<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\RawatInap\OperasiIBS;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

class OperasiIBSController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
    }

    public function index($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
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

        // Provide a safe fallback for $informedConsent while the model/table is not yet created.
        $informedConsent = new Collection();

        try {
            // If the InformedConsent model and table exist, use them. We check both the class and table presence.
            if (class_exists(\App\Models\InformedConsent::class) && Schema::hasTable((new \App\Models\InformedConsent)->getTable())) {
                $informedConsent = \App\Models\InformedConsent::where('kd_pasien', $kd_pasien)
                    ->where('kd_unit', $kd_unit)
                    ->whereDate('tgl_masuk', date('Y-m-d', strtotime($tgl_masuk)))
                    ->where('urut_masuk', $urut_masuk)
                    ->get();
            } else {
                // Create a small fake dataset so the view can render without errors during development.
                $informedConsent->push((object)[
                    'id' => 1,
                    'tanggal' => date('Y-m-d'),
                    'jam' => date('H:i:s'),
                    'user' => (object)['name' => 'Demo User'],
                    'nama_penerima_info' => 'Demo Penerima',
                    'saksi1_nama' => 'Saksi 1 Demo',
                    'saksi2_nama' => 'Saksi 2 Demo'
                ]);
            }
        } catch (\Exception $e) {
            // On any unexpected error, return an empty collection to avoid breaking the view.
            $informedConsent = new Collection();
        }

        // Provide demo Operasi IBS data when the model/table is not yet created so the view can render.
        $operasiIbs = new Collection();
        try {
            if (class_exists(OperasiIBS::class) && Schema::hasTable((new OperasiIBS)->getTable())) {
                $operasiIbs = OperasiIBS::where('kd_pasien', $kd_pasien)
                    ->where('kd_unit', $kd_unit)
                    ->whereDate('tgl_masuk', date('Y-m-d', strtotime($tgl_masuk)))
                    ->where('urut_masuk', $urut_masuk)
                    ->get();
            } else {
                // Demo / fake data
                $operasiIbs->push((object)[
                    'id' => 1,
                    'tanggal' => date('Y-m-d'),
                    'jam' => date('H:i:s'),
                    'dokter' => (object)['name' => 'Dr. Demo Operasi'],
                    'tindakan' => 'Reseksi usus kecil (demo)',
                    'catatan' => 'Data demo — buat model OperasiIBS untuk menyimpan riil.'
                ]);

                $operasiIbs->push((object)[
                    'id' => 2,
                    'tanggal' => date('Y-m-d', strtotime('-1 day')),
                    'jam' => '09:30:00',
                    'dokter' => (object)['name' => 'Dr. Contoh'],
                    'tindakan' => 'Eksisi polip (demo)',
                    'catatan' => 'Catatan demo kedua'
                ]);
            }
        } catch (\Exception $e) {
            $operasiIbs = new Collection();
        }

        return view('unit-pelayanan.rawat-inap.pelayanan.operasi-ibs.index', compact('dataMedis', 'operasiIbs'));
    }

    public function create($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk) {
         $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
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

        return view('unit-pelayanan.rawat-inap.pelayanan.operasi-ibs.create', compact('dataMedis'));
    }

}
