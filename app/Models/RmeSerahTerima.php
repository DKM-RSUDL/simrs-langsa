<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeSerahTerima extends Model
{
    use HasFactory;
    protected $table = 'rme_serah_terima';
    public $timestamps = false;

    protected $fillable = [
        'kd_pasien',
        'tgl_masuk',
        'urut_masuk',
        'kd_unit_asal',
        'kd_unit_tujuan',
        'subjective',
        'background',
        'assessment',
        'recomendation',
        'tanggal_menyerahkan',
        'jam_menyerahkan',
        'petugas_menyerahkan',
        'tanggal_terima',
        'jam_terima',
        'petugas_terima',
        'status',
        'urut_masuk_tujuan',
    ];

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
        return $this->belongsTo(User::class, 'petugas_menyerahkan', 'id');
    }

    public function petugasTerima()
    {
        return $this->belongsTo(User::class, 'petugas_terima', 'id');
    }
}
