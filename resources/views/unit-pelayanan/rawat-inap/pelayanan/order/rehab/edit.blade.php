@extends('layouts.administrator.master')

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <x-content-card>
                <x-button-previous />

                @include('components.page-header', [
                    'title' => 'Edit Order Rehabilitasi Medik',
                    'description' =>
                        'Edit order pelayanan Rehabilitasi Medik pasien rawat inap dengan mengisi formulir di bawah ini.',
                ])

                <form
                    action="{{ route('rawat-inap.order-rehab.update', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, encrypt($order->id)]) }}"
                    method="post">
                    @csrf
                    @method('PUT')

                    {{-- START : HANDOVER --}}
                    <div class="row">

                        <div class="col-12">
                            <div class="mb-4">
                                <div class="mb-3 row">
                                    <div class="col-md-6">
                                        <label for="tgl_order">Tanggal</label>
                                        <input type="date" name="tgl_order" id="tgl_order"
                                            value="{{ $order->tgl_order ? date('Y-m-d', strtotime($order->tgl_order)) : date('Y-m-d') }}"
                                            class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="jam_order">Jam</label>
                                        <input type="time" name="jam_order" id="jam_order"
                                            value="{{ $order->jam_order ? date('H:i', strtotime($order->jam_order)) : date('H:i') }}"
                                            class="form-control" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="kd_produk">Tindakan</label>
                                        <select name="kd_produk" id="kd_produk" class="form-select select2">
                                            <option value="">--Pilih--</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->kd_produk }}" @selected(($order->kd_produk ?? '') == $product->kd_produk)>
                                                    {{ $product->deskripsi }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="kd_dokter">Dokter</label>
                                        <select name="kd_dokter" id="kd_dokter" class="form-select select2">
                                            <option value="">--Pilih--</option>
                                            @foreach ($dokter as $d)
                                                <option value="{{ $d->kd_dokter }}"@selected(($order->kd_dokter ?? '') == $d->kd_dokter)>
                                                    {{ $d->dokter->nama_lengkap }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- END : HANDOVER --}}

                    <div class="row mt-3">
                        <div class="col-12 text-end">
                            <x-button-submit>Order</x-button-submit>
                        </div>
                    </div>
                </form>

            </x-content-card>

        </div>
    </div>
@endsection
