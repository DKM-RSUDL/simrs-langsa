@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('unit-pelayanan.hemodialisa.component.patient-card')
        </div>

        <div class="col-md-9">
            @include('unit-pelayanan.hemodialisa.component.navigation')

            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        {{-- Tabs --}}
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a href="#" class="nav-link active" aria-selected="true">Data Umum</a>
                            </li>
                        </ul>

                        {{-- Tab Content --}}
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active">
                                {{-- TAB 1. buatlah list disini --}}

                                <div class="row">
                                    <div class="d-flex justify-content-between align-items-center m-3">

                                        <div class="row w-100">
                                            <!-- Add Button -->
                                            <!-- Include the modal file -->
                                            <div class="col-md-2 ms-auto">
                                                <div class="d-grid gap-2">
                                                    <a href="{{ route('hemodialisa.pelayanan.data-umum.create', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                                        class="btn btn-primary">
                                                        <i class="ti-plus"></i> Tambah
                                                    </a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm table-hover">
                                            <thead class="table-primary">
                                                <tr align="middle">
                                                    <th width="100px">NO</th>
                                                    <th>TANGGAL</th>
                                                    <th>PENANGGUNGJAWAB PASIEN</th>
                                                    <th>PETUGAS</th>
                                                    <th>AKSI</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($dataUmum as $umum)
                                                    <tr>
                                                        <td align="middle">{{ $loop->iteration }}</td>
                                                        <td align="middle">
                                                            {{ date('Y-m-d H:i', strtotime($umum->created_at)) . ' WIB' }}
                                                        </td>
                                                        <td>{{ $umum->pj_nama }}</td>
                                                        <td>
                                                            {{ $umum->userCreate->karyawan->gelar_depan . ' ' . str()->title($umum->userCreate->karyawan->nama) . ' ' . $umum->userCreate->karyawan->gelar_belakang }}
                                                        </td>
                                                        <td align="middle">
                                                            <a href="{{ route('hemodialisa.pelayanan.data-umum.show', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, encrypt($umum->id)]) }}"
                                                                class="btn btn-sm btn-success">
                                                                <i class="fas fa-eye"></i>
                                                            </a>

                                                            <a href="{{ route('hemodialisa.pelayanan.data-umum.edit', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, encrypt($umum->id)]) }}"
                                                                class="btn btn-sm btn-warning mx-2">
                                                                <i class="fas fa-edit"></i>
                                                            </a>

                                                            <button type="button"
                                                                class="btn btn-sm btn-danger btn-del-data"
                                                                data-umum="{{ encrypt($umum->id) }}"
                                                                data-bs-target="#deleteModal">
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
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form
                    action="{{ route('hemodialisa.pelayanan.data-umum.delete', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                    method="post">
                    @csrf
                    @method('delete')

                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="deleteModalLabel">Hapus Data Umum</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <p>Apakah anda yakin ingin menghapus data umum pasien hd ini ?</p>

                        <input type="hidden" name="data_umum" id="data_umum">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $('.btn-del-data').click(function() {
            $this = $(this);
            let data_umum = $this.attr('data-umum');
            let target = $this.attr('data-bs-target');

            $(target).find('#data_umum').val(data_umum);
            $(target).modal('show');
        });
    </script>
@endpush
