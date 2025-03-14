<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenKepAnakStatusNyeri extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_KEP_ANAK_STATUS_NYERI';
    public $timestamps = false;
    protected $guarded = ['id'];
}
