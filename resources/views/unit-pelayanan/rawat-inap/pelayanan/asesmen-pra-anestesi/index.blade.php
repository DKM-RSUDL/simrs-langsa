@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .assessment-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            margin-bottom: 1rem;
        }

        .assessment-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .date-badge {
            background: linear-gradient(135deg, #2047f5 0%, #31389c 100%);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: bold;
            text-align: center;
            min-width: 80px;
        }

        .day-number {
            font-size: 1.5rem;
            font-weight: 700;
            line-height: 1;
        }

        .day-month {
            font-size: 0.75rem;
            opacity: 0.9;
            margin-top: 2px;
        }

        .assessment-title {
            color: #2563eb;
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 0.25rem;
            text-decoration: none;
        }

        .assessment-title:hover {
            color: #1d4ed8;
            text-decoration: none;
        }

        .doctor-name {
            color: #6b7280;
            font-size: 0.875rem;
            margin-bottom: 0;
        }

        .action-buttons .btn {
            border-radius: 6px;
            font-size: 0.875rem;
            padding: 0.375rem 0.75rem;
            margin-left: 0.25rem;
        }

        .btn-view {
            background-color: #06b6d4;
            border-color: #06b6d4;
            color: white;
        }

        .btn-view:hover {
            background-color: #0891b2;
            border-color: #0891b2;
            color: white;
        }

        .btn-edit {
            background-color: #6b7280;
            border-color: #6b7280;
            color: white;
        }

        .btn-edit:hover {
            background-color: #4b5563;
            border-color: #4b5563;
            color: white;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            margin-right: 0.75rem;
        }

        .search-section {
            background: #f8fafc;
            padding: 1.5rem;
            border-radius: 12px;
            margin-bottom: 2rem;
        }

        .filter-controls {
            display: flex;
            gap: 1rem;
            align-items: end;
            flex-wrap: wrap;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #6b7280;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
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
                        <!-- Search and Filter Section -->
                        <div class="row">
                            <div class="d-flex justify-content-between m-3">
                                <div class="row">
                                    <!-- Start Date -->
                                    <div class="col-md-2">
                                        <input type="date" name="start_date" id="start_date" class="form-control"
                                            placeholder="Dari Tanggal">
                                    </div>

                                    <!-- End Date -->
                                    <div class="col-md-2">
                                        <input type="date" name="end_date" id="end_date" class="form-control"
                                            placeholder="S.d Tanggal">
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#" class="btn btn-secondary rounded-3" id="filterButton"><i
                                                class="bi bi-funnel-fill"></i></a>
                                    </div>

                                    <!-- Search Bar -->
                                    <div class="col-md-4">
                                        <form method="GET" action="#">

                                            <div class="input-group">
                                                <input type="text" name="search" class="form-control"
                                                    placeholder="Cari nama dokter" aria-label="Cari"
                                                    value="{{ request('search') }}" aria-describedby="basic-addon1">
                                                <button type="submit" class="btn btn-primary">Cari</button>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="col-md-2">
                                    <!-- Add Button -->
                                    <div class="form-group">
                                        <a href="{{ route('rawat-inap.asesmen-pra-anestesi.create', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                            class="btn btn-primary">
                                            <i class="ti-plus"></i> Tambah
                                        </a>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Assessment Cards --}}
                        <div class="row">
                            @forelse($asesmenPraAnestesi as $index => $item)
                                <div class="col-12">
                                    <div class="assessment-card card">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <!-- Date Badge -->
                                                <div class="col-auto">
                                                    <div class="date-badge">
                                                        <div class="day-number">
                                                            {{ date('d', strtotime($item->tanggal_create)) }}</div>
                                                        <div class="day-month">
                                                            {{ date('M-y', strtotime($item->tanggal_create)) }}</div>
                                                        <div class="day-month">
                                                            {{ date('H:i', strtotime($item->tanggal_create)) }}</div>
                                                    </div>
                                                </div>

                                                <!-- Content -->
                                                <div class="col">
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar">
                                                            {{ strtoupper(substr($item->userCreate->name ?? 'U', 0, 1)) }}
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="assessment-title mb-1">Asesmen Pra Anestesi & Sedasi</h6>
                                                            <p class="doctor-name">By:
                                                                {{ str()->title($item->userCreate->name ?? 'Unknown') }}</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Action Buttons -->
                                                <div class="col-auto">
                                                    <div class="action-buttons">
                                                        <a href="{{ route('rawat-inap.asesmen-pra-anestesi.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                            class="btn btn-view btn-sm" title="Lihat">
                                                            <i class="ti-eye"></i> Lihat
                                                        </a>

                                                        <a href="{{ route('rawat-inap.asesmen-pra-anestesi.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                            class="btn btn-edit btn-sm" title="Edit">
                                                            <i class="ti-pencil"></i> Edit
                                                        </a>

                                                        <form
                                                            action="{{ route('rawat-inap.asesmen-pra-anestesi.destroy', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                            method="POST" class="delete-form d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                                <i class="ti-trash"></i>
                                                            </button>
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
                                        <i class="ti-clipboard"></i>
                                        <h5>Belum ada data Asesmen Pra Anestesi & Sedasi</h5>
                                        <p class="text-muted">Klik tombol "Tambah" untuk membuat asesmen baru</p>
                                    </div>
                                </div>
                            @endforelse
                        </div>

                        <!-- Pagination -->
                        @if($asesmenPraAnestesi->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $asesmenPraAnestesi->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // SweetAlert for delete confirmation
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: 'Data Asesmen Pra Anestesi & Sedasi ini akan dihapus secara permanen!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // Filter functionality
            document.getElementById('filterButton').addEventListener('click', function () {
                const startDate = document.getElementById('start_date').value;
                const endDate = document.getElementById('end_date').value;

                // Add filter logic here if needed
                console.log('Filter:', { startDate, endDate });
            });
        });
    </script>
@endpush