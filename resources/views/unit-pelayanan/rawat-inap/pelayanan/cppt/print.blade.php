<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak CPPT - {{ $dataMedis->pasien->nama_pasien ?? 'Pasien' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 10pt;
            color: #000;
            background-color: #fff;
        }

        .container-print {
            max-width: 100%;
            margin: 0;
            padding: 0;
        }

        .print-header {
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-left {
            display: flex;
            align-items: center;
        }

        .header-left img {
            width: 70px;
            /* Sesuaikan ukuran logo */
            height: auto;
            margin-right: 15px;
        }

        .header-left .title-container {
            text-align: center;
        }

        .header-left h4 {
            font-size: 1.4rem;
            font-weight: bold;
            margin-bottom: 2px;
        }

        .header-left p {
            font-size: 0.8rem;
            margin-bottom: 0;
            line-height: 1.3;
        }

        .patient-info {
            border: 2px solid #000;
            padding: 8px;
            font-size: 9pt;
            width: 300px;
            /* Lebar kotak info pasien */
            min-height: 80px;
            /* Tinggi minimal */
        }

        .patient-info table {
            width: 100%;
        }

        .patient-info td {
            padding: 1px 3px;
            vertical-align: top;
        }

        .patient-info .label {
            width: 70px;
            font-weight: 600;
        }

        .main-table {
            width: 100%;
            border-collapse: collapse;
            border: 2px solid #000;
        }

        .main-table th,
        .main-table td {
            border: 1px solid #000;
            padding: 8px;
            vertical-align: top;
            text-align: left;
            word-break: break-word;
            /* Mencegah teks meluber */
        }

        .main-table thead th {
            font-size: 9pt;
            font-weight: bold;
            text-align: center;
            vertical-align: middle;
            background-color: #f0f0f0;
        }

        /* Penyesuaian lebar kolom agar sesuai gambar */
        .col-datetime {
            width: 8%;
        }

        .col-ppa {
            width: 15%;
        }

        .col-soap {
            width: 37%;
        }

        .col-instruksi {
            width: 25%;
        }

        .col-verif {
            width: 15%;
        }

        .ppa-info strong {
            display: block;
            font-size: 10pt;
        }

        .ppa-info small {
            font-size: 8pt;
            color: #333;
        }

        .soap-container {
            font-size: 9pt;
        }

        .soap-s,
        .soap-o,
        .soap-a,
        .soap-p,
        .soap-d,
        .soap-i,
        .soap-m,
        .soap-e {
            margin-bottom: 5px;
        }

        .soap-container strong {
            font-size: 10pt;
        }

        .soap-o ul,
        .soap-a ul {
            padding-left: 20px;
            margin-bottom: 0;
            list-style-type: disc;
        }

        .soap-o li,
        .soap-a li {
            font-size: 9pt;
        }

        .instruksi-list {
            font-size: 9pt;
            margin-bottom: 0;
            padding-left: 0;
            list-style: none;
        }

        .instruksi-list li {
            margin-bottom: 5px;
            padding-bottom: 5px;
            border-bottom: 1px dashed #ccc;
        }

        .instruksi-list li:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .instruksi-list strong {
            display: block;
            color: #000;
        }

        .verification-status {
            font-size: 9pt;
            text-align: center;
        }

        .verification-status .verified {
            color: #006400;
            font-weight: bold;
        }

        .verification-status .unverified {
            color: #888;
            font-style: italic;
        }

        @page {
            size: A4 landscape;
            /* Mengatur halaman menjadi landscape */
            margin: 0.5in;
        }

        @media print {
            body {
                margin: 0;
                font-size: 10pt;
            }

            .container-print {
                width: 100%;
                padding: 0;
            }

            .main-table thead th {
                background-color: #f0f0f0 !important;
                -webkit-print-color-adjust: exact;
                /* Memaksa print background color */
                color-adjust: exact;
            }

            .main-table td {
                page-break-inside: avoid;
                /* Mencegah baris terpotong */
            }

            .main-table tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }

            .main-table thead {
                display: table-header-group;
                /* Memastikan header tabel muncul di setiap halaman */
            }
        }
    </style>
</head>

<body>
    <div class="container-print">
        <div class="print-header">
            <div class="header-left">
                <img src="{{ asset('assets/img/logo_rs.png') }}" alt="Logo RS">
                <div class="title-container">
                    <h4>CATATAN PERKEMBANGAN PASIEN TERINTEGRASI</h4>
                    <p>
                        <strong>RSUD LANGSA (Contoh)</strong><br>
                        Jl. Jend. A. Yani, Paya Bujok Seuleumak, Langsa Baro, Kota Langsa
                    </p>
                </div>
            </div>

            <div class="patient-info">
                <table>
                    <tbody>
                        <tr>
                            <td class="label">NRM</td>
                            <td>: {{ $dataMedis->kd_pasien ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Nama</td>
                            <td>: {{ $dataMedis->pasien->nama_pasien ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Jenis Kelamin</td>
                            <td>: {{ $dataMedis->pasien->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Tanggal Lahir</td>
                            <td>:
                                {{ $dataMedis->pasien->tgl_lahir ? date('d-m-Y', strtotime($dataMedis->pasien->tgl_lahir)) : '-' }}
                                (Umur {{ $dataMedis->pasien->umur ?? '-' }} Thn)
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <table class="main-table">
            <thead>
                <tr>
                    <th class="col-datetime">TGL/JAM</th>
                    <th class="col-ppa">PROFESIONAL PEMBERI ASUHAN</th>
                    <th class="col-soap">HASIL ASESMEN PASIEN DAN PEMBERIAN PELAYANAN
                        <br><small>(Tulis SOAP/ADIME disertai sasaran terukur)
                            Tulis nama dan paraf pada akhir catatan</small>
                    </th>
                    <th class="col-instruksi">INSTRUKSI PPA
                        <br><small>(Tulis Instruksi PPA termasuk pasca bedah,
                            tulis dengan rinci dan jelas)</small>
                    </th>
                    <th class="col-verif">REVIEW & VERIFIKASI DPJP
                        <br><small>(Tulis nama, tgl, jam. DPJP harus
                            membaca/review seluruh rencana asuhan)</small>
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($cppt as $value)
                    <tr>
                        <td class="text-center">
                            {{ date('d-m-Y', strtotime($value['tanggal'])) }}<br>
                            <strong>{{ date('H:i', strtotime($value['jam'])) }}</strong>
                        </td>

                        <td>
                            <div class="ppa-info">
                                <strong>{{ $value['nama_penanggung'] }}</strong>
                                <small>({{ str()->title($value['jenis_tenaga']) }})</small>
                            </div>
                        </td>

                        <td>
                            <div class="soap-container">
                                @if (!empty($value['tipe_cppt']) && $value['tipe_cppt'] != 4)
                                    <div class="soap-s">
                                        <strong>S:</strong> {{ $value['anamnesis'] ?? '-' }}
                                    </div>
                                    <div class="soap-o">
                                        <strong>O:</strong>
                                        <ul>
                                            @foreach ($value['kondisi']['konpas'] as $val)
                                                <li>
                                                    {{ $val['nama_kondisi'] }} : <strong>{{ $val['hasil'] }}</strong>
                                                    {{ $val['satuan'] }}
                                                </li>
                                            @endforeach
                                        </ul>
                                        <p class="mb-0">{{ $value['pemeriksaan_fisik'] }}</p>
                                        <p class="mb-0">{{ $value['obyektif'] }}</p>
                                    </div>
                                    <div class="soap-a">
                                        <strong>A:</strong>
                                        <ul>
                                            @forelse ($value['cppt_penyakit'] as $v)
                                                <li>{{ $v['nama_penyakit'] }}</li>
                                            @empty
                                                <li>-</li>
                                            @endforelse
                                        </ul>
                                    </div>
                                    <div class="soap-p">
                                        <strong>P:</strong> {{ $value['planning'] ?? '-' }}
                                    </div>
                                @else
                                    <div class="soap-a">
                                        <strong>A (Assessment):</strong> {{ $value['anamnesis'] ?? '-' }}
                                        <ul>
                                            @foreach ($value['kondisi']['konpas'] as $val)
                                                <li>
                                                    {{ $val['nama_kondisi'] }} : <strong>{{ $val['hasil'] }}</strong>
                                                    {{ $val['satuan'] }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="soap-d">
                                        <strong>D (Diagnosis):</strong>
                                        <ul>
                                            @forelse ($value['cppt_penyakit'] as $v)
                                                <li>{{ $v['nama_penyakit'] }}</li>
                                            @empty
                                                <li>-</li>
                                            @endforelse
                                        </ul>
                                    </div>
                                    <div class="soap-i">
                                        <strong>I (Intervention):</strong> {{ $value['pemeriksaan_fisik'] ?? '-' }}
                                    </div>
                                    <div class="soap-m">
                                        <strong>M (Monitoring):</strong> {{ $value['obyektif'] ?? '-' }}
                                    </div>
                                    <div class="soap-e">
                                        <strong>E (Evaluation):</strong> {{ $value['planning'] ?? '-' }}
                                    </div>
                                @endif
                            </div>
                        </td>

                        <td>
                            <ul class="instruksi-list">
                                @forelse ($value['instruksi_ppa_nama'] as $instruksi)
                                    @php
                                        // Logika untuk mendapatkan nama PPA dari $karyawan
                                        $ppa_kode = is_array($instruksi) ? $instruksi['ppa'] : $instruksi->ppa;
                                        $karyawan_ppa = $karyawan->where('kd_karyawan', $ppa_kode)->first();
                                        $nama_ppa = $karyawan_ppa
                                            ? trim(
                                                ($karyawan_ppa->gelar_depan ? $karyawan_ppa->gelar_depan . ' ' : '') .
                                                    $karyawan_ppa->nama .
                                                    ($karyawan_ppa->gelar_belakang
                                                        ? ', ' . $karyawan_ppa->gelar_belakang
                                                        : ''),
                                            )
                                            : $ppa_kode;
                                    @endphp
                                    <li>
                                        <strong>Kepada: {{ $nama_ppa }}</strong>
                                        {{ is_array($instruksi) ? $instruksi['instruksi'] : $instruksi->instruksi }}
                                    </li>
                                @empty
                                    <li class="text-center text-muted">(Tidak ada instruksi)</li>
                                @endforelse
                            </ul>
                        </td>

                        <td>
                            <div class="verification-status">
                                @if ($value['verified'])
                                    <span class="verified">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06l2.5 2.5a.75.75 0 0 0 1.06 0l4.5-4.5a.75.75 0 0 0 .022-1.08z" />
                                        </svg>
                                        Terverifikasi
                                    </span>
                                    {{-- <small>Oleh: ...</small> --}}
                                @else
                                    <span class="unverified">(Belum Diverifikasi)</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Belum ada data CPPT.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>





