<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmePengkajianIntervensiGiziDewasa extends Model
{
    use HasFactory;

    protected $table = 'RME_PENGKAJIAN_INTERVENSI_GIZI_DEWASA';
    public $timestamps = false;
    protected $guarded = ['id'];
}
