@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        /* Enhanced completion styling */
        .completion-container {
            min-width: 140px;
        }

        .completion-text {
            font-size: 0.85rem;
            color: #495057;
        }

        .completion-bar {
            height: 6px;
            background-color: #e9ecef;
            border-radius: 3px;
            overflow: hidden;
            position: relative;
        }

        .completion-progress {
            height: 100%;
            border-radius: 3px;
            transition: width 0.8s ease-in-out;
            position: relative;
        }

        /* Gradient backgrounds for progress bars */
        .bg-gradient-success {
            background: linear-gradient(90deg, #28a745 0%, #20c997 100%);
        }

        .bg-gradient-info {
            background: linear-gradient(90deg, #17a2b8 0%, #6f42c1 100%);
        }

        .bg-gradient-warning {
            background: linear-gradient(90deg, #ffc107 0%, #fd7e14 100%);
        }

        .bg-gradient-danger {
            background: linear-gradient(90deg, #dc3545 0%, #e83e8c 100%);
        }

        /* Enhanced status badges */
        .badge {
            font-size: 0.7rem;
            padding: 0.35rem 0.6rem;
            border-radius: 0.375rem;
            font-weight: 600;
            letter-spacing: 0.025em;
        }

        .status-complete {
            background: linear-gradient(135deg, #28a745, #20c997) !important;
            color: white;
            border: none;
            box-shadow: 0 2px 4px rgba(40, 167, 69, 0.25);
        }

        .status-high {
            background: linear-gradient(135deg, #17a2b8, #6f42c1) !important;
            color: white;
            border: none;
            box-shadow: 0 2px 4px rgba(23, 162, 184, 0.25);
        }

        .status-medium {
            background: linear-gradient(135deg, #ffc107, #fd7e14) !important;
            color: #212529;
            border: none;
            box-shadow: 0 2px 4px rgba(255, 193, 7, 0.25);
        }

        .status-low {
            background: linear-gradient(135deg, #dc3545, #e83e8c) !important;
            color: white;
            border: none;
            box-shadow: 0 2px 4px rgba(220, 53, 69, 0.25);
        }

        /* Hover effects */
        .completion-container:hover .completion-progress {
            transform: scaleY(1.2);
            transition: transform 0.3s ease;
        }

        .badge:hover {
            transform: translateY(-1px);
            transition: transform 0.2s ease;
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
                                <a 
                                    href="{{ route('forensik.unit.pelayanan.visum-exit.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}" 
                                    class="nav-link {{ request()->routeIs('forensik.unit.pelayanan.visum-exit.index') ? 'active' : '' }}" 
                                    aria-current="{{ request()->routeIs('forensik.unit.pelayanan.visum-exit.index') ? 'page' : '' }}">
                                    Visum Exit
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a 
                                    href="{{ route('forensik.unit.pelayanan.visum-hidup.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}" 
                                    class="nav-link {{ request()->routeIs('forensik.unit.pelayanan.visum-hidup.index') ? 'active' : '' }}" 
                                    aria-current="{{ request()->routeIs('forensik.unit.pelayanan.visum-hidup.index') ? 'page' : '' }}">
                                    Visum Hidup
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
                                                            <a href="{{ route('forensik.unit.pelayanan.visum-hidup.create', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
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
                                                <th width="12%">Tanggal & Jam</th>
                                                <th width="20%">Dokter Pemeriksa</th>
                                                <th width="15%">Permintaan Dari</th>
                                                <th width="10%">Kelengkapan</th>
                                                <th width="12%">Dibuat Oleh</th>
                                                <th width="8%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($visumHidupList as $index => $item)
                                                <tr>
                                                    <td>{{ $visumHidupList->firstItem() + $index }}</td>
                                                    <td>
                                                        <strong>{{ $item->nomor_ver }}</strong>
                                                        @if($item->nomor_surat)
                                                            <br><small class="text-muted">{{ $item->nomor_surat }}</small>
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->tanggal_formatted }} {{ $item->jam_formatted }}</td>
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
                                                        <div class="completion-container">
                                                            <!-- Percentage with Icon -->
                                                            <div class="d-flex align-items-center justify-content-between mb-1">
                                                                <span class="completion-text fw-bold">{{ $item->completion_percentage }}%</span>
                                                                @if($item->completion_percentage >= 100)
                                                                    <i class="ti-check-circle text-success" style="font-size: 0.9rem;"></i>
                                                                @elseif($item->completion_percentage >= 80)
                                                                    <i class="ti-clock text-info" style="font-size: 0.9rem;"></i>
                                                                @elseif($item->completion_percentage >= 50)
                                                                    <i class="ti-alert-circle text-warning" style="font-size: 0.9rem;"></i>
                                                                @else
                                                                    <i class="ti-alert-triangle text-danger" style="font-size: 0.9rem;"></i>
                                                                @endif
                                                            </div>

                                                            <!-- Enhanced Progress Bar -->
                                                            <div class="completion-bar mb-2">
                                                                <div class="completion-progress
                                                                    @if($item->completion_percentage >= 100)
                                                                        bg-gradient-success
                                                                    @elseif($item->completion_percentage >= 80)
                                                                        bg-gradient-info
                                                                    @elseif($item->completion_percentage >= 50)
                                                                        bg-gradient-warning
                                                                    @else
                                                                        bg-gradient-danger
                                                                    @endif"
                                                                    style="width: {{ $item->completion_percentage }}%">
                                                                </div>
                                                            </div>

                                                            <!-- Smart Status Badge -->
                                                            @if($item->completion_percentage >= 100)
                                                                <span class="badge status-complete">
                                                                    <i class="ti-check me-1" style="font-size: 0.7rem;"></i>Lengkap
                                                                </span>
                                                            @elseif($item->completion_percentage >= 80)
                                                                <span class="badge status-high">
                                                                    <i class="ti-trending-up me-1" style="font-size: 0.7rem;"></i>Hampir Lengkap
                                                                </span>
                                                            @elseif($item->completion_percentage >= 50)
                                                                <span class="badge status-medium">
                                                                    <i class="ti-edit me-1" style="font-size: 0.7rem;"></i>Perlu Dilengkapi
                                                                </span>
                                                            @else
                                                                <span class="badge status-low">
                                                                    <i class="ti-alert-triangle me-1" style="font-size: 0.7rem;"></i>Belum Lengkap
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        {{ $item->userCreate->name }}
                                                        <br><small class="text-muted">{{ $item->no_transaksi }}</small>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <!-- View Button -->
                                                            <a href="{{ route('forensik.unit.pelayanan.visum-hidup.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                                class="btn btn-info btn-sm" title="Detail" data-bs-toggle="tooltip">
                                                                <i class="ti-eye"></i>
                                                            </a>

                                                            <!-- Edit Button -->
                                                            <a href="{{ route('forensik.unit.pelayanan.visum-hidup.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                                class="btn btn-warning btn-sm ms-1" title="Edit" data-bs-toggle="tooltip">
                                                                <i class="ti-pencil"></i>
                                                            </a>

                                                            <!-- Delete Button -->
                                                            <form action="{{ route('forensik.unit.pelayanan.visum-hidup.destroy', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
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
                                                    <td colspan="8" class="text-center py-4">
                                                        <div class="d-flex flex-column align-items-center">
                                                            <i class="ti-folder-open text-muted" style="font-size: 3rem;"></i>
                                                            <h6 class="text-muted mt-2">Tidak ada data Visum Hidup</h6>
                                                            <p class="text-muted small mb-0">
                                                                @if(request()->hasAny(['start_date', 'end_date', 'search']))
                                                                    Tidak ditemukan data sesuai filter yang diterapkan
                                                                @else
                                                                    Belum ada data Visum Hidup untuk pasien ini
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
                                @if($visumHidupList->hasPages())
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <div class="text-muted">
                                            Menampilkan {{ $visumHidupList->firstItem() }} sampai {{ $visumHidupList->lastItem() }}
                                            dari {{ $visumHidupList->total() }} data
                                        </div>
                                        <div>
                                            {{ $visumHidupList->links() }}
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
                        text: 'Data Visum Hidup ini akan dihapus secara permanen!',
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