@extends('layouts.administrator.master')

@section('content')
    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
        <style>
            .header-background {
                height: 100%;
                background-image: url("{{ asset('assets/img/background_gawat_darurat.png') }}");
            }
        </style>
    @endpush

    @php
        $tglMasukData = date('Y-m-d', strtotime($dataMedis->tgl_masuk));

        $navItems = [
            ['icon' => 'verified_badge.png', 'label' => 'Asesmen', 'link' => route('asesmen.index', [$dataMedis->pasien->kd_pasien, $tglMasukData])],
            ['icon' => 'positive_dynamic.png', 'label' => 'CPPT', 'link' => route('cppt.index', [$dataMedis->pasien->kd_pasien, $tglMasukData])],
            ['icon' => 'tools.png', 'label' => 'Tindakan', 'link' => route('tindakan.index', [$dataMedis->pasien->kd_pasien, $tglMasukData])],
            ['icon' => 'agree.png', 'label' => 'Konsultasi', 'link' => route('konsultasi.index', [$dataMedis->pasien->kd_pasien, $tglMasukData])],
            ['icon' => 'test_tube.png', 'label' => 'Labor', 'link' => route('labor.index', [$dataMedis->pasien->kd_pasien, $tglMasukData])],
            ['icon' => 'microbeam_radiation_therapy.png', 'label' => 'Radiologi', 'link' => route('radiologi.index', [$dataMedis->pasien->kd_pasien, $tglMasukData])],
            ['icon' => 'pill.png', 'label' => 'Farmasi', 'link' => route('farmasi.index', [$dataMedis->pasien->kd_pasien, $tglMasukData])],
            ['icon' => 'info.png', 'label' => 'Edukasi', 'link' => route('edukasi.index', [$dataMedis->pasien->kd_pasien, $tglMasukData])],
            ['icon' => 'goal.png', 'label' => 'Care Plan', 'link' => route('careplan.index', [$dataMedis->pasien->kd_pasien, $tglMasukData])],
            ['icon' => 'cv.png', 'label' => 'Resume', 'link' => route('resume.index', [$dataMedis->pasien->kd_pasien, $tglMasukData])],
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

            <div class="header-content" hidden>
                <h1>Dokter Dashbord</h1>
            </div>
        </div>
    </div>
@endsection
