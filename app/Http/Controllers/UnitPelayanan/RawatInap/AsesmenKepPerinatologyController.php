<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\MrItemFisik;
use App\Models\RmeAlergiPasien;
use App\Models\RmeAsesmen;
use App\Models\RmeAsesmenKepPerinatology;
use App\Models\RmeAsesmenKepPerinatologyFisik;
use App\Models\RmeAsesmenKepPerinatologyStatusFungsional;
use App\Models\RmeAsesmenKepPerinatologyGizi;
use App\Models\RmeAsesmenKepPerinatologyKeperawatan;
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
use App\Services\AsesmenService;
use App\Services\BaseService;
use Illuminate\Support\Facades\Storage;
use App\Services\CheckResumeService;
use Exception;

class AsesmenKepPerinatologyController extends Controller
{
    protected $asesmenService;
    protected $checkResumeService;
    private $baseService;

    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
        $this->asesmenService = new AsesmenService();
        $this->checkResumeService = new CheckResumeService();
        $this->baseService = new BaseService();
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
        // Get latest vital signs data for the patient
        $vitalSignsData = $this->asesmenService->getLatestVitalSignsByPatient($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

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

            $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
            if (empty($dataMedis)) throw new Exception('Data kunjungan tidak ditemukan !');

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
            $dataAsesmen->save();

            // Validasi file yang diunggah
            $request->validate([
                'sidik_kaki_kiri' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
                'sidik_kaki_kanan' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
                'sidik_jari_ibu_kiri' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
                'sidik_jari_ibu_kanan' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
                'sidik_jari_bayi_kiri' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
                'sidik_jari_bayi_kanan' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            ]);

            // === SIMPAN KE RmeAsesmenKepPerinatology ===
            $tglLahir = $request->tanggal_lahir;
            $jamLahir = $request->jam_lahir;
            $waktuLahir = $tglLahir . ' ' . $jamLahir;

            $asesmenPerinatology = new RmeAsesmenKepPerinatology();
            $asesmenPerinatology->id_asesmen = $dataAsesmen->id;
            $asesmenPerinatology->data_masuk = $waktu_asesmen;
            $asesmenPerinatology->agama_orang_tua = $request->agama_orang_tua;
            $asesmenPerinatology->tgl_lahir_bayi = $waktuLahir;
            $asesmenPerinatology->nama_bayi = $request->nama_bayi;
            $asesmenPerinatology->jenis_kelamin = $request->jenis_kelamin;
            $asesmenPerinatology->nama_ibu = $request->nama_ibu;
            $asesmenPerinatology->nik_ibu = $request->nik_ibu;

            // Upload files dengan nama variabel yang benar
            $pathSidikKakiKiri = $request->hasFile('sidik_kaki_kiri')
                ? $request->file('sidik_kaki_kiri')->store("uploads/ranap/asesmen-perinatology/$kd_unit/$kd_pasien/$tgl_masuk/$urut_masuk")
                : null;

            $pathSidikKakiKanan = $request->hasFile('sidik_kaki_kanan')
                ? $request->file('sidik_kaki_kanan')->store("uploads/ranap/asesmen-perinatology/$kd_unit/$kd_pasien/$tgl_masuk/$urut_masuk")
                : null;

            $pathSidikJariIbuKiri = $request->hasFile('sidik_jari_ibu_kiri')
                ? $request->file('sidik_jari_ibu_kiri')->store("uploads/ranap/asesmen-perinatology/$kd_unit/$kd_pasien/$tgl_masuk/$urut_masuk")
                : null;

            $pathSidikJariIbuKanan = $request->hasFile('sidik_jari_ibu_kanan')
                ? $request->file('sidik_jari_ibu_kanan')->store("uploads/ranap/asesmen-perinatology/$kd_unit/$kd_pasien/$tgl_masuk/$urut_masuk")
                : null;

            $pathSidikJariBayiKiri = $request->hasFile('sidik_jari_bayi_kiri')
                ? $request->file('sidik_jari_bayi_kiri')->store("uploads/ranap/asesmen-perinatology/$kd_unit/$kd_pasien/$tgl_masuk/$urut_masuk")
                : null;

            $pathSidikJariBayiKanan = $request->hasFile('sidik_jari_bayi_kanan')
                ? $request->file('sidik_jari_bayi_kanan')->store("uploads/ranap/asesmen-perinatology/$kd_unit/$kd_pasien/$tgl_masuk/$urut_masuk")
                : null;

            // Assign semua path ke model (ini sudah benar)
            $asesmenPerinatology->sidik_telapak_kaki_kiri = $pathSidikKakiKiri;
            $asesmenPerinatology->sidik_telapak_kaki_kanan = $pathSidikKakiKanan;
            $asesmenPerinatology->sidik_jari_ibu_kiri = $pathSidikJariIbuKiri;
            $asesmenPerinatology->sidik_jari_ibu_kanan = $pathSidikJariIbuKanan;
            $asesmenPerinatology->sidik_jari_bayi_kiri = $pathSidikJariBayiKiri;
            $asesmenPerinatology->sidik_jari_bayi_kanan = $pathSidikJariBayiKanan;

            // === TAMBAHAN: Field yang mungkin terlewat ===
            $asesmenPerinatology->gaya_bicara = $request->gaya_bicara;
            $asesmenPerinatology->bahasa = $request->bahasa_sehari_hari;
            $asesmenPerinatology->perlu_penerjemahan = $request->perlu_penerjemah;
            $asesmenPerinatology->hambatan_komunikasi = $request->hambatan_komunikasi;
            $asesmenPerinatology->media_disukai = $request->media_disukai;
            $asesmenPerinatology->tingkat_pendidikan = $request->tingkat_pendidikan;

            // Masalah diagnosis dan intervensi rencana
            if ($request->has('masalah_diagnosis') && is_array($request->masalah_diagnosis)) {
                $masalahDiagnosis = array_filter($request->masalah_diagnosis, function ($value) {
                    return !empty(trim($value));
                });
                $asesmenPerinatology->masalah_diagnosis = json_encode(array_values($masalahDiagnosis));
            }

            if ($request->has('intervensi_rencana') && is_array($request->intervensi_rencana)) {
                $intervensiRencana = array_filter($request->intervensi_rencana, function ($value) {
                    return !empty(trim($value));
                });
                $asesmenPerinatology->intervensi_rencana = json_encode(array_values($intervensiRencana));
            }

            $asesmenPerinatology->save();

            // === SIMPAN KE RmeAsesmenKepPerinatologyFisik ===
            $perinatologyFisik = new RmeAsesmenKepPerinatologyFisik();
            $perinatologyFisik->id_asesmen = $dataAsesmen->id;
            $perinatologyFisik->jenis_kelamin = $request->jenis_kelamin;
            $perinatologyFisik->frekuensi_nadi = $request->frekuensi_nadi ? (int)$request->frekuensi_nadi : null;
            $perinatologyFisik->status_frekuensi = $request->status_frekuensi;
            $perinatologyFisik->nafas = $request->nafas ? (int)$request->nafas : null;
            $perinatologyFisik->suhu = $request->suhu ? (float)$request->suhu : null;
            $perinatologyFisik->spo2_tanpa_bantuan = $request->spo2_tanpa_bantuan ? (int)$request->spo2_tanpa_bantuan : null;
            $perinatologyFisik->spo2_dengan_bantuan = $request->spo2_dengan_bantuan ? (int)$request->spo2_dengan_bantuan : null;
            $perinatologyFisik->tinggi_badan = $request->tinggi_badan ? (int)$request->tinggi_badan : null;
            $perinatologyFisik->berat_badan = $request->berat_badan ? (int)$request->berat_badan : null;
            $perinatologyFisik->lingkar_kepala = $request->lingkar_kepala ? (int)$request->lingkar_kepala : null;
            $perinatologyFisik->lingkar_dada = $request->lingkar_dada;
            $perinatologyFisik->lingkar_perut = $request->lingkar_perut;
            $perinatologyFisik->kesadaran = $request->kesadaran;
            $perinatologyFisik->avpu = $request->avpu;
            $perinatologyFisik->save();

            // === SIMPAN KE RmeAsesmenKepPerinatologyPemeriksaanLanjut ===
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

            // === SIMPAN KE RmePemeriksaanFisik ===
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

            // === SIMPAN DATA ALERGI ===
            $alergiData = json_decode($request->alergis, true);
            if (!empty($alergiData)) {
                RmeAlergiPasien::where('kd_pasien', $kd_pasien)->delete();
                foreach ($alergiData as $alergi) {
                    RmeAlergiPasien::create([
                        'kd_pasien' => $kd_pasien,
                        'jenis_alergi' => $alergi['jenis_alergi'],
                        'nama_alergi' => $alergi['alergen'],
                        'reaksi' => $alergi['reaksi'],
                        'tingkat_keparahan' => $alergi['tingkat_keparahan']
                    ]);
                }
            }

            // === SIMPAN KE RmeAsesmenKepPerinatologyRiwayatIbu ===
            $riwayatIbu = new RmeAsesmenKepPerinatologyRiwayatIbu();
            $riwayatIbu->id_asesmen = $dataAsesmen->id;
            $riwayatIbu->pemeriksaan_kehamilan = $request->pemeriksaan_kehamilan;
            $riwayatIbu->tempat_pemeriksaan = $request->tempat_pemeriksaan;
            $riwayatIbu->usia_kehamilan = $request->usia_kehamilan;
            $riwayatIbu->cara_persalinan = $request->cara_persalinan;

            $riwayatJson = $request->input('riwayat_penyakit_pengobatan');
            if ($riwayatJson) {
                json_decode($riwayatJson);
                $riwayatIbu->riwayat_penyakit_pengobatan = (json_last_error() === JSON_ERROR_NONE) ? $riwayatJson : json_encode([]);
            } else {
                $riwayatIbu->riwayat_penyakit_pengobatan = json_encode([]);
            }
            $riwayatIbu->save();

            // === SIMPAN KE RmeAsesmenKepPerinatologyStatusNyeri ===
            $statusNyeri = new RmeAsesmenKepPerinatologyStatusNyeri();
            $statusNyeri->id_asesmen = $dataAsesmen->id;

            if ($request->filled('jenis_skala_nyeri')) {
                $jenisSkala = ['NRS' => 1, 'FLACC' => 2, 'CRIES' => 3];
                $statusNyeri->jenis_skala_nyeri = $jenisSkala[$request->jenis_skala_nyeri];
                $statusNyeri->nilai_nyeri = $request->nilai_skala_nyeri;
                $statusNyeri->kesimpulan_nyeri = $request->kesimpulan_nyeri;

                if ($request->jenis_skala_nyeri === 'FLACC') {
                    $statusNyeri->flacc_wajah = $request->wajah ? json_encode($request->wajah) : null;
                    $statusNyeri->flacc_kaki = $request->kaki ? json_encode($request->kaki) : null;
                    $statusNyeri->flacc_aktivitas = $request->aktivitas ? json_encode($request->aktivitas) : null;
                    $statusNyeri->flacc_menangis = $request->menangis ? json_encode($request->menangis) : null;
                    $statusNyeri->flacc_konsolabilitas = $request->konsolabilitas ? json_encode($request->konsolabilitas) : null;
                    $statusNyeri->flacc_jumlah_skala = $request->flaccTotal;
                }

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

            // === SIMPAN KE RmeAsesmenKepPerinatologyRisikoJatuh ===
            $risikoJatuh = new RmeAsesmenKepPerinatologyRisikoJatuh();
            $risikoJatuh->id_asesmen = $dataAsesmen->id;

            if ($request->filled('resiko_jatuh_jenis')) {
                $risikoJatuh->resiko_jatuh_jenis = (int)$request->resiko_jatuh_jenis;
                $risikoJatuh->intervensi_risiko_jatuh = $request->has('intervensi_risiko_jatuh_json')
                    ? $request->intervensi_risiko_jatuh_json
                    : '[]';

                // Skala Umum
                if ($request->resiko_jatuh_jenis == 1) {
                    $risikoJatuh->risiko_jatuh_umum_usia = $request->risiko_jatuh_umum_usia ? 1 : 0;
                    $risikoJatuh->risiko_jatuh_umum_kondisi_khusus = $request->risiko_jatuh_umum_kondisi_khusus ? 1 : 0;
                    $risikoJatuh->risiko_jatuh_umum_diagnosis_parkinson = $request->risiko_jatuh_umum_diagnosis_parkinson ? 1 : 0;
                    $risikoJatuh->risiko_jatuh_umum_pengobatan_berisiko = $request->risiko_jatuh_umum_pengobatan_berisiko ? 1 : 0;
                    $risikoJatuh->risiko_jatuh_umum_lokasi_berisiko = $request->risiko_jatuh_umum_lokasi_berisiko ? 1 : 0;
                    $risikoJatuh->kesimpulan_skala_umum = $request->input('risiko_jatuh_umum_kesimpulan', 'Tidak berisiko jatuh');
                }

                // Skala Morse
                if ($request->resiko_jatuh_jenis == 2) {
                    $risikoJatuh->risiko_jatuh_morse_riwayat_jatuh = array_search($request->risiko_jatuh_morse_riwayat_jatuh, ['25' => 25, '0' => 0]);
                    $risikoJatuh->risiko_jatuh_morse_diagnosis_sekunder = array_search($request->risiko_jatuh_morse_diagnosis_sekunder, ['15' => 15, '0' => 0]);
                    $risikoJatuh->risiko_jatuh_morse_bantuan_ambulasi = array_search($request->risiko_jatuh_morse_bantuan_ambulasi, ['30' => 30, '15' => 15, '0' => 0]);
                    $risikoJatuh->risiko_jatuh_morse_terpasang_infus = array_search($request->risiko_jatuh_morse_terpasang_infus, ['20' => 20, '0' => 0]);
                    $risikoJatuh->risiko_jatuh_morse_cara_berjalan = array_search($request->risiko_jatuh_morse_cara_berjalan, ['0' => 0, '20' => 20, '10' => 10]);
                    $risikoJatuh->risiko_jatuh_morse_status_mental = array_search($request->risiko_jatuh_morse_status_mental, ['0' => 0, '15' => 15]);
                    $risikoJatuh->kesimpulan_skala_morse = $request->risiko_jatuh_morse_kesimpulan;
                }

                // Skala Pediatrik
                if ($request->resiko_jatuh_jenis == 3) {
                    $risikoJatuh->risiko_jatuh_pediatrik_usia_anak = array_search((int)$request->risiko_jatuh_pediatrik_usia_anak, ['4' => 4, '3' => 3, '2' => 2, '1' => 1]);
                    $risikoJatuh->risiko_jatuh_pediatrik_jenis_kelamin = array_search($request->risiko_jatuh_pediatrik_jenis_kelamin, ['2' => 2, '1' => 1]);
                    $risikoJatuh->risiko_jatuh_pediatrik_diagnosis = array_search($request->risiko_jatuh_pediatrik_diagnosis, ['4' => 4, '3' => 3, '2' => 2, '1' => 1]);
                    $risikoJatuh->risiko_jatuh_pediatrik_gangguan_kognitif = array_search($request->risiko_jatuh_pediatrik_gangguan_kognitif, ['3' => 3, '2' => 2, '1' => 1]);
                    $risikoJatuh->risiko_jatuh_pediatrik_faktor_lingkungan = array_search($request->risiko_jatuh_pediatrik_faktor_lingkungan, ['4' => 4, '3' => 3, '2' => 2, '1' => 1]);
                    $risikoJatuh->risiko_jatuh_pediatrik_pembedahan = array_search($request->risiko_jatuh_pediatrik_pembedahan, ['3' => 3, '2' => 2, '1' => 1]);
                    $risikoJatuh->risiko_jatuh_pediatrik_penggunaan_mentosa = array_search($request->risiko_jatuh_pediatrik_penggunaan_mentosa, ['3' => 3, '2' => 2, '1' => 1]);
                    $risikoJatuh->kesimpulan_skala_pediatrik = $request->risiko_jatuh_pediatrik_kesimpulan;
                }

                // Skala Lansia
                if ($request->resiko_jatuh_jenis == 4) {
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
                    $risikoJatuh->risiko_jatuh_lansia_transfer_bantuan_total = array_search($request->risiko_jatuh_lansia_transfer_bantuan_total, ['3' => 3, '0' => 0]);
                    $risikoJatuh->risiko_jatuh_lansia_mobilitas_mandiri = $request->risiko_jatuh_lansia_mobilitas_mandiri;
                    $risikoJatuh->risiko_jatuh_lansia_mobilitas_bantuan_1_orang = $request->risiko_jatuh_lansia_mobilitas_bantuan_1_orang;
                    $risikoJatuh->risiko_jatuh_lansia_mobilitas_kursi_roda = array_search($request->risiko_jatuh_lansia_mobilitas_kursi_roda, ['2' => 2, '0' => 0]);
                    $risikoJatuh->risiko_jatuh_lansia_mobilitas_imobilisasi = array_search($request->risiko_jatuh_lansia_mobilitas_imobilisasi, ['3' => 3, '0' => 0]);
                    $risikoJatuh->kesimpulan_skala_lansia = $request->risiko_jatuh_lansia_kesimpulan;
                }
            }
            $risikoJatuh->save();

            // === SIMPAN KE RmeAsesmenKepPerinatologyResikoDekubitus ===
            if ($request->filled('jenis_skala_dekubitus')) {
                $resikoDekubitus = new RmeAsesmenKepPerinatologyResikoDekubitus();
                $resikoDekubitus->id_asesmen = $dataAsesmen->id;

                if ($request->jenis_skala_dekubitus === 'norton') {
                    $resikoDekubitus->jenis_skala = 1;
                    $resikoDekubitus->norton_kondisi_fisik = $request->kondisi_fisik;
                    $resikoDekubitus->norton_kondisi_mental = $request->kondisi_mental;
                    $resikoDekubitus->norton_aktivitas = $request->norton_aktivitas;
                    $resikoDekubitus->norton_mobilitas = $request->norton_mobilitas;
                    $resikoDekubitus->norton_inkontenesia = $request->inkontinensia;

                    // Hitung total dan kesimpulan Norton
                    $totalNorton = (int)$request->kondisi_fisik + (int)$request->kondisi_mental +
                        (int)$request->norton_aktivitas + (int)$request->norton_mobilitas +
                        (int)$request->inkontinensia;

                    if ($totalNorton <= 14) {
                        $resikoDekubitus->decubitus_kesimpulan = 'Risiko Tinggi';
                    } elseif ($totalNorton <= 18) {
                        $resikoDekubitus->decubitus_kesimpulan = 'Risiko Sedang';
                    } else {
                        $resikoDekubitus->decubitus_kesimpulan = 'Risiko Rendah';
                    }
                }

                if ($request->jenis_skala_dekubitus === 'braden') {
                    $resikoDekubitus->jenis_skala = 2;
                    $resikoDekubitus->braden_persepsi = $request->persepsi_sensori;
                    $resikoDekubitus->braden_kelembapan = $request->kelembapan;
                    $resikoDekubitus->braden_aktivitas = $request->braden_aktivitas;
                    $resikoDekubitus->braden_mobilitas = $request->braden_mobilitas;
                    $resikoDekubitus->braden_nutrisi = $request->nutrisi;
                    $resikoDekubitus->braden_pergesekan = $request->pergesekan;

                    // Hitung total dan kesimpulan Braden
                    $totalBraden = (int)$request->persepsi_sensori + (int)$request->kelembapan +
                        (int)$request->braden_aktivitas + (int)$request->braden_mobilitas +
                        (int)$request->nutrisi + (int)$request->pergesekan;

                    if ($totalBraden <= 12) {
                        $resikoDekubitus->decubitus_kesimpulan = 'Risiko Tinggi';
                    } elseif ($totalBraden <= 14) {
                        $resikoDekubitus->decubitus_kesimpulan = 'Risiko Sedang';
                    } else {
                        $resikoDekubitus->decubitus_kesimpulan = 'Risiko Rendah';
                    }
                }

                $resikoDekubitus->save();
            }

            // === SIMPAN KE RmeAsesmenKepPerinatologyGizi ===
            if ($request->filled('gizi_jenis')) {
                $gizi = new RmeAsesmenKepPerinatologyGizi();
                $gizi->id_asesmen = $dataAsesmen->id;
                $gizi->gizi_jenis = (int)$request->gizi_jenis;

                // MST
                if ($request->gizi_jenis == 1) {
                    $gizi->gizi_mst_penurunan_bb = $request->gizi_mst_penurunan_bb;
                    $gizi->gizi_mst_jumlah_penurunan_bb = $request->gizi_mst_jumlah_penurunan_bb;
                    $gizi->gizi_mst_nafsu_makan_berkurang = $request->gizi_mst_nafsu_makan_berkurang;
                    $gizi->gizi_mst_diagnosis_khusus = $request->gizi_mst_diagnosis_khusus;
                    $gizi->gizi_mst_kesimpulan = $request->gizi_mst_kesimpulan;
                }

                // MNA
                if ($request->gizi_jenis == 2) {
                    $gizi->gizi_mna_penurunan_asupan_3_bulan = $request->gizi_mna_penurunan_asupan_3_bulan;
                    $gizi->gizi_mna_kehilangan_bb_3_bulan = $request->gizi_mna_kehilangan_bb_3_bulan;
                    $gizi->gizi_mna_mobilisasi = $request->gizi_mna_mobilisasi;
                    $gizi->gizi_mna_stress_penyakit_akut = $request->gizi_mna_stress_penyakit_akut;
                    $gizi->gizi_mna_status_neuropsikologi = $request->gizi_mna_status_neuropsikologi;
                    $gizi->gizi_mna_berat_badan = $request->gizi_mna_berat_badan;
                    $gizi->gizi_mna_tinggi_badan = $request->gizi_mna_tinggi_badan;
                    $gizi->gizi_mna_imt = $request->gizi_mna_imt;
                    $gizi->gizi_mna_kesimpulan = $request->gizi_mna_kesimpulan;
                }

                // Strong Kids
                if ($request->gizi_jenis == 3) {
                    $gizi->gizi_strong_status_kurus = $request->gizi_strong_status_kurus;
                    $gizi->gizi_strong_penurunan_bb = $request->gizi_strong_penurunan_bb;
                    $gizi->gizi_strong_gangguan_pencernaan = $request->gizi_strong_gangguan_pencernaan;
                    $gizi->gizi_strong_penyakit_berisiko = $request->gizi_strong_penyakit_berisiko;
                    $gizi->gizi_strong_kesimpulan = $request->gizi_strong_kesimpulan;
                }

                // NRS (jika ada)
                if ($request->gizi_jenis == 4) {
                    $gizi->gizi_nrs_jatuh_saat_masuk_rs = $request->gizi_nrs_jatuh_saat_masuk_rs ?? null;
                    $gizi->gizi_nrs_kesimpulan = $request->gizi_nrs_kesimpulan ?? null;
                }

                // Tidak dapat dinilai
                if ($request->gizi_jenis == 5) {
                    $gizi->status_gizi_tidakdapat = 'Tidak dapat dinilai';
                }

                $gizi->save();
            }

            // === SIMPAN KE RmeAsesmenKepPerinatologyFungsional ===
            if ($request->filled('skala_fungsional')) {
                $fungsional = new RmeAsesmenKepPerinatologyStatusFungsional();
                $fungsional->id_asesmen = $dataAsesmen->id;

                // Jenis skala (1: Pengkajian Aktivitas, 2: Lainnya)
                $fungsional->jenis_skala = (int)$request->skala_fungsional;

                // Data dari modal ADL
                $fungsional->makan = $request->adl_makan ?? '';
                $fungsional->berjalan = $request->adl_berjalan ?? '';
                $fungsional->mandi = $request->adl_mandi ?? '';

                // Total skala dan kesimpulan
                $fungsional->jumlah_skala = $request->adl_total ? (int)$request->adl_total : 0;
                $fungsional->nilai_skala_adl = $request->adl_total ?? '';
                $fungsional->kesimpulan = $request->adl_kesimpulan_value ?? '';
                $fungsional->kesimpulan_fungsional = $request->adl_kesimpulan_value ?? '';

                $fungsional->save();
            }

            // === SIMPAN KE RmeAsesmenKepPerinatologyRencanaPulang ===
            $rencanaPulang = new RmeAsesmenKepPerinatologyRencanaPulang();
            $rencanaPulang->id_asesmen = $dataAsesmen->id;

            // Field yang optional (bisa null)
            $rencanaPulang->diagnosis_medis = $request->diagnosis_medis ?? null;
            $rencanaPulang->perkiraan_lama_dirawat = $request->perkiraan_hari ?? null;
            $rencanaPulang->rencana_pulang = $request->tanggal_pulang ?? null;

            // Field tinyint (0: Tidak, 1: Ya) - berikan default
            $rencanaPulang->usia_lanjut = $request->usia_lanjut ?? 1; // default: Tidak
            $rencanaPulang->hambatan_mobilisasi = $request->hambatan_mobilisasi ?? 1; // default: Tidak

            // Field varchar (ya/tidak) - berikan default
            $rencanaPulang->membutuhkan_pelayanan_medis = $request->penggunaan_media_berkelanjutan ?? 'tidak';
            $rencanaPulang->memerlukan_keterampilan_khusus = $request->keterampilan_khusus ?? 'tidak';
            $rencanaPulang->memerlukan_alat_bantu = $request->alat_bantu ?? 'tidak';
            $rencanaPulang->memiliki_nyeri_kronis = $request->nyeri_kronis ?? 'tidak';

            // Kesimpulan
            $rencanaPulang->kesimpulan = $request->kesimpulan_planing ?? 'Tidak membutuhkan rencana pulang khusus';

            $rencanaPulang->save();

            // === SIMPAN KE RmeAsesmenKepPerinatologyKeperawatan ===
            $keperawatan = new RmeAsesmenKepPerinatologyKeperawatan();
            $keperawatan->id_asesmen = $dataAsesmen->id;
            $keperawatan->tanggal = $request->tanggal ?? date('Y-m-d');
            $keperawatan->jam = $request->jam ?? date('H:i:s');
            $keperawatan->diagnosis = $request->diagnosis ?? [];
            $keperawatan->rencana_bersihan_jalan_nafas = $request->rencana_bersihan_jalan_nafas ?? [];
            $keperawatan->rencana_penurunan_curah_jantung = $request->rencana_penurunan_curah_jantung ?? [];
            $keperawatan->rencana_perfusi_perifer = $request->rencana_perfusi_perifer ?? [];
            $keperawatan->rencana_hipovolemia = $request->rencana_hipovolemia ?? [];
            $keperawatan->rencana_hipervolemia = $request->rencana_hipervolemia ?? [];
            $keperawatan->rencana_diare = $request->rencana_diare ?? [];
            $keperawatan->rencana_retensi_urine = $request->rencana_retensi_urine ?? [];
            $keperawatan->rencana_nyeri_akut = $request->rencana_nyeri_akut ?? [];
            $keperawatan->rencana_nyeri_kronis = $request->rencana_nyeri_kronis ?? [];
            $keperawatan->rencana_hipertermia = $request->rencana_hipertermia ?? [];
            $keperawatan->rencana_gangguan_mobilitas_fisik = $request->rencana_gangguan_mobilitas_fisik ?? [];
            $keperawatan->rencana_resiko_infeksi = $request->rencana_resiko_infeksi ?? [];
            $keperawatan->rencana_konstipasi = $request->rencana_konstipasi ?? [];
            $keperawatan->rencana_resiko_jatuh = $request->rencana_resiko_jatuh ?? [];
            $keperawatan->rencana_gangguan_integritas_kulit = $request->rencana_gangguan_integritas_kulit ?? [];
            $keperawatan->save();

            // === SIMPAN RESUME ===
            // Data vital sign untuk disimpan via service
            $vitalSignData = [
                'nadi' => $request->frekuensi_nadi ? (int) $request->frekuensi_nadi : null,
                'respiration' => $request->nafas ? (int) $request->nafas : null,
                'suhu' => $request->suhu ? (float) $request->suhu : null,
                'spo2_tanpa_o2' => $request->spo2_tanpa_bantuan ? (int) $request->spo2_tanpa_bantuan : null,
                'spo2_dengan_o2' => $request->spo2_dengan_bantuan ? (int) $request->spo2_dengan_bantuan : null,
                'tinggi_badan' => $request->tinggi_badan ? (int) $request->tinggi_badan : null,
                'berat_badan' => $request->berat_badan ? (int) $request->berat_badan : null,
            ];

            $this->asesmenService->store($vitalSignData, $kd_pasien, $dataMedis->no_transaksi, $dataMedis->kd_kasir);

            // create resume
            $resumeData = [
                'anamnesis'             => $request->anamnesis,

                'konpas'                =>
                [
                    'respiration_rate'   => [
                        'hasil' => $vitalSignData['respiration'] ?? null
                    ],
                    'suhu'   => [
                        'hasil' => $vitalSignData['suhu'] ?? null
                    ],
                    'nadi'   => [
                        'hasil' => $vitalSignData['nadi'] ?? null
                    ],
                    'tinggi_badan'   => [
                        'hasil' => $vitalSignData['tinggi_badan'] ?? null
                    ],
                    'berat_badan'   => [
                        'hasil' => $vitalSignData['berat_badan'] ?? null
                    ]
                ]
            ];

            $this->baseService->updateResumeMedis($dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $resumeData);

            DB::commit();

            return to_route('rawat-inap.asesmen.medis.umum.index', [
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
            ])->with('success', 'Data asesmen perinatology berhasil disimpan');
        } catch (Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
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
                'rmeAsesmenPerinatologyStatusFungsional',
                'rmeAsesmenPerinatologyRencanaPulang',
                'rmeAsesmenKepPerinatologyKeperawatan'
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
        } catch (Exception $e) {
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
                'rmeAsesmenPerinatologyStatusFungsional',
                'rmeAsesmenPerinatologyRencanaPulang',
                'rmeAsesmenKepPerinatologyKeperawatan'
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

            if ($asesmen->rmeAsesmenPerinatology) {
                // Parse masalah diagnosis
                $masalahDiagnosis = [];
                if ($asesmen->rmeAsesmenPerinatology->masalah_diagnosis) {
                    $masalahDiagnosis = json_decode($asesmen->rmeAsesmenPerinatology->masalah_diagnosis, true) ?? [];
                }
                $asesmen->masalah_diagnosis_parsed = $masalahDiagnosis;

                // Parse intervensi rencana
                $intervensiRencana = [];
                if ($asesmen->rmeAsesmenPerinatology->intervensi_rencana) {
                    $intervensiRencana = json_decode($asesmen->rmeAsesmenPerinatology->intervensi_rencana, true) ?? [];
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
                'alergiPasien',
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
        } catch (Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id, Request $request)
    {
        DB::beginTransaction();

        try {
            $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
            if (empty($dataMedis)) throw new Exception('Data kunjungan tidak ditemukan !');

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
            $dataAsesmen->save();

            // Update RmeAsesmenKepPerinatology
            $tglLahir = $request->tanggal_lahir;
            $jamLahir = $request->jam_lahir;
            $waktuLahir = $tglLahir . ' ' . $jamLahir;

            // Validasi file yang diunggah
            $request->validate([
                'sidik_kaki_kiri' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
                'sidik_kaki_kanan' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
                'sidik_jari_ibu_kiri' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
                'sidik_jari_ibu_kanan' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
                'sidik_jari_bayi_kiri' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
                'sidik_jari_bayi_kanan' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            ]);

            // Update atau buat baru
            $asesmenPerinatology = RmeAsesmenKepPerinatology::firstOrNew(['id_asesmen' => $dataAsesmen->id]);
            $asesmenPerinatology->id_asesmen = $dataAsesmen->id;
            $asesmenPerinatology->data_masuk = $waktu_asesmen;
            $asesmenPerinatology->agama_orang_tua = $request->agama_orang_tua;
            $asesmenPerinatology->tgl_lahir_bayi = $waktuLahir;
            $asesmenPerinatology->nama_bayi = $request->nama_bayi;
            $asesmenPerinatology->jenis_kelamin = $request->jenis_kelamin;
            $asesmenPerinatology->nama_ibu = $request->nama_ibu;
            $asesmenPerinatology->nik_ibu = $request->nik_ibu;

            // Handle file uploads dengan penghapusan file lama
            if ($request->hasFile('sidik_kaki_kiri')) {
                // Hapus file lama jika ada
                if ($asesmenPerinatology->sidik_telapak_kaki_kiri && Storage::exists($asesmenPerinatology->sidik_telapak_kaki_kiri)) {
                    Storage::delete($asesmenPerinatology->sidik_telapak_kaki_kiri);
                }
                $pathSidikKakiKiri = $request->file('sidik_kaki_kiri')->store("uploads/ranap/asesmen-perinatology/$kd_unit/$kd_pasien/$tgl_masuk/$urut_masuk");
                $asesmenPerinatology->sidik_telapak_kaki_kiri = $pathSidikKakiKiri;
            }

            if ($request->hasFile('sidik_kaki_kanan')) {
                // Hapus file lama jika ada
                if ($asesmenPerinatology->sidik_telapak_kaki_kanan && Storage::exists($asesmenPerinatology->sidik_telapak_kaki_kanan)) {
                    Storage::delete($asesmenPerinatology->sidik_telapak_kaki_kanan);
                }
                $pathSidikKakiKanan = $request->file('sidik_kaki_kanan')->store("uploads/ranap/asesmen-perinatology/$kd_unit/$kd_pasien/$tgl_masuk/$urut_masuk");
                $asesmenPerinatology->sidik_telapak_kaki_kanan = $pathSidikKakiKanan;
            }

            if ($request->hasFile('sidik_jari_ibu_kiri')) {
                // Hapus file lama jika ada
                if ($asesmenPerinatology->sidik_jari_ibu_kiri && Storage::exists($asesmenPerinatology->sidik_jari_ibu_kiri)) {
                    Storage::delete($asesmenPerinatology->sidik_jari_ibu_kiri);
                }
                $pathSidikJariIbuKiri = $request->file('sidik_jari_ibu_kiri')->store("uploads/ranap/asesmen-perinatology/$kd_unit/$kd_pasien/$tgl_masuk/$urut_masuk");
                $asesmenPerinatology->sidik_jari_ibu_kiri = $pathSidikJariIbuKiri;
            }

            if ($request->hasFile('sidik_jari_ibu_kanan')) {
                // Hapus file lama jika ada
                if ($asesmenPerinatology->sidik_jari_ibu_kanan && Storage::exists($asesmenPerinatology->sidik_jari_ibu_kanan)) {
                    Storage::delete($asesmenPerinatology->sidik_jari_ibu_kanan);
                }
                $pathSidikJariIbuKanan = $request->file('sidik_jari_ibu_kanan')->store("uploads/ranap/asesmen-perinatology/$kd_unit/$kd_pasien/$tgl_masuk/$urut_masuk");
                $asesmenPerinatology->sidik_jari_ibu_kanan = $pathSidikJariIbuKanan;
            }

            if ($request->hasFile('sidik_jari_bayi_kiri')) {
                // Hapus file lama jika ada
                if ($asesmenPerinatology->sidik_jari_bayi_kiri && Storage::exists($asesmenPerinatology->sidik_jari_bayi_kiri)) {
                    Storage::delete($asesmenPerinatology->sidik_jari_bayi_kiri);
                }
                $pathSidikJariBayiKiri = $request->file('sidik_jari_bayi_kiri')->store("uploads/ranap/asesmen-perinatology/$kd_unit/$kd_pasien/$tgl_masuk/$urut_masuk");
                $asesmenPerinatology->sidik_jari_bayi_kiri = $pathSidikJariBayiKiri;
            }

            if ($request->hasFile('sidik_jari_bayi_kanan')) {
                // Hapus file lama jika ada
                if ($asesmenPerinatology->sidik_jari_bayi_kanan && Storage::exists($asesmenPerinatology->sidik_jari_bayi_kanan)) {
                    Storage::delete($asesmenPerinatology->sidik_jari_bayi_kanan);
                }
                $pathSidikJariBayiKanan = $request->file('sidik_jari_bayi_kanan')->store("uploads/ranap/asesmen-perinatology/$kd_unit/$kd_pasien/$tgl_masuk/$urut_masuk");
                $asesmenPerinatology->sidik_jari_bayi_kanan = $pathSidikJariBayiKanan;
            }

            $asesmenPerinatology->alamat = $request->alamat;
            $asesmenPerinatology->gaya_bicara = $request->gaya_bicara;
            $asesmenPerinatology->bahasa = $request->bahasa_sehari_hari;
            $asesmenPerinatology->perlu_penerjemahan = $request->perlu_penerjemah;
            $asesmenPerinatology->hambatan_komunikasi = $request->hambatan_komunikasi;
            $asesmenPerinatology->media_disukai = $request->media_disukai;
            $asesmenPerinatology->tingkat_pendidikan = $request->tingkat_pendidikan;

            if ($request->has('masalah_diagnosis') && is_array($request->masalah_diagnosis)) {
                $masalahDiagnosis = array_filter($request->masalah_diagnosis, function ($value) {
                    return !empty(trim($value));
                });
                $asesmenPerinatology->masalah_diagnosis = json_encode(array_values($masalahDiagnosis));
            }

            if ($request->has('intervensi_rencana') && is_array($request->intervensi_rencana)) {
                $intervensiRencana = array_filter($request->intervensi_rencana, function ($value) {
                    return !empty(trim($value));
                });
                $asesmenPerinatology->intervensi_rencana = json_encode(array_values($intervensiRencana));
            }

            $asesmenPerinatology->save();

            // === UPDATE DATA VITAL SIGN ===
            $vitalSignData = [
                'sistole' => null,
                'diastole' => null,
                'nadi' => $request->frekuensi_nadi ? (int) $request->frekuensi_nadi : null,
                'respiration' => $request->nafas ? (int) $request->nafas : null,
                'suhu' => $request->suhu ? (float) $request->suhu : null,
                'spo2_tanpa_o2' => $request->saturasi_o2_tanpa ? (int) $request->saturasi_o2_tanpa : null,
                'spo2_dengan_o2' => $request->saturasi_o2_dengan ? (int) $request->saturasi_o2_dengan : null,
                'tinggi_badan' => $request->tinggi_badan ? (int) $request->tinggi_badan : null,
                'berat_badan' => $request->berat_badan ? (int) $request->berat_badan : null,
            ];

            $lastTransaction = $this->asesmenService->getTransaksiData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
            $this->asesmenService->store($vitalSignData, $kd_pasien, $lastTransaction->no_transaksi, $lastTransaction->kd_kasir);

            // Update RmeAsesmenKepPerinatologyFisik
            $perinatologyFisik = RmeAsesmenKepPerinatologyFisik::firstOrNew(['id_asesmen' => $dataAsesmen->id]);
            $perinatologyFisik->id_asesmen = $dataAsesmen->id;
            $perinatologyFisik->jenis_kelamin = $request->jenis_kelamin;
            $perinatologyFisik->frekuensi_nadi = $request->frekuensi_nadi ? (int)$request->frekuensi_nadi : null;
            $perinatologyFisik->status_frekuensi = $request->status_frekuensi;
            $perinatologyFisik->nafas = $request->nafas ? (int)$request->nafas : null;
            $perinatologyFisik->suhu = $request->suhu ? (float)$request->suhu : null;
            $perinatologyFisik->spo2_tanpa_bantuan = $request->spo2_tanpa_bantuan ? (int)$request->spo2_tanpa_bantuan : null;
            $perinatologyFisik->spo2_dengan_bantuan = $request->spo2_dengan_bantuan ? (int)$request->spo2_dengan_bantuan : null;
            $perinatologyFisik->tinggi_badan = $request->tinggi_badan ? (int)$request->tinggi_badan : null;
            $perinatologyFisik->berat_badan = $request->berat_badan ? (int)$request->berat_badan : null;
            $perinatologyFisik->lingkar_kepala = $request->lingkar_kepala ? (int)$request->lingkar_kepala : null;
            $perinatologyFisik->lingkar_dada = $request->lingkar_dada;
            $perinatologyFisik->lingkar_perut = $request->lingkar_perut;
            $perinatologyFisik->kesadaran = $request->kesadaran;
            $perinatologyFisik->avpu = $request->avpu;
            $perinatologyFisik->save();

            // Update RmeAsesmenKepPerinatologyPemeriksaanLanjut
            $perinatologyPemeriksaanLanjut = RmeAsesmenKepPerinatologyPemeriksaanLanjut::firstOrNew(['id_asesmen' => $dataAsesmen->id]);
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

            // Update data alergi
            $alergiData = json_decode($request->alergis, true);
            RmeAlergiPasien::where('kd_pasien', $kd_pasien)->delete();

            if (!empty($alergiData)) {
                foreach ($alergiData as $alergi) {
                    RmeAlergiPasien::create([
                        'kd_pasien' => $kd_pasien,
                        'jenis_alergi' => $alergi['jenis_alergi'],
                        'nama_alergi' => $alergi['alergen'],
                        'reaksi' => $alergi['reaksi'],
                        'tingkat_keparahan' => $alergi['tingkat_keparahan']
                    ]);
                }
            }

            // Update RmeAsesmenKepPerinatologyRiwayatIbu
            $riwayatIbu = RmeAsesmenKepPerinatologyRiwayatIbu::firstOrNew(['id_asesmen' => $dataAsesmen->id]);
            $riwayatIbu->id_asesmen = $dataAsesmen->id;
            $riwayatIbu->pemeriksaan_kehamilan = $request->pemeriksaan_kehamilan;
            $riwayatIbu->tempat_pemeriksaan = $request->tempat_pemeriksaan;
            $riwayatIbu->usia_kehamilan = $request->usia_kehamilan;
            $riwayatIbu->cara_persalinan = $request->cara_persalinan;

            $riwayatJson = $request->input('riwayat_penyakit_pengobatan');
            if ($riwayatJson) {
                json_decode($riwayatJson);
                $riwayatIbu->riwayat_penyakit_pengobatan = (json_last_error() === JSON_ERROR_NONE) ? $riwayatJson : json_encode([]);
            } else {
                $riwayatIbu->riwayat_penyakit_pengobatan = json_encode([]);
            }
            $riwayatIbu->save();

            // Update RmeKepPerinatologyStatusNyeri
            $statusNyeri = RmeAsesmenKepPerinatologyStatusNyeri::firstOrNew(['id_asesmen' => $dataAsesmen->id]);
            $statusNyeri->id_asesmen = $dataAsesmen->id;

            if ($request->filled('jenis_skala_nyeri')) {
                $jenisSkala = ['NRS' => 1, 'FLACC' => 2, 'CRIES' => 3];
                $statusNyeri->jenis_skala_nyeri = $jenisSkala[$request->jenis_skala_nyeri];
                $statusNyeri->nilai_nyeri = $request->nilai_skala_nyeri;
                $statusNyeri->kesimpulan_nyeri = $request->kesimpulan_nyeri;

                if ($request->jenis_skala_nyeri === 'FLACC') {
                    $statusNyeri->flacc_wajah = $request->wajah ? json_encode($request->wajah) : null;
                    $statusNyeri->flacc_kaki = $request->kaki ? json_encode($request->kaki) : null;
                    $statusNyeri->flacc_aktivitas = $request->aktivitas ? json_encode($request->aktivitas) : null;
                    $statusNyeri->flacc_menangis = $request->menangis ? json_encode($request->menangis) : null;
                    $statusNyeri->flacc_konsolabilitas = $request->konsolabilitas ? json_encode($request->konsolabilitas) : null;
                    $statusNyeri->flacc_jumlah_skala = $request->flaccTotal;
                }

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

            // Update Risiko Jatuh
            $risikoJatuh = RmeAsesmenKepPerinatologyRisikoJatuh::firstOrNew(['id_asesmen' => $dataAsesmen->id]);
            $risikoJatuh->id_asesmen = $dataAsesmen->id;

            if ($request->filled('resiko_jatuh_jenis')) {
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
                    $risikoJatuh->risiko_jatuh_morse_cara_berjalan = array_search($request->risiko_jatuh_morse_cara_berjalan, ['0' => 0, '20' => 20, '10' => 10]);
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
                    $risikoJatuh->risiko_jatuh_lansia_transfer_bantuan_total = array_search($request->risiko_jatuh_lansia_transfer_bantuan_total, ['3' => 3, '0' => 0]);
                    $risikoJatuh->risiko_jatuh_lansia_mobilitas_mandiri = $request->risiko_jatuh_lansia_mobilitas_mandiri;
                    $risikoJatuh->risiko_jatuh_lansia_mobilitas_bantuan_1_orang = $request->risiko_jatuh_lansia_mobilitas_bantuan_1_orang;
                    $risikoJatuh->risiko_jatuh_lansia_mobilitas_kursi_roda = array_search($request->risiko_jatuh_lansia_mobilitas_kursi_roda, ['2' => 2, '0' => 0]);
                    $risikoJatuh->risiko_jatuh_lansia_mobilitas_imobilisasi = array_search($request->risiko_jatuh_lansia_mobilitas_imobilisasi, ['3' => 3, '0' => 0]);
                    $risikoJatuh->kesimpulan_skala_lansia = $request->risiko_jatuh_lansia_kesimpulan;
                }
            }
            $risikoJatuh->save();

            // Update RmeAsesmenKepPerinatologyResikoDekubitus
            if ($request->filled('jenis_skala_dekubitus')) {
                $resikoDekubitus = RmeAsesmenKepPerinatologyResikoDekubitus::firstOrNew(['id_asesmen' => $dataAsesmen->id]);
                $resikoDekubitus->id_asesmen = $dataAsesmen->id;

                if ($request->jenis_skala_dekubitus === 'norton') {
                    $resikoDekubitus->jenis_skala = 1;
                    $resikoDekubitus->norton_kondisi_fisik = $request->kondisi_fisik;
                    $resikoDekubitus->norton_kondisi_mental = $request->kondisi_mental;
                    $resikoDekubitus->norton_aktivitas = $request->norton_aktivitas;
                    $resikoDekubitus->norton_mobilitas = $request->norton_mobilitas;
                    $resikoDekubitus->norton_inkontenesia = $request->inkontinensia;

                    $totalNorton = (int)$request->kondisi_fisik + (int)$request->kondisi_mental +
                        (int)$request->norton_aktivitas + (int)$request->norton_mobilitas +
                        (int)$request->inkontinensia;

                    if ($totalNorton <= 14) {
                        $resikoDekubitus->decubitus_kesimpulan = 'Risiko Tinggi';
                    } elseif ($totalNorton <= 18) {
                        $resikoDekubitus->decubitus_kesimpulan = 'Risiko Sedang';
                    } else {
                        $resikoDekubitus->decubitus_kesimpulan = 'Risiko Rendah';
                    }
                }

                if ($request->jenis_skala_dekubitus === 'braden') {
                    $resikoDekubitus->jenis_skala = 2;
                    $resikoDekubitus->braden_persepsi = $request->persepsi_sensori;
                    $resikoDekubitus->braden_kelembapan = $request->kelembapan;
                    $resikoDekubitus->braden_aktivitas = $request->braden_aktivitas;
                    $resikoDekubitus->braden_mobilitas = $request->braden_mobilitas;
                    $resikoDekubitus->braden_nutrisi = $request->nutrisi;
                    $resikoDekubitus->braden_pergesekan = $request->pergesekan;

                    $totalBraden = (int)$request->persepsi_sensori + (int)$request->kelembapan +
                        (int)$request->braden_aktivitas + (int)$request->braden_mobilitas +
                        (int)$request->nutrisi + (int)$request->pergesekan;

                    if ($totalBraden <= 12) {
                        $resikoDekubitus->decubitus_kesimpulan = 'Risiko Tinggi';
                    } elseif ($totalBraden <= 14) {
                        $resikoDekubitus->decubitus_kesimpulan = 'Risiko Sedang';
                    } else {
                        $resikoDekubitus->decubitus_kesimpulan = 'Risiko Rendah';
                    }
                }

                $resikoDekubitus->save();
            }

            // Update RmeAsesmenKepPerinatologyGizi
            if ($request->filled('gizi_jenis')) {
                $gizi = RmeAsesmenKepPerinatologyGizi::firstOrNew(['id_asesmen' => $dataAsesmen->id]);
                $gizi->id_asesmen = $dataAsesmen->id;
                $gizi->gizi_jenis = (int)$request->gizi_jenis;

                // MST
                if ($request->gizi_jenis == 1) {
                    $gizi->gizi_mst_penurunan_bb = $request->gizi_mst_penurunan_bb;
                    $gizi->gizi_mst_jumlah_penurunan_bb = $request->gizi_mst_jumlah_penurunan_bb;
                    $gizi->gizi_mst_nafsu_makan_berkurang = $request->gizi_mst_nafsu_makan_berkurang;
                    $gizi->gizi_mst_diagnosis_khusus = $request->gizi_mst_diagnosis_khusus;
                    $gizi->gizi_mst_kesimpulan = $request->gizi_mst_kesimpulan;
                }

                // MNA
                if ($request->gizi_jenis == 2) {
                    $gizi->gizi_mna_penurunan_asupan_3_bulan = (int)$request->gizi_mna_penurunan_asupan_3_bulan;
                    $gizi->gizi_mna_kehilangan_bb_3_bulan = (int)$request->gizi_mna_kehilangan_bb_3_bulan;
                    $gizi->gizi_mna_mobilisasi = (int)$request->gizi_mna_mobilisasi;
                    $gizi->gizi_mna_stress_penyakit_akut = (int)$request->gizi_mna_stress_penyakit_akut;
                    $gizi->gizi_mna_status_neuropsikologi = (int)$request->gizi_mna_status_neuropsikologi;
                    $gizi->gizi_mna_berat_badan = (float)$request->gizi_mna_berat_badan;
                    $gizi->gizi_mna_tinggi_badan = (float)$request->gizi_mna_tinggi_badan;

                    // Hitung IMT
                    if ($request->gizi_mna_tinggi_badan > 0) {
                        $heightInMeters = $request->gizi_mna_tinggi_badan / 100;
                        $imt = $request->gizi_mna_berat_badan / ($heightInMeters * $heightInMeters);
                        $gizi->gizi_mna_imt = number_format($imt, 2, '.', '');
                    }

                    $gizi->gizi_mna_kesimpulan = $request->gizi_mna_kesimpulan;
                }

                // Strong Kids
                if ($request->gizi_jenis == 3) {
                    $gizi->gizi_strong_status_kurus = $request->gizi_strong_status_kurus;
                    $gizi->gizi_strong_penurunan_bb = $request->gizi_strong_penurunan_bb;
                    $gizi->gizi_strong_gangguan_pencernaan = $request->gizi_strong_gangguan_pencernaan;
                    $gizi->gizi_strong_penyakit_berisiko = $request->gizi_strong_penyakit_berisiko;
                    $gizi->gizi_strong_kesimpulan = $request->gizi_strong_kesimpulan;
                }

                // NRS
                if ($request->gizi_jenis == 4) {
                    $gizi->gizi_nrs_jatuh_saat_masuk_rs = $request->gizi_nrs_jatuh_saat_masuk_rs ?? null;
                    $gizi->gizi_nrs_kesimpulan = $request->gizi_nrs_kesimpulan ?? null;
                }

                // Tidak dapat dinilai
                if ($request->gizi_jenis == 5) {
                    $gizi->status_gizi_tidakdapat = 'Tidak dapat dinilai';
                }

                $gizi->save();
            }

            // === SIMPAN KE RmeAsesmenKepPerinatologyFungsional ===
            if ($request->filled('skala_fungsional')) {
                $fungsional = RmeAsesmenKepPerinatologyStatusFungsional::firstOrNew(['id_asesmen' => $dataAsesmen->id]);

                // Jenis skala (1: Pengkajian Aktivitas, 2: Lainnya)
                $fungsional->jenis_skala = (int)$request->skala_fungsional;

                // Data dari modal ADL
                $fungsional->makan = $request->adl_makan ?? '';
                $fungsional->berjalan = $request->adl_berjalan ?? '';
                $fungsional->mandi = $request->adl_mandi ?? '';

                // Total skala dan kesimpulan
                $fungsional->jumlah_skala = $request->adl_total ? (int)$request->adl_total : 0;
                $fungsional->nilai_skala_adl = $request->adl_total ?? '';
                $fungsional->kesimpulan = $request->adl_kesimpulan_value ?? '';
                $fungsional->kesimpulan_fungsional = $request->adl_kesimpulan_value ?? '';

                $fungsional->save();
            }

            // Update RmeAsesmenKepPerinatologyRencanaPulang
            $rencanaPulang = RmeAsesmenKepPerinatologyRencanaPulang::firstOrNew(['id_asesmen' => $dataAsesmen->id]);
            $rencanaPulang->id_asesmen = $dataAsesmen->id;
            $rencanaPulang->diagnosis_medis = $request->diagnosis_medis ?? null;
            $rencanaPulang->usia_lanjut = $request->usia_lanjut;
            $rencanaPulang->hambatan_mobilisasi = $request->hambatan_mobilisasi;
            $rencanaPulang->membutuhkan_pelayanan_medis = $request->penggunaan_media_berkelanjutan;
            $rencanaPulang->memerlukan_keterampilan_khusus = $request->keterampilan_khusus;
            $rencanaPulang->memerlukan_alat_bantu = $request->alat_bantu;
            $rencanaPulang->memiliki_nyeri_kronis = $request->nyeri_kronis;
            $rencanaPulang->perkiraan_lama_dirawat = $request->perkiraan_hari;
            $rencanaPulang->rencana_pulang = $request->tanggal_pulang;
            $rencanaPulang->kesimpulan = $request->kesimpulan_planing ?? 'Tidak membutuhkan rencana pulang khusus';
            $rencanaPulang->save();

            // Update RmeAsesmenKepPerinatologyKeperawatan
            RmeAsesmenKepPerinatologyKeperawatan::updateOrCreate(
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

            // === SIMPAN RESUME ===
            // Data vital sign untuk disimpan via service
            $vitalSignData = [
                'nadi' => $request->frekuensi_nadi ? (int) $request->frekuensi_nadi : null,
                'respiration' => $request->nafas ? (int) $request->nafas : null,
                'suhu' => $request->suhu ? (float) $request->suhu : null,
                'spo2_tanpa_o2' => $request->spo2_tanpa_bantuan ? (int) $request->spo2_tanpa_bantuan : null,
                'spo2_dengan_o2' => $request->spo2_dengan_bantuan ? (int) $request->spo2_dengan_bantuan : null,
                'tinggi_badan' => $request->tinggi_badan ? (int) $request->tinggi_badan : null,
                'berat_badan' => $request->berat_badan ? (int) $request->berat_badan : null,
            ];

            $this->asesmenService->store($vitalSignData, $kd_pasien, $dataMedis->no_transaksi, $dataMedis->kd_kasir);

            // create resume
            $resumeData = [
                'anamnesis'             => $request->anamnesis,

                'konpas'                =>
                [
                    'respiration_rate'   => [
                        'hasil' => $vitalSignData['respiration'] ?? null
                    ],
                    'suhu'   => [
                        'hasil' => $vitalSignData['suhu'] ?? null
                    ],
                    'nadi'   => [
                        'hasil' => $vitalSignData['nadi'] ?? null
                    ],
                    'tinggi_badan'   => [
                        'hasil' => $vitalSignData['tinggi_badan'] ?? null
                    ],
                    'berat_badan'   => [
                        'hasil' => $vitalSignData['berat_badan'] ?? null
                    ]
                ]
            ];

            $this->baseService->updateResumeMedis($dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $resumeData);

            DB::commit();

            return to_route('rawat-inap.asesmen.medis.umum.index', [
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
            ])->with('success', 'Data asesmen perinatology berhasil diperbarui');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return back()->with('error', 'Data tidak ditemukan. Detail: ' . $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
