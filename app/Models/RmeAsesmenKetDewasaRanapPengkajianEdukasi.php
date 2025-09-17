<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenKetDewasaRanapPengkajianEdukasi extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_KET_DEWASA_RANAP_PENGKAJIAN_EDUKASI';
    public $timestamps = false;
    protected $guarded = ['id'];

    protected $casts = [
        'bicara' => 'array',
        'bahasa_sehari' => 'array',
        'penerjemah' => 'array',
        'hambatan' => 'array',
        'cara_komunikasi' => 'array',
        'pendidikan' => 'array',
        'potensi_pembelajaran' => 'array',
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
}
