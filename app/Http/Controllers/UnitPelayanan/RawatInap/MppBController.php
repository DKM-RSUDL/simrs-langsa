<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\HrdKaryawan;
use App\Models\Kunjungan;
use App\Models\Perawat;
use App\Models\RmeMppA;
use App\Models\RmeMppB;
use App\Models\User;
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
            ->orderBy('created_at', 'desc')
            ->get();

        // Transform collection to add processed data
        $mppDataList = $mppDataList->map(function ($mppData) {
            // Process DPJP Utama
            $dpjpUtama = null;
            if ($mppData->dpjp_utama) {
                $dpjpUtama = \App\Models\Dokter::where('kd_dokter', $mppData->dpjp_utama)->first();
            }

            // Process Dokter Tambahan
            $dokterTambahanNames = [];
            if ($mppData->dokter_tambahan) {
                $dokterTambahanArray = json_decode($mppData->dokter_tambahan, true);
                if (is_array($dokterTambahanArray)) {
                    // New format: JSON array
                    $dokterTambahanNames = \App\Models\Dokter::whereIn('kd_dokter', $dokterTambahanArray)
                        ->pluck('nama')->toArray();
                } else {
                    // Old format: single doctor code
                    $dokter = \App\Models\Dokter::where('kd_dokter', $mppData->dokter_tambahan)->first();
                    $dokterTambahanNames = $dokter ? [$dokter->nama] : [];
                }
            }

            // Process Petugas Terkait
            $petugasTerkaitNames = [];
            if ($mppData->petugas_terkait) {
                $petugasTerkaitArray = json_decode($mppData->petugas_terkait, true);
                if (is_array($petugasTerkaitArray)) {
                    // New format: JSON array
                    $petugasData = \App\Models\HrdKaryawan::whereIn('kd_karyawan', $petugasTerkaitArray)->get();
                    foreach ($petugasData as $petugas) {
                        $petugasTerkaitNames[] = trim($petugas->gelar_depan . ' ' . $petugas->nama . ' ' . $petugas->gelar_belakang);
                    }
                } else {
                    // Old format: single staff code
                    $petugas = \App\Models\HrdKaryawan::where('kd_karyawan', $mppData->petugas_terkait)->first();
                    $petugasTerkaitNames = $petugas ? [trim($petugas->gelar_depan . ' ' . $petugas->nama . ' ' . $petugas->gelar_belakang)] : [];
                }
            }

            // Add properties to existing model instance (better approach)
            $mppData->dpjpUtama = $dpjpUtama;
            $mppData->dokterTambahanNames = $dokterTambahanNames;
            $mppData->petugasTerkaitNames = $petugasTerkaitNames;

            return $mppData;
        });

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
            ->get();

        $perawat = HrdKaryawan::where('kd_jenis_tenaga', 2)
            ->where('kd_detail_jenis_tenaga', 1)
            ->where('status_peg', 1)
            ->get();

        // Get latest Form A data to auto-fill doctors
        $latestFormA = RmeMppA::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->orderBy('created_at', 'desc')
            ->first();

        return view('unit-pelayanan.rawat-inap.pelayanan.mpp.form-b.create', compact(
            'dataMedis',
            'kd_unit',
            'kd_pasien',
            'tgl_masuk',
            'urut_masuk',
            'dokter',
            'perawat',
            'latestFormA'
        ));
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        // Process Dokter Tambahan array
        $dokterTambahanArray = [];
        if ($request->has('dokter_tambahan') && is_array($request->dokter_tambahan)) {
            $dokterTambahanArray = array_filter($request->dokter_tambahan, function ($value) {
                return !empty($value);
            });
        }

        // Process Petugas Terkait array
        $petugasTerkaitArray = [];
        if ($request->has('petugas_terkait') && is_array($request->petugas_terkait)) {
            $petugasTerkaitArray = array_filter($request->petugas_terkait, function ($value) {
                return !empty($value);
            });
        }

        $data = [
            'kd_unit' => $kd_unit,
            'kd_pasien' => $kd_pasien,
            'tgl_masuk' => $tgl_masuk,
            'urut_masuk' => $urut_masuk,
            'dpjp_utama' => $request->dpjp_utama,
            'dokter_tambahan' => !empty($dokterTambahanArray) ? json_encode(array_values($dokterTambahanArray)) : null,
            'petugas_terkait' => !empty($petugasTerkaitArray) ? json_encode(array_values($petugasTerkaitArray)) : null,

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

        // Create new record (FIXED: was using update instead of create)
        RmeMppB::create($data);

        return redirect()->route('rawat-inap.mpp.form-b.index', [
            'kd_unit' => $kd_unit,
            'kd_pasien' => $kd_pasien,
            'tgl_masuk' => $tgl_masuk,
            'urut_masuk' => $urut_masuk
        ])->with('success', 'Data MPP Form B berhasil disimpan.');
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

        // Process Dokter Tambahan array
        $dokterTambahanArray = [];
        if ($request->has('dokter_tambahan') && is_array($request->dokter_tambahan)) {
            $dokterTambahanArray = array_filter($request->dokter_tambahan, function ($value) {
                return !empty($value);
            });
        }

        // Process Petugas Terkait array
        $petugasTerkaitArray = [];
        if ($request->has('petugas_terkait') && is_array($request->petugas_terkait)) {
            $petugasTerkaitArray = array_filter($request->petugas_terkait, function ($value) {
                return !empty($value);
            });
        }

        $data = [
            'dpjp_utama' => $request->dpjp_utama,
            'dokter_tambahan' => !empty($dokterTambahanArray) ? json_encode(array_values($dokterTambahanArray)) : null,
            'petugas_terkait' => !empty($petugasTerkaitArray) ? json_encode(array_values($petugasTerkaitArray)) : null,

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
        $dokterTambahan = [];

        if ($mppData->dpjp_utama) {
            $dpjpUtama = Dokter::where('kd_dokter', $mppData->dpjp_utama)->first();
        }

        if ($mppData->dokter_tambahan) {
            $dokterTambahanArray = json_decode($mppData->dokter_tambahan, true);
            if (is_array($dokterTambahanArray)) {
                // New format: JSON array
                $dokterTambahan = Dokter::whereIn('kd_dokter', $dokterTambahanArray)->get();
            } else {
                // Old format: single doctor code (for backward compatibility)
                $dokter = Dokter::where('kd_dokter', $mppData->dokter_tambahan)->first();
                $dokterTambahan = $dokter ? collect([$dokter]) : collect([]);
            }
        }

        // Get petugas names
        $petugasTerkait = [];

        if ($mppData->petugas_terkait) {
            $petugasTerkaitArray = json_decode($mppData->petugas_terkait, true);
            if (is_array($petugasTerkaitArray)) {
                // New format: JSON array
                $petugasTerkait = HrdKaryawan::whereIn('kd_karyawan', $petugasTerkaitArray)->get();
            } else {
                // Old format: single petugas code (for backward compatibility)
                $petugas = HrdKaryawan::where('kd_karyawan', $mppData->petugas_terkait)->first();
                $petugasTerkait = $petugas ? collect([$petugas]) : collect([]);
            }
        }

        // Get user who created the record
        $userCreate = null;
        if ($mppData->user_create) {
            $userCreate = \App\Models\User::find($mppData->user_create);
        }

        // Logo path
        $logoPath = public_path('assets/img/Logo-RSUD-Langsa-1.png');

        $pdf = Pdf::loadView('unit-pelayanan.rawat-inap.pelayanan.mpp.form-b.print', compact(
            'dataMedis',
            'mppData',
            'dpjpUtama',
            'dokterTambahan',
            'petugasTerkait',
            'userCreate',
            'logoPath'
        ));

        $pdf->setPaper('A4', 'portrait');

        $filename = 'MPP_Form_B_' . $kd_pasien . '_' . date('Y-m-d', strtotime($tgl_masuk)) . '.pdf';

        return $pdf->stream($filename);
    }
}
