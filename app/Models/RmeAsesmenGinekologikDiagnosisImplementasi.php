<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenGinekologikDiagnosisImplementasi extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_GINEKOLOGIK_DIAGNOSIS_IMPLEMENTASI';
    public $timestamps = false;
    protected $guarded = ['id'];
}
