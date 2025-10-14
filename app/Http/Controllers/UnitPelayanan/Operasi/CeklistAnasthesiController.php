<?php

namespace App\Http\Controllers\UnitPelayanan\Operasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kunjungan;
use App\Models\Perawat;
use App\Models\RmeCeklistKesiapanAnesthesi;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class CeklistAnasthesiController extends Controller
{
    protected $perawat;

    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/operasi');

        // Cache perawat aktif selama 60 menit
        $this->perawat = Cache::remember('perawat_aktif', now()->addMinutes(60), function () {
            return Perawat::select('kd_perawat', 'nama')->where('aktif', 1)->get();
        });
    }

    public function index($kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', 71)
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


        return view('unit-pelayanan.operasi.pelayanan.ceklist-anasthesi.index', compact(
            'dataMedis',
        ));
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
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', 71)
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

        // ganti query langsung dengan properti yang sudah di-cache
        $perawat = $this->perawat;

        return view('unit-pelayanan.operasi.pelayanan.ceklist-anasthesi.create', compact(
            'dataMedis',
            'perawat'
        ));
    }

    public function store($kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        try {
            // data dalam bentuk json
            $mesin_anesthesia_listrik = null;
            if ($request->has('mesin_anesthesia_listrik') && is_array($request->mesin_anesthesia_listrik)) {
                $mesin_anesthesia_listrik = json_encode($request->mesin_anesthesia_listrik);
            }
            $gas_medis = null;
            if ($request->has('gas_medis') && is_array($request->gas_medis)) {
                $gas_medis = json_encode($request->gas_medis);
            }
            $mesin_anesthesia = null;
            if ($request->has('mesin_anesthesia') && is_array($request->mesin_anesthesia)) {
                $mesin_anesthesia = json_encode($request->mesin_anesthesia);
            }
            $manajemen_jalan_nafas = null;
            if ($request->has('manajemen_jalan_nafas') && is_array($request->manajemen_jalan_nafas)) {
                $manajemen_jalan_nafas = json_encode($request->manajemen_jalan_nafas);
            }
            $pemantauan = null;
            if ($request->has('pemantauan') && is_array($request->pemantauan)) {
                $pemantauan = json_encode($request->pemantauan);
            }
            $lain_lain = null;
            if ($request->has('lain_lain') && is_array($request->lain_lain)) {
                $lain_lain = json_encode($request->lain_lain);
            }
            $obat_obatan = null;
            if ($request->has('obat_obatan') && is_array($request->obat_obatan)) {
                $obat_obatan = json_encode($request->obat_obatan);
            }

            $ceklistKesiapanAnesthesi = new RmeCeklistKesiapanAnesthesi();
            $ceklistKesiapanAnesthesi->kd_pasien = $kd_pasien;
            $ceklistKesiapanAnesthesi->kd_unit = 71;
            $ceklistKesiapanAnesthesi->tgl_masuk = $tgl_masuk;
            $ceklistKesiapanAnesthesi->urut_masuk = $urut_masuk;
            $ceklistKesiapanAnesthesi->waktu_create = date('Y-m-d H:i:s');
            $ceklistKesiapanAnesthesi->user_create = Auth::id();

            // Mengisi data dari request
            $ceklistKesiapanAnesthesi->ruangan = $request->ruangan;
            $ceklistKesiapanAnesthesi->diagnosis = $request->diagnosis;
            $ceklistKesiapanAnesthesi->teknik_anesthesia = $request->teknik_anesthesia;
            $ceklistKesiapanAnesthesi->mesin_anesthesia_listrik = $mesin_anesthesia_listrik;
            $ceklistKesiapanAnesthesi->gas_medis = $gas_medis;
            $ceklistKesiapanAnesthesi->mesin_anesthesia = $mesin_anesthesia;
            $ceklistKesiapanAnesthesi->manajemen_jalan_nafas = $manajemen_jalan_nafas;
            $ceklistKesiapanAnesthesi->pemantauan = $pemantauan;
            $ceklistKesiapanAnesthesi->lain_lain = $lain_lain;
            $ceklistKesiapanAnesthesi->obat_obatan = $obat_obatan;
            $ceklistKesiapanAnesthesi->obat_lain = $request->obat_lain;
            $ceklistKesiapanAnesthesi->pemeriksa = $request->pemeriksa;
            $ceklistKesiapanAnesthesi->supervisor = $request->supervisor;

            $ceklistKesiapanAnesthesi->save();

            DB::commit();
            return to_route('operasi.pelayanan.laporan-anastesi.index', [$kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'ceklist anasthesi berhasil di tambah !');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function show($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            $ceklistKesiapanAnesthesi = RmeCeklistKesiapanAnesthesi::findOrFail($id);

            $dataMedis = Kunjungan::with('pasien')
                ->where('kd_pasien', $kd_pasien)
                ->where('kd_unit', 71)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->firstOrFail();

            $perawat = $this->perawat;

            return view('unit-pelayanan.operasi.pelayanan.ceklist-anasthesi.show', compact(
                'ceklistKesiapanAnesthesi',
                'dataMedis',
                'perawat'
            ));
        } catch (ModelNotFoundException $e) {
            return back()->with('error', 'Data tidak ditemukan. Detail: ' . $e->getMessage());
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            $ceklistKesiapanAnesthesi = RmeCeklistKesiapanAnesthesi::findOrFail($id);

            $dataMedis = Kunjungan::with('pasien')
                ->where('kd_pasien', $kd_pasien)
                ->where('kd_unit', 71)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->firstOrFail();

            $perawat = $this->perawat;

            return view('unit-pelayanan.operasi.pelayanan.ceklist-anasthesi.edit', compact(
                'ceklistKesiapanAnesthesi',
                'dataMedis',
                'perawat'
            ));
        } catch (ModelNotFoundException $e) {
            return back()->with('error', 'Data tidak ditemukan. Detail: ' . $e->getMessage());
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update($kd_pasien, $tgl_masuk, $urut_masuk, $id, Request $request)
    {
        DB::beginTransaction();

        try {
            // data dalam bentuk json
            $mesin_anesthesia_listrik = null;
            if ($request->has('mesin_anesthesia_listrik') && is_array($request->mesin_anesthesia_listrik)) {
                $mesin_anesthesia_listrik = json_encode($request->mesin_anesthesia_listrik);
            }
            $gas_medis = null;
            if ($request->has('gas_medis') && is_array($request->gas_medis)) {
                $gas_medis = json_encode($request->gas_medis);
            }
            $mesin_anesthesia = null;
            if ($request->has('mesin_anesthesia') && is_array($request->mesin_anesthesia)) {
                $mesin_anesthesia = json_encode($request->mesin_anesthesia);
            }
            $manajemen_jalan_nafas = null;
            if ($request->has('manajemen_jalan_nafas') && is_array($request->manajemen_jalan_nafas)) {
                $manajemen_jalan_nafas = json_encode($request->manajemen_jalan_nafas);
            }
            $pemantauan = null;
            if ($request->has('pemantauan') && is_array($request->pemantauan)) {
                $pemantauan = json_encode($request->pemantauan);
            }
            $lain_lain = null;
            if ($request->has('lain_lain') && is_array($request->lain_lain)) {
                $lain_lain = json_encode($request->lain_lain);
            }
            $obat_obatan = null;
            if ($request->has('obat_obatan') && is_array($request->obat_obatan)) {
                $obat_obatan = json_encode($request->obat_obatan);
            }

            $ceklistKesiapanAnesthesi = RmeCeklistKesiapanAnesthesi::findOrFail($id);
            $ceklistKesiapanAnesthesi->kd_pasien = $kd_pasien;
            $ceklistKesiapanAnesthesi->kd_unit = 71;
            $ceklistKesiapanAnesthesi->tgl_masuk = $tgl_masuk;
            $ceklistKesiapanAnesthesi->urut_masuk = $urut_masuk;
            $ceklistKesiapanAnesthesi->waktu_create = date('Y-m-d H:i:s');
            $ceklistKesiapanAnesthesi->user_edit = Auth::id();

            // Mengisi data dari request
            $ceklistKesiapanAnesthesi->ruangan = $request->ruangan;
            $ceklistKesiapanAnesthesi->diagnosis = $request->diagnosis;
            $ceklistKesiapanAnesthesi->teknik_anesthesia = $request->teknik_anesthesia;
            $ceklistKesiapanAnesthesi->mesin_anesthesia_listrik = $mesin_anesthesia_listrik;
            $ceklistKesiapanAnesthesi->gas_medis = $gas_medis;
            $ceklistKesiapanAnesthesi->mesin_anesthesia = $mesin_anesthesia;
            $ceklistKesiapanAnesthesi->manajemen_jalan_nafas = $manajemen_jalan_nafas;
            $ceklistKesiapanAnesthesi->pemantauan = $pemantauan;
            $ceklistKesiapanAnesthesi->lain_lain = $lain_lain;
            $ceklistKesiapanAnesthesi->obat_obatan = $obat_obatan;
            $ceklistKesiapanAnesthesi->obat_lain = $request->obat_lain;
            $ceklistKesiapanAnesthesi->pemeriksa = $request->pemeriksa;
            $ceklistKesiapanAnesthesi->supervisor = $request->supervisor;

            $ceklistKesiapanAnesthesi->save();

            DB::commit();
            return to_route('operasi.pelayanan.laporan-anastesi.index', [$kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'ceklist anasthesi berhasil di update !');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
