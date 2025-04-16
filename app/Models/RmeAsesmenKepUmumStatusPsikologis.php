<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenKepUmumStatusPsikologis extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_KEP_UMUM_STATUS_PSIKOLOGIS';
    public $timestamps = false;

    protected $guarded = ['id'];
}
