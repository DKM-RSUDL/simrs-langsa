<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeIntensiveMonitoringTherapyDtl extends Model
{
    use HasFactory;

    protected $table = 'RME_INTENSIVE_MONITORING_THERAPY_DTL';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function monitoring()
    {
        return $this->belongsTo(RmeIntesiveMonitoring::class, 'id_monitoring', 'id');
    }

    public function therapy()
    {
        // 'id_therapy' adalah foreign key di tabel ini
        // 'id' adalah primary key di RmeIntensiveMonitoringTherapy
        return $this->belongsTo(RmeIntensiveMonitoringTherapy::class, 'id_therapy', 'id');
    }
}
