<?php

namespace App\Models\RmeKepRajal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenKepRajalGizi extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_KEP_RAJAL_GIZI';
    public $timestamps = false;
    protected $guarded = ['id'];
}