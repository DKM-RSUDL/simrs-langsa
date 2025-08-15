<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeEchocardiography extends Model
{
    use HasFactory;

    protected $table = 'RME_ECHOCARDIOGRAPHY';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    protected $guarded = ['id'];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'no_transaksi', 'no_transaksi');
    }

    public function kasir()
    {
        return $this->belongsTo(User::class, 'kd_kasir', 'id');
    }

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
        return $this->belongsTo(Dokter::class, 'dokter_pemeriksa', 'kd_dokter');
    }
}
