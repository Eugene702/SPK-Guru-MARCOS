<?php

namespace App\Http\Controllers\Admin;

use App\Exports\Student\MasterExport;
use App\Http\Requests\Admin\Student\ImportRequest;
use App\Http\Requests\Admin\Student\StoreRequest;
use App\Imports\Student\MasterImport;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use Spatie\Permission\Models\Role;

class DataSiswaController extends Controller
{
    public function index()
    {
        $siswas = Siswa::with(['kelas', 'user'])->get(); // Load relasi kelas dan user
        $kelass = Kelas::with('siswas:id,kelas_id')->get();
        return view('admin.datasiswa.index', compact('siswas', 'kelass'));
    }

    public function store(StoreRequest $request)
    {
        DB::transaction(function() use($request){
            $role = Role::firstOrCreate(['name' => 'Siswa']);
            $user = User::create([
                'name' => $request->nama_siswa,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
    
            $user->assignRole($role);
            $user->siswa()->create([
                'kelas_id' => $request->kelas_id,
            ]);
        });

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

        return redirect()->route('admin.datasiswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        try {
            User::whereHas('siswa', function ($query) use ($id) {
                $query->where('id', '=', $id);
            })->delete();

            return redirect()->route('admin.datasiswa.index')->with('success', 'Data siswa berhasil dihapus.');
        } catch (\Exception $e) {
            if (config('app.debug')) {
                dd($e);
            }

            return redirect()->back()->with('error', 'Gagal menghapus data siswa.');
        }
    }

    public function export()
    {
        try {
            return Excel::download(new MasterExport, 'Template Data Siswa.xlsx');
        } catch (\Exception $e) {
            if (config('app.debug')) {
                dd($e);
            }

            return redirect()->back()->with('error', 'Gagal mengunduh data siswa.');
        }
    }

    public function import(ImportRequest $request)
    {
        try {
            $file = Excel::toCollection(new MasterImport, $request->file('document')->getRealPath());
            $class = Kelas::select('id')->whereDoesntHave('siswas')->pluck('id')->toArray();
            $validator = Validator::make($file['User Info']->toArray(), [
                '*.nama' => ['required'],
                '*.email' => ['required', 'email', 'unique:users,email'],
                '*.kata_sandi' => ['required', 'min:8'],
                '*.kelas' => ['required', 'in:' . implode(',', $class)],
            ], [
                'required' => 'Kolom :attribute tidak boleh kosong.',
                'email' => 'Format email :input tidak valid.',
                'unique' => 'Email :input sudah terdaftar.',
                'min' => 'Password minimal :min karakter.',
                'in' => 'Kelas tidak valid.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', implode('<br />', $validator->errors()->all()));
            }

            DB::transaction(function () use ($file) {
                foreach ($file['User Info'] as $row) {
                    User::create([
                        'name' => $row['nama'],
                        'email' => $row['email'],
                        'password' => Hash::make($row['kata_sandi']),
                    ])->assignRole('Siswa')
                        ->siswa()->create([
                                'kelas_id' => $row['kelas'],
                            ]);
                }
            });

            return redirect()->back()->with('success', 'Data siswa berhasil diunggah.');
        } catch (\Exception $e) {
            if (config('app.debug')) {
                dd($e);
            }

            return redirect()->back()->with('error', 'Gagal mengunggah data siswa.');
        }
    }
}
