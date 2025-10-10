<?php

namespace App\Http\Controllers\UnitPelayanan\Operasi;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\OkAsesmen;
use App\Models\OkPraOperasiMedis;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PraAnestesiMedisController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/operasi');
    }

    public function create($kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', 71)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();

        // Menghitung umur berdasarkan tgl_lahir jika ada
        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        return view('unit-pelayanan.operasi.pelayanan.asesmen.pra-anestesi.medis.create', compact('dataMedis'));
    }

    public function store($kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {

        DB::beginTransaction();

        try {

            // create asesmen
            $asesmen = new OkAsesmen();
            $asesmen->kd_pasien = $kd_pasien;
            $asesmen->kd_unit = 71;
            $asesmen->tgl_masuk = $tgl_masuk;
            $asesmen->urut_masuk = $urut_masuk;
            $asesmen->kategori = 1;
            $asesmen->waktu_asesmen = date('Y-m-d H:i:s');
            $asesmen->user_create = Auth::id();
            $asesmen->save();

            // create asesmen pra operasi medis
            $data = [
                'id_asesmen'            => $asesmen->id,
                'kd_pasien'             => $kd_pasien,
                'kd_unit'               => 71,
                'tgl_masuk'             => $tgl_masuk,
                'urut_masuk'            => $urut_masuk,
                'tgl_op'                => "$request->tgl_masuk $request->jam_masuk",
                'diagnosa_pra_operasi'  => $request->diagnosa_pra_operatif,
                'timing_tindakan'       => $request->timing_tindakan,
                'indikasi_tindakan'     => $request->indikasi_tindakan,
                'rencana_tindakan'      => $request->rencana_tindakan,
                'prosedur_tindakan'     => $request->prosedur_tindakan,
                'waktu_tindakan'        => "$request->tgl_tindakan $request->jam_tindakan",
                'alternatif_lain'       => $request->alternatif_lain,
                'resiko'                => $request->resiko,
            ];

            OkPraOperasiMedis::create($data);

            DB::commit();
            return to_route('operasi.pelayanan.asesmen.index', [$kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'Asesmen Pra Operatif Medis berhasil di tambah !');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', 71)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();

        // Menghitung umur berdasarkan tgl_lahir jika ada
        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        $asesmen = OkAsesmen::find($id);

        return view('unit-pelayanan.operasi.pelayanan.asesmen.pra-anestesi.medis.edit', compact('dataMedis', 'asesmen'));
    }

    public function update($kd_pasien, $tgl_masuk, $urut_masuk, $idEncrypt, Request $request)
    {
        DB::beginTransaction();

        try {
            $id = decrypt($idEncrypt);
            $PraOperatif = OkPraOperasiMedis::find($id);

            $asesmen = OkAsesmen::find($PraOperatif->id_asesmen);
            $asesmen->user_edit = Auth::id();
            $asesmen->save();

            // create asesmen pra operasi medis
            $data = [
                'tgl_op'                => "$request->tgl_masuk $request->jam_masuk",
                'diagnosa_pra_operasi'  => $request->diagnosa_pra_operatif,
                'timing_tindakan'       => $request->timing_tindakan,
                'indikasi_tindakan'     => $request->indikasi_tindakan,
                'rencana_tindakan'      => $request->rencana_tindakan,
                'prosedur_tindakan'     => $request->prosedur_tindakan,
                'waktu_tindakan'        => "$request->tgl_tindakan $request->jam_tindakan",
                'alternatif_lain'       => $request->alternatif_lain,
                'resiko'                => $request->resiko,
            ];

            OkPraOperasiMedis::where('id', $id)->update($data);
            DB::commit();
            return to_route('operasi.pelayanan.asesmen.index', [$kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'Asesmen Pra Operatif Medis berhasil di ubah !');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function show($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
                ->join('transaksi as t', function ($join) {
                    $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                    $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                    $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                    $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
                })
                ->where('kunjungan.kd_pasien', $kd_pasien)
                ->where('kunjungan.kd_unit', 71)
                ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
                ->where('kunjungan.urut_masuk', $urut_masuk)
                ->first();

            // Menghitung umur berdasarkan tgl_lahir jika ada
            if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
                $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
            } else {
                $dataMedis->pasien->umur = 'Tidak Diketahui';
            }

            if (!$dataMedis) {
                abort(404, 'Data not found');
            }

            $asesmen = OkAsesmen::find($id);

            return view('unit-pelayanan.operasi.pelayanan.asesmen.pra-anestesi.medis.show', compact('dataMedis', 'asesmen'));
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
