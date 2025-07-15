<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeSkalaHumptyDumpty extends Model
{
    use HasFactory;

    protected $table = 'RME_SKALA_HUMPTY_DUMPTY';
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
