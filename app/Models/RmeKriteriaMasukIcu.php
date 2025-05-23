<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeKriteriaMasukIcu extends Model
{
    use HasFactory;

    protected $table = 'RME_KRITERIA_MASUK_ICU';
    public $timestamps = false;

    protected $guarded = ['id'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_create', 'id');
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'kd_dokter', 'kd_dokter');
    }
}
