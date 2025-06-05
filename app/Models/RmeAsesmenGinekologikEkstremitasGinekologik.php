<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenGinekologikEkstremitasGinekologik extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_GINEKOLOGIK_EKSTREMITAS_GINEKOLOGIK';
    public $timestamps = false;
    protected $guarded = ['id'];
}
