@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
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
        }

        .hiv-art-card {
            border-left: 4px solid #e74c3c;
        }

        .hiv-art-card:hover {
            border-left-color: #c0392b;
        }

        .patient-info {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 10px;
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

            <div class="row">
                {{-- Tabs --}}
                <ul class="nav nav-tabs" id="ikhtisarTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a href="{{ request()->fullUrlWithQuery(['tab' => 'ikhtisar']) }}"
                            class="nav-link {{ ($activeTab ?? 'ikhtisar') == 'ikhtisar' ? 'active' : '' }}"
                            aria-selected="{{ ($activeTab ?? 'ikhtisar') == 'ikhtisar' ? 'true' : 'false' }}">
                            <i class="bi bi-clipboard-data me-2"></i>
                            Ikhtisar
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

                <div class="d-flex justify-content-between align-items-center m-3">
                    <div class="row w-100">
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

                        <!-- Button Filter -->
                        <div class="col-md-1">
                            <button id="filterButton" class="btn btn-secondary rounded-3">
                                <i class="bi bi-funnel-fill"></i>
                            </button>
                        </div>

                        <!-- Search Bar -->
                        <div class="col-md-3">
                            <form method="GET" action="{{ route('rawat-jalan.hiv_art.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Cari..."
                                        aria-label="Cari" value="{{ request('search') }}" aria-describedby="basic-addon1">
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </div>
                            </form>
                        </div>

                        <!-- Add Button -->
                        <div class="col-md-2">
                            <div class="d-grid gap-2">
                                <a href="{{ route('rawat-jalan.hiv_art.create', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                    class="btn btn-primary">
                                    <i class="ti-plus"></i> Tambah
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- HIV ART Records Cards --}}
                <div class="row">
                    @forelse($hivArtRecords ?? [] as $index => $item)
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
                                                    {{ $item->jam ? date('H:i', strtotime($item->jam)) : '--:--' }}
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Content -->
                                        <div class="col">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar">
                                                    {{ strtoupper(substr($item->userCreate->name ?? 'U', 0, 1)) }}
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="assessment-title mb-1">
                                                        <i class="fas fa-virus text-danger me-2"></i>
                                                        HIV ART - Ikhtisar Perawatan
                                                    </h6>
                                                    <p class="doctor-name">By: {{ str()->title($item->userCreate->name ?? 'Unknown') }}</p>

                                                    <!-- Patient Info Summary -->
                                                    <div class="patient-info mt-2">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <span class="info-label">No Reg Nas:</span>
                                                                <div class="info-value">{{ $item->no_reg_nas ?: '-' }}</div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <span class="info-label">Status ART:</span>
                                                                <div class="info-value">
                                                                    @if($item->menerima_art)
                                                                        <span class="badge {{ $item->menerima_art == 'Ya' ? 'bg-success' : 'bg-secondary' }}">
                                                                            {{ $item->menerima_art }}
                                                                        </span>
                                                                    @else
                                                                        <span class="text-muted">-</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <span class="info-label">Indikasi ART:</span>
                                                                <div class="info-value">
                                                                    {{ $item->indikasi_inisiasi_art ? : '-' }}
                                                                </div>
                                                            </div>
                                                        </div>

                                                        @if($item->dataPemeriksaanKlinis)
                                                        <div class="row mt-2">
                                                            <div class="col-md-6">
                                                                <span class="info-label">CD4 Terakhir:</span>
                                                                <div class="info-value">
                                                                    @php
                                                                        $lastCd4 = $item->dataPemeriksaanKlinis->setelah_24_bulan_cd4
                                                                                ?? $item->dataPemeriksaanKlinis->setelah_12_bulan_cd4
                                                                                ?? $item->dataPemeriksaanKlinis->setelah_6_bulan_cd4
                                                                                ?? $item->dataPemeriksaanKlinis->saat_mulai_art_cd4
                                                                                ?? $item->dataPemeriksaanKlinis->kunjungan_pertama_cd4;
                                                                    @endphp
                                                                    {{ $lastCd4 ? $lastCd4 . ' cells/μL' : '-' }}
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <span class="info-label">BB Terakhir:</span>
                                                                <div class="info-value">
                                                                    @php
                                                                        $lastBb = $item->dataPemeriksaanKlinis->setelah_24_bulan_bb
                                                                                ?? $item->dataPemeriksaanKlinis->setelah_12_bulan_bb
                                                                                ?? $item->dataPemeriksaanKlinis->setelah_6_bulan_bb
                                                                                ?? $item->dataPemeriksaanKlinis->saat_mulai_art_bb
                                                                                ?? $item->dataPemeriksaanKlinis->kunjungan_pertama_bb;
                                                                    @endphp
                                                                    {{ $lastBb ? $lastBb . ' kg' : '-' }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif

                                                        @if($item->tgl_tes_hiv)
                                                        <div class="row mt-2">
                                                            <div class="col-md-6">
                                                                <span class="info-label">Tgl Tes HIV:</span>
                                                                <div class="info-value">{{ $item->tgl_tes_hiv->format('d/m/Y') }}</div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <span class="info-label">Tempat Tes:</span>
                                                                <div class="info-value">{{ $item->tempat_tes_hiv ?: '-' }}</div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="col-auto">
                                            <div class="action-buttons">
                                                <a href="{{ route('rawat-jalan.hiv_art.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                    class="btn btn-view btn-sm" title="Lihat">
                                                    <i class="ti-eye"></i> Lihat
                                                </a>

                                                <a href="{{ route('rawat-jalan.hiv_art.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                    class="btn btn-edit btn-sm" title="Edit">
                                                    <i class="ti-pencil"></i> Edit
                                                </a>

                                                <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                    data-id="{{ $item->id }}" title="Hapus">
                                                    <i class="ti-trash"></i>
                                                </button>

                                                <form id="deleteForm_{{ $item->id }}"
                                                    action="{{ route('rawat-jalan.hiv_art.destroy', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
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
                                <i class="fas fa-virus"></i>
                                <h5>Belum ada data HIV ART</h5>
                                <p class="text-muted">Klik tombol "Tambah" untuk membuat data HIV ART baru</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if(isset($hivArtRecords) && $hivArtRecords->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $hivArtRecords->links() }}
                    </div>
                @endif

                <!-- Summary Statistics -->
                @if(isset($hivArtRecords) && $hivArtRecords->count() > 0)
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">
                                    <i class="fas fa-chart-bar me-2"></i>
                                    Ringkasan Data HIV ART
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <h4 class="text-primary">{{ $hivArtRecords->total() }}</h4>
                                            <small class="text-muted">Total Records</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            @php
                                                $onArt = $hivArtRecords->where('menerima_art', 'Ya')->count();
                                            @endphp
                                            <h4 class="text-success">{{ $onArt }}</h4>
                                            <small class="text-muted">Sudah ART</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            @php
                                                $notOnArt = $hivArtRecords->where('menerima_art', 'Tidak')->count();
                                            @endphp
                                            <h4 class="text-warning">{{ $notOnArt }}</h4>
                                            <small class="text-muted">Belum ART</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            @php
                                                $withTb = $hivArtRecords->whereNotNull('tgl_mulai_terapi_tb')->count();
                                            @endphp
                                            <h4 class="text-danger">{{ $withTb }}</h4>
                                            <small class="text-muted">Ko-infeksi TB</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Filter functionality
            document.getElementById('filterButton').addEventListener('click', function() {
                const startDate = document.getElementById('start_date').value;
                const endDate = document.getElementById('end_date').value;

                let url = new URL(window.location.href);
                if (startDate) url.searchParams.set('start_date', startDate);
                if (endDate) url.searchParams.set('end_date', endDate);

                // Keep existing search and tab parameters
                const currentSearch = url.searchParams.get('search');
                const currentTab = url.searchParams.get('tab');

                if (currentSearch) url.searchParams.set('search', currentSearch);
                if (currentTab) url.searchParams.set('tab', currentTab);

                window.location.href = url.toString();
            });

            // Delete confirmation with SweetAlert
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const form = document.getElementById(`deleteForm_${id}`);

                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            title: 'Apakah Anda yakin?',
                            text: "Data HIV ART yang dihapus tidak dapat dikembalikan!",
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
                    } else {
                        // Fallback to native confirm
                        if (confirm('Apakah Anda yakin ingin menghapus data HIV ART ini?')) {
                            form.submit();
                        }
                    }
                });
            });

            // Auto-submit search on Enter
            document.querySelector('input[name="search"]').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    this.closest('form').submit();
                }
            });

            // Clear search functionality
            const searchInput = document.querySelector('input[name="search"]');
            if (searchInput && searchInput.value) {
                // Add clear button if there's a search value
                const clearBtn = document.createElement('button');
                clearBtn.type = 'button';
                clearBtn.className = 'btn btn-outline-secondary';
                clearBtn.innerHTML = '<i class="fas fa-times"></i>';
                clearBtn.title = 'Clear search';

                clearBtn.addEventListener('click', function() {
                    searchInput.value = '';
                    searchInput.closest('form').submit();
                });

                searchInput.parentNode.appendChild(clearBtn);
            }
        });

        // Show success/error messages
        @if(session('success'))
            @if(isset($message))
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: '{{ session('success') }}',
                        timer: 3000,
                        showConfirmButton: false
                    });
                } else {
                    alert('{{ session('success') }}');
                }
            @endif
        @endif

        @if(session('error'))
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    timer: 3000,
                    showConfirmButton: false
                });
            } else {
                alert('{{ session('error') }}');
            }
        @endif
    </script>
@endpush
