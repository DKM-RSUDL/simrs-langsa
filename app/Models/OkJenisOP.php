<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OkJenisOP extends Model
{
    use HasFactory;

    protected $table = 'OK_JENIS_OP';
    public $timestamps = false;

    protected $guarded = [];
}