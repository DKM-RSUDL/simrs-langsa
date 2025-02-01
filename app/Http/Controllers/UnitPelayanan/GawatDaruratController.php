<?php

namespace App\Http\Controllers\UnitPelayanan;

use App\Http\Controllers\Controller;
use App\Models\DataTriase;
use App\Models\DetailComponent;
use App\Models\DetailPrsh;
use App\Models\DetailTransaksi;
use App\Models\Dokter;
use App\Models\DokterKlinik;
use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\RujukanKunjungan;
use App\Models\SjpKunjungan;
use App\Models\Transaksi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;

class GawatDaruratController extends Controller
{
    protected $roleService;
    public function index(Request $request)
    {
        $tglBatasData = date('Y-m-d', strtotime('-2 days', strtotime(date('Y-m-d'))));

        if ($request->ajax()) {
            $dokterFilter = $request->get('dokter');

            $data = Kunjungan::with(['pasien', 'dokter', 'customer'])
                ->where('kd_unit', 3)
                ->whereDate('tgl_masuk', '>=', $tglBatasData);

            // Filte dokter
            if (!empty($dokterFilter)) $data->where('kd_dokter', $dokterFilter);

            return DataTables::of($data)
                ->filter(function ($query) use ($request) {
                    if ($searchValue = $request->get('search')['value']) {
                        $query->where(function ($q) use ($searchValue) {
                            if (is_numeric($searchValue) && strlen($searchValue) == 4) {
                                $q->whereRaw("YEAR(kunjungan.tgl_masuk) = ?", [$searchValue]);
                            } elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $searchValue)) {
                                $q->whereRaw("CONVERT(varchar, kunjungan.tgl_masuk, 23) like ?", ["%{$searchValue}%"]);
                            } elseif (preg_match('/^\d{2}:\d{2}$/', $searchValue)) {
                                $q->whereRaw("FORMAT(kunjungan.jam_masuk, 'HH:mm') like ?", ["%{$searchValue}%"]);
                            } else {
                                $q->where('kunjungan.kd_pasien', 'like', "%{$searchValue}%")
                                    ->orWhereHas('pasien', function ($q) use ($searchValue) {
                                        $q->where('nama', 'like', "%{$searchValue}%")
                                            ->orWhere('alamat', 'like', "%{$searchValue}%");
                                    })
                                    ->orWhereHas('dokter', function ($q) use ($searchValue) {
                                        $q->where('nama_lengkap', 'like', "%{$searchValue}%");
                                    })
                                    ->orWhereHas('customer', function ($q) use ($searchValue) {
                                        $q->where('customer', 'like', "%{$searchValue}%");
                                    });
                            }
                        });
                    }
                })

                ->order(function ($query) {
                    $query->orderBy('tgl_masuk', 'desc')
                        ->orderBy('antrian', 'desc')
                        ->orderBy('urut_masuk', 'desc');
                })
                ->editColumn('tgl_masuk', fn($row) => date('Y-m-d', strtotime($row->tgl_masuk)) ?: '-')
                ->addColumn('triase', fn($row) => $row->kd_triase ?: '-')
                ->addColumn('bed', fn($row) => '' ?: '-')
                ->addColumn('no_rm', fn($row) => $row->kd_pasien ?: '-')
                ->addColumn('alamat', fn($row) =>  $row->pasien->alamat ?: '-')
                ->addColumn('jaminan', fn($row) =>  $row->customer->customer ?: '-')
                ->addColumn('instruksi', fn($row) => '' ?: '-')
                ->addColumn('kd_dokter', fn($row) => $row->dokter->nama ?: '-')
                ->addColumn('waktu_masuk', function ($row) {

                    $tglMasuk = Carbon::parse($row->tgl_masuk)->format('d M Y');
                    $jamMasuk = date('H:i', strtotime($row->jam_masuk));
                    return "$tglMasuk $jamMasuk";
                })
                // Hitung umur dari tabel pasien
                ->addColumn('umur', function ($row) {
                    return $row->pasien && $row->pasien->tgl_lahir
                        ? Carbon::parse($row->pasien->tgl_lahir)->age . ''
                        : 'Tidak diketahui';
                })
                ->addColumn('action', fn($row) => $row->kd_pasien)  // Return raw data, no HTML
                ->addColumn('del', fn($row) => $row->kd_pasien)     // Return raw data
                ->addColumn('profile', fn($row) => $row)
                ->rawColumns(['action', 'del', 'profile'])
                ->make(true);
        }

        $dokter = DokterKlinik::with(['dokter', 'unit'])
            ->where('kd_unit', 3)
            ->whereRelation('dokter', 'status', 1)
            ->get();

        return view('unit-pelayanan.gawat-darurat.index', compact('dokter',));
    }

    public function storeTriase(Request $request)
    {
        // validate data
        $messageErr = [
            'dokter_triase.required'    => 'Dokter harus dipilih!',
            'tgl_masuk.required'        => 'Tanggal masuk harus di isi!',
            'jam_masuk.required'        => 'Jam masuk harus di isi!',
            'nama_pasien.required'      => 'Nama pasien harus di isi!',
            'jenis_kelamin.required'    => 'Jenis kelamin harus di isi!',
            'rujukan.required'          => 'rujukan harus di pilih!',
            'usia_bulan.min'            => 'Usia bulan minimal 0!',
            'usia_bulan.max'            => 'Usia bulan maksimal 11!',
            'foto_pasien.image'         => 'Foto pasien harus file gambar!',
            'foto_pasien.max'           => 'Foto pasien maksimal 5 MB!'
        ];

        $request->validate([
            'dokter_triase'     => 'required',
            'tgl_masuk'         => 'required',
            'jam_masuk'         => 'required',
            'nama_pasien'       => 'required',
            'jenis_kelamin'     => 'required',
            'rujukan'           => 'required',
            'usia_bulan'        => 'nullable|min:0|max:11',
            'foto_pasien'       => 'nullable|image|file|max:5120',
        ], $messageErr);

        $no_rm = $request->no_rm ?? null;

        // get pasien
        $pasien = Pasien::where('kd_pasien', $no_rm)->first();

        // get request data
        $dokter_triase = $request->dokter_triase;
        $tgl_masuk = $request->tgl_masuk;
        $jam_masuk = $request->jam_masuk;
        $nama_pasien = $request->nama_pasien;
        $usia_tahun = $request->usia_tahun ?? 18;
        $usia_bulan = $request->usia_bulan ?? 5;
        $jenis_kelamin = !empty($pasien) ? $pasien->jenis_kelamin : $request->jenis_kelamin;
        $rujukan = $request->rujukan;
        $rujukan_ket = $request->rujukan_ket ?? null;
        $tanggal_lahir = Carbon::now()->subYears($usia_tahun)->subMonths($usia_bulan)->format('Y-m-d');
        $tanggal_lahir = !empty($pasien) ? date('Y-m-d', strtotime($pasien->tgl_lahir)) : $tanggal_lahir;
        $hasil_triase = $request->ket_triase;
        $kode_triase = $request->kd_triase;
        $dataTriase = [
            'hasil_triase'  => $hasil_triase,
            'kode_triase'   => $kode_triase,
            'air_way'       => $request->airway ?? null,
            'breathing'     => $request->breathing ?? null,
            'circulation'   => $request->circulation ?? null,
            'disability'    => $request->disability ?? null,
        ];

        // set new number
        $prefix = 'IGD-';
        $lastIgdNumber = Pasien::select('kd_pasien')
            ->where('kd_pasien', 'like', "$prefix%")
            ->orderBy('kd_pasien', 'desc')
            ->first();

        if (empty($lastIgdNumber)) {
            $lastIgdNumber = $prefix . '000001';
        } else {
            $lastIgdNumber = $lastIgdNumber->kd_pasien;
            $lastIgdNumber = explode('-', $lastIgdNumber);
            $lastIgdNumber = $lastIgdNumber[1];
            $lastIgdNumber = (int) $lastIgdNumber + 1;
            $lastIgdNumber = str_pad($lastIgdNumber, 6, '0', STR_PAD_LEFT);
            $lastIgdNumber = $prefix . $lastIgdNumber;
        }

        // ganti last ig number dgn kode pasien jika pasien ada
        if (!empty($pasien)) $lastIgdNumber = $pasien->kd_pasien;

        // upload foto pasien
        $pathFotoPasien = ($request->hasFile('foto_pasien')) ? $request->file('foto_pasien')->store('uploads/gawat-darurat/triase') : '';


        // insert ke tabel data_triase
        $dataTriase = [
            'nama_pasien'       => $nama_pasien,
            'usia'              => $usia_tahun,
            'usia_bulan'        => $usia_bulan,
            'jenis_kelamin'     => $jenis_kelamin,
            'tanggal_lahir'     => $tanggal_lahir,
            'status'            => 1,
            'kd_pasien'         => null,
            'kd_pasien_triase'  => $lastIgdNumber,
            'keterangan'        => null,
            'tanggal_triase'    => "$tgl_masuk $jam_masuk",
            'triase'            => json_encode($dataTriase),
            'hasil_triase'      => $hasil_triase,
            'dokter_triase'     => $dokter_triase,
            'kode_triase'       => $kode_triase,
            'foto_pasien'       => $pathFotoPasien
        ];

        DataTriase::create($dataTriase);


        // insert ke tabel pasien
        if (empty($pasien)) {
            $dataPasien = [
                'kd_pasien'         => $lastIgdNumber,
                'nama'              => $nama_pasien,
                'jenis_kelamin'     => $jenis_kelamin,
                'tempat_lahir'      => '',
                'tgl_lahir'         => $tanggal_lahir,
                'kd_agama'          => 0,
                'gol_darah'         => 0,
                'status_marita'     => 0,
                'alamat'            => '',
                'telepon'           => '',
                'kd_kelurahan'      => null,
                'kd_pendidikan'     => null,
                'kd_pekerjaan'      => 16, // lain-lain
                'no_pengenal'       => '',
                'no_asuransi'       => '',
                'pemegang_asuransi' => '',
                'jns_peserta'       => '',
                'wni'               => 0,
                'kd_suku'           => null,
                'tanda_pengenal'    => 0,
                'kd_pos'            => null,
                'nama_keluarga'     => '',
                'ibu_kandung'       => null,
                'kelas'             => null,
                'kd_bahasa'         => 0,
                'kd_cacat'          => 0,
                'email'             => '',
                'gelar_dpn'         => '',
                'gelar_blkg'        => '',
                'kd_negara'         => '',
                'tgl_pass'          => null,
            ];

            Pasien::create($dataPasien);
        }


        // get antrian terakhir
        $getLastAntrianToday = Kunjungan::select('antrian')
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('kd_unit', 3)
            ->orderBy('antrian', 'desc')
            ->first();

        $no_antrian = !empty($getLastAntrianToday) ? $getLastAntrianToday->antrian + 1 : 1;

        // pasien not null get last urut masuk
        $urut_masuk = 0;
        if (!empty($pasien)) {
            $getLastUrutMasukPatientToday = Kunjungan::select('urut_masuk')
                ->where('kd_pasien', $pasien->kd_pasien)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->orderBy('urut_masuk', 'desc')
                ->first();

            $urut_masuk = !empty($getLastUrutMasukPatientToday) ? $getLastUrutMasukPatientToday->urut_masuk + 1 : $urut_masuk;
        }

        // insert ke tabel kunjungan
        $dataKunjungan = [
            'kd_pasien'         => $lastIgdNumber,
            'kd_unit'           => 3,
            'tgl_masuk'         => $tgl_masuk,
            'urut_masuk'        => $urut_masuk,
            'jam_masuk'         => $jam_masuk,
            'asal_pasien'       => 0,
            'cara_penerimaan'   => 99,
            'kd_rujukan'        => 0,
            'no_surat'          => '',
            'kd_dokter'         => $dokter_triase, // jangan lupa ganti dengan dokter yang login
            'baru'              => 1,
            'kd_customer'       => '0000000001', // karena belum diketahui rm pasien maka penjaminnya adalah umum
            'shift'             => 0, // nanti diambil dari shift yang login
            'kontrol'           => 0,
            'antrian'           => $no_antrian,
            'tgl_surat'         => $tgl_masuk,
            'jasa_raharja'      => 0,
            'catatan'           => '',
            'kd_triase'         => $kode_triase,
            'is_rujukan'        => $rujukan,
            'rujukan_ket'       => $rujukan_ket
        ];

        Kunjungan::create($dataKunjungan);

        // delete rujukan_kunjungan
        RujukanKunjungan::where('kd_pasien', $lastIgdNumber)
            ->where('kd_unit', 3)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->delete();


        // insert transaksi
        $lastTransaction = Transaksi::select('no_transaksi')
            ->where('kd_unit', 3)
            ->where('kd_kasir', '06')
            ->orderBy('no_transaksi', 'desc')
            ->first();

        if ($lastTransaction) {
            $lastTransactionNumber = (int) $lastTransaction->no_transaksi;
            $newTransactionNumber = $lastTransactionNumber + 1;
        } else {
            $newTransactionNumber = 1;
        }

        // formatted new transaction number with 7 digits length
        $formattedTransactionNumber = str_pad($newTransactionNumber, 7, '0', STR_PAD_LEFT);

        $dataTransaksi = [
            'kd_kasir'      => '06',
            'no_transaksi'  => $formattedTransactionNumber,
            'kd_pasien'     => $lastIgdNumber,
            'kd_unit'       => 3,
            'tgl_transaksi' => $tgl_masuk,
            'app'           => 0,
            'ispay'         => 0,
            'co_status'     => 0,
            'urut_masuk'    => $urut_masuk,
            'kd_user'       => $dokter_triase, // nanti diambil dari user yang login
            'lunas'         => 0,
        ];

        Transaksi::create($dataTransaksi);


        // insert detail_transaksi
        $dataDetailTransaksi = [
            'no_transaksi'  => $formattedTransactionNumber,
            'kd_kasir'      => '06',
            'tgl_transaksi' => $tgl_masuk,
            'urut'          => 1,
            'kd_tarif'      => 'TU',
            'kd_produk'     => 3634,
            'kd_unit'       => 3,
            'kd_unit_tr'    => 3,
            'tgl_berlaku'   => '2019-07-01',
            'kd_user'       => $dokter_triase,
            'shift'         => 0,
            'harga'         => 15000,
            'qty'           => 1,
            'flag'          => 0,
            'jns_trans'     => 0,
        ];

        DetailTransaksi::create($dataDetailTransaksi);


        // insert detail_prsh
        $dataDetailPrsh = [
            'kd_kasir'      => '06',
            'no_transaksi'  => $formattedTransactionNumber,
            'urut'          => 1,
            'tgl_transaksi' => $tgl_masuk,
            'hak'           => 15000,
            'selisih'       => 0,
            'disc'          => 0
        ];

        DetailPrsh::create($dataDetailPrsh);


        // delete detail_component
        DetailComponent::where('kd_kasir', '06')
            ->where('no_transaksi', $formattedTransactionNumber)
            ->where('urut', 1)
            ->delete();


        // insert detail_component
        $dataDetailComponent = [
            'kd_kasir'      => '06',
            'no_transaksi'  => $formattedTransactionNumber,
            'tgl_transaksi' => $tgl_masuk,
            'urut'          => 1,
            'kd_component'  => '30',
            'tarif'         => 15000,
            'disc'          => 0
        ];

        DetailComponent::create($dataDetailComponent);

        // insert sjp_kunjungan
        $sjpKunjunganData = [
            'kd_pasien'     => $lastIgdNumber,
            'kd_unit'       => 3,
            'tgl_masuk'     => $tgl_masuk,
            'urut_masuk'    => $urut_masuk,
            'no_sjp'        => '',
            'penjamin_laka' => 0,
            'katarak'       => 0,
            'dpjp'          => $dokter_triase,
            'cob'           => 0
        ];

        SjpKunjungan::create($sjpKunjunganData);

        return back()->with('success', 'Data triase berhasil ditambah');
    }

    public function getPatientByNikAjax(Request $request)
    {
        try {
            $pasien = Pasien::where('no_pengenal', $request->nik)
                ->first();

            if (empty($pasien)) {
                return response()->json([
                    'status'    => 'error',
                    'message'   => 'Data tidak ditemukan',
                    'data'      => []
                ], 200);
            } else {
                return response()->json([
                    'status'    => 'success',
                    'message'   => 'Data ditemukan',
                    'data'      => $pasien
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'status'    => 'error',
                'message'   => $e->getMessage(),
                'data'      => []
            ] . 500);
        }
    }

    public function rujukAntarRs($kd_pasien, $tgl_masuk, $urut_masuk)
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

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.rujuk-antar-rs.index', compact('dataMedis'));
    }
}