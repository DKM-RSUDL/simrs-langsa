<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    protected $table = 'pasien';
    public $timestamps = false;

    protected $fillable = [
        'kd_pasien',
        'kd_kelurahan',
        'kd_pendidikan',
        'kd_pekerjaan',
        'kd_perusahaan',
        'kd_agama',
        'nama',
        'tgl_lahir',
        'gol_darah',
        'jenis_kelamin',
        'status_hidup',
        'status_marita',
        'alamat',
        'kota',
        'telepon',
        'kd_pos',
        'kd_asuransi',
        'no_asuransi',
        'jabatan',
        'tanda_pengenal',
        'no_pengenal',
        'keterangan',
        'kode_lama',
        'wni',
        'nama_keluarga',
        'tempat_lahir',
        'pemegang_asuransi',
        'kd_suku',
        'nik',
        'jns_peserta',
        'ibu_kandung',
        'kelas',
        'kd_bahasa',
        'kd_cacat',
        'email',
        'alamat_domisil',
        'gelar_dpn',
        'gelar_blkg',
        'kd_negara',
        'tgl_pass',
        'passport',
        'ihs_number',
    ];

    public function golonganDarah()
    {
        return $this->belongsTo(GolonganDarah::class, 'gol_darah', 'kode');
    }

    public function agama()
    {
        return $this->belongsTo(Agama::class, 'kd_agama', 'kd_agama');
    }

    public function pekerjaan()
    {
        return $this->belongsTo(Pekerjaan::class, 'kd_pekerjaan', 'kd_pekerjaan');
    }

    public function suku()
    {
        return $this->belongsTo(Suku::class, 'kd_suku', 'kd_suku');
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'kd_kelurahan', 'kd_kelurahan');
    }

    public function pendidikan()
    {
        return $this->belongsTo(Pendidikan::class, 'kd_pendidikan', 'kd_pendidikan');
    }

    public function marital()
    {
        return $this->belongsTo(Marital::class, 'status_marita', 'kode');
    }
}
