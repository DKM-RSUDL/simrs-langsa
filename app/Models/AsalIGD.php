<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsalIGD extends Model
{
    use HasFactory;

    protected $table = 'asal_igd';
    public $timestamps = false;
    protected $guarded = ['id'];
}
