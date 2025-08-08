@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .badge-success {
            background-color: #28a745;
            color: white;
        }
        .badge-warning {
            background-color: #ffc107;
            color: black;
        }
        .badge-info {
            background-color: #17a2b8;
            color: white;
        }
        .badge-danger {
            background-color: #dc3545;
            color: white;
        }
        
        .section-card {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }
        
        .section-header {
            background: linear-gradient(135deg, #097dd6 0%, #0056b3 100%);
            color: white;
            padding: 0.75rem 1rem;
            border-radius: 8px 8px 0 0;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .section-body {
            padding: 1rem;
        }
        
        .info-row {
            border-bottom: 1px solid #f1f3f4;
            padding: 0.5rem 0;
        }
        
        .info-row:last-child {
            border-bottom: none;
        }
        
        .info-card {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 1rem;
            margin-bottom: 1rem;
        }
        
        .info-card-header {
            font-weight: 600;
            color: #097dd6;
            margin-bottom: 0.75rem;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 0.25rem;
        }
        
        .device-item {
            background-color: white;
            border: 1px solid #e9ecef;
            border-radius: 4px;
            padding: 0.75rem;
            margin-bottom: 0.5rem;
        }
        
        .device-item:last-child {
            margin-bottom: 0;
        }
        
        .infection-badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            margin: 0.125rem;
            background-color: #dc3545;
            color: white;
            border-radius: 0.25rem;
            font-size: 0.75rem;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        {{-- Patient Card Column --}}
        <div class="col-md-3">
            @include('components.patient-card', ['dataMedis' => $dataMedis])
        </div>

        {{-- Detail Column --}}
        <div class="col-md-9">
            <a href="{{ route('rawat-inap.surveilans-ppi.a2.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}" 
               class="btn btn-outline-primary mb-3">
                <i class="ti-arrow-left"></i> Kembali
            </a>

            <div class="card">
                <div class="card-header">
                    <h5>Detail Surveilans PPI (PENCEGAHAN DAN PENGENDALIAN INFEKSI) A2</h5>
                </div>
                <div class="card-body">
                    
                    {{-- Informasi Dasar --}}
                    <div class="section-card">
                        <div class="section-header">
                            <i class="fas fa-info-circle"></i>
                            Informasi Dasar
                        </div>
                        <div class="section-body">
                            <table class="table table-bordered table-sm">
                                <tr>
                                    <td width="30%"><strong>Nama Pasien</strong></td>
                                    <td>{{ $dataMedis->pasien->nama ?? 'Tidak Diketahui' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Nomor Rekam Medis</strong></td>
                                    <td>{{ $dataMedis->pasien->kd_pasien }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal Lahir</strong></td>
                                    <td>{{ $dataMedis->pasien->tgl_lahir ? \Carbon\Carbon::parse($dataMedis->pasien->tgl_lahir)->format('d/m/Y') : 'Tidak Diketahui' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal Implementasi</strong></td>
                                    <td>{{ $surveilans->tanggal_implementasi ? \Carbon\Carbon::parse($surveilans->tanggal_implementasi)->format('d/m/Y') : '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Jam Implementasi</strong></td>
                                    <td>{{ date('H:i', strtotime($surveilans->jam_implementasi)) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal Keluar</strong></td>
                                    <td>
                                        {{ $surveilans->tanggal_keluar ? \Carbon\Carbon::parse($surveilans->tanggal_keluar)->format('d/m/Y') : '-' }}
                                        @if($surveilans->tanggal_keluar)
                                            <span class="badge badge-success ms-2">Sudah Keluar</span>
                                        @else
                                            <span class="badge badge-warning ms-2">Masih Dirawat</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Petugas</strong></td>
                                    <td>{{ $surveilans->userCreated->name ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    {{-- Informasi Keluar & Diagnosa --}}
                    <div class="section-card">
                        <div class="section-header">
                            <i class="fas fa-clipboard-list"></i>
                            Informasi Medis
                        </div>
                        <div class="section-body">
                            <div class="info-row">
                                <strong>Sebab Keluar:</strong><br>
                                <div class="mt-1">{{ $surveilans->sebab_keluar ?? '-' }}</div>
                            </div>
                            <div class="info-row">
                                <strong>Diagnosa Akhir:</strong><br>
                                <div class="mt-1">{{ $surveilans->diagnosa_akhir ?? '-' }}</div>
                            </div>
                        </div>
                    </div>

                    {{-- Informasi Operasi --}}
                    @if($surveilans->jenis_operasi || $surveilans->ahli_bedah || $surveilans->scrub_nurse)
                        <div class="section-card">
                            <div class="section-header">
                                <i class="fas fa-procedures"></i>
                                Informasi Operasi
                            </div>
                            <div class="section-body">
                                <div class="info-card">
                                    <div class="info-card-header">Detail Operasi</div>
                                    <table class="table table-sm table-borderless mb-0">
                                        <tr><td width="25%">Jenis Operasi:</td><td>{{ $surveilans->jenis_operasi ?? '-' }}</td></tr>
                                        <tr><td>Ahli Bedah:</td><td>{{ $surveilans->ahli_bedah ?? '-' }}</td></tr>
                                        <tr><td>Scrub Nurse:</td><td>{{ $surveilans->scrub_nurse ?? '-' }}</td></tr>
                                        <tr><td>Tipe Operasi:</td><td>{{ $surveilans->tipe_operasi ?? '-' }}</td></tr>
                                        <tr><td>Jenis Luka:</td><td>{{ $surveilans->jenis_luka ?? '-' }}</td></tr>
                                        <tr><td>Lama Operasi:</td><td>{{ $surveilans->lama_operasi ?? '-' }}</td></tr>
                                        <tr><td>ASA Score:</td><td>{{ $surveilans->asa_score ?? '-' }}</td></tr>
                                        <tr><td>Risk Score:</td><td>{{ $surveilans->risk_score ?? '-' }}</td></tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Pemasangan Alat --}}
                    @if($surveilans->iv_perifer_tgl || $surveilans->iv_sentral_tgl || $surveilans->kateter_urine_tgl || $surveilans->ventilasi_mekanik_tgl)
                        <div class="section-card">
                            <div class="section-header">
                                <i class="fas fa-medical-kit"></i>
                                Pemasangan Alat Medis
                            </div>
                            <div class="section-body">
                                
                                @if($surveilans->iv_perifer_tgl)
                                    <div class="device-item">
                                        <div class="fw-bold text-primary">Intra Vena Cateter Perifer</div>
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <small class="text-muted">Tanggal Mulai:</small><br>
                                                {{ $surveilans->iv_perifer_tgl ? \Carbon\Carbon::parse($surveilans->iv_perifer_tgl)->format('d/m/Y') : '-' }}
                                            </div>
                                            <div class="col-md-6">
                                                <small class="text-muted">Tanggal Selesai:</small><br>
                                                {{ $surveilans->iv_perifer_sd ? \Carbon\Carbon::parse($surveilans->iv_perifer_sd)->format('d/m/Y') : 'Belum selesai' }}
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if($surveilans->iv_sentral_tgl)
                                    <div class="device-item">
                                        <div class="fw-bold text-primary">Intra Vena Cateter Sentral</div>
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <small class="text-muted">Tanggal Mulai:</small><br>
                                                {{ $surveilans->iv_sentral_tgl ? \Carbon\Carbon::parse($surveilans->iv_sentral_tgl)->format('d/m/Y') : '-' }}
                                            </div>
                                            <div class="col-md-6">
                                                <small class="text-muted">Tanggal Selesai:</small><br>
                                                {{ $surveilans->iv_sentral_sd ? \Carbon\Carbon::parse($surveilans->iv_sentral_sd)->format('d/m/Y') : 'Belum selesai' }}
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if($surveilans->kateter_urine_tgl)
                                    <div class="device-item">
                                        <div class="fw-bold text-primary">Kateter Urine</div>
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <small class="text-muted">Tanggal Mulai:</small><br>
                                                {{ $surveilans->kateter_urine_tgl ? \Carbon\Carbon::parse($surveilans->kateter_urine_tgl)->format('d/m/Y') : '-' }}
                                            </div>
                                            <div class="col-md-6">
                                                <small class="text-muted">Tanggal Selesai:</small><br>
                                                {{ $surveilans->kateter_urine_sd ? \Carbon\Carbon::parse($surveilans->kateter_urine_sd)->format('d/m/Y') : 'Belum selesai' }}
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if($surveilans->ventilasi_mekanik_tgl)
                                    <div class="device-item">
                                        <div class="fw-bold text-primary">Ventilasi Mekanik</div>
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <small class="text-muted">Tanggal Mulai:</small><br>
                                                {{ $surveilans->ventilasi_mekanik_tgl ? \Carbon\Carbon::parse($surveilans->ventilasi_mekanik_tgl)->format('d/m/Y') : '-' }}
                                            </div>
                                            <div class="col-md-6">
                                                <small class="text-muted">Tanggal Selesai:</small><br>
                                                {{ $surveilans->ventilasi_mekanik_sd ? \Carbon\Carbon::parse($surveilans->ventilasi_mekanik_sd)->format('d/m/Y') : 'Belum selesai' }}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    {{-- Penggunaan Antibiotika --}}
                    @if($surveilans->pemakaian_antibiotika)
                        <div class="section-card">
                            <div class="section-header">
                                <i class="fas fa-pills"></i>
                                Penggunaan Antibiotika
                            </div>
                            <div class="section-body">
                                <table class="table table-sm table-borderless mb-0">
                                    <tr><td width="25%">Pemakaian Antibiotika:</td><td>{{ $surveilans->pemakaian_antibiotika ?? '-' }}</td></tr>
                                    <tr><td>Nama Jenis Obat:</td><td>{{ $surveilans->nama_jenis_obat ?? '-' }}</td></tr>
                                    <tr><td>Tujuan Penggunaan:</td><td>{{ $surveilans->tujuan_penggunaan ?? '-' }}</td></tr>
                                </table>
                            </div>
                        </div>
                    @endif

                    {{-- Pemeriksaan Kultur --}}
                    @if($surveilans->pemeriksaan_kultur)
                        <div class="section-card">
                            <div class="section-header">
                                <i class="fas fa-microscope"></i>
                                Pemeriksaan Kultur
                            </div>
                            <div class="section-body">
                                <table class="table table-sm table-borderless mb-0">
                                    <tr><td width="25%">Jenis Pemeriksaan:</td><td>{{ $surveilans->pemeriksaan_kultur ?? '-' }}</td></tr>
                                    <tr><td>Temperatur:</td><td>{{ $surveilans->temp ? $surveilans->temp . '°C' : '-' }}</td></tr>
                                    <tr><td>Hasil Kultur:</td><td>{{ $surveilans->hasil_kultur ?? '-' }}</td></tr>
                                </table>
                            </div>
                        </div>
                    @endif

                    {{-- Infeksi Nosokomial --}}
                    @if($surveilans->bakteremia_sepsis || $surveilans->vap || $surveilans->infeksi_saluran_kemih || $surveilans->infeksi_luka_operasi || $surveilans->dekubitus || $surveilans->plebitis)
                        <div class="section-card">
                            <div class="section-header">
                                <i class="fas fa-exclamation-triangle"></i>
                                Infeksi Nosokomial yang Terjadi
                            </div>
                            <div class="section-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        @if($surveilans->bakteremia_sepsis)
                                            <div class="mb-2">
                                                <strong>Bakteremia/Sepsis:</strong><br>
                                                <span class="infection-badge">{{ $surveilans->bakteremia_sepsis }}</span>
                                            </div>
                                        @endif
                                        
                                        @if($surveilans->vap)
                                            <div class="mb-2">
                                                <strong>VAP:</strong><br>
                                                <span class="infection-badge">{{ $surveilans->vap }}</span>
                                            </div>
                                        @endif
                                        
                                        @if($surveilans->infeksi_saluran_kemih)
                                            <div class="mb-2">
                                                <strong>Infeksi Saluran Kemih:</strong><br>
                                                <span class="infection-badge">{{ $surveilans->infeksi_saluran_kemih }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        @if($surveilans->infeksi_luka_operasi)
                                            <div class="mb-2">
                                                <strong>Infeksi Luka Operasi:</strong><br>
                                                <span class="infection-badge">{{ $surveilans->infeksi_luka_operasi }}</span>
                                            </div>
                                        @endif
                                        
                                        @if($surveilans->dekubitus)
                                            <div class="mb-2">
                                                <strong>Dekubitus:</strong><br>
                                                <span class="infection-badge">{{ $surveilans->dekubitus }}</span>
                                            </div>
                                        @endif
                                        
                                        @if($surveilans->plebitis)
                                            <div class="mb-2">
                                                <strong>Plebitis:</strong><br>
                                                <span class="infection-badge">{{ $surveilans->plebitis }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Infeksi Lain --}}
                    @if($surveilans->infeksi_lain)
                        <div class="section-card">
                            <div class="section-header">
                                <i class="fas fa-virus"></i>
                                Infeksi Lain
                            </div>
                            <div class="section-body">
                                <div class="alert alert-warning mb-0">
                                    <strong>Infeksi Lain (HIV, HBC, HCV):</strong><br>
                                    {{ $surveilans->infeksi_lain }}
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Informasi Tambahan --}}
                    <div class="section-card">
                        <div class="section-header">
                            <i class="fas fa-clock"></i>
                            Informasi Tambahan
                        </div>
                        <div class="section-body">
                            <table class="table table-bordered table-sm">
                                <tr>
                                    <td width="30%"><strong>Tanggal Pembuatan</strong></td>
                                    <td>{{ $surveilans->created_at ? \Carbon\Carbon::parse($surveilans->created_at)->format('d/m/Y H:i') : '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Terakhir Diubah</strong></td>
                                    <td>
                                        {{ $surveilans->updated_at ? \Carbon\Carbon::parse($surveilans->updated_at)->format('d/m/Y H:i') : '-' }}
                                        @if($surveilans->userUpdated)
                                            <br><small class="text-muted">oleh {{ $surveilans->userUpdated->name }}</small>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('rawat-inap.surveilans-ppi.a2.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}" 
                           class="btn btn-secondary">
                            <i class="ti-arrow-left"></i> Kembali
                        </a>
                        
                        <div>
                            <a href="{{ route('rawat-inap.surveilans-ppi.a2.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $surveilans->id]) }}"
                                class="btn btn-primary">
                                <i class="ti-pencil-alt"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection