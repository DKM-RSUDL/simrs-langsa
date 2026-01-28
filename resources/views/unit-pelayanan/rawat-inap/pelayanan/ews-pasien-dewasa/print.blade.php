<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Early Warning System (EWS) Pasien Dewasa</title>
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
                                    <img src="{{ $logoBase64 }}" style="width:70px; height:auto;">
                                @endif
                            </td>
                            <td class="va-middle">
                                <p class="brand-name">RSUD Langsa</p>
                                <p class="brand-info">Jl. Jend. A. Yani No.1 Kota Langsa</p>
                                <p class="brand-info">Telp: 0641-22051</p>
                                <p class="brand-info">Email: rsudlangsa.aceh@gmail.com</p>
                            </td>
                        </tr>
                    </table>
                </td>

                <td class="td-center">
                    <span class="title-main">EARLY WARNING SYSTEM (EWS)</span>
                    <span class="title-sub">PASIEN DEWASA</span>
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
            // Pastikan ewsRecords diurutkan berdasarkan tanggal dan jam
            $sortedRecords = $ewsRecords->sortBy(function ($record) {
                return Carbon\Carbon::parse($record->tanggal)->format('Y-m-d') .
                    ' ' .
                    Carbon\Carbon::parse($record->jam_masuk)->format('H:i:s');
            });
        @endphp

        @if ($sortedRecords->isEmpty())
            <p style="text-align: center; font-size: 8pt;">Tidak ada data EWS yang tersedia.</p>
        @else
            <table class="ews-table">
                <thead>
                    <tr>
                        <th rowspan="3" class="parameter-col">PARAMETER</th>
                        <th colspan="2" rowspan="2">Tanggal & Jam</th>
                        @foreach ($sortedRecords as $record)
                            <th>{{ \Carbon\Carbon::parse($record->tanggal)->format('d/m/Y') }}</th>
                        @endforeach
                    </tr>
                    <tr>
                        @foreach ($sortedRecords as $record)
                            <th>{{ \Carbon\Carbon::parse($record->jam_masuk)->format('H:i') }}</th>
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
                    <!-- AVPU -->
                    <tr>
                        <td rowspan="2" class="parameter-col">Kesadaran (AVPU)</td>
                        <td>A*</td>
                        <td>0</td>
                        @foreach ($sortedRecords as $record)
                            <td class="{{ $record->avpu == 'A' ? 'cell-green' : '' }}">
                                {{ $record->avpu == 'A' ? 'A' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>V,P,U*</td>
                        <td>3</td>
                        @foreach ($sortedRecords as $record)
                            <td class="{{ in_array($record->avpu, ['V', 'P', 'U']) ? 'cell-red' : '' }}">
                                {{ in_array($record->avpu, ['V', 'P', 'U']) ? $record->avpu : '' }}
                            </td>
                        @endforeach
                    </tr>

                    <!-- Saturasi O2 -->
                    <tr>
                        <td rowspan="4" class="parameter-col">Saturasi O2 (%)</td>
                        <td>≥ 95</td>
                        <td>0</td>
                        @foreach ($sortedRecords as $record)
                            <td class="{{ compareEwsValue($record->saturasi_o2, '≥ 95') ? 'cell-green' : '' }}">
                                {{ compareEwsValue($record->saturasi_o2, '≥ 95') ? '≥ 95' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>94-95</td>
                        <td>1</td>
                        @foreach ($sortedRecords as $record)
                            <td class="{{ $record->saturasi_o2 == '94-95' ? 'cell-yellow' : '' }}">
                                {{ $record->saturasi_o2 == '94-95' ? '94-95' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>92-93</td>
                        <td>2</td>
                        @foreach ($sortedRecords as $record)
                            <td class="{{ $record->saturasi_o2 == '92-93' ? 'cell-yellow' : '' }}">
                                {{ $record->saturasi_o2 == '92-93' ? '92-93' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>≤ 91</td>
                        <td>3</td>
                        @foreach ($sortedRecords as $record)
                            <td class="{{ compareEwsValue($record->saturasi_o2, '≤ 91') ? 'cell-red' : '' }}">
                                {{ compareEwsValue($record->saturasi_o2, '≤ 91') ? '≤ 91' : '' }}
                            </td>
                        @endforeach
                    </tr>

                    <!-- Dengan Bantuan O2 -->
                    <tr>
                        <td rowspan="2" class="parameter-col">Dengan Bantuan O2</td>
                        <td>Tidak</td>
                        <td>0</td>
                        @foreach ($sortedRecords as $record)
                            <td class="{{ $record->dengan_bantuan == 'Tidak' ? 'cell-green' : '' }}">
                                {{ $record->dengan_bantuan == 'Tidak' ? 'Tidak' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>Ya</td>
                        <td>2</td>
                        @foreach ($sortedRecords as $record)
                            <td class="{{ $record->dengan_bantuan == 'Ya' ? 'cell-yellow' : '' }}">
                                {{ $record->dengan_bantuan == 'Ya' ? 'Ya' : '' }}
                            </td>
                        @endforeach
                    </tr>

                    <!-- Tekanan Darah Sistolik -->
                    <tr>
                        <td rowspan="5" class="parameter-col">Tekanan Darah Sistolik (mmHg)</td>
                        <td>≥ 220</td>
                        <td>3</td>
                        @foreach ($sortedRecords as $record)
                            <td class="{{ compareEwsValue($record->tekanan_darah, '≥ 220') ? 'cell-red' : '' }}">
                                {{ compareEwsValue($record->tekanan_darah, '≥ 220') ? '≥ 220' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>111-219</td>
                        <td>0</td>
                        @foreach ($sortedRecords as $record)
                            <td class="{{ $record->tekanan_darah == '111-219' ? 'cell-green' : '' }}">
                                {{ $record->tekanan_darah == '111-219' ? '111-219' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>101-110</td>
                        <td>1</td>
                        @foreach ($sortedRecords as $record)
                            <td class="{{ $record->tekanan_darah == '101-110' ? 'cell-yellow' : '' }}">
                                {{ $record->tekanan_darah == '101-110' ? '101-110' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>91-100</td>
                        <td>2</td>
                        @foreach ($sortedRecords as $record)
                            <td class="{{ $record->tekanan_darah == '91-100' ? 'cell-yellow' : '' }}">
                                {{ $record->tekanan_darah == '91-100' ? '91-100' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>≤ 90</td>
                        <td>3</td>
                        @foreach ($sortedRecords as $record)
                            <td class="{{ compareEwsValue($record->tekanan_darah, '≤ 90') ? 'cell-red' : '' }}">
                                {{ compareEwsValue($record->tekanan_darah, '≤ 90') ? '≤ 90' : '' }}
                            </td>
                        @endforeach
                    </tr>

                    <!-- Nadi -->
                    <tr>
                        <td rowspan="6" class="parameter-col">Nadi (per menit)</td>
                        <td>≥ 131</td>
                        <td>3</td>
                        @foreach ($sortedRecords as $record)
                            <td class="{{ compareEwsValue($record->nadi, '≥ 131') ? 'cell-red' : '' }}">
                                {{ compareEwsValue($record->nadi, '≥ 131') ? '≥ 131' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>111-130</td>
                        <td>2</td>
                        @foreach ($sortedRecords as $record)
                            <td class="{{ $record->nadi == '111-130' ? 'cell-yellow' : '' }}">
                                {{ $record->nadi == '111-130' ? '111-130' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>91-110</td>
                        <td>1</td>
                        @foreach ($sortedRecords as $record)
                            <td class="{{ $record->nadi == '91-110' ? 'cell-yellow' : '' }}">
                                {{ $record->nadi == '91-110' ? '91-110' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>51-90</td>
                        <td>0</td>
                        @foreach ($sortedRecords as $record)
                            <td class="{{ $record->nadi == '51-90' ? 'cell-green' : '' }}">
                                {{ $record->nadi == '51-90' ? '51-90' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>41-50</td>
                        <td>1</td>
                        @foreach ($sortedRecords as $record)
                            <td class="{{ $record->nadi == '41-50' ? 'cell-yellow' : '' }}">
                                {{ $record->nadi == '41-50' ? '41-50' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>≤ 40</td>
                        <td>3</td>
                        @foreach ($sortedRecords as $record)
                            <td class="{{ compareEwsValue($record->nadi, '≤ 40') ? 'cell-red' : '' }}">
                                {{ compareEwsValue($record->nadi, '≤ 40') ? '≤ 40' : '' }}
                            </td>
                        @endforeach
                    </tr>

                    <!-- Nafas -->
                    <tr>
                        <td rowspan="5" class="parameter-col">Nafas (per menit)</td>
                        <td>≥ 25</td>
                        <td>3</td>
                        @foreach ($sortedRecords as $record)
                            <td class="{{ compareEwsValue($record->nafas, '≥ 25') ? 'cell-red' : '' }}">
                                {{ compareEwsValue($record->nafas, '≥ 25') ? '≥ 25' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>21-24</td>
                        <td>2</td>
                        @foreach ($sortedRecords as $record)
                            <td class="{{ $record->nafas == '21-24' ? 'cell-yellow' : '' }}">
                                {{ $record->nafas == '21-24' ? '21-24' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>12-20</td>
                        <td>0</td>
                        @foreach ($sortedRecords as $record)
                            <td class="{{ $record->nafas == '12-20' ? 'cell-green' : '' }}">
                                {{ $record->nafas == '12-20' ? '12-20' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>9-11</td>
                        <td>1</td>
                        @foreach ($sortedRecords as $record)
                            <td class="{{ $record->nafas == '9-11' ? 'cell-yellow' : '' }}">
                                {{ $record->nafas == '9-11' ? '9-11' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>≤ 8</td>
                        <td>3</td>
                        @foreach ($sortedRecords as $record)
                            <td class="{{ compareEwsValue($record->nafas, '≤ 8') ? 'cell-red' : '' }}">
                                {{ compareEwsValue($record->nafas, '≤ 8') ? '≤ 8' : '' }}
                            </td>
                        @endforeach
                    </tr>

                    <!-- Temperatur -->
                    <tr>
                        <td rowspan="5" class="parameter-col">Temperatur (°C)</td>
                        <td>≥ 39.1</td>
                        <td>2</td>
                        @foreach ($sortedRecords as $record)
                            <td class="{{ compareEwsValue($record->temperatur, '≥ 39.1') ? 'cell-yellow' : '' }}">
                                {{ compareEwsValue($record->temperatur, '≥ 39.1') ? '≥ 39.1' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>38.1-39.0</td>
                        <td>1</td>
                        @foreach ($sortedRecords as $record)
                            <td class="{{ $record->temperatur == '38.1-39.0' ? 'cell-yellow' : '' }}">
                                {{ $record->temperatur == '38.1-39.0' ? '38.1-39.0' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>36.1-38.0</td>
                        <td>0</td>
                        @foreach ($sortedRecords as $record)
                            <td class="{{ $record->temperatur == '36.1-38.0' ? 'cell-green' : '' }}">
                                {{ $record->temperatur == '36.1-38.0' ? '36.1-38.0' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>35.1-36.0</td>
                        <td>1</td>
                        @foreach ($sortedRecords as $record)
                            <td class="{{ $record->temperatur == '35.1-36.0' ? 'cell-yellow' : '' }}">
                                {{ $record->temperatur == '35.1-36.0' ? '35.1-36.0' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>≤ 35</td>
                        <td>3</td>
                        @foreach ($sortedRecords as $record)
                            <td class="{{ compareEwsValue($record->temperatur, '≤ 35') ? 'cell-red' : '' }}">
                                {{ compareEwsValue($record->temperatur, '≤ 35') ? '≤ 35' : '' }}
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
                                if ($record->total_skor >= 7) {
                                    $riskClass = 'cell-red';
                                } elseif (
                                    $record->total_skor >= 5 ||
                                    (in_array($record->avpu, ['V', 'P', 'U']) && $record->avpu != null) ||
                                    compareEwsValue($record->saturasi_o2, '≤ 91') ||
                                    compareEwsValue($record->tekanan_darah, '≤ 90') ||
                                    compareEwsValue($record->tekanan_darah, '≥ 220') ||
                                    compareEwsValue($record->nadi, '≤ 40') ||
                                    compareEwsValue($record->nadi, '≥ 131') ||
                                    compareEwsValue($record->nafas, '≤ 8') ||
                                    compareEwsValue($record->nafas, '≥ 25')
                                ) {
                                    $riskClass = 'cell-yellow';
                                } elseif ($record->total_skor <= 4) {
                                    $riskClass = 'cell-green';
                                }
                            @endphp
                            <td style="font-weight: bold;" class="{{ $riskClass }}">
                                {{ $record->total_skor ?? '-' }}</td>
                        @endforeach
                    </tr>

                    <!-- Risk Level -->
                    <tr>
                        <td colspan="2" style="text-align: center; font-weight: bold;">LEVEL RISIKO</td>
                        <td></td>
                        @foreach ($sortedRecords as $record)
                            @php
                                $riskText = '';
                                $riskClass = '';

                                if ($record->hasil_ews == 'RISIKO TINGGI' || $record->total_skor >= 7) {
                                    $riskText = 'TINGGI';
                                    $riskClass = 'cell-red';
                                } elseif (
                                    $record->hasil_ews == 'RISIKO SEDANG' ||
                                    $record->total_skor >= 5 ||
                                    (in_array($record->avpu, ['V', 'P', 'U']) && $record->avpu != null) ||
                                    compareEwsValue($record->saturasi_o2, '≤ 91') ||
                                    compareEwsValue($record->tekanan_darah, '≤ 90') ||
                                    compareEwsValue($record->tekanan_darah, '≥ 220') ||
                                    compareEwsValue($record->nadi, '≤ 40') ||
                                    compareEwsValue($record->nadi, '≥ 131') ||
                                    compareEwsValue($record->nafas, '≤ 8') ||
                                    compareEwsValue($record->nafas, '≥ 25')
                                ) {
                                    $riskText = 'SEDANG';
                                    $riskClass = 'cell-yellow';
                                } elseif ($record->hasil_ews == 'RISIKO RENDAH' || $record->total_skor <= 4) {
                                    $riskText = 'RENDAH';
                                    $riskClass = 'cell-green';
                                }
                            @endphp
                            <td style="font-weight: bold;" class="{{ $riskClass }}">{{ $riskText }}
                            </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        @endif

        <div class="hasil-ews">HASIL EARLY WARNING SCORING:</div>
        <table class="hasil-ews-table">
            <tr>
                @php
                    // Tentukan risiko berdasarkan data pasien terakhir
                    $latestRecord = $sortedRecords->last();
                    $riskLevel = '';
                    $riskClass = '';
                    $riskText = '';

                    if ($latestRecord) {
                        if ($latestRecord->total_skor >= 7) {
                            $riskLevel = 'TINGGI';
                            $riskClass = 'hasil-high';
                            $riskText = 'Total Skor ≥ 7: RISIKO TINGGI';
                        } elseif (
                            $latestRecord->total_skor >= 5 ||
                            (in_array($latestRecord->avpu, ['V', 'P', 'U']) && $latestRecord->avpu != null) ||
                            compareEwsValue($latestRecord->saturasi_o2, '≤ 91') ||
                            compareEwsValue($latestRecord->tekanan_darah, '≤ 90') ||
                            compareEwsValue($latestRecord->tekanan_darah, '≥ 220') ||
                            compareEwsValue($latestRecord->nadi, '≤ 40') ||
                            compareEwsValue($latestRecord->nadi, '≥ 131') ||
                            compareEwsValue($latestRecord->nafas, '≤ 8') ||
                            compareEwsValue($latestRecord->nafas, '≥ 25')
                        ) {
                            $riskLevel = 'SEDANG';
                            $riskClass = 'hasil-medium';
                            $riskText = 'Skor 3 dalam satu parameter atau Total Skor 5-6: RISIKO SEDANG';
                        } else {
                            $riskLevel = 'RENDAH';
                            $riskClass = 'hasil-low';
                            $riskText = 'Total Skor 0-4: RISIKO RENDAH';
                        }
                    }
                @endphp
                <td class="{{ $riskClass }}">{{ $riskText }}</td>
            </tr>
        </table>

        <div class="footer">
            <p style="font-size: 12px">Nama dan Paraf:</p>
            <p style="margin-top: 40px; font-size: 12px;">
                {{ str()->title($ewsPasienDewasa->userCreate->name ?? '-') }}</p>
            <p class="small-text" style="font-size: 12px">Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}
            </p>
            @if (isset($ewsPasienDewasa) && $ewsPasienDewasa->userCreate && $ewsPasienDewasa->userCreate->jabatan)
                <p>{{ $ewsPasienDewasa->userCreate->jabatan }}</p>
            @endif
        </div>
    </div>

    <div class="page-break"></div>

    <!-- Halaman Kedua: Intervensi dan Keterangan -->
    <div class="intervention-page">
        <div class="intervention-title">INTERVENSI PENILAIAN EARLY WARNING SYSTEM</div>

        <!-- Risk Assessment Table -->
        <table class="risk-table">
            <tr class="risk-low">
                <td>Total Skor 0-4</td>
                <td>RISIKO RENDAH</td>
            </tr>
            <tr class="risk-medium">
                <td>Skor 3 dalam satu parameter atau Total Skor : 5 - 6</td>
                <td>RISIKO SEDANG</td>
            </tr>
            <tr class="risk-high">
                <td>Total Skor ≥ 7</td>
                <td>RISIKO TINGGI</td>
            </tr>
        </table>

        <!-- AVPU Explanation -->
        <div class="avpu-explanation">
            <p><strong>Keterangan Tingkat kesadaran AVPU :</strong></p>
            <p><strong>A : ALERT</strong> &nbsp;&nbsp;&nbsp; Pasien sadar penuh</p>
            <p><strong>V : VOICE</strong> &nbsp;&nbsp;&nbsp; Pasien membuat beberapa jenis respon saat
                dipanggil
                berbicara, terdiri dari 3 komponen yang mempengaruhi yaitu mata, suara atau motorik</p>
            <p><strong>P : PAIN</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pasien akan berespon jika dirangsang
                sakit</p>
            <p><strong>U : UNRESPONSIVE</strong> &nbsp;&nbsp;&nbsp; Tidak berespon, jika pasien tidak
                memberikan respon
                terhadap suara, nyeri dsb</p>
        </div>

        <!-- Intervention Table -->
        <table class="intervention-table">
            <thead>
                <tr>
                    <th style="width: 5%;">NO</th>
                    <th style="width: 15%;">NILAI EWS</th>
                    <th style="width: 20%;">FREKUENSI MONITORING</th>
                    <th style="width: 60%;">ASUHAN YANG DIBERIKAN</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: center;">1</td>
                    <td style="text-align: center;">0</td>
                    <td style="text-align: center;">Minimal setiap 12 jam sekali</td>
                    <td>Lanjutkan observasi/ monitoring secara rutin/per shift</td>
                </tr>
                <tr>
                    <td style="text-align: center;">2</td>
                    <td style="text-align: center;">TOTAL SCORE<br>1 - 4</td>
                    <td style="text-align: center;">Minimal Setiap<br>4 - 6 Jam Sekali</td>
                    <td>
                        <strong>1.</strong> Perawat pelaksana menginformasikan kepada ketua tim / penanggung
                        jawab jaga
                        ruangan tentang siapa yang melaksanakan assesment selanjutnya.<br>
                        <strong>2.</strong> Ketua Tim / penanggunggjawab harus membuat keputusan:<br>
                        &nbsp;&nbsp;&nbsp; a. Meningkatkan frekuensi observasi / monitoring<br>
                        &nbsp;&nbsp;&nbsp; b. Perawatan asuhan yang dibutuhkan oleh pasien
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">3</td>
                    <td style="text-align: center;">TOTAL SCORE<br>5 DAN 6 ATAU 3<br>DALAM 1
                        (SATU)<br>PARAMETER</td>
                    <td style="text-align: center;">Peningkatan<br>Frekuensi Observasi /
                        Monitoring<br>Setidaknya
                        Setiap<br>1 Jam Sekali</td>
                    <td>
                        <strong>1.</strong> Ketua Tim (Perawat) segera memberikan informasi tentang kondisi
                        pasien
                        kepada dokter jaga atau DPJP<br>
                        <strong>2.</strong> Dokter jaga atau DPJP melakukan assesment sesuai kompetensinya
                        dan
                        menentukan kondisi pasien apakah dalam penyakit akut,<br>
                        <strong>3.</strong> Siapkan fasilitas monitoring yang lebih canggih.
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">4</td>
                    <td style="text-align: center;">TOTAL SCORE 7<br>ATAU LEBIH</td>
                    <td style="text-align: center;">Lanjutkan Observasi / Monitoring<br>Tanda-Tanda Vital
                    </td>
                    <td>
                        <strong>1.</strong> Ketua Tim (Perawat) segera memberikan informasi tentang kondisi
                        pasien
                        kepada dokter jaga atau DPJP<br>
                        <strong>2.</strong> Rencanakan transfer pasien ke ruang intensive<br>
                        <strong>3.</strong> Aktivasi code blue bila pasien henti jantung/henti nafas
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</html>
