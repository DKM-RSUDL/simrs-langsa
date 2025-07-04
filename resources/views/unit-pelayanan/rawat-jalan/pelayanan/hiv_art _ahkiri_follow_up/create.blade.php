@extends('layouts.administrator.master')
@include('unit-pelayanan.rawat-jalan.pelayanan.hiv_art.include')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .form-section {
            border: 1px solid #dee2e6;
            margin-bottom: 20px;
        }

        .section-header {
            background-color: #f8f9fa;
            padding: 10px 15px;
            border-bottom: 1px solid #dee2e6;
            font-weight: bold;
        }

        .checkbox-group {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .patient-id-boxes {
            display: flex;
            gap: 5px;
        }

        .id-box {
            width: 30px;
            height: 30px;
            text-align: center;
            border: 1px solid #ccc;
        }

        .vital-signs-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }

        .vital-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Animation styles */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .was-validated .form-control:invalid {
            border-color: #dc3545;
        }

        .was-validated .form-control:valid {
            border-color: #198754;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <!-- Patient Card -->
            <div class="col-lg-3 col-md-4 mb-4">
                @include('components.patient-card')
            </div>

            <!-- Main Form -->
            <div class="col-lg-9 col-md-8">
                <div class="d-flex align-items-center mb-3">
                    <a href="{{ route('rawat-jalan.hiv_art.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}"
                        class="btn btn-outline-primary btn-sm me-2">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>

                <form id="praAnestesiForm" method="POST"
                    action="{{ route('rawat-jalan.hiv_art.store', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}">
                    @csrf

                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-primary text-white text-center py-3">
                            <h5 class="mb-0 font-weight-bold">IKHTISAR PERAWATAN PASIEN HIV DAN TERAPI ANTIRETROVIRAL (ART)
                            </h5>
                        </div>

                        <div class="card-body p-4">

                            <!-- Waktu -->
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-clock me-2"></i>Waktu</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Tanggal</label>
                                                <input type="date" class="form-control" name="tanggal"
                                                    value="{{ date('Y-m-d') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Jam</label>
                                                <input type="time" class="form-control" name="jam"
                                                    value="{{ date('H:i') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- Form Buttons -->
                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('unit-pelayanan.rawat-jalan.pelayanan.hiv_art.modal-create-alergi')
    @include('unit-pelayanan.rawat-jalan.pelayanan.hiv_art.modal-datakeluarga-mitra')
@endsection

@push('js')
    <script>
        
    </script>
@endpush
