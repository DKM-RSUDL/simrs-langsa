<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeMonitoringGizi extends Model
{
    use HasFactory;

    protected $table = 'RME_PENGKAJIAN_MONITORING_GIZI';
    public $timestamps = false;

    protected $fillable = [
        'kd_unit',
        'kd_pasien',
        'tgl_masuk',
        'urut_masuk',
        'tanggal_monitoring',
        'ahli_gizi',
        'energi',
        'protein',
        'karbohidrat',
        'lemak',
        'masalah_perkembangan',
        'tindak_lanjut',
        'user_create',
        'user_update'
    ];

    /**
     * Relasi ke model User untuk user yang membuat
     */
    public function userCreator()
    {
        return $this->belongsTo(User::class, 'user_create', 'id');
    }

    // Relasi ke user yang mengupdate
    public function userUpdater()
    {
        return $this->belongsTo(User::class, 'user_update', 'id');
    }


    // Relasi ke ahli gizi
    public function ahliGizi()
    {
        return $this->belongsTo(User::class, 'ahli_gizi', 'id');
    }

    // Accessor untuk format energi
    public function getEnergiFormattedAttribute()
    {
        return number_format($this->energi, 1) . ' Kkal';
    }

    // Accessor untuk format protein
    public function getProteinFormattedAttribute()
    {
        return number_format($this->protein, 1) . ' g';
    }

    // Accessor untuk format karbohidrat
    public function getKarbohidratFormattedAttribute()
    {
        return number_format($this->karbohidrat, 1) . ' g';
    }

    // Accessor untuk format lemak
    public function getLemakFormattedAttribute()
    {
        return number_format($this->lemak, 1) . ' g';
    }

    
}
