<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Form A - Evaluasi Awal MPP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            line-height: 1.2;
            margin: 2mm;
        }

        .header {
            display: table;
            width: 100%;
            margin-bottom: 10px;
        }

        .header-row {
            display: table-row;
        }

        .hospital-info {
            display: table-cell;
            vertical-align: top;
            width: 25%;
            text-align: left;
        }

        .title-section {
            display: table-cell;
            vertical-align: top;
            width: 45%;
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            padding: 8px 10px 0 10px;
        }

        .patient-info-cell {
            display: table-cell;
            vertical-align: top;
            width: 30%;
            text-align: right;
        }

        .hospital-info img {
            width: 50px;
            height: auto;
            vertical-align: middle;
            margin-right: 8px;
        }

        .hospital-info .info-text {
            display: inline-block;
            vertical-align: middle;
            font-size: 9pt;
        }

        .hospital-info .info-text .title {
            font-size: 12pt;
            font-weight: bold;
            margin-bottom: 1px;
        }

        .hospital-info .info-text p {
            margin: 0;
        }

        .patient-info-box {
            display: inline-block;
            text-align: left;
            border: 1px solid #000;
            padding: 8px;
            font-size: 9pt;
            width: 180px;
            box-sizing: border-box;
        }

        .patient-info-box p {
            margin: 0;
            line-height: 1.3;
        }

        .doctor-info {
            margin: 10px 0;
            font-size: 9pt;
        }

        .doctor-info table {
            width: 100%;
        }

        .doctor-info td {
            padding: 2px 5px;
            border: none;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            page-break-inside: auto;
            /* Allow tables to break across pages */
        }

        .table th,
        .table td {
            border: 1px solid #000;
            padding: 4px;
            vertical-align: top;
            font-size: 9pt;
            text-align: left;
        }

        .table tr {
            page-break-inside: avoid;
            /* Try to keep rows on one page */
            page-break-after: auto;
        }

        .table th.datetime-col,
        .table td.datetime-col {
            width: 120px;
            text-align: center;
            vertical-align: middle;
            /* Align content to the middle */
        }

        .section-header {
            background-color: #e9ecef;
            font-weight: bold;
            text-align: center;
            font-size: 10pt;
            page-break-after: avoid;
        }

        .criteria-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 3px;
            padding: 2px 0;
        }

        .criteria-item:last-child {
            margin-bottom: 0;
        }

        .criteria-checkbox {
            margin-right: 5px;
            margin-top: 1px;
            flex-shrink: 0;
            width: 12px;
            height: 12px;
        }

        .criteria-label {
            flex: 1;
            font-size: 8pt;
            line-height: 1.3;
        }

        .datetime-display {
            font-size: 8pt;
            text-align: center;
        }

        .signature {
            text-align: right;
            margin-top: 30px;
            width: 100%;
            page-break-before: avoid;
        }

        .signature div {
            display: inline-block;
            text-align: center;
            width: 250px;
        }

        .signature p {
            margin: 0;
            font-size: 9pt;
        }

        .signature .underline {
            border-bottom: 1px solid #000;
            width: 200px;
            margin: 50px auto 5px;
        }

        /* Tambahkan CSS ini di bagian style yang sudah ada */

        .criteria-label {
            flex: 1;
            font-size: 8pt;
            line-height: 1.3;
            word-wrap: break-word; /* Untuk handle text panjang */
            overflow-wrap: break-word;
        }

        /* Styling khusus untuk text lain-lain */
        .lain-lain-text {
            font-style: italic;
            color: #333;
            margin-left: 3px;
        }

        /* Pastikan text tidak overflow pada print */
        @media print {
            .criteria-label {
                font-size: 8pt !important;
                line-height: 1.3 !important;
                word-break: break-word;
                hyphens: auto;
            }
            
            .lain-lain-text {
                font-style: italic !important;
                color: #333 !important;
            }
        }

        /**************************************************/
        /* SOLUSI UNTUK ROWSPAN YANG RUSAK SAAT PRINT      */
        /**************************************************/
        .screening-row+.screening-row .datetime-col,
        .assessment-row+.assessment-row .datetime-col,
        .identification-row+.identification-row .datetime-col,
        .planning-row+.planning-row .datetime-col {
            /* Hapus border atas pada sel tanggal/jam yang melanjutkan grup yang sama.
                   Ini menciptakan ilusi visual sel yang digabung. */
            border-top: none;
        }

        @media print {
            body {
                font-family: Arial, sans-serif;
                /* Pastikan font konsisten */
            }

            .table {
                page-break-inside: auto !important;
            }

            .table tr {
                page-break-inside: avoid !important;
            }
        }
    </style>
</head>

<body>
    <!-- HEADER SECTION -->
    <div class="header">
        <div class="header-row">
            <div class="hospital-info">
                @if (isset($logoPath) && file_exists($logoPath))
                    <img src="{{ $logoPath }}" alt="Logo RSUD Langsa">
                @endif
                <div class="info-text">
                    <p class="title">RSUD LANGSA</p>
                    <p>Jl. Jend. A. Yani Kota Langsa</p>
                    <p>Telp. 0641 - 32051</p>
                    <p>rsudlangsa.aceh@gmail.com</p>
                </div>
            </div>
            <div class="title-section">
                FORM A<br>
                EVALUASI AWAL MPP<br>
                <i style="font-size: 10pt">(MANAJEMEN PELAYANAN PASIEN)</i>
            </div>
            <div class="patient-info-cell">
                <div class="patient-info-box">
                    <p><b>NO RM: {{ $dataMedis->kd_pasien ?? 'N/A' }}</b></p>
                    <p>Nama: {{ $dataMedis->pasien->nama ?? 'N/A' }}</p>
                    <p>Jenis Kelamin:
                        {{ ($dataMedis->pasien->jenis_kelamin ?? '') == '1' ? 'Laki-laki' : (($dataMedis->pasien->jenis_kelamin ?? '') == '0' ? 'Perempuan' : 'N/A') }}
                    </p>
                    <p>Tanggal Lahir:
                        {{ $dataMedis->pasien->tgl_lahir ? Carbon\Carbon::parse($dataMedis->pasien->tgl_lahir)->format('d-m-Y') : 'N/A' }}
                    </p>
                    <p>Umur: {{ $dataMedis->pasien->umur ?? 'N/A' }} Tahun</p>
                </div>
            </div>
        </div>
    </div>
    <hr style="border: 0.5px solid #000; margin-top: 5px; margin-bottom: 10px;">

    <!-- Doctor Information -->
    <div class="doctor-info">
        <table>
            <tr>
                <td style="width: 15%;"><strong>DPJP Utama:</strong></td>
                <td style="width: 35%;">{{ $dpjpUtama ? $dpjpUtama->nama : '-' }}</td>
                <td style="width: 15%;"><strong>DPJP Tambahan:</strong></td>
                <td style="width: 35%;">
                    @if ($dpjpTambahan && count($dpjpTambahan) > 0)
                        @foreach ($dpjpTambahan as $index => $dokter)
                            {{ $index + 1 }}. {{ $dokter->nama }}@if (!$loop->last)
                                <br>
                            @endif
                        @endforeach
                    @else
                        -
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <!-- SECTION I: IDENTIFIKASI/SCREENING PASIEN -->
    <table class="table">
        <thead>
            <tr>
                <th class="datetime-col">TANGGAL DAN JAM</th>
                <th>CATATAN</th>
            </tr>
        </thead>
        <tbody>
            <tr class="section-header">
                <td colspan="2">I. IDENTIFIKASI/SCREENING PASIEN</td>
            </tr>
            <!-- Update untuk bagian screening criteria di print view -->
            @foreach ([
        ['key' => 'fungsi_kognitif', 'label' => 'Fungsi kognitif rendah'],
        ['key' => 'risiko_tinggi', 'label' => 'Risiko tinggi'],
        ['key' => 'potensi_komplain', 'label' => 'Potensi komplain tinggi'],
        ['key' => 'riwayat_kronis', 'label' => 'Kasus dengan riwayat kronis'],
        ['key' => 'kasus_katastropik', 'label' => 'Kasus katastropik'],
        ['key' => 'kasus_terminal', 'label' => 'Kasus terminal'],
        ['key' => 'status_fungsional', 'label' => 'Status fungsional rendah, kebutuhan ADL tinggi'],
        ['key' => 'peralatan_medis', 'label' => 'Riwayat penggunaan peralatan medis di masa lalu'],
        ['key' => 'gangguan_mental', 'label' => 'Riwayat gangguan mental'],
        ['key' => 'krisis_keluarga', 'label' => 'Krisis keluarga'],
        ['key' => 'isu_sosial', 'label' => 'Isu sosial (terlantar, tinggal sendiri, narkoba)'],
        ['key' => 'sering_igd', 'label' => 'Sering masuk IGD, readmisi RS'],
        ['key' => 'perkiraan_asuhan', 'label' => 'Perkiraan asuhan dengan biaya tinggi'],
        ['key' => 'sistem_pembiayaan', 'label' => 'Kemungkinan sistem pembiayaan komplek, masalah finansial'],
        ['key' => 'length_of_stay', 'label' => 'Kasus yang melebihi rata-rata length of stay'],
        ['key' => 'rencana_pemulangan', 'label' => 'Kasus yang rencana pemulangannya berisiko/membutuhkan kontinuitas pelayanan'],
        ['key' => 'lain_lain', 'label' => 'Lain-lain'],
    ] as $index => $item)
                <tr class="screening-row">
                    <td class="datetime-col">
                        @if ($index == 0)
                            <div class="datetime-display">
                                @if ($mppData->screening_date)
                                    {{ \Carbon\Carbon::parse($mppData->screening_date)->format('d-m-Y') }}<br>
                                @endif
                                @if ($mppData->screening_time)
                                    {{ \Carbon\Carbon::parse($mppData->screening_time)->format('H:i') }}
                                @endif
                            </div>
                        @endif
                    </td>
                    <td>
                        <div class="criteria-item">
                            <input type="checkbox" class="criteria-checkbox"
                                {{ isset($mppData->{$item['key']}) && $mppData->{$item['key']} ? 'checked' : '' }}
                                disabled>
                            <span class="criteria-label">
                                {{ $item['label'] }}
                                @if ($item['key'] == 'lain_lain' && $mppData->lain_lain && $mppData->lain_lain_text)
                                    : {{ $mppData->lain_lain_text }}
                                @endif
                            </span>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="table">
        <thead>
            <tr>
                <th class="datetime-col">TANGGAL DAN JAM</th>
                <th>CATATAN</th>
            </tr>
        </thead>
        <tbody>
            <tr class="section-header">
                <td colspan="2">II. ASSESSMENT</td>
            </tr>
            @foreach ([
        ['key' => 'assessment_fisik', 'label' => 'Assessment fisik', 'fallback' => 'fisik_fungsional'],
        ['key' => 'assessment_fungsional', 'label' => 'Assessment fungsional'],
        ['key' => 'assessment_kognitif', 'label' => 'Assessment kognitif'],
        ['key' => 'assessment_kemandirian', 'label' => 'Assessment kemandirian'],
        ['key' => 'riwayat_kesehatan', 'label' => 'Riwayat Kesehatan'],
        ['key' => 'perilaku_psiko', 'label' => 'Perilaku psiko-sosio-kultural'],
        ['key' => 'kesehatan_mental', 'label' => 'Kesehatan mental'],
        ['key' => 'dukungan_keluarga', 'label' => 'Tersedianya dukungan keluarga, kemampuan merawat dari pemberi asuhan'],
        ['key' => 'finansial_asuransi', 'label' => 'Finansial/status asuransi'],
        ['key' => 'riwayat_obat', 'label' => 'Riwayat penggunaan obat, alternatif'],
        ['key' => 'trauma_kekerasan', 'label' => 'Riwayat/trauma/kekerasan'],
        ['key' => 'health_literacy', 'label' => 'Pemahaman tentang kesehatan (health literacy)'],
        ['key' => 'aspek_legal', 'label' => 'Aspek legal'],
        ['key' => 'harapan_hasil', 'label' => 'Harapan terhadap hasil asuhan, kemampuan untuk menerima perubahan'],
    ] as $index => $item)
                <tr class="assessment-row">
                    <td class="datetime-col">
                        @if ($index == 0)
                            <div class="datetime-display">
                                @if ($mppData->assessment_date)
                                    {{ \Carbon\Carbon::parse($mppData->assessment_date)->format('d-m-Y') }}<br>
                                @endif
                                @if ($mppData->assessment_time)
                                    {{ \Carbon\Carbon::parse($mppData->assessment_time)->format('H:i') }}
                                @endif
                            </div>
                        @endif
                    </td>
                    <td>
                        <div class="criteria-item">
                            <input type="checkbox" class="criteria-checkbox"
                                {{ isset($item['fallback']) ? (isset($mppData->{$item['key']}) && $mppData->{$item['key']} ? 'checked' : ($mppData->{$item['fallback']} ? 'checked' : '')) : (isset($mppData->{$item['key']}) && $mppData->{$item['key']} ? 'checked' : '') }}
                                disabled>
                            <span class="criteria-label">{{ $item['label'] }}</span>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="table">
        <thead>
            <tr>
                <th class="datetime-col">TANGGAL DAN JAM</th>
                <th>CATATAN</th>
            </tr>
        </thead>
        <tbody>
            <tr class="section-header">
                <td colspan="2">III. IDENTIFIKASI MASALAH</td>
            </tr>
            @foreach ([
        ['key' => 'tingkat_asuhan', 'label' => 'Tingkat asuhan yang tidak sesuai dengan panduan, norma yang digunakan'],
        ['key' => 'over_utilization', 'label' => 'Over utilization pelayanan dengan dasar panduan norma yang digunakan', 'fallback' => 'over_under_utilization'],
        ['key' => 'under_utilization', 'label' => 'Under utilization pelayanan dengan dasar panduan norma yang digunakan'],
        ['key' => 'ketidak_patuhan', 'label' => 'Ketidak patuhan pasien'],
        ['key' => 'edukasi_kurang', 'label' => 'Edukasi kurang memadai atau pemahamannya yang belum memadai tentang proses penyakit, kondisi terkini dan daftar obat'],
        ['key' => 'kurang_dukungan', 'label' => 'Kurangnya dukungan keluarga, tidak ada keluarga'],
        ['key' => 'penurunan_determinasi', 'label' => 'Penurunan determinasi pasien (ketika tingkat keparahan/komplikasi meningkat)'],
        ['key' => 'kendala_keuangan', 'label' => 'Kendala keuangan ketika keparahan/komplikasi meningkat'],
        ['key' => 'pemulangan_rujukan', 'label' => 'Pemulangan/rujukan yang belum memenuhi kriteria atau sebaliknya, pemulangan/rujukan yang ditunda'],
    ] as $index => $item)
                <tr class="identification-row">
                    <td class="datetime-col">
                        @if ($index == 0)
                            <div class="datetime-display">
                                @if ($mppData->identification_date)
                                    {{ \Carbon\Carbon::parse($mppData->identification_date)->format('d-m-Y') }}<br>
                                @endif
                                @if ($mppData->identification_time)
                                    {{ \Carbon\Carbon::parse($mppData->identification_time)->format('H:i') }}
                                @endif
                            </div>
                        @endif
                    </td>
                    <td>
                        <div class="criteria-item">
                            <input type="checkbox" class="criteria-checkbox"
                                {{ isset($item['fallback']) ? (isset($mppData->{$item['key']}) && $mppData->{$item['key']} ? 'checked' : ($mppData->{$item['fallback']} ? 'checked' : '')) : (isset($mppData->{$item['key']}) && $mppData->{$item['key']} ? 'checked' : '') }}
                                disabled>
                            <span class="criteria-label">{{ $item['label'] }}</span>
                        </div>
                    </td>
                </tr>
            @endforeach
            <tr class="section-header">
                <td colspan="2">IV. PERENCANAAN MANAJEMEN PELAYANAN PASIEN</td>
            </tr>
            @foreach ([['key' => 'validasi_rencana', 'label' => 'Validasi rencana asuhan, sesuaikan/konsisten dengan panduan lakukan kolaborasi komunikasi dengan PPA dalam akses pelayanan'], ['key' => 'rencana_informasi', 'label' => 'Tentukan rencana pemberian informasi kepada pasien keluarga untuk pengambilan keputusan'], ['key' => 'rencana_melibatkan', 'label' => 'Tentukan rencana untuk melibatkan pasien dan keluarga dalam menentukan asuhan termasuk kemungkinan perubahan rencana'], ['key' => 'fasilitas_penyelesaian', 'label' => 'Fasilitas penyelesaian masalah dan konflik'], ['key' => 'bantuan_alternatif', 'label' => 'Bantuan dalam alternatif solusi permasalahan keuangan']] as $index => $item)
                <tr class="planning-row">
                    <td class="datetime-col">
                        @if ($index == 0)
                            <div class="datetime-display">
                                @if ($mppData->planning_date)
                                    {{ \Carbon\Carbon::parse($mppData->planning_date)->format('d-m-Y') }}<br>
                                @endif
                                @if ($mppData->planning_time)
                                    {{ \Carbon\Carbon::parse($mppData->planning_time)->format('H:i') }}
                                @endif
                            </div>
                        @endif
                    </td>
                    <td>
                        <div class="criteria-item">
                            <input type="checkbox" class="criteria-checkbox"
                                {{ isset($mppData->{$item['key']}) && $mppData->{$item['key']} ? 'checked' : '' }}
                                disabled>
                            <span class="criteria-label">{{ $item['label'] }}</span>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Signature -->
    <div class="signature">
        <div>
            <p>Langsa, {{ date('d/m/Y') }}</p>
            <p style="font-weight: bold;">Manajer Pelayanan Pasien</p>
            <div class="underline"></div>
            <p style="font-weight: bold;">{{ $userCreate ? $userCreate->name : '...............................' }}</p>
            <p>NIP. ...............................</p>
        </div>
    </div>
</body>

</html>
