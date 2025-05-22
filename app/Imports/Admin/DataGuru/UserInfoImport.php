<?php

namespace App\Imports\Admin\DataGuru;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class UserInfoImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        return collect($collection->map(function($row){
            return [
                'nip' => $row[0],
                'name' => $row[1],
                'email' => $row[2],
                'position' => $row[3],
                'role' => $row[4],
                'teachingHour' => $row[5],
                'totalAttendance' => $row[6],
                'password' => $row[7],
            ];
        }));
    }
}
