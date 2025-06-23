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
                                                <a href="{{ route('rawat-inap.asesmen-pra-anestesi.create', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
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
                                                @forelse($asesmenPraAnestesi as $index => $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ date('d-m-Y', strtotime($item->tanggal)) }}</td>
                                                        <td>{{ str()->title($item->userCreate->name) }}</td>
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                <a href="{{ route('rawat-inap.asesmen-pra-anestesi.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                                    class="btn btn-info btn-sm ms-2" title="Detail">
                                                                    <i class="ti-eye"></i>
                                                                </a>                                                                
                                                                <a href="{{ route('rawat-inap.asesmen-pra-anestesi.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                                    class="btn btn-warning btn-sm ms-2" title="Edit">
                                                                    <i class="ti-pencil"></i>
                                                                </a>

                                                                <form
                                                                    action="{{ route('rawat-inap.asesmen-pra-anestesi.destroy', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                                    method="POST" class="delete-form ms-2"
                                                                    style="display: inline;">
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
                                                        <td colspan="8" class="text-center">Tidak ada data Asesmen Pra Anestesi & Sedasi</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>

                                        <!-- Pagination -->
                                        <div class="d-flex justify-content-end">
                                            {{ $asesmenPraAnestesi->links() }}
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
                        text: 'Data Asesmen Pra Anestesi ini akan dihapus secara permanen!',
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
