<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeHdTindakanKhusus extends Model
{
    use HasFactory;

    protected $table = 'RME_HD_TINDAKAN_KHUSUS';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function userCreate()
    {
        return $this->belongsTo(User::class, 'user_create', 'id');
    }

    /**
     * Scope untuk filter berdasarkan pasien
     */
    public function scopeByPasien($query, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        return $query->where('kd_pasien', $kd_pasien)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk);
    }

    /**
     * Scope untuk pencarian
     */
    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where(function ($q) use ($search) {
                $q->where('diagnosis', 'like', "%{$search}%")
                    ->orWhere('obat_tindakan', 'like', "%{$search}%")
                    ->orWhere('hasil_lab', 'like', "%{$search}%")
                    ->orWhere('catatan', 'like', "%{$search}%");
            });
        }
        return $query;
    }

    /**
     * Scope untuk filter tanggal
     */
    public function scopeDateRange($query, $start_date, $end_date)
    {
        if ($start_date && $end_date) {
            return $query->whereBetween('tanggal', [$start_date, $end_date]);
        }
        return $query;
    }

    /**
     * Accessor untuk format tanggal yang aman
     */
    public function getFormattedTanggalAttribute()
    {
        if ($this->tanggal) {
            if (is_string($this->tanggal)) {
                return date('Y-m-d', strtotime($this->tanggal));
            }
            return $this->tanggal->format('Y-m-d');
        }
        return null;
    }

    /**
     * Accessor untuk format jam yang aman
     */
    public function getFormattedJamAttribute()
    {
        if ($this->jam) {
            if (is_string($this->jam)) {
                return date('H:i', strtotime($this->jam));
            }
            return $this->jam->format('H:i');
        }
        return null;
    }

    /**
     * Accessor untuk format datetime yang aman
     */
    public function getFormattedUpdatedAtAttribute()
    {
        if ($this->updated_at) {
            if (is_string($this->updated_at)) {
                return date('d/m/Y H:i', strtotime($this->updated_at));
            }
            return $this->updated_at->format('d/m/Y H:i');
        }
        return null;
    }
}
