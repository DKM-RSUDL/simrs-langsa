<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\MrItemFisik;
use App\Models\RmeAlergiPasien;
use App\Models\RmeAsesmen;
use App\Models\RmeAsesmenKepAnak;
use App\Models\RmeAsesmenKepAnakFisik;
use App\Models\RmeAsesmenKepAnakGizi;
use App\Models\RmeAsesmenKepAnakRencanaPulang;
use App\Models\RmeAsesmenKepAnakResikoDekubitus;
use App\Models\RmeAsesmenKepAnakRisikoJatuh;
use App\Models\RmeAsesmenKepAnakRiwayatKesehatan;
use App\Models\RmeAsesmenKepAnakSosialEkonomi;
use App\Models\RmeAsesmenKepAnakStatusFungsional;
use App\Models\RmeAsesmenKepAnakStatusNyeri;
use App\Models\RmeAsesmenKepAnakStatusPsikologis;
use App\Models\RmeAsesmenPemeriksaanFisik;
use App\Models\RmeAsesmenKepAnakKeperawatan;
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
use App\Services\AsesmenService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\CheckResumeService;
class AsesmenKepAnakController extends Controller
{
    protected $asesmenService;
    protected $checkResumeService;

    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
        $this->asesmenService = new AsesmenService;
        $this->checkResumeService = new CheckResumeService();
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
        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();

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

        if (! $dataMedis) {
            abort(404, 'Data not found');
        }

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        $dataMedis->waktu_masuk = Carbon::parse($dataMedis->TGL_MASUK.' '.$dataMedis->JAM_MASUK)->format('Y-m-d H:i:s');

        // Get latest vital signs data for the patient
        $vitalSignsData = $this->asesmenService->getLatestVitalSignsByPatient($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

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
            'alergiPasien',
            'rmeMasterDiagnosis',
            'rmeMasterImplementasi',
            'user',
            'vitalSignsData'
        ));
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        DB::beginTransaction();

        try {
            // Ambil tanggal dan jam dari form
            $tanggal = $request->tanggal_masuk;
            $jam = $request->jam_masuk;
            $waktu_asesmen = $tanggal.' '.$jam;

            // Simpan ke table RmeAsesmen
            $dataAsesmen = new RmeAsesmen;
            $dataAsesmen->kd_pasien = $kd_pasien;
            $dataAsesmen->kd_unit = $kd_unit;
            $dataAsesmen->tgl_masuk = $tgl_masuk;
            $dataAsesmen->urut_masuk = $urut_masuk;
            $dataAsesmen->user_id = Auth::id();
            $dataAsesmen->waktu_asesmen = $waktu_asesmen;
            $dataAsesmen->kategori = 2;
            $dataAsesmen->sub_kategori = 7;
            $dataAsesmen->anamnesis = $request->anamnesis;
            $dataAsesmen->save();

            // Data vital sign untuk disimpan
            $vitalSignData = [
                'sistole' => $request->sistole ? (int) $request->sistole : null,
                'diastole' => $request->diastole ? (int) $request->diastole : null, // Perbaikan dari 'distole' ke 'diastole'
                'nadi' => $request->nadi ? (int) $request->nadi : null,
                'respiration' => $request->nafas ? (int) $request->nafas : null,
                'suhu' => $request->suhu ? (float) $request->suhu : null,
                'spo2_tanpa_o2' => $request->sao2 ?? $request->saturasi_o2_tanpa ? (int) ($request->sao2 ?? $request->saturasi_o2_tanpa) : null,
                'spo2_dengan_o2' => $request->sao2 ?? $request->saturasi_o2_dengan ? (int) ($request->sao2 ?? $request->saturasi_o2_dengan) : null,
                'tinggi_badan' => $request->tb ?? $request->tinggi_badan ? (int) ($request->tb ?? $request->tinggi_badan) : null,
                'berat_badan' => $request->bb ?? $request->berat_badan ? (int) ($request->bb ?? $request->berat_badan) : null,
            ];

            $lastTransaction = $this->asesmenService->getTransaksiData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

            // Simpan vital sign menggunakan service
            $this->asesmenService->store($vitalSignData, $kd_pasien, $lastTransaction->no_transaksi, $lastTransaction->kd_kasir);

            // Simpan ke tabel RmeAsesmenKepAnak
            $asesmenKepAnak = new RmeAsesmenKepAnak;
            $asesmenKepAnak->id_asesmen = $dataAsesmen->id;
            $asesmenKepAnak->cara_masuk = $request->cara_masuk;
            $asesmenKepAnak->kasus_trauma = $request->kasus_trauma;
            $asesmenKepAnak->anamnesis = $request->anamnesis;
            $asesmenKepAnak->pandangan_terhadap_penyakit = $request->pandangan_terhadap_penyakit;
            $asesmenKepAnak->agama = $request->keyakinan_agama;
            $asesmenKepAnak->gaya_bicara = $request->gaya_bicara;
            $asesmenKepAnak->bahasa = $request->bahasa_sehari_hari;
            $asesmenKepAnak->perlu_penerjemahan = $request->perlu_penerjemah;
            $asesmenKepAnak->hambatan_komunikasi = $request->hambatan_komunikasi;
            $asesmenKepAnak->media_disukai = $request->media_disukai;
            $asesmenKepAnak->tingkat_pendidikan = $request->tingkat_pendidikan;
            $asesmenKepAnak->keluhan_utama = $request->keluhan_utama;
            $asesmenKepAnak->riwayat_kesehatan_sekarang = $request->riwayat_kesehatan_sekarang;
            $asesmenKepAnak->gcs = $request->gcs_value;

            if ($request->has('masalah_diagnosis') && is_array($request->masalah_diagnosis)) {
                $masalahDiagnosis = array_filter($request->masalah_diagnosis, function ($value) {
                    return ! empty(trim($value));
                });
                $asesmenKepAnak->masalah_diagnosis = json_encode(array_values($masalahDiagnosis));
            }

            if ($request->has('intervensi_rencana') && is_array($request->intervensi_rencana)) {
                $intervensiRencana = array_filter($request->intervensi_rencana, function ($value) {
                    return ! empty(trim($value));
                });
                $asesmenKepAnak->intervensi_rencana = json_encode(array_values($intervensiRencana));
            }

            $asesmenKepAnak->save();

            // Simpan ke tabel RmeAsesmenKepAnakSosialEkonomi
            $sosialEkonomi = new RmeAsesmenKepAnakSosialEkonomi;
            $sosialEkonomi->id_asesmen = $dataAsesmen->id;
            $sosialEkonomi->sosial_ekonomi_pekerjaan = $request->pekerjaan_pasien;
            $sosialEkonomi->sosial_ekonomi_status_pernikahan = $request->status_pernikahan;
            $sosialEkonomi->sosial_ekonomi_tempat_tinggal = $request->tempat_tinggal;
            $sosialEkonomi->sosial_ekonomi_tinggal_dengan_keluarga = $request->status_tinggal;
            $sosialEkonomi->sosial_ekonomi_curiga_penganiayaan = $request->curiga_penganiayaan;
            $sosialEkonomi->save();

            // Validasi data alergi
            $alergiData = json_decode($request->alergis, true);

            if (! empty($alergiData)) {
                // Hapus data alergi lama untuk pasien ini
                RmeAlergiPasien::where('kd_pasien', $kd_pasien)->delete();

                // Simpan data alergi baru
                foreach ($alergiData as $alergi) {
                    RmeAlergiPasien::create([
                        'kd_pasien' => $kd_pasien,
                        'jenis_alergi' => $alergi['jenis_alergi'],
                        'nama_alergi' => $alergi['alergen'],
                        'reaksi' => $alergi['reaksi'],
                        'tingkat_keparahan' => $alergi['tingkat_keparahan'],
                    ]);
                }
            }

            // Simpan ke tabel RmeAsesmenKepAnakFisik
            $asesmenKepAnakFisik = new RmeAsesmenKepAnakFisik;
            $asesmenKepAnakFisik->id_asesmen = $dataAsesmen->id;
            $asesmenKepAnakFisik->sistole = $vitalSignData['sistole'];
            $asesmenKepAnakFisik->diastole = $vitalSignData['diastole'];
            $asesmenKepAnakFisik->nadi = $vitalSignData['nadi'];
            $asesmenKepAnakFisik->nafas = $vitalSignData['respiration'];
            $asesmenKepAnakFisik->suhu = $vitalSignData['suhu'];
            $asesmenKepAnakFisik->spo2_tanpa_bantuan = $vitalSignData['spo2_tanpa_o2'];
            $asesmenKepAnakFisik->spo2_dengan_bantuan = $request->saturasi_o2_dengan ? (int) $request->saturasi_o2_dengan : null;
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
            $asesmenKepAnakFisik->tinggi_badan = $vitalSignData['tinggi_badan'];
            $asesmenKepAnakFisik->berat_badan = $vitalSignData['berat_badan'];
            $asesmenKepAnakFisik->imt = $vitalSignData['imt'] ?? null; // IMT dihitung jika ada data TB dan BB
            $asesmenKepAnakFisik->lpt = $request->lpt;
            $asesmenKepAnakFisik->lingkar_kepala = $request->lingkar_kepala ? (int) $request->lingkar_kepala : null;
            $asesmenKepAnakFisik->save();

            // Simpan ke table RmePemeriksaanFisik
            $itemFisik = MrItemFisik::all();
            foreach ($itemFisik as $item) {
                $isNormal = $request->has($item->id.'-normal') ? 1 : 0;
                $keterangan = $request->input($item->id.'_keterangan');
                if ($isNormal) {
                    $keterangan = '';
                }

                RmeAsesmenPemeriksaanFisik::create([
                    'id_asesmen' => $dataAsesmen->id,
                    'id_item_fisik' => $item->id,
                    'is_normal' => $isNormal,
                    'keterangan' => $keterangan,
                ]);
            }

            // Simpan ke table RmeKepAnakStatusNyeri
            $statusNyeri = new RmeAsesmenKepAnakStatusNyeri;
            $statusNyeri->id_asesmen = $dataAsesmen->id;
            if ($request->filled('jenis_skala_nyeri')) {
                $jenisSkala = [
                    'NRS' => 1,
                    'FLACC' => 2,
                    'CRIES' => 3,
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

            // Simpan ke table RmeAsesmenKepAnakRiwayatKesehatan
            $riwayatKesehatan = new RmeAsesmenKepAnakRiwayatKesehatan;
            $riwayatKesehatan->id_asesmen = $dataAsesmen->id;
            $riwayatKesehatan->penyakit_yang_diderita = $request->penyakit_diderita;
            $riwayatKesehatan->riwayat_imunisasi = $request->riwayat_imunisasi == 'Ya' ? 1 : 0;
            $riwayatKesehatan->jenis_kecelakaan = $request->riwayat_kecelakaan;
            $riwayatKesehatan->riwayat_rawat_inap = $request->riwayat_rawat_inap == 'Ya' ? 1 : 0;
            $riwayatKesehatan->tanggal_riwayat_rawat_inap = $request->tanggal_rawat_inap;
            $riwayatKesehatan->riwayat_operasi = $request->riwayat_operasi;
            $riwayatKesehatan->nama_operasi = $request->jenis_operasi;
            $riwayatKesehatan->riwayat_penyakit_keluarga = $request->riwayat_kesehatan_keluarga;
            $riwayatKesehatan->konsumsi_obat = $request->konsumsi_obat;
            $riwayatKesehatan->tumbuh_kembang = $request->tumbuh_kembang;
            $riwayatKesehatan->penyakit_diderita_lalu = json_encode($request->penyakit_diderita_lalu ?? []);
            $riwayatKesehatan->penyakit_diderita_lainnya = $request->penyakit_diderita_lainnya;
            $riwayatKesehatan->riwayat_kecelakaan_lalu = json_encode($request->riwayat_kecelakaan_lalu ?? []);
            $riwayatKesehatan->jenis_operasi = $request->jenis_operasi;
            $riwayatKesehatan->save();

            // Simpan ke table RmeAsesmenKepAnakRisikoJatuh
            $asesmenKepAnakRisikoJatuh = new RmeAsesmenKepAnakRisikoJatuh;
            $asesmenKepAnakRisikoJatuh->id_asesmen = $dataAsesmen->id;
            $asesmenKepAnakRisikoJatuh->resiko_jatuh_jenis = (int) $request->resiko_jatuh_jenis;
            if ($request->has('intervensi_risiko_jatuh_json')) {
                $intervensiRisikoJatuhJson = $request->intervensi_risiko_jatuh_json;
                $asesmenKepAnakRisikoJatuh->intervensi_risiko_jatuh = $intervensiRisikoJatuhJson;
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
                $asesmenKepAnakRisikoJatuh->save();
            }

            // Handle Skala Pediatrik/Humpty
            elseif ($request->resiko_jatuh_jenis == 3) {
                $asesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_usia_anak = array_search((int) $request->risiko_jatuh_pediatrik_usia_anak, ['4' => 4, '3' => 3, '2' => 2, '1' => 1]);
                $asesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_jenis_kelamin = array_search($request->risiko_jatuh_pediatrik_jenis_kelamin, ['2' => 2, '1' => 1]);
                $asesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_diagnosis = array_search($request->risiko_jatuh_pediatrik_diagnosis, ['4' => 4, '3' => 3, '2' => 2, '1' => 1]);
                $asesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_gangguan_kognitif = array_search($request->risiko_jatuh_pediatrik_gangguan_kognitif, ['3' => 3, '2' => 2, '1' => 1]);
                $asesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_faktor_lingkungan = array_search($request->risiko_jatuh_pediatrik_faktor_lingkungan, ['4' => 4, '3' => 3, '2' => 2, '1' => 1]);
                $asesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_pembedahan = array_search($request->risiko_jatuh_pediatrik_pembedahan, ['3' => 3, '2' => 2, '1' => 1]);
                $asesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_penggunaan_mentosa = array_search($request->risiko_jatuh_pediatrik_penggunaan_mentosa, ['3' => 3, '2' => 2, '1' => 1]);
                $asesmenKepAnakRisikoJatuh->kesimpulan_skala_pediatrik = $request->risiko_jatuh_pediatrik_kesimpulan;
            }

            // Handle Skala Lansia/Ontario
            elseif ($request->resiko_jatuh_jenis == 4) {
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
            } elseif ($request->resiko_jatuh_jenis == 5) {
                $asesmenKepAnakRisikoJatuh->resiko_jatuh_lainnya = 'resiko jatuh lainnya';
            }
            $asesmenKepAnakRisikoJatuh->save();

            // Simpan ke table RmeAsesmenKepAnakStatusPsikologi
            $statusPsikologis = new RmeAsesmenKepAnakStatusPsikologis;
            $statusPsikologis->id_asesmen = $dataAsesmen->id;
            $statusPsikologis->kondisi_psikologis = $request->kondisi_psikologis_json ?? '[]';
            $statusPsikologis->gangguan_perilaku = $request->gangguan_perilaku_json ?? '[]';
            $statusPsikologis->potensi_menyakiti = $request->potensi_menyakiti;
            $statusPsikologis->keluarga_gangguan_jiwa = $request->anggota_keluarga_gangguan_jiwa;
            $statusPsikologis->lainnya = $request->psikologis_lainnya;
            $statusPsikologis->save();

            // Simpan ke table RmeAsesmenKepAnakGizi
            $asesmenKepAnakStatusGizi = new RmeAsesmenKepAnakGizi;
            $asesmenKepAnakStatusGizi->id_asesmen = $dataAsesmen->id;
            $asesmenKepAnakStatusGizi->gizi_jenis = (int) $request->gizi_jenis;

            // Handle MST Form
            if ($request->gizi_jenis == 1) {
                $asesmenKepAnakStatusGizi->gizi_mst_penurunan_bb = $request->gizi_mst_penurunan_bb;
                $asesmenKepAnakStatusGizi->gizi_mst_jumlah_penurunan_bb = $request->gizi_mst_jumlah_penurunan_bb;
                $asesmenKepAnakStatusGizi->gizi_mst_nafsu_makan_berkurang = $request->gizi_mst_nafsu_makan_berkurang;
                $asesmenKepAnakStatusGizi->gizi_mst_diagnosis_khusus = $request->gizi_mst_diagnosis_khusus;
                $asesmenKepAnakStatusGizi->gizi_mst_kesimpulan = $request->gizi_mst_kesimpulan;
            }

            // Handle MNA Form
            elseif ($request->gizi_jenis == 2) {
                $asesmenKepAnakStatusGizi->gizi_mna_penurunan_asupan_3_bulan = (int) $request->gizi_mna_penurunan_asupan_3_bulan;
                $asesmenKepAnakStatusGizi->gizi_mna_kehilangan_bb_3_bulan = (int) $request->gizi_mna_kehilangan_bb_3_bulan;
                $asesmenKepAnakStatusGizi->gizi_mna_mobilisasi = (int) $request->gizi_mna_mobilisasi;
                $asesmenKepAnakStatusGizi->gizi_mna_stress_penyakit_akut = (int) $request->gizi_mna_stress_penyakit_akut;
                $asesmenKepAnakStatusGizi->gizi_mna_status_neuropsikologi = (int) $request->gizi_mna_status_neuropsikologi;
                $asesmenKepAnakStatusGizi->gizi_mna_berat_badan = (int) $request->gizi_mna_berat_badan;
                $asesmenKepAnakStatusGizi->gizi_mna_tinggi_badan = (int) $request->gizi_mna_tinggi_badan;

                // Hitung dan simpan IMT
                $heightInMeters = $request->gizi_mna_tinggi_badan / 100;
                $imt = $request->gizi_mna_berat_badan / ($heightInMeters * $heightInMeters);
                $asesmenKepAnakStatusGizi->gizi_mna_imt = number_format($imt, 2, '.', '');

                $asesmenKepAnakStatusGizi->gizi_mna_kesimpulan = $request->gizi_mna_kesimpulan;
            }

            // Handle Strong Kids Form
            elseif ($request->gizi_jenis == 3) {
                $asesmenKepAnakStatusGizi->gizi_strong_status_kurus = $request->gizi_strong_status_kurus;
                $asesmenKepAnakStatusGizi->gizi_strong_penurunan_bb = $request->gizi_strong_penurunan_bb;
                $asesmenKepAnakStatusGizi->gizi_strong_gangguan_pencernaan = $request->gizi_strong_gangguan_pencernaan;
                $asesmenKepAnakStatusGizi->gizi_strong_penyakit_berisiko = $request->gizi_strong_penyakit_berisiko;
                $asesmenKepAnakStatusGizi->gizi_strong_kesimpulan = $request->gizi_strong_kesimpulan;
            }

            // Handle NRS Form
            elseif ($request->gizi_jenis == 4) {
                $asesmenKepAnakStatusGizi->gizi_nrs_jatuh_saat_masuk_rs = $request->gizi_nrs_jatuh_saat_masuk_rs;
                $asesmenKepAnakStatusGizi->gizi_nrs_jatuh_2_bulan_terakhir = $request->gizi_nrs_jatuh_2_bulan_terakhir;
                $asesmenKepAnakStatusGizi->gizi_nrs_status_delirium = $request->gizi_nrs_status_delirium;
                $asesmenKepAnakStatusGizi->gizi_nrs_status_disorientasi = $request->gizi_nrs_status_disorientasi;
                $asesmenKepAnakStatusGizi->gizi_nrs_status_agitasi = $request->gizi_nrs_status_agitasi;
                $asesmenKepAnakStatusGizi->gizi_nrs_menggunakan_kacamata = $request->gizi_nrs_menggunakan_kacamata;
                $asesmenKepAnakStatusGizi->gizi_nrs_keluhan_penglihatan_buram = $request->gizi_nrs_keluhan_penglihatan_buram;
                $asesmenKepAnakStatusGizi->gizi_nrs_degenerasi_makula = $request->gizi_nrs_degenerasi_makula;
                $asesmenKepAnakStatusGizi->gizi_nrs_perubahan_berkemih = $request->gizi_nrs_perubahan_berkemih;
                $asesmenKepAnakStatusGizi->gizi_nrs_transfer_mandiri = $request->gizi_nrs_transfer_mandiri;
                $asesmenKepAnakStatusGizi->gizi_nrs_transfer_bantuan_1_orang = $request->gizi_nrs_transfer_bantuan_1_orang;
                $asesmenKepAnakStatusGizi->gizi_nrs_transfer_bantuan_2_orang = $request->gizi_nrs_transfer_bantuan_2_orang;
                $asesmenKepAnakStatusGizi->gizi_nrs_transfer_bantuan_total = $request->gizi_nrs_transfer_bantuan_total;
                $asesmenKepAnakStatusGizi->gizi_nrs_mobilitas_mandiri = $request->gizi_nrs_mobilitas_mandiri;
                $asesmenKepAnakStatusGizi->gizi_nrs_mobilitas_bantuan_1_orang = $request->gizi_nrs_mobilitas_bantuan_1_orang;
                $asesmenKepAnakStatusGizi->gizi_nrs_mobilitas_kursi_roda = $request->gizi_nrs_mobilitas_kursi_roda;
                $asesmenKepAnakStatusGizi->gizi_nrs_mobilitas_imobilisasi = $request->gizi_nrs_mobilitas_imobilisasi;
                $asesmenKepAnakStatusGizi->gizi_nrs_kesimpulan = $request->gizi_nrs_kesimpulan;
            } elseif ($request->gizi_jenis == 5) {
                $asesmenKepAnakStatusGizi->status_gizi_tidakada = 'tidak ada status gizi';
            }

            $asesmenKepAnakStatusGizi->save();

            // Simpan ke table RmeAsesmenKepAnakStatusDecubitus
            $decubitusData = new RmeAsesmenKepAnakResikoDekubitus;
            $decubitusData->id_asesmen = $dataAsesmen->id;

            $jenisSkala = $request->input('jenis_skala_dekubitus') === 'norton' ? 1 : 2;
            $decubitusData->jenis_skala = $jenisSkala;

            // // Fungsi untuk menentukan kesimpulan
            // function getRiskConclusion($score)
            // {
            //     if ($score <= 12) {
            //         return 'Risiko Tinggi';
            //     } elseif ($score <= 14) {
            //         return 'Risiko Sedang';
            //     }

            //     return 'Risiko Rendah';
            // }

            if ($jenisSkala === 1) {
                // Norton
                $decubitusData->norton_kondisi_fisik = $request->input('kondisi_fisik');
                $decubitusData->norton_kondisi_mental = $request->input('kondisi_mental');
                $decubitusData->norton_aktivitas = $request->input('norton_aktivitas');
                $decubitusData->norton_mobilitas = $request->input('norton_mobilitas');
                $decubitusData->norton_inkontenesia = $request->input('inkontinensia');

                $totalScore =
                    (int) $request->input('kondisi_fisik') +
                    (int) $request->input('kondisi_mental') +
                    (int) $request->input('norton_aktivitas') +
                    (int) $request->input('norton_mobilitas') +
                    (int) $request->input('inkontinensia');
                    
                $decubitusData->decubitus_kesimpulan = $this->getRiskConclusion($totalScore);
            } else {
                // Braden
                $decubitusData->braden_persepsi = $request->input('persepsi_sensori');
                $decubitusData->braden_kelembapan = $request->input('kelembapan');
                $decubitusData->braden_aktivitas = $request->input('braden_aktivitas');
                $decubitusData->braden_mobilitas = $request->input('braden_mobilitas');
                $decubitusData->braden_nutrisi = $request->input('nutrisi');
                $decubitusData->braden_pergesekan = $request->input('pergesekan');

                $totalScore =
                    (int) $request->input('persepsi_sensori') +
                    (int) $request->input('kelembapan') +
                    (int) $request->input('braden_aktivitas') +
                    (int) $request->input('braden_mobilitas') +
                    (int) $request->input('nutrisi') +
                    (int) $request->input('pergesekan');

                $decubitusData->decubitus_kesimpulan = $this->getRiskConclusion($totalScore);
            }
            $decubitusData->save();

            // Simpan ke table RmeAsesmenKepAnakStatusFungsional
            $statusFungsional = new RmeAsesmenKepAnakStatusFungsional;
            $statusFungsional->id_asesmen = $dataAsesmen->id;
            if ($request->filled('skala_fungsional')) {
                if ($request->skala_fungsional === 'Pengkajian Aktivitas') {
                    $statusFungsional->jenis_skala = 1;
                } elseif ($request->skala_fungsional === 'Lainnya') {
                    $statusFungsional->jenis_skala = 2;
                }
            } else {
                $statusFungsional->jenis_skala = 0;
            }

            // Simpan data ADL
            $statusFungsional->makan = $request->adl_makan;
            $statusFungsional->berjalan = $request->adl_berjalan;
            $statusFungsional->mandi = $request->adl_mandi;
            $statusFungsional->jumlah_skala = $request->filled('adl_total') ? (int) $request->adl_total : null;
            $statusFungsional->kesimpulan = $request->adl_kesimpulan_value;
            $statusFungsional->nilai_skala_adl = $request->filled('adl_total') ? (int) $request->adl_total : null;
            $statusFungsional->kesimpulan_fungsional = $request->adl_kesimpulan_value;
            $statusFungsional->save();

            // Simpan ke table RmeAsesmenKepAnakRencana
            $asesmenRencana = new RmeAsesmenKepAnakRencanaPulang;
            $asesmenRencana->id_asesmen = $dataAsesmen->id;
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

            // Simpan ke table RmeAsesmenKepAnakResume
            $resumeData = [
                'anamnesis' => $request->anamnesis,
                'diagnosis' => [],
                'tindak_lanjut_code' => null,
                'tindak_lanjut_name' => null,
                'tgl_kontrol_ulang' => null,
                'unit_rujuk_internal' => null,
                'rs_rujuk' => null,
                'rs_rujuk_bagian' => null,
                'konpas' => [
                    'sistole' => ['hasil' => $vitalSignData['sistole']],
                    'diastole' => ['hasil' => $vitalSignData['diastole']],
                    'respiration_rate' => ['hasil' => $vitalSignData['respiration']],
                    'suhu' => ['hasil' => $vitalSignData['suhu']],
                    'nadi' => ['hasil' => $vitalSignData['nadi']],
                    'tinggi_badan' => ['hasil' => $vitalSignData['tinggi_badan']],
                    'berat_badan' => ['hasil' => $vitalSignData['berat_badan']],
                ],
            ];

            // Simpan ke tabel RmeAsesmenKepAnakKeperawatan
            $asesmenKepAnakKeperawatan = RmeAsesmenKepAnakKeperawatan::create([
                'id_asesmen' => $dataAsesmen->id,
                'tanggal' => $request->tanggal ?? date('Y-m-d'),
                'jam' => $request->jam ?? date('H:i:s'),
                'diagnosis' => $request->diagnosis ?? [],
                'rencana_bersihan_jalan_nafas' => $request->rencana_bersihan_jalan_nafas ?? [],
                'rencana_penurunan_curah_jantung' => $request->rencana_penurunan_curah_jantung ?? [],
                'rencana_perfusi_perifer' => $request->rencana_perfusi_perifer ?? [],
                'rencana_hipovolemia' => $request->rencana_hipovolemia ?? [],
                'rencana_hipervolemia' => $request->rencana_hipervolemia ?? [],
                'rencana_diare' => $request->rencana_diare ?? [],
                'rencana_retensi_urine' => $request->rencana_retensi_urine ?? [],
                'rencana_nyeri_akut' => $request->rencana_nyeri_akut ?? [],
                'rencana_nyeri_kronis' => $request->rencana_nyeri_kronis ?? [],
                'rencana_hipertermia' => $request->rencana_hipertermia ?? [],
                'rencana_gangguan_mobilitas_fisik' => $request->rencana_gangguan_mobilitas_fisik ?? [],
                'rencana_resiko_infeksi' => $request->rencana_resiko_infeksi ?? [],
                'rencana_konstipasi' => $request->rencana_konstipasi ?? [],
                'rencana_resiko_jatuh' => $request->rencana_resiko_jatuh ?? [],
                'rencana_gangguan_integritas_kulit' => $request->rencana_gangguan_integritas_kulit ?? [],
            ]);

            // Panggil ResumeService
            $resume = $this->checkResumeService->checkAndCreateResume([
                'kd_pasien' => $kd_pasien,
                'kd_unit' => $kd_unit,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk
            ]);

            DB::commit();

            return to_route('rawat-inap.asesmen.medis.umum.index', [
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
            ])->with('success', 'Data asesmen anak berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Terjadi kesalahan: '.$e->getMessage());
        }
    }

    public function show($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            // Ambil data asesmen beserta semua relasinya

            $asesmen = RmeAsesmen::with([
                'user',
                'rmeAsesmenKepAnak',
                'rmeAsesmenKepAnakSosialEkonomi',
                'pemeriksaanFisik.itemFisik',
                'rmeAsesmenKepAnakFisik',
                'rmeAsesmenKepAnakStatusNyeri',
                'rmeAsesmenKepAnakRiwayatKesehatan',
                'rmeAsesmenKepAnakRisikoJatuh',
                'rmeAsesmenKepAnakStatusPsikologis',
                'rmeAsesmenKepAnakGizi',
                'rmeAsesmenKepAnakResikoDekubitus',
                'rmeAsesmenKepAnakStatusFungsional',
                'rmeAsesmenKepAnakRencanaPulang',
                'rmeAsesmenKepAnakKeperawatan'
            ])->findOrFail($id);

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

            if (! $dataMedis) {
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

            $dataMedis->waktu_masuk = Carbon::parse($dataMedis->TGL_MASUK.' '.$dataMedis->JAM_MASUK)->format('Y-m-d H:i:s');

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

            return view('unit-pelayanan.rawat-inap.pelayanan.asesmen-anak.show', compact(
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
                'user'
            ));
        } catch (ModelNotFoundException $e) {
            return back()->with('error', 'Data tidak ditemukan. Detail: '.$e->getMessage());
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: '.$e->getMessage());
        }
    }

    public function edit($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            // Ambil data asesmen beserta semua relasinya
            $asesmen = RmeAsesmen::with([
                'user',
                'rmeAsesmenKepAnak',
                'rmeAsesmenKepAnakSosialEkonomi',
                'pemeriksaanFisik.itemFisik',
                'rmeAsesmenKepAnakFisik',
                'rmeAsesmenKepAnakStatusNyeri',
                'rmeAsesmenKepAnakRiwayatKesehatan',
                'rmeAsesmenKepAnakRisikoJatuh',
                'rmeAsesmenKepAnakStatusPsikologis',
                'rmeAsesmenKepAnakGizi',
                'rmeAsesmenKepAnakResikoDekubitus',
                'rmeAsesmenKepAnakStatusFungsional',
                'rmeAsesmenKepAnakRencanaPulang',
                'rmeAsesmenKepAnakKeperawatan'
            ])->findOrFail($id);

            // Pastikan data RmeAsesmenKepAnakSosialEkonomi ada
            if (! $asesmen->rmeAsesmenKepAnakSosialEkonomi) {
                $sosialEkonomi = new RmeAsesmenKepAnakSosialEkonomi;
                $sosialEkonomi->id_asesmen = $asesmen->id;
                $sosialEkonomi->save();
                // Refresh relasi setelah membuat data baru
                $asesmen->load('rmeAsesmenKepAnakSosialEkonomi');
            }

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

            $dataMedis->waktu_masuk = Carbon::parse($dataMedis->TGL_MASUK.' '.$dataMedis->JAM_MASUK)->format('Y-m-d H:i:s');

            if ($asesmen->rmeAsesmenKepAnak && $asesmen->rmeAsesmenKepAnak->gcs) {
                $gcsData = $this->parseGCSData($asesmen->rmeAsesmenKepAnak->gcs);
                $asesmen->gcs_parsed = $gcsData;
            }

            if ($asesmen->rmeAsesmenKepAnak) {
                // Parse masalah diagnosis
                $masalahDiagnosis = [];
                if ($asesmen->rmeAsesmenKepAnak->masalah_diagnosis) {
                    $masalahDiagnosis = json_decode($asesmen->rmeAsesmenKepAnak->masalah_diagnosis, true) ?? [];
                }
                $asesmen->masalah_diagnosis_parsed = $masalahDiagnosis;

                // Parse intervensi rencana
                $intervensiRencana = [];
                if ($asesmen->rmeAsesmenKepAnak->intervensi_rencana) {
                    $intervensiRencana = json_decode($asesmen->rmeAsesmenKepAnak->intervensi_rencana, true) ?? [];
                }
                $asesmen->intervensi_rencana_parsed = $intervensiRencana;
            }

            // Mengambil data tambahan yang diperlukan untuk tampilan
            $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();
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

            return view('unit-pelayanan.rawat-inap.pelayanan.asesmen-anak.edit', compact(
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
                'alergiPasien',
                'user',
                'kd_unit',
                'kd_pasien',
                'tgl_masuk',
                'urut_masuk'
            ));
        } catch (ModelNotFoundException $e) {
            return back()->with('error', 'Data tidak ditemukan. Detail: '.$e->getMessage());
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: '.$e->getMessage());
        }
    }

    private function parseGCSData($gcsString)
    {
        // Format: "10 E3 V3 M4"
        $parts = explode(' ', $gcsString);

        if (count($parts) >= 4) {
            return [
                'total' => $parts[0],
                'eye' => str_replace('E', '', $parts[1]),
                'verbal' => str_replace('V', '', $parts[2]),
                'motor' => str_replace('M', '', $parts[3]),
            ];
        }

        return ['total' => '', 'eye' => '', 'verbal' => '', 'motor' => ''];
    }

    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            // Ambil tanggal dan jam dari form
            $tanggal = $request->tanggal_masuk;
            $jam = $request->jam_masuk;
            $waktu_asesmen = $tanggal.' '.$jam;

            // Update RmeAsesmen
            $dataAsesmen = RmeAsesmen::findOrFail($id);
            $dataAsesmen->kd_pasien = $kd_pasien;
            $dataAsesmen->kd_unit = $kd_unit;
            $dataAsesmen->tgl_masuk = $tgl_masuk;
            $dataAsesmen->urut_masuk = $urut_masuk;
            $dataAsesmen->user_id = Auth::id();
            $dataAsesmen->waktu_asesmen = $waktu_asesmen;
            $dataAsesmen->kategori = 2;
            $dataAsesmen->sub_kategori = 7;
            $dataAsesmen->anamnesis = $request->anamnesis;
            $dataAsesmen->save();

            // Update RmeAsesmenKepAnak
            $asesmenKepAnak = RmeAsesmenKepAnak::where('id_asesmen', $dataAsesmen->id)->first();
            if (! $asesmenKepAnak) {
                $asesmenKepAnak = new RmeAsesmenKepAnak;
                $asesmenKepAnak->id_asesmen = $dataAsesmen->id;
            }

            $asesmenKepAnak->cara_masuk = $request->cara_masuk;
            $asesmenKepAnak->kasus_trauma = $request->kasus_trauma;
            $asesmenKepAnak->anamnesis = $request->anamnesis;
            $asesmenKepAnak->pandangan_terhadap_penyakit = $request->pandangan_terhadap_penyakit;
            $asesmenKepAnak->agama = $request->keyakinan_agama;
            $asesmenKepAnak->gaya_bicara = $request->gaya_bicara;
            $asesmenKepAnak->bahasa = $request->bahasa_sehari_hari;
            $asesmenKepAnak->perlu_penerjemahan = $request->perlu_penerjemah;
            $asesmenKepAnak->hambatan_komunikasi = $request->hambatan_komunikasi;
            $asesmenKepAnak->media_disukai = $request->media_disukai;
            $asesmenKepAnak->tingkat_pendidikan = $request->tingkat_pendidikan;
            $asesmenKepAnak->keluhan_utama = $request->keluhan_utama;
            $asesmenKepAnak->riwayat_kesehatan_sekarang = $request->riwayat_kesehatan_sekarang;
            $asesmenKepAnak->gcs = $request->gcs_value;

            if ($request->has('masalah_diagnosis') && is_array($request->masalah_diagnosis)) {
                $masalahDiagnosis = array_filter($request->masalah_diagnosis, function ($value) {
                    return ! empty(trim($value));
                });
                $asesmenKepAnak->masalah_diagnosis = json_encode(array_values($masalahDiagnosis));
            }

            if ($request->has('intervensi_rencana') && is_array($request->intervensi_rencana)) {
                $intervensiRencana = array_filter($request->intervensi_rencana, function ($value) {
                    return ! empty(trim($value));
                });
                $asesmenKepAnak->intervensi_rencana = json_encode(array_values($intervensiRencana));
            }

            $asesmenKepAnak->save();

            // Update atau Buat RmeAsesmenKepAnakSosialEkonomi
            $sosialEkonomi = RmeAsesmenKepAnakSosialEkonomi::where('id_asesmen', $dataAsesmen->id)->first();
            if (! $sosialEkonomi) {
                $sosialEkonomi = new RmeAsesmenKepAnakSosialEkonomi;
                $sosialEkonomi->id_asesmen = $dataAsesmen->id;
            }

            $sosialEkonomi->sosial_ekonomi_pekerjaan = $request->pekerjaan_pasien;
            $sosialEkonomi->sosial_ekonomi_status_pernikahan = $request->status_pernikahan;
            $sosialEkonomi->sosial_ekonomi_tempat_tinggal = $request->tempat_tinggal;
            $sosialEkonomi->sosial_ekonomi_tinggal_dengan_keluarga = $request->status_tinggal;
            $sosialEkonomi->sosial_ekonomi_curiga_penganiayaan = $request->curiga_penganiayaan;
            $sosialEkonomi->save();

            // Update data alergi
            $alergiData = json_decode($request->alergis, true);

            if (! empty($alergiData)) {
                // Hapus data alergi lama untuk pasien ini
                RmeAlergiPasien::where('kd_pasien', $kd_pasien)->delete();

                // Simpan data alergi baru
                foreach ($alergiData as $alergi) {
                    RmeAlergiPasien::create([
                        'kd_pasien' => $kd_pasien,
                        'jenis_alergi' => $alergi['jenis_alergi'],
                        'nama_alergi' => $alergi['alergen'],
                        'reaksi' => $alergi['reaksi'],
                        'tingkat_keparahan' => $alergi['tingkat_keparahan'],
                    ]);
                }
            } else {
                // Jika tidak ada data alergi baru, hapus yang lama
                RmeAlergiPasien::where('kd_pasien', $kd_pasien)->delete();
            }

            // Update RmeAsesmenKepAnakFisik
            $asesmenKepAnakFisik = RmeAsesmenKepAnakFisik::where('id_asesmen', $dataAsesmen->id)->first();
            if (! $asesmenKepAnakFisik) {
                $asesmenKepAnakFisik = new RmeAsesmenKepAnakFisik;
                $asesmenKepAnakFisik->id_asesmen = $dataAsesmen->id;
            }

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

            // Update RmePemeriksaanFisik
            RmeAsesmenPemeriksaanFisik::where('id_asesmen', $dataAsesmen->id)->delete();
            $itemFisik = MrItemFisik::all();
            foreach ($itemFisik as $item) {
                $isNormal = $request->has($item->id.'-normal') ? 1 : 0;
                $keterangan = $request->input($item->id.'_keterangan');
                if ($isNormal) {
                    $keterangan = '';
                }

                RmeAsesmenPemeriksaanFisik::create([
                    'id_asesmen' => $dataAsesmen->id,
                    'id_item_fisik' => $item->id,
                    'is_normal' => $isNormal,
                    'keterangan' => $keterangan,
                ]);
            }

            // Update RmeAsesmenKepAnakStatusNyeri
            $statusNyeri = RmeAsesmenKepAnakStatusNyeri::where('id_asesmen', $dataAsesmen->id)->first();
            if (! $statusNyeri) {
                $statusNyeri = new RmeAsesmenKepAnakStatusNyeri;
                $statusNyeri->id_asesmen = $dataAsesmen->id;
            }

            if ($request->filled('jenis_skala_nyeri')) {
                $jenisSkala = [
                    'NRS' => 1,
                    'FLACC' => 2,
                    'CRIES' => 3,
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

            // Update RmeAsesmenKepAnakRiwayatKesehatan
            $riwayatKesehatan = RmeAsesmenKepAnakRiwayatKesehatan::where('id_asesmen', $dataAsesmen->id)->first();
            if (! $riwayatKesehatan) {
                $riwayatKesehatan = new RmeAsesmenKepAnakRiwayatKesehatan;
                $riwayatKesehatan->id_asesmen = $dataAsesmen->id;
            }

            $riwayatKesehatan->penyakit_yang_diderita = $request->penyakit_diderita;
            $riwayatKesehatan->riwayat_imunisasi = $request->riwayat_imunisasi == 'Ya' ? 1 : 0;
            $riwayatKesehatan->jenis_kecelakaan = $request->riwayat_kecelakaan;
            $riwayatKesehatan->riwayat_rawat_inap = $request->riwayat_rawat_inap == 'Ya' ? 1 : 0;
            $riwayatKesehatan->tanggal_riwayat_rawat_inap = $request->tanggal_rawat_inap;
            $riwayatKesehatan->riwayat_operasi = $request->riwayat_operasi;
            $riwayatKesehatan->nama_operasi = $request->jenis_operasi;
            $riwayatKesehatan->riwayat_penyakit_keluarga = $request->riwayat_kesehatan_keluarga;
            $riwayatKesehatan->konsumsi_obat = $request->konsumsi_obat;
            $riwayatKesehatan->tumbuh_kembang = $request->tumbuh_kembang;
            $riwayatKesehatan->penyakit_diderita_lalu = json_encode($request->penyakit_diderita_lalu ?? []);
            $riwayatKesehatan->penyakit_diderita_lainnya = $request->penyakit_diderita_lainnya;
            $riwayatKesehatan->riwayat_kecelakaan_lalu = json_encode($request->riwayat_kecelakaan_lalu ?? []);
            $riwayatKesehatan->jenis_operasi = $request->jenis_operasi;
            $riwayatKesehatan->save();

            // Update RmeAsesmenKepAnakRisikoJatuh
            $asesmenKepAnakRisikoJatuh = RmeAsesmenKepAnakRisikoJatuh::where('id_asesmen', $dataAsesmen->id)->first();
            if (! $asesmenKepAnakRisikoJatuh) {
                $asesmenKepAnakRisikoJatuh = new RmeAsesmenKepAnakRisikoJatuh;
                $asesmenKepAnakRisikoJatuh->id_asesmen = $dataAsesmen->id;
            }

            $asesmenKepAnakRisikoJatuh->resiko_jatuh_jenis = (int) $request->resiko_jatuh_jenis;
            if ($request->has('intervensi_risiko_jatuh_json')) {
                $intervensiRisikoJatuhJson = $request->intervensi_risiko_jatuh_json;
                $asesmenKepAnakRisikoJatuh->intervensi_risiko_jatuh = $intervensiRisikoJatuhJson;
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
            elseif ($request->resiko_jatuh_jenis == 3) {
                $asesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_usia_anak = array_search((int) $request->risiko_jatuh_pediatrik_usia_anak, ['4' => 4, '3' => 3, '2' => 2, '1' => 1]);
                $asesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_jenis_kelamin = array_search($request->risiko_jatuh_pediatrik_jenis_kelamin, ['2' => 2, '1' => 1]);
                $asesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_diagnosis = array_search($request->risiko_jatuh_pediatrik_diagnosis, ['4' => 4, '3' => 3, '2' => 2, '1' => 1]);
                $asesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_gangguan_kognitif = array_search($request->risiko_jatuh_pediatrik_gangguan_kognitif, ['3' => 3, '2' => 2, '1' => 1]);
                $asesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_faktor_lingkungan = array_search($request->risiko_jatuh_pediatrik_faktor_lingkungan, ['4' => 4, '3' => 3, '2' => 2, '1' => 1]);
                $asesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_pembedahan = array_search($request->risiko_jatuh_pediatrik_pembedahan, ['3' => 3, '2' => 2, '1' => 1]);
                $asesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_penggunaan_mentosa = array_search($request->risiko_jatuh_pediatrik_penggunaan_mentosa, ['3' => 3, '2' => 2, '1' => 1]);
                $asesmenKepAnakRisikoJatuh->kesimpulan_skala_pediatrik = $request->risiko_jatuh_pediatrik_kesimpulan;
            }

            // Handle Skala Lansia/Ontario
            elseif ($request->resiko_jatuh_jenis == 4) {
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
            } elseif ($request->resiko_jatuh_jenis == 5) {
                $asesmenKepAnakRisikoJatuh->resiko_jatuh_lainnya = 'resiko jatuh lainnya';
            }
            $asesmenKepAnakRisikoJatuh->save();

            // Update RmeAsesmenKepAnakStatusPsikologis
            $statusPsikologis = RmeAsesmenKepAnakStatusPsikologis::where('id_asesmen', $dataAsesmen->id)->first();
            if (! $statusPsikologis) {
                $statusPsikologis = new RmeAsesmenKepAnakStatusPsikologis;
                $statusPsikologis->id_asesmen = $dataAsesmen->id;
            }

            $statusPsikologis->kondisi_psikologis = $request->kondisi_psikologis_json ?? '[]';
            $statusPsikologis->gangguan_perilaku = $request->gangguan_perilaku_json ?? '[]';
            $statusPsikologis->potensi_menyakiti = $request->potensi_menyakiti;
            $statusPsikologis->keluarga_gangguan_jiwa = $request->anggota_keluarga_gangguan_jiwa;
            $statusPsikologis->lainnya = $request->psikologis_lainnya;
            $statusPsikologis->save();

            // Update RmeAsesmenKepAnakGizi
            $asesmenKepAnakStatusGizi = RmeAsesmenKepAnakGizi::where('id_asesmen', $dataAsesmen->id)->first();
            if (! $asesmenKepAnakStatusGizi) {
                $asesmenKepAnakStatusGizi = new RmeAsesmenKepAnakGizi;
                $asesmenKepAnakStatusGizi->id_asesmen = $dataAsesmen->id;
            }

            $asesmenKepAnakStatusGizi->gizi_jenis = (int) $request->gizi_jenis;

            // Handle MST Form
            if ($request->gizi_jenis == 1) {
                $asesmenKepAnakStatusGizi->gizi_mst_penurunan_bb = $request->gizi_mst_penurunan_bb;
                $asesmenKepAnakStatusGizi->gizi_mst_jumlah_penurunan_bb = $request->gizi_mst_jumlah_penurunan_bb;
                $asesmenKepAnakStatusGizi->gizi_mst_nafsu_makan_berkurang = $request->gizi_mst_nafsu_makan_berkurang;
                $asesmenKepAnakStatusGizi->gizi_mst_diagnosis_khusus = $request->gizi_mst_diagnosis_khusus;
                $asesmenKepAnakStatusGizi->gizi_mst_kesimpulan = $request->gizi_mst_kesimpulan;
            }

            // Handle MNA Form
            elseif ($request->gizi_jenis == 2) {
                $asesmenKepAnakStatusGizi->gizi_mna_penurunan_asupan_3_bulan = (int) $request->gizi_mna_penurunan_asupan_3_bulan;
                $asesmenKepAnakStatusGizi->gizi_mna_kehilangan_bb_3_bulan = (int) $request->gizi_mna_kehilangan_bb_3_bulan;
                $asesmenKepAnakStatusGizi->gizi_mna_mobilisasi = (int) $request->gizi_mna_mobilisasi;
                $asesmenKepAnakStatusGizi->gizi_mna_stress_penyakit_akut = (int) $request->gizi_mna_stress_penyakit_akut;
                $asesmenKepAnakStatusGizi->gizi_mna_status_neuropsikologi = (int) $request->gizi_mna_status_neuropsikologi;
                $asesmenKepAnakStatusGizi->gizi_mna_berat_badan = (int) $request->gizi_mna_berat_badan;
                $asesmenKepAnakStatusGizi->gizi_mna_tinggi_badan = (int) $request->gizi_mna_tinggi_badan;

                // Hitung dan simpan IMT
                $heightInMeters = $request->gizi_mna_tinggi_badan / 100;
                $imt = $request->gizi_mna_berat_badan / ($heightInMeters * $heightInMeters);
                $asesmenKepAnakStatusGizi->gizi_mna_imt = number_format($imt, 2, '.', '');

                $asesmenKepAnakStatusGizi->gizi_mna_kesimpulan = $request->gizi_mna_kesimpulan;
            }

            // Handle Strong Kids Form
            elseif ($request->gizi_jenis == 3) {
                $asesmenKepAnakStatusGizi->gizi_strong_status_kurus = $request->gizi_strong_status_kurus;
                $asesmenKepAnakStatusGizi->gizi_strong_penurunan_bb = $request->gizi_strong_penurunan_bb;
                $asesmenKepAnakStatusGizi->gizi_strong_gangguan_pencernaan = $request->gizi_strong_gangguan_pencernaan;
                $asesmenKepAnakStatusGizi->gizi_strong_penyakit_berisiko = $request->gizi_strong_penyakit_berisiko;
                $asesmenKepAnakStatusGizi->gizi_strong_kesimpulan = $request->gizi_strong_kesimpulan;
            }

            // Handle NRS Form
            elseif ($request->gizi_jenis == 4) {
                $asesmenKepAnakStatusGizi->gizi_nrs_jatuh_saat_masuk_rs = $request->gizi_nrs_jatuh_saat_masuk_rs;
                $asesmenKepAnakStatusGizi->gizi_nrs_jatuh_2_bulan_terakhir = $request->gizi_nrs_jatuh_2_bulan_terakhir;
                $asesmenKepAnakStatusGizi->gizi_nrs_status_delirium = $request->gizi_nrs_status_delirium;
                $asesmenKepAnakStatusGizi->gizi_nrs_status_disorientasi = $request->gizi_nrs_status_disorientasi;
                $asesmenKepAnakStatusGizi->gizi_nrs_status_agitasi = $request->gizi_nrs_status_agitasi;
                $asesmenKepAnakStatusGizi->gizi_nrs_menggunakan_kacamata = $request->gizi_nrs_menggunakan_kacamata;
                $asesmenKepAnakStatusGizi->gizi_nrs_keluhan_penglihatan_buram = $request->gizi_nrs_keluhan_penglihatan_buram;
                $asesmenKepAnakStatusGizi->gizi_nrs_degenerasi_makula = $request->gizi_nrs_degenerasi_makula;
                $asesmenKepAnakStatusGizi->gizi_nrs_perubahan_berkemih = $request->gizi_nrs_perubahan_berkemih;
                $asesmenKepAnakStatusGizi->gizi_nrs_transfer_mandiri = $request->gizi_nrs_transfer_mandiri;
                $asesmenKepAnakStatusGizi->gizi_nrs_transfer_bantuan_1_orang = $request->gizi_nrs_transfer_bantuan_1_orang;
                $asesmenKepAnakStatusGizi->gizi_nrs_transfer_bantuan_2_orang = $request->gizi_nrs_transfer_bantuan_2_orang;
                $asesmenKepAnakStatusGizi->gizi_nrs_transfer_bantuan_total = $request->gizi_nrs_transfer_bantuan_total;
                $asesmenKepAnakStatusGizi->gizi_nrs_mobilitas_mandiri = $request->gizi_nrs_mobilitas_mandiri;
                $asesmenKepAnakStatusGizi->gizi_nrs_mobilitas_bantuan_1_orang = $request->gizi_nrs_mobilitas_bantuan_1_orang;
                $asesmenKepAnakStatusGizi->gizi_nrs_mobilitas_kursi_roda = $request->gizi_nrs_mobilitas_kursi_roda;
                $asesmenKepAnakStatusGizi->gizi_nrs_mobilitas_imobilisasi = $request->gizi_nrs_mobilitas_imobilisasi;
                $asesmenKepAnakStatusGizi->gizi_nrs_kesimpulan = $request->gizi_nrs_kesimpulan;
            } elseif ($request->gizi_jenis == 5) {
                $asesmenKepAnakStatusGizi->status_gizi_tidakada = 'tidak ada status gizi';
            }

            $asesmenKepAnakStatusGizi->save();

            // Update RmeAsesmenKepAnakResikoDekubitus
            $decubitusData = RmeAsesmenKepAnakResikoDekubitus::where('id_asesmen', $dataAsesmen->id)->first();
            if (! $decubitusData) {
                $decubitusData = new RmeAsesmenKepAnakResikoDekubitus;
                $decubitusData->id_asesmen = $dataAsesmen->id;
            }

            $jenisSkala = $request->input('jenis_skala_dekubitus') === 'norton' ? 1 : 2;
            $decubitusData->jenis_skala = $jenisSkala;

            if ($jenisSkala === 1) {
                // Norton
                $decubitusData->norton_kondisi_fisik = $request->input('kondisi_fisik');
                $decubitusData->norton_kondisi_mental = $request->input('kondisi_mental');
                $decubitusData->norton_aktivitas = $request->input('norton_aktivitas');
                $decubitusData->norton_mobilitas = $request->input('norton_mobilitas');
                $decubitusData->norton_inkontenesia = $request->input('inkontinensia');

                $totalScore =
                    (int) $request->input('kondisi_fisik') +
                    (int) $request->input('kondisi_mental') +
                    (int) $request->input('norton_aktivitas') +
                    (int) $request->input('norton_mobilitas') +
                    (int) $request->input('inkontinensia');

                $decubitusData->decubitus_kesimpulan = $this->getRiskConclusion($totalScore);
            } else {
                // Braden
                $decubitusData->braden_persepsi = $request->input('persepsi_sensori');
                $decubitusData->braden_kelembapan = $request->input('kelembapan');
                $decubitusData->braden_aktivitas = $request->input('braden_aktivitas');
                $decubitusData->braden_mobilitas = $request->input('braden_mobilitas');
                $decubitusData->braden_nutrisi = $request->input('nutrisi');
                $decubitusData->braden_pergesekan = $request->input('pergesekan');

                $totalScore =
                    (int) $request->input('persepsi_sensori') +
                    (int) $request->input('kelembapan') +
                    (int) $request->input('braden_aktivitas') +
                    (int) $request->input('braden_mobilitas') +
                    (int) $request->input('nutrisi') +
                    (int) $request->input('pergesekan');

                $decubitusData->decubitus_kesimpulan = $this->getRiskConclusion($totalScore);
            }
            $decubitusData->save();

            // Update RmeAsesmenKepAnakStatusFungsional
            $statusFungsional = RmeAsesmenKepAnakStatusFungsional::where('id_asesmen', $dataAsesmen->id)->first();
            if ($request->filled('skala_fungsional')) {
                if (! $statusFungsional) {
                    $statusFungsional = new RmeAsesmenKepAnakStatusFungsional;
                    $statusFungsional->id_asesmen = $dataAsesmen->id;
                }

                if ($request->filled('skala_fungsional')) {
                    if ($request->skala_fungsional === 'Pengkajian Aktivitas') {
                        $statusFungsional->jenis_skala = 1;
                    } elseif ($request->skala_fungsional === 'Lainnya') {
                        $statusFungsional->jenis_skala = 2;
                    }
                } else {
                    $statusFungsional->jenis_skala = 0;
                }

                // Simpan data ADL
                $statusFungsional->makan = $request->adl_makan;
                $statusFungsional->berjalan = $request->adl_berjalan;
                $statusFungsional->mandi = $request->adl_mandi;
                $statusFungsional->jumlah_skala = $request->filled('adl_total') ? (int) $request->adl_total : null;
                $statusFungsional->kesimpulan = $request->adl_kesimpulan_value;
                $statusFungsional->nilai_skala_adl = $request->filled('adl_total') ? (int) $request->adl_total : null;
                $statusFungsional->kesimpulan_fungsional = $request->adl_kesimpulan_value;
                $statusFungsional->save();
            }

            // Update RmeAsesmenKepAnakRencanaPulang
            $asesmenRencana = RmeAsesmenKepAnakRencanaPulang::where('id_asesmen', $dataAsesmen->id)->first();
            if (! $asesmenRencana) {
                $asesmenRencana = new RmeAsesmenKepAnakRencanaPulang;
                $asesmenRencana->id_asesmen = $dataAsesmen->id;
            }

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

            $dataAsesmen->rmeAsesmenKepAnakKeperawatan()->updateOrCreate(
                ['id_asesmen' => $dataAsesmen->id],
                [
                    'tanggal' => $request->tanggal ?? date('Y-m-d'),
                    'jam' => $request->jam ?? date('H:i:s'),
                    'diagnosis' => $request->diagnosis ?? [],
                    'rencana_bersihan_jalan_nafas' => $request->rencana_bersihan_jalan_nafas ?? [],
                    'rencana_penurunan_curah_jantung' => $request->rencana_penurunan_curah_jantung ?? [],
                    'rencana_perfusi_perifer' => $request->rencana_perfusi_perifer ?? [],
                    'rencana_hipovolemia' => $request->rencana_hipovolemia ?? [],
                    'rencana_hipervolemia' => $request->rencana_hipervolemia ?? [],
                    'rencana_diare' => $request->rencana_diare ?? [],
                    'rencana_retensi_urine' => $request->rencana_retensi_urine ?? [],
                    'rencana_nyeri_akut' => $request->rencana_nyeri_akut ?? [],
                    'rencana_nyeri_kronis' => $request->rencana_nyeri_kronis ?? [],
                    'rencana_hipertermia' => $request->rencana_hipertermia ?? [],
                    'rencana_gangguan_mobilitas_fisik' => $request->rencana_gangguan_mobilitas_fisik ?? [],
                    'rencana_resiko_infeksi' => $request->rencana_resiko_infeksi ?? [],
                    'rencana_konstipasi' => $request->rencana_konstipasi ?? [],
                    'rencana_resiko_jatuh' => $request->rencana_resiko_jatuh ?? [],
                    'rencana_gangguan_integritas_kulit' => $request->rencana_gangguan_integritas_kulit ?? [],
                ]
            );

            // RESUME
            $resumeData = [
                'anamnesis' => $request->anamnesis,
                'diagnosis' => [],
                'tindak_lanjut_code' => null,
                'tindak_lanjut_name' => null,
                'tgl_kontrol_ulang' => null,
                'unit_rujuk_internal' => null,
                'rs_rujuk' => null,
                'rs_rujuk_bagian' => null,
                'konpas' => [
                    'sistole' => [
                        'hasil' => $request->sistole,
                    ],
                    'distole' => [
                        'hasil' => $request->diastole,
                    ],
                    'respiration_rate' => [
                        'hasil' => '',
                    ],
                    'suhu' => [
                        'hasil' => $request->suhu,
                    ],
                    'nadi' => [
                        'hasil' => $request->nadi,
                    ],
                    'tinggi_badan' => [
                        'hasil' => $request->tinggi_badan,
                    ],
                    'berat_badan' => [
                        'hasil' => $request->berat_badan,
                    ],
                ],
            ];

            // Panggil ResumeService
            $resume = $this->checkResumeService->checkAndCreateResume([
                'kd_pasien' => $kd_pasien,
                'kd_unit' => $kd_unit,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk
            ]);

            DB::commit();

            return to_route('rawat-inap.asesmen.medis.umum.index', [
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
            ])
                ->with('success', 'Data asesmen anak berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Terjadi kesalahan: '.$e->getMessage());
        }
    }

    private function getRiskConclusion($score)
    {
        if ($score <= 12) {
            return 'Risiko Tinggi';
        } elseif ($score <= 14) {
            return 'Risiko Sedang';
        }
        return 'Risiko Rendah';
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
            'tindak_lanjut_code' => $data['tindak_lanjut_code'],
            'tindak_lanjut_name' => $data['tindak_lanjut_name'],
            'tgl_kontrol_ulang' => $data['tgl_kontrol_ulang'],
            'unit_rujuk_internal' => $data['unit_rujuk_internal'],
            'rs_rujuk' => $data['rs_rujuk'],
            'rs_rujuk_bagian' => $data['rs_rujuk_bagian'],
        ];

        if (empty($resume)) {
            $resumeData = [
                'kd_pasien' => $kd_pasien,
                'kd_unit' => $kd_unit,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
                'anamnesis' => $data['anamnesis'],
                'konpas' => $data['konpas'],
                'diagnosis' => $data['diagnosis'],
                'status' => 0,
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
                $resumeDtl->tindak_lanjut_code = $data['tindak_lanjut_code'];
                $resumeDtl->tindak_lanjut_name = $data['tindak_lanjut_name'];
                $resumeDtl->tgl_kontrol_ulang = $data['tgl_kontrol_ulang'];
                $resumeDtl->unit_rujuk_internal = $data['unit_rujuk_internal'];
                $resumeDtl->rs_rujuk = $data['rs_rujuk'];
                $resumeDtl->rs_rujuk_bagian = $data['rs_rujuk_bagian'];
                $resumeDtl->save();
            }
        }
    }
}
