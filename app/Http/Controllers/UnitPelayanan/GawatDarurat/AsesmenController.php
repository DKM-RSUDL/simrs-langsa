<?php

namespace App\Http\Controllers\UnitPelayanan\GawatDarurat;

use App\Http\Controllers\Controller;
use App\Models\AptObat;
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
use App\Models\SegalaOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AsesmenController extends Controller
{
    public function index($kd_pasien, $tgl_masuk)
    {

        $user = auth()->user();
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

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
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
        $asesmen = RmeAsesmen::with(['retriase'])
            ->where('RME_ASESMEN.kd_pasien', $kd_pasien)
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
            'asesmen'
        ));
    }

    public function show($kd_pasien, $tgl_masuk, $id)
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
                        'tindaklanjut' => $asesmen->tindaklanjut

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

    public function update($kd_pasien, $tgl_masuk, $id, Request $request)
    {
        // DB::beginTransaction();
        try {

            $asesmen = RmeAsesmen::where('id', $id)
                ->where('kd_pasien', $kd_pasien)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->firstOrFail();

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
                    'Waktu Hasil' => $labHasil && $labHasil->tgl_otoritas_det ? $labHasil->tgl_otoritas_det->format('d M Y H:i') : '-',
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
                    RmeAsesmenPemeriksaanFisik::create([
                        'id_asesmen' => $asesmen->id,
                        'id_item_fisik' => $itemFisik['id'],
                        'is_normal' => $itemFisik['is_normal'],
                        'keterangan' => $itemFisik['keterangan']
                    ]);
                }
            } else {
                // Error handling jika data bukan array
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

            return response()->json(['message' => 'Berhasil']);

            // DB::commit();
        } catch (\Exception $e) {
            // DB::rollBack();
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
}
