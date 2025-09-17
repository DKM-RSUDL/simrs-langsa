@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .dropdown-menu {
            max-height: 400px;
            overflow-y: auto;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            @include('components.navigation-rajal')

            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        {{-- Tabs --}}
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active fw-bold" id="resep-tab" data-bs-toggle="tab"
                                    data-bs-target="#resep" type="button" role="tab" aria-controls="resep"
                                    aria-selected="true">
                                    Pelayanan Medis
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-bold" id="riwayat-tab" data-bs-toggle="tab"
                                    data-bs-target="#riwayat" type="button" role="tab" aria-controls="riwayat"
                                    aria-selected="false">
                                    Program
                                </button>
                            </li>
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="resep" role="tabpanel"
                                aria-labelledby="resep-tab">
                                <!-- TAB 1. buatlah list disini -->
                                @include('unit-pelayanan.rawat-jalan.pelayanan.rehab.layanan.pelayanan-medis.index')
                            </div>
                            <div class="tab-pane fade" id="riwayat" role="tabpanel" aria-labelledby="riwayat-tab">
                                <!-- TAB 2. buatlah list disini -->
                                @include('unit-pelayanan.rawat-jalan.pelayanan.rehab.layanan.program.index')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
