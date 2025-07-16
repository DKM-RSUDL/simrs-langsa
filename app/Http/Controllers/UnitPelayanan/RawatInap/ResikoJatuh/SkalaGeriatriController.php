<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap\ResikoJatuh;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\RmeSkalaGeriatri;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SkalaGeriatriController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
    }

    public function checkDuplicate(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $exists = RmeSkalaGeriatri::where('kd_pasien', $kd_pasien)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->where('tanggal_implementasi', $request->tanggal_implementasi)
            ->where('shift', $request->shift)
            ->exists();

        return response()->json([
            'exists' => $exists,
            'message' => $exists ? 'Data dengan tanggal dan shift ini sudah ada!' : 'Data dapat disimpan'
        ]);
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

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        // Query untuk data Skala Geriatri
        $query = RmeSkalaGeriatri::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk);

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('shift', 'like', '%' . $search . '%')
                    ->orWhere('kategori_risiko', 'like', '%' . $search . '%')
                    ->orWhere('total_skor', 'like', '%' . $search . '%');
            });
        }

        // Filter berdasarkan tanggal
        if ($request->filled('dari_tanggal')) {
            $query->whereDate('tanggal_implementasi', '>=', $request->dari_tanggal);
        }

        if ($request->filled('sampai_tanggal')) {
            $query->whereDate('tanggal_implementasi', '<=', $request->sampai_tanggal);
        }

        // Ambil data dengan pagination dan relasi user
        $dataGeriatri = $query->with(['userCreated', 'userUpdated'])
            ->orderBy('tanggal_implementasi', 'desc')
            ->orderBy('jam_implementasi', 'desc')
            ->paginate(10);

        // Append query parameters untuk pagination
        $dataGeriatri->appends($request->query());

        return view('unit-pelayanan.rawat-inap.pelayanan.resiko-jatuh.skala-geriatri.index', compact(
            'dataMedis',
            'dataGeriatri'
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

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        return view('unit-pelayanan.rawat-inap.pelayanan.resiko-jatuh.skala-geriatri.create', compact(
            'dataMedis',
        ));
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        DB::beginTransaction();

        try {
            // Validasi duplikasi tanggal dan shift
            $existingData = RmeSkalaGeriatri::where('kd_pasien', $kd_pasien)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->where('tanggal_implementasi', $request->tanggal_implementasi)
                ->where('shift', $request->shift)
                ->first();

            if ($existingData) {
                return back()->with('error', 'Data dengan tanggal ' . date('d/m/Y', strtotime($request->tanggal_implementasi)) . ' dan shift ' . ucfirst($request->shift) . ' sudah ada!')
                    ->withInput();
            }

            // Kalkulasi skor khusus untuk Geriatri
            $riwayatJatuhScore = 0;
            $riwayat1a = (int)$request->riwayat_jatuh_1a;
            $riwayat1b = (int)$request->riwayat_jatuh_1b;
            if ($riwayat1a === 6 || $riwayat1b === 6) {
                $riwayatJatuhScore = 6;
            } else {
                $riwayatJatuhScore = 0;
            }

            $statusMentalScore = 0;
            $mental2a = (int)$request->status_mental_2a;
            $mental2b = (int)$request->status_mental_2b;
            $mental2c = (int)$request->status_mental_2c;
            if ($mental2a === 14 || $mental2b === 14 || $mental2c === 14) {
                $statusMentalScore = 14;
            } else {
                $statusMentalScore = 0;
            }

            $penglihatanScore = 0;
            $penglihatan3a = (int)$request->penglihatan_3a;
            $penglihatan3b = (int)$request->penglihatan_3b;
            $penglihatan3c = (int)$request->penglihatan_3c;
            if ($penglihatan3a === 1 || $penglihatan3b === 1 || $penglihatan3c === 1) {
                $penglihatanScore = 1;
            } else {
                $penglihatanScore = 0;
            }

            $kebiasaanBerkemihScore = (int)$request->kebiasaan_berkemih_4a;

            // Transfer + Mobilitas logic
            $transferValue = (int)$request->transfer;
            $mobilitasValue = (int)$request->mobilitas;
            $totalTransferMobilitas = $transferValue + $mobilitasValue;
            $transferMobilitasScore = ($totalTransferMobilitas >= 0 && $totalTransferMobilitas <= 3) ? 0 : 7;

            // Hitung total skor
            $totalSkor = $riwayatJatuhScore + $statusMentalScore + $penglihatanScore + $kebiasaanBerkemihScore + $transferMobilitasScore;

            // Tentukan kategori risiko
            if ($totalSkor >= 0 && $totalSkor <= 5) {
                $kategoriRisiko = 'Risiko Rendah';
            } elseif ($totalSkor >= 6 && $totalSkor <= 16) {
                $kategoriRisiko = 'Risiko Sedang';
            } elseif ($totalSkor >= 17 && $totalSkor <= 30) {
                $kategoriRisiko = 'Risiko Tinggi';
            } else {
                $kategoriRisiko = 'Skor Tidak Valid';
            }

            // Simpan data assessment
            $dataGeriatri = new RmeSkalaGeriatri();
            $dataGeriatri->kd_pasien = $kd_pasien;
            $dataGeriatri->tgl_masuk = $tgl_masuk;
            $dataGeriatri->kd_unit = $kd_unit;
            $dataGeriatri->urut_masuk = $urut_masuk;

            // Data dasar
            $dataGeriatri->tanggal_implementasi = $request->tanggal_implementasi;
            $dataGeriatri->jam_implementasi = $request->jam_implementasi;
            $dataGeriatri->shift = $request->shift;

            // Data assessment (simpan nilai individual)
            $dataGeriatri->riwayat_jatuh_1a = $riwayat1a;
            $dataGeriatri->riwayat_jatuh_1b = $riwayat1b;
            $dataGeriatri->status_mental_2a = $mental2a;
            $dataGeriatri->status_mental_2b = $mental2b;
            $dataGeriatri->status_mental_2c = $mental2c;
            $dataGeriatri->penglihatan_3a = $penglihatan3a;
            $dataGeriatri->penglihatan_3b = $penglihatan3b;
            $dataGeriatri->penglihatan_3c = $penglihatan3c;
            $dataGeriatri->kebiasaan_berkemih_4a = $kebiasaanBerkemihScore;
            $dataGeriatri->transfer = $transferValue;
            $dataGeriatri->mobilitas = $mobilitasValue;

            // Skor hasil kalkulasi
            $dataGeriatri->skor_riwayat_jatuh = $riwayatJatuhScore;
            $dataGeriatri->skor_status_mental = $statusMentalScore;
            $dataGeriatri->skor_penglihatan = $penglihatanScore;
            $dataGeriatri->skor_kebiasaan_berkemih = $kebiasaanBerkemihScore;
            $dataGeriatri->skor_transfer_mobilitas = $transferMobilitasScore;

            // Hasil assessment
            $dataGeriatri->total_skor = $totalSkor;
            $dataGeriatri->kategori_risiko = $kategoriRisiko;

            // Data intervensi untuk risiko rendah
            if ($kategoriRisiko == 'Risiko Rendah') {
                $dataGeriatri->rr_observasi_ambulasi = $request->has('rr_observasi_ambulasi') ? 1 : 0;
                $dataGeriatri->rr_orientasi_kamar_mandi = $request->has('rr_orientasi_kamar_mandi') ? 1 : 0;
                $dataGeriatri->rr_orientasi_bertahap = $request->has('rr_orientasi_bertahap') ? 1 : 0;
                $dataGeriatri->rr_tempatkan_bel = $request->has('rr_tempatkan_bel') ? 1 : 0;
                $dataGeriatri->rr_instruksi_bantuan = $request->has('rr_instruksi_bantuan') ? 1 : 0;
                $dataGeriatri->rr_pagar_pengaman = $request->has('rr_pagar_pengaman') ? 1 : 0;
                $dataGeriatri->rr_tempat_tidur_rendah = $request->has('rr_tempat_tidur_rendah') ? 1 : 0;
                $dataGeriatri->rr_edukasi_perilaku = $request->has('rr_edukasi_perilaku') ? 1 : 0;
                $dataGeriatri->rr_monitor_berkala = $request->has('rr_monitor_berkala') ? 1 : 0;
                $dataGeriatri->rr_anjuran_kaus_kaki = $request->has('rr_anjuran_kaus_kaki') ? 1 : 0;
                $dataGeriatri->rr_lantai_antislip = $request->has('rr_lantai_antislip') ? 1 : 0;
            }

            // Data intervensi untuk risiko sedang
            if ($kategoriRisiko == 'Risiko Sedang') {
                $dataGeriatri->rs_semua_intervensi_rendah = $request->has('rs_semua_intervensi_rendah') ? 1 : 0;
                $dataGeriatri->rs_gelang_kuning = $request->has('rs_gelang_kuning') ? 1 : 0;
                $dataGeriatri->rs_pasang_gambar = $request->has('rs_pasang_gambar') ? 1 : 0;
                $dataGeriatri->rs_tanda_daftar_nama = $request->has('rs_tanda_daftar_nama') ? 1 : 0;
                $dataGeriatri->rs_pertimbangkan_obat = $request->has('rs_pertimbangkan_obat') ? 1 : 0;
                $dataGeriatri->rs_alat_bantu_jalan = $request->has('rs_alat_bantu_jalan') ? 1 : 0;
            }

            // Data intervensi untuk risiko tinggi
            if ($kategoriRisiko == 'Risiko Tinggi') {
                $dataGeriatri->rt_semua_intervensi_rendah_sedang = $request->has('rt_semua_intervensi_rendah_sedang') ? 1 : 0;
                $dataGeriatri->rt_jangan_tinggalkan = $request->has('rt_jangan_tinggalkan') ? 1 : 0;
                $dataGeriatri->rt_dekat_nurse_station = $request->has('rt_dekat_nurse_station') ? 1 : 0;
            }

            $dataGeriatri->user_created = Auth::id();

            $dataGeriatri->save();

            DB::commit();

            return redirect()->route('rawat-inap.resiko-jatuh.geriatri.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data Skala Geriatri berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage())->withInput();
        }
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

        // Ambil data Humpty Dumpty berdasarkan ID
        $dataSkalaGeriatri = RmeSkalaGeriatri::where('id', $id)
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->first();

        if (!$dataSkalaGeriatri) {
            abort(404, 'Data Humpty Dumpty tidak ditemukan');
        }

        return view('unit-pelayanan.rawat-inap.pelayanan.resiko-jatuh.skala-geriatri.edit', compact(
            'dataMedis',
            'dataSkalaGeriatri'
        ));
    }

    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            // Ambil data yang akan diupdate
            $dataGeriatri = RmeSkalaGeriatri::where('id', $id)
                ->where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->first();

            if (!$dataGeriatri) {
                return back()->with('error', 'Data tidak ditemukan!')
                    ->withInput();
            }

            // Validasi duplikasi tanggal dan shift (kecuali data sendiri)
            $existingData = RmeSkalaGeriatri::where('kd_pasien', $kd_pasien)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->where('tanggal_implementasi', $request->tanggal_implementasi)
                ->where('shift', $request->shift)
                ->where('id', '!=', $id)
                ->first();

            if ($existingData) {
                return back()->with('error', 'Data dengan tanggal ' . date('d/m/Y', strtotime($request->tanggal_implementasi)) . ' dan shift ' . ucfirst($request->shift) . ' sudah ada!')
                    ->withInput();
            }

            // Kalkulasi skor khusus untuk Geriatri
            $riwayatJatuhScore = 0;
            $riwayat1a = (int)$request->riwayat_jatuh_1a;
            $riwayat1b = (int)$request->riwayat_jatuh_1b;
            if ($riwayat1a === 6 || $riwayat1b === 6) {
                $riwayatJatuhScore = 6;
            } else {
                $riwayatJatuhScore = 0;
            }

            $statusMentalScore = 0;
            $mental2a = (int)$request->status_mental_2a;
            $mental2b = (int)$request->status_mental_2b;
            $mental2c = (int)$request->status_mental_2c;
            if ($mental2a === 14 || $mental2b === 14 || $mental2c === 14) {
                $statusMentalScore = 14;
            } else {
                $statusMentalScore = 0;
            }

            $penglihatanScore = 0;
            $penglihatan3a = (int)$request->penglihatan_3a;
            $penglihatan3b = (int)$request->penglihatan_3b;
            $penglihatan3c = (int)$request->penglihatan_3c;
            if ($penglihatan3a === 1 || $penglihatan3b === 1 || $penglihatan3c === 1) {
                $penglihatanScore = 1;
            } else {
                $penglihatanScore = 0;
            }

            $kebiasaanBerkemihScore = (int)$request->kebiasaan_berkemih_4a;

            // Transfer + Mobilitas logic
            $transferValue = (int)$request->transfer;
            $mobilitasValue = (int)$request->mobilitas;
            $totalTransferMobilitas = $transferValue + $mobilitasValue;
            $transferMobilitasScore = ($totalTransferMobilitas >= 0 && $totalTransferMobilitas <= 3) ? 0 : 7;

            // Hitung total skor
            $totalSkor = $riwayatJatuhScore + $statusMentalScore + $penglihatanScore + $kebiasaanBerkemihScore + $transferMobilitasScore;

            // Tentukan kategori risiko
            if ($totalSkor >= 0 && $totalSkor <= 5) {
                $kategoriRisiko = 'Risiko Rendah';
            } elseif ($totalSkor >= 6 && $totalSkor <= 16) {
                $kategoriRisiko = 'Risiko Sedang';
            } elseif ($totalSkor >= 17 && $totalSkor <= 30) {
                $kategoriRisiko = 'Risiko Tinggi';
            } else {
                $kategoriRisiko = 'Skor Tidak Valid';
            }

            // Update data dasar
            $dataGeriatri->tanggal_implementasi = $request->tanggal_implementasi;
            $dataGeriatri->jam_implementasi = $request->jam_implementasi;
            $dataGeriatri->shift = $request->shift;

            // Update data assessment (simpan nilai individual)
            $dataGeriatri->riwayat_jatuh_1a = $riwayat1a;
            $dataGeriatri->riwayat_jatuh_1b = $riwayat1b;
            $dataGeriatri->status_mental_2a = $mental2a;
            $dataGeriatri->status_mental_2b = $mental2b;
            $dataGeriatri->status_mental_2c = $mental2c;
            $dataGeriatri->penglihatan_3a = $penglihatan3a;
            $dataGeriatri->penglihatan_3b = $penglihatan3b;
            $dataGeriatri->penglihatan_3c = $penglihatan3c;
            $dataGeriatri->kebiasaan_berkemih_4a = $kebiasaanBerkemihScore;
            $dataGeriatri->transfer = $transferValue;
            $dataGeriatri->mobilitas = $mobilitasValue;

            // Update skor hasil kalkulasi
            $dataGeriatri->skor_riwayat_jatuh = $riwayatJatuhScore;
            $dataGeriatri->skor_status_mental = $statusMentalScore;
            $dataGeriatri->skor_penglihatan = $penglihatanScore;
            $dataGeriatri->skor_kebiasaan_berkemih = $kebiasaanBerkemihScore;
            $dataGeriatri->skor_transfer_mobilitas = $transferMobilitasScore;

            // Update hasil assessment
            $dataGeriatri->total_skor = $totalSkor;
            $dataGeriatri->kategori_risiko = $kategoriRisiko;

            // Reset semua intervensi ke 0 terlebih dahulu
            $dataGeriatri->rr_observasi_ambulasi = 0;
            $dataGeriatri->rr_orientasi_kamar_mandi = 0;
            $dataGeriatri->rr_orientasi_bertahap = 0;
            $dataGeriatri->rr_tempatkan_bel = 0;
            $dataGeriatri->rr_instruksi_bantuan = 0;
            $dataGeriatri->rr_pagar_pengaman = 0;
            $dataGeriatri->rr_tempat_tidur_rendah = 0;
            $dataGeriatri->rr_edukasi_perilaku = 0;
            $dataGeriatri->rr_monitor_berkala = 0;
            $dataGeriatri->rr_anjuran_kaus_kaki = 0;
            $dataGeriatri->rr_lantai_antislip = 0;
            $dataGeriatri->rs_semua_intervensi_rendah = 0;
            $dataGeriatri->rs_gelang_kuning = 0;
            $dataGeriatri->rs_pasang_gambar = 0;
            $dataGeriatri->rs_tanda_daftar_nama = 0;
            $dataGeriatri->rs_pertimbangkan_obat = 0;
            $dataGeriatri->rs_alat_bantu_jalan = 0;
            $dataGeriatri->rt_semua_intervensi_rendah_sedang = 0;
            $dataGeriatri->rt_jangan_tinggalkan = 0;
            $dataGeriatri->rt_dekat_nurse_station = 0;

            // Update data intervensi berdasarkan kategori risiko
            if ($kategoriRisiko == 'Risiko Rendah') {
                $dataGeriatri->rr_observasi_ambulasi = $request->has('rr_observasi_ambulasi') ? 1 : 0;
                $dataGeriatri->rr_orientasi_kamar_mandi = $request->has('rr_orientasi_kamar_mandi') ? 1 : 0;
                $dataGeriatri->rr_orientasi_bertahap = $request->has('rr_orientasi_bertahap') ? 1 : 0;
                $dataGeriatri->rr_tempatkan_bel = $request->has('rr_tempatkan_bel') ? 1 : 0;
                $dataGeriatri->rr_instruksi_bantuan = $request->has('rr_instruksi_bantuan') ? 1 : 0;
                $dataGeriatri->rr_pagar_pengaman = $request->has('rr_pagar_pengaman') ? 1 : 0;
                $dataGeriatri->rr_tempat_tidur_rendah = $request->has('rr_tempat_tidur_rendah') ? 1 : 0;
                $dataGeriatri->rr_edukasi_perilaku = $request->has('rr_edukasi_perilaku') ? 1 : 0;
                $dataGeriatri->rr_monitor_berkala = $request->has('rr_monitor_berkala') ? 1 : 0;
                $dataGeriatri->rr_anjuran_kaus_kaki = $request->has('rr_anjuran_kaus_kaki') ? 1 : 0;
                $dataGeriatri->rr_lantai_antislip = $request->has('rr_lantai_antislip') ? 1 : 0;
            } elseif ($kategoriRisiko == 'Risiko Sedang') {
                $dataGeriatri->rs_semua_intervensi_rendah = $request->has('rs_semua_intervensi_rendah') ? 1 : 0;
                $dataGeriatri->rs_gelang_kuning = $request->has('rs_gelang_kuning') ? 1 : 0;
                $dataGeriatri->rs_pasang_gambar = $request->has('rs_pasang_gambar') ? 1 : 0;
                $dataGeriatri->rs_tanda_daftar_nama = $request->has('rs_tanda_daftar_nama') ? 1 : 0;
                $dataGeriatri->rs_pertimbangkan_obat = $request->has('rs_pertimbangkan_obat') ? 1 : 0;
                $dataGeriatri->rs_alat_bantu_jalan = $request->has('rs_alat_bantu_jalan') ? 1 : 0;
            } elseif ($kategoriRisiko == 'Risiko Tinggi') {
                $dataGeriatri->rt_semua_intervensi_rendah_sedang = $request->has('rt_semua_intervensi_rendah_sedang') ? 1 : 0;
                $dataGeriatri->rt_jangan_tinggalkan = $request->has('rt_jangan_tinggalkan') ? 1 : 0;
                $dataGeriatri->rt_dekat_nurse_station = $request->has('rt_dekat_nurse_station') ? 1 : 0;
            }

            // Update user yang mengupdate dan timestamp
            $dataGeriatri->user_updated = Auth::id();

            $dataGeriatri->save();

            DB::commit();

            return redirect()->route('rawat-inap.resiko-jatuh.geriatri.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data Skala Geriatri berhasil diupdate!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal mengupdate data: ' . $e->getMessage())->withInput();
        }
    }

    public function show($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
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

        // Hitung umur pasien
        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        // Ambil data geriatri berdasarkan ID
        $dataGeriatri = RmeSkalaGeriatri::with('userCreated')
            ->where('id', $id)
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->first();

        if (!$dataGeriatri) {
            abort(404, 'Data  tidak ditemukan');
        }

        return view('unit-pelayanan.rawat-inap.pelayanan.resiko-jatuh.skala-geriatri.show', compact(
            'dataMedis',
            'dataGeriatri'
        ));
    }

    public function destroy($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            // Cari data yang akan dihapus
            $dataGeriatri = RmeSkalaGeriatri::where('id', $id)
                ->where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->first();

            if (!$dataGeriatri) {
                return back()->with('error', 'Data tidak ditemukan!');
            }

            // Hapus data
            $dataGeriatri->delete();

            DB::commit();

            return redirect()->route('rawat-inap.resiko-jatuh.geriatri.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data Skala Geriatri berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

}
