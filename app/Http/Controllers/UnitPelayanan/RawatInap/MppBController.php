<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\HrdKaryawan;
use App\Models\Kunjungan;
use App\Models\Perawat;
use App\Models\RmeMppB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MppBController extends Controller
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

        $mppDataList = RmeMppB::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->get();

        if ($mppDataList->isEmpty()) {
            $mppDataList = null;
        }

        return view('unit-pelayanan.rawat-inap.pelayanan.mpp.form-b.index', compact(
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

        $perawat = HrdKaryawan::where('kd_jenis_tenaga', 2)
            ->where('kd_detail_jenis_tenaga', 1)
            ->where('status_peg', 1)
            ->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.mpp.form-b.create', compact(
            'dataMedis',
            'kd_unit',
            'kd_pasien',
            'tgl_masuk',
            'urut_masuk',
            'dokter',
            'perawat'
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
            'dokter_1' => $request->dokter_1,
            'dokter_2' => $request->dokter_2,
            'dokter_3' => $request->dokter_3,
            'petugas_terkait_1' => $request->petugas_terkait_1,
            'petugas_terkait_2' => $request->petugas_terkait_2,

            // 1. Rencana Pelayanan Pasien
            'rencana_date' => $request->rencana_date,
            'rencana_time' => $request->rencana_time,
            'rencana_pelayanan' => $request->rencana_pelayanan,

            // 2. Monitoring Pelayanan/Asuhan Pasien
            'monitoring_date' => $request->monitoring_date,
            'monitoring_time' => $request->monitoring_time,
            'monitoring_pelayanan' => $request->monitoring_pelayanan,

            // 3. Koordinasi Komunikasi dan Kolaborasi
            'koordinasi_date' => $request->koordinasi_date,
            'koordinasi_time' => $request->koordinasi_time,

            // 4. Advokasi Pelayanan Pasien
            'advokasi_date' => $request->advokasi_date,
            'advokasi_time' => $request->advokasi_time,

            // 5. Hasil Pelayanan
            'hasil_date' => $request->hasil_date,
            'hasil_time' => $request->hasil_time,
            'hasil_pelayanan' => $request->hasil_pelayanan,

            // 6. Terminasi Manajemen Pelayanan
            'terminasi_date' => $request->terminasi_date,
            'terminasi_time' => $request->terminasi_time,

            'user_create' => auth()->user()->id,
        ];

        // Handle koordinasi criteria
        $koordinasiCriteria = [
            'konsultasi_kolaborasi',
            'second_opinion',
            'rawat_bersama',
            'komunikasi_edukasi',
            'rujukan'
        ];
        foreach ($koordinasiCriteria as $criteria) {
            $data[$criteria] = in_array($criteria, (array)$request->koordinasi) ? 1 : 0;
        }

        // Handle advokasi criteria
        $advokasiCriteria = [
            'diskusi_ppa',
            'fasilitasi_akses',
            'kemandirian_keputusan',
            'pencegahan_disparitas',
            'pemenuhan_kebutuhan'
        ];
        foreach ($advokasiCriteria as $criteria) {
            $data[$criteria] = in_array($criteria, (array)$request->advokasi) ? 1 : 0;
        }

        // Handle terminasi criteria
        $terminasiCriteria = [
            'puas',
            'tidak_puas',
            'abstain',
            'konflik_komplain',
            'keuangan',
            'pulang_sembuh',
            'rujuk',
            'meninggal'
        ];
        foreach ($terminasiCriteria as $criteria) {
            $data[$criteria] = in_array($criteria, (array)$request->terminasi) ? 1 : 0;
        }

        RmeMppB::create($data);


        return redirect()->route('rawat-inap.mpp.form-b.index', [
            'kd_unit' => $kd_unit,
            'kd_pasien' => $kd_pasien,
            'tgl_masuk' => $tgl_masuk,
            'urut_masuk' => $urut_masuk
        ])->with('success', 'Data MPP Form B berhasil diupdate.');
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

        // Get existing MPP Form B data by ID
        $mppData = RmeMppB::where('id', $id)
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->first();

        if (!$mppData) {
            abort(404, 'MPP Form B data not found');
        }

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        $dokter = Dokter::where('status', 1)
            ->select('kd_dokter', 'nama')
            ->get();

        $perawat = HrdKaryawan::where('kd_jenis_tenaga', 2)
            ->where('kd_detail_jenis_tenaga', 1)
            ->where('status_peg', 1)
            ->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.mpp.form-b.edit', compact(
            'dataMedis',
            'kd_unit',
            'kd_pasien',
            'tgl_masuk',
            'urut_masuk',
            'dokter',
            'perawat',
            'mppData',
            'id'
        ));
    }

    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        // Find existing MPP Form B data by ID
        $mppData = RmeMppB::where('id', $id)
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->first();

        if (!$mppData) {
            abort(404, 'MPP Form B data not found');
        }

        $data = [
            'dpjp_utama' => $request->dpjp_utama,
            'dokter_1' => $request->dokter_1,
            'dokter_2' => $request->dokter_2,
            'dokter_3' => $request->dokter_3,
            'petugas_terkait_1' => $request->petugas_terkait_1,
            'petugas_terkait_2' => $request->petugas_terkait_2,

            // 1. Rencana Pelayanan Pasien
            'rencana_date' => $request->rencana_date,
            'rencana_time' => $request->rencana_time,
            'rencana_pelayanan' => $request->rencana_pelayanan,

            // 2. Monitoring Pelayanan/Asuhan Pasien
            'monitoring_date' => $request->monitoring_date,
            'monitoring_time' => $request->monitoring_time,
            'monitoring_pelayanan' => $request->monitoring_pelayanan,

            // 3. Koordinasi Komunikasi dan Kolaborasi
            'koordinasi_date' => $request->koordinasi_date,
            'koordinasi_time' => $request->koordinasi_time,

            // 4. Advokasi Pelayanan Pasien
            'advokasi_date' => $request->advokasi_date,
            'advokasi_time' => $request->advokasi_time,

            // 5. Hasil Pelayanan
            'hasil_date' => $request->hasil_date,
            'hasil_time' => $request->hasil_time,
            'hasil_pelayanan' => $request->hasil_pelayanan,

            // 6. Terminasi Manajemen Pelayanan
            'terminasi_date' => $request->terminasi_date,
            'terminasi_time' => $request->terminasi_time,

            'user_update' => auth()->user()->id,
        ];

        // Handle koordinasi criteria
        $koordinasiCriteria = [
            'konsultasi_kolaborasi',
            'second_opinion',
            'rawat_bersama',
            'komunikasi_edukasi',
            'rujukan'
        ];
        foreach ($koordinasiCriteria as $criteria) {
            $data[$criteria] = in_array($criteria, (array)$request->koordinasi) ? 1 : 0;
        }

        // Handle advokasi criteria
        $advokasiCriteria = [
            'diskusi_ppa',
            'fasilitasi_akses',
            'kemandirian_keputusan',
            'pencegahan_disparitas',
            'pemenuhan_kebutuhan'
        ];
        foreach ($advokasiCriteria as $criteria) {
            $data[$criteria] = in_array($criteria, (array)$request->advokasi) ? 1 : 0;
        }

        // Handle terminasi criteria
        $terminasiCriteria = [
            'puas',
            'tidak_puas',
            'abstain',
            'konflik_komplain',
            'keuangan',
            'pulang_sembuh',
            'rujuk',
            'meninggal'
        ];
        foreach ($terminasiCriteria as $criteria) {
            $data[$criteria] = in_array($criteria, (array)$request->terminasi) ? 1 : 0;
        }

        // Update existing record
        $mppData->update($data);

        return redirect()->route('rawat-inap.mpp.form-b.index', [
            'kd_unit' => $kd_unit,
            'kd_pasien' => $kd_pasien,
            'tgl_masuk' => $tgl_masuk,
            'urut_masuk' => $urut_masuk
        ])->with('success', 'Data MPP Form B berhasil diupdate.');
    }

    public function destroy($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $mppData = RmeMppB::where('id', $id)
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->first();

        if (!$mppData) {
            abort(404, 'MPP Form B data not found');
        }

        $mppData->delete();

        return redirect()->route('rawat-inap.mpp.form-b.index', [
            'kd_unit' => $kd_unit,
            'kd_pasien' => $kd_pasien,
            'tgl_masuk' => $tgl_masuk,
            'urut_masuk' => $urut_masuk
        ])->with('success', 'Data MPP Form B berhasil dihapus.');
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

        // Get MPP Form B data
        $mppData = RmeMppB::where('id', $id)
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->first();

        if (!$mppData) {
            abort(404, 'MPP Form B data not found');
        }

        // Calculate age
        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        // Get doctor names
        $dpjpUtama = null;
        $dokter1 = null;
        $dokter2 = null;
        $dokter3 = null;

        if ($mppData->dpjp_utama) {
            $dpjpUtama = Dokter::where('kd_dokter', $mppData->dpjp_utama)->first();
        }

        if ($mppData->dokter_1) {
            $dokter1 = Dokter::where('kd_dokter', $mppData->dokter_1)->first();
        }

        if ($mppData->dokter_2) {
            $dokter2 = Dokter::where('kd_dokter', $mppData->dokter_2)->first();
        }

        if ($mppData->dokter_3) {
            $dokter3 = Dokter::where('kd_dokter', $mppData->dokter_3)->first();
        }

        // Get perawat names
        $perawat1 = null;
        $perawat2 = null;

        if ($mppData->petugas_terkait_1) {
            $perawat1 = HrdKaryawan::where('nip', $mppData->petugas_terkait_1)->first();
        }

        if ($mppData->petugas_terkait_2) {
            $perawat2 = HrdKaryawan::where('nip', $mppData->petugas_terkait_2)->first();
        }

        // Logo path
        $logoPath = public_path('assets/img/Logo-RSUD-Langsa-1.png');

        $pdf = Pdf::loadView('unit-pelayanan.rawat-inap.pelayanan.mpp.form-b.print', compact(
            'dataMedis',
            'mppData',
            'dpjpUtama',
            'dokter1',
            'dokter2',
            'dokter3',
            'perawat1',
            'perawat2',
            'logoPath'
        ));

        $pdf->setPaper('A4', 'portrait');

        $filename = 'MPP_Form_B_' . $kd_pasien . '_' . date('Y-m-d', strtotime($tgl_masuk)) . '.pdf';

        return $pdf->stream($filename);
    }

    

}
