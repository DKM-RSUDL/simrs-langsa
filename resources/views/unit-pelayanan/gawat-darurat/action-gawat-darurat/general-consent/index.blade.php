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
            <div class="d-flex justify-content-end">
                <div class="col-md-2">
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addGeneralConsentModal"
                            type="button">
                            <i class="ti-plus"></i> Tambah
                        </button>
                    </div>
                </div>
            </div>

            <div class="table-responsive mt-3">
                <table class="table table-bordered table-sm table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>Tanggal dan Jam</th>
                            <th>Petugas</th>
                            <th>Penanggung Jawab</th>
                            <th>Saksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.general-consent.modal')
@endsection
