<?php

namespace App\Http\Controllers\UnitPelayanan\GawatDarurat;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\MrResep;
use App\Models\SegalaOrder;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class ResumeController extends Controller
{
    public function index($kd_pasien, $tgl_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien.golonganDarah', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();

        $dataDokter = Dokter::all();
        // Hasil Pemeriksaan Laboratorium
        $dataLabor = SegalaOrder::with(['details.produk'])
            ->where('kd_pasien', $kd_pasien)
            ->whereHas('details', function ($query) {
                $query->where('status_order', 1);
            })
            ->orderBy('tgl_order', 'desc')   // Urutkan dari yang terbaru
            ->get();

        // Hasil Pemeriksaan Radiologi
        $dataRagiologi = SegalaOrder::with(['details.produk'])
            ->where('kd_pasien', $kd_pasien)
            ->whereHas('details', function ($query) {
                $query->where('status_order', 1);
            })
            ->orderBy('tgl_order', 'desc')   // Urutkan dari yang terbaru
            ->get();

        // Resep Obat
        // $dataResepObat = MrResep::with(['detailResep.aptObat'])
        // ->orderBy('tgl_order', 'desc')
        // ->get();

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        return view(
            'unit-pelayanan.gawat-darurat.action-gawat-darurat.resume.index',
            compact(
                'dataMedis',
                'dataDokter',
                'dataLabor',
                'dataRagiologi'
            )
        );
    }
}
