<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenKepUmumGizi extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_KEP_UMUM_GIZI';
    public $timestamps = false;

    protected $guarded = ['id'];
}
