<?php

namespace App\Imports\Admin\DataGuru;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class SubjectImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        return collect($collection->map(function($row){
            return [
                'nip' => $row[0],
                'subject' => $row[1],
            ];
        }));
    }
}
