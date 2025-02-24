<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Asesmen THT</title>
    <style>
        @page {
            margin: 0.5cm 1cm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        header {
            width: 100%;
            display: table;
            padding-bottom: 20px;
            border-bottom: 2px solid black;
            margin-bottom: 20px;
        }

        .left-column {
            float: left;
            width: 20%;
            text-align: center;
        }

        .center-column {
            float: left;
            width: 40%;
            text-align: center;
            padding: 10px 0;
        }

        .right-column {
            float: right;
            width: 35%;
        }

        .header-logo {
            width: 80px;
            margin-bottom: 5px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 4px;
            border: 1px solid #333;
        }

        .clear {
            clear: both;
        }

        .content-section {
            margin-top: 20px;
        }

        .section-title {
            background: #f5f5f5;
            padding: 5px;
            font-weight: bold;
            border-left: 3px solid #333;
            margin-bottom: 10px;
        }

        .detail-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .detail-table th,
        .detail-table td {
            padding: 5px;
            border: 1px solid #333;
            font-size: 10px;
        }

        .sign-area {
            margin-top: 30px;
            page-break-inside: avoid;
        }

        .sign-box {
            float: right;
            width: 200px;
            text-align: center;
        }

        .sign-box p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <header>
        <div class="left-column">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/Logo-RSUD-Langsa-1.png'))) }}" class="header-logo" alt="Logo">
            <p>RSUD Langsa</p>
            <p>Jl. Jend. A. Yani No.1 Kota Langsa</p>
        </div>
        <div class="center-column">
            <h1 style="font-size: 16px;">Formulir Asesmen THT</h1>
        </div>
        <div class="right-column">
            <table class="info-table">
                <tr>
                    <td width="40%"><strong>No RM</strong></td>
                    <td>{{ $kunjungan->pasien->kd_pasien ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Nama</strong></td>
                    <td>{{ $kunjungan->pasien->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Jenis Kelamin</strong></td>
                    <td>{{ $kunjungan->pasien->jenis_kelamin == 1 ? 'Laki-laki' : 'Perempuan' }}</td>
                </tr>
                <tr>
                    <td><strong>Tanggal Lahir</strong></td>
                    <td>{{ $kunjungan->pasien->tgl_lahir ? date('d/m/Y', strtotime($kunjungan->pasien->tgl_lahir)) : '-' }}</td>
                </tr>
            </table>
        </div>
        <div class="clear"></div>
    </header>

    <div class="sign-area">
        <div class="sign-box">
            <p>Perawat yang Melakukan Asesmen</p>
            <br><br><br>
            <p>( _________________________ )</p>
            <p>{{ $asesmen->user->name ?? '.............................' }}</p>
        </div>
        <div class="clear"></div>
    </div>
</body>
</html>
