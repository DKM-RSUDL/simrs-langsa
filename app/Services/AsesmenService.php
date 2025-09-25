<?php

namespace App\Services;

use App\Models\Transaksi;
use App\Models\VitalSign;

class AsesmenService
{
    public function store($vitalSignData, $no_rm, $no_transaksi, $kd_kasir)
    {
        if (empty($vitalSignData)) {
            return;
        }

        $vitalSign = [
            // 'kd_kasir'         => $kd_kasir,
            // 'no_transaksi'     => $no_transaksi,
            'sistole' => isset($vitalSignData['sistole']) ? (int) $vitalSignData['sistole'] : null,
            'diastole' => isset($vitalSignData['diastole']) ? (int) $vitalSignData['diastole'] : null,
            'nadi' => isset($vitalSignData['nadi']) ? (int) $vitalSignData['nadi'] : null,
            'respiration' => isset($vitalSignData['respiration']) ? (int) $vitalSignData['respiration'] : null,
            'suhu' => isset($vitalSignData['suhu']) ? (float) $vitalSignData['suhu'] : null,
            'spo2_tanpa_o2' => isset($vitalSignData['spo2_tanpa_o2']) ? (int) $vitalSignData['spo2_tanpa_o2'] : null,
            'spo2_dengan_o2' => isset($vitalSignData['spo2_dengan_o2']) ? (int) $vitalSignData['spo2_dengan_o2'] : null,
            'tinggi_badan' => isset($vitalSignData['tinggi_badan']) ? (int) $vitalSignData['tinggi_badan'] : null,
            'berat_badan' => isset($vitalSignData['berat_badan']) ? (int) $vitalSignData['berat_badan'] : null,
        ];

        VitalSign::updateOrCreate(
            ['kd_kasir' => $kd_kasir,
                'no_transaksi' => $no_transaksi, ],
            $vitalSign);
    }

    public function getTransaksiData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $lastTransaction = Transaksi::select('kd_kasir', 'no_transaksi')
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_transaksi', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->first();

        return $lastTransaction; 
    }
}
