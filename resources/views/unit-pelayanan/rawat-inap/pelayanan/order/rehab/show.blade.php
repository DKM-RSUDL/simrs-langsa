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
                    'title' => 'Show Order Rehabilitasi Medik',
                ])

                {{-- START : HANDOVER --}}
                <div class="row">

                    <div class="col-12">
                        <div class="mb-4">
                            <div class="mb-3 row">
                                <div class="col-md-6">
                                    <label for="tgl_order">Tanggal</label>
                                    <input type="date" name="tgl_order" id="tgl_order"
                                        value="{{ $order->tgl_order ? date('Y-m-d', strtotime($order->tgl_order)) : date('Y-m-d') }}"
                                        class="form-control" disabled>
                                </div>
                                <div class="col-md-6">
                                    <label for="jam_order">Jam</label>
                                    <input type="time" name="jam_order" id="jam_order"
                                        value="{{ $order->jam_order ? date('H:i', strtotime($order->jam_order)) : date('H:i') }}"
                                        class="form-control" disabled>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="kd_produk">Tindakan</label>
                                    <input type="text" class="form-control" value="{{ $order->produk->deskripsi ?? '' }}" disabled>
                                </div>
                                <div class="col-md-6">
                                    <label for="kd_dokter">Dokter</label>
                                    <input type="text" class="form-control" value="{{ $order->dokter->nama_lengkap ?? '' }}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- END : HANDOVER --}}

            </x-content-card>

        </div>
    </div>
@endsection
