<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class RmeCatatanPoliklinik extends Model
{
    use HasFactory;

    protected $table = 'RME_CATATAN_POLIKLINIK';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function userCreate()
    {
        return $this->belongsTo(User::class, 'user_create', 'id');
    }
    public function bagian()
    {
        return $this->belongsTo(Bagian::class, 'kd_bagian', 'kd_bagian');
    }

    public function getTanggalIndonesiaAttribute()
    {
        return Carbon::parse($this->tanggal)->translatedFormat('d F Y');
    }

    public function getJamFormatAttribute()
    {
        return Carbon::parse($this->jam)->format('H:i');
    }

    public function getDatetimeAttribute()
    {
        return Carbon::parse($this->tanggal . ' ' . $this->jam);
    }

    // Accessor untuk mendapatkan preview SOAP
    public function getSoapPreviewAttribute()
    {
        return [
            'S' => Str::limit($this->subjective, 100),
            'O' => Str::limit($this->objective, 100),
            'A' => Str::limit($this->assessment, 100),
            'P' => Str::limit($this->plan, 100)
        ];
    }

    public function getDiagnosisUtamaAttribute()
    {
        $lines = explode("\n", $this->assessment);
        return $lines[0] ?? $this->assessment;
    }

    // Scope untuk filter berdasarkan periode
    public function scopeFilterByPeriod($query, $period)
    {
        switch ($period) {
            case 'option2': // 1 Bulan
                return $query->where('tanggal', '>=', Carbon::now()->subMonth());
            case 'option3': // 3 Bulan
                return $query->where('tanggal', '>=', Carbon::now()->subMonths(3));
            case 'option4': // 6 Bulan
                return $query->where('tanggal', '>=', Carbon::now()->subMonths(6));
            case 'option5': // 9 Bulan
                return $query->where('tanggal', '>=', Carbon::now()->subMonths(9));
            default:
                return $query;
        }
    }

    // Scope untuk filter berdasarkan episode
    public function scopeFilterByEpisode($query, $kd_unit, $tgl_masuk, $urut_masuk)
    {
        return $query->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk);
    }

    // Scope untuk pencarian SOAP
    public function scopeSearchSoap($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('subjective', 'like', '%' . $search . '%')
                ->orWhere('objective', 'like', '%' . $search . '%')
                ->orWhere('assessment', 'like', '%' . $search . '%')
                ->orWhere('plan', 'like', '%' . $search . '%');
        });
    }

    // Scope untuk filter berdasarkan tanggal range
    public function scopeFilterByDateRange($query, $startDate, $endDate)
    {
        if ($startDate) {
            $query->whereDate('tanggal', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('tanggal', '<=', $endDate);
        }
        return $query;
    }

    // Method untuk mendapatkan summary catatan
    public function getSummaryAttribute()
    {
        return [
            'tanggal' => $this->tanggal_indonesia,
            'jam' => $this->jam_format,
            'diagnosis' => $this->diagnosis_utama,
            'unit' => $this->kd_unit
        ];
    }
}
