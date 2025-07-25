<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Monitoring Pasien</title>

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
                font-size: 10px;
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
                text-align: left;
                font-weight: bold;
            }

            .patient-info,
            .diagnosis-info {
                background-color: #f8f9fa !important;
                -webkit-print-color-adjust: exact;
                border: 1px solid #dee2e6;
                padding: 8px;
                border-radius: 5px;
            }
        }

        .print-container {
            padding: 10px;
        }

        /* Header Layout - Diperbaiki dengan proporsi 35:35:30 */
        .header-row {
            display: flex;
            width: 100%;
            margin-bottom: 15px;
            position: relative;
            align-items: flex-start;
        }

        .rm-number {
            position: absolute;
            bottom: 0;
            left: 0;
            font-weight: bold;
            font-size: 12px;
            z-index: 100;
        }

        .no-right {
            position: absolute;
            top: 0;
            right: 0;
            font-weight: bold;
            font-size: 12px;
            z-index: 100;
        }

        /* Kolom Kiri - Informasi Pasien (35%) */
        .patient-column {
            width: 35%;
            padding-right: 10px;
            box-sizing: border-box;
        }

        /* Kolom Tengah - Header Hospital & Logo (35%) */
        .hospital-header {
            width: 35%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 0 10px;
            box-sizing: border-box;
        }

        .logo-title-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }

        .hospital-logo {
            height: 70px;
            width: auto;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .header-title {
            text-align: center;
            flex: 1;
        }

        .header-title h5,
        .header-title h2,
        .header-title h4 {
            margin: 4px 0;
            line-height: 1.2;
        }

        .header-title h5 {
            font-size: 12px;
            font-weight: 600;
        }

        .header-title h2 {
            font-size: 15px;
            font-weight: bold;
            color: #2c3e50;
        }

        .header-title h4 {
            font-size: 12px;
            font-weight: 600;
            color: #34495e;
        }

        /* Kolom Kanan - Informasi Diagnosis (30%) */
        .diagnosis-column {
            width: 30%;
            padding-left: 10px;
            box-sizing: border-box;
        }

        .patient-info-container {
            margin-bottom: 10px;
        }

        .patient-info-item {
            margin-bottom: 3px;
            font-size: 11px;
            line-height: 1.3;
        }

        .patient-info,
        .diagnosis-info {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 10px;
            border-radius: 5px;
            font-size: 11px;
        }

        .patient-info-item strong {
            font-weight: 600;
            color: #2c3e50;
        }

        .vital-signs-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .vital-signs-table th {
            background-color: #e6e6e6;
            padding: 6px;
            text-align: center;
            border: 1px solid #b8b8b8;
            font-weight: bold;
        }

        .vital-signs-table td {
            padding: 4px;
            text-align: center;
            border: 1px solid #b8b8b8;
        }

        .parameter-header {
            text-align: left;
            font-weight: 500;
            background-color: #f8f9fa;
            border: 1px solid #b8b8b8 !important;
        }

        .sub-parameter-header {
            background-color: #e2e8f0;
            color: #1a202c;
            font-weight: bold;
            text-align: center;
        }

        .sub-parameter-header-oral {
            background-color: #f6f3c4;
            color: #1a202c;
            font-weight: bold;
        }

        .sub-parameter-header-intake {
            background-color: #ebafd5;
            color: #1a202c;
            font-weight: bold;
            text-align: center;
        }

        .filter-info {
            margin: 8px 0;
            padding: 4px;
            background-color: #e9ecef;
            border-radius: 3px;
            font-style: italic;
            font-size: 11px;
        }

        .print-footer {
            text-align: center;
            font-size: 10px;
            margin-top: 15px;
            color: #6c757d;
        }

        .signature {
            margin-top: 40px;
            text-align: right;
            padding-right: 40px;
            font-size: 11px;
        }

        #loadingIndicator {
            text-align: center;
            padding: 20px;
            font-size: 18px;
        }

        /* Medical Staff Info Section */
        .medical-staff-info {
            margin: 15px 0;
            width: 100%;
        }

        .medical-staff-row {
            display: flex;
            width: 100%;
            gap: 10px;
            align-items: stretch;
        }

        .medical-staff-column {
            flex: 1;
            box-sizing: border-box;
        }

        .medical-staff-column:first-child {
            flex: 0 0 35%;
        }

        .medical-staff-column:nth-child(2) {
            flex: 0 0 35%;
        }

        .medical-staff-column:last-child {
            flex: 0 0 30%;
        }

        .medical-staff-box {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 10px;
            height: 100%;
            box-sizing: border-box;
        }

        .medical-staff-title {
            font-size: 12px;
            font-weight: 600;
            color: #2c3e50;
            margin: 0 0 8px 0;
            padding-bottom: 4px;
            border-bottom: 1px solid #dee2e6;
            display: flex;
            align-items: center;
        }

        .medical-staff-item {
            font-size: 11px;
            line-height: 1.4;
            margin-bottom: 4px;
            color: #495057;
        }

        .medical-staff-item strong {
            font-weight: 600;
            color: #2c3e50;
        }

        .medical-staff-item:last-child {
            margin-bottom: 0;
        }

        .konsulen-list-item {
            font-size: 11px;
            line-height: 1.3;
            margin-bottom: 2px;
            color: #495057;
            padding-left: 0;
        }

        .konsulen-list-item strong {
            font-weight: 600;
            color: #2c3e50;
            margin-right: 4px;
        }

        /* Print specific styling */
        @media print {
            .medical-staff-item {
                font-size: 11px !important;
                line-height: 1.4 !important;
                margin-bottom: 4px !important;
                color: #495057 !important;
                page-break-inside: avoid;
            }
            
            .konsulen-list-item {
                font-size: 11px !important;
                line-height: 1.3 !important;
                margin-bottom: 2px !important;
                page-break-inside: avoid;
            }
            
            .medical-staff-box {
                page-break-inside: avoid;
            }
        }

        @media print {
            .medical-staff-box {
                background-color: #f8f9fa !important;
                -webkit-print-color-adjust: exact;
            }
        }

        /* Responsive untuk layar kecil */
        @media screen and (max-width: 1024px) {
            .medical-staff-row {
                flex-direction: column;
                gap: 8px;
            }

            .medical-staff-column,
            .medical-staff-column:first-child,
            .medical-staff-column:nth-child(2),
            .medical-staff-column:last-child {
                flex: none;
                width: 100%;
            }
        }

        /* Responsive untuk layar kecil */
        @media screen and (max-width: 1024px) {
            .header-row {
                flex-direction: column;
            }

            .patient-column,
            .hospital-header,
            .diagnosis-column {
                width: 100%;
                margin-bottom: 10px;
                padding: 0;
            }

            .logo-title-container {
                flex-direction: column;
            }

            .hospital-logo {
                margin-right: 0;
                margin-bottom: 10px;
            }
        }
    </style>
</head>

<body>
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

    <div id="loadingIndicator">
        <i class="bi bi-hourglass-split me-2"></i> Memuat data monitoring...
    </div>

    <div class="print-container" style="display: none;" id="printContent">
        <div class="no-right">
            <strong>NO: K.7/IRM/Rev 0/2017</strong>
        </div>

        <div class="header-row">
            <!-- Kolom Kiri - Informasi Pasien (35%) -->
            <div class="patient-column">
                <div class="patient-info">
                    <div class="patient-info-item">
                        <strong>Nama Pasien:</strong> {{ $dataMedis->pasien->nama ?? '-' }}
                    </div>
                    <div class="patient-info-item">
                        <strong>No RM:</strong> {{ $dataMedis->pasien->kd_pasien ?? '-' }}
                    </div>
                    <div class="patient-info-item">
                        <strong>Umur:</strong> {{ $dataMedis->pasien->umur ?? '-' }} tahun
                    </div>
                    <div class="patient-info-item">
                        <strong>Berat Badan:</strong>
                        {{ $latestMonitoring ? number_format($latestMonitoring->berat_badan, 1) : '-' }} kg
                    </div>
                    <div class="patient-info-item">
                        <strong>Tinggi Badan:</strong>
                        {{ $latestMonitoring ? number_format($latestMonitoring->tinggi_badan, 1) : '-' }} cm
                    </div>
                </div>
            </div>

            <!-- Kolom Tengah - Header Hospital & Logo (35%) -->
            <div class="hospital-header">
                <div class="logo-title-container">
                    <img src="{{ asset('assets/img/Logo-RSUD-Langsa-1.png') }}" alt="Logo Rumah Sakit"
                        class="hospital-logo">
                    <div class="header-title">
                        <h5>PEMERINTAH KOTA LANGSA<br>RUMAH SAKIT UMUM DAERAH LANGSA</h5>
                        <h2>MONITORING HARIAN 24 JAM</h2>
                        <h4 id="unitTitle"><i>{{ $subTitle }}</i>  ({{ $title }})</h4>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan - Informasi Diagnosis (30%) -->
            <div class="diagnosis-column">
                <div class="diagnosis-info">
                    <div class="patient-info-item">
                        <strong>Tanggal:</strong>
                        <span id="filterDate">
                            {{ \Carbon\Carbon::parse($tgl_masuk)->format('d-m-Y') }}
                        </span>
                    </div>
                    <div class="patient-info-item">
                        <strong>Diagnosa:</strong> {{ $latestMonitoring->diagnosa ?? '-' }}
                    </div>
                    <div class="patient-info-item">
                        <strong>Indikasi {{ $title }}:</strong>
                        {{ $latestMonitoring->indikasi_iccu ?? '-' }}
                    </div>
                    <div class="patient-info-item">
                        <strong>Alergi:</strong>
                        {{ $allergiesDisplay ?? 'Tidak Ada Alergi' }}
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <!-- Informasi Tenaga Medis -->
        <!-- Informasi Tenaga Medis - Updated untuk Semua Unit -->
        <div class="medical-staff-info">
            <!-- Layout Uniform untuk Semua Unit (NICU, ICCU, ICU, PICU) -->
            <div class="medical-staff-row">
                <!-- Kolom Kiri - Dokter Utama (50%) -->
                <div class="medical-staff-column" style="flex: 0 0 50%;">
                    <div class="medical-staff-box">
                        <h6 class="medical-staff-title">
                            <i class="bi bi-person-badge me-1"></i>Dokter Penanggung Jawab
                        </h6>
                        <div class="medical-staff-item">
                            <strong>Dokter:</strong> 
                            @if($latestMonitoring && $latestMonitoring->dokter)
                                @php
                                    $dokterUtama = \App\Models\Dokter::where('kd_dokter', $latestMonitoring->dokter)->first();
                                @endphp
                                {{ $dokterUtama ? $dokterUtama->nama_lengkap : $latestMonitoring->dokter }}
                            @else
                                -
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan - Dokter Konsulen (50%) -->
                <div class="medical-staff-column" style="flex: 0 0 50%;">
                    <div class="medical-staff-box">
                        <h6 class="medical-staff-title">
                            <i class="bi bi-person-check me-1"></i>Dokter Konsulen
                        </h6>
                        <div class="medical-staff-item">
                            @if($latestMonitoring && $latestMonitoring->konsulen)
                                @php
                                    // Decode konsulen JSON untuk print
                                    $konsulenNames = [];
                                    try {
                                        $konsulenArray = json_decode($latestMonitoring->konsulen, true);
                                        if (!is_array($konsulenArray)) {
                                            // Handle old format (single doctor)
                                            $konsulenArray = [$latestMonitoring->konsulen];
                                        }
                                        
                                        foreach ($konsulenArray as $konsulenId) {
                                            $dokter = \App\Models\Dokter::where('kd_dokter', $konsulenId)->first();
                                            if ($dokter) {
                                                $konsulenNames[] = $dokter->nama_lengkap;
                                            } else {
                                                $konsulenNames[] = $konsulenId; // Fallback ke kode dokter
                                            }
                                        }
                                    } catch (Exception $e) {
                                        // Handle invalid JSON - treat as single doctor
                                        $dokter = \App\Models\Dokter::where('kd_dokter', $latestMonitoring->konsulen)->first();
                                        $konsulenNames[] = $dokter ? $dokter->nama_lengkap : $latestMonitoring->konsulen;
                                    }
                                @endphp
                                
                                @if(count($konsulenNames) > 1)
                                    <!-- Multiple konsulen - tampilkan sebagai numbered list -->
                                    @foreach($konsulenNames as $index => $nama)
                                        <div class="medical-staff-item" style="margin-bottom: 2px;">
                                            <strong>{{ $index + 1 }}.</strong> {{ $nama }}
                                        </div>
                                    @endforeach
                                @elseif(count($konsulenNames) == 1)
                                    <!-- Single konsulen - tampilkan dengan label -->
                                    <strong>Konsulen:</strong> {{ $konsulenNames[0] }}
                                @else
                                    <!-- No konsulen -->
                                    <strong>Konsulen:</strong> -
                                @endif
                            @else
                                <strong>Konsulen:</strong> -
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="filter-info" id="filterInfo">
            <i class="bi bi-funnel me-1"></i>Filter: <span id="filterText">
                {{ $filterType }}: {{ $filterValue ?: 'Semua Data' }} ({{ $monitoringRecords->count() }} data)
            </span>
        </div>

        <div class="chart-container no-page-break"
            style="position: relative; border: 1px solid #818181; height: 500px; width: 100%; margin-bottom: 15px;">
            <canvas id="vitalSignsChart"></canvas>
        </div>

        <div class="card-header bg-light">
            <h5 class="mb-0"><i class="bi bi-activity me-2"></i>Data Analisis Monitoring Tanda Vital</h5>
        </div>
        <table class="vital-signs-table no-page-break" id="vitalSignsTable">
            <thead>
                <tr>
                    <th style="width: 200px;">Parameter</th>
                    @if ($monitoringRecords->isNotEmpty())
                        @foreach ($monitoringRecords as $item)
                            @php
                                $datetime = \Carbon\Carbon::parse(
                                    $item->tgl_implementasi . ' ' . $item->jam_implementasi,
                                )->format('H:i');
                                $date = \Carbon\Carbon::parse($item->tgl_implementasi)->format('d-M');
                            @endphp
                            <th>{{ $datetime }} <br> <small>{{ $date }}</small></th>
                        @endforeach
                    @else
                        <th>Waktu Observasi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @if ($monitoringRecords->isNotEmpty())
                    <tr>
                        <td class="parameter-header">Sistolik (mmHg)</td>
                        @foreach ($monitoringRecords as $item)
                            <td>{{ isset($item->detail->sistolik) ? number_format($item->detail->sistolik, 0) : '-' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">Diastolik (mmHg)</td>
                        @foreach ($monitoringRecords as $item)
                            <td>{{ isset($item->detail->diastolik) ? number_format($item->detail->diastolik, 0) : '-' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">MAP (mmHg)</td>
                        @foreach ($monitoringRecords as $item)
                            <td>{{ isset($item->detail->map) ? number_format($item->detail->map, 0) : '-' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">Heart Rate (x/mnt)</td>
                        @foreach ($monitoringRecords as $item)
                            <td>{{ isset($item->detail->hr) ? number_format($item->detail->hr, 0) : '-' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">Respiratory Rate (x/mnt)</td>
                        @foreach ($monitoringRecords as $item)
                            <td>{{ isset($item->detail->rr) ? number_format($item->detail->rr, 0) : '-' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">Suhu (°C)</td>
                        @foreach ($monitoringRecords as $item)
                            <td>{{ isset($item->detail->temp) ? number_format($item->detail->temp, 1) : '-' }}</td>
                        @endforeach
                    </tr>
                @else
                    <tr>
                        <td colspan="2" class="text-center text-muted">Tidak ada data tanda vital yang tercatat dalam
                            rentang ini.</td>
                    </tr>
                @endif
            </tbody>
        </table>

        @php
            $oralCvPEkgEnteralRecords = $monitoringRecords->filter(function ($record) {
                $hasOralTherapyWithValue = false;
                if ($record->therapyDoses) {
                    foreach ($record->therapyDoses as $dose) {
                        if (
                            $dose->therapy &&
                            $dose->therapy->jenis_terapi == 1 &&
                            isset($dose->nilai) &&
                            $dose->nilai > 0
                        ) {
                            $hasOralTherapyWithValue = true;
                            break;
                        }
                    }
                }
                return $hasOralTherapyWithValue ||
                    isset($record->detail->cvp) ||
                    !empty($record->detail->ekg_record) ||
                    (isset($record->detail->oral) && is_numeric($record->detail->oral)) ||
                    (isset($record->detail->ngt) && is_numeric($record->detail->ngt));
            });

            // Updated: Include dihitung status for oral therapies
            $uniqueOralTherapiesForTable = [];
            foreach ($monitoringRecords as $record) {
                if ($record->therapyDoses) {
                    foreach ($record->therapyDoses as $dose) {
                        if (
                            $dose->therapy &&
                            $dose->therapy->jenis_terapi == 1 &&
                            !isset($uniqueOralTherapiesForTable[$dose->therapy->id])
                        ) {
                            $uniqueOralTherapiesForTable[$dose->therapy->id] = [
                                'nama_obat' => $dose->therapy->nama_obat,
                                'dihitung' => $dose->therapy->dihitung,
                            ];
                        }
                    }
                }
            }
        @endphp


        <div class="card-header bg-light mt-4">
            <h5 class="mb-0"><i class="bi bi-journal-medical me-2"></i>Terapi Oral, CVP, EKG & Input Enteral</h5>
        </div>
        @if ($oralCvPEkgEnteralRecords->isNotEmpty())
            <table class="vital-signs-table no-page-break">
                <thead>
                    <tr>
                        <th style="width: 200px;">Parameter</th>
                        @foreach ($oralCvPEkgEnteralRecords as $item)
                            @php
                                $datetime = \Carbon\Carbon::parse(
                                    $item->tgl_implementasi . ' ' . $item->jam_implementasi,
                                )->format('H:i');
                                $date = \Carbon\Carbon::parse($item->tgl_implementasi)->format('d-M');
                            @endphp
                            <th>{{ $datetime }} <br> <small>{{ $date }}</small></th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="parameter-header">CVP (Cm H2O)</td>
                        @foreach ($oralCvPEkgEnteralRecords as $item)
                            <td>{{ isset($item->detail->cvp) ? number_format($item->detail->cvp, 0) : '-' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">EKG Record</td>
                        @foreach ($oralCvPEkgEnteralRecords as $item)
                            <td>{{ $item->detail->ekg_record ?? '-' }}</td>
                        @endforeach
                    </tr>
                    @if (!empty($uniqueOralTherapiesForTable))
                        <tr>
                            <td class="sub-parameter-header-oral" colspan="1">Terapi Oral</td>
                            @foreach ($oralCvPEkgEnteralRecords as $item)
                                <td></td>
                            @endforeach
                        </tr>
                        @foreach ($uniqueOralTherapiesForTable as $therapyId => $therapyData)
                            <tr>
                                <td class="parameter-header">
                                    {{ $therapyData['nama_obat'] }}
                                    @if (!$therapyData['dihitung'])
                                        <small class="text-muted">(Tidak dihitung)</small>
                                    @endif
                                </td>
                                @foreach ($oralCvPEkgEnteralRecords as $item)
                                    @php
                                        $doseValue = '-';
                                        if ($item->therapyDoses) {
                                            $dose = $item->therapyDoses->where('id_therapy', $therapyId)->first();
                                            if ($dose && isset($dose->nilai) && $dose->nilai > 0) {
                                                $doseValue = number_format($dose->nilai, 1) . ' cc/ml';
                                            }
                                        }
                                    @endphp
                                    <td>{{ $doseValue }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        @else
            <div class="text-center text-muted p-3">Tidak ada data Terapi Oral, CVP, EKG, atau Input Enteral yang
                tercatat signifikan dalam rentang ini.</div>
        @endif

        @php
            $nonOralTherapyEnteralRecords = $monitoringRecords->filter(function ($record) {
                $hasNonOralTherapyWithValue = false;
                if ($record->therapyDoses) {
                    foreach ($record->therapyDoses as $dose) {
                        if (
                            $dose->therapy &&
                            in_array($dose->therapy->jenis_terapi, [2, 3, 4]) &&
                            isset($dose->nilai) &&
                            $dose->nilai > 0
                        ) {
                            $hasNonOralTherapyWithValue = true;
                            break;
                        }
                    }
                }
                return $hasNonOralTherapyWithValue ||
                    (isset($record->detail->oral) && is_numeric($record->detail->oral) && $record->detail->oral > 0) ||
                    (isset($record->detail->ngt) && is_numeric($record->detail->ngt) && $record->detail->ngt > 0);
            });

            $uniqueInjeksiTherapies = [];
            $uniqueDripTherapies = [];
            $uniqueCairanTherapies = [];

            foreach ($monitoringRecords as $record) {
                if ($record->therapyDoses) {
                    foreach ($record->therapyDoses as $dose) {
                        if ($dose->therapy) {
                            if (
                                $dose->therapy->jenis_terapi == 2 &&
                                !isset($uniqueInjeksiTherapies[$dose->therapy->id])
                            ) {
                                $uniqueInjeksiTherapies[$dose->therapy->id] = [
                                    'nama_obat' => $dose->therapy->nama_obat,
                                    'dihitung' => $dose->therapy->dihitung,
                                ];
                            } elseif (
                                $dose->therapy->jenis_terapi == 3 &&
                                !isset($uniqueDripTherapies[$dose->therapy->id])
                            ) {
                                $uniqueDripTherapies[$dose->therapy->id] = [
                                    'nama_obat' => $dose->therapy->nama_obat,
                                    'dihitung' => $dose->therapy->dihitung,
                                ];
                            } elseif (
                                $dose->therapy->jenis_terapi == 4 &&
                                !isset($uniqueCairanTherapies[$dose->therapy->id])
                            ) {
                                $uniqueCairanTherapies[$dose->therapy->id] = [
                                    'nama_obat' => $dose->therapy->nama_obat,
                                    'dihitung' => $dose->therapy->dihitung,
                                ];
                            }
                        }
                    }
                }
            }
        @endphp

        <div class="card-header bg-light mt-4">
            <h5 class="mb-0"><i class="bi bi-arrow-left-right me-2"></i>Input</h5>
        </div>
        @if ($nonOralTherapyEnteralRecords->isNotEmpty())
            <table class="vital-signs-table no-page-break">
                <thead>
                    <tr>
                        <th style="width: 200px;">Parameter</th>
                        @foreach ($nonOralTherapyEnteralRecords as $item)
                            @php
                                $datetime = \Carbon\Carbon::parse(
                                    $item->tgl_implementasi . ' ' . $item->jam_implementasi,
                                )->format('H:i');
                                $date = \Carbon\Carbon::parse($item->tgl_implementasi)->format('d-M');
                            @endphp
                            <th>{{ $datetime }} <br> <small>{{ $date }}</small></th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($uniqueInjeksiTherapies))
                        <tr>
                            <td class="sub-parameter-header-intake" colspan="1">Therapy Injeksi</td>
                            @foreach ($nonOralTherapyEnteralRecords as $item)
                                <td></td>
                            @endforeach
                        </tr>
                        @foreach ($uniqueInjeksiTherapies as $therapyId => $therapyData)
                            <tr>
                                <td class="parameter-header">
                                    {{ $therapyData['nama_obat'] }}
                                    @if (!$therapyData['dihitung'])
                                        <small class="text-muted">(Tidak dihitung)</small>
                                    @endif
                                </td>
                                @foreach ($nonOralTherapyEnteralRecords as $item)
                                    @php
                                        $doseValue = '-';
                                        if ($item->therapyDoses) {
                                            $dose = $item->therapyDoses
                                                ->where('id_therapy', $therapyId)
                                                ->where('therapy.jenis_terapi', 2)
                                                ->first();
                                            if ($dose && isset($dose->nilai) && $dose->nilai > 0) {
                                                $doseValue = number_format($dose->nilai, 1) . ' cc/ml';
                                            }
                                        }
                                    @endphp
                                    <td>{{ $doseValue }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    @endif

                    @if (!empty($uniqueDripTherapies))
                        <tr>
                            <td class="sub-parameter-header-intake" colspan="1">Therapy Drip</td>
                            @foreach ($nonOralTherapyEnteralRecords as $item)
                                <td></td>
                            @endforeach
                        </tr>
                        @foreach ($uniqueDripTherapies as $therapyId => $therapyData)
                            <tr>
                                <td class="parameter-header">
                                    {{ $therapyData['nama_obat'] }}
                                    @if (!$therapyData['dihitung'])
                                        <small class="text-muted">(Tidak dihitung)</small>
                                    @endif
                                </td>
                                @foreach ($nonOralTherapyEnteralRecords as $item)
                                    @php
                                        $doseValue = '-';
                                        if ($item->therapyDoses) {
                                            $dose = $item->therapyDoses
                                                ->where('id_therapy', $therapyId)
                                                ->where('therapy.jenis_terapi', 3)
                                                ->first();
                                            if ($dose && isset($dose->nilai) && $dose->nilai > 0) {
                                                $doseValue = number_format($dose->nilai, 1) . ' cc/ml';
                                            }
                                        }
                                    @endphp
                                    <td>{{ $doseValue }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    @endif

                    @if (!empty($uniqueCairanTherapies))
                        <tr>
                            <td class="sub-parameter-header-intake" colspan="1">Therapy Cairan</td>
                            @foreach ($nonOralTherapyEnteralRecords as $item)
                                <td></td>
                            @endforeach
                        </tr>
                        @foreach ($uniqueCairanTherapies as $therapyId => $therapyData)
                            <tr>
                                <td class="parameter-header">
                                    {{ $therapyData['nama_obat'] }}
                                    @if (!$therapyData['dihitung'])
                                        <small class="text-muted">(Tidak dihitung)</small>
                                    @endif
                                </td>
                                @foreach ($nonOralTherapyEnteralRecords as $item)
                                    @php
                                        $doseValue = '-';
                                        if ($item->therapyDoses) {
                                            $dose = $item->therapyDoses
                                                ->where('id_therapy', $therapyId)
                                                ->where('therapy.jenis_terapi', 4)
                                                ->first();
                                            if ($dose && isset($dose->nilai) && $dose->nilai > 0) {
                                                $doseValue = number_format($dose->nilai, 1) . ' cc/ml';
                                            }
                                        }
                                    @endphp
                                    <td>{{ $doseValue }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    @endif

                    <tr>
                        <td class="sub-parameter-header-intake" colspan="1">Enteral</td>
                        @foreach ($nonOralTherapyEnteralRecords as $item)
                            <td></td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">Oral (ml)</td>
                        @foreach ($nonOralTherapyEnteralRecords as $item)
                            <td>{{ isset($item->detail->oral) && is_numeric($item->detail->oral) ? number_format((float) $item->detail->oral, 0) : '-' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="parameter-header">NGT (ml)</td>
                        @foreach ($nonOralTherapyEnteralRecords as $item)
                            <td>{{ isset($item->detail->ngt) && is_numeric($item->detail->ngt) ? number_format((float) $item->detail->ngt, 0) : '-' }}
                            </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        @else
            <div class="text-center text-muted p-3">Tidak ada data Terapi Injeksi, Drip, Cairan, atau Input Enteral
                yang
                tercatat signifikan dalam rentang ini.</div>
        @endif

        @php
            $outputOnlyBalanceRecords = $monitoringRecords->filter(function ($record) {
                return (isset($record->detail->bab) && is_numeric($record->detail->bab)) ||
                    (isset($record->detail->urine) && is_numeric($record->detail->urine)) ||
                    (isset($record->detail->iwl) && is_numeric($record->detail->iwl)) ||
                    (isset($record->detail->muntahan_cms) && is_numeric($record->detail->muntahan_cms)) ||
                    (isset($record->detail->drain) && is_numeric($record->detail->drain));
            });

            $clinicalParamsRecords = $monitoringRecords->filter(function ($record) {
                return !empty($record->detail->kesadaran) ||
                    (isset($record->detail->gcs_eye) && is_numeric($record->detail->gcs_eye)) ||
                    (isset($record->detail->gcs_verbal) && is_numeric($record->detail->gcs_verbal)) ||
                    (isset($record->detail->gcs_motor) && is_numeric($record->detail->gcs_motor)) ||
                    (isset($record->detail->gcs_total) && is_numeric($record->detail->gcs_total)) ||
                    !empty($record->detail->pupil_kanan) ||
                    !empty($record->detail->pupil_kiri) ||
                    !empty($record->detail->terapi_oksigen);
            });

            $ventilatorParamsRecords = $monitoringRecords->filter(function ($record) {
                return !empty($record->detail->ventilator_mode) ||
                    (isset($record->detail->ventilator_mv) && is_numeric($record->detail->ventilator_mv)) ||
                    (isset($record->detail->ventilator_tv) && is_numeric($record->detail->ventilator_tv)) ||
                    (isset($record->detail->ventilator_fio2) && is_numeric($record->detail->ventilator_fio2)) ||
                    !empty($record->detail->ventilator_ie_ratio) ||
                    (isset($record->detail->ventilator_pmax) && is_numeric($record->detail->ventilator_pmax)) ||
                    (isset($record->detail->ventilator_peep_ps) && is_numeric($record->detail->ventilator_peep_ps));
            });

            $catheterTubeRecords = $monitoringRecords->filter(function ($record) {
                return !empty($record->detail->ett_no) ||
                    (isset($record->detail->batas_bibir) && is_numeric($record->detail->batas_bibir)) ||
                    !empty($record->detail->ngt_no) ||
                    !empty($record->detail->cvc) ||
                    !empty($record->detail->urine_catch_no) ||
                    !empty($record->detail->iv_line);
            });
        @endphp

        <div class="card-header bg-light mt-4">
            <h5 class="mb-0"><i class="bi bi-arrow-left-right me-2"></i>Output</h5>
        </div>
        <div class="card-body p-0">
            @if ($outputOnlyBalanceRecords->isNotEmpty())
                <table class="vital-signs-table no-page-break">
                    <thead>
                        <tr>
                            <th style="width: 200px;">Parameter</th>
                            @foreach ($outputOnlyBalanceRecords as $item)
                                @php
                                    $datetime = \Carbon\Carbon::parse(
                                        $item->tgl_implementasi . ' ' . $item->jam_implementasi,
                                    )->format('H:i');
                                    $date = \Carbon\Carbon::parse($item->tgl_implementasi)->format('d-M');
                                @endphp
                                <th>{{ $datetime }} <br> <small>{{ $date }}</small></th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="parameter-header">BAB (x)</td>
                            @foreach ($outputOnlyBalanceRecords as $item)
                                <td>{{ isset($item->detail->bab) && is_numeric($item->detail->bab) ? number_format((float) $item->detail->bab, 0) : '-' }}
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="parameter-header">Urine (mL)</td>
                            @foreach ($outputOnlyBalanceRecords as $item)
                                <td>{{ isset($item->detail->urine) && is_numeric($item->detail->urine) ? number_format((float) $item->detail->urine, 0) : '-' }}
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="parameter-header">IWL (mL)</td>
                            @foreach ($outputOnlyBalanceRecords as $item)
                                <td>{{ isset($item->detail->iwl) && is_numeric($item->detail->iwl) ? number_format((float) $item->detail->iwl, 0) : '-' }}
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="parameter-header">Muntahan (mL)</td>
                            @foreach ($outputOnlyBalanceRecords as $item)
                                <td>{{ isset($item->detail->muntahan_cms) && is_numeric($item->detail->muntahan_cms) ? number_format((float) $item->detail->muntahan_cms, 0) : '-' }}
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="parameter-header">Drain (mL)</td>
                            @foreach ($outputOnlyBalanceRecords as $item)
                                <td>{{ isset($item->detail->drain) && is_numeric($item->detail->drain) ? number_format((float) $item->detail->drain, 0) : '-' }}
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            @else
                <div class="text-center text-muted p-3">Tidak ada data Output (I/O Balance) yang tercatat signifikan
                    dalam rentang ini.</div>
            @endif
        </div>

        <!-- Updated Balance Calculation Section with Oral Therapy Logic -->
        <div class="card-header bg-light mt-4">
            <h5 class="mb-0"><i class="bi bi-balance-scale me-2"></i>Balance (I/O)</h5>
        </div>
        <div class="card-body p-0">
            @php
                $balanceRecords = $monitoringRecords->filter(function ($record) {
                    $hasCountedTherapyWithValue = false;
                    if ($record->therapyDoses) {
                        foreach ($record->therapyDoses as $dose) {
                            if (
                                $dose->therapy &&
                                in_array($dose->therapy->jenis_terapi, [1, 2, 3, 4]) && // Include oral therapy (jenis_terapi = 1)
                                $dose->therapy->dihitung == 1 && // Only count therapies with dihitung = 1
                                isset($dose->nilai) &&
                                $dose->nilai > 0
                            ) {
                                $hasCountedTherapyWithValue = true;
                                break;
                            }
                        }
                    }
                    return $hasCountedTherapyWithValue ||
                        (isset($record->detail->oral) &&
                            is_numeric($record->detail->oral) &&
                            $record->detail->oral > 0) ||
                        (isset($record->detail->ngt) && is_numeric($record->detail->ngt) && $record->detail->ngt > 0) ||
                        (isset($record->detail->bab) && is_numeric($record->detail->bab)) ||
                        (isset($record->detail->urine) && is_numeric($record->detail->urine)) ||
                        (isset($record->detail->iwl) && is_numeric($record->detail->iwl)) ||
                        (isset($record->detail->muntahan_cms) && is_numeric($record->detail->muntahan_cms)) ||
                        (isset($record->detail->drain) && is_numeric($record->detail->drain));
                });

                $balanceData = $balanceRecords->map(function ($record) {
                    $totalInput = 0;
                    $totalOutput = 0;

                    // Include ALL therapy doses (oral, injection, drip, fluid) where dihitung = 1
                    if ($record->therapyDoses) {
                        foreach ($record->therapyDoses as $dose) {
                            if (
                                $dose->therapy &&
                                in_array($dose->therapy->jenis_terapi, [1, 2, 3, 4]) && // Include oral therapy
                                $dose->therapy->dihitung == 1 && // Check if therapy should be counted
                                isset($dose->nilai) &&
                                $dose->nilai > 0
                            ) {
                                $totalInput += floatval($dose->nilai);
                            }
                        }
                    }

                    // Enteral inputs (always counted)
                    if (isset($record->detail->oral) && is_numeric($record->detail->oral)) {
                        $totalInput += floatval($record->detail->oral);
                    }
                    if (isset($record->detail->ngt) && is_numeric($record->detail->ngt)) {
                        $totalInput += floatval($record->detail->ngt);
                    }

                    // Output calculations (always counted)
                    if (isset($record->detail->bab) && is_numeric($record->detail->bab)) {
                        $totalOutput += floatval($record->detail->bab);
                    }
                    if (isset($record->detail->urine) && is_numeric($record->detail->urine)) {
                        $totalOutput += floatval($record->detail->urine);
                    }
                    if (isset($record->detail->iwl) && is_numeric($record->detail->iwl)) {
                        $totalOutput += floatval($record->detail->iwl);
                    }
                    if (isset($record->detail->muntahan_cms) && is_numeric($record->detail->muntahan_cms)) {
                        $totalOutput += floatval($record->detail->muntahan_cms);
                    }
                    if (isset($record->detail->drain) && is_numeric($record->detail->drain)) {
                        $totalOutput += floatval($record->detail->drain);
                    }

                    $balance = $totalInput - $totalOutput;

                    return [
                        'total_input' => $totalInput,
                        'total_output' => $totalOutput,
                        'balance' => $balance,
                        'datetime' => \Carbon\Carbon::parse(
                            $record->tgl_implementasi . ' ' . $record->jam_implementasi,
                        ),
                    ];
                });
            @endphp

            @if ($balanceData->isNotEmpty())
                <table class="vital-signs-table no-page-break">
                    <thead>
                        <tr>
                            <th style="width: 200px;">Parameter</th>
                            @foreach ($balanceData as $item)
                                <th>{{ $item['datetime']->format('H:i') }} <br>
                                    <small>{{ $item['datetime']->format('d-M') }}</small>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="parameter-header">Total Input (mL) <small class="text-muted">*termasuk semua
                                    therapy yang dihitung</small></td>
                            @foreach ($balanceData as $item)
                                <td>{{ $item['total_input'] > 0 ? number_format($item['total_input'], 0) : '-' }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="parameter-header">Total Output (mL)</td>
                            @foreach ($balanceData as $item)
                                <td>{{ $item['total_output'] > 0 ? number_format($item['total_output'], 0) : '-' }}
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="parameter-header">Balance (mL)</td>
                            @foreach ($balanceData as $item)
                                <td>{{ $item['balance'] != 0 ? number_format($item['balance'], 0) : '-' }}</td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            @else
                <div class="text-center text-muted p-3">Tidak ada data Balance (I/O) yang tercatat signifikan dalam
                    rentang ini.</div>
            @endif
        </div>

        @php
            $agdElektrolitRecords = $monitoringRecords->filter(function ($record) {
                return isset($record->detail->ph) ||
                    isset($record->detail->po2) ||
                    isset($record->detail->pco2) ||
                    isset($record->detail->be) ||
                    isset($record->detail->hco3) ||
                    isset($record->detail->saturasi_o2) ||
                    isset($record->detail->na) ||
                    isset($record->detail->k) ||
                    isset($record->detail->cl) ||
                    isset($record->detail->ureum) ||
                    isset($record->detail->creatinin) ||
                    isset($record->detail->hb) ||
                    isset($record->detail->ht) ||
                    isset($record->detail->leukosit) ||
                    isset($record->detail->trombosit) ||
                    isset($record->detail->sgot) ||
                    isset($record->detail->sgpt) ||
                    isset($record->detail->albumin) ||
                    isset($record->detail->kdgs);
            });
        @endphp

        <div class="card-header bg-light mt-4">
            <h5 class="mb-0"><i class="bi bi-flask me-2"></i>Data Analisis Gas Darah (AGD)</h5>
        </div>
        <div class="card-body p-0">
            @if ($agdElektrolitRecords->isNotEmpty())
                <table class="vital-signs-table no-page-break" id="agdTable">
                    <thead>
                        <tr>
                            <th style="width: 200px;">Parameter</th>
                            @foreach ($agdElektrolitRecords as $item)
                                @php
                                    $datetime = \Carbon\Carbon::parse(
                                        $item->tgl_implementasi . ' ' . $item->jam_implementasi,
                                    )->format('H:i');
                                    $date = \Carbon\Carbon::parse($item->tgl_implementasi)->format('d-M');
                                @endphp
                                <th>{{ $datetime }} <br> <small>{{ $date }}</small></th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="sub-parameter-header" colspan="1">AGD</td>
                        </tr>
                        <tr>
                            <td class="parameter-header">pH</td>
                            @foreach ($agdElektrolitRecords as $item)
                                <td>{{ isset($item->detail->ph) ? number_format($item->detail->ph, 2) : '-' }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="parameter-header">PO<sub>2</sub> (mmHg)</td>
                            @foreach ($agdElektrolitRecords as $item)
                                <td>{{ isset($item->detail->po2) ? number_format($item->detail->po2, 0) : '-' }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="parameter-header">PCO<sub>2</sub> (mmHg)</td>
                            @foreach ($agdElektrolitRecords as $item)
                                <td>{{ isset($item->detail->pco2) ? number_format($item->detail->pco2, 0) : '-' }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="parameter-header">BE (mmol/L)</td>
                            @foreach ($agdElektrolitRecords as $item)
                                <td>{{ isset($item->detail->be) ? number_format($item->detail->be, 1) : '-' }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="parameter-header">HCO<sub>3</sub> (mmol/L)</td>
                            @foreach ($agdElektrolitRecords as $item)
                                <td>{{ isset($item->detail->hco3) ? number_format($item->detail->hco3, 1) : '-' }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="parameter-header">Saturasi O<sub>2</sub> (%)</td>
                            @foreach ($agdElektrolitRecords as $item)
                                <td>{{ isset($item->detail->saturasi_o2) ? number_format($item->detail->saturasi_o2, 0) : '-' }}
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="parameter-header">Na / K / CL</td>
                            @foreach ($agdElektrolitRecords as $item)
                                <td>{{ isset($item->detail->na) ? number_format($item->detail->na, 0) : '-' }} /
                                    {{ isset($item->detail->k) ? number_format($item->detail->k, 1) : '-' }} /
                                    {{ isset($item->detail->cl) ? number_format($item->detail->cl, 0) : '-' }}
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="parameter-header">Ureum (mg/dL)</td>
                            @foreach ($agdElektrolitRecords as $item)
                                <td>{{ isset($item->detail->ureum) ? number_format($item->detail->ureum, 0) : '-' }}
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="parameter-header">Creatinin (mg/dL)</td>
                            @foreach ($agdElektrolitRecords as $item)
                                <td>{{ isset($item->detail->creatinin) ? number_format($item->detail->creatinin, 2) : '-' }}
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="parameter-header">Hb / HT / L / Tr</td>
                            @foreach ($agdElektrolitRecords as $item)
                                <td>{{ isset($item->detail->hb) ? number_format($item->detail->hb, 1) : '-' }} /
                                    {{ isset($item->detail->ht) ? number_format($item->detail->ht, 1) : '-' }} /
                                    {{ isset($item->detail->leukosit) ? number_format($item->detail->leukosit, 0) : '-' }}
                                    /
                                    {{ isset($item->detail->trombosit) ? number_format($item->detail->trombosit, 0) : '-' }}
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="sub-parameter-header" colspan="1">Lain-lain</td>
                        </tr>
                        <tr>
                            <td class="parameter-header">SGOT (U/L)</td>
                            @foreach ($agdElektrolitRecords as $item)
                                <td>{{ isset($item->detail->sgot) ? number_format($item->detail->sgot, 0) : '-' }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="parameter-header">SGPT (U/L)</td>
                            @foreach ($agdElektrolitRecords as $item)
                                <td>{{ isset($item->detail->sgpt) ? number_format($item->detail->sgpt, 0) : '-' }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="parameter-header">Albumin (g/dL)</td>
                            @foreach ($agdElektrolitRecords as $item)
                                <td>{{ isset($item->detail->albumin) ? number_format($item->detail->albumin, 1) : '-' }}
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="parameter-header">GDS/KDGS (mg/dL)</td>
                            @foreach ($agdElektrolitRecords as $item)
                                <td>{{ isset($item->detail->kdgs) ? number_format($item->detail->kdgs, 0) : '-' }}</td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            @else
                <div class="text-center text-muted p-3">Tidak ada data AGD & Elektrolit yang tercatat dalam rentang
                    ini.</div>
            @endif
        </div>

        <div class="card-header bg-light mt-4">
            <h5 class="mb-0"><i class="bi bi-clipboard2-pulse me-2"></i>Data Parameter Klinis</h5>
        </div>
        <div class="card-body p-0">
            @if ($clinicalParamsRecords->isNotEmpty())
                <table class="vital-signs-table no-page-break" id="clinicalTable">
                    <thead>
                        <tr>
                            <th style="width: 200px;">Parameter</th>
                            @foreach ($clinicalParamsRecords as $item)
                                @php
                                    $datetime = \Carbon\Carbon::parse(
                                        $item->tgl_implementasi . ' ' . $item->jam_implementasi,
                                    )->format('H:i');
                                    $date = \Carbon\Carbon::parse($item->tgl_implementasi)->format('d-M');
                                @endphp
                                <th>{{ $datetime }} <br> <small>{{ $date }}</small></th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="parameter-header">Kesadaran</td>
                            @foreach ($clinicalParamsRecords as $item)
                                <td>{{ !empty($item->detail->kesadaran) ? $item->detail->kesadaran : '-' }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="parameter-header">GCS - Mata (E)</td>
                            @foreach ($clinicalParamsRecords as $item)
                                <td>{{ isset($item->detail->gcs_eye) ? number_format($item->detail->gcs_eye, 0) : '-' }}
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="parameter-header">GCS - Verbal (V)</td>
                            @foreach ($clinicalParamsRecords as $item)
                                <td>{{ isset($item->detail->gcs_verbal) ? number_format($item->detail->gcs_verbal, 0) : '-' }}
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="parameter-header">GCS - Motorik (M)</td>
                            @foreach ($clinicalParamsRecords as $item)
                                <td>{{ isset($item->detail->gcs_motor) ? number_format($item->detail->gcs_motor, 0) : '-' }}
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="parameter-header">GCS - Total</td>
                            @foreach ($clinicalParamsRecords as $item)
                                <td>{{ isset($item->detail->gcs_total) ? number_format($item->detail->gcs_total, 0) : '-' }}
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="parameter-header">Pupil Kanan (mm)</td>
                            @foreach ($clinicalParamsRecords as $item)
                                <td>{{ !empty($item->detail->pupil_kanan) ? $item->detail->pupil_kanan : '-' }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="parameter-header">Pupil Kiri (mm)</td>
                            @foreach ($clinicalParamsRecords as $item)
                                <td>{{ !empty($item->detail->pupil_kiri) ? $item->detail->pupil_kiri : '-' }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="parameter-header">Therapy Oksigen</td>
                            @foreach ($clinicalParamsRecords as $item)
                                <td>{{ !empty($item->detail->terapi_oksigen) ? $item->detail->terapi_oksigen : '-' }}
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            @else
                <div class="text-center text-muted p-3">Tidak ada data Parameter Klinis yang tercatat signifikan dalam
                    rentang ini.</div>
            @endif
        </div>

        <div class="card-header bg-light mt-4">
            @if ($dataMedis->kd_unit == '10131')
                <h5 class="mb-0"><i class="bi bi-fan me-2"></i>Parameter CPAP</h5>
            @elseif(in_array($dataMedis->kd_unit, ['10015', '10016', '10132']))
                <h5 class="mb-0"><i class="bi bi-fan me-2"></i>Parameter Ventilator</h5>
            @endif
        </div>
        <div class="card-body p-0">
            @if ($ventilatorParamsRecords->isNotEmpty())
                <table class="vital-signs-table no-page-break">
                    <thead>
                        <tr>
                            <th style="width: 200px;">Parameter</th>
                            @foreach ($ventilatorParamsRecords as $item)
                                @php
                                    $datetime = \Carbon\Carbon::parse(
                                        $item->tgl_implementasi . ' ' . $item->jam_implementasi,
                                    )->format('H:i');
                                    $date = \Carbon\Carbon::parse($item->tgl_implementasi)->format('d-M');
                                @endphp
                                <th>{{ $datetime }} <br> <small>{{ $date }}</small></th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="parameter-header">Mode</td>
                            @foreach ($ventilatorParamsRecords as $item)
                                <td>{{ !empty($item->detail->ventilator_mode) ? $item->detail->ventilator_mode : '-' }}
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="parameter-header">MV (L/min)</td>
                            @foreach ($ventilatorParamsRecords as $item)
                                <td>{{ isset($item->detail->ventilator_mv) ? number_format($item->detail->ventilator_mv, 1) : '-' }}
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="parameter-header">TV (mL)</td>
                            @foreach ($ventilatorParamsRecords as $item)
                                <td>{{ isset($item->detail->ventilator_tv) ? number_format($item->detail->ventilator_tv, 0) : '-' }}
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="parameter-header">FiO<sub>2</sub> (%)</td>
                            @foreach ($ventilatorParamsRecords as $item)
                                <td>{{ isset($item->detail->ventilator_fio2) ? number_format($item->detail->ventilator_fio2, 0) : '-' }}
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="parameter-header">I:E Ratio</td>
                            @foreach ($ventilatorParamsRecords as $item)
                                <td>{{ !empty($item->detail->ventilator_ie_ratio) ? $item->detail->ventilator_ie_ratio : '-' }}
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="parameter-header">Pmax (cmH<sub>2</sub>O)</td>
                            @foreach ($ventilatorParamsRecords as $item)
                                <td>{{ isset($item->detail->ventilator_pmax) ? number_format($item->detail->ventilator_pmax, 0) : '-' }}
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="parameter-header">PEEP/PS (cmH<sub>2</sub>O)</td>
                            @foreach ($ventilatorParamsRecords as $item)
                                <td>{{ isset($item->detail->ventilator_peep_ps) ? number_format($item->detail->ventilator_peep_ps, 0) : '-' }}
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            @else
                <div class="text-center text-muted p-3">Tidak ada data Parameter Ventilator yang tercatat signifikan
                    dalam rentang ini.</div>
            @endif
        </div>

        <div class="card-header bg-light mt-4">
            <h5 class="mb-0"><i class="bi bi-bandaid me-2"></i>Catheter & Tube</h5>
        </div>
        <div class="card-body p-0">
            @if ($catheterTubeRecords->isNotEmpty())
                <table class="vital-signs-table no-page-break">
                    <thead>
                        <tr>
                            <th style="width: 200px;">Parameter</th>
                            @foreach ($catheterTubeRecords as $item)
                                @php
                                    $datetime = \Carbon\Carbon::parse(
                                        $item->tgl_implementasi . ' ' . $item->jam_implementasi,
                                    )->format('H:i');
                                    $date = \Carbon\Carbon::parse($item->tgl_implementasi)->format('d-M');
                                @endphp
                                <th>{{ $datetime }} <br> <small>{{ $date }}</small></th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="parameter-header">ETT No</td>
                            @foreach ($catheterTubeRecords as $item)
                                <td>{{ !empty($item->detail->ett_no) ? $item->detail->ett_no : '-' }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="parameter-header">Batas Bibir (cm)</td>
                            @foreach ($catheterTubeRecords as $item)
                                <td>{{ isset($item->detail->batas_bibir) && is_numeric($item->detail->batas_bibir) ? number_format($item->detail->batas_bibir, 2) : '-' }}
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="parameter-header">NGT No</td>
                            @foreach ($catheterTubeRecords as $item)
                                <td>{{ !empty($item->detail->ngt_no) ? $item->detail->ngt_no : '-' }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="parameter-header">CVC</td>
                            @foreach ($catheterTubeRecords as $item)
                                <td>{{ !empty($item->detail->cvc) ? $item->detail->cvc : '-' }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="parameter-header">Urine Catch No</td>
                            @foreach ($catheterTubeRecords as $item)
                                <td>{{ !empty($item->detail->urine_catch_no) ? $item->detail->urine_catch_no : '-' }}
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="parameter-header">IV Line</td>
                            @foreach ($catheterTubeRecords as $item)
                                <td>{{ !empty($item->detail->iv_line) ? $item->detail->iv_line : '-' }}</td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            @else
                <div class="text-center text-muted p-3">Tidak ada data Catheter & Tube yang tercatat signifikan dalam
                    rentang ini.</div>
            @endif
        </div>

        <div class="signature">
            <p>{{ $dataMedis->unit->NAMA_UNIT ?? 'Intensive Care' }}, {{ \Carbon\Carbon::now()->format('d-m-Y') }}
            </p>
            <p>Penanggung Jawab</p>
            <br><br><br>
            <p>( {{ auth()->user()->name ?? '........................' }} )</p>
        </div>
    </div>

    <div class="print-footer">
        Dicetak pada: {{ \Carbon\Carbon::now()->format('d-m-Y H:i:s') }}
    </div>

    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>

    <script>
        // Fungsi untuk memformat angka float
        function formatNumber(value, decimals = 1) {
            if (value === null || value === undefined || isNaN(value)) {
                return '-';
            }
            return parseFloat(value).toFixed(decimals);
        }

        // Main execution when document is ready
        document.addEventListener('DOMContentLoaded', () => {
            var monitoringData = @json($monitoringRecords);

            // Siapkan data untuk grafik
            const labels = monitoringData.map(record => {
                const date = new Date(record.tgl_implementasi + ' ' + record.jam_implementasi);
                return `${String(date.getHours()).padStart(2, '0')}:${String(date.getMinutes()).padStart(2, '0')}`;
            });

            const sistolikData = monitoringData.map(record => record.detail.sistolik !== undefined ? parseFloat(
                record.detail.sistolik) : null);
            const diastolikData = monitoringData.map(record => record.detail.diastolik !== undefined ? parseFloat(
                record.detail.diastolik) : null);
            const hrData = monitoringData.map(record => record.detail.hr !== undefined ? parseFloat(record.detail
                .hr) : null);
            const rrData = monitoringData.map(record => record.detail.rr !== undefined ? parseFloat(record.detail
                .rr) : null);
            const suhuData = monitoringData.map(record => record.detail.temp !== undefined ? parseFloat(record
                .detail.temp) : null);
            const mapData = monitoringData.map(record => record.detail.map !== undefined ? parseFloat(record.detail
                .map) : null);

            // Buat grafik dengan data yang sudah diambil
            createChartFromLabels(labels, sistolikData, diastolikData, hrData, rrData, suhuData, mapData);

            // Sembunyikan loading indicator dan tampilkan konten
            document.getElementById('loadingIndicator').style.display = 'none';
            document.getElementById('printContent').style.display = 'block';

            // Aktifkan tombol print
            document.getElementById('printBtn').disabled = false;
        });

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
                            fill: true,
                            tension: 0.4,
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
                        text: `Grafik Monitoring Tanda Vital - {{ $filterType }}: {{ $filterValue ?: 'Semua Data' }}`,
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
