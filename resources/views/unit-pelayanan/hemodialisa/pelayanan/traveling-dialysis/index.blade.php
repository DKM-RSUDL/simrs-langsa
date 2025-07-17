@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .table th {
            background-color: #e3f2fd;
            color: #1976d2;
            font-weight: 600;
            border-bottom: 2px solid #1976d2;
        }
        
        .btn-action {
            margin: 0 2px;
            padding: 5px 8px;
            font-size: 12px;
        }
        
        .table-responsive {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .table {
            margin-bottom: 0;
        }
        
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #6c757d;
        }
        
        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }
        
        .serologic-tests .test-item {
            margin-bottom: 4px;
        }
        
        .serologic-tests .badge {
            font-size: 10px;
            padding: 3px 6px;
        }
        
        .badge-success {
            background-color: #28a745;
        }
        
        .badge-danger {
            background-color: #dc3545;
        }
        
        .serologic-tests small {
            font-size: 9px;
            margin-left: 5px;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            @include('unit-pelayanan.hemodialisa.component.navigation')

            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">

                        <!-- Header -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="mb-0">Data Traveling Dialysis</h4>
                            <a href="{{ route('hemodialisa.pelayanan.traveling-dialysis.create', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                class="btn btn-primary">
                                <i class="ti-plus"></i> Tambah Data
                            </a>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="10%">Date Dialysis</th>
                                        <th width="15%">Diagnosis</th>
                                        <th width="15%">Pre –Dialysis</th>
                                        <th width="15%">Post –Dialysis</th>
                                        <th width="15%">Serologic Test</th>
                                        <th width="15%">User Created</th>
                                        <th width="10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($dataTravelingDialysis as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                {{ $item->date_first_dialysis ? \Carbon\Carbon::parse($item->date_first_dialysis)->format('d/m/Y') : '-' }}
                                                @if($item->time_first_dialysis)
                                                    <br>
                                                    <small class="text-muted">{{ \Carbon\Carbon::parse($item->time_first_dialysis)->format('H:i') }}</small>
                                                @endif
                                            </td>
                                            <td>{{ $item->diagnosis ?? '-' }}</td>
                                            <td>{{ $item->pre_dialysis_bp ?? '-' }} mmHg</td>
                                            <td>{{ $item->post_dialysis_bp ?? '-' }} mmHg</td>
                                            <td>
                                                <div class="serologic-tests">
                                                    @if($item->hbsag_result || $item->anti_hcv_result || $item->anti_hiv_result)
                                                        @if($item->hbsag_result)
                                                            <div class="test-item mb-1">
                                                                <span class="badge {{ $item->hbsag_result == 'Reactive (+)' ? 'badge-danger' : 'badge-success' }} me-1">
                                                                    HbsAg: {{ $item->hbsag_result }}
                                                                </span>
                                                                @if($item->hbsag_date)
                                                                    <small class="text-muted d-block">{{ \Carbon\Carbon::parse($item->hbsag_date)->format('d/m/Y') }}</small>
                                                                @endif
                                                            </div>
                                                        @endif
                                                        
                                                        @if($item->anti_hcv_result)
                                                            <div class="test-item mb-1">
                                                                <span class="badge {{ $item->anti_hcv_result == 'Reactive (+)' ? 'badge-danger' : 'badge-success' }} me-1">
                                                                    Anti HCV: {{ $item->anti_hcv_result }}
                                                                </span>
                                                                @if($item->anti_hcv_date)
                                                                    <small class="text-muted d-block">{{ \Carbon\Carbon::parse($item->anti_hcv_date)->format('d/m/Y') }}</small>
                                                                @endif
                                                            </div>
                                                        @endif
                                                        
                                                        @if($item->anti_hiv_result)
                                                            <div class="test-item mb-1">
                                                                <span class="badge {{ $item->anti_hiv_result == 'Reactive (+)' ? 'badge-danger' : 'badge-success' }} me-1">
                                                                    Anti HIV: {{ $item->anti_hiv_result }}
                                                                </span>
                                                                @if($item->anti_hiv_date)
                                                                    <small class="text-muted d-block">{{ \Carbon\Carbon::parse($item->anti_hiv_date)->format('d/m/Y') }}</small>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                {{ $item->userCreated->name ?? 'Unknown' }}
                                                <br>
                                                <small class="text-muted">{{ $item->created_at ? $item->created_at->format('d/m/Y H:i') : '-' }}</small>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-wrap gap-1">
                                                    <a href="{{ route('hemodialisa.pelayanan.traveling-dialysis.show', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                        class="btn btn-info btn-sm" title="Lihat Detail">
                                                        <i class="ti-eye"></i>
                                                    </a>
                                                    <a href="{{ route('hemodialisa.pelayanan.traveling-dialysis.edit', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                        class="btn btn-warning btn-sm" title="Edit">
                                                        <i class="ti-pencil"></i>
                                                    </a>
                                                </div>
                                                <div class="d-flex flex-wrap gap-1 mt-1">
                                                    <a href="{{ route('hemodialisa.pelayanan.traveling-dialysis.print-pdf', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                        class="btn btn-secondary btn-sm" title="Print PDF" target="_blank">
                                                        <i class="ti-printer"></i>
                                                    </a>
                                                    <form action="{{ route('hemodialisa.pelayanan.traveling-dialysis.destroy', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                        method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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
                                            <td colspan="8" class="empty-state">
                                                <i class="ti-clipboard"></i>
                                                <h5>Belum ada data traveling dialysis</h5>
                                                <p class="mb-0">Klik tombol "Tambah Data" untuk menambahkan data baru</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script>
        // Auto refresh success message
        @if(session('success'))
            setTimeout(function() {
                $('.alert-success').fadeOut('slow');
            }, 3000);
        @endif
        
        @if(session('error'))
            setTimeout(function() {
                $('.alert-danger').fadeOut('slow');
            }, 5000);
        @endif
    </script>
@endpush