<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $fillable = [
        'nip',
        'jabatan',
        'mata_pelajaran',
        'jumlah_jam_mengajar',
        'jumlah_presensi',
        'user_id', // <-- INI WAJIB ADA!
    ];

    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'guru_kelas', 'guru_id', 'kelas_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mataPelajarans()
    {
        return $this->belongsToMany(MataPelajaran::class, 'guru_mata_pelajaran', 'guru_id', 'mata_pelajaran_id');
    }
    
    public function penilaianAdmin()
    {
        return $this->hasOne(PenilaianAdmin::class, 'guru_id');
    }

    public function perhitungan()
    {
        return $this->hasOne(Perhitungan::class, 'guru_id');
    }

    public function penilaianSiswa()
    {
        return $this->hasMany(PenilaianSiswa::class, 'guru_id');
    }

    public function penilaianOlehKepalaSekolah()
    {
        return $this->hasMany(PenilaianOlehKepalaSekolah::class, 'guru_id');
    }

    // Penilaian yang DILAKUKAN oleh guru ini
    public function penilaianDilakukan()
    {
        return $this->hasMany(\App\Models\PenilaianOlehRekanSejawat::class, 'penilai_id');
    }

    // Penilaian yang DITERIMA oleh guru ini
    public function penilaianDiterima()
    {
        return $this->hasMany(\App\Models\PenilaianOlehRekanSejawat::class, 'guru_id');
    }



}
