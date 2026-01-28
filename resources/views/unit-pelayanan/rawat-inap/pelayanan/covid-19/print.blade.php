<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Covid 19 - {{ $dataMedis->pasien->nama ?? 'Pasien' }}</title>
    <style>
        @page {
            size: 8.5in 13in;
            /* Letter/F4 size */
            margin: 10mm 12mm 10mm 12mm;
        }

        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 10px;
            line-height: 1.2;
            color: #000;
            margin: 0;
            padding: 0;
        }

        .header {
            width: 100%;
            margin-bottom: 10px;
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
        }

        .header-content {
            display: table;
            width: 100%;
        }

        .logo-section {
            display: table-cell;
            width: 12%;
            vertical-align: middle;
            text-align: center;
        }

        .title-section {
            display: table-cell;
            width: 25%;
            vertical-align: middle;
            text-align: center;
            padding: 0 5px;
        }

        .patient-info {
            display: table-cell;
            width: 20%;
            vertical-align: top;
        }

        .logo-box {
            width: 50px;
            height: 50px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8px;
            font-weight: bold;
        }

        .hospital-name {
            font-size: 9px;
            font-weight: bold;
            margin-top: 3px;
        }

        .hospital-address {
            font-size: 7px;
            margin-top: 2px;
            line-height: 1.1;
        }

        .main-title {
            font-size: 12px;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
            line-height: 1.2;
        }

        .form-number {
            font-size: 8px;
            margin-top: 5px;
        }

        .patient-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8px;
        }

        .patient-table td {
            border: 1px solid #000;
            padding: 2px 2px;
            vertical-align: top;
        }

        .patient-table .label {
            background-color: #f5f5f5;
            font-weight: bold;
            width: 35%;
        }

        .content {
            margin-top: 10px;
            clear: both;
        }

        .instruction {
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 10px;
        }

        .table-form {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .table-form th,
        .table-form td {
            border: 1px solid #000;
            padding: 2px 2px;
            text-align: left;
            vertical-align: middle;
        }

        .table-form th {
            background-color: #f5f5f5;
            font-weight: bold;
            text-align: center;
            font-size: 9px;
        }

        .table-form .no-col {
            width: 6%;
            text-align: center;
            font-size: 9px;
        }

        .table-form .item-col {
            width: 64%;
            font-size: 9px;
        }

        .table-form .ya-col,
        .table-form .tidak-col {
            width: 15%;
            text-align: center;
        }

        /* Checkbox styling for DomPDF */
        .checkbox {
            width: 12px;
            height: 12px;
            border: 1.5px solid #000;
            display: inline-block;
            text-align: center;
            line-height: 10px;
            font-weight: bold;
            vertical-align: middle;
            margin: 0 auto;
        }

        .checkbox.checked {
            background-color: #000;
            color: white;
        }

        .checkbox.checked::before {
            content: "✓";
            font-size: 7px;
            font-weight: bold;
        }

        .date-input {
            border-bottom: 1px solid #000;
            display: inline-block;
            min-width: 60px;
            text-align: center;
            padding: 1px 3px;
            font-size: 9px;
        }

        .date-label {
            font-weight: bold;
            margin: 10px 0;
            font-size: 9px;
        }

        .komorbid-section {
            margin: 12px 0;
        }

        .komorbid-title {
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 10px;
            text-transform: uppercase;
        }

        .komorbid-subtitle {
            font-weight: bold;
            margin-bottom: 8px;
            font-size: 9px;
        }

        .komorbid-list {
            display: table;
            width: 100%;
        }

        .komorbid-row {
            display: table-row;
        }

        .komorbid-col {
            display: table-cell;
            width: 33.33%;
            padding: 2px 6px;
            vertical-align: top;
        }

        .komorbid-item {
            margin-bottom: 4px;
            font-size: 9px;
        }

        .penilaian-section {
            margin: 10px 0;
        }

        .penilaian-title {
            font-weight: bold;
            margin-bottom: 8px;
            font-size: 9px;
            text-transform: uppercase;
        }

        .penilaian-table {
            width: 100%;
            border-collapse: collapse;
        }

        .penilaian-table th,
        .penilaian-table td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
            vertical-align: top;
        }

        .penilaian-table th {
            background-color: #f5f5f5;
            font-weight: bold;
            font-size: 9px;
        }

        .penilaian-table .criteria-cell {
            text-align: left;
            font-size: 8px;
            line-height: 1.3;
        }

        .kesimpulan-section {
            margin: 15px 0;
        }

        .kesimpulan-title {
            font-weight: bold;
            margin-bottom: 8px;
            font-size: 9px;
            text-transform: uppercase;
            text-align: start;
        }

        .kesimpulan-table {
            width: 100%;
            border-collapse: collapse;
            margin: 8px 0;
        }

        .kesimpulan-table th,
        .kesimpulan-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        .kesimpulan-table th {
            background-color: #f5f5f5;
            font-weight: bold;
            font-size: 9px;
        }

        .tindak-lanjut {
            margin: 5px 0;
            padding: 4px;
            border: 1px solid #000;
        }

        .tindak-lanjut-title {
            font-weight: bold;
            margin-bottom: 8px;
            font-size: 9px;
            text-transform: uppercase;
        }

        .tindak-lanjut-item {
            margin-bottom: 3px;
            font-size: 8px;
        }

        .declaration {
            margin: 10px 0;
            text-align: justify;
            line-height: 1.4;
            font-size: 8px;
        }

        .location-date {
            margin: 10px 0;
            text-align: start;
            font-size: 9px;
        }

        .underline {
            border-bottom: 1px solid #000;
            display: inline-block;
            min-width: 80px;
            padding-bottom: 2px;
            text-align: center;
        }

        .signature-section {
            margin-top: 10px;
            page-break-inside: avoid;
        }

        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        .signature-table td {
            border: none;
            padding: 8px;
            text-align: center;
            vertical-align: top;
            width: 50%;
        }

        .signature-box {
            height: 50px;
            border-bottom: 1px solid #000;
            margin-bottom: 5px;
            margin-top: 5px;
        }

        .signature-label {
            font-size: 8px;
            font-weight: bold;
        }

        .signature-name {
            margin-top: 5px;
            font-size: 8px;
        }

        .note-section {
            margin-top: 5px;
            font-size: 8px;
            line-height: 1.3;
        }

        .note-title {
            font-weight: bold;
        }

        .page-break {
            page-break-before: always;
        }

        /* Page 2 Styles */
        .informed-title {
            font-size: 12px;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
            margin: 7px 0;
        }

        .dasar-section {
            margin-bottom: 12px;
        }

        .dasar-title {
            font-weight: bold;
            margin-bottom: 8px;
            font-size: 9px;
        }

        .dasar-list {
            margin-left: 15px;
            line-height: 1.4;
            font-size: 8px;
        }

        .dasar-list li {
            margin-bottom: 4px;
        }

        .maka-section {
            margin-bottom: 12px;
        }

        .maka-title {
            font-weight: bold;
            margin-bottom: 8px;
            font-size: 9px;
        }

        .maka-content {
            text-align: justify;
            line-height: 1.4;
            margin-bottom: 8px;
            font-size: 8px;
        }

        .maka-list {
            margin-left: 15px;
            line-height: 1.4;
            font-size: 8px;
        }

        .maka-list li {
            margin-bottom: 4px;
        }

        .persetujuan-section {
            margin: 15px 0;
            text-align: justify;
            line-height: 1.4;
            font-size: 8px;
        }

        .signature-table-page2 {
            width: 100%;
            margin-top: 10px;
        }

        .signature-table-page2 td {
            text-align: center;
            vertical-align: top;
            width: 33.33%;
            padding: 5px;
        }

        .signature-box-page2 {
            height: 110px;
            border-bottom: 1px solid #000;
            margin: 8px 0 5px 0;
        }

        .label-barcode {
            height: 10px;
            border-bottom: 1px solid #000;
            margin: 8px 0 5px 0;
        }

        /* Additional styles for komorbid section borders */
        .no-border-left {
            border-left: none !important;
        }

        .no-border-right {
            border-right: none !important;
        }

        .no-border-top {
            border-top: none !important;
        }

        .no-border-bottom {
            border-bottom: none !important;
        }
    </style>
</head>

<body>
    <!-- PAGE 1: FORMULIR DETEKSI DINI -->
    <!-- Header Section -->
    <div class="header">
        <div class="header-content">
            <div class="logo-section">
                <div class="logo-box">
                    @if (file_exists(public_path('assets/img/Logo-RSUD-Langsa-1.png')))
                        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/Logo-RSUD-Langsa-1.png'))) }}"
                            style="width: 50px; height: 50px;" alt="Logo RSUD Langsa">
                    @else
                        LOGO
                    @endif
                </div>
                <div class="hospital-name">RSUD LANGSA</div>
                <div class="hospital-address">
                    Jl. Jend. A. Yani. Kota Langsa<br>
                    Telp: 0641- 22051<br>
                    email: rsudlangsa.aceh@gmail.com
                </div>
            </div>

            <div class="title-section">
                <h1 class="main-title">FORMULIR DETEKSI DINI CORONA VIRUS DISEASE (COVID-19) REVISI 5</h1>
            </div>

            <div class="patient-info">
                <table class="patient-table">
                    <tr>
                        <td class="label">No RM</td>
                        <td>{{ $dataMedis->pasien->kd_pasien ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Nama</td>
                        <td>{{ $dataMedis->pasien->nama ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Jenis Kelamin</td>
                        <td>
                            @if (isset($dataMedis->pasien->jenis_kelamin))
                                {{ $dataMedis->pasien->jenis_kelamin == 1 ? 'Laki-laki' : 'Perempuan' }}
                            @else
                                Laki-laki / Perempuan *
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Tanggal Lahir</td>
                        <td>{{ $dataMedis->pasien->tgl_lahir ? date('d/m/Y', strtotime($dataMedis->pasien->tgl_lahir)) : '' }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">
        <!-- Instructions -->
        <div class="instruction">
            Beri Tanda centang ✓ pada kolom yang sesuai
        </div>

        <!-- Gejala Section -->
        <table class="table-form">
            <thead>
                <tr>
                    <th class="no-col">NO</th>
                    <th class="item-col">GEJALA</th>
                    <th class="ya-col">YA</th>
                    <th class="tidak-col">TIDAK</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $gejalaList = [
                        'demam' => 'Demam (≥ 38° C)/ Riwayat demam',
                        'ispa' => 'Batuk/Pilek/Nyeri tenggorokan/Sesak Nafas (ISPA)',
                        'sakit_kepala' => 'Sakit kepala/ Lemah (Malaise)/ Nyeri otot',
                        'ispa_berat' => 'ISPA Berat/ Pneumonia Berat',
                        'gejala_lain' =>
                            'Gejala lainnya: Gangguan pemciuman/ Gangguan pengecapan/ Mual/ Muntah/ Nyeri perut/ Diare',
                    ];
                    $gejalaData = $covidData->gejala_decoded ?? [];
                @endphp

                @foreach ($gejalaList as $key => $label)
                    <tr>
                        <td class="no-col">{{ $loop->iteration }}</td>
                        <td class="item-col">{{ $label }}</td>
                        <td class="ya-col">
                            <span
                                class="checkbox {{ isset($gejalaData[$key]) && $gejalaData[$key] == 1 ? 'checked' : '' }}"></span>
                        </td>
                        <td class="tidak-col">
                            <span
                                class="checkbox {{ !isset($gejalaData[$key]) || $gejalaData[$key] != 1 ? 'checked' : '' }}"></span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Tanggal Gejala -->
        <div class="date-label">
            <strong>Tanggal pertama timbul gejala:</strong>
            <span class="date-input">{{ $covidData->tgl_gejala ? $covidData->tgl_gejala->format('d') : '' }}</span> /
            <span class="date-input">{{ $covidData->tgl_gejala ? $covidData->tgl_gejala->format('m') : '' }}</span> /
            <span class="date-input">{{ $covidData->tgl_gejala ? $covidData->tgl_gejala->format('Y') : '' }}</span>
        </div>

        <!-- Faktor Risiko & Komorbid Section -->
        <table class="table-form">
            <thead>
                <tr>
                    <th class="no-col">NO</th>
                    <th class="item-col">FAKTOR RISIKO PENULARAN</th>
                    <th class="ya-col">YA</th>
                    <th class="tidak-col">TIDAK</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $risikoList = [
                        'perjalanan' =>
                            'Riwayat perjalanan/ tinggal di daerah transmisi lokal dalam < 14 hari terakhir',
                        'kontak_erat' =>
                            'Kontak erat* dengan kasus konformasi** /Suspek***/Probable**** COVID-19 dalam 14 hari terakhir',
                    ];
                    $risikoData = $covidData->faktor_risiko_decoded ?? [];
                @endphp

                @foreach ($risikoList as $key => $label)
                    <tr>
                        <td class="no-col">{{ $loop->iteration }}</td>
                        <td class="item-col">
                            {{ $label }}
                            @if ($key == 'perjalanan')
                                <br><strong>Sebutkan Negara/ Propinsi/ Kota:</strong>
                                {{ $covidData->lokasi_perjalanan ?? '................................' }}
                            @endif
                        </td>
                        <td class="ya-col">
                            <span
                                class="checkbox {{ isset($risikoData[$key]) && $risikoData[$key] == 1 ? 'checked' : '' }}"></span>
                        </td>
                        <td class="tidak-col">
                            <span
                                class="checkbox {{ !isset($risikoData[$key]) || $risikoData[$key] != 1 ? 'checked' : '' }}"></span>
                        </td>
                    </tr>
                @endforeach

                <!-- Header Faktor Komorbid -->
                <tr>
                    <td colspan="4"
                        style="background-color: #f5f5f5; font-weight: bold; text-align: left; padding: 6px;">
                        <strong>FAKTOR KOMORBID</strong>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: left; padding: 4px 6px;">
                        <strong>Mempunyai riwayat:</strong>
                    </td>
                </tr>

                @php
                    $komorbidList = [
                        'hipertensi' => 'Hipertensi',
                        'diabetes' => 'Diabetes Mellitus',
                        'jantung' => 'Jantung',
                        'ginjal' => 'Ginjal',
                        'hemodialisis' => 'Riwayat hemodialisis',
                        'usia_50' => 'Usia > 50 Tahun',
                    ];
                    $komorbidData = $covidData->komorbid_decoded ?? [];
                @endphp

                @foreach ($komorbidList as $key => $label)
                    <tr>
                        <td class="no-col">{{ $loop->iteration }}</td>
                        <td class="no-border-left no-border-right" style="text-align: left; padding: 4px 8px;">
                            • {{ $label }}
                        </td>
                        <td class="no-col" style="text-align: center;">
                            <span
                                class="checkbox {{ isset($komorbidData[$key]) && $komorbidData[$key] == 1 ? 'checked' : '' }}"></span>
                        </td>
                        <td style="text-align: center;">
                            <span
                                class="checkbox {{ !isset($komorbidData[$key]) || $komorbidData[$key] != 1 ? 'checked' : '' }}"></span>
                        </td>
                    </tr>
                @endforeach

                @media print {
                .page-break {
                page-break-before: always;
                }
                }
            </tbody>
        </table>

        <!-- Cara Penilaian -->
        <div class="penilaian-section">
            <div class="penilaian-title">CARA PENILAIAN (Cocokan dengan temuan pada gejala dan faktor risiko)</div>

            <table class="penilaian-table">
                <thead>
                    <tr>
                        <th style="width: 33.33%;">KONTAK ERAT</th>
                        <th style="width: 33.33%;">SUSPEK</th>
                        <th style="width: 33.33%;">NON SUSPEK</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="criteria-cell">
                            Tanpa gejala + Faktor risiko utama no. 2 (Kasus konfirmasi*/ Probable**)
                        </td>
                        <td class="criteria-cell">
                            • Gejala No.1 atau No.2 + Faktor risiko utama No.1 atau No.2<br>
                            • Gejala No.1 atau No.2 + Faktor risiko utama No.2 (kasus konfirmasi*)<br>
                            • Gejala No.4 DAN tidak ada penyebab lain berdasarkan gambaran klinis yang meyakinkan.
                        </td>
                        <td class="criteria-cell">
                            Tidak memenuhi kriteria kontak erat, kasus suspek.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Kesimpulan -->
        <div class="kesimpulan-section">
            <div class="kesimpulan-title">KESIMPULAN (beri tanda centang pada kolom yang sesuai)</div>

            <table class="kesimpulan-table">
                <tr>
                    <th style="width: 33.33%;">KONTAK ERAT</th>
                    <th style="width: 33.33%;">SUSPEK</th>
                    <th style="width: 33.33%;">NON SUSPEK</th>
                </tr>
                <tr>
                    <td>
                        <span class="checkbox {{ $covidData->kesimpulan == 'kontak_erat' ? 'checked' : '' }}"></span>
                    </td>
                    <td>
                        <span class="checkbox {{ $covidData->kesimpulan == 'suspek' ? 'checked' : '' }}"></span>
                    </td>
                    <td>
                        <span class="checkbox {{ $covidData->kesimpulan == 'non_suspek' ? 'checked' : '' }}"></span>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Tindak Lanjut -->
        <div class="tindak-lanjut">
            <div class="tindak-lanjut-title">TINDAK LANJUT:</div>
            <div class="tindak-lanjut-item"><strong>Kontak erat</strong> : Rujuk ke pelayanan COVID-19 (IGD PIE)</div>
            <div class="tindak-lanjut-item"><strong>SUSPEK</strong> : Rujuk ke pelayanan COVID-19 (IGD PIE)</div>
            <div class="tindak-lanjut-item"><strong>NON SUSPEK</strong>: Lanjut ke pelayanan Non COVID-19
                (IGD/Poliklinik/ Rawat Inap Non PIE)</div>
        </div>

        <!-- Declaration -->
        <div class="declaration">
            Demikian pernyataan ini saya sampaikan dengan sebenar-benarnya. Saya menyadari pemberian informasi yang
            tidak sesuai dengan yang sebenarnya dapat dikenakan sa
        </div>

        <!-- Location and Date -->
        <div class="location-date">
            Kota Langsa, <span
                class="underline">{{ $covidData->tanggal ? $covidData->tanggal->format('d') : '.....' }}</span>,
            <span
                class="underline">{{ $covidData->tanggal ? $covidData->tanggal->format('F') : '............' }}</span>,
            <span class="underline">{{ $covidData->tanggal ? $covidData->tanggal->format('Y') : '20....' }}</span>
        </div>

        <!-- Signatures -->
        <table class="signature-table">
            <tr>
                <td>
                    @if ($covidData->persetujuan_untuk == 'keluarga')
                        <div class="signature-label">Keluarga pasien</div>
                    @else
                        <div class="signature-label">Pasien/pendamping</div>
                    @endif
                    <div class="signature-box"></div>
                    <div class="signature-name">
                        @if ($covidData->persetujuan_untuk == 'keluarga' && $covidData->nama_keluarga)
                            ({{ $covidData->nama_keluarga }})
                        @else
                            ({{ $dataMedis->pasien->nama ?? '.....................................' }})
                        @endif
                    </div>
                    <div style="font-size: 7px;">Nama lengkap dan TTD</div>
                </td>
                <td>
                    <div class="signature-label">Petugas skrining</div>
                    <div class="signature-box"></div>
                    <div class="signature-name">
                        ({{ $covidData->userCreate->name ?? '.....................................' }})
                    </div>
                    <div style="font-size: 7px;">Nama lengkap dan TTD</div>
                </td>
            </tr>
        </table>

        <!-- Notes -->
        <div class="note-section" style="font-size: 10px;">
            <div class="note-title">Ket:</div>
            <div><strong>Kasus konfirmasi:</strong> Seseorang yang dinyatakan positif virus COVID-19 berdasarkan
                pemeriksaan laboratorium RT-PCR.</div>
            <div><strong>Kasus Probable :</strong> Kasus suspek ISPA/ARDS/meninggal dengan gambaran klinis yang
                meyakinkan COVID-19 dan belum ada hasil pemeriksaan.</div>
        </div>
    </div>

    <!-- PAGE 2: INFORMED CONSENT -->
    <div class="page-break">
        <!-- Header for Page 2 -->
        <div class="header">
            <div class="header-content">
                <div class="logo-section">
                    <div class="logo-box">
                        @if (file_exists(public_path('assets/img/Logo-RSUD-Langsa-1.png')))
                            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/Logo-RSUD-Langsa-1.png'))) }}"
                                style="width: 50px; height: 50px;" alt="Logo RSUD Langsa">
                        @else
                            LOGO
                        @endif
                    </div>
                    <div class="hospital-name">RSUD LANGSA</div>
                    <div class="hospital-address">
                        Jl. Jend. A. Yani. Kota Langsa<br>
                        Telp: 0641- 22051<br>
                        email: rsudlangsa.aceh@gmail.com
                    </div>
                </div>

                <div class="title-section">
                    <h1 class="main-title">INFORMED CONCENT KEWASPADAAN COVID-19</h1>
                </div>

                <div class="patient-info">
                    <table class="patient-table">
                        <tr>
                            <td class="label">No RM</td>
                            <td>{{ $dataMedis->pasien->kd_pasien ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Nama</td>
                            <td>{{ $dataMedis->pasien->nama ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Jenis Kelamin</td>
                            <td>
                                @if (isset($dataMedis->pasien->jenis_kelamin))
                                    {{ $dataMedis->pasien->jenis_kelamin == 1 ? 'Laki-laki' : 'Perempuan' }}
                                @else
                                    Laki-laki / Perempuan *
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Tanggal Lahir</td>
                            <td>{{ $dataMedis->pasien->tgl_lahir ? date('d/m/Y', strtotime($dataMedis->pasien->tgl_lahir)) : '' }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Informed Consent Content -->
        <div class="content">
            <div class="dasar-section">
                <div class="dasar-title" style="font-size: 12px;">Dasar:</div>
                <ol class="dasar-list" style="font-size: 12px;">
                    <li>Instruksi Presiden Republik Indonesia Indonesia Nomor 6 Tahun 2020 tentang Peningkatan Disiplin
                        dan Penegakan Hukum Protokol Kesehatan dalam Pencegahan dan Pengendalian Corona Virus Disease
                        2019;</li>
                    <li>Keputusan Menteri Kesehatan No.HK.01.07 /MENKES/413/2020 tentang Pedoman Pencegahan dan
                        Pengendalian COVID-19;</li>
                    <li>Keputusan Gubernur Aceh Nomor 360/969/2020 tentang Penetapan Status Tanggap Darurat Skala
                        Provinsi untuk Penanganan Corona Virus Disease 2019;</li>
                    <li>Peraturan Walikota Langsa Nomor 31 Tentang Penerapan Disiplin dan Penegakan Hukum Protokol
                        Kesehatan Sebagai Upaya Pencegehan dan Pengendalian Corona Virus Disease 2019 di Kota Langsa
                    </li>
                </ol>
            </div>

            <div class="maka-section">
                <div class="maka-title" style="font-size: 12px;">Maka:</div>
                <div class="maka-content" style="font-size: 12px;">
                    Dalam rangka menindaklanjuti Kebijakan Pemerintah untuk Penegakan Protokol Kesehatan dalam
                    Pencegahan dan Pengendalian COVID-19, maka RSUD Kota Langsa akan melakukan Skrining (penapisan)
                    COVID-19 yang terdiri dari anamnesa, pemeriksaan laboratorium dan radiologi bagi semua pasien yang
                    akan dilayani. Bila dari hasil pemeriksaan tersebut, pasien diduga terinfeksi COVID-19 maka:
                </div>
                <ol class="maka-list" style="font-size: 12px;">
                    <li>Akan dilakukan pemeriksaan SWAB RT-PCR yang akan dikirim ke Laboratorium yang mampu melakukan
                        pemeriksaan RT-PCR;</li>
                    <li>Selama menunggu hasil, pasien akan dirawat di Ruang PINERE;</li>
                    <li>TIDAK BOLEH didampingi/dibesuk, kecuali bagi pasien dengan kondisi tidak dapat mandiri dapat
                        didampingi 1 (satu) orang keluarga yang sehat;</li>
                    <li>Pendamping juga ikut diisolasi bersama pasien di kamar dan tidak boleh keluar masuk selama
                        pasien dirawat;</li>
                    <li>Jika Pasien meninggal selama perawatan meskipun hasil SWAB Test belum keluar, pasien akan
                        dimakamkan secara Protokol Covid-19;</li>
                    <li>Dalam proses Pemulasaran Jenazah, jika Keluarga ingin berpartisipasi dalam kegiatan
                        tersebutkeluarga dekat (sehat) dapat mengikuti proses tersebut dengan menggunakan APO Level 3
                        yang disediakan Ru mah Sakit maksimal 2 (dua) orang</li>
                </ol>
            </div>

            <div class="persetujuan-section" style="font-size: 12px;">
                Dengan ini Saya dan telah menendapat penjelasan dan memahami penjelasan tersebut di atas dan menyatakan
                <strong>{{ $covidData->persetujuan === 'setuju' ? 'SETUJU' : 'TIDAK SETUJU' }}</strong> untuk setiap
                hal yang ditetapkan RSUD Langsa di atas.
            </div>

            <!-- Signature Section for Page 2 -->
            <div class="location-date" style="font-size: 12px;">
                Langsa, tanggal: <span
                    class="underline">{{ $covidData->tanggal ? $covidData->tanggal->format('d/m/Y') : '................' }}</span>
                Jam: <span
                    class="underline">{{ $covidData->jam_formatted ? $covidData->jam_formatted : '........' }}</span>
            </div>

            <table class="signature-table-page2">
                <tr>
                    <td>
                        @if ($covidData->persetujuan_untuk == 'keluarga')
                            <div class="signature-label" style="font-size: 12px;">Keluarga pasien:</div>
                        @else
                            <div class="signature-label" style="font-size: 12px;">Pasien:</div>
                        @endif
                        <div class="signature-box-page2"></div>
                        <div class="signature-name" style="font-size: 12px;">
                            @if ($covidData->persetujuan_untuk == 'keluarga' && $covidData->nama_keluarga)
                                ({{ $covidData->nama_keluarga }})
                            @else
                                ({{ $dataMedis->pasien->nama ?? '.....................................' }})
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="signature-label" style="font-size: 12px;">Saksi:</div>
                        <div class="signature-box-page2"></div>
                        <div class="signature-name" style="font-size: 12px;">
                            ({{ $covidData->nama_saksi1 ?? '.....................................' }})
                        </div>
                    </td>
                    <td>
                        <div class="signature-label" style="font-size: 12px;">Yang menjelaskan:</div>
                        <img src="{{ generateQrCode($covidData->userCreate->name, 100, 'svg_datauri') }}"
                            alt="QR">
                        <div class="label-barcode"></div>
                        <div class="signature-name" style="font-size: 12px;">
                            ({{ $covidData->userCreate->name ?? '.....................................' }})
                        </div>
                    </td>
                </tr>
            </table>

        </div>
    </div>
</body>

</html>
