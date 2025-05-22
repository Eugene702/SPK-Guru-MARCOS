<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ClassImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        return collect($collection->map(function($row){
            return [
                'nip' => $row[0],
                'class' => $row[1],
            ];
        }));
    }
}
