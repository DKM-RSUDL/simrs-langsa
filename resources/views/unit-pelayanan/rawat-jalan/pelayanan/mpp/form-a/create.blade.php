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

            .mpp-table {
                border-collapse: collapse;
                width: 100%;
                border: 1px solid #dee2e6;
            }

            .mpp-table th,
            .mpp-table td {
                border: 1px solid #dee2e6;
                padding: 6px;
                vertical-align: top;
            }

            .mpp-table th {
                background-color: #f8f9fa;
                font-weight: 700;
                text-align: center;
            }

            .datetime-column {
                width: 150px;
                text-align: center;
            }

            .criteria-column {
                width: 75%;
            }

            .datetime-inputs {
                display: flex;
                flex-direction: column;
                gap: 0.5rem;
            }

            .datetime-inputs input {
                font-size: 0.85rem;
                padding: 0.375rem 0.5rem;
            }

            .section-header {
                background-color: #e9ecef;
                font-weight: bold;
                text-align: center;
            }

            .screening-row {
                background-color: #fff9f0;
            }

            .assessment-row {
                background-color: #f0fff4;
            }

            .identification-row {
                background-color: #f0f8ff;
            }

            .planning-row {
                background-color: #fff0f5;
            }

            .criteria-item {
                display: flex;
                align-items: flex-start;
                margin-bottom: 8px;
                padding: 4px 0;
            }

            .criteria-item:last-child {
                margin-bottom: 0;
            }

            .criteria-checkbox {
                margin-right: 8px;
                margin-top: 2px;
                flex-shrink: 0;
                cursor: pointer;
            }

            .criteria-label {
                flex: 1;
                font-size: 0.9rem;
                line-height: 1.4;
                color: #495057;
                cursor: pointer;
            }

            .form-control-textarea {
                min-height: 100px;
                resize: vertical;
                width: 100%;
            }

            .dpjp-tambahan-item {
                position: relative;
            }

            .dpjp-tambahan-item .input-group {
                display: flex;
                align-items: stretch;
            }

            .dpjp-tambahan-item .form-select {
                flex: 1;
            }

            .dpjp-tambahan-item .btn {
                border-top-left-radius: 0;
                border-bottom-left-radius: 0;
                z-index: 1;
            }

            .select2-tambahan+.select2-container {
                width: calc(100% - 42px) !important;
            }

            .input-group .select2-container {
                flex: 1;
            }

            .input-group .select2-container .select2-selection {
                border-top-right-radius: 0;
                border-bottom-right-radius: 0;
                height: calc(2.25rem + 2px);
                border-right: 0;
            }

            .input-group .btn {
                border-top-left-radius: 0;
                border-bottom-left-radius: 0;
            }
        </style>
    @endpush

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <div class="text-center mt-1 mb-2">
                <h5 class="text-secondary fw-bold">FORM A-EVALUASI AWAL MPP</h5>
            </div>

            <hr>

            <div class="form-section">
                <form
                    action="{{ route('rawat-jalan.mpp.form-a.store', [
                        'kd_unit' => $kd_unit,
                        'kd_pasien' => $kd_pasien,
                        'tgl_masuk' => $tgl_masuk,
                        'urut_masuk' => $urut_masuk,
                    ]) }}"
                    method="post" id="mppEvaluationForm">
                    @csrf

                    <!-- Section Dokter -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="section-title mb-0">Informasi Dokter</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">DPJP Utama</label>
                                        <select name="dpjp_utama" class="form-select select2" style="width: 100%">
                                            <option value="">--Pilih--</option>
                                            @foreach ($dokter as $dok)
                                                <option value="{{ $dok->kd_dokter }}"
                                                    {{ isset($mppData) && $mppData->dpjp_utama == $dok->kd_dokter ? 'selected' : '' }}>
                                                    {{ $dok->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">DPJP Tambahan</label>
                                        <div id="dpjp-tambahan-container">
                                            @if (isset($mppData) && $mppData->dpjp_tambahan)
                                                @php
                                                    $dpjpTambahanArray = is_array($mppData->dpjp_tambahan)
                                                        ? $mppData->dpjp_tambahan
                                                        : json_decode($mppData->dpjp_tambahan, true);
                                                    if (!is_array($dpjpTambahanArray)) {
                                                        $dpjpTambahanArray = [$mppData->dpjp_tambahan];
                                                    }
                                                @endphp
                                                @foreach ($dpjpTambahanArray as $index => $dpjpTambahan)
                                                    <div class="dpjp-tambahan-item mb-2" data-index="{{ $index }}">
                                                        <div class="input-group">
                                                            <select name="dpjp_tambahan[]"
                                                                class="form-select select2-tambahan">
                                                                <option value="">--Pilih--</option>
                                                                @foreach ($dokter as $dok)
                                                                    <option value="{{ $dok->kd_dokter }}"
                                                                        {{ $dpjpTambahan == $dok->kd_dokter ? 'selected' : '' }}>
                                                                        {{ $dok->nama }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <button type="button"
                                                                class="btn btn-outline-danger remove-dpjp-tambahan"
                                                                {{ $index == 0 ? 'style=display:none;' : '' }}>
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="dpjp-tambahan-item mb-2" data-index="0">
                                                    <div class="input-group">
                                                        <select name="dpjp_tambahan[]" class="form-select select2-tambahan">
                                                            <option value="">--Pilih--</option>
                                                            @foreach ($dokter as $dok)
                                                                <option value="{{ $dok->kd_dokter }}">{{ $dok->nama }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <button type="button"
                                                            class="btn btn-outline-danger remove-dpjp-tambahan"
                                                            style="display: none;">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-outline-primary btn-sm mt-2"
                                            id="add-dpjp-tambahan">
                                            <i class="bi bi-plus"></i> Tambah Dokter
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main MPP Table -->
                    <div class="card mb-4">
                        <div class="card-body p-0">
                            <table class="mpp-table">
                                <thead>
                                    <tr>
                                        <th class="datetime-column">TANGGAL DAN JAM</th>
                                        <th class="criteria-column">CATATAN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Section I: Identifikasi/Screening Pasien -->
                                    <tr class="section-header">
                                        <td colspan="2">I. IDENTIFIKASI/SCREENING PASIEN</td>
                                    </tr>

                                    <!-- Row dengan tanggal jam dan semua kriteria -->
                                    <tr class="screening-row">
                                        <td class="datetime-column" rowspan="17"> <!-- Updated rowspan from 13 to 18 -->
                                            <div class="datetime-inputs">
                                                <input type="text" name="screening_date"
                                                    class="form-control form-control-sm screening-date date"
                                                    placeholder="yyyy/mm/dd" readonly>
                                                <input type="time" name="screening_time"
                                                    class="form-control form-control-sm screening-time">
                                            </div>
                                        </td>
                                        <td class="criteria-column">
                                            <div class="criteria-item">
                                                <input type="checkbox" name="screening_criteria[]" value="fungsi_kognitif"
                                                    class="criteria-checkbox screening-checkbox" id="s1">
                                                <label class="criteria-label" for="s1">Fungsi kognitif rendah</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="screening-row">
                                        <td class="criteria-column">
                                            <div class="criteria-item">
                                                <input type="checkbox" name="screening_criteria[]" value="risiko_tinggi"
                                                    class="criteria-checkbox screening-checkbox" id="s2">
                                                <label class="criteria-label" for="s2">Risiko tinggi</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="screening-row">
                                        <td class="criteria-column">
                                            <div class="criteria-item">
                                                <input type="checkbox" name="screening_criteria[]" value="potensi_komplain"
                                                    class="criteria-checkbox screening-checkbox" id="s3">
                                                <label class="criteria-label" for="s3">Potensi komplain
                                                    tinggi</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- SEPARATED: Kasus dengan riwayat kronis, katastropik, terminal -->
                                    <tr class="screening-row">
                                        <td class="criteria-column">
                                            <div class="criteria-item">
                                                <input type="checkbox" name="screening_criteria[]" value="riwayat_kronis"
                                                    class="criteria-checkbox screening-checkbox" id="s4">
                                                <label class="criteria-label" for="s4">Kasus dengan riwayat
                                                    kronis</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="screening-row">
                                        <td class="criteria-column">
                                            <div class="criteria-item">
                                                <input type="checkbox" name="screening_criteria[]"
                                                    value="kasus_katastropik" class="criteria-checkbox screening-checkbox"
                                                    id="s4b">
                                                <label class="criteria-label" for="s4b">Kasus katastropik</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="screening-row">
                                        <td class="criteria-column">
                                            <div class="criteria-item">
                                                <input type="checkbox" name="screening_criteria[]" value="kasus_terminal"
                                                    class="criteria-checkbox screening-checkbox" id="s4c">
                                                <label class="criteria-label" for="s4c">Kasus terminal</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="screening-row">
                                        <td class="criteria-column">
                                            <div class="criteria-item">
                                                <input type="checkbox" name="screening_criteria[]"
                                                    value="status_fungsional" class="criteria-checkbox screening-checkbox"
                                                    id="s5">
                                                <label class="criteria-label" for="s5">Status fungsional rendah,
                                                    kebutuhan ADL tinggi</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="screening-row">
                                        <td class="criteria-column">
                                            <div class="criteria-item">
                                                <input type="checkbox" name="screening_criteria[]"
                                                    value="peralatan_medis" class="criteria-checkbox screening-checkbox"
                                                    id="s6">
                                                <label class="criteria-label" for="s6">Riwayat penggunaan peralatan
                                                    medis di masa lalu</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- SEPARATED: Riwayat gangguan mental, krisis keluarga, isu sosial -->
                                    <tr class="screening-row">
                                        <td class="criteria-column">
                                            <div class="criteria-item">
                                                <input type="checkbox" name="screening_criteria[]"
                                                    value="gangguan_mental" class="criteria-checkbox screening-checkbox"
                                                    id="s7">
                                                <label class="criteria-label" for="s7">Riwayat gangguan
                                                    mental</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="screening-row">
                                        <td class="criteria-column">
                                            <div class="criteria-item">
                                                <input type="checkbox" name="screening_criteria[]"
                                                    value="krisis_keluarga" class="criteria-checkbox screening-checkbox"
                                                    id="s7b">
                                                <label class="criteria-label" for="s7b">Krisis keluarga</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="screening-row">
                                        <td class="criteria-column">
                                            <div class="criteria-item">
                                                <input type="checkbox" name="screening_criteria[]" value="isu_sosial"
                                                    class="criteria-checkbox screening-checkbox" id="s7c">
                                                <label class="criteria-label" for="s7c">Isu sosial (terlantar,
                                                    tinggal sendiri, narkoba)</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="screening-row">
                                        <td class="criteria-column">
                                            <div class="criteria-item">
                                                <input type="checkbox" name="screening_criteria[]" value="sering_igd"
                                                    class="criteria-checkbox screening-checkbox" id="s8">
                                                <label class="criteria-label" for="s8">Sering masuk IGD, readmisi
                                                    RS</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="screening-row">
                                        <td class="criteria-column">
                                            <div class="criteria-item">
                                                <input type="checkbox" name="screening_criteria[]"
                                                    value="perkiraan_asuhan" class="criteria-checkbox screening-checkbox"
                                                    id="s9">
                                                <label class="criteria-label" for="s9">Perkiraan asuhan dengan biaya
                                                    tinggi</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="screening-row">
                                        <td class="criteria-column">
                                            <div class="criteria-item">
                                                <input type="checkbox" name="screening_criteria[]"
                                                    value="sistem_pembiayaan" class="criteria-checkbox screening-checkbox"
                                                    id="s10">
                                                <label class="criteria-label" for="s10">Kemungkinan sistem pembiayaan
                                                    komplek, masalah finansial</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="screening-row">
                                        <td class="criteria-column">
                                            <div class="criteria-item">
                                                <input type="checkbox" name="screening_criteria[]" value="length_of_stay"
                                                    class="criteria-checkbox screening-checkbox" id="s11">
                                                <label class="criteria-label" for="s11">Kasus yang melebihi rata-rata
                                                    length of stay</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="screening-row">
                                        <td class="criteria-column">
                                            <div class="criteria-item">
                                                <input type="checkbox" name="screening_criteria[]"
                                                    value="rencana_pemulangan"
                                                    class="criteria-checkbox screening-checkbox" id="s12">
                                                <label class="criteria-label" for="s12">Kasus yang rencana
                                                    pemulangannya berisiko/membutuhkan kontinuitas pelayanan</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="screening-row">
                                        <td class="criteria-column">
                                            <div class="criteria-item">
                                                <input type="checkbox" name="screening_criteria[]" value="lain_lain"
                                                    class="criteria-checkbox screening-checkbox" id="s13">
                                                <input type="checkbox" name="screening_criteria[]" value="lain_lain"
                                                    class="criteria-checkbox screening-checkbox" id="s13">
                                                <label class="criteria-label" for="s13">Lain-lain</label>
                                            </div>
                                            <!-- Tambahkan textarea untuk free text -->
                                            <div class="mt-2" id="lain-lain-text-container" style="display: none;">
                                                <textarea name="lain_lain_text" class="form-control form-control-sm" rows="2"
                                                    placeholder="Jelaskan lain-lain..." id="lain-lain-textarea">{{ isset($mppData) ? $mppData->lain_lain_text : '' }}</textarea>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Section II: Assessment -->
                                    <tr class="section-header">
                                        <td colspan="2">II. ASSESSMENT</td>
                                    </tr>

                                    <tr class="assessment-row">
                                        <td class="datetime-column" rowspan="14"> <!-- Updated rowspan from 11 to 14 -->
                                            <div class="datetime-inputs">
                                                <input type="text" name="assessment_date"
                                                    class="form-control form-control-sm assessment-date date"
                                                    placeholder="yyyy/mm/dd" readonly>
                                                <input type="time" name="assessment_time"
                                                    class="form-control form-control-sm assessment-time">
                                            </div>
                                        </td>
                                        <!-- SEPARATED: Fisik, Fungsional, Kognitif, Kemandirian -->
                                        <td class="criteria-column">
                                            <div class="criteria-item">
                                                <input type="checkbox" name="assessment_criteria[]"
                                                    value="assessment_fisik" class="criteria-checkbox assessment-checkbox"
                                                    id="a1">
                                                <label class="criteria-label" for="a1">Assessment fisik</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="assessment-row">
                                        <td class="criteria-column">
                                            <div class="criteria-item">
                                                <input type="checkbox" name="assessment_criteria[]"
                                                    value="assessment_fungsional"
                                                    class="criteria-checkbox assessment-checkbox" id="a1b">
                                                <label class="criteria-label" for="a1b">Assessment fungsional</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="assessment-row">
                                        <td class="criteria-column">
                                            <div class="criteria-item">
                                                <input type="checkbox" name="assessment_criteria[]"
                                                    value="assessment_kognitif"
                                                    class="criteria-checkbox assessment-checkbox" id="a1c">
                                                <label class="criteria-label" for="a1c">Assessment kognitif</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="assessment-row">
                                        <td class="criteria-column">
                                            <div class="criteria-item">
                                                <input type="checkbox" name="assessment_criteria[]"
                                                    value="assessment_kemandirian"
                                                    class="criteria-checkbox assessment-checkbox" id="a1d">
                                                <label class="criteria-label" for="a1d">Assessment
                                                    kemandirian</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="assessment-row">
                                        <td class="criteria-column">
                                            <div class="criteria-item">
                                                <input type="checkbox" name="assessment_criteria[]"
                                                    value="riwayat_kesehatan"
                                                    class="criteria-checkbox assessment-checkbox" id="a2">
                                                <label class="criteria-label" for="a2">Riwayat Kesehatan</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="assessment-row">
                                        <td class="criteria-column">
                                            <div class="criteria-item">
                                                <input type="checkbox" name="assessment_criteria[]"
                                                    value="perilaku_psiko" class="criteria-checkbox assessment-checkbox"
                                                    id="a3">
                                                <label class="criteria-label" for="a3">Perilaku
                                                    psiko-sosio-kultural</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="assessment-row">
                                        <td class="criteria-column">
                                            <div class="criteria-item">
                                                <input type="checkbox" name="assessment_criteria[]"
                                                    value="kesehatan_mental" class="criteria-checkbox assessment-checkbox"
                                                    id="a4">
                                                <label class="criteria-label" for="a4">Kesehatan mental</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="assessment-row">
                                        <td class="criteria-column">
                                            <div class="criteria-item">
                                                <input type="checkbox" name="assessment_criteria[]"
                                                    value="dukungan_keluarga"
                                                    class="criteria-checkbox assessment-checkbox" id="a5">
                                                <label class="criteria-label" for="a5">Tersedianya dukungan
                                                    keluarga, kemampuan merawat dari pemberi asuhan</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="assessment-row">
                                        <td class="criteria-column">
                                            <div class="criteria-item">
                                                <input type="checkbox" name="assessment_criteria[]"
                                                    value="finansial_asuransi"
                                                    class="criteria-checkbox assessment-checkbox" id="a6">
                                                <label class="criteria-label" for="a6">Finansial/status
                                                    asuransi</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="assessment-row">
                                        <td class="criteria-column">
                                            <div class="criteria-item">
                                                <input type="checkbox" name="assessment_criteria[]" value="riwayat_obat"
                                                    class="criteria-checkbox assessment-checkbox" id="a7">
                                                <label class="criteria-label" for="a7">Riwayat penggunaan obat,
                                                    alternatif</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="assessment-row">
                                        <td class="criteria-column">
                                            <div class="criteria-item">
                                                <input type="checkbox" name="assessment_criteria[]"
                                                    value="trauma_kekerasan" class="criteria-checkbox assessment-checkbox"
                                                    id="a8">
                                                <label class="criteria-label"
                                                    for="a8">Riwayat/trauma/kekerasan</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="assessment-row">
                                        <td class="criteria-column">
                                            <div class="criteria-item">
                                                <input type="checkbox" name="assessment_criteria[]"
                                                    value="health_literacy" class="criteria-checkbox assessment-checkbox"
                                                    id="a9">
                                                <label class="criteria-label" for="a9">Pemahaman tentang kesehatan
                                                    (health literacy)</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="assessment-row">
                                        <td class="criteria-column">
                                            <div class="criteria-item">
                                                <input type="checkbox" name="assessment_criteria[]" value="aspek_legal"
                                                    class="criteria-checkbox assessment-checkbox" id="a10">
                                                <label class="criteria-label" for="a10">Aspek legal</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="assessment-row">
                                        <td class="criteria-column">
                                            <div class="criteria-item">
                                                <input type="checkbox" name="assessment_criteria[]" value="harapan_hasil"
                                                    class="criteria-checkbox assessment-checkbox" id="a11">
                                                <label class="criteria-label" for="a11">Harapan terhadap hasil
                                                    asuhan, kemampuan untuk menerima perubahan</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Section III: Identifikasi Masalah -->
                                    <tr class="section-header">
                                        <td colspan="2">III. IDENTIFIKASI MASALAH</td>
                                    </tr>

                                    <tr class="identification-row">
                                        <td class="datetime-column" rowspan="9"> <!-- Updated rowspan from 8 to 9 -->
                                            <div class="datetime-inputs">
                                                <input type="text" name="identification_date"
                                                    class="form-control form-control-sm identification-date date"
                                                    placeholder="yyyy/mm/dd" readonly>
                                                <input type="time" name="identification_time"
                                                    class="form-control form-control-sm identification-time">
                                            </div>
                                        </td>
                                        <td class="criteria-column">
                                            <div class="criteria-item">
                                                <input type="checkbox" name="identification_criteria[]"
                                                    value="tingkat_asuhan"
                                                    class="criteria-checkbox identification-checkbox" id="i1">
                                                <label class="criteria-label" for="i1">Tingkat asuhan yang tidak
                                                    sesuai dengan panduan, norma yang digunakan</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- SEPARATED: Over/under utilization -->
                                    <tr class="identification-row">
                                        <td class="criteria-column">
                                            <div class="criteria-item">
                                                <input type="checkbox" name="identification_criteria[]"
                                                    value="over_utilization"
                                                    class="criteria-checkbox identification-checkbox" id="i2a">
                                                <label class="criteria-label" for="i2a">Over utilization pelayanan
                                                    dengan dasar panduan norma yang digunakan</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="identification-row">
                                        <td class="criteria-column">
                                            <div class="criteria-item">
                                                <input type="checkbox" name="identification_criteria[]"
                                                    value="under_utilization"
                                                    class="criteria-checkbox identification-checkbox" id="i2b">
                                                <label class="criteria-label" for="i2b">Under utilization pelayanan
                                                    dengan dasar panduan norma yang digunakan</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="identification-row">
                                        <td class="criteria-column">
                                            <div class="criteria-item">
                                                <input type="checkbox" name="identification_criteria[]"
                                                    value="ketidak_patuhan"
                                                    class="criteria-checkbox identification-checkbox" id="i3">
                                                <label class="criteria-label" for="i3">Ketidak patuhan
                                                    pasien</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="identification-row">
                                        <td class="criteria-column">
                                            <div class="criteria-item">
                                                <input type="checkbox" name="identification_criteria[]"
                                                    value="edukasi_kurang"
                                                    class="criteria-checkbox identification-checkbox" id="i4">
                                                <label class="criteria-label" for="i4">Edukasi kurang memadai atau
                                                    pemahamannya yang belum memadai tentang proses penyakit, kondisi terkini
                                                    dan daftar obat</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="identification-row">
                                        <td class="criteria-column">
                                            <div class="criteria-item">
                                                <input type="checkbox" name="identification_criteria[]"
                                                    value="kurang_dukungan"
                                                    class="criteria-checkbox identification-checkbox" id="i5">
                                                <label class="criteria-label" for="i5">Kurangnya dukungan keluarga,
                                                    tidak ada keluarga</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="identification-row">
                                        <td class="criteria-column">
                                            <div class="criteria-item">
                                                <input type="checkbox" name="identification_criteria[]"
                                                    value="penurunan_determinasi"
                                                    class="criteria-checkbox identification-checkbox" id="i6">
                                                <label class="criteria-label" for="i6">Penurunan determinasi pasien
                                                    (ketika tingkat keparahan/komplikasi meningkat)</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="identification-row">
                                        <td class="criteria-column">
                                            <div class="criteria-item">
                                                <input type="checkbox" name="identification_criteria[]"
                                                    value="kendala_keuangan"
                                                    class="criteria-checkbox identification-checkbox" id="i7">
                                                <label class="criteria-label" for="i7">Kendala keuangan ketika
                                                    keparahan/komplikasi meningkat</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="identification-row">
                                        <td class="criteria-column">
                                            <div class="criteria-item">
                                                <input type="checkbox" name="identification_criteria[]"
                                                    value="pemulangan_rujukan"
                                                    class="criteria-checkbox identification-checkbox" id="i8">
                                                <label class="criteria-label" for="i8">Pemulangan/rujukan yang belum
                                                    memenuhi kriteria atau sebaliknya, pemulangan/rujukan yang
                                                    ditunda</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Section IV: Rencana Asuhan -->
                                    <tr class="section-header">
                                        <td colspan="2">IV. PERENCANAAN MANAJEMEN PELAYANAN PASIEN</td>
                                    </tr>

                                    <tr class="planning-row">
                                        <td class="datetime-column" rowspan="5">
                                            <div class="datetime-inputs">
                                                <input type="text" name="planning_date"
                                                    class="form-control form-control-sm planning-date date"
                                                    placeholder="yyyy/mm/dd" readonly>
                                                <input type="time" name="planning_time"
                                                    class="form-control form-control-sm planning-time">
                                            </div>
                                        </td>
                                        <td class="criteria-column">
                                            <div class="criteria-item">
                                                <input type="checkbox" name="planning_criteria[]"
                                                    value="validasi_rencana" class="criteria-checkbox planning-checkbox"
                                                    id="p1">
                                                <label class="criteria-label" for="p1">Validasi rencana asuhan,
                                                    sesuaikan/konsisten dengan panduan lakukan kolaborasi komunikasi dengan
                                                    PPA dalam akses pelayanan</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="planning-row">
                                        <td class="criteria-column">
                                            <div class="criteria-item">
                                                <input type="checkbox" name="planning_criteria[]"
                                                    value="rencana_informasi" class="criteria-checkbox planning-checkbox"
                                                    id="p2">
                                                <label class="criteria-label" for="p2">Tentukan rencana pemberian
                                                    informasi kepada pasien keluarga untuk pengambilan keputusan</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="planning-row">
                                        <td class="criteria-column">
                                            <div class="criteria-item">
                                                <input type="checkbox" name="planning_criteria[]"
                                                    value="rencana_melibatkan" class="criteria-checkbox planning-checkbox"
                                                    id="p3">
                                                <label class="criteria-label" for="p3">Tentukan rencana untuk
                                                    melibatkan pasien dan keluarga dalam menentukan asuhan termasuk
                                                    kemungkinan perubahan rencana</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="planning-row">
                                        <td class="criteria-column">
                                            <div class="criteria-item">
                                                <input type="checkbox" name="planning_criteria[]"
                                                    value="fasilitas_penyelesaian"
                                                    class="criteria-checkbox planning-checkbox" id="p4">
                                                <label class="criteria-label" for="p4">Fasilitas penyelesaian
                                                    masalah dan konflik</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="planning-row">
                                        <td class="criteria-column">
                                            <div class="criteria-item">
                                                <input type="checkbox" name="planning_criteria[]"
                                                    value="bantuan_alternatif" class="criteria-checkbox planning-checkbox"
                                                    id="p5">
                                                <label class="criteria-label" for="p5">Bantuan dalam alternatif
                                                    solusi permasalahan keuangan</label>
                                            </div>
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
                            <a href="{{ route('rawat-jalan.mpp.form-a.index', [
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
        document.addEventListener('DOMContentLoaded', function() {

            // Handle show/hide lain-lain text area
            const lainLainCheckbox = document.getElementById('s13');
            const lainLainContainer = document.getElementById('lain-lain-text-container');
            const lainLainTextarea = document.getElementById('lain-lain-textarea');

            if (lainLainCheckbox && lainLainContainer) {
                // Check initial state for edit mode
                if (lainLainCheckbox.checked) {
                    lainLainContainer.style.display = 'block';
                }

                lainLainCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        lainLainContainer.style.display = 'block';
                        lainLainTextarea.focus();
                    } else {
                        lainLainContainer.style.display = 'none';
                        lainLainTextarea.value = '';
                    }
                });
            }

            // Update form validation untuk lain-lain
            // Di bagian form validation yang sudah ada, tambahkan:
            // Validate lain-lain text when checkbox is checked
            if (lainLainCheckbox && lainLainCheckbox.checked && lainLainTextarea) {
                if (!lainLainTextarea.value.trim()) {
                    lainLainTextarea.classList.add('is-invalid');
                    isValid = false;
                } else {
                    lainLainTextarea.classList.remove('is-invalid');
                }
            }


            let dpjpTambahanIndex = document.querySelectorAll('.dpjp-tambahan-item').length;

            // Store doctor options for dynamic creation - safer approach
            const doctorOptions = [];
            @foreach ($dokter as $dok)
                doctorOptions.push({
                    value: '{{ addslashes($dok->kd_dokter) }}',
                    text: '{{ addslashes($dok->nama) }}'
                });
            @endforeach

            // Function to build options HTML
            function buildOptionsHtml(selectedValue = '') {
                let html = '<option value="">--Pilih--</option>';
                doctorOptions.forEach(function(doctor) {
                    const selected = selectedValue === doctor.value ? 'selected' : '';
                    html += `<option value="${doctor.value}" ${selected}>${doctor.text}</option>`;
                });
                return html;
            }

            // Function to initialize Select2 for new elements
            function initializeSelect2(element) {
                if (typeof $.fn.select2 !== 'undefined') {
                    $(element).select2({
                        theme: 'bootstrap-5',
                        placeholder: '--Pilih--',
                        width: '100%'
                    });
                }
            }

            // Function to reinitialize existing selects with proper data
            function reinitializeExistingSelects() {
                $('.select2-tambahan').each(function() {
                    const currentValue = $(this).val();

                    // Destroy existing Select2 if exists
                    if ($(this).hasClass('select2-hidden-accessible')) {
                        $(this).select2('destroy');
                    }

                    // Rebuild options with current value preserved
                    $(this).html(buildOptionsHtml(currentValue));

                    // Re-initialize Select2
                    initializeSelect2(this);
                });
            }

            // Initialize existing Select2 elements
            if (typeof $.fn.select2 !== 'undefined') {
                $('.select2').select2({
                    theme: 'bootstrap-5',
                    placeholder: '--Pilih--'
                });

                // Fix existing DPJP Tambahan selects after a short delay to ensure DOM is ready
                setTimeout(function() {
                    reinitializeExistingSelects();
                }, 100);
            }

            // Add new DPJP Tambahan
            document.getElementById('add-dpjp-tambahan').addEventListener('click', function() {
                const container = document.getElementById('dpjp-tambahan-container');
                const newItem = document.createElement('div');
                newItem.className = 'dpjp-tambahan-item mb-2';
                newItem.setAttribute('data-index', dpjpTambahanIndex);

                newItem.innerHTML = `
                    <div class="input-group">
                        <select name="dpjp_tambahan[]" class="form-select select2-tambahan">
                            ${buildOptionsHtml()}
                        </select>
                        <button type="button" class="btn btn-outline-danger remove-dpjp-tambahan">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                `;

                container.appendChild(newItem);

                // Initialize Select2 for the new element
                const newSelect = newItem.querySelector('select');
                initializeSelect2(newSelect);

                dpjpTambahanIndex++;
                updateRemoveButtons();
            });

            // Remove DPJP Tambahan
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-dpjp-tambahan') || e.target.closest(
                        '.remove-dpjp-tambahan')) {
                    const button = e.target.classList.contains('remove-dpjp-tambahan') ? e.target : e.target
                        .closest('.remove-dpjp-tambahan');
                    const item = button.closest('.dpjp-tambahan-item');

                    // Destroy Select2 before removing element
                    const select = item.querySelector('select');
                    if (typeof $.fn.select2 !== 'undefined' && $(select).hasClass(
                            'select2-hidden-accessible')) {
                        $(select).select2('destroy');
                    }

                    item.remove();
                    updateRemoveButtons();
                }
            });

            // Update remove buttons visibility
            function updateRemoveButtons() {
                const items = document.querySelectorAll('.dpjp-tambahan-item');
                items.forEach((item, index) => {
                    const removeBtn = item.querySelector('.remove-dpjp-tambahan');
                    if (index === 0 && items.length === 1) {
                        removeBtn.style.display = 'none';
                    } else {
                        removeBtn.style.display = 'block';
                    }
                });
            }

            // Initial update of remove buttons
            updateRemoveButtons();

            // Form validation
            document.getElementById('mppEvaluationForm').addEventListener('submit', function(e) {

                // Remove empty dpjp_tambahan values before submission
                const dpjpTambahanSelects = document.querySelectorAll('select[name="dpjp_tambahan[]"]');
                dpjpTambahanSelects.forEach(select => {
                    if (!select.value || select.value === '') {
                        select.remove();
                    }
                });

                let isValid = true;

                // Validate Screening Section
                const screeningCheckboxes = document.querySelectorAll(
                    'input[name="screening_criteria[]"]:checked');
                const screeningDate = document.querySelector('input[name="screening_date"]');
                const screeningTime = document.querySelector('input[name="screening_time"]');
                if (screeningCheckboxes.length > 0) {
                    if (!screeningDate.value.trim()) {
                        screeningDate.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        screeningDate.classList.remove('is-invalid');
                    }
                    if (!screeningTime.value.trim()) {
                        screeningTime.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        screeningTime.classList.remove('is-invalid');
                    }
                } else {
                    screeningDate.classList.remove('is-invalid');
                    screeningTime.classList.remove('is-invalid');
                }

                // Validate Assessment Section
                const assessmentCheckboxes = document.querySelectorAll(
                    'input[name="assessment_criteria[]"]:checked');
                const assessmentDate = document.querySelector('input[name="assessment_date"]');
                const assessmentTime = document.querySelector('input[name="assessment_time"]');
                if (assessmentCheckboxes.length > 0) {
                    if (!assessmentDate.value.trim()) {
                        assessmentDate.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        assessmentDate.classList.remove('is-invalid');
                    }
                    if (!assessmentTime.value.trim()) {
                        assessmentTime.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        assessmentTime.classList.remove('is-invalid');
                    }
                } else {
                    assessmentDate.classList.remove('is-invalid');
                    assessmentTime.classList.remove('is-invalid');
                }

                // Validate Identification Section
                const identificationCheckboxes = document.querySelectorAll(
                    'input[name="identification_criteria[]"]:checked');
                const identificationDate = document.querySelector('input[name="identification_date"]');
                const identificationTime = document.querySelector('input[name="identification_time"]');
                if (identificationCheckboxes.length > 0) {
                    if (!identificationDate.value.trim()) {
                        identificationDate.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        identificationDate.classList.remove('is-invalid');
                    }
                    if (!identificationTime.value.trim()) {
                        identificationTime.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        identificationTime.classList.remove('is-invalid');
                    }
                } else {
                    identificationDate.classList.remove('is-invalid');
                    identificationTime.classList.remove('is-invalid');
                }

                // Validate Planning Section
                const planningCheckboxes = document.querySelectorAll(
                    'input[name="planning_criteria[]"]:checked');
                const planningDate = document.querySelector('input[name="planning_date"]');
                const planningTime = document.querySelector('input[name="planning_time"]');
                if (planningCheckboxes.length > 0) {
                    if (!planningDate.value.trim()) {
                        planningDate.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        planningDate.classList.remove('is-invalid');
                    }
                    if (!planningTime.value.trim()) {
                        planningTime.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        planningTime.classList.remove('is-invalid');
                    }
                } else {
                    planningDate.classList.remove('is-invalid');
                    planningTime.classList.remove('is-invalid');
                }

                // Time format validation for all time inputs
                document.querySelectorAll('input[type="time"]').forEach(timeInput => {
                    if (timeInput.value && !/^([01]\d|2[0-3]):([0-5]\d)$/.test(timeInput.value)) {
                        timeInput.classList.add('is-invalid');
                        isValid = false;
                    } else if (!timeInput.value && timeInput.classList.contains('is-invalid')) {
                        // Only keep is-invalid if the section requires it
                        const section = timeInput.className.includes('screening-time') ?
                            'screening' :
                            timeInput.className.includes('assessment-time') ? 'assessment' :
                            timeInput.className.includes('identification-time') ? 'identification' :
                            'planning';
                        const checkboxes = document.querySelectorAll(
                            `input[name="${section}_criteria[]"]:checked`);
                        if (checkboxes.length === 0) {
                            timeInput.classList.remove('is-invalid');
                        }
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    alert(
                        'Mohon lengkapi tanggal dan jam untuk setiap seksi yang memiliki kriteria yang dipilih.'
                    );
                }
            });

            // Real-time validation for checkboxes
            const sections = [{
                    checkboxClass: 'screening-checkbox',
                    dateClass: 'screening-date',
                    timeClass: 'screening-time',
                    name: 'screening'
                },
                {
                    checkboxClass: 'assessment-checkbox',
                    dateClass: 'assessment-date',
                    timeClass: 'assessment-time',
                    name: 'assessment'
                },
                {
                    checkboxClass: 'identification-checkbox',
                    dateClass: 'identification-date',
                    timeClass: 'identification-time',
                    name: 'identification'
                },
                {
                    checkboxClass: 'planning-checkbox',
                    dateClass: 'planning-date',
                    timeClass: 'planning-time',
                    name: 'planning'
                }
            ];

            sections.forEach(section => {
                const checkboxes = document.querySelectorAll(`.${section.checkboxClass}`);
                const dateInput = document.querySelector(`.${section.dateClass}`);
                const timeInput = document.querySelector(`.${section.timeClass}`);

                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
                        if (anyChecked) {
                            if (!dateInput.value.trim()) {
                                dateInput.classList.add('is-invalid');
                            }
                            if (!timeInput.value.trim()) {
                                timeInput.classList.add('is-invalid');
                            }
                        } else {
                            dateInput.classList.remove('is-invalid');
                            timeInput.classList.remove('is-invalid');
                        }
                    });
                });

                dateInput.addEventListener('change', function() {
                    const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
                    if (anyChecked && this.value.trim()) {
                        this.classList.remove('is-invalid');
                    } else if (anyChecked && !this.value.trim()) {
                        this.classList.add('is-invalid');
                    }
                });

                timeInput.addEventListener('change', function() {
                    const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
                    if (anyChecked && this.value.trim() && /^([01]\d|2[0-3]):([0-5]\d)$/.test(this
                            .value)) {
                        this.classList.remove('is-invalid');
                    } else if (anyChecked && !this.value.trim()) {
                        this.classList.add('is-invalid');
                    }
                });
            });

            // Initialize Select2 if available
            if (typeof $.fn.select2 !== 'undefined') {
                $('.select2').select2({
                    theme: 'bootstrap-5',
                    placeholder: '--Pilih--'
                });
            }
        });
    </script>
@endpush
