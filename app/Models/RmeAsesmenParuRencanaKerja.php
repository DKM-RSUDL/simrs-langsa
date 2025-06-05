<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenParuRencanaKerja extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_PARU_RENCANA_KERJA';
    public $timestamps = false;
    protected $guarded = ['id'];
}
