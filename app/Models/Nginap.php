<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nginap extends Model
{
    use HasFactory;

    protected $table = 'nginap';
    public $timestamps = false;
    protected $fillable = [
        'kd_unit_kamar',
        'no_kamar',
        'kd_pasien',
        'kd_unit',
        'tgl_masuk',
        'urut_masuk',
        'tgl_inap',
        'jam_inap',
        'tgl_keluar',
        'jam_keluar',
        'bed',
        'kd_spesial',
        'akhir',
        'urut_nginap',
        'alasan_pindah',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'kd_unit', 'kd_unit');
    }

    public function unitKamar()
    {
        return $this->belongsTo(Unit::class, 'kd_unit_kamar', 'kd_unit');
    }
}
