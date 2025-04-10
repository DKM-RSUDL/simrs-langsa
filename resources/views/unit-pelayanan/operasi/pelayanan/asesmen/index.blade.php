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
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pra-anestesi-tab" data-bs-toggle="tab"
                                    data-bs-target="#pra-anestesi" type="button" role="tab" aria-controls="pra-anestesi"
                                    aria-selected="true">
                                    Pra Anestesi
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pra-induksi-tab" data-bs-toggle="tab" data-bs-target="#pra-induksi"
                                    type="button" role="tab" aria-controls="pra-induksi" aria-selected="false">
                                    Pra Induksi
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="pra-anestesi" role="tabpanel"
                                aria-labelledby="pra-anestesi-tab">
                                {{-- TAB 1. buatlah list disini --}}
                                @include('unit-pelayanan.operasi.pelayanan.asesmen.pra-anestesi.pra-anestesi')
                            </div>
                            <div class="tab-pane fade" id="pra-induksi" role="tabpanel" aria-labelledby="pra-induksi-tab">
                                {{-- TAB 2. buatlah list disini --}}
                                @include('unit-pelayanan.operasi.pelayanan.asesmen.pra-induksi.pra-induksi')
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
