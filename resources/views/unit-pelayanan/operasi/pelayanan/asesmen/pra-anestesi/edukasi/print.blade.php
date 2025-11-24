<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edukasi Anestesi - {{ $dataMedis->pasien->nama ?? '-' }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 10mm 15mm 10mm 15mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11pt;
            color: #000;
        }

        h2,
        h3,
        p {
            margin: 0;
            padding: 0;
        }

        /* HEADER STYLE */
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

        /* PATIENT TABLE STYLE */
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
            font-size: 12pt;
            font-weight: bold;
            background-color: #097dd6;
            color: white;
            padding: 5px;
            margin: 15px 0 5px 0;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10pt;
            margin-top: 5px;
        }

        .data-table th,
        .data-table td {
            border: 1px solid #ddd;
            padding: 4px 8px;
            vertical-align: top;
        }

        .data-table th {
            background-color: #f0f0f0;
            text-align: left;
            font-weight: bold;
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
            width: 40%;
            font-weight: bold;
        }

        .form-value {
            width: 60%;
            padding-left: 10px;
        }

        .catatan {
            border: 1px solid #000;
            padding: 10px;
            margin-top: 5px;
        }

        .ttd-container {
            margin-top: 50px;
            width: 100%;
            page-break-inside: avoid;
        }

        .ttd-cell {
            width: 50%;
            text-align: center;
            vertical-align: top;
            border: none;
        }

        /* List Styling */
        ul {
            list-style: disc;
            padding-left: 20px;
            margin: 5px 0;
        }

        ul li {
            margin-bottom: 2px;
        }
    </style>
</head>

<body>

    @php
        $edukasi = $edukasiAnestesi;

        // Konversi string edukasi_anestesi ke array
        $edukasiAnestesiTopics = json_decode($edukasi->edukasi_anestesi ?? '[]', true);

        // Helper untuk Yes/No/Skala (diasumsikan didefinisikan secara global atau di awal file)
        function getText($value, $type)
        {
            if ($type === 'YN') {
                $map = ['1' => 'Ya', '0' => 'Tidak'];
                return $map[$value] ?? '-';
            }
            if ($type === 'PEMAHAMAN') {
                $map = ['1' => 'Baik', '2' => 'Cukup', '3' => 'Kurang'];
                return $map[$value] ?? '-';
            }
            if ($type === 'JK') {
                $map = ['1' => 'Laki-Laki', '0' => 'Perempuan'];
                return $map[$value] ?? '-';
            }
            return $value ?? '-';
        }

        // =======================================================
        // DEFINISI ARRAY KONTEN EDUKASI (FIXED UNDEFINED VARIABLE)
        // =======================================================
        $topikEdukasi = [
            'Tujuan Pemberian Anestesi' => 'Mengapa anestesi diperlukan dalam prosedur yang akan dijalani.',
            'Prosedur yang Akan Dilakukan' => 'Langkah-langkah selama anestesi diberikan.',
            'Manfaat dan Risiko Anestesi' => 'Efek positif anestesi serta risiko yang mungkin terjadi.',

            'Efek Samping yang Mungkin Terjadi' => [
                'Mual/muntah',
                'Pusing',
                'Reaksi alergi terhadap obat anestesi',
                'Gangguan pernapasan',
                'Sakit kepala pasca-anestesi',
            ],

            'Instruksi Pra-Anestesi' => [
                'Pasien harus puasa sebelum anestesi untuk mencegah aspirasi.',
                'Penghentian obat tertentu sebelum operasi.',
                'Memberitahu dokter jika memiliki riwayat alergi obat.',
            ],

            'Instruksi Pasca-Anestesi' => [
                'Pasien mungkin merasa lelah setelah anestesi.',
                'Larangan mengemudi atau mengoperasikan mesin selama 24 jam setelah anestesi.',
                'Pengelolaan nyeri pasca-tindakan jika diperlukan.',
            ],
        ];

        $dokterEdukasiRecord = $dokterAnastesi->firstWhere('kd_dokter', $edukasi->dokter_edukasi);
        $namaDokterEdukasi = '_________________________';

        if ($dokterEdukasiRecord && $dokterEdukasiRecord->dokter) {
            $namaEdukasi = $dokterEdukasiRecord->dokter->nama_lengkap ?? $dokterEdukasiRecord->dokter->nama;
            $gelarDepan = $dokterEdukasiRecord->dokter->gelar_depan ?? '';
            $gelarBelakang = $dokterEdukasiRecord->dokter->gelar_belakang ?? '';
            $namaDokterEdukasi = trim("{$gelarDepan} {$namaEdukasi} {$gelarBelakang}");
        }

        // Ambil Jenis Anastesi Yang Dipilih
        $jenisAnastesiMap = $jenisAnastesi->pluck('jenis_anastesi', 'kd_jenis_anastesi')->toArray();
        $jenisAnastesiDipilih = $jenisAnastesiMap[$edukasi->jenis_anestesi] ?? ($edukasi->jenis_anestesi ?? '-');

        // Ambil data pasien
        $pasien = $dataMedis->pasien;
    @endphp

    {{-- ======================================================= --}}
    {{-- HEADER --}}
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
                <span class="title-main">EDUKASI PRA ANESTESI</span>
            </td>
            <td class="td-right" style="width: 20%;">
                <div class="hd-box"><span class="hd-text">OPERASI</span></div>
            </td>
        </tr>
    </table>

    {{-- INFORMASI PASIEN --}}
    @php

    @endphp

    {{-- INFORMASI PASIEN --}}
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

    {{-- ======================================================= --}}
    {{-- SECTION 1: DATA MASUK & JENIS ANESTESI --}}
    {{-- ======================================================= --}}
    <div class="section-title">1. Data Masuk & Jenis Anestesi</div>
    <div class="form-row">
        <div class="form-label">Tanggal dan Jam Masuk</div>
        <div class="form-value">
            : {{ date('d-m-Y', strtotime($edukasi->tgl_op)) ?? '-' }} Pukul
            {{ date('H:i', strtotime($edukasi->jam_op)) ?? '-' }} WIB
        </div>
    </div>


    {{-- ======================================================= --}}
    {{-- Section 2 : PENJELASAN SINGKAT JENIS ANESTESI (DITAMBAHKAN) --}}
    {{-- ======================================================= --}}
    <div class="section-title">2. Jenis Anastesi</div>
    <div class="form-row">
        <div class="form-label">Jenis Anestesi Yang Digunakan</div>
        <div class="form-value">
            : {{ $jenisAnastesiDipilih ?? '-' }}
        </div>
    </div>
    <p class="fw-bold" style="font-size: 13pt; text-align: center; font-weight: bold;">Penjelasan Singkat Jenis Anestesi
    </p>
    <table class="data-table">
        <thead>
            <tr>
                <th style="text-align: center; width: 35%;">Jenis Anestesi</th>
                <th style="text-align: center; width: 65%;">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Anestesi Umum (GA – General Anesthesia)</td>
                <td>
                    Pasien tidak sadar sepenuhnya selama operasi dan memerlukan alat bantu napas.
                </td>
            </tr>
            <tr>
                <td>Anestesi Regional (Spinal, Epidural)</td>
                <td>
                    Membius sebagian tubuh, pasien tetap sadar tetapi tidak merasakan nyeri di area tertentu.
                </td>
            </tr>
            <tr>
                <td>Blok Perifer</td>
                <td>
                    Anestesi regional yang diberikan di sekitar saraf tertentu untuk membius bagian tubuh tertentu
                    tanpa mempengaruhi kesadaran pasien.
                </td>
            </tr>
            <tr>
                <td>Sedasi Sedang dan Dalam</td>
                <td>
                    Pasien dalam keadaan rileks atau tertidur ringan tanpa kehilangan kesadaran sepenuhnya.
                </td>
            </tr>
            <tr>
                <td>Anestesia Topikal</td>
                <td>
                    Membius area kecil tanpa mempengaruhi kesadaran pasien, misalnya untuk operasi kecil.
                </td>
            </tr>
        </tbody>
    </table>

    {{-- ======================================================= --}}
    {{-- SECTION 3: EDUKASI PASIEN --}}
    {{-- ======================================================= --}}
    <div class="section-title">3. Edukasi Pasien</div>
    <p class="fw-bold" style="font-size: 13pt; text-align: center; font-weight: bold;">Penjelasan Singkat Edukasi Pasien
    </p>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;">No.</th>
                <th style="width: 35%;">Topik Edukasi</th>
                <th style="width: 40%;">Penjelasan yang Harus Disampaikan ke Pasien</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($topikEdukasi as $topik => $materi)
                <tr>
                    <td style="text-align: center;">{{ $no++ }}</td>
                    <td style="font-weight: bold;">{{ $topik }}</td>
                    <td>
                        @if (is_array($materi))
                            <ul>
                                @foreach ($materi as $detail)
                                    <li>{{ $detail }}</li>
                                @endforeach
                            </ul>
                        @else
                            {{ $materi }}
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="form-row" style="margin-top: 10px;">
        <div class="form-label">Edukasi tentang prosedur operasi</div>
        <div class="form-value">
            :
            @php
                $statusProsedur = [
                    '1' => 'Sudah',
                    '0' => 'Belum',
                ];
            @endphp
            {{ $statusProsedur[$edukasi->edukasi_prosedur] ?? '-' }}
        </div>
    </div>
    {{-- ======================================================= --}}
    {{-- SECTION 4: PERSETUJUAN PASIEN DAN KELUARGA --}}
    {{-- ======================================================= --}}
    <div class="section-title">4. Persetujuan Pasien dan Keluarga</div>

    <div class="form-row">
        <div class="form-label">Pemahaman Pasien</div>
        <div class="form-value">
            : {{ getText($edukasi->pemahaman_pasien, 'PEMAHAMAN') }}
        </div>
    </div>

    <div class="form-row">
        <div class="form-label">Persetujuan Tindakan (Informed Consent)</div>
        <div class="form-value">
            : {{ getText($edukasi->informed_consent, 'YN') }}
        </div>
    </div>

    <p style="margin: 10px 0;">Data Persetujuan Prosedur Anestesia dan sedasi yang akan dilakukan. Diisi oleh
        pasien/istri/suami anak/ayah/ibu.</p>

    <div class="form-row">
        <div class="form-label">Nama Yang Bertanda Tangan (Keluarga/Wali)</div>
        <div class="form-value">
            : {{ $edukasi->nama_keluarga ?? '-' }}
        </div>
    </div>

    <div class="form-row">
        <div class="form-label">Usia (tahun)</div>
        <div class="form-value">
            : {{ $edukasi->usia_keluarga ?? '-' }} Tahun
        </div>
    </div>

    <div class="form-row">
        <div class="form-label">Jenis Kelamin</div>
        <div class="form-value">
            : {{ getText($edukasi->jenis_kelamin, 'JK') }}
        </div>
    </div>

    <div class="form-row">
        <div class="form-label">No Telepon</div>
        <div class="form-value">
            : {{ $edukasi->no_telepon ?? '-' }}
        </div>
    </div>

    <div class="form-row">
        <div class="form-label">Dokter Yang Memberikan Edukasi</div>
        <div class="form-value">
            : {{ $namaDokterEdukasi }}
        </div>
    </div>

    <div class="form-row">
        <div class="form-label">Tanggal dan Jam Dilakukan</div>
        <div class="form-value">
            : {{ date('d M Y', strtotime($edukasi->tgl_dilakukan)) ?? '-' }} Pukul
            {{ date('H:i', strtotime($edukasi->jam_dilakukan)) ?? '-' }} WIB
        </div>
    </div>


    {{-- ======================================================= --}}
    {{-- SECTION 5: CATATAN TAMBAHAN --}}
    {{-- ======================================================= --}}
    <div class="section-title">5. Catatan Tambahan</div>

    <div class="form-row">
        <div class="form-label">Pertanyaan atau Kekhawatiran Pasien</div>
        <div class="form-value">
            : {{ $edukasi->pertanyaan_pasien ?? '-' }}
        </div>
    </div>

    <div class="form-row">
        <div class="form-label">Rekomendasi Tambahan Dari Dokter</div>
        <div class="form-value">
            : {{ $edukasi->rekomendasi_dokter ?? '-' }}
        </div>
    </div>

    <div class="form-row">
        <div class="form-label">Lain-Lain</div>
        <div class="form-value">
            : {{ $edukasi->lainnya ?? '-' }}
        </div>
    </div>
    <div class="ttd-container">
        <table class="no-border" style="width: 100%;">
            <tr class="no-border">
                <td class="ttd-cell" style="width: 50%;">Dokter yang Menjelaskan,</td>
                <td class="ttd-cell" style="width: 50%; padding-right: 20%;">Pihak yang diJelaskan,</td>
            </tr>
            <tr class="no-border">
                <td class="ttd-cell" style="padding-top: 50px;">
                    ( {{ $namaDokterEdukasi }} )
                </td>
                <td class="ttd-cell" style="padding-top: 50px;">
                    ( {{ $edukasi->nama_keluarga ?? '_____________________' }} )
                </td>
            </tr>
        </table>
    </div>

</body>

</html>
