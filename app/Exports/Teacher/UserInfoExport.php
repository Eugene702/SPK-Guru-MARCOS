<?php

namespace App\Exports\Teacher;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UserInfoExport implements FromCollection, WithStyles, ShouldAutoSize, WithTitle
{
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
    public function collection()
    {
        return collect([
            ['NIP', 'NAMA', 'EMAIL', 'JABATAN', 'ROLE', 'JUMLAH JAM MENGAJAR', 'JUMLAH PRESENSI', 'KATA SANDI']
        ]);
    }
}
