@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>

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
                        <ul class="nav nav-tabs" id="skalaMorseTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a href="{{ route('rawat-jalan.resiko-jatuh.morse.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                    class="nav-link @if (request()->routeIs('rawat-jalan.resiko-jatuh.morse.index')) active @endif">
                                    <i class="bi bi-person-heart me-2"></i>
                                    Skala Morse
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="{{ route('rawat-jalan.resiko-jatuh.humpty-dumpty.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                    class="nav-link @if (request()->routeIs('rawat-jalan.resiko-jatuh.humpty-dumpty.index')) active @endif">
                                    <i class="bi bi-person-heart me-2"></i>
                                    Humpty Dumpty
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="{{ route('rawat-jalan.resiko-jatuh.geriatri.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                    class="nav-link @if (request()->routeIs('rawat-jalan.resiko-jatuh.geriatri.index')) active @endif">
                                    <i class="bi bi-person-heart me-2"></i>
                                    Skala Geriatri
                                </a>
                            </li>
                        </ul>

                        {{-- Tab Content --}}
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active">

                                <div class="row">
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
                                            <button class="btn btn-outline-secondary" type="button">
                                                <i class="ti-filter"></i> Filter
                                            </button>
                                        </div>

                                        <div class="col-md-3 text-end">
                                            <a href="{{ route('rawat-jalan.resiko-jatuh.humpty-dumpty.create', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                                class="btn btn-primary">
                                                <i class="ti-plus"></i> Tambah
                                            </a>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm table-hover">
                                            <thead class="table-primary">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tanggal & Jam</th>
                                                    <th>Shift</th>
                                                    <th>Total Skor</th>
                                                    <th>Kategori Risiko</th>
                                                    <th>Petugas</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($dataHumptyDumpty as $index => $data)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>
                                                            <strong>{{ date('d/m/Y', strtotime($data->tanggal_implementasi)) }}</strong><br>
                                                            <small class="text-muted">{{ date('H:i', strtotime($data->jam_implementasi)) }} WIB</small>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-secondary">{{ ucfirst($data->shift) }}</span>
                                                        </td>
                                                        <td class="text-center">
                                                            <h5 class="mb-0">{{ $data->total_skor }}</h5>
                                                        </td>
                                                        <td>
                                                            @if($data->kategori_risiko == 'Risiko Rendah')
                                                                <span class="badge bg-success">
                                                                    <i class="ti-check"></i> {{ $data->kategori_risiko }}
                                                                </span>
                                                            @elseif($data->kategori_risiko == 'Risiko Tinggi')
                                                                <span class="badge bg-danger">
                                                                    <i class="ti-alert-triangle"></i> {{ $data->kategori_risiko }}
                                                                </span>
                                                            @else
                                                                <span class="badge bg-secondary">{{ $data->kategori_risiko }}</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{ $data->userCreated->name ?? 'Unknown' }}<br>
                                                            <small class="text-muted">{{ $data->userCreated->username ?? '-' }}</small>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                <a href="{{ route('rawat-jalan.resiko-jatuh.humpty-dumpty.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $data->id]) }}"
                                                                   class="btn btn-sm btn-outline-info" title="Lihat Detail">
                                                                    <i class="ti-eye"></i>
                                                                </a>
                                                                <a href="{{ route('rawat-jalan.resiko-jatuh.humpty-dumpty.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $data->id]) }}"
                                                                   class="btn btn-sm btn-outline-warning" title="Edit">
                                                                    <i class="ti-pencil"></i>
                                                                </a>
                                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                                        onclick="confirmDelete({{ $data->id }})" title="Hapus">
                                                                    <i class="ti-trash"></i>
                                                                </button>
                                                            </div>

                                                            {{-- Hidden Delete Form --}}
                                                            <form id="delete-form-{{ $data->id }}"
                                                                  action="{{ route('rawat-jalan.resiko-jatuh.humpty-dumpty.destroy', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $data->id]) }}"
                                                                  method="POST" style="display: none;">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="7" class="text-center py-4">
                                                            <div class="text-muted">
                                                                <i class="ti-info-alt" style="font-size: 2rem;"></i>
                                                                <p class="mt-2">Belum ada data pengkajian Humpty Dumpty</p>
                                                                <a href="{{ route('rawat-jalan.resiko-jatuh.humpty-dumpty.create', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}"
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
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }

        // Auto dismiss alerts after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
    </script>
@endpush
