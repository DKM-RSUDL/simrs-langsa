@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>

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
                    <div class="row">
                        <!-- Select Option -->
                        <div class="col-md-2">
                            <select class="form-select" id="SelectOption" aria-label="Pilih...">
                                <option value="semua" selected>Semua Episode</option>
                                <option value="option1">Episode Sekarang</option>
                                <option value="option2">1 Bulan</option>
                                <option value="option3">3 Bulan</option>
                                <option value="option4">6 Bulan</option>
                                <option value="option5">9 Bulan</option>
                            </select>
                        </div>

                        <!-- Start Date -->
                        <div class="col-md-2">
                            <input type="date" name="start_date" id="start_date" class="form-control" placeholder="Dari Tanggal">
                        </div>

                        <!-- End Date -->
                        <div class="col-md-2">
                            <input type="date" name="end_date" id="end_date" class="form-control" placeholder="S.d Tanggal">
                        </div>

                        <!-- Button Filter -->
                        <div class="col-md-1">
                            <button id="filterButton" class="btn btn-secondary rounded-3"><i class="bi bi-funnel-fill"></i></button>
                        </div>

                        <!-- Search Bar -->
                        <div class="col-md-3">
                            <form method="GET" action="#">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Cari..." aria-label="Cari" value="{{ request('search') }}" aria-describedby="basic-addon1">
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </div>
                            </form>
                        </div>

                        <!-- Add Button -->
                        <div class="col-md-2">
                            <div class="d-grid gap-2">
                                <a href="{{ route('rawat-jalan.hiv_art_akhir_follow_up.create', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}" class="btn btn-primary">
                                    <i class="ti-plus"></i> Tambah
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-sm table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th>Tanggal & Jam</th>
                                <th>Petugas</th>
                                <th>Diagnosis</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @forelse ($prmrjs as $prmrj)
                                <tr>
                                    <td>
                                        {{ \Carbon\Carbon::parse($prmrj->tanggal)->format('Y-m-d') }}
                                        {{ \Carbon\Carbon::parse($prmrj->jam)->format('H:i') }}
                                    </td>
                                    <td>{{ str()->title($prmrj->userCreate->name) }}</td>
                                    <td>{{ $prmrj->diagnosis }}</td>
                                    <td>
                                        <a href="{{ route('rawat-jalan.prmrj.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $prmrj->id]) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('rawat-jalan.prmrj.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $prmrj->id]) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('rawat-jalan.prmrj.destroy', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $prmrj->id]) }}" method="POST" style="display:inline;" id="deleteForm_{{ $prmrj->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="{{ $prmrj->id }}"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Tidak ada data.</td>
                                </tr>
                            @endforelse --}}
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-end mt-3">
                    {{-- {{ $prmrjs->links() }} --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.getElementById('filterButton').addEventListener('click', function() {
            const selectOption = document.getElementById('SelectOption').value;
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;

            let url = new URL(window.location.href);
            if (selectOption) url.searchParams.set('option', selectOption);
            if (startDate) url.searchParams.set('start_date', startDate);
            if (endDate) url.searchParams.set('end_date', endDate);

            window.location.href = url.toString();
        });

        // Fungsi untuk konfirmasi hapus dengan SweetAlert
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const form = document.getElementById(`deleteForm_${id}`);

                Swal.fire({
                    title: 'Apakah Anda yakin?',
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
    </script>
@endpush
