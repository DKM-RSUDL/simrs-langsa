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

class ForensikPatologiController extends Controller
{
    public function index($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
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

        return view('unit-pelayanan.forensik.pelayanan.create-patologi', compact('dataMedis', 'itemFisik'));
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
            $pemeriksaan->cara_datang = $request->cara_datang;
            $pemeriksaan->tgl_meninggal = $request->tgl_meninggal;
            $pemeriksaan->tgl_pemeriksaan = $request->tgl_pemeriksaan;
            $pemeriksaan->jam_pemeriksaan = $request->jam_pemeriksaan;
            $pemeriksaan->jam_pemeriksaan_akhir = $request->jam_pemeriksaan_akhir;
            $pemeriksaan->diagnosis_meninggal = $request->diagnosis_meninggal;
            $pemeriksaan->asal_rujukan = $request->asal_rujukan;
            $pemeriksaan->jenis_kasus_patologi = $request->jenis_kasus_patologi;
            $pemeriksaan->nomor_penyidik = $request->nomor_penyidik;
            $pemeriksaan->nama_penyidik = $request->nama_penyidik;
            $pemeriksaan->nrp_penyidik = $request->nrp_penyidik;
            $pemeriksaan->tgl_penyidik = $request->tgl_penyidik;
            $pemeriksaan->instansi_penyidik = $request->instansi_penyidik;
            $pemeriksaan->pemeriksaan = $request->pemeriksaan;
            $pemeriksaan->label_jenazah = $request->label_jenazah;
            $pemeriksaan->penutup_jenazah = $request->penutup_jenazah;
            $pemeriksaan->pembungkus_jenazah = $request->pembungkus_jenazah;
            $pemeriksaan->pakaian_jenazah = $request->pakaian_jenazah;
            $pemeriksaan->perhiasan_jenazah = $request->perhiasan_jenazah;
            $pemeriksaan->benda_disamping_jenazah = $request->benda_disamping_jenazah;
            $pemeriksaan->identitas_umum = $request->identitas_umum;
            $pemeriksaan->identitas_khusus = $request->identitas_khusus;
            $pemeriksaan->lebam_mayat = $request->lebam_mayat;
            $pemeriksaan->kaku_mayat = $request->kaku_mayat;
            $pemeriksaan->penurunan_suhu = $request->penurunan_suhu;
            $pemeriksaan->pembusukan = $request->pembusukan;
            $pemeriksaan->lama_kematian = $request->lama_kematian;
            $pemeriksaan->penatalaksanaan = $request->penatalaksanaan;
            $pemeriksaan->penatalaksanaan_lainnya = $request->penatalaksanaan_lainnya;
            $pemeriksaan->diagnosos = $request->diagnosos;
            $pemeriksaan->dibawa_oleh = $request->dibawa_oleh;
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
            return to_route('forensik.unit.pelayanan', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'Pemeriksaan berhasil di tambah !');
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

        return view('unit-pelayanan.forensik.pelayanan.edit-patologi', compact('dataMedis', 'pemeriksaan', 'itemFisik'));
    }

    public function update($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id, Request $request)
    {
        DB::beginTransaction();

        try {
            // store pemeriksaan
            $pemeriksaan = RmeForensikPemeriksaan::find($id);
            $pemeriksaan->kd_pasien = $kd_pasien;
            $pemeriksaan->kd_unit = $kd_unit;
            $pemeriksaan->tgl_masuk = $tgl_masuk;
            $pemeriksaan->urut_masuk = $urut_masuk;
            $pemeriksaan->cara_datang = $request->cara_datang;
            $pemeriksaan->tgl_meninggal = $request->tgl_meninggal;
            $pemeriksaan->tgl_pemeriksaan = $request->tgl_pemeriksaan;
            $pemeriksaan->jam_pemeriksaan = $request->jam_pemeriksaan;
            $pemeriksaan->jam_pemeriksaan_akhir = $request->jam_pemeriksaan_akhir;
            $pemeriksaan->diagnosis_meninggal = $request->diagnosis_meninggal;
            $pemeriksaan->asal_rujukan = $request->asal_rujukan;
            $pemeriksaan->jenis_kasus_patologi = $request->jenis_kasus_patologi;
            $pemeriksaan->nomor_penyidik = $request->nomor_penyidik;
            $pemeriksaan->nama_penyidik = $request->nama_penyidik;
            $pemeriksaan->nrp_penyidik = $request->nrp_penyidik;
            $pemeriksaan->tgl_penyidik = $request->tgl_penyidik;
            $pemeriksaan->instansi_penyidik = $request->instansi_penyidik;
            $pemeriksaan->pemeriksaan = $request->pemeriksaan;
            $pemeriksaan->label_jenazah = $request->label_jenazah;
            $pemeriksaan->penutup_jenazah = $request->penutup_jenazah;
            $pemeriksaan->pembungkus_jenazah = $request->pembungkus_jenazah;
            $pemeriksaan->pakaian_jenazah = $request->pakaian_jenazah;
            $pemeriksaan->perhiasan_jenazah = $request->perhiasan_jenazah;
            $pemeriksaan->benda_disamping_jenazah = $request->benda_disamping_jenazah;
            $pemeriksaan->identitas_umum = $request->identitas_umum;
            $pemeriksaan->identitas_khusus = $request->identitas_khusus;
            $pemeriksaan->lebam_mayat = $request->lebam_mayat;
            $pemeriksaan->kaku_mayat = $request->kaku_mayat;
            $pemeriksaan->penurunan_suhu = $request->penurunan_suhu;
            $pemeriksaan->pembusukan = $request->pembusukan;
            $pemeriksaan->lama_kematian = $request->lama_kematian;
            $pemeriksaan->penatalaksanaan = $request->penatalaksanaan;
            $pemeriksaan->penatalaksanaan_lainnya = $request->penatalaksanaan_lainnya;
            $pemeriksaan->diagnosos = $request->diagnosos;
            $pemeriksaan->dibawa_oleh = $request->dibawa_oleh;
            $pemeriksaan->user_create = Auth::id();
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
            return to_route('forensik.unit.pelayanan', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'Pemeriksaan berhasil di ubah !');
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

        return view('unit-pelayanan.forensik.pelayanan.show-patologi', compact('dataMedis', 'pemeriksaan', 'itemFisik'));
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