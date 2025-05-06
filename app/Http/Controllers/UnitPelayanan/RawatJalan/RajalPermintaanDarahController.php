<?php

namespace App\Http\Controllers\UnitPelayanan\RawatJalan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BdrsPermintaanDarah;
use App\Models\DokterKlinik;
use App\Models\GolonganDarah;
use App\Models\Kunjungan;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RajalPermintaanDarahController extends Controller
{
    public function index(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->leftJoin('dokter', 'kunjungan.KD_DOKTER', '=', 'dokter.KD_DOKTER')
            ->select('kunjungan.*', 't.*', 'dokter.NAMA as nama_dokter')
            ->where('kunjungan.kd_unit', $kd_unit)
            ->where('kunjungan.kd_pasien', $kd_pasien)
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

        // start fungsi Tabs
        $tabs = $request->query('tab');

        if ($tabs == 'monitoring') {
            return $this->monitoringTab($dataMedis, $request);
        } else {
            return $this->orderTab($dataMedis, $request);
        }
        // end code
    }

    private function orderTab($dataMedis, $request)
    {
        // $permintaanDarah = BdrsPermintaanDarah::orderBy('TGL_PENGIRIMAN', 'desc')->paginate(10);
        $permintaanDarah = BdrsPermintaanDarah::where('kd_pasien', $dataMedis->kd_pasien)
            ->where('kd_unit', $dataMedis->kd_unit)
            ->whereDate('tgl_masuk', $dataMedis->tgl_masuk)
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->orderBy('TGL_PENGIRIMAN', 'desc')
            ->paginate(10);

        return view('unit-pelayanan.rawat-jalan.pelayanan.permintaan-darah.index', compact(
            'dataMedis',
            'permintaanDarah'
        ));
    }

    private function monitoringTab($dataMedis, $request)
    {
        //
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
            ->leftJoin('dokter', 'kunjungan.KD_DOKTER', '=', 'dokter.KD_DOKTER')
            ->select('kunjungan.*', 't.*', 'dokter.NAMA as nama_dokter')
            ->where('kunjungan.kd_unit', $kd_unit)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();


        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        $dokter = DokterKlinik::with(['unit', 'dokter'])
            ->whereRelation('dokter', 'status', 1)
            ->where('kd_unit', $kd_unit)
            ->get();            

        $gologanDarah = GolonganDarah::all();


        return view('unit-pelayanan.rawat-jalan.pelayanan.permintaan-darah.create', compact(
            'dataMedis',
            'dokter',
            'gologanDarah'
        ));
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        // 1. Validasi data dasar
        $request->validate([
            // Data wajib pasien
            'TIPE' => 'required|in:0,1',
            'KD_DOKTER' => 'required',
            'DIAGNOSA_KIMIA' => 'required',
            'ALASAN_TRANSFUSI' => 'required',
            'KODE_GOLDA' => 'required',
            'HB' => 'required|numeric',
            'NAMA_SUAMI_ISTRI' => 'required',

            // Data null
            'TRANFUSI_SEBELUMNYA' => 'nullable|string|max:255',
            'REAKSI_TRANFUSI' => 'nullable|string|max:255',
            'SEROLOGI_DIMANA' => 'nullable|string|max:255',
            'SEROLOGI_KAPAN' => 'nullable|date',
            'SEROLOGI_HASIL' => 'nullable|string|max:255',
            'PERNAH_HAMIL' => 'nullable',
            'ABORTUS_HDN' => 'nullable|in:0,1',

            // Data komponen darah null
            'WB' => 'nullable|numeric|min:0',
            'PRC' => 'nullable|numeric|min:0',
            'PRC_PEDIACTRIC' => 'nullable|numeric|min:0',
            'PRC_LEUKODEPLETED' => 'nullable|numeric|min:0',
            'WASHED_ERYTHROYTE' => 'nullable|numeric|min:0',
            'LAINNYA' => 'nullable|string|max:255',
            'TC_BIASA' => 'nullable|numeric|min:0',
            'TC_APHERESIS' => 'nullable|numeric|min:0',
            'TC_POOLED' => 'nullable|numeric|min:0',
            'PLASMA_CAIR' => 'nullable|numeric|min:0',
            'PLASMA_SEGAR_BEKU' => 'nullable|numeric|min:0',
            'CIYOPRECIPITATE' => 'nullable|numeric|min:0',

            // Data wajib pengambilan sampel
            'TGL_PENGAMBILAN_SAMPEL' => 'required|date',
            'WAKTU_PENGAMBILAN_SAMPEL' => 'required',
            'PETUGAS_PENGAMBILAN_SAMPEL' => 'required',

            // Validasi tanggal
            'TGL_PENGIRIMAN' => 'required|date',
            'TGL_DIPERLUKAN' => 'required|date|after_or_equal:TGL_PENGIRIMAN',
        ]);

        // 3. Simpan data ke database
        DB::beginTransaction();
        try {
            // Buat objek permintaan darah baru
            $permintaanDarah = new BdrsPermintaanDarah();

            // Isi data pasien
            $permintaanDarah->KD_PASIEN = $kd_pasien;
            $permintaanDarah->KD_UNIT = $kd_unit;
            $permintaanDarah->TGL_MASUK = $tgl_masuk;
            $permintaanDarah->URUT_MASUK = $urut_masuk;
            $permintaanDarah->STATUS = 0;
            $permintaanDarah->USER_CREATE = Auth::id();

            // Isi data dari form
            foreach ($request->except(['_token', 'TGL_PENGAMBILAN_SAMPEL', 'WAKTU_PENGAMBILAN_SAMPEL']) as $field => $value) {
                $permintaanDarah->$field = $value;
            }

            // Gabungkan tanggal dan waktu pengambilan sampel
            $permintaanDarah->WAKTU_PENGAMBILAN_SAMPEL = $request->TGL_PENGAMBILAN_SAMPEL . ' ' . $request->WAKTU_PENGAMBILAN_SAMPEL;

            // Simpan permintaan darah
            $permintaanDarah->save();
            DB::commit();

            return to_route('rawat-jalan.permintaan-darah.index', [
                $kd_unit,
                $kd_pasien,
                $tgl_masuk,
                $request->urut_masuk,
            ])
                ->with('success', 'Berhasil menambah Permintaan Darah!');
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
            ->leftJoin('dokter', 'kunjungan.KD_DOKTER', '=', 'dokter.KD_DOKTER')
            ->select('kunjungan.*', 't.*', 'dokter.NAMA as nama_dokter')
            ->where('kunjungan.kd_unit', $kd_unit)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();


        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        $dokter = DokterKlinik::with(['unit', 'dokter'])
            ->whereRelation('dokter', 'status', 1)
            ->where('kd_unit', $kd_unit)
            ->get();

        $gologanDarah = GolonganDarah::all();
        $permintaanDarah = BdrsPermintaanDarah::findOrFail($id);

        return view('unit-pelayanan.rawat-jalan.pelayanan.permintaan-darah.show', compact(
            'dataMedis',
            'dokter',
            'gologanDarah',
            'permintaanDarah'
        ));
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
            ->leftJoin('dokter', 'kunjungan.KD_DOKTER', '=', 'dokter.KD_DOKTER')
            ->select('kunjungan.*', 't.*', 'dokter.NAMA as nama_dokter')
            ->where('kunjungan.kd_unit', $kd_unit)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();


        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        $dokter = DokterKlinik::with(['unit', 'dokter'])
            ->whereRelation('dokter', 'status', 1)
            ->where('kd_unit', $kd_unit)
            ->get();

        $gologanDarah = GolonganDarah::all();
        $permintaanDarah = BdrsPermintaanDarah::findOrFail($id);

        return view('unit-pelayanan.rawat-jalan.pelayanan.permintaan-darah.edit', compact(
            'dataMedis',
            'dokter',
            'gologanDarah',
            'permintaanDarah'
        ));
    }

    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        // 1. Validasi data dasar
        $request->validate([
            // Data wajib pasien
            'TIPE' => 'required|in:0,1',
            'KD_DOKTER' => 'required',
            'DIAGNOSA_KIMIA' => 'required',
            'ALASAN_TRANSFUSI' => 'required',
            'KODE_GOLDA' => 'required',
            'HB' => 'required|numeric',
            'NAMA_SUAMI_ISTRI' => 'required',

            // Data null
            'TRANFUSI_SEBELUMNYA' => 'nullable|string|max:255',
            'REAKSI_TRANFUSI' => 'nullable|string|max:255',
            'SEROLOGI_DIMANA' => 'nullable|string|max:255',
            'SEROLOGI_KAPAN' => 'nullable|date',
            'SEROLOGI_HASIL' => 'nullable|string|max:255',
            'PERNAH_HAMIL' => 'nullable',
            'ABORTUS_HDN' => 'nullable|in:0,1',

            // Data komponen darah null
            'WB' => 'nullable|numeric|min:0',
            'PRC' => 'nullable|numeric|min:0',
            'PRC_PEDIACTRIC' => 'nullable|numeric|min:0',
            'PRC_LEUKODEPLETED' => 'nullable|numeric|min:0',
            'WASHED_ERYTHROYTE' => 'nullable|numeric|min:0',
            'LAINNYA' => 'nullable|string|max:255',
            'TC_BIASA' => 'nullable|numeric|min:0',
            'TC_APHERESIS' => 'nullable|numeric|min:0',
            'TC_POOLED' => 'nullable|numeric|min:0',
            'PLASMA_CAIR' => 'nullable|numeric|min:0',
            'PLASMA_SEGAR_BEKU' => 'nullable|numeric|min:0',
            'CIYOPRECIPITATE' => 'nullable|numeric|min:0',

            // Data wajib pengambilan sampel
            'TGL_PENGAMBILAN_SAMPEL' => 'required|date',
            'WAKTU_PENGAMBILAN_SAMPEL' => 'required',
            'PETUGAS_PENGAMBILAN_SAMPEL' => 'required',

            // Validasi tanggal
            'TGL_PENGIRIMAN' => 'required|date',
            'TGL_DIPERLUKAN' => 'required|date|after_or_equal:TGL_PENGIRIMAN',
        ]);

        // Simpan data ke database
        DB::beginTransaction();
        try {
            // Temukan record yang akan diupdate
            $permintaanDarah = BdrsPermintaanDarah::findOrFail($id);

            // Update data dari form
            foreach ($request->except(['_token', '_method', 'TGL_PENGAMBILAN_SAMPEL', 'WAKTU_PENGAMBILAN_SAMPEL', 'PERNAH_HAMIL_COUNT']) as $field => $value) {
                $permintaanDarah->$field = $value;
            }

            // Handle PERNAH_HAMIL khusus
            if ($request->has('PERNAH_HAMIL')) {
                if ($request->PERNAH_HAMIL == '1' && $request->has('PERNAH_HAMIL_COUNT')) {
                    $permintaanDarah->PERNAH_HAMIL = $request->PERNAH_HAMIL_COUNT;
                } else {
                    $permintaanDarah->PERNAH_HAMIL = $request->PERNAH_HAMIL;
                }
            }

            // Gabungkan tanggal dan waktu pengambilan sampel
            $permintaanDarah->WAKTU_PENGAMBILAN_SAMPEL = $request->TGL_PENGAMBILAN_SAMPEL . ' ' . $request->WAKTU_PENGAMBILAN_SAMPEL;

            // Update user yang melakukan edit
            $permintaanDarah->USER_EDIT = Auth::id();

            // Simpan permintaan darah
            $permintaanDarah->save();
            DB::commit();

            return to_route('rawat-jalan.permintaan-darah.index', [
            $kd_unit,
            $kd_pasien,
            $tgl_masuk,
            $request->urut_masuk,])
                ->with('success', 'Berhasil mengupdate Permintaan Darah!');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
