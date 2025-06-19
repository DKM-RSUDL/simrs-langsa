<?php

namespace App\Http\Controllers\UnitPelayanan\GawatDarurat;

use App\Http\Controllers\Controller;
use App\Models\BdrsPermintaanDarah;
use App\Models\DokterKlinik;
use App\Models\GolonganDarah;
use Illuminate\Http\Request;
use App\Models\Kunjungan;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PermintaanDarahController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/gawat-darurat');
    }

    public function index($kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_unit', 3)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
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
            // ->where('kd_unit', 3)
            ->whereDate('tgl_masuk', '>=', date('Y-m-d', strtotime('-3 month', strtotime(date('Y-m-d')))))
            // ->where('urut_masuk', $dataMedis->urut_masuk)
            ->orderBy('TGL_PENGIRIMAN', 'desc')
            ->paginate(10);

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.permintaan-darah.index', compact(
            'dataMedis',
            'permintaanDarah'
        ));
    }

    private function monitoringTab($dataMedis, $request)
    {
        //
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
            ->where('kunjungan.kd_unit', 3)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();


        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        $dokter = DokterKlinik::with(['unit', 'dokter'])
            ->whereRelation('dokter', 'status', 1)
            ->where('kd_unit', 3)
            ->get();

        $gologanDarah = GolonganDarah::all();


        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.permintaan-darah.create', compact(
            'dataMedis',
            'dokter',
            'gologanDarah'
        ));
    }

    public function store(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk)
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
            $permintaanDarah->TGL_MASUK = $tgl_masuk;
            $permintaanDarah->URUT_MASUK = $urut_masuk;
            $permintaanDarah->KD_UNIT = 3;
            $permintaanDarah->STATUS = 0;
            $permintaanDarah->USER_CREATE = Auth::id();

            // filed all db
            $permintaanDarah->TIPE = $request->TIPE;
            $permintaanDarah->KD_DOKTER = $request->KD_DOKTER;
            $permintaanDarah->TGL_PENGIRIMAN = $request->TGL_PENGIRIMAN;
            $permintaanDarah->TGL_DIPERLUKAN = $request->TGL_DIPERLUKAN;
            $permintaanDarah->DIAGNOSA_KIMIA = $request->DIAGNOSA_KIMIA;
            $permintaanDarah->ALASAN_TRANSFUSI = $request->ALASAN_TRANSFUSI;
            $permintaanDarah->KODE_GOLDA = $request->KODE_GOLDA;
            $permintaanDarah->HB = $request->HB;
            $permintaanDarah->NAMA_SUAMI_ISTRI = $request->NAMA_SUAMI_ISTRI;
            $permintaanDarah->TRANFUSI_SEBELUMNYA = $request->TRANFUSI_SEBELUMNYA;
            $permintaanDarah->REAKSI_TRANFUSI = $request->REAKSI_TRANFUSI;
            $permintaanDarah->SEROLOGI_DIMANA = $request->SEROLOGI_DIMANA;
            $permintaanDarah->SEROLOGI_KAPAN = $request->SEROLOGI_KAPAN;
            $permintaanDarah->SEROLOGI_HASIL = $request->SEROLOGI_HASIL;
            $permintaanDarah->PERNAH_HAMIL = $request->PERNAH_HAMIL;
            $permintaanDarah->ABORTUS_HDN = $request->ABORTUS_HDN;
            $permintaanDarah->WB = $request->WB;
            $permintaanDarah->PRC = $request->PRC;
            $permintaanDarah->PRC_PEDIACTRIC = $request->PRC_PEDIACTRIC;
            $permintaanDarah->PRC_LEUKODEPLETED = $request->PRC_LEUKODEPLETED;
            $permintaanDarah->WASHED_ERYTHROYTE = $request->WASHED_ERYTHROYTE;
            $permintaanDarah->LAINNYA = $request->LAINNYA;
            $permintaanDarah->TC_BIASA = $request->TC_BIASA;
            $permintaanDarah->TC_APHERESIS = $request->TC_APHERESIS;
            $permintaanDarah->TC_POOLED = $request->TC_POOLED;
            $permintaanDarah->PLASMA_CAIR = $request->PLASMA_CAIR;
            $permintaanDarah->PLASMA_SEGAR_BEKU = $request->PLASMA_SEGAR_BEKU;
            $permintaanDarah->CIYOPRECIPITATE = $request->CIYOPRECIPITATE;
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

            return to_route('permintaan-darah.index', [$kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Berhasil menambah Permintaan Darah!');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function show($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_unit', 3)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();


        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        $dokter = DokterKlinik::with(['unit', 'dokter'])
            ->whereRelation('dokter', 'status', 1)
            ->where('kd_unit', 3)
            ->get();

        $gologanDarah = GolonganDarah::all();
        $order = BdrsPermintaanDarah::findOrFail($id);

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.permintaan-darah.show', compact(
            'dataMedis',
            'dokter',
            'gologanDarah',
            'order'
        ));
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
            ->where('kunjungan.kd_unit', 3)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();


        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        $dokter = DokterKlinik::with(['unit', 'dokter'])
            ->whereRelation('dokter', 'status', 1)
            ->where('kd_unit', 3)
            ->get();

        $gologanDarah = GolonganDarah::all();
        $permintaanDarah = BdrsPermintaanDarah::findOrFail($id);

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.permintaan-darah.edit', compact(
            'dataMedis',
            'dokter',
            'gologanDarah',
            'permintaanDarah'
        ));
    }

    public function update(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
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
            $permintaanDarah->PETUGAS_PENGAMBILAN_SAMPEL = $request->PETUGAS_PENGAMBILAN_SAMPEL;

            // Update user yang melakukan edit
            $permintaanDarah->USER_EDIT = Auth::id();

            // Simpan permintaan darah
            $permintaanDarah->save();
            DB::commit();

            return to_route('permintaan-darah.index', [$kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Berhasil mengupdate Permintaan Darah!');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
