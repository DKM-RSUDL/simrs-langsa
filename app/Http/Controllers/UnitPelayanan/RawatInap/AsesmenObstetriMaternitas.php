<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\MrItemFisik;
use App\Models\RmeAsesmen;
use App\Models\RmeAsesmenObstetri;
use App\Models\RmeAsesmenObstetriDiagnosisImplementasi;
use App\Models\RmeAsesmenObstetriDischargePlanning;
use App\Models\RmeAsesmenObstetriPemeriksaanFisik;
use App\Models\RmeAsesmenObstetriRiwayatKesehatan;
use App\Models\RmeAsesmenObstetriStatusNyeri;
use App\Models\RmeAsesmenPemeriksaanFisik;
use App\Models\RmeMasterDiagnosis;
use App\Models\RmeMasterImplementasi;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AsesmenObstetriMaternitas extends Controller
{
    public function index(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $user = auth()->user();
        $itemFisik = MrItemFisik::orderby('urut')->get();
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

        return view('unit-pelayanan.rawat-inap.pelayanan.asesmen-obstetri-maternitas.create', compact(
            'kd_unit',
            'kd_pasien',
            'tgl_masuk',
            'urut_masuk',
            'dataMedis',
            'itemFisik',
            'user',
            'rmeMasterDiagnosis',
            'rmeMasterImplementasi'
        ));
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        // dd($request);
        $asesmen = new RmeAsesmen();
        $asesmen->kd_pasien = $request->kd_pasien;
        $asesmen->kd_unit = $request->kd_unit;
        $asesmen->tgl_masuk = $request->tgl_masuk;
        $asesmen->urut_masuk = $request->urut_masuk;
        $asesmen->user_id = Auth::id();
        $asesmen->waktu_asesmen = date('Y-m-d H:i:s');
        $asesmen->kategori = 1;
        $asesmen->sub_kategori = 4;
        $asesmen->save();

        $request->validate([
            'hasil_pemeriksaan_penunjang_darah' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'hasil_pemeriksaan_penunjang_urine' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'hasil_pemeriksaan_penunjang_rontgent' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'hasil_pemeriksaan_penunjang_histopatology' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        $asesmenObstetri = new RmeAsesmenObstetri();
        $asesmenObstetri->id_asesmen = $asesmen->id;
        $asesmenObstetri->tgl_masuk = "$request->tgl_masuk $request->jam_masuk";
        $asesmenObstetri->antenatal_rs = $request->antenatal_rs;
        $asesmenObstetri->antenatal_rs_count = $request->antenatal_rs_count;
        $asesmenObstetri->antenatal_lain = $request->antenatal_lain;
        $asesmenObstetri->antenatal_lain_count = $request->antenatal_lain_count;
        $asesmenObstetri->nama_pemeriksa = Auth::user()->name;
        $asesmenObstetri->anamnesis_anamnesis = $request->anamnesis_anamnesis;
        $asesmenObstetri->evaluasi_evaluasi = $request->evaluasi_evaluasi;

        // Array untuk menyimpan path file yang berhasil diupload
        $uploadedFiles = [];

        // Fungsi helper untuk upload file
        $uploadFile = function ($fieldName) use ($request, &$uploadedFiles, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk) {
            if ($request->hasFile($fieldName)) {
                try {
                    $file = $request->file($fieldName);
                    $path = $file->store("uploads/ranap/asesmen-obstetri/$kd_unit/$kd_pasien/$tgl_masuk/$urut_masuk");

                    if ($path) {
                        return $path;
                    }
                } catch (\Exception $e) {
                    throw new \Exception("Gagal mengupload file {$fieldName}");
                }
            }
            return null;
        };

        // Upload files
        $asesmenObstetri->hasil_pemeriksaan_penunjang_darah = $uploadFile('hasil_pemeriksaan_penunjang_darah');
        $asesmenObstetri->hasil_pemeriksaan_penunjang_urine = $uploadFile('hasil_pemeriksaan_penunjang_urine');
        $asesmenObstetri->hasil_pemeriksaan_penunjang_rontgent = $uploadFile('hasil_pemeriksaan_penunjang_rontgent');
        $asesmenObstetri->hasil_pemeriksaan_penunjang_histopatology = $uploadFile('hasil_pemeriksaan_penunjang_histopatology');
        $asesmenObstetri->save();

        $asesmenObstetriPemeriksaanFisik = new RmeAsesmenObstetriPemeriksaanFisik();
        $asesmenObstetriPemeriksaanFisik->id_asesmen = $asesmen->id;
        $asesmenObstetriPemeriksaanFisik->keadaan_umum = $request->keadaan_umum;
        $asesmenObstetriPemeriksaanFisik->tekanan_darah_sistole = $request->tekanan_darah_sistole;
        $asesmenObstetriPemeriksaanFisik->tekanan_darah_diastole = $request->tekanan_darah_diastole;
        $asesmenObstetriPemeriksaanFisik->nadi = $request->nadi;
        $asesmenObstetriPemeriksaanFisik->pernafasan = $request->pernafasan;
        $asesmenObstetriPemeriksaanFisik->suhu = $request->suhu;
        $asesmenObstetriPemeriksaanFisik->kesadaran = $request->kesadaran;
        $asesmenObstetriPemeriksaanFisik->avpu = $request->avpu;
        $asesmenObstetriPemeriksaanFisik->komprehensif_posisi_janin = $request->komprehensif_posisi_janin;
        $asesmenObstetriPemeriksaanFisik->komprehensif_tinggi_fundus = $request->komprehensif_tinggi_fundus;
        $asesmenObstetriPemeriksaanFisik->kontraksi_frekuensi = $request->kontraksi_frekuensi;
        $asesmenObstetriPemeriksaanFisik->kontraksi_kekuatan = $request->kontraksi_kekuatan;
        $asesmenObstetriPemeriksaanFisik->kontraksi_irama = $request->kontraksi_irama;
        $asesmenObstetriPemeriksaanFisik->kontraksi_letak_janin = $request->kontraksi_letak_janin;
        $asesmenObstetriPemeriksaanFisik->kontraksi_presentasi_janin = $request->kontraksi_presentasi_janin;
        $asesmenObstetriPemeriksaanFisik->kontraksi_sikap_janin = $request->kontraksi_sikap_janin;
        $asesmenObstetriPemeriksaanFisik->djj_frekuensi = $request->djj_frekuensi;
        $asesmenObstetriPemeriksaanFisik->djj_irama = $request->djj_irama;
        $asesmenObstetriPemeriksaanFisik->serviks_konsistensi = $request->serviks_konsistensi;
        $asesmenObstetriPemeriksaanFisik->serviks_station = $request->serviks_station;
        $asesmenObstetriPemeriksaanFisik->serviks_penurunan = $request->serviks_penurunan;
        $asesmenObstetriPemeriksaanFisik->serviks_pembukaan = $request->serviks_pembukaan;
        $asesmenObstetriPemeriksaanFisik->serviks_jam_pembukaan = $request->serviks_jam_pembukaan;
        $asesmenObstetriPemeriksaanFisik->serviks_posisi = $request->serviks_posisi;
        $asesmenObstetriPemeriksaanFisik->serviks_irama = $request->serviks_irama;
        $asesmenObstetriPemeriksaanFisik->panggul_promontorium = $request->panggul_promontorium;
        $asesmenObstetriPemeriksaanFisik->panggul_line_terminalis = $request->panggul_line_terminalis;
        $asesmenObstetriPemeriksaanFisik->panggul_spina_ischiadika = $request->panggul_spina_ischiadika;
        $asesmenObstetriPemeriksaanFisik->panggul_arkus_pubis = $request->panggul_arkus_pubis;
        $asesmenObstetriPemeriksaanFisik->panggul_lengkung_sakrum = $request->panggul_lengkung_sakrum;
        $asesmenObstetriPemeriksaanFisik->panggul_dinding_samping = $request->panggul_dinding_samping;
        $asesmenObstetriPemeriksaanFisik->panggul_simpulan = $request->panggul_simpulan;
        $asesmenObstetriPemeriksaanFisik->panggul_pembukaan_cm = $request->panggul_pembukaan_cm;
        $asesmenObstetriPemeriksaanFisik->panggul_selaput_ketuban = $request->panggul_selaput_ketuban;
        $asesmenObstetriPemeriksaanFisik->panggul_air_ketuban = $request->panggul_air_ketuban;
        $asesmenObstetriPemeriksaanFisik->panggul_presentasi = $request->panggul_presentasi;
        $asesmenObstetriPemeriksaanFisik->antropometri_tinggi_badan = $request->antropometri_tinggi_badan;
        $asesmenObstetriPemeriksaanFisik->antropometr_berat_badan = $request->antropometr_berat_badan;
        $asesmenObstetriPemeriksaanFisik->antropometri_imt = $request->antropometri_imt;
        $asesmenObstetriPemeriksaanFisik->antropometri_lpt = $request->antropometri_lpt;
        $asesmenObstetriPemeriksaanFisik->save();

        //Simpan ke table RmePemeriksaanFisik
        $itemFisik = MrItemFisik::all();
        foreach ($itemFisik as $item) {
            $itemName = strtolower($item->nama);
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

        $asesmenObstetriStatusNyeri = new RmeAsesmenObstetriStatusNyeri();
        $asesmenObstetriStatusNyeri->id_asesmen = $asesmen->id;
        $asesmenObstetriStatusNyeri->jenis_skala_nyeri = $request->jenis_skala_nyeri;
        $asesmenObstetriStatusNyeri->skala_nyeri = $request->skala_nyeri;
        $asesmenObstetriStatusNyeri->lokasi_nyeri = $request->lokasi_nyeri;
        $asesmenObstetriStatusNyeri->durasi_nyeri = $request->durasi_nyeri;
        $asesmenObstetriStatusNyeri->jenis_nyeri = $request->jenis_nyeri;
        $asesmenObstetriStatusNyeri->frekuensi_nyeri = $request->frekuensi_nyeri;
        $asesmenObstetriStatusNyeri->menjalar = $request->menjalar;
        $asesmenObstetriStatusNyeri->kualitas_nyeri = $request->kualitas_nyeri;
        $asesmenObstetriStatusNyeri->faktor_pemberat = $request->faktor_pemberat;
        $asesmenObstetriStatusNyeri->faktor_peringan = $request->faktor_peringan;
        $asesmenObstetriStatusNyeri->kesimpulan_nyeri = $request->kesimpulan_nyeri;
        $obstetriEfekNyeri = $request->efek_nyeri;
        if ($obstetriEfekNyeri) {
            $efekNyeriArray = array_map('trim', explode(',', $obstetriEfekNyeri));
            $asesmenObstetriStatusNyeri->efek_nyeri = json_encode($efekNyeriArray);
        } else {
            $asesmenObstetriStatusNyeri->efek_nyeri = null;
        }
        $asesmenObstetriStatusNyeri->save();

        $asesmenObstetriRiwayatKesehatan = new RmeAsesmenObstetriRiwayatKesehatan();
        $asesmenObstetriRiwayatKesehatan->id_asesmen = $asesmen->id;
        $asesmenObstetriRiwayatKesehatan->gravid = $request->gravid;
        $asesmenObstetriRiwayatKesehatan->partus = $request->partus;
        $asesmenObstetriRiwayatKesehatan->abortus = $request->abortus;
        $asesmenObstetriRiwayatKesehatan->siklus = $request->siklus;
        $asesmenObstetriRiwayatKesehatan->lama_haid = $request->lama_haid;
        $asesmenObstetriRiwayatKesehatan->hari_pht = $request->hari_pht;
        $asesmenObstetriRiwayatKesehatan->usia_kehamilan = $request->usia_kehamilan;
        $asesmenObstetriRiwayatKesehatan->perkawinan_kali = $request->perkawinan_kali;
        $asesmenObstetriRiwayatKesehatan->perkawinan_usia = $request->perkawinan_usia;
        $asesmenObstetriRiwayatKesehatan->penambahan_bb = $request->penambahan_bb;
        $asesmenObstetriRiwayatKesehatan->kehamilan_diinginkan = $request->kehamilan_diinginkan;
        $asesmenObstetriRiwayatKesehatan->dukungan_sosial = $request->dukungan_sosial;
        $asesmenObstetriRiwayatKesehatan->eliminasi = $request->eliminasi;
        $asesmenObstetriRiwayatKesehatan->riwayat_rawat_inap = $request->riwayat_rawat_inap;
        $asesmenObstetriRiwayatKesehatan->tanggal_rawat = $request->tanggal_rawat;
        $asesmenObstetriRiwayatKesehatan->konsumsi_obat = $request->konsumsi_obat;
        $asesmenObstetriRiwayatKesehatan->antenatal_lain = $request->antenatal_lain;
        $asesmenObstetriRiwayatKesehatan->berapa_kali = $request->berapa_kali;

        $asesmenObstetriRiwayatKesehatan->riwayat_kehamilan_sekarang = $request->riwayat_kehamilan_sekarang;
        $obstetriIbuHamil = $request->kebiasaan_ibu_hamil;
        if ($obstetriIbuHamil) {
            $ibuHamil = array_map('trim', explode(',', $obstetriIbuHamil));
            $asesmenObstetriRiwayatKesehatan->kebiasaan_ibu_hamil = json_encode($ibuHamil);
        } else {
            $asesmenObstetriRiwayatKesehatan->kebiasaan_ibu_hamil = null;
        }

        $obstetriPengambilanKeputusan = $request->pengambilan_keputusan;
        if ($obstetriPengambilanKeputusan) {
            $pengambilanKeputusan = array_map('trim', explode(',', $obstetriPengambilanKeputusan));
            $asesmenObstetriRiwayatKesehatan->pengambilan_keputusan = json_encode($pengambilanKeputusan);
        } else {
            $asesmenObstetriRiwayatKesehatan->pengambilan_keputusan = null;
        }

        $obstetriPendamping = $request->pendamping;
        if ($obstetriPendamping) {
            $pendampingData = array_map('trim', explode(',', $obstetriPendamping));
            $asesmenObstetriRiwayatKesehatan->pendamping = json_encode($pendampingData);
        } else {
            $asesmenObstetriRiwayatKesehatan->pendamping = null;
        }
        $asesmenObstetriRiwayatKesehatan->riwayat_penyakin_keluarwa = $request->riwayat_penyakin_keluarwa;
        $asesmenObstetriRiwayatKesehatan->riwayat_obstetrik = $request->riwayat_obstetrik;

        $asesmenObstetriRiwayatKesehatan->save();

        $asesmenObstetriDischargePlanning = new RmeAsesmenObstetriDischargePlanning();
        $asesmenObstetriDischargePlanning->id_asesmen = $asesmen->id;
        $asesmenObstetriDischargePlanning->dp_diagnosis_medis = $request->dp_diagnosis_medis;
        $asesmenObstetriDischargePlanning->dp_usia_lanjut = $request->dp_usia_lanjut;
        $asesmenObstetriDischargePlanning->dp_hambatan_mobilisasi = $request->dp_hambatan_mobilisasi;
        $asesmenObstetriDischargePlanning->dp_layanan_medis_lanjutan = $request->dp_layanan_medis_lanjutan;
        $asesmenObstetriDischargePlanning->dp_tergantung_orang_lain = $request->dp_tergantung_orang_lain;
        $asesmenObstetriDischargePlanning->dp_lama_dirawat = $request->dp_lama_dirawat;
        $asesmenObstetriDischargePlanning->dp_rencana_pulang = $request->dp_rencana_pulang;
        $asesmenObstetriDischargePlanning->dp_kesimpulan = $request->dp_kesimpulan;
        $asesmenObstetriDischargePlanning->save();

        $asesmenObstetriDiagnosisImplementasi = new RmeAsesmenObstetriDiagnosisImplementasi();
        $asesmenObstetriDiagnosisImplementasi->id_asesmen = $asesmen->id;
        $asesmenObstetriDiagnosisImplementasi->diagnosis_banding = $request->diagnosis_banding;
        $asesmenObstetriDiagnosisImplementasi->diagnosis_kerja = $request->diagnosis_kerja;
        $asesmenObstetriDiagnosisImplementasi->prognosis = $request->prognosis;
        $asesmenObstetriDiagnosisImplementasi->observasi = $request->observasi;
        $asesmenObstetriDiagnosisImplementasi->terapeutik = $request->terapeutik;
        $asesmenObstetriDiagnosisImplementasi->edukasi = $request->edukasi;
        $asesmenObstetriDiagnosisImplementasi->kolaborasi = $request->kolaborasi;
        $asesmenObstetriDiagnosisImplementasi->save();

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
        function saveToColumn($dataList, $column)
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
        saveToColumn($rppList, 'prognosis'); // sudah terlanjut buat ke rpp jadi yang di ubah hanya name sesuai DB saja ke prognosis
        saveToColumn($observasiList, 'observasi');
        saveToColumn($terapeutikList, 'terapeutik');
        saveToColumn($edukasiList, 'edukasi');
        saveToColumn($kolaborasiList, 'kolaborasi');

        return redirect()->route('rawat-inap.asesmen.medis.umum.index', [
            'kd_unit' => request()->route('kd_unit'),
            'kd_pasien' => request()->route('kd_pasien'),
            'tgl_masuk' => request()->route('tgl_masuk'),
            'urut_masuk' => request()->route('urut_masuk'),
        ])->with(['success' => 'Berhasil menambah asesmen Obstetri!']);
        // return back()->with('success', 'Berhasil menambah asesmen Obstetri!');
    }

    public function show($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            // Ambil data asesmen beserta relasinya
            $asesmen = RmeAsesmen::with([
                'user',
                'asesmenObstetri',
                'rmeAsesmenObstetriPemeriksaanFisik',
                'pemeriksaanFisik',
                'rmeAsesmenObstetriStatusNyeri',
                'rmeAsesmenObstetriRiwayatKesehatan',
                'rmeAsesmenObstetriDischargePlanning',
                'rmeAsesmenObstetriDiagnosisImplementasi',
            ])->findOrFail($id);

            $dataMedis = Kunjungan::with('pasien')
                ->where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->firstOrFail();

            // dd($asesmen);
            // dd($dataMedis);

            return view('unit-pelayanan.rawat-inap.pelayanan.asesmen-obstetri-maternitas.show', compact(
                'asesmen',
                'dataMedis'
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
            // Cari asesmen berdasarkan ID dengan eager loading untuk semua relasi yang dibutuhkan
            $asesmen = RmeAsesmen::with([
                'user',
                'asesmenObstetri',
                'rmeAsesmenObstetriPemeriksaanFisik',
                'pemeriksaanFisik',
                'rmeAsesmenObstetriStatusNyeri',
                'rmeAsesmenObstetriRiwayatKesehatan',
                'rmeAsesmenObstetriDischargePlanning',
                'rmeAsesmenObstetriDiagnosisImplementasi',
            ])->findOrFail($id);

            // Pastikan data kunjungan pasien ditemukan dan sesuai dengan parameter
            $dataMedis = Kunjungan::with('pasien')
                ->where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->firstOrFail();

            // Ambil data pendukung
            $itemFisik = MrItemFisik::orderBy('urut')->get();
            $rmeMasterDiagnosis = RmeMasterDiagnosis::all();
            $rmeMasterImplementasi = RmeMasterImplementasi::all();

            // Kirim data ke view
            return view('unit-pelayanan.rawat-inap.pelayanan.asesmen-obstetri-maternitas.edit', compact(
                'asesmen',
                'dataMedis',
                'itemFisik',
                'rmeMasterDiagnosis',
                'rmeMasterImplementasi',
            ));
        } catch (\Exception $e) {
            // Tangani error dan berikan pesan yang jelas
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengambil data asesmen: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            $asesmen = RmeAsesmen::findOrFail($id);
            $asesmen->kd_pasien = $request->kd_pasien;
            $asesmen->kd_unit = $request->kd_unit;
            $asesmen->tgl_masuk = $request->tgl_masuk;
            $asesmen->urut_masuk = $request->urut_masuk;
            $asesmen->user_id = Auth::id();
            $asesmen->waktu_asesmen = date('Y-m-d H:i:s');
            $asesmen->kategori = 1;
            $asesmen->sub_kategori = 4;
            $asesmen->save();

            $request->validate([
                'hasil_pemeriksaan_penunjang_darah' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
                'hasil_pemeriksaan_penunjang_urine' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
                'hasil_pemeriksaan_penunjang_rontgent' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
                'hasil_pemeriksaan_penunjang_histopatology' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048'
            ]);

            $asesmenObstetri = RmeAsesmenObstetri::firstOrNew(['id_asesmen' => $asesmen->id]);
            $asesmenObstetri->id_asesmen = $asesmen->id;
            $asesmenObstetri->tgl_masuk = "$request->tgl_masuk $request->jam_masuk";
            $asesmenObstetri->antenatal_rs = $request->antenatal_rs;
            $asesmenObstetri->antenatal_rs_count = $request->antenatal_rs_count;
            $asesmenObstetri->antenatal_lain = $request->antenatal_lain;
            $asesmenObstetri->antenatal_lain_count = $request->antenatal_lain_count;
            $asesmenObstetri->nama_pemeriksa = Auth::user()->name;
            $asesmenObstetri->anamnesis_anamnesis = $request->anamnesis_anamnesis;
            $asesmenObstetri->evaluasi_evaluasi = $request->evaluasi_evaluasi;

            /// Fungsi helper untuk upload file
            $handleFile = function ($fieldName) use ($request, $asesmen, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk) {
                if ($request->has("remove_{$fieldName}")) {
                    $oldFile = $asesmen->asesmenObstetri->{$fieldName} ?? null;
                    if ($oldFile && Storage::exists($oldFile)) {
                        Storage::delete($oldFile);
                    }
                    return null;
                }

                if ($request->hasFile($fieldName)) {
                    try {
                        // Hapus file lama jika ada
                        $oldFile = $asesmen->asesmenObstetri->{$fieldName} ?? null;
                        if ($oldFile && Storage::exists($oldFile)) {
                            Storage::delete($oldFile);
                        }

                        // Upload file baru
                        $file = $request->file($fieldName);
                        $path = $file->store("uploads/ranap/asesmen-obstetri/$kd_unit/$kd_pasien/$tgl_masuk/$urut_masuk");

                        if ($path) {
                            return $path;
                        }
                    } catch (\Exception $e) {
                        throw new \Exception("Gagal mengupload file {$fieldName}: " . $e->getMessage());
                    }
                }

                // Jika ada nilai existing (file lama tetap dipertahankan)
                if ($request->has("existing_{$fieldName}")) {
                    return $request->input("existing_{$fieldName}");
                }

                // Jika tidak ada file baru dan tidak ada existing file, ambil nilai yang ada di database
                return $asesmen->asesmenObstetri->{$fieldName} ?? null;
            };

            // Siapkan data untuk update
            $PemeriksaanPenunjang = [
                'hasil_pemeriksaan_penunjang_darah' => $handleFile('hasil_pemeriksaan_penunjang_darah'),
                'hasil_pemeriksaan_penunjang_urine' => $handleFile('hasil_pemeriksaan_penunjang_urine'),
                'hasil_pemeriksaan_penunjang_rontgent' => $handleFile('hasil_pemeriksaan_penunjang_rontgent'),
                'hasil_pemeriksaan_penunjang_histopatology' => $handleFile('hasil_pemeriksaan_penunjang_histopatology'),
            ];

            // Update data asesmenObstetri
            if ($asesmen->asesmenObstetri) {
                $asesmen->asesmenObstetri->update($PemeriksaanPenunjang);
            } else {
                // Jika belum ada record, buat baru
                $PemeriksaanPenunjang['asesmen_id'] = $asesmen->id;
                RmeAsesmenObstetri::create($PemeriksaanPenunjang);
            }
            $asesmenObstetri->save();

            $asesmenObstetriPemeriksaanFisik = RmeAsesmenObstetriPemeriksaanFisik::firstOrNew(['id_asesmen' => $asesmen->id]);
            $asesmenObstetriPemeriksaanFisik->id_asesmen = $asesmen->id;
            $asesmenObstetriPemeriksaanFisik->keadaan_umum = $request->keadaan_umum;
            $asesmenObstetriPemeriksaanFisik->tekanan_darah_sistole = $request->tekanan_darah_sistole;
            $asesmenObstetriPemeriksaanFisik->tekanan_darah_diastole = $request->tekanan_darah_diastole;
            $asesmenObstetriPemeriksaanFisik->nadi = $request->nadi;
            $asesmenObstetriPemeriksaanFisik->pernafasan = $request->pernafasan;
            $asesmenObstetriPemeriksaanFisik->suhu = $request->suhu;
            $asesmenObstetriPemeriksaanFisik->kesadaran = $request->kesadaran;
            $asesmenObstetriPemeriksaanFisik->avpu = $request->avpu;
            $asesmenObstetriPemeriksaanFisik->komprehensif_posisi_janin = $request->komprehensif_posisi_janin;
            $asesmenObstetriPemeriksaanFisik->komprehensif_tinggi_fundus = $request->komprehensif_tinggi_fundus;
            $asesmenObstetriPemeriksaanFisik->kontraksi_frekuensi = $request->kontraksi_frekuensi;
            $asesmenObstetriPemeriksaanFisik->kontraksi_kekuatan = $request->kontraksi_kekuatan;
            $asesmenObstetriPemeriksaanFisik->kontraksi_irama = $request->kontraksi_irama;
            $asesmenObstetriPemeriksaanFisik->kontraksi_letak_janin = $request->kontraksi_letak_janin;
            $asesmenObstetriPemeriksaanFisik->kontraksi_presentasi_janin = $request->kontraksi_presentasi_janin;
            $asesmenObstetriPemeriksaanFisik->kontraksi_sikap_janin = $request->kontraksi_sikap_janin;
            $asesmenObstetriPemeriksaanFisik->djj_frekuensi = $request->djj_frekuensi;
            $asesmenObstetriPemeriksaanFisik->djj_irama = $request->djj_irama;
            $asesmenObstetriPemeriksaanFisik->serviks_konsistensi = $request->serviks_konsistensi;
            $asesmenObstetriPemeriksaanFisik->serviks_station = $request->serviks_station;
            $asesmenObstetriPemeriksaanFisik->serviks_penurunan = $request->serviks_penurunan;
            $asesmenObstetriPemeriksaanFisik->serviks_pembukaan = $request->serviks_pembukaan;
            $asesmenObstetriPemeriksaanFisik->serviks_jam_pembukaan = $request->serviks_jam_pembukaan;
            $asesmenObstetriPemeriksaanFisik->serviks_posisi = $request->serviks_posisi;
            $asesmenObstetriPemeriksaanFisik->serviks_irama = $request->serviks_irama;
            $asesmenObstetriPemeriksaanFisik->panggul_promontorium = $request->panggul_promontorium;
            $asesmenObstetriPemeriksaanFisik->panggul_line_terminalis = $request->panggul_line_terminalis;
            $asesmenObstetriPemeriksaanFisik->panggul_spina_ischiadika = $request->panggul_spina_ischiadika;
            $asesmenObstetriPemeriksaanFisik->panggul_arkus_pubis = $request->panggul_arkus_pubis;
            $asesmenObstetriPemeriksaanFisik->panggul_lengkung_sakrum = $request->panggul_lengkung_sakrum;
            $asesmenObstetriPemeriksaanFisik->panggul_dinding_samping = $request->panggul_dinding_samping;
            $asesmenObstetriPemeriksaanFisik->panggul_simpulan = $request->panggul_simpulan;
            $asesmenObstetriPemeriksaanFisik->panggul_pembukaan_cm = $request->panggul_pembukaan_cm;
            $asesmenObstetriPemeriksaanFisik->panggul_selaput_ketuban = $request->panggul_selaput_ketuban;
            $asesmenObstetriPemeriksaanFisik->panggul_air_ketuban = $request->panggul_air_ketuban;
            $asesmenObstetriPemeriksaanFisik->panggul_presentasi = $request->panggul_presentasi;
            $asesmenObstetriPemeriksaanFisik->antropometri_tinggi_badan = $request->antropometri_tinggi_badan;
            $asesmenObstetriPemeriksaanFisik->antropometr_berat_badan = $request->antropometr_berat_badan;
            $asesmenObstetriPemeriksaanFisik->antropometri_imt = $request->antropometri_imt;
            $asesmenObstetriPemeriksaanFisik->antropometri_lpt = $request->antropometri_lpt;
            $asesmenObstetriPemeriksaanFisik->save();

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

            $asesmenObstetriStatusNyeri = RmeAsesmenObstetriStatusNyeri::firstOrNew(['id_asesmen' => $asesmen->id]);
            $asesmenObstetriStatusNyeri->id_asesmen = $asesmen->id;
            $asesmenObstetriStatusNyeri->jenis_skala_nyeri = $request->jenis_skala_nyeri;
            $asesmenObstetriStatusNyeri->skala_nyeri = $request->skala_nyeri;
            $asesmenObstetriStatusNyeri->lokasi_nyeri = $request->lokasi_nyeri;
            $asesmenObstetriStatusNyeri->durasi_nyeri = $request->durasi_nyeri;
            $asesmenObstetriStatusNyeri->jenis_nyeri = $request->jenis_nyeri;
            $asesmenObstetriStatusNyeri->frekuensi_nyeri = $request->frekuensi_nyeri;
            $asesmenObstetriStatusNyeri->menjalar = $request->menjalar;
            $asesmenObstetriStatusNyeri->kualitas_nyeri = $request->kualitas_nyeri;
            $asesmenObstetriStatusNyeri->faktor_pemberat = $request->faktor_pemberat;
            $asesmenObstetriStatusNyeri->faktor_peringan = $request->faktor_peringan;
            $asesmenObstetriStatusNyeri->kesimpulan_nyeri = $request->kesimpulan_nyeri;
            $asesmenObstetriStatusNyeri->efek_nyeri = $request->efek_nyeri;
            $asesmenObstetriStatusNyeri->save();

            $asesmenObstetriRiwayatKesehatan = RmeAsesmenObstetriRiwayatKesehatan::firstOrNew(['id_asesmen' => $asesmen->id]);
            $asesmenObstetriRiwayatKesehatan->id_asesmen = $asesmen->id;
            $asesmenObstetriRiwayatKesehatan->gravid = $request->gravid;
            $asesmenObstetriRiwayatKesehatan->partus = $request->partus;
            $asesmenObstetriRiwayatKesehatan->abortus = $request->abortus;
            $asesmenObstetriRiwayatKesehatan->siklus = $request->siklus;
            $asesmenObstetriRiwayatKesehatan->lama_haid = $request->lama_haid;
            $asesmenObstetriRiwayatKesehatan->hari_pht = $request->hari_pht;
            $asesmenObstetriRiwayatKesehatan->usia_kehamilan = $request->usia_kehamilan;
            $asesmenObstetriRiwayatKesehatan->perkawinan_kali = $request->perkawinan_kali;
            $asesmenObstetriRiwayatKesehatan->perkawinan_usia = $request->perkawinan_usia;
            $asesmenObstetriRiwayatKesehatan->penambahan_bb = $request->penambahan_bb;
            $asesmenObstetriRiwayatKesehatan->kehamilan_diinginkan = $request->kehamilan_diinginkan;
            $asesmenObstetriRiwayatKesehatan->dukungan_sosial = $request->dukungan_sosial;
            $asesmenObstetriRiwayatKesehatan->eliminasi = $request->eliminasi;
            $asesmenObstetriRiwayatKesehatan->riwayat_rawat_inap = $request->riwayat_rawat_inap;
            $asesmenObstetriRiwayatKesehatan->tanggal_rawat = $request->tanggal_rawat;
            $asesmenObstetriRiwayatKesehatan->konsumsi_obat = $request->konsumsi_obat;
            $asesmenObstetriRiwayatKesehatan->antenatal_lain = $request->antenatal_lain;
            $asesmenObstetriRiwayatKesehatan->berapa_kali = $request->berapa_kali;

            $asesmenObstetriRiwayatKesehatan->riwayat_kehamilan_sekarang = $request->riwayat_kehamilan_sekarang;
            $asesmenObstetriRiwayatKesehatan->kebiasaan_ibu_hamil = $request->kebiasaan_ibu_hamil;
            $asesmenObstetriRiwayatKesehatan->pengambilan_keputusan = $request->pengambilan_keputusan;
            $asesmenObstetriRiwayatKesehatan->pendamping = $request->pendamping;
            $asesmenObstetriRiwayatKesehatan->riwayat_penyakin_keluarwa = $request->riwayat_penyakin_keluarwa;
            $asesmenObstetriRiwayatKesehatan->riwayat_obstetrik = $request->riwayat_obstetrik;

            $asesmenObstetriRiwayatKesehatan->save();

            $asesmenObstetriDischargePlanning = RmeAsesmenObstetriDischargePlanning::firstOrNew(['id_asesmen' => $asesmen->id]);
            $asesmenObstetriDischargePlanning->id_asesmen = $asesmen->id;
            $asesmenObstetriDischargePlanning->dp_diagnosis_medis = $request->dp_diagnosis_medis;
            $asesmenObstetriDischargePlanning->dp_usia_lanjut = $request->dp_usia_lanjut;
            $asesmenObstetriDischargePlanning->dp_hambatan_mobilisasi = $request->dp_hambatan_mobilisasi;
            $asesmenObstetriDischargePlanning->dp_layanan_medis_lanjutan = $request->dp_layanan_medis_lanjutan;
            $asesmenObstetriDischargePlanning->dp_tergantung_orang_lain = $request->dp_tergantung_orang_lain;
            $asesmenObstetriDischargePlanning->dp_lama_dirawat = $request->dp_lama_dirawat;
            $asesmenObstetriDischargePlanning->dp_rencana_pulang = $request->dp_rencana_pulang;
            $asesmenObstetriDischargePlanning->dp_kesimpulan = $request->dp_kesimpulan;
            $asesmenObstetriDischargePlanning->save();

            $asesmenObstetriDiagnosisImplementasi = RmeAsesmenObstetriDiagnosisImplementasi::firstOrNew(['id_asesmen' => $asesmen->id]);
            $asesmenObstetriDiagnosisImplementasi->id_asesmen = $asesmen->id;
            $asesmenObstetriDiagnosisImplementasi->diagnosis_banding = $request->diagnosis_banding;
            $asesmenObstetriDiagnosisImplementasi->diagnosis_kerja = $request->diagnosis_kerja;
            $asesmenObstetriDiagnosisImplementasi->prognosis = $request->prognosis;
            $asesmenObstetriDiagnosisImplementasi->observasi = $request->observasi;
            $asesmenObstetriDiagnosisImplementasi->terapeutik = $request->terapeutik;
            $asesmenObstetriDiagnosisImplementasi->edukasi = $request->edukasi;
            $asesmenObstetriDiagnosisImplementasi->kolaborasi = $request->kolaborasi;
            $asesmenObstetriDiagnosisImplementasi->save();

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
            function saveToColumnUpdate($dataList, $column)
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
            saveToColumnUpdate($rppList, 'prognosis'); // sudah terlanjut buat ke rpp jadi yang di ubah hanya name sesuai DB saja ke prognosis
            saveToColumnUpdate($observasiList, 'observasi');
            saveToColumnUpdate($terapeutikList, 'terapeutik');
            saveToColumnUpdate($edukasiList, 'edukasi');
            saveToColumnUpdate($kolaborasiList, 'kolaborasi');

            return redirect()->route('rawat-inap.asesmen.medis.umum.index', [
                'kd_unit' => request()->route('kd_unit'),
                'kd_pasien' => request()->route('kd_pasien'),
                'tgl_masuk' => request()->route('tgl_masuk'),
                'urut_masuk' => request()->route('urut_masuk'),
            ])->with(['success' => 'Berhasil mengupdate asesmen THT!']);
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
