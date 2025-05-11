<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Observasi Pasien</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            line-height: 1.3;
            margin: 0;
            padding: 0;
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
        
        .page-break {
            page-break-after: always;
        }
        
        table.observasi {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
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
            position: fixed;
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
    @php
        // Group observations into chunks of 4 for pagination
        $observasiChunks = $observasiList->chunk(4);
        $totalPages = count($observasiChunks);
        $currentPage = 1;
    @endphp

    @foreach($observasiChunks as $chunkIndex => $observasiChunk)
        <!-- Header yang diulang di setiap halaman -->
        <div class="header">
            <div class="logo-hospital-container">
                <div class="logo-cell">
                    @if(isset($logoPath) && $logoPath)
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
                    <th rowspan="2">Parameter</th>
                    @foreach($observasiChunk as $observasi)
                        <th colspan="{{ count($allTimestamps) > 0 ? count($allTimestamps) : 1 }}">
                            {{ $observasi->tanggal->format('d-m-Y') }}
                        </th>
                    @endforeach
                </tr>
                @if(count($allTimestamps) > 0)
                    <tr>
                        @foreach($observasiChunk as $observasi)
                            @foreach($allTimestamps as $timestamp)
                                <th>{{ $timestamp }}</th>
                            @endforeach
                        @endforeach
                    </tr>
                @endif
            </thead>
            <tbody>
                <!-- Vital Signs First -->
                @if(count($allTimestamps) > 0)
                    <!-- Suhu -->
                    <tr class="field-row">
                        <td>Suhu (°C)</td>
                        @foreach($observasiChunk as $observasi)
                            @foreach($allTimestamps as $timestamp)
                                @php
                                    $detail = $observasi->details->where('waktu', $timestamp)->first();
                                @endphp
                                <td>{{ $detail && $detail->suhu ? $detail->suhu : '-' }}</td>
                            @endforeach
                        @endforeach
                    </tr>
                    
                    <!-- Nadi -->
                    <tr class="field-row">
                        <td>Nadi (x/menit)</td>
                        @foreach($observasiChunk as $observasi)
                            @foreach($allTimestamps as $timestamp)
                                @php
                                    $detail = $observasi->details->where('waktu', $timestamp)->first();
                                @endphp
                                <td>{{ $detail && $detail->nadi ? $detail->nadi : '-' }}</td>
                            @endforeach
                        @endforeach
                    </tr>
                    
                    <!-- Tekanan Darah -->
                    <tr class="field-row">
                        <td>Tekanan Darah (mmHg)</td>
                        @foreach($observasiChunk as $observasi)
                            @foreach($allTimestamps as $timestamp)
                                @php
                                    $detail = $observasi->details->where('waktu', $timestamp)->first();
                                    $tekananDarah = ($detail && $detail->tekanan_darah_sistole && $detail->tekanan_darah_diastole) 
                                        ? $detail->tekanan_darah_sistole . '/' . $detail->tekanan_darah_diastole
                                        : '-';
                                @endphp
                                <td>{{ $tekananDarah }}</td>
                            @endforeach
                        @endforeach
                    </tr>
                    
                    <!-- Respirasi -->
                    <tr class="field-row">
                        <td>Respirasi (x/menit)</td>
                        @foreach($observasiChunk as $observasi)
                            @foreach($allTimestamps as $timestamp)
                                @php
                                    $detail = $observasi->details->where('waktu', $timestamp)->first();
                                @endphp
                                <td>{{ $detail && $detail->respirasi ? $detail->respirasi : '-' }}</td>
                            @endforeach
                        @endforeach
                    </tr>
                @endif

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

        @if($currentPage < $totalPages)
            <div class="page-break"></div>
            @php $currentPage++; @endphp
        @endif
    @endforeach
</body>
</html>