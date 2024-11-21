<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $table = 'produk';
    protected $fillable = [
        'kd_produk',
        'kd_klas',
        'deskripsi',
        'manual',
        'kp_produk',
        'kd_kat',
        'aktif',
    ];

    public function klas()
    {
        return $this->belongsTo(KlasProduk::class, 'kd_klas', 'kd_klas');
    }

    // public function labHasil()
    // {
    //     return $this->hasOne(LabHasil::class, 'kd_produk', 'kd_produk');
    // }

    public function labTest()
    {
        return $this->hasMany(LabTest::class, 'kd_produk', 'kd_produk');
    }

    public function labHasil()
    {
        return $this->hasMany(LabHasil::class, 'kd_produk', 'kd_produk');
    }
}
