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
}