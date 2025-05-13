<?php

namespace App\Http\Controllers\UnitPelayanan\RawatJalan;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\RmePersetujuanAnestesi;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PersetujuanAnestesiController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-jalan');
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

        $anestesi = RmePersetujuanAnestesi::with(['dokter'])
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->get();

        return view('unit-pelayanan.rawat-jalan.pelayanan.persetujuan-anestesi.index', compact(
            'dataMedis',
            'anestesi'
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

        return view('unit-pelayanan.rawat-jalan.pelayanan.persetujuan-anestesi.create', compact('dataMedis', 'dokter'));
    }

    public function store($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        DB::beginTransaction();

        try {
            $pasien = Pasien::where('kd_pasien', $kd_pasien)->first();
            if (empty($pasien)) throw new Exception('Data pasien tidak ditemukan !');

            $statusKeluarga = $request->status_keluarga;

            $anestesi = new RmePersetujuanAnestesi();
            $anestesi->kd_pasien        = $kd_pasien;
            $anestesi->kd_unit        = $kd_unit;
            $anestesi->tgl_masuk        = $tgl_masuk;
            $anestesi->urut_masuk        = $urut_masuk;
            $anestesi->tanggal        = $request->tanggal;
            $anestesi->jam        = $request->jam;
            $anestesi->kd_dokter        = $request->kd_dokter;
            $anestesi->nama_saksi_keluarga        = $request->nama_saksi_keluarga;
            $anestesi->nama_saksi        = $request->nama_saksi;
            $anestesi->status_keluarga        = $request->status_keluarga;
            $anestesi->keluarga_nama = ($statusKeluarga == 1) ? $pasien->nama : $request->keluarga_nama;
            $anestesi->keluarga_usia = ($statusKeluarga == 1) ? hitungUmur(date('Y-m-d', strtotime($pasien->tgl_lahir))) : $request->keluarga_usia;
            $anestesi->keluarga_jenis_kelamin = ($statusKeluarga == 1) ? $pasien->jenis_kelamin : $request->keluarga_jenis_kelamin;
            $anestesi->keluarga_alamat = ($statusKeluarga == 1) ? $pasien->alamat : $request->keluarga_alamat;
            $anestesi->tindakan        = $request->tindakan;
            $anestesi->tindakan_lainnya        = $request->tindakan_lainnya;
            $anestesi->user_create        = Auth::id();
            $anestesi->save();

            DB::commit();
            return to_route('rawat-inap.anestesi-sedasi.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'Persetujuan anestesi dan sedasi berhasil di tambah !');
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
        $anestesi = RmePersetujuanAnestesi::find($id);

        return view('unit-pelayanan.rawat-jalan.pelayanan.persetujuan-anestesi.edit', compact('dataMedis', 'dokter', 'anestesi'));
    }

    public function update($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $idEncrypt, Request $request)
    {
        DB::beginTransaction();

        try {
            $pasien = Pasien::where('kd_pasien', $kd_pasien)->first();
            if (empty($pasien)) throw new Exception('Data pasien tidak ditemukan !');

            $id = decrypt($idEncrypt);
            $anestesi = RmePersetujuanAnestesi::find($id);
            if (empty($anestesi)) throw new Exception('Data persetujuan anestesi dan sedasi tidak ditemukan !');

            $statusKeluarga = $request->status_keluarga;

            $anestesi->tanggal        = $request->tanggal;
            $anestesi->jam        = $request->jam;
            $anestesi->kd_dokter        = $request->kd_dokter;
            $anestesi->nama_saksi_keluarga        = $request->nama_saksi_keluarga;
            $anestesi->nama_saksi        = $request->nama_saksi;
            $anestesi->status_keluarga        = $request->status_keluarga;
            $anestesi->keluarga_nama = ($statusKeluarga == 1) ? $pasien->nama : $request->keluarga_nama;
            $anestesi->keluarga_usia = ($statusKeluarga == 1) ? hitungUmur(date('Y-m-d', strtotime($pasien->tgl_lahir))) : $request->keluarga_usia;
            $anestesi->keluarga_jenis_kelamin = ($statusKeluarga == 1) ? $pasien->jenis_kelamin : $request->keluarga_jenis_kelamin;
            $anestesi->keluarga_alamat = ($statusKeluarga == 1) ? $pasien->alamat : $request->keluarga_alamat;
            $anestesi->tindakan        = $request->tindakan;
            $anestesi->tindakan_lainnya        = $request->tindakan_lainnya;
            $anestesi->user_edit        = Auth::id();
            $anestesi->save();

            DB::commit();
            return to_route('rawat-inap.anestesi-sedasi.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'Persetujuan anestesi dan sedasi berhasil di ubah !');
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
        $anestesi = RmePersetujuanAnestesi::find($id);

        return view('unit-pelayanan.rawat-jalan.pelayanan.persetujuan-anestesi.show', compact('dataMedis', 'dokter', 'anestesi'));
    }

    public function delete($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        DB::beginTransaction();

        try {
            $id = decrypt($request->id_anestesi);
            $anestesi = RmePersetujuanAnestesi::find($id);

            if (empty($anestesi)) throw new Exception('Data persetujuan anestesi dan sedasi tidak ditemukan !');

            $anestesi->delete();

            DB::commit();
            return back()->with('success', 'Data persetujuan anestesi dan sedasi berhasil dihapus !');
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
        $anestesi = RmePersetujuanAnestesi::find($id);

        $pdf = Pdf::loadView('unit-pelayanan.rawat-jalan.pelayanan.persetujuan-anestesi.pdf', compact(
            'dataMedis',
            'anestesi'
        ))
            ->setPaper('a4', 'potrait');
        return $pdf->stream('persetujuanAnestesi_' . $dataMedis->kd_pasien . '_' . $dataMedis->tgl_masuk . '.pdf');
    }
}
