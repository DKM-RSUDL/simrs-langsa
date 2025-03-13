<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenNeurologi extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_NEUROLOGI';
    public $timestamps = false;
    protected $guarded = ['id'];
}
