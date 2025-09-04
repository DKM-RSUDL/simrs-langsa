<?php
// Model RmeAsesmenMedisRanap.php - Updated

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenMedisRanap extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_MEDIS_RANAP';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = ['id'];

    protected $casts = [
        'tanggal' => 'date',
        'rencana_tgl_pulang' => 'date',
        'sistole' => 'integer',
        'diastole' => 'integer',
        'respirasi' => 'integer',
        'nadi' => 'integer',
        'suhu' => 'float',
        'skala_nyeri_nilai' => 'integer',
        'usia_lanjut' => 'boolean',
        'hambatan_mobilisasi' => 'boolean',
    ];

    public function asesmen()
    {
        return $this->belongsTo(RmeAsesmen::class, 'id_asesmen', 'id');
    }

    public function fisikExamination()
    {
        return $this->hasOne(RmeAsesmenMedisRanapFisik::class, 'id_asesmen_medis_ranap', 'id');
    }

    public function userCreate()
    {
        return $this->belongsTo(User::class, 'user_create', 'id');
    }

    public function userEdit()
    {
        return $this->belongsTo(User::class, 'user_edit', 'id');
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'kd_pasien', 'kd_pasien');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'kd_unit', 'kd_unit');
    }

    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class, function ($query) {
            $query->on('RME_ASESMEN_MEDIS_RANAP.kd_pasien', '=', 'kunjungan.kd_pasien')
                ->on('RME_ASESMEN_MEDIS_RANAP.kd_unit', '=', 'kunjungan.kd_unit')
                ->on('RME_ASESMEN_MEDIS_RANAP.tgl_masuk', '=', 'kunjungan.tgl_masuk')
                ->on('RME_ASESMEN_MEDIS_RANAP.urut_masuk', '=', 'kunjungan.urut_masuk');
        });
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'no_transaksi', 'no_transaksi');
    }

    public function getSkalaNyeriStatusAttribute()
    {
        $nilai = $this->skala_nyeri_nilai ?? 0;

        if ($nilai === 0) {
            return 'Tidak Nyeri';
        } elseif ($nilai >= 1 && $nilai <= 3) {
            return 'Nyeri Ringan';
        } elseif ($nilai >= 4 && $nilai <= 5) {
            return 'Nyeri Sedang';
        } elseif ($nilai >= 6 && $nilai <= 7) {
            return 'Nyeri Berat';
        } elseif ($nilai >= 8 && $nilai <= 9) {
            return 'Nyeri Sangat Berat';
        } else {
            return 'Nyeri Tak Tertahankan';
        }
    }

    public function getRiwayatPenggunaanObatArrayAttribute()
    {
        return $this->riwayat_penggunaan_obat ? json_decode($this->riwayat_penggunaan_obat, true) : [];
    }

    public function getDiagnosisBandingArrayAttribute()
    {
        return $this->diagnosis_banding ? json_decode($this->diagnosis_banding, true) : [];
    }

    public function getDiagnosisKerjaArrayAttribute()
    {
        return $this->diagnosis_kerja ? json_decode($this->diagnosis_kerja, true) : [];
    }

    public function getAlergisArrayAttribute()
    {
        return $this->alergis ? json_decode($this->alergis, true) : [];
    }
    // Scope untuk filter berdasarkan pasien
    public function scopeByPasien($query, $kd_pasien)
    {
        return $query->where('kd_pasien', $kd_pasien);
    }

    public function scopeByUnit($query, $kd_unit)
    {
        return $query->where('kd_unit', $kd_unit);
    }

    public function scopeByTanggal($query, $tgl_masuk)
    {
        return $query->whereDate('tgl_masuk', $tgl_masuk);
    }
}
