<?php

namespace App\Models\RawatInap;

use App\Models\Dokter;
use App\Models\Kamar;
use App\Models\KlasProduk;
use App\Models\OkJenisOP;
use App\Models\Pasien;
use App\Models\Produk;
use App\Models\Spesialisasi;
use App\Models\SubSpesialisasi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperasiIBS extends Model
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
        return $this->belongsTo(KlasProduk::class, 'kd_jenis_op', 'kd_klas');
    }

    public function spesialisasi()
    {
        return $this->belongsTo(Spesialisasi::class, 'kd_spc', 'kd_spesial');
    }

    public function subSpesialisasi()
    {
        return $this->belongsTo(KlasProduk::class, 'kd_sub_spc', 'kd_klas');
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'kd_pasien', 'kd_pasien');
    }
}