<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenAwal extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_MED_RAJAL';
    public $timestamps = false; // set true jika tabel punya created_at/updated_at

    protected $fillable = [
        'kd_kasir',
        'no_transaksi',
        'kd_dokter',
        'keluhan_utama',
        'pemeriksaan_fisik',
        'diagnosis',         // JSON array (list)
        'planning',
        'edukasi',
        'waktu_asesmen',     // datetime-local
    ];

    protected $casts = [
        'diagnosis'      => 'array',
        'waktu_asesmen'  => 'datetime',
    ];
}
