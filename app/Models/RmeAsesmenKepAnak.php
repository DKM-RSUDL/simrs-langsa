<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenKepAnak extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_KEP_ANAK';
    public $timestamps = false;
    protected $guarded = ['id'];
}
