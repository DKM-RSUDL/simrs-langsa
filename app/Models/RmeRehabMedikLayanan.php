<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeRehabMedikLayanan extends Model
{
    use HasFactory;

    protected $table = 'rme_rehab_medik_layanan';
    public $timestamps = false;

    protected $fillable = [
        'kd_pasien',
        'kd_unit',
        'tgl_masuk',
        'urut_masuk',
        'tgl_pelayanan',
        'jam_pelayanan',
        'anamnesa',
        'pemeriksaan_fisik',
        'diagnosis_medis',
        'diagnosis_fungsi',
        'pemeriksaan_penunjang',
        'tatalaksana',
        'suspek_penyakit',
        'suspek_penyakit_ket',
        'diagnosa',
        'permintaan_terapi',
        'user_create',
        'user_edit',
    ];

    protected $casts = [
        'diagnosis_medis' => 'array',
        'diagnosis_fungsi' => 'array',
        'tatalaksana' => 'array',
    ];


    public function userCreate()
    {
        return $this->belongsTo(User::class, 'user_create', 'id');
    }
}
