@extends('layouts.administrator.master')

@section('content')
    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
        <style>
            .card-header {
                font-weight: bold;
            }

            .form-label {
                font-weight: 600;
                margin-bottom: 0.3rem;
            }

            .required::after {
                content: '*';
                color: red;
                margin-left: 0.2rem;
            }

            .invalid-feedback {
                display: none;
            }

            .is-invalid~.invalid-feedback {
                display: block;
            }

            .form-section {
                max-width: 100%;
            }

            .hover-shadow {
                transition: all 0.3s ease;
                cursor: pointer;
            }

            .hover-shadow:hover {
                box-shadow: 0 4px 12px rgba(0, 123, 255, 0.15) !important;
                transform: translateY(-1px);
            }

            .form-check-input:checked+.form-check-label .badge {
                transform: scale(1.1);
            }

            /* Card active state - hanya background soft */
            .form-check-input:checked+.form-check-label {
                background-color: rgba(0, 123, 255, 0.1) !important;
            }

            /* Warna soft sesuai dengan badge skor */
            .form-check-input[value="0"]:checked+.form-check-label {
                background-color: rgba(25, 135, 84, 0.1) !important;
                /* soft green */
            }

            .form-check-input[value="1"]:checked+.form-check-label {
                background-color: rgba(255, 193, 7, 0.1) !important;
                /* soft yellow */
            }

            .form-check-input[value="2"]:checked+.form-check-label {
                background-color: rgba(253, 126, 20, 0.1) !important;
                /* soft orange */
            }

            .form-check-input[value="3"]:checked+.form-check-label {
                background-color: rgba(220, 53, 69, 0.1) !important;
                /* soft red */
            }
        </style>
    @endpush

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <x-content-card>
                <x-button-previous />

                @include('components.page-header', [
                    'title' => 'Tambah Data Malnutrition Inflammation Score Pasien Hemodialisa',
                    'description' =>
                        'Tambah data Malnutrition Inflammation Score Pasien Hemodialisa dengan mengisi formulir di bawah ini.',
                ])

                <hr>

                <div class="form-section">
                    <form id="beratBadanForm" method="POST"
                        action="{{ route('hemodialisa.pelayanan.malnutrition-inflammation-score.store', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}">
                        @csrf

                        <!-- Patient Information Section -->
                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0">
                                    <i class="bi bi-person-lines-fill me-2"></i>
                                    Data Awal
                                </h6>
                            </div>
                            <div class="card-body">

                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Tanggal Rawat</label>
                                                    <div class="input-group">
                                                        <input type="date" class="form-control" name="tgl_rawat"
                                                            value="" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Jam Rawat</label>
                                                    <div class="input-group">
                                                        <input type="time" class="form-control" name="jam_rawat"
                                                            value="" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Diagnosis Medis </label>
                                            <textarea class="form-control" name="diagnosis_medis" rows="2"></textarea>
                                        </div>

                                    </div>

                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Berat Badan (kg)</label>
                                                    <div class="input-group">
                                                        <input type="number" step="0.01" class="form-control"
                                                            name="berat_badan" placeholder="kg" value="">
                                                        <span class="input-group-text">kg</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Tinggi Badan (cm)</label>
                                                    <div class="input-group">
                                                        <input type="number" step="0.01" class="form-control"
                                                            name="tinggi_badan" placeholder="cm" value="">
                                                        <span class="input-group-text">cm</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0">
                                    <i class="bi bi-clipboard-data me-2"></i>
                                    A. RIWAYAT MEDIS
                                </h6>
                            </div>
                            <div class="card-body">

                                <!-- 1. Perubahan berat badan kering -->
                                <div class="card border-0 shadow-sm mb-2">
                                    <div class="card-body py-2">
                                        <h6 class="fw-bold text-primary mb-3" style="font-size: 1.1rem;">
                                            1. Perubahan berat badan kering di akhir dialysis
                                            <small class="text-muted d-block"
                                                style="font-size: 0.9rem; font-weight: normal;">
                                                (perubahan keseluruhan pada 3-6 bulan terakhir)
                                            </small>
                                        </h6>
                                        <div class="row g-3">
                                            <div class="col-lg-6 col-xl-3">
                                                <div
                                                    class="form-check p-3 border rounded-3 h-100 position-relative hover-shadow">
                                                    <input class="form-check-input" type="radio"
                                                        name="perubahan_bb_kering" id="bb_kering_0" value="0">
                                                    <label class="form-check-label w-100" for="bb_kering_0">
                                                        <span
                                                            class="badge bg-success position-absolute top-0 end-0 m-2">0</span>
                                                        <strong class="d-block mb-1">
                                                            < 0,5 kg</strong>
                                                                <small class="text-muted">Minimal</small>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-3">
                                                <div
                                                    class="form-check p-3 border rounded-3 h-100 position-relative hover-shadow">
                                                    <input class="form-check-input" type="radio"
                                                        name="perubahan_bb_kering" id="bb_kering_1" value="1">
                                                    <label class="form-check-label w-100" for="bb_kering_1">
                                                        <span
                                                            class="badge bg-warning position-absolute top-0 end-0 m-2">1</span>
                                                        <strong class="d-block mb-1">0,5 - 1 kg</strong>
                                                        <small class="text-muted">Ringan</small>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-3">
                                                <div
                                                    class="form-check p-3 border rounded-3 h-100 position-relative hover-shadow">
                                                    <input class="form-check-input" type="radio"
                                                        name="perubahan_bb_kering" id="bb_kering_2" value="2">
                                                    <label class="form-check-label w-100" for="bb_kering_2">
                                                        <span class="badge bg-orange position-absolute top-0 end-0 m-2"
                                                            style="background-color: #fd7e14;">2</span>
                                                        <strong class="d-block mb-1">≥ 1 kg tapi < 5 %</strong>
                                                                <small class="text-muted">Sedang</small>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-3">
                                                <div
                                                    class="form-check p-3 border rounded-3 h-100 position-relative hover-shadow">
                                                    <input class="form-check-input" type="radio"
                                                        name="perubahan_bb_kering" id="bb_kering_3" value="3">
                                                    <label class="form-check-label w-100" for="bb_kering_3">
                                                        <span
                                                            class="badge bg-danger position-absolute top-0 end-0 m-2">3</span>
                                                        <strong class="d-block mb-1">≤ 5 %</strong>
                                                        <small class="text-muted">Berat</small>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- 2. Asupan Diet -->
                                <div class="card border-0 shadow-sm mb-2">
                                    <div class="card-body py-2">
                                        <h6 class="fw-bold text-primary mb-3" style="font-size: 1.1rem;">
                                            2. Asupan Diet
                                        </h6>
                                        <div class="row g-3">
                                            <div class="col-lg-6 col-xl-3">
                                                <div
                                                    class="form-check p-3 border rounded-3 h-100 position-relative hover-shadow">
                                                    <input class="form-check-input" type="radio" name="asupan_diet"
                                                        id="asupan_diet_0" value="0">
                                                    <label class="form-check-label w-100" for="asupan_diet_0">
                                                        <span
                                                            class="badge bg-success position-absolute top-0 end-0 m-2">0</span>
                                                        <strong class="d-block mb-2">Nafsu makan baik Asupan tidak
                                                            menurun</strong>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-3">
                                                <div
                                                    class="form-check p-3 border rounded-3 h-100 position-relative hover-shadow">
                                                    <input class="form-check-input" type="radio" name="asupan_diet"
                                                        id="asupan_diet_1" value="1">
                                                    <label class="form-check-label w-100" for="asupan_diet_1">
                                                        <span
                                                            class="badge bg-warning position-absolute top-0 end-0 m-2">1</span>
                                                        <strong class="d-block mb-2">Asupan diet padat suboptimal</strong>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-3">
                                                <div
                                                    class="form-check p-3 border rounded-3 h-100 position-relative hover-shadow">
                                                    <input class="form-check-input" type="radio" name="asupan_diet"
                                                        id="asupan_diet_2" value="2">
                                                    <label class="form-check-label w-100" for="asupan_diet_2">
                                                        <span class="badge bg-orange position-absolute top-0 end-0 m-2"
                                                            style="background-color: #fd7e14;">2</span>
                                                        <strong class="d-block mb-2">Berkurangnya asupan makan padat dan
                                                            cair</strong>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-3">
                                                <div
                                                    class="form-check p-3 border rounded-3 h-100 position-relative hover-shadow">
                                                    <input class="form-check-input" type="radio" name="asupan_diet"
                                                        id="asupan_diet_3" value="3">
                                                    <label class="form-check-label w-100" for="asupan_diet_3">
                                                        <span
                                                            class="badge bg-danger position-absolute top-0 end-0 m-2">3</span>
                                                        <strong class="d-block mb-2">Starvasi karena diet cair pun tidak
                                                            masuk</strong>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- 3. Gejala gastrointestinal -->
                                <div class="card border-0 shadow-sm mb-2">
                                    <div class="card-body py-2">
                                        <h6 class="fw-bold text-primary mb-3" style="font-size: 1.1rem;">
                                            3. Gejala Gastrointestinal
                                        </h6>
                                        <div class="row g-3">
                                            <div class="col-lg-6 col-xl-3">
                                                <div
                                                    class="form-check p-3 border rounded-3 h-100 position-relative hover-shadow">
                                                    <input class="form-check-input" type="radio"
                                                        name="gejala_gastrointestinal" id="gejala_gi_0" value="0">
                                                    <label class="form-check-label w-100" for="gejala_gi_0">
                                                        <span
                                                            class="badge bg-success position-absolute top-0 end-0 m-2">0</span>
                                                        <strong class="d-block mb-2">Tidak ada gejala dengan Nafsu makan
                                                            baik</strong>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-3">
                                                <div
                                                    class="form-check p-3 border rounded-3 h-100 position-relative hover-shadow">
                                                    <input class="form-check-input" type="radio"
                                                        name="gejala_gastrointestinal" id="gejala_gi_1" value="1">
                                                    <label class="form-check-label w-100" for="gejala_gi_1">
                                                        <span
                                                            class="badge bg-warning position-absolute top-0 end-0 m-2">1</span>
                                                        <strong class="d-block mb-2">Gejala ringan, nafsu makan buruk atau
                                                            kadang mual</strong>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-3">
                                                <div
                                                    class="form-check p-3 border rounded-3 h-100 position-relative hover-shadow">
                                                    <input class="form-check-input" type="radio"
                                                        name="gejala_gastrointestinal" id="gejala_gi_2" value="2">
                                                    <label class="form-check-label w-100" for="gejala_gi_2">
                                                        <span class="badge bg-orange position-absolute top-0 end-0 m-2"
                                                            style="background-color: #fd7e14;">2</span>
                                                        <strong class="d-block mb-2">Kadang muntah atau Gejala IG
                                                            sedang</strong>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-3">
                                                <div
                                                    class="form-check p-3 border rounded-3 h-100 position-relative hover-shadow">
                                                    <input class="form-check-input" type="radio"
                                                        name="gejala_gastrointestinal" id="gejala_gi_3" value="3">
                                                    <label class="form-check-label w-100" for="gejala_gi_3">
                                                        <span
                                                            class="badge bg-danger position-absolute top-0 end-0 m-2">3</span>
                                                        <strong class="d-block mb-2">Sering diare atau muntah atau
                                                            anoreksia
                                                            berat</strong>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- 4. Kapasitas fungsional -->
                                <div class="card border-0 shadow-sm mb-2">
                                    <div class="card-body py-2">
                                        <h6 class="fw-bold text-primary mb-3" style="font-size: 1.1rem;">
                                            4. Kapasitas Fungsional
                                            <small class="text-muted d-block"
                                                style="font-size: 0.9rem; font-weight: normal;">
                                                (hubungan nutrisi dengan gangguan fungsional)
                                            </small>
                                        </h6>
                                        <div class="row g-3">
                                            <div class="col-lg-6 col-xl-3">
                                                <div
                                                    class="form-check p-3 border rounded-3 h-100 position-relative hover-shadow">
                                                    <input class="form-check-input" type="radio"
                                                        name="kapasitas_fungsional" id="kapasitas_0" value="0">
                                                    <label class="form-check-label w-100" for="kapasitas_0">
                                                        <span
                                                            class="badge bg-success position-absolute top-0 end-0 m-2">0</span>
                                                        <strong class="d-block mb-2">Kapasitas fungsional normal, Merasa
                                                            Sehat</strong>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-3">
                                                <div
                                                    class="form-check p-3 border rounded-3 h-100 position-relative hover-shadow">
                                                    <input class="form-check-input" type="radio"
                                                        name="kapasitas_fungsional" id="kapasitas_1" value="1">
                                                    <label class="form-check-label w-100" for="kapasitas_1">
                                                        <span
                                                            class="badge bg-warning position-absolute top-0 end-0 m-2">1</span>
                                                        <strong class="d-block mb-2">Kadang sulit melakukan aktifitas dasar
                                                            atau sering merasa lelah</strong>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-3">
                                                <div
                                                    class="form-check p-3 border rounded-3 h-100 position-relative hover-shadow">
                                                    <input class="form-check-input" type="radio"
                                                        name="kapasitas_fungsional" id="kapasitas_2" value="2">
                                                    <label class="form-check-label w-100" for="kapasitas_2">
                                                        <span class="badge bg-orange position-absolute top-0 end-0 m-2"
                                                            style="background-color: #fd7e14;">2</span>
                                                        <strong class="d-block mb-2">Sulit melakukan aktivitas
                                                            mandiri</strong>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-3">
                                                <div
                                                    class="form-check p-3 border rounded-3 h-100 position-relative hover-shadow">
                                                    <input class="form-check-input" type="radio"
                                                        name="kapasitas_fungsional" id="kapasitas_3" value="3">
                                                    <label class="form-check-label w-100" for="kapasitas_3">
                                                        <span
                                                            class="badge bg-danger position-absolute top-0 end-0 m-2">3</span>
                                                        <strong class="d-block mb-2">Terbaring di bed/kursi atau dengan
                                                            aktifitas kecil sampai tidak bisa melakukan apa apa.</strong>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- 5. Komorbiditas -->
                                <div class="card border-0 shadow-sm mb-2">
                                    <div class="card-body py-2">
                                        <h6 class="fw-bold text-primary mb-3" style="font-size: 1.1rem;">
                                            5. Komorbiditas
                                            <small class="text-muted d-block"
                                                style="font-size: 0.9rem; font-weight: normal;">
                                                (termasuk lama tahun dialysis)
                                            </small>
                                        </h6>
                                        <div class="row g-3">
                                            <div class="col-lg-6 col-xl-3">
                                                <div
                                                    class="form-check p-3 border rounded-3 h-100 position-relative hover-shadow">
                                                    <input class="form-check-input" type="radio" name="komorbiditas"
                                                        id="komorbiditas_0" value="0">
                                                    <label class="form-check-label w-100" for="komorbiditas_0">
                                                        <span
                                                            class="badge bg-success position-absolute top-0 end-0 m-2">0</span>
                                                        <strong class="d-block mb-2">Tanpa komorbiditas dalam Dialysis
                                                            selama 1
                                                            tahun terakhir</strong>
                                                        <small class="text-muted"></small>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-3">
                                                <div
                                                    class="form-check p-3 border rounded-3 h-100 position-relative hover-shadow">
                                                    <input class="form-check-input" type="radio" name="komorbiditas"
                                                        id="komorbiditas_1" value="1">
                                                    <label class="form-check-label w-100" for="komorbiditas_1">
                                                        <span
                                                            class="badge bg-warning position-absolute top-0 end-0 m-2">1</span>
                                                        <strong class="d-block mb-2">Komorbiditas ringan, dalam Dialysis
                                                            1-4
                                                            tahun (termasuk MMC*)</strong>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-3">
                                                <div
                                                    class="form-check p-3 border rounded-3 h-100 position-relative hover-shadow">
                                                    <input class="form-check-input" type="radio" name="komorbiditas"
                                                        id="komorbiditas_2" value="2">
                                                    <label class="form-check-label w-100" for="komorbiditas_2">
                                                        <span class="badge bg-orange position-absolute top-0 end-0 m-2"
                                                            style="background-color: #fd7e14;">2</span>
                                                        <strong class="d-block mb-2">Komorbiditas sedang, dalam Dialysis >
                                                            4
                                                            tahun (termasuk MMC*)</strong>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-3">
                                                <div
                                                    class="form-check p-3 border rounded-3 h-100 position-relative hover-shadow">
                                                    <input class="form-check-input" type="radio" name="komorbiditas"
                                                        id="komorbiditas_3" value="3">
                                                    <label class="form-check-label w-100" for="komorbiditas_3">
                                                        <span
                                                            class="badge bg-danger position-absolute top-0 end-0 m-2">3</span>
                                                        <strong class="d-block mb-2">Setiap Komorditas berta multiple (2
                                                            atau
                                                            lebih MMC)</strong>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Section B: Physical Examination -->
                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0">
                                    <i class="bi bi-person-check me-2"></i>
                                    B. PEMERIKSAAN FISIK
                                </h6>
                            </div>
                            <div class="card-body">

                                <!-- 6. Berkurangnya cadangan lemak atau kehilangan lemak subkutan -->
                                <div class="card border-0 shadow-sm mb-2">
                                    <div class="card-body py-2">
                                        <h6 class="fw-bold text-primary mb-3" style="font-size: 1.1rem;">
                                            6. Berkurangnya cadangan lemak atau kehilangan lemak subkutan
                                            <small class="text-muted d-block"
                                                style="font-size: 0.9rem; font-weight: normal;">
                                                (bawah mata, trisep, bisep, dada)
                                            </small>
                                        </h6>
                                        <div class="row g-3">
                                            <div class="col-lg-6 col-xl-3">
                                                <div
                                                    class="form-check p-3 border rounded-3 h-100 position-relative hover-shadow">
                                                    <input class="form-check-input" type="radio"
                                                        name="berkurang_cadangan_lemak" id="cadangan_lemak_0"
                                                        value="0">
                                                    <label class="form-check-label w-100" for="cadangan_lemak_0">
                                                        <span
                                                            class="badge bg-success position-absolute top-0 end-0 m-2">0</span>
                                                        <strong class="d-block mb-2">Tidak ada perubahan</strong>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-3">
                                                <div
                                                    class="form-check p-3 border rounded-3 h-100 position-relative hover-shadow">
                                                    <input class="form-check-input" type="radio"
                                                        name="berkurang_cadangan_lemak" id="cadangan_lemak_1"
                                                        value="1">
                                                    <label class="form-check-label w-100" for="cadangan_lemak_1">
                                                        <span
                                                            class="badge bg-warning position-absolute top-0 end-0 m-2">1</span>
                                                        <strong class="d-block mb-2">Ringan</strong>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-3">
                                                <div
                                                    class="form-check p-3 border rounded-3 h-100 position-relative hover-shadow">
                                                    <input class="form-check-input" type="radio"
                                                        name="berkurang_cadangan_lemak" id="cadangan_lemak_2"
                                                        value="2">
                                                    <label class="form-check-label w-100" for="cadangan_lemak_2">
                                                        <span class="badge bg-orange position-absolute top-0 end-0 m-2"
                                                            style="background-color: #fd7e14;">2</span>
                                                        <strong class="d-block mb-2">Sedang</strong>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-3">
                                                <div
                                                    class="form-check p-3 border rounded-3 h-100 position-relative hover-shadow">
                                                    <input class="form-check-input" type="radio"
                                                        name="berkurang_cadangan_lemak" id="cadangan_lemak_3"
                                                        value="3">
                                                    <label class="form-check-label w-100" for="cadangan_lemak_3">
                                                        <span
                                                            class="badge bg-danger position-absolute top-0 end-0 m-2">3</span>
                                                        <strong class="d-block mb-2">Berat</strong>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- 7. Tanda kehilangan masa oto -->
                                <div class="card border-0 shadow-sm mb-2">
                                    <div class="card-body py-2">
                                        <h6 class="fw-bold text-primary mb-3" style="font-size: 1.1rem;">
                                            7. Tanda kehilangan masa oto
                                            <small class="text-muted d-block"
                                                style="font-size: 0.9rem; font-weight: normal;">
                                                (kening, clavicula, skapula, costae, kuadricep, lutut, interoseous)
                                            </small>
                                        </h6>
                                        <div class="row g-3">
                                            <div class="col-lg-6 col-xl-3">
                                                <div
                                                    class="form-check p-3 border rounded-3 h-100 position-relative hover-shadow">
                                                    <input class="form-check-input" type="radio"
                                                        name="kehilangan_masa_oto" id="masa_oto_0" value="0">
                                                    <label class="form-check-label w-100" for="masa_oto_0">
                                                        <span
                                                            class="badge bg-success position-absolute top-0 end-0 m-2">0</span>
                                                        <strong class="d-block mb-2">Tidak ada perubahan</strong>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-3">
                                                <div
                                                    class="form-check p-3 border rounded-3 h-100 position-relative hover-shadow">
                                                    <input class="form-check-input" type="radio"
                                                        name="kehilangan_masa_oto" id="masa_oto_1" value="1">
                                                    <label class="form-check-label w-100" for="masa_oto_1">
                                                        <span
                                                            class="badge bg-warning position-absolute top-0 end-0 m-2">1</span>
                                                        <strong class="d-block mb-2">Ringan</strong>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-3">
                                                <div
                                                    class="form-check p-3 border rounded-3 h-100 position-relative hover-shadow">
                                                    <input class="form-check-input" type="radio"
                                                        name="kehilangan_masa_oto" id="masa_oto_2" value="2">
                                                    <label class="form-check-label w-100" for="masa_oto_2">
                                                        <span class="badge bg-orange position-absolute top-0 end-0 m-2"
                                                            style="background-color: #fd7e14;">2</span>
                                                        <strong class="d-block mb-2">Sedang</strong>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-3">
                                                <div
                                                    class="form-check p-3 border rounded-3 h-100 position-relative hover-shadow">
                                                    <input class="form-check-input" type="radio"
                                                        name="kehilangan_masa_oto" id="masa_oto_3" value="3">
                                                    <label class="form-check-label w-100" for="masa_oto_3">
                                                        <span
                                                            class="badge bg-danger position-absolute top-0 end-0 m-2">3</span>
                                                        <strong class="d-block mb-2">Berat</strong>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Section C: Body Measurements -->
                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0">
                                    <i class="bi bi-calculator me-2"></i>
                                    C. UKURAN TUBUH
                                </h6>
                            </div>
                            <div class="card-body">

                                <!-- BMI Calculation Display -->
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">IMT (Index Massa Tubuh)</label>
                                        <div class="input-group">
                                            <input type="number" step="0.01" class="form-control bg-light"
                                                id="imt_result" name="imt_result" readonly>
                                            <span class="input-group-text">kg/m²</span>
                                        </div>
                                        <small class="text-muted">Otomatis dihitung dari BB dan TB</small>
                                    </div>
                                </div>

                                <!-- 8. Indeks masa tubuh -->
                                <div class="card border-0 shadow-sm mb-2">
                                    <div class="card-body py-2">
                                        <h6 class="fw-bold text-primary mb-3" style="font-size: 1.1rem;">
                                            8. Indeks masa tubuh (Kg/m²)
                                        </h6>
                                        <div class="row g-3">
                                            <div class="col-lg-6 col-xl-3">
                                                <div
                                                    class="form-check p-3 border rounded-3 h-100 position-relative hover-shadow">
                                                    <input class="form-check-input" type="radio"
                                                        name="indeks_masa_tubuh" id="imt_0" value="0">
                                                    <label class="form-check-label w-100" for="imt_0">
                                                        <span
                                                            class="badge bg-success position-absolute top-0 end-0 m-2">0</span>
                                                        <strong class="d-block mb-2">≥ 20</strong>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-3">
                                                <div
                                                    class="form-check p-3 border rounded-3 h-100 position-relative hover-shadow">
                                                    <input class="form-check-input" type="radio"
                                                        name="indeks_masa_tubuh" id="imt_1" value="1">
                                                    <label class="form-check-label w-100" for="imt_1">
                                                        <span
                                                            class="badge bg-warning position-absolute top-0 end-0 m-2">1</span>
                                                        <strong class="d-block mb-2">18 - 19,9</strong>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-3">
                                                <div
                                                    class="form-check p-3 border rounded-3 h-100 position-relative hover-shadow">
                                                    <input class="form-check-input" type="radio"
                                                        name="indeks_masa_tubuh" id="imt_2" value="2">
                                                    <label class="form-check-label w-100" for="imt_2">
                                                        <span class="badge bg-orange position-absolute top-0 end-0 m-2"
                                                            style="background-color: #fd7e14;">2</span>
                                                        <strong class="d-block mb-2">16 - 17,99</strong>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-3">
                                                <div
                                                    class="form-check p-3 border rounded-3 h-100 position-relative hover-shadow">
                                                    <input class="form-check-input" type="radio"
                                                        name="indeks_masa_tubuh" id="imt_3" value="3">
                                                    <label class="form-check-label w-100" for="imt_3">
                                                        <span
                                                            class="badge bg-danger position-absolute top-0 end-0 m-2">3</span>
                                                        <strong class="d-block mb-2">
                                                            < 16</strong>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Section D: Laboratory Parameters -->
                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0">
                                    <i class="bi bi-clipboard-pulse me-2"></i>
                                    D. PARAMETER LABORATORIUM
                                </h6>
                            </div>
                            <div class="card-body">

                                <!-- 9. Albumin serum -->
                                <div class="card border-0 shadow-sm mb-2">
                                    <div class="card-body py-2">
                                        <h6 class="fw-bold text-primary mb-3" style="font-size: 1.1rem;">
                                            9. Albumin serum (g/dl)
                                        </h6>
                                        <div class="row g-3">
                                            <div class="col-lg-6 col-xl-3">
                                                <div
                                                    class="form-check p-3 border rounded-3 h-100 position-relative hover-shadow">
                                                    <input class="form-check-input" type="radio" name="albumin_serum"
                                                        id="albumin_0" value="0">
                                                    <label class="form-check-label w-100" for="albumin_0">
                                                        <span
                                                            class="badge bg-success position-absolute top-0 end-0 m-2">0</span>
                                                        <strong class="d-block mb-2">≥ 4</strong>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-3">
                                                <div
                                                    class="form-check p-3 border rounded-3 h-100 position-relative hover-shadow">
                                                    <input class="form-check-input" type="radio" name="albumin_serum"
                                                        id="albumin_1" value="1">
                                                    <label class="form-check-label w-100" for="albumin_1">
                                                        <span
                                                            class="badge bg-warning position-absolute top-0 end-0 m-2">1</span>
                                                        <strong class="d-block mb-2">3,5 - 3,9</strong>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-3">
                                                <div
                                                    class="form-check p-3 border rounded-3 h-100 position-relative hover-shadow">
                                                    <input class="form-check-input" type="radio" name="albumin_serum"
                                                        id="albumin_2" value="2">
                                                    <label class="form-check-label w-100" for="albumin_2">
                                                        <span class="badge bg-orange position-absolute top-0 end-0 m-2"
                                                            style="background-color: #fd7e14;">2</span>
                                                        <strong class="d-block mb-2">3,0 - 3,4</strong>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-3">
                                                <div
                                                    class="form-check p-3 border rounded-3 h-100 position-relative hover-shadow">
                                                    <input class="form-check-input" type="radio" name="albumin_serum"
                                                        id="albumin_3" value="3">
                                                    <label class="form-check-label w-100" for="albumin_3">
                                                        <span
                                                            class="badge bg-danger position-absolute top-0 end-0 m-2">3</span>
                                                        <strong class="d-block mb-2">
                                                            < 3,0</strong>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- 10. TIBC -->
                                <div class="card border-0 shadow-sm mb-2">
                                    <div class="card-body py-2">
                                        <h6 class="fw-bold text-primary mb-3" style="font-size: 1.1rem;">
                                            10. TIBC (Total Iron Binding Capacity Serum) mg/dl**
                                        </h6>
                                        <div class="row g-3">
                                            <div class="col-lg-6 col-xl-3">
                                                <div
                                                    class="form-check p-3 border rounded-3 h-100 position-relative hover-shadow">
                                                    <input class="form-check-input" type="radio" name="tibc"
                                                        id="tibc_0" value="0">
                                                    <label class="form-check-label w-100" for="tibc_0">
                                                        <span
                                                            class="badge bg-success position-absolute top-0 end-0 m-2">0</span>
                                                        <strong class="d-block mb-2">≥ 250</strong>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-3">
                                                <div
                                                    class="form-check p-3 border rounded-3 h-100 position-relative hover-shadow">
                                                    <input class="form-check-input" type="radio" name="tibc"
                                                        id="tibc_1" value="1">
                                                    <label class="form-check-label w-100" for="tibc_1">
                                                        <span
                                                            class="badge bg-warning position-absolute top-0 end-0 m-2">1</span>
                                                        <strong class="d-block mb-2">200 - 249</strong>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-3">
                                                <div
                                                    class="form-check p-3 border rounded-3 h-100 position-relative hover-shadow">
                                                    <input class="form-check-input" type="radio" name="tibc"
                                                        id="tibc_2" value="2">
                                                    <label class="form-check-label w-100" for="tibc_2">
                                                        <span class="badge bg-orange position-absolute top-0 end-0 m-2"
                                                            style="background-color: #fd7e14;">2</span>
                                                        <strong class="d-block mb-2">150 - 199</strong>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-3">
                                                <div
                                                    class="form-check p-3 border rounded-3 h-100 position-relative hover-shadow">
                                                    <input class="form-check-input" type="radio" name="tibc"
                                                        id="tibc_3" value="3">
                                                    <label class="form-check-label w-100" for="tibc_3">
                                                        <span
                                                            class="badge bg-danger position-absolute top-0 end-0 m-2">3</span>
                                                        <strong class="d-block mb-2">
                                                            < 150</strong>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Total Score Section -->
                        <div class="card mb-4">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0">
                                    <i class="bi bi-calculator me-2"></i>
                                    TOTAL SKOR & INTERPRETASI
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="text-center p-3 border rounded bg-light">
                                            <h4 class="mb-1">Total Skor</h4>
                                            <h2 class="text-primary mb-0" id="total_score">0</h2>
                                            <small class="text-muted">dari 30 maksimal</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-center p-3 border rounded" id="interpretation_box">
                                            <h5 class="mb-1">Interpretasi</h5>
                                            <h4 id="interpretation_text" class="mb-1">-</h4>
                                            <small id="interpretation_desc" class="text-muted">Silakan lengkapi
                                                penilaian</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notes Section -->
                        <div class="alert alert-info border-0 shadow-sm">
                            <div class="d-flex">
                                <i class="bi bi-info-circle-fill me-3 mt-1"></i>
                                <div>
                                    <strong>Keterangan:</strong><br>
                                    *MMC (Mayor Comorbid Condition) termasuk CHF kelas III atau IV, penyakit AIDS total
                                    (full
                                    blown), CAD berat, COPD sedang sampai berat, sekuel neurogikal mayor dan cancer malignan
                                    metastasis atau post kemoterapi.<br><br>
                                    ** Peningkatan serum transferrin yang diharapkan adalah : > 200(0), 170-199 (1), 140-162
                                    (2), dan < 140 mg/dl (3).<br><br>
                                        <strong>Kesimpulan :</strong> tanpa malnutrisi total nilai < 6 apabila malnutrisi
                                            nilai>
                                            6, jika nilai = 6 lihat klinis pasien dan kesimpulan diambil seobiektif mungkin.
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <x-button-submit />
                        </div>
                    </form>
            </x-content-card>
        </div>
    </div>
    </div>
@endsection



@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // BMI Calculation
            function calculateBMI() {
                const weight = parseFloat(document.querySelector('input[name="berat_badan"]').value);
                const height = parseFloat(document.querySelector('input[name="tinggi_badan"]').value);

                if (weight && height) {
                    const heightInMeters = height / 100;
                    const bmi = weight / (heightInMeters * heightInMeters);
                    document.getElementById('imt_result').value = bmi.toFixed(2);

                    // Auto select BMI category
                    if (bmi >= 20) {
                        document.getElementById('imt_0').checked = true;
                    } else if (bmi >= 18) {
                        document.getElementById('imt_1').checked = true;
                    } else if (bmi >= 16) {
                        document.getElementById('imt_2').checked = true;
                    } else {
                        document.getElementById('imt_3').checked = true;
                    }
                    calculateTotal();
                }
            }

            // Total Score Calculation
            function calculateTotal() {
                let total = 0;
                const radioGroups = [
                    'perubahan_bb_kering',
                    'asupan_diet',
                    'gejala_gastrointestinal',
                    'kapasitas_fungsional',
                    'komorbiditas',
                    'berkurang_cadangan_lemak',
                    'kehilangan_masa_oto',
                    'indeks_masa_tubuh',
                    'albumin_serum',
                    'tibc'
                ];

                radioGroups.forEach(group => {
                    const selected = document.querySelector(`input[name="${group}"]:checked`);
                    if (selected) {
                        total += parseInt(selected.value);
                    }
                });

                document.getElementById('total_score').textContent = total;

                // Update interpretation
                const interpretationBox = document.getElementById('interpretation_box');
                const interpretationText = document.getElementById('interpretation_text');
                const interpretationDesc = document.getElementById('interpretation_desc');

                if (total < 6) {
                    interpretationBox.className = 'text-center p-3 border rounded bg-success text-white';
                    interpretationText.textContent = 'NORMAL';
                    interpretationDesc.textContent = 'Tanpa malnutrisi';
                } else if (total === 6) {
                    interpretationBox.className = 'text-center p-3 border rounded bg-warning text-dark';
                    interpretationText.textContent = 'BORDERLINE';
                    interpretationDesc.textContent = 'Lihat klinis pasien';
                } else {
                    interpretationBox.className = 'text-center p-3 border rounded bg-danger text-white';
                    interpretationText.textContent = 'MALNUTRISI';
                    interpretationDesc.textContent = 'Malnutrisi terdeteksi';
                }
            }

            // Event listeners
            document.querySelector('input[name="berat_badan"]').addEventListener('input', calculateBMI);
            document.querySelector('input[name="tinggi_badan"]').addEventListener('input', calculateBMI);

            // Add event listeners to all radio buttons
            document.querySelectorAll('input[type="radio"]').forEach(radio => {
                radio.addEventListener('change', calculateTotal);
            });
        });
    </script>
@endpush
