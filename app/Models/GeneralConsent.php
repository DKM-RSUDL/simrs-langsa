<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralConsent extends Model
{
    use HasFactory;
    protected $table = 'dkm_general_consent';

    protected $fillable = [
        'kd_pasien',
        'kd_unit',
        'tgl_masuk',
        'urut_masuk',
        'tanggal', 
        'jam',
        'pj_nama',
        'pj_tgl_lahir',
        'pj_nohp',
        'pj_alamat',
        'pj_hubungan_pasien',
        'saksi_nama',
        'saksi_tgl_lahir',
        'saksi_nohp',
        'saksi_alamat',
        'saksi_hubungan_pasien',
        'setuju_perawatan',
        'setuju_barang',
        'info_nama_1',
        'info_hubungan_pasien_1',
        'info_nama_2',
        'info_hubungan_pasien_2',
        'info_nama_3',
        'info_hubungan_pasien_3',
        'setuju_hak',
        'setuju_akses_privasi',
        'akses_privasi_keterangan',
        'setuju_privasi_khusus',
        'privasi_khusus_keterangan',
        'rawat_inap_keterangan',
        'biaya_status',
        'biaya_setuju',
        'id_user',
        'ttd_petugas',
        'ttd_pj',
        'ttd_saksi'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    /**
     * Get relationship name from ID
     */
    public function getRelationshipName($relationshipId)
    {
        $relationships = [
            0 => 'Diri Sendiri',
            1 => 'Orang Tua',
            2 => 'Anak',
            3 => 'Saudara Kandung',
            4 => 'Suami',
            5 => 'Istri',
            6 => 'Kakek',
            7 => 'Nenek',
            8 => 'Cucu',
            9 => 'Lainnya'
        ];

        return $relationships[$relationshipId] ?? '-';
    }

    /**
     * Get PJ relationship name
     */
    public function getPjHubunganPasienNameAttribute()
    {
        return $this->getRelationshipName($this->pj_hubungan_pasien);
    }

    /**
     * Get Saksi relationship name
     */
    public function getSaksiHubunganPasienNameAttribute()
    {
        return $this->getRelationshipName($this->saksi_hubungan_pasien);
    }

    /**
     * Get Info relationship name 1
     */
    public function getInfoHubunganPasien1NameAttribute()
    {
        return $this->getRelationshipName($this->info_hubungan_pasien_1);
    }

    /**
     * Get Info relationship name 2
     */
    public function getInfoHubunganPasien2NameAttribute()
    {
        return $this->getRelationshipName($this->info_hubungan_pasien_2);
    }

    /**
     * Get Info relationship name 3
     */
    public function getInfoHubunganPasien3NameAttribute()
    {
        return $this->getRelationshipName($this->info_hubungan_pasien_3);
    }
}
