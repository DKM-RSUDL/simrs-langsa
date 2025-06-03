<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Asesmen Paru</title>
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
            font-size: 10px;
        }

        .clear {
            clear: both;
        }

        .content-section {
            margin-top: 20px;
        }

        .section-title {
            background: #f5f5f5;
            padding: 8px;
            font-weight: bold;
            border-left: 3px solid #333;
            margin-bottom: 10px;
            font-size: 12px;
        }

        .detail-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .detail-table th,
        .detail-table td {
            padding: 6px;
            border: 1px solid #333;
            font-size: 10px;
            vertical-align: top;
        }

        .detail-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .col-header {
            font-weight: bold;
            background-color: #f8f9fa;
            width: 25%;
        }

        .checkbox-group {
            display: inline-block;
            margin-right: 15px;
        }

        /* Menggunakan HTML checkbox standar seperti orientasi pasien */
        .checkbox {
            margin-right: 5px;
            vertical-align: middle;
        }

        /* Hapus custom checkbox style dan gunakan HTML input checkbox */
        input[type="checkbox"] {
            margin-right: 5px;
            vertical-align: middle;
            transform: scale(1.2);
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

        .two-column {
            width: 48%;
            float: left;
            margin-right: 2%;
        }

        .two-column:last-child {
            margin-right: 0;
        }

        .text-center {
            text-align: center;
        }

        .small-text {
            font-size: 9px;
        }

        /* Print-specific styles */
        @media print {
            .page-break {
                page-break-before: always;
            }

            * {
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            /* Pastikan checkbox HTML standar muncul saat print */
            input[type="checkbox"] {
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
                print-color-adjust: exact !important;
                transform: scale(1.2);
                margin-right: 5px;
            }

            .section-title {
                background-color: #f5f5f5 !important;
            }

            .col-header {
                background-color: #f8f9fa !important;
            }

            .detail-table th {
                background-color: #f8f9fa !important;
            }

            table,
            th,
            td {
                border: 1px solid #000 !important;
            }
        }
    </style>
</head>

<body>
    <header>
        <div class="left-column">
            <div style="width: 80px; height: 80px; border: 0px solid #333; margin: 0 auto 5px;">
                @if(file_exists(public_path('assets/img/Logo-RSUD-Langsa-1.png')))
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/Logo-RSUD-Langsa-1.png'))) }}"
                        class="header-logo" alt="Logo">
                @else
                    <div style="text-align: center; line-height: 80px; font-size: 8px;">LOGO</div>
                @endif
            </div>
            <p style="font-size: 10px; margin: 0;">RSUD Langsa</p>
            <p style="font-size: 9px; margin: 0;">Jl. Jend. A. Yani No.1 Kota Langsa</p>
        </div>
        <div class="center-column">
            <h1 style="font-size: 16px; margin: 0;">Pengkajian Awal Medis</h1>
            <h2 style="font-size: 14px; margin: 5px 0;">Penyakit Paru</h2>
            <p style="font-size: 10px; margin: 0;">Diisi dalam 24 jam sejak pasien masuk</p>
            <p style="font-size: 9px; margin: 5px 0;">No : B.8 /IRM/Rev 2/ 2018</p>
        </div>
        <div class="right-column">
            <table class="info-table">
                <tr>
                    <td><strong>No RM</strong></td>
                    <td>{{ optional($pasien)->kd_pasien ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Nama</strong></td>
                    <td>{{ optional($pasien)->nama ? ucwords(strtolower(optional($pasien)->nama)) : '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Jenis Kelamin</strong></td>
                    <td>
                        @php
                            $gender = '-';
                            if (optional($pasien)->jenis_kelamin == 1) {
                                $gender = 'Laki-Laki';
                            } elseif (optional($pasien)->jenis_kelamin == 0) {
                                $gender = 'Perempuan';
                            }
                        @endphp
                        {{ $gender }}
                    </td>
                </tr>
                <tr>
                    <td><strong>Tanggal Lahir</strong></td>
                    <td>{{ optional($pasien)->tgl_lahir ? date('d/m/Y', strtotime(optional($pasien)->tgl_lahir)) : '-' }}
                    </td>
                </tr>
            </table>
        </div>
        <div class="clear"></div>
    </header>

    <!-- 1. Data masuk -->
    <div class="content-section">
        <div class="section-title">1. DATA MASUK</div>
        <table class="detail-table">
            <tr>
                <td class="col-header">Petugas:</td>
                <td>{{ $asesmen->user->name ?? '-' }}</td>
                <td class="col-header">Tanggal Dan Jam Masuk:</td>
                <td>{{ $asesmen->rmeAsesmenParu->tanggal ? date('d M Y', strtotime($asesmen->rmeAsesmenParu->tanggal)) : '-' }}
                    {{ $asesmen->rmeAsesmenParu->jam_masuk ? date('H:i', strtotime($asesmen->rmeAsesmenParu->jam_masuk)) : '-' }}
                </td>
            </tr>
            <tr>
                <td class="col-header">Ruang:</td>
                <td colspan="3">{{ $dataMedis->unit->nama_unit ?? '-'}}</td>
            </tr>
        </table>
    </div>

    <!-- 2. Anamnesis -->
    <div class="content-section">
        <div class="section-title">2. ANAMNESA (auto/ allo)</div>
        <table class="detail-table">
            <tr>
                <td class="col-header">Keluhan utama/ Alasan masuk RS mulai, lama, pencetus:</td>
                <td colspan="3">{{ optional($asesmen->rmeAsesmenParu)->anamnesa ?? '-' }}</td>
            </tr>
            <tr>
                <td class="col-header">Keluhan tambahan:</td>
                <td colspan="3">{{ optional($asesmen->rmeAsesmenParu)->riwayat_penyakit ?? '-' }}</td>
            </tr>
            <tr>
                <td class="col-header">ALERGI :</td>
                <td colspan="3">
                    @if(optional($asesmen->rmeAsesmenParu)->alergi)
                        @php
                            $allergies = json_decode($asesmen->rmeAsesmenParu->alergi, true);
                        @endphp
                        @if(is_array($allergies) && !empty($allergies))
                            {{ implode(', ', $allergies) }}
                        @else
                            {{ $asesmen->rmeAsesmenParu->alergi }}
                        @endif
                    @else
                        -
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <!-- 3. Riwayat Penyakit Terdahulu dan Riwayat Pengobatan -->
    <div class="content-section">
        <div class="section-title">3. RIWAYAT PENYAKIT TERDAHULU DAN RIWAYAT PENGOBATAN</div>
        <table class="detail-table">
            <tr>
                <th class="text-center" style="width: 50%;">Riwayat Penyakit Terdahulu (RPT)</th>
                <th class="text-center" style="width: 50%;">Riwayat Penggunaan Obat (RPO)</th>
            </tr>
            <tr>
                <td style="height: 80px; vertical-align: top;">
                    {{ optional($asesmen->rmeAsesmenParu)->riwayat_penyakit_terdahulu ?? '-' }}
                </td>
                <td style="height: 80px; vertical-align: top;">
                    {{ optional($asesmen->rmeAsesmenParu)->riwayat_penggunaan_obat ?? '-' }}
                </td>
            </tr>
        </table>
    </div>

    <!-- 4. Kebiasaan -->
    <div class="content-section">
        <div class="section-title">4. KEBIASAAN</div>
        <table class="detail-table">
            <tr>
                <td class="col-header">a. Merokok</td>
                <td>
                    <span class="checkbox-group">
                        <input type="checkbox" {{ optional($asesmen->rmeAsesmenParu)->merokok == 'tidak' ? 'checked' : '' }} disabled> Tidak
                    </span>
                    <span class="checkbox-group">
                        <input type="checkbox" {{ optional($asesmen->rmeAsesmenParu)->merokok == 'ya' ? 'checked' : '' }}
                            disabled> ya, jumlah:
                        {{ optional($asesmen->rmeAsesmenParu)->merokok_jumlah ?? '.....' }} batang/hari
                        Lama: {{ optional($asesmen->rmeAsesmenParu)->merokok_lama ?? '.....' }} tahun
                    </span>
                </td>
            </tr>
            <tr>
                <td class="col-header">b. Alkohol</td>
                <td>
                    <span class="checkbox-group">
                        <input type="checkbox" {{ optional($asesmen->rmeAsesmenParu)->alkohol == 'tidak' ? 'checked' : '' }} disabled> Tidak
                    </span>
                    <span class="checkbox-group">
                        <input type="checkbox" {{ optional($asesmen->rmeAsesmenParu)->alkohol == 'ya' ? 'checked' : '' }}
                            disabled> ya, jumlah:
                        {{ optional($asesmen->rmeAsesmenParu)->alkohol_jumlah ?? '.....' }}
                    </span>
                </td>
            </tr>
            <tr>
                <td class="col-header">c. Obat-obatan</td>
                <td>
                    <span class="checkbox-group">
                        <input type="checkbox" {{ optional($asesmen->rmeAsesmenParu)->obat_obatan == 'tidak' ? 'checked' : '' }} disabled> Tidak
                    </span>
                    <span class="checkbox-group">
                        <input type="checkbox" {{ optional($asesmen->rmeAsesmenParu)->obat_obatan == 'ya' ? 'checked' : '' }} disabled> ya
                        @if(optional($asesmen->rmeAsesmenParu)->obat_jenis)
                            - Jenis: {{ $asesmen->rmeAsesmenParu->obat_jenis }}
                        @endif
                    </span>
                </td>
            </tr>
        </table>
    </div>

    <!-- 5. Tanda-Tanda Vital -->
    <div class="content-section">
        <div class="section-title">5. TANDA-TANDA VITAL</div>
        <table class="detail-table">
            <tr>
                <td class="col-header">a. Sensorium</td>
                <td colspan="3">
                    @php
                        $sensorium = optional($asesmen->rmeAsesmenParu)->sensorium;
                    @endphp
                    <input type="checkbox" {{ $sensorium == 'cm' ? 'checked' : '' }} disabled> CM
                    <input type="checkbox" {{ $sensorium == 'cm_lemah' ? 'checked' : '' }} disabled> CM lemah
                    <input type="checkbox" {{ $sensorium == 'somnolen' ? 'checked' : '' }} disabled> Somnolen
                    <input type="checkbox" {{ $sensorium == 'soporus' ? 'checked' : '' }} disabled> Soporus
                    <input type="checkbox" {{ $sensorium == 'coma' ? 'checked' : '' }} disabled> Coma
                </td>
            </tr>
            <tr>
                <td class="col-header">b. Keadaan umum</td>
                <td colspan="3">
                    @php
                        $keadaanUmum = optional($asesmen->rmeAsesmenParu)->keadaan_umum;
                    @endphp
                    <input type="checkbox" {{ $keadaanUmum == 'baik' ? 'checked' : '' }} disabled> Baik
                    <input type="checkbox" {{ $keadaanUmum == 'sedang' ? 'checked' : '' }} disabled> Sedang
                    <input type="checkbox" {{ $keadaanUmum == 'jelek' ? 'checked' : '' }} disabled> Jelek
                </td>
            </tr>
            <tr>
                <td class="col-header">c. Tekanan darah</td>
                <td>{{ optional($asesmen->rmeAsesmenParu)->darah_sistole ?? '.....' }}/{{ optional($asesmen->rmeAsesmenParu)->darah_diastole ?? '.....' }}
                    mmHg</td>
                <td class="col-header">Dyspnoe</td>
                <td>
                    <input type="checkbox" {{ optional($asesmen->rmeAsesmenParu)->dyspnoe == 'tidak' ? 'checked' : '' }}
                        disabled> Tidak
                    <input type="checkbox" {{ optional($asesmen->rmeAsesmenParu)->dyspnoe == 'ya' ? 'checked' : '' }}
                        disabled> Ya
                </td>
            </tr>
            <tr>
                <td class="col-header">d. Nadi/pulse</td>
                <td>{{ optional($asesmen->rmeAsesmenParu)->nadi ?? '.....' }} x/menit</td>
                <td class="col-header">Cyanose</td>
                <td>
                    <input type="checkbox" {{ optional($asesmen->rmeAsesmenParu)->cyanose == 'tidak' ? 'checked' : '' }}
                        disabled> Tidak
                    <input type="checkbox" {{ optional($asesmen->rmeAsesmenParu)->cyanose == 'ya' ? 'checked' : '' }}
                        disabled> Ya
                </td>
            </tr>
            <tr>
                <td class="col-header">e. Frekuensi Pernafasan</td>
                <td>{{ optional($asesmen->rmeAsesmenParu)->frekuensi_pernafasan ?? '.....' }} x/menit
                    ({{ optional($asesmen->rmeAsesmenParu)->pernafasan_tipe == 'reguler' ? 'Reg' : 'Irreg' }})</td>
                <td class="col-header">Oedema</td>
                <td>
                    <input type="checkbox" {{ optional($asesmen->rmeAsesmenParu)->oedema == 'tidak' ? 'checked' : '' }}
                        disabled> Tidak
                    <input type="checkbox" {{ optional($asesmen->rmeAsesmenParu)->oedema == 'ya' ? 'checked' : '' }}
                        disabled> Ya
                </td>
            </tr>
            <tr>
                <td class="col-header">f. Temperatur</td>
                <td>{{ optional($asesmen->rmeAsesmenParu)->temperatur ?? '.....' }} °C</td>
                <td class="col-header">Icterus</td>
                <td>
                    <input type="checkbox" {{ optional($asesmen->rmeAsesmenParu)->icterus == 'tidak' ? 'checked' : '' }}
                        disabled> Tidak
                    <input type="checkbox" {{ optional($asesmen->rmeAsesmenParu)->icterus == 'ya' ? 'checked' : '' }}
                        disabled> Ya
                </td>
            </tr>
            <tr>
                <td class="col-header">g. Saturasi Oksigen</td>
                <td>{{ optional($asesmen->rmeAsesmenParu)->saturasi_oksigen ?? '.....' }}%</td>
                <td class="col-header">Anemia</td>
                <td>
                    <input type="checkbox" {{ optional($asesmen->rmeAsesmenParu)->anemia == 'tidak' ? 'checked' : '' }}
                        disabled> Tidak
                    <input type="checkbox" {{ optional($asesmen->rmeAsesmenParu)->anemia == 'ya' ? 'checked' : '' }}
                        disabled> Ya
                </td>
            </tr>
        </table>
    </div>

    <!-- Page Break untuk halaman 2 -->
    <div class="page-break"></div>

    <!-- 6. Pemeriksaan Fisik -->
    <div class="content-section">
        <div class="section-title">6. PEMERIKSAAN FISIK</div>

        @if($pemeriksaanFisik && $pemeriksaanFisik->count() > 0)
            @php
                // Buat mapping pemeriksaan fisik berdasarkan id_item_fisik
                $pemeriksaanFisikMap = [];
                foreach ($pemeriksaanFisik as $item) {
                    $pemeriksaanFisikMap[$item->id_item_fisik] = $item;
                }

                // Mapping nama item fisik sesuai dengan show.blade.php
                $fisikItems = [
                    1 => 'Kepala',
                    2 => 'Mata',
                    3 => 'THT',
                    4 => 'Leher',
                    5 => 'Thoraks - Jantung',
                    6 => 'Thoraks - Paru'
                ];
            @endphp

            <table class="detail-table">
                @foreach($fisikItems as $itemId => $itemName)
                    @php
                        $pemeriksaan = $pemeriksaanFisikMap[$itemId] ?? null;
                        $status = optional($pemeriksaan)->is_normal;
                        $keterangan = optional($pemeriksaan)->keterangan;
                        $prefix = chr(96 + $itemId); // a, b, c, d, e, f
                    @endphp
                    <tr>
                        <td class="col-header" style="width: 25%;">{{ $prefix }}. {{ $itemName }}</td>
                        <td>
                            @if($status === 1 || $status === '1')
                                Normal
                            @elseif($status === 0 || $status === '0')
                                Tidak Normal
                                @if($keterangan)
                                    - {{ $keterangan }}
                                @endif
                            @else
                                ................................................................
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        @else
            <!-- Fallback jika tidak ada data pemeriksaan fisik -->
            <table class="detail-table">
                <tr>
                    <td class="col-header">a. Kepala:</td>
                    <td>................................................................</td>
                </tr>
                <tr>
                    <td class="col-header">b. Mata:</td>
                    <td>................................................................</td>
                </tr>
                <tr>
                    <td class="col-header">c. THT:</td>
                    <td>................................................................</td>
                </tr>
                <tr>
                    <td class="col-header">d. Leher:</td>
                    <td>................................................................</td>
                </tr>
                <tr>
                    <td class="col-header">e. Thoraks - Jantung:</td>
                    <td>................................................................</td>
                </tr>
                <tr>
                    <td class="col-header">f. Thoraks - Paru:</td>
                    <td>................................................................</td>
                </tr>
            </table>
        @endif
    </div>

    <!-- 7. Rencana Kerja dan Penatalaksanaan -->
    <div class="content-section">
        <div class="section-title">7. RENCANA KERJA DAN PENATALAKSANAAN</div>
        @php
            $rencanaKerja = optional($asesmen->rmeAsesmenParuRencanaKerja);
        @endphp
        <table class="detail-table">
            <tr>
                <td style="width: 70%;">a. Foto thoraks</td>
                <td style="width: 30%; text-align: center;">
                    <input type="checkbox" {{ $rencanaKerja->foto_thoraks ? 'checked' : '' }} disabled>
                </td>
            </tr>
            <tr>
                <td>b. Pemeriksaan darah rutin</td>
                <td style="text-align: center;">
                    <input type="checkbox" {{ $rencanaKerja->darah_rutin ? 'checked' : '' }} disabled>
                </td>
            </tr>
            <tr>
                <td>c. Pemeriksaan LED</td>
                <td style="text-align: center;">
                    <input type="checkbox" {{ $rencanaKerja->led ? 'checked' : '' }} disabled>
                </td>
            </tr>
            <tr>
                <td>d. Pemeriksaan sputum BTA</td>
                <td style="text-align: center;">
                    <input type="checkbox" {{ $rencanaKerja->sputum_bta ? 'checked' : '' }} disabled>
                </td>
            </tr>
            <tr>
                <td>e. Pemeriksaan KGDS</td>
                <td style="text-align: center;">
                    <input type="checkbox" {{ $rencanaKerja->igds ? 'checked' : '' }} disabled>
                </td>
            </tr>
            <tr>
                <td>f. Pemeriksaan faal hati (LFT)</td>
                <td style="text-align: center;">
                    <input type="checkbox" disabled>
                </td>
            </tr>
            <tr>
                <td>g. Pemeriksaan faal ginjal (RFT)</td>
                <td style="text-align: center;">
                    <input type="checkbox" {{ $rencanaKerja->faal_ginjal ? 'checked' : '' }} disabled>
                </td>
            </tr>
            <tr>
                <td>h. Pemeriksaan elektrolit</td>
                <td style="text-align: center;">
                    <input type="checkbox" {{ $rencanaKerja->elektrolit ? 'checked' : '' }} disabled>
                </td>
            </tr>
            <tr>
                <td>i. Pemeriksaan albumin</td>
                <td style="text-align: center;">
                    <input type="checkbox" {{ $rencanaKerja->albumin ? 'checked' : '' }} disabled>
                </td>
            </tr>
            <tr>
                <td>j. Pemeriksaan asam urat</td>
                <td style="text-align: center;">
                    <input type="checkbox" {{ $rencanaKerja->asam_urat ? 'checked' : '' }} disabled>
                </td>
            </tr>
            <tr>
                <td>k. Faal paru (APE, spirometri)</td>
                <td style="text-align: center;">
                    <input type="checkbox" {{ $rencanaKerja->faal_paru ? 'checked' : '' }} disabled>
                </td>
            </tr>
            <tr>
                <td>l. CT Scan thoraks</td>
                <td style="text-align: center;">
                    <input type="checkbox" {{ $rencanaKerja->ct_scan_thoraks ? 'checked' : '' }} disabled>
                </td>
            </tr>
            <tr>
                <td>m. Bronchoscopy</td>
                <td style="text-align: center;">
                    <input type="checkbox" {{ $rencanaKerja->bronchoscopy ? 'checked' : '' }} disabled>
                </td>
            </tr>
            <tr>
                <td>n. Proef Punctie</td>
                <td style="text-align: center;">
                    <input type="checkbox" {{ $rencanaKerja->proef_punctie ? 'checked' : '' }} disabled>
                </td>
            </tr>
            <tr>
                <td>o. Aspirasi cairan pleura</td>
                <td style="text-align: center;">
                    <input type="checkbox" {{ $rencanaKerja->aspirasi_cairan_pleura ? 'checked' : '' }} disabled>
                </td>
            </tr>
            <tr>
                <td>p. Pemasangan WSD</td>
                <td style="text-align: center;">
                    <input type="checkbox" {{ $rencanaKerja->penanganan_wsd ? 'checked' : '' }} disabled>
                </td>
            </tr>
            <tr>
                <td>q. Biopsi Kelenjar</td>
                <td style="text-align: center;">
                    <input type="checkbox" disabled>
                </td>
            </tr>
            <tr>
                <td>r. Mantoux Tes</td>
                <td style="text-align: center;">
                    <input type="checkbox" disabled>
                </td>
            </tr>
            <tr>
                <td>s. Lainnya:</td>
                <td>{{ $rencanaKerja->lainnya ?? '.............................' }}</td>
            </tr>
        </table>
    </div>

    <!-- Page Break untuk halaman 2 -->
    <div class="page-break"></div>

    <!-- 8. Perencanaan Pulang Pasien -->
    <div class="content-section">
        <div class="section-title">8. PERENCANAAN PULANG PASIEN (DISCHARGE PLANNING)</div>
        @php
            $dischargePlanning = optional($asesmen->rmeAsesmenParuPerencanaanPulang);
        @endphp

        <table class="detail-table">
            <tr>
                <td rowspan="4"
                    style="vertical-align: middle; text-align: center; font-weight: bold; background-color: #f8f9fa;">
                    Jika salah satu jawaban "ya" maka pasien membutuhkan rencana pulang khusus.
                </td>
                <td style="width: 40%;">Usia lanjut (> 60 th)</td>
                <td style="width: 15%;">
                    <span class="checkbox {{ $dischargePlanning->usia_lanjut == '1' ? 'checked' : '' }}"></span> Ya
                    <span class="checkbox {{ $dischargePlanning->usia_lanjut == '0' ? 'checked' : '' }}"></span> Tidak
                </td>
            </tr>
            <tr>
                <td>Hambatan mobilisasi</td>
                <td>
                    <span class="checkbox {{ $dischargePlanning->hambatan_mobilisasi == '1' ? 'checked' : '' }}"></span>
                    Ya
                    <span class="checkbox {{ $dischargePlanning->hambatan_mobilisasi == '0' ? 'checked' : '' }}"></span>
                    Tidak
                </td>
            </tr>
            <tr>
                <td>Membutuhkan pelayanan medis berkelanjutan</td>
                <td>
                    <span
                        class="checkbox {{ $dischargePlanning->penggunaan_media_berkelanjutan == 'ya' ? 'checked' : '' }}"></span>
                    Ya
                    <span
                        class="checkbox {{ $dischargePlanning->penggunaan_media_berkelanjutan == 'tidak' ? 'checked' : '' }}"></span>
                    Tidak
                </td>
            </tr>
            <tr>
                <td>Ketergantungan dengan orang lain dalam aktivitas harian</td>
                <td>
                    <span
                        class="checkbox {{ $dischargePlanning->ketergantungan_aktivitas == 'ya' ? 'checked' : '' }}"></span>
                    Ya
                    <span
                        class="checkbox {{ $dischargePlanning->ketergantungan_aktivitas == 'tidak' ? 'checked' : '' }}"></span>
                    Tidak
                </td>
            </tr>
        </table>

        <table class="detail-table" style="margin-top: 10px;">
            <tr>
                <td class="col-header">Diagnosis medis:</td>
                <td colspan="3">{{ $dischargePlanning->diagnosis_medis ?? '.............................' }}</td>
            </tr>
            <tr>
                <td class="col-header">Rencana Pulang Khusus:</td>
                <td colspan="3">{{ $dischargePlanning->rencana_pulang_khusus ?? '.............................' }}</td>
            </tr>
            <tr>
                <td class="col-header">Rencana Lama Perawatan:</td>
                <td>{{ $dischargePlanning->rencana_lama_perawatan ?? '.............................' }}</td>
                <td class="col-header">Rencana Tanggal Pulang:</td>
                <td>{{ $dischargePlanning->rencana_tgl_pulang ? date('d/m/Y', strtotime($dischargePlanning->rencana_tgl_pulang)) : '.............................' }}
                </td>
            </tr>
        </table>

        <!-- Kesimpulan Discharge Planning -->
        @if($dischargePlanning->kesimpulan_planing)
            <div style="margin-top: 10px; padding: 10px; border: 1px solid #333; background-color: #f8f9fa;">
                <strong>KESIMPULAN:</strong><br>
                {{ $dischargePlanning->kesimpulan_planing }}
            </div>
        @endif
    </div>

    <!-- Page Break untuk halaman 3 -->
    <div class="page-break"></div>

    <!-- 9. Diagnosis -->
    <div class="content-section">
        <div class="section-title">9. DIAGNOSIS</div>
        <table class="detail-table">
            <tr>
                <td class="col-header">DIAGNOSIS BANDING :</td>
                <td>
                    @if(optional($asesmen->rmeAsesmenParuDiagnosisImplementasi)->diagnosis_banding)
                        @php
                            $diagnosisBanding = json_decode($asesmen->rmeAsesmenParuDiagnosisImplementasi->diagnosis_banding, true);
                        @endphp
                        @if(is_array($diagnosisBanding) && !empty($diagnosisBanding))
                            @foreach($diagnosisBanding as $index => $diagnosis)
                                {{ $index + 1 }}. {{ $diagnosis }}<br>
                            @endforeach
                        @else
                            {{ $asesmen->rmeAsesmenParuDiagnosisImplementasi->diagnosis_banding }}
                        @endif
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <td class="col-header">DIAGNOSIS KERJA :</td>
                <td>
                    @if(optional($asesmen->rmeAsesmenParuDiagnosisImplementasi)->diagnosis_kerja)
                        @php
                            $diagnosisKerja = json_decode($asesmen->rmeAsesmenParuDiagnosisImplementasi->diagnosis_kerja, true);
                        @endphp
                        @if(is_array($diagnosisKerja) && !empty($diagnosisKerja))
                            @foreach($diagnosisKerja as $index => $diagnosis)
                                {{ $index + 1 }}. {{ $diagnosis }}<br>
                            @endforeach
                        @else
                            {{ $asesmen->rmeAsesmenParuDiagnosisImplementasi->diagnosis_kerja }}
                        @endif
                    @else
                        -
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <!-- Gambar Radiologi Paru -->
    <div class="content-section">
        <div class="section-title">GAMBAR RADIOLOGI PARU</div>
        <div style="height: 120px; border: 1px solid #333; text-align: center; padding: 50px;">
            @if(optional($asesmen->rmeAsesmenParuDiagnosisImplementasi)->gambar_radiologi_paru)
                <img src="{{ asset('storage/' . $asesmen->rmeAsesmenParuDiagnosisImplementasi->gambar_radiologi_paru) }}"
                    style="max-width: 100%; max-height: 100px;" alt="Gambar Radiologi Paru">
            @else
                [Area untuk gambar radiologi paru]
            @endif
        </div>
    </div>

    <!-- 10. Implementasi -->
    <div class="content-section">
        <div class="section-title">10. RENCANA PENATALAKSANAAN DAN PENGOBATAN</div>
        @php
            $implementasi = optional($asesmen->rmeAsesmenParuDiagnosisImplementasi);
            $observasi = $implementasi->observasi ? json_decode($implementasi->observasi, true) : [];
            $terapeutik = $implementasi->terapeutik ? json_decode($implementasi->terapeutik, true) : [];
            $edukasi = $implementasi->edukasi ? json_decode($implementasi->edukasi, true) : [];
            $kolaborasi = $implementasi->kolaborasi ? json_decode($implementasi->kolaborasi, true) : [];
        @endphp

        <div class="two-column">
            <h6 style="font-weight: bold; margin-bottom: 10px;">Observasi:</h6>
            @if(is_array($observasi) && !empty($observasi))
                @foreach($observasi as $index => $item)
                    {{ $index + 1 }}. {{ $item }}<br>
                @endforeach
            @else
                .....................................<br><br><br>
            @endif

            <h6 style="font-weight: bold; margin: 20px 0 10px 0;">Edukasi:</h6>
            @if(is_array($edukasi) && !empty($edukasi))
                @foreach($edukasi as $index => $item)
                    {{ $index + 1 }}. {{ $item }}<br>
                @endforeach
            @else
                .....................................<br><br><br>
            @endif
        </div>

        <div class="two-column">
            <h6 style="font-weight: bold; margin-bottom: 10px;">Terapeutik:</h6>
            @if(is_array($terapeutik) && !empty($terapeutik))
                @foreach($terapeutik as $index => $item)
                    {{ $index + 1 }}. {{ $item }}<br>
                @endforeach
            @else
                .....................................<br><br><br>
            @endif

            <h6 style="font-weight: bold; margin: 20px 0 10px 0;">Kolaborasi:</h6>
            @if(is_array($kolaborasi) && !empty($kolaborasi))
                @foreach($kolaborasi as $index => $item)
                    {{ $index + 1 }}. {{ $item }}<br>
                @endforeach
            @else
                .....................................<br><br><br>
            @endif
        </div>
        <div class="clear"></div>
    </div>

    <!-- Prognosis -->
    <div class="content-section">
        <div class="section-title">PROGNOSIS</div>
        <div>
            @if(optional($asesmen->rmeAsesmenParuDiagnosisImplementasi)->prognosis)
                @php
                    $prognosis = json_decode($asesmen->rmeAsesmenParuDiagnosisImplementasi->prognosis, true);
                @endphp
                @if(is_array($prognosis) && !empty($prognosis))
                    @foreach($prognosis as $index => $item)
                        {{ $index + 1 }}. {{ $item }}<br>
                    @endforeach
                @else
                    {{ $asesmen->rmeAsesmenParuDiagnosisImplementasi->prognosis }}
                @endif
            @else
                .....................................................................
            @endif
        </div>
    </div>

    <!-- Tanda Tangan -->
    <div class="sign-area">
        <div style="float: left; width: 48%;">
            <p>Tanggal:
                {{ optional($asesmen->rmeAsesmenParu)->tanggal ? date('d/m/Y', strtotime($asesmen->rmeAsesmenParu->tanggal)) : '.............................' }}
            </p>
            <p>Jam:
                {{ optional($asesmen->rmeAsesmenParu)->tanggal ? date('H:i', strtotime($asesmen->rmeAsesmenParu->jam_masuk)) : '.............................' }}
            </p>
        </div>
        <div class="sign-box">
            <p>Dokter yang memeriksa</p>
            <br><br><br>
            <p>( _________________________ )</p>
            <p>{{ optional($asesmen->user)->name ?? '.............................' }}</p>
            <p style="font-size: 9px;">ttd dan nama jelas</p>
        </div>
        <div class="clear"></div>
    </div>
</body>

</html>
