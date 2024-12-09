@extends('layouts.administrator.master')

@section('content')
    <div class="d-flex justify-content-center">
        <div class="w-100 h-100">
            <div class="d-flex justify-content-between m-3">
                <div class="row">
                    <!-- Select Option -->
                    <div class="col-md-2">
                        <select class="form-select" id="SelectOption" aria-label="Pilih...">
                            <option value="semua" selected>Semua Episode</option>
                            <option value="option1">Episode Sekarang</option>
                            <option value="option2">1 Bulan</option>
                            <option value="option3">3 Bulan</option>
                            <option value="option4">6 Bulan</option>
                            <option value="option5">9 Bulan</option>
                        </select>
                    </div>

                    <!-- Start Date -->
                    <div class="col-md-2">
                        <input type="date" name="start_date" id="start_date" class="form-control"
                            placeholder="Dari Tanggal">
                    </div>

                    <!-- End Date -->
                    <div class="col-md-2">
                        <input type="date" name="end_date" id="end_date" class="form-control" placeholder="S.d Tanggal">
                    </div>
                    <div class="col-md-1">
                        <a href="#" class="btn btn-secondary rounded-3" id="filterButton"><i
                                class="bi bi-funnel-fill"></i></a>
                    </div>

                    <!-- Search Bar -->
                    <div class="col-md-3">
                        <form method="GET" action="">

                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Cari..."
                                    aria-label="Cari" value="" aria-describedby="basic-addon1">
                                <button type="submit" class="btn btn-primary">Cari</button>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-2">
                        <a href="javascript:void(0)" class="btn btn-primary" id="btn-asuhan-create">
                            <i class="bi bi-plus-square"></i> Tambah
                        </a>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-sm table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Petugas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>04 Des 2024</td>
                            <td>Pagi</td>
                            <td>Haris Yunanda</td>
                            <td>
                                <a href="javascript:void(0)" id="btn-asuhan-show" class="mb-2 btn btn-sm btn-info">
                                    <i class="ti-eye"></i>
                                </a>
                                <a href="javascript:void(0)" id="btn-asuhan-edit" class="mb-2 btn btn-sm btn-warning">
                                    <i class="ti-pencil"></i>
                                </a>
                                <a href="javascript:void(0)" class="mb-2 btn btn-sm btn-danger btn-delete">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>05 Des 2024</td>
                            <td>Sore</td>
                            <td>Nasruddin</td>
                            <td>
                                <a href="javascript:void(0)" id="btn-asuhan-show" class="mb-2 btn btn-sm btn-info">
                                    <i class="ti-eye"></i>
                                </a>
                                <a href="javascript:void(0)" id="btn-asuhan-edit" class="mb-2 btn btn-sm btn-warning">
                                    <i class="ti-pencil"></i>
                                </a>
                                <a href="javascript:void(0)" class="mb-2 btn btn-sm btn-danger btn-delete">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>06 Des 2024</td>
                            <td>Malam</td>
                            <td>Rizaldi</td>
                            <td>
                                <a href="javascript:void(0)" id="btn-asuhan-show" class="mb-2 btn btn-sm btn-info">
                                    <i class="ti-eye"></i>
                                </a>
                                <a href="javascript:void(0)" id="btn-asuhan-edit" class="mb-2 btn btn-sm btn-warning">
                                    <i class="ti-pencil"></i>
                                </a>
                                <a href="javascript:void(0)" class="mb-2 btn btn-sm btn-danger btn-delete">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection


@include('unit-pelayanan.rawat-inap.pelayanan.asuhan-keperawatan.modal-asuhan-create')
@include('unit-pelayanan.rawat-inap.pelayanan.asuhan-keperawatan.modal-show')
@include('unit-pelayanan.rawat-inap.pelayanan.asuhan-keperawatan.modal-edit')
@include('unit-pelayanan.rawat-inap.pelayanan.asuhan-keperawatan.modal-delete')
