<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>TRIASE PASIEN GAWAT DARURAT - {{ $pasien->nama ?? '' }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 3mm;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10pt;
            color: #000;
        }

        h2,
        h3,
        p {
            margin: 0;
            padding: 0;
        }

        .checkbox {
            display: inline-block;
            width: 14px;
            height: 14px;
            border: 1px solid #000;
            line-height: 13px;
            text-align: center;
            font-size: 9pt;
            font-weight: bold;
            font-family: Arial, Helvetica, sans-serif !important;
            color: #000 !important;
            overflow: visible;
            vertical-align: middle;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #f0f0f0;
            padding: 0;
            position: relative;

        }

        .td-left {
            width: 40%;
            text-align: left;
            vertical-align: middle;
        }

        .td-center {
            width: 40%;
            text-align: center;
            vertical-align: middle;
        }

        .td-right {
            width: 20%;
            position: relative;
            padding: 0;
        }

        .title-main {
            display: block;
            font-size: 22px;
            font-weight: bold;
            letter-spacing: 1px;
            margin: 0;
        }

        .title-sub {
            display: block;
            font-size: 16px;
            font-weight: bold;
            margin: 0;
        }

        .igd-box {
            background-color: #bbbbbb;
            padding: 18px 0px;
            width: 100%;
            margin: 0 auto;
            text-align: center;
        }

        .igd-text {
            font-size: 24px;
            font-weight: bold;
            color: #ffffff;
        }

        .brand-table {
            border-collapse: collapse;
            background-color: transparent;
        }

        .va-middle {
            vertical-align: middle;
        }

        .brand-logo {
            width: 60px;
            height: auto;
            margin-right: 2px;
        }

        .brand-name {
            font-weight: 700;
            margin: 0;
            font-size: 16px;
        }

        .brand-info {
            margin: 0;
            font-size: 8px;
        }

        .info-table,
        .triage-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            /* tambahkan ini */
        }

        .triage-table th,
        .triage-table td {
            border: 1px solid #000;
            padding: 4px;
            font-size: 9pt;
            vertical-align: top;
        }

        .triage-table th {
            background: #f0f0f0;
            text-align: center;
        }

        .checkbox {
            display: inline-block;
            width: 14px;
            height: 14px;
            border: 1px solid #000;
            line-height: 13px;
            text-align: center;
            font-size: 10pt;
            font-weight: bold;
            color: #000;
            font-family: Arial, Helvetica, sans-serif !important;
            overflow: visible;
            vertical-align: middle;
        }



        .selected {
            font-weight: bold;
            background-color: rgba(0, 0, 0, 0.05);
        }

        .footer {
            margin-top: 80px;
            margin-right: 15px;
        }

        .ttd-wrapper {
            text-align: right;
            margin-right: 40px;
        }

        .label {
            margin-bottom: 80px;
            font-weight: normal;
        }

        .line,
        .nama {
            text-align: right;
            margin: 2px 0;
        }

        /* Warna lingkaran kode triase */
        .circle {
            display: inline-block;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .bg-dark {
            background-color: #000;
        }

        .bg-danger {
            background-color: #dc3545;
        }

        .bg-warning {
            background-color: #ffc107;
        }

        .bg-success {
            background-color: #28a745;
        }

        .circle-label {
            font-weight: bold;
            font-size: 10pt;
            vertical-align: middle;
        }

        .triase-box {
            text-align: center;
            margin-top: 15px;
            border: 1px solid #000;
            padding: 8px;
        }

        .signature {
            margin-top: 40px;
        }
    </style>
</head>

<body>
    <header>
        <table class="header-table">
            <tr>
                <td class="td-left">
                    <table class="brand-table">
                        <tr>
                            <td class="va-middle"><img
                                    src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/Logo-RSUD-Langsa-1.png'))) }}"
                                    alt="Logo" class="brand-logo"></td>
                            <td class="va-middle">
                                <p class="brand-name">RSUD Langsa</p>
                                <p class="brand-info">Jl. Jend. A. Yani No.1 Kota Langsa</p>
                                <p class="brand-info">Telp. 0641-22051, email: rsulangsa@gmail.com</p>
                                <p class="brand-info">www.rsud.langsakota.go.id</p>
                            </td>
                        </tr>
                    </table>
                </td>

                <td class="td-center">
                    <span class="title-main">TRIASE</span>
                    <span class="title-sub">PASIEN GAWAT DARURAT</span>
                </td>

                <td class="td-right">
                    <div class="igd-box">
                        <span class="igd-text">RWI</span>
                    </div>
                </td>
            </tr>
        </table>
    </header>

    {{-- =============================================== --}}
    {{-- AMBIL DATA TRIASE DAN DOKTER --}}
    {{-- =============================================== --}}

    @php
        use App\Models\Dokter;
        $dataTriase = $triase->triase ?? [];
        $dokterNama = \App\Models\Dokter::where('kd_dokter', $triase->dokter_triase)->value('nama_lengkap');
    @endphp


    {{-- DATA PASIEN --}}
    <table class="info-table">
        <tr>
            <td width="28%">Nama Pasien</td>
            <td>: {{ $triase->nama_pasien ?? '-' }}</td>
        </tr>
        <tr>
            <td>No. RM</td>
            <td>: {{ $triase->kd_pasien_triase ?? '-' }}</td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>: {{ $pasien->jenis_kelamin == 1 ? 'Laki-laki' : ($pasien->jenis_kelamin == 0 ? 'Perempuan' : '-') }}
            </td>
        </tr>
        <tr>
            <td>Tanggal Lahir</td>
            <td>: {{ carbon_parse($pasien->tgl_lahir, null, 'Y-m-d') }}
            </td>
        </tr>
        <tr>
            <td>Usia</td>
            <td>: {{ !empty($pasien->tgl_lahir) ? hitungUmur($pasien->tgl_lahir) : 'Tidak Diketahui' }}
                Thn</td>
        </tr>
        <tr>
            <td>Tanggal Triase</td>
            <td>:
                {{ carbon_parse($triase->tanggal_triase, null, 'Y-m-d') }}
            </td>
        </tr>
        <tr>
            <td>Jam Triase</td>
            <td>:
                {{ carbon_parse($triase->tanggal_triase, null, 'H:i') }}
            </td>
        </tr>
    </table>
    {{-- =============================================== --}}
    {{-- PEMERIKSAAN TRIASE (DOKTER) --}}
    {{-- =============================================== --}}
    <h3 style="text-align:center; margin-bottom: 10px;">PEMERIKSAAN TRIASE (DOKTER)</h3>

    <table class="triage-table">
        <tbody>
            <tr>
                <td style="width: 20%"><strong>JALAN NAFAS</strong></td>
                <td colspan="5">
                    @if (isset($dataTriase['air_way']))
                        <ul style="margin: 0; padding-left: 20px;">
                            @foreach ($dataTriase['air_way'] as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    @else
                        -
                    @endif
                </td>
            </tr>

            <tr>
                <td><strong>PERNAFASAN</strong></td>
                <td colspan="5">
                    @if (isset($dataTriase['breathing']))
                        <ul style="margin: 0; padding-left: 20px;">
                            @foreach ($dataTriase['breathing'] as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    @else
                        -
                    @endif
                </td>
            </tr>

            <tr>
                <td><strong>SIRKULASI</strong></td>
                <td colspan="5">
                    @if (isset($dataTriase['circulation']))
                        <ul style="margin: 0; padding-left: 20px;">
                            @foreach ($dataTriase['circulation'] as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    @else
                        -
                    @endif
                </td>
            </tr>

            <tr>
                <td><strong>KESADARAN</strong></td>
                <td colspan="5">
                    @if (isset($dataTriase['disability']))
                        <ul style="margin: 0; padding-left: 20px;">
                            @foreach ($dataTriase['disability'] as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    @else
                        -
                    @endif
                </td>
            </tr>
            @php
                $kdTriase = (int) ($triase->kode_triase ?? 0);
                $warna = '';
                $label = '';

                if ($kdTriase === 1) {
                    $warna = 'bg-danger';
                    $label = 'RESUSITASI';
                } elseif ($kdTriase === 2) {
                    $warna = 'bg-warning';
                    $label = 'URGENT';
                } elseif ($kdTriase === 3) {
                    $warna = 'bg-danger';
                    $label = 'EMERGENCY';
                } elseif ($kdTriase === 4) {
                    $warna = 'bg-success';
                    $label = 'FALSE EMERGENCY';
                } elseif ($kdTriase === 5) {
                    $warna = 'bg-dark';
                    $label = 'DOA';
                } else {
                    $warna = '';
                    $label = '-';
                }
            @endphp
            <tr>
                <td colspan="6" style="text-align:center; padding:15px;">
                    <span class="circle {{ $warna }}"></span>
                    <span class="circle-label" style="font-weight:bold;">{{ $label }}</span>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <div class="ttd-wrapper">
            <p class="label">Petugas Dokter Triase</p>
            <div class="space"></div>
            <p class="nama">( {{ $dokterNama ?? '_____________________' }} )</p>
        </div>
    </div>

</body>

</html>
