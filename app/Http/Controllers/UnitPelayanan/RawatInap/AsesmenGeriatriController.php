<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\MrItemFisik;
use App\Models\RmeAlergiPasien;
use App\Models\RmeAsesmen;
use App\Models\RmeAsesmenGeriatri;
use App\Models\RmeAsesmenGeriatriRencanaPulang;
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
use App\Models\RMEResume;
use App\Models\RmeResumeDtl;
use App\Services\AsesmenService;
use App\Services\BaseService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class AsesmenGeriatriController extends Controller
{
    protected $asesmenService;
    private $baseService;

    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
        $this->asesmenService = new AsesmenService();
        $this->baseService = new BaseService();
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

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        $dataMedis->waktu_masuk = Carbon::parse($dataMedis->TGL_MASUK . ' ' . $dataMedis->JAM_MASUK)->format('Y-m-d H:i:s');
        // Get latest vital signs data for the patient
        $vitalSignsData = $this->asesmenService->getLatestVitalSignsByPatient($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

        return view('unit-pelayanan.rawat-inap.pelayanan.asesmen-geriatri.create', compact(
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
            'user',
            'vitalSignsData'
        ));
    }


    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        DB::beginTransaction();

        try {
            $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
            if (empty($dataMedis)) throw new Exception("Data kunjungan tidak ditemukan");


            // Prepare assessment time
            $tanggal = $request->tanggal_masuk;
            $jam = $request->jam_masuk;
            $waktu_asesmen = $tanggal . ' ' . $jam;


            // Ambil tanggal dan jam dari form
            $formatDate = date('Y-m-d', strtotime($request->tanggal_masuk));
            $formatTime = date('H:i:s', strtotime($request->jam_masuk));

            // Simpan data utama asesmen
            $dataAsesmen = new RmeAsesmen();
            $dataAsesmen->kd_pasien = $dataMedis->kd_pasien;
            $dataAsesmen->kd_unit = $dataMedis->kd_unit;
            $dataAsesmen->tgl_masuk = $dataMedis->tgl_masuk;
            $dataAsesmen->urut_masuk = $dataMedis->urut_masuk;
            $dataAsesmen->user_id = Auth::id();
            $dataAsesmen->waktu_asesmen = "$formatDate $formatTime";
            $dataAsesmen->kategori = 1;
            $dataAsesmen->sub_kategori = 12; // 12 untuk Geriatri
            $dataAsesmen->anamnesis = $request->anamnesis;
            $dataAsesmen->skala_nyeri = $request->skala_nyeri ?? null;
            $dataAsesmen->save();

            // PERBAIKAN: Gunakan model yang sesuai untuk Geriatri
            $dataGeriatri = new RmeAsesmenGeriatri();
            $dataGeriatri->id_asesmen = $dataAsesmen->id;

            // Section 1: Data Masuk
            $dataGeriatri->waktu_masuk = $waktu_asesmen;
            $dataGeriatri->kondisi_masuk = $request->kondisi_masuk;
            $dataGeriatri->diagnosis_masuk = $request->diagnosis_masuk;

            // Section 2: Anamnesis & Vital Signs
            $dataGeriatri->keluhan_utama = $request->keluhan_utama;
            $dataGeriatri->sensorium = $request->sensorium;
            $dataGeriatri->sistole = $request->sistole;
            $dataGeriatri->diastole = $request->diastole;
            $dataGeriatri->suhu = $request->suhu;
            $dataGeriatri->respirasi = $request->respirasi;
            $dataGeriatri->nadi = $request->nadi;
            $dataGeriatri->berat_badan = $request->berat_badan;
            $dataGeriatri->tinggi_badan = $request->tinggi_badan;
            $dataGeriatri->imt = $request->imt;

            // Section 3: Riwayat Kesehatan
            $dataGeriatri->riwayat_penyakit_sekarang = $request->riwayat_penyakit_sekarang;
            $dataGeriatri->riwayat_penyakit_terdahulu = $request->riwayat_penyakit_terdahulu;

            // Section 4: Data Psikologi dan Sosial Ekonomi
            $dataGeriatri->kondisi_psikologi = $request->kondisi_psikologi;
            $dataGeriatri->kondisi_sosial_ekonomi = $request->kondisi_sosial_ekonomi;

            // Section 5: Asesmen Geriatri - PERBAIKAN untuk checkbox mutual exclusive
            $dataGeriatri->adl = is_array($request->adl) ? json_encode($request->adl) : null;
            $dataGeriatri->kognitif = is_array($request->kognitif) ? json_encode($request->kognitif) : null;
            $dataGeriatri->depresi = is_array($request->depresi) ? json_encode($request->depresi) : null;
            $dataGeriatri->inkontinensia = is_array($request->inkontinensia) ? json_encode($request->inkontinensia) : null;
            $dataGeriatri->insomnia = is_array($request->insomnia) ? json_encode($request->insomnia) : null;

            // Kategori IMT
            $dataGeriatri->kategori_imt = is_array($request->kategori_imt) ? json_encode($request->kategori_imt) : null;

            // Section 9: Diagnosis
            $dataGeriatri->diagnosis_banding = $request->diagnosis_banding;
            $dataGeriatri->diagnosis_kerja = $request->diagnosis_kerja;

            $dataGeriatri->save();

            // Simpan Pemeriksaan Fisik (tidak berubah)
            $itemFisik = MrItemFisik::all();
            foreach ($itemFisik as $item) {
                $isNormal = $request->has($item->id . '-normal') ? 1 : 0;
                $keterangan = $request->input($item->id . '_keterangan');
                if ($isNormal) $keterangan = '';

                RmeAsesmenPemeriksaanFisik::create([
                    'id_asesmen' => $dataAsesmen->id,
                    'id_item_fisik' => $item->id,
                    'is_normal' => $isNormal,
                    'keterangan' => $keterangan
                ]);
            }

            // Section 8: Discharge Planning - PERBAIKAN nama model
            $asesmenRencana = new RmeAsesmenGeriatriRencanaPulang(); // Pastikan nama model ini benar
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

            // Prepare vital sign data
            $vitalSignData = [
                'sistole' => $request->sistole ? (int) $request->sistole : null,
                'diastole' => $request->diastole ? (int) $request->diastole : null,
                'nadi' => $request->nadi ? (int) $request->nadi : null,
                'respiration' => $request->respirasi ? (int) $request->respirasi : null,
                'suhu' => $request->suhu ? (float) $request->suhu : null,
                'tinggi_badan' => $request->tinggi_badan ? (int) $request->tinggi_badan : null,
                'berat_badan' => $request->berat_badan ? (int) $request->berat_badan : null,
            ];


            // Save vital signs using service
            $this->asesmenService->store($vitalSignData, $kd_pasien, $dataMedis->no_transaksi, $dataMedis->kd_kasir);

            // create resume
            $resumeData = [
                'anamnesis'             => $request->anamnesis,

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

            return redirect()->to(url("unit-pelayanan/rawat-inap/unit/$kd_unit/pelayanan/$kd_pasien/$tgl_masuk/$urut_masuk/asesmen/medis/umum"))
                ->with('success', 'Data asesmen geriatri dan tanda vital berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan data asesmen: ' . $e->getMessage());
        }
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

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        $dataMedis->waktu_masuk = Carbon::parse($dataMedis->TGL_MASUK . ' ' . $dataMedis->JAM_MASUK)->format('Y-m-d H:i:s');

        // Ambil data asesmen berdasarkan ID spesifik
        $asesmen = RmeAsesmen::where('id', $id)
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->where('kategori', 1)
            ->where('sub_kategori', 12) // Geriatri
            ->first();

        if (!$asesmen) {
            return redirect()->back()->with('error', 'Data asesmen geriatri tidak ditemukan');
        }

        // Ambil data detail asesmen geriatri
        $asesmenGeriatri = RmeAsesmenGeriatri::where('id_asesmen', $asesmen->id)->first();

        if (!$asesmenGeriatri) {
            return redirect()->back()->with('error', 'Data asesmen geriatri tidak ditemukan');
        }

        // Ambil data pemeriksaan fisik
        $pemeriksaanFisik = RmeAsesmenPemeriksaanFisik::where('id_asesmen', $asesmen->id)
            ->get()
            ->keyBy('id_item_fisik');

        // Ambil data rencana pulang
        $rencanaPulang = RmeAsesmenGeriatriRencanaPulang::where('id_asesmen', $asesmen->id)->first();

        return view('unit-pelayanan.rawat-inap.pelayanan.asesmen-geriatri.edit', compact(
            'kd_unit',
            'kd_pasien',
            'tgl_masuk',
            'urut_masuk',
            'id',
            'dataMedis',
            'asesmen',
            'asesmenGeriatri',
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
            'user'
        ));
    }
    public function generatePDF($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        // 1. Ambil data kunjungan dan pasien [cite: 351, 352]
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
            abort(404, 'Data kunjungan tidak ditemukan');
        }

        // 2. Ambil data asesmen utama [cite: 357]
        $asesmen = RmeAsesmen::with(['user.karyawan'])
            ->where('id', $id)
            ->where('sub_kategori', 12) // Geriatri
            ->first();

        if (!$asesmen) {
            return redirect()->back()->with('error', 'Data asesmen tidak ditemukan');
        }

        // 3. Ambil data detail geriatri, pemeriksaan fisik, alergi, dan rencana pulang [cite: 360, 362, 363, 364]
        $asesmenGeriatri = RmeAsesmenGeriatri::where('id_asesmen', $asesmen->id)->first();
        $pemeriksaanFisik = RmeAsesmenPemeriksaanFisik::with('itemFisik')
            ->where('id_asesmen', $asesmen->id)
            ->get()
            ->keyBy('id_item_fisik');
        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();
        $rencanaPulang = RmeAsesmenGeriatriRencanaPulang::where('id_asesmen', $asesmen->id)->first();
        $itemFisik = MrItemFisik::orderby('urut')->get();

        // 4. Decode data JSON untuk ditampilkan di PDF [cite: 366, 367, 368, 369]
        $diagnosisBanding = json_decode($asesmenGeriatri->diagnosis_banding ?? '[]', true);
        $diagnosisKerja = json_decode($asesmenGeriatri->diagnosis_kerja ?? '[]', true);
        $adl = json_decode($asesmenGeriatri->adl ?? '[]', true);
        $kognitif = json_decode($asesmenGeriatri->kognitif ?? '[]', true);
        $depresi = json_decode($asesmenGeriatri->depresi ?? '[]', true);
        $inkontinensia = json_decode($asesmenGeriatri->inkontinensia ?? '[]', true);
        $insomnia = json_decode($asesmenGeriatri->insomnia ?? '[]', true);
        $kategoriImt = json_decode($asesmenGeriatri->kategori_imt ?? '[]', true);

        // Variabel pendukung untuk view (menyesuaikan variabel di file printgeriatri.txt)
        $pasien = $dataMedis->pasien;

        // 5. Generate PDF
        $pdf = Pdf::loadView('unit-pelayanan.rawat-inap.pelayanan.asesmen-geriatri.print', compact(
            'dataMedis',
            'pasien',
            'asesmen',
            'asesmenGeriatri',
            'pemeriksaanFisik',
            'alergiPasien',
            'rencanaPulang',
            'itemFisik',
            'diagnosisBanding',
            'diagnosisKerja',
            'adl',
            'kognitif',
            'depresi',
            'inkontinensia',
            'insomnia',
            'kategoriImt'
        ))->setPaper('a4', 'portrait');

        return $pdf->stream('Asesmen_Geriatri_' . $kd_pasien . '.pdf');
    }


    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
            if (empty($dataMedis)) throw new Exception("Data kunjungan tidak ditemukan");

            // Validasi asesmen exists berdasarkan ID
            $asesmen = RmeAsesmen::where('id', $id)
                ->where('kd_pasien', $dataMedis->kd_pasien)
                ->where('kd_unit', $dataMedis->kd_unit)
                ->whereDate('tgl_masuk', $dataMedis->tgl_masuk)
                ->where('urut_masuk', $dataMedis->urut_masuk)
                ->where('kategori', 1)
                ->where('sub_kategori', 12) // Geriatri
                ->first();

            if (!$asesmen) {
                return redirect()->back()->with('error', 'Data asesmen geriatri tidak ditemukan');
            }

            $tanggal = $request->tanggal_masuk;
            $jam = $request->jam_masuk;
            $waktu_asesmen = $tanggal . ' ' . $jam;

            // Ambil tanggal dan jam dari form
            $formatDate = date('Y-m-d', strtotime($request->tanggal_masuk));
            $formatTime = date('H:i:s', strtotime($request->jam_masuk));

            // Update data asesmen utama
            $asesmen->user_id = Auth::id();
            $asesmen->waktu_asesmen = "$formatDate $formatTime";
            $asesmen->anamnesis = $request->anamnesis;
            $asesmen->skala_nyeri = $request->skala_nyeri ?? null;
            $asesmen->save();

            // Update atau create data geriatri
            $dataGeriatri = RmeAsesmenGeriatri::where('id_asesmen', $asesmen->id)->first();

            if (!$dataGeriatri) {
                $dataGeriatri = new RmeAsesmenGeriatri();
                $dataGeriatri->id_asesmen = $asesmen->id;
            }

            // Section 1: Data Masuk
            $dataGeriatri->waktu_masuk = $waktu_asesmen;
            $dataGeriatri->kondisi_masuk = $request->kondisi_masuk;
            $dataGeriatri->diagnosis_masuk = $request->diagnosis_masuk;

            // Section 2: Anamnesis & Vital Signs
            $dataGeriatri->keluhan_utama = $request->keluhan_utama;
            $dataGeriatri->sensorium = $request->sensorium;
            $dataGeriatri->sistole = $request->tekanan_darah_sistole;
            $dataGeriatri->diastole = $request->tekanan_darah_diastole;
            $dataGeriatri->suhu = $request->suhu;
            $dataGeriatri->respirasi = $request->respirasi;
            $dataGeriatri->nadi = $request->nadi;
            $dataGeriatri->berat_badan = $request->berat_badan;
            $dataGeriatri->tinggi_badan = $request->tinggi_badan;
            $dataGeriatri->imt = $request->imt;

            // Section 3: Riwayat Kesehatan
            $dataGeriatri->riwayat_penyakit_sekarang = $request->riwayat_penyakit_sekarang;
            $dataGeriatri->riwayat_penyakit_terdahulu = $request->riwayat_penyakit_terdahulu;

            // Section 4: Data Psikologi dan Sosial Ekonomi
            $dataGeriatri->kondisi_psikologi = $request->kondisi_psikologi;
            $dataGeriatri->kondisi_sosial_ekonomi = $request->kondisi_sosial_ekonomi;

            // Section 5: Asesmen Geriatri
            $dataGeriatri->adl = is_array($request->adl) ? json_encode($request->adl) : null;
            $dataGeriatri->kognitif = is_array($request->kognitif) ? json_encode($request->kognitif) : null;
            $dataGeriatri->depresi = is_array($request->depresi) ? json_encode($request->depresi) : null;
            $dataGeriatri->inkontinensia = is_array($request->inkontinensia) ? json_encode($request->inkontinensia) : null;
            $dataGeriatri->insomnia = is_array($request->insomnia) ? json_encode($request->insomnia) : null;

            // Kategori IMT
            $dataGeriatri->kategori_imt = is_array($request->kategori_imt) ? json_encode($request->kategori_imt) : null;

            // Section 9: Diagnosis
            $dataGeriatri->diagnosis_banding = $request->diagnosis_banding;
            $dataGeriatri->diagnosis_kerja = $request->diagnosis_kerja;

            $dataGeriatri->save();

            // Update Diagnosa ke Master
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

            // Update pemeriksaan fisik - hapus yang lama dulu
            RmeAsesmenPemeriksaanFisik::where('id_asesmen', $asesmen->id)->delete();

            // Insert pemeriksaan fisik yang baru
            $itemFisik = MrItemFisik::all();
            foreach ($itemFisik as $item) {
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

            // Update rencana pulang
            $asesmenRencana = RmeAsesmenGeriatriRencanaPulang::where('id_asesmen', $asesmen->id)->first();

            if (!$asesmenRencana) {
                $asesmenRencana = new RmeAsesmenGeriatriRencanaPulang();
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
                'sistole' => $request->sistole ? (int) $request->sistole : null,
                'diastole' => $request->diastole ? (int) $request->diastole : null,
                'nadi' => $request->nadi ? (int) $request->nadi : null,
                'respiration' => $request->respirasi ? (int) $request->respirasi : null,
                'suhu' => $request->suhu ? (float) $request->suhu : null,
                'tinggi_badan' => $request->tinggi_badan ? (int) $request->tinggi_badan : null,
                'berat_badan' => $request->berat_badan ? (int) $request->berat_badan : null,
            ];


            // Save vital signs using service
            $this->asesmenService->store($vitalSignData, $kd_pasien, $dataMedis->no_transaksi, $dataMedis->kd_kasir);

            // create resume
            $resumeData = [
                'anamnesis'             => $request->anamnesis,

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

            return redirect()->route('rawat-inap.asesmen.medis.geriatri.show', [
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
                'id' => $id
            ])->with('success', 'Data asesmen geriatri berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui data asesmen geriatri: ' . $e->getMessage());
        }
    }


    public function show($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $user = auth()->user();

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

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        $dataMedis->waktu_masuk = Carbon::parse($dataMedis->TGL_MASUK . ' ' . $dataMedis->JAM_MASUK)->format('Y-m-d H:i:s');

        // Ambil data asesmen berdasarkan ID spesifik
        $asesmen = RmeAsesmen::where('id', $id)
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->where('kategori', 1)
            ->where('sub_kategori', 12) // Geriatri
            ->first();

        if (!$asesmen) {
            return redirect()->back()->with('error', 'Data asesmen geriatri tidak ditemukan');
        }

        // Ambil data detail asesmen geriatri
        $asesmenGeriatri = RmeAsesmenGeriatri::where('id_asesmen', $asesmen->id)->first();

        if (!$asesmenGeriatri) {
            return redirect()->back()->with('error', 'Data asesmen geriatri tidak ditemukan');
        }

        // Ambil data pemeriksaan fisik
        $pemeriksaanFisik = RmeAsesmenPemeriksaanFisik::with('itemFisik')
            ->where('id_asesmen', $asesmen->id)
            ->get()
            ->keyBy('id_item_fisik');

        // Ambil data alergi pasien
        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();

        // Ambil data rencana pulang
        $rencanaPulang = RmeAsesmenGeriatriRencanaPulang::where('id_asesmen', $asesmen->id)->first();

        // Ambil semua item fisik untuk referensi
        $itemFisik = MrItemFisik::orderby('urut')->get();

        // Decode JSON data untuk asesmen geriatri
        $diagnosisBanding = json_decode($asesmenGeriatri->diagnosis_banding ?? '[]', true);
        $diagnosisKerja = json_decode($asesmenGeriatri->diagnosis_kerja ?? '[]', true);
        $adl = json_decode($asesmenGeriatri->adl ?? '[]', true);
        $kognitif = json_decode($asesmenGeriatri->kognitif ?? '[]', true);
        $depresi = json_decode($asesmenGeriatri->depresi ?? '[]', true);
        $inkontinensia = json_decode($asesmenGeriatri->inkontinensia ?? '[]', true);
        $insomnia = json_decode($asesmenGeriatri->insomnia ?? '[]', true);
        $kategoriImt = json_decode($asesmenGeriatri->kategori_imt ?? '[]', true);

        return view('unit-pelayanan.rawat-inap.pelayanan.asesmen-geriatri.show', compact(
            'kd_unit',
            'kd_pasien',
            'tgl_masuk',
            'urut_masuk',
            'dataMedis',
            'asesmen',
            'asesmenGeriatri',
            'pemeriksaanFisik',
            'alergiPasien',
            'rencanaPulang',
            'itemFisik',
            'diagnosisBanding',
            'diagnosisKerja',
            'adl',
            'kognitif',
            'depresi',
            'inkontinensia',
            'insomnia',
            'kategoriImt',
            'user'
        ));
    }
}
