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
                <h5 class="text-secondary fw-bold">Edit Kriteria Masuk/Keluar Ruang PICU</h5>
            </div>

            <hr>

            <div class="form-section">
                <form
                    action="{{ route('rawat-inap.kriteria-masuk-keluar.picu.update', [
                        'kd_unit' => $kd_unit,
                        'kd_pasien' => $kd_pasien,
                        'tgl_masuk' => $tgl_masuk,
                        'urut_masuk' => $urut_masuk,
                    ]) }}"
                    method="post" id="picuCriteriaForm">
                    @csrf
                    @method('PUT')

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
                                            value="{{ old('tanggal', $dataPICU->tanggal ?? date('Y-m-d')) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Jam</label>
                                        <input type="time" class="form-control" name="jam" id="jam"
                                            value="{{ old('jam', $dataPICU->jam ? date('H:i', strtotime($dataPICU->jam)) : date('H:i')) }}"
                                            required>
                                        <div class="invalid-feedback" id="timeError">
                                            Pastikan format jam benar (HH:MM)
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Dokter</label>
                                        <select name="kd_dokter" id="kd_dokter" class="form-select select2" style="width: 100%" required>
                                            <option value="">--Pilih--</option>
                                            @foreach ($dokter as $dok)
                                                <option value="{{ $dok->kd_dokter }}" {{ old('kd_dokter', $dataPICU->kd_dokter ?? '') == $dok->kd_dokter ? 'selected' : '' }}>
                                                    {{ $dok->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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
                                    <tr>
                                        <td colspan="4" style="background-color: #eef; padding: 8px 12px; font-style: italic;">
                                            Pasien Anak Usia 1 bulan s/d 18 tahun dengan Kasus:
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="criteria-no">1.</td>
                                        <td class="criteria-desc">
                                            <div class="main-criteria">Gawat Nafas/ gagal nafas.</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="1_main" id="check_1_main"
                                                {{ $dataPICU && $dataPICU->kriteria_1_main ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[1_main]"
                                                placeholder="Keterangan...">{{ old('keterangan.1_main', $dataPICU->keterangan_1_main ?? '') }}</textarea>
                                        </td>
                                    </tr>
                                    <tr class="sub-criteria-row">
                                        <td class="criteria-no"></td>
                                        <td class="criteria-desc">
                                            <div class="sub-criteria-text">• RR: ≥ 60 x/i</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="1_rr" id="check_1_rr"
                                                {{ $dataPICU && $dataPICU->kriteria_1_rr ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[1_rr]"
                                                placeholder="Keterangan...">{{ old('keterangan.1_rr', $dataPICU->keterangan_1_rr ?? '') }}</textarea>
                                        </td>
                                    </tr>
                                    <tr class="sub-criteria-row">
                                        <td class="criteria-no"></td>
                                        <td class="criteria-desc">
                                            <div class="sub-criteria-text">• Sianosis</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="1_sianosis" id="check_1_sianosis"
                                                {{ $dataPICU && $dataPICU->kriteria_1_sianosis ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[1_sianosis]"
                                                placeholder="Keterangan...">{{ old('keterangan.1_sianosis', $dataPICU->keterangan_1_sianosis ?? '') }}</textarea>
                                        </td>
                                    </tr>
                                    <tr class="sub-criteria-row">
                                        <td class="criteria-no"></td>
                                        <td class="criteria-desc">
                                            <div class="sub-criteria-text">• Retraksi IGA</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="1_retraksi" id="check_1_retraksi"
                                                {{ $dataPICU && $dataPICU->kriteria_1_retraksi ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[1_retraksi]"
                                                placeholder="Keterangan...">{{ old('keterangan.1_retraksi', $dataPICU->keterangan_1_retraksi ?? '') }}</textarea>
                                        </td>
                                    </tr>
                                    <tr class="sub-criteria-row">
                                        <td class="criteria-no"></td>
                                        <td class="criteria-desc">
                                            <div class="sub-criteria-text">• Merintih</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="1_merintih" id="check_1_merintih"
                                                {{ $dataPICU && $dataPICU->kriteria_1_merintih ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[1_merintih]"
                                                placeholder="Keterangan...">{{ old('keterangan.1_merintih', $dataPICU->keterangan_1_merintih ?? '') }}</textarea>
                                        </td>
                                    </tr>
                                    <tr class="sub-criteria-row">
                                        <td class="criteria-no"></td>
                                        <td class="criteria-desc">
                                            <div class="sub-criteria-text">• Nafas cuping hidung.</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="1_nafas_cuping" id="check_1_nafas_cuping"
                                                {{ $dataPICU && $dataPICU->kriteria_1_nafas_cuping ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[1_nafas_cuping]"
                                                placeholder="Keterangan...">{{ old('keterangan.1_nafas_cuping', $dataPICU->keterangan_1_nafas_cuping ?? '') }}</textarea>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="criteria-no">2.</td>
                                        <td class="criteria-desc">
                                            <div class="main-criteria">Syok / kegagalan sirkulasi</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="2_main" id="check_2_main"
                                                {{ $dataPICU && $dataPICU->kriteria_2_main ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[2_main]"
                                                placeholder="Keterangan...">{{ old('keterangan.2_main', $dataPICU->keterangan_2_main ?? '') }}</textarea>
                                        </td>
                                    </tr>
                                    <tr class="sub-criteria-row">
                                        <td class="criteria-no"></td>
                                        <td class="criteria-desc">
                                            <div class="sub-criteria-text">• Tekanan Darah tidak terukur</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="2_tekanan_darah" id="check_2_tekanan_darah"
                                                 {{ $dataPICU && $dataPICU->kriteria_2_tekanan_darah ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[2_tekanan_darah]" placeholder="Keterangan...">{{ old('keterangan.2_tekanan_darah', $dataPICU->keterangan_2_tekanan_darah ?? '') }}</textarea>
                                        </td>
                                    </tr>
                                    <tr class="sub-criteria-row">
                                        <td class="criteria-no"></td>
                                        <td class="criteria-desc">
                                            <div class="sub-criteria-text">• Nadi Cepat dan lemah</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="2_nadi" id="check_2_nadi"
                                                {{ $dataPICU && $dataPICU->kriteria_2_nadi ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[2_nadi]"
                                                placeholder="Keterangan...">{{ old('keterangan.2_nadi', $dataPICU->keterangan_2_nadi ?? '') }}</textarea>
                                        </td>
                                    </tr>
                                    <tr class="sub-criteria-row">
                                        <td class="criteria-no"></td>
                                        <td class="criteria-desc">
                                            <div class="sub-criteria-text">• HR takikardia (>140)</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="2_hr" id="check_2_hr"
                                                {{ $dataPICU && $dataPICU->kriteria_2_hr ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[2_hr]"
                                                placeholder="Keterangan...">{{ old('keterangan.2_hr', $dataPICU->keterangan_2_hr ?? '') }}</textarea>
                                        </td>
                                    </tr>
                                    <tr class="sub-criteria-row">
                                        <td class="criteria-no"></td>
                                        <td class="criteria-desc">
                                            <div class="sub-criteria-text">• Tekanan Nadi : ≥ 20mmHg</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="2_tekanan_nadi" id="check_2_tekanan_nadi"
                                                {{ $dataPICU && $dataPICU->kriteria_2_tekanan_nadi ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[2_tekanan_nadi]"
                                                placeholder="Keterangan...">{{ old('keterangan.2_tekanan_nadi', $dataPICU->keterangan_2_tekanan_nadi ?? '') }}</textarea>
                                        </td>
                                    </tr>
                                    <tr class="sub-criteria-row">
                                        <td class="criteria-no"></td>
                                        <td class="criteria-desc">
                                            <div class="sub-criteria-text">• RR: Takipnue ≥ 60x/m</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="2_rr" id="check_2_rr"
                                                {{ $dataPICU && $dataPICU->kriteria_2_rr ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[2_rr]"
                                                placeholder="Keterangan...">{{ old('keterangan.2_rr', $dataPICU->keterangan_2_rr ?? '') }}</textarea>
                                        </td>
                                    </tr>
                                    <tr class="sub-criteria-row">
                                        <td class="criteria-no"></td>
                                        <td class="criteria-desc">
                                            <div class="sub-criteria-text">• Akral dingin</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="2_akral" id="check_2_akral"
                                                {{ $dataPICU && $dataPICU->kriteria_2_akral ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[2_akral]"
                                                placeholder="Keterangan...">{{ old('keterangan.2_akral', $dataPICU->keterangan_2_akral ?? '') }}</textarea>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="criteria-no">3.</td>
                                        <td class="criteria-desc">
                                            <strong>Kejang berulang disertai penurunan kesadaran</strong>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="3" id="check_3"
                                                {{ $dataPICU && $dataPICU->kriteria_3 ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[3]"
                                                placeholder="Keterangan...">{{ old('keterangan.3', $dataPICU->keterangan_3 ?? '') }}</textarea>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="criteria-no">4.</td>
                                        <td class="criteria-desc">
                                            <strong>Sepsis (kesadaran menurun, nadi&lt;60)</strong>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="4" id="check_4"
                                                {{ $dataPICU && $dataPICU->kriteria_4 ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[4]"
                                                placeholder="Keterangan...">{{ old('keterangan.4', $dataPICU->keterangan_4 ?? '') }}</textarea>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="criteria-no">5.</td>
                                        <td class="criteria-desc">
                                            <strong>Tetanus Anak</strong>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="5" id="check_5"
                                                {{ $dataPICU && $dataPICU->kriteria_5 ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[5]"
                                                placeholder="Keterangan...">{{ old('keterangan.5', $dataPICU->keterangan_5 ?? '') }}</textarea>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="criteria-no">6.</td>
                                        <td class="criteria-desc">
                                            <div class="main-criteria">Dehidrasi Berat</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="6_main" id="check_6_main"
                                                {{ $dataPICU && $dataPICU->kriteria_6_main ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[6_main]"
                                                placeholder="Keterangan...">{{ old('keterangan.6_main', $dataPICU->keterangan_6_main ?? '') }}</textarea>
                                        </td>
                                    </tr>
                                    <tr class="sub-criteria-row">
                                        <td class="criteria-no"></td>
                                        <td class="criteria-desc">
                                            <div class="sub-criteria-text">• Penurunan kesadaran</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="6_penurunan_kesadaran" id="check_6_penurunan_kesadaran"
                                                {{ $dataPICU && $dataPICU->kriteria_6_penurunan_kesadaran ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[6_penurunan_kesadaran]"
                                                placeholder="Keterangan...">{{ old('keterangan.6_penurunan_kesadaran', $dataPICU->keterangan_6_penurunan_kesadaran ?? '') }}</textarea>
                                        </td>
                                    </tr>
                                    <tr class="sub-criteria-row">
                                        <td class="criteria-no"></td>
                                        <td class="criteria-desc">
                                            <div class="sub-criteria-text">• Takikardia</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="6_takikardia" id="check_6_takikardia"
                                                {{ $dataPICU && $dataPICU->kriteria_6_takikardia ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[6_takikardia]"
                                                placeholder="Keterangan...">{{ old('keterangan.6_takikardia', $dataPICU->keterangan_6_takikardia ?? '') }}</textarea>
                                        </td>
                                    </tr>
                                    <tr class="sub-criteria-row">
                                        <td class="criteria-no"></td>
                                        <td class="criteria-desc">
                                            <div class="sub-criteria-text">• Mata cekung</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="6_mata" id="check_6_mata"
                                                {{ $dataPICU && $dataPICU->kriteria_6_mata ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[6_mata]"
                                                placeholder="Keterangan...">{{ old('keterangan.6_mata', $dataPICU->keterangan_6_mata ?? '') }}</textarea>
                                        </td>
                                    </tr>
                                    <tr class="sub-criteria-row">
                                        <td class="criteria-no"></td>
                                        <td class="criteria-desc">
                                            <div class="sub-criteria-text">• Letargi</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="6_letargi" id="check_6_letargi"
                                                {{ $dataPICU && $dataPICU->kriteria_6_letargi ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[6_letargi]"
                                                placeholder="Keterangan...">{{ old('keterangan.6_letargi', $dataPICU->keterangan_6_letargi ?? '') }}</textarea>
                                        </td>
                                    </tr>
                                    <tr class="sub-criteria-row">
                                        <td class="criteria-no"></td>
                                        <td class="criteria-desc">
                                            <div class="sub-criteria-text">• Anuria</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="6_anuria" id="check_6_anuria"
                                                {{ $dataPICU && $dataPICU->kriteria_6_anuria ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[6_anuria]"
                                                placeholder="Keterangan...">{{ old('keterangan.6_anuria', $dataPICU->keterangan_6_anuria ?? '') }}</textarea>
                                        </td>
                                    </tr>
                                    <tr class="sub-criteria-row">
                                        <td class="criteria-no"></td>
                                        <td class="criteria-desc">
                                            <div class="sub-criteria-text">• Malas minum</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="6_malas_minum" id="check_6_malas_minum"
                                                {{ $dataPICU && $dataPICU->kriteria_6_malas_minum ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[6_malas_minum]"
                                                placeholder="Keterangan...">{{ old('keterangan.6_malas_minum', $dataPICU->keterangan_6_malas_minum ?? '') }}</textarea>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="criteria-no">7.</td>
                                        <td class="criteria-desc">
                                            <strong>Hipertensi krisis pada anak (&gt;180/120mmHg)</strong>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="7" id="check_7"
                                                {{ $dataPICU && $dataPICU->kriteria_7 ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[7]"
                                                placeholder="Keterangan...">{{ old('keterangan.7', $dataPICU->keterangan_7 ?? '') }}</textarea>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="criteria-no">8.</td>
                                        <td class="criteria-desc">
                                            <strong>Kegagalan organ</strong>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="8" id="check_8"
                                                {{ $dataPICU && $dataPICU->kriteria_8 ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[8]"
                                                placeholder="Keterangan...">{{ old('keterangan.8', $dataPICU->keterangan_8 ?? '') }}</textarea>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="criteria-no">9.</td>
                                        <td class="criteria-desc">
                                            <div class="main-criteria">Pasien anak pasca bedah</div>
                                        </td>
                                        <td class="check-col">
                                            {{-- Sesuai backend $kriteriaMasukFields, ini kriteria_9_main, bukan kriteria_9 --}}
                                            <input type="checkbox" name="check_list[]" value="9_main" id="check_9_main"
                                                {{ $dataPICU && $dataPICU->kriteria_9_main ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[9_main]"
                                                placeholder="Keterangan...">{{ old('keterangan.9_main', $dataPICU->keterangan_9_main ?? '') }}</textarea>
                                        </td>
                                    </tr>
                                     <tr class="sub-criteria-row">
                                        <td class="criteria-no"></td>
                                        <td class="criteria-desc">
                                            <div class="sub-criteria-text">• Traumatologi pada anak</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="9_traumatologi" id="check_9_traumatologi"
                                                {{ $dataPICU && $dataPICU->kriteria_9_traumatologi ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[9_traumatologi]"
                                                placeholder="Keterangan...">{{ old('keterangan.9_traumatologi', $dataPICU->keterangan_9_traumatologi ?? '') }}</textarea>
                                        </td>
                                    </tr>
                                    {{-- Checkbox untuk kriteria_9 (jika ada dan berbeda dari kriteria_9_main) --}}
                                    {{-- Jika kriteria_9 adalah field boolean tersendiri tanpa sub-kriteria dan berbeda dari 9_main --}}
                                    @if(isset($dataPICU) && property_exists($dataPICU, 'kriteria_9') && !property_exists($dataPICU, 'kriteria_9_main'))
                                    <tr>
                                        <td class="criteria-no"></td> <td class="criteria-desc">
                                            <strong>Kriteria 9 Lainnya (jika ada)</strong> </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="9" id="check_9_standalone"
                                                {{ $dataPICU && $dataPICU->kriteria_9 ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[9]"
                                                placeholder="Keterangan...">{{ old('keterangan.9', $dataPICU->keterangan_9 ?? '') }}</textarea>
                                        </td>
                                    </tr>
                                    @endif


                                    <tr>
                                        <td class="criteria-no"></td>
                                        <td class="criteria-desc">
                                            <strong>Diagnosa Kriteria</strong>
                                        </td>
                                        <td class="check-col"></td> <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="diagnosa_kriteria"
                                                placeholder="Diagnosa Kriteria...">{{ old('diagnosa_kriteria', $dataPICU->diagnosa_kriteria ?? '') }}</textarea>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

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
                                    <tr>
                                        <td class="criteria-no">1.</td>
                                        <td class="criteria-desc">
                                            <strong>Parameter hemodinamik stabil</strong>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list_keluar[]" value="1" id="check_keluar_1"
                                                {{ $dataKeluarPICU && $dataKeluarPICU->kriteria_keluar_1 ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan_keluar[1]"
                                                placeholder="Keterangan...">{{ old('keterangan_keluar.1', $dataKeluarPICU->keterangan_keluar_1 ?? '') }}</textarea>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="criteria-no">2.</td>
                                        <td class="criteria-desc">
                                            <strong>Status respirasi stabil (tanpa ETT, jalan nafas bebas, gas darah normal)</strong>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list_keluar[]" value="2" id="check_keluar_2"
                                                {{ $dataKeluarPICU && $dataKeluarPICU->kriteria_keluar_2 ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan_keluar[2]"
                                                placeholder="Keterangan...">{{ old('keterangan_keluar.2', $dataKeluarPICU->keterangan_keluar_2 ?? '') }}</textarea>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="criteria-no">3.</td>
                                        <td class="criteria-desc">
                                            <strong>Kebutuhan suplementasi oksigen minimal (tidak melebihi standar yang
                                                dapat dilakukan di luar ruang intensive pediatrik)</strong>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list_keluar[]" value="3" id="check_keluar_3"
                                                {{ $dataKeluarPICU && $dataKeluarPICU->kriteria_keluar_3 ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan_keluar[3]"
                                                placeholder="Keterangan...">{{ old('keterangan_keluar.3', $dataKeluarPICU->keterangan_keluar_3 ?? '') }}</textarea>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="criteria-no">4.</td>
                                        <td class="criteria-desc">
                                            <strong>Disritmia jantung terkontrol</strong>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list_keluar[]" value="4" id="check_keluar_4"
                                                {{ $dataKeluarPICU && $dataKeluarPICU->kriteria_keluar_4 ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan_keluar[4]"
                                                placeholder="Keterangan...">{{ old('keterangan_keluar.4', $dataKeluarPICU->keterangan_keluar_4 ?? '') }}</textarea>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="criteria-no">5.</td>
                                        <td class="criteria-desc">
                                            <strong>Alat pemantauan tekanan intrakranial intensive tidak terpasang lagi</strong>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list_keluar[]" value="5" id="check_keluar_5"
                                                {{ $dataKeluarPICU && $dataKeluarPICU->kriteria_keluar_5 ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan_keluar[5]"
                                                placeholder="Keterangan...">{{ old('keterangan_keluar.5', $dataKeluarPICU->keterangan_keluar_5 ?? '') }}</textarea>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="criteria-no">6.</td>
                                        <td class="criteria-desc">
                                            <strong>Neurologi stabil kejang terkontrol</strong>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list_keluar[]" value="6" id="check_keluar_6"
                                                {{ $dataKeluarPICU && $dataKeluarPICU->kriteria_keluar_6 ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan_keluar[6]"
                                                placeholder="Keterangan...">{{ old('keterangan_keluar.6', $dataKeluarPICU->keterangan_keluar_6 ?? '') }}</textarea>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="criteria-no">7.</td>
                                        <td class="criteria-desc">
                                            <strong>Kateter pemantau hemodinamik telah dilepas</strong>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list_keluar[]" value="7" id="check_keluar_7"
                                                {{ $dataKeluarPICU && $dataKeluarPICU->kriteria_keluar_7 ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan_keluar[7]"
                                                placeholder="Keterangan...">{{ old('keterangan_keluar.7', $dataKeluarPICU->keterangan_keluar_7 ?? '') }}</textarea>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Simpan
                            </button>
                            <a href="{{ route('rawat-inap.kriteria-masuk-keluar.picu.index', [
                                'kd_unit' => $kd_unit,
                                'kd_pasien' => $kd_pasien,
                                'tgl_masuk' => $tgl_masuk,
                                'urut_masuk' => $urut_masuk,
                            ]) }}"
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
            // Helper function to update textarea based on checkbox state
            function updateTextareaRequired(checkbox, textarea) {
                if (checkbox.checked) {
                    textarea.setAttribute('required', 'required');
                    textarea.style.borderColor = '#dc3545'; // Bootstrap danger color
                    // Add a class to parent for more specific styling if needed
                    if (textarea.parentElement) textarea.parentElement.classList.add('required-field');
                } else {
                    textarea.removeAttribute('required');
                    textarea.style.borderColor = '#ced4da'; // Default Bootstrap border color
                    if (textarea.parentElement) textarea.parentElement.classList.remove('required-field');
                }
            }

            // Handle kriteria masuk checkboxes
            const checkboxesMasuk = document.querySelectorAll('input[name="check_list[]"]');
            checkboxesMasuk.forEach(function(checkbox) {
                const row = checkbox.closest('tr');
                if (!row) return;
                const textareaName = `keterangan[${checkbox.value}]`;
                const keteranganTextarea = row.querySelector(`textarea[name="${textareaName}"]`);

                if (keteranganTextarea) {
                    // Initialize required state based on checkbox for pre-filled forms
                    updateTextareaRequired(checkbox, keteranganTextarea);

                    checkbox.addEventListener('change', function() {
                        updateTextareaRequired(this, keteranganTextarea);
                    });
                }
            });

            // Handle kriteria keluar checkboxes
            const checkboxesKeluar = document.querySelectorAll('input[name="check_list_keluar[]"]');
            checkboxesKeluar.forEach(function(checkbox) {
                const row = checkbox.closest('tr');
                if(!row) return;
                const textareaName = `keterangan_keluar[${checkbox.value}]`;
                const keteranganTextarea = row.querySelector(`textarea[name="${textareaName}"]`);

                if (keteranganTextarea) {
                     // Initialize required state based on checkbox for pre-filled forms
                    updateTextareaRequired(checkbox, keteranganTextarea);

                    checkbox.addEventListener('change', function() {
                        updateTextareaRequired(this, keteranganTextarea);
                    });
                }
            });

            // Form validation before submit
            document.getElementById('picuCriteriaForm').addEventListener('submit', function(e) {
                let hasError = false;
                let firstErrorTextarea = null;

                // Check kriteria masuk
                checkboxesMasuk.forEach(function(checkbox) {
                    if (checkbox.checked) {
                        const row = checkbox.closest('tr');
                        if (!row) return;
                        const textareaName = `keterangan[${checkbox.value}]`;
                        const textarea = row.querySelector(`textarea[name="${textareaName}"]`);

                        if (textarea && !textarea.value.trim()) {
                            hasError = true;
                            textarea.style.borderColor = '#dc3545';
                            if (!firstErrorTextarea) firstErrorTextarea = textarea;
                        }
                    }
                });

                // Check kriteria keluar
                checkboxesKeluar.forEach(function(checkbox) {
                    if (checkbox.checked) {
                        const row = checkbox.closest('tr');
                        if(!row) return;
                        const textareaName = `keterangan_keluar[${checkbox.value}]`;
                        const textarea = row.querySelector(`textarea[name="${textareaName}"]`);
                        
                        if (textarea && !textarea.value.trim()) {
                            hasError = true;
                            textarea.style.borderColor = '#dc3545';
                             if (!firstErrorTextarea) firstErrorTextarea = textarea;
                        }
                    }
                });

                if (hasError) {
                    e.preventDefault();
                    alert('Harap isi keterangan untuk semua kriteria yang dipilih.');
                    if (firstErrorTextarea) {
                        firstErrorTextarea.focus();
                    }
                }
            });
        });
    </script>
@endpush