@extends('layouts.administrator.master')
@include('unit-pelayanan.gawat-darurat.action-gawat-darurat.resiko-jatuh.skala-morse.include')
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
            @include('components.navigation')

            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        {{-- Tabs --}}
                        <ul class="nav nav-tabs" id="skalaMorseTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a href="{{ route('resiko-jatuh.morse.index', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}"
                                    class="nav-link @if (request()->routeIs('resiko-jatuh.morse.index')) active @endif">
                                    <i class="bi bi-person-heart me-2"></i>
                                    Skala Morse
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="{{ route('resiko-jatuh.humpty-dumpty.index', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}"
                                    class="nav-link @if (request()->routeIs('resiko-jatuh.humpty-dumpty.index')) active @endif">
                                    <i class="bi bi-person-heart me-2"></i>
                                    Humpty Dumpty
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="{{ route('resiko-jatuh.geriatri.index', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                    class="nav-link @if (request()->routeIs('resiko-jatuh.geriatri.index')) active @endif">
                                    <i class="bi bi-person-heart me-2"></i>
                                    Skala Geriatri
                                </a>
                            </li>
                        </ul>

                        {{-- Tab Content --}}
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active">
                                {{-- TAB 1. List Data Skala Morse --}}
                                <div class="row">
                                    <div class="d-flex justify-content-between m-3">
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
                                            <div class="col-md-4">
                                                <form method="GET" action="{{ request()->fullUrl() }}">
                                                    @foreach(request()->except(['search', 'page']) as $key => $value)
                                                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                                    @endforeach
                                                    <div class="input-group">
                                                        <input type="text" name="search" class="form-control"
                                                            placeholder="Cari nama petugas" aria-label="Cari"
                                                            value="{{ request('search') }}" aria-describedby="basic-addon1">
                                                        <button type="submit" class="btn btn-primary">Cari</button>
                                                    </div>
                                                </form>
                                            </div>

                                            <div class="col-md-2">
                                                <a href="{{ route('resiko-jatuh.morse.create', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                                    class="btn btn-primary">
                                                    <i class="ti-plus"></i> Tambah
                                                </a>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm table-hover">
                                            <thead class="table-primary">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tanggal</th>
                                                    <th>Hari Ke</th>
                                                    <th>Shift</th>
                                                    <th>Skor Total</th>
                                                    <th>Kategori Resiko</th>
                                                    <th>Petugas</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($skalaMorseData as $index => $item)
                                                    <tr>
                                                        <td>{{ $skalaMorseData->firstItem() + $index }}</td>
                                                        <td>{{ $item->tanggal_formatted }}</td>
                                                        <td>{{ $item->hari_ke }}</td>
                                                        <td>{{ $item->shift_name }}</td>
                                                        <td>
                                                            <span class="fw-bold fs-5">{{ $item->skor_total }}</span>
                                                        </td>
                                                        <td>{!! $item->kategori_resiko_with_badge !!}</td>
                                                        <td>{{ str()->title($item->userCreate->name ?? 'Tidak Diketahui') }}</td>
                                                        <td>
                                                            <div class="btn-group" role="group">

                                                                <a href="{{ route('resiko-jatuh.morse.show', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                                    class="btn btn-info btn-sm ms-1" title="Detail">
                                                                    <i class="ti-eye"></i>
                                                                </a>

                                                                <a href="{{ route('resiko-jatuh.morse.edit', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                                    class="btn btn-warning btn-sm ms-1" title="Edit">
                                                                    <i class="ti-pencil"></i>
                                                                </a>

                                                                <form
                                                                    action="{{ route('resiko-jatuh.morse.destroy', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                                    method="POST" class="delete-form ms-1"
                                                                    style="display: inline;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                                        title="Hapus">
                                                                        <i class="ti-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="8" class="text-center">Tidak ada data Skala Morse</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>

                                        <!-- Pagination -->
                                        <div class="d-flex justify-content-end">
                                            {{ $skalaMorseData->links() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
