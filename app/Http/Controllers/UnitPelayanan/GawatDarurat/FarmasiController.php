<?php

namespace App\Http\Controllers\UnitPelayanan\GawatDarurat;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class FarmasiController extends Controller
{
    public function index($kd_pasien)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'aptBarangOuts'])
        ->where('kd_pasien', $kd_pasien)
            ->first();

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        // Ambil data riwayat pemberian obat
        $riwayatObat = $dataMedis->aptBarangOuts()->select('KD_PASIENAPT', 'NO_RESEP', 'DOKTER', 'JML_ITEM', 'RESEP', 'TGL_OUT')->get();

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.farmasi.index', compact('dataMedis', 'riwayatObat'));
    }
}
