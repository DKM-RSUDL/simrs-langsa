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
            ['icon' => 'verified_badge.png', 'label' => 'Asesmen', 'link' => route('asesmen.index', $dataMedis->pasien->kd_pasien)],
            ['icon' => 'positive_dynamic.png', 'label' => 'CPPT', 'link' => route('cppt.index', $dataMedis->pasien->kd_pasien)],
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
        <div class="col-md-3">
            @component('components.patient-card', ['patient' => $dataMedis->pasien])
            @endcomponent
        </div>

        <div class="col-md-9">
            @component('components.navigation', ['navItems' => $navItems])
            @endcomponent
            <div class="d-flex justify-content-center">
                <h1>Asesmen Dashboard</h1>
            </div>
        </div>
    </div>
@endsection
