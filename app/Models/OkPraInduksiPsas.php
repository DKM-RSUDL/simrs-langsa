<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OkPraInduksiPsas extends Model
{
    use HasFactory;

    protected $table = 'OK_PRA_INDUKSI_PSAS';
    public $timestamps = false;
    protected $guarded = ['id'];
}
