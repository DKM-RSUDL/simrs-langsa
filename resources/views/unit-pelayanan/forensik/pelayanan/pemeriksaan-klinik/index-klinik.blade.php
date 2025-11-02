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
            @include('components.navigation-forensik')
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
                        <a href="{{ route('forensik.unit.pelayanan.pemeriksaan-klinik.create', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                            class="btn btn-primary">
                            <i class="bi bi-plus"></i> Tambah
                        </a>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-primary">
                        <tr align="middle">
                            <th>Tanggal & Jam</th>
                            <th>Petugas</th>
                            <th>Asal Rujukan</th>
                            <th>Diagnosos</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pemeriksaan as $item)
                            <tr>
                                <td align="middle">
                                    {{ date('d M Y', strtotime($item->tgl_pemeriksaan)) . ' ' . date('H:i', strtotime($item->jam_pemeriksaan)) }}
                                </td>
                                <td>{{ str()->title($item->userCreate->name) }}</td>
                                <td>{{ $item->asal_rujukan }}</td>
                                <td>{{ $item->diagnosos }}</td>
                                <td align="middle">
                                    <a href="{{ route('forensik.unit.pelayanan.pemeriksaan-klinik.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                        class="btn btn-sm btn-success"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('forensik.unit.pelayanan.pemeriksaan-klinik.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                        class="btn btn-sm btn-warning mx-2"><i class="bi bi-pencil-square"></i></a>
                                    <button type="button" class="btn btn-sm btn-danger btn-del-pemeriksaan"
                                        data-pemeriksaan="{{ encrypt($item->id) }}" data-bs-target="#deleteModal">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $('.btn-del-pemeriksaan').click(function(e) {
            let $this = $(this);
            let pemeriksaan = $this.attr('data-pemeriksaan');


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
                        url: "{{ route('forensik.unit.pelayanan.pemeriksaan-klinik.destroy', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            _method: "delete",
                            pemeriksaan: pemeriksaan
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
                                text: "Data pemeriksaan berhasil dihapus !",
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
