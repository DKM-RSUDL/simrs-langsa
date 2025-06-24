<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenPraAnestesiKppKs extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_PRA_ANESTESI_KPP_KS';
    public $timestamps = false;
    protected $guarded = ['id'];
}
