<?php

namespace App\Http\Controllers\UnitPelayanan\GawatDarurat;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\LapLisItemPemeriksaan;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class LaborController extends Controller
{
    public function index(Request $request, $kd_pasien, $tgl_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer'])
        ->join('transaksi as t', function($join) {
            $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
            $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
            $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
            $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
        })
        ->where('kunjungan.kd_pasien', $kd_pasien)
        ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
        ->first();

        $DataLapPemeriksaan = LapLisItemPemeriksaan::select('kategori', 'nama')
            ->get()
            ->groupBy('kategori');

        $dataDokter = Dokter::all();

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.labor.index', compact(
            'dataMedis',
            'DataLapPemeriksaan',
            'dataDokter'
        ));
    }
}

// - selaga_order
// - selaga_order_det
