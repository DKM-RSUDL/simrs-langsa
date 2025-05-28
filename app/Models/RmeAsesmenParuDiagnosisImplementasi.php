<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenParuDiagnosisImplementasi extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_PARU_DIAGNOSIS_IMPLEMENTASI';
    public $timestamps = false;
    protected $guarded = ['id'];
}
