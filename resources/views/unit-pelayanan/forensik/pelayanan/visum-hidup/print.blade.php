<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visum et Repertum - {{ $visumHidup->nomor_ver }}</title>
    <style>
        @page {
            margin: 1.5cm 2cm;
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

        body {
            font-family: 'Times New Roman', serif;
            margin: 0;
            padding: 0;
            font-size: 12pt;
            line-height: 1.4;
            color: #000;
        }

        .container {
            width: 100%;
            padding: 0;
        }

        /* Header Styles */
        .header {
            display: table;
            width: 100%;
            margin-bottom: 20px;
            border-bottom: 3px solid #000;
            padding-bottom: 15px;
        }

        .logo-section {
            display: table-cell;
            width: 100px;
            vertical-align: middle;
            text-align: center;
            padding: 10px;
        }

        .logo {
            width: 80px;
            height: 80px;
            object-fit: contain;
        }

        .hospital-info {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
            padding: 10px 20px;
        }

        .hospital-name {
            font-size: 12pt;
            font-weight: bold;
            margin: 0 0 8px 0;
            line-height: 1.3;
            text-transform: uppercase;
        }

        .hospital-address {
            font-size: 11pt;
            margin: 3px 0;
            line-height: 1.2;
        }

        .hospital-address a {
            color: #000;
            text-decoration: underline;
        }

        .city-logo {
            display: table-cell;
            width: 100px;
            vertical-align: middle;
            text-align: center;
            padding: 10px;
        }

        .city-logo img {
            width: 80px;
            height: 80px;
            object-fit: contain;
        }

        /* Date and Location */
        .date-location {
            text-align: right;
            margin: 20px 0;
            font-size: 12pt;
        }

        /* Title Section */
        .title-section {
            /* text-align: center; */
            margin: 25px 0;
        }

        .pro-justitia {
            text-align: start;
            font-size: 12pt;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .visum-title {
            text-align: center;
            font-size: 12pt;
            font-weight: bold;
            text-decoration: underline;
            margin: 10px 0;
        }

        .visum-number {
            text-align: center;
            font-size: 12pt;
            font-weight: bold;
            color: #d32f2f;
            margin-bottom: 20px;
        }

        /* Opening Statement */
        .opening-statement {
            text-align: justify;
            margin: 20px 0;
            line-height: 1.5;
        }

        /* Patient Data Section */
        .patient-data {
            margin: 20px 0;
        }

        .patient-data table {
            width: 100%;
            border-collapse: collapse;
        }

        .patient-data td {
            padding: 5px 0;
            vertical-align: top;
        }

        .patient-data .label {
            width: 200px;
            font-weight: normal;
        }

        .patient-data .colon {
            width: 20px;
            text-align: center;
        }

        .patient-data .value {
            border-bottom: 1px solid #000;
            min-height: 20px;
        }

        /* Section Headers */
        .section-header {
            font-size: 12pt;
            font-weight: bold;
            margin: 25px 0 15px 0;
            text-align: start;
        }

        .subsection-header {
            font-size: 12pt;
            font-weight: bold;
            margin: 20px 0 10px 0;
            text-decoration: underline;
        }

        /* Content Sections */
        .content-section {
            margin: 15px 0;
            text-align: justify;
        }

        .content-item {
            margin: 8px 0;
            line-height: 1.5;
        }

        .content-label {
            font-weight: bold;
            display: inline-block;
            width: 300px;
        }

        .content-value {
            display: inline;
        }

        /* Conclusion Section */
        .conclusion-section {
            margin: 25px 0;
        }

        .conclusion-header {
            font-size: 14pt;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 15px;
        }

        .conclusion-item {
            margin: 12px 0;
            text-align: justify;
            line-height: 1.5;
        }

        /* Signature Section */
        .signature-section {
            margin-top: 20px;
            text-align: center;
        }

        .closing-statement {
            text-align: justify;
            margin: 20px 0;
            line-height: 1.5;
        }

        .doctor-signature {
            margin-top: 30px;
            text-align: center;
        }

        .doctor-title {
            font-weight: bold;
            margin-bottom: 60px;
        }

        .doctor-name {
            font-weight: bold;
            text-decoration: underline;
        }

        .doctor-nip {
            margin-top: 5px;
        }

        /* Utilities */
        .text-center {
            text-align: center;
        }

        .text-justify {
            text-align: justify;
        }

        .font-bold {
            font-weight: bold;
        }

        .underline {
            text-decoration: underline;
        }

        .page-break {
            page-break-before: always;
        }

        .no-break {
            page-break-inside: avoid;
        }

        /* Dotted lines for filling */
        .dotted-line {
            border-bottom: 1px dotted #000;
            display: inline-block;
            min-width: 300px;
            min-height: 18px;
        }

        .fill-space {
            display: inline-block;
            border-bottom: 1px solid #000;
            min-width: 200px;
            min-height: 18px;
            margin: 0 5px;
        }

        /* Multi-line content */
        .multi-line {
            white-space: pre-line;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header Section -->
        <div class="header no-break">
            <div class="logo-section">
                <img src="{{ public_path('assets/img/Logo-RSUD-Langsa-1.png') }}" alt="Logo RSUD Langsa" class="logo">
            </div>
            <div class="hospital-info">
                <p class="hospital-name">PEMERINTAH KOTA LANGSA INSTALASI KEDOKTERAN FORENSIK DAN MEDIKOLEGAL RUMAH SAKIT UMUM DAERAH LANGSA</p>
                <p class="hospital-address">Alamat : Jln. Jend. A. Yani No.1 Kota Langsa – Provinsi Aceh Telp. (0641) 22800 (IGD) - Fax. (0641) 22051, WA. 08116800288 E-mail : rsudlangsa.aceh@gmail.com, rsud@langsakota.go.id </p>
                <p class="hospital-address"><a href="mailto:rsulangsa@gmail.com">rsulangsa@gmail.com</a></p>
            </div>
            <div class="city-logo">
                <img src="{{ public_path('assets/img/logo-kota-langsa.png') }}" alt="Logo Kota Langsa" class="logo">
            </div>
        </div>

        <!-- Date and Location -->
        <div class="date-location">
            Langsa, {{ $visumHidup->tanggal ? \Carbon\Carbon::parse($visumHidup->tanggal)->format('d F Y') : date('d F Y') }}
        </div>

        <!-- Title Section -->
        <div class="title-section no-break">
            <div class="pro-justitia">PRO JUSTITIA</div>
            <div class="visum-title">VISUM ET REPERTUM</div>
            <div class="visum-number">{{ $visumHidup->nomor_ver }}</div>
        </div>

        <!-- Opening Statement -->
        <div class="opening-statement no-break">
            Yang bertanda tangan di bawah ini
            <strong>{{ $visumHidup->dokter->nama_lengkap ?? $visumHidup->dokter_pemeriksa ?? '' }}</strong>
            dokter pada Rumah Sakit Umum Daerah Langsa, atas permintaan dari
            {{ $visumHidup->permintaan ?? '' }} nomor
            <strong style="color: #d32f2f;">{{ $visumHidup->nomor_surat ?? 'B/49/XII/2024/LL' }}</strong>,
            tertanggal <strong style="color: #d32f2f;"> {{ $visumHidup->tanggal ? \Carbon\Carbon::parse($visumHidup->tanggal)->format('d F Y') : date('d F Y') }} </strong>,
            maka dengan ini menerangkan bahwa pada tanggal
            <strong style="color: #d32f2f;">{{ $visumHidup->menerangkan }}</strong>
            Waktu Indonesia Barat, bertempat di RSUD Langsa, telah melakukan pemeriksaan korban dengan nomor registrasi 
            <strong style="color: #d32f2f;">{{ $visumHidup->registrasi ?? $dataMedis->kd_pasien }}</strong> yang menurut surat tersebut
            adalah : <span class="dotted-line"></span>
        </div>

        <!-- Patient Data Section -->
        <div class="patient-data no-break">
            <table>
                <tr>
                    <td class="label">Nama</td>
                    <td class="colon">:</td>
                    <td class="value">{{ $dataMedis->pasien->nama ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label">Umur</td>
                    <td class="colon">:</td>
                    <td class="value">
                        {{ $dataMedis->pasien->umur ?? 'Tidak Diketahui' }} Tahun
                    </td>
                </tr>
                <tr>
                    <td class="label">Jenis Kelamin</td>
                    <td class="colon">:</td>
                    <td class="value">{{ $dataMedis->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                </tr>
                <tr>
                    <td class="label">Suku/Agama</td>
                    <td class="colon">:</td>
                    <td class="value">
                        {{ $dataMedis->pasien->suku->suku ?? '' }} / {{ $dataMedis->pasien->agama->agama ?? '' }}
                    </td>
                </tr>
                <tr>
                    <td class="label">Pekerjaan</td>
                    <td class="colon">:</td>
                    <td class="value">{{ $dataMedis->pasien->pekerjaan->pekerjaan ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label">Alamat</td>
                    <td class="colon">:</td>
                    <td class="value">{{ $dataMedis->pasien->alamat ?? '' }}</td>
                </tr>
            </table>
        </div>

        <!-- Interview Section -->
        @if($visumHidup->hasil_pemeriksaan)
        <div class="subsection-header">HASIL PEMERIKSAAN :</div>
        <div class="content-section">
            {!! $visumHidup->hasil_pemeriksaan !!}
        </div>
        @else
            <ol type="1">
                <li>
                    Korban ini datang dengan keadaan sadar penuh, dengan keadaan umum baik.--------------
                </li>
                <li>
                    Korban datang ke IGD RSUD Langsa xxxxxxxxxxxxxxxxxxxxxx ---------------------------
                </li>
                <li>
                    Pada korban ditemukan : ---------------------------------------------------------------------------- <br>
                    •	Pada xxxxxxxxx .----------------------------------------------------------------------
                </li>
            </ol>
        @endif

        @if($visumHidup->hasil_kesimpulan)
        <div class="subsection-header">KESIMPULAN  :</div>
        <div class="content-section">
            {!! $visumHidup->hasil_kesimpulan !!}
        </div>
        @else
            <div>
                KESIMPULAN : <br>
                Pada korban laki-laki/perepuan berusia xxx tahun ini, didapatkan luka xxx pada xxxx akibat trauma tumpul. Keadaan tersebut tidak menimbulkan penyakit atau halangan dalam menjalankan pekerjaan jabatan/pencaharian.------------------------------------------------------
            </div>
        @endif

        <div class="closing-statement">
            Demikianlah visum et repertum ini dibuat dengan sebenarnya dengan menggunakan keilmuan yang sebaik-baiknya, mengingat sumpah sesuai dengan Kitab Undang-undang Acara Pidana.---
        </div>

        <!-- Signature Section -->
        <div class="signature-section">
            <div class="doctor-signature">
                <div class="doctor-title">Dokter Pemeriksa,</div>
                <div class="doctor-name">{{ $visumHidup->dokter->nama_lengkap ?? $visumHidup->dokter_pemeriksa ?? '' }}</div>
                <div class="doctor-nip">NIP.{{ $visumHidup->dokter->nip ?? '' }}</div>
            </div>
        </div>
    </div>
</body>

</html>
