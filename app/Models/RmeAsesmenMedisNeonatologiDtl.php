<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenMedisNeonatologiDtl extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_MEDIS_NEONATOLOGI_DTL';
    public $timestamps = false;
    protected $guarded = ['id'];

    protected $casts = [
        'cara_persalinan' => 'json',
        'faktor_resiko_mayor' => 'json',
        'faktor_resiko_minor' => 'json',
        'diagnosis_banding' => 'json',
        'diagnosis_kerja' => 'json',
    ];

    public function userCreate()
    {
        return $this->belongsTo(User::class, 'user_create', 'id');
    }
    public function userEdit()
    {
        return $this->belongsTo(User::class, 'user_create', 'id');
    }

    public function asesmenMedisNeonatologi()
    {
        return $this->belongsTo(RmeAsesmenMedisNeonatologi::class, 'id_asesmen_medis_neonatologi', 'id');
    }

    // Accessors & Mutators
    public function getCaraPersalinanAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    public function setCaraPersalinanAttribute($value)
    {
        $this->attributes['cara_persalinan'] = is_array($value) ? json_encode($value) : $value;
    }

    public function getFaktorResikoMayorAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    public function setFaktorResikoMayorAttribute($value)
    {
        $this->attributes['faktor_resiko_mayor'] = is_array($value) ? json_encode($value) : $value;
    }

    public function getFaktorResikoMinorAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    public function setFaktorResikoMinorAttribute($value)
    {
        $this->attributes['faktor_resiko_minor'] = is_array($value) ? json_encode($value) : $value;
    }

    public function getDiagnosisBandingAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    public function setDiagnosisBandingAttribute($value)
    {
        $this->attributes['diagnosis_banding'] = is_array($value) ? json_encode($value) : $value;
    }

    public function getDiagnosisKerjaAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    public function setDiagnosisKerjaAttribute($value)
    {
        $this->attributes['diagnosis_kerja'] = is_array($value) ? json_encode($value) : $value;
    }

    public function getEdukasiAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    public function setEdukasiAttribute($value)
    {
        $this->attributes['edukasi'] = is_array($value) ? json_encode($value) : $value;
    }
}
