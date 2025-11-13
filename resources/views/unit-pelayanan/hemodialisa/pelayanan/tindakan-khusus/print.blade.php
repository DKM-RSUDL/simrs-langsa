<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tindakan Khusus Hemodialisa - {{ $dataMedis->pasien->nama ?? '' }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 10mm;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10pt;
            color: #333;
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
            width: 60px;
            height: auto;
            margin-right: 2px;
        }

        .brand-name {
            font-weight: 700;
            margin: 0;
            font-size: 14px;
        }

        .brand-info {
            margin: 0;
            font-size: 7px;
        }

        .title-main {
            display: block;
            font-size: 16px;
            font-weight: bold;
            margin: 0;
        }

        .title-sub {
            display: block;
            font-size: 14px;
            font-weight: bold;
            margin: 0;
        }

        .hd-box {
            background-color: #bbbbbb;
            padding: 15px 0px;
            width: 100%;
            margin: 0 auto;
            text-align: center;
        }

        .hd-text {
            font-size: 18px;
            font-weight: bold;
            color: #ffffff;
        }

        .patient-table {
            width: 100%;
            margin-top: 15px;
            border-collapse: collapse;
        }

        .patient-table th,
        .patient-table td {
            border: 1px solid #ccc;
            padding: 4px 6px;
            font-size: 9pt;
        }

        .patient-table th {
            background-color: #f2f2f2;
            text-align: left;
            width: 120px;
        }

        .section {
            margin-top: 15px;
            page-break-inside: avoid;
        }

        .section-title {
            font-size: 11pt;
            font-weight: bold;
            background-color: #097dd6;
            color: white;
            padding: 5px;
            margin-bottom: 5px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table td {
            padding: 4px 2px;
            vertical-align: top;
            border-bottom: 1px solid #eee;
        }

        .data-table td:nth-child(1) {
            width: 200px;
            font-weight: 500;
        }

        .data-table td:nth-child(2) {
            width: 10px;
        }

        .data-table td:nth-child(3) {
            color: #000;
        }

        .sig-table {
            width: 100%;
            margin-top: 40px;
            page-break-inside: avoid;
        }

        .sig-table td {
            width: 33%;
            text-align: center;
            vertical-align: top;
            border: none;
            padding: 0;
        }

        .sig-name {
            margin-top: 60px;
            font-weight: bold;
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
                            <td class="va-middle"><img src="{{ public_path('assets/img/Logo-RSUD-Langsa-1.png') }}"
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
                    <span class="title-main">TINDAKAN KHUSUS</span>
                    <span class="title-sub">HEMODIALISA (HD)</span>
                </td>
                <td class="td-right">
                    <div class="hd-box"><span class="hd-text">HEMODIALISA</span></div>
                </td>
            </tr>
        </table>
    </header>

    <table class="patient-table">
        <tr>
            <th>No. RM</th>
            <td>{{ $dataMedis->pasien->kd_pasien ?? '-' }}</td>
            <th>Tgl. Lahir</th>
            <td>{{ $dataMedis->pasien->tgl_lahir ? \Carbon\Carbon::parse($dataMedis->pasien->tgl_lahir)->format('d M Y') : '-' }}
            </td>
        </tr>
        <tr>
            <th>Nama Pasien</th>
            <td>{{ $dataMedis->pasien->nama ?? '-' }}</td>
            <th>Umur</th>
            <td>{{ $dataMedis->pasien->umur ?? '-' }} Tahun</td>
        </tr>
        <tr>
            <th>Jenis Kelamin</th>
            <td>{{ $dataMedis->pasien->jns_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
            <th>Tgl. Kunjungan</th>
            <td>{{ $dataMedis->tgl_masuk ? \Carbon\Carbon::parse($dataMedis->tgl_masuk)->format('d M Y') : '-' }}
            </td>
        </tr>
    </table>

    <div class="section">
        <div class="section-title">CATATAN TINDAKAN KHUSUS</div>

        @if ($tindakanKhusus)
            <table class="data-table">
                <tr>
                    <td>Tanggal Tindakan</td>
                    <td>:</td>
                    <td>{{ $tindakanKhusus->tanggal ? \Carbon\Carbon::parse($tindakanKhusus->tanggal)->format('d M Y') : '-' }}
                    </td>
                </tr>
                <tr>
                    <td>Jam Tindakan</td>
                    <td>:</td>
                    <td>{{ $tindakanKhusus->jam ? \Carbon\Carbon::parse($tindakanKhusus->jam)->format('H:i') : '-' }}
                    </td>
                </tr>
                <tr>
                    <td>Diagnosis</td>
                    <td>:</td>
                    <td>{!! nl2br(e($tindakanKhusus->diagnosis ?? '-')) !!}</td>
                </tr>
                <tr>
                    <td>Hasil Lab dan Penunjang</td>
                    <td>:</td>
                    <td>{!! nl2br(e($tindakanKhusus->hasil_lab ?? '-')) !!}</td>
                </tr>
                <tr>
                    <td>Obat-obatan dan Tindakan</td>
                    <td>:</td>
                    <td>{!! nl2br(e($tindakanKhusus->obat_tindakan ?? '-')) !!}</td>
                </tr>
                <tr>
                    <td>Follow Up</td>
                    <td>:</td>
                    <td>{!! nl2br(e($tindakanKhusus->follow_up ?? '-')) !!}</td>
                </tr>
                <tr>
                    <td>Catatan</td>
                    <td>:</td>
                    <td>{!! nl2br(e($tindakanKhusus->catatan ?? '-')) !!}</td>
                </tr>
            </table>
        @else
            <p>Tidak ada data tindakan khusus.</p>
        @endif
    </div>

    @php
        // Ambil nama petugas
        $namaPetugas = '-';
        if ($tindakanKhusus && $tindakanKhusus->userCreate && $tindakanKhusus->userCreate->karyawan) {
            $petugas = $tindakanKhusus->userCreate->karyawan;
            $namaPetugas =
                ($petugas->gelar_depan ? $petugas->gelar_depan . ' ' : '') .
                $petugas->nama .
                ($petugas->gelar_belakang ? ', ' . $petugas->gelar_belakang : '');
        }
    @endphp

</body>

</html>
