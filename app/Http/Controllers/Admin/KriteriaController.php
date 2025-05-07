<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kriterias = \App\Models\Kriteria::all();
        return view('admin.datakriteria', compact('kriterias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kriteria.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_kriteria' => 'required|unique:kriterias,kode_kriteria',
            'nama_kriteria' => 'required',
            'bobot' => 'required|integer',
            'jenis' => 'required|in:Benefit,Cost',
        ]);

        Kriteria::create($request->all());

        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil ditambahkan');
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
    public function edit(Kriteria $kriterium)
    {
        return view('kriteria.edit', ['kriteria' => $kriterium]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kriteria $kriterium)
    {
        $request->validate([
            'kode_kriteria' => 'required|unique:kriterias,kode_kriteria,' . $kriterium->id,
            'nama_kriteria' => 'required',
            'bobot' => 'required|integer',
            'jenis' => 'required|in:Benefit,Cost',
        ]);

        $kriterium->update($request->all());

        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kriteria $kriterium)
    {
        $kriterium->delete();
        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil dihapus');
    }
}
