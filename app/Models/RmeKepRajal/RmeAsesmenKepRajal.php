<?php

namespace App\Models\RmeKepRajal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RmeKepRajal\RmeAsesmenKepRajalPendidikan;
use App\Models\RmeKepRajal\RmeAsesmenKepRajalDischargePlanning;
class RmeAsesmenKepRajal extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_KEP_RAJAL';
    public $timestamps = false;
    protected $guarded = ['id'];

    protected $casts = [
        'keperawatan_masalah'      => 'array',
        'keperawatan_rencana'      => 'array',
        'waktu_asesmen'  => 'datetime',
    ];

    public function pendidikan() {
        return $this->belongsTo(RmeAsesmenKepRajalPendidikan::class);
    }

    public function dischargePlanning() {
        return $this->belongsTo(RmeAsesmenKepRajalDischargePlanning::class);
    }

    // public function dischargePlanning() {
    //     return $this->belongsTo(RmeAsesmenKepRajalDischargePlanning::class);
    // }
}