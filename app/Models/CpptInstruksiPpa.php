<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CpptInstruksiPpa extends Model
{
    use HasFactory;
    protected $table = 'CPPT_INSTRUKSI_PPA';
    public $timestamps = false;
    protected $guarded = ['id'];

    protected $appends = ['nama_lengkap'];
    
    public function cppt()
    {
        return $this->belongsTo(Cppt::class, 'urut_total_cppt', 'urut_total');
    }
    
    public function karyawan()
    {
        return $this->belongsTo(HrdKaryawan::class, 'ppa', 'kd_karyawan');
    }
    
    // Accessor untuk nama lengkap
    public function getNamaLengkapAttribute()
    {
        if (!$this->karyawan) {
            return $this->ppa;
        }
        
        $nama_lengkap = '';
        if (!empty($this->karyawan->gelar_depan)) {
            $nama_lengkap .= $this->karyawan->gelar_depan . ' ';
        }
        $nama_lengkap .= $this->karyawan->nama;
        if (!empty($this->karyawan->gelar_belakang)) {
            $nama_lengkap .= ', ' . $this->karyawan->gelar_belakang;
        }
        
        return $nama_lengkap;
    }
}
