<?php

namespace App\Exports\Student;

use App\Models\Kelas;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UserInfoExport implements WithHeadings, WithTitle, WithStyles
{
    public function headings(): array{
        return ['NAMA', 'EMAIL', 'KATA SANDI', 'KELAS'];
    }

    public function title(): string{
        return "User Info";
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
