<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\MrItemFisik;
use App\Models\RmeAsesmen;
use App\Models\RmeAsesmenGinekologik;
use App\Models\RmeAsesmenGinekologikDiagnosisImplementasi;
use App\Models\RmeAsesmenGinekologikEkstremitasGinekologik;
use App\Models\RmeAsesmenGinekologikPemeriksaanDischarge;
use App\Models\RmeAsesmenGinekologikTandaVital;
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
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AsesmenGinekologikController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
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

        // Mengambil nama alergen dari riwayat_alergi
        if ($dataMedis->riwayat_alergi) {
            $dataMedis->riwayat_alergi = collect(json_decode($dataMedis->riwayat_alergi, true))
                ->pluck('alergen')
                ->all();
        } else {
            $dataMedis->riwayat_alergi = [];
        }

        $dataMedis->waktu_masuk = Carbon::parse($dataMedis->TGL_MASUK . ' ' . $dataMedis->JAM_MASUK)->format('Y-m-d H:i:s');

        return view('unit-pelayanan.rawat-inap.pelayanan.asesmen-ginekologik.create', compact(
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
            'user'
        ));
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        try {
            // 1. Buat record RmeAsesmen
            $asesmen = new RmeAsesmen();
            $asesmen->kd_pasien = $request->kd_pasien;
            $asesmen->kd_unit = $request->kd_unit;
            $asesmen->tgl_masuk = $request->tgl_masuk;
            $asesmen->urut_masuk = $request->urut_masuk;
            $asesmen->user_id = Auth::id();
            $asesmen->waktu_asesmen = date('Y-m-d H:i:s');
            $asesmen->kategori = 1;
            $asesmen->sub_kategori = 9;
            $asesmen->save();

            // 2. Simpan RmeAsesmenGinekologik
            $asesmenGinekologik = new RmeAsesmenGinekologik();
            $asesmenGinekologik->id_asesmen = $asesmen->id;
            $asesmenGinekologik->user_create = Auth::id();
            $asesmenGinekologik->tanggal = Carbon::parse($request->tanggal);
            $asesmenGinekologik->jam_masuk = $request->jam_masuk;
            $asesmenGinekologik->kondisi_masuk = $request->kondisi_masuk;
            $asesmenGinekologik->diagnosis_masuk = $request->diagnosis_masuk;
            $asesmenGinekologik->gravida = $request->gravida;
            $asesmenGinekologik->para = $request->para;
            $asesmenGinekologik->abortus = $request->abortus;
            $asesmenGinekologik->keluhan_utama = $request->keluhan_utama;
            $asesmenGinekologik->riwayat_penyakit = $request->riwayat_penyakit;
            $asesmenGinekologik->siklus = $request->siklus;
            $asesmenGinekologik->hpht = $request->hpht;
            $asesmenGinekologik->usia_kehamilan = $request->usia_kehamilan;
            $asesmenGinekologik->jumlah = $request->jumlah;
            $asesmenGinekologik->tahun = $request->tahun;
            $asesmenGinekologik->riwayat_obstetrik = $request->riwayat_obstetrik;
            $asesmenGinekologik->riwayat_penyakit_dahulu = $request->riwayat_penyakit_dahulu;
            $asesmenGinekologik->save();

            // 3. Simpan data tanda vital
            $asesmenTandaVital = new RmeAsesmenGinekologikTandaVital();
            $asesmenTandaVital->id_asesmen = $asesmen->id;
            $asesmenTandaVital->tekanan_darah_sistole = $request->tekanan_darah_sistole;
            $asesmenTandaVital->tekanan_darah_diastole = $request->tekanan_darah_diastole;
            $asesmenTandaVital->suhu = $request->suhu;
            $asesmenTandaVital->respirasi = $request->respirasi;
            $asesmenTandaVital->nadi = $request->nadi;
            $asesmenTandaVital->nafas = $request->nafas;
            $asesmenTandaVital->berat_badan = $request->berat_badan;
            $asesmenTandaVital->tinggi_badan = $request->tinggi_badan;
            $asesmenTandaVital->save();

            $ginekologikEkstremitasGinekologik = new RmeAsesmenGinekologikEkstremitasGinekologik();
            $ginekologikEkstremitasGinekologik->id_asesmen = $asesmen->id;
            $ginekologikEkstremitasGinekologik->edema_atas = $request->edema_atas;
            $ginekologikEkstremitasGinekologik->varises_atas = $request->varises_atas;
            $ginekologikEkstremitasGinekologik->refleks_atas = $request->refleks_atas;
            $ginekologikEkstremitasGinekologik->edema_bawah = $request->edema_bawah;
            $ginekologikEkstremitasGinekologik->varises_bawah = $request->varises_bawah;
            $ginekologikEkstremitasGinekologik->refleks_bawah = $request->refleks_bawah;
            $ginekologikEkstremitasGinekologik->catatan_ekstremitas = $request->catatan_ekstremitas;
            $ginekologikEkstremitasGinekologik->keadaan_umum = $request->keadaan_umum;
            $ginekologikEkstremitasGinekologik->status_ginekologik = $request->status_ginekologik;
            $ginekologikEkstremitasGinekologik->pemeriksaan = $request->pemeriksaan;
            $ginekologikEkstremitasGinekologik->inspekulo = $request->inspekulo;
            $ginekologikEkstremitasGinekologik->vt = $request->vt;
            $ginekologikEkstremitasGinekologik->rt = $request->rt;
            $ginekologikEkstremitasGinekologik->save();

            $ginekologikPemeriksaanDischarge = new RmeAsesmenGinekologikPemeriksaanDischarge();
            $ginekologikPemeriksaanDischarge->id_asesmen = $asesmen->id;
            $ginekologikPemeriksaanDischarge->laboratorium = $request->laboratorium;
            $ginekologikPemeriksaanDischarge->usg = $request->usg;
            $ginekologikPemeriksaanDischarge->radiologi = $request->radiologi;
            $ginekologikPemeriksaanDischarge->penunjang_lainnya = $request->penunjang_lainnya;
            $ginekologikPemeriksaanDischarge->diagnosis_medis = $request->diagnosis_medis;
            $ginekologikPemeriksaanDischarge->usia_lanjut = $request->usia_lanjut;
            $ginekologikPemeriksaanDischarge->hambatan_mobilisasi = $request->hambatan_mobilisasi;
            $ginekologikPemeriksaanDischarge->penggunaan_media_berkelanjutan = $request->penggunaan_media_berkelanjutan;
            $ginekologikPemeriksaanDischarge->ketergantungan_aktivitas = $request->ketergantungan_aktivitas;
            $ginekologikPemeriksaanDischarge->keterampilan_khusus = $request->keterampilan_khusus;
            $ginekologikPemeriksaanDischarge->alat_bantu = $request->alat_bantu;
            $ginekologikPemeriksaanDischarge->nyeri_kronis = $request->nyeri_kronis;
            $ginekologikPemeriksaanDischarge->perkiraan_hari = $request->perkiraan_hari;
            $ginekologikPemeriksaanDischarge->tanggal_pulang = $request->tanggal_pulang;
            $ginekologikPemeriksaanDischarge->kesimpulan_planing = $request->kesimpulan_planing;
            $ginekologikPemeriksaanDischarge->save();

            $ginekologikDiagnosisImplementasi = new RmeAsesmenGinekologikDiagnosisImplementasi();
            $ginekologikDiagnosisImplementasi->id_asesmen = $asesmen->id;
            $ginekologikDiagnosisImplementasi->diagnosis_banding = $request->diagnosis_banding;
            $ginekologikDiagnosisImplementasi->diagnosis_kerja = $request->diagnosis_kerja;
            $ginekologikDiagnosisImplementasi->gambar_radiologi_paru = $request->gambar_radiologi_paru;
            $ginekologikDiagnosisImplementasi->observasi = $request->observasi;
            $ginekologikDiagnosisImplementasi->terapeutik = $request->terapeutik;
            $ginekologikDiagnosisImplementasi->edukasi = $request->edukasi;
            $ginekologikDiagnosisImplementasi->kolaborasi = $request->kolaborasi;
            $ginekologikDiagnosisImplementasi->prognosis = $request->prognosis;
            $ginekologikDiagnosisImplementasi->save();

            // PERBAIKAN UTAMA: Simpan data pemeriksaan fisik dengan ID yang benar
            $itemFisik = MrItemFisik::all();
            foreach ($itemFisik as $item) {
                $isNormal = $request->has($item->id . '-normal') ? 1 : 0;
                $keterangan = $request->input($item->id . '_keterangan');

                // Jika normal, hapus keterangan
                if ($isNormal) {
                    $keterangan = '';
                }

                // PERBAIKAN: Gunakan $asesmen->id bukan $asesmenParu->id
                RmeAsesmenPemeriksaanFisik::create([
                    'id_asesmen' => $asesmen->id, // ← INI YANG DIPERBAIKI!
                    'id_item_fisik' => $item->id,
                    'is_normal' => $isNormal,
                    'keterangan' => $keterangan
                ]);
            }

            // Simpan diagnosis dan implementasi ke master - tetap sama...
            $diagnosisBandingList = json_decode($request->diagnosis_banding ?? '[]', true);
            $diagnosisKerjaList = json_decode($request->diagnosis_kerja ?? '[]', true);
            $allDiagnoses = array_merge($diagnosisBandingList, $diagnosisKerjaList);

            foreach ($allDiagnoses as $diagnosa) {
                $existingDiagnosa = RmeMasterDiagnosis::where('nama_diagnosis', $diagnosa)->first();
                if (!$existingDiagnosa) {
                    RmeMasterDiagnosis::create([
                        'nama_diagnosis' => $diagnosa
                    ]);
                }
            }

            // Fungsi helper untuk menyimpan implementasi
            $saveToColumn = function ($dataList, $column) {
                foreach ($dataList as $item) {
                    $existingImplementasi = RmeMasterImplementasi::where($column, $item)->first();
                    if (!$existingImplementasi) {
                        RmeMasterImplementasi::create([
                            $column => $item
                        ]);
                    }
                }
            };

            // Simpan implementasi
            $rppList = json_decode($request->prognosis ?? '[]', true);
            $observasiList = json_decode($request->observasi ?? '[]', true);
            $terapeutikList = json_decode($request->terapeutik ?? '[]', true);
            $edukasiList = json_decode($request->edukasi ?? '[]', true);
            $kolaborasiList = json_decode($request->kolaborasi ?? '[]', true);

            $saveToColumn($rppList, 'prognosis');
            $saveToColumn($observasiList, 'observasi');
            $saveToColumn($terapeutikList, 'terapeutik');
            $saveToColumn($edukasiList, 'edukasi');
            $saveToColumn($kolaborasiList, 'kolaborasi');

            return redirect()->route('rawat-inap.asesmen.medis.umum.index', [
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk
            ])->with('success', 'Data berhasil disimpan');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $th->getMessage());
        }
    }
}
