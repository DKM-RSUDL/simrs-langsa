<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\RmePaps;
use App\Models\RmePapsDtl;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PapsController extends Controller
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

        $paps = RmePaps::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.paps.index', compact(
            'dataMedis',
            'paps'
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

        $dokter = Dokter::where('status', 1)->get();

        if (empty($dataMedis)) return back()->with('error', 'Data kunjungan tidak dapat ditemukan !');

        return view('unit-pelayanan.rawat-inap.pelayanan.paps.create', compact('dataMedis', 'dokter'));
    }

    public function store($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        DB::beginTransaction();

        try {
            $pasien = Pasien::where('kd_pasien', $kd_pasien)->first();
            if (empty($pasien)) throw new Exception('Data pasien tidak ditemukan !');

            $statusKeluarga = $request->status_keluarga;

            $paps = new RmePaps();
            $paps->kd_pasien = $kd_pasien;
            $paps->kd_unit = $kd_unit;
            $paps->tgl_masuk = $tgl_masuk;
            $paps->urut_masuk = $urut_masuk;
            $paps->tanggal = $request->tanggal;
            $paps->jam = $request->jam;
            $paps->kd_dokter = $request->kd_dokter;
            $paps->alasan = $request->alasan;
            $paps->status_keluarga = $request->status_keluarga;
            $paps->saksi_1 = $request->saksi_1;
            $paps->saksi_2 = $request->saksi_2;
            $paps->keluarga_nama = ($statusKeluarga == 1) ? $pasien->nama : $request->keluarga_nama;
            $paps->keluarga_usia = ($statusKeluarga == 1) ? hitungUmur(date('Y-m-d', strtotime($pasien->tgl_lahir))) : $request->keluarga_usia;
            $paps->keluarga_jenis_kelamin = ($statusKeluarga == 1) ? $pasien->jenis_kelamin : $request->keluarga_jenis_kelamin;
            $paps->keluarga_alamat = ($statusKeluarga == 1) ? $pasien->alamat : $request->keluarga_alamat;
            $paps->keluarga_ktp = ($statusKeluarga == 1) ? $pasien->no_pengenal : $request->keluarga_ktp;
            $paps->user_create = Auth::id();
            $paps->save();

            $diagnosis = $request->diagnosis;
            $risiko = $request->risiko;

            for ($i = 0; $i < count($diagnosis); $i++) {
                $dataDetail = [
                    'id_paps'       => $paps->id,
                    'diagnosis'     => $diagnosis[$i],
                    'risiko'     => $risiko[$i]
                ];

                RmePapsDtl::create($dataDetail);
            }

            DB::commit();
            return to_route('rawat-inap.paps.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'Pernyataan PAPS berhasil di tambah !');
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
        $paps = RmePaps::find($id);


        return view('unit-pelayanan.rawat-inap.pelayanan.paps.edit', compact('dataMedis', 'dokter', 'paps'));
    }

    public function update($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $idEncrypt, Request $request)
    {
        DB::beginTransaction();

        try {
            $pasien = Pasien::where('kd_pasien', $kd_pasien)->first();
            if (empty($pasien)) throw new Exception('Data pasien tidak ditemukan !');

            $statusKeluarga = $request->status_keluarga;
            $id = decrypt($idEncrypt);

            $paps = RmePaps::find($id);
            $paps->tanggal = $request->tanggal;
            $paps->jam = $request->jam;
            $paps->kd_dokter = $request->kd_dokter;
            $paps->alasan = $request->alasan;
            $paps->status_keluarga = $request->status_keluarga;
            $paps->saksi_1 = $request->saksi_1;
            $paps->saksi_2 = $request->saksi_2;
            $paps->keluarga_nama = ($statusKeluarga == 1) ? $pasien->nama : $request->keluarga_nama;
            $paps->keluarga_usia = ($statusKeluarga == 1) ? hitungUmur(date('Y-m-d', strtotime($pasien->tgl_lahir))) : $request->keluarga_usia;
            $paps->keluarga_jenis_kelamin = ($statusKeluarga == 1) ? $pasien->jenis_kelamin : $request->keluarga_jenis_kelamin;
            $paps->keluarga_alamat = ($statusKeluarga == 1) ? $pasien->alamat : $request->keluarga_alamat;
            $paps->keluarga_ktp = ($statusKeluarga == 1) ? $pasien->no_pengenal : $request->keluarga_ktp;
            $paps->user_edit = Auth::id();
            $paps->save();

            $diagnosis = $request->diagnosis;
            $risiko = $request->risiko;

            // delete old diagnosis
            RmePapsDtl::where('id_paps', $paps->id)->delete();

            for ($i = 0; $i < count($diagnosis); $i++) {
                $dataDetail = [
                    'id_paps'       => $paps->id,
                    'diagnosis'     => $diagnosis[$i],
                    'risiko'     => $risiko[$i]
                ];

                RmePapsDtl::create($dataDetail);
            }

            DB::commit();
            return to_route('rawat-inap.paps.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'Pernyataan PAPS berhasil di ubah !');
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
        $paps = RmePaps::find($id);


        return view('unit-pelayanan.rawat-inap.pelayanan.paps.show', compact('dataMedis', 'dokter', 'paps'));
    }

    public function delete($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        DB::beginTransaction();

        try {
            $id = decrypt($request->id_paps);
            $paps = RmePaps::find($id);

            if (empty($paps)) throw new Exception('Data PAPS tidak ditemukan !');

            $paps->delete();
            RmePapsDtl::where('id_paps', $id)->delete();

            DB::commit();
            return back()->with('success', 'Data PAPS berhasil dihapus !');
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
        $paps = RmePaps::find($id);

        // return view('unit-pelayanan.rawat-inap.pelayanan.paps.pdf', compact(
        //     'dataMedis',
        //     'paps'
        // ));

        $pdf = Pdf::loadView('unit-pelayanan.rawat-inap.pelayanan.paps.pdf', compact(
            'dataMedis',
            'paps'
        ))
            ->setPaper('a4', 'potrait');
        return $pdf->stream('paps' . $dataMedis->kd_pasien . '_' . $dataMedis->tgl_masuk . '.pdf');
    }
}
