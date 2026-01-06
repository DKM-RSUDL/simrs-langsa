@extends('layouts.administrator.master')
@include('unit-pelayanan.rawat-inap.pelayanan.asesmen-pra-anestesi.include')

@push('css')
    <style>
        /* untuk button dropdownd di awal asesmen */
        .custom__dropdown {
            position: relative;
            display: inline-block;
            width: 250px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        .custom__dropdown__btn {
            background: #2563eb;
            color: white;
            padding: 12px 16px;
            border: none;
            border-radius: 8px;
            width: 100%;
            text-align: left;
            position: relative;
            font-size: 15px;
            transition: all 0.2s ease;
            box-shadow: 0 2px 4px rgba(37, 99, 235, 0.1);
        }

        .custom__dropdown__btn:hover {
            background: #1d4ed8;
            box-shadow: 0 4px 6px rgba(37, 99, 235, 0.2);
        }

        .custom__dropdown__btn::after {
            content: '';
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            border-left: 6px solid transparent;
            border-right: 6px solid transparent;
            border-top: 6px solid rgba(255, 255, 255, 0.9);
            transition: transform 0.2s ease;
        }

        .custom__dropdown__btn.active::after {
            transform: translateY(-50%) rotate(180deg);
        }

        .custom__dropdown__menu {
            display: none;
            position: absolute;
            background: white;
            width: 100%;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-top: 8px;
            padding: 8px 0;
            z-index: 1000;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.2s ease;
        }

        .custom__dropdown__menu.show {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        .custom__dropdown__item {
            display: block;
            padding: 10px 16px;
            text-decoration: none;
            color: #374151;
            font-size: 14px;
            transition: all 0.15s ease;
            position: relative;
        }

        .custom__dropdown__item:hover {
            background: #f3f4f6;
            color: #2563eb;
            padding-left: 20px;
        }

        /* List styling */
        .custom__dropdown__menu li {
            list-style: none;
        }

        /* Remove default padding from ul */
        .custom__dropdown__menu {
            padding: 8px 0;
            margin: 0;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            @include('components.navigation-hemodialisa')

            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="bi bi-clipboard2-pulse-fill"></i>
                            TRANSFER PASIEN ANTAR RUANG
                        </h5>

                    </div>
                    <div class="card-body">
                        <!-- Search and Filter Section -->
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
                            <div class="col-md-3">
                                <form method="GET"
                                    action="{{ route('hemodialisa.pelayanan.transfer-pasien.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control" placeholder="Cari"
                                            aria-label="Cari" value="{{ request('search') }}"
                                            aria-describedby="basic-addon1">
                                        <button type="submit" class="btn btn-primary">Cari</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Button "Tambah" di sebelah kanan -->
                            <div class="col-md-3 text-end">
                                <a href="{{ route('hemodialisa.pelayanan.transfer-pasien.create', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}"
                                    class="btn btn-primary">
                                    <i class="fas fa-shuffle"></i> Pindah Unit Asal
                                </a>
                            </div>
                        </div>

                        <!-- Transfer Cards -->
                        <div class="row">
                            @forelse($transfers as $index => $item)
                                <div class="col-12">
                                    <div class="assessment-card card">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <!-- Date Badge -->
                                                <div class="col-auto">
                                                    <div class="date-badge">
                                                        <div class="day-number">
                                                            {{ date('d', strtotime($item->tanggal)) }}</div>
                                                        <div class="day-month">
                                                            {{ date('M-y', strtotime($item->tanggal)) }}</div>
                                                        <div class="day-month">
                                                            {{ date('H:i', strtotime($item->jam)) }}</div>
                                                    </div>
                                                </div>

                                                <!-- Content -->
                                                <div class="col">
                                                    <div class="d-flex align-items-center">
                                                        {{-- <div class="avatar">
                                                            {{ strtoupper(substr($item->userCreate->name ?? 'U', 0, 1)) }}
                                                        </div> --}}
                                                        <div class="flex-grow-1">
                                                            <h6 class="assessment-title mb-1">Transfer Pasien Antar Ruang
                                                            </h6>
                                                            <p class="doctor-name"><strong>By:</strong>
                                                                {{ ($item->userCreate->karyawan->gelar_depan ?? '') . ' ' . str()->title($item->userCreate->karyawan->nama ?? '') . ' ' . ($item->userCreate->karyawan->gelar_belakang ?? '') }}
                                                            </p>
                                                            <p class="text-muted m-0"><strong>Unit Asal:</strong>
                                                                {{ ($item->serahTerima->unitAsal->nama_unit ?? 'Tidak Diketahui') . ' ' . ($item->serahTerima->unitAsal->bagian->bagian ? '(' . $item->serahTerima->unitAsal->bagian->bagian . ')' : '') }}
                                                            </p>
                                                            <p class="text-muted"><strong>Unit Tujuan:</strong>
                                                                {{ ($item->serahTerima->unitTujuan->nama_unit ?? 'Tidak Diketahui') . ' ' . ($item->serahTerima->unitTujuan->bagian->bagian ? '(' . $item->serahTerima->unitTujuan->bagian->bagian . ')' : '') }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Action Buttons -->
                                                <div class="col-auto">
                                                    <div class="action-buttons">
                                                        <a href="{{ route('hemodialisa.pelayanan.transfer-pasien.show', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                            class="btn btn-view btn-sm" title="Lihat">
                                                            <i class="ti-eye"></i> Lihat
                                                        </a>

                                                        @if (($item->serahTerima->kd_unit_asal ?? '') == $dataMedis->kd_unit && ($item->serahTerima->status ?? '') == 1)
                                                            <a href="{{ route('hemodialisa.pelayanan.transfer-pasien.edit', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                                class="btn btn-edit btn-sm" title="Edit">
                                                                <i class="ti-pencil"></i> Edit
                                                            </a>

                                                            <form
                                                                action="{{ route('hemodialisa.pelayanan.transfer-pasien.destroy', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                                method="POST" class="delete-form d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm"
                                                                    title="Hapus">
                                                                    <i class="ti-trash"></i>
                                                                </button>
                                                            </form>
                                                        @endif
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
                                        <h5>Belum ada data Transfer Pasien Antar Ruang</h5>
                                        <p class="text-muted">Klik tombol "Tambah" untuk membuat data baru</p>
                                    </div>
                                </div>
                            @endforelse
                        </div>

                        <!-- Pagination -->
                        @if ($transfers->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $transfers->appends(request()->query())->links() }}
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
        document.addEventListener('DOMContentLoaded', function() {
            // SweetAlert for delete confirmation
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: 'Data Transfer Pasien Antar Ruang ini akan dihapus secara permanen!',
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
            document.getElementById('filterButton').addEventListener('click', function(e) {
                e.preventDefault();
                const startDate = document.getElementById('start_date').value;
                const endDate = document.getElementById('end_date').value;
                const search = document.querySelector('input[name="search"]').value;

                // Construct URL with query parameters
                let url =
                    "{{ route('hemodialisa.pelayanan.transfer-pasien.index', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}";
                const params = new URLSearchParams();
                if (startDate) params.append('start_date', startDate);
                if (endDate) params.append('end_date', endDate);
                if (search) params.append('search', search);

                window.location.href = url + (params.toString() ? '?' + params.toString() : '');
            });
        });
    </script>
@endpush
