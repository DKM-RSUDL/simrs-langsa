<?php

namespace App\Services;

use App\Models\Cppt;
use App\Models\MrKonpas;
use App\Models\MrKonpasDtl;
use App\Models\Transaksi;
use App\Models\VitalSign;
use Exception;

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
            [
                'kd_kasir' => $kd_kasir,
                'no_transaksi' => $no_transaksi,
            ],
            $vitalSign
        );
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

    public function getVitalSignData($kd_kasir, $no_transaksi)
    {
        try {
            $vitalSign = VitalSign::where('kd_kasir', $kd_kasir)
                ->where('no_transaksi', $no_transaksi)
                ->first();

            return $vitalSign;
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Get latest vital signs data for a patient
     * This method can be used globally across the application
     * 
     * @param string $kd_unit
     * @param string $kd_pasien
     * @param string $tgl_masuk
     * @param string $urut_masuk
     * @return object|null
     */
    public function getLatestVitalSignsByPatient($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        try {
            // Get transaction data first
            $transactionData = $this->getTransaksiData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
            
            if (!$transactionData) {
                return null;
            }

            // Get vital signs data using transaction info
            $vitalSign = $this->getVitalSignData($transactionData->kd_kasir, $transactionData->no_transaksi);
            
            if ($vitalSign) {
                // Map vital signs data to form field names for better usability
                return (object) [
                    'nadi' => $vitalSign->nadi,
                    'sistole' => $vitalSign->sistole,
                    'diastole' => $vitalSign->diastole,
                    'respiration' => $vitalSign->respiration,
                    'suhu' => $vitalSign->suhu,
                    'spo2_tanpa_o2' => $vitalSign->spo2_tanpa_o2,
                    'spo2_dengan_o2' => $vitalSign->spo2_dengan_o2,
                    'tinggi_badan' => $vitalSign->tinggi_badan,
                    'berat_badan' => $vitalSign->berat_badan,
                    'original' => $vitalSign
                ];
            }

            return null;
        } catch (Exception $e) {
            return null;
        }
    }
}
