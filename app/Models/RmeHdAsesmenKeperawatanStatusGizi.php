<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeHdAsesmenKeperawatanStatusGizi extends Model
{
    use HasFactory;

    protected $table = 'RME_HD_ASESMEN_KEPERAWATAN_STATUS_GIZI';
    public $timestamps = false;

    protected $guarded = ['id'];
}
