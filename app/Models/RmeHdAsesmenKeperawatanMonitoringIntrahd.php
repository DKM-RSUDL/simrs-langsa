<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeHdAsesmenKeperawatanMonitoringIntrahd extends Model
{
    use HasFactory;

    protected $table = 'RME_HD_ASESMEN_KEPERAWATAN_MONITORING_INTRAHD';
    public $timestamps = false;

    protected $guarded = ['id'];

    protected $casts = [
        // 'observasi_data' => 'array'
    ];
}
