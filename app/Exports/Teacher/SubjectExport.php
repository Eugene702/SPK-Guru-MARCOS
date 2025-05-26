<?php

namespace App\Exports\Teacher;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SubjectExport implements WithStyles, ShouldAutoSize, WithTitle, WithHeadings
{
    public function headings(): array
    {
        return ['NIP', 'SUBJECT_ID'];
    }
    public function title(): string{
        return "Subject";
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
