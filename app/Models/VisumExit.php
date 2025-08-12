<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class VisumExit extends Model
{
    use HasFactory;

    protected $table = 'RME_VISUM_EXIT';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    protected $guarded = ['id'];

    protected $casts = [
        'tanggal' => 'date',
        'jam' => 'datetime:H:i',
        'tgl_masuk' => 'date'
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

    /**
     * Relationship with User (creator)
     */
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

    /**
     * Relationship with Pasien
     */
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'kd_pasien', 'kd_pasien');
    }

    /**
     * Relationship with Kunjungan
     */
    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class, 'kd_pasien', 'kd_pasien')
                    ->where('tgl_masuk', $this->tgl_masuk)
                    ->where('urut_masuk', $this->urut_masuk);
    }

    /**
     * Scope untuk filter berdasarkan pasien
     */
    public function scopeByPasien($query, $kd_pasien)
    {
        return $query->where('kd_pasien', $kd_pasien);
    }

    /**
     * Scope untuk filter berdasarkan tanggal
     */
    public function scopeByTanggal($query, $tanggal)
    {
        return $query->whereDate('tanggal', $tanggal);
    }

    /**
     * Scope untuk filter berdasarkan bulan dan tahun
     */
    public function scopeByMonthYear($query, $month, $year)
    {
        return $query->whereMonth('tanggal', $month)
                    ->whereYear('tanggal', $year);
    }

    /**
     * Scope untuk filter berdasarkan dokter pemeriksa
     */
    public function scopeByDokter($query, $dokter_pemeriksa)
    {
        return $query->where('dokter_pemeriksa', $dokter_pemeriksa);
    }

    /**
     * Accessor untuk format tanggal Indonesia
     */
    public function getTanggalFormattedAttribute()
    {
        return $this->tanggal ? $this->tanggal->format('d/m/Y') : null;
    }

    /**
     * Accessor untuk format jam
     */
    public function getJamFormattedAttribute()
    {
        return $this->jam ? Carbon::parse($this->jam)->format('H:i') : null;
    }

    /**
     * Accessor untuk format datetime lengkap
     */
    public function getDatetimeFormattedAttribute()
    {
        if ($this->tanggal && $this->jam) {
            $datetime = Carbon::parse($this->tanggal->format('Y-m-d') . ' ' . $this->jam);
            return $datetime->format('d/m/Y H:i');
        }
        return null;
    }

    /**
     * Accessor untuk mendapatkan nama user create
     */
    public function getUserCreateNameAttribute()
    {
        return $this->userCreate ? $this->userCreate->name : 'Unknown';
    }

    /**
     * Accessor untuk mendapatkan nama user edit
     */
    public function getUserEditNameAttribute()
    {
        return $this->userEdit ? $this->userEdit->name : 'Unknown';
    }

    /**
     * Accessor untuk mendapatkan nama dokter pemeriksa
     */
    public function getDokterNameAttribute()
    {
        return $this->dokter ? $this->dokter->nama_lengkap : $this->dokter_pemeriksa;
    }

    /**
     * Accessor untuk mendapatkan nama kasir
     */
    public function getKasirNameAttribute()
    {
        return $this->kasir ? $this->kasir->name : 'Unknown';
    }

    /**
     * Mutator untuk clean HTML content
     */
    public function setWawancaraAttribute($value)
    {
        $this->attributes['wawancara'] = $this->cleanHtmlContent($value);
    }

    public function setLabelMayatAttribute($value)
    {
        $this->attributes['label_mayat'] = $this->cleanHtmlContent($value);
    }

    public function setPembungkusMayatAttribute($value)
    {
        $this->attributes['pembungkus_mayat'] = $this->cleanHtmlContent($value);
    }

    public function setBendaDisampingAttribute($value)
    {
        $this->attributes['benda_disamping'] = $this->cleanHtmlContent($value);
    }

    public function setPenutupMayatAttribute($value)
    {
        $this->attributes['penutup_mayat'] = $this->cleanHtmlContent($value);
    }

    public function setPakaianMayatAttribute($value)
    {
        $this->attributes['pakaian_mayat'] = $this->cleanHtmlContent($value);
    }

    public function setPerhiasanMayatAttribute($value)
    {
        $this->attributes['perhiasan_mayat'] = $this->cleanHtmlContent($value);
    }

    public function setIdentifikasiUmumAttribute($value)
    {
        $this->attributes['identifikasi_umum'] = $this->cleanHtmlContent($value);
    }

    public function setIdentifikasiKhususAttribute($value)
    {
        $this->attributes['identifikasi_khusus'] = $this->cleanHtmlContent($value);
    }

    public function setTandaKematianAttribute($value)
    {
        $this->attributes['tanda_kematian'] = $this->cleanHtmlContent($value);
    }

    public function setGigiGeligiAttribute($value)
    {
        $this->attributes['gigi_geligi'] = $this->cleanHtmlContent($value);
    }

    public function setLukaLukaAttribute($value)
    {
        $this->attributes['luka_luka'] = $this->cleanHtmlContent($value);
    }

    public function setPadaJenazahAttribute($value)
    {
        $this->attributes['pada_jenazah'] = $this->cleanHtmlContent($value);
    }

    public function setPemeriksaanLuarKesimpulanAttribute($value)
    {
        $this->attributes['pemeriksaan_luar_kesimpulan'] = $this->cleanHtmlContent($value);
    }

    public function setDijumpaiKesimpulanAttribute($value)
    {
        $this->attributes['dijumpai_kesimpulan'] = $this->cleanHtmlContent($value);
    }

    public function setHasilKesimpulanAttribute($value)
    {
        $this->attributes['hasil_kesimpulan'] = $this->cleanHtmlContent($value);
    }

    /**
     * Clean HTML content from Trix editor
     */
    private function cleanHtmlContent($value)
    {
        if (empty($value)) {
            return $value;
        }

        // Remove unwanted HTML tags but keep basic formatting
        $allowedTags = '<p><br><strong><b><em><i><u><ul><ol><li>';
        return strip_tags($value, $allowedTags);
    }

    /**
     * Get summary of visum for listing
     */
    public function getSummaryAttribute()
    {
        $summary = [];
        
        if ($this->nomor_ver) {
            $summary[] = "No. VeR: {$this->nomor_ver}";
        }
        
        if ($this->tanggal_formatted) {
            $summary[] = "Tanggal: {$this->tanggal_formatted}";
        }
        
        if ($this->dokter_pemeriksa) {
            $summary[] = "Dokter: {$this->dokter_pemeriksa}";
        }
        
        return implode(' | ', $summary);
    }

    /**
     * Check if visum is complete (has all required sections)
     */
    public function getIsCompleteAttribute()
    {
        $requiredFields = [
            'tanggal', 'jam', 'nomor_ver', 'dokter_pemeriksa'
        ];
        
        foreach ($requiredFields as $field) {
            if (empty($this->$field)) {
                return false;
            }
        }
        
        return true;
    }

    /**
     * Get completion percentage
     */
    public function getCompletionPercentageAttribute()
    {
        $allFields = [
            'tanggal', 'jam', 'nomor_ver', 'dokter_pemeriksa',
            'permintaan', 'nomor_surat', 'wawancara',
            'label_mayat', 'pembungkus_mayat', 'benda_disamping',
            'penutup_mayat', 'pakaian_mayat', 'perhiasan_mayat',
            'identifikasi_umum', 'identifikasi_khusus', 'tanda_kematian',
            'gigi_geligi', 'luka_luka', 'pada_jenazah',
            'pemeriksaan_luar_kesimpulan', 'dijumpai_kesimpulan', 'hasil_kesimpulan'
        ];
        
        $filledFields = 0;
        foreach ($allFields as $field) {
            if (!empty($this->$field)) {
                $filledFields++;
            }
        }
        
        return round(($filledFields / count($allFields)) * 100);
    }

    /**
     * Static method to get field labels
     */
    public static function getFieldLabels()
    {
        return [
            'tanggal' => 'Tanggal Pemeriksaan',
            'jam' => 'Jam Pemeriksaan',
            'nomor_ver' => 'Nomor VeR',
            'permintaan' => 'Permintaan Dari',
            'nomor_surat' => 'Nomor Surat',
            'registrasi' => 'Nomor Registrasi',
            'menerangkan' => 'Keterangan Tambahan',
            'wawancara' => 'Hasil Wawancara',
            'label_mayat' => 'Label Mayat',
            'pembungkus_mayat' => 'Pembungkus Mayat',
            'benda_disamping' => 'Benda di Samping Mayat',
            'penutup_mayat' => 'Penutup Mayat',
            'pakaian_mayat' => 'Pakaian Mayat',
            'perhiasan_mayat' => 'Perhiasan Mayat',
            'identifikasi_umum' => 'Identifikasi Umum',
            'identifikasi_khusus' => 'Identifikasi Khusus',
            'tanda_kematian' => 'Tanda-tanda Kematian',
            'gigi_geligi' => 'Gigi-geligi',
            'luka_luka' => 'Luka-luka',
            'pada_jenazah' => 'Pada Jenazah',
            'pemeriksaan_luar_kesimpulan' => 'Pada Pemeriksaan Luar',
            'dijumpai_kesimpulan' => 'Dijumpai',
            'hasil_kesimpulan' => 'Hasil Kesimpulan',
            'dokter_pemeriksa' => 'Dokter Pemeriksa'
        ];
    }

    /**
     * Static method to get examination sections
     */
    public static function getExaminationSections()
    {
        return [
            'basic_info' => [
                'title' => 'Informasi Dasar',
                'fields' => ['tanggal', 'jam', 'nomor_ver', 'permintaan', 'nomor_surat', 'registrasi', 'menerangkan']
            ],
            'interview' => [
                'title' => 'Wawancara',
                'fields' => ['wawancara']
            ],
            'external_exam' => [
                'title' => 'Pemeriksaan Luar',
                'fields' => [
                    'label_mayat', 'pembungkus_mayat', 'benda_disamping', 'penutup_mayat',
                    'pakaian_mayat', 'perhiasan_mayat', 'identifikasi_umum', 'identifikasi_khusus',
                    'tanda_kematian', 'gigi_geligi', 'luka_luka'
                ]
            ],
            'conclusion' => [
                'title' => 'Kesimpulan',
                'fields' => ['pada_jenazah', 'pemeriksaan_luar_kesimpulan', 'dijumpai_kesimpulan', 'hasil_kesimpulan', 'dokter_pemeriksa']
            ]
        ];
    }

    /**
     * Bootstrap method for model events
     */
    protected static function boot()
    {
        parent::boot();

        // Set default values on creating
        static::creating(function ($model) {
            if (empty($model->registrasi) && !empty($model->kd_pasien)) {
                $model->registrasi = $model->kd_pasien;
            }
            
            if (empty($model->tanggal)) {
                $model->tanggal = now()->toDateString();
            }
            
            if (empty($model->jam)) {
                $model->jam = now()->toTimeString();
            }
        });

        // Update user_edit on updating
        static::updating(function ($model) {
            if (auth()->check()) {
                $model->user_edit = auth()->id();
            }
        });
    }

    /**
     * Convert model to array for export
     */
    public function toExportArray()
    {
        return [
            'Nomor VeR' => $this->nomor_ver,
            'Tanggal' => $this->tanggal_formatted,
            'Jam' => $this->jam_formatted,
            'Kode Pasien' => $this->kd_pasien,
            'Nama Pasien' => $this->pasien ? $this->pasien->nama : '',
            'Permintaan Dari' => $this->permintaan,
            'Nomor Surat' => $this->nomor_surat,
            'Dokter Pemeriksa' => $this->dokter_pemeriksa,
            'Kasir' => $this->kasir_name,
            'No Transaksi' => $this->no_transaksi,
            'User Create' => $this->user_create_name,
            'User Edit' => $this->user_edit_name,
            'Kelengkapan' => $this->completion_percentage . '%'
        ];
    }
}