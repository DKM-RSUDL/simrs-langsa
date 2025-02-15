<?php

namespace App\Http\Controllers\UnitPelayanan\GawatDarurat;

use App\Http\Controllers\Controller;
use App\Models\AptObat;
use App\Models\DataTriase;
use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\ListTindakanPasien;
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
use App\Models\RmeSpri;
use App\Models\SegalaOrder;
use App\Models\Unit;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AsesmenController extends Controller
{
    public function index($kd_pasien, $tgl_masuk)
    {
        $user = auth()->user();

        // Mengambil data kunjungan dan tanggal triase terkait
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit', 'getVitalSign'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->leftJoin('dokter', 'kunjungan.KD_DOKTER', '=', 'dokter.KD_DOKTER')
            ->select('kunjungan.*', 't.*', 'dokter.NAMA as nama_dokter')
            ->where('kunjungan.kd_unit', 3)
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
        $tindakanData = $this->getTindakan($kd_pasien);
        $itemFisik = MrItemFisik::orderby('urut')->get();
        $menjalar = RmeMenjalar::all();
        $frekuensinyeri = RmeFrekuensiNyeri::all();
        $kualitasnyeri = RmeKualitasNyeri::all();
        $faktorpemberat = RmeFaktorPemberat::all();
        $faktorperingan = RmeFaktorPeringan::all();
        $efeknyeri = RmeEfekNyeri::all();
        $unitPoli = Unit::where('kd_bagian', '2')->where('aktif', 1)->get();

        // Mengambil asesmen dengan join ke data_triase untuk mendapatkan tanggal_triase
        $asesmen = RmeAsesmen::with(['user'])
        ->leftJoin('data_triase', 'RME_ASESMEN.id', '=', 'data_triase.id_asesmen')
        ->where('RME_ASESMEN.kd_pasien', $kd_pasien)
        ->select(
            'RME_ASESMEN.*',
            'data_triase.tanggal_triase',
            'data_triase.id as id_triase'
        )
        ->orderBy('RME_ASESMEN.waktu_asesmen', 'desc') 
        ->get();

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen.index', compact(
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
            'asesmen',
            'unitPoli',
            'tindakanData'
        ));
    }


    public function show($kd_pasien, $tgl_masuk, $id)
    {
        try {
            // Parse tanggal tanpa waktu
            $date = Carbon::parse($tgl_masuk)->format('Y-m-d');

            // Mengambil data kunjungan dan tanggal triase terkait
            $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=',
                    't.kd_pasien'
                );
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=',
                    't.tgl_transaksi'
                );
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->leftJoin('dokter', 'kunjungan.KD_DOKTER', '=', 'dokter.KD_DOKTER')
            ->select('kunjungan.*', 't.*', 'dokter.NAMA as nama_dokter')
            ->where('kunjungan.kd_unit', 3)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();

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
                        'riwayat_penyakit_keluarga' => $asesmen->riwayat_penyakit_keluarga,
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

                    ],
                    'dataMedis' => $dataMedis
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 404);
        }
    }

    public function update($kd_pasien, $tgl_masuk, $id, Request $request)
    {
        // DB::beginTransaction();
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
                'riwayat_penyakit_keluarga' => $request->riwayat_penyakit_keluarga,
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

            if ($request->has('tindak_lanjut_data')) {
                $tindakLanjutData = is_string($request->tindak_lanjut_data) ?
                json_decode($request->tindak_lanjut_data, true) :
                $request->tindak_lanjut_data;

                $tindakLanjutDtl = RmeAsesmenDtl::where('id_asesmen', $id)->first();
                if (!$tindakLanjutDtl) {
                    $tindakLanjutDtl = new RmeAsesmenDtl();
                    $tindakLanjutDtl->id_asesmen = $id;
                }

                if ($tindakLanjutData && isset($tindakLanjutData['option'])) {
                    switch ($tindakLanjutData['option']) {
                        case 'rawatInap':
                            $tindakLanjutDtl->tindak_lanjut_code = 1;
                            $tindakLanjutDtl->tindak_lanjut_name = 'Rawat Inap';

                            $spri = RmeSpri::where('id_asesmen', $id)->first();

                            $spriData = [
                                'kd_pasien' => $dataMedis->kd_pasien,
                                'kd_unit' => $dataMedis->kd_unit,
                                'tgl_masuk' => $dataMedis->tgl_masuk,
                                'urut_masuk' => $dataMedis->urut_masuk,
                                'id_asesmen' => $id,
                                'tanggal_ranap' => $tindakLanjutData['tanggalRawatInap'] ?? '',
                                'jam_ranap' => $tindakLanjutData['jamRawatInap'] ?? null,
                                'keluhan_utama' => $tindakLanjutData['keluhanUtama_ranap'] ?? '',
                                'jalannya_penyakit' => $tindakLanjutData['jalannyaPenyakit_ranap'] ?? '',
                                'hasil_pemeriksaan' => $tindakLanjutData['hasilPemeriksaan_ranap'] ?? '',
                                'diagnosis' => $tindakLanjutData['diagnosis_ranap'] ?? '',
                                'tindakan' => $tindakLanjutData['tindakan_ranap'] ?? '',
                                'anjuran' => $tindakLanjutData['anjuran_ranap'] ?? ''
                            ];
                            if ($spri) {
                                // Update data yang sudah ada
                                $spri->update($spriData);
                            } else {
                                // Buat data baru jika belum ada
                                RmeSpri::create($spriData);
                            }
                            break;

                        case 'rujukKeluar':
                            $tindakLanjutDtl->tindak_lanjut_code = 5;
                            $tindakLanjutDtl->tindak_lanjut_name = 'Rujuk RS Lain';
                            $tindakLanjutDtl->tujuan_rujuk = $tindakLanjutData['tujuan_rujuk'] ?? '';
                            $tindakLanjutDtl->alasan_rujuk = $tindakLanjutData['alasan_rujuk'] ?? '';
                            $tindakLanjutDtl->transportasi_rujuk = $tindakLanjutData['transportasi_rujuk'] ?? '';
                            break;

                        case 'pulangSembuh':
                            $tindakLanjutDtl->tindak_lanjut_code = 6;
                            $tindakLanjutDtl->tindak_lanjut_name = 'Pulang Sembuh';
                            $tindakLanjutDtl->tanggal_pulang = $tindakLanjutData['tanggal_pulang'] ?? '';
                            $tindakLanjutDtl->jam_pulang = $tindakLanjutData['jam_pulang'] ?? '';
                            $tindakLanjutDtl->alasan_pulang = $tindakLanjutData['alasan_pulang'] ?? '';
                            $tindakLanjutDtl->kondisi_pulang = $tindakLanjutData['kondisi_pulang'] ?? '';
                            break;

                        case 'berobatJalan':
                            $tindakLanjutDtl->tindak_lanjut_code = 8;
                            $tindakLanjutDtl->tindak_lanjut_name = 'Berobat Jalan Ke Poli';
                            $tindakLanjutDtl->tanggal_rajal = $tindakLanjutData['tanggal_rajal'] ?? '';
                            $tindakLanjutDtl->poli_unit_tujuan = $tindakLanjutData['poli_unit_tujuan'] ?? '';
                            break;

                        case 'menolakRawatInap':
                            $tindakLanjutDtl->tindak_lanjut_code = 9;
                            $tindakLanjutDtl->tindak_lanjut_name = 'Menolak Rawat Inap';
                            $tindakLanjutDtl->keterangan = $tindakLanjutData['alasan_menolak'] ?? '';
                            break;

                        case 'meninggalDunia':
                            $tindakLanjutDtl->tindak_lanjut_code = 10;
                            $tindakLanjutDtl->tindak_lanjut_name = 'Meninggal Dunia';
                            $tindakLanjutDtl->tanggal_meninggal = $tindakLanjutData['tanggal_meninggal'] ?? '';
                            $tindakLanjutDtl->jam_meninggal = $tindakLanjutData['jam_meninggal'] ?? '';
                            break;

                        case 'deathoffarrival':
                            $tindakLanjutDtl->tindak_lanjut_code = 11;
                            $tindakLanjutDtl->tindak_lanjut_name = 'DOA';
                            $tindakLanjutDtl->tanggal_meninggal = $tindakLanjutData['tanggal_meninggal'] ?? '';
                            $tindakLanjutDtl->jam_meninggal = $tindakLanjutData['jam_meninggal'] ?? '';
                            break;

                        default:
                            $tindakLanjutDtl->tindak_lanjut_code = null;
                            $tindakLanjutDtl->tindak_lanjut_name = null;
                    }

                    $tindakLanjutDtl->save();
                }
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

            // dd($request->diagnosis);

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

            $this->createResume($kd_pasien, $tgl_masuk, $request->urut_masuk, $resumeData);

            // DB::commit();
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

    private function getTindakan($kd_pasien)
    {
        return ListTindakanPasien::with(['produk', 'ppa', 'unit'])
            ->where('kd_pasien', $kd_pasien)
            ->orderBy('tgl_tindakan', 'desc')
            ->get()
            ->map(function ($tindakan) {
                $tanggal = Carbon::parse($tindakan->tgl_tindakan)->format('Y-m-d');
                $jam = Carbon::parse($tindakan->jam_tindakan)->format('H:i');

                return [
                    'Tanggal-Jam' => Carbon::parse($tanggal . ' ' . $jam)->format('d M Y H:i'),
                    'Nama Tindakan' => $tindakan->produk->deskripsi ?? 'Tidak ada deskripsi',
                    'Dokter' => $tindakan->ppa->nama ?? 'Tidak diketahui',
                    'Unit' => $tindakan->unit->nama_unit ?? 'Tidak diketahui',
                    'Status' => $this->getStatusTindakan($tindakan->status),
                    'Keterangan' => $tindakan->keterangan ?? '-',
                    'Kesimpulan' => $tindakan->kesimpulan ?? '-'
                ];
            });
    }

    private function getStatusTindakan($status)
    {
        switch ($status) {
            case 0:
                return '<span class="text-warning">Menunggu</span>';
            case 1:
                return '<span class="text-primary">Dalam Proses</span>';
            case 2:
                return '<span class="text-success">Selesai</span>';
            default:
                return '<span class="text-secondary">Tidak Diketahui</span>';
        }
    }

    private function getRiwayatObat($kd_pasien)
    {
        // Get the latest order
        $latestOrder = DB::table('MR_RESEP')
            ->where('KD_PASIEN', $kd_pasien)
            ->select('TGL_ORDER')
            ->orderBy('TGL_ORDER', 'desc')
            ->first();

        if (!$latestOrder) {
            return collect();
        }

        return DB::table('MR_RESEP')
            ->join('DOKTER', 'MR_RESEP.KD_DOKTER', '=', 'DOKTER.KD_DOKTER')
            ->leftJoin('MR_RESEPDTL', 'MR_RESEP.ID_MRRESEP', '=', 'MR_RESEPDTL.ID_MRRESEP')
            ->leftJoin('APT_OBAT', 'MR_RESEPDTL.KD_PRD', '=', 'APT_OBAT.KD_PRD')
            ->where('MR_RESEP.KD_PASIEN', $kd_pasien)
            ->where('MR_RESEP.TGL_ORDER', $latestOrder->tgl_order)  // Changed to lowercase
            ->select(
                DB::raw('DISTINCT MR_RESEP.TGL_MASUK'),
                'MR_RESEP.KD_DOKTER',
                'DOKTER.NAMA as NAMA_DOKTER',
                'MR_RESEP.TGL_ORDER',
                'MR_RESEPDTL.CARA_PAKAI',
                'MR_RESEPDTL.JUMLAH_TAKARAN',
                'MR_RESEPDTL.SATUAN_TAKARAN',
                'APT_OBAT.NAMA_OBAT'
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

    public function store($kd_pasien, $tgl_masuk, Request $request)
    {
        // DB::beginTransaction();
        // dd($request->all());

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
                ->where('kunjungan.kd_unit', 3)
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
            $asesmen->riwayat_penyakit_keluarga = $request->riwayat_penyakit_keluarga;
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
            $asesmen->waktu_asesmen = date("Y-m-d H:i:s");
            $asesmen->kategori = 1;
            $asesmen->sub_kategori = 1;
            $asesmen->save();

            // dd($asesmen->all());

            // Di dalam method store
            $pemeriksaanFisik = json_decode($request->pemeriksaan_fisik, true);

            if (is_array($pemeriksaanFisik)) {
                foreach ($pemeriksaanFisik as $itemFisik) {
                    // Simpan semua data tanpa kondisi
                    RmeAsesmenPemeriksaanFisik::create([
                        'id_asesmen' => $asesmen->id,
                        'id_item_fisik' => $itemFisik['id'],
                        'is_normal' => $itemFisik['is_normal'],
                        'keterangan' => $itemFisik['keterangan'] ?? '',
                    ]);
                }
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
            if ($request->has('tindak_lanjut_data')) {
                $tindakLanjutData = json_decode($request->tindak_lanjut_data, true);

                $tindakLanjutDtl = new RmeAsesmenDtl();
                $tindakLanjutDtl->id_asesmen = $asesmen->id;

                if ($tindakLanjutData && isset($tindakLanjutData['option'])) {
                    switch ($tindakLanjutData['option']) {
                        case 'rawatInap':
                            $tindakLanjutDtl->tindak_lanjut_code = 1;
                            $tindakLanjutDtl->tindak_lanjut_name = 'Rawat Inap';

                            RmeSpri::create([
                                'kd_pasien' => $dataMedis->kd_pasien,
                                'kd_unit' => $dataMedis->kd_unit,
                                'tgl_masuk' => $dataMedis->tgl_masuk,
                                'urut_masuk' => $dataMedis->urut_masuk,
                                'id_asesmen' => $asesmen->id,
                                'tanggal_ranap' => $tindakLanjutData['tanggalRawatInap'] ?? '',
                                'jam_ranap' => $tindakLanjutData['jamRawatInap'] ?? null,
                                'keluhan_utama' => $tindakLanjutData['keluhanUtama_ranap'] ?? '',
                                'jalannya_penyakit' => $tindakLanjutData['jalannyaPenyakit_ranap'] ?? '',
                                'hasil_pemeriksaan' => $tindakLanjutData['hasilPemeriksaan_ranap'] ?? '',
                                'diagnosis' => $tindakLanjutData['diagnosis_ranap'] ?? '',
                                'tindakan' => $tindakLanjutData['tindakan_ranap'] ?? '',
                                'anjuran' => $tindakLanjutData['anjuran_ranap'] ?? ''
                            ]);
                            break;

                        case 'kamarOperasi':
                            $tindakLanjutDtl->tindak_lanjut_code = 7;
                            $tindakLanjutDtl->tindak_lanjut_name = 'Kamar Operasi';
                            $tindakLanjutDtl->keterangan = $tindakLanjutData['kamarOperasi'] ?? '';
                            break;

                        case 'rujukKeluar':
                            $tindakLanjutDtl->tindak_lanjut_code = 5;
                            $tindakLanjutDtl->tindak_lanjut_name = 'Rujuk RS Lain';
                            $tindakLanjutDtl->tujuan_rujuk = $tindakLanjutData['tujuan_rujuk'] ?? '';
                            $tindakLanjutDtl->alasan_rujuk = $tindakLanjutData['alasan_rujuk'] ?? '';
                            $tindakLanjutDtl->transportasi_rujuk = $tindakLanjutData['transportasi_rujuk'] ?? '';
                            break;

                        case 'pulangSembuh':
                            $tindakLanjutDtl->tindak_lanjut_code = 6;
                            $tindakLanjutDtl->tindak_lanjut_name = 'Pulang Sembuh';
                            $tindakLanjutDtl->tanggal_pulang = $tindakLanjutData['tanggalPulang'] ?? '';
                            $tindakLanjutDtl->jam_pulang = $tindakLanjutData['jamPulang'] ?? '';
                            $tindakLanjutDtl->alasan_pulang = $tindakLanjutData['alasan_pulang'] ?? '';
                            $tindakLanjutDtl->kondisi_pulang = $tindakLanjutData['kondisi_pulang'] ?? '';
                            break;

                        case 'berobatJalan':
                            $tindakLanjutDtl->tindak_lanjut_code = 8;
                            $tindakLanjutDtl->tindak_lanjut_name = 'Berobat Jalan Ke Poli';
                            $tindakLanjutDtl->tanggal_rajal = $tindakLanjutData['tanggal_rajal'] ?? '';
                            $tindakLanjutDtl->poli_unit_tujuan = $tindakLanjutData['poli_unit_tujuan'] ?? '';
                            break;

                        case 'menolakRawatInap':
                            $tindakLanjutDtl->tindak_lanjut_code = 9;
                            $tindakLanjutDtl->tindak_lanjut_name = 'Menolak Rawat Inap';
                            $tindakLanjutDtl->keterangan = $tindakLanjutData['alasanMenolak'] ?? '';
                            break;

                        case 'meninggalDunia':
                            $tindakLanjutDtl->tindak_lanjut_code = 10;
                            $tindakLanjutDtl->tindak_lanjut_name = 'Meninggal Dunia';
                            $tindakLanjutDtl->tanggal_meninggal = $tindakLanjutData['tanggalMeninggal'] ?? '';
                            $tindakLanjutDtl->jam_meninggal = $tindakLanjutData['jamMeninggal'] ?? '';
                            break;

                        case 'deathofarrival':
                            $tindakLanjutDtl->tindak_lanjut_code = 11;
                            $tindakLanjutDtl->tindak_lanjut_name = 'DOA';
                            $tindakLanjutDtl->tanggal_meninggal = $tindakLanjutData['tanggalDoa'] ?? '';
                            $tindakLanjutDtl->jam_meninggal = $tindakLanjutData['jamDoa'] ?? '';
                            break;

                        default:
                            $tindakLanjutDtl->tindak_lanjut_code = null;
                            $tindakLanjutDtl->tindak_lanjut_name = null;
                    }
                } else {
                    // Set default empty values when tindakLanjutData is empty
                    $tindakLanjutDtl->tindak_lanjut_code = '';
                    $tindakLanjutDtl->tindak_lanjut_name = '';
                    $tindakLanjutDtl->keterangan = '';
                    $tindakLanjutDtl->tanggal_meninggal = '';
                    $tindakLanjutDtl->jam_meninggal = '';
                    $tindakLanjutDtl->tanggal_pulang = '';
                    $tindakLanjutDtl->jam_pulang = '';
                    $tindakLanjutDtl->alasan_pulang = '';
                    $tindakLanjutDtl->tanggal_rajal = '';
                    $tindakLanjutDtl->poli_unit_tujuan = '';
                    $tindakLanjutDtl->tujuan_rujuk = '';
                    $tindakLanjutDtl->alasan_rujuk = '';
                    $tindakLanjutDtl->transportasi_rujuk = '';
                    $tindakLanjutDtl->kamar_operasi = '';
                }

                $tindakLanjutDtl->save();
            }

            // dd($request->vital_sign[0]['td_sistole']);

            $vitalSign = json_decode($request->vital_sign, true);
            $antropometri = json_decode($request->antropometri, true);
            $diagnosa = json_decode($request->diagnosa_data, true);

            // create resume
            $resumeData = [
                'anamnesis'             => $request->anamnesis,
                'diagnosis'             => $diagnosa,
                'tindak_lanjut_code'    => $tindakLanjutDtl->tindak_lanjut_code ?? null,
                'tindak_lanjut_name'    => $tindakLanjutDtl->tindak_lanjut_name ?? null,
                'tgl_kontrol_ulang'     => null,
                'unit_rujuk_internal'   => null,
                'rs_rujuk'              => null,
                'rs_rujuk_bagian'       => null,
                'konpas'                => [
                    'sistole'   => [
                        'hasil' => $vitalSign['td_sistole'] ?? null
                    ],
                    'distole'   => [
                        'hasil' => $vitalSign['td_diastole'] ?? null
                    ],
                    'respiration_rate'   => [
                        'hasil' => $vitalSign['resp'] ?? null
                    ],
                    'suhu'   => [
                        'hasil' => $vitalSign['suhu'] ?? null
                    ],
                    'nadi'   => [
                        'hasil' => $vitalSign['nadi'] ?? null 
                    ],
                    'tinggi_badan'   => [
                        'hasil' => $antropometri['tb'] ?? null 
                    ],
                    'berat_badan'   => [
                        'hasil' => $antropometri['bb'] ?? null
                    ]
                ]
            ];

            $this->createResume($kd_pasien, $tgl_masuk, $request->urut_masuk, $resumeData);

            return response()->json(['message' => 'Berhasil']);

            // DB::commit();
        } catch (\Exception $e) {
            // DB::rollBack();
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function createResume($kd_pasien, $tgl_masuk, $urut_masuk, $data)
    {
        // get resume
        $resume = RMEResume::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', 3)
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
                'kd_unit'       => 3,
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

    public function print($kd_pasien, $tgl_masuk, $id)
    {

        // dd($tgl_masuk);

        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->leftJoin('dokter', 'kunjungan.KD_DOKTER', '=', 'dokter.KD_DOKTER')
            ->select('kunjungan.*', 't.*', 'dokter.NAMA as nama_dokter')
            ->where('kunjungan.kd_unit', 3)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();

        // Ambil data asesmen
        $asesmen = RmeAsesmen::with([
            'pasien',
            'menjalar',
            'frekuensiNyeri',
            'kualitasNyeri',
            'faktorPemberat',
            'faktorPeringan',
            'efekNyeri',
            'tindaklanjut',
            'pemeriksaanFisik',
            'pemeriksaanFisik.itemFisik',
            'user'
        ])
            ->where('id', $id)
            ->first();

        $triaselabel ='-';
        $triasename = '-';
        
        switch ($dataMedis->kd_triase) {
            case '1':
                $triaselabel = 'FALSE EMERGENCY';
                $triasename = 'HIJAU';
                break;
            case '2':
                $triaselabel = 'URGNET';
                $triasename = 'KUNING';
                break;
            case '3':
                $triaselabel = 'EMERGENCY';
                $triasename = 'MERAH';
                break;
            case '4':
                $triaselabel = 'RESUSITASI';
                $triasename = 'MERAH';
                break;
            case '5':
                $triaselabel = 'DOA';
                $triasename = 'HITAM';
                break;
        }

        $pdf = PDF::loadView('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen.print', [
            'asesmen' => $asesmen,
            'triase' => [
                'label' => $triaselabel,
                'warna' => $triasename,
            ]

        ]);

        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream("Asesmen-Keperawatan-Medis-{$id}.pdf");
    }

}
