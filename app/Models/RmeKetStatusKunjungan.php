<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeKetStatusKunjungan extends Model
{
    use HasFactory;

    protected $table = 'rme_ket_status_kunjungan';
    public $timestamps = false;

    protected $fillable = [
        'kd_kasir',
        'no_transaksi',
        'keterangan_kunjungan',
        'status_inap'
    ];
}
