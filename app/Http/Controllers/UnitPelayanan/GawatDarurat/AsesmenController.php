<?php

namespace App\Http\Controllers\UnitPelayanan\GawatDarurat;

use App\Http\Controllers\Controller;
use App\Models\AptObat;
use App\Models\DataTriase;
use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\ListTindakanPasien;
use App\Models\MrItemFisik;
use App\Models\RmeAlergiPasien;
use App\Models\RmeAsesmen;
use App\Models\RmeAsesmenDtl;
use App\Models\RmeAsesmenPemeriksaanFisik;
use App\Models\RmeEfekNyeri;
use App\Models\RmeFaktorPemberat;
use App\Models\RmeFaktorPeringan;
use App\Models\RmeFrekuensiNyeri;
use App\Models\RmeJenisNyeri;
use App\Models\RmeKualitasNyeri;
use App\Models\RmeMenjalar;
use App\Models\RmeRekonsiliasiObat;
use App\Models\RMEResume;
use App\Models\RmeResumeDtl;
use App\Models\RmeSpri;
use App\Models\SegalaOrder;
use App\Models\Unit;
use App\Services\AsesmenService;
use App\Services\BaseService;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AsesmenController extends Controller
{
    private $kdUnit;
    private $asesmenService;
    private $baseService;

    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/gawat-darurat');
        $this->kdUnit = 3; // Gawat Darurat
        $this->asesmenService = new AsesmenService();
        $this->baseService = new BaseService();
    }

    public function index($kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $user = auth()->user();

        // Mengambil data kunjungan dan tanggal triase terkait
        $dataMedis = $this->baseService->getDataMedis($this->kdUnit, $kd_pasien, $tgl_masuk, $urut_masuk);

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
        $riwayatObat = $this->getRiwayatObat($dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk);
        $laborData = $this->getLabor($dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk);
        $radiologiData = $this->getRadiologi($dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk);
        $itemFisik = MrItemFisik::orderby('urut')->get();
        $menjalar = RmeMenjalar::all();
        $frekuensinyeri = RmeFrekuensiNyeri::all();
        $kualitasnyeri = RmeKualitasNyeri::all();
        $faktorpemberat = RmeFaktorPemberat::all();
        $faktorperingan = RmeFaktorPeringan::all();
        $efeknyeri = RmeEfekNyeri::all();
        $unitPoli = Unit::where('kd_bagian', '2')->where('aktif', 1)->get();

        // Mengambil asesmen dengan join ke data_triase untuk mendapatkan tanggal_triase
        $asesmen = RmeAsesmen::with(['user'])
            ->leftJoin('data_triase', 'RME_ASESMEN.id', '=', 'data_triase.id_asesmen')
            ->where('RME_ASESMEN.kd_pasien', $dataMedis->kd_pasien)
            ->where('RME_ASESMEN.kd_unit', $this->kdUnit)
            ->whereDate('RME_ASESMEN.tgl_masuk', $dataMedis->tgl_masuk)
            ->where('RME_ASESMEN.urut_masuk', $dataMedis->urut_masuk)
            ->select(
                'RME_ASESMEN.*',
                'data_triase.tanggal_triase',
                'data_triase.id as id_triase'
            )
            ->orderBy('RME_ASESMEN.waktu_asesmen', 'desc')
            ->get();

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen.index', compact(
            'dataMedis',
            'riwayatObat',
            'laborData',
            'radiologiData',
            'itemFisik',
            'menjalar',
            'frekuensinyeri',
            'kualitasnyeri',
            'faktorpemberat',
            'faktorperingan',
            'efeknyeri',
            'asesmen',
            'unitPoli',
        ));
    }


    public function create(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->baseService->getDataMedis($this->kdUnit, $kd_pasien, $tgl_masuk, $urut_masuk);

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        // Ambil data triase terakhir untuk pasien yang sama
        $latestTriase = DataTriase::where('kd_pasien_triase', $kd_pasien)
            ->whereNotNull('vital_sign')
            ->orderBy('tanggal_triase', 'desc')
            ->first();

        // Parse vital sign dari triase jika ada
        $triaseVitalSign = null;
        if ($latestTriase && $latestTriase->vital_sign) {
            try {
                $triaseVitalSign = json_decode($latestTriase->vital_sign, true);
            } catch (Exception $e) {
                $triaseVitalSign = null;
            }
        }

        $dokter = Dokter::where('status', 1)->get();
        $triageClass = $this->getTriageClass($dataMedis->kd_triase);
        $menjalar = RmeMenjalar::all();
        $frekuensinyeri = RmeFrekuensiNyeri::all();
        $kualitasnyeri = RmeKualitasNyeri::all();
        $faktorpemberat = RmeFaktorPemberat::all();
        $faktorperingan = RmeFaktorPeringan::all();
        $efeknyeri = RmeEfekNyeri::all();
        $jenisnyeri = RmeJenisNyeri::all();
        $itemFisik = MrItemFisik::orderby('urut')->get();
        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();
        $unitPoli = Unit::where('kd_bagian', '2')->where('aktif', 1)->get();
        $laborData = $this->getLabor($dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk);
        $radiologiData = $this->getRadiologi($dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk);

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen.create', compact(
            'dataMedis',
            'triageClass',
            'dokter',
            'menjalar',
            'frekuensinyeri',
            'kualitasnyeri',
            'faktorpemberat',
            'faktorperingan',
            'efeknyeri',
            'jenisnyeri',
            'alergiPasien',
            'unitPoli',
            'itemFisik',
            'triaseVitalSign',
            'laborData',
            'radiologiData'
        ));
    }

    public function edit(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        // Ambil data kunjungan
        $dataMedis = $this->baseService->getDataMedis($this->kdUnit, $kd_pasien, $tgl_masuk, $urut_masuk);

        if (!$dataMedis) {
            abort(404, 'Data kunjungan tidak ditemukan');
        }

        // Ambil data asesmen
        $asesmen = RmeAsesmen::with([
            'menjalar',
            'frekuensiNyeri',
            'kualitasNyeri',
            'faktorPemberat',
            'faktorPeringan',
            'efekNyeri',
            'pemeriksaanFisik',
            'pemeriksaanFisik.itemFisik'
        ])->where('id', $id)->first();

        if (!$asesmen) {
            abort(404, 'Data asesmen tidak ditemukan');
        }

        // PERBAIKAN: Ambil tindak lanjut sebagai single record
        $tindakLanjutData = RmeAsesmenDtl::where('id_asesmen', $id)->first();

        // Set ke asesmen untuk konsistensi dengan view
        $asesmen->tindaklanjut = $tindakLanjutData;

        // Hitung umur pasien
        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        // Parse data JSON dari asesmen
        $tindakanResusitasi = $this->parseJsonSafely($asesmen->tindakan_resusitasi);
        $vitalSign = $this->parseJsonSafely($asesmen->vital_sign);
        $antropometri = $this->parseJsonSafely($asesmen->antropometri);
        $diagnosis = $this->parseJsonSafely($asesmen->diagnosis);
        $alatTerpasang = $this->parseJsonSafely($asesmen->alat_terpasang);

        // Data lainnya
        $retriaseData = DataTriase::where('id_asesmen', $id)->get();
        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();
        $pemeriksaanFisikData = RmeAsesmenPemeriksaanFisik::where('id_asesmen', $id)
            ->get()
            ->keyBy('id_item_fisik');

        // Data master
        $dokter = Dokter::where('status', 1)->get();
        $triageClass = $this->getTriageClass($dataMedis->kd_triase);
        $menjalar = RmeMenjalar::all();
        $frekuensinyeri = RmeFrekuensiNyeri::all();
        $kualitasnyeri = RmeKualitasNyeri::all();
        $faktorpemberat = RmeFaktorPemberat::all();
        $faktorperingan = RmeFaktorPeringan::all();
        $efeknyeri = RmeEfekNyeri::all();
        $jenisnyeri = RmeJenisNyeri::all();
        $itemFisik = MrItemFisik::orderby('urut')->get();
        $unitPoli = Unit::where('kd_bagian', '2')->where('aktif', 1)->get();
        $laborData = $this->getLabor($dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk);
        $radiologiData = $this->getRadiologi($dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk);

        // Triase untuk fallback
        $latestTriase = DataTriase::where('kd_pasien_triase', $kd_pasien)
            ->whereNotNull('vital_sign')
            ->orderBy('tanggal_triase', 'desc')
            ->first();

        $triaseVitalSign = null;
        if ($latestTriase && $latestTriase->vital_sign) {
            try {
                $triaseVitalSign = json_decode($latestTriase->vital_sign, true);
            } catch (Exception $e) {
                $triaseVitalSign = null;
            }
        }

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen.edit', compact(
            'dataMedis',
            'asesmen',
            'triageClass',
            'dokter',
            'menjalar',
            'frekuensinyeri',
            'kualitasnyeri',
            'faktorpemberat',
            'faktorperingan',
            'efeknyeri',
            'jenisnyeri',
            'alergiPasien',
            'unitPoli',
            'itemFisik',
            'triaseVitalSign',
            'tindakanResusitasi',
            'vitalSign',
            'antropometri',
            'diagnosis',
            'alatTerpasang',
            'retriaseData',
            'pemeriksaanFisikData',
            'laborData',
            'radiologiData'
        ));
    }

    public function update(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            $user = auth()->user();

            // Validasi asesmen exists
            $asesmen = RmeAsesmen::where('id', $id)->first();
            if (!$asesmen) {
                return back()->with('error', 'Asesmen tidak ditemukan');
            }

            // Get data medis untuk referensi
            $dataMedis = $this->baseService->getDataMedis($this->kdUnit, $kd_pasien, $tgl_masuk, $urut_masuk);

            if (!$dataMedis) {
                return back()->with('error', 'Data kunjungan tidak ditemukan');
            }

            // Hitung umur pasien
            if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
                $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
            } else {
                $dataMedis->pasien->umur = 'Tidak Diketahui';
            }

            // Update data asesmen
            $tanggalMasuk = $request->tanggal_masuk ?? date('Y-m-d');
            $jamMasuk = $request->jam_masuk ?? date('H:i');
            $waktuAsesmen = $tanggalMasuk . ' ' . $jamMasuk . ':00';

            $asesmen->waktu_asesmen = $waktuAsesmen;
            $asesmen->tindakan_resusitasi = json_encode($request->tindakan_resusitasi) ?? '';
            $asesmen->anamnesis = $request->keluhan_utama;
            $asesmen->riwayat_penyakit = $request->riwayat_penyakit;
            $asesmen->riwayat_penyakit_keluarga = $request->riwayat_penyakit_keluarga;
            $asesmen->riwayat_pengobatan = $request->riwayat_pengobatan;

            // Format vital_sign sesuai struktur yang diinginkan
            $vitalSignData = [
                'td_sistole' => $request->vital_sign['td_sistole'] ?? '',
                'td_diastole' => $request->vital_sign['td_diastole'] ?? '',
                'nadi' => $request->vital_sign['nadi'] ?? '',
                'temp' => $request->vital_sign['suhu'] ?? '',
                'rr' => $request->vital_sign['respirasi'] ?? '',
                'spo2_tanpa_o2' => $request->vital_sign['spo2_tanpa_o2'] ?? '',
                'spo2_dengan_o2' => $request->vital_sign['spo2_dengan_o2'] ?? '',
                'gcs' => $request->vital_sign['gcs'] ?? ''
            ];

            $asesmen->vital_sign = json_encode($vitalSignData);
            $asesmen->antropometri = json_encode($request->antropometri);
            $asesmen->skala_nyeri = $request->skala_nyeri_nilai;
            $asesmen->lokasi = $request->lokasi;
            $asesmen->durasi = $request->durasi;
            $asesmen->menjalar_id = $request->menjalar;
            $asesmen->frekuensi_nyeri_id = $request->frekuensi;
            $asesmen->kualitas_nyeri_id = $request->kualitas;
            $asesmen->faktor_pemberat_id = $request->faktor_pemberat;
            $asesmen->faktor_peringan_id = $request->faktor_peringan;
            $asesmen->efek_nyeri = $request->efek_nyeri;
            $asesmen->jenis_nyeri_id = $request->jenis_nyeri;
            $asesmen->diagnosis = $request->diagnosa_data ? json_encode($request->diagnosa_data) : null;
            $asesmen->alat_terpasang = $request->alat_terpasang_data;
            $asesmen->kondisi_pasien = $request->kondisi_pasien;
            $asesmen->user_id = $user->id;
            $asesmen->save();

            // Update alergi pasien
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

            // Update pemeriksaan fisik
            RmeAsesmenPemeriksaanFisik::where('id_asesmen', $id)->delete();
            $itemFisik = MrItemFisik::all();
            foreach ($itemFisik as $item) {
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

            // Update data retriase
            DataTriase::where('id_asesmen', $id)->delete();
            $retriaseData = json_decode($request->retriase_data, true);
            if ($retriaseData && !empty($retriaseData)) {
                foreach ($retriaseData as $retriase) {
                    $newRetriase = new DataTriase();
                    $newRetriase->id_asesmen = $asesmen->id;
                    $newRetriase->nama_pasien = $dataMedis->pasien->nama;
                    $newRetriase->usia = $dataMedis->pasien->umur;
                    $newRetriase->jenis_kelamin = $dataMedis->pasien->jenis_kelamin;
                    $newRetriase->tanggal_lahir = $dataMedis->pasien->tgl_lahir;

                    // Format tanggal dari form retriase
                    $tanggalJam = $retriase['tanggal'] . ' ' . $retriase['jam'] . ':00';
                    $newRetriase->tanggal_triase = $tanggalJam;

                    $newRetriase->dokter_triase = $dataMedis->dokter->kd_dokter ?? null;
                    $newRetriase->kd_pasien_triase = $dataMedis->kd_pasien;
                    $newRetriase->status = $dataMedis->status;
                    $newRetriase->usia_bulan = $dataMedis->usia_bulan;
                    $newRetriase->foto_pasien = $dataMedis->foto_pasien;

                    // Kesimpulan triase
                    $newRetriase->kode_triase = $retriase['kesimpulan_triase'] ?? null;
                    $newRetriase->hasil_triase = $retriase['kesimpulan_triase_text'] ?? null;

                    // Keluhan sebagai anamnesis retriase
                    $newRetriase->anamnesis_retriase = $retriase['keluhan'] ?? null;

                    // Vital signs retriase - menggunakan struktur yang sama
                    $vitalSignsRetriase = [
                        'gcs' => $retriase['gcs'] ?? '',
                        'temp' => $retriase['temp'] ?? '',
                        'rr' => $retriase['rr'] ?? '',
                        'spo2_tanpa_o2' => $retriase['spo2_tanpa_o2'] ?? '',
                        'spo2_dengan_o2' => $retriase['spo2_dengan_o2'] ?? '',
                        'td_sistole' => $retriase['td_sistole'] ?? '',
                        'td_diastole' => $retriase['td_diastole'] ?? ''
                    ];
                    $newRetriase->vitalsign_retriase = json_encode($vitalSignsRetriase);
                    $newRetriase->save();
                }
            }

            // Update tindak lanjut
            $tindakLanjutDtl = RmeAsesmenDtl::where('id_asesmen', $id)->first();
            if (!$tindakLanjutDtl) {
                $tindakLanjutDtl = new RmeAsesmenDtl();
                $tindakLanjutDtl->id_asesmen = $asesmen->id;
            }

            if ($request->has('tindak_lanjut_data')) {
                $tindakLanjutData = json_decode($request->tindak_lanjut_data, true);

                if ($tindakLanjutData && isset($tindakLanjutData['option'])) {
                    switch ($tindakLanjutData['option']) {
                        case 'rawatInap':
                            $tindakLanjutDtl->tindak_lanjut_code = 1;
                            $tindakLanjutDtl->tindak_lanjut_name = 'Rawat Inap';

                            // Update atau create SPRI data
                            $spri = RmeSpri::where('id_asesmen', $id)->first();
                            if (!$spri) {
                                $spri = new RmeSpri();
                                $spri->kd_pasien = $dataMedis->kd_pasien;
                                $spri->kd_unit = $dataMedis->kd_unit;
                                $spri->tgl_masuk = $dataMedis->tgl_masuk;
                                $spri->urut_masuk = $dataMedis->urut_masuk;
                                $spri->id_asesmen = $asesmen->id;
                            }

                            $spri->tanggal_ranap = !empty($tindakLanjutData['tanggalRawatInap']) ? $tindakLanjutData['tanggalRawatInap'] : null;
                            $spri->jam_ranap = !empty($tindakLanjutData['jamRawatInap']) ? $tindakLanjutData['jamRawatInap'] : null;
                            $spri->keluhan_utama = $tindakLanjutData['keluhanUtama_ranap'] ?? null;
                            $spri->jalannya_penyakit = $tindakLanjutData['jalannyaPenyakit_ranap'] ?? null;
                            $spri->hasil_pemeriksaan = $tindakLanjutData['hasilPemeriksaan_ranap'] ?? null;
                            $spri->diagnosis = $tindakLanjutData['diagnosis_ranap'] ?? null;
                            $spri->tindakan = $tindakLanjutData['tindakan_ranap'] ?? null;
                            $spri->anjuran = $tindakLanjutData['anjuran_ranap'] ?? null;
                            $spri->save();
                            break;

                        case 'rujukKeluar':
                            $tindakLanjutDtl->tindak_lanjut_code = 5;
                            $tindakLanjutDtl->tindak_lanjut_name = 'Rujuk RS Lain';
                            $tindakLanjutDtl->tujuan_rujuk = $tindakLanjutData['tujuan_rujuk'] ?? null;
                            $tindakLanjutDtl->alasan_rujuk = $tindakLanjutData['alasan_rujuk'] ?? null;
                            $tindakLanjutDtl->transportasi_rujuk = $tindakLanjutData['transportasi_rujuk'] ?? null;
                            $tindakLanjutDtl->keterangan = $tindakLanjutData['keterangan_rujuk'] ?? null;
                            break;

                        case 'pulangSembuh':
                            $tindakLanjutDtl->tindak_lanjut_code = 6;
                            $tindakLanjutDtl->tindak_lanjut_name = 'Pulang Sembuh';
                            $tindakLanjutDtl->tanggal_pulang = !empty($tindakLanjutData['tanggalPulang']) ? $tindakLanjutData['tanggalPulang'] : null;
                            $tindakLanjutDtl->jam_pulang = !empty($tindakLanjutData['jamPulang']) ? $tindakLanjutData['jamPulang'] : null;
                            $tindakLanjutDtl->alasan_pulang = $tindakLanjutData['alasan_pulang'] ?? null;
                            $tindakLanjutDtl->kondisi_pulang = $tindakLanjutData['kondisi_pulang'] ?? null;
                            break;

                        case 'berobatJalan':
                            $tindakLanjutDtl->tindak_lanjut_code = 8;
                            $tindakLanjutDtl->tindak_lanjut_name = 'Berobat Jalan Ke Poli';
                            $tindakLanjutDtl->tanggal_rajal = !empty($tindakLanjutData['tanggal_rajal']) ? $tindakLanjutData['tanggal_rajal'] : null;
                            $tindakLanjutDtl->poli_unit_tujuan = $tindakLanjutData['poli_unit_tujuan'] ?? null;
                            $tindakLanjutDtl->keterangan = $tindakLanjutData['catatan_rajal'] ?? null;
                            break;

                        case 'menolakRawatInap':
                            $tindakLanjutDtl->tindak_lanjut_code = 9;
                            $tindakLanjutDtl->tindak_lanjut_name = 'Menolak Rawat Inap';
                            $tindakLanjutDtl->keterangan = $tindakLanjutData['alasanMenolak'] ?? null;
                            break;

                        case 'meninggalDunia':
                            $tindakLanjutDtl->tindak_lanjut_code = 10;
                            $tindakLanjutDtl->tindak_lanjut_name = 'Meninggal Dunia';
                            $tindakLanjutDtl->tanggal_meninggal = !empty($tindakLanjutData['tanggalMeninggal']) ? $tindakLanjutData['tanggalMeninggal'] : null;
                            $tindakLanjutDtl->jam_meninggal = !empty($tindakLanjutData['jamMeninggal']) ? $tindakLanjutData['jamMeninggal'] : null;
                            $tindakLanjutDtl->keterangan = $tindakLanjutData['penyebab_kematian'] ?? null;
                            break;

                        case 'deathoffarrival':
                            $tindakLanjutDtl->tindak_lanjut_code = 11;
                            $tindakLanjutDtl->tindak_lanjut_name = 'DOA';
                            $tindakLanjutDtl->tanggal_meninggal = !empty($tindakLanjutData['tanggalDoa']) ? $tindakLanjutData['tanggalDoa'] : null;
                            $tindakLanjutDtl->jam_meninggal = !empty($tindakLanjutData['jamDoa']) ? $tindakLanjutData['jamDoa'] : null;
                            $tindakLanjutDtl->keterangan = $tindakLanjutData['keterangan_doa'] ?? null;
                            break;
                    }
                }
            }

            $tindakLanjutDtl->save();

            // Data vital sign untuk disimpan
            $vitalSignStore = [
                'sistole' => $request->vital_sign['td_sistole'] ? (int)$request->vital_sign['td_sistole'] : null,
                'diastole' => $request->vital_sign['td_diastole'] ? (int)$request->vital_sign['td_diastole'] : null,
                'nadi' => $request->vital_sign['nadi'] ? (int)$request->vital_sign['nadi'] : null,
                'respiration' => $request->vital_sign['respirasi'] ? (int)$request->vital_sign['respirasi'] : null,
                'suhu' => $request->suhu ? (float)$request->suhu : null,
                'spo2_tanpa_o2' => $request->vital_sign['spo2_tanpa_o2'] ? (int)$request->vital_sign['spo2_tanpa_o2'] : null,
                'spo2_dengan_o2' => $request->vital_sign['spo2_dengan_o2'] ? (int)$request->vital_sign['spo2_dengan_o2'] : null,
                'tinggi_badan' => $request->antropometri['tb'] ? (int)$request->antropometri['tb'] : null,
                'berat_badan' => $request->antropometri['bb'] ? (int) $request->antropometri['bb'] : null,
            ];

            // Simpan vital sign menggunakan service
            $this->asesmenService->store($vitalSignStore, $dataMedis->kd_pasien, $dataMedis->no_transaksi, $dataMedis->kd_kasir);

            // create resume
            $resumeData = [
                'anamnesis'             => $request->keluhan_utama,
                'diagnosis'             => $request->diagnosa_data,

                'tindak_lanjut_code'    => $tindakLanjutDtl->tindak_lanjut_code ?? null,
                'tindak_lanjut_name'    => $tindakLanjutDtl->tindak_lanjut_name ?? null,
                'rs_rujuk'              => $tindakLanjutDtl->tujuan_rujuk ?? null,
                'alasan_rujuk'          => $tindakLanjutDtl->alasan_rujuk ?? null,
                'transportasi_rujuk'    => $tindakLanjutDtl->transportasi_rujuk ?? null,
                'tgl_pulang'            => $tindakLanjutDtl->tanggal_pulang ?? null,
                'jam_pulang'            => $tindakLanjutDtl->jam_pulang ?? null,
                'alasan_pulang'         => $tindakLanjutDtl->alasan_pulang ?? null,
                'kondisi_pulang'        => $tindakLanjutDtl->kondisi_pulang ?? null,
                'tgl_rajal'             => $tindakLanjutDtl->tanggal_rajal ?? null,
                'unit_rajal'            => $tindakLanjutDtl->poli_unit_tujuan ?? null,
                'tgl_meninggal'         => $tindakLanjutDtl->tanggal_meninggal ?? null,
                'jam_meninggal'         => $tindakLanjutDtl->jam_meninggal ?? null,
                'tgl_meninggal_doa'     => $tindakLanjutDtl->tanggal_meninggal ?? null,
                'jam_meninggal_doa'     => $tindakLanjutDtl->jam_meninggal ?? null,
                'keterangan'            => $tindakLanjutDtl->keterangan ?? null,

                'konpas'                =>
                [
                    'sistole'   => [
                        'hasil' => $vitalSignStore['sistole'] ?? null
                    ],
                    'distole'   => [
                        'hasil' => $vitalSignStore['diastole'] ?? null
                    ],
                    'respiration_rate'   => [
                        'hasil' => $vitalSignStore['respiration'] ?? null
                    ],
                    'suhu'   => [
                        'hasil' => $vitalSignStore['suhu'] ?? null
                    ],
                    'nadi'   => [
                        'hasil' => $vitalSignStore['nadi'] ?? null
                    ],
                    'tinggi_badan'   => [
                        'hasil' => $vitalSignStore['tinggi_badan'] ?? null
                    ],
                    'berat_badan'   => [
                        'hasil' => $vitalSignStore['berat_badan'] ?? null
                    ]
                ]
            ];

            $this->baseService->updateResumeMedis(3, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $resumeData);

            DB::commit();

            return to_route('asesmen.index', [$kd_pasien, date('Y-m-d', strtotime($tgl_masuk)), $urut_masuk])
                ->with('success', 'Asesmen berhasil diperbarui');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error updating asesmen: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function show($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            // Cek apakah asesmen dengan ID ini ada
            $asesmenExists = RmeAsesmen::where('id', $id)->first();

            if (!$asesmenExists) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Asesmen dengan ID {$id} tidak ditemukan"
                ], 404);
            }

            // Cek data kunjungan
            $date = Carbon::parse($tgl_masuk)->format('Y-m-d');

            $dataMedis = $this->baseService->getDataMedis($this->kdUnit, $kd_pasien, $tgl_masuk, $urut_masuk);

            if (!$dataMedis) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data kunjungan tidak ditemukan'
                ], 404);
            }

            // Query asesmen dengan relasi
            $asesmen = RmeAsesmen::with([
                'menjalar',
                'frekuensiNyeri',
                'kualitasNyeri',
                'faktorPemberat',
                'faktorPeringan',
                'efekNyeri',
                'tindaklanjut',
                'tindaklanjut.spri'
            ])->where('id', $id)->first();

            if (!$asesmen) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Data asesmen tidak ditemukan"
                ], 404);
            }

            // Parse JSON data
            $tindakanResusitasi = $this->parseJsonSafely($asesmen->tindakan_resusitasi);
            $vitalSign = $this->parseJsonSafely($asesmen->vital_sign);
            $antropometri = $this->parseJsonSafely($asesmen->antropometri);
            $diagnosis = $this->parseJsonSafely($asesmen->diagnosis);
            $alatTerpasang = $this->parseJsonSafely($asesmen->alat_terpasang);

            // Ambil data alergi dari tabel RmeAlergiPasien
            $riwayatAlergi = RmeAlergiPasien::where('kd_pasien', $asesmen->kd_pasien)->get();

            // Ambil data retriase
            $retriaseData = DataTriase::where('id_asesmen', $id)->get();

            // Ambil pemeriksaan fisik
            $pemeriksaanFisik = RmeAsesmenPemeriksaanFisik::with('itemFisik')
                ->where('id_asesmen', $id)
                ->get()
                ->map(function ($item) {
                    return [
                        'id_item_fisik' => $item->id_item_fisik,
                        'nama_item' => $item->itemFisik->nama ?? 'Tidak Diketahui',
                        'is_normal' => $item->is_normal,
                        'keterangan' => $item->keterangan
                    ];
                });

            return response()->json([
                'status' => 'success',
                'data' => [
                    'asesmen' => [
                        'asesmen' => $asesmen,
                        'tindakan_resusitasi' => $tindakanResusitasi,
                        'anamnesis' => $asesmen->anamnesis,
                        'riwayat_penyakit' => $asesmen->riwayat_penyakit,
                        'riwayat_penyakit_keluarga' => $asesmen->riwayat_penyakit_keluarga,
                        'riwayat_pengobatan' => $asesmen->riwayat_pengobatan,
                        'riwayat_alergi' => $riwayatAlergi,
                        'vital_sign' => $vitalSign,
                        'antropometri' => $antropometri,
                        'show_skala_nyeri' => $asesmen->skala_nyeri,
                        'show_lokasi' => $asesmen->lokasi,
                        'show_durasi' => $asesmen->durasi,
                        'show_menjalar' => $asesmen->menjalar ? $asesmen->menjalar->name : null,
                        'show_frekuensi' => $asesmen->frekuensiNyeri ? $asesmen->frekuensiNyeri->name : null,
                        'show_kualitas' => $asesmen->kualitasNyeri ? $asesmen->kualitasNyeri->name : null,
                        'show_faktor_pemberat' => $asesmen->faktorPemberat ? $asesmen->faktorPemberat->name : null,
                        'show_faktor_peringan' => $asesmen->faktorPeringan ? $asesmen->faktorPeringan->name : null,
                        'show_efek_nyeri' => $asesmen->efekNyeri ? $asesmen->efekNyeri->name : null,
                        'show_diagnosis' => $diagnosis,
                        'retriase_data' => $retriaseData,
                        'alat_terpasang' => $alatTerpasang,
                        'show_kondisi_pasien' => $asesmen->kondisi_pasien,
                        'tindaklanjut' => $asesmen->tindaklanjut,
                        'pemeriksaan_fisik' => $pemeriksaanFisik,
                    ],
                    'dataMedis' => $dataMedis
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    private function parseJsonSafely($data)
    {
        if (is_string($data)) {
            $decoded = json_decode($data, true);
            return $decoded !== null ? $decoded : [];
        }
        return $data ?: [];
    }

    private function getTriageClass($kdTriase)
    {
        switch ($kdTriase) {
            case 5:
                return 'bg-dark';
            case 4:
                return 'bg-danger';
            case 3:
                return 'bg-danger';
            case 2:
                return 'bg-warning';
            case 1:
                return 'bg-success';
        }
    }

    private function getRiwayatObat($kd_pasien, $tgl_masuk, $urut_masuk)
    {
        return DB::table('MR_RESEP')
            ->join('DOKTER', 'MR_RESEP.KD_DOKTER', '=', 'DOKTER.KD_DOKTER')
            ->leftJoin('MR_RESEPDTL', 'MR_RESEP.ID_MRRESEP', '=', 'MR_RESEPDTL.ID_MRRESEP')
            ->leftJoin('APT_OBAT', 'MR_RESEPDTL.KD_PRD', '=', 'APT_OBAT.KD_PRD')
            ->where('MR_RESEP.KD_PASIEN', $kd_pasien)
            ->whereDate('MR_RESEP.tgl_masuk', $tgl_masuk)
            ->where('MR_RESEP.urut_masuk', $urut_masuk)
            ->where('MR_RESEP.kd_unit', $this->kdUnit)
            ->select(
                'MR_RESEP.TGL_ORDER',
                'DOKTER.NAMA_LENGKAP as NAMA_DOKTER',
                'MR_RESEP.ID_MRRESEP',
                'MR_RESEP.STATUS',
                'MR_RESEPDTL.CARA_PAKAI',
                'MR_RESEPDTL.JUMLAH',
                'MR_RESEPDTL.KET',
                'MR_RESEPDTL.JUMLAH_TAKARAN',
                'MR_RESEPDTL.SATUAN_TAKARAN',
                'APT_OBAT.NAMA_OBAT'
            )
            ->distinct()
            ->orderBy('MR_RESEP.TGL_ORDER', 'desc')
            ->get();
    }

    protected function getLabData($kd_order, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $results = DB::table('SEGALA_ORDER as so')
            ->select([
                'so.kd_order',
                'so.kd_pasien',
                'so.tgl_order',
                'so.tgl_masuk',
                'sod.kd_produk',
                'p.deskripsi as nama_produk',
                'kp.klasifikasi',
                'lt.item_test',
                'sod.jumlah',
                'sod.status',
                'lh.hasil',
                'lh.satuan',
                'lh.nilai_normal',
                'lh.tgl_masuk',
                'lh.KD_UNIT',
                'lh.URUT_MASUK',
                'lt.kd_test'
            ])
            ->join('SEGALA_ORDER_DET as sod', 'so.kd_order', '=', 'sod.kd_order')
            ->join('PRODUK as p', 'sod.kd_produk', '=', 'p.kd_produk')
            ->join('KLAS_PRODUK as kp', 'p.kd_klas', '=', 'kp.kd_klas')
            ->join('LAB_HASIL as lh', function ($join) {
                $join->on('p.kd_produk', '=', 'lh.kd_produk')
                    ->on('so.kd_pasien', '=', 'lh.kd_pasien')
                    ->on('so.tgl_masuk', '=', 'lh.tgl_masuk');
            })
            ->join('LAB_TEST as lt', function ($join) {
                $join->on('lh.kd_lab', '=', 'lt.kd_lab')
                    ->on('lh.kd_test', '=', 'lt.kd_test');
            })
            ->where([
                'so.tgl_masuk' => $tgl_masuk,
                'so.kd_order' => $kd_order,
                'so.kd_pasien' => $kd_pasien,
                'so.kd_unit' => 3,
                'so.urut_masuk' => $urut_masuk
            ])
            ->orderBy('lt.kd_test')
            ->get();

        // Group results by nama_produk and include klasifikasi
        return collect($results)->groupBy('nama_produk')->map(function ($group) {
            $klasifikasi = $group->first()->klasifikasi;
            return [
                'klasifikasi' => $klasifikasi,
                'tests' => $group->map(function ($item) {
                    return [
                        'item_test' => $item->item_test ?? '-',
                        'hasil' => $item->hasil ?? '-',
                        'satuan' => $item->satuan ?? '',
                        'nilai_normal' => $item->nilai_normal ?? '-',
                        'kd_test' => $item->kd_test
                    ];
                })
            ];
        });
    }

    private function getLabor($kd_pasien, $tgl_masuk, $urut_masuk)
    {
        // Mengambil data hasil pemeriksaan laboratorium
        $dataLabor = SegalaOrder::with(['details.produk', 'produk.labHasil'])
            ->where('kd_pasien', $kd_pasien)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->where('kd_unit', $this->kdUnit)
            ->whereHas('details.produk', function ($query) {
                $query->where('kategori', 'LB');
            })
            ->orderBy('tgl_order', 'desc')
            ->get();

        // Transform lab results
        $dataLabor->transform(function ($item) {
            foreach ($item->details as $detail) {
                $labResults = $this->getLabData(
                    $item->kd_order,
                    $item->kd_pasien,
                    $item->tgl_masuk,
                    $item->urut_masuk
                );
                $detail->labResults = $labResults;
            }
            return $item;
        });

        return $dataLabor;
    }

    // private function getLabor($kd_pasien, $tgl_masuk, $urut_masuk)
    // {
    //     return SegalaOrder::with(['details.produk', 'dokter', 'labHasil'])
    //         ->where('kd_pasien', $kd_pasien)
    //         ->whereDate('tgl_masuk', $tgl_masuk)
    //         ->where('urut_masuk', $urut_masuk)
    //         ->where('kd_unit', $this->kdUnit)
    //         ->orderBy('tgl_order', 'desc')
    //         ->get()
    //         ->map(function ($order) {
    //             $labHasil = $order->labHasil->sortByDesc('tgl_otoritas_det')->first();
    //             $namaPemeriksaan = $order->details->map(function ($detail) {
    //                 return $detail->produk->deskripsi ?? '';
    //             })->filter()->implode(', ');

    //             return [
    //                 'Tanggal-Jam' => $order->tgl_order->format('d M Y H:i'),
    //                 'Nama pemeriksaan' => $namaPemeriksaan,
    //                 'Status' => $this->getStatusOrder($order->status_order),
    //                 // 'Waktu Hasil' => $labHasil && $labHasil->tgl_otoritas_det ? $labHasil->tgl_otoritas_det->format('d M Y H:i') : '-',
    //                 'Dokter Pengirim' => $order->dokter->nama_lengkap ?? '',
    //                 'Cito/Non Cito' => $order->cyto == 1 ? 'Cyto' : 'Non-Cyto',
    //                 'No Order' => (int) $order->kd_order
    //             ];
    //         });
    // }

    private function getStatusOrder($statusOrder)
    {
        if ($statusOrder == 1) {
            return 'Diorder';
        } elseif ($statusOrder == 0) {
            return 'Selesai';
        }
        return 'Unknown';
    }

    private function getRadiologi($kd_pasien, $tgl_masuk, $urut_masuk)
    {
        return SegalaOrder::with(['details.produk', 'dokter'])
            ->where('kd_pasien', $kd_pasien)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->where('kd_unit', $this->kdUnit)
            ->where('kategori', 'RD')
            ->orderBy('tgl_order', 'desc')
            ->get()
            ->map(function ($order) {
                $namaPemeriksaan = $order->details->map(function ($detail) {
                    return $detail->produk->deskripsi ?? '';
                })->filter()->implode(', ');

                return [
                    'Tanggal-Jam' => Carbon::parse($order->tgl_order)->format('d M Y H:i'),
                    'Nama Pemeriksaan' => $namaPemeriksaan,
                    'Status' => $this->getStatusOrderRadiologi($order->status_order),
                ];
            });
    }

    private function getStatusOrderRadiologi($statusOrder)
    {
        switch ($statusOrder) {
            case 0:
                return '<span class="text-warning">Diproses</span>';
            case 1:
                return '<span class="text-secondary">Diorder</span>';
            case 2:
                return '<span class="text-success">Selesai</span>';
            default:
                return '<span class="text-secondary">Unknown</span>';
        }
    }

    public function store($kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        DB::beginTransaction();

        try {

            $user = auth()->user();
            $dataMedis = $this->baseService->getDataMedis($this->kdUnit, $kd_pasien, $tgl_masuk, $urut_masuk);
            if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
                $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
            } else {
                $dataMedis->pasien->umur = 'Tidak Diketahui';
            }

            $tanggalMasuk = $request->tanggal_masuk ?? date('Y-m-d');
            $jamMasuk = $request->jam_masuk ?? date('H:i');
            $waktuAsesmen = $tanggalMasuk . ' ' . $jamMasuk . ':00';

            $asesmen = new RmeAsesmen();
            $asesmen->kd_pasien = $dataMedis->kd_pasien;
            $asesmen->kd_unit = $dataMedis->kd_unit;
            $asesmen->tgl_masuk = $dataMedis->tgl_masuk;
            $asesmen->urut_masuk = $dataMedis->urut_masuk;
            $asesmen->waktu_asesmen = $waktuAsesmen;

            $asesmen->tindakan_resusitasi = json_encode($request->tindakan_resusitasi) ?? '';
            $asesmen->anamnesis = $request->keluhan_utama;
            $asesmen->riwayat_penyakit = $request->riwayat_penyakit;
            $asesmen->riwayat_penyakit_keluarga = $request->riwayat_penyakit_keluarga;
            $asesmen->riwayat_pengobatan = $request->riwayat_pengobatan;

            // Format vital_sign sesuai struktur yang diinginkan
            $vitalSignData = [
                'td_sistole' => $request->vital_sign['td_sistole'] ?? '',
                'td_diastole' => $request->vital_sign['td_diastole'] ?? '',
                'nadi' => $request->vital_sign['nadi'] ?? '',
                'temp' => $request->vital_sign['suhu'] ?? '',
                'rr' => $request->vital_sign['respirasi'] ?? '',
                'spo2_tanpa_o2' => $request->vital_sign['spo2_tanpa_o2'] ?? '',
                'spo2_dengan_o2' => $request->vital_sign['spo2_dengan_o2'] ?? '',
                'gcs' => $request->vital_sign['gcs'] ?? ''
            ];

            $asesmen->vital_sign = json_encode($vitalSignData);
            $asesmen->antropometri = json_encode($request->antropometri);

            $asesmen->skala_nyeri = $request->skala_nyeri_nilai;
            $asesmen->lokasi = $request->lokasi;
            $asesmen->durasi = $request->durasi;
            $asesmen->menjalar_id = $request->menjalar;
            $asesmen->frekuensi_nyeri_id = $request->frekuensi;
            $asesmen->kualitas_nyeri_id = $request->kualitas;
            $asesmen->faktor_pemberat_id = $request->faktor_pemberat;
            $asesmen->faktor_peringan_id = $request->faktor_peringan;
            $asesmen->efek_nyeri = $request->efek_nyeri;
            $asesmen->jenis_nyeri_id = $request->jenis_nyeri;

            $asesmen->diagnosis = $request->diagnosa_data ? json_encode($request->diagnosa_data) : null;
            $asesmen->alat_terpasang = $request->alat_terpasang_data;

            $asesmen->kondisi_pasien = $request->kondisi_pasien;
            $asesmen->user_id = $user->id;
            $asesmen->kategori = 1;
            $asesmen->sub_kategori = 1;
            $asesmen->save();

            // Simpan alergi pasien
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

            // Simpan pemeriksaan fisik
            $itemFisik = MrItemFisik::all();
            foreach ($itemFisik as $item) {
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

            // Simpan data retriase
            $retriaseData = json_decode($request->retriase_data, true);
            if ($retriaseData && !empty($retriaseData)) {
                foreach ($retriaseData as $retriase) {
                    $newRetriase = new DataTriase();
                    $newRetriase->id_asesmen = $asesmen->id;
                    $newRetriase->nama_pasien = $dataMedis->pasien->nama;
                    $newRetriase->usia = $dataMedis->pasien->umur;
                    $newRetriase->jenis_kelamin = $dataMedis->pasien->jenis_kelamin;
                    $newRetriase->tanggal_lahir = $dataMedis->pasien->tgl_lahir;

                    // Format tanggal dari form retriase
                    $tanggalJam = $retriase['tanggal'] . ' ' . $retriase['jam'] . ':00';
                    $newRetriase->tanggal_triase = $tanggalJam;

                    $newRetriase->dokter_triase = $dataMedis->dokter->kd_dokter ?? null;
                    $newRetriase->kd_pasien_triase = $dataMedis->kd_pasien;
                    $newRetriase->status = $dataMedis->status;
                    $newRetriase->usia_bulan = $dataMedis->usia_bulan;
                    $newRetriase->foto_pasien = $dataMedis->foto_pasien;

                    // Kesimpulan triase
                    $newRetriase->kode_triase = $retriase['kesimpulan_triase'] ?? null;
                    $newRetriase->hasil_triase = $retriase['kesimpulan_triase_text'] ?? null;

                    // Keluhan sebagai anamnesis retriase
                    $newRetriase->anamnesis_retriase = $retriase['keluhan'] ?? null;

                    // Vital signs retriase - menggunakan struktur yang sama
                    $vitalSignsRetriase = [
                        'gcs' => $retriase['gcs'] ?? '',
                        'temp' => $retriase['temp'] ?? '',
                        'rr' => $retriase['rr'] ?? '',
                        'spo2_tanpa_o2' => $retriase['spo2_tanpa_o2'] ?? '',
                        'spo2_dengan_o2' => $retriase['spo2_dengan_o2'] ?? '',
                        'td_sistole' => $retriase['td_sistole'] ?? '',
                        'td_diastole' => $retriase['td_diastole'] ?? ''
                    ];
                    $newRetriase->vitalsign_retriase = json_encode($vitalSignsRetriase);
                    $newRetriase->save();
                }
            }

            // Simpan tindak lanjut
            $tindakLanjutDtl = null;
            if ($request->has('tindak_lanjut_data')) {
                $tindakLanjutData = json_decode($request->tindak_lanjut_data, true);

                $tindakLanjutDtl = new RmeAsesmenDtl();
                $tindakLanjutDtl->id_asesmen = $asesmen->id;

                if ($tindakLanjutData && isset($tindakLanjutData['option'])) {
                    switch ($tindakLanjutData['option']) {
                        case 'rawatInap':
                            $tindakLanjutDtl->tindak_lanjut_code = 1;
                            $tindakLanjutDtl->tindak_lanjut_name = 'Rawat Inap';

                            RmeSpri::create([
                                'kd_pasien' => $dataMedis->kd_pasien,
                                'kd_unit' => $dataMedis->kd_unit,
                                'tgl_masuk' => $dataMedis->tgl_masuk,
                                'urut_masuk' => $dataMedis->urut_masuk,
                                'id_asesmen' => $asesmen->id,
                                'tanggal_ranap' => !empty($tindakLanjutData['tanggalRawatInap']) ? $tindakLanjutData['tanggalRawatInap'] : null,
                                'jam_ranap' => !empty($tindakLanjutData['jamRawatInap']) ? $tindakLanjutData['jamRawatInap'] : null,
                                'keluhan_utama' => $tindakLanjutData['keluhanUtama_ranap'] ?? null,
                                'jalannya_penyakit' => $tindakLanjutData['jalannyaPenyakit_ranap'] ?? null,
                                'hasil_pemeriksaan' => $tindakLanjutData['hasilPemeriksaan_ranap'] ?? null,
                                'diagnosis' => $tindakLanjutData['diagnosis_ranap'] ?? null,
                                'tindakan' => $tindakLanjutData['tindakan_ranap'] ?? null,
                                'anjuran' => $tindakLanjutData['anjuran_ranap'] ?? null
                            ]);
                            break;

                        case 'kamarOperasi':
                            $tindakLanjutDtl->tindak_lanjut_code = 7;
                            $tindakLanjutDtl->tindak_lanjut_name = 'Kamar Operasi';
                            $tindakLanjutDtl->keterangan = $tindakLanjutData['kamarOperasi'] ?? null;
                            break;

                        case 'rujukKeluar':
                            $tindakLanjutDtl->tindak_lanjut_code = 5;
                            $tindakLanjutDtl->tindak_lanjut_name = 'Rujuk RS Lain';
                            $tindakLanjutDtl->tujuan_rujuk = $tindakLanjutData['tujuan_rujuk'] ?? null;
                            $tindakLanjutDtl->alasan_rujuk = $tindakLanjutData['alasan_rujuk'] ?? null;
                            $tindakLanjutDtl->transportasi_rujuk = $tindakLanjutData['transportasi_rujuk'] ?? null;
                            $tindakLanjutDtl->keterangan = $tindakLanjutData['keterangan_rujuk'] ?? null;
                            break;

                        case 'pulangSembuh':
                            $tindakLanjutDtl->tindak_lanjut_code = 6;
                            $tindakLanjutDtl->tindak_lanjut_name = 'Pulang Sembuh';
                            $tindakLanjutDtl->tanggal_pulang = !empty($tindakLanjutData['tanggalPulang']) ? $tindakLanjutData['tanggalPulang'] : null;
                            $tindakLanjutDtl->jam_pulang = !empty($tindakLanjutData['jamPulang']) ? $tindakLanjutData['jamPulang'] : null;
                            $tindakLanjutDtl->alasan_pulang = $tindakLanjutData['alasan_pulang'] ?? null;
                            $tindakLanjutDtl->kondisi_pulang = $tindakLanjutData['kondisi_pulang'] ?? null;
                            break;

                        case 'berobatJalan':
                            $tindakLanjutDtl->tindak_lanjut_code = 8;
                            $tindakLanjutDtl->tindak_lanjut_name = 'Berobat Jalan Ke Poli';
                            $tindakLanjutDtl->tanggal_rajal = !empty($tindakLanjutData['tanggal_rajal']) ? $tindakLanjutData['tanggal_rajal'] : null;
                            $tindakLanjutDtl->poli_unit_tujuan = $tindakLanjutData['poli_unit_tujuan'] ?? null;
                            $tindakLanjutDtl->keterangan = $tindakLanjutData['catatan_rajal'] ?? null;
                            break;

                        case 'menolakRawatInap':
                            $tindakLanjutDtl->tindak_lanjut_code = 9;
                            $tindakLanjutDtl->tindak_lanjut_name = 'Menolak Rawat Inap';
                            $tindakLanjutDtl->keterangan = $tindakLanjutData['alasanMenolak'] ?? null;
                            break;

                        case 'meninggalDunia':
                            $tindakLanjutDtl->tindak_lanjut_code = 10;
                            $tindakLanjutDtl->tindak_lanjut_name = 'Meninggal Dunia';
                            $tindakLanjutDtl->tanggal_meninggal = !empty($tindakLanjutData['tanggalMeninggal']) ? $tindakLanjutData['tanggalMeninggal'] : null;
                            $tindakLanjutDtl->jam_meninggal = !empty($tindakLanjutData['jamMeninggal']) ? $tindakLanjutData['jamMeninggal'] : null;
                            $tindakLanjutDtl->keterangan = $tindakLanjutData['penyebab_kematian'] ?? null;
                            break;

                        case 'deathofarrival':
                            $tindakLanjutDtl->tindak_lanjut_code = 11;
                            $tindakLanjutDtl->tindak_lanjut_name = 'DOA';
                            $tindakLanjutDtl->tanggal_meninggal = !empty($tindakLanjutData['tanggalDoa']) ? $tindakLanjutData['tanggalDoa'] : null;
                            $tindakLanjutDtl->jam_meninggal = !empty($tindakLanjutData['jamDoa']) ? $tindakLanjutData['jamDoa'] : null;
                            $tindakLanjutDtl->keterangan = $tindakLanjutData['keterangan_doa'] ?? null;
                            break;

                        default:
                            $tindakLanjutDtl->tindak_lanjut_code = null;
                            $tindakLanjutDtl->tindak_lanjut_name = null;
                    }
                } else {
                    // Set NULL values when tindakLanjutData is empty
                    $tindakLanjutDtl->tindak_lanjut_code = null;
                    $tindakLanjutDtl->tindak_lanjut_name = null;
                    $tindakLanjutDtl->keterangan = null;
                    $tindakLanjutDtl->tanggal_meninggal = null;
                    $tindakLanjutDtl->jam_meninggal = null;
                    $tindakLanjutDtl->tanggal_pulang = null;
                    $tindakLanjutDtl->jam_pulang = null;
                    $tindakLanjutDtl->alasan_pulang = null;
                    $tindakLanjutDtl->kondisi_pulang = null;
                    $tindakLanjutDtl->tanggal_rajal = null;
                    $tindakLanjutDtl->poli_unit_tujuan = null;
                    $tindakLanjutDtl->tujuan_rujuk = null;
                    $tindakLanjutDtl->alasan_rujuk = null;
                    $tindakLanjutDtl->transportasi_rujuk = null;
                    $tindakLanjutDtl->kamar_operasi = null;
                }

                $tindakLanjutDtl->save();
            }

            // Data vital sign untuk disimpan
            $vitalSignStore = [
                'sistole' => $request->vital_sign['td_sistole'] ? (int)$request->vital_sign['td_sistole'] : null,
                'diastole' => $request->vital_sign['td_diastole'] ? (int)$request->vital_sign['td_diastole'] : null,
                'nadi' => $request->vital_sign['nadi'] ? (int)$request->vital_sign['nadi'] : null,
                'respiration' => $request->vital_sign['respirasi'] ? (int)$request->vital_sign['respirasi'] : null,
                'suhu' => $request->suhu ? (float)$request->suhu : null,
                'spo2_tanpa_o2' => $request->vital_sign['spo2_tanpa_o2'] ? (int)$request->vital_sign['spo2_tanpa_o2'] : null,
                'spo2_dengan_o2' => $request->vital_sign['spo2_dengan_o2'] ? (int)$request->vital_sign['spo2_dengan_o2'] : null,
                'tinggi_badan' => $request->antropometri['tb'] ? (int)$request->antropometri['tb'] : null,
                'berat_badan' => $request->antropometri['bb'] ? (int) $request->antropometri['bb'] : null,
            ];

            // Simpan vital sign menggunakan service
            $this->asesmenService->store($vitalSignStore, $dataMedis->kd_pasien, $dataMedis->no_transaksi, $dataMedis->kd_kasir);


            // create resume
            $resumeData = [
                'anamnesis'             => $request->keluhan_utama,
                'diagnosis'             => $request->diagnosa_data,

                'tindak_lanjut_code'    => $tindakLanjutDtl->tindak_lanjut_code ?? null,
                'tindak_lanjut_name'    => $tindakLanjutDtl->tindak_lanjut_name ?? null,
                'rs_rujuk'              => $tindakLanjutDtl->tujuan_rujuk ?? null,
                'alasan_rujuk'          => $tindakLanjutDtl->alasan_rujuk ?? null,
                'transportasi_rujuk'    => $tindakLanjutDtl->transportasi_rujuk ?? null,
                'tgl_pulang'            => $tindakLanjutDtl->tanggal_pulang ?? null,
                'jam_pulang'            => $tindakLanjutDtl->jam_pulang ?? null,
                'alasan_pulang'         => $tindakLanjutDtl->alasan_pulang ?? null,
                'kondisi_pulang'        => $tindakLanjutDtl->kondisi_pulang ?? null,
                'tgl_rajal'             => $tindakLanjutDtl->tanggal_rajal ?? null,
                'unit_rajal'            => $tindakLanjutDtl->poli_unit_tujuan ?? null,
                'tgl_meninggal'         => $tindakLanjutDtl->tanggal_meninggal ?? null,
                'jam_meninggal'         => $tindakLanjutDtl->jam_meninggal ?? null,
                'tgl_meninggal_doa'     => $tindakLanjutDtl->tanggal_meninggal ?? null,
                'jam_meninggal_doa'     => $tindakLanjutDtl->jam_meninggal ?? null,
                'keterangan'            => $tindakLanjutDtl->keterangan ?? null,

                'konpas'                =>
                [
                    'sistole'   => [
                        'hasil' => $vitalSignStore['sistole'] ?? null
                    ],
                    'distole'   => [
                        'hasil' => $vitalSignStore['diastole'] ?? null
                    ],
                    'respiration_rate'   => [
                        'hasil' => $vitalSignStore['respiration'] ?? null
                    ],
                    'suhu'   => [
                        'hasil' => $vitalSignStore['suhu'] ?? null
                    ],
                    'nadi'   => [
                        'hasil' => $vitalSignStore['nadi'] ?? null
                    ],
                    'tinggi_badan'   => [
                        'hasil' => $vitalSignStore['tinggi_badan'] ?? null
                    ],
                    'berat_badan'   => [
                        'hasil' => $vitalSignStore['berat_badan'] ?? null
                    ]
                ]
            ];

            $this->baseService->updateResumeMedis(3, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $resumeData);

            DB::commit();
            return to_route('asesmen.index', [$kd_pasien, date('Y-m-d', strtotime($tgl_masuk)), $dataMedis->urut_masuk])
                ->with('success', 'Asesmen berhasil disimpan');
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function print($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {

        $dataMedis = $this->baseService->getDataMedis($this->kdUnit, $kd_pasien, $tgl_masuk, $urut_masuk);

        // Ambil data asesmen
        $asesmen = RmeAsesmen::with([
            'pasien',
            'menjalar',
            'frekuensiNyeri',
            'kualitasNyeri',
            'faktorPemberat',
            'faktorPeringan',
            'efekNyeri',
            'tindaklanjut',
            'pemeriksaanFisik',
            'pemeriksaanFisik.itemFisik',
            'user'
        ])
            ->where('id', $id)
            ->first();

        $triaselabel = '-';
        $triasename = '-';

        switch ($dataMedis->kd_triase) {
            case '1':
                $triaselabel = 'FALSE EMERGENCY';
                $triasename = 'HIJAU';
                break;
            case '2':
                $triaselabel = 'URGNET';
                $triasename = 'KUNING';
                break;
            case '3':
                $triaselabel = 'EMERGENCY';
                $triasename = 'MERAH';
                break;
            case '4':
                $triaselabel = 'RESUSITASI';
                $triasename = 'MERAH';
                break;
            case '5':
                $triaselabel = 'DOA';
                $triasename = 'HITAM';
                break;
        }

        // Ambil riwayat alergi dari tabel RmeAlergiPasien, sama seperti di show
        $riwayatAlergi = RmeAlergiPasien::where('kd_pasien', $asesmen->kd_pasien)->get();

        $pdf = PDF::loadView('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen.print', [
            'asesmen' => $asesmen,
            'triase' => [
                'label' => $triaselabel,
                'warna' => $triasename,
            ],
            'riwayatAlergi' => $riwayatAlergi

        ]);

        // dd($asesmen);

        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream("Asesmen-Keperawatan-Medis-{$id}.pdf");
    }
}
