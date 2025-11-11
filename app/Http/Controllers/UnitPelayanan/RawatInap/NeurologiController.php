<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\MrItemFisik;
use App\Models\RmeAlergiPasien;
use App\Models\RmeAsesmen;
use App\Models\RmeAsesmenNeurologi;
use App\Models\RmeAsesmenNeurologiDischargePlanning;
use App\Models\RmeAsesmenNeurologiIntensitasNyeri;
use App\Models\RmeAsesmenNeurologiSistemSyaraf;
use App\Models\RmeAsesmenPemeriksaanFisik;
use App\Models\RmeMasterDiagnosis;
use App\Models\RmeMasterImplementasi;
use App\Models\RMEResume;
use App\Models\RmeResumeDtl;
use App\Models\SatsetPrognosis;
use App\Services\AsesmenService;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Support\Facades\DB;

class NeurologiController extends Controller
{
    protected $asesmenService;
    private $baseService;

    public function __construct()
    {
        $this->asesmenService = new AsesmenService();
        $this->baseService = new BaseService();
        $this->middleware('can:read unit-pelayanan/rawat-inap');
    }

    public function index(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $itemFisik = MrItemFisik::orderby('urut')->get();
        $rmeMasterDiagnosis = RmeMasterDiagnosis::all();
        $rmeMasterImplementasi = RmeMasterImplementasi::all();
        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();
        $satsetPrognosis = SatsetPrognosis::all();
        // Get latest vital signs data for the patient
        $vitalSignsData = $this->asesmenService->getLatestVitalSignsByPatient($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

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

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        return view('unit-pelayanan.rawat-inap.pelayanan.neurologi.create', compact(
            'dataMedis',
            'itemFisik',
            'rmeMasterDiagnosis',
            'rmeMasterImplementasi',
            'alergiPasien',
            'satsetPrognosis',
            'vitalSignsData'
        ));
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {

        DB::beginTransaction();

        try {
            $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
            if (empty($dataMedis)) throw new Exception("Data kunjungan tidak ditemukan");

            $asesmen = new RmeAsesmen();
            $asesmen->kd_pasien = $request->kd_pasien;
            $asesmen->kd_unit = $request->kd_unit;
            $asesmen->tgl_masuk = $request->tgl_masuk;
            $asesmen->urut_masuk = $request->urut_masuk;
            $asesmen->user_id = Auth::id();
            $asesmen->waktu_asesmen = date('Y-m-d H:i:s');
            $asesmen->kategori = 1;
            $asesmen->sub_kategori = 3;
            $asesmen->save();

            // Prepare vital sign data (hanya field yang ada input)
            $vitalSignInput = [
                'sistole'        => $request->darah_sistole,
                'diastole'       => $request->darah_diastole,
                'nadi'           => $request->nadi,
                'respiration'    => $request->respirasi,
                'suhu'           => $request->suhu,
                'spo2_tanpa_o2'  => $request->spo_o2_tanpa,
                'spo2_dengan_o2' => $request->spo_o2_dengan,
                'tinggi_badan'   => $request->tinggi_badan,
                'berat_badan'    => $request->berat_badan,
            ];

            $mapping = [
                'sistole'        => 'int',
                'diastole'       => 'int',
                'nadi'           => 'int',
                'respiration'    => 'int',
                'suhu'           => 'float',
                'spo2_tanpa_o2'  => 'int',
                'spo2_dengan_o2' => 'int',
                'tinggi_badan'   => 'int',
                'berat_badan'    => 'int',
            ];

            $vitalSignData = [];
            foreach ($mapping as $field => $type) {
                if (isset($vitalSignInput[$field]) && $vitalSignInput[$field] !== '' && $vitalSignInput[$field] !== null) {
                    $vitalSignData[$field] = $type === 'int'
                        ? (int) $vitalSignInput[$field]
                        : (float) $vitalSignInput[$field];
                }
            }

            // Save vital signs using service (hanya field yang terisi)
            if (!empty($vitalSignData)) {
                $this->asesmenService->store(
                    $vitalSignData,
                    $kd_pasien,
                    $dataMedis->no_transaksi,
                    $dataMedis->kd_kasir
                );
            }


            $asesmenNeurologi = new RmeAsesmenNeurologi();
            $asesmenNeurologi->id_asesmen = $asesmen->id;
            $asesmenNeurologi->keluhan_utama = $request->keluhan_utama;
            $asesmenNeurologi->riwayat_penyakit_sekarang = $request->riwayat_penyakit_sekarang;
            $asesmenNeurologi->riwayat_penyakit_terdahulu = $request->riwayat_penyakit_terdahulu;
            $asesmenNeurologi->riwayat_penyakit_keluarga = $request->riwayat_penyakit_keluarga;
            $asesmenNeurologi->riwayat_pengobatan = $request->riwayat_pengobatan;
            $asesmenNeurologi->riwayat_pengobatan_keterangan = $request->riwayat_pengobatan_keterangan;
            $asesmenNeurologi->riwayat_alergi = $request->riwayat_alergi;
            $asesmenNeurologi->tekanan_darah = $request->tekanan_darah;
            $asesmenNeurologi->respirasi = $request->respirasi;
            $asesmenNeurologi->suhu = $request->suhu;
            $asesmenNeurologi->nadi = $request->nadi;
            $asesmenNeurologi->darah_sistole = $request->darah_sistole;
            $asesmenNeurologi->darah_diastole = $request->darah_diastole;
            $asesmenNeurologi->evaluasi_evaluasi_keperawatan = $request->evaluasi_evaluasi_keperawatan;
            $asesmenNeurologi->save();

            //Simpan ke table RmePemeriksaanFisik
            $itemFisik = MrItemFisik::all();
            foreach ($itemFisik as $item) {
                $itemName = strtolower($item->nama);
                $isNormal = $request->has($item->id . '-normal') ? 1 : 0;
                $keterangan = $request->input($item->id . '_keterangan');
                if ($isNormal) $keterangan = '';

                RmeAsesmenPemeriksaanFisik::create([
                    'id_asesmen' => $asesmen->id,
                    'id_item_fisik' => $item->id,
                    'is_normal' => $isNormal,
                    'keterangan' => $keterangan
                ]);
            }

            $asesmenNeurologiSistemSyaraf = new RmeAsesmenNeurologiSistemSyaraf();
            $asesmenNeurologiSistemSyaraf->id_asesmen = $asesmen->id;
            $asesmenNeurologiSistemSyaraf->kesadaran_kulitatif = $request->kesadaran_kulitatif;
            $asesmenNeurologiSistemSyaraf->kesadaran_kulitatif_e = $request->kesadaran_kulitatif_e;
            $asesmenNeurologiSistemSyaraf->kesadaran_kulitatif_m = $request->kesadaran_kulitatif_m;
            $asesmenNeurologiSistemSyaraf->kesadaran_kulitatif_v = $request->kesadaran_kulitatif_v;
            $asesmenNeurologiSistemSyaraf->pupil_isokor = $request->pupil_isokor;
            $asesmenNeurologiSistemSyaraf->pupil_anisokor = $request->pupil_anisokor;
            $asesmenNeurologiSistemSyaraf->pupil_cahaya_kiri = $request->pupil_cahaya_kiri;
            $asesmenNeurologiSistemSyaraf->pupil_cahaya_kanan = $request->pupil_cahaya_kanan;
            $asesmenNeurologiSistemSyaraf->pupil_kornea_kiri = $request->pupil_kornea_kiri;
            $asesmenNeurologiSistemSyaraf->pupil_kornea_kanan = $request->pupil_kornea_kanan;
            $asesmenNeurologiSistemSyaraf->nervus_cranialis = $request->nervus_cranialis;
            $asesmenNeurologiSistemSyaraf->ekstremitas_atas = $request->ekstremitas_atas;
            $asesmenNeurologiSistemSyaraf->ekstremitas_kanan = $request->ekstremitas_kanan;
            $asesmenNeurologiSistemSyaraf->ekstremitas_bawah = $request->ekstremitas_bawah;
            $asesmenNeurologiSistemSyaraf->ekstremitas_kiri = $request->ekstremitas_kiri;
            $asesmenNeurologiSistemSyaraf->refleks_atas = $request->refleks_atas;
            $asesmenNeurologiSistemSyaraf->refleks_kanan = $request->refleks_kanan;
            $asesmenNeurologiSistemSyaraf->refleks_bawah = $request->refleks_bawah;
            $asesmenNeurologiSistemSyaraf->refleks_kiri = $request->refleks_kiri;
            $asesmenNeurologiSistemSyaraf->refleks_patologis_atas = $request->refleks_patologis_atas;
            $asesmenNeurologiSistemSyaraf->refleks_patologis_kanan = $request->refleks_patologis_kanan;
            $asesmenNeurologiSistemSyaraf->refleks_patologis_bawah = $request->refleks_patologis_bawah;
            $asesmenNeurologiSistemSyaraf->refleks_patologis_kiri = $request->refleks_patologis_kiri;
            $asesmenNeurologiSistemSyaraf->kekuatan_atas = $request->kekuatan_atas;
            $asesmenNeurologiSistemSyaraf->kekuatan_kanan = $request->kekuatan_kanan;
            $asesmenNeurologiSistemSyaraf->kekuatan_bawah = $request->kekuatan_bawah;
            $asesmenNeurologiSistemSyaraf->kekuatan_kiri = $request->kekuatan_kiri;
            $asesmenNeurologiSistemSyaraf->klonus_kiri = $request->klonus_kiri;
            $asesmenNeurologiSistemSyaraf->klonus_kanan = $request->klonus_kanan;
            $asesmenNeurologiSistemSyaraf->laseque_kiri = $request->laseque_kiri;
            $asesmenNeurologiSistemSyaraf->laseque_kanan = $request->laseque_kanan;
            $asesmenNeurologiSistemSyaraf->patrick_kiri = $request->patrick_kiri;
            $asesmenNeurologiSistemSyaraf->patrick_kanan = $request->patrick_kanan;
            $asesmenNeurologiSistemSyaraf->kontra_kiri = $request->kontra_kiri;
            $asesmenNeurologiSistemSyaraf->kontra_kanan = $request->kontra_kanan;
            $asesmenNeurologiSistemSyaraf->kaku_kuduk = $request->kaku_kuduk;
            $asesmenNeurologiSistemSyaraf->tes_brudzinski = $request->tes_brudzinski;
            $asesmenNeurologiSistemSyaraf->tanda_kerning = $request->tanda_kerning;
            $asesmenNeurologiSistemSyaraf->nistagmus = $request->nistagmus;
            $asesmenNeurologiSistemSyaraf->dismitri = $request->dismitri;
            $asesmenNeurologiSistemSyaraf->disdiadokokinesis = $request->disdiadokokinesis;
            $asesmenNeurologiSistemSyaraf->tes_romberg = $request->tes_romberg;
            $asesmenNeurologiSistemSyaraf->ataksia = $request->ataksia;
            $asesmenNeurologiSistemSyaraf->cara_berjalan = $request->cara_berjalan;
            $asesmenNeurologiSistemSyaraf->tremor = $request->tremor;
            $asesmenNeurologiSistemSyaraf->khorea = $request->khorea;
            $asesmenNeurologiSistemSyaraf->balismus = $request->balismus;
            $asesmenNeurologiSistemSyaraf->atetose = $request->atetose;
            $asesmenNeurologiSistemSyaraf->sensibilitas = $request->sensibilitas;
            $asesmenNeurologiSistemSyaraf->miksi = $request->miksi;
            $asesmenNeurologiSistemSyaraf->defekasi = $request->defekasi;
            $asesmenNeurologiSistemSyaraf->save();

            $asesmenNeurologiIntensitasNyeri = new RmeAsesmenNeurologiIntensitasNyeri();
            $asesmenNeurologiIntensitasNyeri->id_asesmen = $asesmen->id;
            $asesmenNeurologiIntensitasNyeri->skala_nyeri = $request->skala_nyeri;
            $asesmenNeurologiIntensitasNyeri->diagnosis_banding = $request->diagnosis_banding;
            $asesmenNeurologiIntensitasNyeri->diagnosis_kerja = $request->diagnosis_kerja;
            $asesmenNeurologiIntensitasNyeri->prognosis = $request->prognosis;
            $asesmenNeurologiIntensitasNyeri->observasi = $request->observasi;
            $asesmenNeurologiIntensitasNyeri->terapeutik = $request->terapeutik;
            $asesmenNeurologiIntensitasNyeri->edukasi = $request->edukasi;
            $asesmenNeurologiIntensitasNyeri->kolaborasi = $request->kolaborasi;
            $asesmenNeurologiIntensitasNyeri->neurologi_prognosis = $request->neurologi_prognosis;
            $asesmenNeurologiIntensitasNyeri->rencana_pengobatan = $request->rencana_pengobatan;
            $asesmenNeurologiIntensitasNyeri->save();

            //Simpan Diagnosa ke Master
            $diagnosisBandingList = json_decode($request->diagnosis_banding ?? '[]', true);
            $diagnosisKerjaList = json_decode($request->diagnosis_kerja ?? '[]', true);
            $allDiagnoses = array_merge($diagnosisBandingList, $diagnosisKerjaList);
            foreach ($allDiagnoses as $diagnosa) {
                $existingDiagnosa = RmeMasterDiagnosis::where('nama_diagnosis', $diagnosa)->first();
                if (!$existingDiagnosa) {
                    $masterDiagnosa = new RmeMasterDiagnosis();
                    $masterDiagnosa->nama_diagnosis = $diagnosa;
                    $masterDiagnosa->save();
                }
            }

            // Simpan Implementasi ke Master
            $rppList = json_decode($request->prognosis ?? '[]', true);
            $observasiList = json_decode($request->observasi ?? '[]', true);
            $terapeutikList = json_decode($request->terapeutik ?? '[]', true);
            $edukasiList = json_decode($request->edukasi ?? '[]', true);
            $kolaborasiList = json_decode($request->kolaborasi ?? '[]', true);
            // Fungsi untuk menyimpan data ke kolom tertentu
            function saveToColumn($dataList, $column)
            {
                foreach ($dataList as $item) {
                    // Cek apakah sudah ada entri
                    $existingImplementasi = RmeMasterImplementasi::where($column, $item)->first();

                    if (!$existingImplementasi) {
                        // Jika tidak ada, buat record baru
                        $masterImplementasi = new RmeMasterImplementasi();
                        $masterImplementasi->$column = $item;
                        $masterImplementasi->save();
                    }
                }
            }

            // Simpan data
            saveToColumn($rppList, 'prognosis'); // sudah terlanjut buat ke rpp jadi yang di ubah hanya name sesuai DB saja ke prognosis
            saveToColumn($observasiList, 'observasi');
            saveToColumn($terapeutikList, 'terapeutik');
            saveToColumn($edukasiList, 'edukasi');
            saveToColumn($kolaborasiList, 'kolaborasi');

            $asesmenNeurologiDischargePlanning = new RmeAsesmenNeurologiDischargePlanning();
            $asesmenNeurologiDischargePlanning->id_asesmen = $asesmen->id;
            $asesmenNeurologiDischargePlanning->usia_lanjut = $request->usia_lanjut;
            $asesmenNeurologiDischargePlanning->hambatan_mobilisasi = $request->hambatan_mobilisasi;
            $asesmenNeurologiDischargePlanning->pelayanan_medis = $request->pelayanan_medis;
            $asesmenNeurologiDischargePlanning->ketergantungan = $request->ketergantungan;
            $asesmenNeurologiDischargePlanning->rencana_pulang_khusus = $request->rencana_pulang_khusus;
            $asesmenNeurologiDischargePlanning->rencana_lama_perawatan = $request->rencana_lama_perawatan;
            $asesmenNeurologiDischargePlanning->rencana_tanggal_pulang = $request->rencana_tanggal_pulang;
            $asesmenNeurologiDischargePlanning->save();

            $vitalSignStore = [
                'sistole'        => (int) $request->darah_sistole ?? null,
                'diastole'       => (int) $request->darah_diastole ?? null,
                'nadi'           => (int)$request->nadi ?? null,
                'respiration'    => (int) $request->respirasi ?? null,
                'suhu'           => (float) $request->suhu ?? null,
            ];

            // create resume
            $resumeData = [
                'anamnesis'             => $request->keluhan_utama,
                'diagnosis'             => $allDiagnoses,

                'konpas'                =>
                [
                    'sistole'   => [
                        'hasil' => $vitalSignStore['sistole'] ?? null
                    ],
                    'distole'   => [
                        'hasil' => $vitalSignStore['diastole'] ?? null
                    ],
                    'respiration_rate'   => [
                        'hasil' => $vitalSignStore['respiration'] ?? null
                    ],
                    'suhu'   => [
                        'hasil' => $vitalSignStore['suhu'] ?? null
                    ],
                    'nadi'   => [
                        'hasil' => $vitalSignStore['nadi'] ?? null
                    ]
                ]
            ];

            $this->baseService->updateResumeMedis($dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $resumeData);

            DB::commit();

            return redirect()->route('rawat-inap.asesmen.medis.umum.index', [
                'kd_unit' => request()->route('kd_unit'),
                'kd_pasien' => request()->route('kd_pasien'),
                'tgl_masuk' => request()->route('tgl_masuk'),
                'urut_masuk' => request()->route('urut_masuk'),
            ])->with(['success' => 'Berhasil menambah asesmen Neurologi !']);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function show($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            // Ambil data asesmen beserta relasinya
            $asesmen = RmeAsesmen::with([
                'user',
                'rmeAsesmenNeurologi',
                'rmeAsesmenNeurologiSistemSyaraf',
                'pemeriksaanFisik',
                'rmeAsesmenNeurologiIntensitasNyeri',
                'rmeAsesmenNeurologiDischargePlanning',
            ])->findOrFail($id);

            $dataMedis = Kunjungan::with('pasien')
                ->where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->firstOrFail();

            $itemFisikIds = $asesmen->pemeriksaanFisik->pluck('id_item_fisik')->unique()->toArray();
            $itemFisik = MrItemFisik::whereIn('id', $itemFisikIds)->orderBy('urut')->get();
            $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();
            $satsetPrognosis = SatsetPrognosis::all();

            return view('unit-pelayanan.rawat-inap.pelayanan.neurologi.show', compact(
                'asesmen',
                'dataMedis',
                'itemFisik',
                'alergiPasien',
                'satsetPrognosis'
            ));
        } catch (ModelNotFoundException $e) {
            return back()->with('error', 'Data tidak ditemukan. Detail: ' . $e->getMessage());
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            // Cari asesmen berdasarkan ID dengan eager loading untuk semua relasi yang dibutuhkan
            $asesmen = RmeAsesmen::with([
                'user',
                'rmeAsesmenNeurologi',
                'rmeAsesmenNeurologiSistemSyaraf',
                'pemeriksaanFisik',
                'rmeAsesmenNeurologiIntensitasNyeri',
                'rmeAsesmenNeurologiDischargePlanning',
            ])->findOrFail($id);

            // Pastikan data kunjungan pasien ditemukan dan sesuai dengan parameter
            $dataMedis = Kunjungan::with('pasien')
                ->where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->whereDate('tgl_masuk', date('Y-m-d', strtotime($tgl_masuk)))
                ->where('urut_masuk', $urut_masuk)
                ->firstOrFail();

            // Ambil data pendukung
            $itemFisik = MrItemFisik::orderby('urut')->get();
            $pemeriksaanFisik = RmeAsesmenPemeriksaanFisik::where('id_asesmen', $asesmen->id)
                ->get()
                ->keyBy('id_item_fisik');
            $rmeMasterDiagnosis = RmeMasterDiagnosis::all();
            $rmeMasterImplementasi = RmeMasterImplementasi::all();
            $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();
            $satsetPrognosis = SatsetPrognosis::all();

            // Kirim data ke view
            return view('unit-pelayanan.rawat-inap.pelayanan.neurologi.edit', compact(
                'asesmen',
                'dataMedis',
                'itemFisik',
                'pemeriksaanFisik',
                'rmeMasterDiagnosis',
                'rmeMasterImplementasi',
                'alergiPasien',
                'satsetPrognosis'
            ));
        } catch (\Exception $e) {
            // Tangani error dan berikan pesan yang jelas
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengambil data asesmen: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
            if (empty($dataMedis)) throw new Exception("Data kunjungan tidak ditemukan");

            $asesmen = RmeAsesmen::findOrFail($id);
            $asesmen->kd_pasien = $request->kd_pasien;
            $asesmen->kd_unit = $request->kd_unit;
            $asesmen->tgl_masuk = $request->tgl_masuk;
            $asesmen->urut_masuk = $request->urut_masuk;
            $asesmen->user_id = Auth::id();
            $asesmen->waktu_asesmen = date('Y-m-d H:i:s');
            $asesmen->kategori = 1;
            $asesmen->sub_kategori = 3;
            $asesmen->save();

            $asesmenNeurologi = RmeAsesmenNeurologi::firstOrNew(['id_asesmen' => $asesmen->id]);
            $asesmenNeurologi->id_asesmen = $asesmen->id;
            $asesmenNeurologi->keluhan_utama = $request->keluhan_utama;
            $asesmenNeurologi->riwayat_penyakit_sekarang = $request->riwayat_penyakit_sekarang;
            $asesmenNeurologi->riwayat_penyakit_terdahulu = $request->riwayat_penyakit_terdahulu;
            $asesmenNeurologi->riwayat_penyakit_keluarga = $request->riwayat_penyakit_keluarga;
            $asesmenNeurologi->riwayat_pengobatan = $request->riwayat_pengobatan;
            $asesmenNeurologi->riwayat_pengobatan_keterangan = $request->riwayat_pengobatan_keterangan;
            $asesmenNeurologi->riwayat_alergi = $request->riwayat_alergi;
            $asesmenNeurologi->tekanan_darah = $request->tekanan_darah;
            $asesmenNeurologi->respirasi = $request->respirasi;
            $asesmenNeurologi->suhu = $request->suhu;
            $asesmenNeurologi->nadi = $request->nadi;
            $asesmenNeurologi->darah_diastole = $request->darah_diastole;
            $asesmenNeurologi->evaluasi_evaluasi_keperawatan = $request->evaluasi_evaluasi_keperawatan;
            $asesmenNeurologi->evaluasi_evaluasi_keperawatan = $request->evaluasi_evaluasi_keperawatan;
            $asesmenNeurologi->save();

            // Update ke table RmePemeriksaanFisik
            $itemFisik = MrItemFisik::all();
            foreach ($itemFisik as $item) {
                $itemName = strtolower($item->nama);
                $isNormal = $request->has($item->id . '-normal') ? 1 : 0;
                $keterangan = $request->input($item->id . '_keterangan');
                if ($isNormal) $keterangan = '';

                RmeAsesmenPemeriksaanFisik::updateOrCreate(
                    [
                        'id_asesmen' => $asesmen->id,
                        'id_item_fisik' => $item->id
                    ],
                    [
                        'is_normal' => $isNormal,
                        'keterangan' => $keterangan
                    ]
                );
            }

            $asesmenNeurologiSistemSyaraf = RmeAsesmenNeurologiSistemSyaraf::firstOrNew(['id_asesmen' => $asesmen->id]);
            $asesmenNeurologiSistemSyaraf->id_asesmen = $asesmen->id;
            $asesmenNeurologiSistemSyaraf->kesadaran_kulitatif = $request->kesadaran_kulitatif;
            $asesmenNeurologiSistemSyaraf->kesadaran_kulitatif_e = $request->kesadaran_kulitatif_e;
            $asesmenNeurologiSistemSyaraf->kesadaran_kulitatif_m = $request->kesadaran_kulitatif_m;
            $asesmenNeurologiSistemSyaraf->kesadaran_kulitatif_v = $request->kesadaran_kulitatif_v;
            $asesmenNeurologiSistemSyaraf->pupil_isokor = $request->pupil_isokor;
            $asesmenNeurologiSistemSyaraf->pupil_anisokor = $request->pupil_anisokor;
            $asesmenNeurologiSistemSyaraf->pupil_cahaya_kiri = $request->pupil_cahaya_kiri;
            $asesmenNeurologiSistemSyaraf->pupil_cahaya_kanan = $request->pupil_cahaya_kanan;
            $asesmenNeurologiSistemSyaraf->pupil_kornea_kiri = $request->pupil_kornea_kiri;
            $asesmenNeurologiSistemSyaraf->pupil_kornea_kanan = $request->pupil_kornea_kanan;
            $asesmenNeurologiSistemSyaraf->nervus_cranialis = $request->nervus_cranialis;
            $asesmenNeurologiSistemSyaraf->ekstremitas_atas = $request->ekstremitas_atas;
            $asesmenNeurologiSistemSyaraf->ekstremitas_kanan = $request->ekstremitas_kanan;
            $asesmenNeurologiSistemSyaraf->ekstremitas_bawah = $request->ekstremitas_bawah;
            $asesmenNeurologiSistemSyaraf->ekstremitas_kiri = $request->ekstremitas_kiri;
            $asesmenNeurologiSistemSyaraf->refleks_atas = $request->refleks_atas;
            $asesmenNeurologiSistemSyaraf->refleks_kanan = $request->refleks_kanan;
            $asesmenNeurologiSistemSyaraf->refleks_bawah = $request->refleks_bawah;
            $asesmenNeurologiSistemSyaraf->refleks_kiri = $request->refleks_kiri;
            $asesmenNeurologiSistemSyaraf->refleks_patologis_atas = $request->refleks_patologis_atas;
            $asesmenNeurologiSistemSyaraf->refleks_patologis_kanan = $request->refleks_patologis_kanan;
            $asesmenNeurologiSistemSyaraf->refleks_patologis_bawah = $request->refleks_patologis_bawah;
            $asesmenNeurologiSistemSyaraf->refleks_patologis_kiri = $request->refleks_patologis_kiri;
            $asesmenNeurologiSistemSyaraf->kekuatan_atas = $request->kekuatan_atas;
            $asesmenNeurologiSistemSyaraf->kekuatan_kanan = $request->kekuatan_kanan;
            $asesmenNeurologiSistemSyaraf->kekuatan_bawah = $request->kekuatan_bawah;
            $asesmenNeurologiSistemSyaraf->kekuatan_kiri = $request->kekuatan_kiri;
            $asesmenNeurologiSistemSyaraf->klonus_kiri = $request->klonus_kiri;
            $asesmenNeurologiSistemSyaraf->klonus_kanan = $request->klonus_kanan;
            $asesmenNeurologiSistemSyaraf->laseque_kiri = $request->laseque_kiri;
            $asesmenNeurologiSistemSyaraf->laseque_kanan = $request->laseque_kanan;
            $asesmenNeurologiSistemSyaraf->patrick_kiri = $request->patrick_kiri;
            $asesmenNeurologiSistemSyaraf->patrick_kanan = $request->patrick_kanan;
            $asesmenNeurologiSistemSyaraf->kontra_kiri = $request->kontra_kiri;
            $asesmenNeurologiSistemSyaraf->kontra_kanan = $request->kontra_kanan;
            $asesmenNeurologiSistemSyaraf->kaku_kuduk = $request->kaku_kuduk;
            $asesmenNeurologiSistemSyaraf->tes_brudzinski = $request->tes_brudzinski;
            $asesmenNeurologiSistemSyaraf->tanda_kerning = $request->tanda_kerning;
            $asesmenNeurologiSistemSyaraf->nistagmus = $request->nistagmus;
            $asesmenNeurologiSistemSyaraf->dismitri = $request->dismitri;
            $asesmenNeurologiSistemSyaraf->disdiadokokinesis = $request->disdiadokokinesis;
            $asesmenNeurologiSistemSyaraf->tes_romberg = $request->tes_romberg;
            $asesmenNeurologiSistemSyaraf->ataksia = $request->ataksia;
            $asesmenNeurologiSistemSyaraf->cara_berjalan = $request->cara_berjalan;
            $asesmenNeurologiSistemSyaraf->tremor = $request->tremor;
            $asesmenNeurologiSistemSyaraf->khorea = $request->khorea;
            $asesmenNeurologiSistemSyaraf->balismus = $request->balismus;
            $asesmenNeurologiSistemSyaraf->atetose = $request->atetose;
            $asesmenNeurologiSistemSyaraf->sensibilitas = $request->sensibilitas;
            $asesmenNeurologiSistemSyaraf->miksi = $request->miksi;
            $asesmenNeurologiSistemSyaraf->defekasi = $request->defekasi;
            $asesmenNeurologiSistemSyaraf->save();

            $asesmenNeurologiIntensitasNyeri = RmeAsesmenNeurologiIntensitasNyeri::firstOrNew(['id_asesmen' => $asesmen->id]);
            $asesmenNeurologiIntensitasNyeri->id_asesmen = $asesmen->id;
            $asesmenNeurologiIntensitasNyeri->skala_nyeri = $request->skala_nyeri;
            $asesmenNeurologiIntensitasNyeri->diagnosis_banding = $request->diagnosis_banding;
            $asesmenNeurologiIntensitasNyeri->diagnosis_kerja = $request->diagnosis_kerja;
            $asesmenNeurologiIntensitasNyeri->prognosis = $request->prognosis;
            $asesmenNeurologiIntensitasNyeri->observasi = $request->observasi;
            $asesmenNeurologiIntensitasNyeri->terapeutik = $request->terapeutik;
            $asesmenNeurologiIntensitasNyeri->edukasi = $request->edukasi;
            $asesmenNeurologiIntensitasNyeri->kolaborasi = $request->kolaborasi;
            $asesmenNeurologiIntensitasNyeri->neurologi_prognosis = $request->neurologi_prognosis;
            $asesmenNeurologiIntensitasNyeri->rencana_pengobatan = $request->rencana_pengobatan;
            $asesmenNeurologiIntensitasNyeri->save();

            //Simpan Diagnosa ke Master
            $diagnosisBandingList = json_decode($request->diagnosis_banding ?? '[]', true);
            $diagnosisKerjaList = json_decode($request->diagnosis_kerja ?? '[]', true);
            $allDiagnoses = array_merge($diagnosisBandingList, $diagnosisKerjaList);
            foreach ($allDiagnoses as $diagnosa) {
                $existingDiagnosa = RmeMasterDiagnosis::where('nama_diagnosis', $diagnosa)->first();
                if (!$existingDiagnosa) {
                    $masterDiagnosa = new RmeMasterDiagnosis();
                    $masterDiagnosa->nama_diagnosis = $diagnosa;
                    $masterDiagnosa->save();
                }
            }

            // Simpan Implementasi ke Master
            $rppList = json_decode($request->prognosis ?? '[]', true);
            $observasiList = json_decode($request->observasi ?? '[]', true);
            $terapeutikList = json_decode($request->terapeutik ?? '[]', true);
            $edukasiList = json_decode($request->edukasi ?? '[]', true);
            $kolaborasiList = json_decode($request->kolaborasi ?? '[]', true);
            // Fungsi untuk menyimpan data ke kolom tertentu
            function updateToColumn($dataList, $column)
            {
                foreach ($dataList as $item) {
                    // Cek apakah sudah ada entri
                    $existingImplementasi = RmeMasterImplementasi::where($column, $item)->first();

                    if (!$existingImplementasi) {
                        // Jika tidak ada, buat record baru
                        $masterImplementasi = new RmeMasterImplementasi();
                        $masterImplementasi->$column = $item;
                        $masterImplementasi->save();
                    }
                }
            }
            // Simpan data
            updateToColumn($rppList, 'prognosis'); // sudah terlanjut buat ke rpp jadi yang di ubah hanya name sesuai DB saja ke prognosis
            updateToColumn($observasiList, 'observasi');
            updateToColumn($terapeutikList, 'terapeutik');
            updateToColumn($edukasiList, 'edukasi');
            updateToColumn($kolaborasiList, 'kolaborasi');

            $asesmenNeurologiDischargePlanning = RmeAsesmenNeurologiDischargePlanning::firstOrNew(['id_asesmen' => $asesmen->id]);
            $asesmenNeurologiDischargePlanning->id_asesmen = $asesmen->id;
            $asesmenNeurologiDischargePlanning->usia_lanjut = $request->usia_lanjut;
            $asesmenNeurologiDischargePlanning->hambatan_mobilisasi = $request->hambatan_mobilisasi;
            $asesmenNeurologiDischargePlanning->pelayanan_medis = $request->pelayanan_medis;
            $asesmenNeurologiDischargePlanning->ketergantungan = $request->ketergantungan;
            $asesmenNeurologiDischargePlanning->rencana_pulang_khusus = $request->rencana_pulang_khusus;
            $asesmenNeurologiDischargePlanning->rencana_lama_perawatan = $request->rencana_lama_perawatan;
            $asesmenNeurologiDischargePlanning->rencana_tanggal_pulang = $request->rencana_tanggal_pulang;
            $asesmenNeurologiDischargePlanning->save();

            $vitalSignStore = [
                'sistole'        => (int) $request->darah_sistole ?? null,
                'diastole'       => (int) $request->darah_diastole ?? null,
                'nadi'           => (int)$request->nadi ?? null,
                'respiration'    => (int) $request->respirasi ?? null,
                'suhu'           => (float) $request->suhu ?? null,
            ];

            $this->asesmenService->store(
                $vitalSignStore,
                $kd_pasien,
                $dataMedis->no_transaksi,
                $dataMedis->kd_kasir
            );

            // create resume
            $resumeData = [
                'anamnesis'             => $request->keluhan_utama,
                'diagnosis'             => $allDiagnoses,

                'konpas'                =>
                [
                    'sistole'   => [
                        'hasil' => $vitalSignStore['sistole'] ?? null
                    ],
                    'distole'   => [
                        'hasil' => $vitalSignStore['diastole'] ?? null
                    ],
                    'respiration_rate'   => [
                        'hasil' => $vitalSignStore['respiration'] ?? null
                    ],
                    'suhu'   => [
                        'hasil' => $vitalSignStore['suhu'] ?? null
                    ],
                    'nadi'   => [
                        'hasil' => $vitalSignStore['nadi'] ?? null
                    ]
                ]
            ];

            $this->baseService->updateResumeMedis($dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $resumeData);

            DB::commit();

            return redirect()->route('rawat-inap.asesmen.medis.umum.index', [
                'kd_unit' => request()->route('kd_unit'),
                'kd_pasien' => request()->route('kd_pasien'),
                'tgl_masuk' => request()->route('tgl_masuk'),
                'urut_masuk' => request()->route('urut_masuk'),
            ])->with(['success' => 'Berhasil mengupdate asesmen Neurologi!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function generatePDF($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            // Get assessment data
            $asesmen = RmeAsesmen::with([
                'user',
                'rmeAsesmenNeurologi',
                'rmeAsesmenNeurologiSistemSyaraf',
                'pemeriksaanFisik',
                'rmeAsesmenNeurologiIntensitasNyeri',
                'rmeAsesmenNeurologiDischargePlanning',
            ])->where('id', $id)->first();

            if (!$asesmen) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Data asesmen tidak ditemukan'
                ], 404);
            }

            // Try to get medical record with different formatting of the date
            $tgl_masuk_formatted = date('Y-m-d', strtotime($tgl_masuk));

            $dataMedis = Kunjungan::with('pasien')
                ->where('kd_unit', $kd_unit)
                ->where('kd_pasien', $kd_pasien)
                ->whereDate('tgl_masuk', $tgl_masuk_formatted)
                ->where('urut_masuk', $urut_masuk)
                ->first();

            // If we can't find the data medis, try getting the patient directly
            $pasien = null;
            if (!$dataMedis || !$dataMedis->pasien) {
                $pasien = DB::table('pasien')->where('kd_pasien', $kd_pasien)->first();

                if (!$pasien) {
                    return response()->json([
                        'status'  => 'error',
                        'message' => 'Data pasien tidak ditemukan'
                    ], 404);
                }
            } else {
                $pasien = $dataMedis->pasien;
            }

            // Get physical examination data
            $itemFisikIds = collect();
            if ($asesmen && $asesmen->pemeriksaanFisik) {
                $itemFisikIds = $asesmen->pemeriksaanFisik->pluck('id_item_fisik')->unique();
            }

            $itemFisik = MrItemFisik::whereIn('id', $itemFisikIds)->get()->keyBy('id');

            // Load view and generate PDF
            $pdf = PDF::loadView('unit-pelayanan.rawat-inap.pelayanan.neurologi.print', [
                'asesmen'    => $asesmen,
                'pasien' => $pasien,
                'dataMedis' => $dataMedis,
                'rmeAsesmenNeurologi'                     => optional($asesmen)->rmeAsesmenNeurologi ?? null,
                'rmeAsesmenNeurologiSistemSyaraf'     => optional($asesmen)->rmeAsesmenNeurologiSistemSyaraf ?? null,
                'pemeriksaanFisik'                  => optional($asesmen)->pemeriksaanFisik ?? null,
                'rmeAsesmenNeurologiIntensitasNyeri' => optional($asesmen)->rmeAsesmenNeurologiIntensitasNyeri ?? null,
                'rmeAsesmenNeurologiDischargePlanning'    => optional($asesmen)->rmeAsesmenNeurologiDischargePlanning ?? null,
                'itemFisik' => $itemFisik,
            ]);

            $pdf->setPaper('a4', 'portrait');
            $pdf->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled'      => true,
                'defaultFont'          => 'sans-serif'
            ]);

            return $pdf->stream("asesmen-obstetri-maternitas-{$id}-print-pdf.pdf");
        } catch (\Exception $e) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal generate PDF: ' . $e->getMessage()
            ], 500);
        }
    }

    public function createResume($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $data)
    {
        // get resume
        $resume = RMEResume::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->first();

        $resumeDtlData = [
            'tindak_lanjut_code'    => $data['tindak_lanjut_code'],
            'tindak_lanjut_name'    => $data['tindak_lanjut_name'],
            'tgl_kontrol_ulang'     => $data['tgl_kontrol_ulang'],
            'unit_rujuk_internal'   => $data['unit_rujuk_internal'],
            'rs_rujuk'              => $data['rs_rujuk'],
            'rs_rujuk_bagian'       => $data['rs_rujuk_bagian'],
        ];

        if (empty($resume)) {
            $resumeData = [
                'kd_pasien'     => $kd_pasien,
                'kd_unit'       => $kd_unit,
                'tgl_masuk'     => $tgl_masuk,
                'urut_masuk'    => $urut_masuk,
                'anamnesis'     => $data['anamnesis'],
                'konpas'        => $data['konpas'],
                'diagnosis'     => $data['diagnosis'],
                'status'        => 0
            ];

            $newResume = RMEResume::create($resumeData);
            $newResume->refresh();

            // create resume detail
            $resumeDtlData['id_resume'] = $newResume->id;
            RmeResumeDtl::create($resumeDtlData);
        } else {
            $resume->anamnesis = $data['anamnesis'];
            $resume->konpas = $data['konpas'];
            $resume->diagnosis = $data['diagnosis'];
            $resume->save();

            // get resume dtl
            $resumeDtl = RmeResumeDtl::where('id_resume', $resume->id)->first();
            $resumeDtlData['id_resume'] = $resume->id;

            if (empty($resumeDtl)) {
                RmeResumeDtl::create($resumeDtlData);
            } else {
                $resumeDtl->tindak_lanjut_code  = $data['tindak_lanjut_code'];
                $resumeDtl->tindak_lanjut_name  = $data['tindak_lanjut_name'];
                $resumeDtl->tgl_kontrol_ulang   = $data['tgl_kontrol_ulang'];
                $resumeDtl->unit_rujuk_internal = $data['unit_rujuk_internal'];
                $resumeDtl->rs_rujuk            = $data['rs_rujuk'];
                $resumeDtl->rs_rujuk_bagian     = $data['rs_rujuk_bagian'];
                $resumeDtl->save();
            }
        }
    }
}
