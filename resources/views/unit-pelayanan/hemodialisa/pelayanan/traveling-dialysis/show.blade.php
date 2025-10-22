@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .header-asesmen {
            margin-top: 1rem;
            font-size: 1.5rem;
            font-weight: 600;
            color: #097dd6;
            text-align: center;
            margin-bottom: 2rem;
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

        .data-item {
            margin-bottom: 1rem;
            padding: 0.75rem;
            background-color: white;
            border: 1px solid #dee2e6;
            border-radius: 6px;
        }

        .data-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.25rem;
        }

        .data-value {
            color: #6c757d;
            font-size: 0.95rem;
        }

        .badge-test {
            font-size: 0.85rem;
            padding: 0.4em 0.8em;
            margin-right: 0.5rem;
            margin-bottom: 0.25rem;
        }

        .checkbox-display {
            display: inline-block;
            background-color: #e3f2fd;
            color: #1976d2;
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.85rem;
            margin-right: 0.5rem;
            margin-bottom: 0.25rem;
        }

        .medication-list {
            background-color: white;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 1rem;
        }

        .medication-item {
            padding: 0.5rem 0;
            border-bottom: 1px solid #eee;
        }

        .medication-item:last-child {
            border-bottom: none;
        }

        .table-responsive {
            border-radius: 8px;
            overflow: hidden;
        }

        .table th {
            background-color: #e9ecef;
            font-weight: 600;
            color: #495057;
        }

        @media print {
            .no-print {
                display: none !important;
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
                <div class="d-flex gap-2">
                    <x-button-previous />
                    <a target="_blank"
                        href="{{ route('hemodialisa.pelayanan.traveling-dialysis.print-pdf', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $dataTraveling->id]) }}"
                        class="btn btn-info">
                        <i class="fas fa-print me-1"></i> Cetak
                    </a>
                    <a href="{{ route('hemodialisa.pelayanan.traveling-dialysis.edit', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $dataTraveling->id]) }}"
                        class="btn btn-warning">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                </div>

                @include('components.page-header', [
                    'title' => 'Detail Traveling Hemodialisa',
                    'description' => 'Detail data Traveling Hemodialisa dengan mengisi formulir di bawah ini.',
                ])

                <div class="card-body">
                    <h4 class="header-asesmen">Data Traveling Hemodialisis</h4>

                    <!-- Basic Information Section -->
                    <div class="form-section">
                        <h5 class="section-title">Informasi Dasar</h5>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="data-item">
                                    <div class="data-label">Date of First Dialysis</div>
                                    <div class="data-value">
                                        {{ $dataTraveling->date_first_dialysis ? \Carbon\Carbon::parse($dataTraveling->date_first_dialysis)->format('d/m/Y') : '-' }}
                                        @if ($dataTraveling->time_first_dialysis)
                                            |
                                            {{ \Carbon\Carbon::parse($dataTraveling->time_first_dialysis)->format('H:i') }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="data-item">
                                    <div class="data-label">Diagnosis</div>
                                    <div class="data-value">{{ $dataTraveling->diagnosis ?? '-' }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="data-item">
                            <div class="data-label">Home Dialyzed or Center Dialyzed</div>
                            <div class="data-value">{{ $dataTraveling->dialysis_location ?? '-' }}</div>
                        </div>
                    </div>

                    <!-- Blood Pressure Section -->
                    <div class="form-section">
                        <h5 class="section-title">Recent Blood Pressure Status</h5>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="data-item">
                                    <div class="data-label">Pre-Dialysis</div>
                                    <div class="data-value">{{ $dataTraveling->pre_dialysis_bp ?? '-' }} mmHg</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="data-item">
                                    <div class="data-label">Post-Dialysis</div>
                                    <div class="data-value">{{ $dataTraveling->post_dialysis_bp ?? '-' }} mmHg</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Access & Equipment Section -->
                    <div class="form-section">
                        <h5 class="section-title">Akses Vaskular & Peralatan</h5>

                        <div class="data-item">
                            <div class="data-label">Vascular Access</div>
                            <div class="data-value">
                                @if ($dataTraveling->vascular_access)
                                    @foreach (json_decode($dataTraveling->vascular_access) as $access)
                                        <span class="checkbox-display">{{ ucwords(str_replace('_', ' ', $access)) }}</span>
                                    @endforeach
                                @else
                                    -
                                @endif
                            </div>
                        </div>

                        <div class="data-item">
                            <div class="data-label">Type Dialyzer</div>
                            <div class="data-value">
                                @if ($dataTraveling->type_dialyzer)
                                    @foreach (json_decode($dataTraveling->type_dialyzer) as $dialyzer)
                                        <span
                                            class="checkbox-display">{{ strtoupper(str_replace('_', ' ', $dialyzer)) }}</span>
                                    @endforeach
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Flow Rates & Settings Section -->
                    <div class="form-section">
                        <h5 class="section-title">Flow Rates & Pengaturan</h5>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="data-item">
                                    <div class="data-label">Blood Flow Rate (QB)</div>
                                    <div class="data-value">{{ $dataTraveling->blood_flow_rate ?? '-' }} ml/minute</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="data-item">
                                    <div class="data-label">Dialysate Flow Rate</div>
                                    <div class="data-value">{{ $dataTraveling->dialysate_flow_rate ?? '-' }} ml/minute
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="data-item">
                                    <div class="data-label">Type Dialysate</div>
                                    <div class="data-value">{{ $dataTraveling->type_dialysate ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Anticoagulation Section -->
                    <div class="form-section">
                        <h5 class="section-title">Anticoagulation</h5>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="data-item">
                                    <div class="data-label">Anticoagulant</div>
                                    <div class="data-value">{{ $dataTraveling->anticoagulant ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="data-item">
                                    <div class="data-label">Loading Dose</div>
                                    <div class="data-value">{{ $dataTraveling->loading_dose ?? '-' }} UI</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="data-item">
                                    <div class="data-label">Maintenance</div>
                                    <div class="data-value">{{ $dataTraveling->maintenance ?? '-' }} UI</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Patient Information Section -->
                    <div class="form-section">
                        <h5 class="section-title">Patient Information</h5>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="data-item">
                                    <div class="data-label">Patient's Dry Weight</div>
                                    <div class="data-value">{{ $dataTraveling->patient_dry_weight ?? '-' }} kg</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="data-item">
                                    <div class="data-label">UF Goal</div>
                                    <div class="data-value">{{ $dataTraveling->uf_goal ?? '-' }} ml</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="data-item">
                                    <div class="data-label">UF Rate</div>
                                    <div class="data-value">{{ $dataTraveling->uf_rate ?? '-' }} mL/kg/jam</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="data-item">
                                    <div class="data-label">Number of Run Per Week</div>
                                    <div class="data-value">{{ $dataTraveling->number_run_per_week ?? '-' }} week</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="data-item">
                                    <div class="data-label">Length of Dialysis</div>
                                    <div class="data-value">{{ $dataTraveling->length_dialysis ?? '-' }} hours</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Complications & Tests Section -->
                    <div class="form-section">
                        <h5 class="section-title">Complications & Serologic Tests</h5>

                        <div class="data-item">
                            <div class="data-label">Complication During Dialysis</div>
                            <div class="data-value">{{ $dataTraveling->complication_dialysis ?? '-' }}</div>
                        </div>

                        <div class="data-item">
                            <div class="data-label">Alergi</div>
                            <div class="data-value">
                                @if ($alergiPasien->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Jenis</th>
                                                    <th>Alergen</th>
                                                    <th>Reaksi</th>
                                                    <th>Tingkat Keparahan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($alergiPasien as $alergi)
                                                    <tr>
                                                        <td>{{ $alergi->jenis_alergi }}</td>
                                                        <td>{{ $alergi->nama_alergi }}</td>
                                                        <td>{{ $alergi->reaksi }}</td>
                                                        <td>{{ $alergi->tingkat_keparahan }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    Tidak ada data alergi
                                @endif
                            </div>
                        </div>

                        <div class="data-item">
                            <div class="data-label">Serologic Test</div>
                            <div class="data-value">
                                @if ($dataTraveling->hbsag_result)
                                    <span
                                        class="badge badge-test {{ $dataTraveling->hbsag_result == 'Reactive (+)' ? 'badge-danger' : 'badge-success' }}">
                                        HbsAg: {{ $dataTraveling->hbsag_result }}
                                        @if ($dataTraveling->hbsag_date)
                                            ({{ \Carbon\Carbon::parse($dataTraveling->hbsag_date)->format('d/m/Y') }})
                                        @endif
                                    </span>
                                @endif

                                @if ($dataTraveling->anti_hcv_result)
                                    <span
                                        class="badge badge-test {{ $dataTraveling->anti_hcv_result == 'Reactive (+)' ? 'badge-danger' : 'badge-success' }}">
                                        Anti HCV: {{ $dataTraveling->anti_hcv_result }}
                                        @if ($dataTraveling->anti_hcv_date)
                                            ({{ \Carbon\Carbon::parse($dataTraveling->anti_hcv_date)->format('d/m/Y') }})
                                        @endif
                                    </span>
                                @endif

                                @if ($dataTraveling->anti_hiv_result)
                                    <span
                                        class="badge badge-test {{ $dataTraveling->anti_hiv_result == 'Reactive (+)' ? 'badge-danger' : 'badge-success' }}">
                                        Anti HIV: {{ $dataTraveling->anti_hiv_result }}
                                        @if ($dataTraveling->anti_hiv_date)
                                            ({{ \Carbon\Carbon::parse($dataTraveling->anti_hiv_date)->format('d/m/Y') }})
                                        @endif
                                    </span>
                                @endif

                                @if (!$dataTraveling->hbsag_result && !$dataTraveling->anti_hcv_result && !$dataTraveling->anti_hiv_result)
                                    -
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Medication Section -->
                    <div class="form-section">
                        <h5 class="section-title">Current Medication & Clinical History</h5>

                        <div class="data-item">
                            <div class="data-label">Current Medication</div>
                            <div class="data-value">{{ $dataTraveling->current_medication ?? '-' }}</div>
                        </div>

                        <div class="data-item">
                            <div class="data-label">Relevant Clinical History</div>
                            <div class="data-value">
                                @if ($dataTraveling->relevant_clinical_history)
                                    @php
                                        $medications = json_decode($dataTraveling->relevant_clinical_history, true);
                                    @endphp
                                    @if ($medications && count($medications) > 0)
                                        <div class="medication-list">
                                            @foreach ($medications as $medication)
                                                <div class="medication-item">
                                                    <strong>{{ $medication['name'] ?? '-' }}</strong>
                                                    @if (isset($medication['frequency']) && $medication['frequency'])
                                                        - {{ $medication['frequency'] }}
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        -
                                    @endif
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Footer Info -->
                    <div class="form-section">
                        <h5 class="section-title">Informasi Sistem</h5>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="data-item">
                                    <div class="data-label">Dibuat oleh</div>
                                    <div class="data-value">{{ $dataTraveling->userCreated->name ?? 'Unknown' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="data-item">
                                    <div class="data-label">Dibuat pada</div>
                                    <div class="data-value">
                                        {{ $dataTraveling->created_at ? $dataTraveling->created_at->format('d/m/Y H:i') : '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </x-content-card>>
        </div>
    </div>
@endsection

@push('js')
@endpush
