<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\AsalIGD;
use App\Models\Dokter;
use App\Models\DokterKlinik;
use App\Models\ICD9Baru;
use App\Models\Kunjungan;
use App\Models\ListTindakanPasien;
use App\Models\MrPenyakit;
use App\Models\Penyakit;
use App\Models\RmeAsesmen;
use App\Models\RmeAsesmenPemeriksaanFisik;
use App\Models\RMEResume;
use App\Models\RmeResumeDtl;
use App\Models\SegalaOrder;
use App\Models\Unit;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Services\AsesmenService;
use App\Services\BaseService;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class RawatInapResumeController extends Controller
{
    protected $asesmenService;
    private $baseService;
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
        $this->asesmenService = new AsesmenService();
        $this->baseService = new BaseService();
    }

    public function index(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);


        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        // ambil data Resume
        $dataResume = RMEResume::with(['listTindakanPasien.produk', 'rmeResumeDet', 'kunjungan'])
            ->where('kd_pasien', $kd_pasien)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->where('kd_unit', $dataMedis->kd_unit)
            ->orderBy('tgl_masuk', 'desc')
            ->first();

        $search = $request->input('search');
        $periode = $request->input('periode');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $dataGet = RMEResume::with(['rmeResumeDet', 'kunjungan.dokter', 'unit'])
            // filter data
            ->when($periode, function ($query) use ($periode) {
                $now = now();
                switch ($periode) {
                    case 'option1':
                        return $query->whereYear('tgl_masuk', $now->year)
                            ->whereMonth('tgl_masuk', $now->month);
                    case 'option2':
                        return $query->where('tgl_masuk', '>=', $now->subMonth(1));
                    case 'option3':
                        return $query->where('tgl_masuk', '>=', $now->subMonths(3));
                    case 'option4':
                        return $query->where('tgl_masuk', '>=', $now->subMonths(6));
                    case 'option5':
                        return $query->where('tgl_masuk', '>=', $now->subMonths(9));
                    default:
                        return $query;
                }
            })
            ->when($startDate, function ($query) use ($startDate) {
                return $query->whereDate('tgl_masuk', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                return $query->whereDate('tgl_masuk', '<=', $endDate);
            })
            ->when($search, function ($query, $search) {
                $search = strtolower($search);
                return $query->orWhereHas('kunjungan.dokter', function ($q) use ($search) {
                    $q->whereRaw('LOWER(kd_dokter) like ?', ["%$search%"])
                        ->orWhereRaw('LOWER(nama_lengkap) like ?', ["%$search%"]);
                });
            })
            // end filter
            ->where('kd_pasien', $kd_pasien)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->where('kd_unit', $dataMedis->kd_unit)
            ->orderBy('tgl_masuk', 'desc')
            ->paginate(10);

        // Ambil semua dokter
        $dataDokter = DokterKlinik::with(['dokter', 'unit'])
            ->where('kd_unit', 3)
            ->whereRelation('dokter', 'status', 1)
            ->get();

        // Ambil dokter yang aktif saat ini
        $dokterPengirim = DokterKlinik::with(['konsultasi' => function ($query) {
            $query->with('dokter');
        }])
            ->where('kd_unit', 3)
            ->whereRelation('dokter', 'status', 1)
            ->first();

        // Mengambil data hasil pemeriksaan laboratorium
        $dataLabor = SegalaOrder::with(['details.produk'])
            ->where('kd_pasien', $kd_pasien)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->where('kd_unit', $dataMedis->kd_unit)
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
                    $item->kd_unit,
                    $item->urut_masuk
                );
                $detail->labResults = $labResults;
            }
            return $item;
        });

        // Mengambil data hasil pemeriksaan radiologi
        $dataRagiologi = SegalaOrder::with(['details.produk'])
            ->where('kd_pasien', $kd_pasien)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->where('kd_unit', $dataMedis->kd_unit)
            ->whereHas('details.produk', function ($query) {
                $query->where('kategori', 'RD');
            })
            ->orderBy('tgl_order', 'desc')
            ->get();

        // Kode ICD 10 (Koder)
        $kodeICD = Penyakit::all();
        // Kode ICD-9 CM (Koder)
        $kodeICD9 = ICD9Baru::all();

        // Mengambil data obat
        $riwayatObatHariIni = $this->getRiwayatObatHariIni($dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk);

        // unit palayanan
        $unitKonsul = Unit::where('kd_bagian', 2)
            ->where('aktif', 1)
            ->get();

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        $vitalSign = $this->asesmenService->getVitalSignData($dataMedis->kd_kasir, $dataMedis->no_transaksi);

        return view(
            'unit-pelayanan.rawat-inap.pelayanan.resume.index',
            compact(
                'dataMedis',
                'dataDokter',
                'dokterPengirim',
                'dataLabor',
                'dataRagiologi',
                'riwayatObatHariIni',
                'kodeICD',
                'kodeICD9',
                'dataResume',
                'dataGet',
                'unitKonsul',
                'vitalSign'
            )
        );
    }

    public function detail($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $idHash)
    {
        $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        // ambil data Resume
        $dataResume = RMEResume::where('kd_pasien', $dataMedis->kd_pasien)
            ->whereDate('tgl_masuk', $dataMedis->tgl_masuk)
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->where('kd_unit', $dataMedis->kd_unit)
            ->orderBy('tgl_masuk', 'desc')
            ->first();

        if (!$dataResume) {
            abort(404, 'Data resume not found');
        }

        // get data medis
        $asalIGD = AsalIGD::where('kd_kasir', $dataMedis->kd_kasir)->where('no_transaksi', $dataMedis->no_transaksi)->first();
        $kunjunganIGD = null;

        if (!empty($asalIGD)) {
            $kunjunganIGD = $this->baseService->getDataMedisbyTransaksi($asalIGD->kd_kasir_asal, $asalIGD->no_transaksi_asal);
        }

        // Mengambil data hasil pemeriksaan laboratorium
        $dataLabor = SegalaOrder::with(['details', 'details.produk', 'produk.labHasil'])
            ->where('kategori', 'LB')
            ->where(function ($query) use ($kunjunganIGD, $dataMedis) {
                $query->where(function ($q) use ($kunjunganIGD) {
                    $q->where('kd_pasien', $kunjunganIGD->kd_pasien ?? '')
                        ->whereDate('tgl_masuk', $kunjunganIGD->tgl_masuk ?? '')
                        ->where('urut_masuk', $kunjunganIGD->urut_masuk ?? '')
                        ->where('kd_unit', $kunjunganIGD->kd_unit ?? '');
                })
                    ->orWhere(function ($q) use ($dataMedis) {
                        $q->where('kd_pasien', $dataMedis->kd_pasien)
                            ->whereDate('tgl_masuk', $dataMedis->tgl_masuk)
                            ->where('urut_masuk', $dataMedis->urut_masuk)
                            ->where('kd_unit', $dataMedis->kd_unit);
                    });
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
                    $item->kd_unit,
                    $item->urut_masuk
                );
                $detail->labResults = $labResults;
            }
            return $item;
        });

        // Mengambil data hasil pemeriksaan radiologi
        $dataRadiologi = SegalaOrder::with(['details.produk'])
            ->where('kategori', 'RD')
            ->where(function ($query) use ($kunjunganIGD, $dataMedis) {
                $query->where(function ($q) use ($kunjunganIGD) {
                    $q->where('kd_pasien', $kunjunganIGD->kd_pasien ?? '')
                        ->whereDate('tgl_masuk', $kunjunganIGD->tgl_masuk ?? '')
                        ->where('urut_masuk', $kunjunganIGD->urut_masuk ?? '')
                        ->where('kd_unit', $kunjunganIGD->kd_unit ?? '');
                })
                    ->orWhere(function ($q) use ($dataMedis) {
                        $q->where('kd_pasien', $dataMedis->kd_pasien)
                            ->whereDate('tgl_masuk', $dataMedis->tgl_masuk)
                            ->where('urut_masuk', $dataMedis->urut_masuk)
                            ->where('kd_unit', $dataMedis->kd_unit);
                    });
            })
            ->orderBy('tgl_order', 'desc')
            ->get();

        // Mengambil data obat
        $riwayatObatHariIni = $this->getRiwayatObatHariIni($dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $kunjunganIGD);
        $resepPulang = $this->getObatPulang($dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $kunjunganIGD);

        // tindakan
        $tindakan = ListTindakanPasien::with(['produk'])
            ->where(function ($q) use ($kunjunganIGD) {
                $q->where('kd_pasien', $kunjunganIGD->kd_pasien ?? '')
                    ->whereDate('tgl_masuk', $kunjunganIGD->tgl_masuk ?? '')
                    ->where('urut_masuk', $kunjunganIGD->urut_masuk ?? '')
                    ->where('kd_unit', $kunjunganIGD->kd_unit ?? '');
            })
            ->orWhere(function ($q) use ($dataMedis) {
                $q->where('kd_pasien', $dataMedis->kd_pasien)
                    ->whereDate('tgl_masuk', $dataMedis->tgl_masuk)
                    ->where('urut_masuk', $dataMedis->urut_masuk)
                    ->where('kd_unit', $dataMedis->kd_unit);
            })
            ->get();

        // get last ttv
        $vitalSign = $this->asesmenService->getVitalSignData($dataMedis->kd_kasir, $dataMedis->no_transaksi);

        // Kode ICD 10 (Koder)
        $kodeICD = Penyakit::all();
        // Kode ICD-9 CM (Koder)
        $kodeICD9 = ICD9Baru::all();
        // unit palayanan
        $unitKonsul = Unit::where('kd_bagian', 2)
            ->where('aktif', 1)
            ->get();

        return view(
            'unit-pelayanan.rawat-inap.pelayanan.resume.resume-medis.detail',
            compact(
                'dataMedis',
                'dataResume',
                'dataLabor',
                'dataRadiologi',
                'riwayatObatHariIni',
                'vitalSign',
                'kodeICD',
                'kodeICD9',
                'unitKonsul',
                'resepPulang',
                'tindakan'
            )
        );
    }

    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();
        try {

            $validator = Validator::make($request->all(), [
                'anamnesis' => 'required|string',
                'pemeriksaan_penunjang' => 'nullable|string',
                'diagnosis' => 'required|json',
                'penyakit' => 'required|json',
                // 'icd_10' => 'required|json',
                'icd_9' => 'required|json',
                // 'alergi' => 'nullable|json',

                // RmeResumeDtl
                'tindak_lanjut_code' => 'required',
                'tindak_lanjut_name' => 'required',
                'tgl_kontrol_ulang' => 'nullable|string',
                'rs_rujuk' => 'nullable|string',
                'rs_rujuk_bagian' => 'nullable|string',
                'unit_rujuk_internal' => 'nullable|string',
                'unit_rawat_inap' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            // get data medis
            $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
            if (!$dataMedis) throw new Exception('Data kunjungan tidak ditemukan');

            $resume = RMEResume::find($id);
            if (empty($resume)) throw new Exception('Data resume tidak ditemukan');

            // newline
            $cleanArray = function ($array) {
                return array_map(function ($item) {
                    return trim(preg_replace('/\s+/', ' ', $item));
                }, $array);
            };

            // Data baru
            $newDiagnosis = json_decode($request->diagnosis, true);
            // $newIcd10 = json_decode($request->icd_10, true);
            $newIcd9 = json_decode($request->icd_9, true);
            $newAlergi = json_decode($request->alergi, true);

            // Bersihkan data newline
            $newDiagnosis = $cleanArray($newDiagnosis);
            $penyakit = json_decode($request->penyakit, true);
            // $newIcd10 = $cleanArray($newIcd10);
            $newIcd9 = $cleanArray($newIcd9);
            $newAlergi = $cleanArray($newAlergi);

            $resume->update([
                'anamnesis' => trim($request->anamnesis),
                'pemeriksaan_penunjang' => trim($request->pemeriksaan_penunjang),
                'diagnosis' => $newDiagnosis,
                'icd_10' => $penyakit,
                'icd_9' => $newIcd9,
                'alergi' => $newAlergi,
                'anjuran_diet' => $request->anjuran_diet,
                'anjuran_edukasi' => $request->anjuran_edukasi,
                // 'status' => 1,
                'user_validasi' => Auth::id()
            ]);

            // Prepare data for RmeResumeDtl update
            $resumeDtlData = [
                'tindak_lanjut_name' => trim($request->tindak_lanjut_name),
                'tindak_lanjut_code' => $request->tindak_lanjut_code,
                'rs_rujuk' => $request->rs_rujuk,
                'rs_rujuk_bagian' => $request->rs_rujuk_bagian,
                'unit_rujuk_internal' => $request->unit_rujuk_internal,
                'unit_rawat_inap' => $request->unit_rawat_inap
            ];

            // Handle tgl_kontrol_ulang - only set if it's a valid date
            $tglKontrolUlang = $request->tgl_kontrol_ulang;
            if ($tglKontrolUlang && $tglKontrolUlang !== 'sembuh' && $tglKontrolUlang !== 'meninggal') {
                // Validate if it's a proper date format
                $date = \DateTime::createFromFormat('Y-m-d', $tglKontrolUlang);
                if ($date && $date->format('Y-m-d') === $tglKontrolUlang) {
                    $resumeDtlData['tgl_kontrol_ulang'] = $tglKontrolUlang;
                }
                // If it's not a valid date, we don't set it (leave as null)
            }

            RmeResumeDtl::updateOrCreate(
                ['id_resume' => $id],
                $resumeDtlData
            );

            // delete mr_penyakit
            MrPenyakit::where('kd_pasien', $dataMedis->kd_pasien)
                ->whereDate('tgl_masuk', $dataMedis->tgl_masuk)
                ->where('urut_masuk', $dataMedis->urut_masuk)
                ->where('kd_unit', $dataMedis->kd_unit)
                ->delete();

            // store data ke mr_penyakit
            $urutPenyakit = 0;

            foreach ($penyakit as $penyakitItem) {
                MrPenyakit::create([
                    'kd_penyakit' => $penyakitItem['kd_penyakit'],
                    'kd_pasien' => $dataMedis->kd_pasien,
                    'kd_unit' => $dataMedis->kd_unit,
                    'tgl_masuk' => $dataMedis->tgl_masuk,
                    'urut_masuk' => $dataMedis->urut_masuk,
                    'urut' => $urutPenyakit,
                    'stat_diag' => $penyakitItem['stat_diag'],
                    'kasus' => $penyakitItem['kasus'],
                    'tindakan' => 99,
                    'perawatan' => 99,
                ]);

                $urutPenyakit++;
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diperbarui',
                'data' => $resume
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function validasiResume($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        DB::beginTransaction();

        try {
            $resumeId = decrypt($request->resume_id);

            $resume = RMEResume::find($resumeId);

            if (empty($resume)) {
                return response()->json([
                    'status'    => 'error',
                    'message'   => 'Data resume gagal di cari !',
                    'data'      => []
                ]);
            }

            $resume->status = 1;
            $resume->save();

            DB::commit();

            return response()->json([
                'status'    => 'success',
                'message'   => 'OK',
                'data'      => []
            ]);
        } catch (Exception $e) {

            DB::rollBack();
            return response()->json([
                'status'    => 'error',
                'message'   => 'Internal server error !',
                'data'      => []
            ]);
        }
    }


    public function pdf($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $idEncrypt)
    {
        $resumeId = decrypt($idEncrypt);
        $resume = RMEResume::with(['pasien', 'rmeResumeDet', 'unit'])
            ->where('id', $resumeId)
            ->first();

        $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        if (empty($resume)) return back()->with('error', 'Gagal menemukan data resume !');

        // get last ttv
        $vitalSign = $this->asesmenService->getVitalSignData($dataMedis->kd_kasir, $dataMedis->no_transaksi);

        $sistole = $vitalSign->sistole ?? '-';
        $distole = $vitalSign->diastole ?? '-';
        $tdKonpas = "TD : $sistole/$distole mmHg";

        $rrKonpas = $vitalSign->respiration ?? '-';
        $rr = "RR : $rrKonpas x/mnt";

        $nadiKonpas = $vitalSign->nadi ?? '-';
        $resp = "Nadi : $nadiKonpas x/mnt";

        $tempKonpas = $vitalSign->suhu ?? '-';
        $temp = "Suhu : $tempKonpas C";

        $tbKonpas = $vitalSign->tinggi_badan ?? '-';
        $tb = "TB : $tbKonpas cm";

        $bbKonpas = $vitalSign->berat_badan ?? '-';
        $bb = "BB : $bbKonpas kg";

        $hasilKonpas = "$tdKonpas, $rr, $resp, $temp, $tb, $bb";

        $resepRawat = $this->getRiwayatObatHariIni($dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk);
        $resepPulang = $this->getObatPulang($dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk);

        $labor = SegalaOrder::with(['details'])
            ->where('kd_pasien', $dataMedis->kd_pasien)
            ->where('kd_unit', $dataMedis->kd_unit)
            ->whereDate('tgl_masuk', date('Y-m-d', strtotime($dataMedis->tgl_masuk)))
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->where('kategori', 'LB')
            ->get();

        $radiologi = SegalaOrder::with(['details'])
            ->where('kd_pasien', $dataMedis->kd_pasien)
            ->where('kd_unit', $dataMedis->kd_unit)
            ->whereDate('tgl_masuk', date('Y-m-d', strtotime($dataMedis->tgl_masuk)))
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->where('kategori', 'RD')
            ->get();

        $tindakan = ListTindakanPasien::with(['produk'])
            ->where('kd_pasien', $dataMedis->kd_pasien)
            ->where('kd_unit', $dataMedis->kd_unit)
            ->whereDate('tgl_masuk', date('Y-m-d', strtotime($dataMedis->tgl_masuk)))
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->get();


        $lastAsesmen = RmeAsesmen::with(['pemeriksaanFisik'])
            ->where('kd_pasien', $dataMedis->kd_pasien)
            ->where('kd_unit', $dataMedis->kd_unit)
            ->whereDate('tgl_masuk', date('Y-m-d', strtotime($dataMedis->tgl_masuk)))
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->where('kategori', 1)
            ->where('sub_kategori', 1)
            ->first();

        $pemeriksaanFisik = RmeAsesmenPemeriksaanFisik::with(['itemFisik'])
            ->where('id_asesmen', ($lastAsesmen->id ?? 0))
            ->where('is_normal', 0)
            ->get();

        $qrCode = base64_encode(QrCode::format('png')->size(100)->errorCorrection('H')->generate($dataMedis->dokter->nama_lengkap));

        $pdf = Pdf::loadView('unit-pelayanan.rawat-inap.pelayanan.resume.resume-medis.print', compact(
            'resume',
            'dataMedis',
            'hasilKonpas',
            'labor',
            'radiologi',
            'tindakan',
            'pemeriksaanFisik',
            'resepRawat',
            'resepPulang',
            'qrCode'
        ))
            ->setPaper('a4', 'potrait');
        return $pdf->stream('resume_' . $resume->kd_pasien . '_' . $resume->tgl_konsul . '.pdf');
    }

    private function getRiwayatObatHariIni($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $kunjunganIGD = null)
    {
        return DB::table('MR_RESEP')
            ->join('DOKTER', 'MR_RESEP.KD_DOKTER', '=', 'DOKTER.KD_DOKTER')
            ->leftJoin('MR_RESEPDTL', 'MR_RESEP.ID_MRRESEP', '=', 'MR_RESEPDTL.ID_MRRESEP')
            ->leftJoin('APT_OBAT', 'MR_RESEPDTL.KD_PRD', '=', 'APT_OBAT.KD_PRD')
            ->leftJoin('APT_SATUAN', 'APT_OBAT.KD_SATUAN', '=', 'APT_SATUAN.KD_SATUAN')
            ->where(function ($query) use ($kunjunganIGD, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk) {
                $query->where(function ($q) use ($kunjunganIGD) {
                    $q->where('MR_RESEP.kd_pasien', $kunjunganIGD->kd_pasien ?? '')
                        ->whereDate('MR_RESEP.tgl_masuk', $kunjunganIGD->tgl_masuk ?? '')
                        ->where('MR_RESEP.urut_masuk', $kunjunganIGD->urut_masuk ?? '')
                        ->where('MR_RESEP.kd_unit', $kunjunganIGD->kd_unit ?? '');
                })
                    ->orWhere(function ($q) use ($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk) {
                        $q->where('MR_RESEP.kd_pasien', $kd_pasien)
                            ->whereDate('MR_RESEP.tgl_masuk', $tgl_masuk)
                            ->where('MR_RESEP.urut_masuk', $urut_masuk)
                            ->where('MR_RESEP.kd_unit', $kd_unit);
                    });
            })
            ->where(function ($query) {
                $query->where('MR_RESEP.RESEP_PULANG', '!=', 1)
                    ->orWhereNull('MR_RESEP.RESEP_PULANG');
            })
            ->select(
                'MR_RESEP.TGL_ORDER',
                'DOKTER.NAMA as NAMA_DOKTER',
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

    private function getObatPulang($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $kunjunganIGD = null)
    {
        return DB::table('MR_RESEP')
            ->join('DOKTER', 'MR_RESEP.KD_DOKTER', '=', 'DOKTER.KD_DOKTER')
            ->leftJoin('MR_RESEPDTL', 'MR_RESEP.ID_MRRESEP', '=', 'MR_RESEPDTL.ID_MRRESEP')
            ->leftJoin('APT_OBAT', 'MR_RESEPDTL.KD_PRD', '=', 'APT_OBAT.KD_PRD')
            ->leftJoin('APT_SATUAN', 'APT_OBAT.KD_SATUAN', '=', 'APT_SATUAN.KD_SATUAN')
            ->where(function ($query) use ($kunjunganIGD, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk) {
                $query->where(function ($q) use ($kunjunganIGD) {
                    $q->where('MR_RESEP.kd_pasien', $kunjunganIGD->kd_pasien ?? '')
                        ->whereDate('MR_RESEP.tgl_masuk', $kunjunganIGD->tgl_masuk ?? '')
                        ->where('MR_RESEP.urut_masuk', $kunjunganIGD->urut_masuk ?? '')
                        ->where('MR_RESEP.kd_unit', $kunjunganIGD->kd_unit ?? '');
                })
                    ->orWhere(function ($q) use ($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk) {
                        $q->where('MR_RESEP.kd_pasien', $kd_pasien)
                            ->whereDate('MR_RESEP.tgl_masuk', $tgl_masuk)
                            ->where('MR_RESEP.urut_masuk', $urut_masuk)
                            ->where('MR_RESEP.kd_unit', $kd_unit);
                    });
            })
            ->where('MR_RESEP.RESEP_PULANG', 1)
            ->select(
                'MR_RESEP.TGL_ORDER',
                'DOKTER.NAMA as NAMA_DOKTER',
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

    // hasil data raboratorium
    protected function getLabData($kd_order, $kd_pasien, $tgl_masuk, $kd_unit, $urut_masuk)
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
                'so.kd_unit' => $kd_unit,
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
}
