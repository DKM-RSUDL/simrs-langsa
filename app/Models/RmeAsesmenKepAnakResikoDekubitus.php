<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenKepAnakResikoDekubitus extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_KEP_ANAK_RISIKO_DEKUBITUS';
    public $timestamps = false;
    protected $guarded = ['id'];
}
