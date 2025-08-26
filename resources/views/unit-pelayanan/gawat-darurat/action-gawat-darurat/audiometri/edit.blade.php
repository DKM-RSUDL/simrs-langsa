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
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .section-title {
            font-weight: 600;
            color: #097dd6;
            margin-bottom: 1.5rem;
            font-size: 1.2rem;
            border-bottom: 2px solid #097dd6;
            padding-bottom: 0.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
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

        /* Audiogram Table Styles */
        .audiogram-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .audiogram-table th {
            background-color: #097dd6;
            color: white;
            font-weight: 600;
            text-align: center;
            padding: 12px 8px;
            font-size: 0.9rem;
            border: 1px solid #0056b3;
        }

        .audiogram-table td {
            text-align: center;
            padding: 8px;
            border: 1px solid #dee2e6;
            vertical-align: middle;
        }

        .frequency-label {
            background-color: #e3f2fd;
            font-weight: 600;
            color: #097dd6;
            writing-mode: horizontal-tb;
            transform: rotate(0deg);
            width: 80px;
        }

        .conduction-label {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #495057;
            width: 120px;
        }

        .audiogram-input {
            width: 70px;
            padding: 6px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            text-align: center;
            font-size: 0.85rem;
        }

        .audiogram-input:focus {
            border-color: #097dd6;
            box-shadow: 0 0 0 0.1rem rgba(9, 125, 214, 0.25);
            outline: none;
        }

        .average-row {
            background-color: #fff3cd !important;
            font-weight: 600;
        }

        .average-input {
            background-color: #ffeaa7 !important;
            font-weight: 600;
            color: #856404;
        }

        .ear-section {
            margin-bottom: 2rem;
        }

        .ear-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #097dd6;
            margin-bottom: 1rem;
            padding: 0.75rem;
            background-color: #e3f2fd;
            border-left: 4px solid #097dd6;
            border-radius: 4px;
        }

        .info-box {
            background-color: #d1ecf1;
            border: 1px solid #bee5eb;
            border-radius: 6px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .info-title {
            font-weight: 600;
            color: #0c5460;
            margin-bottom: 0.5rem;
        }

        .info-text {
            color: #0c5460;
            font-size: 0.9rem;
            margin: 0;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .datetime-group {
                grid-template-columns: 1fr;
            }

            .form-section {
                padding: 1rem;
            }

            .audiogram-table {
                font-size: 0.8rem;
            }

            .audiogram-input {
                width: 60px;
                font-size: 0.8rem;
            }

            .conduction-label {
                width: 100px;
                font-size: 0.8rem;
            }

            .frequency-label {
                width: 60px;
                font-size: 0.8rem;
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
            <a href="{{ route('audiometri.index', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}" class="btn btn-outline-primary mb-3">
                <i class="ti-arrow-left"></i> Kembali
            </a>

            <form id="audiometriForm" method="POST"
                action="{{ route('audiometri.update', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $dataAudiometri->id]) }}">
                @csrf
                @method('PUT')

                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="header-asesmen">Form Edit Pemeriksaan Audiometri</h4>

                        <!-- Basic Information Section -->
                        <div class="form-section">
                            <h5 class="section-title">Informasi Dasar</h5>

                            <div class="form-group">
                                <label class="form-label">Tanggal dan Jam Pemeriksaan</label>
                                <div class="datetime-group">
                                    <div class="datetime-item">
                                        <label>Tanggal</label>
                                        <input type="date" class="form-control @error('tanggal_pemeriksaan') is-invalid @enderror" 
                                               name="tanggal_pemeriksaan" id="tanggal_pemeriksaan" 
                                               value="{{ old('tanggal_pemeriksaan', $dataAudiometri->tanggal_pemeriksaan) }}" required>
                                        @error('tanggal_pemeriksaan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="datetime-item">
                                        <label>Jam</label>
                                        <input type="time" class="form-control @error('jam_pemeriksaan') is-invalid @enderror" 
                                               name="jam_pemeriksaan" id="jam_pemeriksaan" 
                                               value="{{ old('jam_pemeriksaan', $dataAudiometri->jam_pemeriksaan) }}" required>
                                        @error('jam_pemeriksaan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Info Box -->
                        <div class="info-box">
                            <div class="info-title">Petunjuk Pengisian:</div>
                            <ul class="info-text">
                                <li>AC (Air Conduction) = Hantaran Udara</li>
                                <li>BC (Bone Conduction) = Hantaran Tulang</li>
                                <li>Masukkan nilai threshold pendengaran dalam dB HL</li>
                                <li>Range nilai: -10 dB hingga 140 dB</li>
                                <li>Rata-rata akan dihitung otomatis dari frekuensi 500, 1000, 2000, 4000 Hz</li>
                            </ul>
                        </div>

                        <!-- Audiogram Results Section -->
                        <div class="form-section">
                            <h5 class="section-title">Hasil Pemeriksaan Audiometri</h5>

                            <!-- Telinga Kanan -->
                            <div class="ear-section">
                                <div class="ear-title">
                                    <i class="ti-arrow-right mr-2"></i>Telinga Kanan (Right Ear)
                                </div>
                                
                                <table class="audiogram-table">
                                    <thead>
                                        <tr>
                                            <th class="conduction-label">Frekuensi (Hz)</th>
                                            <th class="frequency-label">250</th>
                                            <th class="frequency-label">500</th>
                                            <th class="frequency-label">1000</th>
                                            <th class="frequency-label">2000</th>
                                            <th class="frequency-label">3000</th>
                                            <th class="frequency-label">4000</th>
                                            <th class="frequency-label">6000</th>
                                            <th class="frequency-label">8000</th>
                                            <th class="frequency-label">Rata-rata</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- AC Kanan -->
                                        <tr>
                                            <td class="conduction-label">AC - Kanan (dB HL)</td>
                                            <td>
                                                <input type="number" class="audiogram-input ac-right" 
                                                       name="ac_right_250" min="-10" max="140" step="5" 
                                                       value="{{ old('ac_right_250', $acKanan['250'] ?? '') }}" data-freq="250">
                                            </td>
                                            <td>
                                                <input type="number" class="audiogram-input ac-right avg-calc" 
                                                       name="ac_right_500" min="-10" max="140" step="5" 
                                                       value="{{ old('ac_right_500', $acKanan['500'] ?? '') }}" data-freq="500">
                                            </td>
                                            <td>
                                                <input type="number" class="audiogram-input ac-right avg-calc" 
                                                       name="ac_right_1000" min="-10" max="140" step="5" 
                                                       value="{{ old('ac_right_1000', $acKanan['1000'] ?? '') }}" data-freq="1000">
                                            </td>
                                            <td>
                                                <input type="number" class="audiogram-input ac-right avg-calc" 
                                                       name="ac_right_2000" min="-10" max="140" step="5" 
                                                       value="{{ old('ac_right_2000', $acKanan['2000'] ?? '') }}" data-freq="2000">
                                            </td>
                                            <td>
                                                <input type="number" class="audiogram-input ac-right" 
                                                       name="ac_right_3000" min="-10" max="140" step="5" 
                                                       value="{{ old('ac_right_3000', $acKanan['3000'] ?? '') }}" data-freq="3000">
                                            </td>
                                            <td>
                                                <input type="number" class="audiogram-input ac-right avg-calc" 
                                                       name="ac_right_4000" min="-10" max="140" step="5" 
                                                       value="{{ old('ac_right_4000', $acKanan['4000'] ?? '') }}" data-freq="4000">
                                            </td>
                                            <td>
                                                <input type="number" class="audiogram-input ac-right" 
                                                       name="ac_right_6000" min="-10" max="140" step="5" 
                                                       value="{{ old('ac_right_6000', $acKanan['6000'] ?? '') }}" data-freq="6000">
                                            </td>
                                            <td>
                                                <input type="number" class="audiogram-input ac-right" 
                                                       name="ac_right_8000" min="-10" max="140" step="5" 
                                                       value="{{ old('ac_right_8000', $acKanan['8000'] ?? '') }}" data-freq="8000">
                                            </td>
                                            <td class="average-row">
                                                <input type="text" class="audiogram-input average-input" 
                                                       id="ac_right_avg" name="ac_right_avg" 
                                                       value="{{ old('ac_right_avg', $acKanan['rata_rata'] ?? '') }}" readonly>
                                            </td>
                                        </tr>
                                        <!-- BC Kanan -->
                                        <tr>
                                            <td class="conduction-label">BC - Kanan (dB HL)</td>
                                            <td>
                                                <input type="number" class="audiogram-input bc-right" 
                                                       name="bc_right_250" min="-10" max="140" step="5" 
                                                       value="{{ old('bc_right_250', $bcKanan['250'] ?? '') }}" data-freq="250">
                                            </td>
                                            <td>
                                                <input type="number" class="audiogram-input bc-right bc-avg-calc" 
                                                       name="bc_right_500" min="-10" max="140" step="5" 
                                                       value="{{ old('bc_right_500', $bcKanan['500'] ?? '') }}" data-freq="500">
                                            </td>
                                            <td>
                                                <input type="number" class="audiogram-input bc-right bc-avg-calc" 
                                                       name="bc_right_1000" min="-10" max="140" step="5" 
                                                       value="{{ old('bc_right_1000', $bcKanan['1000'] ?? '') }}" data-freq="1000">
                                            </td>
                                            <td>
                                                <input type="number" class="audiogram-input bc-right bc-avg-calc" 
                                                       name="bc_right_2000" min="-10" max="140" step="5" 
                                                       value="{{ old('bc_right_2000', $bcKanan['2000'] ?? '') }}" data-freq="2000">
                                            </td>
                                            <td>
                                                <input type="number" class="audiogram-input bc-right" 
                                                       name="bc_right_3000" min="-10" max="140" step="5" 
                                                       value="{{ old('bc_right_3000', $bcKanan['3000'] ?? '') }}" data-freq="3000">
                                            </td>
                                            <td>
                                                <input type="number" class="audiogram-input bc-right bc-avg-calc" 
                                                       name="bc_right_4000" min="-10" max="140" step="5" 
                                                       value="{{ old('bc_right_4000', $bcKanan['4000'] ?? '') }}" data-freq="4000">
                                            </td>
                                            <td>
                                                <input type="number" class="audiogram-input bc-right" 
                                                       name="bc_right_6000" min="-10" max="140" step="5" 
                                                       value="{{ old('bc_right_6000', $bcKanan['6000'] ?? '') }}" data-freq="6000">
                                            </td>
                                            <td>
                                                <input type="number" class="audiogram-input bc-right" 
                                                       name="bc_right_8000" min="-10" max="140" step="5" 
                                                       value="{{ old('bc_right_8000', $bcKanan['8000'] ?? '') }}" data-freq="8000">
                                            </td>
                                            <td class="average-row">
                                                <input type="text" class="audiogram-input average-input" 
                                                       id="bc_right_avg" name="bc_right_avg" 
                                                       value="{{ old('bc_right_avg', $bcKanan['rata_rata'] ?? '') }}" readonly>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Telinga Kiri -->
                            <div class="ear-section">
                                <div class="ear-title">
                                    <i class="ti-arrow-left mr-2"></i>Telinga Kiri (Left Ear)
                                </div>
                                
                                <table class="audiogram-table">
                                    <thead>
                                        <tr>
                                            <th class="conduction-label">Frekuensi (Hz)</th>
                                            <th class="frequency-label">250</th>
                                            <th class="frequency-label">500</th>
                                            <th class="frequency-label">1000</th>
                                            <th class="frequency-label">2000</th>
                                            <th class="frequency-label">3000</th>
                                            <th class="frequency-label">4000</th>
                                            <th class="frequency-label">6000</th>
                                            <th class="frequency-label">8000</th>
                                            <th class="frequency-label">Rata-rata</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- AC Kiri -->
                                        <tr>
                                            <td class="conduction-label">AC - Kiri (dB HL)</td>
                                            <td>
                                                <input type="number" class="audiogram-input ac-left" 
                                                       name="ac_left_250" min="-10" max="140" step="5" 
                                                       value="{{ old('ac_left_250', $acKiri['250'] ?? '') }}" data-freq="250">
                                            </td>
                                            <td>
                                                <input type="number" class="audiogram-input ac-left ac-left-avg-calc" 
                                                       name="ac_left_500" min="-10" max="140" step="5" 
                                                       value="{{ old('ac_left_500', $acKiri['500'] ?? '') }}" data-freq="500">
                                            </td>
                                            <td>
                                                <input type="number" class="audiogram-input ac-left ac-left-avg-calc" 
                                                       name="ac_left_1000" min="-10" max="140" step="5" 
                                                       value="{{ old('ac_left_1000', $acKiri['1000'] ?? '') }}" data-freq="1000">
                                            </td>
                                            <td>
                                                <input type="number" class="audiogram-input ac-left ac-left-avg-calc" 
                                                       name="ac_left_2000" min="-10" max="140" step="5" 
                                                       value="{{ old('ac_left_2000', $acKiri['2000'] ?? '') }}" data-freq="2000">
                                            </td>
                                            <td>
                                                <input type="number" class="audiogram-input ac-left" 
                                                       name="ac_left_3000" min="-10" max="140" step="5" 
                                                       value="{{ old('ac_left_3000', $acKiri['3000'] ?? '') }}" data-freq="3000">
                                            </td>
                                            <td>
                                                <input type="number" class="audiogram-input ac-left ac-left-avg-calc" 
                                                       name="ac_left_4000" min="-10" max="140" step="5" 
                                                       value="{{ old('ac_left_4000', $acKiri['4000'] ?? '') }}" data-freq="4000">
                                            </td>
                                            <td>
                                                <input type="number" class="audiogram-input ac-left" 
                                                       name="ac_left_6000" min="-10" max="140" step="5" 
                                                       value="{{ old('ac_left_6000', $acKiri['6000'] ?? '') }}" data-freq="6000">
                                            </td>
                                            <td>
                                                <input type="number" class="audiogram-input ac-left" 
                                                       name="ac_left_8000" min="-10" max="140" step="5" 
                                                       value="{{ old('ac_left_8000', $acKiri['8000'] ?? '') }}" data-freq="8000">
                                            </td>
                                            <td class="average-row">
                                                <input type="text" class="audiogram-input average-input" 
                                                       id="ac_left_avg" name="ac_left_avg" 
                                                       value="{{ old('ac_left_avg', $acKiri['rata_rata'] ?? '') }}" readonly>
                                            </td>
                                        </tr>
                                        <!-- BC Kiri -->
                                        <tr>
                                            <td class="conduction-label">BC - Kiri (dB HL)</td>
                                            <td>
                                                <input type="number" class="audiogram-input bc-left" 
                                                       name="bc_left_250" min="-10" max="140" step="5" 
                                                       value="{{ old('bc_left_250', $bcKiri['250'] ?? '') }}" data-freq="250">
                                            </td>
                                            <td>
                                                <input type="number" class="audiogram-input bc-left bc-left-avg-calc" 
                                                       name="bc_left_500" min="-10" max="140" step="5" 
                                                       value="{{ old('bc_left_500', $bcKiri['500'] ?? '') }}" data-freq="500">
                                            </td>
                                            <td>
                                                <input type="number" class="audiogram-input bc-left bc-left-avg-calc" 
                                                       name="bc_left_1000" min="-10" max="140" step="5" 
                                                       value="{{ old('bc_left_1000', $bcKiri['1000'] ?? '') }}" data-freq="1000">
                                            </td>
                                            <td>
                                                <input type="number" class="audiogram-input bc-left bc-left-avg-calc" 
                                                       name="bc_left_2000" min="-10" max="140" step="5" 
                                                       value="{{ old('bc_left_2000', $bcKiri['2000'] ?? '') }}" data-freq="2000">
                                            </td>
                                            <td>
                                                <input type="number" class="audiogram-input bc-left" 
                                                       name="bc_left_3000" min="-10" max="140" step="5" 
                                                       value="{{ old('bc_left_3000', $bcKiri['3000'] ?? '') }}" data-freq="3000">
                                            </td>
                                            <td>
                                                <input type="number" class="audiogram-input bc-left bc-left-avg-calc" 
                                                       name="bc_left_4000" min="-10" max="140" step="5" 
                                                       value="{{ old('bc_left_4000', $bcKiri['4000'] ?? '') }}" data-freq="4000">
                                            </td>
                                            <td>
                                                <input type="number" class="audiogram-input bc-left" 
                                                       name="bc_left_6000" min="-10" max="140" step="5" 
                                                       value="{{ old('bc_left_6000', $bcKiri['6000'] ?? '') }}" data-freq="6000">
                                            </td>
                                            <td>
                                                <input type="number" class="audiogram-input bc-left" 
                                                       name="bc_left_8000" min="-10" max="140" step="5" 
                                                       value="{{ old('bc_left_8000', $bcKiri['8000'] ?? '') }}" data-freq="8000">
                                            </td>
                                            <td class="average-row">
                                                <input type="text" class="audiogram-input average-input" 
                                                       id="bc_left_avg" name="bc_left_avg" 
                                                       value="{{ old('bc_left_avg', $bcKiri['rata_rata'] ?? '') }}" readonly>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Interpretasi Section -->
                        <div class="form-section">
                            <h5 class="section-title">Interpretasi dan Catatan</h5>
                            
                            <div class="form-group">
                                <label class="form-label">Interpretasi Hasil</label>
                                <textarea class="form-control @error('interpretasi') is-invalid @enderror" 
                                          name="interpretasi" id="interpretasi" rows="4" 
                                          placeholder="Tuliskan interpretasi hasil audiometri...">{{ old('interpretasi', $dataAudiometri->interpretasi) }}</textarea>
                                @error('interpretasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">Catatan Tambahan</label>
                                <textarea class="form-control @error('catatan') is-invalid @enderror" 
                                          name="catatan" id="catatan" rows="3" 
                                          placeholder="Catatan tambahan dari pemeriksa...">{{ old('catatan', $dataAudiometri->catatan) }}</textarea>
                                @error('catatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary btn-lg px-4" id="simpan">
                                <i class="ti-save mr-2"></i> Perbarui Data
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
            // Fungsi untuk menghitung rata-rata AC Kanan
            function calculateACRightAverage() {
                let total = 0;
                let count = 0;
                
                $('.avg-calc').each(function() {
                    let value = parseFloat($(this).val());
                    if (!isNaN(value)) {
                        total += value;
                        count++;
                    }
                });
                
                if (count > 0) {
                    let average = total / count;
                    $('#ac_right_avg').val(average.toFixed(1));
                } else {
                    $('#ac_right_avg').val('');
                }
            }

            // Fungsi untuk menghitung rata-rata BC Kanan
            function calculateBCRightAverage() {
                let total = 0;
                let count = 0;
                
                $('.bc-avg-calc').each(function() {
                    let value = parseFloat($(this).val());
                    if (!isNaN(value)) {
                        total += value;
                        count++;
                    }
                });
                
                if (count > 0) {
                    let average = total / count;
                    $('#bc_right_avg').val(average.toFixed(1));
                } else {
                    $('#bc_right_avg').val('');
                }
            }

            // Fungsi untuk menghitung rata-rata AC Kiri
            function calculateACLeftAverage() {
                let total = 0;
                let count = 0;
                
                $('.ac-left-avg-calc').each(function() {
                    let value = parseFloat($(this).val());
                    if (!isNaN(value)) {
                        total += value;
                        count++;
                    }
                });
                
                if (count > 0) {
                    let average = total / count;
                    $('#ac_left_avg').val(average.toFixed(1));
                } else {
                    $('#ac_left_avg').val('');
                }
            }

            // Fungsi untuk menghitung rata-rata BC Kiri
            function calculateBCLeftAverage() {
                let total = 0;
                let count = 0;
                
                $('.bc-left-avg-calc').each(function() {
                    let value = parseFloat($(this).val());
                    if (!isNaN(value)) {
                        total += value;
                        count++;
                    }
                });
                
                if (count > 0) {
                    let average = total / count;
                    $('#bc_left_avg').val(average.toFixed(1));
                } else {
                    $('#bc_left_avg').val('');
                }
            }

            // Event listener untuk input AC Kanan
            $('.avg-calc').on('input', function() {
                calculateACRightAverage();
            });

            // Event listener untuk input BC Kanan
            $('.bc-avg-calc').on('input', function() {
                calculateBCRightAverage();
            });

            // Event listener untuk input AC Kiri
            $('.ac-left-avg-calc').on('input', function() {
                calculateACLeftAverage();
            });

            // Event listener untuk input BC Kiri
            $('.bc-left-avg-calc').on('input', function() {
                calculateBCLeftAverage();
            });

            // Hitung rata-rata pada saat load halaman
            calculateACRightAverage();
            calculateBCRightAverage();
            calculateACLeftAverage();
            calculateBCLeftAverage();

            // Validasi input range
            $('.audiogram-input').on('input', function() {
                let value = parseInt($(this).val());
                let min = parseInt($(this).attr('min'));
                let max = parseInt($(this).attr('max'));
                
                if (value < min) {
                    $(this).val(min);
                } else if (value > max) {
                    $(this).val(max);
                }
            });

            // Form validation
            $('#audiometriForm').on('submit', function(e) {
                let isValid = true;
                let emptyFields = [];

                // Validasi field wajib
                if (!$('#tanggal_pemeriksaan').val()) {
                    emptyFields.push('Tanggal Pemeriksaan');
                    isValid = false;
                }

                if (!$('#jam_pemeriksaan').val()) {
                    emptyFields.push('Jam Pemeriksaan');
                    isValid = false;
                }

                if (!isValid) {
                    e.preventDefault();
                    alert('Mohon lengkapi field berikut: ' + emptyFields.join(', '));
                    return false;
                }
            });
        });
    </script>
@endpush