<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\InformedConsent;
use App\Models\Kunjungan;
use App\Models\RMEResume;
use App\Models\RmeResumeDtl;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class InformedConsentController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
    }

    public function index($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
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

        $informedConsent = InformedConsent::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', date('Y-m-d', strtotime($tgl_masuk)))
            ->where('urut_masuk', $urut_masuk)
            ->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.informed-consent.index', compact('dataMedis', 'informedConsent'));
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        DB::beginTransaction();

        try {
            $data = $request->except(['_token']);
            $data['kd_pasien'] = $kd_pasien;
            $data['kd_unit'] = $kd_unit;
            $data['tgl_masuk'] = $tgl_masuk;
            $data['urut_masuk'] = $urut_masuk;
            $data['id_user'] = Auth::id();


            $formatTglMasuk = date('Y-m-d', strtotime($tgl_masuk));

            // store ttd petugas
            if ($request->hasFile('ttd_pj')) {
                $path = $request->file('ttd_pj')->store("uploads/rawat-inap/informed-consent/$formatTglMasuk/$kd_pasien/$urut_masuk");

                $data['ttd_pj'] = $path;
            }

            // store ttd pj
            if ($request->hasFile('ttd_saksi_1')) {
                $path = $request->file('ttd_saksi_1')->store("uploads/rawat-inap/informed-consent/$formatTglMasuk/$kd_pasien/$urut_masuk");

                $data['ttd_saksi_1'] = $path;
            }

            // store ttd saksi
            if ($request->hasFile('ttd_saksi_2')) {
                $path = $request->file('ttd_saksi_2')->store("uploads/rawat-inap/informed-consent/$formatTglMasuk/$kd_pasien/$urut_masuk");

                $data['ttd_saksi_2'] = $path;
            }

            // store data
            InformedConsent::create($data);

            // RESUME
            $resumeData = [
                'anamnesis'             => '',
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
                        'hasil' => ''
                    ],
                    'nadi'   => [
                        'hasil' => ''
                    ],
                    'tinggi_badan'   => [
                        'hasil' => ''
                    ],
                    'berat_badan'   => [
                        'hasil' => ''
                    ]
                ]
            ];

            $this->createResume($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $resumeData);

            DB::commit();
            return back()->with('success', 'Informed Consent berhasil ditambah!');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Internal Server Error!');
        }
    }

    public function delete($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $idInformedConsent)
    {
        DB::beginTransaction();

        try {
            InformedConsent::where('id', $idInformedConsent)->delete();
            DB::commit();
            return back()->with('success', 'Informed Consent berhasil dihapus!');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        try {
            $informedConsent = InformedConsent::find($request->dataic);

            if (empty($informedConsent)) {
                return response()->json([
                    'status'    => 'error',
                    'message'   => 'Data tidak ditemukan !',
                    'data'      => []
                ]);
            }

            return response()->json([
                'status'    => 'success',
                'message'   => 'OK',
                'data'      => $informedConsent
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'    => 'error',
                'message'   => 'Internal Server Error !',
                'data'      => []
            ]);
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

     public function print($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        // Get Patient data
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

        if (!$dataMedis) {
            abort(404, 'Data pasien tidak ditemukan');
        }

        // Get Informed Consent data
        $informedConsent = InformedConsent::with('user')
            ->where('id', $id)
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('urut_masuk', $urut_masuk)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->first();

        if (!$informedConsent) {
            abort(404, 'Informed consent tidak ditemukan');
        }

        // Persiapkan data untuk PDF
        $data = [
            'dataMedis' => $dataMedis,
            'informedConsent' => $informedConsent,
        ];

        // Generate PDF dengan DomPDF
        $pdf = Pdf::loadView('unit-pelayanan.rawat-inap.pelayanan.informed-consent.print', $data);

        // Atur PDF properties
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'defaultFont' => 'sans-serif',
            'isFontSubsettingEnabled' => true,
            'isPhpEnabled' => true,
            'debugCss' => false,
        ]);

        // Nama file PDF
        $filename = 'Informed_Consent_' . str_replace(' ', '_', $dataMedis->pasien->nama ?? 'Pasien') . '_' . date('Y-m-d') . '.pdf';

        // Download file PDF
        return $pdf->stream($filename);
    }
}