<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsuhanKeperawatan extends Model
{
    use HasFactory;

    protected $table = 'rme_asuhan_keperawatan';
    public $timestamps = false;

    protected $fillable = [
        'kd_pasien',
        'kd_unit',
        'tgl_masuk',
        'urut_masuk',
        'tgl_implementasi',
        'waktu',
        'airway',
        'pernafasan',
        'tanda_vital',
        'nyeri',
        'nutrisi',
        'eliminasi',
        'personal_hygiene',
        'ginekologi',
        'sosial',
        'edukasi',
        'cedera',
        'lainnya',
        'user_create',
        'user_edit',
    ];

    protected $casts = [
        'airway' => 'array',
        'pernafasan' => 'array',
        'tanda_vital' => 'array',
        'nyeri' => 'array',
        'nutrisi' => 'array',
        'eliminasi' => 'array',
        'personal_hygiene' => 'array',
        'ginekologi' => 'array',
        'sosial' => 'array',
        'edukasi' => 'array',
        'cedera' => 'array',
        'lainnya' => 'array',
    ];

    public function userCreate()
    {
        return $this->belongsTo(User::class, 'user_create', 'id');
    }
}