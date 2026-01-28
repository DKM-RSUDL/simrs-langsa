<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Early Warning System (EWS) Pasien Obstetrik</title>
    <style>
        @page {
            size: A4;
            margin: 3mm 6mm;
        }

        .a4 {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "DejaVu Sans", "Helvetica", "Arial", sans-serif !important;
            font-size: 8.5pt;
            width: 100%;
            max-width: 100%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            padding: 4px 6px;
            vertical-align: top;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #f0f0f0;
            padding: 0;
            position: relative;
        }

        .td-left {
            width: 40%;
            text-align: left;
            vertical-align: middle;
        }

        .td-center {
            width: 40%;
            text-align: center;
            vertical-align: middle;
        }

        .td-right {
            width: 20%;
            text-align: center;
            vertical-align: middle;
        }

        .brand-table {
            border-collapse: collapse;
            background-color: transparent;
        }

        .va-middle {
            vertical-align: middle;
        }

        .brand-name {
            font-weight: 700;
            margin: 0;
            font-size: 14px;
        }

        .brand-info {
            margin: 0;
            font-size: 7px;
        }

        .title-main {
            display: block;
            font-size: 16px;
            font-weight: bold;
            margin: 0;
        }

        .title-sub {
            display: block;
            font-size: 14px;
            font-weight: bold;
            margin: 0;
        }

        .unit-box {
            background-color: #bbbbbb;
            padding: 15px 0px;
            width: 100%;
            margin: 0 auto;
            text-align: center;
        }

        .unit-text {
            font-size: 18px;
            font-weight: bold;
            color: #ffffff;
        }

        .patient-table {
            width: 100%;
            margin-top: 15px;
            border-collapse: collapse;
        }

        .patient-table th,
        .patient-table td {
            border: 1px solid #ccc;
            padding: 5px 7px;
            font-size: 9pt;
        }

        .patient-table th {
            background-color: #f2f2f2;
            text-align: left;
            width: 130px;
        }

        .section-title {
            font-weight: bold;
            font-size: 11pt;
            padding-top: 12px;
        }

        .label {
            font-weight: bold;
            width: 38%;
            padding-right: 8px;
        }

        .value {
            border-bottom: 1px solid #000;
            min-height: 22px;
        }

        .value.tall {
            min-height: 32px;
        }

        .value.empty-space {
            min-height: 60px;
        }

        .checkbox-group label {
            margin-right: 28px;
            display: inline-block;
        }

        /* EWS specific styles */
        .ews-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 6pt;
            margin-top: 10px;
        }

        .ews-table th,
        .ews-table td {
            border: 1px solid #000;
            padding: 2px;
            text-align: center;
            height: 14px;
        }

        .ews-table th {
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

        .cell-green {
            background-color: #90EE90;
        }

        .cell-yellow {
            background-color: #FFFF00;
        }

        .cell-red {
            background-color: #FF6347;
        }

        .hasil-ews {
            margin-top: 8px;
            font-size: 7pt;
            font-weight: bold;
        }

        .hasil-ews-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        .hasil-ews-table td {
            padding: 4px;
            border: 1px solid #000;
            font-size: 6pt;
            text-align: center;
        }

        .hasil-low {
            background-color: #90EE90;
        }

        .hasil-medium {
            background-color: #FFFF00;
        }

        .hasil-high {
            background-color: #FF6347;
        }

        .intervention-page {
            font-size: 8pt;
            margin-top: 20px;
        }

        .intervention-title {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            margin: 20px 0;
        }

        .risk-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .risk-table td {
            border: 2px solid #000;
            padding: 8px;
            text-align: center;
            font-weight: bold;
            font-size: 10pt;
        }

        .risk-low {
            background-color: #90EE90;
        }

        .risk-medium {
            background-color: #FFFF00;
        }

        .risk-high {
            background-color: #FF6347;
            color: white;
        }

        .avpu-explanation {
            margin: 15px 0;
            font-size: 9pt;
        }

        .avpu-explanation p {
            margin: 3px 0;
        }

        .intervention-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .intervention-table th,
        .intervention-table td {
            border: 1px solid #000;
            padding: 6px;
            font-size: 8pt;
        }

        .intervention-table th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }

        .intervention-table td {
            vertical-align: top;
        }

        .footer {
            margin-top: 10px;
            font-size: 6pt;
            text-align: right;
        }

        .small-text {
            font-size: 5pt;
        }

        /* Print specific */
        @media print {
            .page-break {
                page-break-before: always;
            }
        }
    </style>
</head>

<body>
    <div class="a4">

        @php
            // logo base64 (dompdf-friendly)
            $logoPath = public_path('assets/img/Logo-RSUD-Langsa-1.png');
            $logoType = pathinfo($logoPath, PATHINFO_EXTENSION);
            $logoData = @file_get_contents($logoPath);
            $logoBase64 = $logoData ? 'data:image/' . $logoType . ';base64,' . base64_encode($logoData) : null;
        @endphp

        <table class="header-table">
            <tr>
                <td class="td-left">
                    <table class="brand-table">
                        <tr>
                            <td class="va-middle">
                                @if ($logoBase64)
                                    <img src="{{ $logoBase64 }}" alt="Logo RSUD Langsa"
                                        style="width: 50px; height: 50px;">
                                @endif
                            </td>
                            <td class="va-middle">
                                <p class="brand-name">RSUD LANGSA</p>
                                <p class="brand-info">Jl. Jend. A. Yani, Kota Langsa</p>
                                <p class="brand-info">Telp: 0641-22051</p>
                                <p class="brand-info">Email: rsudlangsa.aceh@gmail.com</p>
                            </td>
                        </tr>
                    </table>
                </td>

                <td class="td-center">
                    <span class="title-main">EARLY WARNING SYSTEM (EWS)</span>
                    <span class="title-sub">PASIEN OBSTETRIK</span>
                </td>

                <td class="td-right">
                    <div class="unit-box">
                        <span class="unit-text" style="font-size: 14px; margin-top: 10px;">RAWAT INAP</span>
                    </div>
                </td>
            </tr>
        </table>

        <table class="patient-table">
            <tr>
                <th>No. RM</th>
                <td>{{ $dataMedis->pasien->kd_pasien ?? '-' }}</td>
                <th>Tgl. Lahir</th>
                <td>
                    {{ !empty($dataMedis->pasien->tgl_lahir) ? date('d M Y', strtotime($dataMedis->pasien->tgl_lahir)) : '-' }}
                </td>
            </tr>
            <tr>
                <th>Nama Pasien</th>
                <td>{{ $dataMedis->pasien->nama ?? '-' }}</td>
                <th>Jenis Kelamin</th>
                <td>
                    @php
                        $gender = '-';
                        if (isset($dataMedis->pasien->jenis_kelamin)) {
                            $gender = (string) $dataMedis->pasien->jenis_kelamin === '1' ? 'Laki-Laki' : 'Perempuan';
                        }
                    @endphp
                    {{ $gender }}
                </td>
            </tr>
        </table>

        <br>

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
            $sortedRecords = $ewsRecords
                ->sortBy(function ($record) {
                    return \Carbon\Carbon::parse($record->tanggal . ' ' . $record->jam_masuk);
                })
                ->take(10);
        @endphp

        @if ($sortedRecords->isEmpty())
            <p style="text-align: center; font-size: 7.5pt;">Tidak ada data EWS yang tersedia.</p>
        @else
            <table class="ews-table">
                <thead>
                    <tr>
                        <th rowspan="3" class="parameter-col">PARAMETER</th>
                        <th colspan="2" rowspan="2">Penilaian & Skor</th>
                        @foreach ($sortedRecords as $record)
                            <th class="data-col">{{ \Carbon\Carbon::parse($record->tanggal)->format('d/m/Y') }}</th>
                        @endforeach
                    </tr>
                    <tr>
                        @foreach ($sortedRecords as $record)
                            <th class="data-col">{{ \Carbon\Carbon::parse($record->jam_masuk)->format('H:i') }}</th>
                        @endforeach
                    </tr>
                    <tr>
                        <th class="nilai-col">Penilaian</th>
                        <th class="skor-col">Skor</th>
                        @foreach ($sortedRecords as $record)
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
                        @foreach ($sortedRecords as $record)
                            <td class="{{ in_array($record->respirasi, $respirasiMatches['>25']) ? 'cell-red' : '' }}">
                                {{ in_array($record->respirasi, $respirasiMatches['>25']) ? '>25' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>21-25</td>
                        <td>2</td>
                        @foreach ($sortedRecords as $record)
                            <td
                                class="{{ in_array($record->respirasi, $respirasiMatches['21-25']) ? 'cell-yellow' : '' }}">
                                {{ in_array($record->respirasi, $respirasiMatches['21-25']) ? '21-25' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>12-20</td>
                        <td>0</td>
                        @foreach ($sortedRecords as $record)
                            <td
                                class="{{ in_array($record->respirasi, $respirasiMatches['12-20']) ? 'cell-green' : '' }}">
                                {{ in_array($record->respirasi, $respirasiMatches['12-20']) ? '12-20' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>12<< /td>
                        <td>3</td>
                        @foreach ($sortedRecords as $record)
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
                        @foreach ($sortedRecords as $record)
                            <td
                                class="{{ in_array($record->saturasi_o2, $saturasiMatches['≥ 95']) ? 'cell-green' : '' }}">
                                {{ in_array($record->saturasi_o2, $saturasiMatches['≥ 95']) ? '≥ 95' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>92-95</td>
                        <td>1</td>
                        @foreach ($sortedRecords as $record)
                            <td
                                class="{{ in_array($record->saturasi_o2, $saturasiMatches['92-95']) ? 'cell-yellow' : '' }}">
                                {{ in_array($record->saturasi_o2, $saturasiMatches['92-95']) ? '92-95' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>≤ 91</td>
                        <td>3</td>
                        @foreach ($sortedRecords as $record)
                            <td
                                class="{{ in_array($record->saturasi_o2, $saturasiMatches['≤ 91']) ? 'cell-red' : '' }}">
                                {{ in_array($record->saturasi_o2, $saturasiMatches['≤ 91']) ? '≤ 91' : '' }}
                            </td>
                        @endforeach
                    </tr>

                    <!-- Suplemen O2 -->
                    <tr>
                        <td rowspan="2" class="parameter-col">Suplemen O2</td>
                        <td>Tidak</td>
                        <td>0</td>
                        @foreach ($sortedRecords as $record)
                            <td
                                class="{{ in_array($record->suplemen_o2, $suplemenMatches['Tidak']) ? 'cell-green' : '' }}">
                                {{ in_array($record->suplemen_o2, $suplemenMatches['Tidak']) ? 'Tidak' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>Ya</td>
                        <td>2</td>
                        @foreach ($sortedRecords as $record)
                            <td
                                class="{{ in_array($record->suplemen_o2, $suplemenMatches['Ya']) ? 'cell-yellow' : '' }}">
                                {{ in_array($record->suplemen_o2, $suplemenMatches['Ya']) ? 'Ya' : '' }}
                            </td>
                        @endforeach
                    </tr>

                    <!-- Tekanan Darah Sistolik -->
                    <tr>
                        <td rowspan="5" class="parameter-col">Tekanan Darah Sistolik (mmHg)</td>
                        <td>> 160</td>
                        <td>3</td>
                        @foreach ($sortedRecords as $record)
                            <td
                                class="{{ in_array($record->tekanan_darah, $tekananDarahMatches['> 160']) ? 'cell-red' : '' }}">
                                {{ in_array($record->tekanan_darah, $tekananDarahMatches['> 160']) ? '> 160' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>151-160</td>
                        <td>2</td>
                        @foreach ($sortedRecords as $record)
                            <td
                                class="{{ in_array($record->tekanan_darah, $tekananDarahMatches['151-160']) ? 'cell-yellow' : '' }}">
                                {{ in_array($record->tekanan_darah, $tekananDarahMatches['151-160']) ? '151-160' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>141-150</td>
                        <td>1</td>
                        @foreach ($sortedRecords as $record)
                            <td
                                class="{{ in_array($record->tekanan_darah, $tekananDarahMatches['141-150']) ? 'cell-yellow' : '' }}">
                                {{ in_array($record->tekanan_darah, $tekananDarahMatches['141-150']) ? '141-150' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>91-140</td>
                        <td>0</td>
                        @foreach ($sortedRecords as $record)
                            <td
                                class="{{ in_array($record->tekanan_darah, $tekananDarahMatches['91-140']) ? 'cell-green' : '' }}">
                                {{ in_array($record->tekanan_darah, $tekananDarahMatches['91-140']) ? '91-140' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>
                            < 90</td>
                        <td>3</td>
                        @foreach ($sortedRecords as $record)
                            <td
                                class="{{ in_array($record->tekanan_darah, $tekananDarahMatches['< 90']) ? 'cell-red' : '' }}">
                                {{ in_array($record->tekanan_darah, $tekananDarahMatches['< 90']) ? '< 90' : '' }}
                            </td>
                        @endforeach
                    </tr>

                    <!-- Detak Jantung -->
                    <tr>
                        <td rowspan="6" class="parameter-col">Detak Jantung (per menit)</td>
                        <td>> 120</td>
                        <td>3</td>
                        @foreach ($sortedRecords as $record)
                            <td
                                class="{{ in_array($record->detak_jantung, $detakJantungMatches['> 120']) ? 'cell-red' : '' }}">
                                {{ in_array($record->detak_jantung, $detakJantungMatches['> 120']) ? '> 120' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>111-120</td>
                        <td>2</td>
                        @foreach ($sortedRecords as $record)
                            <td
                                class="{{ in_array($record->detak_jantung, $detakJantungMatches['111-120']) ? 'cell-yellow' : '' }}">
                                {{ in_array($record->detak_jantung, $detakJantungMatches['111-120']) ? '111-120' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>101-110</td>
                        <td>1</td>
                        @foreach ($sortedRecords as $record)
                            <td
                                class="{{ in_array($record->detak_jantung, $detakJantungMatches['101-110']) ? 'cell-yellow' : '' }}">
                                {{ in_array($record->detak_jantung, $detakJantungMatches['101-110']) ? '101-110' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>61-100</td>
                        <td>0</td>
                        @foreach ($sortedRecords as $record)
                            <td
                                class="{{ in_array($record->detak_jantung, $detakJantungMatches['61-100']) ? 'cell-green' : '' }}">
                                {{ in_array($record->detak_jantung, $detakJantungMatches['61-100']) ? '61-100' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>50-60</td>
                        <td>2</td>
                        @foreach ($sortedRecords as $record)
                            <td
                                class="{{ in_array($record->detak_jantung, $detakJantungMatches['50-60']) ? 'cell-yellow' : '' }}">
                                {{ in_array($record->detak_jantung, $detakJantungMatches['50-60']) ? '50-60' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>≤ 50</td>
                        <td>3</td>
                        @foreach ($sortedRecords as $record)
                            <td
                                class="{{ in_array($record->detak_jantung, $detakJantungMatches['≤ 50']) ? 'cell-red' : '' }}">
                                {{ in_array($record->detak_jantung, $detakJantungMatches['≤ 50']) ? '≤ 50' : '' }}
                            </td>
                        @endforeach
                    </tr>

                    <!-- Kesadaran -->
                    <tr>
                        <td rowspan="3" class="parameter-col">Kesadaran</td>
                        <td>Sadar</td>
                        <td>0</td>
                        @foreach ($sortedRecords as $record)
                            <td
                                class="{{ in_array($record->kesadaran, $kesadaranMatches['Sadar']) ? 'cell-green' : '' }}">
                                {{ in_array($record->kesadaran, $kesadaranMatches['Sadar']) ? 'Sadar' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>Nyeri/Verbal</td>
                        <td>2</td>
                        @foreach ($sortedRecords as $record)
                            <td
                                class="{{ in_array($record->kesadaran, $kesadaranMatches['Nyeri/Verbal']) ? 'cell-yellow' : '' }}">
                                {{ in_array($record->kesadaran, $kesadaranMatches['Nyeri/Verbal']) ? 'Nyeri/Verbal' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>Unresponsive</td>
                        <td>Code Blue</td>
                        @foreach ($sortedRecords as $record)
                            <td
                                class="{{ in_array($record->kesadaran, $kesadaranMatches['Unresponsive']) ? 'cell-dark' : '' }}">
                                {{ in_array($record->kesadaran, $kesadaranMatches['Unresponsive']) ? 'Unresponsive' : '' }}
                            </td>
                        @endforeach
                    </tr>

                    <!-- Temperatur -->
                    <tr>
                        <td rowspan="4" class="parameter-col">Temperatur (°C)</td>
                        <td>≤ 36</td>
                        <td>2</td>
                        @foreach ($sortedRecords as $record)
                            <td
                                class="{{ in_array($record->temperatur, $temperaturMatches['≤ 36']) ? 'cell-yellow' : '' }}">
                                {{ in_array($record->temperatur, $temperaturMatches['≤ 36']) ? '≤ 36' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>36.1-37.2</td>
                        <td>0</td>
                        @foreach ($sortedRecords as $record)
                            <td
                                class="{{ in_array($record->temperatur, $temperaturMatches['36.1-37.2']) ? 'cell-green' : '' }}">
                                {{ in_array($record->temperatur, $temperaturMatches['36.1-37.2']) ? '36.1-37.2' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>37.3-37.7</td>
                        <td>1</td>
                        @foreach ($sortedRecords as $record)
                            <td
                                class="{{ in_array($record->temperatur, $temperaturMatches['37.3-37.7']) ? 'cell-yellow' : '' }}">
                                {{ in_array($record->temperatur, $temperaturMatches['37.3-37.7']) ? '37.3-37.7' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>> 37.7</td>
                        <td>2</td>
                        @foreach ($sortedRecords as $record)
                            <td
                                class="{{ in_array($record->temperatur, $temperaturMatches['> 37.7']) ? 'cell-yellow' : '' }}">
                                {{ in_array($record->temperatur, $temperaturMatches['> 37.7']) ? '> 37.7' : '' }}
                            </td>
                        @endforeach
                    </tr>

                    <!-- Discharge/Lochia -->
                    <tr>
                        <td rowspan="2" class="parameter-col">Discharge/Lochia</td>
                        <td>Normal</td>
                        <td>0</td>
                        @foreach ($sortedRecords as $record)
                            <td
                                class="{{ in_array($record->discharge, $dischargeMatches['Normal']) ? 'cell-green' : '' }}">
                                {{ in_array($record->discharge, $dischargeMatches['Normal']) ? 'Normal' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>Abnormal</td>
                        <td>2</td>
                        @foreach ($sortedRecords as $record)
                            <td
                                class="{{ in_array($record->discharge, $dischargeMatches['Abnormal']) ? 'cell-yellow' : '' }}">
                                {{ in_array($record->discharge, $dischargeMatches['Abnormal']) ? 'Abnormal' : '' }}
                            </td>
                        @endforeach
                    </tr>

                    <!-- Proteinuria -->
                    <tr>
                        <td rowspan="2" class="parameter-col">Proteinuria/hari</td>
                        <td>Negatif</td>
                        <td>0</td>
                        @foreach ($sortedRecords as $record)
                            <td
                                class="{{ in_array($record->proteinuria, $proteinuriaMatches['Negatif']) ? 'cell-green' : '' }}">
                                {{ in_array($record->proteinuria, $proteinuriaMatches['Negatif']) ? 'Negatif' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>≥ 1</td>
                        <td>1</td>
                        @foreach ($sortedRecords as $record)
                            <td
                                class="{{ in_array($record->proteinuria, $proteinuriaMatches['≥ 1']) ? 'cell-yellow' : '' }}">
                                {{ in_array($record->proteinuria, $proteinuriaMatches['≥ 1']) ? '≥ 1' : '' }}
                            </td>
                        @endforeach
                    </tr>

                    <!-- Total Skor -->
                    <tr>
                        <td colspan="2" style="text-align: center; font-weight: bold;">TOTAL SKOR</td>
                        <td></td>
                        @foreach ($sortedRecords as $record)
                            @php
                                $riskClass = '';
                                if (in_array($record->kesadaran, $kesadaranMatches['Unresponsive'])) {
                                    $riskClass = 'cell-dark';
                                } elseif ($record->total_skor >= 7) {
                                    $riskClass = 'cell-red';
                                } elseif (
                                    $record->total_skor >= 5 ||
                                    in_array($record->kesadaran, $kesadaranMatches['Nyeri/Verbal'])
                                ) {
                                    $riskClass = 'cell-yellow';
                                } else {
                                    $riskClass = 'cell-green';
                                }
                            @endphp
                            <td style="font-weight: bold;" class="{{ $riskClass }}">
                                {{ $record->total_skor ?? '-' }}</td>
                        @endforeach
                    </tr>

                    <!-- Level Risiko -->
                    <tr>
                        <td colspan="2" style="text-align: center; font-weight: bold;">LEVEL RISIKO</td>
                        <td></td>
                        @foreach ($sortedRecords as $record)
                            @php
                                $riskText = '';
                                $riskClass = '';
                                if (
                                    in_array($record->hasil_ews, [
                                        'HENTI NAFAS/JANTUNG',
                                        'CODE BLUE - HENTI NAFAS/JANTUNG',
                                    ]) ||
                                    in_array($record->kesadaran, $kesadaranMatches['Unresponsive'])
                                ) {
                                    $riskText = 'CODE BLUE';
                                    $riskClass = 'cell-dark';
                                } elseif ($record->hasil_ews == 'RISIKO TINGGI' || $record->total_skor >= 7) {
                                    $riskText = 'TINGGI';
                                    $riskClass = 'cell-red';
                                } elseif (
                                    $record->hasil_ews == 'RISIKO SEDANG' ||
                                    $record->total_skor >= 5 ||
                                    in_array($record->kesadaran, $kesadaranMatches['Nyeri/Verbal'])
                                ) {
                                    $riskText = 'SEDANG';
                                    $riskClass = 'cell-yellow';
                                } elseif (
                                    $record->hasil_ews == 'RISIKO RENDAH' ||
                                    ($record->total_skor > 0 && $record->total_skor <= 4)
                                ) {
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
                    $resultText =
                        'Henti Nafas/Jantung: CODE BLUE<br>Lakukan RJP oleh petugas/tim primer, aktivasi code blue henti jantung, respon Tim Medis Emergency (TME)/tim Code Blue segera (maksimal 5 menit), informasikan dan konsultasikan dengan DPJP.';
                    $resultClass = 'hasil-code-blue';
                } elseif ($latestRecord->total_skor >= 7) {
                    $resultText =
                        'Total Skor ≥ 7: RISIKO TINGGI<br>Resusitasi dan monitoring secara kontinyu oleh dokter jaga dan perawat senior, aktivasi code blue kegawatan medis, respon Tim Medis Emergency (TME)/tim Code Blue segera (maksimal 10 menit), Informasikan dan konsultasikan ke DPJP.';
                    $resultClass = 'hasil-high';
                } elseif (
                    $latestRecord->total_skor >= 5 ||
                    in_array($latestRecord->kesadaran, $kesadaranMatches['Nyeri/Verbal'])
                ) {
                    $resultText =
                        'Total Skor 5-6: RISIKO SEDANG<br>Assessment segera oleh dokter jaga (respon segera, maks 5 menit), konsultasi DPJP dan spesialis terkait, eksalasi perawatan dan monitoring tiap jam, pertimbangkan perawatan dengan monitoring yang sesuai (HCU).';
                    $resultClass = 'hasil-medium';
                } elseif ($latestRecord->total_skor >= 1 && $latestRecord->total_skor <= 4) {
                    $resultText =
                        'Total Skor 1-4: RISIKO RENDAH<br>Assessment segera oleh perawat senior, respon segera, maks 5 menit, eskalasi perawatan dan frekuensi monitoring per 4-6 jam, Jika diperlukan assessment oleh dokter jaga bangsal.';
                    $resultClass = 'hasil-low';
                } else {
                    $resultText =
                        'Total Skor 0: TIDAK ADA RISIKO<br>Lanjutkan observasi/monitoring secara rutin/per shift.';
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
            <p style="font-size: 12px">Nama dan Paraf:</p>
            <p style="margin-top: 40px; font-size: 12px;">
                {{ str()->title($ewsPsienObstetrik->userCreate->name ?? '-') }}</p>
            <p class="small-text" style="font-size: 12px">Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}
            </p>
            @if (isset($ewsPsienObstetrik) && $ewsPsienObstetrik->userCreate && $ewsPsienObstetrik->userCreate->jabatan)
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
                            Assessment segera oleh perawat senior, respon segera, maks 5 menit, eskalasi perawatan dan
                            frekuensi monitoring per 4-6 jam, Jika diperlukan assessment oleh dokter jaga bangsal.
                        </td>
                    </tr>
                    <tr>
                        <td class="protocol-skor-5-6">
                            Skor 5-6
                        </td>
                        <td>
                            Assessment segera oleh dokter jaga (respon segera, maks 5 menit), konsultasi DPJP dan
                            spesialis terkait, eksalasi perawatan dan monitoring tiap jam, pertimbangkan perawatan
                            dengan monitoring yang sesuai (HCU).
                        </td>
                    </tr>
                    <tr>
                        <td class="protocol-skor-7-plus">
                            Skor 7 atau Lebih atau Parameter Code Blue (Risiko Tinggi)
                        </td>
                        <td>
                            Resusitasi dan monitoring secara kontinyu oleh dokter jaga dan perawat senior, Aktivasi code
                            blue kegawatan medis, respon Tim Medis Emergency (TME)/tim Code Blue segera, maksimal 10
                            menit), Informasikan dan konsultasikan ke DPJP.
                        </td>
                    </tr>
                    <tr>
                        <td class="protocol-code-blue">
                            HENTI NAFAS/JANTUNG
                        </td>
                        <td>
                            Lakukan RJP oleh petugas/tim primer, aktivasi code blue henti jantung, respon Tim Medis
                            Emergency (TME) /tim Code Blue segera, maksimal 5 menit, informasikan dan konsultasikan
                            dengan DPJP.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
