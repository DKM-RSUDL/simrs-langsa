<?php

namespace App\Http\Controllers\UnitPelayanan\RawatJalan;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\RmeMppA;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MppAController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-jalan');
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

        $mppDataList = RmeMppA::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->get();

        // Decode dpjp_tambahan JSON for each record
        foreach ($mppDataList as $mppData) {
            if ($mppData->dpjp_tambahan) {
                $dpjpTambahanArray = json_decode($mppData->dpjp_tambahan, true);
                if (is_array($dpjpTambahanArray)) {
                    $mppData->dpjp_tambahan_names = Dokter::whereIn('kd_dokter', $dpjpTambahanArray)->pluck('nama')->toArray();
                } else {
                    // Handle old format (single doctor)
                    $dokter = Dokter::where('kd_dokter', $mppData->dpjp_tambahan)->first();
                    $mppData->dpjp_tambahan_names = $dokter ? [$dokter->nama] : [];
                }
            } else {
                $mppData->dpjp_tambahan_names = [];
            }
        }

        return view('unit-pelayanan.rawat-jalan.pelayanan.mpp.form-a.index', compact(
            'dataMedis',
            'kd_unit',
            'kd_pasien',
            'tgl_masuk',
            'urut_masuk',
            'mppDataList'
        ));
    }

    public function create(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
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

        $dokter = Dokter::where('status', 1)
            ->select('kd_dokter', 'nama')
            ->get();

        return view('unit-pelayanan.rawat-jalan.pelayanan.mpp.form-a.create', compact(
            'dataMedis',
            'kd_unit',
            'kd_pasien',
            'tgl_masuk',
            'urut_masuk',
            'dokter'
        ));
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        // Process DPJP Tambahan array
        $dpjpTambahanArray = [];
        if ($request->has('dpjp_tambahan') && is_array($request->dpjp_tambahan)) {
            $dpjpTambahanArray = array_filter($request->dpjp_tambahan, function ($value) {
                return !empty($value);
            });
        }

        $data = [
            'kd_unit' => $kd_unit,
            'kd_pasien' => $kd_pasien,
            'tgl_masuk' => $tgl_masuk,
            'urut_masuk' => $urut_masuk,
            'dpjp_utama' => $request->dpjp_utama,
            'dpjp_tambahan' => !empty($dpjpTambahanArray) ? json_encode(array_values($dpjpTambahanArray)) : null,
            'screening_date' => $request->screening_date,
            'screening_time' => $request->screening_time,
            'assessment_date' => $request->assessment_date,
            'assessment_time' => $request->assessment_time,
            'identification_date' => $request->identification_date,
            'identification_time' => $request->identification_time,
            'planning_date' => $request->planning_date,
            'planning_time' => $request->planning_time,
            'lain_lain_text' => $request->lain_lain_text,
            'user_create' => auth()->user()->id,
        ];

        // Handle screening criteria
        $screeningCriteria = [
            'fungsi_kognitif',
            'risiko_tinggi',
            'potensi_komplain',
            'riwayat_kronis',
            'kasus_katastropik',    // NEW
            'kasus_terminal',       // NEW
            'status_fungsional',
            'peralatan_medis',
            'gangguan_mental',
            'krisis_keluarga',      // NEW
            'isu_sosial',           // NEW
            'sering_igd',
            'perkiraan_asuhan',
            'sistem_pembiayaan',
            'length_of_stay',
            'rencana_pemulangan',
            'lain_lain'
        ];
        foreach ($screeningCriteria as $criteria) {
            $data[$criteria] = in_array($criteria, (array)$request->screening_criteria) ? 1 : 0;
        }

        // Handle assessment criteria
        $assessmentCriteria = [
            'assessment_fisik',     // NEW (was fisik_fungsional)
            'assessment_fungsional', // NEW
            'assessment_kognitif',   // NEW
            'assessment_kemandirian', // NEW
            'riwayat_kesehatan',
            'perilaku_psiko',
            'kesehatan_mental',
            'dukungan_keluarga',
            'finansial_asuransi',
            'riwayat_obat',
            'trauma_kekerasan',
            'health_literacy',
            'aspek_legal',
            'harapan_hasil'
        ];
        foreach ($assessmentCriteria as $criteria) {
            $data[$criteria] = in_array($criteria, (array)$request->assessment_criteria) ? 1 : 0;
        }

        // Handle identification criteria
        $identificationCriteria = [
            'tingkat_asuhan',
            'over_utilization',     // NEW (was over_under_utilization)
            'under_utilization',    // NEW
            'ketidak_patuhan',
            'edukasi_kurang',
            'kurang_dukungan',
            'penurunan_determinasi',
            'kendala_keuangan',
            'pemulangan_rujukan'
        ];
        foreach ($identificationCriteria as $criteria) {
            $data[$criteria] = in_array($criteria, (array)$request->identification_criteria) ? 1 : 0;
        }

        // Handle planning criteria
        $planningCriteria = [
            'validasi_rencana',
            'rencana_informasi',
            'rencana_melibatkan',
            'fasilitas_penyelesaian',
            'bantuan_alternatif'
        ];
        foreach ($planningCriteria as $criteria) {
            $data[$criteria] = in_array($criteria, (array)$request->planning_criteria) ? 1 : 0;
        }

        // Create new record
        RmeMppA::create($data);

        return redirect()->route('rawat-jalan.mpp.form-a.index', [
            'kd_unit' => $kd_unit,
            'kd_pasien' => $kd_pasien,
            'tgl_masuk' => $tgl_masuk,
            'urut_masuk' => $urut_masuk
        ])->with('success', 'Data MPP Form A berhasil disimpan.');
    }

    public function edit($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
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

        // Get existing MPP Form A data by ID
        $mppData = RmeMppA::where('id', $id)
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->first();

        if (!$mppData) {
            abort(404, 'MPP Form A data not found');
        }

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        $dokter = Dokter::where('status', 1)
            ->select('kd_dokter', 'nama')
            ->get();

        return view('unit-pelayanan.rawat-jalan.pelayanan.mpp.form-a.edit', compact(
            'dataMedis',
            'kd_unit',
            'kd_pasien',
            'tgl_masuk',
            'urut_masuk',
            'dokter',
            'mppData',
            'id'
        ));
    }

    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        // Find existing MPP Form A data by ID
        $mppData = RmeMppA::where('id', $id)
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->first();

        if (!$mppData) {
            abort(404, 'MPP Form A data not found');
        }

        // Process DPJP Tambahan array
        $dpjpTambahanArray = [];
        if ($request->has('dpjp_tambahan') && is_array($request->dpjp_tambahan)) {
            $dpjpTambahanArray = array_filter($request->dpjp_tambahan, function ($value) {
                return !empty($value);
            });
        }

        $data = [
            'dpjp_utama' => $request->dpjp_utama,
            'dpjp_tambahan' => !empty($dpjpTambahanArray) ? json_encode(array_values($dpjpTambahanArray)) : null,
            'screening_date' => $request->screening_date,
            'screening_time' => $request->screening_time,
            'assessment_date' => $request->assessment_date,
            'assessment_time' => $request->assessment_time,
            'identification_date' => $request->identification_date,
            'identification_time' => $request->identification_time,
            'planning_date' => $request->planning_date,
            'planning_time' => $request->planning_time,
            'lain_lain_text' => $request->lain_lain_text,
            'user_update' => auth()->user()->id,
        ];

        // Handle screening criteria
        $screeningCriteria = [
            'fungsi_kognitif',
            'risiko_tinggi',
            'potensi_komplain',
            'riwayat_kronis',
            'kasus_katastropik',    // NEW
            'kasus_terminal',       // NEW
            'status_fungsional',
            'peralatan_medis',
            'gangguan_mental',
            'krisis_keluarga',      // NEW
            'isu_sosial',           // NEW
            'sering_igd',
            'perkiraan_asuhan',
            'sistem_pembiayaan',
            'length_of_stay',
            'rencana_pemulangan',
            'lain_lain'
        ];
        foreach ($screeningCriteria as $criteria) {
            $data[$criteria] = in_array($criteria, (array)$request->screening_criteria) ? 1 : 0;
        }

        // Handle assessment criteria
        $assessmentCriteria = [
            'assessment_fisik',     // NEW (was fisik_fungsional)
            'assessment_fungsional', // NEW
            'assessment_kognitif',   // NEW
            'assessment_kemandirian', // NEW
            'riwayat_kesehatan',
            'perilaku_psiko',
            'kesehatan_mental',
            'dukungan_keluarga',
            'finansial_asuransi',
            'riwayat_obat',
            'trauma_kekerasan',
            'health_literacy',
            'aspek_legal',
            'harapan_hasil'
        ];
        foreach ($assessmentCriteria as $criteria) {
            $data[$criteria] = in_array($criteria, (array)$request->assessment_criteria) ? 1 : 0;
        }

        // Handle identification criteria
        $identificationCriteria = [
            'tingkat_asuhan',
            'over_utilization',     // NEW (was over_under_utilization)
            'under_utilization',    // NEW
            'ketidak_patuhan',
            'edukasi_kurang',
            'kurang_dukungan',
            'penurunan_determinasi',
            'kendala_keuangan',
            'pemulangan_rujukan'
        ];
        foreach ($identificationCriteria as $criteria) {
            $data[$criteria] = in_array($criteria, (array)$request->identification_criteria) ? 1 : 0;
        }

        // Handle planning criteria
        $planningCriteria = [
            'validasi_rencana',
            'rencana_informasi',
            'rencana_melibatkan',
            'fasilitas_penyelesaian',
            'bantuan_alternatif'
        ];
        foreach ($planningCriteria as $criteria) {
            $data[$criteria] = in_array($criteria, (array)$request->planning_criteria) ? 1 : 0;
        }

        // Update existing record
        $mppData->update($data);

        return redirect()->route('rawat-jalan.mpp.form-a.index', [
            'kd_unit' => $kd_unit,
            'kd_pasien' => $kd_pasien,
            'tgl_masuk' => $tgl_masuk,
            'urut_masuk' => $urut_masuk
        ])->with('success', 'Data MPP Form A berhasil diupdate.');
    }

    public function destroy($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $mppData = RmeMppA::where('id', $id)
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->first();

        if (!$mppData) {
            abort(404, 'MPP Form A data not found');
        }

        $mppData->delete();

        return redirect()->route('rawat-jalan.mpp.form-a.index', [
            'kd_unit' => $kd_unit,
            'kd_pasien' => $kd_pasien,
            'tgl_masuk' => $tgl_masuk,
            'urut_masuk' => $urut_masuk
        ])->with('success', 'Data MPP Form A berhasil dihapus.');
    }

    public function print($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
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

        // Get MPP Form A data
        $mppData = RmeMppA::where('id', $id)
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->first();

        if (!$mppData) {
            abort(404, 'MPP Form A data not found');
        }

        // Calculate age
        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        // Get doctor names and user creator
        $dpjpUtama = null;
        $dpjpTambahan = [];
        $userCreate = null;

        if ($mppData->dpjp_utama) {
            $dpjpUtama = Dokter::where('kd_dokter', $mppData->dpjp_utama)->first();
        }

        if ($mppData->dpjp_tambahan) {
            $dpjpTambahanArray = json_decode($mppData->dpjp_tambahan, true);
            if (is_array($dpjpTambahanArray)) {
                // New format: JSON array
                $dpjpTambahan = Dokter::whereIn('kd_dokter', $dpjpTambahanArray)->get();
            } else {
                // Old format: single doctor code
                $dokter = Dokter::where('kd_dokter', $mppData->dpjp_tambahan)->first();
                $dpjpTambahan = $dokter ? collect([$dokter]) : collect([]);
            }
        }

        // Get user who created the record
        if ($mppData->user_create) {
            $userCreate = \App\Models\User::find($mppData->user_create);
        }

        // Logo path
        $logoPath = public_path('assets/img/Logo-RSUD-Langsa-1.png');

        $pdf = Pdf::loadView('unit-pelayanan.rawat-jalan.pelayanan.mpp.form-a.print', compact(
            'dataMedis',
            'mppData',
            'dpjpUtama',
            'dpjpTambahan',
            'userCreate',
            'logoPath'
        ));

        $pdf->setPaper('A4', 'portrait');

        $filename = 'MPP_Form_A_' . $kd_pasien . '_' . date('Y-m-d', strtotime($tgl_masuk)) . '.pdf';

        return $pdf->stream($filename);
    }
}
