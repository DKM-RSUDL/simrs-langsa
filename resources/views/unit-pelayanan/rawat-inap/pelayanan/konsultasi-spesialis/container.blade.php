@extends('layouts.administrator.master')

@push('css')
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>
        <div class="col-md-9">
            <x-content-card>
                @if ($firstFrame)
                    @include('components.navigation-ranap')
                @endif
                <div class="d-flex justify-content-center">
                    <div class="card w-100 h-100 px-3">
                        @if($firstFrame)
                            <div class="card-body d-flex justify-content-between nav nav-tabs">
                                {{-- Tabs --}}
                                @include('unit-pelayanan.rawat-inap.pelayanan.konsultasi-spesialis.tab-component.index', ['active' => $active])
                                <div class="d-flex justify-content-end align-items-center mb-3">
                                    <div class="col-md-12 text-end">
                                        <button class="btn btn-primary" id="addKonsulModal">
                                            <i class="bi bi-plus"></i> Tambah Konsultasi
                                        </button>
                                    </div>
                                </div>


                            </div>
                        @endif
                        {{-- Tab Content --}}
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="resep" role="tabpanel" aria-labelledby="resep-tab">
                                {{-- TAB 1. buatlah list disini --}}
                                {{ $slot }}
                            </div>
                        </div>
                    </div>
                </div>
            </x-content-card>
        </div>
    </div>
@endsection


@push('js')
    <script>
        $(document).ready(() => {
            $('#addKonsulModal').click(() => {
                console.log('oke')
                location.href = "{{ route('rawat-inap.konsultasi-spesialis.create', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk]) }}"
            })
        })
    </script>
@endpush