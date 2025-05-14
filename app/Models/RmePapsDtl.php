<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmePapsDtl extends Model
{
    use HasFactory;

    protected $table = 'RME_PAPS_DTL';
    public $timestamps = false;
    protected $guarded = ['id'];
}
