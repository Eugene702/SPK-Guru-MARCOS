<?php

namespace App\Imports\Admin\DataGuru;

use App\Models\Guru;
use App\Models\GuruKelas;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ClassImport implements WithCalculatedFormulas, WithHeadingRow, ToCollection, WithValidation, ToModel, WithBatchInserts
{
    public function model($row)
    {
        $teacher = Guru::select('id')->where('nip', '=', $row['nip'])->first();
        return new GuruKelas([
            'guru_id' => $teacher->id,
            'kelas_id' => $row['class_id']
        ]);
    }
    public function collection(Collection $rows)
    {

    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function rules(): array
    {
        return [
            'nip' => ['required'],
            'class_id' => ['required', 'exists:kelas,id']
        ];
    }

    public function customValidationMessages()
    {
        return [
            'class_id.string' => 'ID Kelas harus berupa string',
            'class_id.exists' => 'ID Kelas tidak ditemukan di database',
        ];
    }
}
