@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        /* .header-background {
                    background-image: url("{{ asset('assets/img/background_gawat_darurat.png') }}");
                } */
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
            [
                'icon' => 'tools.png',
                'label' => 'Tindakan',
                'link' => route('tindakan.index', $dataMedis->pasien->kd_pasien),
            ],
            [
                'icon' => 'agree.png',
                'label' => 'Konsultasi',
                'link' => route('konsultasi.index', $dataMedis->pasien->kd_pasien),
            ],
            [
                'icon' => 'test_tube.png',
                'label' => 'Labor',
                'link' => route('labor.index', $dataMedis->pasien->kd_pasien),
            ],
            [
                'icon' => 'microbeam_radiation_therapy.png',
                'label' => 'Radiologi',
                'link' => route('radiologi.index', $dataMedis->pasien->kd_pasien),
            ],
            [
                'icon' => 'pill.png',
                'label' => 'Farmasi',
                'link' => route('farmasi.index', $dataMedis->pasien->kd_pasien),
            ],
            [
                'icon' => 'info.png',
                'label' => 'Edukasi',
                'link' => route('edukasi.index', $dataMedis->pasien->kd_pasien),
            ],
            [
                'icon' => 'goal.png',
                'label' => 'Care Plan',
                'link' => route('careplan.index', $dataMedis->pasien->kd_pasien),
            ],
            ['icon' => 'cv.png', 'label' => 'Resume', 'link' => route('resume.index', $dataMedis->pasien->kd_pasien)],
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
            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                                    type="button" role="tab" aria-controls="home" aria-selected="true">
                                    Lab Patologi Klinik (PK)
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                                    type="button" role="tab" aria-controls="profile" aria-selected="false">
                                    Lab Patologi Anatomi (PA)
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel"
                                aria-labelledby="home-tab">
                                {{-- TAB 1. buatlah list disini --}}
                                @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.labor.pktabs')
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                {{-- TAB 2. buatlah list disini --}}
                                @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.labor.patabs')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
