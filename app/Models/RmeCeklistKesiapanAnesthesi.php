<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeCeklistKesiapanAnesthesi extends Model
{
    use HasFactory;

    protected $table = 'RME_CEKLIST_KESIAPAN_ANESTHESI';
    public $timestamps = false;

    protected $guarded = ['id'];

    public function userCreate()
    {
        return $this->belongsTo(User::class, 'user_create', 'id');
    }
}
