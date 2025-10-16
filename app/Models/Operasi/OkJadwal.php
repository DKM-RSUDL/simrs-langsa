<?php

namespace App\Models\Operasi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OkJadwal extends Model
{
    use HasFactory;

    protected $table = 'OK_JADWAL';
    protected $guarded = [];
    public $timestamps = false;

    /**
     * Generate next patterned no_urut string with IBS prefix.
     * Returns array: ['no_urut' => string] where value looks like 'IBS00000001'.
     */
    public static function generateNoUrut()
    {
        // Find last existing no_urut that starts with 'IBS' and increment its numeric suffix
    $lastNoUrutStr = DB::table('OK_JADWAL')->max('no_urut');

        if ($lastNoUrutStr) {
            $lastNum = intval(preg_replace('/\D/', '', $lastNoUrutStr));
            $nextNum = $lastNum + 1;
        } else {
            $nextNum = 1;
        }

        $nextNumPadded = str_pad($nextNum, 8, '0', STR_PAD_LEFT);
        $newNoUrutStr = 'IBS' . $nextNumPadded;

        return $newNoUrutStr;
    }
}
