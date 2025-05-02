<?php

namespace App\Http\Controllers\UnitPelayanan\GawatDarurat;

use App\Http\Controllers\Controller;
use App\Models\Cppt;
use App\Models\CpptPenyakit;
use App\Models\CpptTindakLanjut;
use App\Models\DetailComponent;
use App\Models\DetailPrsh;
use App\Models\DetailTransaksi;
use App\Models\DokterKlinik;
use App\Models\Konsultasi;
use App\Models\Kunjungan;
use App\Models\MrAnamnesis;
use App\Models\MrKondisiFisik;
use App\Models\MrKonpas;
use App\Models\MrKonpasDtl;
use App\Models\MrPenyakit;
use App\Models\Penyakit;
use App\Models\RmeFaktorPemberat;
use App\Models\RmeFaktorPeringan;
use App\Models\RmeFrekuensiNyeri;
use App\Models\RmeJenisNyeri;
use App\Models\RmeKualitasNyeri;
use App\Models\RmeMenjalar;
use App\Models\RMEResume;
use App\Models\RmeResumeDtl;
use App\Models\RujukanKunjungan;
use App\Models\SjpKunjungan;
use App\Models\Transaksi;
use App\Models\Unit;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CpptController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/gawat-darurat');
    }

    public function index($kd_pasien, $tgl_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_unit', 3)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();

        $tandaVital = MrKondisiFisik::OrderBy('urut')->get();
        $faktorPemberat = RmeFaktorPemberat::all();
        $faktorPeringan = RmeFaktorPeringan::all();
        $kualitasNyeri = RmeKualitasNyeri::all();
        $frekuensiNyeri = RmeFrekuensiNyeri::all();
        $menjalar = RmeMenjalar::all();
        $jenisNyeri = RmeJenisNyeri::all();
        $dokterPengirim = DokterKlinik::with(['dokter', 'unit'])
            ->where('kd_unit', 3)
            ->whereRelation('dokter', 'status', 1)
            ->get();

        $unitKonsul = Unit::where('kd_bagian', 2)
            ->where('aktif', 1)
            ->get();

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        // get cppt
        $getCppt = Cppt::with(['dtCppt', 'pemberat', 'peringan', 'kualitas', 'frekuensi', 'menjalar', 'jenis'])
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
                'cp.nama_penyakit'
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
                    ->on('a.tgl_masuk', '=', 'cppt.tanggal')
                    ->on('a.urut_masuk', '=', 'cppt.urut');
            })
            // tindak lanjut
            ->leftJoin('cppt_tindak_lanjut as ctl', function ($j) {
                $j->on('ctl.no_transaksi', '=', 'cppt.no_transaksi')
                    ->on('ctl.kd_kasir', '=', 'cppt.kd_kasir')
                    ->on('ctl.tanggal', '=', 'cppt.tanggal')
                    ->on('ctl.urut', '=', 'cppt.urut');
            })
            // tanda vital
            ->leftJoin('mr_konpas as kp', function ($j) {
                $j->on('kp.kd_pasien', '=', 't.kd_pasien')
                    ->on('kp.kd_unit', '=', 't.kd_unit')
                    ->on('kp.tgl_masuk', '=', 'cppt.tanggal')
                    ->on('kp.urut_masuk', '=', 'cppt.urut');
            })
            ->leftJoin('mr_konpasdtl as kpd', 'kpd.id_konpas', '=', 'kp.id_konpas')
            ->leftJoin('mr_kondisifisik as kf', 'kf.id_kondisi', '=', 'kpd.id_kondisi')
            // diagnosa
            // ->leftJoin('mr_penyakit as mrp', function($j) {
            //     $j->on('mrp.kd_pasien', '=', 't.kd_pasien')
            //         ->on('mrp.kd_unit', '=', 't.kd_unit')
            //         ->on('mrp.tgl_cppt', '=', 'cppt.tanggal')
            //         ->on('mrp.urut_cppt', '=', 'cppt.urut');
            // })
            ->leftJoin('cppt_penyakit as cp', function ($j) {
                $j->on('cp.kd_unit', '=', 't.kd_unit')
                    ->on('cp.no_transaksi', '=', 'cppt.no_transaksi')
                    ->on('cp.tgl_cppt', '=', 'cppt.tanggal')
                    ->on('cp.urut_cppt', '=', 'cppt.urut_total');
            })
            ->leftJoin('penyakit as p', 'p.kd_penyakit', '=', 'cp.kd_penyakit')
            ->where('t.kd_pasien', $dataMedis->kd_pasien)
            ->where('t.kd_unit', $dataMedis->kd_unit)
            ->where('cppt.no_transaksi', $dataMedis->no_transaksi)
            ->where('cppt.kd_kasir', $dataMedis->kd_kasir)
            ->orderBy('cppt.tanggal', 'desc')
            ->orderBy('cppt.jam', 'desc')
            ->orderBy('kf.urut')
            ->get();


        // $cppt = $getCppt->groupBy(['tanggal', 'urut'])->map(function($item) {
        //     return [
        //         'kd_pasien'             => $item->first()->first()->kd_pasien,
        //         'no_transaksi'          => $item->first()->first()->no_transaksi,
        //         'kd_kasir'              => $item->first()->first()->kd_kasir,
        //         'kd_unit'               => $item->first()->first()->kd_unit,
        //         'nama_unit'             => $item->first()->first()->nama_unit,
        //         'penanggung'            => $item->first()->first()->dtCppt,
        //         'nama_penanggung'       => $item->first()->first()->nama_penanggung,
        //         'tanggal'               => $item->first()->first()->tanggal,
        //         'jam'                   => $item->first()->first()->jam,
        //         'obyektif'              => $item->first()->first()->obyektif,
        //         'planning'              => $item->first()->first()->planning,
        //         'urut'                  => $item->first()->first()->urut,
        //         'skala_nyeri'           => $item->first()->first()->skala_nyeri,
        //         'lokasi'                => $item->first()->first()->lokasi,
        //         'durasi'                => $item->first()->first()->durasi,
        //         'pemberat'              => $item->first()->first()->pemberat,
        //         'peringan'              => $item->first()->first()->peringan,
        //         'kualitas'              => $item->first()->first()->kualitas,
        //         'frekuensi'             => $item->first()->first()->frekuensi,
        //         'menjalar'              => $item->first()->first()->menjalar,
        //         'jenis'                 => $item->first()->first()->jenis,
        //         'pemeriksaan_fisik'     => $item->first()->first()->pemeriksaan_fisik,
        //         'user_penanggung'       => $item->first()->first()->user_penanggung,
        //         'anamnesis'             => $item->first()->first()->anamnesis,
        //         'tindak_lanjut_code'    => $item->first()->first()->tindak_lanjut_code,
        //         'tindak_lanjut_name'    => $item->first()->first()->tindak_lanjut_name,
        //         'tgl_kontrol_ulang'     => $item->first()->first()->tgl_kontrol_ulang,
        //         'unit_rujuk_internal'   => $item->first()->first()->unit_rujuk_internal,
        //         'unit_rawat_inap'       => $item->first()->first()->unit_rawat_inap,
        //         'rs_rujuk'              => $item->first()->first()->rs_rujuk,
        //         'rs_rujuk_bagian'       => $item->first()->first()->rs_rujuk_bagian,
        //         'kondisi'               => [
        //             "id_konpas"     => (int) $item->first()->first()->id_konpas,
        //             'konpas'        => $item->first()->groupBy('id_kondisi')->map(function($konpas) {
        //                 return [
        //                     "id_kondisi"    => $konpas->first()->id_kondisi,
        //                     "nama_kondisi"  => $konpas->first()->kondisi,
        //                     "satuan"        => $konpas->first()->satuan,
        //                     "hasil"         => $konpas->first()->hasil,
        //                 ];
        //             })
        //         ],
        //         'penyakit'              => $item->first()->groupBy('kd_penyakit')->map(function($penyakit) {
        //             return [
        //                 'kd_penyakit'   => $penyakit->first()->kd_penyakit,
        //                 'nama_penyakit' => $penyakit->first()->penyakit,
        //             ];
        //         })
        //     ];
        // });

        $cppt = $getCppt->groupBy(['urut_total'])->map(function ($item) {

            return [
                'kd_pasien'             => $item->first()->kd_pasien,
                'no_transaksi'          => $item->first()->no_transaksi,
                'kd_kasir'              => $item->first()->kd_kasir,
                'kd_unit'               => $item->first()->kd_unit,
                'nama_unit'             => $item->first()->nama_unit,
                'penanggung'            => $item->first()->dtCppt,
                'nama_penanggung'       => $item->first()->nama_penanggung,
                'tanggal'               => $item->first()->tanggal,
                'jam'                   => $item->first()->jam,
                'obyektif'              => $item->first()->obyektif,
                'planning'              => $item->first()->planning,
                'urut'                  => $item->first()->urut,
                'skala_nyeri'           => $item->first()->skala_nyeri,
                'lokasi'                => $item->first()->lokasi,
                'durasi'                => $item->first()->durasi,
                'pemberat'              => $item->first()->pemberat,
                'peringan'              => $item->first()->peringan,
                'kualitas'              => $item->first()->kualitas,
                'frekuensi'             => $item->first()->frekuensi,
                'menjalar'              => $item->first()->menjalar,
                'jenis'                 => $item->first()->jenis,
                'pemeriksaan_fisik'     => $item->first()->pemeriksaan_fisik,
                'urut_total'            => $item->first()->urut_total,
                'user_penanggung'       => $item->first()->user_penanggung,
                'anamnesis'             => $item->first()->anamnesis,
                'tindak_lanjut_code'    => $item->first()->tindak_lanjut_code,
                'tindak_lanjut_name'    => $item->first()->tindak_lanjut_name,
                'tgl_kontrol_ulang'     => $item->first()->tgl_kontrol_ulang,
                'unit_rujuk_internal'   => $item->first()->unit_rujuk_internal,
                'unit_rawat_inap'       => $item->first()->unit_rawat_inap,
                'rs_rujuk'              => $item->first()->rs_rujuk,
                'rs_rujuk_bagian'       => $item->first()->rs_rujuk_bagian,
                'verified'              => $item->first()->verified,
                'user_verified'         => $item->first()->user_verified,
                'kondisi'               => [
                    "id_konpas"     => (int) $item->first()->id_konpas,
                    'konpas'        => $item->groupBy('id_kondisi')->map(function ($konpas) {
                        return [
                            "id_kondisi"    => $konpas->first()->id_kondisi,
                            "nama_kondisi"  => $konpas->first()->kondisi,
                            "satuan"        => $konpas->first()->satuan,
                            "hasil"         => $konpas->first()->hasil,
                        ];
                    })
                ],
                'cppt_penyakit'              => $item->groupBy('nama_penyakit')->map(function ($penyakit) {
                    return [
                        'nama_penyakit' => $penyakit->first()->nama_penyakit,
                    ];
                }),
                'penyakit'              => $item->groupBy('kd_penyakit')->map(function ($penyakit) {
                    return [
                        'kd_penyakit'   => $penyakit->first()->kd_penyakit,
                        'nama_penyakit' => $penyakit->first()->penyakit,
                    ];
                })
            ];
        });

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.cppt.index', [
            'dataMedis'         => $dataMedis,
            'tandaVital'        => $tandaVital,
            'faktorPemberat'    => $faktorPemberat,
            'faktorPeringan'    => $faktorPeringan,
            'kualitasNyeri'     => $kualitasNyeri,
            'frekuensiNyeri'    => $frekuensiNyeri,
            'menjalar'          => $menjalar,
            'jenisNyeri'        => $jenisNyeri,
            'cppt'              => $cppt,
            'dokterPengirim'    => $dokterPengirim,
            'unitKonsul'        => $unitKonsul
        ]);
    }

    public function getIcdTenAjax(Request $request)
    {
        try {
            $search = $request->data;
            $query = Penyakit::select(['kd_penyakit', 'penyakit']);

            if (!empty($search)) {
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
                'status'    => 'success',
                'data'      => [
                    'count'     => count($dataDiagnosa),
                    'diagnosa'  => $dataDiagnosa
                ]
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status'    => 'error',
                'message'   => $e->getMessage(),
                'data'      => [
                    'count' => 0
                ]
            ], 400);
        }
    }

    public function getCpptAjax(Request $request)
    {
        try {

            // get cppt
            $getCppt = Cppt::with(['dtCppt', 'pemberat', 'peringan', 'kualitas', 'frekuensi', 'menjalar', 'jenis'])
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
                    'unt.nama_unit as nama_unit_tujuan_konsul'
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
                        ->on('a.tgl_masuk', '=', 'cppt.tanggal')
                        ->on('a.urut_masuk', '=', 'cppt.urut');
                })
                // tindak lanjut
                ->leftJoin('cppt_tindak_lanjut as ctl', function ($j) {
                    $j->on('ctl.no_transaksi', '=', 'cppt.no_transaksi')
                        ->on('ctl.kd_kasir', '=', 'cppt.kd_kasir')
                        ->on('ctl.tanggal', '=', 'cppt.tanggal')
                        ->on('ctl.urut', '=', 'cppt.urut');
                })
                // tanda vital
                ->leftJoin('mr_konpas as kp', function ($j) {
                    $j->on('kp.kd_pasien', '=', 't.kd_pasien')
                        ->on('kp.kd_unit', '=', 't.kd_unit')
                        ->on('kp.tgl_masuk', '=', 'cppt.tanggal')
                        ->on('kp.urut_masuk', '=', 'cppt.urut');
                })
                ->leftJoin('mr_konpasdtl as kpd', 'kpd.id_konpas', '=', 'kp.id_konpas')
                ->leftJoin('mr_kondisifisik as kf', 'kf.id_kondisi', '=', 'kpd.id_kondisi')
                // diagnosa
                ->leftJoin('cppt_penyakit as cp', function ($j) {
                    $j->on('cp.kd_unit', '=', 't.kd_unit')
                        ->on('cp.no_transaksi', '=', 'cppt.no_transaksi')
                        ->on('cp.tgl_cppt', '=', 'cppt.tanggal')
                        ->on('cp.urut_cppt', '=', 'cppt.urut_total');
                })
                ->leftJoin('penyakit as p', 'p.kd_penyakit', '=', 'cp.kd_penyakit')
                ->leftJoin('unit as unt', 'ctl.unit_rujuk_internal', '=', 'unt.kd_unit')
                ->where('t.kd_pasien', $request->kd_pasien)
                ->where('t.kd_unit', $request->kd_unit)
                ->where('t.no_transaksi', $request->no_transaksi)
                ->where('cppt.tanggal', $request->tanggal)
                ->where('cppt.urut', $request->urut)
                ->orderBy('cppt.tanggal', 'desc')
                ->orderBy('cppt.jam', 'desc')
                ->orderBy('kf.urut')
                ->get();

            $cppt = $getCppt->groupBy(['urut_total'])->map(function ($item) {
                return [
                    'kd_pasien'                 => $item->first()->kd_pasien,
                    'no_transaksi'              => $item->first()->no_transaksi,
                    'kd_kasir'                  => $item->first()->kd_kasir,
                    'kd_unit'                   => $item->first()->kd_unit,
                    'nama_unit'                 => $item->first()->nama_unit,
                    'penanggung'                => $item->first()->dtCppt,
                    'nama_penanggung'           => $item->first()->nama_penanggung,
                    'tanggal'                   => $item->first()->tanggal,
                    'jam'                       => $item->first()->jam,
                    'obyektif'                  => $item->first()->obyektif,
                    'planning'                  => $item->first()->planning,
                    'urut'                      => $item->first()->urut,
                    'skala_nyeri'               => $item->first()->skala_nyeri,
                    'lokasi'                    => $item->first()->lokasi,
                    'durasi'                    => $item->first()->durasi,
                    'pemberat'                  => $item->first()->pemberat,
                    'peringan'                  => $item->first()->peringan,
                    'kualitas'                  => $item->first()->kualitas,
                    'frekuensi'                 => $item->first()->frekuensi,
                    'menjalar'                  => $item->first()->menjalar,
                    'jenis'                     => $item->first()->jenis,
                    'pemeriksaan_fisik'         => $item->first()->pemeriksaan_fisik,
                    'urut_total'                => $item->first()->urut_total,
                    'user_penanggung'           => $item->first()->user_penanggung,
                    'anamnesis'                 => $item->first()->anamnesis,
                    'tindak_lanjut_code'        => $item->first()->tindak_lanjut_code,
                    'tindak_lanjut_name'        => $item->first()->tindak_lanjut_name,
                    'tgl_kontrol_ulang'         => $item->first()->tgl_kontrol_ulang,
                    'unit_rujuk_internal'       => $item->first()->unit_rujuk_internal,
                    'nama_unit_tujuan_konsul'   => $item->first()->nama_unit_tujuan_konsul,
                    'unit_rawat_inap'           => $item->first()->unit_rawat_inap,
                    'rs_rujuk'                  => $item->first()->rs_rujuk,
                    'rs_rujuk_bagian'           => $item->first()->rs_rujuk_bagian,
                    'verified'                  => $item->first()->verified,
                    'user_verified'             => $item->first()->user_verified,
                    'kondisi'                   => [
                        "id_konpas"     => (int) $item->first()->id_konpas,
                        'konpas'        => $item->groupBy('id_kondisi')->map(function ($konpas) {
                            return [
                                "id_kondisi"    => $konpas->first()->id_kondisi,
                                "nama_kondisi"  => $konpas->first()->kondisi,
                                "satuan"        => $konpas->first()->satuan,
                                "hasil"         => $konpas->first()->hasil,
                            ];
                        })
                    ],
                    'cppt_penyakit'              => $item->groupBy('nama_penyakit')->map(function ($penyakit) {
                        return [
                            'nama_penyakit' => $penyakit->first()->nama_penyakit,
                        ];
                    }),
                    'penyakit'              => $item->groupBy('kd_penyakit')->map(function ($penyakit) {
                        return [
                            'kd_penyakit'   => $penyakit->first()->kd_penyakit,
                            'nama_penyakit' => $penyakit->first()->penyakit,
                        ];
                    })
                ];
            });


            if (count($cppt) < 1) {
                return response()->json([
                    'status'    => 'error',
                    'message'   => 'Data tidak ditemukan!',
                    'data'      => []
                ], 200);
            } else {
                return response()->json([
                    'status'    => 'success',
                    'message'   => 'Data ditemukan!',
                    'data'      => $cppt
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'status'    => 'error',
                'message'   => 'Internal server error',
                'data'      => []
            ], 500);
        }
    }

    public function store($kd_pasien, $tgl_masuk, Request $request)
    {
        DB::beginTransaction();

        try {
            // Validation Input
            $validatorMessage = [
                'anamnesis.required'            => 'Anamnesis harus di isi!',
                // 'skala_nyeri.required'          => 'Skala nyeri harus di isi!',
                'skala_nyeri.min'               => 'Nilai skala nyeri minimal 0!',
                'skala_nyeri.max'               => 'Nilai skala nyeri minimal 10!',
                // 'lokasi.required'               => 'Lokasi harus di isi!',
                // 'durasi.required'               => 'Durasi harus di isi!',
                // 'pemberat.required'             => 'Pemberat harus di isi!',
                // 'peringan.required'             => 'Peringan harus di isi!',
                // 'kualitas_nyeri.required'       => 'Kualitas nyeri harus di isi!',
                // 'frekuensi_nyeri.required'      => 'Frekuensi nyeri harus di isi!',
                // 'menjalar.required'             => 'Menjalar harus di isi!',
                // 'jenis_nyeri.required'          => 'Jenis nyeri harus di isi!',
                // 'pemeriksaan_fisik.required'    => 'Pemeriksaan fisik harus di isi!',
                // 'data_objektif.required'        => 'Data objektif harus di isi!',
                // 'planning.required'             => 'Planning harus di isi!',
                'tindak_lanjut'                 => 'Tindak lanjut harus di isi!'
            ];

            // $validator = Validator::make($request->all(), [
            //     'anamnesis'         => 'required',
            //     'skala_nyeri'       => 'required|min:0|max:10',
            //     'lokasi'            => 'required',
            //     'durasi'            => 'required',
            //     'pemberat'          => 'required',
            //     'peringan'          => 'required',
            //     'kualitas_nyeri'    => 'required',
            //     'frekuensi_nyeri'   => 'required',
            //     'menjalar'          => 'required',
            //     'jenis_nyeri'       => 'required',
            //     'pemeriksaan_fisik' => 'required',
            //     'data_objektif'     => 'required',
            //     'planning'          => 'required',
            //     'tindak_lanjut'     => 'required'
            // ], $validatorMessage);


            $validatedData = $request->validate([
                'anamnesis'         => 'required',
                'skala_nyeri'       => 'min:0|max:10',
                // 'lokasi'            => 'required',
                // 'durasi'            => 'required',
                // 'pemberat'          => 'required',
                // 'peringan'          => 'required',
                // 'kualitas_nyeri'    => 'required',
                // 'frekuensi_nyeri'   => 'required',
                // 'menjalar'          => 'required',
                // 'jenis_nyeri'       => 'required',
                // 'pemeriksaan_fisik' => 'required',
                // 'data_objektif'     => 'required',
                // 'planning'          => 'required',
                'tindak_lanjut'     => 'required'
            ], $validatorMessage);

            if (empty($request->diagnose_name)) return back()->with('error', 'Diagnosis harus di tambah minimal 1!');

            // get kunjungan
            $kunjungan = Kunjungan::join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
                ->where('kunjungan.kd_unit', 3)
                ->where('kunjungan.kd_pasien', $kd_pasien)
                ->where('kunjungan.urut_masuk', $request->urut_masuk)
                ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
                ->first();


            $tanggal = date('Y-m-d');
            $jam = date('H:i:s');

            // store anamnesis
            $lastUrutMasukAnamnesis = MrAnamnesis::where('kd_pasien', $kunjungan->kd_pasien)
                ->where('kd_unit', $kunjungan->kd_unit)
                ->whereDate('tgl_masuk', $tanggal)
                ->count();
            $lastUrutMasukAnamnesis += 1;

            $anamnesisInsertData = [
                'kd_pasien'     => $kunjungan->kd_pasien,
                'kd_unit'       => $kunjungan->kd_unit,
                'tgl_masuk'     => $tanggal,
                'urut_masuk'    => $lastUrutMasukAnamnesis,
                'urut'          => 0,
                'anamnesis'     => $request->anamnesis,
                'dd'            => ''
            ];

            MrAnamnesis::create($anamnesisInsertData);


            // insert data to mr_konpas
            $konpasMax = MrKonpas::select(['id_konpas'])
                ->whereDate('tgl_masuk', $tanggal)
                // ->where('kd_unit', 3)
                ->orderBy('id_konpas', 'desc')
                ->max('id_konpas');

            $newIdKonpas = (empty($konpasMax)) ? date('Ymd', strtotime($tanggal)) . '0001' : (int) $konpasMax + 1;

            $lastUrutMasukKonpas = MrKonpas::where('kd_pasien', $kunjungan->kd_pasien)
                ->where('kd_unit', $kunjungan->kd_unit)
                ->whereDate('tgl_masuk', $tanggal)
                ->count();
            $lastUrutMasukKonpas += 1;

            $konpasInsertData = [
                'id_konpas'     => $newIdKonpas,
                'kd_pasien'     => $kunjungan->kd_pasien,
                'kd_unit'       => $kunjungan->kd_unit,
                'tgl_masuk'     => $tanggal,
                'urut_masuk'    => $lastUrutMasukKonpas,
                'catatan'       => ''
            ];

            MrKonpas::create($konpasInsertData);

            // store tanda vital
            $tandaVitalReq = $request->tanda_vital;
            $tandaVitalList = MrKondisiFisik::OrderBy('urut')->get();

            $i = 0;
            foreach ($tandaVitalList as $item) {
                $konpasDtlInsertData = [
                    'id_konpas'     => $newIdKonpas,
                    'id_kondisi'    => $item->id_kondisi,
                    'hasil'         => $tandaVitalReq[$i]
                ];

                MrKonpasDtl::create($konpasDtlInsertData);
                $i++;
            }


            // store CPPT
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

            $cpptInsertData = [
                'kd_kasir'              => $kunjungan->kd_kasir,
                'no_transaksi'          => $kunjungan->no_transaksi,
                'penanggung'            => 0,
                'nama_penanggung'       => Auth::user()->name,
                'tanggal'               => $tanggal,
                'jam'                   => $jam,
                'obyektif'              => $request->data_objektif,
                'assesment'             => '',
                'planning'              => $request->planning,
                'urut'                  => $lastUrutCPPT,
                'skala_nyeri'           => $request->skala_nyeri,
                'lokasi'                => $request->lokasi,
                'durasi'                => $request->durasi,
                'faktor_pemberat_id'    => $request->pemberat,
                'faktor_peringan_id'    => $request->peringan,
                'kualitas_nyeri_id'     => $request->kualitas_nyeri,
                'frekuensi_nyeri_id'    => $request->frekuensi_nyeri,
                'menjalar_id'           => $request->menjalar,
                'jenis_nyeri_id'        => $request->jenis_nyeri,
                'pemeriksaan_fisik'     => $request->pemeriksaan_fisik,
                'user_penanggung'       => Auth::user()->id,
                'verified'              => 0,
                'user_verified'         => null,
                'urut_total'            => $lastUrutTotalCppt
            ];

            Cppt::create($cpptInsertData);


            // store CPPT Tindak Lanjut
            $tindakLanjut = $request->tindak_lanjut;
            $tindakLanjutLabel = '';

            switch ($tindakLanjut) {
                case '1':
                    $tindakLanjutLabel = 'Rawat Inap';
                    break;
                case '2':
                    $tindakLanjutLabel = 'Kontrol ulang';
                    break;
                case '3':
                    $tindakLanjutLabel = 'Selesai di klinik ini';
                    break;
                case '4':
                    $tindakLanjutLabel = 'Konsul/Rujuk internal';
                    break;
                case '5':
                    $tindakLanjutLabel = 'Rujuk RS lain';
                    break;
                default:
                    $tindakLanjutLabel = '';
                    break;
            }

            $cpptTindakLanjutInsertData = [
                'kd_kasir'              => $kunjungan->kd_kasir,
                'no_transaksi'          => $kunjungan->no_transaksi,
                'tanggal'               => $tanggal,
                'jam'                   => $jam,
                'tindak_lanjut_code'    => $tindakLanjut,
                'tindak_lanjut_name'    => $tindakLanjutLabel,
                'tgl_kontrol_ulang'     => '',
                'unit_rujuk_internal'   => '',
                'unit_rawat_inap'       => '',
                'rs_rujuk'              => '',
                'rs_rujuk_bagian'       => '',
                'urut'                  => $lastUrutCPPT
            ];


            // TINDAK LANJURT
            // kontrol ulang (2)
            if ($tindakLanjut == '2') {
                $cpptTindakLanjutInsertData['tgl_kontrol_ulang'] = $request->tgl_kontrol;
            }

            // kontrol ulang (5)
            if ($tindakLanjut == '5') {
                $cpptTindakLanjutInsertData['rs_rujuk'] = $request->nama_rs;
                $cpptTindakLanjutInsertData['rs_rujuk_bagian'] = $request->bagian_rs;
            }

            // konsul (4)
            if ($tindakLanjut == '4') {
                $dataKonsul = [
                    'tgl_konsul'            => $request->tgl_konsul,
                    'jam_konsul'            => $request->jam_konsul,
                    'dokter_pengirim'       => $request->dokter_pengirim,
                    'unit_tujuan'           => $request->unit_tujuan,
                    'dokter_unit_tujuan'    => $request->dokter_unit_tujuan,
                    'konsulen_harap'        => $request->konsulen_harap,
                    'catatan'               => $request->catatan,
                    'konsul'                => $request->konsul,
                ];

                $cpptTindakLanjutInsertData['unit_rujuk_internal'] = $request->unit_tujuan;
                $this->storeKonsultasi($kd_pasien, $tgl_masuk, $request->urut_masuk, $dataKonsul);
            }

            CpptTindakLanjut::create($cpptTindakLanjutInsertData);

            // store diagnosis
            $diagnosisReq = $request->diagnose_name;

            foreach ($diagnosisReq as $diag) {

                $diagInsertData = [
                    'no_transaksi'     => $kunjungan->no_transaksi,
                    'kd_unit'          => $kunjungan->kd_unit,
                    'tgl_cppt'         => $tanggal,
                    'urut_cppt'        => $lastUrutTotalCppt,
                    'kd_penyakit'      => null,
                    'nama_penyakit'    => $diag
                ];

                CpptPenyakit::create($diagInsertData);
            }


            // create resume
            $resumeData = [
                'anamnesis'             => $request->anamnesis,
                'diagnosis'             => $diagnosisReq,
                'tindak_lanjut_code'    => $tindakLanjut,
                'tindak_lanjut_name'    => $tindakLanjutLabel,
                'tgl_kontrol_ulang'     => $request->tgl_kontrol,
                'unit_rujuk_internal'   => $request->unit_tujuan,
                'rs_rujuk'              => $request->nama_rs,
                'rs_rujuk_bagian'       => $request->bagian_rs,
                'konpas'                => [
                    'sistole'   => [
                        'hasil' => $tandaVitalReq[1]
                    ],
                    'distole'   => [
                        'hasil' => $tandaVitalReq[2]
                    ],
                    'respiration_rate'   => [
                        'hasil' => $tandaVitalReq[5]
                    ],
                    'suhu'   => [
                        'hasil' => $tandaVitalReq[8]
                    ],
                    'nadi'   => [
                        'hasil' => $tandaVitalReq[0]
                    ],
                    'tinggi_badan'   => [
                        'hasil' => $tandaVitalReq[3]
                    ],
                    'berat_badan'   => [
                        'hasil' => $tandaVitalReq[4]
                    ]
                ]
            ];

            $this->createResume($kd_pasien, $tgl_masuk, $request->urut_masuk, $resumeData);

            DB::commit();
            return back()->with('success', 'CPPT berhasil ditambah!');
        } catch (Exception $e) {
            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }

    public function update($kd_pasien, $tgl_masuk, Request $request)
    {
        DB::beginTransaction();

        try {

            // Validation Input
            $validatorMessage = [
                'anamnesis.required'            => 'Anamnesis harus di isi!',
                // 'skala_nyeri.required'          => 'Skala nyeri harus di isi!',
                'skala_nyeri.min'               => 'Nilai skala nyeri minimal 0!',
                'skala_nyeri.max'               => 'Nilai skala nyeri minimal 10!',
                // 'lokasi.required'               => 'Lokasi harus di isi!',
                // 'durasi.required'               => 'Durasi harus di isi!',
                // 'pemberat.required'             => 'Pemberat harus di isi!',
                // 'peringan.required'             => 'Peringan harus di isi!',
                // 'kualitas_nyeri.required'       => 'Kualitas nyeri harus di isi!',
                // 'frekuensi_nyeri.required'      => 'Frekuensi nyeri harus di isi!',
                // 'menjalar.required'             => 'Menjalar harus di isi!',
                // 'jenis_nyeri.required'          => 'Jenis nyeri harus di isi!',
                // 'pemeriksaan_fisik.required'    => 'Pemeriksaan fisik harus di isi!',
                // 'data_objektif.required'        => 'Data objektif harus di isi!',
                // 'planning.required'             => 'Planning harus di isi!',
                'tindak_lanjut'                 => 'Tindak lanjut harus di isi!'
            ];

            // $validator = Validator::make($request->all(), [
            //     'anamnesis'         => 'required',
            //     'skala_nyeri'       => 'required|min:0|max:10',
            //     'lokasi'            => 'required',
            //     'durasi'            => 'required',
            //     'pemberat'          => 'required',
            //     'peringan'          => 'required',
            //     'kualitas_nyeri'    => 'required',
            //     'frekuensi_nyeri'   => 'required',
            //     'menjalar'          => 'required',
            //     'jenis_nyeri'       => 'required',
            //     'pemeriksaan_fisik' => 'required',
            //     'data_objektif'     => 'required',
            //     'planning'          => 'required',
            //     'tindak_lanjut'     => 'required'
            // ], $validatorMessage);


            $validatedData = $request->validate([
                'anamnesis'         => 'required',
                'skala_nyeri'       => 'min:0|max:10',
                // 'lokasi'            => 'required',
                // 'durasi'            => 'required',
                // 'pemberat'          => 'required',
                // 'peringan'          => 'required',
                // 'kualitas_nyeri'    => 'required',
                // 'frekuensi_nyeri'   => 'required',
                // 'menjalar'          => 'required',
                // 'jenis_nyeri'       => 'required',
                // 'pemeriksaan_fisik' => 'required',
                // 'data_objektif'     => 'required',
                // 'planning'          => 'required',
                'tindak_lanjut'     => 'required'
            ], $validatorMessage);

            if (empty($request->diagnose_name)) return back()->with('error', 'Diagnosis harus di tambah minimal 1!');

            // get kunjungan
            $kunjungan = Kunjungan::join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
                ->where('kunjungan.kd_unit', 3)
                ->where('kunjungan.kd_pasien', $kd_pasien)
                ->where('kunjungan.urut_masuk', $request->urut_masuk)
                ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
                ->first();


            $tglCpptReq = $request->tgl_cppt;
            $urutCpptReq = $request->urut_cppt;
            $unitCpptReq = $request->unit_cppt;
            $noTransaksiCpptReq = $request->no_transaksi;

            // update anamnesis
            MrAnamnesis::where('kd_pasien', $kunjungan->kd_pasien)
                ->where('kd_unit', $unitCpptReq)
                ->where('tgl_masuk', $tglCpptReq)
                ->where('urut_masuk', $urutCpptReq)
                ->update([
                    'anamnesis' => $request->anamnesis
                ]);


            // update konpas
            $konpas = MrKonpas::where('kd_pasien', $kunjungan->kd_pasien)
                ->where('kd_unit', $unitCpptReq)
                ->where('tgl_masuk', $tglCpptReq)
                ->where('urut_masuk', $urutCpptReq)
                ->first();


            // update tanda vital
            $tandaVitalReq = $request->tanda_vital;
            $tandaVitalList = MrKondisiFisik::OrderBy('urut')->get();

            $i = 0;
            foreach ($tandaVitalList as $item) {
                MrKonpasDtl::where('id_konpas', $konpas->id_konpas)
                    ->where('id_kondisi', $item->id_kondisi)
                    ->update([
                        'hasil' => $tandaVitalReq[$i]
                    ]);

                $i++;
            }


            // update CPPT
            $cppt = Cppt::where('no_transaksi', $kunjungan->no_transaksi)
                ->where('kd_kasir', $kunjungan->kd_kasir)
                ->where('tanggal', $tglCpptReq)
                ->where('urut', $urutCpptReq)
                ->first();

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
            ];

            Cppt::where('no_transaksi', $kunjungan->no_transaksi)
                ->where('kd_kasir', $kunjungan->kd_kasir)
                ->where('tanggal', $tglCpptReq)
                ->where('urut', $urutCpptReq)
                ->update($cpptDataUpdate);


            // update CPPT Tindak Lanjut
            $tindakLanjut = $request->tindak_lanjut;
            $tindakLanjutLabel = '';

            switch ($tindakLanjut) {
                case '1':
                    $tindakLanjutLabel = 'Rawat Inap';
                    break;
                case '2':
                    $tindakLanjutLabel = 'Kontrol ulang';
                    break;
                case '3':
                    $tindakLanjutLabel = 'Selesai di klinik ini';
                    break;
                case '4':
                    $tindakLanjutLabel = 'Konsul/Rujuk internal';
                    break;
                case '5':
                    $tindakLanjutLabel = 'Rujuk RS lain';
                    break;
                default:
                    $tindakLanjutLabel = '';
                    break;
            }

            $cpptTL = [
                'tindak_lanjut_code' => $tindakLanjut,
                'tindak_lanjut_name' => $tindakLanjutLabel,
            ];

            // TINDAK LANJUT
            // kontrol ulang (2)
            if ($tindakLanjut == '2') {
                $cpptTL['tgl_kontrol_ulang'] = $request->tgl_kontrol;
            }

            // kontrol ulang (5)
            if ($tindakLanjut == '5') {
                $cpptTL['rs_rujuk'] = $request->nama_rs;
                $cpptTL['rs_rujuk_bagian'] = $request->bagian_rs;
            }

            CpptTindakLanjut::where('kd_kasir', $cppt->kd_kasir)
                ->where('no_transaksi', $cppt->no_transaksi)
                ->where('tanggal', $cppt->tanggal)
                ->where('jam', $cppt->jam)
                ->update($cpptTL);


            // update diagnosis
            $diagnosisList = $request->diagnose_name;

            // delete old diagnose
            CpptPenyakit::where('no_transaksi', $noTransaksiCpptReq)
                ->where('kd_unit', $unitCpptReq)
                ->where('tgl_cppt', $tglCpptReq)
                ->where('urut_cppt', $urutCpptReq)
                ->delete();

            foreach ($diagnosisList as $diag) {

                $diagInsertData = [
                    'no_transaksi'     => $kunjungan->no_transaksi,
                    'kd_unit'          => $kunjungan->kd_unit,
                    'tgl_cppt'         => $cppt->tanggal,
                    'urut_cppt'        => $cppt->urut_total,
                    'kd_penyakit'      => null,
                    'nama_penyakit'    => $diag
                ];

                CpptPenyakit::create($diagInsertData);
            }


            // create resume
            $resumeData = [
                'anamnesis'             => $request->anamnesis,
                'diagnosis'             => $diagnosisList,
                'tindak_lanjut_code'    => $tindakLanjut,
                'tindak_lanjut_name'    => $tindakLanjutLabel,
                'tgl_kontrol_ulang'     => $request->tgl_kontrol,
                'unit_rujuk_internal'   => $request->unit_tujuan,
                'rs_rujuk'              => $request->nama_rs,
                'rs_rujuk_bagian'       => $request->bagian_rs,
                'konpas'                => [
                    'sistole'   => [
                        'hasil' => $tandaVitalReq[1]
                    ],
                    'distole'   => [
                        'hasil' => $tandaVitalReq[2]
                    ],
                    'respiration_rate'   => [
                        'hasil' => $tandaVitalReq[5]
                    ],
                    'suhu'   => [
                        'hasil' => $tandaVitalReq[8]
                    ],
                    'nadi'   => [
                        'hasil' => $tandaVitalReq[0]
                    ],
                    'tinggi_badan'   => [
                        'hasil' => $tandaVitalReq[3]
                    ],
                    'berat_badan'   => [
                        'hasil' => $tandaVitalReq[4]
                    ]
                ]
            ];

            $this->createResume($kd_pasien, $tgl_masuk, $request->urut_masuk, $resumeData);

            DB::commit();
            return back()->with('success', 'CPPT berhasil diubah!');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function verifikasiCppt($kd_pasien, $tgl_masuk, Request $request)
    {
        DB::beginTransaction();

        try {
            $kdPasienReq = $request->kd_pasien;
            $noTransaksiReq = $request->no_transaksi;
            $kdKasirReq = $request->kd_kasir;
            $tglReq = $request->tanggal;
            $urutReq = $request->urut;

            if (empty($kdPasienReq) || empty($noTransaksiReq) || empty($kdKasirReq) || empty($tglReq) || empty($urutReq)) return back()->with('error', 'Salah satu key verifikasi kosong!');

            Cppt::where('no_transaksi', $noTransaksiReq)
                ->where('kd_kasir', $kdKasirReq)
                ->where('tanggal', $tglReq)
                ->where('urut', $urutReq)
                ->update([
                    'verified'          => 1,
                    'user_verified'     => Auth::user()->id
                ]);

            DB::commit();
            return back()->with('success', 'Cppt berhasil di verifikasi');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function searchCppt($kd_pasien, $tgl_masuk, Request $request)
    {
        try {
            $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
                ->join('transaksi as t', function ($join) {
                    $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                    $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                    $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                    $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
                })
                ->where('kunjungan.kd_unit', 3)
                ->where('kunjungan.kd_pasien', $kd_pasien)
                ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
                ->where('kunjungan.urut_masuk', $request->urut_masuk)
                ->first();

            $tandaVital = MrKondisiFisik::OrderBy('urut')->get();
            $faktorPemberat = RmeFaktorPemberat::all();
            $faktorPeringan = RmeFaktorPeringan::all();
            $kualitasNyeri = RmeKualitasNyeri::all();
            $frekuensiNyeri = RmeFrekuensiNyeri::all();
            $menjalar = RmeMenjalar::all();
            $jenisNyeri = RmeJenisNyeri::all();
            $dokterPengirim = DokterKlinik::with(['dokter', 'unit'])
                ->where('kd_unit', 3)
                ->whereRelation('dokter', 'status', 1)
                ->get();

            $unitKonsul = Unit::where('kd_bagian', 2)
                ->where('aktif', 1)
                ->get();

            if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
                $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
            } else {
                $dataMedis->pasien->umur = 'Tidak Diketahui';
            }

            if (!$dataMedis) {
                abort(404, 'Data not found');
            }

            // get cppt
            $getCppt = Cppt::with(['dtCppt', 'pemberat', 'peringan', 'kualitas', 'frekuensi', 'menjalar', 'jenis'])
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
                    'cp.nama_penyakit'
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
                        ->on('a.tgl_masuk', '=', 'cppt.tanggal')
                        ->on('a.urut_masuk', '=', 'cppt.urut');
                })
                // tindak lanjut
                ->leftJoin('cppt_tindak_lanjut as ctl', function ($j) {
                    $j->on('ctl.no_transaksi', '=', 'cppt.no_transaksi')
                        ->on('ctl.kd_kasir', '=', 'cppt.kd_kasir')
                        ->on('ctl.tanggal', '=', 'cppt.tanggal')
                        ->on('ctl.urut', '=', 'cppt.urut');
                })
                // tanda vital
                ->leftJoin('mr_konpas as kp', function ($j) {
                    $j->on('kp.kd_pasien', '=', 't.kd_pasien')
                        ->on('kp.kd_unit', '=', 't.kd_unit')
                        ->on('kp.tgl_masuk', '=', 'cppt.tanggal')
                        ->on('kp.urut_masuk', '=', 'cppt.urut');
                })
                ->leftJoin('mr_konpasdtl as kpd', 'kpd.id_konpas', '=', 'kp.id_konpas')
                ->leftJoin('mr_kondisifisik as kf', 'kf.id_kondisi', '=', 'kpd.id_kondisi')
                ->leftJoin('cppt_penyakit as cp', function ($j) {
                    $j->on('cp.kd_unit', '=', 't.kd_unit')
                        ->on('cp.no_transaksi', '=', 'cppt.no_transaksi')
                        ->on('cp.tgl_cppt', '=', 'cppt.tanggal')
                        ->on('cp.urut_cppt', '=', 'cppt.urut_total');
                })
                ->leftJoin('penyakit as p', 'p.kd_penyakit', '=', 'cp.kd_penyakit')
                ->where('t.kd_pasien', $dataMedis->kd_pasien)
                ->where('t.kd_unit', $dataMedis->kd_unit)
                ->where('cppt.no_transaksi', $dataMedis->no_transaksi)
                ->where('cppt.kd_kasir', $dataMedis->kd_kasir);

            if (!empty($request->keyword)) {
                $getCppt->where('cppt.nama_penanggung', 'like', "%$request->keyword%")
                    ->where('cppt.tanggal', 'like', "%$request->keyword%")
                    ->where('cppt.jam', 'like', "%$request->keyword%")
                    ->where('cppt.obyektif', 'like', "%$request->keyword%")
                    ->where('cppt.planning', 'like', "%$request->keyword%")
                    ->where('cppt.pemeriksaan_fisik', 'like', "%$request->keyword%");
            }

            if (!empty($request->tgl_awal)) $getCppt->whereDate('cppt.tanggal', '>=', $request->tgl_awal);
            if (!empty($request->tgl_akhir)) $getCppt->whereDate('cppt.tanggal', '<=', $request->tgl_akhir);

            if (!empty($request->episode)) {
                if ($request->episode == 'sekarang') $getCppt->whereDate('cppt.tanggal', date('Y-m-d'));

                if ($request->episode != '1_bulan') {
                    $getCppt->whereDate('cppt.tanggal', '>=', date('Y-m-d', strtotime('-1 month', strtotime(date('Y-m-d')))))
                        ->whereDate('cppt.tanggal', '<=', date('Y-m-d'));
                }

                if ($request->episode != '3_bulan') {
                    $getCppt->whereDate('cppt.tanggal', '>=', date('Y-m-d', strtotime('-3 month', strtotime(date('Y-m-d')))))
                        ->whereDate('cppt.tanggal', '<=', date('Y-m-d'));
                }

                if ($request->episode != '6_bulan') {
                    $getCppt->whereDate('cppt.tanggal', '>=', date('Y-m-d', strtotime('-6 month', strtotime(date('Y-m-d')))))
                        ->whereDate('cppt.tanggal', '<=', date('Y-m-d'));
                }

                if ($request->episode != '9_bulan') {
                    $getCppt->whereDate('cppt.tanggal', '>=', date('Y-m-d', strtotime('-9 month', strtotime(date('Y-m-d')))))
                        ->whereDate('cppt.tanggal', '<=', date('Y-m-d'));
                }
            }

            $getCppt = $getCppt->orderBy('cppt.tanggal', 'desc')
                ->orderBy('cppt.jam', 'desc')
                ->orderBy('kf.urut')
                ->get();

            $cppt = $getCppt->groupBy(['urut_total'])->map(function ($item) {

                return [
                    'kd_pasien'             => $item->first()->kd_pasien,
                    'no_transaksi'          => $item->first()->no_transaksi,
                    'kd_kasir'              => $item->first()->kd_kasir,
                    'kd_unit'               => $item->first()->kd_unit,
                    'nama_unit'             => $item->first()->nama_unit,
                    'penanggung'            => $item->first()->dtCppt,
                    'nama_penanggung'       => $item->first()->nama_penanggung,
                    'tanggal'               => $item->first()->tanggal,
                    'jam'                   => $item->first()->jam,
                    'obyektif'              => $item->first()->obyektif,
                    'planning'              => $item->first()->planning,
                    'urut'                  => $item->first()->urut,
                    'skala_nyeri'           => $item->first()->skala_nyeri,
                    'lokasi'                => $item->first()->lokasi,
                    'durasi'                => $item->first()->durasi,
                    'pemberat'              => $item->first()->pemberat,
                    'peringan'              => $item->first()->peringan,
                    'kualitas'              => $item->first()->kualitas,
                    'frekuensi'             => $item->first()->frekuensi,
                    'menjalar'              => $item->first()->menjalar,
                    'jenis'                 => $item->first()->jenis,
                    'pemeriksaan_fisik'     => $item->first()->pemeriksaan_fisik,
                    'urut_total'            => $item->first()->urut_total,
                    'user_penanggung'       => $item->first()->user_penanggung,
                    'anamnesis'             => $item->first()->anamnesis,
                    'tindak_lanjut_code'    => $item->first()->tindak_lanjut_code,
                    'tindak_lanjut_name'    => $item->first()->tindak_lanjut_name,
                    'tgl_kontrol_ulang'     => $item->first()->tgl_kontrol_ulang,
                    'unit_rujuk_internal'   => $item->first()->unit_rujuk_internal,
                    'unit_rawat_inap'       => $item->first()->unit_rawat_inap,
                    'rs_rujuk'              => $item->first()->rs_rujuk,
                    'rs_rujuk_bagian'       => $item->first()->rs_rujuk_bagian,
                    'verified'              => $item->first()->verified,
                    'user_verified'         => $item->first()->user_verified,
                    'kondisi'               => [
                        "id_konpas"     => (int) $item->first()->id_konpas,
                        'konpas'        => $item->groupBy('id_kondisi')->map(function ($konpas) {
                            return [
                                "id_kondisi"    => $konpas->first()->id_kondisi,
                                "nama_kondisi"  => $konpas->first()->kondisi,
                                "satuan"        => $konpas->first()->satuan,
                                "hasil"         => $konpas->first()->hasil,
                            ];
                        })
                    ],
                    'cppt_penyakit'              => $item->groupBy('nama_penyakit')->map(function ($penyakit) {
                        return [
                            'nama_penyakit' => $penyakit->first()->nama_penyakit,
                        ];
                    }),
                    'penyakit'              => $item->groupBy('kd_penyakit')->map(function ($penyakit) {
                        return [
                            'kd_penyakit'   => $penyakit->first()->kd_penyakit,
                            'nama_penyakit' => $penyakit->first()->penyakit,
                        ];
                    })
                ];
            });

            return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.cppt.index', [
                'dataMedis'         => $dataMedis,
                'tandaVital'        => $tandaVital,
                'faktorPemberat'    => $faktorPemberat,
                'faktorPeringan'    => $faktorPeringan,
                'kualitasNyeri'     => $kualitasNyeri,
                'frekuensiNyeri'    => $frekuensiNyeri,
                'menjalar'          => $menjalar,
                'jenisNyeri'        => $jenisNyeri,
                'cppt'              => $cppt,
                'dokterPengirim'    => $dokterPengirim,
                'unitKonsul'        => $unitKonsul,
            ]);
        } catch (Exception $e) {
            return to_route('cppt.index', [$kd_pasien, $tgl_masuk])->with('error', 'Terjadi kesalahan saat pencarian');
        }
    }


    public function storeKonsultasi($kd_pasien, $tgl_masuk, $urut_masuk, $data)
    {
        // Create New Kunjungan Tujuan

        // get request data
        $tgl_konsul = $data['tgl_konsul'];
        $jam_konsul = $data['jam_konsul'];
        $dokter_pengirim = $data['dokter_pengirim'];
        $unit_tujuan = $data['unit_tujuan'];
        $dokter_unit_tujuan = $data['dokter_unit_tujuan'];
        $konsulen_harap = $data['konsulen_harap'];
        $catatan = $data['catatan'];
        $konsul = $data['konsul'];

        // get antrian terakhir
        $getLastAntrian = Kunjungan::select('antrian')
            ->whereDate('tgl_masuk', $tgl_konsul)
            ->where('kd_unit', $unit_tujuan)
            ->orderBy('antrian', 'desc')
            ->first();

        $no_antrian = !empty($getLastAntrian) ? $getLastAntrian->antrian + 1 : 1;

        // pasien not null get last urut masuk
        $getLastUrutMasukPatient = Kunjungan::select('urut_masuk')
            ->where('kd_pasien', $kd_pasien)
            ->whereDate('tgl_masuk', $tgl_konsul)
            ->orderBy('urut_masuk', 'desc')
            ->first();

        $urut_masuk = !empty($getLastUrutMasukPatient) ? $getLastUrutMasukPatient->urut_masuk + 1 : 0;

        // insert ke tabel kunjungan
        $dataKunjungan = [
            'kd_pasien'         => $kd_pasien,
            'kd_unit'           => $unit_tujuan,
            'tgl_masuk'         => $tgl_konsul,
            'urut_masuk'        => $urut_masuk,
            'jam_masuk'         => $jam_konsul,
            'asal_pasien'       => 0,
            'cara_penerimaan'   => 99,
            'kd_rujukan'        => 1,
            'no_surat'          => '',
            'kd_dokter'         => $dokter_unit_tujuan,
            'baru'              => 1,
            'kd_customer'       => '0000000001',
            'shift'             => 0,
            'kontrol'           => 0,
            'antrian'           => $no_antrian,
            'tgl_surat'         => $tgl_konsul,
            'jasa_raharja'      => 0,
            'catatan'           => '',
            'is_rujukan'        => 1,
            'rujukan_ket'       => "Instalasi Gawat Darurat"
        ];

        Kunjungan::create($dataKunjungan);

        // delete rujukan_kunjungan
        RujukanKunjungan::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $unit_tujuan)
            ->whereDate('tgl_masuk', $tgl_konsul)
            ->where('urut_masuk', $urut_masuk)
            ->delete();


        // insert transaksi
        $lastTransaction = Transaksi::select('no_transaksi')
            ->where('kd_kasir', '01')
            ->orderBy('no_transaksi', 'desc')
            ->first();

        if ($lastTransaction) {
            $lastTransactionNumber = (int) $lastTransaction->no_transaksi;
            $newTransactionNumber = $lastTransactionNumber + 1;
        } else {
            $newTransactionNumber = 1;
        }

        // formatted new transaction number with 7 digits length
        $formattedTransactionNumber = str_pad($newTransactionNumber, 7, '0', STR_PAD_LEFT);

        $dataTransaksi = [
            'kd_kasir'      => '01',
            'no_transaksi'  => $formattedTransactionNumber,
            'kd_pasien'     => $kd_pasien,
            'kd_unit'       => $unit_tujuan,
            'tgl_transaksi' => $tgl_konsul,
            'app'           => 0,
            'ispay'         => 0,
            'co_status'     => 0,
            'urut_masuk'    => $urut_masuk,
            'kd_user'       => $dokter_pengirim, // nanti diambil dari user yang login
            'lunas'         => 0,
        ];

        Transaksi::create($dataTransaksi);


        // insert detail_transaksi
        $dataDetailTransaksi = [
            'no_transaksi'  => $formattedTransactionNumber,
            'kd_kasir'      => '01',
            'tgl_transaksi' => $tgl_konsul,
            'urut'          => 1,
            'kd_tarif'      => 'TU',
            'kd_produk'     => 3634,
            'kd_unit'       => $unit_tujuan,
            'kd_unit_tr'    => 3,
            'tgl_berlaku'   => '2019-07-01',
            'kd_user'       => $dokter_pengirim,
            'shift'         => 0,
            'harga'         => 15000,
            'qty'           => 1,
            'flag'          => 0,
            'jns_trans'     => 0,
        ];

        DetailTransaksi::create($dataDetailTransaksi);


        // insert detail_prsh
        $dataDetailPrsh = [
            'kd_kasir'      => '01',
            'no_transaksi'  => $formattedTransactionNumber,
            'urut'          => 1,
            'tgl_transaksi' => $tgl_konsul,
            'hak'           => 15000,
            'selisih'       => 0,
            'disc'          => 0
        ];

        DetailPrsh::create($dataDetailPrsh);


        // delete detail_component
        DetailComponent::where('kd_kasir', '01')
            ->where('no_transaksi', $formattedTransactionNumber)
            ->where('urut', 1)
            ->delete();


        // insert detail_component
        $dataDetailComponent = [
            'kd_kasir'      => '01',
            'no_transaksi'  => $formattedTransactionNumber,
            'tgl_transaksi' => $tgl_konsul,
            'urut'          => 1,
            'kd_component'  => '30',
            'tarif'         => 15000,
            'disc'          => 0
        ];

        DetailComponent::create($dataDetailComponent);

        // insert sjp_kunjungan
        $sjpKunjunganData = [
            'kd_pasien'     => $kd_pasien,
            'kd_unit'       => $unit_tujuan,
            'tgl_masuk'     => $tgl_konsul,
            'urut_masuk'    => $urut_masuk,
            'no_sjp'        => '',
            'penjamin_laka' => 0,
            'katarak'       => 0,
            'dpjp'          => $dokter_unit_tujuan,
            'cob'           => 0
        ];

        SjpKunjungan::create($sjpKunjunganData);


        // Insert konsultasi
        $getLastUrutKonsul = Konsultasi::select(['urut_konsul'])
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', 3)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->orderBy('urut_konsul', 'desc')
            ->first();

        $urut_konsul = !empty($getLastUrutKonsul) ? $getLastUrutKonsul->urut_konsul + 1 : 1;

        $konsultasiData = [
            'kd_pasien'                 => $kd_pasien,
            'kd_unit'                   => 3,
            'tgl_masuk'                 => $tgl_masuk,
            'urut_masuk'                => $urut_masuk,
            'kd_pasien_tujuan'          => $kd_pasien,
            'kd_unit_tujuan'            => $unit_tujuan,
            'tgl_masuk_tujuan'          => $tgl_konsul,
            'urut_masuk_tujuan'         => $urut_masuk,
            'urut_konsul'               => $urut_konsul,
            'jam_masuk_tujuan'          => $jam_konsul,
            'kd_dokter'                 => $dokter_pengirim,
            'kd_dokter_tujuan'          => $dokter_unit_tujuan,
            'kd_konsulen_diharapkan'    => $konsulen_harap,
            'catatan'                   => $catatan,
            'konsul'                    => $konsul
        ];

        Konsultasi::create($konsultasiData);

        return true;
    }


    public function createResume($kd_pasien, $tgl_masuk, $urut_masuk, $data)
    {
        // get resume
        $resume = RMEResume::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', 3)
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
                'kd_unit'       => 3,
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