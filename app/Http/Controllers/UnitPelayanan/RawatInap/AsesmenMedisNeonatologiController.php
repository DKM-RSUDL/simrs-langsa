<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Kunjungan;
use App\Models\RmeAlergiPasien;
use App\Models\RmeAsesmen;
use App\Models\RmeAsesmenMedisNeonatologi;
use App\Models\RmeAsesmenMedisNeonatologiDtl;
use App\Models\RmeAsesmenMedisNeonatologiFisikGeneralis;
use App\Models\RmeMasterDiagnosis;
use App\Models\RmeMasterImplementasi;
use App\Models\SatsetPrognosis;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AsesmenMedisNeonatologiController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
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

    private function getTransaksiData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        return Transaksi::select('kd_kasir', 'no_transaksi')
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_transaksi', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->first();
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

        return view(
            'unit-pelayanan.rawat-inap.pelayanan.asesmen-medis-neonatologi.create',
            array_merge([
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
                'dataMedis' => $dataMedis,
            ], $masterData)
        );
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $request->validate([
            'kd_pasien' => 'required',
            'kd_unit' => 'required',
            'tgl_masuk' => 'required|date',
            'urut_masuk' => 'required',
            'tanggal' => 'required|date',
            'jam' => 'required',
        ]);

        DB::beginTransaction();
        try {

            // Get transaksi data
            $transaksiData = $this->getTransaksiData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

            if (!$transaksiData) {
                throw new \Exception('Data transaksi tidak ditemukan');
            }

            // 1. Buat record RmeAsesmen
            $asesmen = new RmeAsesmen();
            $asesmen->kd_pasien = $request->kd_pasien;
            $asesmen->kd_unit = $request->kd_unit;
            $asesmen->tgl_masuk = $request->tgl_masuk;
            $asesmen->urut_masuk = $request->urut_masuk;
            $asesmen->user_id = Auth::id();
            $asesmen->waktu_asesmen = now();
            $asesmen->kategori = 1;
            $asesmen->sub_kategori = 14;
            $asesmen->save();

            // 2. Store ke RmeAsesmenMedisNeonatologi
            $asesmenMedisNeonatologi = RmeAsesmenMedisNeonatologi::create([
                'id_asesmen' => $asesmen->id,
                'kd_kasir' => $transaksiData->kd_kasir,
                'no_transaksi' => $transaksiData->no_transaksi,
                'tanggal' => $request->tanggal ?? date('Y-m-d'),
                'jam' => $request->jam ?? date('H:i:s'),
                'no_hp' => $request->no_hp,
                'transportasi' => $this->formatJsonForDatabase($request->transportasi)  ,
                'kendaraan_lainnya_detail' => $request->kendaraan_lainnya_detail,
                'anamnesis' => $request->anamnesis,
                'lahir' => $request->lahir,
                'lahir_rs_lain' => $request->lahir_rs_lain,
                'keluahan_bayi' => $request->keluahan_bayi,
                'anak_ke' => $request->anak_ke,
                'anc' => $request->anc,
                'usg_kali' => $request->usg_kali,
                'hpht_tanggal' => $request->hpht_tanggal,
                'taksiran_tanggal' => $request->taksiran_tanggal,
                'nyeri_bak' => $request->nyeri_bak,
                'keputihan' => $request->keputihan,
                'perdarahan' => $request->perdarahan,
                'ketuban_pecah' => $request->ketuban_pecah,
                'ketuban_jam' => $request->ketuban_jam,
                'gawat_janin' => $request->gawat_janin,
                'demam' => $request->demam,
                'demam_suhu' => $request->demam_suhu,
                'terapi_deksametason' => $request->terapi_deksametason,
                'deksametason_kali' => $request->deksametason_kali,
                'terapi_lain' => $request->terapi_lain,
                'riwayat_penyakit_ibu' => $this->formatJsonForDatabase($request->riwayat_penyakit_ibu),
                'riwayat_penyakit_ibu_lain' => $request->riwayat_penyakit_ibu_lain,
                'user_create' => Auth::id()
            ]);

            // 3. Create fisik generalis record
            RmeAsesmenMedisNeonatologiFisikGeneralis::create([
                'id_asesmen' => $asesmen->id,
                'postur_tubuh' => $request->postur_tubuh,
                'tangis' => $request->tangis,
                'anemia' => $request->anemia,
                'dispnoe' => $request->dispnoe,
                'edema' => $request->edema,
                'ikterik' => $request->ikterik,
                'sianosis' => $request->sianosis,
                'denyut_jantung' => $request->denyut_jantung,
                'nadi' => $request->nadi,
                'respirasi' => $request->respirasi,
                'spo' => $request->spo,
                'merintih' => $request->merintih,
                'temperatur' => $request->temperatur,
                'bbl_pbl' => $request->bbl_pbl,
                'lk_ld' => $request->lk_ld,
                'bb_sekarang' => $request->bb_sekarang,
                'pb_sekarang' => $request->pb_sekarang,
                'lk_sekarang' => $request->lk_sekarang,
                'bollard_score' => $request->bollard_score,
                'skor_nyeri' => $request->skor_nyeri,
                'down_score' => $request->down_score,
                'kepala_bentuk' => $request->kepala_bentuk,
                'kepala_uub' => $request->kepala_uub,
                'kepala_uuk' => $request->kepala_uuk,
                'caput_sucedaneum' => $request->caput_sucedaneum,
                'cephalohematom' => $request->cephalohematom,
                'kepala_lp' => $request->kepala_lp,
                'kepala_lain' => $request->kepala_lain,
                'mata_pucat' => $request->mata_pucat,
                'mata_ikterik' => $request->mata_ikterik,
                'pupil' => $request->pupil,
                'refleks_cahaya' => $request->refleks_cahaya,
                'refleks_kornea' => $request->refleks_kornea,
                'nafas_cuping' => $request->nafas_cuping,
                'hidung_lain' => $request->hidung_lain,
                'telinga_keterangan' => $request->telinga_keterangan,
                'mulut_sianosis' => $request->mulut_sianosis,
                'mulut_lidah' => $request->mulut_lidah,
                'mulut_tenggorokan' => $request->mulut_tenggorokan,
                'mulut_lain' => $request->mulut_lain,
                'leher_kgb' => $request->leher_kgb,
                'leher_tvj' => $request->leher_tvj,
                'thoraks_bentuk' => $this->formatJsonForDatabase($request->thoraks_bentuk),
                'thoraks_areola_mamae' => $request->thoraks_areola_mamae,
                'thoraks_hr' => $request->thoraks_hr,
                'thoraks_murmur' => $request->thoraks_murmur,
                'thoraks_bunyi_jantung' => $request->thoraks_bunyi_jantung,
                'thoraks_retraksi' => $request->thoraks_retraksi,
                'thoraks_merintih' => $request->thoraks_merintih,
                'thoraks_rr' => $request->thoraks_rr,
                'thoraks_suara_nafas' => $request->thoraks_suara_nafas,
                'thoraks_suara_tambahan' => $request->thoraks_suara_tambahan,
                'abdomen_distensi' => $request->abdomen_distensi,
                'abdomen_bising_usus' => $request->abdomen_bising_usus,
                'abdomen_venektasi' => $request->abdomen_venektasi,
                'abdomen_hepar' => $request->abdomen_hepar,
                'abdomen_lien' => $request->abdomen_lien,
                'abdomen_tali_pusat' => $this->formatJsonForDatabase($request->abdomen_tali_pusat),
                'abdomen_arteri' => $request->abdomen_arteri,
                'abdomen_vena' => $request->abdomen_vena,
                'abdomen_kelainan' => $request->abdomen_kelainan,
                'genetalia' => $request->genetalia,
                'anus_keterangan' => $request->anus_keterangan,
                'anus_mekonium' => $request->anus_mekonium,
                'plantar_creases' => $this->formatJsonForDatabase($request->plantar_creases),
                'waktu_pengisian_kapiler' => $request->waktu_pengisian_kapiler,
                'kulit' => $this->formatJsonForDatabase($request->kulit),
                'kulit_lainnya' => $request->kulit_lainnya,
                'kuku' => $this->formatJsonForDatabase($request->kuku),
                'kuku_lainnya' => $request->kuku_lainnya,
                'user_create' => Auth::id()
            ]);

            // Process diagnosis data
            $diagnosisBanding = $this->processJsonData($request->diagnosis_banding);
            $diagnosisKerja = $this->processJsonData($request->diagnosis_kerja);

            // 4. Store ke RmeAsesmenMedisNeonatologiDtl
            RmeAsesmenMedisNeonatologiDtl::create([
                'id_asesmen' => $asesmen->id,
                'appearance_1' => $request->appearance_1,
                'pulse_1' => $request->pulse_1,
                'grimace_1' => $request->grimace_1,
                'activity_1' => $request->activity_1,
                'respiration_1' => $request->respiration_1,
                'appearance_5' => $request->appearance_5,
                'pulse_5' => $request->pulse_5,
                'grimace_5' => $request->grimace_5,
                'activity_5' => $request->activity_5,
                'respiration_5' => $request->respiration_5,
                'total_1_minute' => $request->total_1_minute,
                'total_5_minute' => $request->total_5_minute,
                'total_combined' => $request->total_combined,
                'diagnosis_ibu_1' => $request->diagnosis_ibu_1,
                'diagnosis_ibu_2' => $request->diagnosis_ibu_2,
                'diagnosis_ibu_3' => $request->diagnosis_ibu_3,
                'cara_persalinan' => $this->formatJsonForDatabase($request->cara_persalinan),
                'indikasi' => $request->indikasi,
                'faktor_resiko_mayor' => $this->formatJsonForDatabase($request->faktor_resiko_mayor),
                'faktor_resiko_minor' => $this->formatJsonForDatabase($request->faktor_resiko_minor),
                'refleks_moro' => $request->refleks_moro,
                'refleks_rooting' => $request->refleks_rooting,
                'refleks_palmar_grasping' => $request->refleks_palmar_grasping,
                'refleks_sucking' => $request->refleks_sucking,
                'refleks_plantar_grasping' => $request->refleks_plantar_grasping,
                'refleks_tonic_neck' => $request->refleks_tonic_neck,
                'kelainan_bawaan_1' => $request->kelainan_bawaan_1,
                'kelainan_bawaan_2' => $request->kelainan_bawaan_2,
                'kelainan_bawaan_3' => $request->kelainan_bawaan_3,
                'kelainan_bawaan_4' => $request->kelainan_bawaan_4,
                'hasil_laboratorium' => $request->hasil_laboratorium,
                'hasil_radiologi' => $request->hasil_radiologi,
                'hasil_lainnya' => $request->hasil_lainnya,
                'prognosis' => $request->prognosis,
                'rencana_pengobatan' => $request->rencana_pengobatan,
                'usia_menarik_bayi' => $request->usia_menarik_bayi,
                'keterangan_usia' => $request->keterangan_usia,
                'keterangan_tidak_usia' => $request->keterangan_tidak_usia,
                'masalah_pulang' => $request->masalah_pulang,
                'keterangan_masalah_pulang' => $request->keterangan_masalah_pulang,
                'beresiko_finansial' => $request->beresiko_finansial,
                'edukasi' => $this->formatJsonForDatabase($request->edukasi),
                'edukasi_lainnya_keterangan' => $request->edukasi_lainnya_keterangan,
                'ada_membantu' => $request->ada_membantu,
                'keterangan_membantu' => $request->keterangan_membantu,
                'perkiraan_lama_rawat' => $request->perkiraan_lama_rawat,
                'rencana_tanggal_pulang' => $request->rencana_tanggal_pulang,
                'diagnosis_banding' => $this->formatJsonForDatabase($diagnosisBanding),
                'diagnosis_kerja' => $this->formatJsonForDatabase($diagnosisKerja),
                'user_create' => Auth::id()
            ]);

            // Handle diagnosis ke master
            if (!empty($diagnosisBanding) && is_array($diagnosisBanding)) {
                $this->saveDiagnosisToMaster($diagnosisBanding);
            }

            if (!empty($diagnosisKerja) && is_array($diagnosisKerja)) {
                $this->saveDiagnosisToMaster($diagnosisKerja);
            }

            // Handle alergi
            $this->handleAlergiData($request, $kd_pasien);

            DB::commit();

            return redirect()
                ->route('rawat-inap.asesmen.medis.umum.index', [
                    'kd_unit' => $kd_unit,
                    'kd_pasien' => $kd_pasien,
                    'tgl_masuk' => $tgl_masuk,
                    'urut_masuk' => $urut_masuk
                ])
                ->with('success', 'Data asesmen medis neonatologi berhasil disimpan');

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
            $asesmen = RmeAsesmen::with([
                'asesmenMedisNeonatologi',
                'asesmenMedisNeonatologiFisikGeneralis',
                'asesmenMedisNeonatologiDtl'
            ])->findOrFail($id);

        } catch (ModelNotFoundException $e) {
            abort(404, 'Data asesmen tidak ditemukan');
        } catch (\Exception $e) {
            $asesmen = RmeAsesmen::findOrFail($id);
        }

        $dataMedis = $this->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

        if (!$dataMedis) {
            abort(404, 'Data medis tidak ditemukan');
        }

        $masterData = $this->getMasterData($kd_pasien);

        return view(
            'unit-pelayanan.rawat-inap.pelayanan.asesmen-medis-neonatologi.show',
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
            $asesmen = RmeAsesmen::with([
                'asesmenMedisNeonatologi',
                'asesmenMedisNeonatologiFisikGeneralis',
                'asesmenMedisNeonatologiDtl'
            ])->findOrFail($id);

        } catch (ModelNotFoundException $e) {
            abort(404, 'Data asesmen tidak ditemukan');
        } catch (\Exception $e) {
            $asesmen = RmeAsesmen::findOrFail($id);
        }

        $dataMedis = $this->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

        if (!$dataMedis) {
            abort(404, 'Data medis tidak ditemukan');
        }

        $masterData = $this->getMasterData($kd_pasien);

        return view(
            'unit-pelayanan.rawat-inap.pelayanan.asesmen-medis-neonatologi.edit',
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
        $request->validate([
            'kd_pasien' => 'required',
            'kd_unit' => 'required',
            'tgl_masuk' => 'required|date',
            'urut_masuk' => 'required',
            'tanggal' => 'required|date',
            'jam' => 'required',
        ]);

        DB::beginTransaction();
        try {

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

            // Update main table (RME_ASESMEN_MEDIS_NEONATOLOGI)
            $asesmen->asesmenMedisNeonatologi()->updateOrCreate(
            ['id_asesmen' => $asesmen->id],
            [
                'tanggal' => $request->tanggal,
                'jam' => $request->jam,
                'no_hp' => $request->no_hp,
                'transportasi' => $this->formatJsonForDatabase($request->transportasi)  ,
                'kendaraan_lainnya_detail' => $request->kendaraan_lainnya_detail,
                'anamnesis' => $request->anamnesis,
                'lahir' => $request->lahir,
                'lahir_rs_lain' => $request->lahir_rs_lain,
                'keluahan_bayi' => $request->keluahan_bayi,
                'anak_ke' => $request->anak_ke,
                'anc' => $request->anc,
                'usg_kali' => $request->usg_kali,
                'hpht_tanggal' => $request->hpht_tanggal,
                'taksiran_tanggal' => $request->taksiran_tanggal,
                'nyeri_bak' => $request->nyeri_bak,
                'keputihan' => $request->keputihan,
                'perdarahan' => $request->perdarahan,
                'ketuban_pecah' => $request->ketuban_pecah,
                'ketuban_jam' => $request->ketuban_jam,
                'gawat_janin' => $request->gawat_janin,
                'demam' => $request->demam,
                'demam_suhu' => $request->demam_suhu,
                'terapi_deksametason' => $request->terapi_deksametason,
                'deksametason_kali' => $request->deksametason_kali,
                'terapi_lain' => $request->terapi_lain,
                'riwayat_penyakit_ibu' => $this->formatJsonForDatabase($request->riwayat_penyakit_ibu),
                'riwayat_penyakit_ibu_lain' => $request->riwayat_penyakit_ibu_lain,
                'user_edit' => Auth::id()
            ]);

            // Update or create fisik-generalis data
            $asesmen->asesmenMedisNeonatologiFisikGeneralis()->updateOrCreate(
                ['id_asesmen' => $asesmen->id],
                [
                    'postur_tubuh' => $request->postur_tubuh,
                    'tangis' => $request->tangis,
                    'anemia' => $request->anemia,
                    'dispnoe' => $request->dispnoe,
                    'edema' => $request->edema,
                    'ikterik' => $request->ikterik,
                    'sianosis' => $request->sianosis,
                    'denyut_jantung' => $request->denyut_jantung,
                    'nadi' => $request->nadi,
                    'respirasi' => $request->respirasi,
                    'spo' => $request->spo,
                    'merintih' => $request->merintih,
                    'temperatur' => $request->temperatur,
                    'bbl_pbl' => $request->bbl_pbl,
                    'lk_ld' => $request->lk_ld,
                    'bb_sekarang' => $request->bb_sekarang,
                    'pb_sekarang' => $request->pb_sekarang,
                    'lk_sekarang' => $request->lk_sekarang,
                    'bollard_score' => $request->bollard_score,
                    'skor_nyeri' => $request->skor_nyeri,
                    'down_score' => $request->down_score,
                    'kepala_bentuk' => $request->kepala_bentuk,
                    'kepala_uub' => $request->kepala_uub,
                    'kepala_uuk' => $request->kepala_uuk,
                    'caput_sucedaneum' => $request->caput_sucedaneum,
                    'cephalohematom' => $request->cephalohematom,
                    'kepala_lp' => $request->kepala_lp,
                    'kepala_lain' => $request->kepala_lain,
                    'mata_pucat' => $request->mata_pucat,
                    'mata_ikterik' => $request->mata_ikterik,
                    'pupil' => $request->pupil,
                    'refleks_cahaya' => $request->refleks_cahaya,
                    'refleks_kornea' => $request->refleks_kornea,
                    'nafas_cuping' => $request->nafas_cuping,
                    'hidung_lain' => $request->hidung_lain,
                    'telinga_keterangan' => $request->telinga_keterangan,
                    'mulut_sianosis' => $request->mulut_sianosis,
                    'mulut_lidah' => $request->mulut_lidah,
                    'mulut_tenggorokan' => $request->mulut_tenggorokan,
                    'mulut_lain' => $request->mulut_lain,
                    'leher_kgb' => $request->leher_kgb,
                    'leher_tvj' => $request->leher_tvj,
                    'thoraks_bentuk' => $this->formatJsonForDatabase($request->thoraks_bentuk),
                    'thoraks_areola_mamae' => $request->thoraks_areola_mamae,
                    'thoraks_hr' => $request->thoraks_hr,
                    'thoraks_murmur' => $request->thoraks_murmur,
                    'thoraks_bunyi_jantung' => $request->thoraks_bunyi_jantung,
                    'thoraks_retraksi' => $request->thoraks_retraksi,
                    'thoraks_merintih' => $request->thoraks_merintih,
                    'thoraks_rr' => $request->thoraks_rr,
                    'thoraks_suara_nafas' => $request->thoraks_suara_nafas,
                    'thoraks_suara_tambahan' => $request->thoraks_suara_tambahan,
                    'abdomen_distensi' => $request->abdomen_distensi,
                    'abdomen_bising_usus' => $request->abdomen_bising_usus,
                    'abdomen_venektasi' => $request->abdomen_venektasi,
                    'abdomen_hepar' => $request->abdomen_hepar,
                    'abdomen_lien' => $request->abdomen_lien,
                    'abdomen_tali_pusat' => $this->formatJsonForDatabase($request->abdomen_tali_pusat),
                    'abdomen_arteri' => $request->abdomen_arteri,
                    'abdomen_vena' => $request->abdomen_vena,
                    'abdomen_kelainan' => $request->abdomen_kelainan,
                    'genetalia' => $request->genetalia,
                    'anus_keterangan' => $request->anus_keterangan,
                    'anus_mekonium' => $request->anus_mekonium,
                    'plantar_creases' => $this->formatJsonForDatabase($request->plantar_creases),
                    'waktu_pengisian_kapiler' => $request->waktu_pengisian_kapiler,
                    'kulit' => $this->formatJsonForDatabase($request->kulit),
                    'kulit_lainnya' => $request->kulit_lainnya,
                    'kuku' => $this->formatJsonForDatabase($request->kuku),
                    'kuku_lainnya' => $request->kuku_lainnya,
                    'user_edit' => Auth::id()
                ]
            );

            // Process diagnosis data
            $diagnosisBanding = $this->processJsonData($request->diagnosis_banding);
            $diagnosisKerja = $this->processJsonData($request->diagnosis_kerja);

            // Update or create detail data
            $asesmen->asesmenMedisNeonatologiDtl()->updateOrCreate(
                ['id_asesmen' => $asesmen->id],
                [
                    'appearance_1' => $request->appearance_1,
                    'pulse_1' => $request->pulse_1,
                    'grimace_1' => $request->grimace_1,
                    'activity_1' => $request->activity_1,
                    'respiration_1' => $request->respiration_1,
                    'appearance_5' => $request->appearance_5,
                    'pulse_5' => $request->pulse_5,
                    'grimace_5' => $request->grimace_5,
                    'activity_5' => $request->activity_5,
                    'respiration_5' => $request->respiration_5,
                    'total_1_minute' => $request->total_1_minute,
                    'total_5_minute' => $request->total_5_minute,
                    'total_combined' => $request->total_combined,
                    'diagnosis_ibu_1' => $request->diagnosis_ibu_1,
                    'diagnosis_ibu_2' => $request->diagnosis_ibu_2,
                    'diagnosis_ibu_3' => $request->diagnosis_ibu_3,
                    'cara_persalinan' => $this->formatJsonForDatabase($request->cara_persalinan),
                    'indikasi' => $request->indikasi,
                    'faktor_resiko_mayor' => $this->formatJsonForDatabase($request->faktor_resiko_mayor),
                    'faktor_resiko_minor' => $this->formatJsonForDatabase($request->faktor_resiko_minor),
                    'refleks_moro' => $request->refleks_moro,
                    'refleks_rooting' => $request->refleks_rooting,
                    'refleks_palmar_grasping' => $request->refleks_palmar_grasping,
                    'refleks_sucking' => $request->refleks_sucking,
                    'refleks_plantar_grasping' => $request->refleks_plantar_grasping,
                    'refleks_tonic_neck' => $request->refleks_tonic_neck,
                    'kelainan_bawaan_1' => $request->kelainan_bawaan_1,
                    'kelainan_bawaan_2' => $request->kelainan_bawaan_2,
                    'kelainan_bawaan_3' => $request->kelainan_bawaan_3,
                    'kelainan_bawaan_4' => $request->kelainan_bawaan_4,
                    'hasil_laboratorium' => $request->hasil_laboratorium,
                    'hasil_radiologi' => $request->hasil_radiologi,
                    'hasil_lainnya' => $request->hasil_lainnya,
                    'prognosis' => $request->prognosis,
                    'rencana_pengobatan' => $request->rencana_pengobatan,
                    'usia_menarik_bayi' => $request->usia_menarik_bayi,
                    'keterangan_usia' => $request->keterangan_usia,
                    'keterangan_tidak_usia' => $request->keterangan_tidak_usia,
                    'masalah_pulang' => $request->masalah_pulang,
                    'keterangan_masalah_pulang' => $request->keterangan_masalah_pulang,
                    'beresiko_finansial' => $request->beresiko_finansial,
                    'edukasi' => $this->formatJsonForDatabase($request->edukasi),
                    'edukasi_lainnya_keterangan' => $request->edukasi_lainnya_keterangan,
                    'ada_membantu' => $request->ada_membantu,
                    'keterangan_membantu' => $request->keterangan_membantu,
                    'perkiraan_lama_rawat' => $request->perkiraan_lama_rawat,
                    'rencana_tanggal_pulang' => $request->rencana_tanggal_pulang,
                    'diagnosis_banding' => $this->formatJsonForDatabase($diagnosisBanding),
                    'diagnosis_kerja' => $this->formatJsonForDatabase($diagnosisKerja),
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

            DB::commit();

            return redirect()
                ->route('rawat-inap.asesmen.medis.umum.index', [
                    'kd_unit' => $kd_unit,
                    'kd_pasien' => $kd_pasien,
                    'tgl_masuk' => $tgl_masuk,
                    'urut_masuk' => $urut_masuk
                ])
                ->with('success', 'Data asesmen medis neonatologi berhasil diperbarui');

        } catch (\Exception $e) {
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
                throw new \Exception('Data transaksi tidak ditemukan');
            }

            // Find existing asesmen
            $asesmenMedisNeonatologi = RmeAsesmenMedisNeonatologi::where('no_transaksi', $transaksiData->no_transaksi)->first();

            if (!$asesmenMedisNeonatologi) {
                throw new \Exception('Data asesmen tidak ditemukan');
            }

            // Delete related data first
            $asesmenMedisNeonatologi->asesmenMedisNeonatologiFisikGeneralis()->delete();
            $asesmenMedisNeonatologi->asesmenMedisNeonatologiDtl()->delete();

            // Delete main data
            $asesmenMedisNeonatologi->delete();

            // Delete asesmen record if exists
            if ($asesmenMedisNeonatologi->asesmen) {
                $asesmenMedisNeonatologi->asesmen->delete();
            }

            DB::commit();

            return redirect()
                ->route('rawat-inap.asesmen.medis.umum.index', [
                    'kd_unit' => $kd_unit,
                    'kd_pasien' => $kd_pasien,
                    'tgl_masuk' => $tgl_masuk,
                    'urut_masuk' => $urut_masuk
                ])
                ->with('success', 'Data asesmen medis neonatologi berhasil dihapus');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
