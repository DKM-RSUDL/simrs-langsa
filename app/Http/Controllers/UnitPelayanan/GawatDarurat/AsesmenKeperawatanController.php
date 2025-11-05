<?php

namespace App\Http\Controllers\UnitPelayanan\GawatDarurat;

use App\Http\Controllers\Controller;
use App\Models\Agama;
use App\Models\Kunjungan;
use App\Models\Pekerjaan;
use App\Models\Pendidikan;
use App\Models\RmeAsesmen;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

use Illuminate\Support\Facades\DB;
use App\Models\RmeAsesmenKepUmum;
use App\Models\RmeAsesmenKepUmumBreathing;
use App\Models\RmeAsesmenKepUmumCirculation;
use App\Models\RmeAsesmenKepUmumDisability;
use App\Models\RmeAsesmenKepUmumExpo;
use App\Models\RmeAsesmenKepUmumExposure;
use App\Models\RmeAsesmenKepUmumGizi;
use App\Models\RmeAsesmenKepUmumRisikoJatuh;
use App\Models\RmeAsesmenKepUmumSkalaNyeri;
use App\Models\RmeAsesmenKepUmumSosialEkonomi;
use App\Models\RmeFaktorPemberat;
use App\Models\RmeFaktorPeringan;
use App\Models\RmeFrekuensiNyeri;
use App\Models\RmeJenisNyeri;
use App\Models\RmeKualitasNyeri;
use App\Models\RmeMenjalar;
use App\Services\AsesmenService;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;

// use Illuminate\Support\Carbon;

class AsesmenKeperawatanController extends Controller
{
    private $baseService;
    private $asesmenService;
    private $kdUnit;

    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/gawat-darurat');
        $this->baseService = new BaseService();
        $this->asesmenService = new AsesmenService();
        $this->kdUnit = 3; // Gawat Darurat
    }

    public function index($kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $user = auth()->user();

        $dataMedis = $this->baseService->getDataMedis($this->kdUnit, $kd_pasien, $tgl_masuk, $urut_masuk);
        if (!$dataMedis) abort(404, 'Data not found');

        $pekerjaan = Pekerjaan::all();
        $faktorPemberat = RmeFaktorPemberat::all();
        $faktorPeringan = RmeFaktorPeringan::all();
        $kualitasNyeri = RmeKualitasNyeri::all();
        $frekuensiNyeri = RmeFrekuensiNyeri::all();
        $menjalar = RmeMenjalar::all();
        $jenisNyeri = RmeJenisNyeri::all();
        $agama = Agama::all();
        $pendidikan = Pendidikan::all();

        $rmeAsesmenKepUmum = RmeAsesmenKepUmum::select('masalah_keperawatan', 'implementasi')->get();

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        // Mengambil nama alergen dari riwayat_alergi
        if ($dataMedis->riwayat_alergi) {
            $dataMedis->riwayat_alergi = collect(json_decode($dataMedis->riwayat_alergi, true))
                ->pluck('alergen')
                ->all();
        } else {
            $dataMedis->riwayat_alergi = [];
        }

        $dataMedis->waktu_masuk = Carbon::parse($dataMedis->TGL_MASUK . ' ' . $dataMedis->JAM_MASUK)->format('Y-m-d H:i:s');

        // get asesmen data
        $asesmenMedis = RmeAsesmen::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', 3)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->orderBy('id', 'DESC')
            ->first();

        $vitalSignMedis = json_decode($asesmenMedis->vital_sign ?? '{}', true);


        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen-keperawatan.create', compact(
            'kd_pasien',
            'tgl_masuk',
            'dataMedis',
            'user',
            'pekerjaan',
            'rmeAsesmenKepUmum',
            'faktorPemberat',
            'faktorPeringan',
            'kualitasNyeri',
            'frekuensiNyeri',
            'menjalar',
            'jenisNyeri',
            'agama',
            'pendidikan',
            'asesmenMedis',
            'vitalSignMedis'
        ));
    }

    public function store(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        DB::beginTransaction();

        try {
            $dataMedis = $this->baseService->getDataMedis($this->kdUnit, $kd_pasien, $tgl_masuk, $urut_masuk);
            if (!$dataMedis) throw new Exception('Data medis tidak ditemukan.');

            $asesmen = new RmeAsesmen();
            $asesmen->kd_pasien = $kd_pasien;
            $asesmen->kd_unit = 3;
            $asesmen->tgl_masuk = $tgl_masuk;
            $asesmen->urut_masuk = $request->urut_masuk;
            $asesmen->user_id = Auth::id();
            $asesmen->waktu_asesmen = date('Y-m-d H:i:s');
            $asesmen->kategori = 2;
            $asesmen->sub_kategori = 1;
            $asesmen->save();

            $asesmenKepUmum = new RmeAsesmenKepUmum();
            $asesmenKepUmum->id_asesmen = $asesmen->id;
            $asesmenKepUmum->airway_status = $request->airway_status;
            $asesmenKepUmum->airway_suara_nafas = $request->airway_suara_nafas;
            $asesmenKepUmum->airway_diagnosis = $request->airway_diagnosis_type;
            $asesmenKepUmum->airway_tindakan = $request->airway_tindakan_keperawatan ? json_encode($request->airway_tindakan_keperawatan) : null;
            $asesmenKepUmum->psikologis_kondisi = $request->psikologis_kondisi;
            $asesmenKepUmum->psikologis_potensi_menyakiti = $request->psikologis_potensi_menyakiti;
            $asesmenKepUmum->psikologis_lainnya = $request->psikologis_lainnya;
            $asesmenKepUmum->spiritual_agama = $request->spiritual_agama;
            $asesmenKepUmum->spiritual_nilai = $request->spiritual_nilai;
            $asesmenKepUmum->status_fungsional = $request->status_fungsional;
            $asesmenKepUmum->kebutuhan_edukasi_gaya_bicara = $request->kebutuhan_edukasi_gaya_bicara;
            $asesmenKepUmum->kebutuhan_edukasi_bahasa_sehari_hari = $request->kebutuhan_edukasi_bahasa_sehari_hari;
            $asesmenKepUmum->kebutuhan_edukasi_perlu_penerjemah = $request->kebutuhan_edukasi_perlu_penerjemah;
            $asesmenKepUmum->kebutuhan_edukasi_hambatan_komunikasi = $request->kebutuhan_edukasi_hambatan_komunikasi;
            $asesmenKepUmum->kebutuhan_edukasi_media_belajar = $request->kebutuhan_edukasi_media_belajar;
            $asesmenKepUmum->kebutuhan_edukasi_tingkat_pendidikan = $request->kebutuhan_edukasi_tingkat_pendidikan;
            $asesmenKepUmum->kebutuhan_edukasi_edukasi_dibutuhkan = $request->kebutuhan_edukasi_edukasi_dibutuhkan;
            $asesmenKepUmum->kebutuhan_edukasi_keterangan_lain = $request->kebutuhan_edukasi_keterangan_lain;
            $asesmenKepUmum->discharge_planning_diagnosis_medis = $request->discharge_planning_diagnosis_medis;
            $asesmenKepUmum->discharge_planning_usia_lanjut = $request->discharge_planning_usia_lanjut;
            $asesmenKepUmum->discharge_planning_hambatan_mobilisasi = $request->discharge_planning_hambatan_mobilisasi;
            $asesmenKepUmum->discharge_planning_pelayanan_medis = $request->discharge_planning_pelayanan_medis;
            $asesmenKepUmum->discharge_planning_ketergantungan_aktivitas = $request->discharge_planning_ketergantungan_aktivitas;
            $asesmenKepUmum->discharge_planning_kesimpulan = $request->discharge_planning_kesimpulan;
            $asesmenKepUmum->evaluasi = $request->evaluasi;
            $asesmenKepUmum->masalah_keperawatan = $request->masalah_keperawatan;
            $asesmenKepUmum->implementasi = $request->implementasi;
            $asesmenKepUmum->implementasi_keperawatan = $request->implementasi_keperawatan;
            $asesmenKepUmum->evaluasi_keperawatan = $request->evaluasi_keperawatan;
            $asesmenKepUmum->save();

            $asesmenKepUmumBreathing = new RmeAsesmenKepUmumBreathing();
            $asesmenKepUmumBreathing->id_asesmen = $asesmen->id;
            $asesmenKepUmumBreathing->breathing_frekuensi_nafas = $request->breathing_frekuensi_nafas;
            $asesmenKepUmumBreathing->breathing_pola_nafas = $request->breathing_pola_nafas;
            $asesmenKepUmumBreathing->breathing_bunyi_nafas = $request->breathing_bunyi_nafas;
            $asesmenKepUmumBreathing->breathing_irama_nafas = (int)$request->breathing_irama_nafas;
            $asesmenKepUmumBreathing->breathing_tanda_distress = $request->breathing_tanda_distress;
            $asesmenKepUmumBreathing->breathing_jalan_nafas = (int)$request->breathing_jalan_nafas;
            $asesmenKepUmumBreathing->breathing_lainnya = $request->breathing_lainnya;
            $asesmenKepUmumBreathing->breathing_tindakan = $request->breathing_tindakan_keperawatan ? json_encode($request->breathing_tindakan_keperawatan) : null;

            // Handle diagnosis nafas
            if ($request->has('breathing_diagnosis_nafas')) {
                $nafas_type = $request->breathing_diagnosis_type;

                // Simpan nilai berdasarkan radio button yang dipilih
                $asesmenKepUmumBreathing->breathing_diagnosis_nafas = $nafas_type ? (int)$nafas_type : null;
            }

            // Handle gangguan
            if ($request->has('breathing_gangguan')) {
                $gangguan_type = $request->breathing_gangguan_type;

                // Simpan nilai berdasarkan radio button yang dipilih
                $asesmenKepUmumBreathing->breathing_gangguan = $gangguan_type ? (int)$gangguan_type : null;
            }
            $asesmenKepUmumBreathing->save();

            $asesmenKepUmumCirculation = new RmeAsesmenKepUmumCirculation();
            $asesmenKepUmumCirculation->id_asesmen = $asesmen->id;
            $asesmenKepUmumCirculation->circulation_nadi = $request->circulation_nadi;
            $asesmenKepUmumCirculation->circulation_sistole = $request->circulation_sistole;
            $asesmenKepUmumCirculation->circulation_diastole = $request->circulation_diastole;
            $asesmenKepUmumCirculation->circulation_akral = $request->circulation_akral;
            $asesmenKepUmumCirculation->circulation_pucat = $request->circulation_pucat;
            $asesmenKepUmumCirculation->circulation_cianosis = $request->circulation_cianosis;
            $asesmenKepUmumCirculation->circulation_kapiler = $request->circulation_kapiler;
            $asesmenKepUmumCirculation->circulation_kelembapan_kulit = $request->circulation_kelembapan_kulit;
            $asesmenKepUmumCirculation->circulation_turgor = $request->circulation_turgor;
            $asesmenKepUmumCirculation->circulation_transfusi = $request->circulation_transfusi;
            $asesmenKepUmumCirculation->circulation_transfusi_jumlah = $request->circulation_transfusi_jumlah;
            $asesmenKepUmumCirculation->circulation_nadi_irama = $request->circulation_nadi_irama;
            $asesmenKepUmumCirculation->circulation_nadi_kekuatan = $request->circulation_nadi_kekuatan;

            if ($request->has('circulation_diagnosis_perfusi')) {
                $perfusi_selected = $request->circulation_diagnosis_perfusi;
                $perfusi_type = $request->circulation_diagnosis_perfusi_type;

                // Simpan sebagai angka (0: null, 1: aktual, 2: risiko)
                $asesmenKepUmumCirculation->circulation_diagnosis_perfusi = in_array('perfusi_jaringan_perifer_tidak_efektif', $perfusi_selected) ?
                    ($perfusi_type == 'aktual' ? 1 : ($perfusi_type == 'risiko' ? 2 : null)) : null;
            }

            if ($request->has('circulation_diagnosis_defisit')) {
                $defisit_selected = $request->circulation_diagnosis_defisit;
                $defisit_type = $request->circulation_diagnosis_defisit_type;

                // Simpan sebagai angka (0: null, 1: aktual, 2: risiko)
                $asesmenKepUmumCirculation->circulation_diagnosis_defisit = in_array('defisit_volume_cairan', $defisit_selected) ?
                    ($defisit_type == 'aktual' ? 1 : ($defisit_type == 'risiko' ? 2 : null)) : null;
            }
            $asesmenKepUmumCirculation->circulation_lain = $request->circulation_lain;
            $asesmenKepUmumCirculation->circulation_tindakan = $request->circulation_tindakan_keperawatan ? json_encode($request->circulation_tindakan_keperawatan) : null;
            $asesmenKepUmumCirculation->save();

            $asesmenKepUmumDisability = new RmeAsesmenKepUmumDisability();
            $asesmenKepUmumDisability->id_asesmen = $asesmen->id;
            $asesmenKepUmumDisability->disability_kesadaran = $request->disability_kesadaran;
            $asesmenKepUmumDisability->disability_isokor = $request->disability_isokor;
            $asesmenKepUmumDisability->disability_respon_cahaya = $request->disability_respon_cahaya;
            $asesmenKepUmumDisability->disability_diameter_pupil = $request->disability_diameter_pupil;
            $asesmenKepUmumDisability->disability_motorik = $request->disability_motorik;
            $asesmenKepUmumDisability->disability_sensorik = $request->disability_sensorik;
            $asesmenKepUmumDisability->disability_kekuatan_otot = $request->disability_kekuatan_otot;

            // Diagnosis Perfusi
            if ($request->has('disability_diagnosis_perfusi')) {
                $perfusiSelected = $request->disability_diagnosis_perfusi;
                $perfusiType = $request->disability_diagnosis_perfusi_type ?? null;

                // Konversi nilai "aktual" ke 1, "risiko" ke 2, atau 0 jika tidak dipilih
                $asesmenKepUmumDisability->disability_diagnosis_perfusi = in_array('perfusi_jaringan_cereberal_tidak_efektif', $perfusiSelected)
                    ? ($perfusiType === '1' ? 1 : ($perfusiType === '2' ? 2 : 0))
                    : 0;
            }

            // Diagnosis Intoleransi
            if ($request->has('disability_diagnosis_intoleransi')) {
                $intoleransiSelected = $request->disability_diagnosis_intoleransi;
                $intoleransiType = $request->disability_diagnosis_intoleransi_type ?? null;

                $asesmenKepUmumDisability->disability_diagnosis_intoleransi = in_array('intoleransi_aktivitas', $intoleransiSelected)
                    ? ($intoleransiType === '1' ? 1 : ($intoleransiType === '2' ? 2 : 0))
                    : 0;
            }

            // Diagnosis Komunikasi
            if ($request->has('disability_diagnosis_komunikasi')) {
                $komunikasiSelected = $request->disability_diagnosis_komunikasi;
                $komunikasiType = $request->disability_diagnosis_komunikasi_type ?? null;

                $asesmenKepUmumDisability->disability_diagnosis_komunikasi = in_array('kendala_komunikasi_verbal', $komunikasiSelected)
                    ? ($komunikasiType === '1' ? 1 : ($komunikasiType === '2' ? 2 : 0))
                    : 0;
            }

            // Diagnosis Kejang
            if ($request->has('disability_diagnosis_kejang')) {
                $kejangSelected = $request->disability_diagnosis_kejang;
                $kejangType = $request->disability_diagnosis_kejang_type ?? null;

                $asesmenKepUmumDisability->disability_diagnosis_kejang = in_array('kejang_ulang', $kejangSelected)
                    ? ($kejangType === '1' ? 1 : ($kejangType === '2' ? 2 : 0))
                    : 0;
            }

            // Diagnosis Kesadaran
            if ($request->has('disability_diagnosis_kesadaran')) {
                $kesadaranSelected = $request->disability_diagnosis_kesadaran;
                $kesadaranType = $request->disability_diagnosis_kesadaran_type ?? null;

                $asesmenKepUmumDisability->disability_diagnosis_kesadaran = in_array('penurunan_kesadaran', $kesadaranSelected)
                    ? ($kesadaranType == '1' ? 1 : ($kesadaranType == '2' ? 2 : 0))
                    : 0;
            }

            // Konversi tindakan ke JSON
            $asesmenKepUmumDisability->disability_lainnya = $request->disability_lainnya;
            $asesmenKepUmumDisability->disability_tindakan = $request->disability_tindakan_keperawatan ? json_encode($request->disability_tindakan_keperawatan) : null;
            $asesmenKepUmumDisability->vital_sign = $request->vital_sign ? json_encode($request->vital_sign) : null;
            $asesmenKepUmumDisability->save();

            $asesmenKepUmumExposure = new RmeAsesmenKepUmumExposure();
            $asesmenKepUmumExposure->id_asesmen = $asesmen->id;
            // Exposure Deformitas
            $asesmenKepUmumExposure->exposure_deformitas = $request->exposure_deformitas;
            $asesmenKepUmumExposure->exposure_deformitas_daerah = $request->exposure_deformitas_daerah;
            // Exposure Kontusion
            $asesmenKepUmumExposure->exposure_kontusion = $request->exposure_kontusion;
            $asesmenKepUmumExposure->exposure_kontusion_daerah = $request->exposure_kontusion_daerah;
            // Exposure Abrasi
            $asesmenKepUmumExposure->exposure_abrasi = $request->exposure_abrasi;
            $asesmenKepUmumExposure->exposure_abrasi_daerah = $request->exposure_abrasi_daerah;
            // Exposure Penetrasi
            $asesmenKepUmumExposure->exposure_penetrasi = $request->exposure_penetrasi;
            $asesmenKepUmumExposure->exposure_penetrasi_daerah = $request->exposure_penetrasi_daerah;
            // Exposure Laserasi
            $asesmenKepUmumExposure->exposure_laserasi = $request->exposure_laserasi;
            $asesmenKepUmumExposure->exposure_laserasi_daerah = $request->exposure_laserasi_daerah;
            // Exposure Edema
            $asesmenKepUmumExposure->exposure_edema = $request->exposure_edema;
            $asesmenKepUmumExposure->exposure_edema_daerah = $request->exposure_edema_daerah;
            // Exposure Lainnya
            $asesmenKepUmumExposure->exposure_kedalaman_luka = $request->exposure_kedalaman_luka;
            $asesmenKepUmumExposure->exposure_lainnya = $request->exposure_lainnya;

            // Diagnosis
            if ($request->has('exposure_diagnosis_mobilitasi')) {
                $mobilitasi_type = $request->exposure_diagnosis_mobilitasi_type;

                // Simpan nilai berdasarkan radio button yang dipilih
                $asesmenKepUmumExposure->exposure_diagnosis_mobilitasi = $mobilitasi_type ? (int)$mobilitasi_type : null;
            }

            // exposure_diagosis_integritas
            if ($request->has('exposure_diagosis_integritas')) {
                $integritas_type = $request->exposure_diagosis_integritas_type;

                // Simpan nilai berdasarkan radio button yang dipilih
                $asesmenKepUmumExposure->exposure_diagosis_integritas = $integritas_type ? (int)$integritas_type : null;
            }

            // Diagnosis Lainnya dan Tindakan
            $asesmenKepUmumExposure->exposure_diagnosis_lainnya = $request->exposure_diagnosis_lainnya;
            $asesmenKepUmumExposure->exposure_tindakan = $request->exposure_tindakan_keperawatan ? json_encode($request->exposure_tindakan_keperawatan) : null;
            $asesmenKepUmumExposure->save();

            $asesmenKepUmumExposure = new RmeAsesmenKepUmumSosialEkonomi();
            $asesmenKepUmumExposure->id_asesmen = $asesmen->id;
            $asesmenKepUmumExposure->sosial_ekonomi_pekerjaan = $request->sosial_ekonomi_pekerjaan;
            $asesmenKepUmumExposure->sosial_ekonomi_tingkat_penghasilan = $request->sosial_ekonomi_tingkat_penghasilan;
            $asesmenKepUmumExposure->sosial_ekonomi_status_pernikahan = $request->sosial_ekonomi_status_pernikahan;
            $asesmenKepUmumExposure->sosial_ekonomi_status_pendidikan = $request->sosial_ekonomi_status_pendidikan;
            $asesmenKepUmumExposure->sosial_ekonomi_tempat_tinggal = $request->sosial_ekonomi_tempat_tinggal;
            $asesmenKepUmumExposure->sosial_ekonomi_tinggal_dengan_keluarga = $request->sosial_ekonomi_tinggal_dengan_keluarga;
            $asesmenKepUmumExposure->sosial_ekonomi_curiga_penganiayaan = $request->sosial_ekonomi_curiga_penganiayaan;
            $asesmenKepUmumExposure->sosial_ekonomi_curiga_kesulitan = $request->sosial_ekonomi_curiga_kesulitan;
            $asesmenKepUmumExposure->sosial_ekonomi_curiga_hubungan_keluarga = $request->sosial_ekonomi_curiga_hubungan_keluarga;
            $asesmenKepUmumExposure->sosial_ekonomi_curiga_suku = $request->sosial_ekonomi_curiga_suku;
            $asesmenKepUmumExposure->sosial_ekonomi_curiga_budaya = $request->sosial_ekonomi_curiga_budaya;
            $asesmenKepUmumExposure->sosial_ekonomi_keterangan_lain = $request->sosial_ekonomi_keterangan_lain;
            $asesmenKepUmumExposure->save();

            $asesmenKepUmumStatusNyeri = new RmeAsesmenKepUmumSkalaNyeri();
            $asesmenKepUmumStatusNyeri->id_asesmen = $asesmen->id;
            $asesmenKepUmumStatusNyeri->skala_nyeri = $request->skala_nyeri;
            $asesmenKepUmumStatusNyeri->skala_nyeri_lokasi = $request->skala_nyeri_lokasi;
            $asesmenKepUmumStatusNyeri->skala_nyeri_durasi = $request->skala_nyeri_durasi;
            $asesmenKepUmumStatusNyeri->skala_nyeri_pemberat_id = $request->skala_nyeri_pemberat_id;
            $asesmenKepUmumStatusNyeri->skala_nyeri_peringan_id = $request->skala_nyeri_peringan_id;
            $asesmenKepUmumStatusNyeri->skala_nyeri_kualitas_id = $request->skala_nyeri_kualitas_id;
            $asesmenKepUmumStatusNyeri->skala_nyeri_frekuensi_id = $request->skala_nyeri_frekuensi_id;
            $asesmenKepUmumStatusNyeri->skala_nyeri_menjalar_id = $request->skala_nyeri_menjalar_id;
            $asesmenKepUmumStatusNyeri->skala_nyeri_jenis_id = $request->skala_nyeri_jenis_id;
            $asesmenKepUmumStatusNyeri->save();

            $asesmenKepUmumRisikoJatuh = new RmeAsesmenKepUmumRisikoJatuh();
            $asesmenKepUmumRisikoJatuh->id_asesmen = $asesmen->id;
            $asesmenKepUmumRisikoJatuh->resiko_jatuh_jenis = (int)$request->resiko_jatuh_jenis;
            $asesmenKepUmumRisikoJatuh->risik_jatuh_tindakan = $request->risikojatuh_tindakan_keperawatan ? json_encode($request->risikojatuh_tindakan_keperawatan) : null;

            // Handle Skala Umum
            if ($request->resiko_jatuh_jenis == 1) {
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_umum_usia = $request->risiko_jatuh_umum_usia ? 1 : 0;
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_umum_kondisi_khusus = $request->risiko_jatuh_umum_kondisi_khusus ? 1 : 0;
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_umum_diagnosis_parkinson = $request->risiko_jatuh_umum_diagnosis_parkinson ? 1 : 0;
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_umum_pengobatan_berisiko = $request->risiko_jatuh_umum_pengobatan_berisiko ? 1 : 0;
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_umum_lokasi_berisiko = $request->risiko_jatuh_umum_lokasi_berisiko ? 1 : 0;
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_umum_kesimpulan = $request->input('risiko_jatuh_umum_kesimpulan', 'Tidak berisiko jatuh');
            }

            // Handle Skala Morse
            if ($request->resiko_jatuh_jenis == 2) {
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_riwayat_jatuh = array_search($request->risiko_jatuh_morse_riwayat_jatuh, ['25' => 25, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_diagnosis_sekunder = array_search($request->risiko_jatuh_morse_diagnosis_sekunder, ['15' => 15, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_bantuan_ambulasi = array_search($request->risiko_jatuh_morse_bantuan_ambulasi, ['30' => 30, '15' => 15, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_terpasang_infus = array_search($request->risiko_jatuh_morse_terpasang_infus, ['20' => 20, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_cara_berjalan = array_search($request->risiko_jatuh_morse_cara_berjalan, ['0' => 0, '20' => 20, 10 => 10]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_status_mental = array_search($request->risiko_jatuh_morse_status_mental, ['0' => 0, '15' => 15]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_kesimpulan = $request->risiko_jatuh_morse_kesimpulan;
                $asesmenKepUmumRisikoJatuh->save();
            }

            // Handle Skala Pediatrik/Humpty
            else if ($request->resiko_jatuh_jenis == 3) {
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_usia_anak = array_search((int)$request->risiko_jatuh_pediatrik_usia_anak, ['4' => 4, '3' => 3, '2' => 2, '1' => 1]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_jenis_kelamin = array_search($request->risiko_jatuh_pediatrik_jenis_kelamin, ['2' => 2, '1' => 1]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_diagnosis = array_search($request->risiko_jatuh_pediatrik_diagnosis, ['4' => 4, '3' => 3, '2' => 2, '1' => 1]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_gangguan_kognitif = array_search($request->risiko_jatuh_pediatrik_gangguan_kognitif, ['3' => 3, '2' => 2, '1' => 1]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_faktor_lingkungan = array_search($request->risiko_jatuh_pediatrik_faktor_lingkungan, ['4' => 4, '3' => 3, '2' => 2, '1' => 1]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_pembedahan = array_search($request->risiko_jatuh_pediatrik_pembedahan, ['3' => 3, '2' => 2, '1' => 1]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_penggunaan_mentosa = array_search($request->risiko_jatuh_pediatrik_penggunaan_mentosa, ['3' => 3, '2' => 2, '1' => 1]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_kesimpulan = $request->risiko_jatuh_pediatrik_kesimpulan;
            }

            // Handle Skala Lansia/Ontario
            else if ($request->resiko_jatuh_jenis == 4) {
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_jatuh_saat_masuk_rs = array_search($request->risiko_jatuh_lansia_jatuh_saat_masuk_rs, ['6' => 6, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_riwayat_jatuh_2_bulan = array_search($request->risiko_jatuh_lansia_riwayat_jatuh_2_bulan, ['6' => 6, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_status_bingung = array_search($request->risiko_jatuh_lansia_status_bingung, ['14' => 14, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_status_disorientasi = array_search($request->risiko_jatuh_lansia_status_disorientasi, ['14' => 14, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_status_agitasi = array_search($request->risiko_jatuh_lansia_status_agitasi, ['14' => 14, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_kacamata = $request->risiko_jatuh_lansia_kacamata;
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_kelainan_penglihatan = $request->risiko_jatuh_lansia_kelainan_penglihatan;
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_glukoma = $request->risiko_jatuh_lansia_glukoma;
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_perubahan_berkemih = array_search($request->risiko_jatuh_lansia_perubahan_berkemih, ['2' => 2, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_transfer_mandiri = $request->risiko_jatuh_lansia_transfer_mandiri;
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_sedikit = $request->risiko_jatuh_lansia_transfer_bantuan_sedikit;
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_nyata = array_search($request->risiko_jatuh_lansia_transfer_bantuan_nyata, ['2' => 2, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_total = array_search($request->risiko_jatuh_lansia_transfer_bantuan_total, ['3' => 2, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_mobilitas_mandiri = $request->risiko_jatuh_lansia_mobilitas_mandiri;
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_mobilitas_bantuan_1_orang = $request->risiko_jatuh_lansia_mobilitas_bantuan_1_orang;
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_mobilitas_kursi_roda = array_search($request->risiko_jatuh_lansia_mobilitas_kursi_roda, ['2' => 2, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_mobilitas_imobilisasi = array_search($request->risiko_jatuh_lansia_mobilitas_imobilisasi, ['3' => 2, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_kesimpulan = $request->risiko_jatuh_lansia_kesimpulan;
            } else if ($request->resiko_jatuh_jenis == 5) {
                $asesmenKepUmumRisikoJatuh->resiko_jatuh_lainnya = 'resiko jatuh lainnya';
            }
            $asesmenKepUmumRisikoJatuh->save();

            $asesmenKepUmumStatusGizi = new RmeAsesmenKepUmumGizi();
            $asesmenKepUmumStatusGizi->id_asesmen = $asesmen->id;
            $asesmenKepUmumStatusGizi->gizi_jenis = (int)$request->gizi_jenis;

            // Handle MST Form
            if ($request->gizi_jenis == 1) {
                $asesmenKepUmumStatusGizi->gizi_mst_penurunan_bb = $request->gizi_mst_penurunan_bb;
                $asesmenKepUmumStatusGizi->gizi_mst_jumlah_penurunan_bb = $request->gizi_mst_jumlah_penurunan_bb;
                $asesmenKepUmumStatusGizi->gizi_mst_nafsu_makan_berkurang = $request->gizi_mst_nafsu_makan_berkurang;
                $asesmenKepUmumStatusGizi->gizi_mst_diagnosis_khusus = $request->gizi_mst_diagnosis_khusus;
                $asesmenKepUmumStatusGizi->gizi_mst_kesimpulan = $request->gizi_mst_kesimpulan;
            }

            // Handle MNA Form
            else if ($request->gizi_jenis == 2) {
                $asesmenKepUmumStatusGizi->gizi_mna_penurunan_asupan_3_bulan = (int)$request->gizi_mna_penurunan_asupan_3_bulan;
                $asesmenKepUmumStatusGizi->gizi_mna_kehilangan_bb_3_bulan = (int)$request->gizi_mna_kehilangan_bb_3_bulan;
                $asesmenKepUmumStatusGizi->gizi_mna_mobilisasi = (int)$request->gizi_mna_mobilisasi;
                $asesmenKepUmumStatusGizi->gizi_mna_stress_penyakit_akut = (int)$request->gizi_mna_stress_penyakit_akut;
                $asesmenKepUmumStatusGizi->gizi_mna_status_neuropsikologi = (int)$request->gizi_mna_status_neuropsikologi;
                $asesmenKepUmumStatusGizi->gizi_mna_berat_badan = (int)$request->gizi_mna_berat_badan;
                $asesmenKepUmumStatusGizi->gizi_mna_tinggi_badan = (int)$request->gizi_mna_tinggi_badan;

                // Hitung dan simpan IMT
                $heightInMeters = $request->gizi_mna_tinggi_badan / 100;
                $imt = $request->gizi_mna_berat_badan / ($heightInMeters * $heightInMeters);
                $asesmenKepUmumStatusGizi->gizi_mna_imt = number_format($imt, 2, '.', '');

                $asesmenKepUmumStatusGizi->gizi_mna_kesimpulan = $request->gizi_mna_kesimpulan;
            }

            // Handle Strong Kids Form
            else if ($request->gizi_jenis == 3) {
                $asesmenKepUmumStatusGizi->gizi_strong_status_kurus = $request->gizi_strong_status_kurus;
                $asesmenKepUmumStatusGizi->gizi_strong_penurunan_bb = $request->gizi_strong_penurunan_bb;
                $asesmenKepUmumStatusGizi->gizi_strong_gangguan_pencernaan = $request->gizi_strong_gangguan_pencernaan;
                $asesmenKepUmumStatusGizi->gizi_strong_penyakit_berisiko = $request->gizi_strong_penyakit_berisiko;
                $asesmenKepUmumStatusGizi->gizi_strong_kesimpulan = $request->gizi_strong_kesimpulan;
            }

            // Handle NRS Form
            else if ($request->gizi_jenis == 4) {
                $asesmenKepUmumStatusGizi->gizi_nrs_jatuh_saat_masuk_rs = $request->gizi_nrs_jatuh_saat_masuk_rs;
                $asesmenKepUmumStatusGizi->gizi_nrs_jatuh_2_bulan_terakhir = $request->gizi_nrs_jatuh_2_bulan_terakhir;
                $asesmenKepUmumStatusGizi->gizi_nrs_status_delirium = $request->gizi_nrs_status_delirium;
                $asesmenKepUmumStatusGizi->gizi_nrs_status_disorientasi = $request->gizi_nrs_status_disorientasi;
                $asesmenKepUmumStatusGizi->gizi_nrs_status_agitasi = $request->gizi_nrs_status_agitasi;
                $asesmenKepUmumStatusGizi->gizi_nrs_menggunakan_kacamata = $request->gizi_nrs_menggunakan_kacamata;
                $asesmenKepUmumStatusGizi->gizi_nrs_keluhan_penglihatan_buram = $request->gizi_nrs_keluhan_penglihatan_buram;
                $asesmenKepUmumStatusGizi->gizi_nrs_degenerasi_makula = $request->gizi_nrs_degenerasi_makula;
                $asesmenKepUmumStatusGizi->gizi_nrs_perubahan_berkemih = $request->gizi_nrs_perubahan_berkemih;
                $asesmenKepUmumStatusGizi->gizi_nrs_transfer_mandiri = $request->gizi_nrs_transfer_mandiri;
                $asesmenKepUmumStatusGizi->gizi_nrs_transfer_bantuan_1_orang = $request->gizi_nrs_transfer_bantuan_1_orang;
                $asesmenKepUmumStatusGizi->gizi_nrs_transfer_bantuan_2_orang = $request->gizi_nrs_transfer_bantuan_2_orang;
                $asesmenKepUmumStatusGizi->gizi_nrs_transfer_bantuan_total = $request->gizi_nrs_transfer_bantuan_total;
                $asesmenKepUmumStatusGizi->gizi_nrs_mobilitas_mandiri = $request->gizi_nrs_mobilitas_mandiri;
                $asesmenKepUmumStatusGizi->gizi_nrs_mobilitas_bantuan_1_orang = $request->gizi_nrs_mobilitas_bantuan_1_orang;
                $asesmenKepUmumStatusGizi->gizi_nrs_mobilitas_kursi_roda = $request->gizi_nrs_mobilitas_kursi_roda;
                $asesmenKepUmumStatusGizi->gizi_nrs_mobilitas_imobilisasi = $request->gizi_nrs_mobilitas_imobilisasi;
                $asesmenKepUmumStatusGizi->gizi_nrs_kesimpulan = $request->gizi_nrs_kesimpulan;
            } else if ($request->gizi_jenis == 5) {
                $asesmenKepUmumStatusGizi->status_gizi_tidakada = 'tidak ada status gizi';
            }

            $asesmenKepUmumStatusGizi->save();



            // Data vital sign untuk disimpan
            $vitalSignStore = [
                'nadi' => $request->circulation_transfusi_jumlah ? (int)$request->circulation_transfusi_jumlah : null,
                'respiration' => $request->breathing_frekuensi_nafas ? (int)$request->breathing_frekuensi_nafas : null,
            ];

            // Simpan vital sign menggunakan service
            $this->asesmenService->store($vitalSignStore, $dataMedis->kd_pasien, $dataMedis->no_transaksi, $dataMedis->kd_kasir);


            // create resume
            $resumeData = [
                'konpas' =>
                [
                    'respiration_rate'   => [
                        'hasil' => $vitalSignStore['respiration'] ?? null
                    ],
                    'nadi'   => [
                        'hasil' => $vitalSignStore['nadi'] ?? null
                    ],
                ]
            ];

            $this->baseService->updateResumeMedis(3, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $resumeData);

            DB::commit();

            return to_route('asesmen.index', [
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $request->urut_masuk
            ])->with(['success' => 'Berhasil menambah asesmen keperawatan umum !']);
        } catch (Exception $e) {
            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }


    public function show($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            // Ambil data asesmen beserta relasinya
            $asesmen = RmeAsesmen::with([
                'user',
                'asesmenKepUmum',
                'asesmenKepUmumBreathing',
                'asesmenKepUmumCirculation',
                'asesmenKepUmumDisability',
                'asesmenKepUmumExposure',
                'asesmenKepUmumSkalaNyeri',
                'asesmenKepUmumRisikoJatuh',
                'asesmenKepUmumSosialEkonomi',
                'asesmenKepUmumGizi'
            ])
                ->where('id', $id)
                ->where('kd_pasien', $kd_pasien)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->firstOrFail();

            // Ambil data medis pasien
            $dataMedis = $this->baseService->getDataMedis($this->kdUnit, $kd_pasien, $tgl_masuk, $urut_masuk);
            if (!$dataMedis) abort(404, 'Data not found');

            // Ambil data master yang diperlukan
            $pekerjaan = Pekerjaan::all();
            $faktorPemberat = RmeFaktorPemberat::all();
            $faktorPeringan = RmeFaktorPeringan::all();
            $kualitasNyeri = RmeKualitasNyeri::all();
            $frekuensiNyeri = RmeFrekuensiNyeri::all();
            $menjalar = RmeMenjalar::all();
            $jenisNyeri = RmeJenisNyeri::all();
            $agama = Agama::all();
            $pendidikan = Pendidikan::all();

            // Siapkan data untuk view
            $data = [
                'asesmen' => $asesmen,
                'pasien' => $dataMedis->pasien ?? null,
                'dataMedis' => $dataMedis ?? null,
                'pekerjaan' => $pekerjaan,
                'faktorPemberat' => $faktorPemberat,
                'faktorPeringan' => $faktorPeringan,
                'kualitasNyeri' => $kualitasNyeri,
                'frekuensiNyeri' => $frekuensiNyeri,
                'menjalar' => $menjalar,
                'jenisNyeri' => $jenisNyeri,
                'agama' => $agama,
                'pendidikan' => $pendidikan,
            ];

            // Return ke view
            return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen-keperawatan.show', $data);
        } catch (ModelNotFoundException $e) {
            return back()->with('error', 'Data asesmen tidak ditemukan.');
        } catch (\Exception $e) {

            return back()->with('error', 'Terjadi kesalahan saat memuat data asesmen.');
        }
    }

    public function edit($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            $asesmen = RmeAsesmen::with([
                'user',
                'asesmenKepUmum',
                'asesmenKepUmumBreathing',
                'asesmenKepUmumCirculation',
                'asesmenKepUmumDisability',
                'asesmenKepUmumExposure',
                'asesmenKepUmumSkalaNyeri',
                'asesmenKepUmumRisikoJatuh',
                'asesmenKepUmumSosialEkonomi',
                'asesmenKepUmumGizi'
            ])
                ->where('id', $id)
                ->where('kd_pasien', $kd_pasien)
                ->where('tgl_masuk', $tgl_masuk)
                ->firstOrFail();


            $dataMedis = $this->baseService->getDataMedis($this->kdUnit, $kd_pasien, $tgl_masuk, $urut_masuk);
            if (!$dataMedis) abort(404, 'Data not found');

            $data = [
                'asesmen'   => $asesmen,
                'dataMedis' => $dataMedis,
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


            return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen-keperawatan.edit', $data);
        } catch (ModelNotFoundException $e) {
            return back()->with('error', 'Data asesmen tidak ditemukan');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat memuat data');
        }
    }

    public function update(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            $dataMedis = $this->baseService->getDataMedis($this->kdUnit, $kd_pasien, $tgl_masuk, $urut_masuk);
            if (!$dataMedis) abort(404, 'Data not found');

            $asesmen = RmeAsesmen::findOrFail($id);
            $asesmen->kd_pasien = $kd_pasien;
            $asesmen->kd_unit = 3;
            $asesmen->tgl_masuk = $tgl_masuk;
            $asesmen->urut_masuk = $request->urut_masuk;
            $asesmen->user_id = Auth::id();
            $asesmen->waktu_asesmen = date('Y-m-d H:i:s');
            $asesmen->kategori = 2;
            $asesmen->sub_kategori = 1;
            $asesmen->save();

            $asesmenKepUmum = RmeAsesmenKepUmum::firstOrNew(['id_asesmen' => $asesmen->id]);
            $asesmenKepUmum->id_asesmen = $asesmen->id;
            $asesmenKepUmum->airway_status = $request->airway_status;
            $asesmenKepUmum->airway_suara_nafas = $request->airway_suara_nafas;
            // Update hanya jika field ada dalam request
            if ($request->has('airway_status')) {
                $asesmenKepUmum->airway_status = $request->airway_status;
            }

            if ($request->has('airway_suara_nafas')) {
                $asesmenKepUmum->airway_suara_nafas = $request->airway_suara_nafas;
            }

            // Untuk diagnosis, hanya update jika checkbox diagnosis dicentang
            if ($request->has('airway_diagnosis')) {
                if ($request->has('airway_diagnosis_type')) {
                    $asesmenKepUmum->airway_diagnosis = $request->airway_diagnosis_type;
                }
            }
            // Handle tindakan
            if ($request->has('airway_tindakan')) {
                try {
                    $tindakanData = $request->airway_tindakan;
                    if (is_string($tindakanData)) {
                        $decoded = json_decode($tindakanData, true);
                        if (json_last_error() === JSON_ERROR_NONE) {
                            $asesmenKepUmum->airway_tindakan = $tindakanData;
                        }
                    } else {
                        $asesmenKepUmum->airway_tindakan = json_encode($tindakanData);
                    }
                } catch (\Exception $e) {
                    $asesmenKepUmum->airway_tindakan = null;
                }
            } else {
                $asesmenKepUmum->airway_tindakan = null;
            }

            $asesmenKepUmum->psikologis_kondisi = $request->psikologis_kondisi;
            $asesmenKepUmum->psikologis_potensi_menyakiti = $request->psikologis_potensi_menyakiti;
            $asesmenKepUmum->psikologis_lainnya = $request->psikologis_lainnya;
            $asesmenKepUmum->spiritual_agama = $request->spiritual_agama;
            $asesmenKepUmum->spiritual_nilai = $request->spiritual_nilai;
            $asesmenKepUmum->status_fungsional = $request->status_fungsional;
            $asesmenKepUmum->kebutuhan_edukasi_gaya_bicara = $request->kebutuhan_edukasi_gaya_bicara;
            $asesmenKepUmum->kebutuhan_edukasi_bahasa_sehari_hari = $request->kebutuhan_edukasi_bahasa_sehari_hari;
            $asesmenKepUmum->kebutuhan_edukasi_perlu_penerjemah = $request->kebutuhan_edukasi_perlu_penerjemah;
            $asesmenKepUmum->kebutuhan_edukasi_hambatan_komunikasi = $request->kebutuhan_edukasi_hambatan_komunikasi;
            $asesmenKepUmum->kebutuhan_edukasi_media_belajar = $request->kebutuhan_edukasi_media_belajar;
            $asesmenKepUmum->kebutuhan_edukasi_tingkat_pendidikan = $request->kebutuhan_edukasi_tingkat_pendidikan;
            $asesmenKepUmum->kebutuhan_edukasi_edukasi_dibutuhkan = $request->kebutuhan_edukasi_edukasi_dibutuhkan;
            $asesmenKepUmum->kebutuhan_edukasi_keterangan_lain = $request->kebutuhan_edukasi_keterangan_lain;
            $asesmenKepUmum->discharge_planning_diagnosis_medis = $request->discharge_planning_diagnosis_medis;
            $asesmenKepUmum->discharge_planning_usia_lanjut = $request->discharge_planning_usia_lanjut;
            $asesmenKepUmum->discharge_planning_hambatan_mobilisasi = $request->discharge_planning_hambatan_mobilisasi;
            $asesmenKepUmum->discharge_planning_pelayanan_medis = $request->discharge_planning_pelayanan_medis;
            $asesmenKepUmum->discharge_planning_ketergantungan_aktivitas = $request->discharge_planning_ketergantungan_aktivitas;
            $asesmenKepUmum->discharge_planning_kesimpulan = $request->discharge_planning_kesimpulan;
            $asesmenKepUmum->evaluasi = $request->evaluasi;
            $asesmenKepUmum->masalah_keperawatan = $request->masalah_keperawatan;
            $asesmenKepUmum->implementasi = $request->implementasi;
            $asesmenKepUmum->implementasi_keperawatan = $request->implementasi_keperawatan;
            $asesmenKepUmum->evaluasi_keperawatan = $request->evaluasi_keperawatan;
            $asesmenKepUmum->save();

            // Update atau create breathing
            $asesmenKepUmumBreathing = RmeAsesmenKepUmumBreathing::firstOrNew(['id_asesmen' => $asesmen->id]);
            $asesmenKepUmumBreathing->breathing_frekuensi_nafas = $request->breathing_frekuensi_nafas;
            $asesmenKepUmumBreathing->breathing_pola_nafas = $request->breathing_pola_nafas;
            $asesmenKepUmumBreathing->breathing_bunyi_nafas = $request->breathing_bunyi_nafas;
            $asesmenKepUmumBreathing->breathing_irama_nafas = (int)$request->breathing_irama_nafas;
            $asesmenKepUmumBreathing->breathing_tanda_distress = $request->breathing_tanda_distress;
            $asesmenKepUmumBreathing->breathing_jalan_nafas = (int)$request->breathing_jalan_nafas;
            $asesmenKepUmumBreathing->breathing_lainnya = $request->breathing_lainnya;
            // Handle breathing_diagnosis_nafas
            if ($request->has('breathing_diagnosis_nafas')) {
                if ($request->has('breathing_diagnosis_type')) {
                    $asesmenKepUmumBreathing->breathing_diagnosis_nafas = $request->breathing_diagnosis_type;
                }
            }

            // Handle breathing_gangguan
            if ($request->has('breathing_gangguan')) {
                if ($request->has('breathing_gangguan_type')) {
                    $asesmenKepUmumBreathing->breathing_gangguan = $request->breathing_gangguan_type;
                }
            }

            if ($request->has('breathing_tindakan')) {
                try {
                    $tindakanDataBreathing = $request->breathing_tindakan;
                    $asesmenKepUmumBreathing->breathing_tindakan = is_string($tindakanDataBreathing)
                        ? $tindakanDataBreathing
                        : json_encode($tindakanDataBreathing, JSON_THROW_ON_ERROR);
                } catch (\JsonException $e) {
                    $asesmenKepUmumBreathing->breathing_tindakan = null;
                }
            } else {
                $asesmenKepUmumBreathing->breathing_tindakan = null;
            }

            $asesmenKepUmumBreathing->save();

            // Update atau create circulation
            $asesmenKepUmumCirculation = RmeAsesmenKepUmumCirculation::firstOrNew(['id_asesmen' => $asesmen->id]);
            $asesmenKepUmumCirculation->circulation_nadi = $request->circulation_nadi;
            $asesmenKepUmumCirculation->circulation_sistole = $request->circulation_sistole;
            $asesmenKepUmumCirculation->circulation_diastole = $request->circulation_diastole;
            $asesmenKepUmumCirculation->circulation_akral = $request->circulation_akral;
            $asesmenKepUmumCirculation->circulation_pucat = $request->circulation_pucat;
            $asesmenKepUmumCirculation->circulation_cianosis = $request->circulation_cianosis;
            $asesmenKepUmumCirculation->circulation_kapiler = $request->circulation_kapiler;
            $asesmenKepUmumCirculation->circulation_kelembapan_kulit = $request->circulation_kelembapan_kulit;
            $asesmenKepUmumCirculation->circulation_turgor = $request->circulation_turgor;
            $asesmenKepUmumCirculation->circulation_transfusi = $request->circulation_transfusi;
            $asesmenKepUmumCirculation->circulation_transfusi_jumlah = $request->circulation_transfusi_jumlah;
            $asesmenKepUmumCirculation->circulation_nadi_irama = $request->circulation_nadi_irama;
            $asesmenKepUmumCirculation->circulation_nadi_kekuatan = $request->circulation_nadi_kekuatan;

            // Handle circulation_diagnosis_perfusi
            if ($request->has('circulation_diagnosis_perfusi')) {
                if ($request->has('circulation_diagnosis_perfusi_type')) {
                    $asesmenKepUmumCirculation->circulation_diagnosis_perfusi = $request->circulation_diagnosis_perfusi_type;
                }
            }

            // Handle circulation_diagnosis_defisit
            if ($request->has('circulation_diagnosis_defisit')) {
                if ($request->has('circulation_diagnosis_defisit_type')) {
                    $asesmenKepUmumCirculation->circulation_diagnosis_defisit = $request->circulation_diagnosis_defisit_type;
                }
            }

            $asesmenKepUmumCirculation->circulation_lain = $request->circulation_lain;

            if ($request->has('circulation_tindakan')) {
                try {
                    $tindakanDataCirculation = $request->circulation_tindakan;
                    $asesmenKepUmumCirculation->circulation_tindakan = is_string($tindakanDataCirculation)
                        ? $tindakanDataCirculation
                        : json_encode($tindakanDataCirculation, JSON_THROW_ON_ERROR);
                } catch (\JsonException $e) {
                    $asesmenKepUmumCirculation->circulation_tindakan = null;
                }
            } else {
                $asesmenKepUmumCirculation->circulation_tindakan = null;
            }
            $asesmenKepUmumCirculation->save();

            // Update atau create disability
            $asesmenKepUmumDisability = RmeAsesmenKepUmumDisability::firstOrNew(['id_asesmen' => $asesmen->id]);
            $asesmenKepUmumDisability->disability_kesadaran = $request->disability_kesadaran;
            $asesmenKepUmumDisability->disability_isokor = $request->disability_isokor;
            $asesmenKepUmumDisability->disability_respon_cahaya = $request->disability_respon_cahaya;
            $asesmenKepUmumDisability->disability_diameter_pupil = $request->disability_diameter_pupil;
            $asesmenKepUmumDisability->disability_motorik = $request->disability_motorik;
            $asesmenKepUmumDisability->disability_sensorik = $request->disability_sensorik;
            $asesmenKepUmumDisability->disability_kekuatan_otot = $request->disability_kekuatan_otot;

            if ($request->has('disability_diagnosis_perfusi')) {
                if ($request->has('disability_diagnosis_perfusi_type')) {
                    $asesmenKepUmumDisability->disability_diagnosis_perfusi = $request->disability_diagnosis_perfusi_type;
                }
            }
            if ($request->has('disability_diagnosis_intoleransi')) {
                if ($request->has('disability_diagnosis_intoleransi_type')) {
                    $asesmenKepUmumDisability->disability_diagnosis_intoleransi = $request->disability_diagnosis_intoleransi_type;
                }
            }
            if ($request->has('disability_diagnosis_komunikasi')) {
                if ($request->has('disability_diagnosis_komunikasi_type')) {
                    $asesmenKepUmumDisability->disability_diagnosis_komunikasi = $request->disability_diagnosis_komunikasi_type;
                }
            }
            if ($request->has('disability_diagnosis_kejang')) {
                if ($request->has('disability_diagnosis_kejang_type')) {
                    $asesmenKepUmumDisability->disability_diagnosis_kejang = $request->disability_diagnosis_kejang_type;
                }
            }
            if ($request->has('disability_diagnosis_kesadaran')) {
                if ($request->has('disability_diagnosis_kesadaran_type')) {
                    $asesmenKepUmumDisability->disability_diagnosis_kesadaran = $request->disability_diagnosis_kesadaran_type;
                }
            }

            $asesmenKepUmumDisability->disability_lainnya = $request->disability_lainnya;
            if ($request->has('disability_tindakan')) {
                try {
                    $tindakanDataDisability = $request->disability_tindakan;
                    $asesmenKepUmumDisability->disability_tindakan = is_string($tindakanDataDisability)
                        ? $tindakanDataDisability
                        : json_encode($tindakanDataDisability, JSON_THROW_ON_ERROR);
                } catch (\JsonException $e) {
                    $asesmenKepUmumDisability->disability_tindakan = null;
                }
            } else {
                $asesmenKepUmumDisability->disability_tindakan = null;
            }
            if ($request->has('vital_sign')) {
                try {
                    $vitalSign = $request->vital_sign;
                    $asesmenKepUmumDisability->vital_sign = is_string($vitalSign)
                        ? $vitalSign
                        : json_encode($vitalSign, JSON_THROW_ON_ERROR);
                } catch (\JsonException $e) {
                    $asesmenKepUmumDisability->vital_sign = null;
                }
            } else {
                $asesmenKepUmumDisability->vital_sign = null;
            }
            $asesmenKepUmumDisability->save();

            // Update atau create exposure
            $asesmenKepUmumExposure = RmeAsesmenKepUmumExposure::firstOrNew(['id_asesmen' => $asesmen->id]);
            $asesmenKepUmumExposure->exposure_deformitas = $request->exposure_deformitas;
            $asesmenKepUmumExposure->exposure_deformitas_daerah = $request->exposure_deformitas_daerah;
            $asesmenKepUmumExposure->exposure_kontusion = $request->exposure_kontusion;
            $asesmenKepUmumExposure->exposure_kontusion_daerah = $request->exposure_kontusion_daerah;
            $asesmenKepUmumExposure->exposure_abrasi = $request->exposure_abrasi;
            $asesmenKepUmumExposure->exposure_abrasi_daerah = $request->exposure_abrasi_daerah;
            $asesmenKepUmumExposure->exposure_penetrasi = $request->exposure_penetrasi;
            $asesmenKepUmumExposure->exposure_penetrasi_daerah = $request->exposure_penetrasi_daerah;
            $asesmenKepUmumExposure->exposure_laserasi = $request->exposure_laserasi;
            $asesmenKepUmumExposure->exposure_laserasi_daerah = $request->exposure_laserasi_daerah;
            $asesmenKepUmumExposure->exposure_edema = $request->exposure_edema;
            $asesmenKepUmumExposure->exposure_edema_daerah = $request->exposure_edema_daerah;
            $asesmenKepUmumExposure->exposure_kedalaman_luka = $request->exposure_kedalaman_luka;
            $asesmenKepUmumExposure->exposure_lainnya = $request->exposure_lainnya;

            if ($request->has('exposure_diagnosis_mobilitasi')) {
                if ($request->has('exposure_diagnosis_mobilitasi_type')) {
                    $asesmenKepUmumExposure->exposure_diagnosis_mobilitasi = $request->exposure_diagnosis_mobilitasi_type;
                }
            }
            if ($request->has('exposure_diagosis_integritas')) {
                if ($request->has('exposure_diagosis_integritas_type')) {
                    $asesmenKepUmumExposure->exposure_diagosis_integritas = $request->exposure_diagosis_integritas_type;
                }
            }

            $asesmenKepUmumExposure->exposure_diagnosis_lainnya = $request->exposure_diagnosis_lainnya;
            if ($request->has('exposure_tindakan')) {
                try {
                    $tindakanDataExposure = $request->exposure_tindakan;
                    $asesmenKepUmumExposure->exposure_tindakan = is_string($tindakanDataExposure)
                        ? $tindakanDataExposure
                        : json_encode($tindakanDataExposure, JSON_THROW_ON_ERROR);
                } catch (\JsonException $e) {
                    $asesmenKepUmumExposure->exposure_tindakan = null;
                }
            } else {
                $asesmenKepUmumExposure->exposure_tindakan = null;
            }
            $asesmenKepUmumExposure->save();

            // Update atau create sosial ekonomi
            $asesmenKepUmumSosialEkonomi = RmeAsesmenKepUmumSosialEkonomi::firstOrNew(['id_asesmen' => $asesmen->id]);
            $asesmenKepUmumSosialEkonomi->sosial_ekonomi_pekerjaan = $request->sosial_ekonomi_pekerjaan;
            $asesmenKepUmumSosialEkonomi->sosial_ekonomi_tingkat_penghasilan = $request->sosial_ekonomi_tingkat_penghasilan;
            $asesmenKepUmumSosialEkonomi->sosial_ekonomi_status_pernikahan = $request->sosial_ekonomi_status_pernikahan;
            $asesmenKepUmumSosialEkonomi->sosial_ekonomi_status_pendidikan = $request->sosial_ekonomi_status_pendidikan;
            $asesmenKepUmumSosialEkonomi->sosial_ekonomi_tempat_tinggal = $request->sosial_ekonomi_tempat_tinggal;
            $asesmenKepUmumSosialEkonomi->sosial_ekonomi_tinggal_dengan_keluarga = $request->sosial_ekonomi_tinggal_dengan_keluarga;
            $asesmenKepUmumSosialEkonomi->sosial_ekonomi_curiga_penganiayaan = $request->sosial_ekonomi_curiga_penganiayaan;
            $asesmenKepUmumExposure->sosial_ekonomi_curiga_kesulitan = $request->sosial_ekonomi_curiga_kesulitan;
            $asesmenKepUmumExposure->sosial_ekonomi_curiga_hubungan_keluarga = $request->sosial_ekonomi_curiga_hubungan_keluarga;
            $asesmenKepUmumExposure->sosial_ekonomi_curiga_suku = $request->sosial_ekonomi_curiga_suku;
            $asesmenKepUmumExposure->sosial_ekonomi_curiga_budaya = $request->sosial_ekonomi_curiga_budaya;
            $asesmenKepUmumSosialEkonomi->sosial_ekonomi_keterangan_lain = $request->sosial_ekonomi_keterangan_lain;
            $asesmenKepUmumSosialEkonomi->save();

            // Update atau create skala nyeri
            $asesmenKepUmumSkalaNyeri = RmeAsesmenKepUmumSkalaNyeri::firstOrNew(['id_asesmen' => $asesmen->id]);
            $asesmenKepUmumSkalaNyeri->skala_nyeri = $request->skala_nyeri;
            $asesmenKepUmumSkalaNyeri->skala_nyeri_lokasi = $request->skala_nyeri_lokasi;
            $asesmenKepUmumSkalaNyeri->skala_nyeri_durasi = $request->skala_nyeri_durasi;
            $asesmenKepUmumSkalaNyeri->skala_nyeri_pemberat_id = $request->skala_nyeri_pemberat_id;
            $asesmenKepUmumSkalaNyeri->skala_nyeri_peringan_id = $request->skala_nyeri_peringan_id;
            $asesmenKepUmumSkalaNyeri->skala_nyeri_kualitas_id = $request->skala_nyeri_kualitas_id;
            $asesmenKepUmumSkalaNyeri->skala_nyeri_frekuensi_id = $request->skala_nyeri_frekuensi_id;
            $asesmenKepUmumSkalaNyeri->skala_nyeri_menjalar_id = $request->skala_nyeri_menjalar_id;
            $asesmenKepUmumSkalaNyeri->skala_nyeri_jenis_id = $request->skala_nyeri_jenis_id;
            $asesmenKepUmumSkalaNyeri->save();

            // Update atau create risiko jatuh
            $asesmenKepUmumRisikoJatuh = RmeAsesmenKepUmumRisikoJatuh::firstOrNew(['id_asesmen' => $asesmen->id]);
            $asesmenKepUmumRisikoJatuh->resiko_jatuh_jenis = (int)$request->resiko_jatuh_jenis;
            if ($request->has('risik_jatuh_tindakan')) {
                try {
                    $tindakanDataJatuhTindakan = $request->risik_jatuh_tindakan;
                    $asesmenKepUmumRisikoJatuh->risik_jatuh_tindakan = is_string($tindakanDataJatuhTindakan)
                        ? $tindakanDataJatuhTindakan
                        : json_encode($tindakanDataExposure, JSON_THROW_ON_ERROR);
                } catch (\JsonException $e) {
                    $asesmenKepUmumRisikoJatuh->risik_jatuh_tindakan = null;
                }
            } else {
                $asesmenKepUmumRisikoJatuh->risik_jatuh_tindakan = null;
            }

            // Handle Skala Umum
            if ($request->resiko_jatuh_jenis == 1) {
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_umum_usia = $request->risiko_jatuh_umum_usia ? 1 : 0;
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_umum_kondisi_khusus = $request->risiko_jatuh_umum_kondisi_khusus ? 1 : 0;
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_umum_diagnosis_parkinson = $request->risiko_jatuh_umum_diagnosis_parkinson ? 1 : 0;
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_umum_pengobatan_berisiko = $request->risiko_jatuh_umum_pengobatan_berisiko ? 1 : 0;
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_umum_lokasi_berisiko = $request->risiko_jatuh_umum_lokasi_berisiko ? 1 : 0;
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_umum_kesimpulan = $request->input('risiko_jatuh_umum_kesimpulan', 'Tidak berisiko jatuh');
            }

            // Handle Skala Morse
            else if ($request->resiko_jatuh_jenis == 2) {
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_riwayat_jatuh = array_search($request->risiko_jatuh_morse_riwayat_jatuh, ['25' => 25, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_diagnosis_sekunder = array_search($request->risiko_jatuh_morse_diagnosis_sekunder, ['15' => 15, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_bantuan_ambulasi = array_search($request->risiko_jatuh_morse_bantuan_ambulasi, ['30' => 30, '15' => 15, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_terpasang_infus = array_search($request->risiko_jatuh_morse_terpasang_infus, ['20' => 20, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_cara_berjalan = array_search($request->risiko_jatuh_morse_cara_berjalan, ['0' => 0, '20' => 20, 10 => 10]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_status_mental = array_search($request->risiko_jatuh_morse_status_mental, ['0' => 0, '15' => 15]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_kesimpulan = $request->risiko_jatuh_morse_kesimpulan;
            }

            // Handle Skala Pediatrik/Humpty
            else if ($request->resiko_jatuh_jenis == 3) {
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_usia_anak = array_search((int)$request->risiko_jatuh_pediatrik_usia_anak, ['4' => 4, '3' => 3, '2' => 2, '1' => 1]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_jenis_kelamin = array_search($request->risiko_jatuh_pediatrik_jenis_kelamin, ['2' => 2, '1' => 1]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_diagnosis = array_search($request->risiko_jatuh_pediatrik_diagnosis, ['4' => 4, '3' => 3, '2' => 2, '1' => 1]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_gangguan_kognitif = array_search($request->risiko_jatuh_pediatrik_gangguan_kognitif, ['3' => 3, '2' => 2, '1' => 1]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_faktor_lingkungan = array_search($request->risiko_jatuh_pediatrik_faktor_lingkungan, ['4' => 4, '3' => 3, '2' => 2, '1' => 1]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_pembedahan = array_search($request->risiko_jatuh_pediatrik_pembedahan, ['3' => 3, '2' => 2, '1' => 1]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_penggunaan_mentosa = array_search($request->risiko_jatuh_pediatrik_penggunaan_mentosa, ['3' => 3, '2' => 2, '1' => 1]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_kesimpulan = $request->risiko_jatuh_pediatrik_kesimpulan;
            }

            // Handle Skala Lansia/Ontario
            else if ($request->resiko_jatuh_jenis == 4) {
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_jatuh_saat_masuk_rs = array_search($request->risiko_jatuh_lansia_jatuh_saat_masuk_rs, ['6' => 6, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_riwayat_jatuh_2_bulan = array_search($request->risiko_jatuh_lansia_riwayat_jatuh_2_bulan, ['6' => 6, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_status_bingung = array_search($request->risiko_jatuh_lansia_status_bingung, ['14' => 14, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_status_disorientasi = array_search($request->risiko_jatuh_lansia_status_disorientasi, ['14' => 14, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_status_agitasi = array_search($request->risiko_jatuh_lansia_status_agitasi, ['14' => 14, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_kacamata = $request->risiko_jatuh_lansia_kacamata;
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_kelainan_penglihatan = $request->risiko_jatuh_lansia_kelainan_penglihatan;
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_glukoma = $request->risiko_jatuh_lansia_glukoma;
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_perubahan_berkemih = array_search($request->risiko_jatuh_lansia_perubahan_berkemih, ['2' => 2, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_transfer_mandiri = $request->risiko_jatuh_lansia_transfer_mandiri;
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_sedikit = $request->risiko_jatuh_lansia_transfer_bantuan_sedikit;
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_nyata = array_search($request->risiko_jatuh_lansia_transfer_bantuan_nyata, ['2' => 2, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_total = array_search($request->risiko_jatuh_lansia_transfer_bantuan_total, ['3' => 2, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_mobilitas_mandiri = $request->risiko_jatuh_lansia_mobilitas_mandiri;
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_mobilitas_bantuan_1_orang = $request->risiko_jatuh_lansia_mobilitas_bantuan_1_orang;
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_mobilitas_kursi_roda = array_search($request->risiko_jatuh_lansia_mobilitas_kursi_roda, ['2' => 2, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_mobilitas_imobilisasi = array_search($request->risiko_jatuh_lansia_mobilitas_imobilisasi, ['3' => 2, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_kesimpulan = $request->risiko_jatuh_lansia_kesimpulan;
            } else if ($request->resiko_jatuh_jenis == 5) {
                $asesmenKepUmumRisikoJatuh->resiko_jatuh_lainnya = 'resiko jatuh lainnya';
            }
            $asesmenKepUmumRisikoJatuh->save();

            // Update atau create status gizi
            $asesmenKepUmumStatusGizi = RmeAsesmenKepUmumGizi::firstOrNew(['id_asesmen' => $asesmen->id]);
            $asesmenKepUmumStatusGizi->gizi_jenis = (int)$request->gizi_jenis;

            // Reset all gizi fields first
            $this->resetGiziFields($asesmenKepUmumStatusGizi);

            // Handle MST Form
            if ($request->gizi_jenis == 1) {
                $asesmenKepUmumStatusGizi->gizi_mst_penurunan_bb = $request->gizi_mst_penurunan_bb;
                $asesmenKepUmumStatusGizi->gizi_mst_jumlah_penurunan_bb = $request->gizi_mst_jumlah_penurunan_bb;
                $asesmenKepUmumStatusGizi->gizi_mst_nafsu_makan_berkurang = $request->gizi_mst_nafsu_makan_berkurang;
                $asesmenKepUmumStatusGizi->gizi_mst_diagnosis_khusus = $request->gizi_mst_diagnosis_khusus;
                $asesmenKepUmumStatusGizi->gizi_mst_kesimpulan = $request->gizi_mst_kesimpulan;
            }

            // Handle MNA Form
            else if ($request->gizi_jenis == 2) {
                $asesmenKepUmumStatusGizi->gizi_mna_penurunan_asupan_3_bulan = (int)$request->gizi_mna_penurunan_asupan_3_bulan;
                $asesmenKepUmumStatusGizi->gizi_mna_kehilangan_bb_3_bulan = (int)$request->gizi_mna_kehilangan_bb_3_bulan;
                $asesmenKepUmumStatusGizi->gizi_mna_mobilisasi = (int)$request->gizi_mna_mobilisasi;
                $asesmenKepUmumStatusGizi->gizi_mna_stress_penyakit_akut = (int)$request->gizi_mna_stress_penyakit_akut;
                $asesmenKepUmumStatusGizi->gizi_mna_status_neuropsikologi = (int)$request->gizi_mna_status_neuropsikologi;
                $asesmenKepUmumStatusGizi->gizi_mna_berat_badan = (float)$request->gizi_mna_berat_badan;
                $asesmenKepUmumStatusGizi->gizi_mna_tinggi_badan = (float)$request->gizi_mna_tinggi_badan;

                // Calculate and save IMT if both weight and height are present
                if ($request->gizi_mna_tinggi_badan && $request->gizi_mna_berat_badan) {
                    $heightInMeters = $request->gizi_mna_tinggi_badan / 100;
                    $imt = $request->gizi_mna_berat_badan / ($heightInMeters * $heightInMeters);
                    $asesmenKepUmumStatusGizi->gizi_mna_imt = number_format($imt, 2, '.', '');
                }

                $asesmenKepUmumStatusGizi->gizi_mna_kesimpulan = $request->gizi_mna_kesimpulan;
            }

            // Handle Strong Kids Form
            else if ($request->gizi_jenis == 3) {
                $asesmenKepUmumStatusGizi->gizi_strong_status_kurus = $request->gizi_strong_status_kurus;
                $asesmenKepUmumStatusGizi->gizi_strong_penurunan_bb = $request->gizi_strong_penurunan_bb;
                $asesmenKepUmumStatusGizi->gizi_strong_gangguan_pencernaan = $request->gizi_strong_gangguan_pencernaan;
                $asesmenKepUmumStatusGizi->gizi_strong_penyakit_berisiko = $request->gizi_strong_penyakit_berisiko;
                $asesmenKepUmumStatusGizi->gizi_strong_kesimpulan = $request->gizi_strong_kesimpulan;
            }

            // Handle tidak dapat dinilai
            else if ($request->gizi_jenis == 5) {
                $asesmenKepUmumStatusGizi->status_gizi_tidakada = 'tidak ada status gizi';
            }

            $asesmenKepUmumStatusGizi->save();



            // Data vital sign untuk disimpan
            $vitalSignStore = [
                'nadi' => $request->circulation_transfusi_jumlah ? (int)$request->circulation_transfusi_jumlah : null,
                'respiration' => $request->breathing_frekuensi_nafas ? (int)$request->breathing_frekuensi_nafas : null,
            ];

            // Simpan vital sign menggunakan service
            $this->asesmenService->store($vitalSignStore, $dataMedis->kd_pasien, $dataMedis->no_transaksi, $dataMedis->kd_kasir);


            // create resume
            $resumeData = [
                'konpas' =>
                [
                    'respiration_rate'   => [
                        'hasil' => $vitalSignStore['respiration'] ?? null
                    ],
                    'nadi'   => [
                        'hasil' => $vitalSignStore['nadi'] ?? null
                    ],
                ]
            ];

            $this->baseService->updateResumeMedis(3, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $resumeData);



            DB::commit();

            return redirect()->route('asesmen.index', [
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $request->urut_masuk
            ])->with(['success' => 'Berhasil mengupdate asesmen keperawatan umum!']);
        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->with('error', 'Terjadi kesalahan saat mengupdate data: ' . $e->getMessage())
                ->withInput();
        }
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


    public function generatePDF($kd_pasien, $tgl_masuk, $id)
    {
        try {
            // Ambil data asesmen dengan eager loading
            $asesmen = RmeAsesmen::with([
                'user',
                'asesmenKepUmum',
                'asesmenKepUmumBreathing',
                'asesmenKepUmumCirculation',
                'asesmenKepUmumDisability',
                'asesmenKepUmumExposure',
                'asesmenKepUmumSkalaNyeri',
                'asesmenKepUmumRisikoJatuh',
                'asesmenKepUmumSosialEkonomi',
                'asesmenKepUmumGizi'
            ])->where('id', $id)->first();

            // Ambil data pasien dan kunjungan
            $dataMedis = Kunjungan::with('pasien')
                ->where('kd_pasien', $kd_pasien)
                ->where('tgl_masuk', $tgl_masuk)
                ->first();

            // Initialize collections with empty arrays if data is null
            $faktorPemberatData = cache()->remember('faktor_pemberat', 3600, function () {
                return RmeFaktorPemberat::select('id', 'name')->pluck('name', 'id');
            });

            $kualitasNyeriData = cache()->remember('kualitas_nyeri', 3600, function () {
                return RmeKualitasNyeri::select('id', 'name')->pluck('name', 'id');
            });

            $menjalarData = cache()->remember('menjalar', 3600, function () {
                return RmeMenjalar::select('id', 'name')->pluck('name', 'id');
            });

            $faktorPeringanData = cache()->remember('faktor_peringan', 3600, function () {
                return RmeFaktorPeringan::select('id', 'name')->pluck('name', 'id');
            });

            $frekuensiNyeriData = cache()->remember('frekuensi_nyeri', 3600, function () {
                return RmeFrekuensiNyeri::select('id', 'name')->pluck('name', 'id');
            });

            $jenisNyeriData = cache()->remember('jenis_nyeri', 3600, function () {
                return RmeJenisNyeri::select('id', 'name')->pluck('name', 'id');
            });

            $pekerjaanData = cache()->remember('pekerjaan', 3600, function () {
                return Pekerjaan::select('kd_pekerjaan', 'pekerjaan')->pluck('pekerjaan', 'kd_pekerjaan');
            });

            $agamaData = cache()->remember('agama', 3600, function () {
                return Agama::select('kd_agama', 'agama')->pluck('agama', 'kd_agama');
            });

            $pendidikanData = cache()->remember('pendidikan', 3600, function () {
                return Pendidikan::select('kd_pendidikan', 'pendidikan')->pluck('pendidikan', 'kd_pendidikan');
            });

            // dd([
            //     'pasien' => optional($dataMedis)->pasien ?? null,
            //     'dataMedis' => $dataMedis ?? null,
            //     'asesmenKepUmum' => optional($asesmen)->asesmenKepUmum ?? null,
            //     'asesmenBreathing' => optional($asesmen)->asesmenKepUmumBreathing ?? null,
            //     'asesmenCirculation' => optional($asesmen)->asesmenKepUmumCirculation ?? null,
            //     'asesmenDisability' => optional($asesmen)->asesmenKepUmumDisability ?? null,
            //     'asesmenExposure' => optional($asesmen)->asesmenKepUmumExposure ?? null,
            //     'asesmenSkalaNyeri' => optional($asesmen)->asesmenKepUmumSkalaNyeri ?? null,
            //     'asesmenRisikoJatuh' => optional($asesmen)->asesmenKepUmumRisikoJatuh ?? null,
            //     'asesmenSosialEkonomi' => optional($asesmen)->asesmenKepUmumSosialEkonomi ?? null,
            //     'asesmenStatusGizi' => optional($asesmen)->asesmenKepUmumGizi ?? null,
            //     'asesmenTanggal' => $asesmenTanggal ?? null,
            //     'tglMasukFormatted' => $tglMasukFormatted ?? null,

            //     // All Item with null checks
            //     'faktorPemberatData' => $faktorPemberatData ?? null,
            //     'kualitasNyeriData' => $kualitasNyeriData ?? null,
            //     'menjalarData' => $menjalarData ?? null,
            //     'faktorPeringanData' => $faktorPeringanData ?? null,
            //     'frekuensiNyeriData' => $frekuensiNyeriData ?? null,
            //     'jenisNyeriData' => $jenisNyeriData ?? null,
            //     'pekerjaanData' => $pekerjaanData ?? null,
            //     'agamaData' => $agamaData ?? null,
            //     'pendidikanData' => $pendidikanData ?? null,

            //     // tambahan sesuai kalimat “(Bila skor ≥ 2 dan/atau pasien dengan diagnosis/kondisi khusus dilaporkan ke dokter pemeriksa)”
            //     'catatanKondisiKhusus' => '(Bila skor ≥ 2 dan/atau pasien dengan diagnosis/kondisi khusus dilaporkan ke dokter pemeriksa)',
            // ]);


            // 4. Optimize date handling
            $asesmenTanggal = $asesmen->created_at ?? now();
            $tglMasukFormatted = $dataMedis->tgl_masuk ?? now();


         
            // Generate PDF with null checks
            $pdf = PDF::loadView('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen-keperawatan.print-pdf', [
                'asesmen' => $asesmen ?? null,
                'pasien' => optional($dataMedis)->pasien ?? null,
                'dataMedis' => $dataMedis ?? null,
                'asesmenKepUmum' => optional($asesmen)->asesmenKepUmum ?? null,
                'asesmenBreathing' => optional($asesmen)->asesmenKepUmumBreathing ?? null,
                'asesmenCirculation' => optional($asesmen)->asesmenKepUmumCirculation ?? null,
                'asesmenDisability' => optional($asesmen)->asesmenKepUmumDisability ?? null,
                'asesmenExposure' => optional($asesmen)->asesmenKepUmumExposure ?? null,
                'asesmenSkalaNyeri' => optional($asesmen)->asesmenKepUmumSkalaNyeri ?? null,
                'asesmenRisikoJatuh' => optional($asesmen)->asesmenKepUmumRisikoJatuh ?? null,
                'asesmenSosialEkonomi' => optional($asesmen)->asesmenKepUmumSosialEkonomi ?? null,
                'asesmenStatusGizi' => optional($asesmen)->asesmenKepUmumGizi ?? null,
                'asesmenTanggal' => $asesmenTanggal,
                'tglMasukFormatted' => $tglMasukFormatted,
                // All Item with null checks
                'faktorPemberatData' => $faktorPemberatData,
                'kualitasNyeriData' => $kualitasNyeriData,
                'menjalarData' => $menjalarData,
                'faktorPeringanData' => $faktorPeringanData,
                'frekuensiNyeriData' => $frekuensiNyeriData,
                'jenisNyeriData' => $jenisNyeriData,
                'pekerjaanData' => $pekerjaanData,
                'agamaData' => $agamaData,
                'pendidikanData' => $pendidikanData,
            ]);

            // Set konfigurasi PDF
            $pdf->setPaper('a4', 'portrait');
            $pdf->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'sans-serif'
            ]);

            return $pdf->stream("asesmen-keperawatan-{$id}-print-pdf.pdf");
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal generate PDF: ' . $e->getMessage()
            ], 500);
        }
    }
}