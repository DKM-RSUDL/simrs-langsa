<?php

namespace App\Http\Controllers\UnitPelayanan\GawatDarurat;

use App\Http\Controllers\Controller;
use App\Models\AptObat;
use App\Models\DataTriase;
use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\MrItemFisik;
use App\Models\RmeAsesmen;
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
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
                            ->join('transaksi as t', function($join) {
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

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen.index', compact(
            'dataMedis', 'dokter', 'triageClass', 'riwayatObat', 'laborData', 'radiologiData', 
            'itemFisik', 'menjalar', 'frekuensinyeri', 'kualitasnyeri', 'faktorpemberat', 'faktorperingan', 'efeknyeri'));
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
        DB::beginTransaction();
        dd($request->all());

        try {

            $asesmen = new RmeAsesmen();
            $asesmen->kd_pasien = $request->kd_pasien;
            $asesmen->kd_unit = $request->kd_unit;
            $asesmen->tgl_masuk = $request->tgl_masuk;
            $asesmen->urut_masuk = $request->urut_masuk;
            $asesmen->tindakan_resusitasi = json_encode($request->tindakan_resusitasi);
            $asesmen->anamnesis = $request->anamnesis;
            $asesmen->riwayat_penyakit = $request->riwayat_penyakit;
            $asesmen->riwayat_pengobatan = $request->riwayat_pengobatan;
            $asesmen->riwayat_alergi = json_encode($request->riwayat_alergi);
            $asesmen->vital_sign = json_encode($request->vital_sign);
            $asesmen->antropometri = json_encode($request->antropometri);
            $asesmen->skala_nyeri = $request->skala_nyeri;
            $asesmen->lokasi = $request->lokasi;
            $asesmen->durasi = $request->durasi;
            $asesmen->menjalar_id = $request->menjalar;
            $asesmen->frekuensi_nyeri_id = $request->frekuensi;
            $asesmen->kualitas_nyeri_id = $request->kualitas;
            $asesmen->faktor_pemberat_id = $request->faktor_pemberat;
            $asesmen->faktor_peringan_id = $request->faktor_peringan;
            $asesmen->efek_nyeri = $request->efek_nyeri;
            $asesmen->diagnosis = json_encode($request->diagnosis);
            $asesmen->alat_terpasang = json_encode($request->alat_terpasang);
            $asesmen->kondisi_pasien = $request->kondisi_pasien;
            $asesmen->save();

            foreach ($request->pemeriksaan_fisik as $itemFisik) {
                RmeAsesmenPemeriksaanFisik::create([
                    'id_asesmen' => $asesmen->id,
                    'id_item_fisik' => $itemFisik['id'],
                    'is_normal' => $itemFisik['is_normal'],
                    'keterangan' => $itemFisik['keterangan']
                ]);
            }

            // Simpan data triase
            $triase = new DataTriase();
            $triase->id_asesmen = $asesmen->id;
            $triase->nama_pasien = $request->nama_pasien;
            $triase->jenis_kelamin = $request->jenis_kelamin;
            $triase->tanggal_lahir = $request->tanggal_lahir;
            $triase->status = $request->status;
            $triase->tanggal_triase = now();
            $triase->triase = json_encode($request->triase);
            $triase->hasil_triase = $request->hasil_triase;
            $triase->save();

            DB::commit();


        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

}
