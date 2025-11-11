<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    public $timestamps = false;

    protected $guarded = [];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'kd_pasien', 'kd_pasien');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'kd_unit', 'kd_unit');
    }

    public function unitAsal()
    {
        return $this->hasMany(UnitAsal::class, 'no_transaksi', 'no_transaksi')
            ->where('kd_kasir', $this->kd_kasir);
    }

    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class, 'kd_pasien', 'kd_pasien')
            ->where('kd_unit', $this->kd_unit)
            ->where('tgl_masuk', $this->tgl_transaksi)
            ->where('urut_masuk', $this->urut_masuk);
    }
}
