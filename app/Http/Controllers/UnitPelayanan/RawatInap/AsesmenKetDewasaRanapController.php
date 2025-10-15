<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Agama;
use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\Pekerjaan;
use App\Models\Pendidikan;
use App\Models\RmeAlergiPasien;
use App\Models\RmeAsesmen;
use App\Models\RmeAsesmenKetDewasaRanap;
use App\Models\RmeAsesmenKetDewasaRanapDiagnosisKeperawatan;
use App\Models\RmeAsesmenKetDewasaRanapDietKhusus;
use App\Models\RmeAsesmenKetDewasaRanapDischargePlanning;
use App\Models\RmeAsesmenKetDewasaRanapFisik;
use App\Models\RmeAsesmenKetDewasaRanapPengkajianEdukasi;
use App\Models\RmeAsesmenKetDewasaRanapResikoJatuh;
use App\Models\RmeAsesmenKetDewasaRanapRiwayatPasien;
use App\Models\RmeAsesmenKetDewasaRanapSkalaNyeri;
use App\Models\RmeAsesmenKetDewasaRanapStatusNutrisi;
use App\Models\RmeFaktorPemberat;
use App\Models\RmeFaktorPeringan;
use App\Models\RmeFrekuensiNyeri;
use App\Models\RmeJenisNyeri;
use App\Models\RmeKualitasNyeri;
use App\Models\RmeMasterDiagnosis;
use App\Models\RmeMasterImplementasi;
use App\Models\RmeMenjalar;
use App\Models\RMEResume;
use App\Models\RmeResumeDtl;
use App\Models\SatsetPrognosis;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\AsesmenService;
use App\Services\CheckResumeService;

class AsesmenKetDewasaRanapController extends Controller
{
    protected $asesmenService;
    protected $checkResumeService;
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
        $this->asesmenService = new AsesmenService();
        $this->checkResumeService = new CheckResumeService();
    }

    private function getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien')
                    ->on('kunjungan.kd_unit', '=', 't.kd_unit')
                    ->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi')
                    ->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->leftJoin('dokter', 'kunjungan.KD_DOKTER', '=', 'dokter.KD_DOKTER')
            ->select('kunjungan.*', 't.*', 'dokter.NAMA as nama_dokter')
            ->where('kunjungan.kd_unit', $kd_unit)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();

        if ($dataMedis && $dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } elseif ($dataMedis && $dataMedis->pasien) {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        return $dataMedis;
    }



    private function getMasterData($kd_pasien)
    {
        return [
            'rmeMasterDiagnosis' => RmeMasterDiagnosis::all(),
            'rmeMasterImplementasi' => RmeMasterImplementasi::all(),
            'satsetPrognosis' => SatsetPrognosis::all(),
            'alergiPasien' => RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get(),
            'dokter' => Dokter::where('status', 1)->orderBy('nama_lengkap', 'asc')->get(),
        ];
    }

    private function saveDiagnosisToMaster($diagnosisList)
    {
        foreach ($diagnosisList as $diagnosa) {
            if (!empty($diagnosa)) {
                RmeMasterDiagnosis::firstOrCreate(['nama_diagnosis' => $diagnosa]);
            }
        }
    }
    private function saveImplementasiToMaster($dataList, $column)
    {
        foreach ($dataList as $item) {
            if (!empty($item)) {
                RmeMasterImplementasi::firstOrCreate([$column => $item]);
            }
        }
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

    /**
     * Helper function to process JSON data correctly
     */
    private function processJsonData($jsonString)
    {
        if (empty($jsonString) || $jsonString === '[]') {
            return null;
        }

        $data = json_decode($jsonString, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return null;
        }

        return $data;
    }

    /**
     * Helper function to format JSON for database storage
     */
    private function formatJsonForDatabase($data)
    {
        if (empty($data) || !is_array($data)) {
            return null;
        }

        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * Helper function to process checkbox arrays
     */
    private function processCheckboxArray($data)
    {
        if (empty($data)) {
            return null;
        }

        if (is_array($data)) {
            return json_encode(array_values($data), JSON_UNESCAPED_UNICODE);
        }

        return $data;
    }

    // helper kecil di dalam controller class
    private function ensureArray($value)
    {
        if (is_null($value)) return [];
        if (is_array($value)) return array_values($value);
        // jika string (mis. single value), bungkus jadi array
        return [$value];
    }

    public function create(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
            $dataMedis = $this->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
           
            if (!$dataMedis) {
                abort(404, 'Data tidak ditemukan');
            }

            $masterData = $this->getMasterData($kd_pasien);

            // Get latest vital signs data for the patient
            $vitalSignsData = $this->asesmenService->getLatestVitalSignsByPatient($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

            return view(
                'unit-pelayanan.rawat-inap.pelayanan.asesmen-umum.create',
                array_merge([
                    'kd_unit' => $kd_unit,
                    'kd_pasien' => $kd_pasien,
                    'tgl_masuk' => $tgl_masuk,
                    'urut_masuk' => $urut_masuk,
                    'dataMedis' => $dataMedis,
                    'vitalSigns' => $vitalSignsData,
                ], $masterData)
            );
        }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        DB::beginTransaction();
        try {
            // 1. Buat record RmeAsesmen
            $asesmen = new RmeAsesmen();
            $asesmen->kd_pasien = $request->kd_pasien;
            $asesmen->kd_unit = $request->kd_unit;
            $asesmen->tgl_masuk = $request->tgl_masuk;
            $asesmen->urut_masuk = $request->urut_masuk;
            $asesmen->user_id = Auth::id();
            $asesmen->waktu_asesmen = now();
            $asesmen->kategori = 2;
            $asesmen->sub_kategori = 1;
            $asesmen->save();

            // Data vital sign untuk disimpan
            $vitalSignData = [
                'sistole' => $request->sistole ? (int)$request->sistole : null,
                'diastole' => $request->distole ? (int)$request->distole : null,
                'nadi' => $request->nadi ? (int)$request->nadi : null,
                'respiration' => $request->nafas ? (int)$request->nafas : null,
                'suhu' => $request->suhu ? (float)$request->suhu : null,
                'spo2_tanpa_o2' => $request->sao2 ? (int)$request->sao2 : null,
                'tinggi_badan' => $request->tb ? (int)$request->tb : null,
                'berat_badan' => $request->bb ? (int) $request->bb : null,
            ];


            $lastTransaction = $this->asesmenService->getTransaksiData($kd_unit,$kd_pasien,$tgl_masuk,$urut_masuk);

            // Simpan vital sign menggunakan service
            $this->asesmenService->store($vitalSignData, $kd_pasien, $lastTransaction->no_transaksi,$lastTransaction->kd_kasir);

            // Simpan ke tabel RmeAsesmenKetDewasaRanap
            $asesmenKetDewasaRanap = RmeAsesmenKetDewasaRanap::create([
                'id_asesmen' => $asesmen->id,
                'tanggal' => $request->tanggal ?? date('Y-m-d'),
                'jam' => $request->jam ?? date('H:i:s'),
                'nadi' => $request->nadi,
                'sistole' => $request->sistole,
                'distole' => $request->distole,
                'nafas' => $request->nafas,
                'suhu' => $request->suhu,
                'sao2' => $request->sao2,
                'tb' => $request->tb,
                'bb' => $request->bb,
                'status' => $request->status ?? [],
                'kondisi_masuk' => $request->kondisi_masuk,
                'kondisi_masuk_lainnya' => $request->kondisi_masuk_lainnya,
                'kd_dokter' => $request->kd_dokter,
                'diagnosis_masuk' => $request->diagnosis_masuk,
                'keluhan_utama' => $request->keluhan_utama,
                'barang_berharga' => $request->barang_berharga,
                'barang_berharga_lainnya' => $request->barang_berharga_lainnya,
                'data_umum_alat_bantu' => $request->data_umum_alat_bantu ?? [],
                'user_create' => Auth::id(),
                'tingkat_kesadaran' => $request->disability_kesadaran
            ]);

            // Simpan ke tabel RmeAsesmenKetDewasaRanapRiwayatPasien
            $asesmenKetDewasaRanapRiwayatPasien = RmeAsesmenKetDewasaRanapRiwayatPasien::create([
                'id_asesmen' => $asesmen->id,
                'tanggal' => $request->tanggal ?? date('Y-m-d'),
                'jam' => $request->jam ?? date('H:i:s'),
                'riwayat_pasien' => $request->riwayat_pasien ?? [],
                'riwayat_pasien_lain' => $request->riwayat_pasien_lain,
                'alkohol_obat' => $request->alkohol_obat,
                'alkohol_jenis' => $this->formatJsonForDatabase($request->input('alkohol_jenis')),
                'alkohol_jumlah' => $this->formatJsonForDatabase($request->input('alkohol_jumlah')),
                'merokok' => $request->merokok,
                'merokok_jenis' => $this->formatJsonForDatabase($request->input('merokok_jenis')),
                'merokok_jumlah' => $this->formatJsonForDatabase($request->input('merokok_jumlah')),
                'riwayat_keluarga' => $request->riwayat_keluarga ?? [],
                'diabetes_lainnya' => $request->diabetes_lainnya,
                'psikososial_status_pernikahan' => $request->psikososial_status_pernikahan,
                'psikososial_keluarga' => $request->psikososial_keluarga,
                'psikososial_tempat_tinggal' => $request->psikososial_tempat_tinggal,
                'psikososial_lainnya' => $request->psikososial_lainnya,
                'psikososial_pekerjaan' => $request->psikososial_pekerjaan,
                'psikososial_curiga_penganiayaan' => $request->psikososial_curiga_penganiayaan,
                'psikososial_status_emosional' => $request->psikososial_status_emosional,
                'psikososial_status_emosional_lainnya' => $request->psikososial_status_emosional_lainnya,
                'keluarga_terdekat_nama' => $request->keluarga_terdekat_nama,
                'keluarga_terdekat_hubungan' => $request->keluarga_terdekat_hubungan,
                'keluarga_terdekat_telepon' => $request->keluarga_terdekat_telepon,
                'informasi_didapat_dari' => $request->informasi_didapat_dari,
                'informasi_didapat_dari_lainnya' => $request->informasi_didapat_dari_lainnya,
                'agama' => $request->agama ?? [],
                'pandangan_spiritual' => $request->pandangan_spiritual,
                'pandangan_spiritual_lainnya' => $request->pandangan_spiritual_lainnya,
                'psikososial_aktivitas' => $request->psikososial_aktivitas,
                'psikososial_aktivitas_lain' => $request->psikososial_aktivitas_lain,
                'psikososial_aktivitas_lainnya2' => $request->psikososial_aktivitas_lainnya2,
                'user_create' => Auth::id()
            ]);

            // Simpan ke tabel RmeAsesmenKetDewasaRanapFisik
            $asesmenKetDewasaRanapFisik = RmeAsesmenKetDewasaRanapFisik::create([
                'id_asesmen' => $asesmen->id,
                'tanggal' => $request->tanggal ?? date('Y-m-d'),
                'jam' => $request->jam ?? date('H:i:s'),
                'mata_telinga_hidung_normal' => $request->mata_telinga_hidung_normal,
                'mata_telinga_hidung' => $request->mata_telinga_hidung ?? [],
                'mata_telinga_hidung_catatan' => $request->mata_telinga_hidung_catatan,
                'pemeriksaan_paru_normal' => $request->pemeriksaan_paru_normal,
                'pemeriksaan_paru' => $request->pemeriksaan_paru ?? [],
                'pemeriksaan_paru_catatan' => $request->pemeriksaan_paru_catatan,
                'pemeriksaan_gastrointestinal_normal' => $request->pemeriksaan_gastrointestinal_normal,
                'pemeriksaan_gastrointestinal' => $request->pemeriksaan_gastrointestinal ?? [],
                'pemeriksaan_gastrointestinal_bab_terakhir' => $request->pemeriksaan_gastrointestinal_bab_terakhir,
                'fisik_diet_khusus' => $request->fisik_diet_khusus,
                'pemeriksaan_gastrointestinal_catatan' => $request->pemeriksaan_gastrointestinal_catatan,
                'pemeriksaan_kardiovaskular_normal' => $request->pemeriksaan_kardiovaskular_normal,
                'pemeriksaan_kardiovaskular' => $request->pemeriksaan_kardiovaskular ?? [],
                'pemeriksaan_genitourinaria_ginekologi_normal' => $request->pemeriksaan_genitourinaria_ginekologi_normal,
                'pemeriksaan_genitourinaria_ginekologi' => $request->pemeriksaan_genitourinaria_ginekologi ?? [],
                'pemeriksaan_genitourinaria_ginekologi_catatan' => $request->pemeriksaan_genitourinaria_ginekologi_catatan,
                'pemeriksaan_neurologi_normal' => $request->pemeriksaan_neurologi_normal,
                'pemeriksaan_neurologi' => $request->pemeriksaan_neurologi ?? [],
                'pemeriksaan_neurologi_catatan' => $request->pemeriksaan_neurologi_catatan,
                'kesadaran' => $request->disability_kesadaran ?? [],
                'vital_sign' => $this->formatJsonForDatabase($vitalSignData),
                'pemeriksaan_kardiovaskular_catatan' => $request->pemeriksaan_kardiovaskular_catatan,
                'user_create' => Auth::id()
            ]);

            // Simpan ke tabel RmeAsesmenKetDewasaRanapStatusNutrisi
            $asesmenKetDewasaStatusNutrisi = RmeAsesmenKetDewasaRanapStatusNutrisi::create([
                'id_asesmen' => $asesmen->id,
                'tanggal' => $request->tanggal ?? date('Y-m-d'),
                'jam' => $request->jam ?? date('H:i:s'),
                'bb_turun' => $request->bb_turun,
                'bb_turun_range' => $request->bb_turun_range,
                'nafsu_makan' => $request->nafsu_makan,
                'diagnosa_khusus' => $request->diagnosa_khusus,
                'status_nutrisi_lainnya' => $request->status_nutrisi_lainnya,
                'status_nutrisi_total' => $request->status_nutrisi_total,
                'user_create' => Auth::id()
            ]);

            // Simpan ke tabel RmeAsesmenKetDewasaRanapSkalaNyeri
            $asesmenKetDewasaStatusSkalaNyeri = RmeAsesmenKetDewasaRanapSkalaNyeri::create([
                'id_asesmen' => $asesmen->id,
                'tanggal' => $request->tanggal ?? date('Y-m-d'),
                'jam' => $request->jam ?? date('H:i:s'),
                'skala_nyeri' => $request->skala_nyeri,
                'tipe_skala_nyeri' => $request->tipe_skala_nyeri,
                'lokasi_nyeri' => $request->lokasi_nyeri,
                'jenis_nyeri' => $request->jenis_nyeri ?? [],
                'frekuensi_nyeri' => $request->frekuensi_nyeri ?? [],
                'durasi_nyeri' => $request->durasi_nyeri,
                'nyeri_menjalar' => $request->nyeri_menjalar,
                'durasi_nyeri_lokasi' => $request->durasi_nyeri_lokasi,
                'kualitas_nyeri' => $request->kualitas_nyeri ?? [],
                'faktor_pemberat' => $request->faktor_pemberat ?? [],
                'faktor_peringan' => $request->faktor_peringan ?? [],
                'faktor_peringan_lainnya_text' => $request->faktor_peringan_lainnya_text,
                'efek_nyeri' => $request->efek_nyeri ?? [],
                'efek_nyeri_lainnya_text' => $request->efek_nyeri_lainnya_text,
                'user_create' => Auth::id()
            ]);

            // Simpan ke tabel RmeAsesmenKetDewasaRanapResikoJatuh
            $asesmenKetDewasaResikoJatuh = RmeAsesmenKetDewasaRanapResikoJatuh::create([
                'id_asesmen' => $asesmen->id,
                'tanggal' => $request->tanggal ?? date('Y-m-d'),
                'jam' => $request->jam ?? date('H:i:s'),
                // resiko jatuh umum
                'resiko_jatuh_jenis' => $request->resiko_jatuh_jenis,
                'risiko_jatuh_umum_usia' => $request->risiko_jatuh_umum_usia,
                'risiko_jatuh_umum_kondisi_khusus' => $request->risiko_jatuh_umum_kondisi_khusus,
                'risiko_jatuh_umum_diagnosis_parkinson' => $request->risiko_jatuh_umum_diagnosis_parkinson,
                'risiko_jatuh_umum_pengobatan_berisiko' => $request->risiko_jatuh_umum_pengobatan_berisiko,
                'risiko_jatuh_umum_lokasi_berisiko' => $request->risiko_jatuh_umum_lokasi_berisiko,
                'risiko_jatuh_umum_kesimpulan' => $request->risiko_jatuh_umum_kesimpulan,
                // resiko jatuh morse
                'risiko_jatuh_morse_riwayat_jatuh' => $request->risiko_jatuh_morse_riwayat_jatuh,
                'risiko_jatuh_morse_diagnosis_sekunder' => $request->risiko_jatuh_morse_diagnosis_sekunder,
                'risiko_jatuh_morse_bantuan_ambulasi' => $request->risiko_jatuh_morse_bantuan_ambulasi,
                'risiko_jatuh_morse_terpasang_infus' => $request->risiko_jatuh_morse_terpasang_infus,
                'risiko_jatuh_morse_cara_berjalan' => $request->risiko_jatuh_morse_cara_berjalan,
                'risiko_jatuh_morse_status_mental' => $request->risiko_jatuh_morse_status_mental,
                'risiko_jatuh_morse_kesimpulan' => $request->risiko_jatuh_morse_kesimpulan,
                // resiko jatuh ontario
                'ontario_jatuh_saat_masuk' => $request->ontario_jatuh_saat_masuk,
                'ontario_jatuh_2_bulan' => $request->ontario_jatuh_2_bulan,
                'ontario_delirium' => $request->ontario_delirium,
                'ontario_disorientasi' => $request->ontario_disorientasi,
                'ontario_agitasi' => $request->ontario_agitasi,
                'ontario_kacamata' => $request->ontario_kacamata,
                'ontario_penglihatan_buram' => $request->ontario_penglihatan_buram,
                'ontario_glaukoma' => $request->ontario_glaukoma,
                'ontario_berkemih' => $request->ontario_berkemih,
                'ontario_transfer' => $request->ontario_transfer,
                'ontario_mobilitas' => $request->ontario_mobilitas,
                'risiko_jatuh_lansia_kesimpulan' => $request->risiko_jatuh_lansia_kesimpulan,
                // risiko decubitus
                'resiko_decubitus_jenis' => $request->resiko_decubitus_jenis,
                'norton_kondisi_fisik' => $request->norton_kondisi_fisik,
                'norton_kondisi_mental' => $request->norton_kondisi_mental,
                'norton_aktivitas' => $request->norton_aktivitas,
                'norton_mobilitas' => $request->norton_mobilitas,
                'norton_inkontinensia' => $request->norton_inkontinensia,
                'risiko_norton_kesimpulan' => $request->risiko_norton_kesimpulan,
                // aktivitas harian
                'aktivitas_harian_jenis' => $request->aktivitas_harian_jenis,
                'adl_makan' => $request->adl_makan,
                'adl_berjalan' => $request->adl_berjalan,
                'adl_mandi' => $request->adl_mandi,
                'adl_kesimpulan' => $request->adl_kesimpulan,
                'user_create' => Auth::id()
            ]);

            // Simpan ke tabel RmeAsesmenKetDewasaRanapPengkajianEdukasi
            $asesmenKetDewasaPengkajianEdukasi = RmeAsesmenKetDewasaRanapPengkajianEdukasi::create([
                'id_asesmen' => $asesmen->id,
                'tanggal' => $request->tanggal ?? date('Y-m-d'),
                'jam' => $request->jam ?? date('H:i:s'),
                'bicara' => $request->bicara ?? [],
                'bicara_lainnya' => $request->bicara_lainnya,
                'bahasa_sehari' => $request->bahasa_sehari ?? [],
                'bahasa_sehari_lainnya' => $request->bahasa_sehari_lainnya,
                'penerjemah' => $request->penerjemah ?? [],
                'penerjemah_bahasa' => $request->penerjemah_bahasa,
                'hambatan' => $request->hambatan ?? [],
                'hambatan_lainnya' => $request->hambatan_lainnya,
                'cara_komunikasi' => $request->cara_komunikasi ?? [],
                'cara_komunikasi_lainnya' => $request->cara_komunikasi_lainnya,
                'pendidikan' => $request->pendidikan ?? [],
                'pendidikan_detail' => $request->pendidikan_detail,
                'potensi_pembelajaran' => $request->potensi_pembelajaran ?? [],
                'potensi_pembelajaran_lainnya' => $request->potensi_pembelajaran_lainnya,
                'catatan_khusus' => $request->catatan_khusus,
                'user_create' => Auth::id()
            ]);

            // Simpan ke tabel RmeAsesmenKetDewasaRanapDischargePlanning
            $asesmenKetDewasaDischargePlanning = RmeAsesmenKetDewasaRanapDischargePlanning::create([
                'id_asesmen' => $asesmen->id,
                'tanggal' => $request->tanggal ?? date('Y-m-d'),
                'jam' => $request->jam ?? date('H:i:s'),
                'diagnosis_medis' => $request->diagnosis_medis,
                'usia_lanjut' => $request->usia_lanjut,
                'hambatan_mobilisasi' => $request->hambatan_mobilisasi,
                'penggunaan_media_berkelanjutan' => $request->penggunaan_media_berkelanjutan,
                'ketergantungan_aktivitas' => $request->ketergantungan_aktivitas,
                'rencana_pulang_khusus' => $request->rencana_pulang_khusus,
                'rencana_lama_perawatan' => $request->rencana_lama_perawatan,
                'rencana_tgl_pulang' => $request->rencana_tgl_pulang,
                'kesimpulan_planing' => $request->kesimpulan_planing,
                'user_create' => Auth::id()
            ]);

            // Simpan ke tabel RmeAsesmenKetDewasaRanapDietKhusus
            $asesmenKetDewasaDietKhusus = RmeAsesmenKetDewasaRanapDietKhusus::create([
                'id_asesmen' => $asesmen->id,
                'tanggal' => $request->tanggal ?? date('Y-m-d'),
                'jam' => $request->jam ?? date('H:i:s'),
                'diet_khusus' => $request->diet_khusus,
                'pengaruh_perawatan' => $request->pengaruh_perawatan ?? [],
                'pengaruh_ya_tidak_1' => $request->pengaruh_ya_tidak_1,
                'pengaruh_ya_tidak_2' => $request->pengaruh_ya_tidak_2,
                'pengaruh_ya_tidak_3' => $request->pengaruh_ya_tidak_3,
                'hidup_sendiri' => $request->hidup_sendiri,
                'antisipasi_masalah' => $request->antisipasi_masalah,
                'antisipasi_jelaskan' => $request->antisipasi_jelaskan,
                'bantuan_hal' => $request->bantuan_hal ?? [],
                'bantuan_lainnya' => $request->bantuan_lainnya,
                'peralatan_medis' => $request->peralatan_medis,
                'peralatan_jelaskan' => $request->peralatan_jelaskan,
                'alat_bantu' => $request->alat_bantu,
                'alat_bantu_jelaskan' => $request->alat_bantu_jelaskan,
                'perawatan_khusus' => $request->perawatan_khusus,
                'perawatan_khusus_jelaskan' => $request->perawatan_khusus_jelaskan,
                'nyeri_kronis' => $request->nyeri_kronis,
                'nyeri_kronis_jelaskan' => $request->nyeri_kronis_jelaskan,
                'keterampilan_khusus' => $request->keterampilan_khusus,
                'keterampilan_jelaskan' => $request->keterampilan_jelaskan,
                'dirujuk_komunitas' => $request->dirujuk_komunitas,
                'dirujuk_jelaskan' => $request->dirujuk_jelaskan,
                'catatan_khusus_diet' => $request->catatan_khusus_diet,
                'user_create' => Auth::id()
            ]);

            // Simpan ke tabel RmeAsesmenKetDewasaRanapDiagnosisKeperawatan
            $asesmenKetDewasaDiagnosisKeperawatan = RmeAsesmenKetDewasaRanapDiagnosisKeperawatan::create([
                'id_asesmen' => $asesmen->id,
                'tanggal' => $request->tanggal ?? date('Y-m-d'),
                'jam' => $request->jam ?? date('H:i:s'),
                'diagnosis' => $request->diagnosis ?? [],
                'rencana_bersihan_jalan_nafas' => $request->rencana_bersihan_jalan_nafas ?? [],
                'rencana_penurunan_curah_jantung' => $request->rencana_penurunan_curah_jantung ?? [],
                'rencana_perfusi_perifer' => $request->rencana_perfusi_perifer ?? [],
                'rencana_hipovolemia' => $request->rencana_hipovolemia ?? [],
                'rencana_hipervolemia' => $request->rencana_hipervolemia ?? [],
                'rencana_diare' => $request->rencana_diare ?? [],
                'rencana_retensi_urine' => $request->rencana_retensi_urine ?? [],
                'rencana_nyeri_akut' => $request->rencana_nyeri_akut ?? [],
                'rencana_nyeri_kronis' => $request->rencana_nyeri_kronis ?? [],
                'rencana_hipertermia' => $request->rencana_hipertermia ?? [],
                'rencana_gangguan_mobilitas_fisik' => $request->rencana_gangguan_mobilitas_fisik ?? [],
                'rencana_resiko_infeksi' => $request->rencana_resiko_infeksi ?? [],
                'rencana_konstipasi' => $request->rencana_konstipasi ?? [],
                'rencana_resiko_jatuh' => $request->rencana_resiko_jatuh ?? [],
                'rencana_gangguan_integritas_kulit' => $request->rencana_gangguan_integritas_kulit ?? [],
                'user_create' => Auth::id()
            ]);

            // Process diagnosis data
            $diagnosisBanding = $this->processJsonData($request->diagnosis_banding);
            $diagnosisKerja = $this->processJsonData($request->diagnosis_kerja);

            // Handle diagnosis ke master
            if (!empty($diagnosisBanding) && is_array($diagnosisBanding)) {
                $this->saveDiagnosisToMaster($diagnosisBanding);
            }

            if (!empty($diagnosisKerja) && is_array($diagnosisKerja)) {
                $this->saveDiagnosisToMaster($diagnosisKerja);
            }

            // Handle alergi
            $this->handleAlergiData($request, $kd_pasien);

            // Panggil ResumeService
            $resume = $this->checkResumeService->checkAndCreateResume([
                'kd_pasien' => $kd_pasien,
                'kd_unit' => $kd_unit,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk
            ]);

            DB::commit();

            return redirect()
                ->route('rawat-inap.asesmen.medis.umum.index', [
                    'kd_unit' => $kd_unit,
                    'kd_pasien' => $kd_pasien,
                    'tgl_masuk' => $tgl_masuk,
                    'urut_masuk' => $urut_masuk
                ])
                ->with('success', 'Data Asesmen Awal Keperawatan Rawat Inap Dewasa');
        } catch (\Exception $e) {
            DB::rollback();
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            $asesmen = RmeAsesmen::with(
                [
                    'asesmenKetDewasaRanap',
                    'asesmenKetDewasaRanapRiwayatPasien',
                    'asesmenKetDewasaRanapFisik',
                    'asesmenKetDewasaRanapStatusNutrisi',
                    'asesmenKetDewasaRanapSkalaNyeri',
                    'asesmenKetDewasaRanapResikoJatuh',
                    'asesmenKetDewasaRanapPengkajianEdukasi',
                    'asesmenKetDewasaRanapDischargePlanning',
                    'asesmenKetDewasaRanapDietKhusus',
                    'asesmenKetDewasaRanapDiagnosisKeperawatan'
                ]
            )->findOrFail($id);
        } catch (\Exception $e) {
            $asesmen = RmeAsesmen::findOrFail($id);
        }

        $dataMedis = $this->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

        if (!$dataMedis) {
            abort(404, 'Data tidak ditemukan');
        }

        $masterData = $this->getMasterData($kd_pasien);

        return view(
            'unit-pelayanan.rawat-inap.pelayanan.asesmen-umum.show',
            array_merge([
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
                'dataMedis' => $dataMedis,
                'asesmen' => $asesmen,
            ], $masterData)
        );
    }

    public function edit($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            $asesmen = RmeAsesmen::with(
                [
                    'asesmenKetDewasaRanap',
                    'asesmenKetDewasaRanapRiwayatPasien',
                    'asesmenKetDewasaRanapFisik',
                    'asesmenKetDewasaRanapStatusNutrisi',
                    'asesmenKetDewasaRanapSkalaNyeri',
                    'asesmenKetDewasaRanapResikoJatuh',
                    'asesmenKetDewasaRanapPengkajianEdukasi',
                    'asesmenKetDewasaRanapDischargePlanning',
                    'asesmenKetDewasaRanapDietKhusus',
                    'asesmenKetDewasaRanapDiagnosisKeperawatan'
                ]
            )->findOrFail($id);
        } catch (\Exception $e) {
            $asesmen = RmeAsesmen::findOrFail($id);
        }

        $dataMedis = $this->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

        if (!$dataMedis) {
            abort(404, 'Data tidak ditemukan');
        }

        $masterData = $this->getMasterData($kd_pasien);

        return view(
            'unit-pelayanan.rawat-inap.pelayanan.asesmen-umum.edit',
            array_merge([
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
                'dataMedis' => $dataMedis,
                'asesmen' => $asesmen,
            ], $masterData)
        );
    }

    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {

        DB::beginTransaction();
        try {
            // 1. Buat record RmeAsesmen
            $asesmen = RmeAsesmen::findOrFail($id);
            $asesmen->kd_pasien = $request->kd_pasien;
            $asesmen->kd_unit = $request->kd_unit;
            $asesmen->tgl_masuk = $request->tgl_masuk;
            $asesmen->urut_masuk = $request->urut_masuk;
            $asesmen->user_id = Auth::id();
            $asesmen->waktu_asesmen = now();
            $asesmen->kategori = 2;
            $asesmen->sub_kategori = 1;
            $asesmen->save();

            $asesmen->asesmenKetDewasaRanap()->updateOrCreate(
                ['id_asesmen' => $asesmen->id],
                [
                    'tanggal' => $request->tanggal ?? date('Y-m-d'),
                    'jam' => $request->jam ?? date('H:i:s'),
                    'nadi' => $request->nadi,
                    'sistole' => $request->sistole,
                    'distole' => $request->distole,
                    'nafas' => $request->nafas,
                    'suhu' => $request->suhu,
                    'sao2' => $request->sao2,
                    'tb' => $request->tb,
                    'bb' => $request->bb,
                    'status' => $request->status ?? [],
                    'kondisi_masuk' => $request->kondisi_masuk,
                    'kondisi_masuk_lainnya' => $request->kondisi_masuk_lainnya,
                    'kd_dokter' => $request->kd_dokter,
                    'diagnosis_masuk' => $request->diagnosis_masuk,
                    'keluhan_utama' => $request->keluhan_utama,
                    'barang_berharga' => $request->barang_berharga,
                    'barang_berharga_lainnya' => $request->barang_berharga_lainnya,
                    'data_umum_alat_bantu' => $request->data_umum_alat_bantu ?? [],
                    'user_edit' => Auth::id(),
                ]
            );

            // sebelum memanggil updateOrCreate / create: normalisasi
            $alkoholJenis = $this->ensureArray($request->input('alkohol_jenis'));
            $alkoholJumlah = $this->ensureArray($request->input('alkohol_jumlah'));
            $merokokJenis = $this->ensureArray($request->input('merokok_jenis'));
            $merokokJumlah = $this->ensureArray($request->input('merokok_jumlah'));

            $asesmen->asesmenKetDewasaRanapRiwayatPasien()->updateOrCreate(
                ['id_asesmen' => $asesmen->id],
                [
                    'tanggal' => $request->tanggal ?? date('Y-m-d'),
                    'jam' => $request->jam ?? date('H:i:s'),
                    'riwayat_pasien' => $request->riwayat_pasien ?? [],
                    'riwayat_pasien_lain' => $request->riwayat_pasien_lain,
                    'alkohol_obat' => $request->alkohol_obat,
                    'alkohol_jenis' => $this->formatJsonForDatabase($alkoholJenis),
                    'alkohol_jumlah' => $this->formatJsonForDatabase($alkoholJumlah),
                    'merokok' => $request->merokok,
                    'merokok_jenis' => $this->formatJsonForDatabase($merokokJenis),
                    'merokok_jumlah' => $this->formatJsonForDatabase($merokokJumlah),
                    'riwayat_keluarga' => $request->riwayat_keluarga ?? [],
                    'diabetes_lainnya' => $request->diabetes_lainnya,
                    'psikososial_status_pernikahan' => $request->psikososial_status_pernikahan,
                    'psikososial_keluarga' => $request->psikososial_keluarga,
                    'psikososial_tempat_tinggal' => $request->psikososial_tempat_tinggal,
                    'psikososial_lainnya' => $request->psikososial_lainnya,
                    'psikososial_pekerjaan' => $request->psikososial_pekerjaan,
                    'psikososial_curiga_penganiayaan' => $request->psikososial_curiga_penganiayaan,
                    'psikososial_status_emosional' => $request->psikososial_status_emosional,
                    'psikososial_status_emosional_lainnya' => $request->psikososial_status_emosional_lainnya,
                    'keluarga_terdekat_nama' => $request->keluarga_terdekat_nama,
                    'keluarga_terdekat_hubungan' => $request->keluarga_terdekat_hubungan,
                    'keluarga_terdekat_telepon' => $request->keluarga_terdekat_telepon,
                    'informasi_didapat_dari' => $request->informasi_didapat_dari,
                    'informasi_didapat_dari_lainnya' => $request->informasi_didapat_dari_lainnya,
                    'agama' => $request->agama ?? [],
                    'pandangan_spiritual' => $request->pandangan_spiritual,
                    'pandangan_spiritual_lainnya' => $request->pandangan_spiritual_lainnya,
                    'psikososial_aktivitas' => $request->psikososial_aktivitas,
                    'psikososial_aktivitas_lain' => $request->psikososial_aktivitas_lain,
                    'psikososial_aktivitas_lainnya2' => $request->psikososial_aktivitas_lainnya2,
                    'user_edit' => Auth::id(),
                ]
            );
            $asesmen->asesmenKetDewasaRanapFisik()->updateOrCreate(
                ['id_asesmen' => $asesmen->id],
                [
                    'tanggal' => $request->tanggal ?? date('Y-m-d'),
                    'jam' => $request->jam ?? date('H:i:s'),
                    'mata_telinga_hidung_normal' => $request->mata_telinga_hidung_normal,
                    'mata_telinga_hidung' => $request->mata_telinga_hidung ?? [],
                    'mata_telinga_hidung_catatan' => $request->mata_telinga_hidung_catatan,
                    'pemeriksaan_paru_normal' => $request->pemeriksaan_paru_normal,
                    'pemeriksaan_paru' => $request->pemeriksaan_paru ?? [],
                    'pemeriksaan_paru_catatan' => $request->pemeriksaan_paru_catatan,
                    'pemeriksaan_gastrointestinal_normal' => $request->pemeriksaan_gastrointestinal_normal,
                    'pemeriksaan_gastrointestinal' => $request->pemeriksaan_gastrointestinal ?? [],
                    'pemeriksaan_gastrointestinal_bab_terakhir' => $request->pemeriksaan_gastrointestinal_bab_terakhir,
                    'fisik_diet_khusus' => $request->fisik_diet_khusus,
                    'pemeriksaan_gastrointestinal_catatan' => $request->pemeriksaan_gastrointestinal_catatan,
                    'pemeriksaan_kardiovaskular_normal' => $request->pemeriksaan_kardiovaskular_normal,
                    'pemeriksaan_kardiovaskular' => $request->pemeriksaan_kardiovaskular ?? [],
                    'pemeriksaan_genitourinaria_ginekologi_normal' => $request->pemeriksaan_genitourinaria_ginekologi_normal,
                    'pemeriksaan_genitourinaria_ginekologi' => $request->pemeriksaan_genitourinaria_ginekologi ?? [],
                    'pemeriksaan_genitourinaria_ginekologi_catatan' => $request->pemeriksaan_genitourinaria_ginekologi_catatan,
                    'pemeriksaan_neurologi_normal' => $request->pemeriksaan_neurologi_normal,
                    'pemeriksaan_neurologi' => $request->pemeriksaan_neurologi ?? [],
                    'pemeriksaan_neurologi_catatan' => $request->pemeriksaan_neurologi_catatan,
                    'kesadaran' => $request->disability_kesadaran ?? [],
                    'vital_sign' => $this->formatJsonForDatabase($request->vital_sign),
                    'pemeriksaan_kardiovaskular_catatan' => $request->pemeriksaan_kardiovaskular_catatan,
                    'user_edit' => Auth::id(),
                ]
            );
            $asesmen->asesmenKetDewasaRanapStatusNutrisi()->updateOrCreate(
                ['id_asesmen' => $asesmen->id],
                [
                    'tanggal' => $request->tanggal ?? date('Y-m-d'),
                    'jam' => $request->jam ?? date('H:i:s'),
                    'bb_turun' => $request->bb_turun,
                    'bb_turun_range' => $request->bb_turun_range,
                    'nafsu_makan' => $request->nafsu_makan,
                    'diagnosa_khusus' => $request->diagnosa_khusus,
                    'status_nutrisi_lainnya' => $request->status_nutrisi_lainnya,
                    'status_nutrisi_total' => $request->status_nutrisi_total,
                    'user_edit' => Auth::id(),
                ]
            );
            $asesmen->asesmenKetDewasaRanapSkalaNyeri()->updateOrCreate(
                ['id_asesmen' => $asesmen->id],
                [
                    'tanggal' => $request->tanggal ?? date('Y-m-d'),
                    'jam' => $request->jam ?? date('H:i:s'),
                    'skala_nyeri' => $request->skala_nyeri,
                    'tipe_skala_nyeri' => $request->tipe_skala_nyeri,
                    'lokasi_nyeri' => $request->lokasi_nyeri,
                    'jenis_nyeri' => $request->jenis_nyeri ?? [],
                    'frekuensi_nyeri' => $request->frekuensi_nyeri ?? [],
                    'durasi_nyeri' => $request->durasi_nyeri,
                    'nyeri_menjalar' => $request->nyeri_menjalar,
                    'durasi_nyeri_lokasi' => $request->durasi_nyeri_lokasi,
                    'kualitas_nyeri' => $request->kualitas_nyeri ?? [],
                    'faktor_pemberat' => $request->faktor_pemberat ?? [],
                    'faktor_peringan' => $request->faktor_peringan ?? [],
                    'faktor_peringan_lainnya_text' => $request->faktor_peringan_lainnya_text,
                    'efek_nyeri' => $request->efek_nyeri ?? [],
                    'efek_nyeri_lainnya_text' => $request->efek_nyeri_lainnya_text,
                    'user_edit' => Auth::id(),
                ]
            );
            $asesmen->asesmenKetDewasaRanapResikoJatuh()->updateOrCreate(
                ['id_asesmen' => $asesmen->id],
                [
                    'tanggal' => $request->tanggal ?? date('Y-m-d'),
                    'jam' => $request->jam ?? date('H:i:s'),
                    // resiko jatuh umum
                    'resiko_jatuh_jenis' => $request->resiko_jatuh_jenis,
                    'risiko_jatuh_umum_usia' => $request->risiko_jatuh_umum_usia,
                    'risiko_jatuh_umum_kondisi_khusus' => $request->risiko_jatuh_umum_kondisi_khusus,
                    'risiko_jatuh_umum_diagnosis_parkinson' => $request->risiko_jatuh_umum_diagnosis_parkinson,
                    'risiko_jatuh_umum_pengobatan_berisiko' => $request->risiko_jatuh_umum_pengobatan_berisiko,
                    'risiko_jatuh_umum_lokasi_berisiko' => $request->risiko_jatuh_umum_lokasi_berisiko,
                    'risiko_jatuh_umum_kesimpulan' => $request->risiko_jatuh_umum_kesimpulan,
                    // resiko jatuh morse
                    'risiko_jatuh_morse_riwayat_jatuh' => $request->risiko_jatuh_morse_riwayat_jatuh,
                    'risiko_jatuh_morse_diagnosis_sekunder' => $request->risiko_jatuh_morse_diagnosis_sekunder,
                    'risiko_jatuh_morse_bantuan_ambulasi' => $request->risiko_jatuh_morse_bantuan_ambulasi,
                    'risiko_jatuh_morse_terpasang_infus' => $request->risiko_jatuh_morse_terpasang_infus,
                    'risiko_jatuh_morse_cara_berjalan' => $request->risiko_jatuh_morse_cara_berjalan,
                    'risiko_jatuh_morse_status_mental' => $request->risiko_jatuh_morse_status_mental,
                    'risiko_jatuh_morse_kesimpulan' => $request->risiko_jatuh_morse_kesimpulan,
                    // resiko jatuh ontario
                    'ontario_jatuh_saat_masuk' => $request->ontario_jatuh_saat_masuk,
                    'ontario_jatuh_2_bulan' => $request->ontario_jatuh_2_bulan,
                    'ontario_delirium' => $request->ontario_delirium,
                    'ontario_disorientasi' => $request->ontario_disorientasi,
                    'ontario_agitasi' => $request->ontario_agitasi,
                    'ontario_kacamata' => $request->ontario_kacamata,
                    'ontario_penglihatan_buram' => $request->ontario_penglihatan_buram,
                    'ontario_glaukoma' => $request->ontario_glaukoma,
                    'ontario_berkemih' => $request->ontario_berkemih,
                    'ontario_transfer' => $request->ontario_transfer,
                    'ontario_mobilitas' => $request->ontario_mobilitas,
                    'risiko_jatuh_lansia_kesimpulan' => $request->risiko_jatuh_lansia_kesimpulan,
                    // risiko decubitus
                    'resiko_decubitus_jenis' => $request->resiko_decubitus_jenis,
                    'norton_kondisi_fisik' => $request->norton_kondisi_fisik,
                    'norton_kondisi_mental' => $request->norton_kondisi_mental,
                    'norton_aktivitas' => $request->norton_aktivitas,
                    'norton_mobilitas' => $request->norton_mobilitas,
                    'norton_inkontinensia' => $request->norton_inkontinensia,
                    'risiko_norton_kesimpulan' => $request->risiko_norton_kesimpulan,
                    // aktivitas harian
                    'aktivitas_harian_jenis' => $request->aktivitas_harian_jenis,
                    'adl_makan' => $request->adl_makan,
                    'adl_berjalan' => $request->adl_berjalan,
                    'adl_mandi' => $request->adl_mandi,
                    'adl_kesimpulan' => $request->adl_kesimpulan,
                    'user_edit' => Auth::id(),
                ]
            );
            $asesmen->asesmenKetDewasaRanapPengkajianEdukasi()->updateOrCreate(
                ['id_asesmen' => $asesmen->id],
                [
                    'tanggal' => $request->tanggal ?? date('Y-m-d'),
                    'jam' => $request->jam ?? date('H:i:s'),
                    'bicara' => $request->bicara ?? [],
                    'bicara_lainnya' => $request->bicara_lainnya,
                    'bahasa_sehari' => $request->bahasa_sehari ?? [],
                    'bahasa_sehari_lainnya' => $request->bahasa_sehari_lainnya,
                    'penerjemah' => $request->penerjemah ?? [],
                    'penerjemah_bahasa' => $request->penerjemah_bahasa,
                    'hambatan' => $request->hambatan ?? [],
                    'hambatan_lainnya' => $request->hambatan_lainnya,
                    'cara_komunikasi' => $request->cara_komunikasi ?? [],
                    'cara_komunikasi_lainnya' => $request->cara_komunikasi_lainnya,
                    'pendidikan' => $request->pendidikan ?? [],
                    'pendidikan_detail' => $request->pendidikan_detail,
                    'potensi_pembelajaran' => $request->potensi_pembelajaran ?? [],
                    'potensi_pembelajaran_lainnya' => $request->potensi_pembelajaran_lainnya,
                    'catatan_khusus' => $request->catatan_khusus,
                    'user_edit' => Auth::id(),
                ]
            );
            $asesmen->asesmenKetDewasaRanapDischargePlanning()->updateOrCreate(
                ['id_asesmen' => $asesmen->id],
                [
                    'tanggal' => $request->tanggal ?? date('Y-m-d'),
                    'jam' => $request->jam ?? date('H:i:s'),
                    'diagnosis_medis' => $request->diagnosis_medis,
                    'usia_lanjut' => $request->usia_lanjut,
                    'hambatan_mobilisasi' => $request->hambatan_mobilisasi,
                    'penggunaan_media_berkelanjutan' => $request->penggunaan_media_berkelanjutan,
                    'ketergantungan_aktivitas' => $request->ketergantungan_aktivitas,
                    'rencana_pulang_khusus' => $request->rencana_pulang_khusus,
                    'rencana_lama_perawatan' => $request->rencana_lama_perawatan,
                    'rencana_tgl_pulang' => $request->rencana_tgl_pulang,
                    'kesimpulan_planing' => $request->kesimpulan_planing,
                    'user_edit' => Auth::id(),
                ]
            );
            $asesmen->asesmenKetDewasaRanapDietKhusus()->updateOrCreate(
                ['id_asesmen' => $asesmen->id],
                [
                    'tanggal' => $request->tanggal ?? date('Y-m-d'),
                    'jam' => $request->jam ?? date('H:i:s'),
                    'diet_khusus' => $request->diet_khusus,
                    'pengaruh_perawatan' => $request->pengaruh_perawatan ?? [],
                    'pengaruh_ya_tidak_1' => $request->pengaruh_ya_tidak_1,
                    'pengaruh_ya_tidak_2' => $request->pengaruh_ya_tidak_2,
                    'pengaruh_ya_tidak_3' => $request->pengaruh_ya_tidak_3,
                    'hidup_sendiri' => $request->hidup_sendiri,
                    'antisipasi_masalah' => $request->antisipasi_masalah,
                    'antisipasi_jelaskan' => $request->antisipasi_jelaskan,
                    'bantuan_hal' => $request->bantuan_hal ?? [],
                    'bantuan_lainnya' => $request->bantuan_lainnya,
                    'peralatan_medis' => $request->peralatan_medis,
                    'peralatan_jelaskan' => $request->peralatan_jelaskan,
                    'alat_bantu' => $request->alat_bantu,
                    'alat_bantu_jelaskan' => $request->alat_bantu_jelaskan,
                    'perawatan_khusus' => $request->perawatan_khusus,
                    'perawatan_khusus_jelaskan' => $request->perawatan_khusus_jelaskan,
                    'nyeri_kronis' => $request->nyeri_kronis,
                    'nyeri_kronis_jelaskan' => $request->nyeri_kronis_jelaskan,
                    'keterampilan_khusus' => $request->keterampilan_khusus,
                    'keterampilan_jelaskan' => $request->keterampilan_jelaskan,
                    'dirujuk_komunitas' => $request->dirujuk_komunitas,
                    'dirujuk_jelaskan' => $request->dirujuk_jelaskan,
                    'catatan_khusus_diet' => $request->catatan_khusus_diet,
                    'user_edit' => Auth::id(),
                ]
            );
            $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan()->updateOrCreate(
                ['id_asesmen' => $asesmen->id],
                [
                    'tanggal' => $request->tanggal ?? date('Y-m-d'),
                    'jam' => $request->jam ?? date('H:i:s'),
                    'diagnosis' => $request->diagnosis ?? [],
                    'rencana_bersihan_jalan_nafas' => $request->rencana_bersihan_jalan_nafas ?? [],
                    'rencana_penurunan_curah_jantung' => $request->rencana_penurunan_curah_jantung ?? [],
                    'rencana_perfusi_perifer' => $request->rencana_perfusi_perifer ?? [],
                    'rencana_hipovolemia' => $request->rencana_hipovolemia ?? [],
                    'rencana_hipervolemia' => $request->rencana_hipervolemia ?? [],
                    'rencana_diare' => $request->rencana_diare ?? [],
                    'rencana_retensi_urine' => $request->rencana_retensi_urine ?? [],
                    'rencana_nyeri_akut' => $request->rencana_nyeri_akut ?? [],
                    'rencana_nyeri_kronis' => $request->rencana_nyeri_kronis ?? [],
                    'rencana_hipertermia' => $request->rencana_hipertermia ?? [],
                    'rencana_gangguan_mobilitas_fisik' => $request->rencana_gangguan_mobilitas_fisik ?? [],
                    'rencana_resiko_infeksi' => $request->rencana_resiko_infeksi ?? [],
                    'rencana_konstipasi' => $request->rencana_konstipasi ?? [],
                    'rencana_resiko_jatuh' => $request->rencana_resiko_jatuh ?? [],
                    'rencana_gangguan_integritas_kulit' => $request->rencana_gangguan_integritas_kulit ?? [],
                    'user_edit' => Auth::id(),
                ]
            );

            // Process diagnosis data
            $diagnosisBanding = $this->processJsonData($request->diagnosis_banding);
            $diagnosisKerja = $this->processJsonData($request->diagnosis_kerja);

            // Handle diagnosis ke master
            if (!empty($diagnosisBanding) && is_array($diagnosisBanding)) {
                $this->saveDiagnosisToMaster($diagnosisBanding);
            }

            if (!empty($diagnosisKerja) && is_array($diagnosisKerja)) {
                $this->saveDiagnosisToMaster($diagnosisKerja);
            }

            // Handle alergi
            $this->handleAlergiData($request, $kd_pasien);

            // Panggil ResumeService
            $resume = $this->checkResumeService->checkAndCreateResume([
                'kd_pasien' => $kd_pasien,
                'kd_unit' => $kd_unit,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk
            ]);

            DB::commit();

            return redirect()
                ->route('rawat-inap.asesmen.medis.umum.index', [
                    'kd_unit' => $kd_unit,
                    'kd_pasien' => $kd_pasien,
                    'tgl_masuk' => $tgl_masuk,
                    'urut_masuk' => $urut_masuk
                ])
                ->with('success', 'Data asesmen medis anak berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollback();
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function showKepIGD($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
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
                ->firstOrFail();

            // Ambil data medis pasien
            $dataMedis = Kunjungan::with('pasien')
                ->where('kd_pasien', $kd_pasien)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->first();

            if (!$dataMedis) {
                return back()->with('error', 'Data medis tidak ditemukan untuk pasien ini.');
            }

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
}
