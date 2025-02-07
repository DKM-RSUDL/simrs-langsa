<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Resume Medis IGD</title>

    <style>
        body {
            font-family: Arial, sans-serif;
        }

        header {
            width: 100%;
            display: table;
            padding-bottom: 30px;
            border-bottom: 2px solid black
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
            margin-top: 30px;
        }

        main table {
            width: 100%;
            border-collapse: collapse;
        }

        main table th, main table td {
            text-align: left;
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        main table .table-section-title th {
            text-align: center;
            background-color: #dddddd
        }

        footer {
            width: 100%;
            display: table;
            margin-top: 30px;
        }

        footer div {
            display: table-cell;
            vertical-align: top;
            text-align: center;
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
        <div class="center-column">
            <p>Resume Medis<br>IGD</p>
        </div>
        <div class="right-column">
            <table class="info-table">
                <tr>
                    <td><strong>No RM</strong></td>
                    <td>{{ $resume->kd_pasien }}</td>
                </tr>
                <tr>
                    <td><strong>Nama</strong></td>
                    <td>{{ str()->title($resume->pasien->nama) }}</td>
                </tr>
                <tr>
                    <td><strong>Jenis Kelamin</strong></td>
                    <td>
                        @php
                            $gender = '-';

                            if($resume->pasien->jenis_kelamin == 1) $gender = 'Laki-Laki';
                            if($resume->pasien->jenis_kelamin == 0) $gender = 'Perempuan';

                            echo $gender;
                        @endphp
                    </td>
                </tr>
                <tr>
                    <td><strong>Tanggal Lahir</strong></td>
                    <td>{{ date('d/m/Y', strtotime($resume->pasien->tgl_lahir)) }}</td>
                </tr>
            </table>
        </div>
    </header>

    <main>
        <table border="1">
            <tr>
                <th>Ruang</th>
                <td>{{ $resume->unit->nama_unit }}</td>
            </tr>
            <tr>
                <th>Tanggal Masuk</th>
                <td>{{ date('d/m/Y', strtotime($resume->tgl_masuk)) }}</td>
            </tr>
            <tr>
                <th>Tanggal Keluar</th>
                <td>{{ $resume->rmeResumeDet->tgl_pulang ? date('d/m/Y', strtotime($resume->rmeResumeDet->tgl_pulang)) : '-' }}</td>
            </tr>
            <tr>
                <th>Lama Dirawat</th>
                <td>
                    {{ !empty($resume->rmeResumeDet->tgl_pulang) ? selisihHari($resume->tgl_masuk, $resume->rmeResumeDet->tgl_pulang) + 1 . ' Hari' : '-' }}
                </td>
            </tr>
            <tr>
                <th>Jaminan</th>
                <td>{{ $dataMedis->customer->customer }}</td>
            </tr>
            <tr>
                <th>Anamnesis</th>
                <td>{{ $resume->anamnesis }}</td>
            </tr>
            <tr>
                <th>Hasil Pemeriksaan Fisik</th>
                <td></td>
            </tr>
            <tr>
                <th>Temuan Klinik Penunjang</th>
                <td>{{ $resume->pemeriksaan_penunjang }}</td>
            </tr>
            <tr>
                <th>Diagnosis Primer</th>
                <td></td>
            </tr>
            <tr>
                <th>Diagnosis Sekunder</th>
                <td></td>
            </tr>
            <tr>
                <th>Tindakan</th>
                <td></td>
            </tr>
            <tr>
                <th>Terapi Selama Dirawat</th>
                <td></td>
            </tr>
            <tr>
                <th>Tindak Lanjut</th>
                <td></td>
            </tr>
        </table>
    </main>
</body>
</html>
