@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .card {
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .btn-sm {
            padding: 5px 10px;
        }
        .input-group {
            max-width: 300px;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card', ['dataMedis' => $dataMedis])
        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title mb-0">Daftar Surat Kematian Pasien</h5>
                        <a href="{{ route('surat-kematian.create', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}" class="btn btn-primary">
                            <i class="ti-plus"></i> Tambah Surat Kematian
                        </a>
                    </div>
                    
                    <div class="row mb-3">
                        <form method="GET" action="{{ route('surat-kematian.index', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}">
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="date" name="start_date" id="start_date" class="form-control" placeholder="Dari Tanggal" value="{{ request('start_date') }}">
                                </div>
                                <div class="col-md-3">
                                    <input type="date" name="end_date" id="end_date" class="form-control" placeholder="S.d Tanggal" value="{{ request('end_date') }}">
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control" placeholder="Cari nomor surat" aria-label="Cari" value="{{ request('search') }}">
                                        <button type="submit" class="btn btn-primary">Cari</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-sm table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="15%">Tanggal Kematian</th>
                                    <th width="20%">Nomor Surat</th>
                                    <th width="25%">Dokter</th>
                                    <th width="20%">Penyebab Kematian</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dataSuratKematian as $index => $surat)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ \Carbon\Carbon::parse($surat->tanggal_kematian)->format('d-m-Y') }}<br>
                                            <small class="text-muted">{{ substr($surat->jam_kematian, 0, 5) }}</small>
                                        </td>
                                        <td>{{ $surat->nomor_surat }}</td>
                                        <td>{{ $surat->dokter->nama_lengkap ?? 'Tidak Ada' }}</td>
                                        <td>
                                            @if($surat->detailType1->isNotEmpty())
                                                {{ $surat->detailType1->first()->keterangan }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('surat-kematian.show', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $surat->id]) }}" class="btn btn-info btn-sm" title="Detail">
                                                    <i class="ti-eye"></i>
                                                </a>
                                                <a href="{{ route('surat-kematian.edit', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $surat->id]) }}" class="btn btn-warning btn-sm ms-2" title="Edit">
                                                    <i class="ti-pencil"></i>
                                                </a>
                                                <a href="{{ route('surat-kematian.print', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $surat->id]) }}" class="btn btn-primary btn-sm ms-2" title="Cetak" target="_blank">
                                                    <i class="ti-printer"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data surat kematian</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection