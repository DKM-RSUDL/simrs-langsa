<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeMppB extends Model
{
    use HasFactory;

    protected $table = 'RME_MPP_B';
    protected $guarded = ['id'];

    public function __set($key, $value)
    {
        // Allow setting dynamic properties
        if (in_array($key, ['dpjpUtama', 'dokterTambahanNames', 'petugasTerkaitNames'])) {
            $this->attributes[$key] = $value;
            return;
        }

        parent::__set($key, $value);
    }

    public function __get($key)
    {
        // Allow getting dynamic properties
        if (in_array($key, ['dpjpUtama', 'dokterTambahanNames', 'petugasTerkaitNames'])) {
            return $this->attributes[$key] ?? null;
        }

        return parent::__get($key);
    }


    public function dpjpUtama()
    {
        return $this->belongsTo(Dokter::class, 'dpjp_utama', 'kd_dokter');
    }

    public function dokter1()
    {
        return $this->belongsTo(Dokter::class, 'dokter_1', 'kd_dokter');
    }

    public function dokter2()
    {
        return $this->belongsTo(Dokter::class, 'dokter_2', 'kd_dokter');
    }

    public function dokter3()
    {
        return $this->belongsTo(Dokter::class, 'dokter_3', 'kd_dokter');
    }

    public function petugasTerkait1()
    {
        return $this->belongsTo(HrdKaryawan::class, 'petugas_terkait_1', 'kd_karyawan');
    }

    public function petugasTerkait2()
    {
        return $this->belongsTo(HrdKaryawan::class, 'petugas_terkait_2', 'kd_karyawan');
    }

    public function userCreate()
    {
        return $this->belongsTo(User::class, 'user_create');
    }

    public function userUpdate()
    {
        return $this->belongsTo(User::class, 'user_update');
    }
}
