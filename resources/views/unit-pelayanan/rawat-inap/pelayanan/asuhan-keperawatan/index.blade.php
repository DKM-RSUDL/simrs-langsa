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
                    <div
                        class="d-flex flex-column flex-md-row justify-content-between align-items-stretch align-items-md-center my-3 gap-2">

                        <!-- GRUP FILTER (KIRI) -->
                        <div class="d-flex flex-wrap align-items-center gap-2 flex-grow-1">

                            <!-- Select Option -->
                            <div class="col-auto">
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
                            <div class="col-auto">
                                <input type="date" name="start_date" id="start_date" class="form-control"
                                    placeholder="Dari Tanggal">
                            </div>

                            <!-- End Date -->
                            <div class="col-auto">
                                <input type="date" name="end_date" id="end_date" class="form-control"
                                    placeholder="S.d Tanggal">
                            </div>

                            <!-- Tombol Filter -->
                            <div class="col-auto">
                                <a href="#" class="btn btn-secondary rounded-3" id="filterButton">
                                    <i class="bi bi-funnel-fill"></i>
                                </a>
                            </div>

                            <!-- Search -->
                                <form method="GET" action="">
                                    <div class="input-group" style="margin-bottom: 0px;">
                                        <input type="text" name="search" class="form-control" placeholder="Cari..."
                                            aria-label="Cari" value="">
                                        <button type="submit" class="btn btn-primary">Cari</button>
                                    </div>
                                </form>

                        </div>

                        <!-- GRUP AKSI (KANAN) -->
                        <div class="d-flex justify-content-start justify-content-md-end">
                            <a href="{{ route('rawat-inap.asuhan-keperawatan.create', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                class="btn btn-primary d-inline-flex align-items-center gap-2">
                                <i class="bi bi-plus-square"></i>
                                <span>Tambah</span>
                            </a>
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
                                @foreach ($asuhan as $item)
                                    <tr>
                                        <td>{{ date('d M Y', strtotime($item->tgl_implementasi)) }}</td>
                                        <td>
                                            @if ($item->waktu == 1)
                                                Pagi
                                            @endif

                                            @if ($item->waktu == 2)
                                                Sore
                                            @endif

                                            @if ($item->waktu == 3)
                                                Malam
                                            @endif
                                        </td>
                                        <td>{{ str()->title($item->userCreate->name) }}</td>
                                        <td class="text-center" width="150">
                                            <a href="{{ route('rawat-inap.asuhan-keperawatan.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="ti-eye"></i>
                                            </a>
                                            <a href="{{ route('rawat-inap.asuhan-keperawatan.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="ti-pencil"></i>
                                            </a>
                                            <button class="btn btn-sm btn-danger btn-delete"
                                                data-asuhan="{{ encrypt($item->id) }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('js')
    <script>
        $('.btn-delete').click(function(e) {
            let $this = $(this);
            let asuhan = $this.attr('data-asuhan');


            Swal.fire({
                title: "Anda yakin ingin menghapus?",
                text: "Data yang dihapus tidak dapat dikembalikan kembali !",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "post",
                        url: "{{ route('rawat-inap.asuhan-keperawatan.destroy', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            _method: "delete",
                            asuhan: asuhan
                        },
                        dataType: "json",
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
                            let status = res.status;
                            let msg = res.message;
                            let data = res.data;

                            if (status == 'error') {
                                Swal.fire({
                                    title: "Gagal!",
                                    text: msg,
                                    icon: "error",
                                    allowOutsideClick: false,
                                });

                                return false;
                            }

                            Swal.fire({
                                title: "Berhasil!",
                                text: "Data asuhan berhasil dihapus !",
                                icon: "success",
                                allowOutsideClick: false,
                            });

                            location.reload();
                        },
                        error: function() {
                            Swal.fire({
                                title: "Gagal!",
                                text: "Internal Server Error",
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
