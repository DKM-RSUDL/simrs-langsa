<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrKondisiFisik extends Model
{
    use HasFactory;

    protected $table = 'mr_kondisifisik';
    public $timestamps = false;

    protected $fillable = [
        'id_kondisi',
        'kondisi',
        'satuan',
        'orderlist',
        'kd_unit',
        'kd_loinc',
        'unit_loinc',
        'system_code',
        'display',
        'urut',
    ];
}
