<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenObstetri extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_OBSTETRI';
    public $timestamps = false;
    protected $guarded = ['id'];
}
