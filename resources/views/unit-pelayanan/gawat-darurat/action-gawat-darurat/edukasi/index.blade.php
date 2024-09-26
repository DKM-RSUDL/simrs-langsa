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
            ['icon' => 'tools.png', 'label' => 'Tindakan', 'link' => route('tindakan.index', $dataMedis->pasien->kd_pasien)],
            ['icon' => 'agree.png', 'label' => 'Konsultasi', 'link' => route('konsultasi.index', $dataMedis->pasien->kd_pasien)],
            ['icon' => 'test_tube.png', 'label' => 'Labor', 'link' => route('labor.index', $dataMedis->pasien->kd_pasien)],
            ['icon' => 'microbeam_radiation_therapy.png', 'label' => 'Radiologi', 'link' => route('radiologi.index', $dataMedis->pasien->kd_pasien)],
            ['icon' => 'pill.png', 'label' => 'Farmasi', 'link' => route('farmasi.index', $dataMedis->pasien->kd_pasien)],
            ['icon' => 'info.png', 'label' => 'Edukasi', 'link' => route('edukasi.index', $dataMedis->pasien->kd_pasien)],
            ['icon' => 'goal.png', 'label' => 'Care Plan', 'link' => route('careplan.index', $dataMedis->pasien->kd_pasien)],
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
            <h1>Edukasi Dashboard</h1>
        </div>
    </div>
</div>
@endsection
