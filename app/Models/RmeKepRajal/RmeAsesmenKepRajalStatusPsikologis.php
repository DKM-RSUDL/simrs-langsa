<?php

namespace App\Models\RmeKepRajal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenKepRajalStatusPsikologis extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_KEP_RAJAL_STATUS_PSIKOLOGIS';
    public $timestamps = false;
    protected $guarded = ['id'];
}
