<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\MrItemFisik;
use App\Models\RmeAlergiPasien;
use App\Models\RmeAsesmen;
use App\Models\RmeAsesmenKulitKelamin;
use App\Models\RmeAsesmenKulitKelaminRencanaPulang;
use App\Models\RmeAsesmenPemeriksaanFisik;
use App\Models\RmeEfekNyeri;
use App\Models\RmeFaktorPemberat;
use App\Models\RmeFaktorPeringan;
use App\Models\RmeFrekuensiNyeri;
use App\Models\RmeJenisNyeri;
use App\Models\RmeKualitasNyeri;
use App\Models\RmeMasterDiagnosis;
use App\Models\RmeMasterImplementasi;
use App\Models\RmeMenjalar;
use App\Models\SatsetPrognosis;
use App\Services\AsesmenService;
use App\Services\BaseService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AsesmenKulitKelaminController extends Controller
{
    protected $asesmenService;

    private $baseService;

    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
        $this->asesmenService = new AsesmenService;
        $this->baseService = new BaseService;
    }

    public function index(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $user = auth()->user();
        $itemFisik = MrItemFisik::orderby('urut')->get();
        $menjalar = RmeMenjalar::all();
        $frekuensinyeri = RmeFrekuensiNyeri::all();
        $kualitasnyeri = RmeKualitasNyeri::all();
        $faktorpemberat = RmeFaktorPemberat::all();
        $faktorperingan = RmeFaktorPeringan::all();
        $efeknyeri = RmeEfekNyeri::all();
        $jenisnyeri = RmeJenisNyeri::all();
        $rmeMasterDiagnosis = RmeMasterDiagnosis::all();
        $rmeMasterImplementasi = RmeMasterImplementasi::all();
        $satsetPrognosis = SatsetPrognosis::all();
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

        if (! $dataMedis) {
            abort(404, 'Data not found');
        }

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        $dataMedis->waktu_masuk = Carbon::parse($dataMedis->TGL_MASUK.' '.$dataMedis->JAM_MASUK)->format('Y-m-d H:i:s');
        // Get latest vital signs data for the patient
        $vitalSignsData = $this->asesmenService->getLatestVitalSignsByPatient($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

        return view('unit-pelayanan.rawat-inap.pelayanan.asesmen-kulitkelamin.create', compact(
            'kd_unit',
            'kd_pasien',
            'tgl_masuk',
            'urut_masuk',
            'dataMedis',
            'itemFisik',
            'menjalar',
            'frekuensinyeri',
            'kualitasnyeri',
            'faktorpemberat',
            'faktorperingan',
            'efeknyeri',
            'jenisnyeri',
            'rmeMasterDiagnosis',
            'rmeMasterImplementasi',
            'alergiPasien',
            'satsetPrognosis',
            'user',
            'vitalSignsData'
        ));
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        DB::beginTransaction();

        try {
            $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
            if (empty($dataMedis)) {
                throw new Exception('Data kunjungan tidak ditemukan');
            }

            // Prepare assessment time
            $tanggal = $request->tanggal_masuk;
            $jam = $request->jam_masuk;
            $waktu_asesmen = $tanggal.' '.$jam;

            // Ambil tanggal dan jam dari form
            $formatDate = date('Y-m-d', strtotime($request->tanggal_masuk));
            $formatTime = date('H:i:s', strtotime($request->jam_masuk));

            // Save core assessment data
            $dataAsesmen = new RmeAsesmen;
            $dataAsesmen->kd_pasien = $dataMedis->kd_pasien;
            $dataAsesmen->kd_unit = $dataMedis->kd_unit;
            $dataAsesmen->tgl_masuk = $dataMedis->tgl_masuk;
            $dataAsesmen->urut_masuk = $dataMedis->urut_masuk;
            $dataAsesmen->user_id = Auth::id();
            $dataAsesmen->waktu_asesmen = "$formatDate $formatTime";
            $dataAsesmen->kategori = 1;
            $dataAsesmen->sub_kategori = 10; // Specific to dermatology/venereology
            $dataAsesmen->anamnesis = $request->anamnesis;
            $dataAsesmen->save();

            // Prepare vital sign data
            $vitalSignData = [
                'sistole' => $request->tekanan_darah_sistole ? (int) $request->tekanan_darah_sistole : null,
                'diastole' => $request->tekanan_darah_diastole ? (int) $request->tekanan_darah_diastole : null,
                'nadi' => $request->nadi ? (int) $request->nadi : null,
                'respiration' => $request->respirasi ? (int) $request->respirasi : null,
                'suhu' => $request->suhu ? (float) $request->suhu : null,
            ];

            $dataKulitKelamin = new RmeAsesmenKulitKelamin;
            $dataKulitKelamin->id_asesmen = $dataAsesmen->id;
            $dataKulitKelamin->waktu_masuk = $waktu_asesmen;
            $dataKulitKelamin->diagnosis_masuk = $request->diagnosis_masuk;
            $dataKulitKelamin->kondisi_masuk = $request->kondisi_masuk;
            $dataKulitKelamin->keluhan_utama = $request->keluhan_utama;
            $dataKulitKelamin->riwayat_penyakit_sekarang = $request->riwayat_penyakit_sekarang;
            $dataKulitKelamin->riwayat_penyakit_terdahulu = $request->riwayat_penyakit_terdahulu;
            $dataKulitKelamin->riwayat_penyakit_keluarga = $request->riwayat_kesehatan_keluarga;
            $dataKulitKelamin->riwayat_penggunaan_obat = $request->riwayat_penggunaan_obat;
            $dataKulitKelamin->diagnosis_banding = $request->diagnosis_banding;
            $dataKulitKelamin->diagnosis_kerja = $request->diagnosis_kerja;
            $dataKulitKelamin->prognosis = $request->prognosis;
            $dataKulitKelamin->observasi = $request->observasi;
            $dataKulitKelamin->terapeutik = $request->terapeutik;
            $dataKulitKelamin->edukasi = $request->edukasi;
            $dataKulitKelamin->kolaborasi = $request->kolaborasi;
            $dataKulitKelamin->sensorium = $request->sensorium;
            $dataKulitKelamin->tekanan_darah_sistole = $request->tekanan_darah_sistole;
            $dataKulitKelamin->tekanan_darah_diastole = $request->tekanan_darah_diastole;
            $dataKulitKelamin->suhu = $request->suhu;
            $dataKulitKelamin->respirasi = $request->respirasi;
            $dataKulitKelamin->nadi = $request->nadi;
            $dataKulitKelamin->site_marking_data = $request->site_marking_data;
            $dataKulitKelamin->rencana_pengobatan = $request->rencana_pengobatan;
            $dataKulitKelamin->save();

            // Save vital signs using service
            $this->asesmenService->store($vitalSignData, $kd_pasien, $dataMedis->no_transaksi, $dataMedis->kd_kasir);

            // Save dermatology/venereology-specific assessment data with vital signs
            $dataKulitKelamin = new RmeAsesmenKulitKelamin;
            $dataKulitKelamin->id_asesmen = $dataAsesmen->id;
            $dataKulitKelamin->waktu_masuk = $waktu_asesmen;
            $dataKulitKelamin->diagnosis_masuk = $request->diagnosis_masuk;
            $dataKulitKelamin->kondisi_masuk = $request->kondisi_masuk;
            $dataKulitKelamin->keluhan_utama = $request->keluhan_utama;
            $dataKulitKelamin->tekanan_darah_sistole = $vitalSignData['sistole'];
            $dataKulitKelamin->tekanan_darah_diastole = $vitalSignData['diastole'];
            $dataKulitKelamin->nadi = $vitalSignData['nadi'];
            $dataKulitKelamin->respirasi = $vitalSignData['respiration'];
            $dataKulitKelamin->suhu = $vitalSignData['suhu'];
            $dataKulitKelamin->save();

            // Validasi data alergi
            $alergiData = json_decode($request->alergis, true);

            if (! empty($alergiData)) {
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
                        'tingkat_keparahan' => $alergi['tingkat_keparahan'],
                    ]);
                }
            }

            // Simpan ke table RmeAsesmenRencanaPulang
            $asesmenRencana = new RmeAsesmenKulitKelaminRencanaPulang;
            $asesmenRencana->id_asesmen = $dataAsesmen->id;
            $asesmenRencana->diagnosis_medis = $request->diagnosis_medis;
            $asesmenRencana->usia_lanjut = $request->usia_lanjut;
            $asesmenRencana->hambatan_mobilisasi = $request->hambatan_mobilisasi;
            $asesmenRencana->membutuhkan_pelayanan_medis = $request->penggunaan_media_berkelanjutan;
            $asesmenRencana->memerlukan_keterampilan_khusus = $request->keterampilan_khusus;
            $asesmenRencana->memerlukan_alat_bantu = $request->alat_bantu;
            $asesmenRencana->memiliki_nyeri_kronis = $request->nyeri_kronis;
            $asesmenRencana->perkiraan_lama_dirawat = $request->perkiraan_hari;
            $asesmenRencana->rencana_pulang = $request->tanggal_pulang;
            $asesmenRencana->kesimpulan = $request->kesimpulan_planing;
            $asesmenRencana->save();

            // Simpan Diagnosa ke Master
            $diagnosisBandingList = json_decode($request->diagnosis_banding ?? '[]', true);
            $diagnosisKerjaList = json_decode($request->diagnosis_kerja ?? '[]', true);
            $allDiagnoses = array_merge($diagnosisBandingList, $diagnosisKerjaList);

            // create resume
            $resumeData = [
                'anamnesis' => $request->anamnesis,
                'diagnosis' => $allDiagnoses,

                'konpas' => [
                    'sistole' => [
                        'hasil' => $vitalSignData['sistole'] ?? null,
                    ],
                    'distole' => [
                        'hasil' => $vitalSignData['diastole'] ?? null,
                    ],
                    'respiration_rate' => [
                        'hasil' => $vitalSignData['respiration'] ?? null,
                    ],
                    'suhu' => [
                        'hasil' => $vitalSignData['suhu'] ?? null,
                    ],
                    'nadi' => [
                        'hasil' => $vitalSignData['nadi'] ?? null,
                    ],
                ],
            ];

            $this->baseService->updateResumeMedis($dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $resumeData);

            DB::commit();

            return redirect()->to(url("unit-pelayanan/rawat-inap/unit/$kd_unit/pelayanan/$kd_pasien/$tgl_masuk/$urut_masuk/asesmen/medis/umum"))
                ->with('success', 'Data asesmen anak berhasil disimpan');
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Gagal menyimpan data asesmen'.$e->getMessage());
        }
    }

    public function show($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id, $print = false)
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
            ->where('kunjungan.kd_unit', $kd_unit)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();

        if (! $dataMedis) {
            abort(404, 'Data not found');
        }

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        $dataMedis->waktu_masuk = Carbon::parse($dataMedis->TGL_MASUK.' '.$dataMedis->JAM_MASUK)->format('Y-m-d H:i:s');

        $satsetPrognosis = SatsetPrognosis::all();

        // Ambil data asesmen
        $asesmen = RmeAsesmen::where('id', $id) // Gunakan ID spesifik
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->where('kategori', 1)
            ->where('sub_kategori', 10)
            ->first();

        if (! $asesmen) {
            return redirect()->back()->with('error', 'Data asesmen tidak ditemukan');
        }

        // Ambil data detail asesmen kulit kelamin
        $asesmenKulitKelamin = RmeAsesmenKulitKelamin::where('id_asesmen', $asesmen->id)->first();

        if (! $asesmenKulitKelamin) {
            return redirect()->back()->with('error', 'Data asesmen kulit kelamin tidak ditemukan');
        }

        // Ambil data pemeriksaan fisik
        $pemeriksaanFisik = RmeAsesmenPemeriksaanFisik::with('itemFisik')
            ->where('id_asesmen', $asesmen->id)
            ->get()
            ->keyBy('id_item_fisik');

        // Ambil data alergi pasien
        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();

        // Ambil data rencana pulang
        $rencanaPulang = RmeAsesmenKulitKelaminRencanaPulang::where('id_asesmen', $asesmen->id)->first();

        // Ambil semua item fisik untuk referensi
        $itemFisik = MrItemFisik::orderby('urut')->get();

        $siteMarkingData = json_decode($asesmenKulitKelamin->site_marking_data ?? '[]', true);

        // Decode JSON data
        $diagnosisBanding = json_decode($asesmenKulitKelamin->diagnosis_banding ?? '[]', true);
        $diagnosisKerja = json_decode($asesmenKulitKelamin->diagnosis_kerja ?? '[]', true);
        $observasi = json_decode($asesmenKulitKelamin->observasi ?? '[]', true);
        $terapeutik = json_decode($asesmenKulitKelamin->terapeutik ?? '[]', true);
        $edukasi = json_decode($asesmenKulitKelamin->edukasi ?? '[]', true);
        $kolaborasi = json_decode($asesmenKulitKelamin->kolaborasi ?? '[]', true);
        $riwayatPenggunaanObat = json_decode($asesmenKulitKelamin->riwayat_penggunaan_obat ?? '[]', true);
        $riwayatKesehatanKeluarga = json_decode($asesmenKulitKelamin->riwayat_penyakit_keluarga ?? '[]', true);

        $data = compact(
            'kd_unit',
            'kd_pasien',
            'tgl_masuk',
            'urut_masuk',
            'dataMedis',
            'asesmen',
            'asesmenKulitKelamin',
            'pemeriksaanFisik',
            'alergiPasien',
            'rencanaPulang',
            'itemFisik',
            'diagnosisBanding',
            'diagnosisKerja',
            'observasi',
            'terapeutik',
            'edukasi',
            'kolaborasi',
            'satsetPrognosis',
            'riwayatPenggunaanObat',
            'riwayatKesehatanKeluarga',
            'siteMarkingData',
            'user'
        );

        if ($print) {
            return $data;
        }

        return view('unit-pelayanan.rawat-inap.pelayanan.asesmen-kulitkelamin.show', $data);
    }

    public function edit($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $user = auth()->user();
        $itemFisik = MrItemFisik::orderby('urut')->get();
        $menjalar = RmeMenjalar::all();
        $frekuensinyeri = RmeFrekuensiNyeri::all();
        $kualitasnyeri = RmeKualitasNyeri::all();
        $faktorpemberat = RmeFaktorPemberat::all();
        $faktorperingan = RmeFaktorPeringan::all();
        $efeknyeri = RmeEfekNyeri::all();
        $jenisnyeri = RmeJenisNyeri::all();
        $rmeMasterDiagnosis = RmeMasterDiagnosis::all();
        $rmeMasterImplementasi = RmeMasterImplementasi::all();
        $satsetPrognosis = SatsetPrognosis::all();
        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();

        // Mengambil data kunjungan
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

        if (! $dataMedis) {
            abort(404, 'Data not found');
        }

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        $dataMedis->waktu_masuk = Carbon::parse($dataMedis->TGL_MASUK.' '.$dataMedis->JAM_MASUK)->format('Y-m-d H:i:s');

        // Ambil data asesmen
        $asesmen = RmeAsesmen::where('id', $id)
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->where('kategori', 1)
            ->where('sub_kategori', 10)
            ->first();

        if (! $asesmen) {
            return redirect()->back()->with('error', 'Data asesmen tidak ditemukan');
        }

        // Ambil data detail asesmen kulit kelamin
        $asesmenKulitKelamin = RmeAsesmenKulitKelamin::where('id_asesmen', $asesmen->id)->first();

        if (! $asesmenKulitKelamin) {
            return redirect()->back()->with('error', 'Data asesmen kulit kelamin tidak ditemukan');
        }

        // Ambil data pemeriksaan fisik
        $pemeriksaanFisik = RmeAsesmenPemeriksaanFisik::where('id_asesmen', $asesmen->id)
            ->get()
            ->keyBy('id_item_fisik');

        // Ambil data rencana pulang
        $rencanaPulang = RmeAsesmenKulitKelaminRencanaPulang::where('id_asesmen', $asesmen->id)->first();

        return view('unit-pelayanan.rawat-inap.pelayanan.asesmen-kulitkelamin.edit', compact(
            'kd_unit',
            'kd_pasien',
            'tgl_masuk',
            'urut_masuk',
            'id',
            'dataMedis',
            'asesmen',
            'asesmenKulitKelamin',
            'pemeriksaanFisik',
            'rencanaPulang',
            'itemFisik',
            'menjalar',
            'frekuensinyeri',
            'kualitasnyeri',
            'faktorpemberat',
            'faktorperingan',
            'efeknyeri',
            'jenisnyeri',
            'rmeMasterDiagnosis',
            'rmeMasterImplementasi',
            'alergiPasien',
            'satsetPrognosis',
            'user'
        ));
    }

    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
            if (empty($dataMedis)) {
                throw new Exception('Data kunjungan tidak ditemukan');
            }

            // Validasi asesmen exists
            $asesmen = RmeAsesmen::where('id', $id)
                ->where('kd_pasien', $dataMedis->kd_pasien)
                ->where('kd_unit', $dataMedis->kd_unit)
                ->whereDate('tgl_masuk', $dataMedis->tgl_masuk)
                ->where('urut_masuk', $dataMedis->urut_masuk)
                ->where('kategori', 1)
                ->where('sub_kategori', 10)
                ->first();

            if (! $asesmen) {
                return redirect()->back()->with('error', 'Data asesmen tidak ditemukan');
            }

            $tanggal = $request->tanggal_masuk;
            $jam = $request->jam_masuk;
            $waktu_asesmen = $tanggal.' '.$jam;

            // Ambil tanggal dan jam dari form
            $formatDate = date('Y-m-d', strtotime($request->tanggal_masuk));
            $formatTime = date('H:i:s', strtotime($request->jam_masuk));

            // Update data asesmen utama
            $asesmen->user_id = Auth::id();
            $asesmen->waktu_asesmen = "$formatDate $formatTime";
            $asesmen->anamnesis = $request->anamnesis;
            $asesmen->skala_nyeri = $request->skala_nyeri;
            $asesmen->save();

            // Update atau create data kulit kelamin
            $dataKulitKelamin = RmeAsesmenKulitKelamin::where('id_asesmen', $asesmen->id)->first();

            if (! $dataKulitKelamin) {
                $dataKulitKelamin = new RmeAsesmenKulitKelamin;
                $dataKulitKelamin->id_asesmen = $asesmen->id;
            }

            $dataKulitKelamin->waktu_masuk = $waktu_asesmen;
            $dataKulitKelamin->diagnosis_masuk = $request->diagnosis_masuk;
            $dataKulitKelamin->kondisi_masuk = $request->kondisi_masuk;
            $dataKulitKelamin->keluhan_utama = $request->keluhan_utama;
            $dataKulitKelamin->riwayat_penyakit_sekarang = $request->riwayat_penyakit_sekarang;
            $dataKulitKelamin->riwayat_penyakit_terdahulu = $request->riwayat_penyakit_terdahulu;
            $dataKulitKelamin->riwayat_penyakit_keluarga = $request->riwayat_kesehatan_keluarga;
            $dataKulitKelamin->riwayat_penggunaan_obat = $request->riwayat_penggunaan_obat;
            $dataKulitKelamin->diagnosis_banding = $request->diagnosis_banding;
            $dataKulitKelamin->diagnosis_kerja = $request->diagnosis_kerja;
            $dataKulitKelamin->prognosis = $request->prognosis;
            $dataKulitKelamin->observasi = $request->observasi;
            $dataKulitKelamin->terapeutik = $request->terapeutik;
            $dataKulitKelamin->edukasi = $request->edukasi;
            $dataKulitKelamin->kolaborasi = $request->kolaborasi;
            $dataKulitKelamin->sensorium = $request->sensorium;
            $dataKulitKelamin->tekanan_darah_sistole = $request->tekanan_darah_sistole;
            $dataKulitKelamin->tekanan_darah_diastole = $request->tekanan_darah_diastole;
            $dataKulitKelamin->suhu = $request->suhu;
            $dataKulitKelamin->respirasi = $request->respirasi;
            $dataKulitKelamin->nadi = $request->nadi;
            $dataKulitKelamin->site_marking_data = $request->site_marking_data;
            $dataKulitKelamin->rencana_pengobatan = $request->rencana_pengobatan;
            $dataKulitKelamin->save();

            // Update Diagnosa ke Master (sama seperti store)
            $diagnosisBandingList = json_decode($request->diagnosis_banding ?? '[]', true);
            $diagnosisKerjaList = json_decode($request->diagnosis_kerja ?? '[]', true);
            $allDiagnoses = array_merge($diagnosisBandingList, $diagnosisKerjaList);
            foreach ($allDiagnoses as $diagnosa) {
                $existingDiagnosa = RmeMasterDiagnosis::where('nama_diagnosis', $diagnosa)->first();
                if (! $existingDiagnosa) {
                    $masterDiagnosa = new RmeMasterDiagnosis;
                    $masterDiagnosa->nama_diagnosis = $diagnosa;
                    $masterDiagnosa->save();
                }
            }

            // Update Implementasi ke Master
            $implementasiData = [
                'observasi' => json_decode($request->observasi ?? '[]', true),
                'terapeutik' => json_decode($request->terapeutik ?? '[]', true),
                'edukasi' => json_decode($request->edukasi ?? '[]', true),
                'kolaborasi' => json_decode($request->kolaborasi ?? '[]', true),
            ];

            foreach ($implementasiData as $column => $dataList) {
                foreach ($dataList as $item) {
                    $existingImplementasi = RmeMasterImplementasi::where($column, $item)->first();
                    if (! $existingImplementasi) {
                        $masterImplementasi = new RmeMasterImplementasi;
                        $masterImplementasi->$column = $item;
                        $masterImplementasi->save();
                    }
                }
            }

            // Update pemeriksaan fisik - hapus yang lama dulu
            RmeAsesmenPemeriksaanFisik::where('id_asesmen', $asesmen->id)->delete();

            // Insert pemeriksaan fisik yang baru
            $itemFisik = MrItemFisik::all();
            foreach ($itemFisik as $item) {
                $isNormal = $request->has($item->id.'-normal') ? 1 : 0;
                $keterangan = $request->input($item->id.'_keterangan');
                if ($isNormal) {
                    $keterangan = '';
                }

                RmeAsesmenPemeriksaanFisik::create([
                    'id_asesmen' => $asesmen->id,
                    'id_item_fisik' => $item->id,
                    'is_normal' => $isNormal,
                    'keterangan' => $keterangan,
                ]);
            }

            // Update data alergi
            $alergiData = json_decode($request->alergis, true);

            if (! empty($alergiData)) {
                // Hapus data alergi lama untuk pasien ini
                RmeAlergiPasien::where('kd_pasien', $kd_pasien)->delete();

                // Simpan data alergi baru
                foreach ($alergiData as $alergi) {
                    RmeAlergiPasien::create([
                        'kd_pasien' => $kd_pasien,
                        'jenis_alergi' => $alergi['jenis_alergi'],
                        'nama_alergi' => $alergi['alergen'],
                        'reaksi' => $alergi['reaksi'],
                        'tingkat_keparahan' => $alergi['tingkat_keparahan'],
                    ]);
                }
            } else {
                // Jika tidak ada data alergi baru, hapus yang lama
                RmeAlergiPasien::where('kd_pasien', $kd_pasien)->delete();
            }

            // Update rencana pulang
            $asesmenRencana = RmeAsesmenKulitKelaminRencanaPulang::where('id_asesmen', $asesmen->id)->first();

            if (! $asesmenRencana) {
                $asesmenRencana = new RmeAsesmenKulitKelaminRencanaPulang;
                $asesmenRencana->id_asesmen = $asesmen->id;
            }

            $asesmenRencana->diagnosis_medis = $request->diagnosis_medis;
            $asesmenRencana->usia_lanjut = $request->usia_lanjut;
            $asesmenRencana->hambatan_mobilisasi = $request->hambatan_mobilisasi;
            $asesmenRencana->membutuhkan_pelayanan_medis = $request->penggunaan_media_berkelanjutan;
            $asesmenRencana->memerlukan_keterampilan_khusus = $request->keterampilan_khusus;
            $asesmenRencana->memerlukan_alat_bantu = $request->alat_bantu;
            $asesmenRencana->memiliki_nyeri_kronis = $request->nyeri_kronis;
            $asesmenRencana->perkiraan_lama_dirawat = $request->perkiraan_hari;
            $asesmenRencana->rencana_pulang = $request->tanggal_pulang;
            $asesmenRencana->kesimpulan = $request->kesimpulan_planing;
            $asesmenRencana->save();

            // Prepare vital sign data
            $vitalSignData = [
                'sistole' => $request->tekanan_darah_sistole ? (int) $request->tekanan_darah_sistole : null,
                'diastole' => $request->tekanan_darah_diastole ? (int) $request->tekanan_darah_diastole : null,
                'nadi' => $request->nadi ? (int) $request->nadi : null,
                'respiration' => $request->respirasi ? (int) $request->respirasi : null,
                'suhu' => $request->suhu ? (float) $request->suhu : null,
            ];

            $this->asesmenService->store($vitalSignData, $kd_pasien, $dataMedis->no_transaksi, $dataMedis->kd_kasir);

            // Simpan Diagnosa ke Master
            $diagnosisBandingList = json_decode($request->diagnosis_banding ?? '[]', true);
            $diagnosisKerjaList = json_decode($request->diagnosis_kerja ?? '[]', true);
            $allDiagnoses = array_merge($diagnosisBandingList, $diagnosisKerjaList);

            // create resume
            $resumeData = [
                'anamnesis' => $request->anamnesis,
                'diagnosis' => $allDiagnoses,

                'konpas' => [
                    'sistole' => [
                        'hasil' => $vitalSignData['sistole'] ?? null,
                    ],
                    'distole' => [
                        'hasil' => $vitalSignData['diastole'] ?? null,
                    ],
                    'respiration_rate' => [
                        'hasil' => $vitalSignData['respiration'] ?? null,
                    ],
                    'suhu' => [
                        'hasil' => $vitalSignData['suhu'] ?? null,
                    ],
                    'nadi' => [
                        'hasil' => $vitalSignData['nadi'] ?? null,
                    ],
                ],
            ];

            $this->baseService->updateResumeMedis($dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $resumeData);

            DB::commit();

            return redirect()->route('rawat-inap.asesmen.medis.kulit-kelamin.show', [
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
                'id' => $id,
            ])->with('success', 'Data asesmen kulit kelamin berhasil diperbarui');
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Gagal memperbarui data asesmen: '.$e->getMessage());
        }
    }

    public function generatePDF($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $data = $this->show($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id, true);
     
        return view('unit-pelayanan.rawat-inap.pelayanan.asesmen-kulitkelamin.print-pdf', ['data' => $data]);
    }
}
