<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\RmeKriteriaKeluarPicu;
use App\Models\RmeKriteriaMasukPicu;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $dataPICU = RmeKriteriaMasukPicu::with(['dokter', 'user'])
            ->byKunjungan($dataMedis->kd_pasien, $dataMedis->kd_unit, $dataMedis->tgl_masuk, $dataMedis->urut_masuk)
            ->orderBy('tanggal', 'desc')
            ->get();

        // Ambil data kriteria keluar PICU
        $dataKeluarPICU = RmeKriteriaKeluarPicu::with(['dokter', 'user'])
            ->byKunjungan($dataMedis->kd_pasien, $dataMedis->kd_unit, $dataMedis->tgl_masuk, $dataMedis->urut_masuk)
            ->orderBy('tanggal', 'desc')
            ->get();

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
            DB::beginTransaction();

            // Data dasar yang sama untuk kedua tabel
            $baseData = [
                'kd_pasien' => $kd_pasien,
                'kd_unit' => $kd_unit,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
                'tanggal' => $request->tanggal,
                'jam' => $request->jam,
                'kd_dokter' => $request->kd_dokter,
                'user_id' => auth()->id(),
            ];

            // Simpan data kriteria masuk PICU
            $dataMasuk = $baseData;

            // Process kriteria masuk checkboxes
            if ($request->has('check_list')) {
                foreach ($request->check_list as $criteriaValue) {
                    $fieldName = 'kriteria_' . $criteriaValue;
                    $dataMasuk[$fieldName] = true;
                }
            }

            // Process keterangan for kriteria masuk
            if ($request->has('keterangan')) {
                foreach ($request->keterangan as $key => $value) {
                    $fieldName = 'keterangan_' . $key;
                    $dataMasuk[$fieldName] = $value;
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

            // Process kriteria keluar checkboxes
            if ($request->has('check_list_keluar')) {
                foreach ($request->check_list_keluar as $criteriaValue) {
                    $fieldName = 'kriteria_keluar_' . $criteriaValue;
                    $dataKeluar[$fieldName] = true;
                }
            }

            // Process keterangan for kriteria keluar
            if ($request->has('keterangan_keluar')) {
                foreach ($request->keterangan_keluar as $key => $value) {
                    $fieldName = 'keterangan_keluar_' . $key;
                    $dataKeluar[$fieldName] = $value;
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

            DB::commit();

            return redirect()
                ->route('rawat-inap.kriteria-masuk-keluar.picu.index', [
                    'kd_unit' => $kd_unit,
                    'kd_pasien' => $kd_pasien,
                    'tgl_masuk' => $tgl_masuk,
                    'urut_masuk' => $urut_masuk,
                ])
                ->with('success', 'Data kriteria masuk/keluar PICU berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();

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
            DB::beginTransaction();

            // Data dasar yang sama untuk kedua tabel
            $baseData = [
                'tanggal' => $request->tanggal,
                'jam' => $request->jam,
                'kd_dokter' => $request->kd_dokter,
                'user_id' => auth()->id(),
            ];

            // Update kriteria masuk PICU
            $dataPICU = RmeKriteriaMasukPicu::byKunjungan($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk)->first();

            if ($dataPICU) {
                // Reset all kriteria to false first
                $resetData = [];
                $kriteriaFields = [
                    'kriteria_1_main',
                    'kriteria_1_rr',
                    'kriteria_1_sianosis',
                    'kriteria_1_retraksi',
                    'kriteria_1_merintih',
                    'kriteria_1_nafas_cuping',
                    'kriteria_2_main',
                    'kriteria_2_nadi',
                    'kriteria_2_hr',
                    'kriteria_2_tekanan_nadi',
                    'kriteria_2_rr',
                    'kriteria_2_akral',
                    'kriteria_3',
                    'kriteria_4',
                    'kriteria_5',
                    'kriteria_6_main',
                    'kriteria_6_takikardia',
                    'kriteria_6_mata',
                    'kriteria_6_letargi',
                    'kriteria_6_anuria',
                    'kriteria_6_malas_minum',
                    'kriteria_7',
                    'kriteria_8',
                    'kriteria_9'
                ];

                foreach ($kriteriaFields as $field) {
                    $resetData[$field] = false;
                    $resetData['keterangan_' . substr($field, 9)] = null; // Remove 'kriteria_' prefix
                }

                $dataMasuk = array_merge($baseData, $resetData);

                // Process checked kriteria masuk
                if ($request->has('check_list')) {
                    foreach ($request->check_list as $criteriaValue) {
                        $fieldName = 'kriteria_' . $criteriaValue;
                        $dataMasuk[$fieldName] = true;
                    }
                }

                // Process keterangan for kriteria masuk
                if ($request->has('keterangan')) {
                    foreach ($request->keterangan as $key => $value) {
                        $fieldName = 'keterangan_' . $key;
                        $dataMasuk[$fieldName] = $value;
                    }
                }

                // Add diagnosa kriteria
                $dataMasuk['diagnosa_kriteria'] = $request->diagnosa_kriteria;

                $dataPICU->update($dataMasuk);
            }

            // Update kriteria keluar PICU
            $dataKeluarPICU = RmeKriteriaKeluarPicu::byKunjungan($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk)->first();

            if ($dataKeluarPICU || $request->has('check_list_keluar')) {
                // Reset all kriteria keluar to false first
                $resetDataKeluar = [];
                $kriteriaKeluarFields = [
                    'kriteria_keluar_1',
                    'kriteria_keluar_2',
                    'kriteria_keluar_3',
                    'kriteria_keluar_4',
                    'kriteria_keluar_5',
                    'kriteria_keluar_6',
                    'kriteria_keluar_7'
                ];

                foreach ($kriteriaKeluarFields as $field) {
                    $resetDataKeluar[$field] = false;
                    $resetDataKeluar['keterangan_' . $field] = null;
                }

                $dataKeluar = array_merge($baseData, $resetDataKeluar);

                // Process checked kriteria keluar
                if ($request->has('check_list_keluar')) {
                    foreach ($request->check_list_keluar as $criteriaValue) {
                        $fieldName = 'kriteria_keluar_' . $criteriaValue;
                        $dataKeluar[$fieldName] = true;
                    }
                }

                // Process keterangan for kriteria keluar
                if ($request->has('keterangan_keluar')) {
                    foreach ($request->keterangan_keluar as $key => $value) {
                        $fieldName = 'keterangan_keluar_' . $key;
                        $dataKeluar[$fieldName] = $value;
                    }
                }

                if ($dataKeluarPICU) {
                    $dataKeluarPICU->update($dataKeluar);
                } else {
                    $dataKeluar = array_merge($dataKeluar, [
                        'kd_pasien' => $kd_pasien,
                        'kd_unit' => $kd_unit,
                        'tgl_masuk' => $tgl_masuk,
                        'urut_masuk' => $urut_masuk,
                    ]);
                    RmeKriteriaKeluarPicu::create($dataKeluar);
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

}
