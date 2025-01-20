<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KamarInduk extends Model
{
    use HasFactory;

    protected $table = 'kamar_induk';
    public $timestamps = false;
    
    protected $fillable = [
        'no_kamar',
        'nama_kamar',
        'jumlah_bed',
        'digunakan',
        'booking',
        'aktif',
    ];
}
