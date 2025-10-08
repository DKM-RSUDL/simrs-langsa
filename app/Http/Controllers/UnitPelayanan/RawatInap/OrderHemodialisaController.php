<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\Unit;
use App\Services\BaseService;
use Illuminate\Http\Request;

class OrderHemodialisaController extends Controller
{
    private $baseService;

    public function __construct()
    {
        $this->baseService = new BaseService();
    }

    public function index($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
        $nginap = $this->baseService->getNginapData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
        $unit = Unit::where('kd_bagian', 1)->where('aktif', 1)->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.order.hd.index', compact('dataMedis', 'nginap', 'unit'));
    }
}
