<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeSerahTerima extends Model
{
    use HasFactory;
    protected $table = 'rme_serah_terima';
    public $timestamps = false;

    protected $guarded = ['id'];

    public function unitAsal()
    {
        return $this->belongsTo(Unit::class, 'kd_unit_asal', 'kd_unit');
    }

    public function unitTujuan()
    {
        return $this->belongsTo(Unit::class, 'kd_unit_tujuan', 'kd_unit');
    }

    public function petugasAsal()
    {
        return $this->belongsTo(HrdKaryawan::class, 'petugas_menyerahkan', 'kd_karyawan');
    }

    public function petugasTerima()
    {
        return $this->belongsTo(HrdKaryawan::class, 'petugas_terima', 'kd_karyawan');
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'kd_pasien', 'kd_pasien');
    }

    public function transfer()
    {
        return $this->belongsTo(RmeTransferPasienAntarRuang::class, 'transfer_id', 'id');
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'kd_dokter', 'kd_dokter');
    }

    public function kamar()
    {
        return $this->belongsTo(KamarInduk::class, 'no_kamar', 'no_kamar');
    }
}
