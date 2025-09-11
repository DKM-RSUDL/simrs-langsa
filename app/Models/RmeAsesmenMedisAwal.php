<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenMedisAwal extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_MED_RAJAL';

    public $timestamps = false;

    protected $fillable = [
        'asesmen_id',
        'keluhan_utama',
        'pemeriksaan_fisik',
        'diagnosis',
        'planning',
        'edukasi',
    ];

    public function asesmen()
    {
        return $this->belongsTo(RmeAsesmen::class);
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'kd_dokter', 'KD_DOKTER');
    }

    public function getDiagnosisArrayAttribute()
    {
        return json_decode($this->diagnosis, true) ?? [];
    }

    public function setDiagnosisAttribute($value)
    {
        $this->attributes['diagnosis'] = is_array($value) ? json_encode($value) : $value;
    }
}
