@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .header-asesmen {
            margin-top: 1rem;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .section-separator {
            border-top: 2px solid #097dd6;
            margin: 2rem 0;
            padding-top: 1rem;
        }

        .form-group {
            margin-bottom: 1rem;
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .btn-outline-primary {
            color: #097dd6;
            border-color: #097dd6;
        }

        .btn-outline-primary:hover {
            background-color: #097dd6;
            color: white;
        }

        .time-info-group {
            background-color: #f1f8ff;
            border: 1px solid #c7e2ff;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .vital-signs-group {
            background-color: #f8f9fa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .group-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: #333;
            border-bottom: 2px solid #097dd6;
            padding-bottom: 0.5rem;
        }

        .form-control:focus {
            border-color: #097dd6;
            box-shadow: 0 0 5px rgba(9, 125, 214, 0.3);
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <a href="{{ url()->previous() }}" class="btn btn-outline-primary mb-3">
                <i class="ti-arrow-left"></i> Kembali
            </a>
            <form id="edukasiForm" method="POST"
                action="{{ route('rawat-inap.kontrol-istimewa.store', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}">
                @csrf

                <div class="d-flex justify-content-center">
                    <div class="card w-100 h-100 shadow-sm">
                        <div class="card-body">
                            <div class="px-3">
                                <h4 class="header-asesmen">Tambah Kontrol Istimewa per 15 Menit</h4>
                            </div>

                            <div class="px-3">
                                {{-- Info Waktu --}}
                                <div class="time-info-group">
                                    <div class="group-title">Informasi Waktu</div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="tanggal">Tanggal</label>
                                                <input type="text" name="tanggal" id="tanggal" class="form-control date"
                                                    value="{{ date('Y-m-d') }}" required readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="jam">Jam</label>
                                                <input type="time" name="jam" id="jam" class="form-control"
                                                    value="{{ date('H:i') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Vital Signs --}}
                                <div class="vital-signs-group">
                                    <div class="group-title">Tanda-tanda Vital</div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nadi">Nadi (per menit)</label>
                                                <input type="number" class="form-control" id="nadi" name="nadi" 
                                                    placeholder="contoh: 80" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nafas">Pernafasan (per menit)</label>
                                                <input type="number" class="form-control" id="nafas" name="nafas" 
                                                    placeholder="contoh: 20" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="sistole">Tekanan Darah Sistole (mmHg)</label>
                                                <input type="number" class="form-control" id="sistole" name="sistole"
                                                    placeholder="contoh: 120" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="diastole">Tekanan Darah Diastole (mmHg)</label>
                                                <input type="number" class="form-control" id="diastole" name="diastole"
                                                    placeholder="contoh: 80" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-primary" id="simpan">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            // Form validation jika diperlukan
            $('#edukasiForm').on('submit', function(e) {
                // Validasi dapat ditambahkan di sini jika diperlukan
            });
        });
    </script>
@endpush