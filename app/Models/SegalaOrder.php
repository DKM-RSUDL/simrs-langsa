<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SegalaOrder extends Model
{
    use HasFactory;
    protected $table = 'SEGALA_ORDER';
    protected $primaryKey = 'kd_order';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

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
        'transaksi_penunjang',
        'user_create',
        'user_edit',
        'indikasi_klinis'
    ];

    protected $casts = [
        'tgl_masuk' => 'datetime',
        'tgl_order' => 'datetime',
        'jadwal_pemeriksaan' => 'datetime',
        'cyto' => 'string',
        'puasa' => 'string',
    ];

    public function labHasil()
    {
        return $this->hasMany(LabHasil::class, 'kd_pasien', 'kd_pasien');
    }

    public function details()
    {
        return $this->hasMany(SegalaOrderDet::class, 'kd_order', 'kd_order');
    }

    public function laplisitempemeriksaan()
    {
        return $this->belongsTo(LapLisItemPemeriksaan::class, 'kd_produk', 'kd_produk');
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
        return $this->belongsTo(produk::class, 'kd_produk', 'kp_produk');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'kd_unit', 'kd_unit');
    }

    // public function labHasil()
    // {
    //     return $this->hasMany(LabHasil::class, 'kd_pasien', 'kd_pasien')
    //         ->whereColumn('tgl_masuk', 'tgl_masuk')
    //         ->whereColumn('kd_lab', 'kd_produk');
    // }
}
