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
                            <option value="option1">Visum et Repertum</option>
                            <option value="option2">Pemeriksaan Luka</option>
                            <option value="option3">Pemeriksaan Forensik</option>
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
                        <a href="{{ route('forensik.unit.pelayanan.create-patologi', [
                            'kd_unit' => $kd_unit,
                            'kd_pasien' => $kd_pasien,
                            'tgl_masuk' => $tgl_masuk,
                            'urut_masuk' => $urut_masuk,
                        ]) }}"
                            class="btn btn-primary">
                            <i class="bi bi-plus"></i> Patologi
                        </a>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>Tanggal & Jam</th>
                            <th>Petugas</th>
                            <th>Jenis Pelayanan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>05 Des 2024 14:30</td>
                            <td>dr. Budi Santoso (Dokter Forensik)</td>
                            <td>
                                <p class="text-primary fw-bold m-0">Visum et Repertum</p>
                                <p class="m-0">Pemeriksaan Luka Akibat Kekerasan Tumpul</p>
                            </td>
                            <td>
                                <span class="badge bg-success">Selesai</span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></button>
                                <button class="btn btn-sm"><i class="bi bi-x-circle-fill text-danger"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>04 Des 2024 09:15</td>
                            <td>Ns. Siti Aminah (Perawat Forensik)</td>
                            <td>
                                <p class="text-primary fw-bold m-0">Pemeriksaan Forensik</p>
                                <p class="m-0">Pengambilan Sampel DNA</p>
                            </td>
                            <td>
                                <span class="badge bg-warning text-dark">Dalam Proses</span>
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
@endsection
