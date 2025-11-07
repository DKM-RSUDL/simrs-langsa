@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .form-label {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #2c3e50;
        }

        .header-asesmen {
            margin-top: 1rem;
            font-size: 1.5rem;
            font-weight: 600;
            color: #097dd6;
            text-align: center;
            margin-bottom: 2rem;
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
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .section-title {
            font-weight: 600;
            color: #097dd6;
            margin-bottom: 1.5rem;
            font-size: 1.1rem;
            border-bottom: 2px solid #097dd6;
            padding-bottom: 0.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control {
            border-radius: 6px;
            border: 1px solid #ced4da;
            padding: 0.75rem;
            font-size: 0.9rem;
        }

        .form-control:focus {
            border-color: #097dd6;
            box-shadow: 0 0 0 0.2rem rgba(9, 125, 214, 0.25);
        }

        .datetime-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .datetime-item label {
            font-weight: 500;
            color: #6c757d;
            font-size: 0.85rem;
        }

        .score-display {
            background-color: #e3f2fd;
            border: 2px solid #097dd6;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            text-align: center;
        }

        .score-number {
            font-size: 2rem;
            font-weight: bold;
            color: #097dd6;
            margin-bottom: 0.5rem;
        }

        .score-category {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .score-category.low-risk {
            color: #28a745;
        }

        .score-category.medium-risk {
            color: #fd7e14;
        }

        .score-category.high-risk {
            color: #dc3545;
        }

        .score-description {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .radio-group {
            background-color: white;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .radio-group .form-label {
            font-weight: 600;
            color: #097dd6;
            margin-bottom: 1rem;
            font-size: 1rem;
            border-bottom: 1px solid #e9ecef;
            padding-bottom: 0.5rem;
        }

        .radio-options {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .radio-item {
            display: flex;
            align-items: flex-start;
            background-color: #f8f9fa;
            padding: 0.75rem;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .radio-item:hover {
            background-color: #e3f2fd;
            border-color: #097dd6;
        }

        .radio-item.selected {
            background-color: #e3f2fd;
            border-color: #097dd6;
            border-width: 2px;
        }

        .radio-item input[type="radio"] {
            margin-right: 0.75rem;
            margin-top: 0.1rem;
            transform: scale(1.3);
            accent-color: #097dd6;
        }

        .radio-item label {
            margin-bottom: 0 !important;
            cursor: pointer;
            font-weight: 500;
            line-height: 1.4;
            flex: 1;
        }

        .radio-value {
            background-color: #097dd6;
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-left: 0.5rem;
            min-width: 30px;
            text-align: center;
        }

        .form-check {
            padding-left: 1.5rem;
        }

        .form-check-input {
            margin-left: -1.5rem;
            transform: scale(1.2);
            accent-color: #097dd6;
        }

        .form-check-label {
            font-weight: 500;
            color: #495057;
            line-height: 1.4;
            margin-bottom: 0;
            cursor: pointer;
        }

        .form-check-input:checked+.form-check-label {
            color: #097dd6;
            font-weight: 600;
        }

        .alert {
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
            border: none;
        }

        .alert-info {
            background-color: #d1ecf1;
            color: #0c5460;
            border-left: 4px solid #17a2b8;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        .ml-3 {
            margin-left: 1rem;
        }

        .mb-2 {
            margin-bottom: 0.5rem;
        }

        .mb-3 {
            margin-bottom: 1rem;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .datetime-group {
                grid-template-columns: 1fr;
            }

            .form-section {
                padding: 1rem;
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
            <x-content-card>
                <x-button-previous />
                @include('components.page-header', [
                    'title' => 'Perbarui Pengkajian Resiko Jatuh - Khusus Lansia (Geriatri)',
                    'description' =>
                        'Perbarui data pengkajian resiko jatuh - geriatri pasien rawat inap dengan mengisi formulir di bawah ini.',
                ])

                <form id="humptyDumptyForm" method="POST"
                    action="{{ route('rawat-inap.resiko-jatuh.geriatri.update', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $dataSkalaGeriatri->id]) }}">
                    @csrf
                    @method('PUT')



                    <!-- Basic Information Section -->
                    <div class="form-section">
                        <h5 class="section-title">Informasi Dasar</h5>

                        <div class="form-group">
                            <label class="form-label">Tanggal dan Jam Implementasi</label>
                            <div class="datetime-group">
                                <div class="datetime-item">
                                    <label>Tanggal</label>
                                    <input type="date" class="form-control" name="tanggal_implementasi"
                                        id="tanggal_implementasi"
                                        value="{{ date('Y-m-d', strtotime($dataSkalaGeriatri->tanggal_implementasi)) }}"
                                        required>
                                </div>
                                <div class="datetime-item">
                                    <label>Jam</label>
                                    <input type="time" class="form-control" name="jam_implementasi" id="jam_implementasi"
                                        value="{{ date('H:i', strtotime($dataSkalaGeriatri->jam_implementasi)) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="shift" class="form-label">Shift</label>
                            <select class="form-control" id="shift" name="shift" required>
                                <option value="">Pilih Shift</option>
                                <option value="pagi" {{ $dataSkalaGeriatri->shift == 'pagi' ? 'selected' : '' }}>
                                    Pagi
                                </option>
                                <option value="siang" {{ $dataSkalaGeriatri->shift == 'siang' ? 'selected' : '' }}>
                                    Siang</option>
                                <option value="malam" {{ $dataSkalaGeriatri->shift == 'malam' ? 'selected' : '' }}>
                                    Malam</option>
                            </select>
                        </div>
                    </div>

                    <!-- Assessment Criteria Section -->
                    <div class="form-section">
                        <h5 class="section-title">Kriteria Penilaian Skala Geriatri</h5>

                        <!-- 1. Riwayat Jatuh -->
                        <div class="form-group">
                            <div class="radio-group">
                                <div class="form-label">1. Riwayat Jatuh</div>

                                <!-- Pertanyaan 1a -->
                                <div
                                    style="margin-bottom: 1rem; padding: 0.5rem; background-color: #f8f9fa; border-radius: 4px;">
                                    <div style="font-weight: 500; margin-bottom: 0.5rem;">Apakah pasien datang
                                        kerumah
                                        sakit karena jatuh?</div>
                                    <div class="radio-options">
                                        <label
                                            class="radio-item {{ $dataSkalaGeriatri->riwayat_jatuh_1a == 6 ? 'selected' : '' }}"
                                            for="riwayat_jatuh_1a_ya">
                                            <input type="radio" id="riwayat_jatuh_1a_ya" name="riwayat_jatuh_1a"
                                                value="6"
                                                {{ $dataSkalaGeriatri->riwayat_jatuh_1a == 6 ? 'checked' : '' }}
                                                class="assessment-field" data-field="riwayat_jatuh_1a">
                                            <span>Ya</span>
                                            <span class="radio-value">6</span>
                                        </label>
                                        <label
                                            class="radio-item {{ $dataSkalaGeriatri->riwayat_jatuh_1a == 0 ? 'selected' : '' }}"
                                            for="riwayat_jatuh_1a_tidak">
                                            <input type="radio" id="riwayat_jatuh_1a_tidak" name="riwayat_jatuh_1a"
                                                value="0"
                                                {{ $dataSkalaGeriatri->riwayat_jatuh_1a == 0 ? 'checked' : '' }}
                                                class="assessment-field" data-field="riwayat_jatuh_1a">
                                            <span>Tidak</span>
                                            <span class="radio-value">0</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Pertanyaan 1b -->
                                <div
                                    style="margin-bottom: 1rem; padding: 0.5rem; background-color: #f8f9fa; border-radius: 4px;">
                                    <div style="font-weight: 500; margin-bottom: 0.5rem;">Jika tidak, apakah pasien
                                        mengalami jatuh dalam 2 bulan terakhir ini?</div>
                                    <div class="radio-options">
                                        <label
                                            class="radio-item {{ $dataSkalaGeriatri->riwayat_jatuh_1b == 6 ? 'selected' : '' }}"
                                            for="riwayat_jatuh_1b_ya">
                                            <input type="radio" id="riwayat_jatuh_1b_ya" name="riwayat_jatuh_1b"
                                                value="6"
                                                {{ $dataSkalaGeriatri->riwayat_jatuh_1b == 6 ? 'checked' : '' }}
                                                class="assessment-field" data-field="riwayat_jatuh_1b">
                                            <span>Ya</span>
                                            <span class="radio-value">6</span>
                                        </label>
                                        <label
                                            class="radio-item {{ $dataSkalaGeriatri->riwayat_jatuh_1b == 0 ? 'selected' : '' }}"
                                            for="riwayat_jatuh_1b_tidak">
                                            <input type="radio" id="riwayat_jatuh_1b_tidak" name="riwayat_jatuh_1b"
                                                value="0"
                                                {{ $dataSkalaGeriatri->riwayat_jatuh_1b == 0 ? 'checked' : '' }}
                                                class="assessment-field" data-field="riwayat_jatuh_1b">
                                            <span>Tidak</span>
                                            <span class="radio-value">0</span>
                                        </label>
                                    </div>
                                </div>
                                <!-- Keterangan -->
                                <div
                                    style="margin-top: 1rem; padding: 0.75rem; background-color: #e3f2fd; border-left: 4px solid #097dd6; border-radius: 4px;">
                                    <div style="font-weight: 400; color: #000000be; margin-bottom: 0.5rem;">Salah
                                        Satu
                                        jawaban Ya = 6</div>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Status Mental -->
                        <div class="form-group">
                            <div class="radio-group">
                                <div class="form-label">2. Status Mental</div>

                                <!-- Pertanyaan 2a -->
                                <div
                                    style="margin-bottom: 1rem; padding: 0.5rem; background-color: #f8f9fa; border-radius: 4px;">
                                    <div style="font-weight: 500; margin-bottom: 0.5rem;">Apakah pasien delirium?
                                        (Tidak
                                        dapat membuat keputusan, pola pikir tidak terorganisir, gangguan daya ingat)
                                    </div>
                                    <div class="radio-options">
                                        <label
                                            class="radio-item {{ $dataSkalaGeriatri->status_mental_2a == 14 ? 'selected' : '' }}"
                                            for="status_mental_2a_ya">
                                            <input type="radio" id="status_mental_2a_ya" name="status_mental_2a"
                                                value="14"
                                                {{ $dataSkalaGeriatri->status_mental_2a == 14 ? 'checked' : '' }}
                                                class="assessment-field" data-field="status_mental_2a">
                                            <span>Ya</span>
                                            <span class="radio-value">14</span>
                                        </label>
                                        <label
                                            class="radio-item {{ $dataSkalaGeriatri->status_mental_2a == 0 ? 'selected' : '' }}"
                                            for="status_mental_2a_tidak">
                                            <input type="radio" id="status_mental_2a_tidak" name="status_mental_2a"
                                                value="0"
                                                {{ $dataSkalaGeriatri->status_mental_2a == 0 ? 'checked' : '' }}
                                                class="assessment-field" data-field="status_mental_2a">
                                            <span>Tidak</span>
                                            <span class="radio-value">0</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Pertanyaan 2b -->
                                <div
                                    style="margin-bottom: 1rem; padding: 0.5rem; background-color: #f8f9fa; border-radius: 4px;">
                                    <div style="font-weight: 500; margin-bottom: 0.5rem;">Apakah pasien
                                        disorientasi?
                                        (salah menyebutkan waktu, tempat atau orang)</div>
                                    <div class="radio-options">
                                        <label
                                            class="radio-item {{ $dataSkalaGeriatri->status_mental_2b == 14 ? 'selected' : '' }}"
                                            for="status_mental_2b_ya">
                                            <input type="radio" id="status_mental_2b_ya" name="status_mental_2b"
                                                value="14"
                                                {{ $dataSkalaGeriatri->status_mental_2b == 14 ? 'checked' : '' }}
                                                class="assessment-field" data-field="status_mental_2b">
                                            <span>Ya</span>
                                            <span class="radio-value">14</span>
                                        </label>
                                        <label
                                            class="radio-item {{ $dataSkalaGeriatri->status_mental_2b == 0 ? 'selected' : '' }}"
                                            for="status_mental_2b_tidak">
                                            <input type="radio" id="status_mental_2b_tidak" name="status_mental_2b"
                                                value="0"
                                                {{ $dataSkalaGeriatri->status_mental_2b == 0 ? 'checked' : '' }}
                                                class="assessment-field" data-field="status_mental_2b">
                                            <span>Tidak</span>
                                            <span class="radio-value">0</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Pertanyaan 2c -->
                                <div
                                    style="margin-bottom: 1rem; padding: 0.5rem; background-color: #f8f9fa; border-radius: 4px;">
                                    <div style="font-weight: 500; margin-bottom: 0.5rem;">Apakah pasien mengalami
                                        agitasi? (ketakutan, gelisah, tidak cemas)</div>
                                    <div class="radio-options">
                                        <label
                                            class="radio-item {{ $dataSkalaGeriatri->status_mental_2c == 14 ? 'selected' : '' }}"
                                            for="status_mental_2c_ya">
                                            <input type="radio" id="status_mental_2c_ya" name="status_mental_2c"
                                                value="14"
                                                {{ $dataSkalaGeriatri->status_mental_2c == 14 ? 'checked' : '' }}
                                                class="assessment-field" data-field="status_mental_2c">
                                            <span>Ya</span>
                                            <span class="radio-value">14</span>
                                        </label>
                                        <label
                                            class="radio-item {{ $dataSkalaGeriatri->status_mental_2c == 0 ? 'selected' : '' }}"
                                            for="status_mental_2c_tidak">
                                            <input type="radio" id="status_mental_2c_tidak" name="status_mental_2c"
                                                value="0"
                                                {{ $dataSkalaGeriatri->status_mental_2c == 0 ? 'checked' : '' }}
                                                class="assessment-field" data-field="status_mental_2c">
                                            <span>Tidak</span>
                                            <span class="radio-value">0</span>
                                        </label>
                                    </div>
                                </div>
                                <!-- Keterangan -->
                                <div
                                    style="margin-top: 1rem; padding: 0.75rem; background-color: #e3f2fd; border-left: 4px solid #097dd6; border-radius: 4px;">
                                    <div style="font-weight: 400; color: #000000be; margin-bottom: 0.5rem;">Salah
                                        Satu
                                        jawaban Ya = 14</div>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Penglihatan -->
                        <div class="form-group">
                            <div class="radio-group">
                                <div class="form-label">3. Penglihatan</div>

                                <!-- Pertanyaan 3a -->
                                <div
                                    style="margin-bottom: 1rem; padding: 0.5rem; background-color: #f8f9fa; border-radius: 4px;">
                                    <div style="font-weight: 500; margin-bottom: 0.5rem;">Apakah pasien memakai
                                        kacamata?</div>
                                    <div class="radio-options">
                                        <label
                                            class="radio-item {{ $dataSkalaGeriatri->penglihatan_3a == 1 ? 'selected' : '' }}"
                                            for="penglihatan_3a_ya">
                                            <input type="radio" id="penglihatan_3a_ya" name="penglihatan_3a"
                                                value="1"
                                                {{ $dataSkalaGeriatri->penglihatan_3a == 1 ? 'checked' : '' }}
                                                class="assessment-field" data-field="penglihatan_3a">
                                            <span>Ya</span>
                                            <span class="radio-value">1</span>
                                        </label>
                                        <label
                                            class="radio-item {{ $dataSkalaGeriatri->penglihatan_3a == 0 ? 'selected' : '' }}"
                                            for="penglihatan_3a_tidak">
                                            <input type="radio" id="penglihatan_3a_tidak" name="penglihatan_3a"
                                                value="0"
                                                {{ $dataSkalaGeriatri->penglihatan_3a == 0 ? 'checked' : '' }}
                                                class="assessment-field" data-field="penglihatan_3a">
                                            <span>Tidak</span>
                                            <span class="radio-value">0</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Pertanyaan 3b -->
                                <div
                                    style="margin-bottom: 1rem; padding: 0.5rem; background-color: #f8f9fa; border-radius: 4px;">
                                    <div style="font-weight: 500; margin-bottom: 0.5rem;">Apakah pasien mengeluh
                                        adanya penglihatan buram?</div>
                                    <div class="radio-options">
                                        <label
                                            class="radio-item {{ $dataSkalaGeriatri->penglihatan_3b == 1 ? 'selected' : '' }}"
                                            for="penglihatan_3b_ya">
                                            <input type="radio" id="penglihatan_3b_ya" name="penglihatan_3b"
                                                value="1"
                                                {{ $dataSkalaGeriatri->penglihatan_3b == 1 ? 'checked' : '' }}
                                                class="assessment-field" data-field="penglihatan_3b">
                                            <span>Ya</span>
                                            <span class="radio-value">1</span>
                                        </label>
                                        <label
                                            class="radio-item {{ $dataSkalaGeriatri->penglihatan_3b == 0 ? 'selected' : '' }}"
                                            for="penglihatan_3b_tidak">
                                            <input type="radio" id="penglihatan_3b_tidak" name="penglihatan_3b"
                                                value="0"
                                                {{ $dataSkalaGeriatri->penglihatan_3b == 0 ? 'checked' : '' }}
                                                class="assessment-field" data-field="penglihatan_3b">
                                            <span>Tidak</span>
                                            <span class="radio-value">0</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Pertanyaan 3c -->
                                <div
                                    style="margin-bottom: 1rem; padding: 0.5rem; background-color: #f8f9fa; border-radius: 4px;">
                                    <div style="font-weight: 500; margin-bottom: 0.5rem;">Apakah pasien mempunyai
                                        Glaukoma/ Katarak/ degenerasi makula?</div>
                                    <div class="radio-options">
                                        <label
                                            class="radio-item {{ $dataSkalaGeriatri->penglihatan_3c == 1 ? 'selected' : '' }}"
                                            for="penglihatan_3c_ya">
                                            <input type="radio" id="penglihatan_3c_ya" name="penglihatan_3c"
                                                value="1"
                                                {{ $dataSkalaGeriatri->penglihatan_3c == 1 ? 'checked' : '' }}
                                                class="assessment-field" data-field="penglihatan_3c">
                                            <span>Ya</span>
                                            <span class="radio-value">1</span>
                                        </label>
                                        <label
                                            class="radio-item {{ $dataSkalaGeriatri->penglihatan_3c == 0 ? 'selected' : '' }}"
                                            for="penglihatan_3c_tidak">
                                            <input type="radio" id="penglihatan_3c_tidak" name="penglihatan_3c"
                                                value="0"
                                                {{ $dataSkalaGeriatri->penglihatan_3c == 0 ? 'checked' : '' }}
                                                class="assessment-field" data-field="penglihatan_3c">
                                            <span>Tidak</span>
                                            <span class="radio-value">0</span>
                                        </label>
                                    </div>
                                </div>
                                <!-- Keterangan -->
                                <div
                                    style="margin-top: 1rem; padding: 0.75rem; background-color: #e3f2fd; border-left: 4px solid #097dd6; border-radius: 4px;">
                                    <div style="font-weight: 400; color: #000000be; margin-bottom: 0.5rem;">Salah
                                        Satu
                                        jawaban Ya = 1</div>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Kebiasaan Berkemih -->
                        <div class="form-group">
                            <div class="radio-group">
                                <div class="form-label">4. Kebiasaan Berkemih</div>

                                <!-- Pertanyaan 4a -->
                                <div
                                    style="margin-bottom: 1rem; padding: 0.5rem; background-color: #f8f9fa; border-radius: 4px;">
                                    <div style="font-weight: 500; margin-bottom: 0.5rem;">Apakah terdapat perubahan
                                        perilaku berkemih? (frekuensi, urgensi, inkontinensia, nokturia)</div>
                                    <div class="radio-options">
                                        <label
                                            class="radio-item {{ $dataSkalaGeriatri->kebiasaan_berkemih_4a == 2 ? 'selected' : '' }}"
                                            for="kebiasaan_berkemih_4a_ya">
                                            <input type="radio" id="kebiasaan_berkemih_4a_ya"
                                                name="kebiasaan_berkemih_4a" value="2"
                                                {{ $dataSkalaGeriatri->kebiasaan_berkemih_4a == 2 ? 'checked' : '' }}
                                                class="assessment-field" data-field="kebiasaan_berkemih_4a">
                                            <span>Ya</span>
                                            <span class="radio-value">2</span>
                                        </label>
                                        <label
                                            class="radio-item {{ $dataSkalaGeriatri->kebiasaan_berkemih_4a == 0 ? 'selected' : '' }}"
                                            for="kebiasaan_berkemih_4a_tidak">
                                            <input type="radio" id="kebiasaan_berkemih_4a_tidak"
                                                name="kebiasaan_berkemih_4a" value="0"
                                                {{ $dataSkalaGeriatri->kebiasaan_berkemih_4a == 0 ? 'checked' : '' }}
                                                class="assessment-field" data-field="kebiasaan_berkemih_4a">
                                            <span>Tidak</span>
                                            <span class="radio-value">0</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 5. Transfer-->
                        <div class="form-group">
                            <div class="radio-group">
                                <div class="form-label">5. Transfer (dari tempat tidur ke kursi dan kembali lagi ke
                                    tempat tidur)</div>

                                <div class="radio-options">
                                    <label class="radio-item {{ $dataSkalaGeriatri->transfer == 0 ? 'selected' : '' }}"
                                        for="transfer_5a">
                                        <input type="radio" id="transfer_5a" name="transfer" value="0"
                                            {{ $dataSkalaGeriatri->transfer == 0 ? 'checked' : '' }}
                                            class="assessment-field" data-field="transfer">
                                        <span>Mandiri (boleh memakai alat bantu jalan)</span>
                                        <span class="radio-value">0</span>
                                    </label>
                                    <label class="radio-item {{ $dataSkalaGeriatri->transfer == 1 ? 'selected' : '' }}"
                                        for="transfer_5b">
                                        <input type="radio" id="transfer_5b" name="transfer" value="1"
                                            {{ $dataSkalaGeriatri->transfer == 1 ? 'checked' : '' }}
                                            class="assessment-field" data-field="transfer">
                                        <span>Memerlukan sedikit bantuan (1 orang) / dalam pengawasan</span>
                                        <span class="radio-value">1</span>
                                    </label>
                                    <label class="radio-item {{ $dataSkalaGeriatri->transfer == 2 ? 'selected' : '' }}"
                                        for="transfer_5c">
                                        <input type="radio" id="transfer_5c" name="transfer" value="2"
                                            {{ $dataSkalaGeriatri->transfer == 2 ? 'checked' : '' }}
                                            class="assessment-field" data-field="transfer">
                                        <span>Memerlukan bantuan yang nyata (2 orang)</span>
                                        <span class="radio-value">2</span>
                                    </label>
                                    <label class="radio-item {{ $dataSkalaGeriatri->transfer == 3 ? 'selected' : '' }}"
                                        for="transfer_5d">
                                        <input type="radio" id="transfer_5d" name="transfer" value="3"
                                            {{ $dataSkalaGeriatri->transfer == 3 ? 'checked' : '' }}
                                            class="assessment-field" data-field="transfer">
                                        <span>Tidak dapat duduk dengan seimbang, perlu bantuan total</span>
                                        <span class="radio-value">3</span>
                                    </label>
                                </div>

                                <!-- Keterangan Jumlah Nilai Transfer -->
                                <div
                                    style="margin-top: 1rem; padding: 0.75rem; background-color: #e3f2fd; border-left: 4px solid #097dd6; border-radius: 4px;">
                                    <div style="font-weight: 600; color: #097dd6; margin-bottom: 0.5rem;">Jumlah
                                        nilai
                                        transfer dan mobilitas:</div>
                                    <div style="font-size: 0.9rem; color: #495057;">
                                        <div>• Jika nilai total 0 s/d 3 maka skor = 0.</div>
                                        <div>• Jika nilai total 4 s/d 6, maka skor = 7</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 6. Mobilitas -->
                        <div class="form-group">
                            <div class="radio-group">
                                <div class="form-label">6. Mobilitas</div>

                                <div class="radio-options">
                                    <label class="radio-item {{ $dataSkalaGeriatri->mobilitas == 0 ? 'selected' : '' }}"
                                        for="mobilitas_6a">
                                        <input type="radio" id="mobilitas_6a" name="mobilitas" value="0"
                                            {{ $dataSkalaGeriatri->mobilitas == 0 ? 'checked' : '' }}
                                            class="assessment-field" data-field="mobilitas">
                                        <span>Mandiri (boleh menggunakan alat bantu jalan)</span>
                                        <span class="radio-value">0</span>
                                    </label>
                                    <label class="radio-item {{ $dataSkalaGeriatri->mobilitas == 1 ? 'selected' : '' }}"
                                        for="mobilitas_6b">
                                        <input type="radio" id="mobilitas_6b" name="mobilitas" value="1"
                                            {{ $dataSkalaGeriatri->mobilitas == 1 ? 'checked' : '' }}
                                            class="assessment-field" data-field="mobilitas">
                                        <span>Berjalan dengan bantuan 1 orang (verbal / fisik) menggunakan kursi
                                            roda</span>
                                        <span class="radio-value">1</span>
                                    </label>
                                    <label class="radio-item {{ $dataSkalaGeriatri->mobilitas == 2 ? 'selected' : '' }}"
                                        for="mobilitas_6c">
                                        <input type="radio" id="mobilitas_6c" name="mobilitas" value="2"
                                            {{ $dataSkalaGeriatri->mobilitas == 2 ? 'checked' : '' }}
                                            class="assessment-field" data-field="mobilitas">
                                        <span>Menggunakan kursi roda</span>
                                        <span class="radio-value">2</span>
                                    </label>
                                    <label class="radio-item {{ $dataSkalaGeriatri->mobilitas == 3 ? 'selected' : '' }}"
                                        for="mobilitas_6d">
                                        <input type="radio" id="mobilitas_6d" name="mobilitas" value="3"
                                            {{ $dataSkalaGeriatri->mobilitas == 3 ? 'checked' : '' }}
                                            class="assessment-field" data-field="mobilitas">
                                        <span>Imobilisasi</span>
                                        <span class="radio-value">3</span>
                                    </label>
                                </div>
                                <!-- Keterangan -->
                                <div
                                    style="margin-top: 1rem; padding: 0.75rem; background-color: #e3f2fd; border-left: 4px solid #097dd6; border-radius: 4px;">
                                    <div style="font-weight: 600; color: #097dd6; margin-bottom: 0.5rem;">Jumlah
                                        nilai
                                        transfer dan mobilitas:</div>
                                    <div style="font-size: 0.9rem; color: #495057;">
                                        <div>• Jika nilai total 0 s/d 3 maka skor = 0.</div>
                                        <div>• Jika nilai total 4 s/d 6, maka skor = 7</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Score Display Section -->
                    <div class="score-display" id="scoreDisplay">
                        <div class="score-number" id="totalScore">{{ $dataSkalaGeriatri->total_skor }}</div>
                        <div class="score-category" id="riskCategory">{{ $dataSkalaGeriatri->kategori_risiko }}
                        </div>
                        <div class="score-description" id="riskDescription">Kategori risiko saat ini</div>
                    </div>

                    <!-- Intervention Section -->
                    <div class="form-section" id="interventionSection">
                        <h5 class="section-title">Intervensi Pencegahan Jatuh</h5>

                        <!-- Intervensi untuk Risiko Rendah -->
                        <div id="lowRiskInterventions"
                            style="{{ $dataSkalaGeriatri->kategori_risiko == 'Risiko Rendah' ? 'display: block;' : 'display: none;' }}">
                            <div class="alert alert-info mb-3">
                                <i class="ti-info-circle"></i> <strong>Intervensi Jatuh Risiko Rendah /
                                    Standar</strong>
                            </div>

                            <div class="form-group">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="rr_observasi_ambulasi"
                                        name="rr_observasi_ambulasi" value="1"
                                        {{ $dataSkalaGeriatri->rr_observasi_ambulasi ? 'checked' : '' }}>
                                    <label class="form-check-label" for="rr_observasi_ambulasi">
                                        Tingkatkan observasi bantuan yang sesuai saat ambulasi
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Orientasikan pasien terhadap lingkungan dan rutinitas
                                    RS:</label>
                                <div class="ml-3">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="rr_orientasi_kamar_mandi"
                                            name="rr_orientasi_kamar_mandi" value="1"
                                            {{ $dataSkalaGeriatri->rr_orientasi_kamar_mandi ? 'checked' : '' }}>
                                        <label class="form-check-label" for="rr_orientasi_kamar_mandi">
                                            Tunjukkan lokasi kamar mandi
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="rr_orientasi_bertahap"
                                            name="rr_orientasi_bertahap" value="1"
                                            {{ $dataSkalaGeriatri->rr_orientasi_bertahap ? 'checked' : '' }}>
                                        <label class="form-check-label" for="rr_orientasi_bertahap">
                                            Jika pasien linglung, orientasi dilaksanakan bertahap
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="rr_tempatkan_bel"
                                            name="rr_tempatkan_bel" value="1"
                                            {{ $dataSkalaGeriatri->rr_tempatkan_bel ? 'checked' : '' }}>
                                        <label class="form-check-label" for="rr_tempatkan_bel">
                                            Tempatkan bel ditempat yang mudah dicapai
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="rr_instruksi_bantuan"
                                            name="rr_instruksi_bantuan" value="1"
                                            {{ $dataSkalaGeriatri->rr_instruksi_bantuan ? 'checked' : '' }}>
                                        <label class="form-check-label" for="rr_instruksi_bantuan">
                                            Instruksikan meminta bantuan perawat sebelum turun dari tempat tidur
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="rr_pagar_pengaman"
                                        name="rr_pagar_pengaman" value="1"
                                        {{ $dataSkalaGeriatri->rr_pagar_pengaman ? 'checked' : '' }}>
                                    <label class="form-check-label" for="rr_pagar_pengaman">
                                        Pagar pengaman tempat tidur dinaikkan
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="rr_tempat_tidur_rendah"
                                        name="rr_tempat_tidur_rendah" value="1"
                                        {{ $dataSkalaGeriatri->rr_tempat_tidur_rendah ? 'checked' : '' }}>
                                    <label class="form-check-label" for="rr_tempat_tidur_rendah">
                                        Tempat tidur dalam posisi rendah dan terkunci
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="rr_edukasi_perilaku"
                                        name="rr_edukasi_perilaku" value="1"
                                        {{ $dataSkalaGeriatri->rr_edukasi_perilaku ? 'checked' : '' }}>
                                    <label class="form-check-label" for="rr_edukasi_perilaku">
                                        Edukasi perilaku yang lebih aman saat jatuh atau transfer
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="rr_monitor_berkala"
                                        name="rr_monitor_berkala" value="1"
                                        {{ $dataSkalaGeriatri->rr_monitor_berkala ? 'checked' : '' }}>
                                    <label class="form-check-label" for="rr_monitor_berkala">
                                        Monitor kebutuhan pasien secara berkala (minimalnya tiap 2 jam)
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="rr_anjuran_kaus_kaki"
                                        name="rr_anjuran_kaus_kaki" value="1"
                                        {{ $dataSkalaGeriatri->rr_anjuran_kaus_kaki ? 'checked' : '' }}>
                                    <label class="form-check-label" for="rr_anjuran_kaus_kaki">
                                        Anjurkan pasien tidak menggunakan kaus kaki atau sepatu yang licin
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="rr_lantai_antislip"
                                        name="rr_lantai_antislip" value="1"
                                        {{ $dataSkalaGeriatri->rr_lantai_antislip ? 'checked' : '' }}>
                                    <label class="form-check-label" for="rr_lantai_antislip">
                                        Lantai kamar mandi dengan karpet antislip, tidak licin
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Intervensi untuk Risiko Sedang -->
                        <div id="mediumRiskInterventions"
                            style="{{ $dataSkalaGeriatri->kategori_risiko == 'Risiko Sedang' ? 'display: block;' : 'display: none;' }}">
                            <div class="alert"
                                style="background-color: #fff3cd; color: #856404; border-left: 4px solid #fd7e14;">
                                <i class="ti-alert-triangle"></i> <strong>Intervensi Jatuh Risiko Sedang</strong>
                            </div>

                            <div class="form-group">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="rs_semua_intervensi_rendah"
                                        name="rs_semua_intervensi_rendah" value="1"
                                        {{ $dataSkalaGeriatri->rs_semua_intervensi_rendah ? 'checked' : '' }}>
                                    <label class="form-check-label" for="rs_semua_intervensi_rendah">
                                        Lakukan SEMUA intervensi jatuh risiko rendah / standar
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="rs_gelang_kuning"
                                        name="rs_gelang_kuning" value="1"
                                        {{ $dataSkalaGeriatri->rs_gelang_kuning ? 'checked' : '' }}>
                                    <label class="form-check-label" for="rs_gelang_kuning">
                                        Pakailah gelang risiko jatuh berwarna kuning
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="rs_pasang_gambar"
                                        name="rs_pasang_gambar" value="1"
                                        {{ $dataSkalaGeriatri->rs_pasang_gambar ? 'checked' : '' }}>
                                    <label class="form-check-label" for="rs_pasang_gambar">
                                        Pasang gambar risiko jatuh diatas tempat tidur pasien dan pada pintu kamar
                                        pasien
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="rs_tanda_daftar_nama"
                                        name="rs_tanda_daftar_nama" value="1"
                                        {{ $dataSkalaGeriatri->rs_tanda_daftar_nama ? 'checked' : '' }}>
                                    <label class="form-check-label" for="rs_tanda_daftar_nama">
                                        Tempatkan tanda resiko pasien jatuh pada daftar nama pasien (warna kuning)
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="rs_pertimbangkan_obat"
                                        name="rs_pertimbangkan_obat" value="1"
                                        {{ $dataSkalaGeriatri->rs_pertimbangkan_obat ? 'checked' : '' }}>
                                    <label class="form-check-label" for="rs_pertimbangkan_obat">
                                        Pertimbangkan riwayat obat-obatan dan suplemen untuk mengevaluasi pengobatan
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="rs_alat_bantu_jalan"
                                        name="rs_alat_bantu_jalan" value="1"
                                        {{ $dataSkalaGeriatri->rs_alat_bantu_jalan ? 'checked' : '' }}>
                                    <label class="form-check-label" for="rs_alat_bantu_jalan">
                                        Gunakan alat bantu jalan (walker, handrail)
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Intervensi untuk Risiko Tinggi -->
                        <div id="highRiskInterventions"
                            style="{{ $dataSkalaGeriatri->kategori_risiko == 'Risiko Tinggi' ? 'display: block;' : 'display: none;' }}">
                            <div class="alert alert-danger mb-3">
                                <i class="ti-alert-triangle"></i> <strong>Intervensi Jatuh Risiko Tinggi</strong>
                            </div>

                            <div class="form-group">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox"
                                        id="rt_semua_intervensi_rendah_sedang" name="rt_semua_intervensi_rendah_sedang"
                                        value="1"
                                        {{ $dataSkalaGeriatri->rt_semua_intervensi_rendah_sedang ? 'checked' : '' }}>
                                    <label class="form-check-label" for="rt_semua_intervensi_rendah_sedang">
                                        Lakukan SEMUA intervensi jatuh risiko rendah / standar dan risiko sedang
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="rt_jangan_tinggalkan"
                                        name="rt_jangan_tinggalkan" value="1"
                                        {{ $dataSkalaGeriatri->rt_jangan_tinggalkan ? 'checked' : '' }}>
                                    <label class="form-check-label" for="rt_jangan_tinggalkan">
                                        Jangan tinggalkan pasien saat di ruangan diagnostic atau tindakan
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="rt_dekat_nurse_station"
                                        name="rt_dekat_nurse_station" value="1"
                                        {{ $dataSkalaGeriatri->rt_dekat_nurse_station ? 'checked' : '' }}>
                                    <label class="form-check-label" for="rt_dekat_nurse_station">
                                        Penempatan pasien dekat nurse station untuk memudahkan observasi (24-48 jam)
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-end">
                        <x-button-submit id="simpan">Perbarui</x-button-submit>
                    </div>
                </form>
            </x-content-card>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            let lastChecked = {}; // Untuk menyimpan radio button yang terakhir diklik

            // Set initial state - populate lastChecked dengan data yang sudah ada
            $('.assessment-field:checked').each(function() {
                lastChecked[this.name] = this;
                $(this).closest('.radio-item').addClass('selected');
            });

            // Calculate initial score
            calculateScore();

            // Initialize checkbox styling for pre-checked items
            $('.form-check-input:checked').each(function() {
                $(this).next('.form-check-label').addClass('text-primary');
            });

            // Function to calculate total score
            function calculateScore() {
                let totalScore = 0;
                let filledCount = 0;

                // Hitung skor untuk setiap kategori
                const categories = [
                    'riwayat_jatuh_1a', 'riwayat_jatuh_1b',
                    'status_mental_2a', 'status_mental_2b', 'status_mental_2c',
                    'penglihatan_3a', 'penglihatan_3b', 'penglihatan_3c',
                    'kebiasaan_berkemih_4a',
                    'transfer', 'mobilitas'
                ];

                let categoryScores = {};

                // Ambil nilai dari setiap field yang terisi
                categories.forEach(function(category) {
                    const checkedInput = $('input[name="' + category + '"]:checked');
                    if (checkedInput.length > 0) {
                        categoryScores[category] = parseInt(checkedInput.val());
                        filledCount++;
                    }
                });

                // Kalkulasi skor khusus
                // 1. Riwayat Jatuh - jika salah satu atau kedua "Ya" = 6, jika kedua "Tidak" = 0
                let riwayatJatuhScore = 0;
                const riwayat1a = categoryScores['riwayat_jatuh_1a'];
                const riwayat1b = categoryScores['riwayat_jatuh_1b'];

                if ((riwayat1a !== undefined && riwayat1a === 6) || (riwayat1b !== undefined && riwayat1b === 6)) {
                    riwayatJatuhScore = 6;
                } else if (riwayat1a !== undefined && riwayat1b !== undefined) {
                    riwayatJatuhScore = 0;
                }
                totalScore += riwayatJatuhScore;

                // 2. Status Mental - jika salah satu atau lebih "Ya" = 14, jika semua "Tidak" = 0
                let statusMentalScore = 0;
                const mental2a = categoryScores['status_mental_2a'];
                const mental2b = categoryScores['status_mental_2b'];
                const mental2c = categoryScores['status_mental_2c'];

                if ((mental2a !== undefined && mental2a === 14) ||
                    (mental2b !== undefined && mental2b === 14) ||
                    (mental2c !== undefined && mental2c === 14)) {
                    statusMentalScore = 14;
                } else if (mental2a !== undefined && mental2b !== undefined && mental2c !== undefined) {
                    statusMentalScore = 0;
                }
                totalScore += statusMentalScore;

                // 3. Penglihatan - jika salah satu atau lebih "Ya" = 1, jika semua "Tidak" = 0
                let penglihatanScore = 0;
                const penglihatan3a = categoryScores['penglihatan_3a'];
                const penglihatan3b = categoryScores['penglihatan_3b'];
                const penglihatan3c = categoryScores['penglihatan_3c'];

                if ((penglihatan3a !== undefined && penglihatan3a === 1) ||
                    (penglihatan3b !== undefined && penglihatan3b === 1) ||
                    (penglihatan3c !== undefined && penglihatan3c === 1)) {
                    penglihatanScore = 1;
                } else if (penglihatan3a !== undefined && penglihatan3b !== undefined && penglihatan3c !==
                    undefined) {
                    penglihatanScore = 0;
                }
                totalScore += penglihatanScore;

                // 4. Kebiasaan Berkemih
                totalScore += categoryScores['kebiasaan_berkemih_4a'] || 0;

                // 5. Transfer + Mobilitas - logika khusus
                let transferMobilitasScore = 0;
                let transferValue = categoryScores['transfer'] || 0;
                let mobilitasValue = categoryScores['mobilitas'] || 0;
                let totalTransferMobilitas = transferValue + mobilitasValue;

                if (totalTransferMobilitas >= 0 && totalTransferMobilitas <= 3) {
                    transferMobilitasScore = 0;
                } else if (totalTransferMobilitas >= 4 && totalTransferMobilitas <= 6) {
                    transferMobilitasScore = 7;
                }
                totalScore += transferMobilitasScore;

                if (filledCount > 0) {
                    updateScoreDisplay(totalScore, filledCount, categories.length);
                } else {
                    $('#scoreDisplay').hide();
                    $('#interventionSection').hide();
                }
            }

            // Function to update score display
            function updateScoreDisplay(score, filledCount, totalFields) {
                $('#totalScore').text(score);
                $('#scoreDisplay').show();

                $('#interventionSection').hide();
                $('#lowRiskInterventions').hide();
                $('#mediumRiskInterventions').hide();
                $('#highRiskInterventions').hide();

                if (filledCount < totalFields) {
                    $('#riskCategory').text('Skor Sementara').removeClass('low-risk medium-risk high-risk');
                    $('#riskDescription').text(
                        `Skor saat ini: ${score} (${filledCount}/${totalFields} kriteria terisi)`);
                } else {
                    if (score >= 0 && score <= 5) {
                        $('#riskCategory').text('Risiko Rendah').removeClass('medium-risk high-risk').addClass(
                            'low-risk');
                        $('#riskDescription').text('Skor 0-5: Pasien memiliki risiko jatuh rendah');
                        $('#interventionSection').show();
                        $('#lowRiskInterventions').show();
                    } else if (score >= 6 && score <= 16) {
                        $('#riskCategory').text('Risiko Sedang').removeClass('low-risk high-risk').addClass(
                            'medium-risk');
                        $('#riskDescription').text('Skor 6-16: Pasien memiliki risiko jatuh sedang');
                        $('#interventionSection').show();
                        $('#mediumRiskInterventions').show();
                    } else if (score >= 17 && score <= 30) {
                        $('#riskCategory').text('Risiko Tinggi').removeClass('low-risk medium-risk').addClass(
                            'high-risk');
                        $('#riskDescription').text('Skor 17-30: Pasien memiliki risiko jatuh tinggi');
                        $('#interventionSection').show();
                        $('#highRiskInterventions').show();
                    } else {
                        $('#riskCategory').text('Skor Tidak Valid').removeClass('low-risk medium-risk high-risk');
                        $('#riskDescription').text('Skor di luar rentang yang valid');
                    }
                }
            }

            // Function untuk mengecek duplikasi (exclude current record)
            function checkDuplicateDateTime() {
                const tanggal = $('#tanggal_implementasi').val();
                const shift = $('#shift').val();
                const currentId = '{{ $dataSkalaGeriatri->id }}';

                if (tanggal && shift) {
                    $.ajax({
                        url: "{{ route('rawat-inap.resiko-jatuh.geriatri.check-duplicate', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}",
                        method: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            tanggal_implementasi: tanggal,
                            shift: shift,
                            exclude_id: currentId
                        },
                        success: function(response) {
                            if (response.exists) {
                                showDuplicateWarning(true);
                                $('#simpan').prop('disabled', true);
                            } else {
                                showDuplicateWarning(false);
                                $('#simpan').prop('disabled', false);
                            }
                        },
                        error: function() {
                            showDuplicateWarning(false);
                            $('#simpan').prop('disabled', false);
                        }
                    });
                } else {
                    showDuplicateWarning(false);
                    $('#simpan').prop('disabled', false);
                }
            }

            // Function untuk menampilkan/menyembunyikan warning
            function showDuplicateWarning(show) {
                if (show) {
                    if ($('#duplicate-warning').length === 0) {
                        const warningHtml = `
                            <div id="duplicate-warning" class="alert alert-warning mt-2" style="border-left: 4px solid #ffc107;">
                                <i class="ti-alert-triangle"></i>
                                <strong>Peringatan:</strong> Data dengan tanggal dan shift ini sudah ada!
                            </div>
                        `;
                        $('#shift').closest('.form-group').after(warningHtml);
                    }
                    $('#duplicate-warning').show();
                } else {
                    $('#duplicate-warning').hide();
                }
            }

            // ======= HANYA INI YANG PERLU UNTUK RADIO BUTTON =======
            // Event handler untuk fitur uncheck pada radio button
            $('.assessment-field').on('click', function() {
                const groupName = this.name;

                // Jika radio yang sama diklik lagi, uncheck
                if (lastChecked[groupName] === this && this.checked) {
                    this.checked = false;
                    lastChecked[groupName] = null;
                } else {
                    lastChecked[groupName] = this;
                }

                // Update visual selected state
                $('.radio-item').removeClass('selected');
                $('.assessment-field:checked').each(function() {
                    $(this).closest('.radio-item').addClass('selected');
                });

                // Calculate score
                calculateScore();
            });
            // ======= AKHIR RADIO BUTTON HANDLER =======

            // Event listener untuk checkbox styling
            $('.form-check-input').on('change', function() {
                if ($(this).is(':checked')) {
                    $(this).next('.form-check-label').addClass('text-primary');
                } else {
                    $(this).next('.form-check-label').removeClass('text-primary');
                }
            });

            // Form validation
            $('#humptyDumptyForm').on('submit', function(e) {
                let isValid = true;
                let errorMessage = '';

                const requiredFields = [{
                        element: $('#tanggal_implementasi'),
                        name: 'Tanggal Implementasi'
                    },
                    {
                        element: $('#jam_implementasi'),
                        name: 'Jam Implementasi'
                    },
                    {
                        element: $('#shift'),
                        name: 'Shift'
                    }
                ];

                requiredFields.forEach(function(field) {
                    if (!field.element.val()) {
                        isValid = false;
                        field.element.addClass('is-invalid');
                        errorMessage += '- ' + field.name + '\n';
                    } else {
                        field.element.removeClass('is-invalid');
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    alert('Mohon lengkapi field berikut:\n' + errorMessage);
                    return false;
                }

                return true;
            });

            // Remove invalid class on input
            $('input, select').on('input change', function() {
                $(this).removeClass('is-invalid');
            });

            // Event listeners untuk tanggal dan shift
            $('#tanggal_implementasi, #shift').on('change', function() {
                checkDuplicateDateTime();
            });

            // Tambahkan CSS untuk medium-risk jika belum ada
            if (!$('style:contains("medium-risk")').length) {
                $('<style>').text(`
                    .score-category.medium-risk {
                        color: #fd7e14;
                    }
                `).appendTo('head');
            }

        });
    </script>
@endpush
