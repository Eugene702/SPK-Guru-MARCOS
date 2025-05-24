<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Perhitungan extends Model
{
    use HasFactory;

    protected $table = 'perhitungan'; // nama tabel
    protected $fillable = [
        'guru_id', 
        'supervisi', 
        'administrasi', 
        'presensi', 
        'kehadiran_dikelas',
        'sertifikat_pengembangan', 
        'kegiatan_sosial',
        'rekan_sejawat'
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }

    public function administrasiSubKriteria()
    {
        return $this->belongsTo(SubKriteria::class, 'administrasi', 'id_sub_kriteria');
    }


}
