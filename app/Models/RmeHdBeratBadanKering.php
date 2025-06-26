<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeHdBeratBadanKering extends Model
{
    use HasFactory;

    protected $table = 'RME_HD_BERAT_BADAN_KERING';
    public $timestamps = false;

    protected $fillable = [
        'kd_pasien',
        'tgl_masuk',
        'urut_masuk',
        'kd_unit',
        'tahun',
        'bulan',
        'mulai_hd',
        'bbk',
        'berat_badan',
        'tinggi_badan',
        'imt',
        'selisih_bbk',
        'catatan',
        'user_created',
        'user_updated'
    ];

    // Relasi ke user yang membuat
    public function userCreated()
    {
        return $this->belongsTo(User::class, 'user_created', 'id');
    }

    // Relasi ke user yang mengupdate
    public function userUpdated()
    {
        return $this->belongsTo(User::class, 'user_updated', 'id');
    }

    protected $casts = [
        'mulai_hd' => 'date',
        'bbk' => 'decimal:1',
        'berat_badan' => 'decimal:1',
        'tinggi_badan' => 'decimal:1',
        'imt' => 'decimal:1',
        'selisih_bbk' => 'decimal:1'
    ];

    // Accessor untuk nama bulan
    public function getNamaBulanAttribute()
    {
        $bulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        return $bulan[$this->bulan] ?? 'Tidak diketahui';
    }

    // Accessor untuk status IMT
    public function getStatusImtAttribute()
    {
        if ($this->imt < 18.5) {
            return 'Kurus';
        } elseif ($this->imt < 25) {
            return 'Normal';
        } elseif ($this->imt < 30) {
            return 'Overweight';
        } else {
            return 'Obesitas';
        }
    }

    // Accessor untuk warna status IMT
    public function getWarnaImtAttribute()
    {
        if ($this->imt < 18.5) {
            return 'info';
        } elseif ($this->imt < 25) {
            return 'success';
        } elseif ($this->imt < 30) {
            return 'warning';
        } else {
            return 'danger';
        }
    }

    // Accessor untuk status selisih BBK
    public function getStatusSelisihAttribute()
    {
        if ($this->selisih_bbk > 0) {
            return 'Kelebihan';
        } elseif ($this->selisih_bbk < 0) {
            return 'Kekurangan';
        } else {
            return 'Sesuai Target';
        }
    }

    // Accessor untuk warna status selisih
    public function getWarnaSelisihAttribute()
    {
        if ($this->selisih_bbk > 0) {
            return 'warning';
        } elseif ($this->selisih_bbk < 0) {
            return 'info';
        } else {
            return 'success';
        }
    }
}
