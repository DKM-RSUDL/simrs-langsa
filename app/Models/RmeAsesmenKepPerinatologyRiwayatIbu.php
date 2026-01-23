<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenKepPerinatologyRiwayatIbu extends Model
{
    use HasFactory;
    protected $table = 'RME_ASESMEN_KEP_PERINATOLOGY_RIWAYAT_IBU';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function getTempatPemeriksaanAttribute($value)
    {
        $map = [
            'puskesmas'      => 'Puskesmas',
            'rumah_sakit'    => 'Rumah Sakit',
            'klinik'         => 'Klinik',
            'dokter_praktek' => 'Dokter Praktek',
            'bidan'          => 'Bidan',
        ];

        return $map[$value] ?? ($value ? ucwords(str_replace('_', ' ', $value)) : '-');
    }

    public function getPemeriksaanKehamilanAttribute($value)
    {
        return $value ? ucfirst($value) : '-';
    }

    public function getCaraPersalinanAttribute($value)
    {
        return $value ? ucfirst($value) : '-';
    }
}
