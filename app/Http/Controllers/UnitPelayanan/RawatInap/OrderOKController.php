<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\OrderOK;
use App\Services\BaseService;
use Illuminate\Http\Request;

class OrderOKController extends Controller
{
    private $baseService;
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
        $this->baseService = new BaseService();
    }
    public function show($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $tgl_op, $jam_op)
    {
        $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

        if (!$dataMedis) {
            abort(404, 'Data tidak ditemukan');
        }

        $operasi = OrderOK::where('kd_kasir', $dataMedis->kd_kasir)
            ->where('no_transaksi', $dataMedis->no_transaksi)
            ->whereIn('status', [1, 2])
            ->where('tgl_op', $tgl_op)
            ->where('jam_op', $jam_op)
            ->first(['tgl_op', 'jam_op']);

        if (!$operasi) {
            abort(404, 'Data operasi tidak ditemukan');
        }

        return view('unit-pelayanan.rawat-inap.pelayanan.order.operasi.show', [
            'dataMedis' => $dataMedis,
            'tgl_op' => $tgl_op,
            'jam_op' => $jam_op,
            'operasi' => $operasi,
        ]);
    }
}