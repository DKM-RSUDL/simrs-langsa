<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeHivArtTerapiAntiretroviral extends Model
{
    use HasFactory;

    protected $table = 'RME_HIV_ART_TERAPI_ANTIRETROVIRAL';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $guarded = ['id'];

    protected $casts = [
        // **PERBAIKAN: Jangan gunakan cast 'array' untuk kontrol penuh format JSON**
        // 'data_terapi_art' => 'array'
    ];

    // Relationships
    public function hivArt()
    {
        return $this->belongsTo(RmeHivArt::class, 'id_hiv_art', 'id');
    }

    // **Accessor untuk mendapatkan data terapi ART yang sudah di-decode**
    public function getDataTerapiArtArrayAttribute()
    {
        if (empty($this->data_terapi_art)) {
            return [];
        }

        if (is_string($this->data_terapi_art)) {
            $decoded = json_decode($this->data_terapi_art, true);
            return is_array($decoded) ? $decoded : [];
        }

        return is_array($this->data_terapi_art) ? $this->data_terapi_art : [];
    }

    // **Helper methods untuk mendapatkan informasi ART**
    public function getNamaPaduanArtAttribute()
    {
        $artData = $this->data_terapi_art_array;
        return $artData['nama_paduan_art'] ?? '';
    }

    public function getArtLainnyaAttribute()
    {
        $artData = $this->data_terapi_art_array;
        return $artData['art_lainnya'] ?? '';
    }

    public function getSubstitusiTanggalAttribute()
    {
        $artData = $this->data_terapi_art_array;
        return $artData['substitusi_tanggal'] ?? '';
    }

    public function getSubstitusiAttribute()
    {
        $artData = $this->data_terapi_art_array;
        return $artData['substitusi'] ?? '';
    }

    public function getSwitchAttribute()
    {
        $artData = $this->data_terapi_art_array;
        return $artData['switch'] ?? '';
    }

    public function getStopAttribute()
    {
        $artData = $this->data_terapi_art_array;
        return $artData['stop'] ?? '';
    }

    public function getRestartAttribute()
    {
        $artData = $this->data_terapi_art_array;
        return $artData['restart'] ?? '';
    }

    public function getAlasanAttribute()
    {
        $artData = $this->data_terapi_art_array;
        return $artData['alasan'] ?? '';
    }

    public function getNamaPaduanBaruAttribute()
    {
        $artData = $this->data_terapi_art_array;
        return $artData['nama_paduan_baru'] ?? '';
    }

    // **Helper method untuk mendapatkan text alasan yang mudah dibaca**
    public function getAlasanTextAttribute()
    {
        $alasan = [
            '1' => 'Toksisitas/efek samping',
            '2' => 'Hamil',
            '3' => 'Risiko hamil',
            '4' => 'TB baru',
            '5' => 'Ada obat baru',
            '6' => 'Stok obat habis',
            '7' => 'Alasan lain',
            '8' => 'Gagal pengobatan klinis',
            '9' => 'Gagal imunologis',
            '10' => 'Gagal virologis'
        ];

        return $alasan[$this->alasan] ?? $this->alasan;
    }

    // **Method untuk mendapatkan nama paduan ART yang mudah dibaca**
    public function getNamaPaduanArtTextAttribute()
    {
        $namaPaduan = $this->nama_paduan_art;

        if ($namaPaduan === 'lainnya') {
            return $this->art_lainnya ?: 'Lainnya';
        }

        return $namaPaduan;
    }

    // **Method untuk debug JSON format**
    public function debugJsonData()
    {
        return [
            'data_terapi_art_raw' => $this->data_terapi_art,
            'data_terapi_art_decoded' => $this->data_terapi_art_array,
            'nama_paduan_art' => $this->nama_paduan_art,
            'art_lainnya' => $this->art_lainnya,
            'alasan' => $this->alasan,
            'alasan_text' => $this->alasan_text,
        ];
    }

    // **Method untuk format ulang JSON yang sudah ada (untuk data lama)**
    public function reformatJsonData()
    {
        if (!empty($this->data_terapi_art) && is_string($this->data_terapi_art)) {
            $decoded = json_decode($this->data_terapi_art, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                // Reformat dengan JSON bersih
                $cleanJson = json_encode($decoded, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                if ($cleanJson !== $this->data_terapi_art) {
                    $this->data_terapi_art = $cleanJson;
                    $this->save();
                    return true;
                }
            }
        }

        return false;
    }
}
