<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeSpri extends Model
{
    use HasFactory;

    protected $table = 'RME_SPRI';
    public $timestamps = false;

    protected $fillable = [
        'kd_pasien',
        'kd_unit',
        'tgl_masuk',
        'urut_masuk',
        'id_asesmen',
        'tanggal_ranap',
        'jam_ranap',
        'keluhan_utama',
        'jalannya_penyakit',
        'hasil_pemeriksaan',
        'diagnosis',
        'tindakan',
        'anjuran'
    ];
}
