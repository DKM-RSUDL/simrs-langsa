<?php

namespace App\Services;

use App\Models\Kunjungan;
use App\Models\Nginap;
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
}
