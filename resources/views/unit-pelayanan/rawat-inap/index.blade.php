@extends('layouts.administrator.master')

@section('content')
    <div class="content-wrapper">
        <h5 class="fw-bold">Ruang/Klinik</h5>
        <p>Pilih ruang/klinik pelayanan pasien:</p>
        <div class="row">

            @foreach ($unit as $unt)
                @can('access-unit', $unt->kd_unit)
                    <div class="col-md-2 p-2">
                        <a href="{{ route('rawat-inap.unit', $unt->kd_unit) }}" class="text-decoration-none card-hover">
                            <div class="card mb-3 rounded-5 bg-white dark:bg-dark text-dark dark:text-light">
                                <div class="card-body text-center">
                                    <h6 class="fw-bold text-primary">{{ $unt->nama_unit }}</h6>
                                    <hr class="text-secondary">
                                    <p class="text-black">
                                        <img src="{{ asset('assets/img/Account.png') }}" alt="" width="15%">
                                        Pasien : 0
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endcan
            @endforeach

        </div>
    </div>
@endsection
