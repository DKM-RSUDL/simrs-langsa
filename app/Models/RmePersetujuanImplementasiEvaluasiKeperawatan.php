<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmePersetujuanImplementasiEvaluasiKeperawatan extends Model
{
    use HasFactory;

    protected $table = 'RME_PERSETUJUAN_IMPLEMENTASI_EVALUASI_KEPERAWATAN';

    public $timestamps = false;
    protected $guarded = ['id'];

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'kd_dokter', 'kd_dokter');
    }

    public function userCreated()
    {
        return $this->belongsTo(User::class, 'user_created', 'id');
    }

    public function userUpdated()
    {
        return $this->belongsTo(User::class, 'user_updated', 'id');
    }
}
