<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeIntensiveMonitoringTherapy extends Model
{
    use HasFactory;

    protected $table = 'RME_INTENSIVE_MONITORING_THERAPY';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function dose()
    {
        return $this->hasOne(RmeIntensiveMonitoringTherapyDtl::class, 'id_therapy', 'id');
    }
}
