<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Intake dan Output Cairan Rawat Inap</title>

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

        .total-cell {
            background-color: #888888;
        }

        .summary-row {
            background-color: #f0f0f0;
            font-weight: bold;
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
                @php
                    // Group data by tanggal untuk menampilkan per hari
                    $groupedData = $intakeData->groupBy('tanggal');
                    $totalIntakeAll = 0;
                    $totalOutputAll = 0;
                    $totalBalanceAll = 0;
                @endphp

                @foreach ($groupedData as $tanggal => $dataPerTanggal)
                    @php
                        // Inisialisasi data untuk setiap shift
                        $shiftData = [
                            1 => ['shift_time' => '07:00 s.d 14:00', 'data' => null],
                            2 => ['shift_time' => '14:00 s.d 20:00', 'data' => null],
                            3 => ['shift_time' => '20:00 s.d 07:00', 'data' => null]
                        ];

                        // Isi data yang ada
                        foreach ($dataPerTanggal as $data) {
                            $shiftData[$data->shift]['data'] = $data;
                        }

                        // Hitung total per hari
                        $dailyTotalOutput = $dataPerTanggal->sum('total_output');
                        $dailyTotalIntake = $dataPerTanggal->sum('total_intake');
                        $dailyBalance = $dailyTotalIntake - $dailyTotalOutput;

                        $totalIntakeAll += $dailyTotalIntake;
                        $totalOutputAll += $dailyTotalOutput;
                        $totalBalanceAll += $dailyBalance;
                    @endphp

                    {{-- Tampilkan data per shift --}}
                    @foreach ($shiftData as $shift => $shiftInfo)
                        <tr>
                            <td class="date-cell {{ $shift > 1 ? 'date-repeat' : '' }}">
                                {{ $shift == 1 ? date('d M Y', strtotime($tanggal)) : date('d M Y', strtotime($tanggal)) }}
                            </td>
                            <td>{{ $shiftInfo['shift_time'] }}</td>
                            
                            @if ($shiftInfo['data'])
                                {{-- Jika ada data untuk shift ini --}}
                                <td>{{ $shiftInfo['data']->output_urine ?? 0 }}</td>
                                <td>{{ $shiftInfo['data']->output_muntah ?? 0 }}</td>
                                <td>{{ $shiftInfo['data']->output_drain ?? 0 }}</td>
                                <td>{{ $shiftInfo['data']->output_iwl ?? 0 }}</td>
                                <td class="total-cell"></td>
                                <td>{{ $shiftInfo['data']->intake_iufd ?? 0 }}</td>
                                <td>{{ $shiftInfo['data']->intake_minum ?? 0 }}</td>
                                <td>{{ $shiftInfo['data']->intake_makan ?? 0 }}</td>
                                <td>{{ $shiftInfo['data']->intake_ngt ?? 0 }}</td>
                                <td class="total-cell"></td>
                                <td class="total-cell"></td>
                            @else
                                {{-- Jika tidak ada data untuk shift ini --}}
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td class="total-cell"></td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td class="total-cell"></td>
                                <td class="total-cell"></td>
                            @endif
                        </tr>
                    @endforeach

                    {{-- Row Summary per hari --}}
                    <tr class="sum-row summary-row">
                        <td class="date-cell date-repeat">{{ date('d M Y', strtotime($tanggal)) }}</td>
                        <td><strong>Jumlah</strong></td>
                        <td><strong>{{ $dataPerTanggal->sum('output_urine') }}</strong></td>
                        <td><strong>{{ $dataPerTanggal->sum('output_muntah') }}</strong></td>
                        <td><strong>{{ $dataPerTanggal->sum('output_drain') }}</strong></td>
                        <td><strong>{{ $dataPerTanggal->sum('output_iwl') }}</strong></td>
                        <td><strong>{{ $dailyTotalOutput }}</strong></td>
                        <td><strong>{{ $dataPerTanggal->sum('intake_iufd') }}</strong></td>
                        <td><strong>{{ $dataPerTanggal->sum('intake_minum') }}</strong></td>
                        <td><strong>{{ $dataPerTanggal->sum('intake_makan') }}</strong></td>
                        <td><strong>{{ $dataPerTanggal->sum('intake_ngt') }}</strong></td>
                        <td><strong>{{ $dailyTotalIntake }}</strong></td>
                        <td><strong>{{ $dailyBalance > 0 ? '+' : '' }}{{ $dailyBalance }}</strong></td>
                    </tr>
                @endforeach

                {{-- Grand Total --}}
                @if ($groupedData->count() > 1)
                    <tr class="sum-row" style="background-color: #d0d0d0; font-weight: bold;">
                        <td colspan="2" style="text-align: center;"><strong>GRAND TOTAL</strong></td>
                        <td><strong>{{ $intakeData->sum('output_urine') }}</strong></td>
                        <td><strong>{{ $intakeData->sum('output_muntah') }}</strong></td>
                        <td><strong>{{ $intakeData->sum('output_drain') }}</strong></td>
                        <td><strong>{{ $intakeData->sum('output_iwl') }}</strong></td>
                        <td><strong>{{ $totalOutputAll }}</strong></td>
                        <td><strong>{{ $intakeData->sum('intake_iufd') }}</strong></td>
                        <td><strong>{{ $intakeData->sum('intake_minum') }}</strong></td>
                        <td><strong>{{ $intakeData->sum('intake_makan') }}</strong></td>
                        <td><strong>{{ $intakeData->sum('intake_ngt') }}</strong></td>
                        <td><strong>{{ $totalIntakeAll }}</strong></td>
                        <td><strong>{{ $totalBalanceAll > 0 ? '+' : '' }}{{ $totalBalanceAll }}</strong></td>
                    </tr>
                @endif
            </tbody>
        </table>
    </main>
</body>

</html>