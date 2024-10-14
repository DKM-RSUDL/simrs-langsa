<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailComponent extends Model
{
    use HasFactory;

    protected $table = 'detail_component';
    public $timestamps = false;

    protected $fillable = [
        'kd_kasir',
        'no_transaksi',
        'urut',
        'tgl_transaksi',
        'kd_component',
        'tarif',
        'disc',
        'markup',
    ];
}
