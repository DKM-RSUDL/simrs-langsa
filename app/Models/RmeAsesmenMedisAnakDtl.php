<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenMedisAnakDtl extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_MEDIS_ANAK_DTL';
    public $timestamps = false;
    protected $guarded = ['id'];

    protected $casts = [
        'tanggal_dirawat' => 'date',
        'rencana_tgl_pulang' => 'date',
        'komplikasi' => 'boolean',
        'maternal' => 'boolean',
        'persalinan' => 'boolean',
        'penyulit_persalinan' => 'boolean',
        'lainnya_sebukan' => 'boolean',
        'prematur_aterm' => 'boolean',
        'kmk_smk_bmk' => 'boolean',
        'pasca_nicu' => 'boolean',
        'pernah_dirawat' => 'boolean',
        'diagnosis_banding' => 'json',
        'diagnosis_kerja' => 'json',
    ];

    /**
     * Mutator untuk diagnosis_banding - memastikan format JSON yang benar
     */
    public function setDiagnosisBandingAttribute($value)
    {
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            $this->attributes['diagnosis_banding'] = json_encode($decoded, JSON_UNESCAPED_UNICODE);
        } elseif (is_array($value)) {
            $this->attributes['diagnosis_banding'] = json_encode($value, JSON_UNESCAPED_UNICODE);
        } else {
            $this->attributes['diagnosis_banding'] = null;
        }
    }

    /**
     * Mutator untuk diagnosis_kerja - memastikan format JSON yang benar
     */
    public function setDiagnosisKerjaAttribute($value)
    {
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            $this->attributes['diagnosis_kerja'] = json_encode($decoded, JSON_UNESCAPED_UNICODE);
        } elseif (is_array($value)) {
            $this->attributes['diagnosis_kerja'] = json_encode($value, JSON_UNESCAPED_UNICODE);
        } else {
            $this->attributes['diagnosis_kerja'] = null;
        }
    }

    /**
     * Accessor untuk diagnosis_banding - memastikan return array yang bersih
     */
    public function getDiagnosisBandingAttribute($value)
    {
        if (empty($value)) {
            return [];
        }

        $decoded = json_decode($value, true);
        return json_last_error() === JSON_ERROR_NONE ? $decoded : [];
    }

    /**
     * Accessor untuk diagnosis_kerja - memastikan return array yang bersih
     */
    public function getDiagnosisKerjaAttribute($value)
    {
        if (empty($value)) {
            return [];
        }

        $decoded = json_decode($value, true);
        return json_last_error() === JSON_ERROR_NONE ? $decoded : [];
    }

    public function userCreate()
    {
        return $this->belongsTo(User::class, 'user_create', 'id');
    }

    public function userEdit()
    {
        return $this->belongsTo(User::class, 'user_edit', 'id');
    }

    public function asesmen()
    {
        return $this->belongsTo(RmeAsesmen::class, 'id_asesmen', 'id');
    }
    public function asesmenMedisAnak()
    {
        return $this->belongsTo(RmeAsesmenMedisAnak::class, 'id_asesmen_medis_anak', 'id');
    }
}
