<?php

namespace App\Http\Controllers\Bridging\Bpjs;

use App\Http\Controllers\Controller;
use App\Services\BaseService;
use App\Services\Bpjs\BpjsService;
use Exception;
use Illuminate\Http\Request;

class BpjsController extends Controller
{
    private $baseService;
    private $bpjsService;

    public function __construct()
    {
        $this->baseService = new BaseService();
        $this->bpjsService = new BpjsService();
    }

    public function icare(Request $request)
    {
        try {
            $kd_unit = $request->kd_unit ?? '0000000000000';
            $kd_pasien = $request->kd_pasien ?? '0000000000000';
            $tgl_masuk = $request->tgl_masuk ?? '0000000000000';
            $urut_masuk = $request->urut_masuk ?? '0000000000000';

            $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
            if (!$dataMedis) throw new Exception('Data medis tidak ditemukan.');

            $icare = $this->bpjsService->icare($dataMedis->pasien->no_asuransi ?? null, $dataMedis->dokter->kd_user ?? null);
            if ($icare['status'] == 'error') throw new Exception($icare['message']);

            $url = $icare['data'];

            return response()->json([
                'status'    => 'success',
                'message'   => 'OK',
                'data'      => $url
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'    => 'error',
                'message'   => $e->getMessage(),
                'data'      => []
            ]);
        }
    }
}
