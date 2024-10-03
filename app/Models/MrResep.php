<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrResep extends Model
{
    use HasFactory;

    protected $table = 'MR_RESEP';
    public $timestamps = false;

    protected $fillable = [
        'KD_PASIEN',
        'TGL_MASUK',
        'KD_DOKTER',
        'ID_MRRESEP',
        'CAT_RACIKAN',
        'TGL_ORDER',
        'STATUS',
        // Tambahkan kolom lain yang ada di tabel MR_RESEP
    ];

    // Relasi dengan model Pasien
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'KD_PASIEN', 'KD_PASIEN');
    }

    // Relasi dengan model Dokter
    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'KD_DOKTER', 'KD_DOKTER');
    }

}   
