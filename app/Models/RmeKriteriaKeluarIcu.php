<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeKriteriaKeluarIcu extends Model
{
    use HasFactory;

    protected $table = 'RME_KRITERIA_KELUAR_ICU';
    public $timestamps = false;

    protected $guarded = ['id'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_create', 'id');
    }
}
