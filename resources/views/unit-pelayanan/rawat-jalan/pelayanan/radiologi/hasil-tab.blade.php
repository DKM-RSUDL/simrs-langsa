@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        /* .header-background {
                                                                                                                                background-image: url("{{ asset('assets/img/background_gawat_darurat.png') }}");
                                                                                                                            } */
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            @include('components.navigation')

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
                                {{-- TAB 1. buatlah list disini --}}

                                <div class="row">

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm table-hover">
                                            <thead class="table-primary">
                                                <tr align="middle">
                                                    <th width="100px">NO</th>
                                                    <th>NAMA PEMERIKSAAN</th>
                                                    <th>DOKTER RADIOLOGI</th>
                                                    <th>HASIL</th>
                                                    <th>PACS</th>
                                                    <th width="120px">AKSI</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($dataTransaksi as $item)
                                                    <tr>
                                                        <td align="middle">{{ $loop->iteration }}</td>
                                                        <td>{{ $item['nama_produk'] }}</td>
                                                        <td>{{ $item['nama_dokter'] }}</td>
                                                        <td>{{ $item['hasil'] ?? '-' }}</td>
                                                        <td align="middle">
                                                            @if (!empty($item['pacs']))
                                                                <a href="{{ $item['pacs'] }}" target="_blank"
                                                                    class="btn btn-sm btn-primary">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                            @endif
                                                        </td>
                                                        <td align="middle">
                                                            @if (!empty($item['file_name']))
                                                                <x-table-action>
                                                                    <a target="_blank"
                                                                        href="{{ route('rawat-jalan.radiologi.preview', [
                                                                            $item['kd_unit'],
                                                                            $item['kd_pasien'],
                                                                            $item['tgl_transaksi'],
                                                                            $item['urut_masuk'],
                                                                            'file' => $item['file_name'],
                                                                        ]) }}"
                                                                        class="btn btn-sm btn-success"
                                                                        title="Print / Preview Hasil Radiologi">
                                                                        <i class="fas fa-print"></i>
                                                                    </a>

                                                                    <a href="{{ route('rawat-jalan.radiologi.download', [
                                                                        $item['kd_unit'],
                                                                        $item['kd_pasien'],
                                                                        $item['tgl_transaksi'],
                                                                        $item['urut_masuk'],
                                                                        'file' => $item['file_name'],
                                                                    ]) }}"
                                                                        class="btn btn-sm btn-primary"
                                                                        title="Download Hasil Radiologi">
                                                                        <i class="fas fa-download"></i>
                                                                    </a>
                                                                </x-table-action>
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

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
