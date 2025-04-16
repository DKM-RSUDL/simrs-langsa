<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenKepOphtamology extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_KEP_OPTHAMOLOGY';
    public $timestamps = false;

    protected $guarded = ['id'];
}
