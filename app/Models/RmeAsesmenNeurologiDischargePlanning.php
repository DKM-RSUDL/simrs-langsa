<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenNeurologiDischargePlanning extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_NEUROLOGI_DISCHARGE_PLANNING';
    public $timestamps = false;
    protected $guarded = ['id'];
}
