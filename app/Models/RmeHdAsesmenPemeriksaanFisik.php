<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeHdAsesmenPemeriksaanFisik extends Model
{
    use HasFactory;

    protected $table = 'rme_hd_asesmen_pemeriksaan_fisik';
    public $timestamps = false;

    protected $fillable = [
        'id_asesmen',
        'id_item_fisik',
        'is_normal',
        'keterangan'
    ];
}
