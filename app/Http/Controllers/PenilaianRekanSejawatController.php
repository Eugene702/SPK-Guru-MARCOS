<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\PernyataanRekanSejawat;
use App\Models\PenilaianOlehRekanSejawat;
use App\Models\PenilaianRekanDetail;
use App\Models\Perhitungan;
use Illuminate\Http\Request;

class PenilaianRekanSejawatController extends Controller
{
    public function dashboard()
    {
        return view('guru.index'); // Halaman dashboard guru
    }
    public function index()
    {
        $gurus = Guru::where('id', '!=', auth()->user()->guru->id)
            ->whereHas('user', function($query){
                $query->whereHas('roles', function($query){
                    $query->where('name', '=', 'Guru');
                });
            })
            ->get();

        return view('guru.penilaian.index', compact('gurus'));
    }

    public function form($guruId)
    {
        $penilaiId = auth()->user()->guru->id;

        $guru = Guru::findOrFail($guruId);
        $pernyataan = PernyataanRekanSejawat::all();

        $penilaian = PenilaianOlehRekanSejawat::where('penilai_id', $penilaiId)
            ->where('guru_id', $guruId)
            ->whereYear('created_at', now()->year)
            ->first();

        $nilaiSebelumnya = [];

        if ($penilaian) {
            $nilaiSebelumnya = PenilaianRekanDetail::where('penilaian_id', $penilaian->id)
                ->pluck('nilai', 'pernyataan_id')
                ->toArray();
        }

        return view('guru.penilaian.form', compact('guru', 'pernyataan', 'nilaiSebelumnya'));
    }


    public function updateRataRataRekanSejawat($guruId)
    {
        $nilaiAkhirList = PenilaianOlehRekanSejawat::where('guru_id', $guruId)
            ->whereYear('created_at', now()->year)
            ->pluck('nilai_akhir');

        if ($nilaiAkhirList->count() >= 1) {
            $rataRata = $nilaiAkhirList->avg();
            $calculate = Perhitungan::where('guru_id', '=', $guruId)
                ->whereYear('created_at', now()->year);
            if($calculate->exists()){
                $calculate->first()->update([
                    'rekan_sejawat' => $rataRata
                ]);
            } else {
                Perhitungan::create([
                    'guru_id' => $guruId,
                    'rekan_sejawat' => $rataRata
                ]);
            }
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'guru_id' => 'required|exists:guru,id',
            'nilai' => 'required|array',
            'nilai.*' => 'in:0,1,2',
        ]);

        $penilaiId = auth()->user()->guru->id;

        $penilaian = PenilaianOlehRekanSejawat::where('penilai_id', $penilaiId)
            ->where('guru_id', $request->guru_id)
            ->whereYear('created_at', now()->year)
            ->first();

        if (!$penilaian) {
            $penilaian = PenilaianOlehRekanSejawat::create([
                'penilai_id' => $penilaiId,
                'guru_id' => $request->guru_id,
            ]);
        }

        // Hapus detail lama jika ada
        PenilaianRekanDetail::where('penilaian_id', $penilaian->id)->whereYear('created_at', now()->year)->delete();

        $total = 0;
        foreach ($request->nilai as $pernyataanId => $skor) {
            PenilaianRekanDetail::create([
                'penilaian_id' => $penilaian->id,
                'pernyataan_id' => $pernyataanId,
                'nilai' => $skor,
            ]);
            $total += $skor;
        }

        $maks = count($request->nilai) * 2;
        $nilaiAkhir = ($total / $maks) * 100;

        $penilaian->update(['nilai_akhir' => $nilaiAkhir]);

        $this->updateRataRataRekanSejawat($request->guru_id);

        return redirect()->route('guru.penilaian.index')->with('success', 'Penilaian berhasil disimpan');
    }
}
