<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenTht extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_THT';
    public $timestamps = false;
    protected $guarded = ['id'];
}
