<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenKepUmumDisability extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_KEP_UMUM_DISABILITY';
    public $timestamps = false;

    protected $fillable = [
        'id_asesmen',
        'disability_kesadaran',
        'disability_isokor',
        'disability_respon_cahaya',
        'disability_diameter_pupil',
        'disability_motorik',
        'disability_sensorik',
        'disability_kekuatan_otot',
        'disability_diagnosis_perfusi',
        'disability_diagnosis_intoleransi',
        'disability_diagnosis_komunikasi',
        'disability_diagnosis_kejang',
        'disability_diagnosis_kesadaran',
        'disability_lainnya',
        'disability_tindakan'
    ];
}
