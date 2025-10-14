<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderOK extends Model
{
    use HasFactory;

    protected $table = 'ORDER_OK';
    protected $guarded = [];
    public $timestamps = false;

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'kd_produk', 'kd_produk');
    }

    public function kamar()
    {
        return $this->belongsTo(Kamar::class, 'no_kamar', 'no_kamar');
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'kd_dokter', 'kd_dokter');
    }

    public function jenisOperasi()
    {
        return $this->belongsTo(OkJenisOP::class, 'kd_jenis_op', 'kd_jenis_op');
    }

    public function spesialisasi()
    {
        return $this->belongsTo(Spesialisasi::class, 'kd_spc', 'kd_spesial');
    }

    public function subSpesialisasi()
    {
        return $this->belongsTo(SubSpesialisasi::class, 'kd_sub_spc', 'kd_sub_spc');
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'kd_pasien', 'kd_pasien');
    }
}
