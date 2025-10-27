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
                @include('components.navigation-ranap')
                <div class="d-flex justify-content-center">
                    <div class="card w-100 h-100 px-3">
                        <div class="card-body d-flex justify-content-between nav nav-tabs">
                            {{-- Tabs --}}
                            @include('unit-pelayanan.rawat-inap.pelayanan.konsultasi-spesialis.tab-component.index', ['active' => $active])
                            @if($active == 1)
                                <div class="d-flex justify-content-end align-items-center mb-3">
                                    <div class="col-md-12 text-end">
                                        <button class="btn btn-primary" id="addKonsulModal">
                                            <i class="bi bi-plus"></i> Tambah Konsultasi
                                        </button>
                                    </div>
                                </div>
                            @endif


                        </div>
                        {{-- Tab Content --}}
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="resep" role="tabpanel" aria-labelledby="resep-tab">
                                {{-- TAB 1. buatlah list disini --}}
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm table-hover"
                                        id="rawatDaruratKonsultasiTable">
                                        <thead class="table-primary">
                                            <tr>
                                                <th width="10%">Tanggal</th>
                                                <th width="20%">Dari PPA</th>
                                                <th width="15%">Konsulen</th>
                                                <th width="20%">Konsul yang diminta</th>
                                                <th width="20%">Jawaban</th>
                                                <th width="13%">Status Konsul</th>
                                                <th width="{{ $isTerima ? '22%' : '10%' }}">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Data Konsultasi-->
                                            {{ $slot }}
                                        </tbody>
                                    </table>
                                </div>
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