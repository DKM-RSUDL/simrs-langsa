<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenObstetriDischargePlanning extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_OBSTETRI_DISCHARGE_PLANNING';
    public $timestamps = false;
    protected $guarded = ['id'];
}
