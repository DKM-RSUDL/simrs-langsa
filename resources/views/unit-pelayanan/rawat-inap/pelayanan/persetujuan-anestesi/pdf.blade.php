<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Persetujuan Anestesi dan Sedasi Rawat Inap</title>

    <style>
        body {
            font-family: sans-serif;
        }

        header {
            width: 100%;
            display: table;
            padding-bottom: 30px;
            border-bottom: 2px solid black;
            font-size: 13px;
        }

        header .left-column {
            display: table-cell;
            width: 20%;
            vertical-align: top;
            text-align: center;
        }

        header .left-column p {
            margin: 5px;
        }

        header .center-column {
            display: table-cell;
            width: auto;
            vertical-align: middle;
            text-align: center;
        }

        header .center-column p {
            font-size: 25px;
            font-weight: 700;
        }

        header .right-column {
            display: table-cell;
            width: 40%;
            vertical-align: top;
            text-align: right;
        }

        header .header-logo {
            width: 80px;
        }

        header .title {
            font-size: 24px;
            font-weight: bold;
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
            /* margin-top: 10px; */
            text-align: justify;
            font-size: 14px;
        }

        main .letter-title {
            text-align: center;
            font-weight: 700;
            margin-bottom: 30px;
            text-decoration: underline;
        }

        footer {
            width: 100%;
            display: table;
            margin-top: 10px;
            font-size: 14px;
        }

        footer div {
            width: 100%;
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

        footer div .label-barcode {
            margin: 10px 0 0 0;
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
            <p>RSUD Langsa</p>
            <p>Jl. Jend. A. Yani No.1 Kota Langsa</p>
        </div>
        <div class="right-column">
            <table class="info-table">
                <tr>
                    <td><strong>No RM</strong></td>
                    <td>{{ $dataMedis->kd_pasien }}</td>
                </tr>
                <tr>
                    <td><strong>Nama</strong></td>
                    <td>{{ str()->title($dataMedis->pasien->nama) }}</td>
                </tr>
                <tr>
                    <td><strong>Jenis Kelamin</strong></td>
                    <td>
                        @php
                            $gender = '-';

                            if ($dataMedis->pasien->jenis_kelamin == 1) {
                                $gender = 'Laki-Laki';
                            }
                            if ($dataMedis->pasien->jenis_kelamin == 0) {
                                $gender = 'Perempuan';
                            }

                            echo $gender;
                        @endphp
                    </td>
                </tr>
                <tr>
                    <td><strong>Tanggal Lahir</strong></td>
                    <td>{{ date('d/m/Y', strtotime($dataMedis->pasien->tgl_lahir)) }}</td>
                </tr>
            </table>
        </div>
    </header>

    <main>
        <p class="letter-title">
            PERNYATAAN PERSETUJUAN TINDAKAN ANESTESI DAN SEDASI
        </p>

        <p>
            Yang bertanda tangan di bawah ini, saya:
        </p>

        <table style="margin-left: 40px;">
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>{{ $anestesi->keluarga_nama }}</td>
            </tr>
            <tr>
                <td>Usia</td>
                <td>:</td>
                <td>{{ $anestesi->keluarga_usia }} tahun</td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td>{{ $anestesi->keluarga_jenis_kelamin == 1 ? 'Laki-Laki' : 'Perempuan' }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>{{ $anestesi->keluarga_alamat }}</td>
            </tr>
        </table>

        <p>
            Dengan ini menyatakan <strong>PERSETUJUAN</strong> untuk dilakukannya tindakan anestesi berupa:
        </p>

        <ol @if (count($anestesi->tindakan) < 2) style="list-style-type: none;" @endif>
            @foreach ($anestesi->tindakan as $item)
                <li>
                    {{ $item }} {{ $item == 'Lain-lain' ? ': ' . $anestesi->tindakan_lainnya : '' }}
                </li>
            @endforeach
        </ol>

        <p>
            Terhadap

            @if ($anestesi->status_keluarga == 1)
                diri saya sendiri
            @endif
            @if ($anestesi->status_keluarga == 2)
                Istri saya
            @endif
            @if ($anestesi->status_keluarga == 3)
                Suami saya
            @endif
            @if ($anestesi->status_keluarga == 4)
                Anak saya
            @endif
            @if ($anestesi->status_keluarga == 5)
                Ayah saya
            @endif
            @if ($anestesi->status_keluarga == 6)
                Ibu saya
            @endif
            @if ($anestesi->status_keluarga == 7)
                Keluarga saya
            @endif
            :
        </p>

        <table style="margin-left: 40px;">
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>{{ $dataMedis->pasien->nama }}</td>
            </tr>
            <tr>
                <td>Usia</td>
                <td>:</td>
                <td>{{ hitungUmur(date('Y-m-d', strtotime($dataMedis->pasien->tgl_lahir))) }} tahun</td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td>{{ $dataMedis->pasien->jenis_kelamin == '1' ? 'Laki-Laki' : 'Perempuan' }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>{{ $dataMedis->pasien->alamat }}</td>
            </tr>
            <tr>
                <td>No RM</td>
                <td>:</td>
                <td>{{ $dataMedis->pasien->kd_pasien }}</td>
            </tr>
        </table>

        <p>
            Saya memahami perlunya dan manfaat tindakan tersebut sebagaimana telah dijelaskan kepada saya

            @if ($anestesi->status_keluarga == 2)
                / Istri saya
            @endif
            @if ($anestesi->status_keluarga == 3)
                / Suami saya
            @endif
            @if ($anestesi->status_keluarga == 4)
                / Anak saya
            @endif
            @if ($anestesi->status_keluarga == 5)
                / Ayah saya
            @endif
            @if ($anestesi->status_keluarga == 6)
                / Ibu saya
            @endif
            @if ($anestesi->status_keluarga == 7)
                / Keluarga saya
            @endif
            , termasuk risiko dan komplikasi yang mungkin timbul apabila
            tindakan tersebut dilakukan.
        </p>

        <p>
            Saya juga menyadari bahwa ilmu kedokteran bukanlah ilmu pasti, maka keberhasilan dan kesembuhan sangat
            bergantung atas izin Tuhan Yang Maha Kuasa.
        </p>

        <p>
            Kota Langsa, tanggal: {{ date('d-m-Y', strtotime($anestesi->tanggal)) }} / pukul
            : {{ date('H:i', strtotime($anestesi->jam)) }} WIB
        </p>
    </main>

    <footer>
        <div class="">
            <p style="margin: 0;">Yang menyatakan</p>
            <p class="name-konsulen">{{ $anestesi->keluarga_nama }}</p>
        </div>

        <div class="">
            <p style="margin: 0;">Saksi keluarga</p>
            <p class="name-konsulen">{{ $anestesi->nama_saksi_keluarga }}</p>
        </div>
    </footer>

    <footer>
        <div class="">
            <p style="margin: 0;">Dokter</p>
            <img src="{{ generateQrCode($anestesi->dokter->nama_lengkap, 100, 'svg_datauri') }}" alt="QR">
            <p class="label-barcode">{{ $anestesi->dokter->nama_lengkap }}</p>
        </div>

        <div class="">
            <p style="margin: 0;">Saksi</p>
            <p class="name-konsulen">{{ $anestesi->nama_saksi }}</p>
        </div>
    </footer>
</body>

</html>
