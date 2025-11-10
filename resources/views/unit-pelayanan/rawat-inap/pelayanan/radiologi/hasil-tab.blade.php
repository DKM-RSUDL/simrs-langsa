@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        /* .header-background {
                                                                                                                                    background-image: url("{{ asset('assets/img/background_gawat_darurat.png') }}");
                                                                                                                                } */

        .result-text {
            max-width: 300px;
            max-height: 100px;
            overflow-y: auto;
            font-size: 0.875rem;
        }

        .keluhan-text {
            max-width: 250px;
            max-height: 80px;
            overflow-y: auto;
            font-size: 0.75rem;
        }

        .table td {
            vertical-align: middle;
        }

        .badge {
            font-size: 0.75rem;
        }

        code {
            font-size: 0.8rem;
        }

        .alert .fa-3x {
            opacity: 0.3;
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
                                <a href="?tab=order" class="nav-link" aria-selected="true">Order</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="?tab=hasil" class="nav-link active" aria-selected="true">Hasil</a>
                            </li>
                        </ul>

                        {{-- Tab Content --}}
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active">
                                {{-- TAB 1. Hasil Radiologi --}}
                                @include('components.page-header', [
                                    'title' => 'Hasil Pemeriksaan Radiologi',
                                    'description' =>
                                        'Hasil pemeriksaan radiologi pasien rawat inap dan dari unit asal.',
                                ])

                                {{-- Data Radiologi Lengkap --}}
                                @if (isset($dataRadiologi) && $dataRadiologi->isNotEmpty())
                                    <div class="mb-4">
                                        <h5 class="text-primary mb-3">
                                            <i class="fas fa-x-ray me-2"></i>Hasil Radiologi Terbaru
                                        </h5>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-sm table-hover">
                                                <thead class="table-primary">
                                                    <tr align="middle">
                                                        <th width="50px">NO</th>
                                                        <th>NO SJP</th>
                                                        <th>KLASIFIKASI</th>
                                                        <th>NAMA PEMERIKSAAN</th>
                                                        <th>DOKTER PENGIRIM</th>
                                                        <th>POLI ASAL</th>
                                                        <th>HASIL</th>
                                                        <th>KELUHAN</th>
                                                        <th width="100px">PACS</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($dataRadiologi as $item)
                                                        <tr>
                                                            <td align="middle">{{ $loop->iteration }}</td>
                                                            <td>{{ $item->NO_SJP ?? '-' }}</td>
                                                            <td>
                                                                <span class="badge bg-info text-dark">
                                                                    {{ $item->Klasifikasi ?? '-' }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <strong>{{ $item->deskripsi }}</strong>
                                                                @if ($item->no_asuransi)
                                                                    <br><small class="text-muted">Asuransi:
                                                                        {{ $item->no_asuransi }}</small>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                {{ $item->dokterPoli ?? ($item->dokter ?? '-') }}
                                                                @if ($item->poli)
                                                                    <br><small
                                                                        class="text-muted">{{ $item->poli }}</small>
                                                                @endif
                                                            </td>
                                                            <td>{{ $item->poli ?? '-' }}</td>
                                                            <td>
                                                                @if ($item->hasil)
                                                                    <div class="result-text">
                                                                        {!! nl2br(e($item->hasil)) !!}
                                                                    </div>
                                                                @else
                                                                    <span class="text-muted">Belum ada hasil</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($item->keluhan)
                                                                    <div class="keluhan-text">
                                                                        <small>{!! nl2br(e($item->keluhan)) !!}</small>
                                                                    </div>
                                                                @else
                                                                    <span class="text-muted">-</span>
                                                                @endif
                                                            </td>
                                                            <td align="middle">
                                                                @if (!empty($item->pacs))
                                                                    <a href="{{ $item->pacs }}" target="_blank"
                                                                        class="btn btn-sm btn-primary" title="Lihat PACS">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                @else
                                                                    <span class="text-muted">-</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endif

                                {{-- Data dari Unit Asal --}}
                                @if (!empty($dataTransaksi))
                                    <div class="mb-4">
                                        <h5 class="text-secondary mb-3">
                                            <i class="fas fa-history me-2"></i>Hasil Radiologi dari Unit Asal
                                        </h5>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-sm table-hover">
                                                <thead class="table-secondary">
                                                    <tr align="middle">
                                                        <th width="50px">NO</th>
                                                        <th>KLASIFIKASI</th>
                                                        <th>NAMA PEMERIKSAAN</th>
                                                        <th>DOKTER RADIOLOGI</th>
                                                        <th>HASIL</th>
                                                        <th>ACCESSION NUMBER</th>
                                                        <th width="100px">PACS</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($dataTransaksi as $item)
                                                        <tr>
                                                            <td align="middle">{{ $loop->iteration }}</td>
                                                            <td>
                                                                <span class="badge bg-secondary">
                                                                    {{ $item['klasifikasi'] ?? '-' }}
                                                                </span>
                                                            </td>
                                                            <td>{{ $item['nama_produk'] }}</td>
                                                            <td>{{ $item['nama_dokter'] }}</td>
                                                            <td>
                                                                @if ($item['hasil'])
                                                                    <div class="result-text">
                                                                        {!! nl2br(e($item['hasil'])) !!}
                                                                    </div>
                                                                @else
                                                                    <span class="text-muted">Belum ada hasil</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <code>{{ $item['accession_number'] ?? '-' }}</code>
                                                            </td>
                                                            <td align="middle">
                                                                @if (!empty($item['pacs']))
                                                                    <a href="{{ $item['pacs'] }}" target="_blank"
                                                                        class="btn btn-sm btn-primary" title="Lihat PACS">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                @else
                                                                    <span class="text-muted">-</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endif

                                {{-- Info jika tidak ada data --}}
                                @if (isset($dataRadiologi) && $dataRadiologi->isEmpty() && empty($dataTransaksi))
                                    <div class="alert alert-info text-center py-5">
                                        <i class="fas fa-info-circle fa-3x text-muted mb-3"></i>
                                        <h5>Belum Ada Hasil Radiologi</h5>
                                        <p class="text-muted mb-0">Hasil pemeriksaan radiologi akan ditampilkan di sini
                                            setelah pemeriksaan selesai.</p>
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
