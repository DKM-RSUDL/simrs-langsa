@extends('layouts.administrator.master')
@include('unit-pelayanan.rawat-inap.pelayanan.covid-19.include')

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

        .gejala-list, .risiko-list, .komorbid-list {
            max-width: 200px;
            max-height: 100px;
            overflow-y: auto;
            font-size: 0.8rem;
        }

        .gejala-list ul, .risiko-list ul, .komorbid-list ul {
            margin: 0;
            padding-left: 15px;
        }

        .gejala-list li, .risiko-list li, .komorbid-list li {
            font-size: 0.75rem;
            margin-bottom: 2px;
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

            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-virus me-2"></i>
                            FORMULIR DETEKSI DINI CORONA VIRUS DISEASE (COVID-19) REVISI 5
                        </h5>

                        {{-- Alert Messages --}}
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        {{-- Filter dan Search --}}
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <!-- Start Date -->
                                        <div class="me-2">
                                            <input type="date" name="start_date" id="start_date"
                                                class="form-control form-control-sm"
                                                placeholder="Dari Tanggal"
                                                value="{{ request('start_date') }}">
                                        </div>

                                        <!-- End Date -->
                                        <div class="me-2">
                                            <input type="date" name="end_date" id="end_date"
                                                class="form-control form-control-sm"
                                                placeholder="S.d Tanggal"
                                                value="{{ request('end_date') }}">
                                        </div>

                                        <!-- Filter Button -->
                                        <div class="me-3">
                                            <button class="btn btn-secondary btn-sm" id="filterButton">
                                                <i class="ti-filter"></i> Filter
                                            </button>
                                        </div>

                                        <!-- Search Bar -->
                                        <div class="me-2">
                                            <form method="GET" action="{{ request()->fullUrl() }}" class="d-flex">
                                                @foreach(request()->except(['search', 'page']) as $key => $value)
                                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                                @endforeach
                                                <div class="input-group input-group-sm">
                                                    <input type="text" name="search" class="form-control"
                                                        placeholder="Cari data COVID-19..."
                                                        value="{{ request('search') }}">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="ti-search"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Add Button -->
                                    <div>
                                        <a href="{{ route('rawat-inap.covid-19.create', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                            class="btn btn-primary btn-sm">
                                            <i class="ti-plus"></i> Tambah Data
                                        </a>
                                    </div>
                                </div>
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
                                        <th width="10%">Kesimpulan</th>
                                        <th width="10%">Persetujuan</th>
                                        <th width="12%">Petugas</th>
                                        <th width="8%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($covidData as $index => $item)
                                        <tr>
                                            <td>{{ $covidData->firstItem() + $index }}</td>
                                            <td>{{ $item->tanggal_formatted }}</td>
                                            <td>{{ $item->jam_formatted }}</td>
                                            <td>{!! $item->kesimpulan_badge !!}</td>
                                            <td>{!! $item->persetujuan_untuk_badge !!}</td>
                                            <td>{{ str()->title($item->userCreate->name ?? 'Tidak Diketahui') }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <!-- Detail Button -->
                                                    <a href="{{ route('rawat-inap.covid-19.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                        class="btn btn-info btn-sm" title="Detail">
                                                        <i class="ti-eye"></i>
                                                    </a>

                                                    <!-- Edit Button -->
                                                    <a href="{{ route('rawat-inap.covid-19.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                        class="btn btn-warning btn-sm" title="Edit">
                                                        <i class="ti-pencil"></i>
                                                    </a>

                                                    <!-- Delete Button -->
                                                    <form action="{{ route('rawat-inap.covid-19.destroy', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                        method="POST" class="delete-form" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            title="Hapus">
                                                            <i class="ti-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center py-4">
                                                <div class="d-flex flex-column align-items-center">
                                                    <i class="fas fa-virus fa-2x text-muted mb-2"></i>
                                                    <span class="text-muted">Belum ada data COVID-19</span>
                                                    <small class="text-muted">Klik tombol "Tambah Data" untuk menambah data baru</small>
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
                                        Menampilkan {{ $covidData->firstItem() ?? 0 }} - {{ $covidData->lastItem() ?? 0 }}
                                        dari {{ $covidData->total() }} data
                                    </small>
                                </div>
                                <div>
                                    {{ $covidData->links() }}
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
                        text: 'Apakah Anda yakin ingin menghapus data COVID-19 ini?',
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
                    if (confirm('Apakah Anda yakin ingin menghapus data COVID-19 ini?')) {
                        form.submit();
                    }
                }
            });
        });
    </script>
@endpush
