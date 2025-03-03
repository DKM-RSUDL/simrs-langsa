<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenKepPerinatologyRiwayatIbu extends Model
{
    use HasFactory;
    protected $table = 'RME_ASESMEN_KEP_PERINATOLOGY_RIWAYAT_IBU';
    public $timestamps = false;

    protected $guarded = ['id'];
}
