<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeHivArt extends Model
{
    use HasFactory;

    protected $table = 'RME_HIV_ART';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $guarded = ['id'];

    protected $casts = [
        'tgl_masuk' => 'date',
        'tanggal' => 'date',
        'tgl_tes_hiv' => 'date',
        'tgl_mulai_terapi_tb' => 'date',
        'tgl_selesai_terapi_tb' => 'date',
        // **PERBAIKAN: Jangan gunakan cast 'array' untuk JSON, biarkan sebagai string untuk kontrol penuh**
        // 'kia_details' => 'array',
        // 'faktor_risiko' => 'array',
        // 'data_keluarga' => 'array'
    ];

    // Relationships
    public function userCreate()
    {
        return $this->belongsTo(User::class, 'user_create', 'id');
    }

    public function userEdit()
    {
        return $this->belongsTo(User::class, 'user_edit', 'id');
    }

    public function dataPemeriksaanKlinis()
    {
        return $this->hasOne(RmeHivArtDataPemeriksaanKlinis::class, 'id_hiv_art', 'id');
    }

    public function terapiAntiretroviral()
    {
        return $this->hasMany(RmeHivArtTerapiAntiretroviral::class, 'id_hiv_art', 'id');
    }

    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class, 'kd_pasien', 'kd_pasien');
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'kd_pasien', 'kd_pasien');
    }

    // **PERBAIKAN: Accessor yang mengembalikan format JSON bersih**
    public function getKiaDetailsArrayAttribute()
    {
        if (empty($this->kia_details)) {
            return [];
        }

        if (is_string($this->kia_details)) {
            $decoded = json_decode($this->kia_details, true);
            return is_array($decoded) ? $decoded : [];
        }

        return is_array($this->kia_details) ? $this->kia_details : [];
    }

    public function getFaktorRisikoArrayAttribute()
    {
        if (empty($this->faktor_risiko)) {
            return [];
        }

        if (is_string($this->faktor_risiko)) {
            $decoded = json_decode($this->faktor_risiko, true);
            return is_array($decoded) ? $decoded : [];
        }

        return is_array($this->faktor_risiko) ? $this->faktor_risiko : [];
    }

    public function getDataKeluargaArrayAttribute()
    {
        if (empty($this->data_keluarga)) {
            return [];
        }

        if (is_string($this->data_keluarga)) {
            $decoded = json_decode($this->data_keluarga, true);
            return is_array($decoded) ? $decoded : [];
        }

        return is_array($this->data_keluarga) ? $this->data_keluarga : [];
    }

    // **Helper methods untuk mendapatkan text yang mudah dibaca**
    public function getPendidikanTextAttribute()
    {
        $pendidikan = [
            '0' => 'Tidak Sekolah',
            '1' => 'SD',
            '2' => 'SMP',
            '3' => 'SMU',
            '4' => 'Akademi/PT'
        ];

        return $pendidikan[$this->pendidikan] ?? $this->pendidikan;
    }

    public function getPekerjaanTextAttribute()
    {
        $pekerjaan = [
            '0' => 'Tidak Bekerja',
            '1' => 'Bekerja',
            '2' => 'Lainnya'
        ];

        return $pekerjaan[$this->pekerjaan] ?? $this->pekerjaan;
    }

    public function getKlasifikasiTbTextAttribute()
    {
        $klasifikasi = [
            'tb_paru' => 'TB Paru',
            'tb_ekstra_paru' => 'TB Ekstra Paru',
            'tidak_ada' => 'Tidak Ada'
        ];

        return $klasifikasi[$this->klasifikasi_tb] ?? $this->klasifikasi_tb;
    }

    public function getPaduanTbTextAttribute()
    {
        $paduan = [
            'kategori_1' => 'Kategori I',
            'kategori_2' => 'Kategori II',
            'kategori_anak' => 'Kategori Anak',
            'oat_lini_2' => 'OAT Lini 2 (MDR)'
        ];

        return $paduan[$this->paduan_tb] ?? $this->paduan_tb;
    }

    public function getTipeTbTextAttribute()
    {
        $tipe = [
            'baru' => 'Baru',
            'kambuh' => 'Kambuh',
            'default' => 'Default',
            'gagal' => 'Gagal'
        ];

        return $tipe[$this->tipe_tb] ?? $this->tipe_tb;
    }

    public function getIndikasInisiasiArtTextAttribute()
    {
        $indikasi = [
            'penasun' => 'Penasun',
            'lsl' => 'LSL',
            'pasien_ko_infeksi_tb_hiv' => 'Pasien Ko-Infeksi TB-HIV',
            'wps' => 'WPS',
            'waria' => 'Waria',
            'pasien_ko_infeksi_hepatitis_b_hiv' => 'Pasien Ko-Infeksi Hepatitis B-HIV',
            'odha_dengan_pasangan_negatif' => 'ODHA dengan Pasangan Negatif',
            'ibu_hamil' => 'Ibu Hamil',
            'lainnya' => 'Lainnya (Stadium Klinis 3 atau 4 / CD4<350)'
        ];

        return $indikasi[$this->indikasi_inisiasi_art] ?? $this->indikasi_inisiasi_art;
    }

    // **Method untuk debug JSON format**
    public function debugJsonFields()
    {
        return [
            'kia_details_raw' => $this->kia_details,
            'kia_details_decoded' => $this->kia_details_array,
            'faktor_risiko_raw' => $this->faktor_risiko,
            'faktor_risiko_decoded' => $this->faktor_risiko_array,
            'data_keluarga_raw' => $this->data_keluarga,
            'data_keluarga_decoded' => $this->data_keluarga_array,
        ];
    }

    // **Method untuk format ulang JSON yang sudah ada (untuk data lama)**
    public function reformatJsonFields()
    {
        $fieldsToReformat = ['kia_details', 'faktor_risiko', 'data_keluarga'];
        $updated = false;

        foreach ($fieldsToReformat as $field) {
            if (!empty($this->$field) && is_string($this->$field)) {
                $decoded = json_decode($this->$field, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    // Reformat dengan JSON bersih
                    $cleanJson = json_encode($decoded, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                    if ($cleanJson !== $this->$field) {
                        $this->$field = $cleanJson;
                        $updated = true;
                    }
                }
            }
        }

        if ($updated) {
            $this->save();
        }

        return $updated;
    }
}
