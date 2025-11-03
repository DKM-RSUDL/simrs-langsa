<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\RmeAsesmenthtDiagnosisImplementasi;
use App\Models\MrItemFisik;
use App\Models\RmeAsesmen;
use App\Models\RmeAsesmenPemeriksaanFisik;
use App\Models\RmeAsesmenTht;
use App\Models\RmeAsesmenThtDischargePlanning;
use App\Models\RmeAsesmenThtPemeriksaanFisik;
use App\Models\RmeAsesmenThtRiwayatKesehatanObatAlergi;
use App\Models\RmeMasterDiagnosis;
use App\Models\RmeMasterImplementasi;
use App\Models\RMEResume;
use App\Models\RmeResumeDtl;
use App\Models\RmeAlergiPasien;
use App\Models\SatsetPrognosis;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Services\AsesmenService;

class AsesmenKepThtController extends Controller
{
    protected $asesmenService;
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
        $this->asesmenService = new AsesmenService();
    }

    public function index(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $user = auth()->user();
        $itemFisik = MrItemFisik::orderby('urut')->get();
        $rmeMasterDiagnosis = RmeMasterDiagnosis::all();
        $rmeMasterImplementasi = RmeMasterImplementasi::all();
        $satsetPrognosis = SatsetPrognosis::all();
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

        return view('unit-pelayanan.rawat-inap.pelayanan.asesmen-tht.create', compact(
            'kd_unit',
            'kd_pasien',
            'tgl_masuk',
            'urut_masuk',
            'dataMedis',
            'itemFisik',
            'user',
            'rmeMasterDiagnosis',
            'rmeMasterImplementasi',
            'alergiPasien',
            'satsetPrognosis',
            'vitalSignsData'
        ));
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        DB::beginTransaction();
        try {

            $asesmenTht = new RmeAsesmen();
            $asesmenTht->kd_pasien = $request->kd_pasien;
            $asesmenTht->kd_unit = $request->kd_unit;
            $asesmenTht->tgl_masuk = $request->tgl_masuk;
            $asesmenTht->urut_masuk = $request->urut_masuk;
            $asesmenTht->user_id = Auth::id();
            $asesmenTht->waktu_asesmen = date('Y-m-d H:i:s');
            $asesmenTht->kategori = 1;
            $asesmenTht->sub_kategori = 5;
            $asesmenTht->save();

            $request->validate([
                'hasil_pemeriksaan_penunjang_darah' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
                'hasil_pemeriksaan_penunjang_urine' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
                'hasil_pemeriksaan_penunjang_rontgent' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
                'hasil_pemeriksaan_penunjang_histopatology' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048'
            ]);

            // Data vital sign untuk disimpan (disesuaikan dengan field yang tersedia di THT)
            $vitalSignData = [
                'sistole' => $request->darah_sistole ? (int)$request->darah_sistole : null,
                'diastole' => $request->darah_diastole ? (int)$request->darah_diastole : null,
                'nadi' => $request->nadi ? (int)$request->nadi : null,
                'respiration' => $request->nafas ? (int)$request->nafas : null,
                'suhu' => $request->suhu ? (float)$request->suhu : null,
                'spo2_tanpa_o2' => null, // Tidak ada di THT, set null
                'tinggi_badan' => $request->antropometri_tinggi_badan ? (int)$request->antropometri_tinggi_badan : null,
                'berat_badan' => $request->antropometr_berat_badan ? (int)$request->antropometr_berat_badan : null,
            ];



            $lastTransaction = $this->asesmenService->getTransaksiData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

            // Simpan vital sign menggunakan service
            $this->asesmenService->store($vitalSignData, $kd_pasien, $lastTransaction->no_transaksi, $lastTransaction->kd_kasir);

            $asesmenThtDataMasuk = new RmeAsesmenTht();
            $asesmenThtDataMasuk->id_asesmen = $asesmenTht->id;
            $asesmenThtDataMasuk->tgl_masuk = "$request->tgl_masuk $request->jam_masuk";
            $asesmenThtDataMasuk->kondisi_masuk = $request->kondisi_masuk;
            $asesmenThtDataMasuk->ruang = $request->ruang;
            $asesmenThtDataMasuk->anamnesis_anamnesis = $request->anamnesis_anamnesis;
            $asesmenThtDataMasuk->evaluasi_evaluasi_keperawatan = $request->evaluasi_evaluasi_keperawatan;
            $asesmenThtDataMasuk->penyakit_sekarang = $request->penyakit_sekarang;
            $asesmenThtDataMasuk->penyakit_terdahulu = $request->penyakit_terdahulu;
            $asesmenThtDataMasuk->rencana_penatalaksanaan = $request->rencana_penatalaksanaan;
            $asesmenThtDataMasuk->darah = $request->darah;
            $asesmenThtDataMasuk->urine = $request->urine;
            $asesmenThtDataMasuk->rontgent = $request->rontgent;
            $asesmenThtDataMasuk->gistopatology = $request->gistopatology;

            // Array untuk menyimpan path file yang berhasil diupload
            $uploadedFiles = [];

            // Fungsi helper untuk upload file
            $uploadFile = function ($fieldName) use ($request, &$uploadedFiles, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk) {
                if ($request->hasFile($fieldName)) {
                    try {
                        $file = $request->file($fieldName);
                        $path = $file->store("uploads/ranap/asesmen-tht/$kd_unit/$kd_pasien/$tgl_masuk/$urut_masuk");

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
            $asesmenThtDataMasuk->hasil_pemeriksaan_penunjang_darah = $uploadFile('hasil_pemeriksaan_penunjang_darah');
            $asesmenThtDataMasuk->hasil_pemeriksaan_penunjang_urine = $uploadFile('hasil_pemeriksaan_penunjang_urine');
            $asesmenThtDataMasuk->hasil_pemeriksaan_penunjang_rontgent = $uploadFile('hasil_pemeriksaan_penunjang_rontgent');
            $asesmenThtDataMasuk->hasil_pemeriksaan_penunjang_histopatology = $uploadFile('hasil_pemeriksaan_penunjang_histopatology');

            $asesmenThtDataMasuk->save();

            $asesmenThtPemeriksaanFisik = new RmeAsesmenThtPemeriksaanFisik();
            $asesmenThtPemeriksaanFisik->id_asesmen = $asesmenTht->id;
            // Vital sign tidak disimpan di sini lagi karena sudah di-handle via service; gunakan null atau hapus field ini jika duplikat
            $asesmenThtPemeriksaanFisik->darah_sistole = $request->darah_sistole;
            $asesmenThtPemeriksaanFisik->darah_diastole = $request->darah_diastole;
            $asesmenThtPemeriksaanFisik->nadi = $request->nadi;
            $asesmenThtPemeriksaanFisik->nafas = $request->nafas;
            $asesmenThtPemeriksaanFisik->suhu = $request->suhu;
            $asesmenThtPemeriksaanFisik->sensorium = $request->sensorium;
            $asesmenThtPemeriksaanFisik->ku_kp_kg = $request->ku_kp_kg;
            $asesmenThtPemeriksaanFisik->avpu = $request->avpu;
            $asesmenThtPemeriksaanFisik->pangkal_lidah = $request->pangkal_lidah;
            $asesmenThtPemeriksaanFisik->tonsil_lidah = $request->tonsil_lidah;
            $asesmenThtPemeriksaanFisik->epiglotis = $request->epiglotis;
            $asesmenThtPemeriksaanFisik->pita_suara = $request->pita_suara;
            // Daun Telinga
            $asesmenThtPemeriksaanFisik->daun_telinga_nanah_kana = $request->daun_telinga_nanah_kana;
            $asesmenThtPemeriksaanFisik->daun_telinga_nanah_kiri = $request->daun_telinga_nanah_kiri;
            $asesmenThtPemeriksaanFisik->daun_telinga_darah_kanan = $request->daun_telinga_darah_kanan;
            $asesmenThtPemeriksaanFisik->daun_telinga_darah_kiri = $request->daun_telinga_darah_kiri;
            $asesmenThtPemeriksaanFisik->daun_telinga_lainnya_kanan = $request->daun_telinga_lainnya_kanan;
            $asesmenThtPemeriksaanFisik->daun_telinga_lainnya_kiri = $request->daun_telinga_lainnya_kiri;
            // Liang Telinga
            $asesmenThtPemeriksaanFisik->liang_telinga_darah_kanan = $request->liang_telinga_darah_kanan;
            $asesmenThtPemeriksaanFisik->liang_telinga_darah_kiri = $request->liang_telinga_darah_kiri;
            $asesmenThtPemeriksaanFisik->liang_telinga_nanah_kanan = $request->liang_telinga_nanah_kanan;
            $asesmenThtPemeriksaanFisik->liang_telinga_nanah_kiri = $request->liang_telinga_nanah_kiri;
            $asesmenThtPemeriksaanFisik->liang_telinga_berbau_kanan = $request->liang_telinga_berbau_kanan;
            $asesmenThtPemeriksaanFisik->liang_telinga_berbau_kiri = $request->liang_telinga_berbau_kiri;
            $asesmenThtPemeriksaanFisik->liang_telinga_lainnya_kanan = $request->liang_telinga_lainnya_kanan;
            $asesmenThtPemeriksaanFisik->liang_telinga_lainnya_kiri = $request->liang_telinga_lainnya_kiri;
            // Tes Pendengaran
            $asesmenThtPemeriksaanFisik->tes_pendengaran_renne_res_kanan = $request->tes_pendengaran_renne_res_kanan;
            $asesmenThtPemeriksaanFisik->tes_pendengaran_renne_res_kiri = $request->tes_pendengaran_renne_res_kiri;
            $asesmenThtPemeriksaanFisik->tes_pendengaran_weber_tes_kanan = $request->tes_pendengaran_weber_tes_kanan;
            $asesmenThtPemeriksaanFisik->tes_pendengaran_weber_tes_kiri = $request->tes_pendengaran_weber_tes_kiri;
            $asesmenThtPemeriksaanFisik->tes_pendengaran_schwabach_test_kanan = $request->tes_pendengaran_schwabach_test_kanan;
            $asesmenThtPemeriksaanFisik->tes_pendengaran_schwabach_test_kiri = $request->tes_pendengaran_schwabach_test_kiri;
            $asesmenThtPemeriksaanFisik->tes_pendengaran_bebisik_kanan = $request->tes_pendengaran_bebisik_kanan;
            $asesmenThtPemeriksaanFisik->tes_pendengaran_bebisik_kiri = $request->tes_pendengaran_bebisik_kiri;
            // Paranatal Sinus
            $asesmenThtPemeriksaanFisik->senus_frontalis_nyeri_tekan_kanan = $request->senus_frontalis_nyeri_tekan_kanan;
            $asesmenThtPemeriksaanFisik->senus_frontalis_nyeri_tekan_kiri = $request->senus_frontalis_nyeri_tekan_kiri;
            $asesmenThtPemeriksaanFisik->senus_frontalis_transluminasi_kanan = $request->senus_frontalis_transluminasi_kanan;
            $asesmenThtPemeriksaanFisik->senus_frontalis_transluminasi_kiri = $request->senus_frontalis_transluminasi_kiri;
            // Sinus Maksinasi
            $asesmenThtPemeriksaanFisik->sinus_maksinasi_nyari_tekan_kanan = $request->sinus_maksinasi_nyari_tekan_kanan;
            $asesmenThtPemeriksaanFisik->sinus_maksinasi_nyari_tekan_kiri = $request->sinus_maksinasi_nyari_tekan_kiri;
            $asesmenThtPemeriksaanFisik->sinus_maksinasi_transluminasi_kanan = $request->sinus_maksinasi_transluminasi_kanan;
            $asesmenThtPemeriksaanFisik->sinus_maksinasi_transluminasi_kiri = $request->sinus_maksinasi_transluminasi_kiri;
            // Rhinoscopi Anterior
            $asesmenThtPemeriksaanFisik->rhinoscopi_anterior_cavun_nasi_kanan = $request->rhinoscopi_anterior_cavun_nasi_kanan;
            $asesmenThtPemeriksaanFisik->rhinoscopi_anterior_cavun_nasi_kiri = $request->rhinoscopi_anterior_cavun_nasi_kiri;
            $asesmenThtPemeriksaanFisik->rhinoscopi_anterior_konka_inferior_kanan = $request->rhinoscopi_anterior_konka_inferior_kanan;
            $asesmenThtPemeriksaanFisik->rhinoscopi_anterior_konka_inferior_kiri = $request->rhinoscopi_anterior_konka_inferior_kiri;
            $asesmenThtPemeriksaanFisik->rhinoscopi_anterior_septum_nasi_kanan = $request->rhinoscopi_anterior_septum_nasi_kanan;
            $asesmenThtPemeriksaanFisik->rhinoscopi_anterior_septum_nasi_kiri = $request->rhinoscopi_anterior_septum_nasi_kiri;
            // Rhinoscopi Pasterior
            $asesmenThtPemeriksaanFisik->rhinoscopi_pasterior_septum_nasi_kanan = $request->rhinoscopi_pasterior_septum_nasi_kanan;
            $asesmenThtPemeriksaanFisik->rhinoscopi_pasterior_septum_nasi_kiri = $request->rhinoscopi_pasterior_septum_nasi_kiri;
            $asesmenThtPemeriksaanFisik->rhinoscopi_superior_kanan = $request->rhinoscopi_superior_kanan;
            $asesmenThtPemeriksaanFisik->rhinoscopi_superior_kiri = $request->rhinoscopi_superior_kiri;
            $asesmenThtPemeriksaanFisik->rhinoscopi_media_kanan = $request->rhinoscopi_media_kanan;
            $asesmenThtPemeriksaanFisik->rhinoscopi_media_kiri = $request->rhinoscopi_media_kiri;
            $asesmenThtPemeriksaanFisik->rhinoscopi_fasso_rossenmuler_kanan = $request->rhinoscopi_fasso_rossenmuler_kanan;
            $asesmenThtPemeriksaanFisik->rhinoscopi_fasso_rossenmuler_kiri = $request->rhinoscopi_fasso_rossenmuler_kiri;
            // Meatus Nasi
            $asesmenThtPemeriksaanFisik->meatus_nasi_superior_kanan = $request->meatus_nasi_superior_kanan;
            $asesmenThtPemeriksaanFisik->meatus_nasi_superior_kiri = $request->meatus_nasi_superior_kiri;
            $asesmenThtPemeriksaanFisik->meatus_nasi_media_kanan = $request->meatus_nasi_media_kanan;
            $asesmenThtPemeriksaanFisik->meatus_nasi_media_kiri = $request->meatus_nasi_media_kiri;
            $asesmenThtPemeriksaanFisik->meatus_nasi_inferior_kanan = $request->meatus_nasi_inferior_kanan;
            $asesmenThtPemeriksaanFisik->meatus_nasi_inferior_kiri = $request->meatus_nasi_inferior_kiri;
            // Membran Tympani
            $asesmenThtPemeriksaanFisik->membran_tympani_warna_kanan = $request->membran_tympani_warna_kanan;
            $asesmenThtPemeriksaanFisik->membran_tympani_warna_kiri = $request->membran_tympani_warna_kiri;
            $asesmenThtPemeriksaanFisik->membran_tympani_perforasi_kanan = $request->membran_tympani_perforasi_kanan;
            $asesmenThtPemeriksaanFisik->membran_tympani_perforasi_kiri = $request->membran_tympani_perforasi_kiri;
            $asesmenThtPemeriksaanFisik->membran_tympani_lainnya_kanan = $request->membran_tympani_lainnya_kanan;
            $asesmenThtPemeriksaanFisik->membran_tympani_lainnya_kiri = $request->membran_tympani_lainnya_kiri;
            // Hidung
            $asesmenThtPemeriksaanFisik->hidung_bentuk_kanan = $request->hidung_bentuk_kanan;
            $asesmenThtPemeriksaanFisik->hidung_bentuk_kiri = $request->hidung_bentuk_kiri;
            $asesmenThtPemeriksaanFisik->hidung_luka_kanan = $request->hidung_luka_kanan;
            $asesmenThtPemeriksaanFisik->hidung_luka_kiri = $request->hidung_luka_kiri;
            $asesmenThtPemeriksaanFisik->hidung_bisul_kanan = $request->hidung_bisul_kanan;
            $asesmenThtPemeriksaanFisik->hidung_bisul_kiri = $request->hidung_bisul_kiri;
            $asesmenThtPemeriksaanFisik->hidung_fissare_kanan = $request->hidung_fissare_kanan;
            $asesmenThtPemeriksaanFisik->hidung_fissare_kiri = $request->hidung_fissare_kiri;
            // Antropometri (tidak disimpan di sini lagi karena sudah via service)
            $asesmenThtPemeriksaanFisik->antropometri_tinggi_badan = null;
            $asesmenThtPemeriksaanFisik->antropometr_berat_badan = null;
            $asesmenThtPemeriksaanFisik->antropometri_imt = $request->antropometri_imt;
            $asesmenThtPemeriksaanFisik->antropometri_lpt = $request->antropometri_lpt;

            // Plica vokalis
            $asesmenThtPemeriksaanFisik->plica_vokalis_bentuk_kanan = $request->plica_vokalis_bentuk_kanan;
            $asesmenThtPemeriksaanFisik->plica_vokalis_bentuk_kiri = $request->plica_vokalis_bentuk_kiri;
            $asesmenThtPemeriksaanFisik->plica_vokalis_warna_kanan = $request->plica_vokalis_warna_kanan;
            $asesmenThtPemeriksaanFisik->plica_vokalis_warna_kiri = $request->plica_vokalis_warna_kiri;

            $asesmenThtPemeriksaanFisik->save();

            //Simpan ke table RmePemeriksaanFisik
            $itemFisik = MrItemFisik::all();
            foreach ($itemFisik as $item) {
                $itemName = strtolower($item->nama);
                $isNormal = $request->has($item->id . '-normal') ? 1 : 0;
                $keterangan = $request->input($item->id . '_keterangan');
                if ($isNormal) $keterangan = '';

                RmeAsesmenPemeriksaanFisik::create([
                    'id_asesmen' => $asesmenTht->id,
                    'id_item_fisik' => $item->id,
                    'is_normal' => $isNormal,
                    'keterangan' => $keterangan
                ]);
            }

            $asesmenThtRiwayatKesehatanObatAlergi = new RmeAsesmenThtRiwayatKesehatanObatAlergi();
            $asesmenThtRiwayatKesehatanObatAlergi->id_asesmen = $asesmenTht->id;
            $penyakitDiderita = $request->riwayat_kesehatan_penyakit_diderita;
            if ($penyakitDiderita) {
                $decodedPenyakit = json_decode($penyakitDiderita);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $asesmenThtRiwayatKesehatanObatAlergi->riwayat_kesehatan_penyakit_diderita = $penyakitDiderita;
                } else {
                    throw new \Exception('Invalid JSON format for penyakit_diderita');
                }
            } else {
                $asesmenThtRiwayatKesehatanObatAlergi->riwayat_kesehatan_penyakit_diderita = null;
            }

            $penyakitKeluarga = $request->riwayat_kesehatan_penyakit_keluarga;
            if ($penyakitKeluarga) {
                // Validasi JSON string
                $decodedPenyakit = json_decode($penyakitKeluarga);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $asesmenThtRiwayatKesehatanObatAlergi->riwayat_kesehatan_penyakit_keluarga = $penyakitKeluarga;
                } else {
                    throw new \Exception('Invalid JSON format for penyakit_Keluarga');
                }
            } else {
                $asesmenThtRiwayatKesehatanObatAlergi->riwayat_kesehatan_penyakit_keluarga = null;
            }

            $riwayatObat = $request->riwayat_penggunaan_obat;
            if ($riwayatObat) {
                $decodedObat = json_decode($riwayatObat, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new \Exception('Format JSON untuk riwayat obat tidak valid');
                }

                // Validasi struktur data
                foreach ($decodedObat as $obat) {
                    if (!isset(
                        $obat['namaObat'],
                        $obat['dosis'],
                        $obat['satuan'],
                        $obat['frekuensi'],
                        $obat['keterangan']
                    )) {
                        throw new \Exception('Data obat tidak lengkap');
                    }
                }

                $asesmenThtRiwayatKesehatanObatAlergi->riwayat_penggunaan_obat = $riwayatObat;
            } else {
                $asesmenThtRiwayatKesehatanObatAlergi->riwayat_penggunaan_obat = null;
            }

            $dataAlergi = $request->alergi;
            if ($dataAlergi) {
                $decodedObat = json_decode($dataAlergi, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new \Exception('Format JSON untuk alergi tidak valid');
                }

                // Validasi struktur data
                foreach ($decodedObat as $obat) {
                    if (!isset(
                        $obat['alergen'],
                        $obat['reaksi'],
                        $obat['severe'],
                    )) {
                        throw new \Exception('Data alergi tidak lengkap');
                    }
                }

                $asesmenThtRiwayatKesehatanObatAlergi->alergi = $dataAlergi;
            } else {
                $asesmenThtRiwayatKesehatanObatAlergi->alergi = null;
            }
            $asesmenThtRiwayatKesehatanObatAlergi->save();

            // Validasi data alergi
            $alergiData = json_decode($request->alergis, true);

            if (!empty($alergiData)) {
                // Hapus data alergi lama untuk pasien ini
                RmeAlergiPasien::where('kd_pasien', $kd_pasien)->delete();

                // Simpan data alergi baru
                foreach ($alergiData as $alergi) {
                    // Skip data yang sudah ada di database (is_existing = true)
                    // kecuali jika ingin update
                    RmeAlergiPasien::create([
                        'kd_pasien' => $kd_pasien,
                        'jenis_alergi' => $alergi['jenis_alergi'],
                        'nama_alergi' => $alergi['alergen'],
                        'reaksi' => $alergi['reaksi'],
                        'tingkat_keparahan' => $alergi['tingkat_keparahan']
                    ]);
                }
            }

            $asesmenThtDischargePlanning = new RmeAsesmenThtDischargePlanning();
            $asesmenThtDischargePlanning->id_asesmen = $asesmenTht->id;
            $asesmenThtDischargePlanning->dp_diagnosis_medis = $request->dp_diagnosis_medis;
            $asesmenThtDischargePlanning->dp_usia_lanjut = $request->dp_usia_lanjut;
            $asesmenThtDischargePlanning->dp_hambatan_mobilisasi = $request->dp_hambatan_mobilisasi;
            $asesmenThtDischargePlanning->dp_layanan_medis_lanjutan = $request->dp_layanan_medis_lanjutan;
            $asesmenThtDischargePlanning->dp_tergantung_orang_lain = $request->dp_tergantung_orang_lain;
            $asesmenThtDischargePlanning->dp_lama_dirawat = $request->dp_lama_dirawat;
            $asesmenThtDischargePlanning->dp_rencana_pulang = $request->dp_rencana_pulang;
            $asesmenThtDischargePlanning->dp_kesimpulan = $request->dp_kesimpulan;
            $asesmenThtDischargePlanning->save();

            $thtDiagnosisImplementasi = new RmeAsesmenthtDiagnosisImplementasi();
            $thtDiagnosisImplementasi->id_asesmen = $asesmenTht->id;
            $thtDiagnosisImplementasi->diagnosis_banding = $request->diagnosis_banding;
            $thtDiagnosisImplementasi->diagnosis_kerja = $request->diagnosis_kerja;
            $thtDiagnosisImplementasi->prognosis = $request->prognosis;
            $thtDiagnosisImplementasi->observasi = $request->observasi;
            $thtDiagnosisImplementasi->terapeutik = $request->terapeutik;
            $thtDiagnosisImplementasi->edukasi = $request->edukasi;
            $thtDiagnosisImplementasi->kolaborasi = $request->kolaborasi;
            $thtDiagnosisImplementasi->tht_prognosis = $request->tht_prognosis;
            $thtDiagnosisImplementasi->save();

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

            // RESUME (disesuaikan dengan vital sign dari service, tapi gunakan request untuk konsistensi)
            $resumeData = [
                'anamnesis'             => $request->anamnesis_anamnesis,
                'diagnosis'             => [],
                'tindak_lanjut_code'    => null,
                'tindak_lanjut_name'    => null,
                'tgl_kontrol_ulang'     => null,
                'unit_rujuk_internal'   => null,
                'rs_rujuk'              => null,
                'rs_rujuk_bagian'       => null,
                'konpas'                => [
                    'sistole'   => [
                        'hasil' => $request->darah_sistole
                    ],
                    'distole'   => [
                        'hasil' => $request->darah_diastole
                    ],
                    'respiration_rate'   => [
                        'hasil' => $request->nafas
                    ],
                    'suhu'   => [
                        'hasil' => $request->suhu
                    ],
                    'nadi'   => [
                        'hasil' => $request->nadi
                    ],
                    'tinggi_badan'   => [
                        'hasil' => $request->antropometri_tinggi_badan
                    ],
                    'berat_badan'   => [
                        'hasil' => $request->antropometr_berat_badan
                    ]
                ]
            ];

            $this->createResume($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $resumeData);

            DB::commit();

            return redirect()->route('rawat-inap.asesmen.medis.umum.index', [
                'kd_unit' => request()->route('kd_unit'),
                'kd_pasien' => request()->route('kd_pasien'),
                'tgl_masuk' => request()->route('tgl_masuk'),
                'urut_masuk' => request()->route('urut_masuk'),
            ])->with(['success' => 'Berhasil menambah asesmen THT !']);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    // public function show($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    // {
    //     try {
    //         // Ambil data asesmen beserta relasinya
    //         $asesmen = RmeAsesmen::with([
    //             'user',
    //             'rmeAsesmenTht',
    //             'rmeAsesmenThtPemeriksaanFisik',
    //             'pemeriksaanFisik',
    //             'rmeAsesmenThtRiwayatKesehatanObatAlergi',
    //             'rmeAsesmenThtDischargePlanning',
    //             'rmeAsesmenThtDiagnosisImplementasi',
    //         ])->findOrFail($id);

    //         $dataMedis = Kunjungan::with('pasien')
    //             ->where('kd_pasien', $kd_pasien)
    //             ->where('kd_unit', $kd_unit)
    //             ->whereDate('tgl_masuk', $tgl_masuk)
    //             ->where('urut_masuk', $urut_masuk)
    //             ->firstOrFail();

    //         $itemFisikIds = $asesmen->pemeriksaanFisik->pluck('id_item_fisik')->unique()->toArray();
    //         $itemFisik = MrItemFisik::whereIn('id', $itemFisikIds)->orderBy('urut')->get();
    //         $satsetPrognosis = SatsetPrognosis::all();
    //         $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();

    //         return view('unit-pelayanan.rawat-inap.pelayanan.asesmen-tht.show', compact(
    //             'asesmen',
    //             'dataMedis',
    //             'itemFisik',
    //             'satsetPrognosis',
    //             'alergiPasien',
    //         ));
    //     } catch (ModelNotFoundException $e) {
    //         return back()->with('error', 'Data tidak ditemukan. Detail: ' . $e->getMessage());
    //     } catch (\Exception $e) {
    //         return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    //     }
    // }

    public function show($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            // Cari asesmen berdasarkan ID dengan eager loading untuk semua relasi yang dibutuhkan
            $asesmen = RmeAsesmen::with([
                'user',
                'rmeAsesmenTht',
                'rmeAsesmenThtPemeriksaanFisik',
                'pemeriksaanFisik',
                'rmeAsesmenThtRiwayatKesehatanObatAlergi',
                'rmeAsesmenThtDischargePlanning',
                'rmeAsesmenThtDiagnosisImplementasi',
            ])->findOrFail($id);

            // Pastikan data kunjungan pasien ditemukan dan sesuai dengan parameter
            $dataMedis = Kunjungan::with('pasien')
                ->where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->whereDate('tgl_masuk', date('Y-m-d', strtotime($tgl_masuk)))
                ->where('urut_masuk', $urut_masuk)
                ->firstOrFail();

            // Ambil data pendukung
            $itemFisik = MrItemFisik::orderBy('urut')->get();
            $rmeMasterDiagnosis = RmeMasterDiagnosis::all();
            $rmeMasterImplementasi = RmeMasterImplementasi::all();
            $satsetPrognosis = SatsetPrognosis::all();
            $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();

            // Kirim data ke view
            return view('unit-pelayanan.rawat-inap.pelayanan.asesmen-tht.show', compact(
                'asesmen',
                'dataMedis',
                'itemFisik',
                'rmeMasterDiagnosis',
                'rmeMasterImplementasi',
                'satsetPrognosis',
                'alergiPasien',
            ));
        } catch (\Exception $e) {
            // Tangani error dan berikan pesan yang jelas
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengambil data asesmen: ' . $e->getMessage());
        }
    }

    public function edit($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            // Cari asesmen berdasarkan ID dengan eager loading untuk semua relasi yang dibutuhkan
            $asesmen = RmeAsesmen::with([
                'user',
                'rmeAsesmenTht',
                'rmeAsesmenThtPemeriksaanFisik',
                'pemeriksaanFisik',
                'rmeAsesmenThtRiwayatKesehatanObatAlergi',
                'rmeAsesmenThtDischargePlanning',
                'rmeAsesmenThtDiagnosisImplementasi',
            ])->findOrFail($id);

            // Pastikan data kunjungan pasien ditemukan dan sesuai dengan parameter
            $dataMedis = Kunjungan::with('pasien')
                ->where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->whereDate('tgl_masuk', date('Y-m-d', strtotime($tgl_masuk)))
                ->where('urut_masuk', $urut_masuk)
                ->firstOrFail();

            // Ambil data pendukung
            $itemFisik = MrItemFisik::orderBy('urut')->get();
            $rmeMasterDiagnosis = RmeMasterDiagnosis::all();
            $rmeMasterImplementasi = RmeMasterImplementasi::all();
            $satsetPrognosis = SatsetPrognosis::all();
            $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();

            // Kirim data ke view
            return view('unit-pelayanan.rawat-inap.pelayanan.asesmen-tht.edit', compact(
                'asesmen',
                'dataMedis',
                'itemFisik',
                'rmeMasterDiagnosis',
                'rmeMasterImplementasi',
                'satsetPrognosis',
                'alergiPasien',
            ));
        } catch (\Exception $e) {
            // Tangani error dan berikan pesan yang jelas
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengambil data asesmen: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            $asesmenTht = RmeAsesmen::findOrFail($id);
            $asesmenTht->kd_pasien = $kd_pasien;
            $asesmenTht->kd_unit = $kd_unit;
            $asesmenTht->tgl_masuk = $tgl_masuk;
            $asesmenTht->urut_masuk = $urut_masuk;
            $asesmenTht->user_id = Auth::id();
            $asesmenTht->waktu_asesmen = date('Y-m-d H:i:s');
            $asesmenTht->kategori = 1;
            $asesmenTht->sub_kategori = 5;
            $asesmenTht->save();

            $request->validate([
                'hasil_pemeriksaan_penunjang_darah' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
                'hasil_pemeriksaan_penunjang_urine' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
                'hasil_pemeriksaan_penunjang_rontgent' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
                'hasil_pemeriksaan_penunjang_histopatology' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048'
            ]);

            $asesmenThtDataMasuk = RmeAsesmenTht::firstOrNew(['id_asesmen' => $asesmenTht->id]);
            $asesmenThtDataMasuk->id_asesmen = $asesmenTht->id;
            $asesmenThtDataMasuk->tgl_masuk = "$request->tgl_masuk $request->jam_masuk";
            $asesmenThtDataMasuk->kondisi_masuk = $request->kondisi_masuk;
            $asesmenThtDataMasuk->ruang = $request->ruang;
            $asesmenThtDataMasuk->anamnesis_anamnesis = $request->anamnesis_anamnesis;
            $asesmenThtDataMasuk->evaluasi_evaluasi_keperawatan = $request->evaluasi_evaluasi_keperawatan;
            $asesmenThtDataMasuk->penyakit_sekarang = $request->penyakit_sekarang;
            $asesmenThtDataMasuk->penyakit_terdahulu = $request->penyakit_terdahulu;
            $asesmenThtDataMasuk->rencana_penatalaksanaan = $request->rencana_penatalaksanaan;
            $asesmenThtDataMasuk->darah = $request->darah;
            $asesmenThtDataMasuk->urine = $request->urine;
            $asesmenThtDataMasuk->rontgent = $request->rontgent;
            $asesmenThtDataMasuk->gistopatology = $request->gistopatology;

            $fileFields = [
                'hasil_pemeriksaan_penunjang_darah',
                'hasil_pemeriksaan_penunjang_urine',
                'hasil_pemeriksaan_penunjang_rontgent',
                'hasil_pemeriksaan_penunjang_histopatology'
            ];

            // Array untuk menyimpan path file yang berhasil diupload
            $uploadedFiles = [];

            // Fungsi helper untuk upload file
            $uploadFile = function ($fieldName) use ($request, &$uploadedFiles, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk) {
                if ($request->hasFile($fieldName)) {
                    try {
                        $file = $request->file($fieldName);
                        $path = $file->store("uploads/ranap/asesmen-tht/$kd_unit/$kd_pasien/$tgl_masuk/$urut_masuk");

                        if ($path) {
                            return $path;
                        }
                    } catch (\Exception $e) {
                        throw new \Exception("Gagal mengupload file {$fieldName}");
                    }
                }
                return null;
            };

            $fileFields = [
                'hasil_pemeriksaan_penunjang_darah',
                'hasil_pemeriksaan_penunjang_urine',
                'hasil_pemeriksaan_penunjang_rontgent',
                'hasil_pemeriksaan_penunjang_histopatology'
            ];

            foreach ($fileFields as $field) {
                if ($request->has("delete_$field")) {
                    if ($asesmenThtDataMasuk->$field) {
                        Storage::disk('public')->delete(
                            "uploads/ranap/asesmen-tht/$kd_unit/$kd_pasien/$tgl_masuk/$urut_masuk/" . $asesmenThtDataMasuk->$field
                        );
                        $asesmenThtDataMasuk->$field = null;
                    }
                } elseif ($request->hasFile($field)) {
                    try {
                        if ($asesmenThtDataMasuk->$field) {
                            Storage::disk('public')->delete(
                                "uploads/ranap/asesmen-tht/$kd_unit/$kd_pasien/$tgl_masuk/$urut_masuk/" . $asesmenThtDataMasuk->$field
                            );
                        }

                        $path = $uploadFile($field);
                        if ($path) {
                            $asesmenThtDataMasuk->$field = basename($path);
                            $uploadedFiles[$field] = $path;
                        }
                    } catch (\Exception $e) {
                        throw new \Exception("Gagal mengupload file $field: " . $e->getMessage());
                    }
                }
            }
            $asesmenThtDataMasuk->save();

            $asesmenThtPemeriksaanFisik = RmeAsesmenThtPemeriksaanFisik::firstOrNew(['id_asesmen' => $asesmenTht->id]);
            $asesmenThtPemeriksaanFisik->id_asesmen = $asesmenTht->id;
            $asesmenThtPemeriksaanFisik->darah_sistole = $request->darah_sistole;
            $asesmenThtPemeriksaanFisik->darah_diastole = $request->darah_diastole;
            $asesmenThtPemeriksaanFisik->nadi = $request->nadi;
            $asesmenThtPemeriksaanFisik->nafas = $request->nafas;
            $asesmenThtPemeriksaanFisik->suhu = $request->suhu;
            $asesmenThtPemeriksaanFisik->sensorium = $request->sensorium;
            $asesmenThtPemeriksaanFisik->ku_kp_kg = $request->ku_kp_kg;
            $asesmenThtPemeriksaanFisik->avpu = $request->avpu;
            $asesmenThtPemeriksaanFisik->pangkal_lidah = $request->pangkal_lidah;
            $asesmenThtPemeriksaanFisik->tonsil_lidah = $request->tonsil_lidah;
            $asesmenThtPemeriksaanFisik->epiglotis = $request->epiglotis;
            $asesmenThtPemeriksaanFisik->pita_suara = $request->pita_suara;
            // Daun Telinga
            $asesmenThtPemeriksaanFisik->daun_telinga_nanah_kana = $request->daun_telinga_nanah_kana;
            $asesmenThtPemeriksaanFisik->daun_telinga_nanah_kiri = $request->daun_telinga_nanah_kiri;
            $asesmenThtPemeriksaanFisik->daun_telinga_darah_kanan = $request->daun_telinga_darah_kanan;
            $asesmenThtPemeriksaanFisik->daun_telinga_darah_kiri = $request->daun_telinga_darah_kiri;
            $asesmenThtPemeriksaanFisik->daun_telinga_lainnya_kanan = $request->daun_telinga_lainnya_kanan;
            $asesmenThtPemeriksaanFisik->daun_telinga_lainnya_kiri = $request->daun_telinga_lainnya_kiri;
            // Liang Telinga
            $asesmenThtPemeriksaanFisik->liang_telinga_darah_kanan = $request->liang_telinga_darah_kanan;
            $asesmenThtPemeriksaanFisik->liang_telinga_darah_kiri = $request->liang_telinga_darah_kiri;
            $asesmenThtPemeriksaanFisik->liang_telinga_nanah_kanan = $request->liang_telinga_nanah_kanan;
            $asesmenThtPemeriksaanFisik->liang_telinga_nanah_kiri = $request->liang_telinga_nanah_kiri;
            $asesmenThtPemeriksaanFisik->liang_telinga_berbau_kanan = $request->liang_telinga_berbau_kanan;
            $asesmenThtPemeriksaanFisik->liang_telinga_berbau_kiri = $request->liang_telinga_berbau_kiri;
            $asesmenThtPemeriksaanFisik->liang_telinga_lainnya_kanan = $request->liang_telinga_lainnya_kanan;
            $asesmenThtPemeriksaanFisik->liang_telinga_lainnya_kiri = $request->liang_telinga_lainnya_kiri;
            // Tes Pendengaran
            $asesmenThtPemeriksaanFisik->tes_pendengaran_renne_res_kanan = $request->tes_pendengaran_renne_res_kanan;
            $asesmenThtPemeriksaanFisik->tes_pendengaran_renne_res_kiri = $request->tes_pendengaran_renne_res_kiri;
            $asesmenThtPemeriksaanFisik->tes_pendengaran_weber_tes_kanan = $request->tes_pendengaran_renne_res_kiri;
            $asesmenThtPemeriksaanFisik->tes_pendengaran_weber_tes_kiri = $request->tes_pendengaran_renne_res_kiri;
            $asesmenThtPemeriksaanFisik->tes_pendengaran_schwabach_test_kanan = $request->tes_pendengaran_renne_res_kiri;
            $asesmenThtPemeriksaanFisik->tes_pendengaran_schwabach_test_kiri = $request->tes_pendengaran_renne_res_kiri;
            $asesmenThtPemeriksaanFisik->tes_pendengaran_bebisik_kanan = $request->tes_pendengaran_renne_res_kiri;
            $asesmenThtPemeriksaanFisik->tes_pendengaran_bebisik_kiri = $request->tes_pendengaran_renne_res_kiri;
            // Paranatal Sinus
            $asesmenThtPemeriksaanFisik->senus_frontalis_nyeri_tekan_kanan = $request->senus_frontalis_nyeri_tekan_kanan;
            $asesmenThtPemeriksaanFisik->senus_frontalis_nyeri_tekan_kiri = $request->senus_frontalis_nyeri_tekan_kiri;
            $asesmenThtPemeriksaanFisik->senus_frontalis_transluminasi_kanan = $request->senus_frontalis_transluminasi_kanan;
            $asesmenThtPemeriksaanFisik->senus_frontalis_transluminasi_kiri = $request->senus_frontalis_transluminasi_kanan;
            // Sinus Maksinasi
            $asesmenThtPemeriksaanFisik->sinus_maksinasi_nyari_tekan_kanan = $request->sinus_maksinasi_nyari_tekan_kanan;
            $asesmenThtPemeriksaanFisik->sinus_maksinasi_nyari_tekan_kiri = $request->sinus_maksinasi_nyari_tekan_kiri;
            $asesmenThtPemeriksaanFisik->sinus_maksinasi_transluminasi_kanan = $request->sinus_maksinasi_nyari_tekan_kiri;
            $asesmenThtPemeriksaanFisik->sinus_maksinasi_transluminasi_kiri = $request->sinus_maksinasi_nyari_tekan_kiri;
            // Rhinoscopi Anterior
            $asesmenThtPemeriksaanFisik->rhinoscopi_anterior_cavun_nasi_kanan = $request->rhinoscopi_anterior_cavun_nasi_kanan;
            $asesmenThtPemeriksaanFisik->rhinoscopi_anterior_cavun_nasi_kiri = $request->rhinoscopi_anterior_cavun_nasi_kanan;
            $asesmenThtPemeriksaanFisik->rhinoscopi_anterior_konka_inferior_kanan = $request->rhinoscopi_anterior_konka_inferior_kanan;
            $asesmenThtPemeriksaanFisik->rhinoscopi_anterior_konka_inferior_kiri = $request->rhinoscopi_anterior_konka_inferior_kiri;
            $asesmenThtPemeriksaanFisik->rhinoscopi_anterior_septum_nasi_kanan = $request->rhinoscopi_anterior_konka_inferior_kiri;
            $asesmenThtPemeriksaanFisik->rhinoscopi_anterior_septum_nasi_kiri = $request->rhinoscopi_anterior_konka_inferior_kiri;
            // Rhinoscopi Pasterior
            $asesmenThtPemeriksaanFisik->rhinoscopi_pasterior_septum_nasi_kanan = $request->rhinoscopi_pasterior_septum_nasi_kanan;
            $asesmenThtPemeriksaanFisik->rhinoscopi_pasterior_septum_nasi_kiri = $request->rhinoscopi_pasterior_septum_nasi_kiri;
            $asesmenThtPemeriksaanFisik->rhinoscopi_superior_kanan = $request->rhinoscopi_superior_kanan;
            $asesmenThtPemeriksaanFisik->rhinoscopi_superior_kiri = $request->rhinoscopi_superior_kiri;
            $asesmenThtPemeriksaanFisik->rhinoscopi_media_kanan = $request->rhinoscopi_media_kanan;
            $asesmenThtPemeriksaanFisik->rhinoscopi_media_kiri = $request->rhinoscopi_media_kiri;
            $asesmenThtPemeriksaanFisik->rhinoscopi_fasso_rossenmuler_kanan = $request->rhinoscopi_fasso_rossenmuler_kanan;
            $asesmenThtPemeriksaanFisik->rhinoscopi_fasso_rossenmuler_kiri = $request->rhinoscopi_fasso_rossenmuler_kiri;
            // Meatus Nasi
            $asesmenThtPemeriksaanFisik->meatus_nasi_superior_kanan = $request->meatus_nasi_superior_kanan;
            $asesmenThtPemeriksaanFisik->meatus_nasi_superior_kiri = $request->meatus_nasi_superior_kiri;
            $asesmenThtPemeriksaanFisik->meatus_nasi_media_kanan = $request->meatus_nasi_media_kanan;
            $asesmenThtPemeriksaanFisik->meatus_nasi_media_kiri = $request->meatus_nasi_media_kiri;
            $asesmenThtPemeriksaanFisik->meatus_nasi_inferior_kanan = $request->meatus_nasi_inferior_kanan;
            $asesmenThtPemeriksaanFisik->meatus_nasi_inferior_kiri = $request->meatus_nasi_inferior_kiri;
            // Membran Tympani
            $asesmenThtPemeriksaanFisik->membran_tympani_warna_kanan = $request->membran_tympani_warna_kanan;
            $asesmenThtPemeriksaanFisik->membran_tympani_warna_kiri = $request->membran_tympani_warna_kiri;
            $asesmenThtPemeriksaanFisik->membran_tympani_perforasi_kanan = $request->membran_tympani_perforasi_kanan;
            $asesmenThtPemeriksaanFisik->membran_tympani_perforasi_kiri = $request->membran_tympani_perforasi_kiri;
            $asesmenThtPemeriksaanFisik->membran_tympani_lainnya_kanan = $request->membran_tympani_lainnya_kanan;
            $asesmenThtPemeriksaanFisik->membran_tympani_lainnya_kiri = $request->membran_tympani_lainnya_kiri;
            // Hidung
            $asesmenThtPemeriksaanFisik->hidung_bentuk_kanan = $request->hidung_bentuk_kanan;
            $asesmenThtPemeriksaanFisik->hidung_bentuk_kiri = $request->hidung_bentuk_kiri;
            $asesmenThtPemeriksaanFisik->hidung_luka_kanan = $request->hidung_luka_kanan;
            $asesmenThtPemeriksaanFisik->hidung_luka_kiri = $request->hidung_luka_kiri;
            $asesmenThtPemeriksaanFisik->hidung_bisul_kanan = $request->hidung_bisul_kanan;
            $asesmenThtPemeriksaanFisik->hidung_bisul_kiri = $request->hidung_bisul_kiri;
            $asesmenThtPemeriksaanFisik->hidung_fissare_kanan = $request->hidung_fissare_kanan;
            $asesmenThtPemeriksaanFisik->hidung_fissare_kiri = $request->hidung_fissare_kiri;
            // Antropometri
            $asesmenThtPemeriksaanFisik->antropometri_tinggi_badan = $request->antropometri_tinggi_badan;
            $asesmenThtPemeriksaanFisik->antropometr_berat_badan = $request->antropometr_berat_badan;
            $asesmenThtPemeriksaanFisik->antropometri_imt = $request->antropometri_imt;
            $asesmenThtPemeriksaanFisik->antropometri_lpt = $request->antropometri_lpt;

            // Plica vokalis
            $asesmenThtPemeriksaanFisik->plica_vokalis_bentuk_kanan = $request->plica_vokalis_bentuk_kanan;
            $asesmenThtPemeriksaanFisik->plica_vokalis_bentuk_kiri = $request->plica_vokalis_bentuk_kiri;
            $asesmenThtPemeriksaanFisik->plica_vokalis_warna_kanan = $request->plica_vokalis_warna_kanan;
            $asesmenThtPemeriksaanFisik->plica_vokalis_warna_kiri = $request->plica_vokalis_warna_kiri;


            $asesmenThtPemeriksaanFisik->save();

            // Update ke table RmePemeriksaanFisik
            $itemFisik = MrItemFisik::all();
            foreach ($itemFisik as $item) {
                $itemName = strtolower($item->nama);
                $isNormal = $request->has($item->id . '-normal') ? 1 : 0;
                $keterangan = $request->input($item->id . '_keterangan');
                if ($isNormal) $keterangan = '';

                RmeAsesmenPemeriksaanFisik::updateOrCreate(
                    [
                        'id_asesmen' => $asesmenTht->id,
                        'id_item_fisik' => $item->id
                    ],
                    [
                        'is_normal' => $isNormal,
                        'keterangan' => $keterangan
                    ]
                );
            }

            $asesmenThtRiwayatKesehatanObatAlergi = RmeAsesmenThtRiwayatKesehatanObatAlergi::firstOrNew(['id_asesmen' => $asesmenTht->id]);
            $asesmenThtRiwayatKesehatanObatAlergi->id_asesmen = $asesmenTht->id;
            $penyakitDiderita = $request->riwayat_kesehatan_penyakit_diderita;
            if ($penyakitDiderita) {
                $decodedPenyakit = json_decode($penyakitDiderita);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $asesmenThtRiwayatKesehatanObatAlergi->riwayat_kesehatan_penyakit_diderita = $penyakitDiderita;
                } else {
                    throw new \Exception('Invalid JSON format for penyakit_diderita');
                }
            } else {
                $asesmenThtRiwayatKesehatanObatAlergi->riwayat_kesehatan_penyakit_diderita = null;
            }

            $penyakitKeluarga = $request->riwayat_kesehatan_penyakit_keluarga;
            if ($penyakitKeluarga) {
                // Validasi JSON string
                $decodedPenyakit = json_decode($penyakitKeluarga);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $asesmenThtRiwayatKesehatanObatAlergi->riwayat_kesehatan_penyakit_keluarga = $penyakitKeluarga;
                } else {
                    throw new \Exception('Invalid JSON format for penyakit_Keluarga');
                }
            } else {
                $asesmenThtRiwayatKesehatanObatAlergi->riwayat_kesehatan_penyakit_keluarga = null;
            }

            $riwayatObat = $request->riwayat_penggunaan_obat;
            if ($riwayatObat) {
                $decodedObat = json_decode($riwayatObat, true);


                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new \Exception('Format JSON untuk riwayat obat tidak valid');
                }

                // Validasi struktur data
                foreach ($decodedObat as $obat) {
                    if (!isset(
                        $obat['namaObat'],
                        $obat['dosis'],
                        $obat['satuan'],
                        $obat['frekuensi'],
                        $obat['keterangan']
                    )) {
                        throw new \Exception('Data obat tidak lengkap');
                    }
                }

                $asesmenThtRiwayatKesehatanObatAlergi->riwayat_penggunaan_obat = $riwayatObat;
            } else {
                $asesmenThtRiwayatKesehatanObatAlergi->riwayat_penggunaan_obat = null;
            }

            $dataAlergi = $request->alergi;
            if ($dataAlergi) {
                $decodedObat = json_decode($dataAlergi, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new \Exception('Format JSON untuk alergi tidak valid');
                }

                // Validasi struktur data
                foreach ($decodedObat as $obat) {
                    if (!isset(
                        $obat['alergen'],
                        $obat['reaksi'],
                        $obat['severe'],
                    )) {
                        throw new \Exception('Data alergi tidak lengkap');
                    }
                }

                $asesmenThtRiwayatKesehatanObatAlergi->alergi = $dataAlergi;
            } else {
                $asesmenThtRiwayatKesehatanObatAlergi->alergi = null;
            }
            $asesmenThtRiwayatKesehatanObatAlergi->save();

            $asesmenThtDischargePlanning = RmeAsesmenThtDischargePlanning::firstOrNew(['id_asesmen' => $asesmenTht->id]);
            $asesmenThtDischargePlanning->id_asesmen = $asesmenTht->id;
            $asesmenThtDischargePlanning->dp_diagnosis_medis = $request->dp_diagnosis_medis;
            $asesmenThtDischargePlanning->dp_usia_lanjut = $request->dp_usia_lanjut;
            $asesmenThtDischargePlanning->dp_hambatan_mobilisasi = $request->dp_hambatan_mobilisasi;
            $asesmenThtDischargePlanning->dp_layanan_medis_lanjutan = $request->dp_layanan_medis_lanjutan;
            $asesmenThtDischargePlanning->dp_tergantung_orang_lain = $request->dp_tergantung_orang_lain;
            $asesmenThtDischargePlanning->dp_lama_dirawat = $request->dp_lama_dirawat;
            $asesmenThtDischargePlanning->dp_rencana_pulang = $request->dp_rencana_pulang;
            $asesmenThtDischargePlanning->dp_kesimpulan = $request->dp_kesimpulan;
            $asesmenThtDischargePlanning->save();

            $thtDiagnosisImplementasi = RmeAsesmenthtDiagnosisImplementasi::firstOrNew(['id_asesmen' => $asesmenTht->id]);
            $thtDiagnosisImplementasi->id_asesmen = $asesmenTht->id;
            $thtDiagnosisImplementasi->diagnosis_banding = $request->diagnosis_banding;
            $thtDiagnosisImplementasi->diagnosis_kerja = $request->diagnosis_kerja;
            $thtDiagnosisImplementasi->prognosis = $request->prognosis;
            $thtDiagnosisImplementasi->observasi = $request->observasi;
            $thtDiagnosisImplementasi->terapeutik = $request->terapeutik;
            $thtDiagnosisImplementasi->edukasi = $request->edukasi;
            $thtDiagnosisImplementasi->kolaborasi = $request->kolaborasi;
            $thtDiagnosisImplementasi->tht_prognosis = $request->tht_prognosis;
            $thtDiagnosisImplementasi->save();

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
                        'hasil' => $request->darah_sistole
                    ],
                    'distole'   => [
                        'hasil' => $request->darah_diastole
                    ],
                    'respiration_rate'   => [
                        'hasil' => ''
                    ],
                    'suhu'   => [
                        'hasil' => $request->suhu
                    ],
                    'nadi'   => [
                        'hasil' => $request->nadi
                    ],
                    'tinggi_badan'   => [
                        'hasil' => $request->antropometri_tinggi_badan
                    ],
                    'berat_badan'   => [
                        'hasil' => $request->antropometr_berat_badan
                    ]
                ]
            ];

            $this->createResume($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $resumeData);

            DB::commit();

            return redirect()->route('rawat-inap.asesmen.medis.umum.index', [
                'kd_unit' => request()->route('kd_unit'),
                'kd_pasien' => request()->route('kd_pasien'),
                'tgl_masuk' => request()->route('tgl_masuk'),
                'urut_masuk' => request()->route('urut_masuk'),
            ])->with(['success' => 'Berhasil mengupdate asesmen THT!']);
        } catch (\Exception $e) {

            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function generatePDF($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            $asesmenTht = RmeAsesmen::with([
                'user',
                'rmeAsesmenTht',
                'rmeAsesmenThtPemeriksaanFisik',
                'pemeriksaanFisik',
                'rmeAsesmenThtRiwayatKesehatanObatAlergi',
                'rmeAsesmenThtDischargePlanning',
                'rmeAsesmenThtDiagnosisImplementasi',
            ])->where('id', $id)->first();

            $dataMedis = Kunjungan::with('pasien')
                ->where('kd_unit', $kd_unit)
                ->where('kd_pasien', $kd_pasien)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->first();

            $pdf = PDF::loadView('unit-pelayanan.rawat-inap.pelayanan.asesmen-tht.print', [
                'asesmen'    => $asesmenTht ?? null,
                'pasien' => optional($dataMedis)->pasien ?? null,
                'dataMedis' => $dataMedis ?? null,
                // variabel lainnya sesuai kebutuhan
                'rmeAsesmenTht'                     => optional($asesmenTht)->rmeAsesmenTht ?? null,
                'rmeAsesmenThtPemeriksaanFisik'     => optional($asesmenTht)->rmeAsesmenThtPemeriksaanFisik ?? null,
                'pemeriksaanFisik'                  => optional($asesmenTht)->pemeriksaanFisik ?? null,
                'rmeAsesmenThtRiwayatKesehatanObatAlergi' => optional($asesmenTht)->rmeAsesmenThtRiwayatKesehatanObatAlergi ?? null,
                'rmeAsesmenThtDischargePlanning'    => optional($asesmenTht)->rmeAsesmenThtDischargePlanning ?? null,
                'rmeAsesmenThtDiagnosisImplementasi' => optional($asesmenTht)->rmeAsesmenThtDiagnosisImplementasi ?? null,
            ]);

            $pdf->setPaper('a4', 'portrait');
            $pdf->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled'      => true,
                'defaultFont'          => 'sans-serif'
            ]);

            return $pdf->stream("asesmen-tht-{$id}-print-pdf.pdf");
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