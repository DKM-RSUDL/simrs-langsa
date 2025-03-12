<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenKepPerinatologyGizi extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_KEP_PERINATOLOGY_GIZI';
    public $timestamps = false;
    protected $guarded = ['id'];
}
