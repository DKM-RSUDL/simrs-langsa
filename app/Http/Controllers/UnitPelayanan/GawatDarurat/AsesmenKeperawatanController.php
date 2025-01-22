<?php

namespace App\Http\Controllers\UnitPelayanan\GawatDarurat;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\Pekerjaan;
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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AsesmenKeperawatanController extends Controller
{
    public function index($kd_pasien, $tgl_masuk)
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
            ->leftJoin('dokter', 'kunjungan.KD_DOKTER', '=', 'dokter.KD_DOKTER')
            ->select('kunjungan.*', 't.*', 'dokter.NAMA as nama_dokter')
            ->where('kunjungan.kd_unit', 3)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();

        $pekerjaan = Pekerjaan::all();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

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

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen-keperawatan.create', compact(
            'kd_pasien',
            'tgl_masuk',
            'dataMedis',
            'user',
            'pekerjaan'
        ));
    }

    public function store(Request $request, $kd_pasien, $tgl_masuk)
    {
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
        $asesmenKepUmum->airway_tindakan = json_encode($request->airway_tindakan_keperawatan);
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
        $asesmenKepUmumBreathing->breathing_tindakan = json_encode($request->breathing_tindakan_keperawatan);

        $nafasValue = 1;
        $diagnosisNafas = $request->input('breathing_diagnosis_nafas', []);
        if (is_array($diagnosisNafas) && !empty($diagnosisNafas)) {
            $nafasValue = max(array_values($diagnosisNafas));
        }
        $asesmenKepUmumBreathing->breathing_diagnosis_nafas = (int)$nafasValue;

        $gangguanValue = 1;
        $breathing_gangguan = $request->input('breathing_gangguan', []);
        if (is_array($breathing_gangguan) && !empty($breathing_gangguan)) {
            $gangguanValue = max(array_values($breathing_gangguan));
        }
        $asesmenKepUmumBreathing->breathing_gangguan = (int)$gangguanValue;
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
        $asesmenKepUmumCirculation->circulation_tindakan = !empty($request->circulation_tindakan_keperawatan) ? json_encode($request->circulation_tindakan_keperawatan) : null;
        $asesmenKepUmumCirculation->save();

        $asesmenKepUmumDisability = new RmeAsesmenKepUmumDisability();
        $asesmenKepUmumDisability->id_asesmen = $asesmen->id;
        $asesmenKepUmumDisability->disability_kesadaran = $request->disability_kesadaran;
        $asesmenKepUmumDisability->disability_isokor = $request->disability_isokor;
        $asesmenKepUmumDisability->disability_respon_cahaya = $request->disability_respon_cahaya;
        $asesmenKepUmumDisability->disability_diameter_pupil = $request->disability_diameter_pupil;
        $asesmenKepUmumDisability->disability_motorik = $request->disability_motorik;
        $asesmenKepUmumDisability->disability_sensorik = $request->disability_sensorik;

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
                ? ($kesadaranType === '1' ? 1 : ($kesadaranType === '2' ? 2 : 0))
                : 0;
        }

        // Konversi tindakan ke JSON
        $asesmenKepUmumDisability->disability_lainnya = $request->disability_lainnya;
        $asesmenKepUmumDisability->disability_tindakan = json_encode($request->disability_tindakan_keperawatan);
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
            $mobilitasiSelected = $request->exposure_diagnosis_mobilitasi;
            $mobilitasiType = $request->exposure_diagnosis_mobilitasi_type ?? null;

            $asesmenKepUmumExposure->exposure_diagnosis_mobilitasi = in_array('mobilitasi', $mobilitasiSelected)
                ? ($mobilitasiType === '1' ? 1 : ($mobilitasiType === '2' ? 2 : 0))
                : 0;
        }
        if ($request->has('exposure_diagosis_integritas')) {
            $jaringanSelected = $request->exposure_diagnosis_mobilitasi;
            $jaringanType = $request->exposure_diagosis_integritas_type ?? null;

            $asesmenKepUmumExposure->exposure_diagnosis_mobilitasi = in_array('jaringan', $jaringanSelected)
                ? ($jaringanType === '1' ? 1 : ($jaringanType === '2' ? 2 : 0))
                : 0;
        }
        // Diagnosis Lainnya dan Tindakan
        $asesmenKepUmumExposure->exposure_diagnosis_lainnya = $request->exposure_diagnosis_lainnya;
        $asesmenKepUmumExposure->exposure_tindakan = json_encode($request->exposure_tindakan);
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
        $asesmenKepUmumExposure->sosial_ekonomi_keterangan_lain = $request->sosial_ekonomi_keterangan_lain;
        $asesmenKepUmumExposure->save();

        return redirect()->route('asesmen-keperawatan.index', [
            'kd_pasien' => $kd_pasien,
            'tgl_masuk' => $tgl_masuk
        ])->with(['success' => 'created successfully']);
    }
}
