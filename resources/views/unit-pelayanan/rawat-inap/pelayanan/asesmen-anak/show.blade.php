@extends('layouts.administrator.master')

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card-keperawatan')
        </div>

        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                    <i class="ti-arrow-left"></i> Kembali
                </a>
                <div>
                    <a href="#" class="btn btn-outline-primary" onclick="window.print()">
                        <i class="fas fa-print"></i> Cetak
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Data Asesmen Keperawatan Anak</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <div class="mt-3">
                                    <h6 class="font-weight-bold">Tanggal Asesmen: {{ \Carbon\Carbon::parse($asesmen->waktu_asesmen)->format('d/m/Y H:i') }}</h6>
                                </div>
                                <div class="mt-3">
                                    <h6 class="font-weight-bold">Perawat: {{ $asesmen->user->name ?? 'Tidak diketahui' }}</h6>
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
                        