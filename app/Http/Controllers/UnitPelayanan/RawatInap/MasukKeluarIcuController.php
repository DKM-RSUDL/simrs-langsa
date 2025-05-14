<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\RmeKriteriaKeluarIcu;
use App\Models\RmeKriteriaMasukIcu;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasukKeluarIcuController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
    }

    public function index($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
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

        // get tab
        $tabContent = $request->query('tab');

        if ($tabContent == 'keluar') {
            return $this->keluarTabs($kd_unit, $dataMedis);
        } else {
            return $this->masukTabs($kd_unit, $dataMedis);
        }
    }


    public function masukTabs($kd_unit, $dataMedis)
    {
        // Get data kriteria masuk jika ada
        $kriteriaMasuk = RmeKriteriaMasukIcu::with(['creator'])->where('kd_pasien', $dataMedis->kd_pasien)
            ->where('kd_unit', $dataMedis->kd_unit)
            ->where('tgl_masuk', $dataMedis->tgl_masuk)
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->first();


        return view('unit-pelayanan.rawat-inap.pelayanan.kriteria-masuk-keluar.icu.masuk.index', [
            'dataMedis' => $dataMedis,
            'kriteriaMasuk' => $kriteriaMasuk,
        ]);
    }

    public function keluarTabs($kd_unit, $dataMedis)
    {
        // Get data kriteria keluar jika ada
        $kriteriaKeluar = RmeKriteriaKeluarIcu::with(['creator'])->where('kd_pasien', $dataMedis->kd_pasien)
            ->where('kd_unit', $dataMedis->kd_unit)
            ->where('tgl_masuk', $dataMedis->tgl_masuk)
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->first();

        return view('unit-pelayanan.rawat-inap.pelayanan.kriteria-masuk-keluar.icu.keluar.index', [
            'dataMedis' => $dataMedis,
            'kriteriaKeluar' => $kriteriaKeluar,
        ]);
    }


    //UNTUK CRUD MASUK
    public function createMasuk($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
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

        return view('unit-pelayanan.rawat-inap.pelayanan.kriteria-masuk-keluar.icu.masuk.create', [
            'dataMedis' => $dataMedis,
            'kd_unit' => $kd_unit,
            'kd_pasien' => $kd_pasien,
            'tgl_masuk' => $tgl_masuk,
            'urut_masuk' => $urut_masuk,
        ]);
    }

    public function storeMasuk($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        try {
            DB::beginTransaction();

            // Konversi array prioritas menjadi string (jika ada)
            $prioritas1 = $request->prioritas_1 ? implode(',', $request->prioritas_1) : null;
            $prioritas2 = $request->prioritas_2 ? implode(',', $request->prioritas_2) : null;
            $prioritas3 = $request->prioritas_3 ? implode(',', $request->prioritas_3) : null;
            $prioritas4 = $request->prioritas_4 ? implode(',', $request->prioritas_4) : null;

            // Gabungkan tanggal dan jam
            $datetime = $request->tanggal . ' ' . $request->jam;

            // Simpan data ke model RmeKriteriaMasukIcu
            $kriteriaMasuk = RmeKriteriaMasukIcu::create([
                'kd_pasien' => $kd_pasien,
                'kd_unit' => $kd_unit,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
                'tanggal' => $request->tanggal,
                'jam' => $request->jam,
                'waktu_masuk' => $datetime,
                'gcs_mata' => $request->gcs_mata,
                'gcs_verbal' => $request->gcs_verbal,
                'gcs_motorik' => $request->gcs_motorik,
                'gcs_total' => $request->gcs_total,
                'td_sistole' => $request->td_sistole,
                'td_diastole' => $request->td_diastole,
                'nadi' => $request->nadi,
                'rr' => $request->rr,
                'suhu' => $request->suhu,
                'prioritas_1' => $prioritas1,
                'prioritas_2' => $prioritas2,
                'prioritas_3' => $prioritas3,
                'prioritas_4' => $prioritas4,
                'diagnosa_kriteria' => $request->diagnosa_kriteria,
                'user_create' => auth()->user()->id,
            ]);

            DB::commit();

            // Redirect dengan pesan sukses
            return redirect()
                ->route('rawat-inap.kriteria-masuk-keluar.icu.masuk.index', [
                    'kd_unit' => $kd_unit,
                    'kd_pasien' => $kd_pasien,
                    'tgl_masuk' => $tgl_masuk,
                    'urut_masuk' => $urut_masuk,
                ])
                ->with('success', 'Data kriteria masuk ICU berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollback();

            // Redirect kembali dengan pesan error
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    public function editMasuk($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
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

        // Get data kriteria masuk yang akan diedit
        $kriteriaMasuk = RmeKriteriaMasukIcu::findOrFail($id);

        // Convert string prioritas back to array for checkbox
        $kriteriaMasuk->prioritas_1_array = $kriteriaMasuk->prioritas_1 ? explode(',', $kriteriaMasuk->prioritas_1) : [];
        $kriteriaMasuk->prioritas_2_array = $kriteriaMasuk->prioritas_2 ? explode(',', $kriteriaMasuk->prioritas_2) : [];
        $kriteriaMasuk->prioritas_3_array = $kriteriaMasuk->prioritas_3 ? explode(',', $kriteriaMasuk->prioritas_3) : [];
        $kriteriaMasuk->prioritas_4_array = $kriteriaMasuk->prioritas_4 ? explode(',', $kriteriaMasuk->prioritas_4) : [];

        return view('unit-pelayanan.rawat-inap.pelayanan.kriteria-masuk-keluar.icu.masuk.edit', [
            'dataMedis' => $dataMedis,
            'kriteriaMasuk' => $kriteriaMasuk,
            'kd_unit' => $kd_unit,
            'kd_pasien' => $kd_pasien,
            'tgl_masuk' => $tgl_masuk,
            'urut_masuk' => $urut_masuk,
        ]);
    }

    public function updateMasuk($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id, Request $request)
    {
        try {
            DB::beginTransaction();

            // Find existing record
            $kriteriaMasuk = RmeKriteriaMasukIcu::findOrFail($id);

            // Konversi array prioritas menjadi string (jika ada)
            $prioritas1 = $request->prioritas_1 ? implode(',', $request->prioritas_1) : null;
            $prioritas2 = $request->prioritas_2 ? implode(',', $request->prioritas_2) : null;
            $prioritas3 = $request->prioritas_3 ? implode(',', $request->prioritas_3) : null;
            $prioritas4 = $request->prioritas_4 ? implode(',', $request->prioritas_4) : null;

            // Gabungkan tanggal dan jam
            $datetime = $request->tanggal . ' ' . $request->jam;

            // Update data
            $kriteriaMasuk->update([
                'tanggal' => $request->tanggal,
                'jam' => $request->jam,
                'waktu_masuk' => $datetime,
                'gcs_mata' => $request->gcs_mata,
                'gcs_verbal' => $request->gcs_verbal,
                'gcs_motorik' => $request->gcs_motorik,
                'gcs_total' => $request->gcs_total,
                'td_sistole' => $request->td_sistole,
                'td_diastole' => $request->td_diastole,
                'nadi' => $request->nadi,
                'rr' => $request->rr,
                'suhu' => $request->suhu,
                'prioritas_1' => $prioritas1,
                'prioritas_2' => $prioritas2,
                'prioritas_3' => $prioritas3,
                'prioritas_4' => $prioritas4,
                'diagnosa_kriteria' => $request->diagnosa_kriteria,
                'user_update' => auth()->user()->id,
            ]);

            DB::commit();

            // Redirect dengan pesan sukses
            return redirect()
                ->route('rawat-inap.kriteria-masuk-keluar.icu.masuk.index', [
                    'kd_unit' => $kd_unit,
                    'kd_pasien' => $kd_pasien,
                    'tgl_masuk' => $tgl_masuk,
                    'urut_masuk' => $urut_masuk,
                ])
                ->with('success', 'Data kriteria masuk ICU berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollback();

            // Redirect kembali dengan pesan error
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat mengupdate data: ' . $e->getMessage());
        }
    }

    public function destroyMasuk($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            DB::beginTransaction();

            // Find and delete record
            $kriteriaMasuk = RmeKriteriaMasukIcu::findOrFail($id);
            $kriteriaMasuk->delete();

            DB::commit();

            // Redirect dengan pesan sukses
            return redirect()
                ->route('rawat-inap.kriteria-masuk-keluar.icu.masuk.index', [
                    'kd_unit' => $kd_unit,
                    'kd_pasien' => $kd_pasien,
                    'tgl_masuk' => $tgl_masuk,
                    'urut_masuk' => $urut_masuk,
                ])
                ->with('success', 'Data kriteria masuk ICU berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();

            // Redirect kembali dengan pesan error
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }

    public function printMasuk($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        // Fetch medical data
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

        // Fetch ICU entry criteria data
        $kriteriaMasuk = RmeKriteriaMasukIcu::findOrFail($id);

        // Convert priority strings to arrays for display
        $kriteriaMasuk->prioritas_1_array = $kriteriaMasuk->prioritas_1 ? explode(',', $kriteriaMasuk->prioritas_1) : [];
        $kriteriaMasuk->prioritas_2_array = $kriteriaMasuk->prioritas_2 ? explode(',', $kriteriaMasuk->prioritas_2) : [];
        $kriteriaMasuk->prioritas_3_array = $kriteriaMasuk->prioritas_3 ? explode(',', $kriteriaMasuk->prioritas_3) : [];
        $kriteriaMasuk->prioritas_4_array = $kriteriaMasuk->prioritas_4 ? explode(',', $kriteriaMasuk->prioritas_4) : [];

        // Prepare data for the PDF view
        $data = [
            'dataMedis' => $dataMedis,
            'kriteriaMasuk' => $kriteriaMasuk,
        ];

        // Generate PDF
        $pdf = Pdf::loadView('unit-pelayanan.rawat-inap.pelayanan.kriteria-masuk-keluar.icu.masuk.print', $data);
        $pdf->setPaper('A4', 'portrait');

        // Stream the PDF
        return $pdf->stream('Kriteria_Masuk_ICU_' . $kd_pasien . '.pdf');
    }


    //UNTUK CURD KELUAR
    public function createKeluar($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
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

        return view('unit-pelayanan.rawat-inap.pelayanan.kriteria-masuk-keluar.icu.keluar.create', [
            'dataMedis' => $dataMedis,
            'kd_unit' => $kd_unit,
            'kd_pasien' => $kd_pasien,
            'tgl_masuk' => $tgl_masuk,
            'urut_masuk' => $urut_masuk,
        ]);
    }

    public function storeKeluar($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        try {
            DB::beginTransaction();

            // Cek apakah sudah ada data kriteria keluar untuk pasien ini
            $existingKriteria = RmeKriteriaKeluarIcu::where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->first();

            if ($existingKriteria) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Data kriteria keluar ICU sudah ada untuk pasien ini');
            }

            // Konversi array prioritas menjadi string (jika ada)
            $prioritas1 = $request->prioritas_1 ? implode(',', $request->prioritas_1) : null;
            $prioritas2 = $request->prioritas_2 ? implode(',', $request->prioritas_2) : null;
            $prioritas3 = $request->prioritas_3 ? implode(',', $request->prioritas_3) : null;

            // Gabungkan tanggal dan jam
            $waktukeluar = $request->tanggal . ' ' . $request->jam;

            // Simpan data ke model RmeKriteriaKeluarIcu
            $kriteriaKeluar = RmeKriteriaKeluarIcu::create([
                'kd_pasien' => $kd_pasien,
                'kd_unit' => $kd_unit,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
                'tanggal' => $request->tanggal,
                'jam' => $request->jam,
                'waktu_keluar' => $waktukeluar,
                'gcs_mata' => $request->gcs_mata,
                'gcs_verbal' => $request->gcs_verbal,
                'gcs_motorik' => $request->gcs_motorik,
                'gcs_total' => $request->gcs_total,
                'td_sistole' => $request->td_sistole,
                'td_diastole' => $request->td_diastole,
                'nadi' => $request->nadi,
                'rr' => $request->rr,
                'suhu' => $request->suhu,
                'prioritas_1' => $prioritas1,
                'prioritas_2' => $prioritas2,
                'prioritas_3' => $prioritas3,
                'diagnosa_kriteria' => $request->diagnosa_kriteria,
                'user_create' => auth()->user()->id,
            ]);

            DB::commit();

            // Redirect dengan pesan sukses
            return redirect()
                ->route('rawat-inap.kriteria-masuk-keluar.icu.keluar.index', [
                    'kd_unit' => $kd_unit,
                    'kd_pasien' => $kd_pasien,
                    'tgl_masuk' => $tgl_masuk,
                    'urut_masuk' => $urut_masuk,
                    'tab' => 'keluar'
                ])
                ->with('success', 'Data kriteria keluar ICU berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollback();

            // Redirect kembali dengan pesan error
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    public function editKeluar($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
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

        // Get data kriteria keluar yang akan diedit
        $kriteriaKeluar = RmeKriteriaKeluarIcu::findOrFail($id);

        // Convert string prioritas back to array for checkbox
        $kriteriaKeluar->prioritas_1_array = $kriteriaKeluar->prioritas_1 ? explode(',', $kriteriaKeluar->prioritas_1) : [];
        $kriteriaKeluar->prioritas_2_array = $kriteriaKeluar->prioritas_2 ? explode(',', $kriteriaKeluar->prioritas_2) : [];
        $kriteriaKeluar->prioritas_3_array = $kriteriaKeluar->prioritas_3 ? explode(',', $kriteriaKeluar->prioritas_3) : [];

        return view('unit-pelayanan.rawat-inap.pelayanan.kriteria-masuk-keluar.icu.keluar.edit', [
            'dataMedis' => $dataMedis,
            'kriteriaKeluar' => $kriteriaKeluar,
            'kd_unit' => $kd_unit,
            'kd_pasien' => $kd_pasien,
            'tgl_masuk' => $tgl_masuk,
            'urut_masuk' => $urut_masuk,
        ]);
    }

    public function updateKeluar($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id, Request $request)
    {
        try {
            DB::beginTransaction();

            // Find existing record
            $kriteriaKeluar = RmeKriteriaKeluarIcu::findOrFail($id);

            // Konversi array prioritas menjadi string (jika ada)
            $prioritas1 = $request->prioritas_1 ? implode(',', $request->prioritas_1) : null;
            $prioritas2 = $request->prioritas_2 ? implode(',', $request->prioritas_2) : null;
            $prioritas3 = $request->prioritas_3 ? implode(',', $request->prioritas_3) : null;

            // Gabungkan tanggal dan jam
            $waktukeluar = $request->tanggal . ' ' . $request->jam;

            // Update data
            $kriteriaKeluar->update([
                'tanggal' => $request->tanggal,
                'jam' => $request->jam,
                'waktu_keluar' => $waktukeluar,
                'gcs_mata' => $request->gcs_mata,
                'gcs_verbal' => $request->gcs_verbal,
                'gcs_motorik' => $request->gcs_motorik,
                'gcs_total' => $request->gcs_total,
                'td_sistole' => $request->td_sistole,
                'td_diastole' => $request->td_diastole,
                'nadi' => $request->nadi,
                'rr' => $request->rr,
                'suhu' => $request->suhu,
                'prioritas_1' => $prioritas1,
                'prioritas_2' => $prioritas2,
                'prioritas_3' => $prioritas3,
                'diagnosa_kriteria' => $request->diagnosa_kriteria,
                'user_update' => auth()->user()->id,
            ]);

            DB::commit();

            // Redirect dengan pesan sukses
            return redirect()
                ->route('rawat-inap.kriteria-masuk-keluar.icu.keluar.index', [
                    'kd_unit' => $kd_unit,
                    'kd_pasien' => $kd_pasien,
                    'tgl_masuk' => $tgl_masuk,
                    'urut_masuk' => $urut_masuk,
                    'tab' => 'keluar'
                ])
                ->with('success', 'Data kriteria keluar ICU berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollback();

            // Redirect kembali dengan pesan error
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat mengupdate data: ' . $e->getMessage());
        }
    }

    public function destroyKeluar($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            DB::beginTransaction();

            // Find and delete record
            $kriteriaKeluar = RmeKriteriaKeluarIcu::findOrFail($id);
            $kriteriaKeluar->delete();

            DB::commit();

            // Redirect dengan pesan sukses
            return redirect()
                ->route('rawat-inap.kriteria-masuk-keluar.icu.keluar.index', [
                    'kd_unit' => $kd_unit,
                    'kd_pasien' => $kd_pasien,
                    'tgl_masuk' => $tgl_masuk,
                    'urut_masuk' => $urut_masuk,
                    'tab' => 'keluar'
                ])
                ->with('success', 'Data kriteria keluar ICU berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();

            // Redirect kembali dengan pesan error
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }

    public function printKeluar($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        // Fetch medical data
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

        // Fetch ICU exit criteria data
        $kriteriaKeluar = RmeKriteriaKeluarIcu::findOrFail($id);

        // Convert priority strings to arrays for display
        $kriteriaKeluar->prioritas_1_array = $kriteriaKeluar->prioritas_1 ? explode(',', $kriteriaKeluar->prioritas_1) : [];
        $kriteriaKeluar->prioritas_2_array = $kriteriaKeluar->prioritas_2 ? explode(',', $kriteriaKeluar->prioritas_2) : [];
        $kriteriaKeluar->prioritas_3_array = $kriteriaKeluar->prioritas_3 ? explode(',', $kriteriaKeluar->prioritas_3) : [];

        // Prepare data for the PDF view
        $data = [
            'dataMedis' => $dataMedis,
            'kriteriaKeluar' => $kriteriaKeluar,
        ];

        // Generate PDF
        $pdf = Pdf::loadView('unit-pelayanan.rawat-inap.pelayanan.kriteria-masuk-keluar.icu.keluar.print', $data);
        $pdf->setPaper('A4', 'portrait');

        // Stream the PDF
        return $pdf->stream('Kriteria_Keluar_ICU_' . $kd_pasien . '.pdf');
    }

}
