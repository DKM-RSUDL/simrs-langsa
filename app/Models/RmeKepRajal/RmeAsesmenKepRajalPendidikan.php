<?php

namespace App\Models\RmeKepRajal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenKepRajalPendidikan extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_KEP_RAJAL_PENDIDIKAN';
    public $timestamps = false;
    protected $guarded = ['id'];
}
