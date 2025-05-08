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

        /* Styling untuk kartu edukasi */
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

            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100 shadow-sm">
                    <div class="card-body">
                        <div class="px-3">
                            <h4 class="header-asesmen">Intake dan Output Cairan</h4>
                        </div>

                        <div class="px-3">

                            {{-- Info Umum --}}
                            <div class="section-separator">
                                <div class="form-group">
                                    <label for="tanggal" style="min-width: 200px;">Tanggal</label>
                                    <input type="date" class="form-control"
                                        value="{{ date('Y-m-d', strtotime($intake->tanggal)) }}" disabled>
                                </div>
                            </div>

                            <div class="accordion accordion-space" id="accordionExample2">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne1">
                                        <button class="accordion-button collapsed fw-bold" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseOne2" aria-expanded="false"
                                            aria-controls="collapseOne2">
                                            07:00 s/d 14:00
                                        </button>
                                    </h2>
                                    <div id="collapseOne2" class="accordion-collapse collapse" aria-labelledby="headingOne1"
                                        data-bs-parent="#accordionExample2" style="">
                                        <div class="accordion-body">
                                            {{-- Output --}}
                                            <div class="section-separator">
                                                <h4 class="mb-3">Output</h4>

                                                <div class="form-group">
                                                    <label for="output_pagi_urine" style="min-width: 200px;">Urine</label>
                                                    <input type="number" name="output_pagi_urine" id="output_pagi_urine"
                                                        class="form-control" value="{{ $intake->output_pagi_urine ?? '0' }}"
                                                        disabled>
                                                </div>

                                                <div class="form-group">
                                                    <label for="output_pagi_muntah" style="min-width: 200px;">Muntah</label>
                                                    <input type="number" name="output_pagi_muntah" id="output_pagi_muntah"
                                                        class="form-control"
                                                        value="{{ $intake->output_pagi_muntah ?? '0' }}" disabled>
                                                </div>

                                                <div class="form-group">
                                                    <label for="output_pagi_drain" style="min-width: 200px;">Drain</label>
                                                    <input type="number" name="output_pagi_drain" id="output_pagi_drain"
                                                        class="form-control" value="{{ $intake->output_pagi_drain ?? '0' }}"
                                                        disabled>
                                                </div>

                                                <div class="form-group">
                                                    <label for="output_pagi_iwl" style="min-width: 200px;">IWL
                                                        (Insesible
                                                        water loss)</label>
                                                    <input type="number" name="output_pagi_iwl" id="output_pagi_iwl"
                                                        class="form-control" value="{{ $intake->output_pagi_iwl ?? '0' }}"
                                                        disabled>
                                                </div>
                                            </div>

                                            {{-- Intake --}}
                                            <div class="section-separator">
                                                <h4 class="mb-3">Intake</h4>

                                                <div class="form-group">
                                                    <label for="intake_pagi_iufd" style="min-width: 200px;">IUFD</label>
                                                    <input type="number" name="intake_pagi_iufd" id="intake_pagi_iufd"
                                                        class="form-control" value="{{ $intake->intake_pagi_iufd ?? '0' }}"
                                                        disabled>
                                                </div>

                                                <div class="form-group">
                                                    <label for="intake_pagi_minum" style="min-width: 200px;">Minum</label>
                                                    <input type="number" name="intake_pagi_minum" id="intake_pagi_minum"
                                                        class="form-control" value="{{ $intake->intake_pagi_minum ?? '0' }}"
                                                        disabled>
                                                </div>

                                                <div class="form-group">
                                                    <label for="intake_pagi_makan" style="min-width: 200px;">Makan</label>
                                                    <input type="number" name="intake_pagi_makan" id="intake_pagi_makan"
                                                        class="form-control" value="{{ $intake->intake_pagi_makan ?? '0' }}"
                                                        disabled>
                                                </div>

                                                <div class="form-group">
                                                    <label for="intake_pagi_ngt" style="min-width: 200px;">NGT</label>
                                                    <input type="number" name="intake_pagi_ngt" id="intake_pagi_ngt"
                                                        class="form-control"
                                                        value="{{ $intake->intake_pagi_ngt ?? '0' }}" disabled>
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
                                            14:00 s/d 20:00
                                        </button>
                                    </h2>
                                    <div id="collapseTwo2" class="accordion-collapse collapse"
                                        aria-labelledby="headingTwo2" data-bs-parent="#accordionExample2">
                                        <div class="accordion-body">
                                            {{-- Output --}}
                                            <div class="section-separator">
                                                <h4 class="mb-3">Output</h4>

                                                <div class="form-group">
                                                    <label for="output_siang_urine"
                                                        style="min-width: 200px;">Urine</label>
                                                    <input type="number" name="output_siang_urine"
                                                        id="output_siang_urine" class="form-control"
                                                        value="{{ $intake->output_siang_urine ?? '0' }}" disabled>
                                                </div>

                                                <div class="form-group">
                                                    <label for="output_siang_muntah"
                                                        style="min-width: 200px;">Muntah</label>
                                                    <input type="number" name="output_siang_muntah"
                                                        id="output_siang_muntah" class="form-control"
                                                        value="{{ $intake->output_siang_muntah ?? '0' }}" disabled>
                                                </div>

                                                <div class="form-group">
                                                    <label for="output_siang_drain"
                                                        style="min-width: 200px;">Drain</label>
                                                    <input type="number" name="output_siang_drain"
                                                        id="output_siang_drain" class="form-control"
                                                        value="{{ $intake->output_siang_drain ?? '0' }}" disabled>
                                                </div>

                                                <div class="form-group">
                                                    <label for="output_siang_iwl" style="min-width: 200px;">IWL
                                                        (Insesible
                                                        water loss)</label>
                                                    <input type="number" name="output_siang_iwl" id="output_siang_iwl"
                                                        class="form-control"
                                                        value="{{ $intake->output_siang_iwl ?? '0' }}" disabled>
                                                </div>
                                            </div>

                                            {{-- Intake --}}
                                            <div class="section-separator">
                                                <h4 class="mb-3">Intake</h4>

                                                <div class="form-group">
                                                    <label for="intake_siang_iufd" style="min-width: 200px;">IUFD</label>
                                                    <input type="number" name="intake_siang_iufd" id="intake_siang_iufd"
                                                        class="form-control"
                                                        value="{{ $intake->intake_siang_iufd ?? '0' }}" disabled>
                                                </div>

                                                <div class="form-group">
                                                    <label for="intake_siang_minum"
                                                        style="min-width: 200px;">Minum</label>
                                                    <input type="number" name="intake_siang_minum"
                                                        id="intake_siang_minum" class="form-control"
                                                        value="{{ $intake->intake_siang_minum ?? '0' }}" disabled>
                                                </div>

                                                <div class="form-group">
                                                    <label for="intake_siang_makan"
                                                        style="min-width: 200px;">Makan</label>
                                                    <input type="number" name="intake_siang_makan"
                                                        id="intake_siang_makan" class="form-control"
                                                        value="{{ $intake->intake_siang_makan ?? '0' }}" disabled>
                                                </div>

                                                <div class="form-group">
                                                    <label for="intake_siang_ngt" style="min-width: 200px;">NGT</label>
                                                    <input type="number" name="intake_siang_ngt" id="intake_siang_ngt"
                                                        class="form-control"
                                                        value="{{ $intake->intake_siang_ngt ?? '0' }}" disabled>
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
                                            20:00 s/d 07:00
                                        </button>
                                    </h2>
                                    <div id="collapseThree3" class="accordion-collapse collapse"
                                        aria-labelledby="headingThree3" data-bs-parent="#accordionExample2">
                                        <div class="accordion-body">
                                            {{-- Output --}}
                                            <div class="section-separator">
                                                <h4 class="mb-3">Output</h4>

                                                <div class="form-group">
                                                    <label for="output_malam_urine"
                                                        style="min-width: 200px;">Urine</label>
                                                    <input type="number" name="output_malam_urine"
                                                        id="output_malam_urine" class="form-control"
                                                        value="{{ $intake->output_malam_urine ?? '0' }}" disabled>
                                                </div>

                                                <div class="form-group">
                                                    <label for="output_malam_muntah"
                                                        style="min-width: 200px;">Muntah</label>
                                                    <input type="number" name="output_malam_muntah"
                                                        id="output_malam_muntah" class="form-control"
                                                        value="{{ $intake->output_malam_muntah ?? '0' }}" disabled>
                                                </div>

                                                <div class="form-group">
                                                    <label for="output_malam_drain"
                                                        style="min-width: 200px;">Drain</label>
                                                    <input type="number" name="output_malam_drain"
                                                        id="output_malam_drain" class="form-control"
                                                        value="{{ $intake->output_malam_drain ?? '0' }}" disabled>
                                                </div>

                                                <div class="form-group">
                                                    <label for="output_malam_iwl" style="min-width: 200px;">IWL
                                                        (Insesible
                                                        water loss)</label>
                                                    <input type="number" name="output_malam_iwl" id="output_malam_iwl"
                                                        class="form-control"
                                                        value="{{ $intake->output_malam_iwl ?? '0' }}" disabled>
                                                </div>
                                            </div>

                                            {{-- Intake --}}
                                            <div class="section-separator">
                                                <h4 class="mb-3">Intake</h4>

                                                <div class="form-group">
                                                    <label for="intake_malam_iufd" style="min-width: 200px;">IUFD</label>
                                                    <input type="number" name="intake_malam_iufd" id="intake_malam_iufd"
                                                        class="form-control"
                                                        value="{{ $intake->intake_malam_iufd ?? '0' }}" disabled>
                                                </div>

                                                <div class="form-group">
                                                    <label for="intake_malam_minum"
                                                        style="min-width: 200px;">Minum</label>
                                                    <input type="number" name="intake_malam_minum"
                                                        id="intake_malam_minum" class="form-control"
                                                        value="{{ $intake->intake_malam_minum ?? '0' }}" disabled>
                                                </div>

                                                <div class="form-group">
                                                    <label for="intake_malam_makan"
                                                        style="min-width: 200px;">Makan</label>
                                                    <input type="number" name="intake_malam_makan"
                                                        id="intake_malam_makan" class="form-control"
                                                        value="{{ $intake->intake_malam_makan ?? '0' }}" disabled>
                                                </div>

                                                <div class="form-group">
                                                    <label for="intake_malam_ngt" style="min-width: 200px;">NGT</label>
                                                    <input type="number" name="intake_malam_ngt" id="intake_malam_ngt"
                                                        class="form-control"
                                                        value="{{ $intake->intake_malam_ngt ?? '0' }}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
