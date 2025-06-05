<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenParuPerencanaanPulang extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_PARU_PERENCANAAN_PULANG';
    public $timestamps = false;
    protected $guarded = ['id'];
}
