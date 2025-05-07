<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Perhitungan;
use App\Models\Guru;
use App\Models\SubKriteria;
use App\Models\Kriteria;
use App\Models\PenilaianAdmin;
use App\Models\PenilaianSiswa;
use Illuminate\Http\Request;
use App\Models\PenilaianOlehKepalaSekolah;
use App\Models\PenilaianOlehRekanSejawat;

class PerhitunganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Perhitungan::whereHas('guru', function ($query) {
            $query->where('jabatan', 'Kepala Sekolah');
        })->delete();

        // Ambil semua data perhitungan yang tidak memiliki guru dengan jabatan 'Kepala Sekolah'        
        $perhitungans = Perhitungan::with(['guru.user', 'administrasiSubKriteria'])
        ->whereHas('guru', function ($query) {
        $query->where('jabatan', '!=', 'Kepala Sekolah'); // sesuaikan nama kolom dan nilainya
        })
        ->get();


        return $this->prosesMarcos();

        
    
        return view('admin.dataperhitungan', compact('perhitungans'));
    }

    public function prosesMarcos()
    {
        $perhitungans = Perhitungan::with('guru.user')->get();
        $kriterias = Kriteria::pluck('bobot_kriteria', 'nama_kriteria')->toArray();
    
        // Inisialisasi matriks keputusan
        $matriks = [];
        foreach ($perhitungans as $perhitungan) {
            $matriks[] = [
                'guru_id' => $perhitungan->guru_id,
                'nama' => $perhitungan->guru->user->name ?? 'Nama tidak tersedia',
                'supervisi' => $perhitungan->supervisi,
                'administrasi' => $perhitungan->administrasiSubKriteria->bobot_sub_kriteria ?? 0,
                'presensi' => $perhitungan->presensi,
                'kehadiran_dikelas' => $perhitungan->kehadiran_dikelas,
                'sertifikat_pengembangan' => $perhitungan->sertifikat_pengembangan,
                'kegiatan_sosial' => $perhitungan->kegiatan_sosial,
                'rekan_sejawat' => $perhitungan->rekan_sejawat,
            ];
        }
    
        $kriteria_keys = [ 'supervisi', 'administrasi', 'presensi', 'kehadiran_dikelas', 'sertifikat_pengembangan', 'kegiatan_sosial', 'rekan_sejawat'];
        
        // Ideal dan Anti-Ideal
        $ideal = [];
        $anti_ideal = [];
        foreach ($kriteria_keys as $key) {
            $nilai_kriteria = array_column($matriks, $key);
            $ideal[$key] = max($nilai_kriteria);
            $anti_ideal[$key] = min($nilai_kriteria);
        }
    
        // Normalisasi matriks
        $normalisasi = [];
        foreach ($matriks as $data) {
            $row = ['guru_id' => $data['guru_id'], 'nama' => $data['nama']];
            foreach ($kriteria_keys as $key) {
                $row[$key] = $data[$key] / ($ideal[$key] ?: 1); // Hindari pembagian nol
            }
            $normalisasi[] = $row;
        }
    
        // Pembobotan matriks
        $pembobotan = [];
        foreach ($normalisasi as $data) {
            $row = ['guru_id' => $data['guru_id'], 'nama' => $data['nama']];
            foreach ($kriteria_keys as $key) {
                // $row[$key] = $data[$key] * $kriterias[$key];
            }
            $pembobotan[] = $row;
        }
    
        // Hitung Si, Ki, dan f(Ki)
        $si_values = [];
        foreach ($pembobotan as $data) {
            $si = array_sum(array_intersect_key($data, array_flip($kriteria_keys)));
            $si_values[] = $si;
        }
    
        $si_ideal = max($si_values);
        $si_anti_ideal = min($si_values);
    
        $hasil = [];
        foreach ($pembobotan as $index => $data) {
            $si = $si_values[$index];
            $ki_plus = $si / ($si_ideal ?: 1);
            $ki_minus = $si / ($si_anti_ideal ?: 1);
            $f_ki = ($ki_plus + $ki_minus) / (1 + ((1 - $ki_plus) / ($ki_plus ?: 1)) + ((1 - $ki_minus) / ($ki_minus ?: 1)));
            $hasil[] = [
                'guru_id' => $data['guru_id'],
                'nama' => $data['nama'],
                'si' => $si,
                'ki_plus' => $ki_plus,
                'ki_minus' => $ki_minus,
                'f_ki' => $f_ki,
            ];
        }
    
        // Peringkat
        usort($hasil, fn($a, $b) => $b['f_ki'] <=> $a['f_ki']);
        foreach ($hasil as $index => &$data) {
            $data['ranking'] = $index + 1;
        }
    
        // Kirim semua data tahapan ke view
        return view('admin.dataperhitungan', compact(
            'perhitungans',         // Jika masih ingin pakai untuk data awal
            'matriks',              // Matriks keputusan
            'ideal',                // Nilai ideal
            'anti_ideal',           // Nilai anti-ideal
            'normalisasi',          // Matriks normalisasi
            'pembobotan',           // Matriks berbobot
            'si_values',            // Nilai Si
            'si_ideal',             // Si ideal
            'si_anti_ideal',        // Si anti-ideal
            'hasil',                 // Hasil akhir termasuk f_ki & ranking
            'kriteria_keys'
        ));
    }

    public function hitung($penilaianadmin_id)
    {
        $penilaianAdmin = PenilaianAdmin::find($penilaianadmin_id);
        if (!$penilaianAdmin) {
            return back()->with('error', 'Data Penilaian Admin tidak ditemukan');
        }

        $guru = Guru::find($penilaianAdmin->guru_id);
        if (!$guru) {
            return back()->with('error', 'Data guru tidak ditemukan');
        }

            // Tambahkan pengecekan jabatan guru
        if ($guru->jabatan === 'Kepala Sekolah') {
            return back()->with('error', 'Kepala Sekolah tidak perlu dinilai');
        }

        $penilaianSiswa = PenilaianSiswa::where('guru_id', $guru->id)->first();
        if (!$penilaianSiswa) {
            return back()->with('error', 'Penilaian siswa belum ada');
        }

        $nilaiKepsek = PenilaianOlehKepalaSekolah::where('guru_id', $guru->id)->value('nilai_akhir');
        if (is_null($nilaiKepsek)) {
            return back()->with('error', 'Nilai akhir dari kepala sekolah belum ada');
        }

        // // Contoh: hitung nilai presensi final
        $nilaiPresensi = ($penilaianAdmin->presensi_realita / $guru->jumlah_presensi) * 100;
        if ($nilaiPresensi >= 90 && $nilaiPresensi <= 100) {
            $skorPresensi = 4;
        } elseif ($nilaiPresensi >= 80 && $nilaiPresensi < 90) {
            $skorPresensi = 3;
        } elseif ($nilaiPresensi >= 70 && $nilaiPresensi < 80) {
            $skorPresensi = 2;
        } else {
            $skorPresensi = 1;
        }
        $kehadiran_dikelas = ($penilaianSiswa->jam_masuk / $guru->jumlah_jam_mengajar) * 100;
        if ($kehadiran_dikelas >= 90 && $kehadiran_dikelas <= 100) {
            $skorKehadiran = 4;
        } elseif ($kehadiran_dikelas >= 80 && $kehadiran_dikelas < 90) {
            $skorKehadiran = 3;
        } elseif ($kehadiran_dikelas >= 70 && $kehadiran_dikelas < 80) {
            $skorKehadiran = 2;
        } else {
            $skorKehadiran = 1;
        }

        Perhitungan::updateOrCreate(
            ['guru_id' => $guru->id],
            [
                'supervisi' => $nilaiKepsek,
                'administrasi' => $penilaianAdmin->administrasi,
                'presensi' => $skorPresensi,
                'kehadiran_dikelas' => $skorKehadiran,
                'sertifikat_pengembangan' => $penilaianAdmin->sertifikat_pengembangan,
                'kegiatan_sosial' => $penilaianAdmin->kegiatan_sosial,
                'rekan_sejawat' => null,
            ]
        );
    }

    public function updateRataRataRekanSejawat($guruId)
    {
        // Ambil semua nilai_akhir dari semua penilai untuk guru ini
        $nilaiAkhirList = PenilaianOlehRekanSejawat::where('guru_id', $guruId)
                            ->pluck('nilai_akhir');

        if ($nilaiAkhirList->count() >= 1) {
            $rataRata = $nilaiAkhirList->avg();

            // Update ke perhitungan
            Perhitungan::updateOrCreate(
                ['guru_id' => $guruId],
                ['rekan_sejawat' => $rataRata]
            );
        }
    }

 

}
