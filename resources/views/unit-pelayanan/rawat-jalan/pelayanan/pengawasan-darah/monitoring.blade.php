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
            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        {{-- Tabs --}}
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a href="?tab=pengelolaan" class="nav-link" aria-selected="false">
                                    Pengelolaan
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="?tab=monitoring" class="nav-link active" aria-selected="true">
                                    Monitoring
                                </a>
                            </li>
                        </ul>

                        {{-- Tab Content --}}
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active">
                                {{-- TAB 2. Monitoring --}}
                                <div class="row">
                                    <div class="d-flex justify-content-between m-3">
                                        <div class="row w-100">
                                            <div class="col-md-8">
                                                <h6 class="mb-0">Data Monitoring Transfusi Darah</h6>
                                                <small class="text-muted">Pengisian dapat dilakukan secara bertahap</small>
                                            </div>
                                            <div class="col-md-4 text-end">
                                                <a href="{{ route('rawat-jalan.pengawasan-darah.print', [
                                                    'kd_unit' => $dataMedis->kd_unit,
                                                    'kd_pasien' => $dataMedis->kd_pasien,
                                                    'tgl_masuk' => date('Y-m-d', strtotime($dataMedis->tgl_masuk)),
                                                    'urut_masuk' => $dataMedis->urut_masuk
                                                ]) }}" class="btn btn-success btn-sm me-2" target="_blank">
                                                    <i class="bi bi-printer"></i> Print
                                                </a>
                                                <a href="{{ route('rawat-jalan.pengawasan-darah.monitoring.create', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                                    class="btn btn-primary btn-sm">
                                                    <i class="ti-plus"></i> Tambah
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Data Table --}}
                                @if(isset($monitoringDarah) && $monitoringDarah->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm table-hover">
                                            <thead class="table-primary">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tanggal</th>
                                                    <th>Waktu</th>
                                                    <th>Jam Transfusi</th>
                                                    <th>Vital Sign</th>
                                                    <th>Reaksi</th>
                                                    <th>Petugas</th>
                                                    <th>Status Kelengkapan</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($monitoringDarah as $index => $data)
                                                    @php
                                                        // Hitung kelengkapan data - Total 25 field
                                                        $filledFields = 0;
                                                        $totalFields = 25;
                                                        
                                                        // Field dasar (4 field)
                                                        if($data->tanggal) $filledFields++;
                                                        if($data->jam) $filledFields++;
                                                        if($data->jam_mulai_transfusi) $filledFields++;
                                                        if($data->jam_selesai_transfusi) $filledFields++;
                                                        
                                                        // Vital sign pre transfusi (5 field)
                                                        if($data->pre_td_sistole) $filledFields++;
                                                        if($data->pre_td_diastole) $filledFields++;
                                                        if($data->pre_nadi) $filledFields++;
                                                        if($data->pre_temp) $filledFields++;
                                                        if($data->pre_rr) $filledFields++;
                                                        
                                                        // Vital sign post 15 menit (5 field)
                                                        if($data->post15_td_sistole) $filledFields++;
                                                        if($data->post15_td_diastole) $filledFields++;
                                                        if($data->post15_nadi) $filledFields++;
                                                        if($data->post15_temp) $filledFields++;
                                                        if($data->post15_rr) $filledFields++;
                                                        
                                                        // Vital sign post 1 jam (5 field)
                                                        if($data->post1h_td_sistole) $filledFields++;
                                                        if($data->post1h_td_diastole) $filledFields++;
                                                        if($data->post1h_nadi) $filledFields++;
                                                        if($data->post1h_temp) $filledFields++;
                                                        if($data->post1h_rr) $filledFields++;
                                                        
                                                        // Vital sign post 4 jam (5 field)
                                                        if($data->post4h_td_sistole) $filledFields++;
                                                        if($data->post4h_td_diastole) $filledFields++;
                                                        if($data->post4h_nadi) $filledFields++;
                                                        if($data->post4h_temp) $filledFields++;
                                                        if($data->post4h_rr) $filledFields++;
                                                        
                                                        // Petugas (2 field) - hanya jika ada nilai
                                                        if($data->dokter) $filledFields++;
                                                        if($data->perawat) $filledFields++;
                                                        
                                                        // Pastikan tidak melebihi 100%
                                                        $percentage = min(100, round(($filledFields / $totalFields) * 100));
                                                        
                                                        // Tentukan status berdasarkan persentase
                                                        if($percentage >= 90) {
                                                            $statusClass = 'success';
                                                            $statusText = 'Lengkap';
                                                            $statusIcon = 'bi-check-circle-fill';
                                                        } elseif($percentage >= 70) {
                                                            $statusClass = 'warning';
                                                            $statusText = 'Hampir Lengkap';
                                                            $statusIcon = 'bi-exclamation-triangle-fill';
                                                        } elseif($percentage >= 40) {
                                                            $statusClass = 'info';
                                                            $statusText = 'Sebagian';
                                                            $statusIcon = 'bi-info-circle-fill';
                                                        } else {
                                                            $statusClass = 'danger';
                                                            $statusText = 'Minimal';
                                                            $statusIcon = 'bi-x-circle-fill';
                                                        }
                                                    @endphp
                                                    
                                                    <tr>
                                                        <td>{{ $monitoringDarah->firstItem() + $index }}</td>
                                                        <td>{{ date('d/m/Y', strtotime($data->tanggal)) }}</td>
                                                        <td>{{ date('H:i', strtotime($data->jam)) }}</td>
                                                        <td>
                                                            <small>
                                                                @if($data->jam_mulai_transfusi)
                                                                    Mulai: {{ date('H:i', strtotime($data->jam_mulai_transfusi)) }}<br>
                                                                @else
                                                                    Mulai: <span class="text-muted">-</span><br>
                                                                @endif
                                                                @if($data->jam_selesai_transfusi)
                                                                    Selesai: {{ date('H:i', strtotime($data->jam_selesai_transfusi)) }}
                                                                @else
                                                                    Selesai: <span class="text-muted">-</span>
                                                                @endif
                                                            </small>
                                                        </td>
                                                        <td>
                                                            <small>
                                                                @if($data->pre_td_sistole && $data->pre_td_diastole)
                                                                    Pre: {{ $data->pre_td_sistole }}/{{ $data->pre_td_diastole }} mmHg<br>
                                                                @else
                                                                    Pre: <span class="text-muted">-</span><br>
                                                                @endif
                                                                @if($data->post4h_td_sistole && $data->post4h_td_diastole)
                                                                    Post 4h: {{ $data->post4h_td_sistole }}/{{ $data->post4h_td_diastole }} mmHg
                                                                @else
                                                                    Post 4h: <span class="text-muted">-</span>
                                                                @endif
                                                            </small>
                                                        </td>
                                                        <td>
                                                            @if($data->reaksi_selama_transfusi || $data->reaksi_transfusi)
                                                                <span class="badge bg-warning">Ada Reaksi</span>
                                                            @else
                                                                <span class="badge bg-success">Normal</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <small>
                                                                Dokter: {{ $data->dokterRelation->nama ?? '-' }}<br>
                                                                Perawat: {{ $data->perawatRelation->nama ?? '-' }}
                                                            </small>
                                                        </td>
                                                        <td>
                                                            <div class="text-center">
                                                                <span class="badge bg-{{ $statusClass }} d-flex align-items-center justify-content-center mb-1">
                                                                    <i class="bi {{ $statusIcon }} me-1"></i>
                                                                    {{ $statusText }}
                                                                </span>
                                                                <div class="progress progress-mini">
                                                                    <div class="progress-bar bg-{{ $statusClass }}" role="progressbar" 
                                                                         style="width: {{ $percentage }}%" 
                                                                         aria-valuenow="{{ $percentage }}" 
                                                                         aria-valuemin="0" 
                                                                         aria-valuemax="100">
                                                                    </div>
                                                                </div>
                                                                <small class="status-progress text-muted">{{ $percentage }}%</small>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group btn-group-sm" role="group">
                                                                <a href="{{ route('rawat-jalan.pengawasan-darah.monitoring.show', [
                                                                    'kd_unit' => $dataMedis->kd_unit,
                                                                    'kd_pasien' => $dataMedis->kd_pasien,
                                                                    'tgl_masuk' => date('Y-m-d', strtotime($dataMedis->tgl_masuk)),
                                                                    'urut_masuk' => $dataMedis->urut_masuk,
                                                                    'id' => $data->id
                                                                ]) }}" class="btn btn-info btn-sm" title="Lihat Detail">
                                                                    <i class="bi bi-eye"></i>
                                                                </a>
                                                                <a href="{{ route('rawat-jalan.pengawasan-darah.monitoring.edit', [
                                                                    'kd_unit' => $dataMedis->kd_unit,
                                                                    'kd_pasien' => $dataMedis->kd_pasien,
                                                                    'tgl_masuk' => date('Y-m-d', strtotime($dataMedis->tgl_masuk)),
                                                                    'urut_masuk' => $dataMedis->urut_masuk,
                                                                    'id' => $data->id
                                                                ]) }}" class="btn btn-warning btn-sm" title="Edit / Lengkapi Data">
                                                                    <i class="bi bi-pencil"></i>
                                                                </a>
                                                                <form action="{{ route('rawat-jalan.pengawasan-darah.monitoring.destroy', [
                                                                    'kd_unit' => $dataMedis->kd_unit,
                                                                    'kd_pasien' => $dataMedis->kd_pasien,
                                                                    'tgl_masuk' => date('Y-m-d', strtotime($dataMedis->tgl_masuk)),
                                                                    'urut_masuk' => $dataMedis->urut_masuk,
                                                                    'id' => $data->id
                                                                ]) }}" method="POST" class="delete-form d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                                        <i class="bi bi-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        <!-- Pagination -->
                                        <div class="d-flex justify-content-end">
                                            {{ $monitoringDarah->links() }}
                                        </div>
                                    </div>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm table-hover">
                                            <thead class="table-primary">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tanggal</th>
                                                    <th>Waktu</th>
                                                    <th>Jam Transfusi</th>
                                                    <th>Vital Sign</th>
                                                    <th>Reaksi</th>
                                                    <th>Petugas</th>
                                                    <th>Status Kelengkapan</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="9" class="text-center">Tidak ada data Monitoring Transfusi Darah</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
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
        document.addEventListener('DOMContentLoaded', function () {
            // SweetAlert untuk konfirmasi hapus
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: 'Data monitoring transfusi darah ini akan dihapus secara permanen!',
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
        });
    </script>
@endpush