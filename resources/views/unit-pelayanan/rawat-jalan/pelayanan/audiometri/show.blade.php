@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .page-header {
            background: linear-gradient(135deg, #ffffff 0%, #cee2ff 100%);
            color: rgb(0, 0, 0);
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .summary-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 1.25rem;
            text-align: center;
        }

        .summary-value {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.25rem;
        }

        .summary-label {
            color: #6b7280;
            font-size: 0.875rem;
            margin-bottom: 0.75rem;
        }

        .hearing-status {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-normal { background-color: #dcfce7; color: #166534; }
        .status-ringan { background-color: #fef3c7; color: #92400e; }
        .status-sedang { background-color: #fed7aa; color: #c2410c; }
        .status-berat { background-color: #fecaca; color: #dc2626; }
        .status-sangat-berat { background-color: #e0e7ff; color: #6366f1; }

        .data-table {
            font-size: 0.875rem;
            margin-bottom: 0;
        }

        .data-table th {
            background-color: #f8fafc;
            color: #374151;
            font-weight: 600;
            text-align: center;
            padding: 0.75rem 0.5rem;
            border: 1px solid #e5e7eb;
        }

        .data-table td {
            text-align: center;
            padding: 0.75rem 0.5rem;
            border: 1px solid #e5e7eb;
        }

        .conduction-label {
            background-color: #f1f5f9;
            font-weight: 600;
            text-align: left;
            padding-left: 1rem;
        }

        .average-cell {
            background-color: #fef3c7;
            font-weight: 600;
            color: #92400e;
        }

        .chart-container {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .section-title {
            color: #374151;
            font-weight: 600;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e5e7eb;
        }

        .info-box {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 1.25rem;
        }

        .legend-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 0.75rem;
        }

        .legend-item {
            text-align: center;
        }

        .legend-item small {
            display: block;
            color: #6b7280;
            margin-top: 0.25rem;
        }

        @media print {
            .btn, .btn-group { display: none !important; }
            .page-header { background: #ffffff !important; }
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <a href="{{ route('rawat-jalan.audiometri.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}" 
               class="btn btn-outline-secondary mb-3">
                <i class="ti-arrow-left"></i> Kembali ke Daftar
            </a>

            <div class="card shadow-sm">
                <div class="card-body">
                    <!-- Header -->
                    <div class="page-header">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h4 class="mb-2">
                                    <i class="ti-volume mr-2"></i>Detail Hasil Audiometri
                                </h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($dataAudiometri->tanggal_pemeriksaan)->format('d F Y') }}</p>
                                        <p class="mb-0"><strong>Jam:</strong> {{ \Carbon\Carbon::parse($dataAudiometri->jam_pemeriksaan)->format('H:i') }} WIB</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-0"><strong>Pemeriksa:</strong> {{ $dataAudiometri->pemeriksa ?? 'Tidak disebutkan' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 text-end">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('rawat-jalan.audiometri.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $dataAudiometri->id]) }}" 
                                       class="btn btn-warning btn-sm">
                                        <i class="ti-pencil"></i> Edit
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Summary -->
                    <div class="summary-grid">
                        <div class="summary-card">
                            <div class="summary-value">{{ number_format($acKanan['rata_rata'] ?? 0, 1) }} dB</div>
                            <div class="summary-label">AC Telinga Kanan</div>
                            @php
                                $avgKanan = $acKanan['rata_rata'] ?? 0;
                                if ($avgKanan <= 25) $statusKanan = ['normal', 'Normal'];
                                elseif ($avgKanan <= 40) $statusKanan = ['ringan', 'Ringan'];
                                elseif ($avgKanan <= 55) $statusKanan = ['sedang', 'Sedang'];
                                elseif ($avgKanan <= 70) $statusKanan = ['berat', 'Berat'];
                                else $statusKanan = ['sangat-berat', 'Sangat Berat'];
                            @endphp
                            <span class="hearing-status status-{{ $statusKanan[0] }}">{{ $statusKanan[1] }}</span>
                        </div>

                        <div class="summary-card">
                            <div class="summary-value">{{ number_format($acKiri['rata_rata'] ?? 0, 1) }} dB</div>
                            <div class="summary-label">AC Telinga Kiri</div>
                            @php
                                $avgKiri = $acKiri['rata_rata'] ?? 0;
                                if ($avgKiri <= 25) $statusKiri = ['normal', 'Normal'];
                                elseif ($avgKiri <= 40) $statusKiri = ['ringan', 'Ringan'];
                                elseif ($avgKiri <= 55) $statusKiri = ['sedang', 'Sedang'];
                                elseif ($avgKiri <= 70) $statusKiri = ['berat', 'Berat'];
                                else $statusKiri = ['sangat-berat', 'Sangat Berat'];
                            @endphp
                            <span class="hearing-status status-{{ $statusKiri[0] }}">{{ $statusKiri[1] }}</span>
                        </div>

                        <div class="summary-card">
                            <div class="summary-value">{{ number_format(($acKanan['rata_rata'] + $acKiri['rata_rata']) / 2, 1) }} dB</div>
                            <div class="summary-label">Rata-rata Kedua Telinga</div>
                        </div>

                        <div class="summary-card">
                            @php
                                $gapKanan = abs(($acKanan['rata_rata'] ?? 0) - ($bcKanan['rata_rata'] ?? 0));
                                $gapKiri = abs(($acKiri['rata_rata'] ?? 0) - ($bcKiri['rata_rata'] ?? 0));
                                $avgGap = ($gapKanan + $gapKiri) / 2;
                            @endphp
                            <div class="summary-value">{{ number_format($avgGap, 1) }} dB</div>
                            <div class="summary-label">Air-Bone Gap</div>
                        </div>
                    </div>

                    <!-- Chart -->
                    <div class="chart-container">
                        <h5 class="section-title">Grafik Audiogram</h5>
                        <canvas id="audiogramChart" style="max-height: 500px;"></canvas>
                    </div>

                    <!-- Data Tables -->
                    <div class="row">
                        <!-- Telinga Kanan -->
                        <div class="col-md-6">
                            <h5 class="section-title">Telinga Kanan</h5>
                            <div class="table-responsive">
                                <table class="table data-table">
                                    <thead>
                                        <tr>
                                            <th>Frekuensi (Hz)</th>
                                            <th>250</th>
                                            <th>500</th>
                                            <th>1000</th>
                                            <th>2000</th>
                                            <th>3000</th>
                                            <th>4000</th>
                                            <th>6000</th>
                                            <th>8000</th>
                                            <th>Avg</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="conduction-label">AC (dB HL)</td>
                                            <td>{{ $acKanan['250'] ?? '-' }}</td>
                                            <td>{{ $acKanan['500'] ?? '-' }}</td>
                                            <td>{{ $acKanan['1000'] ?? '-' }}</td>
                                            <td>{{ $acKanan['2000'] ?? '-' }}</td>
                                            <td>{{ $acKanan['3000'] ?? '-' }}</td>
                                            <td>{{ $acKanan['4000'] ?? '-' }}</td>
                                            <td>{{ $acKanan['6000'] ?? '-' }}</td>
                                            <td>{{ $acKanan['8000'] ?? '-' }}</td>
                                            <td class="average-cell">{{ number_format($acKanan['rata_rata'] ?? 0, 1) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="conduction-label">BC (dB HL)</td>
                                            <td>{{ $bcKanan['250'] ?? '-' }}</td>
                                            <td>{{ $bcKanan['500'] ?? '-' }}</td>
                                            <td>{{ $bcKanan['1000'] ?? '-' }}</td>
                                            <td>{{ $bcKanan['2000'] ?? '-' }}</td>
                                            <td>{{ $bcKanan['3000'] ?? '-' }}</td>
                                            <td>{{ $bcKanan['4000'] ?? '-' }}</td>
                                            <td>{{ $bcKanan['6000'] ?? '-' }}</td>
                                            <td>{{ $bcKanan['8000'] ?? '-' }}</td>
                                            <td class="average-cell">{{ number_format($bcKanan['rata_rata'] ?? 0, 1) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="conduction-label">Gap (dB)</td>
                                            <td>{{ abs(($acKanan['250'] ?? 0) - ($bcKanan['250'] ?? 0)) }}</td>
                                            <td>{{ abs(($acKanan['500'] ?? 0) - ($bcKanan['500'] ?? 0)) }}</td>
                                            <td>{{ abs(($acKanan['1000'] ?? 0) - ($bcKanan['1000'] ?? 0)) }}</td>
                                            <td>{{ abs(($acKanan['2000'] ?? 0) - ($bcKanan['2000'] ?? 0)) }}</td>
                                            <td>{{ abs(($acKanan['3000'] ?? 0) - ($bcKanan['3000'] ?? 0)) }}</td>
                                            <td>{{ abs(($acKanan['4000'] ?? 0) - ($bcKanan['4000'] ?? 0)) }}</td>
                                            <td>{{ abs(($acKanan['6000'] ?? 0) - ($bcKanan['6000'] ?? 0)) }}</td>
                                            <td>{{ abs(($acKanan['8000'] ?? 0) - ($bcKanan['8000'] ?? 0)) }}</td>
                                            <td class="average-cell">{{ number_format($gapKanan, 1) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Telinga Kiri -->
                        <div class="col-md-6">
                            <h5 class="section-title">Telinga Kiri</h5>
                            <div class="table-responsive">
                                <table class="table data-table">
                                    <thead>
                                        <tr>
                                            <th>Frekuensi (Hz)</th>
                                            <th>250</th>
                                            <th>500</th>
                                            <th>1000</th>
                                            <th>2000</th>
                                            <th>3000</th>
                                            <th>4000</th>
                                            <th>6000</th>
                                            <th>8000</th>
                                            <th>Avg</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="conduction-label">AC (dB HL)</td>
                                            <td>{{ $acKiri['250'] ?? '-' }}</td>
                                            <td>{{ $acKiri['500'] ?? '-' }}</td>
                                            <td>{{ $acKiri['1000'] ?? '-' }}</td>
                                            <td>{{ $acKiri['2000'] ?? '-' }}</td>
                                            <td>{{ $acKiri['3000'] ?? '-' }}</td>
                                            <td>{{ $acKiri['4000'] ?? '-' }}</td>
                                            <td>{{ $acKiri['6000'] ?? '-' }}</td>
                                            <td>{{ $acKiri['8000'] ?? '-' }}</td>
                                            <td class="average-cell">{{ number_format($acKiri['rata_rata'] ?? 0, 1) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="conduction-label">BC (dB HL)</td>
                                            <td>{{ $bcKiri['250'] ?? '-' }}</td>
                                            <td>{{ $bcKiri['500'] ?? '-' }}</td>
                                            <td>{{ $bcKiri['1000'] ?? '-' }}</td>
                                            <td>{{ $bcKiri['2000'] ?? '-' }}</td>
                                            <td>{{ $bcKiri['3000'] ?? '-' }}</td>
                                            <td>{{ $bcKiri['4000'] ?? '-' }}</td>
                                            <td>{{ $bcKiri['6000'] ?? '-' }}</td>
                                            <td>{{ $bcKiri['8000'] ?? '-' }}</td>
                                            <td class="average-cell">{{ number_format($bcKiri['rata_rata'] ?? 0, 1) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="conduction-label">Gap (dB)</td>
                                            <td>{{ abs(($acKiri['250'] ?? 0) - ($bcKiri['250'] ?? 0)) }}</td>
                                            <td>{{ abs(($acKiri['500'] ?? 0) - ($bcKiri['500'] ?? 0)) }}</td>
                                            <td>{{ abs(($acKiri['1000'] ?? 0) - ($bcKiri['1000'] ?? 0)) }}</td>
                                            <td>{{ abs(($acKiri['2000'] ?? 0) - ($bcKiri['2000'] ?? 0)) }}</td>
                                            <td>{{ abs(($acKiri['3000'] ?? 0) - ($bcKiri['3000'] ?? 0)) }}</td>
                                            <td>{{ abs(($acKiri['4000'] ?? 0) - ($bcKiri['4000'] ?? 0)) }}</td>
                                            <td>{{ abs(($acKiri['6000'] ?? 0) - ($bcKiri['6000'] ?? 0)) }}</td>
                                            <td>{{ abs(($acKiri['8000'] ?? 0) - ($bcKiri['8000'] ?? 0)) }}</td>
                                            <td class="average-cell">{{ number_format($gapKiri, 1) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Interpretasi dan Catatan -->
                    @if($dataAudiometri->interpretasi || $dataAudiometri->catatan)
                        <div class="row mt-4">
                            @if($dataAudiometri->interpretasi)
                                <div class="col-md-6">
                                    <h5 class="section-title">Interpretasi</h5>
                                    <div class="info-box">
                                        <p class="mb-0">{{ $dataAudiometri->interpretasi }}</p>
                                    </div>
                                </div>
                            @endif

                            @if($dataAudiometri->catatan)
                                <div class="col-md-6">
                                    <h5 class="section-title">Catatan</h5>
                                    <div class="info-box">
                                        <p class="mb-0">{{ $dataAudiometri->catatan }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Legend -->
                    <div class="mt-4">
                        <div class="info-box">
                            <h6 class="mb-3">Keterangan Tingkat Gangguan Pendengaran</h6>
                            <div class="legend-grid">
                                <div class="legend-item">
                                    <span class="hearing-status status-normal">Normal</span>
                                    <small>≤ 25 dB HL</small>
                                </div>
                                <div class="legend-item">
                                    <span class="hearing-status status-ringan">Ringan</span>
                                    <small>26-40 dB HL</small>
                                </div>
                                <div class="legend-item">
                                    <span class="hearing-status status-sedang">Sedang</span>
                                    <small>41-55 dB HL</small>
                                </div>
                                <div class="legend-item">
                                    <span class="hearing-status status-berat">Berat</span>
                                    <small>56-70 dB HL</small>
                                </div>
                                <div class="legend-item">
                                    <span class="hearing-status status-sangat-berat">Sangat Berat</span>
                                    <small>> 70 dB HL</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('audiogramChart').getContext('2d');
            const chartData = @json($chartData);
            
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartData.frequencies.map(f => f + ' Hz'),
                    datasets: [
                        {
                            label: 'AC Kanan',
                            data: chartData.ac_kanan,
                            borderColor: '#dc2626',
                            backgroundColor: 'rgba(220, 38, 38, 0.1)',
                            borderWidth: 2,
                            pointStyle: 'circle',
                            pointRadius: 5,
                            tension: 0.1
                        },
                        {
                            label: 'BC Kanan',
                            data: chartData.bc_kanan,
                            borderColor: '#dc2626',
                            backgroundColor: 'rgba(220, 38, 38, 0.1)',
                            borderWidth: 2,
                            pointStyle: 'cross',
                            pointRadius: 5,
                            tension: 0.1
                        },
                        {
                            label: 'AC Kiri',
                            data: chartData.ac_kiri,
                            borderColor: '#2563eb',
                            backgroundColor: 'rgba(37, 99, 235, 0.1)',
                            borderWidth: 2,
                            pointStyle: 'rectRot',
                            pointRadius: 5,
                            tension: 0.1
                        },
                        {
                            label: 'BC Kiri',
                            data: chartData.bc_kiri,
                            borderColor: '#2563eb',
                            backgroundColor: 'rgba(37, 99, 235, 0.1)',
                            borderWidth: 2,
                            pointStyle: 'triangle',
                            pointRadius: 5,
                            tension: 0.1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: false
                        },
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Frekuensi (Hz)'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Threshold (dB HL)'
                            },
                            reverse: true,
                            min: -10,
                            max: 140,
                            ticks: {
                                stepSize: 10
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush