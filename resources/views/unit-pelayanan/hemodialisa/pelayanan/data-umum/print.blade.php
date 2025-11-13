<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Umum Hemodialisa - {{ $dataMedis->pasien->nama ?? '' }}</title>
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
            padding: 5px 7px;
            font-size: 10pt;
        }

        .patient-table th {
            background-color: #f2f2f2;
            text-align: left;
            width: 130px;
        }

        .section {
            margin-top: 15px;
            page-break-inside: avoid;
        }

        .section-header {
            background-color: #f8f9fa;
            padding: 5px;
            font-weight: bold;
            text-align: center;
            border: 1px solid #dee2e6;
            margin-bottom: 5px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table td {
            padding: 5px 3px;
            vertical-align: top;
            border-bottom: 1px solid #eee;
        }

        .data-table td:nth-child(1) {
            width: 220px;
            font-weight: 500;
        }

        .data-table td:nth-child(2) {
            width: 10px;
        }

        .data-table td:nth-child(3) {
            color: #000;
        }

        .alergi-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
        }

        .alergi-table th,
        .alergi-table td {
            border: 1px solid #ccc;
            padding: 5px;
            text-align: left;
        }

        .alergi-table th {
            background-color: #f2f2f2;
        }

        .signature-block {
            margin-top: 50px;
            width: 100%;
            clear: both;
            page-break-inside: avoid;
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
    @endphp

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
                    <span class="title-main">DATA UMUM PASIEN</span>
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
            <th>Tgl. Input</th>
            <td>{{ $dataUmum->created_at ? \Carbon\Carbon::parse($dataUmum->created_at)->format('d M Y H:i') : '-' }}
            </td>
        </tr>
    </table>

    <div class="section">
        <div class="section-header">DATA PASIEN</div>
        <table class="data-table">
            <tr>
                <td>Agama</td>
                <td>:</td>
                <td>{{ str()->title($dataMedis->pasien->agama->agama ?? '-') }}</td>
            </tr>
            <tr>
                <td>Pendidikan</td>
                <td>:</td>
                <td>{{ str()->title($dataMedis->pasien->pendidikan->pendidikan ?? '-') }}</td>
            </tr>
            <tr>
                <td>Status Pernikahan</td>
                <td>:</td>
                <td>{{ $dataMedis->pasien->marital->jenis ?? '-' }}</td>
            </tr>
            <tr>
                <td>Pekerjaan</td>
                <td>:</td>
                <td>{{ str()->title($dataMedis->pasien->pekerjaan->pekerjaan ?? '-') }}</td>
            </tr>
            <tr>
                <td>Alamat lengkap</td>
                <td>:</td>
                <td>
                    {{ str()->title($dataMedis->pasien->alamat ?? '') . ', ' . str()->title($dataMedis->pasien->kelurahan->kelurahan ?? '') . ', ' . str()->title($dataMedis->pasien->kelurahan->kecamatan->kecamatan ?? '') . ', ' . str()->title($dataMedis->pasien->kelurahan->kecamatan->kabupaten->kabupaten ?? '') . ', ' . str()->title($dataMedis->pasien->kelurahan->kecamatan->kabupaten->propinsi->propinsi ?? '') }}
                </td>
            </tr>
            <tr>
                <td>No Identitas</td>
                <td>:</td>
                <td>{{ $dataMedis->pasien->no_pengenal ?? '-' }}</td>
            </tr>
            <tr>
                <td>No Kartu BPJS</td>
                <td>:</td>
                <td>{{ $dataMedis->pasien->no_asuransi ?? '-' }}</td>
            </tr>
            <tr>
                <td>No Telpon/ HP</td>
                <td>:</td>
                <td>{{ $dataUmum->pasien_no_telpon ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-header">RIWAYAT ALERGI</div>
        <table class="alergi-table">
            <thead>
                <tr>
                    <th>Jenis Alergi</th>
                    <th>Alergen</th>
                    <th>Reaksi</th>
                    <th>Tingkat Keparahan</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop ini diambil dari $alergiPasien (sesuai controller show) -->
                @if ($alergiPasien && $alergiPasien->count() > 0)
                    @foreach ($alergiPasien as $alergi)
                        <tr>
                            <td>{{ $alergi->jenis_alergi ?? '-' }}</td>
                            <td>{{ $alergi->nama_alergi ?? '-' }}</td>
                            <td>{{ $alergi->reaksi ?? '-' }}</td>
                            <td>{{ $alergi->tingkat_keparahan ?? '-' }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" style="text-align: center;">Tidak ada data alergi</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <div class="section">
        <div class="section-header">IDENTITAS PENANGGUNG JAWAB PASIEN</div>
        <table class="data-table">
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>{{ $dataUmum->pj_nama ?? '-' }}</td>
            </tr>
            <tr>
                <td>Hubungan keluarga</td>
                <td>:</td>
                <td>{{ $dataUmum->pj_hubungan_keluarga ?? '-' }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>{{ $dataUmum->pj_alamat ?? '-' }}</td>
            </tr>
            <tr>
                <td>Pekerjaan</td>
                <td>:</td>
                <td>{{ $dataUmum->pj_pekerjaan ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-header">DATA HEMODIALISIS (Diisi petugas HD)</div>
        <table class="data-table">
            <tr>
                <td>HD pertama kali tanggal</td>
                <td>:</td>
                <td>{{ $dataUmum->hd_pertama_kali ? \Carbon\Carbon::parse($dataUmum->hd_pertama_kali)->format('d M Y') : '-' }}
                </td>
            </tr>
            <tr>
                <td>Mulai HD rutin tanggal</td>
                <td>:</td>
                <td>{{ $dataUmum->mulai_hd_rutin ? \Carbon\Carbon::parse($dataUmum->mulai_hd_rutin)->format('d M Y') : '-' }}
                </td>
            </tr>
            <tr>
                <td>Frekuensi HD</td>
                <td>:</td>
                <td>{{ $dataUmum->frekuensi_hd ?? '-' }}</td>
            </tr>
            <tr>
                <td>Status pembayaran</td>
                <td>:</td>
                <td>{{ $dataUmum->status_pembayaran ?? '-' }}</td>
            </tr>
            <tr>
                <td>Dokter pengirim</td>
                <td>:</td>
                <td>{{ $dataUmum->dokter_pengirim ?? '-' }}</td>
            </tr>
            <tr>
                <td>Asal rujukan</td>
                <td>:</td>
                <td>{{ $dataUmum->asal_rujukan ?? '-' }}</td>
            </tr>
            <tr>
                <td>Diagnosis</td>
                <td>:</td>
                <td>{{ $dataUmum->diagnosis ?? '-' }}</td>
            </tr>
            <tr>
                <td>Etiologi</td>
                <td>:</td>
                <td>{{ $dataUmum->etiologi ?? '-' }}</td>
            </tr>
            <tr>
                <td>Penyakit penyerta</td>
                <td>:</td>
                <td>{{ $dataUmum->penyakit_penyerta ?? '-' }}</td>
            </tr>
        </table>
    </div>
</body>

</html>
