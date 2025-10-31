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
            @include('components.navigation-rahab-medis')
            <x-content-card>

                @include('components.page-header', [
                    'title' => 'Program Terapi',
                    'description' =>
                        'Daftar program terapi/pendampingan/sebelum dan sesudah sesi rehabilitasi pasien.',
                ])

                <!-- TAB 1. buatlah list disini -->
                @include('unit-pelayanan.rehab-medis.pelayanan.terapi.pelayanan-medis.index')

            </x-content-card>
        </div>
    </div>
@endsection
