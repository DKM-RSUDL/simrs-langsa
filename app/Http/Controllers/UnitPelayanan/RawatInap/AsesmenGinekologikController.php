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
use App\Models\RMEResume;
use App\Models\RmeResumeDtl;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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

    public function show($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            // Ambil data asesmen beserta relasinya
            $asesmen = RmeAsesmen::with([
                'user',
                'rmeAsesmenGinekologik',
                'rmeAsesmenGinekologikTandaVital',
                'rmeAsesmenGinekologikEkstremitasGinekologik',
                'rmeAsesmenGinekologikPemeriksaanDischarge',
                'rmeAsesmenGinekologikDiagnosisImplementasi',
                'rmeAlergiPasien',
                'pemeriksaanFisik' => function ($query) {
                    $query->orderBy('id_item_fisik');
                },
            ])->findOrFail($id);

            $dataMedis = Kunjungan::with('pasien')
                ->where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->firstOrFail();

            $itemFisik = MrItemFisik::orderBy('urut')->get();

            return view('unit-pelayanan.rawat-inap.pelayanan.asesmen-ginekologik.show', compact(
                'asesmen',
                'dataMedis',
                'itemFisik'
            ));
        } catch (ModelNotFoundException $e) {
            return back()->with('error', 'Data tidak ditemukan. Detail: ' . $e->getMessage());
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            // Ambil data asesmen beserta relasinya
            $asesmen = RmeAsesmen::with([
                'user',
                'rmeAsesmenGinekologik',
                'rmeAsesmenGinekologikTandaVital',
                'rmeAsesmenGinekologikEkstremitasGinekologik',
                'rmeAsesmenGinekologikPemeriksaanDischarge',
                'rmeAsesmenGinekologikDiagnosisImplementasi',
                'rmeAlergiPasien',
                'pemeriksaanFisik' => function ($query) {
                    $query->orderBy('id_item_fisik');
                },
            ])->findOrFail($id);

            $dataMedis = Kunjungan::with('pasien')
                ->where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->firstOrFail();

            $itemFisik = MrItemFisik::orderBy('urut')->get();

            return view('unit-pelayanan.rawat-inap.pelayanan.asesmen-ginekologik.edit', compact(
                'asesmen',
                'dataMedis',
                'itemFisik'
            ));
        } catch (ModelNotFoundException $e) {
            return back()->with('error', 'Data tidak ditemukan. Detail: ' . $e->getMessage());
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            // 1. Buat record RmeAsesmen
            $asesmen = RmeAsesmen::findOrFail($id);
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
            $asesmenGinekologik = RmeAsesmenGinekologik::firstOrNew(['id_asesmen' => $asesmen->id]);
            $asesmenGinekologik->id_asesmen = $asesmen->id;
            $asesmenGinekologik->user_edit = Auth::id();
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
            $asesmenTandaVital = RmeAsesmenGinekologikTandaVital::firstOrNew(['id_asesmen' => $asesmen->id]);
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

            $ginekologikEkstremitasGinekologik = RmeAsesmenGinekologikEkstremitasGinekologik::firstOrNew(['id_asesmen' => $asesmen->id]);
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

            $ginekologikPemeriksaanDischarge = RmeAsesmenGinekologikPemeriksaanDischarge::firstOrNew(['id_asesmen' => $asesmen->id]);
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

            $ginekologikDiagnosisImplementasi = RmeAsesmenGinekologikDiagnosisImplementasi::firstOrNew(['id_asesmen' => $asesmen->id]);
            $ginekologikDiagnosisImplementasi->id_asesmen = $asesmen->id;
            $ginekologikDiagnosisImplementasi->diagnosis_banding = $request->diagnosis_banding;
            $ginekologikDiagnosisImplementasi->diagnosis_kerja = $request->diagnosis_kerja;
            $ginekologikDiagnosisImplementasi->observasi = $request->observasi;
            $ginekologikDiagnosisImplementasi->terapeutik = $request->terapeutik;
            $ginekologikDiagnosisImplementasi->edukasi = $request->edukasi;
            $ginekologikDiagnosisImplementasi->kolaborasi = $request->kolaborasi;
            $ginekologikDiagnosisImplementasi->prognosis = $request->prognosis;
            $ginekologikDiagnosisImplementasi->save();

            // Update ke table RmePemeriksaanFisik
            $itemFisik = MrItemFisik::all();
            foreach ($itemFisik as $item) {
                $itemName = strtolower($item->nama);
                $isNormal = $request->has($item->id . '-normal') ? 1 : 0;
                $keterangan = $request->input($item->id . '_keterangan');
                if ($isNormal) $keterangan = '';

                RmeAsesmenPemeriksaanFisik::updateOrCreate(
                    [
                        'id_asesmen' => $asesmen->id,
                        'id_item_fisik' => $item->id
                    ],
                    [
                        'is_normal' => $isNormal,
                        'keterangan' => $keterangan
                    ]
                );
            }

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
            $rppList = json_decode($request->prognosis ?? '[]', true);
            $observasiList = json_decode($request->observasi ?? '[]', true);
            $terapeutikList = json_decode($request->terapeutik ?? '[]', true);
            $edukasiList = json_decode($request->edukasi ?? '[]', true);
            $kolaborasiList = json_decode($request->kolaborasi ?? '[]', true);
            // Fungsi untuk menyimpan data ke kolom tertentu
            function updateToColumn($dataList, $column)
            {
                foreach ($dataList as $item) {
                    // Cek apakah sudah ada entri
                    $existingImplementasi = RmeMasterImplementasi::where($column, $item)->first();

                    if (!$existingImplementasi) {
                        // Jika tidak ada, buat record baru
                        $masterImplementasi = new RmeMasterImplementasi();
                        $masterImplementasi->$column = $item;
                        $masterImplementasi->save();
                    }
                }
            }
            // Simpan data
            updateToColumn($rppList, 'prognosis'); // sudah terlanjut buat ke rpp jadi yang di ubah hanya name sesuai DB saja ke prognosis
            updateToColumn($observasiList, 'observasi');
            updateToColumn($terapeutikList, 'terapeutik');
            updateToColumn($edukasiList, 'edukasi');
            updateToColumn($kolaborasiList, 'kolaborasi');

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

    public function generatePDF($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            $asesmen = RmeAsesmen::with([
                'user',
                'rmeAsesmenGinekologik',
                'rmeAsesmenGinekologikTandaVital',
                'rmeAsesmenGinekologikEkstremitasGinekologik',
                'rmeAsesmenGinekologikPemeriksaanDischarge',
                'rmeAsesmenGinekologikDiagnosisImplementasi',
                'rmeAlergiPasien',
                'pemeriksaanFisik' => function ($query) {
                $query->orderBy('id_item_fisik');
            },
            ])->findOrFail($id);

            $dataMedis = Kunjungan::with('pasien')
                ->where('kd_unit', $kd_unit)
                ->where('kd_pasien', $kd_pasien)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->first();

            $pdf = PDF::loadView('unit-pelayanan.rawat-inap.pelayanan.asesmen-ginekologik.print', [
                'asesmen'    => $asesmen ?? null,
                'pasien' => optional($dataMedis)->pasien ?? null,
                'dataMedis' => $dataMedis ?? null,
                // variabel lainnya sesuai kebutuhan
                'rmeAsesmenGinekologik' => optional($asesmen)->rmeAsesmenGinekologik ?? null,
                'rmeAsesmenGinekologikTandaVital' => optional($asesmen)->rmeAsesmenGinekologikTandaVital ?? null,
                'rmeAsesmenGinekologikEkstremitasGinekologik' => optional($asesmen)->rmeAsesmenGinekologikEkstremitasGinekologik ?? null,
                'rmeAsesmenGinekologikPemeriksaanDischarge' => optional($asesmen)->rmeAsesmenGinekologikPemeriksaanDischarge ?? null,
                'rmeAsesmenGinekologikDiagnosisImplementasi' => optional($asesmen)->rmeAsesmenGinekologikDiagnosisImplementasi ?? null,
                'rmeAlergiPasien' => optional($asesmen)->rmeAlergiPasien ?? null,
                'pemeriksaanFisik' => optional($asesmen)->pemeriksaanFisik ?? null,
            ]);

            $pdf->setPaper('a4', 'portrait');
            $pdf->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled'      => true,
                'defaultFont'          => 'sans-serif'
            ]);

            return $pdf->stream("asesmen-ginekologik-{$id}-print-pdf.pdf");
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal generate PDF: ' . $e->getMessage()
            ], 500);
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
}
