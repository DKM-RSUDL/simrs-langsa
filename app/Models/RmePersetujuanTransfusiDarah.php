<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmePersetujuanTransfusiDarah extends Model
{
    use HasFactory;

    protected $table = 'RME_PERSETUJUAN_TRANSFUSI_DARAH';
    public $timestamps = false;
    protected $guarded = ['id'];

    protected $casts = [
        'tanggal' => 'date',
        'tgl_lahir_keluarga' => 'date',
        'tgl_lahir_saksi1' => 'date',
        'tgl_lahir_saksi2' => 'date',
    ];

    public function userCreate()
    {
        return $this->belongsTo(User::class, 'user_create', 'id');
    }

    public function userEdit()
    {
        return $this->belongsTo(User::class, 'user_edit', 'id');
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'dokter', 'kd_dokter');
    }

    // Accessor untuk format tanggal
    public function getTanggalFormattedAttribute()
    {
        return $this->tanggal ? $this->tanggal->format('d/m/Y') : '-';
    }

    public function getJamFormattedAttribute()
    {
        return $this->jam ? date('H:i', strtotime($this->jam)) : '-';
    }

    public function getPersetujuanBadgeAttribute()
    {
        return $this->persetujuan === 'setuju'
            ? '<span class="badge bg-success">Setuju</span>'
            : '<span class="badge bg-danger">Tidak Setuju</span>';
    }
}
