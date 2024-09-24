@extends('layouts.administrator.master')

@section('content')
    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
        <style>
            .header-background {
                background-image: url("{{ asset('assets/img/background_gawat_darurat.png') }}");
            }
        </style>
    @endpush

    @php
        // Array that stores the navigation data
        $navItems = [
            ['icon' => 'verified_badge.png', 'label' => 'Asesmen', 'link' => route('asesmen')],
            ['icon' => 'positive_dynamic.png', 'label' => 'CPPT', 'link' => '#'],
            ['icon' => 'tools.png', 'label' => 'Tindakan', 'link' => '#'],
            ['icon' => 'agree.png', 'label' => 'Konsultasi', 'link' => '#'],
            ['icon' => 'test_tube.png', 'label' => 'Labor', 'link' => '#'],
            ['icon' => 'microbeam_radiation_therapy.png', 'label' => 'Radiologi', 'link' => '#'],
            ['icon' => 'pill.png', 'label' => 'Farmasi', 'link' => '#'],
            ['icon' => 'info.png', 'label' => 'Edukasi', 'link' => '#'],
            ['icon' => 'goal.png', 'label' => 'Care Plan', 'link' => '#'],
            ['icon' => 'cv.png', 'label' => 'Resume', 'link' => '#'],
        ];
    @endphp

        <div class="row">
            <!-- Patient Card Section -->
            <div class="col-md-3">
                <div class="position-relative patient-card">
                    <!-- Status Indicators -->
                    <div class="status-indicators">
                        <div class="status-indicator red"></div>
                        <div class="status-indicator orange"></div>
                        <div class="status-indicator green"></div>
                    </div>

                    <!-- Patient Photo -->
                    <div class="patient-photo">
                        <img src="{{ asset('assets/img/profile.jpg') }}" alt="Patient Photo">
                    </div>

                    <!-- Patient Information -->
                    <div class="patient-info">
                        <h6>{{ $dataMedis->pasien->nama ?? 'Tidak Diketahui' }}</h6>
                        <p class="mb-0">
                            {{ $dataMedis->pasien->jenis_kelamin == 1 ? 'Laki-laki' : ($dataMedis->pasien->jenis_kelamin == 0 ? 'Perempuan' : 'Tidak Diketahui') }}
                        </p>
                        <small>
                            {{ $dataMedis->pasien->umur ?? 'Tidak Diketahui' }} Thn
                            ({{ $dataMedis->pasien->tgl_lahir ? \Carbon\Carbon::parse($dataMedis->pasien->tgl_lahir)->format('d/m/Y') : 'Tidak Diketahui' }})
                        </small>


                        <div class="patient-meta mt-2">
                            <p class="mb-0"><i class="bi bi-file-earmark-medical"></i>RM: 0-76-34-33</p>
                            <p class="mb-0"><i class="bi bi-calendar3"></i>31 Jan 2025 - 31 Jan 2025</p>
                            <p><i class="bi bi-hospital"></i>Rawat Jalan (Klinik Internis Pria)</p>
                        </div>
                    </div>
                </div>

                <!-- Task List -->
                <div class="mt-2">
                    <div class="card-header">
                        <h4>Task:</h4>
                    </div>
                    <div class="card-body">
                        <ul class="timeline-xs">
                            <li class="timeline-item success">
                                <div class="margin-left-15">
                                    <p>Asesmen Awal Medis</p>
                                </div>
                            </li>
                            <li class="timeline-item success">
                                <div class="margin-left-15">
                                    <p>Asesmen Awal Keperawatan</p>
                                </div>
                            </li>
                            <li class="timeline-item success">
                                <div class="margin-left-15">
                                    <p>Order Laboratorium</p>
                                </div>
                            </li>
                            <li class="timeline-item info">
                                <div class="margin-left-15">
                                    <p>Resume Medis -(belum final)</p>
                                </div>
                            </li>
                            <li class="timeline-item info">
                                <div class="margin-left-15">
                                    <p>Perintah Rawat Inap</p>
                                </div>
                            </li>
                            <li class="timeline-item info">
                                <div class="margin-left-15">
                                    <p>Selesai</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Navigation and Header Section -->
            <div class="col-md-9">
                <div class="header-background">
                    <!-- Navigation bar inside header -->
                    <div class="nav-icons">
                        @foreach ($navItems as $item)
                            <a href="{{ $item['link'] }}">
                                <img src="{{ asset('assets/img/icons/' . $item['icon']) }}" alt="{{ $item['label'] }} Icon"
                                    width="25">
                                <span>{{ $item['label'] }}</span>
                            </a>
                        @endforeach
                    </div>

                    <!-- Header content (Text) -->
                    <div class="header-content">
                        <h1>Dokter Dashboard</h1>
                    </div>
                </div>
            </div>
        </div>
@endsection