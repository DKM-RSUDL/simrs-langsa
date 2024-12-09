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
            <div class="d-flex justify-content-between align-items-center m-3">
                <div class="row">
                    <!-- Filter by Service Type -->
                    <div class="col-md-2">
                        <select class="form-select" id="SelectService" aria-label="Pilih...">
                            <option value="semua" selected>Semua Pelayanan</option>
                        </select>
                    </div>

                    <!-- Date Range -->
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="date" name="start_date" id="start_date" class="form-control"
                                    placeholder="Dari Tanggal">
                            </div>
                            <div class="col-md-6">
                                <input type="date" name="end_date" id="end_date" class="form-control"
                                    placeholder="S.d Tanggal">
                            </div>
                        </div>
                    </div>

                    <!-- Search Bar -->
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari nama petugas..."
                                aria-label="Cari">
                            <button type="submit" class="btn btn-primary">Cari</button>
                        </div>
                    </div>

                    <!-- Add Button -->
                    <div class="col-md-2">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRujukAntarRs"
                            type="button">
                            <i class="ti-plus"></i> Tambah
                        </button>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>Tanggal & Jam</th>
                            <th>Petugas</th>
                            <th>Rujukan Rumah Sakit</th>
                            <th>Saksi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>05 Des 2024 14:30</td>
                            <td>dr. Budi Santoso (Dokter Forensik)</td>
                            <td>
                                <p class="text-primary fw-bold m-0">RSUP H. Adam Malik Medan</p>
                            </td>
                            <td>dr. Budi Santoso (Dokter Forensik)</td>
                            <td>
                                <span class="badge bg-success">Selesai</span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></button>
                                <button class="btn btn-sm"><i class="bi bi-x-circle-fill text-danger"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.rujuk-antar-rs.modal')
@endsection
