@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
        /* .header-background { background-image: url("{{ asset('assets/img/background_gawat_darurat.png') }}");} */
    </style>
@endpush

@section('content')
    @php

        $tglMasukData = date('Y-m-d', strtotime($dataMedis->tgl_masuk));
        // Prepare navigation items
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
            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        {{-- Tabs --}}
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="resep-tab" data-bs-toggle="tab" data-bs-target="#resep"
                                    type="button" role="tab" aria-controls="resep" aria-selected="true">E-Resep Obat &
                                    BMHP</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="riwayat-tab" data-bs-toggle="tab" data-bs-target="#riwayat"
                                    type="button" role="tab" aria-controls="riwayat" aria-selected="false">Riwayat
                                    Penggunaan Obat</button>
                            </li>
                        </ul>

                        {{-- Tab Content --}}
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="resep" role="tabpanel" aria-labelledby="resep-tab">
                                {{-- TAB 1. buatlah list disini --}}
                                @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.farmasi.tabsresep')
                            </div>
                            <div class="tab-pane fade" id="riwayat" role="tabpanel" aria-labelledby="riwayat-tab">
                                {{-- TAB 2. buatlah list disini --}}
                                @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.farmasi.tabsriwayat')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
