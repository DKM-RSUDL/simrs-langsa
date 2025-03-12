<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeForensikPemeriksaanFisik extends Model
{
    use HasFactory;

    protected $table = 'rme_forensik_pemeriksaan_fisik';
    public $timestamps = false;

    protected $fillable = [
        'id_pemeriksaan',
        'id_item_fisik',
        'is_normal',
        'keterangan'
    ];
}
