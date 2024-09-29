<?php

namespace App\Http\Controllers\UnitPelayanan\GawatDarurat;

use App\Http\Controllers\Controller;
use App\Models\Cppt;
use App\Models\CpptTindakLanjut;
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
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CpptController extends Controller
{
    public function index($kd_pasien, $tgl_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer'])
                            ->join('transaksi as t', function($join) {
                                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
                            })
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
                        'p.penyakit'
                    ])
                    // transaksi
                    ->join('transaksi as t', function($join) {
                        $join->on('cppt.no_transaksi', '=', 't.no_transaksi')
                            ->on('cppt.kd_kasir', '=', 't.kd_kasir');
                    })
                    // unit
                    ->join('unit as u', 't.kd_unit', '=', 'u.kd_unit')
                    // anamnesis
                    ->leftJoin('mr_anamnesis as a', function($j) {
                        $j->on('a.kd_pasien', '=', 't.kd_pasien')
                            ->on('a.kd_unit', '=', 't.kd_unit')
                            ->on('a.tgl_masuk', '=', 'cppt.tanggal')
                            ->on('a.urut_masuk', '=', 'cppt.urut');
                    })
                    // tindak lanjut
                    ->leftJoin('cppt_tindak_lanjut as ctl', function($j) {
                        $j->on('ctl.no_transaksi', '=', 'cppt.no_transaksi')
                            ->on('ctl.kd_kasir', '=', 'cppt.kd_kasir')
                            ->on('ctl.tanggal', '=', 'cppt.tanggal')
                            ->on('ctl.urut', '=', 'cppt.urut');
                    })
                    // tanda vital
                    ->leftJoin('mr_konpas as kp', function($j) {
                        $j->on('kp.kd_pasien', '=', 't.kd_pasien')
                            ->on('kp.kd_unit', '=', 't.kd_unit')
                            ->on('kp.tgl_masuk', '=', 'cppt.tanggal')
                            ->on('kp.urut_masuk', '=', 'cppt.urut');
                    })
                    ->leftJoin('mr_konpasdtl as kpd', 'kpd.id_konpas', '=', 'kp.id_konpas')
                    ->leftJoin('mr_kondisifisik as kf', 'kf.id_kondisi', '=', 'kpd.id_kondisi')
                    // diagnosa
                    ->leftJoin('mr_penyakit as mrp', function($j) {
                        $j->on('mrp.kd_pasien', '=', 't.kd_pasien')
                            ->on('mrp.kd_unit', '=', 't.kd_unit')
                            ->on('mrp.tgl_cppt', '=', 'cppt.tanggal')
                            ->on('mrp.urut_cppt', '=', 'cppt.urut');
                    })
                    ->leftJoin('penyakit as p', 'p.kd_penyakit', '=', 'mrp.kd_penyakit')
                    ->where('t.kd_pasien', $dataMedis->kd_pasien)
                    ->where('t.no_transaksi', $dataMedis->no_transaksi)
                    ->where('t.kd_unit', $dataMedis->kd_unit)
                    ->orderBy('cppt.tanggal', 'desc')
                    ->orderBy('kf.urut')
                    ->get();

        $cppt = $getCppt->groupBy(['urut'])->map(function($item) {
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
                'user_penanggung'       => $item->first()->user_penanggung,
                'anamnesis'             => $item->first()->anamnesis,
                'tindak_lanjut_code'    => $item->first()->tindak_lanjut_code,
                'tindak_lanjut_name'    => $item->first()->tindak_lanjut_name,
                'tgl_kontrol_ulang'     => $item->first()->tgl_kontrol_ulang,
                'unit_rujuk_internal'   => $item->first()->unit_rujuk_internal,
                'unit_rawat_inap'       => $item->first()->unit_rawat_inap,
                'rs_rujuk'              => $item->first()->rs_rujuk,
                'rs_rujuk_bagian'       => $item->first()->rs_rujuk_bagian,
                'kondisi'               => [
                    "id_konpas"     => (int) $item->first()->id_konpas,
                    'konpas'        => $item->groupBy('id_kondisi')->map(function($konpas) {
                        return [
                            "id_kondisi"    => $konpas->first()->id_kondisi,
                            "nama_kondisi"  => $konpas->first()->kondisi,
                            "satuan"        => $konpas->first()->satuan,
                            "hasil"         => $konpas->first()->hasil,
                        ];
                    })
                ],
                'penyakit'              => $item->groupBy('kd_penyakit')->map(function($penyakit) {
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
            'cppt'              => $cppt
        ]);
    }

    public function getIcdTenAjax(Request $request)
    {
        try {
            $search = $request->data;
            $query = Penyakit::select(['kd_penyakit', 'penyakit']);

            if(!empty($search)) {
                $query->where(function($q) use ($search) {
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

    public function store($kd_pasien, $tgl_masuk, Request $request)
    {
        // Validation Input
        $validatorMessage = [
            'anamnesis.required'            => 'Anamnesis harus di isi!',
            'skala_nyeri.required'          => 'Skala nyeri harus di isi!',
            'skala_nyeri.min'               => 'Nilai skala nyeri minimal 0!',
            'skala_nyeri.max'               => 'Nilai skala nyeri minimal 10!',
            'lokasi.required'               => 'Lokasi harus di isi!',
            'durasi.required'               => 'Durasi harus di isi!',
            'pemberat.required'             => 'Pemberat harus di isi!',
            'peringan.required'             => 'Peringan harus di isi!',
            'kualitas_nyeri.required'       => 'Kualitas nyeri harus di isi!',
            'frekuensi_nyeri.required'      => 'Frekuensi nyeri harus di isi!',
            'menjalar.required'             => 'Menjalar harus di isi!',
            'jenis_nyeri.required'          => 'Jenis nyeri harus di isi!',
            'pemeriksaan_fisik.required'    => 'Pemeriksaan fisik harus di isi!',
            'data_objektif.required'        => 'Data objektif harus di isi!',
            'planning.required'             => 'Planning harus di isi!',
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
                'skala_nyeri'       => 'required|min:0|max:10',
                'lokasi'            => 'required',
                'durasi'            => 'required',
                'pemberat'          => 'required',
                'peringan'          => 'required',
                'kualitas_nyeri'    => 'required',
                'frekuensi_nyeri'   => 'required',
                'menjalar'          => 'required',
                'jenis_nyeri'       => 'required',
                'pemeriksaan_fisik' => 'required',
                'data_objektif'     => 'required',
                'planning'          => 'required',
                'tindak_lanjut'     => 'required'
        ], $validatorMessage);

        // get kunjungan
        $kunjungan = Kunjungan::join('transaksi as t', function($join) {
                                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
                            })
                            ->where('kunjungan.kd_unit', 3)
                            ->where('kunjungan.kd_pasien', $kd_pasien)
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
        foreach($tandaVitalList as $item) {
            $konpasDtlInsertData = [
                'id_konpas'     => $newIdKonpas,
                'id_kondisi'    => $item->id_kondisi,
                'hasil'         => $tandaVitalReq[$i]
            ];

            MrKonpasDtl::create($konpasDtlInsertData);
            $i++;
        }


        // store diagnosis
        $diagnosisReq = $request->diagnosis;
        $diagnosisList = explode(',', $diagnosisReq);
        
        $lastUrutMasukDiagnosis = MrPenyakit::where('kd_pasien', $kunjungan->kd_pasien)
                                    ->where('kd_unit', $kunjungan->kd_unit)
                                    ->whereDate('tgl_masuk', $tanggal)
                                    ->count();
        $lastUrutMasukDiagnosis += 1;

        foreach($diagnosisList as $diag) {

            $diagInsertData = [
                'kd_penyakit'       => $diag,
                'kd_pasien'         => $kunjungan->kd_pasien,
                'kd_unit'           => $kunjungan->kd_unit,
                'tgl_masuk'         => $kunjungan->tgl_masuk,
                'urut_masuk'        => $kunjungan->urut_masuk,
                'urut'              => $lastUrutMasukDiagnosis,
                'stat_diag'         => 0,
                'kasus'             => 0,
                'tindakan'          => 0,
                'perawatan'         => 0,
                'tgl_cppt'          => $tanggal
            ];

            MrPenyakit::create($diagInsertData);
            $lastUrutMasukDiagnosis++;
        }


        // store CPPT
        $lastUrutCPPT = Cppt::where('no_transaksi', $kunjungan->no_transaksi)
                                    ->where('kd_kasir', $kunjungan->kd_kasir)
                                    ->whereDate('tanggal', $tanggal)
                                    ->count();
        $lastUrutCPPT += 1;

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
            'pemberat'              => $request->pemberat,
            'peringan'              => $request->peringan,
            'kualitas_nyeri_id'     => $request->kualitas_nyeri,
            'frekuensi_nyeri_id'    => $request->frekuensi_nyeri,
            'menjalar_id'           => $request->menjalar,
            'jenis_nyeri_id'        => $request->jenis_nyeri,
            'pemeriksaan_fisik'     => $request->pemeriksaan_fisik,
            'user_penanggung'       => Auth::user()->id
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
            // 'urut'                  => $lastUrutCPPT
            'urut'                  => 1
        ];

        CpptTindakLanjut::create($cpptTindakLanjutInsertData);

        return back()->with('success', 'CPPT berhasil ditambah!');
    }
}


