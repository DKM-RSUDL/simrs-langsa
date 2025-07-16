@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .badge-nyeri-tidak {
            background-color: #28a745;
            color: white;
        }
        .badge-nyeri-ringan {
            background-color: #17a2b8;
            color: white;
        }
        .badge-nyeri-sedang {
            background-color: #ffc107;
            color: black;
        }
        .badge-nyeri-berat {
            background-color: #fd7e14;
            color: white;
        }
        .badge-nyeri-sangat-berat {
            background-color: #dc3545;
            color: white;
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
                        {{-- Tabs --}}
                        <ul class="nav nav-tabs" id="skalaMorseTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a href="{{ route('rawat-inap.status-nyeri.skala-numerik.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                    class="nav-link @if (request()->routeIs('rawat-inap.status-nyeri.skala-numerik.index')) active @endif">
                                    <i class="bi bi-person-heart me-2"></i>
                                    Skala Numerik
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="#"
                                    class="nav-link">
                                    <i class="bi bi-person-heart me-2"></i>
                                    Skala Numerik 2
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="#"
                                    class="nav-link">
                                    <i class="bi bi-person-heart me-2"></i>
                                    Skala Numerik 3
                                </a>
                            </li>
                        </ul>

                        {{-- Tab Content --}}
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active">

                                <div class="row">
                                    <form method="GET" action="{{ route('rawat-inap.status-nyeri.skala-numerik.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}">
                                        <div class="row m-3">
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="ti-search"></i>
                                                    </span>
                                                    <input type="text" name="search" class="form-control" placeholder="Cari data..." value="{{ request('search') }}">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-2">
                                                <input type="date" name="dari_tanggal" class="form-control" placeholder="Dari Tanggal" value="{{ request('dari_tanggal') }}">
                                            </div>
                                            
                                            <div class="col-md-2">
                                                <input type="date" name="sampai_tanggal" class="form-control" placeholder="Sampai Tanggal" value="{{ request('sampai_tanggal') }}">
                                            </div>
                                            
                                            <div class="col-md-2">
                                                <button class="btn btn-outline-secondary" type="submit">
                                                    <i class="ti-filter"></i> Filter
                                                </button>
                                            </div>
                                            
                                            <div class="col-md-3 text-end">
                                                <a href="{{ route('rawat-inap.status-nyeri.skala-numerik.create', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                                    class="btn btn-primary">
                                                    <i class="ti-plus"></i> Tambah
                                                </a>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm table-hover">
                                            <thead class="table-primary">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tanggal & Jam</th>
                                                    <th>Skala Nyeri</th>
                                                    <th>Nilai Nyeri</th>
                                                    <th>Lokasi Nyeri</th>
                                                    <th>Kategori Nyeri</th>
                                                    <th>Petugas</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($dataSkalaNumerik as $index => $item)
                                                    <tr>
                                                        <td>{{ $dataSkalaNumerik->firstItem() + $index }}</td>
                                                        <td>
                                                            {{ \Carbon\Carbon::parse($item->tanggal_implementasi)->format('d/m/Y') }}<br>
                                                            <small class="text-muted">{{ date('H:i', strtotime($item->jam_implementasi)) }}</small>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-info text-white">
                                                                {{ ucfirst(str_replace('_', ' ', $item->pain_scale_type)) }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="fs-5 fw-bold text-primary">{{ $item->pain_value }}/10</span>
                                                        </td>
                                                        <td>{{ $item->lokasi_nyeri }}</td>
                                                        <td>
                                                            @php
                                                                $painValue = $item->pain_value;
                                                                if ($painValue == 0) {
                                                                    $kategori = 'Tidak Nyeri';
                                                                    $badgeClass = 'badge-nyeri-tidak';
                                                                } elseif ($painValue >= 1 && $painValue <= 3) {
                                                                    $kategori = 'Ringan';
                                                                    $badgeClass = 'badge-nyeri-ringan';
                                                                } elseif ($painValue >= 4 && $painValue <= 6) {
                                                                    $kategori = 'Sedang';
                                                                    $badgeClass = 'badge-nyeri-sedang';
                                                                } elseif ($painValue >= 7 && $painValue <= 9) {
                                                                    $kategori = 'Berat';
                                                                    $badgeClass = 'badge-nyeri-berat';
                                                                } else {
                                                                    $kategori = 'Sangat Berat';
                                                                    $badgeClass = 'badge-nyeri-sangat-berat';
                                                                }
                                                            @endphp
                                                            <span class="badge {{ $badgeClass }}">{{ $kategori }}</span>
                                                        </td>
                                                        <td>
                                                            {{ $item->userCreated->name ?? 'N/A' }}<br>
                                                            <small class="text-muted">{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i') }}</small>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                <a href="{{ route('rawat-inap.status-nyeri.skala-numerik.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}" 
                                                                class="btn btn-sm btn-outline-info" title="Lihat Detail">
                                                                    <i class="ti-eye"></i>
                                                                </a>
                                                                <a href="{{ route('rawat-inap.status-nyeri.skala-numerik.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}" 
                                                                class="btn btn-sm btn-outline-warning" title="Edit">
                                                                    <i class="ti-pencil"></i>
                                                                </a>
                                                                <form method="POST" 
                                                                    action="{{ route('rawat-inap.status-nyeri.skala-numerik.destroy', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}" 
                                                                    style="display: inline-block;"
                                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                                        <i class="ti-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="8" class="text-center">
                                                            <div class="d-flex flex-column align-items-center justify-content-center py-4">
                                                                <i class="ti-clipboard fs-1 text-muted mb-2"></i>
                                                                <p class="text-muted mb-0">Belum ada data skala numerik</p>
                                                                <small class="text-muted">Klik tombol "Tambah" untuk membuat data baru</small>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                    {{-- Pagination --}}
                                    @if($dataSkalaNumerik->hasPages())
                                        <div class="d-flex justify-content-center">
                                            {{ $dataSkalaNumerik->appends(request()->query())->links() }}
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
@endpush