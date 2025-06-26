<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenPraAnestesi extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_PRA_ANESTESI';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function userCreate()
    {
        return $this->belongsTo(User::class, 'user_create', 'id');
    }

    public function rmeAsesmenPraAnestesiRiwayatKeluarga()
    {
        return $this->hasOne(RmeAsesmenPraAnestesiRiwayatKeluarga::class, 'id_asesmen_pra_anestesi', 'id');
    }
    public function rmeAsesmenPraAnestesiRppRml()
    {
        return $this->hasOne(RmeAsesmenPraAnestesiRppRml::class, 'id_asesmen_pra_anestesi', 'id');
    }
    public function rmeAsesmenPraAnestesiKppKs()
    {
        return $this->hasOne(RmeAsesmenPraAnestesiKppKs::class, 'id_asesmen_pra_anestesi', 'id');
    }
    public function rmeAsesmenPraAnestesiKuPfLaboratorium()
    {
        return $this->hasOne(RmeAsesmenPraAnestesiKuPfLaboratorium::class, 'id_asesmen_pra_anestesi', 'id');
    }
    public function rmeAsesmenPraAnestesiDiagnosisPmRtRo()
    {
        return $this->hasOne(RmeAsesmenPraAnestesiDiagnosisPmRtRo::class, 'id_asesmen_pra_anestesi', 'id');
    }
}
