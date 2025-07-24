<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeHivArtDataPemeriksaanKlinis extends Model
{
    use HasFactory;

    protected $table = 'RME_HIV_ART_DATA_PEMERIKSAAN_KLINIS';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $guarded = ['id'];

    protected $casts = [
        'kunjungan_pertama_tanggal' => 'date',
        'memenuhi_syarat_tanggal' => 'date',
        'saat_mulai_art_tanggal' => 'date',
        'setelah_6_bulan_tanggal' => 'date',
        'setelah_12_bulan_tanggal' => 'date',
        'setelah_24_bulan_tanggal' => 'date',
        'kunjungan_pertama_bb' => 'decimal:2',
        'memenuhi_syarat_bb' => 'decimal:2',
        'saat_mulai_art_bb' => 'decimal:2',
        'setelah_6_bulan_bb' => 'decimal:2',
        'setelah_12_bulan_bb' => 'decimal:2',
        'setelah_24_bulan_bb' => 'decimal:2',
        'kunjungan_pertama_cd4' => 'integer',
        'memenuhi_syarat_cd4' => 'integer',
        'saat_mulai_art_cd4' => 'integer',
        'setelah_6_bulan_cd4' => 'integer',
        'setelah_12_bulan_cd4' => 'integer',
        'setelah_24_bulan_cd4' => 'integer'
    ];

    // Relationships
    public function hivArt()
    {
        return $this->belongsTo(RmeHivArt::class, 'id_hiv_art', 'id');
    }

    // Helper methods for getting status functional text
    public function getStatusFungsionalText($value)
    {
        $status = [
            '1' => 'Kerja',
            '2' => 'Ambulatori',
            '3' => 'Baring'
        ];

        return $status[$value] ?? $value;
    }

    // Accessor untuk format status fungsional
    public function getKunjunganPertamaStatusFungsionalTextAttribute()
    {
        return $this->getStatusFungsionalText($this->kunjungan_pertama_status_fungsional);
    }

    public function getMemenuhiSyaratStatusFungsionalTextAttribute()
    {
        return $this->getStatusFungsionalText($this->memenuhi_syarat_status_fungsional);
    }

    public function getSaatMulaiArtStatusFungsionalTextAttribute()
    {
        return $this->getStatusFungsionalText($this->saat_mulai_art_status_fungsional);
    }

    public function getSetelah6BulanStatusFungsionalTextAttribute()
    {
        return $this->getStatusFungsionalText($this->setelah_6_bulan_status_fungsional);
    }

    public function getSetelah12BulanStatusFungsionalTextAttribute()
    {
        return $this->getStatusFungsionalText($this->setelah_12_bulan_status_fungsional);
    }

    public function getSetelah24BulanStatusFungsionalTextAttribute()
    {
        return $this->getStatusFungsionalText($this->setelah_24_bulan_status_fungsional);
    }
}
