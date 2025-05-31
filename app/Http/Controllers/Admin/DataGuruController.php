<?php

namespace App\Http\Controllers\Admin;

use App\Exports\Teacher\MasterExport;
use App\Http\Requests\Admin\DataGuru\ImportRequest;
use App\Http\Requests\Admin\DataGuru\StoreRequest;
use App\Http\Requests\Admin\DataGuru\UpdateRequest;
use App\Imports\Admin\DataGuru\MasterImport;
use App\Models\Guru;
use App\Http\Controllers\Controller;
use App\Models\GuruKelas;
use App\Models\GuruMataPelajaran;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
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
        $gurus = Guru::select('*', 'presensi_ekspektasi as jumlah_presensi', 'jam_mengajar_ekspektasi as jumlah_jam_mengajar')
            ->with(['user.roles', 'kelas', 'mataPelajarans'])
            ->get()
            ->sortByDesc(function ($query) {
                return optional($query->user->roles->first())->name == 'KepalaSekolah';
            })
            ->values();

        $attendanceFromFirstData = Guru::select('presensi_ekspektasi as jumlah_presensi')
            ->whereYear('created_at', date('Y'))
            ->orderByDesc('created_at')
            ->first();

        return view('admin.dataguru.index', compact('gurus', 'roles', 'opsiKelas', 'mataPelajarans', 'attendanceFromFirstData'));
    }

    public function storeguru(StoreRequest $request)
    {
        DB::transaction(function () use ($request) {
            $role = Role::firstOrCreate(['name' => $request->role]);
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ])->assignRole($role);

            $teacher = $user->guru()->create([
                'nip' => $request->nip,
                'jabatan' => $request->jabatan,
                'jam_mengajar_ekspektasi' => $request->role == 'Guru' ? $request->jumlah_jam_mengajar : 0,
                'presensi_ekspektasi' => $request->role == 'Guru' ? $request->jumlah_presensi : 0,
            ]);

            if ($request->role == "Guru") {
                $teacher->kelas()->sync($request->kelas);
                $teacher->mataPelajarans()->sync($request->mata_pelajaran);
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
                'jam_mengajar_ekspektasi' => $request->role == 'Guru' ? $request->jumlah_jam_mengajar : 0,
                'presensi_ekspektasi' => $request->role == 'Guru' ? $request->jumlah_presensi : 0,
            ]);

            GuruKelas::where('guru_id', '=', $id)->delete();
            GuruMataPelajaran::where('guru_id', '=', $id)->delete();
            if ($request->role === "Guru") {

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
        DB::transaction(function () use ($id) {
            $guru = Guru::find($id);
            if($guru){
                $guru->user()->delete();
                $guru->delete();
            }
        });

        return redirect()->route('admin.dataguru.index')->with('success', 'Data guru berhasil dihapus.');
    }

    public function export()
    {
        return Excel::download(new MasterExport, 'Template Data Guru.xlsx');
    }

    public function import(ImportRequest $request)
    {
        try {
            $file = Excel::toCollection(new MasterImport, $request->file('document'));
            $data = collect($file[0])->map(function ($row) use ($file) {
                return [
                    ...$row,
                    'subject' => $file[1]->where('nip', "=", $row['nip'])->unique('subject_id')->pluck("subject_id")->toArray(),
                    'class' => $file[2]->where('nip', "=", $row['nip'])->unique('class_id')->pluck("class_id")->toArray(),
                ];
            });

            $role = Role::pluck('id')->toArray();
            $validator = Validator::make($data->toArray(), [
                '*.nip' => ['required', 'unique:guru,nip'],
                '*.nama' => ['required'],
                '*.email' => ['required', 'email', 'unique:users,email'],
                '*.jabatan' => ['required', 'in:Kepala Sekolah,Guru'],
                '*.kata_sandi' => ['required', 'min:8'],
                '*.role' => ['required', 'in:' . implode(',', $role)],
                '*.jumlah_jam_mengajar' => ['required', 'integer', 'min:0'],
                '*.jumlah_presensi' => ['required', 'integer', 'min:0'],
                '*.subject' => ['required_if:role,Guru', 'array'],
                '*.subject.*' => ['required_if:role,Guru', 'exists:mata_pelajaran,id'],
                '*.class' => ['required_if:role,Guru', 'array'],
                '*.class.*' => ['required_if:role,Guru', 'exists:kelas,id'],
            ], [
                '*.nip.required' => 'NIP :input tidak boleh kosong.',
                '*.nip.unique' => 'NIP :input sudah terdaftar.',
                '*.nama.required' => 'Nama :input tidak boleh kosong.',
                '*.email.required' => 'Email :input tidak boleh kosong.',
                '*.email.email' => 'Email :input tidak valid.',
                '*.email.unique' => 'Email :input sudah terdaftar.',
                '*.jabatan.required' => 'Jabatan :input tidak boleh kosong.',
                '*.jabatan.in' => 'Jabatan :input tidak valid.',
                '*.kata_sandi.required' => 'Kata sandi :input tidak boleh kosong.',
                '*.kata_sandi.min' => 'Kata sandi :input minimal 8 karakter.',
                '*.role.required' => 'Role :input tidak boleh kosong.',
                '*.role.in' => 'Role :input tidak valid.',
                '*.jumlah_jam_mengajar.required' => 'Jumlah jam mengajar :input tidak boleh kosong.',
                '*.jumlah_jam_mengajar.integer' => 'Jumlah jam mengajar :input harus berupa angka.',
                '*.jumlah_jam_mengajar.min' => 'Jumlah jam mengajar :input tidak boleh kurang dari 0.',
                '*.jumlah_presensi.required' => 'Jumlah presensi :input tidak boleh kosong.',
                '*.jumlah_presensi.integer' => 'Jumlah presensi :input harus berupa angka.',
                '*.jumlah_presensi.min' => 'Jumlah presensi :input tidak boleh kurang dari 0.',
                '*.subject.required' => 'Mata pelajaran :input tidak boleh kosong.',
                '*.subject.array' => 'Mata pelajaran :input harus berupa array.',
                '*.subject.*.required' => 'Mata pelajaran :input tidak boleh kosong.',
                '*.subject.*.exists' => 'Mata pelajaran :input tidak valid.',
                '*.class.required' => 'Kelas :input tidak boleh kosong.',
                '*.class.array' => 'Kelas :input harus berupa array.',
                '*.class.*.required' => 'Kelas :input tidak boleh kosong.',
                '*.class.*.exists' => 'Kelas :input tidak valid.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', implode('<br />', $validator->errors()->all()));
            }

            DB::transaction(function () use ($data) {
                foreach ($data as $row) {
                    $user = User::create([
                        'name' => $row['nama'],
                        'email' => $row['email'],
                        'password' => Hash::make($row['kata_sandi'])
                    ]);

                    $role = Role::find($row['role']);
                    $user->assignRole($role);
                    $teacher = $user->guru()->create([
                        'nip' => $row['nip'],
                        'jabatan' => $row['jabatan'],
                        'jam_mengajar_ekspektasi' => $row['jumlah_jam_mengajar'],
                        'presensi_ekspektasi' => $row['jumlah_presensi'],
                    ]);

                    $teacher->subjectTeacher()->createMany(collect($row['subject'])->map(fn($subject) => ['mata_pelajaran_id' => $subject]));
                    $teacher->classTeacher()->createMany(collect($row['class'])->map(fn($class) => ['kelas_id' => $class]));
                }
            });

            return redirect()->back()->with('success', 'Data guru berhasil diimpor.');
        } catch (\Exception $e) {
            if (config('app.debug')) {
                dd($e);
            }

            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengimpor data guru. Silakan coba lagi.');
        }
    }
}
