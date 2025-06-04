<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenKulitKelamin extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_KULIT_KELAMIN';
    public $timestamps = false;
    protected $guarded = ['id'];
}
