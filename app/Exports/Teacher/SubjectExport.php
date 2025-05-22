<?php

namespace App\Exports\Teacher;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SubjectExport implements FromCollection, WithStyles, ShouldAutoSize, WithTitle
{
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
    public function collection()
    {
        return collect([
            ['NIP', 'SUBJECT_ID']
        ]);
    }
}
