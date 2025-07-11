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

            .info-item {
                border: 1px solid #e3e6f0;
                border-radius: 6px;
                padding: 15px;
                margin-bottom: 12px;
                background-color: #f8f9fc;
            }

            .info-label {
                font-weight: 500;
                margin-bottom: 8px;
                color: #5a5c69;
                font-size: 14px;
            }

            .info-value {
                font-size: 16px;
                color: #3a3b45;
            }

            .verification-item {
                border: 1px solid #e3e6f0;
                border-radius: 6px;
                padding: 15px;
                margin-bottom: 12px;
                background-color: #fff;
            }

            .verification-label {
                font-weight: 500;
                margin-bottom: 8px;
                color: #5a5c69;
                font-size: 14px;
            }

            .verification-status {
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .status-badge {
                padding: 4px 12px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 600;
            }

            .status-sesuai {
                background-color: #d4edda;
                color: #155724;
                border: 1px solid #c3e6cb;
            }

            .status-tidak-sesuai {
                background-color: #f8d7da;
                color: #721c24;
                border: 1px solid #f5c6cb;
            }

            .readonly-form .form-control {
                background-color: #f8f9fa;
                border: 1px solid #e9ecef;
                cursor: not-allowed;
            }

            .readonly-form .form-select {
                background-color: #f8f9fa;
                border: 1px solid #e9ecef;
                cursor: not-allowed;
            }
        </style>
    @endpush

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <div class="text-center mt-1 mb-2">
                <h5 class="text-secondary fw-bold">Detail Data Pengelolaan Pengawasan Darah</h5>
            </div>

            <hr>

            <div class="form-section readonly-form">
                <!-- Informasi Dasar -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0"><i class="bi bi-calendar-check me-2"></i>Informasi Dasar</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="info-item">
                                    <div class="info-label">Tanggal</div>
                                    <div class="info-value">{{ date('d/m/Y', strtotime($pengelolaan->tanggal)) }}</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-item">
                                    <div class="info-label">Jam</div>
                                    <div class="info-value">{{ date('H:i', strtotime($pengelolaan->jam)) }}</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-item">
                                    <div class="info-label">Transfusi Ke</div>
                                    <div class="info-value">
                                        <span class="badge bg-primary">Ke-{{ $pengelolaan->transfusi_ke }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-item">
                                    <div class="info-label">Nomor Seri Kantong Darah</div>
                                    <div class="info-value">{{ $pengelolaan->nomor_seri_kantong }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Verifikasi Keamanan Darah -->
                <div class="card mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h6 class="mb-0"><i class="bi bi-shield-check me-2"></i>Verifikasi Keamanan Darah</h6>
                    </div>
                    <div class="card-body">
                        <!-- Riwayat Komponen Darah -->
                        <div class="verification-item">
                            <div class="verification-label">
                                1. Riwayat komponen darah sesuai instruksi dokter
                            </div>
                            <div class="verification-status">
                                @if($pengelolaan->riwayat_komponen_sesuai == 1)
                                    <span class="status-badge status-sesuai">
                                        <i class="bi bi-check-circle me-1"></i>Sesuai
                                    </span>
                                @else
                                    <span class="status-badge status-tidak-sesuai">
                                        <i class="bi bi-x-circle me-1"></i>Tidak Sesuai
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Identitas Label Darah -->
                        <div class="verification-item">
                            <div class="verification-label">
                                2. Identitas label darah sesuai dengan barcode
                            </div>
                            <div class="verification-status">
                                @if($pengelolaan->identitas_label_sesuai == 1)
                                    <span class="status-badge status-sesuai">
                                        <i class="bi bi-check-circle me-1"></i>Sesuai
                                    </span>
                                @else
                                    <span class="status-badge status-tidak-sesuai">
                                        <i class="bi bi-x-circle me-1"></i>Tidak Sesuai
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Golongan Darah Pasien -->
                        <div class="verification-item">
                            <div class="verification-label">
                                3. Golongan darah pasien sesuai dengan produk darah yang tersedia
                            </div>
                            <div class="verification-status">
                                @if($pengelolaan->golongan_darah_sesuai == 1)
                                    <span class="status-badge status-sesuai">
                                        <i class="bi bi-check-circle me-1"></i>Sesuai
                                    </span>
                                @else
                                    <span class="status-badge status-tidak-sesuai">
                                        <i class="bi bi-x-circle me-1"></i>Tidak Sesuai
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Volume Darah -->
                        <div class="verification-item">
                            <div class="verification-label">
                                4. Volume darah sesuai dengan instruksi
                            </div>
                            <div class="verification-status">
                                @if($pengelolaan->volume_sesuai == 1)
                                    <span class="status-badge status-sesuai">
                                        <i class="bi bi-check-circle me-1"></i>Sesuai
                                    </span>
                                @else
                                    <span class="status-badge status-tidak-sesuai">
                                        <i class="bi bi-x-circle me-1"></i>Tidak Sesuai
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Kantong Darah Utuh -->
                        <div class="verification-item">
                            <div class="verification-label">
                                5. Kantong darah utuh (tidak bocor)
                            </div>
                            <div class="verification-status">
                                @if($pengelolaan->kantong_utuh == 1)
                                    <span class="status-badge status-sesuai">
                                        <i class="bi bi-check-circle me-1"></i>Sesuai
                                    </span>
                                @else
                                    <span class="status-badge status-tidak-sesuai">
                                        <i class="bi bi-x-circle me-1"></i>Tidak Sesuai
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Darah Tidak Expired -->
                        <div class="verification-item">
                            <div class="verification-label">
                                6. Darah tidak expired
                            </div>
                            <div class="verification-status">
                                @if($pengelolaan->tidak_expired == 1)
                                    <span class="status-badge status-sesuai">
                                        <i class="bi bi-check-circle me-1"></i>Sesuai
                                    </span>
                                @else
                                    <span class="status-badge status-tidak-sesuai">
                                        <i class="bi bi-x-circle me-1"></i>Tidak Sesuai
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Ringkasan Status -->
                        <div class="mt-4 pt-3 border-top">
                            <div class="row">
                                <div class="col-md-12">
                                    @php
                                        $verifikasi = [
                                            $pengelolaan->riwayat_komponen_sesuai,
                                            $pengelolaan->identitas_label_sesuai,
                                            $pengelolaan->golongan_darah_sesuai,
                                            $pengelolaan->volume_sesuai,
                                            $pengelolaan->kantong_utuh,
                                            $pengelolaan->tidak_expired
                                        ];
                                        $totalSesuai = array_sum($verifikasi);
                                    @endphp
                                    
                                    <div class="alert {{ $totalSesuai == 6 ? 'alert-success' : ($totalSesuai >= 4 ? 'alert-warning' : 'alert-danger') }}">
                                        <h6 class="alert-heading">
                                            <i class="bi bi-clipboard-check me-2"></i>Ringkasan Verifikasi
                                        </h6>
                                        <p class="mb-0">
                                            <strong>{{ $totalSesuai }}/6</strong> kriteria keamanan darah terpenuhi
                                            @if($totalSesuai == 6)
                                                - Semua verifikasi sesuai standar
                                            @elseif($totalSesuai >= 4)
                                                - Sebagian besar verifikasi sesuai standar
                                            @else
                                                - Perlu perhatian lebih pada verifikasi keamanan
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Petugas -->
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0"><i class="bi bi-people me-2"></i>Petugas Verifikasi</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">Petugas 1</div>
                                    <div class="info-value">
                                        <i class="bi bi-person-badge me-2"></i>
                                        {{ $pengelolaan->petugas1->nama ?? 'N/A' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">Petugas 2</div>
                                    <div class="info-value">
                                        <i class="bi bi-person-badge me-2"></i>
                                        {{ $pengelolaan->petugas2->nama ?? 'N/A' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Button Actions -->
                <div class="row">
                    <div class="col-12 text-end">
                        <a href="{{ route('pengawasan-darah.pengelolaan.edit', [
                            'kd_pasien' => $dataMedis->kd_pasien,
                            'tgl_masuk' => date('Y-m-d', strtotime($dataMedis->tgl_masuk)),
                            'urut_masuk' => $dataMedis->urut_masuk,
                            'id' => $pengelolaan->id,
                        ]) }}" class="btn btn-warning">
                            <i class="bi bi-pencil me-1"></i> Edit Data
                        </a>
                        <a href="{{ route('pengawasan-darah.index', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}?tab=pengelolaan"
                            class="btn btn-secondary ms-2">
                            <i class="ti-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
   
@endpush