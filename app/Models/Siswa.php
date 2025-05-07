<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Siswa extends Model
{
    protected $fillable = ['kelas_id', 'user_id'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function penilaianGuru()
    {
        return $this->hasMany(PenilaianSiswa::class);
    }


}
