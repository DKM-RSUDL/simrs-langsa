<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Edukasi;
use App\Models\EdukasiKebutuhanEdukasi;
use App\Models\EdukasiKebutuhanEdukasiLanjutan;
use App\Models\EdukasiPasien;
use App\Models\RMEEdukasiRoles;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Kunjungan;
use App\Models\Pendidikan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

class RawatInapEdukasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
    }

    public function index(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
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

        $edukasi = Edukasi::with(['edukasiPasien', 'kebutuhanEdukasi', 'kebutuhanEdukasiLanjutan', 'userCreate'])
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('unit-pelayanan.rawat-inap.pelayanan.edukasi.index', compact(
            'dataMedis',
            'edukasi',
        ));
    }

    public function create($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
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

        $role = $request->query('role');

        $sectionAccess = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16];

        if($role == 'dokter') $sectionAccess = [1,2,9,10,13,15,16];
        if($role == 'farmasi') $sectionAccess = [3,15,16];
        if($role == 'gizi') $sectionAccess = [4,15,16];
        if($role == 'perawat') $sectionAccess = [5,6,7,15,16];
        if($role == 'adc') $sectionAccess = [11,12,14,15,16];

        $pendidikan = Pendidikan::all();

        return view('unit-pelayanan.rawat-inap.pelayanan.edukasi.create', compact(
            'dataMedis',
            'pendidikan',
            'sectionAccess',
            'role'
        ));
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {

        DB::beginTransaction();
        try {

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
                abort(404, 'Data kunjungan tidak ditemukan');
            }

            $role = $request->role;
            $sectionAccess = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16];

            if($role == 'dokter') $sectionAccess = [1,2,9,10,13,15,16];
            if($role == 'farmasi') $sectionAccess = [3,15,16];
            if($role == 'gizi') $sectionAccess = [4,15,16];
            if($role == 'perawat') $sectionAccess = [5,6,7,15,16];
            if($role == 'adc') $sectionAccess = [11,12,14,15,16];


            // CREATE EDUKASI
            $edukasi = Edukasi::firstOrCreate([
                'kd_pasien' => $kd_pasien,
                'kd_unit' => $kd_unit,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
            ], [
                'waktu_edukasi' => date('Y-m-d H:i:s'),
                'user_create' => Auth::id(),
            ]);

            // CREATE USER_EDUKASI_ROLE
            $dataRole = [
                'id_edukasi'    => 10,
            ];

            $userLogin = Auth::id();

            foreach($sectionAccess as $acc) {
                $dataRole = array_merge($dataRole, ["user_edukasi_$acc" => $userLogin]);
            }

            $userEdukasiRole = RMEEdukasiRoles::firstOrCreate([
                'id_edukasi' => $edukasi->id,
            ], $dataRole);

            // Convert arrays to JSON strings
            $tipe_pembelajaran = null;
            if ($request->has('tipe_pembelajaran') && is_array($request->tipe_pembelajaran)) {
                $tipe_pembelajaran = json_encode($request->tipe_pembelajaran);
            }

            $hambatan_komunikasi = null;
            if ($request->has('hambatan_komunikasi') && is_array($request->hambatan_komunikasi)) {
                $hambatan_komunikasi = json_encode($request->hambatan_komunikasi);
            }

            $edukasiPasien = new EdukasiPasien();
            $edukasiPasien->id_edukasi = $edukasi->id;
            $edukasiPasien->kebutuhan_penerjemah = $request->kebutuhan_penerjemah;
            $edukasiPasien->penerjemah_bahasa = $request->penerjemah_bahasa;
            $edukasiPasien->pendidikan = $request->pendidikan;
            $edukasiPasien->kemampuan_baca_tulis = $request->kemampuan_baca_tulis;
            $edukasiPasien->tipe_pembelajaran = $tipe_pembelajaran;
            $edukasiPasien->hambatan_komunikasi = $hambatan_komunikasi;
            $edukasiPasien->save();

            $pemahaman_awal_1 = null;
            if ($request->has('pemahaman_awal_1') && is_array($request->pemahaman_awal_1)) {
                $pemahaman_awal_1 = json_encode($request->pemahaman_awal_1);
            }
            $metode_1 = null;
            if ($request->has('metode_1') && is_array($request->metode_1)) {
                $metode_1 = json_encode($request->metode_1);
            }
            $media_1 = null;
            if ($request->has('media_1') && is_array($request->media_1)) {
                $media_1 = json_encode($request->media_1);
            }
            $evaluasi_1 = null;
            if ($request->has('evaluasi_1') && is_array($request->evaluasi_1)) {
                $evaluasi_1 = json_encode($request->evaluasi_1);
            }

            $pemahaman_awal_2 = null;
            if ($request->has('pemahaman_awal_2') && is_array($request->pemahaman_awal_2)) {
                $pemahaman_awal_2 = json_encode($request->pemahaman_awal_2);
            }
            $metode_2 = null;
            if ($request->has('metode_2') && is_array($request->metode_2)) {
                $metode_2 = json_encode($request->metode_2);
            }
            $media_2 = null;
            if ($request->has('media_2') && is_array($request->media_2)) {
                $media_2 = json_encode($request->media_2);
            }
            $evaluasi_2 = null;
            if ($request->has('evaluasi_2') && is_array($request->evaluasi_2)) {
                $evaluasi_2 = json_encode($request->evaluasi_2);
            }

            $pemahaman_awal_3 = null;
            if ($request->has('pemahaman_awal_3') && is_array($request->pemahaman_awal_3)) {
                $pemahaman_awal_3 = json_encode($request->pemahaman_awal_3);
            }
            $metode_3 = null;
            if ($request->has('metode_3') && is_array($request->metode_3)) {
                $metode_3 = json_encode($request->metode_3);
            }
            $media_3 = null;
            if ($request->has('media_3') && is_array($request->media_3)) {
                $media_3 = json_encode($request->media_3);
            }
            $evaluasi_3 = null;
            if ($request->has('evaluasi_3') && is_array($request->evaluasi_3)) {
                $evaluasi_3 = json_encode($request->evaluasi_3);
            }

            $pemahaman_awal_4 = null;
            if ($request->has('pemahaman_awal_4') && is_array($request->pemahaman_awal_4)) {
                $pemahaman_awal_4 = json_encode($request->pemahaman_awal_4);
            }
            $metode_4 = null;
            if ($request->has('metode_4') && is_array($request->metode_4)) {
                $metode_4 = json_encode($request->metode_4);
            }
            $media_4 = null;
            if ($request->has('media_4') && is_array($request->media_4)) {
                $media_4 = json_encode($request->media_4);
            }
            $evaluasi_4 = null;
            if ($request->has('evaluasi_4') && is_array($request->evaluasi_4)) {
                $evaluasi_4 = json_encode($request->evaluasi_4);
            }

            $pemahaman_awal_5 = null;
            if ($request->has('pemahaman_awal_5') && is_array($request->pemahaman_awal_5)) {
                $pemahaman_awal_5 = json_encode($request->pemahaman_awal_5);
            }
            $metode_5 = null;
            if ($request->has('metode_5') && is_array($request->metode_5)) {
                $metode_5 = json_encode($request->metode_5);
            }
            $media_5 = null;
            if ($request->has('media_5') && is_array($request->media_5)) {
                $media_5 = json_encode($request->media_5);
            }
            $evaluasi_5 = null;
            if ($request->has('evaluasi_5') && is_array($request->evaluasi_5)) {
                $evaluasi_5 = json_encode($request->evaluasi_5);
            }

            $pemahaman_awal_6 = null;
            if ($request->has('pemahaman_awal_6') && is_array($request->pemahaman_awal_6)) {
                $pemahaman_awal_6 = json_encode($request->pemahaman_awal_6);
            }
            $metode_6 = null;
            if ($request->has('metode_6') && is_array($request->metode_6)) {
                $metode_6 = json_encode($request->metode_6);
            }
            $media_6 = null;
            if ($request->has('media_6') && is_array($request->media_6)) {
                $media_6 = json_encode($request->media_6);
            }
            $evaluasi_6 = null;
            if ($request->has('evaluasi_6') && is_array($request->evaluasi_6)) {
                $evaluasi_6 = json_encode($request->evaluasi_6);
            }

            $KebutuhanEdukasi = new EdukasiKebutuhanEdukasi();
            $KebutuhanEdukasi->id_edukasi = $edukasi->id;
            $KebutuhanEdukasi->tanggal_1 = $request->tanggal_1;
            $KebutuhanEdukasi->ket_Kondisi_medis_1 = $request->ket_Kondisi_medis_1;
            $KebutuhanEdukasi->sasaran_nama_1 = $request->sasaran_nama_1;
            $KebutuhanEdukasi->edukator_nama_1 = $request->edukator_nama_1;
            $KebutuhanEdukasi->pemahaman_awal_1 = $pemahaman_awal_1;
            $KebutuhanEdukasi->metode_1 = $metode_1;
            $KebutuhanEdukasi->media_1 = $media_1;
            $KebutuhanEdukasi->evaluasi_1 = $evaluasi_1;
            $KebutuhanEdukasi->lama_edukasi_1 = $request->lama_edukasi_1;

            $KebutuhanEdukasi->tanggal_2 = $request->tanggal_2;
            $KebutuhanEdukasi->sasaran_nama_2 = $request->sasaran_nama_2;
            $KebutuhanEdukasi->edukator_nama_2 = $request->edukator_nama_2;
            $KebutuhanEdukasi->pemahaman_awal_2 = $pemahaman_awal_2;
            $KebutuhanEdukasi->metode_2 = $metode_2;
            $KebutuhanEdukasi->media_2 = $media_2;
            $KebutuhanEdukasi->evaluasi_2 = $evaluasi_2;
            $KebutuhanEdukasi->lama_edukasi_2 = $request->lama_edukasi_2;

            $KebutuhanEdukasi->tanggal_3 = $request->tanggal_3;
            $KebutuhanEdukasi->sasaran_nama_3 = $request->sasaran_nama_3;
            $KebutuhanEdukasi->edukator_nama_3 = $request->edukator_nama_3;
            $KebutuhanEdukasi->pemahaman_awal_3 = $pemahaman_awal_3;
            $KebutuhanEdukasi->metode_3 = $metode_3;
            $KebutuhanEdukasi->media_3 = $media_3;
            $KebutuhanEdukasi->evaluasi_3 = $evaluasi_3;
            $KebutuhanEdukasi->lama_edukasi_3 = $request->lama_edukasi_3;

            $KebutuhanEdukasi->tanggal_4 = $request->tanggal_4;
            $KebutuhanEdukasi->ket_program_4 = $request->ket_program_4;
            $KebutuhanEdukasi->sasaran_nama_4 = $request->sasaran_nama_4;
            $KebutuhanEdukasi->edukator_nama_4 = $request->edukator_nama_4;
            $KebutuhanEdukasi->pemahaman_awal_4 = $pemahaman_awal_4;
            $KebutuhanEdukasi->metode_4 = $metode_4;
            $KebutuhanEdukasi->media_4 = $media_4;
            $KebutuhanEdukasi->evaluasi_4 = $evaluasi_4;
            $KebutuhanEdukasi->lama_edukasi_4 = $request->lama_edukasi_4;

            $KebutuhanEdukasi->tanggal_5 = $request->tanggal_5;
            $KebutuhanEdukasi->sasaran_nama_5 = $request->sasaran_nama_5;
            $KebutuhanEdukasi->edukator_nama_5 = $request->edukator_nama_5;
            $KebutuhanEdukasi->pemahaman_awal_5 = $pemahaman_awal_5;
            $KebutuhanEdukasi->metode_5 = $metode_5;
            $KebutuhanEdukasi->media_5 = $media_5;
            $KebutuhanEdukasi->evaluasi_5 = $evaluasi_5;
            $KebutuhanEdukasi->lama_edukasi_5 = $request->lama_edukasi_5;

            $KebutuhanEdukasi->tanggal_6 = $request->tanggal_6;
            $KebutuhanEdukasi->sasaran_nama_6 = $request->sasaran_nama_6;
            $KebutuhanEdukasi->edukator_nama_6 = $request->edukator_nama_6;
            $KebutuhanEdukasi->pemahaman_awal_6 = $pemahaman_awal_6;
            $KebutuhanEdukasi->metode_6 = $metode_6;
            $KebutuhanEdukasi->media_6 = $media_6;
            $KebutuhanEdukasi->evaluasi_6 = $evaluasi_6;
            $KebutuhanEdukasi->lama_edukasi_6 = $request->lama_edukasi_6;
            $KebutuhanEdukasi->save();

            $pemahaman_awal_7 = null;
            if ($request->has('pemahaman_awal_7') && is_array($request->pemahaman_awal_7)) {
                $pemahaman_awal_7 = json_encode($request->pemahaman_awal_7);
            }
            $metode_7 = null;
            if ($request->has('metode_7') && is_array($request->metode_7)) {
                $metode_7 = json_encode($request->metode_7);
            }
            $media_7 = null;
            if ($request->has('media_7') && is_array($request->media_7)) {
                $media_7 = json_encode($request->media_7);
            }
            $evaluasi_7 = null;
            if ($request->has('evaluasi_7') && is_array($request->evaluasi_7)) {
                $evaluasi_7 = json_encode($request->evaluasi_7);
            }

            $pemahaman_awal_8 = null;
            if ($request->has('pemahaman_awal_8') && is_array($request->pemahaman_awal_8)) {
                $pemahaman_awal_8 = json_encode($request->pemahaman_awal_8);
            }
            $metode_8 = null;
            if ($request->has('metode_8') && is_array($request->metode_8)) {
                $metode_8 = json_encode($request->metode_8);
            }
            $media_8 = null;
            if ($request->has('media_8') && is_array($request->media_8)) {
                $media_8 = json_encode($request->media_8);
            }
            $evaluasi_8 = null;
            if ($request->has('evaluasi_8') && is_array($request->evaluasi_8)) {
                $evaluasi_8 = json_encode($request->evaluasi_8);
            }

            $pemahaman_awal_9 = null;
            if ($request->has('pemahaman_awal_9') && is_array($request->pemahaman_awal_9)) {
                $pemahaman_awal_9 = json_encode($request->pemahaman_awal_9);
            }
            $metode_9 = null;
            if ($request->has('metode_9') && is_array($request->metode_9)) {
                $metode_9 = json_encode($request->metode_9);
            }
            $media_9 = null;
            if ($request->has('media_9') && is_array($request->media_9)) {
                $media_9 = json_encode($request->media_9);
            }
            $evaluasi_9 = null;
            if ($request->has('evaluasi_9') && is_array($request->evaluasi_9)) {
                $evaluasi_9 = json_encode($request->evaluasi_9);
            }

            $pemahaman_awal_10 = null;
            if ($request->has('pemahaman_awal_10') && is_array($request->pemahaman_awal_10)) {
                $pemahaman_awal_10 = json_encode($request->pemahaman_awal_10);
            }
            $metode_10 = null;
            if ($request->has('metode_10') && is_array($request->metode_10)) {
                $metode_10 = json_encode($request->metode_10);
            }
            $media_10 = null;
            if ($request->has('media_10') && is_array($request->media_10)) {
                $media_10 = json_encode($request->media_10);
            }
            $evaluasi_10 = null;
            if ($request->has('evaluasi_10') && is_array($request->evaluasi_10)) {
                $evaluasi_10 = json_encode($request->evaluasi_10);
            }

            $pemahaman_awal_11 = null;
            if ($request->has('pemahaman_awal_11') && is_array($request->pemahaman_awal_11)) {
                $pemahaman_awal_11 = json_encode($request->pemahaman_awal_11);
            }
            $metode_11 = null;
            if ($request->has('metode_11') && is_array($request->metode_11)) {
                $metode_11 = json_encode($request->metode_11);
            }
            $media_11 = null;
            if ($request->has('media_11') && is_array($request->media_11)) {
                $media_11 = json_encode($request->media_11);
            }
            $evaluasi_11 = null;
            if ($request->has('evaluasi_11') && is_array($request->evaluasi_11)) {
                $evaluasi_11 = json_encode($request->evaluasi_11);
            }

            $pemahaman_awal_12 = null;
            if ($request->has('pemahaman_awal_12') && is_array($request->pemahaman_awal_12)) {
                $pemahaman_awal_12 = json_encode($request->pemahaman_awal_12);
            }
            $metode_12 = null;
            if ($request->has('metode_12') && is_array($request->metode_12)) {
                $metode_12 = json_encode($request->metode_12);
            }
            $media_12 = null;
            if ($request->has('media_12') && is_array($request->media_12)) {
                $media_12 = json_encode($request->media_12);
            }
            $evaluasi_12 = null;
            if ($request->has('evaluasi_12') && is_array($request->evaluasi_12)) {
                $evaluasi_12 = json_encode($request->evaluasi_12);
            }

            $pemahaman_awal_13 = null;
            if ($request->has('pemahaman_awal_13') && is_array($request->pemahaman_awal_13)) {
                $pemahaman_awal_13 = json_encode($request->pemahaman_awal_13);
            }
            $metode_13 = null;
            if ($request->has('metode_13') && is_array($request->metode_13)) {
                $metode_13 = json_encode($request->metode_13);
            }
            $media_13 = null;
            if ($request->has('media_13') && is_array($request->media_13)) {
                $media_13 = json_encode($request->media_13);
            }
            $evaluasi_13 = null;
            if ($request->has('evaluasi_13') && is_array($request->evaluasi_13)) {
                $evaluasi_13 = json_encode($request->evaluasi_13);
            }

            $pemahaman_awal_14 = null;
            if ($request->has('pemahaman_awal_14') && is_array($request->pemahaman_awal_14)) {
                $pemahaman_awal_14 = json_encode($request->pemahaman_awal_14);
            }
            $metode_14 = null;
            if ($request->has('metode_14') && is_array($request->metode_14)) {
                $metode_14 = json_encode($request->metode_14);
            }
            $media_14 = null;
            if ($request->has('media_14') && is_array($request->media_14)) {
                $media_14 = json_encode($request->media_14);
            }
            $evaluasi_14 = null;
            if ($request->has('evaluasi_14') && is_array($request->evaluasi_14)) {
                $evaluasi_14 = json_encode($request->evaluasi_14);
            }
            $pemahaman_awal_15 = null;
            if ($request->has('pemahaman_awal_15') && is_array($request->pemahaman_awal_15)) {
                $pemahaman_awal_15 = json_encode($request->pemahaman_awal_15);
            }
            $metode_15 = null;
            if ($request->has('metode_15') && is_array($request->metode_15)) {
                $metode_15 = json_encode($request->metode_15);
            }
            $media_15 = null;
            if ($request->has('media_15') && is_array($request->media_15)) {
                $media_15 = json_encode($request->media_15);
            }
            $evaluasi_15 = null;
            if ($request->has('evaluasi_15') && is_array($request->evaluasi_15)) {
                $evaluasi_15 = json_encode($request->evaluasi_15);
            }

            $pemahaman_awal_16 = null;
            if ($request->has('pemahaman_awal_16') && is_array($request->pemahaman_awal_16)) {
                $pemahaman_awal_16 = json_encode($request->pemahaman_awal_16);
            }
            $metode_16 = null;
            if ($request->has('metode_16') && is_array($request->metode_16)) {
                $metode_16 = json_encode($request->metode_16);
            }
            $media_16 = null;
            if ($request->has('media_16') && is_array($request->media_16)) {
                $media_16 = json_encode($request->media_16);
            }
            $evaluasi_16 = null;
            if ($request->has('evaluasi_16') && is_array($request->evaluasi_16)) {
                $evaluasi_16 = json_encode($request->evaluasi_16);
            }

            $KebutuhanEdukasiLanjutan = new EdukasiKebutuhanEdukasiLanjutan();
            $KebutuhanEdukasiLanjutan->id_edukasi = $edukasi->id;
            $KebutuhanEdukasiLanjutan->tanggal_7 = $request->tanggal_7;
            $KebutuhanEdukasiLanjutan->sasaran_nama_7 = $request->sasaran_nama_7;
            $KebutuhanEdukasiLanjutan->edukator_nama_7 = $request->edukator_nama_7;
            $KebutuhanEdukasiLanjutan->pemahaman_awal_7 = $pemahaman_awal_7;
            $KebutuhanEdukasiLanjutan->metode_7 = $metode_7;
            $KebutuhanEdukasiLanjutan->media_7 = $media_7;
            $KebutuhanEdukasiLanjutan->evaluasi_7 = $evaluasi_7;
            $KebutuhanEdukasiLanjutan->lama_edukasi_7 = $request->lama_edukasi_7;

            $KebutuhanEdukasiLanjutan->tanggal_8 = $request->tanggal_8;
            $KebutuhanEdukasiLanjutan->sasaran_nama_8 = $request->sasaran_nama_8;
            $KebutuhanEdukasiLanjutan->edukator_nama_8 = $request->edukator_nama_8;
            $KebutuhanEdukasiLanjutan->pemahaman_awal_8 = $pemahaman_awal_8;
            $KebutuhanEdukasiLanjutan->metode_8 = $metode_8;
            $KebutuhanEdukasiLanjutan->media_8 = $media_8;
            $KebutuhanEdukasiLanjutan->evaluasi_8 = $evaluasi_8;
            $KebutuhanEdukasiLanjutan->lama_edukasi_8 = $request->lama_edukasi_8;

            $KebutuhanEdukasiLanjutan->tanggal_9 = $request->tanggal_9;
            $KebutuhanEdukasiLanjutan->ket_teknik_rehabilitasi_9 = $request->ket_teknik_rehabilitasi_9;
            $KebutuhanEdukasiLanjutan->teknik_rehabilitasi_9 = $request->teknik_rehabilitasi_9;
            $KebutuhanEdukasiLanjutan->sasaran_nama_9 = $request->sasaran_nama_9;
            $KebutuhanEdukasiLanjutan->edukator_nama_9 = $request->edukator_nama_9;
            $KebutuhanEdukasiLanjutan->pemahaman_awal_9 = $pemahaman_awal_9;
            $KebutuhanEdukasiLanjutan->metode_9 = $metode_9;
            $KebutuhanEdukasiLanjutan->media_9 = $media_9;
            $KebutuhanEdukasiLanjutan->evaluasi_9 = $evaluasi_9;
            $KebutuhanEdukasiLanjutan->lama_edukasi_9 = $request->lama_edukasi_9;

            $KebutuhanEdukasiLanjutan->tanggal_10 = $request->tanggal_10;
            $KebutuhanEdukasiLanjutan->sasaran_nama_10 = $request->sasaran_nama_10;
            $KebutuhanEdukasiLanjutan->edukator_nama_10 = $request->edukator_nama_10;
            $KebutuhanEdukasiLanjutan->pemahaman_awal_10 = $pemahaman_awal_10;
            $KebutuhanEdukasiLanjutan->metode_10 = $metode_10;
            $KebutuhanEdukasiLanjutan->media_10 = $media_10;
            $KebutuhanEdukasiLanjutan->evaluasi_10 = $evaluasi_10;
            $KebutuhanEdukasiLanjutan->lama_edukasi_10 = $request->lama_edukasi_10;

            $KebutuhanEdukasiLanjutan->tanggal_11 = $request->tanggal_11;
            $KebutuhanEdukasiLanjutan->sasaran_nama_11 = $request->sasaran_nama_11;
            $KebutuhanEdukasiLanjutan->edukator_nama_11 = $request->edukator_nama_11;
            $KebutuhanEdukasiLanjutan->pemahaman_awal_11 = $pemahaman_awal_11;
            $KebutuhanEdukasiLanjutan->metode_11 = $metode_11;
            $KebutuhanEdukasiLanjutan->media_11 = $media_11;
            $KebutuhanEdukasiLanjutan->evaluasi_11 = $evaluasi_11;
            $KebutuhanEdukasiLanjutan->lama_edukasi_11 = $request->lama_edukasi_11;

            $KebutuhanEdukasiLanjutan->tanggal_12 = $request->tanggal_12;
            $KebutuhanEdukasiLanjutan->sasaran_nama_12 = $request->sasaran_nama_12;
            $KebutuhanEdukasiLanjutan->edukator_nama_12 = $request->edukator_nama_12;
            $KebutuhanEdukasiLanjutan->pemahaman_awal_12 = $pemahaman_awal_12;
            $KebutuhanEdukasiLanjutan->metode_12 = $metode_12;
            $KebutuhanEdukasiLanjutan->media_12 = $media_12;
            $KebutuhanEdukasiLanjutan->evaluasi_12 = $evaluasi_12;
            $KebutuhanEdukasiLanjutan->lama_edukasi_12 = $request->lama_edukasi_12;

            $KebutuhanEdukasiLanjutan->tanggal_13 = $request->tanggal_13;
            $KebutuhanEdukasiLanjutan->sasaran_nama_13 = $request->sasaran_nama_13;
            $KebutuhanEdukasiLanjutan->edukator_nama_13 = $request->edukator_nama_13;
            $KebutuhanEdukasiLanjutan->pemahaman_awal_13 = $pemahaman_awal_13;
            $KebutuhanEdukasiLanjutan->metode_13 = $metode_13;
            $KebutuhanEdukasiLanjutan->media_13 = $media_13;
            $KebutuhanEdukasiLanjutan->evaluasi_13 = $evaluasi_13;
            $KebutuhanEdukasiLanjutan->lama_edukasi_13 = $request->lama_edukasi_13;

            $KebutuhanEdukasiLanjutan->tanggal_14 = $request->tanggal_14;
            $KebutuhanEdukasiLanjutan->ket_hambatan_14 = $request->ket_hambatan_14;
            $KebutuhanEdukasiLanjutan->sasaran_nama_14 = $request->sasaran_nama_14;
            $KebutuhanEdukasiLanjutan->edukator_nama_14 = $request->edukator_nama_14;
            $KebutuhanEdukasiLanjutan->pemahaman_awal_14 = $pemahaman_awal_14;
            $KebutuhanEdukasiLanjutan->metode_14 = $metode_14;
            $KebutuhanEdukasiLanjutan->media_14 = $media_14;
            $KebutuhanEdukasiLanjutan->evaluasi_14 = $evaluasi_14;
            $KebutuhanEdukasiLanjutan->lama_edukasi_14 = $request->lama_edukasi_14;

            $KebutuhanEdukasiLanjutan->tanggal_15 = $request->tanggal_15;
            $KebutuhanEdukasiLanjutan->ket_pertanyaan_15 = $request->ket_pertanyaan_15;
            $KebutuhanEdukasiLanjutan->sasaran_nama_15 = $request->sasaran_nama_15;
            $KebutuhanEdukasiLanjutan->edukator_nama_15 = $request->edukator_nama_15;
            $KebutuhanEdukasiLanjutan->pemahaman_awal_15 = $pemahaman_awal_15;
            $KebutuhanEdukasiLanjutan->metode_15 = $metode_15;
            $KebutuhanEdukasiLanjutan->media_15 = $media_15;
            $KebutuhanEdukasiLanjutan->evaluasi_15 = $evaluasi_15;
            $KebutuhanEdukasiLanjutan->lama_edukasi_15 = $request->lama_edukasi_15;

            $KebutuhanEdukasiLanjutan->tanggal_16 = $request->tanggal_16;
            $KebutuhanEdukasiLanjutan->ket_preferensi_16 = $request->ket_preferensi_16;
            $KebutuhanEdukasiLanjutan->sasaran_nama_16 = $request->sasaran_nama_16;
            $KebutuhanEdukasiLanjutan->edukator_nama_16 = $request->edukator_nama_16;
            $KebutuhanEdukasiLanjutan->pemahaman_awal_16 = $pemahaman_awal_16;
            $KebutuhanEdukasiLanjutan->metode_16 = $metode_16;
            $KebutuhanEdukasiLanjutan->media_16 = $media_16;
            $KebutuhanEdukasiLanjutan->evaluasi_16 = $evaluasi_16;
            $KebutuhanEdukasiLanjutan->lama_edukasi_16 = $request->lama_edukasi_16;
            $KebutuhanEdukasiLanjutan->save();

            DB::commit();

            return redirect()->route('rawat-inap.edukasi.index', [
                $kd_unit,
                $kd_pasien,
                $tgl_masuk,
                $request->urut_masuk,
            ])->with(['success' => 'Berhasil menambah Edukasi !']);
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {

        $edukasi = Edukasi::with([
            'edukasiPasien',
            'kebutuhanEdukasi',
            'kebutuhanEdukasiLanjutan',
            'userCreate',
        ])->findOrFail($id);

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

        // Get reference data for display purposes
        $pendidikan = Pendidikan::all();

        return view('unit-pelayanan.rawat-inap.pelayanan.edukasi.show', compact('edukasi', 'pendidikan', 'dataMedis'));
    }

    public function edit($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {

        $edukasi = Edukasi::with([
            'edukasiPasien',
            'kebutuhanEdukasi',
            'kebutuhanEdukasiLanjutan',
            'userCreate',
        ])->findOrFail($id);

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

        // Get reference data for display purposes
        $pendidikan = Pendidikan::all();

        return view('unit-pelayanan.rawat-inap.pelayanan.edukasi.edit', compact('edukasi', 'pendidikan', 'dataMedis'));
    }

    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {

        DB::beginTransaction();
        try {

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
                abort(404, 'Data kunjungan tidak ditemukan');
            }

            $edukasi = Edukasi::findOrFail($id);
            $edukasi->kd_pasien = $kd_pasien;
            $edukasi->kd_unit = $request->kd_unit;
            $edukasi->tgl_masuk = $tgl_masuk;
            $edukasi->urut_masuk = $urut_masuk;
            $edukasi->waktu_edukasi = date('Y-m-d H:i:s');
            $edukasi->user_edit = Auth::id();
            $edukasi->save();

            // Convert arrays to JSON strings
            $tipe_pembelajaran = null;
            if ($request->has('tipe_pembelajaran') && is_array($request->tipe_pembelajaran)) {
                $tipe_pembelajaran = json_encode($request->tipe_pembelajaran);
            }

            $hambatan_komunikasi = null;
            if ($request->has('hambatan_komunikasi') && is_array($request->hambatan_komunikasi)) {
                $hambatan_komunikasi = json_encode($request->hambatan_komunikasi);
            }

            $edukasiPasien = EdukasiPasien::firstOrNew(['id_edukasi' => $edukasi->id]);
            $edukasiPasien->id_edukasi = $edukasi->id;
            $edukasiPasien->kebutuhan_penerjemah = $request->kebutuhan_penerjemah;
            $edukasiPasien->penerjemah_bahasa = $request->penerjemah_bahasa;
            $edukasiPasien->pendidikan = $request->pendidikan;
            $edukasiPasien->kemampuan_baca_tulis = $request->kemampuan_baca_tulis;
            $edukasiPasien->tipe_pembelajaran = $tipe_pembelajaran;
            $edukasiPasien->hambatan_komunikasi = $hambatan_komunikasi;
            $edukasiPasien->save();

            $pemahaman_awal_1 = null;
            if ($request->has('pemahaman_awal_1') && is_array($request->pemahaman_awal_1)) {
                $pemahaman_awal_1 = json_encode($request->pemahaman_awal_1);
            }
            $metode_1 = null;
            if ($request->has('metode_1') && is_array($request->metode_1)) {
                $metode_1 = json_encode($request->metode_1);
            }
            $media_1 = null;
            if ($request->has('media_1') && is_array($request->media_1)) {
                $media_1 = json_encode($request->media_1);
            }
            $evaluasi_1 = null;
            if ($request->has('evaluasi_1') && is_array($request->evaluasi_1)) {
                $evaluasi_1 = json_encode($request->evaluasi_1);
            }

            $pemahaman_awal_2 = null;
            if ($request->has('pemahaman_awal_2') && is_array($request->pemahaman_awal_2)) {
                $pemahaman_awal_2 = json_encode($request->pemahaman_awal_2);
            }
            $metode_2 = null;
            if ($request->has('metode_2') && is_array($request->metode_2)) {
                $metode_2 = json_encode($request->metode_2);
            }
            $media_2 = null;
            if ($request->has('media_2') && is_array($request->media_2)) {
                $media_2 = json_encode($request->media_2);
            }
            $evaluasi_2 = null;
            if ($request->has('evaluasi_2') && is_array($request->evaluasi_2)) {
                $evaluasi_2 = json_encode($request->evaluasi_2);
            }

            $pemahaman_awal_3 = null;
            if ($request->has('pemahaman_awal_3') && is_array($request->pemahaman_awal_3)) {
                $pemahaman_awal_3 = json_encode($request->pemahaman_awal_3);
            }
            $metode_3 = null;
            if ($request->has('metode_3') && is_array($request->metode_3)) {
                $metode_3 = json_encode($request->metode_3);
            }
            $media_3 = null;
            if ($request->has('media_3') && is_array($request->media_3)) {
                $media_3 = json_encode($request->media_3);
            }
            $evaluasi_3 = null;
            if ($request->has('evaluasi_3') && is_array($request->evaluasi_3)) {
                $evaluasi_3 = json_encode($request->evaluasi_3);
            }

            $pemahaman_awal_4 = null;
            if ($request->has('pemahaman_awal_4') && is_array($request->pemahaman_awal_4)) {
                $pemahaman_awal_4 = json_encode($request->pemahaman_awal_4);
            }
            $metode_4 = null;
            if ($request->has('metode_4') && is_array($request->metode_4)) {
                $metode_4 = json_encode($request->metode_4);
            }
            $media_4 = null;
            if ($request->has('media_4') && is_array($request->media_4)) {
                $media_4 = json_encode($request->media_4);
            }
            $evaluasi_4 = null;
            if ($request->has('evaluasi_4') && is_array($request->evaluasi_4)) {
                $evaluasi_4 = json_encode($request->evaluasi_4);
            }

            $pemahaman_awal_5 = null;
            if ($request->has('pemahaman_awal_5') && is_array($request->pemahaman_awal_5)) {
                $pemahaman_awal_5 = json_encode($request->pemahaman_awal_5);
            }
            $metode_5 = null;
            if ($request->has('metode_5') && is_array($request->metode_5)) {
                $metode_5 = json_encode($request->metode_5);
            }
            $media_5 = null;
            if ($request->has('media_5') && is_array($request->media_5)) {
                $media_5 = json_encode($request->media_5);
            }
            $evaluasi_5 = null;
            if ($request->has('evaluasi_5') && is_array($request->evaluasi_5)) {
                $evaluasi_5 = json_encode($request->evaluasi_5);
            }

            $pemahaman_awal_6 = null;
            if ($request->has('pemahaman_awal_6') && is_array($request->pemahaman_awal_6)) {
                $pemahaman_awal_6 = json_encode($request->pemahaman_awal_6);
            }
            $metode_6 = null;
            if ($request->has('metode_6') && is_array($request->metode_6)) {
                $metode_6 = json_encode($request->metode_6);
            }
            $media_6 = null;
            if ($request->has('media_6') && is_array($request->media_6)) {
                $media_6 = json_encode($request->media_6);
            }
            $evaluasi_6 = null;
            if ($request->has('evaluasi_6') && is_array($request->evaluasi_6)) {
                $evaluasi_6 = json_encode($request->evaluasi_6);
            }

            $KebutuhanEdukasi = EdukasiKebutuhanEdukasi::firstOrNew(['id_edukasi' => $edukasi->id]);
            $KebutuhanEdukasi->id_edukasi = $edukasi->id;
            $KebutuhanEdukasi->tanggal_1 = $request->tanggal_1;
            $KebutuhanEdukasi->ket_Kondisi_medis_1 = $request->ket_Kondisi_medis_1;
            $KebutuhanEdukasi->sasaran_nama_1 = $request->sasaran_nama_1;
            $KebutuhanEdukasi->edukator_nama_1 = $request->edukator_nama_1;
            $KebutuhanEdukasi->pemahaman_awal_1 = $pemahaman_awal_1;
            $KebutuhanEdukasi->metode_1 = $metode_1;
            $KebutuhanEdukasi->media_1 = $media_1;
            $KebutuhanEdukasi->evaluasi_1 = $evaluasi_1;
            $KebutuhanEdukasi->lama_edukasi_1 = $request->lama_edukasi_1;

            $KebutuhanEdukasi->tanggal_2 = $request->tanggal_2;
            $KebutuhanEdukasi->sasaran_nama_2 = $request->sasaran_nama_2;
            $KebutuhanEdukasi->edukator_nama_2 = $request->edukator_nama_2;
            $KebutuhanEdukasi->pemahaman_awal_2 = $pemahaman_awal_2;
            $KebutuhanEdukasi->metode_2 = $metode_2;
            $KebutuhanEdukasi->media_2 = $media_2;
            $KebutuhanEdukasi->evaluasi_2 = $evaluasi_2;
            $KebutuhanEdukasi->lama_edukasi_2 = $request->lama_edukasi_2;

            $KebutuhanEdukasi->tanggal_3 = $request->tanggal_3;
            $KebutuhanEdukasi->sasaran_nama_3 = $request->sasaran_nama_3;
            $KebutuhanEdukasi->edukator_nama_3 = $request->edukator_nama_3;
            $KebutuhanEdukasi->pemahaman_awal_3 = $pemahaman_awal_3;
            $KebutuhanEdukasi->metode_3 = $metode_3;
            $KebutuhanEdukasi->media_3 = $media_3;
            $KebutuhanEdukasi->evaluasi_3 = $evaluasi_3;
            $KebutuhanEdukasi->lama_edukasi_3 = $request->lama_edukasi_3;

            $KebutuhanEdukasi->tanggal_4 = $request->tanggal_4;
            $KebutuhanEdukasi->ket_program_4 = $request->ket_program_4;
            $KebutuhanEdukasi->sasaran_nama_4 = $request->sasaran_nama_4;
            $KebutuhanEdukasi->edukator_nama_4 = $request->edukator_nama_4;
            $KebutuhanEdukasi->pemahaman_awal_4 = $pemahaman_awal_4;
            $KebutuhanEdukasi->metode_4 = $metode_4;
            $KebutuhanEdukasi->media_4 = $media_4;
            $KebutuhanEdukasi->evaluasi_4 = $evaluasi_4;
            $KebutuhanEdukasi->lama_edukasi_4 = $request->lama_edukasi_4;

            $KebutuhanEdukasi->tanggal_5 = $request->tanggal_5;
            $KebutuhanEdukasi->sasaran_nama_5 = $request->sasaran_nama_5;
            $KebutuhanEdukasi->edukator_nama_5 = $request->edukator_nama_5;
            $KebutuhanEdukasi->pemahaman_awal_5 = $pemahaman_awal_5;
            $KebutuhanEdukasi->metode_5 = $metode_5;
            $KebutuhanEdukasi->media_5 = $media_5;
            $KebutuhanEdukasi->evaluasi_5 = $evaluasi_5;
            $KebutuhanEdukasi->lama_edukasi_5 = $request->lama_edukasi_5;

            $KebutuhanEdukasi->tanggal_6 = $request->tanggal_6;
            $KebutuhanEdukasi->sasaran_nama_6 = $request->sasaran_nama_6;
            $KebutuhanEdukasi->edukator_nama_6 = $request->edukator_nama_6;
            $KebutuhanEdukasi->pemahaman_awal_6 = $pemahaman_awal_6;
            $KebutuhanEdukasi->metode_6 = $metode_6;
            $KebutuhanEdukasi->media_6 = $media_6;
            $KebutuhanEdukasi->evaluasi_6 = $evaluasi_6;
            $KebutuhanEdukasi->lama_edukasi_6 = $request->lama_edukasi_6;
            $KebutuhanEdukasi->save();

            $pemahaman_awal_7 = null;
            if ($request->has('pemahaman_awal_7') && is_array($request->pemahaman_awal_7)) {
                $pemahaman_awal_7 = json_encode($request->pemahaman_awal_7);
            }
            $metode_7 = null;
            if ($request->has('metode_7') && is_array($request->metode_7)) {
                $metode_7 = json_encode($request->metode_7);
            }
            $media_7 = null;
            if ($request->has('media_7') && is_array($request->media_7)) {
                $media_7 = json_encode($request->media_7);
            }
            $evaluasi_7 = null;
            if ($request->has('evaluasi_7') && is_array($request->evaluasi_7)) {
                $evaluasi_7 = json_encode($request->evaluasi_7);
            }

            $pemahaman_awal_8 = null;
            if ($request->has('pemahaman_awal_8') && is_array($request->pemahaman_awal_8)) {
                $pemahaman_awal_8 = json_encode($request->pemahaman_awal_8);
            }
            $metode_8 = null;
            if ($request->has('metode_8') && is_array($request->metode_8)) {
                $metode_8 = json_encode($request->metode_8);
            }
            $media_8 = null;
            if ($request->has('media_8') && is_array($request->media_8)) {
                $media_8 = json_encode($request->media_8);
            }
            $evaluasi_8 = null;
            if ($request->has('evaluasi_8') && is_array($request->evaluasi_8)) {
                $evaluasi_8 = json_encode($request->evaluasi_8);
            }

            $pemahaman_awal_9 = null;
            if ($request->has('pemahaman_awal_9') && is_array($request->pemahaman_awal_9)) {
                $pemahaman_awal_9 = json_encode($request->pemahaman_awal_9);
            }
            $metode_9 = null;
            if ($request->has('metode_9') && is_array($request->metode_9)) {
                $metode_9 = json_encode($request->metode_9);
            }
            $media_9 = null;
            if ($request->has('media_9') && is_array($request->media_9)) {
                $media_9 = json_encode($request->media_9);
            }
            $evaluasi_9 = null;
            if ($request->has('evaluasi_9') && is_array($request->evaluasi_9)) {
                $evaluasi_9 = json_encode($request->evaluasi_9);
            }

            $pemahaman_awal_10 = null;
            if ($request->has('pemahaman_awal_10') && is_array($request->pemahaman_awal_10)) {
                $pemahaman_awal_10 = json_encode($request->pemahaman_awal_10);
            }
            $metode_10 = null;
            if ($request->has('metode_10') && is_array($request->metode_10)) {
                $metode_10 = json_encode($request->metode_10);
            }
            $media_10 = null;
            if ($request->has('media_10') && is_array($request->media_10)) {
                $media_10 = json_encode($request->media_10);
            }
            $evaluasi_10 = null;
            if ($request->has('evaluasi_10') && is_array($request->evaluasi_10)) {
                $evaluasi_10 = json_encode($request->evaluasi_10);
            }

            $pemahaman_awal_11 = null;
            if ($request->has('pemahaman_awal_11') && is_array($request->pemahaman_awal_11)) {
                $pemahaman_awal_11 = json_encode($request->pemahaman_awal_11);
            }
            $metode_11 = null;
            if ($request->has('metode_11') && is_array($request->metode_11)) {
                $metode_11 = json_encode($request->metode_11);
            }
            $media_11 = null;
            if ($request->has('media_11') && is_array($request->media_11)) {
                $media_11 = json_encode($request->media_11);
            }
            $evaluasi_11 = null;
            if ($request->has('evaluasi_11') && is_array($request->evaluasi_11)) {
                $evaluasi_11 = json_encode($request->evaluasi_11);
            }

            $pemahaman_awal_12 = null;
            if ($request->has('pemahaman_awal_12') && is_array($request->pemahaman_awal_12)) {
                $pemahaman_awal_12 = json_encode($request->pemahaman_awal_12);
            }
            $metode_12 = null;
            if ($request->has('metode_12') && is_array($request->metode_12)) {
                $metode_12 = json_encode($request->metode_12);
            }
            $media_12 = null;
            if ($request->has('media_12') && is_array($request->media_12)) {
                $media_12 = json_encode($request->media_12);
            }
            $evaluasi_12 = null;
            if ($request->has('evaluasi_12') && is_array($request->evaluasi_12)) {
                $evaluasi_12 = json_encode($request->evaluasi_12);
            }

            $pemahaman_awal_13 = null;
            if ($request->has('pemahaman_awal_13') && is_array($request->pemahaman_awal_13)) {
                $pemahaman_awal_13 = json_encode($request->pemahaman_awal_13);
            }
            $metode_13 = null;
            if ($request->has('metode_13') && is_array($request->metode_13)) {
                $metode_13 = json_encode($request->metode_13);
            }
            $media_13 = null;
            if ($request->has('media_13') && is_array($request->media_13)) {
                $media_13 = json_encode($request->media_13);
            }
            $evaluasi_13 = null;
            if ($request->has('evaluasi_13') && is_array($request->evaluasi_13)) {
                $evaluasi_13 = json_encode($request->evaluasi_13);
            }

            $pemahaman_awal_14 = null;
            if ($request->has('pemahaman_awal_14') && is_array($request->pemahaman_awal_14)) {
                $pemahaman_awal_14 = json_encode($request->pemahaman_awal_14);
            }
            $metode_14 = null;
            if ($request->has('metode_14') && is_array($request->metode_14)) {
                $metode_14 = json_encode($request->metode_14);
            }
            $media_14 = null;
            if ($request->has('media_14') && is_array($request->media_14)) {
                $media_14 = json_encode($request->media_14);
            }
            $evaluasi_14 = null;
            if ($request->has('evaluasi_14') && is_array($request->evaluasi_14)) {
                $evaluasi_14 = json_encode($request->evaluasi_14);
            }
            $pemahaman_awal_15 = null;
            if ($request->has('pemahaman_awal_15') && is_array($request->pemahaman_awal_15)) {
                $pemahaman_awal_15 = json_encode($request->pemahaman_awal_15);
            }
            $metode_15 = null;
            if ($request->has('metode_15') && is_array($request->metode_15)) {
                $metode_15 = json_encode($request->metode_15);
            }
            $media_15 = null;
            if ($request->has('media_15') && is_array($request->media_15)) {
                $media_15 = json_encode($request->media_15);
            }
            $evaluasi_15 = null;
            if ($request->has('evaluasi_15') && is_array($request->evaluasi_15)) {
                $evaluasi_15 = json_encode($request->evaluasi_15);
            }

            $pemahaman_awal_16 = null;
            if ($request->has('pemahaman_awal_16') && is_array($request->pemahaman_awal_16)) {
                $pemahaman_awal_16 = json_encode($request->pemahaman_awal_16);
            }
            $metode_16 = null;
            if ($request->has('metode_16') && is_array($request->metode_16)) {
                $metode_16 = json_encode($request->metode_16);
            }
            $media_16 = null;
            if ($request->has('media_16') && is_array($request->media_16)) {
                $media_16 = json_encode($request->media_16);
            }
            $evaluasi_16 = null;
            if ($request->has('evaluasi_16') && is_array($request->evaluasi_16)) {
                $evaluasi_16 = json_encode($request->evaluasi_16);
            }

            $KebutuhanEdukasiLanjutan = EdukasiKebutuhanEdukasiLanjutan::firstOrNew(['id_edukasi' => $edukasi->id]);
            $KebutuhanEdukasiLanjutan->id_edukasi = $edukasi->id;
            $KebutuhanEdukasiLanjutan->tanggal_7 = $request->tanggal_7;
            $KebutuhanEdukasiLanjutan->sasaran_nama_7 = $request->sasaran_nama_7;
            $KebutuhanEdukasiLanjutan->edukator_nama_7 = $request->edukator_nama_7;
            $KebutuhanEdukasiLanjutan->pemahaman_awal_7 = $pemahaman_awal_7;
            $KebutuhanEdukasiLanjutan->metode_7 = $metode_7;
            $KebutuhanEdukasiLanjutan->media_7 = $media_7;
            $KebutuhanEdukasiLanjutan->evaluasi_7 = $evaluasi_7;
            $KebutuhanEdukasiLanjutan->lama_edukasi_7 = $request->lama_edukasi_7;

            $KebutuhanEdukasiLanjutan->tanggal_8 = $request->tanggal_8;
            $KebutuhanEdukasiLanjutan->sasaran_nama_8 = $request->sasaran_nama_8;
            $KebutuhanEdukasiLanjutan->edukator_nama_8 = $request->edukator_nama_8;
            $KebutuhanEdukasiLanjutan->pemahaman_awal_8 = $pemahaman_awal_8;
            $KebutuhanEdukasiLanjutan->metode_8 = $metode_8;
            $KebutuhanEdukasiLanjutan->media_8 = $media_8;
            $KebutuhanEdukasiLanjutan->evaluasi_8 = $evaluasi_8;
            $KebutuhanEdukasiLanjutan->lama_edukasi_8 = $request->lama_edukasi_8;

            $KebutuhanEdukasiLanjutan->tanggal_9 = $request->tanggal_9;
            $KebutuhanEdukasiLanjutan->ket_teknik_rehabilitasi_9 = $request->ket_teknik_rehabilitasi_9;
            $KebutuhanEdukasiLanjutan->teknik_rehabilitasi_9 = $request->teknik_rehabilitasi_9;
            $KebutuhanEdukasiLanjutan->sasaran_nama_9 = $request->sasaran_nama_9;
            $KebutuhanEdukasiLanjutan->edukator_nama_9 = $request->edukator_nama_9;
            $KebutuhanEdukasiLanjutan->pemahaman_awal_9 = $pemahaman_awal_9;
            $KebutuhanEdukasiLanjutan->metode_9 = $metode_9;
            $KebutuhanEdukasiLanjutan->media_9 = $media_9;
            $KebutuhanEdukasiLanjutan->evaluasi_9 = $evaluasi_9;
            $KebutuhanEdukasiLanjutan->lama_edukasi_9 = $request->lama_edukasi_9;

            $KebutuhanEdukasiLanjutan->tanggal_10 = $request->tanggal_10;
            $KebutuhanEdukasiLanjutan->sasaran_nama_10 = $request->sasaran_nama_10;
            $KebutuhanEdukasiLanjutan->edukator_nama_10 = $request->edukator_nama_10;
            $KebutuhanEdukasiLanjutan->pemahaman_awal_10 = $pemahaman_awal_10;
            $KebutuhanEdukasiLanjutan->metode_10 = $metode_10;
            $KebutuhanEdukasiLanjutan->media_10 = $media_10;
            $KebutuhanEdukasiLanjutan->evaluasi_10 = $evaluasi_10;
            $KebutuhanEdukasiLanjutan->lama_edukasi_10 = $request->lama_edukasi_10;

            $KebutuhanEdukasiLanjutan->tanggal_11 = $request->tanggal_11;
            $KebutuhanEdukasiLanjutan->sasaran_nama_11 = $request->sasaran_nama_11;
            $KebutuhanEdukasiLanjutan->edukator_nama_11 = $request->edukator_nama_11;
            $KebutuhanEdukasiLanjutan->pemahaman_awal_11 = $pemahaman_awal_11;
            $KebutuhanEdukasiLanjutan->metode_11 = $metode_11;
            $KebutuhanEdukasiLanjutan->media_11 = $media_11;
            $KebutuhanEdukasiLanjutan->evaluasi_11 = $evaluasi_11;
            $KebutuhanEdukasiLanjutan->lama_edukasi_11 = $request->lama_edukasi_11;

            $KebutuhanEdukasiLanjutan->tanggal_12 = $request->tanggal_12;
            $KebutuhanEdukasiLanjutan->sasaran_nama_12 = $request->sasaran_nama_12;
            $KebutuhanEdukasiLanjutan->edukator_nama_12 = $request->edukator_nama_12;
            $KebutuhanEdukasiLanjutan->pemahaman_awal_12 = $pemahaman_awal_12;
            $KebutuhanEdukasiLanjutan->metode_12 = $metode_12;
            $KebutuhanEdukasiLanjutan->media_12 = $media_12;
            $KebutuhanEdukasiLanjutan->evaluasi_12 = $evaluasi_12;
            $KebutuhanEdukasiLanjutan->lama_edukasi_12 = $request->lama_edukasi_12;

            $KebutuhanEdukasiLanjutan->tanggal_13 = $request->tanggal_13;
            $KebutuhanEdukasiLanjutan->sasaran_nama_13 = $request->sasaran_nama_13;
            $KebutuhanEdukasiLanjutan->edukator_nama_13 = $request->edukator_nama_13;
            $KebutuhanEdukasiLanjutan->pemahaman_awal_13 = $pemahaman_awal_13;
            $KebutuhanEdukasiLanjutan->metode_13 = $metode_13;
            $KebutuhanEdukasiLanjutan->media_13 = $media_13;
            $KebutuhanEdukasiLanjutan->evaluasi_13 = $evaluasi_13;
            $KebutuhanEdukasiLanjutan->lama_edukasi_13 = $request->lama_edukasi_13;

            $KebutuhanEdukasiLanjutan->tanggal_14 = $request->tanggal_14;
            $KebutuhanEdukasiLanjutan->ket_hambatan_14 = $request->ket_hambatan_14;
            $KebutuhanEdukasiLanjutan->sasaran_nama_14 = $request->sasaran_nama_14;
            $KebutuhanEdukasiLanjutan->edukator_nama_14 = $request->edukator_nama_14;
            $KebutuhanEdukasiLanjutan->pemahaman_awal_14 = $pemahaman_awal_14;
            $KebutuhanEdukasiLanjutan->metode_14 = $metode_14;
            $KebutuhanEdukasiLanjutan->media_14 = $media_14;
            $KebutuhanEdukasiLanjutan->evaluasi_14 = $evaluasi_14;
            $KebutuhanEdukasiLanjutan->lama_edukasi_14 = $request->lama_edukasi_14;

            $KebutuhanEdukasiLanjutan->tanggal_15 = $request->tanggal_15;
            $KebutuhanEdukasiLanjutan->ket_pertanyaan_15 = $request->ket_pertanyaan_15;
            $KebutuhanEdukasiLanjutan->sasaran_nama_15 = $request->sasaran_nama_15;
            $KebutuhanEdukasiLanjutan->edukator_nama_15 = $request->edukator_nama_15;
            $KebutuhanEdukasiLanjutan->pemahaman_awal_15 = $pemahaman_awal_15;
            $KebutuhanEdukasiLanjutan->metode_15 = $metode_15;
            $KebutuhanEdukasiLanjutan->media_15 = $media_15;
            $KebutuhanEdukasiLanjutan->evaluasi_15 = $evaluasi_15;
            $KebutuhanEdukasiLanjutan->lama_edukasi_15 = $request->lama_edukasi_15;

            $KebutuhanEdukasiLanjutan->tanggal_16 = $request->tanggal_16;
            $KebutuhanEdukasiLanjutan->ket_preferensi_16 = $request->ket_preferensi_16;
            $KebutuhanEdukasiLanjutan->sasaran_nama_16 = $request->sasaran_nama_16;
            $KebutuhanEdukasiLanjutan->edukator_nama_16 = $request->edukator_nama_16;
            $KebutuhanEdukasiLanjutan->pemahaman_awal_16 = $pemahaman_awal_16;
            $KebutuhanEdukasiLanjutan->metode_16 = $metode_16;
            $KebutuhanEdukasiLanjutan->media_16 = $media_16;
            $KebutuhanEdukasiLanjutan->evaluasi_16 = $evaluasi_16;
            $KebutuhanEdukasiLanjutan->lama_edukasi_16 = $request->lama_edukasi_16;
            $KebutuhanEdukasiLanjutan->save();

            DB::commit();

            return redirect()->route('rawat-inap.edukasi.index', [
                $kd_unit,
                $kd_pasien,
                $tgl_masuk,
                $request->urut_masuk,
            ])->with(['success' => 'Berhasil update data Edukasi !']);
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();
        try {
            // Verify Kunjungan exists
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
                return redirect()->route('rawat-inap.edukasi.index', [
                    'kd_unit' => $kd_unit,
                    'kd_pasien' => $kd_pasien,
                    'tgl_masuk' => $tgl_masuk,
                    'urut_masuk' => $urut_masuk,
                ])->with('error', 'Data kunjungan tidak ditemukan.');
            }

            // Find Edukasi
            $edukasi = Edukasi::findOrFail($id);

            // Delete related records
            EdukasiPasien::where('id_edukasi', $edukasi->id)->delete();
            EdukasiKebutuhanEdukasi::where('id_edukasi', $edukasi->id)->delete();
            EdukasiKebutuhanEdukasiLanjutan::where('id_edukasi', $edukasi->id)->delete();

            // Delete Edukasi
            $edukasi->delete();

            DB::commit();
            return redirect()->route('rawat-inap.edukasi.index', [
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
            ])->with('success', 'Data edukasi berhasil dihapus!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->route('rawat-inap.edukasi.index', [
                'kd_unit' => $kd_unit,
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
            ])->with('error', 'Data edukasi tidak ditemukan.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('rawat-inap.edukasi.index', [
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
            ])->with('error', 'Terjadi kesalahan saat menghapus data. Silakan coba lagi.');
        }
    }
}
