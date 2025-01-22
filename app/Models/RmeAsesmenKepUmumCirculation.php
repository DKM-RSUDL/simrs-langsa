<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenKepUmumCirculation extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_KEP_UMUM_CIRCULATION';
    public $timestamps = false;

    protected $guarded = ['id'];
}
