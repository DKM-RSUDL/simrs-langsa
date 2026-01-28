<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Meninggalkan Perawatan Rawat Inap</title>

    <style>
        body {
            font-family: sans-serif;
        }

        header {
            width: 100%;
            border-bottom: 2px solid black;
            font-size: 13px;
        }

        header .header-logo {
            width: 80px;
        }

        header .title {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
        }

        header .info-table {
            width: 100%;
            border: 1px solid black;
            border-collapse: collapse;
        }

        header .info-table td {
            padding: 8px;
            border: 1px solid black;
        }

        main {
            margin-top: 10px;
            text-align: justify;
            font-size: 15px;
        }


        #signature-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            table-layout: fixed;
            /* page-break-inside: avoid; */
        }

        #signature-table tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        #signature-table tr.sum-row {
            page-break-inside: avoid;
        }

        #signature-table th,
        #signature-table td {
            text-align: left;
            border: 1px solid black;
            padding: 8px;
            text-align: left;
            overflow: hidden;
            word-wrap: break-word;
        }

        #signature-table .table-section-title th {
            text-align: center;
            background-color: #dddddd
        }


        footer {
            width: 100%;
            display: table;
            /* margin-top: 30px; */
            font-size: 13px;
        }

        footer div {
            display: table-cell;
            vertical-align: top;
            text-align: center;
            width: fit-content;
        }

        footer div .name-konsulen {
            margin: 80px 0 0 0;
            font-weight: 600;
            text-decoration: underline;
        }

        footer div .identity-num {
            margin: 0;
        }
    </style>
</head>

<body>
    <header>
        <div class="left-column">
            <img src="{{ public_path('assets/img/Logo-RSUD-Langsa-1.png') }}" class="header-logo" alt="Logo">
        </div>
        <div class="right-column">
            <p class="title">
                SURAT PERNYATAAN MENINGGALKAN PERAWATAN
            </p>
        </div>
    </header>

    <main>
        <p>
            Saya yang bertanda tangan di bawah ini :
        </p>

        <table style="margin-left: 40px;">
            <tr>
                <td>Nama Pasien</td>
                <td style="padding-left: 30px;">:</td>
                <td>{{ $dataMedis->pasien->nama }}</td>
            </tr>
            <tr>
                <td>No RM</td>
                <td style="padding-left: 30px;">:</td>
                <td>{{ $dataMedis->pasien->kd_pasien }}</td>
            </tr>
            <tr>
                <td>Umur / Tgl Lahir</td>
                <td style="padding-left: 30px;">:</td>
                <td>{{ hitungUmur($dataMedis->pasien->tgl_lahir) . ' / ' . date('d-m-Y', strtotime($dataMedis->pasien->tgl_lahir)) }}
                </td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td style="padding-left: 30px;">:</td>
                <td>
                    @if ($dataMedis->pasien->jenis_kelamin == 0)
                        Perempuan
                    @endif
                    @if ($dataMedis->pasien->jenis_kelamin == 1)
                        Laki-laki
                    @endif
                </td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td style="padding-left: 30px;">:</td>
                <td>{{ $dataMedis->pasien->alamat }}</td>
            </tr>
            <tr>
                <td>No KTP/ SIM/ Passport</td>
                <td style="padding-left: 30px;">:</td>
                <td>{{ $dataMedis->pasien->no_pengenal }}</td>
            </tr>
        </table>

        <p>
            Menyatakan bahwa saya akan meninggalkan perawatan yang sedang saya jalani di ruang perawatan RSU Langsa
            untuk sementara waktu untuk keperluan : {{ $pernyataan->keperluan }}
        </p>
        <p>
            Dari tanggal
            {{ date('d-m-Y', strtotime($pernyataan->tgl_awal)) . ' ' . date('H:i', strtotime($pernyataan->jam_awal)) }}
            s/d tanggal
            {{ date('d-m-Y', strtotime($pernyataan->tgl_akhir)) . ' ' . date('H:i', strtotime($pernyataan->jam_akhir)) }}
        </p>
        <p>
            Dengan demikian segala resiko yang berkaitan dengan keselamatan dan gangguan terhadap
            kesehatan/penyakit saya adalah menjadi tanggung jawab saya sepenuhnya dan tidak ada
            kaitannya dengan pihak rumah sakit.
        </p>
        <p>
            Demikian surat pernyataan ini saya buat dengan penuh kesadaran dan tanpa paksaan.
        </p>

        <table id="signature-table">
            <thead>
                <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2">Tanda Tangan Yang Menyatakan</th>
                    <th colspan="2">Keluar</th>
                    <th colspan="2">Masuk Kembali</th>
                    <th rowspan="2">Tanda Tangan DPJP</th>
                </tr>

                <tr>
                    <th>Tgl</th>
                    <th>Jam</th>
                    <th>Tgl</th>
                    <th>Jam</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>1</td>
                    <td align="middle" style="padding-top: 80px;">{{ $dataMedis->pasien->nama }}</td>
                    <td>{{ date('d-m-Y', strtotime($pernyataan->tgl_keluar)) }}</td>
                    <td>{{ date('H:i', strtotime($pernyataan->jam_keluar)) }} WIB</td>
                    <td>{{ date('d-m-Y', strtotime($pernyataan->tgl_masuk_kembali)) }}</td>
                    <td>{{ date('H:i', strtotime($pernyataan->jam_masuk_kembali)) }} WIB</td>
                    <td style="padding-top: 80px;">
                        <img src="{{ generateQrCode($pernyataan->dokter->nama_lengkap, 100, 'svg_datauri') }}"
                            alt="QR">
                        {{ $pernyataan->dokter->nama_lengkap }}
                    </td>
                </tr>
            </tbody>
        </table>
    </main>

    <footer>

    </footer>
</body>

</html>
