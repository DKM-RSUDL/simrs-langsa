<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenGinekologikTandaVital extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_GINEKOLOGIK_TANDA_VITAL';
    public $timestamps = false;
    protected $guarded = ['id'];
}
