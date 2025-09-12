<?php

namespace App\Models\RmeKepRajal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenKepRajalSkalaNyeri extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_KEP_RAJAL_SKALA_NYERI';
    public $timestamps = false;
    protected $guarded = ['id'];
}
