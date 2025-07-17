@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .table th {            
            color: black;
            font-weight: 600;
            border: none;
            padding: 15px;
        }

        .table td {
            padding: 12px 15px;
            vertical-align: middle;
            border-bottom: 1px solid #e9ecef;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .btn-sm {
            padding: 5px 10px;
            font-size: 12px;
            border-radius: 5px;
            margin: 0 2px;
        }

        .soap-preview {
            font-size: 12px;
            color: #6c757d;
            max-width: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .diagnosis-text {
            font-weight: 600;
            color: #495057;
        }

        .date-time {
            font-size: 13px;
            color: #495057;
        }

        .unit-badge {
            background: #e3f2fd;
            color: #1976d2;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
        }

        .filter-section {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .filter-title {
            font-weight: 600;
            color: #495057;
            margin-bottom: 15px;
        }

        .alert {
            border: none;
            border-radius: 10px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .pagination {
            margin: 0;
        }

        .pagination .page-link {
            border-radius: 5px;
            margin: 0 2px;
            border: 1px solid #e9ecef;
        }

        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: #667eea;
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

            <!-- Filter Section -->
            <div class="filter-section">
                <h6 class="filter-title"><i class="fas fa-filter me-2"></i>Filter & Pencarian</h6>
                <div class="row">
                    <!-- Select Option -->
                    <div class="col-md-2">
                        <select class="form-select" id="SelectOption" aria-label="Pilih...">
                            <option value="semua" {{ request('option', 'semua') == 'semua' ? 'selected' : '' }}>Semua
                                Episode</option>
                            <option value="option1" {{ request('option') == 'option1' ? 'selected' : '' }}>Episode Sekarang
                            </option>
                            <option value="option2" {{ request('option') == 'option2' ? 'selected' : '' }}>1 Bulan</option>
                            <option value="option3" {{ request('option') == 'option3' ? 'selected' : '' }}>3 Bulan</option>
                            <option value="option4" {{ request('option') == 'option4' ? 'selected' : '' }}>6 Bulan</option>
                            <option value="option5" {{ request('option') == 'option5' ? 'selected' : '' }}>9 Bulan</option>
                        </select>
                    </div>

                    <!-- Start Date -->
                    <div class="col-md-2">
                        <input type="date" name="start_date" id="start_date" class="form-control"
                            placeholder="Dari Tanggal" value="{{ request('start_date') }}">
                    </div>

                    <!-- End Date -->
                    <div class="col-md-2">
                        <input type="date" name="end_date" id="end_date" class="form-control" placeholder="S.d Tanggal"
                            value="{{ request('end_date') }}">
                    </div>

                    <!-- Button Filter -->
                    <div class="col-md-1">
                        <button id="filterButton" class="btn btn-secondary rounded-3">
                            <i class="bi bi-funnel-fill"></i>
                        </button>
                    </div>

                    <!-- Search Bar -->
                    <div class="col-md-3">
                        <form method="GET"
                            action="{{ route('rawat-jalan.catatan-poliklinik.index', ['kd_unit' => $dataMedis->kd_unit, 'kd_pasien' => $dataMedis->kd_pasien, 'tgl_masuk' => \Carbon\Carbon::parse($dataMedis->tgl_masuk)->format('Y-m-d'), 'urut_masuk' => $dataMedis->urut_masuk]) }}">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Cari Diagnosis/SOAP"
                                    aria-label="Cari" value="{{ request('search') }}" aria-describedby="basic-addon1">
                                <button type="submit" class="btn btn-primary">Cari</button>
                            </div>
                        </form>
                    </div>

                    <!-- Add Button -->
                    <div class="col-md-2">
                        <div class="d-grid gap-2">
                            <a href="{{ route('rawat-jalan.catatan-poliklinik.create', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                class="btn btn-primary">
                                <i class="ti-plus"></i> Tambah
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-sm table-hover">
                    <thead>
                        <tr align="middle">
                            <th style="width: 15%;">Tanggal & Jam</th>
                            <th style="width: 12%;">Unit/Poliklinik</th>
                            <th style="width: 53%;">Catatan SOAP</th>
                            <th style="width: 20%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($catatanPoliklinik as $catatan)
                            <tr>
                                <td align="middle">
                                    <div class="date-time">
                                        <div class="fw-bold">
                                            {{ \Carbon\Carbon::parse($catatan->tanggal)->format('d/m/Y') }}</div>
                                        <div>{{ \Carbon\Carbon::parse($catatan->jam)->format('H:i') }} WIB</div>
                                    </div>
                                </td>
                                <td>
                                    <span class="unit-badge">{{ $dataMedis->unit->nama_unit }}</span>
                                </td>
                                <td>
                                    <div class="mb-1">
                                        <strong class="diagnosis-text">A:</strong>
                                        <span class="soap-preview">{{ Str::limit($catatan->assessment, 50) }}</span>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <small class="text-muted">
                                                <strong>S:</strong> {{ Str::limit($catatan->subjective, 30) }}
                                            </small>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">
                                                <strong>O:</strong> {{ Str::limit($catatan->objective, 30) }}
                                            </small>
                                        </div>
                                    </div>
                                    <div class="mt-1">
                                        <small class="text-muted">
                                            <strong>P:</strong> {{ Str::limit($catatan->plan, 40) }}
                                        </small>
                                    </div>
                                </td>
                                <td align="center">
                                    <div class="btn-group" role="group">
                                        <!-- View Button -->
                                        <a href="{{ route('rawat-jalan.catatan-poliklinik.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $catatan->id]) }}"
                                            class="btn btn-info btn-sm" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <!-- Edit Button - Only if same unit -->
                                        @if ($catatan->kd_unit == $dataMedis->kd_unit)
                                            <a href="{{ route('rawat-jalan.catatan-poliklinik.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $catatan->id]) }}"
                                                class="btn btn-warning btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <!-- Delete Button -->
                                            <form
                                                action="{{ route('rawat-jalan.catatan-poliklinik.destroy', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $catatan->id]) }}"
                                                method="POST" style="display:inline;"
                                                id="deleteForm_{{ $catatan->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                    data-id="{{ $catatan->id }}" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-muted small">Unit lain</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <div class="empty-state">
                                        <i class="fas fa-clipboard-list"></i>
                                        <h5>Belum Ada Catatan Klinik</h5>
                                        <p class="text-muted">Belum ada catatan klinik yang tersedia untuk pasien ini.</p>
                                        <a href="{{ route('rawat-jalan.catatan-poliklinik.create', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                            class="btn btn-primary">
                                            Tambah Catatan Pertama
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination & Info -->
            @if ($catatanPoliklinik->hasPages() || $catatanPoliklinik->total() > 0)
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Menampilkan {{ $catatanPoliklinik->firstItem() ?? 0 }} sampai
                        {{ $catatanPoliklinik->lastItem() ?? 0 }}
                        dari {{ $catatanPoliklinik->total() }} catatan
                    </div>
                    <div>
                        {{ $catatanPoliklinik->appends(request()->query())->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('js')
    <script>
        // Filter functionality
        document.getElementById('filterButton').addEventListener('click', function() {
            const selectOption = document.getElementById('SelectOption').value;
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;

            let url = new URL(window.location.href);

            // Clear existing filter params
            url.searchParams.delete('option');
            url.searchParams.delete('start_date');
            url.searchParams.delete('end_date');

            // Add new filter params
            if (selectOption && selectOption !== 'semua') {
                url.searchParams.set('option', selectOption);
            }
            if (startDate) {
                url.searchParams.set('start_date', startDate);
            }
            if (endDate) {
                url.searchParams.set('end_date', endDate);
            }

            window.location.href = url.toString();
        });

        // Delete confirmation with SweetAlert
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const form = document.getElementById(`deleteForm_${id}`);

                Swal.fire({
                    title: 'Hapus Catatan Klinik?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
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

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);

        // Clear filter functionality
        function clearFilters() {
            document.getElementById('SelectOption').value = 'semua';
            document.getElementById('start_date').value = '';
            document.getElementById('end_date').value = '';

            let url = new URL(window.location.href);
            url.searchParams.delete('option');
            url.searchParams.delete('start_date');
            url.searchParams.delete('end_date');
            url.searchParams.delete('search');

            window.location.href = url.toString();
        }
    </script>
@endpush
