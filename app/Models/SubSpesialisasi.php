<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubSpesialisasi extends Model
{
    use HasFactory;

    protected $table = 'SUB_SPESIALISASI';
    public $timestamps = false;

    protected $guarded = [];
}