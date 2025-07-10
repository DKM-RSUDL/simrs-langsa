<?php

namespace App\Http\Controllers\UnitPelayanan\RawatJalan;

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
use App\Models\RMEResume;
use App\Models\RmeResumeDtl;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AsesmenKulitKelaminController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-jalan');
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

        return view('unit-pelayanan.rawat-jalan.pelayanan.asesmen-kulitkelamin.create', compact(
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
            'user'
        ));
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        DB::beginTransaction();

        try {
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
            $dataAsesmen->sub_kategori = 10;
            $dataAsesmen->anamnesis = $request->anamnesis;
            $dataAsesmen->skala_nyeri = $request->skala_nyeri;
            $dataAsesmen->save();


            $dataKulitKelamin = new RmeAsesmenKulitKelamin();
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
            $dataKulitKelamin->save();

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
            $implementasiData = [
                'prognosis' => json_decode($request->prognosis ?? '[]', true),
                'observasi' => json_decode($request->observasi ?? '[]', true),
                'terapeutik' => json_decode($request->terapeutik ?? '[]', true),
                'edukasi' => json_decode($request->edukasi ?? '[]', true),
                'kolaborasi' => json_decode($request->kolaborasi ?? '[]', true)
            ];

            foreach ($implementasiData as $column => $dataList) {
                foreach ($dataList as $item) {
                    $existingImplementasi = RmeMasterImplementasi::where($column, $item)->first();
                    if (!$existingImplementasi) {
                        $masterImplementasi = new RmeMasterImplementasi();
                        $masterImplementasi->$column = $item;
                        $masterImplementasi->save();
                    }
                }
            }

            //Simpan ke table RmePemeriksaanFisik
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


            // Simpan ke table RmeAsesmenRencanaPulang
            $asesmenRencana = new RmeAsesmenKulitKelaminRencanaPulang();
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


            // RESUME
            $resumeData = [
                'anamnesis'             => $request->anamnesis,
                'diagnosis'             => [],
                'tindak_lanjut_code'    => null,
                'tindak_lanjut_name'    => null,
                'tgl_kontrol_ulang'     => null,
                'unit_rujuk_internal'   => null,
                'rs_rujuk'              => null,
                'rs_rujuk_bagian'       => null,
                'konpas'                => [
                    'sistole'   => [
                        'hasil' => $request->sistole
                    ],
                    'distole'   => [
                        'hasil' => $request->diastole
                    ],
                    'respiration_rate'   => [
                        'hasil' => ''
                    ],
                    'suhu'   => [
                        'hasil' => $request->suhu
                    ],
                    'nadi'   => [
                        'hasil' => $request->nadi
                    ],
                    'tinggi_badan'   => [
                        'hasil' => $request->tinggi_badan
                    ],
                    'berat_badan'   => [
                        'hasil' => $request->berat_badan
                    ]
                ]
            ];

            $this->createResume($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $resumeData);

            DB::commit();

            return redirect()->to(url("unit-pelayanan/rawat-jalan/unit/$kd_unit/pelayanan/$kd_pasien/$tgl_masuk/$urut_masuk/asesmen"))
                ->with('success', 'Data asesmen anak berhasil disimpan');
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

    public function show($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
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

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        $dataMedis->waktu_masuk = Carbon::parse($dataMedis->TGL_MASUK . ' ' . $dataMedis->JAM_MASUK)->format('Y-m-d H:i:s');

        // Ambil data asesmen
        $asesmen = RmeAsesmen::where('id', $id) // Gunakan ID spesifik
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->where('kategori', 1)
            ->where('sub_kategori', 10)
            ->first();

        if (!$asesmen) {
            return redirect()->back()->with('error', 'Data asesmen tidak ditemukan');
        }

        // Ambil data detail asesmen kulit kelamin
        $asesmenKulitKelamin = RmeAsesmenKulitKelamin::where('id_asesmen', $asesmen->id)->first();

        if (!$asesmenKulitKelamin) {
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
        $prognosis = json_decode($asesmenKulitKelamin->prognosis ?? '[]', true);
        $observasi = json_decode($asesmenKulitKelamin->observasi ?? '[]', true);
        $terapeutik = json_decode($asesmenKulitKelamin->terapeutik ?? '[]', true);
        $edukasi = json_decode($asesmenKulitKelamin->edukasi ?? '[]', true);
        $kolaborasi = json_decode($asesmenKulitKelamin->kolaborasi ?? '[]', true);
        $riwayatPenggunaanObat = json_decode($asesmenKulitKelamin->riwayat_penggunaan_obat ?? '[]', true);
        $riwayatKesehatanKeluarga = json_decode($asesmenKulitKelamin->riwayat_penyakit_keluarga ?? '[]', true);

        return view('unit-pelayanan.rawat-jalan.pelayanan.asesmen-kulitkelamin.show', compact(
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
            'prognosis',
            'observasi',
            'terapeutik',
            'edukasi',
            'kolaborasi',
            'riwayatPenggunaanObat',
            'riwayatKesehatanKeluarga',
            'siteMarkingData',
            'user'
        ));
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

        // Ambil data asesmen
        $asesmen = RmeAsesmen::where('id', $id)
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->where('kategori', 1)
            ->where('sub_kategori', 10)
            ->first();

        if (!$asesmen) {
            return redirect()->back()->with('error', 'Data asesmen tidak ditemukan');
        }

        // Ambil data detail asesmen kulit kelamin
        $asesmenKulitKelamin = RmeAsesmenKulitKelamin::where('id_asesmen', $asesmen->id)->first();

        if (!$asesmenKulitKelamin) {
            return redirect()->back()->with('error', 'Data asesmen kulit kelamin tidak ditemukan');
        }

        // Ambil data pemeriksaan fisik
        $pemeriksaanFisik = RmeAsesmenPemeriksaanFisik::where('id_asesmen', $asesmen->id)
            ->get()
            ->keyBy('id_item_fisik');

        // Ambil data rencana pulang
        $rencanaPulang = RmeAsesmenKulitKelaminRencanaPulang::where('id_asesmen', $asesmen->id)->first();

        return view('unit-pelayanan.rawat-jalan.pelayanan.asesmen-kulitkelamin.edit', compact(
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
            'user'
        ));
    }

    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            // Validasi asesmen exists
            $asesmen = RmeAsesmen::where('id', $id)
                ->where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->where('kategori', 1)
                ->where('sub_kategori', 10)
                ->first();

            if (!$asesmen) {
                return redirect()->back()->with('error', 'Data asesmen tidak ditemukan');
            }

            $tanggal = $request->tanggal_masuk;
            $jam = $request->jam_masuk;
            $waktu_asesmen = $tanggal . ' ' . $jam;

            // Update data asesmen utama
            $asesmen->user_id = Auth::id();
            $asesmen->waktu_asesmen = $waktu_asesmen;
            $asesmen->anamnesis = $request->anamnesis;
            $asesmen->skala_nyeri = $request->skala_nyeri;
            $asesmen->save();

            // Update atau create data kulit kelamin
            $dataKulitKelamin = RmeAsesmenKulitKelamin::where('id_asesmen', $asesmen->id)->first();

            if (!$dataKulitKelamin) {
                $dataKulitKelamin = new RmeAsesmenKulitKelamin();
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
            $dataKulitKelamin->save();

            // Update Diagnosa ke Master (sama seperti store)
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

            // Update Implementasi ke Master
            $implementasiData = [
                'prognosis' => json_decode($request->prognosis ?? '[]', true),
                'observasi' => json_decode($request->observasi ?? '[]', true),
                'terapeutik' => json_decode($request->terapeutik ?? '[]', true),
                'edukasi' => json_decode($request->edukasi ?? '[]', true),
                'kolaborasi' => json_decode($request->kolaborasi ?? '[]', true)
            ];

            foreach ($implementasiData as $column => $dataList) {
                foreach ($dataList as $item) {
                    $existingImplementasi = RmeMasterImplementasi::where($column, $item)->first();
                    if (!$existingImplementasi) {
                        $masterImplementasi = new RmeMasterImplementasi();
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
            $asesmenRencana = RmeAsesmenKulitKelaminRencanaPulang::where('id_asesmen', $asesmen->id)->first();

            if (!$asesmenRencana) {
                $asesmenRencana = new RmeAsesmenKulitKelaminRencanaPulang();
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
                'anamnesis'             => $request->anamnesis,
                'diagnosis'             => [],
                'tindak_lanjut_code'    => null,
                'tindak_lanjut_name'    => null,
                'tgl_kontrol_ulang'     => null,
                'unit_rujuk_internal'   => null,
                'rs_rujuk'              => null,
                'rs_rujuk_bagian'       => null,
                'konpas'                => [
                    'sistole'   => [
                        'hasil' => $request->sistole
                    ],
                    'distole'   => [
                        'hasil' => $request->diastole
                    ],
                    'respiration_rate'   => [
                        'hasil' => ''
                    ],
                    'suhu'   => [
                        'hasil' => $request->suhu
                    ],
                    'nadi'   => [
                        'hasil' => $request->nadi
                    ],
                    'tinggi_badan'   => [
                        'hasil' => $request->tinggi_badan
                    ],
                    'berat_badan'   => [
                        'hasil' => $request->berat_badan
                    ]
                ]
            ];

            $this->createResume($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $resumeData);

            DB::commit();

            return redirect()->route('rawat-jalan.asesmen.medis.kulit-kelamin.show', [
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
                'id' => $id
            ])->with('success', 'Data asesmen kulit kelamin berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui data asesmen: ' . $e->getMessage());
        }
    }
}
