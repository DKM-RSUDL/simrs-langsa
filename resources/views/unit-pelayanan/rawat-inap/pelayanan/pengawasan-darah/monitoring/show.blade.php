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

            .vital-item {
                border: 1px solid #e3e6f0;
                border-radius: 6px;
                padding: 12px;
                margin-bottom: 8px;
                background-color: #fff;
            }

            .vital-label {
                font-weight: 500;
                margin-bottom: 4px;
                color: #5a5c69;
                font-size: 12px;
            }

            .vital-value {
                font-size: 14px;
                color: #3a3b45;
                font-weight: 600;
            }

            .time-badge {
                background-color: #e9ecef;
                color: #495057;
                padding: 4px 8px;
                border-radius: 15px;
                font-size: 12px;
                font-weight: 600;
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

            .vital-signs-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
                gap: 10px;
            }
        </style>
    @endpush

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <div class="text-center mt-1 mb-2">
                <h5 class="text-secondary fw-bold">Detail Data Monitoring Transfusi Darah</h5>
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
                            <div class="col-md-4">
                                <div class="info-item">
                                    <div class="info-label">Tanggal</div>
                                    <div class="info-value">{{ date('d/m/Y', strtotime($monitoring->tanggal)) }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-item">
                                    <div class="info-label">Jam</div>
                                    <div class="info-value">{{ date('H:i', strtotime($monitoring->jam)) }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-item">
                                    <div class="info-label">Durasi Transfusi</div>
                                    <div class="info-value">
                                        @php
                                            $jamMulai = \Carbon\Carbon::parse($monitoring->jam_mulai_transfusi);
                                            $jamSelesai = \Carbon\Carbon::parse($monitoring->jam_selesai_transfusi);
                                            $durasi = $jamSelesai->diff($jamMulai);
                                            $durasiText = $durasi->h . ' jam ' . $durasi->i . ' menit';
                                        @endphp
                                        <span class="badge bg-info">{{ $durasiText }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">Jam Mulai Transfusi</div>
                                    <div class="info-value">{{ date('H:i', strtotime($monitoring->jam_mulai_transfusi)) }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">Jam Selesai Transfusi</div>
                                    <div class="info-value">{{ date('H:i', strtotime($monitoring->jam_selesai_transfusi)) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Monitoring Tanda Vital -->
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h6 class="mb-0"><i class="bi bi-heart-pulse me-2"></i>Monitoring Tanda Vital</h6>
                    </div>
                    <div class="card-body">
                        <!-- 15 Menit Sebelum Transfusi -->
                        <div class="mb-4">
                            <h6 class="text-muted mb-3">
                                <span class="time-badge">15 Menit Sebelum Transfusi</span>
                            </h6>
                            <div class="vital-signs-grid">
                                <div class="vital-item">
                                    <div class="vital-label">TD Sistole</div>
                                    <div class="vital-value">{{ $monitoring->pre_td_sistole }} mmHg</div>
                                </div>
                                <div class="vital-item">
                                    <div class="vital-label">TD Diastole</div>
                                    <div class="vital-value">{{ $monitoring->pre_td_diastole }} mmHg</div>
                                </div>
                                <div class="vital-item">
                                    <div class="vital-label">Nadi</div>
                                    <div class="vital-value">{{ $monitoring->pre_nadi }} x/mnt</div>
                                </div>
                                <div class="vital-item">
                                    <div class="vital-label">Suhu</div>
                                    <div class="vital-value">{{ $monitoring->pre_temp }} °C</div>
                                </div>
                                <div class="vital-item">
                                    <div class="vital-label">RR</div>
                                    <div class="vital-value">{{ $monitoring->pre_rr }} x/mnt</div>
                                </div>
                            </div>
                        </div>

                        <!-- 15 Menit Setelah Darah Masuk -->
                        <div class="mb-4">
                            <h6 class="text-muted mb-3">
                                <span class="time-badge">15 Menit Setelah Darah Masuk</span>
                            </h6>
                            <div class="vital-signs-grid">
                                <div class="vital-item">
                                    <div class="vital-label">TD Sistole</div>
                                    <div class="vital-value">{{ $monitoring->post15_td_sistole }} mmHg</div>
                                </div>
                                <div class="vital-item">
                                    <div class="vital-label">TD Diastole</div>
                                    <div class="vital-value">{{ $monitoring->post15_td_diastole }} mmHg</div>
                                </div>
                                <div class="vital-item">
                                    <div class="vital-label">Nadi</div>
                                    <div class="vital-value">{{ $monitoring->post15_nadi }} x/mnt</div>
                                </div>
                                <div class="vital-item">
                                    <div class="vital-label">Suhu</div>
                                    <div class="vital-value">{{ $monitoring->post15_temp }} °C</div>
                                </div>
                                <div class="vital-item">
                                    <div class="vital-label">RR</div>
                                    <div class="vital-value">{{ $monitoring->post15_rr }} x/mnt</div>
                                </div>
                            </div>
                        </div>

                        <!-- 1 Jam Setelah Darah Masuk -->
                        <div class="mb-4">
                            <h6 class="text-muted mb-3">
                                <span class="time-badge">1 Jam Setelah Darah Masuk</span>
                            </h6>
                            <div class="vital-signs-grid">
                                <div class="vital-item">
                                    <div class="vital-label">TD Sistole</div>
                                    <div class="vital-value">{{ $monitoring->post1h_td_sistole }} mmHg</div>
                                </div>
                                <div class="vital-item">
                                    <div class="vital-label">TD Diastole</div>
                                    <div class="vital-value">{{ $monitoring->post1h_td_diastole }} mmHg</div>
                                </div>
                                <div class="vital-item">
                                    <div class="vital-label">Nadi</div>
                                    <div class="vital-value">{{ $monitoring->post1h_nadi }} x/mnt</div>
                                </div>
                                <div class="vital-item">
                                    <div class="vital-label">Suhu</div>
                                    <div class="vital-value">{{ $monitoring->post1h_temp }} °C</div>
                                </div>
                                <div class="vital-item">
                                    <div class="vital-label">RR</div>
                                    <div class="vital-value">{{ $monitoring->post1h_rr }} x/mnt</div>
                                </div>
                            </div>
                        </div>

                        <!-- 4 Jam Setelah Transfusi -->
                        <div class="mb-4">
                            <h6 class="text-muted mb-3">
                                <span class="time-badge">4 Jam Setelah Transfusi</span>
                            </h6>
                            <div class="vital-signs-grid">
                                <div class="vital-item">
                                    <div class="vital-label">TD Sistole</div>
                                    <div class="vital-value">{{ $monitoring->post4h_td_sistole }} mmHg</div>
                                </div>
                                <div class="vital-item">
                                    <div class="vital-label">TD Diastole</div>
                                    <div class="vital-value">{{ $monitoring->post4h_td_diastole }} mmHg</div>
                                </div>
                                <div class="vital-item">
                                    <div class="vital-label">Nadi</div>
                                    <div class="vital-value">{{ $monitoring->post4h_nadi }} x/mnt</div>
                                </div>
                                <div class="vital-item">
                                    <div class="vital-label">Suhu</div>
                                    <div class="vital-value">{{ $monitoring->post4h_temp }} °C</div>
                                </div>
                                <div class="vital-item">
                                    <div class="vital-label">RR</div>
                                    <div class="vital-value">{{ $monitoring->post4h_rr }} x/mnt</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reaksi Transfusi -->
                <div class="card mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h6 class="mb-0"><i class="bi bi-exclamation-triangle me-2"></i>Reaksi Transfusi</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">Reaksi Selama Transfusi</div>
                                    <div class="info-value">
                                        @if($monitoring->reaksi_selama_transfusi)
                                            {{ $monitoring->reaksi_selama_transfusi }}
                                        @else
                                            <span class="text-muted">Tidak ada reaksi</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">Reaksi Setelah Transfusi</div>
                                    <div class="info-value">
                                        @if($monitoring->reaksi_transfusi)
                                            {{ $monitoring->reaksi_transfusi }}
                                        @else
                                            <span class="text-muted">Tidak ada reaksi</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status Reaksi -->
                        <div class="mt-3">
                            <div class="alert {{ ($monitoring->reaksi_selama_transfusi || $monitoring->reaksi_transfusi) ? 'alert-warning' : 'alert-success' }}">
                                <h6 class="alert-heading">
                                    <i class="bi bi-shield-check me-2"></i>Status Reaksi Transfusi
                                </h6>
                                <p class="mb-0">
                                    @if($monitoring->reaksi_selama_transfusi || $monitoring->reaksi_transfusi)
                                        <strong>Terdeteksi reaksi transfusi</strong> - Perlu pemantauan lebih lanjut
                                    @else
                                        <strong>Tidak ada reaksi transfusi</strong> - Proses transfusi berjalan normal
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Petugas -->
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0"><i class="bi bi-people me-2"></i>Petugas Monitoring</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">Dokter</div>
                                    <div class="info-value">
                                        <i class="bi bi-person-badge me-2"></i>
                                        {{ $monitoring->dokterRelation->nama ?? 'N/A' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">Perawat</div>
                                    <div class="info-value">
                                        <i class="bi bi-person-badge me-2"></i>
                                        {{ $monitoring->perawatRelation->nama ?? 'N/A' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Button Actions -->
                <div class="row">
                    <div class="col-12 text-end">
                        <a href="{{ route('rawat-inap.pengawasan-darah.monitoring.edit', [
                            'kd_unit' => $dataMedis->kd_unit,
                            'kd_pasien' => $dataMedis->kd_pasien,
                            'tgl_masuk' => date('Y-m-d', strtotime($dataMedis->tgl_masuk)),
                            'urut_masuk' => $dataMedis->urut_masuk,
                            'id' => $monitoring->id,
                        ]) }}" class="btn btn-warning">
                            <i class="bi bi-pencil me-1"></i> Edit Data
                        </a>
                        <a href="{{ route('rawat-inap.pengawasan-darah.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}?tab=monitoring"
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