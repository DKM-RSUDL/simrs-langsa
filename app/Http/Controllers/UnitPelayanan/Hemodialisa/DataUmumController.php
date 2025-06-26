<?php

namespace App\Http\Controllers\UnitPelayanan\Hemodialisa;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\RmeAlergiPasien;
use App\Models\RmeHdDataUmum;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DataUmumController extends Controller
{
    private $kdUnitDef_;

    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/hemodialisa');
        $this->kdUnitDef_ = 72;
    }

    public function index($kd_pasien, $tgl_masuk, $urut_masuk)
    {
        // Mengambil data kunjungan dan tanggal triase terkait
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_unit', $this->kdUnitDef_)
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

        $dataUmum = RmeHdDataUmum::with(['userCreate'])
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $this->kdUnitDef_)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->get();

        return view('unit-pelayanan.hemodialisa.pelayanan.data-umum.index', compact(
            'dataMedis',
            'dataUmum'
        ));
    }


    public function create($kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_unit', $this->kdUnitDef_)
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

        $dokter = Dokter::where('status', 1)->get();
        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();

        return view('unit-pelayanan.hemodialisa.pelayanan.data-umum.create', compact(
            'dataMedis',
            'dokter',
            'alergiPasien'
        ));
    }

    public function store($kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_unit', $this->kdUnitDef_)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        DB::beginTransaction();

        try {
            // store data umum
            $data = [
                'kd_pasien'     => $kd_pasien,
                'kd_unit'     => $this->kdUnitDef_,
                'tgl_masuk'     => $tgl_masuk,
                'urut_masuk'     => $urut_masuk,
                'pasien_no_telpon'      => $request->pasien_no_telpon,
                'pj_nama'      => $request->pj_nama,
                'pj_hubungan_keluarga'      => $request->pj_hubungan_keluarga,
                'pj_alamat'      => $request->pj_alamat,
                'pj_pekerjaan'      => $request->pj_pekerjaan,
                'hd_pertama_kali'      => date('Y-m-d', strtotime($request->hd_pertama_kali)),
                'mulai_hd_rutin'      => date('Y-m-d', strtotime($request->mulai_hd_rutin)),
                'frekuensi_hd'      => $request->frekuensi_hd,
                'status_pembayaran'      => $request->status_pembayaran,
                'dokter_pengirim'      => $request->dokter_pengirim,
                'asal_rujukan'      => $request->asal_rujukan,
                'diagnosis'      => $request->diagnosis,
                'etiologi'      => $request->etiologi,
                'penyakit_penyerta'      => $request->penyakit_penyerta,
                'user_create'       => Auth::id(),
                'created_at'        => date('Y-m-d H:i:s')
            ];

            RmeHdDataUmum::create($data);

            // store alergi
            $jenis_alergi = $request->jenis_alergi ?? [];
            $nama_alergi = $request->nama_alergi ?? [];
            $reaksi = $request->reaksi ?? [];
            $tingkat_keparahan = $request->tingkat_keparahan ?? [];

            RmeAlergiPasien::where('kd_pasien', $kd_pasien)->delete();

            for ($i = 0; $i < count($jenis_alergi); $i++) {
                $dataAlergi = [
                    'kd_pasien'     => $kd_pasien,
                    'jenis_alergi'     => $jenis_alergi[$i],
                    'nama_alergi'     => $nama_alergi[$i],
                    'reaksi'     => $reaksi[$i],
                    'tingkat_keparahan'     => $tingkat_keparahan[$i],
                ];

                RmeAlergiPasien::create($dataAlergi);
            }

            DB::commit();
            return to_route('hemodialisa.pelayanan.data-umum.index', [$kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'Data umum pasien berhasil ditambah !');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit($kd_pasien, $tgl_masuk, $urut_masuk, $idEncrypt)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_unit', $this->kdUnitDef_)
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

        $id = decrypt($idEncrypt);
        $dataUmum = RmeHdDataUmum::find($id);

        if (empty($dataUmum)) abort(404, 'Data not found');

        $dokter = Dokter::where('status', 1)->get();
        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();

        return view('unit-pelayanan.hemodialisa.pelayanan.data-umum.edit', compact(
            'dataMedis',
            'dokter',
            'alergiPasien',
            'dataUmum'
        ));
    }

    public function update($kd_pasien, $tgl_masuk, $urut_masuk, $idEncrypt, Request $request)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_unit', $this->kdUnitDef_)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        DB::beginTransaction();

        try {
            $id = decrypt($idEncrypt);
            $dataUmum = RmeHdDataUmum::find($id);

            if (empty($dataUmum)) abort(404, 'Data not found');

            // store data umum
            $data = [
                'pasien_no_telpon'      => $request->pasien_no_telpon,
                'pj_nama'      => $request->pj_nama,
                'pj_hubungan_keluarga'      => $request->pj_hubungan_keluarga,
                'pj_alamat'      => $request->pj_alamat,
                'pj_pekerjaan'      => $request->pj_pekerjaan,
                'hd_pertama_kali'      => date('Y-m-d', strtotime($request->hd_pertama_kali)),
                'mulai_hd_rutin'      => date('Y-m-d', strtotime($request->mulai_hd_rutin)),
                'frekuensi_hd'      => $request->frekuensi_hd,
                'status_pembayaran'      => $request->status_pembayaran,
                'dokter_pengirim'      => $request->dokter_pengirim,
                'asal_rujukan'      => $request->asal_rujukan,
                'diagnosis'      => $request->diagnosis,
                'etiologi'      => $request->etiologi,
                'penyakit_penyerta'      => $request->penyakit_penyerta,
                'user_edit'       => Auth::id(),
                'updated_at'        => date('Y-m-d H:i:s')
            ];

            RmeHdDataUmum::where('id', $dataUmum->id)->update($data);

            // store alergi
            $jenis_alergi = $request->jenis_alergi ?? [];
            $nama_alergi = $request->nama_alergi ?? [];
            $reaksi = $request->reaksi ?? [];
            $tingkat_keparahan = $request->tingkat_keparahan ?? [];

            RmeAlergiPasien::where('kd_pasien', $kd_pasien)->delete();

            for ($i = 0; $i < count($jenis_alergi); $i++) {
                $dataAlergi = [
                    'kd_pasien'     => $kd_pasien,
                    'jenis_alergi'     => $jenis_alergi[$i],
                    'nama_alergi'     => $nama_alergi[$i],
                    'reaksi'     => $reaksi[$i],
                    'tingkat_keparahan'     => $tingkat_keparahan[$i],
                ];

                RmeAlergiPasien::create($dataAlergi);
            }

            DB::commit();
            return to_route('hemodialisa.pelayanan.data-umum.index', [$kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'Data umum pasien berhasil diubah !');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function show($kd_pasien, $tgl_masuk, $urut_masuk, $idEncrypt)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_unit', $this->kdUnitDef_)
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

        $id = decrypt($idEncrypt);
        $dataUmum = RmeHdDataUmum::find($id);

        if (empty($dataUmum)) abort(404, 'Data not found');

        $dokter = Dokter::where('status', 1)->get();
        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();

        return view('unit-pelayanan.hemodialisa.pelayanan.data-umum.show', compact(
            'dataMedis',
            'dokter',
            'alergiPasien',
            'dataUmum'
        ));
    }

    public function delete($kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_unit', $this->kdUnitDef_)
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

        $id = decrypt($request->data_umum);
        $dataUmum = RmeHdDataUmum::find($id);

        if (empty($dataUmum)) abort(404, 'Data not found');

        DB::beginTransaction();

        try {
            $dataUmum->delete();

            DB::commit();
            return to_route('hemodialisa.pelayanan.data-umum.index', [$kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'Data umum pasien berhasil dihapus !');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
