<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeIntakeOutputCairan extends Model
{
    use HasFactory;

    protected $table = 'rme_intake_output_cairan';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function userCreate()
    {
        return $this->belongsTo(User::class, 'user_create', 'id');
    }

    public function getShiftNameAttribute(): string
    {
        $shiftNames = [
            1 => 'Shift 1 (07:00-14:00)',
            2 => 'Shift 2 (14:00-20:00)',
            3 => 'Shift 3 (20:00-07:00)'
        ];

        return $shiftNames[$this->shift] ?? 'Shift Tidak Dikenal';
    }

    public function getShiftTimeAttribute(): string
    {
        $shiftTimes = [
            1 => '07:00-14:00',
            2 => '14:00-20:00',
            3 => '20:00-07:00'
        ];

        return $shiftTimes[$this->shift] ?? '-';
    }
}