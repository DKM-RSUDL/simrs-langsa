@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        /* .header-background { background-image: url("{{ asset('assets/img/background_gawat_darurat.png') }}");} */
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
                <div class="card w-100 h-100">
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                                    type="button" role="tab" aria-controls="home" aria-selected="true">Asesmen Awal
                                    Medis</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                                    type="button" role="tab" aria-controls="profile" aria-selected="false">Skrining
                                    Khusus</button>
                            </li>
                        </ul>
                        <div class="d-flex justify-content-start align-items-center m-3">
                            <div class="btn-group me-2">
                                <button id="btnGroupDrop1" type="button" class="btn btn-outline-secondary dropdown-toggle"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Pilih PPA
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                    <li><a class="dropdown-item" href="#">Dropdown link</a></li>
                                    <li><a class="dropdown-item" href="#">Dropdown link</a></li>
                                </ul>
                            </div>
                            <div class="btn-group me-2">
                                <button id="btnGroupDrop2" type="button" class="btn btn-outline-secondary dropdown-toggle"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Pilih Kategori
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop2">
                                    <li><a class="dropdown-item" href="#">Kategori 1</a></li>
                                    <li><a class="dropdown-item" href="#">Kategori 2</a></li>
                                    <li><a class="dropdown-item" href="#">Kategori 3</a></li>
                                </ul>
                            </div>

                            <!-- Filter Tanggal -->
                            <div class="d-flex align-items-center me-2">
                                <label class="me-2">Dari: </label>
                                <input type="date" class="form-control me-2" id="startDate" name="start_date">
                            </div>
                            <div class="d-flex align-items-center me-2">
                                <label class="me-2">Sampai: </label>
                                <input type="date" class="form-control me-2" id="endDate" name="end_date">
                            </div>

                            <div class="d-flex ms-auto">
                                <input type="text" class="form-control w-100 me-2" placeholder="Search...">
                                <button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#detailPasienModal">Tambah</button>
                            </div>
                        </div>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel"
                                aria-labelledby="home-tab">
                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="m-2">
                                                <span class="fw-bold text-primary">29</span> <br>
                                                <span class="fw-bold">Mar-24</span> <br>
                                                <span class="fw">08:00</span>
                                            </div>
                                            <img src="{{ asset('assets/images/avatar1.png') }}" class="rounded-circle me-3"
                                                alt="Foto Pasien" width="70" height="70">
                                            <div>
                                                <span class="text-primary fw-bold">Asesmen Awal Keperawatan-Pasien
                                                    Umum/Dewasa</span> <br>
                                                By : <span class="fw-bold">Ns. Aleyndra, S.Kep</span> - Perawat Klinik
                                                Internis
                                            </div>
                                        </div>
                                        <div>
                                            <button class="btn btn-success">Lihat</button>
                                            <button class="btn btn-secondary">Edit</button>
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="m-2">
                                                <span class="fw-bold text-primary">29</span> <br>
                                                <span class="fw-bold">Mar-24</span> <br>
                                                <span class="fw">08:00</span>
                                            </div>
                                            <img src="{{ asset('assets/images/avatar1.png') }}"
                                                class="rounded-circle me-3" alt="Foto Pasien" width="70"
                                                height="70">
                                            <div>
                                                <span class="text-primary fw-bold">Asesmen Awal Keperawatan-Pasien
                                                    Umum/Dewasa</span> <br>
                                                By : <span class="fw-bold">Ns. Aleyndra, S.Kep</span> - Perawat Klinik
                                                Internis
                                            </div>
                                        </div>
                                        <div>
                                            <button class="btn btn-success">Lihat</button>
                                            <button class="btn btn-secondary">Edit</button>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                {{-- TAB 2. buatlah list disini --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen.create')
@endsection
