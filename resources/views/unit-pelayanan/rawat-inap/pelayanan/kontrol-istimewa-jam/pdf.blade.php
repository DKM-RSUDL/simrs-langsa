<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Kontrol Istimewa per Jam {{ $dataMedis->unit->nama_unit }}</title>

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
            /* text-decoration: underline; */
        }

        .main-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        .main-table th {
            background-color: #f0f0f0;
            padding: 8px;
            border: 1px solid black;
            text-align: center;
            font-weight: bold;
        }

        .main-table td {
            padding: 6px;
            border: 1px solid black;
            text-align: center;
        }

        .main-table .time-col {
            width: 10%;
        }

        .main-table .vital-col {
            width: 8%;
        }

        .main-table .bp-col {
            width: 10%;
        }

        .main-table .io-col {
            width: 12%;
        }

        .main-table .note-col {
            width: 15%;
            text-align: left;
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
                <tr>
                    <td><strong>DPJP</strong></td>
                    <td>{{ $dataMedis->dokter->nama_lengkap }}</td>
                </tr>
            </table>
        </div>
    </header>

    <main>
        <p class="letter-title">
            KONTROL ISTIMEWA SETIAP JAM
            <br>
            Tanggal : {{ date('d-m-Y', strtotime($tglPrint)) }}
        </p>

        <table class="main-table">
            <thead>
                <tr>
                    <th rowspan="2" class="time-col">JAM</th>
                    <th colspan="4">TANDA VITAL</th>
                    <th colspan="4">INPUT & OUTPUT</th>
                    <th rowspan="2" class="note-col">KETERANGAN</th>
                </tr>
                <tr>
                    <th class="vital-col">Nadi</th>
                    <th class="vital-col">Nafas</th>
                    <th class="bp-col">Sistole</th>
                    <th class="bp-col">Diastole</th>
                    <th class="io-col">Oral (ml)</th>
                    <th class="io-col">IV (ml)</th>
                    <th class="io-col">Diurosis (ml)</th>
                    <th class="io-col">Muntah (ml)</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kontrolJam as $item)
                    <tr>
                        <td class="time-col">{{ date('H:i', strtotime($item->jam)) }} WIB</td>
                        <td class="vital-col">{{ $item->nadi ?? '-' }}</td>
                        <td class="vital-col">{{ $item->nafas ?? '-' }}</td>
                        <td class="bp-col">{{ $item->sistole ?? '-' }}</td>
                        <td class="bp-col">{{ $item->diastole ?? '-' }}</td>
                        <td class="io-col">{{ $item->pemberian_oral ?? '-' }}</td>
                        <td class="io-col">{{ $item->cairan_intra_vena ?? '-' }}</td>
                        <td class="io-col">{{ $item->diurosis ?? '-' }}</td>
                        <td class="io-col">{{ $item->muntah ?? '-' }}</td>
                        <td class="note-col">{{ $item->keterangan ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" style="text-align: center; padding: 20px;">
                            Tidak ada data kontrol istimewa per jam untuk tanggal {{ date('d-m-Y', strtotime($tglPrint)) }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </main>
</body>

</html>