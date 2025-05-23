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

            .section-title {
                color: #2c3e50;
                font-weight: 700;
                margin-bottom: 1rem;
                border-bottom: 2px solid #e9ecef;
                padding-bottom: 0.5rem;
            }

            .criteria-table {
                border-collapse: collapse;
                width: 100%;
                border: 1px solid #dee2e6;
            }

            .criteria-table th,
            .criteria-table td {
                border: 1px solid #dee2e6;
                padding: 12px;
                vertical-align: top;
            }

            .criteria-table th {
                background-color: #f8f9fa;
                font-weight: 700;
                text-align: center;
            }

            .criteria-no {
                text-align: center;
                width: 50px;
                font-weight: 700;
            }

            .criteria-desc {
                width: 45%;
            }

            .check-col {
                text-align: center;
                width: 80px;
            }

            .keterangan-col {
                width: 40%;
            }

            .main-criteria {
                font-weight: bold;
                margin-bottom: 8px;
            }

            .sub-criteria-row {
                border-left: 3px solid #e9ecef;
                background-color: #fafafa;
            }

            .sub-criteria-text {
                margin-left: 20px;
                font-size: 0.95rem;
            }

            .form-control-textarea {
                min-height: 60px;
                resize: vertical;
                width: 100%;
            }

            .vital-signs-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 1rem;
            }
        </style>
    @endpush

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <div class="text-center mt-1 mb-2">
                <h5 class="text-secondary fw-bold">Kriteria Masuk Ruang PICU</h5>
            </div>

            <hr>

            <div class="form-section">
                <form
                    action="{{ route('rawat-inap.kriteria-masuk-keluar.picu.store', [
                        'kd_unit' => $kd_unit,
                        'kd_pasien' => $kd_pasien,
                        'tgl_masuk' => $tgl_masuk,
                        'urut_masuk' => $urut_masuk,
                    ]) }}"
                    method="post" id="picuCriteriaForm">
                    @csrf

                    <!-- Section Tanggal & Waktu -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="section-title mb-0">Tanggal & Waktu</h6>
                        </div>
                        <div class="card-body">
                            <div class="row align-items-center">
                                <small class="text-warning mb-2">
                                    <i class="bi bi-exclamation-triangle-fill"></i>
                                    Pastikan jam diisi dengan benar untuk keakuratan dokumentasi medis
                                </small>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Tanggal</label>
                                        <input type="date" class="form-control" name="tanggal" id="tanggal"
                                            value="{{ old('tanggal', date('Y-m-d')) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Jam</label>
                                        <input type="time" class="form-control" name="jam" id="jam"
                                            value="{{ old('jam', date('H:i')) }}" required>
                                        <div class="invalid-feedback" id="timeError">
                                            Pastikan format jam benar (HH:MM)
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Dokter</label>
                                        <select name="kd_dokter" id="kd_dokter" class="form-select select2"
                                            style="width: 100%" required>
                                            <option value="">--Pilih--</option>
                                            @foreach ($dokter as $dok)
                                                <option value="{{ $dok->kd_dokter }}">{{ $dok->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section Kriteria Masuk PICU -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="section-title mb-0">Kriteria Masuk PICU</h6>
                        </div>
                        <div class="card-body p-0">
                            <table class="criteria-table">
                                <thead>
                                    <tr>
                                        <th class="criteria-no">No</th>
                                        <th class="criteria-desc">Kriteria Masuk</th>
                                        <th class="check-col">Check List</th>
                                        <th class="keterangan-col">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- 1. Pasien Anak Usia 1 bulan s/d 18 tahun -->
                                    <tr>
                                        <td class="criteria-no">1.</td>
                                        <td class="criteria-desc">
                                            <div class="main-criteria">Gawat Nafas/ gagal nafas.</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="1_main" id="check_1_main">
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[1_main]" placeholder="Keterangan..."></textarea>
                                        </td>
                                    </tr>

                                    <!-- Sub-kriteria untuk Gawat Nafas -->
                                    <tr class="sub-criteria-row">
                                        <td class="criteria-no"></td>
                                        <td class="criteria-desc">
                                            <div class="sub-criteria-text">• RR: ≥ 60 x/i</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="1_rr" id="check_1_rr">
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[1_rr]" placeholder="Keterangan..."></textarea>
                                        </td>
                                    </tr>

                                    <tr class="sub-criteria-row">
                                        <td class="criteria-no"></td>
                                        <td class="criteria-desc">
                                            <div class="sub-criteria-text">• Sianosis</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="1_sianosis"
                                                id="check_1_sianosis">
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[1_sianosis]" placeholder="Keterangan..."></textarea>
                                        </td>
                                    </tr>

                                    <tr class="sub-criteria-row">
                                        <td class="criteria-no"></td>
                                        <td class="criteria-desc">
                                            <div class="sub-criteria-text">• Retraksi IGA</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="1_retraksi"
                                                id="check_1_retraksi">
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[1_retraksi]" placeholder="Keterangan..."></textarea>
                                        </td>
                                    </tr>

                                    <tr class="sub-criteria-row">
                                        <td class="criteria-no"></td>
                                        <td class="criteria-desc">
                                            <div class="sub-criteria-text">• Merintih</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="1_merintih"
                                                id="check_1_merintih">
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[1_merintih]" placeholder="Keterangan..."></textarea>
                                        </td>
                                    </tr>

                                    <tr class="sub-criteria-row">
                                        <td class="criteria-no"></td>
                                        <td class="criteria-desc">
                                            <div class="sub-criteria-text">• Nafas cuping hidung.</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="1_nafas_cuping"
                                                id="check_1_nafas_cuping">
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[1_nafas_cuping]" placeholder="Keterangan..."></textarea>
                                        </td>
                                    </tr>

                                    <!-- 2. Syok / kegagalan sirkulasi -->
                                    <tr>
                                        <td class="criteria-no">2.</td>
                                        <td class="criteria-desc">
                                            <div class="main-criteria">Syok / kegagalan sirkulasi</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="2_main" id="check_2_main">
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[2_main]" placeholder="Keterangan..."></textarea>
                                        </td>
                                    </tr>

                                    <tr class="sub-criteria-row">
                                        <td class="criteria-no"></td>
                                        <td class="criteria-desc">
                                            <div class="sub-criteria-text">• Tekanan Darah tidak terukur</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="2_tekanan_darah"
                                                id="check_2_tekanan_darah">
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[2_tekanan_darah]" placeholder="Keterangan..."></textarea>
                                        </td>
                                    </tr>

                                    <tr class="sub-criteria-row">
                                        <td class="criteria-no"></td>
                                        <td class="criteria-desc">
                                            <div class="sub-criteria-text">• Nadi Cepat dan lemah</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="2_nadi" id="check_2_nadi">
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[2_nadi]" placeholder="Keterangan..."></textarea>
                                        </td>
                                    </tr>

                                    <tr class="sub-criteria-row">
                                        <td class="criteria-no"></td>
                                        <td class="criteria-desc">
                                            <div class="sub-criteria-text">• HR takikardia (>140)</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="2_hr" id="check_2_hr">
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[2_hr]" placeholder="Keterangan..."></textarea>
                                        </td>
                                    </tr>

                                    <tr class="sub-criteria-row">
                                        <td class="criteria-no"></td>
                                        <td class="criteria-desc">
                                            <div class="sub-criteria-text">• Tekanan Nadi : ≥ 20mmHg</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="2_tekanan_nadi"
                                                id="check_2_tekanan_nadi">
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[2_tekanan_nadi]" placeholder="Keterangan..."></textarea>
                                        </td>
                                    </tr>

                                    <tr class="sub-criteria-row">
                                        <td class="criteria-no"></td>
                                        <td class="criteria-desc">
                                            <div class="sub-criteria-text">• RR: Takipnue ≥ 60x/m</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="2_rr" id="check_2_rr">
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[2_rr]" placeholder="Keterangan..."></textarea>
                                        </td>
                                    </tr>

                                    <tr class="sub-criteria-row">
                                        <td class="criteria-no"></td>
                                        <td class="criteria-desc">
                                            <div class="sub-criteria-text">• Akral dingin</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="2_akral"
                                                id="check_2_akral">
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[2_akral]" placeholder="Keterangan..."></textarea>
                                        </td>
                                    </tr>

                                    <!-- 3. Kejang berulang disertai penurunan kesadaran -->
                                    <tr>
                                        <td class="criteria-no">3.</td>
                                        <td class="criteria-desc">
                                            <strong>Kejang berulang disertai penurunan kesadaran</strong>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="3" id="check_3">
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[3]" placeholder="Keterangan..."></textarea>
                                        </td>
                                    </tr>

                                    <!-- 4. Sepsis (kesadaran menurun, nadi<60) -->
                                    <tr>
                                        <td class="criteria-no">4.</td>
                                        <td class="criteria-desc">
                                            <strong>Sepsis (kesadaran menurun, nadi&lt;60)</strong>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="4" id="check_4">
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[4]" placeholder="Keterangan..."></textarea>
                                        </td>
                                    </tr>

                                    <!-- 5. Tetanus Anak -->
                                    <tr>
                                        <td class="criteria-no">5.</td>
                                        <td class="criteria-desc">
                                            <strong>Tetanus Anak</strong>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="5" id="check_5">
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[5]" placeholder="Keterangan..."></textarea>
                                        </td>
                                    </tr>

                                    <<!-- 6. Dehidrasi Berat -->
                                        <tr>
                                            <td class="criteria-no">6.</td>
                                            <td class="criteria-desc">
                                                <div class="main-criteria">Dehidrasi Berat</div>
                                            </td>
                                            <td class="check-col">
                                                <input type="checkbox" name="check_list[]" value="6_main"
                                                    id="check_6_main">
                                            </td>
                                            <td class="keterangan-col">
                                                <textarea class="form-control form-control-textarea" name="keterangan[6_main]" placeholder="Keterangan..."></textarea>
                                            </td>
                                        </tr>

                                        <tr class="sub-criteria-row">
                                            <td class="criteria-no"></td>
                                            <td class="criteria-desc">
                                                <div class="sub-criteria-text">• Penurunan kesadaran</div>
                                            </td>
                                            <td class="check-col">
                                                <input type="checkbox" name="check_list[]" value="6_penurunan_kesadaran"
                                                    id="check_6_penurunan_kesadaran">
                                            </td>
                                            <td class="keterangan-col">
                                                <textarea class="form-control form-control-textarea" name="keterangan[6_penurunan_kesadaran]"
                                                    placeholder="Keterangan..."></textarea>
                                            </td>
                                        </tr>

                                        <tr class="sub-criteria-row">
                                            <td class="criteria-no"></td>
                                            <td class="criteria-desc">
                                                <div class="sub-criteria-text">• Takikardia</div>
                                            </td>
                                            <td class="check-col">
                                                <input type="checkbox" name="check_list[]" value="6_takikardia"
                                                    id="check_6_takikardia">
                                            </td>
                                            <td class="keterangan-col">
                                                <textarea class="form-control form-control-textarea" name="keterangan[6_takikardia]" placeholder="Keterangan..."></textarea>
                                            </td>
                                        </tr>

                                        <tr class="sub-criteria-row">
                                            <td class="criteria-no"></td>
                                            <td class="criteria-desc">
                                                <div class="sub-criteria-text">• Mata cekung</div>
                                            </td>
                                            <td class="check-col">
                                                <input type="checkbox" name="check_list[]" value="6_mata"
                                                    id="check_6_mata">
                                            </td>
                                            <td class="keterangan-col">
                                                <textarea class="form-control form-control-textarea" name="keterangan[6_mata]" placeholder="Keterangan..."></textarea>
                                            </td>
                                        </tr>

                                        <tr class="sub-criteria-row">
                                            <td class="criteria-no"></td>
                                            <td class="criteria-desc">
                                                <div class="sub-criteria-text">• Letargi</div>
                                            </td>
                                            <td class="check-col">
                                                <input type="checkbox" name="check_list[]" value="6_letargi"
                                                    id="check_6_letargi">
                                            </td>
                                            <td class="keterangan-col">
                                                <textarea class="form-control form-control-textarea" name="keterangan[6_letargi]" placeholder="Keterangan..."></textarea>
                                            </td>
                                        </tr>

                                        <tr class="sub-criteria-row">
                                            <td class="criteria-no"></td>
                                            <td class="criteria-desc">
                                                <div class="sub-criteria-text">• Anuria</div>
                                            </td>
                                            <td class="check-col">
                                                <input type="checkbox" name="check_list[]" value="6_anuria"
                                                    id="check_6_anuria">
                                            </td>
                                            <td class="keterangan-col">
                                                <textarea class="form-control form-control-textarea" name="keterangan[6_anuria]" placeholder="Keterangan..."></textarea>
                                            </td>
                                        </tr>

                                        <tr class="sub-criteria-row">
                                            <td class="criteria-no"></td>
                                            <td class="criteria-desc">
                                                <div class="sub-criteria-text">• Malas minum</div>
                                            </td>
                                            <td class="check-col">
                                                <input type="checkbox" name="check_list[]" value="6_malas_minum"
                                                    id="check_6_malas_minum">
                                            </td>
                                            <td class="keterangan-col">
                                                <textarea class="form-control form-control-textarea" name="keterangan[6_malas_minum]" placeholder="Keterangan..."></textarea>
                                            </td>
                                        </tr>

                                        <!-- 7. Hipertensi krisis pada anak -->
                                        <tr>
                                            <td class="criteria-no">7.</td>
                                            <td class="criteria-desc">
                                                <strong>Hipertensi krisis pada anak (&gt;180/120mmHg)</strong>
                                            </td>
                                            <td class="check-col">
                                                <input type="checkbox" name="check_list[]" value="7"
                                                    id="check_7">
                                            </td>
                                            <td class="keterangan-col">
                                                <textarea class="form-control form-control-textarea" name="keterangan[7]" placeholder="Keterangan..."></textarea>
                                            </td>
                                        </tr>

                                        <!-- 8. Kegagalan organ -->
                                        <tr>
                                            <td class="criteria-no">8.</td>
                                            <td class="criteria-desc">
                                                <strong>Kegagalan organ</strong>
                                            </td>
                                            <td class="check-col">
                                                <input type="checkbox" name="check_list[]" value="8"
                                                    id="check_8">
                                            </td>
                                            <td class="keterangan-col">
                                                <textarea class="form-control form-control-textarea" name="keterangan[8]" placeholder="Keterangan..."></textarea>
                                            </td>
                                        </tr>

                                        <!-- 9. Pasien anak pasca bedah -->
                                        <tr>
                                            <td class="criteria-no">9.</td>
                                            <td class="criteria-desc">
                                                <div class="main-criteria">Pasien anak pasca bedah</div>
                                            </td>
                                            <td class="check-col">
                                                <input type="checkbox" name="check_list[]" value="9_main"
                                                    id="check_9_main">
                                            </td>
                                            <td class="keterangan-col">
                                                <textarea class="form-control form-control-textarea" name="keterangan[9_main]" placeholder="Keterangan..."></textarea>
                                            </td>
                                        </tr>

                                        <tr class="sub-criteria-row">
                                            <td class="criteria-no"></td>
                                            <td class="criteria-desc">
                                                <div class="sub-criteria-text">• Traumatologi pada anak</div>
                                            </td>
                                            <td class="check-col">
                                                <input type="checkbox" name="check_list[]" value="9_traumatologi"
                                                    id="check_9_traumatologi">
                                            </td>
                                            <td class="keterangan-col">
                                                <textarea class="form-control form-control-textarea" name="keterangan[9_traumatologi]" placeholder="Keterangan..."></textarea>
                                            </td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <!-- Section Kriteria Keluar PICU -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="section-title mb-0">Kriteria Keluar PICU</h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="alert alert-info mb-3 mx-3 mt-3">
                                <i class="bi bi-info-circle me-2"></i>
                                Bila indikasi untuk semua tindakan di ruang intensive tidak diperlukan lagi (pemantauan
                                intensive, intervensi intensive)
                            </div>
                            <table class="criteria-table">
                                <thead>
                                    <tr>
                                        <th class="criteria-no">No</th>
                                        <th class="criteria-desc">Kriteria Keluar</th>
                                        <th class="check-col">Check List</th>
                                        <th class="keterangan-col">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- 1. Parameter hemodinamik stabil -->
                                    <tr>
                                        <td class="criteria-no">1.</td>
                                        <td class="criteria-desc">
                                            <strong>Parameter hemodinamik stabil</strong>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list_keluar[]" value="1"
                                                id="check_keluar_1">
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan_keluar[1]" placeholder="Keterangan..."></textarea>
                                        </td>
                                    </tr>

                                    <!-- 2. Status respirasi stabil -->
                                    <tr>
                                        <td class="criteria-no">2.</td>
                                        <td class="criteria-desc">
                                            <strong>Status respirasi stabil (tanpa ETT, jalan nafas bebas, gas darah
                                                normal)</strong>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list_keluar[]" value="2"
                                                id="check_keluar_2">
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan_keluar[2]" placeholder="Keterangan..."></textarea>
                                        </td>
                                    </tr>

                                    <!-- 3. Kebutuhan suplementasi oksigen minimal -->
                                    <tr>
                                        <td class="criteria-no">3.</td>
                                        <td class="criteria-desc">
                                            <strong>Kebutuhan suplementasi oksigen minimal (tidak melebihi standar yang
                                                dapat dilakukan di luar ruang intensive pediatrik)</strong>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list_keluar[]" value="3"
                                                id="check_keluar_3">
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan_keluar[3]" placeholder="Keterangan..."></textarea>
                                        </td>
                                    </tr>

                                    <!-- 4. Disritmia jantung terkontrol -->
                                    <tr>
                                        <td class="criteria-no">4.</td>
                                        <td class="criteria-desc">
                                            <strong>Disritmia jantung terkontrol</strong>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list_keluar[]" value="4"
                                                id="check_keluar_4">
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan_keluar[4]" placeholder="Keterangan..."></textarea>
                                        </td>
                                    </tr>

                                    <!-- 5. Alat pemantauan tekanan intrakranial intensive tidak terpasang lagi -->
                                    <tr>
                                        <td class="criteria-no">5.</td>
                                        <td class="criteria-desc">
                                            <strong>Alat pemantauan tekanan intrakranial intensive tidak terpasang
                                                lagi</strong>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list_keluar[]" value="5"
                                                id="check_keluar_5">
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan_keluar[5]" placeholder="Keterangan..."></textarea>
                                        </td>
                                    </tr>

                                    <!-- 6. Neurologi stabil kejang terkontrol -->
                                    <tr>
                                        <td class="criteria-no">6.</td>
                                        <td class="criteria-desc">
                                            <strong>Neurologi stabil kejang terkontrol</strong>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list_keluar[]" value="6"
                                                id="check_keluar_6">
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan_keluar[6]" placeholder="Keterangan..."></textarea>
                                        </td>
                                    </tr>

                                    <!-- 7. Kateter pemantau hemodinamik telah dilepas -->
                                    <tr>
                                        <td class="criteria-no">7.</td>
                                        <td class="criteria-desc">
                                            <strong>Kateter pemantau hemodinamik telah dilepas</strong>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list_keluar[]" value="7"
                                                id="check_keluar_7">
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan_keluar[7]" placeholder="Keterangan..."></textarea>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="row">
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Simpan
                            </button>
                            <a href="{{ url("unit-pelayanan/rawat-inap/unit/$kd_unit/pelayanan/$kd_pasien/$tgl_masuk/$urut_masuk") }}"
                                class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Batal
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        // Function to handle checkbox interactions
        document.addEventListener('DOMContentLoaded', function() {
            // Handle kriteria masuk checkboxes
            const checkboxesMasuk = document.querySelectorAll('input[name="check_list[]"]');

            checkboxesMasuk.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    const row = this.closest('tr');
                    const keteranganTextarea = row.querySelector('textarea[name^="keterangan["]');

                    if (this.checked) {
                        keteranganTextarea.setAttribute('required', 'required');
                        keteranganTextarea.style.borderColor = '#dc3545';
                        keteranganTextarea.parentElement.classList.add('required-field');
                    } else {
                        keteranganTextarea.removeAttribute('required');
                        keteranganTextarea.style.borderColor = '#ced4da';
                        keteranganTextarea.parentElement.classList.remove('required-field');
                    }
                });
            });

            // Handle kriteria keluar checkboxes
            const checkboxesKeluar = document.querySelectorAll('input[name="check_list_keluar[]"]');

            checkboxesKeluar.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    const row = this.closest('tr');
                    const keteranganTextarea = row.querySelector(
                        'textarea[name^="keterangan_keluar["]');

                    if (this.checked) {
                        keteranganTextarea.setAttribute('required', 'required');
                        keteranganTextarea.style.borderColor = '#dc3545';
                        keteranganTextarea.parentElement.classList.add('required-field');
                    } else {
                        keteranganTextarea.removeAttribute('required');
                        keteranganTextarea.style.borderColor = '#ced4da';
                        keteranganTextarea.parentElement.classList.remove('required-field');
                    }
                });
            });

            // Form validation before submit
            document.getElementById('picuCriteriaForm').addEventListener('submit', function(e) {
                let hasError = false;

                // Check kriteria masuk
                checkboxesMasuk.forEach(function(checkbox) {
                    if (checkbox.checked) {
                        const row = checkbox.closest('tr');
                        const textarea = row.querySelector('textarea[name^="keterangan["]');

                        if (!textarea.value.trim()) {
                            hasError = true;
                            textarea.style.borderColor = '#dc3545';
                            textarea.focus();
                        }
                    }
                });

                // Check kriteria keluar
                checkboxesKeluar.forEach(function(checkbox) {
                    if (checkbox.checked) {
                        const row = checkbox.closest('tr');
                        const textarea = row.querySelector('textarea[name^="keterangan_keluar["]');

                        if (!textarea.value.trim()) {
                            hasError = true;
                            textarea.style.borderColor = '#dc3545';
                            textarea.focus();
                        }
                    }
                });

                if (hasError) {
                    e.preventDefault();
                    alert('Harap isi keterangan untuk semua kriteria yang dipilih.');
                }
            });
        });
    </script>
@endpush
