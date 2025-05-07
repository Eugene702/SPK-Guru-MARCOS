<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaianOlehRekanSejawat extends Model
{
    protected $fillable = [
        'penilai_id',
        'guru_id',
        'nilai_akhir',
    ];

    // Di PenilaianOlehRekanSejawat.php
    public function details()
    {
        return $this->hasMany(PenilaianRekanDetail::class, 'penilaian_id');
    }

}
