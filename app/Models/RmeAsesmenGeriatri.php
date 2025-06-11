<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenGeriatri extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_GERIATRI';
    public $timestamps = false;
    protected $guarded = ['id'];
}
