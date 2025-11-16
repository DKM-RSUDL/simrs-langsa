<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeTransferPasienAntarRuang extends Model
{
    use HasFactory;

    protected $table = 'RME_TRANSFER_PASIEN_ANTAR_RUANG';
    public $timestamps = false;

    protected $guarded = ['id'];

    public function userCreate()
    {
        return $this->belongsTo(User::class, 'user_create', 'id');
    }
    public function userEdit()
    {
        return $this->belongsTo(User::class, 'user_edit', 'id');
    }

    public function serahTerima()
    {
        return $this->hasOne(RmeSerahTerima::class, 'transfer_id', 'id');
    }

}
