<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\MrItemFisik;
use App\Models\Pekerjaan;
use App\Models\RmeAlergiPasien;
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
use App\Models\SatsetPrognosis;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AsesmenKepUmumController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
    }

    private function getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien')
                    ->on('kunjungan.kd_unit', '=', 't.kd_unit')
                    ->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi')
                    ->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->leftJoin('dokter', 'kunjungan.KD_DOKTER', '=', 'dokter.KD_DOKTER')
            ->select('kunjungan.*', 't.*', 'dokter.NAMA as nama_dokter')
            ->where('kunjungan.kd_unit', $kd_unit)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();

        if ($dataMedis && $dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } elseif ($dataMedis && $dataMedis->pasien) {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        return $dataMedis;
    }

    private function getTransaksiData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        return Transaksi::select('kd_kasir', 'no_transaksi')
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_transaksi', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->first();
    }

    private function getMasterData($kd_pasien)
    {
        return [
            'rmeMasterDiagnosis' => RmeMasterDiagnosis::all(),
            'rmeMasterImplementasi' => RmeMasterImplementasi::all(),
            'satsetPrognosis' => SatsetPrognosis::all(),
            'alergiPasien' => RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get(),
            'dokter' => Dokter::where('status', 1)->orderBy('nama_lengkap', 'asc')->get(),
        ];
    }

    private function saveDiagnosisToMaster($diagnosisList)
    {
        foreach ($diagnosisList as $diagnosa) {
            if (!empty($diagnosa)) {
                RmeMasterDiagnosis::firstOrCreate(['nama_diagnosis' => $diagnosa]);
            }
        }
    }
    private function saveImplementasiToMaster($dataList, $column)
    {
        foreach ($dataList as $item) {
            if (!empty($item)) {
                RmeMasterImplementasi::firstOrCreate([$column => $item]);
            }
        }
    }

    private function handleAlergiData($request, $kd_pasien)
    {
        $alergiData = json_decode($request->alergis, true);

        if (!empty($alergiData)) {
            RmeAlergiPasien::where('kd_pasien', $kd_pasien)->delete();

            foreach ($alergiData as $alergi) {
                if (!empty($alergi['jenis_alergi']) || !empty($alergi['alergen'])) {
                    RmeAlergiPasien::create([
                        'kd_pasien' => $kd_pasien,
                        'jenis_alergi' => $alergi['jenis_alergi'],
                        'nama_alergi' => $alergi['alergen'],
                        'reaksi' => $alergi['reaksi'],
                        'tingkat_keparahan' => $alergi['tingkat_keparahan']
                    ]);
                }
            }
        }
    }

    /**
     * Helper function to process JSON data correctly
     */
    private function processJsonData($jsonString)
    {
        if (empty($jsonString) || $jsonString === '[]') {
            return null;
        }

        $data = json_decode($jsonString, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return null;
        }

        return $data;
    }

    /**
     * Helper function to format JSON for database storage
     */
    private function formatJsonForDatabase($data)
    {
        if (empty($data) || !is_array($data)) {
            return null;
        }

        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function index(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

        if (!$dataMedis) {
            abort(404, 'Data tidak ditemukan');
        }

        $masterData = $this->getMasterData($kd_pasien);

        return view(
            'unit-pelayanan.rawat-inap.pelayanan.asesmen-umum.create',
            array_merge([
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
                'dataMedis' => $dataMedis,
            ], $masterData)
        );
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $request->validate([
            'kd_pasien' => 'required',
            'kd_unit' => 'required',
            'tgl_masuk' => 'required|date',
            'urut_masuk' => 'required',
            'tanggal' => 'required|date',
            'jam_masuk' => 'required',
            'sistole' => 'nullable|numeric',
            'diastole' => 'nullable|numeric',
            'respirasi' => 'nullable|numeric',
            'suhu' => 'nullable|numeric',
            'nadi' => 'nullable|numeric',
            'riwayat_imunisasi' => 'nullable|array',
            'riwayat_imunisasi.*' => 'in:hep_b_ii,hep_b_iii,hep_b_iv,hep_b_v,dpt_ii,dpt_iii,bcg,booster_ii,booster_iii,hib_ii,hib_iii,hib_iv,mmr,varilrix,typhim',
        ]);

        DB::beginTransaction();
        try {

            // Get transaksi data
            $transaksiData = $this->getTransaksiData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

            if (!$transaksiData) {
                throw new \Exception('Data transaksi tidak ditemukan');
            }

            // 1. Buat record RmeAsesmen
            $asesmen = new RmeAsesmen();
            $asesmen->kd_pasien = $request->kd_pasien;
            $asesmen->kd_unit = $request->kd_unit;
            $asesmen->tgl_masuk = $request->tgl_masuk;
            $asesmen->urut_masuk = $request->urut_masuk;
            $asesmen->user_id = Auth::id();
            $asesmen->waktu_asesmen = now();
            $asesmen->kategori = 1;
            $asesmen->sub_kategori = 7;
            $asesmen->save();

            // Process JSON data
            $riwayatObat = $this->processJsonData($request->riwayat_penggunaan_obat);
            $riwayatImunisasi = $request->input('riwayat_imunisasi', []);

            // Process vital signs
            $vitalSign = [
                'gcs' => $request->input('vital_sign.gcs'),
                'sistole' => $request->sistole,
                'diastole' => $request->diastole,
                'nadi' => $request->nadi,
                'suhu' => $request->suhu,
                'rr' => $request->rr,
                'berat_badan' => $request->berat_badan,
                'tinggi_badan' => $request->tinggi_badan
            ];

            // $asesmenMedisAnak = RmeAsesmenMedisAnak::create([
            //     'id_asesmen' => $asesmen->id,
            //     'kd_kasir' => $transaksiData->kd_kasir,
            //     'no_transaksi' => $transaksiData->no_transaksi,
            //     'tanggal' => $request->tanggal ?? date('Y-m-d'),
            //     'jam' => $request->jam_masuk ?? date('H:i:s'),
            //     'anamnesis' => $request->anamnesis,
            //     'keluhan_utama' => $request->keluhan_utama,
            //     'riwayat_penyakit_terdahulu' => $request->riwayat_penyakit_terdahulu,
            //     'riwayat_penyakit_keluarga' => $request->riwayat_penyakit_keluarga,
            //     'riwayat_penyakit_sekarang' => $request->riwayat_penyakit_sekarang,
            //     'riwayat_penggunaan_obat' => $this->formatJsonForDatabase($riwayatObat),
            //     'kesadaran' => $request->kesadaran,
            //     'vital_sign' => $this->formatJsonForDatabase($vitalSign),
            //     'sistole' => $request->sistole,
            //     'diastole' => $request->diastole,
            //     'nadi' => $request->nadi,
            //     'suhu' => $request->suhu,
            //     'rr' => $request->rr,
            //     'berat_badan' => $request->berat_badan,
            //     'tinggi_badan' => $request->tinggi_badan,
            //     'user_create' => Auth::id()
            // ]);

            // RmeAsesmenMedisAnakFisik::create([
            //     'id_asesmen_medis_anak' => $asesmenMedisAnak->id,
            //     'user_create' => Auth::id()
            // ]);

            // Process diagnosis data
            $diagnosisBanding = $this->processJsonData($request->diagnosis_banding);
            $diagnosisKerja = $this->processJsonData($request->diagnosis_kerja);

            // RmeAsesmenMedisAnakDtl::create([
            //     'id_asesmen_medis_anak' => $asesmenMedisAnak->id,
            //     // Riwayat Prenatal

            //     'user_create' => Auth::id()
            // ]);

            // Handle diagnosis ke master
            if (!empty($diagnosisBanding) && is_array($diagnosisBanding)) {
                $this->saveDiagnosisToMaster($diagnosisBanding);
            }

            if (!empty($diagnosisKerja) && is_array($diagnosisKerja)) {
                $this->saveDiagnosisToMaster($diagnosisKerja);
            }

            // Handle alergi
            $this->handleAlergiData($request, $kd_pasien);

            DB::commit();

            return redirect()
                ->route('rawat-inap.asesmen.medis.umum.index', [
                    'kd_unit' => $kd_unit,
                    'kd_pasien' => $kd_pasien,
                    'tgl_masuk' => $tgl_masuk,
                    'urut_masuk' => $urut_masuk
                ])
                ->with('success', 'Data Asesmen Awal Keperawatan Rawat Inap Dewasa');

        } catch (\Exception $e) {
            DB::rollback();
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
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