<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenKetDewasaRanapResikoJatuh extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_KET_DEWASA_RANAP_RESIKO_JATUH';
    public $timestamps = false;
    protected $guarded = ['id'];

    protected $casts = [

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
