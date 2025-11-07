@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .card {
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .table th,
        .table td {
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
            <x-content-card>
                <x-button-previous />

                @include('components.page-header', [
                    'title' => 'Daftar Surat Kematian Pasien',
                    'description' => 'Daftar surat kematian pasien rawat inap.',
                ])

                <div class="row">
                    <form method="GET"
                        action="{{ route('rawat-inap.surat-kematian.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                        class="col-md-10">
                        <div class="d-flex flex-wrap flex-md-nowrap gap-2">
                            <div>
                                <input type="date" name="start_date" id="start_date" class="form-control"
                                    placeholder="Dari Tanggal" value="{{ request('start_date') }}">
                            </div>
                            <div>
                                <input type="date" name="end_date" id="end_date" class="form-control"
                                    placeholder="S.d Tanggal" value="{{ request('end_date') }}">
                            </div>
                            <div>
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Cari nomor surat"
                                        aria-label="Cari" value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="text-end col-md-2">
                        <a href="{{ route('rawat-inap.surat-kematian.create', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                            class="btn btn-primary">
                            <i class="ti-plus"></i> Tambah
                        </a>
                    </div>
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
                                        @if ($surat->detailType1->isNotEmpty())
                                            {{ $surat->detailType1->first()->keterangan }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('rawat-inap.surat-kematian.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $surat->id]) }}"
                                                class="btn btn-info btn-sm" title="Detail">
                                                <i class="ti-eye"></i>
                                            </a>
                                            <a href="{{ route('rawat-inap.surat-kematian.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $surat->id]) }}"
                                                class="btn btn-warning btn-sm ms-2" title="Edit">
                                                <i class="ti-pencil"></i>
                                            </a>
                                            <a href="{{ route('rawat-inap.surat-kematian.print', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $surat->id]) }}"
                                                class="btn btn-primary btn-sm ms-2" title="Cetak" target="_blank">
                                                <i class="ti-printer"></i>
                                            </a>
                                            <form
                                                action="{{ route('rawat-inap.surat-kematian.destroy', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $surat->id]) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus surat kematian ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm ms-2" title="Hapus">
                                                    <i class="ti-trash"></i>
                                                </button>
                                            </form>
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
            </x-content-card>

        </div>
    </div>
@endsection
