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
        
        .score-display {
            font-size: 1.2rem;
            font-weight: bold;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
        }
        
        .score-0 { background-color: #28a745; color: white; }
        .score-1, .score-2, .score-3 { background-color: #17a2b8; color: white; }
        .score-4, .score-5, .score-6, .score-7 { background-color: #ffc107; color: black; }
        .score-8, .score-9, .score-10 { background-color: #dc3545; color: white; }
        
        .table td {
            vertical-align: middle;
        }
        
        .btn-sm {
            padding: 0.25rem 0.5rem;
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
            @include('components.navigation-rajal')

            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        {{-- Tabs --}}
                        <ul class="nav nav-tabs" id="skalaMorseTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a href="{{ route('rawat-jalan.status-nyeri.skala-numerik.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                    class="nav-link @if (request()->routeIs('rawat-jalan.status-nyeri.skala-numerik.index')) active @endif">
                                    <i class="bi bi-person-heart me-2"></i>
                                    Skala Numerik
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="{{ route('rawat-jalan.status-nyeri.skala-cries.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                    class="nav-link @if (request()->routeIs('rawat-jalan.status-nyeri.skala-cries.index')) active @endif">
                                    <i class="bi bi-person-heart me-2"></i>
                                    Skala Cries
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="{{ route('rawat-jalan.status-nyeri.skala-flacc.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                    class="nav-link @if (request()->routeIs('rawat-jalan.status-nyeri.skala-flacc.*')) active @endif ">
                                    <i class="bi bi-person-heart me-2"></i>
                                    Skala FLACC
                                </a>
                            </li>
                        </ul>

                        {{-- Tab Content --}}
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active">

                                <div class="row">
                                    <form method="GET" action="{{ route('rawat-jalan.status-nyeri.skala-flacc.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}">
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
                                                <a href="{{ route('rawat-jalan.status-nyeri.skala-flacc.create', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
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
                                                @forelse($dataSkalaFlacc as $key => $flacc)
                                                    <tr>
                                                        <td>{{ $dataSkalaFlacc->firstItem() + $key }}</td>
                                                        <td>
                                                            <div class="fw-bold">
                                                                {{ \Carbon\Carbon::parse($flacc->tanggal_implementasi)->format('d/m/Y') }}
                                                            </div>
                                                            <small class="text-muted">{{ date('H:i', strtotime($flacc->jam_implementasi)) }}</small>
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="badge bg-info text-white">FLACC</span>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="score-display score-{{ $flacc->pain_value }}">
                                                                {{ $flacc->pain_value }}
                                                            </div>
                                                        </td>
                                                        <td>{{ $flacc->lokasi_nyeri }}</td>
                                                        <td>
                                                            @if($flacc->pain_value == 0)
                                                                <span class="badge badge-nyeri-tidak">Tidak Nyeri</span>
                                                            @elseif($flacc->pain_value >= 1 && $flacc->pain_value <= 3)
                                                                <span class="badge badge-nyeri-ringan">Nyeri Ringan</span>
                                                            @elseif($flacc->pain_value >= 4 && $flacc->pain_value <= 7)
                                                                <span class="badge badge-nyeri-sedang">Nyeri Sedang</span>
                                                            @elseif($flacc->pain_value >= 8 && $flacc->pain_value <= 10)
                                                                <span class="badge badge-nyeri-berat">Nyeri Berat</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="fw-bold">{{ $flacc->userCreated->name ?? 'N/A' }}</div>
                                                            <small class="text-muted">
                                                                {{ $flacc->created_at ? $flacc->created_at->format('d/m/Y H:i') : '-' }}
                                                            </small>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                <a href="{{ route('rawat-jalan.status-nyeri.skala-flacc.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $flacc->id]) }}"
                                                                    class="btn btn-info btn-sm me-2"
                                                                    title="Lihat Detail">
                                                                    <i class="ti-eye"></i>
                                                                </a>
                                                                <a href="{{ route('rawat-jalan.status-nyeri.skala-flacc.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $flacc->id]) }}"
                                                                    class="btn btn-warning btn-sm me-2"
                                                                    title="Edit">
                                                                    <i class="ti-pencil"></i>
                                                                </a>
                                                                <form action="{{ route('rawat-jalan.status-nyeri.skala-flacc.destroy', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $flacc->id]) }}"
                                                                    method="POST" 
                                                                    style="display: inline-block;"
                                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus data Skala FLACC tanggal {{ \Carbon\Carbon::parse($flacc->tanggal_implementasi)->format('d/m/Y') }} jam {{ $flacc->jam_implementasi }}?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" 
                                                                        class="btn btn-danger btn-sm"
                                                                        title="Hapus">
                                                                        <i class="ti-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="8" class="text-center py-4">
                                                            <div class="d-flex flex-column align-items-center">
                                                                <i class="ti-info-circle fs-1 text-muted mb-2"></i>
                                                                <h5 class="text-muted">Belum Ada Data</h5>
                                                                <p class="text-muted">Data Skala FLACC belum tersedia. Silakan tambah data baru.</p>
                                                                <a href="{{ route('rawat-jalan.status-nyeri.skala-flacc.create', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                                                    class="btn btn-primary">
                                                                    <i class="ti-plus"></i> Tambah Data Pertama
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                    {{-- Pagination --}}
                                    @if($dataSkalaFlacc->hasPages())
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <div class="showing-info">
                                                <small class="text-muted">
                                                    Menampilkan {{ $dataSkalaFlacc->firstItem() }} sampai {{ $dataSkalaFlacc->lastItem() }} 
                                                    dari {{ $dataSkalaFlacc->total() }} data
                                                </small>
                                            </div>
                                            <div class="pagination-wrapper">
                                                {{ $dataSkalaFlacc->appends(request()->query())->links() }}
                                            </div>
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
        // Auto-submit form when date filter changes
        $('input[name="dari_tanggal"], input[name="sampai_tanggal"]').on('change', function() {
            // Optional: Auto submit when date changes
            // $(this).closest('form').submit();
        });

        // Tooltip for buttons
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endpush