<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonsultasiIGD extends Model
{
    use HasFactory;

    protected $table = 'konsultasi_igd';

    protected $fillable = [
        'kd_pasien',
        'kd_unit',
        'tgl_masuk',
        'urut_masuk',
        'kd_dokter',
        'kd_dokter_tujuan',
        'tgl_konsul',
        'jam_konsul',
        'subjective',
        'background',
        'assesment',
        'recomendation',
        'konsultasi',
        'instruksi',
        'user_create',
        'user_edit',
    ];

    public function dokterAsal()
    {
        return $this->belongsTo(Dokter::class, 'kd_dokter', 'kd_dokter');
    }

    public function dokterTujuan()
    {
        return $this->belongsTo(Dokter::class, 'kd_dokter_tujuan', 'kd_dokter');
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'kd_pasien', 'kd_pasien');
    }
}
