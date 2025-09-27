<?php

namespace Database\Seeders;

use App\Models\Pasien;
use App\Models\DataTriase;
use App\Models\Kunjungan;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\DetailPrsh;
use App\Models\DetailComponent;
use App\Models\SjpKunjungan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DaruratSeeder extends Seeder
{
    public function run(): void
    {
        DB::beginTransaction();

        try {
            // Contoh data dummy untuk pasien
            $no_rm = null; // Pasien baru
            $nama_pasien = 'John Doe';
            $usia_tahun = 30;
            $usia_bulan = 0;
            $jenis_kelamin = 'L';
            $tgl_masuk = Carbon::now()->format('Y-m-d');
            $jam_masuk = Carbon::now()->format('H:i:s');
            $dokter_triase = 1; // ID dokter dummy
            $kode_triase = 'TR001'; // Kode triase dummy
            $hasil_triase = 'Stabil';
            $rujukan = 0;
            $rujukan_ket = null;

            // Hitung tanggal lahir
            $tanggal_lahir = Carbon::now()->subYears($usia_tahun)->subMonths($usia_bulan)->format('Y-m-d');

            // Data triase
            $dataTriase = [
                'hasil_triase' => $hasil_triase,
                'kode_triase' => $kode_triase,
                'air_way' => 'Normal',
                'breathing' => 'Normal',
                'circulation' => 'Normal',
                'disability' => 'Normal',
            ];

            // Tentukan nomor IGD baru
            $prefix = 'IGD-';
            $lastIgdNumber = Pasien::select('kd_pasien')
                ->where('kd_pasien', 'like', "$prefix%")
                ->orderBy('kd_pasien', 'desc')
                ->first();

            if (empty($lastIgdNumber)) {
                $lastIgdNumber = $prefix . '000001';
            } else {
                $lastIgdNumber = $lastIgdNumber->kd_pasien;
                $lastIgdNumber = explode('-', $lastIgdNumber)[1];
                $lastIgdNumber = (int) $lastIgdNumber + 1;
                $lastIgdNumber = str_pad($lastIgdNumber, 6, '0', STR_PAD_LEFT);
                $lastIgdNumber = $prefix . $lastIgdNumber;
            }

            $finalNoRm = $lastIgdNumber;

            // Simpan ke tabel data_triase
            $triase = DataTriase::create([
                'nama_pasien' => $nama_pasien,
                'usia' => $usia_tahun,
                'usia_bulan' => $usia_bulan,
                'jenis_kelamin' => $jenis_kelamin,
                'tanggal_lahir' => $tanggal_lahir,
                'status' => 1,
                'kd_pasien' => null,
                'kd_pasien_triase' => $finalNoRm,
                'keterangan' => null,
                'tanggal_triase' => "$tgl_masuk $jam_masuk",
                'triase' => json_encode($dataTriase),
                'hasil_triase' => $hasil_triase,
                'dokter_triase' => $dokter_triase,
                'kode_triase' => $kode_triase,
                'foto_pasien' => '', // Tidak ada foto untuk seeder
            ]);

            // Simpan ke tabel pasien
            Pasien::create([
                'kd_pasien' => $finalNoRm,
                'nama' => $nama_pasien,
                'jenis_kelamin' => $jenis_kelamin,
                'tempat_lahir' => '',
                'tgl_lahir' => $tanggal_lahir,
                'kd_agama' => 0,
                'gol_darah' => 0,
                'status_marita' => 0,
                'alamat' => '',
                'telepon' => '',
                'kd_kelurahan' => null,
                'kd_pendidikan' => null,
                'kd_pekerjaan' => 16,
                'no_pengenal' => '',
                'no_asuransi' => '',
                'pemegang_asuransi' => '',
                'jns_peserta' => '',
                'wni' => 0,
                'kd_suku' => null,
                'tanda_pengenal' => 0,
                'kd_pos' => null,
                'nama_keluarga' => '',
                'ibu_kandung' => null,
                'kelas' => null,
                'kd_bahasa' => 0,
                'kd_cacat' => 0,
                'email' => '',
                'gelar_dpn' => '',
                'gelar_blkg' => '',
                'kd_negara' => '',
                'tgl_pass' => null,
            ]);

            // Simpan ke tabel kunjungan
            $no_antrian = Kunjungan::select('antrian')
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('kd_unit', 3)
                ->orderBy('antrian', 'desc')
                ->first()?->antrian + 1 ?? 1;

            Kunjungan::create([
                'kd_pasien' => $finalNoRm,
                'kd_unit' => 3,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => 0,
                'jam_masuk' => $jam_masuk,
                'asal_pasien' => 0,
                'cara_penerimaan' => 99,
                'kd_rujukan' => 0,
                'no_surat' => '',
                'kd_dokter' => $dokter_triase,
                'baru' => 1,
                'kd_customer' => '0000000001',
                'shift' => 0,
                'kontrol' => 0,
                'antrian' => $no_antrian,
                'tgl_surat' => $tgl_masuk,
                'jasa_raharja' => 0,
                'catatan' => '',
                'kd_triase' => $kode_triase,
                'is_rujukan' => $rujukan,
                'rujukan_ket' => $rujukan_ket,
                'triase_id' => $triase->id,
                'triase_proses' => 1,
            ]);

            // Simpan transaksi
            $lastTransaction = Transaksi::select('no_transaksi')
                ->where('kd_unit', 3)
                ->where('kd_kasir', '06')
                ->orderBy('no_transaksi', 'desc')
                ->first();

            $newTransactionNumber = $lastTransaction ? (int) $lastTransaction->no_transaksi + 1 : 1;
            $formattedTransactionNumber = str_pad($newTransactionNumber, 7, '0', STR_PAD_LEFT);

            Transaksi::create([
                'kd_kasir' => '06',
                'no_transaksi' => $formattedTransactionNumber,
                'kd_pasien' => $finalNoRm,
                'kd_unit' => 3,
                'tgl_transaksi' => $tgl_masuk,
                'app' => 0,
                'ispay' => 0,
                'co_status' => 0,
                'urut_masuk' => 0,
                'kd_user' => $dokter_triase,
                'lunas' => 0,
            ]);

            // Simpan detail transaksi
            DetailTransaksi::create([
                'no_transaksi' => $formattedTransactionNumber,
                'kd_kasir' => '06',
                'tgl_transaksi' => $tgl_masuk,
                'urut' => 1,
                'kd_tarif' => 'TU',
                'kd_produk' => 3634,
                'kd_unit' => 3,
                'kd_unit_tr' => 3,
                'tgl_berlaku' => '2019-07-01',
                'kd_user' => $dokter_triase,
                'shift' => 0,
                'harga' => 15000,
                'qty' => 1,
                'flag' => 0,
                'jns_trans' => 0,
            ]);

            // Simpan detail_prsh
            DetailPrsh::create([
                'kd_kasir' => '06',
                'no_transaksi' => $formattedTransactionNumber,
                'urut' => 1,
                'tgl_transaksi' => $tgl_masuk,
                'hak' => 15000,
                'selisih' => 0,
                'disc' => 0,
            ]);

            // Simpan detail_component
            DetailComponent::create([
                'kd_kasir' => '06',
                'no_transaksi' => $formattedTransactionNumber,
                'tgl_transaksi' => $tgl_masuk,
                'urut' => 1,
                'kd_component' => '30',
                'tarif' => 15000,
                'disc' => 0,
            ]);

            // Simpan sjp_kunjungan
            SjpKunjungan::create([
                'kd_pasien' => $finalNoRm,
                'kd_unit' => 3,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => 0,
                'no_sjp' => '',
                'penjamin_laka' => 0,
                'katarak' => 0,
                'dpjp' => $dokter_triase,
                'cob' => 0,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}