<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RMEResume extends Model
{
    use HasFactory;
    protected $table = 'RME_RESUME';
    // protected $primaryKey = 'id';
    // public $incrementing = false;
    // protected $keyType = 'float';
    public $timestamps = false;

    protected $fillable = [
        'kd_pasien',
        'kd_unit',
        'tgl_masuk',
        'urut_masuk',
        'anamnesis',
        'konpas',
        'pemeriksaan_penunjang',
        'diagnosis',
        'icd_10',
        'icd_9',
        'status',
        'user_validasi'
    ];

    protected $casts = [
        'konpas' => 'array',
        'diagnosis' => 'array',
        'icd_10' => 'array',
        'icd_9' => 'array',
    ];

    public function rmeResumeDet()
    {
        return $this->belongsTo(RmeResumeDtl::class, 'id', 'id_resume');
    }

    public function listTindakanPasien()
    {
        return $this->belongsTo(ListTindakanPasien::class, 'kd_pasien', 'kd_pasien');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'kd_produk', 'kd_produk');
    }
    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class, 'kd_pasien', 'kd_pasien');
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'kd_dokter', 'kd_dokter');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'kd_unit', 'kd_unit');
    }
}
