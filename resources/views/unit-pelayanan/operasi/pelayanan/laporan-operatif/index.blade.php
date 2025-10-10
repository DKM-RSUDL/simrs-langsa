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

            <x-content-card>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="pra-anestesi" role="tabpanel"
                        aria-labelledby="pra-anestesi-tab">
                        {{-- TAB 1. buatlah list disini --}}
                        @include('unit-pelayanan.operasi.pelayanan.laporan-operatif.laporan-operasi')
                    </div>
                </div>
            </x-content-card>
        </div>
    </div>
@endsection
