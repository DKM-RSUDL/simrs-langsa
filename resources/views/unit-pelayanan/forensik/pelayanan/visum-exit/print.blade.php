<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visum et Repertum - {{ $visumExit->nomor_ver }}</title>
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
            margin-top: 40px;
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
                <p class="hospital-name">INSTALASI KEDOKTERAN FORENSIK RUMAH SAKIT<br>UMUM DAERAH LANGSA</p>
                <p class="hospital-address">JL.A.Yani No.1 A</p>
                <p class="hospital-address">Telp.064122051 Fax.064122051 Email: <a href="mailto:rsulangsa@gmail.com">rsulangsa@gmail.com</a></p>
                <p class="hospital-address">Langsa Kota</p>
            </div>
            <div class="city-logo">
                <img src="{{ public_path('assets/img/logo-kota-langsa.png') }}" alt="Logo Kota Langsa" class="logo">
            </div>
        </div>

        <!-- Date and Location -->
        <div class="date-location">
            Langsa, {{ $visumExit->tanggal ? \Carbon\Carbon::parse($visumExit->tanggal)->format('d F Y') : date('d F Y') }}
        </div>

        <!-- Title Section -->
        <div class="title-section no-break">
            <div class="pro-justitia">PRO JUSTITIA</div>
            <div class="visum-title">VISUM ET REPERTUM</div>
            <div class="visum-number">{{ $visumExit->nomor_ver }}</div>
        </div>

        <!-- Opening Statement -->
        <div class="opening-statement no-break">
            Yang bertanda tangan di bawah ini
            <strong>{{ $visumExit->dokter->nama_lengkap ?? $visumExit->dokter_pemeriksa ?? 'Dr.dr.Netty Herawati, M.ked(For), Sp.F.M.,M.H' }}</strong>
            dokter pada Rumah Sakit Umum Daerah Langsa, atas permintaan dari
            {{ $visumExit->permintaan ?? 'kepolisian Resor langsa' }} nomor
            <strong style="color: #d32f2f;">{{ $visumExit->nomor_surat ?? 'B/49/XII/2024/LL' }}</strong>,
            tertanggal <strong style="color: #d32f2f;"> {{ $visumExit->tanggal ? \Carbon\Carbon::parse($visumExit->tanggal)->format('d F Y') : date('d F Y') }} </strong>,
            maka dengan ini menerangkan bahwa pada tanggal
            <strong style="color: #d32f2f;">{{ $visumExit->menerangkan }}</strong>
            Waktu Indonesia Barat, bertempat di Instalasi Forensik dan Medikolegal RSUD Langsa, telah
            melakukan pemeriksaan korban dengan nomor registrasi
            <strong style="color: #d32f2f;">{{ $visumExit->registrasi ?? $dataMedis->kd_pasien }}</strong> yang menurut surat tersebut
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
                    <td class="label">Tempat/tanggal lahir</td>
                    <td class="colon">:</td>
                    <td class="value">
                        {{ $dataMedis->pasien->tempat_lahir ?? '' }}
                        @if($dataMedis->pasien->tgl_lahir)
                            / {{ \Carbon\Carbon::parse($dataMedis->pasien->tgl_lahir)->format('d F Y') }}
                        @endif
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

        <!-- Results Section -->
        <div class="section-header">HASIL PEMERIKSAAN</div>

        <!-- Interview Section -->
        @if($visumExit->wawancara)
        <div class="subsection-header">WAWANCARA</div>
        <div class="content-section">
            {!! $visumExit->wawancara !!}
        </div>
        @else
        <div class="subsection-header">WAWANCARA</div>
        <div class="content-section">
            Telah ditemukan jenazah berjenis kelamin {{ $dataMedis->jk == 'L' ? 'laki-laki' : 'perempuan' }} <span class="dotted-line"></span>
        </div>
        @endif

        <!-- External Examination Section -->
        <div class="subsection-header">PEMERIKSAAN LUAR</div>

        <div class="content-section">
            <div class="content-item">
                <span class="content-label">Label mayat :</span>
                <span class="content-value">
                    @if($visumExit->label_mayat)
                        {!! $visumExit->label_mayat!!}
                    @else
                        Tidak dijumpai label mayat. <span class="dotted-line"></span>
                    @endif
                </span>
            </div>

            <div class="content-item">
                <span class="content-label">Pembungkus mayat :</span>
                <span class="content-value">
                    @if($visumExit->pembungkus_mayat)
                        {!! $visumExit->pembungkus_mayat !!}
                    @else
                        Tidak ada. <span class="dotted-line"></span>
                    @endif
                </span>
            </div>

            <div class="content-item">
                <span class="content-label">Benda disamping mayat :</span>
                <span class="content-value">
                    @if($visumExit->benda_disamping)
                        {!! $visumExit->benda_disamping !!}
                    @else
                        Tidak ada. <span class="dotted-line"></span>
                    @endif
                </span>
            </div>

            <div class="content-item">
                <span class="content-label">Penutup mayat :</span>
                <span class="content-value">
                    @if($visumExit->penutup_mayat)
                        {!! $visumExit->penutup_mayat !!}
                    @else
                        <span class="dotted-line"></span><br>
                        Dijumpai <span class="fill-space"></span>
                    @endif
                </span>
            </div>

            <div class="content-item">
                <span class="content-label">Pakaian mayat :</span>
                <span class="content-value">                    
                    @if($visumExit->pakaian_mayat)
                        {!! $visumExit->pakaian_mayat !!}
                    @else
                        <span class="dotted-line"></span><br>
                        Dijumpai pakaian baju <span class="fill-space"></span><br>
                        Dijumpai celana <span class="fill-space"></span><br>
                        Dijumpai celana dalam <span class="fill-space"></span>
                    @endif
                </span>
            </div>
        </div>

        <!-- Page break for continuation -->
        <div class="page-break"></div>

        <!-- Continuation Header -->
        <div style="text-align: right; margin-bottom: 10px; font-size: 10pt;">
            Lanjutan {{ $visumExit->nomor_ver }}<br>
            Halaman ke 2 dari 3 halaman
        </div>

        <div class="content-section">
            <div class="content-item">
                <span class="content-label">Perhiasan mayat :</span>
                <span class="content-value">
                    @if($visumExit->perhiasan_mayat)
                        {!! $visumExit->perhiasan_mayat !!}
                    @else
                        <span class="dotted-line"></span><br>
                        Tidak ada <span class="dotted-line"></span>
                    @endif
                </span>
            </div>

            <div class="content-item">
                <span class="content-label">Identifikasi umum :</span>
                <span class="content-value">
                    @if($visumExit->identifikasi_umum)
                        {!! $visumExit->identifikasi_umum !!}
                    @else
                        <span class="dotted-line"></span><br>
                        Dijumpai mayat yang dikenal, berjenis kelamin {{ $dataMedis->jk == 'L' ? 'laki-laki' : 'perempuan' }} dengan tinggi badan <span class="fill-space"></span>,
                        berpostur sedang, berambut <span class="fill-space"></span> warna <span class="fill-space"></span>, dengan kulit tubuh berwarna <span class="fill-space"></span>
                    @endif
                </span>
            </div>

            <div class="content-item">
                <span class="content-label">Identifikasi Khusus :</span>
                <span class="content-value">
                    @if($visumExit->identifikasi_khusus)
                        {!! $visumExit->identifikasi_khusus !!}
                    @else
                        <span class="dotted-line"></span><br>
                        Dijumpai <span class="fill-space"></span>
                    @endif
                </span>
            </div>

            <div class="content-item">
                <span class="content-label">Tanda-tanda kematian :</span>
                <span class="content-value">
                    @if($visumExit->tanda_kematian)
                        {!! $visumExit->tanda_kematian !!}
                    @else
                        <span class="dotted-line"></span><br>
                        Dijumpai Bola mata hitam melebar kanan dan kiri. <span class="dotted-line"></span><br>
                        Dijumpai Bola mata putih ditemukan bintik-bintik merah kanan dan kiri <span class="dotted-line"></span><br>
                        Dijumpai Lebam mayat pada leher belakang (sulit dinilai) <span class="dotted-line"></span><br>
                        Dijumpai Lebam mayat di pinggang kiri (hilang dengan penekanan) <span class="dotted-line"></span><br>
                        Dijumpai kaku mayat yang sulit dilawan pada rahang, kedua tangan dan kaki dan
                        pada perabaan suhu tubuh teraba dingin. <span class="dotted-line"></span><br>
                        Mata kanan dan kiri tidak dijumpai tanda-tanda kekerasan. <span class="dotted-line"></span>
                    @endif
                </span>
            </div>

            <div class="content-item">
                <span class="content-label">Gigi-geligi :</span>
                <span class="content-value">
                    @if($visumExit->gigi_geligi)
                        {!! $visumExit->gigi_geligi !!}
                    @else
                        <span class="fill-space"></span> <span class="dotted-line"></span>
                    @endif
                </span>
            </div>

            <div class="content-item">
                <span class="content-label">Luka-luka :</span>
                <span class="content-value">
                    @if($visumExit->luka_luka)
                        {!! $visumExit->luka_luka !!}
                    @else
                        <span class="dotted-line"></span><br>
                        a. Dijumpai luka <span class="fill-space"></span><br>
                        b. Dijumpai <span class="fill-space"></span><br>
                        c. Dijumpai <span class="fill-space"></span>
                    @endif
                </span>
            </div>
        </div>

        <!-- Page break for conclusion -->
        <div class="page-break"></div>

        <!-- Conclusion Page Header -->
        <div style="text-align: right; margin-bottom: 10px; font-size: 10pt;">
            Lanjutan {{ $visumExit->nomor_ver }}<br>
            Halaman ke 3 dari 3 halaman
        </div>

        <!-- Conclusion Section -->
        <div class="conclusion-section">
            <div class="conclusion-header">KESIMPULAN :</div>

            <div class="conclusion-item">
                <strong>Pada jenazah {{ $dataMedis->jk == 'L' ? 'Laki-laki' : 'Perempuan' }},</strong>
                @if($visumExit->pada_jenazah)
                    {!! $visumExit->pada_jenazah !!}
                @else
                    <span class="fill-space"></span>
                @endif
            </div>

            <div class="conclusion-item">
                <strong>Pada pemeriksaan luar :</strong><br>
                @if($visumExit->pemeriksaan_luar_kesimpulan)
                    {!! $visumExit->pemeriksaan_luar_kesimpulan !!}
                @else
                    Dijumpai <span class="fill-space"></span> <span class="dotted-line"></span>
                @endif
            </div>

            <div class="conclusion-item">
                <strong>Dari hasil pemeriksaan luar disimpulkan :</strong><br>
                @if($visumExit->hasil_kesimpulan)
                    {!! $visumExit->hasil_kesimpulan !!}
                @else
                    Perkiraan lama kematian kurang dari enam jam dari saat pemeriksaan. <span class="dotted-line"></span><br>
                    Cara kematian korban wajar. <span class="dotted-line"></span><br>
                    Penyebab kematian tidak dapat ditentukan karena tidak dilakukan pemeriksaan dalam
                    sesuai dengan permintaan visum nomor <span class="dotted-line"></span>
                @endif
            </div>
        </div>

        <!-- Closing Section -->
        <div class="section-header" style="margin-top: 30px;">PENUTUP</div>

        <div class="closing-statement">
            Demikianlah visum et repertum ini dibuat dengan sebenarnya dengan menggunakan keilmuan yang sebaik-baiknya, mengingat sumpah sesuai dengan Kitab Undang-undang Acara Pidana
        </div>

        <!-- Signature Section -->
        <div class="signature-section">
            <div class="doctor-signature">
                <div class="doctor-title">Dokter Pemeriksa,</div>
                <div class="doctor-name">{{ $visumExit->dokter->nama_lengkap ?? $visumExit->dokter_pemeriksa ?? 'Dr.dr. Netty Herawati,M.Ked(For),Sp.F.M.,M.H' }}</div>
                <div class="doctor-nip">NIP.{{ $visumExit->dokter->nip ?? '' }}</div>
            </div>
        </div>
    </div>
</body>

</html>
