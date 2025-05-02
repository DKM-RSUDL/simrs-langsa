<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Monitoring Pasien</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

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
            width:100%;
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
            background-color: #f8f9fa;
            padding: 8px;
            text-align: center;
            border: 1px solid #dee2e6;
            font-weight: bold;
        }

        .vital-signs-table td {
            padding: 8px;
            text-align: center;
            border-top: none;
            border-bottom: none;
            border-left: 1px solid #dee2e6;
            border-right: 1px solid #dee2e6;
        }

        .vital-signs-table tr:last-child td {
            border-bottom: 1px solid #dee2e6;
        }

        .parameter-header {
            text-align: left;
            font-weight: bold;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6 !important;
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

        <!-- Vital Signs Table - Unchanged -->
        <table class="vital-signs-table no-page-break" id="vitalSignsTable">
            <thead>
                <tr id="dateTimeHeaders">
                    <th style="width: 200px;">Parameter</th>
                    <!-- Date/Time headers will be dynamically generated here -->
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="parameter-header">Sistolik (mmHg)</td>
                    <!-- Data will be filled dynamically -->
                </tr>
                <tr>
                    <td class="parameter-header">Diastolik (mmHg)</td>
                    <!-- Data will be filled dynamically -->
                </tr>
                <tr>
                    <td class="parameter-header">Heart Rate (x/mnt)</td>
                    <!-- Data will be filled dynamically -->
                </tr>
                <tr>
                    <td class="parameter-header">Respiratory Rate (x/mnt)</td>
                    <!-- Data will be filled dynamically -->
                </tr>
                <tr>
                    <td class="parameter-header">Suhu (°C)</td>
                    <!-- Data will be filled dynamically -->
                </tr>
                <tr>
                    <td class="parameter-header">MAP (mmHg)</td>
                    <!-- Data will be filled dynamically -->
                </tr>
            </tbody>
        </table>

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
        function formatNumber(value, decimals = 1) {
            if (value === null || value === undefined || isNaN(value)) {
                return '-';
            }
            return parseFloat(value).toFixed(decimals);
        }

        // Fungsi untuk memformat tanggal dan waktu
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

        // Fungsi untuk memproses data
        function processPrintData(data, filterRangeText, unitTitleText) {
            console.log("Processing print data:", data.length, "records");

            // Aktifkan tombol print
            document.getElementById('printBtn').disabled = false;

            // Set informasi filter
            if (filterRangeText) {
                document.getElementById('filterText').textContent = filterRangeText;

                // Ekstrak tanggal dari filterRangeText
                // Contoh filterRangeText: "30-04-2025 00:00 s.d 30-04-2025 23:59"
                const dateMatch = filterRangeText.match(/(\d{2}-\d{2}-\d{4})/);
                if (dateMatch) {
                    document.getElementById('filterDate').textContent = dateMatch[0]; // Misalnya: 30-04-2025
                } else {
                    document.getElementById('filterDate').textContent = '-';
                }
            } else {
                document.getElementById('filterDate').textContent = '-';
            }

            // Set judul unit jika ada
            if (unitTitleText) {
                document.getElementById('unitTitle').textContent = unitTitleText;
            }

            if (!data || data.length === 0) {
                document.getElementById('loadingIndicator').innerHTML =
                    '<div class="alert alert-info">Tidak ada data untuk ditampilkan</div>';
                return;
            }

            try {
                // Urutkan data berdasarkan waktu (asc)
                const sortedData = [...data].sort((a, b) => {
                    const dateTimeA = new Date(a.tgl_implementasi + 'T' + a.jam_implementasi);
                    const dateTimeB = new Date(b.tgl_implementasi + 'T' + b.jam_implementasi);
                    return dateTimeA - dateTimeB;
                });

                // Generate header untuk setiap pengukuran
                const headerRow = document.getElementById('dateTimeHeaders');
                headerRow.innerHTML = '<th style="width: 200px;">Parameter</th>';

                sortedData.forEach(item => {
                    const datetime = formatDateTime(item.tgl_implementasi + 'T' + item.jam_implementasi);
                    const headerCell = document.createElement('th');
                    headerCell.innerHTML = datetime.time;
                    headerRow.appendChild(headerCell);
                });

                // Dapatkan baris tabel untuk setiap parameter
                const tableRows = document.querySelectorAll('#vitalSignsTable tbody tr');

                // Definisikan parameter dan formatnya
                const parameters = [{
                        row: tableRows[0],
                        accessor: item => formatNumber(item.detail?.sistolik, 0),
                        label: 'Sistolik'
                    },
                    {
                        row: tableRows[1],
                        accessor: item => formatNumber(item.detail?.diastolik, 0),
                        label: 'Diastolik'
                    },
                    {
                        row: tableRows[2],
                        accessor: item => formatNumber(item.detail?.hr, 0),
                        label: 'Heart Rate'
                    },
                    {
                        row: tableRows[3],
                        accessor: item => formatNumber(item.detail?.rr, 0),
                        label: 'Respiratory Rate'
                    },
                    {
                        row: tableRows[4],
                        accessor: item => formatNumber(item.detail?.temp, 1),
                        label: 'Suhu'
                    },
                    {
                        row: tableRows[5],
                        accessor: item => formatNumber(item.detail?.map, 0),
                        label: 'MAP'
                    },
                ];

                // Isi data untuk setiap parameter
                parameters.forEach(param => {
                    populateRow(param.row, sortedData, param.accessor, param.label);
                });

                // Sembunyikan loading indicator dan tampilkan konten
                document.getElementById('loadingIndicator').style.display = 'none';
                document.getElementById('printContent').style.display = 'block';

            } catch (e) {
                console.error("Error processing data:", e);
                document.getElementById('loadingIndicator').innerHTML =
                    `<div class="alert alert-danger">Error: ${e.message}</div>`;
            }
        }

        // Helper function untuk mengisi baris dengan data
        function populateRow(row, data, valueAccessor, label) {
            // Reset row content except for the first cell (parameter name)
            const cells = row.querySelectorAll('td:not(:first-child)');
            cells.forEach(cell => cell.remove());

            // Add cells for each data point
            data.forEach(item => {
                try {
                    const cell = document.createElement('td');
                    cell.textContent = valueAccessor(item);
                    row.appendChild(cell);
                } catch (e) {
                    console.error(`Error populating cell for ${label}:`, e);
                    const cell = document.createElement('td');
                    cell.textContent = 'Error';
                    row.appendChild(cell);
                }
            });
        }

        // Main execution when document is ready
        document.addEventListener('DOMContentLoaded', () => {
            console.log("DOM loaded, checking for data from opener");

            if (window.opener && window.opener.printData) {
                console.log("Found data in window.opener.printData");
                processPrintData(
                    window.opener.printData,
                    window.opener.filterRange,
                    window.opener.unitTitle
                );
            } else {
                console.log("No data yet, setting up window listener");
                window.addEventListener('message', event => {
                    if (event.data && event.data.type === 'printData') {
                        processPrintData(
                            event.data.printData,
                            event.data.filterRange,
                            event.data.unitTitle
                        );
                    }
                });

                if (window.opener) {
                    console.log("Requesting data from opener");
                    window.opener.postMessage({
                        type: 'requestPrintData'
                    }, '*');
                }

                setTimeout(() => {
                    if (window.printData) {
                        console.log("Found data in window.printData after delay");
                        processPrintData(window.printData, window.filterRange, window.unitTitle);
                    }
                }, 500);
            }

            setTimeout(() => {
                if (document.getElementById('loadingIndicator').style.display !== 'none') {
                    document.getElementById('loadingIndicator').innerHTML =
                        '<div class="alert alert-warning">Data tidak berhasil dimuat. Coba tutup dan buka kembali jendela print.</div>';
                }
            }, 5000);
        });
    </script>
</body>

</html>
