<?php

namespace App\Http\Controllers\UnitPelayanan\GawatDarurat;

use App\Http\Controllers\Controller;
use App\Models\DetailComponent;
use App\Models\DetailPrsh;
use App\Models\DetailTransaksi;
use App\Models\Dokter;
use App\Models\DokterKlinik;
use App\Models\ICD9Baru;
use App\Models\Konsultasi;
use App\Models\Kunjungan;
use App\Models\Penyakit;
use App\Models\RMEResume;
use App\Models\RmeResumeDtl;
use App\Models\RujukanKunjungan;
use App\Models\SegalaOrder;
use App\Models\Transaksi;
use App\Models\Unit;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ResumeController extends Controller
{
    public function index(Request $request, $kd_pasien, $tgl_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien.golonganDarah', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', 3)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        // ambil data Resume
        $dataResume = RMEResume::with(['listTindakanPasien.produk', 'rmeResumeDet.unitRujukanInternal', 'kunjungan', 'unit', 'konsultasi'])
            ->where('kd_pasien', $kd_pasien)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->where('kd_unit', 3)
            ->orderBy('tgl_masuk', 'desc')
            ->first();

        $search = $request->input('search');
        $periode = $request->input('periode');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $dataGet = RMEResume::with(['rmeResumeDet', 'kunjungan.dokter', 'unit'])
            // filter data
            ->when($periode, function ($query) use ($periode) {
                $now = now();
                switch ($periode) {
                    case 'option1':
                        return $query->whereYear('tgl_masuk', $now->year)
                            ->whereMonth('tgl_masuk', $now->month);
                    case 'option2':
                        return $query->where('tgl_masuk', '>=', $now->subMonth(1));
                    case 'option3':
                        return $query->where('tgl_masuk', '>=', $now->subMonths(3));
                    case 'option4':
                        return $query->where('tgl_masuk', '>=', $now->subMonths(6));
                    case 'option5':
                        return $query->where('tgl_masuk', '>=', $now->subMonths(9));
                    default:
                        return $query;
                }
            })
            ->when($startDate, function ($query) use ($startDate) {
                return $query->whereDate('tgl_masuk', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                return $query->whereDate('tgl_masuk', '<=', $endDate);
            })
            ->when($search, function ($query, $search) {
                $search = strtolower($search);
                return $query->orWhereHas('kunjungan.dokter', function ($q) use ($search) {
                    $q->whereRaw('LOWER(kd_dokter) like ?', ["%$search%"])
                        ->orWhereRaw('LOWER(nama_lengkap) like ?', ["%$search%"]);
                });
            })
            // end filter
            ->where('kd_pasien', $kd_pasien)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->where('kd_unit', $dataMedis->kd_unit)
            ->orderBy('tgl_masuk', 'desc')
            ->paginate(10);

        // Ambil semua dokter
        $dataDokter = DokterKlinik::with(['dokter', 'unit'])
            ->where('kd_unit', 3)
            ->whereRelation('dokter', 'status', 1)
            ->get();

        // Ambil dokter yang aktif saat ini
        $dokterPengirim = DokterKlinik::with(['dokter', 'unit'])
            ->where('kd_unit', 3)
            ->whereRelation('dokter', 'status', 1)
            ->first();

        // // Mengambil data hasil pemeriksaan laboratorium
        $dataLabor = SegalaOrder::with(['details.produk', 'produk.labHasil'])
            ->where('kd_pasien', $kd_pasien)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->where('kd_unit', $dataMedis->kd_unit)
            ->whereHas('details.produk', function ($query) {
                $query->where('kategori', 'LB');
            })
            ->orderBy('tgl_order', 'desc')
            ->get();


        // Mengambil data hasil pemeriksaan radiologi
        $dataRagiologi = SegalaOrder::with(['details.produk'])
            ->where('kd_pasien', $kd_pasien)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->where('kd_unit', $dataMedis->kd_unit)
            ->whereHas('details.produk', function ($query) {
                $query->where('kategori', 'RD');
            })
            ->orderBy('tgl_order', 'desc')
            ->get();

        // Kode ICD 10 (Koder)
        $kodeICD = Penyakit::all();
        // Kode ICD-9 CM (Koder)
        $kodeICD9 = ICD9Baru::all();

        // Mengambil data obat
        $riwayatObatHariIni = $this->getRiwayatObatHariIni($kd_pasien, $tgl_masuk);

        // unit palayanan
        $unitKonsul = Unit::where('kd_bagian', 2)
            ->where('aktif', 1)
            ->get();

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        return view(
            'unit-pelayanan.gawat-darurat.action-gawat-darurat.resume.index',
            compact(
                'dataMedis',
                'dataDokter',
                'dokterPengirim',
                'dataLabor',
                'dataRagiologi',
                'riwayatObatHariIni',
                'kodeICD',
                'kodeICD9',
                'dataResume',
                'dataGet',
                'unitKonsul'
            )
        );
    }

    public function getOrderDetails($kdOrder, $kdPasien)
    {
        $result = SegalaOrder::query()
            ->select([
                'SEGALA_ORDER.kd_order',
                'SEGALA_ORDER.kd_pasien',
                'SEGALA_ORDER.tgl_order',
                'SEGALA_ORDER_DET.kd_produk',
                'PRODUK.deskripsi as nama_produk',
                'SEGALA_ORDER_DET.jumlah',
                'SEGALA_ORDER_DET.status',
                'LAB_HASIL.hasil as hasil_lab'
            ])
            ->join('SEGALA_ORDER_DET', 'SEGALA_ORDER.kd_order', '=', 'SEGALA_ORDER_DET.kd_order')
            ->join('PRODUK', 'SEGALA_ORDER_DET.kd_produk', '=', 'PRODUK.kd_produk')
            ->join('LAB_HASIL', function ($join) {
                $join->on('SEGALA_ORDER_DET.kd_produk', '=', 'LAB_HASIL.kd_produk')
                    ->on('SEGALA_ORDER.kd_pasien', '=', 'LAB_HASIL.kd_pasien');
            })
            ->whereRaw('CAST(SEGALA_ORDER.kd_order AS VARCHAR) = ?', [$kdOrder])
            ->whereRaw('CAST(SEGALA_ORDER.kd_pasien AS VARCHAR) = ?', [$kdPasien])
            ->get();

        return $result;
    }

    // Controller
    public function store(Request $request, $kd_pasien, $tgl_masuk)
    {
        try {
            // Validate request
            $validated = $request->validate([
                'dokter_pengirim' => 'required',
                'dokter_unit_tujuan' => 'required',
                'tgl_konsul' => 'required|date',
                'jam_konsul' => 'required',
                'unit_tujuan' => 'required',
                'konsulen_harap' => 'required|in:1,2,3,4',
                'catatan' => 'nullable',
                'konsul' => 'nullable'
            ]);

            $data = [
                'tgl_konsul' => $request->tgl_konsul,
                'jam_konsul' => $request->jam_konsul,
                'dokter_pengirim' => $request->dokter_pengirim,
                'unit_tujuan' => $request->unit_tujuan,
                'dokter_unit_tujuan' => $request->dokter_unit_tujuan,
                'konsulen_harap' => $request->konsulen_harap,
                'catatan' => $request->catatan,
                'konsul' => $request->konsul
            ];

            // Call storeKonsultasi dengan urut_masuk dari request
            $result = $this->storeKonsultasi($kd_pasien, $tgl_masuk, $request->urut_masuk, $data);

            if ($result) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data konsultasi berhasil disimpan'
                ], 200);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan data konsultasi'
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $kd_pasien, $tgl_masuk, $id)
    {
        $validator = Validator::make($request->all(), [
            'anamnesis' => 'required',
            'pemeriksaan_penunjang' => 'required',
            'diagnosis' => 'required|json',
            'icd_10' => 'required|json',
            'icd_9' => 'required|json',
            'alergi' => 'nullable|json',

            // RmeResumeDtl
            'tindak_lanjut_code' => 'required|string',
            'tindak_lanjut_name' => 'required|string',
            'tgl_kontrol_ulang' => 'nullable|string',
            'rs_rujuk' => 'nullable|string',
            'rs_rujuk_bagian' => 'nullable|string',
            'unit_rujuk_internal' => 'nullable|string',
            'unit_rawat_inap' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = RMEResume::where('kd_pasien', $kd_pasien)
            ->where('tgl_masuk', $tgl_masuk)
            ->findOrFail($id);

        // newline
        $cleanArray = function ($array) {
            return array_map(function ($item) {
                return trim(preg_replace('/\s+/', ' ', $item));
            }, $array);
        };

        // Data baru
        $newDiagnosis = json_decode($request->diagnosis, true);
        $newIcd10 = json_decode($request->icd_10, true);
        $newIcd9 = json_decode($request->icd_9, true);
        $newAlergi = json_decode($request->alergi, true);

        // Bersihkan data newline
        $newDiagnosis = $cleanArray($newDiagnosis);
        $newIcd10 = $cleanArray($newIcd10);
        $newIcd9 = $cleanArray($newIcd9);
        $newAlergi = $cleanArray($newAlergi);

        $data->update([
            'anamnesis' => $request->anamnesis,
            'pemeriksaan_penunjang' => $request->pemeriksaan_penunjang,
            'diagnosis' => $newDiagnosis,
            'icd_10' => $newIcd10,
            'icd_9' => $newIcd9,
            'alergi' => $newAlergi,
            'status' => 1,
            'user_validasi' => Auth::id(),
        ]);

        $resumeDtl = RmeResumeDtl::updateOrCreate(
            [
                'id_resume' => $data->id
            ],
            [
                'tindak_lanjut_name' => $request->tindak_lanjut_name,
                'tindak_lanjut_code' => $request->tindak_lanjut_code,
                'tgl_kontrol_ulang' => $request->tgl_kontrol_ulang,
                'rs_rujuk' => $request->rs_rujuk,
                'rs_rujuk_bagian' => $request->rs_rujuk_bagian,
                'unit_rujuk_internal' => $request->unit_rujuk_internal,
                'unit_rawat_inap' => $request->unit_rawat_inap
            ]
        );



        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diperbarui',
            'data' => [
                'resume' => $data,
                'resume_detail' => $resumeDtl
            ]
        ]);
    }


    private function getRiwayatObatHariIni($kd_pasien, $tgl_masuk)
    {
        $today = Carbon::today()->toDateString();

        return DB::table('MR_RESEP')
            ->join('DOKTER', 'MR_RESEP.KD_DOKTER', '=', 'DOKTER.KD_DOKTER')
            ->leftJoin('MR_RESEPDTL', 'MR_RESEP.ID_MRRESEP', '=', 'MR_RESEPDTL.ID_MRRESEP')
            ->leftJoin('APT_OBAT', 'MR_RESEPDTL.KD_PRD', '=', 'APT_OBAT.KD_PRD')
            ->leftJoin('APT_SATUAN', 'APT_OBAT.KD_SATUAN', '=', 'APT_SATUAN.KD_SATUAN')
            ->where('MR_RESEP.KD_PASIEN', $kd_pasien)
            ->whereDate('MR_RESEP.TGL_ORDER', $today)
            ->select(
                'MR_RESEP.TGL_ORDER',
                'DOKTER.NAMA as NAMA_DOKTER',
                'MR_RESEP.ID_MRRESEP',
                'MR_RESEP.STATUS',
                'MR_RESEPDTL.CARA_PAKAI',
                'MR_RESEPDTL.JUMLAH',
                'MR_RESEPDTL.KET',
                'MR_RESEPDTL.JUMLAH_TAKARAN',
                'MR_RESEPDTL.SATUAN_TAKARAN',
                'APT_OBAT.NAMA_OBAT'
            )
            ->distinct()
            ->orderBy('MR_RESEP.TGL_ORDER', 'desc')
            ->get();
    }

    public function storeKonsultasi($kd_pasien, $tgl_masuk, $urut_masuk, $data)
    {
        // Create New Kunjungan Tujuan

        // get request data
        $tgl_konsul = $data['tgl_konsul'];
        $jam_konsul = $data['jam_konsul'];
        $dokter_pengirim = $data['dokter_pengirim'];
        $unit_tujuan = $data['unit_tujuan'];
        $dokter_unit_tujuan = $data['dokter_unit_tujuan'];
        $konsulen_harap = $data['konsulen_harap'];
        $catatan = $data['catatan'];
        $konsul = $data['konsul'];

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

        // jangan lupa tambahkan insert into sjp_kunjungan


        // Insert konsultasi
        $getLastUrutKonsul = Konsultasi::select(['urut_konsul'])
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', 3)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->orderBy('urut_konsul', 'desc')
            ->first();

        $urut_konsul = !empty($getLastUrutKonsul) ? $getLastUrutKonsul->urut_konsul + 1 : 1;

        $konsultasiData = [
            'kd_pasien'                 => $kd_pasien,
            'kd_unit'                   => 3,
            'tgl_masuk'                 => $tgl_masuk,
            'urut_masuk'                => $urut_masuk,
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

        return true;
    }
}
