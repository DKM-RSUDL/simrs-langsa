<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

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

        $mppDataList = RmeMppA::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.mpp.form-a.index', compact(
            'dataMedis', 'kd_unit', 'kd_pasien', 'tgl_masuk', 'urut_masuk', 'mppDataList'
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

        return view('unit-pelayanan.rawat-inap.pelayanan.mpp.form-a.create', compact(
            'dataMedis', 'kd_unit', 'kd_pasien', 'tgl_masuk', 'urut_masuk', 'dokter'
        ));
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $data = [
            'kd_unit' => $kd_unit,
            'kd_pasien' => $kd_pasien,
            'tgl_masuk' => $tgl_masuk,
            'urut_masuk' => $urut_masuk,
            'dpjp_utama' => $request->dpjp_utama,
            'dpjp_tambahan' => $request->dpjp_tambahan,
            'screening_date' => $request->screening_date,
            'screening_time' => $request->screening_time,
            'assessment_date' => $request->assessment_date,
            'assessment_time' => $request->assessment_time,
            'identification_date' => $request->identification_date,
            'identification_time' => $request->identification_time,
            'planning_date' => $request->planning_date,
            'planning_time' => $request->planning_time,
            'user_create' => auth()->user()->id,
        ];

        // Handle screening criteria
        $screeningCriteria = [
            'fungsi_kognitif',
            'risiko_tinggi',
            'potensi_komplain',
            'riwayat_kronis',
            'status_fungsional',
            'peralatan_medis',
            'gangguan_mental',
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
            'fisik_fungsional',
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
            'over_under_utilization',
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

        return redirect()->route('rawat-inap.mpp.form-a.index', [
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

        return view('unit-pelayanan.rawat-inap.pelayanan.mpp.form-a.edit', compact(
            'dataMedis',
            'kd_unit',
            'kd_pasien',
            'tgl_masuk',
            'urut_masuk',
            'dokter',
            'mppData',
            'id'  // Tambahkan parameter id
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

        $data = [
            'dpjp_utama' => $request->dpjp_utama,
            'dpjp_tambahan' => $request->dpjp_tambahan,
            'screening_date' => $request->screening_date,
            'screening_time' => $request->screening_time,
            'assessment_date' => $request->assessment_date,
            'assessment_time' => $request->assessment_time,
            'identification_date' => $request->identification_date,
            'identification_time' => $request->identification_time,
            'planning_date' => $request->planning_date,
            'planning_time' => $request->planning_time,
            'user_update' => auth()->user()->id,
        ];

        // Handle screening criteria
        $screeningCriteria = [
            'fungsi_kognitif',
            'risiko_tinggi',
            'potensi_komplain',
            'riwayat_kronis',
            'status_fungsional',
            'peralatan_medis',
            'gangguan_mental',
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
            'fisik_fungsional',
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
            'over_under_utilization',
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

        return redirect()->route('rawat-inap.mpp.form-a.index', [
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

        return redirect()->route('rawat-inap.mpp.form-a.index', [
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

        // Get doctor names
        $dpjpUtama = null;
        $dpjpTambahan = null;

        if ($mppData->dpjp_utama) {
            $dpjpUtama = Dokter::where('kd_dokter', $mppData->dpjp_utama)->first();
        }

        if ($mppData->dpjp_tambahan) {
            $dpjpTambahan = Dokter::where('kd_dokter', $mppData->dpjp_tambahan)->first();
        }

        // Logo path
        $logoPath = public_path('assets/img/Logo-RSUD-Langsa-1.png');

        $pdf = Pdf::loadView('unit-pelayanan.rawat-inap.pelayanan.mpp.form-a.print', compact(
            'dataMedis',
            'mppData',
            'dpjpUtama',
            'dpjpTambahan',
            'logoPath'
        ));

        $pdf->setPaper('A4', 'portrait');

        $filename = 'MPP_Form_A_' . $kd_pasien . '_' . date('Y-m-d', strtotime($tgl_masuk)) . '.pdf';

        return $pdf->stream($filename);
    }

}
