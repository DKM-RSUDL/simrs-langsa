<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\MrItemFisik;
use App\Models\RmeAlergiPasien;
use App\Models\RmeAsesmen;
use App\Models\RmeAsesmenPsikiatri;
use App\Models\RmeAsesmenPsikiatriDtl;
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
use App\Models\SatsetPrognosis;
use App\Models\Unit;
use App\Services\AsesmenService;
use App\Services\BaseService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AsesmenPsikiatriController extends Controller
{
    protected $asesmenService;
    private $baseService;

    public function __construct()
    {
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
        $satsetPrognosis = SatsetPrognosis::all();
        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();

        $poliklinik = Unit::where('kd_bagian', '2')
            ->where('aktif', 1)
            ->orderBy('nama_unit')
            ->get();

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

        return view('unit-pelayanan.rawat-inap.pelayanan.asesmen-psikiatri.create', compact(
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
            'poliklinik',
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
            if (empty($dataMedis)) throw new Exception("Data kunjungan tidak ditemukan");

            $tanggal = $request->tanggal_masuk;
            $jam = $request->jam_masuk;
            $waktu_asesmen = $tanggal . ' ' . $jam;

            $dataAsesmen = new RmeAsesmen();
            $dataAsesmen->kd_pasien = $kd_pasien;
            $dataAsesmen->kd_unit = $kd_unit;
            $dataAsesmen->tgl_masuk = $tgl_masuk;
            $dataAsesmen->urut_masuk = $urut_masuk;
            $dataAsesmen->user_id = Auth::id();
            $dataAsesmen->waktu_asesmen = $waktu_asesmen;
            $dataAsesmen->kategori = 1;
            $dataAsesmen->sub_kategori = 11; // Asesmen Psikiatri
            $dataAsesmen->anamnesis = $request->anamnesis;
            $dataAsesmen->skala_nyeri = $request->skala_nyeri;
            $dataAsesmen->save();

            $asesmenPsikiatri = new RmeAsesmenPsikiatri();
            $asesmenPsikiatri->id_asesmen = $dataAsesmen->id;
            $asesmenPsikiatri->waktu_masuk = $waktu_asesmen;
            $asesmenPsikiatri->kondisi_masuk = $request->kondisi_masuk;
            $asesmenPsikiatri->diagnosis_masuk = $request->diagnosis_masuk;

            // Pengkajian Keperawatan
            $asesmenPsikiatri->anamnesis = $request->anamnesis;
            $asesmenPsikiatri->keluhan_utama = $request->keluhan_utama;
            $asesmenPsikiatri->sensorium = $request->sensorium;
            $asesmenPsikiatri->tekanan_darah_sistole = $request->tekanan_darah_sistole;
            $asesmenPsikiatri->tekanan_darah_diastole = $request->tekanan_darah_diastole;
            $asesmenPsikiatri->suhu = $request->suhu;
            $asesmenPsikiatri->respirasi = $request->respirasi;
            $asesmenPsikiatri->nadi = $request->nadi;
            $asesmenPsikiatri->skala_nyeri = $request->skala_nyeri;
            $asesmenPsikiatri->kategori_nyeri = $request->kategori_nyeri;
            $asesmenPsikiatri->alat_bantu = $request->alat_bantu;
            $asesmenPsikiatri->cacat_tubuh = $request->cacat_tubuh;
            $asesmenPsikiatri->adl = $request->adl;
            $asesmenPsikiatri->resiko_jatuh = $request->resiko_jatuh;
            $asesmenPsikiatri->save();

            // Pengkajian Medis
            $asesmenPsikiatriDtl = new RmeAsesmenPsikiatriDtl();
            $asesmenPsikiatriDtl->id_asesmen = $dataAsesmen->id;
            $asesmenPsikiatriDtl->riwayat_penyakit_sekarang = $request->riwayat_penyakit_sekarang;
            $asesmenPsikiatriDtl->riwayat_penyakit_terdahulu = $request->riwayat_penyakit_terdahulu;
            $asesmenPsikiatriDtl->riwayat_penyakit_perkembangan_masa_kanak = $request->riwayat_penyakit_perkembangan_masa_kanak;
            $asesmenPsikiatriDtl->riwayat_penyakit_masa_dewasa = $request->riwayat_penyakit_masa_dewasa;
            $asesmenPsikiatriDtl->riwayat_kesehatan_keluarga = $request->riwayat_kesehatan_keluarga;
            $asesmenPsikiatriDtl->terapi_diberikan = $request->terapi_diberikan;

            // Pemeriksaan Fisik
            $asesmenPsikiatriDtl->pemeriksaan_psikiatri = $request->pemeriksaan_psikiatri;
            $asesmenPsikiatriDtl->status_internis = $request->status_internis;
            $asesmenPsikiatriDtl->status_neorologi = $request->status_neorologi;
            $asesmenPsikiatriDtl->pemeriksaan_penunjang = $request->pemeriksaan_penunjang;

            // Diagnosis
            $asesmenPsikiatriDtl->diagnosis_banding = $request->diagnosis_banding;
            $asesmenPsikiatriDtl->axis_i = $request->axis_i;
            $asesmenPsikiatriDtl->axis_ii = $request->axis_ii;
            $asesmenPsikiatriDtl->axis_iii = $request->axis_iii;
            $asesmenPsikiatriDtl->axis_iv = $request->axis_iv;
            $asesmenPsikiatriDtl->axis_v = $request->axis_v;

            // Prognosis dan Therapy
            $asesmenPsikiatriDtl->prognosis = $request->prognosis;
            $asesmenPsikiatriDtl->therapi = $request->therapi;
            $asesmenPsikiatriDtl->save();


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


            // Validasi data alergi
            $alergiData = json_decode($request->alergis, true);

            if (!empty($alergiData)) {
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
                        'tingkat_keparahan' => $alergi['tingkat_keparahan']
                    ]);
                }
            }

            $vitalSignData = [
                'sistole'      => $request->tekanan_darah_sistole ? (int)$request->tekanan_darah_sistole : null,
                'diastole'     => $request->tekanan_darah_diastole ? (int)$request->tekanan_darah_diastole : null,
                'nadi'         => $request->nadi ? (int)$request->nadi : null,
                'respiration'  => $request->respirasi ? (int)$request->respirasi : null,
                'suhu'         => $request->suhu ? (float)$request->suhu : null,
                'tinggi_badan' => $request->tinggi_badan ? (int)$request->tinggi_badan : null,
                'berat_badan'  => $request->berat_badan ? (int)$request->berat_badan : null,
            ];

            $this->asesmenService->store(
                $vitalSignData,
                $kd_pasien,
                $dataMedis->no_transaksi,
                $dataMedis->kd_kasir
            );

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

            return redirect()->to(url("unit-pelayanan/rawat-inap/unit/$kd_unit/pelayanan/$kd_pasien/$tgl_masuk/$urut_masuk/asesmen/medis/umum"))
                ->with('success', 'Data asesmen Psikiatri berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan data asesmen' . $e->getMessage());
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
        $satsetPrognosis = SatsetPrognosis::all();
        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();

        $poliklinik = Unit::where('kd_bagian', '2')
            ->where('aktif', 1)
            ->orderBy('nama_unit')
            ->get();

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

        // Mengambil data asesmen psikiatri yang sudah ada
        $asesmen = RmeAsesmen::where('id', $id)
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->where('kategori', 1)
            ->where('sub_kategori', 11)
            ->first();

        if (!$asesmen) {
            abort(404, 'Data asesmen psikiatri tidak ditemukan');
        }

        $asesmenPsikiatri = RmeAsesmenPsikiatri::where('id_asesmen', $asesmen->id)->first();
        $asesmenPsikiatriDtl = RmeAsesmenPsikiatriDtl::where('id_asesmen', $asesmen->id)->first();

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        $dataMedis->waktu_masuk = Carbon::parse($dataMedis->TGL_MASUK . ' ' . $dataMedis->JAM_MASUK)->format('Y-m-d H:i:s');

        return view('unit-pelayanan.rawat-inap.pelayanan.asesmen-psikiatri.edit', compact(
            'kd_unit',
            'kd_pasien',
            'tgl_masuk',
            'urut_masuk',
            'id',
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
            'poliklinik',
            'user',
            'asesmen',
            'asesmenPsikiatri',
            'satsetPrognosis',
            'asesmenPsikiatriDtl'
        ));
    }


    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
            if (empty($dataMedis)) throw new Exception("Data kunjungan tidak ditemukan");

            $tanggal = $request->tanggal_masuk;
            $jam = $request->jam_masuk;
            $waktu_asesmen = $tanggal . ' ' . $jam;

            // Update data asesmen utama
            $dataAsesmen = RmeAsesmen::where('id', $id)
                ->where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->where('kategori', 1)
                ->where('sub_kategori', 11)
                ->first();

            if (!$dataAsesmen) {
                throw new \Exception('Data asesmen tidak ditemukan');
            }

            $dataAsesmen->user_id = Auth::id();
            $dataAsesmen->waktu_asesmen = $waktu_asesmen;
            $dataAsesmen->anamnesis = $request->anamnesis;
            $dataAsesmen->skala_nyeri = $request->skala_nyeri;
            $dataAsesmen->save();

            // Update atau create asesmen psikiatri
            $asesmenPsikiatri = RmeAsesmenPsikiatri::where('id_asesmen', $dataAsesmen->id)->first();
            if (!$asesmenPsikiatri) {
                $asesmenPsikiatri = new RmeAsesmenPsikiatri();
                $asesmenPsikiatri->id_asesmen = $dataAsesmen->id;
            }

            $asesmenPsikiatri->waktu_masuk = $waktu_asesmen;
            $asesmenPsikiatri->kondisi_masuk = $request->kondisi_masuk;
            $asesmenPsikiatri->diagnosis_masuk = $request->diagnosis_masuk;

            // Pengkajian Keperawatan
            $asesmenPsikiatri->anamnesis = $request->anamnesis;
            $asesmenPsikiatri->keluhan_utama = $request->keluhan_utama;
            $asesmenPsikiatri->sensorium = $request->sensorium;
            $asesmenPsikiatri->tekanan_darah_sistole = $request->tekanan_darah_sistole;
            $asesmenPsikiatri->tekanan_darah_diastole = $request->tekanan_darah_diastole;
            $asesmenPsikiatri->suhu = $request->suhu;
            $asesmenPsikiatri->respirasi = $request->respirasi;
            $asesmenPsikiatri->nadi = $request->nadi;
            $asesmenPsikiatri->skala_nyeri = $request->skala_nyeri;
            $asesmenPsikiatri->kategori_nyeri = $request->kategori_nyeri;
            $asesmenPsikiatri->alat_bantu = $request->alat_bantu;
            $asesmenPsikiatri->cacat_tubuh = $request->cacat_tubuh;
            $asesmenPsikiatri->adl = $request->adl;
            $asesmenPsikiatri->resiko_jatuh = $request->resiko_jatuh;
            $asesmenPsikiatri->save();

            // Update atau create asesmen psikiatri detail
            $asesmenPsikiatriDtl = RmeAsesmenPsikiatriDtl::where('id_asesmen', $dataAsesmen->id)->first();
            if (!$asesmenPsikiatriDtl) {
                $asesmenPsikiatriDtl = new RmeAsesmenPsikiatriDtl();
                $asesmenPsikiatriDtl->id_asesmen = $dataAsesmen->id;
            }

            // Pengkajian Medis
            $asesmenPsikiatriDtl->riwayat_penyakit_sekarang = $request->riwayat_penyakit_sekarang;
            $asesmenPsikiatriDtl->riwayat_penyakit_terdahulu = $request->riwayat_penyakit_terdahulu;
            $asesmenPsikiatriDtl->riwayat_penyakit_perkembangan_masa_kanak = $request->riwayat_penyakit_perkembangan_masa_kanak;
            $asesmenPsikiatriDtl->riwayat_penyakit_masa_dewasa = $request->riwayat_penyakit_masa_dewasa;
            $asesmenPsikiatriDtl->riwayat_kesehatan_keluarga = $request->riwayat_kesehatan_keluarga;
            $asesmenPsikiatriDtl->terapi_diberikan = $request->terapi_diberikan;

            // Pemeriksaan Fisik
            $asesmenPsikiatriDtl->pemeriksaan_psikiatri = $request->pemeriksaan_psikiatri;
            $asesmenPsikiatriDtl->status_internis = $request->status_internis;
            $asesmenPsikiatriDtl->status_neorologi = $request->status_neorologi;
            $asesmenPsikiatriDtl->pemeriksaan_penunjang = $request->pemeriksaan_penunjang;

            // Diagnosis
            $asesmenPsikiatriDtl->diagnosis_banding = $request->diagnosis_banding;
            $asesmenPsikiatriDtl->axis_i = $request->axis_i;
            $asesmenPsikiatriDtl->axis_ii = $request->axis_ii;
            $asesmenPsikiatriDtl->axis_iii = $request->axis_iii;
            $asesmenPsikiatriDtl->axis_iv = $request->axis_iv;
            $asesmenPsikiatriDtl->axis_v = $request->axis_v;

            // Prognosis dan Therapy
            $asesmenPsikiatriDtl->prognosis = $request->prognosis;
            $asesmenPsikiatriDtl->therapi = $request->therapi;
            $asesmenPsikiatriDtl->save();

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
            }

            $vitalSignData = [
                'sistole'      => $request->tekanan_darah_sistole ? (int)$request->tekanan_darah_sistole : null,
                'diastole'     => $request->tekanan_darah_diastole ? (int)$request->tekanan_darah_diastole : null,
                'nadi'         => $request->nadi ? (int)$request->nadi : null,
                'respiration'  => $request->respirasi ? (int)$request->respirasi : null,
                'suhu'         => $request->suhu ? (float)$request->suhu : null,
                'tinggi_badan' => $request->tinggi_badan ? (int)$request->tinggi_badan : null,
                'berat_badan'  => $request->berat_badan ? (int)$request->berat_badan : null,
            ];

            $this->asesmenService->store(
                $vitalSignData,
                $kd_pasien,
                $dataMedis->no_transaksi,
                $dataMedis->kd_kasir
            );

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

            return redirect()->to(url("unit-pelayanan/rawat-inap/unit/$kd_unit/pelayanan/$kd_pasien/$tgl_masuk/$urut_masuk/asesmen/medis/umum"))
                ->with('success', 'Data asesmen Psikiatri berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal mengupdate data asesmen: ' . $e->getMessage())->withInput();
        }
    }


    public function show(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
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

        // Mengambil data asesmen psikiatri
        $asesmen = RmeAsesmen::where('id', $id) // TAMBAHKAN PARAMETER ID
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->where('kategori', 2)
            ->where('sub_kategori', 11)
            ->with('user')
            ->first();

        if (!$asesmen) {
            abort(404, 'Data asesmen psikiatri tidak ditemukan');
        }

        $asesmenPsikiatri = RmeAsesmenPsikiatri::where('id_asesmen', $asesmen->id)->first();
        $asesmenPsikiatriDtl = RmeAsesmenPsikiatriDtl::where('id_asesmen', $asesmen->id)->first();
        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        $dataMedis->waktu_masuk = Carbon::parse($dataMedis->TGL_MASUK . ' ' . $dataMedis->JAM_MASUK)->format('Y-m-d H:i:s');

        return view('unit-pelayanan.rawat-inap.pelayanan.asesmen-psikiatri.show', compact(
            'kd_unit',
            'kd_pasien',
            'tgl_masuk',
            'urut_masuk',
            'dataMedis',
            'user',
            'asesmen',
            'asesmenPsikiatri',
            'asesmenPsikiatriDtl',
            'alergiPasien'
        ));
    }
}
