@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .badge-setuju {
            background-color: #28a745;
            color: white;
        }
        .badge-menolak {
            background-color: #dc3545;
            color: white;
        }
        .badge-pasien {
            background-color: #17a2b8;
            color: white;
        }
        .badge-keluarga {
            background-color: #ffc107;
            color: black;
        }

        .info-breakdown {
            font-size: 0.75rem;
            color: #6c757d;
            margin-top: 0.25rem;
        }

        .info-item {
            display: inline-block;
            margin-right: 0.3rem;
            padding: 0.1rem 0.2rem;
            background-color: #e9ecef;
            border-radius: 2px;
            font-size: 0.7rem;
        }

        .info-checked {
            background-color: #d4edda;
            color: #155724;
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
                        {{-- Tabs --}}
                        <ul class="nav nav-tabs" id="tindakanHd" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a href="{{ route('hemodialisa.pelayanan.persetujuan.tindakan-hd.index', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                    class="nav-link @if (request()->routeIs('hemodialisa.pelayanan.persetujuan.tindakan-hd.*')) active @endif">
                                    <i class="bi bi-person-heart me-2"></i>
                                    Persetujuan Tindakan HD
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="#"
                                    class="nav-link">
                                    <i class="bi bi-person-heart me-2"></i>
                                    Persetujuan 2
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href=""
                                    class="nav-link">
                                    <i class="bi bi-person-heart me-2"></i>
                                    Persetujuan 3
                                </a>
                            </li>
                        </ul>

                        {{-- Tab Content --}}
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active">

                                <div class="row">
                                    <form method="GET" action="{{ route('hemodialisa.pelayanan.persetujuan.tindakan-hd.index', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}">
                                        <div class="row m-3">
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="ti-search"></i>
                                                    </span>
                                                    <input type="text" name="search" class="form-control" placeholder="Cari dokter, tipe penerima..." value="{{ request('search') }}">
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
                                                <a href="{{ route('hemodialisa.pelayanan.persetujuan.tindakan-hd.create', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                                    class="btn btn-primary">
                                                    <i class="ti-plus"></i> Tambah Data
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
                                                    <th>DPJP</th>
                                                    <th>Penerima Info</th>
                                                    <th>Keputusan</th>
                                                    <th>Info Dijelaskan</th>
                                                    <th>Petugas Input</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($dataPersetujuan as $key => $item)
                                                    <tr>
                                                        <td>{{ $dataPersetujuan->firstItem() + $key }}</td>
                                                        <td>
                                                            <strong>{{ date('d/m/Y', strtotime($item->tanggal_implementasi)) }}</strong><br>
                                                            <small class="text-muted">{{ date('H:i', strtotime($item->jam_implementasi)) }} WIB</small>
                                                        </td>
                                                        <td>
                                                            @if($item->dokter)
                                                                {{ $item->dokter->nama_lengkap }}
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-{{ $item->tipe_penerima }}">
                                                                {{ ucfirst($item->tipe_penerima) }}
                                                            </span>
                                                            @if($item->tipe_penerima == 'keluarga' && $item->nama_keluarga)
                                                                <br><small>{{ $item->nama_keluarga }}</small>
                                                                @if($item->status_keluarga)
                                                                    <br><small class="text-muted">({{ ucfirst(str_replace('_', ' ', $item->status_keluarga)) }})</small>
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($item->keputusan)
                                                                <span class="badge badge-{{ $item->keputusan }}">
                                                                    {{ strtoupper($item->keputusan) }}
                                                                </span>
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @php
                                                                $infoCount = 0;
                                                                if($item->info_diagnosis) $infoCount++;
                                                                if($item->info_dasar_diagnosis) $infoCount++;
                                                                if($item->info_tindakan) $infoCount++;
                                                                if($item->info_indikasi) $infoCount++;
                                                                if($item->info_tata_cara) $infoCount++;
                                                                if($item->info_tujuan) $infoCount++;
                                                                if($item->info_resiko) $infoCount++;
                                                                if($item->info_prognosis) $infoCount++;
                                                                if($item->info_alternatif) $infoCount++;
                                                                if($item->info_lain_lain_check) $infoCount++;
                                                            @endphp
                                                            
                                                            <span class="badge bg-info">{{ $infoCount }} item</span>
                                                        </td>
                                                        <td>
                                                            @if($item->userCreated)
                                                                {{ $item->userCreated->name }}
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                            <br><small class="text-muted">{{ $item->created_at ? $item->created_at->format('d/m/Y H:i') : '-' }}</small>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                <a href="{{ route('hemodialisa.pelayanan.persetujuan.tindakan-hd.print-pdf', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}" 
                                                                   class="btn btn-info btn-sm me-2" target="_blank" title="Lihat Detail">
                                                                    <i class="fas fa-print"></i>
                                                                </a>
                                                                <a href="{{ route('hemodialisa.pelayanan.persetujuan.tindakan-hd.edit', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}" 
                                                                   class="btn btn-warning btn-sm me-2" title="Edit">
                                                                    <i class="ti-pencil"></i>
                                                                </a>
                                                                <form action="{{ route('hemodialisa.pelayanan.persetujuan.tindakan-hd.destroy', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}" 
                                                                      method="POST" style="display: inline;" 
                                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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
                                                        <td colspan="8" class="text-center">
                                                            <div class="py-3">
                                                                <i class="ti-info-alt" style="font-size: 3rem; color: #dee2e6;"></i>
                                                                <p class="mt-2 text-muted">Belum ada data persetujuan tindakan HD</p>
                                                                <a href="{{ route('hemodialisa.pelayanan.persetujuan.tindakan-hd.create', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}" 
                                                                   class="btn btn-primary btn-sm">
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
                                    @if($dataPersetujuan->hasPages())
                                        <div class="d-flex justify-content-center mt-3">
                                            {{ $dataPersetujuan->appends(request()->query())->links() }}
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
    // Auto submit form ketika filter tanggal berubah
    $('input[name="dari_tanggal"], input[name="sampai_tanggal"]').on('change', function() {
        $(this).closest('form').submit();
    });
</script>
@endpush