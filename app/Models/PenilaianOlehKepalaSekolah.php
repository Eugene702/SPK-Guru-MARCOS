<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaianOlehKepalaSekolah extends Model
{
    protected $table = 'penilaian_oleh_kepala_sekolah';

    protected $fillable = [
        'guru_id',
        'kepala_sekolah_id',
        'nilai_akhir',
    ];
}
