<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;
    // protected $connection = 'sqlsrv_hrd';

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function asesmen()
    {
        return $this->hasMany(RmeAsesmen::class, 'user_id', 'id');
    }
}
