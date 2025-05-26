<?php

namespace App\Imports\Student;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MasterImport implements WithMultipleSheets
{
    
    public function sheets(): array
    {
        return [
            'User Info' => new UserInfoImport(),
            'Reference' => new ReferenceImport()
        ];
    }
}
