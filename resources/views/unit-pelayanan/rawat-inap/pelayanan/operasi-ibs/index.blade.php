@extends('layouts.administrator.master')

@section('content')
    <div class="row" style="height: auto;">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <x-content-card>
                <x-button-previous />

                @include('components.page-header', [
                    'title' => 'Daftar Operasi (IBS)',
                    'description' =>
                        'Daftar data operasi (IBS) pasien rawat inap.',
                ])

                <a class="btn btn-primary w-min ms-auto"
                    href="{{ route('rawat-inap.operasi-ibs.create', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}">
                    <i class="ti-plus"></i> Tambah</a>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>Petugas</th>
                                <th>Tindakan</th>
                                <th>Catatan</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($operasiIbs as $item)
                                <tr>
                                    <td>{{ date('d M Y', strtotime($item->tanggal)) . ' ' . date('H:i', strtotime($item->jam)) }}
                                    </td>
                                    <td>{{ $item->dokter->name ?? ($item->dokter->nama ?? '—') }}</td>
                                    <td>{{ $item->tindakan ?? ($item->tindakan ?? '-') }}</td>
                                    <td>{{ Str::limit($item->catatan ?? '-', 80) }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="#" class="btn btn-sm btn-primary"
                                                data-item='@json($item)' data-bs-target="#showOperasiModal">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            @if ($operasiIbs->isEmpty())
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Belum ada data operasi IBS.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </x-content-card>
        </div>
    </div>
@endsection

@push('js')
    <script></script>
@endpush
