<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeIntesiveMonitoringDtl extends Model
{
    use HasFactory;

    protected $table = 'RME_INTENSIVE_MONITORING_DTL';
    public $timestamps = false;

    protected $guarded = ['id'];

    public function monitoring()
    {
        return $this->belongsTo(RmeIntesiveMonitoring::class, 'monitoring_id', 'id');
    }
}
