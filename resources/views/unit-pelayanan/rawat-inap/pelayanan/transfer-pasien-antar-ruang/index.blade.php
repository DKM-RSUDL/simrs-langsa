@extends('layouts.administrator.master')
@include('unit-pelayanan.rawat-inap.pelayanan.asesmen-pra-anestesi.include')

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
                                    <h5 class="card-title">
                                        <i class="bi bi-clipboard2-pulse-fill"></i>
                                        TRANSFER PASIEN ANTAR RUANG
                                    </h5>
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
                                    <div class="col-md-4">
                                        <form method="GET" action="{{ route('rawat-inap.transfer-pasien-antar-ruang.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}">
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
                                            <a href="{{ route('rawat-inap.transfer-pasien-antar-ruang.create', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                                class="btn btn-primary">
                                                <i class="ti-plus"></i> Tambah
                                            </a>
                                        </div>
                                    </div>
                                </div>
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
                                                            <h6 class="assessment-title mb-1">Transfer Pasien Antar Ruang</h6>
                                                            <p class="doctor-name">By:
                                                                {{ str()->title($item->userCreate->name ?? 'Unknown') }}</p>
                                                            <p class="text-muted">Unit Tujuan: {{ $item->kd_unit_tujuan ?? 'Tidak Diketahui' }}</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Action Buttons -->
                                                <div class="col-auto">
                                                    <div class="action-buttons">
                                                        <a href="{{ route('rawat-inap.transfer-pasien-antar-ruang.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                            class="btn btn-view btn-sm" title="Lihat">
                                                            <i class="ti-eye"></i> Lihat
                                                        </a>

                                                        <a href="{{ route('rawat-inap.transfer-pasien-antar-ruang.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                            class="btn btn-edit btn-sm" title="Edit">
                                                            <i class="ti-pencil"></i> Edit
                                                        </a>

                                                        <form
                                                            action="{{ route('rawat-inap.transfer-pasien-antar-ruang.destroy', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
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
                                        <h5>Belum ada data Transfer Pasien Antar Ruang</h5>
                                        <p class="text-muted">Klik tombol "Tambah" untuk membuat data baru</p>
                                    </div>
                                </div>
                            @endforelse
                        </div>

                        <!-- Pagination -->
                        @if($transfers->hasPages())
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
        document.addEventListener('DOMContentLoaded', function () {
            // SweetAlert for delete confirmation
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function (e) {
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
            document.getElementById('filterButton').addEventListener('click', function (e) {
                e.preventDefault();
                const startDate = document.getElementById('start_date').value;
                const endDate = document.getElementById('end_date').value;
                const search = document.querySelector('input[name="search"]').value;

                // Construct URL with query parameters
                let url = "{{ route('rawat-inap.transfer-pasien-antar-ruang.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}";
                const params = new URLSearchParams();
                if (startDate) params.append('start_date', startDate);
                if (endDate) params.append('end_date', endDate);
                if (search) params.append('search', search);

                window.location.href = url + (params.toString() ? '?' + params.toString() : '');
            });
        });
    </script>
@endpush