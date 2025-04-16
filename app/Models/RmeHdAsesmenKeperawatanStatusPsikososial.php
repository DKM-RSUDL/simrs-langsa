<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeHdAsesmenKeperawatanStatusPsikososial extends Model
{
    use HasFactory;

    protected $table = 'RME_HD_ASESMEN_KEPERAWATAN_STATUS_PSIKOSOSIAL';
    public $timestamps = false;

    protected $guarded = ['id'];
}
