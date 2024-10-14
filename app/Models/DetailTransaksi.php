<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;

    protected $table = 'detail_transaksi';
    public $timestamps = false;

    protected $fillable = [
        'kd_kasir',
        'no_transaksi',
        'urut',
        'tgl_transaksi',
        'kd_user',
        'kd_tarif',
        'kd_produk',
        'kd_unit',
        'tgl_berlaku',
        'charge',
        'adjust',
        'folio',
        'qty',
        'harga',
        'shift',
        'kd_dokter',
        'kd_unit_tr',
        'cito',
        'js',
        'jp',
        'no_faktur',
        'flag',
        'tag',
        'hrg_asli',
        'kd_customer',
        'close_shift_status',
        'kd_loket',
        'jns_trans',
        'bhp',
        'selisih_tarif',
    ];
}
