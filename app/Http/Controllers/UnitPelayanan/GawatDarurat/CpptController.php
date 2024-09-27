<?php

namespace App\Http\Controllers\UnitPelayanan\GawatDarurat;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\MrKondisiFisik;
use App\Models\RmeFaktorPemberat;
use App\Models\RmeFaktorPeringan;
use App\Models\RmeFrekuensiNyeri;
use App\Models\RmeJenisNyeri;
use App\Models\RmeKualitasNyeri;
use App\Models\RmeMenjalar;
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
}
