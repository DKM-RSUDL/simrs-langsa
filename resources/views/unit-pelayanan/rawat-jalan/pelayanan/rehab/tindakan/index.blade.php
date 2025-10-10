@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .select2-container {
            z-index: 9999;
        }

        .modal-dialog {
            z-index: 1050 !important;
        }

        .modal-content {
            overflow: visible !important;
        }

        .select2-dropdown {
            z-index: 99999 !important;
        }

        /* Menghilangkan elemen Select2 yang tidak diinginkan */
        .select2-container+.select2-container {
            display: none;
        }

        /* Menyamakan tampilan Select2 dengan Bootstrap */
        .select2-container--default .select2-selection--single {
            height: calc(1.5em + 0.75rem + 2px);
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 1.5;
            padding-left: 0;
            padding-right: 0;
            color: #495057;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: calc(1.5em + 0.75rem);
            position: absolute;
            top: 1px;
            right: 1px;
            width: 20px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border-color: #6c757d transparent transparent transparent;
        }

        .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b {
            border-color: transparent transparent #6c757d transparent;
        }

        .select2-container--default .select2-dropdown {
            border-color: #80bdff;
            border-radius: 0.25rem;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #007bff;
        }

        /* Fokus */
        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            @include('components.navigation-rajal')

            <div class="row">
                <div class="d-flex justify-content-between align-items-center my-3">

                    <div class="row w-100">
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

                        <!-- Button Filter -->
                        <div class="col-md-2">
                            <button id="filterButton" class="btn btn-secondary rounded-3"><i
                                    class="bi bi-funnel-fill"></i></button>
                        </div>

                        <!-- Add Button -->
                        <!-- Include the modal file -->
                        <div class="col-md-4 d-flex justify-content-end">
                            @if (count($tindakan) < 1)
                                <div class="d-flex gap-2">
                                    <a href="{{ route('rawat-jalan.tindakan-rehab-medik.create', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}" class="btn btn-primary">
                                        <i class="ti-plus"></i> Tambah
                                    </a>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-sm table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th>Tanggal</th>
                                <th>PPA</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tindakan as $tdk)
                                <tr>
                                    <td>
                                        {{ date('d M Y', strtotime($tdk->tgl_tindakan)) .' '. date('H:i', strtotime($tdk->jam_tindakan)) }}
                                        WIB
                                    </td>
                                    <td>{{ $tdk->karyawan->gelar_depan .' '. str()->title($tdk->karyawan->nama) .' '. $tdk->karyawan->gelar_belakang }}</td>
                                    <td>
                                        <a href="{{ route('rawat-jalan.tindakan-rehab-medik.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $tdk->id]) }}" class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('rawat-jalan.tindakan-rehab-medik.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $tdk->id]) }}" class="btn btn-warning btn-sm"><i class="fas fa-pencil"></i></a>
                                        <button class="btn btn-sm btn-danger btn-delete-tindakan" data-tindakan="{{ encrypt($tdk->id) }}">
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
    </div>
@endsection



@push('js')
    <script>
        $('.btn-delete-tindakan').click(function(e) {
            let $this = $(this);
            let tindakan = $this.attr('data-tindakan');


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
                        url: "{{ route('rawat-jalan.tindakan-rehab-medik.destroy', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            _method: "delete",
                            tindakan: tindakan
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
                        success: function (res) {
                            let status = res.status;
                            let msg = res.message;
                            let data = res.data;

                            if(status == 'error') {
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
                                text: "Data Tindakan berhasil dihapus !",
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
