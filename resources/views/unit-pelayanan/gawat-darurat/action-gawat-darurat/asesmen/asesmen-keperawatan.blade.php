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

        .progress-wrapper {
            background: #f8f9fa;
            border-radius: 8px;
        }

        .progress-status {
            display: flex;
            justify-content: space-between;
        }

        .progress-label {
            color: #6c757d;
            font-size: 14px;
            font-weight: 500;
        }

        .progress-percentage {
            color: #198754;
            font-weight: 600;
        }

        .custom-progress {
            height: 8px;
            background-color: #e9ecef;
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-bar-custom {
            height: 100%;
            background-color: #097dd6;
            transition: width 0.6s ease;
        }

        .section-separator {
            border-top: 2px solid #097dd6;
            margin: 2rem 0;
            padding-top: 1rem;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        .form-group label {
            width: 380px;
            margin-bottom: 0;
        }

        .form-group .form-control,
        .form-group .form-select {
            width: 100%;
        }

        .diagnosis-group {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card-keperawatan')
        </div>

        <div class="col-md-9">
            <a href="{{ url()->previous() }}" class="btn">
                <i class="ti-arrow-left"></i> Kembali
            </a>
            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        <div class="px-3">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Tanggal Asesmen</label>
                                        <input type="date" name="tgl_asesmen_keperawatan" id="tgl_asesmen_keperawatan"
                                            class="form-control" value="{{ date('Y-m-d') }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="time" name="jam_asesmen_keperawatan" id="jam_asesmen_keperawatan"
                                            class="form-control" value="{{ date('H:i') }}">
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="progress-wrapper">
                                        <div class="progress-status">
                                            <span class="progress-label">Progress Pengisian</span>
                                            <span class="progress-percentage">60%</span>
                                        </div>
                                        <div class="custom-progress">
                                            <div class="progress-bar-custom" style="width: 60%"></div>
                                        </div>
                                        <div class="mt-2">
                                            <small class="text-muted">6/10 bagian telah diisi</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h4 class="header-asesmen">Asesmen Awal Keperawatan Gawat Darurat</h4>
                            <p>
                                Isikan Asesmen awal dalam 24 jam sejak pasien masuk ke unit pelayanan
                            </p>
                        </div>

                        {{-- FORM ASESMEN AWAL KEPERATAWAN --}}

                        <div class="px-3">
                            <div class="section-separator" id="status-airway">
                                <h5 class="section-title">1. Status Air way</h5>

                                <div class="form-group">
                                    <label>Status Air way</label>
                                    <select class="form-select" name="status_airway">
                                        <option selected disabled>Pilih</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Suara nafas</label>
                                    <select class="form-select" name="suara_nafas">
                                        <option selected disabled>Pilih</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Diagnosis Keperawatan</label>
                                </div>

                                <div class="form-group">
                                    <label>Tindakan Keperawatan</label>
                                </div>
                            </div>

                            <div class="section-separator" id="status-breathing">
                                <h5 class="section-title">2. Status Breathing</h5>

                                <div class="form-group">
                                    <label>Frekuensi nafas/menit</label>
                                    <input type="text" class="form-control" name="frekuensi_nafas"
                                        placeholder="frekuensi nafas per menit">
                                </div>

                                <div class="form-group">
                                    <label>Pola nafas</label>
                                    <select class="form-select" name="pola_nafas">
                                        <option selected disabled>pilih</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Bunyi nafas</label>
                                    <select class="form-select" name="bunyi_nafas">
                                        <option selected disabled>Pilih</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Irama Nafas</label>
                                    <select class="form-select" name="irama_nafas">
                                        <option selected disabled>Pilih</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Tanda Distress Nafas</label>
                                    <select class="form-select" name="tanda_distress_nafas">
                                        <option selected disabled>Pilih</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Lainnya</label>
                                    <input class="form-control" type="text">
                                </div>
                            </div>

                            <div class="section-separator" id="status-circulation">
                                <h5 class="section-title">3. Status Circulation</h5>

                                <div class="form-group" id="status-disability">
                                    <label>Nadi Frekuensi/menit</label>
                                    <input type="text" class="form-control" name="nadi_frekuensi"
                                        placeholder="frekuensi nafas per menit">
                                </div>

                                <div class="form-group">
                                    <label>Tekanan Darah (mmHg)</label>
                                    <div class="d-flex gap-3" style="width: 100%;">
                                        <div class="flex-grow-1">
                                            <div class="mb-1">
                                                <small class="text-muted">Sistole</small>
                                            </div>
                                            <input class="form-control" type="text" name="sistole" placeholder="sistole">
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="mb-1">
                                                <small class="text-muted">Diastole</small>
                                            </div>
                                            <input class="form-control" type="text" name="diastole"
                                                placeholder="diastole">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Akral</label>
                                    <select class="form-select" name="akral">
                                        <option selected disabled>Pilih</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Pucat</label>
                                    <select class="form-select" name="pucat">
                                        <option selected disabled>Pilih</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Cianoisis</label>
                                    <select class="form-select" name="cianoisis">
                                        <option selected disabled>Pilih</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Pengisian Kapiler</label>
                                    <select class="form-select" name="pengisian_kapiler">
                                        <option selected disabled>Pilih</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Kelembapan Kulit</label>
                                    <select class="form-select" name="kelembapan_kulit">
                                        <option selected disabled>Pilih</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Tugor</label>
                                    <select class="form-select" name="tugor">
                                        <option selected disabled>Pilih</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Transfursi Darah</label>
                                    <div class="d-flex gap-3" style="width: 100%;">
                                        <div class="flex-grow-1">
                                            <div class="mb-1">
                                                <small class="text-muted">Diberikan?</small>
                                            </div>
                                            <input class="form-control" type="text" name="sistole">
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="mb-1">
                                                <small class="text-muted">Jumlah Transfursi (cc)</small>
                                            </div>
                                            <input class="form-control" type="text" name="diastole">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Lainnya</label>
                                    <input class="form-control" type="text"
                                        placeholder="isikan jika ada keluhan nafas lainnya">
                                </div>
                            </div>

                            <div class="section-separator">
                                <h5 class="section-title">4. Status Disablity</h5>

                                <div class="form-group">
                                    <label>Kesadaran</label>
                                    <select class="form-select" name="kesadaran">
                                        <option selected disabled>Pilih</option>
                                    </select>
                                </div>
                                 <div class="form-group">
                                    <label>Pupil</label>
                                    <div class="d-flex gap-3" style="width: 100%;">
                                        <div class="flex-grow-1">
                                            <div class="mb-1">
                                                <small class="text-muted">Isokor</small>
                                            </div>
                                            <input class="form-control" type="text" name="isokor">
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="mb-1">
                                                <small class="text-muted">Respon Cahaya</small>
                                            </div>
                                            <input class="form-control" type="text" name="diastole">
                                        </div>
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label>Diameter Pupil (mm)</label>
                                    <input type="text" class="form-control" name="diameter_Pupil"
                                        placeholder="frekuensi nafas per menit">
                                </div>
                                <div class="form-group">
                                    <label>Ekstremitas</label>
                                    <div class="d-flex gap-3" style="width: 100%;">
                                        <div class="flex-grow-1">
                                            <div class="mb-1">
                                                <small class="text-muted">Motorik</small>
                                            </div>
                                            <input class="form-control" type="text" name="isokor">
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="mb-1">
                                                <small class="text-muted">Sensorik</small>
                                            </div>
                                            <input class="form-control" type="text" name="diastole">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Kekuatan Ototo</label>
                                    <input class="form-control" type="text" name="kekutan_otot">
                                </div>
                                <div class="form-group">
                                    <label>Lainnya</label>
                                    <input class="form-control" type="text"
                                        placeholder="isikan jika ada keluhan nafas lainnya">
                                </div>
                            </div>

                            <div class="section-separator">
                                <h5 class="section-title">5. Status Exposure</h5>

                                <div class="form-group">
                                    <label>Kesadaran</label>
                                    <select class="form-select" name="kesadaran">
                                        <option selected disabled>Pilih</option>
                                    </select>
                                </div>
                                 <div class="form-group">
                                    <label>Pupil</label>
                                    <div class="d-flex gap-3" style="width: 100%;">
                                        <div class="flex-grow-1">
                                            <div class="mb-1">
                                                <small class="text-muted">Isokor</small>
                                            </div>
                                            <input class="form-control" type="text" name="isokor">
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="mb-1">
                                                <small class="text-muted">Respon Cahaya</small>
                                            </div>
                                            <input class="form-control" type="text" name="diastole">
                                        </div>
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label>Diameter Pupil (mm)</label>
                                    <input type="text" class="form-control" name="diameter_Pupil"
                                        placeholder="frekuensi nafas per menit">
                                </div>
                                <div class="form-group">
                                    <label>Ekstremitas</label>
                                    <div class="d-flex gap-3" style="width: 100%;">
                                        <div class="flex-grow-1">
                                            <div class="mb-1">
                                                <small class="text-muted">Motorik</small>
                                            </div>
                                            <input class="form-control" type="text" name="isokor">
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="mb-1">
                                                <small class="text-muted">Sensorik</small>
                                            </div>
                                            <input class="form-control" type="text" name="diastole">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Kekuatan Ototo</label>
                                    <input class="form-control" type="text" name="kekutan_otot">
                                </div>
                                <div class="form-group">
                                    <label>Lainnya</label>
                                    <input class="form-control" type="text"
                                        placeholder="isikan jika ada keluhan nafas lainnya">
                                </div>
                            </div>

                            <div class="section-separator" id="status-circulation">
                                <h5 class="section-title">6. Skala Nyeri</h5>

                                <div class="form-group" id="status-disability">
                                    <label>Nadi Frekuensi/menit</label>
                                    <input type="text" class="form-control" name="nadi_frekuensi"
                                        placeholder="frekuensi nafas per menit">
                                </div>

                                <div class="form-group">
                                    <label>Tekanan Darah (mmHg)</label>
                                    <div class="d-flex gap-3" style="width: 100%;">
                                        <div class="flex-grow-1">
                                            <div class="mb-1">
                                                <small class="text-muted">Sistole</small>
                                            </div>
                                            <input class="form-control" type="text" name="sistole" placeholder="sistole">
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="mb-1">
                                                <small class="text-muted">Diastole</small>
                                            </div>
                                            <input class="form-control" type="text" name="diastole"
                                                placeholder="diastole">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Akral</label>
                                    <select class="form-select" name="akral">
                                        <option selected disabled>Pilih</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Pucat</label>
                                    <select class="form-select" name="pucat">
                                        <option selected disabled>Pilih</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Cianoisis</label>
                                    <select class="form-select" name="cianoisis">
                                        <option selected disabled>Pilih</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Pengisian Kapiler</label>
                                    <select class="form-select" name="pengisian_kapiler">
                                        <option selected disabled>Pilih</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Kelembapan Kulit</label>
                                    <select class="form-select" name="kelembapan_kulit">
                                        <option selected disabled>Pilih</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Tugor</label>
                                    <select class="form-select" name="tugor">
                                        <option selected disabled>Pilih</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Transfursi Darah</label>
                                    <div class="d-flex gap-3" style="width: 100%;">
                                        <div class="flex-grow-1">
                                            <div class="mb-1">
                                                <small class="text-muted">Diberikan?</small>
                                            </div>
                                            <input class="form-control" type="text" name="sistole">
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="mb-1">
                                                <small class="text-muted">Jumlah Transfursi (cc)</small>
                                            </div>
                                            <input class="form-control" type="text" name="diastole">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Lainnya</label>
                                    <input class="form-control" type="text"
                                        placeholder="isikan jika ada keluhan nafas lainnya">
                                </div>
                            </div>
                            

                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tglAsesmen = document.getElementById('tgl_asesmen_keperawatan');
            const jamAsesmen = document.getElementById('jam_asesmen_keperawatan');

            tglAsesmen.addEventListener('change', function(e) {
                // Handle date change
            });

            jamAsesmen.addEventListener('change', function(e) {
                // Handle time change
            });
        });
    </script>
@endpush
