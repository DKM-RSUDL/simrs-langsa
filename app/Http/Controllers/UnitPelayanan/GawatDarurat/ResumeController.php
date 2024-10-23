<?php

namespace App\Http\Controllers\UnitPelayanan\GawatDarurat;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\ICD9Baru;
use App\Models\Kunjungan;
use App\Models\MrResep;
use App\Models\Penyakit;
use App\Models\RMEResume;
use App\Models\RmeResumeDtl;
use App\Models\SegalaOrder;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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
        $dataResume = RMEResume::with(['listTindakanPasien.produk', 'rmeResumeDet', 'kunjungan'])
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

        // Mengambil semua data dokter
        $dataDokter = Dokter::all();

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
                'dataLabor',
                'dataRagiologi',
                'riwayatObatHariIni',
                'kodeICD',
                'kodeICD9',
                'dataResume',
                'dataGet'
            )
        );
    }

    public function update(Request $request, $kd_pasien, $tgl_masuk, $id)
    {
        $validator = Validator::make($request->all(), [
            'anamnesis' => 'required',
            'pemeriksaan_penunjang' => 'required',
            'diagnosis' => 'required|json',
            'icd_10' => 'required|json',
            'icd_9' => 'required|json',

            // RmeResumeDtl
            'tindak_lanjut_code' => 'required|string',
            'tindak_lanjut_name' => 'required|string'
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

        // Bersihkan data newline
        $newDiagnosis = $cleanArray($newDiagnosis);
        $newIcd10 = $cleanArray($newIcd10);
        $newIcd9 = $cleanArray($newIcd9);

        $data->update([
            'anamnesis' => $request->anamnesis,
            'pemeriksaan_penunjang' => $request->pemeriksaan_penunjang,
            'diagnosis' => $newDiagnosis,
            'icd_10' => $newIcd10,
            'icd_9' => $newIcd9,
            'status' => 1,
            'user_validasi' => Auth::id(),
        ]);

        $resumeDtl = RmeResumeDtl::updateOrCreate(
            [
                'id_resume' => $data->id
            ],
            [
                'tindak_lanjut_name' => $request->tindak_lanjut_name,
                'tindak_lanjut_code' => $request->tindak_lanjut_code
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
}
