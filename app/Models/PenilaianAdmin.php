<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianAdmin extends Model
{
    use HasFactory;

    protected $table = 'penilaian_oleh_admin'; // <- tabel tanpa underscore
    protected $primaryKey = 'id'; 
    public $incrementing = true;
    protected $keyType = 'int';
    
    protected $fillable = [
        'guru_id',
        'administrasi',
        'presensi_realita',
        'sertifikat_pengembangan',
        'kegiatan_sosial',
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function administrasiSubKriteria()
    {
        return $this->belongsTo(SubKriteria::class, 'administrasi', 'id_sub_kriteria');
    }
}
