<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeIntesiveMonitoring extends Model
{
    use HasFactory;

    protected $table = 'RME_INTENSIVE_MONITORING';
    public $timestamps = false;

    protected $guarded = ['id'];

    public function detail()
    {
        return $this->hasOne(RmeIntesiveMonitoringDtl::class, 'monitoring_id');
    }

    // Relationship with user who created this record
    public function userCreator()
    {
        return $this->belongsTo(User::class, 'user_create');
    }

    // Relationship with user who edited this record
    public function userEditor()
    {
        return $this->belongsTo(User::class, 'user_edit');
    }

    public function therapyDoses()
    {
        return $this->hasMany(RmeIntensiveMonitoringTherapyDtl::class, 'id_monitoring', 'id');
    }
}
