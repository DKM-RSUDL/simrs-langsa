<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeVisumHidup extends Model
{
    use HasFactory;

    protected $table = 'RME_VISUM_HIDUP';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $guarded = ['id'];

    protected $fillable = [
        'kd_kasir',
        'no_transaksi',
        'user_create',
        'user_edit',
        'tanggal',
        'jam',
        'nomor_ver',
        'permintaan',
        'nomor_surat',
        'registrasi',
        'menerangkan',
        'hasil_pemeriksaan',
        'hasil_kesimpulan',
        'dokter_pemeriksa'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam' => 'datetime:H:i',
    ];

    /**
     * Relationship with Transaksi
     */
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'no_transaksi', 'no_transaksi');
    }

    /**
     * Relationship with Kasir (User)
     */
    public function kasir()
    {
        return $this->belongsTo(User::class, 'kd_kasir', 'id');
    }

    public function userCreate()
    {
        return $this->belongsTo(User::class, 'user_create', 'id');
    }

    /**
     * Relationship with User (editor)
     */
    public function userEdit()
    {
        return $this->belongsTo(User::class, 'user_edit', 'id');
    }

    /**
     * Relationship with Dokter
     */
    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'dokter_pemeriksa', 'kd_dokter');
    }

    // Accessors
    public function getTanggalFormattedAttribute()
    {
        return $this->tanggal ? $this->tanggal->format('d/m/Y') : '-';
    }

    public function getJamFormattedAttribute()
    {
        return $this->jam ? \Carbon\Carbon::parse($this->jam)->format('H:i') : '-';
    }

    public function getDokterNameAttribute()
    {
        return $this->dokter ? $this->dokter->nama_lengkap : '-';
    }

    public function getUserCreateNameAttribute()
    {
        return $this->userCreate ? $this->userCreate->nama : '-';
    }

    public function getUserEditNameAttribute()
    {
        return $this->userEdit ? $this->userEdit->nama : '-';
    }

    // Method untuk menghitung kelengkapan data
    public function getCompletionPercentageAttribute()
    {
        $fields = [
            'tanggal',
            'jam',
            'nomor_ver',
            'permintaan',
            'nomor_surat',
            'menerangkan',
            'hasil_pemeriksaan',
            'hasil_kesimpulan',
            'dokter_pemeriksa'
        ];

        $filledFields = 0;
        $totalFields = count($fields);

        foreach ($fields as $field) {
            if (!empty($this->$field)) {
                $filledFields++;
            }
        }

        return round(($filledFields / $totalFields) * 100);
    }

    // Scope untuk filter berdasarkan tanggal
    public function scopeFilterByDateRange($query, $startDate, $endDate)
    {
        if ($startDate && $endDate) {
            return $query->whereBetween('tanggal', [$startDate, $endDate]);
        } elseif ($startDate) {
            return $query->where('tanggal', '>=', $startDate);
        } elseif ($endDate) {
            return $query->where('tanggal', '<=', $endDate);
        }

        return $query;
    }

    // Scope untuk filter berdasarkan dokter
    public function scopeFilterByDokter($query, $search)
    {
        if ($search) {
            return $query->whereHas('dokter', function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', '%' . $search . '%');
            });
        }

        return $query;
    }

    // Method untuk generate nomor VeR otomatis
    public static function generateNomorVer()
    {
        $year = date('Y');
        $month = date('n');
        $romanMonths = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        $romanMonth = $romanMonths[$month - 1];

        // Ambil nomor urut terakhir pada bulan dan tahun ini
        $lastRecord = self::whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month)
            ->orderBy('id', 'desc')
            ->first();

        $sequence = 1;
        if ($lastRecord && $lastRecord->nomor_ver) {
            // Extract sequence number from nomor_ver format: VeR/001/I/2025
            preg_match('/VeR\/(\d+)\//', $lastRecord->nomor_ver, $matches);
            if (isset($matches[1])) {
                $sequence = intval($matches[1]) + 1;
            }
        }

        $sequenceStr = str_pad($sequence, 3, '0', STR_PAD_LEFT);

        return "VeR/{$sequenceStr}/{$romanMonth}/{$year}";
    }
}
