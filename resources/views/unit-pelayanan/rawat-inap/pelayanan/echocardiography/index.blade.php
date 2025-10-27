@extends('layouts.administrator.master')
@include('unit-pelayanan.rawat-inap.pelayanan.echocardiography.include')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
            border: 1px solid #dee2e6;
        }

        .table td {
            border: 1px solid #dee2e6;
            vertical-align: middle;
        }

        .btn-group .btn {
            margin: 0 1px;
        }

        .badge {
            font-size: 0.75rem;
        }

        .text-truncate-custom {
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            @include('components.navigation-ranap')

            <x-content-card>
                @include('components.page-header', [
                    'title' => 'Laporan Hasil Echocardiography',
                    'description' => 'Daftar data hasil echocardiography rawat inap.',
                ])

                <div class="row">
                    <div class="col-md-10 d-flex flex-md-row flex-wrap flex-md-nowrap gap-2">
                        <!-- Start Date -->
                        <div>
                            <input type="date" name="start_date" id="start_date" class="form-control"
                                placeholder="Dari Tanggal" value="{{ request('start_date') }}">
                        </div>

                        <!-- End Date -->
                        <div>
                            <input type="date" name="end_date" id="end_date" class="form-control"
                                placeholder="S.d Tanggal" value="{{ request('end_date') }}">
                        </div>

                        <!-- Filter Button -->
                        <div>
                            <button class="btn btn-secondary" id="filterButton">
                                <i class="ti-filter"></i>
                            </button>
                        </div>

                        <!-- Search Bar -->
                        <div>
                            <form method="GET" action="{{ request()->fullUrl() }}" class="d-flex">
                                @foreach (request()->except(['search', 'page']) as $key => $value)
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endforeach
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Cari data echocardiography..." value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ti-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Add Button -->
                    <div class="col-md-2 text-end">
                        <a href="{{ route('rawat-inap.echocardiography.create', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                            class="btn btn-primary">
                            <i class="ti-plus"></i> Tambah
                        </a>
                    </div>
                </div>

                {{-- Table Data --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-sm table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th width="5%">No</th>
                                <th width="10%">Tanggal</th>
                                <th width="8%">Jam</th>
                                <th width="15%">Diagnosa Klinik</th>
                                <th width="12%">Dokter Pemeriksa</th>
                                <th width="10%">Petugas</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($echocardiographyData as $index => $item)
                                <tr>
                                    <td>{{ $echocardiographyData->firstItem() + $index }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->jam)->format('H:i') }}</td>
                                    <td>
                                        <span class="text-truncate-custom" title="{{ $item->diagnosa_klinik }}">
                                            {{ $item->diagnosa_klinik ?? '-' }}
                                        </span>
                                    </td>
                                    <td>{{ $item->dokter->nama_lengkap ?? 'Tidak Diketahui' }}</td>
                                    <td>{{ str()->title($item->userCreate->name ?? 'Tidak Diketahui') }}</td>
                                    <td>
                                        <x-table-action>
                                            <!-- Detail Button -->
                                            <a href="{{ route('rawat-inap.echocardiography.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                class="btn btn-info btn-sm" title="Detail">
                                                <i class="ti-eye"></i>
                                            </a>

                                            <!-- Edit Button -->
                                            <a href="{{ route('rawat-inap.echocardiography.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                class="btn btn-warning btn-sm" title="Edit">
                                                <i class="ti-pencil"></i>
                                            </a>

                                            <!-- Delete Button -->
                                            <form
                                                action="{{ route('rawat-inap.echocardiography.destroy', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                method="POST" class="delete-form" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                    <i class="ti-trash"></i>
                                                </button>
                                            </form>
                                        </x-table-action>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fas fa-heartbeat fa-2x text-muted mb-2"></i>
                                            <span class="text-muted">Belum ada data Echocardiography</span>
                                            <small class="text-muted">Klik tombol "Tambah Data" untuk menambah data
                                                baru</small>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            <small class="text-muted">
                                Menampilkan {{ $echocardiographyData->firstItem() ?? 0 }} -
                                {{ $echocardiographyData->lastItem() ?? 0 }}
                                dari {{ $echocardiographyData->total() }} data
                            </small>
                        </div>
                        <div>
                            {{ $echocardiographyData->links() }}
                        </div>
                    </div>
                </div>
            </x-content-card>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            // Filter button functionality
            $('#filterButton').on('click', function() {
                const startDate = $('#start_date').val();
                const endDate = $('#end_date').val();

                let url = new URL(window.location.href);

                if (startDate) {
                    url.searchParams.set('start_date', startDate);
                } else {
                    url.searchParams.delete('start_date');
                }

                if (endDate) {
                    url.searchParams.set('end_date', endDate);
                } else {
                    url.searchParams.delete('end_date');
                }

                url.searchParams.delete('page'); // Reset pagination
                window.location.href = url.toString();
            });

            // Auto dismiss alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);

            // Confirm delete with SweetAlert if available
            $('.delete-form').on('submit', function(e) {
                e.preventDefault();
                const form = this;

                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Konfirmasi Hapus',
                        text: 'Apakah Anda yakin ingin menghapus data Echocardiography ini?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                } else {
                    if (confirm('Apakah Anda yakin ingin menghapus data Echocardiography ini?')) {
                        form.submit();
                    }
                }
            });
        });
    </script>
@endpush
