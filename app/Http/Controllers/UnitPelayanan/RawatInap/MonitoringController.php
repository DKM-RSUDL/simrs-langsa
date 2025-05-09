<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\RmeIntesiveMonitoring;
use App\Models\RmeIntesiveMonitoringDtl;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonitoringController extends Controller
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
            ->where('kunjungan.urut_masuk', (int)$urut_masuk)
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

        // Fetch all monitoring records for this patient visit (without pagination)
        $monitoringRecords = RmeIntesiveMonitoring::with(['detail', 'userCreator'])
            ->where('kd_unit', $kd_unit)
            ->where('kd_pasien', $kd_pasien)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->orderBy('tgl_implementasi', 'desc')
            ->orderBy('jam_implementasi', 'desc')
            ->get();

        // Get the most recent monitoring record for displaying in the hasil-monitoring tab
        $latestMonitoring = RmeIntesiveMonitoring::with(['detail', 'userCreator'])
            ->where('kd_unit', $kd_unit)
            ->where('kd_pasien', $kd_pasien)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->orderBy('tgl_implementasi', 'desc')
            ->orderBy('jam_implementasi', 'desc')
            ->first();

        // Get all monitoring records for chart data (unpaginated)
        $allMonitoringRecords = RmeIntesiveMonitoring::with(['detail', 'userCreator'])
            ->where('kd_unit', $kd_unit)
            ->where('kd_pasien', $kd_pasien)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->orderBy('tgl_implementasi', 'asc')
            ->orderBy('jam_implementasi', 'asc')
            ->get();

        return view(
            'unit-pelayanan.rawat-inap.pelayanan.monitoring.index',
            compact('dataMedis', 'kd_pasien', 'tgl_masuk', 'urut_masuk', 'monitoringRecords', 'latestMonitoring', 'allMonitoringRecords')
        );
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

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        // Mengambil nama alergen dari riwayat_alergi
        if ($dataMedis->riwayat_alergi) {
            $dataMedis->riwayat_alergi = collect(json_decode($dataMedis->riwayat_alergi, true))
                ->pluck('alergen')
                ->all();
        } else {
            $dataMedis->riwayat_alergi = [];
        }

        $dataMedis->waktu_masuk = Carbon::parse($dataMedis->TGL_MASUK . ' ' . $dataMedis->JAM_MASUK)->format('Y-m-d H:i:s');

        $latestMonitoring = RmeIntesiveMonitoring::where([
            'kd_pasien' => $kd_pasien,
            'kd_unit' => $kd_unit,
            'tgl_masuk' => $tgl_masuk,
            'urut_masuk' => $urut_masuk,
        ])
            ->orderBy('tgl_implementasi', 'desc')
            ->orderBy('jam_implementasi', 'desc')
            ->first();

        return view(
            'unit-pelayanan.rawat-inap.pelayanan.monitoring.create',
            compact('dataMedis', 'kd_unit',  'kd_pasien', 'tgl_masuk', 'urut_masuk', 'latestMonitoring')
        );
    }


    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        DB::beginTransaction();

        try {
            // Create main monitoring record
            $monitoring = new RmeIntesiveMonitoring();
            $monitoring->kd_unit = $kd_unit;
            $monitoring->kd_pasien = $kd_pasien;
            $monitoring->tgl_masuk = $tgl_masuk;
            $monitoring->urut_masuk = $urut_masuk;
            $monitoring->tgl_implementasi = $request->tgl_implementasi;
            $monitoring->jam_implementasi = $request->jam_implementasi;
            $monitoring->indikasi_iccu = $request->indikasi_iccu;
            $monitoring->diagnosa = $request->diagnosa;
            $monitoring->alergi = $request->alergi;
            $monitoring->berat_badan = $request->berat_badan;
            $monitoring->tinggi_badan = $request->tinggi_badan;
            $monitoring->bab = $request->bab;
            $monitoring->urine = $request->urine;
            $monitoring->iwl = $request->iwl;
            $monitoring->muntahan_cms = $request->muntahan_cms;
            $monitoring->drain = $request->drain;
            $monitoring->user_create = auth()->user()->id;
            $monitoring->user_edit = auth()->user()->id;
            $monitoring->save();

            // Create detailed monitoring record
            $monitoringDtl = new RmeIntesiveMonitoringDtl();
            $monitoringDtl->monitoring_id = $monitoring->id;
            $monitoringDtl->sistolik = $request->sistolik;
            $monitoringDtl->diastolik = $request->diastolik;
            $monitoringDtl->map = $request->map;
            $monitoringDtl->hr = $request->hr;
            $monitoringDtl->rr = $request->rr;
            $monitoringDtl->temp = $request->temp;
            $monitoringDtl->gcs_eye = $request->gcs_eye;
            $monitoringDtl->gcs_verbal = $request->gcs_verbal;
            $monitoringDtl->gcs_motor = $request->gcs_motor;
            $monitoringDtl->gcs_total = $request->gcs_total;
            $monitoringDtl->pupil_kanan = $request->pupil_kanan;
            $monitoringDtl->pupil_kiri = $request->pupil_kiri;
            $monitoringDtl->ph = $request->ph;
            $monitoringDtl->po2 = $request->po2;
            $monitoringDtl->pco2 = $request->pco2;
            $monitoringDtl->be = $request->be;
            $monitoringDtl->hco3 = $request->hco3;
            $monitoringDtl->saturasi_o2 = $request->saturasi_o2;
            $monitoringDtl->na = $request->na;
            $monitoringDtl->k = $request->k;
            $monitoringDtl->cl = $request->cl;
            $monitoringDtl->ureum = $request->ureum;
            $monitoringDtl->creatinin = $request->creatinin;
            $monitoringDtl->hb = $request->hb;
            $monitoringDtl->ht = $request->ht;
            $monitoringDtl->leukosit = $request->leukosit;
            $monitoringDtl->trombosit = $request->trombosit;
            $monitoringDtl->sgot = $request->sgot;
            $monitoringDtl->sgpt = $request->sgpt;
            $monitoringDtl->kdgs = $request->kdgs;
            $monitoringDtl->terapi_oksigen = $request->terapi_oksigen;
            $monitoringDtl->albumin = $request->albumin;
            $monitoringDtl->kesadaran = $request->kesadaran;
            $monitoringDtl->ventilator_mode = $request->ventilator_mode;
            $monitoringDtl->ventilator_mv = $request->ventilator_mv;
            $monitoringDtl->ventilator_tv = $request->ventilator_tv;
            $monitoringDtl->ventilator_fio2 = $request->ventilator_fio2;
            $monitoringDtl->ventilator_ie_ratio = $request->ventilator_ie_ratio;
            $monitoringDtl->ventilator_pmax = $request->ventilator_pmax;
            $monitoringDtl->ventilator_peep_ps = $request->ventilator_peep_ps;
            $monitoringDtl->ett_no = $request->ett_no;
            $monitoringDtl->batas_bibir = $request->batas_bibir;
            $monitoringDtl->ngt_no = $request->ngt_no;
            $monitoringDtl->cvc = $request->cvc;
            $monitoringDtl->urine_catch_no = $request->urine_catch_no;
            $monitoringDtl->iv_line = $request->iv_line;
            $monitoringDtl->save();

            DB::commit();

            return redirect()->route('rawat-inap.monitoring.index', [
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk
            ])->with('success', 'Data monitoring berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    public function edit($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        // Ambil data medis kunjungan
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

        // Hitung umur pasien
        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        // Ambil data monitoring yang akan diedit
        $monitoring = RmeIntesiveMonitoring::with('detail')
            ->where('id', $id)
            ->where('kd_unit', $kd_unit)
            ->where('kd_pasien', $kd_pasien)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->firstOrFail();

        // Mengambil nama alergen dari riwayat_alergi
        if ($dataMedis->riwayat_alergi) {
            $dataMedis->riwayat_alergi = collect(json_decode($dataMedis->riwayat_alergi, true))
                ->pluck('alergen')
                ->all();
        } else {
            $dataMedis->riwayat_alergi = [];
        }

        $dataMedis->waktu_masuk = Carbon::parse($dataMedis->TGL_MASUK . ' ' . $dataMedis->JAM_MASUK)->format('Y-m-d H:i:s');

        return view(
            'unit-pelayanan.rawat-inap.pelayanan.monitoring.edit',
            compact('dataMedis', 'kd_unit',  'kd_pasien', 'tgl_masuk', 'urut_masuk', 'monitoring')
        );
    }

    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            // Cari dan update record monitoring utama
            $monitoring = RmeIntesiveMonitoring::where('id', $id)
                ->where('kd_unit', $kd_unit)
                ->where('kd_pasien', $kd_pasien)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->firstOrFail();

            // Update data monitoring utama
            $monitoring->tgl_implementasi = $request->tgl_implementasi;
            $monitoring->jam_implementasi = $request->jam_implementasi;
            $monitoring->indikasi_iccu = $request->indikasi_iccu;
            $monitoring->diagnosa = $request->diagnosa;
            $monitoring->alergi = $request->alergi;
            $monitoring->berat_badan = $request->berat_badan;
            $monitoring->tinggi_badan = $request->tinggi_badan;
            $monitoring->bab = $request->bab;
            $monitoring->urine = $request->urine;
            $monitoring->iwl = $request->iwl;
            $monitoring->muntahan_cms = $request->muntahan_cms;
            $monitoring->drain = $request->drain;
            $monitoring->user_edit = auth()->user()->id;
            $monitoring->save();

            // Cari dan update record monitoring detail
            $monitoringDtl = RmeIntesiveMonitoringDtl::where('monitoring_id', $id)->firstOrFail();

            // Update data monitoring detail
            $monitoringDtl->sistolik = $request->sistolik;
            $monitoringDtl->diastolik = $request->diastolik;
            $monitoringDtl->map = $request->map;
            $monitoringDtl->hr = $request->hr;
            $monitoringDtl->rr = $request->rr;
            $monitoringDtl->temp = $request->temp;
            $monitoringDtl->gcs_eye = $request->gcs_eye;
            $monitoringDtl->gcs_verbal = $request->gcs_verbal;
            $monitoringDtl->gcs_motor = $request->gcs_motor;
            $monitoringDtl->gcs_total = $request->gcs_total;
            $monitoringDtl->pupil_kanan = $request->pupil_kanan;
            $monitoringDtl->pupil_kiri = $request->pupil_kiri;
            $monitoringDtl->ph = $request->ph;
            $monitoringDtl->po2 = $request->po2;
            $monitoringDtl->pco2 = $request->pco2;
            $monitoringDtl->be = $request->be;
            $monitoringDtl->hco3 = $request->hco3;
            $monitoringDtl->saturasi_o2 = $request->saturasi_o2;
            $monitoringDtl->na = $request->na;
            $monitoringDtl->k = $request->k;
            $monitoringDtl->cl = $request->cl;
            $monitoringDtl->ureum = $request->ureum;
            $monitoringDtl->creatinin = $request->creatinin;
            $monitoringDtl->hb = $request->hb;
            $monitoringDtl->ht = $request->ht;
            $monitoringDtl->leukosit = $request->leukosit;
            $monitoringDtl->trombosit = $request->trombosit;
            $monitoringDtl->sgot = $request->sgot;
            $monitoringDtl->sgpt = $request->sgpt;
            $monitoringDtl->kdgs = $request->kdgs;
            $monitoringDtl->terapi_oksigen = $request->terapi_oksigen;
            $monitoringDtl->albumin = $request->albumin;
            $monitoringDtl->kesadaran = $request->kesadaran;
            $monitoringDtl->ventilator_mode = $request->ventilator_mode;
            $monitoringDtl->ventilator_mv = $request->ventilator_mv;
            $monitoringDtl->ventilator_tv = $request->ventilator_tv;
            $monitoringDtl->ventilator_fio2 = $request->ventilator_fio2;
            $monitoringDtl->ventilator_ie_ratio = $request->ventilator_ie_ratio;
            $monitoringDtl->ventilator_pmax = $request->ventilator_pmax;
            $monitoringDtl->ventilator_peep_ps = $request->ventilator_peep_ps;
            $monitoringDtl->ett_no = $request->ett_no;
            $monitoringDtl->batas_bibir = $request->batas_bibir;
            $monitoringDtl->ngt_no = $request->ngt_no;
            $monitoringDtl->cvc = $request->cvc;
            $monitoringDtl->urine_catch_no = $request->urine_catch_no;
            $monitoringDtl->iv_line = $request->iv_line;
            $monitoringDtl->save();

            DB::commit();

            return redirect()->route('rawat-inap.monitoring.index', [
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk
            ])->with('success', 'Data monitoring berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            // Cari record monitoring
            $monitoring = RmeIntesiveMonitoring::where('id', $id)
                ->where('kd_unit', $kd_unit)
                ->where('kd_pasien', $kd_pasien)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->firstOrFail();

            // Hapus record detail monitoring terlebih dahulu karena terkait dengan foreign key
            RmeIntesiveMonitoringDtl::where('monitoring_id', $id)->delete();

            // Kemudian hapus record monitoring utama
            $monitoring->delete();

            DB::commit();

            return redirect()->route('rawat-inap.monitoring.index', [
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk
            ])->with('success', 'Data monitoring berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }

    public function show($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        // Ambil data medis kunjungan
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_unit', $kd_unit)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        // Hitung umur pasien
        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        // Ambil data monitoring yang akan ditampilkan
        $monitoring = RmeIntesiveMonitoring::with(['detail', 'userCreator'])
            ->where('id', $id)
            ->where('kd_unit', $kd_unit)
            ->where('kd_pasien', $kd_pasien)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->firstOrFail();

        return view(
            'unit-pelayanan.rawat-inap.pelayanan.monitoring.show',
            compact('dataMedis', 'kd_unit',  'kd_pasien', 'tgl_masuk', 'urut_masuk', 'monitoring')
        );
    }

    // Tambahkan method print pada MonitoringController

    public function print(Request $request)
    {
        $kd_unit = $request->kd_unit;
        $kd_pasien = $request->kd_pasien;
        $tgl_masuk = $request->tgl_masuk;
        $urut_masuk = $request->urut_masuk;
        $start_date = $request->start_date;
        $start_time = $request->start_time;
        $end_date = $request->end_date;
        $end_time = $request->end_time;

        // Ambil data medis kunjungan
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_unit', $kd_unit)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        // Hitung umur pasien
        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        // Filter data monitoring berdasarkan range tanggal jika parameter ada
        $monitoringQuery = RmeIntesiveMonitoring::with(['detail'])
            ->where('kd_unit', $kd_unit)
            ->where('kd_pasien', $kd_pasien)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk);

        // Terapkan filter tanggal jika ada
        if ($start_date && $end_date) {
            $start_datetime = $start_date . ' ' . ($start_time ?: '00:00:00');
            $end_datetime = $end_date . ' ' . ($end_time ?: '23:59:59');

            $monitoringQuery->whereRaw("CONCAT(tgl_implementasi, ' ', jam_implementasi) >= ?", [$start_datetime])
                ->whereRaw("CONCAT(tgl_implementasi, ' ', jam_implementasi) <= ?", [$end_datetime]);
        }

        // Clone query untuk mendapatkan data terakhir dan semua data
        $latestQuery = clone $monitoringQuery;

        // Ambil data monitoring terbaru
        $latestMonitoring = $latestQuery->orderBy('tgl_implementasi', 'desc')
            ->orderBy('jam_implementasi', 'desc')
            ->first();

        // Ambil semua data monitoring dengan urutan ASC untuk daftar
        $allMonitoringRecords = $monitoringQuery->orderBy('tgl_implementasi', 'asc')
            ->orderBy('jam_implementasi', 'asc')
            ->get();

        // Set judul unit
        $unitTitles = [
            '10015' => 'INTENSIVE CORONARY CARE UNIT',
            '10016' => 'INTENSIVE CARE UNIT',
            '10131' => 'NEONATAL INTENSIVE CARE UNIT',
            '10132' => 'PEDIATRIC INTENSIVE CARE UNIT',
        ];

        $title = isset($unitTitles[$dataMedis->kd_unit])
            ? $unitTitles[$dataMedis->kd_unit]
            : 'Monitoring Intensive Care';

        // Pass semua data ke view
        return view(
            'unit-pelayanan.rawat-inap.pelayanan.monitoring.print',
            compact(
                'dataMedis',
                'kd_pasien',
                'tgl_masuk',
                'urut_masuk',
                'latestMonitoring',
                'title',
                'allMonitoringRecords',
                'start_date',
                'start_time',
                'end_date',
                'end_time'
            )
        );
    }
}