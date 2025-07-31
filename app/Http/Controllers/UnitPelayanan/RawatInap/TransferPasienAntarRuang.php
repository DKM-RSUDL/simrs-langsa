<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\HrdKaryawan;
use App\Models\KamarInduk;
use App\Models\Kunjungan;
use App\Models\RmeSerahTerima;
use App\Models\Unit;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TransferPasienAntarRuang extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
    }

    /**
     * Helper method untuk mendapatkan data medis
     */
    private function getDataMedis($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk)
    {
        try {
            // Konversi format tanggal untuk SQL Server
            $tgl_masuk_formatted = Carbon::parse($tgl_masuk)->format('Y-m-d');

            $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
                ->join('transaksi as t', function ($join) {
                    $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                    $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                    $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                    $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
                })
                ->where('kunjungan.kd_pasien', (int) $kd_pasien)
                ->where('kunjungan.kd_unit', (int) $kd_unit)
                ->where('kunjungan.urut_masuk', (int) $urut_masuk)
                // Gunakan whereRaw untuk memastikan format tanggal yang benar
                ->whereRaw("CAST(kunjungan.tgl_masuk AS DATE) = ?", [$tgl_masuk_formatted])
                ->first();

            // Pastikan data ditemukan sebelum mengakses properti
            if (!$dataMedis) {
                abort(404, 'Data kunjungan tidak ditemukan');
            }

            // Hitung umur jika data pasien ada
            if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
                $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
            } elseif ($dataMedis->pasien) {
                $dataMedis->pasien->umur = 'Tidak Diketahui';
            }

            return $dataMedis;
        } catch (\Exception $e) {

            abort(500, 'Terjadi kesalahan dalam mengambil data medis: ' . $e->getMessage());
        }
    }

    /**
     * Helper method untuk mendapatkan data serah terima
     */
    private function getSerahTerimaData($kd_pasien, $tgl_masuk, $urut_masuk)
    {
        try {
            $tgl_masuk_formatted = Carbon::parse($tgl_masuk)->format('Y-m-d');

            $serahTerimaData = RmeSerahTerima::with(['unitAsal', 'unitTujuan', 'petugasAsal', 'petugasTerima'])
                ->where('kd_pasien', (int) $kd_pasien)
                ->where('kd_unit_asal', 3)
                ->where('urut_masuk', (int) $urut_masuk)
                // Gunakan whereRaw untuk format tanggal yang konsisten
                ->whereRaw("CAST(tgl_masuk AS DATE) = ?", [$tgl_masuk_formatted])
                ->first();

            if (!$serahTerimaData) {
                abort(404, 'Data serah terima tidak ditemukan!');
            }

            return $serahTerimaData;
        } catch (\Exception $e) {

            abort(500, 'Terjadi kesalahan dalam mengambil data serah terima: ' . $e->getMessage());
        }
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


        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        // Menghitung umur berdasarkan tgl_lahir jika ada
        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        $unit = Unit::where('aktif', 1)->get();
        $unitTujuan = Unit::where('kd_bagian', 1)
            ->where('aktif', 1)
            ->whereNot('kd_unit', $kd_unit)
            ->get();

        $petugas = HrdKaryawan::where('kd_jenis_tenaga', 2)
            ->where('kd_detail_jenis_tenaga', 1)
            ->where('status_peg',  1)
            ->get();
        $dokter = Dokter::where('status', 1)->orderBy('nama_lengkap', 'asc')->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.transfer-pasien-antar-ruang.index', compact('dataMedis', 'unit', 'unitTujuan', 'petugas', 'dokter'));
    }

    public function getKamarByRuang(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        try {
            // Validasi input
            $request->validate([
                'kd_unit' => 'required'
            ]);

            $kdUnit = $request->kd_unit;

            // Query untuk mendapatkan kamar yang tersedia
            $kamar = KamarInduk::select([
                'kamar_induk.no_kamar',
                'kamar_induk.nama_kamar',
                DB::raw('(kamar_induk.jumlah_bed - kamar_induk.digunakan - kamar_induk.booking) as sisa_bed')
            ])
                ->join('kamar as k', 'kamar_induk.no_kamar', '=', 'k.no_kamar')
                ->where(DB::raw('(kamar_induk.jumlah_bed - kamar_induk.digunakan - kamar_induk.booking)'), '>', 0)
                ->where('kamar_induk.aktif', 1)
                ->where('k.kd_unit', $kdUnit)
                ->orderBy('kamar_induk.nama_kamar')
                ->get();

            $kamarHtml = "<option value=''>--Pilih Kamar--</option>";

            if ($kamar->count() > 0) {
                foreach ($kamar as $kmr) {
                    $kamarHtml .= "<option value='{$kmr->no_kamar}' data-sisa-bed='{$kmr->sisa_bed}'>{$kmr->nama_kamar} (Sisa: {$kmr->sisa_bed} bed)</option>";
                }
            } else {
                $kamarHtml .= "<option value='' disabled>Tidak ada kamar tersedia</option>";
            }

            return response()->json([
                'status'    => 'success',
                'message'   => 'Data kamar berhasil dimuat',
                'data'      => $kamarHtml,
                'count'     => $kamar->count()
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status'    => 'error',
                'message'   => 'Data tidak valid: ' . implode(', ', $e->errors()),
                'data'      => "<option value=''>--Pilih Kamar--</option>"
            ]);
        } catch (Exception $e) {

            return response()->json([
                'status'    => 'error',
                'message'   => 'Terjadi kesalahan saat mengambil data kamar',
                'data'      => "<option value=''>--Pilih Kamar--</option>"
            ]);
        }
    }

    public function getSisaBedByKamar(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        try {
            // Validasi input
            $request->validate([
                'no_kamar' => 'required',
                'kd_unit' => 'required'
            ]);

            $noKamar = $request->no_kamar;
            $kdUnit = $request->kd_unit;

            // Query untuk mendapatkan sisa bed
            $kamarData = KamarInduk::select([
                'kamar_induk.no_kamar',
                'kamar_induk.nama_kamar',
                'kamar_induk.jumlah_bed',
                'kamar_induk.digunakan',
                'kamar_induk.booking',
                DB::raw('(kamar_induk.jumlah_bed - kamar_induk.digunakan - kamar_induk.booking) as sisa_bed')
            ])
                ->join('kamar as k', 'kamar_induk.no_kamar', '=', 'k.no_kamar')
                ->where('kamar_induk.no_kamar', $noKamar)
                ->where('k.kd_unit', $kdUnit)
                ->where('kamar_induk.aktif', 1)
                ->first();

            if (!$kamarData) {
                return response()->json([
                    'status'    => 'error',
                    'message'   => 'Data kamar tidak ditemukan',
                    'data'      => 0
                ]);
            }

            $sisaBed = $kamarData->sisa_bed;

            // Validasi sisa bed tidak boleh negatif
            if ($sisaBed < 0) {
                $sisaBed = 0;
            }

            return response()->json([
                'status'    => 'success',
                'message'   => 'Data sisa bed berhasil dimuat',
                'data'      => $sisaBed,
                'detail'    => [
                    'nama_kamar' => $kamarData->nama_kamar,
                    'total_bed' => $kamarData->jumlah_bed,
                    'terpakai' => $kamarData->digunakan,
                    'booking' => $kamarData->booking,
                    'sisa' => $sisaBed
                ]
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status'    => 'error',
                'message'   => 'Data tidak valid: ' . implode(', ', $e->errors()),
                'data'      => 0
            ]);
        } catch (Exception $e) {

            return response()->json([
                'status'    => 'error',
                'message'   => 'Terjadi kesalahan saat mengambil data sisa bed',
                'data'      => 0
            ]);
        }
    }
}
