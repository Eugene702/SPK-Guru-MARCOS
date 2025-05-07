<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $fillable = ['nama_kelas'];

    public function siswas()
    {
        return $this->hasMany(Siswa::class, 'kelas_id');
    }

    public function gurus()
{
    return $this->belongsToMany(Guru::class, 'guru_kelas', 'kelas_id', 'guru_id');
}

}
