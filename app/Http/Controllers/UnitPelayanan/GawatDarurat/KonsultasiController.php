<?php

namespace App\Http\Controllers\UnitPelayanan\GawatDarurat;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\DokterKlinik;
use App\Models\Kunjungan;
use App\Models\Unit;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class KonsultasiController extends Controller
{
    public function index($kd_pasien, $tgl_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_unit', 3)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();

        
        $dokterPengirim = DokterKlinik::with(['dokter', 'unit'])
                                    ->where('kd_unit', 3)
                                    ->whereRelation('dokter', 'status', 1)
                                    ->get();
    
        $unit = Unit::where('kd_bagian', 2)
                    ->where('aktif', 1)
                    ->get();


        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        return view(
            'unit-pelayanan.gawat-darurat.action-gawat-darurat.konsultasi.index',
            compact(
                'dataMedis',
                'dokterPengirim',
                'unit',
            )
        );
    }

    public function getDokterbyUnit(Request $request)
    {
        try {
            $dokter = DokterKlinik::with(['dokter', 'unit'])
                                ->where('kd_unit', $request->kd_unit)
                                ->whereRelation('dokter', 'status', 1)
                                ->get();

            if(count($dokter) > 0) {
                return response()->json([
                    'status'    => 'success',
                    'message'   => 'Data ditemukan',
                    'data'      => $dokter
                ]);
            } else {
                return response()->json([
                    'status'    => 'error',
                    'message'   => 'Data tidak ditemukan',
                    'data'      => []
                ]);
            }

        } catch (Exception $e) {
            return response()->json([
                'status'    => 'error',
                'message'   => $e->getMessage(),
                'data'      => []
            ], 500);
        }
    }
}
