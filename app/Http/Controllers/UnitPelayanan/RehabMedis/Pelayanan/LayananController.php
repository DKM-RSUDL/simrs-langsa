<?php

namespace App\Http\Controllers\UnitPelayanan\RehabMedis\Pelayanan;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Produk;
use App\Models\RmeRehabMedikLayanan;
use App\Models\RmeRehabMedikProgramDetail;
use App\Models\RmeRehabMedikTindakan;
use App\Services\BaseService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LayananController extends Controller
{
    private int $kdUnitDef_;
    private BaseService $baseService;

    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rehab-medis');
        $this->kdUnitDef_ = 74;
        $this->baseService = new BaseService();
    }

    public function index(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->baseService->getDataMedis($this->kdUnitDef_, $kd_pasien, $tgl_masuk, $urut_masuk);
        if (!$dataMedis) abort(404, 'Data tidak ditemukan');

        $layanan  = $this->layananList($kd_pasien, $tgl_masuk, $urut_masuk); // now includes relasi dokter
        $tindakan = $this->tindakanList($kd_pasien, $tgl_masuk, $urut_masuk);
        $programs = collect();

        return view('unit-pelayanan.rehab-medis.pelayanan.terapi.index', compact('dataMedis', 'layanan', 'programs', 'tindakan'));
    }

    public function create($kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->baseService->getDataMedis($this->kdUnitDef_, $kd_pasien, $tgl_masuk, $urut_masuk);
        if (!$dataMedis) abort(404, 'Data tidak ditemukan');

        $produk = $this->getProdukTarifRehabMedis();
        $dokter = $this->getActiveDokter();

        return view('unit-pelayanan.rehab-medis.pelayanan.terapi.pelayanan-medis.create', compact('dataMedis', 'produk', 'dokter'));
    }

    public function store($kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        DB::beginTransaction();
        try {
            $dataMedis = $this->baseService->getDataMedis($this->kdUnitDef_, $kd_pasien, $tgl_masuk, $urut_masuk);
            if (!$dataMedis) abort(404, 'Data tidak ditemukan');

            $layanan = new RmeRehabMedikLayanan();
            $layanan->kd_pasien     = $kd_pasien;
            $layanan->kd_unit       = $this->kdUnitDef_;
            $layanan->tgl_masuk     = $tgl_masuk;
            $layanan->urut_masuk    = $urut_masuk;
            $layanan->tgl_pelayanan = $request->tgl_pelayanan;
            $layanan->jam_pelayanan = $request->jam_pelayanan;
            $layanan->kd_dokter     = $request->dokter;
            $layanan->subjective    = $request->subjective;
            $layanan->objective     = $request->objective;
            $layanan->assessment    = $request->assessment;
            $layanan->user_create   = Auth::id();
            $layanan->save();

            $programs = $this->parseProgramsFromRequest($request);
            $this->createProgramDetails($layanan->id, $programs);

            DB::commit();
            return to_route('rehab-medis.pelayanan.terapi', [$kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Layanan berhasil ditambah !');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataMedis = $this->baseService->getDataMedis($this->kdUnitDef_, $kd_pasien, $tgl_masuk, $urut_masuk);
        if (!$dataMedis) abort(404, 'Data tidak ditemukan');

        $layanan = RmeRehabMedikLayanan::find($id);
        if (!$layanan) abort(404, 'Data layanan tidak ditemukan !');

        $produk = $this->getProdukTarifRehabMedis();
        $programDetails = RmeRehabMedikProgramDetail::with(['produk'])
            ->where('id_layanan', $layanan->id)->get();
        $program = (object) ['detail' => $programDetails];

        $dokter = $this->getActiveDokter();

        return view('unit-pelayanan.rehab-medis.pelayanan.terapi.pelayanan-medis.edit', compact('dataMedis', 'layanan', 'produk', 'program', 'dokter'));
    }

    public function update($kd_pasien, $tgl_masuk, $urut_masuk, $idEncrypt, Request $request)
    {
        DB::beginTransaction();
        try {
            $dataMedis = $this->baseService->getDataMedis($this->kdUnitDef_, $kd_pasien, $tgl_masuk, $urut_masuk);
            if (!$dataMedis) abort(404, 'Data tidak ditemukan');

            $id = $this->decryptIdOrAbort($idEncrypt);
            $layanan = RmeRehabMedikLayanan::findOrFail($id);

            $layanan->tgl_pelayanan = $request->tgl_pelayanan;
            $layanan->jam_pelayanan = $request->jam_pelayanan;
            $layanan->kd_dokter     = $request->dokter;
            $layanan->subjective    = $request->subjective;
            $layanan->objective     = $request->objective;
            $layanan->assessment    = $request->assessment;
            $layanan->user_edit     = Auth::id();
            $layanan->save();

            $programs = $this->parseProgramsFromRequest($request);
            $this->replaceProgramDetails($id, $programs);

            DB::commit();
            return to_route('rehab-medis.pelayanan.terapi', [$kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Layanan berhasil diubah !');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function show($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataMedis = $this->baseService->getDataMedis($this->kdUnitDef_, $kd_pasien, $tgl_masuk, $urut_masuk);
        if (!$dataMedis) abort(404, 'Data medis tidak ditemukan');

        $layanan = $this->findLayananWithDetailsOrFail($id);
        $program = (object) ['detail' => $layanan->detail];

        return view('unit-pelayanan.rehab-medis.pelayanan.terapi.pelayanan-medis.show', compact('dataMedis', 'layanan', 'program'));
    }

    public function destroy($kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        DB::beginTransaction();
        try {

            $dataMedis = $this->baseService->getDataMedis($this->kdUnitDef_, $kd_pasien, $tgl_masuk, $urut_masuk);
            if (!$dataMedis) abort(404, 'Data medis tidak ditemukan');

            $layananId = $this->decryptIdOrAbort($request->input('id'));
            $pelayanan = RmeRehabMedikLayanan::find($layananId);
            if (!$pelayanan) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Data layanan tidak ditemukan!',
                    'data'    => [],
                ]);
            }

            RmeRehabMedikProgramDetail::where('id_layanan', $pelayanan->id)->delete();
            RmeRehabMedikLayanan::where('id', $pelayanan->id)->delete();

            DB::commit();
            return back()->with('success', 'Data pelayanan beserta program berhasil dihapus!');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function print($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();
        try {
            $dataMedis = $this->baseService->getDataMedis($this->kdUnitDef_, $kd_pasien, $tgl_masuk, $urut_masuk);
            if (!$dataMedis) abort(404, 'Data medis tidak ditemukan');

            $layanan = $this->findLayananWithDetailsOrFail($id);

            $pdf = Pdf::loadView(
                'unit-pelayanan.rehab-medis.pelayanan.terapi.pelayanan-medis.print',
                ['dataMedis' => $dataMedis, 'layanan' => $layanan]
            );

            $pdf->setPaper('a4', 'portrait');
            $pdf->setOptions([
                'isHtml5ParserEnabled'    => true,
                'isRemoteEnabled'         => true,
                'defaultFont'             => 'sans-serif',
                'isFontSubsettingEnabled' => true,
                'isPhpEnabled'            => true,
                'debugCss'                => false,
            ]);

            $filename = 'Program_Terapi_' . Str::of($dataMedis->pasien->nama ?? 'Pasien')->replace(' ', '_')
                . '_' . date('Y-m-d') . '.pdf';

            DB::commit(); // commit sebelum stream
            return $pdf->stream($filename);
        } catch (Exception $e) {
            DB::rollBack();
            abort(500, 'Terjadi kesalahan saat memuat data: ' . $e->getMessage());
        }
    }

    /* ====================== PRIVATE HELPERS ====================== */

    private function layananList($kd_pasien, $tgl_masuk, $urut_masuk): Collection
    {
        return RmeRehabMedikLayanan::with(['userCreate', 'dokter']) // <= tambah relasi dokter
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $this->kdUnitDef_)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->get();
    }

    private function tindakanList($kd_pasien, $tgl_masuk, $urut_masuk): Collection
    {
        return RmeRehabMedikTindakan::with(['karyawan'])
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $this->kdUnitDef_)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->get();
    }

    private function getProdukTarifRehabMedis(): Collection
    {
        $today = Carbon::now()->toDateString();

        return Produk::select([
            'klas_produk.kd_klas',
            'produk.kd_produk',
            'produk.kp_produk',
            'produk.deskripsi',
            'tarif.kd_tarif',
            'tarif.tarif',
            'tarif.kd_unit',
            'tarif.tgl_berlaku',
        ])
            ->join('tarif', 'produk.kd_produk', '=', 'tarif.kd_produk')
            ->join('tarif_cust', 'tarif.kd_tarif', '=', 'tarif_cust.kd_tarif')
            ->join('klas_produk', 'klas_produk.kd_klas', '=', 'produk.kd_klas')
            ->whereIn('tarif.kd_unit', [$this->kdUnitDef_])
            ->where('tarif.kd_tarif', 'TU')
            ->where(function ($q) use ($today) {
                $q->whereNull('tarif.Tgl_Berakhir')
                    ->orWhere('tarif.Tgl_Berakhir', '>=', $today);
            })
            ->where('tarif.tgl_berlaku', '<=', $today)
            ->whereIn('tarif.tgl_berlaku', function ($q) use ($today) {
                $q->select('tgl_berlaku')
                    ->from('tarif as t')
                    ->whereColumn('t.KD_PRODUK', 'tarif.kd_produk')
                    ->whereColumn('t.KD_TARIF', 'tarif.kd_tarif')
                    ->whereColumn('t.KD_UNIT', 'tarif.kd_unit')
                    ->where(function ($qq) use ($today) {
                        $qq->whereNull('t.Tgl_Berakhir')->orWhere('t.Tgl_Berakhir', '>=', $today);
                    })
                    ->orderBy('t.tgl_berlaku', 'asc')
                    ->limit(1);
            })
            ->whereRaw('LEFT(produk.kd_klas, 2) = ?', [$this->kdUnitDef_])
            ->orderBy('tarif.TGL_BERLAKU', 'desc')
            ->distinct()
            ->get();
    }

    private function getActiveDokter(): Collection
    {
        return Dokter::where('status', 1)->get();
    }

    private function parseProgramsFromRequest(Request $request): array
    {
        $programReq = $request->program ?? [];
        $programs = [];

        foreach ($programReq as $pro) {
            $parsed = is_array($pro) ? $pro : json_decode($pro, true);
            if (is_array($parsed) && isset($parsed['kd_produk'])) {
                $programs[] = [
                    'kd_produk'   => $parsed['kd_produk'],
                    'tarif'       => intval($parsed['tarif'] ?? 0),
                    'tgl_berlaku' => $parsed['tgl_berlaku'] ?? null,
                ];
            }
        }

        return $programs;
    }

    private function createProgramDetails(int $idLayanan, array $programs): void
    {
        foreach ($programs as $pr) {
            RmeRehabMedikProgramDetail::create([
                'id_layanan'  => $idLayanan,
                'kd_produk'   => $pr['kd_produk'],
                'tarif'       => intval($pr['tarif']),
                'tgl_berlaku' => $pr['tgl_berlaku'],
            ]);
        }
    }

    private function replaceProgramDetails(int $idLayanan, array $programs): void
    {
        RmeRehabMedikProgramDetail::where('id_layanan', $idLayanan)->delete();
        $this->createProgramDetails($idLayanan, $programs);
    }

    private function findLayananWithDetailsOrFail($id): RmeRehabMedikLayanan
    {
        return RmeRehabMedikLayanan::with(['dokter', 'detail.produk'])->findOrFail($id);
    }

    private function decryptIdOrAbort(?string $encryptedId): int
    {
        try {
            return (int) decrypt($encryptedId);
        } catch (Exception $e) {
            abort(400, 'ID tidak valid');
        }
    }
}
