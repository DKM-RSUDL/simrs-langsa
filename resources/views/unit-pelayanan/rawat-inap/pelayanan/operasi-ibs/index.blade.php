@extends('layouts.administrator.master')

@section('content')
    <div class="row" style="height: auto;">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <div class="card" style="height: auto;">
                <div class="card-body">
                    <a href="{{ url()->previous() }}" class="btn btn-light mb-4">
                        <i class="ti-arrow-left"></i> Kembali
                    </a>
                    <div class="d-flex justify-content-between align-items-center">
                        <h4>Daftar Operasi (IBS)</h4>
                        @if (!empty($dataMedis))
                            <a class="btn btn-primary"
                                href="{{ route('rawat-inap.operasi-ibs.create', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}">
                                <i class="ti-plus"></i> Tambah</a>
                        @else
                            <button class="btn btn-secondary" disabled><i class="ti-plus"></i> Tambah</button>
                        @endif
                    </div>

                    <div class="table-responsive mt-3">
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
                                                    data-item='@json($item)'
                                                    data-bs-target="#showOperasiModal">
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
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script></script>
@endpush
