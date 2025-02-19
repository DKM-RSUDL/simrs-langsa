<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenThtDischargePlanning extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_THT_DISCHARGE_PLANNING';
    public $timestamps = false;
    protected $guarded = ['id'];
}
