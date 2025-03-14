<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenKepPerinatologyPemeriksaanLanjut extends Model
{
    use HasFactory;
    protected $table = 'RME_ASESMEN_KEP_PERINATOLOGY_PEMERIKSAAN_LANJUT';
    public $timestamps = false;

    protected $guarded = ['id'];
}
