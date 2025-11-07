<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Bukti Pelayanan RJTL/RITL - {{ $dataMedis->pasien->nama ?? '' }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 10mm;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10pt;
            color: #000;
            margin: 0;
            padding: 0;
        }

        h2,
        h3,
        p {
            margin: 0;
            padding: 0;
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

        .brand-table {
            border-collapse: collapse;
            background-color: transparent;
        }

        .va-middle {
            vertical-align: middle;
        }

        .brand-logo {
            width: 70px;
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

        .slip {
            width: 100%;
            padding: 10px 15px;
            box-sizing: border-box;
            page-break-inside: avoid;
        }

        .page-break {
            page-break-after: always;
        }

        .data-table {
            width: 100%;
            margin-top: 20px;
            font-size: 10pt;
            border-collapse: collapse;
        }

        .data-table td {
            padding: 4px 2px;
            vertical-align: top;
        }

        .data-table td:nth-child(1) {
            width: 120px;
        }

        .data-table td:nth-child(2) {
            width: 10px;
        }

        .content-fields {
            margin-top: 15px;
            border-top: 1px dashed #777;
            padding-top: 10px;
        }

        .content-fields h5 {
            font-size: 11pt;
            font-weight: bold;
            margin: 10px 0 5px 0;
            text-decoration: underline;
        }

        .content-fields p {
            margin: 0 0 10px 0;
            min-height: 20px;
        }

        .content-fields img {
            max-width: 250px;
            max-height: 250px;
            display: block;
            margin-top: 10px;
            border: 1px solid #ccc;
        }

        .signature-block {
            margin-top: 40px;
            width: 100%;
            clear: both;
        }

        .sig-left {
            float: left;
            width: 45%;
            text-align: center;
        }

        .sig-right {
            float: right;
            width: 45%;
            text-align: center;
        }

        .sig-name {
            margin-top: 60px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    @php
        $countTindakan = count($tindakan);
        $index = 1;
    @endphp

    @foreach ($tindakan as $tdk)
        <header>
            <table class="header-table">
                <tr>
                    <td class="td-left">
                        <table class="brand-table">
                            <tr>
                                <td class="va-middle">
                                    <img src="{{ public_path('assets/img/Logo-RSUD-Langsa-1.png') }}"
                                        alt="Logo RSUD Langsa" class="brand-logo">
                                </td>
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
                        <span class="title-main">TINDAKAN</span>
                        <span class="title-sub">RAWAT JALAN</span>
                    </td>
                    <td class="td-right">
                        <div class="igd-box">
                            <span class="igd-text" style="font-size: 16px; padding: 10px;">RWJ</span>
                        </div>
                    </td>
                </tr>
            </table>
        </header>

        <div class="slip">
            <table class="data-table">
                <tr>
                    <td>NO RM</td>
                    <td>:</td>
                    <td>{{ $dataMedis->pasien->kd_pasien }}</td>
                </tr>
                <tr>
                    <td>NO SEP</td>
                    <td>:</td>
                    <td>{{ $sjp->NO_SJP ?? '...................' }}</td>
                </tr>
                <tr>
                    <td>NAMA</td>
                    <td>:</td>
                    <td>{{ $dataMedis->pasien->nama }}</td>
                </tr>
                <tr>
                    <td>TGL PELAYANAN</td>
                    <td>:</td>
                    <td>{{ \Carbon\Carbon::parse($tdk->tgl_tindakan)->format('d M Y H:i') }} WIB</td>
                </tr>
                <tr>
                    <td>POLI/RUANG</td>
                    <td>:</td>
                    <td>{{ $tdk->unit->nama_unit }}</td>
                </tr>
                <tr>
                    <td>DIAGNOSE</td>
                    <td>:</td>
                    <td>{{ $resume && $resume->diagnosis ? implode(', ', $resume->diagnosis) : '...................' }}
                    </td>
                </tr>
                <tr>
                    <td>JENIS TINDAKAN</td>
                    <td>:</td>
                    <td>{{ $tdk->produk->deskripsi }}</td>
                </tr>
            </table>

            <div class="content-fields">
                <h5>LAPORAN HASIL TINDAKAN:</h5>
                <p>{!! nl2br(e($tdk->laporan_hasil)) !!}</p>

                <h5>KESIMPULAN:</h5>
                <p>{!! nl2br(e($tdk->kesimpulan)) !!}</p>

                @if ($tdk->gambar)
                    <h5>GAMBAR:</h5>
                    <img src="{{ public_path('storage/' . $tdk->gambar) }}" alt="Gambar Tindakan">
                @endif
            </div>

            <div class="signature-block">
                <div class="sig-left">
                    TANDA TANGAN PASIEN
                    <div class="sig-name">
                        ({{ $dataMedis->pasien->nama }})
                    </div>
                </div>
                <div class="sig-right">
                    TANDA TANGAN DOKTER
                    <div class="sig-name">
                        ({{ $tdk->ppa->nama_lengkap }})
                    </div>
                </div>
            </div>
        </div>

        @if ($index < $countTindakan)
            <div class="page-break"></div>
        @endif

        @php $index++; @endphp
    @endforeach
</body>

</html>
