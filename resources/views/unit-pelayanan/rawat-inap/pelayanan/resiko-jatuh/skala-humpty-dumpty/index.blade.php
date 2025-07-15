@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>

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
                        {{-- Tabs --}}
                        <ul class="nav nav-tabs" id="skalaMorseTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a href="{{ route('rawat-inap.resiko-jatuh.morse.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}"
                                    class="nav-link @if (request()->routeIs('rawat-inap.resiko-jatuh.morse.index')) active @endif">
                                    <i class="bi bi-person-heart me-2"></i>
                                    Skala Morse
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="{{ route('rawat-inap.resiko-jatuh.humpty-dumpty.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}"
                                    class="nav-link @if (request()->routeIs('rawat-inap.resiko-jatuh.humpty-dumpty.index')) active @endif">
                                    <i class="bi bi-person-heart me-2"></i>
                                    Humpty Dumpty
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="#"
                                    class="nav-link #">
                                    <i class="bi bi-person-heart me-2"></i>
                                    Skala 3
                                </a>
                            </li>
                        </ul>

                        {{-- Tab Content --}}
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active">
                                {{-- TAB 1. buatlah list disini --}}
                                <div class="row">
                                    <div class="row m-3">
                                        <div class="col-md-3">
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="ti-search"></i>
                                                </span>
                                                <input type="text" class="form-control" placeholder="Cari data...">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-2">
                                            <input type="date" class="form-control" placeholder="Dari Tanggal">
                                        </div>
                                        
                                        <div class="col-md-2">
                                            <input type="date" class="form-control" placeholder="Sampai Tanggal">
                                        </div>
                                        
                                        <div class="col-md-2">
                                            <button class="btn btn-outline-secondary" type="button">
                                                <i class="ti-filter"></i> Filter
                                            </button>
                                        </div>
                                        
                                        <div class="col-md-3 text-end">
                                            <a href="{{ route('rawat-inap.resiko-jatuh.humpty-dumpty.create', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                                class="btn btn-primary">
                                                <i class="ti-plus"></i> Tambah
                                            </a>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm table-hover">
                                            <thead class="table-primary">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tgl Pengiriman</th>
                                                    <th>Nama Petugas</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                               
                                            </tbody>
                                        </table>
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

@push('js')
    <script>
    </script>
@endpush