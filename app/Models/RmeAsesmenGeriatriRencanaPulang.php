<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenGeriatriRencanaPulang extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_GERIATRI_RENCANA_PULANG';
    public $timestamps = false;
    protected $guarded = ['id'];
}
