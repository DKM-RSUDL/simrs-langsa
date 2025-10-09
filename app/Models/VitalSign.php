<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VitalSign extends Model
{
    protected $table = 'vital_signs';

    public $timestamps = false;
    protected $fillable = [
        'kd_kasir',
        'no_transaksi',
        'sistole',
        'diastole',
        'nadi',
        'respiration',
        'suhu',
        'spo2_tanpa_o2',
        'spo2_dengan_o2',
        'tinggi_badan',
        'berat_badan',
        'created_by',
    ];

    public function patient()
    {
        return $this->belongsTo(Pasien::class, 'no_rm', 'kd_pasien');
    }

    public function triage()
    {
        return $this->belongsTo(DataTriase::class, 'triage_id', 'id');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaksi::class, 'no_transaksi',  'no_transaksi');
    }
}