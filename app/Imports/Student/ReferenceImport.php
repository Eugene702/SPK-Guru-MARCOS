<?php

namespace App\Imports\Student;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\HasReferencesToOtherSheets;
use Maatwebsite\Excel\Concerns\ToCollection;

class ReferenceImport implements ToCollection, HasReferencesToOtherSheets
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        //
    }
}
