<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenKepOphtamologyStatusNyeri extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_KEP_OPTHAMOLOGY_STATUS_NYERI';
    public $timestamps = false;
    protected $guarded = ['id'];
}
