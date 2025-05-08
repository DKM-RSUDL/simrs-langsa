@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .data-label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 0.3rem;
        }
        
        .data-value {
            margin-bottom: 1rem;
            color: #212529;
        }
        
        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #e9ecef;
            color: #1a3c34;
        }
        
        .diagnosis-item {
            background-color: #f8f9fa;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 0.8rem;
        }
        
        .diagnosis-label {
            font-weight: 500;
            margin-bottom: 0.2rem;
        }
        
        .diagnosis-text {
            margin-bottom: 0.5rem;
        }
        
        .btn-action {
            margin-right: 0.5rem;
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
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title">Detail Surat Kematian Pasien</h5>
                        <div>
                            <a href="{{ route('surat-kematian.index', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}" 
                               class="btn btn-outline-secondary btn-action">
                                <i class="ti-arrow-left"></i> Kembali
                            </a>
                            <a href="{{ route('surat-kematian.edit', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $suratKematian->id]) }}" 
                               class="btn btn-warning btn-action">
                                <i class="ti-pencil"></i> Edit
                            </a>
                            <a href="{{ route('surat-kematian.print', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $suratKematian->id]) }}" 
                               class="btn btn-primary" target="_blank">
                                <i class="ti-printer"></i> Cetak
                            </a>
                        </div>
                    </div>

                    {{-- Data Surat Kematian --}}
                    <div class="">
                        <div class="card-header">
                            <h6 class="card-title">Informasi Umum</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="data-label">Nomor Surat</div>
                                    <div class="data-value">{{ $suratKematian->nomor_surat ?: '-' }}</div>
                                    
                                    <div class="data-label">Tanggal Kematian</div>
                                    <div class="data-value">
                                        {{ \Carbon\Carbon::parse($suratKematian->tanggal_kematian)->format('d-m-Y') }}
                                    </div>
                                    
                                    <div class="data-label">Jam Kematian</div>
                                    <div class="data-value">{{ substr($suratKematian->jam_kematian, 0, 5) }}</div>
                                    
                                    <div class="data-label">Dokter</div>
                                    <div class="data-value">{{ $suratKematian->dokter->nama_lengkap ?? '-' }}</div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="data-label">Tempat Kematian</div>
                                    <div class="data-value">{{ $suratKematian->tempat_kematian ?: '-' }}</div>
                                    
                                    <div class="data-label">Kabupaten/Kota</div>
                                    <div class="data-value">{{ $suratKematian->kabupaten_kota ?: '-' }}</div>
                                    
                                    <div class="data-label">Umur Saat Meninggal</div>
                                    <div class="data-value">
                                        @if($suratKematian->umur > 0)
                                            {{ $suratKematian->umur }} tahun
                                        @endif
                                        
                                        @if($suratKematian->bulan > 0)
                                            {{ $suratKematian->bulan }} bulan
                                        @endif
                                        
                                        @if($suratKematian->hari > 0)
                                            {{ $suratKematian->hari }} hari
                                        @endif
                                        
                                        @if($suratKematian->jam > 0)
                                            {{ $suratKematian->jam }} jam
                                        @endif
                                        
                                        @if($suratKematian->umur == 0 && $suratKematian->bulan == 0 && $suratKematian->hari == 0 && $suratKematian->jam == 0)
                                            -
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Data Penyebab Kematian --}}
                    <div class="">
                        <div class="card-header">
                            <h6 class="card-title">Diagnosis Penyebab Kematian</h6>
                        </div>
                        <div class="card-body">
                            <div class="section-title">I. Penyakit atau keadaan yang langsung mengakibatkan kematian</div>
                            
                            @if($suratKematian->detailType1->count() > 0)
                                @foreach($suratKematian->detailType1 as $index => $detail)
                                    <div class="diagnosis-item">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="diagnosis-label">Diagnosa</div>
                                                <div class="diagnosis-text">{{ $detail->keterangan }}</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="diagnosis-label">Disebabkan/Akibat dari</div>
                                                <div class="diagnosis-text">{{ $detail->konsekuensi ?: '-' }}</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="diagnosis-label">Lamanya (kira-kira)</div>
                                                <div class="diagnosis-text">{{ $detail->estimasi ?: '-' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-muted">Tidak ada data diagnosa penyebab kematian.</p>
                            @endif
                            
                            <div class="section-title mt-4">II. Penyakit-penyakit lain yang mempengaruhi kematian</div>
                            
                            @if($suratKematian->detailType2->count() > 0)
                                @foreach($suratKematian->detailType2 as $index => $detail)
                                    <div class="diagnosis-item">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="diagnosis-label">Penyakit</div>
                                                <div class="diagnosis-text">{{ $detail->keterangan }}</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="diagnosis-label">Lamanya (kira-kira)</div>
                                                <div class="diagnosis-text">{{ $detail->estimasi ?: '-' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-muted">Tidak ada data penyakit lain yang mempengaruhi kematian.</p>
                            @endif
                        </div>
                    </div>

                    {{-- Metadata --}}
                    <div class="">
                        <div class="card-header">
                            <h6 class="card-title">Informasi Tambahan</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="data-label">Tanggal Pembuatan Surat</div>
                                    <div class="data-value">
                                        {{ $suratKematian->tanggal_surat ? \Carbon\Carbon::parse($suratKematian->tanggal_surat)->format('d-m-Y H:i') : '-' }}
                                    </div>
                                </div>
                                @if(isset($suratKematian->user_create) || isset($suratKematian->user_edit))
                                <div class="col-md-6">
                                    <div class="data-label">Dibuat/Diubah oleh</div>
                                    <div class="data-value">
                                        @if($suratKematian->user_create)
                                            Dibuat: User ID {{ $suratKematian->user_create }}
                                        @endif
                                        @if($suratKematian->user_edit && $suratKematian->user_edit != $suratKematian->user_create)
                                            <br>Diubah: User ID {{ $suratKematian->user_edit }}
                                        @endif
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection