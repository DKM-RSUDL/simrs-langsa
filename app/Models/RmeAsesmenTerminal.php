<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenTerminal extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_TERMINAL';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function userCreate()
    {
        return $this->belongsTo(User::class, 'user_create', 'id');
    }
}
