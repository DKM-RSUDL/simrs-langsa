<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenKepUmumCirculation extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_KEP_UMUM_CIRCULATION';
    public $timestamps = false;

    protected $fillable = [
        'id_asesmen',
        'circulation_nadi',
        'circulation_sistole',
        'circulation_diastole',
        'circulation_akral',
        'circulation_pucat',
        'circulation_cianosis',
        'circulation_kapiler',
        'circulation_kelembapan_kulit',
        'circulation_turgor',
        'circulation_transfusi',
        'circulation_transfusi_jumlah',
        'circulation_diagnosis_perfusi',
        'circulation_diagnosis_defisit',
        'circulation_tindakan',
        'circulation_lain'
    ];
}
