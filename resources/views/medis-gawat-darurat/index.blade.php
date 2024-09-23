@extends('layouts.administrator.master')

@section('content')
    @push('css')
        <style>
            /* Header styling with navigation */
            .header-background {
                background-color: #fff;
                background-image: url('{{ asset('assets/img/background_gawat_darurat.png') }}');
                background-size: cover;
                background-position: center;
                height: 500px;
                position: relative;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
            }

            .header-content {
                color: white;
                text-align: center;
                z-index: 2;
            }

            /* Styling for navigation bar */
            .nav-icons {
                display: flex;
                gap: 4px;
                justify-content: center;
                padding: 5px;
                background-color: #fff;
                border-radius: 15px;
                position: absolute;
                top: 10px;
                z-index: 1;
                width: 100%;
            }

            .nav-icons a {
                text-decoration: none;
                color: #000;
                display: flex;
                flex-direction: row;
                align-items: center;
                font-size: 9px;
                font-weight: bold;
            }

            .nav-icons a img {
                margin-right: 4px;
            }

            .nav-icons a span {
                color: #000;
            }

            /* Styling for patient card */
            .patient-card {
                border: 1px solid #e0e0e0;
                border-radius: 15px;
                padding: 20px;
                width: 100%;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                background-color: #fff;
            }

            .patient-photo img {
                border-radius: 10px;
                width: 50%;
                height: auto;
            }

            .status-indicators {
                position: absolute;
                top: 15px;
                right: 15px;
            }

            .status-indicator {
                width: 12px;
                height: 12px;
                border-radius: 50%;
                margin-bottom: 5px;
            }

            .status-indicator.red {
                background-color: red;
            }

            .status-indicator.orange {
                background-color: orange;
            }

            .status-indicator.green {
                background-color: green;
            }

            .patient-info {
                margin-top: 5px;
            }

            .patient-info h6 {
                font-size: 12px;
                font-weight: bold;
                margin-bottom: 5px;
            }

            .patient-info small {
                color: #6c757d;
            }

            .patient-meta {
                margin-top: 5px;
                font-size: 12px;
                color: #6c757d;
            }

            .patient-meta i {
                margin-right: 5px;
            }

            .row {
                margin-top: 20px;
            }
        </style>
    @endpush

    @php
        // Array that stores the navigation data
        $navItems = [
            ['icon' => 'verified_badge.png', 'label' => 'Asesmen', 'link' => '#'],
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

    <div class="container">
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
                        <img src="https://via.placeholder.com/150" alt="Patient Photo">
                    </div>

                    <!-- Patient Information -->
                    <div class="patient-info">
                        <h6>ANDI NURDIANSYAH</h6>
                        <p class="mb-0">Laki-laki</p>
                        <small>33 Thn (10/02/1985)</small>

                        <div class="patient-meta mt-2 ">
                            <p class="mb-0"><i class="bi bi-file-earmark-medical"></i>RM: 0-76-34-33</p>
                            <p class="mb-0"><i class="bi bi-calendar3"></i>31 Jan 2025 - 31 Jan 2025</p>
                            <p><i class="bi bi-hospital"></i>Rawat Jalan (Klinik Internis Pria)</p>
                        </div>
                    </div>
                </div>

                <!-- task -->
                <div class="mt-2">
                    <div class="card-header">
                        <h4>Task:</h4>
                    </div>
                    <div class="card-body">
                        <ul class="timeline-xs">
                            <li class="timeline-item success">
                                <div class="margin-left-15">
                                    <p>
                                        Asesmen Awal Medis
                                    </p>
                                </div>
                            </li>
                            <li class="timeline-item success">
                                <div class="margin-left-15">
                                    <p>
                                        Asesmen Awal Keperawatan
                                    </p>
                                </div>
                            </li>
                            <li class="timeline-item success">
                                <div class="margin-left-15">
                                    <p>
                                        Order Laboratorium
                                    </p>
                                </div>
                            </li>
                            <li class="timeline-item info">
                                <div class="margin-left-15">
                                    <p>
                                        Resume Medis -(belum final)
                                    </p>
                                </div>
                            </li>
                            <li class="timeline-item info">
                                <div class="margin-left-15">
                                    <p>
                                        Perintah Rawat Inap
                                    </p>
                                </div>
                            </li>
                            <li class="timeline-item info">
                                <div class="margin-left-15">
                                    <p>
                                        Selesai
                                    </p>
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
    </div>
@endsection
