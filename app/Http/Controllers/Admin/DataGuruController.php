<?php

namespace App\Http\Controllers\Admin;

use App\Models\Guru;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\MataPelajaran;
use App\Models\Kelas;

class DataGuruController extends Controller
{
    public function index()
    {
        $roles = Role::all(); // Ambil semua role
        $kelas = Kelas::all();
        $mataPelajarans = MataPelajaran::all(); // jangan dari Guru::with(), cukup ambil semua
        $gurus = Guru::with(['user','kelas', 'mataPelajarans'])->get();
        return view('admin.dataguru.index', compact('gurus', 'roles', 'kelas', 'mataPelajarans'));
    }

    public function storeguru(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'nip' => 'required|unique:gurus',
            'jabatan' => 'required',
            'mata_pelajaran' => 'required',
            'jumlah_jam_mengajar' => 'required',
            'jumlah_presensi' => 'required',
            'role' => 'required',
            'kelas' => 'required|array',
            'kelas.*' => 'exists:kelas,id',
            'mata_pelajaran' => 'required|array',
            'mata_pelajaran.*' => 'exists:mata_pelajarans,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
    
        $user->assignRole($request->role);

        $guru = Guru::create([
            'nip' => $request->nip,
            'jabatan' => $request->jabatan,
            'jumlah_jam_mengajar' => $request->jumlah_jam_mengajar,
            'jumlah_presensi' => $request->jumlah_presensi,
            'user_id' => $user->id, // hubungkan guru dengan user
            
        ]);
        // SIMPAN relasi ke tabel pivot guru_kelas
        $guru->kelas()->sync($request->kelas);
        $guru->mataPelajarans()->sync($request->mata_pelajaran);

        return redirect()->route('admin.dataguru.index')->with('success', 'Data guru berhasil ditambahkan.');

    }

    public function update(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);
        if (!$guru->user) {
            return redirect()->back()->with('error', 'User terkait guru ini tidak ditemukan.');
        }
        $user = $guru->user; // Ambil user terkait

        // Validasi
        $request->validate([
            'nip' => 'required|unique:gurus,nip,' . $guru->id,
            'nama' => 'required',
            'jabatan' => 'required',
            'mata_pelajaran' => 'required',
            'jumlah_jam_mengajar' => 'required|numeric',
            'jumlah_presensi' => 'required|numeric',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'kelas_id' => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
        ]);

        // Update Guru
        $guru->update([
            'nip' => $request->nip,
            'jabatan' => $request->jabatan,
            'mata_pelajaran' => $request->mata_pelajaran,
            'jumlah_jam_mengajar' => $request->jumlah_jam_mengajar,
            'jumlah_presensi' => $request->jumlah_presensi,
        ]);
        // Update relasi ke tabel pivot guru_kelas
        $guru->kelas()->sync($request->kelas);
        $guru->mataPelajaran()->attach($request->mata_pelajaran);

        // Update User
        $user->name = $request->nama;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()->route('admin.dataguru.index')->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $guru = Guru::findOrFail($id);
        $guru->delete();

        return redirect()->route('admin.dataguru.index')->with('success', 'Data guru berhasil dihapus.');
    }
}
