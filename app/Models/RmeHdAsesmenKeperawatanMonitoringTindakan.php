<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeHdAsesmenKeperawatanMonitoringTindakan extends Model
{
    use HasFactory;

    protected $table = 'RME_HD_ASESMEN_KEPERAWATAN_MONITORING_TINDAKAN';
    public $timestamps = false;

    protected $guarded = ['id'];
}
