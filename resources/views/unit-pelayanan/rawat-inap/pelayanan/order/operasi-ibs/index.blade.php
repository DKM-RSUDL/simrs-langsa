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
                    'description' => 'Daftar data operasi (IBS) pasien rawat inap.',
                ])

                <a class="btn btn-primary w-min ms-auto"
                    href="{{ route('rawat-inap.operasi-ibs.create', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}">
                    <i class="ti-plus"></i> Tambah</a>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Tgl. Registrasi</th> {{-- gabungan tgl_op + jam_op --}}
                                <th>Tgl Jadwal</th>
                                <th>Kamar</th>
                                <th>Spesialisasi</th>
                                <th>Sub Spesialisasi</th>
                                <th>Jenis Op</th>
                                <th>Status</th>
                                <th>Petugas</th>
                                <th>Diagnosis</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($operasiIbs as $item)
                                <tr>
                                    <td>
                                        {{ $item->tgl_op ? date('Y-m-d', strtotime($item->tgl_op)) : '-' }}
                                        {{ $item->jam_op ? ' ' . date('H:i', strtotime($item->jam_op)) : '' }}
                                    </td>
                                    <td>{{ optional($item->tgl_jadwal) ? date('Y-m-d', strtotime($item->tgl_jadwal)) : '-' }}
                                    </td>
                                    <td>{{ optional($item->kamar)->nama_kamar ?? ($item->no_kamar ?? ($item->kd_unit_kamar ?? '-')) }}
                                    </td>
                                    <td>{{ optional($item->spesialisasi)->spesialisasi ?? ($item->kd_spc ?? '-') }}</td>
                                    <td>{{ optional($item->subSpesialisasi)->klasifikasi ?? ($item->klasifikasi ?? '-') }}
                                    </td>
                                    <td>{{ optional($item->jenisOperasi)->klasifikasi ?? ($item->klasifikasi ?? '-') }}</td>
                                    <td>
                                        @if ($item->status === 0 || $item->status === '0')
                                            <span class="badge bg-warning">Menunggu</span>
                                        @elseif ($item->status === 1 || $item->status === '1')
                                            <span class="badge bg-primary">Disetujui</span>
                                        @else
                                            <span class="badge bg-success">Selesai</span>
                                        @endif
                                    </td>
                                    <td>{{ optional($item->dokter)->nama ?? (optional($item->dokter)->name ?? ($item->kd_dokter ?? '-')) }}
                                    </td>
                                    <td>{{ Str::limit($item->diagnosis ?? '-', 120) }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('rawat-inap.operasi-ibs.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->tgl_op, $item->jam_op]) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('rawat-inap.operasi-ibs.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->tgl_op, $item->jam_op]) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form
                                                action="{{ route('rawat-inap.operasi-ibs.delete', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $item->tgl_op, $item->jam_op]) }}"
                                                method="post">
                                                @csrf
                                                @method('delete')

                                                <button type="submit" class="btn btn-sm btn-danger" data-confirm
                                                    data-confirm-title="Anda yakin?"
                                                    data-confirm-text="Data yang dihapus tidak dapat dikembalikan"
                                                    title="Hapus operasi" aria-label="Hapus operasi">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            @if ($operasiIbs->isEmpty())
                                <tr>
                                    <td colspan="12" class="text-center text-muted">Belum ada data operasi IBS.</td>
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
    <script src="{{ asset('js/helpers/confirm.js') }}"></script>
@endpush
