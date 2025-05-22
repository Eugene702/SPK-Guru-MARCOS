<?php

namespace App\Imports;

use App\Imports\Admin\DataGuru\SubjectImport;
use App\Imports\Admin\DataGuru\UserInfoImport;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MasterImport implements WithMultipleSheets
{
    public function sheets(): array{
        return [
            'User Info' => new UserInfoImport(),
            'Subject' => new SubjectImport(),
            'Class' => new ClassImport()
        ];
    }
}
