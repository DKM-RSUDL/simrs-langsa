<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Privasi Rawat Inap</title>

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
            font-size: 16px;
        }

        main .letter-title {
            text-align: center;
            font-weight: 700;
            text-decoration: underline;
            margin-bottom: 30px;
        }

        footer {
            width: 100%;
            display: table;
            /* margin-top: 30px; */
            font-size: 16px;
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
            PERMINTAAN PRIVASI / KEAMANAN
        </p>

        <p>
            Saya yang bertanda tangan di bawah ini:
        </p>

        <table style="margin-left: 40px;">
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>{{ $privasi->keluarga_nama }}</td>
            </tr>
            <tr>
                <td>Tempat/ Tgl Lahir</td>
                <td>:</td>
                <td>{{ "$privasi->keluarga_tempat_lahir/ " . date('d-m-Y', strtotime($privasi->keluarga_tgl_lahir)) }}
                </td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td>{{ $privasi->keluarga_jenis_kelamin == '1' ? 'Laki-Laki' : 'Perempuan' }}</td>
            </tr>
            <tr>
                <td>Hubungan dengan pasien</td>
                <td>:</td>
                <td>
                    @if ($privasi->keluarga_hubungan_pasien == 1)
                        Pasien sendiri
                    @endif
                    @if ($privasi->keluarga_hubungan_pasien == 2)
                        Istri
                    @endif
                    @if ($privasi->keluarga_hubungan_pasien == 3)
                        Suami
                    @endif
                    @if ($privasi->keluarga_hubungan_pasien == 4)
                        Anak
                    @endif
                    @if ($privasi->keluarga_hubungan_pasien == 5)
                        Ayah
                    @endif
                    @if ($privasi->keluarga_hubungan_pasien == 6)
                        Ibu
                    @endif
                    @if ($privasi->keluarga_hubungan_pasien == 7)
                        Keluarga
                    @endif
                </td>
            </tr>
            <tr>
                <td>Alamat rumah</td>
                <td>:</td>
                <td>{{ $privasi->keluarga_alamat }}</td>
            </tr>
        </table>

        <ol>
            @if (!empty($privasi->privasi_nama))
                <li>
                    Dengan ini meminta privasi khusus bahwa
                    <strong>{{ $privasi->status_privasi == 1 ? 'mengizinkan' : 'tidak mengizinkan' }}</strong>
                    sdr/i {{ $privasi->privasi_nama }}
                    untuk menjenguk/ menemui saya/ keluarga saya selama dirawat di RSUD Langsa
                </li>
            @endif

            @if (!empty($privasi->privasi_khusus) || is_array($privasi->privasi_khusus))
                <li>
                    Saya menginginkan privasi khusus pada saat :

                    <ol type="a">
                        @if (in_array('wawancara', $privasi->privasi_khusus))
                            <li>Wawancara klinis</li>
                        @endif
                        @if (in_array('fisik', $privasi->privasi_khusus))
                            <li>Pemeriksaan fisik</li>
                        @endif
                        @if (in_array('perawatan', $privasi->privasi_khusus))
                            <li>Perawatan/ tindakan: {{ $privasi->tindakan_privasi }}</li>
                        @endif
                        @if (in_array('lainnya', $privasi->privasi_khusus))
                            <li>Lainnya: {{ $privasi->privasi_lainnya }}</li>
                        @endif
                    </ol>
                </li>
            @endif
        </ol>

        <p>
            Demikian permohonan ini dibuat, atas perhatiannya kami ucapkan terima kasih.
        </p>
    </main>

    <footer>
        <div class="">
            <p>Langsa, {{ date('d-m-Y', strtotime($privasi->tanggal)) }}</p>
            <p>Yang memohon</p>
            <p class="name-konsulen">{{ $privasi->keluarga_nama }}</p>
        </div>
    </footer>
</body>

</html>
