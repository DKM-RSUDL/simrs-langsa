<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\RmeKontrolIstimewa;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KontrolIstimewaController extends Controller
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

        $kontrol = RmeKontrolIstimewa::with(['userCreate'])
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.kontrol-istimewa.index', compact(
            'dataMedis',
            'kontrol'
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

        if (empty($dataMedis)) return back()->with('error', 'Data kunjungan tidak dapat ditemukan !');

        return view('unit-pelayanan.rawat-inap.pelayanan.kontrol-istimewa.create', compact('dataMedis'));
    }

    public function store($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        DB::beginTransaction();

        try {
            $pasien = Pasien::where('kd_pasien', $kd_pasien)->first();
            if (empty($pasien)) throw new Exception('Data pasien tidak ditemukan !');

            $data = [
                'kd_pasien'     => $kd_pasien,
                'kd_unit'     => $kd_unit,
                'tgl_masuk'     => $tgl_masuk,
                'urut_masuk'     => $urut_masuk,
                'tanggal'       => $request->tanggal,
                'jam'       => $request->jam,
                'nadi'       => $request->nadi,
                'nafas'       => $request->nafas,
                'sistole'       => $request->sistole,
                'diastole'       => $request->diastole,
                'user_create'       => Auth::id(),
            ];

            RmeKontrolIstimewa::create($data);

            DB::commit();
            return to_route('rawat-inap.kontrol-istimewa.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'Kontrol Istimewa berhasil di tambah !');
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

        if (empty($dataMedis)) return back()->with('error', 'Data kunjungan tidak dapat ditemukan !');

        $id = decrypt($idEncrypt);
        $kontrol = RmeKontrolIstimewa::find($id);

        return view('unit-pelayanan.rawat-inap.pelayanan.kontrol-istimewa.edit', compact('dataMedis', 'kontrol'));
    }

    public function update($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $idEncrypt, Request $request)
    {
        DB::beginTransaction();

        try {
            $pasien = Pasien::where('kd_pasien', $kd_pasien)->first();
            if (empty($pasien)) throw new Exception('Data pasien tidak ditemukan !');

            $id = decrypt($idEncrypt);
            $kontrol = RmeKontrolIstimewa::find($id);
            if (empty($kontrol)) throw new Exception('Data kontrol istimewa tidak ditemukan !');

            $data = [
                'tanggal'       => $request->tanggal,
                'jam'       => $request->jam,
                'nadi'       => $request->nadi,
                'nafas'       => $request->nafas,
                'sistole'       => $request->sistole,
                'diastole'       => $request->diastole,
                'user_edit'       => Auth::id(),
            ];

            RmeKontrolIstimewa::where('id', $kontrol->id)->update($data);

            DB::commit();
            return to_route('rawat-inap.kontrol-istimewa.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'Kontrol Istimewa berhasil di ubah !');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function delete($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        DB::beginTransaction();

        try {
            $id = decrypt($request->id_kontrol);
            $kontrol = RmeKontrolIstimewa::find($id);

            if (empty($kontrol)) throw new Exception('Data kontrol istimewa tidak ditemukan !');
            $kontrol->delete();

            DB::commit();
            return back()->with('success', 'Data kontrol istimewa berhasil dihapus !');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function pdf($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
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

        $tglPrint = $request->tgl_print;

        $kontrol = RmeKontrolIstimewa::with(['userCreate'])
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->whereDate('tanggal', $tglPrint)
            ->orderBy('jam', 'ASC')
            ->get();

        $pdf = Pdf::loadView('unit-pelayanan.rawat-inap.pelayanan.kontrol-istimewa.pdf', compact(
            'dataMedis',
            'kontrol',
            'tglPrint'
        ))
            ->setPaper('a4', 'potrait');
        return $pdf->stream('kontrolIstimewa_' . $dataMedis->kd_pasien . '_' . $dataMedis->tgl_masuk . '.pdf');
    }
}
