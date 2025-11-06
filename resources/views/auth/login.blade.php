@extends('layouts.auth.app')

@section('content')
    <div class="d-flex align-items-center bg-success-subtle">
        <div class="container-fluid px-0">
            <!-- GANTI: gunakan grid agar responsif -->
            <div class="row g-0 overflow-hidden rounded-4 shadow mx-auto">

                {{-- Kiri: Hero / Branding --}}
                <div class="col-12 col-md-6 d-flex flex-column justify-content-center bg-light p-4 p-md-5">
                    <h1 class="fw-bold text-dark mb-2 text-start">
                        Selamat Datang di EMRIS RSUD Langsa
                    </h1>
                    <p class="text-start text-secondary mb-4">
                        Electronic Medical Record Information System untuk mencatat, mengelola, dan memantau layanan
                        kesehatan secara cepat, aman, dan terstandar.
                    </p>

                    <div class="row g-3 mt-2">
                        <div class="col-6">
                            <img src="{{ asset('assets/img/auth1.png') }}" class="img-fluid rounded border" alt="Ilustrasi 1">
                        </div>
                        <div class="col-6">
                            <img src="{{ asset('assets/img/auth2.png') }}" class="img-fluid rounded border"
                                alt="Ilustrasi 2">
                        </div>
                    </div>
                </div>

                {{-- Kanan: Kartu Login --}}
                <div class="col-12 col-md-6 d-flex flex-column justify-content-center p-4 p-md-5 bg-white">
                    <div class="d-flex align-items-center gap-3 mb-4 w-100">
                        <img src="{{ asset('assets/img/logo.png') }}" alt="Logo"
                            style="width:64px; height:64px; object-fit:contain;">
                        <div class="text-start">
                            <div class="fw-bold text-dark">RSUD Langsa</div>
                            <small class="text-secondary">Electronic Medical Record</small>
                        </div>
                    </div>

                    <div class="mb-3 text-start">
                        <h2 class="h4 fw-bold text-dark mb-1">Masuk ke Sistem</h2>
                        <p class="text-secondary mb-0">Gunakan akun resmi yang telah terdaftar.</p>
                    </div>

                    {{-- Tombol Login --}}
                    <a href="{{ route('home') }}" class="btn btn-success w-100 fw-semibold mb-3">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Masuk ke RME
                    </a>

                    <div class="text-start">
                        <small class="text-secondary text-start">Butuh bantuan? Hubungi IT RSUD Langsa.</small>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
