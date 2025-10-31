<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informed Consent - {{ $dataMedis->pasien->nama ?? 'Pasien' }}</title>
    <style>
        @page {
            margin: 40px 40px;
            size: 21cm 29.7cm;
            /* A4 portrait */
        }

        body {
            font-family: sans-serif;
            font-size: 11pt;
            line-height: 1.2;
            margin: 0;
            padding: 0;
        }

        /* ===== Header ===== */
        .header-container {
            width: 100%;
            margin-bottom: 12px;
            padding-bottom: 10px;
        }

        .header-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 20px;
            border-bottom: 2px solid black;
        }

        .header-table td {
            vertical-align: top;
            padding: 0;
        }

        .logo-cell {
            width: 75px;
            text-align: center;
        }

        .logo-cell img {
            width: 60px;
            height: auto;
        }

        .header-rs-name {
            font-size: 10pt;
            margin: 2px;
            font-weight: bold;
            line-height: 1;
        }

        .header-address {
            font-size: 8pt;
            margin: 2px;
            line-height: 1;
        }

        .header-info-box {
            border: 2px solid black;
            border-radius: 10px;
            padding: 8px;
            width: 100%;
            font-size: 9pt;
        }

        /* ===== Title ===== */
        .title {
            font-size: 12pt;
            font-weight: bold;
            text-align: center;
        }

        .section {
            font-size: 12pt;
            font-weight: bold;
            margin-top: 40px;
        }

        .title-table {
            font-size: 12pt;
            font-weight: bold;
            font-style: italic;
            margin-top: 20px;
        }

        .section-signature-space {
            height: 25px;
        }

        .section-signature-label {
            margin-top: 10px;
            padding-top: 5px;
        }

        /* ===== Signature ===== */
        .signature-section {
            margin-top: 12px;
        }

        .signature-sub-table {
            width: 100%;
            border-collapse: collapse;
        }

        .signature-sub-cell {
            width: 25%;
            text-align: center;
            vertical-align: top;
        }

        .signature-name-space {
            margin-bottom: 60px;
        }

        .signature-line {
            width: 120px;
            margin: 0 auto;
            height: 1px;
        }

        .signature-caption {
            margin-top: 5px;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<body>
    <!-- ===== Header ===== -->
    <div class="header-container">
        <table class="header-table">
            <tr>
                <td class="logo-cell" align="center" style="vertical-align: middle;">
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/Logo-RSUD-Langsa-1.png'))) }}"
                        alt="Logo RSUD Langsa">
                </td>
                <td style="vertical-align: middle;">
                    <p class="header-rs-name">RSUD LANGSA</p>
                    <p class="header-address">Jl. Jend. A. Yani. No.1 Kota Langsa</p>
                </td>
                <td>
                    <!-- ===== Title ===== -->
                    <div class="title">FORMULIR RAWAT JALAN PROGRAM TERAPI/PENDAMPINGAN/SEBELUM DAN SESUDAH SESI
                        REHABILITASI</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="section">Identitas Pasien</div>
    <table>
        <tr>
            <td>Nomor Rekam Medis</td>
            <td>: {{ $dataMedis->kd_pasien }}</td>
        </tr>
        <tr>
            <td>Nama</td>
            <td>: {{ $dataMedis->pasien->nama ?? '-' }}
            </td>
        </tr>
        <tr>
            <td>Tanggal Lahir</td>
            <td>
                :
                {{ $dataMedis->pasien->tgl_lahir ? date('d/m/Y', strtotime($dataMedis->pasien->tgl_lahir)) : '-' }}
            </td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>: {{ $dataMedis->pasien->alamat ?? '-' }}
            </td>
        </tr>
    </table>

    <!-- ===== Patient Info ===== -->
    <table style="width:100%; border-collapse:collapse; margin-top:40px;">
        <tr>
            <td class="title-table" style="width:30%; vertical-align:top; font-weight:bold; padding:6px 8px;">Subjective
            </td>
            <td class="width:5px;">:</td>
            <td style="width:70%; padding:6px 8px; vertical-align:top;">
                {!! nl2br(e($tindakan->subjective ?? '-')) !!}
            </td>
        </tr>
        <tr>
            <td class="title-table" style="width:30%; vertical-align:top; font-weight:bold; padding:6px 8px;">Objective
            </td>
            <td class="width:5px;" style="vertical-align:top;">:</td>
            <td style="width:70%; padding:6px 8px; vertical-align:top;">
                {!! nl2br(e($tindakan->objective ?? '-')) !!}
            </td>
        </tr>
        <tr>
            <td class="title-table" style="width:30%; vertical-align:top; font-weight:bold; padding:6px 8px;">Asesmen
            </td>
            <td class="width:5px;" style="vertical-align:top;">:</td>
            <td style="width:70%; padding:6px 8px; vertical-align:top;">
                {!! nl2br(e($tindakan->assessment ?? '-')) !!}
            </td>
        </tr>
        <tr>
            <td class="title-table" style="width:30%; vertical-align:top; font-weight:bold; padding:6px 8px;">Planning
            </td>
            <td class="width:5px;" style="vertical-align:top;">:</td>
            <td style="width:70%; padding:6px 8px; vertical-align:top;">
                <ul style="margin:0; padding-left:18px;">
                    <li><strong>a. Goal Of Treatment</strong><br>{!! nl2br(e($tindakan->planning_goal ?? '-')) !!}</li>
                    <li><strong>b. Tindakan/Program Rehabilitasi Medik</strong><br>{!! nl2br(e($tindakan->planning_tindakan ?? '-')) !!}</li>
                    <li><strong>c. Edukasi</strong><br>{!! nl2br(e($tindakan->planning_edukasi ?? '-')) !!}</li>
                    <li><strong>d. Frekuensi Kunjungan</strong><br>{!! nl2br(e($tindakan->planning_frekuensi ?? '-')) !!}</li>
                </ul>
            </td>
        </tr>
        <tr>
            <td class="title-table" style="width:30%; vertical-align:top; padding:6px 8px;">Rencana
                Tindak Lanjut(Evaluasi/Rujuk/Selesai)
            </td>
            <td class="width:5px;" style="vertical-align:top;">:</td>
            <td style="width:70%; padding:6px 8px; vertical-align:top;">
                {!! nl2br(e($tindakan->rencana_tindak_lanjut ?? '-')) !!}
            </td>
        </tr>
    </table>

    <table style="width:100%; margin-top:40px;">
        <tr>
            <td class="signature-sub-cell" style="width:50%; text-align:center; vertical-align:top;" />

            <td style="width:50%; text-align:center; vertical-align:top;">
                <p>
                    Langsa,
                    {{ $tindakan->tgl_tindakan ? date('d-M-Y', strtotime($tindakan->tgl_tindakan)) : '................' }}
                    {{ $tindakan->jam_tindakan ? date('H:i', strtotime($tindakan->jam_tindakan)) : '........' }}
                </p>
            </td>
        </tr>
        <tr>
            <!-- Kiri -->
            <td class="signature-sub-cell" style="width:50%; text-align:center; vertical-align:top;" />

            <!-- Kanan: Dokter -->
            <td class="signature-sub-cell" style="width:50%; text-align:center; vertical-align:top; margin-top:20px;">
                <div class="signature-name-space">Dokter Penanggung Jawab Pelayanan,</div>
                <div class="signature-line" style="height:60px;"></div>
                <div class="signature-caption">
                    {{ $tindakan->karyawan?->gelar_depan . ' ' . str()->title($tindakan->karyawan?->nama) . ' ' . $tindakan->karyawan?->gelar_belakang ?? '(...........................)' }}
                </div>
            </td>
        </tr>
    </table>
</body>

</html>
