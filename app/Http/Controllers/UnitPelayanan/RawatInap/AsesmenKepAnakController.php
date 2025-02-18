<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\MrItemFisik;
use App\Models\RmeAsesmen;
use App\Models\RmeAsesmenKepAnakFisik;
use App\Models\RmeAsesmenKepAnakStatusNyeri;
use App\Models\RmeAsesmenPemeriksaanFisik;
use App\Models\RmeEfekNyeri;
use App\Models\RmeFaktorPemberat;
use App\Models\RmeFaktorPeringan;
use App\Models\RmeFrekuensiNyeri;
use App\Models\RmeJenisNyeri;
use App\Models\RmeKualitasNyeri;
use App\Models\RmeMenjalar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AsesmenKepAnakController extends Controller
{
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

        return view('unit-pelayanan.rawat-inap.pelayanan.asesmen-anak.create', compact(
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
            'user'
        ));
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        try {
            // Ambil tanggal dan jam dari form
            $tanggal = $request->tanggal_masuk;
            $jam = $request->jam_masuk;
            $waktu_asesmen = $tanggal . ' ' . $jam;

            // Simpan ke table RmeAsesmen
            $dataAsesmen = new RmeAsesmen();
            $dataAsesmen->kd_pasien = $kd_pasien;
            $dataAsesmen->kd_unit = $kd_unit;
            $dataAsesmen->tgl_masuk = $tgl_masuk;
            $dataAsesmen->urut_masuk = $urut_masuk;
            $dataAsesmen->user_id = Auth::id();
            $dataAsesmen->waktu_asesmen = $waktu_asesmen;
            $dataAsesmen->kategori = 1;
            $dataAsesmen->sub_kategori = 7;
            $dataAsesmen->anamnesis = $request->anamnesis;
            $dataAsesmen->save();

            //Simpan ke table RmeAsesmenKepAnakFisik
            $asesmenKepAnakFisik = new RmeAsesmenKepAnakFisik();
            $asesmenKepAnakFisik->id_asesmen = $dataAsesmen->id;
            $asesmenKepAnakFisik->sistole = $request->sistole;
            $asesmenKepAnakFisik->diastole = $request->diastole;
            $asesmenKepAnakFisik->nadi = $request->nadi;
            $asesmenKepAnakFisik->nafas = $request->nafas;
            $asesmenKepAnakFisik->suhu = $request->suhu;
            $asesmenKepAnakFisik->spo2_tanpa_bantuan = $request->saturasi_o2_tanpa;
            $asesmenKepAnakFisik->spo2_dengan_bantuan = $request->saturasi_o2_dengan;
            $asesmenKepAnakFisik->kesadaran = $request->kesadaran;
            $asesmenKepAnakFisik->avpu = $request->avpu;
            $asesmenKepAnakFisik->penglihatan = $request->penglihatan;
            $asesmenKepAnakFisik->pendengaran = $request->pendengaran;
            $asesmenKepAnakFisik->bicara = $request->bicara;
            $asesmenKepAnakFisik->refleks_menelan = $request->refleks_menelan;
            $asesmenKepAnakFisik->pola_tidur = $request->pola_tidur;
            $asesmenKepAnakFisik->luka = $request->luka;
            $asesmenKepAnakFisik->defekasi = $request->defekasi;
            $asesmenKepAnakFisik->miksi = $request->miksi;
            $asesmenKepAnakFisik->gastrointestinal = $request->gastrointestinal;
            $asesmenKepAnakFisik->lahir_umur_kehamilan = $request->umur_kehamilan;
            $asesmenKepAnakFisik->asi_Sampai_Umur = $request->Asi_Sampai_Umur;
            $asesmenKepAnakFisik->alasan_berhenti_menyusui = $request->alasan_berhenti_menyusui;
            $asesmenKepAnakFisik->masalah_neonatus = $request->masalah_neonatus;
            $asesmenKepAnakFisik->kelainan_kongenital = $request->kelainan_kongenital;
            $asesmenKepAnakFisik->tengkurap = $request->tengkurap;
            $asesmenKepAnakFisik->merangkak = $request->merangkak;
            $asesmenKepAnakFisik->duduk = $request->duduk;
            $asesmenKepAnakFisik->berdiri = $request->berdiri;
            $asesmenKepAnakFisik->tinggi_badan = $request->tinggi_badan;
            $asesmenKepAnakFisik->berat_badan = $request->berat_badan;
            $asesmenKepAnakFisik->imt = $request->imt;
            $asesmenKepAnakFisik->lpt = $request->lpt;
            $asesmenKepAnakFisik->lingkar_kepala = $request->lingkar_kepala;
            $asesmenKepAnakFisik->save();

            //Simpan ke table RmePemeriksaanFisik
            $itemFisik = MrItemFisik::all();
            foreach ($itemFisik as $item) {
                $itemName = strtolower($item->nama);
                $isNormal = $request->has($itemName . '-normal');
                $keterangan = $request->input($itemName . '_keterangan');

                // Hanya simpan jika checkbox normal dicentang atau ada keterangan
                if ($isNormal || $keterangan) {
                    RmeAsesmenPemeriksaanFisik::create([
                        'id_asesmen' => $dataAsesmen->id,
                        'id_item_fisik' => $item->id,
                        'is_normal' => $isNormal,
                        'keterangan' => $keterangan ?? ''
                    ]);
                }
            }

            //Simpan ke table RmeKepAnakStatusNyeri
            if ($request->filled('jenis_skala_nyeri')) {
                $jenisSkala = [
                    'NRS' => 1,
                    'FLACC' => 2,
                    'CRIES' => 3
                ];

                $statusNyeri = new RmeAsesmenKepAnakStatusNyeri();
                $statusNyeri->id_asesmen = $dataAsesmen->id;
                $statusNyeri->jenis_skala_nyeri = $jenisSkala[$request->jenis_skala_nyeri];
                $statusNyeri->nilai_nyeri = $request->nilai_skala_nyeri;
                $statusNyeri->kesimpulan_nyeri = $request->kesimpulan_nyeri;

                // Jika skala FLACC dipilih
                if ($request->jenis_skala_nyeri === 'FLACC') {
                    $statusNyeri->flacc_wajah = json_encode($request->input('wajah', []));
                    $statusNyeri->flacc_kaki = json_encode($request->input('kaki', []));
                    $statusNyeri->flacc_aktivitas = json_encode($request->input('aktivitas', []));
                    $statusNyeri->flacc_menangis = json_encode($request->input('menangis', []));
                    $statusNyeri->flacc_konsolabilitas = json_encode($request->input('konsolabilitas', []));
                    $statusNyeri->flacc_jumlah_skala = $request->input('flaccTotal');
                }

                // Jika skala CRIES dipilih
                if ($request->jenis_skala_nyeri === 'CRIES') {
                    $statusNyeri->cries_menangis = json_encode($request->input('menangis', []));
                    $statusNyeri->cries_kebutuhan_oksigen = json_encode($request->input('oksigen', []));
                    $statusNyeri->cries_increased = json_encode($request->input('vital', []));
                    $statusNyeri->cries_wajah = json_encode($request->input('wajah', []));
                    $statusNyeri->cries_sulit_tidur = json_encode($request->input('tidur', []));
                    $statusNyeri->cries_jumlah_skala = $request->input('criesTotal');
                }

                $statusNyeri->lokasi = $request->lokasi_nyeri;
                $statusNyeri->durasi_nyeri = $request->durasi_nyeri;
                $statusNyeri->jenis_nyeri = $request->jenis_nyeri;
                $statusNyeri->frekuensi_nyeri = $request->frekuensi_nyeri;
                $statusNyeri->nyeri_menjalar = $request->nyeri_menjalar;
                $statusNyeri->kualitas_nyeri = $request->kualitas_nyeri;
                $statusNyeri->faktor_pemberat = $request->faktor_pemberat;
                $statusNyeri->faktor_peringan = $request->faktor_peringan;
                $statusNyeri->efek_nyeri = $request->efek_nyeri;
                $statusNyeri->save();
            }


            return redirect()->back()->with('success', 'Data asesmen anak berhasil disimpan');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

}
