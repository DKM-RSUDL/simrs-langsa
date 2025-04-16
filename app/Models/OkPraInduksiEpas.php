<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OkPraInduksiEpas extends Model
{
    use HasFactory;

    protected $table = 'OK_PRA_INDUKSI_EPAS';
    public $timestamps = false;
    protected $guarded = ['id'];
}
