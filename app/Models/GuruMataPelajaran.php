<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuruMataPelajaran extends Model
{
    protected $table = 'guru_mata_pelajaran';

    protected $fillable = [
        'guru_id',
        'mata_pelajaran_id',
    ];
}
