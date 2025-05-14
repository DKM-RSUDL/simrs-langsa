<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\Perawat;
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

        return view('unit-pelayanan.rawat-inap.pelayanan.observasi.create', [
            'dataMedis' => $dataMedis,
            'perawat' => $perawat,
            'existingObservasi' => $existingObservasi,
            'existingDetails' => $existingDetails,
            'hasExistingObservasi' => $hasExistingObservasi,
        ]);
    }


    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'berat_badan' => 'required|numeric',
            'sensorium' => 'required|string',
            'alat_invasive' => 'nullable|string',
            'ngt' => 'nullable|string',
            'catheter' => 'nullable|string',
            'diet' => 'nullable|string',
            'alergi' => 'nullable|string',
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
                'alat_invasive' => $request->alat_invasive,
                'ngt' => $request->ngt,
                'catheter' => $request->catheter,
                'diet' => $request->diet,
                'alergi' => $request->alergi,
                'user_create' => Auth::user()->id,
            ];

            if ($observasi) {
                // Update existing observation
                $observasi->update($observasiData);
            } else {
                // Create new observation
                $observasi = RmeObservasi::create($observasiData);
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
            ])->with('success', 'Data observasi berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi' . $e->getMessage());
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

        return view('unit-pelayanan.rawat-inap.pelayanan.observasi.edit', [
            'dataMedis' => $dataMedis,
            'observasi' => $observasi,
            'perawat' => $perawat,
            'existingDetails' => $existingDetails,
        ]);
    }

    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'berat_badan' => 'required|numeric',
            'sensorium' => 'required|string',
            'alat_invasive' => 'nullable|string',
            'ngt' => 'nullable|string',
            'catheter' => 'nullable|string',
            'diet' => 'nullable|string',
            'alergi' => 'nullable|string',
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

            // Check if force_new is set to create a new observation
            if ($request->force_new) {
                // Create a new observation instead of updating
                $observasiData = [
                    'kd_pasien' => $kd_pasien,
                    'kd_unit' => $kd_unit,
                    'urut_masuk' => $urut_masuk,
                    'tgl_masuk' => $tgl_masuk,
                    'tanggal' => Carbon::parse($request->tanggal),
                    'berat_badan' => $request->berat_badan,
                    'sensorium' => $request->sensorium,
                    'alat_invasive' => $request->alat_invasive,
                    'ngt' => $request->ngt,
                    'catheter' => $request->catheter,
                    'diet' => $request->diet,
                    'alergi' => $request->alergi,
                    'kd_perawat' => $request->kd_perawat,
                    'user_create' => Auth::user()->id,
                ];

                $observasi = RmeObservasi::create($observasiData);
            } else {
                // Update the existing observation
                $observasi = RmeObservasi::where('id', $id)
                    ->where('kd_pasien', $kd_pasien)
                    ->where('kd_unit', $kd_unit)
                    ->where('urut_masuk', $urut_masuk)
                    ->firstOrFail();

                $observasiData = [
                    'kd_pasien' => $kd_pasien,
                    'kd_unit' => $kd_unit,
                    'urut_masuk' => $urut_masuk,
                    'tgl_masuk' => $tgl_masuk,
                    'tanggal' => Carbon::parse($request->tanggal),
                    'berat_badan' => $request->berat_badan,
                    'sensorium' => $request->sensorium,
                    'alat_invasive' => $request->alat_invasive,
                    'ngt' => $request->ngt,
                    'catheter' => $request->catheter,
                    'diet' => $request->diet,
                    'alergi' => $request->alergi,
                    'user_edit' => Auth::user()->id,
                ];

                $observasi->update($observasiData);
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
                } else {
                    // If no data is provided for this time slot, delete the existing detail (if any)
                    RmeObservasiDtl::where('observasi_id', $observasi->id)
                        ->where('waktu', $waktu)
                        ->delete();
                }
            }

            DB::commit();

            return redirect()->route('rawat-inap.observasi.index', [
                $kd_unit,
                $kd_pasien,
                $tgl_masuk,
                $urut_masuk
            ])->with('success', 'Data observasi berhasil diperbarui.');
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
