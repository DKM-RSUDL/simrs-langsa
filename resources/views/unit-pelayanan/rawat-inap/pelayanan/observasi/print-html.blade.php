<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Observasi Pasien</title>
    
    <!-- Load Chart.js via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            line-height: 1.3;
            margin: 0;
            padding: 0;
            background-color: white;
        }

        @media print {
            @page {
                size: A4 portrait;
                margin: 10mm;
            }
            
            body {
                width: 100%;
                font-size: 10pt;
            }
            
            .no-print {
                display: none !important;
            }
            
            .page-break {
                page-break-after: always;
            }
            
            .no-page-break {
                page-break-inside: avoid;
            }
        }
        
        .print-page {
            min-height: 100vh;
            position: relative;
        }
        
        .header {
            width: 100%;
            margin-bottom: 20px;
            overflow: hidden;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        
        .logo-hospital-container {
            float: left;
            width: 60%;
            display: table;
            margin-bottom: 10px;
        }
        
        .logo-cell {
            display: table-cell;
            vertical-align: top;
            width: 80px;
        }
        
        .hospital-info-cell {
            display: table-cell;
            vertical-align: top;
            padding-left: 10px;
        }
        
        .logo {
            height: 70px;
            width: auto;
        }
        
        .hospital-info {
            font-size: 10pt;
            line-height: 1.4;
        }
        
        .hospital-name {
            font-weight: bold;
            font-size: 12pt;
            margin-bottom: 3px;
        }
        
        .report-title {
            font-size: 14pt;
            font-weight: bold;
            margin: 10px 0 5px 0;
            clear: both;
        }
        
        .patient-info-container {
            float: right;
            width: 38%;
            font-size: 10pt;
            padding-top: 5px;
        }
        
        .patient-info {
            border-collapse: collapse;
            width: 100%;
        }
        
        .patient-info td {
            padding: 3px 0;
            vertical-align: top;
        }
        
        .patient-info td:first-child {
            font-weight: bold;
            width: 130px;
        }
        
        .patient-info td:nth-child(2) {
            width: 15px;
            text-align: center;
        }
        
        .date-range {
            font-size: 11pt;
            text-align: center;
            margin: 10px 0 15px 0;
        }
        
        /* Chart container styles */
        .charts-container {
            margin: 20px 0 40px 0;
            page-break-inside: avoid;
            height: 400px;
        }
        
        .chart-item {
            width: 100%;
            height: 400px;
            border: 1px solid #ddd;
            padding: 10px;
            box-sizing: border-box;
            background-color: white;
        }
        
        .chart-title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 14pt;
        }
        
        /* Chart legend styles */
        .chart-legend {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 10px;
            font-size: 9pt;
            justify-content: center;
        }
        
        .legend-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .legend-color {
            width: 15px;
            height: 15px;
            border-radius: 3px;
        }
        
        table.observasi {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            margin-top: 80px;
            font-size: 7pt;
        }
        
        table.observasi th, table.observasi td {
            border: 1px solid #000;
            padding: 4px;
            text-align: center;
        }
        
        table.observasi th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        
        table.observasi tr.field-row td:first-child {
            text-align: left;
            font-weight: bold;
            width: 150px;
        }
        
        .date-row {
            background-color: #e0e0e0;
            font-weight: bold;
        }
        
        .clearfix {
            clear: both;
        }
        
        .document-number {
            position: absolute;
            bottom: 20px;
            right: 20px;
            font-size: 8pt;
            text-align: right;
        }
        
        .divider {
            width: 100%;
            border-bottom: 1px solid #000;
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <!-- Print Controls -->
    <div class="no-print d-print-none mb-3 p-3 bg-light">
        <div class="d-flex justify-content-between">
            <button onclick="window.print()" class="btn btn-primary" id="printBtn">
                <i class="bi bi-printer me-1"></i> Print
            </button>
            <button onclick="window.close()" class="btn btn-secondary">
                <i class="bi bi-x me-1"></i> Tutup
            </button>
        </div>
    </div>

    @php
        // Group observations into chunks of 4 for pagination
        $observasiChunks = $observasiList->chunk(4);
        $totalPages = count($observasiChunks);
        $currentPage = 1;
    @endphp

    @foreach($observasiChunks as $chunkIndex => $observasiChunk)
        <div class="print-page">
            <!-- Header yang diulang di setiap halaman -->
            <div class="header">
                <div class="logo-hospital-container">
                    <div class="logo-cell">
                        @if($logoPath)
                            <img src="{{ $logoPath }}" alt="Logo Rumah Sakit" class="logo">
                        @else
                            <div style="height: 80px; width: 80px; text-align: center; border: 1px solid #ddd; display: flex; align-items: center; justify-content: center;">
                                <span style="font-weight: bold; font-size: 14pt;">LOGO</span>
                            </div>
                        @endif
                    </div>
                    <div class="hospital-info-cell">
                        <div class="hospital-name">RSUD LANGSA</div>
                        Jl. Jend. A. Yani No. 1 Kota Langsa<br>
                        Tel. 0641-22051
                        <h1 class="report-title">EVALUASI HARIAN/<br>CATATAN OBSERVASI</h1>
                    </div>
                </div>
                
                <div class="patient-info-container">
                    <table class="patient-info">
                        <tr>
                            <td>No. RM</td>
                            <td>:</td>
                            <td>{{ $dataMedis->kd_pasien }}</td>
                        </tr>
                        <tr>
                            <td>Nama Pasien</td>
                            <td>:</td>
                            <td>{{ $dataMedis->pasien->nama_pasien ?? $dataMedis->pasien->nama }}</td>
                        </tr>
                        <tr>
                            <td>Jenis Kelamin</td>
                            <td>:</td>
                            <td>{{ $dataMedis->pasien->jns_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Lahir</td>
                            <td>:</td>
                            <td>{{ $dataMedis->pasien->tgl_lahir ? date('d-m-Y', strtotime($dataMedis->pasien->tgl_lahir)) : 'Tidak Diketahui' }}</td>
                        </tr>
                        <tr>
                            <td>Unit Rawat</td>
                            <td>:</td>
                            <td>{{ $dataMedis->unit->nama_unit }}</td>
                        </tr>
                    </table>
                </div>
                
                <div class="clearfix"></div>
            </div>

            @if($startDate && $endDate && $currentPage == 1)
                <div class="date-range">
                    Periode: {{ $startDate }} s/d {{ $endDate }}
                </div>
            @endif

            @php
                // Prepare chart data for current chunk
                $currentChartData = [
                    'labels' => [],
                    'suhu' => [],
                    'nadi' => [],
                    'tekanan_sistole' => [],
                    'tekanan_diastole' => [],
                    'respirasi' => []
                ];
                
                foreach($observasiChunk as $observasi) {
                    foreach($observasi->details as $detail) {
                        $label = $observasi->tanggal->format('d/m') . ' ' . $detail->waktu;
                        $currentChartData['labels'][] = $label;
                        $currentChartData['suhu'][] = (float)$detail->suhu;
                        $currentChartData['nadi'][] = (float)$detail->nadi;
                        $currentChartData['tekanan_sistole'][] = (float)$detail->tekanan_darah_sistole;
                        $currentChartData['tekanan_diastole'][] = (float)$detail->tekanan_darah_diastole;
                        $currentChartData['respirasi'][] = (float)$detail->respirasi;
                    }
                }
            @endphp

            <!-- Display chart on every page if there's data -->
            @if(count($observasiChunk) > 0)
                <div class="charts-container">
                    <div class="chart-item">
                        <div class="chart-title">Grafik Vital Signs</div>
                        
                        <!-- Legend -->
                        <div class="chart-legend">
                            <div class="legend-item">
                                <div class="legend-color" style="background-color: #7DD3FC;"></div>
                                <span>Sistole</span>
                            </div>
                            <div class="legend-item">
                                <div class="legend-color" style="background-color: #F59E0B;"></div>
                                <span>Diastole</span>
                            </div>
                            <div class="legend-item">
                                <div class="legend-color" style="background-color: #10B981;"></div>
                                <span>HR</span>
                            </div>
                            <div class="legend-item">
                                <div class="legend-color" style="background-color: #8B5CF6;"></div>
                                <span>RR</span>
                            </div>
                            <div class="legend-item">
                                <div class="legend-color" style="background-color: #EC4899;"></div>
                                <span>Suhu</span>
                            </div>
                            <div class="legend-item">
                                <div class="legend-color" style="background-color: #6B7280;"></div>
                                <span>MAP</span>
                            </div>
                        </div>
                        
                        <canvas id="vitalChart{{ $currentPage }}" width="800" height="400"></canvas>
                    </div>
                </div>
            @endif

            @php
                // Get all unique timestamps from all observations in this chunk
                $allTimestamps = [];
                foreach($observasiChunk as $observasi) {
                    foreach($observasi->details as $detail) {
                        if (!in_array($detail->waktu, $allTimestamps)) {
                            $allTimestamps[] = $detail->waktu;
                        }
                    }
                }
                // Sort timestamps
                sort($allTimestamps);
            @endphp

            <table class="observasi">
                <thead>
                    <tr class="date-row">
                        <th rowspan="1">Parameter</th>
                        @foreach($observasiChunk as $observasi)
                            <th colspan="{{ count($allTimestamps) > 0 ? count($allTimestamps) : 1 }}">
                                {{ $observasi->tanggal->format('d-m-Y') }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <!-- Berat Badan -->
                    <tr class="field-row">
                        <td>Berat Badan (kg)</td>
                        @foreach($observasiChunk as $observasi)
                            <td colspan="{{ count($allTimestamps) > 0 ? count($allTimestamps) : 1 }}">{{ $observasi->berat_badan }}</td>
                        @endforeach
                    </tr>
                    
                    <!-- Sensorium -->
                    <tr class="field-row">
                        <td>Sensorium</td>
                        @foreach($observasiChunk as $observasi)
                            <td colspan="{{ count($allTimestamps) > 0 ? count($allTimestamps) : 1 }}">{{ $observasi->sensorium }}</td>
                        @endforeach
                    </tr>
                    
                    <!-- Alat Invasive -->
                    <tr class="field-row">
                        <td>Alat Invasive</td>
                        @foreach($observasiChunk as $observasi)
                            <td colspan="{{ count($allTimestamps) > 0 ? count($allTimestamps) : 1 }}">{{ $observasi->alat_invasive ?? '-' }}</td>
                        @endforeach
                    </tr>
                    
                    <!-- NGT -->
                    <tr class="field-row">
                        <td>NGT</td>
                        @foreach($observasiChunk as $observasi)
                            <td colspan="{{ count($allTimestamps) > 0 ? count($allTimestamps) : 1 }}">{{ $observasi->ngt ?? '-' }}</td>
                        @endforeach
                    </tr>
                    
                    <!-- Catheter -->
                    <tr class="field-row">
                        <td>Catheter</td>
                        @foreach($observasiChunk as $observasi)
                            <td colspan="{{ count($allTimestamps) > 0 ? count($allTimestamps) : 1 }}">{{ $observasi->catheter ?? '-' }}</td>
                        @endforeach
                    </tr>
                    
                    <!-- Diet -->
                    <tr class="field-row">
                        <td>Diet</td>
                        @foreach($observasiChunk as $observasi)
                            <td colspan="{{ count($allTimestamps) > 0 ? count($allTimestamps) : 1 }}">{{ $observasi->diet ?? '-' }}</td>
                        @endforeach
                    </tr>
                    
                    <!-- Alergi -->
                    <tr class="field-row">
                        <td>Alergi</td>
                        @foreach($observasiChunk as $observasi)
                            <td colspan="{{ count($allTimestamps) > 0 ? count($allTimestamps) : 1 }}">{{ $observasi->alergi ?? '-' }}</td>
                        @endforeach
                    </tr>
                    
                    <!-- Petugas -->
                    <tr class="field-row">
                        <td>Petugas</td>
                        @foreach($observasiChunk as $observasi)
                            <td colspan="{{ count($allTimestamps) > 0 ? count($allTimestamps) : 1 }}">{{ $observasi->creator->name ?? 'Tidak Diketahui' }}</td>
                        @endforeach
                    </tr>
                </tbody>
            </table>

            <div class="document-number">
                No: D.11/IRM/Rev 1/2017
            </div>

            <!-- JavaScript for current page chart -->
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Prepare chart data for page {{ $currentPage }}
                    const chartData{{ $currentPage }} = @json($currentChartData);
                    
                    // Calculate MAP (Mean Arterial Pressure)
                    const mapData{{ $currentPage }} = chartData{{ $currentPage }}.tekanan_sistole.map((sistole, index) => {
                        const diastole = chartData{{ $currentPage }}.tekanan_diastole[index];
                        if (sistole && diastole) {
                            return Math.round((sistole + 2 * diastole) / 3);
                        }
                        return null;
                    });
                    
                    // Configure chart for page {{ $currentPage }}
                    const ctx{{ $currentPage }} = document.getElementById('vitalChart{{ $currentPage }}').getContext('2d');
                    
                    new Chart(ctx{{ $currentPage }}, {
                        type: 'line',
                        data: {
                            labels: chartData{{ $currentPage }}.labels,
                            datasets: [
                                {
                                    label: 'Sistole',
                                    data: chartData{{ $currentPage }}.tekanan_sistole,
                                    borderColor: '#7DD3FC',
                                    backgroundColor: 'rgba(125, 211, 252, 0.3)',
                                    fill: true,
                                    tension: 0.4,
                                    pointBackgroundColor: '#7DD3FC',
                                    pointBorderColor: '#0EA5E9',
                                    pointRadius: 4
                                },
                                {
                                    label: 'Diastole',
                                    data: chartData{{ $currentPage }}.tekanan_diastole,
                                    borderColor: '#F59E0B',
                                    backgroundColor: 'rgba(245, 158, 11, 0.3)',
                                    fill: true,
                                    tension: 0.4,
                                    pointBackgroundColor: '#F59E0B',
                                    pointBorderColor: '#D97706',
                                    pointRadius: 4
                                },
                                {
                                    label: 'HR (Nadi)',
                                    data: chartData{{ $currentPage }}.nadi,
                                    borderColor: '#10B981',
                                    backgroundColor: 'rgba(16, 185, 129, 0.3)',
                                    fill: true,
                                    tension: 0.4,
                                    pointBackgroundColor: '#10B981',
                                    pointBorderColor: '#059669',
                                    pointRadius: 4
                                },
                                {
                                    label: 'RR (Respirasi)',
                                    data: chartData{{ $currentPage }}.respirasi,
                                    borderColor: '#8B5CF6',
                                    backgroundColor: 'rgba(139, 92, 246, 0.3)',
                                    fill: true,
                                    tension: 0.4,
                                    pointBackgroundColor: '#8B5CF6',
                                    pointBorderColor: '#7C3AED',
                                    pointRadius: 4
                                },
                                {
                                    label: 'Suhu',
                                    data: chartData{{ $currentPage }}.suhu,
                                    borderColor: '#EC4899',
                                    backgroundColor: 'rgba(236, 72, 153, 0.3)',
                                    fill: true,
                                    tension: 0.4,
                                    pointBackgroundColor: '#EC4899',
                                    pointBorderColor: '#DB2777',
                                    pointRadius: 4
                                },
                                {
                                    label: 'MAP',
                                    data: mapData{{ $currentPage }},
                                    borderColor: '#6B7280',
                                    backgroundColor: 'rgba(107, 114, 128, 0.3)',
                                    fill: true,
                                    tension: 0.4,
                                    pointBackgroundColor: '#6B7280',
                                    pointBorderColor: '#4B5563',
                                    pointRadius: 4
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            interaction: {
                                intersect: false,
                                mode: 'index'
                            },
                            plugins: {
                                legend: {
                                    display: false // Using custom legend
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                    titleColor: 'white',
                                    bodyColor: 'white',
                                    borderColor: 'rgba(255, 255, 255, 0.1)',
                                    borderWidth: 1
                                }
                            },
                            scales: {
                                x: {
                                    display: true,
                                    grid: {
                                        display: true,
                                        color: 'rgba(0, 0, 0, 0.1)'
                                    },
                                    ticks: {
                                        maxRotation: 45,
                                        minRotation: 0
                                    }
                                },
                                y: {
                                    display: true,
                                    beginAtZero: false,
                                    grid: {
                                        display: true,
                                        color: 'rgba(0, 0, 0, 0.1)'
                                    },
                                    ticks: {
                                        callback: function(value) {
                                            return value;
                                        }
                                    }
                                }
                            },
                            elements: {
                                line: {
                                    tension: 0.4
                                }
                            }
                        }
                    });
                });
            </script>
        </div>

        @if($currentPage < $totalPages)
            <div class="page-break"></div>
            @php $currentPage++; @endphp
        @endif
    @endforeach
</body>
</html>