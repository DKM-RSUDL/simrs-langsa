<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenMedisAnakFisik extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_MEDIS_ANAK_FISIK';
    public $timestamps = false;
    protected $guarded = ['id'];

    protected $casts = [
        'mata_pucat' => 'boolean',
        'mata_ikterik' => 'boolean',
        'pupil_isokor' => 'boolean',
        'pupil_anisokor' => 'boolean',
        'nafas_cuping' => 'boolean',
        'telinga_cairan' => 'boolean',
        'mulut_sianosis' => 'boolean',
        'leher_kelenjar' => 'boolean',
        'leher_vena' => 'boolean',
        'thoraks_simetris' => 'boolean',
        'thoraks_asimetris' => 'boolean',
        'abdomen_venekasi' => 'boolean',
        'kulit' => 'json',
        'kuku' => 'json'
    ];

    /**
     * Mutator untuk kulit - memastikan format JSON yang benar
     */
    public function setKulitAttribute($value)
    {
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            $this->attributes['kulit'] = json_encode($decoded, JSON_UNESCAPED_UNICODE);
        } elseif (is_array($value)) {
            $this->attributes['kulit'] = json_encode($value, JSON_UNESCAPED_UNICODE);
        } else {
            $this->attributes['kulit'] = null;
        }
    }

    /**
     * Mutator untuk kuku - memastikan format JSON yang benar
     */
    public function setKukuAttribute($value)
    {
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            $this->attributes['kuku'] = json_encode($decoded, JSON_UNESCAPED_UNICODE);
        } elseif (is_array($value)) {
            $this->attributes['kuku'] = json_encode($value, JSON_UNESCAPED_UNICODE);
        } else {
            $this->attributes['kuku'] = null;
        }
    }

    /**
     * Accessor untuk kulit - memastikan return array yang bersih
     */
    public function getKulitAttribute($value)
    {
        if (empty($value)) {
            return [];
        }

        $decoded = json_decode($value, true);
        return json_last_error() === JSON_ERROR_NONE ? $decoded : [];
    }

    /**
     * Accessor untuk kuku - memastikan return array yang bersih
     */
    public function getKukuAttribute($value)
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

    public function asesmenMedisAnak()
    {
        return $this->belongsTo(RmeAsesmenMedisAnak::class, 'id_asesmen_medis_anak', 'id');
    }
}
