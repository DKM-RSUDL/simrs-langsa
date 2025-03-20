<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OkPraInduksi extends Model
{
    use HasFactory;

    protected $table = 'OK_PRA_INDUKSI';
    public $timestamps = false;
    protected $guarded = ['id'];
}
