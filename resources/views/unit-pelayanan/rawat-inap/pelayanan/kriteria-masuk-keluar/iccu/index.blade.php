@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
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
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a href="?tab=iccu" class="nav-link active" aria-selected="true">
                                    Masuk/Keluar
                                </a>
                            </li>
                            {{-- <li class="nav-item" role="presentation">
                                <a href="?tab=monitoring" class="nav-link" aria-selected="true">
                                    Monitoring
                                </a>
                            </li> --}}
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
                                                <a href="{{ route('rawat-inap.kriteria-masuk-keluar.iccu.create', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
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
                                                    <th>Tanggal</th>
                                                    <th>Dokter Jantung</th>
                                                    <th>Petugas</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($dataIccu as $index => $item)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ date('d M Y', strtotime($item->iccu_tanggal)) }}
                                                            {{ date('H:i', strtotime($item->iccu_jam)) }}
                                                        </td>
                                                        <td>{{ $item->dokter->nama_lengkap ?? '-' }}</td>
                                                        <td>{{ str()->title($item->userCreate->name) }}</td>
                                                        <td>
                                                            <a href="{{ route('rawat-inap.kriteria-masuk-keluar.iccu.print-pdf', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                                class="mb-2 btn btn-secondary btn-sm" target="_blank">
                                                                <i class="bi bi-printer"></i>
                                                            </a>
                                                            <a href="{{ route('rawat-inap.kriteria-masuk-keluar.iccu.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                                class="mb-2 btn btn-sm btn-info">
                                                                <i class="ti-eye"></i>
                                                            </a>
                                                            <a href="{{ route('rawat-inap.kriteria-masuk-keluar.iccu.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                                class="mb-2 btn btn-sm btn-warning">
                                                                <i class="ti-pencil"></i>
                                                            </a>
                                                            <button class="mb-2 btn btn-sm btn-danger btn-delete"
                                                                data-id="{{ $item->id }}">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        <!-- Pagination -->
                                        <div class="d-flex justify-content-end">
                                            {{ $dataIccu->links() }}
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
        $('.btn-delete').click(function (e) {
            e.preventDefault();
            let $this = $(this);
            let id = $this.data('id');

            Swal.fire({
                title: "Anda yakin ingin menghapus?",
                text: "Data yang dihapus tidak dapat dikembalikan kembali!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    let destroyUrl = "{{ route('rawat-inap.kriteria-masuk-keluar.iccu.destroy', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, ':id']) }}";
                    destroyUrl = destroyUrl.replace(':id', id);

                    $.ajax({
                        type: "POST",
                        url: destroyUrl,
                        data: {
                            _token: "{{ csrf_token() }}",
                            _method: "DELETE"
                        },
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest' // Ini penting untuk mendeteksi AJAX request
                        },
                        beforeSend: function () {
                            Swal.fire({
                                title: 'Sedang Memproses',
                                html: 'Mohon tunggu sebentar...',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });
                        },
                        success: function (res) {
                            // Jika menggunakan controller dengan JSON response
                            if (res.status === 'success') {
                                Swal.fire({
                                    title: "Berhasil!",
                                    text: res.message,
                                    icon: "success",
                                    allowOutsideClick: false,
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: "Gagal!",
                                    text: res.message || "Terjadi kesalahan",
                                    icon: "error",
                                    allowOutsideClick: false,
                                });
                            }
                        },
                        error: function (xhr, status, error) {
                            // Handle both JSON and HTML error responses
                            let errorMessage = "Terjadi kesalahan";

                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            } else if (xhr.status === 404) {
                                errorMessage = "Data tidak ditemukan";
                            } else if (xhr.status === 500) {
                                errorMessage = "Internal Server Error";
                            }

                            Swal.fire({
                                title: "Gagal!",
                                text: errorMessage,
                                icon: "error",
                                allowOutsideClick: false,
                            });
                        }
                    });
                }
            });
        });
    </script>
@endpush
