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
                            <img src="{{ asset('assets/images/avatar1.png') }}" alt="Profile Picture"
                                class="rounded-circle w-100 avatar-lg img-fluid" style="max-width: 100px; height: auto;">
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

                                <a href="https://www.instagram.com" target="_blank" class="me-2"><i class="fab fa-instagram fa-lg"></i></a>
                                <a href="https://wa.me/085277678789" target="_blank" class="me-2"><i class="fab fa-whatsapp fa-lg"></i></a>
                                <a href="https://www.facebook.com" target="_blank"><i class="fab fa-facebook fa-lg"></i></a>
                                <h5 class="card-title mb-2" style="font-size: 1.5rem; font-weight: 800">
                                    {{ auth()->user()->name }}
                                </h5>
                                @if (isset(auth()->user()->roles[0]->name))
                                    <p class="card-text mb-1" style="font-size: 1.25rem;">Roles:
                                        {{ auth()->user()->roles[0]->name }}</p>
                                @endif

                                @if (isset(auth()->user()->profile->no_hp))
                                    <p class="card-text mb-1" style="font-size: 1.25rem;">No Hp:
                                        {{ auth()->user()->profile->no_hp }}</p>
                                @endif

                                @if (isset(auth()->user()->email))
                                    <p class="card-text mb-2" style="font-size: 1.25rem;">Email: {{ auth()->user()->email }}
                                    </p>
                                @endif

                            </div>
                            <div class="mt-2">
                                <a href="https://www.instagram.com" target="_blank" class="me-2"><i
                                        class="fab fa-instagram fa-lg"></i></a>
                                <a href="https://wa.me/085277678789" target="_blank" class="me-2"><i
                                        class="fab fa-whatsapp fa-lg"></i></a>
                                <a href="https://www.facebook.com" target="_blank" class=""><i
                                        class="fab fa-facebook fa-lg"></i></a>
                                <a href="https://www.instagram.com" target="_blank" class="me-2"><i class="fab fa-instagram fa-lg"></i></a>
                                <a href="https://wa.me/085277678789" target="_blank" class="me-2"><i class="fab fa-whatsapp fa-lg"></i></a>
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
                    <div class="date mx-auto">
                        <h5 class="card-title">Tanggal</h5>
                        <p class="card-text">{{ date('d F Y') }}</p> <!-- Example date -->
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card mb-4 p-3">
                    <div class="card-body">
                        <h5 class="card-title">Informasi</h5>
                        <p class="card-text">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas quod recusandae molestiae quam a vitae dolorum
                        </p>
                        <a href="#" class="btn btn-primary">Selengkap</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-wrapper">
        <div class="row same-height">
            <div class="col-md-8">
            {{-- card --}}
            <div class="col-md-6">
                <div class="card mb-3 p-4">
                    <div class="row">
                        @foreach ([
                            ['route' => route('rawat-jalan.index'), 'icon' => 'wheelchair', 'title' => 'Rawat Jalan', 'patients' => 23],
                            ['route' => '#', 'icon' => 'procedures', 'title' => 'Rawat Inap', 'patients' => 11],
                            ['route' => route('gawat-darurat.index'), 'icon' => 'truck-medical', 'title' => 'Gawat Darurat', 'patients' => 23],
                            ['route' => '#', 'icon' => 'truck-medical', 'title' => 'Gawat Darurat', 'patients' => 23],
                            ['route' => '#', 'icon' => 'person-dots-from-line', 'title' => 'Bedah Sentral', 'patients' => 4],
                            ['route' => '#', 'icon' => 'lungs', 'title' => 'Hemodialisis', 'patients' => 23],
                            ['route' => '#', 'icon' => 'flask', 'title' => 'Cathlab', 'patients' => 31],
                            ['route' => '#', 'icon' => 'magnifying-glass', 'title' => 'Forensik', 'patients' => 31],
                            ['route' => '#', 'icon' => 'notes-medical', 'title' => 'Rehab Medis', 'patients' => 31],
                            ['route' => '#', 'icon' => 'mortar-pestle', 'title' => 'Gizi Klinis', 'patients' => 31]
                        ] as $card)
                        <div class="col-md-4 p-2">
                            <a href="{{ $card['route'] }}" class="text-decoration-none card-hover">
                                <div class="card mb-3" style="background: linear-gradient(to right, #f0f5ff, #f1f5f0);">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="me-2">
                                            <i class="fa fa-{{ $card['icon'] }} fa-2x"></i>
                                        </div>
                                        <div>
                                            <div class="fs-6 fw-bold text-primary">{{ $card['title'] }}</div>
                                            <div class="fs-6 text-muted">Pasien: <span class="fw-bold text-black">{{ $card['patients'] }}</span></div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-md-4">
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
