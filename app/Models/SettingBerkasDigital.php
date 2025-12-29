<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingBerkasDigital extends Model
{
    use HasFactory;

    protected $table = 'RME_SETTING_BERKAS_DIGITAL';

    protected $fillable = [
        'nama_berkas',
        'aktif',
    ];

    public $timestamps = false;
}
