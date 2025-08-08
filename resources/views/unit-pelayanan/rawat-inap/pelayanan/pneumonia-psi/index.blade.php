@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .badge-resiko-rendah {
            background-color: #28a745;
            color: white;
        }
        .badge-resiko-sedang {
            background-color: #ffc107;
            color: black;
        }
        .badge-resiko-sedang-berat {
            background-color: #fd7e14;
            color: white;
        }
        .badge-resiko-berat {
            background-color: #dc3545;
            color: white;
        }
        .badge-resiko-sangat-berat {
            background-color: #6f42c1;
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
                                <a href="{{ route('rawat-inap.pneumonia.psi.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                    class="nav-link @if (request()->routeIs('rawat-inap.pneumonia.psi.*')) active @endif">
                                    <i class="bi bi-shield-check me-2"></i>
                                    Pneumonia Severity Index
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="{{ route('rawat-inap.pneumonia.curb-65.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                    class="nav-link @if (request()->routeIs('rawat-inap.pneumonia.curb-65.*')) active @endif">
                                    <i class="bi bi-shield-plus me-2"></i>
                                    CURB-65
                                </a>
                            </li>
                        </ul>

                        {{-- Tab Content --}}
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active">

                                <div class="row">
                                    <form method="GET" action="{{ route('rawat-inap.pneumonia.psi.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}">
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
                                                <a href="{{ route('rawat-inap.pneumonia.psi.create', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
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
                                                    <th width="5%">No</th>
                                                    <th width="15%">Tanggal & Jam</th>
                                                    <th width="10%">Total Skor</th>
                                                    <th width="12%">Gender/Umur</th>
                                                    <th width="15%">Rekomendasi Perawatan</th>
                                                    <th width="20%">Kriteria Tambahan</th>
                                                    <th width="13%">Petugas</th>
                                                    <th width="20%">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($dataPsi as $index => $item)
                                                    <tr>
                                                        <td class="text-center">{{ $index + 1 }}</td>
                                                        <td>
                                                            <div class="fw-bold">{{ \Carbon\Carbon::parse($item->tanggal_implementasi)->format('d/m/Y') }}</div>
                                                            <small class="text-muted">{{ \Carbon\Carbon::parse($item->jam_implementasi)->format('H:i') }} WIB</small>
                                                        </td>
                                                        <td class="text-center">
                                                            @php
                                                                $badgeClass = 'badge-resiko-rendah';
                                                                if($item->total_skor >= 131) {
                                                                    $badgeClass = 'badge-resiko-sangat-berat';
                                                                } elseif($item->total_skor >= 91) {
                                                                    $badgeClass = 'badge-resiko-berat';
                                                                } elseif($item->total_skor >= 71) {
                                                                    $badgeClass = 'badge-resiko-sedang-berat';
                                                                } elseif($item->total_skor >= 51) {
                                                                    $badgeClass = 'badge-resiko-sedang';
                                                                }
                                                            @endphp
                                                            <span class="badge {{ $badgeClass }} fs-6">{{ $item->total_skor }}</span>
                                                        </td>
                                                        <td>
                                                            @if($item->gender_age == 'male')
                                                                <span class="badge bg-info">Laki-laki</span>
                                                                <br><small class="text-muted">{{ $item->umur_laki ?? 'N/A' }} tahun</small>
                                                            @else
                                                                <span class="badge bg-pink">Perempuan</span>
                                                                <br><small class="text-muted">{{ $item->umur_perempuan ?? 'N/A' }} tahun</small>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="text-wrap">
                                                                {{ $item->rekomendasi_perawatan }}
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="text-wrap">
                                                                {{ $item->kriteria_tambahan ?? '-' }}
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="fw-bold">{{ $item->userCreated->name ?? 'N/A' }}</div>
                                                            <small class="text-muted">{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i') }}</small>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                <a href="{{ route('rawat-inap.pneumonia.psi.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                                    class="btn btn-sm btn-info" title="Lihat Detail">
                                                                    <i class="ti-eye"></i>
                                                                </a>
                                                                <a href="{{ route('rawat-inap.pneumonia.psi.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                                    class="btn btn-sm btn-warning" title="Edit">
                                                                    <i class="ti-pencil"></i>
                                                                </a>
                                                                <button type="button" class="btn btn-sm btn-danger" title="Hapus"
                                                                    onclick="confirmDelete({{ $item->id }})">
                                                                    <i class="ti-trash"></i>
                                                                </button>
                                                            </div>

                                                            <!-- Form Delete (Hidden) -->
                                                            <form id="delete-form-{{ $item->id }}" 
                                                                action="{{ route('rawat-inap.pneumonia.psi.destroy', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}" 
                                                                method="POST" style="display: none;">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="8" class="text-center py-4">
                                                            <div class="text-muted">
                                                                <i class="ti-clipboard fs-1"></i>
                                                                <p class="mt-2">Belum ada data Pneumonia PSI</p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                    @if($dataPsi->isNotEmpty())
                                        <div class="mt-3">
                                            <small class="text-muted">
                                                Total: {{ $dataPsi->count() }} data ditemukan
                                            </small>
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
function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data Pneumonia PSI ini?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush