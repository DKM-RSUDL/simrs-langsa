<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IntakeCairanController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
    }

    public function index($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', $kd_unit)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        return view('unit-pelayanan.rawat-inap.pelayanan.intake-cairan.index', [
            'dataMedis'     => $dataMedis,
        ]);
    }

    public function create($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', $kd_unit)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        return view('unit-pelayanan.rawat-inap.pelayanan.intake-cairan.create', [
            'dataMedis'     => $dataMedis,
        ]);
    }

    public function store($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        DB::beginTransaction();

        try {
            // hitung total output
            $jmlUrine = $request->output_pagi_urine + $request->output_siang_urine + $request->output_malam_urine;
            $jmlMuntah = $request->output_pagi_muntah + $request->output_siang_muntah + $request->output_malam_muntah;
            $jmlDrain = $request->output_pagi_drain + $request->output_siang_drain + $request->output_malam_drain;
            $jmlIWL = $request->output_pagi_iwl + $request->output_siang_iwl + $request->output_malam_iwl;
            $totalOutput = $jmlUrine + $jmlMuntah + $jmlDrain + $jmlIWL;

            // hitung total intake
            $jmlIUFD = $request->intake_pagi_iufd + $request->intake_siang_iufd + $request->intake_malam_iufd;
            $jmlMinum = $request->intake_pagi_minum + $request->intake_siang_minum + $request->intake_malam_minum;
            $jmlMakan = $request->intake_pagi_makan + $request->intake_siang_makan + $request->intake_malam_makan;
            $jmlNGT = $request->intake_pagi_ngt + $request->intake_siang_ngt + $request->intake_malam_ngt;
            $totalIntake = $jmlIUFD + $jmlMinum + $jmlMakan + $jmlNGT;

            // balance
            $balance = $totalIntake - $totalOutput;
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}