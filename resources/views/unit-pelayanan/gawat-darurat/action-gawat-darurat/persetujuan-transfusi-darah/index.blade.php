@extends('layouts.administrator.master')
@include('unit-pelayanan.gawat-darurat.action-gawat-darurat.persetujuan-transfusi-darah.include')

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
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            @include('components.navigation')

            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="ti-clipboard"></i> Persetujuan Transfusi Darah
                        </h5>

                        {{-- Alert Messages --}}
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
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
                                                        placeholder="Cari diagnosa, dokter, atau petugas"
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
                                        <a href="{{ route('persetujuan-transfusi-darah.create', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
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
                                        <th width="12%">Tanggal</th>
                                        <th width="8%">Jam</th>
                                        <th width="20%">Diagnosa</th>
                                        <th width="15%">Persetujuan Untuk</th>
                                        <th width="10%">Status</th>
                                        <th width="15%">Dokter</th>
                                        <th width="15%">Petugas</th>
                                        <th width="12%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($persetujuanData as $index => $item)
                                        <tr>
                                            <td>{{ $persetujuanData->firstItem() + $index }}</td>
                                            <td>{{ $item->tanggal_formatted }}</td>
                                            <td>{{ $item->jam_formatted }}</td>
                                            <td>{{ $item->diagnosa }}</td>
                                            <td>
                                                @if($item->persetujuan_untuk === 'diri_sendiri')
                                                    <span class="badge bg-info">Diri Sendiri</span>
                                                @else
                                                    <span class="badge bg-warning">Keluarga/Wali</span>
                                                @endif
                                            </td>
                                            <td>{!! $item->persetujuan_badge !!}</td>
                                            <td>{{ $item->dokter ? $dokter->where('kd_dokter', $item->dokter)->first()->nama_lengkap ?? 'Tidak ada dokter dipilih' : 'Tidak ada dokter dipilih' }}</td>
                                            <td>{{ str()->title($item->userCreate->name ?? 'Tidak Diketahui') }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <!-- Detail Button -->
                                                    <a href="{{ route('persetujuan-transfusi-darah.show', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                        class="btn btn-info btn-sm" title="Detail">
                                                        <i class="ti-eye"></i>
                                                    </a>

                                                    <!-- Edit Button -->
                                                    <a href="{{ route('persetujuan-transfusi-darah.edit', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                        class="btn btn-warning btn-sm" title="Edit">
                                                        <i class="ti-pencil"></i>
                                                    </a>

                                                    <!-- Delete Button -->
                                                    <form action="{{ route('persetujuan-transfusi-darah.destroy', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
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
                                            <td colspan="9" class="text-center py-4">
                                                <div class="d-flex flex-column align-items-center">
                                                    <i class="ti-info-alt fa-2x text-muted mb-2"></i>
                                                    <span class="text-muted">Belum ada data Persetujuan Transfusi Darah</span>
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
                                        Menampilkan {{ $persetujuanData->firstItem() ?? 0 }} - {{ $persetujuanData->lastItem() ?? 0 }}
                                        dari {{ $persetujuanData->total() }} data
                                    </small>
                                </div>
                                <div>
                                    {{ $persetujuanData->links() }}
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
                        text: 'Apakah Anda yakin ingin menghapus data persetujuan transfusi darah ini?',
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
                    if (confirm('Apakah Anda yakin ingin menghapus data persetujuan transfusi darah ini?')) {
                        form.submit();
                    }
                }
            });
        });
    </script>
@endpush
