<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAudiometri extends Model
{
    use HasFactory;

    protected $table = 'RME_AUDIOMETRI';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function userCreated()
    {
        return $this->belongsTo(User::class, 'user_created', 'id');
    }

    public function userUpdated()
    {
        return $this->belongsTo(User::class, 'user_updated', 'id');
    }
}
