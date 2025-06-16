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
            ->orderBy('shift', 'asc')
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
            // Validasi input
            $request->validate([
                'tanggal' => 'required|date',
                'shift' => 'required|in:1,2,3',
                'output_urine' => 'required|numeric|min:0',
                'output_muntah' => 'required|numeric|min:0',
                'output_drain' => 'required|numeric|min:0',
                'output_iwl' => 'required|numeric|min:0',
                'intake_iufd' => 'required|numeric|min:0',
                'intake_minum' => 'required|numeric|min:0',
                'intake_makan' => 'required|numeric|min:0',
                'intake_ngt' => 'required|numeric|min:0',
            ]);

            // Cek apakah data untuk tanggal dan shift tersebut sudah ada
            $existingData = RmeIntakeOutputCairan::where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->whereDate('tanggal', $request->tanggal)
                ->where('shift', $request->shift)
                ->first();

            if ($existingData) {
                $shiftName = $this->getShiftName($request->shift);
                throw new Exception("Data untuk tanggal {$request->tanggal} shift {$shiftName} sudah ada!");
            }

            // Hitung total output
            $totalOutput = $request->output_urine + $request->output_muntah +
                $request->output_drain + $request->output_iwl;

            // Hitung total intake
            $totalIntake = $request->intake_iufd + $request->intake_minum +
                $request->intake_makan + $request->intake_ngt;

            // Hitung balance cairan
            $balance = $totalIntake - $totalOutput;

            // Siapkan data untuk disimpan
            $data = [
                'kd_pasien'      => $kd_pasien,
                'kd_unit'        => $kd_unit,
                'tgl_masuk'      => $tgl_masuk,
                'urut_masuk'     => $urut_masuk,
                'tanggal'        => $request->tanggal,
                'shift'          => $request->shift,

                // Output data
                'output_urine'   => $request->output_urine,
                'output_muntah'  => $request->output_muntah,
                'output_drain'   => $request->output_drain,
                'output_iwl'     => $request->output_iwl,
                'total_output'   => $totalOutput,

                // Intake data
                'intake_iufd'    => $request->intake_iufd,
                'intake_minum'   => $request->intake_minum,
                'intake_makan'   => $request->intake_makan,
                'intake_ngt'     => $request->intake_ngt,
                'total_intake'   => $totalIntake,

                // Balance
                'balance_cairan' => $balance,

                'user_create'    => Auth::id(),
                'created_at'     => now(),
            ];

            // Simpan data
            RmeIntakeOutputCairan::create($data);

            DB::commit();

            $shiftName = $this->getShiftName($request->shift);
            return to_route('rawat-inap.intake-cairan.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', "Data intake output cairan {$shiftName} berhasil ditambahkan!");
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function checkDuplicate($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        $tanggal = $request->get('tanggal');
        $shift = $request->get('shift');

        $exists = RmeIntakeOutputCairan::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tanggal', $tanggal)
            ->where('shift', $shift)
            ->exists();

        $shiftName = $this->getShiftName($shift);

        return response()->json([
            'exists' => $exists,
            'shift_name' => $shiftName
        ]);
    }
    private function getShiftName($shift)
    {
        $shiftNames = [
            1 => 'Shift 1 (07:00-14:00)',
            2 => 'Shift 2 (14:00-20:00)',
            3 => 'Shift 3 (20:00-07:00)'
        ];

        return $shiftNames[$shift] ?? 'Shift Tidak Dikenal';
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

        if (empty($intake)) {
            return back()->with('error', 'Data tidak ditemukan!');
        }

        return view('unit-pelayanan.rawat-inap.pelayanan.intake-cairan.edit', compact(
            'dataMedis',
            'intake'
        ));
    }

    public function update($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $idEncrypt, Request $request)
    {
        DB::beginTransaction();

        try {
            // Validasi input
            $request->validate([
                'output_urine' => 'required|numeric|min:0',
                'output_muntah' => 'required|numeric|min:0',
                'output_drain' => 'required|numeric|min:0',
                'output_iwl' => 'required|numeric|min:0',
                'intake_iufd' => 'required|numeric|min:0',
                'intake_minum' => 'required|numeric|min:0',
                'intake_makan' => 'required|numeric|min:0',
                'intake_ngt' => 'required|numeric|min:0',
            ]);

            $id = decrypt($idEncrypt);
            $intake = RmeIntakeOutputCairan::find($id);

            if (empty($intake)) {
                throw new Exception('Data tidak ditemukan!');
            }

            // Hitung total output
            $totalOutput = $request->output_urine + $request->output_muntah +
                $request->output_drain + $request->output_iwl;

            // Hitung total intake
            $totalIntake = $request->intake_iufd + $request->intake_minum +
                $request->intake_makan + $request->intake_ngt;

            // Hitung balance cairan
            $balance = $totalIntake - $totalOutput;

            // Data untuk update
            $data = [
                // Output data
                'output_urine'   => $request->output_urine,
                'output_muntah'  => $request->output_muntah,
                'output_drain'   => $request->output_drain,
                'output_iwl'     => $request->output_iwl,
                'total_output'   => $totalOutput,

                // Intake data
                'intake_iufd'    => $request->intake_iufd,
                'intake_minum'   => $request->intake_minum,
                'intake_makan'   => $request->intake_makan,
                'intake_ngt'     => $request->intake_ngt,
                'total_intake'   => $totalIntake,

                // Balance
                'balance_cairan' => $balance,

                'user_edit'      => Auth::id(),
            ];

            // Update data
            $intake->update($data);

            DB::commit();

            return to_route('rawat-inap.intake-cairan.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', "Data intake output cairan {$intake->shift_name} berhasil diupdate!");
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage())->withInput();
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

        if (empty($dataMedis)) {
            return back()->with('error', 'Gagal menemukan data kunjungan!');
        }

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        $intakeData = RmeIntakeOutputCairan::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->orderBy('tanggal', 'asc')
            ->orderBy('shift', 'asc')
            ->get();

        $pdf = Pdf::loadView('unit-pelayanan.rawat-inap.pelayanan.intake-cairan.pdf', compact(
            'dataMedis',
            'intakeData'
        ))
            ->setPaper('a4', 'landscape'); // Menggunakan landscape karena banyak kolom

        return $pdf->stream('intake_output_cairan_' . $dataMedis->kd_pasien . '_' . date('Y-m-d', strtotime($dataMedis->tgl_masuk)) . '.pdf');
    }
}
