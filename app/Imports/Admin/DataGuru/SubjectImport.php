<?php

namespace App\Imports\Admin\DataGuru;

use App\Models\Guru;
use App\Models\GuruMataPelajaran;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class SubjectImport implements WithCalculatedFormulas, ToModel, WithHeadingRow, WithValidation, WithBatchInserts
{
    /**
     * @param Collection $collection
     */
    public function model($row)
    {
        $teacher = Guru::select('id')->where('nip', '=', $row['nip'])->first();
        return new GuruMataPelajaran([
            'guru_id' => $teacher->id,
            'mata_pelajaran_id' => $row['subject_id'],
        ]);
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function rules(): array
    {
        return [
            'nip' => ['required'],
            'subject_id' => ['required', 'exists:mata_pelajaran,id']
        ];
    }

    public function customValidationMessages()
    {
        return [
            'subject_id.required' => 'ID Mata Pelajaran tidak boleh kosong',
            'subject_id.exists' => 'ID Mata Pelajaran tidak ditemukan di database',
        ];
    }
}
