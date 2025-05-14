<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\RmePermintaanPrivasi;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PermintaanPrivasiController extends Controller
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

        $privasi = RmePermintaanPrivasi::with(['userCreate'])
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.privasi.index', compact(
            'dataMedis',
            'privasi'
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
        return view('unit-pelayanan.rawat-inap.pelayanan.privasi.create', compact('dataMedis'));
    }

    public function store($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        DB::beginTransaction();

        try {
            $pasien = Pasien::where('kd_pasien', $kd_pasien)->first();
            if (empty($pasien)) throw new Exception('Data pasien tidak ditemukan !');

            $data = [
                'kd_pasien'         => $kd_pasien,
                'kd_unit'         => $kd_unit,
                'tgl_masuk'         => $tgl_masuk,
                'urut_masuk'         => $urut_masuk,
                'tanggal'         => $request->tanggal,
                'keluarga_nama'         => $request->keluarga_nama,
                'keluarga_tempat_lahir'         => $request->keluarga_tempat_lahir,
                'keluarga_tgl_lahir'         => $request->keluarga_tgl_lahir,
                'keluarga_jenis_kelamin'         => $request->keluarga_jenis_kelamin,
                'keluarga_hubungan_pasien'         => $request->keluarga_hubungan_pasien,
                'keluarga_alamat'         => $request->keluarga_alamat,
                'status_privasi'         => $request->status_privasi,
                'privasi_nama'         => $request->privasi_nama,
                'tindakan_privasi'         => $request->tindakan_privasi,
                'privasi_lainnya'         => $request->privasi_lainnya,
                'user_create'         => Auth::id(),
            ];

            RmePermintaanPrivasi::create($data);

            DB::commit();
            return to_route('rawat-inap.privasi.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'Pernyataan permintaan privasi dan keamanan berhasil di tambah !');
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
        $privasi = RmePermintaanPrivasi::find($id);

        return view('unit-pelayanan.rawat-inap.pelayanan.privasi.edit', compact('dataMedis', 'privasi'));
    }

    public function update($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $idEncrypt, Request $request)
    {
        DB::beginTransaction();

        try {
            $pasien = Pasien::where('kd_pasien', $kd_pasien)->first();
            if (empty($pasien)) throw new Exception('Data pasien tidak ditemukan !');

            $id = decrypt($idEncrypt);
            $privasi = RmePermintaanPrivasi::find($id);
            if (empty($privasi)) throw new Exception('Data permintaan tidak ditemukan !');

            $data = [
                'tanggal'         => $request->tanggal,
                'keluarga_nama'         => $request->keluarga_nama,
                'keluarga_tempat_lahir'         => $request->keluarga_tempat_lahir,
                'keluarga_tgl_lahir'         => $request->keluarga_tgl_lahir,
                'keluarga_jenis_kelamin'         => $request->keluarga_jenis_kelamin,
                'keluarga_hubungan_pasien'         => $request->keluarga_hubungan_pasien,
                'keluarga_alamat'         => $request->keluarga_alamat,
                'status_privasi'         => $request->status_privasi,
                'privasi_nama'         => $request->privasi_nama,
                'tindakan_privasi'         => $request->tindakan_privasi,
                'privasi_lainnya'         => $request->privasi_lainnya,
                'user_edit'         => Auth::id(),
            ];

            RmePermintaanPrivasi::where('id', $privasi->id)->update($data);

            DB::commit();
            return to_route('rawat-inap.privasi.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'Pernyataan permintaan privasi dan keamanan berhasil di ubah !');
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

        if (empty($dataMedis)) return back()->with('error', 'Data kunjungan tidak dapat ditemukan !');

        $id = decrypt($idEncrypt);
        $privasi = RmePermintaanPrivasi::find($id);

        return view('unit-pelayanan.rawat-inap.pelayanan.privasi.show', compact('dataMedis', 'privasi'));
    }

    public function delete($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        DB::beginTransaction();

        try {
            $id = decrypt($request->id_privasi);
            $privasi = RmePermintaanPrivasi::find($id);

            if (empty($privasi)) throw new Exception('Data permintaan privasi tidak ditemukan !');

            $privasi->delete();

            DB::commit();
            return back()->with('success', 'Data permintaan privasi berhasil dihapus !');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function pdf($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $idEncrypt)
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

        $id = decrypt($idEncrypt);
        $privasi = RmePermintaanPrivasi::find($id);

        $pdf = Pdf::loadView('unit-pelayanan.rawat-inap.pelayanan.privasi.pdf', compact(
            'dataMedis',
            'privasi'
        ))
            ->setPaper('a4', 'potrait');
        return $pdf->stream('privasi_' . $dataMedis->kd_pasien . '_' . $dataMedis->tgl_masuk . '.pdf');
    }
}
