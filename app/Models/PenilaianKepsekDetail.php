<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaianKepsekDetail extends Model
{
    protected $table = 'penilaian_kepsek_detail';

    protected $fillable = [
        'penilaian_id',
        'pernyataan_id',
        'nilai',
    ];
}
