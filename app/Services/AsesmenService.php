<?php

namespace App\Services;

use App\Models\Cppt;
use App\Models\MrKonpas;
use App\Models\MrKonpasDtl;
use App\Models\Transaksi;
use App\Models\VitalSign;

class AsesmenService
{
    public function store($vitalSignData, $no_rm, $no_transaksi, $kd_kasir)
    {
        if (empty($vitalSignData)) {
            return;
        }

        $mapping = [
            'sistole' => 'int',
            'diastole' => 'int',
            'nadi' => 'int',
            'respiration' => 'int',
            'suhu' => 'float',
            'spo2_tanpa_o2' => 'int',
            'spo2_dengan_o2' => 'int',
            'tinggi_badan' => 'int',
            'berat_badan' => 'int',
        ];

        $vitalSign = [];

        foreach ($mapping as $field => $type) {
            if (isset($vitalSignData[$field])) {
                $vitalSign[$field] = $type === 'int'
                    ? (int) $vitalSignData[$field]
                    : (float) $vitalSignData[$field];
            }
        }

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
