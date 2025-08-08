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
                                <a href="{{ route('rawat-inap.surveilans-ppi.a1.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                    class="nav-link @if (request()->routeIs('rawat-inap.surveilans-ppi.a1.index')) active @endif">
                                    <i class="bi bi-shield-check me-2"></i>
                                    Surveilans PPI A1
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="{{ route('rawat-inap.surveilans-ppi.a2.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                    class="nav-link @if (request()->routeIs('rawat-inap.surveilans-ppi.a2.index')) active @endif">
                                    <i class="bi bi-shield-plus me-2"></i>
                                    Surveilans PPI A2
                                </a>
                            </li>
                        </ul>

                        {{-- Tab Content --}}
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active">

                                <div class="row">
                                    <form method="GET" action="{{ route('rawat-inap.surveilans-ppi.a1.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}">
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
                                                <a href="{{ route('rawat-inap.surveilans-ppi.a1.create', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                                    class="btn btn-primary">
                                                    <i class="ti-plus"></i> Tambah Surveilans A1
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
                                                    <th width="12%">Cara Dirawat</th>
                                                    <th width="12%">Asal Masuk</th>
                                                    <th width="20%">Faktor Risiko</th>
                                                    <th width="15%">Petugas</th>
                                                    <th width="21%">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($surveilansData as $index => $surveilans)
                                                    @php
                                                        $intraVena = json_decode($surveilans->intra_vena_kateter, true) ?? [];
                                                        $kateter = json_decode($surveilans->kateter, true) ?? [];
                                                        $ventilasi = json_decode($surveilans->ventilasi_mekanik, true) ?? [];
                                                        $lainLain = json_decode($surveilans->lain_lain, true) ?? [];
                                                        
                                                        $faktorRisiko = [];
                                                        if (!empty($intraVena)) $faktorRisiko[] = 'Intra Vena';
                                                        if (!empty($kateter)) $faktorRisiko[] = 'Kateter';
                                                        if (!empty($ventilasi)) $faktorRisiko[] = 'Ventilasi';
                                                        if (!empty($lainLain)) $faktorRisiko[] = 'Lain-lain';
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $surveilansData->firstItem() + $index }}</td>
                                                        <td>
                                                            <div class="fw-bold">
                                                                {{ \Carbon\Carbon::parse($surveilans->tanggal_implementasi)->format('d/m/Y') }}
                                                            </div>
                                                            <small class="text-muted">
                                                                {{ \Carbon\Carbon::parse($surveilans->jam_implementasi)->format('H:i') }} WIB
                                                            </small>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-{{ $surveilans->cara_dirawat == 'Emergency' ? 'danger' : 'info' }}">
                                                                {{ $surveilans->cara_dirawat }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-{{ $surveilans->asal_masuk == 'Rujukan' ? 'warning' : 'success' }}">
                                                                {{ $surveilans->asal_masuk }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            @if(!empty($faktorRisiko))
                                                                @foreach($faktorRisiko as $faktor)
                                                                    <span class="badge bg-primary me-1 mb-1">{{ $faktor }}</span>
                                                                @endforeach
                                                            @else
                                                                <span class="text-muted fst-italic">Tidak ada faktor risiko</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="fw-bold">{{ $surveilans->userCreated->name ?? 'N/A' }}</div>
                                                            @if($surveilans->userUpdated)
                                                                <small class="text-muted">
                                                                    Diupdate: {{ $surveilans->userUpdated->name }}
                                                                </small>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                <a href="{{ route('rawat-inap.surveilans-ppi.a1.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $surveilans->id]) }}"
                                                                   class="btn btn-info btn-sm" title="Lihat Detail">
                                                                    <i class="ti-eye"></i>
                                                                </a>
                                                                <a href="{{ route('rawat-inap.surveilans-ppi.a1.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $surveilans->id]) }}"
                                                                   class="btn btn-warning btn-sm" title="Edit">
                                                                    <i class="ti-pencil"></i>
                                                                </a>
                                                                <button type="button" class="btn btn-danger btn-sm" 
                                                                        onclick="confirmDelete({{ $surveilans->id }})" title="Hapus">
                                                                    <i class="ti-trash"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="7" class="text-center py-4">
                                                            <div class="text-muted">
                                                                <i class="ti-info-alt me-2"></i>
                                                                Belum ada data surveilans PPI A1
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                    @if($surveilansData->hasPages())
                                        <div class="d-flex justify-content-center mt-3">
                                            {{ $surveilansData->links() }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Konfirmasi Delete -->
            <div class="modal fade" id="deleteModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Konfirmasi Hapus</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda yakin ingin menghapus data surveilans ini?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <form id="deleteForm" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
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
            const deleteForm = document.getElementById('deleteForm');
            const deleteUrl = "{{ route('rawat-inap.surveilans-ppi.a1.destroy', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, ':id']) }}";
            deleteForm.action = deleteUrl.replace(':id', id);
            
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }
    </script>
@endpush