<?php

namespace App\Http\Controllers\Admin;

use App\Exports\Teacher\MasterExport;
use App\Http\Requests\Admin\DataGuru\StoreRequest;
use App\Http\Requests\Admin\DataGuru\UpdateRequest;
use App\Models\Guru;
use App\Http\Controllers\Controller;
use App\Models\GuruKelas;
use App\Models\GuruMataPelajaran;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;
use App\Models\MataPelajaran;
use App\Models\Kelas;

class DataGuruController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $opsiKelas = Kelas::all();
        $mataPelajarans = MataPelajaran::all();
        $gurus = Guru::with(['user.roles', 'kelas', 'mataPelajarans'])
            ->get()
            ->sortByDesc(function($query){
                return optional($query->user->roles->first())->name == 'KepalaSekolah';
            })
            ->values();
        $attendanceFromFirstData = Guru::select('jumlah_presensi')
            ->whereYear('created_at', date('Y'))
            ->orderByDesc('created_at')
            ->first();
        return view('admin.dataguru.index', compact('gurus', 'roles', 'opsiKelas', 'mataPelajarans', 'attendanceFromFirstData'));
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
                'jam_mengajar_ekspektasi' => $request->role === 'Guru' ? $request->jumlah_jam_mengajar : 0,
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
            $user->syncRoles($request->role);
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
        DB::transaction(function() use($id){
            $guru = Guru::findOrFail($id);
            User::where('id', '=', $guru->user_id)->delete();
            $guru->delete();
        });

        return redirect()->route('admin.dataguru.index')->with('success', 'Data guru berhasil dihapus.');
    }

    public function export(){
        return Excel::download(new MasterExport, 'Template Data Guru.xlsx');
    }
}
