<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrDiagnosisBanding extends Model
{
    use HasFactory;
    protected $table = 'mr_diagnosis_banding';
    public $timestamps = false;
    protected $guarded = ['id'];
}
