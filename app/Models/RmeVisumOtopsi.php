<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeVisumOtopsi extends Model
{
    use HasFactory;

    protected $table = "RME_VISUM_OTOPSI";
    public $timestamps = false;
    protected $guarded = ['id'];


    public function userCreated()
    {
        return $this->belongsTo(User::class, 'user_created', 'id');
    }

    // Relasi ke user yang mengupdate
    public function userUpdated()
    {
        return $this->belongsTo(User::class, 'user_updated', 'id');
    }
}
