<?php

namespace App\Http\Requests\Admin\DataGuru;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UpdateRequest extends FormRequest
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
        $userId = User::select('id')
            ->whereHas('guru', function ($query) {
                $query->where('id', '=', $this->route('id'));
            });

        if (!$userId->exists()) {
            throw ValidationException::withMessages([
                'email' => 'User tidak ditemukan untuk guru ini.',
            ]);
        } else {
            $userId = $userId->first()->id;
        }

        return [
            'name' => ['required'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($userId)],
            'password' => ['nullable', 'min:6'],
            'nip' => ['required', Rule::unique('guru', 'id')->ignore($this->route('id'))],
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

    public function messages()
    {
        return [
            'name.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
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
