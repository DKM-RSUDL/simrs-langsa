@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .form-label {
            font-weight: 600;
            margin-bottom: 0.3rem;
            color: #2c3e50;
        }

        .header-asesmen {
            margin-top: 0.5rem;
            font-size: 1.5rem;
            font-weight: 600;
            color: #00223b;
            text-align: center;
            margin-bottom: 1rem;
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
            padding: 0.75rem;
            margin-bottom: 0.75rem;
        }

        .section-title {
            font-weight: 600;
            color: #097dd6;
            margin-bottom: 1rem;
            font-size: 1.1rem;
            border-bottom: 2px solid #097dd6;
            padding-bottom: 0.25rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 0.3rem;
            display: block;
        }

        .form-control {
            border-radius: 6px;
            border: 1px solid #ced4da;
            padding: 0.5rem;
            font-size: 0.9rem;
        }

        .form-control:focus {
            border-color: #097dd6;
            box-shadow: 0 0 0 0.2rem rgba(9, 125, 214, 0.25);
        }

        .datetime-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
        }

        .datetime-item label {
            font-weight: 500;
            color: #6c757d;
            font-size: 0.85rem;
        }

        .norton-assessment {
            background-color: #fff;
            border: 2px solid #097dd6;
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .norton-category {
            background-color: white;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .norton-category-title {
            font-weight: 600;
            color: #097dd6;
            margin-bottom: 1rem;
            font-size: 1rem;
            border-bottom: 1px solid #e9ecef;
            padding-bottom: 0.5rem;
        }

        .norton-options {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .norton-option {
            display: flex;
            align-items: flex-start;
            background-color: #f8f9fa;
            padding: 0.75rem;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .norton-option:hover {
            background-color: #e3f2fd;
            border-color: #097dd6;
        }

        .norton-option.selected {
            background-color: #e3f2fd;
            border-color: #097dd6;
            border-width: 2px;
        }

        .norton-option input[type="radio"] {
            margin-right: 0.75rem;
            margin-top: 0.1rem;
            transform: scale(1.3);
            accent-color: #097dd6;
        }

        .norton-description {
            font-size: 0.9rem;
            color: #495057;
            line-height: 1.4;
            flex: 1;
            font-weight: 500;
        }

        .norton-score {
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

        .total-score-display {
            background: linear-gradient(135deg, #097dd6, #0056b3);
            color: white;
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            margin: 1rem 0;
            box-shadow: 0 4px 12px rgba(9, 125, 214, 0.3);
        }

        .total-score-value {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .total-score-text {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .total-score-category {
            font-size: 1rem;
            opacity: 0.9;
        }

        .alert {
            margin-bottom: 0.75rem;
            padding: 0.75rem;
        }

        .form-check {
            margin-bottom: 0.5rem !important;
        }

        .form-check-input {
            margin-top: 0.125rem;
        }

        .form-check-label {
            margin-bottom: 0;
            padding-left: 0.25rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .datetime-group {
                grid-template-columns: 1fr;
            }
            
            .form-section {
                padding: 0.5rem;
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
            <a href="{{ route('resiko-decubitus.index', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}" class="btn btn-outline-primary mb-3">
                <i class="ti-arrow-left"></i> Kembali
            </a>

            <form id="nortonAssessmentForm" method="POST"
                action="{{ route('resiko-decubitus.store', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}">
                @csrf

                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="header-asesmen">Form Pengkajian Resiko Decubitus (Skala Norton)</h4>

                        <!-- Basic Information Section -->
                        <div class="form-section">
                            <h5 class="section-title">Informasi Dasar</h5>
                            
                            <div class="form-group">
                                <label class="form-label">Tanggal dan Jam Implementasi</label>
                                <div class="datetime-group">
                                    <div class="datetime-item">
                                        <label>Tanggal</label>
                                        <input type="date" class="form-control" name="tanggal_implementasi" id="tanggal_implementasi" required>
                                    </div>
                                    <div class="datetime-item">
                                        <label>Jam</label>
                                        <input type="time" class="form-control" name="jam_implementasi" id="jam_implementasi" required>
                                    </div>
                                </div>
                            </div>

                            <div class="datetime-group">
                                <div class="datetime-item">
                                    <label>Hari Ke</label>
                                    <input type="number" class="form-control" id="hari_ke" name="hari_ke" min="1" required>
                                </div>
                                <div class="datetime-item">
                                    <label>Shift</label>
                                    <select class="form-control" id="shift" name="shift" required>
                                        <option value="">Pilih Shift</option>
                                        <option value="1">Pagi</option>
                                        <option value="2">Siang</option>
                                        <option value="3">Malam</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Norton Scale Assessment -->
                        <div class="form-section">
                            <h5 class="section-title">Penilaian Resiko Decubitus (Skala Norton)</h5>
                            
                            <div class="norton-assessment">
                                <!-- 1. Kondisi Fisik -->
                                <div class="norton-category">
                                    <div class="norton-category-title">1. Kondisi Fisik</div>
                                    <div class="norton-options">
                                        <div class="norton-option" data-category="kondisi_fisik" data-score="4">
                                            <input type="radio" name="kondisi_fisik" value="4" id="fisik_4" required>
                                            <div class="norton-description">Baik</div>
                                            <span class="norton-score">4</span>
                                        </div>
                                        <div class="norton-option" data-category="kondisi_fisik" data-score="3">
                                            <input type="radio" name="kondisi_fisik" value="3" id="fisik_3" required>
                                            <div class="norton-description">Sedang</div>
                                            <span class="norton-score">3</span>
                                        </div>
                                        <div class="norton-option" data-category="kondisi_fisik" data-score="2">
                                            <input type="radio" name="kondisi_fisik" value="2" id="fisik_2" required>
                                            <div class="norton-description">Buruk</div>
                                            <span class="norton-score">2</span>
                                        </div>
                                        <div class="norton-option" data-category="kondisi_fisik" data-score="1">
                                            <input type="radio" name="kondisi_fisik" value="1" id="fisik_1" required>
                                            <div class="norton-description">Sangat Buruk</div>
                                            <span class="norton-score">1</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- 2. Status Mental -->
                                <div class="norton-category">
                                    <div class="norton-category-title">2. Status Mental</div>
                                    <div class="norton-options">
                                        <div class="norton-option" data-category="status_mental" data-score="4">
                                            <input type="radio" name="status_mental" value="4" id="mental_4" required>
                                            <div class="norton-description">Sadar</div>
                                            <span class="norton-score">4</span>
                                        </div>
                                        <div class="norton-option" data-category="status_mental" data-score="3">
                                            <input type="radio" name="status_mental" value="3" id="mental_3" required>
                                            <div class="norton-description">Apatis</div>
                                            <span class="norton-score">3</span>
                                        </div>
                                        <div class="norton-option" data-category="status_mental" data-score="2">
                                            <input type="radio" name="status_mental" value="2" id="mental_2" required>
                                            <div class="norton-description">Bingung</div>
                                            <span class="norton-score">2</span>
                                        </div>
                                        <div class="norton-option" data-category="status_mental" data-score="1">
                                            <input type="radio" name="status_mental" value="1" id="mental_1" required>
                                            <div class="norton-description">Stupor</div>
                                            <span class="norton-score">1</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- 3. Aktivitas -->
                                <div class="norton-category">
                                    <div class="norton-category-title">3. Aktivitas</div>
                                    <div class="norton-options">
                                        <div class="norton-option" data-category="aktivitas" data-score="4">
                                            <input type="radio" name="aktivitas" value="4" id="aktivitas_4" required>
                                            <div class="norton-description">Jalan Sendiri</div>
                                            <span class="norton-score">4</span>
                                        </div>
                                        <div class="norton-option" data-category="aktivitas" data-score="3">
                                            <input type="radio" name="aktivitas" value="3" id="aktivitas_3" required>
                                            <div class="norton-description">Jalan dgn Bantuan</div>
                                            <span class="norton-score">3</span>
                                        </div>
                                        <div class="norton-option" data-category="aktivitas" data-score="2">
                                            <input type="radio" name="aktivitas" value="2" id="aktivitas_2" required>
                                            <div class="norton-description">Kursi Roda</div>
                                            <span class="norton-score">2</span>
                                        </div>
                                        <div class="norton-option" data-category="aktivitas" data-score="1">
                                            <input type="radio" name="aktivitas" value="1" id="aktivitas_1" required>
                                            <div class="norton-description">Ditempat tidur</div>
                                            <span class="norton-score">1</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- 4. Mobilitas -->
                                <div class="norton-category">
                                    <div class="norton-category-title">4. Mobilitas</div>
                                    <div class="norton-options">
                                        <div class="norton-option" data-category="mobilitas" data-score="4">
                                            <input type="radio" name="mobilitas" value="4" id="mobilitas_4" required>
                                            <div class="norton-description">Bisa bergerak</div>
                                            <span class="norton-score">4</span>
                                        </div>
                                        <div class="norton-option" data-category="mobilitas" data-score="3">
                                            <input type="radio" name="mobilitas" value="3" id="mobilitas_3" required>
                                            <div class="norton-description">Agak terbatas</div>
                                            <span class="norton-score">3</span>
                                        </div>
                                        <div class="norton-option" data-category="mobilitas" data-score="2">
                                            <input type="radio" name="mobilitas" value="2" id="mobilitas_2" required>
                                            <div class="norton-description">Sangat terbatas</div>
                                            <span class="norton-score">2</span>
                                        </div>
                                        <div class="norton-option" data-category="mobilitas" data-score="1">
                                            <input type="radio" name="mobilitas" value="1" id="mobilitas_1" required>
                                            <div class="norton-description">Tidak bergerak</div>
                                            <span class="norton-score">1</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- 5. Inkontinensia -->
                                <div class="norton-category">
                                    <div class="norton-category-title">5. Inkontinensia</div>
                                    <div class="norton-options">
                                        <div class="norton-option" data-category="inkontinensia" data-score="4">
                                            <input type="radio" name="inkontinensia" value="4" id="inkontinensia_4" required>
                                            <div class="norton-description">Kontinen</div>
                                            <span class="norton-score">4</span>
                                        </div>
                                        <div class="norton-option" data-category="inkontinensia" data-score="3">
                                            <input type="radio" name="inkontinensia" value="3" id="inkontinensia_3" required>
                                            <div class="norton-description">Kadang-kadang inkontinensia urine</div>
                                            <span class="norton-score">3</span>
                                        </div>
                                        <div class="norton-option" data-category="inkontinensia" data-score="2">
                                            <input type="radio" name="inkontinensia" value="2" id="inkontinensia_2" required>
                                            <div class="norton-description">Selalu inkontinensia urine</div>
                                            <span class="norton-score">2</span>
                                        </div>
                                        <div class="norton-option" data-category="inkontinensia" data-score="1">
                                            <input type="radio" name="inkontinensia" value="1" id="inkontinensia_1" required>
                                            <div class="norton-description">Inkontinensia urine dan alvi</div>
                                            <span class="norton-score">1</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Total Score Display -->
                                <div class="total-score-display" id="totalScoreDisplay" style="display: none;">
                                    <div class="total-score-value" id="totalScoreValue">0</div>
                                    <div class="total-score-text">Total Skor Norton</div>
                                    <div class="total-score-category" id="totalScoreCategory">Masukkan nilai untuk setiap kategori</div>
                                </div>

                                <!-- Hidden input for total score -->
                                <input type="hidden" name="norton_total_score" id="norton_total_score" value="0">
                            </div>
                        </div>

                        <!-- Decubitus Intervention Protocol Section -->
                        <div class="form-section" id="decubitusInterventionSection" style="display: none;">
                            <h5 class="section-title">Protokol Intervensi Pencegahan Decubitus</h5>
                            
                            <!-- Intervensi untuk Risiko Rendah -->
                            <div id="decubitusLowRiskInterventions" style="display: none;">
                                <div class="alert alert-success mb-3">
                                    <i class="ti-check-circle"></i> <strong>INTERVENSI RISIKO RENDAH/STANDAR (SKOR 16-20)</strong>
                                </div>
                                
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="rr_kaji_ulang" name="rr_kaji_ulang" value="1">
                                        <label class="form-check-label" for="rr_kaji_ulang">
                                            Lakukan pengkajian ulang setiap hari atau jika ada perubahan kondisi pasien
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="rr_cek_control" name="rr_cek_control" value="1">
                                        <label class="form-check-label" for="rr_cek_control">
                                            Cek kondisi kulit pada area yang tertekan atau lembab setiap hari.
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="rr_kebersihan" name="rr_kebersihan" value="1">
                                        <label class="form-check-label" for="rr_kebersihan">
                                            Pertahankan kebersihan dan kerapihan linen
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="rr_beritahu_pasien" name="rr_beritahu_pasien" value="1">
                                        <label class="form-check-label" for="rr_beritahu_pasien">
                                            Beritahu pasien untuk melaporkan bila ada nyeri pada area yang tertekan atau kulit yang lembab
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="rr_monitor_nutrisi" name="rr_monitor_nutrisi" value="1">
                                        <label class="form-check-label" for="rr_monitor_nutrisi">
                                            Monitor pemasukan nutrisi dan cairan pasien
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="rr_edukasi" name="rr_edukasi" value="1">
                                        <label class="form-check-label" for="rr_edukasi">
                                            Edukasi pasien dan keluarga pasien mengenai pencegahan dekubitus
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Intervensi untuk Risiko Sedang -->
                            <div id="decubitusMediumRiskInterventions" style="display: none;">
                                <div class="alert alert-warning mb-3">
                                    <i class="ti-alert-triangle"></i> <strong>INTERVENSI RISIKO SEDANG (SKOR 12-15)</strong>
                                </div>
                                
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="rs_kaji_ulang" name="rs_kaji_ulang" value="1">
                                        <label class="form-check-label" for="rs_kaji_ulang">
                                            Lakukan pengkajian ulang (dengan skala norton) setiap shift
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="rs_ubah_posisi" name="rs_ubah_posisi" value="1">
                                        <label class="form-check-label" for="rs_ubah_posisi">
                                            Ubah posisi pasien secara teratur, setidaknya 4 jam sekali
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="rs_motivasi" name="rs_motivasi" value="1">
                                        <label class="form-check-label" for="rs_motivasi">
                                            Beri motivasi pasien untuk mobilisasi seaktif mungkin
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="rs_lotion" name="rs_lotion" value="1">
                                        <label class="form-check-label" for="rs_lotion">
                                            Berikan lotion/ skin barrier cream untuk kulit yang kering
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="rs_lindungi_area" name="rs_lindungi_area" value="1">
                                        <label class="form-check-label" for="rs_lindungi_area">
                                            Lindungi area tonjolan tulang yang berisiko untuk terjadi luka tekan
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="rs_alat_penyangga" name="rs_alat_penyangga" value="1">
                                        <label class="form-check-label" for="rs_alat_penyangga">
                                            Gunakan alat penyangga untuk melindungi area tubuh dari tekanan
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="rs_cegah_gesekan" name="rs_cegah_gesekan" value="1">
                                        <label class="form-check-label" for="rs_cegah_gesekan">
                                            Cegah gesekan dengan mengangkat atau mobilisasi pasif dengan benar
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="rs_nutrisi" name="rs_nutrisi" value="1">
                                        <label class="form-check-label" for="rs_nutrisi">
                                           Berikan nutrisi secara adekuat sesuai dengan kebutuhan pasien/ program dietnya
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="rs_keringkan" name="rs_keringkan" value="1">
                                        <label class="form-check-label" for="rs_keringkan">
                                            Keringkan area yang lembab dengan segera
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="rs_edukasi" name="rs_edukasi" value="1">
                                        <label class="form-check-label" for="rs_edukasi">
                                            Edukasi pasien dan keluarga/ care giver pasien mengenai pencegahan dekubitus
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="rs_libatkan_keluarga" name="rs_libatkan_keluarga" value="1">
                                        <label class="form-check-label" for="rs_libatkan_keluarga">
                                            Libatkan keluarga/ care giver dalam program pencegahan dekubitus
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Intervensi untuk Risiko Tinggi -->
                            <div id="decubitusHighRiskInterventions" style="display: none;">
                                <div class="alert alert-danger mb-3">
                                    <i class="ti-alert-triangle"></i> <strong>INTERVENSI RISIKO TINGGI (SKOR < 12)</strong>
                                </div>
                                
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="rt_kaji_ulang" name="rt_kaji_ulang" value="1">
                                        <label class="form-check-label" for="rt_kaji_ulang">
                                            Lakukan pengkajian ulang (dengan skala norton) setiap shift
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="rt_ubah_posisi" name="rt_ubah_posisi" value="1">
                                        <label class="form-check-label" for="rt_ubah_posisi">
                                            Ubah posisi pasien secara teratur, setidaknya 1 - 2 jam sekali
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="rt_motivasi" name="rt_motivasi" value="1">
                                        <label class="form-check-label" for="rt_motivasi">
                                            Beri motivasi pasien untuk mobilisasi seaktif mungkin
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="rt_lotion" name="rt_lotion" value="1">
                                        <label class="form-check-label" for="rt_lotion">
                                            Berikan lotion/ skin barrier cream untuk kulit yang kering
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="rt_lindungi_area" name="rt_lindungi_area" value="1">
                                        <label class="form-check-label" for="rt_lindungi_area">
                                            Lindungi area tonjolan tulang yang berisiko untuk terjadi luka tekan
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="rt_alat_penyangga" name="rt_alat_penyangga" value="1">
                                        <label class="form-check-label" for="rt_alat_penyangga">
                                            Gunakan alat penyangga untuk melindungi area tubuh dari tekanan
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="rt_cegah_gesekan" name="rt_cegah_gesekan" value="1">
                                        <label class="form-check-label" for="rt_cegah_gesekan">
                                            Cegah gesekan dengan mengangkat atau mobilisasi pasif dengan benar
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="rt_nutrisi" name="rt_nutrisi" value="1">
                                        <label class="form-check-label" for="rt_nutrisi">
                                            Berikan nutrisi secara adekuat sesuai dengan kebutuhan pasien/ program dietnya
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="rt_keringkan" name="rt_keringkan" value="1">
                                        <label class="form-check-label" for="rt_keringkan">
                                            Keringkan area yang lembab dengan segera
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="rt_posisi_miring" name="rt_posisi_miring" value="1">
                                        <label class="form-check-label" for="rt_posisi_miring">
                                            Pengaturan posisi miring 30° dengan menggunakan bantuan bantal busa
                                        </label>
                                    </div>

                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="rt_matras_khusus" name="rt_matras_khusus" value="1">
                                        <label class="form-check-label" for="rt_matras_khusus">
                                            Gunakan matras khusus untuk terjadi luka tekan
                                        </label>
                                    </div>

                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="rt_edukasi" name="rt_edukasi" value="1">
                                        <label class="form-check-label" for="rt_edukasi">
                                            Edukasi pasien dan keluarga care giver mengenai pencegahan dekubitus
                                        </label>
                                    </div>

                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="rt_libatkan_keluarga" name="rt_libatkan_keluarga" value="1">
                                        <label class="form-check-label" for="rt_libatkan_keluarga">
                                            Libatkan keluarga/ care giver dalam program pencegahan dekubitus
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary btn-l px-2" id="simpan">
                                <i class="ti-save mr-2"></i> Simpan Data
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            // Set current date and time
            const now = new Date();
            $('#tanggal_implementasi').val(now.toISOString().split('T')[0]);
            $('#jam_implementasi').val(now.toTimeString().slice(0, 5));

            // Add click handler for norton items
            $('.norton-option').on('click', function() {
                const category = $(this).data('category');
                
                // Update radio button
                $(`input[name="${category}"]`).prop('checked', false);
                $(this).find('input[type="radio"]').prop('checked', true);
                
                // Update visual selection
                $(`.norton-option[data-category="${category}"]`).removeClass('selected');
                $(this).addClass('selected');
                
                // Calculate total score
                calculateTotalScore();
            });

            // Event listener for checkbox styling
            $('.form-check-input').on('change', function() {
                if ($(this).is(':checked')) {
                    $(this).next('.form-check-label').addClass('text-primary');
                } else {
                    $(this).next('.form-check-label').removeClass('text-primary');
                }
            });

            $('#tanggal_implementasi, #shift, #hari_ke').on('change', function() {
                checkDuplicateDateTime();
            });

            $('#simpan').on('propertychange change', function() {
                if ($(this).prop('disabled')) {
                    $(this).addClass('btn-secondary').removeClass('btn-primary');
                    $(this).html('<i class="ti-ban mr-2"></i> Data Sudah Ada');
                } else {
                    $(this).addClass('btn-primary').removeClass('btn-secondary');
                    $(this).html('<i class="ti-save mr-2"></i> Simpan Data');
                }
            });

            if (!$('style:contains("btn-secondary")').length) {
                $('<style>').text(`
                    .btn-secondary {
                        background-color: #6c757d !important;
                        border-color: #6c757d !important;
                        color: white !important;
                    }
                    .btn-secondary:hover {
                        background-color: #5a6268 !important;
                        border-color: #5a6268 !important;
                    }
                `).appendTo('head');
            }

        });

        function checkDuplicateDateTime() {
            const tanggal = $('#tanggal_implementasi').val();
            const shift = $('#shift').val();
            const hariKe = $('#hari_ke').val();
            
            if (tanggal && shift && hariKe) {
                // AJAX call untuk mengecek duplikasi
                $.ajax({
                    url: "{{ route('resiko-decubitus.check-duplicate', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}",
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        tanggal_implementasi: tanggal,
                        shift: shift,
                        hari_ke: hariKe
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

        function showDuplicateWarning(show) {
            if (show) {
                if ($('#duplicate-warning').length === 0) {
                    const warningHtml = `
                        <div id="duplicate-warning" class="alert alert-warning mt-2" style="border-left: 4px solid #ffc107;">
                            <i class="ti-alert-triangle"></i> 
                            <strong>Peringatan:</strong> Data dengan tanggal, shift, dan hari ke ini sudah ada!
                        </div>
                    `;
                    $('#shift').closest('.datetime-group').after(warningHtml);
                }
                $('#duplicate-warning').show();
            } else {
                $('#duplicate-warning').hide();
            }
        }

        function calculateTotalScore() {
            let totalScore = 0;
            
            // Get scores from each category
            const kondisiFisik = parseInt($('input[name="kondisi_fisik"]:checked').val()) || 0;
            const statusMental = parseInt($('input[name="status_mental"]:checked').val()) || 0;
            const aktivitas = parseInt($('input[name="aktivitas"]:checked').val()) || 0;
            const mobilitas = parseInt($('input[name="mobilitas"]:checked').val()) || 0;
            const inkontinensia = parseInt($('input[name="inkontinensia"]:checked').val()) || 0;
            
            totalScore = kondisiFisik + statusMental + aktivitas + mobilitas + inkontinensia;
            
            // Update hidden input
            $('#norton_total_score').val(totalScore);
            
            // Update display
            updateScoreDisplay(totalScore);
            
            // Show intervention protocol
            showDecubitusInterventionProtocol(totalScore);
        }

        function updateScoreDisplay(totalScore) {
            let category = '';
            let displayColor = '';
            
            if (totalScore >= 16 && totalScore <= 20) {
                category = 'Risiko Rendah';
                displayColor = '#28a745'; // Green
            } else if (totalScore >= 12 && totalScore <= 15) {
                category = 'Risiko Sedang';
                displayColor = '#ffc107'; // Yellow
            } else if (totalScore < 12) {
                category = 'Risiko Tinggi';
                displayColor = '#dc3545'; // Red
            } else {
                category = 'Skor Tidak Valid';
                displayColor = '#6c757d'; // Gray
            }
            
            $('#totalScoreValue').text(totalScore);
            $('#totalScoreCategory').text(category);
            
            // Update display color
            $('.total-score-display').css('background', `linear-gradient(135deg, ${displayColor}, ${displayColor})`);
            
            // Show the display
            $('#totalScoreDisplay').show();
        }

        function showDecubitusInterventionProtocol(totalScore) {
            // Hide all intervention sections first
            $('#decubitusInterventionSection').hide();
            $('#decubitusLowRiskInterventions').hide();
            $('#decubitusMediumRiskInterventions').hide();
            $('#decubitusHighRiskInterventions').hide();
            
            // Show appropriate intervention based on total score
            if (totalScore >= 16 && totalScore <= 20) {
                // Risiko Rendah
                $('#decubitusInterventionSection').show();
                $('#decubitusLowRiskInterventions').show();
            } else if (totalScore >= 12 && totalScore <= 15) {
                // Risiko Sedang
                $('#decubitusInterventionSection').show();
                $('#decubitusMediumRiskInterventions').show();
            } else if (totalScore < 12) {
                // Risiko Tinggi
                $('#decubitusInterventionSection').show();
                $('#decubitusHighRiskInterventions').show();
            }
            // Jika totalScore = 0 atau tidak valid, tidak ada protokol yang ditampilkan
        }
    </script>
@endpush