<?php

namespace App\Models\RmeKepRajal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenKepRajalRisikoJatuh extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_KEP_RAJAL_RISIKO_JATUH';
    public $timestamps = false;
    protected $guarded = ['id'];
}
