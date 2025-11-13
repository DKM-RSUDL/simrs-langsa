<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Cppt;
use App\Models\CpptInstruksiPpa;
use App\Models\CpptPenyakit;
use App\Models\CpptTindakLanjut;
use App\Models\HrdKaryawan;
use App\Models\Kunjungan;
use App\Models\MrAnamnesis;
use App\Models\MrKondisiFisik;
use App\Models\MrKonpas;
use App\Models\MrKonpasDtl;
use App\Models\Penyakit;
use App\Models\RmeFaktorPemberat;
use App\Models\RmeFaktorPeringan;
use App\Models\RmeFrekuensiNyeri;
use App\Models\RmeJenisNyeri;
use App\Models\RmeKualitasNyeri;
use App\Models\RmeMenjalar;
use App\Models\RMEResume;
use App\Models\RmeResumeDtl;
use App\Models\Transaksi;
use App\Models\VitalSign;
use App\Services\AsesmenService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CpptController extends Controller
{
    protected $asesmenService;

    public function __construct()
    {
        $this->asesmenService = new AsesmenService;
        $this->middleware('can:read unit-pelayanan/rawat-inap');
    }

    public function dataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', $kd_unit)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();

        return $dataMedis;
    }

    public function index($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->dataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

        $tandaVital = MrKondisiFisik::OrderBy('urut')->get();
        $faktorPemberat = RmeFaktorPemberat::all();
        $faktorPeringan = RmeFaktorPeringan::all();
        $kualitasNyeri = RmeKualitasNyeri::all();
        $frekuensiNyeri = RmeFrekuensiNyeri::all();
        $menjalar = RmeMenjalar::all();
        $jenisNyeri = RmeJenisNyeri::all();
        $karyawan = HrdKaryawan::orderBy('kd_karyawan', 'asc')->get();

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (! $dataMedis) {
            abort(404, 'Data not found');
        }

        $vitalSignData = $this->getVitalSignForCppt($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
        $lastCpptData = $this->getLastCpptData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
        $lastDiagnoses = $this->getLastDiagnosisByTipeCppt($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

        // get cppt - REFACTORED
        $additionalWheres = [
            't.kd_pasien' => $dataMedis->kd_pasien,
            't.kd_unit' => $dataMedis->kd_unit,
            'cppt.no_transaksi' => $dataMedis->no_transaksi,
            'cppt.kd_kasir' => $dataMedis->kd_kasir,
        ];

        $getCppt = $this->buildCpptQuery($additionalWheres)->get();
        $cppt = $this->transformCpptData($getCppt, true); // includeNames = true

        return view('unit-pelayanan.rawat-inap.pelayanan.cppt.index', [
            'dataMedis' => $dataMedis,
            'tandaVital' => $tandaVital,
            'faktorPemberat' => $faktorPemberat,
            'faktorPeringan' => $faktorPeringan,
            'kualitasNyeri' => $kualitasNyeri,
            'frekuensiNyeri' => $frekuensiNyeri,
            'menjalar' => $menjalar,
            'jenisNyeri' => $jenisNyeri,
            'cppt' => $cppt,
            'karyawan' => $karyawan,
            'vitalSignData' => $vitalSignData,
            'lastCpptData' => $lastCpptData,
        ]);
    }

    public function getCpptAjax(Request $request)
    {
        try {
            // REFACTORED
            $additionalWheres = [
                't.kd_pasien' => $request->kd_pasien,
                't.kd_unit' => $request->kd_unit,
                't.no_transaksi' => $request->no_transaksi,
                'cppt.tanggal' => $request->tanggal,
                'cppt.urut' => $request->urut,
            ];

            $getCppt = $this->buildCpptQuery($additionalWheres)->get();
            $cppt = $this->transformCpptData($getCppt, false); // includeNames = false

         
            if (count($cppt) < 1) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data tidak ditemukan!',
                    'data' => [],
                ], 200);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Data ditemukan!',
                'data' => $cppt,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Internal server error',
                'data' => [],
            ], 500);
        }
    }

    public function getIcdTenAjax(Request $request)
    {
        try {
            $search = $request->data;
            $query = Penyakit::select(['kd_penyakit', 'penyakit']);

            if (! empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('penyakit', 'LIKE', "%$search%");
                    $q->orWhere('kd_penyakit', 'LIKE', "%$search%");
                })
                    ->limit(5);
            } else {
                $query->limit(5);
            }

            $dataDiagnosa = $query->get();

            return response()->json([
                'status' => 'success',
                'data' => [
                    'count' => count($dataDiagnosa),
                    'diagnosa' => $dataDiagnosa,
                ],
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => [
                    'count' => 0,
                ],
            ], 400);
        }
    }

    public function getInstruksiPpaByUrutTotal(Request $request)
    {
        try {
            $urutTotal = $request->urut_total;

            $instruksiPpa = CpptInstruksiPpa::where('urut_total_cppt', $urutTotal)
                ->orderBy('id', 'asc')
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $instruksiPpa,
                'count' => $instruksiPpa->count(),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    private function getNamaLengkapByKode($kode_ppa)
    {
        $karyawan = HrdKaryawan::where('kd_karyawan', $kode_ppa)->first();

        if (! $karyawan) {
            return $kode_ppa;
        }

        $nama_lengkap = '';
        if (! empty($karyawan->gelar_depan)) {
            $nama_lengkap .= $karyawan->gelar_depan . ' ';
        }
        $nama_lengkap .= $karyawan->nama;
        if (! empty($karyawan->gelar_belakang)) {
            $nama_lengkap .= ', ' . $karyawan->gelar_belakang;
        }

        return $nama_lengkap;
    }

    private function getLastCpptData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $lastCppt = Cppt::with(['pemberat', 'peringan', 'kualitas', 'frekuensi', 'menjalar', 'jenis'])
            ->join('transaksi as t', function ($join) {
                $join->on('cppt.no_transaksi', '=', 't.no_transaksi')
                    ->on('cppt.kd_kasir', '=', 't.kd_kasir');
            })
            ->where('t.kd_pasien', $kd_pasien)
            ->where('t.kd_unit', $kd_unit)
            ->orderBy('cppt.tanggal', 'desc')
            ->orderBy('cppt.jam', 'desc')
            ->first();

        if ($lastCppt) {
            return [
                'skala_nyeri' => $lastCppt->skala_nyeri ?? 0,
                'lokasi' => $lastCppt->lokasi ?? '',
                'durasi' => $lastCppt->durasi ?? '',
                'pemberat_id' => $lastCppt->faktor_pemberat_id ?? '',
                'peringan_id' => $lastCppt->faktor_peringan_id ?? '',
                'kualitas_nyeri_id' => $lastCppt->kualitas_nyeri_id ?? '',
                'frekuensi_nyeri_id' => $lastCppt->frekuensi_nyeri_id ?? '',
                'menjalar_id' => $lastCppt->menjalar_id ?? '',
                'jenis_nyeri_id' => $lastCppt->jenis_nyeri_id ?? '',
            ];
        }

        return null;
    }

    /**
     * Get vital sign data for CPPT form
     * Priority: CPPT data first, fallback to VitalSign table
     */
    public function getVitalSignForCppt($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $transaction = $this->getTransaksiData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

        if (! $transaction) {
            return $this->getEmptyVitalSignArray();
        }

        // Check if CPPT data exists
        $hasCpptData = Cppt::where('no_transaksi', $transaction->no_transaksi)
            ->where('kd_kasir', $transaction->kd_kasir)
            ->exists();

        if ($hasCpptData) {
            // PERBAIKAN: Get from LATEST CPPT vital signs (bukan berdasarkan tanggal hari ini)
            return $this->getLatestVitalSignFromCppt($kd_pasien, $kd_unit, $transaction->no_transaksi, $transaction->kd_kasir);
        } else {
            // Get from VitalSign table
            return $this->getVitalSignFromTable($transaction->no_transaksi, $transaction->kd_kasir);
        }
    }

    /**
     * Get latest vital sign from ANY CPPT entry (tidak terbatas hari ini)
     */
    private function getLatestVitalSignFromCppt($kd_pasien, $kd_unit, $no_transaksi, $kd_kasir)
    {
        // Get latest CPPT entry untuk pasien ini
        $latestCppt = Cppt::where('no_transaksi', $no_transaksi)
            ->where('kd_kasir', $kd_kasir)
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'desc')
            ->first();

        if (! $latestCppt) {
            return $this->getEmptyVitalSignArray();
        }

        // Get konpas berdasarkan CPPT terakhir
        $latestKonpas = MrKonpas::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('tgl_masuk', $latestCppt->tanggal)
            ->where('urut_masuk', $latestCppt->urut)
            ->orderBy('id_konpas', 'desc')
            ->first();

        if (! $latestKonpas) {
            // Jika tidak ada konpas dari CPPT terakhir, ambil konpas terakhir yang ada
            $latestKonpas = MrKonpas::where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->orderBy('tgl_masuk', 'desc')
                ->orderBy('urut_masuk', 'desc')
                ->orderBy('id_konpas', 'desc')
                ->first();
        }

        if (! $latestKonpas) {
            return $this->getEmptyVitalSignArray();
        }

        // Get konpas details
        $konpasDetails = MrKonpasDtl::join('mr_kondisifisik as kf', 'kf.id_kondisi', '=', 'mr_konpasdtl.id_kondisi')
            ->where('mr_konpasdtl.id_konpas', $latestKonpas->id_konpas)
            ->select('kf.kondisi', 'mr_konpasdtl.hasil', 'kf.urut')
            ->orderBy('kf.urut')
            ->get();

        return $this->mapKonpasToVitalSign($konpasDetails);
    }

    /**
     * Get vital sign data from VitalSign table
     */
    private function getVitalSignFromTable($no_transaksi, $kd_kasir)
    {
        $vitalSign = VitalSign::where('no_transaksi', $no_transaksi)
            ->where('kd_kasir', $kd_kasir)
            ->first();

        if (! $vitalSign) {
            return $this->getEmptyVitalSignArray();
        }

        return [
            'nadi' => $vitalSign->nadi,
            'sistole' => $vitalSign->sistole,
            'diastole' => $vitalSign->diastole,
            'tinggi_badan' => $vitalSign->tinggi_badan,
            'berat_badan' => $vitalSign->berat_badan,
            'respiration' => $vitalSign->respiration,
            'suhu' => $vitalSign->suhu,
            'spo2_tanpa_o2' => $vitalSign->spo2_tanpa_o2,
            'spo2_dengan_o2' => $vitalSign->spo2_dengan_o2,
        ];
    }

    /**
     * Map konpas data to vital sign array
     */
    private function mapKonpasToVitalSign($konpasDetails)
    {
        $vitalSignData = $this->getEmptyVitalSignArray();

        foreach ($konpasDetails as $detail) {
            $kondisi = strtolower(trim($detail->kondisi));

            // Mapping yang lebih spesifik
            if ($kondisi === 'nadi' || str_contains($kondisi, 'nadi')) {
                $vitalSignData['nadi'] = $detail->hasil;
            } elseif ($kondisi === 'tekanan darah (sistole)' || str_contains($kondisi, 'sistole')) {
                $vitalSignData['sistole'] = $detail->hasil;
            } elseif ($kondisi === 'tekanan darah (diastole)' || str_contains($kondisi, 'diastole') || str_contains($kondisi, 'distole')) {
                $vitalSignData['diastole'] = $detail->hasil;
            } elseif ($kondisi === 'tinggi badan' || str_contains($kondisi, 'tinggi badan')) {
                $vitalSignData['tinggi_badan'] = $detail->hasil;
            } elseif ($kondisi === 'berat badan' || str_contains($kondisi, 'berat badan')) {
                $vitalSignData['berat_badan'] = $detail->hasil;
            } elseif ($kondisi === 'respiration rate' || str_contains($kondisi, 'respiration')) {
                $vitalSignData['respiration'] = $detail->hasil;
            } elseif ($kondisi === 'suhu' || str_contains($kondisi, 'suhu')) {
                $vitalSignData['suhu'] = $detail->hasil;
            } elseif ($kondisi === 'spo2 tanpa bantuan o2' || str_contains($kondisi, 'spo2') && str_contains($kondisi, 'tanpa')) {
                $vitalSignData['spo2_tanpa_o2'] = $detail->hasil;
            } elseif ($kondisi === 'spo2 dengan bantuan o2' || str_contains($kondisi, 'spo2') && str_contains($kondisi, 'dengan')) {
                $vitalSignData['spo2_dengan_o2'] = $detail->hasil;
            } elseif ($kondisi === 'sensorium' || str_contains($kondisi, 'sensorium') && str_contains($kondisi, 'sensorium')) {
                $vitalSignData['sensorium'] = $detail->hasil;
            }
        }

        return $vitalSignData;
    }

    /**
     * Get empty vital sign array
     */
    private function getEmptyVitalSignArray()
    {
        return [
            'nadi' => '',
            'sistole' => '',
            'diastole' => '',
            'tinggi_badan' => '',
            'berat_badan' => '',
            'respiration' => '',
            'suhu' => '',
            'spo2_tanpa_o2' => '',
            'spo2_dengan_o2' => '',
        ];
    }

    /**
     * Check if CPPT data exists (helper method)
     */
    public function hasCpptData($no_transaksi, $kd_kasir)
    {
        return Cppt::where('no_transaksi', $no_transaksi)
            ->where('kd_kasir', $kd_kasir)
            ->exists();
    }

    public function getTransaksiData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $lastTransaction = Transaksi::select('kd_kasir', 'no_transaksi')
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_transaksi', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->first();

        return $lastTransaction;
    }

    private function getTipeCpptByUser($tipe = null)
    {
        if (! empty($tipe) && is_numeric($tipe)) {
            return $tipe;
        }

        $user = Auth::user();
        $tipe_cppt = 1;

        if ($user->can('is-dokter-umum') || $user->can('is-dokter-spesialis')) {
            $tipe_cppt = 1; // dokter
        } elseif ($user->can('is-perawat') || $user->can('is-bidan')) {
            $tipe_cppt = 2; // perawat/bidan
        } elseif ($user->can('is-farmasi')) {
            $tipe_cppt = 3; // farmasi
        } elseif ($user->can('is-gizi')) {
            $tipe_cppt = 4; // gizi
        }

        return $tipe_cppt;
    }

    private function getLastDiagnosisByTipeCppt($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $tipeCppt = $this->getTipeCpptByUser();
        

     

        // Ambil diagnosis terakhir berdasarkan tipe PPA yang sama
        $lastCppt = Cppt::join('transaksi as t', function ($join) {
            $join->on('cppt.no_transaksi', '=', 't.no_transaksi')
                ->on('cppt.kd_kasir', '=', 't.kd_kasir');
        })
            ->where('t.kd_pasien', $kd_pasien)
            ->where('t.kd_unit', $kd_unit)
            ->where('cppt.tipe_cppt', $tipeCppt)
            ->orderBy('cppt.tanggal', 'desc')
            ->orderBy('cppt.jam', 'desc')
            ->first();

        if (! $lastCppt) {
            return [];
        }

        // Ambil diagnosis dari CPPT terakhir
        $diagnoses = CpptPenyakit::where('no_transaksi', $lastCppt->no_transaksi)
            ->where('kd_unit', $lastCppt->kd_unit)
            ->where('tgl_cppt', $lastCppt->tanggal)
            ->where('urut_cppt', $lastCppt->urut_total)
            ->get()
            ->pluck('nama_penyakit')
            ->toArray();

        return $diagnoses;
    }

    public function getLastDiagnosesForEdit(Request $request)
    {
        try {
            $lastDiagnoses = $this->getLastDiagnosisByTipeCppt(
                $request->kd_unit,
                $request->kd_pasien,
                $request->tgl_masuk,
                $request->urut_masuk
            );

            return response()->json([
                'status' => 'success',
                'data' => $lastDiagnoses,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function getLastDiagnosesAjax(Request $request)
    {
        try {
            $kd_unit = $request->kd_unit;
            $kd_pasien = $request->kd_pasien;
            $tgl_masuk = $request->tgl_masuk;
            $urut_masuk = $request->urut_masuk;

            $tipeCppt = $this->getTipeCpptByUser();

            // Get transaksi data
            $transaction = $this->getTransaksiData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

            if (! $transaction) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Transaksi tidak ditemukan',
                    'data' => [],
                ]);
            }

            // Ambil CPPT terakhir berdasarkan tipe PPA yang sama
            $lastCppt = Cppt::join('transaksi as t', function ($join) {
                $join->on('cppt.no_transaksi', '=', 't.no_transaksi')
                    ->on('cppt.kd_kasir', '=', 't.kd_kasir');
            })
                ->where('t.kd_pasien', $kd_pasien)
                ->where('t.kd_unit', $kd_unit)
                ->where('cppt.tipe_cppt', $tipeCppt)
                ->orderBy('cppt.tanggal', 'desc')
                ->orderBy('cppt.jam', 'desc')
                ->first();

            if (! $lastCppt) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Tidak ada diagnosis sebelumnya',
                    'data' => [],
                ]);
            }

            // Ambil diagnosis dari CPPT terakhir
            $diagnoses = CpptPenyakit::where('no_transaksi', $lastCppt->no_transaksi)
                ->where('kd_unit', $kd_unit)
                ->where('tgl_cppt', $lastCppt->tanggal)
                ->where('urut_cppt', $lastCppt->urut_total)
                ->get()
                ->pluck('nama_penyakit')
                ->toArray();

            return response()->json([
                'status' => 'success',
                'message' => 'Data ditemukan',
                'data' => $diagnoses,
                'cppt_info' => [
                    'tanggal' => $lastCppt->tanggal,
                    'jam' => $lastCppt->jam,
                    'tipe' => $tipeCppt,
                ],
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => [],
            ], 500);
        }
    }



    private function getKunjungan($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        return Kunjungan::join('transaksi as t', function ($join) {
            $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
            $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
            $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
            $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
        })
            ->where('kunjungan.kd_unit', $kd_unit)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();
    }

    private function getTindakLanjutLabel($code)
    {
        $map = [
            '1' => 'Rawat Inap',
            '2' => 'Kontrol ulang',
            '3' => 'Selesai di klinik ini',
            '4' => 'Konsul/Rujuk internal',
            '5' => 'Rujuk RS lain',
        ];

        return $map[$code] ?? '';
    }

    private function saveInstruksiPpa($kunjungan, $urutTotal, Request $request)
    {
        CpptInstruksiPpa::where('urut_total_cppt', $urutTotal)->delete();

        if ($request->has('perawat_kode') && is_array($request->perawat_kode)) {
            $perawatKodes = $request->perawat_kode;
            $instruksis = $request->instruksi_text ?? [];

            foreach ($perawatKodes as $index => $perawatKode) {
                if (!empty($perawatKode) && !empty($instruksis[$index])) {
                    $cpptInstruksiPpa = [
                        'kd_kasir'              => $kunjungan->kd_kasir,
                        'no_transaksi'          => $kunjungan->no_transaksi,
                        'urut_total_cppt'   => $urutTotal,
                        'ppa'               => $perawatKode,
                        'instruksi'         => $instruksis[$index]
                    ];

                    CpptInstruksiPpa::create($cpptInstruksiPpa);
                }
            }
        }
    }

    private function makeResumeData(Request $request, $diagnosis, $tindakLanjut, $tindakLanjutLabel, $tandaVital)
    {
        return [
            'anamnesis' => $request->anamnesis,
            'diagnosis' => $diagnosis,
            'tindak_lanjut_code' => $tindakLanjut,
            'tindak_lanjut_name' => $tindakLanjutLabel,
            'tgl_kontrol_ulang' => $request->tgl_kontrol ?? '',
            'unit_rujuk_internal' => $request->unit_tujuan ?? '',
            'rs_rujuk' => $request->nama_rs ?? '',
            'rs_rujuk_bagian' => $request->bagian_rs ?? '',
            'konpas' => [
                'sistole' => ['hasil' => $tandaVital[1] ?? ''],
                'distole' => ['hasil' => $tandaVital[2] ?? ''],
                'respiration_rate' => ['hasil' => $tandaVital[5] ?? ''],
                'suhu' => ['hasil' => $tandaVital[8] ?? ''],
                'nadi' => ['hasil' => $tandaVital[0] ?? ''],
                'tinggi_badan' => ['hasil' => $tandaVital[3] ?? ''],
                'berat_badan' => ['hasil' => $tandaVital[4] ?? ''],
            ],
        ];
    }


    public function store($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        // Validation Input
        
        $validatorMessage = [
            'anamnesis.required' => 'Anamnesis harus di isi!',
            'skala_nyeri.min' => 'Nilai skala nyeri minimal 0!',
            'skala_nyeri.max' => 'Nilai skala nyeri minimal 10!',
        ];

     

        $validatedData = $request->validate([
            'anamnesis' => 'required',
            'skala_nyeri' => 'nullable|min:0|max:10',
            'pemeriksaan_fisik' => 'nullable',
            'data_objektif' => 'nullable',
            'planning' => 'nullable',
            'tindak_lanjut' => 'nullable',
            'instruksi' => 'nullable',
        ], $validatorMessage);

        if (empty($request->diagnose_name)) {
            return back()->with('error', 'Diagnosis harus di tambah minimal 1!');
        }

        DB::beginTransaction();

        try {
            // Get kunjungan using private function

            $kunjungan = $this->getKunjungan($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

            if (! $kunjungan) {
                throw new Exception('Data kunjungan tidak ditemukan!');
            }

            $tanggal = $request->tanggal_masuk;
            $jam = $request->jam_masuk;

            // Store CPPT
            $lastUrutTotalCpptMax = Cppt::where('no_transaksi', $kunjungan->no_transaksi)
                ->where('kd_kasir', $kunjungan->kd_kasir)
                ->orderBy('urut_total', 'desc')
                ->first();

            $lastUrutCPPT = Cppt::where('no_transaksi', $kunjungan->no_transaksi)
                ->where('kd_kasir', $kunjungan->kd_kasir)
                ->whereDate('tanggal', $tanggal)
                ->count();
            $lastUrutCPPT += 1;
            $lastUrutTotalCppt = ($lastUrutTotalCpptMax->urut_total ?? 0) + 1;

            $tipe_cppt = $request->tipe_cppt;

            $cpptInsertData = [
                'kd_kasir' => $kunjungan->kd_kasir,
                'no_transaksi' => $kunjungan->no_transaksi,
                'penanggung' => 0,
                'nama_penanggung' => Auth::user()->name,
                'tanggal' => $tanggal,
                'jam' => $jam,
                'obyektif' => $request->data_objektif,
                'assesment' => '',
                'planning' => $request->planning,
                'urut' => $lastUrutTotalCppt,
                'skala_nyeri' => $request->skala_nyeri,
                'lokasi' => $request->lokasi ?? null,
                'durasi' => $request->durasi ?? null,
                'faktor_pemberat_id' => $request->pemberat ?? null,
                'faktor_peringan_id' => $request->peringan ?? null,
                'kualitas_nyeri_id' => $request->kualitas_nyeri ?? null,
                'frekuensi_nyeri_id' => $request->frekuensi_nyeri ?? null,
                'menjalar_id' => $request->menjalar ?? null,
                'jenis_nyeri_id' => $request->jenis_nyeri ?? null,
                'pemeriksaan_fisik' => $request->pemeriksaan_fisik,
                'user_penanggung' => Auth::user()->id,
                'verified' => 0,
                'user_verified' => null,
                'urut_total' => $lastUrutTotalCppt,
                'tipe_cppt' => $this->getTipeCpptByUser($tipe_cppt),
            ];

            Cppt::create($cpptInsertData);

            // Store CPPT Tindak Lanjut
            $tindakLanjut = $request->tindak_lanjut;
            $tindakLanjutLabel = $this->getTindakLanjutLabel($tindakLanjut);

            $cpptTindakLanjutInsertData = [
                'kd_kasir' => $kunjungan->kd_kasir,
                'no_transaksi' => $kunjungan->no_transaksi,
                'tanggal' => $tanggal,
                'jam' => $jam,
                'tindak_lanjut_code' => $tindakLanjut,
                'tindak_lanjut_name' => $tindakLanjutLabel,
                'tgl_kontrol_ulang' => $request->tgl_kontrol ?? '',
                'unit_rujuk_internal' => $request->unit_tujuan ?? '',
                'unit_rawat_inap' => $request->unit_rawat_inap ?? '',
                'rs_rujuk' => $request->nama_rs ?? '',
                'rs_rujuk_bagian' => $request->bagian_rs ?? '',
                'urut' => $lastUrutTotalCppt,
            ];

            CpptTindakLanjut::create($cpptTindakLanjutInsertData);

            // Store diagnosis
            $diagnosisReq = $request->diagnose_name;

            foreach ($diagnosisReq as $diag) {
                $diagInsertData = [
                    'no_transaksi' => $kunjungan->no_transaksi,
                    'kd_unit' => $kunjungan->kd_unit,
                    'tgl_cppt' => $tanggal,
                    'urut_cppt' => $lastUrutTotalCppt,
                    'kd_penyakit' => null,
                    'nama_penyakit' => $diag,
                ];

                CpptPenyakit::create($diagInsertData);
            }

            // Store anamnesis
            $lastUrutMasukAnamnesis = MrAnamnesis::where('kd_pasien', $kunjungan->kd_pasien)
                ->where('kd_unit', $kunjungan->kd_unit)
                ->whereDate('tgl_masuk', $tanggal)
                ->count();
            $lastUrutMasukAnamnesis += 1;

            $anamnesisInsertData = [
                'kd_pasien' => $kunjungan->kd_pasien,
                'kd_unit' => $kunjungan->kd_unit,
                'tgl_masuk' => $tanggal,
                'urut_masuk' => $lastUrutMasukAnamnesis,
                'urut_cppt' => $lastUrutTotalCppt,
                'urut' => 0,
                'anamnesis' => $request->anamnesis,
                'dd' => '',
            ];

            MrAnamnesis::create($anamnesisInsertData);

            // Insert data to mr_konpas
            $konpasMax = MrKonpas::select(['id_konpas'])
                ->whereDate('tgl_masuk', $tanggal)
                ->orderBy('id_konpas', 'desc')
                ->max('id_konpas');

            $newIdKonpas = (empty($konpasMax)) ? date('Ymd', strtotime($tanggal)).'0001' : (int) $konpasMax + 1;

            $lastUrutMasukKonpas = MrKonpas::where('kd_pasien', $kunjungan->kd_pasien)
                ->where('kd_unit', $kunjungan->kd_unit)
                ->whereDate('tgl_masuk', $tanggal)
                ->count();
            $lastUrutMasukKonpas += 1;

            $konpasInsertData = [
                'id_konpas' => $newIdKonpas,
                'kd_pasien' => $kunjungan->kd_pasien,
                'kd_unit' => $kunjungan->kd_unit,
                'tgl_masuk' => $tanggal,
                'urut_masuk' => $urut_masuk,
                'urut_cppt' => $lastUrutTotalCppt,
                'catatan' => '',
            ];

            MrKonpas::create($konpasInsertData);

            // Store tanda vital
            $tandaVitalReq = $request->tanda_vital ?? [];
            $tandaVitalList = MrKondisiFisik::OrderBy('urut')->get();

            $i = 0;
            $vitalSignData = [];
            $mappingKey = [
                'nadi',
                'sistole',
                'diastole',
                'tinggi_badan',
                'berat_badan',
                'respiration',
                'sensorium',
                'golongan_darah',
                'suhu',
                'spo2_tanpa_o2',
                'spo2_dengan_o2',

            ];

            foreach ($tandaVitalList as $item) {
                $konpasDtlInsertData = [
                    'id_konpas' => $newIdKonpas,
                    'id_kondisi' => $item->id_kondisi,
                    'hasil' => $tandaVitalReq[$i] ?? null,
                ];
                $vitalSignData[$mappingKey[$i]] = $tandaVitalReq[$i];

                MrKonpasDtl::create($konpasDtlInsertData);
                $i++;
            }

            $transaksi = $this->asesmenService->getTransaksiData(
                $request->kd_unit,
                $request->kd_pasien,
                $request->tgl_masuk,
                $request->urut_masuk
            );

            $this->asesmenService->store(
                $vitalSignData,
                $request->kd_pasien,
                $transaksi->no_transaksi,
                $transaksi->kd_kasir
            );

            // Create resume using private function
            $resumeData = $this->makeResumeData(
                $request,
                $diagnosisReq,
                $tindakLanjut,
                $tindakLanjutLabel,
                $tandaVitalReq
            );

            $this->createResume($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $resumeData);

            $this->asesmenService->getTransaksiData($kd_pasien, $kd_pasien, $tgl_masuk, $urut_masuk);



            // Save instruksi PPA using private function
            $this->saveInstruksiPpa($kunjungan, $lastUrutTotalCppt, $request);

            DB::commit();

            return redirect()->route('rawat-inap.cppt.index', [
                $kd_unit,
                $kd_pasien,
                $tgl_masuk,
                $urut_masuk,
            ])->with('success', 'Data berhasil disimpan.');

        } catch (Exception $e) {
            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }

    public function update($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        // Validation Input

        $validatorMessage = [
            'anamnesis.required' => 'Anamnesis harus di isi!',
            'skala_nyeri.min' => 'Nilai skala nyeri minimal 0!',
            'skala_nyeri.max' => 'Nilai skala nyeri minimal 10!',
            'tindak_lanjut' => 'Tindak lanjut harus di isi!',
        ];

        $validatedData = $request->validate([
            'anamnesis' => 'required',
            'skala_nyeri' => 'min:0|max:10',
            'tindak_lanjut' => 'nullable',
        ], $validatorMessage);

        if (empty($request->diagnose_name)) {
            return back()->with('error', 'Diagnosis harus di tambah minimal 1!');
        }

        DB::beginTransaction();

        try {
            // Get kunjungan using private function
            $kunjungan = $this->getKunjungan($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

           
            $tglCpptReq = $request->tgl_cppt;
            $urutCpptReq = $request->urut_total_cppt;
            $unitCpptReq = $request->unit_cppt;
            $noTransaksiCpptReq = $request->no_transaksi;


           
            // Update anamnesis
            MrAnamnesis::where('kd_pasien', $kunjungan->kd_pasien)
                ->where('kd_unit', $unitCpptReq)
                // ->where('tgl_masuk', $tgl_masuk)
                ->where('urut_cppt', $urutCpptReq)
                ->update([
                    'anamnesis' => $request->anamnesis,
                ]);
             

            $konpas = MrKonpas::where('kd_pasien', $kunjungan->kd_pasien)
                ->where('kd_unit', $unitCpptReq)
                // ->where('tgl_masuk', $tgl_masuk)
                ->where('urut_cppt', $urutCpptReq)
                ->first();
            

            // Update tanda vital
            $tandaVitalReq = $request->tanda_vital;
            $tandaVitalList = MrKondisiFisik::OrderBy('urut')->get();

            $i = 0;
            foreach ($tandaVitalList as $item) {
                MrKonpasDtl::where('id_konpas', $konpas->id_konpas)
                    ->where('id_kondisi', $item->id_kondisi)
                    ->update([
                        'hasil' => $tandaVitalReq[$i],
                        
                    ]);

                $i++;
            }

       

            
            // Update CPPT
            $cppt = Cppt::where('no_transaksi', $kunjungan->no_transaksi)
                ->where('kd_kasir', $kunjungan->kd_kasir)
                ->where('tanggal', $tglCpptReq)
                ->where('urut_total', $urutCpptReq)
                ->first();

         
        

            $new_tgl = date('Y-m-d H:i:s', strtotime($request->tanggal_masuk));
            $cpptDataUpdate = [
                'obyektif' => $request->data_objektif,
                'planning' => $request->planning,
                'skala_nyeri' => $request->skala_nyeri,
                'lokasi' => $request->lokasi,
                'durasi' => $request->durasi,
                'faktor_pemberat_id' => $request->pemberat,
                'faktor_peringan_id' => $request->peringan,
                'frekuensi_nyeri_id' => $request->frekuensi_nyeri,
                'menjalar_id' => $request->menjalar,
                'jenis_nyeri_id' => $request->jenis_nyeri,
                'pemeriksaan_fisik' => $request->pemeriksaan_fisik,
                'tanggal' => $new_tgl,
                'jam' => date('H:i:s', strtotime($request->jam_masuk_edit))
            ];

          
            Cppt::where('no_transaksi', $kunjungan->no_transaksi)
                ->where('kd_kasir', $kunjungan->kd_kasir)
                ->where('tanggal', $tglCpptReq)
                ->where('urut_total', $urutCpptReq)
                ->update($cpptDataUpdate);

            // Update CPPT Tindak Lanjut
            $tindakLanjut = $request->tindak_lanjut;
            $tindakLanjutLabel = $this->getTindakLanjutLabel($tindakLanjut);

            $cpptTL = [
                'tindak_lanjut_code' => $tindakLanjut,
                'tindak_lanjut_name' => $tindakLanjutLabel,
                'tanggal' => $new_tgl
            ];

            CpptTindakLanjut::where('kd_kasir', $cppt->kd_kasir)
                ->where('no_transaksi', $cppt->no_transaksi)
                ->where('tanggal', $cppt->tanggal)
                ->where('jam', operator: $cppt->jam)
                ->update($cpptTL);

            // Update diagnosis
            $diagnosisList = $request->diagnose_name;

            // Delete old diagnose
            CpptPenyakit::where('no_transaksi', $noTransaksiCpptReq)
                ->where('kd_unit', $unitCpptReq)
                ->where('tgl_cppt', $tgl_masuk)
                ->where('urut_cppt', $urutCpptReq)
                ->delete();

            foreach ($diagnosisList as $diag) {
                $diagInsertData = [
                    'no_transaksi' => $kunjungan->no_transaksi,
                    'kd_unit' => $kunjungan->kd_unit,
                    'tgl_cppt' => $new_tgl,
                    'urut_cppt' => $cppt->urut_total,
                    'kd_penyakit' => null,
                    'nama_penyakit' => $diag,
                ];

                CpptPenyakit::create($diagInsertData);
            }

            // Create resume using private function
            $resumeData = $this->makeResumeData($request, $diagnosisList, $tindakLanjut, $tindakLanjutLabel, $tandaVitalReq);
            $this->createResume($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $resumeData);

            // Save instruksi PPA using private function
            $this->saveInstruksiPpa($kunjungan, $cppt->urut_total, $request);

            DB::commit();

            return redirect()->route('rawat-inap.cppt.index', [
                $kd_unit,
                $kd_pasien,
                $tgl_masuk,
                $urut_masuk,
            ])->with('success', 'Data berhasil Diubah.');
        } catch (Exception $e) {
            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }

    public function getInstruksiPpaAjax(Request $request)
    {
        try {
            $urutTotal = $request->urut_total;

            $instruksiPpa = CpptInstruksiPpa::where('urut_total_cppt', $urutTotal)->get();

            return response()->json([
                'status' => 'success',
                'data' => $instruksiPpa,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function verifikasiCppt($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {

        try {
            $kdPasienReq = $request->kd_pasien;
            $noTransaksiReq = $request->no_transaksi;
            $kdKasirReq = $request->kd_kasir;
            $tglReq = $request->tanggal;
            $urutReq = $request->urut;

            if (empty($kdPasienReq) || empty($noTransaksiReq) || empty($kdKasirReq) || empty($tglReq) || empty($urutReq)) {
                return back()->with('error', 'Salah satu key verifikasi kosong!');
            }

            Cppt::where('no_transaksi', $noTransaksiReq)
                ->where('kd_kasir', $kdKasirReq)
                ->where('tanggal', $tglReq)
                ->where('urut', $urutReq)
                ->update([
                    'verified' => 1,
                    'user_verified' => Auth::user()->id,
                ]);

            return back()->with('success', 'Cppt berhasil di verifikasi');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
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

    public function cpptGizi($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->dataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
        $tandaVital = MrKondisiFisik::OrderBy('urut')->get();
        $vitalSignData = $this->getVitalSignForCppt($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

        $lastDiagnoses = $this->getLastDiagnosisByTipeCppt($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
        $karyawan = HrdKaryawan::orderBy('kd_karyawan', 'asc')->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.cppt.adime.index', [
            'vitalSignData' => $vitalSignData,
            'lastDiagnoses' => $lastDiagnoses,
            'tandaVital' => $tandaVital,
            'dataMedis' => $dataMedis,
            'karyawan' => $karyawan,
        ]);
    }

    public function getCpptAdime(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        try {

             // REFACTORED
            $additionalWheres = [
                't.kd_pasien' => $request->kd_pasien,
                't.kd_unit' => $request->kd_unit,
                't.no_transaksi' => $request->no_transaksi,
                'cppt.tanggal' => $request->tanggal,
                'cppt.urut' => $request->urut,
            ];

           
            
            $tandaVital = MrKondisiFisik::OrderBy('urut')->get();
            $vitalSignData = $this->getVitalSignForCppt($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
            $getCppt = $this->buildCpptQuery($additionalWheres)->get();
            $cppt = $this->transformCpptData($getCppt, true)-> first();
            $lastDiagnoses = $this->getLastDiagnosisByTipeCppt($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
            $karyawan = HrdKaryawan::orderBy('kd_karyawan', 'asc')->get();
           

        
            if (count($cppt) < 1) {
                return redirect()->back()->with('error', 'Data CPPT tidak ditemukan!');
            }

            $dataMedis = $this->dataMedis($kd_unit, $kd_pasien, $tgl_masuk, $request->urut_masuk);

            return view('unit-pelayanan.rawat-inap.pelayanan.cppt.adime.index', [
                'cppt' => $cppt,
                'dataMedis' => $dataMedis,
                'vitalSignData' => $vitalSignData,
                'tandaVital' => $tandaVital,
                'lastDiagnoses' => $lastDiagnoses,
                'karyawan' => $karyawan,
                'isEdit' => true,
            ]);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan server: '.$e->getMessage());
        }
    }

    private function buildCpptQuery($additionalWheres = [])
    {
        return Cppt::with(['dtCppt', 'pemberat', 'peringan', 'kualitas', 'frekuensi', 'menjalar', 'jenis', 'userPenanggung'])
            ->select([
                'cppt.*',
                't.kd_pasien',
                't.kd_unit',
                'u.nama_unit',
                'a.anamnesis',
                'ctl.tindak_lanjut_code',
                'ctl.tindak_lanjut_name',
                'ctl.tgl_kontrol_ulang',
                'ctl.unit_rujuk_internal',
                'ctl.unit_rawat_inap',
                'ctl.rs_rujuk',
                'ctl.rs_rujuk_bagian',
                'kp.id_konpas',
                'kf.id_kondisi',
                'kf.kondisi',
                'kf.satuan',
                'kpd.hasil',
                'p.kd_penyakit',
                'p.penyakit',
                'cp.nama_penyakit',
            ])
            // transaksi
            ->join('transaksi as t', function ($join) {
                $join->on('cppt.no_transaksi', '=', 't.no_transaksi')
                    ->on('cppt.kd_kasir', '=', 't.kd_kasir');
            })
            // unit
            ->join('unit as u', 't.kd_unit', '=', 'u.kd_unit')
            // anamnesis
            ->leftJoin('mr_anamnesis as a', function ($j) {
                $j->on('a.kd_pasien', '=', 't.kd_pasien')
                    ->on('a.kd_unit', '=', 't.kd_unit')
                    // ->on('a.tgl_masuk', '=', 'cppt.tanggal')
                    ->on('a.urut_cppt', '=', 'cppt.urut_total');
            })
            // tindak lanjut (KONSISTEN: gunakan urut_total)
            ->leftJoin('cppt_tindak_lanjut as ctl', function ($j) {
                $j->on('ctl.no_transaksi', '=', 'cppt.no_transaksi')
                    ->on('ctl.kd_kasir', '=', 'cppt.kd_kasir')
                    ->on('ctl.tanggal', '=', 'cppt.tanggal')
                    ->on('ctl.urut', '=', 'cppt.urut_total'); // Fixed: urut_total
            })
            // tanda vital
            ->leftJoin('mr_konpas as kp', function ($j) {
                $j->on('kp.kd_pasien', '=', 't.kd_pasien')
                    ->on('kp.kd_unit', '=', 't.kd_unit')
                    // ->on('kp.tgl_masuk', '=', 'cppt.tanggal')
                    ->on('kp.urut_cppt', '=', 'cppt.urut_total');
            })
            ->leftJoin('mr_konpasdtl as kpd', 'kpd.id_konpas', '=', 'kp.id_konpas')
            ->leftJoin('mr_kondisifisik as kf', 'kf.id_kondisi', '=', 'kpd.id_kondisi')
            // diagnosa
            ->leftJoin('cppt_penyakit as cp', function ($j) {
                $j->on('cp.kd_unit', '=', 't.kd_unit')
                    ->on('cp.no_transaksi', '=', 'cppt.no_transaksi')
                    // ->on('cp.tgl_cppt', '=', 'cppt.tanggal')
                    ->on('cp.urut_cppt', '=', 'cppt.urut_total');
            })
            ->leftJoin('penyakit as p', 'p.kd_penyakit', '=', 'cp.kd_penyakit')
            // Apply additional wheres
            ->when($additionalWheres, function ($query) use ($additionalWheres) {
                foreach ($additionalWheres as $column => $value) {
                    $query->where($column, $value);
                }
            })
            ->orderBy('cppt.tanggal', 'desc')
            ->orderBy('cppt.jam', 'desc')
            ->orderBy('kf.urut');
    }

    private function transformCpptData($getCppt, $includeNames = false)
    {   
        return $getCppt->groupBy(['urut_total'])->map(function ($item) use ($includeNames) {
            $instruksiPpa = CpptInstruksiPpa::where('urut_total_cppt', $item->first()->urut_total)
                ->where('kd_kasir', $item->first()->kd_kasir)
                ->where('no_transaksi', $item->first()->no_transaksi)
                ->get();
           
           

            $transformedInstruksi = $includeNames ? $this->transformInstruksiWithNames($instruksiPpa) : $instruksiPpa;

            return [
                'kd_pasien' => $item->first()->kd_pasien,
                'no_transaksi' => $item->first()->no_transaksi,
                'jam_masuk' => $item->first()->jam,
                'tanggal_masuk' => $item->first()->tanggal,
                'kd_kasir' => $item->first()->kd_kasir,
                'kd_unit' => $item->first()->kd_unit,
                'nama_unit' => $item->first()->nama_unit,
                'penanggung' => $item->first()->dtCppt,
                'nama_penanggung' => $item->first()->userPenanggung->viewKaryawan->gelar_depan . ' ' . $item->first()->userPenanggung->viewKaryawan->nama . ' ' . $item->first()->userPenanggung->viewKaryawan->gelar_belakang,
                'jenis_tenaga' => $item->first()->userPenanggung->viewKaryawan->sub_detail ?? '-',
                'tanggal' => $item->first()->tanggal,
                'jam' => $item->first()->jam,
                'obyektif' => $item->first()->obyektif,
                'planning' => $item->first()->planning,
                'urut' => $item->first()->urut,
                'skala_nyeri' => $item->first()->skala_nyeri,
                'lokasi' => $item->first()->lokasi,
                'durasi' => $item->first()->durasi,
                'pemberat' => $item->first()->pemberat,
                'peringan' => $item->first()->peringan,
                'kualitas' => $item->first()->kualitas,
                'frekuensi' => $item->first()->frekuensi,
                'menjalar' => $item->first()->menjalar,
                'jenis' => $item->first()->jenis,
                'pemeriksaan_fisik' => $item->first()->pemeriksaan_fisik,
                'urut_total' => $item->first()->urut_total,
                'user_penanggung' => $item->first()->user_penanggung,
                'anamnesis' => $item->first()->anamnesis,
                'tindak_lanjut_code' => $item->first()->tindak_lanjut_code,
                'tindak_lanjut_name' => $item->first()->tindak_lanjut_name,
                'tgl_kontrol_ulang' => $item->first()->tgl_kontrol_ulang,
                'unit_rujuk_internal' => $item->first()->unit_rujuk_internal,
                'unit_rawat_inap' => $item->first()->unit_rawat_inap,
                'rs_rujuk' => $item->first()->rs_rujuk,
                'rs_rujuk_bagian' => $item->first()->rs_rujuk_bagian,
                'verified' => $item->first()->verified,
                'user_verified' => $item->first()->user_verified,
                'tipe_cppt' => $item->first()->tipe_cppt ?? null, // Added for index
                'kondisi' => [
                    'id_konpas' => (int) $item->first()->id_konpas,
                    'konpas' => $item->groupBy('id_kondisi')->map(function ($konpas) {
                        return [
                            'id_kondisi' => $konpas->first()->id_kondisi,
                            'nama_kondisi' => $konpas->first()->kondisi,
                            'satuan' => $konpas->first()->satuan,
                            'hasil' => $konpas->first()->hasil,
                        ];
                    }),
                ],
                'cppt_penyakit' => $item->groupBy('nama_penyakit')->map(function ($penyakit) {
                    return ['nama_penyakit' => $penyakit->first()->nama_penyakit];
                }),
                'penyakit' => $item->groupBy('kd_penyakit')->map(function ($penyakit) {
                    return [
                        'kd_penyakit' => $penyakit->first()->kd_penyakit,
                        'nama_penyakit' => $penyakit->first()->penyakit,
                    ];
                }),
                'instruksi_ppa' => $instruksiPpa,
                'instruksi_ppa_nama' => $transformedInstruksi, // Only populated if $includeNames=true
            ];
        });
    }

    private function transformInstruksiWithNames($instruksiPpa)
    {
        return $instruksiPpa->map(function ($instruksi) {
            return [
                'id' => $instruksi->id,
                'ppa' => $instruksi->ppa,
                'instruksi' => $instruksi->instruksi,
                'nama_lengkap' => $this->getNamaLengkapByKode($instruksi->ppa),
                'urut_total_cppt' => $instruksi->urut_total_cppt,
            ];
        });
    }
}
