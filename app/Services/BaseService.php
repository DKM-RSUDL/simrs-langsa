<?php

namespace App\Services;

use App\Models\Kunjungan;
use App\Models\Nginap;
use App\Models\RmeKetStatusKunjungan;
use App\Models\RMEResume;
use App\Models\RmeResumeDtl;
use App\Models\Transaksi;

class BaseService
{
    // Get data medis
    public function getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis =  Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', $kd_unit)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();

        return $dataMedis;
    }

    public function getNginapData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $nginap = Nginap::join('unit as u', 'nginap.kd_unit_kamar', '=', 'u.kd_unit')
            ->where('nginap.kd_pasien', $kd_pasien)
            ->where('nginap.kd_unit', $kd_unit)
            ->where('nginap.tgl_masuk', $tgl_masuk)
            ->where('nginap.urut_masuk', $urut_masuk)
            ->where('nginap.akhir', 1)
            ->first();

        return $nginap;
    }

    // Get data medis
    public function getDataMedisbyTransaksi($kd_kasir, $no_transaksi)
    {
        $dataMedis =  Transaksi::with(['pasien', 'unit'])
            ->join('kunjungan as k', function ($join) {
                $join->on('k.kd_pasien', '=', 'transaksi.kd_pasien');
                $join->on('k.kd_unit', '=', 'transaksi.kd_unit');
                $join->on('k.tgl_masuk', '=', 'transaksi.tgl_transaksi');
                $join->on('k.urut_masuk', '=', 'transaksi.urut_masuk');
            })
            ->where('transaksi.kd_kasir', $kd_kasir)
            ->where('transaksi.no_transaksi', $no_transaksi)
            ->first();

        return $dataMedis;
    }

    // update status keterangan kunjungan
    public function updateKetKunjungan($kd_kasir, $no_transaksi, $keterangan, $status)
    {
        RmeKetStatusKunjungan::updateOrCreate([
            'kd_kasir'      => $kd_kasir,
            'no_transaksi'  => $no_transaksi,
        ], [
            'keterangan_kunjungan'  => $keterangan,
            'status_inap'           => $status
        ]);
    }

    // UPDATE RESUME MEDIS
    public function updateResumeMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $data)
    {
        // CONTOH DATA YANG DIKIRIM

        /*
            $resumeData = [
                'anamnesis'             => 'demam tinggi dan batuk',
                'diagnosis'             => ['demam', 'batuk'],

                // WAJIB DIKIRIM

                'tindak_lanjut_code'    => 1,
                'tindak_lanjut_name'    => 'Rawat Inap',

                //=========================================



                'tgl_kontrol_ulang'     => '2023-09-15',
                'unit_rujuk_internal'  => '0102',
                'unit_rawat_inap'      => '0203',
                'rs_rujuk'             => 'RSUP HAM Medan',
                'alasan_rujuk'          => 1,
                'transportasi_rujuk'   => 3,
                'tgl_pulang'            => '2023-09-10',
                'jam_pulang'            => '14:30:00',
                'alasan_pulang'         => 2,
                'kondisi_pulang'        => 1,
                'tgl_rajal'             => '2025-10-10',
                'unit_rajal'            => '222',
                'tgl_meninggal'         => '2023-09-12',
                'jam_meninggal'         => '10:00:00',
                'tgl_meninggal_doa'         => '2023-09-12',
                'jam_meninggal_doa'         => '10:00:00',
                'rs_rujuk_bagian'        => 'IGD',
                'keterangan'            => 'takut',

                'konpas'                =>
                [
                    'sistole'   => [
                        'hasil' => $vitalSignStore['sistole'] ?? null
                    ],
                    'distole'   => [
                        'hasil' => $vitalSignStore['diastole'] ?? null
                    ],
                    'respiration_rate'   => [
                        'hasil' => $vitalSignStore['respiration'] ?? null
                    ],
                    'suhu'   => [
                        'hasil' => $vitalSignStore['suhu'] ?? null
                    ],
                    'nadi'   => [
                        'hasil' => $vitalSignStore['nadi'] ?? null
                    ],
                    'tinggi_badan'   => [
                        'hasil' => $vitalSignStore['tinggi_badan'] ?? null
                    ],
                    'berat_badan'   => [
                        'hasil' => $vitalSignStore['berat_badan'] ?? null
                    ]
                ]
            ];

        */


        // get resume
        $resume = RMEResume::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->first();

        $statusResume  = $resume->status ?? 0;

        // update or create rme_resume
        if (empty($resume)) $resume = new RMEResume();

        $resume->kd_pasien = $kd_pasien;
        $resume->kd_unit = $kd_unit;
        $resume->tgl_masuk = $tgl_masuk;
        $resume->urut_masuk = $urut_masuk;
        if (isset($data['anamnesis'])) $resume->anamnesis = $data['anamnesis'];
        if (isset($data['konpas'])) $resume->konpas = $data['konpas'];
        if (isset($data['diagnosis'])) $resume->diagnosis = $data['diagnosis'];
        $resume->status = $statusResume;
        $resume->save();

        // update or create rme_resume_dtl
        $resumeDetail = RmeResumeDtl::find($resume->id);
        if (empty($resumeDetail)) $resumeDetail = new RmeResumeDtl();

        $resumeDetail->id_resume                = $resume->id;
        if (isset($data['tindak_lanjut_code'])) $resumeDetail->tindak_lanjut_code       = $data['tindak_lanjut_code'];
        if (isset($data['tindak_lanjut_name'])) $resumeDetail->tindak_lanjut_name       = $data['tindak_lanjut_name'];
        if (isset($data['tgl_kontrol_ulang'])) $resumeDetail->tgl_kontrol_ulang        = $data['tgl_kontrol_ulang'] ?? null;
        if (isset($data['unit_rujuk_internal'])) $resumeDetail->unit_rujuk_internal      = $data['unit_rujuk_internal'] ?? null;
        if (isset($data['unit_rawat_inap'])) $resumeDetail->unit_rawat_inap          = $data['unit_rawat_inap'] ?? null;
        if (isset($data['rs_rujuk'])) $resumeDetail->rs_rujuk                 = $data['rs_rujuk'] ?? null;
        if (isset($data['alasan_rujuk'])) $resumeDetail->alasan_rujuk             = $data['alasan_rujuk'] ?? null;
        if (isset($data['transportasi_rujuk'])) $resumeDetail->transportasi_rujuk       = $data['transportasi_rujuk'] ?? null;
        if (isset($data['tgl_pulang'])) $resumeDetail->tgl_pulang               = $data['tgl_pulang'] ?? null;
        if (isset($data['jam_pulang'])) $resumeDetail->jam_pulang               = $data['jam_pulang'] ?? null;
        if (isset($data['alasan_pulang'])) $resumeDetail->alasan_pulang            = $data['alasan_pulang'] ?? null;
        if (isset($data['kondisi_pulang'])) $resumeDetail->kondisi_pulang           = $data['kondisi_pulang'] ?? null;
        if (isset($data['tgl_rajal'])) $resumeDetail->tgl_rajal                = $data['tgl_rajal'] ?? null;
        if (isset($data['unit_rajal'])) $resumeDetail->unit_rajal               = $data['unit_rajal'] ?? null;
        if (isset($data['tgl_meninggal'])) $resumeDetail->tgl_meninggal            = $data['tgl_meninggal'] ?? null;
        if (isset($data['jam_meninggal'])) $resumeDetail->jam_meninggal            = $data['jam_meninggal'] ?? null;
        if (isset($data['tgl_meninggal_doa'])) $resumeDetail->tgl_meninggal_doa        = $data['tgl_meninggal_doa'] ?? null;
        if (isset($data['jam_meninggal_doa'])) $resumeDetail->jam_meninggal_doa        = $data['jam_meninggal_doa'] ?? null;
        if (isset($data['rs_rujuk_bagian'])) $resumeDetail->rs_rujuk_bagian          = $data['rs_rujuk_bagian'] ?? null;
        if (isset($data['keterangan'])) $resumeDetail->keterangan               = $data['keterangan'] ?? null;
        $resumeDetail->save();
    }
}
