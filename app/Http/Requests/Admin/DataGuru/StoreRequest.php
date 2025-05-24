<?php

namespace App\Http\Requests\Admin\DataGuru;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6'],
            'nip' => ['required', 'unique:guru,nip'],
            'jabatan' => ['required'],
            'jumlah_jam_mengajar' => ['required_if:role,Guru'],
            'jumlah_presensi' => ['required_if:role,Guru'],
            'role' => ['required'],
            'kelas' => ['required_if:role,Guru', 'array'],
            'kelas.*' => ['exists:kelas,id'],
            'mata_pelajaran' => ['required_if:role,Guru', 'array'],
            'mata_pelajaran.*' => ['exists:mata_pelajaran,id']
        ];
    }

    public function messages(){
        return [
            'name.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password tidak boleh kosong',
            'password.min' => 'Password minimal 6 karakter',
            'nip.required' => 'NIP tidak boleh kosong',
            'nip.unique' => 'NIP sudah terdaftar',
            'jabatan.required' => 'Jabatan tidak boleh kosong',
            'mata_pelajaran.required_if' => 'Mata pelajaran tidak boleh kosong',
            'mata_pelajaran.array' => 'Mata pelajaran harus berupa array',
            'mata_pelajaran.*.exists' => 'Mata pelajaran yang dipilih tidak valid',
            'jumlah_jam_mengajar.required_if' => 'Jumlah jam mengajar tidak boleh kosong',
            'jumlah_presensi.required_if' => 'Jumlah presensi tidak boleh kosong',
            'role.required' => 'Role tidak boleh kosong',
            'kelas.required_if' => 'Kelas tidak boleh kosong',
            'kelas.array' => 'Kelas harus berupa array',
            'kelas.*.exists' => 'Kelas yang dipilih tidak valid',
        ];
    }
}
