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
                                <a href="#" class="nav-link active" aria-selected="true">Intake Output Cairan</a>
                            </li>
                        </ul>

                        {{-- Tab Content --}}
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active">
                                {{-- TAB 1. buatlah list disini --}}

                                <div class="d-flex justify-content-end mb-3">
                                    <a href="{{ route('rawat-inap.intake-cairan.pdf', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                        class="btn btn-success me-2" target="_blank">
                                        <i class="fa fa-print"></i> Print
                                    </a>

                                    <a href="{{ route('rawat-inap.intake-cairan.create', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                        class="btn btn-primary">
                                        <i class="ti-plus"></i> Tambah
                                    </a>
                                </div>

                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm table-hover">
                                            <thead class="table-primary">
                                                <tr align="middle">
                                                    <th width="100px">No</th>
                                                    <th>Tanggal</th>
                                                    <th>Petugas</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($intakeData as $intake)
                                                    <tr>
                                                        <td align="middle">{{ $loop->iteration }}</td>
                                                        <td align="middle">{{ date('d M Y', strtotime($intake->tanggal)) }}
                                                        </td>
                                                        <td>{{ $intake->userCreate->karyawan->gelar_depan . ' ' . str()->title($intake->userCreate->karyawan->nama) . ' ' . $intake->userCreate->karyawan->gelar_belakang }}
                                                        </td>
                                                        <td align="middle">
                                                            <a href="{{ route('rawat-inap.intake-cairan.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, encrypt($intake->id)]) }}"
                                                                class="btn btn-sm btn-success ms-1">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                            <a href="{{ route('rawat-inap.intake-cairan.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, encrypt($intake->id)]) }}"
                                                                class="btn btn-sm btn-warning mx-1">
                                                                <i class="fa fa-pencil"></i>
                                                            </a>
                                                            <button class="btn btn-sm btn-danger btn-delete"
                                                                data-bs-target="#deleteModal"
                                                                data-intake="{{ encrypt($intake->id) }}">
                                                                <i class="fa fa-trash"></i>
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


    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteModalLabel">Hapus Intake Output</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form
                    action="{{ route('rawat-inap.intake-cairan.delete', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}"
                    method="post">
                    @csrf
                    @method('delete')

                    <div class="modal-body">
                        <input type="hidden" id="id_intake" name="id_intake">
                        <p>Apakah anda yakin ingin menghapus data intake output cairan ? data yang telah dihapus tidak dapat
                            dikembalikan</p>
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
        $('.btn-delete').click(function() {
            let $this = $(this);
            let id = $this.attr('data-intake');
            let target = $this.attr('data-bs-target');

            $(target).find('#id_intake').val(id);
            $(target).modal('show');

        });
    </script>
@endpush
