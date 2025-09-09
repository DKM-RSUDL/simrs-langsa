<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenMedisNeonatologiFisikGeneralis extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_MEDIS_NEONATOLOGI_FISIK_GENERALIS';
    public $timestamps = false;
    protected $guarded = ['id'];

    protected $casts = [
        'thoraks_bentuk' => 'json',
        'abdomen_tali_pusat' => 'json',
        'plantar_creases' => 'json',
        'kulit' => 'json',
        'kuku' => 'json',
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

    // Accessors
    public function getThoraksBentukAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    public function setThoraksBentukAttribute($value)
    {
        $this->attributes['thoraks_bentuk'] = is_array($value) ? json_encode($value) : $value;
    }

    public function getAbdomenTaliPusatAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    public function setAbdomenTaliPusatAttribute($value)
    {
        $this->attributes['abdomen_tali_pusat'] = is_array($value) ? json_encode($value) : $value;
    }

    public function getPlantarCreasesAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    public function setPlantarCreasesAttribute($value)
    {
        $this->attributes['plantar_creases'] = is_array($value) ? json_encode($value) : $value;
    }

    public function getKulitAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    public function setKulitAttribute($value)
    {
        $this->attributes['kulit'] = is_array($value) ? json_encode($value) : $value;
    }

    public function getKukuAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    public function setKukuAttribute($value)
    {
        $this->attributes['kuku'] = is_array($value) ? json_encode($value) : $value;
    }
}
