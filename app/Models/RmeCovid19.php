<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class RmeCovid19 extends Model
{
    use HasFactory;

    protected $table = 'RME_COVID_19';
    public $timestamps = false;
    protected $guarded = ['id'];

    protected $casts = [
        'tanggal' => 'date',
        'tgl_gejala' => 'date',
        'tgl_lahir_keluarga' => 'date',
        'tgl_lahir_saksi1' => 'date',
    ];

    // Relationships
    public function userCreate()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_create', 'id');
    }

    public function userEdit()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_edit', 'id');
    }

    public function dokter()
    {
        return $this->belongsTo(\App\Models\Dokter::class, 'dokter', 'kd_dokter');
    }

    public function kunjungan()
    {
        return $this->belongsTo(\App\Models\Kunjungan::class, 'kd_pasien', 'kd_pasien')
            ->where('kd_unit', $this->kd_unit)
            ->whereDate('tgl_masuk', $this->tgl_masuk)
            ->where('urut_masuk', $this->urut_masuk);
    }

    // Accessors
    public function getTanggalFormattedAttribute()
    {
        try {
            return $this->tanggal ? $this->tanggal->format('d/m/Y') : '-';
        } catch (\Exception $e) {
            return '-';
        }
    }

    public function getJamFormattedAttribute()
    {
        return $this->jam ? date('H:i', strtotime($this->jam)) : '-';
    }

    // public function getJamFormattedAttribute()
    // {
    //     try {
    //         if (!$this->jam) return '-';

    //         // Handle different time formats
    //         if (strlen($this->jam) === 8) {
    //             // Format H:i:s
    //             return Carbon::createFromFormat('H:i:s', $this->jam)->format('H:i');
    //         } elseif (strlen($this->jam) === 5) {
    //             // Format H:i
    //             return Carbon::createFromFormat('H:i', $this->jam)->format('H:i');
    //         }

    //         return $this->jam;
    //     } catch (\Exception $e) {
    //         return $this->jam ?? '-';
    //     }
    // }

    public function getGejalaDecodedAttribute()
    {
        try {
            if (!$this->gejala || $this->gejala === '[]' || $this->gejala === 'null') return [];

            $decoded = json_decode($this->gejala, true);

            // Check for JSON decode errors
            if (json_last_error() !== JSON_ERROR_NONE) {
                return [];
            }

            return is_array($decoded) ? $decoded : [];
        } catch (\Exception $e) {
            return [];
        }
    }

    public function getFaktorRisikoDecodedAttribute()
    {
        try {
            if (!$this->faktor_risiko || $this->faktor_risiko === '[]' || $this->faktor_risiko === 'null') return [];

            $decoded = json_decode($this->faktor_risiko, true);

            // Check for JSON decode errors
            if (json_last_error() !== JSON_ERROR_NONE) {
                return [];
            }

            return is_array($decoded) ? $decoded : [];
        } catch (\Exception $e) {
            return [];
        }
    }

    public function getKomorbidDecodedAttribute()
    {
        try {
            if (!$this->komorbid || $this->komorbid === '[]' || $this->komorbid === 'null') return [];

            $decoded = json_decode($this->komorbid, true);

            // Check for JSON decode errors
            if (json_last_error() !== JSON_ERROR_NONE) {
                return [];
            }

            return is_array($decoded) ? $decoded : [];
        } catch (\Exception $e) {
            return [];
        }
    }

    public function getGejalaListAttribute()
    {
        $gejala = $this->gejala_decoded;
        if (empty($gejala)) return [];

        $gejalaLabels = [
            'demam' => 'Demam (≥ 38° C) / Riwayat demam',
            'ispa' => 'Batuk/Pilek/Nyeri tenggorokan/Sesak Nafas (ISPA)',
            'sakit_kepala' => 'Sakit kepala/ Lemah (Malaise)/ Nyeri otot',
            'ispa_berat' => 'ISPA Berat/ Pneumonia Berat',
            'gejala_lain' => 'Gejala lainnya (Gangguan penciuman/pengecapan/Mual/Muntah/Nyeri perut/Diare)',
        ];

        $result = [];
        foreach ($gejala as $key => $value) {
            if (($value == 1 || $value === true || $value === '1') && isset($gejalaLabels[$key])) {
                $result[] = $gejalaLabels[$key];
            }
        }

        return $result;
    }

    public function getFaktorRisikoListAttribute()
    {
        $faktorRisiko = $this->faktor_risiko_decoded;
        if (empty($faktorRisiko)) return [];

        $risikoLabels = [
            'perjalanan' => 'Riwayat perjalanan/tinggal di daerah transmisi lokal dalam < 14 hari terakhir',
            'kontak_erat' => 'Kontak erat dengan kasus konfirmasi/Suspek/Probable COVID-19 dalam 14 hari terakhir',
        ];

        $result = [];
        foreach ($faktorRisiko as $key => $value) {
            if (($value == 1 || $value === true || $value === '1') && isset($risikoLabels[$key])) {
                $result[] = $risikoLabels[$key];
            }
        }

        return $result;
    }

    public function getKomorbidListAttribute()
    {
        $komorbid = $this->komorbid_decoded;
        if (empty($komorbid)) return [];

        $komorbidLabels = [
            'hipertensi' => 'Hipertensi',
            'diabetes' => 'Diabetes Mellitus',
            'jantung' => 'Jantung',
            'ginjal' => 'Ginjal',
            'hemodialisis' => 'Riwayat hemodialisis',
            'usia_50' => 'Usia > 50 Tahun',
        ];

        $result = [];
        foreach ($komorbid as $key => $value) {
            if (($value == 1 || $value === true || $value === '1') && isset($komorbidLabels[$key])) {
                $result[] = $komorbidLabels[$key];
            }
        }

        return $result;
    }

    public function getKesimpulanBadgeAttribute()
    {
        switch ($this->kesimpulan) {
            case 'kontak_erat':
                return '<span class="badge bg-warning">Kontak Erat</span>';
            case 'suspek':
                return '<span class="badge bg-danger">Suspek</span>';
            case 'non_suspek':
                return '<span class="badge bg-success">Non Suspek</span>';
            default:
                return '<span class="badge bg-secondary">-</span>';
        }
    }

    public function getPersetujuanUntukBadgeAttribute()
    {
        switch ($this->persetujuan_untuk) {
            case 'diri_sendiri':
                return '<span class="badge bg-info">Diri Sendiri</span>';
            case 'keluarga':
                return '<span class="badge bg-warning">Keluarga/Wali</span>';
            default:
                return '<span class="badge bg-secondary">-</span>';
        }
    }

    public function getJenisKelaminKeluargaAttribute()
    {
        if (is_null($this->jk_keluarga)) return '-';
        return $this->jk_keluarga == 1 ? 'Laki-laki' : 'Perempuan';
    }

    public function getJenisKelaminSaksi1Attribute()
    {
        if (is_null($this->jk_saksi1)) return '-';
        return $this->jk_saksi1 == 1 ? 'Laki-laki' : 'Perempuan';
    }

    // Scopes
    public function scopeByPatient($query, $kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk)
    {
        return $query->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk);
    }

    public function scopeSearch($query, $search)
    {
        if (!$search) return $query;

        return $query->where(function ($q) use ($search) {
            $q->where('gejala', 'LIKE', "%{$search}%")
                ->orWhere('faktor_risiko', 'LIKE', "%{$search}%")
                ->orWhere('komorbid', 'LIKE', "%{$search}%")
                ->orWhere('kesimpulan', 'LIKE', "%{$search}%")
                ->orWhere('nama_keluarga', 'LIKE', "%{$search}%")
                ->orWhere('nama_saksi1', 'LIKE', "%{$search}%");

            // Only add dokter relationship if it exists
            if (method_exists($this, 'dokter')) {
                $q->orWhereHas('dokter', function ($dokterQuery) use ($search) {
                    $dokterQuery->where('nama_lengkap', 'LIKE', "%{$search}%");
                });
            }

            // Only add userCreate relationship if it exists
            if (method_exists($this, 'userCreate')) {
                $q->orWhereHas('userCreate', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'LIKE', "%{$search}%");
                });
            }
        });
    }

    public function scopeDateRange($query, $startDate, $endDate)
    {
        if ($startDate) {
            $query->whereDate('tanggal', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('tanggal', '<=', $endDate);
        }

        return $query;
    }
}
