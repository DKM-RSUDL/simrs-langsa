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

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            @include('components.navigation-forensik')

            <div class="header-content" hidden>
                <h1>Dokter Dashbord</h1>
            </div>
        </div>
    </div>
@endsection
