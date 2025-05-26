<?php

namespace App\Exports\Teacher;

use App\Models\Kelas;
use App\Models\MataPelajaran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Spatie\Permission\Models\Role;

class ReferenceExport implements FromCollection, ShouldAutoSize, WithTitle, WithStyles, WithHeadings
{
    public function headings(): array
    {
        return [
            'ROLE ID',
            'ROLE NAME',
            '',
            'JABATAN',
            '',
            'SUBJECT ID',
            'SUBJECT NAME',
            '',
            'CLASS ID',
            'CLASS NAME'
        ];
    }
    public function title(): string
    {
        return "Reference";
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]]
        ];
    }

    public function collection()
    {
        $roles = Role::select('id', 'name')
            ->get()
            ->sortByDesc(function ($query) {
                return $query->name === 'KepalaSekolah';
            })
            ->values();

        $positions = collect(['Kepala Sekolah', 'Guru']);
        $subjects = MataPelajaran::select('id', 'nama_mata_pelajaran')->get();
        $classes = Kelas::select('id', 'nama_kelas')->get();

        $max = max($roles->count(), $positions->count(), $subjects->count(), $classes->count());

        $rows = [];

        for ($i = 0; $i < $max; $i++) {
            $rows[] = [
                $roles[$i]->id ?? null,
                $roles[$i]->name ?? null,
                '',

                $positions[$i] ?? null,
                '',

                $subjects[$i]->id ?? null,
                $subjects[$i]->nama_mata_pelajaran ?? null,
                '',

                $classes[$i]->id ?? null,
                $classes[$i]->nama_kelas ?? null,
            ];
        }

        return collect([...$rows]);
    }
}
