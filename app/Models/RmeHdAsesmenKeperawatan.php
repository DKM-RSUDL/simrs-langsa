<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeHdAsesmenKeperawatan extends Model
{
    use HasFactory;
    protected $table = 'RME_HD_ASESMEN_KEPERAWATAN';
    public $timestamps = false;

    protected $guarded = ['id'];
}
