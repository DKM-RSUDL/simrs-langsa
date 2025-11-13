<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\DokterInap;
use App\Models\Kunjungan;
use App\Models\RmeAsuhanKeperawatan;
use App\Models\RMEResume;
use App\Models\RmeResumeDtl;
use App\Services\AsesmenService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AsuhanKeperawatanRawatInapController extends Controller
{
    protected $asesmenService;
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
        $this->asesmenService = new AsesmenService();
    }

    public function index(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
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

        $dataDokter = DokterInap::with(['dokter', 'unit'])
            ->where('kd_unit', '1001')
            ->whereRelation('dokter', 'status', 1)
            ->get();

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        $asuhan = RmeAsuhanKeperawatan::with(['userCreate'])
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.asuhan-keperawatan.index', compact(
            'dataMedis',
            'dataDokter',
            'asuhan'
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

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        return view('unit-pelayanan.rawat-inap.pelayanan.asuhan-keperawatan.create',  compact('dataMedis'));
    }

    public function store($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
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

            if (empty($dataMedis)) {
                return back()->with('error', 'Kunjungan pasien tidak ditemukan !');
            }

            // data
            $asuhan = new RmeAsuhanKeperawatan();
            $asuhan->kd_pasien = $kd_pasien;
            $asuhan->kd_unit = $kd_unit;
            $asuhan->tgl_masuk = $tgl_masuk;
            $asuhan->urut_masuk = $urut_masuk;
            $asuhan->tgl_implementasi = $request->tgl_implementasi;
            $asuhan->waktu = $request->waktu;
            $asuhan->airway = $request->airway;
            $asuhan->pernafasan = $request->pernafasan;
            $asuhan->tanda_vital = $request->tanda_vital;
            $asuhan->nyeri = $request->nyeri;
            $asuhan->nutrisi = $request->nutrisi;
            $asuhan->eliminasi = $request->eliminasi;
            $asuhan->personal_hygiene = $request->personal_hygiene;
            $asuhan->ginekologi = $request->ginekologi;
            $asuhan->sosial = $request->sosial;
            $asuhan->edukasi = $request->edukasi;
            $asuhan->cedera = $request->cedera;
            $asuhan->lainnya = $request->lainnya;
            $asuhan->makan_via = $request->makan_via;
            $asuhan->user_create = Auth::id();
            $asuhan->save();

            // $vitalSignData = [
            //     'sistole'      => $request->sistole ? (int)$request->sistole : null,
            //     'diastole'     => $request->diastole ? (int)$request->diastole : null,
            //     'nadi'         => $request->nadi ? (int)$request->nadi : null,
            //     'respiration'  => $request->pernafasan ? (int)$request->pernafasan : null,
            //     'suhu'         => $request->suhu ? (float)$request->suhu : null,
            //     'tinggi_badan' => $request->tb ? (int)$request->tb : null,
            //     'berat_badan'  => $request->bb ? (int)$request->bb : null,
            // ];

            // $lastTransaction = $this->asesmenService->getTransaksiData(
            //     $kd_unit,
            //     $kd_pasien,
            //     $tgl_masuk,
            //     $urut_masuk
            // );

            // $this->asesmenService->store(
            //     $vitalSignData,
            //     $kd_pasien,
            //     $lastTransaction->no_transaction,
            //     $lastTransaction->kd_kasir
            // );
            // // --- End Vital Sign ---

            DB::commit();
            return to_route('rawat-inap.asuhan-keperawatan.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data berhasil di tambah !');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }



    public function edit($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
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

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        $asuhan = RmeAsuhanKeperawatan::find($id);

        if (!$dataMedis || empty($asuhan)) {
            abort(404, 'Data not found');
        }

        return view('unit-pelayanan.rawat-inap.pelayanan.asuhan-keperawatan.edit',  compact('dataMedis', 'asuhan'));
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

            if (empty($dataMedis)) {
                return back()->with('error', 'Kunjungan pasien tidak ditemukan !');
            }


            $id = decrypt($idEncrypt);

            // data
            $asuhan = RmeAsuhanKeperawatan::find($id);
            $asuhan->tgl_implementasi = $request->tgl_implementasi;
            $asuhan->waktu = $request->waktu;
            $asuhan->airway = $request->airway;
            $asuhan->pernafasan = $request->pernafasan;
            $asuhan->tanda_vital = $request->tanda_vital;
            $asuhan->nyeri = $request->nyeri;
            $asuhan->nutrisi = $request->nutrisi;
            $asuhan->eliminasi = $request->eliminasi;
            $asuhan->personal_hygiene = $request->personal_hygiene;
            $asuhan->ginekologi = $request->ginekologi;
            $asuhan->sosial = $request->sosial;
            $asuhan->edukasi = $request->edukasi;
            $asuhan->cedera = $request->cedera;
            $asuhan->lainnya = $request->lainnya;
            $asuhan->makan_via = $request->makan_via;
            $asuhan->user_edit = Auth::id();
            $asuhan->save();


            DB::commit();
            return to_route('rawat-inap.asuhan-keperawatan.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'Data berhasil di ubah !');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function show($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
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

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        $asuhan = RmeAsuhanKeperawatan::find($id);

        if (!$dataMedis || empty($asuhan)) {
            abort(404, 'Data not found');
        }

        return view('unit-pelayanan.rawat-inap.pelayanan.asuhan-keperawatan.show',  compact('dataMedis', 'asuhan'));
    }

    public function destroy($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
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
                ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
                ->where('kunjungan.urut_masuk', $urut_masuk)
                ->first();


            if (empty($dataMedis)) {
                return response()->json([
                    'status'    => 'error',
                    'message'   => 'Kunjungan pasien tidak ditemukan !',
                    'data'      => []
                ]);
            }

            $id = decrypt($request->asuhan);

            $asuhan = RmeAsuhanKeperawatan::find($id);

            if (empty($asuhan)) {
                return response()->json([
                    'status'    => 'error',
                    'message'   => 'Data tidak ditemukan !',
                    'data'      => []
                ]);
            }

            RmeAsuhanKeperawatan::where('id', $id)->delete();

            DB::commit();
            return response()->json([
                'status'    => 'success',
                'message'   => 'OK !',
                'data'      => []
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
