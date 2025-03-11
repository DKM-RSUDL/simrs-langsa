<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenKepPerinatologyFungsional extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_KEP_PERINATOLOGY_STATUS_FUNGSIONAL';
    public $timestamps = false;
    protected $guarded = ['id'];
}
