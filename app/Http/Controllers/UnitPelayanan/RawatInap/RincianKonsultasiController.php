<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\DokterKlinik;
use App\Models\Konsultasi;
use App\Models\ListTindakanPasien;
use App\Models\Produk;
use App\Services\BaseService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class RincianKonsultasiController extends Controller
{
    private $baseService;
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
        $this->baseService = new BaseService();
    }

    public function getKlasProdukCodeByUnit($kd_unit)
    {
        $code = '';

        switch ($kd_unit) {
            case '201':
                $code = '6401';
                break;
            case '202':
                $code = '6402';
                break;
            case '203':
                $code = '6403';
                break;
            case '204':
                $code = '6404';
                break;
            case '205':
                $code = '6405';
                break;
            case '206':
                $code = '6406';
                break;
            case '207':
                $code = '6407';
                break;
            case '208':
                $code = '6408';
                break;
            case '209':
                $code = '6410';
                break;
            case '210':
                $code = '6411';
                break;
            case '211':
                $code = '6412';
                break;
            case '212':
                $code = '6413';
                break;
            case '213':
                $code = '6414';
                break;
            case '214':
                $code = '6415';
                break;
            case '215':
                $code = '';
                break;
            case '216':
                $code = '6416';
                break;
            case '217':
                $code = '6417';
                break;
            case '218':
                $code = '6410';
                break;
            case '219':
                $code = '6418';
                break;
            case '220':
                $code = '';
                break;
            case '221':
                $code = '6419';
                break;
            case '222':
                $code = '6420';
                break;
            case '223':
                $code = '6421';
                break;
            case '224':
                $code = '6423';
                break;
            case '225':
                $code = '6410';
                break;
            case '226':
                $code = '6424';
                break;
            case '227':
                $code = '6417';
                break;
            case '228':
                $code = '';
                break;
            case '229':
                $code = '6426';
                break;
            case '230':
                $code = '6425';
                break;
            case '231':
                $code = '6428';
                break;
            case '232':
                $code = '6427';
                break;
            case '233':
                $code = '';
                break;
            case '234':
                $code = '6429';
                break;
            case '235':
                $code = '6408';
                break;
        }

        return $code;
    }

    public function indexTindakan(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $kd_unit_tujuan, $kd_pasien_tujuan, $tgl_masuk_tujuan, $jam_masuk_tujuan, $urut_konsul)
    {
        $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
        if (!$dataMedis) {
            abort(404, 'Data medis tidak ditemukan.');
        }

        $konsultasi = Konsultasi::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->where('kd_pasien_tujuan', $kd_pasien_tujuan)
            ->where('kd_unit_tujuan', $kd_unit_tujuan)
            ->where('tgl_masuk_tujuan', $tgl_masuk_tujuan)
            ->where('jam_masuk_tujuan', $jam_masuk_tujuan)
            ->where('urut_konsul', $urut_konsul)
            ->first();

        $klasProdukCode = $this->getKlasProdukCodeByUnit($kd_unit);

        $produk = Produk::select([
            'klas_produk.kd_klas',
            'produk.kd_produk',
            'produk.kp_produk',
            'produk.deskripsi',
            'tarif.kd_tarif',
            'tarif.tarif',
            'tarif.kd_unit',
            'tarif.tgl_berlaku'
        ])
            ->join('tarif', 'produk.kd_produk', '=', 'tarif.kd_produk')
            ->join('tarif_cust', 'tarif.kd_tarif', '=', 'tarif_cust.kd_tarif')
            ->join('klas_produk', 'klas_produk.kd_klas', '=', 'produk.kd_klas')
            ->whereIn('tarif.kd_unit', [$kd_unit])
            ->where('klas_produk.kd_klas', $klasProdukCode)
            ->where('tarif.kd_tarif', 'TU')
            ->where(function ($query) {
                $query->whereNull('tarif.Tgl_Berakhir')
                    ->orWhere('tarif.Tgl_Berakhir', '>=', Carbon::now()->toDateString());
            })
            ->where('tarif.tgl_berlaku', '<=', Carbon::now()->toDateString())
            ->whereIn('tarif.tgl_berlaku', function ($query) {
                $query->select('tgl_berlaku')
                    ->from('tarif as t')
                    ->whereColumn('t.KD_PRODUK', 'tarif.kd_produk')
                    ->whereColumn('t.KD_TARIF', 'tarif.kd_tarif')
                    ->whereColumn('t.KD_UNIT', 'tarif.kd_unit')
                    ->where(function ($q) {
                        $q->whereNull('t.Tgl_Berakhir')
                            ->orWhere('t.Tgl_Berakhir', '>=', Carbon::now()->toDateString());
                    })
                    ->orderBy('t.tgl_berlaku', 'asc')
                    ->limit(1);
            })
            ->orderBy('tarif.TGL_BERLAKU', 'desc')
            ->distinct()
            ->get();


        $periode = $request->input('periode');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $search = $request->input('search');
        $tindakan = ListTindakanPasien::with(['produk', 'ppa', 'unit'])
            // filter data per periode to anas
            ->when($periode && $periode !== 'semua', function ($query) use ($periode) {
                $now = now();
                switch ($periode) {
                    case 'option1':
                        return $query->whereYear('tgl_tindakan', $now->year)
                            ->whereMonth('tgl_tindakan', $now->month);
                    case 'option2':
                        return $query->where('tgl_tindakan', '>=', $now->subMonth(1));
                    case 'option3':
                        return $query->where('tgl_tindakan', '>=', $now->subMonths(3));
                    case 'option4':
                        return $query->where('tgl_tindakan', '>=', $now->subMonths(6));
                    case 'option5':
                        return $query->where('tgl_tindakan', '>=', $now->subMonths(9));
                }
            })
            ->when($startDate, function ($query) use ($startDate) {
                return $query->whereDate('tgl_tindakan', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                return $query->whereDate('tgl_tindakan', '<=', $endDate);
            })
            // end filter data
            ->where('kd_pasien', $konsultasi->kd_pasien_tujuan)
            ->where('tgl_masuk', $konsultasi->tgl_masuk_tujuan)
            ->where('kd_unit', $konsultasi->kd_unit_tujuan)
            ->where('urut_masuk', $konsultasi->urut_masuk_tujuan)
            // Filter pencarian to anas
            ->when($search, function ($query, $search) {
                $search = strtolower($search);

                if (is_numeric($search) && strlen($search) > 3) {
                    return $query->where('tgl_tindakan', $search);
                }
                return $query->where(function ($q) use ($search) {
                    $q->whereRaw('LOWER(tgl_tindakan) like ?', ["%$search%"])
                        ->orWhereHas('ppa', function ($q) use ($search) {
                            $q->whereRaw('LOWER(nama_lengkap) like ?', ["%$search%"]);
                        })
                        ->orWhereHas('produk', function ($q) use ($search) {
                            $q->whereRaw('LOWER(deskripsi) like ?', ["%$search%"]);
                        });
                });
            })
            ->get();


        $dokter = DokterKlinik::with(['dokter', 'unit'])
            ->where('kd_unit', $kd_unit)
            ->whereRelation('dokter', 'status', 1)
            ->get();

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }
        return view('unit-pelayanan.rawat-inap.pelayanan.konsultasi.rincian.tindakan.index', compact(
            'dataMedis',
            'dokter',
            'produk',
            'tindakan',
            'kd_unit_tujuan',
            'kd_pasien_tujuan',
            'tgl_masuk_tujuan',
            'jam_masuk_tujuan',
            'urut_konsul'
        ));
    }
}