@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        /* .header-background { background-image: url("{{ asset('assets/img/background_gawat_darurat.png') }}");} */
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            @include('components.navigation')

            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="asesmen-tab" data-bs-toggle="tab"
                                    data-bs-target="#asesmen" type="button" role="tab" aria-controls="asesmen"
                                    aria-selected="true">Asesmen Awal
                                    Medis</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="skrining-tab" data-bs-toggle="tab" data-bs-target="#skrining"
                                    type="button" role="tab" aria-controls="skrining" aria-selected="false">Skrining
                                    Khusus</button>
                            </li>
                        </ul>

                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="asesmen" role="tabpanel" aria-labelledby="asesmen-tab">
                                {{-- TAB 1. buatlah list disini --}}
                                @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen.asesmenawal')
                            </div>
                            <div class="tab-pane fade" id="skrining" role="tabpanel" aria-labelledby="skrining-tab">
                                {{-- TAB 2. buatlah list disini --}}
                                @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen.skriningkhusus')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
