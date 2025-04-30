@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('vendor/chart.js/Chart.min.css') }}">
    <style>
        body {
            width: 100%;
        }
    </style>
@endpush

@section('content')
    <div class="content-wrapper">
        <div class="row same-height">
            <div class="col-md-5">
                <div class="card p-3 mb-4 rounded-lg position-relative">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            @if (empty(auth()->user()->karyawan->foto))
                                <img src="{{ asset('assets/images/avatar1.png') }}" alt="Profile Picture"
                                    class="rounded-circle w-100 avatar-lg img-fluid"
                                    style="max-width: 100px; height: auto;">
                            @else
                                    <img src="https://e-rsudlangsa.id/hrd/user/images/profil/{{ auth()->user()->karyawan->foto }}" alt="Profile Picture"
                                    class="rounded-circle w-100 avatar-lg img-fluid"
                                    style="max-width: 100px; height: auto;">
                            @endif

                        </div>
                        <div class="card-body">
                            <h6 class="card-title mb-2" style="font-size: 1.5rem; font-weight: 800;">
                                {{ auth()->user()->name }}
                            </h6>
                            @if (isset(auth()->user()->roles[0]->name))
                                <p class="card-text mb-1" style="font-size: 1rem;">Roles:
                                    <span class="fw-bold">{{ auth()->user()->roles[0]->name }}</span>
                                </p>
                            @endif
                            @if (isset(auth()->user()->profile->no_hp))
                                <p class="card-text mb-1" style="font-size: 1rem;">No Hp:
                                    <span class="fw-bold">{{ auth()->user()->profile->no_hp }}</span>
                                </p>
                            @endif
                            @if (isset(auth()->user()->email))
                                <p class="card-text mb-2" style="font-size: 1rem;">Email:
                                    <span class="fw-bold">{{ auth()->user()->email }}</span>
                                </p>
                            @endif
                            <div class="mt-2">
                                <a href="https://www.instagram.com" target="_blank" class="me-2"><i
                                        class="fab fa-instagram fa-lg"></i></a>
                                <a href="https://wa.me/085277678789" target="_blank" class="me-2"><i
                                        class="fab fa-whatsapp fa-lg"></i></a>
                                <a href="https://www.facebook.com" target="_blank"><i class="fab fa-facebook fa-lg"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="status-badge position-absolute top-0 end-0 mt-2 me-2">
                        <span class="badge bg-light text-success">
                            Aktif <i class="fas fa-circle text-success"></i>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-center mb-4 p-3">
                    <div class="mx-auto">
                        <h5 class="card-title">Tanggal</h5>
                        <p class="card-text">{{ date('d F Y') }}</p> <!-- Example date -->
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card mb-4 p-3">
                    <div class="card-body">
                        <h5 class="card-title">Status RME</h5>
                        <p class="card-text">Sistem Rekam Medis Elektronik RSUD Langsa: <span
                                class="fw-bold text-success">Online</span></p>
                        <a href="#" class="btn btn-primary btn-sm">Cek Detail</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-wrapper">
        <div class="row same-height">
            <div class="col-md-8">
                <div class="card mb-3 p-4">
                    <div class="row">
                        <div class="col-md-4 p-2">
                            <a href="{{ route('rawat-jalan.index') }}" class="text-decoration-none card-hover">
                                <div class="card mb-3" style="background: linear-gradient(to right, #f0f5ff, #f1f5f0);">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="me-2">
                                            <i class="fa fa-wheelchair fa-2x"></i>
                                        </div>
                                        <div>
                                            <div class="fs-6 fw-bold text-primary">Rawat Jalan</div>
                                            <div class="fs-6 text-muted">Pasien: <span class="fw-bold text-black">0</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4 p-2">
                            <a href="{{ route('rawat-inap.index') }}" class="text-decoration-none card-hover">
                                <div class="card mb-3" style="background: linear-gradient(to right, #f0f5ff, #f1f5f0);">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="me-2">
                                            <i class="fa fa-procedures fa-2x"></i>
                                        </div>
                                        <div>
                                            <div class="fs-6 fw-bold text-primary">Rawat Inap</div>
                                            <div class="fs-6 text-muted">Pasien: <span class="fw-bold text-black">0</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>


                        <div class="col-md-4 p-2">
                            <a href="{{ route('gawat-darurat.index') }}" class="text-decoration-none card-hover">
                                <div class="card mb-3" style="background: linear-gradient(to right, #f0f5ff, #f1f5f0);">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="me-2">
                                            <i class="fa fa-truck-medical fa-2x"></i>
                                        </div>
                                        <div>
                                            <div class="fs-6 fw-bold text-primary">Gawat Darurat</div>
                                            <div class="fs-6 text-muted">Pasien: <span class="fw-bold text-black">0</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4 p-2">
                            <a href="{{ route('operasi.index') }}" class="text-decoration-none card-hover">
                                <div class="card mb-3" style="background: linear-gradient(to right, #f0f5ff, #f1f5f0);">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="me-2">
                                            <i class="fa fa-person-dots-from-line fa-2x"></i>
                                        </div>
                                        <div>
                                            <div class="fs-6 fw-bold text-primary">Bedah Sentral</div>
                                            <div class="fs-6 text-muted">Pasien: <span class="fw-bold text-black">0</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4 p-2">
                            <a href="#" class="text-decoration-none card-hover">
                                <div class="card mb-3" style="background: linear-gradient(to right, #f0f5ff, #f1f5f0);">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="me-2">
                                            <i class="fa fa-lungs fa-2x"></i>
                                        </div>
                                        <div>
                                            <div class="fs-6 fw-bold text-primary">Hemodialisa</div>
                                            <div class="fs-6 text-muted">Pasien: <span class="fw-bold text-black">0</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4 p-2">
                            <a href="#" class="text-decoration-none card-hover">
                                <div class="card mb-3" style="background: linear-gradient(to right, #f0f5ff, #f1f5f0);">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="me-2">
                                            <i class="fa fa-flask fa-2x"></i>
                                        </div>
                                        <div>
                                            <div class="fs-6 fw-bold text-primary">Cathlab</div>
                                            <div class="fs-6 text-muted">Pasien: <span class="fw-bold text-black">0</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4 p-2">
                            <a href="{{ route('forensik.index') }}" class="text-decoration-none card-hover">
                                <div class="card mb-3" style="background: linear-gradient(to right, #f0f5ff, #f1f5f0);">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="me-2">
                                            <i class="fa fa-magnifying-glass fa-2x"></i>
                                        </div>
                                        <div>
                                            <div class="fs-6 fw-bold text-primary">Forensik</div>
                                            <div class="fs-6 text-muted">Pasien: <span class="fw-bold text-black">0</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4 p-2">
                            <a href="{{ route('rehab-medis.index') }}" class="text-decoration-none card-hover">
                                <div class="card mb-3" style="background: linear-gradient(to right, #f0f5ff, #f1f5f0);">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="me-2">
                                            <i class="fa fa-notes-medical fa-2x"></i>
                                        </div>
                                        <div>
                                            <div class="fs-6 fw-bold text-primary">Rehab Medik</div>
                                            <div class="fs-6 text-muted">Pasien: <span class="fw-bold text-black">0</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4 p-2">
                            <a href="#" class="text-decoration-none card-hover">
                                <div class="card mb-3" style="background: linear-gradient(to right, #f0f5ff, #f1f5f0);">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="me-2">
                                            <i class="fa fa-mortar-pestle fa-2x"></i>
                                        </div>
                                        <div>
                                            <div class="fs-6 fw-bold text-primary">Gizi Klinis</div>
                                            <div class="fs-6 text-muted">Pasien: <span class="fw-bold text-black">0</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4 p-4">
                    <h5 class="card-title">Informasi Sistem RME RSUD Langsa</h5>
                    <p class="card-text">
                        Sistem Rekam Medis Elektronik di RSUD Langsa mendukung pengelolaan data pasien secara digital sejak
                        pendaftaran hingga pelaporan.
                        Dengan teknologi terintegrasi, sistem ini memungkinkan akses cepat, efisiensi administrasi, dan
                        pengurangan penggunaan kertas sesuai
                        Peraturan Menteri Kesehatan No. 24 Tahun 2022.
                    </p>
                    <ul class="list-unstyled">
                        <li><strong>Lokasi:</strong> Jl. Jend. A. Yani No.1, Langsa, Aceh</li>
                        <li><strong>Status Akreditasi:</strong> Tingkat Utama (KARS 2017)</li>
                        <li><strong>Kontak:</strong> (0641) 22800</li>
                    </ul>
                    <a href="https://rsud.langsakota.go.id" target="_blank"
                        class="btn btn-outline-primary btn-sm">Kunjungi Situs Resmi</a>
                </div>
            </div>

        </div>


    </div>
@endsection

@push('js')
    <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="{{ asset('assets/js/pages/index.min.js') }}"></script>
@endpush
