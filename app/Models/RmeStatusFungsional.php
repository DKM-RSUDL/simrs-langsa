<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; // ✅ TAMBAHKAN INI

class RmeStatusFungsional extends Model
{
    use HasFactory;

    protected $table = 'RME_STATUS_FUNGSIONAL';
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = [
        'kd_pasien',
        'kd_unit', 
        'tgl_masuk',
        'urut_masuk',
        'tanggal',
        'jam',
        'nilai_skor',
        'bab',
        'bak',
        'membersihkan_diri',
        'penggunaan_jamban',
        'makan',
        'berubah_sikap',
        'berpindah',
        'berpakaian',
        'naik_turun_tangga',
        'mandi',
        'skor_total',
        'kategori',
        'user_create',
        'user_edit'
    ];

    public function userCreate()
    {
        return $this->belongsTo(User::class, 'user_create', 'id');
    }

    public function userEdit()
    {
        return $this->belongsTo(User::class, 'user_edit', 'id');
    }
}