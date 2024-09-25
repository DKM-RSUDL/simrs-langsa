@extends('layouts.administrator.master')

@section('content')
    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
        <style>
            .header-background {
                background-image: url("{{ asset('assets/img/background_gawat_darurat.png') }}");
            }
        </style>
    @endpush

    <div class="content-wrapper">
        <div class="row same-height">
            <!-- Patient Card Section -->
            @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.index')
        </div>
    </div>
@endsection
