@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
        <style>
        #asesmenList .list-group-item:nth-child(even) {
            background-color: #edf7ff;
        }

        /* Background putih untuk item ganjil */
        #asesmenList .list-group-item:nth-child(odd) {
            background-color: #ffffff;
        }

        /* Efek hover tetap sama untuk konsistensi */
        #asesmenList .list-group-item:hover {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .list-group-item {
            margin-bottom: 0.2rem;
            border-radius: 0.5rem !important;
            padding: 0.5rem;
            border: 1px solid #dee2e6;
            background: white;
            transition: all 0.2s;
        }

        .list-group-item:hover {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .gap-2 {
            gap: 0.5rem !important;
        }

        .gap-3 {
            gap: 1rem !important;
        }

        .gap-4 {
            gap: 1.5rem !important;
        }

        .btn-sm {
            padding: 0.4rem 1rem;
            font-size: 0.875rem;
        }

        .btn i {
            font-size: 0.875rem;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            @include('components.navigation-operasi')

            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">


                        <div class="d-flex justify-content-start align-items-center m-3">
                            <div class="row g-3 w-100">
                                <!-- Select Episode Option -->
                                <div class="col-md-2">
                                    <select class="form-select" id="SelectEpisode" aria-label="Pilih...">
                                        <option value="semua" selected>Semua Episode</option>
                                        <option value="Episode1">Episode Sekarang</option>
                                        <option value="Episode2">1 Bulan</option>
                                        <option value="Episode3">3 Bulan</option>
                                        <option value="Episode4">6 Bulan</option>
                                        <option value="Episode5">9 Bulan</option>
                                    </select>
                                </div>

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

                                <!-- Search Bar -->
                                <div class="col-md-2">
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="bi bi-search"></i>
                                        </span>
                                        <input type="text" class="form-control" placeholder="Cari" aria-label="Cari"
                                            aria-describedby="basic-addon1" id="searchInput">
                                    </div>
                                </div>

                                <!-- Button "Tambah" di sebelah kanan -->
                                <div class="col-md-4 text-end ms-auto">
                                    <div class="btn-group">
                                        <a href="{{ route('operasi.pelayanan.laporan-anastesi.create', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                            class="btn btn-primary">
                                            <i class="ti-plus"></i> Tambah
                                        </a>
                                        <a href="{{ route('operasi.pelayanan.ceklist-anasthesi.index', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                            class="btn btn-primary ms-2">
                                            <i class="ti-plus"></i> Ceklist Anasthesi
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <ul class="list-group" id="laporanAnastesiList">
                            @forelse ($laporanAnastesi as $item)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center gap-4">
                                        <!-- Tanggal -->
                                        <div class="text-center px-3">
                                            <div class="fw-bold fs-4 mb-0 text-primary">
                                                {{ date('d', strtotime($item->waktu_laporan)) }}
                                            </div>
                                            <div class="text-muted" style="font-size: 0.85rem;">
                                                {{ date('M-y', strtotime($item->waktu_laporan)) }}
                                            </div>
                                            <div class="text-muted" style="font-size: 0.85rem;">
                                                {{ date('H:i', strtotime($item->waktu_laporan)) }}
                                            </div>
                                        </div>

                                        <!-- Info Laporan -->
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="{{ asset('assets/images/avatar1.png') }}"
                                                class="rounded-circle border border-2" alt="Foto Pasien" width="60"
                                                height="60">
                                            <div>
                                                <div class="text-primary fw-bold mb-1">
                                                    Laporan Anastesi - {{ $item->jenis_operasi ?? 'Tidak Ditentukan' }}
                                                </div>
                                                <div class="text-muted">
                                                    By: <span class="fw-semibold">{{ $item->userCreate->name ?? 'Unknown' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('operasi.pelayanan.laporan-anastesi.show', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                            class="btn btn-info btn-sm px-3">
                                            <i class="fas fa-eye me-1"></i>
                                            Lihat
                                        </a>

                                        <a href="{{ route('operasi.pelayanan.laporan-anastesi.edit', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                            class="btn btn-sm btn-secondary">
                                            <i class="fas fa-edit"></i>
                                            Edit
                                        </a>
                                    </div>
                                </li>
                            @empty
                                <li class="list-group-item text-center">
                                    Tidak ada laporan anestesi yang ditemukan.
                                </li>
                            @endforelse
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
@endpush
