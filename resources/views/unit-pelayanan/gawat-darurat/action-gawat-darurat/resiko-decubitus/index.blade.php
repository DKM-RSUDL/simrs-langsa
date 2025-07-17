@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .badge-risiko-rendah {
            background-color: #28a745;
            color: white;
        }
        .badge-risiko-sedang {
            background-color: #ffc107;
            color: black;
        }
        .badge-risiko-tinggi {
            background-color: #dc3545;
            color: white;
        }
        .table-responsive {
            border-radius: 0.5rem;
            overflow: hidden;
        }
        .table thead th {
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
        }
        .table tbody td {
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
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active">

                                <div class="row">
                                    <form method="GET" action="{{ route('resiko-decubitus.index', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}">
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
                                                <a href="{{ route('resiko-decubitus.create', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
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
                                                    <th>Hari Ke</th>
                                                    <th>Shift</th>
                                                    <th>Skor Norton</th>
                                                    <th>Kategori Risiko</th>
                                                    <th>Petugas</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($dataDecubitus as $index => $item)
                                                    <tr>
                                                        <td>{{ $dataDecubitus->firstItem() + $index }}</td>
                                                        <td>
                                                            <div class="fw-bold">{{ date('d/m/Y', strtotime($item->tanggal_implementasi)) }}</div>
                                                            <small class="text-muted">{{ date('H:i', strtotime($item->jam_implementasi)) }}</small>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-info">Hari {{ $item->hari_ke }}</span>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-secondary">
                                                                @if($item->shift == '1')
                                                                    Pagi
                                                                @elseif($item->shift == '2')
                                                                    Siang
                                                                @elseif($item->shift == '3')
                                                                    Malam
                                                                @else
                                                                    {{ $item->shift }}
                                                                @endif
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-primary fs-6">{{ $item->norton_total_score }}</span>
                                                        </td>
                                                        <td>
                                                            @if($item->kategori_risiko == 'Risiko Rendah')
                                                                <span class="badge badge-risiko-rendah">{{ $item->kategori_risiko }}</span>
                                                            @elseif($item->kategori_risiko == 'Risiko Sedang')
                                                                <span class="badge badge-risiko-sedang">{{ $item->kategori_risiko }}</span>
                                                            @elseif($item->kategori_risiko == 'Risiko Tinggi')
                                                                <span class="badge badge-risiko-tinggi">{{ $item->kategori_risiko }}</span>
                                                            @else
                                                                <span class="badge bg-secondary">{{ $item->kategori_risiko }}</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="fw-bold">{{ $item->userCreated->name ?? 'Unknown' }}</div>
                                                            <small class="text-muted">{{ date('d/m/Y H:i', strtotime($item->created_at)) }}</small>
                                                            @if($item->userUpdated)
                                                                <br>
                                                                <small class="text-warning">
                                                                    <i class="ti-pencil"></i> {{ $item->userUpdated->name ?? 'Unknown' }}
                                                                    <br>{{ date('d/m/Y H:i', strtotime($item->updated_at)) }}
                                                                </small>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                <a href="{{ route('resiko-decubitus.show', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                                    class="btn btn-info btn-sm" title="Lihat Detail">
                                                                    <i class="ti-eye"></i>
                                                                </a>
                                                                <a href="{{ route('resiko-decubitus.edit', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                                    class="btn btn-warning btn-sm" title="Edit">
                                                                    <i class="ti-pencil"></i>
                                                                </a>
                                                                <form method="POST" action="{{ route('resiko-decubitus.destroy', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}" 
                                                                    style="display: inline-block;" 
                                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
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
                                                        <td colspan="8" class="text-center py-4">
                                                            <div class="d-flex flex-column align-items-center">
                                                                <i class="ti-clipboard" style="font-size: 3rem; color: #dee2e6;"></i>
                                                                <h5 class="mt-3 text-muted">Tidak ada data</h5>
                                                                <p class="text-muted">Belum ada data pengkajian risiko decubitus untuk pasien ini</p>
                                                                <a href="{{ route('resiko-decubitus.create', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}" 
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

                                    <!-- Pagination -->
                                    @if($dataDecubitus->hasPages())
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <div>
                                                <small class="text-muted">
                                                    Menampilkan {{ $dataDecubitus->firstItem() }} sampai {{ $dataDecubitus->lastItem() }} 
                                                    dari {{ $dataDecubitus->total() }} data
                                                </small>
                                            </div>
                                            <div>
                                                {{ $dataDecubitus->links() }}
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
    // Auto-hide success/error messages
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 3000);
</script>
@endpush