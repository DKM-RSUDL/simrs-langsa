<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    public $timestamps = false;

    protected $fillable = [
        'kd_kasir',
        'no_transaksi',
        'kd_pasien',
        'kd_unit',
        'tgl_transaksi',
        'urut_masuk',
        'tgl_co',
        'co_status',
        'orderlist',
        'app',
        'kd_user',
        'tag',
        'lunas',
        'tgl_lunas',
        'acc_dr',
        'jumlah_lama',
        'dilayani',
        'orderMng',
        'verified',
        'closeShift',
        'paid',
        'tgl_bayar_paid',
        'tgl_dok',
        'stats_dok',
        'jumlah_jaminan',
        'konsul_rwi',
    ];
}
