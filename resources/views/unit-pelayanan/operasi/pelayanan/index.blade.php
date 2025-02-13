@extends('layouts.administrator.master')

@section('content')
    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
        <style>
            .header-background {
                height: 100%;
                background-image: url("{{ asset('assets/img/background_gawat_darurat.png') }}");
            }
        </style>
    @endpush

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            @include('unit-pelayanan.operasi.pelayanan.include.nav')


            <div class="container-fluid py-3">
                <!-- Form Header -->
                <div class="d-flex justify-content-center align-items-center mb-3">
                    <h5 class="mb-0 text-secondary fw-bold">Asesmen Pra Operasi</h5>
                </div>

                <!-- Main Form -->
                <div class="form-section p-3 mb-2">
                    <!-- Row 1 -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Ruangan</label>
                                <input type="text" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Tanggal</label>
                                <input type="date" class="form-control form-control-sm">
                            </div>
                        </div>
                    </div>

                    <!-- Row 2 -->
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Diagnosis Pra Operatif</label>
                                <textarea class="form-control form-control-sm" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Timing Tindakan</label>
                                <textarea class="form-control form-control-sm" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Information Section -->
                <div class="form-section p-3">
                    <div class="mb-3">
                        <label class="form-label">Indikasi Tindakan</label>
                        <textarea class="form-control form-control-sm" rows="2"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Rencana Tindakan</label>
                        <textarea class="form-control form-control-sm" rows="2"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Prosedur Tindakan</label>
                        <textarea class="form-control form-control-sm" rows="2"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alternatif Lain</label>
                        <textarea class="form-control form-control-sm" rows="2"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Risiko/Komplikasi dan kemungkinan perdarahan intra operasi</label>
                        <textarea class="form-control form-control-sm" rows="2"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pemantauan Khusus Pasca Tindakan</label>
                        <textarea class="form-control form-control-sm" rows="2"></textarea>
                    </div>

                    <div class="text-end">
                        <button class="btn btn-primary btn-sm">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
