@extends('layouts.administrator.master')
@push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
        <style>
            /* .header-background {
                background-image: url("{{ asset('assets/img/background_gawat_darurat.png') }}");
            } */
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
            <h1>Care Plan Dashboard</h1>
        </div>
    </div>
</div>
@endsection
