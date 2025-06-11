<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeKriteriaMasukNicu extends Model
{
    use HasFactory;

    protected $table = 'RME_KRITERIA_MASUK_NICU';

    public $timestamps = false;

    protected $guarded = ['id'];

    // Relasi dengan dokter
    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'kd_dokter', 'kd_dokter');
    }

    // Relasi dengan user (yang menginput)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_create', 'id');
    }

    // Relasi dengan pasien
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'kd_pasien', 'kd_pasien');
    }

    // Relasi dengan unit
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'kd_unit', 'kd_unit');
    }

    // Scope untuk filter berdasarkan kunjungan
    public function scopeByKunjungan($query, $kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk)
    {
        return $query->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk);
    }
}
