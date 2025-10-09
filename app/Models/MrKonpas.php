<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrKonpas extends Model
{
    use HasFactory;

    protected $table = 'mr_konpas';
    public $timestamps = false;

    protected $fillable = [
        'id_konpas',
        'kd_pasien',
        'kd_unit',
        'tgl_masuk',
        'urut_masuk',
        'catatan',
        'urut_cppt'
    ];
}