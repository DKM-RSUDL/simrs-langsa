<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenParu extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_PARU';
    public $timestamps = false;
    protected $guarded = ['id'];

    protected $casts = [
        'obat_data'  => 'array',
        'merokok_data'  => 'array',
    ];

    public function userCreate()
    {
        return $this->belongsTo(User::class, 'user_create', 'id');
    }
}
