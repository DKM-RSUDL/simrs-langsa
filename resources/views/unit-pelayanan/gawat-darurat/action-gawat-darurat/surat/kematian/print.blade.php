<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Surat Keterangan Kematian</title>
    <style>
        @page {
            margin: 20px 35px;
            size: 21cm 29.7cm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11pt;
            line-height: 1.2;
            margin: 0;
            padding: 0;
        }

        /* Header */
        .header-container {
            position: relative;
            width: 100%;
            height: 105px;
            border-bottom: 1.5px solid black;
            margin-bottom: 12px;
        }

        .logo-container {
            position: absolute;
            top: 0;
            left: 20pt;
            width: 80px;
        }

        .header-content {
            margin-left: 75px;
            text-align: center;
        }

        .header-title {
            font-size: 12pt;
            font-weight: bold;
            margin: 0;
            padding: 0;
        }

        .header-subtitle {
            font-size: 16pt;
            font-weight: bold;
            margin: 0;
            padding: 0;
        }

        .header-address {
            font-size: 9pt;
            margin: 2px;
            padding: 0;
            line-height: 1.0;
        }

        /* Document Title */
        .title {
            font-size: 12pt;
            font-weight: bold;
            text-align: center;
            margin: 5px 0 3px 0;
        }

        .doc-number {
            font-size: 9pt;
            text-align: center;
            margin-bottom: 5px;
        }

        /* Content Styling */
        .content p {
            text-align: justify;
            margin: 4px 0;
            font-size: 12pt;
        }

        /* Patient Data Table */
        .patient-data {
            width: 100%;
            margin: 5px 0 5px 50px;
            border-collapse: collapse;
        }

        .patient-data td {
            padding: 3px 0;
            vertical-align: top;
            font-size: 12pt;
        }

        .patient-data td:first-child {
            width: 120px;
            padding-left: 15px;
        }

        .patient-data td:nth-child(2) {
            width: 10px;
            text-align: center;
        }
        
        .patient-data td:nth-child(3) {
            padding-left: 5px;
        }

        /* Diagnosis Table */
        .diagnosis-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid black;
            margin: 15px 0;
        }
        
        .diagnosis-table th, 
        .diagnosis-table td {
            border: 1px solid black;
            padding: 3px 5px;
            font-size: 10pt;
            vertical-align: top;
        }
        
        .diagnosis-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        
        /* Signature Section */
        .signature {
            margin-top: 15px;
            text-align: right;
            font-size: 10pt;
        }

        .signature p {
            margin: 2px 0;
        }

        .signature-line {
            margin-top: 50px;
            border-bottom: 1px solid black;
            width: 150px;
            display: inline-block;
        }

        /* Footer */
        .footer {
            font-size: 7pt;
            text-align: left;
            position: fixed;
            bottom: 10px;
            left: 10px;
            width: 100%;
        }
    </style>
</head>

<body>
    <!-- Header with Logo -->
    <div class="header-container">
        <div class="logo-container">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/logo-kota-langsa.png'))) }}" width="100" height="100" alt="Logo">
        </div>
        <div class="header-content">
            <p class="header-title">PEMERINTAH KOTA LANGSA</p>
            <p class="header-subtitle">RUMAH SAKIT UMUM DAERAH LANGSA</p>
            <p class="header-address">Alamat : Jln. Jend. A. Yani No.1 Kota Langsa – Provinsi Aceh</p>
            <p class="header-address">Telp. (0641) 21457 – 22800 (IGD) - 21009 (Farmasi) Fax. (0641) 22051</p>
            <p class="header-address">E-mail : rsudlangsa.aceh@gmail.com, website: www.rsud.langsakota.go.id</p>
            <p class="header-address">KOTA LANGSA</p>
        </div>
    </div>

    <!-- Document Title -->
    <div class="title">SURAT KETERANGAN KEDOKTERAN<br>TENTANG SEBAB KEMATIAN</div>
    <div class="doc-number">No. {{ $suratKematian->nomor_surat ?? '..........................' }}</div>

    <!-- Document Content -->
    <div class="content">
        <p>Yang bertanda tangan di bawah ini dr. {{ $suratKematian->dokter->nama_lengkap ?? '..........................' }}, spesialis bagian {{ $suratKematian->dokter->spesialis ?? '..........................' }} pada Rumah Sakit Umum Daerah Kota Langsa menerangkan bahwa pasien kami sebagai berikut:</p>
    </div>

    <!-- Patient Information -->
    <table class="patient-data">
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td>{{ $dataMedis->pasien->nama ?? '..........................' }}</td>
        </tr>
        <tr>
            <td>Tgl lahir/ Usia</td>
            <td>:</td>
            <td>{{ $dataMedis->pasien->tgl_lahir ? \Carbon\Carbon::parse($dataMedis->pasien->tgl_lahir)->format('d-m-Y') : '..........................' }} / {{ $dataMedis->pasien->umur ?? '..........' }} Tahun</td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td>{{ $dataMedis->pasien->jenis_kelamin == '1' ? 'Laki-laki' : 'Perempuan' }}</td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td>:</td>
            <td>{{ $dataMedis->pasien->pekerjaan ?? '..........................' }}</td>
        </tr>
        <tr>
            <td>Suku/Bangsa</td>
            <td>:</td>
            <td>{{ $dataMedis->pasien->suku ?? '..........................' }}</td>
        </tr>
        <tr>
            <td>Agama</td>
            <td>:</td>
            <td>{{ $dataMedis->pasien->agama ?? '..........................' }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>
                Jl. {{ $dataMedis->pasien->alamat ?? '..........................' }}<br>
                Dsn. {{ $dataMedis->pasien->dusun ?? '..........................' }}<br>
                Desa/Kel. {{ $dataMedis->pasien->desa ?? '..........................' }},<br>
                Kec. {{ $dataMedis->pasien->kecamatan ?? '..........................' }},<br>
                Kab/Kota: {{ $dataMedis->pasien->kabupaten ?? '..........................' }}
            </td>
        </tr>
    </table>

    <!-- Death Information -->
    <div class="content">
        <p><strong>TELAH MENINGGAL DUNIA pada:</strong></p>
    </div>

    <table class="patient-data">
        <tr>
            <td>Tanggal Kematian</td>
            <td>:</td>
            <td>{{ \Carbon\Carbon::parse($suratKematian->tanggal_kematian)->format('d/m/Y') }} Jam: {{ substr($suratKematian->jam_kematian, 0, 5) }}</td>
        </tr>
        <tr>
            <td>Di</td>
            <td>:</td>
            <td>{{ $suratKematian->tempat_kematian ?? '..........................' }} Kab/Kota: {{ $suratKematian->kabupaten_kota ?? '..........................' }}</td>
        </tr>
        <tr>
            <td>Umur dalam</td>
            <td>:</td>
            <td>{{ $suratKematian->umur ?? '0' }} Tahun / {{ $suratKematian->bulan ?? '0' }} Bulan / {{ $suratKematian->hari ?? '0' }} Hari / {{ $suratKematian->jam ?? '0' }} Jam/Menit</td>
        </tr>
    </table>

    <!-- Diagnosis Table -->
    <table class="diagnosis-table" border="1" cellspacing="0" cellpadding="3">
        <tr>
            <th colspan="2" width="75%">DIAGNOSIS PENYEBAB KEMATIAN</th>
            <th width="25%">Lamanya (kira-kira) mulai sakit hingga meninggal</th>
        </tr>

        <!-- Type I Diagnosis -->
        @if (!empty($suratKematian->detailType1) && $suratKematian->detailType1->count() > 0)
            <tr>
                <td width="25%" style="vertical-align: top;" rowspan="{{ $suratKematian->detailType1->count() }}">
                    <strong>I</strong><br>
                    Penyakit atau keadaan yang langsung mengakibatkan kematian
                </td>
                @foreach ($suratKematian->detailType1 as $index => $detail)
                    @if ($index == 0)
                        <td width="50%">
                            a. {{ $detail->keterangan ?? '..........................' }}
                            @if (!empty($detail->konsekuensi))
                                <br>
                                Disebabkan atau konsekuensi dari: {{ $detail->konsekuensi }}
                            @endif
                        </td>
                        <td width="25%">
                            {{ $detail->estimasi ?? '..........................' }}
                        </td>
                    </tr>
                    @else
                    <tr>
                        <td width="50%">
                            {{ chr(97 + $index) }}. {{ $detail->keterangan ?? '..........................' }}
                            @if (!empty($detail->konsekuensi))
                                <br>
                                Disebabkan atau konsekuensi dari: {{ $detail->konsekuensi }}
                            @endif
                        </td>
                        <td width="25%">
                            {{ $detail->estimasi ?? '..........................' }}
                        </td>
                    </tr>
                    @endif
                @endforeach
        @else
            <tr>
                <td width="25%" style="vertical-align: top;" rowspan="1">
                    <strong>I</strong><br>
                    Penyakit atau keadaan yang langsung mengakibatkan kematian
                </td>
                <td width="50%">
                    Tidak ada data
                </td>
                <td width="25%"></td>
            </tr>
        @endif

        <!-- Type II Diagnosis -->
        @if (!empty($suratKematian->detailType2) && $suratKematian->detailType2->count() > 0)
            <tr>
                <td width="25%" style="vertical-align: top;" rowspan="{{ $suratKematian->detailType2->count() + 1 }}">
                    <strong>II</strong><br>
                    Penyakit-penyakit lain yang mempengaruhi kematian, tetapi tidak ada hubungannya dengan penyakit diatas
                </td>
                <td width="50%">
                    <strong>Disamping penyakit-penyakit tersebut diatas terdapat pula penyakit:</strong>
                </td>
                <td width="25%"></td>
            </tr>
            @foreach ($suratKematian->detailType2 as $index => $detail)
            <tr>
                <td width="50%">
                    {{ chr(97 + $index) }}. {{ $detail->keterangan ?? '..........................' }}
                </td>
                <td width="25%">
                    {{ $detail->estimasi ?? '..........................' }}
                </td>
            </tr>
            @endforeach
        @else
            <tr>
                <td width="25%" style="vertical-align: top;" rowspan="1">
                    <strong>II</strong><br>
                    Penyakit-penyakit lain yang mempengaruhi kematian, tetapi tidak ada hubungannya dengan penyakit diatas
                </td>
                <td width="50%">
                    Tidak ada data
                </td>
                <td width="25%"></td>
            </tr>
        @endif
    </table>

    <!-- Signature -->
    <div class="signature">
        <p>Kota Langsa, {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
        <p>Dokter yang menerangkan</p>
        <div class="signature-line"></div>
        <p>({{ $suratKematian->dokter->nama_lengkap ?? '.............................' }})</p>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>NO: B.12/IRM/Rev 0/2017</p>
    </div>
</body>

</html>