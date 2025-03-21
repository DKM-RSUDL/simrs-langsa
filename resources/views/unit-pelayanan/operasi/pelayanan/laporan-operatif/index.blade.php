@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <!-- Tambahkan ini ke tag <style> atau file CSS -->
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            @include('components.navigation-operasi')

            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="pra-anestesi" role="tabpanel"
                                aria-labelledby="pra-anestesi-tab">
                                {{-- TAB 1. buatlah list disini --}}
                                @include('unit-pelayanan.operasi.pelayanan.laporan-operatif.laporan-operasi.laporan-operasi')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
@endpush
