<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Early Warning System (EWS) Pasien Dewasa</title>
    <style>
        @page {
            margin: 0.5cm;
            size: A4 portrait;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 8pt;
            line-height: 1.2;
        }

        .container {
            width: 100%;
            position: relative;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 5px;
        }

        .logo-rs {
            display: flex;
            align-items: center;
        }

        .logo {
            width: 50px;
            height: 50px;
            margin-right: 8px;
        }

        .hospital-info {
            font-size: 9pt;
        }

        .hospital-name {
            font-size: 12pt;
            font-weight: bold;
            margin: 0;
        }

        .hospital-address {
            margin: 2px 0;
        }

        .patient-info {
            border: 1px solid #000;
            padding: 5px;
            width: 250px;
            font-size: 9pt;
            position: absolute;
            top: 0;
            right: 0;
        }

        .patient-row {
            display: flex;
            margin-bottom: 4px;
        }

        .patient-label {
            width: 80px;
            font-weight: normal;
        }

        .patient-value {
            flex: 1;
        }

        .border-line {
            border-bottom: 2px solid black;
            margin: 5px 0;
        }

        .title {
            text-align: center;
            font-size: 12pt;
            font-weight: bold;
            margin: 10px 0;
        }

        table.ews-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 6pt;
        }

        table.ews-table th,
        table.ews-table td {
            border: 1px solid #000;
            padding: 2px;
            text-align: center;
            height: 14px;
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

        .footer {
            margin-top: 10px;
            font-size: 6pt;
            text-align: right;
        }

        .small-text {
            font-size: 5pt;
        }

        /* Tambahan styles untuk highlight status risiko pasien */
        .risk-status {
            padding: 3px 6px;
            border-radius: 3px;
            font-weight: bold;
            display: inline-block;
            margin-top: 5px;
        }

        .risk-low {
            background-color: #90EE90;
        }

        .risk-medium {
            background-color: #FFFF00;
        }

        .risk-high {
            background-color: #FF6347;
        }
    </style>
</head>

<body>
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
                    <span
                        class="patient-value">{{ $dataMedis->pasien->jenis_kelamin == 1 ? 'Laki-laki' : ($dataMedis->pasien->jenis_kelamin == 0 ? 'Perempuan' : '-') }}</span>
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
            EARLY WARNING SYSTEM (EWS)<br>PASIEN DEWASA
        </div>

        @php
            // Helper function untuk standardize comparison
            function compareEwsValue($recordValue, $targetValue)
            {
                // Standardize comparison for multiple formats
                $equivalentValues = [
                    '≥ 95' => ['≥ 95', '>= 95', '= 95', '>=95', '≥95'],
                    '≥ 220' => ['≥ 220', '>= 220', '= 220', '>=220', '≥220'],
                    '≥ 131' => ['≥ 131', '>= 131', '= 131', '>=131', '≥131'],
                    '≥ 25' => ['≥ 25', '>= 25', '= 25', '>=25', '≥25'],
                    '≥ 39.1' => ['≥ 39.1', '>= 39.1', '= 39.1', '>=39.1', '≥39.1'],
                    '≤ 91' => ['≤ 91', '<= 91', '= 91', '<=91', '≤91'],
                    '≤ 90' => ['≤ 90', '<= 90', '= 90', '<=90', '≤90'],
                    '≤ 40' => ['≤ 40', '<= 40', '= 40', '<=40', '≤40'],
                    '≤ 8' => ['≤ 8', '<= 8', '= 8', '<=8', '≤8'],
                    '≤ 35' => ['≤ 35', '<= 35', '= 35', '<=35', '≤35'],
                ];

                foreach ($equivalentValues as $standard => $variations) {
                    if (in_array($targetValue, $variations) && in_array($recordValue, $variations)) {
                        return true;
                    }
                }

                return $recordValue == $targetValue;
            }

            // Pastikan ewsRecords diurutkan berdasarkan tanggal dan jam
            $sortedRecords = $ewsRecords->sortBy(function ($record) {
                return Carbon\Carbon::parse($record->tanggal)->format('Y-m-d') . ' ' .
                    Carbon\Carbon::parse($record->jam_masuk)->format('H:i:s');
            });
        @endphp

        @if($sortedRecords->isEmpty())
            <p style="text-align: center; font-size: 8pt;">Tidak ada data EWS yang tersedia.</p>
        @else
            <table class="ews-table">
                <thead>
                    <tr>
                        <th rowspan="3" class="parameter-col">PARAMETER</th>
                        <th colspan="2" rowspan="2">Tanggal & Jam</th>
                        @foreach($sortedRecords as $record)
                            <th>{{ \Carbon\Carbon::parse($record->tanggal)->format('d/m/Y') }}</th>
                        @endforeach
                    </tr>
                    <tr>
                        @foreach($sortedRecords as $record)
                            <th>{{ \Carbon\Carbon::parse($record->jam_masuk)->format('H:i') }}</th>
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
                    <!-- AVPU -->
                    <tr>
                        <td rowspan="2" class="parameter-col">Kesadaran (AVPU)</td>
                        <td>A*</td>
                        <td>0</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ $record->avpu == 'A' ? 'cell-green' : '' }}">{{ $record->avpu == 'A' ? 'A' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>V,P,U*</td>
                        <td>3</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ in_array($record->avpu, ['V', 'P', 'U']) ? 'cell-red' : '' }}">
                                {{ in_array($record->avpu, ['V', 'P', 'U']) ? $record->avpu : '' }}</td>
                        @endforeach
                    </tr>

                    <!-- Saturasi O2 -->
                    <tr>
                        <td rowspan="4" class="parameter-col">Saturasi O2 (%)</td>
                        <td>≥ 95</td>
                        <td>0</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ compareEwsValue($record->saturasi_o2, '≥ 95') ? 'cell-green' : '' }}">
                                {{ compareEwsValue($record->saturasi_o2, '≥ 95') ? '≥ 95' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>94-95</td>
                        <td>1</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ $record->saturasi_o2 == '94-95' ? 'cell-yellow' : '' }}">
                                {{ $record->saturasi_o2 == '94-95' ? '94-95' : '' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>92-93</td>
                        <td>2</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ $record->saturasi_o2 == '92-93' ? 'cell-yellow' : '' }}">
                                {{ $record->saturasi_o2 == '92-93' ? '92-93' : '' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>≤ 91</td>
                        <td>3</td>
                        @foreach($sortedRecords as $record)
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
                        @foreach($sortedRecords as $record)
                            <td class="{{ $record->dengan_bantuan == 'Tidak' ? 'cell-green' : '' }}">
                                {{ $record->dengan_bantuan == 'Tidak' ? 'Tidak' : '' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>Ya</td>
                        <td>2</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ $record->dengan_bantuan == 'Ya' ? 'cell-yellow' : '' }}">
                                {{ $record->dengan_bantuan == 'Ya' ? 'Ya' : '' }}</td>
                        @endforeach
                    </tr>

                    <!-- Tekanan Darah Sistolik -->
                    <tr>
                        <td rowspan="5" class="parameter-col">Tekanan Darah Sistolik (mmHg)</td>
                        <td>≥ 220</td>
                        <td>3</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ compareEwsValue($record->tekanan_darah, '≥ 220') ? 'cell-red' : '' }}">
                                {{ compareEwsValue($record->tekanan_darah, '≥ 220') ? '≥ 220' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>111-219</td>
                        <td>0</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ $record->tekanan_darah == '111-219' ? 'cell-green' : '' }}">
                                {{ $record->tekanan_darah == '111-219' ? '111-219' : '' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>101-110</td>
                        <td>1</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ $record->tekanan_darah == '101-110' ? 'cell-yellow' : '' }}">
                                {{ $record->tekanan_darah == '101-110' ? '101-110' : '' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>91-100</td>
                        <td>2</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ $record->tekanan_darah == '91-100' ? 'cell-yellow' : '' }}">
                                {{ $record->tekanan_darah == '91-100' ? '91-100' : '' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>≤ 90</td>
                        <td>3</td>
                        @foreach($sortedRecords as $record)
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
                        @foreach($sortedRecords as $record)
                            <td class="{{ compareEwsValue($record->nadi, '≥ 131') ? 'cell-red' : '' }}">
                                {{ compareEwsValue($record->nadi, '≥ 131') ? '≥ 131' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>111-130</td>
                        <td>2</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ $record->nadi == '111-130' ? 'cell-yellow' : '' }}">
                                {{ $record->nadi == '111-130' ? '111-130' : '' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>91-110</td>
                        <td>1</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ $record->nadi == '91-110' ? 'cell-yellow' : '' }}">
                                {{ $record->nadi == '91-110' ? '91-110' : '' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>51-90</td>
                        <td>0</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ $record->nadi == '51-90' ? 'cell-green' : '' }}">
                                {{ $record->nadi == '51-90' ? '51-90' : '' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>41-50</td>
                        <td>1</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ $record->nadi == '41-50' ? 'cell-yellow' : '' }}">
                                {{ $record->nadi == '41-50' ? '41-50' : '' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>≤ 40</td>
                        <td>3</td>
                        @foreach($sortedRecords as $record)
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
                        @foreach($sortedRecords as $record)
                            <td class="{{ compareEwsValue($record->nafas, '≥ 25') ? 'cell-red' : '' }}">
                                {{ compareEwsValue($record->nafas, '≥ 25') ? '≥ 25' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>21-24</td>
                        <td>2</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ $record->nafas == '21-24' ? 'cell-yellow' : '' }}">
                                {{ $record->nafas == '21-24' ? '21-24' : '' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>12-20</td>
                        <td>0</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ $record->nafas == '12-20' ? 'cell-green' : '' }}">
                                {{ $record->nafas == '12-20' ? '12-20' : '' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>9-11</td>
                        <td>1</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ $record->nafas == '9-11' ? 'cell-yellow' : '' }}">
                                {{ $record->nafas == '9-11' ? '9-11' : '' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>≤ 8</td>
                        <td>3</td>
                        @foreach($sortedRecords as $record)
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
                        @foreach($sortedRecords as $record)
                            <td class="{{ compareEwsValue($record->temperatur, '≥ 39.1') ? 'cell-yellow' : '' }}">
                                {{ compareEwsValue($record->temperatur, '≥ 39.1') ? '≥ 39.1' : '' }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>38.1-39.0</td>
                        <td>1</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ $record->temperatur == '38.1-39.0' ? 'cell-yellow' : '' }}">
                                {{ $record->temperatur == '38.1-39.0' ? '38.1-39.0' : '' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>36.1-38.0</td>
                        <td>0</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ $record->temperatur == '36.1-38.0' ? 'cell-green' : '' }}">
                                {{ $record->temperatur == '36.1-38.0' ? '36.1-38.0' : '' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>35.1-36.0</td>
                        <td>1</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ $record->temperatur == '35.1-36.0' ? 'cell-yellow' : '' }}">
                                {{ $record->temperatur == '35.1-36.0' ? '35.1-36.0' : '' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>≤ 35</td>
                        <td>3</td>
                        @foreach($sortedRecords as $record)
                            <td class="{{ compareEwsValue($record->temperatur, '≤ 35') ? 'cell-red' : '' }}">
                                {{ compareEwsValue($record->temperatur, '≤ 35') ? '≤ 35' : '' }}
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
                            <td style="font-weight: bold;" class="{{ $riskClass }}">{{ $record->total_skor ?? '-' }}</td>
                        @endforeach
                    </tr>

                    <!-- Risk Level -->
                    <tr>
                        <td colspan="2" style="text-align: center; font-weight: bold;">LEVEL RISIKO</td>
                        <td></td>
                        @foreach($sortedRecords as $record)
                            @php
                                $riskText = '';
                                $riskClass = '';

                                if ($record->hasil_ews == 'RISIKO TINGGI' || $record->total_skor >= 7) {
                                    $riskText = 'TINGGI';
                                    $riskClass = 'cell-red';
                                } elseif (
                                    $record->hasil_ews == 'RISIKO SEDANG' || $record->total_skor >= 5 ||
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
                            <td style="font-weight: bold;" class="{{ $riskClass }}">{{ $riskText }}</td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        @endif

        <div class="hasil-ews">HASIL EARLY WARNING SCORING:</div>
        <table class="hasil-ews-table">
            <tr>
                <td class="hasil-low">Total Skor 0-4: RISIKO RENDAH</td>
                <td class="hasil-medium">Skor 3 dalam satu parameter atau Total Skor 5-6: RISIKO SEDANG</td>
                <td class="hasil-high">Total Skor ≥ 7: RISIKO TINGGI</td>
            </tr>
        </table>

        <div class="footer">
            <p>Nama dan Paraf:</p>
            <p style="margin-top: 30px;">{{ str()->title($ewsPasienDewasa->userCreate->name ?? '-') }}</p>
            <p class="small-text">Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}</p>
            @if(isset($ewsPasienDewasa) && $ewsPasienDewasa->userCreate && $ewsPasienDewasa->userCreate->jabatan)
                <p>{{ $ewsPasienDewasa->userCreate->jabatan }}</p>
            @endif
        </div>
    </div>
</body>

</html>
