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
    public function index(Request $request)
    {
        Perhitungan::whereHas('guru', function ($query) {
            $query->where('jabatan', 'Kepala Sekolah');
        })->delete();

        $data = null;
        if ($request->has('year') && trim($request->year) != "") {
            $data = Perhitungan::whereHas('guru', function ($query) {
                $query->where('jabatan', '=', 'Guru');
            })
                ->whereYear('created_at', $request->year)
                ->with('guru.user')
                ->get();
        }

        $year = Perhitungan::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->get();
        $calculateReportService = app(\App\Services\CalculateReportService::class);
        return view('admin.dataperhitungan', array_merge($calculateReportService->calculate($data), ['year' => $year]));
    }
    public function hitung($penilaianAdmin)
    {
        if (!$penilaianAdmin) {
            return back()->with('error', 'Data Penilaian Admin tidak ditemukan');
        }

        $guru = Guru::find($penilaianAdmin->guru_id);
        if (!$guru) {
            return back()->with('error', 'Data guru tidak ditemukan');
        }

        if ($guru->jabatan === 'Kepala Sekolah') {
            return back()->with('error', 'Kepala Sekolah tidak perlu dinilai');
        }

        $penilaianSiswa = PenilaianSiswa::where('guru_id', $guru->id)->first();
        $nilaiPresensi = ($penilaianAdmin->presensi_realita / $guru->presensi_ekspektasi) * 100;
        if ($nilaiPresensi >= 90 && $nilaiPresensi <= 100) {
            $skorPresensi = 4;
        } elseif ($nilaiPresensi >= 80 && $nilaiPresensi < 90) {
            $skorPresensi = 3;
        } elseif ($nilaiPresensi >= 70 && $nilaiPresensi < 80) {
            $skorPresensi = 2;
        } else {
            $skorPresensi = 1;
        }

        $kehadiran_dikelas = $penilaianSiswa ? ($penilaianSiswa->jam_masuk / $guru->jam_mengajar_ekspektasi) * 100 : 0;
        if ($kehadiran_dikelas >= 90 && $kehadiran_dikelas <= 100) {
            $skorKehadiran = 4;
        } elseif ($kehadiran_dikelas >= 80 && $kehadiran_dikelas < 90) {
            $skorKehadiran = 3;
        } elseif ($kehadiran_dikelas >= 70 && $kehadiran_dikelas < 80) {
            $skorKehadiran = 2;
        } else {
            $skorKehadiran = 1;
        }

        $calculate = Perhitungan::where('guru_id', '=', $guru->id)
            ->whereYear('created_at', now()->year);

        if ($calculate->exists()) {
            $calculate->first()->update([
                'administrasi' => $penilaianAdmin->administrasi,
                'presensi' => $skorPresensi,
                'kehadiran_dikelas' => $skorKehadiran,
                'sertifikat_pengembangan' => $penilaianAdmin->sertifikat_pengembangan,
                'kegiatan_sosial' => $penilaianAdmin->kegiatan_sosial,
            ]);
        } else {
            Perhitungan::create([
                'guru_id' => $guru->id,
                'administrasi' => $penilaianAdmin->administrasi,
                'presensi' => $skorPresensi,
                'kehadiran_dikelas' => $skorKehadiran,
                'sertifikat_pengembangan' => $penilaianAdmin->sertifikat_pengembangan,
                'kegiatan_sosial' => $penilaianAdmin->kegiatan_sosial,
            ]);
        }
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
