<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderRehabMedik extends Model
{
    use HasFactory;

    protected $table = 'order_rehab_medik';
    public $timestamps = false;

    protected $fillable = [
        'kd_kasir_asal',
        'no_transaksi_asal',
        'kd_unit_order',
        'tgl_order',
        'jam_order',
        'status',
        'kd_kasir_rehab',
        'no_transaksi_rehab',
        'kd_produk',
        'user_create',
        'user_edit',
        'kd_dokter',
    ];

    public function unit_asal()
    {
        return $this->belongsTo(Unit::class, 'kd_unit_order', 'kd_unit');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'kd_produk', 'kd_produk');
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'kd_dokter', 'kd_dokter');
    }

    public function userCreate()
    {
        return $this->belongsTo(HrdKaryawan::class, 'user_create', 'kd_karyawan');
    }
}
