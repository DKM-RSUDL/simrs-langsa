<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable; // Import Trait library

class MasterBerkasDigital extends Model
{
    use Sluggable; // Gunakan Trait agar fitur aktif

    protected $table = 'RME_MR_BERKAS_DIGITAL'; // Sesuai Navicat

    protected $fillable = [
        'nama_berkas',
        'slug',
        'user_create',
        'user_update'
    ];

    public $timestamps = false;

    /**
     * Pengaturan Sluggable Otomatis
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'nama_berkas', // Ambil teks dari kolom nama_berkas
                'separator' => '_',       // Gunakan underscore sesuai instruksi
                'unique' => true,         // Menjamin tidak akan ada slug kembar
                'onUpdate' => true,       // Slug berubah otomatis jika nama berkas di-edit
            ]
        ];
    }
}
