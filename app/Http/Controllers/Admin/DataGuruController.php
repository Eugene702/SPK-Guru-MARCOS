<?php

namespace App\Http\Controllers\Admin;

use App\Models\Guru;
use App\Http\Controllers\Controller;
use App\Models\GuruKelas;
use App\Models\GuruMataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $opsiKelas = Kelas::all();
        $mataPelajarans = MataPelajaran::all(); // jangan dari Guru::with(), cukup ambil semua
        $gurus = Guru::with(['user', 'kelas', 'mataPelajarans'])->get();
        return view('admin.dataguru.index', compact('gurus', 'roles', 'opsiKelas', 'mataPelajarans'));
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
        $user = $guru->user;

        // $request->validate([
        //     'nip' => 'required|unique:gurus,nip,' . $guru->id,
        //     'nama' => 'required',
        //     'jabatan' => 'required',
        //     'mata_pelajaran' => 'required',
        //     'jumlah_jam_mengajar' => 'required|numeric',
        //     'jumlah_presensi' => 'required|numeric',
        //     'email' => 'required|email|unique:users,email,' . $user->id,
        //     'kelas_id' => 'required|exists:kelas,id',
        //     'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
        // ]);

        DB::transaction(function () use ($request, $id, $user) {
            Guru::where('id', '=', $id)->update([
                'nip' => $request->nip,
                'jabatan' => $request->jabatan,
                'jumlah_jam_mengajar' => $request->jumlah_jam_mengajar,
                'jumlah_presensi' => $request->jumlah_presensi,
            ]);

            GuruKelas::where('guru_id', '=', $id)->delete();
            GuruMataPelajaran::where('guru_id', '=', $id)->delete();

            foreach ($request->kelas as $row) {
                GuruKelas::create([
                    'guru_id' => $id,
                    'kelas_id' => $row,
                ]);
            }

            foreach ($request->mata_pelajaran as $row) {
                GuruMataPelajaran::create([
                    'guru_id' => $id,
                    'mata_pelajaran_id' => $row,
                ]);
            }

            User::where('id', '=', $user->id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password ? Hash::make($request->password) : $user->password,
            ]);
        });

        return redirect()->route('admin.dataguru.index')->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $guru = Guru::findOrFail($id);
        $guru->delete();

        return redirect()->route('admin.dataguru.index')->with('success', 'Data guru berhasil dihapus.');
    }
}
