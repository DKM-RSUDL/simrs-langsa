@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .badge-success {
            background-color: #28a745;
            color: white;
        }
        .badge-info {
            background-color: #17a2b8;
            color: white;
        }
        .badge-warning {
            background-color: #ffc107;
            color: black;
        }
        .badge-danger {
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
                                    <form method="GET" action="{{ route('rawat-inap.surveilans-ppi.a2.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}">
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
                                                <a href="{{ route('rawat-inap.surveilans-ppi.a2.create', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                                    class="btn btn-primary">
                                                    <i class="ti-plus"></i> Tambah Surveilans A2
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
                                                    <th width="20%">Diagnosa Akhir</th>
                                                    <th width="15%">Jenis Operasi</th>
                                                    <th width="15%">Petugas</th>
                                                    <th width="15%">Status</th>
                                                    <th width="15%">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($dataSurveilans as $index => $data)
                                                    <tr>
                                                        <td class="text-center">{{ $dataSurveilans->firstItem() + $index }}</td>
                                                        <td>
                                                            {{ $data->tanggal_implementasi ? \Carbon\Carbon::parse($data->tanggal_implementasi)->format('d/m/Y') : '-' }}
                                                            <br>
                                                            <small class="text-muted">{{ $data->jam_implementasi ?? '-' }}</small>
                                                        </td>
                                                        <td>
                                                            <div class="text-truncate" style="max-width: 150px;" title="{{ $data->diagnosa_akhir }}">
                                                                {{ $data->diagnosa_akhir ?? '-' }}
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="text-truncate" style="max-width: 120px;" title="{{ $data->jenis_operasi }}">
                                                                {{ $data->jenis_operasi ?? '-' }}
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <small>{{ $data->userCreated->name ?? 'N/A' }}</small>
                                                        </td>
                                                        <td>
                                                            @if($data->tanggal_keluar)
                                                                <span class="badge badge-success">Selesai</span>
                                                            @else
                                                                <span class="badge badge-warning">Dalam Perawatan</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                <a href="{{ route('rawat-inap.surveilans-ppi.a2.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $data->id]) }}" 
                                                                    class="btn btn-sm btn-info" title="Lihat Detail">
                                                                    <i class="ti-eye"></i>
                                                                </a>
                                                                
                                                                <a href="{{ route('rawat-inap.surveilans-ppi.a2.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $data->id]) }}" 
                                                                    class="btn btn-sm btn-warning" title="Edit">
                                                                    <i class="ti-pencil"></i>
                                                                </a>
                                                                
                                                                <form method="POST" 
                                                                    action="{{ route('rawat-inap.surveilans-ppi.a2.destroy', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $data->id]) }}" 
                                                                    style="display: inline-block;"
                                                                    onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                                        <i class="ti-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <!-- Modal Detail -->
                                                    <div class="modal fade" id="detailModal{{ $data->id }}" tabindex="-1">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Detail Surveilans PPI A2</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <strong>Tanggal Implementasi:</strong><br>
                                                                            {{ $data->tanggal_implementasi ? \Carbon\Carbon::parse($data->tanggal_implementasi)->format('d/m/Y') : '-' }}
                                                                            {{ $data->jam_implementasi ?? '' }}
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <strong>Tanggal Keluar:</strong><br>
                                                                            {{ $data->tanggal_keluar ? \Carbon\Carbon::parse($data->tanggal_keluar)->format('d/m/Y') : '-' }}
                                                                        </div>
                                                                    </div>
                                                                    <hr>
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <strong>Diagnosa Akhir:</strong><br>
                                                                            {{ $data->diagnosa_akhir ?? '-' }}
                                                                        </div>
                                                                    </div>
                                                                    <hr>
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <strong>Jenis Operasi:</strong><br>
                                                                            {{ $data->jenis_operasi ?? '-' }}
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <strong>Ahli Bedah:</strong><br>
                                                                            {{ $data->ahli_bedah ?? '-' }}
                                                                        </div>
                                                                    </div>
                                                                    <hr>
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <strong>Tipe Operasi:</strong><br>
                                                                            {{ $data->tipe_operasi ?? '-' }}
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <strong>Jenis Luka:</strong><br>
                                                                            {{ $data->jenis_luka ?? '-' }}
                                                                        </div>
                                                                    </div>
                                                                    <hr>
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <strong>Infeksi yang Terjadi:</strong><br>
                                                                            @if($data->bakteremia_sepsis)
                                                                                <span class="badge badge-danger me-1">Bakteremia/Sepsis</span>
                                                                            @endif
                                                                            @if($data->vap)
                                                                                <span class="badge badge-danger me-1">VAP</span>
                                                                            @endif
                                                                            @if($data->infeksi_saluran_kemih)
                                                                                <span class="badge badge-danger me-1">Infeksi Saluran Kemih</span>
                                                                            @endif
                                                                            @if($data->infeksi_luka_operasi)
                                                                                <span class="badge badge-danger me-1">Infeksi Luka Operasi</span>
                                                                            @endif
                                                                            @if($data->dekubitus)
                                                                                <span class="badge badge-danger me-1">Dekubitus</span>
                                                                            @endif
                                                                            @if($data->plebitis)
                                                                                <span class="badge badge-danger me-1">Plebitis</span>
                                                                            @endif
                                                                            @if(!$data->bakteremia_sepsis && !$data->vap && !$data->infeksi_saluran_kemih && !$data->infeksi_luka_operasi && !$data->dekubitus && !$data->plebitis)
                                                                                <span class="text-muted">Tidak ada infeksi tercatat</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <tr>
                                                        <td colspan="7" class="text-center text-muted py-4">
                                                            <i class="ti-clipboard-list-check" style="font-size: 48px; opacity: 0.3;"></i>
                                                            <br>
                                                            Belum ada data surveilans A2
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Pagination -->
                                    @if($dataSurveilans->hasPages())
                                        <div class="d-flex justify-content-center mt-3">
                                            {{ $dataSurveilans->appends(request()->query())->links() }}
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
    // Auto hide alert messages
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 3000);
</script>
@endpush