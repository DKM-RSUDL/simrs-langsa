@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>

    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <x-content-card>
                <x-button-previous />

                @include('components.page-header', [
                    'title' => 'Daftar Order Permintaan Darah',
                    'description' => 'Daftar data order permintaan darah pasien gawat darurat.',
                ])
                <div class="row">
                    <div class="col-md-10 d-flex flex-wrap flex-md-nowrap gap-2">
                        <!-- Start Date -->
                        <div>
                            <input type="date" name="start_date" id="start_date" class="form-control"
                                placeholder="Dari Tanggal">
                        </div>

                        <!-- End Date -->
                        <div>
                            <input type="date" name="end_date" id="end_date" class="form-control"
                                placeholder="S.d Tanggal">
                        </div>
                        <div>
                            <a href="#" class="btn btn-secondary rounded-3" id="filterButton"><i
                                    class="bi bi-funnel-fill"></i></a>
                        </div>

                        <!-- Search Bar -->
                        <div>
                            <form method="GET" action="#">

                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Cari nama dokter"
                                        aria-label="Cari" value="{{ request('search') }}" aria-describedby="basic-addon1">
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-md-2 text-end">
                        <a href="{{ route('permintaan-darah.create', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                            class="btn btn-primary">
                            <i class="ti-plus"></i> Tambah
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-sm table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th>No</th>
                                <th>Tgl Pengiriman</th>
                                <th>Unit Order</th>
                                <th>Nama Petugas</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($permintaanDarah as $index => $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ date('d-m-Y', strtotime($item->tgl_pengiriman)) }}</td>
                                    <td>
                                        {{ $item->unit->nama_unit }}
                                    </td>
                                    <td>{{ $item->petugas_pengambilan_sampel }}</td>
                                    <td>
                                        @if ($item->status == 0)
                                            Diorder
                                        @elseif ($item->status == 1)
                                            Diterima
                                        @elseif ($item->status == 2)
                                            Diserahkan
                                        @else
                                            Tidak Diketahui
                                        @endif
                                    </td>
                                    <td>
                                        <x-table-action>
                                            <a href="{{ route('permintaan-darah.show', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                class="btn btn-info btn-sm" title="Detail">
                                                <i class="ti-eye"></i>
                                            </a>
                                            @if ($item->status == 0 && $item->kd_unit == $dataMedis->kd_unit)
                                                <a href="{{ route('permintaan-darah.edit', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                    class="btn btn-warning btn-sm" title="Edit">
                                                    <i class="ti-pencil"></i>
                                                </a>
                                            @endif
                                            {{-- <form
                                                                    action="{{ route('permintaan-darah.destroy', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                                    method="POST" class="delete-form" style="display: inline;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger btn-sm ms-2"
                                                                        title="Hapus">
                                                                        <i class="ti-trash"></i>
                                                                    </button>
                                                                </form> --}}
                                        </x-table-action>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Tidak ada data Permintaan
                                        Darah</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-end">
                        {{ $permintaanDarah->links() }}
                    </div>
                </div>
            </x-content-card>
        </div>
    </div>
@endsection


@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Attach SweetAlert to all delete forms
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: 'Data edukasi ini akan dihapus secara permanen!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush
