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

            .kriteria-row {
                display: flex;
                align-items: center;
                width: 100%;
                gap: 17px;
            }

            .kriteria-desc {
                flex: 0 1 50%;
                line-height: 1.5;
                font-size: 14px;
                padding-right: 0;
            }

            .kriteria-desc strong {
                color: #2c3e50;
                font-size: 15px;
            }

            .kriteria-checkbox {
                width: 50px;
                text-align: left;
                flex-shrink: 0;
            }

            .kriteria-checkbox input[type="checkbox"] {
                width: 15px;
                height: 18px;
                cursor: pointer;
                transform: scale(1.2);
            }

            .keterangan-input {
                flex: 1;
                max-width: 350px;
                min-width: 200px;
            }

            .sub-kriteria {
                background-color: #f8f9fc;
                border-left: 3px solid #4e73df;
                margin-left: 20px;
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
                width: 100%;
            }

            .keterangan-field:focus {
                border-color: #4e73df;
                box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
                outline: none;
            }

            .keterangan-field.show {
                display: block;
                animation: slideIn 0.3s ease;
            }

            @keyframes slideIn {
                from {
                    opacity: 0;
                    transform: scale(0.9);
                }
                to {
                    opacity: 1;
                    transform: scale(1);
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

            .signature-area {
                background: white;
                border: 2px dashed #d1d3e2;
                border-radius: 8px;
                height: 120px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 15px 0;
                position: relative;
                transition: border-color 0.3s ease;
            }

            .signature-area:hover {
                border-color: #4e73df;
                background-color: #f8f9fc;
            }

            .signature-area span {
                color: #6c757d;
                font-style: italic;
            }

            .doctor-name-input {
                background: white;
                border: none;
                border-bottom: 2px solid #dee2e6;
                border-radius: 0;
                padding: 10px 0;
                text-align: center;
                font-weight: 500;
                transition: border-color 0.3s ease;
            }

            .doctor-name-input:focus {
                border-bottom-color: #4e73df;
                box-shadow: none;
                outline: none;
            }

            .btn-save {
                background: linear-gradient(135deg, #1cc88a 0%, #17a673 100%);
                border: none;
                padding: 12px 30px;
                border-radius: 8px;
                font-weight: 600;
                color: white;
                box-shadow: 0 4px 6px rgba(28, 200, 138, 0.25);
                transition: all 0.3s ease;
            }

            .btn-save:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 12px rgba(28, 200, 138, 0.35);
                background: linear-gradient(135deg, #17a673 0%, #1cc88a 100%);
            }

            .form-label {
                font-weight: 600;
                color: #495057;
                margin-bottom: 8px;
            }

            .form-control {
                border: 2px solid #e3e8ee;
                border-radius: 6px;
                padding: 10px 12px;
                transition: all 0.3s ease;
            }

            .form-control:focus {
                border-color: #4e73df;
                box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
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

            /* Responsive design */
            @media (max-width: 768px) {
                .kriteria-row {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 10px;
                }

                .kriteria-desc {
                    flex: 1 1 100%;
                    margin-bottom: 10px;
                    max-width: 100%;
                }

                .kriteria-checkbox,
                .keterangan-input {
                    width: 100%;
                    max-width: 100%;
                }

                .kriteria-checkbox {
                    text-align: left;
                }
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

                <form
                    action="{{ route('rawat-inap.kriteria-masuk-keluar.iccu.store', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                    method="post">
                    @csrf

                    <!-- Tanggal dan Tanda Tangan -->
                    <div class="">
                        <h6><i class="fas fa-signature me-2"></i>Informasi Dokter</h6>

                        <div class="date-time-inputs">
                            <div class="row">
                                <div class="col-md-6 col-12 mb-3">
                                    <label for="iccu_tanggal" class="form-label">
                                        <i class="fas fa-calendar me-1"></i>Tanggal
                                    </label>
                                    <input type="date" name="iccu_tanggal" id="iccu_tanggal" class="form-control"
                                        value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="col-md-6 col-12 mb-3">
                                    <label for="iccu_jam" class="form-label">
                                        <i class="fas fa-clock me-1"></i>Jam
                                    </label>
                                    <input type="time" name="iccu_jam" id="iccu_jam" class="form-control"
                                        value="{{ date('H:i') }}">
                                </div>
                            </div>
                        </div>

                        <div class="">
                            <label for="kd_dokter" class="form-label mb-2">Dokter Jantung</label>
                            <select name="kd_dokter" id="kd_dokter" class="form-select select2" required>
                                <option value="">--Pilih--</option>
                                @foreach ($dokter as $dok)
                                    <option value="{{ $dok->kd_dokter }}">{{ $dok->nama_lengkap }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- KRITERIA MASUK -->
                    <div class="kriteria-section mt-5">
                        <div class="kriteria-header">
                            <div class="row">
                                <div class="col-md-5 col-6">
                                    <i class="fas fa-sign-in-alt me-2"></i>
                                    KRITERIA MASUK
                                </div>
                                <div class="col-md-2 col-2">CHECK</div>
                                <div class="col-md-5 col-4">KETERANGAN</div>
                            </div>
                        </div>

                        <!-- Nilai Tanda Vital -->
                        <div class="kriteria-item" data-kriteria="tanda_vital">
                            <div class="kriteria-row">
                                <div class="kriteria-desc">
                                    <strong>1. Nilai Tanda Vital</strong>
                                </div>
                                <div class="kriteria-checkbox">
                                    <input type="checkbox" name="vita_kriteria_masuk" value="1" id="tanda_vital"
                                        onchange="toggleKeterangan('tanda_vital', this)">
                                </div>
                                <div class="keterangan-input">
                                    <input type="text" name="vita_keterangan_masuk"
                                        class="form-control keterangan-field" id="keterangan_tanda_vital"
                                        placeholder="Masukkan keterangan...">
                                </div>
                            </div>
                        </div>

                        <!-- Infark Miocard Akut -->
                        <div class="kriteria-item sub-kriteria" data-kriteria="infark_miocard">
                            <div class="kriteria-row">
                                <div class="kriteria-desc">
                                    • Infark Miocard Akut
                                </div>
                                <div class="kriteria-checkbox">
                                    <input type="checkbox" name="infark_kriteria_masuk" value="1" id="infark_miocard"
                                        onchange="toggleKeterangan('infark_miocard', this)">
                                </div>
                                <div class="keterangan-input">
                                    <input type="text" name="infark_keterangan_masuk"
                                        class="form-control keterangan-field" id="keterangan_infark_miocard"
                                        placeholder="Masukkan keterangan...">
                                </div>
                            </div>
                        </div>

                        <!-- Angina Tidak Stabil -->
                        <div class="kriteria-item sub-kriteria" data-kriteria="angina_tidak_stabil">
                            <div class="kriteria-row">
                                <div class="kriteria-desc">
                                    • Angina Tidak Stabil
                                </div>
                                <div class="kriteria-checkbox">
                                    <input type="checkbox" name="angina_kriteria_masuk" value="1" id="angina_tidak_stabil"
                                        onchange="toggleKeterangan('angina_tidak_stabil', this)">
                                </div>
                                <div class="keterangan-input">
                                    <input type="text" name="angina_keterangan_masuk"
                                        class="form-control keterangan-field" id="keterangan_angina_tidak_stabil"
                                        placeholder="Masukkan keterangan...">
                                </div>
                            </div>
                        </div>

                        <!-- Aritmia yang gawat -->
                        <div class="kriteria-item" data-kriteria="aritmia_gawat">
                            <div class="kriteria-row">
                                <div class="kriteria-desc">
                                    <strong>3. Aritmia yang gawat, mengancam jiwa misalnya :</strong>
                                </div>
                                <div class="kriteria-checkbox">
                                    <input type="checkbox" name="aritmia_kriteria_masuk" value="1" id="aritmia_gawat"
                                        onchange="toggleKeterangan('aritmia_gawat', this)">
                                </div>
                                <div class="keterangan-input">
                                    <input type="text" name="aritmia_keterangan_masuk"
                                        class="form-control keterangan-field" id="keterangan_aritmia_gawat"
                                        placeholder="Masukkan keterangan...">
                                </div>
                            </div>
                        </div>

                        <!-- Sub-kriteria Aritmia -->
                        <div class="kriteria-item sub-kriteria" data-kriteria="blok_av">
                            <div class="kriteria-row">
                                <div class="kriteria-desc">
                                    • Blok AV total dengan irama lolos Ventrikuler <40X/Menit
                                </div>
                                <div class="kriteria-checkbox">
                                    <input type="checkbox" name="blokav_kriteria_masuk" value="1" id="blok_av"
                                        onchange="toggleKeterangan('blok_av', this)">
                                </div>
                                <div class="keterangan-input">
                                    <input type="text" name="blokav_keterangan_masuk" class="form-control keterangan-field"
                                        id="keterangan_blok_av" placeholder="Masukkan keterangan...">
                                </div>
                            </div>
                        </div>

                        <div class="kriteria-item sub-kriteria" data-kriteria="sinus_bradikardi">
                            <div class="kriteria-row">
                                <div class="kriteria-desc">
                                    • Sinus Bradikardi <40x/Menit
                                </div>
                                <div class="kriteria-checkbox">
                                    <input type="checkbox" name="sinus_kriteria_masuk" value="1" id="sinus_bradikardi"
                                        onchange="toggleKeterangan('sinus_bradikardi', this)">
                                </div>
                                <div class="keterangan-input">
                                    <input type="text" name="sinus_keterangan_masuk"
                                        class="form-control keterangan-field" id="keterangan_sinus_bradikardi"
                                        placeholder="Masukkan keterangan...">
                                </div>
                            </div>
                        </div>

                        <div class="kriteria-item sub-kriteria" data-kriteria="sick_sinus">
                            <div class="kriteria-row">
                                <div class="kriteria-desc">
                                    • Sick Sinus Sindroma dengan serangan
                                </div>
                                <div class="kriteria-checkbox">
                                    <input type="checkbox" name="sick_kriteria_masuk" value="1" id="sick_sinus"
                                        onchange="toggleKeterangan('sick_sinus', this)">
                                </div>
                                <div class="keterangan-input">
                                    <input type="text" name="sick_keterangan_masuk" class="form-control keterangan-field"
                                        id="keterangan_sick_sinus" placeholder="Masukkan keterangan...">
                                </div>
                            </div>
                        </div>

                        <div class="kriteria-item sub-kriteria" data-kriteria="takikardia_artrial">
                            <div class="kriteria-row">
                                <div class="kriteria-desc">
                                    • Takikardia artrial proksimal.
                                </div>
                                <div class="kriteria-checkbox">
                                    <input type="checkbox" name="takikardia_kriteria_masuk" value="1" id="takikardia_artrial"
                                        onchange="toggleKeterangan('takikardia_artrial', this)">
                                </div>
                                <div class="keterangan-input">
                                    <input type="text" name="takikardia_keterangan_masuk"
                                        class="form-control keterangan-field" id="keterangan_takikardia_artrial"
                                        placeholder="Masukkan keterangan...">
                                </div>
                            </div>
                        </div>

                        <div class="kriteria-item sub-kriteria" data-kriteria="fibrilasi_ventrikuler">
                            <div class="kriteria-row">
                                <div class="kriteria-desc">
                                    • Fibrilasi ventrikuler
                                </div>
                                <div class="kriteria-checkbox">
                                    <input type="checkbox" name="fibrilasi_kriteria_masuk" value="1"
                                        id="fibrilasi_ventrikuler" onchange="toggleKeterangan('fibrilasi_ventrikuler', this)">
                                </div>
                                <div class="keterangan-input">
                                    <input type="text" name="fibrilasi_keterangan_masuk"
                                        class="form-control keterangan-field" id="keterangan_fibrilasi_ventrikuler"
                                        placeholder="Masukkan keterangan...">
                                </div>
                            </div>
                        </div>

                        <!-- Edema Paru Akut -->
                        <div class="kriteria-item" data-kriteria="edema_paru">
                            <div class="kriteria-row">
                                <div class="kriteria-desc">
                                    4. Edema Paru Akut
                                </div>
                                <div class="kriteria-checkbox">
                                    <input type="checkbox" name="edema_kriteria_masuk" value="1" id="edema_paru"
                                        onchange="toggleKeterangan('edema_paru', this)">
                                </div>
                                <div class="keterangan-input">
                                    <input type="text" name="edema_keterangan_masuk" class="form-control keterangan-field"
                                        id="keterangan_edema_paru" placeholder="Masukkan keterangan...">
                                </div>
                            </div>
                        </div>

                        <!-- Miokarditis -->
                        <div class="kriteria-item" data-kriteria="miokarditis">
                            <div class="kriteria-row">
                                <div class="kriteria-desc">
                                    5. Miokarditis
                                </div>
                                <div class="kriteria-checkbox">
                                    <input type="checkbox" name="miokarditis_kriteria_masuk" value="1" id="miokarditis"
                                        onchange="toggleKeterangan('miokarditis', this)">
                                </div>
                                <div class="keterangan-input">
                                    <input type="text" name="miokarditis_keterangan_masuk"
                                        class="form-control keterangan-field" id="keterangan_miokarditis"
                                        placeholder="Masukkan keterangan...">
                                </div>
                            </div>
                        </div>

                        <!-- Krisis Hipertensi -->
                        <div class="kriteria-item" data-kriteria="krisis_hipertensi">
                            <div class="kriteria-row">
                                <div class="kriteria-desc">
                                    6. Krisis Hipertensi
                                </div>
                                <div class="kriteria-checkbox">
                                    <input type="checkbox" name="krisis_kriteria_masuk" value="1" id="krisis_hipertensi"
                                        onchange="toggleKeterangan('krisis_hipertensi', this)">
                                </div>
                                <div class="keterangan-input">
                                    <input type="text" name="krisis_keterangan_masuk"
                                        class="form-control keterangan-field" id="keterangan_krisis_hipertensi"
                                        placeholder="Masukkan keterangan...">
                                </div>
                            </div>
                        </div>

                        <!-- Penyakit Jantung lain -->
                        <div class="kriteria-item" data-kriteria="penyakit_jantung_lain">
                            <div class="kriteria-row">
                                <div class="kriteria-desc">
                                    7. Penyakit Jantung lain yang memerlukan pemantauan Hemodinamik
                                </div>
                                <div class="kriteria-checkbox">
                                    <input type="checkbox" name="penyakit_kriteria_masuk" value="1"
                                        id="penyakit_jantung_lain" onchange="toggleKeterangan('penyakit_jantung_lain', this)">
                                </div>
                                <div class="keterangan-input">
                                    <input type="text" name="penyakit_keterangan_masuk"
                                        class="form-control keterangan-field" id="keterangan_penyakit_jantung_lain"
                                        placeholder="Masukkan keterangan...">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- KRITERIA KELUAR -->
                    <div class="kriteria-section">
                        <div class="kriteria-header">
                            <div class="row">
                                <div class="col-md-5 col-6">
                                    <i class="fas fa-sign-out-alt me-2"></i>
                                    KRITERIA KELUAR
                                </div>
                                <div class="col-md-2 col-2">CHECK LIST</div>
                                <div class="col-md-5 col-4">KETERANGAN</div>
                            </div>
                        </div>

                        <!-- Kriteria Keluar 1 -->
                        <div class="kriteria-item" data-kriteria="tidak_perlu_intensive">
                            <div class="kriteria-row">
                                <div class="kriteria-desc">
                                    1. Dianggap keadaan penderita sudah tidak memerlukan perawatan intensive dan dapat dirawat
                                    di ruang rawat inap.
                                </div>
                                <div class="kriteria-checkbox">
                                    <input type="checkbox" name="dirawat_kriteria_keluar" value="1"
                                        id="tidak_perlu_intensive" onchange="toggleKeterangan('tidak_perlu_intensive', this)">
                                </div>
                                <div class="keterangan-input">
                                    <input type="text" name="dirawat_keterangan_keluar"
                                        class="form-control keterangan-field" id="keterangan_tidak_perlu_intensive"
                                        placeholder="Masukkan keterangan...">
                                </div>
                            </div>
                        </div>

                        <!-- Kriteria Keluar 2 -->
                        <div class="kriteria-item" data-kriteria="bukan_penyakit_jantung">
                            <div class="kriteria-row">
                                <div class="kriteria-desc">
                                    2. Kegawatan penderita bukan disebabkan oleh penyakit jantung dan dipindahkan ke unit
                                    perawatan intensive lain.
                                </div>
                                <div class="kriteria-checkbox">
                                    <input type="checkbox" name="kegawatan_kriteria_keluar" value="1"
                                        id="bukan_penyakit_jantung" onchange="toggleKeterangan('bukan_penyakit_jantung', this)">
                                </div>
                                <div class="keterangan-input">
                                    <input type="text" name="kegawatan_keterangan_keluar"
                                        class="form-control keterangan-field" id="keterangan_bukan_penyakit_jantung"
                                        placeholder="Masukkan keterangan...">
                                </div>
                            </div>
                        </div>

                        <!-- Kriteria Keluar 3 -->
                        <div class="kriteria-item" data-kriteria="penyakit_menular">
                            <div class="kriteria-row">
                                <div class="kriteria-desc">
                                    3. Penderita juga menderita penyakit menular.
                                </div>
                                <div class="kriteria-checkbox">
                                    <input type="checkbox" name="penderita_kriteria_keluar" value="1" id="penyakit_menular"
                                        onchange="toggleKeterangan('penyakit_menular', this)">
                                </div>
                                <div class="keterangan-input">
                                    <input type="text" name="penderita_keterangan_keluar"
                                        class="form-control keterangan-field" id="keterangan_penyakit_menular"
                                        placeholder="Masukkan keterangan...">
                                </div>
                            </div>
                        </div>

                        <!-- Kriteria Keluar 4 -->
                        <div class="kriteria-item" data-kriteria="meninggal">
                            <div class="kriteria-row">
                                <div class="kriteria-desc">
                                    4. Penderita yang meninggal dan dikeluarkan setelah 2 jam observasi di ICCU.
                                </div>
                                <div class="kriteria-checkbox">
                                    <input type="checkbox" name="iccu_kriteria_keluar" value="1" id="meninggal"
                                        onchange="toggleKeterangan('meninggal', this)">
                                </div>
                                <div class="keterangan-input">
                                    <input type="text" name="iccu_keterangan_keluar" class="form-control keterangan-field"
                                        id="keterangan_meninggal" placeholder="Masukkan keterangan...">
                                </div>
                            </div>
                        </div>

                        <!-- Kriteria Keluar 5 -->
                        <div class="kriteria-item" data-kriteria="pindah_rs_lain">
                            <div class="kriteria-row">
                                <div class="kriteria-desc">
                                    5. Penderita yang ingin dirawat di rumah sakit lain atas permintaan sendiri atau keluarga.
                                </div>
                                <div class="kriteria-checkbox">
                                    <input type="checkbox" name="rslain_kriteria_keluar" value="1" id="pindah_rs_lain"
                                        onchange="toggleKeterangan('pindah_rs_lain', this)">
                                </div>
                                <div class="keterangan-input">
                                    <input type="text" name="rslain_keterangan_keluar"
                                        class="form-control keterangan-field" id="keterangan_pindah_rs_lain"
                                        placeholder="Masukkan keterangan...">
                                </div>
                            </div>
                        </div>

                        <!-- Kriteria Keluar 6 -->
                        <div class="kriteria-item" data-kriteria="pulang_paksa">
                            <div class="kriteria-row">
                                <div class="kriteria-desc">
                                    6. Yang pulang paksa setelah mendatangani surat pernyataan tidak ingin di rawat di RSUD
                                    Langsa
                                </div>
                                <div class="kriteria-checkbox">
                                    <input type="checkbox" name="rsud_kriteria_keluar" value="1" id="pulang_paksa"
                                        onchange="toggleKeterangan('pulang_paksa', this)">
                                </div>
                                <div class="keterangan-input">
                                    <input type="text" name="rsud_keterangan_keluar"
                                        class="form-control keterangan-field" id="keterangan_pulang_paksa"
                                        placeholder="Masukkan keterangan...">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary" id="simpan">
                                <i class="ti-save"></i> Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function toggleKeterangan(id, checkbox) {
            const keteranganField = document.getElementById('keterangan_' + id);
            const kriteriaBaris = checkbox.closest('.kriteria-item');

            if (checkbox.checked) {
                keteranganField.style.display = 'block';
                keteranganField.classList.add('show');
                keteranganField.focus();
                kriteriaBaris.classList.add('checked');

                // Animate the field appearance
                setTimeout(() => {
                    keteranganField.style.opacity = '1';
                }, 50);
            } else {
                keteranganField.style.display = 'none';
                keteranganField.classList.remove('show');
                keteranganField.value = ''; // Kosongkan keterangan saat checkbox tidak dicentang
                kriteriaBaris.classList.remove('checked');
            }
        }

        // Initialize all checkboxes on page load
        document.addEventListener('DOMContentLoaded', function () {
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');

            checkboxes.forEach(function (checkbox) {
                const id = checkbox.id;
                const keteranganField = document.getElementById('keterangan_' + id);

                if (keteranganField) {
                    if (checkbox.checked) {
                        keteranganField.style.display = 'block';
                        keteranganField.classList.add('show');
                        checkbox.closest('.kriteria-item').classList.add('checked');
                    } else {
                        keteranganField.style.display = 'none';
                        keteranganField.classList.remove('show');
                    }
                }
            });

            // Add smooth transitions for better UX
            window.addEventListener('beforeunload', function () {
                const checkedItems = document.querySelectorAll('.kriteria-item.checked');
                if (checkedItems.length > 0) {
                    return 'Anda memiliki item yang telah dicentang. Yakin ingin meninggalkan halaman?';
                }
            });
        });

        // Add validation before submit
        document.querySelector('form').addEventListener('submit', function (e) {
            const checkedBoxes = document.querySelectorAll('input[type="checkbox"]:checked');
            const emptyKeterangan = [];

            checkedBoxes.forEach(function (checkbox) {
                const id = checkbox.id;
                const keteranganField = document.getElementById('keterangan_' + id);
                if (keteranganField && keteranganField.value.trim() === '') {
                    const label = checkbox.closest('.kriteria-item').querySelector('.kriteria-desc').textContent.trim();
                    emptyKeterangan.push(label);
                }
            });

            if (emptyKeterangan.length > 0) {
                e.preventDefault();
                alert('Harap isi keterangan untuk item yang telah dicentang:\n\n' + emptyKeterangan.join('\n'));
                return false;
            }

            // Show loading state
            const submitBtn = document.querySelector('#simpan');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
            submitBtn.disabled = true;

            // Restore button state if there's an error (after a delay)
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 5000);
        });
    </script>
@endpush
