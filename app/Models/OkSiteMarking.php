<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OkSiteMarking extends Model
{
    use HasFactory;

    protected $table = 'OK_SITE_MARKING';
    public $timestamps = false;
    protected $guarded = ['id'];

    // Relasi dengan Dokter
    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class, ['kd_pasien', 'tgl_masuk', 'urut_masuk']);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_create');
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'kd_dokter', 'kd_dokter');
    }
}
