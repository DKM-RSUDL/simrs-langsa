<?php

namespace App\Http\Controllers\UnitPelayanan\RawatJalan;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\DokterKlinik;
use App\Models\ICD9Baru;
use App\Models\Kunjungan;
use App\Models\Penyakit;
use App\Models\RMEResume;
use App\Models\RmeResumeDtl;
use App\Models\SegalaOrder;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RawatJalanResumeController extends Controller
{
    public function index(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien.golonganDarah', 'dokter', 'customer', 'unit'])
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

        // ambil data Resume
        $dataResume = RMEResume::with(['listTindakanPasien.produk', 'rmeResumeDet', 'kunjungan', 'konsultasi'])
            ->where('kd_pasien', $kd_pasien)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->where('kd_unit', $dataMedis->kd_unit)
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
            ->where('tgl_masuk', $dataMedis->tgl_masuk)
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
        $dokterPengirim = DokterKlinik::with(['konsultasi' => function ($query) {
            $query->with('dokter');
        }])
            ->where('kd_unit', 3)
            ->whereRelation('dokter', 'status', 1)
            ->first();

        // Mengambil data hasil pemeriksaan laboratorium
        $dataLabor = SegalaOrder::with(['details.produk'])
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
            'unit-pelayanan.rawat-jalan.pelayanan.resume.index',
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

    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'anamnesis' => 'required|string',
                'pemeriksaan_penunjang' => 'required|string',
                'diagnosis' => 'required|json',
                'icd_10' => 'required|json',
                'icd_9' => 'required|json',
                'alergi' => 'nullable|json',
                'tindak_lanjut_code' => 'required',
                'tindak_lanjut_name' => 'required',
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

            $resume = RMEResume::where('id', $id)
                ->where('kd_pasien', $kd_pasien)
                ->first();

            // newline
            $cleanArray = function ($array) {
                return array_map(function ($item) {
                    return trim(preg_replace('/\s+/', ' ', $item));
                }, $array);
            };

            if (!$resume) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Data resume tidak ditemukan'
                ], 404);
            }

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

            $resume->update([
                'anamnesis' => trim($request->anamnesis),
                'pemeriksaan_penunjang' => trim($request->pemeriksaan_penunjang),
                'diagnosis' => $newDiagnosis,
                'icd_10' => $newIcd10,
                'icd_9' => $newIcd9,
                'alergi' => $newAlergi,
                'status' => 1,
                'user_validasi' => Auth::id()
            ]);

            RmeResumeDtl::updateOrCreate(
                ['id_resume' => $id],
                [
                    'tindak_lanjut_name' => trim($request->tindak_lanjut_name),
                    'tindak_lanjut_code' => $request->tindak_lanjut_code,
                    'tgl_kontrol_ulang' => $request->tgl_kontrol_ulang,
                    'rs_rujuk' => $request->rs_rujuk,
                    'rs_rujuk_bagian' => $request->rs_rujuk_bagian,
                    'unit_rujuk_internal' => $request->unit_rujuk_internal,
                    'unit_rawat_inap' => $request->unit_rawat_inap
                ]
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diperbarui',
                'data' => $resume
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui data'
            ], 500);
        }
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
}
