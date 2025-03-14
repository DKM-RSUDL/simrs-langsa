<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenKepPerinatologyFisik extends Model
{
    use HasFactory;
    protected $table = 'RME_ASESMEN_KEP_PERINATOLOGY_FISIK';
    public $timestamps = false;

    protected $guarded = ['id'];
}
