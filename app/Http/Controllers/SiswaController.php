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
        })
        ->withCount('kelas')
        ->get();

        return view('siswa.penilaiansiswa', compact('gurus'));
    }

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
            'jam_mengajar_realita' => $request->jam_masuk,
            'jam_tugas' => $request->jam_tugas,
            'jam_tidak_masuk' => $request->jam_tidak_masuk,
        ]);

        $guru = Guru::find($request->guru_id);

        if (!$guru) {
            return back()->with('error', 'Guru tidak ditemukan.');
        }

        if ($guru->jam_mengajar_ekspektasi > 0) {
            $penilaianSiswa = PenilaianSiswa::where('guru_id', "=", $guru->id)->sum('jam_mengajar_realita');
            $kehadiran_dikelas = (($request->jam_masuk + $penilaianSiswa) / $guru->jam_mengajar_ekspektasi) * 100;
            $value = $kehadiran_dikelas >= 90 ? 4 : ($kehadiran_dikelas >= 80 ? 3 : ($kehadiran_dikelas >= 70 ? 2 : 1));

            $perhitungan = Perhitungan::where('guru_id', '=', $guru->id)
                ->whereYear('created_at', now()->year);
            
            if($perhitungan->exists()){
                $perhitungan->first()->update([
                    'kehadiran_dikelas' => $value,
                ]);
            } else {
                Perhitungan::create([
                    'guru_id' => $guru->id,
                    'kehadiran_dikelas' => $value,
                ]);
            }
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

        $penilaian = PenilaianSiswa::findOrFail($id);
        $penilaian->update([
            'jam_mengajar_realita' => $request->jam_masuk,
            'jam_tugas' => $request->jam_tugas,
            'jam_tidak_masuk' => $request->jam_tidak_masuk,
        ]);

        // Ambil data guru terkait
        $guru = Guru::findOrFail($penilaian->guru_id);

        // Hitung kehadiran di kelas ulang
        if ($guru->jam_mengajar_ekspektasi > 0) {
            $penilaianSiswa = PenilaianSiswa::where('guru_id', "=", $guru->id)->sum('jam_mengajar_realita');
            $kehadiran_dikelas = ($penilaianSiswa / $guru->jam_mengajar_ekspektasi) * 100;
            $value = $kehadiran_dikelas >= 90 ? 4 : ($kehadiran_dikelas >= 80 ? 3 : ($kehadiran_dikelas >= 70 ? 2 : 1));

            // Update ke tabel perhitungans
            $perhitungan = Perhitungan::firstOrCreate(['guru_id' => $request->guru_id]);
            $perhitungan->fill(['kehadiran_dikelas' => $value])->save();

        }

        return redirect()->back()->with('success', 'Penilaian berhasil diperbarui.');
    }

}
