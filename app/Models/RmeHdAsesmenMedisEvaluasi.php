<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeHdAsesmenMedisEvaluasi extends Model
{
    use HasFactory;

    protected $table = 'rme_hd_asesmen_medis_evaluasi';
    public $timestamps = false;

    protected $fillable = [
        'id_asesmen',
        'evaluasi_medis',
        'dokter_pelaksana',
        'dpjp',
        'perawat',
        'diagnosis_banding',
        'diagnosis_kerja',
    ];
}
