@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .form-label {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #2c3e50;
        }

        .header-asesmen {
            margin-top: 1rem;
            font-size: 1.5rem;
            font-weight: 600;
            color: #097dd6;
            text-align: center;
            margin-bottom: 2rem;
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
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .section-title {
            font-weight: 600;
            color: #097dd6;
            margin-bottom: 1.5rem;
            font-size: 1.1rem;
            border-bottom: 2px solid #097dd6;
            padding-bottom: 0.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control {
            border-radius: 6px;
            border: 1px solid #ced4da;
            padding: 0.75rem;
            font-size: 0.9rem;
        }

        .form-control:focus {
            border-color: #097dd6;
            box-shadow: 0 0 0 0.2rem rgba(9, 125, 214, 0.25);
        }

        .checkbox-group {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            background-color: white;
            padding: 0.75rem 1rem;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .checkbox-item:hover {
            background-color: #e3f2fd;
            border-color: #097dd6;
        }

        .checkbox-item input[type="checkbox"] {
            margin-right: 0.5rem;
            transform: scale(1.2);
        }

        .checkbox-item label {
            margin-bottom: 0 !important;
            cursor: pointer;
            font-weight: 500;
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
            padding: 0.75rem 1rem;
            border-top-right-radius: 6px;
            border-bottom-right-radius: 6px;
            font-weight: 500;
            color: #6c757d;
            white-space: nowrap;
        }

        .blood-pressure-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .blood-pressure-item {
            background-color: white;
            padding: 1rem;
            border: 1px solid #dee2e6;
            border-radius: 6px;
        }

        .blood-pressure-item label {
            font-weight: 600;
            color: #097dd6;
            margin-bottom: 0.5rem;
        }

        .datetime-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .datetime-item label {
            font-weight: 500;
            color: #6c757d;
            font-size: 0.85rem;
        }

        .medication-item {
            background-color: white;
            padding: 1rem;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            margin-bottom: 0.5rem;
        }

        /* Additional CSS for alergi section */
        .table-responsive {
            border-radius: 8px;
            overflow: hidden;
        }

        .table-bordered {
            border: 1px solid #dee2e6;
        }

        .table-light {
            background-color: #f8f9fa;
        }

        .table th {
            background-color: #e9ecef;
            font-weight: 600;
            color: #495057;
            border-bottom: 2px solid #dee2e6;
            padding: 12px 8px;
            font-size: 0.9rem;
        }

        .table td {
            padding: 12px 8px;
            vertical-align: middle;
            font-size: 0.9rem;
        }

        .badge {
            font-size: 0.75rem;
            padding: 0.35em 0.65em;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.775rem;
        }

        .modal-lg {
            max-width: 800px;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #495057;
        }

        .text-danger {
            color: #dc3545 !important;
        }

        .is-invalid {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }

        .btn-outline-secondary {
            color: #6c757d;
            border-color: #6c757d;
        }

        .btn-outline-secondary:hover {
            background-color: #6c757d;
            border-color: #6c757d;
            color: white;
        }

        /* Tooltip styling */
        .tooltip {
            font-size: 0.8rem;
        }

        .tooltip-inner {
            max-width: 300px;
            text-align: left;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .modal-lg {
                max-width: 95%;
            }

            .table-responsive {
                font-size: 0.8rem;
            }

            .table th,
            .table td {
                padding: 8px 4px;
            }
        }

        .remove-medication {
            height: 38px;
        }

        @media (max-width: 768px) {
            .checkbox-group {
                flex-direction: column;
                gap: 0.75rem;
            }

            .blood-pressure-container {
                grid-template-columns: 1fr;
            }

            .datetime-group {
                grid-template-columns: 1fr;
            }

            .form-section {
                padding: 1rem;
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
            <x-content-card>
                <x-button-previous />

                @include('components.page-header', [
                    'title' => 'Tambah Data Traveling Hemodialisis',
                    'description' => 'Tambah Data Traveling Hemodialisis dengan mengisi formulir di bawah ini.',
                ])

                <form id="beratBadanForm" method="POST"
                    action="{{ route('hemodialisa.pelayanan.traveling-dialysis.store', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}">
                    @csrf

                    <div class="card shadow-sm">
                        <div class="card-body">
                            <!-- Basic Information Section -->
                            <div class="form-section">
                                <h5 class="section-title">Informasi Dasar</h5>

                                <div class="form-group">
                                    <label class="form-label">Date of First Dialysis</label>
                                    <div class="datetime-group">
                                        <div class="datetime-item">
                                            <label>Tanggal</label>
                                            <input type="date" class="form-control" name="date_first_dialysis" required>
                                        </div>
                                        <div class="datetime-item">
                                            <label>Waktu</label>
                                            <input type="time" class="form-control" name="time_first_dialysis" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="diagnosis" class="form-label">Diagnosis</label>
                                    <input type="text" class="form-control" id="diagnosis" name="diagnosis"
                                        placeholder="Masukkan diagnosis pasien" required>
                                </div>

                                <div class="form-group">
                                    <label for="dialysis_location" class="form-label">Home Dialyzed or Center
                                        Dialyzed</label>
                                    <input type="text" class="form-control" id="dialysis_location"
                                        name="dialysis_location" placeholder="Contoh: Home Dialyzed" required>
                                </div>
                            </div>

                            <!-- Blood Pressure Section -->
                            <div class="form-section">
                                <h5 class="section-title">Recent Blood Pressure Status</h5>

                                <div class="blood-pressure-container">
                                    <div class="blood-pressure-item">
                                        <label>Pre-Dialysis</label>
                                        <div class="input-with-unit">
                                            <input type="text" class="form-control" name="pre_dialysis_bp"
                                                placeholder="120/80" required>
                                            <span class="unit-label">mmHg</span>
                                        </div>
                                    </div>
                                    <div class="blood-pressure-item">
                                        <label>Post-Dialysis</label>
                                        <div class="input-with-unit">
                                            <input type="text" class="form-control" name="post_dialysis_bp"
                                                placeholder="110/70" required>
                                            <span class="unit-label">mmHg</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Access & Equipment Section -->
                            <div class="form-section">
                                <h5 class="section-title">Akses Vaskular & Peralatan</h5>

                                <div class="form-group">
                                    <label class="form-label">Vascular Access</label>
                                    <div class="checkbox-group">
                                        <div class="checkbox-item">
                                            <input type="checkbox" id="av_shunt" name="vascular_access[]" value="av_shunt">
                                            <label>AV Shunt</label>
                                        </div>
                                        <div class="checkbox-item">
                                            <input type="checkbox" id="cdl" name="vascular_access[]" value="cdl">
                                            <label>CDL</label>
                                        </div>
                                        <div class="checkbox-item">
                                            <input type="checkbox" id="femoral" name="vascular_access[]" value="femoral">
                                            <label>Femoral</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Type Dialyzer</label>
                                    <div class="checkbox-group">
                                        <div class="checkbox-item">
                                            <input type="checkbox" id="f7_hps" name="type_dialyzer[]" value="f7_hps">
                                            <label>F7 HPS</label>
                                        </div>
                                        <div class="checkbox-item">
                                            <input type="checkbox" id="f8_hps" name="type_dialyzer[]" value="f8_hps">
                                            <label>F8 HPS</label>
                                        </div>
                                        <div class="checkbox-item">
                                            <input type="checkbox" id="elisio" name="type_dialyzer[]" value="elisio">
                                            <label>Elisio</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Flow Rates & Settings Section -->
                            <div class="form-section">
                                <h5 class="section-title">Flow Rates & Pengaturan</h5>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="blood_flow_rate" class="form-label">Blood Flow Rate (QB)</label>
                                            <div class="input-with-unit">
                                                <input type="number" class="form-control" id="blood_flow_rate"
                                                    name="blood_flow_rate" placeholder="250" required>
                                                <span class="unit-label">ml/minute</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="dialysate_flow_rate" class="form-label">Dialysate Flow
                                                Rate</label>
                                            <div class="input-with-unit">
                                                <input type="number" class="form-control" id="dialysate_flow_rate"
                                                    name="dialysate_flow_rate" placeholder="500" required>
                                                <span class="unit-label">ml/minute</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="type_dialysate" class="form-label">Type Dialysate</label>
                                    <input type="text" class="form-control" id="type_dialysate" name="type_dialysate"
                                        placeholder="Masukkan jenis dialysate" required>
                                </div>
                            </div>

                            <!-- Anticoagulation Section -->
                            <div class="form-section">
                                <h5 class="section-title">Anticoagulation</h5>

                                <div class="form-group">
                                    <label for="anticoagulant" class="form-label">Anticoagulant</label>
                                    <input type="text" class="form-control" id="anticoagulant" name="anticoagulant"
                                        placeholder="Contoh: Heparin" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="loading_dose" class="form-label">Loading Dose</label>
                                            <div class="input-with-unit">
                                                <input type="number" class="form-control" id="loading_dose"
                                                    name="loading_dose" placeholder="Contoh :1000" required>
                                                <span class="unit-label">UI</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="maintenance" class="form-label">Maintenance</label>
                                            <div class="input-with-unit">
                                                <input type="number" class="form-control" id="maintenance"
                                                    name="maintenance" placeholder="Contoh : 500" required>
                                                <span class="unit-label">UI</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Patient Information Section -->
                            <div class="form-section">
                                <h5 class="section-title">Patient Information</h5>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="patient_dry_weight" class="form-label">Patient's Dry
                                                Weight</label>
                                            <div class="input-with-unit">
                                                <input type="number" class="form-control" id="patient_dry_weight"
                                                    name="patient_dry_weight">
                                                <span class="unit-label">kg</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="uf_goal" class="form-label">UF Goal</label>
                                            <div class="input-with-unit">
                                                <input type="number" class="form-control" id="uf_goal"
                                                    name="uf_goal">
                                                <span class="unit-label">ml</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="uf_rate" class="form-label">UF Rate</label>
                                            <div class="input-with-unit">
                                                <input type="number" class="form-control" id="uf_rate"
                                                    name="uf_rate">
                                                <span class="unit-label">mL/kg/jam</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="number_run_per_week" class="form-label">Number of Run Per
                                                Week</label>
                                            <div class="input-with-unit">
                                                <input type="number" class="form-control" id="number_run_per_week"
                                                    name="number_run_per_week">
                                                <span class="unit-label">week</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="length_dialysis" class="form-label">Length of Dialysis</label>
                                            <div class="input-with-unit">
                                                <input type="number" class="form-control" id="length_dialysis"
                                                    name="length_dialysis">
                                                <span class="unit-label">hours</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Complications & Tests Section -->
                            <div class="form-section">
                                <h5 class="section-title">Complications & Serologic Tests</h5>

                                <div class="form-group">
                                    <label for="complication_dialysis" class="form-label">Complication During
                                        Dialysis</label>
                                    <textarea class="form-control" id="complication_dialysis" name="complication_dialysis" rows="3"
                                        placeholder="Masukkan komplikasi jika ada"></textarea>
                                </div>

                                <!-- Updated Allergic Section -->
                                <div class="form-group">
                                    <label class="form-label">Alergi</label>
                                    <div class="w-100">
                                        <button type="button" class="btn btn-sm btn-outline-secondary mb-3"
                                            id="openAlergiModal" data-bs-toggle="modal" data-bs-target="#alergiModal">
                                            <i class="ti-plus"></i> Tambah Alergi
                                        </button>
                                        <input type="hidden" name="alergis" id="alergisInput" value="[]">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="createAlergiTable">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th width="20%">Jenis Alergi</th>
                                                        <th width="25%">Alergen</th>
                                                        <th width="25%">Reaksi</th>
                                                        <th width="20%">Tingkat Keparahan</th>
                                                        <th width="10%">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr id="no-alergi-row">
                                                        <td colspan="5" class="text-center text-muted">Tidak ada data
                                                            alergi</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Serologic Test</label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="blood-pressure-item">
                                                <label>HbsAg</label>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <select class="form-control" name="hbsag_result" required>
                                                            <option value="">Pilih Hasil</option>
                                                            <option value="Non Reactive (-)">Non Reactive (-)</option>
                                                            <option value="Reactive (+)">Reactive (+)</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="date" class="form-control" name="hbsag_date"
                                                            required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="blood-pressure-item">
                                                <label>Anti HCV</label>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <select class="form-control" name="anti_hcv_result" required>
                                                            <option value="">Pilih Hasil</option>
                                                            <option value="Non Reactive (-)">Non Reactive (-)</option>
                                                            <option value="Reactive (+)">Reactive (+)</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="date" class="form-control" name="anti_hcv_date"
                                                            required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="blood-pressure-item">
                                                <label>Anti HIV</label>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <select class="form-control" name="anti_hiv_result" required>
                                                            <option value="">Pilih Hasil</option>
                                                            <option value="Non Reactive (-)">Non Reactive (-)</option>
                                                            <option value="Reactive (+)">Reactive (+)</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="date" class="form-control" name="anti_hiv_date"
                                                            required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Medication Section -->
                            <div class="form-section">
                                <h5 class="section-title">Current Medication & Clinical History</h5>

                                <div class="form-group">
                                    <label class="form-label">Current Medication</label>
                                    <textarea class="form-control" name="current_medication" rows="3" placeholder="Masukkan obat-obatan saat ini"></textarea>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Relevant Clinical History</label>
                                    <div id="medication-container">
                                        <div class="medication-item row mb-2">
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" name="medication_name[]"
                                                    placeholder="Nama obat (contoh: Candesartan 8mg)">
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" name="medication_frequency[]"
                                                    placeholder="Frekuensi (contoh: 1 x 1)">
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-danger btn-sm remove-medication"
                                                    style="display: none;">
                                                    <i class="ti-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-outline-primary btn-sm mt-2"
                                        id="add-medication">
                                        <i class="ti-plus"></i> Tambah Obat
                                    </button>
                                </div>
                            </div>

                            <div class="text-end">
                                <x-button-submit />
                            </div>
                        </div>
                    </div>
                </form>
            </x-content-card>
        </div>
    </div>
    @include('unit-pelayanan.hemodialisa.pelayanan.traveling-dialysis.modal-create-alergi')
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Make checkbox items clickable
            document.querySelectorAll('.checkbox-item').forEach(function(item) {
                item.addEventListener('click', function(e) {
                    if (e.target.type !== 'checkbox') {
                        const checkbox = item.querySelector('input[type="checkbox"]');
                        checkbox.checked = !checkbox.checked;
                    }
                });
            });

            // Add medication functionality
            let medicationCount = 1;

            document.getElementById('add-medication').addEventListener('click', function() {
                medicationCount++;
                const container = document.getElementById('medication-container');
                const newMedicationItem = document.createElement('div');
                newMedicationItem.className = 'medication-item row mb-2';
                newMedicationItem.innerHTML = `
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="medication_name[]" placeholder="Nama obat (contoh: Candesartan 8mg)">
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="medication_frequency[]" placeholder="Frekuensi (contoh: 1 x 1)">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-sm remove-medication">
                            <i class="ti-trash"></i>
                        </button>
                    </div>
                `;
                container.appendChild(newMedicationItem);

                // Show remove button for all items if more than 1
                if (medicationCount > 1) {
                    document.querySelectorAll('.remove-medication').forEach(btn => {
                        btn.style.display = 'block';
                    });
                }
            });

            // Remove medication functionality
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-medication') || e.target.closest(
                        '.remove-medication')) {
                    const medicationItem = e.target.closest('.medication-item');
                    medicationItem.remove();
                    medicationCount--;

                    // Hide remove button if only 1 item left
                    if (medicationCount <= 1) {
                        document.querySelectorAll('.remove-medication').forEach(btn => {
                            btn.style.display = 'none';
                        });
                    }
                }
            });
        });
    </script>
@endpush
