@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .status-badge {
            font-size: 0.875rem;
            padding: 0.375rem 0.75rem;
        }
        .btn-action {
            margin: 0 2px;
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
                                <a href="?tab=picu" class="nav-link active" aria-selected="true">
                                    Masuk/Keluar PICU
                                </a>
                            </li>
                            {{-- <li class="nav-item" role="presentation">
                                <a href="?tab=monitoring" class="nav-link" aria-selected="true">
                                    Monitoring
                                </a>
                            </li> --}}
                        </ul>

                        {{-- Tab Content --}}
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active">
                                {{-- TAB 1. List Data --}}
                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-end m-3">
                                            @if($dataPICU->isEmpty())
                                                <a href="{{ route('rawat-inap.kriteria-masuk-keluar.picu.create', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                                    class="btn btn-primary">
                                                    <i class="ti-plus"></i> Tambah Data PICU
                                                </a>
                                            @endif
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-bordered table-sm table-hover">
                                                <thead class="table-primary">
                                                    <tr>
                                                        <th width="5%">No</th>
                                                        <th width="15%">Tanggal</th>
                                                        <th width="15%">Jam</th>
                                                        <th width="20%">Dokter</th>
                                                        <th width="15%">Status</th>
                                                        <th width="15%">Petugas</th>
                                                        <th width="15%">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($dataPICU as $index => $item)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                                                            <td>{{ $item->jam }}</td>
                                                            <td>{{ $item->dokter->nama ?? '-' }}</td>
                                                            <td>
                                                                @php
                                                                    $hasMasuk = false;
                                                                    $hasKeluar = false;
                                                                    
                                                                    // Check kriteria masuk
                                                                    $kriteriamasuk = [
                                                                        'kriteria_1_main', 'kriteria_1_rr', 'kriteria_1_sianosis', 'kriteria_1_retraksi',
                                                                        'kriteria_1_merintih', 'kriteria_1_nafas_cuping', 'kriteria_2_main', 'kriteria_2_nadi',
                                                                        'kriteria_2_hr', 'kriteria_2_tekanan_nadi', 'kriteria_2_rr', 'kriteria_2_akral',
                                                                        'kriteria_3', 'kriteria_4', 'kriteria_5', 'kriteria_6_main', 'kriteria_6_takikardia',
                                                                        'kriteria_6_mata', 'kriteria_6_letargi', 'kriteria_6_anuria', 'kriteria_6_malas_minum',
                                                                        'kriteria_7', 'kriteria_8', 'kriteria_9'
                                                                    ];
                                                                    
                                                                    foreach($kriteriamasuk as $kriteria) {
                                                                        if($item->$kriteria) {
                                                                            $hasMasuk = true;
                                                                            break;
                                                                        }
                                                                    }
                                                                    
                                                                    // Check kriteria keluar
                                                                    $kriteriaKeluar = $dataPICU->where('kd_pasien', $item->kd_pasien)
                                                                        ->where('kd_unit', $item->kd_unit)
                                                                        ->where('tgl_masuk', $item->tgl_masuk)
                                                                        ->where('urut_masuk', $item->urut_masuk)
                                                                        ->first();
                                                                    
                                                                    if($kriteriaKeluar) {
                                                                        $kriteriakeluar_fields = [
                                                                            'kriteria_keluar_1', 'kriteria_keluar_2', 'kriteria_keluar_3', 'kriteria_keluar_4',
                                                                            'kriteria_keluar_5', 'kriteria_keluar_6', 'kriteria_keluar_7'
                                                                        ];
                                                                        
                                                                        foreach($kriteriakeluar_fields as $kriteria) {
                                                                            if(isset($kriteriaKeluar->$kriteria) && $kriteriaKeluar->$kriteria) {
                                                                                $hasKeluar = true;
                                                                                break;
                                                                            }
                                                                        }
                                                                    }
                                                                @endphp
                                                                
                                                                @if($hasMasuk && $hasKeluar)
                                                                    <span class="badge bg-success status-badge">Masuk & Keluar</span>
                                                                @elseif($hasMasuk)
                                                                    <span class="badge bg-warning status-badge">Masuk Saja</span>
                                                                @elseif($hasKeluar)
                                                                    <span class="badge bg-info status-badge">Keluar Saja</span>
                                                                @else
                                                                    <span class="badge bg-secondary status-badge">Belum Diisi</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ $item->user->name ?? '-' }}</td>
                                                            <td>
                                                                <div class="btn-group" role="group">
                                                                    <a href="#" 
                                                                       class="btn btn-info btn-sm btn-action" title="Lihat Detail">
                                                                        <i class="ti-eye"></i>
                                                                    </a>
                                                                    <a href="#" 
                                                                       class="btn btn-warning btn-sm btn-action" title="Edit">
                                                                        <i class="ti-pencil"></i>
                                                                    </a>
                                                                    <form action="#" 
                                                                          method="POST" style="display: inline-block;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-danger btn-sm btn-action" 
                                                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')" title="Hapus">
                                                                            <i class="ti-trash"></i>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="7" class="text-center">
                                                                <div class="py-3">
                                                                    <i class="ti-info-alt" style="font-size: 2rem; color: #6c757d;"></i>
                                                                    <p class="mt-2 text-muted">Belum ada data kriteria PICU yang tercatat</p>
                                                                </div>
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
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        // Auto hide success/error messages after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                alert.fadeOut();
            });
        }, 5000);
    </script>
@endpush