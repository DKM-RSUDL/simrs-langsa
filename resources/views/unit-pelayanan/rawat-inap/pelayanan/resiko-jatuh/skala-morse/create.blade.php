@extends('layouts.administrator.master')
@include('unit-pelayanan.rawat-inap.pelayanan.resiko-jatuh.skala-morse.include')

@section('content')
    <style>
        .resiko_jatuh__header-asesmen {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .resiko_jatuh__section-separator {
            background: white;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-left: 4px solid #667eea;
        }

        .resiko_jatuh__section-separator h5 {
            color: #667eea;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .resiko_jatuh__section-separator h5:before {
            content: '';
            width: 4px;
            height: 25px;
            background: #667eea;
            margin-right: 10px;
            border-radius: 2px;
        }

        .resiko_jatuh__form-group label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
        }

        .resiko_jatuh__form-control {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 12px 15px;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .resiko_jatuh__form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            transform: translateY(-1px);
        }

        .resiko_jatuh__form-check {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .resiko_jatuh__form-check:hover {
            border-color: #667eea;
            background: #f0f3ff;
            transform: translateX(5px);
        }

        .resiko_jatuh__form-check-input:checked~.resiko_jatuh__form-check-label {
            color: #667eea;
            font-weight: 600;
        }

        .resiko_jatuh__form-check input:checked+label {
            color: #667eea !important;
        }

        .resiko_jatuh__form-check.selected {
            border-color: #667eea;
            background: #e8f0fe;
            box-shadow: 0 4px 8px rgba(102, 126, 234, 0.2);
        }

        .resiko_jatuh__criteria-form-check {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .resiko_jatuh__criteria-form-check:hover {
            border-color: #667eea;
            background: #f0f3ff;
            transform: translateX(5px);
        }

        .resiko_jatuh__criteria-form-check-input:checked~.resiko_jatuh__criteria-form-check-label {
            color: #667eea;
            font-weight: 600;
        }

        .resiko_jatuh__criteria-form-check input:checked+label {
            color: #667eea !important;
        }

        .resiko_jatuh__criteria-form-check.selected {
            border-color: #667eea;
            background: #e8f0fe;
            box-shadow: 0 4px 8px rgba(102, 126, 234, 0.2);
        }

        .resiko_jatuh__badge {
            font-size: 12px;
            padding: 5px 10px;
            border-radius: 20px;
            font-weight: 600;
        }

        .resiko_jatuh__badge-info {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
        }

        .resiko_jatuh__badge-success {
            background: #28a745;
            color: white;
        }

        .resiko_jatuh__badge-warning {
            background: #ffc107;
            color: #212529;
        }

        .resiko_jatuh__badge-danger {
            background: #dc3545;
            color: white;
        }

        .resiko_jatuh__font-weight-bold {
            color: #495057;
            margin-bottom: 15px;
            font-size: 16px;
            display: flex;
            align-items: center;
        }

        .resiko_jatuh__font-weight-bold:before {
            content: '';
            width: 6px;
            height: 6px;
            background: #667eea;
            border-radius: 50%;
            margin-right: 10px;
        }

        .resiko_jatuh__card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .resiko_jatuh__card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .resiko_jatuh__score-total {
            font-size: 3rem;
            font-weight: bold;
            background: linear-gradient(45deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-align: center;
            animation: resiko_jatuh__pulse 2s infinite;
        }

        @keyframes resiko_jatuh__pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        .resiko_jatuh__result-card {
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            transition: all 0.3s ease;
            min-height: 200px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .resiko_jatuh__result-card h5 {
            margin-bottom: 15px;
            font-weight: 600;
        }

        .resiko_jatuh__btn-primary {
            background: linear-gradient(45deg, #667eea, #764ba2);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .resiko_jatuh__btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
            background: linear-gradient(45deg, #764ba2, #667eea);
        }

        .resiko_jatuh__criteria-section {
            background: #fafbfc;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #e9ecef;
        }

        .resiko_jatuh__score-badge {
            float: right;
            margin-top: 2px;
        }

        .resiko_jatuh__fade-in {
            animation: resiko_jatuh__fadeIn 0.6s ease-in;
        }

        @keyframes resiko_jatuh__fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .resiko_jatuh__btn-outline-primary {
            border-color: #667eea;
            color: #667eea;
            transition: all 0.3s ease;
        }

        .resiko_jatuh__btn-outline-primary:hover {
            background: #667eea;
            border-color: #667eea;
            transform: translateX(-3px);
        }

        .resiko_jatuh__keterangan-box {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
        }

        .resiko_jatuh__keterangan-title {
            color: #667eea;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .resiko_jatuh__keterangan-list {
            list-style: none;
            padding: 0;
            margin: 0;
            font-size: 14px;
            line-height: 1.6;
        }

        .resiko_jatuh__keterangan-list li {
            margin-bottom: 8px;
        }

        /* Style khusus untuk section intervensi */
        .resiko_jatuh__intervensi-rr {
            border-left: 4px solid #28a745;
        }

        .resiko_jatuh__intervensi-rr h5 {
            color: #28a745;
        }

        .resiko_jatuh__intervensi-rs {
            border-left: 4px solid #ffc107;
        }

        .resiko_jatuh__intervensi-rs h5 {
            color: #856404;
        }

        .resiko_jatuh__intervensi-rt {
            border-left: 4px solid #dc3545;
        }

        .resiko_jatuh__intervensi-rt h5 {
            color: #dc3545;
        }

        .resiko_jatuh__table-intervensi {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .resiko_jatuh__table-intervensi th,
        .resiko_jatuh__table-intervensi td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: center;
            vertical-align: middle;
            font-size: 12px;
        }

        .resiko_jatuh__table-intervensi th {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        .resiko_jatuh__table-intervensi .shift-header {
            background-color: #e9ecef;
            font-weight: 600;
        }
    </style>

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <a href="{{ route('rawat-inap.resiko-jatuh.morse.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}"
                class="btn btn-outline-primary resiko_jatuh__btn-outline-primary mb-3">
                <i class="ti-arrow-left"></i> Kembali
            </a>

            <form id="resikoJatuh_form" method="POST"
                action="{{ route('rawat-inap.resiko-jatuh.morse.store', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}">
                @csrf

                <div class="resiko_jatuh__fade-in">
                    <div class="resiko_jatuh__header-asesmen text-center">
                        <h4 class="mb-2">
                            <i class="ti-clipboard mr-2"></i>
                            PENGKAJIAN RESIKO JATUH - SKALA MORSE
                        </h4>
                        <small>DEWASA (19 - 59 Tahun)</small>
                    </div>

                    <!-- Data Dasar -->
                    <div class="resiko_jatuh__section-separator">
                        <h5><i class="ti-calendar mr-2"></i> Data Pengkajian</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group resiko_jatuh__form-group">
                                    <label>Tanggal</label>
                                    <input type="date" class="form-control resiko_jatuh__form-control" name="tanggal"
                                        value="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group resiko_jatuh__form-group">
                                    <label>Hari ke</label>
                                    <input type="number" class="form-control resiko_jatuh__form-control" name="hari_ke"
                                        min="1" placeholder="Masukkan hari ke..." required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group resiko_jatuh__form-group">
                                    <label>Shift</label>
                                    <select class="form-control resiko_jatuh__form-control" name="shift" required>
                                        <option value="">Pilih Shift</option>
                                        <option value="PG">🌅 Pagi (PG)</option>
                                        <option value="SI">☀️ Siang (SI)</option>
                                        <option value="ML">🌙 Malam (ML)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Penilaian Resiko Jatuh -->
                    <div class="resiko_jatuh__section-separator">
                        <h5><i class="ti-list-ol mr-2"></i>PENILAIAN RESIKO JATUH (SKALA MORSE)</h5>

                        <!-- Riwayat Jatuh -->
                        <div class="resiko_jatuh__criteria-section">
                            <label class="resiko_jatuh__font-weight-bold">1. Riwayat Jatuh:</label>
                            <div class="form-check resiko_jatuh__criteria-form-check" data-group="riwayat_jatuh">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="riwayat_jatuh" id="resikoJatuh_riwayat_tidak" value="0" required>
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label"
                                    for="resikoJatuh_riwayat_tidak">
                                    a. Tidak
                                    <span
                                        class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor:
                                        0</span>
                                </label>
                            </div>
                            <div class="form-check resiko_jatuh__criteria-form-check" data-group="riwayat_jatuh">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="riwayat_jatuh" id="resikoJatuh_riwayat_ya" value="25">
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label"
                                    for="resikoJatuh_riwayat_ya">
                                    b. Ya
                                    <span
                                        class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor:
                                        25</span>
                                </label>
                            </div>
                        </div>

                        <!-- Diagnosa Sekunder -->
                        <div class="resiko_jatuh__criteria-section">
                            <label class="resiko_jatuh__font-weight-bold">2. Diagnosa Sekunder:</label>
                            <div class="form-check resiko_jatuh__criteria-form-check" data-group="diagnosa_sekunder">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="diagnosa_sekunder" id="resikoJatuh_diagnosa_tidak" value="0" required>
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label"
                                    for="resikoJatuh_diagnosa_tidak">
                                    a. Tidak
                                    <span
                                        class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor:
                                        0</span>
                                </label>
                            </div>
                            <div class="form-check resiko_jatuh__criteria-form-check" data-group="diagnosa_sekunder">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="diagnosa_sekunder" id="resikoJatuh_diagnosa_ya" value="15">
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label"
                                    for="resikoJatuh_diagnosa_ya">
                                    b. Ya
                                    <span
                                        class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor:
                                        15</span>
                                </label>
                            </div>
                        </div>

                        <!-- Bantuan Ambulasi -->
                        <div class="resiko_jatuh__criteria-section">
                            <label class="resiko_jatuh__font-weight-bold">3. Bantuan Ambulasi:</label>
                            <div class="form-check resiko_jatuh__criteria-form-check" data-group="bantuan_ambulasi">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="bantuan_ambulasi" id="resikoJatuh_ambulasi_tidak" value="0" required>
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label"
                                    for="resikoJatuh_ambulasi_tidak">
                                    a. Tidak ada / bed rest / bantuan perawat
                                    <span
                                        class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor:
                                        0</span>
                                </label>
                            </div>
                            <div class="form-check resiko_jatuh__criteria-form-check" data-group="bantuan_ambulasi">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="bantuan_ambulasi" id="resikoJatuh_ambulasi_kruk" value="15">
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label"
                                    for="resikoJatuh_ambulasi_kruk">
                                    b. Kruk / tongkat / alat bantu berjalan
                                    <span
                                        class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor:
                                        15</span>
                                </label>
                            </div>
                            <div class="form-check resiko_jatuh__criteria-form-check" data-group="bantuan_ambulasi">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="bantuan_ambulasi" id="resikoJatuh_ambulasi_meja" value="30">
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label"
                                    for="resikoJatuh_ambulasi_meja">
                                    c. Meja / kursi
                                    <span
                                        class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor:
                                        30</span>
                                </label>
                            </div>
                        </div>

                        <!-- Terpasang Infus -->
                        <div class="resiko_jatuh__criteria-section">
                            <label class="resiko_jatuh__font-weight-bold">4. Terpasang Infus:</label>
                            <div class="form-check resiko_jatuh__criteria-form-check" data-group="terpasang_infus">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="terpasang_infus" id="resikoJatuh_infus_tidak" value="0" required>
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label"
                                    for="resikoJatuh_infus_tidak">
                                    a. Tidak
                                    <span
                                        class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor:
                                        0</span>
                                </label>
                            </div>
                            <div class="form-check resiko_jatuh__criteria-form-check" data-group="terpasang_infus">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="terpasang_infus" id="resikoJatuh_infus_ya" value="20">
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label"
                                    for="resikoJatuh_infus_ya">
                                    b. Ya
                                    <span
                                        class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor:
                                        20</span>
                                </label>
                            </div>
                        </div>

                        <!-- Cara/Gaya Berjalan -->
                        <div class="resiko_jatuh__criteria-section">
                            <label class="resiko_jatuh__font-weight-bold">5. Cara / gaya berjalan:</label>
                            <div class="form-check resiko_jatuh__criteria-form-check" data-group="gaya_berjalan">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="gaya_berjalan" id="resikoJatuh_berjalan_normal" value="0" required>
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label"
                                    for="resikoJatuh_berjalan_normal">
                                    a. Normal / bed rest / kursi roda
                                    <span
                                        class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor:
                                        0</span>
                                </label>
                            </div>
                            <div class="form-check resiko_jatuh__criteria-form-check" data-group="gaya_berjalan">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="gaya_berjalan" id="resikoJatuh_berjalan_lemah" value="10">
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label"
                                    for="resikoJatuh_berjalan_lemah">
                                    b. Lemah
                                    <span
                                        class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor:
                                        10</span>
                                </label>
                            </div>
                            <div class="form-check resiko_jatuh__criteria-form-check" data-group="gaya_berjalan">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="gaya_berjalan" id="resikoJatuh_berjalan_terganggu" value="20">
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label"
                                    for="resikoJatuh_berjalan_terganggu">
                                    c. Terganggu
                                    <span
                                        class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor:
                                        20</span>
                                </label>
                            </div>
                        </div>

                        <!-- Status Mental -->
                        <div class="resiko_jatuh__criteria-section">
                            <label class="resiko_jatuh__font-weight-bold">6. Status Mental:</label>
                            <div class="form-check resiko_jatuh__criteria-form-check" data-group="status_mental">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="status_mental" id="resikoJatuh_mental_orientasi" value="0" required>
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label"
                                    for="resikoJatuh_mental_orientasi">
                                    a. Berorientasi pada kemampuannya
                                    <span
                                        class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor:
                                        0</span>
                                </label>
                            </div>
                            <div class="form-check resiko_jatuh__criteria-form-check" data-group="status_mental">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="status_mental" id="resikoJatuh_mental_lupa" value="15">
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label"
                                    for="resikoJatuh_mental_lupa">
                                    b. Lupa akan keterbatasannya
                                    <span
                                        class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor:
                                        15</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Hasil Skor -->
                    <div class="resiko_jatuh__section-separator">
                        <h5><i class="ti-stats-up mr-2"></i>Hasil Penilaian</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card resiko_jatuh__card resiko_jatuh__result-card bg-light">
                                    <div class="card-body">
                                        <h5>SKOR TOTAL</h5>
                                        <div id="resikoJatuh_skorTotal" class="resiko_jatuh__score-total">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card resiko_jatuh__card resiko_jatuh__result-card" id="resikoJatuh_hasilResiko">
                                    <div class="card-body">
                                        <h5>Kategori Resiko</h5>
                                        <h4 id="resikoJatuh_kategoriResiko">Belum Dinilai</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="skor_total" id="resikoJatuh_skorTotalInput" value="0">
                        <input type="hidden" name="kategori_resiko" id="resikoJatuh_kategoriResikoInput" value="">
                    </div>


                    <!-- INTERVENSI RESIKO RENDAH (RR) -->
                    <div class="resiko_jatuh__section-separator resiko_jatuh__intervensi-rr" id="resikoJatuh_intervensiRR"
                        style="display: none;">
                        <h5><i class="ti-shield mr-2"></i> INTERVENSI PENCEGAHAN JATUH - RESIKO RENDAH/STANDAR (RR)</h5>

                        <div class="alert alert-success">
                            <strong><i class="ti-info-alt mr-2"></i>INFORMASI:</strong>
                            Beri tanda cek (√) pada tindakan yang dilakukan <br>
                            1. RT: intervensi setiap shift dan dinilai ulang setiap 2 hari) <br>
                            2. RS: intervensi setiap pagi dan dinilai ulang tiap 3 hari) <br>
                            3. RR: intervensi setiap pagi dan dinilai ulang tiap 3 hari )
                        </div>

                        <div class="resiko_jatuh__criteria-section">
                            <label class="resiko_jatuh__font-weight-bold text-success">
                                <i class="ti-list mr-2"></i>Pilih Intervensi yang Akan Dilakukan:
                            </label>

                            <div class="form-check resiko_jatuh__criteria-form-check">
                                <input class="form-check-input" type="checkbox" name="intervensi_rr[]" id="rr_intervensi_1"
                                    value="lingkungan_observasi">
                                <label class="form-check-label" for="rr_intervensi_1">
                                    <strong>1. Tingkatkan observasi bantuan yang sesuai saat ambulasi</strong>
                                </label>
                            </div>

                            <div class="form-check resiko_jatuh__criteria-form-check">
                                <input class="form-check-input" type="checkbox" name="intervensi_rr[]" id="rr_intervensi_2"
                                    value="orientasi_lingkungan">
                                <label class="form-check-label" for="rr_intervensi_2">
                                    <strong>2. Orientasikan pasien terhadap lingkungan dan rutinitas RS:</strong>
                                    <ul class="mt-2 ml-3" style="font-size: 13px;">
                                        <li>a. Tunjukkan lokasi kamar mandi</li>
                                        <li>b. Jika pasien linglung, orientasi dilaksanakan bertahap</li>
                                        <li>c. Tempatkan bel ditempat yang mudah dicapai</li>
                                        <li>d. Instruksikan meminta bantuan perawat sebelum turun dari tempat tidur</li>
                                    </ul>
                                </label>
                            </div>

                            <div class="form-check resiko_jatuh__criteria-form-check">
                                <input class="form-check-input" type="checkbox" name="intervensi_rr[]" id="rr_intervensi_3"
                                    value="pagar_pengaman">
                                <label class="form-check-label" for="rr_intervensi_3">
                                    <strong>3. Pagar pengaman tempat tidur dinaikkan</strong>
                                </label>
                            </div>

                            <div class="form-check resiko_jatuh__criteria-form-check">
                                <input class="form-check-input" type="checkbox" name="intervensi_rr[]" id="rr_intervensi_4"
                                    value="tempat_tidur_rendah">
                                <label class="form-check-label" for="rr_intervensi_4">
                                    <strong>4. Tempat tidur dalam posisi rendah terkunci</strong>
                                </label>
                            </div>

                            <div class="form-check resiko_jatuh__criteria-form-check">
                                <input class="form-check-input" type="checkbox" name="intervensi_rr[]" id="rr_intervensi_5"
                                    value="tunjuk_perilaku_aman">
                                <label class="form-check-label" for="rr_intervensi_5">
                                    <strong>5. Edukasi perilaku yang lebih aman saat jatuh atau transfer</strong>
                                </label>
                            </div>

                            <div class="form-check resiko_jatuh__criteria-form-check">
                                <input class="form-check-input" type="checkbox" name="intervensi_rr[]" id="rr_intervensi_6"
                                    value="monitor_berkala">
                                <label class="form-check-label" for="rr_intervensi_6">
                                    <strong>6. Monitor kebutuhan pasien secara berkala (minimalnya tiap 2 jam)</strong>
                                </label>
                            </div>

                            <div class="form-check resiko_jatuh__criteria-form-check">
                                <input class="form-check-input" type="checkbox" name="intervensi_rr[]" id="rr_intervensi_7"
                                    value="anjurkan_tidak_menggunakan">
                                <label class="form-check-label" for="rr_intervensi_7">
                                    <strong>7. Anjurkan pasien tidak menggunakan kaus kaki atau sepatu yang licin</strong>
                                </label>
                            </div>

                            <div class="form-check resiko_jatuh__criteria-form-check">
                                <input class="form-check-input" type="checkbox" name="intervensi_rr[]" id="rr_intervensi_8"
                                    value="lantai_kamar_mandi">
                                <label class="form-check-label" for="rr_intervensi_8">
                                    <strong>8. Lantai kamar mandi dengan karpet antislip, tidak licin</strong>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- INTERVENSI RESIKO SEDANG (RS) -->
                    <div class="resiko_jatuh__section-separator resiko_jatuh__intervensi-rs" id="resikoJatuh_intervensiRS"
                        style="display: none;">
                        <h5><i class="ti-alert mr-2"></i>INTERVENSI PENCEGAHAN JATUH - RESIKO SEDANG (RS)</h5>

                        <div class="alert alert-warning">
                            <strong><i class="ti-info-alt mr-2"></i>PERHATIAN:</strong>
                            Beri tanda cek (√) pada tindakan yang dilakukan <br>
                            1. RT: intervensi setiap shift dan dinilai ulang setiap 2 hari) <br>
                            2. RS: intervensi setiap pagi dan dinilai ulang tiap 3 hari) <br>
                            3. RR: intervensi setiap pagi dan dinilai ulang tiap 3 hari )
                        </div>

                        <div class="resiko_jatuh__criteria-section">
                            <label class="resiko_jatuh__font-weight-bold text-warning">
                                <i class="ti-list mr-2"></i>Pilih Intervensi yang Akan Dilakukan:
                            </label>

                            <div class="form-check resiko_jatuh__criteria-form-check">
                                <input class="form-check-input" type="checkbox" name="intervensi_rs[]" id="rs_intervensi_1"
                                    value="lakukan_semua_intervensi_rendah">
                                <label class="form-check-label" for="rs_intervensi_1">
                                    <strong>1. Lakukan <span class="text-bold">SEMUA</span> intervensi jatuh resiko rendah /
                                        standar</strong>
                                </label>
                            </div>

                            <div class="form-check resiko_jatuh__criteria-form-check">
                                <input class="form-check-input" type="checkbox" name="intervensi_rs[]" id="rs_intervensi_2"
                                    value="pakai_gelang_risiko">
                                <label class="form-check-label" for="rs_intervensi_2">
                                    <strong>2. Pakailah gelang risiko jatuh berwarna kuning</strong>
                                </label>
                            </div>

                            <div class="form-check resiko_jatuh__criteria-form-check">
                                <input class="form-check-input" type="checkbox" name="intervensi_rs[]" id="rs_intervensi_3"
                                    value="pasang_gambar_risiko">
                                <label class="form-check-label" for="rs_intervensi_3">
                                    <strong>3. Pasang gambar risiko jatuh diatas tempat tidur pasien dan pada pintu kamar
                                        pasien</strong>
                                </label>
                            </div>

                            <div class="form-check resiko_jatuh__criteria-form-check">
                                <input class="form-check-input" type="checkbox" name="intervensi_rs[]" id="rs_intervensi_4"
                                    value="tempatkan_risiko_jatuh">
                                <label class="form-check-label" for="rs_intervensi_4">
                                    <strong>4. Tempatkan tanda resiko pasien jatuh pada daftar nama pasein (warna
                                        kuning)</strong>
                                </label>
                            </div>

                            <div class="form-check resiko_jatuh__criteria-form-check">
                                <input class="form-check-input" type="checkbox" name="intervensi_rs[]" id="rs_intervensi_5"
                                    value="pertimbangkan_riwayat_obat">
                                <label class="form-check-label" for="rs_intervensi_5">
                                    <strong>5. Pertimbangkan riwayat obat-obatan dan suplemen untuk mengevaluasi
                                        pengobatan</strong>
                                </label>
                            </div>

                            <div class="form-check resiko_jatuh__criteria-form-check">
                                <input class="form-check-input" type="checkbox" name="intervensi_rs[]" id="rs_intervensi_6"
                                    value="gunakan_alat_bantu">
                                <label class="form-check-label" for="rs_intervensi_6">
                                    <strong>6. Gunakan alat bantu jalan (walker, handrail)</strong>
                                </label>
                            </div>

                            <div class="form-check resiko_jatuh__criteria-form-check">
                                <input class="form-check-input" type="checkbox" name="intervensi_rs[]" id="rs_intervensi_7"
                                    value="dorong_partisipasi_keluarga">
                                <label class="form-check-label" for="rs_intervensi_7">
                                    <strong>7. Dorong partisipasi keluarga dalam keselamatan pasien</strong>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- INTERVENSI RESIKO TINGGI (RT) -->
                    <div class="resiko_jatuh__section-separator resiko_jatuh__intervensi-rt" id="resikoJatuh_intervensiRT"
                        style="display: none;">
                        <h5><i class="ti-alert mr-2"></i>INTERVENSI PENCEGAHAN JATUH - RESIKO TINGGI (RT)</h5>

                        <div class="alert alert-danger">
                            <strong><i class="ti-info-alt mr-2"></i>PERHATIAN:</strong>
                            Beri tanda cek (√) pada tindakan yang dilakukan <br>
                            1. RT: intervensi setiap shift dan dinilai ulang setiap 2 hari) <br>
                            2. RS: intervensi setiap pagi dan dinilai ulang tiap 3 hari) <br>
                            3. RR: intervensi setiap pagi dan dinilai ulang tiap 3 hari )
                        </div>

                        <div class="resiko_jatuh__criteria-section">
                            <label class="resiko_jatuh__font-weight-bold text-danger">
                                <i class="ti-shield mr-2"></i>Pilih Intervensi yang Akan Dilakukan:
                            </label>

                            <div class="form-check resiko_jatuh__criteria-form-check">
                                <input class="form-check-input" type="checkbox" name="intervensi_rt[]" id="rt_intervensi_1"
                                    value="lakukan_semua_intervensi">
                                <label class="form-check-label" for="rt_intervensi_1">
                                    <strong>1. Lakukan <span class="text-bold">SEMUA</span> intervensi jatuh resiko rendah /
                                        standar dan resiko sedang</strong>
                                </label>
                            </div>

                            <div class="form-check resiko_jatuh__criteria-form-check">
                                <input class="form-check-input" type="checkbox" name="intervensi_rt[]" id="rt_intervensi_2"
                                    value="jangan_tinggalkan_pasien">
                                <label class="form-check-label" for="rt_intervensi_2">
                                    <strong>2. Jangan tinggalkan pasien saat di ruangan diagnostic atau tindakan</strong>
                                </label>
                            </div>

                            <div class="form-check resiko_jatuh__criteria-form-check">
                                <input class="form-check-input" type="checkbox" name="intervensi_rt[]" id="rt_intervensi_3"
                                    value="penempatan_dekat_nurse_station">
                                <label class="form-check-label" for="rt_intervensi_3">
                                    <strong>3. Penempatan pasien dekat nurse station untuk memudahkan observasi (24-48
                                        jam)</strong>
                                </label>
                            </div>

                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary resiko_jatuh__btn-primary" id="resikoJatuh_simpan">
                            <i class="ti-save mr-2"></i> Simpan
                        </button>
                    </div>
                </div>
            </form>

            <!-- Keterangan -->
            <div class="resiko_jatuh__section-separator mt-3">
                <h5><i class="ti-info mr-2"></i> Keterangan</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="resiko_jatuh__keterangan-box">
                            <h6 class="resiko_jatuh__keterangan-title"><strong>Keterangan :</strong></h6>
                            <ul class="resiko_jatuh__keterangan-list">
                                <li>
                                    <span class="badge resiko_jatuh__badge resiko_jatuh__badge-success mr-2">RR</span>
                                    <strong>Resiko Rendah (0 - 24)</strong>
                                </li>
                                <li>
                                    <span class="badge resiko_jatuh__badge resiko_jatuh__badge-warning mr-2">RS</span>
                                    <strong>Resiko Sedang (25 - 44)</strong>
                                </li>
                                <li>
                                    <span class="badge resiko_jatuh__badge resiko_jatuh__badge-danger mr-2">RT</span>
                                    <strong>Resiko Tinggi (45 dan lebih)</strong>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="resiko_jatuh__keterangan-box">
                            <h6 class="resiko_jatuh__keterangan-title"><strong>Pengkajian resiko jatuh dilakukan pada waktu
                                    :</strong></h6>
                            <ul class="resiko_jatuh__keterangan-list">
                                <li>
                                    <strong>a.</strong> Saat pasien masuk RS / Initial Assessment (IA)
                                </li>
                                <li>
                                    <strong>b.</strong> Saat kondisi pasien berubah atau ada suatu perubahan dalam terapi
                                    medik yang dapat resiko jatuh / Change Of Condition (CC)
                                </li>
                                <li>
                                    <strong>c.</strong> Saat pasien dipindahkan ke Unit lain / on Ward Transfer (WT)
                                </li>
                                <li>
                                    <strong>d.</strong> Setelah kejadian jatuh / Post Fall (PF)
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            // Fungsi untuk menghitung skor total
            function hitungSkorTotal() {
                let total = 0;

                // Mengambil nilai dari setiap radio button yang dipilih
                const riwayatJatuh = $('input[name="riwayat_jatuh"]:checked').val() || 0;
                const diagnosaSekunder = $('input[name="diagnosa_sekunder"]:checked').val() || 0;
                const bantuanAmbulasi = $('input[name="bantuan_ambulasi"]:checked').val() || 0;
                const terpasangInfus = $('input[name="terpasang_infus"]:checked').val() || 0;
                const gayaBerjalan = $('input[name="gaya_berjalan"]:checked').val() || 0;
                const statusMental = $('input[name="status_mental"]:checked').val() || 0;

                total = parseInt(riwayatJatuh) + parseInt(diagnosaSekunder) + parseInt(bantuanAmbulasi) +
                    parseInt(terpasangInfus) + parseInt(gayaBerjalan) + parseInt(statusMental);

                // Update tampilan skor dengan animasi
                $('#resikoJatuh_skorTotal').text(total);

                // **TAMBAHAN PENTING: Update input hidden untuk skor total**
                $('#resikoJatuh_skorTotalInput').val(total);

                // Sembunyikan semua section intervensi terlebih dahulu
                $('#resikoJatuh_intervensiRR, #resikoJatuh_intervensiRS, #resikoJatuh_intervensiRT').hide();

                // Tentukan kategori resiko dan warna
                let kategori = '';
                let kategoriLengkap = '';
                let cardClass = '';
                let kodeResiko = '';

                if (total >= 0 && total <= 24) {
                    kategori = 'RESIKO RENDAH';
                    kodeResiko = 'RR';
                    kategoriLengkap = 'RR';
                    cardClass = 'bg-success text-white';
                    // Tampilkan intervensi RR dengan animasi
                    $('#resikoJatuh_intervensiRR').show().addClass('resiko_jatuh__fade-in');
                } else if (total >= 25 && total <= 44) {
                    kategori = 'RESIKO SEDANG';
                    kodeResiko = 'RS';
                    kategoriLengkap = 'RS';
                    cardClass = 'bg-warning text-dark';
                    // Tampilkan intervensi RS dengan animasi
                    $('#resikoJatuh_intervensiRS').show().addClass('resiko_jatuh__fade-in');
                } else if (total >= 45) {
                    kategori = 'RESIKO TINGGI';
                    kodeResiko = 'RT';
                    kategoriLengkap = 'RT';
                    cardClass = 'bg-danger text-white';
                    // Tampilkan intervensi RT dengan animasi
                    $('#resikoJatuh_intervensiRT').show().addClass('resiko_jatuh__fade-in');
                }

                // Update tampilan kategori
                $('#resikoJatuh_kategoriResiko').text(`${kategori} (${kodeResiko})`);
                $('#resikoJatuh_hasilResiko').removeClass('bg-success bg-warning bg-danger text-white text-dark').addClass(cardClass);

                // **TAMBAHAN PENTING: Update input hidden untuk kategori resiko**
                $('#resikoJatuh_kategoriResikoInput').val(kategoriLengkap);
            }

            // Event listener untuk radio button dengan efek visual
            $('input[type="radio"]').on('change', function () {
                const group = $(this).attr('name');

                // Remove selected class from all form-check in the same group
                $(`.resiko_jatuh__form-check[data-group="${group}"], .resiko_jatuh__criteria-form-check[data-group="${group}"]`).removeClass('selected');

                // Add selected class to the clicked form-check
                $(this).closest('.resiko_jatuh__form-check, .resiko_jatuh__criteria-form-check').addClass('selected');

                // Hitung ulang skor
                hitungSkorTotal();
            });

            // Event listener untuk checkbox intervensi
            $('input[name^="intervensi_"]').on('change', function () {
                const checkbox = $(this);
                const formCheck = checkbox.closest('.resiko_jatuh__criteria-form-check');

                if (checkbox.is(':checked')) {
                    formCheck.addClass('selected');
                } else {
                    formCheck.removeClass('selected');
                }
            });

            // Tambahkan efek hover dan klik pada form-check
            $('.resiko_jatuh__form-check, .resiko_jatuh__criteria-form-check').on('click', function () {
                const radio = $(this).find('input[type="radio"]');
                const checkbox = $(this).find('input[type="checkbox"]');

                if (radio.length && !radio.prop('checked')) {
                    radio.prop('checked', true).trigger('change');
                } else if (checkbox.length) {
                    checkbox.prop('checked', !checkbox.prop('checked')).trigger('change');
                }
            });

            // Hitung skor awal
            hitungSkorTotal();

            // Validasi form dengan notifikasi yang lebih baik
            $('#resikoJatuh_form').on('submit', function (e) {
                const requiredFields = ['riwayat_jatuh', 'diagnosa_sekunder', 'bantuan_ambulasi', 'terpasang_infus', 'gaya_berjalan', 'status_mental'];
                let allAnswered = true;
                let missingFields = [];

                requiredFields.forEach(function (field) {
                    if (!$('input[name="' + field + '"]:checked').length) {
                        allAnswered = false;
                        missingFields.push(field);
                    }
                });

                // **TAMBAHAN: Pastikan skor total dan kategori terisi sebelum submit**
                const skorTotal = $('#resikoJatuh_skorTotalInput').val();
                const kategoriResiko = $('#resikoJatuh_kategoriResikoInput').val();

                if (!skorTotal || skorTotal === '0' || !kategoriResiko) {
                    e.preventDefault();
                    alert('Mohon lengkapi semua penilaian terlebih dahulu!');
                    return false;
                }

                // Validasi khusus berdasarkan kategori resiko yang muncul
                if ($('#resikoJatuh_intervensiRR').is(':visible')) {
                    // Validasi untuk RR
                    if (!$('input[name="intervensi_rr[]"]:checked').length) {
                        allAnswered = false;
                        alert('Untuk pasien dengan resiko rendah, wajib memilih minimal 1 intervensi pencegahan!');
                        $('#resikoJatuh_intervensiRR').css({
                            'border': '2px solid #dc3545',
                            'background': '#f8d7da'
                        });

                        setTimeout(function () {
                            $('#resikoJatuh_intervensiRR').css({
                                'border': '1px solid #e9ecef',
                                'background': ''
                            });
                        }, 3000);

                        return false;
                    }
                }

                if ($('#resikoJatuh_intervensiRS').is(':visible')) {
                    // Validasi untuk RS
                    if (!$('input[name="intervensi_rs[]"]:checked').length) {
                        allAnswered = false;
                        alert('Untuk pasien dengan resiko sedang, wajib memilih minimal 1 intervensi pencegahan!');
                        $('#resikoJatuh_intervensiRS').css({
                            'border': '2px solid #dc3545',
                            'background': '#f8d7da'
                        });

                        setTimeout(function () {
                            $('#resikoJatuh_intervensiRS').css({
                                'border': '1px solid #e9ecef',
                                'background': ''
                            });
                        }, 3000);

                        return false;
                    }
                }

                if ($('#resikoJatuh_intervensiRT').is(':visible')) {
                    // Validasi untuk RT
                    if (!$('input[name="intervensi_rt[]"]:checked').length) {
                        allAnswered = false;
                        alert('Untuk pasien dengan resiko tinggi, wajib memilih minimal 1 intervensi pencegahan!');
                        $('#resikoJatuh_intervensiRT').css({
                            'border': '2px solid #dc3545',
                            'background': '#f8d7da'
                        });

                        setTimeout(function () {
                            $('#resikoJatuh_intervensiRT').css({
                                'border': '1px solid #e9ecef',
                                'background': ''
                            });
                        }, 3000);

                        return false;
                    }
                }

                if (!allAnswered) {
                    e.preventDefault();

                    // Highlight missing fields
                    missingFields.forEach(function (field) {
                        $(`input[name="${field}"]`).closest('.resiko_jatuh__criteria-section, .resiko_jatuh__section-separator').css({
                            'border': '2px solid #dc3545',
                            'background': '#f8d7da'
                        });
                    });

                    alert(`Mohon lengkapi ${missingFields.length} kriteria yang belum dinilai!`);

                    // Remove highlight after 3 seconds
                    setTimeout(function () {
                        $('.resiko_jatuh__criteria-section, .resiko_jatuh__section-separator').css({
                            'border': '1px solid #e9ecef',
                            'background': ''
                        });
                    }, 3000);

                    return false;
                }

                // **TAMBAHAN: Debug log untuk memastikan data terkirim**
                console.log('Data yang akan dikirim:');
                console.log('Skor Total:', $('#resikoJatuh_skorTotalInput').val());
                console.log('Kategori Resiko:', $('#resikoJatuh_kategoriResikoInput').val());

                // Show loading state
                $('#resikoJatuh_simpan').prop('disabled', true).html('<i class="ti-reload mr-2"></i> Menyimpan...');
            });
        });
    </script>
@endpush