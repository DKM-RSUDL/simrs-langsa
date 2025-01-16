<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenKepUmumBreathing extends Model
{
    use HasFactory;
    protected $table = 'RME_ASESMEN_KEP_UMUM_BREATHING';
    public $timestamps = false;

    protected $guarded = ['id'];
}
