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
            @include('components.navigation-forensik')
            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">

                        {{-- Tab Content --}}
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active">
                                {{-- TAB 1. buatlah list disini --}}
                                <div class="row">
                                    <div class="d-flex justify-content-between m-3">
                                        <div class="row">
                                            <!-- Start Date -->
                                            <div class="col-md-2">
                                                <input type="date" name="start_date" id="start_date" class="form-control"
                                                    placeholder="Dari Tanggal" value="{{ request('start_date') }}">
                                            </div>

                                            <!-- End Date -->
                                            <div class="col-md-2">
                                                <input type="date" name="end_date" id="end_date" class="form-control"
                                                    placeholder="S.d Tanggal" value="{{ request('end_date') }}">
                                            </div>
                                            <div class="col-md-2">
                                                <a href="#" class="btn btn-secondary rounded-3" id="filterButton"><i
                                                        class="bi bi-funnel-fill"></i></a>
                                            </div>

                                            <!-- Search Bar -->
                                            <div class="col-md-4">
                                                <form method="GET" action="{{ route('forensik.unit.pelayanan.visum-otopsi.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}">
                                                    <input type="hidden" name="start_date" value="{{ request('start_date') }}">
                                                    <input type="hidden" name="end_date" value="{{ request('end_date') }}">
                                                    <div class="input-group">
                                                        <input type="text" name="search" class="form-control"
                                                            placeholder="Cari nama dokter" aria-label="Cari"
                                                            value="{{ request('search') }}" aria-describedby="basic-addon1">
                                                        <button type="submit" class="btn btn-primary">Cari</button>
                                                    </div>
                                                </form>
                                            </div>

                                            <div class="col-md-2">
                                                <a href="{{ route('forensik.unit.pelayanan.visum-otopsi.create', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                                    class="btn btn-primary">
                                                    <i class="ti-plus"></i> Tambah
                                                </a>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm table-hover">
                                            <thead class="table-primary">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tanggal</th>
                                                    <th>Jam</th>
                                                    <th>Nomor</th>
                                                    <th>Nama Petugas</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($visumOtopsiData as $index => $visum)
                                                    <tr>
                                                        <td>{{ $visumOtopsiData->firstItem() + $index }}</td>
                                                        <td>{{ $visum->tanggal ? date('d/m/Y', strtotime($visum->tanggal)) : '-' }}</td>
                                                        <td>{{ $visum->jam ? date('H:i', strtotime($visum->jam)) : '-' }}</td>
                                                        <td>{{ $visum->nomor ?? '-' }}</td>
                                                        <td>{{ $visum->userCreated->name ?? 'System' }}</td>
                                                        <td>
                                                            <span class="badge bg-success">Selesai</span>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                <a href="{{ route('forensik.unit.pelayanan.visum-otopsi.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $visum->id]) }}" 
                                                                   class="btn btn-info btn-sm">
                                                                    <i class="ti-eye"></i> Lihat
                                                                </a>
                                                                <a href="{{ route('forensik.unit.pelayanan.visum-otopsi.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $visum->id]) }}" 
                                                                   class="btn btn-warning btn-sm">
                                                                    <i class="ti-pencil"></i> Edit
                                                                </a>
                                                                <form method="POST" 
                                                                      action="{{ route('forensik.unit.pelayanan.visum-otopsi.destroy', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $visum->id]) }}" 
                                                                      class="delete-form d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                                        <i class="ti-trash"></i> Hapus
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="7" class="text-center">Tidak ada data visum otopsi</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>

                                        <!-- Pagination -->
                                        <div class="d-flex justify-content-end">
                                            {{ $visumOtopsiData->withQueryString()->links() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection


@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Filter functionality
            document.getElementById('filterButton').addEventListener('click', function(e) {
                e.preventDefault();
                const startDate = document.getElementById('start_date').value;
                const endDate = document.getElementById('end_date').value;
                const search = document.querySelector('input[name="search"]').value;
                
                const url = new URL(window.location.href);
                
                if (startDate) url.searchParams.set('start_date', startDate);
                else url.searchParams.delete('start_date');
                
                if (endDate) url.searchParams.set('end_date', endDate);
                else url.searchParams.delete('end_date');
                
                if (search) url.searchParams.set('search', search);
                else url.searchParams.delete('search');
                
                window.location.href = url.toString();
            });
            
            // Attach SweetAlert to all delete forms
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: 'Data visum otopsi ini akan dihapus secara permanen!',
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