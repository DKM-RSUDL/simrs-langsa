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
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AsesmenGeriatriController extends Controller
{
    protected $asesmenService;
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
        $this->asesmenService = new AsesmenService();
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


    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk){
        DB::beginTransaction();

        try {
            // Validate vital sign inputs
            $request->validate([
                'sistole' => 'nullable|numeric|min:0|max:300',
                'diastole' => 'nullable|numeric|min:0|max:200',
                'nadi' => 'nullable|numeric|min:0|max:300',
                'respirasi' => 'nullable|numeric|min:0|max:100',
                'suhu' => 'nullable|numeric|min:0|max:45',
                'tinggi_badan' => 'nullable|numeric|min:0|max:300',
                'berat_badan' => 'nullable|numeric|min:0|max:500',
                'imt' => 'nullable|numeric|min:0|max:100',
            ], [
                'sistole.numeric' => 'Sistole harus berupa angka.',
                'sistole.min' => 'Sistole tidak boleh kurang dari 0.',
                'sistole.max' => 'Sistole tidak boleh lebih dari 300.',
                'diastole.numeric' => 'Diastole harus berupa angka.',
                'diastole.min' => 'Diastole tidak boleh kurang dari 0.',
                'diastole.max' => 'Diastole tidak boleh lebih dari 200.',
                'nadi.numeric' => 'Nadi harus berupa angka.',
                'nadi.min' => 'Nadi tidak boleh kurang dari 0.',
                'nadi.max' => 'Nadi tidak boleh lebih dari 300.',
                'respirasi.numeric' => 'Respirasi harus berupa angka.',
                'respirasi.min' => 'Respirasi tidak boleh kurang dari 0.',
                'respirasi.max' => 'Respirasi tidak boleh lebih dari 100.',
                'suhu.numeric' => 'Suhu harus berupa angka.',
                'suhu.min' => 'Suhu tidak boleh kurang dari 0.',
                'suhu.max' => 'Suhu tidak boleh lebih dari 45.',
                'tinggi_badan.numeric' => 'Tinggi badan harus berupa angka.',
                'tinggi_badan.min' => 'Tinggi badan tidak boleh kurang dari 0.',
                'tinggi_badan.max' => 'Tinggi badan tidak boleh lebih dari 300.',
                'berat_badan.numeric' => 'Berat badan harus berupa angka.',
                'berat_badan.min' => 'Berat badan tidak boleh kurang dari 0.',
                'berat_badan.max' => 'Berat badan tidak boleh lebih dari 500.',
                'imt.numeric' => 'IMT harus berupa angka.',
                'imt.min' => 'IMT tidak boleh kurang dari 0.',
                'imt.max' => 'IMT tidak boleh lebih dari 100.',
            ]);

            // Prepare assessment time
            $tanggal = $request->tanggal_masuk;
            $jam = $request->jam_masuk;
            $waktu_asesmen = $tanggal . ' ' . $jam;

            // Save core assessment data
            $dataAsesmen = new RmeAsesmen();
            $dataAsesmen->kd_pasien = $kd_pasien;
            $dataAsesmen->kd_unit = $kd_unit;
            $dataAsesmen->tgl_masuk = $tgl_masuk;
            $dataAsesmen->urut_masuk = $urut_masuk;
            $dataAsesmen->user_id = Auth::id();
            $dataAsesmen->waktu_asesmen = $waktu_asesmen;
            $dataAsesmen->kategori = 1;
            $dataAsesmen->sub_kategori = 12; // Specific to geriatrics
            $dataAsesmen->anamnesis = $request->anamnesis;
            $dataAsesmen->save();

            // Prepare vital sign data
            $vitalSignData = [
                'sistole' => $request->sistole ? (int) $request->sistole : null,
                'diastole' => $request->diastole ? (int) $request->diastole : null,
                'nadi' => $request->nadi ? (int) $request->nadi : null,
                'respiration' => $request->respirasi ? (int) $request->respirasi : null,
                'suhu' => $request->suhu ? (float) $request->suhu : null,
                'tinggi_badan' => $request->tinggi_badan ? (int) $request->tinggi_badan : null,
                'berat_badan' => $request->berat_badan ? (int) $request->berat_badan : null,
                'imt' => $request->imt ? (float) $request->imt : null,
            ];

            // Get transaction data for vital sign storage
            $lastTransaction = $this->asesmenService->getTransaksiData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

            // Save vital signs using service
            $this->asesmenService->store($vitalSignData, $kd_pasien, $lastTransaction->no_transaksi, $lastTransaction->kd_kasir);

            // Save geriatrics-specific assessment data with vital signs
            $dataGeriatri = new RmeAsesmenGeriatri();
            $dataGeriatri->id_asesmen = $dataAsesmen->id;
            $dataGeriatri->waktu_masuk = $waktu_asesmen;
            $dataGeriatri->kondisi_masuk = $request->kondisi_masuk;
            $dataGeriatri->diagnosis_masuk = $request->diagnosis_masuk;
            $dataGeriatri->keluhan_utama = $request->keluhan_utama;
            $dataGeriatri->sistole = $vitalSignData['sistole'];
            $dataGeriatri->diastole = $vitalSignData['diastole'];
            $dataGeriatri->nadi = $vitalSignData['nadi'];
            $dataGeriatri->respirasi = $vitalSignData['respiration'];
            $dataGeriatri->suhu = $vitalSignData['suhu'];
            $dataGeriatri->tinggi_badan = $vitalSignData['tinggi_badan'];
            $dataGeriatri->berat_badan = $vitalSignData['berat_badan'];
            $dataGeriatri->imt = $vitalSignData['imt'];
            $dataGeriatri->save();

            // Save resume data with vital signs
            $resumeData = [
                'anamnesis' => $request->anamnesis ?? $request->keluhan_utama ?? '',
                'diagnosis' => [],
                'tindak_lanjut_code' => null,
                'tindak_lanjut_name' => null,
                'tgl_kontrol_ulang' => null,
                'unit_rujuk_internal' => null,
                'rs_rujuk' => null,
                'rs_rujuk_bagian' => null,
                'konpas' => [
                    'sistole' => ['hasil' => $vitalSignData['sistole']],
                    'diastole' => ['hasil' => $vitalSignData['diastole']],
                    'respiration_rate' => ['hasil' => $vitalSignData['respiration']],
                    'suhu' => ['hasil' => $vitalSignData['suhu']],
                    'nadi' => ['hasil' => $vitalSignData['nadi']],
                    'tinggi_badan' => ['hasil' => $vitalSignData['tinggi_badan']],
                    'berat_badan' => ['hasil' => $vitalSignData['berat_badan']],
                    'imt' => ['hasil' => $vitalSignData['imt']],
                ]
            ];

            $this->createResume($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $resumeData);

            DB::commit();

            return redirect()->to(url("unit-pelayanan/rawat-inap/unit/$kd_unit/pelayanan/$kd_pasien/$tgl_masuk/$urut_masuk/asesmen/medis/umum"))
                ->with('success', 'Data asesmen geriatri dan tanda vital berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan data asesmen: ' . $e->getMessage());
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



    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            // Validasi asesmen exists berdasarkan ID
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

            $tanggal = $request->tanggal_masuk;
            $jam = $request->jam_masuk;
            $waktu_asesmen = $tanggal . ' ' . $jam;

            // Update data asesmen utama
            $asesmen->user_id = Auth::id();
            $asesmen->waktu_asesmen = $waktu_asesmen;
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

            // Update RESUME
            $resumeData = [
                'anamnesis' => $request->anamnesis,
                'diagnosis' => [],
                'tindak_lanjut_code' => null,
                'tindak_lanjut_name' => null,
                'tgl_kontrol_ulang' => null,
                'unit_rujuk_internal' => null,
                'rs_rujuk' => null,
                'rs_rujuk_bagian' => null,
                'konpas' => [
                    'sistole' => [
                        'hasil' => $request->tekanan_darah_sistole
                    ],
                    'diastole' => [
                        'hasil' => $request->tekanan_darah_diastole
                    ],
                    'respiration_rate' => [
                        'hasil' => $request->respirasi
                    ],
                    'suhu' => [
                        'hasil' => $request->suhu
                    ],
                    'nadi' => [
                        'hasil' => $request->nadi
                    ],
                    'tinggi_badan' => [
                        'hasil' => $request->tinggi_badan
                    ],
                    'berat_badan' => [
                        'hasil' => $request->berat_badan
                    ]
                ]
            ];

            $this->createResume($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $resumeData);

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
