<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>CPPT - {{ $dataMedis->pasien->nama ?? '' }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 10mm;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 8pt;
            color: #333;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
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

        .unit-box {
            background-color: #bbbbbb;
            padding: 15px 0px;
            width: 100%;
            margin: 0 auto;
            text-align: center;
        }

        .unit-text {
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
            font-size: 9pt;
        }

        .patient-table th {
            background-color: #f2f2f2;
            text-align: left;
            width: 130px;
        }

        .cppt-main-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .cppt-main-table th,
        .cppt-main-table td {
            border: 1px solid #000;
            padding: 5px;
            vertical-align: top;
        }

        .cppt-main-table th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
            font-size: 8pt;
        }

        .cppt-main-table td {
            font-size: 7.5pt;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        /* Mengatur lebar kolom */
        .cppt-main-table .col-tanggal {
            width: 12%;
        }

        .cppt-main-table .col-profesi {
            width: 15%;
        }

        .cppt-main-table .col-rencana {
            width: 38%;
        }

        .cppt-main-table .col-instruksi {
            width: 20%;
        }

        .cppt-main-table th small {
            font-weight: normal;
        }


        .cppt-main-table .col-review {
            width: 15%;
        }

        .soap-label {
            font-weight: bold;
            margin-right: 3px;
        }

        .paraf-text {
            text-align: right;
            margin-top: 10px;
            font-style: italic;
        }

        .instruksi-ppa-box {
            font-size: 7pt;
        }

        .instruksi-ppa-item {
            margin-bottom: 3px;
        }

        .instruksi-ppa-item strong {
            display: block;
            margin-bottom: 1px;
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
                    <span class="title-main">CATATAN PERKEMBANGAN</span>
                    <span class="title-sub">PASIEN TERINTEGRASI (CPPT)</span>
                </td>
                <td class="td-right">
                    <div class="unit-box"><span class="unit-text" style="font-size: 14px;">RAWAT INAP</span></div>
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
    </table>

    <table class="cppt-main-table">
        <thead>
            <tr>
                <th class="col-tanggal">TANGGAL/JAM</th>
                <th class="col-profesi">Profesional Pemberi Asuhan</th>
                <th class="col-rencana"> HASIL ASESMEN PASIEN DAN PEMBERIAN PELAYANAN
                    <br><small>Tulis (SOAP/ ADIME disertai sasaran terukur)
                        Tulis nama dan paraf pada akhir catatan</small>
                </th>
                <th class="col-instruksi">
                    INSTRUKSI PPA
                    <br><small>(Tulis Instruksi PPA termasuk pasca bedah, tulis dengan rinci dan jelas)</small>
                </th>
                <th class="col-review">REVIEW & VERIFIKASI DPJP
                    <br><small>(Tulis nama, tgl,jam) DPJP harus membaca/ review seluruh rencana asuhan</small>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cppt as $key => $value)
                <tr>
                    <td class="col-tanggal">
                        {{ date('d/m/Y', strtotime($value['tanggal'])) }}<br>
                        {{ date('H:i', strtotime($value['jam'])) }}
                    </td>

                    <td class="col-profesi">
                        {{ $value['nama_penanggung'] }}<br>
                        <small>({{ str()->title($value['jenis_tenaga']) }})</small>

                        <img src="{{ generateQrCode($value['nama_penanggung'], 100, 'svg_datauri') }}" alt="QR Petugas" style="margin-top: 10px;">
                    </td>

                    <td class="col-rencana">
                        @if (!empty($value['tipe_cppt']) && $value['tipe_cppt'] != 4)
                            {{-- Format SOAP --}}
                            <p><span class="soap-label">S(Subjective):</span> {!! nl2br(e($value['anamnesis'] ?? '-')) !!}</p>

                            <p style="margin-top: 5px;"><span class="soap-label">O(Objective):</span></p>
                            <ul style="padding-left: 20px; margin: 0; list-style-type: none;">
                                @foreach ($value['kondisi']['konpas'] as $val)
                                    @if (!empty($val['hasil']))
                                        <li>{{ $val['nama_kondisi'] }}: <strong>{{ $val['hasil'] }}</strong>
                                            {{ $val['satuan'] }}</li>
                                    @endif
                                @endforeach
                            </ul>
                            <p style="margin-top: 5px;">{!! nl2br(e($value['pemeriksaan_fisik'] ?? '')) !!}</p>
                            <p>{!! nl2br(e($value['obyektif'] ?? '')) !!}</p>

                            <p style="margin-top: 5px;"><span class="soap-label">A(Assessment):</span>
                                @forelse ($value['cppt_penyakit'] as $v)
                                    {{ $v['nama_penyakit'] }}{{ !$loop->last ? '; ' : '' }}
                                @empty
                                    -
                                @endforelse
                            </p>
                            <p style="margin-top: 5px;"><span class="soap-label">P(Plan):</span> {!! nl2br(e($value['planning'] ?? '-')) !!}
                            </p>
                        @else
                            {{-- Format ADIME (Gizi) --}}
                            <p><span class="soap-label">A (Assessment):</span></p>
                            <ul style="padding-left: 20px; margin: 0 0 5px 0; list-style-type: none;">
                                @foreach ($value['kondisi']['konpas'] as $val)
                                    @if (!empty($val['hasil']))
                                        <li>{{ $val['nama_kondisi'] }}: <strong>{{ $val['hasil'] }}</strong>
                                            {{ $val['satuan'] }}</li>
                                    @endif
                                @endforeach
                            </ul>
                            <p>{!! nl2br(e($value['anamnesis'] ?? '-')) !!}</p>

                            <p style="margin-top: 5px;"><span class="soap-label">D (Diagnosis):</span>
                                @forelse ($value['cppt_penyakit'] as $v)
                                    {{ $v['nama_penyakit'] }}{{ !$loop->last ? '; ' : '' }}
                                @empty
                                    -
                                @endforelse
                            </p>
                            <p style="margin-top: 5px;"><span class="soap-label">I (Intervention):</span>
                                {!! nl2br(e($value['pemeriksaan_fisik'] ?? '-')) !!}</p>
                            <p style="margin-top: 5px;"><span class="soap-label">M (Monitoring):</span>
                                {!! nl2br(e($value['obyektif'] ?? '-')) !!}</p>
                            <p style="margin-top: 5px;"><span class="soap-label">E (Evaluation):</span>
                                {!! nl2br(e($value['planning'] ?? '-')) !!}</p>
                        @endif
                    </td>

                    <td class="col-instruksi">
                        @if (count($value['instruksi_ppa_nama']) > 0)
                            <div class="instruksi-ppa-box">
                                @foreach ($value['instruksi_ppa_nama'] as $instruksi)
                                    <div class="instruksi-ppa-item"
                                        style="margin-bottom: 8px; padding-bottom: 5px; border-bottom: 1px dotted #eee;">

                                        <div>{!! nl2br(e($instruksi['instruksi'])) !!}</div>

                                        <div
                                            style="text-align: right; font-style: italic; font-size: 7.5pt; margin-top: 5px;">
                                            ({{ $instruksi['nama_lengkap'] ?? $instruksi['ppa'] }})
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            -
                        @endif
                    </td>

                    <td class="col-review" style="text-align: center; vertical-align: middle;">
                        @if ($value['verified'])
                            <p style="font-size: 7.5pt; font-weight: bold; color: green;">
                                DIVERIFIKASI

                                <img src="{{ generateQrCode($value['nama_verified'], 100, 'svg_datauri') }}" alt="QR Petugas" style="margin-top: 10px;">

                                {{ $value['nama_verified'] }}
                            </p>
                        @else
                            <p style="font-size: 7.5pt; font-style: italic; color: #999;">
                                Belum Verifikasi
                            </p>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
