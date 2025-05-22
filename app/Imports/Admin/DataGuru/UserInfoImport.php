<?php

namespace App\Imports\Admin\DataGuru;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\HasReferencesToOtherSheets;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Spatie\Permission\Models\Role;

class UserInfoImport implements ToModel, HasReferencesToOtherSheets, WithCalculatedFormulas, WithHeadingRow, WithValidation, WithBatchInserts
{
    /**
     * @param Collection $collection
     */
    public function model($row)
    {
        $user = new User([
            'name' => $row['nama'],
            'email' => $row['email'],
            'password' => Hash::make($row['kata_sandi']),
        ]);

        $user->setRelation('guru', new Guru([
            'nip' => $row['nip'],
            'jabatan' => $row['jabatan'],
            'jumlah_jam_mengajar' => $row['jumlah_jam_mengajar'],
            'jumla_presensi' => $row['jumlah_presensi']
        ]));

        return $user;
    }

    public function batchSize(): int{
        return 1000;
    }

    public function rules(): array{
        $roleList = Role::pluck('id')->toArray();
        return [
            'nip' => ['required', 'unique:gurus,nip'],
            'nama' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'jabatan' => ['required', 'in:Kepala Sekolah,Guru'],
            'role' => ['required', Rule::in($roleList)],
            'jumlah_jam_mengajar' => ['required', 'integer', 'min:0'],
            'jumlah_presensi' => ['required', 'integer', 'min:0'],
            'kata_sandi' => ['required', 'min:8'],
        ];
    }

    public function customValidationMessages(){
        return [
            'nip.required' => 'NIP tidak boleh kosong',
            'nip.unique' => 'NIP sudah terdaftar',
            'nama.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'jabatan.required' => 'Jabatan tidak boleh kosong',
            'jabatan.in' => 'Jabatan tidak valid',
            'role.required' => 'Role tidak boleh kosong',
            'role.in' => 'Role tidak valid',
            'jumlah_jam_mengajar.required' => 'Jumlah jam mengajar tidak boleh kosong',
            'jumlah_jam_mengajar.integer' => 'Jumlah jam mengajar harus berupa angka bulat positif',
            'jumlah_jam_mengajar.min' => 'Jumlah jam mengajar minimal 0',
            'jumlah_presensi.required' => 'Jumlah presensi tidak boleh kosong',
            'jumlah_presensi.integer' => 'Jumlah presensi harus berupa angka bulat positif',
            'jumlah_presensi.min' => 'Jumlah presensi minimal 0',
            'kata_sandi.required' => 'Kata sandi tidak boleh kosong',
            'kata_sandi.min' => 'Kata sandi minimal 8 karakter',
        ];
    }
}
