<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Asesmen Pra Anestesi Medis - {{ $dataMedis->pasien->nama ?? '-' }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 10mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            color: #333;
        }

        h2,
        h3,
        p {
            margin: 0;
            padding: 0;
        }

        /* HEADER STYLE (Mengambil dari HD Asesmen) */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #f0f0f0;
            margin-bottom: 15px;
        }

        .header-table td {
            vertical-align: middle;
            padding: 5px;
        }

        .brand-logo {
            width: 60px;
            height: auto;
            margin-right: 2px;
        }

        .brand-name {
            font-weight: 700;
            font-size: 14px;
        }

        .brand-info {
            font-size: 7px;
        }

        .title-main {
            font-size: 16px;
            font-weight: bold;
        }

        .hd-box {
            background-color: #bbbbbb;
            padding: 15px 0px;
            text-align: center;
        }

        .hd-text {
            font-size: 18px;
            font-weight: bold;
            color: #ffffff;
        }

        /* PATIENT TABLE STYLE (Mengambil dari HD Asesmen) */
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

        /* SECTION AND FORM ROW STYLES */
        .section-title {
            font-size: 11pt;
            font-weight: bold;
            background-color: #097dd6;
            /* WARNA BIRU HD */
            color: white;
            padding: 5px;
            margin: 15px 0 5px 0;
        }

        .form-row {
            display: table;
            width: 100%;
            border-collapse: collapse;
        }

        .form-label,
        .form-value {
            display: table-cell;
            padding: 5px 0;
            border-bottom: 1px solid #eee;
        }

        .form-label {
            width: 25%;
            font-weight: bold;
        }

        .form-value {
            width: 75%;
            padding-left: 10px;
            text-align: justify;
        }

        .textarea-value {
            display: block;
            min-height: 50px;
            border: 1px solid #ddd;
            padding: 5px;
            white-space: pre-wrap;
            /* Mempertahankan format baris */
            margin-top: 5px;
            background-color: #f9f9f9;
        }

        /* TTD STYLES */
        .ttd-container {
            margin-top: 50px;
            width: 100%;
            page-break-inside: avoid;
        }

        .ttd-cell {
            width: 50%;
            text-align: center;
            vertical-align: top;
        }
    </style>
</head>

<body>
    @php
        $pasien = $dataMedis->pasien ?? (object) [];
        $pra = $asesmen->praOperatifMedis ?? (object) []; // Data Pra Operatif Medis
        $creator = $asesmen->userCreate;
        $namaDpjp = '_________________________';

        if ($creator && $creator->karyawan) {
            $gelarDepan = $creator->karyawan->gelar_depan ?? '';
            // Ambil nama dari nama_lengkap atau nama (sesuai struktur DB)
            $nama = $creator->karyawan->nama_lengkap ?? ($creator->karyawan->nama ?? '');
            $gelarBelakang = $creator->karyawan->gelar_belakang ?? '';
            // Gabungkan dan bersihkan spasi
            $namaDpjp = trim("{$gelarDepan} {$nama} {$gelarBelakang}");
            if ($namaDpjp === '') {
                $namaDpjp = '_________________________';
            }
        }
    @endphp

    {{-- ======================================================= --}}
    {{-- HEADER DENGAN LOGO DAN ALAMAT --}}
    {{-- ======================================================= --}}
    <table class="header-table">
        <tr>
            <td class="td-left" style="width: 40%;">
                <table class="brand-table">
                    <tr>
                        <td class="va-middle" style="width: 60px;"><img
                                src="{{ public_path('assets/img/Logo-RSUD-Langsa-1.png') }}" alt="Logo"
                                class="brand-logo"></td>
                        <td class="va-middle">
                            <p class="brand-name">RSUD Langsa</p>
                            <p class="brand-info">Jl. Jend. A. Yani No.1 Kota Langsa</p>
                            <p class="brand-info">Telp. 0641-22051, email: rsulangsa@gmail.com</p>
                            <p class="brand-info">www.rsud.langsakota.go.id</p>
                        </td>
                    </tr>
                </table>
            </td>
            <td class="td-center" style="width: 40%; text-align: center;">
                <span class="title-main">ASESMEN PRA ANESTESI MEDIS</span>
            </td>
            <td class="td-right" style="width: 20%;">
                <div class="hd-box"><span class="hd-text">OPERASI</span></div>
            </td>
        </tr>
    </table>

    {{-- ======================================================= --}}
    {{-- INFORMASI PASIEN --}}
    {{-- ======================================================= --}}
    <table class="patient-table">
        <tr>
            <th>No. RM</th>
            <td>{{ $dataMedis->pasien->kd_pasien ?? '-' }}</td>
            <th>Jenis Kelamin</th>
            <td>{{ $dataMedis->pasien->jenis_kelamin == 1 ? 'Laki-Laki' : 'Wanita' }}</td>
        </tr>
        <tr>
            <th>Nama Pasien</th>
            <td>{{ $pasien->nama ?? '-' }}</td>
            <th>Umur</th>
            <td>{{ $pasien->umur ?? '-' }} Tahun</td>
        </tr>
    </table>

    {{-- SECTION 1: DATA MASUK --}}
    <div class="section-title">1. Data Masuk</div>
    <div class="form-row">
        <div class="form-label">Tanggal dan Jam Masuk Operasi</div>
        <div class="form-value">
            : {{ date('d-m-Y', strtotime($asesmen->praOperatifMedis->tgl_op)) ?? '-' }} Pukul
            {{ date('H:i', strtotime($asesmen->praOperatifMedis->tgl_op)) ?? '-' }} WIB
        </div>
    </div>

    {{-- SECTION 2: DIAGNOSA PRA OPERATIF --}}
    <div class="section-title">2. Diagnosa Pra Operatif</div>
    <div class="form-row">
        <div class="form-label">Diagnosis Pra Operatif</div>
        <div class="form-value">: {{ $pra->diagnosa_pra_operasi ?? '-' }}</div>
    </div>

    <div class="form-row">
        <div class="form-label">Timing Tindakan</div>
        <div class="form-value">: {{ $pra->timing_tindakan ?? '-' }}</div>
    </div>

    <div class="form-row">
        <div class="form-label">Indikasi Tindakan</div>
        <div class="form-value">: {{ $pra->indikasi_tindakan ?? '-' }}</div>
    </div>


    {{-- SECTION 3: RENCANA TINDAKAN DAN PROSEDUR --}}
    <div class="section-title">3. Rencana Tindakan dan Prosedur</div>

    <div class="form-row">
        <div class="form-label">Rencana Tindakan</div>
        <div class="form-value">: {{ $pra->rencana_tindakan ?? '-' }}</div>
    </div>

    <div class="form-row">
        <div class="form-label">Prosedur Tindakan</div>
        <div class="form-value">: {{ $pra->prosedur_tindakan ?? '-' }}</div>
    </div>


    {{-- SECTION 4: TIMING DAN ALTERNATIF TINDAKAN --}}
    <div class="section-title">4. Timing dan Alternatif Tindakan</div>

    <div class="form-row">
        <div class="form-label">Waktu Tindakan</div>
        <div class="form-value">
            : {{ date('d-m-Y', strtotime($pra->waktu_tindakan)) ?? '-' }}
            Pukul {{ date('H:i', strtotime($pra->jam_tindakan)) ?? '-' }} WIB
        </div>
    </div>

    <div class="form-row">
        <div class="form-label">Alternatif Lain</div>
        <div class="form-value">: {{ $pra->alternatif_lain ?? '-' }}</div>
    </div>


    {{-- SECTION 5: RISIKO DAN PEMANTAUAN --}}
    <div class="section-title">5. Risiko dan Pemantauan</div>

    <div class="form-row">
        <div class="form-label">Risiko / Komplikasi</div>
        <div class="form-value">: {{ $pra->resiko ?? '-' }}</div>
    </div>
    <div class="ttd-container">
        <table class="no-border" style="width: 100%;">
            <tr class="no-border">
                <td class="ttd-cell" style="width: 50%;"></td>
                <td class="ttd-cell" style="width: 50%;">Dokter Penanggung Jawab Pasien,</td>
            </tr>
            <tr class="no-border">
                <td class="ttd-cell" style="padding-top: 50px;"></td>
                <td class="ttd-cell" style="padding-top: 50px;">
                    ( {{ $namaDpjp }} )
                </td>
            </tr>
        </table>
    </div>

</body>

</html>
