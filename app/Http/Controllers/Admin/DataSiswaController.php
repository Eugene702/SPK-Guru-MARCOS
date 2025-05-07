<?php

namespace App\Http\Controllers\Admin;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DataSiswaController extends Controller
{
    public function index()
    {
        $siswas = Siswa::with(['kelas', 'user'])->get(); // Load relasi kelas dan user
        $kelass = Kelas::all(); // Ambil semua kelas untuk dropdown
        return view('admin.datasiswa.index', compact('siswas', 'kelass'));
    }

    public function store(Request $request)
{

    // dd($request->all());
    $request->validate([
        'nama_siswa' => 'required',
        'kelas_id' => 'required|exists:kelas,id',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
    ]);

    // Buat user baru
    $user = User::create([
        'name' => $request->nama_siswa,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    $user->assignRole('Siswa');

    // Buat siswa dan hubungkan dengan user dan kelas
    Siswa::create([
        'user_id' => $user->id,
        'kelas_id' => $request->kelas_id,
    ]);

        return redirect()->route('admin.datasiswa.index')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::with('user')->findOrFail($id); // ambil juga usernya
        $user = $siswa->user; // Ambil user terkait

        // Validasi
        $request->validate([
            'nama_siswa' => 'required|string|max:255',
            'kelas_id' => 'required|exists:kelas,id',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
        ]);
        $siswa->update([
            'kelas_id' => $request->kelas_id,
            // 'email' => $request->email,
            // 'password' => $request->password ? Hash::make($request->password) : $siswa->password,
        ]);

        // Update User
        $user->name = $request->nama_siswa;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()->route('admin.datasiswa.index')->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();

        return redirect()->route('admin.datasiswa.index')->with('success', 'Data siswa berhasil dihapus.');
    }
}
