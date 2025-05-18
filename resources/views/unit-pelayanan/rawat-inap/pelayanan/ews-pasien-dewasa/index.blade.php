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
            @include('components.navigation-ranap')

            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        {{-- Tabs --}}
                        <ul class="nav nav-tabs" id="ewsTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a href="{{ request()->fullUrlWithQuery(['tab' => 'dewasa']) }}"
                                    class="nav-link {{ ($activeTab ?? 'dewasa') == 'dewasa' ? 'active' : '' }}"
                                    aria-selected="{{ ($activeTab ?? 'dewasa') == 'dewasa' ? 'true' : 'false' }}">
                                    <i class="bi bi-heart-pulse-fill me-2"></i>
                                    Dewasa
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="{{ request()->fullUrlWithQuery(['tab' => 'anak']) }}"
                                    class="nav-link {{ ($activeTab ?? 'dewasa') == 'anak' ? 'active' : '' }}"
                                    aria-selected="{{ ($activeTab ?? 'dewasa') == 'anak' ? 'true' : 'false' }}">
                                    <i class="bi bi-person-heart me-2"></i>
                                    Anak-Anak
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="{{ request()->fullUrlWithQuery(['tab' => 'obstetri']) }}"
                                    class="nav-link {{ ($activeTab ?? 'dewasa') == 'obstetri' ? 'active' : '' }}"
                                    aria-selected="{{ ($activeTab ?? 'dewasa') == 'obstetri' ? 'true' : 'false' }}">
                                    <i class="bi bi-person-check me-2"></i>
                                    Obstetri
                                </a>
                            </li>
                        </ul>

                        {{-- Tab Content --}}
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active">
                                {{-- TAB 1. buatlah list disini --}}
                                <div class="row">
                                    <div class="d-flex justify-content-between m-3">
                                        <div class="row">
                                            <!-- Start Date -->
                                            <div class="col-md-2">
                                                <input type="date" name="start_date" id="start_date" class="form-control"
                                                    placeholder="Dari Tanggal">
                                            </div>

                                            <!-- End Date -->
                                            <div class="col-md-2">
                                                <input type="date" name="end_date" id="end_date" class="form-control"
                                                    placeholder="S.d Tanggal">
                                            </div>
                                            <div class="col-md-2">
                                                <a href="#" class="btn btn-secondary rounded-3" id="filterButton"><i
                                                        class="bi bi-funnel-fill"></i></a>
                                            </div>

                                            <!-- Search Bar -->
                                            <div class="col-md-4">
                                                <form method="GET" action="#">

                                                    <div class="input-group">
                                                        <input type="text" name="search" class="form-control"
                                                            placeholder="Cari nama dokter" aria-label="Cari"
                                                            value="{{ request('search') }}" aria-describedby="basic-addon1">
                                                        <button type="submit" class="btn btn-primary">Cari</button>
                                                    </div>
                                                </form>
                                            </div>

                                            <div class="col-md-2">
                                                <a href="{{ route('rawat-inap.ews-pasien-dewasa.create', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                                    class="btn btn-primary">
                                                    <i class="ti-plus"></i> Tambah
                                                </a>
                                            </div>

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
                                                @forelse($ewsPasienDewasa as $index => $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ date('d-m-Y', strtotime($item->tanggal)) }}</td>
                                                        <td>{{ str()->title($item->userCreate->name) }}</td>
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                <a href="{{ route('rawat-inap.ews-pasien-dewasa.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                                    class="btn btn-info btn-sm" title="Detail">
                                                                    <i class="ti-eye"></i>
                                                                </a>
                                                                @if ($item->status == 0)
                                                                    <a href="{{ route('rawat-inap.ews-pasien-dewasa.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                                        class="btn btn-warning btn-sm ms-2" title="Edit">
                                                                        <i class="ti-pencil"></i>
                                                                    </a>
                                                                @endif

                                                                <form
                                                                    action="{{ route('rawat-inap.ews-pasien-dewasa.destroy', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                                    method="POST" class="delete-form ms-2" style="display: inline;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                                        title="Hapus">
                                                                        <i class="ti-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="8" class="text-center">Tidak ada data Permintaan Darah</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>

                                        <!-- Pagination -->
                                        <div class="d-flex justify-content-end">
                                            {{ $ewsPasienDewasa->links() }}
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

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Attach SweetAlert to all delete forms
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: 'Data EWS Pasien Dewasa ini akan dihapus secara permanen!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush
