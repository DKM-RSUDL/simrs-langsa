<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Early Warning System (EWS) Pasien Obstetrik</title>
    <style>
        @page {
            margin: 0.3cm;
            size: A4 portrait;
        }

        @media print {
            .page-break {
                page-break-before: always;
            }
            
            .no-break {
                page-break-inside: avoid;
            }
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 7.5pt;
            line-height: 1.1;
        }

        .container {
            width: 100%;
            position: relative;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 4px;
        }

        .logo-rs {
            display: flex;
            align-items: center;
        }

        .logo {
            width: 45px;
            height: 45px;
            margin-right: 6px;
        }

        .hospital-info {
            font-size: 8pt;
        }

        .hospital-name {
            font-size: 11pt;
            font-weight: bold;
            margin: 0;
        }

        .hospital-address {
            margin: 1px 0;
        }

        .patient-info {
            border: 1px solid #000;
            padding: 4px;
            width: 220px;
            font-size: 8pt;
            position: absolute;
            top: 0;
            right: 0;
        }

        .patient-row {
            display: flex;
            margin-bottom: 3px;
        }

        .patient-label {
            width: 70px;
            font-weight: normal;
        }

        .patient-value {
            flex: 1;
        }

        .border-line {
            border-bottom: 1.5px solid black;
            margin: 4px 0;
        }

        .title {
            text-align: center;
            font-size: 10pt;
            font-weight: bold;
            margin: 6px 0;
        }

        table.ews-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 5.5pt;
        }

        table.ews-table th,
        table.ews-table td {
            border: 1px solid #000;
            padding: 1px;
            text-align: center;
            height: 11px;
        }

        table.ews-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .parameter-col {
            width: 90px;
            text-align: left !important;
            padding-left: 4px !important;
            font-weight: bold;
            white-space: nowrap;
        }

        .nilai-col {
            width: 60px;
        }

        .skor-col {
            width: 20px;
        }

        .data-col {
            width: 50px;
            white-space: nowrap;
        }

        .cell-green {
            background-color: #90EE90;
        }

        .cell-yellow {
            background-color: #FFFF00;
        }

        .cell-red {
            background-color: #FF6347;
        }

        .cell-dark {
            background-color: #0d23e9;
            color: #FFFFFF;
        }

        .hasil-ews {
            margin-top: 6px;
            font-size: 6.5pt;
            font-weight: bold;
        }

        .hasil-ews-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 4px;
        }

        .hasil-ews-table td {
            padding: 6px;
            border: 1px solid #000;
            font-size: 8pt;
            text-align: center;
            line-height: 1.2;
            font-weight: bold;
        }

        .hasil-no-risk {
            background-color: #90EE90;
        }

        .hasil-low {
            background-color: #90EE90;
        }

        .hasil-medium {
            background-color: #FFD66B;
        }

        .hasil-high {
            background-color: #FF6347;
            color: white;
        }

        .hasil-code-blue {
            background-color: #3674B5;
            color: #FFFFFF;
        }

        .footer {
            margin-top: 8px;
            font-size: 5.5pt;
            text-align: right;
        }

        .small-text {
            font-size: 5pt;
            display: flex;
            justify-content: start;
        }

        /* Styles untuk halaman kedua */
        .protocol-page {
            font-size: 9pt;
        }

        .protocol-title {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            margin: 20px 0;
        }

        .protocol-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .protocol-table th,
        .protocol-table td {
            border: 1px solid #000;
            padding: 8px;
            font-size: 9pt;
        }

        .protocol-table th {
            background-color: #333;
            color: white;
            font-weight: bold;
            text-align: center;
        }

        .protocol-table td {
            vertical-align: top;
        }

        .protocol-skor-1-4 {
            background-color: #28a745;
            color: white;
            text-align: center;
            font-weight: bold;
        }

        .protocol-skor-5-6 {
            background-color: #FFD66B;
            color: #333;
            text-align: center;
            font-weight: bold;
        }

        .protocol-skor-7-plus {
            background-color: #dc3545;
            color: white;
            text-align: center;
            font-weight: bold;
        }

        .protocol-code-blue {
            background-color: #3674B5;
            color: white;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- Halaman Pertama: Tabel EWS -->
    <div class="container">
        <div class="header">
            <div class="logo-rs">
                <img src="{{ public_path('assets/img/Logo-RSUD-Langsa-1.png') }}" alt="Logo RSUD Langsa" class="logo">
                <div class="hospital-info">
                    <p class="hospital-name">RSUD LANGSA</p>
                    <p class="hospital-address">Jl. Jend. A. Yani, Kota Langsa</p>
                    <p class="hospital-address">Telp: 0641-22051</p>
                    <p class="hospital-address">Email: rsudlangsa.aceh@gmail.com</p>
                </div>
            </div>
            <div class="patient-info">
                <div class="patient-row">
                    <span class="patient-label">No RM:</span>
                    <span class="patient-value">{{ $dataMedis->pasien->kd_pasien ?? '-' }}</span>
                </div>
                <div class="patient-row">
                    <span class="patient-label">Nama:</span>
                    <span class="patient-value">{{ $dataMedis->pasien->nama ?? '-' }}</span>
                </div>
                <div class="patient-row">
                    <span class="patient-label">Jenis Kelamin:</span>
                    <span class="patient-value">{{ $dataMedis->pasien->jenis_kelamin == '0' ? 'Perempuan' : ($dataMedis->pasien->jenis_kelamin == '1' ? 'Laki-laki' : '-') }}</span>
                </div>
                <div class="patient-row">
                    <span class="patient-label">Tanggal Lahir:</span>
                    <span class="patient-value">
                        {{ $dataMedis->pasien->umur ?? '-' }} Thn
                        ({{ $dataMedis->pasien->tgl_lahir ? \Carbon\Carbon::parse($dataMedis->pasien->tgl_lahir)->format('d/m/Y') : '-' }})
                    </span>
                </div>
            </div>
        </div>

        <div class="border-line"></div>

        <div class="title">
            EARLY WARNING SYSTEM (EWS)<br>PASIEN OBSTETRIK
        </div>

        @php
            // Matches for handling database value variations
            $respirasiMatches = [
                '>25' => ['>25', '> 25', '>=25', '>= 25'],
                '21-25' => ['21-25'],
                '12-20' => ['12-20'],
                '<12' => ['<12', '<=12', '<= 12', '=12'],
            ];
            $saturasiMatches = [
                '≥ 95' => ['≥ 95', '>= 95', '= 95', '>=95'],
                '92-95' => ['92-95'],
                '≤ 91' => ['≤ 91', '<= 91', '= 91', '<=91'],
            ];
            $suplemenMatches = [
                'Tidak' => ['Tidak', 'tidak', 'No'],
                'Ya' => ['Ya', 'ya', 'Yes'],
            ];
            $tekananDarahMatches = [
                '> 160' => ['> 160', '>160', '>= 160', '>=160'],
                '151-160' => ['151-160'],
                '141-150' => ['141-150'],
                '91-140' => ['91-140'],
                '< 90' => ['< 90', '<= 90', '<=90', '= 90'],
            ];
            $detakJantungMatches = [
                '> 120' => ['> 120', '>120', '>= 120', '>=120'],
                '111-120' => ['111-120'],
                '101-110' => ['101-110'],
                '61-100' => ['61-100'],
                '50-60' => ['50-60'],
                '≤ 50' => ['≤ 50', '<= 50', '<=50', '= 50'],
            ];
            $kesadaranMatches = [
                'Sadar' => ['Sadar', 'sadar'],
                'Nyeri/Verbal' => ['Nyeri/Verbal', 'nyeri/verbal'],
                'Unresponsive' => ['Unresponsive', 'unresponsive'],
            ];
            $temperaturMatches = [
                '≤ 36' => ['≤ 36', '<= 36', '<=36', '= 36'],
                '36.1-37.2' => ['36.1-37.2'],
                '37.3-37.7' => ['37.3-37.7'],
                '> 37.7' => ['> 37.7', '>37.7', '>= 37.7', '>=37.7'],
            ];
            $dischargeMatches = [
                'Normal' => ['Normal', 'normal'],
                'Abnormal' => ['Abnormal', 'abnormal'],
            ];
            $proteinuriaMatches = [
                'Negatif' => ['Negatif', 'negatif', 'Negative'],
                '≥ 1' => ['≥ 1', '>= 1', '>=1'],
            ];

            // Sort and limit records to 10 to prevent overflow
            $sortedRecords = $ewsRecords->sortBy(function ($record) {
                return \Carbon\Carbon::parse($record->tanggal . ' ' . $record->jam_masuk);
            })->take(10);
        @endphp

        @if($sortedRecords->isEmpty())
            <p style="text-align: center; font-size: 7.5pt;">Tidak ada data EWS yang tersedia.</p>
        @else
            <table class="ews-table">
                <thead>
                    <tr>
                        <th rowspan="3" class="parameter-col">PARAMETER</th>
                        <th colspan="2" rowspan="2">Penilaian & Skor</th>
                        @foreach($sortedRecords as $record)
                            <th class="data-col">{{ \Carbon\Carbon::parse($record->tanggal)->format('d/m/Y') }}</th>
                        @endforeach
                    </tr>
                    <tr>
                        @foreach($sortedRecords as $record)
                            <th class="data-col">{{ \Carbon\Carbon::parse($record->jam_masuk)->format('H:i') }}</th>
                        @endforeach
                    </tr>
                    <tr>
                        <th class="nilai-col">Penilaian</th>
                        <th class="skor-col">Skor</th>
                        @foreach($sortedRecords as $record)
                            <th></th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <!-- Respirasi -->
                    <tr>
                        <td rowspan="4" class="parameter-col">Respirasi (per menit)</td>
                        <td>>25</td>
                        <td>3</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ in_array($record->respirasi, $respirasiMatches['>25']) ? 'cell-red' : '' }}">
                                {{ in_array($record->respirasi, $respirasiMatches['>25']) ? '>25' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>21-25</td>
                        <td>2</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ in_array($record->respirasi, $respirasiMatches['21-25']) ? 'cell-yellow' : '' }}">
                                {{ in_array($record->respirasi, $respirasiMatches['21-25']) ? '21-25' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>12-20</td>
                        <td>0</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ in_array($record->respirasi, $respirasiMatches['12-20']) ? 'cell-green' : '' }}">
                                {{ in_array($record->respirasi, $respirasiMatches['12-20']) ? '12-20' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>12<</td>
                        <td>3</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ in_array($record->respirasi, $respirasiMatches['<12']) ? 'cell-red' : '' }}">
                                {{ in_array($record->respirasi, $respirasiMatches['<12']) ? '<12' : '' }}
                            </td>
                        @endforeach
                    </tr>

                    <!-- Saturasi O2 -->
                    <tr>
                        <td rowspan="3" class="parameter-col">Saturasi O2 (%)</td>
                        <td>≥ 95</td>
                        <td>0</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ in_array($record->saturasi_o2, $saturasiMatches['≥ 95']) ? 'cell-green' : '' }}">
                                {{ in_array($record->saturasi_o2, $saturasiMatches['≥ 95']) ? '≥ 95' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>92-95</td>
                        <td>1</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ in_array($record->saturasi_o2, $saturasiMatches['92-95']) ? 'cell-yellow' : '' }}">
                                {{ in_array($record->saturasi_o2, $saturasiMatches['92-95']) ? '92-95' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>≤ 91</td>
                        <td>3</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ in_array($record->saturasi_o2, $saturasiMatches['≤ 91']) ? 'cell-red' : '' }}">
                                {{ in_array($record->saturasi_o2, $saturasiMatches['≤ 91']) ? '≤ 91' : '' }}
                            </td>
                        @endforeach
                    </tr>

                    <!-- Suplemen O2 -->
                    <tr>
                        <td rowspan="2" class="parameter-col">Suplemen O2</td>
                        <td>Tidak</td>
                        <td>0</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ in_array($record->suplemen_o2, $suplemenMatches['Tidak']) ? 'cell-green' : '' }}">
                                {{ in_array($record->suplemen_o2, $suplemenMatches['Tidak']) ? 'Tidak' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>Ya</td>
                        <td>2</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ in_array($record->suplemen_o2, $suplemenMatches['Ya']) ? 'cell-yellow' : '' }}">
                                {{ in_array($record->suplemen_o2, $suplemenMatches['Ya']) ? 'Ya' : '' }}
                            </td>
                        @endforeach
                    </tr>

                    <!-- Tekanan Darah Sistolik -->
                    <tr>
                        <td rowspan="5" class="parameter-col">Tekanan Darah Sistolik (mmHg)</td>
                        <td>> 160</td>
                        <td>3</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ in_array($record->tekanan_darah, $tekananDarahMatches['> 160']) ? 'cell-red' : '' }}">
                                {{ in_array($record->tekanan_darah, $tekananDarahMatches['> 160']) ? '> 160' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>151-160</td>
                        <td>2</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ in_array($record->tekanan_darah, $tekananDarahMatches['151-160']) ? 'cell-yellow' : '' }}">
                                {{ in_array($record->tekanan_darah, $tekananDarahMatches['151-160']) ? '151-160' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>141-150</td>
                        <td>1</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ in_array($record->tekanan_darah, $tekananDarahMatches['141-150']) ? 'cell-yellow' : '' }}">
                                {{ in_array($record->tekanan_darah, $tekananDarahMatches['141-150']) ? '141-150' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>91-140</td>
                        <td>0</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ in_array($record->tekanan_darah, $tekananDarahMatches['91-140']) ? 'cell-green' : '' }}">
                                {{ in_array($record->tekanan_darah, $tekananDarahMatches['91-140']) ? '91-140' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>< 90</td>
                        <td>3</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ in_array($record->tekanan_darah, $tekananDarahMatches['< 90']) ? 'cell-red' : '' }}">
                                {{ in_array($record->tekanan_darah, $tekananDarahMatches['< 90']) ? '< 90' : '' }}
                            </td>
                        @endforeach
                    </tr>

                    <!-- Detak Jantung -->
                    <tr>
                        <td rowspan="6" class="parameter-col">Detak Jantung (per menit)</td>
                        <td>> 120</td>
                        <td>3</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ in_array($record->detak_jantung, $detakJantungMatches['> 120']) ? 'cell-red' : '' }}">
                                {{ in_array($record->detak_jantung, $detakJantungMatches['> 120']) ? '> 120' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>111-120</td>
                        <td>2</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ in_array($record->detak_jantung, $detakJantungMatches['111-120']) ? 'cell-yellow' : '' }}">
                                {{ in_array($record->detak_jantung, $detakJantungMatches['111-120']) ? '111-120' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>101-110</td>
                        <td>1</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ in_array($record->detak_jantung, $detakJantungMatches['101-110']) ? 'cell-yellow' : '' }}">
                                {{ in_array($record->detak_jantung, $detakJantungMatches['101-110']) ? '101-110' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>61-100</td>
                        <td>0</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ in_array($record->detak_jantung, $detakJantungMatches['61-100']) ? 'cell-green' : '' }}">
                                {{ in_array($record->detak_jantung, $detakJantungMatches['61-100']) ? '61-100' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>50-60</td>
                        <td>2</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ in_array($record->detak_jantung, $detakJantungMatches['50-60']) ? 'cell-yellow' : '' }}">
                                {{ in_array($record->detak_jantung, $detakJantungMatches['50-60']) ? '50-60' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>≤ 50</td>
                        <td>3</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ in_array($record->detak_jantung, $detakJantungMatches['≤ 50']) ? 'cell-red' : '' }}">
                                {{ in_array($record->detak_jantung, $detakJantungMatches['≤ 50']) ? '≤ 50' : '' }}
                            </td>
                        @endforeach
                    </tr>

                    <!-- Kesadaran -->
                    <tr>
                        <td rowspan="3" class="parameter-col">Kesadaran</td>
                        <td>Sadar</td>
                        <td>0</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ in_array($record->kesadaran, $kesadaranMatches['Sadar']) ? 'cell-green' : '' }}">
                                {{ in_array($record->kesadaran, $kesadaranMatches['Sadar']) ? 'Sadar' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>Nyeri/Verbal</td>
                        <td>2</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ in_array($record->kesadaran, $kesadaranMatches['Nyeri/Verbal']) ? 'cell-yellow' : '' }}">
                                {{ in_array($record->kesadaran, $kesadaranMatches['Nyeri/Verbal']) ? 'Nyeri/Verbal' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>Unresponsive</td>
                        <td>Code Blue</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ in_array($record->kesadaran, $kesadaranMatches['Unresponsive']) ? 'cell-dark' : '' }}">
                                {{ in_array($record->kesadaran, $kesadaranMatches['Unresponsive']) ? 'Unresponsive' : '' }}
                            </td>
                        @endforeach
                    </tr>

                    <!-- Temperatur -->
                    <tr>
                        <td rowspan="4" class="parameter-col">Temperatur (°C)</td>
                        <td>≤ 36</td>
                        <td>2</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ in_array($record->temperatur, $temperaturMatches['≤ 36']) ? 'cell-yellow' : '' }}">
                                {{ in_array($record->temperatur, $temperaturMatches['≤ 36']) ? '≤ 36' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>36.1-37.2</td>
                        <td>0</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ in_array($record->temperatur, $temperaturMatches['36.1-37.2']) ? 'cell-green' : '' }}">
                                {{ in_array($record->temperatur, $temperaturMatches['36.1-37.2']) ? '36.1-37.2' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>37.3-37.7</td>
                        <td>1</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ in_array($record->temperatur, $temperaturMatches['37.3-37.7']) ? 'cell-yellow' : '' }}">
                                {{ in_array($record->temperatur, $temperaturMatches['37.3-37.7']) ? '37.3-37.7' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>> 37.7</td>
                        <td>2</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ in_array($record->temperatur, $temperaturMatches['> 37.7']) ? 'cell-yellow' : '' }}">
                                {{ in_array($record->temperatur, $temperaturMatches['> 37.7']) ? '> 37.7' : '' }}
                            </td>
                        @endforeach
                    </tr>

                    <!-- Discharge/Lochia -->
                    <tr>
                        <td rowspan="2" class="parameter-col">Discharge/Lochia</td>
                        <td>Normal</td>
                        <td>0</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ in_array($record->discharge, $dischargeMatches['Normal']) ? 'cell-green' : '' }}">
                                {{ in_array($record->discharge, $dischargeMatches['Normal']) ? 'Normal' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>Abnormal</td>
                        <td>2</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ in_array($record->discharge, $dischargeMatches['Abnormal']) ? 'cell-yellow' : '' }}">
                                {{ in_array($record->discharge, $dischargeMatches['Abnormal']) ? 'Abnormal' : '' }}
                            </td>
                        @endforeach
                    </tr>

                    <!-- Proteinuria -->
                    <tr>
                        <td rowspan="2" class="parameter-col">Proteinuria/hari</td>
                        <td>Negatif</td>
                        <td>0</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ in_array($record->proteinuria, $proteinuriaMatches['Negatif']) ? 'cell-green' : '' }}">
                                {{ in_array($record->proteinuria, $proteinuriaMatches['Negatif']) ? 'Negatif' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>≥ 1</td>
                        <td>1</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ in_array($record->proteinuria, $proteinuriaMatches['≥ 1']) ? 'cell-yellow' : '' }}">
                                {{ in_array($record->proteinuria, $proteinuriaMatches['≥ 1']) ? '≥ 1' : '' }}
                            </td>
                        @endforeach
                    </tr>

                    <!-- Total Skor -->
                    <tr>
                        <td colspan="2" style="text-align: center; font-weight: bold;">TOTAL SKOR</td>
                        <td></td>
                        @foreach($sortedRecords as $record)
                            @php
                                $riskClass = '';
                                if (in_array($record->kesadaran, $kesadaranMatches['Unresponsive'])) {
                                    $riskClass = 'cell-dark';
                                } elseif ($record->total_skor >= 7) {
                                    $riskClass = 'cell-red';
                                } elseif ($record->total_skor >= 5 || in_array($record->kesadaran, $kesadaranMatches['Nyeri/Verbal'])) {
                                    $riskClass = 'cell-yellow';
                                } else {
                                    $riskClass = 'cell-green';
                                }
                            @endphp
                            <td style="font-weight: bold;" class="{{ $riskClass }}">{{ $record->total_skor ?? '-' }}</td>
                        @endforeach
                    </tr>

                    <!-- Level Risiko -->
                    <tr>
                        <td colspan="2" style="text-align: center; font-weight: bold;">LEVEL RISIKO</td>
                        <td></td>
                        @foreach($sortedRecords as $record)
                            @php
                                $riskText = '';
                                $riskClass = '';
                                if (in_array($record->hasil_ews, ['HENTI NAFAS/JANTUNG', 'CODE BLUE - HENTI NAFAS/JANTUNG']) || in_array($record->kesadaran, $kesadaranMatches['Unresponsive'])) {
                                    $riskText = 'CODE BLUE';
                                    $riskClass = 'cell-dark';
                                } elseif ($record->hasil_ews == 'RISIKO TINGGI' || $record->total_skor >= 7) {
                                    $riskText = 'TINGGI';
                                    $riskClass = 'cell-red';
                                } elseif ($record->hasil_ews == 'RISIKO SEDANG' || $record->total_skor >= 5 || in_array($record->kesadaran, $kesadaranMatches['Nyeri/Verbal'])) {
                                    $riskText = 'SEDANG';
                                    $riskClass = 'cell-yellow';
                                } elseif ($record->hasil_ews == 'RISIKO RENDAH' || ($record->total_skor > 0 && $record->total_skor <= 4)) {
                                    $riskText = 'RENDAH';
                                    $riskClass = 'cell-green';
                                } else {
                                    $riskText = 'TIDAK ADA';
                                    $riskClass = 'cell-green';
                                }
                            @endphp
                            <td style="font-weight: bold;" class="{{ $riskClass }}">{{ $riskText }}</td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        @endif

        <!-- Hasil EWS berdasarkan skor terbaru -->
        @php
            $latestRecord = $sortedRecords->last();
            $resultText = '';
            $resultClass = '';
            
            if ($latestRecord) {
                if (in_array($latestRecord->kesadaran, $kesadaranMatches['Unresponsive'])) {
                    $resultText = 'Henti Nafas/Jantung: CODE BLUE<br>Lakukan RJP oleh petugas/tim primer, aktivasi code blue henti jantung, respon Tim Medis Emergency (TME)/tim Code Blue segera (maksimal 5 menit), informasikan dan konsultasikan dengan DPJP.';
                    $resultClass = 'hasil-code-blue';
                } elseif ($latestRecord->total_skor >= 7) {
                    $resultText = 'Total Skor ≥ 7: RISIKO TINGGI<br>Resusitasi dan monitoring secara kontinyu oleh dokter jaga dan perawat senior, aktivasi code blue kegawatan medis, respon Tim Medis Emergency (TME)/tim Code Blue segera (maksimal 10 menit), Informasikan dan konsultasikan ke DPJP.';
                    $resultClass = 'hasil-high';
                } elseif ($latestRecord->total_skor >= 5 || in_array($latestRecord->kesadaran, $kesadaranMatches['Nyeri/Verbal'])) {
                    $resultText = 'Total Skor 5-6: RISIKO SEDANG<br>Assessment segera oleh dokter jaga (respon segera, maks 5 menit), konsultasi DPJP dan spesialis terkait, eksalasi perawatan dan monitoring tiap jam, pertimbangkan perawatan dengan monitoring yang sesuai (HCU).';
                    $resultClass = 'hasil-medium';
                } elseif ($latestRecord->total_skor >= 1 && $latestRecord->total_skor <= 4) {
                    $resultText = 'Total Skor 1-4: RISIKO RENDAH<br>Assessment segera oleh perawat senior, respon segera, maks 5 menit, eskalasi perawatan dan frekuensi monitoring per 4-6 jam, Jika diperlukan assessment oleh dokter jaga bangsal.';
                    $resultClass = 'hasil-low';
                } else {
                    $resultText = 'Total Skor 0: TIDAK ADA RISIKO<br>Lanjutkan observasi/monitoring secara rutin/per shift.';
                    $resultClass = 'hasil-no-risk';
                }
            }
        @endphp

        <div class="hasil-ews">HASIL EARLY WARNING SCORING:</div>
        <table class="hasil-ews-table">
            <tr>
                <td class="{{ $resultClass }}">
                    {!! $resultText !!}
                </td>
            </tr>
        </table>

        <div class="footer">
            <p>Nama dan Paraf:</p>
            <p style="margin-top: 20px;">{{ str()->title($ewsPsienObstetrik->userCreate->name ?? '-') }}</p>
            <p class="small-text">Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}</p>
            @if(isset($ewsPsienObstetrik->userCreate->jabatan))
                <p>{{ $ewsPsienObstetrik->userCreate->jabatan }}</p>
            @endif
        </div>
    </div>

    <!-- Halaman Kedua: Protokol Assessment dan Intervensi -->
    <div class="page-break"></div>
    <div class="protocol-page">
        <p class="protocol-title">PROTOKOL ASSESSMENT DAN INTERVENSI EWS</p>
        
        <div style="display: flex; justify-content: center; margin-bottom: 20px;">
            <table class="protocol-table">
                <thead>
                    <tr>
                        <th style="width: 200px;">SKOR EWS</th>
                        <th>ASSESSMENT DAN INTERVENSI</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="protocol-skor-1-4">
                            Skor 1-4
                        </td>
                        <td>
                            Assessment segera oleh perawat senior, respon segera, maks 5 menit, eskalasi perawatan dan frekuensi monitoring per 4-6 jam, Jika diperlukan assessment oleh dokter jaga bangsal.
                        </td>
                    </tr>
                    <tr>
                        <td class="protocol-skor-5-6">
                            Skor 5-6
                        </td>
                        <td>
                            Assessment segera oleh dokter jaga (respon segera, maks 5 menit), konsultasi DPJP dan spesialis terkait, eksalasi perawatan dan monitoring tiap jam, pertimbangkan perawatan dengan monitoring yang sesuai (HCU).
                        </td>
                    </tr>
                    <tr>
                        <td class="protocol-skor-7-plus">
                            Skor 7 atau Lebih atau Parameter Code Blue (Risiko Tinggi)
                        </td>
                        <td>
                            Resusitasi dan monitoring secara kontinyu oleh dokter jaga dan perawat senior, Aktivasi code blue kegawatan medis, respon Tim Medis Emergency (TME)/tim Code Blue segera, maksimal 10 menit), Informasikan dan konsultasikan ke DPJP.
                        </td>
                    </tr>
                    <tr>
                        <td class="protocol-code-blue">
                            HENTI NAFAS/JANTUNG
                        </td>
                        <td>
                            Lakukan RJP oleh petugas/tim primer, aktivasi code blue henti jantung, respon Tim Medis Emergency (TME) /tim Code Blue segera, maksimal 5 menit, informasikan dan konsultasikan dengan DPJP.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>