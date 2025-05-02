@extends('layouts.administrator.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="fw-bold">List Permintaan Darah</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive text-left">
                <table class="table table-bordered table-hover table-striped dataTable">
                    <thead>
                        <tr align="middle">
                            <th>No</th>
                            <th>Tgl Permintaan</th>
                            <th>Unit</th>
                            <th>Petugas</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td align="middle">{{ $loop->iteration }}</td>
                                <td align="middle">{{ date('d M Y', strtotime($order->tgl_pengiriman)) }}</td>
                                <td>{{ $order->unit->nama_unit }}</td>
                                <td>{{ $order->petugas_pengambilan_sampel }}</td>
                                <td>
                                    {{ $order->status }}
                                </td>
                                <td></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
