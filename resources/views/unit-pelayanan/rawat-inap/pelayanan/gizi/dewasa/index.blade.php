@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .badge-success {
            background-color: #28a745;
        }
        
        .badge-danger {
            background-color: #dc3545;
        }
        
        .badge-warning {
            background-color: #ffc107;
            color: #212529;
        }
        
        .badge-info {
            background-color: #17a2b8;
        }
        
        .verification-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }
        
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }
        
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #6c757d;
        }
        
        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }
        
        .nav-link.active {
            background-color: #007bff !important;
            color: white !important;
        }

        .status-progress {
            font-size: 0.7rem;
            margin-top: 2px;
        }

        .progress-mini {
            height: 8px;
            margin-top: 3px;
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
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a href="{{ route('rawat-inap.gizi.anak.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}" class="nav-link" aria-selected="false">
                                    Pengkajian Gizi Anak
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="{{ route('rawat-inap.gizi.dewasa.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}" class="nav-link active" aria-selected="true">
                                    Pengkajian Gizi Dewasa
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="{{ route('rawat-inap.gizi.monitoring.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}" class="nav-link" aria-selected="true">
                                    Monitoring dan Evaluasi
                                </a>
                            </li>
                        </ul>

                        {{-- Tab Content --}}
                        <div class="tab-content mt-3">
                            <div class="tab-pane fade show active">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h6 class="mb-0">Data Pengkajian Gizi Dewasa</h6>
                                        <small class="text-muted">Riwayat pengkajian gizi untuk pasien dewasa</small>
                                    </div>
                                    <a href="{{ route('rawat-inap.gizi.dewasa.create', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                        class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus"></i> Tambah
                                    </a>
                                </div>

                                @if($dataPengkajianGiziDewasa->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead class="table-light">
                                                <tr>
                                                    <th width="5%">No</th>
                                                    <th width="15%">Waktu Asesmen</th>
                                                    <th width="20%">Diagnosis Medis</th>
                                                    <th width="15%">IMT</th>
                                                    <th width="15%">BB/TB</th>
                                                    <th width="10%">Kalori</th>
                                                    <th width="10%">Petugas</th>
                                                    <th width="10%">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($dataPengkajianGiziDewasa as $index => $data)
                                                    <tr>
                                                        <td class="text-center">{{ $index + 1 }}</td>
                                                        <td>
                                                            <div class="fw-bold">
                                                                {{ \Carbon\Carbon::parse($data->waktu_asesmen)->format('d/m/Y') }}
                                                            </div>
                                                            <small class="text-muted">
                                                                {{ \Carbon\Carbon::parse($data->waktu_asesmen)->format('H:i') }}
                                                            </small>
                                                        </td>
                                                        <td>
                                                            {{ $data->diagnosis_medis ?: '-' }}
                                                        </td>
                                                        <td>
                                                            @if($data->asesmenGizi && $data->asesmenGizi->imt)
                                                                <span class="badge 
                                                                    @if($data->asesmenGizi->imt < 18.5) bg-warning
                                                                    @elseif($data->asesmenGizi->imt >= 18.5 && $data->asesmenGizi->imt < 25) bg-success
                                                                    @elseif($data->asesmenGizi->imt >= 25 && $data->asesmenGizi->imt < 30) bg-warning
                                                                    @else bg-danger
                                                                    @endif">
                                                                    {{ number_format((float)$data->asesmenGizi->imt, 1, '.', '') }}
                                                                </span>
                                                                <br>
                                                                <small class="text-muted">
                                                                    @if($data->asesmenGizi->imt < 18.5) Underweight
                                                                    @elseif($data->asesmenGizi->imt >= 18.5 && $data->asesmenGizi->imt < 25) Normal
                                                                    @elseif($data->asesmenGizi->imt >= 25 && $data->asesmenGizi->imt < 30) Overweight
                                                                    @else Obesitas
                                                                    @endif
                                                                </small>
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($data->asesmenGizi)
                                                                <small>
                                                                    BB: {{ $data->asesmenGizi->berat_badan ? number_format((float)$data->asesmenGizi->berat_badan, 1, '.', '') : '-' }} kg<br>
                                                                    TB: {{ $data->asesmenGizi->tinggi_badan ? number_format((float)$data->asesmenGizi->tinggi_badan, 1, '.', '') : '-' }} cm
                                                                </small>
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($data->intervensiGizi && $data->intervensiGizi->kebutuhan_kalori)
                                                                <span class="badge bg-info">
                                                                    {{ number_format($data->intervensiGizi->kebutuhan_kalori, 0, '.', '') }}
                                                                </span>
                                                                <br>
                                                                <small class="text-muted">Kkal</small>
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <small>
                                                                {{ $data->userCreate->name ?? 'Tidak Diketahui' }}<br>
                                                                <span class="text-muted">
                                                                    {{ \Carbon\Carbon::parse($data->created_at)->format('d/m/Y H:i') }}
                                                                </span>
                                                            </small>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                <a href="{{ route('rawat-inap.gizi.dewasa.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $data->id]) }}" 
                                                                   class="btn btn-info btn-sm" 
                                                                   title="Lihat">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                                <a href="{{ route('rawat-inap.gizi.dewasa.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $data->id]) }}" 
                                                                   class="btn btn-warning btn-sm" 
                                                                   title="Edit">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <form action="{{ route('rawat-inap.gizi.dewasa.destroy', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $data->id]) }}" 
                                                                      method="POST" 
                                                                      style="display: inline;"
                                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" 
                                                                            class="btn btn-danger btn-sm" 
                                                                            title="Hapus">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="empty-state">
                                        <i class="fas fa-user-md"></i>
                                        <h5>Belum Ada Data Pengkajian Gizi Dewasa</h5>
                                        <p class="mb-3">Belum ada data pengkajian gizi dewasa yang tersimpan untuk pasien ini.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show position-fixed" style="top: 20px; right: 20px; z-index: 1050;" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show position-fixed" style="top: 20px; right: 20px; z-index: 1050;" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
@endsection

@push('js')
<script>
    // Auto hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').alert('close');
    }, 5000);
</script>
@endpush