<?php

namespace App\Http\Controllers\UnitPelayanan\RawatJalan;


use App\Http\Controllers\Controller;
use App\Models\Agama;
use App\Models\Kunjungan;
use App\Models\Pekerjaan;
use App\Models\Pendidikan;
use App\Models\RmeAlergiPasien;
use App\Models\RmeAsesmen;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\RmeAsesmenKepRajalBreathing;
use App\Models\RmeAsesmenKepRajalCirculation;
use App\Models\RmeAsesmenKepRajalDisability;
use App\Models\RmeAsesmenKepRajalExposure;
use App\Models\RmeFaktorPemberat;
use App\Models\RmeFaktorPeringan;
use App\Models\RmeFrekuensiNyeri;
use App\Models\RmeJenisNyeri;
use App\Models\RmeKepRajal\RmeAsesmenKepRajal;
use App\Models\RmeKepRajal\RmeAsesmenKepRajalGizi;
use App\Models\RmeKepRajal\RmeAsesmenKepRajalRisikoJatuh;
use App\Models\RmeKepRajal\RmeAsesmenKepRajalPendidikan;
use App\Models\RmeKepRajal\RmeAsesmenKepRajalDischargePlanning;
use App\Models\RmeKepRajal\RmeAsesmenKepRajalSkalaNyeri;
use App\Models\RmeKepRajal\RmeAsesmenKepRajalSosialBudaya;
use App\Models\RmeKepRajal\RmeAsesmenKepRajalTtv;
use App\Models\RmeKualitasNyeri;
use App\Models\RmeMenjalar;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;

class AsesmenKeperawatanRajalController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-jalan');
    }

    private function handleAlergiData($request, $kd_pasien)
    {
        $alergiData = json_decode($request->alergis, true);

        if (!empty($alergiData)) {
            RmeAlergiPasien::where('kd_pasien', $kd_pasien)->delete();

            foreach ($alergiData as $alergi) {
                if (!empty($alergi['jenis_alergi']) || !empty($alergi['alergen'])) {
                    RmeAlergiPasien::create([
                        'kd_pasien' => $kd_pasien,
                        'jenis_alergi' => $alergi['jenis_alergi'],
                        'nama_alergi' => $alergi['alergen'],
                        'reaksi' => $alergi['reaksi'],
                        'tingkat_keparahan' => $alergi['tingkat_keparahan']
                    ]);
                }
            }
        }
    }

    private function getMasterData($kd_pasien)
    {
        return [
            // 'rmeMasterDiagnosis' => RmeMasterDiagnosis::all(),
            // 'rmeMasterImplementasi' => RmeMasterImplementasi::all(),
            // 'satsetPrognosis' => SatsetPrognosis::all(),
            'alergiPasien' => RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get(),
            'pekerjaan' => Pekerjaan::all(),
            'faktorPemberat' => RmeFaktorPemberat::all(),
            'faktorPeringan' => RmeFaktorPeringan::all(),
            'kualitasNyeri' => RmeKualitasNyeri::all(),
            'frekuensiNyeri' => RmeFrekuensiNyeri::all(),
            'menjalar' => RmeMenjalar::all(),
            'jenisNyeri' => RmeJenisNyeri::all(),
            'agama' => Agama::all(),
            'pendidikan' => Pendidikan::all(),
        ];
    }

    public function index($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $user = auth()->user();

        // Mengambil data kunjungan dan tanggal triase terkait
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



        $masterData = $this->getMasterData($kd_pasien);

        $rmeAsesmenKepRajal = RmeAsesmenKepRajal::select('keperawatan_rencana', 'keperawatan_masalah')->get();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        // $masterData = $this->getMasterData($kd_pasien);

        $dataMedis->waktu_masuk = Carbon::parse($dataMedis->TGL_MASUK . ' ' . $dataMedis->JAM_MASUK)->format('Y-m-d H:i:s');

        return view(
            'unit-pelayanan.rawat-jalan.pelayanan.asesmen-keperawatan.create',
            array_merge([
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
                'dataMedis' => $dataMedis,
                'rmeAsesmenKepRajal' => $rmeAsesmenKepRajal,
            ], $masterData)
        );
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        DB::beginTransaction();

        try {

            $asesmen = new RmeAsesmen();
            $asesmen->kd_pasien = $kd_pasien;
            $asesmen->kd_unit = $kd_unit;
            $asesmen->tgl_masuk = $tgl_masuk;
            $asesmen->urut_masuk = $urut_masuk;
            $asesmen->user_id = Auth::id();
            $asesmen->waktu_asesmen = date('Y-m-d H:i:s');
            $asesmen->kategori = 2;
            $asesmen->sub_kategori = 1;
            $asesmen->save();

            // Tabel Utama
            $asesmenKepRajal = new RmeAsesmenKepRajal();
            $asesmenKepRajal->id_asesmen = $asesmen->id;
            $asesmenKepRajal->keluhan_utama = $request->keluhan_utama;
            $asesmenKepRajal->psikologis_kondisi = $request->psikologis_kondisi;
            $asesmenKepRajal->psikologis_lainnya = $request->psikologis_lainnya;
            $asesmenKepRajal->psikologis_permasalahan_yang_dikonsulkan = $request->psikologis_permasalahan_yang_dikonsulkan;
            $asesmenKepRajal->spiritual_agama = $request->spiritual_agama;
            $asesmenKepRajal->spiritual_nilai = $request->spiritual_nilai;
            // Batuk
            $asesmenKepRajal->skrining_batuk_kejadian = $request->skrining_batuk_kejadian;
            $asesmenKepRajal->skrining_batuk_penurunan_bb = $request->skrining_batuk_penurunan_bb;
            $asesmenKepRajal->skrining_batuk_keringat_malam = $request->skrining_batuk_keringat_malam;
            $asesmenKepRajal->skrining_batuk_sesak_nafas = $request->skrining_batuk_sesak_nafas;
            $asesmenKepRajal->skrining_batuk_jika_tidak_ada = $request->skrining_batuk_jika_tidak_ada;
            $asesmenKepRajal->skrining_batuk_keputusan = $request->skrining_batuk_keputusan;
            // Fungsional Status
            $asesmenKepRajal->fungsional_status = $request->fungsional_status;
            $asesmenKepRajal->fungsional_sebutkan = $request->fungsional_sebutkan;
            $asesmenKepRajal->fungsional_ketergantungan_total = $request->fungsional_ketergantungan_total;

            // Keperawatan
            $keperawatanMasalahData = json_decode($request->keperawatan_masalah, true) ?: [];
            $keperawatanRencanaData = json_decode($request->keperawatan_rencana, true) ?: [];
            $asesmenKepRajal->keperawatan_masalah = $keperawatanMasalahData;
            $asesmenKepRajal->keperawatan_rencana = $keperawatanRencanaData;
            $saved = $asesmenKepRajal->save();

            // Edukasi/Pendidikan Dan Pengajaran
            $asesmenKepRajalPendidikan = new RmeAsesmenKepRajalPendidikan();
            $asesmenKepRajalPendidikan->id_asesmen = $asesmen->id;
            $asesmenKepRajalPendidikan->gaya_bicara = $request->kebutuhan_edukasi_gaya_bicara;
            $asesmenKepRajalPendidikan->bahasa_sehari_hari = $request->kebutuhan_edukasi_bahasa_sehari_hari;
            $asesmenKepRajalPendidikan->perlu_penerjemah = $request->kebutuhan_edukasi_perlu_penerjemah;
            $asesmenKepRajalPendidikan->hambatan_komunikasi = $request->kebutuhan_edukasi_hambatan_komunikasi;
            $asesmenKepRajalPendidikan->media_belajar_yang_disukai = $request->kebutuhan_edukasi_media_belajar;
            $asesmenKepRajalPendidikan->tingkat_pendidikan = $request->kebutuhan_edukasi_tingkat_pendidikan;
            $asesmenKepRajalPendidikan->edukasi_yang_dibutuhkan = $request->kebutuhan_edukasi_edukasi_dibutuhkan;
            $asesmenKepRajalPendidikan->lainnya = $request->kebutuhan_edukasi_keterangan_lain;
            $asesmenKepRajalPendidikan->save();

            // Discharge Planning
            $asesmenKepRajalDischargePlanning = new RmeAsesmenKepRajalDischargePlanning();
            $asesmenKepRajalDischargePlanning->id_asesmen = $asesmen->id;
            $asesmenKepRajalDischargePlanning->diagnosis_medis = $request->diagnosis_medis;
            $asesmenKepRajalDischargePlanning->usia_lanjut = $request->usia_lanjut;
            $asesmenKepRajalDischargePlanning->hambatan_mobilisasi = $request->hambatan_mobilisasi;
            $asesmenKepRajalDischargePlanning->layanan_medis_lanjutan = $request->layanan_medis_lanjutan;
            $asesmenKepRajalDischargePlanning->ketergantungan_orang_lain = $request->ketergantungan_orang_lain;
            $asesmenKepRajalDischargePlanning->rencana_pulang = $request->rencana_pulang;

            // Kesimpulan akan diisi otomatis oleh JavaScript berdasarkan jawaban ya/tidak
            $asesmenKepRajalDischargePlanning->kesimpulan = $request->kesimpulan ?? 'Tidak membutuhkan rencana pulang khusus';

            $asesmenKepRajalDischargePlanning->save();

            $asesmenKepRajalBreathing = new RmeAsesmenKepRajalTtv();
            $asesmenKepRajalBreathing->id_asesmen = $asesmen->id;
            $asesmenKepRajalBreathing->sistolik = $request->sistolik;
            $asesmenKepRajalBreathing->diastolik = $request->diastolik;
            $asesmenKepRajalBreathing->nadi = $request->nadi;
            $asesmenKepRajalBreathing->nafas_per_menit = $request->nafas_per_menit;
            $asesmenKepRajalBreathing->suhu = $request->suhu;
            $asesmenKepRajalBreathing->save();

            // Skala Nyeri
            $asesmenKepRajalStatusNyeri = new RmeAsesmenKepRajalSkalaNyeri();
            $asesmenKepRajalStatusNyeri->id_asesmen = $asesmen->id;
            $asesmenKepRajalStatusNyeri->skala_nyeri = $request->skala_nyeri;
            $asesmenKepRajalStatusNyeri->skala_nyeri_lokasi = $request->skala_nyeri_lokasi;
            $asesmenKepRajalStatusNyeri->skala_nyeri_durasi = $request->skala_nyeri_durasi;
            $asesmenKepRajalStatusNyeri->skala_nyeri_pemberat_id = $request->skala_nyeri_pemberat_id;
            $asesmenKepRajalStatusNyeri->skala_nyeri_peringan_id = $request->skala_nyeri_peringan_id;
            $asesmenKepRajalStatusNyeri->skala_nyeri_kualitas_id = $request->skala_nyeri_kualitas_id;
            $asesmenKepRajalStatusNyeri->skala_nyeri_frekuensi_id = $request->skala_nyeri_frekuensi_id;
            $asesmenKepRajalStatusNyeri->skala_nyeri_menjalar_id = $request->skala_nyeri_menjalar_id;
            $asesmenKepRajalStatusNyeri->skala_nyeri_jenis_id = $request->skala_nyeri_jenis_id;
            $asesmenKepRajalStatusNyeri->save();

            // Sosial Budaya
            $asesmenKepRajalSosialBudaya = new RmeAsesmenKepRajalSosialBudaya();
            $asesmenKepRajalSosialBudaya->id_asesmen = $asesmen->id;
            $asesmenKepRajalSosialBudaya->pekerjaan = $request->sosial_budaya_pekerjaan;
            $asesmenKepRajalSosialBudaya->kesulitan_memenuhi_kebutuhan_dasar = $request->sosial_budaya_kesulitan_memenuhi_kebutuhan_dasar;
            $asesmenKepRajalSosialBudaya->hubungan_dengan_anggota_keluarga = $request->sosial_budaya_hubungan_dengan_anggota_keluarga;
            $asesmenKepRajalSosialBudaya->suku = $request->sosial_budaya_suku;
            $asesmenKepRajalSosialBudaya->pendidikan = $request->sosial_budaya_status_pendidikan;
            $asesmenKepRajalSosialBudaya->budaya_atau_yang_dipercaya = $request->sosial_budaya_budaya_atau_yang_dipercaya;
            $asesmenKepRajalSosialBudaya->save();

            $asesmenKepRajalRisikoJatuh = new RmeAsesmenKepRajalRisikoJatuh();
            $asesmenKepRajalRisikoJatuh->id_asesmen = $asesmen->id;
            $asesmenKepRajalRisikoJatuh->resiko_jatuh_jenis = (int)$request->resiko_jatuh_jenis;
            $asesmenKepRajalRisikoJatuh->risik_jatuh_tindakan = $request->risikojatuh_tindakan_keperawatan ? json_encode($request->risikojatuh_tindakan_keperawatan) : null;

            // Handle Skala Umum
            if ($request->resiko_jatuh_jenis == 1) {
                $asesmenKepRajalRisikoJatuh->risiko_jatuh_umum_usia = $request->risiko_jatuh_umum_usia ? 1 : 0;
                $asesmenKepRajalRisikoJatuh->risiko_jatuh_umum_kondisi_khusus = $request->risiko_jatuh_umum_kondisi_khusus ? 1 : 0;
                $asesmenKepRajalRisikoJatuh->risiko_jatuh_umum_diagnosis_parkinson = $request->risiko_jatuh_umum_diagnosis_parkinson ? 1 : 0;
                $asesmenKepRajalRisikoJatuh->risiko_jatuh_umum_pengobatan_berisiko = $request->risiko_jatuh_umum_pengobatan_berisiko ? 1 : 0;
                $asesmenKepRajalRisikoJatuh->risiko_jatuh_umum_lokasi_berisiko = $request->risiko_jatuh_umum_lokasi_berisiko ? 1 : 0;
                $asesmenKepRajalRisikoJatuh->risiko_jatuh_umum_kesimpulan = $request->input('risiko_jatuh_umum_kesimpulan', 'Tidak berisiko jatuh');
            }

            // Handle Skala Morse
            if ($request->resiko_jatuh_jenis == 2) {
                $asesmenKepRajalRisikoJatuh->risiko_jatuh_morse_riwayat_jatuh = array_search($request->risiko_jatuh_morse_riwayat_jatuh, ['25' => 25, '0' => 0]);
                $asesmenKepRajalRisikoJatuh->risiko_jatuh_morse_diagnosis_sekunder = array_search($request->risiko_jatuh_morse_diagnosis_sekunder, ['15' => 15, '0' => 0]);
                $asesmenKepRajalRisikoJatuh->risiko_jatuh_morse_bantuan_ambulasi = array_search($request->risiko_jatuh_morse_bantuan_ambulasi, ['30' => 30, '15' => 15, '0' => 0]);
                $asesmenKepRajalRisikoJatuh->risiko_jatuh_morse_terpasang_infus = array_search($request->risiko_jatuh_morse_terpasang_infus, ['20' => 20, '0' => 0]);
                $asesmenKepRajalRisikoJatuh->risiko_jatuh_morse_cara_berjalan = array_search($request->risiko_jatuh_morse_cara_berjalan, ['0' => 0, '20' => 20, 10 => 10]);
                $asesmenKepRajalRisikoJatuh->risiko_jatuh_morse_status_mental = array_search($request->risiko_jatuh_morse_status_mental, ['0' => 0, '15' => 15]);
                $asesmenKepRajalRisikoJatuh->risiko_jatuh_morse_kesimpulan = $request->risiko_jatuh_morse_kesimpulan;
                $asesmenKepRajalRisikoJatuh->save();
            }

            // Handle Skala Pediatrik/Humpty
            else if ($request->resiko_jatuh_jenis == 3) {
                $asesmenKepRajalRisikoJatuh->risiko_jatuh_pediatrik_usia_anak = array_search((int)$request->risiko_jatuh_pediatrik_usia_anak, ['4' => 4, '3' => 3, '2' => 2, '1' => 1]);
                $asesmenKepRajalRisikoJatuh->risiko_jatuh_pediatrik_jenis_kelamin = array_search($request->risiko_jatuh_pediatrik_jenis_kelamin, ['2' => 2, '1' => 1]);
                $asesmenKepRajalRisikoJatuh->risiko_jatuh_pediatrik_diagnosis = array_search($request->risiko_jatuh_pediatrik_diagnosis, ['4' => 4, '3' => 3, '2' => 2, '1' => 1]);
                $asesmenKepRajalRisikoJatuh->risiko_jatuh_pediatrik_gangguan_kognitif = array_search($request->risiko_jatuh_pediatrik_gangguan_kognitif, ['3' => 3, '2' => 2, '1' => 1]);
                $asesmenKepRajalRisikoJatuh->risiko_jatuh_pediatrik_faktor_lingkungan = array_search($request->risiko_jatuh_pediatrik_faktor_lingkungan, ['4' => 4, '3' => 3, '2' => 2, '1' => 1]);
                $asesmenKepRajalRisikoJatuh->risiko_jatuh_pediatrik_pembedahan = array_search($request->risiko_jatuh_pediatrik_pembedahan, ['3' => 3, '2' => 2, '1' => 1]);
                $asesmenKepRajalRisikoJatuh->risiko_jatuh_pediatrik_penggunaan_mentosa = array_search($request->risiko_jatuh_pediatrik_penggunaan_mentosa, ['3' => 3, '2' => 2, '1' => 1]);
                $asesmenKepRajalRisikoJatuh->risiko_jatuh_pediatrik_kesimpulan = $request->risiko_jatuh_pediatrik_kesimpulan;
            }

            // Handle Skala Lansia/Ontario
            else if ($request->resiko_jatuh_jenis == 4) {
                $asesmenKepRajalRisikoJatuh->risiko_jatuh_lansia_jatuh_saat_masuk_rs = array_search($request->risiko_jatuh_lansia_jatuh_saat_masuk_rs, ['6' => 6, '0' => 0]);
                $asesmenKepRajalRisikoJatuh->risiko_jatuh_lansia_riwayat_jatuh_2_bulan = array_search($request->risiko_jatuh_lansia_riwayat_jatuh_2_bulan, ['6' => 6, '0' => 0]);
                $asesmenKepRajalRisikoJatuh->risiko_jatuh_lansia_status_bingung = array_search($request->risiko_jatuh_lansia_status_bingung, ['14' => 14, '0' => 0]);
                $asesmenKepRajalRisikoJatuh->risiko_jatuh_lansia_status_disorientasi = array_search($request->risiko_jatuh_lansia_status_disorientasi, ['14' => 14, '0' => 0]);
                $asesmenKepRajalRisikoJatuh->risiko_jatuh_lansia_status_agitasi = array_search($request->risiko_jatuh_lansia_status_agitasi, ['14' => 14, '0' => 0]);
                $asesmenKepRajalRisikoJatuh->risiko_jatuh_lansia_kacamata = $request->risiko_jatuh_lansia_kacamata;
                $asesmenKepRajalRisikoJatuh->risiko_jatuh_lansia_kelainan_penglihatan = $request->risiko_jatuh_lansia_kelainan_penglihatan;
                $asesmenKepRajalRisikoJatuh->risiko_jatuh_lansia_glukoma = $request->risiko_jatuh_lansia_glukoma;
                $asesmenKepRajalRisikoJatuh->risiko_jatuh_lansia_perubahan_berkemih = array_search($request->risiko_jatuh_lansia_perubahan_berkemih, ['2' => 2, '0' => 0]);
                $asesmenKepRajalRisikoJatuh->risiko_jatuh_lansia_transfer_mandiri = $request->risiko_jatuh_lansia_transfer_mandiri;
                $asesmenKepRajalRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_sedikit = $request->risiko_jatuh_lansia_transfer_bantuan_sedikit;
                $asesmenKepRajalRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_nyata = array_search($request->risiko_jatuh_lansia_transfer_bantuan_nyata, ['2' => 2, '0' => 0]);
                $asesmenKepRajalRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_total = array_search($request->risiko_jatuh_lansia_transfer_bantuan_total, ['3' => 2, '0' => 0]);
                $asesmenKepRajalRisikoJatuh->risiko_jatuh_lansia_mobilitas_mandiri = $request->risiko_jatuh_lansia_mobilitas_mandiri;
                $asesmenKepRajalRisikoJatuh->risiko_jatuh_lansia_mobilitas_bantuan_1_orang = $request->risiko_jatuh_lansia_mobilitas_bantuan_1_orang;
                $asesmenKepRajalRisikoJatuh->risiko_jatuh_lansia_mobilitas_kursi_roda = array_search($request->risiko_jatuh_lansia_mobilitas_kursi_roda, ['2' => 2, '0' => 0]);
                $asesmenKepRajalRisikoJatuh->risiko_jatuh_lansia_mobilitas_imobilisasi = array_search($request->risiko_jatuh_lansia_mobilitas_imobilisasi, ['3' => 2, '0' => 0]);
                $asesmenKepRajalRisikoJatuh->risiko_jatuh_lansia_kesimpulan = $request->risiko_jatuh_lansia_kesimpulan;
            } else if ($request->resiko_jatuh_jenis == 5) {
                $asesmenKepRajalRisikoJatuh->resiko_jatuh_lainnya = 'resiko jatuh lainnya';
            }
            $asesmenKepRajalRisikoJatuh->save();

            $asesmenKepRajalStatusGizi = new RmeAsesmenKepRajalGizi();
            $asesmenKepRajalStatusGizi->id_asesmen = $asesmen->id;
            $asesmenKepRajalStatusGizi->gizi_jenis = (int)$request->gizi_jenis;

            // Handle MST Form
            if ($request->gizi_jenis == 1) {
                $asesmenKepRajalStatusGizi->gizi_mst_penurunan_bb = $request->gizi_mst_penurunan_bb;
                $asesmenKepRajalStatusGizi->gizi_mst_jumlah_penurunan_bb = $request->gizi_mst_jumlah_penurunan_bb;
                $asesmenKepRajalStatusGizi->gizi_mst_nafsu_makan_berkurang = $request->gizi_mst_nafsu_makan_berkurang;
                $asesmenKepRajalStatusGizi->gizi_mst_diagnosis_khusus = $request->gizi_mst_diagnosis_khusus;
                $asesmenKepRajalStatusGizi->gizi_mst_kesimpulan = $request->gizi_mst_kesimpulan;
            }

            // Handle MNA Form
            else if ($request->gizi_jenis == 2) {
                $asesmenKepRajalStatusGizi->gizi_mna_penurunan_asupan_3_bulan = (int)$request->gizi_mna_penurunan_asupan_3_bulan;
                $asesmenKepRajalStatusGizi->gizi_mna_kehilangan_bb_3_bulan = (int)$request->gizi_mna_kehilangan_bb_3_bulan;
                $asesmenKepRajalStatusGizi->gizi_mna_mobilisasi = (int)$request->gizi_mna_mobilisasi;
                $asesmenKepRajalStatusGizi->gizi_mna_stress_penyakit_akut = (int)$request->gizi_mna_stress_penyakit_akut;
                $asesmenKepRajalStatusGizi->gizi_mna_status_neuropsikologi = (int)$request->gizi_mna_status_neuropsikologi;
                $asesmenKepRajalStatusGizi->gizi_mna_berat_badan = (int)$request->gizi_mna_berat_badan;
                $asesmenKepRajalStatusGizi->gizi_mna_tinggi_badan = (int)$request->gizi_mna_tinggi_badan;

                // Hitung dan simpan IMT
                $heightInMeters = $request->gizi_mna_tinggi_badan / 100;
                $imt = $request->gizi_mna_berat_badan / ($heightInMeters * $heightInMeters);
                $asesmenKepRajalStatusGizi->gizi_mna_imt = number_format($imt, 2, '.', '');

                $asesmenKepRajalStatusGizi->gizi_mna_kesimpulan = $request->gizi_mna_kesimpulan;
            }

            // Handle Strong Kids Form
            else if ($request->gizi_jenis == 3) {
                $asesmenKepRajalStatusGizi->gizi_strong_status_kurus = $request->gizi_strong_status_kurus;
                $asesmenKepRajalStatusGizi->gizi_strong_penurunan_bb = $request->gizi_strong_penurunan_bb;
                $asesmenKepRajalStatusGizi->gizi_strong_gangguan_pencernaan = $request->gizi_strong_gangguan_pencernaan;
                $asesmenKepRajalStatusGizi->gizi_strong_penyakit_berisiko = $request->gizi_strong_penyakit_berisiko;
                $asesmenKepRajalStatusGizi->gizi_strong_kesimpulan = $request->gizi_strong_kesimpulan;
            }

            // Handle NRS Form
            else if ($request->gizi_jenis == 4) {
                $asesmenKepRajalStatusGizi->gizi_nrs_jatuh_saat_masuk_rs = $request->gizi_nrs_jatuh_saat_masuk_rs;
                $asesmenKepRajalStatusGizi->gizi_nrs_jatuh_2_bulan_terakhir = $request->gizi_nrs_jatuh_2_bulan_terakhir;
                $asesmenKepRajalStatusGizi->gizi_nrs_status_delirium = $request->gizi_nrs_status_delirium;
                $asesmenKepRajalStatusGizi->gizi_nrs_status_disorientasi = $request->gizi_nrs_status_disorientasi;
                $asesmenKepRajalStatusGizi->gizi_nrs_status_agitasi = $request->gizi_nrs_status_agitasi;
                $asesmenKepRajalStatusGizi->gizi_nrs_menggunakan_kacamata = $request->gizi_nrs_menggunakan_kacamata;
                $asesmenKepRajalStatusGizi->gizi_nrs_keluhan_penglihatan_buram = $request->gizi_nrs_keluhan_penglihatan_buram;
                $asesmenKepRajalStatusGizi->gizi_nrs_degenerasi_makula = $request->gizi_nrs_degenerasi_makula;
                $asesmenKepRajalStatusGizi->gizi_nrs_perubahan_berkemih = $request->gizi_nrs_perubahan_berkemih;
                $asesmenKepRajalStatusGizi->gizi_nrs_transfer_mandiri = $request->gizi_nrs_transfer_mandiri;
                $asesmenKepRajalStatusGizi->gizi_nrs_transfer_bantuan_1_orang = $request->gizi_nrs_transfer_bantuan_1_orang;
                $asesmenKepRajalStatusGizi->gizi_nrs_transfer_bantuan_2_orang = $request->gizi_nrs_transfer_bantuan_2_orang;
                $asesmenKepRajalStatusGizi->gizi_nrs_transfer_bantuan_total = $request->gizi_nrs_transfer_bantuan_total;
                $asesmenKepRajalStatusGizi->gizi_nrs_mobilitas_mandiri = $request->gizi_nrs_mobilitas_mandiri;
                $asesmenKepRajalStatusGizi->gizi_nrs_mobilitas_bantuan_1_orang = $request->gizi_nrs_mobilitas_bantuan_1_orang;
                $asesmenKepRajalStatusGizi->gizi_nrs_mobilitas_kursi_roda = $request->gizi_nrs_mobilitas_kursi_roda;
                $asesmenKepRajalStatusGizi->gizi_nrs_mobilitas_imobilisasi = $request->gizi_nrs_mobilitas_imobilisasi;
                $asesmenKepRajalStatusGizi->gizi_nrs_kesimpulan = $request->gizi_nrs_kesimpulan;
            } else if ($request->gizi_jenis == 5) {
                $asesmenKepRajalStatusGizi->status_gizi_tidakada = 'tidak ada status gizi';
            }

            $asesmenKepRajalStatusGizi->save();

            // Handle alergi
            // Sync data alergi pasien
            $alergiData = json_decode($request->alergis, true);
            $alergiLama = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();

            $alergiBaru = [];
            if (!empty($alergiData)) {
                foreach ($alergiData as $alergi) {
                    // Key unik: jenis_alergi + nama_alergi/alergen
                    $jenis = $alergi['jenis_alergi'] ?? null;
                    $nama = $alergi['alergen'] ?? ($alergi['nama_alergi'] ?? null);
                    if ($jenis && $nama && isset($alergi['reaksi']) && isset($alergi['tingkat_keparahan'])) {
                        $alergiBaru[] = [
                            'jenis_alergi' => $jenis,
                            'nama_alergi' => $nama,
                            'reaksi' => $alergi['reaksi'],
                            'tingkat_keparahan' => $alergi['tingkat_keparahan']
                        ];
                        // Update jika sudah ada
                        $existing = $alergiLama->where('jenis_alergi', $jenis)->where('nama_alergi', $nama)->first();
                        if ($existing) {
                            $existing->update([
                                'reaksi' => $alergi['reaksi'],
                                'tingkat_keparahan' => $alergi['tingkat_keparahan']
                            ]);
                        } else {
                            RmeAlergiPasien::create([
                                'kd_pasien' => $kd_pasien,
                                'jenis_alergi' => $jenis,
                                'nama_alergi' => $nama,
                                'reaksi' => $alergi['reaksi'],
                                'tingkat_keparahan' => $alergi['tingkat_keparahan']
                            ]);
                        }
                    }
                }
            }
            // Hapus data lama yang tidak ada di input baru
            foreach ($alergiLama as $lama) {
                $found = false;
                foreach ($alergiBaru as $baru) {
                    if ($lama->jenis_alergi == $baru['jenis_alergi'] && $lama->nama_alergi == $baru['nama_alergi']) {
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    $lama->delete();
                }
            }

            DB::commit();

            return redirect()->route('rawat-jalan.asesmen.index', [
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk
            ])->with(['success' => 'Berhasil menambah asesmen keperawatan rawat jalan!']);
        } catch (Exception $e) {
            DB::rollBack();

            \Log::error('Error saving RmeAsesmenKepRajal: ' . $e->getMessage());
            \Log::error('Error trace: ' . $e->getTraceAsString());

            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $user = auth()->user();

        // Mengambil data kunjungan dan tanggal triase terkait
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

        // Ambil data asesmen existing
        $asesmen = RmeAsesmen::with([
            'asesmenKepRajalPendidikan',
            'asesmenKepRajalDischargePlanning',
            'asesmenKepRajalTtv',
            'asesmenKepRajalSkalaNyeri',
            'asesmenKepRajalSosialBudaya',
            'asesmenKepRajalRisikoJatuh',
            'asesmenKepRajalGizi'
        ])
            ->where('id', $id)
            ->where('kd_unit', $kd_unit)
            ->where('kd_pasien', $kd_pasien)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->firstOrFail();

        $masterData = $this->getMasterData($kd_pasien);

        $rmeAsesmenKepRajal = RmeAsesmenKepRajal::select('keperawatan_rencana', 'keperawatan_masalah')->get();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        $dataMedis->waktu_masuk = Carbon::parse($dataMedis->TGL_MASUK . ' ' . $dataMedis->JAM_MASUK)->format('Y-m-d H:i:s');

        return view(
            'unit-pelayanan.rawat-jalan.pelayanan.asesmen-keperawatan.edit',
            array_merge([
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
                'dataMedis' => $dataMedis,
                'asesmen' => $asesmen,
                'rmeAsesmenKepRajal' => $rmeAsesmenKepRajal,
            ], $masterData)
        );
    }

     public function show($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $user = auth()->user();
        // Mengambil data kunjungan dan tanggal triase terkait
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

        // Ambil data asesmen existing
        $asesmen = RmeAsesmen::with([
            'asesmenKepRajalPendidikan',
            'asesmenKepRajalDischargePlanning',
            'asesmenKepRajalTtv',
            'asesmenKepRajalSkalaNyeri',
            'asesmenKepRajalSosialBudaya',
            'asesmenKepRajalRisikoJatuh',
            'asesmenKepRajalGizi'
        ])
            ->where('id', $id)
            ->where('kd_unit', $kd_unit)
            ->where('kd_pasien', $kd_pasien)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->firstOrFail();

        $masterData = $this->getMasterData($kd_pasien);

        $rmeAsesmenKepRajal = RmeAsesmenKepRajal::select('keperawatan_rencana', 'keperawatan_masalah')->get();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        $dataMedis->waktu_masuk = Carbon::parse($dataMedis->TGL_MASUK . ' ' . $dataMedis->JAM_MASUK)->format('Y-m-d H:i:s');

        return view(
            'unit-pelayanan.rawat-jalan.pelayanan.asesmen-keperawatan.show',
            array_merge([
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
                'dataMedis' => $dataMedis,
                'asesmen' => $asesmen,
                'rmeAsesmenKepRajal' => $rmeAsesmenKepRajal,
            ], $masterData)
        );
    }

    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            $asesmen = RmeAsesmen::findOrFail($id);
            $asesmen->user_id = Auth::id();
            $asesmen->waktu_asesmen = date('Y-m-d H:i:s');
            $asesmen->save();

            // Update following store method pattern
            $this->updateMainRecord($request, $asesmen);
            $this->updateAllRelatedModels($request, $asesmen);
            $this->handleAlergiData($request, $kd_pasien);

            DB::commit();
            return redirect()->route('rawat-jalan.asesmen.index', [
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk
            ])->with(['success' => 'Berhasil mengupdate asesmen keperawatan rawat jalan!']);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    private function updateMainRecord($request, $asesmen)
    {
        $asesmenKepRajal = RmeAsesmenKepRajal::firstOrNew(['id_asesmen' => $asesmen->id]);
        $asesmenKepRajal->id_asesmen = $asesmen->id;
        $asesmenKepRajal->keluhan_utama = $request->keluhan_utama ?? $asesmenKepRajal->keluhan_utama;
        $asesmenKepRajal->psikologis_kondisi = $request->psikologis_kondisi ?? $asesmenKepRajal->psikologis_kondisi;
        $asesmenKepRajal->psikologis_lainnya = $request->psikologis_lainnya ?? $asesmenKepRajal->psikologis_lainnya;
        $asesmenKepRajal->psikologis_permasalahan_yang_dikonsulkan = $request->psikologis_permasalahan_yang_dikonsulkan ?? $asesmenKepRajal->psikologis_permasalahan_yang_dikonsulkan;
        $asesmenKepRajal->spiritual_agama = $request->spiritual_agama ?? $asesmenKepRajal->spiritual_agama;
        $asesmenKepRajal->spiritual_nilai = $request->spiritual_nilai ?? $asesmenKepRajal->spiritual_nilai;
        $asesmenKepRajal->skrining_batuk_kejadian = $request->skrining_batuk_kejadian ?? $asesmenKepRajal->skrining_batuk_kejadian;
        $asesmenKepRajal->skrining_batuk_penurunan_bb = $request->skrining_batuk_penurunan_bb ?? $asesmenKepRajal->skrining_batuk_penurunan_bb;
        $asesmenKepRajal->skrining_batuk_keringat_malam = $request->skrining_batuk_keringat_malam ?? $asesmenKepRajal->skrining_batuk_keringat_malam;
        $asesmenKepRajal->skrining_batuk_sesak_nafas = $request->skrining_batuk_sesak_nafas ?? $asesmenKepRajal->skrining_batuk_sesak_nafas;
        $asesmenKepRajal->skrining_batuk_jika_tidak_ada = $request->skrining_batuk_jika_tidak_ada ?? $asesmenKepRajal->skrining_batuk_jika_tidak_ada;
        $asesmenKepRajal->skrining_batuk_keputusan = $request->skrining_batuk_keputusan ?? $asesmenKepRajal->skrining_batuk_keputusan;
        $asesmenKepRajal->fungsional_status = $request->fungsional_status ?? $asesmenKepRajal->fungsional_status;
        $asesmenKepRajal->fungsional_sebutkan = $request->fungsional_sebutkan ?? $asesmenKepRajal->fungsional_sebutkan;
        $asesmenKepRajal->fungsional_ketergantungan_total = $request->fungsional_ketergantungan_total ?? $asesmenKepRajal->fungsional_ketergantungan_total;
        $asesmenKepRajal->keperawatan_masalah = json_decode($request->keperawatan_masalah, true) ?? $asesmenKepRajal->keperawatan_masalah;
        $asesmenKepRajal->keperawatan_rencana = json_decode($request->keperawatan_rencana, true) ?? $asesmenKepRajal->keperawatan_rencana;
        $asesmenKepRajal->save();
    }

    private function updateAllRelatedModels($request, $asesmen)
    {
        // Update all related models following store method logic
        $models = [
            ['class' => RmeAsesmenKepRajalPendidikan::class, 'method' => 'updatePendidikan'],
            ['class' => RmeAsesmenKepRajalDischargePlanning::class, 'method' => 'updateDischargePlanning'],
            ['class' => RmeAsesmenKepRajalTtv::class, 'method' => 'updateTtv'],
            ['class' => RmeAsesmenKepRajalSkalaNyeri::class, 'method' => 'updateSkalaNyeri'],
            ['class' => RmeAsesmenKepRajalSosialBudaya::class, 'method' => 'updateSosialBudaya'],
            ['class' => RmeAsesmenKepRajalRisikoJatuh::class, 'method' => 'updateRisikoJatuh'],
            ['class' => RmeAsesmenKepRajalGizi::class, 'method' => 'updateStatusGizi']
        ];

        foreach ($models as $model) {
            $this->{$model['method']}($request, $asesmen);
        }
    }

    private function updatePendidikan($request, $asesmen)
    {
        $pendidikan = RmeAsesmenKepRajalPendidikan::firstOrNew(['id_asesmen' => $asesmen->id]);
        $pendidikan->id_asesmen = $asesmen->id;
        $pendidikan->gaya_bicara = $request->kebutuhan_edukasi_gaya_bicara ?? $pendidikan->gaya_bicara;
        $pendidikan->bahasa_sehari_hari = $request->kebutuhan_edukasi_bahasa_sehari_hari ?? $pendidikan->bahasa_sehari_hari;
        $pendidikan->perlu_penerjemah = $request->kebutuhan_edukasi_perlu_penerjemah ?? $pendidikan->perlu_penerjemah;
        $pendidikan->hambatan_komunikasi = $request->kebutuhan_edukasi_hambatan_komunikasi ?? $pendidikan->hambatan_komunikasi;
        $pendidikan->media_belajar_yang_disukai = $request->kebutuhan_edukasi_media_belajar ?? $pendidikan->media_belajar_yang_disukai;
        $pendidikan->tingkat_pendidikan = $request->kebutuhan_edukasi_tingkat_pendidikan ?? $pendidikan->tingkat_pendidikan;
        $pendidikan->edukasi_yang_dibutuhkan = $request->kebutuhan_edukasi_edukasi_dibutuhkan ?? $pendidikan->edukasi_yang_dibutuhkan;
        $pendidikan->lainnya = $request->kebutuhan_edukasi_keterangan_lain ?? $pendidikan->lainnya;
        $pendidikan->save();
    }

    private function updateDischargePlanning($request, $asesmen)
    {
        $dischargePlanning = RmeAsesmenKepRajalDischargePlanning::firstOrNew(['id_asesmen' => $asesmen->id]);
        $dischargePlanning->id_asesmen = $asesmen->id;
        $dischargePlanning->diagnosis_medis = $request->diagnosis_medis ?? $dischargePlanning->diagnosis_medis;
        $dischargePlanning->usia_lanjut = $request->usia_lanjut ?? $dischargePlanning->usia_lanjut;
        $dischargePlanning->hambatan_mobilisasi = $request->hambatan_mobilisasi ?? $dischargePlanning->hambatan_mobilisasi;
        $dischargePlanning->layanan_medis_lanjutan = $request->layanan_medis_lanjutan ?? $dischargePlanning->layanan_medis_lanjutan;
        $dischargePlanning->ketergantungan_orang_lain = $request->ketergantungan_orang_lain ?? $dischargePlanning->ketergantungan_orang_lain;
        $dischargePlanning->rencana_pulang = $request->rencana_pulang ?? $dischargePlanning->rencana_pulang;
        $dischargePlanning->kesimpulan = $request->kesimpulan ?? $dischargePlanning->kesimpulan ?? 'Tidak membutuhkan rencana pulang khusus';
        $dischargePlanning->save();
    }

    private function updateTtv($request, $asesmen)
    {
        $ttv = RmeAsesmenKepRajalTtv::firstOrNew(['id_asesmen' => $asesmen->id]);
        $ttv->id_asesmen = $asesmen->id;
        $ttv->sistolik = $request->sistolik ?? $ttv->sistolik;
        $ttv->diastolik = $request->diastolik ?? $ttv->diastolik;
        $ttv->nadi = $request->nadi ?? $ttv->nadi;
        $ttv->nafas_per_menit = $request->nafas_per_menit ?? $ttv->nafas_per_menit;
        $ttv->suhu = $request->suhu ?? $ttv->suhu;
        $ttv->save();
    }

    private function updateSkalaNyeri($request, $asesmen)
    {
        $skalaNyeri = RmeAsesmenKepRajalSkalaNyeri::firstOrNew(['id_asesmen' => $asesmen->id]);
        $skalaNyeri->id_asesmen = $asesmen->id;
        $skalaNyeri->skala_nyeri = $request->skala_nyeri ?? $skalaNyeri->skala_nyeri;
        $skalaNyeri->skala_nyeri_lokasi = $request->skala_nyeri_lokasi ?? $skalaNyeri->skala_nyeri_lokasi;
        $skalaNyeri->skala_nyeri_durasi = $request->skala_nyeri_durasi ?? $skalaNyeri->skala_nyeri_durasi;
        $skalaNyeri->skala_nyeri_pemberat_id = $request->skala_nyeri_pemberat_id ?? $skalaNyeri->skala_nyeri_pemberat_id;
        $skalaNyeri->skala_nyeri_peringan_id = $request->skala_nyeri_peringan_id ?? $skalaNyeri->skala_nyeri_peringan_id;
        $skalaNyeri->skala_nyeri_kualitas_id = $request->skala_nyeri_kualitas_id ?? $skalaNyeri->skala_nyeri_kualitas_id;
        $skalaNyeri->skala_nyeri_frekuensi_id = $request->skala_nyeri_frekuensi_id ?? $skalaNyeri->skala_nyeri_frekuensi_id;
        $skalaNyeri->skala_nyeri_menjalar_id = $request->skala_nyeri_menjalar_id ?? $skalaNyeri->skala_nyeri_menjalar_id;
        $skalaNyeri->skala_nyeri_jenis_id = $request->skala_nyeri_jenis_id ?? $skalaNyeri->skala_nyeri_jenis_id;
        $skalaNyeri->save();
    }

    private function updateSosialBudaya($request, $asesmen)
    {
        $sosialBudaya = RmeAsesmenKepRajalSosialBudaya::firstOrNew(['id_asesmen' => $asesmen->id]);
        $sosialBudaya->id_asesmen = $asesmen->id;
        $sosialBudaya->pekerjaan = $request->sosial_budaya_pekerjaan ?? $sosialBudaya->pekerjaan;
        $sosialBudaya->kesulitan_memenuhi_kebutuhan_dasar = $request->sosial_budaya_kesulitan_memenuhi_kebutuhan_dasar ?? $sosialBudaya->kesulitan_memenuhi_kebutuhan_dasar;
        $sosialBudaya->hubungan_dengan_anggota_keluarga = $request->sosial_budaya_hubungan_dengan_anggota_keluarga ?? $sosialBudaya->hubungan_dengan_anggota_keluarga;
        $sosialBudaya->suku = $request->sosial_budaya_suku ?? $sosialBudaya->suku;
        $sosialBudaya->pendidikan = $request->sosial_budaya_status_pendidikan ?? $sosialBudaya->pendidikan;
        $sosialBudaya->budaya_atau_yang_dipercaya = $request->sosial_budaya_budaya_atau_yang_dipercaya ?? $sosialBudaya->budaya_atau_yang_dipercaya;
        $sosialBudaya->save();
    }

    private function updateRisikoJatuh($request, $asesmen)
    {
        $risikoJatuh = RmeAsesmenKepRajalRisikoJatuh::firstOrNew(['id_asesmen' => $asesmen->id]);
        $risikoJatuh->id_asesmen = $asesmen->id;
        $risikoJatuh->resiko_jatuh_jenis = (int)$request->resiko_jatuh_jenis;
        $risikoJatuh->risik_jatuh_tindakan = $request->risikojatuh_tindakan_keperawatan ? json_encode($request->risikojatuh_tindakan_keperawatan) : null;

        // Reset all fields first
        $this->resetRisikoJatuhFields($risikoJatuh);

        // Handle different scales similar to store method
        if ($request->resiko_jatuh_jenis == 1) {
            $risikoJatuh->risiko_jatuh_umum_usia = $request->risiko_jatuh_umum_usia ? 1 : 0;
            $risikoJatuh->risiko_jatuh_umum_kondisi_khusus = $request->risiko_jatuh_umum_kondisi_khusus ? 1 : 0;
            $risikoJatuh->risiko_jatuh_umum_diagnosis_parkinson = $request->risiko_jatuh_umum_diagnosis_parkinson ? 1 : 0;
            $risikoJatuh->risiko_jatuh_umum_pengobatan_berisiko = $request->risiko_jatuh_umum_pengobatan_berisiko ? 1 : 0;
            $risikoJatuh->risiko_jatuh_umum_lokasi_berisiko = $request->risiko_jatuh_umum_lokasi_berisiko ? 1 : 0;
            $risikoJatuh->risiko_jatuh_umum_kesimpulan = $request->input('risiko_jatuh_umum_kesimpulan', 'Tidak berisiko jatuh');
        }
        // Handle Skala Morse
        else if ($request->resiko_jatuh_jenis == 2) {
            $risikoJatuh->risiko_jatuh_morse_riwayat_jatuh = array_search($request->risiko_jatuh_morse_riwayat_jatuh, ['25' => 25, '0' => 0]);
            $risikoJatuh->risiko_jatuh_morse_diagnosis_sekunder = array_search($request->risiko_jatuh_morse_diagnosis_sekunder, ['15' => 15, '0' => 0]);
            $risikoJatuh->risiko_jatuh_morse_bantuan_ambulasi = array_search($request->risiko_jatuh_morse_bantuan_ambulasi, ['30' => 30, '15' => 15, '0' => 0]);
            $risikoJatuh->risiko_jatuh_morse_terpasang_infus = array_search($request->risiko_jatuh_morse_terpasang_infus, ['20' => 20, '0' => 0]);
            $risikoJatuh->risiko_jatuh_morse_cara_berjalan = array_search($request->risiko_jatuh_morse_cara_berjalan, ['0' => 0, '20' => 20, 10 => 10]);
            $risikoJatuh->risiko_jatuh_morse_status_mental = array_search($request->risiko_jatuh_morse_status_mental, ['0' => 0, '15' => 15]);
            $risikoJatuh->risiko_jatuh_morse_kesimpulan = $request->risiko_jatuh_morse_kesimpulan;
        }
        // Handle Skala Pediatrik/Humpty
        else if ($request->resiko_jatuh_jenis == 3) {
            $risikoJatuh->risiko_jatuh_pediatrik_usia_anak = array_search((int)$request->risiko_jatuh_pediatrik_usia_anak, ['4' => 4, '3' => 3, '2' => 2, '1' => 1]);
            $risikoJatuh->risiko_jatuh_pediatrik_jenis_kelamin = array_search($request->risiko_jatuh_pediatrik_jenis_kelamin, ['2' => 2, '1' => 1]);
            $risikoJatuh->risiko_jatuh_pediatrik_diagnosis = array_search($request->risiko_jatuh_pediatrik_diagnosis, ['4' => 4, '3' => 3, '2' => 2, '1' => 1]);
            $risikoJatuh->risiko_jatuh_pediatrik_gangguan_kognitif = array_search($request->risiko_jatuh_pediatrik_gangguan_kognitif, ['3' => 3, '2' => 2, '1' => 1]);
            $risikoJatuh->risiko_jatuh_pediatrik_faktor_lingkungan = array_search($request->risiko_jatuh_pediatrik_faktor_lingkungan, ['4' => 4, '3' => 3, '2' => 2, '1' => 1]);
            $risikoJatuh->risiko_jatuh_pediatrik_pembedahan = array_search($request->risiko_jatuh_pediatrik_pembedahan, ['3' => 3, '2' => 2, '1' => 1]);
            $risikoJatuh->risiko_jatuh_pediatrik_penggunaan_mentosa = array_search($request->risiko_jatuh_pediatrik_penggunaan_mentosa, ['3' => 3, '2' => 2, '1' => 1]);
            $risikoJatuh->risiko_jatuh_pediatrik_kesimpulan = $request->risiko_jatuh_pediatrik_kesimpulan;
        }
        // Handle Skala Lansia/Ontario
        else if ($request->resiko_jatuh_jenis == 4) {
            $risikoJatuh->risiko_jatuh_lansia_jatuh_saat_masuk_rs = array_search($request->risiko_jatuh_lansia_jatuh_saat_masuk_rs, ['6' => 6, '0' => 0]);
            $risikoJatuh->risiko_jatuh_lansia_riwayat_jatuh_2_bulan = array_search($request->risiko_jatuh_lansia_riwayat_jatuh_2_bulan, ['6' => 6, '0' => 0]);
            $risikoJatuh->risiko_jatuh_lansia_status_bingung = array_search($request->risiko_jatuh_lansia_status_bingung, ['14' => 14, '0' => 0]);
            $risikoJatuh->risiko_jatuh_lansia_status_disorientasi = array_search($request->risiko_jatuh_lansia_status_disorientasi, ['14' => 14, '0' => 0]);
            $risikoJatuh->risiko_jatuh_lansia_status_agitasi = array_search($request->risiko_jatuh_lansia_status_agitasi, ['14' => 14, '0' => 0]);
            $risikoJatuh->risiko_jatuh_lansia_kacamata = $request->risiko_jatuh_lansia_kacamata;
            $risikoJatuh->risiko_jatuh_lansia_kelainan_penglihatan = $request->risiko_jatuh_lansia_kelainan_penglihatan;
            $risikoJatuh->risiko_jatuh_lansia_glukoma = $request->risiko_jatuh_lansia_glukoma;
            $risikoJatuh->risiko_jatuh_lansia_perubahan_berkemih = array_search($request->risiko_jatuh_lansia_perubahan_berkemih, ['2' => 2, '0' => 0]);
            $risikoJatuh->risiko_jatuh_lansia_transfer_mandiri = $request->risiko_jatuh_lansia_transfer_mandiri;
            $risikoJatuh->risiko_jatuh_lansia_transfer_bantuan_sedikit = $request->risiko_jatuh_lansia_transfer_bantuan_sedikit;
            $risikoJatuh->risiko_jatuh_lansia_transfer_bantuan_nyata = array_search($request->risiko_jatuh_lansia_transfer_bantuan_nyata, ['2' => 2, '0' => 0]);
            $risikoJatuh->risiko_jatuh_lansia_transfer_bantuan_total = array_search($request->risiko_jatuh_lansia_transfer_bantuan_total, ['3' => 2, '0' => 0]);
            $risikoJatuh->risiko_jatuh_lansia_mobilitas_mandiri = $request->risiko_jatuh_lansia_mobilitas_mandiri;
            $risikoJatuh->risiko_jatuh_lansia_mobilitas_bantuan_1_orang = $request->risiko_jatuh_lansia_mobilitas_bantuan_1_orang;
            $risikoJatuh->risiko_jatuh_lansia_mobilitas_kursi_roda = array_search($request->risiko_jatuh_lansia_mobilitas_kursi_roda, ['2' => 2, '0' => 0]);
            $risikoJatuh->risiko_jatuh_lansia_mobilitas_imobilisasi = array_search($request->risiko_jatuh_lansia_mobilitas_imobilisasi, ['3' => 2, '0' => 0]);
            $risikoJatuh->risiko_jatuh_lansia_kesimpulan = $request->risiko_jatuh_lansia_kesimpulan;
        } else if ($request->resiko_jatuh_jenis == 5) {
            $risikoJatuh->resiko_jatuh_lainnya = 'resiko jatuh lainnya';
        }
        $risikoJatuh->save();
    }

    private function updateStatusGizi($request, $asesmen)
    {
        $statusGizi = RmeAsesmenKepRajalGizi::firstOrNew(['id_asesmen' => $asesmen->id]);
        $statusGizi->id_asesmen = $asesmen->id;
        $statusGizi->gizi_jenis = (int)$request->gizi_jenis;

        // Reset all gizi fields first
        $this->resetGiziFields($statusGizi);

        // Handle MST Form
        if ($request->gizi_jenis == 1) {
            $statusGizi->gizi_mst_penurunan_bb = $request->gizi_mst_penurunan_bb;
            $statusGizi->gizi_mst_jumlah_penurunan_bb = $request->gizi_mst_jumlah_penurunan_bb;
            $statusGizi->gizi_mst_nafsu_makan_berkurang = $request->gizi_mst_nafsu_makan_berkurang;
            $statusGizi->gizi_mst_diagnosis_khusus = $request->gizi_mst_diagnosis_khusus;
            $statusGizi->gizi_mst_kesimpulan = $request->gizi_mst_kesimpulan;
        }
        // Handle MNA Form
        else if ($request->gizi_jenis == 2) {
            $statusGizi->gizi_mna_penurunan_asupan_3_bulan = (int)$request->gizi_mna_penurunan_asupan_3_bulan;
            $statusGizi->gizi_mna_kehilangan_bb_3_bulan = (int)$request->gizi_mna_kehilangan_bb_3_bulan;
            $statusGizi->gizi_mna_mobilisasi = (int)$request->gizi_mna_mobilisasi;
            $statusGizi->gizi_mna_stress_penyakit_akut = (int)$request->gizi_mna_stress_penyakit_akut;
            $statusGizi->gizi_mna_status_neuropsikologi = (int)$request->gizi_mna_status_neuropsikologi;
            $statusGizi->gizi_mna_berat_badan = (int)$request->gizi_mna_berat_badan;
            $statusGizi->gizi_mna_tinggi_badan = (int)$request->gizi_mna_tinggi_badan;
            // Hitung dan simpan IMT
            if ($request->gizi_mna_tinggi_badan && $request->gizi_mna_berat_badan) {
                $heightInMeters = $request->gizi_mna_tinggi_badan / 100;
                $imt = $request->gizi_mna_berat_badan / ($heightInMeters * $heightInMeters);
                $statusGizi->gizi_mna_imt = number_format($imt, 2, '.', '');
            }
            $statusGizi->gizi_mna_kesimpulan = $request->gizi_mna_kesimpulan;
        }
        // Handle Strong Kids Form
        else if ($request->gizi_jenis == 3) {
            $statusGizi->gizi_strong_status_kurus = $request->gizi_strong_status_kurus;
            $statusGizi->gizi_strong_penurunan_bb = $request->gizi_strong_penurunan_bb;
            $statusGizi->gizi_strong_gangguan_pencernaan = $request->gizi_strong_gangguan_pencernaan;
            $statusGizi->gizi_strong_penyakit_berisiko = $request->gizi_strong_penyakit_berisiko;
            $statusGizi->gizi_strong_kesimpulan = $request->gizi_strong_kesimpulan;
        }
        // Handle NRS Form
        else if ($request->gizi_jenis == 4) {
            $statusGizi->gizi_nrs_jatuh_saat_masuk_rs = $request->gizi_nrs_jatuh_saat_masuk_rs;
            $statusGizi->gizi_nrs_jatuh_2_bulan_terakhir = $request->gizi_nrs_jatuh_2_bulan_terakhir;
            $statusGizi->gizi_nrs_status_delirium = $request->gizi_nrs_status_delirium;
            $statusGizi->gizi_nrs_status_disorientasi = $request->gizi_nrs_status_disorientasi;
            $statusGizi->gizi_nrs_status_agitasi = $request->gizi_nrs_status_agitasi;
            $statusGizi->gizi_nrs_menggunakan_kacamata = $request->gizi_nrs_menggunakan_kacamata;
            $statusGizi->gizi_nrs_keluhan_penglihatan_buram = $request->gizi_nrs_keluhan_penglihatan_buram;
            $statusGizi->gizi_nrs_degenerasi_makula = $request->gizi_nrs_degenerasi_makula;
            $statusGizi->gizi_nrs_perubahan_berkemih = $request->gizi_nrs_perubahan_berkemih;
            $statusGizi->gizi_nrs_transfer_mandiri = $request->gizi_nrs_transfer_mandiri;
            $statusGizi->gizi_nrs_transfer_bantuan_1_orang = $request->gizi_nrs_transfer_bantuan_1_orang;
            $statusGizi->gizi_nrs_transfer_bantuan_2_orang = $request->gizi_nrs_transfer_bantuan_2_orang;
            $statusGizi->gizi_nrs_transfer_bantuan_total = $request->gizi_nrs_transfer_bantuan_total;
            $statusGizi->gizi_nrs_mobilitas_mandiri = $request->gizi_nrs_mobilitas_mandiri;
            $statusGizi->gizi_nrs_mobilitas_bantuan_1_orang = $request->gizi_nrs_mobilitas_bantuan_1_orang;
            $statusGizi->gizi_nrs_mobilitas_kursi_roda = $request->gizi_nrs_mobilitas_kursi_roda;
            $statusGizi->gizi_nrs_mobilitas_imobilisasi = $request->gizi_nrs_mobilitas_imobilisasi;
            $statusGizi->gizi_nrs_kesimpulan = $request->gizi_nrs_kesimpulan;
        } else if ($request->gizi_jenis == 5) {
            $statusGizi->status_gizi_tidakada = 'tidak ada status gizi';
        }
        $statusGizi->save();
    }

    private function resetGiziFields($model)
    {
        // Reset MST fields
        $model->gizi_mst_penurunan_bb = null;
        $model->gizi_mst_jumlah_penurunan_bb = null;
        $model->gizi_mst_nafsu_makan_berkurang = null;
        $model->gizi_mst_diagnosis_khusus = null;
        $model->gizi_mst_kesimpulan = null;

        // Reset MNA fields
        $model->gizi_mna_penurunan_asupan_3_bulan = null;
        $model->gizi_mna_kehilangan_bb_3_bulan = null;
        $model->gizi_mna_mobilisasi = null;
        $model->gizi_mna_stress_penyakit_akut = null;
        $model->gizi_mna_status_neuropsikologi = null;
        $model->gizi_mna_berat_badan = null;
        $model->gizi_mna_tinggi_badan = null;
        $model->gizi_mna_imt = null;
        $model->gizi_mna_kesimpulan = null;

        // Reset Strong Kids fields
        $model->gizi_strong_status_kurus = null;
        $model->gizi_strong_penurunan_bb = null;
        $model->gizi_strong_gangguan_pencernaan = null;
        $model->gizi_strong_penyakit_berisiko = null;
        $model->gizi_strong_kesimpulan = null;

        // Reset status gizi tidak ada
        $model->status_gizi_tidakada = null;
    }

    private function resetRisikoJatuhFields($model)
    {
        // Reset all risiko jatuh fields to null
        $model->risiko_jatuh_umum_usia = null;
        $model->risiko_jatuh_umum_kondisi_khusus = null;
        $model->risiko_jatuh_umum_diagnosis_parkinson = null;
        $model->risiko_jatuh_umum_pengobatan_berisiko = null;
        $model->risiko_jatuh_umum_lokasi_berisiko = null;
        $model->risiko_jatuh_umum_kesimpulan = null;

        // Reset Morse fields
        $model->risiko_jatuh_morse_riwayat_jatuh = null;
        $model->risiko_jatuh_morse_diagnosis_sekunder = null;
        $model->risiko_jatuh_morse_bantuan_ambulasi = null;
        $model->risiko_jatuh_morse_terpasang_infus = null;
        $model->risiko_jatuh_morse_cara_berjalan = null;
        $model->risiko_jatuh_morse_status_mental = null;
        $model->risiko_jatuh_morse_kesimpulan = null;

        // Reset Pediatrik fields
        $model->risiko_jatuh_pediatrik_usia_anak = null;
        $model->risiko_jatuh_pediatrik_jenis_kelamin = null;
        $model->risiko_jatuh_pediatrik_diagnosis = null;
        $model->risiko_jatuh_pediatrik_gangguan_kognitif = null;
        $model->risiko_jatuh_pediatrik_faktor_lingkungan = null;
        $model->risiko_jatuh_pediatrik_pembedahan = null;
        $model->risiko_jatuh_pediatrik_penggunaan_mentosa = null;
        $model->risiko_jatuh_pediatrik_kesimpulan = null;

        // Reset Lansia fields
        $model->risiko_jatuh_lansia_jatuh_saat_masuk_rs = null;
        $model->risiko_jatuh_lansia_riwayat_jatuh_2_bulan = null;
        $model->risiko_jatuh_lansia_status_bingung = null;
        $model->risiko_jatuh_lansia_status_disorientasi = null;
        $model->risiko_jatuh_lansia_status_agitasi = null;
        $model->risiko_jatuh_lansia_kacamata = null;
        $model->risiko_jatuh_lansia_kelainan_penglihatan = null;
        $model->risiko_jatuh_lansia_glukoma = null;
        $model->risiko_jatuh_lansia_perubahan_berkemih = null;
        $model->risiko_jatuh_lansia_transfer_mandiri = null;
        $model->risiko_jatuh_lansia_transfer_bantuan_sedikit = null;
        $model->risiko_jatuh_lansia_transfer_bantuan_nyata = null;
        $model->risiko_jatuh_lansia_transfer_bantuan_total = null;
        $model->risiko_jatuh_lansia_mobilitas_mandiri = null;
        $model->risiko_jatuh_lansia_mobilitas_bantuan_1_orang = null;
        $model->risiko_jatuh_lansia_mobilitas_kursi_roda = null;
        $model->risiko_jatuh_lansia_mobilitas_imobilisasi = null;
        $model->risiko_jatuh_lansia_kesimpulan = null;

        // Reset lainnya
        $model->resiko_jatuh_lainnya = null;
    }

}
