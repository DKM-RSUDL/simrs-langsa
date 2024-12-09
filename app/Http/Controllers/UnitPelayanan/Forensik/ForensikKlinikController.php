<?php

namespace App\Http\Controllers\UnitPelayanan\Forensik;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ForensikKlinikController extends Controller
{
    public function index()
    {
        $unit = Unit::with(['bagian'])
        ->whereIn('kd_unit', ['228', '76'])
        ->get();

        return view('unit-pelayanan.forensik.create', compact('unit'));
    }


    public function create($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
        ->where('kd_unit', $kd_unit)
            ->where('kd_pasien', $kd_pasien)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->first();

        // Menghitung umur berdasarkan tgl_lahir jika ada
        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        return view(
            'unit-pelayanan.forensik.pelayanan.create',
            compact(
                'dataMedis',
                'kd_unit',
                'kd_pasien',
                'tgl_masuk',
                'urut_masuk'
            )
        );
    }
}
