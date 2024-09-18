@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('vendor/chart.js/Chart.min.css') }}">
@endpush

@section('content')
    <div class="content-wrapper">
        <div class="row same-height">
            {{-- card --}}
            <div class="col-md-6">
                <div class="card p-3 mb-4 rounded-lg position-relative">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <img src="{{ asset('assets/images/avatar1.png') }}" alt="Profile Picture"
                                class="rounded-circle w-100 avatar-lg img-fluid" style="max-width: 150px; height: auto;">
                        </div>
                        <div class="card-body">
                            <div class="mt-2">
                                <h5 class="card-title mb-2" style="font-size: 1.5rem; font-weight: 800">dr. Aleysa, Sp.PD
                                </h5>
                                <p class="card-text mb-1" style="font-size: 1.25rem;">Dokter: Spesialis Penyakit Dalam</p>
                                <p class="card-text mb-1" style="font-size: 1.25rem;">No Hp: 085277678789</p>
                                <p class="card-text mb-2" style="font-size: 1.25rem;">Email: aleysa@gmail.com</p>
                            </div>
                            <div class="mt-2">
                                <a href="https://www.instagram.com" target="_blank" class="me-2"><i
                                        class="fab fa-instagram fa-lg"></i></a>
                                <a href="https://wa.me/085277678789" target="_blank" class="me-2"><i
                                        class="fab fa-whatsapp fa-lg"></i></a>
                                <a href="https://www.facebook.com" target="_blank" class=""><i
                                        class="fab fa-facebook fa-lg"></i></a>
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

            <div class="col-md-3">
                <div class="card text-center mb-4 p-4">
                    <div class="date mx-auto"></div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card mb-4 p-3">
                    <div class="card-body">
                        <h5 class="card-title">Informasi</h5>
                        <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas quod
                            recusandae molestiae quam a vitae dolorum, nihil quidem accusamus ratione? Hic beatae, eius
                            voluptatem nobis dolore necessitatibus blanditiis ipsam ea.</p>
                        <a href="#" class="btn btn-primary">Selengkap</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-wrapper">
        <div class="row same-height">
            {{-- card --}}
            <div class="col-md-6">
                <div class="card mb-3 p-4">
                    <div class="row same-height">
                        <div class="col-md-4 p-2">
                            <a href="" class="text-decoration-none card-hover">
                                <div class="card mb-3"
                                    style="max-width: 18rem; background: linear-gradient(to right, #f0f5ff, #f1f5f0);">
                                    <div class="card-body d-flex align-items-center">
                                        <!-- Tambahkan d-flex dan align-items-center -->
                                        <!-- Icon Section -->
                                        <div class="me-2">
                                            <i class="fa fa-wheelchair fa-2x"></i>
                                        </div>
                                        <!-- Text Section -->
                                        <div>
                                            <div class="fs-6 fw-bold text-primary">Rawat Jalan</div>
                                            <div class="fs-6 text-muted">Pasien: <span class="fw-bold text-black">23</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4 p-2">
                            <a href="" class="text-decoration-none card-hover">
                                <div class="card mb-3"
                                    style="max-width: 18rem; background: linear-gradient(to right, #f0f5ff, #f1f5f0);">
                                    <div class="card-body d-flex align-items-center">
                                        <!-- Tambahkan d-flex dan align-items-center -->
                                        <!-- Icon Section -->
                                        <div class="me-2">
                                            <i class="fa fa-procedures fa-2x"></i>
                                        </div>
                                        <!-- Text Section -->
                                        <div>
                                            <div class="fs-6 fw-bold text-primary">Rawat Inap</div>
                                            <div class="fs-6 text-muted">Pasien: <span class="fw-bold text-black">11</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4 p-2">
                            <a href="" class="text-decoration-none card-hover">
                                <div class="card mb-3"
                                    style="max-width: 18rem; background: linear-gradient(to right, #f0f5ff, #f1f5f0);">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="me-2">
                                            <i class="fa fa-truck-medical fa-2x"></i>
                                        </div>
                                        <div>
                                            <div class="fs-6 fw-bold text-primary">Gawat Darurat</div>
                                            <div class="fs-6 text-muted">Pasien: <span class="fw-bold text-black">23</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4 p-2">
                            <a href="" class="text-decoration-none card-hover">
                                <div class="card mb-3"
                                    style="max-width: 18rem; background: linear-gradient(to right, #f0f5ff, #f1f5f0);">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="me-2">
                                            <i class="fa fa-person-dots-from-line fa-2x"></i>
                                        </div>
                                        <div>
                                            <div class="fs-6 fw-bold text-primary">Bedah Sentral</div>
                                            <div class="fs-6 text-muted">Pasien: <span class="fw-bold text-black">04</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4 p-2">
                            <a href="" class="text-decoration-none card-hover">
                                <div class="card mb-3"
                                    style="max-width: 18rem; background: linear-gradient(to right, #f0f5ff, #f1f5f0);">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="me-2">
                                            <i class="fa fa-lungs fa-2x"></i>
                                        </div>
                                        <div>
                                            <div class="fs-6 fw-bold text-primary">Hemodialisis</div>
                                            <div class="fs-6 text-muted">Pasien: <span
                                                    class="fw-bold text-black">23</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4 p-2">
                            <a href="" class="text-decoration-none card-hover">
                                <div class="card mb-3"
                                    style="max-width: 18rem; background: linear-gradient(to right, #f0f5ff, #f1f5f0);">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="me-2">
                                            <i class="fa fa-flask fa-2x"></i>
                                        </div>
                                        <div>
                                            <div class="fs-6 fw-bold text-primary">Cathlab</div>
                                            <div class="fs-6 text-muted">Pasien: <span
                                                    class="fw-bold text-black">31</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4 p-2">
                            <a href="" class="text-decoration-none card-hover">
                                <div class="card mb-3"
                                    style="max-width: 18rem; background: linear-gradient(to right, #f0f5ff, #f1f5f0);">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="me-2">
                                            <i class="fa fa-magnifying-glass fa-2x"></i>
                                        </div>
                                        <div>
                                            <div class="fs-6 fw-bold text-primary">Forensik</div>
                                            <div class="fs-6 text-muted">Pasien: <span
                                                    class="fw-bold text-black">31</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4 p-2">
                            <a href="" class="text-decoration-none card-hover">
                                <div class="card mb-3"
                                    style="max-width: 18rem; background: linear-gradient(to right, #f0f5ff, #f1f5f0);">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="me-2">
                                            <i class="fa fa-notes-medical fa-2x"></i>
                                        </div>
                                        <div>
                                            <div class="fs-6 fw-bold text-primary">Rehab Medis</div>
                                            <div class="fs-6 text-muted">Pasien: <span
                                                    class="fw-bold text-black">31</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4 p-2">
                            <a href="" class="text-decoration-none card-hover">
                                <div class="card mb-3"
                                    style="max-width: 18rem; background: linear-gradient(to right, #f0f5ff, #f1f5f0);">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="me-2">
                                            <i class="fa fa-mortar-pestle fa-2x"></i>
                                        </div>
                                        <div>
                                            <div class="fs-6 fw-bold text-primary">Gizi Klinis</div>
                                            <div class="fs-6 text-muted">Pasien: <span
                                                    class="fw-bold text-black">31</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mb-4 p-4">
                    <div class="card-body">
                        <h5 class="card-title">Informasi</h5>
                        <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas quod
                            recusandae molestiae quam a vitae dolorum, nihil quidem accusamus ratione? Hic beatae, eius
                            voluptatem nobis dolore necessitatibus blanditiis ipsam ea.</p>
                    </div>
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
