@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('unit-pelayanan.hemodialisa.component.patient-card')
        </div>

        <div class="col-md-9">
            @include('unit-pelayanan.hemodialisa.component.navigation')

            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        {{-- Tabs --}}
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a href="#" class="nav-link active" aria-selected="true">Data Umum</a>
                            </li>
                        </ul>

                        {{-- Tab Content --}}
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active">
                                {{-- TAB 1. buatlah list disini --}}

                                <div class="row">
                                    <div class="d-flex justify-content-between align-items-center m-3">

                                        <div class="row w-100">
                                            <!-- Add Button -->
                                            <!-- Include the modal file -->
                                            <div class="col-md-2 ms-auto">
                                                <div class="d-grid gap-2">
                                                    <a href="{{ route('hemodialisa.pelayanan.data-umum.create', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                                        class="btn btn-primary">
                                                        <i class="ti-plus"></i> Tambah
                                                    </a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm table-hover">
                                            <thead class="table-primary">
                                                <tr>
                                                    <th width="100px">NO</th>
                                                    <th>TANGGAL</th>
                                                    <th>PENANGGUNGJAWAB PASIEN</th>
                                                    <th>PETUGAS</th>
                                                    <th>AKSI</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {{-- @foreach ($radList as $rad)
                                                    <tr>
                                                        <td>{{ (int) $rad->kd_order }}</td>
                                                        <td>
                                                            @php
                                                                $namaPemeriksaan = '';

                                                                foreach ($rad->details as $dtl) {
                                                                    $namaPemeriksaan .= empty($namaPemeriksaan)
                                                                        ? $dtl->produk->deskripsi
                                                                        : ', ' . $dtl->produk->deskripsi;
                                                                }
                                                            @endphp

                                                            {{ $namaPemeriksaan }}
                                                        </td>
                                                        <td>{{ date('d M Y H:i', strtotime($rad->tgl_order)) }}</td>
                                                        <td></td>
                                                        <td>{{ $rad->dokter->nama_lengkap . '(' . $rad->unit->nama_unit . ')' }}
                                                        </td>
                                                        <td align="middle">
                                                            {{ $rad->cyto == 1 ? 'Cito' : 'Non Cito' }}
                                                        </td>
                                                        <td>
                                                            @php
                                                                $statusOrder = $rad->status_order;
                                                                $statusLabel = '';

                                                                if ($statusOrder == 0) {
                                                                    $statusLabel =
                                                                        '<span class="text-warning">Diproses</span>';
                                                                }
                                                                if ($statusOrder == 1) {
                                                                    $statusLabel =
                                                                        '<span class="text-secondary">Diorder</span>';
                                                                }
                                                                if ($statusOrder == 2) {
                                                                    $statusLabel =
                                                                        '<span class="text-success">Selesai</span>';
                                                                }
                                                            @endphp

                                                            {!! $statusLabel !!}
                                                        </td>

                                                        <td>
                                                            @if ($rad->status_order == 1)
                                                                <button class="btn btn-sm btn-secondary btn-edit-rad"
                                                                    data-kode="{{ intval($rad->kd_order) }}"
                                                                    data-bs-target="#editRadiologiModal"><i
                                                                        class="ti-pencil"></i></button>
                                                            @else
                                                                <button class="btn btn-sm btn-primary btn-show-rad"
                                                                    data-kode="{{ intval($rad->kd_order) }}"
                                                                    data-bs-target="#showRadiologiModal"><i
                                                                        class="ti-eye"></i></button>
                                                            @endif
                                                            <button
                                                                class="btn btn-sm {{ $rad->status_order == 1 ? 'btn-delete-rad' : '' }}"
                                                                data-kode="{{ intval($rad->kd_order) }}"><i
                                                                    class="bi bi-x-circle {{ $rad->status_order == 1 ? 'text-danger' : 'text-secondary' }}"></i></button>
                                                        </td>
                                                    </tr>
                                                @endforeach --}}
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
