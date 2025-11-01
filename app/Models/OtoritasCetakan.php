<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtoritasCetakan extends Model
{
    use HasFactory;

    protected $table = 'otoritas_cetakan';
    public $timestamps = false;
    protected $guarded = [];
}