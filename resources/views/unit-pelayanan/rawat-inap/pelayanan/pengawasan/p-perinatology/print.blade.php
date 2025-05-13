<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Pengawasan Perinatology</title>
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
            font-size: 9px;
            line-height: 1.2;
        }

        .header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .logo {
            width: 60px;
            height: 60px;
            margin-right: 15px;
        }

        .hospital-info {
            flex: 1;
        }

        .hospital-name {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .hospital-address {
            font-size: 10px;
            margin-bottom: 3px;
        }

        .title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin: 15px 0;
        }

        .subtitle {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .patient-info {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 15px;
            margin-bottom: 15px;
            font-size: 9px;
        }

        .info-row {
            display: flex;
            margin-bottom: 3px;
        }

        .info-label {
            width: 80px;
            display: inline-block;
        }

        .info-value {
            flex: 1;
            font-weight: bold;
        }

        .observation-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8px;
            margin-bottom: 20px;
        }

        .observation-table th,
        .observation-table td {
            border: 1px solid #000;
            padding: 3px;
            text-align: center;
            vertical-align: middle;
        }

        .observation-table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .section-header {
            background-color: #e0e0e0;
            font-weight: bold;
            font-size: 9px;
        }

        .print-date {
            text-align: right;
            font-size: 8px;
            margin-top: 15px;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Print Button -->
    <div class="no-print" style="margin-bottom: 15px;">
        <button onclick="window.print()" style="padding: 10px 20px; font-size: 14px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">
            <i class="ti-printer"></i> Print
        </button>
        <button onclick="window.close()" style="padding: 10px 20px; font-size: 14px; background-color: #6c757d; color: white; border: none; border-radius: 5px; cursor: pointer; margin-left: 10px;">
            Close
        </button>
    </div>

    <!-- Header -->
    <div class="header">
        <img src="{{ asset('assets/img/Logo-RSUD-Langsa-1.png') }}" alt="Logo RSUD Langsa" class="logo">
        <div class="hospital-info">
            <div class="hospital-name">RSUD LANGSA</div>
            <div class="hospital-address">Jl. Jend. A. Yani No. 1</div>
            <div class="hospital-address">Kota Langsa</div>
        </div>
        <div style="text-align: right;">
            <div style="font-weight: bold;">NO RM</div>
            <div style="border-bottom: 1px solid #000; min-width: 150px; height: 20px;">{{ $dataMedis->kd_pasien }}</div>
        </div>
    </div>

    <!-- Title -->
    <div class="title">PENGAWASAN KHUSUS</div>
    <div class="subtitle">PERINATOLOGI</div>

    <!-- Patient Information -->
    <div class="patient-info">
        <div>
            <div class="info-row">
                <span class="info-label">Nama Keluarga</span>
                <span>:</span>
                <span class="info-value">{{ $dataMedis->customer->nama_customer ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Nama pasien</span>
                <span>:</span>
                <span class="info-value">{{ $dataMedis->pasien->nama_pasien ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Ruang</span>
                <span>:</span>
                <span class="info-value">{{ $dataMedis->unit->nama_unit ?? '-' }}</span>
            </div>
        </div>
        <div>
            <div class="info-row">
                <span class="info-label">BBL</span>
                <span>:</span>
                <span class="info-value">
                    @if($perinatologyData->first())
                        {{ $perinatologyData->first()->bbl_formatted }} gr
                    @else
                        .................. gr
                    @endif
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">BBS</span>
                <span>:</span>
                <span class="info-value">
                    @if($perinatologyData->last())
                        {{ $perinatologyData->last()->bbs_formatted }} gr
                    @else
                        .................. gr
                    @endif
                </span>
            </div>
        </div>
        <div>
            <div class="info-row">
                <span class="info-label">Gestasi</span>
                <span>:</span>
                <span class="info-value">
                    @if($perinatologyData->first())
                        {{ $perinatologyData->first()->gestasi }}
                    @else
                        ........................
                    @endif
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Umur</span>
                <span>:</span>
                <span class="info-value">{{ $dataMedis->pasien->umur ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Hari rawat</span>
                <span>:</span>
                <span class="info-value">{{ Carbon\Carbon::parse($dataMedis->tgl_masuk)->diffInDays(now()) + 1 }}</span>
            </div>
        </div>
    </div>

    <!-- Observation Table -->
    <table class="observation-table">
        <thead>
            <tr>
                <th rowspan="2" style="width: 8%;">TGL/JAM</th>
                <th colspan="5" class="section-header">OBSERVASI</th>
                <th colspan="8" class="section-header">VENTILASI</th>
            </tr>
            <tr>
                <!-- Observasi -->
                <th style="width: 8%;">KESADARAN</th>
                <th style="width: 8%;">TD/CRT</th>
                <th style="width: 6%;">NADI</th>
                <th style="width: 6%;">NAFAS</th>
                <th style="width: 6%;">SUHU</th>
                <!-- Ventilasi -->
                <th style="width: 8%;">MODUS</th>
                <th style="width: 6%;">PEP<br>CM H₂O</th>
                <th style="width: 6%;">BUBLE</th>
                <th style="width: 6%;">FI O₂</th>
                <th style="width: 8%;">FLOW<br>liter/mnt</th>
                <th style="width: 6%;">SPO₂</th>
                <th style="width: 6%;">AIR</th>
                <th style="width: 8%;">HUMIDIFIER<br>AIR | SUHU</th>
            </tr>
        </thead>
        <tbody>
            @if($perinatologyData->count() > 0)
                @foreach($perinatologyData as $data)
                    <tr style="height: 25px;">
                        <td>
                            <div>{{ date('d/m/Y', strtotime($data->tgl_implementasi)) }}</div>
                            <div style="font-size: 7px;">{{ date('H:i', strtotime($data->jam_implementasi)) }}</div>
                        </td>
                        <!-- Observasi -->
                        <td>{{ $data->detail->kesadaran ?? '' }}</td>
                        <td>{{ $data->detail->td_crt ?? '' }}</td>
                        <td>{{ $data->detail->nadi ?? '' }}</td>
                        <td>{{ $data->detail->nafas ?? '' }}</td>
                        <td>{{ $data->detail->suhu_formatted ?? '' }}</td>
                        <!-- Ventilasi -->
                        <td>{{ $data->detail->modus ?? '' }}</td>
                        <td>{{ $data->detail->pep_formatted ?? '' }}</td>
                        <td>{{ $data->detail->bubble ?? '' }}</td>
                        <td>{{ $data->detail->fi_o2_formatted ?? '' }}</td>
                        <td>{{ $data->detail->flow_formatted ?? '' }}</td>
                        <td>{{ $data->detail->spo2 ?? '' }}</td>
                        <td>{{ $data->detail->air ?? '' }}</td>
                        <td>{{ $data->detail->air ?? '' }} | {{ $data->detail->suhu_ventilator_formatted ?? '' }}</td>
                    </tr>
                @endforeach
                <!-- Add empty rows to fill the page -->
                @for($i = $perinatologyData->count(); $i < 12; $i++)
                    <tr style="height: 25px;">
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                @endfor
            @else
                @for($i = 0; $i < 12; $i++)
                    <tr style="height: 25px;">
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                @endfor
            @endif
        </tbody>
    </table>

    <!-- Print Date -->
    <div class="print-date">
        Periode: {{ date('d/m/Y', strtotime($tanggal_mulai)) }} - {{ date('d/m/Y', strtotime($tanggal_selesai)) }} | 
        Dicetak: {{ date('d/m/Y H:i') }}
    </div>
</body>
</html>