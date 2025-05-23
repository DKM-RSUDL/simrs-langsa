@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        /* Keep the same CSS as in create.blade.php */
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

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
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

        .form-check {
            margin: 0;
            padding-left: 1.5rem;
            min-height: auto;
        }

        .form-check-input {
            margin-top: 0.3rem;
        }

        .form-check label {
            margin-right: 0;
            padding-top: 0;
        }

        .btn-outline-primary {
            color: #097dd6;
            border-color: #097dd6;
        }

        .btn-outline-primary:hover {
            background-color: #097dd6;
            color: white;
        }

        .edukasi-cards {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .edukasi-card {
            background-color: #f8f9fa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
        }

        .edukasi-card .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: #333;
        }

        .edukasi-card .form-group {
            margin-bottom: 1.5rem;
        }

        .edukasi-card .form-check {
            margin-bottom: 0.5rem;
        }

        .edukasi-card .form-control {
            border-radius: 5px;
            border: 1px solid #ced4da;
        }

        .edukasi-card .form-control:focus {
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
                action="{{ route('rawat-inap.observasi.update', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $observasi->id]) }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="force_new" id="force_new" value="0">

                <div class="d-flex justify-content-center">
                    <div class="card w-100 h-100 shadow-sm">
                        <div class="card-body">
                            <div class="px-3">
                                <h4 class="header-asesmen">Evaluasi Harian/Catatan Observasi</h4>
                            </div>

                            <div class="px-3">
                                {{-- Info Umum --}}
                                <div class="section-separator">
                                    <div class="form-group">
                                        <label for="tanggal" style="min-width: 200px;">Tanggal</label>
                                        <input type="text" name="tanggal" id="tanggal" class="form-control date"
                                            value="{{ $observasi ? $observasi->tanggal->format('Y-m-d') : date('Y-m-d') }}"
                                            required readonly>
                                    </div>
                                </div>

                                {{-- Informasi Tambahan (di luar accordion) --}}
                                <div class="section-separator">
                                    <h4 class="section-title">Informasi Pasien</h4>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="berat_badan">Berat Badan (kg)</label>
                                                <input type="number" step="0.1" name="berat_badan" id="berat_badan"
                                                    class="form-control" value="{{ $observasi->berat_badan ?? '' }}"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="sensorium">Sensorium</label>
                                                <input type="text" name="sensorium" id="sensorium" class="form-control"
                                                    value="{{ $observasi->sensorium ?? '' }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="diet">Diet</label>
                                        <input type="text" name="diet" id="diet" class="form-control"
                                            value="{{ $observasi->diet ?? '' }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="alergi">Alergi</label>
                                        <div class="input-group">
                                            <input type="text" name="alergi_display" id="alergi_display"
                                                class="form-control" placeholder="Alergi pasien (jika ada)"
                                                value="{{ $allergiesDisplay ?? '' }}" readonly>
                                            <input type="hidden" name="alergi" id="alergi"
                                                value="{{ $allergiesJson ?? '' }}">
                                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                                data-bs-target="#alergiModal">
                                                <i class="ti-plus"></i> Tambah Alergi
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="section-separator">
                                    <h4 class="section-title">Alat Invasive</h4>

                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label class="form-label">1. NGT</label>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="ngt" id="ngt_ada"
                                                    value="Ada"
                                                    {{ $observasi && $observasi->ngt == 'Ada' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="ngt_ada">Ada</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="ngt"
                                                    id="ngt_tidak_ada" value="Tidak Ada"
                                                    {{ $observasi && $observasi->ngt == 'Tidak Ada' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="ngt_tidak_ada">Tidak Ada</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label class="form-label">2. Catheter</label>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="catheter"
                                                    id="catheter_ada" value="Ada"
                                                    {{ $observasi && $observasi->catheter == 'Ada' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="catheter_ada">Ada</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="catheter"
                                                    id="catheter_tidak_ada" value="Tidak Ada"
                                                    {{ $observasi && $observasi->catheter == 'Tidak Ada' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="catheter_tidak_ada">Tidak Ada</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label class="form-label">3. Infus</label>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="infus"
                                                    id="infus_ada" value="Ada"
                                                    {{ $observasi && $observasi->infus == 'Ada' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="infus_ada">Ada</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="infus"
                                                    id="infus_tidak_ada" value="Tidak Ada"
                                                    {{ $observasi && $observasi->infus == 'Tidak Ada' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="infus_tidak_ada">Tidak Ada</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label class="form-label">4. Triway</label>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="triway"
                                                    id="triway_ada" value="Ada"
                                                    {{ $observasi && $observasi->triway == 'Ada' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="triway_ada">Ada</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="triway"
                                                    id="triway_tidak_ada" value="Tidak Ada"
                                                    {{ $observasi && $observasi->triway == 'Tidak Ada' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="triway_tidak_ada">Tidak Ada</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label class="form-label">5. Syringe Pump</label>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="syringe_pump"
                                                    id="syringe_pump_ada" value="Ada"
                                                    {{ $observasi && $observasi->syringe_pump == 'Ada' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="syringe_pump_ada">Ada</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="syringe_pump"
                                                    id="syringe_pump_tidak_ada" value="Tidak Ada"
                                                    {{ $observasi && $observasi->syringe_pump == 'Tidak Ada' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="syringe_pump_tidak_ada">Tidak
                                                    Ada</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label class="form-label">6. Infus Pump</label>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="infus_pump"
                                                    id="infus_pump_ada" value="Ada"
                                                    {{ $observasi && $observasi->infus_pump == 'Ada' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="infus_pump_ada">Ada</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="infus_pump"
                                                    id="infus_pump_tidak_ada" value="Tidak Ada"
                                                    {{ $observasi && $observasi->infus_pump == 'Tidak Ada' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="infus_pump_tidak_ada">Tidak
                                                    Ada</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Accordion Vital Sign --}}
                                <div class="section-separator">
                                    <h4 class="section-title">Pemeriksaan Berkala</h4>
                                </div>

                                <div class="accordion accordion-space" id="accordionExample2">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingOne1">
                                            <button class="accordion-button collapsed fw-bold" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseOne2"
                                                aria-expanded="false" aria-controls="collapseOne2">
                                                06:00
                                            </button>
                                        </h2>
                                        <div id="collapseOne2" class="accordion-collapse collapse"
                                            aria-labelledby="headingOne1" data-bs-parent="#accordionExample2">
                                            <div class="accordion-body">
                                                {{-- Vital Sign --}}
                                                <div class="section-separator">
                                                    <h4 class="mb-3">Vital Sign</h4>

                                                    <div class="form-group">
                                                        <label for="suhu_pagi" style="min-width: 200px;">Suhu/temp
                                                            (°C)</label>
                                                        <input type="number" step="0.1" name="suhu_pagi"
                                                            id="suhu_pagi" class="form-control"
                                                            value="{{ $existingDetails->has('06:00') ? $existingDetails['06:00']->suhu : '' }}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="nadi_pagi" style="min-width: 200px;">Nadi
                                                            (x/mnt)</label>
                                                        <input type="number" name="nadi_pagi" id="nadi_pagi"
                                                            class="form-control"
                                                            value="{{ $existingDetails->has('06:00') ? $existingDetails['06:00']->nadi : '' }}">
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="tekanan_darah_sistole_pagi">Tekanan Darah
                                                                    Sistole (mmHg)</label>
                                                                <input type="number" name="tekanan_darah_sistole_pagi"
                                                                    id="tekanan_darah_sistole_pagi" class="form-control"
                                                                    value="{{ $existingDetails->has('06:00') ? $existingDetails['06:00']->tekanan_darah_sistole : '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="tekanan_darah_diastole_pagi">Tekanan Darah
                                                                    Diastole (mmHg)</label>
                                                                <input type="number" name="tekanan_darah_diastole_pagi"
                                                                    id="tekanan_darah_diastole_pagi" class="form-control"
                                                                    value="{{ $existingDetails->has('06:00') ? $existingDetails['06:00']->tekanan_darah_diastole : '' }}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="respirasi_pagi" style="min-width: 200px;">Respirasi
                                                            (x/mnt)</label>
                                                        <input type="number" name="respirasi_pagi" id="respirasi_pagi"
                                                            class="form-control"
                                                            value="{{ $existingDetails->has('06:00') ? $existingDetails['06:00']->respirasi : '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingTwo2">
                                            <button class="accordion-button collapsed fw-bold" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseTwo2"
                                                aria-expanded="false" aria-controls="collapseTwo2">
                                                11:00
                                            </button>
                                        </h2>
                                        <div id="collapseTwo2" class="accordion-collapse collapse"
                                            aria-labelledby="headingTwo2" data-bs-parent="#accordionExample2">
                                            <div class="accordion-body">
                                                {{-- Vital Sign --}}
                                                <div class="section-separator">
                                                    <h4 class="mb-3">Vital Sign</h4>

                                                    <div class="form-group">
                                                        <label for="suhu_siang" style="min-width: 200px;">Suhu/temp
                                                            (°C)</label>
                                                        <input type="number" step="0.1" name="suhu_siang"
                                                            id="suhu_siang" class="form-control"
                                                            value="{{ $existingDetails->has('12:00') ? $existingDetails['12:00']->suhu : '' }}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="nadi_siang" style="min-width: 200px;">Nadi
                                                            (x/mnt)</label>
                                                        <input type="number" name="nadi_siang" id="nadi_siang"
                                                            class="form-control"
                                                            value="{{ $existingDetails->has('12:00') ? $existingDetails['12:00']->nadi : '' }}">
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="tekanan_darah_sistole_siang">Tekanan Darah
                                                                    Sistole (mmHg)</label>
                                                                <input type="number" name="tekanan_darah_sistole_siang"
                                                                    id="tekanan_darah_sistole_siang" class="form-control"
                                                                    value="{{ $existingDetails->has('12:00') ? $existingDetails['12:00']->tekanan_darah_sistole : '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="tekanan_darah_diastole_siang">Tekanan Darah
                                                                    Diastole (mmHg)</label>
                                                                <input type="number" name="tekanan_darah_diastole_siang"
                                                                    id="tekanan_darah_diastole_siang" class="form-control"
                                                                    value="{{ $existingDetails->has('12:00') ? $existingDetails['12:00']->tekanan_darah_diastole : '' }}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="respirasi_siang" style="min-width: 200px;">Respirasi
                                                            (x/mnt)</label>
                                                        <input type="number" name="respirasi_siang" id="respirasi_siang"
                                                            class="form-control"
                                                            value="{{ $existingDetails->has('12:00') ? $existingDetails['12:00']->respirasi : '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingThree3">
                                            <button class="accordion-button collapsed fw-bold" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseThree3"
                                                aria-expanded="false" aria-controls="collapseThree3">
                                                15:00
                                            </button>
                                        </h2>
                                        <div id="collapseThree3" class="accordion-collapse collapse"
                                            aria-labelledby="headingThree3" data-bs-parent="#accordionExample2">
                                            <div class="accordion-body">
                                                {{-- Vital Sign --}}
                                                <div class="section-separator">
                                                    <h4 class="mb-3">Vital Sign</h4>

                                                    <div class="form-group">
                                                        <label for="suhu_sore" style="min-width: 200px;">Suhu/temp
                                                            (°C)</label>
                                                        <input type="number" step="0.1" name="suhu_sore"
                                                            id="suhu_sore" class="form-control"
                                                            value="{{ $existingDetails->has('18:00') ? $existingDetails['18:00']->suhu : '' }}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="nadi_sore" style="min-width: 200px;">Nadi
                                                            (x/mnt)</label>
                                                        <input type="number" name="nadi_sore" id="nadi_sore"
                                                            class="form-control"
                                                            value="{{ $existingDetails->has('18:00') ? $existingDetails['18:00']->nadi : '' }}">
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="tekanan_darah_sistole_sore">Tekanan Darah
                                                                    Sistole (mmHg)</label>
                                                                <input type="number" name="tekanan_darah_sistole_sore"
                                                                    id="tekanan_darah_sistole_sore" class="form-control"
                                                                    value="{{ $existingDetails->has('18:00') ? $existingDetails['18:00']->tekanan_darah_sistole : '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="tekanan_darah_diastole_sore">Tekanan Darah
                                                                    Diastole (mmHg)</label>
                                                                <input type="number" name="tekanan_darah_diastole_sore"
                                                                    id="tekanan_darah_diastole_sore" class="form-control"
                                                                    value="{{ $existingDetails->has('18:00') ? $existingDetails['18:00']->tekanan_darah_diastole : '' }}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="respirasi_sore" style="min-width: 200px;">Respirasi
                                                            (x/mnt)</label>
                                                        <input type="number" name="respirasi_sore" id="respirasi_sore"
                                                            class="form-control"
                                                            value="{{ $existingDetails->has('18:00') ? $existingDetails['18:00']->respirasi : '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingFour4">
                                            <button class="accordion-button collapsed fw-bold" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseFour4"
                                                aria-expanded="false" aria-controls="collapseFour4">
                                                20:00
                                            </button>
                                        </h2>
                                        <div id="collapseFour4" class="accordion-collapse collapse"
                                            aria-labelledby="headingFour4" data-bs-parent="#accordionExample2">
                                            <div class="accordion-body">
                                                {{-- Vital Sign --}}
                                                <div class="section-separator">
                                                    <h4 class="mb-3">Vital Sign</h4>

                                                    <div class="form-group">
                                                        <label for="suhu_malam" style="min-width: 200px;">Suhu/temp
                                                            (°C)</label>
                                                        <input type="number" step="0.1" name="suhu_malam"
                                                            id="suhu_malam" class="form-control"
                                                            value="{{ $existingDetails->has('24:00') ? $existingDetails['24:00']->suhu : '' }}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="nadi_malam" style="min-width: 200px;">Nadi
                                                            (x/mnt)</label>
                                                        <input type="number" name="nadi_malam" id="nadi_malam"
                                                            class="form-control"
                                                            value="{{ $existingDetails->has('24:00') ? $existingDetails['24:00']->nadi : '' }}">
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="tekanan_darah_sistole_malam">Tekanan Darah
                                                                    Sistole (mmHg)</label>
                                                                <input type="number" name="tekanan_darah_sistole_malam"
                                                                    id="tekanan_darah_sistole_malam" class="form-control"
                                                                    value="{{ $existingDetails->has('24:00') ? $existingDetails['24:00']->tekanan_darah_sistole : '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="tekanan_darah_diastole_malam">Tekanan Darah
                                                                    Diastole (mmHg)</label>
                                                                <input type="number" name="tekanan_darah_diastole_malam"
                                                                    id="tekanan_darah_diastole_malam" class="form-control"
                                                                    value="{{ $existingDetails->has('24:00') ? $existingDetails['24:00']->tekanan_darah_diastole : '' }}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="respirasi_malam" style="min-width: 200px;">Respirasi
                                                            (x/mnt)</label>
                                                        <input type="number" name="respirasi_malam" id="respirasi_malam"
                                                            class="form-control"
                                                            value="{{ $existingDetails->has('24:00') ? $existingDetails['24:00']->respirasi : '' }}">
                                                    </div>
                                                </div>
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

@include('unit-pelayanan.rawat-inap.pelayanan.observasi.alergi')

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle radio button initialization for existing data
            function initRadioButtons() {
                // NGT radio buttons
                if ('{{ $observasi->ngt ?? '' }}' === 'Ada') {
                    document.getElementById('ngt_ada').checked = true;
                } else if ('{{ $observasi->ngt ?? '' }}' === 'Tidak Ada') {
                    document.getElementById('ngt_tidak_ada').checked = true;
                }

                // Catheter radio buttons
                if ('{{ $observasi->catheter ?? '' }}' === 'Ada') {
                    document.getElementById('catheter_ada').checked = true;
                } else if ('{{ $observasi->catheter ?? '' }}' === 'Tidak Ada') {
                    document.getElementById('catheter_tidak_ada').checked = true;
                }

                // Infus radio buttons
                if ('{{ $observasi->infus ?? '' }}' === 'Ada') {
                    document.getElementById('infus_ada').checked = true;
                } else if ('{{ $observasi->infus ?? '' }}' === 'Tidak Ada') {
                    document.getElementById('infus_tidak_ada').checked = true;
                }

                // Triway radio buttons
                if ('{{ $observasi->triway ?? '' }}' === 'Ada') {
                    document.getElementById('triway_ada').checked = true;
                } else if ('{{ $observasi->triway ?? '' }}' === 'Tidak Ada') {
                    document.getElementById('triway_tidak_ada').checked = true;
                }

                // Syringe Pump radio buttons
                if ('{{ $observasi->syringe_pump ?? '' }}' === 'Ada') {
                    document.getElementById('syringe_pump_ada').checked = true;
                } else if ('{{ $observasi->syringe_pump ?? '' }}' === 'Tidak Ada') {
                    document.getElementById('syringe_pump_tidak_ada').checked = true;
                }

                // Infus Pump radio buttons
                if ('{{ $observasi->infus_pump ?? '' }}' === 'Ada') {
                    document.getElementById('infus_pump_ada').checked = true;
                } else if ('{{ $observasi->infus_pump ?? '' }}' === 'Tidak Ada') {
                    document.getElementById('infus_pump_tidak_ada').checked = true;
                }
            }

            // Initialize radio buttons on page load
            initRadioButtons();

            // Form validation specific to radio buttons
            document.getElementById('edukasiForm').addEventListener('submit', function(e) {
                // Check if at least one option is selected for each radio button group
                const ngtSelected = document.querySelector('input[name="ngt"]:checked');
                const catheterSelected = document.querySelector('input[name="catheter"]:checked');
                const infusSelected = document.querySelector('input[name="infus"]:checked');
                const triwaySelected = document.querySelector('input[name="triway"]:checked');
                const syringePumpSelected = document.querySelector('input[name="syringe_pump"]:checked');
                const infusPumpSelected = document.querySelector('input[name="infus_pump"]:checked');

                let errorMessages = [];

                if (!ngtSelected) {
                    errorMessages.push('Silakan pilih status NGT (Ada/Tidak Ada)');
                }

                if (!catheterSelected) {
                    errorMessages.push('Silakan pilih status Catheter (Ada/Tidak Ada)');
                }

                if (!infusSelected) {
                    errorMessages.push('Silakan pilih status Infus (Ada/Tidak Ada)');
                }

                if (!triwaySelected) {
                    errorMessages.push('Silakan pilih status Triway (Ada/Tidak Ada)');
                }

                if (!syringePumpSelected) {
                    errorMessages.push('Silakan pilih status Syringe Pump (Ada/Tidak Ada)');
                }

                if (!infusPumpSelected) {
                    errorMessages.push('Silakan pilih status Infus Pump (Ada/Tidak Ada)');
                }

                if (errorMessages.length > 0) {
                    e.preventDefault(); // Prevent form submission

                    Swal.fire({
                        icon: 'warning',
                        title: 'Data Belum Lengkap',
                        html: errorMessages.join('<br>'),
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                }
            });

            // Check if there is another observation for the same date (excluding the current one)
            @php
                $otherObservasi = App\Models\RmeObservasi::where('kd_pasien', $dataMedis->kd_pasien)->where('kd_unit', $dataMedis->kd_unit)->where('urut_masuk', $dataMedis->urut_masuk)->whereDate('tanggal', $observasi->tanggal)->where('id', '!=', $observasi->id)->exists();
            @endphp

            @if ($otherObservasi)
                Swal.fire({
                    title: 'Data Observasi Hari Ini Sudah Ada',
                    text: 'Apakah Anda ingin melanjutkan mengisi waktu yang belum terisi untuk data hari ini, atau membuat data observasi baru?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Lanjutkan Data Existing',
                    cancelButtonText: 'Buat Data Baru'
                }).then((result) => {
                    if (!result.isConfirmed) {
                        // User chose to create new data
                        document.getElementById('force_new').value = '1';

                        // Clear existing data in the form EXCEPT allergies and use last weight data
                        const lastWeight = '{{ $lastWeight ?? '' }}';
                        if (lastWeight) {
                            document.getElementById('berat_badan').value = lastWeight;
                        } else {
                            document.getElementById('berat_badan').value = '';
                        }

                        document.getElementById('sensorium').value = '';

                        // Reset radio buttons
                        document.getElementById('ngt_ada').checked = false;
                        document.getElementById('ngt_tidak_ada').checked = false;
                        document.getElementById('catheter_ada').checked = false;
                        document.getElementById('catheter_tidak_ada').checked = false;
                        document.getElementById('infus_ada').checked = false;
                        document.getElementById('infus_tidak_ada').checked = false;
                        document.getElementById('triway_ada').checked = false;
                        document.getElementById('triway_tidak_ada').checked = false;
                        document.getElementById('syringe_pump_ada').checked = false;
                        document.getElementById('syringe_pump_tidak_ada').checked = false;
                        document.getElementById('infus_pump_ada').checked = false;
                        document.getElementById('infus_pump_tidak_ada').checked = false;

                        // Clear other fields except allergies
                        document.getElementById('diet').value = '';

                        // DO NOT clear allergies
                        // document.getElementById('alergi').value = '';
                        // document.getElementById('alergi_display').value = '';

                        // Clear vital sign inputs
                        const times = ['pagi', 'siang', 'sore', 'malam'];
                        const fields = ['suhu', 'nadi', 'tekanan_darah_sistole', 'tekanan_darah_diastole',
                            'respirasi'
                        ];
                        times.forEach(time => {
                            fields.forEach(field => {
                                const input = document.getElementById(`${field}_${time}`);
                                if (input) input.value = '';
                            });
                        });
                    }
                });
            @endif
        });
    </script>
@endpush
