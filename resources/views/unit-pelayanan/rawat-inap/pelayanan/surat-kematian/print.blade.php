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
        .header-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #f0f0f0;
            padding: 0;
            margin-bottom: 10px;
        }

        .td-left {
            width: 20%;
            text-align: left;
            vertical-align: middle;
        }

        .td-center {
            width: 60%;
            text-align: center;
            vertical-align: middle;
        }

        .td-right {
            width: 20%;
            text-align: center;
            vertical-align: middle;
        }

        .brand-name {
            font-weight: 700;
            margin: 0;
            font-size: 12pt;
        }

        .brand-info {
            margin: 0;
            font-size: 9pt;
        }

        /* Document Title */
        .title {
            font-size: 12pt;
            font-weight: bold;
            text-align: center;
            margin: 5px 0 3px 0;
        }

        .doc-number {
            font-size: 10pt;
            text-align: center;
            margin-bottom: 5px;
            font-style: bold;
            font-weight: bold;
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
    @php
        // Logic Logo
        $logoBase64 = null;
        if (!$logoBase64) {
            $logoPath = public_path('assets/img/logo-kota-langsa.png');
            $logoData = @file_get_contents($logoPath);
            $logoBase64 = $logoData ? 'data:image/png;base64,' . base64_encode($logoData) : null;
        }
    @endphp

    {{-- HEADER --}}
    <table class="header-table">
        <tr>
            <td class="td-left">
                @if ($logoBase64)
                    <img src="{{ $logoBase64 }}" width="80" height="80" alt="Logo">
                @endif
            </td>

            <td class="td-center">
                <p class="brand-name">PEMERINTAH KOTA LANGSA</p>
                <p class="brand-name">RUMAH SAKIT UMUM DAERAH LANGSA</p>
                <p class="brand-info">Alamat : Jln. Jend. A. Yani No.1 Kota Langsa – Provinsi Aceh</p>
                <p class="brand-info">Telp. (0641) 21457 – 22800 (IGD) - 21009 (Farmasi) Fax. (0641) 22051</p>
                <p class="brand-info">E-mail : rsudlangsa.aceh@gmail.com, website: www.rsud.langsakota.go.id</p>
                <p class="brand-info">KOTA LANGSA</p>
            </td>

            <td class="td-right">
                {{-- Kosongkan atau tambah QR jika perlu --}}
            </td>
        </tr>
    </table>

    <!-- Document Title -->
    <div class="title">SURAT KETERANGAN KEDOKTERAN<br>TENTANG SEBAB KEMATIAN</div>
    <div class="doc-number">(Certificate of Death)</div>

    <!-- Document Content -->
    <div class="content">
        <p>Yang bertanda tangan di bawah ini <b>{{ $suratKematian->nama_dokter ?? '..........................' }}</b>,
            spesialis bagian {{ $suratKematian->nama_spesialis ?? '..........................' }} pada Rumah Sakit Umum
            Daerah Kota Langsa menerangkan bahwa pasien kami sebagai berikut:</p>
    </div>

    <!-- Patient Information -->
    <table class="patient-data">
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td>{{ $dataMedis->pasien->nama ?? '..........................' }}</td>
        </tr>
        <tr>
            <td>Nomor RM</td>
            <td>:</td>
            <td>{{ $dataMedis->kd_pasien ?? '..........................' }}</td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>:</td>
            <td>{{ $dataMedis->pasien->no_pengenal ?? '..........................' }}</td>
        </tr>
        <tr>
            <td>Tgl lahir/ Usia</td>
            <td>:</td>
            <td>{{ $dataMedis->pasien->tgl_lahir ? \Carbon\Carbon::parse($dataMedis->pasien->tgl_lahir)->format('d-m-Y') : '..........................' }}
                / {{ $dataMedis->pasien->umur ?? '..........' }} Tahun</td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td>{{ $dataMedis->jenis_kelamin == '1' ? 'Laki-laki' : 'Perempuan' }}</td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td>:</td>
            <td>{{ $dataMedis->pasien->pekerjaan->pekerjaan ?? '..........................' }}</td>
        </tr>
        <tr>
            <td>Suku/Bangsa</td>
            <td>:</td>
            <td>{{ $dataMedis->pasien->suku->suku ?? '..........................' }}</td>
        </tr>
        <tr>
            <td>Agama</td>
            <td>:</td>
            <td>{{ $dataMedis->pasien->agama->agama ?? '..........................' }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>
                {{ str()->title($dataMedis->pasien->alamat) ?? '..........................' }}<br>
                Desa/Kel.
                {{ str()->title($dataMedis->pasien->kelurahan->kelurahan) ?? '..........................' }}<br>
                Kec.
                {{ str()->title($dataMedis->pasien->kelurahan->kecamatan->kecamatan) ?? '..........................' }}<br>
                Kab/Kota:
                {{ str()->title($dataMedis->pasien->kelurahan->kecamatan->kabupaten->kabupaten) ?? '..........................' }}<br>
                Provinsi:
                {{ str()->title($dataMedis->pasien->kelurahan->kecamatan->kabupaten->propinsi->propinsi) ?? '..........................' }}<br>
            </td>

        </tr>
    </table>

    <!-- Death Information -->
    <div class="content">
        <p><strong>TELAH MENINGGAL DUNIA pada:</strong></p>
    </div>

    <table class="patient-data">
        <tr>
            <td>Tanggal</td>
            <td>:</td>
            <td>{{ \Carbon\Carbon::parse($suratKematian->tanggal_kematian)->format('d/m/Y') }} Jam:
                {{ substr($suratKematian->jam_kematian, 0, 5) }}</td>
        </tr>
        <tr>
            <td>Di</td>
            <td>:</td>
            <td>{{ $suratKematian->tempat_kematian ?? '..........................' }} Kab/Kota:
                {{ $suratKematian->kabupaten_kota ?? '..........................' }}</td>
        </tr>
        <tr>
            <td>Umur dalam</td>
            <td>:</td>
            <td>{{ $suratKematian->umur ?? '0' }} Tahun / {{ $suratKematian->bulan ?? '0' }} Bulan /
                {{ $suratKematian->hari ?? '0' }} Hari / {{ $suratKematian->jam ?? '0' }} Jam/Menit</td>
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
                <td width="25%" style="vertical-align: top;"
                    rowspan="{{ $suratKematian->detailType2->count() + 1 }}">
                    <strong>II</strong><br>
                    Penyakit-penyakit lain yang mempengaruhi kematian, tetapi tidak ada hubungannya dengan penyakit
                    diatas
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
                    Penyakit-penyakit lain yang mempengaruhi kematian, tetapi tidak ada hubungannya dengan penyakit
                    diatas
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
        {{-- <img src="data:image/png;base64,{{ $qrCode }}" alt="QR Code"> --}}
        <p>({{ $suratKematian->dokter->nama_lengkap ?? '.............................' }})</p>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>NO: B.12/IRM/Rev 0/2017</p>
    </div>
</body>

</html>
