<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\RmeAlergiPasien;
use App\Models\RmeAsesmenGiziAnak;
use App\Models\RmeMonitoringGizi;
use App\Models\RmePengkajianGiziAnak;
use App\Models\RmePengkajianGiziAnakDtl;
use App\Models\RmePengkajianIntervensiGiziAnak;
use App\Models\WhoBmiForAge;
use App\Models\WhoHeadCircumferenceForAge;
use App\Models\WhoHeightForAge;
use App\Models\WhoWeightForAge;
use App\Models\WhoWeightForHeight;
use App\Models\WhoWeightForLength;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        $WhoWeightForAge = WhoWeightForAge::all();
        $WhoHeightForAge = WhoHeightForAge::all();
        $WhoBmiForAge = WhoBmiForAge::all();
        $WhoWeightForHeight = WhoWeightForHeight::all();
        $WhoWeightForLength = WhoWeightForLength::all();
        $WhoHeadCircumferenceForAge = WhoHeadCircumferenceForAge::all();

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
            'WhoBmiForAge',
            'WhoHeadCircumferenceForAge',
            'WhoHeightForAge',
            'WhoWeightForAge',
            'WhoWeightForHeight',
            'WhoWeightForLength',
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
            $asesmenGiziAnak->status_stunting = $request->status_stunting;
            $asesmenGiziAnak->lingkar_kepala = $request->lingkar_kepala;
            $asesmenGiziAnak->biokimia = $request->biokimia;
            $asesmenGiziAnak->kimia_fisik = $request->kimia_fisik;
            $asesmenGiziAnak->riwayat_gizi = $request->riwayat_gizi;
            $asesmenGiziAnak->save();

            $intervensiGizi = new RmePengkajianIntervensiGiziAnak();
            $intervensiGizi->id_gizi = $dataGiziAnak->id;
            $intervensiGizi->mode_perhitungan = $request->mode_perhitungan;
            $intervensiGizi->golongan_umur = $request->golongan_umur; 
            $intervensiGizi->rentang_kalori = $request->rentang_kalori; 
            $intervensiGizi->kebutuhan_kalori_per_kg = $request->kebutuhan_kalori_per_kg; 
            $intervensiGizi->total_kebutuhan_kalori = $request->total_kebutuhan_kalori; 
            $intervensiGizi->protein_persen = $request->protein_persen; 
            $intervensiGizi->lemak_persen = $request->lemak_persen; 
            $intervensiGizi->kh_persen = $request->kh_persen; 
            $intervensiGizi->protein_gram_per_kg = $request->protein_gram_per_kg; 
            $intervensiGizi->lemak_gram_per_kg = $request->lemak_gram_per_kg; 
            $intervensiGizi->kh_gram_per_kg = $request->kh_gram_per_kg; 
            $intervensiGizi->protein_gram_total = $request->protein_gram_total; 
            $intervensiGizi->lemak_gram_total = $request->lemak_gram_total; 
            $intervensiGizi->kh_gram_total = $request->kh_gram_total; 
            $intervensiGizi->protein_gram = $request->protein_gram; 
            $intervensiGizi->lemak_gram = $request->lemak_gram; 
            $intervensiGizi->kh_gram = $request->kh_gram; 
            $intervensiGizi->save();

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
        $WhoWeightForAge = WhoWeightForAge::all();
        $WhoHeightForAge = WhoHeightForAge::all();
        $WhoBmiForAge = WhoBmiForAge::all();
        $WhoWeightForHeight = WhoWeightForHeight::all();
        $WhoWeightForLength = WhoWeightForLength::all();
        $WhoHeadCircumferenceForAge = WhoHeadCircumferenceForAge::all();

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
            'WhoBmiForAge',
            'WhoHeightForAge',
            'WhoWeightForAge',
            'WhoWeightForHeight',
            'WhoWeightForLength',
            'WhoHeadCircumferenceForAge',
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
                $asesmenGiziAnak->status_stunting = $request->status_stunting;
                $asesmenGiziAnak->lingkar_kepala = $request->lingkar_kepala;
                $asesmenGiziAnak->biokimia = $request->biokimia;
                $asesmenGiziAnak->kimia_fisik = $request->kimia_fisik;
                $asesmenGiziAnak->riwayat_gizi = $request->riwayat_gizi;
                $asesmenGiziAnak->save();
            }

            // Update data intervensi gizi
            $intervensiGizi = RmePengkajianIntervensiGiziAnak::where('id_gizi', $id)->first();
            if ($intervensiGizi) {
                $intervensiGizi->mode_perhitungan = $request->mode_perhitungan;
                $intervensiGizi->golongan_umur = $request->golongan_umur;
                $intervensiGizi->rentang_kalori = $request->rentang_kalori;
                $intervensiGizi->kebutuhan_kalori_per_kg = $request->kebutuhan_kalori_per_kg;
                $intervensiGizi->total_kebutuhan_kalori = $request->total_kebutuhan_kalori;
                $intervensiGizi->protein_persen = $request->protein_persen;
                $intervensiGizi->lemak_persen = $request->lemak_persen;
                $intervensiGizi->kh_persen = $request->kh_persen;
                $intervensiGizi->protein_gram_per_kg = $request->protein_gram_per_kg;
                $intervensiGizi->lemak_gram_per_kg = $request->lemak_gram_per_kg;
                $intervensiGizi->kh_gram_per_kg = $request->kh_gram_per_kg;
                $intervensiGizi->protein_gram_total = $request->protein_gram_total;
                $intervensiGizi->lemak_gram_total = $request->lemak_gram_total;
                $intervensiGizi->kh_gram_total = $request->kh_gram_total;
                $intervensiGizi->protein_gram = $request->protein_gram;
                $intervensiGizi->lemak_gram = $request->lemak_gram;
                $intervensiGizi->kh_gram = $request->kh_gram;
                $intervensiGizi->save();
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

            // Hapus data intervensi gizi terkait
            RmePengkajianIntervensiGiziAnak::where('id_gizi', $id)->delete();

            // Hapus data alergi pasien
            RmeAlergiPasien::where('kd_pasien', $kd_pasien)->delete();

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
        // Ambil data pengkajian gizi anak dengan semua relasi
        $dataPengkajianGizi = RmePengkajianGiziAnak::with([
            'asesmenGizi',
            'intervensiGizi', 
            'userCreate',
            'userUpdate'        
        ])
            ->where('id', $id)
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->firstOrFail();

        // Ambil data medis pasien
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

        // Hitung umur pasien
        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        // Ambil data alergi pasien
        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)
            ->orderBy('jenis_alergi')
            ->get();

        // Ambil data monitoring gizi
        $monitoringGizi = RmeMonitoringGizi::where('kd_unit', $kd_unit)
            ->where('kd_pasien', $kd_pasien)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->orderBy('tanggal_monitoring', 'desc')
            ->get();

        // Convert gangguan_gi string back to array for display
        if ($dataPengkajianGizi->gangguan_gi) {
            $dataPengkajianGizi->gangguan_gi_array = explode(',', $dataPengkajianGizi->gangguan_gi);
        } else {
            $dataPengkajianGizi->gangguan_gi_array = [];
        }

        return view('unit-pelayanan.rawat-inap.pelayanan.gizi.anak.show', compact(
            'dataPengkajianGizi',
            'dataMedis',
            'alergiPasien',
            'monitoringGizi'
        ));
    }

    public function grafik($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
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

        // Data WHO dan perhitungan rekomendasi
        $whoData = [];
        $recommendations = [];

        if ($dataMedis->pasien && $dataMedis->pasien->jenis_kelamin !== null) {
            // Convert jenis kelamin dari database pasien ke format WHO
            $jenisKelaminPasien = $dataMedis->pasien->jenis_kelamin;

            // Mapping ke format WHO:
            // Database Pasien: 0 = Perempuan, 1 = Laki-laki
            // Database WHO: 1 = Laki-laki, 2 = Perempuan
            if ($jenisKelaminPasien == 1) {
                $jenisKelaminWHO = 1; // Laki-laki
            } elseif ($jenisKelaminPasien == 0) {
                $jenisKelaminWHO = 2; // Perempuan
            } else {
                $jenisKelaminWHO = null; // Invalid
            }

            $umurBulan = $dataMedis->pasien->tgl_lahir ?
                Carbon::parse($dataMedis->pasien->tgl_lahir)->diffInMonths(Carbon::now()) : 0;

            // Tentukan range umur untuk chart (0-60 bulan)
            $maxAge = max(60, $umurBulan + 6);

            if ($jenisKelaminWHO !== null && $dataPengkajianGizi->asesmenGizi) {
                $beratBadan = (float) $dataPengkajianGizi->asesmenGizi->berat_badan;
                $tinggiBadan = (float) $dataPengkajianGizi->asesmenGizi->tinggi_badan;
                $imt = (float) $dataPengkajianGizi->asesmenGizi->imt;

                // 1. Weight for Age
                $weightForAgeRaw = WhoWeightForAge::where('sex', $jenisKelaminWHO)
                    ->where('age_months', '>=', 0)
                    ->where('age_months', '<=', $maxAge)
                    ->orderBy('age_months')
                    ->get(['age_months', 'l', 'm', 's']);

                $whoData['weightForAge'] = $weightForAgeRaw->map(function ($item) {
                    return [
                        'age' => (float)$item->age_months,
                        'L' => (float)$item->l,
                        'M' => (float)$item->m,
                        'S' => (float)$item->s
                    ];
                })->toArray();

                // Calculate Weight for Age recommendation
                if ($beratBadan > 0) {
                    $recommendations['weightAge'] = $this->calculateRecommendation(
                        $beratBadan,
                        $umurBulan,
                        $jenisKelaminWHO,
                        'weight-age'
                    );
                }

                // 2. Height for Age
                $heightForAgeRaw = WhoHeightForAge::where('sex', $jenisKelaminWHO)
                    ->where('age_months', '>=', 0)
                    ->where('age_months', '<=', $maxAge)
                    ->orderBy('age_months')
                    ->get(['age_months', 'l', 'm', 's']);

                $whoData['heightForAge'] = $heightForAgeRaw->map(function ($item) {
                    return [
                        'age' => (float)$item->age_months,
                        'L' => (float)$item->l,
                        'M' => (float)$item->m,
                        'S' => (float)$item->s
                    ];
                })->toArray();

                // Calculate Height for Age recommendation
                if ($tinggiBadan > 0) {
                    $recommendations['heightAge'] = $this->calculateRecommendation(
                        $tinggiBadan,
                        $umurBulan,
                        $jenisKelaminWHO,
                        'height-age'
                    );
                }

                // 3. BMI for Age
                $bmiForAgeRaw = WhoBmiForAge::where('sex', $jenisKelaminWHO)
                    ->where('age_months', '>=', 0)
                    ->where('age_months', '<=', $maxAge)
                    ->orderBy('age_months')
                    ->get(['age_months', 'l', 'm', 's']);

                $whoData['bmiForAge'] = $bmiForAgeRaw->map(function ($item) {
                    return [
                        'age' => (float)$item->age_months,
                        'L' => (float)$item->l,
                        'M' => (float)$item->m,
                        'S' => (float)$item->s
                    ];
                })->toArray();

                // Calculate BMI for Age recommendation
                if ($imt > 0) {
                    $recommendations['bmiAge'] = $this->calculateRecommendation(
                        $imt,
                        $umurBulan,
                        $jenisKelaminWHO,
                        'bmi-age'
                    );
                }

                // 4. Weight for Height/Length
                if ($umurBulan < 24) {
                    // Gunakan Weight for Length untuk < 24 bulan
                    $weightForHeightRaw = WhoWeightForLength::where('sex', $jenisKelaminWHO)
                        ->orderBy('length_cm')
                        ->get(['length_cm', 'l', 'm', 's']);

                    $whoData['weightForHeight'] = $weightForHeightRaw->map(function ($item) {
                        return [
                            'height' => (float)$item->length_cm,
                            'L' => (float)$item->l,
                            'M' => (float)$item->m,
                            'S' => (float)$item->s
                        ];
                    })->toArray();
                } else {
                    // Gunakan Weight for Height untuk >= 24 bulan
                    $weightForHeightRaw = WhoWeightForHeight::where('sex', $jenisKelaminWHO)
                        ->orderBy('height_cm')
                        ->get(['height_cm', 'l', 'm', 's']);

                    $whoData['weightForHeight'] = $weightForHeightRaw->map(function ($item) {
                        return [
                            'height' => (float)$item->height_cm,
                            'L' => (float)$item->l,
                            'M' => (float)$item->m,
                            'S' => (float)$item->s
                        ];
                    })->toArray();
                }

                // Calculate Weight for Height recommendation
                if ($beratBadan > 0 && $tinggiBadan > 0) {
                    $recommendations['weightHeight'] = $this->calculateWeightHeightRecommendation(
                        $beratBadan,
                        $tinggiBadan,
                        $jenisKelaminWHO,
                        $umurBulan
                    );
                }
            }
        }

        // Variabel untuk kompatibilitas (keep existing variables)
        $WhoWeightForAge = WhoWeightForAge::all();
        $WhoHeightForAge = WhoHeightForAge::all();
        $WhoBmiForAge = WhoBmiForAge::all();
        $WhoWeightForHeight = WhoWeightForHeight::all();
        $WhoWeightForLength = WhoWeightForLength::all();
        $WhoHeadCircumferenceForAge = WhoHeadCircumferenceForAge::all();

        return view('unit-pelayanan.rawat-inap.pelayanan.gizi.anak.grafik', compact(
            'dataPengkajianGizi',
            'dataMedis',
            'monitoringGizi',
            'WhoWeightForAge',
            'WhoHeightForAge',
            'WhoBmiForAge',
            'WhoWeightForHeight',
            'WhoWeightForLength',
            'WhoHeadCircumferenceForAge',
            'whoData',
            'recommendations'
        ));
    }

    /**
     * Menghitung Z-Score berdasarkan formula WHO LMS
     */
    private function calculateZScore($value, $L, $M, $S)
    {
        if (!$value || !$M || !$S) return null;

        $zScore = 0;
        if (abs($L) < 0.01) {
            $zScore = log($value / $M) / $S;
        } else {
            $zScore = (pow($value / $M, $L) - 1) / ($L * $S);
        }

        return round($zScore, 2);
    }

    /**
     * Mendapatkan status gizi berdasarkan Z-Score
     */
    private function getStatusFromZScore($zScore, $type)
    {
        if ($zScore === null) return ['status' => 'Tidak dapat dihitung', 'class' => 'normal'];

        $status = '';
        $class = '';

        switch ($type) {
            case 'weight-age':
            case 'weight-height':
                if ($zScore >= 3) {
                    $status = 'Obesitas';
                    $class = 'severe';
                } elseif ($zScore >= 2) {
                    $status = 'Berat Badan Lebih';
                    $class = 'overweight';
                } elseif ($zScore >= -2) {
                    $status = 'Normal';
                    $class = 'normal';
                } elseif ($zScore >= -3) {
                    $status = 'Gizi Kurang';
                    $class = 'underweight';
                } else {
                    $status = 'Gizi Buruk';
                    $class = 'severe';
                }
                break;

            case 'height-age':
                if ($zScore >= 3) {
                    $status = 'Tinggi';
                    $class = 'normal';
                } elseif ($zScore >= 2) {
                    $status = 'Normal Tinggi';
                    $class = 'normal';
                } elseif ($zScore >= -2) {
                    $status = 'Normal';
                    $class = 'normal';
                } elseif ($zScore >= -3) {
                    $status = 'Pendek';
                    $class = 'underweight';
                } else {
                    $status = 'Sangat Pendek';
                    $class = 'severe';
                }
                break;

            case 'bmi-age':
                if ($zScore >= 3) {
                    $status = 'Obesitas';
                    $class = 'severe';
                } elseif ($zScore >= 2) {
                    $status = 'Gemuk';
                    $class = 'overweight';
                } elseif ($zScore >= 1) {
                    $status = 'Risiko Gemuk';
                    $class = 'overweight';
                } elseif ($zScore >= -2) {
                    $status = 'Normal';
                    $class = 'normal';
                } elseif ($zScore >= -3) {
                    $status = 'Kurus';
                    $class = 'underweight';
                } else {
                    $status = 'Sangat Kurus';
                    $class = 'severe';
                }
                break;
        }

        return ['status' => $status, 'class' => $class];
    }

    /**
     * Mendapatkan rekomendasi berdasarkan status gizi
     */
    private function getRecommendationText($status, $type)
    {
        $recommendations = [
            'weight-age' => [
                'Normal' => 'Berat badan anak menurut umur <strong>Normal</strong>, tetap pertahankan dengan memberi makanan sehat dan bergizi.',
                'Gizi Kurang' => 'Berat badan anak menurut umur <strong>Kurang</strong>. Perbanyak asupan makanan bergizi, konsultasi dengan ahli gizi.',
                'Gizi Buruk' => 'Berat badan anak menurut umur <strong>Sangat Kurang</strong>. Segera konsultasi dengan dokter dan ahli gizi.',
                'Berat Badan Lebih' => 'Berat badan anak menurut umur <strong>Berlebih</strong>. Atur pola makan dan tingkatkan aktivitas fisik.',
                'Obesitas' => 'Berat badan anak menurut umur <strong>Obesitas</strong>. Segera konsultasi dengan dokter untuk program penurunan berat badan.'
            ],
            'height-age' => [
                'Normal' => 'Tinggi badan anak menurut umur <strong>Normal</strong>, tetap berikan asupan gizi seimbang.',
                'Normal Tinggi' => 'Tinggi badan anak menurut umur <strong>Normal Tinggi</strong>, pertahankan asupan gizi yang baik.',
                'Tinggi' => 'Tinggi badan anak menurut umur <strong>Tinggi</strong>, pertahankan pola makan sehat.',
                'Pendek' => 'Tinggi badan anak menurut umur <strong>Pendek</strong>. Perbanyak asupan protein, kalsium, dan vitamin D.',
                'Sangat Pendek' => 'Tinggi badan anak menurut umur <strong>Sangat Pendek</strong>. Segera konsultasi dengan dokter untuk evaluasi lebih lanjut.'
            ],
            'weight-height' => [
                'Normal' => 'Berat badan menurut tinggi badan <strong>Normal</strong>, tetap pertahankan pola makan sehat.',
                'Gizi Kurang' => 'Berat badan menurut tinggi badan <strong>Kurang</strong>. Tingkatkan asupan kalori dan protein.',
                'Gizi Buruk' => 'Berat badan menurut tinggi badan <strong>Sangat Kurang</strong>. Segera konsultasi dengan dokter.',
                'Berat Badan Lebih' => 'Berat badan menurut tinggi badan <strong>Berlebih</strong>. Kurangi asupan kalori dan tingkatkan aktivitas.',
                'Obesitas' => 'Berat badan menurut tinggi badan <strong>Obesitas</strong>. Segera konsultasi dengan dokter.'
            ],
            'bmi-age' => [
                'Normal' => 'IMT anak menurut umur <strong>Normal</strong>, tetap pertahankan pola hidup sehat.',
                'Risiko Gemuk' => 'IMT anak menurut umur <strong>Risiko Gemuk</strong>. Perhatikan pola makan dan tingkatkan aktivitas fisik.',
                'Gemuk' => 'IMT anak menurut umur <strong>Gemuk</strong>. Atur pola makan dan rutin berolahraga.',
                'Obesitas' => 'IMT anak menurut umur <strong>Obesitas</strong>. Segera konsultasi dengan dokter.',
                'Kurus' => 'IMT anak menurut umur <strong>Kurus</strong>. Tingkatkan asupan makanan bergizi.',
                'Sangat Kurus' => 'IMT anak menurut umur <strong>Sangat Kurus</strong>. Segera konsultasi dengan dokter dan ahli gizi.'
            ]
        ];

        return $recommendations[$type][$status] ?? 'Konsultasi dengan tenaga kesehatan untuk evaluasi lebih lanjut.';
    }

    /**
     * Menghitung rekomendasi untuk Weight/Age, Height/Age, dan BMI/Age
     */
    private function calculateRecommendation($value, $ageMonths, $sex, $type)
    {
        $modelClass = '';
        $ageField = 'age_months';

        switch ($type) {
            case 'weight-age':
                $modelClass = WhoWeightForAge::class;
                break;
            case 'height-age':
                $modelClass = WhoHeightForAge::class;
                break;
            case 'bmi-age':
                $modelClass = WhoBmiForAge::class;
                break;
        }

        $whoData = $modelClass::where('sex', $sex)
            ->where($ageField, $ageMonths)
            ->first(['l', 'm', 's']);

        if (!$whoData) {
            return [
                'status' => 'Data tidak tersedia',
                'class' => 'normal',
                'recommendation' => 'Data WHO tidak tersedia untuk umur ini.',
                'target_value' => 0,
                'z_score' => null
            ];
        }

        $zScore = $this->calculateZScore($value, $whoData->l, $whoData->m, $whoData->s);
        $statusInfo = $this->getStatusFromZScore($zScore, $type);
        $recommendation = $this->getRecommendationText($statusInfo['status'], $type);

        return [
            'status' => $statusInfo['status'],
            'class' => $statusInfo['class'],
            'recommendation' => $recommendation,
            'target_value' => round($whoData->m, 1),
            'z_score' => $zScore
        ];
    }

    /**
     * Menghitung rekomendasi untuk Weight/Height
     */
    private function calculateWeightHeightRecommendation($weight, $height, $sex, $ageMonths)
    {
        $modelClass = $ageMonths < 24 ? WhoWeightForLength::class : WhoWeightForHeight::class;
        $heightField = $ageMonths < 24 ? 'length_cm' : 'height_cm';

        // Cari data terdekat berdasarkan tinggi/panjang badan
        $whoData = $modelClass::where('sex', $sex)
            ->orderByRaw("ABS({$heightField} - ?)", [$height])
            ->first(['l', 'm', 's', $heightField]);

        if (!$whoData) {
            return [
                'status' => 'Data tidak tersedia',
                'class' => 'normal',
                'recommendation' => 'Data WHO tidak tersedia untuk tinggi badan ini.',
                'target_value' => 0,
                'z_score' => null
            ];
        }

        $zScore = $this->calculateZScore($weight, $whoData->l, $whoData->m, $whoData->s);
        $statusInfo = $this->getStatusFromZScore($zScore, 'weight-height');
        $recommendation = $this->getRecommendationText($statusInfo['status'], 'weight-height');

        return [
            'status' => $statusInfo['status'],
            'class' => $statusInfo['class'],
            'recommendation' => $recommendation,
            'target_value' => round($whoData->m, 1),
            'z_score' => $zScore
        ];
    }

}
