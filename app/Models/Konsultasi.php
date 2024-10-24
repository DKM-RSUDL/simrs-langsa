<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konsultasi extends Model
{
    use HasFactory;
    
    protected $table = 'konsultasi';
    public $timestamps = false;

    protected $fillable = [
        'kd_pasien',
        'kd_unit',
        'tgl_masuk',
        'urut_masuk',
        'kd_pasien_tujuan',
        'kd_unit_tujuan',
        'tgl_masuk_tujuan',
        'urut_masuk_tujuan',
        'urut_konsul',
        'jam_masuk_tujuan',
        'kd_dokter',
        'kd_dokter_tujuan',
        'kd_konsulen_diharapkan',
        'catatan',
        'konsul',
    ];

    public function unit_tujuan()
    {
        return $this->belongsTo(Unit::class, 'kd_unit_tujuan', 'kd_unit');
    }

    public function dokter_asal()
    {
        return $this->belongsTo(Dokter::class, 'kd_dokter', 'kd_dokter');
    }

    public function unit_asal()
    {
        return $this->belongsTo(Unit::class, 'kd_unit', 'kd_unit');
    }
}
