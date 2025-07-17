@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .header-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px;
            text-align: center;
        }

        .header-section h3 {
            font-weight: 700;
            margin-bottom: 5px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .datetime-info {
            background: #f8f9fa;
            padding: 20px;
            border-bottom: 1px solid #e9ecef;
        }

        .soap-detail {
            padding: 30px;
        }

        .soap-item {
            background: white;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .soap-label {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            font-weight: 600;
            color: #2d3436;
        }

        .soap-badge {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 8px 12px;
            border-radius: 20px;
            margin-right: 12px;
            font-weight: 700;
            font-size: 14px;
            min-width: 40px;
            text-align: center;
        }

        .soap-content {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            font-size: 14px;
            line-height: 1.6;
            color: #495057;
            white-space: pre-wrap;
            min-height: 60px;
        }

        .info-row {
            margin-bottom: 15px;
        }

        .info-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
        }

        .info-value {
            background: white;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 12px 15px;
            color: #495057;
        }

        .back-btn {
            background: white;
            border: 2px solid #e9ecef;
            color: #495057;
            border-radius: 10px;
            padding: 10px 20px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
            margin-bottom: 20px;
        }

        .back-btn:hover {
            border-color: #667eea;
            color: #667eea;
            transform: translateX(-2px);
            text-decoration: none;
        }

        .action-buttons {
            background: #f8f9fa;
            padding: 20px;
            border-top: 1px solid #e9ecef;
        }

        .btn {
            border-radius: 8px;
            padding: 12px 24px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-warning {
            background: #ffc107;
            border: none;
            color: #212529;
        }

        .btn-warning:hover {
            background: #ffb300;
            transform: translateY(-1px);
        }

        .metadata-section {
            background: #e3f2fd;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .metadata-title {
            font-weight: 600;
            color: #1976d2;
            margin-bottom: 10px;
        }

        .metadata-item {
            font-size: 13px;
            color: #495057;
            margin-bottom: 5px;
        }

        @media print {

            .back-btn,
            .action-buttons {
                display: none !important;
            }

            .detail-card {
                box-shadow: none;
                border: 1px solid #000;
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
            @include('components.navigation-rajal')

            <!-- Back Button -->
            <a href="{{ route('rawat-jalan.catatan-poliklinik.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                class="back-btn">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>

            <div class="detail-card">
                <!-- Header -->
                <div class="header-section rounded">
                    <h3><i class="fas fa-file-medical me-2"></i>DETAIL CATATAN KLINIK</h3>
                    <p>PASIEN RAWAT JALAN</p>
                </div>

                <!-- Date & Time Info -->
                <div class="datetime-info">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="info-label">
                                <i class="fas fa-calendar-alt me-2 text-primary"></i>Tanggal Pemeriksaan
                            </div>
                            <div class="info-value">
                                {{ \Carbon\Carbon::parse($catatanPoliklinik->tanggal)->format('d F Y') }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-label">
                                <i class="fas fa-clock me-2 text-primary"></i>Jam Pemeriksaan
                            </div>
                            <div class="info-value">
                                {{ \Carbon\Carbon::parse($catatanPoliklinik->jam)->format('H:i') }} WIB
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-label">
                                <i class="fas fa-hospital me-2 text-primary"></i>Unit/Poliklinik
                            </div>
                            <div class="info-value">
                                {{ $dataMedis->unit->nama_unit }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SOAP Content -->
                <div class="soap-detail">

                    <!-- S - Subjective -->
                    <div class="soap-item">
                        <div class="soap-label">
                            <span class="soap-badge">S</span>
                            <span>Subjective</span>
                        </div>
                        <div class="soap-content">{{ $catatanPoliklinik->subjective ?: 'Tidak ada data' }}</div>
                    </div>

                    <!-- O - Objective -->
                    <div class="soap-item">
                        <div class="soap-label">
                            <span class="soap-badge">O</span>
                            <span>Objective</span>
                        </div>
                        <div class="soap-content">{{ $catatanPoliklinik->objective ?: 'Tidak ada data' }}</div>
                    </div>

                    <!-- A - Assessment -->
                    <div class="soap-item">
                        <div class="soap-label">
                            <span class="soap-badge">A</span>
                            <span>Assessment</span>
                        </div>
                        <div class="soap-content">{{ $catatanPoliklinik->assessment ?: 'Tidak ada data' }}</div>
                    </div>

                    <!-- P - Plan -->
                    <div class="soap-item">
                        <div class="soap-label">
                            <span class="soap-badge">P</span>
                            <span>Plan</span>
                        </div>
                        <div class="soap-content">{{ $catatanPoliklinik->plan ?: 'Tidak ada data' }}</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection