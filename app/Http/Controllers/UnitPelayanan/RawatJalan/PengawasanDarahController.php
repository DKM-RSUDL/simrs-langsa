<?php

namespace App\Http\Controllers\UnitPelayanan\RawatJalan;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\HrdKaryawan;
use App\Models\Kunjungan;
use App\Models\RmePengelolaanDarahTab1;
use App\Models\RmePengelolaanDarahTab2;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PengawasanDarahController extends Controller
{
    public function index(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        try {
            $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
                ->join('transaksi as t', function ($join) {
                    $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                    $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                    $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                    $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
                })
                ->leftJoin('dokter', 'kunjungan.KD_DOKTER', '=', 'dokter.KD_DOKTER')
                ->select('kunjungan.*', 't.*', 'dokter.NAMA as nama_dokter')
                ->where('kunjungan.kd_unit', $kd_unit)
                ->where('kunjungan.kd_pasien', $kd_pasien)
                ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
                ->where('kunjungan.urut_masuk', $urut_masuk)
                ->first();

            if (!$dataMedis) {
                abort(404, 'Data medis tidak ditemukan');
            }

            // Set umur pasien
            if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
                $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
            } else {
                $dataMedis->pasien->umur = 'Tidak Diketahui';
            }

            // Handle tabs
            $tab = $request->query('tab', 'pengelolaan'); // default ke monitoring

            if ($tab == 'pengelolaan') {
                return $this->pengelolaanTab($dataMedis, $request);
            } else {
                return $this->monitoringTab($dataMedis, $request);
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    private function monitoringTab($dataMedis, $request)
    {
        try {
            // Ambil data monitoring transfusi darah
            $monitoringDarah = RmePengelolaanDarahTab2::with(['dokterRelation', 'perawatRelation'])
                ->where('kd_unit', $dataMedis->kd_unit)
                ->where('kd_pasien', $dataMedis->kd_pasien)
                ->where('tgl_masuk', $dataMedis->tgl_masuk)
                ->where('urut_masuk', $dataMedis->urut_masuk)
                ->orderBy('tanggal', 'desc')
                ->orderBy('jam', 'desc')
                ->paginate(10);

            return view('unit-pelayanan.rawat-jalan.pelayanan.pengawasan-darah.monitoring', compact(
                'dataMedis',
                'monitoringDarah'
            ));
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat memuat data monitoring: ' . $e->getMessage());
        }
    }

    private function pengelolaanTab($dataMedis, $request)
    {
        try {
            // Build query untuk data pengelolaan tanpa filter
            $pengelolaanDarah = RmePengelolaanDarahTab1::with(['petugas1', 'petugas2'])
                ->where('kd_unit', $dataMedis->kd_unit)
                ->where('kd_pasien', $dataMedis->kd_pasien)
                ->where('tgl_masuk', $dataMedis->tgl_masuk)
                ->where('urut_masuk', $dataMedis->urut_masuk)
                ->orderBy('tanggal', 'desc')
                ->orderBy('jam', 'desc')
                ->paginate(10);

            return view('unit-pelayanan.rawat-jalan.pelayanan.pengawasan-darah.pengelolaan', compact(
                'dataMedis',
                'pengelolaanDarah'
            ));
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat memuat data pengelolaan: ' . $e->getMessage());
        }
    }

    public function createPengelolaan(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        try {

            $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
                ->join('transaksi as t', function ($join) {
                    $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                    $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                    $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                    $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
                })
                ->leftJoin('dokter', 'kunjungan.KD_DOKTER', '=', 'dokter.KD_DOKTER')
                ->select('kunjungan.*', 't.*', 'dokter.NAMA as nama_dokter')
                ->where('kunjungan.kd_unit', $kd_unit)
                ->where('kunjungan.kd_pasien', $kd_pasien)
                ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
                ->where('kunjungan.urut_masuk', $urut_masuk)
                ->first();

            if (!$dataMedis) {
                abort(404, 'Data medis tidak ditemukan');
            }

            // Set umur pasien
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


            return view('unit-pelayanan.rawat-jalan.pelayanan.pengawasan-darah.pengelolaan.create', compact(
                'dataMedis',
                'dokter',
                'perawat'

            ));
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function storePengelolaan(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {

        DB::beginTransaction();

        try {
            // Verifikasi data medis exists
            $dataMedis = Kunjungan::where('kd_unit', $kd_unit)
                ->where('kd_pasien', $kd_pasien)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->first();

            if (!$dataMedis) {
                throw new \Exception('Data medis tidak ditemukan');
            }

            // Create main dataPengelolaan record
            $dataPengelolaan = new RmePengelolaanDarahTab1();
            $dataPengelolaan->kd_unit = $kd_unit;
            $dataPengelolaan->kd_pasien = $kd_pasien;
            $dataPengelolaan->tgl_masuk = $tgl_masuk;
            $dataPengelolaan->urut_masuk = $urut_masuk;
            $dataPengelolaan->tanggal = $request->tanggal;
            $dataPengelolaan->jam = $request->jam;
            $dataPengelolaan->transfusi_ke = $request->transfusi_ke;
            $dataPengelolaan->nomor_seri_kantong = $request->nomor_seri_kantong;
            $dataPengelolaan->riwayat_alergi_sebelumnya = $request->riwayat_alergi_sebelumnya;
            $dataPengelolaan->riwayat_komponen_sesuai = $request->riwayat_komponen_sesuai;
            $dataPengelolaan->identitas_label_sesuai = $request->identitas_label_sesuai;
            $dataPengelolaan->golongan_darah_sesuai = $request->golongan_darah_sesuai;
            $dataPengelolaan->volume_sesuai = $request->volume_sesuai;
            $dataPengelolaan->kantong_utuh = $request->kantong_utuh;
            $dataPengelolaan->tidak_expired = $request->tidak_expired;
            $dataPengelolaan->petugas_1 = $request->petugas_1;
            $dataPengelolaan->petugas_2 = $request->petugas_2;
            $dataPengelolaan->user_create = Auth::user()->id;
            $dataPengelolaan->save();

            DB::commit();

            return redirect()->route('rawat-jalan.pengawasan-darah.index', [
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk
            ])->with('success', 'Data pengelolaan pengawasan darah berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }


    public function showPengelolaan(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
                ->join('transaksi as t', function ($join) {
                    $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                    $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                    $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                    $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
                })
                ->leftJoin('dokter', 'kunjungan.KD_DOKTER', '=', 'dokter.KD_DOKTER')
                ->select('kunjungan.*', 't.*', 'dokter.NAMA as nama_dokter')
                ->where('kunjungan.kd_unit', $kd_unit)
                ->where('kunjungan.kd_pasien', $kd_pasien)
                ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
                ->where('kunjungan.urut_masuk', $urut_masuk)
                ->first();

            if (!$dataMedis) {
                abort(404, 'Data medis tidak ditemukan');
            }

            // Set umur pasien
            if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
                $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
            } else {
                $dataMedis->pasien->umur = 'Tidak Diketahui';
            }

            // Ambil data pengelolaan
            $pengelolaan = RmePengelolaanDarahTab1::with(['petugas1', 'petugas2'])
                ->where('id', $id)
                ->where('kd_unit', $kd_unit)
                ->where('kd_pasien', $kd_pasien)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->first();

            if (!$pengelolaan) {
                abort(404, 'Data pengelolaan tidak ditemukan');
            }

            return view('unit-pelayanan.rawat-jalan.pelayanan.pengawasan-darah.pengelolaan.show', compact(
                'dataMedis',
                'pengelolaan'
            ));
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function editPengelolaan(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
                ->join('transaksi as t', function ($join) {
                    $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                    $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                    $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                    $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
                })
                ->leftJoin('dokter', 'kunjungan.KD_DOKTER', '=', 'dokter.KD_DOKTER')
                ->select('kunjungan.*', 't.*', 'dokter.NAMA as nama_dokter')
                ->where('kunjungan.kd_unit', $kd_unit)
                ->where('kunjungan.kd_pasien', $kd_pasien)
                ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
                ->where('kunjungan.urut_masuk', $urut_masuk)
                ->first();

            if (!$dataMedis) {
                abort(404, 'Data medis tidak ditemukan');
            }

            // Set umur pasien
            if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
                $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
            } else {
                $dataMedis->pasien->umur = 'Tidak Diketahui';
            }

            // Ambil data pengelolaan
            $pengelolaan = RmePengelolaanDarahTab1::where('id', $id)
                ->where('kd_unit', $kd_unit)
                ->where('kd_pasien', $kd_pasien)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->first();

            if (!$pengelolaan) {
                abort(404, 'Data pengelolaan tidak ditemukan');
            }

            $dokter = Dokter::where('status', 1)
                ->select('kd_dokter', 'nama')
                ->get();

            $perawat = HrdKaryawan::where('kd_jenis_tenaga', 2)
                ->where('kd_detail_jenis_tenaga', 1)
                ->where('status_peg', 1)
                ->get();

            return view('unit-pelayanan.rawat-jalan.pelayanan.pengawasan-darah.pengelolaan.edit', compact(
                'dataMedis',
                'pengelolaan',
                'dokter',
                'perawat'
            ));
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function updatePengelolaan(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            // Verifikasi data medis exists
            $dataMedis = Kunjungan::where('kd_unit', $kd_unit)
                ->where('kd_pasien', $kd_pasien)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->first();

            if (!$dataMedis) {
                throw new \Exception('Data medis tidak ditemukan');
            }

            // Ambil data pengelolaan
            $dataPengelolaan = RmePengelolaanDarahTab1::where('id', $id)
                ->where('kd_unit', $kd_unit)
                ->where('kd_pasien', $kd_pasien)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->first();

            if (!$dataPengelolaan) {
                throw new \Exception('Data pengelolaan tidak ditemukan');
            }

            // Update data pengelolaan
            $dataPengelolaan->tanggal = $request->tanggal;
            $dataPengelolaan->jam = $request->jam;
            $dataPengelolaan->transfusi_ke = $request->transfusi_ke;
            $dataPengelolaan->nomor_seri_kantong = $request->nomor_seri_kantong;
            $dataPengelolaan->riwayat_alergi_sebelumnya = $request->riwayat_alergi_sebelumnya;
            $dataPengelolaan->riwayat_komponen_sesuai = $request->riwayat_komponen_sesuai;
            $dataPengelolaan->identitas_label_sesuai = $request->identitas_label_sesuai;
            $dataPengelolaan->golongan_darah_sesuai = $request->golongan_darah_sesuai;
            $dataPengelolaan->volume_sesuai = $request->volume_sesuai;
            $dataPengelolaan->kantong_utuh = $request->kantong_utuh;
            $dataPengelolaan->tidak_expired = $request->tidak_expired;
            $dataPengelolaan->petugas_1 = $request->petugas_1;
            $dataPengelolaan->petugas_2 = $request->petugas_2;
            $dataPengelolaan->user_update = Auth::user()->id;
            $dataPengelolaan->save();

            DB::commit();

            return redirect()->route('rawat-jalan.pengawasan-darah.index', [
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk
            ])->with('success', 'Data pengelolaan pengawasan darah berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroyPengelolaan(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            // Verifikasi data medis exists
            $dataMedis = Kunjungan::where('kd_unit', $kd_unit)
                ->where('kd_pasien', $kd_pasien)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->first();

            if (!$dataMedis) {
                throw new \Exception('Data medis tidak ditemukan');
            }

            // Ambil data pengelolaan
            $dataPengelolaan = RmePengelolaanDarahTab1::where('id', $id)
                ->where('kd_unit', $kd_unit)
                ->where('kd_pasien', $kd_pasien)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->first();

            if (!$dataPengelolaan) {
                throw new \Exception('Data pengelolaan tidak ditemukan');
            }

            // Hapus data
            $dataPengelolaan->delete();

            DB::commit();

            return redirect()->route('rawat-jalan.pengawasan-darah.index', [
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk
            ])->with('success', 'Data pengelolaan pengawasan darah berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }



    public function createMonitoring(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        try {
            $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
                ->join('transaksi as t', function ($join) {
                    $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                    $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                    $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                    $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
                })
                ->leftJoin('dokter', 'kunjungan.KD_DOKTER', '=', 'dokter.KD_DOKTER')
                ->select('kunjungan.*', 't.*', 'dokter.NAMA as nama_dokter')
                ->where('kunjungan.kd_unit', $kd_unit)
                ->where('kunjungan.kd_pasien', $kd_pasien)
                ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
                ->where('kunjungan.urut_masuk', $urut_masuk)
                ->first();

            if (!$dataMedis) {
                abort(404, 'Data medis tidak ditemukan');
            }

            // Set umur pasien
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

            return view('unit-pelayanan.rawat-jalan.pelayanan.pengawasan-darah.monitoring.create', compact(
                'dataMedis',
                'dokter',
                'perawat'
            ));
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function storeMonitoring(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        DB::beginTransaction();

        try {
            // Verifikasi data medis exists
            $dataMedis = Kunjungan::where('kd_unit', $kd_unit)
                ->where('kd_pasien', $kd_pasien)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->first();

            if (!$dataMedis) {
                throw new \Exception('Data medis tidak ditemukan');
            }

            // Validasi jam mulai dan selesai transfusi
            $jamMulai = \Carbon\Carbon::parse($request->jam_mulai_transfusi);
            $jamSelesai = \Carbon\Carbon::parse($request->jam_selesai_transfusi);

            if ($jamSelesai <= $jamMulai) {
                throw new \Exception('Jam selesai transfusi harus lebih besar dari jam mulai transfusi');
            }

            // Create monitoring record - sesuaikan dengan nama model monitoring Anda
            $dataMonitoring = new RmePengelolaanDarahTab2(); // Ganti dengan nama model yang sesuai
            $dataMonitoring->kd_unit = $kd_unit;
            $dataMonitoring->kd_pasien = $kd_pasien;
            $dataMonitoring->tgl_masuk = $tgl_masuk;
            $dataMonitoring->urut_masuk = $urut_masuk;

            // Informasi dasar
            $dataMonitoring->tanggal = $request->tanggal;
            $dataMonitoring->jam = $request->jam;

            // 15 menit sebelum transfusi
            $dataMonitoring->pre_td_sistole = $request->pre_td_sistole;
            $dataMonitoring->pre_td_diastole = $request->pre_td_diastole;
            $dataMonitoring->pre_nadi = $request->pre_nadi;
            $dataMonitoring->pre_temp = $request->pre_temp;
            $dataMonitoring->pre_rr = $request->pre_rr;

            // Jam transfusi
            $dataMonitoring->jam_mulai_transfusi = $request->jam_mulai_transfusi;
            $dataMonitoring->jam_selesai_transfusi = $request->jam_selesai_transfusi;

            // 15 menit setelah darah masuk
            $dataMonitoring->post15_td_sistole = $request->post15_td_sistole;
            $dataMonitoring->post15_td_diastole = $request->post15_td_diastole;
            $dataMonitoring->post15_nadi = $request->post15_nadi;
            $dataMonitoring->post15_temp = $request->post15_temp;
            $dataMonitoring->post15_rr = $request->post15_rr;

            // 1 jam setelah darah masuk
            $dataMonitoring->post1h_td_sistole = $request->post1h_td_sistole;
            $dataMonitoring->post1h_td_diastole = $request->post1h_td_diastole;
            $dataMonitoring->post1h_nadi = $request->post1h_nadi;
            $dataMonitoring->post1h_temp = $request->post1h_temp;
            $dataMonitoring->post1h_rr = $request->post1h_rr;

            // 4 jam setelah transfusi
            $dataMonitoring->post4h_td_sistole = $request->post4h_td_sistole;
            $dataMonitoring->post4h_td_diastole = $request->post4h_td_diastole;
            $dataMonitoring->post4h_nadi = $request->post4h_nadi;
            $dataMonitoring->post4h_temp = $request->post4h_temp;
            $dataMonitoring->post4h_rr = $request->post4h_rr;

            // Reaksi transfusi
            $dataMonitoring->reaksi_selama_transfusi = $request->reaksi_selama_transfusi;
            $dataMonitoring->reaksi_transfusi = $request->reaksi_transfusi;

            // Petugas
            $dataMonitoring->dokter = $request->dokter;
            $dataMonitoring->perawat = $request->perawat;
            $dataMonitoring->user_create = Auth::user()->id;
            $dataMonitoring->save();

            DB::commit();

            return redirect()->route('rawat-jalan.pengawasan-darah.index', [
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
                'tab' => 'monitoring'
            ])->with('success', 'Data monitoring transfusi darah berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    public function editMonitoring(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
                ->join('transaksi as t', function ($join) {
                    $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                    $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                    $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                    $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
                })
                ->leftJoin('dokter', 'kunjungan.KD_DOKTER', '=', 'dokter.KD_DOKTER')
                ->select('kunjungan.*', 't.*', 'dokter.NAMA as nama_dokter')
                ->where('kunjungan.kd_unit', $kd_unit)
                ->where('kunjungan.kd_pasien', $kd_pasien)
                ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
                ->where('kunjungan.urut_masuk', $urut_masuk)
                ->first();

            if (!$dataMedis) {
                abort(404, 'Data medis tidak ditemukan');
            }

            // Set umur pasien
            if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
                $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
            } else {
                $dataMedis->pasien->umur = 'Tidak Diketahui';
            }

            // Ambil data monitoring
            $monitoring = RmePengelolaanDarahTab2::where('id', $id)
                ->where('kd_unit', $kd_unit)
                ->where('kd_pasien', $kd_pasien)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->first();

            if (!$monitoring) {
                abort(404, 'Data monitoring tidak ditemukan');
            }

            $dokter = Dokter::where('status', 1)
                ->select('kd_dokter', 'nama')
                ->get();

            $perawat = HrdKaryawan::where('kd_jenis_tenaga', 2)
                ->where('kd_detail_jenis_tenaga', 1)
                ->where('status_peg', 1)
                ->get();

            return view('unit-pelayanan.rawat-jalan.pelayanan.pengawasan-darah.monitoring.edit', compact(
                'dataMedis',
                'monitoring',
                'dokter',
                'perawat'
            ));
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function updateMonitoring(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            // Verifikasi data medis exists
            $dataMedis = Kunjungan::where('kd_unit', $kd_unit)
                ->where('kd_pasien', $kd_pasien)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->first();

            if (!$dataMedis) {
                throw new \Exception('Data medis tidak ditemukan');
            }

            // Ambil data monitoring
            $dataMonitoring = RmePengelolaanDarahTab2::where('id', $id)
                ->where('kd_unit', $kd_unit)
                ->where('kd_pasien', $kd_pasien)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->first();

            if (!$dataMonitoring) {
                throw new \Exception('Data monitoring tidak ditemukan');
            }

            // Validasi jam mulai dan selesai transfusi
            $jamMulai = \Carbon\Carbon::parse($request->jam_mulai_transfusi);
            $jamSelesai = \Carbon\Carbon::parse($request->jam_selesai_transfusi);

            if ($jamSelesai <= $jamMulai) {
                throw new \Exception('Jam selesai transfusi harus lebih besar dari jam mulai transfusi');
            }

            // Update data monitoring
            // Informasi dasar
            $dataMonitoring->tanggal = $request->tanggal;
            $dataMonitoring->jam = $request->jam;

            // 15 menit sebelum transfusi
            $dataMonitoring->pre_td_sistole = $request->pre_td_sistole;
            $dataMonitoring->pre_td_diastole = $request->pre_td_diastole;
            $dataMonitoring->pre_nadi = $request->pre_nadi;
            $dataMonitoring->pre_temp = $request->pre_temp;
            $dataMonitoring->pre_rr = $request->pre_rr;

            // Jam transfusi
            $dataMonitoring->jam_mulai_transfusi = $request->jam_mulai_transfusi;
            $dataMonitoring->jam_selesai_transfusi = $request->jam_selesai_transfusi;

            // 15 menit setelah darah masuk
            $dataMonitoring->post15_td_sistole = $request->post15_td_sistole;
            $dataMonitoring->post15_td_diastole = $request->post15_td_diastole;
            $dataMonitoring->post15_nadi = $request->post15_nadi;
            $dataMonitoring->post15_temp = $request->post15_temp;
            $dataMonitoring->post15_rr = $request->post15_rr;

            // 1 jam setelah darah masuk
            $dataMonitoring->post1h_td_sistole = $request->post1h_td_sistole;
            $dataMonitoring->post1h_td_diastole = $request->post1h_td_diastole;
            $dataMonitoring->post1h_nadi = $request->post1h_nadi;
            $dataMonitoring->post1h_temp = $request->post1h_temp;
            $dataMonitoring->post1h_rr = $request->post1h_rr;

            // 4 jam setelah transfusi
            $dataMonitoring->post4h_td_sistole = $request->post4h_td_sistole;
            $dataMonitoring->post4h_td_diastole = $request->post4h_td_diastole;
            $dataMonitoring->post4h_nadi = $request->post4h_nadi;
            $dataMonitoring->post4h_temp = $request->post4h_temp;
            $dataMonitoring->post4h_rr = $request->post4h_rr;

            // Reaksi transfusi
            $dataMonitoring->reaksi_selama_transfusi = $request->reaksi_selama_transfusi;
            $dataMonitoring->reaksi_transfusi = $request->reaksi_transfusi;

            // Petugas
            $dataMonitoring->dokter = $request->dokter;
            $dataMonitoring->perawat = $request->perawat;
            $dataMonitoring->user_update = Auth::user()->id;
            $dataMonitoring->save();

            DB::commit();

            return redirect()->route('rawat-jalan.pengawasan-darah.index', [
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
                'tab' => 'monitoring'
            ])->with('success', 'Data monitoring transfusi darah berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }

    public function showMonitoring(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
                ->join('transaksi as t', function ($join) {
                    $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                    $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                    $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                    $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
                })
                ->leftJoin('dokter', 'kunjungan.KD_DOKTER', '=', 'dokter.KD_DOKTER')
                ->select('kunjungan.*', 't.*', 'dokter.NAMA as nama_dokter')
                ->where('kunjungan.kd_unit', $kd_unit)
                ->where('kunjungan.kd_pasien', $kd_pasien)
                ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
                ->where('kunjungan.urut_masuk', $urut_masuk)
                ->first();

            if (!$dataMedis) {
                abort(404, 'Data medis tidak ditemukan');
            }

            // Set umur pasien
            if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
                $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
            } else {
                $dataMedis->pasien->umur = 'Tidak Diketahui';
            }

            // Ambil data monitoring dengan relasi dokter dan perawat
            $monitoring = RmePengelolaanDarahTab2::with(['dokterRelation', 'perawatRelation'])
                ->where('id', $id)
                ->where('kd_unit', $kd_unit)
                ->where('kd_pasien', $kd_pasien)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->first();

            if (!$monitoring) {
                abort(404, 'Data monitoring tidak ditemukan');
            }

            return view('unit-pelayanan.rawat-jalan.pelayanan.pengawasan-darah.monitoring.show', compact(
                'dataMedis',
                'monitoring'
            ));
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroyMonitoring(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            // Verifikasi data medis exists
            $dataMedis = Kunjungan::where('kd_unit', $kd_unit)
                ->where('kd_pasien', $kd_pasien)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->first();

            if (!$dataMedis) {
                throw new \Exception('Data medis tidak ditemukan');
            }

            // Ambil data monitoring
            $dataMonitoring = RmePengelolaanDarahTab2::where('id', $id)
                ->where('kd_unit', $kd_unit)
                ->where('kd_pasien', $kd_pasien)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->first();

            if (!$dataMonitoring) {
                throw new \Exception('Data monitoring tidak ditemukan');
            }

            // Hapus data
            $dataMonitoring->delete();

            DB::commit();

            return redirect()->route('rawat-jalan.pengawasan-darah.index', [
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
                'tab' => 'monitoring',
            ])->with('success', 'Data monitoring transfusi darah berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }

    public function printPengawasanDarah(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        try {
            $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
                ->join('transaksi as t', function ($join) {
                    $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                    $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                    $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                    $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
                })
                ->leftJoin('dokter', 'kunjungan.KD_DOKTER', '=', 'dokter.KD_DOKTER')
                ->select('kunjungan.*', 't.*', 'dokter.NAMA as nama_dokter')
                ->where('kunjungan.kd_unit', $kd_unit)
                ->where('kunjungan.kd_pasien', $kd_pasien)
                ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
                ->where('kunjungan.urut_masuk', $urut_masuk)
                ->first();

            if (!$dataMedis) {
                abort(404, 'Data medis tidak ditemukan');
            }

            // Set umur pasien
            if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
                $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
            } else {
                $dataMedis->pasien->umur = 'Tidak Diketahui';
            }

            // Ambil data pengelolaan
            $pengelolaanDarah = RmePengelolaanDarahTab1::with(['petugas1', 'petugas2'])
                ->where('kd_unit', $dataMedis->kd_unit)
                ->where('kd_pasien', $dataMedis->kd_pasien)
                ->where('tgl_masuk', $dataMedis->tgl_masuk)
                ->where('urut_masuk', $dataMedis->urut_masuk)
                ->orderBy('tanggal', 'asc')
                ->orderBy('jam', 'asc')
                ->get();

            // Ambil data monitoring
            $monitoringDarah = RmePengelolaanDarahTab2::with(['dokterRelation', 'perawatRelation'])
                ->where('kd_unit', $dataMedis->kd_unit)
                ->where('kd_pasien', $dataMedis->kd_pasien)
                ->where('tgl_masuk', $dataMedis->tgl_masuk)
                ->where('urut_masuk', $dataMedis->urut_masuk)
                ->orderBy('tanggal', 'asc')
                ->orderBy('jam', 'asc')
                ->get();

            // Logo path
            $logoPath = public_path('assets/img/Logo-RSUD-Langsa-1.png');

            // Generate PDF
            $pdf = Pdf::loadView('unit-pelayanan.rawat-jalan.pelayanan.pengawasan-darah.print', compact(
                'dataMedis',
                'pengelolaanDarah',
                'monitoringDarah',
                'logoPath'
            ));

            $pdf->setPaper('A4', 'landscape');

            $fileName = 'Pengawasan_Darah_' . $dataMedis->kd_pasien . '_' . date('Y-m-d', strtotime($dataMedis->tgl_masuk)) . '.pdf';

            return $pdf->stream($fileName);
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mencetak: ' . $e->getMessage());
        }
    }
}
