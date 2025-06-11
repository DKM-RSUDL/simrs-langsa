<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\RmeKriteriaKeluarPicu;
use App\Models\RmeKriteriaMasukPicu;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MasukKeluarPicuController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
    }

    public function index(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
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


        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        // fungsi tab
        $tabs = $request->query('tab');

        if ($tabs == 'monitoring') {
            return $this->monitoringTab($dataMedis, $request);
        } else {
            return $this->picuTab($dataMedis, $request);
        }
    }

    private function picuTab($dataMedis, $request)
    {
        $dokter = Dokter::where('status', 1)
            ->select('kd_dokter', 'nama')
            ->get();

        // Ambil data PICU untuk kunjungan ini
        // Change .get() to .first()
        $dataPICU = RmeKriteriaMasukPicu::with(['dokter', 'user'])
            ->byKunjungan($dataMedis->kd_pasien, $dataMedis->kd_unit, $dataMedis->tgl_masuk, $dataMedis->urut_masuk)
            ->first(); // Changed from get()

        // Ambil data kriteria keluar PICU
        // Change .get() to .first()
        $dataKeluarPICU = RmeKriteriaKeluarPicu::with(['dokter', 'user'])
            ->byKunjungan($dataMedis->kd_pasien, $dataMedis->kd_unit, $dataMedis->tgl_masuk, $dataMedis->urut_masuk)
            ->first(); // Changed from get()

        return view('unit-pelayanan.rawat-inap.pelayanan.kriteria-masuk-keluar.picu.index', compact(
            'dataMedis',
            'dokter',
            'dataPICU',
            'dataKeluarPICU'
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
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', $kd_unit)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        $dokter = Dokter::where('status', 1)
            ->select('kd_dokter', 'nama')
            ->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.kriteria-masuk-keluar.picu.create', [
            'dataMedis' => $dataMedis,
            'dokter' => $dokter,
            'kd_unit' => $kd_unit,
            'kd_pasien' => $kd_pasien,
            'tgl_masuk' => $tgl_masuk,
            'urut_masuk' => $urut_masuk,
        ]);
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        // Validasi input
        $request->validate([
            'tanggal' => 'required|date',
            'jam' => 'required',
            'kd_dokter' => 'required',
            'check_list' => 'sometimes|array',
            'check_list_keluar' => 'sometimes|array',
            'keterangan' => 'sometimes|array',
            'keterangan_keluar' => 'sometimes|array',
            'diagnosa_kriteria' => 'nullable|string',
        ]);

        try {
            // Cek apakah sudah ada transaksi aktif
            if (DB::transactionLevel() == 0) {
                DB::beginTransaction();
                $isNewTransaction = true;
            } else {
                $isNewTransaction = false;
            }

            // Data dasar yang sama untuk kedua tabel
            $baseData = [
                'kd_pasien' => $kd_pasien,
                'kd_unit' => $kd_unit,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
                'tanggal' => $request->tanggal,
                'jam' => $request->jam,
                'kd_dokter' => $request->kd_dokter,
                'user_create' => auth()->id(),
            ];

            // Simpan data kriteria masuk PICU
            $dataMasuk = $baseData;

            // Inisialisasi semua kolom kriteria ke false
            $kriteriaColumns = [
                'kriteria_1_main',
                'kriteria_1_sianosis',
                'kriteria_1_rr',
                'kriteria_1_retraksi',
                'kriteria_1_merintih',
                'kriteria_1_nafas_cuping',
                'kriteria_2_main',
                'kriteria_2_nadi',
                'kriteria_2_hr',
                'kriteria_2_tekanan_nadi',
                'kriteria_2_rr',
                'kriteria_2_akral',
                'kriteria_2_tekanan_darah',
                'kriteria_3',
                'kriteria_4',
                'kriteria_5',
                'kriteria_6_main',
                'kriteria_6_takikardia',
                'kriteria_6_mata',
                'kriteria_6_letargi',
                'kriteria_6_anuria',
                'kriteria_6_malas_minum',
                'kriteria_6_penurunan_kesadaran',
                'kriteria_7',
                'kriteria_8',
                'kriteria_9',
                'kriteria_9_main',
                'kriteria_9_traumatologi',
            ];

            foreach ($kriteriaColumns as $column) {
                $dataMasuk[$column] = false;
            }

            // Process kriteria masuk checkboxes
            if ($request->has('check_list')) {
                foreach ($request->check_list as $criteriaValue) {
                    $fieldName = 'kriteria_' . $criteriaValue;
                    if (in_array($fieldName, $kriteriaColumns)) {
                        $dataMasuk[$fieldName] = true;
                    }
                }
            }

            // Process keterangan for kriteria masuk
            if ($request->has('keterangan')) {
                foreach ($request->keterangan as $key => $value) {
                    $fieldName = 'keterangan_' . $key;
                    $dataMasuk[$fieldName] = is_string($value) ? $value : null;
                }
            }

            // Add diagnosa kriteria
            $dataMasuk['diagnosa_kriteria'] = $request->diagnosa_kriteria;

            // Save or update kriteria masuk
            RmeKriteriaMasukPicu::updateOrCreate(
                [
                    'kd_pasien' => $kd_pasien,
                    'kd_unit' => $kd_unit,
                    'tgl_masuk' => $tgl_masuk,
                    'urut_masuk' => $urut_masuk,
                ],
                $dataMasuk
            );

            // Simpan data kriteria keluar PICU
            $dataKeluar = $baseData;

            // Inisialisasi kolom kriteria keluar
            $kriteriaKeluarColumns = [
                'kriteria_keluar_1',
                'kriteria_keluar_2',
                'kriteria_keluar_3',
                'kriteria_keluar_4',
                'kriteria_keluar_5',
                'kriteria_keluar_6',
                'kriteria_keluar_7',
            ];

            foreach ($kriteriaKeluarColumns as $column) {
                $dataKeluar[$column] = false;
            }

            // Process kriteria keluar checkboxes
            if ($request->has('check_list_keluar')) {
                foreach ($request->check_list_keluar as $criteriaValue) {
                    $fieldName = 'kriteria_keluar_' . $criteriaValue;
                    if (in_array($fieldName, $kriteriaKeluarColumns)) {
                        $dataKeluar[$fieldName] = true;
                    }
                }
            }

            // Process keterangan for kriteria keluar
            if ($request->has('keterangan_keluar')) {
                foreach ($request->keterangan_keluar as $key => $value) {
                    $fieldName = 'keterangan_keluar_' . $key;
                    $dataKeluar[$fieldName] = is_string($value) ? $value : null;
                }
            }

            // Save or update kriteria keluar
            RmeKriteriaKeluarPicu::updateOrCreate(
                [
                    'kd_pasien' => $kd_pasien,
                    'kd_unit' => $kd_unit,
                    'tgl_masuk' => $tgl_masuk,
                    'urut_masuk' => $urut_masuk,
                ],
                $dataKeluar
            );

            // Commit transaksi hanya jika transaksi baru dimulai
            if ($isNewTransaction) {
                DB::commit();
            }

            return redirect()
                ->route('rawat-inap.kriteria-masuk-keluar.picu.index', [
                    'kd_unit' => $kd_unit,
                    'kd_pasien' => $kd_pasien,
                    'tgl_masuk' => $tgl_masuk,
                    'urut_masuk' => $urut_masuk,
                ])
                ->with('success', 'Data kriteria masuk/keluar PICU berhasil disimpan.');
        } catch (\Exception $e) {
            // Rollback hanya jika transaksi baru dimulai
            if (isset($isNewTransaction) && $isNewTransaction) {
                DB::rollBack();
            }

            Log::error('Transaction failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }


    public function show($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
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

        // Get data PICU
        $dataPICU = RmeKriteriaMasukPicu::with(['dokter', 'user'])
            ->byKunjungan($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk)
            ->first();

        $dataKeluarPICU = RmeKriteriaKeluarPicu::with(['dokter', 'user'])
            ->byKunjungan($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk)
            ->first();

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        return view('unit-pelayanan.rawat-inap.pelayanan.kriteria-masuk-keluar.picu.show', [
            'dataMedis' => $dataMedis,
            'dataPICU' => $dataPICU,
            'dataKeluarPICU' => $dataKeluarPICU,
            'kd_unit' => $kd_unit,
            'kd_pasien' => $kd_pasien,
            'tgl_masuk' => $tgl_masuk,
            'urut_masuk' => $urut_masuk,
        ]);
    }

    public function edit($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
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

        // Get data PICU for edit
        $dataPICU = RmeKriteriaMasukPicu::byKunjungan($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk)->first();
        $dataKeluarPICU = RmeKriteriaKeluarPicu::byKunjungan($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk)->first();

        $dokter = Dokter::where('status', 1)
            ->select('kd_dokter', 'nama')
            ->get();

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        return view('unit-pelayanan.rawat-inap.pelayanan.kriteria-masuk-keluar.picu.edit', [
            'dataMedis' => $dataMedis,
            'dataPICU' => $dataPICU,
            'dataKeluarPICU' => $dataKeluarPICU,
            'dokter' => $dokter,
            'kd_unit' => $kd_unit,
            'kd_pasien' => $kd_pasien,
            'tgl_masuk' => $tgl_masuk,
            'urut_masuk' => $urut_masuk,
        ]);
    }

    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        // Validasi input (sama seperti store)
        $request->validate([
            'tanggal' => 'required|date',
            'jam' => 'required',
            'kd_dokter' => 'required',
            'check_list' => 'sometimes|array',
            'check_list_keluar' => 'sometimes|array',
            'keterangan' => 'sometimes|array',
            'keterangan_keluar' => 'sometimes|array',
            'diagnosa_kriteria' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Data dasar yang sama untuk kedua tabel
            $baseData = [
                'tanggal' => $request->tanggal,
                'jam' => $request->jam,
                'kd_dokter' => $request->kd_dokter,
                'user_update' => auth()->id(), // Menggunakan user_update untuk operasi update
            ];

            // === Update kriteria masuk PICU ===
            $dataPICU = RmeKriteriaMasukPicu::byKunjungan($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk)->first();

            if ($dataPICU) {
                $updateDataMasuk = $baseData;

                // Daftar kolom kriteria masuk yang lengkap (sesuai dengan 'store')
                $kriteriaMasukFields = [
                    'kriteria_1_main',
                    'kriteria_1_sianosis',
                    'kriteria_1_rr',
                    'kriteria_1_retraksi',
                    'kriteria_1_merintih',
                    'kriteria_1_nafas_cuping',
                    'kriteria_2_main',
                    'kriteria_2_nadi',
                    'kriteria_2_hr',
                    'kriteria_2_tekanan_nadi',
                    'kriteria_2_rr',
                    'kriteria_2_akral',
                    'kriteria_2_tekanan_darah',
                    'kriteria_3',
                    'kriteria_4',
                    'kriteria_5',
                    'kriteria_6_main',
                    'kriteria_6_takikardia',
                    'kriteria_6_mata',
                    'kriteria_6_letargi',
                    'kriteria_6_anuria',
                    'kriteria_6_malas_minum',
                    'kriteria_6_penurunan_kesadaran',
                    'kriteria_7',
                    'kriteria_8',
                    'kriteria_9',
                    'kriteria_9_main',
                    'kriteria_9_traumatologi',
                ];

                // Reset semua kriteria boolean ke false dan keterangan ke null
                foreach ($kriteriaMasukFields as $field) {
                    $updateDataMasuk[$field] = false;
                    // Asumsi nama kolom keterangan adalah 'keterangan_' + suffix dari field kriteria
                    // Contoh: kriteria_1_main -> keterangan_1_main
                    $keteranganKey = substr($field, strlen('kriteria_'));
                    $updateDataMasuk['keterangan_' . $keteranganKey] = null;
                }
                // Ada beberapa field kriteria utama (seperti kriteria_3, kriteria_4, dst) yang tidak memiliki sub-kriteria
                // Pastikan penamaan kolom 'keterangan' untuk ini juga konsisten.
                // Jika ada kriteria tanpa sub (misal 'kriteria_3'), maka keterangan key akan '3'.
                // Ini akan mereset 'keterangan_3', 'keterangan_4', dst. yang seharusnya sudah tercakup.

                // Process checked kriteria masuk
                if ($request->has('check_list')) {
                    foreach ($request->check_list as $criteriaValue) {
                        $fieldName = 'kriteria_' . $criteriaValue;
                        if (in_array($fieldName, $kriteriaMasukFields)) {
                            $updateDataMasuk[$fieldName] = true;
                        }
                    }
                }

                // Process keterangan for kriteria masuk
                if ($request->has('keterangan')) {
                    foreach ($request->keterangan as $key => $value) {
                        // Pastikan $key ada dalam daftar suffix kriteria yang valid jika perlu
                        // atau asumsikan nama kolom keterangan sudah benar: 'keterangan_' . $key
                        $fieldName = 'keterangan_' . $key;
                        // Hanya update jika field keterangan_xxx ada dalam model / $updateDataMasuk yang sudah diinisialisasi
                        // Ini untuk menghindari penambahan field sembarangan jika $key tidak sesuai.
                        // Untuk lebih aman, bisa divalidasi terhadap daftar field keterangan yang valid.
                        $updateDataMasuk[$fieldName] = is_string($value) ? $value : null;
                    }
                }

                // Add diagnosa kriteria
                $updateDataMasuk['diagnosa_kriteria'] = $request->diagnosa_kriteria;

                $dataPICU->update($updateDataMasuk);
            }
            // Opsional: jika $dataPICU tidak ditemukan, Anda bisa memilih untuk membuat baru atau melempar error.
            // Saat ini, jika tidak ditemukan, tidak ada operasi yang dilakukan untuk kriteria masuk.
            // Jika ingin perilaku 'updateOrCreate' seperti di store:
            // else if ($request->has('check_list') || $request->diagnosa_kriteria) {
            //     // Logika create mirip store di sini, pastikan menyertakan $kd_pasien, $kd_unit, dll.
            // }


            // === Update kriteria keluar PICU ===
            $dataKeluarPICU = RmeKriteriaKeluarPicu::byKunjungan($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk)->first();

            // Hanya proses jika ada data keluar yang sudah ada ATAU ada input untuk kriteria keluar
            if ($dataKeluarPICU || $request->has('check_list_keluar') || $request->has('keterangan_keluar')) {
                $updateDataKeluar = $baseData;

                $kriteriaKeluarFields = [
                    'kriteria_keluar_1',
                    'kriteria_keluar_2',
                    'kriteria_keluar_3',
                    'kriteria_keluar_4',
                    'kriteria_keluar_5',
                    'kriteria_keluar_6',
                    'kriteria_keluar_7'
                ];

                // Reset semua kriteria keluar boolean ke false dan keterangan ke null
                foreach ($kriteriaKeluarFields as $field) {
                    $updateDataKeluar[$field] = false;
                    // Asumsi nama kolom keterangan adalah 'keterangan_keluar_' + suffix dari field kriteria
                    // Contoh: kriteria_keluar_1 -> keterangan_keluar_1
                    $keteranganKey = substr($field, strlen('kriteria_keluar_'));
                    $updateDataKeluar['keterangan_keluar_' . $keteranganKey] = null;
                }

                // Process checked kriteria keluar
                if ($request->has('check_list_keluar')) {
                    foreach ($request->check_list_keluar as $criteriaValue) {
                        $fieldName = 'kriteria_keluar_' . $criteriaValue;
                        if (in_array($fieldName, $kriteriaKeluarFields)) {
                            $updateDataKeluar[$fieldName] = true;
                        }
                    }
                }

                // Process keterangan for kriteria keluar
                if ($request->has('keterangan_keluar')) {
                    foreach ($request->keterangan_keluar as $key => $value) {
                        $fieldName = 'keterangan_keluar_' . $key;
                        $updateDataKeluar[$fieldName] = is_string($value) ? $value : null;
                    }
                }

                if ($dataKeluarPICU) {
                    $dataKeluarPICU->update($updateDataKeluar);
                } else {
                    // Jika data keluar belum ada, buat baru (mirip perilaku store)
                    // Tambahkan field primary key dan user_create
                    $createDataKeluar = array_merge($updateDataKeluar, [
                        'kd_pasien' => $kd_pasien,
                        'kd_unit' => $kd_unit,
                        'tgl_masuk' => $tgl_masuk,
                        'urut_masuk' => $urut_masuk,
                        'user_create' => auth()->id(), // user_create saat membuat baru
                    ]);
                    // Hapus user_update jika ada karena ini operasi create
                    unset($createDataKeluar['user_update']);
                    RmeKriteriaKeluarPicu::create($createDataKeluar);
                }
            }

            DB::commit();

            return redirect()
                ->route('rawat-inap.kriteria-masuk-keluar.picu.index', [
                    'kd_unit' => $kd_unit,
                    'kd_pasien' => $kd_pasien,
                    'tgl_masuk' => $tgl_masuk,
                    'urut_masuk' => $urut_masuk,
                ])
                ->with('success', 'Data kriteria masuk/keluar PICU berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating kriteria PICU: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'input' => $request->all()
            ]);
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        try {
            DB::beginTransaction();

            // Delete kriteria masuk PICU
            RmeKriteriaMasukPicu::byKunjungan($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk)->delete();

            // Delete kriteria keluar PICU
            RmeKriteriaKeluarPicu::byKunjungan($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk)->delete();

            DB::commit();

            return redirect()
                ->route('rawat-inap.kriteria-masuk-keluar.picu.index', [
                    'kd_unit' => $kd_unit,
                    'kd_pasien' => $kd_pasien,
                    'tgl_masuk' => $tgl_masuk,
                    'urut_masuk' => $urut_masuk,
                ])
                ->with('success', 'Data kriteria masuk/keluar PICU berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }

    public function printPdf($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        // Fetch the necessary data, similar to the show method
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

        $dataPICU = RmeKriteriaMasukPicu::with(['dokter', 'user'])
            ->byKunjungan($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk)
            ->first();

        $dataKeluarPICU = RmeKriteriaKeluarPicu::with(['dokter', 'user'])
            ->byKunjungan($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk)
            ->first();

        // Pass data to a blade view which will be rendered as PDF
        $pdf = Pdf::loadView('unit-pelayanan.rawat-inap.pelayanan.kriteria-masuk-keluar.picu.print', compact(
            'dataMedis',
            'dataPICU',
            'dataKeluarPICU'
        ));

        // You can customize the PDF options (e.g., paper size, orientation)
        // $pdf->setPaper('A4', 'landscape');

        // Stream the PDF for preview
        $filename = 'Kriteria_Masuk_Keluar_PICU_' . $kd_pasien . '_' . $tgl_masuk . '.pdf';
        return $pdf->stream($filename); // Changed from download() to stream()
    }

}
