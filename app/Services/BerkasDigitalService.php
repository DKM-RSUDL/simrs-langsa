<?php

namespace App\Services;

use App\Models\RmeAsesmen;
use App\Models\DataTriase;

class BerkasDigitalService
{
    public function getAsesmenData($dataMedis)
    {
        // Ambil data asesmen IGD
        $asesmen = RmeAsesmen::with('user')
            ->where('kd_pasien', $dataMedis->kd_pasien)
            ->whereDate('tgl_masuk', date('Y-m-d', strtotime($dataMedis->tgl_masuk)))
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->orderBy('waktu_asesmen', 'desc') // Ambil yang terbaru
            ->first();

        // Ambil data triase jika ada
        $triase = null;
        if ($asesmen) {
            $triase = DataTriase::where('id_asesmen', $asesmen->id)->first();
        }

        // Riwayat alergi
        $riwayatAlergi = isset($dataMedis->riwayat_alergi) ? $dataMedis->riwayat_alergi : [];

        return compact('asesmen', 'triase', 'riwayatAlergi');
    }
}
