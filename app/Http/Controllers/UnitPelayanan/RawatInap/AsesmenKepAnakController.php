<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\MrItemFisik;
use App\Models\RmeAsesmen;
use App\Models\RmeAsesmenKepAnakFisik;
use App\Models\RmeAsesmenKepAnakRisikoJatuh;
use App\Models\RmeAsesmenKepAnakRiwayatKesehatan;
use App\Models\RmeAsesmenKepAnakStatusNyeri;
use App\Models\RmeAsesmenKepUmumRisikoJatuh;
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
        // dd($request->all());

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
            $asesmenKepAnakFisik->refleksi_menelan = $request->refleks_menelan;
            $asesmenKepAnakFisik->pola_tidur = $request->pola_tidur;
            $asesmenKepAnakFisik->luka = $request->luka;
            $asesmenKepAnakFisik->defekasi = $request->defekasi;
            $asesmenKepAnakFisik->miksi = $request->miksi;
            $asesmenKepAnakFisik->gastroentestinal = $request->gastrointestinal;
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

            //Simpan ke table RmeAsesmenKepAnakRiwayatKesehatan
            $riwayatKesehatan = new RmeAsesmenKepAnakRiwayatKesehatan();
            $riwayatKesehatan->id_asesmen = $dataAsesmen->id;
            $riwayatKesehatan->penyakit_yang_diderita = $request->penyakit_diderita;
            $riwayatKesehatan->riwayat_imunisasi = $request->riwayat_imunisasi == 'Ya' ? 1 : 0;
            $riwayatKesehatan->riwayat_kecelakaan = $request->riwayat_kecelakaan == 'Ya' ? 1 : 0;
            $riwayatKesehatan->riwayat_rawat_inap = $request->riwayat_rawat_inap == 'Ya' ? 1 : 0;
            $riwayatKesehatan->tanggal_riwayat_rawat_inap = $request->tanggal_rawat_inap;
            $riwayatKesehatan->riwayat_operasi = $request->riwayat_operasi;
            $riwayatKesehatan->nama_operasi = $request->jenis_operasi;
            $riwayatKesehatan->riwayat_penyakit_keluarga = $request->riwayat_kesehatan_keluarga;
            $riwayatKesehatan->konsumsi_obat = $request->konsumsi_obat;
            $riwayatKesehatan->tumbuh_kembang = $request->tumbuh_kembang;
            $riwayatKesehatan->save();

            $asesmenKepAnakRisikoJatuh = new RmeAsesmenKepAnakRisikoJatuh();
            $asesmenKepAnakRisikoJatuh->id_asesmen = $dataAsesmen->id;
            $asesmenKepAnakRisikoJatuh->resiko_jatuh_jenis = (int)$request->resiko_jatuh_jenis;
            $asesmenKepAnakRisikoJatuh->risiko_jatuh_tindakan = $request->risikojatuh_tindakan_keperawatan ? json_encode($request->risikojatuh_tindakan_keperawatan) : null;

            // Handle Skala Umum
            if ($request->resiko_jatuh_jenis == 1) {
                $asesmenKepAnakRisikoJatuh->risiko_jatuh_umum_usia = $request->risiko_jatuh_umum_usia ? 1 : 0;
                $asesmenKepAnakRisikoJatuh->risiko_jatuh_umum_kondisi_khusus = $request->risiko_jatuh_umum_kondisi_khusus ? 1 : 0;
                $asesmenKepAnakRisikoJatuh->risiko_jatuh_umum_diagnosis_parkinson = $request->risiko_jatuh_umum_diagnosis_parkinson ? 1 : 0;
                $asesmenKepAnakRisikoJatuh->risiko_jatuh_umum_pengobatan_berisiko = $request->risiko_jatuh_umum_pengobatan_berisiko ? 1 : 0;
                $asesmenKepAnakRisikoJatuh->risiko_jatuh_umum_lokasi_berisiko = $request->risiko_jatuh_umum_lokasi_berisiko ? 1 : 0;
                $asesmenKepAnakRisikoJatuh->risiko_jatuh_umum_kesimpulan = $request->input('risiko_jatuh_umum_kesimpulan', 'Tidak berisiko jatuh');
            }

            // Handle Skala Morse
            if ($request->resiko_jatuh_jenis == 2) {
                $asesmenKepAnakRisikoJatuh->risiko_jatuh_morse_riwayat_jatuh = array_search($request->risiko_jatuh_morse_riwayat_jatuh, ['25' => 25, '0' => 0]);
                $asesmenKepAnakRisikoJatuh->risiko_jatuh_morse_diagnosis_sekunder = array_search($request->risiko_jatuh_morse_diagnosis_sekunder, ['15' => 15, '0' => 0]);
                $asesmenKepAnakRisikoJatuh->risiko_jatuh_morse_bantuan_ambulasi = array_search($request->risiko_jatuh_morse_bantuan_ambulasi, ['30' => 30, '15' => 15, '0' => 0]);
                $asesmenKepAnakRisikoJatuh->risiko_jatuh_morse_terpasang_infus = array_search($request->risiko_jatuh_morse_terpasang_infus, ['20' => 20, '0' => 0]);
                $asesmenKepAnakRisikoJatuh->risiko_jatuh_morse_cara_berjalan = array_search($request->risiko_jatuh_morse_cara_berjalan, ['0' => 0, '20' => 20, 10 => 10]);
                $asesmenKepAnakRisikoJatuh->risiko_jatuh_morse_status_mental = array_search($request->risiko_jatuh_morse_status_mental, ['0' => 0, '15' => 15]);
                $asesmenKepAnakRisikoJatuh->risiko_jatuh_morse_kesimpulan = $request->risiko_jatuh_morse_kesimpulan;
                $asesmenKepAnakRisikoJatuh->save();
            }

            // Handle Skala Pediatrik/Humpty
            else if ($request->resiko_jatuh_jenis == 3) {
                $asesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_usia_anak = array_search((int)$request->risiko_jatuh_pediatrik_usia_anak, ['4' => 4, '3' => 3, '2' => 2, '1' => 1]);
                $asesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_jenis_kelamin = array_search($request->risiko_jatuh_pediatrik_jenis_kelamin, ['2' => 2, '1' => 1]);
                $asesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_diagnosis = array_search($request->risiko_jatuh_pediatrik_diagnosis, ['4' => 4, '3' => 3, '2' => 2, '1' => 1]);
                $asesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_gangguan_kognitif = array_search($request->risiko_jatuh_pediatrik_gangguan_kognitif, ['3' => 3, '2' => 2, '1' => 1]);
                $asesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_faktor_lingkungan = array_search($request->risiko_jatuh_pediatrik_faktor_lingkungan, ['4' => 4, '3' => 3, '2' => 2, '1' => 1]);
                $asesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_pembedahan = array_search($request->risiko_jatuh_pediatrik_pembedahan, ['3' => 3, '2' => 2, '1' => 1]);
                $asesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_penggunaan_mentosa = array_search($request->risiko_jatuh_pediatrik_penggunaan_mentosa, ['3' => 3, '2' => 2, '1' => 1]);
                $asesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_kesimpulan = $request->risiko_jatuh_pediatrik_kesimpulan;
            }

            // Handle Skala Lansia/Ontario
            else if ($request->resiko_jatuh_jenis == 4) {
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
                $asesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_kesimpulan = $request->risiko_jatuh_lansia_kesimpulan;
            } else if ($request->resiko_jatuh_jenis == 5) {
                $asesmenKepAnakRisikoJatuh->resiko_jatuh_lainnya = 'resiko jatuh lainnya';
            }
            $asesmenKepAnakRisikoJatuh->save();


            return redirect()->back()->with('success', 'Data asesmen anak berhasil disimpan');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

}
