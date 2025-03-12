<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenNeurologiIntensitasNyeri extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_NEUROLOGI_INTENSITAS_NYERI';
    public $timestamps = false;
    protected $guarded = ['id'];
}
