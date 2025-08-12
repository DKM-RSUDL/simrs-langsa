@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .status-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
        }
        .completion-bar {
            height: 4px;
            background-color: #e9ecef;
            border-radius: 2px;
            overflow: hidden;
        }
        .completion-progress {
            height: 100%;
            background-color: #28a745;
            transition: width 0.3s ease;
        }
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
                        {{-- Tabs --}}
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a href="?tab=order" class="nav-link active" aria-selected="true">
                                    Visum Exit
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="?tab=monitoring" class="nav-link" aria-selected="false">
                                    Visum
                                </a>
                            </li>
                        </ul>

                        {{-- Tab Content --}}
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active">
                                {{-- Filters & Search --}}
                                <div class="row mb-3 mt-3">
                                    <div class="col-12">
                                        <form method="GET" action="{{ request()->url() }}" id="filterForm">
                                            <div class="d-flex justify-content-between align-items-end">
                                                <div class="row flex-grow-1">
                                                    <!-- Start Date -->
                                                    <div class="col-md-2">
                                                        <label class="form-label small">Dari Tanggal</label>
                                                        <input type="date" name="start_date" id="start_date"
                                                            class="form-control form-control-sm"
                                                            value="{{ request('start_date') }}">
                                                    </div>

                                                    <!-- End Date -->
                                                    <div class="col-md-2">
                                                        <label class="form-label small">S.d Tanggal</label>
                                                        <input type="date" name="end_date" id="end_date"
                                                            class="form-control form-control-sm"
                                                            value="{{ request('end_date') }}">
                                                    </div>

                                                    <!-- Filter Button -->
                                                    <div class="col-md-1">
                                                        <button type="submit" class="btn btn-secondary btn-sm rounded-3 w-100"
                                                            style="margin-top: 1.5rem;">
                                                            <i class="bi bi-funnel-fill"></i>
                                                        </button>
                                                    </div>

                                                    <!-- Search Bar -->
                                                    <div class="col-md-4">
                                                        <label class="form-label small">Cari Dokter</label>
                                                        <div class="input-group input-group-sm">
                                                            <input type="text" name="search" class="form-control"
                                                                placeholder="Cari nama dokter"
                                                                value="{{ request('search') }}">
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="bi bi-search"></i> Cari
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <!-- Add Button -->
                                                    <div class="col-md-2">
                                                        <div style="margin-top: 1.5rem;">
                                                            <a href="{{ route('forensik.unit.pelayanan.visum-exit.create', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                                                class="btn btn-primary btn-sm w-100">
                                                                <i class="ti-plus"></i> Tambah
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Clear Filter -->
                                                @if(request()->hasAny(['start_date', 'end_date', 'search']))
                                                    <div class="ms-2">
                                                        <a href="{{ request()->url() }}" class="btn btn-outline-secondary btn-sm"
                                                            style="margin-top: 1.5rem;">
                                                            <i class="bi bi-x-circle"></i> Clear
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                {{-- Data Table --}}
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm table-hover">
                                        <thead class="table-primary">
                                            <tr>
                                                <th width="5%">No</th>
                                                <th width="10%">Nomor VeR &Surat</th>
                                                <th width="12%">Tanggal</th>
                                                <th width="8%">Jam</th>
                                                <th width="20%">Dokter Pemeriksa</th>
                                                <th width="15%">Permintaan Dari</th>
                                                <th width="10%">Kelengkapan</th>
                                                <th width="12%">Dibuat Oleh</th>
                                                <th width="8%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($visumExitList as $index => $item)
                                                <tr>
                                                    <td>{{ $visumExitList->firstItem() + $index }}</td>
                                                    <td>
                                                        <strong>{{ $item->nomor_ver }}</strong>
                                                        @if($item->nomor_surat)
                                                            <br><small class="text-muted">{{ $item->nomor_surat }}</small>
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->tanggal_formatted }}</td>
                                                    <td>{{ $item->jam_formatted }}</td>
                                                    <td>
                                                        {{ $item->dokter_name }}
                                                        @if($item->dokter && $item->dokter->spesialis)
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($item->permintaan)
                                                            {{ Str::limit($item->permintaan, 30) }}
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <span class="me-2">{{ $item->completion_percentage }}%</span>
                                                            <div class="completion-bar flex-grow-1">
                                                                <div class="completion-progress"
                                                                    style="width: {{ $item->completion_percentage }}%"></div>
                                                            </div>
                                                        </div>
                                                        @if($item->is_complete)
                                                            <span class="badge bg-success status-badge mt-1">Lengkap</span>
                                                        @else
                                                            <span class="badge bg-warning status-badge mt-1">Belum Lengkap</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ $item->user_create_name }}
                                                        <br><small class="text-muted">{{ $item->no_transaksi }}</small>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <!-- View Button -->
                                                            <a href="{{ route('forensik.unit.pelayanan.visum-exit.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                                class="btn btn-info btn-sm" title="Detail" data-bs-toggle="tooltip">
                                                                <i class="ti-eye"></i>
                                                            </a>

                                                            <!-- Edit Button -->
                                                            <a href="{{ route('forensik.unit.pelayanan.visum-exit.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                                class="btn btn-warning btn-sm ms-1" title="Edit" data-bs-toggle="tooltip">
                                                                <i class="ti-pencil"></i>
                                                            </a>

                                                            <!-- Delete Button -->
                                                            <form action="{{ route('forensik.unit.pelayanan.visum-exit.destroy', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                                method="POST" class="delete-form" style="display: inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm ms-1"
                                                                    title="Hapus" data-bs-toggle="tooltip">
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
                                                            <i class="ti-folder-open text-muted" style="font-size: 3rem;"></i>
                                                            <h6 class="text-muted mt-2">Tidak ada data Visum et Repertum</h6>
                                                            <p class="text-muted small mb-0">
                                                                @if(request()->hasAny(['start_date', 'end_date', 'search']))
                                                                    Tidak ditemukan data sesuai filter yang diterapkan
                                                                @else
                                                                    Belum ada data Visum et Repertum untuk pasien ini
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination -->
                                @if($visumExitList->hasPages())
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <div class="text-muted">
                                            Menampilkan {{ $visumExitList->firstItem() }} sampai {{ $visumExitList->lastItem() }}
                                            dari {{ $visumExitList->total() }} data
                                        </div>
                                        <div>
                                            {{ $visumExitList->links() }}
                                        </div>
                                    </div>
                                @endif
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
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // SweetAlert for delete confirmation
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: 'Data Visum et Repertum ini akan dihapus secara permanen!',
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

            // Auto submit form when date changes
            document.getElementById('start_date').addEventListener('change', function() {
                if (this.value && document.getElementById('end_date').value) {
                    document.getElementById('filterForm').submit();
                }
            });

            document.getElementById('end_date').addEventListener('change', function() {
                if (this.value && document.getElementById('start_date').value) {
                    document.getElementById('filterForm').submit();
                }
            });
        });
    </script>
@endpush
