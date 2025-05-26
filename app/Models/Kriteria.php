<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    protected $table = 'kriteria';
    protected $fillable = [
        'kode_kriteria',
        'nama_kriteria',
        'bobot',
        'jenis',
    ];

    // App\Models\Kriteria.php
    public function subKriterias()
    {
        return $this->hasMany(SubKriteria::class, 'kriteria_id');
    }


}

