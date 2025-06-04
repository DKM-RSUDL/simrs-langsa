<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenGinekologikPemeriksaanDischarge extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_GINEKOLOGIK_PEMERIKSAAN_DISCHARGE';
    public $timestamps = false;
    protected $guarded = ['id'];
}
