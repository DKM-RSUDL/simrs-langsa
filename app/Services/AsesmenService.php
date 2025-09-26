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

    /**
     * Get vital sign data for CPPT form
     * Priority: CPPT data first, fallback to VitalSign table
     */
    public function getVitalSignForCppt($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $transaction = $this->getTransaksiData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

        if (!$transaction) {
            return $this->getEmptyVitalSignArray();
        }

        // Check if CPPT data exists
        $hasCpptData = Cppt::where('no_transaksi', $transaction->no_transaksi)
            ->where('kd_kasir', $transaction->kd_kasir)
            ->exists();

        if ($hasCpptData) {
            // PERBAIKAN: Get from LATEST CPPT vital signs (bukan berdasarkan tanggal hari ini)
            return $this->getLatestVitalSignFromCppt($kd_pasien, $kd_unit, $transaction->no_transaksi, $transaction->kd_kasir);
        } else {
            // Get from VitalSign table
            return $this->getVitalSignFromTable($transaction->no_transaksi, $transaction->kd_kasir);
        }
    }

    /**
     * Get latest vital sign from ANY CPPT entry (tidak terbatas hari ini)
     */
    private function getLatestVitalSignFromCppt($kd_pasien, $kd_unit, $no_transaksi, $kd_kasir)
    {
        // Get latest CPPT entry untuk pasien ini
        $latestCppt = Cppt::where('no_transaksi', $no_transaksi)
            ->where('kd_kasir', $kd_kasir)
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'desc')
            ->first();

        if (!$latestCppt) {
            return $this->getEmptyVitalSignArray();
        }

        // Get konpas berdasarkan CPPT terakhir
        $latestKonpas = MrKonpas::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('tgl_masuk', $latestCppt->tanggal)
            ->where('urut_masuk', $latestCppt->urut)
            ->orderBy('id_konpas', 'desc')
            ->first();

        if (!$latestKonpas) {
            // Jika tidak ada konpas dari CPPT terakhir, ambil konpas terakhir yang ada
            $latestKonpas = MrKonpas::where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->orderBy('tgl_masuk', 'desc')
                ->orderBy('urut_masuk', 'desc')
                ->orderBy('id_konpas', 'desc')
                ->first();
        }

        if (!$latestKonpas) {
            return $this->getEmptyVitalSignArray();
        }

        // Get konpas details
        $konpasDetails = MrKonpasDtl::join('mr_kondisifisik as kf', 'kf.id_kondisi', '=', 'mr_konpasdtl.id_kondisi')
            ->where('mr_konpasdtl.id_konpas', $latestKonpas->id_konpas)
            ->select('kf.kondisi', 'mr_konpasdtl.hasil', 'kf.urut')
            ->orderBy('kf.urut')
            ->get();

        return $this->mapKonpasToVitalSign($konpasDetails);
    }

    /**
     * Get vital sign data from VitalSign table
     */
    private function getVitalSignFromTable($no_transaksi, $kd_kasir)
    {
        $vitalSign = VitalSign::where('no_transaksi', $no_transaksi)
            ->where('kd_kasir', $kd_kasir)
            ->first();

        if (!$vitalSign) {
            return $this->getEmptyVitalSignArray();
        }

        return [
            'nadi' => $vitalSign->nadi,
            'sistole' => $vitalSign->sistole,
            'diastole' => $vitalSign->diastole,
            'tinggi_badan' => $vitalSign->tinggi_badan,
            'berat_badan' => $vitalSign->berat_badan,
            'respiration' => $vitalSign->respiration,
            'suhu' => $vitalSign->suhu,
            'spo2_tanpa_o2' => $vitalSign->spo2_tanpa_o2,
            'spo2_dengan_o2' => $vitalSign->spo2_dengan_o2,
        ];
    }

    /**
     * Map konpas data to vital sign array
     */
    private function mapKonpasToVitalSign($konpasDetails)
    {
        $vitalSignData = $this->getEmptyVitalSignArray();

        foreach ($konpasDetails as $detail) {
            $kondisi = strtolower(trim($detail->kondisi));
        

            // Mapping yang lebih spesifik
            if ($kondisi === 'nadi' || str_contains($kondisi, 'nadi')) {
                $vitalSignData['nadi'] = $detail->hasil;
            } elseif ($kondisi === 'tekanan darah (sistole)' || str_contains($kondisi, 'sistole')) {
                $vitalSignData['sistole'] = $detail->hasil;
            } elseif ($kondisi === 'tekanan darah (diastole)' || str_contains($kondisi, 'diastole') || str_contains($kondisi, 'distole')) {
                $vitalSignData['diastole'] = $detail->hasil;
            } elseif ($kondisi === 'tinggi badan' || str_contains($kondisi, 'tinggi badan')) {
                $vitalSignData['tinggi_badan'] = $detail->hasil;
            } elseif ($kondisi === 'berat badan' || str_contains($kondisi, 'berat badan')) {
                $vitalSignData['berat_badan'] = $detail->hasil;
            } elseif ($kondisi === 'respiration rate' || str_contains($kondisi, 'respiration')) {
                $vitalSignData['respiration'] = $detail->hasil;
            } elseif ($kondisi === 'suhu' || str_contains($kondisi, 'suhu')) {
                $vitalSignData['suhu'] = $detail->hasil;
            } elseif ($kondisi === 'spo2 tanpa bantuan o2' || str_contains($kondisi, 'spo2') && str_contains($kondisi, 'tanpa')) {
                $vitalSignData['spo2_tanpa_o2'] = $detail->hasil;
            } elseif ($kondisi === 'spo2 dengan bantuan o2' || str_contains($kondisi, 'spo2') && str_contains($kondisi, 'dengan')) {
                $vitalSignData['spo2_dengan_o2'] = $detail->hasil;
            }
        }

        return $vitalSignData;
    }

    /**
     * Get empty vital sign array
     */
    private function getEmptyVitalSignArray()
    {
        return [
            'nadi' => '',
            'sistole' => '',
            'diastole' => '',
            'tinggi_badan' => '',
            'berat_badan' => '',
            'respiration' => '',
            'suhu' => '',
            'spo2_tanpa_o2' => '',
            'spo2_dengan_o2' => '',
        ];
    }

    /**
     * Check if CPPT data exists (helper method)
     */
    public function hasCpptData($no_transaksi, $kd_kasir)
    {
        return Cppt::where('no_transaksi', $no_transaksi)
            ->where('kd_kasir', $kd_kasir)
            ->exists();
    }
}
