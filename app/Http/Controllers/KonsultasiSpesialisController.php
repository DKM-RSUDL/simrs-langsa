<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\DokterInap;
use App\Models\KonsultasiSpesialis;
use App\Models\SpcKelas;
use App\Models\Spesialisasi;
use App\Models\Transaksi;
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
        
        $category = "Minta";
        if(!empty($request->category)){
            $category = $request->category;
        }


        $columnnValue = $category == "Minta" ? 'dokter_pengirim' : 'dokter_tujuan';
        $acuan = Dokter::select('kd_dokter')->where('kd_karyawan', Auth::user()->kd_karyawan)->first();
        if(empty($acuan)){
            $columnnValue = 'user_create';
            $acuan = Auth::user()->kd_karyawan;
        }

        $dataMedis = $this->dataMedis->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
        $dataKonsul = KonsultasiSpesialis::with(['dokterPengirim' ,'dokterTujuan','spesialis'])
                     ->where($columnnValue  ,$acuan)
                     ->where('kd_kasir', $dataMedis->kd_kasir)
                     ->where('no_transaksi', $dataMedis->no_transaksi)
                     ->get();
                    

        $targetRout = 'unit-pelayanan.rawat-inap.pelayanan.konsultasi-spesialis.konsultasi-minta';
        $isTerima = false;
        if($category!="Minta"){
            $targetRout = 'unit-pelayanan.rawat-inap.pelayanan.konsultasi-spesialis.konsultasi-terima';
            $isTerima = true;
        }

    
        return view($targetRout,
            compact('isTerima','dataMedis','dataKonsul'));
    }

    public function create(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        

        $baseData = $this->getBaseData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
        $dataMedis = $baseData['dataMedis'];
        $dokterPengirim = $baseData['dokterPengirim'];
        $spesialisasi = $baseData['spesialisasi'];

        return view('unit-pelayanan.rawat-inap.pelayanan.konsultasi-spesialis.konsultasi-minta-form.form',
            compact('dataMedis', 
            'dokterPengirim',
            'spesialisasi'
        ));
    }

    public function edit(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk){
        $id = $request->id;
        $readonly = false;
        if($request->category){
           $readonly = true;
        }

        $Data = KonsultasiSpesialis::with(['dokterPengirim','dokterTujuan','spesialis'])
            ->where('id',$id)
            ->first();
        if(!$Data){
                throw new Exception('Tidak Ditemukan');
            }

        $baseData = $this->getBaseData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
        $dataMedis = $baseData['dataMedis'];
        $dokterPengirim = $baseData['dokterPengirim'];
        $spesialisasi = $baseData['spesialisasi'];

        $Listdokter =  $this->getDokterSpesialis($Data->kd_spesial);

        return view('unit-pelayanan.rawat-inap.pelayanan.konsultasi-spesialis.konsultasi-minta-form.form',
            compact( 
                'dataMedis',    
                'spesialisasi',
            'dokterPengirim', 
            'Listdokter',
            'Data',
            'readonly',
        ));

    }

     public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
     {
        try {
            DB::beginTransaction();

            $dataMedis = $this->dataMedis->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
            $konsultasi = new KonsultasiSpesialis();
            $konsultasi->dokter_pengirim  = $request->dokter_pengirim;
            $konsultasi->tanggal_konsul   = $request->tgl_konsul;
            $konsultasi->jam_konsul       = $request->jam_konsul;
            $konsultasi->kd_spesial       = $request->spesialisasi;
            $konsultasi->dokter_tujuan    = $request->dokter_unit_tujuan;
            $konsultasi->catatan          = $request->catatan;
            $konsultasi->konsul           = $request->konsul;
            $konsultasi->kd_kasir         = $dataMedis->kd_kasir;
            $konsultasi->no_transaksi     = $dataMedis->no_transaksi;
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

    public function delete(Request $request, $kd_unit, $kd_pasien, $tgl_masuk,$urut_masuk){
        try{
            DB::beginTransaction();
            $id= $request->id;

            $konsultasi = KonsultasiSpesialis::findOrFail($id);

            if(!$konsultasi){
                throw new Exception('Tidak Ditemukan');
            }
            $konsultasi->delete();

            DB::commit();
            return redirect()
                    ->route('rawat-inap.konsultasi-spesialis.index', [
                        $kd_unit,
                        $kd_pasien,
                        $tgl_masuk,
                        $urut_masuk
                    ])
                    ->with('success', 'Konsultasi spesialis berhasil di hapus.');
                    
            }catch(Exception $e){
                DB::rollBack();
                return back()->with('error', $e->getMessage());
            }
    }

    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk){
        try {
            DB::beginTransaction();
           
            $id = $request->id;
            $isTerima = false;
            $konsultasi = KonsultasiSpesialis::findOrFail($id);
            if($request->category === 'minta'){
                 $konsultasi->update([
                    'dokter_pengirim' => $request->dokter_pengirim,
                    'tanggal_konsul'  => $request->tgl_konsul,
                    'jam_konsul'      => $request->jam_konsul,
                    'kd_spesial'      => $request->spesialisasi,
                    'dokter_tujuan'   => $request->dokter_unit_tujuan,
                    'catatan'         => $request->catatan,
                    'konsul'          => $request->konsul,
                    'respon_konsul'   => $request->respon_konsul ?? null,
                    'user_edit'       => Auth::user()->kd_karyawan,
                ]);
            }else{
                 $konsultasi->update([
                    'respon_konsul'   => $request->respon_konsul ?? null,
                    'status'   => 1,
                ]);
                $isTerima = true;
            }
           
            DB::commit();

            return redirect()
                ->route('rawat-inap.konsultasi-spesialis.index', [
                    $kd_unit,
                    $kd_pasien,
                    $tgl_masuk,
                    $urut_masuk,
                    'category'  => $isTerima ? 'Terima' : 'Minta'
                ])
                ->with('success', 'Data konsultasi berhasil diperbarui.');

        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    private function getBaseData($kd_unit,$kd_pasien,$tgl_masuk,$urut_masuk){
        $dataMedis = $this->dataMedis->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
        $dokterPengirim = $this->getDokter();

        $spesialisasi = Spesialisasi::orderBy('spesialisasi')->get();

        return [
            'dataMedis' => $dataMedis,
            'dokterPengirim' => $dokterPengirim,
            'spesialisasi' => $spesialisasi
        ];
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
