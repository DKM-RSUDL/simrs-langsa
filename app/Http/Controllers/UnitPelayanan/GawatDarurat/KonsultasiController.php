<?php

namespace App\Http\Controllers\UnitPelayanan\GawatDarurat;

use App\Http\Controllers\Controller;
use App\Models\DetailComponent;
use App\Models\DetailPrsh;
use App\Models\DetailTransaksi;
use App\Models\Dokter;
use App\Models\DokterKlinik;
use App\Models\Konsultasi;
use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\RMEResume;
use App\Models\RmeResumeDtl;
use App\Models\RujukanKunjungan;
use App\Models\SjpKunjungan;
use App\Models\Transaksi;
use App\Models\Unit;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class KonsultasiController extends Controller
{
    public function index(Request $request, $kd_pasien, $tgl_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_unit', 3)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();


        $dokterPengirim = DokterKlinik::with(['dokter', 'unit'])
            ->where('kd_unit', 3)
            ->whereRelation('dokter', 'status', 1)
            ->get();

        $unit = Unit::where('kd_bagian', 2)
            ->where('aktif', 1)
            ->get();

        $periode = $request->input('periode');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $search = $request->input('search');
        $konsultasi = Konsultasi::with(['unit_tujuan', 'dokter_asal', 'unit_asal'])
            // filter data per periode to anas
            ->when($periode && $periode !== 'semua', function ($query) use ($periode) {
                $now = now();
                switch ($periode) {
                    case 'option1':
                        return $query->whereYear('tgl_masuk_tujuan', $now->year)
                            ->whereMonth('tgl_masuk_tujuan', $now->month);
                    case 'option2':
                        return $query->where('tgl_masuk_tujuan', '>=', $now->subMonth(1));
                    case 'option3':
                        return $query->where('tgl_masuk_tujuan', '>=', $now->subMonths(3));
                    case 'option4':
                        return $query->where('tgl_masuk_tujuan', '>=', $now->subMonths(6));
                    case 'option5':
                        return $query->where('tgl_masuk_tujuan', '>=', $now->subMonths(9));
                }
            })
            ->when($startDate, function ($query) use ($startDate) {
                return $query->whereDate('tgl_masuk_tujuan', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                return $query->whereDate('tgl_masuk_tujuan', '<=', $endDate);
            })
            // end filter data
            ->where('kd_pasien', $kd_pasien)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('kd_unit', 3)
            ->where('urut_masuk', $dataMedis->urut_masuk)
            // Filter pencarian to anas
            ->when($search, function ($query, $search) {
                $search = strtolower($search);

                if (is_numeric($search) && strlen($search) > 3) {
                    return $query->where('tgl_masuk_tujuan', $search);
                }
                return $query->where(function ($q) use ($search) {
                    $q->whereRaw('LOWER(tgl_masuk_tujuan) like ?', ["%$search%"])
                        ->orWhereHas('dokter_asal', function ($q) use ($search) {
                            $q->whereRaw('LOWER(nama_lengkap) like ?', ["%$search%"]);
                        })
                        ->orWhereHas('unit_tujuan', function ($q) use ($search) {
                            $q->whereRaw('LOWER(nama_unit) like ?', ["%$search%"]);
                        });
                });
            })
            ->get();


        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        return view(
            'unit-pelayanan.gawat-darurat.action-gawat-darurat.konsultasi.index',
            compact(
                'dataMedis',
                'dokterPengirim',
                'unit',
                'konsultasi'
            )
        );
    }

    public function getDokterbyUnit(Request $request)
    {
        try {
            $dokter = DokterKlinik::with(['dokter', 'unit'])
                ->where('kd_unit', $request->kd_unit)
                ->whereRelation('dokter', 'status', 1)
                ->get();

            if (count($dokter) > 0) {
                return response()->json([
                    'status'    => 'success',
                    'message'   => 'Data ditemukan',
                    'data'      => $dokter
                ]);
            } else {
                return response()->json([
                    'status'    => 'error',
                    'message'   => 'Data tidak ditemukan',
                    'data'      => []
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status'    => 'error',
                'message'   => $e->getMessage(),
                'data'      => []
            ], 500);
        }
    }

    public function storeKonsultasi($kd_pasien, $tgl_masuk, Request $request)
    {
        // Validation
        $msgErr = [
            'dokter_pengirim.required'      => 'Dokter pengirim harus dipilih!',
            'tgl_konsul.required'           => 'Tanggal konsul harus dipilih!',
            'tgl_konsul.date_format'        => 'Tanggal konsul harus format yang benar!',
            'jam_konsul.required'           => 'Jam konsul harus dipilih!',
            'jam_konsul.date_format'        => 'Jam konsul harus format yang benar!',
            'unit_tujuan.required'          => 'Unit tujuan harus dipilih!',
            'dokter_unit_tujuan.required'   => 'Dokter tujuan harus dipilih!',
            'konsulen_harap.required'       => 'Konsulen diharapkan harus dipilih!',
            'catatan.required'              => 'Catatan harus di isi!',
            'konsul.required'               => 'Konsul harus di isi!',
        ];

        $request->validate([
            'dokter_pengirim'       => 'required',
            'tgl_konsul'            => 'required|date_format:Y-m-d',
            'jam_konsul'            => 'required|date_format:H:i',
            'unit_tujuan'           => 'required',
            'dokter_unit_tujuan'    => 'required',
            'konsulen_harap'        => 'required',
            'catatan'               => 'required',
            'konsul'                => 'required',
        ], $msgErr);


        // get kunjungan
        $kunjungan = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', 3)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $request->urut_masuk)
            ->first();


        if (empty($kunjungan)) return back()->with('error', 'Kunjungan gagal terdeteksi sistem!');


        // Create New Kunjungan Tujuan

        // get request data
        $tgl_konsul = $request->tgl_konsul;
        $jam_konsul = $request->jam_konsul;
        $dokter_pengirim = $request->dokter_pengirim;
        $unit_tujuan = $request->unit_tujuan;
        $dokter_unit_tujuan = $request->dokter_unit_tujuan;
        $konsulen_harap = $request->konsulen_harap;
        $catatan = $request->catatan;
        $konsul = $request->konsul;

        // get antrian terakhir
        $getLastAntrian = Kunjungan::select('antrian')
            ->whereDate('tgl_masuk', $tgl_konsul)
            ->where('kd_unit', $unit_tujuan)
            ->orderBy('antrian', 'desc')
            ->first();

        $no_antrian = !empty($getLastAntrian) ? $getLastAntrian->antrian + 1 : 1;

        // pasien not null get last urut masuk
        $getLastUrutMasukPatient = Kunjungan::select('urut_masuk')
            ->where('kd_pasien', $kd_pasien)
            ->whereDate('tgl_masuk', $tgl_konsul)
            ->orderBy('urut_masuk', 'desc')
            ->first();

        $urut_masuk = !empty($getLastUrutMasukPatient) ? $getLastUrutMasukPatient->urut_masuk + 1 : 0;

        // insert ke tabel kunjungan
        $dataKunjungan = [
            'kd_pasien'         => $kd_pasien,
            'kd_unit'           => $unit_tujuan,
            'tgl_masuk'         => $tgl_konsul,
            'urut_masuk'        => $urut_masuk,
            'jam_masuk'         => $jam_konsul,
            'asal_pasien'       => 0,
            'cara_penerimaan'   => 99,
            'kd_rujukan'        => 1,
            'no_surat'          => '',
            'kd_dokter'         => $dokter_unit_tujuan,
            'baru'              => 1,
            'kd_customer'       => '0000000001',
            'shift'             => 0,
            'kontrol'           => 0,
            'antrian'           => $no_antrian,
            'tgl_surat'         => $tgl_konsul,
            'jasa_raharja'      => 0,
            'catatan'           => '',
            'is_rujukan'        => 1,
            'rujukan_ket'       => "Instalasi Gawat Darurat"
        ];

        Kunjungan::create($dataKunjungan);

        // delete rujukan_kunjungan
        RujukanKunjungan::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $unit_tujuan)
            ->whereDate('tgl_masuk', $tgl_konsul)
            ->where('urut_masuk', $urut_masuk)
            ->delete();


        // insert transaksi
        $lastTransaction = Transaksi::select('no_transaksi')
            ->where('kd_kasir', '01')
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
            'kd_kasir'      => '01',
            'no_transaksi'  => $formattedTransactionNumber,
            'kd_pasien'     => $kd_pasien,
            'kd_unit'       => $unit_tujuan,
            'tgl_transaksi' => $tgl_konsul,
            'app'           => 0,
            'ispay'         => 0,
            'co_status'     => 0,
            'urut_masuk'    => $urut_masuk,
            'kd_user'       => $dokter_pengirim, // nanti diambil dari user yang login
            'lunas'         => 0,
        ];

        Transaksi::create($dataTransaksi);


        // insert detail_transaksi
        $dataDetailTransaksi = [
            'no_transaksi'  => $formattedTransactionNumber,
            'kd_kasir'      => '01',
            'tgl_transaksi' => $tgl_konsul,
            'urut'          => 1,
            'kd_tarif'      => 'TU',
            'kd_produk'     => 3634,
            'kd_unit'       => $unit_tujuan,
            'kd_unit_tr'    => 3,
            'tgl_berlaku'   => '2019-07-01',
            'kd_user'       => $dokter_pengirim,
            'shift'         => 0,
            'harga'         => 15000,
            'qty'           => 1,
            'flag'          => 0,
            'jns_trans'     => 0,
        ];

        DetailTransaksi::create($dataDetailTransaksi);


        // insert detail_prsh
        $dataDetailPrsh = [
            'kd_kasir'      => '01',
            'no_transaksi'  => $formattedTransactionNumber,
            'urut'          => 1,
            'tgl_transaksi' => $tgl_konsul,
            'hak'           => 15000,
            'selisih'       => 0,
            'disc'          => 0
        ];

        DetailPrsh::create($dataDetailPrsh);


        // delete detail_component
        DetailComponent::where('kd_kasir', '01')
            ->where('no_transaksi', $formattedTransactionNumber)
            ->where('urut', 1)
            ->delete();


        // insert detail_component
        $dataDetailComponent = [
            'kd_kasir'      => '01',
            'no_transaksi'  => $formattedTransactionNumber,
            'tgl_transaksi' => $tgl_konsul,
            'urut'          => 1,
            'kd_component'  => '30',
            'tarif'         => 15000,
            'disc'          => 0
        ];

        DetailComponent::create($dataDetailComponent);

        // insert sjp_kunjungan
        $sjpKunjunganData = [
            'kd_pasien'     => $kd_pasien,
            'kd_unit'       => $unit_tujuan,
            'tgl_masuk'     => $tgl_konsul,
            'urut_masuk'    => $urut_masuk,
            'no_sjp'        => '',
            'penjamin_laka' => 0,
            'katarak'       => 0,
            'dpjp'          => $dokter_unit_tujuan,
            'cob'           => 0
        ];

        SjpKunjungan::create($sjpKunjunganData);


        // Insert konsultasi
        $getLastUrutKonsul = Konsultasi::select(['urut_konsul'])
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', 3)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $kunjungan->urut_masuk)
            ->orderBy('urut_konsul', 'desc')
            ->first();

        $urut_konsul = !empty($getLastUrutKonsul) ? $getLastUrutKonsul->urut_konsul + 1 : 1;

        $konsultasiData = [
            'kd_pasien'                 => $kd_pasien,
            'kd_unit'                   => 3,
            'tgl_masuk'                 => $tgl_masuk,
            'urut_masuk'                => $kunjungan->urut_masuk,
            'kd_pasien_tujuan'          => $kd_pasien,
            'kd_unit_tujuan'            => $unit_tujuan,
            'tgl_masuk_tujuan'          => $tgl_konsul,
            'urut_masuk_tujuan'         => $urut_masuk,
            'urut_konsul'               => $urut_konsul,
            'jam_masuk_tujuan'          => $jam_konsul,
            'kd_dokter'                 => $dokter_pengirim,
            'kd_dokter_tujuan'          => $dokter_unit_tujuan,
            'kd_konsulen_diharapkan'    => $konsulen_harap,
            'catatan'                   => $catatan,
            'konsul'                    => $konsul
        ];

        Konsultasi::create($konsultasiData);


        // create resume
        $resumeData = [
            'unit_rujuk_internal'   => $unit_tujuan,
        ];


        $this->createResume($kd_pasien, $tgl_masuk, $request->urut_masuk, $resumeData);

        return back()->with('success', 'Konsultasi berhasil di tambah!');
    }

    public function getKonsulAjax($kd_pasien, $tgl_masuk, Request $request)
    {
        try {
            // get konsultasi
            $konsultasi = Konsultasi::where('kd_pasien', $kd_pasien)
                ->where('kd_unit', 3)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $request->urut_masuk)
                ->where('kd_unit_tujuan', $request->kd_unit_tujuan)
                ->where('tgl_masuk_tujuan', $request->tgl_masuk_tujuan)
                ->where('jam_masuk_tujuan', $request->jam_masuk_tujuan)
                ->where('urut_konsul', $request->urut_konsul)
                ->first();

            $dokter = DokterKlinik::with(['dokter', 'unit'])
                ->where('kd_unit', $request->kd_unit_tujuan)
                ->whereRelation('dokter', 'status', 1)
                ->get();

            if (empty($konsultasi)) {
                return response()->json([
                    'status'    => 'error',
                    'message'   => 'Data konsultasi tidak ditemukan!',
                    'data'      => []
                ], 200);
            } else {
                return response()->json([
                    'status'    => 'success',
                    'message'   => 'Data konsultasi ditemukan',
                    'data'      => [
                        "konsultasi" => $konsultasi,
                        'dokter' => $dokter
                    ]
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'status'    => 'error',
                'message'   => $e->getMessage(),
                'data'      => []
            ], 500);
        }
    }

    public function updateKonsultasi($kd_pasien, $tgl_masuk, Request $request)
    {
        // Validation
        $msgErr = [
            'konsulen_harap.required'       => 'Konsulen diharapkan harus dipilih!',
            'catatan.required'              => 'Catatan harus di isi!',
            'konsul.required'               => 'Konsul harus di isi!',
        ];

        $request->validate([
            'konsulen_harap'        => 'required',
            'catatan'               => 'required',
            'konsul'                => 'required',
        ], $msgErr);


        // update konsul
        Konsultasi::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', 3)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $request->urut_masuk)
            ->where('kd_unit_tujuan', $request->old_kd_unit_tujuan)
            ->where('tgl_masuk_tujuan', $request->old_tgl_konsul)
            ->where('jam_masuk_tujuan', $request->old_jam_konsul)
            ->where('urut_konsul', $request->urut_konsul)
            ->update([
                'kd_konsulen_diharapkan'    => $request->konsulen_harap,
                'catatan'                   => $request->catatan,
                'konsul'                    => $request->konsul,
            ]);

        return back()->with('success', 'Konsultasi berhasil di ubah');
    }

    public function deleteKonsultasi($kd_pasien, $tgl_masuk, Request $request)
    {
        try {
            // get konsultasi
            $konsultasi = Konsultasi::where('kd_pasien', $kd_pasien)
                ->where('kd_unit', 3)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $request->urut_masuk)
                ->where('kd_unit_tujuan', $request->kd_unit_tujuan)
                ->where('tgl_masuk_tujuan', $request->tgl_masuk_tujuan)
                ->where('jam_masuk_tujuan', $request->jam_masuk_tujuan)
                ->where('urut_konsul', $request->urut_konsul)
                ->first();

            if (empty($konsultasi)) {
                return response()->json([
                    'status'    => 'error',
                    'message'   => 'Data konsultasi tidak ditemukan',
                    'data'      => []
                ], 200);
            }

            // delete kunjungan
            Kunjungan::where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $konsultasi->kd_unit_tujuan)
                ->where('tgl_masuk', $konsultasi->tgl_masuk_tujuan)
                ->where('urut_masuk', $konsultasi->urut_masuk_tujuan)
                ->delete();

            // delete transaksi
            Transaksi::where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $konsultasi->kd_unit_tujuan)
                ->where('tgl_transaksi', $konsultasi->tgl_masuk_tujuan)
                ->where('urut_masuk', $konsultasi->urut_masuk_tujuan)
                ->where('no_transaksi', $request->no_transaksi)
                ->delete();

            // delete detail transaksi
            DetailTransaksi::where('tgl_transaksi', $konsultasi->tgl_masuk_tujuan)
                ->where('no_transaksi', $request->no_transaksi)
                ->where('kd_kasir', '01')
                ->delete();

            // delete detail prsh
            DetailPrsh::where('tgl_transaksi', $konsultasi->tgl_masuk_tujuan)
                ->where('no_transaksi', $request->no_transaksi)
                ->where('kd_kasir', '01')
                ->delete();

            // delete detail component
            DetailComponent::where('tgl_transaksi', $konsultasi->tgl_masuk_tujuan)
                ->where('no_transaksi', $request->no_transaksi)
                ->where('kd_kasir', '01')
                ->delete();

            // delete konsultasi
            Konsultasi::where('kd_pasien', $kd_pasien)
                ->where('kd_unit', 3)
                ->whereDate('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $request->urut_masuk)
                ->where('kd_unit_tujuan', $request->kd_unit_tujuan)
                ->where('tgl_masuk_tujuan', $request->tgl_masuk_tujuan)
                ->where('jam_masuk_tujuan', $request->jam_masuk_tujuan)
                ->where('urut_konsul', $request->urut_konsul)
                ->delete();


            return response()->json([
                'status'    => 'success',
                'message'   => 'Konsultasi berhasil dihapus',
                'data'      => []
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status'    => 'error',
                'message'   => $e->getMessage(),
                'data'      => []
            ], 500);
        }
    }


    public function createResume($kd_pasien, $tgl_masuk, $urut_masuk, $data)
    {
        // get resume
        $resume = RMEResume::where('kd_pasien', $kd_pasien)
                        ->where('kd_unit', 3)
                        ->whereDate('tgl_masuk', $tgl_masuk)
                        ->where('urut_masuk', $urut_masuk)
                        ->first();

        $resumeDtlData = [
            'tindak_lanjut_code'    => 4,
            'tindak_lanjut_name'    => 'Konsul/Rujuk internal',
            'unit_rujuk_internal'   => $data['unit_rujuk_internal'],
        ];

        if(empty($resume)) {
            $resumeData = [
                'kd_pasien'     => $kd_pasien,
                'kd_unit'       => 3,
                'tgl_masuk'     => $tgl_masuk,
                'urut_masuk'    => $urut_masuk,
                'status'        => 0
            ];

            $newResume = RMEResume::create($resumeData);
            $newResume->refresh();

            // create resume detail
            $resumeDtlData['id_resume'] = $newResume->id;
            RmeResumeDtl::create($resumeDtlData);

        } else {
            // get resume dtl
            $resumeDtl = RmeResumeDtl::where('id_resume', $resume->id)->first();
            $resumeDtlData['id_resume'] = $resume->id;

            if(empty($resumeDtl)) {
                RmeResumeDtl::create($resumeDtlData);
            } else {
                $resumeDtl->tindak_lanjut_code  = 4;
                $resumeDtl->tindak_lanjut_name  = 'Konsul/Rujuk internal';
                $resumeDtl->unit_rujuk_internal = $data['unit_rujuk_internal'];
                $resumeDtl->save();
            }
        }
    }
}
