<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\DataGuru\StoreRequest;
use App\Http\Requests\Admin\DataGuru\UpdateRequest;
use App\Models\Guru;
use App\Http\Controllers\Controller;
use App\Models\GuruKelas;
use App\Models\GuruMataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Models\MataPelajaran;
use App\Models\Kelas;

class DataGuruController extends Controller
{
    public function index()
    {
        $roles = Role::all(); // Ambil semua role
        $opsiKelas = Kelas::all();
        $mataPelajarans = MataPelajaran::all(); // jangan dari Guru::with(), cukup ambil semua
        $gurus = Guru::with(['user.roles', 'kelas', 'mataPelajarans'])->get();
        return view('admin.dataguru.index', compact('gurus', 'roles', 'opsiKelas', 'mataPelajarans'));
    }

    public function storeguru(StoreRequest $request)
    {
        DB::transaction(function() use($request){
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
    
            $user->assignRole($request->role);
            $guru = Guru::create([
                'nip' => $request->nip,
                'jabatan' => $request->jabatan,
                'jumlah_jam_mengajar' => $request->role === 'Guru' ? $request->jumlah_jam_mengajar : 0,
                'jumlah_presensi' => $request->role === 'Guru' ? $request->jumlah_presensi : 0,
                'user_id' => $user->id
    
            ]);
    
            if($request->role === "Guru"){
                $guru->kelas()->sync($request->kelas);
                $guru->mataPelajarans()->sync($request->mata_pelajaran);
            }
        });

        return redirect()->route('admin.dataguru.index')->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function update(UpdateRequest $request, $id)
    {
        $guru = Guru::findOrFail($id);
        if (!$guru->user) {
            return redirect()->back()->with('error', 'User terkait guru ini tidak ditemukan.');
        }

        $user = $guru->user;
        DB::transaction(function () use ($request, $id, $user) {
            Guru::where('id', '=', $id)->update([
                'nip' => $request->nip,
                'jabatan' => $request->jabatan,
                'jumlah_jam_mengajar' => $request->role === 'Guru' ? $request->jumlah_jam_mengajar : 0,
                'jumlah_presensi' => $request->role === 'Guru' ? $request->jumlah_presensi : 0,
            ]);

            GuruKelas::where('guru_id', '=', $id)->delete();
            GuruMataPelajaran::where('guru_id', '=', $id)->delete();
            if($request->role === "Guru"){
    
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
