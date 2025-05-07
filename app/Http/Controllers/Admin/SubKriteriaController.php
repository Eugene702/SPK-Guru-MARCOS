<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use Illuminate\Http\Request;

class SubKriteriaController extends Controller
{
    public function index()
    {
        $kriterias = Kriteria::with('subKriterias')->get();
        return view('admin.datasubkriteria', compact('kriterias'));

    }

    public function create()
    {
        $kriterias = Kriteria::all();
        return view('admin.datasubkriteria.create', compact('kriterias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kriteria_id' => 'required|exists:kriterias,id',
            'nama_sub_kriteria' => 'required',
            'bobot_sub_kriteria' => 'required|integer',
        ]);

        SubKriteria::create($request->all());
        return redirect()->route('admin.datasubkriteria.index')->with('success', 'Sub Kriteria berhasil ditambahkan');
    }

    public function edit(SubKriteria $subkriterium)
    {
        $kriterias = Kriteria::all();
        return view('admin.datasubkriteria.edit', compact('subkriterium', 'kriterias'));
    }

    public function update(Request $request, SubKriteria $subkriterium)
    {
        $request->validate([
            'kriteria_id' => 'required|exists:kriterias,id',
            'nama_sub_kriteria' => 'required',
            'bobot_sub_kriteria' => 'required|integer',
        ]);

        $subkriterium->update($request->all());
        return redirect()->route('admin.datasubkriteria.index')->with('success', 'Sub Kriteria berhasil diupdate');
    }

    public function destroy(SubKriteria $subkriterium)
    {
        $subkriterium->delete();
        return redirect()->route('admin.datasubkriteria.index')->with('success', 'Sub Kriteria berhasil dihapus');
    }
}
