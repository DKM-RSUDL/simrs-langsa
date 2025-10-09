<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrAnamnesis extends Model
{
    use HasFactory;

    protected $table = 'mr_anamnesis';
    public $timestamps = false;

    protected $fillable = [
        'kd_pasien',
        'kd_unit',
        'tgl_masuk',
        'urut_masuk',
        'urut_cppt',
        'urut',
        'anamnesis',
        'dd',
    ];
}