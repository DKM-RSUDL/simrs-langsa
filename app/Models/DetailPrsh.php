<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPrsh extends Model
{
    use HasFactory;

    protected $table = 'detail_prsh';
    public $timestamps = false;

    protected $fillable = [
        'kd_kasir',
        'no_transaksi',
        'urut',
        'tgl_transaksi',
        'hak',
        'selisih',
        'disc',
    ];
}
