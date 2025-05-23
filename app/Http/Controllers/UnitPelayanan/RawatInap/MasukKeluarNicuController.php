<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\RmeKriteriaKeluarNicu;
use App\Models\RmeKriteriaMasukNicu;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MasukKeluarNicuController extends Controller
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

        // Fetch NICU entry and exit data
        $dataNicu = RmeKriteriaMasukNicu::with('dokter')
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->first();

        $dataKeluarNicu = RmeKriteriaKeluarNicu::with('dokter')
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->first();

        return view('unit-pelayanan.rawat-inap.pelayanan.kriteria-masuk-keluar.nicu.index', compact(
            'dataMedis',
            'dataNicu',
            'dataKeluarNicu'
        ));
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

        return view('unit-pelayanan.rawat-inap.pelayanan.kriteria-masuk-keluar.nicu.create', [
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

            // Simpan data kriteria masuk NICU
            $dataMasuk = $baseData;

            // Inisialisasi semua kolom kriteria ke false
            $kriteriaColumns = [
                'kriteria_1',
                'kriteria_2',
                'kriteria_3',
                'kriteria_4_main',
                'kriteria_4_bibir',
                'kriteria_4_atresia',
                'kriteria_4_acephali',
                'kriteria_4_polidactily',
                'kriteria_5_main',
                'kriteria_5_rr',
                'kriteria_5_takipnoe',
                'kriteria_5_apgar',
                'kriteria_5_retraksi',
                'kriteria_5_sianosis',
                'kriteria_5_merintih',
                'kriteria_6_main',
                'kriteria_6_leukocyte',
                'kriteria_6_rr',
                'kriteria_6_temp',
                'kriteria_6_hr',
                'kriteria_6_malas',
                'kriteria_7',
                'kriteria_8',
                'kriteria_9',
                'kriteria_10',
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

            // Save or update kriteria masuk
            RmeKriteriaMasukNicu::updateOrCreate(
                [
                    'kd_pasien' => $kd_pasien,
                    'kd_unit' => $kd_unit,
                    'tgl_masuk' => $tgl_masuk,
                    'urut_masuk' => $urut_masuk,
                ],
                $dataMasuk
            );

            // Simpan data kriteria keluar NICU
            $dataKeluar = $baseData;

            // Inisialisasi kolom kriteria keluar
            $kriteriaKeluarColumns = [
                'kriteria_keluar_1',
                'kriteria_keluar_2',
                'kriteria_keluar_3',
                'kriteria_keluar_4',
                'kriteria_keluar_5',
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
            RmeKriteriaKeluarNicu::updateOrCreate(
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
                ->route('rawat-inap.kriteria-masuk-keluar.nicu.index', [
                    'kd_unit' => $kd_unit,
                    'kd_pasien' => $kd_pasien,
                    'tgl_masuk' => $tgl_masuk,
                    'urut_masuk' => $urut_masuk,
                ])
                ->with('success', 'Data kriteria masuk/keluar NICU berhasil disimpan.');
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

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        // Fetch NICU entry and exit data
        $dataNicu = RmeKriteriaMasukNicu::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->first();

        $dataKeluarNicu = RmeKriteriaKeluarNicu::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->first();

        $dokter = Dokter::where('status', 1)
            ->select('kd_dokter', 'nama')
            ->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.kriteria-masuk-keluar.nicu.edit', [
            'dataMedis' => $dataMedis,
            'dataNicu' => $dataNicu,
            'dataKeluarNicu' => $dataKeluarNicu,
            'dokter' => $dokter,
            'kd_unit' => $kd_unit,
            'kd_pasien' => $kd_pasien,
            'tgl_masuk' => $tgl_masuk,
            'urut_masuk' => $urut_masuk,
        ]);
    }

    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
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

            // Update data kriteria masuk NICU
            $dataMasuk = $baseData;

            // Inisialisasi semua kolom kriteria ke false
            $kriteriaColumns = [
                'kriteria_1',
                'kriteria_2',
                'kriteria_3',
                'kriteria_4_main',
                'kriteria_4_bibir',
                'kriteria_4_atresia',
                'kriteria_4_acephali',
                'kriteria_4_polidactily',
                'kriteria_5_main',
                'kriteria_5_rr',
                'kriteria_5_takipnoe',
                'kriteria_5_apgar',
                'kriteria_5_retraksi',
                'kriteria_5_sianosis',
                'kriteria_5_merintih',
                'kriteria_6_main',
                'kriteria_6_leukocyte',
                'kriteria_6_rr',
                'kriteria_6_temp',
                'kriteria_6_hr',
                'kriteria_6_malas',
                'kriteria_7',
                'kriteria_8',
                'kriteria_9',
                'kriteria_10',
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

            // Update kriteria masuk
            RmeKriteriaMasukNicu::updateOrCreate(
                [
                    'kd_pasien' => $kd_pasien,
                    'kd_unit' => $kd_unit,
                    'tgl_masuk' => $tgl_masuk,
                    'urut_masuk' => $urut_masuk,
                ],
                $dataMasuk
            );

            // Update data kriteria keluar NICU
            $dataKeluar = $baseData;

            // Inisialisasi kolom kriteria keluar
            $kriteriaKeluarColumns = [
                'kriteria_keluar_1',
                'kriteria_keluar_2',
                'kriteria_keluar_3',
                'kriteria_keluar_4',
                'kriteria_keluar_5',
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

            // Update kriteria keluar
            RmeKriteriaKeluarNicu::updateOrCreate(
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
                ->route('rawat-inap.kriteria-masuk-keluar.nicu.index', [
                    'kd_unit' => $kd_unit,
                    'kd_pasien' => $kd_pasien,
                    'tgl_masuk' => $tgl_masuk,
                    'urut_masuk' => $urut_masuk,
                ])
                ->with('success', 'Data kriteria masuk/keluar NICU berhasil diperbarui.');
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
                ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
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

        $dataNicu = RmeKriteriaMasukNicu::with(['dokter', 'user'])
            ->byKunjungan($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk)
            ->first();

        $dataKeluarNicu = RmeKriteriaKeluarNicu::with(['dokter', 'user'])
            ->byKunjungan($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk)
            ->first();

        // Pass data to a blade view which will be rendered as PDF
        $pdf = Pdf::loadView('unit-pelayanan.rawat-inap.pelayanan.kriteria-masuk-keluar.nicu.print', compact(
            'dataMedis',
            'dataNicu',
            'dataKeluarNicu'
        ));

        // You can customize the PDF options (e.g., paper size, orientation)
        // $pdf->setPaper('A4', 'landscape');

        // Stream the PDF for preview
        $filename = 'Kriteria_Masuk_Keluar_NICU_' . $kd_pasien . '_' . $tgl_masuk . '.pdf';
        return $pdf->stream($filename); // Changed from download() to stream()
    }

}
