<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenThtPemeriksaanFisik extends Model
{
    use HasFactory;
    protected $table = 'RME_ASESMEN_THT_PEMERIKSAAN_FISIK';
    public $timestamps = false;
    protected $guarded = ['id'];
}
