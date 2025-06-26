@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .card {
            border-radius: 10px;
        }

        .card-header {
            border-radius: 10px 10px 0 0;
        }

        .form-label {
            font-size: 0.9rem;
            color: #333;
        }

        .form-control,
        .form-check-input {
            border-radius: 5px;
        }

        .btn {
            border-radius: 5px;
        }

        .text-primary {
            color: #007bff !important;
        }

        .shadow-sm {
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1) !important;
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
                    <a href="{{ url()->previous() }}" class="btn btn-outline-primary btn-sm me-2">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>

                <form id="praAnestesiForm" method="POST"
                    action="{{ route('rawat-jalan.prmrj.store', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}">
                    @csrf

                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-primary text-white text-center py-3">
                            <h5 class="mb-0 font-weight-bold">PROFIL RINGKAS MEDIS RAWAT JALAN</h5>
                        </div>

                        <div class="card-body p-4">

                            <!-- Masuk -->
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-clock me-2"></i>Waktu</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Tanggal</label>
                                                <input type="date" class="form-control" name="tanggal" value="{{ date('Y-m-d') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Jam</label>
                                                <input type="time" class="form-control" name="jam" value="{{ date('H:i') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Alergi -->
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-allergies"></i> Alergi</h6>
                                    <button type="button" class="btn btn-sm btn-outline-secondary mb-3 mt-2"
                                        id="openAlergiModal" data-bs-toggle="modal" data-bs-target="#alergiModal">
                                        <i class="ti-plus"></i> Tambah Alergi
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="section-separator" id="alergi">
                                                <input type="hidden" name="alergis" id="alergisInput" value="[]">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" id="createAlergiTable">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th width="20%">Jenis Alergi</th>
                                                                <th width="25%">Alergen</th>
                                                                <th width="25%">Reaksi</th>
                                                                <th width="20%">Tingkat Keparahan</th>
                                                                <th width="10%">Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr id="no-alergi-row">
                                                                <td colspan="5" class="text-center text-muted">Tidak ada data alergi</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Diagnosis -->
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-notes-medical me-2"></i>Diagnosis</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Diagnosis</label>
                                                <input type="text" class="form-control" name="diagnosis">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Riwayat Rawat Inap -->
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-notes-medical me-2"></i>Riwayat Rawat Inap</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Data klinis penting termasuk riwayat rawat inap atau prosedur bedah sejak kunjungan terakhir</label>
                                                <input type="text" class="form-control" name="riwayat_rawat">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pemeriksaan Penunjang -->
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-stethoscope me-2"></i>Pemeriksaan Penunjang</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Pemeriksaan Penunjang</label>
                                                <input type="text" class="form-control" name="pemeriksaan_penunjang">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tindakan/Prosedur/Terapi -->
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-procedures me-2"></i>Tindakan/Prosedur/Terapi</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Tindakan/Prosedur/Terapi</label>
                                                <input type="text" class="form-control" name="tindakan_prosedur">
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

    @include('unit-pelayanan.rawat-jalan.pelayanan.prmrj.modal-create-alergi')
@endsection
