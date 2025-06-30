@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .nav-link.active {
            background-color: #007bff !important;
            color: white !important;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .chart-container {
            position: relative;
            width: 100%;
            height: 400px;
            margin-bottom: 2rem;
        }

        canvas {
            width: 100% !important;
            height: 100% !important;
        }

        .growth-chart {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .chart-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: #333;
            text-align: center;
        }

        .patient-point {
            background-color: #dc3545;
            border: 2px solid #fff;
            box-shadow: 0 0 0 2px #dc3545;
        }

        .chart-legend {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 10px;
            font-size: 0.85rem;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .legend-line {
            width: 20px;
            height: 2px;
        }

        .patient-info {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .nav-tabs .nav-link {
            border: 1px solid #dee2e6;
            border-bottom: none;
            margin-right: 2px;
        }

        .nav-tabs .nav-link.active {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
        }

        .tab-content {
            border: 1px solid #dee2e6;
            border-radius: 0 0 0.375rem 0.375rem;
            padding: 20px;
            background: white;
        }

        /* Styling untuk rekomendasi WHO */
        .who-recommendation {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .recommendation-header {
            font-size: 1.1rem;
            font-weight: 600;
            color: #495057;
            margin-bottom: 15px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 8px;
        }

        .status-normal {
            color: #28a745;
            font-weight: bold;
        }

        .status-underweight {
            color: #ffc107;
            font-weight: bold;
        }

        .status-overweight {
            color: #fd7e14;
            font-weight: bold;
        }

        .status-severe {
            color: #dc3545;
            font-weight: bold;
        }

        .recommendation-text {
            margin-bottom: 10px;
            line-height: 1.6;
        }

        .recommendation-value {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 10px;
            margin-top: 10px;
            font-weight: 500;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.875rem;
            font-weight: 500;
            margin: 0 2px;
        }

        .badge-normal {
            background-color: #d1edff;
            color: #28a745;
        }

        .badge-underweight {
            background-color: #fff3cd;
            color: #856404;
        }

        .badge-overweight {
            background-color: #f8d7da;
            color: #721c24;
        }

        .badge-severe {
            background-color: #f5c6cb;
            color: #721c24;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <div class="d-flex justify-content-between mb-3">
                <a href="{{ url("unit-pelayanan/rawat-inap/unit/{$dataMedis->kd_unit}/pelayanan/{$dataMedis->kd_pasien}/" . date('Y-m-d', strtotime($dataMedis->tgl_masuk)) . "/{$dataMedis->urut_masuk}/gizi/anak") }}"
                    class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('rawat-inap.gizi.anak.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $dataPengkajianGizi->id]) }}"
                    class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
            </div>

            <div>
                <div class="card-header">
                    <h5>KURVA PERTUMBUHAN LANJUTAN PENGKAJIAN GIZI ANAK</h5>
                </div>
                <div class="card-body">

                    {{-- Asesmen Gizi --}}
                    @if ($dataPengkajianGizi->asesmenGizi)
                        <table class="table table-bordered">
                            <tr>
                                <td width="200px"><strong>Berat Badan</strong></td>
                                <td>{{ $dataPengkajianGizi->asesmenGizi->berat_badan ? number_format((float) $dataPengkajianGizi->asesmenGizi->berat_badan, 1, '.', '') : '-' }}
                                    kg</td>
                            </tr>
                            <tr>
                                <td><strong>Tinggi Badan</strong></td>
                                <td>{{ $dataPengkajianGizi->asesmenGizi->tinggi_badan ? number_format((float) $dataPengkajianGizi->asesmenGizi->tinggi_badan, 1, '.', '') : '-' }}
                                    cm</td>
                            </tr>
                            <tr>
                                <td><strong>IMT</strong></td>
                                <td>{{ $dataPengkajianGizi->asesmenGizi->imt ? number_format((float) $dataPengkajianGizi->asesmenGizi->imt, 2, '.', '') : '-' }}
                                    kg/m²</td>
                            </tr>
                            <tr>
                                <td><strong>BBI</strong></td>
                                <td>{{ $dataPengkajianGizi->asesmenGizi->bbi ? number_format((float) $dataPengkajianGizi->asesmenGizi->bbi, 1, '.', '') : '-' }}
                                    kg</td>
                            </tr>
                            <tr>
                                <td><strong>Status Gizi</strong></td>
                                <td>
                                    <span
                                        class="">
                                        {{ $dataPengkajianGizi->asesmenGizi->status_gizi ?: '-' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>BB/Usia (Z-Score)</strong></td>
                                <td>{{ $dataPengkajianGizi->asesmenGizi->bb_usia ? number_format((float) $dataPengkajianGizi->asesmenGizi->bb_usia, 2, '.', '') : '-' }}
                                </td>
                            </tr>
                            <tr>
                                <td><strong>BB/TB (Z-Score)</strong></td>
                                <td>{{ $dataPengkajianGizi->asesmenGizi->bb_tb ? number_format((float) $dataPengkajianGizi->asesmenGizi->bb_tb, 2, '.', '') : '-' }}
                                </td>
                            </tr>
                            <tr>
                                <td><strong>PB(TB)/Usia (Z-Score)</strong></td>
                                <td>{{ $dataPengkajianGizi->asesmenGizi->pb_tb_usia ? number_format((float) $dataPengkajianGizi->asesmenGizi->pb_tb_usia, 2, '.', '') : '-' }}
                                </td>
                            </tr>
                            <tr>
                                <td><strong>IMT/Usia (Z-Score)</strong></td>
                                <td>{{ $dataPengkajianGizi->asesmenGizi->imt_usia ? number_format((float) $dataPengkajianGizi->asesmenGizi->imt_usia, 2, '.', '') : '-' }}
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Lingkar Kepala</strong></td>
                                <td>{{ $dataPengkajianGizi->asesmenGizi->lingkar_kepala ? number_format((float) $dataPengkajianGizi->asesmenGizi->lingkar_kepala, 1, '.', '') : '-' }}
                                    cm</td>
                            </tr>
                        </table>
                    @endif

                    <hr>

                    {{-- WHO Growth Charts --}}
                    @if (
                        $dataPengkajianGizi->asesmenGizi &&
                            $dataPengkajianGizi->asesmenGizi->berat_badan &&
                            $dataPengkajianGizi->asesmenGizi->tinggi_badan)
                        <h6><i class="fas fa-chart-line"></i> Kurva Pertumbuhan WHO</h6>

                        {{-- Patient Info --}}
                        <div class="patient-info">
                            <div class="row">
                                <div class="col-md-3">
                                    <strong>Jenis Kelamin:</strong>
                                    {{ $dataMedis->pasien->jenis_kelamin == 1 ? 'Laki-laki' : ($dataMedis->pasien->jenis_kelamin == 0 ? 'Perempuan' : 'Tidak Diketahui') }}
                                </div>
                                <div class="col-md-3">
                                    <strong>Umur:</strong>
                                    {{ $dataMedis->pasien->tgl_lahir ? \Carbon\Carbon::parse($dataMedis->pasien->tgl_lahir)->diffInMonths(\Carbon\Carbon::now()) : 'Tidak Diketahui' }}
                                    bulan
                                </div>
                                <div class="col-md-3">
                                    <strong>Berat:</strong>
                                    {{ number_format((float) $dataPengkajianGizi->asesmenGizi->berat_badan, 1) }} kg
                                </div>
                                <div class="col-md-3">
                                    <strong>Tinggi:</strong>
                                    {{ number_format((float) $dataPengkajianGizi->asesmenGizi->tinggi_badan, 1) }} cm
                                </div>
                            </div>
                        </div>

                        {{-- Chart Tabs --}}
                        <ul class="nav nav-tabs" id="chartTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="weight-age-tab" data-bs-toggle="tab"
                                    data-bs-target="#weight-age" type="button" role="tab">
                                    Berat/Umur
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="height-age-tab" data-bs-toggle="tab"
                                    data-bs-target="#height-age" type="button" role="tab">
                                    @php
                                        $umurBulan = $dataMedis->pasien->tgl_lahir ? 
                                            \Carbon\Carbon::parse($dataMedis->pasien->tgl_lahir)->diffInMonths(\Carbon\Carbon::now()) : 0;
                                    @endphp
                                    {{ $umurBulan < 24 ? 'Panjang/Umur' : 'Tinggi/Umur' }}
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="weight-height-tab" data-bs-toggle="tab"
                                    data-bs-target="#weight-height" type="button" role="tab">
                                    {{ $umurBulan < 24 ? 'Berat/Panjang' : 'Berat/Tinggi' }}
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="bmi-age-tab" data-bs-toggle="tab" data-bs-target="#bmi-age"
                                    type="button" role="tab">
                                    IMT/Umur
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content" id="chartTabContent">
                            {{-- Weight for Age Chart --}}
                            <div class="tab-pane fade show active" id="weight-age" role="tabpanel">
                                <div class="chart-title">Berat Badan menurut Umur (0-60 bulan)</div>
                                <div class="chart-container">
                                    <canvas id="weightAgeChart"></canvas>
                                </div>
                                <div class="chart-legend">
                                    <div class="legend-item">
                                        <div class="legend-line" style="background-color: #28a745;"></div>
                                        <span>+3 SD (97th)</span>
                                    </div>
                                    <div class="legend-item">
                                        <div class="legend-line" style="background-color: #ffc107;"></div>
                                        <span>+2 SD (85th)</span>
                                    </div>
                                    <div class="legend-item">
                                        <div class="legend-line" style="background-color: #007bff;"></div>
                                        <span>Median</span>
                                    </div>
                                    <div class="legend-item">
                                        <div class="legend-line" style="background-color: #ffc107;"></div>
                                        <span>-2 SD (15th)</span>
                                    </div>
                                    <div class="legend-item">
                                        <div class="legend-line" style="background-color: #dc3545;"></div>
                                        <span>-3 SD (3rd)</span>
                                    </div>
                                    <div class="legend-item">
                                        <div style="width: 10px; height: 10px; background-color: #dc3545; border-radius: 50%; border: 2px solid #fff; box-shadow: 0 0 0 2px #dc3545;"></div>
                                        <span>Data Pasien</span>
                                    </div>
                                </div>
                                
                                {{-- Rekomendasi WHO untuk Berat/Umur --}}
                                <div class="who-recommendation" id="weight-age-recommendation">
                                    <div class="recommendation-header">
                                        <i class="fas fa-clipboard-check"></i> Analisis Berat Badan menurut Umur
                                    </div>
                                    <div id="weight-age-status" class="recommendation-text"></div>
                                    <div id="weight-age-advice" class="recommendation-text"></div>
                                    <div id="weight-age-target" class="recommendation-value"></div>
                                </div>
                            </div>

                            {{-- Height for Age Chart --}}
                            <div class="tab-pane fade" id="height-age" role="tabpanel">
                                <div class="chart-title">
                                    {{ $umurBulan < 24 ? 'Panjang Badan' : 'Tinggi Badan' }} menurut Umur 
                                    ({{ $umurBulan < 24 ? '0-2 tahun' : ($umurBulan < 60 ? '2-5 tahun' : '5+ tahun') }})
                                </div>
                                <div class="chart-container">
                                    <canvas id="heightAgeChart"></canvas>
                                </div>
                                <div class="chart-legend">
                                    <div class="legend-item">
                                        <div class="legend-line" style="background-color: #28a745;"></div>
                                        <span>+3 SD (97th)</span>
                                    </div>
                                    <div class="legend-item">
                                        <div class="legend-line" style="background-color: #ffc107;"></div>
                                        <span>+2 SD (85th)</span>
                                    </div>
                                    <div class="legend-item">
                                        <div class="legend-line" style="background-color: #007bff;"></div>
                                        <span>Median</span>
                                    </div>
                                    <div class="legend-item">
                                        <div class="legend-line" style="background-color: #ffc107;"></div>
                                        <span>-2 SD (15th)</span>
                                    </div>
                                    <div class="legend-item">
                                        <div class="legend-line" style="background-color: #dc3545;"></div>
                                        <span>-3 SD (3rd)</span>
                                    </div>
                                    <div class="legend-item">
                                        <div style="width: 10px; height: 10px; background-color: #dc3545; border-radius: 50%; border: 2px solid #fff; box-shadow: 0 0 0 2px #dc3545;"></div>
                                        <span>Data Pasien</span>
                                    </div>
                                </div>

                                {{-- Rekomendasi WHO untuk Tinggi/Umur --}}
                                <div class="who-recommendation" id="height-age-recommendation">
                                    <div class="recommendation-header">
                                        <i class="fas fa-ruler-vertical"></i> Analisis {{ $umurBulan < 24 ? 'Panjang Badan' : 'Tinggi Badan' }} menurut Umur
                                    </div>
                                    <div id="height-age-status" class="recommendation-text"></div>
                                    <div id="height-age-advice" class="recommendation-text"></div>
                                    <div id="height-age-target" class="recommendation-value"></div>
                                </div>
                            </div>

                            {{-- Weight for Height Chart --}}
                            <div class="tab-pane fade" id="weight-height" role="tabpanel">
                                <div class="chart-title">
                                    Berat Badan menurut {{ $umurBulan < 24 ? 'Panjang Badan (0-2 tahun)' : 'Tinggi Badan (2-5 tahun)' }}
                                </div>
                                <div class="chart-container">
                                    <canvas id="weightHeightChart"></canvas>
                                </div>
                                <div class="chart-legend">
                                    <div class="legend-item">
                                        <div class="legend-line" style="background-color: #28a745;"></div>
                                        <span>+3 SD (97th)</span>
                                    </div>
                                    <div class="legend-item">
                                        <div class="legend-line" style="background-color: #ffc107;"></div>
                                        <span>+2 SD (85th)</span>
                                    </div>
                                    <div class="legend-item">
                                        <div class="legend-line" style="background-color: #007bff;"></div>
                                        <span>Median</span>
                                    </div>
                                    <div class="legend-item">
                                        <div class="legend-line" style="background-color: #ffc107;"></div>
                                        <span>-2 SD (15th)</span>
                                    </div>
                                    <div class="legend-item">
                                        <div class="legend-line" style="background-color: #dc3545;"></div>
                                        <span>-3 SD (3rd)</span>
                                    </div>
                                    <div class="legend-item">
                                        <div style="width: 10px; height: 10px; background-color: #dc3545; border-radius: 50%; border: 2px solid #fff; box-shadow: 0 0 0 2px #dc3545;"></div>
                                        <span>Data Pasien</span>
                                    </div>
                                </div>

                                {{-- Rekomendasi WHO untuk Berat/Tinggi --}}
                                <div class="who-recommendation" id="weight-height-recommendation">
                                    <div class="recommendation-header">
                                        <i class="fas fa-balance-scale"></i> Analisis Berat Badan menurut {{ $umurBulan < 24 ? 'Panjang Badan' : 'Tinggi Badan' }}
                                    </div>
                                    <div id="weight-height-status" class="recommendation-text"></div>
                                    <div id="weight-height-advice" class="recommendation-text"></div>
                                    <div id="weight-height-target" class="recommendation-value"></div>
                                </div>
                            </div>

                            {{-- BMI for Age Chart --}}
                            <div class="tab-pane fade" id="bmi-age" role="tabpanel">
                                <div class="chart-title">IMT menurut Umur (0-60 bulan)</div>
                                <div class="chart-container">
                                    <canvas id="bmiAgeChart"></canvas>
                                </div>
                                <div class="chart-legend">
                                    <div class="legend-item">
                                        <div class="legend-line" style="background-color: #28a745;"></div>
                                        <span>+3 SD (97th)</span>
                                    </div>
                                    <div class="legend-item">
                                        <div class="legend-line" style="background-color: #ffc107;"></div>
                                        <span>+2 SD (85th)</span>
                                    </div>
                                    <div class="legend-item">
                                        <div class="legend-line" style="background-color: #007bff;"></div>
                                        <span>Median</span>
                                    </div>
                                    <div class="legend-item">
                                        <div class="legend-line" style="background-color: #ffc107;"></div>
                                        <span>-2 SD (15th)</span>
                                    </div>
                                    <div class="legend-item">
                                        <div class="legend-line" style="background-color: #dc3545;"></div>
                                        <span>-3 SD (3rd)</span>
                                    </div>
                                    <div class="legend-item">
                                        <div style="width: 10px; height: 10px; background-color: #dc3545; border-radius: 50%; border: 2px solid #fff; box-shadow: 0 0 0 2px #dc3545;"></div>
                                        <span>Data Pasien</span>
                                    </div>
                                </div>

                                {{-- Rekomendasi WHO untuk IMT/Umur --}}
                                <div class="who-recommendation" id="bmi-age-recommendation">
                                    <div class="recommendation-header">
                                        <i class="fas fa-calculator"></i> Analisis IMT menurut Umur
                                    </div>
                                    <div id="bmi-age-status" class="recommendation-text"></div>
                                    <div id="bmi-age-advice" class="recommendation-text"></div>
                                    <div id="bmi-age-target" class="recommendation-value"></div>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script>

        document.addEventListener('DOMContentLoaded', function() {
            // Data pasien dari blade
            const patientData = {
                sex: {{ $dataMedis->pasien->jenis_kelamin ?? 1 }},
                ageMonths: {{ $dataMedis->pasien->tgl_lahir ? \Carbon\Carbon::parse($dataMedis->pasien->tgl_lahir)->diffInMonths(\Carbon\Carbon::now()) : 0 }},
                weight: {{ (float) ($dataPengkajianGizi->asesmenGizi->berat_badan ?? 0) }},
                height: {{ (float) ($dataPengkajianGizi->asesmenGizi->tinggi_badan ?? 0) }},
                bmi: {{ (float) ($dataPengkajianGizi->asesmenGizi->imt ?? 0) }}
            };

            // Data WHO dan rekomendasi dari backend (SUDAH DIHITUNG DI CONTROLLER)
            const whoData = @json($whoData ?? []);
            const backendRecommendations = @json($recommendations ?? []);

            // ========================================
            // FUNGSI UTILITAS CHART (PERTAHANKAN)
            // ========================================
            
            function parseValue(value) {
                if (value === null || value === undefined) return 0;
                if (typeof value === 'number') return value;
                if (typeof value === 'string') {
                    const parsed = parseFloat(value);
                    return isNaN(parsed) ? 0 : parsed;
                }
                return 0;
            }

            function calculatePercentiles(lmsData) {
                if (!lmsData || lmsData.length === 0) return [];
                const result = [];
                
                lmsData.forEach(function(item) {
                    const L = parseValue(item.L);
                    const M = parseValue(item.M);
                    const S = parseValue(item.S);
                    
                    if (M === 0 || S === 0) return;
                    
                    const zScores = [-3, -2, 0, 2, 3];
                    const percentiles = {};
                    
                    zScores.forEach(function(z) {
                        let value;
                        if (Math.abs(L) < 0.01) {
                            value = M * Math.exp(S * z);
                        } else {
                            const power = 1 + L * S * z;
                            if (power > 0) {
                                value = M * Math.pow(power, 1 / L);
                            } else {
                                value = M * Math.exp(S * z);
                            }
                        }
                        percentiles[z] = Math.max(0, value);
                    });
                    
                    result.push({
                        x: item.age || item.height,
                        minus3: percentiles[-3],
                        minus2: percentiles[-2],
                        median: percentiles[0],
                        plus2: percentiles[2],
                        plus3: percentiles[3]
                    });
                });
                
                return result;
            }

            function getAgeCategory(ageMonths) {
                if (ageMonths < 24) {
                    return {
                        category: '0-2 tahun',
                        heightTerm: 'Panjang Badan',
                        heightUnit: 'Panjang Badan (cm)',
                        weightHeightTitle: 'Berat Badan menurut Panjang Badan (0-2 tahun)'
                    };
                } else if (ageMonths < 60) {
                    return {
                        category: '2-5 tahun', 
                        heightTerm: 'Tinggi Badan',
                        heightUnit: 'Tinggi Badan (cm)',
                        weightHeightTitle: 'Berat Badan menurut Tinggi Badan (2-5 tahun)'
                    };
                } else {
                    return {
                        category: '5+ tahun',
                        heightTerm: 'Tinggi Badan', 
                        heightUnit: 'Tinggi Badan (cm)',
                        weightHeightTitle: 'Berat Badan menurut Tinggi Badan (5+ tahun)'
                    };
                }
            }

            // ========================================
            // REKOMENDASI MENGGUNAKAN DATA DARI CONTROLLER
            // ========================================
            
            function updateRecommendationFromBackend(chartType, recommendation) {
                const statusElement = document.getElementById(`${chartType}-status`);
                const adviceElement = document.getElementById(`${chartType}-advice`);
                const targetElement = document.getElementById(`${chartType}-target`);

                if (statusElement && recommendation.recommendation) {
                    statusElement.innerHTML = recommendation.recommendation;
                }

                if (adviceElement && recommendation.z_score !== null) {
                    const zScoreText = `Z-Score: ${recommendation.z_score}`;
                    adviceElement.innerHTML = `<small class="text-muted">${zScoreText}</small>`;
                }

                if (targetElement && recommendation.target_value > 0) {
                    let unit = '';
                    let targetLabel = '';
                    
                    switch (chartType) {
                        case 'weight-age':
                        case 'weight-height':
                            unit = 'kg';
                            targetLabel = 'Rekomendasi berat badan ideal';
                            break;
                        case 'height-age':
                            unit = 'cm';
                            targetLabel = `Rekomendasi ${ageCategory.heightTerm.toLowerCase()} ideal`;
                            break;
                        case 'bmi-age':
                            unit = 'kg/m²';
                            targetLabel = 'Rekomendasi IMT ideal';
                            break;
                    }
                    
                    targetElement.innerHTML = `
                        <strong>${targetLabel}:</strong> 
                        ${recommendation.target_value} ${unit}
                    `;
                }
            }

            // ========================================
            // CHART CONFIGURATION & RENDERING
            // ========================================
            
            const ageCategory = getAgeCategory(patientData.ageMonths);
            
            // Warna border berdasarkan jenis kelamin (seperti kode asli)
            const genderBorderColors = {
                male: '#007bff',    // Biru untuk laki-laki  
                female: '#e91e63'   // Pink untuk perempuan
            };

            const chartBorderColor = patientData.sex == 1 ? genderBorderColors.male : genderBorderColors.female;

            // Update chart container style seperti kode asli
            function updateChartContainerStyle() {
                const chartContainers = document.querySelectorAll('.chart-container');
                chartContainers.forEach(container => {
                    container.style.border = `1px solid ${chartBorderColor}`;
                    container.style.borderRadius = '8px';
                    container.style.padding = '20px';
                });
            }

            function updateChartTitles() {
                const heightAgeTitle = document.querySelector('#height-age .chart-title');
                if (heightAgeTitle) {
                    heightAgeTitle.textContent = `${ageCategory.heightTerm} menurut Umur (${ageCategory.category})`;
                }

                const weightHeightTitle = document.querySelector('#weight-height .chart-title');
                if (weightHeightTitle) {
                    weightHeightTitle.textContent = ageCategory.weightHeightTitle;
                }

                const heightAgeTab = document.querySelector('#height-age-tab');
                if (heightAgeTab) {
                    heightAgeTab.textContent = ageCategory.heightTerm === 'Panjang Badan' ? 'Panjang/Umur' : 'Tinggi/Umur';
                }

                const weightHeightTab = document.querySelector('#weight-height-tab');
                if (weightHeightTab) {
                    weightHeightTab.textContent = ageCategory.heightTerm === 'Panjang Badan' ? 'Berat/Panjang' : 'Berat/Tinggi';
                }
            }

            function getChartConfig(xAxisTitle, yAxisTitle) {
                return {
                    type: 'line',
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: { mode: 'index', intersect: false }
                        },
                        scales: {
                            x: {
                                type: 'linear',
                                position: 'bottom',
                                grid: { color: '#e9ecef' },
                                title: { display: true, text: xAxisTitle }
                            },
                            y: {
                                type: 'linear',
                                grid: { color: '#e9ecef' },
                                title: { display: true, text: yAxisTitle }
                            }
                        },
                        elements: {
                            line: { borderWidth: 2, fill: false, tension: 0.1 },
                            point: { radius: 0, hoverRadius: 3 }
                        },
                        interaction: { mode: 'nearest', axis: 'x', intersect: false }
                    }
                };
            }

            function createChartDatasets(data, patientX, patientY, showPatient = true) {
                const datasets = [
                    {
                        label: '+3 SD',
                        data: data.map(d => ({ x: d.x, y: d.plus3 })),
                        borderColor: '#28a745',
                        backgroundColor: 'transparent',
                        pointRadius: 0
                    },
                    {
                        label: '+2 SD',
                        data: data.map(d => ({ x: d.x, y: d.plus2 })),
                        borderColor: '#ffc107',
                        backgroundColor: 'transparent',
                        pointRadius: 0
                    },
                    {
                        label: 'Median',
                        data: data.map(d => ({ x: d.x, y: d.median })),
                        borderColor: '#007bff',
                        backgroundColor: 'transparent',
                        borderWidth: 3,
                        pointRadius: 0
                    },
                    {
                        label: '-2 SD',
                        data: data.map(d => ({ x: d.x, y: d.minus2 })),
                        borderColor: '#ffc107',
                        backgroundColor: 'transparent',
                        pointRadius: 0
                    },
                    {
                        label: '-3 SD',
                        data: data.map(d => ({ x: d.x, y: d.minus3 })),
                        borderColor: '#dc3545',
                        backgroundColor: 'transparent',
                        pointRadius: 0
                    }
                ];

                if (showPatient && patientX > 0 && patientY > 0) {
                    datasets.push({
                        label: 'Pasien',
                        data: [{ x: patientX, y: patientY }],
                        borderColor: '#dc3545',
                        backgroundColor: '#dc3545',
                        pointRadius: 8,
                        pointStyle: 'circle',
                        showLine: false,
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2
                    });
                }

                return datasets;
            }

            // ========================================
            // GENERATE CHARTS & APPLY RECOMMENDATIONS
            // ========================================
            
            updateChartTitles();
            updateChartContainerStyle(); // Apply gender border seperti kode asli

            // Destroy existing charts
            ['weightAgeChart', 'heightAgeChart', 'weightHeightChart', 'bmiAgeChart'].forEach(chartId => {
                const existingChart = Chart.getChart(chartId);
                if (existingChart) existingChart.destroy();
            });

            // Generate chart data
            let weightAgeData = whoData.weightForAge ? calculatePercentiles(whoData.weightForAge) : [];
            let heightAgeData = whoData.heightForAge ? calculatePercentiles(whoData.heightForAge) : [];
            let bmiAgeData = whoData.bmiForAge ? calculatePercentiles(whoData.bmiForAge) : [];
            let weightHeightData = whoData.weightForHeight ? calculatePercentiles(whoData.weightForHeight) : [];

            // Create Charts
            if (weightAgeData.length > 0) {
                const ctx = document.getElementById('weightAgeChart');
                if (ctx) {
                    const config = getChartConfig('Umur (bulan)', 'Berat Badan (kg)');
                    config.data = {
                        datasets: createChartDatasets(weightAgeData, patientData.ageMonths, patientData.weight)
                    };
                    new Chart(ctx, config);
                    
                    // Apply recommendation from controller
                    if (backendRecommendations.weightAge) {
                        updateRecommendationFromBackend('weight-age', backendRecommendations.weightAge);
                    }
                }
            }

            if (heightAgeData.length > 0) {
                const ctx = document.getElementById('heightAgeChart');
                if (ctx) {
                    const config = getChartConfig('Umur (bulan)', ageCategory.heightUnit);
                    config.data = {
                        datasets: createChartDatasets(heightAgeData, patientData.ageMonths, patientData.height)
                    };
                    new Chart(ctx, config);
                    
                    // Apply recommendation from controller
                    if (backendRecommendations.heightAge) {
                        updateRecommendationFromBackend('height-age', backendRecommendations.heightAge);
                    }
                }
            }

            if (weightHeightData.length > 0) {
                const ctx = document.getElementById('weightHeightChart');
                if (ctx) {
                    const config = getChartConfig(ageCategory.heightUnit, 'Berat Badan (kg)');
                    config.data = {
                        datasets: createChartDatasets(weightHeightData, patientData.height, patientData.weight)
                    };
                    new Chart(ctx, config);
                    
                    // Apply recommendation from controller
                    if (backendRecommendations.weightHeight) {
                        updateRecommendationFromBackend('weight-height', backendRecommendations.weightHeight);
                    }
                }
            }

            if (bmiAgeData.length > 0) {
                const ctx = document.getElementById('bmiAgeChart');
                if (ctx) {
                    const config = getChartConfig('Umur (bulan)', 'IMT (kg/m²)');
                    config.data = {
                        datasets: createChartDatasets(bmiAgeData, patientData.ageMonths, patientData.bmi)
                    };
                    new Chart(ctx, config);
                    
                    // Apply recommendation from controller
                    if (backendRecommendations.bmiAge) {
                        updateRecommendationFromBackend('bmi-age', backendRecommendations.bmiAge);
                    }
                }
            }

            // Handle tab switching for chart resize and gender styling
            const chartTabs = document.querySelectorAll('#chartTabs button[data-bs-toggle="tab"]');
            const genderClass = patientData.sex == 1 ? 'male' : 'female';
            
            chartTabs.forEach(tab => {
                tab.addEventListener('shown.bs.tab', function() {
                    // Update active tab styling
                    chartTabs.forEach(t => {
                        t.classList.remove('male', 'female');
                        t.style.backgroundColor = '';
                        t.style.borderColor = '';
                        t.style.color = '';
                    });
                    
                    this.classList.add('active', genderClass);
                    this.style.backgroundColor = chartBorderColor;
                    this.style.borderColor = chartBorderColor;
                    this.style.color = 'white';
                    
                    setTimeout(() => {
                        Chart.helpers.each(Chart.instances, function(chart) {
                            chart.resize();
                        });
                    }, 100);
                });
                
                // Set initial active tab styling
                if (tab.classList.contains('active')) {
                    tab.classList.add(genderClass);
                    tab.style.backgroundColor = chartBorderColor;
                    tab.style.borderColor = chartBorderColor;
                    tab.style.color = 'white';
                }
            });

            // Show error if no data
            if (weightAgeData.length === 0 && heightAgeData.length === 0 &&
                bmiAgeData.length === 0 && weightHeightData.length === 0) {
                const chartContainer = document.querySelector('.tab-content');
                if (chartContainer) {
                    chartContainer.innerHTML = `
                        <div class="alert alert-warning text-center">
                            <h5><i class="fas fa-exclamation-triangle"></i> Data WHO Tidak Tersedia</h5>
                            <p>Tidak dapat menampilkan kurva pertumbuhan karena data WHO tidak ditemukan.</p>
                        </div>
                    `;
                }
            }
        });
        
    </script>
@endpush