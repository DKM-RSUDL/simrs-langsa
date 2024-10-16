<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrResep extends Model
{
    use HasFactory;

    protected $table = 'MR_RESEP';
    public $timestamps = false;
    // protected $guarded = [];

    protected $fillable = [
        'KD_PASIEN',
        'TGL_MASUK',
        'KD_UNIT',
        'KD_DOKTER',
        'ID_MRRESEP',
        'CAT_RACIKAN',
        'TGL_ORDER',
        'STATUS',
        'URUT_MASUK',
        'DILAYANI',
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

    public function detailResep()
    {
        return $this->hasMany(MrResepDtl::class, 'ID_MRRESEP', 'ID_MRRESEP');
    }

    public function aptObat()
    {
        return $this->belongsTo(AptObat::class, 'KD_PRD', 'KD_PRD');
    }
}
