<?php

namespace App\Exports\Student;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MasterExport implements WithMultipleSheets
{
    public function sheets(): array{
        return [
            "User Info" => new UserInfoExport(),
            'Reference' => new ReferenceExport()
        ];
    }
}
