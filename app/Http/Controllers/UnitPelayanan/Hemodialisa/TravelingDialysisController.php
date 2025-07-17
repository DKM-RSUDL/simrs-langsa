<?php

namespace App\Http\Controllers\UnitPelayanan\Hemodialisa;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\RmeAlergiPasien;
use App\Models\RmeTravelingDialysis;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TravelingDialysisController extends Controller
{
    private $kdUnitDef_;

    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/hemodialisa');
        $this->kdUnitDef_ = 72;
    }

    public function index($kd_pasien, $tgl_masuk, $urut_masuk)
    {
        // Mengambil data kunjungan
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

        $dataTravelingDialysis = RmeTravelingDialysis::with('userCreated')
            ->where('kd_pasien', $kd_pasien)
            ->orderBy('date_first_dialysis', 'desc')
            ->get();

        return view('unit-pelayanan.hemodialisa.pelayanan.traveling-dialysis.index', compact(
            'dataMedis',
            'dataTravelingDialysis'
        ));
    }

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

        $dokter = Dokter::where('status', 1)->get();
        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();

        return view('unit-pelayanan.hemodialisa.pelayanan.traveling-dialysis.create', compact(
            'dataMedis',
            'dokter',
            'alergiPasien'
        ));
    }

    public function store(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        // dd($request->all());
        DB::beginTransaction();

        try {
            $dataTraveling = new RmeTravelingDialysis();
            $dataTraveling->kd_pasien = $kd_pasien;
            $dataTraveling->kd_unit = $this->kdUnitDef_;
            $dataTraveling->tgl_masuk = $tgl_masuk;
            $dataTraveling->urut_masuk = $urut_masuk;

            $dataTraveling->date_first_dialysis = $request->date_first_dialysis;
            $dataTraveling->time_first_dialysis = $request->time_first_dialysis;
            $dataTraveling->diagnosis = $request->diagnosis;
            $dataTraveling->dialysis_location = $request->dialysis_location;
            $dataTraveling->pre_dialysis_bp = $request->pre_dialysis_bp;
            $dataTraveling->post_dialysis_bp = $request->post_dialysis_bp;
            $dataTraveling->vascular_access = $request->vascular_access ? json_encode($request->vascular_access) : null;
            $dataTraveling->type_dialyzer = $request->type_dialyzer ? json_encode($request->type_dialyzer) : null;
            $dataTraveling->blood_flow_rate = $request->blood_flow_rate;
            $dataTraveling->dialysate_flow_rate = $request->dialysate_flow_rate;
            $dataTraveling->type_dialysate = $request->type_dialysate;
            $dataTraveling->anticoagulant = $request->anticoagulant;
            $dataTraveling->loading_dose = $request->loading_dose;
            $dataTraveling->maintenance = $request->maintenance;
            $dataTraveling->patient_dry_weight = $request->patient_dry_weight;
            $dataTraveling->uf_goal = $request->uf_goal;
            $dataTraveling->uf_rate = $request->uf_rate;
            $dataTraveling->number_run_per_week = $request->number_run_per_week;
            $dataTraveling->length_dialysis = $request->length_dialysis;
            $dataTraveling->complication_dialysis = $request->complication_dialysis;
            $dataTraveling->hbsag_result = $request->hbsag_result;
            $dataTraveling->hbsag_date = $request->hbsag_date;
            $dataTraveling->anti_hcv_result = $request->anti_hcv_result;
            $dataTraveling->anti_hcv_date = $request->anti_hcv_date;
            $dataTraveling->anti_hiv_result = $request->anti_hiv_result;
            $dataTraveling->anti_hiv_date = $request->anti_hiv_date;
            $dataTraveling->current_medication = $request->current_medication;
            $medicationNames = $request->medication_name ?? [];
            $medicationFrequencies = $request->medication_frequency ?? [];
            $medications = [];

            for ($i = 0; $i < count($medicationNames); $i++) {
                if (!empty($medicationNames[$i])) {
                    $medications[] = [
                        'name' => $medicationNames[$i],
                        'frequency' => $medicationFrequencies[$i] ?? ''
                    ];
                }
            }
            $dataTraveling->relevant_clinical_history = !empty($medications) ? json_encode($medications) : null;
            $dataTraveling->user_created = Auth::id();
            $dataTraveling->save();

            // Simpan alergi pasien
            $alergiData = json_decode($request->alergis, true);

            if (!empty($alergiData)) {
                // Hapus data alergi lama untuk pasien ini
                RmeAlergiPasien::where('kd_pasien', $kd_pasien)->delete();

                // Simpan data alergi baru
                foreach ($alergiData as $alergi) {
                    RmeAlergiPasien::create([
                        'kd_pasien' => $kd_pasien,
                        'jenis_alergi' => $alergi['jenis_alergi'],
                        'nama_alergi' => $alergi['alergen'],
                        'reaksi' => $alergi['reaksi'],
                        'tingkat_keparahan' => $alergi['tingkat_keparahan']
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('hemodialisa.pelayanan.traveling-dialysis.index', [$kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage())->withInput();
        }
    }


    public function edit($kd_pasien, $tgl_masuk, $urut_masuk, $id)
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

        $dataTraveling = RmeTravelingDialysis::findOrFail($id);
        $dokter = Dokter::where('status', 1)->get();
        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();

        return view('unit-pelayanan.hemodialisa.pelayanan.traveling-dialysis.edit', compact(
            'dataMedis',
            'dataTraveling',
            'dokter',
            'alergiPasien'
        ));
    }

    public function update(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            $dataTraveling = RmeTravelingDialysis::findOrFail($id);

            $dataTraveling->date_first_dialysis = $request->date_first_dialysis;
            $dataTraveling->time_first_dialysis = $request->time_first_dialysis;
            $dataTraveling->diagnosis = $request->diagnosis;
            $dataTraveling->dialysis_location = $request->dialysis_location;
            $dataTraveling->pre_dialysis_bp = $request->pre_dialysis_bp;
            $dataTraveling->post_dialysis_bp = $request->post_dialysis_bp;
            $dataTraveling->vascular_access = $request->vascular_access ? json_encode($request->vascular_access) : null;
            $dataTraveling->type_dialyzer = $request->type_dialyzer ? json_encode($request->type_dialyzer) : null;
            $dataTraveling->blood_flow_rate = $request->blood_flow_rate;
            $dataTraveling->dialysate_flow_rate = $request->dialysate_flow_rate;
            $dataTraveling->type_dialysate = $request->type_dialysate;
            $dataTraveling->anticoagulant = $request->anticoagulant;
            $dataTraveling->loading_dose = $request->loading_dose;
            $dataTraveling->maintenance = $request->maintenance;
            $dataTraveling->patient_dry_weight = $request->patient_dry_weight;
            $dataTraveling->uf_goal = $request->uf_goal;
            $dataTraveling->uf_rate = $request->uf_rate;
            $dataTraveling->number_run_per_week = $request->number_run_per_week;
            $dataTraveling->length_dialysis = $request->length_dialysis;
            $dataTraveling->complication_dialysis = $request->complication_dialysis;
            $dataTraveling->hbsag_result = $request->hbsag_result;
            $dataTraveling->hbsag_date = $request->hbsag_date;
            $dataTraveling->anti_hcv_result = $request->anti_hcv_result;
            $dataTraveling->anti_hcv_date = $request->anti_hcv_date;
            $dataTraveling->anti_hiv_result = $request->anti_hiv_result;
            $dataTraveling->anti_hiv_date = $request->anti_hiv_date;
            $dataTraveling->current_medication = $request->current_medication;

            $medicationNames = $request->medication_name ?? [];
            $medicationFrequencies = $request->medication_frequency ?? [];
            $medications = [];

            for ($i = 0; $i < count($medicationNames); $i++) {
                if (!empty($medicationNames[$i])) {
                    $medications[] = [
                        'name' => $medicationNames[$i],
                        'frequency' => $medicationFrequencies[$i] ?? ''
                    ];
                }
            }
            $dataTraveling->relevant_clinical_history = !empty($medications) ? json_encode($medications) : null;
            $dataTraveling->user_updated = Auth::id();
            $dataTraveling->save();

            // Update alergi pasien
            $alergiData = json_decode($request->alergis, true);

            if (!empty($alergiData)) {
                RmeAlergiPasien::where('kd_pasien', $kd_pasien)->delete();

                foreach ($alergiData as $alergi) {
                    RmeAlergiPasien::create([
                        'kd_pasien' => $kd_pasien,
                        'jenis_alergi' => $alergi['jenis_alergi'],
                        'nama_alergi' => $alergi['alergen'],
                        'reaksi' => $alergi['reaksi'],
                        'tingkat_keparahan' => $alergi['tingkat_keparahan']
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('hemodialisa.pelayanan.traveling-dialysis.index', [$kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            $dataTraveling = RmeTravelingDialysis::findOrFail($id);
            $dataTraveling->delete();

            DB::commit();

            return redirect()->route('hemodialisa.pelayanan.traveling-dialysis.index', [$kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function show($kd_pasien, $tgl_masuk, $urut_masuk, $id)
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

        $dataTraveling = RmeTravelingDialysis::with('userCreated')->findOrFail($id);
        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();

        return view('unit-pelayanan.hemodialisa.pelayanan.traveling-dialysis.show', compact(
            'dataMedis',
            'dataTraveling',
            'alergiPasien'
        ));
    }

    public function generatePDF($kd_pasien, $tgl_masuk, $urut_masuk, $id)
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

        $dataTraveling = RmeTravelingDialysis::with('userCreated')->findOrFail($id);
        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();

        $pdf = Pdf::loadView('unit-pelayanan.hemodialisa.pelayanan.traveling-dialysis.pdf', compact(
            'dataMedis',
            'dataTraveling',
            'alergiPasien'
        ));

        $filename = 'Traveling_Dialysis_' . $dataMedis->pasien->nama_pasien . '_' . date('Y-m-d') . '.pdf';

        return $pdf->stream($filename);
    }
    
}
