<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenKepUmumExpo extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_KEP_UMUM_EXPO';
    public $timestamps = false;

    protected $fillable = [
        'id_asesmen',
        'exposure_deformitas',
        'exposure_deformitas_daerah',
        'exposure_kontusion',
        'exposure_kontusion_daerah',
        'exposure_abrasi',
        'exposure_abrasi_daerah',
        'exposure_penetrasi',
        'exposure_penetrasi_daerah',
        'exposure_laserasi',
        'exposure_laserasi_daerah',
        'exposure_edema',
        'exposure_edema_daerah',
        'exposure_kedalaman_luka',
        'exposure_lainnya',
        'exposure_diagnosis_mobilitasi',
        'exposure_diagosis_integritas',
        'exposure_diagnosis_lainnya',
        'exposure_tindakan'
    ];

    protected $casts = [
        'exposure_tindakan' => 'json'
    ];
}
