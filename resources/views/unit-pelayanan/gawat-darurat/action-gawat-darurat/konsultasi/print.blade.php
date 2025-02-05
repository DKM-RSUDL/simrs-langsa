<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Konsultasi IGD</title>

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
            <p>Form Konsultasi<br>IGD</p>
        </div>
        <div class="right-column">
            <table class="info-table">
                <tr>
                    <td><strong>No RM</strong></td>
                    <td>{{ $konsultasi->kd_pasien }}</td>
                </tr>
                <tr>
                    <td><strong>Nama</strong></td>
                    <td>{{ str()->title($konsultasi->pasien->nama) }}</td>
                </tr>
                <tr>
                    <td><strong>Jenis Kelamin</strong></td>
                    <td>
                        @php
                            $gender = '-';

                            if($konsultasi->pasien->jenis_kelamin == 1) $gender = 'Laki-Laki';
                            if($konsultasi->pasien->jenis_kelamin == 0) $gender = 'Perempuan';

                            echo $gender;
                        @endphp
                    </td>
                </tr>
                <tr>
                    <td><strong>Tanggal Lahir</strong></td>
                    <td>{{ date('d/m/Y', strtotime($konsultasi->pasien->tgl_lahir)) }}</td>
                </tr>
            </table>
        </div>
    </header>

    <main>
        <table border="1">
            <tr>
                <th>Tanggal</th>
                <td>{{ date('d/m/Y', strtotime($konsultasi->tgl_konsul)) }}</td>
            </tr>
            <tr>
                <th>Jam</th>
                <td>{{ date('H:i', strtotime($konsultasi->jam_konsul)) }} WIB</td>
            </tr>
            <tr class="table-section-title">
                <th colspan="2">SBAR</th>
            </tr>
            <tr>
                <th>Subjective</th>
                <td>{{ $konsultasi->subjective }}</td>
            </tr>
            <tr>
                <th>Backgroud</th>
                <td>{{ $konsultasi->background }}</td>
            </tr>
            <tr>
                <th>Assesment</th>
                <td>{{ $konsultasi->assesment }}</td>
            </tr>
            <tr>
                <th>Recomendation</th>
                <td>{{ $konsultasi->recomendation }}</td>
            </tr>
            <tr class="table-section-title">
                <th colspan="2">KONSULTASI</th>
            </tr>
            <tr>
                <th>Dari Dokter</th>
                <td>{{ $konsultasi->dokterAsal->nama_lengkap }}</td>
            </tr>
            <tr>
                <th>Dokter Konsulen</th>
                <td>{{ $konsultasi->dokterTujuan->nama_lengkap }}</td>
            </tr>
            <tr>
                <th>Konsul yang diminta</th>
                <td>{{ $konsultasi->konsultasi }}</td>
            </tr>
            <tr>
                <th>Instruksi Konsulen</th>
                <td>{{ $konsultasi->instruksi }}</td>
            </tr>
        </table>
    </main>

    <footer>
        <div class="left-column">
            <p>Dokter Pembuat</p>
            <p class="name-konsulen">{{ $konsultasi->dokterAsal->nama_lengkap }}</p>
            <p class="identity-num">
                @php
                    $identityNum = 'Id Peg. ' . $konsultasi->dokterAsal->kd_karyawan;
                    if(!empty($konsultasi->dokterAsal->detail->nip_baru)) $identityNum = 'NIP. ' . $konsultasi->dokterAsal->detail->nip_baru;
                    echo $identityNum;
                @endphp
            </p>
        </div>

        <div class="right-column">
            <p>Dokter Konsulen</p>
            <p class="name-konsulen">{{ $konsultasi->dokterTujuan->nama_lengkap }}</p>
            <p class="identity-num">
                @php
                    $identityNum = 'Id Peg. ' . $konsultasi->dokterTujuan->kd_karyawan;
                    if(!empty($konsultasi->dokterTujuan->detail->nip_baru)) $identityNum = 'NIP. ' . $konsultasi->dokterTujuan->detail->nip_baru;
                    echo $identityNum;
                @endphp
            </p>
        </div>
    </footer>
</body>
</html>
