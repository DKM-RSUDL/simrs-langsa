<?php

namespace App\Http\Controllers\UnitPelayanan\GawatDarurat;

use App\Http\Controllers\Controller;
use App\Models\AsalIGD;
use App\Models\DetailComponent;
use App\Models\DetailPrsh;
use App\Models\DetailTransaksi;
use App\Models\Dokter;
use App\Models\HrdKaryawan;
use App\Models\KamarInduk;
use App\Models\Kunjungan;
use App\Models\Nginap;
use App\Models\PasienInap;
use App\Models\RmeSerahTerima;
use App\Models\RujukanKunjungan;
use App\Models\SjpKunjungan;
use App\Models\SpcKelas;
use App\Models\Spesialisasi;
use App\Models\Tarif;
use App\Models\Transaksi;
use App\Models\Unit;
use App\Models\Pasien;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\DataTriase;
use App\Models\VitalSign;
use App\Models\Konsultasi;
use App\Models\RmeAsesmen;
use App\Models\ListTindakanPasien;
use App\Models\KonsultasiIGD;
use App\Models\SegalaOrder;


class TransferPasienController extends Controller
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

        $spesialisasi = Spesialisasi::orderBy('spesialisasi')->get();

        $unit = Unit::where('aktif', 1)->get();
        $unitTujuan = Unit::where('kd_bagian', 1)->where('aktif', 1)->get();

        $petugasIGD = HrdKaryawan::where('kd_jenis_tenaga', 2)
            ->where('kd_detail_jenis_tenaga', 1)
            ->where('kd_ruangan', 36)
            ->where('status_peg',  1)
            ->get();

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.transfer-pasien.index', compact('dataMedis', 'spesialisasi', 'unit', 'unitTujuan', 'petugasIGD'));
    }

    public function getDokterBySpesial(Request $request)
    {
        try {
            $dokter = Dokter::select(['dokter.kd_dokter', 'nama'])
                ->join('dokter_spesial as ds', 'dokter.kd_dokter', '=', 'ds.kd_dokter')
                ->where('ds.kd_spesial', $request->kd_spesial)
                ->where('dokter.status', 1)
                ->distinct()
                ->get();

            $kelas = SpcKelas::select(['k.kd_kelas', 'k.kelas'])
                ->join('kelas as k', 'spc_kelas.kd_kelas', '=', 'k.kd_kelas')
                ->where('spc_kelas.kd_spesial', $request->kd_spesial)
                ->orderBy('k.kelas')
                ->get();


            $dokHtml = "<option value=''>--Pilih Dokter--</option>";
            $klsHtml = "<option value=''>--Pilih Kelas--</option>";

            foreach ($dokter as $dok) {
                $dokHtml .= "<option value='$dok->kd_dokter'>$dok->nama</option>";
            }

            foreach ($kelas as $kls) {
                $klsHtml .= "<option value='$kls->kd_kelas'>$kls->kelas</option>";
            }

            return response()->json([
                'status'    => 'success',
                'message'   => 'OK',
                'data'      => [
                    'dokterOption'  => $dokHtml,
                    'kelasOption'   => $klsHtml
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'    => 'error',
                'message'   => $e->getMessage(),
                'data'      => []
            ]);
        }
    }

    public function getRuanganByKelas(Request $request)
    {
        try {
            $ruangan = Unit::select(['unit.kd_unit', 'unit.nama_unit'])
                ->join('kelas as k', 'unit.kd_kelas', '=', 'k.kd_kelas')
                ->where('k.kd_kelas', $request->kd_kelas)
                ->where('unit.aktif', 1)
                ->orderBy('unit.kd_unit')
                ->get();


            $ruangHtml = "<option value=''>--Pilih Ruang--</option>";

            foreach ($ruangan as $ruang) {
                $ruangHtml .= "<option value='$ruang->kd_unit'>$ruang->nama_unit</option>";
            }

            return response()->json([
                'status'    => 'success',
                'message'   => 'OK',
                'data'      => $ruangHtml
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'    => 'error',
                'message'   => $e->getMessage(),
                'data'      => []
            ]);
        }
    }

    public function getKamarByRuang(Request $request)
    {
        try {
            $kamar = KamarInduk::select(['kamar_induk.no_kamar', 'kamar_induk.nama_kamar'])
                ->join('kamar as k', 'kamar_induk.no_kamar', '=', 'k.no_kamar')
                ->where(DB::raw('kamar_induk.jumlah_bed - kamar_induk.digunakan - kamar_induk.booking'), '>', 0)
                ->where('kamar_induk.aktif', 1)
                ->where('k.kd_unit', $request->kd_unit)
                ->get();


            $kamarHtml = "<option value=''>--Pilih Kamar--</option>";

            foreach ($kamar as $kmr) {
                $kamarHtml .= "<option value='$kmr->no_kamar'>$kmr->nama_kamar</option>";
            }

            return response()->json([
                'status'    => 'success',
                'message'   => 'OK',
                'data'      => $kamarHtml
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'    => 'error',
                'message'   => $e->getMessage(),
                'data'      => []
            ]);
        }
    }

    public function getSisaBedByKamar(Request $request)
    {
        try {
            $sisaBed = KamarInduk::select(DB::raw('(jumlah_bed - digunakan - booking) as sisa'))
                ->where('no_kamar', $request->no_kamar)
                ->first()
                ->sisa;

            return response()->json([
                'status'    => 'success',
                'message'   => 'OK',
                'data'      => $sisaBed
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'    => 'error',
                'message'   => $e->getMessage(),
                'data'      => []
            ]);
        }
    }

    public function storeTransferInap(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $kd_pasien_lama = $kd_pasien;

        DB::beginTransaction();

        try {
            // Validate request data
            $request->validate([
                'nik_pasien' => 'required|string|max:20',
                'nama' => 'required|string|max:255',
                'jenis_kelamin' => 'required|in:0,1',
                'tanggal_lahir' => 'required|date',
                'alamat' => 'nullable|string',
            ]);

            $pasien_baru = Pasien::where('no_pengenal', $request->nik_pasien)
                ->orWhere('kd_pasien', $request->nik_pasien)
                ->first();

            if (empty($pasien_baru)) {
                throw new \Exception('Pasien baru tidak ditemukan berdasarkan NIK/No. RM yang diberikan.');
            }

            if ($pasien_baru->kd_pasien === $kd_pasien_lama) {
                throw new \Exception('Pasien baru sama dengan pasien lama. Tidak ada perubahan yang diperlukan.');
            }

            // Update the new patient's data with form inputs
            $pasien_baru->update([
                'nama' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tgl_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                // Add other fields if needed, e.g., 'tempat_lahir', 'telepon', etc.
            ]);

            $kd_pasien_baru = $pasien_baru->kd_pasien;

            // 1. Update Kunjungan table (specific to kd_pasien_lama, tgl_masuk, urut_masuk)
            $kunjungan = Kunjungan::where('kd_pasien', $kd_pasien_lama)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->first();

            if ($kunjungan) {
                $kunjungan->kd_pasien = $kd_pasien_baru;
                $kunjungan->triase_proses = 0;
                $kunjungan->save();
            } else {
                throw new \Exception('Data kunjungan tidak ditemukan untuk pasien lama.');
            }

            // 2. Update Transaksi table (all records matching kd_pasien_lama)
            $transaksiUpdated = Transaksi::where('kd_pasien', $kd_pasien_lama)
                ->update(['kd_pasien' => $kd_pasien_baru]);

            // 3. Update DataTriase table (kd_pasien and kd_pasien_triase)
            $triaseUpdated = DataTriase::where('kd_pasien', $kd_pasien_lama)
                ->orWhere('kd_pasien_triase', $kd_pasien_lama)
                ->update([
                    'kd_pasien' => $kd_pasien_baru,
                    'kd_pasien_triase' => $kd_pasien_baru,
                    'nama_pasien' => $request->nama,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'usia' => \Carbon\Carbon::parse($request->tanggal_lahir)->age,
                ]);

           

            // 4. Update SjpKunjungan table (kd_pasien, tgl_masuk, urut_masuk)
            $sjpKunjunganUpdated = SjpKunjungan::where('kd_pasien', $kd_pasien_lama)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->update(['kd_pasien' => $kd_pasien_baru]);

            // 5. Update Konsultasi table (kd_pasien, tgl_masuk, urut_masuk)
            $konsultasiUpdated = Konsultasi::where('kd_pasien', $kd_pasien_lama)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->update(['kd_pasien' => $kd_pasien_baru]);

            // 6. Update RmeAsesmen table (kd_pasien, tgl_masuk, urut_masuk)
            $rmeAsesmenUpdated = RmeAsesmen::where('kd_pasien', $kd_pasien_lama)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->update(['kd_pasien' => $kd_pasien_baru]);

            // 7. Update ListTindakanPasien table (kd_pasien, tgl_masuk, urut_masuk)
            $listTindakanPasienUpdated = ListTindakanPasien::where('kd_pasien', $kd_pasien_lama)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->update(['kd_pasien' => $kd_pasien_baru]);

            // 8. Update KonsultasiIGD table (kd_pasien, tgl_masuk, urut_masuk)
            $konsultasiIGDUpdated = KonsultasiIGD::where('kd_pasien', $kd_pasien_lama)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->update(['kd_pasien' => $kd_pasien_baru]);

            // 9. Update SegalaOrder table (kd_pasien, tgl_masuk, urut_masuk)
            $segalaOrderUpdated = SegalaOrder::where('kd_pasien', $kd_pasien_lama)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->update(['kd_pasien' => $kd_pasien_baru]);

            DB::commit();

            return redirect()->route('gawat-darurat.index')->with('success', 'Data pasien berhasil diubah dan diperbarui di semua tabel terkait.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengubah data pasien: ' . $e->getMessage());
        }
    }

}
