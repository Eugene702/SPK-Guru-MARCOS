<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaianSiswa extends Model
{
    protected $table = 'penilaian_siswa'; // pastikan nama tabel sesuai
    protected $fillable = [
        'siswa_id', 
        'guru_id', 
        'jam_masuk', 
        'jam_tugas', 
        'jam_tidak_masuk'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
}

