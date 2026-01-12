<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SatsetPrognosis extends Model
{
    use HasFactory;

    protected $table = 'SATSET_PROGNOSIS';
    public $timestamps = false;

    protected $guarded = ['SatsetPrognosis'];
}
