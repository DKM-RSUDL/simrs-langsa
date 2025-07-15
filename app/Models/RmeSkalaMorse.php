<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeSkalaMorse extends Model
{
    use HasFactory;

    protected $table = 'RME_SKALA_MORSE';
    public $timestamps = false;
    protected $guarded = ['id'];

    protected $casts = [
        'tanggal' => 'date',
        'jam' => 'datetime:H:i',
        'tgl_masuk' => 'datetime',
        'intervensi_rr' => 'array',
        'intervensi_rs' => 'array', 
        'intervensi_rt' => 'array'
    ];

    // Relationship dengan User untuk user_create
    public function userCreate()
    {
        return $this->belongsTo(User::class, 'user_create', 'id');
    }

    // Relationship dengan User untuk user_edit (jika ada)
    public function userEdit()
    {
        return $this->belongsTo(User::class, 'user_edit', 'id');
    }

    // Accessor untuk mendapatkan badge kategori resiko
    public function getKategoriResikoWithBadgeAttribute()
    {
        switch ($this->kategori_resiko) {
            case 'RR':
                return '<span class="badge bg-success">RR - Resiko Rendah</span>';
            case 'RS':
                return '<span class="badge bg-warning text-dark">RS - Resiko Sedang</span>';
            case 'RT':
                return '<span class="badge bg-danger">RT - Resiko Tinggi</span>';
            default:
                return '<span class="badge bg-secondary">Tidak Diketahui</span>';
        }
    }

    // Accessor untuk mendapatkan interpretasi skor
    public function getInterpretasiSkorAttribute()
    {
        $skor = (int) $this->skor_total;
        
        if ($skor >= 0 && $skor <= 24) {
            return 'Resiko Rendah (0-24)';
        } elseif ($skor >= 25 && $skor <= 44) {
            return 'Resiko Sedang (25-44)';
        } elseif ($skor >= 45) {
            return 'Resiko Tinggi (≥45)';
        }
        
        return 'Tidak Valid';
    }

    // Accessor untuk format tanggal Indonesia
    public function getTanggalFormattedAttribute()
    {
        return $this->tanggal ? $this->tanggal->format('d-m-Y') : '-';
    }

    // Accessor untuk format jam
    public function getJamFormattedAttribute()
    {
        return $this->jam ? date('H:i', strtotime($this->jam)) : '-';
    }

    // Accessor untuk nama shift
    public function getShiftNameAttribute()
    {
        switch ($this->shift) {
            case 'PG': return '🌅 Pagi';
            case 'SI': return '☀️ Siang';
            case 'ML': return '🌙 Malam';
            default: return $this->shift;
        }
    }

    // Scope untuk filter berdasarkan pasien
    public function scopeForPasien($query, $kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk)
    {
        return $query->where('kd_pasien', $kd_pasien)
                    ->where('kd_unit', $kd_unit)
                    ->whereDate('tgl_masuk', $tgl_masuk)
                    ->where('urut_masuk', $urut_masuk);
    }

    // Scope untuk filter berdasarkan tanggal
    public function scopeFilterByDate($query, $startDate = null, $endDate = null)
    {
        if ($startDate) {
            $query->whereDate('tanggal', '>=', $startDate);
        }
        
        if ($endDate) {
            $query->whereDate('tanggal', '<=', $endDate);
        }
        
        return $query;
    }

    // Scope untuk filter berdasarkan kategori resiko
    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori_resiko', $kategori);
    }

    // Method untuk mendapatkan detail kriteria jawaban
    public function getRiwayatJatuhTextAttribute()
    {
        return $this->riwayat_jatuh == '0' ? 'Tidak' : 'Ya';
    }

    public function getDiagnosaSekunderTextAttribute()
    {
        return $this->diagnosa_sekunder == '0' ? 'Tidak' : 'Ya';
    }

    public function getBantuanAmbulasiTextAttribute()
    {
        switch ($this->bantuan_ambulasi) {
            case '0': return 'Tidak ada / bed rest / bantuan perawat';
            case '15': return 'Kruk / tongkat / alat bantu berjalan';
            case '30': return 'Meja / kursi';
            default: return '-';
        }
    }

    public function getTerpasangInfusTextAttribute()
    {
        return $this->terpasang_infus == '0' ? 'Tidak' : 'Ya';
    }

    public function getGayaBerjalanTextAttribute()
    {
        switch ($this->gaya_berjalan) {
            case '0': return 'Normal / bed rest / kursi roda';
            case '10': return 'Lemah';
            case '20': return 'Terganggu';
            default: return '-';
        }
    }

    public function getStatusMentalTextAttribute()
    {
        switch ($this->status_mental) {
            case '0': return 'Berorientasi pada kemampuannya';
            case '15': return 'Lupa akan keterbatasannya';
            default: return '-';
        }
    }

    // Method untuk mendapatkan daftar intervensi yang dipilih
    public function getIntervensiListAttribute()
    {
        $interventions = [];
        
        if ($this->kategori_resiko == 'RR' && $this->intervensi_rr) {
            $interventions = is_array($this->intervensi_rr) ? $this->intervensi_rr : json_decode($this->intervensi_rr, true);
        } elseif ($this->kategori_resiko == 'RS' && $this->intervensi_rs) {
            $interventions = is_array($this->intervensi_rs) ? $this->intervensi_rs : json_decode($this->intervensi_rs, true);
        } elseif ($this->kategori_resiko == 'RT' && $this->intervensi_rt) {
            $interventions = is_array($this->intervensi_rt) ? $this->intervensi_rt : json_decode($this->intervensi_rt, true);
        }
        
        return $interventions ?? [];
    }

    // Method untuk mendapatkan nama intervensi yang mudah dibaca
    private function getInterventionMap($format = 'html')
    {
        $lineBreak = ($format === 'html') ? '<br>' : "\n";
        
        return [
            // RR Interventions
            'tingkatkan_observasi' => 'Tingkatkan observasi bantuan yang sesuai saat ambulasi',
            'orientasi_pasien' => "Orientasikan pasien terhadap lingkungan dan rutinitas RS:{$lineBreak}a. Tunjukkan lokasi kamar mandi{$lineBreak}b. Jika pasien linglung, orientasi dilaksanakan bertahap{$lineBreak}c. Tempatkan bel ditempat yang mudah dicapai{$lineBreak}d. Instruksikan meminta bantuan perawat sebelum turun dari tempat tidur",
            'pagar_pengaman' => 'Pagar pengaman tempat tidur dinaikkan',
            'tempat_tidur_rendah' => 'Tempat tidur dalam posisi rendah terkunci',
            'edukasi_perilaku' => 'Edukasi perilaku yang lebih aman saat jatuh atau transfer',
            'monitor_kebutuhan_pasien' => 'Monitor kebutuhan pasien secara berkala (minimalnya tiap 2 jam)',
            'anjurkan_tidak_menggunakan_kaus' => 'Anjurkan pasien tidak menggunakan kaus kaki atau sepatu yang licin',
            'lantai_kamar_mandi' => 'Lantai kamar mandi dengan karpet antislip, tidak licin',
            
            // RS Interventions  
            'lakukan_semua_intervensi_rendah' => 'Lakukan SEMUA intervensi jatuh resiko rendah / standar',
            'pakai_gelang_risiko' => 'Pakailah gelang risiko jatuh berwarna kuning',
            'pasang_gambar_risiko' => 'Pasang gambar risiko jatuh diatas tempat tidur pasien dan pada pintu kamar pasien',
            'tempatkan_risiko_jatuh' => 'Tempatkan tanda resiko pasien jatuh pada daftar nama pasien (warna kuning)',
            'pertimbangkan_riwayat_obat' => 'Pertimbangkan riwayat obat-obatan dan suplemen untuk mengevaluasi pengobatan',
            'gunakan_alat_bantu' => 'Gunakan alat bantu jalan (walker, handrail)',
            'dorong_partisipasi_keluarga' => 'Dorong partisipasi keluarga dalam keselamatan pasien',
            
            // RT Interventions
            'lakukan_semua_intervensi' => 'Lakukan SEMUA intervensi jatuh resiko rendah / standar dan resiko sedang',
            'jangan_tinggalkan_pasien' => 'Jangan tinggalkan pasien saat di ruangan diagnostic atau tindakan',
            'penempatan_dekat_nurse_station' => 'Penempatan pasien dekat nurse station untuk memudahkan observasi (24-48 jam)',
        ];
    }

    // Method untuk mendapatkan nama intervensi yang mudah dibaca
    public function getIntervensiNames($format = 'html')
    {
        $interventionMap = $this->getInterventionMap($format);

        $names = [];
        foreach ($this->intervensi_list as $key) {
            $names[] = $interventionMap[$key] ?? ucwords(str_replace('_', ' ', $key));
        }

        return $names;
    }

    // Method khusus untuk HTML (untuk view web)
    public function getIntervensiNamesHtml()
    {
        return $this->getIntervensiNames('html');
    }

    // Method khusus untuk Plain Text (untuk PDF, export, etc)
    public function getIntervensiNamesPlain()
    {
        return $this->getIntervensiNames('plain');
    }

    // Method untuk validasi konsistensi skor dengan kategori
    public function isScoreConsistent()
    {
        $skor = (int) $this->skor_total;
        
        switch ($this->kategori_resiko) {
            case 'RR':
                return $skor >= 0 && $skor <= 24;
            case 'RS':
                return $skor >= 25 && $skor <= 44;
            case 'RT':
                return $skor >= 45;
            default:
                return false;
        }
    }
}