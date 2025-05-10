<?php
namespace App\Services;

use App\Models\Perhitungan;

class CalculateReportService
{
    public function calculate()
    {
        $calculation = Perhitungan::whereHas('guru', function ($query) {
            $query->where('jabatan', '=', 'Guru');
        })
            ->with('guru.user', 'administrasiSubKriteria')
            ->get();

        $scoreWeights = [
            'supervisi' => 0.18,
            'administrasi' => 0.15,
            'presensi' => 0.17,
            'kehadiran_dikelas' => 0.15,
            'sertifikat_pengembangan' => 0.12,
            'kegiatan_sosial' => 0.13,
            'rekan_sejawat' => 0.10,
        ];

        $data = $calculation->map(function ($item) {
            return [
                'guru_id' => $item->guru_id,
                'nama' => $item->guru->user->name ?? 'Nama tidak tersedia',
                'supervisi' => $item->supervisi,
                'administrasi' => $item->administrasiSubKriteria->bobot_sub_kriteria === 4 ? "Lengkap" : ($item->administrasiSubKriteria->bobot_sub_kriteria === 3 ? "Cukup" : "Kurang"),
                'presensi' => $item->presensi,
                'kehadiran_dikelas' => $item->kehadiran_dikelas,
                'sertifikat_pengembangan' => $item->sertifikat_pengembangan,
                'kegiatan_sosial' => $item->kegiatan_sosial,
                'rekan_sejawat' => $item->rekan_sejawat,
            ];
        });
        dd($data);

        $liguistics = $calculation->map(function ($item) {
            return [
                'guru_id' => $item->guru_id,
                'nama' => $item->guru->user->name ?? 'Nama tidak tersedia',
                'supervisi' => $item->supervisi,
                'administrasi' => $item->administrasiSubKriteria->bobot_sub_kriteria ?? 0,
                'presensi' => $item->presensi,
                'kehadiran_dikelas' => $item->kehadiran_dikelas,
                'sertifikat_pengembangan' => $item->sertifikat_pengembangan,
                'kegiatan_sosial' => $item->kegiatan_sosial,
                'rekan_sejawat' => $item->rekan_sejawat,
            ];
        });
    }
}