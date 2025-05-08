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
            font-size: 12px;
            table-layout: fixed;
            /* page-break-inside: avoid; */
        }

        main table thead {
            display: table-header-group;
        }

        main table tbody {
            page-break-inside: auto;
        }

        main table tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        main table tr.sum-row {
            page-break-inside: avoid;
        }

        main table th,
        main table td {
            text-align: left;
            border: 1px solid black;
            padding: 8px;
            text-align: left;
            overflow: hidden;
            word-wrap: break-word;
        }

        main table .table-section-title th {
            text-align: center;
            background-color: #dddddd
        }

        .date-repeat {
            text-align: center;
            font-style: italic;
            color: #555;
            background-color: #f5f5f5;
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
            <p>Intake dan Output Pasien Rawat Inap</p>
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
        <table border="1">
            <tr>
                <th>Ruang</th>
                <td>{{ $dataMedis->unit->nama_unit }}</td>
            </tr>
        </table>

        <table id="intake-table" style="margin-top: 20px;">
            <thead>
                <tr>
                    <th rowspan="2">TGL</th>
                    <th rowspan="2">JAM (WIB)</th>
                    <th colspan="4" style="text-align: center">OUTPUT</th>
                    <th rowspan="2" style="text-align: center">TOTAL OUTPUT</th>
                    <th colspan="4" style="text-align: center">INTAKE</th>
                    <th rowspan="2" style="text-align: center">TOTAL INTAKE</th>
                    <th rowspan="2" style="text-align: center">BALANCE CAIRAN</th>
                </tr>
                <tr>
                    <td>Urine</td>
                    <td>Muntah</td>
                    <td>Drain</td>
                    <td>IWL (Insesible waterloss)</td>
                    <td>IUFD</td>
                    <td>Minum</td>
                    <td>Makan</td>
                    <td>NGT</td>
                </tr>
            </thead>

            <tbody>
                @foreach ($intakeData as $intake)
                    <tr>
                        <td class="date-cell">{{ date('d M Y', strtotime($intake->tanggal)) }}</td>
                        <td>07:00 s.d 14:00</td>
                        <td>{{ $intake->output_pagi_urine }}</td>
                        <td>{{ $intake->output_pagi_muntah }}</td>
                        <td>{{ $intake->output_pagi_drain }}</td>
                        <td>{{ $intake->output_pagi_iwl }}</td>
                        <td style="background-color: #888888"></td>
                        <td>{{ $intake->intake_pagi_iufd }}</td>
                        <td>{{ $intake->intake_pagi_minum }}</td>
                        <td>{{ $intake->intake_pagi_makan }}</td>
                        <td>{{ $intake->intake_pagi_ngt }}</td>
                        <td style="background-color: #888888"></td>
                        <td style="background-color: #888888"></td>
                    </tr>

                    <tr>
                        <td class="date-cell date-repeat">
                            {{ date('d M Y', strtotime($intake->tanggal)) }}</td>
                        <td>14:00 s.d 20:00</td>
                        <td>{{ $intake->output_siang_urine }}</td>
                        <td>{{ $intake->output_siang_muntah }}</td>
                        <td>{{ $intake->output_siang_drain }}</td>
                        <td>{{ $intake->output_siang_iwl }}</td>
                        <td style="background-color: #888888"></td>
                        <td>{{ $intake->intake_siang_iufd }}</td>
                        <td>{{ $intake->intake_siang_minum }}</td>
                        <td>{{ $intake->intake_siang_makan }}</td>
                        <td>{{ $intake->intake_siang_ngt }}</td>
                        <td style="background-color: #888888"></td>
                        <td style="background-color: #888888"></td>
                    </tr>

                    <tr>
                        <td class="date-cell date-repeat">
                            {{ date('d M Y', strtotime($intake->tanggal)) }}</td>
                        <td>20:00 s.d 07:00</td>
                        <td>{{ $intake->output_malam_urine }}</td>
                        <td>{{ $intake->output_malam_muntah }}</td>
                        <td>{{ $intake->output_malam_drain }}</td>
                        <td>{{ $intake->output_malam_iwl }}</td>
                        <td style="background-color: #888888"></td>
                        <td>{{ $intake->intake_malam_iufd }}</td>
                        <td>{{ $intake->intake_malam_minum }}</td>
                        <td>{{ $intake->intake_malam_makan }}</td>
                        <td>{{ $intake->intake_malam_ngt }}</td>
                        <td style="background-color: #888888"></td>
                        <td style="background-color: #888888"></td>
                    </tr>

                    <tr class="sum-row">
                        <td class="date-cell date-repeat">
                            {{ date('d M Y', strtotime($intake->tanggal)) }}</td>
                        <td>Jumlah</td>
                        <td>{{ $intake->jml_urine }}</td>
                        <td>{{ $intake->jml_muntah }}</td>
                        <td>{{ $intake->jml_drain }}</td>
                        <td>{{ $intake->jml_iwl }}</td>
                        <td>{{ $intake->total_output }}</td>
                        <td>{{ $intake->jml_iufd }}</td>
                        <td>{{ $intake->jml_minum }}</td>
                        <td>{{ $intake->jml_makan }}</td>
                        <td>{{ $intake->jml_ngt }}</td>
                        <td>{{ $intake->total_intake }}</td>
                        <td>{{ $intake->balance_cairan }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>
</body>

</html>
