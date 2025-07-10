@extends('layouts.administrator.master')
@include('unit-pelayanan.hemodialisa.pelayanan.tindakan-khusus.include')

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('unit-pelayanan.hemodialisa.component.patient-card')
        </div>

        <div class="col-md-9">
            @include('unit-pelayanan.hemodialisa.component.navigation')

            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        {{-- Tab Content --}}
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active">
                                {{-- Header Section --}}
                                <div class="row">
                                    <div class="d-flex justify-content-between align-items-center m-3">
                                        <div class="row">
                                            <!-- Select Option -->
                                            <div class="col-md-2">
                                                <select class="form-select" id="SelectOption" aria-label="Pilih...">
                                                    <option value="semua" {{ request('option') == 'semua' ? 'selected' : '' }}>Semua Episode</option>
                                                    <option value="option1" {{ request('option') == 'option1' ? 'selected' : '' }}>Episode Sekarang</option>
                                                    <option value="option2" {{ request('option') == 'option2' ? 'selected' : '' }}>1 Bulan</option>
                                                    <option value="option3" {{ request('option') == 'option3' ? 'selected' : '' }}>3 Bulan</option>
                                                    <option value="option4" {{ request('option') == 'option4' ? 'selected' : '' }}>6 Bulan</option>
                                                    <option value="option5" {{ request('option') == 'option5' ? 'selected' : '' }}>9 Bulan</option>
                                                </select>
                                            </div>

                                            <!-- Start Date -->
                                            <div class="col-md-2">
                                                <input type="date" name="start_date" id="start_date" 
                                                       class="form-control" placeholder="Dari Tanggal"
                                                       value="{{ request('start_date') }}">
                                            </div>

                                            <!-- End Date -->
                                            <div class="col-md-2">
                                                <input type="date" name="end_date" id="end_date" 
                                                       class="form-control" placeholder="S.d Tanggal"
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
                                                <form method="GET" action="{{ route('hemodialisa.pelayanan.tindakan-khusus.index', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}">
                                                    <div class="input-group">
                                                        <input type="text" name="search" class="form-control"
                                                            placeholder="Cari Diagnosis" aria-label="Cari"
                                                            value="{{ request('search') }}" aria-describedby="basic-addon1">
                                                        <button type="submit" class="btn btn-primary">Cari</button>
                                                    </div>
                                                </form>
                                            </div>

                                            <!-- Add Button -->
                                            <div class="col-md-2">
                                                <div class="d-grid gap-2">
                                                    <a href="{{ route('hemodialisa.pelayanan.tindakan-khusus.create', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                                        class="btn btn-primary">
                                                        <i class="ti-plus"></i> Tambah
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Content Section --}}
                                    <div class="row">
                                        @forelse($hdTindakanKhusus as $index => $item)
                                            <div class="col-12">
                                                <div class="assessment-card card">
                                                    <div class="card-body">
                                                        <div class="row align-items-center">
                                                            <!-- Date Badge -->
                                                            <div class="col-auto">
                                                                <div class="date-badge">
                                                                    <div class="day-number">
                                                                        {{ $item->tanggal ? date('d', strtotime($item->tanggal)) : '-' }}
                                                                    </div>
                                                                    <div class="day-month">
                                                                        {{ $item->tanggal ? date('M-y', strtotime($item->tanggal)) : '-' }}
                                                                    </div>
                                                                    <div class="day-month">
                                                                        {{ $item->jam ? date('H:i', strtotime($item->jam)) : '-' }}
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
                                                                        <h6 class="assessment-title mb-1">Pemakaian Obat-Obatan / Tindakan Khusus</h6>
                                                                        <p class="doctor-name">By: {{ str()->title($item->userCreate->name ?? 'Unknown') }}</p>
                                                                        
                                                                        {{-- Preview Content --}}
                                                                        <div class="mt-2">
                                                                            @if($item->diagnosis)
                                                                                <p class="mb-1"><strong>Diagnosis:</strong> {{ \Str::limit($item->diagnosis, 100) }}</p>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Action Buttons -->
                                                            <div class="col-auto">
                                                                <div class="action-buttons">
                                                                    <a href="{{ route('hemodialisa.pelayanan.tindakan-khusus.show', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                                        class="btn btn-view btn-sm" title="Lihat">
                                                                        <i class="ti-eye"></i> Lihat
                                                                    </a>

                                                                    <a href="{{ route('hemodialisa.pelayanan.tindakan-khusus.edit', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                                        class="btn btn-edit btn-sm" title="Edit">
                                                                        <i class="ti-pencil"></i> Edit
                                                                    </a>

                                                                    <form id="deleteForm_{{ $item->id }}"
                                                                        action="{{ route('hemodialisa.pelayanan.tindakan-khusus.destroy', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                                        method="POST" class="d-inline">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                                            data-id="{{ $item->id }}" title="Hapus">
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
                                                    <i class="fas fa-pills"></i>
                                                    <p>Belum ada data Pemakaian Obat-Obatan / Tindakan Khusus</p>
                                                </div>
                                            </div>
                                        @endforelse
                                    </div>

                                    <!-- Pagination -->
                                    @if($hdTindakanKhusus->hasPages())
                                        <div class="d-flex justify-content-center mt-4">
                                            {{ $hdTindakanKhusus->links() }}
                                        </div>
                                    @endif

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
        document.getElementById('filterButton').addEventListener('click', function () {
            const selectOption = document.getElementById('SelectOption').value;
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;

            let url = new URL(window.location.href);
            if (selectOption) url.searchParams.set('option', selectOption);
            if (startDate) url.searchParams.set('start_date', startDate);
            if (endDate) url.searchParams.set('end_date', endDate);

            window.location.href = url.toString();
        });

        // SweetAlert untuk konfirmasi hapus
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const id = this.getAttribute('data-id');
                const form = document.getElementById(`deleteForm_${id}`);

                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    text: "Apakah Anda yakin ingin menghapus data tindakan khusus ini?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Tampilkan loading
                        Swal.fire({
                            title: 'Menghapus...',
                            text: 'Sedang memproses penghapusan data',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Submit form
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush