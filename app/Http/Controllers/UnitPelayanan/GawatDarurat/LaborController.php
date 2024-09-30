<?php

namespace App\Http\Controllers\UnitPelayanan\GawatDarurat;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\LapLisItemPemeriksaan;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class LaborController extends Controller
{
    public function index(Request $request, $kd_pasien)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer'])
            ->where('kd_pasien', $kd_pasien)
            ->first();

        $DataLapPemeriksaan = LapLisItemPemeriksaan::all();

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.labor.index', compact('dataMedis', 'DataLapPemeriksaan'));
    }
}
