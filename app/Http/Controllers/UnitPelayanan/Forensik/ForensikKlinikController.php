<?php

namespace App\Http\Controllers\UnitPelayanan\Forensik;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\MrItemFisik;
use App\Models\RmeForensikPemeriksaan;
use App\Models\RmeForensikPemeriksaanFisik;
use App\Models\Unit;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ForensikKlinikController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/forensik');
    }

    public function index()
    {
        $unit = Unit::with(['bagian'])
            ->whereIn('kd_unit', ['228', '76'])
            ->get();

        return view('unit-pelayanan.forensik.create', compact('unit'));
    }


    public function create($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->where('kd_unit', $kd_unit)
            ->where('kd_pasien', $kd_pasien)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->first();

        // Menghitung umur berdasarkan tgl_lahir jika ada
        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        $itemFisik = MrItemFisik::orderby('urut')->get();


        return view(
            'unit-pelayanan.forensik.pelayanan.pemeriksaan-klinik.create',
            compact(
                'dataMedis',
                'itemFisik'
            )
        );
    }


    public function store($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        DB::beginTransaction();

        try {
            // store pemeriksaan
            $pemeriksaan = new RmeForensikPemeriksaan();
            $pemeriksaan->kd_pasien = $kd_pasien;
            $pemeriksaan->kd_unit = $kd_unit;
            $pemeriksaan->tgl_masuk = $tgl_masuk;
            $pemeriksaan->urut_masuk = $urut_masuk;
            $pemeriksaan->tgl_pemeriksaan = $request->tgl_pemeriksaan;
            $pemeriksaan->jam_pemeriksaan = $request->jam_pemeriksaan;
            $pemeriksaan->cara_datang = $request->cara_datang;
            $pemeriksaan->asal_rujukan = $request->asal_rujukan;
            $pemeriksaan->jenis_kasus = $request->jenis_kasus;
            $pemeriksaan->nomor_penyidik = $request->nomor_penyidik;
            $pemeriksaan->nama_penyidik = $request->nama_penyidik;
            $pemeriksaan->nrp_penyidik = $request->nrp_penyidik;
            $pemeriksaan->tgl_penyidik = $request->tgl_penyidik;
            $pemeriksaan->instansi_penyidik = $request->instansi_penyidik;
            $pemeriksaan->pemeriksaan = $request->pemeriksaan;
            $pemeriksaan->anamnesis = $request->anamnesis;
            $pemeriksaan->kesadaran = $request->kesadaran;
            $pemeriksaan->nadi = $request->nadi;
            $pemeriksaan->nafas = $request->nafas;
            $pemeriksaan->sistole = $request->sistole;
            $pemeriksaan->diastole = $request->diastole;
            $pemeriksaan->suhu = $request->suhu;
            $pemeriksaan->pemeriksaan_lain = $request->pemeriksaan_lain;
            $pemeriksaan->penatalaksanaan = $request->penatalaksanaan;
            $pemeriksaan->penatalaksanaan_lainnya = $request->penatalaksanaan_lainnya;
            $pemeriksaan->diagnosos = $request->diagnosos;
            $pemeriksaan->dibawa_oleh = $request->dibawa_oleh;
            $pemeriksaan->tgl_pulang = $request->tgl_pulang;
            $pemeriksaan->user_create = Auth::id();
            $pemeriksaan->save();

            //Simpan ke table RmePemeriksaanFisik
            $itemFisik = MrItemFisik::all();
            foreach ($itemFisik as $item) {
                $isNormal = $request->has($item->id . '-normal') ? 1 : 0;
                $keterangan = $request->input($item->id . '_keterangan');
                if ($isNormal) $keterangan = '';

                RmeForensikPemeriksaanFisik::create([
                    'id_pemeriksaan' => $pemeriksaan->id,
                    'id_item_fisik' => $item->id,
                    'is_normal' => $isNormal,
                    'keterangan' => $keterangan
                ]);
            }

            DB::commit();
            return to_route('forensik.unit.pelayanan.pemeriksaan-klinik.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'Pemeriksaan berhasil di tambah !');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
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
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', $kd_unit)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();

        // Menghitung umur berdasarkan tgl_lahir jika ada
        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        $pemeriksaan = RmeForensikPemeriksaan::find($id);
        $itemFisik = MrItemFisik::all();

        return view('unit-pelayanan.forensik.pelayanan.pemeriksaan-klinik.edit', compact('dataMedis', 'pemeriksaan', 'itemFisik'));
    }

    public function update($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id, Request $request)
    {
        DB::beginTransaction();

        try {
            // update pemeriksaan
            $pemeriksaan = RmeForensikPemeriksaan::find($id);
            $pemeriksaan->tgl_pemeriksaan = $request->tgl_pemeriksaan;
            $pemeriksaan->jam_pemeriksaan = $request->jam_pemeriksaan;
            $pemeriksaan->cara_datang = $request->cara_datang;
            $pemeriksaan->asal_rujukan = $request->asal_rujukan;
            $pemeriksaan->jenis_kasus = $request->jenis_kasus;
            $pemeriksaan->nomor_penyidik = $request->nomor_penyidik;
            $pemeriksaan->nama_penyidik = $request->nama_penyidik;
            $pemeriksaan->nrp_penyidik = $request->nrp_penyidik;
            $pemeriksaan->tgl_penyidik = $request->tgl_penyidik;
            $pemeriksaan->instansi_penyidik = $request->instansi_penyidik;
            $pemeriksaan->pemeriksaan = $request->pemeriksaan;
            $pemeriksaan->anamnesis = $request->anamnesis;
            $pemeriksaan->kesadaran = $request->kesadaran;
            $pemeriksaan->nadi = $request->nadi;
            $pemeriksaan->nafas = $request->nafas;
            $pemeriksaan->sistole = $request->sistole;
            $pemeriksaan->diastole = $request->diastole;
            $pemeriksaan->suhu = $request->suhu;
            $pemeriksaan->pemeriksaan_lain = $request->pemeriksaan_lain;
            $pemeriksaan->penatalaksanaan = $request->penatalaksanaan;
            $pemeriksaan->penatalaksanaan_lainnya = $request->penatalaksanaan_lainnya;
            $pemeriksaan->diagnosos = $request->diagnosos;
            $pemeriksaan->dibawa_oleh = $request->dibawa_oleh;
            $pemeriksaan->tgl_pulang = $request->tgl_pulang;
            $pemeriksaan->user_edit = Auth::id();
            $pemeriksaan->save();

            //Simpan ke table RmePemeriksaanFisik
            $itemFisik = MrItemFisik::all();
            foreach ($itemFisik as $item) {
                $isNormal = $request->has($item->id . '-normal') ? 1 : 0;
                $keterangan = $request->input($item->id . '_keterangan');
                if ($isNormal) $keterangan = '';

                RmeForensikPemeriksaanFisik::updateOrCreate([
                    'id_pemeriksaan' => $pemeriksaan->id,
                    'id_item_fisik' => $item->id,
                ], [
                    'is_normal' => $isNormal,
                    'keterangan' => $keterangan
                ]);
            }

            DB::commit();
            return to_route('forensik.unit.pelayanan.pemeriksaan-klinik.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'Pemeriksaan berhasil di ubah !');
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
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', $kd_unit)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();

        // Menghitung umur berdasarkan tgl_lahir jika ada
        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        $pemeriksaan = RmeForensikPemeriksaan::find($id);
        $itemFisik = MrItemFisik::all();

        return view('unit-pelayanan.forensik.pelayanan.pemeriksaan-klinik.show', compact('dataMedis', 'pemeriksaan', 'itemFisik'));
    }

    public function destroy($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        DB::beginTransaction();

        try {
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


            if (empty($dataMedis)) {
                return response()->json([
                    'status'    => 'error',
                    'message'   => 'Kunjungan pasien tidak ditemukan !',
                    'data'      => []
                ]);
            }

            $id = decrypt($request->pemeriksaan);

            $pemeriksaan = RmeForensikPemeriksaan::find($id);

            if (empty($pemeriksaan)) {
                return response()->json([
                    'status'    => 'error',
                    'message'   => 'Data tidak ditemukan !',
                    'data'      => []
                ]);
            }

            RmeForensikPemeriksaanFisik::where('id_pemeriksaan', $pemeriksaan->id)->delete();
            RmeForensikPemeriksaan::where('id', $pemeriksaan->id)->delete();

            DB::commit();
            return response()->json([
                'status'    => 'success',
                'message'   => 'OK !',
                'data'      => []
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}