<?php

namespace App\Http\Controllers\UnitPelayanan\GawatDarurat;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\RmeDnr;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenolakanResusitasiController extends Controller
{
    private $kdUnit_;

    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/gawat-darurat');
        $this->kdUnit_ = 3;
    }

    public function index($kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', $this->kdUnit_)
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

        $dnr = RmeDnr::with(['dokter'])
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $this->kdUnit_)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->get();

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.dnr.index', compact(
            'dataMedis',
            'dnr'
        ));
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
            ->where('kunjungan.kd_unit', $this->kdUnit_)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();

        if (empty($dataMedis)) return back()->with('error', 'Data kunjungan tidak dapat ditemukan !');

        $dokter = Dokter::where('status', 1)->get();

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.dnr.create', compact('dataMedis', 'dokter'));
    }

    public function store($kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        DB::beginTransaction();

        try {
            $pasien = Pasien::where('kd_pasien', $kd_pasien)->first();
            if (empty($pasien)) throw new Exception('Data pasien tidak ditemukan !');

            $data = [
                'kd_pasien'         => $kd_pasien,
                'kd_unit'         => $this->kdUnit_,
                'tgl_masuk'         => $tgl_masuk,
                'urut_masuk'         => $urut_masuk,
                'tanggal'         => $request->tanggal,
                'kd_dokter'         => $request->kd_dokter,
                'no_hp_dokter'         => $request->no_hp_dokter,
                'instruksi'         => $request->instruksi,
                'keputusan'         => $request->keputusan,
                'dasar_perintah'         => $request->dasar_perintah,
                'user_create'         => Auth::id(),
            ];

            RmeDnr::create($data);

            DB::commit();
            return to_route('dnr.index', [$kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'Pernyataan penolakan resusitasi berhasil di tambah !');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit($kd_pasien, $tgl_masuk, $urut_masuk, $idEncrypt)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', $this->kdUnit_)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();

        if (empty($dataMedis)) return back()->with('error', 'Data kunjungan tidak dapat ditemukan !');

        $dokter = Dokter::where('status', 1)->get();
        $id = decrypt($idEncrypt);
        $dnr = RmeDnr::find($id);

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.dnr.edit', compact('dataMedis', 'dokter', 'dnr'));
    }

    public function update($kd_pasien, $tgl_masuk, $urut_masuk, $idEncrypt, Request $request)
    {
        DB::beginTransaction();

        try {
            $pasien = Pasien::where('kd_pasien', $kd_pasien)->first();
            if (empty($pasien)) throw new Exception('Data pasien tidak ditemukan !');

            $id = decrypt($idEncrypt);
            $dnr = RmeDnr::where('id', $id)->first();
            if (empty($dnr)) throw new Exception('Data DNR tidak ditemukan !');

            $data = [
                'tanggal'         => $request->tanggal,
                'kd_dokter'         => $request->kd_dokter,
                'no_hp_dokter'         => $request->no_hp_dokter,
                'instruksi'         => $request->instruksi,
                'keputusan'         => $request->keputusan,
                'dasar_perintah'         => $request->dasar_perintah,
                'user_edit'         => Auth::id(),
            ];

            RmeDnr::where('id', $dnr->id)->update($data);

            DB::commit();
            return to_route('dnr.index', [$kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'Pernyataan penolakan resusitasi berhasil di ubah !');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function show($kd_pasien, $tgl_masuk, $urut_masuk, $idEncrypt)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', $this->kdUnit_)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();

        if (empty($dataMedis)) return back()->with('error', 'Data kunjungan tidak dapat ditemukan !');

        $dokter = Dokter::where('status', 1)->get();
        $id = decrypt($idEncrypt);
        $dnr = RmeDnr::find($id);

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.dnr.show', compact('dataMedis', 'dokter', 'dnr'));
    }

    public function delete($kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        DB::beginTransaction();

        try {
            $id = decrypt($request->id_dnr);
            $dnr = RmeDnr::find($id);

            if (empty($dnr)) throw new Exception('Data dnr tidak ditemukan !');

            $dnr->delete();

            DB::commit();
            return back()->with('success', 'Data dnr berhasil dihapus !');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function pdf($kd_pasien, $tgl_masuk, $urut_masuk, $idEncrypt)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', $this->kdUnit_)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();

        if (empty($dataMedis)) return back()->with('error', 'Gagal menemukan data kunjungan !');

        $id = decrypt($idEncrypt);
        $dnr = RmeDnr::find($id);

        $pdf = Pdf::loadView('unit-pelayanan.gawat-darurat.action-gawat-darurat.dnr.pdf', compact(
            'dataMedis',
            'dnr'
        ))
            ->setPaper('a4', 'potrait');
        return $pdf->stream('DNR_' . $dataMedis->kd_pasien . '_' . $dataMedis->tgl_masuk . '.pdf');
    }
}