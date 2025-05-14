<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\PenilaianAdmin;
use App\Models\SubKriteria;
use Illuminate\Http\Request;

class PenilaianAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gurus = Guru::whereHas('user', function($query){
            $query->withoutRole('KepalaSekolah');
        })
            ->with(['user', 'perhitungan.administrasiSubKriteria', 'penilaianAdmin'])->get();
        $subkriteriaAdministrasi = SubKriteria::where('kriteria_id', 2)->get();
        return view('admin.datapenilaian.index', compact('gurus', 'subkriteriaAdministrasi'));
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
            'guru_id' => 'required',
            'administrasi' => 'required|numeric',
            'presensi_realita' => 'required|numeric',
            'sertifikat_pengembangan' => 'required|numeric',
            'kegiatan_sosial' => 'required|numeric',
        ]);

        $guru = Guru::findOrFail($request->guru_id);

        // 1. Simpan dulu input admin ke tabel penilaianadmins
        $penilaianAdmin = PenilaianAdmin::updateOrCreate(
            ['guru_id' => $request->guru_id],
            [
                'administrasi' => $request->administrasi,
                'presensi_realita' => $request->presensi_realita,
                'sertifikat_pengembangan' => $request->sertifikat_pengembangan,
                'kegiatan_sosial' => $request->kegiatan_sosial,
            ]
        );

        // 2. Panggil proses perhitungan
        (new PerhitunganController)->hitung($penilaianAdmin->id);

        return redirect()->back()->with('success', 'Data penilaian berhasil disimpan.');
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
        $request->validate([
            'administrasi' => 'required|numeric',
            'presensi_realita' => 'required|numeric',
            'sertifikat_pengembangan' => 'required|numeric',
            'kegiatan_sosial' => 'required|numeric',
        ]);

        $penilaianAdmin = PenilaianAdmin::findOrFail($id);
        $guru = Guru::findOrFail($request->guru_id);

        if ($guru->jumlah_presensi == 0) {
            return redirect()->back()->withErrors('Jumlah presensi ekspektasi guru tidak boleh 0.');
        }
    
        // 1. Update data penilaian admin
        $penilaianAdmin->update([
            'administrasi' => $request->administrasi,
            'presensi_realita' => $request->presensi_realita,
            'sertifikat_pengembangan' => $request->sertifikat_pengembangan,
            'kegiatan_sosial' => $request->kegiatan_sosial,
        ]);

        // 2. Panggil proses perhitungan
        (new PerhitunganController)->hitung($penilaianAdmin->id);

        return redirect()->back()->with('success', 'Data penilaian berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
