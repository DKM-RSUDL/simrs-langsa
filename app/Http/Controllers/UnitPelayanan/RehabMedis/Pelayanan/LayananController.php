<?php

namespace App\Http\Controllers\UnitPelayanan\RehabMedis\Pelayanan;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    public function index(Request $request, $kd_pasien, $tgl_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
        ->join('transaksi as t', function ($join) {
            $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
            $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
            $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
            $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
        })
        ->where('kunjungan.kd_unit', 214)
        ->where('kunjungan.kd_pasien', $kd_pasien)
        ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
        ->first();

        return view('unit-pelayanan.rehab-medis.pelayanan.layanan.index', compact('dataMedis'));
    }
}
