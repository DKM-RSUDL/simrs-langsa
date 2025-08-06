<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class RmeHivArtAkhiriFollowUp extends Model
{
    use HasFactory;

    protected $table = 'RME_HIV_ART_AKHIRI_FOLLOW_UP';

    protected $fillable = [
        'kd_pasien',
        'kd_unit',
        'tgl_masuk',
        'urut_masuk',
        'user_create',
        'user_edit',
        'tanggal',
        'jam',
        'visits_data',
        'total_visits',
        'status_akhir',
        'catatan_umum'
    ];

    protected $casts = [
        'visits_data' => 'array',
        'tgl_masuk' => 'datetime',
        'tanggal' => 'date',
        'jam' => 'datetime:H:i:s',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Enable timestamps
    public $timestamps = true;

    // Relationship dengan kunjungan
    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class, 'kd_pasien', 'kd_pasien')
                    ->where('kd_unit', $this->kd_unit)
                    ->whereDate('tgl_masuk', $this->tgl_masuk->format('Y-m-d'))
                    ->where('urut_masuk', $this->urut_masuk);
    }

    // Relationship dengan pasien
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'kd_pasien', 'kd_pasien');
    }

    // Accessor untuk mendapatkan visit tertentu
    public function getVisit($visitNumber)
    {
        $visits = $this->visits_data ?? [];
        return collect($visits)->firstWhere('visit_number', $visitNumber);
    }

    // Accessor untuk mendapatkan semua visits yang sudah diurutkan
    public function getOrderedVisits()
    {
        $visits = $this->visits_data ?? [];
        return collect($visits)->sortBy('visit_number')->values();
    }

    // Accessor untuk visit terakhir
    public function getLastVisit()
    {
        $visits = $this->visits_data ?? [];
        return collect($visits)->sortByDesc('visit_number')->first();
    }

    // Scope untuk filter berdasarkan periode
    public function scopeByPeriod($query, $startDate, $endDate)
    {
        return $query->whereBetween('tanggal', [$startDate, $endDate]);
    }

    // Scope untuk filter berdasarkan status akhir
    public function scopeByStatus($query, $status)
    {
        return $query->where('status_akhir', $status);
    }

    // Mutator untuk update total visits
    public function setVisitsDataAttribute($value)
    {
        $this->attributes['visits_data'] = is_array($value) ? json_encode($value) : $value;
        $this->attributes['total_visits'] = is_array($value) ? count($value) : 0;

        // Update status akhir berdasarkan visit terakhir
        if (is_array($value) && !empty($value)) {
            $lastVisit = collect($value)->sortByDesc('visit_number')->first();
            if (isset($lastVisit['akhir_followup']) && $lastVisit['akhir_followup'] !== 'aktif') {
                $this->attributes['status_akhir'] = $lastVisit['akhir_followup'];
            } else {
                $this->attributes['status_akhir'] = 'aktif';
            }
        }
    }

    // Accessor untuk visits_data
    public function getVisitsDataAttribute($value)
    {
        return is_string($value) ? json_decode($value, true) : $value;
    }

    // Helper method untuk validasi struktur data visit
    public static function validateVisitData($visitData)
    {
        $requiredFields = [
            'visit_number',
            'tanggal_kunjungan',
            'bb',
            'status_fungsional'
        ];

        foreach ($requiredFields as $field) {
            if (!isset($visitData[$field]) || empty($visitData[$field])) {
                return false;
            }
        }

        return true;
    }

    // Helper method untuk format data visit
    public static function formatVisitData($rawData)
    {
        $visits = [];
        $visitNumbers = [];

        // Ekstrak nomor visit dari field names
        foreach ($rawData as $key => $value) {
            if (preg_match('/_(\d+)$/', $key, $matches)) {
                $visitNumbers[] = (int)$matches[1];
            }
        }

        $visitNumbers = array_unique($visitNumbers);
        sort($visitNumbers);

        foreach ($visitNumbers as $visitNum) {
            $visit = [
                'visit_number' => $visitNum,
                'tanggal_kunjungan' => $rawData["tanggal_kunjungan_{$visitNum}"] ?? null,
                'tanggal_rencana' => $rawData["tanggal_rencana_{$visitNum}"] ?? null,
                'pasien_rujuk_masuk' => $rawData["pasien_rujuk_masuk_{$visitNum}"] ?? null,
                'nama_klinik_art' => $rawData["nama_klinik_art_{$visitNum}"] ?? null,
                'dengan_art' => $rawData["dengan_art_{$visitNum}"] ?? null,
                'bb' => $rawData["bb_{$visitNum}"] ?? null,
                'tb' => $rawData["tb_{$visitNum}"] ?? null,
                'status_fungsional' => $rawData["status_fungsional_{$visitNum}"] ?? null,
                'stad_klinis' => $rawData["stad_klinis_{$visitNum}"] ?? null,
                'hamil' => $rawData["hamil_{$visitNum}"] ?? null,
                'infeksi_opportunistik' => $rawData["infeksi_opportunistik_{$visitNum}"] ?? null,
                'obat_io' => $rawData["obat_io_{$visitNum}"] ?? null,
                'status_tb' => $rawData["status_tb_{$visitNum}"] ?? null,
                'pp_inh' => $rawData["pp_inh_{$visitNum}"] ?? null,
                'pp_inh_kode' => $rawData["pp_inh_kode_{$visitNum}"] ?? null,
                'pp_inh_hasil' => $rawData["pp_inh_hasil_{$visitNum}"] ?? null,
                'ppk' => $rawData["ppk_{$visitNum}"] ?? null,
                'ppk_hasil' => $rawData["ppk_hasil_{$visitNum}"] ?? null,
                'obat_arv' => $rawData["obat_arv_{$visitNum}"] ?? null,
                'sisa_obat' => $rawData["sisa_obat_{$visitNum}"] ?? null,
                'adherence_art' => $rawData["adherence_art_{$visitNum}"] ?? null,
                'efek_samping' => $rawData["efek_samping_{$visitNum}"] ?? null,
                'cd4' => $rawData["cd4_{$visitNum}"] ?? null,
                'hasil_lab' => $rawData["hasil_lab_{$visitNum}"] ?? null,
                'diberikan_kondom' => $rawData["diberikan_kondom_{$visitNum}"] ?? null,
                'diberikan_kondom_detail' => $rawData["diberikan_kondom_detail_{$visitNum}"] ?? null,
                'rujuk_spesialis' => $rawData["rujuk_spesialis_{$visitNum}"] ?? null,
                'akhir_followup' => $rawData["akhir_followup_{$visitNum}"] ?? 'aktif',
                'akhir_detail' => $rawData["akhir_detail_{$visitNum}"] ?? null,
                'catatan' => $rawData["catatan_{$visitNum}"] ?? null,
                'created_at' => now()->toISOString()
            ];

            // Remove null values
            $visit = array_filter($visit, function($value) {
                return $value !== null && $value !== '';
            });

            $visits[] = $visit;
        }

        return $visits;
    }
}
