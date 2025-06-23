<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenPraAnestesiKuPfLaboratorium extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_PRA_ANESTESI_KU_PF_LABORATORIUM';
    public $timestamps = false;
    protected $guarded = ['id'];
}
