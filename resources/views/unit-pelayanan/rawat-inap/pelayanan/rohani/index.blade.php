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
                                <a href="#" class="nav-link active" aria-selected="true">Rohani</a>
                            </li>
                        </ul>

                        {{-- Tab Content --}}
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active">
                                {{-- TAB 1. buatlah list disini --}}

                                <div class="text-end mb-3">
                                    <a href="{{ route('rawat-inap.rohani.create', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                        class="btn btn-primary">
                                        <i class="ti-plus"></i> Tambah
                                    </a>
                                </div>

                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm table-hover">
                                            <thead class="table-primary">
                                                <tr align="middle">
                                                    <th width="100px">NO</th>
                                                    <th>TANGGAL</th>
                                                    <th>NAMA PEMOHON</th>
                                                    <th>PENYETUJU</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($rohani as $item)
                                                    <tr>
                                                        <td align="middle">{{ $loop->iteration }}</td>
                                                        <td>
                                                            {{ date('d M Y', strtotime($item->tanggal)) }}
                                                        </td>
                                                        <td style="max-width: 300px;">{{ $item->keluarga_nama }}</td>
                                                        <td>
                                                            {{ $item->penyetuju->gelar_depan . ' ' . str()->title($item->penyetuju->nama) . ' ' . $item->penyetuju->gelar_belakang }}
                                                        </td>
                                                        <td align="middle">
                                                            <a href="{{ route('rawat-inap.rohani.pdf', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, encrypt($item->id)]) }}"
                                                                class="btn btn-sm btn-primary" target="_blank">
                                                                <i class="fa fa-print"></i>
                                                            </a>
                                                            <a href="{{ route('rawat-inap.rohani.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, encrypt($item->id)]) }}"
                                                                class="btn btn-sm btn-success ms-1">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                            <a href="{{ route('rawat-inap.rohani.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, encrypt($item->id)]) }}"
                                                                class="btn btn-sm btn-warning mx-1">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            <button class="btn btn-sm btn-danger btn-delete"
                                                                data-bs-target="#deleteModal"
                                                                data-rohani="{{ encrypt($item->id) }}">
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
                    <h1 class="modal-title fs-5" id="deleteModalLabel">Hapus Pernyataan Rohani</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form
                    action="{{ route('rawat-inap.rohani.delete', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}"
                    method="post">
                    @csrf
                    @method('delete')

                    <div class="modal-body">
                        <input type="hidden" id="id_rohani" name="id_rohani">
                        <p>Apakah anda yakin ingin menghapus data pernyataan permintaan pelayanan rohani ? data yang telah
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
@endsection

@push('js')
    <script>
        $('.btn-delete').click(function() {
            let $this = $(this);
            let id = $this.attr('data-rohani');
            let target = $this.attr('data-bs-target');

            $(target).find('#id_rohani').val(id);
            $(target).modal('show');
        });
    </script>
@endpush
