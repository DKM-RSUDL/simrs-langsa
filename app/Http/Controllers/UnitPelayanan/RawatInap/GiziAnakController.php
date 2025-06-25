<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\RmeAlergiPasien;
use App\Models\RmeAsesmenGiziAnak;
use App\Models\RmeMonitoringGizi;
use App\Models\RmePengkajianGiziAnak;
use App\Models\RmePengkajianGiziAnakDtl;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GiziAnakController extends Controller
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
            $tab = $request->query('tab', 'anak');

            if ($tab == 'anak') {
                return $this->anakTab($dataMedis, $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
            } elseif ($tab == 'dewasa') {
                return $this->dewasaTab($dataMedis, $request);
            } elseif ($tab == 'monitoring') {
                return $this->monitoringTab($dataMedis, $request);
            } else {
                // Default ke tab anak jika tab tidak dikenali
                return $this->anakTab($dataMedis, $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    private function anakTab($dataMedis, $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        // Ambil data pengkajian gizi anak dengan relasi asesmen
        $dataPengkajianGizi = RmePengkajianGiziAnak::with(['asesmenGizi', 'userCreate'])
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->orderBy('waktu_asesmen', 'desc')
            ->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.gizi.anak.index', compact(
            'dataMedis',
            'dataPengkajianGizi'
        ));
    }

    private function dewasaTab($dataMedis, $request)
    {
        return view('unit-pelayanan.rawat-inap.pelayanan.gizi.dewasa.index', compact(
            'dataMedis'
        ));
    }

    private function monitoringTab($dataMedis, $request)
    {
        return view('unit-pelayanan.rawat-inap.pelayanan.gizi.monitoring.index', compact(
            'dataMedis'
        ));
    }

    public function create(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        
        $user = auth()->user();
        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();

        // Mengambil data kunjungan dan tanggal triase terkait
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
            ->first();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        $dataMedis->waktu_masuk = Carbon::parse($dataMedis->TGL_MASUK . ' ' . $dataMedis->JAM_MASUK)->format('Y-m-d H:i:s');

        return view('unit-pelayanan.rawat-inap.pelayanan.gizi.anak.create', compact(
            'kd_unit',
            'kd_pasien',
            'tgl_masuk',
            'urut_masuk',
            'dataMedis',
            'alergiPasien',
            'user'
        ));
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        DB::beginTransaction();

        try {

            $tanggal = $request->tanggal_masuk;
            $jam = $request->jam_masuk;
            $waktu_asesmen = $tanggal . ' ' . $jam;

            $dataGiziAnak = new RmePengkajianGiziAnak();
            $dataGiziAnak->kd_pasien = $kd_pasien;
            $dataGiziAnak->kd_unit = $kd_unit;
            $dataGiziAnak->tgl_masuk = $tgl_masuk;
            $dataGiziAnak->urut_masuk = $urut_masuk;
            $dataGiziAnak->waktu_asesmen = $waktu_asesmen;

            $dataGiziAnak->diagnosis_medis = $request->diagnosis_medis;
            $dataGiziAnak->makan_pagi = $request->makan_pagi;
            $dataGiziAnak->makan_siang = $request->makan_siang;
            $dataGiziAnak->makan_malam = $request->makan_malam;
            $dataGiziAnak->frekuensi_ngemil = $request->frekuensi_ngemil;
            $dataGiziAnak->alergi_makanan = $request->alergi_makanan;
            $dataGiziAnak->jenis_alergi = $request->jenis_alergi;
            $dataGiziAnak->pantangan_makanan = $request->pantangan_makanan;
            $dataGiziAnak->jenis_pantangan = $request->jenis_pantangan;

            // Gangguan GI - convert array to string
            $dataGiziAnak->gangguan_gi = is_array($request->gangguan_gi)
                ? implode(',', $request->gangguan_gi)
                : $request->gangguan_gi;

            $dataGiziAnak->frekuensi_makan_rs = $request->frekuensi_makan_rs;

            $dataGiziAnak->makanan_pokok = $request->makanan_pokok;
            $dataGiziAnak->lauk_hewani = $request->lauk_hewani;
            $dataGiziAnak->lauk_nabati = $request->lauk_nabati;
            $dataGiziAnak->sayuran = $request->sayuran;
            $dataGiziAnak->buah_buahan = $request->buah_buahan;
            $dataGiziAnak->minuman = $request->minuman;

            $dataGiziAnak->recall_makan_pagi = $request->recall_makan_pagi;
            $dataGiziAnak->recall_snack_pagi = $request->recall_snack_pagi;
            $dataGiziAnak->recall_makan_siang = $request->recall_makan_siang;
            $dataGiziAnak->recall_snack_sore = $request->recall_snack_sore;
            $dataGiziAnak->recall_makan_malam = $request->recall_makan_malam;
            $dataGiziAnak->recall_snack_malam = $request->recall_snack_malam;
            $dataGiziAnak->asupan_sebelum_rs = $request->asupan_sebelum_rs;

            $dataGiziAnak->diagnosa_gizi = $request->diagnosa_gizi;
            $dataGiziAnak->user_create = Auth::id();
            $dataGiziAnak->save();

            //Asesmen Gizi Anak
            $asesmenGiziAnak = new RmePengkajianGiziAnakDtl();
            $asesmenGiziAnak->id_gizi = $dataGiziAnak->id;
            $asesmenGiziAnak->berat_badan = $request->berat_badan;
            $asesmenGiziAnak->tinggi_badan = $request->tinggi_badan;
            $asesmenGiziAnak->imt = $request->imt;
            $asesmenGiziAnak->bbi = $request->bbi;
            $asesmenGiziAnak->status_gizi = $request->status_gizi;
            $asesmenGiziAnak->bb_usia = $request->bb_usia;
            $asesmenGiziAnak->bb_tb = $request->bb_tb;
            $asesmenGiziAnak->pb_tb_usia = $request->pb_tb_usia;
            $asesmenGiziAnak->imt_usia = $request->imt_usia;
            $asesmenGiziAnak->lingkar_kepala = $request->lingkar_kepala;
            $asesmenGiziAnak->biokimia = $request->biokimia;
            $asesmenGiziAnak->kimia_fisik = $request->kimia_fisik;
            $asesmenGiziAnak->riwayat_gizi = $request->riwayat_gizi;
            $asesmenGiziAnak->save();

            // Validasi data alergi
            $alergiData = json_decode($request->alergis, true);

            if (!empty($alergiData)) {
                // Hapus data alergi lama untuk pasien ini
                RmeAlergiPasien::where('kd_pasien', $kd_pasien)->delete();

                // Simpan data alergi baru
                foreach ($alergiData as $alergi) {
                    // Skip data yang sudah ada di database (is_existing = true) 
                    // kecuali jika ingin update
                    RmeAlergiPasien::create([
                        'kd_pasien' => $kd_pasien,
                        'jenis_alergi' => $alergi['jenis_alergi'],
                        'nama_alergi' => $alergi['alergen'],
                        'reaksi' => $alergi['reaksi'],
                        'tingkat_keparahan' => $alergi['tingkat_keparahan']
                    ]);
                }
            }


            DB::commit();

            return redirect()->to(url("unit-pelayanan/rawat-inap/unit/$kd_unit/pelayanan/$kd_pasien/$tgl_masuk/$urut_masuk/gizi/anak"))
                ->with('success', 'Data Pengkajian Gizi Anak berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan data asesmen' . $e->getMessage());
        }
    }

    public function edit($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataPengkajianGizi = RmePengkajianGiziAnak::with('asesmenGizi')
            ->where('id', $id)
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->firstOrFail();

        $user = auth()->user();
        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();

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
            ->firstOrFail();

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        return view('unit-pelayanan.rawat-inap.pelayanan.gizi.anak.edit', compact(
            'kd_unit',
            'kd_pasien',
            'tgl_masuk',
            'urut_masuk',
            'dataMedis',
            'dataPengkajianGizi',
            'alergiPasien',
            'user'
        ));
    }

    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            $dataPengkajianGizi = RmePengkajianGiziAnak::where('id', $id)
                ->where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->firstOrFail();

            $tanggal = $request->tanggal_masuk;
            $jam = $request->jam_masuk;
            $waktu_asesmen = $tanggal . ' ' . $jam;

            // Update data pengkajian gizi anak
            $dataPengkajianGizi->waktu_asesmen = $waktu_asesmen;
            $dataPengkajianGizi->diagnosis_medis = $request->diagnosis_medis;
            $dataPengkajianGizi->makan_pagi = $request->makan_pagi;
            $dataPengkajianGizi->makan_siang = $request->makan_siang;
            $dataPengkajianGizi->makan_malam = $request->makan_malam;
            $dataPengkajianGizi->frekuensi_ngemil = $request->frekuensi_ngemil;
            $dataPengkajianGizi->alergi_makanan = $request->alergi_makanan;
            $dataPengkajianGizi->jenis_alergi = $request->jenis_alergi;
            $dataPengkajianGizi->pantangan_makanan = $request->pantangan_makanan;
            $dataPengkajianGizi->jenis_pantangan = $request->jenis_pantangan;

            // Gangguan GI - convert array to string
            $dataPengkajianGizi->gangguan_gi = is_array($request->gangguan_gi)
                ? implode(',', $request->gangguan_gi)
                : $request->gangguan_gi;

            $dataPengkajianGizi->frekuensi_makan_rs = $request->frekuensi_makan_rs;
            $dataPengkajianGizi->makanan_pokok = $request->makanan_pokok;
            $dataPengkajianGizi->lauk_hewani = $request->lauk_hewani;
            $dataPengkajianGizi->lauk_nabati = $request->lauk_nabati;
            $dataPengkajianGizi->sayuran = $request->sayuran;
            $dataPengkajianGizi->buah_buahan = $request->buah_buahan;
            $dataPengkajianGizi->minuman = $request->minuman;
            $dataPengkajianGizi->recall_makan_pagi = $request->recall_makan_pagi;
            $dataPengkajianGizi->recall_snack_pagi = $request->recall_snack_pagi;
            $dataPengkajianGizi->recall_makan_siang = $request->recall_makan_siang;
            $dataPengkajianGizi->recall_snack_sore = $request->recall_snack_sore;
            $dataPengkajianGizi->recall_makan_malam = $request->recall_makan_malam;
            $dataPengkajianGizi->recall_snack_malam = $request->recall_snack_malam;
            $dataPengkajianGizi->asupan_sebelum_rs = $request->asupan_sebelum_rs;
            $dataPengkajianGizi->diagnosa_gizi = $request->diagnosa_gizi;
            $dataPengkajianGizi->user_update = Auth::id();
            $dataPengkajianGizi->save();

            // Update asesmen gizi anak
            $asesmenGiziAnak = RmePengkajianGiziAnakDtl::where('id_gizi', $id)->first();
            if ($asesmenGiziAnak) {
                $asesmenGiziAnak->berat_badan = $request->berat_badan;
                $asesmenGiziAnak->tinggi_badan = $request->tinggi_badan;
                $asesmenGiziAnak->imt = $request->imt;
                $asesmenGiziAnak->bbi = $request->bbi;
                $asesmenGiziAnak->status_gizi = $request->status_gizi;
                $asesmenGiziAnak->bb_usia = $request->bb_usia;
                $asesmenGiziAnak->bb_tb = $request->bb_tb;
                $asesmenGiziAnak->pb_tb_usia = $request->pb_tb_usia;
                $asesmenGiziAnak->imt_usia = $request->imt_usia;
                $asesmenGiziAnak->lingkar_kepala = $request->lingkar_kepala;
                $asesmenGiziAnak->biokimia = $request->biokimia;
                $asesmenGiziAnak->kimia_fisik = $request->kimia_fisik;
                $asesmenGiziAnak->riwayat_gizi = $request->riwayat_gizi;
                $asesmenGiziAnak->save();
            }

            // Update data alergi
            $alergiData = json_decode($request->alergis, true);

            if (!empty($alergiData)) {
                // Hapus data alergi lama untuk pasien ini
                RmeAlergiPasien::where('kd_pasien', $kd_pasien)->delete();

                // Simpan data alergi baru
                foreach ($alergiData as $alergi) {
                    RmeAlergiPasien::create([
                        'kd_pasien' => $kd_pasien,
                        'jenis_alergi' => $alergi['jenis_alergi'],
                        'nama_alergi' => $alergi['alergen'],
                        'reaksi' => $alergi['reaksi'],
                        'tingkat_keparahan' => $alergi['tingkat_keparahan']
                    ]);
                }
            }

            DB::commit();

            return redirect()->to(url("unit-pelayanan/rawat-inap/unit/$kd_unit/pelayanan/$kd_pasien/$tgl_masuk/$urut_masuk/gizi/anak"))
                ->with('success', 'Data Pengkajian Gizi Anak berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            $dataPengkajianGizi = RmePengkajianGiziAnak::where('id', $id)
                ->where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->firstOrFail();

            // Hapus data asesmen gizi terkait
            RmePengkajianGiziAnakDtl::where('id_gizi', $id)->delete();

            // Hapus data pengkajian gizi
            $dataPengkajianGizi->delete();

            DB::commit();

            return redirect()->to(url("unit-pelayanan/rawat-inap/unit/$kd_unit/pelayanan/$kd_pasien/$tgl_masuk/$urut_masuk/gizi/anak"))
                ->with('success', 'Data Pengkajian Gizi Anak berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function show($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataPengkajianGizi = RmePengkajianGiziAnak::with(['asesmenGizi', 'userCreate'])
            ->where('id', $id)
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->firstOrFail();

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
            ->firstOrFail();

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        // Ambil data monitoring gizi
        $monitoringGizi = RmeMonitoringGizi::where('kd_unit', $kd_unit)
            ->where('kd_pasien', $kd_pasien)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->orderBy('tanggal_monitoring', 'desc') 
            ->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.gizi.anak.show', compact(
            'dataPengkajianGizi',
            'dataMedis',
            'monitoringGizi'
        ));
    }

}
