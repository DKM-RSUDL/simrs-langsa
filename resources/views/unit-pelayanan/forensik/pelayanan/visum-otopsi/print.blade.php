<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visum et Repertum Otopsi - {{ $visumOtopsi->nomor ?? 'No Number' }}</title>
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
            font-size: 11pt;
            line-height: 1.3;
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
            margin-bottom: 15px;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
        }

        .logo-section {
            display: table-cell;
            width: 80px;
            vertical-align: middle;
            text-align: center;
            padding: 5px;
        }

        .logo {
            width: 70px;
            height: 70px;
            object-fit: contain;
        }

        .hospital-info {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
            padding: 5px 15px;
        }

        .hospital-name {
            font-size: 11pt;
            font-weight: bold;
            margin: 0 0 5px 0;
            line-height: 1.2;
            text-transform: uppercase;
        }

        .hospital-address {
            font-size: 10pt;
            margin: 2px 0;
            line-height: 1.1;
        }

        .hospital-address a {
            color: #000;
            text-decoration: underline;
        }

        .city-logo {
            display: table-cell;
            width: 80px;
            vertical-align: middle;
            text-align: center;
            padding: 5px;
        }

        .city-logo img {
            width: 70px;
            height: 70px;
            object-fit: contain;
        }

        /* Document Info */
        .doc-info {
            margin: 15px 0;
            font-size: 11pt;
        }

        .doc-info p {
            margin: 3px 0;
            text-align: left;
        }

        /* Title Section */
        .title-section {
            margin: 20px 0;
        }

        .pro-justitia {
            text-align: left;
            font-size: 11pt;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .visum-title {
            text-align: center;
            font-size: 11pt;
            font-weight: bold;
            text-decoration: underline;
            margin: 8px 0;
        }

        .visum-number {
            text-align: center;
            font-size: 11pt;
            font-weight: normal;
            margin-bottom: 15px;
        }

        /* Opening Statement */
        .opening-statement {
            text-align: justify;
            margin: 15px 0;
            line-height: 1.4;
        }

        /* Patient Data Section */
        .patient-data {
            margin: 15px 0;
        }

        .patient-data table {
            width: 100%;
            border-collapse: collapse;
        }

        .patient-data td {
            padding: 3px 0;
            vertical-align: top;
        }

        .patient-data .label {
            width: 150px;
            font-weight: normal;
        }

        .patient-data .colon {
            width: 15px;
            text-align: center;
        }

        .patient-data .value {
            border-bottom: 1px solid #000;
            min-height: 16px;
        }

        /* Section Headers */
        .section-header {
            font-size: 11pt;
            font-weight: bold;
            margin: 20px 0 10px 0;
            text-align: left;
        }

        .subsection-header {
            font-size: 11pt;
            font-weight: bold;
            margin: 15px 0 8px 0;
            text-decoration: underline;
        }

        /* Content Sections */
        .content-section {
            margin: 10px 0;
            text-align: justify;
        }

        .content-item {
            margin: 6px 0;
            line-height: 1.4;
        }

        .content-label {
            font-weight: normal;
            display: inline;
        }

        .content-value {
            display: inline;
        }

        .numbered-list {
            counter-reset: item;
            list-style: none;
            padding-left: 0;
        }

        .numbered-list > li {
            counter-increment: item;
            margin: 8px 0;
        }

        .numbered-list > li:before {
            content: counter(item) ". ";
            font-weight: bold;
        }

        .sub-list {
            list-style: none;
            padding-left: 20px;
        }

        .sub-list li {
            margin: 4px 0;
            position: relative;
        }

        .sub-list li:before {
            content: "- ";
            position: absolute;
            left: -15px;
        }

        /* Continuation header */
        .continuation-header {
            text-align: right;
            margin-bottom: 8px;
            font-size: 10pt;
        }

        /* Conclusion Section */
        .conclusion-section {
            margin: 20px 0;
        }

        .conclusion-header {
            font-size: 11pt;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .conclusion-item {
            margin: 8px 0;
            text-align: justify;
            line-height: 1.4;
        }

        /* Signature Section */
        .signature-section {
            margin-top: 30px;
            text-align: left;
        }

        .closing-statement {
            text-align: justify;
            margin: 15px 0;
            line-height: 1.4;
        }

        .doctor-signature {
            margin-top: 25px;
            text-align: left;
        }

        .doctor-title {
            font-weight: normal;
            margin-bottom: 50px;
        }

        .doctor-name {
            font-weight: bold;
            text-decoration: underline;
        }

        .doctor-nip {
            margin-top: 3px;
        }

        /* Utilities */
        .page-break {
            page-break-before: always;
        }

        .no-break {
            page-break-inside: avoid;
        }

        .dotted-line {
            border-bottom: 1px dotted #000;
            display: inline-block;
            min-width: 200px;
            min-height: 14px;
        }

        .fill-space {
            display: inline-block;
            border-bottom: 1px solid #000;
            min-width: 150px;
            min-height: 14px;
            margin: 0 3px;
        }

        .multi-line {
            white-space: pre-line;
        }

        .text-justify {
            text-align: justify;
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
                <p class="hospital-name">INSTALASI KEDOKTERAN FORENSIK RUMAH SAKIT UMUM DAERAH LANGSA</p>
                <p class="hospital-address"><strong>JL.A.Yani No.1 A</strong></p>
                <p class="hospital-address"><strong>Telp.064122051 Fax.064122051 Email: <a href="mailto:rsulangsa@gmail.com">rsulangsa@gmail.com</a> Langsa Kota</strong></p>
            </div>
            <div class="city-logo">
                <img src="{{ public_path('assets/img/logo-kota-langsa.png') }}" alt="Logo Kota Langsa" class="logo">
            </div>
        </div>

        <!-- Document Info -->
        <div class="doc-info">
            <p>Langsa, {{ $visumOtopsi->tanggal ? \Carbon\Carbon::parse($visumOtopsi->tanggal)->format('Y') : date('Y') }}</p>
            <p><br></p>
            <p>Nomor : {{ $visumOtopsi->nomor ?? 'VER/OTOPSI/' . date('Y/m/d') }}</p>
            <p>Perihal : {{ $visumOtopsi->perihal ?? 'Permintaan visum' }}</p>
            <p>Lampiran : {{ $visumOtopsi->lampiran ?? '-' }}</p>
        </div>

        <!-- Title Section -->
        <div class="title-section no-break">
            <div class="pro-justitia">PRO JUSTITIA</div>
            <div class="visum-title">VISUM ET REPERTUM</div>
        </div>

        <!-- Opening Statement -->
        <div class="opening-statement no-break">
            Yang bertanda tangan di bawah ini adalah dokter <strong>{{ $visumOtopsi->userCreated->name ?? 'Dr.dr.Netty Herawati, M.ked(For), Sp.F.M.,M.H' }}</strong> 
            dokter Spesialis Forensik pada Instalasi Kedokteran Forensik dan Medikolegal RSUD Langsa berdasarkan surat permintaan 
            visum et repertum dari {{ $visumOtopsi->perihal ?? 'kepolisian Negara Republik Indonesia' }} 
            Nomor : <strong>{{ $visumOtopsi->lampiran ?? 'B/67/I/Res.1.7/2022' }}</strong> 
            tertanggal <strong>{{ $visumOtopsi->tanggal ? \Carbon\Carbon::parse($visumOtopsi->tanggal)->format('d F Y') : date('d F Y') }}</strong> 
            menerangkan pada tanggal <strong>{{ $visumOtopsi->tanggal ? \Carbon\Carbon::parse($visumOtopsi->tanggal)->format('d F Y') : date('d F Y') }}</strong> 
            pukul {{ $visumOtopsi->jam ?? '00.00' }} Waktu Indonesia Barat bertempat di Instalasi Forensik dan Medikolegal 
            Rumah Sakit Umum Daerah Langsa telah melakukan pemeriksaan pada korban dengan nomor rekam medik 
            <strong>{{ $dataMedis->kd_pasien }}</strong> yang menurut surat tersebut adalah:
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
                        @if($dataMedis->pasien->tgl_lahir)
                            {{ \Carbon\Carbon::parse($dataMedis->pasien->tgl_lahir)->age }} tahun
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="label">Jenis Kelamin</td>
                    <td class="colon">:</td>
                    <td class="value">{{ $dataMedis->pasien->jenis_kelamin == 1 ? 'Laki-laki' : ($dataMedis->pasien->jenis_kelamin == 0 ? 'Perempuan' : 'Tidak Diketahui') }}</td>
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

        <!-- Page break for continuation -->
        <div class="page-break"></div>

        <!-- Continuation Header -->
        <div class="continuation-header">
            Lanjutan hasil visum nomor {{ $visumOtopsi->nomor ?? 'VER/OTOPSI/' . date('Y/m/d') }}<br>
            Halaman ke 2 dari 5 halaman
        </div>

        <!-- Results Section -->
        <ol class="numbered-list">
            <!-- Wawancara Section -->
            <li>
                <strong>WAWANCARA</strong>
                <div class="content-section" style="margin-left: 20px;">
                    @if($visumOtopsi->wawancara)
                        {!! $visumOtopsi->wawancara !!}
                    @else
                        Korban tiba di Instalasi Forensik RSUD Kota Langsa dalam keadaan sudah meninggal dibawa oleh penyidik dan keluarga menggunakan mobil ambulance pada tanggal {{ $visumOtopsi->tanggal ? \Carbon\Carbon::parse($visumOtopsi->tanggal)->format('d F Y') : date('d F Y') }} pukul {{ $visumOtopsi->jam ?? '00.00' }} Waktu Indonesia Barat. <span class="dotted-line"></span>
                    @endif
                </div>
            </li>

            <!-- Pemeriksaan Luar Section -->
            <li>
                <strong>PEMERIKSAAN LUAR</strong>
                
                <ol style="margin-left: 20px; counter-reset: subletter; list-style: none;">
                    <li style="counter-increment: subletter;">
                        <strong>Penutup mayat</strong>
                        <ul class="sub-list">
                            @if($visumOtopsi->penutup_mayat)
                                <li>{!! $visumOtopsi->penutup_mayat !!}</li>
                            @else
                                <li>Dijumpai <span class="fill-space"></span></li>
                                <li>Dijumpai <span class="fill-space"></span></li>
                                <li>Dijumpai <span class="fill-space"></span></li>
                            @endif
                        </ul>
                    </li>

                    <li style="counter-increment: subletter;">
                        <strong>Label mayat:</strong>
                        <ul class="sub-list">
                            @if($visumOtopsi->label_mayat)
                                <li>{!! $visumOtopsi->label_mayat !!}</li>
                            @else
                                <li>Tidak dijumpai label mayat <span class="dotted-line"></span></li>
                            @endif
                        </ul>
                    </li>

                    <li style="counter-increment: subletter;">
                        <strong>Pakaian mayat:</strong>
                        <ul class="sub-list">
                            @if($visumOtopsi->pakaian_mayat)
                                <li>{!! $visumOtopsi->pakaian_mayat !!}</li>
                            @else
                                <li>Dijumpai baju <span class="fill-space"></span></li>
                                <li>Dijumpai celana <span class="fill-space"></span></li>
                                <li>Dijumpai celana dalam <span class="fill-space"></span></li>
                            @endif
                        </ul>
                    </li>

                    <li style="counter-increment: subletter;">
                        <strong>Benda disamping mayat :</strong>
                        @if($visumOtopsi->benda_disamping)
                            {!! $visumOtopsi->benda_disamping !!}
                        @else
                            tidak dijumpai. <span class="dotted-line"></span>
                        @endif
                    </li>

                    <li style="counter-increment: subletter;">
                        <strong>Aksesoris:</strong>
                        @if($visumOtopsi->aksesoris)
                            {!! $visumOtopsi->aksesoris !!}
                        @else
                            tidak dijumpai. <span class="dotted-line"></span>
                        @endif
                    </li>
                </ol>
            </li>

            <!-- Page break for continuation -->
            <div class="page-break"></div>
            
            <!-- Continuation Header -->
            <div class="continuation-header">
                Lanjutan hasil visum nomor {{ $visumOtopsi->nomor ?? 'VER/OTOPSI/' . date('Y/m/d') }}<br>
                Halaman ke 3 dari 5 halaman
            </div>

            <!-- Identifikasi Umum -->
            <li>
                <strong>IDENTIFIKASI UMUM</strong>
                <ol style="margin-left: 20px; counter-reset: subletter; list-style: none;">
                    <li style="counter-increment: subletter;">
                        @if($visumOtopsi->identifikasi_umum_keterangan)
                            {!! $visumOtopsi->identifikasi_umum_keterangan !!}
                        @else
                            Dijumpai sesosok mayat yang dikenal, yang ditutupi dengan beberapa lapis kain berjenis kelamin {{ $dataMedis->pasien->jenis_kelamin == 1 ? 'laki-laki' : 'perempuan' }} dengan panjang badan <span class="fill-space"></span>, berpostur <span class="fill-space"></span>, berambut <span class="fill-space"></span> warna <span class="fill-space"></span>, dengan kulit tubuh berwarna <span class="fill-space"></span> <span class="dotted-line"></span>
                        @endif
                    </li>

                    <li style="counter-increment: subletter;">
                        <strong>Tanda-tanda Kematian</strong>
                        <ul class="sub-list">
                            @if($visumOtopsi->tanda_kematian)
                                <li>{!! $visumOtopsi->tanda_kematian !!}</li>
                            @else
                                <li>Dijumpai lebam mayat pada bagian <span class="fill-space"></span> yang tidak hilang pada penekanan. <span class="dotted-line"></span></li>
                                <li>Dijumpai kaku mayat pada <span class="fill-space"></span> yang sulit dilawan dan kaku mayat pada anggota gerak lainnya yang mudah dilawan. <span class="dotted-line"></span></li>
                                <li>Dijumpai pucat kebiruan pada <span class="fill-space"></span> <span class="dotted-line"></span></li>
                            @endif
                        </ul>
                    </li>
                </ol>
            </li>

            <!-- Identifikasi Khusus -->
            <li>
                <strong>IDENTIFIKASI KHUSUS</strong>
                <ul class="sub-list" style="margin-left: 20px;">
                    @if($visumOtopsi->identifikasi_khusus_keterangan)
                        <li>{!! $visumOtopsi->identifikasi_khusus_keterangan !!}</li>
                    @else
                        <li>Dijumpai <span class="fill-space"></span> <span class="dotted-line"></span></li>
                    @endif
                </ul>
            </li>

            <!-- Hasil Pemeriksaan Luar -->
            <li>
                <strong>HASIL PEMERIKSAAN LUAR</strong>

                <ol style="margin-left: 20px; list-style: none;">
                    <li>
                        <span style="font-weight: bold;">5.1 Kepala</span>
                        <ul class="sub-list">
                            @if($visumOtopsi->kepala_luar)
                                <li>{!! $visumOtopsi->kepala_luar !!}</li>
                            @else
                                <li>Dijumpai <span class="fill-space"></span> <span class="dotted-line"></span></li>
                            @endif
                        </ul>
                    </li>

                    <li>
                        <span style="font-weight: bold;">5.2 Wajah</span>
                        <ul class="sub-list">
                            @if($visumOtopsi->wajah)
                                <li>{!! $visumOtopsi->wajah !!}</li>
                            @else
                                <li>Dijumpai <span class="fill-space"></span> <span class="dotted-line"></span></li>
                            @endif
                        </ul>
                    </li>

                    <li>
                        <span style="font-weight: bold;">5.3 Mata</span>
                        <ul class="sub-list">
                            @if($visumOtopsi->mata)
                                <li>{!! $visumOtopsi->mata !!}</li>
                            @else
                                <li>Dijumpai <span class="fill-space"></span> <span class="dotted-line"></span></li>
                            @endif
                        </ul>
                    </li>

                    <li>
                        <span style="font-weight: bold;">5.4 Mulut</span>
                        <ul class="sub-list">
                            @if($visumOtopsi->mulut)
                                <li>{!! $visumOtopsi->mulut !!}</li>
                            @else
                                <li>Dijumpai <span class="fill-space"></span> <span class="dotted-line"></span></li>
                            @endif
                        </ul>
                    </li>

                    <li>
                        <span style="font-weight: bold;">5.5 Leher</span>
                        <ul class="sub-list">
                            @if($visumOtopsi->leher_luar)
                                <li>{!! $visumOtopsi->leher_luar !!}</li>
                            @else
                                <li>Dijumpai <span class="fill-space"></span> <span class="dotted-line"></span></li>
                            @endif
                        </ul>
                    </li>

            <!-- Page break for continuation -->
            <div class="page-break"></div>
            
            <!-- Continuation Header -->
            <div class="continuation-header">
                Lanjutan hasil visum nomor {{ $visumOtopsi->nomor ?? 'VER/OTOPSI/' . date('Y/m/d') }}<br>
                Halaman ke 4 dari 5 halaman
            </div>

                    <li>
                        <span style="font-weight: bold;">5.6 Dada :</span>
                        @if($visumOtopsi->dada_luar)
                            {!! $visumOtopsi->dada_luar !!}
                        @else
                            Tidak dijumpai tanda-tanda kekerasan. <span class="dotted-line"></span>
                        @endif
                    </li>

                    <li>
                        <span style="font-weight: bold;">5.7 Punggung :</span>
                        @if($visumOtopsi->punggung)
                            {!! $visumOtopsi->punggung !!}
                        @else
                            Tidak dijumpai tanda-tanda kekerasan. <span class="dotted-line"></span>
                        @endif
                    </li>

                    <li>
                        <span style="font-weight: bold;">5.8 Perut :</span>
                        @if($visumOtopsi->perut_luar)
                            {!! $visumOtopsi->perut_luar !!}
                        @else
                            Dijumpai perut <span class="fill-space"></span> <span class="dotted-line"></span>
                        @endif
                    </li>

                    <li>
                        <span style="font-weight: bold;">5.9 Anggota gerak Atas</span>
                        <ul class="sub-list">
                            @if($visumOtopsi->anggota_gerak_atas)
                                <li>{!! $visumOtopsi->anggota_gerak_atas !!}</li>
                            @else
                                <li>tidak dijumpai tanda-tanda kekerasan. <span class="dotted-line"></span></li>
                            @endif
                        </ul>
                    </li>

                    <li>
                        <span style="font-weight: bold;">5.10 Anggota Gerak bawah :</span>
                        @if($visumOtopsi->anggota_gerak_bawah)
                            {!! $visumOtopsi->anggota_gerak_bawah !!}
                        @else
                            tidak dijumpai tanda-tanda kekerasan. <span class="dotted-line"></span>
                        @endif
                    </li>

                    <li>
                        <span style="font-weight: bold;">5.11 Kemaluan :</span>
                        <ul class="sub-list">
                            @if($visumOtopsi->kemaluan)
                                <li>{!! $visumOtopsi->kemaluan !!}</li>
                            @else
                                <li>Tidak dijumpai tanda-tanda kekerasan. <span class="dotted-line"></span></li>
                            @endif
                        </ul>
                    </li>

                    <li>
                        <span style="font-weight: bold;">5.12 Anus :</span>
                        @if($visumOtopsi->anus)
                            {!! $visumOtopsi->anus !!}
                        @else
                            Dijumpai <span class="fill-space"></span> <span class="dotted-line"></span>
                        @endif
                    </li>
                </ol>
            </li>

            <!-- Hasil Pemeriksaan Dalam -->
            <li>
                <strong>HASIL PEMERIKSAAN DALAM</strong>
                
                <ol style="margin-left: 20px; list-style: none;">
                    <li>
                        <span style="font-weight: bold;">6.1 Kepala</span>
                        <ul class="sub-list">
                            @if($visumOtopsi->kepala_dalam)
                                <li>{!! $visumOtopsi->kepala_dalam !!}</li>
                            @else
                                <li>Pada pembukaan kulit kepala <span class="fill-space"></span> <span class="dotted-line"></span></li>
                            @endif
                        </ul>
                    </li>

                    <li>
                        <span style="font-weight: bold;">6.2 Leher</span>
                        <ul class="sub-list">
                            @if($visumOtopsi->leher_dalam)
                                <li>{!! $visumOtopsi->leher_dalam !!}</li>
                            @else
                                <li>Dijumpai <span class="fill-space"></span> <span class="dotted-line"></span></li>
                            @endif
                        </ul>
                    </li>

                    <li>
                        <span style="font-weight: bold;">6.3 Dada</span>
                        <ul class="sub-list">
                            @if($visumOtopsi->dada_dalam)
                                <li>{!! $visumOtopsi->dada_dalam !!}</li>
                            @else
                                <li>Pada pembukaan kulit dada <span class="fill-space"></span> <span class="dotted-line"></span></li>
                            @endif
                        </ul>
                    </li>
            
            <!-- Page break for conclusion -->
            <div class="page-break"></div>
            
            <!-- Conclusion Page Header -->
            <div class="continuation-header">
                Lanjutan hasil visum nomor {{ $visumOtopsi->nomor ?? 'VER/OTOPSI/' . date('Y/m/d') }}<br>
                Halaman ke 5 dari 5 halaman
            </div>

                    <li>
                        <span style="font-weight: bold;">6.4 Perut</span>
                        <ul class="sub-list">
                            @if($visumOtopsi->perut_dalam)
                                <li>{!! $visumOtopsi->perut_dalam !!}</li>
                            @else
                                <li>Pada pembukaan kantong lambung <span class="fill-space"></span> <span class="dotted-line"></span></li>
                            @endif
                        </ul>
                    </li>
                </ol>
            </li>
        </ol>

        <!-- Conclusion Section -->
        <div class="conclusion-section">
            <div class="conclusion-header"><strong>KESIMPULAN</strong></div>

            <div class="conclusion-item">
                @if($visumOtopsi->kesimpulan)
                    {!! $visumOtopsi->kesimpulan !!}
                @else
                    <p class="text-justify">
                        Pada pemeriksaan luar dan dalam sesosok mayat dikenal berjenis kelamin 
                        {{ $dataMedis->pasien->jenis_kelamin == 1 ? 'laki-laki' : 'perempuan' }} 
                        berusia 
                        @if($dataMedis->pasien->tgl_lahir)
                            {{ \Carbon\Carbon::parse($dataMedis->pasien->tgl_lahir)->age }} tahun
                        @else
                            <span class="fill-space"></span> tahun
                        @endif
                        dengan panjang badan <span class="fill-space"></span> centimeter, 
                        memakai <span class="fill-space"></span>, berambut <span class="fill-space"></span> 
                        berwarna <span class="fill-space"></span> dan berkulit <span class="fill-space"></span> 
                        ini dijumpai <span class="dotted-line"></span>
                    </p>

                    <p class="text-justify" style="margin-top: 10px;">
                        Berdasarkan hasil pemeriksaan dalam pada tubuh korban cara kematian korban 
                        <span class="fill-space"></span>, luka yang berperan dalam kematian adalah 
                        <span class="dotted-line"></span> dengan perkiraan lama kematian 
                        <span class="fill-space"></span> dari saat pemeriksaan dilakukan 
                        <span class="dotted-line"></span>
                    </p>
                @endif
            </div>
        </div>

        <!-- Closing Section -->
        <div class="closing-statement">
            Demikianlah Visum et Repertum ini saya perbuat dengan sejujur-jujurnya dan menggunakan 
            pengetahuan saya sebaik-baiknya, sesuai dengan sumpah dokter dan perundang-undangan yang berlaku 
            agar dipergunakan bilamana perlu. <span class="dotted-line"></span>
        </div>

        <!-- Signature Section -->
        <div class="signature-section">
            <div class="doctor-signature">
                <div class="doctor-title">Dokter Pemeriksa,</div>
                <div class="doctor-name">{{ $visumOtopsi->userCreated->name ?? 'Dr.dr. Netty Herawati,M.Ked(For),Sp.F.M.,M.H' }}</div>
                <div class="doctor-nip">NIP.{{ $visumOtopsi->userCreated->nip ?? '' }}</div>
            </div>
        </div>
    </div>
</body>

</html>