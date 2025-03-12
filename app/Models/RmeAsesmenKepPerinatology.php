<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenKepPerinatology extends Model
{
    use HasFactory;
    protected $table = 'RME_ASESMEN_KEP_PERINATOLOGY';
    public $timestamps = false;

    protected $guarded = ['id'];
}
