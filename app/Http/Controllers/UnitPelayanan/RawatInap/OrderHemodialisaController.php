<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\HrdKaryawan;
use App\Models\Unit;
use App\Services\BaseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        $petugas = HrdKaryawan::where('kd_jenis_tenaga', 2)
            ->where('kd_detail_jenis_tenaga', 1)
            ->where('status_peg', 1)
            ->where('kd_karyawan', '!=', Auth::user()->kd_karyawan)
            ->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.order.hd.index', compact('dataMedis', 'nginap', 'unit', 'petugas'));
    }

    public function store($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        DB::beginTransaction();

        try {
            $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
            $nginap = $this->baseService->getNginapData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

            if(empty($dataMedis)) throw new Exception('Data kunjungan tidak ditemukan');

            dd($request->all());

        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}