<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaianRekanDetail extends Model
{
    protected $fillable = [
        'penilaian_id',
        'pernyataan_id',
        'nilai',
    ];
}
