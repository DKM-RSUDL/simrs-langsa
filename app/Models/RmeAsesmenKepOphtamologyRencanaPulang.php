<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenKepOphtamologyRencanaPulang extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_KEP_OPTHAMOLOGY_RENCANA_PULANG';
    public $timestamps = false;
    protected $guarded = ['id'];
}
