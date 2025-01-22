<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasienInap extends Model
{
    use HasFactory;

    protected $table = 'pasien_inap';
    public $timestamps = false;
    protected $fillable = [
        'kd_kasir',
        'no_transaksi',
        'kd_unit',
        'no_kamar',
        'kd_spesial',
        'co_status',
    ];
}
