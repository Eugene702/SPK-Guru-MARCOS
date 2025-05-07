<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\PernyataanKepalaSekolah;
use App\Models\PenilaianOlehKepalaSekolah;
use App\Models\PenilaianKepsekDetail;
use App\Models\Perhitungan;
use Illuminate\Http\Request;

class PenilaianKepsekController extends Controller
{

    public function dashboard()
    {
        return view('kepsek.index'); // Halaman dashboard kepala sekolah
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gurus = Guru::where('jabatan', 'guru')->get(); // hanya guru yang bisa dinilai
        return view('kepsek.penilaian.index', compact('gurus'));
    }

    public function form($guru_id)
    {
        $pernyataan = PernyataanKepalaSekolah::all();
        $guru = Guru::findOrFail($guru_id);

        $kepalaSekolah = auth()->user()->guru;

        $penilaian = PenilaianOlehKepalaSekolah::where('guru_id', $guru_id)
            ->where('kepala_sekolah_id', $kepalaSekolah->id)
            ->first();

        $nilaiSebelumnya = [];

        if ($penilaian) {
            $detail = PenilaianKepsekDetail::where('penilaian_id', $penilaian->id)->get();
            foreach ($detail as $item) {
                $nilaiSebelumnya[$item->pernyataan_id] = $item->nilai;
            }
        }

        return view('kepsek.penilaian.form', compact('guru', 'pernyataan', 'nilaiSebelumnya'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'guru_id' => 'required|exists:gurus,id',
            'nilai' => 'required|array',
            'nilai.*' => 'required|integer|min:1|max:4',
        ]);
    
        $kepalaSekolah = auth()->user()->guru;
    
        // Cek apakah penilaian sudah ada
        $penilaian = PenilaianOlehKepalaSekolah::firstOrCreate(
            [
                'guru_id' => $request->guru_id,
                'kepala_sekolah_id' => $kepalaSekolah->id,
            ]
        );
    
        // Hapus detail lama dulu jika sudah ada
        PenilaianKepsekDetail::where('penilaian_id', $penilaian->id)->delete();
    
        $totalNilai = 0;
        $nilai = $request->input('nilai');
        $jumlahPernyataan = count($nilai);
    
        foreach ($nilai as $pernyataan_id => $skor) {
            PenilaianKepsekDetail::create([
                'penilaian_id' => $penilaian->id,
                'pernyataan_id' => $pernyataan_id,
                'nilai' => $skor,
            ]);
            $totalNilai += $skor;
        }
    
        $skorMaksimal = $jumlahPernyataan * 4;
        $nilaiAkhir = ($totalNilai / $skorMaksimal) * 100;
    
        $penilaian->update([
            'nilai_akhir' => $nilaiAkhir,
        ]);

        // 🔥 Tambahkan atau update ke tabel perhitungans
        Perhitungan::updateOrCreate(
        ['guru_id' => $request->guru_id],
        ['supervisi' => $nilaiAkhir]
    );
    
        return redirect()->route('kepsek.penilaian.index')->with('success', 'Penilaian berhasil disimpan');
    }
    

    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
