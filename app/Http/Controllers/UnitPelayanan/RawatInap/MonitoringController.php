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
use Exception;
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

    public function getAvailableDays($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        // Get distinct hari rawat with counts
        $hariRawatData = RmeIntesiveMonitoring::where('kd_unit', $kd_unit)
            ->where('kd_pasien', $kd_pasien)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->selectRaw('hari_rawat, COUNT(*) as count')
            ->groupBy('hari_rawat')
            ->orderBy('hari_rawat', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $hariRawatData
        ]);
    }

    public function getFilteredDataByDay(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $request->validate([
            'hari_rawat' => 'required|integer|min:1'
        ]);

        $hariRawat = $request->hari_rawat;

        // Get monitoring records for specific hari rawat with therapy relationships
        $monitoringRecords = RmeIntesiveMonitoring::with([
            'detail',
            'userCreator',
            'therapyDoses' => function ($query) {
                $query->with(['therapy' => function ($subQuery) {
                    $subQuery->select('id', 'nama_obat', 'jenis_terapi', 'dihitung');
                }]);
            }
        ])
            ->where('kd_unit', $kd_unit)
            ->where('kd_pasien', $kd_pasien)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->where('hari_rawat', $hariRawat)
            ->orderBy('tgl_implementasi', 'asc')
            ->orderBy('jam_implementasi', 'asc')
            ->get();

        // Format data for response including balance calculations
        $formattedData = $monitoringRecords->map(function ($record) {
            // Calculate balance considering ALL therapies (including oral) with dihitung = 1
            $totalInput = 0;
            $totalOutput = 0;

            // Count ALL therapy doses (oral, injection, drip, fluid) only if dihitung = 1
            if ($record->therapyDoses) {
                foreach ($record->therapyDoses as $dose) {
                    if (
                        $dose->therapy &&
                        in_array($dose->therapy->jenis_terapi, [1, 2, 3, 4]) && // Include oral therapy (1)
                        $dose->therapy->dihitung == 1 &&
                        isset($dose->nilai) &&
                        $dose->nilai > 0
                    ) {
                        $totalInput += floatval($dose->nilai);
                    }
                }
            }

            // Add enteral inputs (always counted)
            if (isset($record->detail->oral) && is_numeric($record->detail->oral)) {
                $totalInput += floatval($record->detail->oral);
            }
            if (isset($record->detail->ngt) && is_numeric($record->detail->ngt)) {
                $totalInput += floatval($record->detail->ngt);
            }

            // Calculate outputs (always counted)
            if (isset($record->detail->bab) && is_numeric($record->detail->bab)) {
                $totalOutput += floatval($record->detail->bab);
            }
            if (isset($record->detail->urine) && is_numeric($record->detail->urine)) {
                $totalOutput += floatval($record->detail->urine);
            }
            if (isset($record->detail->iwl) && is_numeric($record->detail->iwl)) {
                $totalOutput += floatval($record->detail->iwl);
            }
            if (isset($record->detail->muntahan_cms) && is_numeric($record->detail->muntahan_cms)) {
                $totalOutput += floatval($record->detail->muntahan_cms);
            }
            if (isset($record->detail->drain) && is_numeric($record->detail->drain)) {
                $totalOutput += floatval($record->detail->drain);
            }

            $balance = $totalInput - $totalOutput;

            return [
                'id' => $record->id,
                'tgl_implementasi' => $record->tgl_implementasi,
                'jam_implementasi' => $record->jam_implementasi,
                'hari_rawat' => $record->hari_rawat,
                'formatted_datetime' => Carbon::parse($record->tgl_implementasi)->format('d M Y') . ' ' .
                    Carbon::parse($record->jam_implementasi)->format('H:i'),
                'detail' => [
                    'sistolik' => $record->detail->sistolik ?? 0,
                    'diastolik' => $record->detail->diastolik ?? 0,
                    'map' => $record->detail->map ?? 0,
                    'hr' => $record->detail->hr ?? 0,
                    'rr' => $record->detail->rr ?? 0,
                    'temp' => $record->detail->temp ?? 0,
                ],
                'balance_info' => [
                    'total_input' => $totalInput,
                    'total_output' => $totalOutput,
                    'balance' => $balance,
                    'includes_all_counted_therapies' => true // Updated note
                ]
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $formattedData,
            'count' => $formattedData->count(),
            'filter_info' => [
                'hari_rawat' => $hariRawat,
            ]
        ]);
    }

    public function getAllMonitoringData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        // Get all monitoring records with therapy relationships
        $monitoringRecords = RmeIntesiveMonitoring::with([
            'detail',
            'userCreator',
            'therapyDoses' => function ($query) {
                $query->with(['therapy' => function ($subQuery) {
                    $subQuery->select('id', 'nama_obat', 'jenis_terapi', 'dihitung');
                }]);
            }
        ])
            ->where('kd_unit', $kd_unit)
            ->where('kd_pasien', $kd_pasien)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->orderBy('hari_rawat', 'asc')
            ->orderBy('tgl_implementasi', 'asc')
            ->orderBy('jam_implementasi', 'asc')
            ->get();

        // Format data for response including balance calculations
        $formattedData = $monitoringRecords->map(function ($record) {
            // Calculate balance considering ALL therapies (including oral) with dihitung = 1
            $totalInput = 0;
            $totalOutput = 0;

            // Count ALL therapy doses (oral, injection, drip, fluid) only if dihitung = 1
            if ($record->therapyDoses) {
                foreach ($record->therapyDoses as $dose) {
                    if (
                        $dose->therapy &&
                        in_array($dose->therapy->jenis_terapi, [1, 2, 3, 4]) && // Include oral therapy (1)
                        $dose->therapy->dihitung == 1 &&
                        isset($dose->nilai) &&
                        $dose->nilai > 0
                    ) {
                        $totalInput += floatval($dose->nilai);
                    }
                }
            }

            // Add enteral inputs (always counted)
            if (isset($record->detail->oral) && is_numeric($record->detail->oral)) {
                $totalInput += floatval($record->detail->oral);
            }
            if (isset($record->detail->ngt) && is_numeric($record->detail->ngt)) {
                $totalInput += floatval($record->detail->ngt);
            }

            // Calculate outputs (always counted)
            if (isset($record->detail->bab) && is_numeric($record->detail->bab)) {
                $totalOutput += floatval($record->detail->bab);
            }
            if (isset($record->detail->urine) && is_numeric($record->detail->urine)) {
                $totalOutput += floatval($record->detail->urine);
            }
            if (isset($record->detail->iwl) && is_numeric($record->detail->iwl)) {
                $totalOutput += floatval($record->detail->iwl);
            }
            if (isset($record->detail->muntahan_cms) && is_numeric($record->detail->muntahan_cms)) {
                $totalOutput += floatval($record->detail->muntahan_cms);
            }
            if (isset($record->detail->drain) && is_numeric($record->detail->drain)) {
                $totalOutput += floatval($record->detail->drain);
            }

            $balance = $totalInput - $totalOutput;

            return [
                'id' => $record->id,
                'tgl_implementasi' => $record->tgl_implementasi,
                'jam_implementasi' => $record->jam_implementasi,
                'hari_rawat' => $record->hari_rawat,
                'formatted_datetime' => Carbon::parse($record->tgl_implementasi)->format('d M Y') . ' ' .
                    Carbon::parse($record->jam_implementasi)->format('H:i'),
                'detail' => [
                    'sistolik' => $record->detail->sistolik ?? 0,
                    'diastolik' => $record->detail->diastolik ?? 0,
                    'map' => $record->detail->map ?? 0,
                    'hr' => $record->detail->hr ?? 0,
                    'rr' => $record->detail->rr ?? 0,
                    'temp' => $record->detail->temp ?? 0,
                ],
                'balance_info' => [
                    'total_input' => $totalInput,
                    'total_output' => $totalOutput,
                    'balance' => $balance,
                    'includes_all_counted_therapies' => true // Updated note
                ]
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $formattedData,
            'count' => $formattedData->count(),
            'filter_info' => [
                'type' => 'all_days',
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
                'hari_rawat' => $monitoring->hari_rawat,
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


        // Decode konsulen JSON if exists
        if ($latestMonitoring && $latestMonitoring->konsulen) {
            try {
                $konsulenArray = json_decode($latestMonitoring->konsulen, true);
                if (!is_array($konsulenArray)) {
                    // Handle old format (single doctor)
                    $latestMonitoring->konsulen_array = [$latestMonitoring->konsulen];
                } else {
                    $latestMonitoring->konsulen_array = $konsulenArray;
                }
            } catch (Exception $e) {
                // Handle invalid JSON
                $latestMonitoring->konsulen_array = [$latestMonitoring->konsulen];
            }
        } else if ($latestMonitoring) {
            $latestMonitoring->konsulen_array = [];
        }
        

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

        // Dynamic title based on unit
        $unitTitles = [
            '10015' => 'Monitoring ICCU',
            '10016' => 'Monitoring ICU',
            '10131' => 'Monitoring NICU',
            '10132' => 'Monitoring PICU',
        ];
        $title = isset($unitTitles[$kd_unit]) ? $unitTitles[$kd_unit] : 'Monitoring Intensive Care';

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
                'sistolik' => 'required|numeric|min:0',
                'therapy_doses.*' => 'nullable|numeric|min:0', // Validasi dosis obat
            ]);


            // Process Konsulen array
            $konsulenArray = [];
            if ($request->has('konsulen') && is_array($request->konsulen)) {
                $konsulenArray = array_filter($request->konsulen, function ($value) {
                    return !empty($value);
                });
            }

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
            // Store konsulen as JSON array
            $monitoring->konsulen = !empty($konsulenArray) ? json_encode(array_values($konsulenArray)) : null;
            $monitoring->anastesi_rb = $request->anastesi_rb;

            //NICU BAYI
            $monitoring->usia_kelahiran = $request->usia_kelahiran;
            $monitoring->umur_bayi = $request->umur_bayi;
            $monitoring->umur_gestasi = $request->umur_gestasi;
            $monitoring->berat_badan_lahir = $request->berat_badan_lahir;
            $monitoring->cara_persalinan = $request->cara_persalinan;
            $monitoring->dokter_diagnosa_1 = $request->dokter_diagnosa_1;
            $monitoring->dokter_diagnosa_2 = $request->dokter_diagnosa_2;
            $monitoring->dokter_nicu_1 = $request->dokter_nicu_1;
            $monitoring->dokter_nicu_2 = $request->dokter_nicu_2;
            $monitoring->dokter_konsul_1 = $request->dokter_konsul_1;
            $monitoring->dokter_konsul_2 = $request->dokter_konsul_2;

            //USER DETECTED
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


        // Decode konsulen JSON for edit form
        if ($monitoring->konsulen) {
            try {
                $konsulenArray = json_decode($monitoring->konsulen, true);
                if (!is_array($konsulenArray)) {
                    // Handle old format (single doctor)
                    $monitoring->konsulen_array = [$monitoring->konsulen];
                } else {
                    $monitoring->konsulen_array = $konsulenArray;
                }
            } catch (Exception $e) {
                // Handle invalid JSON
                $monitoring->konsulen_array = [$monitoring->konsulen];
            }
        } else {
            $monitoring->konsulen_array = [];
        }


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
                'sistolik' => 'required|numeric|min:0',
                'therapy_doses.*' => 'nullable|numeric|min:0',
            ]);

            // Process Konsulen array
            $konsulenArray = [];
            if ($request->has('konsulen') && is_array($request->konsulen)) {
                $konsulenArray = array_filter($request->konsulen, function ($value) {
                    return !empty($value);
                });
            }


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
            // Update konsulen as JSON array
            $monitoring->konsulen = !empty($konsulenArray) ? json_encode(array_values($konsulenArray)) : null;
            $monitoring->anastesi_rb = $request->anastesi_rb;

            //NICU BAYI
            $monitoring->usia_kelahiran = $request->usia_kelahiran;
            $monitoring->umur_bayi = $request->umur_bayi;
            $monitoring->umur_gestasi = $request->umur_gestasi;
            $monitoring->berat_badan_lahir = $request->berat_badan_lahir;
            $monitoring->cara_persalinan = $request->cara_persalinan;
            $monitoring->dokter_diagnosa_1 = $request->dokter_diagnosa_1;
            $monitoring->dokter_diagnosa_2 = $request->dokter_diagnosa_2;
            $monitoring->dokter_nicu_1 = $request->dokter_nicu_1;
            $monitoring->dokter_nicu_2 = $request->dokter_nicu_2;
            $monitoring->dokter_konsul_1 = $request->dokter_konsul_1;
            $monitoring->dokter_konsul_2 = $request->dokter_konsul_2;

            // Update user information
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

    public function printMonitoring(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        // Get patient data
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

        // Calculate patient age
        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        // Build query for monitoring records - UPDATED: Include dihitung field
        $query = RmeIntesiveMonitoring::with([
            'detail',
            'userCreator',
            'therapyDoses' => function ($query) {
                $query->with(['therapy' => function ($subQuery) {
                    // Make sure to include the 'dihitung' field
                    $subQuery->select('id', 'kd_unit', 'kd_pasien', 'tgl_masuk', 'urut_masuk', 'jenis_terapi', 'nama_obat', 'dihitung');
                }]);
            }
        ])
            ->where('kd_unit', $kd_unit)
            ->where('kd_pasien', $kd_pasien)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk);

        // Apply filter based on request parameters
        $filterType = 'Semua Data';
        $filterValue = '';

        if ($request->has('hari_rawat') && !empty($request->hari_rawat)) {
            $hariRawat = $request->hari_rawat;
            $query->where('hari_rawat', $hariRawat);
            $filterType = 'Hari Rawat';
            $filterValue = "Ke-{$hariRawat}";
        }

        $monitoringRecords = $query->orderBy('hari_rawat', 'asc')
            ->orderBy('tgl_implementasi', 'asc')
            ->orderBy('jam_implementasi', 'asc')
            ->get();

        // Dynamic title based on unit
        $unitTitles = [
            '10015' => 'ICCU',
            '10016' => 'ICU',
            '10131' => 'NICU',
            '10132' => 'PICU',
        ];
        $title = isset($unitTitles[$kd_unit]) ? $unitTitles[$kd_unit] : 'Monitoring Intensive Care';

        $subUnitTitles = [
            '10015' => 'Intensive Coronary Care Unit',
            '10016' => 'Intensive Care Unit',
            '10131' => 'Neonatal Intensive Care Unit',
            '10132' => 'Pediatric Intensive Care Unit',
        ];
        $subTitle = isset($subUnitTitles[$kd_unit]) ? $subUnitTitles[$kd_unit] : 'Monitoring Intensive Care';

        $latestMonitoring = $monitoringRecords->sortByDesc(function ($record) {
            return \Carbon\Carbon::parse($record->tgl_implementasi . ' ' . $record->jam_implementasi);
        })->first();

        // Decode konsulen untuk latest monitoring
        if ($latestMonitoring && $latestMonitoring->konsulen) {
            $latestMonitoring->konsulen_names = $this->getKonsulenNamesForPrint($latestMonitoring->konsulen);
            $latestMonitoring->konsulen_display = implode(', ', $latestMonitoring->konsulen_names);
        } else if ($latestMonitoring) {
            $latestMonitoring->konsulen_names = [];
            $latestMonitoring->konsulen_display = '-';
        }

        // Get dokter name untuk latest monitoring
        if ($latestMonitoring && $latestMonitoring->dokter) {
            $latestMonitoring->dokter_name = $this->getDokterNameForPrint($latestMonitoring->dokter);
        } else if ($latestMonitoring) {
            $latestMonitoring->dokter_name = '-';
        }

        // Prepare data for view
        $printData = [
            'dataMedis' => $dataMedis,
            'monitoringRecords' => $monitoringRecords,
            'latestMonitoring' => $latestMonitoring,
            'title' => $title,
            'subTitle' => $subTitle,
            'filterType' => $filterType,
            'filterValue' => $filterValue,
            'printDate' => Carbon::now()->format('d M Y H:i'),
            'kd_unit' => $kd_unit,
            'kd_pasien' => $kd_pasien,
            'tgl_masuk' => $tgl_masuk,
            'urut_masuk' => $urut_masuk,
            'allergiesDisplay' => $latestMonitoring->allergies ?? 'Tidak Ada Alergi'
        ];

        return view('unit-pelayanan.rawat-inap.pelayanan.monitoring.print', $printData);
    }

    // Store therapy data
    public function storeTherapy(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $validated = $request->validate([
            'therapies' => 'required|array|min:1',
            'therapies.*.jenis_terapi' => 'required|in:1,2,3,4',
            'therapies.*.nama_obat' => 'required|string|max:255',
            'therapies.*.dihitung' => 'nullable|boolean',
        ]);

        try {
            // Loop through each therapy and save individually
            foreach ($validated['therapies'] as $therapy) {
                RmeIntensiveMonitoringTherapy::create([
                    'kd_unit' => $kd_unit,
                    'kd_pasien' => $kd_pasien,
                    'tgl_masuk' => $tgl_masuk,
                    'urut_masuk' => $urut_masuk,
                    'jenis_terapi' => $therapy['jenis_terapi'],
                    'nama_obat' => $therapy['nama_obat'],
                    'dihitung' => isset($therapy['dihitung']) ? 1 : 0, // Convert checkbox to boolean
                ]);
            }

            $count = count($validated['therapies']);
            $message = $count > 1
                ? "Berhasil menyimpan {$count} terapi obat."
                : "Terapi obat berhasil disimpan.";

            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data terapi obat.');
        }
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


    private function getKonsulenNamesForPrint($konsulenJson)
    {
        if (empty($konsulenJson)) {
            return [];
        }

        try {
            $konsulenArray = json_decode($konsulenJson, true);
            if (!is_array($konsulenArray)) {
                // Handle old format (single doctor)
                $konsulenArray = [$konsulenJson];
            }

            $konsulenNames = [];
            foreach ($konsulenArray as $konsulenId) {
                $dokter = Dokter::where('kd_dokter', $konsulenId)->first();
                if ($dokter) {
                    $konsulenNames[] = $dokter->nama_lengkap;
                } else {
                    $konsulenNames[] = $konsulenId; // Fallback ke kode dokter
                }
            }

            return $konsulenNames;
        } catch (Exception $e) {
            // Handle invalid JSON - treat as single doctor
            $dokter = Dokter::where('kd_dokter', $konsulenJson)->first();
            return $dokter ? [$dokter->nama_lengkap] : [$konsulenJson];
        }
    }

    // Method helper untuk mendapatkan nama dokter dari kode
    private function getDokterNameForPrint($kodeDokter)
    {
        if (empty($kodeDokter)) {
            return '-';
        }

        $dokter = Dokter::where('kd_dokter', $kodeDokter)->first();
        return $dokter ? $dokter->nama_lengkap : $kodeDokter;
    }

}
