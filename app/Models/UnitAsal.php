<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitAsal extends Model
{
    use HasFactory;

    protected $table = 'unit_asal';
    public $timestamps = false;
    protected $guarded = [];

    public function transaksiAsal()
    {
        return $this->belongsTo(Transaksi::class, 'no_transaksi_asal', 'no_transaksi')
            ->where('kd_kasir', $this->kd_kasir_asal);
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'no_transaksi', 'no_transaksi')
            ->where('kd_kasir', $this->kd_kasir);
    }
}
