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
            @include('components.navigation')

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
                                        placeholder="Cari nama dokter" aria-label="Cari" value="{{ request('search') }}"
                                        aria-describedby="basic-addon1">
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-2">
                            <a href="{{ route('rawat-jalan.edukasi.create', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
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
                                <th>Tanggal Edukasi</th>
                                <th>Petugas</th>
                                <th>Kebutuhan Penerjemah</th>
                                <th>Penerjemah Bahasa</th>
                                <th>Tipe Pembelajaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($edukasi as $index => $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ date('d-m-Y H:i', strtotime($item->waktu_edukasi)) }}</td>
                                    <td>{{ $item->userCreate->karyawan->gelar_depan .
                                        ' ' .
                                        str()->title($item->userCreate->karyawan->nama) .
                                        ' ' .
                                        $item->userCreate->karyawan->gelar_belakang ??
                                        '-' }}
                                    </td>
                                    <td>
                                        @if (isset($item->edukasiPasien))
                                            {{ $item->edukasiPasien->kebutuhan_penerjemah == 1 ? 'Ya' : 'Tidak' }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if (isset($item->edukasiPasien) && $item->edukasiPasien->penerjemah_bahasa)
                                            {{ $item->edukasiPasien->penerjemah_bahasa }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if (isset($item->edukasiPasien) && isset($item->edukasiPasien->tipe_pembelajaran_array))
                                            {{ implode(', ', $item->edukasiPasien->tipe_pembelajaran_array) }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('rawat-jalan.edukasi.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                class="btn btn-info btn-sm" title="Detail">
                                                <i class="ti-eye"></i>
                                            </a>
                                            <a href="{{ route('rawat-jalan.edukasi.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}" class="btn btn-warning btn-sm ms-2" title="Edit">
                                                <i class="ti-pencil"></i>
                                            </a>
                                            <form action="{{ route('rawat-jalan.edukasi.destroy', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                method="POST" class="delete-form" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm ms-2" title="Hapus">
                                                    <i class="ti-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Tidak ada data edukasi</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $edukasi->links() }}
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
                        text: 'Data edukasi ini akan dihapus secara permanen!',
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
