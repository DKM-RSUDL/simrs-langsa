@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .card {
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .btn-sm {
            padding: 5px 10px;
        }
        .input-group {
            max-width: 300px;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title mb-0">Daftar Surat Kematian Pasien</h5>
                        <a href="{{ route('surat-kematian.create', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}" class="btn btn-primary">
                            <i class="ti-plus"></i> Tambah Surat Kematian
                        </a>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <input type="date" name="start_date" id="start_date" class="form-control" placeholder="Dari Tanggal">
                        </div>
                        <div class="col-md-3">
                            <input type="date" name="end_date" id="end_date" class="form-control" placeholder="S.d Tanggal">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-secondary rounded-3" id="filterButton">
                                <i class="bi bi-funnel-fill"></i> Filter
                            </button>
                        </div>
                        <div class="col-md-4">
                            <form method="GET" action="#">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Cari nama pasien" aria-label="Cari" value="">
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-sm table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Kematian</th>
                                    <th>Nama Pasien</th>
                                    <th>Nomor Surat</th>
                                    <th>Penyebab Kematian</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>2025-05-01</td>
                                    <td>John Doe</td>
                                    <td>SKM/2025/001</td>
                                    <td>Gagal Jantung</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="#" class="btn btn-info btn-sm" title="Detail">
                                                <i class="ti-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-warning btn-sm ms-2" title="Edit">
                                                <i class="ti-pencil"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>2025-05-03</td>
                                    <td>Jane Smith</td>
                                    <td>SKM/2025/002</td>
                                    <td>Stroke</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="#" class="btn btn-info btn-sm" title="Detail">
                                                <i class="ti-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-warning btn-sm ms-2" title="Edit">
                                                <i class="ti-pencil"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>2025-05-05</td>
                                    <td>Michael Tan</td>
                                    <td>SKM/2025/003</td>
                                    <td>Infeksi Paru</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="#" class="btn btn-info btn-sm" title="Detail">
                                                <i class="ti-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-warning btn-sm ms-2" title="Edit">
                                                <i class="ti-pencil"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection