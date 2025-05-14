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
                <h5 class="text-secondary fw-bold">Edit Monitoring Intensive Care Unit (ICCU)</h5>
            </div>

            <hr>

            <div class="form-section">
                <form action="{{ route('rawat-inap.monitoring.update', [
                                'kd_unit' => $kd_unit,
                                'kd_pasien' => $kd_pasien,
                                'tgl_masuk' => $tgl_masuk,
                                'urut_masuk' => $urut_masuk,
                                'id' => $monitoring->id
                            ]) }}" method="post" id="iccuForm">
                    @csrf
                    @method('PUT')

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
                                            id="tgl_implementasi" value="{{ $monitoring->tgl_implementasi }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Jam Implementasi</label>
                                        <input type="time" class="form-control" name="jam_implementasi"
                                            id="jam_implementasi" value="{{ \Carbon\Carbon::parse($monitoring->jam_implementasi)->format('H:i') }}" required>
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
                                        <textarea class="form-control" name="indikasi_iccu" rows="3" required>{{ $monitoring->indikasi_iccu }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label required">Diagnosa</label>
                                        <input type="text" class="form-control" name="diagnosa" value="{{ $monitoring->diagnosa }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Alergi</label>
                                        <textarea class="form-control" name="alergi" rows="3" placeholder="Tuliskan jika ada alergi">{{ $monitoring->alergi }}</textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Berat Badan (kg)</label>
                                                <input type="number" step="0.1" min="0" class="form-control"
                                                    name="berat_badan" value="{{ $monitoring->berat_badan ? number_format($monitoring->berat_badan, 1) : '' }}" placeholder="kg">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Tinggi Badan (cm)</label>
                                                <input type="number" step="1" min="0" class="form-control"
                                                    name="tinggi_badan" value="{{ $monitoring->tinggi_badan ? number_format($monitoring->tinggi_badan, 0) : '' }}" placeholder="cm">
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
                                        <input type="text" class="form-control" name="bab" value="{{ $monitoring->bab }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Urine</label>
                                        <input type="text" class="form-control" name="urine" value="{{ $monitoring->urine }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">IWL</label>
                                        <input type="text" class="form-control" name="iwl" value="{{ $monitoring->iwl }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Muntahan/CMS</label>
                                        <input type="text" class="form-control" name="muntahan_cms" value="{{ $monitoring->muntahan_cms }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Drain</label>
                                        <input type="text" class="form-control" name="drain" value="{{ $monitoring->drain }}">
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
                                        <label class="form-label">Sistolik (mmHg)</label>
                                        <input type="number" class="form-control" name="sistolik" id="sistolik" value="{{ $monitoring->detail->sistolik ? number_format($monitoring->detail->sistolik, 0) : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Diastolik (mmHg)</label>
                                        <input type="number" class="form-control" name="diastolik" id="diastolik" value="{{ $monitoring->detail->diastolik ? number_format($monitoring->detail->diastolik, 0) : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">MAP</label>
                                        <input type="number" class="form-control" name="map" id="map" value="{{ $monitoring->detail->map ? number_format($monitoring->detail->map, 0) : '' }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Heart Rate (HR) <small>bpm</small></label>
                                        <input type="number" class="form-control" name="hr" value="{{ $monitoring->detail->hr ? number_format($monitoring->detail->hr, 0) : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Resp. Rate (RR) <small>x/menit</small></label>
                                        <input type="number" class="form-control" name="rr" value="{{ $monitoring->detail->rr ? number_format($monitoring->detail->rr, 0) : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Suhu (°C)</label>
                                        <input type="number" step="0.1" class="form-control" name="temp" value="{{ $monitoring->detail->temp ? number_format($monitoring->detail->temp, 1) : '' }}">
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
                                            <option value="4" {{ $monitoring->detail->gcs_eye == 4 ? 'selected' : '' }}>4 - Spontan</option>
                                            <option value="3" {{ $monitoring->detail->gcs_eye == 3 ? 'selected' : '' }}>3 - Terhadap Suara</option>
                                            <option value="2" {{ $monitoring->detail->gcs_eye == 2 ? 'selected' : '' }}>2 - Terhadap Nyeri</option>
                                            <option value="1" {{ $monitoring->detail->gcs_eye == 1 ? 'selected' : '' }}>1 - Tidak Ada Respon</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Respon Verbal (V)</label>
                                        <select class="form-select gcs-component" name="gcs_verbal" id="gcs_verbal">
                                            <option value="">- Pilih -</option>
                                            <option value="5" {{ $monitoring->detail->gcs_verbal == 5 ? 'selected' : '' }}>5 - Orientasi Baik</option>
                                            <option value="4" {{ $monitoring->detail->gcs_verbal == 4 ? 'selected' : '' }}>4 - Bingung</option>
                                            <option value="3" {{ $monitoring->detail->gcs_verbal == 3 ? 'selected' : '' }}>3 - Kata-kata Tidak Jelas</option>
                                            <option value="2" {{ $monitoring->detail->gcs_verbal == 2 ? 'selected' : '' }}>2 - Suara Tidak Jelas</option>
                                            <option value="1" {{ $monitoring->detail->gcs_verbal == 1 ? 'selected' : '' }}>1 - Tidak Ada Respon</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Respon Motorik (M)</label>
                                        <select class="form-select gcs-component" name="gcs_motor" id="gcs_motor">
                                            <option value="">- Pilih -</option>
                                            <option value="6" {{ $monitoring->detail->gcs_motor == 6 ? 'selected' : '' }}>6 - Mengikuti Perintah</option>
                                            <option value="5" {{ $monitoring->detail->gcs_motor == 5 ? 'selected' : '' }}>5 - Melokalisasi Nyeri</option>
                                            <option value="4" {{ $monitoring->detail->gcs_motor == 4 ? 'selected' : '' }}>4 - Withdrawal</option>
                                            <option value="3" {{ $monitoring->detail->gcs_motor == 3 ? 'selected' : '' }}>3 - Fleksi Abnormal</option>
                                            <option value="2" {{ $monitoring->detail->gcs_motor == 2 ? 'selected' : '' }}>2 - Ekstensi Abnormal</option>
                                            <option value="1" {{ $monitoring->detail->gcs_motor == 1 ? 'selected' : '' }}>1 - Tidak Ada Respon</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Total GCS</label>
                                        <input type="number" class="form-control" name="gcs_total" id="gcs_total" value="{{ $monitoring->detail->gcs_total ?? '' }}" readonly>
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
                                            <option value="isokor" {{ $monitoring->detail->pupil_kanan == 'isokor' ? 'selected' : '' }}>Isokor</option>
                                            <option value="anisokor" {{ $monitoring->detail->pupil_kanan == 'anisokor' ? 'selected' : '' }}>Anisokor</option>
                                            <option value="midriasis" {{ $monitoring->detail->pupil_kanan == 'midriasis' ? 'selected' : '' }}>Midriasis</option>
                                            <option value="miosis" {{ $monitoring->detail->pupil_kanan == 'miosis' ? 'selected' : '' }}>Miosis</option>
                                            <option value="pinpoint" {{ $monitoring->detail->pupil_kanan == 'pinpoint' ? 'selected' : '' }}>Pinpoint</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Pupil Kiri</label>
                                        <select class="form-select" name="pupil_kiri">
                                            <option value="">- Pilih -</option>
                                            <option value="isokor" {{ $monitoring->detail->pupil_kiri == 'isokor' ? 'selected' : '' }}>Isokor</option>
                                            <option value="anisokor" {{ $monitoring->detail->pupil_kiri == 'anisokor' ? 'selected' : '' }}>Anisokor</option>
                                            <option value="midriasis" {{ $monitoring->detail->pupil_kiri == 'midriasis' ? 'selected' : '' }}>Midriasis</option>
                                            <option value="miosis" {{ $monitoring->detail->pupil_kiri == 'miosis' ? 'selected' : '' }}>Miosis</option>
                                            <option value="pinpoint" {{ $monitoring->detail->pupil_kiri == 'pinpoint' ? 'selected' : '' }}>Pinpoint</option>
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
                                        <input type="number" step="0.01" class="form-control" name="ph" value="{{ $monitoring->detail->ph ? number_format($monitoring->detail->ph, 2) : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">PO<sub>2</sub> (mmHg)</label>
                                        <input type="number" step="0.1" class="form-control" name="po2" value="{{ $monitoring->detail->po2 ? number_format($monitoring->detail->po2, 1) : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">PCO<sub>2</sub> (mmHg)</label>
                                        <input type="number" step="0.1" class="form-control" name="pco2" value="{{ $monitoring->detail->pco2 ? number_format($monitoring->detail->pco2, 1) : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">BE (mmol/L)</label>
                                        <input type="number" step="0.1" class="form-control" name="be" value="{{ $monitoring->detail->be ? number_format($monitoring->detail->be, 1) : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">HCO<sub>3</sub> (mmol/L)</label>
                                        <input type="number" step="0.1" class="form-control" name="hco3" value="{{ $monitoring->detail->hco3 ? number_format($monitoring->detail->hco3, 1) : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">Saturasi O<sub>2</sub> (%)</label>
                                        <input type="number" step="0.1" class="form-control" name="saturasi_o2" value="{{ $monitoring->detail->saturasi_o2 ? number_format($monitoring->detail->saturasi_o2, 1) : '' }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Elektrolit Parameters -->
                            <h6 class="mb-3 border-bottom pb-2">Elektrolit</h6>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Na (mmol/L)</label>
                                        <input type="number" step="0.1" class="form-control" name="na" value="{{ $monitoring->detail->na ? number_format($monitoring->detail->na, 1) : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">K (mmol/L)</label>
                                        <input type="number" step="0.1" class="form-control" name="k" value="{{ $monitoring->detail->k ? number_format($monitoring->detail->k, 1) : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Cl (mmol/L)</label>
                                        <input type="number" step="0.1" class="form-control" name="cl" value="{{ $monitoring->detail->cl ? number_format($monitoring->detail->cl, 1) : '' }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Renal Function Parameters -->
                            <h6 class="mb-3 border-bottom pb-2">Fungsi Ginjal</h6>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Ureum (mg/dL)</label>
                                        <input type="number" step="0.1" class="form-control" name="ureum" value="{{ $monitoring->detail->ureum ? number_format($monitoring->detail->ureum, 1) : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Creatinin (mg/dL)</label>
                                        <input type="number" step="0.01" class="form-control" name="creatinin" value="{{ $monitoring->detail->creatinin ? number_format($monitoring->detail->creatinin, 2) : '' }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Hematology Parameters -->
                            <h6 class="mb-3 border-bottom pb-2">Hematologi</h6>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Hb (g/dL)</label>
                                        <input type="number" step="0.1" class="form-control" name="hb" value="{{ $monitoring->detail->hb ? number_format($monitoring->detail->hb, 1) : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Ht (%)</label>
                                        <input type="number" step="0.1" class="form-control" name="ht" value="{{ $monitoring->detail->ht ? number_format($monitoring->detail->ht, 1) : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Leukosit (10³/µL)</label>
                                        <input type="number" step="0.01" class="form-control" name="leukosit" value="{{ $monitoring->detail->leukosit ? number_format($monitoring->detail->leukosit, 2) : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Trombosit (10³/µL)</label>
                                        <input type="number" class="form-control" name="trombosit" value="{{ $monitoring->detail->trombosit ? number_format($monitoring->detail->trombosit, 0) : '' }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Liver Function Parameters -->
                            <h6 class="mb-3 border-bottom pb-2">Fungsi Hati</h6>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">SGOT (U/L)</label>
                                        <input type="number" step="0.1" class="form-control" name="sgot" value="{{ $monitoring->detail->sgot ? number_format($monitoring->detail->sgot, 1) : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">SGPT (U/L)</label>
                                        <input type="number" step="0.1" class="form-control" name="sgpt" value="{{ $monitoring->detail->sgpt ? number_format($monitoring->detail->sgpt, 1) : '' }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Other Parameters -->
                            <h6 class="mb-3 border-bottom pb-2">Parameter Tambahan</h6>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">KDGS (mg/dL)</label>
                                        <input type="number" step="1" class="form-control" name="kdgs" value="{{ $monitoring->detail->kdgs ? number_format($monitoring->detail->kdgs, 0) : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Terapi Oksigen</label>
                                        <input type="text" class="form-control" name="terapi_oksigen" value="{{ $monitoring->detail->terapi_oksigen }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Albumin (g/dL)</label>
                                        <input type="number" step="0.1" class="form-control" name="albumin" value="{{ $monitoring->detail->albumin ? number_format($monitoring->detail->albumin, 1) : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Kesadaran</label>
                                        <select class="form-select" name="kesadaran">
                                            <option value="">- Pilih -</option>
                                            <option value="1" {{ $monitoring->detail->kesadaran == '1' ? 'selected' : '' }}>Compos Mentis</option>
                                            <option value="2" {{ $monitoring->detail->kesadaran == '2' ? 'selected' : '' }}>Somnolence</option>
                                            <option value="3" {{ $monitoring->detail->kesadaran == '3' ? 'selected' : '' }}>Sopor</option>
                                            <option value="4" {{ $monitoring->detail->kesadaran == '4' ? 'selected' : '' }}>Coma</option>
                                            <option value="5" {{ $monitoring->detail->kesadaran == '5' ? 'selected' : '' }}>Delirium</option>
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
                                        <input type="text" class="form-control" name="ventilator_mode" value="{{ $monitoring->detail->ventilator_mode }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">MV (L/min)</label>
                                        <input type="number" step="0.1" class="form-control" name="ventilator_mv" value="{{ $monitoring->detail->ventilator_mv ? number_format($monitoring->detail->ventilator_mv, 1) : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">TV (mL)</label>
                                        <input type="number" step="1" class="form-control" name="ventilator_tv" value="{{ $monitoring->detail->ventilator_tv ? number_format($monitoring->detail->ventilator_tv, 0) : '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">FiO2 (%)</label>
                                        <input type="number" step="1" class="form-control" name="ventilator_fio2" value="{{ $monitoring->detail->ventilator_fio2 ? number_format($monitoring->detail->ventilator_fio2, 0) : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">I:E Ratio</label>
                                        <input type="text" class="form-control" name="ventilator_ie_ratio" value="{{ $monitoring->detail->ventilator_ie_ratio }}" placeholder="e.g., 1:2">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">P Max (cmH2O)</label>
                                        <input type="number" step="1" class="form-control" name="ventilator_pmax" value="{{ $monitoring->detail->ventilator_pmax ? number_format($monitoring->detail->ventilator_pmax, 0) : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">PEEP/PS (cmH2O)</label>
                                        <input type="number" step="1" class="form-control" name="ventilator_peep_ps" value="{{ $monitoring->detail->ventilator_peep_ps ? number_format($monitoring->detail->ventilator_peep_ps, 0) : '' }}">
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
                                        <input type="text" class="form-control" name="ett_no" value="{{ $monitoring->detail->ett_no }}" placeholder="Nomor ETT">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Batas Bibir (cm)</label>
                                        <input type="number" step="0.1" class="form-control" name="batas_bibir" min="0" value="{{ $monitoring->detail->batas_bibir ? number_format($monitoring->detail->batas_bibir, 1) : '' }}" placeholder="cm">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">NGT No</label>
                                        <input type="text" class="form-control" name="ngt_no" value="{{ $monitoring->detail->ngt_no }}" placeholder="Nomor NGT">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">CVC</label>
                                        <input type="text" class="form-control" name="cvc" value="{{ $monitoring->detail->cvc }}" placeholder="Jenis CVC">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Urine Catch No</label>
                                        <input type="text" class="form-control" name="urine_catch_no" value="{{ $monitoring->detail->urine_catch_no }}" placeholder="Nomor Urine Catch">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">IV Line</label>
                                        <input type="text" class="form-control" name="iv_line" value="{{ $monitoring->detail->iv_line }}" placeholder="Jenis IV Line">
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
