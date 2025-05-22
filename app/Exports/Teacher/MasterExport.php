<?php

namespace App\Exports\Teacher;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MasterExport implements WithMultipleSheets
{
    use Exportable;
    public function sheets(): array{
        return [
            'UserInfo' => new UserInfoExport(),
            'Subject' => new SubjectExport(),
            'Class' => new ClassExport(),
            'Reference' => new ReferenceExport()
        ];
    }
}
