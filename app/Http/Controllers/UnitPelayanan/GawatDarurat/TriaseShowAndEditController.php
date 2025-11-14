<?php

namespace App\Http\Controllers\UnitPelayanan\GawatDarurat;
use App\Models\DataTriase;
use App\Services\AsesmenService;
use Exception;
use App\Services\BaseService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TriaseShowAndEditController extends Controller
{
    protected $baseService;
    protected $kdUnit;
    protected $asesmenService; 
    protected $IGDservice;
    public function __construct(){
        $this->baseService = new BaseService();
        $this->kdUnit = 3; // Gawat Darurat
        $this->asesmenService = new AsesmenService();

    }
    public function index($kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->baseService->getDataMedis(
            $this->kdUnit,
            $kd_pasien,
            $tgl_masuk,
            $urut_masuk
        );

    
        $data = $this->getTriaseData($dataMedis);
     
        $vitalSign = $this->asesmenService->getVitalSignData($dataMedis->kd_kasir, $dataMedis->no_transaksi);
        $data->triase = json_decode($data->triase, true);

    
        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        return view(
            'unit-pelayanan.gawat-darurat.action-gawat-darurat.triase.show',
            compact('dataMedis','vitalSign','data')
        );
    }

    public function update(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
       
        $dataMedis = $this->baseService->getDataMedis(
            $this->kdUnit,
            $kd_pasien,
            $tgl_masuk,
            $urut_masuk
        );

    
        $triase = $this->getTriaseData($dataMedis);
        if (!$triase) {
            return back()->with('error', 'Data triase tidak ditemukan.');
        }


        // -----------------------------
        // VITAL SIGN
        // -----------------------------
        $vitalSign = [
            'sistole'         => $request->sistole,
            'diastole'        => $request->diastole,
            'nadi'            => $request->nadi,
            'respiration'     => $request->respiration,
            'suhu'            => $request->suhu,
            'spo2_tanpa_o2'   => $request->spo2_tanpa_o2,
            'spo2_dengan_o2'  => $request->spo2_dengan_o2,
            'tinggi_badan'    => $request->tinggi_badan,
            'berat_badan'     => $request->berat_badan,
        ];

        // -----------------------------
        // KUMPULKAN ABCD TRIAGE
        // -----------------------------
        $abcdn = [
            'air_way'     => $request->airway ?? [],
            'breathing'   => $request->breathing ?? [],
            'circulation' => $request->circulation ?? [],
            'disability'  => $request->disability ?? [],
        ];

      
        $triase->vital_sign = json_encode($vitalSign);
        $triase->save();

        $this->asesmenService->store($vitalSign, $kd_pasien, $dataMedis->no_transaksi, $dataMedis->kd_kasir);

        // -----------------------------
        // SIMPAN KE DATABASE
        // -----------------------------
        $triase->update([
            'vital_sign'   => json_encode($vitalSign),
            'triase'       => json_encode($abcdn),
            'kode_triase'  => $request->kd_triase,
            'hasil_triase' => $request->ket_triase,
        ]);

        return back()->with('success', 'Data triase berhasil diperbarui.');
    }



    public function getTriaseData($dataMedis)
    {
        try {
            $triaseData = DataTriase::with(['dokter'])->find($dataMedis->triase_id);
            return $triaseData;
        } catch (Exception $e) {
            return false;
        }
    }
}
