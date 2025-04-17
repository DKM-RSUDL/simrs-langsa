<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\MrItemFisik;
use App\Models\Pekerjaan;
use App\Models\RmeAsesmen;
use App\Models\RmeAsesmenKepUmum;
use App\Models\RmeAsesmenKepUmumDtl;
use App\Models\RmeAsesmenKepUmumGizi;
use App\Models\RmeAsesmenKepUmumRencanaPulang;
use App\Models\RmeAsesmenKepUmumRisikoDekubitus;
use App\Models\RmeAsesmenKepUmumRisikoJatuh;
use App\Models\RmeAsesmenKepUmumRiwayatKesehatan;
use App\Models\RmeAsesmenKepUmumSosialEkonomi;
use App\Models\RmeAsesmenKepUmumStatusFungsional;
use App\Models\RmeAsesmenKepUmumStatusNyeri;
use App\Models\RmeAsesmenKepUmumStatusPsikologis;
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

class AsesmenKepUmumController extends Controller
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
        $pekerjaan = Pekerjaan::all();

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

        return view('unit-pelayanan.rawat-inap.pelayanan.asesmen-umum.create', compact(
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
            'pekerjaan',
            'user'
        ));
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        DB::beginTransaction();
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
            $dataAsesmen->kategori = 2;
            $dataAsesmen->sub_kategori = 1;
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


            $asesmenKepUmum = new RmeAsesmenKepUmum();
            $asesmenKepUmum->id_asesmen = $dataAsesmen->id;
            $asesmenKepUmum->spiritual_agama = $request->keyakinan_agama;
            $asesmenKepUmum->kebutuhan_edukasi_gaya_bicara = $request->kebutuhan_edukasi_gaya_bicara;
            $asesmenKepUmum->kebutuhan_edukasi_bahasa_sehari_hari = $request->kebutuhan_edukasi_bahasa_sehari_hari;
            $asesmenKepUmum->kebutuhan_edukasi_perlu_penerjemah = $request->kebutuhan_edukasi_perlu_penerjemah;
            $asesmenKepUmum->kebutuhan_edukasi_hambatan_komunikasi = $request->kebutuhan_edukasi_hambatan_komunikasi;
            $asesmenKepUmum->kebutuhan_edukasi_media_belajar = $request->kebutuhan_edukasi_media_belajar;
            $asesmenKepUmum->kebutuhan_edukasi_tingkat_pendidikan = $request->kebutuhan_edukasi_tingkat_pendidikan;
            $asesmenKepUmum->save();

            //SIMPAN KE ASESMEN KEP UMUM DETAIL
            $dataAsesmenDetail = new RmeAsesmenKepUmumDtl();
            $dataAsesmenDetail->id_asesmen = $dataAsesmen->id;
            $dataAsesmenDetail->cara_masuk = $request->cara_masuk;
            $dataAsesmenDetail->diagnosa_masuk = $request->diagnosa_masuk;
            $dataAsesmenDetail->barang_berharga = $request->barang_berharga;
            $dataAsesmenDetail->alat_bantu = $request->alat_bantu;
            $dataAsesmenDetail->sistole = $request->sistole;
            $dataAsesmenDetail->diastole = $request->diastole;
            $dataAsesmenDetail->nadi = $request->nadi;
            $dataAsesmenDetail->nafas = $request->nafas;
            $dataAsesmenDetail->suhu = $request->suhu;
            $dataAsesmenDetail->spo_tanpa_o2 = $request->spo_tanpa_o2;
            $dataAsesmenDetail->spo_dengan_o2 = $request->spo_dengan_o2;
            $dataAsesmenDetail->avpu = $request->avpu;
            $dataAsesmenDetail->gcs = $request->gcs_score;
            $dataAsesmenDetail->tinggi_badan = $request->tinggi_badan;
            $dataAsesmenDetail->berat_badan = $request->berat_badan;
            $dataAsesmenDetail->lingkar_kepala = $request->lingkar_kepala;
            $dataAsesmenDetail->riwayat_penggunaan_obat = $request->riwayat_penggunaan_obat ?? '[]';
            $dataAsesmenDetail->diagnosis_banding = $request->diagnosis_banding ?? '[]';
            $dataAsesmenDetail->diagnosis_kerja = $request->diagnosis_kerja ?? '[]';
            $dataAsesmenDetail->prognosis = $request->prognosis;
            $dataAsesmenDetail->observasi = $request->observasi;
            $dataAsesmenDetail->terapeutik = $request->terapeutik;
            $dataAsesmenDetail->edukasi = $request->edukasi;
            $dataAsesmenDetail->kolaborasi = $request->kolaborasi;
            $dataAsesmenDetail->evaluasi = $request->evaluasi_keperawatan;
            $dataAsesmenDetail->save();

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

            //SIMPAN KE TABLE RmePemeriksaanFisik
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


            //SIMPAN KE TABLE RmeKepAnakStatusNyeri
            $statusNyeri = new RmeAsesmenKepUmumStatusNyeri();
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


            //SIMPAN KE TABLE RmeKepAnakRiwayatKesehatan
            $riwayatKesehatan = new RmeAsesmenKepUmumRiwayatKesehatan();
            $riwayatKesehatan->id_asesmen = $dataAsesmen->id;
            $riwayatKesehatan->penyakit_yang_diderita = $request->penyakit_yang_diderita;
            $riwayatKesehatan->riwayat_kecelakaan = $request->riwayat_kecelakaan;
            $riwayatKesehatan->riwayat_rawat_inap = $request->riwayat_rawat_inap;
            $riwayatKesehatan->tanggal_riwayat_rawat_inap = $request->tanggal_rawat_inap;
            $riwayatKesehatan->riwayat_operasi = $request->riwayat_operasi;
            $riwayatKesehatan->jenis_operasi = $request->jenis_operasi;
            $riwayatKesehatan->konsumsi_obat = $request->konsumsi_obat;
            $riwayatKesehatan->merokok = $request->merokok;
            $riwayatKesehatan->alkohol = $request->alkohol;
            $riwayatKesehatan->riwayat_penyakit_keluarga = $request->riwayat_kesehatan_keluarga;
            $riwayatKesehatan->save();


            // Simpan ke table RMEAsesmenKepUmumRencanaPulang
            $asesmenRencana = new RmeAsesmenKepUmumRencanaPulang();
            $asesmenRencana->id_asesmen = $dataAsesmen->id;
            $asesmenRencana->diagnosis_medis = $request->diagnosis_medis;
            $asesmenRencana->usia_lanjut = $request->usia_lanjut;
            $asesmenRencana->hambatan_mobilisasi = $request->hambatan_mobilisasi;
            $asesmenRencana->membutuhkan_pelayanan_medis = $request->penggunaan_media_berkelanjutan;
            $asesmenRencana->ketergantungan_aktivitas = $request->ketergantungan_aktivitas;
            $asesmenRencana->memerlukan_keterampilan_khusus = $request->keterampilan_khusus;
            $asesmenRencana->memerlukan_alat_bantu = $request->alat_bantu;
            $asesmenRencana->memiliki_nyeri_kronis = $request->nyeri_kronis;
            $asesmenRencana->perkiraan_lama_dirawat = $request->perkiraan_hari;
            $asesmenRencana->rencana_pulang = $request->tanggal_pulang;
            $asesmenRencana->kesimpulan = $request->kesimpulan_planing;
            $asesmenRencana->save();



            $asesmenKepUmumRisikoJatuh = new RmeAsesmenKepUmumRisikoJatuh();
            $asesmenKepUmumRisikoJatuh->id_asesmen = $dataAsesmen->id;
            $asesmenKepUmumRisikoJatuh->resiko_jatuh_jenis = (int)$request->resiko_jatuh_jenis;
            $asesmenKepUmumRisikoJatuh->risik_jatuh_tindakan = $request->risikojatuh_tindakan_keperawatan ? json_encode($request->risikojatuh_tindakan_keperawatan) : null;

            if ($request->resiko_jatuh_jenis == 1) {
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_umum_usia = $request->risiko_jatuh_umum_usia ? 1 : 0;
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_umum_kondisi_khusus = $request->risiko_jatuh_umum_kondisi_khusus ? 1 : 0;
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_umum_diagnosis_parkinson = $request->risiko_jatuh_umum_diagnosis_parkinson ? 1 : 0;
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_umum_pengobatan_berisiko = $request->risiko_jatuh_umum_pengobatan_berisiko ? 1 : 0;
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_umum_lokasi_berisiko = $request->risiko_jatuh_umum_lokasi_berisiko ? 1 : 0;
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_umum_kesimpulan = $request->input('risiko_jatuh_umum_kesimpulan', 'Tidak berisiko jatuh');
            }

            if ($request->resiko_jatuh_jenis == 2) {
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_riwayat_jatuh = array_search($request->risiko_jatuh_morse_riwayat_jatuh, ['25' => 25, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_diagnosis_sekunder = array_search($request->risiko_jatuh_morse_diagnosis_sekunder, ['15' => 15, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_bantuan_ambulasi = array_search($request->risiko_jatuh_morse_bantuan_ambulasi, ['30' => 30, '15' => 15, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_terpasang_infus = array_search($request->risiko_jatuh_morse_terpasang_infus, ['20' => 20, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_cara_berjalan = array_search($request->risiko_jatuh_morse_cara_berjalan, ['0' => 0, '20' => 20, 10 => 10]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_status_mental = array_search($request->risiko_jatuh_morse_status_mental, ['0' => 0, '15' => 15]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_kesimpulan = $request->risiko_jatuh_morse_kesimpulan;
                $asesmenKepUmumRisikoJatuh->save();
            } else if ($request->resiko_jatuh_jenis == 3) {
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_usia_anak = array_search((int)$request->risiko_jatuh_pediatrik_usia_anak, ['4' => 4, '3' => 3, '2' => 2, '1' => 1]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_jenis_kelamin = array_search($request->risiko_jatuh_pediatrik_jenis_kelamin, ['2' => 2, '1' => 1]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_diagnosis = array_search($request->risiko_jatuh_pediatrik_diagnosis, ['4' => 4, '3' => 3, '2' => 2, '1' => 1]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_gangguan_kognitif = array_search($request->risiko_jatuh_pediatrik_gangguan_kognitif, ['3' => 3, '2' => 2, '1' => 1]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_faktor_lingkungan = array_search($request->risiko_jatuh_pediatrik_faktor_lingkungan, ['4' => 4, '3' => 3, '2' => 2, '1' => 1]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_pembedahan = array_search($request->risiko_jatuh_pediatrik_pembedahan, ['3' => 3, '2' => 2, '1' => 1]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_penggunaan_mentosa = array_search($request->risiko_jatuh_pediatrik_penggunaan_mentosa, ['3' => 3, '2' => 2, '1' => 1]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_kesimpulan = $request->risiko_jatuh_pediatrik_kesimpulan;
            } else if ($request->resiko_jatuh_jenis == 4) {
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_jatuh_saat_masuk_rs = array_search($request->risiko_jatuh_lansia_jatuh_saat_masuk_rs, ['6' => 6, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_riwayat_jatuh_2_bulan = array_search($request->risiko_jatuh_lansia_riwayat_jatuh_2_bulan, ['6' => 6, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_status_bingung = array_search($request->risiko_jatuh_lansia_status_bingung, ['14' => 14, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_status_disorientasi = array_search($request->risiko_jatuh_lansia_status_disorientasi, ['14' => 14, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_status_agitasi = array_search($request->risiko_jatuh_lansia_status_agitasi, ['14' => 14, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_kacamata = $request->risiko_jatuh_lansia_kacamata;
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_kelainan_penglihatan = $request->risiko_jatuh_lansia_kelainan_penglihatan;
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_glukoma = $request->risiko_jatuh_lansia_glukoma;
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_perubahan_berkemih = array_search($request->risiko_jatuh_lansia_perubahan_berkemih, ['2' => 2, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_transfer_mandiri = $request->risiko_jatuh_lansia_transfer_mandiri;
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_sedikit = $request->risiko_jatuh_lansia_transfer_bantuan_sedikit;
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_nyata = array_search($request->risiko_jatuh_lansia_transfer_bantuan_nyata, ['2' => 2, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_total = array_search($request->risiko_jatuh_lansia_transfer_bantuan_total, ['3' => 2, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_mobilitas_mandiri = $request->risiko_jatuh_lansia_mobilitas_mandiri;
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_mobilitas_bantuan_1_orang = $request->risiko_jatuh_lansia_mobilitas_bantuan_1_orang;
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_mobilitas_kursi_roda = array_search($request->risiko_jatuh_lansia_mobilitas_kursi_roda, ['2' => 2, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_mobilitas_imobilisasi = array_search($request->risiko_jatuh_lansia_mobilitas_imobilisasi, ['3' => 2, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_kesimpulan = $request->risiko_jatuh_lansia_kesimpulan;
            } else if ($request->resiko_jatuh_jenis == 5) {
                $asesmenKepUmumRisikoJatuh->resiko_jatuh_lainnya = 'resiko jatuh lainnya';
            }
            $asesmenKepUmumRisikoJatuh->save();


            //Simpan ke table RmeAsesmenKepUmumStatusDecubitus
            $decubitusData = new RmeAsesmenKepUmumRisikoDekubitus();
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


            //Simpan ke table RmeAsesmenKepAnakStatusPsikologi
            $statusPsikologis = new RmeAsesmenKepUmumStatusPsikologis();
            $statusPsikologis->id_asesmen = $dataAsesmen->id;
            $statusPsikologis->kondisi_psikologis = $request->kondisi_psikologis_json ?? '[]';
            $statusPsikologis->gangguan_perilaku = $request->gangguan_perilaku_json ?? '[]';
            $statusPsikologis->potensi_menyakiti = $request->potensi_menyakiti;
            $statusPsikologis->keluarga_gangguan_jiwa = $request->anggota_keluarga_gangguan_jiwa;
            $statusPsikologis->lainnya = $request->psikologis_lainnya;
            $statusPsikologis->save();


            $asesmenKepUmumExposure = new RmeAsesmenKepUmumSosialEkonomi();
            $asesmenKepUmumExposure->id_asesmen = $dataAsesmen->id;
            $asesmenKepUmumExposure->sosial_ekonomi_pekerjaan = $request->pekerjaan_pasien;
            $asesmenKepUmumExposure->sosial_ekonomi_status_pernikahan = $request->status_pernikahan;
            $asesmenKepUmumExposure->sosial_ekonomi_tempat_tinggal = $request->tempat_tinggal;
            $asesmenKepUmumExposure->sosial_ekonomi_tinggal_dengan_keluarga = $request->status_tinggal;
            $asesmenKepUmumExposure->sosial_ekonomi_curiga_penganiayaan = $request->curiga_penganiayaan;
            $asesmenKepUmumExposure->save();


            $asesmenKepUmumStatusGizi = new RmeAsesmenKepUmumGizi();
            $asesmenKepUmumStatusGizi->id_asesmen = $dataAsesmen->id;
            $asesmenKepUmumStatusGizi->gizi_jenis = (int)$request->gizi_jenis;

            // Handle MST Form
            if ($request->gizi_jenis == 1) {
                $asesmenKepUmumStatusGizi->gizi_mst_penurunan_bb = $request->gizi_mst_penurunan_bb;
                $asesmenKepUmumStatusGizi->gizi_mst_jumlah_penurunan_bb = $request->gizi_mst_jumlah_penurunan_bb;
                $asesmenKepUmumStatusGizi->gizi_mst_nafsu_makan_berkurang = $request->gizi_mst_nafsu_makan_berkurang;
                $asesmenKepUmumStatusGizi->gizi_mst_diagnosis_khusus = $request->gizi_mst_diagnosis_khusus;
                $asesmenKepUmumStatusGizi->gizi_mst_kesimpulan = $request->gizi_mst_kesimpulan;
            }

            // Handle MNA Form
            else if ($request->gizi_jenis == 2) {
                $asesmenKepUmumStatusGizi->gizi_mna_penurunan_asupan_3_bulan = (int)$request->gizi_mna_penurunan_asupan_3_bulan;
                $asesmenKepUmumStatusGizi->gizi_mna_kehilangan_bb_3_bulan = (int)$request->gizi_mna_kehilangan_bb_3_bulan;
                $asesmenKepUmumStatusGizi->gizi_mna_mobilisasi = (int)$request->gizi_mna_mobilisasi;
                $asesmenKepUmumStatusGizi->gizi_mna_stress_penyakit_akut = (int)$request->gizi_mna_stress_penyakit_akut;
                $asesmenKepUmumStatusGizi->gizi_mna_status_neuropsikologi = (int)$request->gizi_mna_status_neuropsikologi;
                $asesmenKepUmumStatusGizi->gizi_mna_berat_badan = (int)$request->gizi_mna_berat_badan;
                $asesmenKepUmumStatusGizi->gizi_mna_tinggi_badan = (int)$request->gizi_mna_tinggi_badan;

                // Hitung dan simpan IMT
                $heightInMeters = $request->gizi_mna_tinggi_badan / 100;
                $imt = $request->gizi_mna_berat_badan / ($heightInMeters * $heightInMeters);
                $asesmenKepUmumStatusGizi->gizi_mna_imt = number_format($imt, 2, '.', '');

                $asesmenKepUmumStatusGizi->gizi_mna_kesimpulan = $request->gizi_mna_kesimpulan;
            }

            // Handle Strong Kids Form
            else if ($request->gizi_jenis == 3) {
                $asesmenKepUmumStatusGizi->gizi_strong_status_kurus = $request->gizi_strong_status_kurus;
                $asesmenKepUmumStatusGizi->gizi_strong_penurunan_bb = $request->gizi_strong_penurunan_bb;
                $asesmenKepUmumStatusGizi->gizi_strong_gangguan_pencernaan = $request->gizi_strong_gangguan_pencernaan;
                $asesmenKepUmumStatusGizi->gizi_strong_penyakit_berisiko = $request->gizi_strong_penyakit_berisiko;
                $asesmenKepUmumStatusGizi->gizi_strong_kesimpulan = $request->gizi_strong_kesimpulan;
            }

            // Handle NRS Form
            else if ($request->gizi_jenis == 4) {
                $asesmenKepUmumStatusGizi->gizi_nrs_jatuh_saat_masuk_rs = $request->gizi_nrs_jatuh_saat_masuk_rs;
                $asesmenKepUmumStatusGizi->gizi_nrs_jatuh_2_bulan_terakhir = $request->gizi_nrs_jatuh_2_bulan_terakhir;
                $asesmenKepUmumStatusGizi->gizi_nrs_status_delirium = $request->gizi_nrs_status_delirium;
                $asesmenKepUmumStatusGizi->gizi_nrs_status_disorientasi = $request->gizi_nrs_status_disorientasi;
                $asesmenKepUmumStatusGizi->gizi_nrs_status_agitasi = $request->gizi_nrs_status_agitasi;
                $asesmenKepUmumStatusGizi->gizi_nrs_menggunakan_kacamata = $request->gizi_nrs_menggunakan_kacamata;
                $asesmenKepUmumStatusGizi->gizi_nrs_keluhan_penglihatan_buram = $request->gizi_nrs_keluhan_penglihatan_buram;
                $asesmenKepUmumStatusGizi->gizi_nrs_degenerasi_makula = $request->gizi_nrs_degenerasi_makula;
                $asesmenKepUmumStatusGizi->gizi_nrs_perubahan_berkemih = $request->gizi_nrs_perubahan_berkemih;
                $asesmenKepUmumStatusGizi->gizi_nrs_transfer_mandiri = $request->gizi_nrs_transfer_mandiri;
                $asesmenKepUmumStatusGizi->gizi_nrs_transfer_bantuan_1_orang = $request->gizi_nrs_transfer_bantuan_1_orang;
                $asesmenKepUmumStatusGizi->gizi_nrs_transfer_bantuan_2_orang = $request->gizi_nrs_transfer_bantuan_2_orang;
                $asesmenKepUmumStatusGizi->gizi_nrs_transfer_bantuan_total = $request->gizi_nrs_transfer_bantuan_total;
                $asesmenKepUmumStatusGizi->gizi_nrs_mobilitas_mandiri = $request->gizi_nrs_mobilitas_mandiri;
                $asesmenKepUmumStatusGizi->gizi_nrs_mobilitas_bantuan_1_orang = $request->gizi_nrs_mobilitas_bantuan_1_orang;
                $asesmenKepUmumStatusGizi->gizi_nrs_mobilitas_kursi_roda = $request->gizi_nrs_mobilitas_kursi_roda;
                $asesmenKepUmumStatusGizi->gizi_nrs_mobilitas_imobilisasi = $request->gizi_nrs_mobilitas_imobilisasi;
                $asesmenKepUmumStatusGizi->gizi_nrs_kesimpulan = $request->gizi_nrs_kesimpulan;
            } else if ($request->gizi_jenis == 5) {
                $asesmenKepUmumStatusGizi->status_gizi_tidakada = 'tidak ada status gizi';
            }

            $asesmenKepUmumStatusGizi->save();


            $statusFungsional = new RmeAsesmenKepUmumStatusFungsional();
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
                ->with('success', 'Data asesmen Keperwatan Umum berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            // Ambil data asesmen beserta semua relasinya
            $asesmen = RmeAsesmen::with([
                'user',
                'pasien',
                'asesmenKepUmum',
                'asesmenKepUmumDetail',
                'pemeriksaanFisik' => function ($query) {
                    $query->with('itemFisik');
                },
                'asesmenKepUmumStatusNyeri',             // Changed from rmeAsesmenKepUmumStatusNyeri
                'asesmenKepUmumRiwayatKesehatan',        // Changed from rmeAsesmenKepUmumRiwayatKesehatan
                'asesmenKepUmumRencanaPulang',           // Changed from rmeAsesmenKepUmumRencanaPulang
                'asesmenKepUmumRisikoJatuh',             // This one is correct
                'asesmenKepUmumRisikoDekubitus',         // Changed from rmeAsesmenKepUmumRisikoDekubitus
                'asesmenKepUmumStatusPsikologis',        // Changed from rmeAsesmenKepUmumStatusPsikologis
                'asesmenKepUmumSosialEkonomi',           // This one is correct
                'asesmenKepUmumGizi',                    // Changed from gizi to match model relation
                'asesmenKepUmumStatusFungsional'         // Changed from rmeAsesmenKepUmumStatusFungsional
            ])->findOrFail($id);



            // Mengambil data medis pasien
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

            // Data tambahan untuk tampilan
            $itemFisik = MrItemFisik::orderBy('urut')->get();
            $menjalar = RmeMenjalar::all();
            $frekuensinyeri = RmeFrekuensiNyeri::all();
            $kualitasnyeri = RmeKualitasNyeri::all();
            $faktorpemberat = RmeFaktorPemberat::all();
            $faktorperingan = RmeFaktorPeringan::all();
            $efeknyeri = RmeEfekNyeri::all();
            $jenisnyeri = RmeJenisNyeri::all();
            $rmeMasterDiagnosis = RmeMasterDiagnosis::all();
            $rmeMasterImplementasi = RmeMasterImplementasi::all();
            $pekerjaan = Pekerjaan::all();
            $user = auth()->user();

            return view('unit-pelayanan.rawat-inap.pelayanan.asesmen-umum.show', compact(
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
                'pekerjaan',
                'urut_masuk'
            ));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return back()->with('error', 'Data tidak ditemukan. Detail: ' . $e->getMessage());
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function edit($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            // Fetch the assessment record with all its relations
            $asesmen = RmeAsesmen::with([
                'user',
                'pasien',
                'asesmenKepUmum',
                'asesmenKepUmumDetail',
                'pemeriksaanFisik' => function ($query) {
                    $query->with('itemFisik');
                },
                'asesmenKepUmumStatusNyeri',
                'asesmenKepUmumRiwayatKesehatan',
                'asesmenKepUmumRencanaPulang',
                'asesmenKepUmumRisikoJatuh',
                'asesmenKepUmumRisikoDekubitus',
                'asesmenKepUmumStatusPsikologis',
                'asesmenKepUmumSosialEkonomi',
                'asesmenKepUmumGizi',
                'asesmenKepUmumStatusFungsional'
            ])->findOrFail($id);

            // Fetch patient medical data
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
                ->where('kunjungan.urut_masuk', $urut_masuk)
                ->first();

            if (!$dataMedis) {
                abort(404, 'Data not found');
            }

            // Calculate patient age
            if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
                $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
            } else {
                $dataMedis->pasien->umur = 'Tidak Diketahui';
            }

            // Process allergy data
            if ($dataMedis->riwayat_alergi) {
                $dataMedis->riwayat_alergi = collect(json_decode($dataMedis->riwayat_alergi, true))
                    ->pluck('alergen')
                    ->all();
            } else {
                $dataMedis->riwayat_alergi = [];
            }

            $dataMedis->waktu_masuk = Carbon::parse($dataMedis->TGL_MASUK . ' ' . $dataMedis->JAM_MASUK)->format('Y-m-d H:i:s');

            // Fetch additional data for form dropdowns
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
            $pekerjaan = Pekerjaan::all();
            $user = auth()->user();

            // Extract date and time from waktu_asesmen for form binding
            $tanggal_masuk = null;
            $jam_masuk = null;
            if ($asesmen->waktu_asesmen) {
                $waktuAsesmen = Carbon::parse($asesmen->waktu_asesmen);
                $tanggal_masuk = $waktuAsesmen->format('Y-m-d');
                $jam_masuk = $waktuAsesmen->format('H:i:s');
            }

            // Convert JSON data for form binding
            $alergis = $asesmen->riwayat_alergi ? json_decode($asesmen->riwayat_alergi, true) : [];

            // Process physical examination data for form binding
            $pemeriksaanFisik = [];
            foreach ($asesmen->pemeriksaanFisik as $fisik) {
                $pemeriksaanFisik[$fisik->id_item_fisik] = [
                    'is_normal' => $fisik->is_normal,
                    'keterangan' => $fisik->keterangan
                ];
            }

            return view('unit-pelayanan.rawat-inap.pelayanan.asesmen-umum.edit', compact(
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
                'user',
                'asesmen',
                'tanggal_masuk',
                'jam_masuk',
                'alergis',
                'pekerjaan',
                'pemeriksaanFisik'
            ));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return back()->with('error', 'Data tidak ditemukan. Detail: ' . $e->getMessage());
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            // Find the assessment
            $dataAsesmen = RmeAsesmen::findOrFail($id);

            // Ambil tanggal dan jam dari form
            $tanggal = $request->tanggal_masuk;
            $jam = $request->jam_masuk;
            $waktu_asesmen = $tanggal . ' ' . $jam;

            // Update RmeAsesmen
            $dataAsesmen->user_id = Auth::id();
            $dataAsesmen->waktu_asesmen = $waktu_asesmen;
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

            // Update RmeAsesmenKepUmum
            $asesmenKepUmum = RmeAsesmenKepUmum::firstOrNew(['id_asesmen' => $dataAsesmen->id]);
            $asesmenKepUmum->spiritual_agama = $request->keyakinan_agama;
            $asesmenKepUmum->kebutuhan_edukasi_gaya_bicara = $request->kebutuhan_edukasi_gaya_bicara;
            $asesmenKepUmum->kebutuhan_edukasi_bahasa_sehari_hari = $request->kebutuhan_edukasi_bahasa_sehari_hari;
            $asesmenKepUmum->kebutuhan_edukasi_perlu_penerjemah = $request->kebutuhan_edukasi_perlu_penerjemah;
            $asesmenKepUmum->kebutuhan_edukasi_hambatan_komunikasi = $request->kebutuhan_edukasi_hambatan_komunikasi;
            $asesmenKepUmum->kebutuhan_edukasi_media_belajar = $request->kebutuhan_edukasi_media_belajar;
            $asesmenKepUmum->kebutuhan_edukasi_tingkat_pendidikan = $request->kebutuhan_edukasi_tingkat_pendidikan;
            $asesmenKepUmum->save();

            // Update RmeAsesmenKepUmumDtl
            $dataAsesmenDetail = RmeAsesmenKepUmumDtl::firstOrNew(['id_asesmen' => $dataAsesmen->id]);
            $dataAsesmenDetail->cara_masuk = $request->cara_masuk;
            $dataAsesmenDetail->diagnosa_masuk = $request->diagnosa_masuk;
            $dataAsesmenDetail->barang_berharga = $request->barang_berharga;
            $dataAsesmenDetail->alat_bantu = $request->alat_bantu;
            $dataAsesmenDetail->sistole = $request->sistole;
            $dataAsesmenDetail->diastole = $request->diastole;
            $dataAsesmenDetail->nadi = $request->nadi;
            $dataAsesmenDetail->nafas = $request->nafas;
            $dataAsesmenDetail->suhu = $request->suhu;
            $dataAsesmenDetail->spo_tanpa_o2 = $request->spo_tanpa_o2;
            $dataAsesmenDetail->spo_dengan_o2 = $request->spo_dengan_o2;
            $dataAsesmenDetail->avpu = $request->avpu;
            $dataAsesmenDetail->gcs = $request->gcs_score;
            $dataAsesmenDetail->tinggi_badan = $request->tinggi_badan;
            $dataAsesmenDetail->berat_badan = $request->berat_badan;
            $dataAsesmenDetail->lingkar_kepala = $request->lingkar_kepala;
            $dataAsesmenDetail->riwayat_penggunaan_obat = $request->riwayat_penggunaan_obat ?? '[]';
            $dataAsesmenDetail->diagnosis_banding = $request->diagnosis_banding ?? '[]';
            $dataAsesmenDetail->diagnosis_kerja = $request->diagnosis_kerja ?? '[]';
            $dataAsesmenDetail->prognosis = $request->prognosis;
            $dataAsesmenDetail->observasi = $request->observasi;
            $dataAsesmenDetail->terapeutik = $request->terapeutik;
            $dataAsesmenDetail->edukasi = $request->edukasi;
            $dataAsesmenDetail->kolaborasi = $request->kolaborasi;
            $dataAsesmenDetail->evaluasi = $request->evaluasi_keperawatan;
            $dataAsesmenDetail->save();

            // Update Diagnosa ke Master
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

            // Update RmePemeriksaanFisik
            // First delete existing records
            RmeAsesmenPemeriksaanFisik::where('id_asesmen', $dataAsesmen->id)->delete();

            // Then create new ones
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

            // Update RmeAsesmenKepUmumStatusNyeri
            $statusNyeri = RmeAsesmenKepUmumStatusNyeri::firstOrNew(['id_asesmen' => $dataAsesmen->id]);
            if ($request->filled('jenis_skala_nyeri')) {
                $jenisSkala = [
                    'NRS' => 1,
                    'FLACC' => 2,
                    'CRIES' => 3
                ];
                $statusNyeri->jenis_skala_nyeri = $jenisSkala[$request->jenis_skala_nyeri];
                $statusNyeri->nilai_nyeri = $request->nilai_skala_nyeri;
                $statusNyeri->kesimpulan_nyeri = $request->kesimpulan_nyeri;

                // If FLACC scale is selected
                if ($request->jenis_skala_nyeri === 'FLACC') {
                    $statusNyeri->flacc_wajah = $request->wajah ? json_encode($request->wajah) : null;
                    $statusNyeri->flacc_kaki = $request->kaki ? json_encode($request->kaki) : null;
                    $statusNyeri->flacc_aktivitas = $request->aktivitas ? json_encode($request->aktivitas) : null;
                    $statusNyeri->flacc_menangis = $request->menangis ? json_encode($request->menangis) : null;
                    $statusNyeri->flacc_konsolabilitas = $request->konsolabilitas ? json_encode($request->konsolabilitas) : null;
                    $statusNyeri->flacc_jumlah_skala = $request->flaccTotal;
                }

                // If CRIES scale is selected
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

            // Update RmeAsesmenKepUmumRiwayatKesehatan
            $riwayatKesehatan = RmeAsesmenKepUmumRiwayatKesehatan::firstOrNew(['id_asesmen' => $dataAsesmen->id]);
            $riwayatKesehatan->penyakit_yang_diderita = $request->penyakit_yang_diderita;
            $riwayatKesehatan->riwayat_kecelakaan = $request->riwayat_kecelakaan;
            $riwayatKesehatan->riwayat_rawat_inap = $request->riwayat_rawat_inap;
            $riwayatKesehatan->tanggal_riwayat_rawat_inap = $request->tanggal_rawat_inap;
            $riwayatKesehatan->riwayat_operasi = $request->riwayat_operasi;
            $riwayatKesehatan->jenis_operasi = $request->jenis_operasi;
            $riwayatKesehatan->konsumsi_obat = $request->konsumsi_obat;
            $riwayatKesehatan->merokok = $request->merokok;
            $riwayatKesehatan->alkohol = $request->alkohol;
            $riwayatKesehatan->riwayat_penyakit_keluarga = $request->riwayat_kesehatan_keluarga;
            $riwayatKesehatan->save();

            // Update RmeAsesmenKepUmumRencanaPulang
            $asesmenRencana = RmeAsesmenKepUmumRencanaPulang::firstOrNew(['id_asesmen' => $dataAsesmen->id]);
            $asesmenRencana->diagnosis_medis = $request->diagnosis_medis;
            $asesmenRencana->usia_lanjut = $request->usia_lanjut;
            $asesmenRencana->hambatan_mobilisasi = $request->hambatan_mobilisasi;
            $asesmenRencana->membutuhkan_pelayanan_medis = $request->penggunaan_media_berkelanjutan;
            $asesmenRencana->memerlukan_keterampilan_khusus = $request->keterampilan_khusus;
            $asesmenRencana->memerlukan_alat_bantu = $request->alat_bantu;
            $asesmenRencana->memiliki_nyeri_kronis = $request->nyeri_kronis;
            $asesmenRencana->ketergantungan_aktivitas = $request->ketergantungan_aktivitas;
            $asesmenRencana->perkiraan_lama_dirawat = $request->perkiraan_hari;
            $asesmenRencana->rencana_pulang = $request->tanggal_pulang;
            $asesmenRencana->kesimpulan = $request->kesimpulan_planing;
            $asesmenRencana->save();

            // Update RmeAsesmenKepUmumRisikoJatuh
            $asesmenKepUmumRisikoJatuh = RmeAsesmenKepUmumRisikoJatuh::firstOrNew(['id_asesmen' => $dataAsesmen->id]);
            $asesmenKepUmumRisikoJatuh->resiko_jatuh_jenis = (int)$request->resiko_jatuh_jenis;
            $asesmenKepUmumRisikoJatuh->risik_jatuh_tindakan = $request->risikojatuh_tindakan_keperawatan ? json_encode($request->risikojatuh_tindakan_keperawatan) : null;

            if ($request->resiko_jatuh_jenis == 1) {
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_umum_usia = $request->risiko_jatuh_umum_usia ? 1 : 0;
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_umum_kondisi_khusus = $request->risiko_jatuh_umum_kondisi_khusus ? 1 : 0;
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_umum_diagnosis_parkinson = $request->risiko_jatuh_umum_diagnosis_parkinson ? 1 : 0;
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_umum_pengobatan_berisiko = $request->risiko_jatuh_umum_pengobatan_berisiko ? 1 : 0;
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_umum_lokasi_berisiko = $request->risiko_jatuh_umum_lokasi_berisiko ? 1 : 0;
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_umum_kesimpulan = $request->input('risiko_jatuh_umum_kesimpulan', 'Tidak berisiko jatuh');
            }

            if ($request->resiko_jatuh_jenis == 2) {
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_riwayat_jatuh = array_search($request->risiko_jatuh_morse_riwayat_jatuh, ['25' => 25, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_diagnosis_sekunder = array_search($request->risiko_jatuh_morse_diagnosis_sekunder, ['15' => 15, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_bantuan_ambulasi = array_search($request->risiko_jatuh_morse_bantuan_ambulasi, ['30' => 30, '15' => 15, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_terpasang_infus = array_search($request->risiko_jatuh_morse_terpasang_infus, ['20' => 20, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_cara_berjalan = array_search($request->risiko_jatuh_morse_cara_berjalan, ['0' => 0, '20' => 20, 10 => 10]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_status_mental = array_search($request->risiko_jatuh_morse_status_mental, ['0' => 0, '15' => 15]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_kesimpulan = $request->risiko_jatuh_morse_kesimpulan;
            } else if ($request->resiko_jatuh_jenis == 3) {
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_usia_anak = array_search((int)$request->risiko_jatuh_pediatrik_usia_anak, ['4' => 4, '3' => 3, '2' => 2, '1' => 1]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_jenis_kelamin = array_search($request->risiko_jatuh_pediatrik_jenis_kelamin, ['2' => 2, '1' => 1]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_diagnosis = array_search($request->risiko_jatuh_pediatrik_diagnosis, ['4' => 4, '3' => 3, '2' => 2, '1' => 1]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_gangguan_kognitif = array_search($request->risiko_jatuh_pediatrik_gangguan_kognitif, ['3' => 3, '2' => 2, '1' => 1]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_faktor_lingkungan = array_search($request->risiko_jatuh_pediatrik_faktor_lingkungan, ['4' => 4, '3' => 3, '2' => 2, '1' => 1]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_pembedahan = array_search($request->risiko_jatuh_pediatrik_pembedahan, ['3' => 3, '2' => 2, '1' => 1]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_penggunaan_mentosa = array_search($request->risiko_jatuh_pediatrik_penggunaan_mentosa, ['3' => 3, '2' => 2, '1' => 1]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_kesimpulan = $request->risiko_jatuh_pediatrik_kesimpulan;
            } else if ($request->resiko_jatuh_jenis == 4) {
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_jatuh_saat_masuk_rs = array_search($request->risiko_jatuh_lansia_jatuh_saat_masuk_rs, ['6' => 6, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_riwayat_jatuh_2_bulan = array_search($request->risiko_jatuh_lansia_riwayat_jatuh_2_bulan, ['6' => 6, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_status_bingung = array_search($request->risiko_jatuh_lansia_status_bingung, ['14' => 14, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_status_disorientasi = array_search($request->risiko_jatuh_lansia_status_disorientasi, ['14' => 14, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_status_agitasi = array_search($request->risiko_jatuh_lansia_status_agitasi, ['14' => 14, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_kacamata = $request->risiko_jatuh_lansia_kacamata;
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_kelainan_penglihatan = $request->risiko_jatuh_lansia_kelainan_penglihatan;
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_glukoma = $request->risiko_jatuh_lansia_glukoma;
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_perubahan_berkemih = array_search($request->risiko_jatuh_lansia_perubahan_berkemih, ['2' => 2, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_transfer_mandiri = $request->risiko_jatuh_lansia_transfer_mandiri;
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_sedikit = $request->risiko_jatuh_lansia_transfer_bantuan_sedikit;
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_nyata = array_search($request->risiko_jatuh_lansia_transfer_bantuan_nyata, ['2' => 2, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_total = array_search($request->risiko_jatuh_lansia_transfer_bantuan_total, ['3' => 2, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_mobilitas_mandiri = $request->risiko_jatuh_lansia_mobilitas_mandiri;
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_mobilitas_bantuan_1_orang = $request->risiko_jatuh_lansia_mobilitas_bantuan_1_orang;
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_mobilitas_kursi_roda = array_search($request->risiko_jatuh_lansia_mobilitas_kursi_roda, ['2' => 2, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_mobilitas_imobilisasi = array_search($request->risiko_jatuh_lansia_mobilitas_imobilisasi, ['3' => 2, '0' => 0]);
                $asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_kesimpulan = $request->risiko_jatuh_lansia_kesimpulan;
            } else if ($request->resiko_jatuh_jenis == 5) {
                $asesmenKepUmumRisikoJatuh->resiko_jatuh_lainnya = 'resiko jatuh lainnya';
            }
            $asesmenKepUmumRisikoJatuh->save();

            // Update RmeAsesmenKepUmumRisikoDekubitus
            $decubitusData = RmeAsesmenKepUmumRisikoDekubitus::firstOrNew(['id_asesmen' => $dataAsesmen->id]);
            $jenisSkala = $request->input('jenis_skala_dekubitus') === 'norton' ? 1 : 2;
            $decubitusData->jenis_skala = $jenisSkala;

            function getRiskConclusionUpdate($score)
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

                $decubitusData->decubitus_kesimpulan = getRiskConclusionUpdate($totalScore);
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

                $decubitusData->decubitus_kesimpulan = getRiskConclusionUpdate($totalScore);
            }
            $decubitusData->save();

            // Update RmeAsesmenKepUmumStatusPsikologis
            $statusPsikologis = RmeAsesmenKepUmumStatusPsikologis::firstOrNew(['id_asesmen' => $dataAsesmen->id]);
            $statusPsikologis->kondisi_psikologis = $request->kondisi_psikologis_json ?? '[]';
            $statusPsikologis->gangguan_perilaku = $request->gangguan_perilaku_json ?? '[]';
            $statusPsikologis->potensi_menyakiti = $request->potensi_menyakiti;
            $statusPsikologis->keluarga_gangguan_jiwa = $request->anggota_keluarga_gangguan_jiwa;
            $statusPsikologis->lainnya = $request->psikologis_lainnya;
            $statusPsikologis->save();

            // Update RmeAsesmenKepUmumSosialEkonomi
            $asesmenKepUmumExposure = RmeAsesmenKepUmumSosialEkonomi::firstOrNew(['id_asesmen' => $dataAsesmen->id]);
            $asesmenKepUmumExposure->sosial_ekonomi_pekerjaan = $request->pekerjaan_pasien;
            $asesmenKepUmumExposure->sosial_ekonomi_status_pernikahan = $request->status_pernikahan;
            $asesmenKepUmumExposure->sosial_ekonomi_tempat_tinggal = $request->tempat_tinggal;
            $asesmenKepUmumExposure->sosial_ekonomi_tinggal_dengan_keluarga = $request->status_tinggal;
            $asesmenKepUmumExposure->sosial_ekonomi_curiga_penganiayaan = $request->curiga_penganiayaan;
            $asesmenKepUmumExposure->save();

            // Update RmeAsesmenKepUmumGizi
            $asesmenKepUmumStatusGizi = RmeAsesmenKepUmumGizi::firstOrNew(['id_asesmen' => $dataAsesmen->id]);
            $asesmenKepUmumStatusGizi->gizi_jenis = (int)$request->gizi_jenis;

            // Handle MST Form
            if ($request->gizi_jenis == 1) {
                $asesmenKepUmumStatusGizi->gizi_mst_penurunan_bb = $request->gizi_mst_penurunan_bb;
                $asesmenKepUmumStatusGizi->gizi_mst_jumlah_penurunan_bb = $request->gizi_mst_jumlah_penurunan_bb;
                $asesmenKepUmumStatusGizi->gizi_mst_nafsu_makan_berkurang = $request->gizi_mst_nafsu_makan_berkurang;
                $asesmenKepUmumStatusGizi->gizi_mst_diagnosis_khusus = $request->gizi_mst_diagnosis_khusus;
                $asesmenKepUmumStatusGizi->gizi_mst_kesimpulan = $request->gizi_mst_kesimpulan;
            }

            // Handle MNA Form
            else if ($request->gizi_jenis == 2) {
                $asesmenKepUmumStatusGizi->gizi_mna_penurunan_asupan_3_bulan = (int)$request->gizi_mna_penurunan_asupan_3_bulan;
                $asesmenKepUmumStatusGizi->gizi_mna_kehilangan_bb_3_bulan = (int)$request->gizi_mna_kehilangan_bb_3_bulan;
                $asesmenKepUmumStatusGizi->gizi_mna_mobilisasi = (int)$request->gizi_mna_mobilisasi;
                $asesmenKepUmumStatusGizi->gizi_mna_stress_penyakit_akut = (int)$request->gizi_mna_stress_penyakit_akut;
                $asesmenKepUmumStatusGizi->gizi_mna_status_neuropsikologi = (int)$request->gizi_mna_status_neuropsikologi;
                $asesmenKepUmumStatusGizi->gizi_mna_berat_badan = (int)$request->gizi_mna_berat_badan;
                $asesmenKepUmumStatusGizi->gizi_mna_tinggi_badan = (int)$request->gizi_mna_tinggi_badan;

                // Hitung dan simpan IMT
                $heightInMeters = $request->gizi_mna_tinggi_badan / 100;
                $imt = $request->gizi_mna_berat_badan / ($heightInMeters * $heightInMeters);
                $asesmenKepUmumStatusGizi->gizi_mna_imt = number_format($imt, 2, '.', '');

                $asesmenKepUmumStatusGizi->gizi_mna_kesimpulan = $request->gizi_mna_kesimpulan;
            }

            // Handle Strong Kids Form
            else if ($request->gizi_jenis == 3) {
                $asesmenKepUmumStatusGizi->gizi_strong_status_kurus = $request->gizi_strong_status_kurus;
                $asesmenKepUmumStatusGizi->gizi_strong_penurunan_bb = $request->gizi_strong_penurunan_bb;
                $asesmenKepUmumStatusGizi->gizi_strong_gangguan_pencernaan = $request->gizi_strong_gangguan_pencernaan;
                $asesmenKepUmumStatusGizi->gizi_strong_penyakit_berisiko = $request->gizi_strong_penyakit_berisiko;
                $asesmenKepUmumStatusGizi->gizi_strong_kesimpulan = $request->gizi_strong_kesimpulan;
            }

            // Handle NRS Form
            else if ($request->gizi_jenis == 4) {
                $asesmenKepUmumStatusGizi->gizi_nrs_jatuh_saat_masuk_rs = $request->gizi_nrs_jatuh_saat_masuk_rs;
                $asesmenKepUmumStatusGizi->gizi_nrs_jatuh_2_bulan_terakhir = $request->gizi_nrs_jatuh_2_bulan_terakhir;
                $asesmenKepUmumStatusGizi->gizi_nrs_status_delirium = $request->gizi_nrs_status_delirium;
                $asesmenKepUmumStatusGizi->gizi_nrs_status_disorientasi = $request->gizi_nrs_status_disorientasi;
                $asesmenKepUmumStatusGizi->gizi_nrs_status_agitasi = $request->gizi_nrs_status_agitasi;
                $asesmenKepUmumStatusGizi->gizi_nrs_menggunakan_kacamata = $request->gizi_nrs_menggunakan_kacamata;
                $asesmenKepUmumStatusGizi->gizi_nrs_keluhan_penglihatan_buram = $request->gizi_nrs_keluhan_penglihatan_buram;
                $asesmenKepUmumStatusGizi->gizi_nrs_degenerasi_makula = $request->gizi_nrs_degenerasi_makula;
                $asesmenKepUmumStatusGizi->gizi_nrs_perubahan_berkemih = $request->gizi_nrs_perubahan_berkemih;
                $asesmenKepUmumStatusGizi->gizi_nrs_transfer_mandiri = $request->gizi_nrs_transfer_mandiri;
                $asesmenKepUmumStatusGizi->gizi_nrs_transfer_bantuan_1_orang = $request->gizi_nrs_transfer_bantuan_1_orang;
                $asesmenKepUmumStatusGizi->gizi_nrs_transfer_bantuan_2_orang = $request->gizi_nrs_transfer_bantuan_2_orang;
                $asesmenKepUmumStatusGizi->gizi_nrs_transfer_bantuan_total = $request->gizi_nrs_transfer_bantuan_total;
                $asesmenKepUmumStatusGizi->gizi_nrs_mobilitas_mandiri = $request->gizi_nrs_mobilitas_mandiri;
                $asesmenKepUmumStatusGizi->gizi_nrs_mobilitas_bantuan_1_orang = $request->gizi_nrs_mobilitas_bantuan_1_orang;
                $asesmenKepUmumStatusGizi->gizi_nrs_mobilitas_kursi_roda = $request->gizi_nrs_mobilitas_kursi_roda;
                $asesmenKepUmumStatusGizi->gizi_nrs_mobilitas_imobilisasi = $request->gizi_nrs_mobilitas_imobilisasi;
                $asesmenKepUmumStatusGizi->gizi_nrs_kesimpulan = $request->gizi_nrs_kesimpulan;
            } else if ($request->gizi_jenis == 5) {
                $asesmenKepUmumStatusGizi->status_gizi_tidakada = 'tidak ada status gizi';
            }

            $asesmenKepUmumStatusGizi->save();

            // Update RmeAsesmenKepUmumStatusFungsional
            $statusFungsional = RmeAsesmenKepUmumStatusFungsional::firstOrNew(['id_asesmen' => $dataAsesmen->id]);
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
            $statusFungsional->save();

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
                ->with('success', 'Data asesmen Keperawatan Umum berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
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
