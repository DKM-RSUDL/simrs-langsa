<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenMedisAnak extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_MEDIS_ANAK';
    public $timestamps = false;
    protected $guarded = ['id'];

    protected $casts = [
        'vital_sign' => 'json',
        'riwayat_penggunaan_obat' => 'json',
        'riwayat_imunisasi' => 'json',
        'tanggal' => 'date',
    ];

    /**
     * Mutator untuk vital_sign - memastikan format JSON yang benar
     */
    public function setVitalSignAttribute($value)
    {
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            $this->attributes['vital_sign'] = json_encode($decoded, JSON_UNESCAPED_UNICODE);
        } elseif (is_array($value)) {
            $this->attributes['vital_sign'] = json_encode($value, JSON_UNESCAPED_UNICODE);
        } else {
            $this->attributes['vital_sign'] = null;
        }
    }

    /**
     * Mutator untuk riwayat_penggunaan_obat - memastikan format JSON yang benar
     */
    public function setRiwayatPenggunaanObatAttribute($value)
    {
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            $this->attributes['riwayat_penggunaan_obat'] = json_encode($decoded, JSON_UNESCAPED_UNICODE);
        } elseif (is_array($value)) {
            $this->attributes['riwayat_penggunaan_obat'] = json_encode($value, JSON_UNESCAPED_UNICODE);
        } else {
            $this->attributes['riwayat_penggunaan_obat'] = null;
        }
    }

    /**
     * Mutator untuk riwayat_imunisasi - memastikan format JSON yang benar
     */
    public function setRiwayatImunisasiAttribute($value)
    {
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            $this->attributes['riwayat_imunisasi'] = json_encode($decoded, JSON_UNESCAPED_UNICODE);
        } elseif (is_array($value)) {
            $this->attributes['riwayat_imunisasi'] = json_encode($value, JSON_UNESCAPED_UNICODE);
        } else {
            $this->attributes['riwayat_imunisasi'] = null;
        }
    }

    /**
     * Accessor untuk vital_sign - memastikan return array yang bersih
     */
    public function getVitalSignAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        $decoded = json_decode($value, true);
        return json_last_error() === JSON_ERROR_NONE ? $decoded : null;
    }

    /**
     * Accessor untuk riwayat_penggunaan_obat - memastikan return array yang bersih
     */
    public function getRiwayatPenggunaanObatAttribute($value)
    {
        if (empty($value)) {
            return [];
        }

        $decoded = json_decode($value, true);
        return json_last_error() === JSON_ERROR_NONE ? $decoded : [];
    }

    /**
     * Accessor untuk riwayat_imunisasi - memastikan return array yang bersih
     */
    public function getRiwayatImunisasiAttribute($value)
    {
        if (empty($value)) {
            return [];
        }

        $decoded = json_decode($value, true);
        return json_last_error() === JSON_ERROR_NONE ? $decoded : [];
    }

    public function asesmen()
    {
        return $this->belongsTo(RmeAsesmen::class, 'id_asesmen', 'id');
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'no_transaksi', 'no_transaksi');
    }

    public function userCreate()
    {
        return $this->belongsTo(User::class, 'user_create', 'id');
    }

    public function userEdit()
    {
        return $this->belongsTo(User::class, 'user_edit', 'id');
    }

    public function asesmenMedisAnakFisik()
    {
        return $this->hasOne(RmeAsesmenMedisAnakFisik::class, 'id_asesmen_medis_anak', 'id');
    }

    public function asesmenMedisAnakDtl()
    {
        return $this->hasOne(RmeAsesmenMedisAnakDtl::class, 'id_asesmen_medis_anak', 'id');
    }
}
