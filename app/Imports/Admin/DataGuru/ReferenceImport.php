<?php

namespace App\Imports\Admin\DataGuru;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\HasReferencesToOtherSheets;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ReferenceImport implements ShouldAutoSize, HasReferencesToOtherSheets, WithHeadingRow, ToCollection
{

    public function collection(Collection $row)
    {
        
    }
}
