<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenPraAnestesiDiagnosisPmRtRo extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_PRA_ANESTESI_DIAGNOSIS_PM_RT_RO';
    public $timestamps = false;
    protected $guarded = ['id'];
}
