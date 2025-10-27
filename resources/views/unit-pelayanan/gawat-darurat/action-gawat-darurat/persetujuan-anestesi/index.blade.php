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
            @include('components.navigation')
            <x-content-card>
                @include('components.page-header', [
                    'title' => 'Daftar Persetujuan Anestesi dan Sedasi',
                    'description' => 'Daftar data persetujuan anestesi dan sedasi pasien gawat darurat.',
                ])

                <div class="text-end">
                    <a href="{{ route('anestesi-sedasi.create', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
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
                                    <th>WAKTU</th>
                                    <th>YANG MENYATAKAN</th>
                                    <th>DOKTER</th>
                                    <th>AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($anestesi as $item)
                                    <tr>
                                        <td align="middle">{{ $loop->iteration }}</td>
                                        <td>
                                            {{ date('d M Y', strtotime($item->tanggal)) . ' ' . date('H:i', strtotime($item->jam)) }}
                                            WIB
                                        </td>
                                        <td>{{ $item->keluarga_nama }}</td>
                                        <td>{{ $item->dokter->nama_lengkap }}</td>
                                        <td>
                                            <x-table-action>
                                                <a href="{{ route('anestesi-sedasi.pdf', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, encrypt($item->id)]) }}"
                                                    class="btn btn-sm btn-primary" target="_blank">
                                                    <i class="fa fa-print"></i>
                                                </a>
                                                <a href="{{ route('anestesi-sedasi.show', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, encrypt($item->id)]) }}"
                                                    class="btn btn-sm btn-success">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('anestesi-sedasi.edit', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, encrypt($item->id)]) }}"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <button class="btn btn-sm btn-danger btn-delete"
                                                    data-bs-target="#deleteModal" data-anestesi="{{ encrypt($item->id) }}">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </x-table-action>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </x-content-card>
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
                    action="{{ route('anestesi-sedasi.delete', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}"
                    method="post">
                    @csrf
                    @method('delete')

                    <div class="modal-body">
                        <input type="hidden" id="id_anestesi" name="id_anestesi">
                        <p>Apakah anda yakin ingin menghapus data persetujuan anestesi dan sedasi ? data yang telah
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
            let id = $this.attr('data-anestesi');
            let target = $this.attr('data-bs-target');

            $(target).find('#id_anestesi').val(id);
            $(target).modal('show');
        });
    </script>
@endpush
