<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenNeurologiSistemSyaraf extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_NEUROLOGI_SISTEM_SYARAF';
    public $timestamps = false;
    protected $guarded = ['id'];
}
