<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsalIGD extends Model
{
    use HasFactory;

    protected $table = 'asal_igd';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function kunjunganRanap()
    {
        return $this->belongsTo(Kunjungan::class, 'kd_kasir', 'kd_kasir')
            ->where('no_transaksi', $this->no_transaksi);
    }

    public function kunjunganIGD()
    {
        return $this->belongsTo(Kunjungan::class, 'kd_kasir_asal', 'kd_kasir')
            ->where('no_transaksi', $this->no_transaksi_asal);
    }
}
