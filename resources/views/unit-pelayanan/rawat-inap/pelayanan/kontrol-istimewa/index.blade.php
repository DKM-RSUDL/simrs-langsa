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
                                <a href="#" class="nav-link active" aria-selected="true">Kontrol Istimewa</a>
                            </li>
                        </ul>

                        {{-- Tab Content --}}
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active">
                                {{-- TAB 1. buatlah list disini --}}

                                <div class="d-flex justify-content-end mb-3">
                                    <button class="btn btn-info me-3" data-bs-toggle="modal" data-bs-target="#printModal">
                                        <i class="fa fa-print"></i>
                                        Print
                                    </button>

                                    <a href="{{ route('rawat-inap.kontrol-istimewa.create', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                        class="btn btn-primary">
                                        <i class="ti-plus"></i> Tambah
                                    </a>
                                </div>

                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm table-hover">
                                            <thead class="table-primary">
                                                <tr align="middle" style="vertical-align: middle;">
                                                    <th width="100px" rowspan="2">NO</th>
                                                    <th rowspan="2">WAKTU</th>
                                                    <th rowspan="2">PETUGAS</th>
                                                    <th rowspan="2">NADI</th>
                                                    <th rowspan="2">NAFAS</th>
                                                    <th colspan="2">TEK. DARAH</th>
                                                    <th rowspan="2">AKSI</th>
                                                </tr>
                                                <tr align="middle">
                                                    <th>Sistole</th>
                                                    <th>Diastole</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($kontrol as $item)
                                                    <tr>
                                                        <td align="middle">{{ $loop->iteration }}</td>
                                                        <td>
                                                            {{ date('d M Y', strtotime($item->tanggal)) . ' ' . date('H:i', strtotime($item->jam)) }}
                                                            WIB
                                                        </td>
                                                        <td>{{ $item->userCreate->karyawan->gelar_depan . ' ' . str()->title($item->userCreate->karyawan->nama) . ' ' . $item->userCreate->karyawan->gelar_belakang }}
                                                        </td>
                                                        <td>{{ $item->nadi }}</td>
                                                        <td>{{ $item->nafas }}</td>
                                                        <td>{{ $item->sistole }}</td>
                                                        <td>{{ $item->diastole }}</td>
                                                        <td align="middle">
                                                            <a href="{{ route('rawat-inap.kontrol-istimewa.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, encrypt($item->id)]) }}"
                                                                class="btn btn-sm btn-warning mx-1">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            <button class="btn btn-sm btn-danger btn-delete"
                                                                data-bs-target="#deleteModal"
                                                                data-kontrol="{{ encrypt($item->id) }}">
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
                    <h1 class="modal-title fs-5" id="deleteModalLabel">Hapus Persetujuan Anestesi dan Sedasi</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form
                    action="{{ route('rawat-inap.kontrol-istimewa.delete', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}"
                    method="post">
                    @csrf
                    @method('delete')

                    <div class="modal-body">
                        <input type="hidden" id="id_kontrol" name="id_kontrol">
                        <p>Apakah anda yakin ingin menghapus data kontrol istimewa ? data yang telah
                            dihapus tidak dapat
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


    <!-- Modal -->
    <div class="modal fade" id="printModal" tabindex="-1" aria-labelledby="printModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="printModalLabel">Print Kontrol Istimewa</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form
                    action="{{ route('rawat-inap.kontrol-istimewa.pdf', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}"
                    method="post">
                    @csrf

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="tgl_print">Tanggal</label>
                            <input type="text" name="tgl_print" id="tgl_print" class="form-control date" required
                                readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Print</button>
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
            let id = $this.attr('data-kontrol');
            let target = $this.attr('data-bs-target');

            $(target).find('#id_kontrol').val(id);
            $(target).modal('show');
        });
    </script>
@endpush
