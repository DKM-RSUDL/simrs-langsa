<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\MrItemFisik;
use App\Models\RmeAsesmen;
use App\Models\RmeAsesmenThtDataMasuk;
use App\Models\RmeAsesmenThtPemeriksaanFisik;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class AsesmenKepThtController extends Controller
{
    public function index(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $user = auth()->user();
        $itemFisik = MrItemFisik::orderby('urut')->get();

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

        return view('unit-pelayanan.rawat-inap.pelayanan.asesmen-tht.create', compact(
            'kd_unit',
            'kd_pasien',
            'tgl_masuk',
            'urut_masuk',
            'dataMedis',
            'itemFisik',
            'user'
        ));
    }

    public function store(Request $request, $kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk)
    {
        // dd($request);
        $asesmenTht = new RmeAsesmen();
        $asesmenTht->kd_pasien = $request->kd_pasien;
        $asesmenTht->kd_unit = $request->kd_unit;
        $asesmenTht->tgl_masuk = $request->tgl_masuk;
        $asesmenTht->urut_masuk = $request->urut_masuk;
        $asesmenTht->user_id = Auth::id();
        $asesmenTht->waktu_asesmen = date('Y-m-d H:i:s');
        $asesmenTht->kategori = 1;
        $asesmenTht->sub_kategori = 5;
        $asesmenTht->save();

        $asesmenThtDataMasuk = new RmeAsesmenThtDataMasuk();
        $asesmenThtDataMasuk->id_asesmen = $asesmenTht->id;
        $asesmenThtDataMasuk->tgl_masuk = $request->tgl_masuk;
        $asesmenThtDataMasuk->kondisi_masuk = $request->kondisi_masuk;
        $asesmenThtDataMasuk->ruang = $request->ruang;
        $asesmenThtDataMasuk->anamnesis_anamnesis = $request->anamnesis_anamnesis;
        $asesmenThtDataMasuk->save();

        $asesmenThtPemeriksaanFisik = new RmeAsesmenThtPemeriksaanFisik();
        $asesmenThtPemeriksaanFisik->id_asesmen = $asesmenTht->id;
        $asesmenThtPemeriksaanFisik->darah_sistole = $request->darah_sistole;
        $asesmenThtPemeriksaanFisik->darah_diastole = $request->darah_diastole;
        $asesmenThtPemeriksaanFisik->nadi = $request->nadi;
        $asesmenThtPemeriksaanFisik->nafas = $request->nafas;
        $asesmenThtPemeriksaanFisik->suhu = $request->suhu;
        $asesmenThtPemeriksaanFisik->sensorium = $request->sensorium;
        $asesmenThtPemeriksaanFisik->ku_kp_kg = $request->ku_kp_kg;
        $asesmenThtPemeriksaanFisik->avpu = $request->avpu;
        $asesmenThtPemeriksaanFisik->save();

        // return redirect()->route('rawat-inap.asesmen.keperawatan.tht.index', [
        //     'kd_pasien' => $kd_pasien,
        //     'kd_unit' => $kd_unit,
        //     'tgl_masuk' => $tgl_masuk,
        //     'urut_masuk' => $urut_masuk
        // ])->with(['success' => 'Berhasil menambah asesmen keperawatan umum !']);
        return back()->with('success', 'Berhasil menambah asesmen keperawatan THT!');
    }
}
