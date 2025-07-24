@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .form-label {
            font-weight: 600;
            margin-bottom: 0.3rem;
            color: #2c3e50;
            font-size: 0.85rem;
        }

        .header-asesmen {
            margin-top: 0.5rem;
            font-size: 1.3rem;
            font-weight: 600;
            color: #0c82dc;
            text-align: center;
            margin-bottom: 1.2rem;
        }

        .btn-outline-primary {
            color: #097dd6;
            border-color: #097dd6;
        }

        .btn-outline-primary:hover {
            background-color: #097dd6;
            color: white;
        }

        .form-section {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 1rem;
            margin-bottom: 1.2rem;
        }

        .section-title {
            font-weight: 600;
            color: #004b85;
            margin-bottom: 1rem;
            font-size: 1rem;
            border-bottom: 2px solid #097dd6;
            padding-bottom: 0.3rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 0.3rem;
            display: block;
            font-size: 0.8rem;
        }

        .form-control {
            border-radius: 4px;
            border: 1px solid #ced4da;
            padding: 0.5rem;
            font-size: 0.85rem;
            height: auto;
        }

        .form-control:focus {
            border-color: #097dd6;
            box-shadow: 0 0 0 0.15rem rgba(9, 125, 214, 0.25);
        }

        .datetime-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.8rem;
        }

        .datetime-item label {
            font-weight: 500;
            color: #6c757d;
            font-size: 0.75rem;
        }

        .row {
            margin-left: -0.5rem;
            margin-right: -0.5rem;
        }

        .row > [class*="col-"] {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }

        .information-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
            font-size: 0.85rem;
        }

        .information-table th,
        .information-table td {
            border: 1px solid #dee2e6;
            padding: 0.7rem;
            text-align: left;
            vertical-align: top;
        }

        .information-table th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #495057;
            width: 20%;
        }

        .information-table td {
            background-color: white;
        }

        .information-table .center-column {
            width: 60%;
        }

        .information-table .checkbox-column {
            width: 20%;
            text-align: center;
        }

        .checkbox-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-check-input {
            margin: 0;
            transform: scale(1.2);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .datetime-group {
                grid-template-columns: 1fr;
            }
            
            .form-section {
                padding: 0.8rem;
            }

            .information-table {
                font-size: 0.75rem;
            }

            .information-table th,
            .information-table td {
                padding: 0.5rem;
            }
        }
    </style>
@endpush


@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <a href="{{ route('hemodialisa.pelayanan.persetujuan.implementasi-evaluasi-keperawatan.index', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}" class="btn btn-outline-primary mb-2">
                <i class="ti-arrow-left"></i> Kembali
            </a>

            <form id="consentForm" method="POST"
                action="{{ route('hemodialisa.pelayanan.persetujuan.implementasi-evaluasi-keperawatan.store', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}">
                @csrf

                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="header-asesmen">Form Persetujuan Implementasi Evaluasi Keperawatan</h4>

                        <div class="form-group">
                            <label class="form-label">Tanggal dan Jam Implementasi</label>
                            <div class="datetime-group">
                                <div class="datetime-item">
                                    <label>Tanggal</label>
                                    <input type="date" class="form-control" name="tanggal_implementasi" id="tanggal_implementasi">
                                </div>
                                <div class="datetime-item">
                                    <label>Jam</label>
                                    <input type="time" class="form-control" name="jam_implementasi" id="jam_implementasi">
                                </div>
                            </div>
                        </div>

                        <!-- Diagnosis Keperawatan Section -->
                        <div class="form-section">
                            <h5 class="section-title">Diagnosis Keperawatan</h5>
                            <div class="form-group">
                                <input type="text" class="form-control" name="diagnosis_keperawatan" placeholder="Masukkan diagnosis keperawatan" required>
                            </div>
                        </div>

                        <!-- Implementasi Keperawatan Section -->
                        <div class="form-section">
                            <h5 class="section-title">Implementasi Keperawatan</h5>
                            <div class="form-group">
                                <textarea rows="4" name="implementasi_keperawatan" id="implementasi_keperawatan" class="form-control"></textarea>
                            </div>
                        </div>

                        <!-- Evaluasi Keperawatan Section -->
                        <div class="form-section">
                            <h5 class="section-title">Evaluasi Keperawatan</h5>
                            <div class="form-group">
                                <textarea rows="4" name="evaluasi_keperawatan" id="evaluasi_keperawatan" class="form-control mt-2"></textarea>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary btn-l px-2" id="simpan">
                                <i class="ti-save mr-2"></i> Simpan Data
                            </button>
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
            // Mendapatkan waktu sekarang
            var currentDate = new Date();

            // Format tanggal untuk input type="date"
            var formattedDate = currentDate.toISOString().split('T')[0];
            $('#tanggal_implementasi').val(formattedDate); // Mengisi input tanggal dengan tanggal sekarang

            // Format jam untuk input type="time"
            var formattedTime = currentDate.toTimeString().split(' ')[0].substring(0, 5);
            $('#jam_implementasi').val(formattedTime); // Mengisi input jam dengan jam sekarang
        });
    </script>
@endpush
