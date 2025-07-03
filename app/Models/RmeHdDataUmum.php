<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeHdDataUmum extends Model
{
    use HasFactory;

    protected $table = 'rme_hd_data_umum';
    public $timestamps = false;

    protected $guarded = ['id'];

    public function userCreate()
    {
        return $this->belongsTo(User::class, 'user_create', 'id');
    }
}
