<?php

namespace App\Http\Controllers\UnitPelayanan\GawatDarurat;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class CarePlanController extends Controller
{
    public function index($kd_pasien)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer'])
        ->where('kd_pasien', $kd_pasien)
            ->first();

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.careplan.index', compact('dataMedis'));
    }
}
