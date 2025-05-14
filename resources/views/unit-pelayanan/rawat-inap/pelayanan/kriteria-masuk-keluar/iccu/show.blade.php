@extends('layouts.administrator.master')

@section('content')
    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
        <style>
            .iccu-form {
                background: white;
                padding: 30px;
                border-radius: 12px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                margin-bottom: 30px;
            }

            .form-header {
                background: linear-gradient(135deg, #4e73df 0%, #36b9cc 100%);
                color: white;
                padding: 20px;
                border-radius: 12px 12px 0 0;
                margin: -30px -30px 30px -30px;
                text-align: center;
            }

            .form-header h5 {
                margin: 0;
                font-weight: 600;
                line-height: 1.4;
            }

            .kriteria-section {
                margin-bottom: 40px;
                border-radius: 8px;
                overflow: hidden;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            }

            .kriteria-header {
                background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
                padding: 15px 20px;
                font-weight: 600;
                border-bottom: 2px solid #dee2e6;
                color: #495057;
            }

            .kriteria-header .row {
                align-items: center;
                margin: 0;
            }

            .kriteria-item {
                border-bottom: 1px solid #e9ecef;
                padding: 15px 20px;
                display: flex;
                align-items: flex-start;
                background: white;
                transition: background-color 0.2s ease;
            }

            .kriteria-item:hover {
                background-color: #f8f9fc;
            }

            .kriteria-item:last-child {
                border-bottom: none;
                border-radius: 0 0 8px 8px;
            }

            .kriteria-desc {
                flex: 1;
                padding-right: 15px;
                line-height: 1.5;
                font-size: 14px;
            }

            .kriteria-desc strong {
                color: #2c3e50;
                font-size: 15px;
            }

            .kriteria-checkbox {
                width: 80px;
                text-align: center;
                padding: 0 10px;
            }

            .kriteria-checkbox input[type="checkbox"] {
                width: 18px;
                height: 18px;
                cursor: default;
                transform: scale(1.2);
            }

            .keterangan-input {
                width: 200px;
                padding-left: 15px;
            }

            .sub-kriteria {
                margin-left: 20px;
                background-color: #f8f9fc;
                border-left: 3px solid #4e73df;
            }

            .sub-kriteria .kriteria-desc {
                font-size: 13px;
                color: #5a6c7d;
            }

            .keterangan-field {
                display: none;
                border: 2px solid #e3e8ee;
                border-radius: 6px;
                padding: 8px 12px;
                font-size: 13px;
                transition: all 0.3s ease;
            }

            .keterangan-field.show {
                display: block;
                animation: slideDown 0.3s ease;
            }

            @keyframes slideDown {
                from {
                    opacity: 0;
                    transform: translateY(-10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .signature-section {
                background: #f8f9fa;
                padding: 25px;
                border-radius: 8px;
                margin-top: 30px;
            }

            .signature-section h6 {
                color: #495057;
                font-weight: 600;
                margin-bottom: 20px;
            }

            .date-time-inputs {
                background: white;
                padding: 20px;
                border-radius: 8px;
                margin-bottom: 20px;
                border: 1px solid #e3e6f0;
            }

            .form-label {
                font-weight: 600;
                color: #495057;
                margin-bottom: 8px;
            }

            /* Responsive design */
            @media (max-width: 768px) {
                .kriteria-header .row>div:nth-child(2),
                .kriteria-header .row>div:nth-child(3) {
                    text-align: center;
                }

                .kriteria-item {
                    flex-direction: column;
                    gap: 10px;
                }

                .kriteria-checkbox,
                .keterangan-input {
                    width: 100%;
                    padding: 0;
                    text-align: left;
                }

                .keterangan-field {
                    margin-top: 10px;
                }
            }

            /* Icon indicators */
            .kriteria-item.checked {
                background-color: #f0f8ff;
                border-left: 4px solid #4e73df;
            }

            .kriteria-item.checked .kriteria-desc {
                color: #2c3e50;
                font-weight: 500;
            }
        </style>
    @endpush

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <a href="{{ url()->previous() }}" class="btn btn-outline-info">
                <i class="ti-arrow-left"></i> Kembali
            </a>

            <div class="iccu-form">
                <div class="form-header mt-3">
                    <h5>
                        <i class="fas fa-heart-pulse me-2"></i>
                        Formulir Kriteria Masuk/Keluar ICCU
                    </h5>
                </div>

                <!-- Tanggal dan Tanda Tangan -->
                <div class="">
                    <h6><i class="fas fa-signature me-2"></i>Informasi Dokter</h6>

                    <div class="date-time-inputs">
                        <div class="row">
                            <div class="col-md-6 col-12 mb-3">
                                <label for="iccu_tanggal" class="form-label">
                                    <i class="fas fa-calendar me-1"></i>Tanggal
                                </label>
                                <p class="form-control-static">
                                    {{ $dataIccu->iccu_tanggal ? date('d M Y', strtotime($dataIccu->iccu_tanggal)) : '-' }}
                                </p>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label for="iccu_jam" class="form-label">
                                    <i class="fas fa-clock me-1"></i>Jam
                                </label>
                                <p class="form-control-static">
                                    {{ $dataIccu->iccu_jam ? date('H:i', strtotime($dataIccu->iccu_jam)) : '-' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="">
                        <label for="kd_dokter" class="form-label mb-2">Dokter Jantung</label>
                        <p class="form-control-static">
                            {{ $dokter->firstWhere('kd_dokter', $dataIccu->kd_dokter)->nama ?? '-' }}
                        </p>
                    </div>
                </div>

                <!-- KRITERIA MASUK -->
                <div class="kriteria-section mt-5">
                    <div class="kriteria-header">
                        <div class="row">
                            <div class="col-md-8 col-12">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                KRITERIA MASUK
                            </div>
                            <div class="col-md-2 col-6">CHECK</div>
                            <div class="col-md-2 col-6">KETERANGAN</div>
                        </div>
                    </div>

                    <!-- Nilai Tanda Vital -->
                    <div class="kriteria-item {{ $dataIccu->vita_kriteria_masuk ? 'checked' : '' }}" data-kriteria="tanda_vital">
                        <div class="kriteria-desc">
                            <strong>1. Nilai Tanda Vital</strong>
                        </div>
                        <div class="kriteria-checkbox">
                            <input type="checkbox" disabled {{ $dataIccu->vita_kriteria_masuk ? 'checked' : '' }}>
                        </div>
                        <div class="keterangan-input">
                            <p class="keterangan-field {{ $dataIccu->vita_kriteria_masuk ? 'show' : '' }}">
                                {{ $dataIccu->vita_keterangan_masuk ?: '-' }}
                            </p>
                        </div>
                    </div>

                    <!-- Infark Miocard Akut -->
                    <div class="kriteria-item {{ $dataIccu->infark_kriteria_masuk ? 'checked' : '' }}" data-kriteria="infark_miocard">
                        <div class="kriteria-desc">
                            1. Infark Miocard Akut
                        </div>
                        <div class="kriteria-checkbox">
                            <input type="checkbox" disabled {{ $dataIccu->infark_kriteria_masuk ? 'checked' : '' }}>
                        </div>
                        <div class="keterangan-input">
                            <p class="keterangan-field {{ $dataIccu->infark_kriteria_masuk ? 'show' : '' }}">
                                {{ $dataIccu->infark_keterangan_masuk ?: '-' }}
                            </p>
                        </div>
                    </div>

                    <!-- Angina Tidak Stabil -->
                    <div class="kriteria-item {{ $dataIccu->angina_kriteria_masuk ? 'checked' : '' }}" data-kriteria="angina_tidak_stabil">
                        <div class="kriteria-desc">
                            2. Angina Tidak Stabil
                        </div>
                        <div class="kriteria-checkbox">
                            <input type="checkbox" disabled {{ $dataIccu->angina_kriteria_masuk ? 'checked' : '' }}>
                        </div>
                        <div class="keterangan-input">
                            <p class="keterangan-field {{ $dataIccu->angina_kriteria_masuk ? 'show' : '' }}">
                                {{ $dataIccu->angina_keterangan_masuk ?: '-' }}
                            </p>
                        </div>
                    </div>

                    <!-- Aritmia yang gawat -->
                    <div class="kriteria-item {{ $dataIccu->aritmia_kriteria_masuk ? 'checked' : '' }}" data-kriteria="aritmia_gawat">
                        <div class="kriteria-desc">
                            <strong>3. Aritmia yang gawat, mengancam jiwa misalnya :</strong>
                        </div>
                        <div class="kriteria-checkbox">
                            <input type="checkbox" disabled {{ $dataIccu->aritmia_kriteria_masuk ? 'checked' : '' }}>
                        </div>
                        <div class="keterangan-input">
                            <p class="keterangan-field {{ $dataIccu->aritmia_kriteria_masuk ? 'show' : '' }}">
                                {{ $dataIccu->aritmia_keterangan_masuk ?: '-' }}
                            </p>
                        </div>
                    </div>

                    <!-- Sub-kriteria Aritmia -->
                    <div class="kriteria-item sub-kriteria {{ $dataIccu->blokav_kriteria_masuk ? 'checked' : '' }}" data-kriteria="blok_av">
                        <div class="kriteria-desc">
                            • Blok AV total dengan irama lolos Ventrikuler <40X/Menit
                        </div>
                        <div class="kriteria-checkbox">
                            <input type="checkbox" disabled {{ $dataIccu->blokav_kriteria_masuk ? 'checked' : '' }}>
                        </div>
                        <div class="keterangan-input">
                            <p class="keterangan-field {{ $dataIccu->blokav_kriteria_masuk ? 'show' : '' }}">
                                {{ $dataIccu->blokav_keterangan_masuk ?: '-' }}
                            </p>
                        </div>
                    </div>

                    <div class="kriteria-item sub-kriteria {{ $dataIccu->sinus_kriteria_masuk ? 'checked' : '' }}" data-kriteria="sinus_bradikardi">
                        <div class="kriteria-desc">
                            • Sinus Bradikardi <40x/Menit
                        </div>
                        <div class="kriteria-checkbox">
                            <input type="checkbox" disabled {{ $dataIccu->sinus_kriteria_masuk ? 'checked' : '' }}>
                        </div>
                        <div class="keterangan-input">
                            <p class="keterangan-field {{ $dataIccu->sinus_kriteria_masuk ? 'show' : '' }}">
                                {{ $dataIccu->sinus_keterangan_masuk ?: '-' }}
                            </p>
                        </div>
                    </div>

                    <div class="kriteria-item sub-kriteria {{ $dataIccu->sick_kriteria_masuk ? 'checked' : '' }}" data-kriteria="sick_sinus">
                        <div class="kriteria-desc">
                            • Sick Sinus Sindroma dengan serangan
                        </div>
                        <div class="kriteria-checkbox">
                            <input type="checkbox" disabled {{ $dataIccu->sick_kriteria_masuk ? 'checked' : '' }}>
                        </div>
                        <div class="keterangan-input">
                            <p class="keterangan-field {{ $dataIccu->sick_kriteria_masuk ? 'show' : '' }}">
                                {{ $dataIccu->sick_keterangan_masuk ?: '-' }}
                            </p>
                        </div>
                    </div>

                    <div class="kriteria-item sub-kriteria {{ $dataIccu->takikardia_kriteria_masuk ? 'checked' : '' }}" data-kriteria="takikardia_artrial">
                        <div class="kriteria-desc">
                            • Takikardia artrial proksimal.
                        </div>
                        <div class="kriteria-checkbox">
                            <input type="checkbox" disabled {{ $dataIccu->takikardia_kriteria_masuk ? 'checked' : '' }}>
                        </div>
                        <div class="keterangan-input">
                            <p class="keterangan-field {{ $dataIccu->takikardia_kriteria_masuk ? 'show' : '' }}">
                                {{ $dataIccu->takikardia_keterangan_masuk ?: '-' }}
                            </p>
                        </div>
                    </div>

                    <div class="kriteria-item sub-kriteria {{ $dataIccu->fibrilasi_kriteria_masuk ? 'checked' : '' }}" data-kriteria="fibrilasi_ventrikuler">
                        <div class="kriteria-desc">
                            • Fibrilasi ventrikuler
                        </div>
                        <div class="kriteria-checkbox">
                            <input type="checkbox" disabled {{ $dataIccu->fibrilasi_kriteria_masuk ? 'checked' : '' }}>
                        </div>
                        <div class="keterangan-input">
                            <p class="keterangan-field {{ $dataIccu->fibrilasi_kriteria_masuk ? 'show' : '' }}">
                                {{ $dataIccu->fibrilasi_keterangan_masuk ?: '-' }}
                            </p>
                        </div>
                    </div>

                    <!-- Edema Paru Akut -->
                    <div class="kriteria-item {{ $dataIccu->edema_kriteria_masuk ? 'checked' : '' }}" data-kriteria="edema_paru">
                        <div class="kriteria-desc">
                            4. Edema Paru Akut
                        </div>
                        <div class="kriteria-checkbox">
                            <input type="checkbox" disabled {{ $dataIccu->edema_kriteria_masuk ? 'checked' : '' }}>
                        </div>
                        <div class="keterangan-input">
                            <p class="keterangan-field {{ $dataIccu->edema_kriteria_masuk ? 'show' : '' }}">
                                {{ $dataIccu->edema_keterangan_masuk ?: '-' }}
                            </p>
                        </div>
                    </div>

                    <!-- Miokarditis -->
                    <div class="kriteria-item {{ $dataIccu->miokarditis_kriteria_masuk ? 'checked' : '' }}" data-kriteria="miokarditis">
                        <div class="kriteria-desc">
                            5. Miokarditis
                        </div>
                        <div class="kriteria-checkbox">
                            <input type="checkbox" disabled {{ $dataIccu->miokarditis_kriteria_masuk ? 'checked' : '' }}>
                        </div>
                        <div class="keterangan-input">
                            <p class="keterangan-field {{ $dataIccu->miokarditis_kriteria_masuk ? 'show' : '' }}">
                                {{ $dataIccu->miokarditis_keterangan_masuk ?: '-' }}
                            </p>
                        </div>
                    </div>

                    <!-- Krisis Hipertensi -->
                    <div class="kriteria-item {{ $dataIccu->krisis_kriteria_masuk ? 'checked' : '' }}" data-kriteria="krisis_hipertensi">
                        <div class="kriteria-desc">
                            6. Krisis Hipertensi
                        </div>
                        <div class="kriteria-checkbox">
                            <input type="checkbox" disabled {{ $dataIccu->krisis_kriteria_masuk ? 'checked' : '' }}>
                        </div>
                        <div class="keterangan-input">
                            <p class="keterangan-field {{ $dataIccu->krisis_kriteria_masuk ? 'show' : '' }}">
                                {{ $dataIccu->krisis_keterangan_masuk ?: '-' }}
                            </p>
                        </div>
                    </div>

                    <!-- Penyakit Jantung lain -->
                    <div class="kriteria-item {{ $dataIccu->penyakit_kriteria_masuk ? 'checked' : '' }}" data-kriteria="penyakit_jantung_lain">
                        <div class="kriteria-desc">
                            7. Penyakit Jantung lain yang memerlukan pemantauan Hemodinamik
                        </div>
                        <div class="kriteria-checkbox">
                            <input type="checkbox" disabled {{ $dataIccu->penyakit_kriteria_masuk ? 'checked' : '' }}>
                        </div>
                        <div class="keterangan-input">
                            <p class="keterangan-field {{ $dataIccu->penyakit_kriteria_masuk ? 'show' : '' }}">
                                {{ $dataIccu->penyakit_keterangan_masuk ?: '-' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- KRITERIA KELUAR -->
                <div class="kriteria-section">
                    <div class="kriteria-header">
                        <div class="row">
                            <div class="col-md-8 col-12">
                                <i class="fas fa-sign-out-alt me-2"></i>
                                KRITERIA KELUAR
                            </div>
                            <div class="col-md-2 col-4">CHECK LIST</div>
                            <div class="col-md-2 col-8">KETERANGAN</div>
                        </div>
                    </div>

                    <!-- Kriteria Keluar 1 -->
                    <div class="kriteria-item {{ $dataIccu->dirawat_kriteria_keluar ? 'checked' : '' }}" data-kriteria="tidak_perlu_intensive">
                        <div class="kriteria-desc">
                            1. Dianggap keadaan penderita sudah tidak memerlukan perawatan intensive dan dapat dirawat di ruang rawat inap.
                        </div>
                        <div class="kriteria-checkbox">
                            <input type="checkbox" disabled {{ $dataIccu->dirawat_kriteria_keluar ? 'checked' : '' }}>
                        </div>
                        <div class="keterangan-input">
                            <p class="keterangan-field {{ $dataIccu->dirawat_kriteria_keluar ? 'show' : '' }}">
                                {{ $dataIccu->dirawat_keterangan_keluar ?: '-' }}
                            </p>
                        </div>
                    </div>

                    <!-- Kriteria Keluar 2 -->
                    <div class="kriteria-item {{ $dataIccu->kegawatan_kriteria_keluar ? 'checked' : '' }}" data-kriteria="bukan_penyakit_jantung">
                        <div class="kriteria-desc">
                            2. Kegawatan penderita bukan disebabkan oleh penyakit jantung dan dipindahkan ke unit perawatan intensive lain.
                        </div>
                        <div class="kriteria-checkbox">
                            <input type="checkbox" disabled {{ $dataIccu->kegawatan_kriteria_keluar ? 'checked' : '' }}>
                        </div>
                        <div class="keterangan-input">
                            <p class="keterangan-field {{ $dataIccu->kegawatan_kriteria_keluar ? 'show' : '' }}">
                                {{ $dataIccu->kegawatan_keterangan_keluar ?: '-' }}
                            </p>
                        </div>
                    </div>

                    <!-- Kriteria Keluar 3 -->
                    <div class="kriteria-item {{ $dataIccu->penderita_kriteria_keluar ? 'checked' : '' }}" data-kriteria="penyakit_menular">
                        <div class="kriteria-desc">
                            3. Penderita juga menderita penyakit menular.
                        </div>
                        <div class="kriteria-checkbox">
                            <input type="checkbox" disabled {{ $dataIccu->penderita_kriteria_keluar ? 'checked' : '' }}>
                        </div>
                        <div class="keterangan-input">
                            <p class="keterangan-field {{ $dataIccu->penderita_kriteria_keluar ? 'show' : '' }}">
                                {{ $dataIccu->penderita_keterangan_keluar ?: '-' }}
                            </p>
                        </div>
                    </div>

                    <!-- Kriteria Keluar 4 -->
                    <div class="kriteria-item {{ $dataIccu->iccu_kriteria_keluar ? 'checked' : '' }}" data-kriteria="meninggal">
                        <div class="kriteria-desc">
                            4. Penderita yang meninggal dan dikeluarkan setelah 2 jam observasi di ICCU.
                        </div>
                        <div class="kriteria-checkbox">
                            <input type="checkbox" disabled {{ $dataIccu->iccu_kriteria_keluar ? 'checked' : '' }}>
                        </div>
                        <div class="keterangan-input">
                            <p class="keterangan-field {{ $dataIccu->iccu_kriteria_keluar ? 'show' : '' }}">
                                {{ $dataIccu->iccu_keterangan_keluar ?: '-' }}
                            </p>
                        </div>
                    </div>

                    <!-- Kriteria Keluar 5 -->
                    <div class="kriteria-item {{ $dataIccu->rslain_kriteria_keluar ? 'checked' : '' }}" data-kriteria="pindah_rs_lain">
                        <div class="kriteria-desc">
                            5. Penderita yang ingin dirawat di rumah sakit lain atas permintaan sendiri atau keluarga.
                        </div>
                        <div class="kriteria-checkbox">
                            <input type="checkbox" disabled {{ $dataIccu->rslain_kriteria_keluar ? 'checked' : '' }}>
                        </div>
                        <div class="keterangan-input">
                            <p class="keterangan-field {{ $dataIccu->rslain_kriteria_keluar ? 'show' : '' }}">
                                {{ $dataIccu->rslain_keterangan_keluar ?: '-' }}
                            </p>
                        </div>
                    </div>

                    <!-- Kriteria Keluar 6 -->
                    <div class="kriteria-item {{ $dataIccu->rsud_kriteria_keluar ? 'checked' : '' }}" data-kriteria="pulang_paksa">
                        <div class="kriteria-desc">
                            6. Yang pulang paksa setelah mendatangani surat pernyataan tidak ingin di rawat di RSUD Langsa
                        </div>
                        <div class="kriteria-checkbox">
                            <input type="checkbox" disabled {{ $dataIccu->rsud_kriteria_keluar ? 'checked' : '' }}>
                        </div>
                        <div class="keterangan-input">
                            <p class="keterangan-field {{ $dataIccu->rsud_kriteria_keluar ? 'show' : '' }}">
                                {{ $dataIccu->rsud_keterangan_keluar ?: '-' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection