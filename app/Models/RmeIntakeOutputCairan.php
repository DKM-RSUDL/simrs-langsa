<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeIntakeOutputCairan extends Model
{
    use HasFactory;

    protected $table = 'rme_intake_output_cairan';
    public $timestamps = false;
    protected $guarded = ['id'];
}