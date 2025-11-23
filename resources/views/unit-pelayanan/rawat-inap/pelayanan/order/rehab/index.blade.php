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
                    'title' => 'Daftar Order Rehabilitasi Medik',
                    'description' => 'Daftar data order rehabilitasi medik pasien rawat inap.',
                ])

                <a class="btn btn-primary w-min ms-auto"
                    href="{{ route('rawat-inap.order-rehab.create', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}">
                    <i class="ti-plus"></i> Tambah</a>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr align="middle">
                                <th>Waktu Permintaan</th>
                                <th>Tindakan</th>
                                <th>Dokter</th>
                                <th>Status</th>
                                <th>Petugas Order</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>
                                        {{ $order->tgl_order ? date('Y-m-d', strtotime($order->tgl_order)) : '-' }}
                                        {{ $order->jam_order ? ' ' . date('H:i', strtotime($order->jam_order)) : '' }}
                                    </td>
                                    <td>
                                        {{ $order->produk->deskripsi ?? '-' }}
                                    </td>
                                    <td>
                                        {{ $order->dokter->nama_lengkap ?? '-' }}
                                    </td>
                                    <td>
                                        @if ($order->status === 0 || $order->status === '0')
                                            <span class="badge bg-warning">Menunggu</span>
                                        @elseif ($order->status === 1 || $order->status === '1')
                                            <span class="badge bg-primary">Disetujui</span>
                                        @else
                                            <span class="badge bg-success">Selesai</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ ($order->userCreate->gelar_depan ?? '') . ' ' . str()->title($order->userCreate->nama ?? '') . ' ' . ($order->userCreate->gelar_belakang ?? '') }}
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('rawat-inap.order-rehab.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, encrypt($order->id)]) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if (!in_array($order->status, [1, '1', 2, '2']))
                                                <a href="{{ route('rawat-inap.order-rehab.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, encrypt($order->id)]) }}"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form
                                                    action="{{ route('rawat-inap.order-rehab.delete', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, encrypt($order->id)]) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('delete')

                                                    <button type="submit" class="btn btn-sm btn-danger" data-confirm
                                                        data-confirm-title="Anda yakin?"
                                                        data-confirm-text="Data yang dihapus tidak dapat dikembalikan"
                                                        title="Hapus Rehab Medik" aria-label="Hapus Rehab Medik">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            @if ($orders->isEmpty())
                                <tr>
                                    <td colspan="12" class="text-center text-muted">Belum ada data order rehabilitasi medik.</td>
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
