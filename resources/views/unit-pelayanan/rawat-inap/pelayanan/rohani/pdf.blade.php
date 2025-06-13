<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print PAPS Rawat Inap</title>

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
            font-size: 15px;
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
            FORMULIR PERMINTAAN PELAYANAN ROHANI
        </p>

        <p>
            Saya yang bertanda tangan di bawah ini:
        </p>

        <table style="margin-left: 40px;">
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>{{ $rohani->keluarga_nama }}</td>
            </tr>
            <tr>
                <td>Tempat/ Tgl Lahir</td>
                <td>:</td>
                <td>{{ "$rohani->keluarga_tempat_lahir/ " . date('d-m-Y', strtotime($rohani->keluarga_tgl_lahir)) }}
                </td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td>{{ $rohani->keluarga_jenis_kelamin == '1' ? 'Laki-Laki' : 'Perempuan' }}</td>
            </tr>
            <tr>
                <td>Hubungan dengan pasien</td>
                <td>:</td>
                <td>{{ $rohani->keluarga_hubungan_pasien }}</td>
            </tr>
            <tr>
                <td>Agama</td>
                <td>:</td>
                <td>{{ $rohani->keluargaAgama->agama }}</td>
            </tr>
        </table>

        <p>Dengan ini mengajukan permohonan untuk diberikan pelayanan rohani terhadap:</p>

        <table style="margin-left: 40px;">
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>{{ $dataMedis->pasien->nama }}</td>
            </tr>
            <tr>
                <td>Tempat/ Tgl Lahir</td>
                <td>:</td>
                <td>{{ $dataMedis->pasien->tempat_lahir ?? '-' }}/
                    {{ date('d-m-Y', strtotime($dataMedis->pasien->tgl_lahir)) }}
                </td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td>{{ $dataMedis->pasien->jenis_kelamin == '1' ? 'Laki-Laki' : 'Perempuan' }}</td>
            </tr>
            <tr>
                <td>Ruang</td>
                <td>:</td>
                <td>{{ $dataMedis->unit->nama_unit }}</td>
            </tr>
            <tr>
                <td>Agama</td>
                <td>:</td>
                <td>{{ $dataMedis->pasien->agama->agama }}</td>
            </tr>
        </table>

        <table style="margin-left: 40px; margin-top: 20px;">
            <td style="padding-right: 10px;">Dengan kondisi pasien: </td>
            <td>
                <ul style="margin-top: 0;">
                    @foreach ($rohani->kondisi_pasien as $kondisi)
                        <li>{{ $kondisi }}</li>
                    @endforeach
                </ul>
            </td>
        </table>

        <p>Demikian permohonan ini dibuat, atas perhatiannya kami ucapkan terima kasih.</p>
    </main>

    <footer>
        <div class="">
            <p>Langsa, {{ date('d-m-Y', strtotime($rohani->tanggal)) }}</p>
            <p>Yang memohon</p>
            <p class="name-konsulen">{{ $rohani->keluarga_nama }}</p>
        </div>

        <div class="">
            <p>PPA Yang menyetujui</p>
            <p class="name-konsulen">
                {{ $rohani->penyetuju->gelar_depan . ' ' . str()->title($rohani->penyetuju->nama) . ' ' . $rohani->penyetuju->gelar_belakang }}
            </p>
        </div>
    </footer>
</body>

</html>
