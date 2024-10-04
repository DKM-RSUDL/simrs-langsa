<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SegalaOrder extends Model
{
    use HasFactory;
    protected $table = 'SEGALA_ORDER';

    protected $fillable = [
        'kd_order',
        'kd_pasien',
        'kd_unit',
        'tgl_masuk',
        'urut_masuk',
        'kd_dokter',
        'tgl_order',
        'cyto',
        'puasa',
        'jadwal_pemeriksaan',
        'diagnosis',
        'dilayani',
        'kategori',
        'no_transaksi',
        'kd_kasir',
        'status_order',
        'transaksi_penunjang'
    ];

    protected $casts = [
        'tgl_masuk' => 'datetime',
        'tgl_order' => 'datetime',
        'jadwal_pemeriksaan' => 'datetime',
        'cyto' => 'string',
        'puasa' => 'string',
    ];
    public $timestamps = false;

    public function details()
    {
        return $this->hasMany(SegalaOrderDet::class, 'kd_order', 'kd_order');
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'kd_dokter', 'kd_dokter');
    }
    public function transaksi()
    {
        return $this->hasOne(Transaksi::class, 'kd_pasien', 'kd_pasien');
    }

    public function produk()
    {
        return $this->belongsTo(LapLisItemPemeriksaan::class, 'kd_produk', 'kd_produk');
    }
}
