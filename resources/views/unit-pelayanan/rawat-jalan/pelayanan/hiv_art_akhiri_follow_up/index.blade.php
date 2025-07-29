@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <!-- Sweet Alert 2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        .assessment-card {
            transition: all 0.3s ease;
            border-left: 4px solid #007bff;
        }

        .assessment-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,123,255,0.2);
        }

        .date-badge {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            min-width: 80px;
        }

        .day-number {
            font-size: 24px;
            font-weight: bold;
            line-height: 1;
        }

        .day-month {
            font-size: 12px;
            opacity: 0.9;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 15px;
        }

        .assessment-title {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .doctor-name {
            color: #7f8c8d;
            font-size: 14px;
            margin: 0;
        }

        .action-buttons .btn {
            margin-left: 5px;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 13px;
        }

        .btn-view {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            border: none;
            color: white;
        }

        .btn-edit {
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
            border: none;
            color: white;
        }

        .btn-delete {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            border: none;
            color: white;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #95a5a6;
        }

        .empty-state i {
            font-size: 64px;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .status-badge {
            font-size: 11px;
            padding: 4px 8px;
            border-radius: 12px;
            font-weight: 500;
        }

        .hiv-art-card {
            border-left: 4px solid #e74c3c;
            margin-bottom: 15px;
        }

        .hiv-art-card:hover {
            border-left-color: #c0392b;
        }

        .follow-up-info {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
        }

        .info-label {
            font-weight: 600;
            color: #2c3e50;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-value {
            color: #34495e;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .visits-summary {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .visits-count {
            background: #3498db;
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .last-visit {
            background: #95a5a6;
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
        }

        .tabs-container {
            background: white;
            border-radius: 10px 10px 0 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .nav-tabs {
            border-bottom: none;
            padding: 10px 20px 0;
        }

        .nav-tabs .nav-link {
            border: none;
            color: #7f8c8d;
            padding: 12px 20px;
            margin-right: 10px;
            border-radius: 8px 8px 0 0;
            background: #ecf0f1;
            transition: all 0.3s ease;
        }

        .nav-tabs .nav-link.active {
            background: #3498db;
            color: white;
        }

        .nav-tabs .nav-link:hover:not(.active) {
            background: #d5dbdb;
            color: #2c3e50;
        }

        .filter-section {
            background: white;
            padding: 20px;
            border-radius: 0 0 10px 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .loading-spinner {
            display: none;
            text-align: center;
            padding: 20px;
        }

        .no-data-illustration {
            max-width: 200px;
            margin: 0 auto 20px;
            opacity: 0.6;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .action-buttons {
                display: flex;
                flex-direction: column;
                gap: 5px;
            }

            .action-buttons .btn {
                margin-left: 0;
                font-size: 12px;
                padding: 6px 10px;
            }

            .filter-section .row > div {
                margin-bottom: 10px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            @include('components.navigation-rajal')

            <!-- Tabs Container -->
            <div class="tabs-container">
                <ul class="nav nav-tabs" id="ikhtisarTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a href="{{ request()->fullUrlWithQuery(['tab' => 'ikhtisar']) }}"
                            class="nav-link {{ ($activeTab ?? 'ikhtisar') == 'ikhtisar' ? 'active' : '' }}"
                            aria-selected="{{ ($activeTab ?? 'ikhtisar') == 'ikhtisar' ? 'true' : 'false' }}">
                            <i class="bi bi-clipboard-data me-2"></i>
                            Ikhtisar HIV ART
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="{{ request()->fullUrlWithQuery(['tab' => 'followUp']) }}"
                            class="nav-link {{ ($activeTab ?? 'ikhtisar') == 'followUp' ? 'active' : '' }}"
                            aria-selected="{{ ($activeTab ?? 'ikhtisar') == 'followUp' ? 'true' : 'false' }}">
                            <i class="bi bi-calendar-check me-2"></i>
                            Akhir Follow-Up
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Filter Section -->
            <div class="filter-section">
                <div class="row align-items-end">
                    <!-- Start Date -->
                    <div class="col-md-2">
                        <label class="form-label">Dari Tanggal</label>
                        <input type="date" name="start_date" id="start_date" class="form-control"
                            value="{{ request('start_date') }}">
                    </div>

                    <!-- End Date -->
                    <div class="col-md-2">
                        <label class="form-label">Sampai Tanggal</label>
                        <input type="date" name="end_date" id="end_date" class="form-control"
                            value="{{ request('end_date') }}">
                    </div>

                    <!-- Status Filter -->
                    <div class="col-md-2">
                        <label class="form-label">Status</label>
                        <select name="status_filter" id="status_filter" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="aktif" {{ request('status_filter') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="m" {{ request('status_filter') == 'm' ? 'selected' : '' }}>Meninggal</option>
                            <option value="lfu" {{ request('status_filter') == 'lfu' ? 'selected' : '' }}>Lost Follow Up</option>
                            <option value="rk" {{ request('status_filter') == 'rk' ? 'selected' : '' }}>Rujuk Keluar</option>
                        </select>
                    </div>

                    <!-- Button Filter -->
                    <div class="col-md-1">
                        <button id="filterButton" class="btn btn-secondary w-100" title="Filter Data">
                            <i class="bi bi-funnel-fill"></i>
                        </button>
                    </div>

                    <!-- Search Bar -->
                    <div class="col-md-3">
                        <label class="form-label">Pencarian</label>
                        <div class="input-group">
                            <input type="text" name="search" id="searchInput" class="form-control"
                                placeholder="Cari catatan, obat ARV..." value="{{ request('search') }}">
                            <button type="button" id="searchButton" class="btn btn-outline-secondary">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Add Button -->
                    <div class="col-md-2">
                        <div class="d-grid">
                            <a href="{{ route('rawat-jalan.hiv_art_akhir_follow_up.create', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                class="btn btn-primary">
                                <i class="ti-plus me-2"></i>Tambah Follow-Up
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Loading Spinner -->
            <div class="loading-spinner" id="loadingSpinner">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2 text-muted">Memuat data...</p>
            </div>

            <!-- Content Container -->
            <div id="contentContainer">
                @if($activeTab == 'followUp')
                    {{-- HIV ART Follow-Up Records --}}
                    <div class="row">
                        @forelse($hivArtData ?? [] as $index => $item)
                            <div class="col-12">
                                <div class="assessment-card card hiv-art-card">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <!-- Date Badge -->
                                            <div class="col-auto">
                                                <div class="date-badge">
                                                    <div class="day-number">
                                                        {{ $item->tanggal ? $item->tanggal->format('d') : date('d') }}
                                                    </div>
                                                    <div class="day-month">
                                                        {{ $item->tanggal ? $item->tanggal->format('M-y') : date('M-y') }}
                                                    </div>
                                                    <div class="day-month">
                                                        {{ $item->jam ? \Carbon\Carbon::parse($item->jam)->format('H:i') : '--:--' }}
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Content -->
                                            <div class="col">
                                                <div class="d-flex align-items-start">
                                                    <div class="avatar">
                                                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="assessment-title mb-1">
                                                            <i class="fas fa-calendar-check text-primary me-2"></i>
                                                            HIV ART - Follow-Up Perawatan
                                                        </h6>
                                                        <p class="doctor-name">
                                                            By: {{ auth()->user()->name ?? 'Unknown' }} •
                                                            {{ $item->created_at ? $item->created_at->format('d/m/Y H:i') : 'Tanggal tidak tersedia' }}
                                                        </p>

                                                        <!-- Follow-Up Info Summary -->
                                                        <div class="follow-up-info">
                                                            <div class="visits-summary">
                                                                <span class="visits-count">
                                                                    <i class="fas fa-calendar-alt me-1"></i>
                                                                    {{ $item->total_visits }} Kunjungan
                                                                </span>

                                                                @php
                                                                    $statusClass = match($item->status_akhir) {
                                                                        'aktif' => 'success',
                                                                        'm' => 'danger',
                                                                        'lfu' => 'warning',
                                                                        'rk' => 'info',
                                                                        default => 'secondary'
                                                                    };
                                                                    $statusText = match($item->status_akhir) {
                                                                        'aktif' => 'Aktif',
                                                                        'm' => 'Meninggal',
                                                                        'lfu' => 'Lost Follow Up',
                                                                        'rk' => 'Rujuk Keluar',
                                                                        default => 'Tidak Diketahui'
                                                                    };
                                                                @endphp

                                                                <span class="badge bg-{{ $statusClass }}">
                                                                    {{ $statusText }}
                                                                </span>

                                                                @if($item->getLastVisit())
                                                                    @php $lastVisit = $item->getLastVisit(); @endphp
                                                                    <span class="last-visit">
                                                                        Terakhir: {{ \Carbon\Carbon::parse($lastVisit['tanggal_kunjungan'])->format('d/m/Y') }}
                                                                    </span>
                                                                @endif
                                                            </div>

                                                            @if($item->catatan_umum)
                                                                <div class="mb-2">
                                                                    <span class="info-label">Catatan Umum:</span>
                                                                    <div class="info-value">{{ Str::limit($item->catatan_umum, 100) }}</div>
                                                                </div>
                                                            @endif

                                                            @if($item->getLastVisit())
                                                                <div class="row">
                                                                    @if(isset($lastVisit['bb']))
                                                                        <div class="col-md-3">
                                                                            <span class="info-label">BB Terakhir:</span>
                                                                            <div class="info-value">{{ $lastVisit['bb'] }} kg</div>
                                                                        </div>
                                                                    @endif
                                                                    @if(isset($lastVisit['cd4']))
                                                                        <div class="col-md-3">
                                                                            <span class="info-label">CD4 Terakhir:</span>
                                                                            <div class="info-value">{{ $lastVisit['cd4'] }} sel/mm³</div>
                                                                        </div>
                                                                    @endif
                                                                    @if(isset($lastVisit['adherence_art']))
                                                                        <div class="col-md-3">
                                                                            <span class="info-label">Adherence:</span>
                                                                            <div class="info-value">
                                                                                @switch($lastVisit['adherence_art'])
                                                                                    @case('1') >95% @break
                                                                                    @case('2') 80-95% @break
                                                                                    @case('3') <80% @break
                                                                                    @default {{ $lastVisit['adherence_art'] }}
                                                                                @endswitch
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                    @if(isset($lastVisit['obat_arv']))
                                                                        <div class="col-md-3">
                                                                            <span class="info-label">Obat ARV:</span>
                                                                            <div class="info-value">{{ Str::limit($lastVisit['obat_arv'], 30) }}</div>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Action Buttons -->
                                            <div class="col-auto">
                                                <div class="action-buttons">
                                                    <a href="{{ route('rawat-jalan.hiv_art_akhir_follow_up.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                        class="btn btn-view btn-sm" title="Lihat Detail">
                                                        <i class="ti-eye"></i> Lihat
                                                    </a>

                                                    <a href="{{ route('rawat-jalan.hiv_art_akhir_follow_up.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                        class="btn btn-edit btn-sm" title="Edit Data">
                                                        <i class="ti-pencil"></i> Edit
                                                    </a>

                                                    <button type="button" class="btn btn-delete btn-sm delete-btn"
                                                        data-id="{{ $item->id }}"
                                                        data-total-visits="{{ $item->total_visits }}"
                                                        data-status="{{ $statusText }}"
                                                        data-date="{{ $item->tanggal->format('d/m/Y') }}"
                                                        title="Hapus Data">
                                                        <i class="ti-trash"></i> Hapus
                                                    </button>

                                                    <form id="deleteForm_{{ $item->id }}"
                                                        action="{{ route('rawat-jalan.hiv_art_akhir_follow_up.destroy', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                        method="POST" class="d-none">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="empty-state">
                                    <div class="no-data-illustration">
                                        <i class="fas fa-calendar-times"></i>
                                    </div>
                                    <h5>Belum ada data Follow-Up HIV ART</h5>
                                    <p class="text-muted">Klik tombol "Tambah Follow-Up" untuk membuat data follow-up baru</p>
                                    <a href="{{ route('rawat-jalan.hiv_art_akhir_follow_up.create', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                        class="btn btn-primary mt-3">
                                        <i class="ti-plus me-2"></i>Tambah Follow-Up Pertama
                                    </a>
                                </div>
                            </div>
                        @endforelse
                    </div>
                @else
                    {{-- Ikhtisar HIV ART Records (jika ada) --}}
                    <div class="row">
                        <div class="col-12">
                            <div class="empty-state">
                                <div class="no-data-illustration">
                                    <i class="fas fa-virus"></i>
                                </div>
                                <h5>Ikhtisar HIV ART</h5>
                                <p class="text-muted">Halaman untuk menampilkan ikhtisar perawatan HIV ART pasien</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Pagination -->
                @if(isset($hivArtData) && $hivArtData->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $hivArtData->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('js')
    <!-- Sweet Alert 2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            // Filter functionality
            $('#filterButton').click(function() {
                applyFilter();
            });

            // Search functionality
            $('#searchButton').click(function() {
                applyFilter();
            });

            $('#searchInput').keypress(function(e) {
                if (e.which == 13) {
                    applyFilter();
                }
            });

            // Apply filter function
            function applyFilter() {
                const startDate = $('#start_date').val();
                const endDate = $('#end_date').val();
                const status = $('#status_filter').val();
                const search = $('#searchInput').val();
                const currentTab = '{{ $activeTab ?? "ikhtisar" }}';

                // Show loading
                showLoading();

                // Build URL with parameters
                const baseUrl = '{{ route("rawat-jalan.hiv_art_akhir_follow_up.index", [$dataMedis->kd_unit, $dataMedis->kd_pasien, date("Y-m-d", strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}';
                const params = new URLSearchParams();

                params.append('tab', currentTab);
                if (startDate) params.append('start_date', startDate);
                if (endDate) params.append('end_date', endDate);
                if (status) params.append('status_filter', status);
                if (search) params.append('search', search);

                window.location.href = baseUrl + '?' + params.toString();
            }

            // Delete functionality with Sweet Alert
            $('.delete-btn').click(function() {
                const id = $(this).data('id');
                const totalVisits = $(this).data('total-visits');
                const status = $(this).data('status');
                const date = $(this).data('date');

                Swal.fire({
                    title: 'Konfirmasi Hapus Data',
                    html: `
                        <div class="text-start">
                            <p class="mb-2"><strong>Anda akan menghapus data follow-up HIV ART:</strong></p>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-calendar text-primary me-2"></i>Tanggal: <strong>${date}</strong></li>
                                <li><i class="fas fa-list-ol text-info me-2"></i>Total Kunjungan: <strong>${totalVisits}</strong></li>
                                <li><i class="fas fa-flag text-warning me-2"></i>Status: <strong>${status}</strong></li>
                            </ul>
                            <div class="alert alert-warning mt-3">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Peringatan:</strong> Data yang dihapus tidak dapat dikembalikan!
                            </div>
                        </div>
                    `,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e74c3c',
                    cancelButtonColor: '#95a5a6',
                    confirmButtonText: '<i class="fas fa-trash me-2"></i>Ya, Hapus Data',
                    cancelButtonText: '<i class="fas fa-times me-2"></i>Batal',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    customClass: {
                        popup: 'swal-wide',
                        confirmButton: 'btn btn-danger',
                        cancelButton: 'btn btn-secondary'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading
                        Swal.fire({
                            title: 'Menghapus Data...',
                            text: 'Mohon tunggu sebentar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Submit delete form
                        setTimeout(() => {
                            document.getElementById('deleteForm_' + id).submit();
                        }, 1000);
                    }
                });
            });

            // Show loading function
            function showLoading() {
                $('#loadingSpinner').show();
                $('#contentContainer').hide();
            }

            // Hide loading function
            function hideLoading() {
                $('#loadingSpinner').hide();
                $('#contentContainer').show();
            }

            // Auto-hide alerts
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);

            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Show success message if exists
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session("success") }}',
                    timer: 3000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            @endif

            // Show error message if exists
            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: '{{ session("error") }}',
                    confirmButtonColor: '#e74c3c'
                });
            @endif

            // Validation errors
            @if($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    html: '<ul class="text-start">' +
                        @foreach($errors->all() as $error)
                            '<li>{{ $error }}</li>' +
                        @endforeach
                        '</ul>',
                    confirmButtonColor: '#e74c3c'
                });
            @endif
        });

        // Add custom CSS for SweetAlert
        const style = document.createElement('style');
        style.textContent = `
            .swal-wide {
                width: 600px !important;
            }
            .swal2-html-container {
                font-size: 14px;
            }
            .swal2-html-container ul {
                padding-left: 0;
            }
            .swal2-html-container li {
                padding: 5px 0;
            }
        `;
        document.head.appendChild(style);
    </script>
@endpush
