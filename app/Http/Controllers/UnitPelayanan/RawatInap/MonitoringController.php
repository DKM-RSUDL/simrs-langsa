<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\RmeAlergiPasien;
use App\Models\RmeIntensiveMonitoringTherapy;
use App\Models\RmeIntensiveMonitoringTherapyDtl;
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

        // Fetch therapies for the given patient
        $therapies = RmeIntensiveMonitoringTherapy::where([
            'kd_unit' => $kd_unit,
            'kd_pasien' => $kd_pasien,
            'tgl_masuk' => $tgl_masuk,
            'urut_masuk' => $urut_masuk,
        ])->get();

        //get getMonitoringDetail
        $monitoringRecords = RmeIntesiveMonitoring::with(['detail', 'userCreator'])
            ->where('kd_unit', $kd_unit)
            ->where('kd_pasien', $kd_pasien)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->orderBy('tgl_implementasi', 'desc')
            ->orderBy('jam_implementasi', 'desc')
            ->get();

        return view(
            'unit-pelayanan.rawat-inap.pelayanan.monitoring.index',
            compact('dataMedis', 'kd_unit', 'kd_pasien', 'tgl_masuk', 'urut_masuk', 'therapies', 'monitoringRecords')
        );
    }

    // New method to get filtered monitoring data via AJAX
    public function getFilteredData(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        $startDate = $request->start_date;
        $endDate = $request->end_date;

        // Get monitoring records within date range
        $monitoringRecords = RmeIntesiveMonitoring::with(['detail', 'userCreator'])
            ->where('kd_unit', $kd_unit)
            ->where('kd_pasien', $kd_pasien)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->whereBetween('tgl_implementasi', [$startDate, $endDate])
            ->orderBy('tgl_implementasi', 'asc')
            ->orderBy('jam_implementasi', 'asc')
            ->get();

        // Format data for response
        $formattedData = $monitoringRecords->map(function ($record) {
            return [
                'id' => $record->id,
                'tgl_implementasi' => $record->tgl_implementasi,
                'jam_implementasi' => $record->jam_implementasi,
                'formatted_datetime' => Carbon::parse($record->tgl_implementasi)->format('d M Y') . ' ' .
                    Carbon::parse($record->jam_implementasi)->format('H:i'),
                'detail' => [
                    'sistolik' => $record->detail->sistolik ?? 0,
                    'diastolik' => $record->detail->diastolik ?? 0,
                    'map' => $record->detail->map ?? 0,
                    'hr' => $record->detail->hr ?? 0,
                    'rr' => $record->detail->rr ?? 0,
                    'temp' => $record->detail->temp ?? 0,
                ]
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $formattedData,
            'count' => $formattedData->count(),
            'filter_info' => [
                'start_date' => Carbon::parse($startDate)->format('d M Y'),
                'end_date' => Carbon::parse($endDate)->format('d M Y'),
            ]
        ]);
    }

    // New method to get single monitoring record details
    public function getMonitoringDetail($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $monitoring = RmeIntesiveMonitoring::with(['detail'])
            ->where('id', $id)
            ->where('kd_unit', $kd_unit)
            ->where('kd_pasien', $kd_pasien)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->first();

        if (!$monitoring) {
            return response()->json([
                'success' => false,
                'message' => 'Data monitoring tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $monitoring->id,
                'tgl_implementasi' => $monitoring->tgl_implementasi,
                'jam_implementasi' => $monitoring->jam_implementasi,
                'formatted_date' => Carbon::parse($monitoring->tgl_implementasi)->format('d M Y'),
                'formatted_time' => Carbon::parse($monitoring->jam_implementasi)->format('H:i'),
                'detail' => [
                    'sistolik' => $monitoring->detail->sistolik ?? '-',
                    'diastolik' => $monitoring->detail->diastolik ?? '-',
                    'map' => $monitoring->detail->map ?? '-',
                    'hr' => $monitoring->detail->hr ?? '-',
                    'rr' => $monitoring->detail->rr ?? '-',
                    'temp' => $monitoring->detail->temp ?? '-',
                ]
            ]
        ]);
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

        if ($dataMedis->riwayat_alergi) {
            $dataMedis->riwayat_alergi = collect(json_decode($dataMedis->riwayat_alergi, true))
                ->pluck('alergen')
                ->all();
        } else {
            $dataMedis->riwayat_alergi = [];
        }

        $dokter = Dokter::where('status', 1)->get();
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

        // Ambil daftar terapi obat untuk pasien dan kunjungan ini
        $therapies = RmeIntensiveMonitoringTherapy::where([
            'kd_unit' => $kd_unit,
            'kd_pasien' => $kd_pasien,
            'tgl_masuk' => $tgl_masuk,
            'urut_masuk' => $urut_masuk,
        ])->get();


        // Get patient's allergies from the Alergi table
        $allergies = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();

        // Create JSON format for allergies to initialize the form
        $allergiesJson = $allergies->map(function ($item) {
            return [
                'jenis_alergi' => $item->jenis_alergi,
                'nama_alergi' => $item->nama_alergi,
                'reaksi' => $item->reaksi,
                'severe' => $item->tingkat_keparahan
            ];
        });

        // Format allergies for display
        $allergiesDisplay = $allergies->pluck('nama_alergi')->join(', ');

        return view(
            'unit-pelayanan.rawat-inap.pelayanan.monitoring.create',
            compact('dataMedis', 'kd_unit', 'kd_pasien', 'tgl_masuk', 'urut_masuk', 'latestMonitoring', 'dokter', 'therapies', 'allergiesJson', 'allergiesDisplay')
        );
    }


    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        DB::beginTransaction();

        try {
            // Validasi input utama
            $validated = $request->validate([
                'tgl_implementasi' => 'required|date',
                'jam_implementasi' => 'required|date_format:H:i',
                'indikasi_iccu' => 'required|string',
                'diagnosa' => 'required|string',
                'sistolik' => 'required|numeric|min:0',
                'therapy_doses.*' => 'nullable|numeric|min:0', // Validasi dosis obat
            ]);

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
            $monitoring->berat_badan = $request->berat_badan;
            $monitoring->tinggi_badan = $request->tinggi_badan;
            $monitoring->hari_rawat = $request->hari_rawat;
            $monitoring->dokter = $request->dokter;
            $monitoring->dokter_jaga = $request->dokter_jaga;
            $monitoring->konsulen = $request->konsulen;
            $monitoring->anastesi_rb = $request->anastesi_rb;
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
            $monitoringDtl->bab = $request->bab;
            $monitoringDtl->urine = $request->urine;
            $monitoringDtl->iwl = $request->iwl;
            $monitoringDtl->muntahan_cms = $request->muntahan_cms;
            $monitoringDtl->drain = $request->drain;
            $monitoringDtl->cvp = $request->cvp;
            $monitoringDtl->ekg_record = $request->ekg_record;
            $monitoringDtl->oral = $request->oral;
            $monitoringDtl->ngt = $request->ngt;
            $monitoringDtl->save();

            // Simpan dosis terapi obat ke RME_INTENSIVE_MONITORING_THERAPY_DTL
            if ($request->has('therapy_doses')) {
                foreach ($request->therapy_doses as $therapyId => $dose) {
                    if (!is_null($dose) && $dose > 0) {
                        RmeIntensiveMonitoringTherapyDtl::create([
                            'id_monitoring' => $monitoring->id,
                            'id_therapy' => $therapyId,
                            'nilai' => $dose,
                        ]);
                    }
                }
            }

            // Handle allergies - store in the Alergi table
            if ($request->filled('alergi')) {
                try {
                    $allergies = json_decode($request->alergi, true);

                    if (is_array($allergies)) {
                        foreach ($allergies as $allergy) {
                            // Check if this allergy already exists to avoid duplicates
                            $existingAllergy = RmeAlergiPasien::where('kd_pasien', $kd_pasien)
                                ->where('jenis_alergi', $allergy['jenis_alergi'])
                                ->where('nama_alergi', $allergy['nama_alergi'])
                                ->first();

                            if (!$existingAllergy) {
                                RmeAlergiPasien::create([
                                    'kd_pasien' => $kd_pasien,
                                    'jenis_alergi' => $allergy['jenis_alergi'],
                                    'nama_alergi' => $allergy['nama_alergi'],
                                    'reaksi' => $allergy['reaksi'],
                                    'tingkat_keparahan' => $allergy['severe'] // Map 'severe' from the form to 'tingkat_keparahan' in DB
                                ]);
                            }
                        }
                    }
                } catch (\Exception $e) {
                }
            }

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

        // Mengambil nama alergen dari riwayat_alergi
        if ($dataMedis->riwayat_alergi) {
            $dataMedis->riwayat_alergi = collect(json_decode($dataMedis->riwayat_alergi, true))
                ->pluck('alergen')
                ->all();
        } else {
            $dataMedis->riwayat_alergi = [];
        }

        $dataMedis->waktu_masuk = Carbon::parse($dataMedis->TGL_MASUK . ' ' . $dataMedis->JAM_MASUK)->format('Y-m-d H:i:s');

        // Ambil data monitoring yang akan diedit
        $monitoring = RmeIntesiveMonitoring::with('detail')
            ->where('id', $id)
            ->where('kd_unit', $kd_unit)
            ->where('kd_pasien', $kd_pasien)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->firstOrFail();

        // Ambil daftar dokter
        $dokter = Dokter::where('status', 1)->get();

        // Ambil daftar terapi obat untuk pasien dan kunjungan ini, dengan dosis terkait
        $therapies = RmeIntensiveMonitoringTherapy::with(['dose' => function ($query) use ($id) {
            $query->where('id_monitoring', $id);
        }])
            ->where([
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
            ])
            ->get();

        // Get patient's allergies from the Alergi table
        $allergies = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();

        // Create JSON format for allergies to initialize the form
        $allergiesJson = $allergies->map(function ($item) {
            return [
                'jenis_alergi' => $item->jenis_alergi,
                'nama_alergi' => $item->nama_alergi,
                'reaksi' => $item->reaksi,
                'severe' => $item->tingkat_keparahan
            ];
        });

        // Format allergies for display
        $allergiesDisplay = $allergies->pluck('nama_alergi')->join(', ');

        return view(
            'unit-pelayanan.rawat-inap.pelayanan.monitoring.edit',
            compact('dataMedis', 'kd_unit', 'kd_pasien', 'tgl_masuk', 'urut_masuk', 'monitoring', 'dokter', 'therapies', 'allergiesJson', 'allergiesDisplay')
        );
    }

    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            // Validasi input utama
            $validated = $request->validate([
                'tgl_implementasi' => 'required|date',
                'jam_implementasi' => 'required|date_format:H:i',
                'indikasi_iccu' => 'required|string',
                'diagnosa' => 'required|string',
                'sistolik' => 'required|numeric|min:0',
                'therapy_doses.*' => 'nullable|numeric|min:0',
            ]);

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
            $monitoring->berat_badan = $request->berat_badan;
            $monitoring->tinggi_badan = $request->tinggi_badan;
            $monitoring->hari_rawat = $request->hari_rawat;
            $monitoring->dokter = $request->dokter;
            $monitoring->konsulen = $request->konsulen;
            $monitoring->anastesi_rb = $request->anastesi_rb;
            $monitoring->dokter_jaga = $request->dokter_jaga;
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
            $monitoringDtl->bab = $request->bab;
            $monitoringDtl->urine = $request->urine;
            $monitoringDtl->iwl = $request->iwl;
            $monitoringDtl->muntahan_cms = $request->muntahan_cms;
            $monitoringDtl->drain = $request->drain;
            $monitoringDtl->save();

            // Hapus dosis obat lama untuk monitoring ini
            RmeIntensiveMonitoringTherapyDtl::where('id_monitoring', $id)->delete();

            // Simpan dosis terapi obat baru ke RME_INTENSIVE_MONITORING_THERAPY_DTL
            if ($request->has('therapy_doses')) {
                foreach ($request->therapy_doses as $therapyId => $dose) {
                    if (!is_null($dose) && $dose > 0) {
                        RmeIntensiveMonitoringTherapyDtl::create([
                            'id_monitoring' => $monitoring->id,
                            'id_therapy' => $therapyId,
                            'nilai' => $dose,
                        ]);
                    }
                }
            }

            // Handle allergies - store in the Alergi table
            if ($request->filled('alergi')) {
                try {
                    $allergies = json_decode($request->alergi, true);

                    if (is_array($allergies)) {
                        foreach ($allergies as $allergy) {
                            // Check if this allergy already exists to avoid duplicates
                            $existingAllergy = RmeAlergiPasien::where('kd_pasien', $kd_pasien)
                                ->where('jenis_alergi', $allergy['jenis_alergi'])
                                ->where('nama_alergi', $allergy['nama_alergi'])
                                ->first();

                            if (!$existingAllergy) {
                                RmeAlergiPasien::create([
                                    'kd_pasien' => $kd_pasien,
                                    'jenis_alergi' => $allergy['jenis_alergi'],
                                    'nama_alergi' => $allergy['nama_alergi'],
                                    'reaksi' => $allergy['reaksi'],
                                    'tingkat_keparahan' => $allergy['severe'] // Map 'severe' from the form to 'tingkat_keparahan' in DB
                                ]);
                            }
                        }
                    }
                } catch (\Exception $e) {
                }
            }

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

    public function print(Request $request)
    {
        $kd_unit = $request->kd_unit;
        $kd_pasien = $request->kd_pasien;
        $tgl_masuk = $request->tgl_masuk;
        $urut_masuk = $request->urut_masuk;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

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
            $monitoringQuery->whereBetween('tgl_implementasi', [$start_date, $end_date]);
        }

        // Ambil data monitoring terbaru untuk info pasien di header
        $latestMonitoring = RmeIntesiveMonitoring::with(['detail'])
            ->where('kd_unit', $kd_unit)
            ->where('kd_pasien', $kd_pasien)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->orderBy('tgl_implementasi', 'desc')
            ->orderBy('jam_implementasi', 'desc')
            ->first();

        // Ambil semua data monitoring dengan urutan ASC untuk daftar dan chart
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
                'latestMonitoring', // Ini digunakan untuk data di header
                'title',
                'allMonitoringRecords',
                'start_date',
                'end_date'
            )
        );
    }

    //Create Therapy Obat
    public function createTherapy($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
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

        return view(
            'unit-pelayanan.rawat-inap.pelayanan.monitoring.create-therapy',
            compact('dataMedis', 'kd_unit',  'kd_pasien', 'tgl_masuk', 'urut_masuk')
        );
    }

    // Store therapy data
    public function storeTherapy(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $validated = $request->validate([
            'jenis_terapi' => 'required|in:1,2,3,4',
            'nama_obat' => 'required|string|max:255',
        ]);

        RmeIntensiveMonitoringTherapy::create([
            'kd_unit' => $kd_unit,
            'kd_pasien' => $kd_pasien,
            'tgl_masuk' => $tgl_masuk,
            'urut_masuk' => $urut_masuk,
            'jenis_terapi' => $validated['jenis_terapi'],
            'nama_obat' => $validated['nama_obat'],
        ]);

        return redirect()->back()->with('success', 'Terapi obat berhasil disimpan.');
    }

    // Delete therapy data
    public function destroyTherapy($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $therapy = RmeIntensiveMonitoringTherapy::where([
            'kd_unit' => $kd_unit,
            'kd_pasien' => $kd_pasien,
            'tgl_masuk' => $tgl_masuk,
            'urut_masuk' => $urut_masuk,
            'id' => $id,
        ])->firstOrFail();

        $therapy->delete();

        return redirect()->back()->with('success', 'Terapi obat berhasil dihapus.');
    }
}
