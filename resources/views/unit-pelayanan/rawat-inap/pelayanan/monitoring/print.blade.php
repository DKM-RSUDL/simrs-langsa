<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Monitoring Pasien</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: white;
        }

        @media print {
            @page {
                size: landscape;
                margin: 10mm;
            }

            body {
                width: 100%;
                font-size: 12px;
            }

            .table-header {
                background-color: #f8f9fa !important;
                -webkit-print-color-adjust: exact;
            }

            .print-container {
                width: 100%;
                margin: 0 auto;
            }

            .print-header {
                text-align: center;
                margin-bottom: 20px;
            }

            .page-break {
                page-break-after: always;
            }

            .no-page-break {
                page-break-inside: avoid;
            }

            .no-print {
                display: none !important;
            }

            .filter-info {
                background-color: #e9ecef !important;
                -webkit-print-color-adjust: exact;
            }

            .parameter-header {
                background-color: #f8f9fa !important;
                -webkit-print-color-adjust: exact;
            }

            .patient-info {
                background-color: #f8f9fa !important;
                -webkit-print-color-adjust: exact;
            }
        }

        .print-container {
            padding: 20px;
        }

        /* New layout for header row */
        .header-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            position: relative;
        }

        /* RM number positioning */
        .rm-number {
            position: absolute;
            top: 0;
            left: 0;
            font-weight: bold;
            font-size: 14px;
            z-index: 100;
        }

        .no-right {
            position: absolute;
            top: 0;
            left: 0;
            font-weight: bold;
            font-size: 14px;
            z-index: 100;
            width: 100%;
            text-align: right;
        }

        /* New header structure */
        .patient-column {
            flex: 1;
        }

        .hospital-header {
            flex: 2;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 15px;
        }

        .hospital-logo {
            height: 100px;
            margin-right: 15px;
        }

        .header-title {
            text-align: center;
        }

        .header-title h2,
        .header-title h4 {
            margin: 5px 0;
        }

        .header-title h5 {
            margin: 10px 0;
        }

        .diagnosis-column {
            flex: 1;
        }

        /* Patient info styling */
        .patient-info-container {
            margin-bottom: 15px;
        }

        .patient-info {
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        .diagnosis-info {
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        .patient-info-item {
            margin-bottom: 5px;
        }

        .vital-signs-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .vital-signs-table th {
            background-color: #cdcdcd;
            padding: 8px;
            text-align: center;
            border: 1px solid #b8b8b8;
            font-weight: bold;
        }

        .vital-signs-table td {
            padding: 6px;
            text-align: center;
            border-top: 1px solid #a1a1a1;
            border-bottom: 1px solid #b8b8b8;
            border-left: 1px solid #b8b8b8;
            border-right: 1px solid #b8b8b8;
        }

        .vital-signs-table tr:last-child td {
            border-bottom: 1px solid #b8b8b8;
        }

        .parameter-header {
            text-align: left;
            font-weight: bold;
            background-color: #f8f9fa;
            border: 1px solid #b8b8b8 !important;
        }

        .filter-info {
            margin: 10px 0;
            padding: 5px;
            background-color: #e9ecef;
            border-radius: 3px;
            font-style: italic;
        }

        .print-footer {
            text-align: center;
            font-size: 12px;
            margin-top: 20px;
            color: #6c757d;
        }

        .signature {
            margin-top: 50px;
            text-align: right;
            padding-right: 50px;
        }

        #loadingIndicator {
            text-align: center;
            padding: 20px;
            font-size: 18px;
        }
    </style>
</head>

<body>
    <!-- Button controls - only visible before print -->
    <div class="no-print d-print-none mb-3 p-3 bg-light">
        <div class="d-flex justify-content-between">
            <button onclick="window.print()" class="btn btn-primary" id="printBtn" disabled>
                <i class="bi bi-printer me-1"></i> Print
            </button>
            <button onclick="window.close()" class="btn btn-secondary">
                <i class="bi bi-x me-1"></i> Tutup
            </button>
        </div>
    </div>

    <!-- Loading indicator -->
    <div id="loadingIndicator">
        <i class="bi bi-hourglass-split me-2"></i> Memuat data monitoring...
    </div>

    <!-- Main content -->
    <div class="print-container" style="display: none;" id="printContent">
        <!-- RM Number - top left corner -->
        <div class="rm-number">
            <strong>No. RM:</strong> {{ $dataMedis->pasien->kd_pasien ?? '-' }}
        </div>
        <div class="no-right">
            <strong>NO: K.7/IRM/Rev 0/2017</strong>
        </div>

        <!-- New 3-column layout for header row -->
        <div class="header-row">
            <!-- Left column - Patient info -->
            <div class="patient-column">
                <div class="patient-info">
                    <div class="patient-info-item"><strong>Nama Pasien:</strong> {{ $dataMedis->pasien->nama ?? '-' }}
                    </div>
                    <div class="patient-info-item"><strong>Umur:</strong> {{ $dataMedis->pasien->umur ?? '-' }} tahun
                    </div>
                    <div class="patient-info-item"><strong>Berat Badan:</strong>
                        {{ $latestMonitoring ? number_format($latestMonitoring->berat_badan, 1) : '-' }} kg
                    </div>
                    <div class="patient-info-item"><strong>Tinggi Badan:</strong>
                        {{ $latestMonitoring ? number_format($latestMonitoring->tinggi_badan, 1) : '-' }} cm
                    </div>
                </div>
            </div>

            <!-- Center column - Hospital logo and title -->
            <div class="hospital-header">
                <img src="{{ asset('assets/img/Logo-RSUD-Langsa-1.png') }}" alt="Logo Rumah Sakit"
                    class="hospital-logo">
                <div class="header-title">
                    <h5>PEMERINTAH KOTA LANGSA <br>RUMAH SAKIT UMUM DAERAH LANGSA </h5>
                    <h2>MONITORING HARIAN 24 JAM</h2>
                    <h4 id="unitTitle">{{ $title }}</h4>
                </div>
            </div>

            <!-- Right column - Diagnosis info -->
            <div class="diagnosis-column">
                <div class="diagnosis-info">
                    <div class="patient-info-item"><strong>Tanggal:</strong> <span id="filterDate">-</span></div>
                    <div class="patient-info-item"><strong>Diagnosa:</strong> {{ $latestMonitoring->diagnosa ?? '-' }}
                    </div>
                    <div class="patient-info-item"><strong>Indikasi ICCU:</strong>
                        {{ $latestMonitoring->indikasi_iccu ?? '-' }}</div>
                    <div class="patient-info-item"><strong>Alergi:</strong>
                        {{ $latestMonitoring->alergi ?? 'Tidak Ada Alergi' }}</div>
                </div>
            </div>
        </div>

        <!-- Filter Info -->
        <div class="filter-info" id="filterInfo">
            <i class="bi bi-funnel me-1"></i>Filter: <span id="filterText">Semua data</span>
        </div>

        <!-- Grafik Vital Signs -->
        <div class="chart-container no-page-break"
            style="position: relative; border: 1px solid #818181; height: 500px; width: 100%; margin-bottom: 20px;">
            <canvas id="vitalSignsChart"></canvas>
        </div>

        <!-- Vital Signs Table - Unchanged -->
        <!-- Vital Signs Table -->
        <div class="card-header bg-light">
            <h5 class="mb-0"><i class="bi bi-activity me-2"></i>Data Analisis Monitoring</h5>
        </div>
        <table class="vital-signs-table no-page-break" id="vitalSignsTable">
            <thead>
                <tr>
                    <th style="width: 200px;">Parameter</th>
                    @foreach ($allMonitoringRecords as $item)
                        @php
                            $datetime = \Carbon\Carbon::parse(
                                $item->tgl_implementasi . ' ' . $item->jam_implementasi,
                            )->format('H:i');
                        @endphp
                        <th>{{ $datetime }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="parameter-header">Sistolik (mmHg)</td>
                    @foreach ($allMonitoringRecords as $item)
                        <td>{{ isset($item->detail->sistolik) ? number_format($item->detail->sistolik, 0) : '-' }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td class="parameter-header">Diastolik (mmHg)</td>
                    @foreach ($allMonitoringRecords as $item)
                        <td>{{ isset($item->detail->diastolik) ? number_format($item->detail->diastolik, 0) : '-' }}
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <td class="parameter-header">Heart Rate (x/mnt)</td>
                    @foreach ($allMonitoringRecords as $item)
                        <td>{{ isset($item->detail->hr) ? number_format($item->detail->hr, 0) : '-' }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td class="parameter-header">Respiratory Rate (x/mnt)</td>
                    @foreach ($allMonitoringRecords as $item)
                        <td>{{ isset($item->detail->rr) ? number_format($item->detail->rr, 0) : '-' }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td class="parameter-header">Suhu (°C)</td>
                    @foreach ($allMonitoringRecords as $item)
                        <td>{{ isset($item->detail->temp) ? number_format($item->detail->temp, 1) : '-' }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td class="parameter-header">MAP (mmHg)</td>
                    @foreach ($allMonitoringRecords as $item)
                        <td>{{ isset($item->detail->map) ? number_format($item->detail->map, 0) : '-' }}</td>
                    @endforeach
                </tr>
            </tbody>
        </table>

        <!-- AGD Data Table -->
        <div class="card-header bg-light">
            <h5 class="mb-0"><i class="bi bi-activity me-2"></i>Data Analisis Monitoring</h5>
        </div>
        <!-- AGD Data Table -->
        <div class="card-header bg-light">
            <h5 class="mb-0"><i class="bi bi-flask me-2"></i>Data Analisis Gas Darah (AGD)</h5>
        </div>
        <div class="card-body p-0">
            <table class="vital-signs-table no-page-break" id="agdTable">
                <thead>
                    <tr>
                        <th style="width: 200px;">Parameter</th>
                        @foreach ($allMonitoringRecords as $item)
                            @php
                                $datetime = \Carbon\Carbon::parse(
                                    $item->tgl_implementasi . ' ' . $item->jam_implementasi,
                                )->format('H:i');
                            @endphp
                            <th>{{ $datetime }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="parameter-header"
                            style="background-color: #e2e8f0; color: #1a202c; font-weight: bold; text-align: center;">
                            AGD</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td
                                style="color: #1a202c; font-weight: bold; text-align: center; border: 1px solid #b8b8b8;">
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">pH</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td>{{ isset($item->detail->ph) ? number_format($item->detail->ph, 2) : '-' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">PO<sub>2</sub> (mmHg)</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td>{{ isset($item->detail->po2) ? number_format($item->detail->po2, 0) : '-' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">PCO<sub>2</sub> (mmHg)</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td>{{ isset($item->detail->pco2) ? number_format($item->detail->pco2, 0) : '-' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">BE (mmol/L)</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td>{{ isset($item->detail->be) ? number_format($item->detail->be, 1) : '-' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">HCO<sub>3</sub> (mmol/L)</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td>{{ isset($item->detail->hco3) ? number_format($item->detail->hco3, 1) : '-' }}</td>
                        @endforeach
                    </tr>
                    <!-- Add additional AGD parameters from controller -->
                    <tr>
                        <td class="parameter-header">Saturasi O<sub>2</sub> (%)</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td>{{ isset($item->detail->saturasi_o2) ? number_format($item->detail->saturasi_o2, 0) : '-' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header"
                            style="background-color: #e2e8f0; color: #1a202c; font-weight: bold; text-align: center;">
                            Elektrolit</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td
                                style="color: #1a202c; font-weight: bold; text-align: center; border: 1px solid #b8b8b8;">
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">Na<sup>+</sup> (mmol/L)</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td>{{ isset($item->detail->na) ? number_format($item->detail->na, 0) : '-' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">K<sup>+</sup> (mmol/L)</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td>{{ isset($item->detail->k) ? number_format($item->detail->k, 1) : '-' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">Cl<sup>-</sup> (mmol/L)</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td>{{ isset($item->detail->cl) ? number_format($item->detail->cl, 0) : '-' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header"
                            style="background-color: #e2e8f0; color: #1a202c; font-weight: bold; text-align: center;">
                            Fungsi Ginjal</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td
                                style="color: #1a202c; font-weight: bold; text-align: center; border: 1px solid #b8b8b8;">
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">Ureum (mg/dL)</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td>{{ isset($item->detail->ureum) ? number_format($item->detail->ureum, 0) : '-' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">Creatinin (mg/dL)</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td>{{ isset($item->detail->creatinin) ? number_format($item->detail->creatinin, 2) : '-' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header"
                            style="background-color: #e2e8f0; color: #1a202c; font-weight: bold; text-align: center;">
                            Hematologi</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td
                                style="color: #1a202c; font-weight: bold; text-align: center; border: 1px solid #b8b8b8;">
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">Hb (g/dL)</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td>{{ isset($item->detail->hb) ? number_format($item->detail->hb, 1) : '-' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">Ht (%)</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td>{{ isset($item->detail->ht) ? number_format($item->detail->ht, 1) : '-' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">Leukosit (/μL)</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td>{{ isset($item->detail->leukosit) ? number_format($item->detail->leukosit, 0) : '-' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">Trombosit (/μL)</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td>{{ isset($item->detail->trombosit) ? number_format($item->detail->trombosit, 0) : '-' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header"
                            style="background-color: #e2e8f0; color: #1a202c; font-weight: bold; text-align: center;">
                            Fungsi Hati</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td
                                style="color: #1a202c; font-weight: bold; text-align: center; border: 1px solid #b8b8b8;">
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">SGOT (U/L)</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td>{{ isset($item->detail->sgot) ? number_format($item->detail->sgot, 0) : '-' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">SGPT (U/L)</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td>{{ isset($item->detail->sgpt) ? number_format($item->detail->sgpt, 0) : '-' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">Albumin (g/dL)</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td>{{ isset($item->detail->albumin) ? number_format($item->detail->albumin, 1) : '-' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header"
                            style="background-color: #e2e8f0; color: #1a202c; font-weight: bold; text-align: center;">
                            Lain-lain</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td
                                style="color: #1a202c; font-weight: bold; text-align: center; border: 1px solid #b8b8b8;">
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">GDS/KDGS (mg/dL)</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td>{{ isset($item->detail->kdgs) ? number_format($item->detail->kdgs, 0) : '-' }}</td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Additional Medical Parameters Table -->
        <div class="card-header bg-light mt-4">
            <h5 class="mb-0"><i class="bi bi-clipboard2-pulse me-2"></i>Data Parameter Klinis</h5>
        </div>
        <div class="card-body p-0">
            <table class="vital-signs-table no-page-break" id="clinicalTable">
                <thead>
                    <tr>
                        <th style="width: 200px;">Parameter</th>
                        @foreach ($allMonitoringRecords as $item)
                            @php
                                $datetime = \Carbon\Carbon::parse(
                                    $item->tgl_implementasi . ' ' . $item->jam_implementasi,
                                )->format('H:i');
                            @endphp
                            <th>{{ $datetime }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="parameter-header"
                            style="background-color: #e2e8f0; color: #1a202c; font-weight: bold; text-align: center;">
                            Tingkat Kesadaran</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td
                                style="color: #1a202c; font-weight: bold; text-align: center; border: 1px solid #b8b8b8;">
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">Kesadaran</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td>{{ isset($item->detail->kesadaran) ? $item->detail->kesadaran : '-' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">GCS - Mata (E)</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td>{{ isset($item->detail->gcs_eye) ? number_format($item->detail->gcs_eye, 0) : '-' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">GCS - Verbal (V)</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td>{{ isset($item->detail->gcs_verbal) ? number_format($item->detail->gcs_verbal, 0) : '-' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">GCS - Motorik (M)</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td>{{ isset($item->detail->gcs_motor) ? number_format($item->detail->gcs_motor, 0) : '-' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">GCS - Total</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td>{{ isset($item->detail->gcs_total) ? number_format($item->detail->gcs_total, 0) : '-' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">Pupil Kanan (mm)</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td>{{ isset($item->detail->pupil_kanan) ? $item->detail->pupil_kanan : '-' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">Pupil Kiri (mm)</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td>{{ isset($item->detail->pupil_kiri) ? $item->detail->pupil_kiri : '-' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header"
                            style="background-color: #e2e8f0; color: #1a202c; font-weight: bold; text-align: center;">
                            Terapi Oksigen</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td
                                style="color: #1a202c; font-weight: bold; text-align: center; border: 1px solid #b8b8b8;">
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">Jenis Terapi</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td>{{ isset($item->detail->terapi_oksigen) ? $item->detail->terapi_oksigen : '-' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header"
                            style="background-color: #e2e8f0; color: #1a202c; font-weight: bold; text-align: center;">
                            Ventilator</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td
                                style="color: #1a202c; font-weight: bold; text-align: center; border: 1px solid #b8b8b8;">
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">Mode</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td>{{ isset($item->detail->ventilator_mode) ? $item->detail->ventilator_mode : '-' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">MV (L/min)</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td>{{ isset($item->detail->ventilator_mv) ? number_format($item->detail->ventilator_mv, 1) : '-' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">TV (mL)</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td>{{ isset($item->detail->ventilator_tv) ? number_format($item->detail->ventilator_tv, 0) : '-' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">FiO<sub>2</sub> (%)</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td>{{ isset($item->detail->ventilator_fio2) ? number_format($item->detail->ventilator_fio2, 0) : '-' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">I:E Ratio</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td>{{ isset($item->detail->ventilator_ie_ratio) ? $item->detail->ventilator_ie_ratio : '-' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">Pmax (cmH<sub>2</sub>O)</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td>{{ isset($item->detail->ventilator_pmax) ? number_format($item->detail->ventilator_pmax, 0) : '-' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">PEEP/PS (cmH<sub>2</sub>O)</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td>{{ isset($item->detail->ventilator_peep_ps) ? number_format($item->detail->ventilator_peep_ps, 0) : '-' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header"
                            style="background-color: #e2e8f0; color: #1a202c; font-weight: bold; text-align: center;">
                            Cateter & Tube</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td
                                style="color: #1a202c; font-weight: bold; text-align: center; border: 1px solid #b8b8b8;">
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">ETT No</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td>{{ isset($item->detail->ett_no) ? $item->detail->ett_no : '-' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">Batas Bibir (cm)</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td>{{ isset($item->detail->batas_bibir) && is_numeric($item->detail->batas_bibir) ? number_format($item->detail->batas_bibir, 2) : '-' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">NGT No</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td>{{ isset($item->detail->ngt_no) ? $item->detail->ngt_no : '-' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">CVC</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td>{{ isset($item->detail->cvc) ? $item->detail->cvc : '-' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">Urine Catch No</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td>{{ isset($item->detail->urine_catch_no) ? $item->detail->urine_catch_no : '-' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">IV Line</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td>{{ isset($item->detail->iv_line) ? $item->detail->iv_line : '-' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header"
                            style="background-color: #e2e8f0; color: #1a202c; font-weight: bold; text-align: center;">
                            I/O Balance</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td
                                style="color: #1a202c; font-weight: bold; text-align: center; border: 1px solid #b8b8b8;">
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">BAB (mL)</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td>{{ isset($item->bab) && is_numeric($item->bab) ? number_format((float)$item->bab, 0) : '-' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">Urine (mL)</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td>{{ isset($item->urine) && is_numeric($item->urine) ? number_format((float)$item->urine, 0) : '-' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">IWL (mL)</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td>{{ isset($item->iwl) && is_numeric($item->iwl) ? number_format((float)$item->iwl, 0) : '-' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">Muntahan (mL)</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td>{{ isset($item->muntahan_cms) && is_numeric($item->muntahan_cms) ? number_format((float)$item->muntahan_cms, 0) : '-' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">Drain (mL)</td>
                        @foreach ($allMonitoringRecords as $item)
                            <td>{{ isset($item->drain) && is_numeric($item->drain) ? number_format((float)$item->drain, 0) : '-' }}</td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Signature -->
        <div class="signature">
            <p>{{ $dataMedis->unit->NAMA_UNIT ?? 'Intensive Care' }}, {{ \Carbon\Carbon::now()->format('d-m-Y') }}</p>
            <p>Penanggung Jawab</p>
            <br><br><br>
            <p>( {{ auth()->user()->name ?? '........................' }} )</p>
        </div>
    </div>

    <!-- Footer - will appear in print -->
    <div class="print-footer">
        Dicetak pada: {{ \Carbon\Carbon::now()->format('d-m-Y H:i:s') }}
    </div>

    <!-- Scripts - UNCHANGED -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>

    <script>
        // Fungsi untuk memformat angka float
        // Fungsi untuk memformat angka float - TETAP DIGUNAKAN
        function formatNumber(value, decimals = 1) {
            if (value === null || value === undefined || isNaN(value)) {
                return '-';
            }
            return parseFloat(value).toFixed(decimals);
        }

        // Fungsi untuk memformat tanggal dan waktu - TETAP DIGUNAKAN UNTUK CHART
        function formatDateTime(dateTimeStr) {
            try {
                const dateTime = new Date(dateTimeStr);
                const day = String(dateTime.getDate()).padStart(2, '0');
                const month = String(dateTime.getMonth() + 1).padStart(2, '0');
                const hours = String(dateTime.getHours()).padStart(2, '0');
                const minutes = String(dateTime.getMinutes()).padStart(2, '0');

                return {
                    date: `${day}/${month}`,
                    time: `${hours}:${minutes}`
                };
            } catch (e) {
                console.error("Error formatting date:", e);
                return {
                    date: "--/--",
                    time: "--:--"
                };
            }
        }

        // Main execution when document is ready -
        document.addEventListener('DOMContentLoaded', () => {
            // JIKA MENGGUNAKAN BLADE TEMPLATE, GANTI DENGAN KODE BERIKUT:
            // Ambil data dari tabel yang sudah dirender oleh Blade
            const labels = Array.from(document.querySelectorAll('#vitalSignsTable thead th:not(:first-child)'))
                .map(th => th.textContent.trim());

            const sistolikData = Array.from(document.querySelectorAll(
                    '#vitalSignsTable tbody tr:nth-child(1) td:not(:first-child)'))
                .map(td => td.textContent.trim() !== '-' ? parseFloat(td.textContent.trim()) : null);

            const diastolikData = Array.from(document.querySelectorAll(
                    '#vitalSignsTable tbody tr:nth-child(2) td:not(:first-child)'))
                .map(td => td.textContent.trim() !== '-' ? parseFloat(td.textContent.trim()) : null);

            const hrData = Array.from(document.querySelectorAll(
                    '#vitalSignsTable tbody tr:nth-child(3) td:not(:first-child)'))
                .map(td => td.textContent.trim() !== '-' ? parseFloat(td.textContent.trim()) : null);

            const rrData = Array.from(document.querySelectorAll(
                    '#vitalSignsTable tbody tr:nth-child(4) td:not(:first-child)'))
                .map(td => td.textContent.trim() !== '-' ? parseFloat(td.textContent.trim()) : null);

            const suhuData = Array.from(document.querySelectorAll(
                    '#vitalSignsTable tbody tr:nth-child(5) td:not(:first-child)'))
                .map(td => td.textContent.trim() !== '-' ? parseFloat(td.textContent.trim()) : null);

            const mapData = Array.from(document.querySelectorAll(
                    '#vitalSignsTable tbody tr:nth-child(6) td:not(:first-child)'))
                .map(td => td.textContent.trim() !== '-' ? parseFloat(td.textContent.trim()) : null);

            // Buat grafik dengan data yang sudah diambil
            createChartFromLabels(labels, sistolikData, diastolikData, hrData, rrData, suhuData, mapData);

            // Sembunyikan loading indicator dan tampilkan konten
            document.getElementById('loadingIndicator').style.display = 'none';
            document.getElementById('printContent').style.display = 'block';

            // Aktifkan tombol print
            document.getElementById('printBtn').disabled = false;

            // KODE LAMA - DAPAT DIHAPUS JIKA MENGGUNAKAN BLADE TEMPLATE:
            // Dapatkan data monitoring dari controller PHP
            var monitoringData = @json($allMonitoringRecords ?? []);

            // Dapatkan info filter dari parameter URL
            var startDate = '{{ $start_date ?? '' }}';
            var startTime = '{{ $start_time ?? '' }}';
            var endDate = '{{ $end_date ?? '' }}';
            var endTime = '{{ $end_time ?? '' }}';

            // Buat teks filter
            var filterRangeText = "Semua data";
            if (startDate && endDate) {
                filterRangeText = formatReadableDate(startDate) + " " + (startTime || "00:00") + " s.d " +
                    formatReadableDate(endDate) + " " + (endTime || "23:59");
            }

            // Proses data untuk ditampilkan
            if (monitoringData && monitoringData.length > 0) {
                processPrintData(monitoringData, filterRangeText, '{{ $title }}');

                // Tampilkan tanggal terbaru pada bagian info pasien
                if (startDate && endDate) {
                    document.getElementById('filterDate').textContent = formatReadableDate(startDate) +
                        (startDate === endDate ? "" : " s.d " + formatReadableDate(endDate));
                } else {
                    var today = new Date();
                    var dd = String(today.getDate()).padStart(2, '0');
                    var mm = String(today.getMonth() + 1).padStart(2, '0');
                    var yyyy = today.getFullYear();
                    document.getElementById('filterDate').textContent = dd + "-" + mm + "-" + yyyy;
                }
            } else {
                document.getElementById('loadingIndicator').innerHTML =
                    '<div class="alert alert-info">Tidak ada data untuk ditampilkan</div>';
            }
        });

        // Format tanggal menjadi format yang mudah dibaca - TETAP DIGUNAKAN
        function formatReadableDate(dateString) {
            var parts = dateString.split('-');
            if (parts.length === 3) {
                return parts[2] + '-' + parts[1] + '-' + parts[0];
            }
            return dateString;
        }

        // Fungsi untuk membuat grafik monitoring dari label yang sudah disiapkan
        function createChartFromLabels(labels, sistolikData, diastolikData, hrData, rrData, suhuData, mapData) {
            // Hapus grafik lama jika ada
            if (window.vitalChart) {
                window.vitalChart.destroy();
            }

            // Buat grafik baru
            const ctx = document.getElementById('vitalSignsChart').getContext('2d');
            window.vitalChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'Sistolik',
                            data: sistolikData,
                            borderColor: 'rgba(54, 162, 235, 1)',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderWidth: 2,
                            pointRadius: 3,
                            fill: true, // Aktifkan fill untuk area di bawah garis
                            tension: 0.4, // Membuat kurva lebih smooth
                            // Efek bayangan area
                            backgroundColor: (context) => {
                                const ctx = context.chart.ctx;
                                const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                                gradient.addColorStop(0, 'rgba(54, 162, 235, 0.3)');
                                gradient.addColorStop(1, 'rgba(54, 162, 235, 0.05)');
                                return gradient;
                            }
                        },
                        {
                            label: 'Diastolik',
                            data: diastolikData,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderWidth: 2,
                            pointRadius: 3,
                            fill: true,
                            tension: 0.4,
                            // Efek bayangan area
                            backgroundColor: (context) => {
                                const ctx = context.chart.ctx;
                                const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                                gradient.addColorStop(0, 'rgba(75, 192, 192, 0.3)');
                                gradient.addColorStop(1, 'rgba(75, 192, 192, 0.05)');
                                return gradient;
                            }
                        },
                        {
                            label: 'Heart Rate',
                            data: hrData,
                            borderColor: 'rgba(255, 206, 86, 1)',
                            backgroundColor: 'rgba(255, 206, 86, 0.2)',
                            borderWidth: 2,
                            pointRadius: 3,
                            fill: true,
                            tension: 0.4,
                            // Efek bayangan area
                            backgroundColor: (context) => {
                                const ctx = context.chart.ctx;
                                const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                                gradient.addColorStop(0, 'rgba(255, 206, 86, 0.3)');
                                gradient.addColorStop(1, 'rgba(255, 206, 86, 0.05)');
                                return gradient;
                            }
                        },
                        {
                            label: 'Respiratory Rate',
                            data: rrData,
                            borderColor: 'rgba(153, 102, 255, 1)',
                            backgroundColor: 'rgba(153, 102, 255, 0.2)',
                            borderWidth: 2,
                            pointRadius: 3,
                            fill: true,
                            tension: 0.4,
                            // Efek bayangan area
                            backgroundColor: (context) => {
                                const ctx = context.chart.ctx;
                                const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                                gradient.addColorStop(0, 'rgba(153, 102, 255, 0.3)');
                                gradient.addColorStop(1, 'rgba(153, 102, 255, 0.05)');
                                return gradient;
                            }
                        },
                        {
                            label: 'Suhu',
                            data: suhuData,
                            borderColor: 'rgba(255, 99, 132, 1)',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderWidth: 2,
                            pointRadius: 3,
                            fill: true,
                            tension: 0.4,
                            // Efek bayangan area
                            backgroundColor: (context) => {
                                const ctx = context.chart.ctx;
                                const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                                gradient.addColorStop(0, 'rgba(255, 99, 132, 0.3)');
                                gradient.addColorStop(1, 'rgba(255, 99, 132, 0.05)');
                                return gradient;
                            }
                        },
                        {
                            label: 'MAP',
                            data: mapData,
                            borderColor: 'rgba(255, 159, 64, 1)',
                            backgroundColor: 'rgba(255, 159, 64, 0.2)',
                            borderWidth: 2,
                            pointRadius: 3,
                            fill: true,
                            tension: 0.4,
                            // Efek bayangan area
                            backgroundColor: (context) => {
                                const ctx = context.chart.ctx;
                                const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                                gradient.addColorStop(0, 'rgba(255, 159, 64, 0.3)');
                                gradient.addColorStop(1, 'rgba(255, 159, 64, 0.05)');
                                return gradient;
                            }
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    title: {
                        display: true,
                        text: 'Grafik Monitoring Tanda Vital',
                        fontSize: 16,
                        fontStyle: 'bold',
                        padding: 20
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: false
                    },
                    hover: {
                        mode: 'nearest',
                        intersect: true
                    },
                    scales: {
                        xAxes: [{
                            display: true,
                            scaleLabel: {
                                display: true,
                                labelString: 'Waktu'
                            },
                            ticks: {
                                autoSkip: false,
                                maxRotation: 45,
                                minRotation: 45
                            }
                        }],
                        yAxes: [{
                            display: true,
                            scaleLabel: {
                                display: true,
                                labelString: 'Nilai'
                            },
                            ticks: {
                                beginAtZero: false,
                                min: 0,
                                max: 200,
                                stepSize: 20
                            }
                        }]
                    },
                    legend: {
                        position: 'top',
                        labels: {
                            boxWidth: 12,
                            padding: 15
                        }
                    }
                }
            });
        }
    </script>
</body>

</html>
