<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\DokterInap;
use App\Models\KonsultasiSpesialis;
use App\Models\SpcKelas;
use App\Models\Spesialisasi;
use Exception;
use App\Services\BaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KonsultasiSpesialisController extends Controller
{
    protected $dataMedis;

    public function __construct()
    {
        $this->dataMedis = new BaseService;
    }

    public function index(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->dataMedis->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

        $dataKonsul = KonsultasiSpesialis::with(['dokterPengirim','dokterTujuan','spesialis'])->get();
        

        return view('unit-pelayanan.rawat-inap.pelayanan.konsultasi-spesialis.konsultasi-terima',
            compact('dataMedis', 'kd_unit', 'kd_pasien', 'tgl_masuk', 'urut_masuk','dataKonsul'));
    }

    public function create(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->dataMedis->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
        $dokterPengirim = $this->getDokter();

        $spesialisasi = Spesialisasi::orderBy('spesialisasi')->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.konsultasi-spesialis.konsultasi-minta-form.form',
            compact('dataMedis', 
            'kd_unit', 
            'kd_pasien', 
            'tgl_masuk', 
            'urut_masuk',
            'dokterPengirim',
            'spesialisasi'
        ));
    }

    public function edit(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk){
        $id = $request->id;
        $dataMedis = $this->dataMedis->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);

        $Data = KonsultasiSpesialis::with(['dokterPengirim','dokterTujuan','spesialis'])
            ->where('id',$id)
            ->first();

        $dokterPengirim = $this->getDokter();
        $spesialisasi = Spesialisasi::orderBy('spesialisasi')->get();
            
        $Listdokter =  $this->getDokterSpesialis($Data->kd_spesial);

        return view('unit-pelayanan.rawat-inap.pelayanan.konsultasi-spesialis.konsultasi-minta-form.form',
            compact( 
                'dataMedis',
                'kd_unit',
                'spesialisasi',
            'dokterPengirim', 
            'kd_pasien', 
            'tgl_masuk', 
            'urut_masuk',
            'Listdokter',
            'Data'
        ));

    }

     public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
     {
        try {
            DB::beginTransaction();
            $konsultasi = new KonsultasiSpesialis();

            $konsultasi->dokter_pengirim  = $request->dokter_pengirim;
            $konsultasi->tanggal_konsul   = $request->tgl_konsul;
            $konsultasi->jam_konsul       = $request->jam_konsul;
            $konsultasi->kd_spesial       = $request->spesialisasi;
            $konsultasi->dokter_tujuan    = $request->dokter_unit_tujuan;
            $konsultasi->catatan          = $request->catatan;
            $konsultasi->konsul           = $request->konsul;
            $konsultasi->user_create      = Auth::user()->kd_karyawan;
            $konsultasi->user_edit        = null;

            $konsultasi->save(); // simpan ke database

            DB::commit();

            return redirect()
                ->route('rawat-inap.konsultasi-spesialis.index', [
                    $kd_unit,
                    $kd_pasien,
                    $tgl_masuk,
                    $urut_masuk
                ])
                ->with('success', 'Konsultasi spesialis berhasil disimpan.');

        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

   public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk){
        try {
            DB::beginTransaction();
           
            $id = $request->id;

            $konsultasi = KonsultasiSpesialis::findOrFail($id);

            $konsultasi->update([
                'dokter_pengirim' => $request->dokter_pengirim,
                'tanggal_konsul'  => $request->tgl_konsul,
                'jam_konsul'      => $request->jam_konsul,
                'kd_spesial'      => $request->spesialisasi,
                'dokter_tujuan'   => $request->dokter_unit_tujuan,
                'catatan'         => $request->catatan,
                'konsul'          => $request->konsul,
                'user_edit'       => Auth::user()->kd_karyawan,
            ]);
            DB::commit();

            return redirect()
                ->route('rawat-inap.konsultasi-spesialis.index', [
                    $kd_unit,
                    $kd_pasien,
                    $tgl_masuk,
                    $urut_masuk
                ])
                ->with('success', 'Data konsultasi berhasil diperbarui.');

        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }



    public function getDokterBySpesial(Request $request){
        try {
            $dokter = $this->getDokterSpesialis($request->kd_spesial);

            $dokHtml = "<option value=''>--Pilih Dokter--</option>";
           
            foreach ($dokter as $dok) {
                $dokHtml .= "<option value='$dok->kd_dokter'>$dok->nama</option>";
            }

            return response()->json([
                'status'    => 'success',
                'message'   => 'OK',
                'data'      => [
                    'dokterOption'  => $dokHtml,
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'    => 'error',
                'message'   => $e->getMessage(),
                'data'      => []
            ]);
        }
    }

    private function getDokterSpesialis($kd_spesial){
        $dokter = Dokter::select(['dokter.kd_dokter', 'nama'])
                ->join('dokter_spesial as ds', 'dokter.kd_dokter', '=', 'ds.kd_dokter')
                ->where('ds.kd_spesial', $kd_spesial)
                ->where('dokter.status', 1)
                ->distinct()
                ->get();
        return $dokter;
    }

    private function getDokter(){
        $DokterInap = DokterInap::with(['dokter', 'unit'])
            ->where('kd_unit', '1001')
            ->whereRelation('dokter', 'status', 1)
            ->get();
        return $DokterInap;
    }

}
