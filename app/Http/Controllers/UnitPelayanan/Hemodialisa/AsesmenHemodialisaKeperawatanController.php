<?php

namespace App\Http\Controllers\UnitPelayanan\Hemodialisa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dokter;
use App\Models\DokterKlinik;
use App\Models\HrdKaryawan;
use App\Models\Kunjungan;
use App\Models\MrItemFisik;
use App\Models\RmeMasterDiagnosis;
use App\Models\RmeMasterImplementasi;
use Carbon\Carbon;

class AsesmenHemodialisaKeperawatanController extends Controller
{
    private $kdUnitDef_ = 72;

    public function create($kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_unit', $this->kdUnitDef_)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        $itemFisik = MrItemFisik::orderby('urut')->get();
        $rmeMasterDiagnosis = RmeMasterDiagnosis::all();
        $dokterPelaksana = DokterKlinik::with(['dokter'])
            ->where('kd_unit', 215)
            ->whereRelation('dokter', 'status', 1)
            ->get();

        $dokter = Dokter::where('status', 1)->get();
        $rmeMasterImplementasi = RmeMasterImplementasi::all();

        $perawat = HrdKaryawan::where('status_peg', 1)
            ->where('kd_ruangan', 29)
            ->where('kd_jenis_tenaga', 2)
            ->where('kd_detail_jenis_tenaga', 1)
            ->get();

        return view('unit-pelayanan.hemodialisa.pelayanan.asesmen.keperawatan.create', compact(
            'dataMedis', 'itemFisik', 'rmeMasterDiagnosis', 'dokterPelaksana', 'dokter', 'perawat', 'rmeMasterImplementasi'
        ));
    }
}
