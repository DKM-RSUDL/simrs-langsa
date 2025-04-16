<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenKepUmumRencanaPulang extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_KEP_UMUM_RENCANA_PULANG';
    public $timestamps = false;

    protected $guarded = ['id'];
}
