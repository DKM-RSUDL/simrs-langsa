<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ICCU extends Model
{
    use HasFactory;

    protected $table = 'RME_ICCU';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function userCreate()
    {
        return $this->belongsTo(User::class, 'user_create', 'id');
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'kd_dokter', 'kd_dokter');
    }
}
