@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .patient-card .nav-link.active {
            background-color: #0056b3;
            color: #fff;
        }

        .patient-card img.rounded-circle {
            object-fit: cover;
        }

        .tab-content {
            flex-grow: 1;
            width: 350px;
        }
    </style>
@endpush

@section('content')
    @php
        // Prepare navigation items
        $navItems = [
            [
                'icon' => 'verified_badge.png',
                'label' => 'Asesmen',
                'link' => route('asesmen.index', $dataMedis->pasien->kd_pasien),
            ],
            [
                'icon' => 'positive_dynamic.png',
                'label' => 'CPPT',
                'link' => route('cppt.index', $dataMedis->pasien->kd_pasien),
            ],
            ['icon' => 'tools.png', 'label' => 'Tindakan', 'link' => '#'],
            ['icon' => 'agree.png', 'label' => 'Konsultasi', 'link' => '#'],
            ['icon' => 'test_tube.png', 'label' => 'Labor', 'link' => '#'],
            ['icon' => 'microbeam_radiation_therapy.png', 'label' => 'Radiologi', 'link' => '#'],
            ['icon' => 'pill.png', 'label' => 'Farmasi', 'link' => '#'],
            ['icon' => 'info.png', 'label' => 'Edukasi', 'link' => '#'],
            ['icon' => 'goal.png', 'label' => 'Care Plan', 'link' => '#'],
            ['icon' => 'cv.png', 'label' => 'Resume', 'link' => '#'],
        ];

        // Prepare content for each tab
        $tabContents = [
            [
                'tanggal' => '02 Mar 2024',
                'time' => '8:30',
                'avatar' => 'profile.jpg',
                'name' => 'Ns. Aleyndra, S.Kep',
                'role' => 'Perawat Klinik Internis',
                'subjective' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'objective' => [
                    'TD' => '___ / ___ mmHg',
                    'RR' => '___ x/mnt',
                    'TB' => '___ M',
                    'Temp' => '___ C',
                    'Resp' => '___ x/mnt',
                    'BB' => '___ Kg',
                ],
                'assessment' => ['Hipertensi Kronis', 'Dyspepsia', 'Depresive Episode'],
                'plan' => ['Stabilisasi TD sampai batas normal', 'Terapi obat', 'Lanjutkan perawatan'],
            ],
            [
                'tanggal' => '03 Mar 2024',
                'time' => '9:30',
                'avatar' => 'profile1.jpg',
                'name' => 'Dr. Amanda',
                'role' => 'Perawat Klinik Internis',
                'subjective' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'objective' => [
                    'TD' => '___ / ___ mmHg',
                    'RR' => '___ x/mnt',
                    'TB' => '___ M',
                    'Temp' => '___ C',
                    'Resp' => '___ x/mnt',
                    'BB' => '___ Kg',
                ],
                'assessment' => ['Hipertensi Kronis', 'Dyspepsia', 'Depresive Episode'],
                'plan' => ['Stabilisasi TD sampai batas normal', 'Terapi obat', 'Lanjutkan perawatan'],
            ],
            [
                'tanggal' => '01 Mar 2024',
                'time' => '10:30',
                'avatar' => 'profile2.jpg',
                'name' => 'Ns. Eka Wira , S.Kep ',
                'role' => 'Perawat Klinik Internis',
                'subjective' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'objective' => [
                    'TD' => '___ / ___ mmHg',
                    'RR' => '___ x/mnt',
                    'TB' => '___ M',
                    'Temp' => '___ C',
                    'Resp' => '___ x/mnt',
                    'BB' => '___ Kg',
                ],
                'assessment' => ['Hipertensi Kronis', 'Dyspepsia', 'Depresive Episode'],
                'plan' => ['Stabilisasi TD sampai batas normal', 'Terapi obat', 'Lanjutkan perawatan'],
            ],
        ];

    @endphp

    <div class="row">
        <div class="col-md-3">
            @component('components.patient-card', ['patient' => $dataMedis->pasien])
            @endcomponent
        </div>

        <div class="col-md-9">
            @component('components.navigation', ['navItems' => $navItems])
            @endcomponent

            <!-- Content -->
            <div class="patient-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="text-primary mb-0">Catatan Perkembangan Pasien Terintegrasi</h6>
                    <h6 class="text-secondary mb-0">Grafik</h6>
                </div>

                <div class="row g-3">
                    <!-- Select PPA Option -->
                    <div class="col-md-2">
                        <select class="form-select" id="SelectOption" aria-label="Pilih...">
                            <option value="semua" selected>Semua PPA</option>
                            <option value="option1">Dokter Spesialis</option>
                            <option value="option2">Dokter Umum</option>
                            <option value="option3">Perawat/bidan</option>
                            <option value="option4">Nutrisionis</option>
                            <option value="option5">Apoteker</option>
                            <option value="option6">Fisioterapis</option>
                        </select>
                    </div>

                    <!-- Select Episode Option -->
                    <div class="col-md-2">
                        <select class="form-select" id="SelectEpisode" aria-label="Pilih...">
                            <option value="semua" selected>Semua Episode</option>
                            <option value="Episode1">Episode Sekarang</option>
                            <option value="Episode2">1 Bulan</option>
                            <option value="Episode3">3 Bulan</option>
                            <option value="Episode4">6 Bulan</option>
                            <option value="Episode5">9 Bulan</option>
                        </select>
                    </div>

                    <!-- Start Date -->
                    <div class="col-md-2">
                        <input type="date" name="start_date" id="start_date" class="form-control"
                            placeholder="Dari Tanggal">
                    </div>

                    <!-- End Date -->
                    <div class="col-md-2">
                        <input type="date" name="end_date" id="end_date" class="form-control" placeholder="S.d Tanggal">
                    </div>

                    <!-- Search Bar -->
                    <div class="col-md-2">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" class="form-control" placeholder="Cari" aria-label="Cari"
                                aria-describedby="basic-addon1">
                        </div>
                    </div>

                    <!-- Add Button -->
                    <!-- Include the modal file -->
                    <div class="col-md-2">
                        @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.cppt.modal')
                    </div>
                </div>

                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <!-- Sidebar navigation -->
                        <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist"
                            aria-orientation="vertical">
                            @foreach ($tabContents as $index => $content)
                                <button class="nav-link @if ($index == 0) active @endif"
                                    id="v-pills-home-tab-{{ $index }}" data-bs-toggle="pill"
                                    href="#v-pills-home-{{ $index }}" role="tab"
                                    aria-selected="{{ $index == 0 }}">
                                    <div class="d-flex align-items-center">
                                        <div class="text-center me-2">
                                            <strong class="d-block">
                                                {{ date('d M', strtotime($content['tanggal'])) }}
                                            </strong>
                                            <small class="d-block">
                                                {{ $content['time'] }}
                                            </small>
                                        </div>
                                        <img src="{{ asset('assets/img/' . $content['avatar']) }}" alt="Avatar"
                                            class="rounded-circle" width="50" height="50">
                                        <div class="ms-3">
                                            <p class="mb-0"><strong>{{ $content['name'] }}</strong></p>
                                            <small class="text-muted">{{ $content['role'] }}</small>
                                        </div>
                                    </div>
                                </button>
                            @endforeach
                        </div>

                        <!-- Tab content -->
                        <div class="tab-content flex-grow-1" id="v-pills-tabContent">
                            @foreach ($tabContents as $index => $content)
                                <div class="tab-pane fade @if ($index == 0) show active @endif"
                                    id="v-pills-home-{{ $index }}" role="tabpanel">
                                    <div class="patient-card bg-secondary-subtle">
                                        <p class="mb-0 text-end">{{ $content['tanggal'] }} {{ $content['time'] }}</p>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('assets/img/' . $content['avatar']) }}" alt="Avatar"
                                                class="rounded-circle" width="50" height="50">
                                            <div class="ms-3">
                                                <p class="mb-0 fw-bold">Catatan Perkembangan Pasien Terintegrasi</p>
                                                <small class="text-muted">
                                                    <span class="fw-bold">{{ $content['name'] }}</span>
                                                    ({{ $content['role'] }})
                                                </small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Subjective -->
                                    <div class="row mt-3">
                                        <div class="col-1">
                                            <h6><strong>S</strong></h6>
                                        </div>
                                        <div class="col-11">
                                            <p>{{ $content['subjective'] }}</p>
                                        </div>
                                    </div>

                                    <!-- Objective -->
                                    <div class="row">
                                        <div class="col-1">
                                            <h6><strong>O</strong></h6>
                                        </div>
                                        <div class="col-11">
                                            <div class="row">
                                                <div class="col-md-3">TD: {{ $content['objective']['TD'] }}</div>
                                                <div class="col-md-3">RR: {{ $content['objective']['RR'] }}</div>
                                                <div class="col-md-3">TB: {{ $content['objective']['TB'] }}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">Temp: {{ $content['objective']['Temp'] }}</div>
                                                <div class="col-md-3">Resp: {{ $content['objective']['Resp'] }}</div>
                                                <div class="col-md-3">BB: {{ $content['objective']['BB'] }}</div>
                                            </div>
                                            <p>{{ $content['subjective'] }}</p>
                                        </div>
                                    </div>

                                    <!-- Assessment -->
                                    <div class="row">
                                        <div class="col-1">
                                            <h6><strong>A</strong></h6>
                                        </div>
                                        <div class="col-11">
                                            <ul>
                                                @foreach ($content['assessment'] as $assessment)
                                                    <li>{{ $assessment }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>

                                    <!-- Plan -->
                                    <div class="row mt-3">
                                        <div class="col-1">
                                            <h6><strong>P</strong></h6>
                                        </div>
                                        <div class="col-11">
                                            <ul>
                                                @foreach ($content['plan'] as $plan)
                                                    <li>{{ $plan }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>

                                    <!-- Button -->
                                    <div class="d-flex justify-content-between mt-4">
                                        <button class="btn btn-primary">Verifikasi DPJP</button>
                                        <button class="btn btn-primary">Edit</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('js')
<script>
    // Event listener untuk membuka Modal Kedua tanpa menutup Modal Pertama
    document.getElementById('openModalKedua').addEventListener('click', function() {
        var modalKedua = new bootstrap.Modal(document.getElementById('verticalCenter'));
        modalKedua.show();
    });
</script>

@endpush
