<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengawasan Perinatology</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 15mm;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.3;
            color: #000;
            width: 260mm; /* A4 landscape width minus margins */
            margin: 0 auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8mm;
        }

        .header-column {
            width: 33.33%;
            padding: 0 4mm;
        }

        .logo-info {
            display: flex;
            align-items: center;
        }

        .logo {
            width: 50px;
            height: 50px;
            margin-right: 3mm;
        }

        .hospital-info {
            flex: 1;
        }

        .hospital-name {
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 1mm;
        }

        .hospital-address {
            font-size: 9px;
            margin-bottom: 1mm;
        }

        .title {
            font-size: 15px;
            font-weight: bold;
            text-align: center;
        }

        .subtitle {
            font-size: 13px;
            font-weight: bold;
            text-align: center;
            margin-top: 1mm;
        }

        .no-rm {
            text-align: right;
            font-size: 10px;
        }

        .no-rm-label {
            font-weight: bold;
            margin-bottom: 1mm;
        }

        .no-rm-value {
            border-bottom: 0.5mm solid #000;
            display: inline-block;
            min-width: 40mm;
            padding-bottom: 1mm;
            font-weight: bold;
        }

        .patient-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8mm;
            font-size: 9px;
        }

        .patient-column {
            width: 33.33%;
            padding: 0 4mm;
        }

        .info-item {
            display: flex;
            margin-bottom: 1.5mm;
        }

        .info-label {
            width: 25mm;
            font-weight: normal;
        }

        .info-value {
            font-weight: bold;
            flex: 1;
        }

        .table-container {
            width: 100%;
            margin-bottom: 8mm;
        }

        .observation-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8px;
        }

        .observation-table th,
        .observation-table td {
            border: 0.3mm solid #000;
            padding: 1.5mm;
            text-align: center;
            vertical-align: middle;
        }

        .observation-table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }

        .section-header {
            background-color: #e5e5e5;
            font-size: 8.5px;
            font-weight: bold;
        }

        .footer {
            text-align: right;
            font-size: 8px;
            font-style: italic;
        }

        @media print {
            body {
                width: 100%;
                margin: 0;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-column">
            <div class="logo-info">
                <img src="{{ asset('assets/img/Logo-RSUD-Langsa-1.png') }}" alt="Logo RSUD Langsa" class="logo">
                <div class="hospital-info">
                    <div class="hospital-name">RSUD LANGSA</div>
                    <div class="hospital-address">Jl. Jend. A. Yani No. 1</div>
                    <div class="hospital-address">Kota Langsa</div>
                </div>
            </div>
        </div>
        <div class="header-column">
            <div class="title">PENGAWASAN KHUSUS</div>
            <div class="subtitle">PERINATOLOGI</div>
        </div>
        <div class="header-column no-rm">
            <div class="no-rm-label">NO RM</div>
            <div class="no-rm-value">{{ $dataMedis->kd_pasien }}</div>
        </div>
    </div>

    <div class="patient-info">
        <div class="patient-column">
            <div class="info-item">
                <span class="info-label">Nama Keluarga</span>
                <span class="info-value">{{ $dataMedis->customer->nama_customer ?? '-' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Nama Pasien</span>
                <span class="info-value">{{ $dataMedis->pasien->nama ?? '-' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Ruang</span>
                <span class="info-value">{{ $dataMedis->unit->nama_unit ?? '-' }}</span>
            </div>
        </div>
        <div class="patient-column">
            <div class="info-item">
                <span class="info-label">BBL</span>
                <span class="info-value">
                    @if($perinatologyData->first() && $perinatologyData->first()->bbl_formatted)
                        {{ $perinatologyData->first()->bbl_formatted }} gr
                    @else
                        - gr
                    @endif
                </span>
            </div>
            <div class="info-item">
                <span class="info-label">BBS</span>
                <span class="info-value">
                    @if($perinatologyData->last() && $perinatologyData->last()->bbs_formatted)
                        {{ $perinatologyData->last()->bbs_formatted }} gr
                    @else
                        - gr
                    @endif
                </span>
            </div>
        </div>
        <div class="patient-column">
            <div class="info-item">
                <span class="info-label">Gestasi</span>
                <span class="info-value">
                    @if($perinatologyData->first() && $perinatologyData->first()->gestasi)
                        {{ $perinatologyData->first()->gestasi }}
                    @else
                        -
                    @endif
                </span>
            </div>
            <div class="info-item">
                <span class="info-label">Umur</span>
                <span class="info-value">{{ $dataMedis->pasien->umur ?? '-' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Hari Rawat</span>
                <span class="info-value">{{ Carbon\Carbon::parse($dataMedis->tgl_masuk)->diffInDays(now()) + 1 }}</span>
            </div>
        </div>
    </div>

    <div class="table-container">
        <table class="observation-table">
            <thead>
                <tr>
                    <th rowspan="3" style="width: 8%;">TGL/JAM</th>
                    <th colspan="5" class="section-header">OBSERVASI</th>
                    <th colspan="8" class="section-header">VENTILASI</th>
                </tr>
                <tr>
                    <th rowspan="2" style="width: 7%;">KESADARAN</th>
                    <th rowspan="2" style="width: 7%;">TD/CRT</th>
                    <th rowspan="2" style="width: 5%;">NADI</th>
                    <th rowspan="2" style="width: 5%;">NAFAS</th>
                    <th rowspan="2" style="width: 5%;">SUHU</th>
                    <th rowspan="2" style="width: 7%;">MODUS</th>
                    <th rowspan="2" style="width: 5%;">PEP<br>CM H₂O</th>
                    <th rowspan="2" style="width: 5%;">BUBLE</th>
                    <th rowspan="2" style="width: 5%;">FI O₂</th>
                    <th rowspan="2" style="width: 7%;">FLOW<br>liter/mnt</th>
                    <th rowspan="2" style="width: 5%;">SPO₂</th>
                    <th colspan="2" style="width: 3.5%;">HUMIDIFIER</th>
                </tr>
                <tr>
                    <th style="width: 3.5%;">AIR</th>
                    <th style="width: 3.5%;">SUHU</th>
                </tr>
            </thead>
            <tbody>
                @if($perinatologyData->count() > 0)
                    @foreach($perinatologyData as $data)
                        <tr style="height: 8mm;">
                            <td>
                                <div>{{ date('d/m/Y', strtotime($data->tgl_implementasi)) }}</div>
                                <div style="font-size: 6px;">{{ date('H:i', strtotime($data->jam_implementasi)) }}</div>
                            </td>
                            <td>{{ $data->detail->kesadaran ?? '-' }}</td>
                            <td>{{ $data->detail->td_crt ?? '-' }}</td>
                            <td>{{ $data->detail->nadi ?? '-' }}</td>
                            <td>{{ $data->detail->nafas ?? '-' }}</td>
                            <td>{{ $data->detail->suhu_formatted ?? '-' }}</td>
                            <td>{{ $data->detail->modus ?? '-' }}</td>
                            <td>{{ $data->detail->pep_formatted ?? '-' }}</td>
                            <td>{{ $data->detail->bubble ?? '-' }}</td>
                            <td>{{ $data->detail->fi_o2_formatted ?? '-' }}</td>
                            <td>{{ $data->detail->flow_formatted ?? '-' }}</td>
                            <td>{{ $data->detail->spo2 ?? '-' }}</td>
                            <td>{{ $data->detail->air ?? '-' }}</td>
                            <td>{{ $data->detail->suhu_ventilator_formatted ?? '-' }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr style="height: 8mm;">
                        <td colspan="14">Tidak ada data tersedia</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <div class="footer">
        Periode: {{ date('d/m/Y', strtotime($tanggal_mulai)) }} - {{ date('d/m/Y', strtotime($tanggal_selesai)) }} | 
        Dicetak: {{ date('d/m/Y H:i') }}
    </div>
</body>
</html>