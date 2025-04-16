<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenKepUmumRisikoDekubitus extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_KEP_UMUM_RISIKO_DEKUBITUS';
    public $timestamps = false;

    protected $guarded = ['id'];
}
