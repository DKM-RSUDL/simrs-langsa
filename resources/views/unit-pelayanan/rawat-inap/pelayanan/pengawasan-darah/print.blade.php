<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan Pengawasan Darah</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 9pt;
            line-height: 1.2;
            margin: 5mm;
        }

        .header {
            display: table;
            width: 100%;
            margin-bottom: 10px;
        }

        .header-row {
            display: table-row;
        }

        .hospital-info {
            display: table-cell;
            vertical-align: top;
            width: 25%;
        }

        .title-section {
            display: table-cell;
            vertical-align: top;
            width: 45%;
        }

        .patient-info-cell {
            display: table-cell;
            vertical-align: top;
            width: 30%;
        }

        .hospital-info {
            text-align: left;
        }

        .hospital-info img {
            width: 50px;
            height: auto;
            vertical-align: middle;
            margin-right: 8px;
        }

        .hospital-info .info-text {
            display: inline-block;
            vertical-align: middle;
            font-size: 9pt;
        }

        .hospital-info .info-text .title {
            font-size: 12pt;
            font-weight: bold;
            margin-bottom: 1px;
        }

        .hospital-info .info-text p {
            margin: 0;
        }

        .title-section {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            padding: 8px 10px 0 10px;
        }

        .patient-info-box {
            border: 1px solid #000;
            padding: 8px;
            font-size: 8pt;
        }

        .patient-info-box p {
            margin: 2px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
            padding: 4px;
            font-size: 8pt;
        }

        td {
            padding: 3px;
            font-size: 8pt;
            text-align: center;
        }

        .section-title {
            font-size: 11pt;
            font-weight: bold;
            margin: 15px 0 8px 0;
            text-align: center;
            background-color: #e9ecef;
            padding: 5px;
            border: 1px solid #000;
        }

        .no-data {
            text-align: center;
            font-style: italic;
            color: #666;
            padding: 20px;
        }

        .status-sesuai {
            background-color: #e4f1e7;
            color: #155724;
        }

        .status-tidak-sesuai {
            background-color: #f8d7da;
            color: #721c24;
        }

        .badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 7pt;
            font-weight: bold;
        }

        .badge-primary {
            background-color: #007bff;
            color: white;
        }

        .badge-success {
            background-color: #28a745;
            color: white;
        }

        .badge-warning {
            background-color: #ffc107;
            color: #212529;
        }

        .badge-danger {
            background-color: #dc3545;
            color: white;
        }

        .text-left {
            text-align: left !important;
        }

        .text-small {
            font-size: 7pt;
        }

        @media print {
            body {
                margin: 0;
            }
            
            .page-break {
                page-break-before: always;
            }
        }
    </style>
</head>

<body>
    <!-- HEADER -->
    <div class="header">
        <div class="header-row">
            <div class="hospital-info">
                @if (isset($logoPath) && file_exists($logoPath))
                    <img src="{{ $logoPath }}" alt="Logo RSUD Langsa">
                @endif
                <div class="info-text">
                    <p class="title">RSUD LANGSA</p>
                    <p>Jl. Jend. A. Yani Kota Langsa</p>
                    <p>Telp. 0641 - 32051</p>
                    <p>rsudlangsa.aceh@gmail.com</p>
                </div>
            </div>
            <div class="title-section">
                LAPORAN PENGAWASAN DARAH<br>
                <i style="font-size: 10pt">(PENGELOLAAN DAN MONITORING TRANSFUSI DARAH)</i>
            </div>
            <div class="patient-info-cell">
                <div class="patient-info-box">
                    <p><b>NO RM: {{ $dataMedis->kd_pasien ?? 'N/A' }}</b></p>
                    <p>Nama: {{ $dataMedis->pasien->nama ?? 'N/A' }}</p>
                    <p>Jenis Kelamin:
                        {{ ($dataMedis->pasien->jenis_kelamin ?? '') == '1' ? 'Laki-laki' : (($dataMedis->pasien->jenis_kelamin ?? '') == '0' ? 'Perempuan' : 'N/A') }}
                    </p>
                    <p>Tanggal Lahir:
                        {{ $dataMedis->pasien->tgl_lahir ? Carbon\Carbon::parse($dataMedis->pasien->tgl_lahir)->format('d-m-Y') : 'N/A' }}
                    </p>
                    <p>Umur: {{ $dataMedis->pasien->umur ?? 'N/A' }} Tahun</p>
                    <p>Unit: {{ $dataMedis->unit->bagian->bagian ?? 'N/A' }} ({{ $dataMedis->unit->nama_unit }})</p>
                </div>
            </div>
        </div>
    </div>
    <hr style="border: 0.5px solid #000; margin-top: 5px; margin-bottom: 10px;">

    <!-- TABEL PENGELOLAAN PENGAWASAN DARAH -->
    <div class="section-title">PENGELOLAAN PENGAWASAN DARAH</div>
    
    @if($pengelolaanDarah->count() > 0)
        <table>
            <thead>
                <tr>
                    <th rowspan="2" style="width: 3%;">No</th>
                    <th rowspan="2" style="width: 8%;">Tanggal</th>
                    <th rowspan="2" style="width: 6%;">Jam</th>
                    <th rowspan="2" style="width: 8%;">Transfusi Ke</th>
                    <th rowspan="2" style="width: 12%;">No. Seri Kantong</th>
                    <th colspan="6" style="width: 45%;">Verifikasi Keamanan Darah</th>
                    <th rowspan="2" style="width: 18%;">Petugas</th>
                </tr>
                <tr>
                    <th style="width: 7.5%;">Riwayat Komponen</th>
                    <th style="width: 7.5%;">Identitas Label</th>
                    <th style="width: 7.5%;">Golongan Darah</th>
                    <th style="width: 7.5%;">Volume</th>
                    <th style="width: 7.5%;">Kantong Utuh</th>
                    <th style="width: 7.5%;">Tidak Expired</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengelolaanDarah as $index => $data)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ date('d/m/Y', strtotime($data->tanggal)) }}</td>
                        <td>{{ date('H:i', strtotime($data->jam)) }}</td>
                        <td>
                            <span class="badge badge-primary">{{ $data->transfusi_ke }}</span>
                        </td>
                        <td class="text-left">{{ $data->nomor_seri_kantong }}</td>
                        <td class="{{ $data->riwayat_komponen_sesuai == 1 ? 'status-sesuai' : 'status-tidak-sesuai' }}">
                            @if($data->riwayat_komponen_sesuai == 1)
                                <span class="badge badge-success">Sesuai</span>
                            @else
                                <span class="badge badge-danger">Tidak</span>
                            @endif
                        </td>
                        <td class="{{ $data->identitas_label_sesuai == 1 ? 'status-sesuai' : 'status-tidak-sesuai' }}">
                            @if($data->identitas_label_sesuai == 1)
                                <span class="badge badge-success">Sesuai</span>
                            @else
                                <span class="badge badge-danger">Tidak</span>
                            @endif
                        </td>
                        <td class="{{ $data->golongan_darah_sesuai == 1 ? 'status-sesuai' : 'status-tidak-sesuai' }}">
                            @if($data->golongan_darah_sesuai == 1)
                                <span class="badge badge-success">Sesuai</span>
                            @else
                                <span class="badge badge-danger">Tidak</span>
                            @endif
                        </td>
                        <td class="{{ $data->volume_sesuai == 1 ? 'status-sesuai' : 'status-tidak-sesuai' }}">
                            @if($data->volume_sesuai == 1)
                                <span class="badge badge-success">Sesuai</span>
                            @else
                                <span class="badge badge-danger">Tidak</span>
                            @endif
                        </td>
                        <td class="{{ $data->kantong_utuh == 1 ? 'status-sesuai' : 'status-tidak-sesuai' }}">
                            @if($data->kantong_utuh == 1)
                                <span class="badge badge-success">Sesuai</span>
                            @else
                                <span class="badge badge-danger">Tidak</span>
                            @endif
                        </td>
                        <td class="{{ $data->tidak_expired == 1 ? 'status-sesuai' : 'status-tidak-sesuai' }}">
                            @if($data->tidak_expired == 1)
                                <span class="badge badge-success">Sesuai</span>
                            @else
                                <span class="badge badge-danger">Tidak</span>
                            @endif
                        </td>
                        <td class="text-left text-small">
                            P1: {{ $data->petugas1->nama ?? 'N/A' }}<br>
                            P2: {{ $data->petugas2->nama ?? 'N/A' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">Tidak ada data pengelolaan pengawasan darah</div>
    @endif

    <!-- TABEL MONITORING TRANSFUSI DARAH -->
    <div class="section-title">MONITORING TRANSFUSI DARAH</div>
    
    @if($monitoringDarah->count() > 0)
        <table>
            <thead>
                <tr>
                    <th rowspan="3" style="width: 3%;">No</th>
                    <th rowspan="3" style="width: 10%;">Tanggal & Jam</th>
                    <th colspan="2" style="width: 12%;">Waktu Transfusi</th>
                    <th colspan="20" style="width: 57%;">Monitoring Tanda Vital</th>
                    <th rowspan="3" style="width: 8%;">Reaksi</th>
                    <th rowspan="3" style="width: 10%;">Petugas</th>
                </tr>
                <tr>
                    <th rowspan="2" style="width: 6%;">Mulai</th>
                    <th rowspan="2" style="width: 6%;">Selesai</th>
                    <th colspan="5" style="width: 14.25%;">Pre (15 mnt sebelum)</th>
                    <th colspan="5" style="width: 14.25%;">Post 15 mnt</th>
                    <th colspan="5" style="width: 14.25%;">Post 1 jam</th>
                    <th colspan="5" style="width: 14.25%;">Post 4 jam</th>
                </tr>
                <tr>
                    <th style="width: 2.85%;">TD Sys</th>
                    <th style="width: 2.85%;">TD Dia</th>
                    <th style="width: 2.85%;">Nadi</th>
                    <th style="width: 2.85%;">Suhu</th>
                    <th style="width: 2.85%;">RR</th>
                    <th style="width: 2.85%;">TD Sys</th>
                    <th style="width: 2.85%;">TD Dia</th>
                    <th style="width: 2.85%;">Nadi</th>
                    <th style="width: 2.85%;">Suhu</th>
                    <th style="width: 2.85%;">RR</th>
                    <th style="width: 2.85%;">TD Sys</th>
                    <th style="width: 2.85%;">TD Dia</th>
                    <th style="width: 2.85%;">Nadi</th>
                    <th style="width: 2.85%;">Suhu</th>
                    <th style="width: 2.85%;">RR</th>
                    <th style="width: 2.85%;">TD Sys</th>
                    <th style="width: 2.85%;">TD Dia</th>
                    <th style="width: 2.85%;">Nadi</th>
                    <th style="width: 2.85%;">Suhu</th>
                    <th style="width: 2.85%;">RR</th>
                </tr>
            </thead>
            <tbody>
                @foreach($monitoringDarah as $index => $data)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="text-small">
                            {{ date('d/m/Y', strtotime($data->tanggal)) }}<br>
                            {{ date('H:i', strtotime($data->jam)) }}
                        </td>
                        <td>{{ date('H:i', strtotime($data->jam_mulai_transfusi)) }}</td>
                        <td>{{ date('H:i', strtotime($data->jam_selesai_transfusi)) }}</td>
                        <!-- Pre transfusi -->
                        <td>{{ $data->pre_td_sistole }}</td>
                        <td>{{ $data->pre_td_diastole }}</td>
                        <td>{{ $data->pre_nadi }}</td>
                        <td>{{ $data->pre_temp }}</td>
                        <td>{{ $data->pre_rr }}</td>
                        <!-- Post 15 menit -->
                        <td>{{ $data->post15_td_sistole }}</td>
                        <td>{{ $data->post15_td_diastole }}</td>
                        <td>{{ $data->post15_nadi }}</td>
                        <td>{{ $data->post15_temp }}</td>
                        <td>{{ $data->post15_rr }}</td>
                        <!-- Post 1 jam -->
                        <td>{{ $data->post1h_td_sistole }}</td>
                        <td>{{ $data->post1h_td_diastole }}</td>
                        <td>{{ $data->post1h_nadi }}</td>
                        <td>{{ $data->post1h_temp }}</td>
                        <td>{{ $data->post1h_rr }}</td>
                        <!-- Post 4 jam -->
                        <td>{{ $data->post4h_td_sistole }}</td>
                        <td>{{ $data->post4h_td_diastole }}</td>
                        <td>{{ $data->post4h_nadi }}</td>
                        <td>{{ $data->post4h_temp }}</td>
                        <td>{{ $data->post4h_rr }}</td>
                        <!-- Reaksi -->
                        <td class="text-left text-small">
                            @if($data->reaksi_selama_transfusi || $data->reaksi_transfusi)
                                @if($data->reaksi_selama_transfusi)
                                    <strong>Selama:</strong> {{ $data->reaksi_selama_transfusi }}
                                @endif
                                @if($data->reaksi_transfusi)
                                    @if($data->reaksi_selama_transfusi)<br>@endif
                                    <strong>Setelah:</strong> {{ $data->reaksi_transfusi }}
                                @endif
                            @else
                                <span class="badge badge-success">Normal</span>
                            @endif
                        </td>
                        <!-- Petugas -->
                        <td class="text-left text-small">
                            Dr: {{ $data->dokterRelation->nama ?? 'N/A' }}<br>
                            Ns: {{ $data->perawatRelation->nama ?? 'N/A' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">Tidak ada data monitoring transfusi darah</div>
    @endif
</body>

</html>