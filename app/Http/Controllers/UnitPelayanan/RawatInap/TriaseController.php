<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\AsalIGD;
use App\Models\DataTriase;
use App\Services\AsesmenService;
use App\Services\BaseService;
use Illuminate\Http\Request;

class TriaseController extends Controller
{
    private $asesmenService;
    private $baseService;

    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
        $this->baseService = new BaseService();
        $this->asesmenService = new AsesmenService();
    }

    public function show($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {

        // get kunjungan ranap
        $dataMedis = $this->baseService->getDataMedis(
            $kd_unit,
            $kd_pasien,
            $tgl_masuk,
            $urut_masuk
        );

        if (empty($dataMedis)) {
            abort(404, 'Data kunjungan tidak ditemukan !');
        }


        // GET ASAL IGD
        $asalIGD = AsalIGD::where('kd_kasir', $dataMedis->kd_kasir)->where('no_transaksi', $dataMedis->no_transaksi)->first();

        if (empty($asalIGD)) {
            abort(404, 'Data IGD tidak ditemukan !');
        }

        // get kunjungan IGD
        $kunjunganIGD = $this->baseService->getDataMedisbyTransaksi($asalIGD->kd_kasir_asal, $asalIGD->no_transaksi_asal);

        if (empty($kunjunganIGD)) {
            abort(404, 'Data kunjungan IGD tidak ditemukan !');
        }

        // get data triase
        $triase = DataTriase::with(['dokter'])->find($kunjunganIGD->triase_id);

        if (empty($triase)) {
            abort(404, 'Data triase tidak ditemukan');
        }

        $vitalSign = json_decode($triase->vital_sign, true);
        $triase->triase = json_decode($triase->triase, true);




        return view(
            'unit-pelayanan.rawat-inap.pelayanan.triase.show',
            compact('dataMedis', 'vitalSign', 'triase')
        );
    }
}
