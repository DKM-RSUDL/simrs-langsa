<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Models\Kunjungan;
use App\Models\MrItemFisik;
use App\Models\RmeAlergiPasien;
use App\Models\RmeAsesmen;
use App\Models\RmeAsesmenParu;
use App\Models\RmeAsesmenParuDiagnosisImplementasi;
use App\Models\RmeAsesmenParuPemeriksaanFisik;
use App\Models\RmeAsesmenParuPerencanaanPulang;
use App\Models\RmeAsesmenParuRencanaKerja;
use App\Models\RmeAsesmenPemeriksaanFisik;
use App\Models\RmeMasterDiagnosis;
use App\Models\RmeMasterImplementasi;
use App\Models\RMEResume;
use App\Models\RmeResumeDtl;
use App\Models\SatsetPrognosis;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;

class AsesmenParuController extends Controller
{
    protected $asesmenService;
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
        $this->esmenService = new AsesmenController();
    }

    public function index(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $itemFisik = MrItemFisik::orderby('urut')->get();
        $rmeMasterDiagnosis = RmeMasterDiagnosis::all();
        $rmeMasterImplementasi = RmeMasterImplementasi::all();
        $satsetPrognosis = SatsetPrognosis::all();
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
            ->first();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        return view('unit-pelayanan.rawat-inap.pelayanan.asesmen-paru.create', [
            'kd_unit' => $kd_unit,
            'kd_pasien' => $kd_pasien,
            'tgl_masuk' => $tgl_masuk,
            'urut_masuk' => $urut_masuk,
            'dataMedis' => $dataMedis,
            'itemFisik' => $itemFisik,
            'rmeMasterDiagnosis' => $rmeMasterDiagnosis,
            'rmeMasterImplementasi' => $rmeMasterImplementasi,
            'alergiPasien' => $alergiPasien,
            'satsetPrognosis' => $satsetPrognosis
        ]);
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'gambar_radiologi_paru' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            ]);

            // 1. Buat record RmeAsesmen
            $asesmen = new RmeAsesmen();
            $asesmen->kd_pasien = $request->kd_pasien;
            $asesmen->kd_unit = $request->kd_unit;
            $asesmen->tgl_masuk = $request->tgl_masuk;
            $asesmen->urut_masuk = $request->urut_masuk;
            $asesmen->user_id = Auth::id();
            $asesmen->waktu_asesmen = date('Y-m-d H:i:s');
            $asesmen->kategori = 1;
            $asesmen->sub_kategori = 8;
            $asesmen->save();

            /**
             * 2. Data vital sign untuk disimpan (sesuai pola vital sign)
             * mapping dari request -> array yang akan dikirim ke service
             */
            $vitalSignData = [
                'sistole'       => $request->darah_sistole ? (int) $request->darah_sistole : null,
                'diastole'      => $request->darah_diastole ? (int) $request->darah_diastole : null,
                'nadi'          => $request->nadi ? (int) $request->nadi : null,
                // beberapa form menggunakan pernafasan / frekuensi_pernafasan
                'respiration'   => $request->frekuensi_pernafasan ? (int) $request->frekuensi_pernafasan :
                                    ($request->pernafasan ? (int) $request->pernafasan : null),
                'suhu'          => $request->temperatur ? (float) $request->temperatur : null,
                'spo2_tanpa_o2' => $request->saturasi_oksigen ? (int) $request->saturasi_oksigen : null,
                // optional jika form mengirim tb/bb
                'tinggi_badan'  => $request->tb ? (int) $request->tb : null,
                'berat_badan'   => $request->bb ? (int) $request->bb : null,
            ];

            // 3. Ambil transaksi terakhir untuk pasien
            $lastTransaction = $this->asesmenService->getTransaksiData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

            $noTransaction = $lastTransaction->no_transaksi ?? null;
            $kdKasir = $lastTransaction->kd_kasir ?? null;

            // 4. Simpan vital sign menggunakan service (boleh menerima null jika transaksi tidak ada)
            $this->asesmenService->store($vitalSignData, $kd_pasien, $noTransaction, $kdKasir);

            // 5. Buat record RmeAsesmenParu
            $asesmenParu = new RmeAsesmenParu();
            $asesmenParu->id_asesmen = $asesmen->id;
            $asesmenParu->user_create = Auth::id();
            $asesmenParu->tanggal = $request->tanggal ? Carbon::parse($request->tanggal) : null;
            $asesmenParu->jam_masuk = $request->jam_masuk;
            $asesmenParu->anamnesa = $request->anamnesa;
            $asesmenParu->riwayat_penyakit = $request->riwayat_penyakit;
            $asesmenParu->riwayat_penyakit_terdahulu = $request->riwayat_penyakit_terdahulu;
            $asesmenParu->riwayat_penggunaan_obat = $request->riwayat_penggunaan_obat;
            $asesmenParu->merokok = $request->merokok;
            $asesmenParu->merokok_jumlah = $request->merokok_jumlah;
            $asesmenParu->merokok_lama = $request->merokok_lama;
            $asesmenParu->alkohol = $request->alkohol;
            $asesmenParu->alkohol_jumlah = $request->alkohol_jumlah;
            $asesmenParu->obat_obatan = $request->obat_obatan;
            $asesmenParu->obat_jenis = $request->obat_jenis;
            $asesmenParu->sensorium = $request->sensorium;
            $asesmenParu->keadaan_umum = $request->keadaan_umum;
            $asesmenParu->darah_sistole = $request->darah_sistole;
            $asesmenParu->darah_diastole = $request->darah_diastole;
            $asesmenParu->nadi = $request->nadi;
            $asesmenParu->dyspnoe = $request->dyspnoe;
            $asesmenParu->frekuensi_pernafasan = $request->frekuensi_pernafasan;
            $asesmenParu->pernafasan_tipe = $request->pernafasan_tipe;
            $asesmenParu->cyanose = $request->cyanose;
            $asesmenParu->temperatur = $request->temperatur;
            $asesmenParu->oedema = $request->oedema;
            $asesmenParu->saturasi_oksigen = $request->saturasi_oksigen;
            $asesmenParu->icterus = $request->icterus;
            $asesmenParu->anemia = $request->anemia;
            $asesmenParu->paru_prognosis = $request->paru_prognosis;
            $asesmenParu->site_marking_paru_data = $request->input('site_marking_paru_data');
            $asesmenParu->save();

            // 6. Rencana Kerja
            $asesmenParuRencanaKerja = new RmeAsesmenParuRencanaKerja();
            $asesmenParuRencanaKerja->id_asesmen = $asesmen->id;
            $asesmenParuRencanaKerja->foto_thoraks = $request->has('foto_thoraks') ? 1 : 0;
            $asesmenParuRencanaKerja->darah_rutin = $request->has('darah_rutin') ? 1 : 0;
            $asesmenParuRencanaKerja->led = $request->has('led') ? 1 : 0;
            $asesmenParuRencanaKerja->sputum_bta = $request->has('sputum_bta') ? 1 : 0;
            $asesmenParuRencanaKerja->kgds = $request->has('kgds') ? 1 : 0;
            $asesmenParuRencanaKerja->faal_ginjal = $request->has('faal_ginjal') ? 1 : 0;
            $asesmenParuRencanaKerja->faal_hati = $request->has('faal_hati') ? 1 : 0;
            $asesmenParuRencanaKerja->elektrolit = $request->has('elektrolit') ? 1 : 0;
            $asesmenParuRencanaKerja->albumin = $request->has('albumin') ? 1 : 0;
            $asesmenParuRencanaKerja->asam_urat = $request->has('asam_urat') ? 1 : 0;
            $asesmenParuRencanaKerja->faal_paru = $request->has('faal_paru') ? 1 : 0;
            $asesmenParuRencanaKerja->ct_scan_thoraks = $request->has('ct_scan_thoraks') ? 1 : 0;
            $asesmenParuRencanaKerja->bronchoscopy = $request->has('bronchoscopy') ? 1 : 0;
            $asesmenParuRencanaKerja->proef_punctie = $request->has('proef_punctie') ? 1 : 0;
            $asesmenParuRencanaKerja->aspirasi_cairan_pleura = $request->has('aspirasi_cairan_pleura') ? 1 : 0;
            $asesmenParuRencanaKerja->penanganan_wsd = $request->has('penanganan_wsd') ? 1 : 0;
            $asesmenParuRencanaKerja->biopsi_kelenjar = $request->has('biopsi_kelenjar') ? 1 : 0;
            $asesmenParuRencanaKerja->mantoux_tes = $request->has('mantoux_tes') ? 1 : 0;
            $asesmenParuRencanaKerja->lainnya_check = $request->has('lainnya_check') ? 1 : 0;
            $asesmenParuRencanaKerja->lainnya = $request->lainnya;
            $asesmenParuRencanaKerja->save();

            // 7. Pemeriksaan Fisik Paru (tetap manual seperti sebelumnya)
            $asesmenParuPemeriksaanFisik = new RmeAsesmenParuPemeriksaanFisik();
            $asesmenParuPemeriksaanFisik->id_asesmen = $asesmen->id;
            $asesmenParuPemeriksaanFisik->paru_kepala = $request->paru_kepala;
            $asesmenParuPemeriksaanFisik->paru_kepala_keterangan = $request->paru_kepala_keterangan;
            $asesmenParuPemeriksaanFisik->paru_mata = $request->paru_mata;
            $asesmenParuPemeriksaanFisik->paru_mata_keterangan = $request->paru_mata_keterangan;
            $asesmenParuPemeriksaanFisik->paru_tht = $request->paru_tht;
            $asesmenParuPemeriksaanFisik->paru_tht_keterangan = $request->paru_tht_keterangan;
            $asesmenParuPemeriksaanFisik->paru_leher = $request->paru_leher;
            $asesmenParuPemeriksaanFisik->paru_leher_keterangan = $request->paru_leher_keterangan;
            $asesmenParuPemeriksaanFisik->paru_jantung = $request->paru_jantung;
            $asesmenParuPemeriksaanFisik->paru_jantung_keterangan = $request->paru_jantung_keterangan;
            $asesmenParuPemeriksaanFisik->paru_inspeksi = $request->paru_inspeksi;
            $asesmenParuPemeriksaanFisik->paru_inspeksi_keterangan = $request->paru_inspeksi_keterangan;
            $asesmenParuPemeriksaanFisik->paru_palpasi = $request->paru_palpasi;
            $asesmenParuPemeriksaanFisik->paru_perkusi = $request->paru_perkusi;
            $asesmenParuPemeriksaanFisik->paru_auskultasi = $request->paru_auskultasi;
            $asesmenParuPemeriksaanFisik->paru_suara_pernafasan = $request->paru_suara_pernafasan ?: null;
            $asesmenParuPemeriksaanFisik->paru_suara_tambahan = $request->paru_suara_tambahan ?: null;
            $asesmenParuPemeriksaanFisik->save();

            // 8. Perencanaan pulang
            $asesmenParuPerencanaanPulang = new RmeAsesmenParuPerencanaanPulang();
            $asesmenParuPerencanaanPulang->id_asesmen = $asesmen->id;
            $asesmenParuPerencanaanPulang->diagnosis_medis = $request->diagnosis_medis;
            $asesmenParuPerencanaanPulang->usia_lanjut = $request->usia_lanjut;
            $asesmenParuPerencanaanPulang->hambatan_mobilisasi = $request->hambatan_mobilisasi;
            $asesmenParuPerencanaanPulang->penggunaan_media_berkelanjutan = $request->penggunaan_media_berkelanjutan;
            $asesmenParuPerencanaanPulang->ketergantungan_aktivitas = $request->ketergantungan_aktivitas;
            $asesmenParuPerencanaanPulang->rencana_pulang_khusus = $request->rencana_pulang_khusus;
            $asesmenParuPerencanaanPulang->rencana_lama_perawatan = $request->rencana_lama_perawatan;
            $asesmenParuPerencanaanPulang->rencana_tgl_pulang = $request->rencana_tgl_pulang;
            $asesmenParuPerencanaanPulang->kesimpulan_planing = $request->kesimpulan_planing;
            $asesmenParuPerencanaanPulang->save();

            // 9. Diagnosis & Implementasi Paru
            $paruDiagnosisImplementasi = new RmeAsesmenParuDiagnosisImplementasi();
            $paruDiagnosisImplementasi->id_asesmen = $asesmen->id;
            $paruDiagnosisImplementasi->diagnosis_banding = $request->diagnosis_banding;
            $paruDiagnosisImplementasi->diagnosis_kerja = $request->diagnosis_kerja;
            $paruDiagnosisImplementasi->gambar_radiologi_paru = $request->gambar_radiologi_paru;
            $paruDiagnosisImplementasi->observasi = $request->observasi;
            $paruDiagnosisImplementasi->terapeutik = $request->terapeutik;
            $paruDiagnosisImplementasi->edukasi = $request->edukasi;
            $paruDiagnosisImplementasi->kolaborasi = $request->kolaborasi;
            $paruDiagnosisImplementasi->prognosis = $request->prognosis;

            // Array untuk menyimpan path file yang berhasil diupload
            $uploadedFiles = [];

            // Fungsi helper untuk upload file
            $uploadFile = function ($fieldName) use ($request, &$uploadedFiles, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk) {
                if ($request->hasFile($fieldName)) {
                    try {
                        $file = $request->file($fieldName);
                        $path = $file->store("uploads/ranap/asesmen-paru/$kd_unit/$kd_pasien/$tgl_masuk/$urut_masuk");

                        if ($path) {
                            return $path;
                        }
                    } catch (\Exception $e) {
                        throw new \Exception("Gagal mengupload file {$fieldName}");
                    }
                }
                return null;
            };

            // Upload files (tetap seperti sebelumnya)
            $paruDiagnosisImplementasi->gambar_radiologi_paru = $uploadFile('gambar_radiologi_paru');

            $paruDiagnosisImplementasi->save();

            // 10. Validasi dan simpan data alergi
            $alergiData = json_decode($request->alergis ?? '[]', true) ?? [];

            if (!empty($alergiData)) {
                // Hapus data alergi lama untuk pasien ini
                RmeAlergiPasien::where('kd_pasien', $kd_pasien)->delete();

                // Simpan data alergi baru
                foreach ($alergiData as $alergi) {
                    RmeAlergiPasien::create([
                        'kd_pasien' => $kd_pasien,
                        'jenis_alergi' => $alergi['jenis_alergi'] ?? null,
                        'nama_alergi' => $alergi['alergen'] ?? null,
                        'reaksi' => $alergi['reaksi'] ?? null,
                        'tingkat_keparahan' => $alergi['tingkat_keparahan'] ?? null
                    ]);
                }
            }

            // 11. Simpan ke table RmePemeriksaanFisik (item fisik umum)
            $itemFisik = MrItemFisik::all();
            foreach ($itemFisik as $item) {
                $isNormal = $request->has($item->id . '-normal') ? 1 : 0;
                $keterangan = $request->input($item->id . '_keterangan');

                // Jika normal, hapus keterangan
                if ($isNormal) {
                    $keterangan = '';
                }

                RmeAsesmenPemeriksaanFisik::create([
                    'id_asesmen' => $asesmen->id,
                    'id_item_fisik' => $item->id,
                    'is_normal' => $isNormal,
                    'keterangan' => $keterangan
                ]);
            }

            // 12. Simpan diagnosis ke Master (banding + kerja)
            $diagnosisBandingList = json_decode($request->diagnosis_banding ?? '[]', true) ?? [];
            $diagnosisKerjaList = json_decode($request->diagnosis_kerja ?? '[]', true) ?? [];
            $allDiagnoses = array_merge($diagnosisBandingList, $diagnosisKerjaList);

            foreach ($allDiagnoses as $diagnosa) {
                if (empty($diagnosa)) continue;
                $existingDiagnosa = RmeMasterDiagnosis::where('nama_diagnosis', $diagnosa)->first();
                if (!$existingDiagnosa) {
                    RmeMasterDiagnosis::create([
                        'nama_diagnosis' => $diagnosa
                    ]);
                }
            }

            // 13. Fungsi helper untuk menyimpan implementasi (closure)
            $saveToColumn = function ($dataList, $column) {
                $dataList = $dataList ?? [];
                foreach ($dataList as $item) {
                    if (empty($item)) continue;
                    $existingImplementasi = RmeMasterImplementasi::where($column, $item)->first();
                    if (!$existingImplementasi) {
                        RmeMasterImplementasi::create([
                            $column => $item
                        ]);
                    }
                }
            };

            // Simpan implementasi
            $rppList = json_decode($request->prognosis ?? '[]', true) ?? [];
            $observasiList = json_decode($request->observasi ?? '[]', true) ?? [];
            $terapeutikList = json_decode($request->terapeutik ?? '[]', true) ?? [];
            $edukasiList = json_decode($request->edukasi ?? '[]', true) ?? [];
            $kolaborasiList = json_decode($request->kolaborasi ?? '[]', true) ?? [];

            $saveToColumn($rppList, 'prognosis');
            $saveToColumn($observasiList, 'observasi');
            $saveToColumn($terapeutikList, 'terapeutik');
            $saveToColumn($edukasiList, 'edukasi');
            $saveToColumn($kolaborasiList, 'kolaborasi');

            // 14. RESUME (masukkan hasil vital sign ke resume juga)
            $resumeData = [
                'anamnesis'             => $request->anamnesa,
                'diagnosis'             => [],
                'tindak_lanjut_code'    => null,
                'tindak_lanjut_name'    => null,
                'tgl_kontrol_ulang'     => null,
                'unit_rujuk_internal'   => null,
                'rs_rujuk'              => null,
                'rs_rujuk_bagian'       => null,
                'konpas'                => [
                    'sistole'   => [
                        'hasil' => $request->darah_sistole
                    ],
                    'distole'   => [
                        'hasil' => $request->darah_diastole
                    ],
                    'respiration_rate'   => [
                        'hasil' => $request->frekuensi_pernafasan ?? $request->pernafasan ?? ''
                    ],
                    'suhu'   => [
                        'hasil' => $request->temperatur
                    ],
                    'nadi'   => [
                        'hasil' => $request->nadi
                    ],
                    'tinggi_badan'   => [
                        'hasil' => $request->tb ?? ''
                    ],
                    'berat_badan'   => [
                        'hasil' => $request->bb ?? ''
                    ],
                    'spo2' => [
                        'hasil' => $request->saturasi_oksigen ?? ''
                    ]
                ]
            ];

            $this->createResume($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $resumeData);

            DB::commit();

            return redirect()->route('rawat-inap.asesmen.medis.umum.index', [
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk
            ])->with('success', 'Data berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }


    public function show($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            // Ambil data asesmen beserta relasinya
            $asesmen = RmeAsesmen::with([
                'user',
                'rmeAsesmenParu',
                'rmeAsesmenParuRencanaKerja',
                'rmeAsesmenParuPerencanaanPulang',
                'rmeAsesmenParuDiagnosisImplementasi',
                'rmeAlergiPasien',
                'rmeAsesmenParuPemeriksaanFisik',
                'pemeriksaanFisik' => function ($query) {
                    $query->orderBy('id_item_fisik');
                },
            ])->findOrFail($id);

            $dataMedis = Kunjungan::with('pasien')
                ->where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->firstOrFail();

            $itemFisik = MrItemFisik::orderBy('urut')->get();
            $satsetPrognosis = SatsetPrognosis::all();

            return view('unit-pelayanan.rawat-inap.pelayanan.asesmen-paru.show', compact(
                'asesmen',
                'dataMedis',
                'itemFisik',
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
            // Ambil data asesmen beserta relasinya
            $asesmen = RmeAsesmen::with([
                'user',
                'rmeAsesmenParu',
                'rmeAsesmenParuRencanaKerja',
                'rmeAsesmenParuPerencanaanPulang',
                'rmeAsesmenParuDiagnosisImplementasi',
                'rmeAlergiPasien',
                'rmeAsesmenParuPemeriksaanFisik',
                'pemeriksaanFisik' => function ($query) {
                    $query->orderBy('id_item_fisik');
                },
            ])->findOrFail($id);

            $dataMedis = Kunjungan::with('pasien')
                ->where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->firstOrFail();

            $itemFisik = MrItemFisik::orderBy('urut')->get();
            $rmeMasterDiagnosis = RmeMasterDiagnosis::all();
            $rmeMasterImplementasi = RmeMasterImplementasi::all();
            $satsetPrognosis = SatsetPrognosis::all();
            $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();

            // **TAMBAHAN: Ambil data site marking paru**
            $siteMarkingParuData = '';
            if ($asesmen && $asesmen->rmeAsesmenParu && $asesmen->rmeAsesmenParu->site_marking_paru_data) {
                $siteMarkingParuData = $asesmen->rmeAsesmenParu->site_marking_paru_data;
            }

            return view('unit-pelayanan.rawat-inap.pelayanan.asesmen-paru.edit', compact(
                'asesmen',
                'dataMedis',
                'itemFisik',
                'rmeMasterDiagnosis',
                'rmeMasterImplementasi',
                'alergiPasien',
                'satsetPrognosis',
                'siteMarkingParuData' // **TAMBAHAN: Kirim ke view**
            ));
        } catch (ModelNotFoundException $e) {
            return back()->with('error', 'Data tidak ditemukan. Detail: ' . $e->getMessage());
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'gambar_radiologi_paru' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            ]);

            

            // 1. Buat record RmeAsesmen
            $asesmen = RmeAsesmen::findOrFail($id);
            $asesmen->kd_pasien = $request->kd_pasien;
            $asesmen->kd_unit = $request->kd_unit;
            $asesmen->tgl_masuk = $request->tgl_masuk;
            $asesmen->urut_masuk = $request->urut_masuk;
            $asesmen->user_id = Auth::id();
            $asesmen->waktu_asesmen = $request->tanggal . ' ' . $request->jam_masuk;
            $asesmen->kategori = 1;
            $asesmen->sub_kategori = 8;
            $asesmen->save();

            // 2. Buat record RmeAsesmenParu
            $asesmenParu = RmeAsesmenParu::firstOrNew(['id_asesmen' => $asesmen->id]);
            $asesmenParu->id_asesmen = $asesmen->id;
            $asesmenParu->user_edit = Auth::id();
            $asesmenParu->tanggal = Carbon::parse($request->tanggal);
            $asesmenParu->jam_masuk = $request->jam_masuk;
            $asesmenParu->anamnesa = $request->anamnesa;
            $asesmenParu->riwayat_penyakit = $request->riwayat_penyakit;
            $asesmenParu->riwayat_penyakit_terdahulu = $request->riwayat_penyakit_terdahulu;
            $asesmenParu->riwayat_penggunaan_obat = $request->riwayat_penggunaan_obat;
            $asesmenParu->merokok = $request->merokok;
            $asesmenParu->merokok_jumlah = $request->merokok_jumlah;
            $asesmenParu->merokok_lama = $request->merokok_lama;
            $asesmenParu->alkohol = $request->alkohol;
            $asesmenParu->alkohol_jumlah = $request->alkohol_jumlah;
            $asesmenParu->obat_obatan = $request->obat_obatan;
            $asesmenParu->obat_jenis = $request->obat_jenis;
            $asesmenParu->sensorium = $request->sensorium;
            $asesmenParu->keadaan_umum = $request->keadaan_umum;
            $asesmenParu->darah_sistole = $request->darah_sistole;
            $asesmenParu->darah_diastole = $request->darah_diastole;
            $asesmenParu->nadi = $request->nadi;
            $asesmenParu->dyspnoe = $request->dyspnoe;
            $asesmenParu->frekuensi_pernafasan = $request->frekuensi_pernafasan;
            $asesmenParu->pernafasan_tipe = $request->pernafasan_tipe;
            $asesmenParu->cyanose = $request->cyanose;
            $asesmenParu->temperatur = $request->temperatur;
            $asesmenParu->oedema = $request->oedema;
            $asesmenParu->saturasi_oksigen = $request->saturasi_oksigen;
            $asesmenParu->icterus = $request->icterus;
            $asesmenParu->anemia = $request->anemia;
            $asesmenParu->site_marking_paru_data = $request->input('site_marking_paru_data');
            $asesmenParu->paru_prognosis = $request->paru_prognosis;
            $asesmenParu->save();

            // 3-5. Records lainnya tetap sama...
            $asesmenParuRencanaKerja = RmeAsesmenParuRencanaKerja::firstOrNew(['id_asesmen' => $asesmen->id]);
            $asesmenParuRencanaKerja->id_asesmen = $asesmen->id;
            $asesmenParuRencanaKerja->foto_thoraks = $request->has('foto_thoraks') ? 1 : 0;
            $asesmenParuRencanaKerja->darah_rutin = $request->has('darah_rutin') ? 1 : 0;
            $asesmenParuRencanaKerja->led = $request->has('led') ? 1 : 0;
            $asesmenParuRencanaKerja->sputum_bta = $request->has('sputum_bta') ? 1 : 0;
            $asesmenParuRencanaKerja->kgds = $request->has('kgds') ? 1 : 0;
            $asesmenParuRencanaKerja->faal_ginjal = $request->has('faal_ginjal') ? 1 : 0;
            $asesmenParuRencanaKerja->faal_hati = $request->has('faal_hati') ? 1 : 0;
            $asesmenParuRencanaKerja->elektrolit = $request->has('elektrolit') ? 1 : 0;
            $asesmenParuRencanaKerja->albumin = $request->has('albumin') ? 1 : 0;
            $asesmenParuRencanaKerja->asam_urat = $request->has('asam_urat') ? 1 : 0;
            $asesmenParuRencanaKerja->faal_paru = $request->has('faal_paru') ? 1 : 0;
            $asesmenParuRencanaKerja->ct_scan_thoraks = $request->has('ct_scan_thoraks') ? 1 : 0;
            $asesmenParuRencanaKerja->bronchoscopy = $request->has('bronchoscopy') ? 1 : 0;
            $asesmenParuRencanaKerja->proef_punctie = $request->has('proef_punctie') ? 1 : 0;
            $asesmenParuRencanaKerja->aspirasi_cairan_pleura = $request->has('aspirasi_cairan_pleura') ? 1 : 0;
            $asesmenParuRencanaKerja->penanganan_wsd = $request->has('penanganan_wsd') ? 1 : 0;
            $asesmenParuRencanaKerja->biopsi_kelenjar = $request->has('biopsi_kelenjar') ? 1 : 0;
            $asesmenParuRencanaKerja->mantoux_tes = $request->has('mantoux_tes') ? 1 : 0;
            $asesmenParuRencanaKerja->lainnya_check = $request->has('lainnya_check') ? 1 : 0;
            $asesmenParuRencanaKerja->lainnya = $request->lainnya;
            $asesmenParuRencanaKerja->save();

            // Perbaikan Controller untuk Asesmen Paru Pemeriksaan Fisik
            $asesmenParuPemeriksaanFisik = RmeAsesmenParuPemeriksaanFisik::firstOrNew(['id_asesmen' => $asesmen->id]);
            $asesmenParuPemeriksaanFisik->id_asesmen = $asesmen->id;
            $asesmenParuPemeriksaanFisik->paru_kepala = $request->paru_kepala;
            $asesmenParuPemeriksaanFisik->paru_kepala_keterangan = $request->paru_kepala_keterangan;
            $asesmenParuPemeriksaanFisik->paru_mata = $request->paru_mata;
            $asesmenParuPemeriksaanFisik->paru_mata_keterangan = $request->paru_mata_keterangan;
            $asesmenParuPemeriksaanFisik->paru_tht = $request->paru_tht;
            $asesmenParuPemeriksaanFisik->paru_tht_keterangan = $request->paru_tht_keterangan;
            $asesmenParuPemeriksaanFisik->paru_leher = $request->paru_leher;
            $asesmenParuPemeriksaanFisik->paru_leher_keterangan = $request->paru_leher_keterangan;
            $asesmenParuPemeriksaanFisik->paru_jantung = $request->paru_jantung;
            $asesmenParuPemeriksaanFisik->paru_jantung_keterangan = $request->paru_jantung_keterangan;
            $asesmenParuPemeriksaanFisik->paru_inspeksi = $request->paru_inspeksi;
            $asesmenParuPemeriksaanFisik->paru_inspeksi_keterangan = $request->paru_inspeksi_keterangan;
            $asesmenParuPemeriksaanFisik->paru_palpasi = $request->paru_palpasi;
            $asesmenParuPemeriksaanFisik->paru_perkusi = $request->paru_perkusi;
            $asesmenParuPemeriksaanFisik->paru_auskultasi = $request->paru_auskultasi;

            $asesmenParuPemeriksaanFisik->paru_suara_pernafasan = $request->paru_suara_pernafasan ?: null;
            $asesmenParuPemeriksaanFisik->paru_suara_tambahan = $request->paru_suara_tambahan ?: null;

            $asesmenParuPemeriksaanFisik->save();

            $asesmenParuPerencanaanPulang = RmeAsesmenParuPerencanaanPulang::firstOrNew(['id_asesmen' => $asesmen->id]);
            $asesmenParuPerencanaanPulang->id_asesmen = $asesmen->id;
            $asesmenParuPerencanaanPulang->diagnosis_medis = $request->diagnosis_medis;
            $asesmenParuPerencanaanPulang->usia_lanjut = $request->usia_lanjut;
            $asesmenParuPerencanaanPulang->hambatan_mobilisasi = $request->hambatan_mobilisasi;
            $asesmenParuPerencanaanPulang->penggunaan_media_berkelanjutan = $request->penggunaan_media_berkelanjutan;
            $asesmenParuPerencanaanPulang->ketergantungan_aktivitas = $request->ketergantungan_aktivitas;
            $asesmenParuPerencanaanPulang->rencana_pulang_khusus = $request->rencana_pulang_khusus;
            $asesmenParuPerencanaanPulang->rencana_lama_perawatan = $request->rencana_lama_perawatan;
            $asesmenParuPerencanaanPulang->rencana_tgl_pulang = $request->rencana_tgl_pulang;
            $asesmenParuPerencanaanPulang->kesimpulan_planing = $request->kesimpulan_planing;
            $asesmenParuPerencanaanPulang->save();

            $paruDiagnosisImplementasi = RmeAsesmenParuDiagnosisImplementasi::firstOrNew(['id_asesmen' => $asesmen->id]);
            $paruDiagnosisImplementasi->id_asesmen = $asesmen->id;
            $paruDiagnosisImplementasi->diagnosis_banding = $request->diagnosis_banding;
            $paruDiagnosisImplementasi->diagnosis_kerja = $request->diagnosis_kerja;
            $paruDiagnosisImplementasi->gambar_radiologi_paru = $request->gambar_radiologi_paru;
            $paruDiagnosisImplementasi->observasi = $request->observasi;
            $paruDiagnosisImplementasi->terapeutik = $request->terapeutik;
            $paruDiagnosisImplementasi->edukasi = $request->edukasi;
            $paruDiagnosisImplementasi->kolaborasi = $request->kolaborasi;
            $paruDiagnosisImplementasi->prognosis = $request->prognosis;

            $fileFields = [
                'gambar_radiologi_paru',
            ];

            // Array untuk menyimpan path file yang berhasil diupload
            $uploadedFiles = [];

            // Fungsi helper untuk upload file
            $uploadFile = function ($fieldName) use ($request, &$uploadedFiles, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk) {
                if ($request->hasFile($fieldName)) {
                    try {
                        $file = $request->file($fieldName);
                        $path = $file->store("uploads/ranap/asesmen-paru/$kd_unit/$kd_pasien/$tgl_masuk/$urut_masuk");

                        if ($path) {
                            return $path;
                        }
                    } catch (\Exception $e) {
                        throw new \Exception("Gagal mengupload file {$fieldName}");
                    }
                }
                return null;
            };

            $fileFields = [
                'gambar_radiologi_paru',
            ];

            foreach ($fileFields as $field) {
                if ($request->has("delete_$field")) {
                    if ($paruDiagnosisImplementasi->$field) {
                        Storage::disk('public')->delete(
                            "uploads/ranap/asesmen-paru/$kd_unit/$kd_pasien/$tgl_masuk/$urut_masuk/" . $paruDiagnosisImplementasi->$field
                        );
                        $paruDiagnosisImplementasi->$field = null;
                    }
                } elseif ($request->hasFile($field)) {
                    try {
                        if ($paruDiagnosisImplementasi->$field) {
                            Storage::disk('public')->delete(
                                "uploads/ranap/asesmen-paru/$kd_unit/$kd_pasien/$tgl_masuk/$urut_masuk/" . $paruDiagnosisImplementasi->$field
                            );
                        }

                        $path = $uploadFile($field);
                        if ($path) {
                            $paruDiagnosisImplementasi->$field = basename($path);
                            $uploadedFiles[$field] = $path;
                        }
                    } catch (\Exception $e) {
                        throw new \Exception("Gagal mengupload file $field: " . $e->getMessage());
                    }
                }
            }
            $paruDiagnosisImplementasi->save();

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
            } else {
                // Jika tidak ada data alergi baru, hapus yang lama
                RmeAlergiPasien::where('kd_pasien', $kd_pasien)->delete();
            }

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

            DB::commit();

            return redirect()->route('rawat-inap.asesmen.medis.umum.index', [
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk
            ])->with('success', 'Data berhasil disimpan');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function generatePDF($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            $asesmen = RmeAsesmen::with([
                'user',
                'rmeAsesmenParu',
                'rmeAsesmenParuRencanaKerja',
                'rmeAsesmenParuPerencanaanPulang',
                'rmeAsesmenParuDiagnosisImplementasi',
                'rmeAlergiPasien',
                'pemeriksaanFisik' => function ($query) {
                    $query->orderBy('id_item_fisik');
                },
            ])->findOrFail($id);

            $dataMedis = Kunjungan::with('pasien')
                ->where('kd_unit', $kd_unit)
                ->where('kd_pasien', $kd_pasien)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->first();

            $pdf = PDF::loadView('unit-pelayanan.rawat-inap.pelayanan.asesmen-paru.print', [
                'asesmen'    => $asesmen ?? null,
                'pasien' => optional($dataMedis)->pasien ?? null,
                'dataMedis' => $dataMedis ?? null,
                // variabel lainnya sesuai kebutuhan
                'rmeAsesmenParu' => optional($asesmen)->rmeAsesmenParu ?? null,
                'rmeAsesmenParuRencanaKerja' => optional($asesmen)->rmeAsesmenParuRencanaKerja ?? null,
                'rmeAsesmenParuPerencanaanPulang' => optional($asesmen)->rmeAsesmenParuPerencanaanPulang ?? null,
                'rmeAsesmenParuDiagnosisImplementasi' => optional($asesmen)->rmeAsesmenParuDiagnosisImplementasi ?? null,
                'pemeriksaanFisik' => optional($asesmen)->pemeriksaanFisik ?? null,
            ]);

            $pdf->setPaper('a4', 'portrait');
            $pdf->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled'      => true,
                'defaultFont'          => 'sans-serif'
            ]);

            return $pdf->stream("asesmen-paru-{$id}-print-pdf.pdf");
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
