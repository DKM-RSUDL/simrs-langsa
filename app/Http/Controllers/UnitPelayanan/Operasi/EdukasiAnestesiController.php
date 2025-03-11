<?php

namespace App\Http\Controllers\UnitPelayanan\Operasi;

use App\Http\Controllers\Controller;
use App\Models\DokterAnastesi;
use App\Models\Kunjungan;
use App\Models\OkAsesmen;
use App\Models\OkEdukasiAnestesi;
use App\Models\OkJenisAnastesi;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EdukasiAnestesiController extends Controller
{
    public function create($kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', 71)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();

        // Menghitung umur berdasarkan tgl_lahir jika ada
        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        $jenisAnastesi = OkJenisAnastesi::all();
        $dokterAnastesi = DokterAnastesi::all();

        return view('unit-pelayanan.operasi.pelayanan.asesmen.pra-anestesi.edukasi.create', compact('dataMedis', 'jenisAnastesi', 'dokterAnastesi'));
    }

    public function store($kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {

        DB::beginTransaction();

        try {

            $validator = Validator::make($request->all(), [
                'file_persetujuan'  => 'nullable|file|max:5120|mimes:png,jpg,jpeg,pdf'
            ]);

            if ($validator->fails()) {
                return back()->with('error', 'File Hardcopy tidak valid !');
            }

            // create asesmen
            $asesmen = new OkAsesmen();
            $asesmen->kd_pasien = $kd_pasien;
            $asesmen->kd_unit = 71;
            $asesmen->tgl_masuk = $tgl_masuk;
            $asesmen->urut_masuk = $urut_masuk;
            $asesmen->kategori = 3;
            $asesmen->waktu_asesmen = date('Y-m-d H:i:s');
            $asesmen->user_create = Auth::id();
            $asesmen->save();

            $data = [
                'id_asesmen'        => $asesmen->id,
                'tgl_op'            => $request->tgl_masuk,
                'jam_op'            => $request->jam_masuk,
                'jenis_anestesi'    => $request->jenis_anestesi,
                'edukasi_prosedur'  => $request->edukasi_prosedur,
                'pemahaman_pasien'  => $request->pemahaman_pasien,
                'informed_consent'  => $request->informed_consent,
                'nama_keluarga'  => $request->nama_keluarga,
                'usia_keluarga'  => $request->usia_keluarga,
                'jenis_kelamin'  => $request->jenis_kelamin,
                'no_telepon'  => $request->no_telepon,
                'dokter_edukasi'  => $request->dokter_edukasi,
                'tgl_dilakukan'  => $request->tgl_dilakukan,
                'jam_dilakukan'  => $request->jam_dilakukan,
                'pertanyaan_pasien'  => $request->pertanyaan_pasien,
                'rekomendasi_dokter'  => $request->rekomendasi_dokter,
                'lainnya'  => $request->lainnya,
            ];

            $path = '';

            if ($request->hasFile('file_persetujuan')) {
                $path = $request->file('file_persetujuan')->store("operasi/$kd_pasien/$tgl_masuk/$urut_masuk");
            }

            $data['file_persetujuan'] = $path;

            OkEdukasiAnestesi::create($data);

            DB::commit();
            return to_route('operasi.pelayanan.asesmen.index', [$kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'Edukasi Anestesi berhasil di tambah !');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', 71)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();

        // Menghitung umur berdasarkan tgl_lahir jika ada
        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        $asesmen = OkAsesmen::find($id);
        $jenisAnastesi = OkJenisAnastesi::all();
        $dokterAnastesi = DokterAnastesi::all();

        return view('unit-pelayanan.operasi.pelayanan.asesmen.pra-anestesi.edukasi.edit', compact('dataMedis', 'asesmen', 'jenisAnastesi', 'dokterAnastesi'));
    }
}