<?php

namespace App\Http\Controllers\UnitPelayanan\RehabMedis\Pelayanan;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\RmeRehabMedikLayanan;
use App\Models\RmeRehabMedikTindakan;
use App\Services\BaseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TindakanController extends Controller
{
    private $kdUnitDef_;
    private $baseService;

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

        $tindakan = RmeRehabMedikTindakan::with('karyawan')->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $this->kdUnitDef_)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->get();

        return view('unit-pelayanan.rehab-medis.pelayanan.tindakan.index', compact(
            'dataMedis',
            'tindakan'
        ));
    }

    public function create($kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->baseService->getDataMedis($this->kdUnitDef_, $kd_pasien, $tgl_masuk, $urut_masuk);
        if (!$dataMedis) abort(404, 'Data tidak ditemukan');

        $tindakan = RmeRehabMedikLayanan::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $this->kdUnitDef_)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->first();

        return view('unit-pelayanan.rehab-medis.pelayanan.tindakan.create', compact('dataMedis', 'tindakan'));
    }

    public function store($kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        DB::beginTransaction();
        try {
            $dataMedis = $this->baseService->getDataMedis($this->kdUnitDef_, $kd_pasien, $tgl_masuk, $urut_masuk);
            if (!$dataMedis) abort(404, 'Data tidak ditemukan');

            // store tindakan
            $tindakanData = [
                'kd_pasien' => $kd_pasien,
                'kd_unit' => $this->kdUnitDef_,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
                'tgl_tindakan' => $request->tgl_tindakan,
                'jam_tindakan' => $request->jam_tindakan,
                'subjective' => $request->subjective,
                'objective' => $request->objective,
                'assessment' => $request->assessment,
                'planning_goal' => $request->planning_goal,
                'planning_tindakan' => $request->planning_tindakan,
                'planning_edukasi' => $request->planning_edukasi,
                'planning_frekuensi' => $request->planning_frekuensi,
                'rencana_tindak_lanjut' => $request->rencana_tindak_lanjut,
                'user_create' => Auth::user()->kd_karyawan,
            ];

            RmeRehabMedikTindakan::create($tindakanData);

            DB::commit();
            return to_route('rehab-medis.pelayanan.tindakan.index', [$kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'Tindakan berhasil ditambah !');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataMedis = $this->baseService->getDataMedis($this->kdUnitDef_, $kd_pasien, $tgl_masuk, $urut_masuk);
        if (!$dataMedis) abort(404, 'Data tidak ditemukan');

        $tindakan = RmeRehabMedikTindakan::find($id);

        return view('unit-pelayanan.rehab-medis.pelayanan.tindakan.edit', compact('dataMedis', 'tindakan'));
    }

    public function update($kd_pasien, $tgl_masuk, $urut_masuk, $idEncrypt, Request $request)
    {
        DB::beginTransaction();

        try {
            $dataMedis = $this->baseService->getDataMedis($this->kdUnitDef_, $kd_pasien, $tgl_masuk, $urut_masuk);
            if (!$dataMedis) abort(404, 'Data tidak ditemukan');

            // update tindakan
            $tindakanData = [
                'tgl_tindakan'  => $request->tgl_tindakan,
                'jam_tindakan'  => $request->jam_tindakan,
                'subjective' => $request->subjective,
                'objective' => $request->objective,
                'assessment' => $request->assessment,
                'planning_goal' => $request->planning_goal,
                'planning_tindakan' => $request->planning_tindakan,
                'planning_edukasi' => $request->planning_edukasi,
                'planning_frekuensi' => $request->planning_frekuensi,
                'rencana_tindak_lanjut' => $request->rencana_tindak_lanjut,
                'user_edit' => Auth::user()->kd_karyawan,
            ];

            $id = decrypt($idEncrypt);
            RmeRehabMedikTindakan::where('id', $id)->update($tindakanData);

            DB::commit();
            return to_route('rehab-medis.pelayanan.tindakan.index', [$kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'Tindakan berhasil diperbarui!');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function show($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataMedis = $this->baseService->getDataMedis($this->kdUnitDef_, $kd_pasien, $tgl_masuk, $urut_masuk);
        if (!$dataMedis) abort(404, 'Data tidak ditemukan');

        $tindakan = RmeRehabMedikTindakan::find($id);

        return view('unit-pelayanan.rehab-medis.pelayanan.tindakan.show', compact('dataMedis', 'tindakan'));
    }

    public function destroy($kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        DB::beginTransaction();
        try {
            $dataMedis = $this->baseService->getDataMedis($this->kdUnitDef_, $kd_pasien, $tgl_masuk, $urut_masuk);
            if (!$dataMedis) abort(404, 'Data tidak ditemukan');

            $tindakanId = $this->decryptIdOrAbort($request->input('id'));
            $tindakan = RmeRehabMedikTindakan::find($tindakanId);
            if (!$tindakan) abort(404, 'Data tidak ditemukan');

            // delete tindakan
            RmeRehabMedikTindakan::where('id', $tindakanId)->delete();

            DB::commit();
            return back()->with('success', 'Tindakan berhasil dihapus!');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
    // public function destroy($kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    // {
    //     DB::beginTransaction();

    //     try {
    //         $dataMedis = $this->baseService->getDataMedis($this->kdUnitDef_, $kd_pasien, $tgl_masuk, $urut_masuk);
    //         if (!$dataMedis) abort(404, 'Data tidak ditemukan');

    //         $id = decrypt($request->tindakan);
    //         $tindakan = RmeRehabMedikTindakan::find($id);

    //         if (empty($tindakan)) {
    //             return response()->json([
    //                 'status'    => 'error',
    //                 'message'   => 'Data tidak ditemukan !',
    //                 'data'      => []
    //             ]);
    //         }

    //         // delete tindakan
    //         RmeRehabMedikTindakan::where('id', $id)->delete();

    //         // delete detail transaksi
    //         $programs = RmeRehabMedikProgramDetail::with(['tindakan'])
    //             ->whereRelation('tindakan', function ($q) use ($kd_pasien, $tgl_masuk, $urut_masuk) {
    //                 $q->where('kd_pasien', $kd_pasien);
    //                 $q->where('kd_unit', $this->kdUnitDef_);
    //                 $q->whereDate('tgl_masuk', $tgl_masuk);
    //                 $q->where('urut_masuk', $urut_masuk);
    //             })->get();

    //         foreach ($programs as $program) {
    //             DetailTransaksi::where('no_transaksi', $dataMedis->no_transaksi)
    //                 ->where('kd_kasir', $dataMedis->kd_kasir)
    //                 ->where('kd_unit', 74)
    //                 ->where('kd_produk', $program->kd_produk)
    //                 ->whereDate('tgl_transaksi', $tgl_masuk)
    //                 ->delete();
    //         }

    //         DB::commit();
    //         return response()->json([
    //             'status'    => 'success',
    //             'message'   => 'OK !',
    //             'data'      => []
    //         ]);
    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         return back()->with('error', $e->getMessage());
    //     }
    // }

    public function print($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();
        try {
            $dataMedis = $this->baseService->getDataMedis($this->kdUnitDef_, $kd_pasien, $tgl_masuk, $urut_masuk);
            if (!$dataMedis) abort(404, 'Data medis tidak ditemukan');

            $tindakan = $this->findTindakanWithDetailsOrFail($id);

            $pdf = Pdf::loadView(
                'unit-pelayanan.rehab-medis.pelayanan.tindakan.print',
                ['dataMedis' => $dataMedis, 'tindakan' => $tindakan]
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

    private function findTindakanWithDetailsOrFail($id): RmeRehabMedikTindakan
    {
        return RmeRehabMedikTindakan::with(['karyawan'])->findOrFail($id);
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
