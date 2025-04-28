@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        #asesmenList .list-group-item:nth-child(even) {
            background-color: #edf7ff;
        }

        #asesmenList .list-group-item:nth-child(odd) {
            background-color: #ffffff;
        }

        #asesmenList .list-group-item:hover {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .list-group-item {
            margin-bottom: 0.2rem;
            border-radius: 0.5rem !important;
            padding: 1rem;
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
            @include('components.navigation-ranap')

            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title mb-0">Monitoring Intensive Care</h4>
                            <a href="{{ route('rawat-inap.monitoring.create', [
                                'kd_unit' => request()->route('kd_unit'),
                                'kd_pasien' => request()->route('kd_pasien'),
                                'tgl_masuk' => request()->route('tgl_masuk'),
                                'urut_masuk' => request()->route('urut_masuk'),
                            ]) }}"
                                class="btn btn-primary d-flex align-items-center gap-2">
                                <i class="fa fa-plus"></i> Tambah Monitoring
                            </a>
                        </div>

                        <div class="alert alert-info mb-4">
                            <p class="mb-0">Halaman ini digunakan untuk memantau dan mencatat kondisi pasien pada unit
                                perawatan intensif.</p>
                        </div>

                        <div class="mt-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5>Riwayat Monitoring</h5>
                                <div class="input-group w-50">
                                    <input type="text" class="form-control" placeholder="Cari riwayat...">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="list-group" id="asesmenList">
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">ICU Monitoring</h6>
                                            <small class="text-muted">Dibuat oleh: Dr. Anwar - 24/04/2025 08:30</small>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-sm btn-info d-flex align-items-center gap-2">
                                                <i class="fa fa-eye"></i>
                                                <span>Lihat</span>
                                            </button>
                                            <button class="btn btn-sm btn-warning d-flex align-items-center gap-2">
                                                <i class="fa fa-edit"></i>
                                                <span>Edit</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
