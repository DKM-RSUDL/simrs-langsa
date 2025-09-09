<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenMedisNeonatologi extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_MEDIS_NEONATOLOGI';
    public $timestamps = false;
    protected $guarded = ['id'];

    protected $casts = [
        'transportasi' => 'json',
        'riwayat_penyakit_ibu' => 'json',
        'tanggal' => 'date',
        'hpht_tanggal' => 'date',
        'taksiran_tanggal' => 'date',
        'ketuban_jam' =>'datetime:H:i'

    ];

    public function asesmen()
    {
        return $this->belongsTo(RmeAsesmen::class, 'id_asesmen', 'id');
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'no_transaksi', 'no_transaksi');
    }

    public function userCreate()
    {
        return $this->belongsTo(User::class, 'user_create', 'id');
    }

    public function userEdit()
    {
        return $this->belongsTo(User::class, 'user_edit', 'id');
    }

    public function asesmenMedisNeonatologiFisikGeneralis()
    {
        return $this->hasOne(RmeAsesmenMedisNeonatologiFisikGeneralis::class, 'id_asesmen_medis_neonatologi', 'id');
    }

    public function asesmenMedisNeonatologiDtl()
    {
        return $this->hasOne(RmeAsesmenMedisNeonatologiDtl::class, 'id_asesmen_medis_neonatologi', 'id');
    }

    // Accessors
    public function getTransportasiAttribute($value)
    {
        return $value ? json_decode($value, true) : null;
    }

    public function setTransportasiAttribute($value)
    {
        $this->attributes['transportasi'] = is_array($value) ? json_encode($value) : $value;
    }

    public function getRiwayatPenyakitIbuAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    public function setRiwayatPenyakitIbuAttribute($value)
    {
        $this->attributes['riwayat_penyakit_ibu'] = is_array($value) ? json_encode($value) : $value;
    }
}
