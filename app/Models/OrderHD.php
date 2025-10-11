<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderHD extends Model
{
    use HasFactory;

    protected $table = 'order_hd';
    public $timestamps = false;

    protected $fillable = [
        'kd_kasir_asal',
        'no_transaksi_asal',
        'kd_unit_order',
        'tgl_order',
        'jam_order',
        'status',
        'kd_kasir_hd',
        'no_transaksi_hd',
        'id_serah_terima',
        'kd_produk'
    ];

    public function unit_asal()
    {
        return $this->belongsTo(Unit::class, 'kd_unit_order', 'kd_unit');
    }
}
