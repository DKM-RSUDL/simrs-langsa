@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .header-asesmen {
            margin-top: 1rem;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .shift-info {
            background-color: #e3f2fd;
            border: 1px solid #2196f3;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .data-section {
            background-color: #f8f9fa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .section-header {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: #333;
            border-bottom: 2px solid #097dd6;
            padding-bottom: 0.5rem;
        }

        .data-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #e9ecef;
        }

        .data-row:last-child {
            border-bottom: none;
        }

        .data-label {
            font-weight: 500;
            color: #495057;
            min-width: 150px;
        }

        .data-value {
            font-weight: 600;
            color: #212529;
            text-align: right;
        }

        .total-row {
            background-color: #e8f4f8;
            margin: 0 -1.5rem;
            padding: 1rem 1.5rem;
            border-radius: 5px;
            margin-top: 1rem;
        }

        .balance-positive {
            color: #28a745;
            font-weight: 700;
        }

        .balance-negative {
            color: #dc3545;
            font-weight: 700;
        }

        .balance-zero {
            color: #6c757d;
            font-weight: 700;
        }

        .summary-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px;
            padding: 1.5rem;
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
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <div class="d-flex justify-content-between mb-3">
                <a href="{{ url()->previous() }}" class="btn btn-outline-primary">
                    <i class="ti-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('rawat-inap.intake-cairan.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, encrypt($intake->id)]) }}" 
                   class="btn btn-warning">
                    <i class="ti-pencil"></i> Edit Data
                </a>
            </div>

            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100 shadow-sm">
                    <div class="card-body">
                        <div class="px-3">
                            <h4 class="header-asesmen">Detail Intake dan Output Cairan</h4>
                            <p class="text-muted mb-0">Informasi detail asupan dan keluaran cairan pasien</p>
                        </div>

                        <div class="px-3">
                            {{-- Info Shift --}}
                            <div class="shift-info">
                                <div class="row">
                                    <div class="col-md-4">
                                        <strong>Tanggal:</strong><br>
                                        <span class="h5">{{ date('d F Y', strtotime($intake->tanggal)) }}</span>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Shift:</strong><br>
                                        <span class="h5">{{ $intake->shift_name }}</span>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Waktu:</strong><br>
                                        <span class="h5">{{ $intake->shift_time }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Summary Balance --}}
                            <div class="summary-card">
                                <div class="row text-center">
                                    <div class="col-md-3">
                                        <h3 class="mb-0">{{ number_format($intake->total_intake ?? 0) }}</h3>
                                        <small>Total Intake (ml)</small>
                                    </div>
                                    <div class="col-md-3">
                                        <h3 class="mb-0">{{ number_format($intake->total_output ?? 0) }}</h3>
                                        <small>Total Output (ml)</small>
                                    </div>
                                    <div class="col-md-3">
                                        @php
                                            $balance = ($intake->balance_cairan ?? 0);
                                        @endphp
                                        <h3 class="mb-0">
                                            {{ $balance > 0 ? '+' : '' }}{{ number_format($balance) }}
                                        </h3>
                                        <small>Balance (ml)</small>
                                    </div>
                                    <div class="col-md-3">
                                        <h3 class="mb-0">
                                            @if($balance > 0)
                                                Positif
                                            @elseif($balance < 0)
                                                Negatif
                                            @else
                                                Seimbang
                                            @endif
                                        </h3>
                                        <small>Status</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                {{-- Output Section --}}
                                <div class="col-md-6">
                                    <div class="data-section">
                                        <h4 class="section-header">Output (Keluaran)</h4>

                                        <div class="data-row">
                                            <span class="data-label">Urine:</span>
                                            <span class="data-value">{{ number_format($intake->output_urine ?? 0) }} ml</span>
                                        </div>

                                        <div class="data-row">
                                            <span class="data-label">Muntah:</span>
                                            <span class="data-value">{{ number_format($intake->output_muntah ?? 0) }} ml</span>
                                        </div>

                                        <div class="data-row">
                                            <span class="data-label">Drain:</span>
                                            <span class="data-value">{{ number_format($intake->output_drain ?? 0) }} ml</span>
                                        </div>

                                        <div class="data-row">
                                            <span class="data-label">IWL (Insensible Water Loss):</span>
                                            <span class="data-value">{{ number_format($intake->output_iwl ?? 0) }} ml</span>
                                        </div>

                                        <div class="total-row">
                                            <div class="data-row">
                                                <span class="data-label"><strong>Total Output:</strong></span>
                                                <span class="data-value"><strong>{{ number_format($intake->total_output ?? 0) }} ml</strong></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Intake Section --}}
                                <div class="col-md-6">
                                    <div class="data-section">
                                        <h4 class="section-header">Intake (Masukan)</h4>

                                        <div class="data-row">
                                            <span class="data-label">IUFD:</span>
                                            <span class="data-value">{{ number_format($intake->intake_iufd ?? 0) }} ml</span>
                                        </div>

                                        <div class="data-row">
                                            <span class="data-label">Minum:</span>
                                            <span class="data-value">{{ number_format($intake->intake_minum ?? 0) }} ml</span>
                                        </div>

                                        <div class="data-row">
                                            <span class="data-label">Makan:</span>
                                            <span class="data-value">{{ number_format($intake->intake_makan ?? 0) }} ml</span>
                                        </div>

                                        <div class="data-row">
                                            <span class="data-label">NGT:</span>
                                            <span class="data-value">{{ number_format($intake->intake_ngt ?? 0) }} ml</span>
                                        </div>

                                        <div class="total-row">
                                            <div class="data-row">
                                                <span class="data-label"><strong>Total Intake:</strong></span>
                                                <span class="data-value"><strong>{{ number_format($intake->total_intake ?? 0) }} ml</strong></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Balance Section --}}
                            <div class="data-section">
                                <h4 class="section-header">Balance Cairan</h4>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="data-row">
                                            <span class="data-label">Balance (Total Intake - Total Output):</span>
                                            <span class="data-value 
                                                @if($balance > 0) balance-positive
                                                @elseif($balance < 0) balance-negative
                                                @else balance-zero
                                                @endif
                                            ">
                                                {{ $balance > 0 ? '+' : '' }}{{ number_format($balance) }} ml
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Info Petugas --}}
                            <div class="data-section">
                                <h4 class="section-header">Informasi Petugas</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="data-row">
                                            <span class="data-label">Dibuat oleh:</span>
                                            <span class="data-value">
                                                {{ $intake->userCreate->karyawan->gelar_depan ?? '' }} 
                                                {{ str()->title($intake->userCreate->karyawan->nama ?? $intake->userCreate->name ?? 'Unknown') }} 
                                                {{ $intake->userCreate->karyawan->gelar_belakang ?? '' }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="data-row">
                                            <span class="data-label">Waktu input:</span>
                                            <span class="data-value">{{ $intake->created_at 
    ? \Carbon\Carbon::parse($intake->created_at)->format('d/m/Y H:i') 
    : '-' 
}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection