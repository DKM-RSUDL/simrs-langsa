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

        .cries-assessment {
            background-color: #fff;
            border: 2px solid #097dd6;
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .cries-category {
            background-color: white;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .cries-category-title {
            font-weight: 600;
            color: #097dd6;
            margin-bottom: 1rem;
            font-size: 1rem;
            border-bottom: 1px solid #e9ecef;
            padding-bottom: 0.5rem;
        }

        .cries-options {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .cries-option {
            display: flex;
            align-items: flex-start;
            background-color: #f8f9fa;
            padding: 0.75rem;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .cries-option:hover {
            background-color: #e3f2fd;
            border-color: #097dd6;
        }

        .cries-option.selected {
            background-color: #e3f2fd;
            border-color: #097dd6;
            border-width: 2px;
        }

        .cries-option input[type="radio"] {
            margin-right: 0.75rem;
            margin-top: 0.1rem;
            transform: scale(1.3);
            accent-color: #097dd6;
        }

        .cries-description {
            font-size: 0.9rem;
            color: #495057;
            line-height: 1.4;
            flex: 1;
            font-weight: 500;
        }

        .cries-score {
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

        .menjalar-group {
            display: flex;
            gap: 0.75rem;
            margin-bottom: 0.75rem;
        }

        .menjalar-btn {
            flex: 1;
            padding: 0.5rem;
            border: 2px solid #dee2e6;
            border-radius: 6px;
            background-color: white;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 500;
        }

        .menjalar-btn.selected {
            border-color: #097dd6;
            background-color: #e3f2fd;
            color: #097dd6;
        }

        .menjalar-keterangan {
            margin-top: 0.75rem;
            display: none;
        }

        .menjalar-keterangan.show {
            display: block;
        }

        .radio-group {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 0.75rem;
        }

        .radio-item {
            display: flex;
            align-items: center;
            background-color: white;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            padding: 0.5rem 0.75rem;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 120px;
        }

        .radio-item:hover {
            border-color: #097dd6;
            background-color: #f8f9fa;
        }

        .radio-item input[type="radio"] {
            margin-right: 0.5rem;
            margin-bottom: 0;
            transform: scale(1.2);
            cursor: pointer;
        }

        .radio-item label {
            margin-bottom: 0;
            cursor: pointer;
            font-weight: 500;
            color: #495057;
            flex: 1;
        }

        .radio-item input[type="radio"]:checked + label {
            color: #097dd6;
            font-weight: 600;
        }

        .radio-item:has(input[type="radio"]:checked) {
            border-color: #097dd6;
            background-color: #e3f2fd;
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
            
            .radio-group {
                flex-direction: column;
                gap: 0.25rem;
            }
            
            .radio-item {
                min-width: 100%;
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
            <a href="{{ route('status-nyeri.skala-cries.show', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $skalaCries->id]) }}" class="btn btn-outline-primary mb-3">
                <i class="ti-arrow-left"></i> Kembali
            </a>

            <form id="criesAssessmentForm" method="POST"
                action="{{ route('status-nyeri.skala-cries.update', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $skalaCries->id]) }}">
                @csrf
                @method('PUT')

                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="header-asesmen">Edit Pengkajian Status Nyeri Skala CRIES</h4>

                        <!-- Basic Information Section -->
                        <div class="form-section">
                            <h5 class="section-title">Informasi Dasar</h5>
                            
                            <div class="form-group">
                                <label class="form-label">Tanggal dan Jam Implementasi</label>
                                <div class="datetime-group">
                                    <div class="datetime-item">
                                        <label>Tanggal</label>
                                        <input type="date" class="form-control" name="tanggal_implementasi" id="tanggal_implementasi" 
                                               value="{{ old('tanggal_implementasi', \Carbon\Carbon::parse($skalaCries->tanggal_implementasi)->format('Y-m-d')) }}" required>
                                    </div>
                                    <div class="datetime-item">
                                        <label>Jam</label>
                                        <input type="time" class="form-control" name="jam_implementasi" id="jam_implementasi" 
                                               value="{{ old('jam_implementasi', \Carbon\Carbon::parse($skalaCries->jam_implementasi)->format('H:i')) }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- CRIES Scale Assessment -->
                        <div class="form-section">
                            <h5 class="section-title">Penilaian Skala CRIES</h5>
                            
                            <div class="cries-assessment">
                                <!-- 1. Crying (Tangisan Melengking) -->
                                <div class="cries-category">
                                    <div class="cries-category-title">1. Crying (Tangisan Melengking)</div>
                                    <div class="cries-options">
                                        <div class="cries-option {{ old('crying', $skalaCries->crying) == '0' ? 'selected' : '' }}" data-category="crying" data-score="0">
                                            <input type="radio" name="crying" value="0" id="crying_0" {{ old('crying', $skalaCries->crying) == '0' ? 'checked' : '' }} required>
                                            <div class="cries-description">Tidak menangis atau tangisan tidak melengking</div>
                                            <span class="cries-score">0</span>
                                        </div>
                                        <div class="cries-option {{ old('crying', $skalaCries->crying) == '1' ? 'selected' : '' }}" data-category="crying" data-score="1">
                                            <input type="radio" name="crying" value="1" id="crying_1" {{ old('crying', $skalaCries->crying) == '1' ? 'checked' : '' }} required>
                                            <div class="cries-description">Tangisan melengking tetapi mudah dihubur</div>
                                            <span class="cries-score">1</span>
                                        </div>
                                        <div class="cries-option {{ old('crying', $skalaCries->crying) == '2' ? 'selected' : '' }}" data-category="crying" data-score="2">
                                            <input type="radio" name="crying" value="2" id="crying_2" {{ old('crying', $skalaCries->crying) == '2' ? 'checked' : '' }} required>
                                            <div class="cries-description">Tangisan melengking dan tidak mudah dihubur</div>
                                            <span class="cries-score">2</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- 2. Requires (Kebutuhan Oksigen) -->
                                <div class="cries-category">
                                    <div class="cries-category-title">2. Requires (Kebutuhan Oksigen)</div>
                                    <div class="cries-options">
                                        <div class="cries-option {{ old('requires', $skalaCries->requires) == '0' ? 'selected' : '' }}" data-category="requires" data-score="0">
                                            <input type="radio" name="requires" value="0" id="requires_0" {{ old('requires', $skalaCries->requires) == '0' ? 'checked' : '' }} required>
                                            <div class="cries-description">Tidak membutuhkan O2 ekstra</div>
                                            <span class="cries-score">0</span>
                                        </div>
                                        <div class="cries-option {{ old('requires', $skalaCries->requires) == '1' ? 'selected' : '' }}" data-category="requires" data-score="1">
                                            <input type="radio" name="requires" value="1" id="requires_1" {{ old('requires', $skalaCries->requires) == '1' ? 'checked' : '' }} required>
                                            <div class="cries-description">Membutuhkan oksigen < 30%</div>
                                            <span class="cries-score">1</span>
                                        </div>
                                        <div class="cries-option {{ old('requires', $skalaCries->requires) == '2' ? 'selected' : '' }}" data-category="requires" data-score="2">
                                            <input type="radio" name="requires" value="2" id="requires_2" {{ old('requires', $skalaCries->requires) == '2' ? 'checked' : '' }} required>
                                            <div class="cries-description">Membutuhkan oksigen > 30%</div>
                                            <span class="cries-score">2</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- 3. Increased (Peningkatan Tanda-tanda Vital) -->
                                <div class="cries-category">
                                    <div class="cries-category-title">3. Increased (Peningkatan Tanda-tanda Vital)</div>
                                    <div class="cries-options">
                                        <div class="cries-option {{ old('increased', $skalaCries->increased) == '0' ? 'selected' : '' }}" data-category="increased" data-score="0">
                                            <input type="radio" name="increased" value="0" id="increased_0" {{ old('increased', $skalaCries->increased) == '0' ? 'checked' : '' }} required>
                                            <div class="cries-description">Berdenyut Jantung dan TD tidak mengalami perubahan</div>
                                            <span class="cries-score">0</span>
                                        </div>
                                        <div class="cries-option {{ old('increased', $skalaCries->increased) == '1' ? 'selected' : '' }}" data-category="increased" data-score="1">
                                            <input type="radio" name="increased" value="1" id="increased_1" {{ old('increased', $skalaCries->increased) == '1' ? 'checked' : '' }} required>
                                            <div class="cries-description">Denyut jantung dan TD meningkat < 20% dari baseline</div>
                                            <span class="cries-score">1</span>
                                        </div>
                                        <div class="cries-option {{ old('increased', $skalaCries->increased) == '2' ? 'selected' : '' }}" data-category="increased" data-score="2">
                                            <input type="radio" name="increased" value="2" id="increased_2" {{ old('increased', $skalaCries->increased) == '2' ? 'checked' : '' }} required>
                                            <div class="cries-description">Denyut jantung dan TD meningkat > 20% dari baseline</div>
                                            <span class="cries-score">2</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- 4. Expression (Wajah) -->
                                <div class="cries-category">
                                    <div class="cries-category-title">4. Expression (Wajah)</div>
                                    <div class="cries-options">
                                        <div class="cries-option {{ old('expression', $skalaCries->expression) == '0' ? 'selected' : '' }}" data-category="expression" data-score="0">
                                            <input type="radio" name="expression" value="0" id="expression_0" {{ old('expression', $skalaCries->expression) == '0' ? 'checked' : '' }} required>
                                            <div class="cries-description">Tidak ada seringai</div>
                                            <span class="cries-score">0</span>
                                        </div>
                                        <div class="cries-option {{ old('expression', $skalaCries->expression) == '1' ? 'selected' : '' }}" data-category="expression" data-score="1">
                                            <input type="radio" name="expression" value="1" id="expression_1" {{ old('expression', $skalaCries->expression) == '1' ? 'checked' : '' }} required>
                                            <div class="cries-description">Seringai ada</div>
                                            <span class="cries-score">1</span>
                                        </div>
                                        <div class="cries-option {{ old('expression', $skalaCries->expression) == '2' ? 'selected' : '' }}" data-category="expression" data-score="2">
                                            <input type="radio" name="expression" value="2" id="expression_2" {{ old('expression', $skalaCries->expression) == '2' ? 'checked' : '' }} required>
                                            <div class="cries-description">Seringai ada dan tidak ada tangisan dengkur</div>
                                            <span class="cries-score">2</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- 5. Sleepless (Sulit Tidur) -->
                                <div class="cries-category">
                                    <div class="cries-category-title">5. Sleepless (Sulit Tidur)</div>
                                    <div class="cries-options">
                                        <div class="cries-option {{ old('sleepless', $skalaCries->sleepless) == '0' ? 'selected' : '' }}" data-category="sleepless" data-score="0">
                                            <input type="radio" name="sleepless" value="0" id="sleepless_0" {{ old('sleepless', $skalaCries->sleepless) == '0' ? 'checked' : '' }} required>
                                            <div class="cries-description">Terus menerus tidur</div>
                                            <span class="cries-score">0</span>
                                        </div>
                                        <div class="cries-option {{ old('sleepless', $skalaCries->sleepless) == '1' ? 'selected' : '' }}" data-category="sleepless" data-score="1">
                                            <input type="radio" name="sleepless" value="1" id="sleepless_1" {{ old('sleepless', $skalaCries->sleepless) == '1' ? 'checked' : '' }} required>
                                            <div class="cries-description">Terbangun pada interval berulang</div>
                                            <span class="cries-score">1</span>
                                        </div>
                                        <div class="cries-option {{ old('sleepless', $skalaCries->sleepless) == '2' ? 'selected' : '' }}" data-category="sleepless" data-score="2">
                                            <input type="radio" name="sleepless" value="2" id="sleepless_2" {{ old('sleepless', $skalaCries->sleepless) == '2' ? 'checked' : '' }} required>
                                            <div class="cries-description">Terjaga / terbangun terus menerus</div>
                                            <span class="cries-score">2</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Total Score Display -->
                                <div class="total-score-display" id="totalScoreDisplay">
                                    <div class="total-score-value" id="totalScoreValue">{{ $skalaCries->pain_value }}</div>
                                    <div class="total-score-text">Total Skor CRIES</div>
                                    <div class="total-score-category" id="totalScoreCategory"></div>
                                </div>

                                <!-- Hidden input for total score -->
                                <input type="hidden" name="pain_value" id="pain_value" value="{{ old('pain_value', $skalaCries->pain_value) }}">
                            </div>
                        </div>

                        <!-- Pain Details Section -->
                        <div class="form-section">
                            <h5 class="section-title">Detail Nyeri</h5>
                            
                            <div class="form-group">
                                <label class="form-label">Lokasi Nyeri</label>
                                <input type="text" class="form-control" name="lokasi_nyeri" id="lokasi_nyeri" 
                                       value="{{ old('lokasi_nyeri', $skalaCries->lokasi_nyeri) }}" 
                                       placeholder="Contoh: Kepala, Dada, Perut..." required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Durasi Nyeri (dalam menit)</label>
                                <input type="number" class="form-control" name="durasi_nyeri" id="durasi_nyeri" 
                                       value="{{ old('durasi_nyeri', $skalaCries->durasi_nyeri) }}" 
                                       min="1" placeholder="Contoh: 30" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Apakah nyeri menjalar?</label>
                                <div class="menjalar-group">
                                    <button type="button" class="menjalar-btn {{ old('menjalar', $skalaCries->menjalar) == 'ya' ? 'selected' : '' }}" data-menjalar="ya">Ya</button>
                                    <button type="button" class="menjalar-btn {{ old('menjalar', $skalaCries->menjalar) == 'tidak' ? 'selected' : '' }}" data-menjalar="tidak">Tidak</button>
                                </div>
                                <input type="hidden" name="menjalar" id="menjalar_value" value="{{ old('menjalar', $skalaCries->menjalar) }}" required>
                                
                                <div id="menjalar_keterangan" class="menjalar-keterangan {{ old('menjalar', $skalaCries->menjalar) == 'ya' ? 'show' : '' }}">
                                    <label class="form-label">Ke : </label>
                                    <input type="text" class="form-control" name="menjalar_keterangan" id="menjalar_keterangan_text" 
                                           value="{{ old('menjalar_keterangan', $skalaCries->menjalar_keterangan) }}" 
                                           placeholder="Contoh: Kepala, Dada, Perut..." 
                                           {{ old('menjalar', $skalaCries->menjalar) == 'ya' ? 'required' : '' }}>
                                </div>
                            </div>
                        </div>

                        <!-- Pain Characteristics Section -->
                        <div class="form-section">
                            <h5 class="section-title">Karakteristik Nyeri</h5>
                            
                            <!-- Kualitas Nyeri -->
                            <div class="form-group">
                                <label class="form-label">Kualitas Nyeri</label>
                                <div class="radio-group">
                                    @foreach($kualitasnyeri as $item)
                                        <div class="radio-item">
                                            <input type="radio" name="kualitas_nyeri" value="{{ $item->id }}" id="kualitas_{{ $item->id }}" 
                                                   {{ old('kualitas_nyeri', $skalaCries->kualitas_nyeri) == $item->id ? 'checked' : '' }} required>
                                            <label for="kualitas_{{ $item->id }}">{{ $item->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Faktor Pemberat -->
                            <div class="form-group">
                                <label class="form-label">Faktor Pemberat</label>
                                <div class="radio-group">
                                    @foreach($faktorpemberat as $item)
                                        <div class="radio-item">
                                            <input type="radio" name="faktor_pemberat" value="{{ $item->id }}" id="pemberat_{{ $item->id }}" 
                                                   {{ old('faktor_pemberat', $skalaCries->faktor_pemberat) == $item->id ? 'checked' : '' }} required>
                                            <label for="pemberat_{{ $item->id }}">{{ $item->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Faktor Peringan -->
                            <div class="form-group">
                                <label class="form-label">Faktor Peringan</label>
                                <div class="radio-group">
                                    @foreach($faktorperingan as $item)
                                        <div class="radio-item">
                                            <input type="radio" name="faktor_peringan" value="{{ $item->id }}" id="peringan_{{ $item->id }}" 
                                                   {{ old('faktor_peringan', $skalaCries->faktor_peringan) == $item->id ? 'checked' : '' }} required>
                                            <label for="peringan_{{ $item->id }}">{{ $item->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Efek Nyeri -->
                            <div class="form-group">
                                <label class="form-label">Efek Nyeri</label>
                                <div class="radio-group">
                                    @foreach($efeknyeri as $item)
                                        <div class="radio-item">
                                            <input type="radio" name="efek_nyeri" value="{{ $item->id }}" id="efek_{{ $item->id }}" 
                                                   {{ old('efek_nyeri', $skalaCries->efek_nyeri) == $item->id ? 'checked' : '' }} required>
                                            <label for="efek_{{ $item->id }}">{{ $item->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Jenis Nyeri -->
                            <div class="form-group">
                                <label class="form-label">Jenis Nyeri</label>
                                <div class="radio-group">
                                    @foreach($jenisnyeri as $item)
                                        <div class="radio-item">
                                            <input type="radio" name="jenis_nyeri" value="{{ $item->id }}" id="jenis_{{ $item->id }}" 
                                                   {{ old('jenis_nyeri', $skalaCries->jenis_nyeri) == $item->id ? 'checked' : '' }} required>
                                            <label for="jenis_{{ $item->id }}">{{ $item->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Frekuensi Nyeri -->
                            <div class="form-group">
                                <label class="form-label">Frekuensi Nyeri</label>
                                <div class="radio-group">
                                    @foreach($frekuensinyeri as $item)
                                        <div class="radio-item">
                                            <input type="radio" name="frekuensi_nyeri" value="{{ $item->id }}" id="frekuensi_{{ $item->id }}" 
                                                   {{ old('frekuensi_nyeri', $skalaCries->frekuensi_nyeri) == $item->id ? 'checked' : '' }} required>
                                            <label for="frekuensi_{{ $item->id }}">{{ $item->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Pain Intervention Protocol Section -->
                        <div class="form-section" id="painInterventionSection">
                            <h5 class="section-title">Protokol Intervensi Status Nyeri</h5>
                            
                            <!-- Intervensi untuk Nyeri Ringan -->
                            <div id="painLightInterventions" style="display: none;">
                                <div class="alert alert-info mb-3">
                                    <i class="ti-info-circle"></i> <strong>Protokol Derajat Nyeri Ringan (Skor 1-3)</strong>
                                </div>
                                
                                <div class="form-group">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="nr_kaji_ulang_8jam" name="nr_kaji_ulang_8jam" value="1"
                                               {{ old('nr_kaji_ulang_8jam', $skalaCries->nr_kaji_ulang_8jam) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="nr_kaji_ulang_8jam">
                                            Kaji ulang nyeri setiap 8 Jam
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="nr_edukasi_pasien" name="nr_edukasi_pasien" value="1"
                                               {{ old('nr_edukasi_pasien', $skalaCries->nr_edukasi_pasien) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="nr_edukasi_pasien">
                                            Edukasi pasien dan keluarga pasien mengenai nyeri
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="nr_teknik_relaksasi" name="nr_teknik_relaksasi" value="1"
                                               {{ old('nr_teknik_relaksasi', $skalaCries->nr_teknik_relaksasi) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="nr_teknik_relaksasi">
                                            Ajarkan tehnik relaksasi seperti tarik nafas dalam & panjang, tehnik distraksi
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="nr_posisi_nyaman" name="nr_posisi_nyaman" value="1"
                                               {{ old('nr_posisi_nyaman', $skalaCries->nr_posisi_nyaman) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="nr_posisi_nyaman">
                                            Beri posisi yang nyaman
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="nr_nsaid" name="nr_nsaid" value="1"
                                               {{ old('nr_nsaid', $skalaCries->nr_nsaid) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="nr_nsaid">
                                            Bila perlu berikan Non Steroid Anti Inflammatory Drugs (NSAID)
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Intervensi untuk Nyeri Sedang -->
                            <div id="painMediumInterventions" style="display: none;">
                                <div class="alert" style="background-color: #fff3cd; color: #856404; border-left: 4px solid #fd7e14;">
                                    <i class="ti-alert-triangle"></i> <strong>Protokol Derajat Nyeri Sedang (Skor 4-7)</strong>
                                </div>
                                
                                <div class="form-group">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="ns_beritahu_tim_nyeri" name="ns_beritahu_tim_nyeri" value="1"
                                               {{ old('ns_beritahu_tim_nyeri', $skalaCries->ns_beritahu_tim_nyeri) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="ns_beritahu_tim_nyeri">
                                            Bila pasien sudah ditangani oleh tim tatalaksana nyeri, maka beritahukan ke tim tatalaksana nyeri
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="ns_rujuk_tim_nyeri" name="ns_rujuk_tim_nyeri" value="1"
                                               {{ old('ns_rujuk_tim_nyeri', $skalaCries->ns_rujuk_tim_nyeri) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="ns_rujuk_tim_nyeri">
                                            Bila pasien belum pernah dirujuk ke tim tatalaksana nyeri, maka beritahukan ke DPJP untuk tatalaksana nyeri
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="ns_kolaborasi_obat" name="ns_kolaborasi_obat" value="1"
                                               {{ old('ns_kolaborasi_obat', $skalaCries->ns_kolaborasi_obat) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="ns_kolaborasi_obat">
                                            Kolaborasi dengan dokter untuk pemberian NSAID, Paracetamol, Opioid lemah (setelah persetujuan DPJP atau tim tatalaksana nyeri)
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="ns_teknik_relaksasi" name="ns_teknik_relaksasi" value="1"
                                               {{ old('ns_teknik_relaksasi', $skalaCries->ns_teknik_relaksasi) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="ns_teknik_relaksasi">
                                            Beritahukan pasien untuk tetap melakukan tehnik relaksasi dan tehnik distraksi yang disukai
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="ns_posisi_nyaman" name="ns_posisi_nyaman" value="1"
                                               {{ old('ns_posisi_nyaman', $skalaCries->ns_posisi_nyaman) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="ns_posisi_nyaman">
                                            Pertahankan posisi yang nyaman sesuai dengan kondisi pasien
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="ns_edukasi_pasien" name="ns_edukasi_pasien" value="1"
                                               {{ old('ns_edukasi_pasien', $skalaCries->ns_edukasi_pasien) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="ns_edukasi_pasien">
                                            Edukasi pasien dan keluarga pasien mengenai nyeri
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="ns_kaji_ulang_2jam" name="ns_kaji_ulang_2jam" value="1"
                                               {{ old('ns_kaji_ulang_2jam', $skalaCries->ns_kaji_ulang_2jam) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="ns_kaji_ulang_2jam">
                                            Kaji ulang derajat nyeri setiap 2 jam, sampai nyeri teratasi (&lt;4)
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="ns_konsultasi_tim" name="ns_konsultasi_tim" value="1"
                                               {{ old('ns_konsultasi_tim', $skalaCries->ns_konsultasi_tim) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="ns_konsultasi_tim">
                                            Bila nyeri masih ada, konsultasikan ke Tim Tatalaksana Nyeri
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Intervensi untuk Nyeri Berat -->
                            <div id="painHighInterventions" style="display: none;">
                                <div class="alert alert-danger mb-3">
                                    <i class="ti-alert-triangle"></i> <strong>Protokol Derajat Nyeri Berat (Skor 8-10)</strong>
                                </div>
                                
                                <div class="form-group">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="nt_semua_langkah_sedang" name="nt_semua_langkah_sedang" value="1"
                                               {{ old('nt_semua_langkah_sedang', $skalaCries->nt_semua_langkah_sedang) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="nt_semua_langkah_sedang">
                                            Lakukan seluruh langkah derajat sedang
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="nt_kaji_ulang_1jam" name="nt_kaji_ulang_1jam" value="1"
                                               {{ old('nt_kaji_ulang_1jam', $skalaCries->nt_kaji_ulang_1jam) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="nt_kaji_ulang_1jam">
                                            Kaji ulang derajat nyeri setiap 1 jam, sampai nyeri menjadi nyeri sedang dikaji setiap 2 jam, dan bila nyeri telah teratasi setiap 8 jam
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary btn-l px-2" id="simpan">
                                <i class="ti-save mr-2"></i> Update Data
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
            // Initialize with existing data
            initializeForm();
            
            // Add click handler for cries items
            $('.cries-option').on('click', function() {
                const category = $(this).data('category');
                
                // Update radio button
                $(`input[name="${category}"]`).prop('checked', false);
                $(this).find('input[type="radio"]').prop('checked', true);
                
                // Update visual selection
                $(`.cries-option[data-category="${category}"]`).removeClass('selected');
                $(this).addClass('selected');
                
                // Calculate total score
                calculateTotalScore();
            });

            // Menjalar selection
            $('.menjalar-btn').on('click', function() {
                const choice = $(this).data('menjalar');
                
                // Update buttons
                $('.menjalar-btn').removeClass('selected');
                $(this).addClass('selected');
                
                // Update hidden input
                $('#menjalar_value').val(choice);
                
                if (choice === 'ya') {
                    $('#menjalar_keterangan').addClass('show');
                    $('#menjalar_keterangan_text').prop('required', true);
                } else {
                    $('#menjalar_keterangan').removeClass('show');
                    $('#menjalar_keterangan_text').prop('required', false).val('');
                }
            });

            // Event listener for checkbox styling
            $('.form-check-input').on('change', function() {
                if ($(this).is(':checked')) {
                    $(this).next('.form-check-label').addClass('text-primary');
                } else {
                    $(this).next('.form-check-label').removeClass('text-primary');
                }
            });

            // Initialize checkbox styling
            $('.form-check-input:checked').next('.form-check-label').addClass('text-primary');
        });

        function initializeForm() {
            // Calculate and display initial score
            const currentScore = parseInt($('#pain_value').val()) || 0;
            updateScoreDisplay(currentScore);
            showPainInterventionProtocol(currentScore);
            
            // Set initial menjalar state
            const menjalah = $('#menjalar_value').val();
            if (menjalah === 'ya') {
                $('#menjalar_keterangan').addClass('show');
                $('#menjalar_keterangan_text').prop('required', true);
            }
        }

        function calculateTotalScore() {
            let totalScore = 0;
            
            // Get scores from each category
            const crying = parseInt($('input[name="crying"]:checked').val()) || 0;
            const requires = parseInt($('input[name="requires"]:checked').val()) || 0;
            const increased = parseInt($('input[name="increased"]:checked').val()) || 0;
            const expression = parseInt($('input[name="expression"]:checked').val()) || 0;
            const sleepless = parseInt($('input[name="sleepless"]:checked').val()) || 0;
            
            totalScore = crying + requires + increased + expression + sleepless;
            
            // Update hidden input
            $('#pain_value').val(totalScore);
            
            // Update display
            updateScoreDisplay(totalScore);
            
            // Show intervention protocol
            showPainInterventionProtocol(totalScore);
        }

        function updateScoreDisplay(totalScore) {
            let category = '';
            let displayColor = '';
            
            if (totalScore === 0) {
                category = 'Tidak Nyeri';
                displayColor = '#28a745'; // Green
            } else if (totalScore >= 1 && totalScore <= 3) {
                category = 'Nyeri Ringan';
                displayColor = '#17a2b8'; // Cyan
            } else if (totalScore >= 4 && totalScore <= 7) {
                category = 'Nyeri Sedang';
                displayColor = '#ffc107'; // Yellow
            } else if (totalScore >= 8 && totalScore <= 10) {
                category = 'Nyeri Berat';
                displayColor = '#dc3545'; // Red
            }
            
            $('#totalScoreValue').text(totalScore);
            $('#totalScoreCategory').text(category);
            
            // Update display color
            $('.total-score-display').css('background', `linear-gradient(135deg, ${displayColor}, ${displayColor})`);
            
            // Show the display
            $('#totalScoreDisplay').show();
        }

        function showPainInterventionProtocol(totalScore) {
            // Hide all intervention sections first
            $('#painLightInterventions').hide();
            $('#painMediumInterventions').hide();
            $('#painHighInterventions').hide();
            
            // Show appropriate intervention based on total score
            if (totalScore >= 1 && totalScore <= 3) {
                // Nyeri Ringan
                $('#painLightInterventions').show();
            } else if (totalScore >= 4 && totalScore <= 7) {
                // Nyeri Sedang
                $('#painMediumInterventions').show();
            } else if (totalScore >= 8 && totalScore <= 10) {
                // Nyeri Berat
                $('#painHighInterventions').show();
            }
            // Jika totalScore = 0, tidak ada protokol yang ditampilkan
        }
    </script>
@endpush