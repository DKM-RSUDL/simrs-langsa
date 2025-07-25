<?php

namespace App\Http\Controllers\UnitPelayanan\RawatJalan;

use App\Http\Controllers\Controller;
use App\Models\DataTriase;
use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\MrItemFisik;
use App\Models\RmeAsesmen;
use App\Models\RmeAsesmenDtl;
use App\Models\RmeAsesmenPemeriksaanFisik;
use App\Models\RmeEfekNyeri;
use App\Models\RmeFaktorPemberat;
use App\Models\RmeFaktorPeringan;
use App\Models\RmeFrekuensiNyeri;
use App\Models\RmeKualitasNyeri;
use App\Models\RmeMenjalar;
use App\Models\RMEResume;
use App\Models\RmeResumeDtl;
use App\Models\SegalaOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AsesmenController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-jalan');
    }

    public function index($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
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
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', $kd_unit)
            ->where('kunjungan.urut_masuk', $urut_masuk)
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

        // Mengambil nama alergen dari riwayat_alergi
        if ($dataMedis->riwayat_alergi) {
            $dataMedis->riwayat_alergi = collect(json_decode($dataMedis->riwayat_alergi, true))
                ->pluck('alergen')
                ->all();
        } else {
            $dataMedis->riwayat_alergi = [];
        }

        $dataMedis->waktu_masuk = Carbon::parse($dataMedis->TGL_MASUK . ' ' . $dataMedis->JAM_MASUK)->format('Y-m-d H:i:s');
        $dokter = Dokter::where('status', 1)->get();
        $triageClass = $this->getTriageClass($dataMedis->kd_triase);
        $riwayatObat = $this->getRiwayatObat($kd_pasien);
        $laborData = $this->getLabor($kd_pasien);
        $radiologiData = $this->getRadiologi($kd_pasien);
        $itemFisik = MrItemFisik::orderby('urut')->get();
        $menjalar = RmeMenjalar::all();
        $frekuensinyeri = RmeFrekuensiNyeri::all();
        $kualitasnyeri = RmeKualitasNyeri::all();
        $faktorpemberat = RmeFaktorPemberat::all();
        $faktorperingan = RmeFaktorPeringan::all();
        $efeknyeri = RmeEfekNyeri::all();

        // Mengambil asesmen dengan join ke data_triase untuk mendapatkan tanggal_triase
        // $asesmen = RmeAsesmen::with(['user']) // Pastikan relasi user tersedia
        // ->join('data_triase', 'RME_ASESMEN.id', '=', 'data_triase.id_asesmen')
        // ->where('RME_ASESMEN.kd_pasien', $kd_pasien)
        //     ->select('RME_ASESMEN.*', 'data_triase.tanggal_triase') // Pilih kolom yang dibutuhkan, termasuk tanggal_triase
        //     ->orderBy('data_triase.tanggal_triase', 'desc') // Urutkan berdasarkan tanggal triase terbaru
        //     ->get();

        $asesmen = RmeAsesmen::with(['user'])
            ->leftJoin('data_triase', 'RME_ASESMEN.id', '=', 'data_triase.id_asesmen')
            ->where('RME_ASESMEN.kd_pasien', $kd_pasien)
            ->select(
                'RME_ASESMEN.*',
                'data_triase.tanggal_triase',
                'data_triase.id as id_triase'
            )
            ->orderBy('id', 'desc')
            ->get();

        return view('unit-pelayanan.rawat-jalan.pelayanan.asesmen.index', compact(
            'dataMedis',
            'dokter',
            'triageClass',
            'riwayatObat',
            'laborData',
            'radiologiData',
            'itemFisik',
            'menjalar',
            'frekuensinyeri',
            'kualitasnyeri',
            'faktorpemberat',
            'faktorperingan',
            'efeknyeri',
            'asesmen'
        ));
    }

    public function store($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {

        try {
            $user = auth()->user();

            $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
                ->join('transaksi as t', function ($join) {
                    $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                    $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                    $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                    $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
                })
                ->leftJoin('dokter', 'kunjungan.KD_DOKTER', '=', 'dokter.KD_DOKTER')
                ->leftJoin('data_triase', 'kunjungan.kd_pasien', '=', 'data_triase.kd_pasien_triase')
                ->select('kunjungan.*', 't.*', 'dokter.NAMA as nama_dokter', 'data_triase.foto_pasien', 'data_triase.status', 'data_triase.usia_bulan')
                ->where('kunjungan.kd_unit', $kd_unit)
                ->where('kunjungan.kd_pasien', $kd_pasien)
                ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
                ->first();
            if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
                $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
            } else {
                $dataMedis->pasien->umur = 'Tidak Diketahui';
            }

            // dd( $request->vital_sign);

            $asesmen = new RmeAsesmen();
            $asesmen->kd_pasien = $dataMedis->kd_pasien;
            $asesmen->kd_unit = $dataMedis->kd_unit;
            $asesmen->tgl_masuk = $dataMedis->tgl_masuk;
            $asesmen->urut_masuk = $dataMedis->urut_masuk;
            $asesmen->tindakan_resusitasi = $request->tindakan_resusitasi;
            $asesmen->anamnesis = $request->anamnesis;
            $asesmen->riwayat_penyakit = $request->riwayat_penyakit;
            $asesmen->riwayat_pengobatan = $request->riwayat_pengobatan;
            $asesmen->riwayat_alergi = $request->riwayat_alergi;
            $asesmen->vital_sign = $request->vital_sign;
            $asesmen->antropometri = $request->antropometri;
            $asesmen->skala_nyeri = $request->skala_nyeri;
            $asesmen->lokasi = $request->lokasi;
            $asesmen->durasi = $request->durasi;
            $asesmen->menjalar_id = $request->menjalar;
            $asesmen->frekuensi_nyeri_id = $request->frekuensi;
            $asesmen->kualitas_nyeri_id = $request->kualitas;
            $asesmen->faktor_pemberat_id = $request->faktor_pemberat;
            $asesmen->faktor_peringan_id = $request->faktor_peringan;
            $asesmen->efek_nyeri = $request->efek_nyeri;
            $asesmen->diagnosis = $request->diagnosa_data;
            $asesmen->alat_terpasang = $request->alat_terpasang_data;
            $asesmen->kondisi_pasien = $request->kondisi_pasien;
            $asesmen->user_id = $user->id;
            $asesmen->save();

            // dd($asesmen->all());

            $pemeriksaanFisik = json_decode($request->pemeriksaan_fisik, true);
            if (is_array($pemeriksaanFisik)) {
                foreach ($pemeriksaanFisik as $itemFisik) {
                    $id_item_fisik = filter_var($itemFisik['id'], FILTER_VALIDATE_INT);
                    $is_normal = filter_var($itemFisik['is_normal'], FILTER_VALIDATE_INT);

                    if ($id_item_fisik === false || $is_normal === false) {
                        continue;
                    }

                    RmeAsesmenPemeriksaanFisik::create([
                        'id_asesmen' => $asesmen->id,
                        'id_item_fisik' => $id_item_fisik,
                        'is_normal' => $is_normal,
                        'keterangan' => $itemFisik['keterangan'] ?? null,
                    ]);
                }
            } else {
                return response()->json(['message' => 'Pemeriksaan Fisik harus berupa array'], 400);
            }

            // Simpan data triase
            $reTriaseData = json_decode($request->retriage_data, true);
            if ($reTriaseData) {
                foreach ($reTriaseData as $reTriase) {
                    $triase = new DataTriase();
                    $triase->id_asesmen = $asesmen->id;
                    $triase->nama_pasien = $dataMedis->pasien->nama;
                    $triase->usia = $dataMedis->pasien->umur;
                    $triase->jenis_kelamin = $dataMedis->pasien->jenis_kelamin;
                    $triase->tanggal_lahir = $dataMedis->pasien->tgl_lahir;
                    $formattedDate = Carbon::createFromFormat('m/d/Y, h:i:s A', $reTriase['tanggalJam'])->format('Y-m-d H:i:s');
                    $triase->tanggal_triase = $formattedDate;
                    $triase->dokter_triase = $dataMedis->dokter->kd_dokter;
                    $triase->kd_pasien_triase = $dataMedis->kd_pasien;
                    $triase->status = $dataMedis->status;
                    $triase->usia_bulan = $dataMedis->usia_bulan;
                    $triase->foto_pasien = $dataMedis->foto_pasien;
                    $triase->hasil_triase = $reTriase['triase']['ket_triase'];
                    $triase->kode_triase = $reTriase['triase']['kode_triase'];
                    $triase->anamnesis_retriase = $reTriase['keluhan'];
                    $triase->catatan_retriase = $reTriase['catatan'];
                    $triase->vitalsign_retriase = json_encode($reTriase['vitalSigns']);

                    $triaseData = [
                        'hasil_triase' => $reTriase['triase']['ket_triase'],
                        'kode_triase' => $reTriase['triase']['kode_triase'],
                        'air_way' => $reTriase['triase']['air_way'],
                        'breathing' => $reTriase['triase']['breathing'],
                        'circulation' => $reTriase['triase']['circulation'],
                        'disability' => $reTriase['triase']['disability']
                    ];
                    $triase->triase = json_encode($triaseData);

                    $triase->save();
                }
            }

            //simpan tindak lanjut
            $tindakLanjutData = json_decode($request->tindak_lanjut_data, true);
            if ($tindakLanjutData) {
                $tindakLanjutDtl = new RmeAsesmenDtl();
                $tindakLanjutDtl->id_asesmen = $asesmen->id;

                switch ($tindakLanjutData['option']) {
                    case 'rawatInap':
                        $tindakLanjutDtl->tindak_lanjut_code = 1;
                        $tindakLanjutDtl->tindak_lanjut_name = 'Rawat Inap';
                        break;
                    case 'pulangKontrol':
                        $tindakLanjutDtl->tindak_lanjut_code = 2;
                        $tindakLanjutDtl->tindak_lanjut_name = 'Kontrol Ulang';
                        break;
                    case 'rujukKeluar':
                        $tindakLanjutDtl->tindak_lanjut_code = 5;
                        $tindakLanjutDtl->tindak_lanjut_name = 'Rujuk RS Lain';
                        break;
                    case 'kamarOperasi':
                        $tindakLanjutDtl->tindak_lanjut_code = 4;
                        $tindakLanjutDtl->tindak_lanjut_name = 'Rujuk Internal';
                        break;
                    case 'menolakRawatInap':
                    case 'meninggalDunia':
                        $tindakLanjutDtl->tindak_lanjut_code = 3;
                        $tindakLanjutDtl->tindak_lanjut_name = 'Selesai di Unit';
                        break;
                    default:
                        $tindakLanjutDtl->tindak_lanjut_code = null;
                        $tindakLanjutDtl->tindak_lanjut_name = $tindakLanjutData['option'];
                }

                if (isset($tindakLanjutData['keterangan'])) {
                    $tindakLanjutDtl->keterangan = $tindakLanjutData['keterangan'];
                }

                if (isset($tindakLanjutData['tanggalMeninggal']) && isset($tindakLanjutData['jamMeninggal'])) {
                    $tindakLanjutDtl->tanggal_meninggal = $tindakLanjutData['tanggalMeninggal'];
                    $tindakLanjutDtl->jam_meninggal = $tindakLanjutData['jamMeninggal'];
                }

                $tindakLanjutDtl->save();
            }

            $vitalSign = json_decode($request->vital_sign, true);
            $antropometri = json_decode($request->antropometri, true);
            $diagnosa = json_decode($request->diagnosa_data, true);

            // create resume
            $resumeData = [
                'anamnesis'             => $request->anamnesis,
                'diagnosis'             => $diagnosa,
                'tindak_lanjut_code'    => $tindakLanjutDtl->tindak_lanjut_code,
                'tindak_lanjut_name'    => $tindakLanjutDtl->tindak_lanjut_name,
                'tgl_kontrol_ulang'     => null,
                'unit_rujuk_internal'   => null,
                'rs_rujuk'              => null,
                'rs_rujuk_bagian'       => null,
                'konpas'                => [
                    'sistole'   => [
                        'hasil' => $vitalSign['td_sistole']
                    ],
                    'distole'   => [
                        'hasil' => $vitalSign['td_diastole']
                    ],
                    'respiration_rate'   => [
                        'hasil' => $vitalSign['resp']
                    ],
                    'suhu'   => [
                        'hasil' => $vitalSign['suhu']
                    ],
                    'nadi'   => [
                        'hasil' => $vitalSign['nadi']
                    ],
                    'tinggi_badan'   => [
                        'hasil' => $antropometri['tb']
                    ],
                    'berat_badan'   => [
                        'hasil' => $antropometri['bb']
                    ]
                ]
            ];

            $this->createResume($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $resumeData);
            return response()->json(['message' => 'Berhasil']);

            // DB::commit();
        } catch (\Exception $e) {
            // DB::rollBack();
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function show($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            // Parse tanggal tanpa waktu
            $date = Carbon::parse($tgl_masuk)->format('Y-m-d');

            $asesmen = RmeAsesmen::with([
                'menjalar',
                'frekuensiNyeri',
                'kualitasNyeri',
                'faktorPemberat',
                'faktorPeringan',
                'efekNyeri',
                'tindaklanjut'
            ])
                ->where('id', $id)
                ->where('kd_pasien', $kd_pasien)
                ->whereDate('tgl_masuk', $date)
                ->firstOrFail();


            $tindakanResusitasi = is_string($asesmen->tindakan_resusitasi)
                ? json_decode($asesmen->tindakan_resusitasi, true)
                : $asesmen->tindakan_resusitasi;

            $riwayatAlergi = is_string($asesmen->riwayat_alergi)
                ? json_decode($asesmen->riwayat_alergi, true)
                : $asesmen->riwayat_alergi;

            $alatTerpasang = is_string($asesmen->alat_terpasang)
                ? json_decode($asesmen->alat_terpasang, true)
                : $asesmen->alat_terpasang;

            $retriaseData = DataTriase::where('id_asesmen', $id)->get();

            $pemeriksaanFisik = RmeAsesmenPemeriksaanFisik::with('itemFisik')
                ->where('id_asesmen', $id)
                ->get()
                ->map(function ($item) {
                    return [
                        'id_item_fisik' => $item->id_item_fisik,
                        'nama_item' => $item->itemFisik->nama ?? 'Tidak Diketahui',
                        'is_normal' => $item->is_normal,
                        'keterangan' => $item->keterangan
                    ];
                });

            return response()->json([
                'status' => 'success',
                'data' => [
                    'asesmen' => [
                        'asesmen' => $asesmen,
                        'tindakan_resusitasi' => $tindakanResusitasi,
                        'anamnesis' => $asesmen->anamnesis,
                        'riwayat_penyakit' => $asesmen->riwayat_penyakit,
                        'riwayat_pengobatan' => $asesmen->riwayat_pengobatan,
                        'riwayat_alergi' => $riwayatAlergi,
                        'vital_sign' => json_decode($asesmen->vital_sign, true),
                        'antropometri' => json_decode($asesmen->antropometri, true),
                        'show_skala_nyeri' => $asesmen->skala_nyeri,
                        'show_lokasi' => $asesmen->lokasi,
                        'show_durasi' => $asesmen->durasi,
                        'show_menjalar' => $asesmen->menjalar ? $asesmen->menjalar->name : null,
                        'show_frekuensi' => $asesmen->frekuensiNyeri ? $asesmen->frekuensiNyeri->name : null,
                        'show_kualitas' => $asesmen->kualitasNyeri ? $asesmen->kualitasNyeri->name : null,
                        'show_faktor_pemberat' => $asesmen->faktorPemberat ? $asesmen->faktorPemberat->name : null,
                        'show_faktor_peringan' => $asesmen->faktorPeringan ? $asesmen->faktorPeringan->name : null,
                        'show_efek_nyeri' => $asesmen->efekNyeri ? $asesmen->efekNyeri->name : null,
                        'show_diagnosis' => json_decode($asesmen->diagnosis, true),
                        'retriase_data' => $retriaseData,
                        'alat_terpasang' => $alatTerpasang,
                        'show_kondisi_pasien' => $asesmen->kondisi_pasien,
                        'tindaklanjut' => $asesmen->tindaklanjut,
                        'pemeriksaan_fisik' => $pemeriksaanFisik

                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 404);
        }
    }

    public function update($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id, Request $request)
    {
        // DB::beginTransaction();
        // dd($kd_unit);
        try {

            $asesmen = RmeAsesmen::where('id', $id)
                ->where('kd_pasien', $kd_pasien)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->firstOrFail();

            $dataMedis = Kunjungan::with(['pasien', 'dokter'])
                ->where('kd_pasien', $kd_pasien)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->first();

            $updateData = [
                'tindakan_resusitasi' => json_encode($request->tindakan_resusitasi),
                'anamnesis' => $request->anamnesis,
                'skala_nyeri' => $request->skala_nyeri,
                'lokasi' => $request->lokasi,
                'durasi' => $request->durasi,
                'riwayat_penyakit' => $request->riwayat_penyakit,
                'riwayat_pengobatan' => $request->riwayat_pengobatan,
                'vital_sign' => json_encode($request->vital_sign),
                'antropometri' => json_encode($request->antropometri),
                'riwayat_alergi' => json_encode($request->riwayat_alergi),
                'menjalar_id' => $request->menjalar_id,
                'frekuensi_nyeri_id' => $request->frekuensi_nyeri_id,
                'kualitas_nyeri_id' => $request->kualitas_nyeri_id,
                'faktor_pemberat_id' => $request->faktor_pemberat_id,
                'faktor_peringan_id' => $request->faktor_peringan_id,
                'efek_nyeri' => $request->efek_nyeri,
                'diagnosis' => json_encode($request->diagnosis),
                'alat_terpasang' => json_encode($request->alat_terpasang),
                'kondisi_pasien' => $request->kondisi_pasien,
            ];

            $asesmen->update($updateData);

            if ($request->has('retriase_data')) {
                // Get existing retriase data to compare
                $existingRetriase = DataTriase::where('id_asesmen', $id)->get();

                foreach ($request->retriase_data as $retriaseData) {
                    // Check if this is a new retriase data
                    $isNewData = true;
                    foreach ($existingRetriase as $existing) {
                        // Compare relevant fields to determine if it's new data
                        if (
                            $existing->tanggal_triase === $retriaseData['tanggal_triase'] &&
                            $existing->hasil_triase === $retriaseData['hasil_triase'] &&
                            $existing->kode_triase === $retriaseData['kode_triase']
                        ) {
                            $isNewData = false;
                            break;
                        }
                    }

                    // If it's new data, insert it
                    if ($isNewData) {
                        $triase = new DataTriase();
                        $triase->id_asesmen = $id;
                        $triase->nama_pasien = $dataMedis->pasien->nama;
                        $triase->usia = $dataMedis->pasien->umur ?? 0;
                        $triase->jenis_kelamin = $dataMedis->pasien->jenis_kelamin;
                        $triase->tanggal_lahir = $dataMedis->pasien->tgl_lahir;
                        $triase->tanggal_triase = $retriaseData['tanggal_triase'];
                        $triase->dokter_triase = $dataMedis->dokter->kd_dokter;
                        $triase->kd_pasien_triase = $kd_pasien;
                        $triase->status = 1;
                        $triase->usia_bulan = $dataMedis->usia_bulan ?? 0;
                        $triase->foto_pasien = $dataMedis->foto_pasien ?? null;
                        $triase->hasil_triase = $retriaseData['hasil_triase'];
                        $triase->kode_triase = $retriaseData['kode_triase'];
                        $triase->anamnesis_retriase = $retriaseData['anamnesis_retriase'];
                        $triase->catatan_retriase = $retriaseData['catatan_retriase'];
                        $triase->vitalsign_retriase = $retriaseData['vitalsign_retriase'];
                        $triase->triase = $retriaseData['triase'];
                        $triase->save();
                    }
                }
            }

            if ($request->has('tindak_lanjut')) {
                $tindakLanjutData = $request->tindak_lanjut;

                $tindakLanjutDtl = RmeAsesmenDtl::firstOrNew(['id_asesmen' => $id]);

                switch ($tindakLanjutData['option']) {
                    case 'rawatInap':
                        $tindakLanjutDtl->tindak_lanjut_code = 1;
                        $tindakLanjutDtl->tindak_lanjut_name = 'Rawat Inap';
                        break;
                    case 'pulangKontrol':
                        $tindakLanjutDtl->tindak_lanjut_code = 2;
                        $tindakLanjutDtl->tindak_lanjut_name = 'Kontrol Ulang';
                        break;
                    case 'rujukKeluar':
                        $tindakLanjutDtl->tindak_lanjut_code = 5;
                        $tindakLanjutDtl->tindak_lanjut_name = 'Rujuk RS Lain';
                        break;
                    case 'kamarOperasi':
                        $tindakLanjutDtl->tindak_lanjut_code = 4;
                        $tindakLanjutDtl->tindak_lanjut_name = 'Rujuk Internal';
                        break;
                    case 'menolakRawatInap':
                    case 'meninggalDunia':
                        $tindakLanjutDtl->tindak_lanjut_code = 3;
                        $tindakLanjutDtl->tindak_lanjut_name = 'Selesai di Unit';
                        break;
                    default:
                        $tindakLanjutDtl->tindak_lanjut_code = null;
                        $tindakLanjutDtl->tindak_lanjut_name = $tindakLanjutData['option'];
                }

                // Update keterangan jika ada
                if (isset($tindakLanjutData['keterangan'])) {
                    $tindakLanjutDtl->keterangan = $tindakLanjutData['keterangan'];
                }

                if (isset($tindakLanjutData['tanggalMeninggal'])) {
                    $tindakLanjutDtl->tanggal_meninggal = $tindakLanjutData['tanggalMeninggal'];
                }
                if (isset($tindakLanjutData['jamMeninggal'])) {
                    $tindakLanjutDtl->jam_meninggal = $tindakLanjutData['jamMeninggal'];
                }

                $tindakLanjutDtl->save();
            }

            if ($request->has('pemeriksaan_fisik')) {
                foreach ($request->pemeriksaan_fisik as $item) {
                    // Clear 'keterangan' if 'is_normal' is set to 1 (normal)
                    $keterangan = $item['is_normal'] == 1 ? '' : $item['keterangan'];

                    // Update or create each 'pemeriksaan_fisik' record
                    RmeAsesmenPemeriksaanFisik::updateOrCreate(
                        [
                            'id_asesmen' => $id,
                            'id_item_fisik' => $item['id_item_fisik'],
                        ],
                        [
                            'is_normal' => $item['is_normal'],
                            'keterangan' => $keterangan,
                        ]
                    );
                }
            }

            $vitalSign = $request->vital_sign;
            $antropometri = $request->antropometri;
            $diagnosa = $request->diagnosis;

            // create resume
            $resumeData = [
                'anamnesis'             => $request->anamnesis,
                'diagnosis'             => $diagnosa,
                'tindak_lanjut_code'    => $tindakLanjutDtl->tindak_lanjut_code,
                'tindak_lanjut_name'    => $tindakLanjutDtl->tindak_lanjut_name,
                'tgl_kontrol_ulang'     => null,
                'unit_rujuk_internal'   => null,
                'rs_rujuk'              => null,
                'rs_rujuk_bagian'       => null,
                'konpas'                => [
                    'sistole'   => [
                        'hasil' => $vitalSign['td_sistole']
                    ],
                    'distole'   => [
                        'hasil' => $vitalSign['td_diastole']
                    ],
                    'respiration_rate'   => [
                        'hasil' => $vitalSign['resp']
                    ],
                    'suhu'   => [
                        'hasil' => $vitalSign['suhu']
                    ],
                    'nadi'   => [
                        'hasil' => $vitalSign['nadi']
                    ],
                    'tinggi_badan'   => [
                        'hasil' => $antropometri['tb']
                    ],
                    'berat_badan'   => [
                        'hasil' => $antropometri['bb']
                    ]
                ]
            ];

            $this->createResume($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $resumeData);

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil diupdate'
            ]);
        } catch (\Exception $e) {
            // DB::rollback();

            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengupdate data: ' . $e->getMessage()
            ], 500);
        }
    }

    private function getTriageClass($kdTriase)
    {
        switch ($kdTriase) {
            case 5:
                return 'bg-dark';
            case 4:
                return 'bg-danger';
            case 3:
                return 'bg-danger';
            case 2:
                return 'bg-warning';
            case 1:
                return 'bg-success';
        }
    }

    private function getRiwayatObat($kd_pasien)
    {
        return DB::table('MR_RESEP')
            ->join('DOKTER', 'MR_RESEP.KD_DOKTER', '=', 'DOKTER.KD_DOKTER')
            ->leftJoin('MR_RESEPDTL', 'MR_RESEP.ID_MRRESEP', '=', 'MR_RESEPDTL.ID_MRRESEP')
            ->leftJoin('APT_OBAT', 'MR_RESEPDTL.KD_PRD', '=', 'APT_OBAT.KD_PRD')
            ->where('MR_RESEP.KD_PASIEN', $kd_pasien)
            ->select(
                DB::raw('DISTINCT MR_RESEP.TGL_MASUK'),
                'MR_RESEP.KD_DOKTER',
                'DOKTER.NAMA as NAMA_DOKTER',
                'MR_RESEP.TGL_ORDER',
                'MR_RESEPDTL.CARA_PAKAI',
                'MR_RESEPDTL.JUMLAH_TAKARAN',
                'MR_RESEPDTL.SATUAN_TAKARAN',
                'APT_OBAT.NAMA_OBAT',
            )
            ->orderBy('MR_RESEP.TGL_MASUK', 'desc')
            ->get();
    }

    private function getLabor($kd_pasien)
    {
        return SegalaOrder::with(['details.produk', 'dokter', 'labHasil'])
            ->where('kd_pasien', $kd_pasien)
            ->orderBy('tgl_order', 'desc')
            ->get()
            ->map(function ($order) {
                $labHasil = $order->labHasil->sortByDesc('tgl_otoritas_det')->first();
                $namaPemeriksaan = $order->details->map(function ($detail) {
                    return $detail->produk->deskripsi ?? '';
                })->filter()->implode(', ');

                return [
                    'Tanggal-Jam' => $order->tgl_order->format('d M Y H:i'),
                    'Nama pemeriksaan' => $namaPemeriksaan,
                    'Status' => $this->getStatusOrder($order->status_order),
                    // 'Waktu Hasil' => $labHasil && $labHasil->tgl_otoritas_det ? $labHasil->tgl_otoritas_det->format('d M Y H:i') : '-',
                    'Dokter Pengirim' => $order->dokter->nama_lengkap ?? '',
                    'Cito/Non Cito' => $order->cyto == 1 ? 'Cyto' : 'Non-Cyto',
                    'No Order' => (int) $order->kd_order
                ];
            });
    }

    private function getStatusOrder($statusOrder)
    {
        if ($statusOrder == 1) {
            return 'Diorder';
        } elseif ($statusOrder == 0) {
            return 'Selesai';
        }
        return 'Unknown';
    }

    private function getRadiologi($kd_pasien)
    {
        return SegalaOrder::with(['details.produk', 'dokter'])
            ->where('kd_pasien', $kd_pasien)
            ->where('kategori', 'RD')
            ->orderBy('tgl_order', 'desc')
            ->get()
            ->map(function ($order) {
                $namaPemeriksaan = $order->details->map(function ($detail) {
                    return $detail->produk->deskripsi ?? '';
                })->filter()->implode(', ');

                return [
                    'Tanggal-Jam' => Carbon::parse($order->tgl_order)->format('d M Y H:i'),
                    'Nama Pemeriksaan' => $namaPemeriksaan,
                    'Status' => $this->getStatusOrderRadiologi($order->status_order),
                ];
            });
    }

    private function getStatusOrderRadiologi($statusOrder)
    {
        switch ($statusOrder) {
            case 0:
                return '<span class="text-warning">Diproses</span>';
            case 1:
                return '<span class="text-secondary">Diorder</span>';
            case 2:
                return '<span class="text-success">Selesai</span>';
            default:
                return '<span class="text-secondary">Unknown</span>';
        }
    }

    public function createResume($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $data)
    {

        // dd($kd_pasien);
        // get resume
        $resume = RMEResume::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->first();

        // dd($resume);

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