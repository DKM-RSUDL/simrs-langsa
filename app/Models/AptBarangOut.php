<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AptBarangOut extends Model
{
    use HasFactory;

    protected $table = 'apt_barang_out';

    protected $fillable = [
        'KD_PASIENAPT',
        'NO_RESEP',
        'DOKTER',
        'JML_ITEM',
        'RESEP',
        'TGL_OUT',
    ];

    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class, 'KD_PASIENAPT', 'KD_PASIEN');
    }
}
