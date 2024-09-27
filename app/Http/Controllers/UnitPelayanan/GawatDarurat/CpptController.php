<?php

namespace App\Http\Controllers\UnitPelayanan\GawatDarurat;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\MrKondisiFisik;
use App\Models\Penyakit;
use App\Models\RmeFaktorPemberat;
use App\Models\RmeFaktorPeringan;
use App\Models\RmeFrekuensiNyeri;
use App\Models\RmeJenisNyeri;
use App\Models\RmeKualitasNyeri;
use App\Models\RmeMenjalar;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CpptController extends Controller
{
    public function index($kd_pasien)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer'])
                            ->where('kd_pasien', $kd_pasien)
                            ->first();

        $tandaVital = MrKondisiFisik::OrderBy('urut')->get();
        $faktorPemberat = RmeFaktorPemberat::all();
        $faktorPeringan = RmeFaktorPeringan::all();
        $kualitasNyeri = RmeKualitasNyeri::all();
        $frekuensiNyeri = RmeFrekuensiNyeri::all();
        $menjalar = RmeMenjalar::all();
        $jenisNyeri = RmeJenisNyeri::all();

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.cppt.index', [
            'dataMedis'         => $dataMedis,
            'tandaVital'        => $tandaVital,
            'faktorPemberat'    => $faktorPemberat,
            'faktorPeringan'    => $faktorPeringan,
            'kualitasNyeri'     => $kualitasNyeri,
            'frekuensiNyeri'    => $frekuensiNyeri,
            'menjalar'          => $menjalar,
            'jenisNyeri'        => $jenisNyeri,
        ]);
    }

    public function getIcdTenAjax(Request $request)
    {
        try {
            $search = $request->data;
            $query = Penyakit::select(['kd_penyakit', 'penyakit']);

            if(!empty($search)) {
                $query->where(function($q) use ($search) {
                        $q->where('penyakit', 'LIKE', "%$search%");
                        $q->orWhere('kd_penyakit', 'LIKE', "%$search%");
                    })
                    ->limit(5);
            } else {
                    $query->limit(5);
            }

            $dataDiagnosa = $query->get();

            return response()->json([
                'status'    => 'success',
                'data'      => [
                    'count'     => count($dataDiagnosa),
                    'diagnosa'  => $dataDiagnosa
                ]
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status'    => 'error',
                'message'   => $e->getMessage(),
                'data'      => [
                    'count' => 0
                ]
            ], 400);
        }
    }
}


