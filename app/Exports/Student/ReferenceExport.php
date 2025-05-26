<?php

namespace App\Exports\Student;

use App\Models\Kelas;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReferenceExport implements ShouldAutoSize, WithHeadings, FromArray, WithTitle, WithStyles
{
    public function headings(): array{
        return ['ID', 'NAMA'];
    }

    public function array(): array{
        return Kelas::select('id', 'nama_kelas')
            ->whereDoesntHave('student')
            ->get()
            ->values()
            ->toArray();
    }

    public function title(): string{
        return 'Reference';
    }

    public function styles(Worksheet $sheet){
        return [
            1 => [
                'font' => [
                    'bold' => true
                ]
            ]
        ];
    }
}
