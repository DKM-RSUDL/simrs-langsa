<?php

namespace App\Http\Controllers\UnitPelayanan\GawatDarurat;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\MrResep;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FarmasiController extends Controller
{
    public function index($kd_pasien, $tgl_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer'])
        ->where('kd_pasien', $kd_pasien)
            ->first();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        $riwayatObat = $this->getRiwayatObat($kd_pasien);

        return view(
            'unit-pelayanan.gawat-darurat.action-gawat-darurat.farmasi.index',
            compact('dataMedis', 'riwayatObat', 'kd_pasien', 'tgl_masuk')
        );
    }

    public function getModalData()
    {
        $dokters = Dokter::orderBy('NAMA', 'asc')->get();

        // Log::info('Jumlah dokter: ' . $dokters->count());
        // Log::info('Data dokter: ' . $dokters->toJson());

        return response()->json([
            'dokters' => $dokters,
            // Tambahkan data lain yang diperlukan untuk modal di sini
        ]);
    }

    private function getRiwayatObat($kd_pasien)
    {
        return DB::table('MR_RESEP')
            ->join('DOKTER', 'MR_RESEP.KD_DOKTER', '=', 'DOKTER.KD_DOKTER')
            ->leftJoin('MR_RESEPDTL', 'MR_RESEP.ID_MRRESEP', '=', 'MR_RESEPDTL.ID_MRRESEP')
            ->leftJoin('APT_OBAT', 'MR_RESEPDTL.KD_PRD', '=', 'APT_OBAT.KD_PRD')
            ->where('MR_RESEP.KD_PASIEN', $kd_pasien)
            ->select(
                'MR_RESEP.TGL_MASUK',
                'MR_RESEP.KD_DOKTER',
                'DOKTER.NAMA as NAMA_DOKTER',
                'MR_RESEP.ID_MRRESEP as ID_MRRESEP',
                'MR_RESEP.CAT_RACIKAN',
                'MR_RESEP.TGL_ORDER',
                'MR_RESEP.STATUS',
                'MR_RESEPDTL.CARA_PAKAI',
                'MR_RESEPDTL.JUMLAH',
                'APT_OBAT.NAMA_OBAT'
            )
            ->orderBy('MR_RESEP.TGL_MASUK', 'desc')
            ->get();
    }
}
