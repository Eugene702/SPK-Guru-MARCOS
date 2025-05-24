<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaianRekanDetail extends Model
{
    protected $table = "penilaian_rekan_detail";
    protected $fillable = [
        'penilaian_id',
        'pernyataan_id',
        'nilai',
    ];
}
