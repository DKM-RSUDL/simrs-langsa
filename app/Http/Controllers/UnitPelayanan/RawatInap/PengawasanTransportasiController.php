<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\HrdKaryawan;
use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\RmePengawasanTransportasi;
use App\Models\RmePengawasanTransportasiDtl;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PengawasanTransportasiController extends Controller
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

        $pengawasan = RmePengawasanTransportasi::with(['userCreate'])
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.pengawasan-transportasi.index', compact(
            'dataMedis',
            'pengawasan'
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
        $perawat = HrdKaryawan::where('kd_jenis_tenaga', 2)
            ->where('kd_detail_jenis_tenaga', 1)
            ->where('status_peg', 1)
            ->get();

        $petugas = HrdKaryawan::whereNotIn('kd_jenis_tenaga', [1, 2])
            ->where('status_peg', 1)
            ->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.pengawasan-transportasi.create', compact('dataMedis', 'dokter', 'perawat', 'petugas'));
    }

    public function store($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        DB::beginTransaction();

        try {
            $pasien = Pasien::where('kd_pasien', $kd_pasien)->first();
            if (empty($pasien)) throw new Exception('Data pasien tidak ditemukan !');

            // PENGAWASAN
            $pengawasan = new RmePengawasanTransportasi();
            $pengawasan->kd_pasien = $kd_pasien;
            $pengawasan->kd_unit = $kd_unit;
            $pengawasan->tgl_masuk = $tgl_masuk;
            $pengawasan->urut_masuk = $urut_masuk;
            $pengawasan->asal_keberangkatan = $request->asal_keberangkatan;
            $pengawasan->keperluan = $request->keperluan;
            $pengawasan->rs_rujuk = $request->rs_rujuk;
            $pengawasan->tanggal_berangkat = $request->tanggal_berangkat;
            $pengawasan->jam_berangkat = $request->jam_berangkat;
            $pengawasan->catatan_khusus_berangkat = $request->catatan_khusus_berangkat;
            $pengawasan->sistole_berangkat = $request->sistole_berangkat;
            $pengawasan->diastole_berangkat = $request->diastole_berangkat;
            $pengawasan->nadi_berangkat = $request->nadi_berangkat;
            $pengawasan->nafas_berangkat = $request->nafas_berangkat;
            $pengawasan->suhu_berangkat = $request->suhu_berangkat;
            $pengawasan->skala_nyeri_berangkat = $request->skala_nyeri_berangkat;
            $pengawasan->gcs_e_berangkat = $request->gcs_e_berangkat;
            $pengawasan->gcs_m_berangkat = $request->gcs_m_berangkat;
            $pengawasan->gcs_v_berangkat = $request->gcs_v_berangkat;
            $pengawasan->resiko_nafas_berangkat = $request->resiko_nafas_berangkat;
            $pengawasan->kriteria = $request->kriteria;
            $pengawasan->kd_dokter = $request->kd_dokter;
            $pengawasan->kd_perawat = $request->kd_perawat;
            $pengawasan->kd_pramuhusada = $request->kd_pramuhusada;
            $pengawasan->kd_pengemudi = $request->kd_pengemudi;
            $pengawasan->cara_transportasi = $request->cara_transportasi;
            $pengawasan->plat_ambulans = $request->plat_ambulans;
            $pengawasan->tanggal_sampai = $request->tanggal_sampai;
            $pengawasan->petugas_penerima = $request->petugas_penerima;
            $pengawasan->catatan_khusus_sampai = $request->catatan_khusus_sampai;
            $pengawasan->sistole_sampai = $request->sistole_sampai;
            $pengawasan->diastole_sampai = $request->diastole_sampai;
            $pengawasan->nadi_sampai = $request->nadi_sampai;
            $pengawasan->nafas_sampai = $request->nafas_sampai;
            $pengawasan->suhu_sampai = $request->suhu_sampai;
            $pengawasan->skala_nyeri_sampai = $request->skala_nyeri_sampai;
            $pengawasan->gcs_e_sampai = $request->gcs_e_sampai;
            $pengawasan->gcs_m_sampai = $request->gcs_m_sampai;
            $pengawasan->gcs_v_sampai = $request->gcs_v_sampai;
            $pengawasan->resiko_nafas_sampai = $request->resiko_nafas_sampai;
            $pengawasan->masalah = $request->masalah;
            $pengawasan->tindakan = $request->tindakan;
            $pengawasan->user_create = Auth::id();
            $pengawasan->save();

            // PENGAWASAN DTL
            $jam_pengawasan = $request->jam_pengawasan;
            $sistole_pengawasan = $request->sistole_pengawasan;
            $diastole_pengawasan = $request->diastole_pengawasan;
            $nadi_pengawasan = $request->nadi_pengawasan;
            $nafas_pengawasan = $request->nafas_pengawasan;
            $suhu_pengawasan = $request->suhu_pengawasan;
            $skala_nyeri_pengawasan = $request->skala_nyeri_pengawasan;
            $gcs_e_pengawasan = $request->gcs_e_pengawasan;
            $gcs_m_pengawasan = $request->gcs_m_pengawasan;
            $gcs_v_pengawasan = $request->gcs_v_pengawasan;

            for ($i = 0; $i < count($jam_pengawasan); $i++) {
                $data = [
                    'id_pengawasan'         => $pengawasan->id,
                    'jam_pengawasan'        => $jam_pengawasan[$i],
                    'sistole_pengawasan'        => $sistole_pengawasan[$i],
                    'diastole_pengawasan'        => $diastole_pengawasan[$i],
                    'nadi_pengawasan'        => $nadi_pengawasan[$i],
                    'nafas_pengawasan'        => $nafas_pengawasan[$i],
                    'suhu_pengawasan'        => $suhu_pengawasan[$i],
                    'skala_nyeri_pengawasan'        => $skala_nyeri_pengawasan[$i],
                    'gcs_e_pengawasan'        => $gcs_e_pengawasan[$i],
                    'gcs_m_pengawasan'        => $gcs_m_pengawasan[$i],
                    'gcs_v_pengawasan'        => $gcs_v_pengawasan[$i],
                ];

                RmePengawasanTransportasiDtl::create($data);
            }


            DB::commit();
            return to_route('rawat-inap.pengawasan-transportasi.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'Pengawasan transportasi berhasil di tambah !');
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
        $perawat = HrdKaryawan::where('kd_jenis_tenaga', 2)
            ->where('kd_detail_jenis_tenaga', 1)
            ->where('status_peg', 1)
            ->get();

        $petugas = HrdKaryawan::whereNotIn('kd_jenis_tenaga', [1, 2])
            ->where('status_peg', 1)
            ->get();

        $id = decrypt($idEncrypt);
        $pengawasan = RmePengawasanTransportasi::find($id);

        return view('unit-pelayanan.rawat-inap.pelayanan.pengawasan-transportasi.edit', compact('dataMedis', 'dokter', 'perawat', 'petugas', 'pengawasan'));
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
            return to_route('rawat-inap.pengawasan-transportasi.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'Persetujuan anestesi dan sedasi berhasil di ubah !');
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

        return view('unit-pelayanan.rawat-inap.pelayanan.pengawasan-transportasi.show', compact('dataMedis', 'dokter', 'anestesi'));
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

        $pdf = Pdf::loadView('unit-pelayanan.rawat-inap.pelayanan.pengawasan-transportasi.pdf', compact(
            'dataMedis',
            'anestesi'
        ))
            ->setPaper('a4', 'potrait');
        return $pdf->stream('persetujuanAnestesi_' . $dataMedis->kd_pasien . '_' . $dataMedis->tgl_masuk . '.pdf');
    }
}
