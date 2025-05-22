<?php

namespace App\Imports\Admin\DataGuru;

use App\Imports\Admin\DataGuru\SubjectImport;
use App\Imports\Admin\DataGuru\UserInfoImport;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithValidation;

class MasterImport implements WithMultipleSheets
{
    public function sheets(): array{
        return [
            new UserInfoImport(),
            new SubjectImport(),
            new ClassImport(),
            new ReferenceImport()
        ];
    }
}
