<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Kunjungan;
use App\Models\RmeAlergiPasien;
use App\Models\RmeAsesmen;
use App\Models\RmeMasterDiagnosis;
use App\Models\RmeMasterImplementasi;
use App\Models\SatsetPrognosis;
use App\Models\Transaksi;
use App\Models\RmeAsesmenMedisAnak;
use App\Models\RmeAsesmenMedisAnakDtl;
use App\Models\RmeAsesmenMedisAnakFisik;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Services\AsesmenService;
use App\Services\BaseService;
use Exception;

class AsesmenMedisAnakController extends Controller
{
    protected $asesmenService;
    private $baseService;

    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
        $this->asesmenService = new AsesmenService();
        $this->baseService = new BaseService();
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
            'alergiPasien' => RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get()
        ];
    }

    public function getTransaksiData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $lastTransaction = Transaksi::select('kd_kasir', 'no_transaksi')
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_transaksi', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->first();

        return $lastTransaction;
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

    public function index(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

        if (!$dataMedis) {
            abort(404, 'Data tidak ditemukan');
        }

        $masterData = $this->getMasterData($kd_pasien);
        // Get latest vital signs data for the patient
        $vitalSignsData = $this->asesmenService->getLatestVitalSignsByPatient($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

        return view(
            'unit-pelayanan.rawat-inap.pelayanan.asesmen-medis-anak.create',
            array_merge([
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
                'dataMedis' => $dataMedis,
                'vitalSignsData' => $vitalSignsData,
            ], $masterData)
        );
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        DB::beginTransaction();
        try {
            $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
            if (empty($dataMedis)) throw new Exception('Data kunjungan tidak ditemukan !');

            // Ambil tanggal dan jam dari form
            $formatDate = date('Y-m-d', strtotime($request->tanggal));
            $formatTime = date('H:i:s', strtotime($request->jam_masuk));

            // 1. Buat record RmeAsesmen
            $asesmen = new RmeAsesmen();
            $asesmen->anamnesis = $dataMedis->anamnesis;
            $asesmen->kd_pasien = $dataMedis->kd_pasien;
            $asesmen->kd_unit = $dataMedis->kd_unit;
            $asesmen->tgl_masuk = $dataMedis->tgl_masuk;
            $asesmen->urut_masuk = $dataMedis->urut_masuk;
            $asesmen->user_id = Auth::id();
            $asesmen->waktu_asesmen = "$formatDate $formatTime";
            $asesmen->kategori = 1;
            $asesmen->sub_kategori = 7;
            $asesmen->save();

            // Process JSON data
            $riwayatObat = $this->processJsonData($request->riwayat_penggunaan_obat);
            $riwayatImunisasi = $request->input('riwayat_imunisasi', []);

            // Process vital signs untuk disimpan via service
            $vitalSignData = [
                'sistole' => $request->sistole ? (int)$request->sistole : null,
                'diastole' => $request->diastole ? (int)$request->diastole : null,
                'nadi' => $request->nadi ? (int)$request->nadi : null,
                'respiration' => $request->rr ? (int)$request->rr : null,
                'suhu' => $request->suhu ? (float)$request->suhu : null,
                'spo2_tanpa_o2' => null, // Tidak ada di pediatric, set null
                'spo2_dengan_o2' => null, // Tidak ada di pediatric, set null
                'tinggi_badan' => $request->tinggi_badan ? (int)$request->tinggi_badan : null,
                'berat_badan' => $request->berat_badan ? (int)$request->berat_badan : null,
            ];

            // Simpan vital sign menggunakan service
            $this->asesmenService->store($vitalSignData, $kd_pasien, $dataMedis->no_transaksi, $dataMedis->kd_kasir);

            // Vital signs untuk kolom vital_sign JSON
            $vitalSign = [
                'gcs' => $request->input('vital_sign.gcs'),
                'sistole' => $request->sistole,
                'diastole' => $request->diastole,
                'nadi' => $request->nadi,
                'suhu' => $request->suhu,
                'rr' => $request->rr,
                'berat_badan' => $request->berat_badan,
                'tinggi_badan' => $request->tinggi_badan
            ];

            // 2. Store ke RME_ASESMEN_MEDIS_ANAK (tabel utama)
            $asesmenMedisAnak = RmeAsesmenMedisAnak::create([
                'id_asesmen' => $asesmen->id,
                'kd_kasir' => $dataMedis->kd_kasir,
                'no_transaksi' => $dataMedis->no_transaksi,
                'tanggal' => $request->tanggal ?? date('Y-m-d'),
                'jam' => $request->jam_masuk ?? date('H:i:s'),
                'anamnesis' => $request->anamnesis,
                'keluhan_utama' => $request->keluhan_utama,
                'riwayat_penyakit_terdahulu' => $request->riwayat_penyakit_terdahulu,
                'riwayat_penyakit_keluarga' => $request->riwayat_penyakit_keluarga,
                'riwayat_penyakit_sekarang' => $request->riwayat_penyakit_sekarang,
                'riwayat_penggunaan_obat' => $this->formatJsonForDatabase($riwayatObat),
                'kesadaran' => $request->kesadaran,
                'vital_sign' => $this->formatJsonForDatabase($vitalSign),
                'sistole' => $request->sistole,
                'diastole' => $request->diastole,
                'nadi' => $request->nadi,
                'suhu' => $request->suhu,
                'rr' => $request->rr,
                'berat_badan' => $request->berat_badan,
                'tinggi_badan' => $request->tinggi_badan,
                'user_create' => Auth::id()
            ]);

            // 3. Store ke RME_ASESMEN_MEDIS_ANAK_FISIK
            RmeAsesmenMedisAnakFisik::create([
                'id_asesmen' => $asesmen->id,
                'kepala_bentuk' => $request->kepala_bentuk,
                'kepala_uub' => $request->kepala_uub,
                'kepala_rambut' => $request->kepala_rambut,
                'kepala_lain' => $request->kepala_lain,
                'mata_pucat' => $request->has('mata_pucat') ? 1 : 0,
                'mata_ikterik' => $request->has('mata_ikterik') ? 1 : 0,
                'pupil_isokor' => $request->pupil_isokor,
                'refleks_cahaya' => $request->refleks_cahaya,
                'refleks_kornea' => $request->refleks_kornea,
                'mata_lain' => $request->mata_lain,
                'nafas_cuping' => $request->nafas_cuping === 'ya' ? 1 : 0,
                'hidung_lain' => $request->hidung_lain,
                'telinga_cairan' => $request->telinga_cairan === 'ya' ? 1 : 0,
                'telinga_lain' => $request->telinga_lain,
                'mulut_sianosis' => $request->mulut_sianosis === 'ya' ? 1 : 0,
                'mulut_lidah' => $request->mulut_lidah,
                'mulut_tenggorokan' => $request->mulut_tenggorokan,
                'mulut_lain' => $request->mulut_lain,
                'leher_kelenjar' => $request->leher_kelenjar === 'ya' ? 1 : 0,
                'leher_vena' => $request->leher_vena === 'ya' ? 1 : 0,
                'leher_lain' => $request->leher_lain,
                'thoraks_simetris' => in_array('simetris', (array)$request->thoraks_bentuk) ? 1 : 0,
                'thoraks_asimetris' => in_array('asimetris', (array)$request->thoraks_bentuk) ? 1 : 0,
                'thoraks_retraksi' => $request->thoraks_retraksi,
                'thoraks_hr' => $request->thoraks_hr,
                'thoraks_merintih' => $request->thoraks_merintih,
                'thoraks_bunyi_jantung' => $request->thoraks_bunyi_jantung,
                'thoraks_rr' => $request->thoraks_rr,
                'thoraks_murmur' => $request->thoraks_murmur,
                'thoraks_suara_nafas' => $request->thoraks_suara_nafas,
                'thoraks_suara_tambahan' => $request->thoraks_suara_tambahan,
                'thoraks_bentuk' => is_array($request->thoraks_bentuk) ? $this->formatJsonForDatabase($request->thoraks_bentuk) : null,
                'abdomen_distensi' => $request->abdomen_distensi,
                'abdomen_bising_usus' => $request->abdomen_bising_usus,
                'abdomen_venekasi' => $request->abdomen_venekasi === 'ya' ? 1 : 0,
                'abdomen_hepar' => $request->abdomen_hepar,
                'abdomen_lien' => $request->abdomen_lien,
                'genetalia' => $request->genetalia,
                'anus_keterangan' => $request->anus_keterangan,
                'kapiler' => $request->kapiler,
                'ekstremitas_refleks' => $request->ekstremitas_refleks,
                'kulit' => is_array($request->kulit) ? $this->formatJsonForDatabase($request->kulit) : null,
                'kulit_lainnya' => $request->kulit_lainnya,
                'kuku' => is_array($request->kuku) ? $this->formatJsonForDatabase($request->kuku) : null,
                'kuku_lainnya' => $request->kuku_lainnya,
                'user_create' => Auth::id()
            ]);

            // Process diagnosis data
            $diagnosisBanding = $this->processJsonData($request->diagnosis_banding);
            $diagnosisKerja = $this->processJsonData($request->diagnosis_kerja);

            // 4. Store ke RME_ASESMEN_MEDIS_ANAK_DTL
            RmeAsesmenMedisAnakDtl::create([
                'id_asesmen' => $asesmen->id,
                'lama_kehamilan' => $request->lama_kehamilan,
                'komplikasi' => $request->komplikasi === '1' ? 1 : 0,
                'maternal' => $request->maternal === '1' ? 1 : 0,
                'maternal_keterangan' => $request->maternal_keterangan,
                'persalinan' => $request->has('persalinan') ? 1 : 0,
                'penyulit_persalinan' => $request->has('penyulit_persalinan') ? 1 : 0,
                'lainnya_sebukan' => $request->has('lainnya_sebukan') ? 1 : 0,
                'lainnya_keterangan' => $request->lainnya_keterangan,
                'prematur_aterm' => $request->has('prematur_aterm') ? 1 : 0,
                'kmk_smk_bmk' => $request->has('kmk_smk_bmk') ? 1 : 0,
                'pasca_nicu' => $request->has('pasca_nicu') ? 1 : 0,
                'lahir_umur_kehamilan' => $request->lahir_umur_kehamilan,
                'lk_saat_lahir' => $request->lk_saat_lahir,
                'bb_saat_lahir' => $request->bb_saat_lahir,
                'tb_saat_lahir' => $request->tb_saat_lahir,
                'pernah_dirawat' => $request->pernah_dirawat === '1' ? 1 : 0,
                'tanggal_dirawat' => $request->tanggal_dirawat,
                'jam_dirawat' => $request->jam_dirawat,
                'jaundice_rds_pjb' => $request->jaundice_rds_pjb,
                'asi_sampai_umur' => $request->asi_sampai_umur,
                'pemberian_susu_formula' => $request->pemberian_susu_formula,
                'makanan_tambahan_umur' => $request->makanan_tambahan_umur,
                'tengkurap_bulan' => $request->tengkurap_bulan,
                'merangkak_bulan' => $request->merangkak_bulan,
                'duduk_bulan' => $request->duduk_bulan,
                'berdiri_bulan' => $request->berdiri_bulan,
                'milestone_lainnya' => $request->milestone_lainnya,
                'hasil_laboratorium' => $request->hasil_laboratorium,
                'hasil_radiologi' => $request->hasil_radiologi,
                'hasil_lainnya' => $request->hasil_lainnya,
                'paru_prognosis' => $request->paru_prognosis,
                'diagnosis_banding' => $this->formatJsonForDatabase($diagnosisBanding),
                'diagnosis_kerja' => $this->formatJsonForDatabase($diagnosisKerja),
                'diagnosis_medis' => $request->diagnosis_medis,
                'rencana_pengobatan' => $request->rencana_pengobatan,
                'hambatan_mobilisasi' => $request->hambatan_mobilisasi,
                'penggunaan_media_berkelanjutan' => $request->penggunaan_media_berkelanjutan,
                'ketergantungan_aktivitas' => $request->ketergantungan_aktivitas,
                'rencana_pulang_khusus' => $request->rencana_pulang_khusus,
                'rencana_lama_perawatan' => $request->rencana_lama_perawatan,
                'rencana_tgl_pulang' => $request->rencana_tgl_pulang,
                'kesimpulan_planing' => $request->kesimpulan_planing,
                'riwayat_imunisasi' => $request->input('riwayat_imunisasi') ? json_encode($request->input('riwayat_imunisasi')) : null,
                'user_create' => Auth::id()
            ]);

            // Handle diagnosis ke master
            if (!empty($diagnosisBanding) && is_array($diagnosisBanding)) {
                $this->saveDiagnosisToMaster($diagnosisBanding);
            }

            if (!empty($diagnosisKerja) && is_array($diagnosisKerja)) {
                $this->saveDiagnosisToMaster($diagnosisKerja);
            }

            $allDiagnoses = array_merge(($diagnosisBanding ?? []), ($diagnosisKerja ?? []));

            // Handle alergi
            $this->handleAlergiData($request, $kd_pasien);

            // create resume
            $resumeData = [
                'anamnesis'             => $request->anamnesis,
                'diagnosis'             => $allDiagnoses,

                'konpas'                =>
                [
                    'sistole'   => [
                        'hasil' => $vitalSignData['sistole'] ?? null
                    ],
                    'distole'   => [
                        'hasil' => $vitalSignData['diastole'] ?? null
                    ],
                    'respiration_rate'   => [
                        'hasil' => $vitalSignData['respiration'] ?? null
                    ],
                    'suhu'   => [
                        'hasil' => $vitalSignData['suhu'] ?? null
                    ],
                    'nadi'   => [
                        'hasil' => $vitalSignData['nadi'] ?? null
                    ],
                    'tinggi_badan'   => [
                        'hasil' => $vitalSignData['tinggi_badan'] ?? null
                    ],
                    'berat_badan'   => [
                        'hasil' => $vitalSignData['berat_badan'] ?? null
                    ]
                ]
            ];

            $this->baseService->updateResumeMedis($dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $resumeData);

            DB::commit();

            return redirect()
                ->route('rawat-inap.asesmen.medis.umum.index', [
                    'kd_unit' => $kd_unit,
                    'kd_pasien' => $kd_pasien,
                    'tgl_masuk' => $tgl_masuk,
                    'urut_masuk' => $urut_masuk
                ])
                ->with('success', 'Data asesmen medis anak berhasil disimpan');
        } catch (Exception $e) {
            DB::rollback();
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function show(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            // Load data utama dengan relationships
            $asesmen = RmeAsesmen::with([
                'asesmenMedisAnak',
                'asesmenMedisAnakFisik',
                'asesmenMedisAnakDtl'
            ])->findOrFail($id);
        } catch (Exception $e) {
            $asesmen = RmeAsesmen::findOrFail($id);
        }


        $dataMedis = $this->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

        if (!$dataMedis) {
            abort(404, 'Data tidak ditemukan');
        }

        $masterData = $this->getMasterData($kd_pasien);


        return view(
            'unit-pelayanan.rawat-inap.pelayanan.asesmen-medis-anak.show',
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
            // Load data utama dengan relationships
            $asesmen = RmeAsesmen::with([
                'asesmenMedisAnak',
                'asesmenMedisAnakFisik',
                'asesmenMedisAnakDtl'
            ])->findOrFail($id);
        } catch (Exception $e) {
            $asesmen = RmeAsesmen::findOrFail($id);
        }

        $dataMedis = $this->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

        if (!$dataMedis) {
            abort(404, 'Data tidak ditemukan');
        }

        $masterData = $this->getMasterData($kd_pasien);

        return view(
            'unit-pelayanan.rawat-inap.pelayanan.asesmen-medis-anak.edit',
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

            $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
            if (empty($dataMedis)) throw new Exception('Data kunjungan tidak ditemukan !');

            // Process JSON data dengan format yang benar
            $riwayatObat = $this->processJsonData($request->riwayat_penggunaan_obat);
            $riwayatImunisasi = $request->input('riwayat_imunisasi', []);

            // Process vital signs
            $vitalSign = [
                'gcs' => $request->input('vital_sign.gcs'),
                'sistole' => $request->sistole,
                'diastole' => $request->diastole,
                'nadi' => $request->nadi,
                'suhu' => $request->suhu,
                'rr' => $request->rr,
                'berat_badan' => $request->berat_badan,
                'tinggi_badan' => $request->tinggi_badan
            ];

            // Ambil tanggal dan jam dari form
            $formatDate = date('Y-m-d', strtotime($request->tanggal));
            $formatTime = date('H:i:s', strtotime($request->jam_masuk));

            $asesmen = RmeAsesmen::findOrFail($id);
            $asesmen->kd_pasien = $dataMedis->kd_pasien;
            $asesmen->kd_unit = $dataMedis->kd_unit;
            $asesmen->tgl_masuk = $dataMedis->tgl_masuk;
            $asesmen->urut_masuk = $dataMedis->urut_masuk;
            $asesmen->user_id = Auth::id();
            $asesmen->waktu_asesmen = "$formatDate $formatTime";
            $asesmen->kategori = 1;
            $asesmen->sub_kategori = 7;
            $asesmen->save();

            // Update main table (RME_ASESMEN_MEDIS_ANAK)
            $asesmen->asesmenMedisAnak()->updateOrCreate(
                ['id_asesmen' => $asesmen->id],
                [
                    'tanggal' => $request->tanggal ?? date('Y-m-d'),
                    'jam' => $request->jam_masuk ?? date('H:i:s'),
                    'anamnesis' => $request->anamnesis,
                    'keluhan_utama' => $request->keluhan_utama,
                    'riwayat_penyakit_terdahulu' => $request->riwayat_penyakit_terdahulu,
                    'riwayat_penyakit_keluarga' => $request->riwayat_penyakit_keluarga,
                    'riwayat_penyakit_sekarang' => $request->riwayat_penyakit_sekarang,
                    'riwayat_penggunaan_obat' => $this->formatJsonForDatabase($riwayatObat),
                    'kesadaran' => $request->kesadaran,
                    'vital_sign' => $this->formatJsonForDatabase($vitalSign),
                    'sistole' => $request->sistole,
                    'diastole' => $request->diastole,
                    'nadi' => $request->nadi,
                    'suhu' => $request->suhu,
                    'rr' => $request->rr,
                    'berat_badan' => $request->berat_badan,
                    'tinggi_badan' => $request->tinggi_badan,
                    'user_edit' => Auth::id()
                ]
            );
            $asesmen->asesmenMedisAnakFisik()->updateOrCreate(
                ['id_asesmen' => $asesmen->id],
                [
                    'kepala_bentuk' => $request->kepala_bentuk,
                    'kepala_uub' => $request->kepala_uub,
                    'kepala_rambut' => $request->kepala_rambut,
                    'kepala_lain' => $request->kepala_lain,
                    'mata_pucat' => $request->has('mata_pucat') ? 1 : 0,
                    'mata_ikterik' => $request->has('mata_ikterik') ? 1 : 0,
                    'pupil_isokor' => $request->pupil_isokor,
                    // 'pupil_anisokor' => $request->pupil_anisokor, // FIELD TIDAK ADA - DIHAPUS
                    'refleks_cahaya' => $request->refleks_cahaya,
                    'refleks_kornea' => $request->refleks_kornea,
                    'mata_lain' => $request->mata_lain,
                    'nafas_cuping' => $request->nafas_cuping === 'ya' ? 1 : 0,
                    'hidung_lain' => $request->hidung_lain,
                    'telinga_cairan' => $request->telinga_cairan === 'ya' ? 1 : 0,
                    'telinga_lain' => $request->telinga_lain,
                    'mulut_sianosis' => $request->mulut_sianosis === 'ya' ? 1 : 0,
                    'mulut_lidah' => $request->mulut_lidah,
                    'mulut_tenggorokan' => $request->mulut_tenggorokan,
                    'mulut_lain' => $request->mulut_lain,
                    'leher_kelenjar' => $request->leher_kelenjar === 'ya' ? 1 : 0,
                    'leher_vena' => $request->leher_vena === 'ya' ? 1 : 0, // PERBAIKI LOGIKA
                    'leher_lain' => $request->leher_lain,
                    // PERBAIKI THORAKS BENTUK - gunakan array handling
                    'thoraks_simetris' => in_array('simetris', (array)$request->thoraks_bentuk) ? 1 : 0,
                    'thoraks_asimetris' => in_array('asimetris', (array)$request->thoraks_bentuk) ? 1 : 0,
                    'thoraks_retraksi' => $request->thoraks_retraksi,
                    'thoraks_hr' => $request->thoraks_hr,
                    'thoraks_merintih' => $request->thoraks_merintih,
                    'thoraks_bunyi_jantung' => $request->thoraks_bunyi_jantung,
                    'thoraks_rr' => $request->thoraks_rr,
                    'thoraks_murmur' => $request->thoraks_murmur,
                    'thoraks_suara_nafas' => $request->thoraks_suara_nafas,
                    'thoraks_suara_tambahan' => $request->thoraks_suara_tambahan, // HAPUS DUPLIKASI
                    // 'thoraks_suara_tambahan' => $request->has('thoraks_simetris') ? 1 : 0, // HAPUS LINE INI
                    'thoraks_bentuk' => is_array($request->thoraks_bentuk) ? $this->formatJsonForDatabase($request->thoraks_bentuk) : null,
                    'abdomen_distensi' => $request->abdomen_distensi,
                    'abdomen_bising_usus' => $request->abdomen_bising_usus,
                    'abdomen_venekasi' => $request->abdomen_venekasi === 'ya' ? 1 : 0,
                    'abdomen_hepar' => $request->abdomen_hepar,
                    'abdomen_lien' => $request->abdomen_lien,
                    'genetalia' => $request->genetalia,
                    'anus_keterangan' => $request->anus_keterangan,
                    'kapiler' => $request->kapiler,
                    'ekstremitas_refleks' => $request->ekstremitas_refleks,
                    'kulit' => is_array($request->kulit) ? $this->formatJsonForDatabase($request->kulit) : null,
                    'kulit_lainnya' => $request->kulit_lainnya,
                    'kuku' => is_array($request->kuku) ? $this->formatJsonForDatabase($request->kuku) : null,
                    'kuku_lainnya' => $request->kuku_lainnya,
                    'user_edit' => Auth::id()
                ]
            );

            // Process diagnosis data
            $diagnosisBanding = $this->processJsonData($request->diagnosis_banding);
            $diagnosisKerja = $this->processJsonData($request->diagnosis_kerja);

            // Update or create detail data - DIPERBAIKI
            $asesmen->asesmenMedisAnakDtl()->updateOrCreate(
                ['id_asesmen' => $asesmen->id],
                [
                    // Riwayat Prenatal - PERBAIKI LOGIKA RADIO
                    'lama_kehamilan' => $request->lama_kehamilan,
                    'komplikasi' => $request->komplikasi === '1' ? 1 : 0, // PERBAIKI
                    'maternal' => $request->maternal === '1' ? 1 : 0, // PERBAIKI
                    'maternal_keterangan' => $request->maternal_keterangan,

                    // Riwayat Natal
                    'persalinan' => $request->has('persalinan') ? 1 : 0,
                    'penyulit_persalinan' => $request->has('penyulit_persalinan') ? 1 : 0,
                    'lainnya_sebukan' => $request->has('lainnya_sebukan') ? 1 : 0,
                    'lainnya_keterangan' => $request->lainnya_keterangan,

                    // Riwayat Post Natal
                    'prematur_aterm' => $request->has('prematur_aterm') ? 1 : 0,
                    'kmk_smk_bmk' => $request->has('kmk_smk_bmk') ? 1 : 0,
                    'pasca_nicu' => $request->has('pasca_nicu') ? 1 : 0,

                    // Data Kelahiran
                    'lahir_umur_kehamilan' => $request->lahir_umur_kehamilan,
                    'lk_saat_lahir' => $request->lk_saat_lahir,
                    'bb_saat_lahir' => $request->bb_saat_lahir,
                    'tb_saat_lahir' => $request->tb_saat_lahir,

                    // Riwayat Perawatan - PERBAIKI LOGIKA
                    'pernah_dirawat' => $request->pernah_dirawat === '1' ? 1 : 0, // PERBAIKI
                    'tanggal_dirawat' => $request->tanggal_dirawat,
                    'jam_dirawat' => $request->jam_dirawat,
                    'jaundice_rds_pjb' => $request->jaundice_rds_pjb,

                    // Riwayat Nutrisi
                    'asi_sampai_umur' => $request->asi_sampai_umur,
                    'pemberian_susu_formula' => $request->pemberian_susu_formula,
                    'makanan_tambahan_umur' => $request->makanan_tambahan_umur,

                    // Milestone Perkembangan
                    'tengkurap_bulan' => $request->tengkurap_bulan,
                    'merangkak_bulan' => $request->merangkak_bulan,
                    'duduk_bulan' => $request->duduk_bulan,
                    'berdiri_bulan' => $request->berdiri_bulan,
                    'milestone_lainnya' => $request->milestone_lainnya,

                    // Hasil Pemeriksaan Penunjang
                    'hasil_laboratorium' => $request->hasil_laboratorium,
                    'hasil_radiologi' => $request->hasil_radiologi,
                    'hasil_lainnya' => $request->hasil_lainnya,

                    // Diagnosis & Prognosis
                    'paru_prognosis' => $request->paru_prognosis,
                    'diagnosis_banding' => $this->formatJsonForDatabase($diagnosisBanding),
                    'diagnosis_kerja' => $this->formatJsonForDatabase($diagnosisKerja),
                    'diagnosis_medis' => $request->diagnosis_medis,
                    'rencana_pengobatan' => $request->rencana_pengobatan, // TAMBAHKAN FIELD YANG HILANG

                    // Discharge Planning
                    'hambatan_mobilisasi' => $request->hambatan_mobilisasi,
                    'penggunaan_media_berkelanjutan' => $request->penggunaan_media_berkelanjutan,
                    'ketergantungan_aktivitas' => $request->ketergantungan_aktivitas,
                    'rencana_pulang_khusus' => $request->rencana_pulang_khusus,
                    'rencana_lama_perawatan' => $request->rencana_lama_perawatan,
                    'rencana_tgl_pulang' => $request->rencana_tgl_pulang,
                    'kesimpulan_planing' => $request->kesimpulan_planing,

                    'riwayat_imunisasi' => $request->input('riwayat_imunisasi') ? json_encode($request->input('riwayat_imunisasi')) : null,
                    'user_edit' => Auth::id()
                ]
            );

            // Handle diagnosis ke master
            if (!empty($diagnosisBanding) && is_array($diagnosisBanding)) {
                $this->saveDiagnosisToMaster($diagnosisBanding);
            }

            if (!empty($diagnosisKerja) && is_array($diagnosisKerja)) {
                $this->saveDiagnosisToMaster($diagnosisKerja);
            }

            // Handle alergi
            $this->handleAlergiData($request, $kd_pasien);

            $allDiagnoses = array_merge(($diagnosisBanding ?? []), ($diagnosisKerja ?? []));

            // Process vital signs untuk disimpan via service
            $vitalSignData = [
                'sistole' => $request->sistole ? (int)$request->sistole : null,
                'diastole' => $request->diastole ? (int)$request->diastole : null,
                'nadi' => $request->nadi ? (int)$request->nadi : null,
                'respiration' => $request->rr ? (int)$request->rr : null,
                'suhu' => $request->suhu ? (float)$request->suhu : null,
                'spo2_tanpa_o2' => null, // Tidak ada di pediatric, set null
                'spo2_dengan_o2' => null, // Tidak ada di pediatric, set null
                'tinggi_badan' => $request->tinggi_badan ? (int)$request->tinggi_badan : null,
                'berat_badan' => $request->berat_badan ? (int)$request->berat_badan : null,
            ];

            // Simpan vital sign menggunakan service
            $this->asesmenService->store($vitalSignData, $kd_pasien, $dataMedis->no_transaksi, $dataMedis->kd_kasir);

            // create resume
            $resumeData = [
                'anamnesis'             => $request->anamnesis,
                'diagnosis'             => $allDiagnoses,

                'konpas'                =>
                [
                    'sistole'   => [
                        'hasil' => $vitalSignData['sistole'] ?? null
                    ],
                    'distole'   => [
                        'hasil' => $vitalSignData['diastole'] ?? null
                    ],
                    'respiration_rate'   => [
                        'hasil' => $vitalSignData['respiration'] ?? null
                    ],
                    'suhu'   => [
                        'hasil' => $vitalSignData['suhu'] ?? null
                    ],
                    'nadi'   => [
                        'hasil' => $vitalSignData['nadi'] ?? null
                    ],
                    'tinggi_badan'   => [
                        'hasil' => $vitalSignData['tinggi_badan'] ?? null
                    ],
                    'berat_badan'   => [
                        'hasil' => $vitalSignData['berat_badan'] ?? null
                    ]
                ]
            ];

            $this->baseService->updateResumeMedis($dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $resumeData);

            DB::commit();

            return redirect()
                ->route('rawat-inap.asesmen.medis.umum.index', [
                    'kd_unit' => $kd_unit,
                    'kd_pasien' => $kd_pasien,
                    'tgl_masuk' => $tgl_masuk,
                    'urut_masuk' => $urut_masuk
                ])
                ->with('success', 'Data asesmen medis anak berhasil diperbarui');
        } catch (Exception $e) {
            DB::rollback();
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        try {
            DB::beginTransaction();

            $transaksiData = $this->getTransaksiData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

            if (!$transaksiData) {
                throw new Exception('Data transaksi tidak ditemukan');
            }

            // Find existing asesmen
            $asesmenMedisAnak = RmeAsesmenMedisAnak::where('no_transaksi', $transaksiData->no_transaksi)->first();

            if (!$asesmenMedisAnak) {
                throw new Exception('Data asesmen tidak ditemukan');
            }

            // Delete related data first
            $asesmenMedisAnak->asesmenMedisAnakFisik()->delete();
            $asesmenMedisAnak->asesmenMedisAnakDtl()->delete();

            // Delete main data
            $asesmenMedisAnak->delete();

            // Delete asesmen record if exists
            if ($asesmenMedisAnak->asesmen) {
                $asesmenMedisAnak->asesmen->delete();
            }

            // Delete alergi data
            RmeAlergiPasien::where('kd_pasien', $kd_pasien)->delete();

            DB::commit();

            return redirect()
                ->route('rawat-inap.asesmen.medis.umum.index', [
                    'kd_unit' => $kd_unit,
                    'kd_pasien' => $kd_pasien,
                    'tgl_masuk' => $tgl_masuk,
                    'urut_masuk' => $urut_masuk
                ])
                ->with('success', 'Data asesmen medis anak berhasil dihapus');
        } catch (Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
