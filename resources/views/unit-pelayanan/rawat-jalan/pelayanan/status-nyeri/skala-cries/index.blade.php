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

        .cries-breakdown {
            font-size: 0.8rem;
            color: #6c757d;
            margin-top: 0.25rem;
        }

        .cries-score-item {
            display: inline-block;
            margin-right: 0.5rem;
            padding: 0.1rem 0.3rem;
            background-color: #f8f9fa;
            border-radius: 3px;
            border: 1px solid #dee2e6;
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
                        <ul class="nav nav-tabs" id="statusNyeriTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a href="{{ route('rawat-jalan.status-nyeri.skala-numerik.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                    class="nav-link @if (request()->routeIs('rawat-jalan.status-nyeri.skala-numerik.*')) active @endif">
                                    <i class="bi bi-person-heart me-2"></i>
                                    Skala Numerik
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="{{ route('rawat-jalan.status-nyeri.skala-cries.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                    class="nav-link @if (request()->routeIs('rawat-jalan.status-nyeri.skala-cries.*')) active @endif">
                                    <i class="bi bi-person-heart me-2"></i>
                                    Skala CRIES
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
                                    <form method="GET" action="{{ route('rawat-jalan.status-nyeri.skala-cries.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}">
                                        <div class="row m-3">
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="ti-search"></i>
                                                    </span>
                                                    <input type="text" name="search" class="form-control" placeholder="Cari lokasi nyeri..." value="{{ request('search') }}">
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
                                                <a href="{{ route('rawat-jalan.status-nyeri.skala-cries.create', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
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
                                                    <th>Skor CRIES</th>
                                                    <th>Total Nilai</th>
                                                    <th>Lokasi Nyeri</th>
                                                    <th>Kategori Nyeri</th>
                                                    <th>Petugas</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($dataSkalaCries as $index => $item)
                                                    <tr>
                                                        <td>{{ $dataSkalaCries->firstItem() + $index }}</td>
                                                        <td>
                                                            <div>{{ \Carbon\Carbon::parse($item->tanggal_implementasi)->format('d/m/Y') }}</div>
                                                            <small class="text-muted">{{ date('H:i', strtotime($item->jam_implementasi)) }} WIB</small>
                                                        </td>
                                                        <td>
                                                            <div class="cries-breakdown">
                                                                <span class="cries-score-item">C: {{ $item->crying }}</span>
                                                                <span class="cries-score-item">R: {{ $item->requires }}</span>
                                                                <span class="cries-score-item">I: {{ $item->increased }}</span>
                                                                <span class="cries-score-item">E: {{ $item->expression }}</span>
                                                                <span class="cries-score-item">S: {{ $item->sleepless }}</span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="fs-5 fw-bold text-primary">{{ $item->pain_value }}/10</span>
                                                        </td>
                                                        <td>{{ $item->lokasi_nyeri ?: '-' }}</td>
                                                        <td>
                                                            @php
                                                                $painValue = $item->pain_value;
                                                                if ($painValue == 0) {
                                                                    $kategori = 'Tidak Nyeri';
                                                                    $badgeClass = 'badge-nyeri-tidak';
                                                                } elseif ($painValue >= 1 && $painValue <= 3) {
                                                                    $kategori = 'Nyeri Ringan';
                                                                    $badgeClass = 'badge-nyeri-ringan';
                                                                } elseif ($painValue >= 4 && $painValue <= 7) {
                                                                    $kategori = 'Nyeri Sedang';
                                                                    $badgeClass = 'badge-nyeri-sedang';
                                                                } elseif ($painValue >= 8 && $painValue <= 10) {
                                                                    $kategori = 'Nyeri Berat';
                                                                    $badgeClass = 'badge-nyeri-berat';
                                                                } else {
                                                                    $kategori = 'Invalid';
                                                                    $badgeClass = 'badge-secondary';
                                                                }
                                                            @endphp
                                                            <span class="badge {{ $badgeClass }}">{{ $kategori }}</span>
                                                        </td>
                                                        <td>{{ $item->userCreated->name ?? 'Unknown' }}</td>
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                <a href="{{ route('rawat-jalan.status-nyeri.skala-cries.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                                   class="btn btn-info btn-sm me-2" title="Lihat Detail">
                                                                    <i class="ti-eye"></i>
                                                                </a>
                                                                <a href="{{ route('rawat-jalan.status-nyeri.skala-cries.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                                   class="btn btn-warning btn-sm me-2" title="Edit">
                                                                    <i class="ti-pencil"></i>
                                                                </a>
                                                                <form action="{{ route('rawat-jalan.status-nyeri.skala-cries.destroy', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}" 
                                                                      method="POST" style="display: inline;" 
                                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus data CRIES tanggal {{ \Carbon\Carbon::parse($item->tanggal_implementasi)->format('d/m/Y') }} jam {{ $item->jam_implementasi }}?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                                        <i class="ti-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="8" class="text-center text-muted">
                                                            <div class="py-4">
                                                                <i class="ti-search fs-1 text-muted"></i>
                                                                <div class="mt-2">Belum ada data skala CRIES</div>
                                                                <small>Klik tombol "Tambah" untuk menambah data baru</small>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                    {{-- Pagination --}}
                                    @if($dataSkalaCries->hasPages())
                                        <div class="d-flex justify-content-center mt-3">
                                            {{ $dataSkalaCries->withQueryString()->links() }}
                                        </div>
                                    @endif

                                    {{-- Summary Info --}}
                                    <div class="mt-3">
                                        <small class="text-muted">
                                            Menampilkan {{ $dataSkalaCries->firstItem() ?? 0 }} sampai {{ $dataSkalaCries->lastItem() ?? 0 }} 
                                            dari {{ $dataSkalaCries->total() }} data
                                        </small>
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

@push('js')
<script>
    $(document).ready(function() {
        // Auto submit form when date filter changes
        $('input[name="dari_tanggal"], input[name="sampai_tanggal"]').on('change', function() {
            $(this).closest('form').submit();
        });

        // Confirm delete with more context
        $('form[method="POST"]').on('submit', function(e) {
            const form = $(this);
            if (form.find('input[name="_method"][value="DELETE"]').length > 0) {
                const confirmText = form.find('button[type="submit"]').attr('onclick');
                if (confirmText && !confirmText.includes('confirm(')) {
                    e.preventDefault();
                    if (confirm('Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.')) {
                        form.off('submit').submit();
                    }
                }
            }
        });

        // Tooltip initialization if using Bootstrap tooltips
        $('[title]').tooltip();
    });
</script>
@endpush