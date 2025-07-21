<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Covid 19 - {{ $dataMedis->pasien->nama ?? 'Pasien' }}</title>
    <style>
        @page {
            margin: 1.5cm 1cm 1cm 1cm;
            size: A4 portrait;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            line-height: 1.3;
            color: #000;
            margin: 0;
            padding: 0;
        }

        .header {
            width: 100%;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .header-content {
            display: table;
            width: 100%;
        }

        .logo-section {
            display: table-cell;
            width: 15%;
            vertical-align: middle;
            text-align: center;
        }

        .title-section {
            display: table-cell;
            width: 50%;
            vertical-align: middle;
            text-align: center;
            padding: 0 10px;
        }

        .patient-info {
            display: table-cell;
            width: 35%;
            vertical-align: top;
        }

        .logo-box {
            width: 60px;
            height: 60px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8px;
        }

        .hospital-name {
            font-size: 10px;
            font-weight: bold;
            margin-top: 5px;
        }

        .hospital-address {
            font-size: 8px;
            margin-top: 2px;
        }

        .main-title {
            font-size: 16px;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
        }

        .form-number {
            font-size: 9px;
            margin-top: 5px;
        }

        .patient-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
        }

        .patient-table td {
            border: 1px solid #000;
            padding: 3px 5px;
            vertical-align: top;
        }

        .patient-table .label {
            background-color: #f5f5f5;
            font-weight: bold;
            width: 30%;
        }

        .content {
            margin-top: 20px;
            clear: both;
        }

        .section {
            margin-bottom: 15px;
        }

        .section-title {
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 8px;
            text-align: center;
            text-transform: uppercase;
        }

        .table-form {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .table-form th,
        .table-form td {
            border: 1px solid #000;
            padding: 4px 6px;
            text-align: left;
            vertical-align: middle;
        }

        .table-form th {
            background-color: #f5f5f5;
            font-weight: bold;
            text-align: center;
        }

        .table-form .no-col {
            width: 8%;
            text-align: center;
        }

        .table-form .item-col {
            width: 62%;
        }

        .table-form .ya-col,
        .table-form .tidak-col {
            width: 15%;
            text-align: center;
        }

        .checkbox {
            width: 12px;
            height: 12px;
            border: 1px solid #000;
            display: inline-block;
            text-align: center;
            line-height: 10px;
            font-weight: bold;
        }

        .checkbox.checked {
            background-color: #000;
            color: white;
        }

        .checkbox.checked::after {
            content: "✓";
            font-size: 8px;
        }

        .date-input {
            border-bottom: 1px solid #000;
            display: inline-block;
            min-width: 80px;
            text-align: center;
            padding: 2px;
        }

        .komorbid-section {
            margin: 15px 0;
        }

        .komorbid-title {
            font-weight: bold;
            margin-bottom: 10px;
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
            padding: 3px 10px;
            vertical-align: top;
        }

        .komorbid-item {
            margin-bottom: 5px;
        }

        .penilaian-section {
            margin: 20px 0;
        }

        .penilaian-table {
            width: 100%;
            border-collapse: collapse;
        }

        .penilaian-table th,
        .penilaian-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
            vertical-align: top;
        }

        .penilaian-table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }

        .penilaian-table .criteria-cell {
            text-align: left;
            font-size: 10px;
        }

        .kesimpulan-section {
            margin: 20px 0;
            text-align: center;
        }

        .kesimpulan-table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }

        .kesimpulan-table th,
        .kesimpulan-table td {
            border: 1px solid #000;
            padding: 10px;
            text-align: center;
        }

        .kesimpulan-table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }

        .tindak-lanjut {
            margin: 20px 0;
            padding: 10px;
            border: 1px solid #000;
        }

        .tindak-lanjut-title {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .signature-section {
            margin-top: 30px;
            page-break-inside: avoid;
        }

        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .signature-table td {
            border: none;
            padding: 10px;
            text-align: center;
            vertical-align: top;
            width: 50%;
        }

        .signature-box {
            height: 60px;
            border-bottom: 1px solid #000;
            margin-bottom: 5px;
            margin-top: 10px;
        }

        .signature-label {
            font-size: 10px;
            font-weight: bold;
        }

        .location-date {
            margin: 20px 0;
            text-align: center;
        }

        .underline {
            border-bottom: 1px solid #000;
            display: inline-block;
            min-width: 100px;
            padding-bottom: 2px;
            text-align: center;
        }

        .page-break {
            page-break-before: always;
        }

        .note-section {
            margin-top: 20px;
            font-size: 9px;
        }

        .note-title {
            font-weight: bold;
        }

        @media print {
            .page-break {
                page-break-before: always;
            }
        }
    </style>
</head>

<body>
    <!-- Header Section -->
    <div class="header">
        <div class="header-content">
            <div class="logo-section">
                <div class="logo-box">
                    @if(file_exists(public_path('assets/img/Logo-RSUD-Langsa-1.png')))
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
                <div class="form-number">F.11/IRM/Rev 0/2020</div>
            </div>

            <div class="patient-info">
                <table class="patient-table">
                    <tr>
                        <td class="label">No RM</td>
                        <td>{{ $dataMedis->pasien->kd_pasien ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Nama</td>
                        <td>{{ $dataMedis->pasien->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Jenis Kelamin</td>
                        <td>
                            @if(isset($dataMedis->pasien->jenis_kelamin))
                                {{ $dataMedis->pasien->jenis_kelamin == 1 ? 'Laki-laki' : 'Perempuan' }}
                            @else
                                Laki-laki / Perempuan
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Tanggal Lahir</td>
                        <td>{{ $dataMedis->pasien->tgl_lahir ? date('d/m/Y', strtotime($dataMedis->pasien->tgl_lahir)) : '-' }}</td>
                    </tr>
                </table>
                <div style="font-size: 8px; font-style: italic; margin-top: 5px;">
                    (mohon diisi atau tempelkan stiker jika ada)
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">
        <!-- Instructions -->
        <div style="margin-bottom: 15px; font-weight: bold;">
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
                        'gejala_lain' => 'Gejala lainnya: Gangguan pemciuman/ Gangguan pengecapan/ Mual/ Muntah/ Nyeri perut/ Diare'
                    ];
                    $gejalaData = $covidData->gejala_decoded ?? [];
                @endphp

                @foreach($gejalaList as $key => $label)
                <tr>
                    <td class="no-col">{{ $loop->iteration }}</td>
                    <td class="item-col">{{ $label }}</td>
                    <td class="ya-col">
                        <span class="checkbox {{ isset($gejalaData[$key]) && $gejalaData[$key] == 1 ? 'checked' : '' }}"></span>
                    </td>
                    <td class="tidak-col">
                        <span class="checkbox {{ !isset($gejalaData[$key]) || $gejalaData[$key] != 1 ? 'checked' : '' }}"></span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Tanggal Gejala -->
        <div style="margin-bottom: 20px;">
            <strong>Tanggal pertama timbul gejala:</strong>
            <span class="date-input">{{ $covidData->tgl_gejala ? $covidData->tgl_gejala->format('d') : '' }}</span> /
            <span class="date-input">{{ $covidData->tgl_gejala ? $covidData->tgl_gejala->format('m') : '' }}</span> /
            <span class="date-input">{{ $covidData->tgl_gejala ? $covidData->tgl_gejala->format('Y') : '' }}</span>
        </div>

        <!-- Faktor Risiko Section -->
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
                        'perjalanan' => 'Riwayat perjalanan/ tinggal di daerah transmisi lokal dalam < 14 hari terakhir',
                        'kontak_erat' => 'Kontak erat* dengan kasus konformasi** /Suspek***/Probable**** COVID-19 dalam 14 hari terakhir'
                    ];
                    $risikoData = $covidData->faktor_risiko_decoded ?? [];
                @endphp

                @foreach($risikoList as $key => $label)
                <tr>
                    <td class="no-col">{{ $loop->iteration }}</td>
                    <td class="item-col">
                        {{ $label }}
                        @if($key == 'perjalanan' && $covidData->lokasi_perjalanan)
                            <br><strong>Sebutkan Negara/ Propinsi/ Kota:</strong> {{ $covidData->lokasi_perjalanan }}
                        @elseif($key == 'perjalanan')
                            <br>Sebutkan Negara/ Propinsi/ Kota: ...............................
                        @endif
                    </td>
                    <td class="ya-col">
                        <span class="checkbox {{ isset($risikoData[$key]) && $risikoData[$key] == 1 ? 'checked' : '' }}"></span>
                    </td>
                    <td class="tidak-col">
                        <span class="checkbox {{ !isset($risikoData[$key]) || $risikoData[$key] != 1 ? 'checked' : '' }}"></span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Faktor Komorbid -->
        <div class="komorbid-section">
            <div class="komorbid-title">FAKTOR KOMORBID</div>
            <div style="margin-bottom: 10px;"><strong>Mempunyai riwayat:</strong></div>

            @php
                $komorbidList = [
                    'hipertensi' => 'Hipertensi',
                    'diabetes' => 'Diabetes Mellitus',
                    'jantung' => 'Jantung',
                    'ginjal' => 'Ginjal',
                    'hemodialisis' => 'Riwayat hemodialisis',
                    'usia_50' => 'Usia > 50 Tahun'
                ];
                $komorbidData = $covidData->komorbid_decoded ?? [];
            @endphp

            <div class="komorbid-list">
                @foreach(array_chunk($komorbidList, 2, true) as $chunk)
                <div class="komorbid-row">
                    @foreach($chunk as $key => $label)
                    <div class="komorbid-col">
                        <div class="komorbid-item">
                            <span class="checkbox {{ isset($komorbidData[$key]) && $komorbidData[$key] == 1 ? 'checked' : '' }}"></span>
                            {{ $label }}
                        </div>
                    </div>
                    @endforeach
                </div>
                @endforeach
            </div>
        </div>

        <!-- Cara Penilaian -->
        <div class="penilaian-section">
            <div style="font-weight: bold; margin-bottom: 10px;">CARA PENILAIAN (Cocokan dengan temuan pada gejala dan faktor risiko)</div>

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
            <div style="font-weight: bold; margin-bottom: 10px;">KESIMPULAN (beri tanda centang pada kolom yang sesuai)</div>

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
            <div><strong>Kontak erat</strong> : Rujuk ke pelayanan COVID-19 (IGD PIE)</div>
            <div><strong>SUSPEK</strong> : Rujuk ke pelayanan COVID-19 (IGD PIE)</div>
            <div><strong>NON SUSPEK</strong>: Lanjut ke pelayanan Non COVID-19 (IGD/Poliklinik/ Rawat Inap Non PIE)</div>
        </div>

        <!-- Declaration -->
        <div style="margin: 20px 0; text-align: justify; line-height: 1.5;">
            Demikian pernyataan ini saya sampaikan dengan sebenar-benarnya. Saya menyadari pemberian informasi yang tidak sesuai dengan yang sebenarnya dapat dikenakan sanksi menurut Undang-undang yang berlaku.
        </div>

        <!-- Location and Date -->
        <div class="location-date">
            Kota Langsa, <span class="underline">{{ $covidData->tanggal ? $covidData->tanggal->format('d') : '.....' }}</span>,
            <span class="underline">{{ $covidData->tanggal ? $covidData->tanggal->format('F') : '............' }}</span>,
            <span class="underline">{{ $covidData->tanggal ? $covidData->tanggal->format('Y') : '20....' }}</span>
        </div>

        <!-- Signatures -->
        <table class="signature-table">
            <tr>
                <td>
                    @if($covidData->persetujuan_untuk == 'keluarga')
                        <div class="signature-label">Keluarga pasien</div>
                    @else
                        <div class="signature-label">Pasien/pendamping</div>
                    @endif
                    <div class="signature-box"></div>
                    <div style="margin-top: 5px;">
                        @if($covidData->persetujuan_untuk == 'keluarga' && $covidData->nama_keluarga)
                            ({{ $covidData->nama_keluarga }})
                        @else
                            ({{ $dataMedis->pasien->nama ?? '.....................................' }})
                        @endif
                    </div>
                    <div style="font-size: 9px;">Nama lengkap dan TTD</div>
                </td>
                <td>
                    <div class="signature-label">Petugas skrining</div>
                    <div class="signature-box"></div>
                    <div style="margin-top: 5px;">
                        ({{ $covidData->userCreate->name ?? '.....................................' }})
                    </div>
                    <div style="font-size: 9px;">Nama lengkap dan TTD</div>
                </td>
            </tr>
        </table>

        <!-- Notes -->
        <div class="note-section">
            <div class="note-title">Ket:</div>
            <div><strong>Kasus konfirmasi:</strong> Seseorang yang dinyatakan positif virus COVID-19 berdasarkan pemeriksaan laboratorium RT-PCR.</div>
            <div><strong>Kasus Probable :</strong> Kasus suspek ISPA/ARDS/meninggal dengan gambaran klinis yang meyakinkan COVID-19 dan belum ada hasil pemeriksaan.</div>
        </div>
    </div>

    <!-- Page 2: Informed Consent -->
    <div class="page-break">
        <!-- Header for Page 2 -->
        <div class="header">
            <div class="header-content">
                <div class="logo-section">
                    <div class="logo-box">
                        @if(file_exists(public_path('assets/img/Logo-RSUD-Langsa-1.png')))
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
                    <h1 class="main-title">INFORMED CONSENT KEWASPADAAN COVID-19</h1>
                    <div class="form-number">F.11/IRM/Rev 0/2020</div>
                </div>

                <div class="patient-info">
                    <table class="patient-table">
                        <tr>
                            <td class="label">No RM</td>
                            <td>{{ $dataMedis->pasien->kd_pasien ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Nama</td>
                            <td>{{ $dataMedis->pasien->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Jenis Kelamin</td>
                            <td>
                                @if(isset($dataMedis->pasien->jenis_kelamin))
                                    {{ $dataMedis->pasien->jenis_kelamin == 1 ? 'Laki-laki' : 'Perempuan' }}
                                @else
                                    Laki-laki / Perempuan *
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Tanggal Lahir</td>
                            <td>{{ $dataMedis->pasien->tgl_lahir ? date('d/m/Y', strtotime($dataMedis->pasien->tgl_lahir)) : '-' }}</td>
                        </tr>
                    </table>
                    <div style="font-size: 8px; font-style: italic; margin-top: 5px;">
                        (mohon diisi atau tempelkan stiker jika ada)
                    </div>
                </div>
            </div>
        </div>

        <!-- Informed Consent Content -->
        <div class="content">
            <div style="margin-bottom: 15px;">
                <div style="font-weight: bold; margin-bottom: 10px;">Dasar:</div>
                <ol style="margin-left: 20px; line-height: 1.5;">
                    <li>Instruksi Presiden Republik Indonesia Indonesia Nomor 6 Tahun 2020 tentang Peningkatan Disiplin dan Penegakan Hukum Protokol Kesehatan dalam Pencegahan dan Pengendalian Corona Virus Disease 2019;</li>
                    <li>Keputusan Menteri Kesehatan No.HK.01.07 /MENKES/413/2020 tentang Pedoman Pencegahan dan Pengendalian COVID-19;</li>
                    <li>Keputusan Gubernur Aceh Nomor 360/969/2020 tentang Penetapan Status Tanggap Darurat Skala Provinsi untuk Penanganan Corona Virus Disease 2019;</li>
                    <li>Peraturan Walikota Langsa Nomor 31 Tentang Penerapan Disiplin dan Penegakan Hukum Protokol Kesehatan Sebagai Upaya Pencegahan dan Pengendalian Corona Virus Disease 2019 di Kota Langsa.</li>
                </ol>
            </div>

            <div style="margin-bottom: 15px;">
                <div style="font-weight: bold; margin-bottom: 10px;">Maka:</div>
                <div style="text-align: justify; line-height: 1.5; margin-bottom: 10px;">
                    Dalam rangka menindaklanjuti Kebijakan Pemerintah untuk Penegakan Protokol Kesehatan dalam Pencegahan dan Pengendalian COVID-19, maka RSUD Kota Langsa akan melakukan Skrining (penapisan) COVID-19 yang terdiri dari anamnesa, pemeriksaan laboratorium dan radiologi bagi semua pasien yang akan dilayani. Bila dari hasil pemeriksaan tersebut, pasien diduga terinfeksi COVID-19 maka:
                </div>
                <ol style="margin-left: 20px; line-height: 1.5;">
                    <li>Akan dilakukan pemeriksaan SWAB RT-PCR yang akan dikirim ke Laboratorium yang mampu melakukan pemeriksaan RT-PCR;</li>
                    <li>Selama menunggu hasil, pasien akan dirawat di Ruang PINERE;</li>
                    <li>TIDAK BOLEH didampingi/dibesuk, kecuali bagi pasien dengan kondisi tidak dapat mandiri dapat didampingi 1 (satu) orang keluarga yang sehat;</li>
                    <li>Pendamping juga ikut diisolasi bersama pasien di kamar dan tidak boleh keluar masuk selama pasien dirawat;</li>
                    <li>Jika Pasien meninggal selama perawatan meskipun hasil</li>
                </ol>
            </div>
        </div>
    </div>
</body>
</html>
