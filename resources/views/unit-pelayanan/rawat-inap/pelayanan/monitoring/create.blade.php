@extends('layouts.administrator.master')

@section('content')
    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
        <style>
            .card-header {
                font-weight: bold;
            }

            .form-label {
                font-weight: 600;
                margin-bottom: 0.3rem;
            }

            .required::after {
                content: '*';
                color: red;
                margin-left: 0.2rem;
            }

            .invalid-feedback {
                display: none;
            }

            .is-invalid~.invalid-feedback {
                display: block;
            }

            .form-section {
                max-width: 100%;
            }
        </style>
    @endpush

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <div class="text-center mt-1 mb-2">
                <h5 class="text-secondary fw-bold">Monitoring Intensive Care Unit (ICCU)</h5>
            </div>

            <hr>

            <div class="form-section">
                <form action="{{ route('rawat-inap.monitoring.store', [
                                'kd_unit' => $kd_unit,
                                'kd_pasien' => $kd_pasien,
                                'tgl_masuk' => $tgl_masuk,
                                'urut_masuk' => $urut_masuk,
                            ]) }}" method="post" id="iccuForm">
                    @csrf

                    <!-- Form Date and Time Section with Validation -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <small class="text-warning mb-2">
                                    <i class="bi bi-exclamation-triangle-fill"></i>
                                    Pastikan jam diisi dengan benar untuk keakuratan dokumentasi medis
                                </small>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Tanggal Implementasi</label>
                                        <input type="date" class="form-control" name="tgl_implementasi"
                                            id="tgl_implementasi" value="{{ date('Y-m-d') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Jam Implementasi</label>
                                        <input type="time" class="form-control" name="jam_implementasi"
                                            id="jam_implementasi" value="{{ date('H:i') }}" required>
                                        <div class="invalid-feedback" id="timeError">
                                            Pastikan format jam benar (HH:MM)
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Patient Information Section -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">
                                <i class="bi bi-person-lines-fill me-2"></i>
                                Informasi Pasien
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Indikasi ICCU</label>
                                        <textarea class="form-control" name="indikasi_iccu" rows="3" required>{{ $latestMonitoring->indikasi_iccu ?? '' }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label required">Diagnosa</label>
                                        <input type="text" class="form-control" name="diagnosa" value="{{ $latestMonitoring->diagnosa ?? '' }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Alergi</label>
                                        <textarea class="form-control" name="alergi" rows="3" placeholder="Tuliskan jika ada alergi">{{ $latestMonitoring->alergi ?? '' }}</textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Berat Badan (kg)</label>
                                                <input type="number" step="0.1" min="0" class="form-control"
                                                    name="berat_badan" placeholder="kg" value="{{ $latestMonitoring && $latestMonitoring->berat_badan ? number_format($latestMonitoring->berat_badan, 1) : '' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Tinggi Badan (cm)</label>
                                                <input type="number" step="1" min="0" class="form-control"
                                                    name="tinggi_badan" placeholder="cm" value="{{ $latestMonitoring && $latestMonitoring->tinggi_badan ? number_format($latestMonitoring->tinggi_badan, 0) : '' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Output -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h6 class="mb-3 border-bottom pb-2">Total Intake</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">BAB</label>
                                        <input type="text" class="form-control" name="bab">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Urine</label>
                                        <input type="text" step="0.1" class="form-control" name="urine">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">IWL</label>
                                        <input type="text" step="1" class="form-control" name="iwl">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Muntahan/CMS</label>
                                        <input type="text" step="1" class="form-control" name="muntahan_cms">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Drain</label>
                                        <input type="text" step="1" class="form-control" name="drain">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Monitoring ICCU Parameters -->
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0">
                                <i class="bi bi-heart-pulse-fill me-2"></i>
                                Monitoring ICCU Parameters
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label required">Sistolik (mmHg)</label>
                                        <input type="number" class="form-control" name="sistolik" id="sistolik" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Diastolik (mmHg)</label>
                                        <input type="number" class="form-control" name="diastolik" id="diastolik">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">MAP</label>
                                        <input type="number" class="form-control" name="map" id="map"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Heart Rate (HR) <small>bpm</small></label>
                                        <input type="number" class="form-control" name="hr">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Resp. Rate (RR) <small>x/menit</small></label>
                                        <input type="number" class="form-control" name="rr">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Suhu (°C)</label>
                                        <input type="number" step="0.1" class="form-control" name="temp">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Neurologis Section (GCS and Pupil) -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <!-- GCS Section -->
                            <h6 class="mb-3 border-bottom pb-2">Glasgow Coma Scale (GCS)</h6>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Respon Mata (E)</label>
                                        <select class="form-select gcs-component" name="gcs_eye" id="gcs_eye">
                                            <option value="">- Pilih -</option>
                                            <option value="4">4 - Spontan</option>
                                            <option value="3">3 - Terhadap Suara</option>
                                            <option value="2">2 - Terhadap Nyeri</option>
                                            <option value="1">1 - Tidak Ada Respon</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Respon Verbal (V)</label>
                                        <select class="form-select gcs-component" name="gcs_verbal" id="gcs_verbal">
                                            <option value="">- Pilih -</option>
                                            <option value="5">5 - Orientasi Baik</option>
                                            <option value="4">4 - Bingung</option>
                                            <option value="3">3 - Kata-kata Tidak Jelas</option>
                                            <option value="2">2 - Suara Tidak Jelas</option>
                                            <option value="1">1 - Tidak Ada Respon</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Respon Motorik (M)</label>
                                        <select class="form-select gcs-component" name="gcs_motor" id="gcs_motor">
                                            <option value="">- Pilih -</option>
                                            <option value="6">6 - Mengikuti Perintah</option>
                                            <option value="5">5 - Melokalisasi Nyeri</option>
                                            <option value="4">4 - Withdrawal</option>
                                            <option value="3">3 - Fleksi Abnormal</option>
                                            <option value="2">2 - Ekstensi Abnormal</option>
                                            <option value="1">1 - Tidak Ada Respon</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Total GCS</label>
                                        <input type="number" class="form-control" name="gcs_total" id="gcs_total" readonly>
                                    </div>
                                </div>
                            </div>

                            <!-- Pupil Section -->
                            <h6 class="mb-3 border-bottom pb-2">Status Pupil</h6>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Pupil Kanan</label>
                                        <select class="form-select" name="pupil_kanan">
                                            <option value="">- Pilih -</option>
                                            <option value="isokor">Isokor</option>
                                            <option value="anisokor">Anisokor</option>
                                            <option value="midriasis">Midriasis</option>
                                            <option value="miosis">Miosis</option>
                                            <option value="pinpoint">Pinpoint</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Pupil Kiri</label>
                                        <select class="form-select" name="pupil_kiri">
                                            <option value="">- Pilih -</option>
                                            <option value="isokor">Isokor</option>
                                            <option value="anisokor">Anisokor</option>
                                            <option value="midriasis">Midriasis</option>
                                            <option value="miosis">Miosis</option>
                                            <option value="pinpoint">Pinpoint</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- AGD and Other Parameters -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <!-- AGD Parameters -->
                            <h6 class="mb-3 border-bottom pb-2">Analisis Gas Darah (AGD)</h6>
                            <div class="row mb-3">
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">pH</label>
                                        <input type="number" step="0.01" class="form-control" name="ph">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">PO<sub>2</sub> (mmHg)</label>
                                        <input type="number" step="0.1" class="form-control" name="po2">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">PCO<sub>2</sub> (mmHg)</label>
                                        <input type="number" step="0.1" class="form-control" name="pco2">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">BE (mmol/L)</label>
                                        <input type="number" step="0.1" class="form-control" name="be">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">HCO<sub>3</sub> (mmol/L)</label>
                                        <input type="number" step="0.1" class="form-control" name="hco3">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">Saturasi O<sub>2</sub> (%)</label>
                                        <input type="number" step="0.1" class="form-control" name="saturasi_o2">
                                    </div>
                                </div>
                            </div>

                            <!-- Elektrolit Parameters -->
                            <h6 class="mb-3 border-bottom pb-2">Elektrolit</h6>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Na (mmol/L)</label>
                                        <input type="number" step="0.1" class="form-control" name="na">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">K (mmol/L)</label>
                                        <input type="number" step="0.1" class="form-control" name="k">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Cl (mmol/L)</label>
                                        <input type="number" step="0.1" class="form-control" name="cl">
                                    </div>
                                </div>
                            </div>

                            <!-- Renal Function Parameters -->
                            <h6 class="mb-3 border-bottom pb-2">Fungsi Ginjal</h6>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Ureum (mg/dL)</label>
                                        <input type="number" step="0.1" class="form-control" name="ureum">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Creatinin (mg/dL)</label>
                                        <input type="number" step="0.01" class="form-control" name="creatinin">
                                    </div>
                                </div>
                            </div>

                            <!-- Hematology Parameters -->
                            <h6 class="mb-3 border-bottom pb-2">Hematologi</h6>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Hb (g/dL)</label>
                                        <input type="number" step="0.1" class="form-control" name="hb">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Ht (%)</label>
                                        <input type="number" step="0.1" class="form-control" name="ht">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Leukosit (10³/µL)</label>
                                        <input type="number" step="0.01" class="form-control" name="leukosit">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Trombosit (10³/µL)</label>
                                        <input type="number" class="form-control" name="trombosit">
                                    </div>
                                </div>
                            </div>

                            <!-- Liver Function Parameters -->
                            <h6 class="mb-3 border-bottom pb-2">Fungsi Hati</h6>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">SGOT (U/L)</label>
                                        <input type="number" step="0.1" class="form-control" name="sgot">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">SGPT (U/L)</label>
                                        <input type="number" step="0.1" class="form-control" name="sgpt">
                                    </div>
                                </div>
                            </div>

                            <!-- Other Parameters -->
                            <h6 class="mb-3 border-bottom pb-2">Parameter Tambahan</h6>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">KDGS (mg/dL)</label>
                                        <input type="number" step="1" class="form-control" name="kdgs">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Terapi Oksigen</label>
                                        <input type="text" class="form-control" name="terapi_oksigen">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Albumin (g/dL)</label>
                                        <input type="number" step="0.1" class="form-control" name="albumin">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Kesadaran</label>
                                        <select class="form-select" name="kesadaran">
                                            <option value="">- Pilih -</option>
                                            <option value="1">Compos Mentis</option>
                                            <option value="2">Somnolence</option>
                                            <option value="3">Sopor</option>
                                            <option value="4">Coma</option>
                                            <option value="5">Delirium</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ventilator Parameters -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h6 class="mb-3 border-bottom pb-2">Parameter Ventilator</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Mode</label>
                                        <input type="text" class="form-control" name="ventilator_mode">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">MV (L/min)</label>
                                        <input type="number" step="0.1" class="form-control" name="ventilator_mv">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">TV (mL)</label>
                                        <input type="number" step="1" class="form-control" name="ventilator_tv">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">FiO2 (%)</label>
                                        <input type="number" step="1" class="form-control" name="ventilator_fio2">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">I:E Ratio</label>
                                        <input type="text" class="form-control" name="ventilator_ie_ratio"
                                            placeholder="e.g., 1:2">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">P Max (cmH2O)</label>
                                        <input type="number" step="1" class="form-control" name="ventilator_pmax">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">PEEP/PS (cmH2O)</label>
                                        <input type="number" step="1" class="form-control"
                                            name="ventilator_peep_ps">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Medical Device Parameters -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h6 class="mb-3 border-bottom pb-2">Parameter Perangkat Medis Tambahan</h6>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">ETT No</label>
                                        <input type="text" class="form-control" name="ett_no" placeholder="Nomor ETT">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Batas Bibir (cm)</label>
                                        <input type="number" step="0.1" class="form-control" name="batas_bibir" min="0" placeholder="cm">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">NGT No</label>
                                        <input type="text" class="form-control" name="ngt_no" placeholder="Nomor NGT">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">CVC</label>
                                        <input type="text" class="form-control" name="cvc" placeholder="Jenis CVC">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Urine Catch No</label>
                                        <input type="text" class="form-control" name="urine_catch_no" placeholder="Nomor Urine Catch">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">IV Line</label>
                                        <input type="text" class="form-control" name="iv_line" placeholder="Jenis IV Line">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Simpan
                            </button>
                            <a href="{{ url("unit-pelayanan/rawat-inap/unit/$kd_unit/pelayanan/$kd_pasien/$tgl_masuk/$urut_masuk/monitoring") }}" class="btn">
                                <i class="ti-arrow-left"></i> Batal
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {


            ///===============================================================================================//
            // Add random data generation button to the form
            ///===============================================================================================//
            $('.row .col-12.text-end').prepend(`
                <button type="button" id="generateRandomData" class="btn btn-warning me-2">
                    <i class="bi bi-shuffle me-1"></i> Isi Data Random
                </button>
            `);

            // Random data generation functionality
            $('#generateRandomData').on('click', function() {
                // Helper function to get random number within range
                function randomNumber(min, max, decimals = 0) {
                    const factor = Math.pow(10, decimals);
                    return Math.round((Math.random() * (max - min) + min) * factor) / factor;
                }
                
                // Helper function to get random item from array
                function randomItem(array) {
                    return array[Math.floor(Math.random() * array.length)];
                }
                
                // Output
                $('[name="bab"]').val(randomNumber(0, 3) + " x");
                $('[name="urine"]').val(randomNumber(500, 2000) + " ml");
                $('[name="iwl"]').val(randomNumber(300, 800) + " ml");
                $('[name="muntahan_cms"]').val(randomNumber(0, 200) + " ml");
                $('[name="drain"]').val(randomNumber(0, 150) + " ml");
                
                // Vital signs
                const sistolik = randomNumber(90, 180);
                const diastolik = randomNumber(60, 110);
                const map = Math.round((sistolik + 2 * diastolik) / 3);
                
                $('[name="sistolik"]').val(sistolik);
                $('[name="diastolik"]').val(diastolik);
                $('[name="map"]').val(map);
                $('[name="hr"]').val(randomNumber(60, 120));
                $('[name="rr"]').val(randomNumber(12, 30));
                $('[name="temp"]').val(randomNumber(36, 39, 1));
                
                // GCS - Glasgow Coma Scale
                const eyeValues = ["", "1", "2", "3", "4"];
                const verbalValues = ["", "1", "2", "3", "4", "5"];
                const motorValues = ["", "1", "2", "3", "4", "5", "6"];
                
                const eyeValue = randomItem(eyeValues);
                const verbalValue = randomItem(verbalValues);
                const motorValue = randomItem(motorValues);
                
                $('#gcs_eye').val(eyeValue);
                $('#gcs_verbal').val(verbalValue);
                $('#gcs_motor').val(motorValue);
                
                // Calculate GCS total if all values are selected
                if (eyeValue && verbalValue && motorValue) {
                    const totalGCS = parseInt(eyeValue) + parseInt(verbalValue) + parseInt(motorValue);
                    $('#gcs_total').val(totalGCS);
                }
                
                // Pupil status
                const pupilStatus = ["", "isokor", "anisokor", "midriasis", "miosis", "pinpoint"];
                $('[name="pupil_kanan"]').val(randomItem(pupilStatus));
                $('[name="pupil_kiri"]').val(randomItem(pupilStatus));
                
                // AGD - Analisis Gas Darah
                $('[name="ph"]').val(randomNumber(7.30, 7.50, 2));
                $('[name="po2"]').val(randomNumber(80, 100, 1));
                $('[name="pco2"]').val(randomNumber(35, 45, 1));
                $('[name="be"]').val(randomNumber(-3, 3, 1));
                $('[name="hco3"]').val(randomNumber(22, 28, 1));
                $('[name="saturasi_o2"]').val(randomNumber(90, 99, 1));
                
                // Elektrolit
                $('[name="na"]').val(randomNumber(135, 145, 1));
                $('[name="k"]').val(randomNumber(3.5, 5.5, 1));
                $('[name="cl"]').val(randomNumber(98, 108, 1));
                
                // Fungsi Ginjal
                $('[name="ureum"]').val(randomNumber(15, 40, 1));
                $('[name="creatinin"]').val(randomNumber(0.6, 1.3, 2));
                
                // Hematologi
                $('[name="hb"]').val(randomNumber(11, 17, 1));
                $('[name="ht"]').val(randomNumber(35, 50, 1));
                $('[name="leukosit"]').val(randomNumber(4, 11, 2));
                $('[name="trombosit"]').val(randomNumber(150, 400));
                
                // Fungsi Hati
                $('[name="sgot"]').val(randomNumber(10, 40, 1));
                $('[name="sgpt"]').val(randomNumber(10, 40, 1));
                
                // Parameter Tambahan
                $('[name="kdgs"]').val(randomNumber(80, 180));
                
                const terapiOksigen = ["Nasal Kanula 2 lpm", "Nasal Kanula 4 lpm", "Non-Rebreathing Mask 10 lpm", "Simple Mask 6 lpm", "Ventilator"];
                $('[name="terapi_oksigen"]').val(randomItem(terapiOksigen));
                $('[name="albumin"]').val(randomNumber(3.5, 5.0, 1));
                
                const kesadaran = ["", "1", "2", "3", "4", "5"];
                $('[name="kesadaran"]').val(randomItem(kesadaran));
                
                // Ventilator Parameters
                const ventModes = ["SIMV", "CPAP", "BiPAP", "AC", "PC", "PSV"];
                $('[name="ventilator_mode"]').val(randomItem(ventModes));
                $('[name="ventilator_mv"]').val(randomNumber(6, 12, 1));
                $('[name="ventilator_tv"]').val(randomNumber(350, 650));
                $('[name="ventilator_fio2"]').val(randomNumber(21, 80));
                
                const ieRatios = ["1:2", "1:1.5", "1:3", "1:4"];
                $('[name="ventilator_ie_ratio"]').val(randomItem(ieRatios));
                $('[name="ventilator_pmax"]').val(randomNumber(15, 30));
                $('[name="ventilator_peep_ps"]').val(randomNumber(5, 12));
                
                // Medical Devices
                const ettSizes = ["7.0", "7.5", "8.0", "8.5"];
                const ngtSizes = ["14", "16", "18"];
                const cvcTypes = ["Subclavian", "Jugularis", "Femoralis", ""];
                const ivLineTypes = ["Perifer", "Central", "PICC", ""];
                
                $('[name="ett_no"]').val(randomItem(ettSizes));
                $('[name="batas_bibir"]').val(randomNumber(19, 24, 1));
                $('[name="ngt_no"]').val(randomItem(ngtSizes));
                $('[name="cvc"]').val(randomItem(cvcTypes));
                $('[name="urine_catch_no"]').val(randomNumber(14, 18));
                $('[name="iv_line"]').val(randomItem(ivLineTypes));
                
                // Trigger input events to calculate derived values
                $('#sistolik, #diastolik').trigger('input');
                $('.gcs-component').trigger('change');
            });

            ///===============================================================================================//
            // Add random data generation button to the form
            ///===============================================================================================//

            // Validasi jam
            $('#jam_implementasi').on('change', function() {
                const timePattern = /^([01]?[0-9]|2[0-3]):[0-5][0-9]$/;
                const timeValue = $(this).val();

                if (!timePattern.test(timeValue)) {
                    $(this).addClass('is-invalid');
                    $('#timeError').show();
                } else {
                    $(this).removeClass('is-invalid');
                    $('#timeError').hide();
                }
            });

            // Kalkulasi MAP (Mean Arterial Pressure)
            $('#sistolik, #diastolik').on('input', function() {
                const sistolik = parseFloat($('#sistolik').val()) || 0;
                const diastolik = parseFloat($('#diastolik').val()) || 0;

                // Only calculate MAP if both values are provided and within reasonable ranges
                if (sistolik > 0 && sistolik <= 300 && diastolik > 0 && diastolik <= 200) {
                    const map = Math.round((sistolik + 2 * diastolik) / 3);
                    $('#map').val(map);
                } else {
                    $('#map').val('');
                }
            });

            // Kalkulasi total GCS
            $('.gcs-component').on('change', function() {
                calculateGCS();
            });

            function calculateGCS() {
                const eyeValue = parseInt($('#gcs_eye').val()) || 0;
                const verbalValue = parseInt($('#gcs_verbal').val()) || 0;
                const motorValue = parseInt($('#gcs_motor').val()) || 0;

                // Only calculate if all three components are selected
                if (eyeValue > 0 && verbalValue > 0 && motorValue > 0) {
                    const totalGCS = eyeValue + verbalValue + motorValue;
                    if (totalGCS >= 3 && totalGCS <= 15) {
                        $('#gcs_total').val(totalGCS);
                    } else {
                        $('#gcs_total').val('');
                    }
                } else {
                    $('#gcs_total').val('');
                }
            }

            // Validasi form sebelum submit
            $('#iccuForm').on('submit', function(e) {
                const requiredFields = [
                    'tgl_implementasi',
                    'jam_implementasi',
                    'indikasi_iccu',
                    'diagnosa'
                ];

                let isValid = true;

                requiredFields.forEach(function(field) {
                    const fieldValue = $(`[name="${field}"]`).val();
                    if (!fieldValue || fieldValue.trim() === '') {
                        $(`[name="${field}"]`).addClass('is-invalid');
                        isValid = false;
                    } else {
                        $(`[name="${field}"]`).removeClass('is-invalid');
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    alert('Mohon lengkapi data yang wajib diisi!');
                }
            });
        });
    </script>
@endpush