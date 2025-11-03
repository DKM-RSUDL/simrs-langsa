<?php

namespace App\Http\Controllers\UnitPelayanan\GawatDarurat;

use App\Http\Controllers\Controller;
use App\Models\AptBarangOut;
use App\Models\DataTriase;
use App\Models\HrdKaryawan;
use App\Models\Konsultasi;
use App\Models\KonsultasiIGD;
use App\Models\Kunjungan;
use App\Models\ListTindakanPasien;
use App\Models\MrResep;
use App\Models\Otoritas;
use App\Models\OtoritasCetakan;
use App\Models\Pasien;
use App\Models\RmeAsesmen;
use App\Models\RMEResume;
use App\Models\SegalaOrder;
use App\Models\SjpKunjungan;
use App\Models\Spesialisasi;
use App\Models\Transaksi;
use App\Models\Unit;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UpdatePasienController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/gawat-darurat');
    }

    public function index($kd_pasien, $tgl_masuk, $urut_masuk)
    {

        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', 3)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();

        $unit = Unit::where('aktif', 1)->get();
        $unitTujuan = Unit::where('kd_bagian', 1)->where('aktif', 1)->get();


        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.ubah-pasien.index', compact('dataMedis', 'unit', 'unitTujuan'));
    }


    public function UbahPasien(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $kd_pasien_lama = $kd_pasien;

        DB::beginTransaction();

        try {
            // Validate request data
            $request->validate([
                'kd_pasien_asli' => 'required'
            ]);

            $pasien_asli = Pasien::where('kd_pasien', $request->kd_pasien_asli)->first();

            if (empty($pasien_asli)) {
                throw new Exception('Pasien baru tidak ditemukan berdasarkan NIK/No. RM yang diberikan.');
            }

            if ($pasien_asli->kd_pasien == $kd_pasien_lama) {
                throw new Exception('Pasien baru sama dengan pasien lama. Tidak ada perubahan yang diperlukan.');
            }

            $kd_pasien_baru = $pasien_asli->kd_pasien;

            // get old kunjungan
            $kunjungan = Kunjungan::where('kd_pasien', $kd_pasien_lama)
                ->where('kd_unit', 3)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->first();

            if (empty($kunjungan)) throw new Exception('Data kunjungan tidak ditemukan di data pasien lama.');

            //get new urut masuk==============
            $new_urut_masuk = 0;
            if (!empty($pasien_asli)) {
                $getLastUrutMasukPatientToday = Kunjungan::select('urut_masuk')
                    ->where('kd_pasien', $pasien_asli->kd_pasien)
                    ->whereDate('tgl_masuk', $tgl_masuk)
                    ->orderBy('urut_masuk', 'desc')
                    ->first();

                $new_urut_masuk = ! empty($getLastUrutMasukPatientToday) ? $getLastUrutMasukPatientToday->urut_masuk + 1 : $urut_masuk;
            }

            // 1. Update Kunjungan table (specific to kd_pasien_lama, tgl_masuk, urut_masuk)
            Kunjungan::where('kd_pasien', $kd_pasien_lama)
                ->where('kd_unit', 3)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->update([
                    'kd_pasien' => $kd_pasien_baru,
                    'urut_masuk' => $new_urut_masuk,
                    'triase_proses' => 0,

                ]);

            // 2. Update Transaksi table
            Transaksi::where('kd_pasien', $kd_pasien_lama)
                ->where('kd_unit', 3)
                ->where('tgl_transaksi', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->update([
                    'kd_pasien' => $kd_pasien_baru,
                    'urut_masuk' => $new_urut_masuk,
                ]);

            // 3. Update DataTriase table (kd_pasien and kd_pasien_triase)
            DataTriase::where('id', $kunjungan->triase_id)
                ->where('kd_pasien_triase', $kd_pasien_lama)
                ->update([
                    'kd_pasien_triase' => $kd_pasien_baru,
                    'nama_pasien' => $pasien_asli->nama,
                    'jenis_kelamin' => $pasien_asli->jenis_kelamin,
                    'tanggal_lahir' => $pasien_asli->tanggal_lahir,
                    'usia' => \Carbon\Carbon::parse($pasien_asli->tanggal_lahir)->age,
                ]);

            // Daftar model yang ingin diupdate
            $models = [
                SjpKunjungan::class,
                RmeAsesmen::class,
                ListTindakanPasien::class,
                KonsultasiIGD::class,
                SegalaOrder::class,
                MrResep::class,
                RMEResume::class
            ];

            foreach ($models as $model) {
                $model::where('kd_pasien', $kd_pasien_lama)
                    ->where('kd_unit', 3)
                    ->where('tgl_masuk', $tgl_masuk)
                    ->where('urut_masuk', $urut_masuk)
                    ->update(
                        [
                            'kd_pasien' => $kd_pasien_baru,
                            'urut_masuk' => $new_urut_masuk,
                        ]
                    );
            }

            // Update Pendukung
            Kunjungan::where('kd_pasien', $kd_pasien_lama)
                ->update([
                    'kd_pasien' => $kd_pasien_baru,
                ]);


            Transaksi::where('kd_pasien', $kd_pasien_lama)
                ->update([
                    'kd_pasien' => $kd_pasien_baru,
                ]);


            Otoritas::where('kd_pasien', $kd_pasien_lama)
                ->update([
                    'kd_pasien' => $kd_pasien_baru,
                ]);

            OtoritasCetakan::where('kd_pasien', $kd_pasien_lama)
                ->update([
                    'kd_pasien' => $kd_pasien_baru,
                ]);

            AptBarangOut::where('kd_pasienapt', $kd_pasien_lama)
                ->update([
                    'kd_pasienapt' => $kd_pasien_baru,
                ]);


            DB::commit();
            return to_route('index', [$kd_pasien_baru, $tgl_masuk])->with('success', 'Data pasien berhasil diubah ke data asli');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengubah data pasien: ' . $e->getMessage());
        }
    }
}
