<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenKetDewasaRanapSkalaNyeri extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_KET_DEWASA_RANAP_SKALA_NYERI';
    public $timestamps = false;
    protected $guarded = ['id'];

    protected $casts = [
        'jenis_nyeri' => 'array',
        'frekuensi_nyeri' => 'array',
        'kualitas_nyeri' => 'array',
        'faktor_pemberat' => 'array',
        'faktor_peringan' => 'array',
        'efek_nyeri' => 'array',
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
