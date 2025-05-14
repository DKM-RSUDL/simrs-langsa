<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Agama;
use App\Models\HrdKaryawan;
use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\RmeRohani;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PelayananRohaniController extends Controller
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

        $rohani = RmeRohani::with(['penyetuju'])
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.rohani.index', compact(
            'dataMedis',
            'rohani'
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
        $pegawai = HrdKaryawan::where('status_peg', 1)->get();
        $agama = Agama::all();

        return view('unit-pelayanan.rawat-inap.pelayanan.rohani.create', compact('dataMedis', 'pegawai', 'agama'));
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
                'kd_penyetuju'         => $request->kd_penyetuju,
                'kondisi_pasien'         => $request->kondisi_pasien,
                'keluarga_nama'         => $request->keluarga_nama,
                'keluarga_tempat_lahir'         => $request->keluarga_tempat_lahir,
                'keluarga_tgl_lahir'         => $request->keluarga_tgl_lahir,
                'keluarga_jenis_kelamin'         => $request->keluarga_jenis_kelamin,
                'keluarga_hubungan_pasien'         => $request->keluarga_hubungan_pasien,
                'keluarga_agama'         => $request->keluarga_agama,
                'user_create'         => Auth::id(),
            ];

            RmeRohani::create($data);

            DB::commit();
            return to_route('rawat-inap.rohani.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'Pernyataan permintaan rohani berhasil di tambah !');
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

        $pegawai = HrdKaryawan::where('status_peg', 1)->get();
        $agama = Agama::all();
        $id = decrypt($idEncrypt);
        $rohani = RmeRohani::find($id);

        return view('unit-pelayanan.rawat-inap.pelayanan.rohani.edit', compact('dataMedis', 'pegawai', 'agama', 'rohani'));
    }

    public function update($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $idEncrypt, Request $request)
    {
        DB::beginTransaction();

        try {
            $pasien = Pasien::where('kd_pasien', $kd_pasien)->first();
            if (empty($pasien)) throw new Exception('Data pasien tidak ditemukan !');

            $id = decrypt($idEncrypt);
            $rohani = RmeRohani::find($id);
            if (empty($rohani)) throw new Exception('Data permintaan rohani tidak ditemukan !');

            $rohani->tanggal                    = $request->tanggal;
            $rohani->kd_penyetuju               = $request->kd_penyetuju;
            $rohani->kondisi_pasien             = $request->kondisi_pasien;
            $rohani->keluarga_nama              = $request->keluarga_nama;
            $rohani->keluarga_tempat_lahir      = $request->keluarga_tempat_lahir;
            $rohani->keluarga_tgl_lahir         = $request->keluarga_tgl_lahir;
            $rohani->keluarga_jenis_kelamin     = $request->keluarga_jenis_kelamin;
            $rohani->keluarga_hubungan_pasien   = $request->keluarga_hubungan_pasien;
            $rohani->keluarga_agama             = $request->keluarga_agama;
            $rohani->user_edit                  = Auth::id();
            $rohani->save();


            DB::commit();
            return to_route('rawat-inap.rohani.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'Pernyataan permintaan rohani berhasil di ubah !');
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

        $pegawai = HrdKaryawan::where('status_peg', 1)->get();
        $agama = Agama::all();
        $id = decrypt($idEncrypt);
        $rohani = RmeRohani::find($id);

        return view('unit-pelayanan.rawat-inap.pelayanan.rohani.show', compact('dataMedis', 'pegawai', 'agama', 'rohani'));
    }

    public function delete($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        DB::beginTransaction();

        try {
            $id = decrypt($request->id_rohani);
            $rohani = RmeRohani::find($id);

            if (empty($rohani)) throw new Exception('Data permintaan pelayanan rohani tidak ditemukan !');

            $rohani->delete();

            DB::commit();
            return back()->with('success', 'Data permintaan pelayanan rohani berhasil dihapus !');
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
        $rohani = RmeRohani::find($id);

        $pdf = Pdf::loadView('unit-pelayanan.rawat-inap.pelayanan.rohani.pdf', compact(
            'dataMedis',
            'rohani'
        ))
            ->setPaper('a4', 'potrait');
        return $pdf->stream('rohani_' . $dataMedis->kd_pasien . '_' . $dataMedis->tgl_masuk . '.pdf');
    }
}
