<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\MrItemFisik;
use App\Models\RmeAsesmen;
use App\Models\RmeAsesmenKepPerinatology;
use App\Models\RmeAsesmenKepPerinatologyFisik;
use App\Models\RmeAsesmenKepPerinatologyFungsional;
use App\Models\RmeAsesmenKepPerinatologyGizi;
use App\Models\RmeAsesmenKepPerinatologyPemeriksaanLanjut;
use App\Models\RmeAsesmenKepPerinatologyRencanaPulang;
use App\Models\RmeAsesmenKepPerinatologyResikoDekubitus;
use App\Models\RmeAsesmenKepPerinatologyRisikoJatuh;
use App\Models\RmeAsesmenKepPerinatologyRiwayatIbu;
use App\Models\RmeAsesmenKepPerinatologyStatusNyeri;
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
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AsesmenKepPerinatologyController extends Controller
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

        return view('unit-pelayanan.rawat-inap.pelayanan.asesmen-perinatology.create', compact(
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
            $dataAsesmen->kategori = 2;
            $dataAsesmen->sub_kategori = 2;
            $dataAsesmen->anamnesis = $request->anamnesis;
            $alergis = collect(json_decode($request->alergis, true))->map(function ($item) {
                return [
                    'jenis' => $item['jenis'],
                    'alergen' => $item['alergen'],
                    'reaksi' => $item['reaksi'],
                    'keparahan' => $item['severe']
                ];
            })->toArray();
            $dataAsesmen->riwayat_alergi = json_encode($alergis);
            $dataAsesmen->save();


            //simpan ke table RmeAsesemnKepPerinatology
            $tglLahir = $request->tanggal_lahir;
            $jamLahir = $request->jam_lahir;
            $waktuLahir = $tglLahir . ' ' . $jamLahir;

            // Validasi file yang diunggah
            $request->validate([
                'sidik_kaki_kiri' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
                'sidik_kaki_kanan' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
                'sidik_jari_kiri' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
                'sidik_jari_kanan' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            ], [
                'sidik_kaki_kiri.mimes' => 'Format file sidik kaki kiri harus JPG, PNG, atau PDF',
                'sidik_kaki_kiri.max' => 'Ukuran file sidik kaki kiri maksimal 10MB',
                'sidik_kaki_kanan.mimes' => 'Format file sidik kaki kanan harus JPG, PNG, atau PDF',
                'sidik_kaki_kanan.max' => 'Ukuran file sidik kaki kanan maksimal 10MB',
                'sidik_jari_kiri.mimes' => 'Format file sidik jari kiri harus JPG, PNG, atau PDF',
                'sidik_jari_kiri.max' => 'Ukuran file sidik jari kiri maksimal 10MB',
                'sidik_jari_kanan.mimes' => 'Format file sidik jari kanan harus JPG, PNG, atau PDF',
                'sidik_jari_kanan.max' => 'Ukuran file sidik jari kanan maksimal 10MB',
            ]);

            $asesmenPerinatology = new RmeAsesmenKepPerinatology();
            $asesmenPerinatology->id_asesmen = $dataAsesmen->id;
            $asesmenPerinatology->data_masuk = $waktu_asesmen;
            $asesmenPerinatology->agama_orang_tua = $request->agama_orang_tua;
            $asesmenPerinatology->tgl_lahir_bayi = $waktuLahir;
            $asesmenPerinatology->nama_bayi = $request->nama_bayi;
            $asesmenPerinatology->jenis_kelamin = $request->jenis_kelamin;
            $asesmenPerinatology->nama_ibu = $request->nama_ibu;
            $asesmenPerinatology->nik_ibu = $request->nik_ibu;

            $pathSidikKakiKiri = ($request->hasFile('sidik_kaki_kiri')) ? $request->file('sidik_kaki_kiri')->store("uploads/ranap/asesmen-perinatology/$kd_unit/$kd_pasien/$tgl_masuk/$urut_masuk") : "";
            $pathSidikKakiKanan = ($request->hasFile('sidik_kaki_kanan')) ? $request->file('sidik_kaki_kanan')->store("uploads/ranap/asesmen-perinatology/$kd_unit/$kd_pasien/$tgl_masuk/$urut_masuk") : "";
            $pathSidikJariKiri = ($request->hasFile('sidik_jari_kiri')) ? $request->file('sidik_jari_kiri')->store("uploads/ranap/asesmen-perinatology/$kd_unit/$kd_pasien/$tgl_masuk/$urut_masuk") : "";
            $pathSidikJariKanan = ($request->hasFile('sidik_jari_kanan')) ? $request->file('sidik_jari_kanan')->store("uploads/ranap/asesmen-perinatology/$kd_unit/$kd_pasien/$tgl_masuk/$urut_masuk") : "";

            $asesmenPerinatology->sidik_telapak_kaki_kiri = $pathSidikKakiKiri;
            $asesmenPerinatology->sidik_telapak_kaki_kanan = $pathSidikKakiKanan;
            $asesmenPerinatology->sidik_jari_ibu_kiri = $pathSidikJariKiri;
            $asesmenPerinatology->sidik_jari_ibu_kanan = $pathSidikJariKanan;

            $asesmenPerinatology->alamat = $request->alamat;
            $asesmenPerinatology->diagnosis_banding = $request->diagnosis_banding ?? '[]';
            $asesmenPerinatology->diagnosis_kerja = $request->diagnosis_kerja ?? '[]';
            $asesmenPerinatology->prognosis = $request->prognosis;
            $asesmenPerinatology->observasi = $request->observasi;
            $asesmenPerinatology->terapeutik = $request->terapeutik;
            $asesmenPerinatology->edukasi = $request->edukasi;
            $asesmenPerinatology->kolaborasi = $request->kolaborasi;
            $asesmenPerinatology->evaluasi = $request->evaluasi_keperawatan;

            $asesmenPerinatology->gaya_bicara = $request->gaya_bicara;
            $asesmenPerinatology->bahasa = $request->bahasa_sehari_hari;
            $asesmenPerinatology->perlu_penerjemahan = $request->perlu_penerjemah;
            $asesmenPerinatology->hambatan_komunikasi = $request->hambatan_komunikasi;
            $asesmenPerinatology->media_disukai = $request->media_disukai;
            $asesmenPerinatology->tingkat_pendidikan = $request->tingkat_pendidikan;
            $asesmenPerinatology->save();

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

            //simpan ke table RmeAsesemnKepPerinatologyFisik
            $perinatologyFisik = new RmeAsesmenKepPerinatologyFisik();
            $perinatologyFisik->id_asesmen = $dataAsesmen->id;
            $perinatologyFisik->jenis_kelamin = $request->jenis_kelamin;
            $perinatologyFisik->frekuensi_nadi = $request->frekuensi_nadi;
            $perinatologyFisik->status_frekuensi = $request->status_frekuensi;
            $perinatologyFisik->nafas = $request->frekuensi_nafas;
            $perinatologyFisik->suhu = $request->suhu;
            $perinatologyFisik->spo2_tanpa_bantuan = $request->spo_tanpa_o2;
            $perinatologyFisik->spo2_dengan_bantuan = $request->spo_dengan_o2;
            $perinatologyFisik->tinggi_badan = $request->tinggi_badan;
            $perinatologyFisik->berat_badan = $request->berat_badan;
            $perinatologyFisik->lingkar_kepala = $request->lingkar_kepala;
            $perinatologyFisik->lingkar_dada = $request->lingkar_dada;
            $perinatologyFisik->lingkar_perut = $request->lingkar_perut;
            $perinatologyFisik->kesadaran = $request->kesadaran;
            $perinatologyFisik->avpu = $request->avpu;
            $perinatologyFisik->save();

            //simpan ke table RmeAsesemnKepPerinatologyPemeriksaanLanjut
            $perinatologyPemeriksaanLanjut = new RmeAsesmenKepPerinatologyPemeriksaanLanjut();
            $perinatologyPemeriksaanLanjut->id_asesmen = $dataAsesmen->id;
            $perinatologyPemeriksaanLanjut->warna_kulit = $request->warna_kulit;
            $perinatologyPemeriksaanLanjut->sianosis = $request->sianosis;
            $perinatologyPemeriksaanLanjut->kemerahan = $request->kemerahan;
            $perinatologyPemeriksaanLanjut->turgor_kulit = $request->turgor_kulit;
            $perinatologyPemeriksaanLanjut->tanda_lahir = $request->tanda_lahir;
            $perinatologyPemeriksaanLanjut->fontanel_anterior = $request->fontanel_anterior;
            $perinatologyPemeriksaanLanjut->sutura_sagitalis = $request->sutura_sagitalis;
            $perinatologyPemeriksaanLanjut->gambaran_wajah = $request->gambaran_wajah;
            $perinatologyPemeriksaanLanjut->cephalhemeton = $request->cephalhemeton;
            $perinatologyPemeriksaanLanjut->caput_succedaneun = $request->caput_succedaneun;
            $perinatologyPemeriksaanLanjut->mulut = $request->mulut;
            $perinatologyPemeriksaanLanjut->mucosa_mulut = $request->mucosa_mulut;
            $perinatologyPemeriksaanLanjut->dada_paru = $request->dada_paru;
            $perinatologyPemeriksaanLanjut->suara_nafas = $request->suara_nafas;
            $perinatologyPemeriksaanLanjut->respirasi = $request->respirasi;
            $perinatologyPemeriksaanLanjut->down_score = $request->down_score;
            $perinatologyPemeriksaanLanjut->bunyi_jantung = $request->bunyi_jantung;
            $perinatologyPemeriksaanLanjut->waktu_pengisian_kapiler = $request->waktu_pengisian_kapiler;
            $perinatologyPemeriksaanLanjut->keadaan_perut = $request->keadaan_perut;
            $perinatologyPemeriksaanLanjut->umbilikus = $request->umbilikus;
            $perinatologyPemeriksaanLanjut->warna_umbilikus = $request->warna_umbilikus;
            $perinatologyPemeriksaanLanjut->genitalis = $request->genitalis;
            $perinatologyPemeriksaanLanjut->gerakan = $request->gerakan;
            $perinatologyPemeriksaanLanjut->ekstremitas_atas = $request->ekstremitas_atas;
            $perinatologyPemeriksaanLanjut->ekstremitas_bawah = $request->ekstremitas_bawah;
            $perinatologyPemeriksaanLanjut->tulang_belakang = $request->tulang_belakang;
            $perinatologyPemeriksaanLanjut->refleks = $request->refleks;
            $perinatologyPemeriksaanLanjut->genggaman = $request->genggaman;
            $perinatologyPemeriksaanLanjut->menghisap = $request->menghisap;
            $perinatologyPemeriksaanLanjut->aktivitas = $request->aktivitas;
            $perinatologyPemeriksaanLanjut->menangis = $request->menangis;
            $perinatologyPemeriksaanLanjut->save();

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

            //simpan ke table RmeAsesemnKepPerinatologyRiwayatIbu
            $riwayatIbu = new RmeAsesmenKepPerinatologyRiwayatIbu();
            $riwayatIbu->id_asesmen = $dataAsesmen->id;
            $riwayatIbu->pemeriksaan_kehamilan = $request->pemeriksaan_kehamilan;
            $riwayatIbu->tempat_pemeriksaan = $request->tempat_pemeriksaan;
            $riwayatIbu->usia_kehamilan = $request->usia_kehamilan;
            $riwayatIbu->cara_persalinan = $request->cara_persalinan;

            // Handle riwayat penyakit dan pengobatan
            $riwayatJson = $request->input('riwayat_penyakit_pengobatan');
            if ($riwayatJson) {
                json_decode($riwayatJson);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $riwayatIbu->riwayat_penyakit_pengobatan = $riwayatJson;
                } else {
                    $riwayatIbu->riwayat_penyakit_pengobatan = json_encode([]);
                }
            } else {
                $riwayatIbu->riwayat_penyakit_pengobatan = json_encode([]);
            }

            $riwayatIbu->save();

            //Simpan ke table RmeKepPerinatologyStatusNyeri
            $statusNyeri = new RmeAsesmenKepPerinatologyStatusNyeri();
            $statusNyeri->id_asesmen = $dataAsesmen->id;
            if ($request->filled('jenis_skala_nyeri')) {
                $jenisSkala = [
                    'NRS' => 1,
                    'FLACC' => 2,
                    'CRIES' => 3
                ];
                $statusNyeri->jenis_skala_nyeri = $jenisSkala[$request->jenis_skala_nyeri];
                $statusNyeri->nilai_nyeri = $request->nilai_skala_nyeri;
                $statusNyeri->kesimpulan_nyeri = $request->kesimpulan_nyeri;

                // Jika skala FLACC dipilih
                if ($request->jenis_skala_nyeri === 'FLACC') {
                    $statusNyeri->flacc_wajah = $request->wajah ? json_encode($request->wajah) : null;
                    $statusNyeri->flacc_kaki = $request->kaki ? json_encode($request->kaki) : null;
                    $statusNyeri->flacc_aktivitas = $request->aktivitas ? json_encode($request->aktivitas) : null;
                    $statusNyeri->flacc_menangis = $request->menangis ? json_encode($request->menangis) : null;
                    $statusNyeri->flacc_konsolabilitas = $request->konsolabilitas ? json_encode($request->konsolabilitas) : null;
                    $statusNyeri->flacc_jumlah_skala = $request->flaccTotal;
                }

                // Jika skala CRIES dipilih
                if ($request->jenis_skala_nyeri === 'CRIES') {
                    $statusNyeri->cries_menangis = $request->menangis ? json_encode($request->menangis) : null;
                    $statusNyeri->cries_kebutuhan_oksigen = $request->oksigen ? json_encode($request->oksigen) : null;
                    $statusNyeri->cries_increased = $request->increased ? json_encode($request->increased) : null;
                    $statusNyeri->cries_wajah = $request->wajah ? json_encode($request->wajah) : null;
                    $statusNyeri->cries_sulit_tidur = $request->tidur ? json_encode($request->tidur) : null;
                    $statusNyeri->cries_jumlah_skala = $request->criesTotal;
                }

                $statusNyeri->lokasi = $request->lokasi_nyeri;
                $statusNyeri->durasi = $request->durasi_nyeri;
                $statusNyeri->jenis_nyeri = $request->jenis_nyeri;
                $statusNyeri->frekuensi = $request->frekuensi_nyeri;
                $statusNyeri->menjalar = $request->nyeri_menjalar;
                $statusNyeri->kualitas = $request->kualitas_nyeri;
                $statusNyeri->faktor_pemberat = $request->faktor_pemberat;
                $statusNyeri->faktor_peringan = $request->faktor_peringan;
                $statusNyeri->efek_nyeri = $request->efek_nyeri;
            }
            $statusNyeri->save();

            // Simpan ke table RmeAsesmenPerinatologyAnakRisikoJatuh
            $asesmenKepAnakRisikoJatuh = new RmeAsesmenKepPerinatologyRisikoJatuh();
            $asesmenKepAnakRisikoJatuh->id_asesmen = $dataAsesmen->id;
            if ($request->filled('resiko_jatuh_jenis')) {
                $asesmenKepAnakRisikoJatuh->resiko_jatuh_jenis = (int)$request->resiko_jatuh_jenis;

                // Handle intervensi risiko jatuh
                if ($request->has('intervensi_risiko_jatuh_json')) {
                    $asesmenKepAnakRisikoJatuh->intervensi_risiko_jatuh = $request->intervensi_risiko_jatuh_json;
                } else {
                    $asesmenKepAnakRisikoJatuh->intervensi_risiko_jatuh = '[]';
                }

                // Handle Skala Umum
                if ($request->resiko_jatuh_jenis == 1) {
                    $asesmenKepAnakRisikoJatuh->risiko_jatuh_umum_usia = $request->risiko_jatuh_umum_usia ? 1 : 0;
                    $asesmenKepAnakRisikoJatuh->risiko_jatuh_umum_kondisi_khusus = $request->risiko_jatuh_umum_kondisi_khusus ? 1 : 0;
                    $asesmenKepAnakRisikoJatuh->risiko_jatuh_umum_diagnosis_parkinson = $request->risiko_jatuh_umum_diagnosis_parkinson ? 1 : 0;
                    $asesmenKepAnakRisikoJatuh->risiko_jatuh_umum_pengobatan_berisiko = $request->risiko_jatuh_umum_pengobatan_berisiko ? 1 : 0;
                    $asesmenKepAnakRisikoJatuh->risiko_jatuh_umum_lokasi_berisiko = $request->risiko_jatuh_umum_lokasi_berisiko ? 1 : 0;
                    $asesmenKepAnakRisikoJatuh->kesimpulan_skala_umum = $request->input('risiko_jatuh_umum_kesimpulan', 'Tidak berisiko jatuh');
                }

                // Handle Skala Morse
                if ($request->resiko_jatuh_jenis == 2) {
                    $asesmenKepAnakRisikoJatuh->risiko_jatuh_morse_riwayat_jatuh = array_search($request->risiko_jatuh_morse_riwayat_jatuh, ['25' => 25, '0' => 0]);
                    $asesmenKepAnakRisikoJatuh->risiko_jatuh_morse_diagnosis_sekunder = array_search($request->risiko_jatuh_morse_diagnosis_sekunder, ['15' => 15, '0' => 0]);
                    $asesmenKepAnakRisikoJatuh->risiko_jatuh_morse_bantuan_ambulasi = array_search($request->risiko_jatuh_morse_bantuan_ambulasi, ['30' => 30, '15' => 15, '0' => 0]);
                    $asesmenKepAnakRisikoJatuh->risiko_jatuh_morse_terpasang_infus = array_search($request->risiko_jatuh_morse_terpasang_infus, ['20' => 20, '0' => 0]);
                    $asesmenKepAnakRisikoJatuh->risiko_jatuh_morse_cara_berjalan = array_search($request->risiko_jatuh_morse_cara_berjalan, ['0' => 0, '20' => 20, 10 => 10]);
                    $asesmenKepAnakRisikoJatuh->risiko_jatuh_morse_status_mental = array_search($request->risiko_jatuh_morse_status_mental, ['0' => 0, '15' => 15]);
                    $asesmenKepAnakRisikoJatuh->kesimpulan_skala_morse = $request->risiko_jatuh_morse_kesimpulan;
                }

                // Handle Skala Pediatrik/Humpty
                if ($request->resiko_jatuh_jenis == 3) {
                    $asesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_usia_anak = array_search((int)$request->risiko_jatuh_pediatrik_usia_anak, ['4' => 4, '3' => 3, '2' => 2, '1' => 1]);
                    $asesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_jenis_kelamin = array_search($request->risiko_jatuh_pediatrik_jenis_kelamin, ['2' => 2, '1' => 1]);
                    $asesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_diagnosis = array_search($request->risiko_jatuh_pediatrik_diagnosis, ['4' => 4, '3' => 3, '2' => 2, '1' => 1]);
                    $asesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_gangguan_kognitif = array_search($request->risiko_jatuh_pediatrik_gangguan_kognitif, ['3' => 3, '2' => 2, '1' => 1]);
                    $asesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_faktor_lingkungan = array_search($request->risiko_jatuh_pediatrik_faktor_lingkungan, ['4' => 4, '3' => 3, '2' => 2, '1' => 1]);
                    $asesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_pembedahan = array_search($request->risiko_jatuh_pediatrik_pembedahan, ['3' => 3, '2' => 2, '1' => 1]);
                    $asesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_penggunaan_mentosa = array_search($request->risiko_jatuh_pediatrik_penggunaan_mentosa, ['3' => 3, '2' => 2, '1' => 1]);
                    $asesmenKepAnakRisikoJatuh->kesimpulan_skala_pediatrik = $request->risiko_jatuh_pediatrik_kesimpulan;
                }

                // Handle Skala Lansia/Ontario
                if ($request->resiko_jatuh_jenis == 4) {
                    $asesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_jatuh_saat_masuk_rs = array_search($request->risiko_jatuh_lansia_jatuh_saat_masuk_rs, ['6' => 6, '0' => 0]);
                    $asesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_riwayat_jatuh_2_bulan = array_search($request->risiko_jatuh_lansia_riwayat_jatuh_2_bulan, ['6' => 6, '0' => 0]);
                    $asesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_status_bingung = array_search($request->risiko_jatuh_lansia_status_bingung, ['14' => 14, '0' => 0]);
                    $asesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_status_disorientasi = array_search($request->risiko_jatuh_lansia_status_disorientasi, ['14' => 14, '0' => 0]);
                    $asesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_status_agitasi = array_search($request->risiko_jatuh_lansia_status_agitasi, ['14' => 14, '0' => 0]);
                    $asesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_kacamata = $request->risiko_jatuh_lansia_kacamata;
                    $asesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_kelainan_penglihatan = $request->risiko_jatuh_lansia_kelainan_penglihatan;
                    $asesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_glukoma = $request->risiko_jatuh_lansia_glukoma;
                    $asesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_perubahan_berkemih = array_search($request->risiko_jatuh_lansia_perubahan_berkemih, ['2' => 2, '0' => 0]);
                    $asesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_transfer_mandiri = $request->risiko_jatuh_lansia_transfer_mandiri;
                    $asesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_sedikit = $request->risiko_jatuh_lansia_transfer_bantuan_sedikit;
                    $asesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_nyata = array_search($request->risiko_jatuh_lansia_transfer_bantuan_nyata, ['2' => 2, '0' => 0]);
                    $asesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_total = array_search($request->risiko_jatuh_lansia_transfer_bantuan_total, ['3' => 2, '0' => 0]);
                    $asesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_mobilitas_mandiri = $request->risiko_jatuh_lansia_mobilitas_mandiri;
                    $asesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_mobilitas_bantuan_1_orang = $request->risiko_jatuh_lansia_mobilitas_bantuan_1_orang;
                    $asesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_mobilitas_kursi_roda = array_search($request->risiko_jatuh_lansia_mobilitas_kursi_roda, ['2' => 2, '0' => 0]);
                    $asesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_mobilitas_imobilisasi = array_search($request->risiko_jatuh_lansia_mobilitas_imobilisasi, ['3' => 2, '0' => 0]);
                    $asesmenKepAnakRisikoJatuh->kesimpulan_skala_lansia = $request->risiko_jatuh_lansia_kesimpulan;
                }

                // Handle Skala Lainnya
                if ($request->resiko_jatuh_jenis == 5) {
                    $asesmenKepAnakRisikoJatuh->resiko_jatuh_lainnya = 'resiko jatuh lainnya';
                }

                $asesmenKepAnakRisikoJatuh->save();
            }

            //Simpan ke table RmeAsesmenKepAnakStatusDecubitus
            $decubitusData = new RmeAsesmenKepPerinatologyResikoDekubitus();
            $decubitusData->id_asesmen = $dataAsesmen->id;

            $jenisSkala = $request->input('jenis_skala_dekubitus') === 'norton' ? 1 : 2;
            $decubitusData->jenis_skala = $jenisSkala;

            function getRiskConclusion($score)
            {
                if ($score <= 12) {
                    return 'Risiko Tinggi';
                } elseif ($score <= 14) {
                    return 'Risiko Sedang';
                }
                return 'Risiko Rendah';
            }

            if ($jenisSkala === 1) {
                // Norton
                $decubitusData->norton_kondisi_fisik   = $request->input('kondisi_fisik');
                $decubitusData->norton_kondisi_mental  = $request->input('kondisi_mental');
                $decubitusData->norton_aktivitas       = $request->input('norton_aktivitas');
                $decubitusData->norton_mobilitas       = $request->input('norton_mobilitas');
                $decubitusData->norton_inkontenesia    = $request->input('inkontinensia');

                $totalScore =
                    (int)$request->input('kondisi_fisik') +
                    (int)$request->input('kondisi_mental') +
                    (int)$request->input('norton_aktivitas') +
                    (int)$request->input('norton_mobilitas') +
                    (int)$request->input('inkontinensia');

                $decubitusData->decubitus_kesimpulan = getRiskConclusion($totalScore);
            } else {
                // Braden
                $decubitusData->braden_persepsi       = $request->input('persepsi_sensori');
                $decubitusData->braden_kelembapan     = $request->input('kelembapan');
                $decubitusData->braden_aktivitas      = $request->input('braden_aktivitas');
                $decubitusData->braden_mobilitas      = $request->input('braden_mobilitas');
                $decubitusData->braden_nutrisi        = $request->input('nutrisi');
                $decubitusData->braden_pergesekan     = $request->input('pergesekan');

                $totalScore =
                    (int)$request->input('persepsi_sensori') +
                    (int)$request->input('kelembapan') +
                    (int)$request->input('braden_aktivitas') +
                    (int)$request->input('braden_mobilitas') +
                    (int)$request->input('nutrisi') +
                    (int)$request->input('pergesekan');

                $decubitusData->decubitus_kesimpulan = getRiskConclusion($totalScore);
            }
            $decubitusData->save();


            //Simpan ke table RmeAsesmenKepAnakGizi
            $asesmenKepPerinatologyStatusGizi = new RmeAsesmenKepPerinatologyGizi();
            $asesmenKepPerinatologyStatusGizi->id_asesmen = $dataAsesmen->id;
            $asesmenKepPerinatologyStatusGizi->gizi_jenis = (int)$request->gizi_jenis;

            if (
                $request->gizi_jenis == 1
            ) {
                $asesmenKepPerinatologyStatusGizi->gizi_mst_penurunan_bb = $request->gizi_mst_penurunan_bb;
                $asesmenKepPerinatologyStatusGizi->gizi_mst_jumlah_penurunan_bb = $request->gizi_mst_jumlah_penurunan_bb;
                $asesmenKepPerinatologyStatusGizi->gizi_mst_nafsu_makan_berkurang = $request->gizi_mst_nafsu_makan_berkurang;
                $asesmenKepPerinatologyStatusGizi->gizi_mst_diagnosis_khusus = $request->gizi_mst_diagnosis_khusus;
                $asesmenKepPerinatologyStatusGizi->gizi_mst_kesimpulan = $request->gizi_mst_kesimpulan;
            } else if ($request->gizi_jenis == 2) {
                $asesmenKepPerinatologyStatusGizi->gizi_mna_penurunan_asupan_3_bulan = (int)$request->gizi_mna_penurunan_asupan_3_bulan;
                $asesmenKepPerinatologyStatusGizi->gizi_mna_kehilangan_bb_3_bulan = (int)$request->gizi_mna_kehilangan_bb_3_bulan;
                $asesmenKepPerinatologyStatusGizi->gizi_mna_mobilisasi = (int)$request->gizi_mna_mobilisasi;
                $asesmenKepPerinatologyStatusGizi->gizi_mna_stress_penyakit_akut = (int)$request->gizi_mna_stress_penyakit_akut;
                $asesmenKepPerinatologyStatusGizi->gizi_mna_status_neuropsikologi = (int)$request->gizi_mna_status_neuropsikologi;
                $asesmenKepPerinatologyStatusGizi->gizi_mna_berat_badan = (int)$request->gizi_mna_berat_badan;
                $asesmenKepPerinatologyStatusGizi->gizi_mna_tinggi_badan = (int)$request->gizi_mna_tinggi_badan;

                // Hitung dan simpan IMT
                $heightInMeters = $request->gizi_mna_tinggi_badan / 100;
                $imt = $request->gizi_mna_berat_badan / ($heightInMeters * $heightInMeters);
                $asesmenKepPerinatologyStatusGizi->gizi_mna_imt = number_format($imt, 2, '.', '');

                $asesmenKepPerinatologyStatusGizi->gizi_mna_kesimpulan = $request->gizi_mna_kesimpulan;
            } else if ($request->gizi_jenis == 3) {
                $asesmenKepPerinatologyStatusGizi->gizi_strong_status_kurus = $request->gizi_strong_status_kurus;
                $asesmenKepPerinatologyStatusGizi->gizi_strong_penurunan_bb = $request->gizi_strong_penurunan_bb;
                $asesmenKepPerinatologyStatusGizi->gizi_strong_gangguan_pencernaan = $request->gizi_strong_gangguan_pencernaan;
                $asesmenKepPerinatologyStatusGizi->gizi_strong_penyakit_berisiko = $request->gizi_strong_penyakit_berisiko;
                $asesmenKepPerinatologyStatusGizi->gizi_strong_kesimpulan = $request->gizi_strong_kesimpulan;
            } else if ($request->gizi_jenis == 4) {
                $asesmenKepPerinatologyStatusGizi->gizi_nrs_jatuh_saat_masuk_rs = $request->gizi_nrs_jatuh_saat_masuk_rs;
                $asesmenKepPerinatologyStatusGizi->gizi_nrs_jatuh_2_bulan_terakhir = $request->gizi_nrs_jatuh_2_bulan_terakhir;
                $asesmenKepPerinatologyStatusGizi->gizi_nrs_status_delirium = $request->gizi_nrs_status_delirium;
                $asesmenKepPerinatologyStatusGizi->gizi_nrs_status_disorientasi = $request->gizi_nrs_status_disorientasi;
                $asesmenKepPerinatologyStatusGizi->gizi_nrs_status_agitasi = $request->gizi_nrs_status_agitasi;
                $asesmenKepPerinatologyStatusGizi->gizi_nrs_menggunakan_kacamata = $request->gizi_nrs_menggunakan_kacamata;
                $asesmenKepPerinatologyStatusGizi->gizi_nrs_keluhan_penglihatan_buram = $request->gizi_nrs_keluhan_penglihatan_buram;
                $asesmenKepPerinatologyStatusGizi->gizi_nrs_degenerasi_makula = $request->gizi_nrs_degenerasi_makula;
                $asesmenKepPerinatologyStatusGizi->gizi_nrs_perubahan_berkemih = $request->gizi_nrs_perubahan_berkemih;
                $asesmenKepPerinatologyStatusGizi->gizi_nrs_transfer_mandiri = $request->gizi_nrs_transfer_mandiri;
                $asesmenKepPerinatologyStatusGizi->gizi_nrs_transfer_bantuan_1_orang = $request->gizi_nrs_transfer_bantuan_1_orang;
                $asesmenKepPerinatologyStatusGizi->gizi_nrs_transfer_bantuan_2_orang = $request->gizi_nrs_transfer_bantuan_2_orang;
                $asesmenKepPerinatologyStatusGizi->gizi_nrs_transfer_bantuan_total = $request->gizi_nrs_transfer_bantuan_total;
                $asesmenKepPerinatologyStatusGizi->gizi_nrs_mobilitas_mandiri = $request->gizi_nrs_mobilitas_mandiri;
                $asesmenKepPerinatologyStatusGizi->gizi_nrs_mobilitas_bantuan_1_orang = $request->gizi_nrs_mobilitas_bantuan_1_orang;
                $asesmenKepPerinatologyStatusGizi->gizi_nrs_mobilitas_kursi_roda = $request->gizi_nrs_mobilitas_kursi_roda;
                $asesmenKepPerinatologyStatusGizi->gizi_nrs_mobilitas_imobilisasi = $request->gizi_nrs_mobilitas_imobilisasi;
                $asesmenKepPerinatologyStatusGizi->gizi_nrs_kesimpulan = $request->gizi_nrs_kesimpulan;
            } else if ($request->gizi_jenis == 5) {
                $asesmenKepPerinatologyStatusGizi->status_gizi_tidakada = 'tidak ada status gizi';
            }

            $asesmenKepPerinatologyStatusGizi->save();

            //Simpan ke table RmeAsesmenKepAnakStatusFungsional
            $statusFungsional = new RmeAsesmenKepPerinatologyFungsional();
            $statusFungsional->id_asesmen = $dataAsesmen->id;

            if ($request->filled('skala_fungsional')) {

                if ($request->filled('skala_fungsional')) {
                    if ($request->skala_fungsional === 'Pengkajian Aktivitas') {
                        $statusFungsional->jenis_skala = 1;
                    } else if ($request->skala_fungsional === 'Lainnya') {
                        $statusFungsional->jenis_skala = 2;
                    }
                } else {
                    $statusFungsional->jenis_skala = 0;
                }

                // Simpan data ADL
                $statusFungsional->makan = $request->adl_makan;
                $statusFungsional->berjalan = $request->adl_berjalan;
                $statusFungsional->mandi = $request->adl_mandi;
                $statusFungsional->jumlah_skala = $request->filled('adl_total') ? (int)$request->adl_total : null;
                $statusFungsional->kesimpulan = $request->adl_kesimpulan_value;
                $statusFungsional->nilai_skala_adl = $request->filled('adl_total') ? (int)$request->adl_total : null;
                $statusFungsional->kesimpulan_fungsional = $request->adl_kesimpulan_value;
            }
            $statusFungsional->save();


            // Simpan ke table RmeAsesmenKepAnakRencana
            $asesmenRencana = new RmeAsesmenKepPerinatologyRencanaPulang();
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
                        'hasil' => ''
                    ],
                    'distole'   => [
                        'hasil' => ''
                    ],
                    'respiration_rate'   => [
                        'hasil' => ''
                    ],
                    'suhu'   => [
                        'hasil' => $request->suhu
                    ],
                    'nadi'   => [
                        'hasil' => ''
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

            return redirect()->to(url("unit-pelayanan/rawat-inap/unit/$kd_unit/pelayanan/$kd_pasien/$tgl_masuk/$urut_masuk/asesmen/medis/umum"))
                ->with('success', 'Data asesmen anak berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan data asesmen' . $e->getMessage());
        }
    }

    public function show($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {

            $asesmen = RmeAsesmen::with([
                'pemeriksaanFisik.itemFisik',
                'rmeAsesmenPerinatology',
                'rmeAsesmenPerinatologyFisik',
                'rmeAsesmenPerinatologyPemeriksaanLanjut',
                'rmeAsesmenPerinatologyRiwayatIbu',
                'rmeAsesmenPerinatologyStatusNyeri',
                'rmeAsesmenPerinatologyRisikoJatuh',
                'rmeAsesmenPerinatologyResikoDekubitus',
                'rmeAsesmenPerinatologyGizi',
                'rmeAsesmenPerinatologyFungsional',
                'rmeAsesmenPerinatologyRencanaPulang'
            ])->findOrFail($id);

            // dd($asesmen);
            // Mengambil data medis pasien
            $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
                ->join('transaksi as t', function ($join) {
                    $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                    $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                    $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                    $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
                })
                ->where('kunjungan.kd_unit', $kd_unit)
                ->where('kunjungan.kd_pasien', $kd_pasien)
                ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
                ->where('kunjungan.urut_masuk', $urut_masuk)
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

            // Mengambil data tambahan yang diperlukan untuk tampilan
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

            return view('unit-pelayanan.rawat-inap.pelayanan.asesmen-perinatology.show', compact(
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
                'asesmen',
                'user'
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
            // Ambil data asesmen beserta semua relasinya
            $asesmen = RmeAsesmen::with([
                'user',
                'pemeriksaanFisik.itemFisik',
                'rmeAsesmenPerinatology',
                'rmeAsesmenPerinatologyFisik',
                'rmeAsesmenPerinatologyPemeriksaanLanjut',
                'rmeAsesmenPerinatologyRiwayatIbu',
                'rmeAsesmenPerinatologyStatusNyeri',
                'rmeAsesmenPerinatologyRisikoJatuh',
                'rmeAsesmenPerinatologyResikoDekubitus',
                'rmeAsesmenPerinatologyGizi',
                'rmeAsesmenPerinatologyFungsional',
                'rmeAsesmenPerinatologyRencanaPulang'
            ])->findOrFail($id);



            // Pastikan data kunjungan pasien ditemukan dan sesuai dengan parameter
            $dataMedis = Kunjungan::with('pasien')
                ->where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->whereDate('tgl_masuk', date('Y-m-d', strtotime($tgl_masuk)))
                ->where('urut_masuk', $urut_masuk)
                ->firstOrFail();

            // Mengambil umur pasien
            if ($dataMedis->pasien->tgl_lahir) {
                $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
            } else {
                $dataMedis->pasien->umur = 'Tidak Diketahui';
            }

            $dataMedis->waktu_masuk = Carbon::parse($dataMedis->TGL_MASUK . ' ' . $dataMedis->JAM_MASUK)->format('Y-m-d H:i:s');

            // Mengambil data tambahan yang diperlukan untuk tampilan
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
            $user = auth()->user();



            return view('unit-pelayanan.rawat-inap.pelayanan.asesmen-perinatology.edit', compact(
                'asesmen',
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
                'user',
                'kd_unit',
                'kd_pasien',
                'tgl_masuk',
                'urut_masuk'
            ));
        } catch (ModelNotFoundException $e) {
            return back()->with('error', 'Data tidak ditemukan. Detail: ' . $e->getMessage());
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id, Request $request)
    {
        DB::beginTransaction();

        try {
            // Ambil data asesmen yang akan diupdate
            $dataAsesmen = RmeAsesmen::findOrFail($id);
            $dataAsesmen->user_id = Auth::id();
            $dataAsesmen->kd_pasien = $kd_pasien;
            $dataAsesmen->kd_unit = $kd_unit;
            $dataAsesmen->tgl_masuk = $tgl_masuk;
            $dataAsesmen->urut_masuk = $urut_masuk;
            $dataAsesmen->kategori = 2;
            $dataAsesmen->sub_kategori = 2;

            // Update data asesmen
            $tanggal = $request->tanggal_masuk;
            $jam = $request->jam_masuk;
            $waktu_asesmen = $tanggal . ' ' . $jam;

            $dataAsesmen->waktu_asesmen = $waktu_asesmen;
            $dataAsesmen->anamnesis = $request->anamnesis;

            // Update alergi
            $alergis = collect(json_decode($request->alergis, true))->map(function ($item) {
                return [
                    'jenis' => $item['jenis'],
                    'alergen' => $item['alergen'],
                    'reaksi' => $item['reaksi'],
                    'keparahan' => $item['severe']
                ];
            })->toArray();
            $dataAsesmen->riwayat_alergi = json_encode($alergis);
            $dataAsesmen->save();

            // Update RmeAsesmenKepPerinatology
            $tglLahir = $request->tanggal_lahir;
            $jamLahir = $request->jam_lahir;
            $waktuLahir = $tglLahir . ' ' . $jamLahir;

            // Validasi file yang diunggah
            $request->validate([
                'sidik_kaki_kiri' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
                'sidik_kaki_kanan' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
                'sidik_jari_kiri' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
                'sidik_jari_kanan' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            ]);

            // Update atau buat baru jika belum ada
            $asesmenPerinatology = RmeAsesmenKepPerinatology::where('id_asesmen', $id)->first();
            if (!$asesmenPerinatology) {
                $asesmenPerinatology = new RmeAsesmenKepPerinatology();
                $asesmenPerinatology->id_asesmen = $id;
            }

            $asesmenPerinatology->data_masuk = $waktu_asesmen;
            $asesmenPerinatology->agama_orang_tua = $request->agama_orang_tua;
            $asesmenPerinatology->tgl_lahir_bayi = $waktuLahir;
            $asesmenPerinatology->nama_bayi = $request->nama_bayi;
            $asesmenPerinatology->jenis_kelamin = $request->jenis_kelamin;
            $asesmenPerinatology->nama_ibu = $request->nama_ibu;
            $asesmenPerinatology->nik_ibu = $request->nik_ibu;

            // Handle file uploads
            if ($request->hasFile('sidik_kaki_kiri')) {
                $pathSidikKakiKiri = $request->file('sidik_kaki_kiri')->store("uploads/ranap/asesmen-perinatology/$kd_unit/$kd_pasien/$tgl_masuk/$urut_masuk");
                $asesmenPerinatology->sidik_telapak_kaki_kiri = $pathSidikKakiKiri;
            }

            if ($request->hasFile('sidik_kaki_kanan')) {
                $pathSidikKakiKanan = $request->file('sidik_kaki_kanan')->store("uploads/ranap/asesmen-perinatology/$kd_unit/$kd_pasien/$tgl_masuk/$urut_masuk");
                $asesmenPerinatology->sidik_telapak_kaki_kanan = $pathSidikKakiKanan;
            }

            if ($request->hasFile('sidik_jari_kiri')) {
                $pathSidikJariKiri = $request->file('sidik_jari_kiri')->store("uploads/ranap/asesmen-perinatology/$kd_unit/$kd_pasien/$tgl_masuk/$urut_masuk");
                $asesmenPerinatology->sidik_jari_ibu_kiri = $pathSidikJariKiri;
            }

            if ($request->hasFile('sidik_jari_kanan')) {
                $pathSidikJariKanan = $request->file('sidik_jari_kanan')->store("uploads/ranap/asesmen-perinatology/$kd_unit/$kd_pasien/$tgl_masuk/$urut_masuk");
                $asesmenPerinatology->sidik_jari_ibu_kanan = $pathSidikJariKanan;
            }

            $asesmenPerinatology->alamat = $request->alamat;
            $asesmenPerinatology->diagnosis_banding = $request->diagnosis_banding ?? '[]';
            $asesmenPerinatology->diagnosis_kerja = $request->diagnosis_kerja ?? '[]';
            $asesmenPerinatology->prognosis = $request->prognosis;
            $asesmenPerinatology->observasi = $request->observasi;
            $asesmenPerinatology->terapeutik = $request->terapeutik;
            $asesmenPerinatology->edukasi = $request->edukasi;
            $asesmenPerinatology->kolaborasi = $request->kolaborasi;
            $asesmenPerinatology->evaluasi = $request->evaluasi_keperawatan;

            $asesmenPerinatology->gaya_bicara = $request->gaya_bicara;
            $asesmenPerinatology->bahasa = $request->bahasa_sehari_hari;
            $asesmenPerinatology->perlu_penerjemahan = $request->perlu_penerjemah;
            $asesmenPerinatology->hambatan_komunikasi = $request->hambatan_komunikasi;
            $asesmenPerinatology->media_disukai = $request->media_disukai;
            $asesmenPerinatology->tingkat_pendidikan = $request->tingkat_pendidikan;
            $asesmenPerinatology->save();

            // Simpan Diagnosa ke Master
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

            // Update RmeAsesmenKepPerinatologyFisik
            $perinatologyFisik = RmeAsesmenKepPerinatologyFisik::where('id_asesmen', $id)->first();
            if (!$perinatologyFisik) {
                $perinatologyFisik = new RmeAsesmenKepPerinatologyFisik();
                $perinatologyFisik->id_asesmen = $id;
            }

            $perinatologyFisik->jenis_kelamin = $request->jenis_kelamin;
            $perinatologyFisik->frekuensi_nadi = $request->frekuensi_nadi;
            $perinatologyFisik->status_frekuensi = $request->status_frekuensi;
            $perinatologyFisik->nafas = $request->nafas; // Perhatikan perubahan dari frekuensi_nafas menjadi nafas
            $perinatologyFisik->suhu = $request->suhu;
            $perinatologyFisik->spo2_tanpa_bantuan = $request->saturasi_o2_tanpa; // Perubahan nama field
            $perinatologyFisik->spo2_dengan_bantuan = $request->saturasi_o2_dengan; // Perubahan nama field
            $perinatologyFisik->tinggi_badan = $request->tinggi_badan;
            $perinatologyFisik->berat_badan = $request->berat_badan;
            $perinatologyFisik->lingkar_kepala = $request->lingkar_kepala;
            $perinatologyFisik->lingkar_dada = $request->lingkar_dada;
            $perinatologyFisik->lingkar_perut = $request->lingkar_perut;
            $perinatologyFisik->kesadaran = $request->kesadaran;
            $perinatologyFisik->avpu = $request->avpu;
            $perinatologyFisik->save();

            // Update RmeAsesmenKepPerinatologyPemeriksaanLanjut
            $perinatologyPemeriksaanLanjut = RmeAsesmenKepPerinatologyPemeriksaanLanjut::where('id_asesmen', $id)->first();
            if (!$perinatologyPemeriksaanLanjut) {
                $perinatologyPemeriksaanLanjut = new RmeAsesmenKepPerinatologyPemeriksaanLanjut();
                $perinatologyPemeriksaanLanjut->id_asesmen = $id;
            }

            $perinatologyPemeriksaanLanjut->warna_kulit = $request->warna_kulit;
            $perinatologyPemeriksaanLanjut->sianosis = $request->sianosis;
            $perinatologyPemeriksaanLanjut->kemerahan = $request->kemerahan;
            $perinatologyPemeriksaanLanjut->turgor_kulit = $request->turgor_kulit;
            $perinatologyPemeriksaanLanjut->tanda_lahir = $request->tanda_lahir;
            $perinatologyPemeriksaanLanjut->fontanel_anterior = $request->fontanel_anterior;
            $perinatologyPemeriksaanLanjut->sutura_sagitalis = $request->sutura_sagitalis;
            $perinatologyPemeriksaanLanjut->gambaran_wajah = $request->gambaran_wajah;
            $perinatologyPemeriksaanLanjut->cephalhemeton = $request->cephalhemeton;
            $perinatologyPemeriksaanLanjut->caput_succedaneun = $request->caput_succedaneun;
            $perinatologyPemeriksaanLanjut->mulut = $request->mulut;
            $perinatologyPemeriksaanLanjut->mucosa_mulut = $request->mucosa_mulut;
            $perinatologyPemeriksaanLanjut->dada_paru = $request->dada_paru;
            $perinatologyPemeriksaanLanjut->suara_nafas = $request->suara_nafas;
            $perinatologyPemeriksaanLanjut->respirasi = $request->respirasi;
            $perinatologyPemeriksaanLanjut->down_score = $request->down_score;
            $perinatologyPemeriksaanLanjut->bunyi_jantung = $request->bunyi_jantung;
            $perinatologyPemeriksaanLanjut->waktu_pengisian_kapiler = $request->waktu_pengisian_kapiler;
            $perinatologyPemeriksaanLanjut->keadaan_perut = $request->keadaan_perut;
            $perinatologyPemeriksaanLanjut->umbilikus = $request->umbilikus;
            $perinatologyPemeriksaanLanjut->warna_umbilikus = $request->warna_umbilikus;
            $perinatologyPemeriksaanLanjut->genitalis = $request->genitalis;
            $perinatologyPemeriksaanLanjut->gerakan = $request->gerakan;
            $perinatologyPemeriksaanLanjut->ekstremitas_atas = $request->ekstremitas_atas;
            $perinatologyPemeriksaanLanjut->ekstremitas_bawah = $request->ekstremitas_bawah;
            $perinatologyPemeriksaanLanjut->tulang_belakang = $request->tulang_belakang;
            $perinatologyPemeriksaanLanjut->refleks = $request->refleks;
            $perinatologyPemeriksaanLanjut->genggaman = $request->genggaman;
            $perinatologyPemeriksaanLanjut->menghisap = $request->menghisap;
            $perinatologyPemeriksaanLanjut->aktivitas = $request->aktivitas;
            $perinatologyPemeriksaanLanjut->menangis = $request->menangis;
            $perinatologyPemeriksaanLanjut->save();

            // Update RmePemeriksaanFisik
            RmeAsesmenPemeriksaanFisik::where('id_asesmen', $dataAsesmen->id)->delete();
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

            // Update RmeAsesmenKepPerinatologyRiwayatIbu
            $riwayatIbu = RmeAsesmenKepPerinatologyRiwayatIbu::where('id_asesmen', $id)->first();
            if (!$riwayatIbu) {
                $riwayatIbu = new RmeAsesmenKepPerinatologyRiwayatIbu();
                $riwayatIbu->id_asesmen = $id;
            }

            $riwayatIbu->pemeriksaan_kehamilan = $request->pemeriksaan_kehamilan;
            $riwayatIbu->tempat_pemeriksaan = $request->tempat_pemeriksaan;
            $riwayatIbu->usia_kehamilan = $request->usia_kehamilan;
            $riwayatIbu->cara_persalinan = $request->cara_persalinan;

            // Handle riwayat penyakit dan pengobatan
            $riwayatJson = $request->input('riwayat_penyakit_pengobatan');
            if ($riwayatJson) {
                json_decode($riwayatJson);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $riwayatIbu->riwayat_penyakit_pengobatan = $riwayatJson;
                } else {
                    $riwayatIbu->riwayat_penyakit_pengobatan = json_encode([]);
                }
            } else {
                $riwayatIbu->riwayat_penyakit_pengobatan = json_encode([]);
            }

            $riwayatIbu->save();

            // Update RmeKepPerinatologyStatusNyeri
            if ($request->filled('jenis_skala_nyeri')) {
                $jenisSkala = [
                    'NRS' => 1,
                    'FLACC' => 2,
                    'CRIES' => 3
                ];

                $statusNyeri = RmeAsesmenKepPerinatologyStatusNyeri::where('id_asesmen', $dataAsesmen->id)->firstOrCreate();
                $statusNyeri->jenis_skala_nyeri = $jenisSkala[$request->jenis_skala_nyeri];
                $statusNyeri->nilai_nyeri = $request->nilai_skala_nyeri;
                $statusNyeri->kesimpulan_nyeri = $request->kesimpulan_nyeri;

                // Jika skala FLACC dipilih
                if ($request->jenis_skala_nyeri === 'FLACC') {
                    $statusNyeri->flacc_wajah = $request->wajah ? json_encode($request->wajah) : null;
                    $statusNyeri->flacc_kaki = $request->kaki ? json_encode($request->kaki) : null;
                    $statusNyeri->flacc_aktivitas = $request->aktivitas ? json_encode($request->aktivitas) : null;
                    $statusNyeri->flacc_menangis = $request->menangis ? json_encode($request->menangis) : null;
                    $statusNyeri->flacc_konsolabilitas = $request->konsolabilitas ? json_encode($request->konsolabilitas) : null;
                    $statusNyeri->flacc_jumlah_skala = $request->flaccTotal;
                }

                // Jika skala CRIES dipilih
                if ($request->jenis_skala_nyeri === 'CRIES') {
                    $statusNyeri->cries_menangis = $request->menangis ? json_encode($request->menangis) : null;
                    $statusNyeri->cries_kebutuhan_oksigen = $request->oksigen ? json_encode($request->oksigen) : null;
                    $statusNyeri->cries_increased = $request->increased ? json_encode($request->increased) : null;
                    $statusNyeri->cries_wajah = $request->wajah ? json_encode($request->wajah) : null;
                    $statusNyeri->cries_sulit_tidur = $request->tidur ? json_encode($request->tidur) : null;
                    $statusNyeri->cries_jumlah_skala = $request->criesTotal;
                }

                $statusNyeri->lokasi = $request->lokasi_nyeri;
                $statusNyeri->durasi = $request->durasi_nyeri;
                $statusNyeri->jenis_nyeri = $request->jenis_nyeri;
                $statusNyeri->frekuensi = $request->frekuensi_nyeri;
                $statusNyeri->menjalar = $request->nyeri_menjalar;
                $statusNyeri->kualitas = $request->kualitas_nyeri;
                $statusNyeri->faktor_pemberat = $request->faktor_pemberat;
                $statusNyeri->faktor_peringan = $request->faktor_peringan;
                $statusNyeri->efek_nyeri = $request->efek_nyeri;
                $statusNyeri->save();
            }

            // Update Risiko Jatuh
            $risikoJatuh = RmeAsesmenKepPerinatologyRisikoJatuh::firstOrCreate(
                ['id_asesmen' => $dataAsesmen->id],
                ['id_asesmen' => $dataAsesmen->id]
            );
            $risikoJatuh->resiko_jatuh_jenis = (int)$request->resiko_jatuh_jenis;
            $risikoJatuh->intervensi_risiko_jatuh = $request->has('intervensi_risiko_jatuh_json')
                ? $request->intervensi_risiko_jatuh_json
                : '[]';

            if ($request->resiko_jatuh_jenis == 1) {
                $risikoJatuh->risiko_jatuh_umum_usia = $request->risiko_jatuh_umum_usia ? 1 : 0;
                $risikoJatuh->risiko_jatuh_umum_kondisi_khusus = $request->risiko_jatuh_umum_kondisi_khusus ? 1 : 0;
                $risikoJatuh->risiko_jatuh_umum_diagnosis_parkinson = $request->risiko_jatuh_umum_diagnosis_parkinson ? 1 : 0;
                $risikoJatuh->risiko_jatuh_umum_pengobatan_berisiko = $request->risiko_jatuh_umum_pengobatan_berisiko ? 1 : 0;
                $risikoJatuh->risiko_jatuh_umum_lokasi_berisiko = $request->risiko_jatuh_umum_lokasi_berisiko ? 1 : 0;
                $risikoJatuh->kesimpulan_skala_umum = $request->input('risiko_jatuh_umum_kesimpulan', 'Tidak berisiko jatuh');
            } elseif ($request->resiko_jatuh_jenis == 2) {
                $risikoJatuh->risiko_jatuh_morse_riwayat_jatuh = array_search($request->risiko_jatuh_morse_riwayat_jatuh, ['25' => 25, '0' => 0]);
                $risikoJatuh->risiko_jatuh_morse_diagnosis_sekunder = array_search($request->risiko_jatuh_morse_diagnosis_sekunder, ['15' => 15, '0' => 0]);
                $risikoJatuh->risiko_jatuh_morse_bantuan_ambulasi = array_search($request->risiko_jatuh_morse_bantuan_ambulasi, ['30' => 30, '15' => 15, '0' => 0]);
                $risikoJatuh->risiko_jatuh_morse_terpasang_infus = array_search($request->risiko_jatuh_morse_terpasang_infus, ['20' => 20, '0' => 0]);
                $risikoJatuh->risiko_jatuh_morse_cara_berjalan = array_search($request->risiko_jatuh_morse_cara_berjalan, ['0' => 0, '20' => 20, 10 => 10]);
                $risikoJatuh->risiko_jatuh_morse_status_mental = array_search($request->risiko_jatuh_morse_status_mental, ['0' => 0, '15' => 15]);
                $risikoJatuh->kesimpulan_skala_morse = $request->risiko_jatuh_morse_kesimpulan;
            } elseif ($request->resiko_jatuh_jenis == 3) {
                $risikoJatuh->risiko_jatuh_pediatrik_usia_anak = array_search((int)$request->risiko_jatuh_pediatrik_usia_anak, ['4' => 4, '3' => 3, '2' => 2, '1' => 1]);
                $risikoJatuh->risiko_jatuh_pediatrik_jenis_kelamin = array_search($request->risiko_jatuh_pediatrik_jenis_kelamin, ['2' => 2, '1' => 1]);
                $risikoJatuh->risiko_jatuh_pediatrik_diagnosis = array_search($request->risiko_jatuh_pediatrik_diagnosis, ['4' => 4, '3' => 3, '2' => 2, '1' => 1]);
                $risikoJatuh->risiko_jatuh_pediatrik_gangguan_kognitif = array_search($request->risiko_jatuh_pediatrik_gangguan_kognitif, ['3' => 3, '2' => 2, '1' => 1]);
                $risikoJatuh->risiko_jatuh_pediatrik_faktor_lingkungan = array_search($request->risiko_jatuh_pediatrik_faktor_lingkungan, ['4' => 4, '3' => 3, '2' => 2, '1' => 1]);
                $risikoJatuh->risiko_jatuh_pediatrik_pembedahan = array_search($request->risiko_jatuh_pediatrik_pembedahan, ['3' => 3, '2' => 2, '1' => 1]);
                $risikoJatuh->risiko_jatuh_pediatrik_penggunaan_mentosa = array_search($request->risiko_jatuh_pediatrik_penggunaan_mentosa, ['3' => 3, '2' => 2, '1' => 1]);
                $risikoJatuh->kesimpulan_skala_pediatrik = $request->risiko_jatuh_pediatrik_kesimpulan;
            } elseif ($request->resiko_jatuh_jenis == 4) {
                $risikoJatuh->risiko_jatuh_lansia_jatuh_saat_masuk_rs = array_search($request->risiko_jatuh_lansia_jatuh_saat_masuk_rs, ['6' => 6, '0' => 0]);
                $risikoJatuh->risiko_jatuh_lansia_riwayat_jatuh_2_bulan = array_search($request->risiko_jatuh_lansia_riwayat_jatuh_2_bulan, ['6' => 6, '0' => 0]);
                $risikoJatuh->risiko_jatuh_lansia_status_bingung = array_search($request->risiko_jatuh_lansia_status_bingung, ['14' => 14, '0' => 0]);
                $risikoJatuh->risiko_jatuh_lansia_status_disorientasi = array_search($request->risiko_jatuh_lansia_status_disorientasi, ['14' => 14, '0' => 0]);
                $risikoJatuh->risiko_jatuh_lansia_status_agitasi = array_search($request->risiko_jatuh_lansia_status_agitasi, ['14' => 14, '0' => 0]);
                $risikoJatuh->risiko_jatuh_lansia_kacamata = $request->risiko_jatuh_lansia_kacamata;
                $risikoJatuh->risiko_jatuh_lansia_kelainan_penglihatan = $request->risiko_jatuh_lansia_kelainan_penglihatan;
                $risikoJatuh->risiko_jatuh_lansia_glukoma = $request->risiko_jatuh_lansia_glukoma;
                $risikoJatuh->risiko_jatuh_lansia_perubahan_berkemih = array_search($request->risiko_jatuh_lansia_perubahan_berkemih, ['2' => 2, '0' => 0]);
                $risikoJatuh->risiko_jatuh_lansia_transfer_mandiri = $request->risiko_jatuh_lansia_transfer_mandiri;
                $risikoJatuh->risiko_jatuh_lansia_transfer_bantuan_sedikit = $request->risiko_jatuh_lansia_transfer_bantuan_sedikit;
                $risikoJatuh->risiko_jatuh_lansia_transfer_bantuan_nyata = array_search($request->risiko_jatuh_lansia_transfer_bantuan_nyata, ['2' => 2, '0' => 0]);
                $risikoJatuh->risiko_jatuh_lansia_transfer_bantuan_total = array_search($request->risiko_jatuh_lansia_transfer_bantuan_total, ['3' => 2, '0' => 0]);
                $risikoJatuh->risiko_jatuh_lansia_mobilitas_mandiri = $request->risiko_jatuh_lansia_mobilitas_mandiri;
                $risikoJatuh->risiko_jatuh_lansia_mobilitas_bantuan_1_orang = $request->risiko_jatuh_lansia_mobilitas_bantuan_1_orang;
                $risikoJatuh->risiko_jatuh_lansia_mobilitas_kursi_roda = array_search($request->risiko_jatuh_lansia_mobilitas_kursi_roda, ['2' => 2, '0' => 0]);
                $risikoJatuh->risiko_jatuh_lansia_mobilitas_imobilisasi = array_search($request->risiko_jatuh_lansia_mobilitas_imobilisasi, ['3' => 2, '0' => 0]);
                $risikoJatuh->kesimpulan_skala_lansia = $request->risiko_jatuh_lansia_kesimpulan;
            } elseif ($request->resiko_jatuh_jenis == 5) {
                $risikoJatuh->resiko_jatuh_lainnya = 'resiko jatuh lainnya';
            }
            $risikoJatuh->save();

            // Update RmeAsesmenKepAnakStatusDecubitus
            $decubitusData = RmeAsesmenKepPerinatologyResikoDekubitus::where('id_asesmen', $dataAsesmen->id)->firstOrCreate();
            $jenisSkala = $request->input('jenis_skala_dekubitus') === 'norton' ? 1 : 2;
            $decubitusData->jenis_skala = $jenisSkala;

            function getRiskConclusionDecubitus($score)
            {
                if ($score <= 12) {
                    return 'Risiko Tinggi';
                } elseif ($score <= 14) {
                    return 'Risiko Sedang';
                }
                return 'Risiko Rendah';
            }

            if ($jenisSkala === 1) {
                // Norton
                $decubitusData->norton_kondisi_fisik = $request->input('kondisi_fisik');
                $decubitusData->norton_kondisi_mental = $request->input('kondisi_mental');
                $decubitusData->norton_aktivitas = $request->input('norton_aktivitas');
                $decubitusData->norton_mobilitas = $request->input('norton_mobilitas');
                $decubitusData->norton_inkontenesia = $request->input('inkontinensia');

                $totalScore =
                    (int)$request->input('kondisi_fisik') +
                    (int)$request->input('kondisi_mental') +
                    (int)$request->input('norton_aktivitas') +
                    (int)$request->input('norton_mobilitas') +
                    (int)$request->input('inkontinensia');

                $decubitusData->decubitus_kesimpulan = getRiskConclusionDecubitus($totalScore);
            } else {
                // Braden
                $decubitusData->braden_persepsi = $request->input('persepsi_sensori');
                $decubitusData->braden_kelembapan = $request->input('kelembapan');
                $decubitusData->braden_aktivitas = $request->input('braden_aktivitas');
                $decubitusData->braden_mobilitas = $request->input('braden_mobilitas');
                $decubitusData->braden_nutrisi = $request->input('nutrisi');
                $decubitusData->braden_pergesekan = $request->input('pergesekan');

                $totalScore =
                    (int)$request->input('persepsi_sensori') +
                    (int)$request->input('kelembapan') +
                    (int)$request->input('braden_aktivitas') +
                    (int)$request->input('braden_mobilitas') +
                    (int)$request->input('nutrisi') +
                    (int)$request->input('pergesekan');

                $decubitusData->decubitus_kesimpulan = getRiskConclusionDecubitus($totalScore);
            }
            $decubitusData->save();

            // Update RmeAsesmenKepAnakGizi
            $asesmenKepPerinatologyStatusGizi = RmeAsesmenKepPerinatologyGizi::where('id_asesmen', $id)->first();
            if (!$asesmenKepPerinatologyStatusGizi) {
                $asesmenKepPerinatologyStatusGizi = new RmeAsesmenKepPerinatologyGizi();
                $asesmenKepPerinatologyStatusGizi->id_asesmen = $id;
            }

            $asesmenKepPerinatologyStatusGizi->gizi_jenis = (int)$request->gizi_jenis;

            if ($request->gizi_jenis == 1) {
                $asesmenKepPerinatologyStatusGizi->gizi_mst_penurunan_bb = $request->gizi_mst_penurunan_bb;
                $asesmenKepPerinatologyStatusGizi->gizi_mst_jumlah_penurunan_bb = $request->gizi_mst_jumlah_penurunan_bb;
                $asesmenKepPerinatologyStatusGizi->gizi_mst_nafsu_makan_berkurang = $request->gizi_mst_nafsu_makan_berkurang;
                $asesmenKepPerinatologyStatusGizi->gizi_mst_diagnosis_khusus = $request->gizi_mst_diagnosis_khusus;
                $asesmenKepPerinatologyStatusGizi->gizi_mst_kesimpulan = $request->gizi_mst_kesimpulan;
            } else if ($request->gizi_jenis == 2) {
                $asesmenKepPerinatologyStatusGizi->gizi_mna_penurunan_asupan_3_bulan = (int)$request->gizi_mna_penurunan_asupan_3_bulan;
                $asesmenKepPerinatologyStatusGizi->gizi_mna_kehilangan_bb_3_bulan = (int)$request->gizi_mna_kehilangan_bb_3_bulan;
                $asesmenKepPerinatologyStatusGizi->gizi_mna_mobilisasi = (int)$request->gizi_mna_mobilisasi;
                $asesmenKepPerinatologyStatusGizi->gizi_mna_stress_penyakit_akut = (int)$request->gizi_mna_stress_penyakit_akut;
                $asesmenKepPerinatologyStatusGizi->gizi_mna_status_neuropsikologi = (int)$request->gizi_mna_status_neuropsikologi;
                $asesmenKepPerinatologyStatusGizi->gizi_mna_berat_badan = (float)$request->gizi_mna_berat_badan;
                $asesmenKepPerinatologyStatusGizi->gizi_mna_tinggi_badan = (float)$request->gizi_mna_tinggi_badan;

                // Hitung dan simpan IMT
                $heightInMeters = $request->gizi_mna_tinggi_badan / 100;
                $imt = $request->gizi_mna_berat_badan / ($heightInMeters * $heightInMeters);
                $asesmenKepPerinatologyStatusGizi->gizi_mna_imt = number_format($imt, 2, '.', '');

                $asesmenKepPerinatologyStatusGizi->gizi_mna_kesimpulan = $request->gizi_mna_kesimpulan;
            } else if ($request->gizi_jenis == 3) {
                $asesmenKepPerinatologyStatusGizi->gizi_strong_status_kurus = $request->gizi_strong_status_kurus;
                $asesmenKepPerinatologyStatusGizi->gizi_strong_penurunan_bb = $request->gizi_strong_penurunan_bb;
                $asesmenKepPerinatologyStatusGizi->gizi_strong_gangguan_pencernaan = $request->gizi_strong_gangguan_pencernaan;
                $asesmenKepPerinatologyStatusGizi->gizi_strong_penyakit_berisiko = $request->gizi_strong_penyakit_berisiko;
                $asesmenKepPerinatologyStatusGizi->gizi_strong_kesimpulan = $request->gizi_strong_kesimpulan;
            } else if ($request->gizi_jenis == 4) {
                $asesmenKepPerinatologyStatusGizi->gizi_nrs_jatuh_saat_masuk_rs = $request->gizi_nrs_jatuh_saat_masuk_rs;
                $asesmenKepPerinatologyStatusGizi->gizi_nrs_kesimpulan = $request->gizi_nrs_kesimpulan;
            } else if ($request->gizi_jenis == 5) {
                $asesmenKepPerinatologyStatusGizi->status_gizi_tidakada = 'tidak ada status gizi';
            }

            $asesmenKepPerinatologyStatusGizi->save();

            // Update RmeAsesmenKepAnakStatusFungsional
            $statusFungsional = RmeAsesmenKepPerinatologyFungsional::where('id_asesmen', $dataAsesmen->id)->firstOrCreate();

            if ($request->filled('skala_fungsional')) {
                if (!$statusFungsional) {
                    $statusFungsional = new RmeAsesmenKepPerinatologyFungsional();
                    $statusFungsional->id_asesmen = $dataAsesmen->id;
                }

                if ($request->skala_fungsional === 'Pengkajian Aktivitas') {
                    $statusFungsional->jenis_skala = 1;
                } elseif ($request->skala_fungsional === 'Lainnya') {
                    $statusFungsional->jenis_skala = 2;
                } else {
                    $statusFungsional->jenis_skala = 0;
                }

                $statusFungsional->makan = $request->adl_makan;
                $statusFungsional->berjalan = $request->adl_berjalan;
                $statusFungsional->mandi = $request->adl_mandi;
                $statusFungsional->jumlah_skala = $request->filled('adl_total') ? (int)$request->adl_total : null;
                $statusFungsional->kesimpulan = $request->adl_kesimpulan_value;
                $statusFungsional->nilai_skala_adl = $request->filled('adl_total') ? (int)$request->adl_total : null;
                $statusFungsional->kesimpulan_fungsional = $request->adl_kesimpulan_value;
                $statusFungsional->save();
            }


            // Update RmeAsesmenKepAnakRencana
            $asesmenRencana = RmeAsesmenKepPerinatologyRencanaPulang::where('id_asesmen', $dataAsesmen->id)->firstOrCreate();
            $asesmenRencana->update([
                'diagnosis_medis' => $request->diagnosis_medis,
                'usia_lanjut' => $request->usia_lanjut,
                'hambatan_mobilisasi' => $request->hambatan_mobilisasi,
                'membutuhkan_pelayanan_medis' => $request->penggunaan_media_berkelanjutan,
                'memerlukan_keterampilan_khusus' => $request->keterampilan_khusus,
                'memerlukan_alat_bantu' => $request->alat_bantu,
                'memiliki_nyeri_kronis' => $request->nyeri_kronis,
                'perkiraan_lama_dirawat' => $request->perkiraan_hari,
                'rencana_pulang' => $request->tanggal_pulang,
                'kesimpulan' => $request->kesimpulan_planing
            ]);

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
                        'hasil' => ''
                    ],
                    'distole'   => [
                        'hasil' => ''
                    ],
                    'respiration_rate'   => [
                        'hasil' => ''
                    ],
                    'suhu'   => [
                        'hasil' => $request->suhu
                    ],
                    'nadi'   => [
                        'hasil' => ''
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

            return redirect()->to(url("unit-pelayanan/rawat-inap/unit/$kd_unit/pelayanan/$kd_pasien/$tgl_masuk/$urut_masuk/asesmen/medis/umum"))
                ->with('success', 'Data asesmen perinatology berhasil diperbarui');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return back()->with('error', 'Data tidak ditemukan. Detail: ' . $e->getMessage());
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
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
