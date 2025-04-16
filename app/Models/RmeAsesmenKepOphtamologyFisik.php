<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenKepOphtamologyFisik extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_KEP_OPTHAMOLOGY_FISIK';
    public $timestamps = false;

    protected $guarded = ['id'];
}
