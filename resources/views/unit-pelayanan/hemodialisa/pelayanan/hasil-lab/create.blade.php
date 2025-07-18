@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .form-label {
            font-weight: 600;
            margin-bottom: 0.3rem;
            color: #2c3e50;
            font-size: 0.85rem;
        }

        .header-asesmen {
            margin-top: 0.5rem;
            font-size: 1.3rem;
            font-weight: 600;
            color: #0c82dc;
            text-align: center;
            margin-bottom: 1.2rem;
        }

        .btn-outline-primary {
            color: #097dd6;
            border-color: #097dd6;
        }

        .btn-outline-primary:hover {
            background-color: #097dd6;
            color: white;
        }

        .form-section {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 1rem;
            margin-bottom: 1.2rem;
        }

        .section-title {
            font-weight: 600;
            color: #004b85;
            margin-bottom: 1rem;
            font-size: 1rem;
            border-bottom: 2px solid #097dd6;
            padding-bottom: 0.3rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 0.3rem;
            display: block;
            font-size: 0.8rem;
        }

        .form-control {
            border-radius: 4px;
            border: 1px solid #ced4da;
            padding: 0.5rem;
            font-size: 0.85rem;
            height: auto;
        }

        .form-control:focus {
            border-color: #097dd6;
            box-shadow: 0 0 0 0.15rem rgba(9, 125, 214, 0.25);
        }

        .input-with-unit {
            display: flex;
            align-items: center;
        }

        .input-with-unit .form-control {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
            border-right: none;
        }

        .unit-label {
            background-color: #e9ecef;
            border: 1px solid #ced4da;
            border-left: none;
            padding: 0.5rem 0.7rem;
            border-top-right-radius: 4px;
            border-bottom-right-radius: 4px;
            font-weight: 500;
            color: #6c757d;
            white-space: nowrap;
            min-width: 60px;
            font-size: 0.75rem;
        }

        .pre-post-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.8rem;
        }

        .pre-post-item {
            background-color: white;
            padding: 0.7rem;
            border: 1px solid #dee2e6;
            border-radius: 4px;
        }

        .pre-post-item label {
            font-weight: 600;
            color: #097dd6;
            margin-bottom: 0.3rem;
            font-size: 0.75rem;
        }

        .datetime-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.8rem;
        }

        .datetime-item label {
            font-weight: 500;
            color: #6c757d;
            font-size: 0.75rem;
        }

        .row {
            margin-left: -0.5rem;
            margin-right: -0.5rem;
        }

        .row > [class*="col-"] {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .pre-post-container {
                grid-template-columns: 1fr;
            }
            
            .datetime-group {
                grid-template-columns: 1fr;
            }
            
            .form-section {
                padding: 0.8rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <a href="{{ route('hemodialisa.pelayanan.hasil-lab.index', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}" class="btn btn-outline-primary mb-2">
                <i class="ti-arrow-left"></i> Kembali
            </a>

            <form id="hasilLabForm" method="POST"
                action="{{ route('hemodialisa.pelayanan.hasil-lab.store', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}">
                @csrf

                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="header-asesmen">Form Tambah Data Hasil Lab</h4>

                        <!-- Tanggal dan Jam Implementasi -->
                        <div class="form-section">
                            <h5 class="section-title">Tanggal dan Jam Implementasi</h5>
                            
                            <div class="form-group">
                                <label class="form-label">Tanggal dan Jam Implementasi</label>
                                <div class="datetime-group">
                                    <div class="datetime-item">
                                        <label>Tanggal</label>
                                        <input type="date" class="form-control" name="tanggal_implementasi" required>
                                    </div>
                                    <div class="datetime-item">
                                        <label>Jam</label>
                                        <input type="time" class="form-control" name="jam_implementasi" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bagian Hematologi -->
                        <div class="form-section">
                            <h5 class="section-title">Hematologi</h5>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="hb" class="form-label">Hemoglobin (Hb)</label>
                                        <div class="input-with-unit">
                                            <input type="number" step="0.1" class="form-control" id="hb" name="hb" placeholder="12.5">
                                            <span class="unit-label">g/dL</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="leukosit" class="form-label">Leukosit</label>
                                        <div class="input-with-unit">
                                            <input type="number" step="0.1" class="form-control" id="leukosit" name="leukosit" placeholder="8.5">
                                            <span class="unit-label">10³/µL</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="thrombosit" class="form-label">Thrombosit</label>
                                        <div class="input-with-unit">
                                            <input type="number" class="form-control" id="thrombosit" name="thrombosit" placeholder="250000">
                                            <span class="unit-label">10³/µL</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="hematokrit" class="form-label">Hematokrit</label>
                                        <div class="input-with-unit">
                                            <input type="number" step="0.1" class="form-control" id="hematokrit" name="hematokrit" placeholder="38.5">
                                            <span class="unit-label">%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="eritrosit" class="form-label">Eritrosit</label>
                                        <div class="input-with-unit">
                                            <input type="number" step="0.1" class="form-control" id="eritrosit" name="eritrosit" placeholder="4.5">
                                            <span class="unit-label">10⁶/µL</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="led" class="form-label">LED</label>
                                        <div class="input-with-unit">
                                            <input type="number" class="form-control" id="led" name="led" placeholder="15">
                                            <span class="unit-label">mm/jam</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="golongan_darah" class="form-label">Golongan Darah</label>
                                        <select class="form-control" id="golongan_darah" name="golongan_darah">
                                            <option value="">Pilih Golongan Darah</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="AB">AB</option>
                                            <option value="O">O</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bagian Ginjal -->
                        <div class="form-section">
                            <h5 class="section-title">Fungsi Ginjal</h5>
                            
                            <div class="form-group">
                                <label class="form-label">Ureum</label>
                                <div class="pre-post-container">
                                    <div class="pre-post-item">
                                        <label>Pre-Dialisis</label>
                                        <div class="input-with-unit">
                                            <input type="number" step="0.1" class="form-control" name="ureum_pre" placeholder="120">
                                            <span class="unit-label">mg/dL</span>
                                        </div>
                                    </div>
                                    <div class="pre-post-item">
                                        <label>Post-Dialisis</label>
                                        <div class="input-with-unit">
                                            <input type="number" step="0.1" class="form-control" name="ureum_post" placeholder="40">
                                            <span class="unit-label">mg/dL</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="urr" class="form-label">URR (Urea Reduction Ratio)</label>
                                        <div class="input-with-unit">
                                            <input type="number" step="0.1" class="form-control" id="urr" name="urr" placeholder="65">
                                            <span class="unit-label">%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="asam_urat" class="form-label">Asam Urat</label>
                                        <div class="input-with-unit">
                                            <input type="number" step="0.1" class="form-control" id="asam_urat" name="asam_urat" placeholder="7.5">
                                            <span class="unit-label">mg/dL</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Kreatinin</label>
                                <div class="pre-post-container">
                                    <div class="pre-post-item">
                                        <label>Pre-Dialisis</label>
                                        <div class="input-with-unit">
                                            <input type="number" step="0.1" class="form-control" name="kreatinin_pre" placeholder="8.5">
                                            <span class="unit-label">mg/dL</span>
                                        </div>
                                    </div>
                                    <div class="pre-post-item">
                                        <label>Post-Dialisis</label>
                                        <div class="input-with-unit">
                                            <input type="number" step="0.1" class="form-control" name="kreatinin_post" placeholder="3.2">
                                            <span class="unit-label">mg/dL</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bagian Anemia -->
                        <div class="form-section">
                            <h5 class="section-title">Anemia</h5>
                            
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="besi_fe" class="form-label">Besi (Fe)</label>
                                        <div class="input-with-unit">
                                            <input type="number" step="0.1" class="form-control" id="besi_fe" name="besi_fe" placeholder="80">
                                            <span class="unit-label">µg/dL</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="tibc" class="form-label">TIBC</label>
                                        <div class="input-with-unit">
                                            <input type="number" step="0.1" class="form-control" id="tibc" name="tibc" placeholder="300">
                                            <span class="unit-label">µg/dL</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="saturasi_transferin" class="form-label">Saturasi Transferin</label>
                                        <div class="input-with-unit">
                                            <input type="number" step="0.1" class="form-control" id="saturasi_transferin" name="saturasi_transferin" placeholder="25">
                                            <span class="unit-label">%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="feritin" class="form-label">Feritin</label>
                                        <div class="input-with-unit">
                                            <input type="number" step="0.1" class="form-control" id="feritin" name="feritin" placeholder="200">
                                            <span class="unit-label">ng/mL</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bagian Hati -->
                        <div class="form-section">
                            <h5 class="section-title">Fungsi Hati</h5>
                            
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="sgot" class="form-label">SGOT</label>
                                        <div class="input-with-unit">
                                            <input type="number" step="0.1" class="form-control" id="sgot" name="sgot" placeholder="25">
                                            <span class="unit-label">U/L</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="sgpt" class="form-label">SGPT</label>
                                        <div class="input-with-unit">
                                            <input type="number" step="0.1" class="form-control" id="sgpt" name="sgpt" placeholder="30">
                                            <span class="unit-label">U/L</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="bilirubin_total" class="form-label">Bilirubin Total</label>
                                        <div class="input-with-unit">
                                            <input type="number" step="0.1" class="form-control" id="bilirubin_total" name="bilirubin_total" placeholder="1.2">
                                            <span class="unit-label">mg/dL</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="bilirubin_direct" class="form-label">Bilirubin Direct</label>
                                        <div class="input-with-unit">
                                            <input type="number" step="0.1" class="form-control" id="bilirubin_direct" name="bilirubin_direct" placeholder="0.3">
                                            <span class="unit-label">mg/dL</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="protein_total" class="form-label">Protein Total</label>
                                        <div class="input-with-unit">
                                            <input type="number" step="0.1" class="form-control" id="protein_total" name="protein_total" placeholder="7.5">
                                            <span class="unit-label">g/dL</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="albumin" class="form-label">Albumin</label>
                                        <div class="input-with-unit">
                                            <input type="number" step="0.1" class="form-control" id="albumin" name="albumin" placeholder="4.2">
                                            <span class="unit-label">g/dL</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="fosfatase_alkali" class="form-label">Fosfatase Alkali</label>
                                        <div class="input-with-unit">
                                            <input type="number" step="0.1" class="form-control" id="fosfatase_alkali" name="fosfatase_alkali" placeholder="120">
                                            <span class="unit-label">U/L</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="gamma_gt" class="form-label">Gamma GT</label>
                                        <div class="input-with-unit">
                                            <input type="number" step="0.1" class="form-control" id="gamma_gt" name="gamma_gt" placeholder="45">
                                            <span class="unit-label">U/L</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bagian Diabetes Melitus -->
                        <div class="form-section">
                            <h5 class="section-title">Diabetes Melitus</h5>
                            
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="glukosa_puasa" class="form-label">Glukosa Puasa</label>
                                        <div class="input-with-unit">
                                            <input type="number" step="0.1" class="form-control" id="glukosa_puasa" name="glukosa_puasa" placeholder="100">
                                            <span class="unit-label">mg/dL</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="glukosa_2jam_pp" class="form-label">Glukosa 2 Jam PP</label>
                                        <div class="input-with-unit">
                                            <input type="number" step="0.1" class="form-control" id="glukosa_2jam_pp" name="glukosa_2jam_pp" placeholder="140">
                                            <span class="unit-label">mg/dL</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="glukosa_sewaktu" class="form-label">Glukosa Sewaktu</label>
                                        <div class="input-with-unit">
                                            <input type="number" step="0.1" class="form-control" id="glukosa_sewaktu" name="glukosa_sewaktu" placeholder="120">
                                            <span class="unit-label">mg/dL</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="hb1a1c" class="form-label">HbA1c</label>
                                        <div class="input-with-unit">
                                            <input type="number" step="0.1" class="form-control" id="hb1a1c" name="hb1a1c" placeholder="7.0">
                                            <span class="unit-label">%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bagian Lemak -->
                        <div class="form-section">
                            <h5 class="section-title">Lemak</h5>
                            
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="kolesterol_total" class="form-label">Kolesterol Total</label>
                                        <div class="input-with-unit">
                                            <input type="number" step="0.1" class="form-control" id="kolesterol_total" name="kolesterol_total" placeholder="200">
                                            <span class="unit-label">mg/dL</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="ldl_c" class="form-label">LDL-C</label>
                                        <div class="input-with-unit">
                                            <input type="number" step="0.1" class="form-control" id="ldl_c" name="ldl_c" placeholder="130">
                                            <span class="unit-label">mg/dL</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="hdl_c" class="form-label">HDL-C</label>
                                        <div class="input-with-unit">
                                            <input type="number" step="0.1" class="form-control" id="hdl_c" name="hdl_c" placeholder="40">
                                            <span class="unit-label">mg/dL</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="trigliserida" class="form-label">Trigliserida</label>
                                        <div class="input-with-unit">
                                            <input type="number" step="0.1" class="form-control" id="trigliserida" name="trigliserida" placeholder="150">
                                            <span class="unit-label">mg/dL</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bagian Jantung -->
                        <div class="form-section">
                            <h5 class="section-title">Faal Jantung</h5>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ck" class="form-label">CK</label>
                                        <div class="input-with-unit">
                                            <input type="number" step="0.1" class="form-control" id="ck" name="ck" placeholder="100">
                                            <span class="unit-label">U/L</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ck_mb" class="form-label">CK-MB</label>
                                        <div class="input-with-unit">
                                            <input type="number" step="0.1" class="form-control" id="ck_mb" name="ck_mb" placeholder="25">
                                            <span class="unit-label">U/L</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="troponin_t" class="form-label">Troponin T</label>
                                        <div class="input-with-unit">
                                            <input type="number" step="0.01" class="form-control" id="troponin_t" name="troponin_t" placeholder="0.02">
                                            <span class="unit-label">ng/mL</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="troponin_i" class="form-label">Troponin I</label>
                                        <div class="input-with-unit">
                                            <input type="number" step="0.01" class="form-control" id="troponin_i" name="troponin_i" placeholder="0.04">
                                            <span class="unit-label">ng/mL</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ldh" class="form-label">LDH</label>
                                        <div class="input-with-unit">
                                            <input type="number" step="0.1" class="form-control" id="ldh" name="ldh" placeholder="200">
                                            <span class="unit-label">U/L</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bagian Elektrolit -->
                        <div class="form-section">
                            <h5 class="section-title">Elektrolit</h5>
                            
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="natrium" class="form-label">Natrium</label>
                                        <div class="input-with-unit">
                                            <input type="number" step="0.1" class="form-control" id="natrium" name="natrium" placeholder="140">
                                            <span class="unit-label">mEq/L</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="kalium" class="form-label">Kalium</label>
                                        <div class="input-with-unit">
                                            <input type="number" step="0.1" class="form-control" id="kalium" name="kalium" placeholder="4.0">
                                            <span class="unit-label">mEq/L</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="calcium_ion" class="form-label">Calcium Ion</label>
                                        <div class="input-with-unit">
                                            <input type="number" step="0.01" class="form-control" id="calcium_ion" name="calcium_ion" placeholder="1.20">
                                            <span class="unit-label">mmol/L</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="clorida" class="form-label">Clorida</label>
                                        <div class="input-with-unit">
                                            <input type="number" step="0.1" class="form-control" id="clorida" name="clorida" placeholder="100">
                                            <span class="unit-label">mEq/L</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="magnesium" class="form-label">Magnesium</label>
                                        <div class="input-with-unit">
                                            <input type="number" step="0.01" class="form-control" id="magnesium" name="magnesium" placeholder="1.80">
                                            <span class="unit-label">mg/dL</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="calcium_total" class="form-label">Calcium Total</label>
                                        <div class="input-with-unit">
                                            <input type="number" step="0.1" class="form-control" id="calcium_total" name="calcium_total" placeholder="9.5">
                                            <span class="unit-label">mg/dL</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="phospor" class="form-label">Phospor</label>
                                        <div class="input-with-unit">
                                            <input type="number" step="0.1" class="form-control" id="phospor" name="phospor" placeholder="3.5">
                                            <span class="unit-label">mg/dL</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bagian Imunoserology -->
                        <div class="form-section">
                            <h5 class="section-title">Imunoserology</h5>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="hbsag_rapid" class="form-label">HbsAg Rapid</label>
                                        <select class="form-control" id="hbsag_rapid" name="hbsag_rapid">
                                            <option value="">Pilih Hasil</option>
                                            <option value="Non Reactive (-)">Non Reactive (-)</option>
                                            <option value="Reactive (+)">Reactive (+)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="hbsag_elisa" class="form-label">HbsAg Elisa</label>
                                        <select class="form-control" id="hbsag_elisa" name="hbsag_elisa">
                                            <option value="">Pilih Hasil</option>
                                            <option value="Non Reactive (-)">Non Reactive (-)</option>
                                            <option value="Reactive (+)">Reactive (+)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="anti_hcv_rapid" class="form-label">Anti HCV Rapid</label>
                                        <select class="form-control" id="anti_hcv_rapid" name="anti_hcv_rapid">
                                            <option value="">Pilih Hasil</option>
                                            <option value="Non Reactive (-)">Non Reactive (-)</option>
                                            <option value="Reactive (+)">Reactive (+)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="anti_hiv_rapid" class="form-label">Anti HIV Rapid</label>
                                        <select class="form-control" id="anti_hiv_rapid" name="anti_hiv_rapid">
                                            <option value="">Pilih Hasil</option>
                                            <option value="Non Reactive (-)">Non Reactive (-)</option>
                                            <option value="Reactive (+)">Reactive (+)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="anti_hiv_3_metode" class="form-label">Anti HIV 3 Metode</label>
                                        <select class="form-control" id="anti_hiv_3_metode" name="anti_hiv_3_metode">
                                            <option value="">Pilih Hasil</option>
                                            <option value="Non Reactive (-)">Non Reactive (-)</option>
                                            <option value="Reactive (+)">Reactive (+)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="fob" class="form-label">FOB</label>
                                        <select class="form-control" id="fob" name="fob">
                                            <option value="">Pilih Hasil</option>
                                            <option value="Negatif (-)">Negatif (-)</option>
                                            <option value="Positif (+)">Positif (+)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <h5>Pemeriksaan Urine Rutin</h5>
                            <textarea class="form-control" id="pemeriksaan_urine_rutin" name="pemeriksaan_urine_rutin" rows="5" placeholder="Masukkan pemeriksaan urine rutin"></textarea>
                        </div>
                        
                        <div class="form-section">
                            <h5>Pemeriksaan Feres Rutirn</h5>
                            <textarea class="form-control" id="pemeriksaan_feres_rutin" name="pemeriksaan_feres_rutin" rows="5" placeholder="Masukkan pemeriksaan feres rutin"></textarea>
                        </div>

                        <div class="form-section">
                            <h5>Pemeriksaan Lain-Lain</h5>
                            <textarea class="form-control" id="pemeriksaan_lain_lain" name="pemeriksaan_lain_lain" rows="5" placeholder="Masukkan pemeriksaan lain-lain"></textarea>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary px-4" id="simpan">
                                <i class="ti-save mr-2"></i> Simpan Data
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            // Set default date to today
            const today = new Date().toISOString().split('T')[0];
            $('input[name="tanggal_implementasi"]').val(today);
            
            // Set default time to current time
            const now = new Date();
            const currentTime = now.toTimeString().slice(0, 5);
            $('input[name="jam_implementasi"]').val(currentTime);

            // Handle form submission with loading state
            const $form = $('#hasilLabForm');
            const $submitButton = $('#simpan');
            const originalButtonHTML = $submitButton.html();

            $form.on('submit', function(e) {
                // Disable button and show loading
                $submitButton.prop('disabled', true);
                $submitButton.html('<i class="spinner-border spinner-border-sm mr-2" role="status"></i> Menyimpan...');
                
                // Add loading class for additional styling
                $submitButton.addClass('btn-loading');
                
                // Re-enable button after a timeout as fallback (in case form submission fails)
                setTimeout(function() {
                    if ($submitButton.prop('disabled')) {
                        $submitButton.prop('disabled', false);
                        $submitButton.html(originalButtonHTML);
                        $submitButton.removeClass('btn-loading');
                    }
                }, 10000); // 10 seconds timeout
            });

            // Handle form validation errors (if form is returned with errors)
            // This will re-enable the button if the page reloads with validation errors
            $(window).on('load', function() {
                if ($submitButton.prop('disabled')) {
                    $submitButton.prop('disabled', false);
                    $submitButton.html(originalButtonHTML);
                    $submitButton.removeClass('btn-loading');
                }
            });
        });
    </script>
@endpush