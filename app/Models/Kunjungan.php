<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    use HasFactory;
    // protected $connection = 'sqlsrv_rslangsa';
    protected $table = 'kunjungan';
    // protected $primaryKey = 'KD_PASIEN';

    // public $incrementing = false;

    // protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kd_pasien',
        'kd_unit',
        'tgl_masuk',
        'urut_masuk',
        'kd_dokter',
        'kd_rujukan',
        'kd_customer',
        'jam_masuk',
        'tgl_keluar',
        'jam_keluar',
        'keadaan_masuk',
        'keadaan_pasien',
        'cara_penerimaan',
        'asal_pasien',
        'cara_keluar',
        'baru',
        'shift',
        'karyawan',
        'kontrol',
        'sebabMati',
        'antrian',
        'no_surat',
        'alergi',
        'catatan',
        'waktu_mati',
        'ket_mati_opr',
        'kd_triase',
        'kd_kecelakaan',
        'tgl_surat',
        'no_pemeriksaan',
        'tag_status',
        'jasa_raharja',
        'tgl_pulang',
        'jam_pulang',
        'stts_map',
        'stts_v',
        'stts_cbg',
        'kd_user_cbg',
        'is_rujukan',
        'rujukan_ket',
        'status_inap',
        'status_kunjungan',
        'triase_id',
        'user_create'
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'kd_pasien', 'kd_pasien');
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'kd_dokter', 'kd_dokter');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'kd_customer', 'kd_customer');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'kd_unit', 'kd_unit');
    }

    public function registrasiHasil()
    {
        return $this->belongsTo(RegistrasrHasil::class, 'kd_pasien', 'kd_pasien');
    }

    public function getVitalSign()
    {
        return $this->hasOne(DataTriase::class, 'kd_pasien_triase', 'kd_pasien')
            ->whereNull('id_asesmen')
            ->latest('tanggal_triase');
    }

    // public function resep()
    // {
    //     return $this->hasMany(MrResep::class, 'KD_PASIEN', 'KD_PASIEN');
    // }
}
