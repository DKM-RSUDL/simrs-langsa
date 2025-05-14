@extends('layouts.administrator.master')

@section('content')
<div class="container-fluid py-3">
    <div class="row g-3">
        <div class="col-lg-3">
            @include('components.patient-card')
        </div>

        <div class="col-lg-9">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title text-center text-primary fw-bold mb-0">Detail Monitoring Intensive Care Unit (ICCU)</h5>
                </div>
                <div class="card-body">
                    <div class="accordion" id="iccuMonitoringAccordion">
                        <!-- Implementation Details -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingImplementation">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseImplementation" aria-expanded="true" aria-controls="collapseImplementation">
                                    <i class="bi bi-calendar-check me-2"></i>Detail Implementasi
                                </button>
                            </h2>
                            <div id="collapseImplementation" class="accordion-collapse collapse show" aria-labelledby="headingImplementation" data-bs-parent="#iccuMonitoringAccordion">
                                <div class="accordion-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped mb-0">
                                            <tbody>
                                                <tr>
                                                    <th class="bg-light">Tanggal Implementasi</th>
                                                    <td>{{ $monitoring->tgl_implementasi }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">Jam Implementasi</th>
                                                    <td>{{ \Carbon\Carbon::parse($monitoring->jam_implementasi)->format('H:i') }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Patient Information -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingPatientInfo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePatientInfo" aria-expanded="false" aria-controls="collapsePatientInfo">
                                    <i class="bi bi-person-lines-fill me-2"></i>Informasi Pasien
                                </button>
                            </h2>
                            <div id="collapsePatientInfo" class="accordion-collapse collapse" aria-labelledby="headingPatientInfo" data-bs-parent="#iccuMonitoringAccordion">
                                <div class="accordion-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped mb-0">
                                            <tbody>
                                                <tr>
                                                    <th class="bg-light">Indikasi ICCU</th>
                                                    <td>{{ $monitoring->indikasi_iccu ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">Diagnosa</th>
                                                    <td>{{ $monitoring->diagnosa ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">Alergi</th>
                                                    <td>{{ $monitoring->alergi ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">Berat Badan (kg)</th>
                                                    <td>{{ $monitoring->berat_badan ? number_format($monitoring->berat_badan, 1) : '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">Tinggi Badan (cm)</th>
                                                    <td>{{ $monitoring->tinggi_badan ? number_format($monitoring->tinggi_badan, 0) : '-' }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Intake -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingIntake">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseIntake" aria-expanded="false" aria-controls="collapseIntake">
                                    <i class="bi bi-droplet-fill me-2"></i>Total Intake
                                </button>
                            </h2>
                            <div id="collapseIntake" class="accordion-collapse collapse" aria-labelledby="headingIntake" data-bs-parent="#iccuMonitoringAccordion">
                                <div class="accordion-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped mb-0">
                                            <tbody>
                                                <tr>
                                                    <th class="bg-light">BAB</th>
                                                    <td>{{ $monitoring->bab ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">Urine</th>
                                                    <td>{{ $monitoring->urine ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">IWL</th>
                                                    <td>{{ $monitoring->iwl ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">Muntahan/CMS</th>
                                                    <td>{{ $monitoring->muntahan_cms ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">Drain</th>
                                                    <td>{{ $monitoring->drain ?? '-' }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ICCU Parameters -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingParameters">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseParameters" aria-expanded="false" aria-controls="collapseParameters">
                                    <i class="bi bi-heart-pulse-fill me-2"></i>Monitoring ICCU Parameters
                                </button>
                            </h2>
                            <div id="collapseParameters" class="accordion-collapse collapse" aria-labelledby="headingParameters" data-bs-parent="#iccuMonitoringAccordion">
                                <div class="accordion-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped mb-0">
                                            <tbody>
                                                <tr>
                                                    <th class="bg-light">Sistolik (mmHg)</th>
                                                    <td>{{ $monitoring->detail->sistolik ? number_format($monitoring->detail->sistolik, 0) : '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">Diastolik (mmHg)</th>
                                                    <td>{{ $monitoring->detail->diastolik ? number_format($monitoring->detail->diastolik, 0) : '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">MAP</th>
                                                    <td>{{ $monitoring->detail->map ? number_format($monitoring->detail->map, 0) : '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">Heart Rate (HR) (bpm)</th>
                                                    <td>{{ $monitoring->detail->hr ? number_format($monitoring->detail->hr, 0) : '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">Resp. Rate (RR) (x/menit)</th>
                                                    <td>{{ $monitoring->detail->rr ? number_format($monitoring->detail->rr, 0) : '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">Suhu (°C)</th>
                                                    <td>{{ $monitoring->detail->temp ? number_format($monitoring->detail->temp, 1) : '-' }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Neurologis -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingNeurologis">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNeurologis" aria-expanded="false" aria-controls="collapseNeurologis">
                                    <i class="bi bi-brain me-2"></i>Status Neurologis
                                </button>
                            </h2>
                            <div id="collapseNeurologis" class="accordion-collapse collapse" aria-labelledby="headingNeurologis" data-bs-parent="#iccuMonitoringAccordion">
                                <div class="accordion-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="bg-primary text-white" colspan="2">Glasgow Coma Scale (GCS)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th class="bg-light">Respon Mata (E)</th>
                                                    <td>
                                                        @switch($monitoring->detail->gcs_eye)
                                                            @case(4) Spontan @break
                                                            @case(3) Terhadap Suara @break
                                                            @case(2) Terhadap Nyeri @break
                                                            @case(1) Tidak Ada Respon @break
                                                            @default - @break
                                                        @endswitch
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">Respon Verbal (V)</th>
                                                    <td>
                                                        @switch($monitoring->detail->gcs_verbal)
                                                            @case(5) Orientasi Baik @break
                                                            @case(4) Bingung @break
                                                            @case(3) Kata-kata Tidak Jelas @break
                                                            @case(2) Suara Tidak Jelas @break
                                                            @case(1) Tidak Ada Respon @break
                                                            @default - @break
                                                        @endswitch
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">Respon Motorik (M)</th>
                                                    <td>
                                                        @switch($monitoring->detail->gcs_motor)
                                                            @case(6) Mengikuti Perintah @break
                                                            @case(5) Melokalisasi Nyeri @break
                                                            @case(4) Withdrawal @break
                                                            @case(3) Fleksi Abnormal @break
                                                            @case(2) Ekstensi Abnormal @break
                                                            @case(1) Tidak Ada Respon @break
                                                            @default - @break
                                                        @endswitch
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">Total GCS</th>
                                                    <td>{{ $monitoring->detail->gcs_total ?? '-' }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <div class="table-responsive mt-3">
                                        <table class="table table-bordered table-striped mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="bg-primary text-white" colspan="2">Status Pupil</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th class="bg-light">Pupil Kanan</th>
                                                    <td>{{ $monitoring->detail->pupil_kanan ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">Pupil Kiri</th>
                                                    <td>{{ $monitoring->detail->pupil_kiri ?? '-' }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- AGD and Other Parameters -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingClinical">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseClinical" aria-expanded="false" aria-controls="collapseClinical">
                                    <i class="bi bi-clipboard-data me-2"></i>Parameter Klinis
                                </button>
                            </h2>
                            <div id="collapseClinical" class="accordion-collapse collapse" aria-labelledby="headingClinical" data-bs-parent="#iccuMonitoringAccordion">
                                <div class="accordion-body p-0">
                                    <!-- Tabs for clinical parameters -->
                                    <ul class="nav nav-tabs" id="clinicalTabs" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="agd-tab" data-bs-toggle="tab" data-bs-target="#agd" type="button" role="tab" aria-controls="agd" aria-selected="true">AGD</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="elektrolit-tab" data-bs-toggle="tab" data-bs-target="#elektrolit" type="button" role="tab" aria-controls="elektrolit" aria-selected="false">Elektrolit</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="ginjal-tab" data-bs-toggle="tab" data-bs-target="#ginjal" type="button" role="tab" aria-controls="ginjal" aria-selected="false">Fungsi Ginjal</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="hematologi-tab" data-bs-toggle="tab" data-bs-target="#hematologi" type="button" role="tab" aria-controls="hematologi" aria-selected="false">Hematologi</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="hati-tab" data-bs-toggle="tab" data-bs-target="#hati" type="button" role="tab" aria-controls="hati" aria-selected="false">Fungsi Hati</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="tambahan-tab" data-bs-toggle="tab" data-bs-target="#tambahan" type="button" role="tab" aria-controls="tambahan" aria-selected="false">Tambahan</button>
                                        </li>
                                    </ul>
                                    
                                    <div class="tab-content" id="clinicalTabContent">
                                        <!-- AGD Tab -->
                                        <div class="tab-pane fade show active" id="agd" role="tabpanel" aria-labelledby="agd-tab">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <th class="bg-light">pH</th>
                                                            <td>{{ $monitoring->detail->ph ? number_format($monitoring->detail->ph, 2) : '-' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">PO₂ (mmHg)</th>
                                                            <td>{{ $monitoring->detail->po2 ? number_format($monitoring->detail->po2, 1) : '-' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">PCO₂ (mmHg)</th>
                                                            <td>{{ $monitoring->detail->pco2 ? number_format($monitoring->detail->pco2, 1) : '-' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">BE (mmol/L)</th>
                                                            <td>{{ $monitoring->detail->be ? number_format($monitoring->detail->be, 1) : '-' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">HCO₃ (mmol/L)</th>
                                                            <td>{{ $monitoring->detail->hco3 ? number_format($monitoring->detail->hco3, 1) : '-' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Saturasi O₂ (%)</th>
                                                            <td>{{ $monitoring->detail->saturasi_o2 ? number_format($monitoring->detail->saturasi_o2, 1) : '-' }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        
                                        <!-- Elektrolit Tab -->
                                        <div class="tab-pane fade" id="elektrolit" role="tabpanel" aria-labelledby="elektrolit-tab">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <th class="bg-light">Na (mmol/L)</th>
                                                            <td>{{ $monitoring->detail->na ? number_format($monitoring->detail->na, 1) : '-' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">K (mmol/L)</th>
                                                            <td>{{ $monitoring->detail->k ? number_format($monitoring->detail->k, 1) : '-' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Cl (mmol/L)</th>
                                                            <td>{{ $monitoring->detail->cl ? number_format($monitoring->detail->cl, 1) : '-' }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        
                                        <!-- Fungsi Ginjal Tab -->
                                        <div class="tab-pane fade" id="ginjal" role="tabpanel" aria-labelledby="ginjal-tab">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <th class="bg-light">Ureum (mg/dL)</th>
                                                            <td>{{ $monitoring->detail->ureum ? number_format($monitoring->detail->ureum, 1) : '-' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Creatinin (mg/dL)</th>
                                                            <td>{{ $monitoring->detail->creatinin ? number_format($monitoring->detail->creatinin, 2) : '-' }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        
                                        <!-- Hematologi Tab -->
                                        <div class="tab-pane fade" id="hematologi" role="tabpanel" aria-labelledby="hematologi-tab">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <th class="bg-light">Hb (g/dL)</th>
                                                            <td>{{ $monitoring->detail->hb ? number_format($monitoring->detail->hb, 1) : '-' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Ht (%)</th>
                                                            <td>{{ $monitoring->detail->ht ? number_format($monitoring->detail->ht, 1) : '-' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Leukosit (10³/µL)</th>
                                                            <td>{{ $monitoring->detail->leukosit ? number_format($monitoring->detail->leukosit, 2) : '-' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Trombosit (10³/µL)</th>
                                                            <td>{{ $monitoring->detail->trombosit ? number_format($monitoring->detail->trombosit, 0) : '-' }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        
                                        <!-- Fungsi Hati Tab -->
                                        <div class="tab-pane fade" id="hati" role="tabpanel" aria-labelledby="hati-tab">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <th class="bg-light">SGOT (U/L)</th>
                                                            <td>{{ $monitoring->detail->sgot ? number_format($monitoring->detail->sgot, 1) : '-' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">SGPT (U/L)</th>
                                                            <td>{{ $monitoring->detail->sgpt ? number_format($monitoring->detail->sgpt, 1) : '-' }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        
                                        <!-- Parameter Tambahan Tab -->
                                        <div class="tab-pane fade" id="tambahan" role="tabpanel" aria-labelledby="tambahan-tab">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <th class="bg-light">KDGS (mg/dL)</th>
                                                            <td>{{ $monitoring->detail->kdgs ? number_format($monitoring->detail->kdgs, 0) : '-' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Terapi Oksigen</th>
                                                            <td>{{ $monitoring->detail->terapi_oksigen ?? '-' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Albumin (g/dL)</th>
                                                            <td>{{ $monitoring->detail->albumin ? number_format($monitoring->detail->albumin, 1) : '-' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-light">Kesadaran</th>
                                                            <td>
                                                                @switch($monitoring->detail->kesadaran)
                                                                    @case('1') Compos Mentis @break
                                                                    @case('2') Somnolence @break
                                                                    @case('3') Sopor @break
                                                                    @case('4') Coma @break
                                                                    @case('5') Delirium @break
                                                                    @default - @break
                                                                @endswitch
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Ventilator Parameters -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingVentilator">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseVentilator" aria-expanded="false" aria-controls="collapseVentilator">
                                    <i class="bi bi-lungs-fill me-2"></i>Parameter Ventilator
                                </button>
                            </h2>
                            <div id="collapseVentilator" class="accordion-collapse collapse" aria-labelledby="headingVentilator" data-bs-parent="#iccuMonitoringAccordion">
                                <div class="accordion-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped mb-0">
                                            <tbody>
                                                <tr>
                                                    <th class="bg-light">Mode</th>
                                                    <td>{{ $monitoring->detail->ventilator_mode ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">MV (L/min)</th>
                                                    <td>{{ $monitoring->detail->ventilator_mv ? number_format($monitoring->detail->ventilator_mv, 1) : '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">TV (mL)</th>
                                                    <td>{{ $monitoring->detail->ventilator_tv ? number_format($monitoring->detail->ventilator_tv, 0) : '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">FiO2 (%)</th>
                                                    <td>{{ $monitoring->detail->ventilator_fio2 ? number_format($monitoring->detail->ventilator_fio2, 0) : '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">I:E Ratio</th>
                                                    <td>{{ $monitoring->detail->ventilator_ie_ratio ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">P Max (cmH2O)</th>
                                                    <td>{{ $monitoring->detail->ventilator_pmax ? number_format($monitoring->detail->ventilator_pmax, 0) : '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">PEEP/PS (cmH2O)</th>
                                                    <td>{{ $monitoring->detail->ventilator_peep_ps ? number_format($monitoring->detail->ventilator_peep_ps, 0) : '-' }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Medical Device Parameters -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingDevices">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDevices" aria-expanded="false" aria-controls="collapseDevices">
                                    <i class="bi bi-gear-fill me-2"></i>Parameter Perangkat Medis Tambahan
                                </button>
                            </h2>
                            <div id="collapseDevices" class="accordion-collapse collapse" aria-labelledby="headingDevices" data-bs-parent="#iccuMonitoringAccordion">
                                <div class="accordion-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped mb-0">
                                            <tbody>
                                                <tr>
                                                    <th class="bg-light">ETT No</th>
                                                    <td>{{ $monitoring->detail->ett_no ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">Batas Bibir (cm)</th>
                                                    <td>{{ $monitoring->detail->batas_bibir ? number_format($monitoring->detail->batas_bibir, 1) : '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">NGT No</th>
                                                    <td>{{ $monitoring->detail->ngt_no ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">CVC</th>
                                                    <td>{{ $monitoring->detail->cvc ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">Urine Catch No</th>
                                                    <td>{{ $monitoring->detail->urine_catch_no ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">IV Line</th>
                                                    <td>{{ $monitoring->detail->iv_line ?? '-' }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Back Button -->
                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ url("unit-pelayanan/rawat-inap/unit/$kd_unit/pelayanan/$kd_pasien/$tgl_masuk/$urut_masuk/monitoring") }}" 
                           class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Show first accordion item by default
    document.addEventListener('DOMContentLoaded', function() {
        // Optional: add any specific JavaScript functionality here
    });
</script>
@endpush