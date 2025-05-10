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
        // $perhitungans = Perhitungan::with(['guru.user', 'administrasiSubKriteria'])
        //     ->whereHas('guru', function ($query) {
        //         $query->where('jabatan', '!=', 'Kepala Sekolah'); // sesuaikan nama kolom dan nilainya
        //     })
        //     ->get();

        $calculateReportService = app(\App\Services\CalculateReportService::class);
        return view('admin.dataperhitungan', $calculateReportService->calculate());
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
