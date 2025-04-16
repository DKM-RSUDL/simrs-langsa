<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeHdAsesmenMedisPenunjang extends Model
{
    use HasFactory;

    protected $table = 'rme_hd_asesmen_medis_penunjang';
    public $timestamps = false;

    protected $fillable = [
        'id_asesmen',
        'hb',
        'hbsag',
        'hbsag',
        'phospor',
        'fe_serum',
        'gol_darah',
        'calcium',
        'kalium',
        'natrium',
        'ureum',
        'asam_urat',
        'creatinin',
        'tibc',
        'hcv',
        'hiv',
        'gula_darah',
        'lab_lainnya',
        'ekg',
        'rongent',
        'usg',
    ];
}
