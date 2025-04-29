@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
        <style>
        #asesmenList .list-group-item:nth-child(even) {
            background-color: #edf7ff;
        }

        /* Background putih untuk item ganjil */
        #asesmenList .list-group-item:nth-child(odd) {
            background-color: #ffffff;
        }

        /* Efek hover tetap sama untuk konsistensi */
        #asesmenList .list-group-item:hover {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .list-group-item {
            margin-bottom: 0.2rem;
            border-radius: 0.5rem !important;
            padding: 0.5rem;
            border: 1px solid #dee2e6;
            background: white;
            transition: all 0.2s;
        }

        .list-group-item:hover {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .gap-2 {
            gap: 0.5rem !important;
        }

        .gap-3 {
            gap: 1rem !important;
        }

        .gap-4 {
            gap: 1.5rem !important;
        }

        .btn-sm {
            padding: 0.4rem 1rem;
            font-size: 0.875rem;
        }

        .btn i {
            font-size: 0.875rem;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            @include('components.navigation-operasi')

            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">

                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="ceklist-kesiapan-tab" data-bs-toggle="tab"
                                    data-bs-target="#ceklist-kesiapan" type="button" role="tab" aria-controls="ceklist-kesiapan"
                                    aria-selected="true">
                                    Ceklist Kesiapan
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="laporan-tab" data-bs-toggle="tab" data-bs-target="#laporan"
                                    type="button" role="tab" aria-controls="laporan" aria-selected="false">
                                    Laporan
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="ceklist-kesiapan" role="tabpanel"
                                aria-labelledby="ceklist-kesiapan-tab">
                                {{-- TAB 1. buatlah list disini --}}
                                @include('unit-pelayanan.operasi.pelayanan.ceklist-anasthesi.index')
                            </div>
                            <div class="tab-pane fade" id="laporan" role="tabpanel" aria-labelledby="laporan-tab">
                                {{-- TAB 2. buatlah list disini --}}
                                @include('unit-pelayanan.operasi.pelayanan.laporan-anastesi.list')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
@endpush
