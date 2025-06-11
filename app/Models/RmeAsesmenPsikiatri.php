<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenPsikiatri extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_PSIKIATRI';
    public $timestamps = false;
    protected $guarded = ['id'];
    
}
