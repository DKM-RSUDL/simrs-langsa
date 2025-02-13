<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendidikan extends Model
{
    use HasFactory;

    protected $table = 'PENDIDIKAN';
    public $timestamps = false;

    protected $guarded = ['KD_PENDIDIKAN'];
}
