<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\RmeMeninggalkanPerawatan;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MeninggalkanPerawatanController extends Controller
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

        $pernyataan = RmeMeninggalkanPerawatan::with(['dokter'])
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.meninggalkan-perawatan.index', compact(
            'dataMedis',
            'pernyataan'
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
        $dokter = Dokter::where('status', 1)->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.meninggalkan-perawatan.create', compact('dataMedis', 'dokter'));
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
                'tanggal'     => $request->tanggal,
                'keperluan'     => $request->keperluan,
                'tgl_awal'     => $request->tgl_awal,
                'tgl_akhir'     => $request->tgl_akhir,
                'kd_dokter'     => $request->kd_dokter,
                'tgl_keluar'     => $request->tgl_keluar,
                'jam_keluar'     => $request->jam_keluar,
                'tgl_masuk_kembali'     => $request->tgl_masuk_kembali,
                'jam_masuk_kembali'     => $request->jam_masuk_kembali,
                'user_create'           => Auth::id()
            ];

            RmeMeninggalkanPerawatan::create($data);

            DB::commit();
            return to_route('rawat-inap.meninggalkan-perawatan.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'Pernyataan Meninggalkan Perawatan berhasil di tambah !');
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

        $dokter = Dokter::where('status', 1)->get();
        $id = decrypt($idEncrypt);
        $pernyataan = RmeMeninggalkanPerawatan::find($id);


        return view('unit-pelayanan.rawat-inap.pelayanan.meninggalkan-perawatan.edit', compact('dataMedis', 'dokter', 'pernyataan'));
    }

    public function update($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $idEncrypt, Request $request)
    {
        DB::beginTransaction();

        try {
            $pasien = Pasien::where('kd_pasien', $kd_pasien)->first();
            if (empty($pasien)) throw new Exception('Data pasien tidak ditemukan !');

            $id = decrypt($idEncrypt);
            $pernyataan = RmeMeninggalkanPerawatan::find($id);
            if (empty($pernyataan)) throw new Exception('Data pernyataan tidak ditemukan !');

            $data = [
                'tanggal'     => $request->tanggal,
                'keperluan'     => $request->keperluan,
                'tgl_awal'     => $request->tgl_awal,
                'tgl_akhir'     => $request->tgl_akhir,
                'kd_dokter'     => $request->kd_dokter,
                'tgl_keluar'     => $request->tgl_keluar,
                'jam_keluar'     => $request->jam_keluar,
                'tgl_masuk_kembali'     => $request->tgl_masuk_kembali,
                'jam_masuk_kembali'     => $request->jam_masuk_kembali,
                'user_edit'           => Auth::id()
            ];

            RmeMeninggalkanPerawatan::where('id', $pernyataan->id)->update($data);

            DB::commit();
            return to_route('rawat-inap.meninggalkan-perawatan.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'Pernyataan Meninggalkan Perawatan berhasil di ubah !');
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

        $dokter = Dokter::where('status', 1)->get();
        $id = decrypt($idEncrypt);
        $pernyataan = RmeMeninggalkanPerawatan::find($id);


        return view('unit-pelayanan.rawat-inap.pelayanan.meninggalkan-perawatan.show', compact('dataMedis', 'dokter', 'pernyataan'));
    }

    public function delete($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        DB::beginTransaction();

        try {
            $id = decrypt($request->id_pernyataan);
            $pernyataan = RmeMeninggalkanPerawatan::find($id);

            if (empty($pernyataan)) throw new Exception('Data Pernyataan tidak ditemukan !');
            $pernyataan->delete();

            DB::commit();
            return back()->with('success', 'Data pernyataan berhasil dihapus !');
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
        $pernyataan = RmeMeninggalkanPerawatan::find($id);

        $pdf = Pdf::loadView('unit-pelayanan.rawat-inap.pelayanan.meninggalkan-perawatan.pdf', compact(
            'dataMedis',
            'pernyataan'
        ))
            ->setPaper('a4', 'potrait');
        return $pdf->stream('pernyataan_meninggalkan_perawatan_' . $dataMedis->kd_pasien . '_' . $dataMedis->tgl_masuk . '.pdf');
    }
}
