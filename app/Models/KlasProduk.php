<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KlasProduk extends Model
{
    use HasFactory;

    protected $table = 'klas_produk';
    protected $fillable = [
        'kd_klas',
        'klasifikasi',
        'type_data',
        'parent',
        'kd_kat',
        'kd_poli',
    ];
}
