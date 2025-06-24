<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenGiziAnak extends Model
{
    use HasFactory;

    protected $table = 'RME_PENGKAJIAN_GIZI_ANAK_DTL';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function pengkajianGizi()
    {
        return $this->belongsTo(RmePengkajianGiziAnak::class, 'id_gizi', 'id');
    }

    public function getFormattedBeratBadanAttribute()
    {
        return $this->berat_badan ? $this->berat_badan . ' kg' : '-';
    }

    public function getFormattedTinggiBadanAttribute()
    {
        return $this->tinggi_badan ? $this->tinggi_badan . ' cm' : '-';
    }

    public function getFormattedImtAttribute()
    {
        return $this->imt ? number_format($this->imt, 2) : '-';
    }

    public function getFormattedBbiAttribute()
    {
        return $this->bbi ? $this->bbi . ' kg' : '-';
    }

    /**
     * Accessor untuk format lingkar kepala
     */
    public function getFormattedLingkarKepalaAttribute()
    {
        return $this->lingkar_kepala ? $this->lingkar_kepala . ' cm' : '-';
    }

    /**
     * Scope untuk filter berdasarkan status gizi
     */
    public function scopeByStatusGizi($query, $status)
    {
        return $query->where('status_gizi', $status);
    }

    /**
     * Scope untuk filter berdasarkan rentang IMT
     */
    public function scopeByImtRange($query, $min, $max)
    {
        return $query->whereBetween('imt', [$min, $max]);
    }

}
