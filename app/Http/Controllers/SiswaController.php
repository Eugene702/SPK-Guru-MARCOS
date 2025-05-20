<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Guru;
use App\Models\PenilaianSiswa;
use App\Models\Perhitungan;

class SiswaController extends Controller
{
    public function index()
    {
        return view('siswa.index');
    }

    public function penilaiansiswa()
    {
        $siswa = auth()->user()->siswa; // asumsi login sebagai siswa
        $kelasId = $siswa->kelas_id;

        // Ambil semua guru yang ngajarnya di kelas siswa
        $gurus = Guru::whereHas('kelas', function ($query) use ($kelasId) {
            $query->where('kelas_id', $kelasId);
            })->get();

        return view('siswa.penilaiansiswa', compact('gurus'));
    }

//     public function storePenilaian(Request $request)
// {
//     $request->validate([
//         'guru_id' => 'required',
//         'jam_masuk' => 'required|integer',
//         'jam_tugas' => 'required|integer',
//         'jam_tidak_masuk' => 'required|integer',
//     ]);

//     $siswa = auth()->user()->siswa;

//     PenilaianSiswa::create([
//         'siswa_id' => $siswa->id,
//         'guru_id' => $request->guru_id,
//         'jam_masuk' => $request->jam_masuk,
//         'jam_tugas' => $request->jam_tugas,
//         'jam_tidak_masuk' => $request->jam_tidak_masuk,
//     ]);

//     // Ambil data guru
//     $guru = Guru::findOrFail($request->guru_id);

//     // Hitung kehadiran di kelas
//     if ($guru->jumlah_jam_mengajar > 0) {
//         $kehadiran_dikelas = ($request->jam_masuk / $guru->jumlah_jam_mengajar) * 100;

//         $perhitungan = Perhitungan::firstOrCreate(['guru_id' => $request->guru_id]);
//         $perhitungan->fill(['kehadiran_dikelas' => $kehadiran_dikelas])->save();

//     }

//     return redirect()->back()->with('success', 'Penilaian berhasil disimpan.');
// }

public function storePenilaian(Request $request)
{
    $request->validate([
        'guru_id' => 'required',
        'jam_masuk' => 'required|integer',
        'jam_tugas' => 'required|integer',
        'jam_tidak_masuk' => 'required|integer',
    ]);

    $siswa = auth()->user()->siswa;

    // Buat Penilaian Siswa
    PenilaianSiswa::create([
        'siswa_id' => $siswa->id,
        'guru_id' => $request->guru_id,
        'jam_masuk' => $request->jam_masuk,
        'jam_tugas' => $request->jam_tugas,
        'jam_tidak_masuk' => $request->jam_tidak_masuk,
    ]);

    $guru = Guru::find($request->guru_id);

    if (!$guru) {
        return back()->with('error', 'Guru tidak ditemukan.');
    }

    if ($guru->jumlah_jam_mengajar > 0) {
        $kehadiran_dikelas = ($request->jam_masuk / $guru->jumlah_jam_mengajar) * 100;
        $value = $kehadiran_dikelas >= 90 ? 4 : ($kehadiran_dikelas >= 80 ? 3 : ($kehadiran_dikelas >= 70 ? 2 : 1));

        // DEBUG LOG
        \Log::info('Nilai Kehadiran Dihitung:', [
            'guru_id' => $guru->id,
            'jumlah_jam_mengajar' => $guru->jumlah_jam_mengajar,
            'jam_masuk' => $request->jam_masuk,
            'kehadiran_dikelas' => $kehadiran_dikelas,
        ]);

        $perhitungan = Perhitungan::firstOrCreate(
            ['guru_id' => $guru->id],
            []
        );

        $perhitungan->update([
            'kehadiran_dikelas' => $value,
        ]);
    } else {
        return back()->with('error', 'Jumlah jam mengajar guru tidak valid.');
    }

    return redirect()->back()->with('success', 'Penilaian berhasil disimpan.');
}


public function updatePenilaian(Request $request, $id)
{
    $request->validate([
        'jam_masuk' => 'required|integer',
        'jam_tugas' => 'required|integer',
        'jam_tidak_masuk' => 'required|integer',
    ]);

    // Cari data penilaian yang mau diupdate
    $penilaian = PenilaianSiswa::findOrFail($id);

    // Update nilai jam masuk, tugas, tidak masuk
    $penilaian->update([
        'jam_masuk' => $request->jam_masuk,
        'jam_tugas' => $request->jam_tugas,
        'jam_tidak_masuk' => $request->jam_tidak_masuk,
    ]);

    // Ambil data guru terkait
    $guru = Guru::findOrFail($penilaian->guru_id);

    // Hitung kehadiran di kelas ulang
    if ($guru->jumlah_jam_mengajar > 0) {
        $kehadiran_dikelas = ($request->jam_masuk / $guru->jumlah_jam_mengajar) * 100;
        $value = $kehadiran_dikelas >= 90 ? 4 : ($kehadiran_dikelas >= 80 ? 3 : ($kehadiran_dikelas >= 70 ? 2 : 1));

        // Update ke tabel perhitungans
        $perhitungan = Perhitungan::firstOrCreate(['guru_id' => $request->guru_id]);
        $perhitungan->fill(['kehadiran_dikelas' => $value])->save();

    }

    return redirect()->back()->with('success', 'Penilaian berhasil diperbarui.');
}

}
