<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Racik extends Model
{
    use HasFactory;

    protected $table = 'RACIK';
    public $timestamps = false;

    protected $fillable = [
        'KD_PASIEN',
        'TGL_MASUK',
        'KD_UNIT',
        'URUT_MASUK',
        'KD_DOKTER',
        'ID_MRRESEP',
        'CAT_RACIKAN',
        'TGL_ORDER',
        'DILAYANI',
        'RACIKAN',
        'QTY',
        'ATURAN',
        'KETERANGAN'
        // Tambahkan kolom lain yang ada di tabel MR_RESEP
    ];
}
