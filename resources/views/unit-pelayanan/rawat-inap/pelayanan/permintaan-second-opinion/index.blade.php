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
                                <input type="date" name="end_date" id="end_date" class="form-control"
                                    placeholder="S.d Tanggal">
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
                                <a href="{{ route('rawat-inap.permintaan-second-opinion.create', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                    class="btn btn-primary">
                                    <i class="bi bi-plus-square"></i> Tambah
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-sm table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th>NO</th>
                                    <th>TANGGAL</th>
                                    <th>NAMA PENERIMA INFORMASI</th>
                                    <th>PETUGAS</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permintaanSecondOpinion as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ date('d M Y', strtotime($item->tanggal)) }}</td>
                                        <td>{{ $item->nama_penerima ?? '-' }}</td>
                                        <td>{{ str()->title($item->userCreate->name) }}</td>
                                        <td>
                                            <a href="{{ route('rawat-inap.permintaan-second-opinion.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                class="mb-2 btn btn-sm btn-info">
                                                <i class="ti-eye"></i>
                                            </a>
                                            <a href="{{ route('rawat-inap.permintaan-second-opinion.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
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
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-end mt-3">
                        {{ $permintaanSecondOpinion->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

// JavaScript yang sudah diperbaiki
@push('js')
    <script>
        $('.btn-delete').click(function(e) {
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
                    let destroyUrl = "{{ route('rawat-inap.permintaan-second-opinion.destroy', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, ':id']) }}";
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
                        beforeSend: function() {
                            Swal.fire({
                                title: 'Sedang Memproses',
                                html: 'Mohon tunggu sebentar...',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });
                        },
                        success: function(res) {
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
                        error: function(xhr, status, error) {
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
