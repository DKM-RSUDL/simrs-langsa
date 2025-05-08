<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\RmeIntakeOutputCairan;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        $intakeData = RmeIntakeOutputCairan::with(['userCreate'])
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.intake-cairan.index', compact(
            'dataMedis',
            'intakeData'
        ));
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
            // get data by tanggal
            $intakeData = RmeIntakeOutputCairan::where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->whereDate('tanggal', $request->tanggal)
                ->first();

            if (!empty($intakeData)) throw new Exception("Data pada tanggal $request->tanggal sudah ada !");

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

            $data = [
                'kd_pasien'             => $kd_pasien,
                'kd_unit'               => $kd_unit,
                'tgl_masuk'             => $tgl_masuk,
                'urut_masuk'            => $urut_masuk,
                'tanggal'               => $request->tanggal,
                'output_pagi_urine'     => $request->output_pagi_urine,
                'output_pagi_muntah'    => $request->output_pagi_muntah,
                'output_pagi_drain'     => $request->output_pagi_drain,
                'output_pagi_iwl'       => $request->output_pagi_iwl,
                'intake_pagi_iufd'      => $request->intake_pagi_iufd,
                'intake_pagi_minum'     => $request->intake_pagi_minum,
                'intake_pagi_makan'     => $request->intake_pagi_makan,
                'intake_pagi_ngt'       => $request->intake_pagi_ngt,
                'output_siang_urine'    => $request->output_siang_urine,
                'output_siang_muntah'   => $request->output_siang_muntah,
                'output_siang_drain'    => $request->output_siang_drain,
                'output_siang_iwl'      => $request->output_siang_iwl,
                'intake_siang_iufd'     => $request->intake_siang_iufd,
                'intake_siang_minum'    => $request->intake_siang_minum,
                'intake_siang_makan'    => $request->intake_siang_makan,
                'intake_siang_ngt'      => $request->intake_siang_ngt,
                'output_malam_urine'    => $request->output_malam_urine,
                'output_malam_muntah'   => $request->output_malam_muntah,
                'output_malam_drain'    => $request->output_malam_drain,
                'output_malam_iwl'      => $request->output_malam_iwl,
                'intake_malam_iufd'     => $request->intake_malam_iufd,
                'intake_malam_minum'    => $request->intake_malam_minum,
                'intake_malam_makan'    => $request->intake_malam_makan,
                'intake_malam_ngt'      => $request->intake_malam_ngt,
                'jml_urine'             => $jmlUrine,
                'jml_muntah'            => $jmlMuntah,
                'jml_drain'             => $jmlDrain,
                'jml_iwl'               => $jmlIWL,
                'total_output'          => $totalOutput,
                'jml_iufd'              => $jmlIUFD,
                'jml_minum'             => $jmlMinum,
                'jml_makan'             => $jmlMakan,
                'jml_ngt'               => $jmlNGT,
                'total_intake'          => $totalIntake,
                'balance_cairan'        => $balance,
                'user_create'           => Auth::id()
            ];

            // store
            RmeIntakeOutputCairan::create($data);
            DB::commit();

            return to_route('rawat-inap.intake-cairan.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'Data intake output cairan berhasil di tambah !');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $idEncrypt)
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

        $id = decrypt($idEncrypt);
        $intake = RmeIntakeOutputCairan::find($id);

        if (empty($intake)) return back()->with('error', 'Data tidak ditemukan !');

        return view('unit-pelayanan.rawat-inap.pelayanan.intake-cairan.edit', compact(
            'dataMedis',
            'intake'
        ));
    }

    public function update($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $idEncrypt, Request $request)
    {
        DB::beginTransaction();

        try {
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

            if (empty($dataMedis)) throw new Exception('Data kunjungan tidak ditemukan !');

            // get data by tanggal
            $id = decrypt($idEncrypt);
            $intakeData = RmeIntakeOutputCairan::find($id);

            if (empty($intakeData)) throw new Exception("Data tidak ditemukan !");

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

            $data = [
                'output_pagi_urine'     => $request->output_pagi_urine,
                'output_pagi_muntah'    => $request->output_pagi_muntah,
                'output_pagi_drain'     => $request->output_pagi_drain,
                'output_pagi_iwl'       => $request->output_pagi_iwl,
                'intake_pagi_iufd'      => $request->intake_pagi_iufd,
                'intake_pagi_minum'     => $request->intake_pagi_minum,
                'intake_pagi_makan'     => $request->intake_pagi_makan,
                'intake_pagi_ngt'       => $request->intake_pagi_ngt,
                'output_siang_urine'    => $request->output_siang_urine,
                'output_siang_muntah'   => $request->output_siang_muntah,
                'output_siang_drain'    => $request->output_siang_drain,
                'output_siang_iwl'      => $request->output_siang_iwl,
                'intake_siang_iufd'     => $request->intake_siang_iufd,
                'intake_siang_minum'    => $request->intake_siang_minum,
                'intake_siang_makan'    => $request->intake_siang_makan,
                'intake_siang_ngt'      => $request->intake_siang_ngt,
                'output_malam_urine'    => $request->output_malam_urine,
                'output_malam_muntah'   => $request->output_malam_muntah,
                'output_malam_drain'    => $request->output_malam_drain,
                'output_malam_iwl'      => $request->output_malam_iwl,
                'intake_malam_iufd'     => $request->intake_malam_iufd,
                'intake_malam_minum'    => $request->intake_malam_minum,
                'intake_malam_makan'    => $request->intake_malam_makan,
                'intake_malam_ngt'      => $request->intake_malam_ngt,
                'jml_urine'             => $jmlUrine,
                'jml_muntah'            => $jmlMuntah,
                'jml_drain'             => $jmlDrain,
                'jml_iwl'               => $jmlIWL,
                'total_output'          => $totalOutput,
                'jml_iufd'              => $jmlIUFD,
                'jml_minum'             => $jmlMinum,
                'jml_makan'             => $jmlMakan,
                'jml_ngt'               => $jmlNGT,
                'total_intake'          => $totalIntake,
                'balance_cairan'        => $balance,
                'user_edit'           => Auth::id()
            ];

            // store
            RmeIntakeOutputCairan::where('id', $id)->update($data);
            DB::commit();

            return to_route('rawat-inap.intake-cairan.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'Data intake output cairan berhasil di ubah !');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function show($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $idEncrypt)
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

        $id = decrypt($idEncrypt);
        $intake = RmeIntakeOutputCairan::find($id);

        if (empty($intake)) return back()->with('error', 'Data tidak ditemukan !');

        return view('unit-pelayanan.rawat-inap.pelayanan.intake-cairan.show', compact(
            'dataMedis',
            'intake'
        ));
    }

    public function delete($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        DB::beginTransaction();

        try {
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

            if (empty($dataMedis)) throw new Exception('Data kunjungan tidak ditemukan !');

            $id = decrypt($request->id_intake);
            $intake = RmeIntakeOutputCairan::find($id);

            if (empty($intake)) throw new Exception('Data tidak ditemukan !');

            $intake->delete();

            DB::commit();
            return back()->with('success', 'Data berhasil dihapus !');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function pdf($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
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
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();

        if (empty($dataMedis)) return back()->with('error', 'Gagal menemukan data kunjungan !');

        $intakeData = RmeIntakeOutputCairan::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->get();

        $pdf = Pdf::loadView('unit-pelayanan.rawat-inap.pelayanan.intake-cairan.pdf', compact(
            'dataMedis',
            'intakeData'
        ))
            ->setPaper('a4', 'potrait');
        return $pdf->stream('intakeoOutputCairan_' . $dataMedis->kd_pasien . '_' . $dataMedis->tgl_masuk . '.pdf');
    }
}
