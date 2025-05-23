<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\Perawat;
use App\Models\RmeAlergiPasien;
use App\Models\RmeObservasi;
use App\Models\RmeObservasiDtl;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ObservasiController extends Controller
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

        // Fetch all observations for this patient, unit, and visit
        $observasiList = RmeObservasi::with(['details', 'creator'])
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('urut_masuk', $urut_masuk)
            ->orderBy('tanggal', 'desc')
            ->get();

        // Get min and max dates for the print modal
        $dateRange = RmeObservasi::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('urut_masuk', $urut_masuk)
            ->selectRaw('MIN(tanggal) as min_date, MAX(tanggal) as max_date')
            ->first();

        return view('unit-pelayanan.rawat-inap.pelayanan.observasi.index', [
            'dataMedis' => $dataMedis,
            'observasiList' => $observasiList,
            'minDate' => $dateRange->min_date ?? null,
            'maxDate' => $dateRange->max_date ?? null
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

        $perawat = Perawat::where('aktif', 1)->get();

        // Check for existing observation data for the same date
        $existingObservasi = RmeObservasi::with('details')
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tanggal', Carbon::today())
            ->first();

        $hasExistingObservasi = $existingObservasi !== null;
        $existingDetails = $existingObservasi ? $existingObservasi->details->keyBy('waktu') : collect([]);

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

        // Get the last weight for new records
        $lastWeight = '';
        if (!$existingObservasi) {
            $lastObservasi = RmeObservasi::where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->where('urut_masuk', $urut_masuk)
                ->orderBy('tanggal', 'desc')
                ->first();

            if ($lastObservasi) {
                $lastWeight = $lastObservasi->berat_badan;
            }
        }

        return view('unit-pelayanan.rawat-inap.pelayanan.observasi.create', [
            'dataMedis' => $dataMedis,
            'perawat' => $perawat,
            'existingObservasi' => $existingObservasi,
            'existingDetails' => $existingDetails,
            'hasExistingObservasi' => $hasExistingObservasi,
            'allergiesJson' => $allergiesJson->count() > 0 ? $allergiesJson->toJson() : '',
            'allergiesDisplay' => $allergiesDisplay,
            'lastWeight' => $lastWeight
        ]);
    }


    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'berat_badan' => 'required|numeric',
            'sensorium' => 'required|string',
            'diet' => 'nullable|string',
            // Alat Invasive fields
            'ngt' => 'required|in:Ada,Tidak Ada',
            'catheter' => 'required|in:Ada,Tidak Ada',
            'infus' => 'required|in:Ada,Tidak Ada',
            'triway' => 'required|in:Ada,Tidak Ada',
            'syringe_pump' => 'required|in:Ada,Tidak Ada',
            'infus_pump' => 'required|in:Ada,Tidak Ada',
            // Vital sign validations (optional, as users may only fill certain times)
            'suhu_pagi' => 'nullable|numeric',
            'nadi_pagi' => 'nullable|numeric',
            'tekanan_darah_sistole_pagi' => 'nullable|numeric',
            'tekanan_darah_diastole_pagi' => 'nullable|numeric',
            'respirasi_pagi' => 'nullable|numeric',
            'suhu_siang' => 'nullable|numeric',
            'nadi_siang' => 'nullable|numeric',
            'tekanan_darah_sistole_siang' => 'nullable|numeric',
            'tekanan_darah_diastole_siang' => 'nullable|numeric',
            'respirasi_siang' => 'nullable|numeric',
            'suhu_sore' => 'nullable|numeric',
            'nadi_sore' => 'nullable|numeric',
            'tekanan_darah_sistole_sore' => 'nullable|numeric',
            'tekanan_darah_diastole_sore' => 'nullable|numeric',
            'respirasi_sore' => 'nullable|numeric',
            'suhu_malam' => 'nullable|numeric',
            'nadi_malam' => 'nullable|numeric',
            'tekanan_darah_sistole_malam' => 'nullable|numeric',
            'tekanan_darah_diastole_malam' => 'nullable|numeric',
            'respirasi_malam' => 'nullable|numeric',
            'force_new' => 'nullable|boolean',
        ]);

        try {
            DB::beginTransaction();

            // Check if observation exists for the same date
            $observasi = RmeObservasi::where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->where('urut_masuk', $urut_masuk)
                ->whereDate('tanggal', Carbon::parse($request->tanggal))
                ->first();

            $observasiData = [
                'kd_pasien' => $kd_pasien,
                'kd_unit' => $kd_unit,
                'urut_masuk' => $urut_masuk,
                'tgl_masuk' => $tgl_masuk,
                'tanggal' => Carbon::parse($request->tanggal),
                'berat_badan' => $request->berat_badan,
                'sensorium' => $request->sensorium,
                'ngt' => $request->ngt,
                'catheter' => $request->catheter,
                'infus' => $request->infus,
                'triway' => $request->triway,
                'syringe_pump' => $request->syringe_pump,
                'infus_pump' => $request->infus_pump,
                'diet' => $request->diet,
                'user_create' => Auth::user()->id,
            ];

            if ($observasi && !$request->force_new) {
                // Update existing observation
                $observasi->update($observasiData);
            } else {
                // Create new observation
                $observasi = RmeObservasi::create($observasiData);
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

            // Merge vital sign data for each time slot
            $vitalSigns = [
                '06:00' => [
                    'suhu' => $request->suhu_pagi,
                    'nadi' => $request->nadi_pagi,
                    'tekanan_darah_sistole' => $request->tekanan_darah_sistole_pagi,
                    'tekanan_darah_diastole' => $request->tekanan_darah_diastole_pagi,
                    'respirasi' => $request->respirasi_pagi,
                ],
                '12:00' => [
                    'suhu' => $request->suhu_siang,
                    'nadi' => $request->nadi_siang,
                    'tekanan_darah_sistole' => $request->tekanan_darah_sistole_siang,
                    'tekanan_darah_diastole' => $request->tekanan_darah_diastole_siang,
                    'respirasi' => $request->respirasi_siang,
                ],
                '18:00' => [
                    'suhu' => $request->suhu_sore,
                    'nadi' => $request->nadi_sore,
                    'tekanan_darah_sistole' => $request->tekanan_darah_sistole_sore,
                    'tekanan_darah_diastole' => $request->tekanan_darah_diastole_sore,
                    'respirasi' => $request->respirasi_sore,
                ],
                '24:00' => [
                    'suhu' => $request->suhu_malam,
                    'nadi' => $request->nadi_malam,
                    'tekanan_darah_sistole' => $request->tekanan_darah_sistole_malam,
                    'tekanan_darah_diastole' => $request->tekanan_darah_diastole_malam,
                    'respirasi' => $request->respirasi_malam,
                ],
            ];

            // Add vital signs to data array, preserving existing values if updating
            foreach ($vitalSigns as $waktu => $signs) {
                // Check if any vital sign data is provided for this time slot
                if ($signs['suhu'] || $signs['nadi'] || $signs['tekanan_darah_sistole'] || $signs['tekanan_darah_diastole'] || $signs['respirasi']) {
                    // Check if detail exists for this time slot
                    $detail = RmeObservasiDtl::where('observasi_id', $observasi->id)
                        ->where('waktu', $waktu)
                        ->first();

                    $detailData = [
                        'observasi_id' => $observasi->id,
                        'waktu' => $waktu,
                        'suhu' => $signs['suhu'],
                        'nadi' => $signs['nadi'],
                        'tekanan_darah_sistole' => $signs['tekanan_darah_sistole'],
                        'tekanan_darah_diastole' => $signs['tekanan_darah_diastole'],
                        'respirasi' => $signs['respirasi'],
                    ];

                    if ($detail) {
                        // Update existing detail
                        $detail->update($detailData);
                    } else {
                        // Create new detail
                        RmeObservasiDtl::create($detailData);
                    }
                }
            }

            DB::commit();

            return redirect()->route('rawat-inap.observasi.index', [
                $kd_unit,
                $kd_pasien,
                $tgl_masuk,
                $urut_masuk
            ])->with('success', 'Data observasi dan alergi berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi. ' . $e->getMessage());
        }
    }


    public function show($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $observasi = RmeObservasi::with(['details', 'perawat'])
            ->where('id', $id)
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('urut_masuk', $urut_masuk)
            ->firstOrFail();

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
            ->firstOrFail();

        return view('unit-pelayanan.rawat-inap.pelayanan.observasi.show', compact('dataMedis', 'observasi'));
    }

    public function edit($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $observasi = RmeObservasi::with(['details', 'perawat'])
            ->where('id', $id)
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('urut_masuk', $urut_masuk)
            ->firstOrFail();

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
            ->firstOrFail();

        $perawat = Perawat::where('aktif', 1)->get();
        $existingDetails = $observasi->details->keyBy('waktu');

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

        // Get the last weight for potential new records
        $lastWeight = '';
        $lastObservasi = RmeObservasi::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('urut_masuk', $urut_masuk)
            ->where('id', '!=', $observasi->id)
            ->orderByDesc('tanggal')
            ->first();

        if ($lastObservasi) {
            $lastWeight = $lastObservasi->berat_badan;
        }

        return view('unit-pelayanan.rawat-inap.pelayanan.observasi.edit', [
            'dataMedis' => $dataMedis,
            'observasi' => $observasi,
            'perawat' => $perawat,
            'existingDetails' => $existingDetails,
            'allergiesJson' => $allergiesJson->count() > 0 ? $allergiesJson->toJson() : '',
            'allergiesDisplay' => $allergiesDisplay,
            'lastWeight' => $lastWeight
        ]);
    }

    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'berat_badan' => 'required|numeric',
            'sensorium' => 'required|string',
            'diet' => 'nullable|string',
            // Alat Invasive fields
            'ngt' => 'required|in:Ada,Tidak Ada',
            'catheter' => 'required|in:Ada,Tidak Ada',
            'infus' => 'required|in:Ada,Tidak Ada',
            'triway' => 'required|in:Ada,Tidak Ada',
            'syringe_pump' => 'required|in:Ada,Tidak Ada',
            'infus_pump' => 'required|in:Ada,Tidak Ada',
            // Vital sign validations (optional, as users may only fill certain times)
            'suhu_pagi' => 'nullable|numeric',
            'nadi_pagi' => 'nullable|numeric',
            'tekanan_darah_sistole_pagi' => 'nullable|numeric',
            'tekanan_darah_diastole_pagi' => 'nullable|numeric',
            'respirasi_pagi' => 'nullable|numeric',
            'suhu_siang' => 'nullable|numeric',
            'nadi_siang' => 'nullable|numeric',
            'tekanan_darah_sistole_siang' => 'nullable|numeric',
            'tekanan_darah_diastole_siang' => 'nullable|numeric',
            'respirasi_siang' => 'nullable|numeric',
            'suhu_sore' => 'nullable|numeric',
            'nadi_sore' => 'nullable|numeric',
            'tekanan_darah_sistole_sore' => 'nullable|numeric',
            'tekanan_darah_diastole_sore' => 'nullable|numeric',
            'respirasi_sore' => 'nullable|numeric',
            'suhu_malam' => 'nullable|numeric',
            'nadi_malam' => 'nullable|numeric',
            'tekanan_darah_sistole_malam' => 'nullable|numeric',
            'tekanan_darah_diastole_malam' => 'nullable|numeric',
            'respirasi_malam' => 'nullable|numeric',
            'force_new' => 'nullable|boolean',
        ]);

        try {
            DB::beginTransaction();

            $observasiData = [
                'kd_pasien' => $kd_pasien,
                'kd_unit' => $kd_unit,
                'urut_masuk' => $urut_masuk,
                'tgl_masuk' => $tgl_masuk,
                'tanggal' => Carbon::parse($request->tanggal),
                'berat_badan' => $request->berat_badan,
                'sensorium' => $request->sensorium,
                'ngt' => $request->ngt,
                'catheter' => $request->catheter,
                'infus' => $request->infus,
                'triway' => $request->triway,
                'syringe_pump' => $request->syringe_pump,
                'infus_pump' => $request->infus_pump,
                'diet' => $request->diet,
            ];

            // Check if user wants to create a new record instead of updating
            if ($request->force_new) {
                // New observation will have user_create
                $observasiData['user_create'] = Auth::user()->id;
                $observasi = RmeObservasi::create($observasiData);
            } else {
                // Update existing observation
                $observasi = RmeObservasi::where('id', $id)
                    ->where('kd_pasien', $kd_pasien)
                    ->where('kd_unit', $kd_unit)
                    ->where('urut_masuk', $urut_masuk)
                    ->firstOrFail();

                // Update will have user_edit
                $observasiData['user_edit'] = Auth::user()->id;
                $observasi->update($observasiData);
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
                    // Log allergy processing error without halting the transaction
                    Log::error('Error processing allergies: ' . $e->getMessage());
                }
            }

            // Merge vital sign data for each time slot
            $vitalSigns = [
                '06:00' => [
                    'suhu' => $request->suhu_pagi,
                    'nadi' => $request->nadi_pagi,
                    'tekanan_darah_sistole' => $request->tekanan_darah_sistole_pagi,
                    'tekanan_darah_diastole' => $request->tekanan_darah_diastole_pagi,
                    'respirasi' => $request->respirasi_pagi,
                ],
                '12:00' => [
                    'suhu' => $request->suhu_siang,
                    'nadi' => $request->nadi_siang,
                    'tekanan_darah_sistole' => $request->tekanan_darah_sistole_siang,
                    'tekanan_darah_diastole' => $request->tekanan_darah_diastole_siang,
                    'respirasi' => $request->respirasi_siang,
                ],
                '18:00' => [
                    'suhu' => $request->suhu_sore,
                    'nadi' => $request->nadi_sore,
                    'tekanan_darah_sistole' => $request->tekanan_darah_sistole_sore,
                    'tekanan_darah_diastole' => $request->tekanan_darah_diastole_sore,
                    'respirasi' => $request->respirasi_sore,
                ],
                '24:00' => [
                    'suhu' => $request->suhu_malam,
                    'nadi' => $request->nadi_malam,
                    'tekanan_darah_sistole' => $request->tekanan_darah_sistole_malam,
                    'tekanan_darah_diastole' => $request->tekanan_darah_diastole_malam,
                    'respirasi' => $request->respirasi_malam,
                ],
            ];

            // Add or update vital signs for each time slot
            foreach ($vitalSigns as $waktu => $signs) {
                // Check if any vital sign data is provided for this time slot
                if ($signs['suhu'] || $signs['nadi'] || $signs['tekanan_darah_sistole'] || $signs['tekanan_darah_diastole'] || $signs['respirasi']) {
                    // Check if detail exists for this time slot
                    $detail = RmeObservasiDtl::where('observasi_id', $observasi->id)
                        ->where('waktu', $waktu)
                        ->first();

                    $detailData = [
                        'observasi_id' => $observasi->id,
                        'waktu' => $waktu,
                        'suhu' => $signs['suhu'],
                        'nadi' => $signs['nadi'],
                        'tekanan_darah_sistole' => $signs['tekanan_darah_sistole'],
                        'tekanan_darah_diastole' => $signs['tekanan_darah_diastole'],
                        'respirasi' => $signs['respirasi'],
                    ];

                    if ($detail) {
                        // Update existing detail
                        $detail->update($detailData);
                    } else {
                        // Create new detail
                        RmeObservasiDtl::create($detailData);
                    }
                }
            }

            DB::commit();

            return redirect()->route('rawat-inap.observasi.index', [
                $kd_unit,
                $kd_pasien,
                $tgl_masuk,
                $urut_masuk
            ])->with('success', $request->force_new ? 'Data observasi baru berhasil dibuat.' : 'Data observasi berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating observation: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data. Silakan coba lagi: ' . $e->getMessage());
        }
    }


    public function destroy($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();
        try {
            $observasi = RmeObservasi::where('id', $id)
                ->where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->where('urut_masuk', $urut_masuk)
                ->firstOrFail();

            $observasi->delete(); // This will also delete related RmeObservasiDtl due to onDelete('cascade')
            DB::commit();

            return redirect()->route('rawat-inap.observasi.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data observasi berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data.' . $e->getMessage());
        }
    }

    // public function print(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    // {
    //     $request->validate([
    //         'start_date' => 'nullable|date',
    //         'end_date' => 'nullable|date',
    //     ]);

    //     $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
    //         ->join('transaksi as t', function ($join) {
    //             $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
    //             $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
    //             $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
    //             $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
    //         })
    //         ->where('kunjungan.kd_pasien', $kd_pasien)
    //         ->where('kunjungan.kd_unit', $kd_unit)
    //         ->where('kunjungan.urut_masuk', $urut_masuk)
    //         ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
    //         ->firstOrFail();

    //     if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
    //         $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
    //     } else {
    //         $dataMedis->pasien->umur = 'Tidak Diketahui';
    //     }

    //     // Query to get observation data with date filtering
    //     $query = RmeObservasi::with(['details', 'creator'])
    //         ->where('kd_pasien', $kd_pasien)
    //         ->where('kd_unit', $kd_unit)
    //         ->where('urut_masuk', $urut_masuk);

    //     // Apply date filters if provided
    //     if ($request->filled('start_date')) {
    //         $query->where('tanggal', '>=', Carbon::parse($request->start_date)->startOfDay());
    //     }

    //     if ($request->filled('end_date')) {
    //         $query->where('tanggal', '<=', Carbon::parse($request->end_date)->endOfDay());
    //     }

    //     // Get the observations ordered by date
    //     $observasiList = $query->orderBy('tanggal', 'asc')->get();

    //     // Get the logo path for the PDF
    //     $logoPath = public_path('assets/img/Logo-RSUD-Langsa-1.png');

    //     // Check if the logo file exists, if not use a default
    //     if (!file_exists($logoPath)) {
    //         $logoPath = null;
    //     }

    //     // Generate PDF
    //     $pdf = PDF::loadView('unit-pelayanan.rawat-inap.pelayanan.observasi.print-pdf', [
    //         'dataMedis' => $dataMedis,
    //         'observasiList' => $observasiList,
    //         'startDate' => $request->filled('start_date') ? Carbon::parse($request->start_date)->format('d-m-Y') : null,
    //         'endDate' => $request->filled('end_date') ? Carbon::parse($request->end_date)->format('d-m-Y') : null,
    //         'logoPath' => $logoPath
    //     ]);
    //     // Set paper options (A4 landscape for better table display)
    //     $pdf->setPaper('a4', 'potrait');

    //     // Return the PDF for download
    //     return $pdf->stream('observasi-' . $kd_pasien . '.pdf');
    // }


    public function print(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

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
            ->firstOrFail();

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        // Query to get observation data with date filtering
        $query = RmeObservasi::with(['details', 'creator'])
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('urut_masuk', $urut_masuk);

        // Apply date filters if provided
        if ($request->filled('start_date')) {
            $query->where('tanggal', '>=', Carbon::parse($request->start_date)->startOfDay());
        }

        if ($request->filled('end_date')) {
            $query->where('tanggal', '<=', Carbon::parse($request->end_date)->endOfDay());
        }

        // Get the observations ordered by date
        $observasiList = $query->orderBy('tanggal', 'asc')->get();

        // Get the logo path for the print view
        $logoPath = asset('assets/img/Logo-RSUD-Langsa-1.png');

        // Return view directly - tidak generate PDF
        return view('unit-pelayanan.rawat-inap.pelayanan.observasi.print-html', [
            'dataMedis' => $dataMedis,
            'observasiList' => $observasiList,
            'startDate' => $request->filled('start_date') ? Carbon::parse($request->start_date)->format('d-m-Y') : null,
            'endDate' => $request->filled('end_date') ? Carbon::parse($request->end_date)->format('d-m-Y') : null,
            'logoPath' => $logoPath
        ]);
    }

}
