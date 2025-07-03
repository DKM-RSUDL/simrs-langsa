<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeHdMalnutrisiSkor extends Model
{
    use HasFactory;

    protected $table = 'RME_HD_MALNUTRISI_SKOR';
    public $timestamps = false;

    protected $guarded = ['id'];

    public function userCreate()
    {
        return $this->belongsTo(User::class, 'user_created', 'id');
    }

    public function userUpdate()
    {
        return $this->belongsTo(User::class, 'user_updated', 'id');
    }
}
