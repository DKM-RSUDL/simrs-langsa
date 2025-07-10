<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Asesmen Ginekologik</title>
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

        .checkbox {
            margin-right: 5px;
            vertical-align: middle;
        }

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

        .page-break {
            page-break-before: always;
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
            <h2 style="font-size: 14px; margin: 5px 0;">Ginekologik</h2>
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
                <td>{{ $asesmen->rmeAsesmenGinekologik->tanggal ? date('d M Y', strtotime($asesmen->rmeAsesmenGinekologik->tanggal)) : '-' }}
                    {{ $asesmen->rmeAsesmenGinekologik->jam_masuk ? date('H:i', strtotime($asesmen->rmeAsesmenGinekologik->jam_masuk)) : '-' }}
                </td>
            </tr>
            <tr>
                <td class="col-header">Kondisi Masuk:</td>
                <td>{{ $asesmen->rmeAsesmenGinekologik->kondisi_masuk ?? '-' }}</td>
                <td class="col-header">Diagnosis Masuk:</td>
                <td>{{ $asesmen->rmeAsesmenGinekologik->diagnosis_masuk ?? '-' }}</td>
            </tr>
            <tr>
                <td class="col-header">Ruang:</td>
                <td colspan="3">{{ $dataMedis->unit->nama_unit ?? '-'}}</td>
            </tr>
        </table>
    </div>

    <!-- 2. G/P/A (Gravida, Para, Abortus) -->
    <div class="content-section">
        <div class="section-title">2. G/P/A (GRAVIDA, PARA, ABORTUS)</div>
        <table class="detail-table">
            <tr>
                <td class="col-header">Gravida:</td>
                <td>{{ $asesmen->rmeAsesmenGinekologik->gravida ?? '-' }}</td>
                <td class="col-header">Para:</td>
                <td>{{ $asesmen->rmeAsesmenGinekologik->para ?? '-' }}</td>
            </tr>
            <tr>
                <td class="col-header">Abortus:</td>
                <td colspan="3">{{ $asesmen->rmeAsesmenGinekologik->abortus ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <!-- 3. Keluhan Utama -->
    <div class="content-section">
        <div class="section-title">3. KELUHAN UTAMA</div>
        <table class="detail-table">
            <tr>
                <td class="col-header">Keluhan Utama/Alasan Masuk RS:</td>
                <td colspan="3">{{ $asesmen->rmeAsesmenGinekologik->keluhan_utama ?? '-' }}</td>
            </tr>
            <tr>
                <td class="col-header">Riwayat Penyakit:</td>
                <td colspan="3">{{ $asesmen->rmeAsesmenGinekologik->riwayat_penyakit ?? '-' }}</td>
            </tr>
            <tr>
                <td class="col-header">Riwayat Haid - Siklus:</td>
                <td>{{ $asesmen->rmeAsesmenGinekologik->siklus ? $asesmen->rmeAsesmenGinekologik->siklus . ' Hari' : '-' }}</td>
                <td class="col-header">HPHT:</td>
                <td>{{ $asesmen->rmeAsesmenGinekologik->hpht ?? '-' }}</td>
            </tr>
            <tr>
                <td class="col-header">Usia Kehamilan:</td>
                <td>{{ $asesmen->rmeAsesmenGinekologik->usia_kehamilan ?? '-' }}</td>
                <td class="col-header">Perkawinan - Jumlah:</td>
                <td>{{ $asesmen->rmeAsesmenGinekologik->jumlah ? $asesmen->rmeAsesmenGinekologik->jumlah . ' Kali' : '-' }}</td>
            </tr>
            <tr>
                <td class="col-header">Dengan Suami Sekarang:</td>
                <td colspan="3">{{ $asesmen->rmeAsesmenGinekologik->tahun ? $asesmen->rmeAsesmenGinekologik->tahun . ' Tahun' : '-' }}</td>
            </tr>
        </table>
    </div>

    <!-- 4. Riwayat Obstetrik -->
    <div class="content-section">
        <div class="section-title">4. RIWAYAT OBSTETRIK</div>
        @if (!empty($asesmen->rmeAsesmenGinekologik->riwayat_obstetrik))
            @php
                $riwayatObstetrik = json_decode($asesmen->rmeAsesmenGinekologik->riwayat_obstetrik, true) ?? [];
            @endphp
            @if (!empty($riwayatObstetrik) && is_array($riwayatObstetrik))
                <table class="detail-table">
                    <thead>
                        <tr>
                            <th>Keadaan</th>
                            <th>Kehamilan</th>
                            <th>Cara Persalinan</th>
                            <th>Keadaan Nifas</th>
                            <th>Tanggal Lahir</th>
                            <th>Keadaan Anak</th>
                            <th>Tempat dan Penolong</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($riwayatObstetrik as $index => $item)
                            <tr>
                                <td>{{ $item['keadaan'] ?? '-' }}</td>
                                <td>{{ $item['kehamilan'] ?? '-' }}</td>
                                <td>{{ $item['caraPersalinan'] ?? '-' }}</td>
                                <td>{{ $item['keadaanNifas'] ?? '-' }}</td>
                                <td>{{ !empty($item['tanggalLahir']) ? date('d M Y', strtotime($item['tanggalLahir'])) : '-' }}</td>
                                <td>{{ $item['keadaanAnak'] ?? '-' }}</td>
                                <td>{{ $item['tempatPenolong'] ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <table class="detail-table">
                    <tr>
                        <td>Tidak ada data riwayat obstetrik</td>
                    </tr>
                </table>
            @endif
        @else
            <table class="detail-table">
                <tr>
                    <td>Tidak ada data riwayat obstetrik</td>
                </tr>
            </table>
        @endif
    </div>

    <!-- 5. Riwayat Penyakit Dahulu -->
    <div class="content-section">
        <div class="section-title">5. RIWAYAT PENYAKIT DAHULU/TERMASUK OPERASI DAN KELUARGA BERENCANA</div>
        <table class="detail-table">
            <tr>
                <td>{{ $asesmen->rmeAsesmenGinekologik->riwayat_penyakit_dahulu ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <!-- Page Break untuk halaman kedua -->
    <div class="page-break"></div>

    <!-- 6. Pemeriksaan Fisik -->
    <div class="content-section">
        <div class="section-title">6. PEMERIKSAAN FISIK</div>
        <table class="detail-table">
            <tr>
                <td colspan="4">
                    <span style="font-weight: bold;">Pemeriksaan Fisik</span>
                    <br>
                    Centang normal jika fisik yang dinilai normal. Jika tidak dipilih, maka pemeriksaan tidak dilakukan.
                </td>
            </tr>
            @php
                // Fetch all physical examination items from MrItemFisik
                $fisikItems = \App\Models\MrItemFisik::orderBy('urut')->get()->pluck('nama', 'id')->toArray();

                // Create mapping of pemeriksaan fisik by id_item_fisik
                $pemeriksaanFisikMap = [];
                foreach ($pemeriksaanFisik ?? [] as $item) {
                    $pemeriksaanFisikMap[$item->id_item_fisik] = $item;
                }

                // Split items into two columns
                $totalItems = count($fisikItems);
                $halfCount = ceil($totalItems / 2);
                $firstColumn = array_slice($fisikItems, 0, $halfCount, true);
                $secondColumn = array_slice($fisikItems, $halfCount, null, true);
                $maxRows = max(count($firstColumn), count($secondColumn));
            @endphp

            @for ($i = 0; $i < $maxRows; $i++)
                <tr>
                    <!-- First Column -->
                    <td class="col-header" style="width: 25%;">
                        @if (isset($firstColumn[array_keys($firstColumn)[$i]]))
                            @php
                                $itemId = array_keys($firstColumn)[$i];
                                $itemName = $firstColumn[$itemId];
                                $pemeriksaan = $pemeriksaanFisikMap[$itemId] ?? null;
                                $status = optional($pemeriksaan)->is_normal;
                                $keterangan = optional($pemeriksaan)->keterangan;
                                $prefix = chr(97 + array_keys($firstColumn)[$i]); // a, b, c, ...
                            @endphp
                            {{ $prefix }}. {{ $itemName }}
                        @else
                            &nbsp;
                        @endif
                    </td>
                    <td style="width: 25%;">
                        @if (isset($firstColumn[array_keys($firstColumn)[$i]]))
                            @if($status === 1 || $status === '1')
                                Normal
                            @elseif($status === 0 || $status === '0')
                                Tidak Normal
                                @if($keterangan)
                                    - {{ $keterangan }}
                                @endif
                            @else
                                Tidak Diperiksa
                            @endif
                        @else
                            &nbsp;
                        @endif
                    </td>

                    <!-- Second Column -->
                    <td class="col-header" style="width: 25%;">
                        @if (isset($secondColumn[array_keys($secondColumn)[$i]]))
                            @php
                                $itemId = array_keys($secondColumn)[$i];
                                $itemName = $secondColumn[$itemId];
                                $pemeriksaan = $pemeriksaanFisikMap[$itemId] ?? null;
                                $status = optional($pemeriksaan)->is_normal;
                                $keterangan = optional($pemeriksaan)->keterangan;
                                $prefix = chr(97 + count($firstColumn) + $i); // continues from first column
                            @endphp
                            {{ $prefix }}. {{ $itemName }}
                        @else
                            &nbsp;
                        @endif
                    </td>
                    <td style="width: 25%;">
                        @if (isset($secondColumn[array_keys($secondColumn)[$i]]))
                            @if($status === 1 || $status === '1')
                                Normal
                            @elseif($status === 0 || $status === '0')
                                Tidak Normal
                                @if($keterangan)
                                    - {{ $keterangan }}
                                @endif
                            @else
                                Tidak Diperiksa
                            @endif
                        @else
                            &nbsp;
                        @endif
                    </td>
                </tr>
            @endfor
        </table>
    </div>

    <!-- 7. Pemeriksaan Ekstremitas -->
    <div class="content-section">
        <div class="section-title">7. PEMERIKSAAN EKSTREMITAS</div>
        <table class="detail-table">
            <tr>
                <td class="col-header" colspan="2">Ekstremitas Atas</td>
                <td class="col-header" colspan="2">Ekstremitas Bawah</td>
            </tr>
            <tr>
                <td class="col-header">Edema:</td>
                <td>{{ $asesmen->rmeAsesmenGinekologikEkstremitasGinekologik->edema_atas ?? '-' }}</td>
                <td class="col-header">Edema:</td>
                <td>{{ $asesmen->rmeAsesmenGinekologikEkstremitasGinekologik->edema_bawah ?? '-' }}</td>
            </tr>
            <tr>
                <td class="col-header">Varises:</td>
                <td>{{ $asesmen->rmeAsesmenGinekologikEkstremitasGinekologik->varises_atas ?? '-' }}</td>
                <td class="col-header">Varises:</td>
                <td>{{ $asesmen->rmeAsesmenGinekologikEkstremitasGinekologik->varises_bawah ?? '-' }}</td>
            </tr>
            <tr>
                <td class="col-header">Refleks:</td>
                <td>{{ $asesmen->rmeAsesmenGinekologikEkstremitasGinekologik->refleks_atas ?? '-' }}</td>
                <td class="col-header">Refleks:</td>
                <td>{{ $asesmen->rmeAsesmenGinekologikEkstremitasGinekologik->refleks_bawah ?? '-' }}</td>
            </tr>
            <tr>
                <td class="col-header">Catatan Tambahan:</td>
                <td colspan="3">{{ $asesmen->rmeAsesmenGinekologikEkstremitasGinekologik->catatan_ekstremitas ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <!-- 8. Status Ginekologik dan Pemeriksaan -->
    <div class="content-section">
        <div class="section-title">8. STATUS GINEKOLOGIK DAN PEMERIKSAAN</div>
        <table class="detail-table">
            <tr>
                <td class="col-header">Keadaan Umum:</td>
                <td>{{ $asesmen->rmeAsesmenGinekologikEkstremitasGinekologik->keadaan_umum ?? '-' }}</td>
                <td class="col-header">Status Ginekologik:</td>
                <td>{{ $asesmen->rmeAsesmenGinekologikEkstremitasGinekologik->status_ginekologik ?? '-' }}</td>
            </tr>
            <tr>
                <td class="col-header">Pemeriksaan:</td>
                <td>{{ $asesmen->rmeAsesmenGinekologikEkstremitasGinekologik->pemeriksaan ?? '-' }}</td>
                <td class="col-header">Inspekulo:</td>
                <td>{{ $asesmen->rmeAsesmenGinekologikEkstremitasGinekologik->inspekulo ?? '-' }}</td>
            </tr>
            <tr>
                <td class="col-header">VT (Vaginal Toucher):</td>
                <td>{{ $asesmen->rmeAsesmenGinekologikEkstremitasGinekologik->vt ?? '-' }}</td>
                <td class="col-header">RT (Rectal Toucher):</td>
                <td>{{ $asesmen->rmeAsesmenGinekologikEkstremitasGinekologik->rt ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <!-- 9. Hasil Pemeriksaan Penunjang -->
    <div class="content-section">
        <div class="section-title">9. HASIL PEMERIKSAAN PENUNJANG</div>
        <table class="detail-table">
            <tr>
                <td class="col-header">Laboratorium:</td>
                <td colspan="3">{{ $asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->laboratorium ?? '-' }}</td>
            </tr>
            <tr>
                <td class="col-header">USG:</td>
                <td colspan="3">{{ $asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->usg ?? '-' }}</td>
            </tr>
            <tr>
                <td class="col-header">Radiologi:</td>
                <td colspan="3">{{ $asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->radiologi ?? '-' }}</td>
            </tr>
            <tr>
                <td class="col-header">Lainnya:</td>
                <td colspan="3">{{ $asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->penunjang_lainnya ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <!-- Page Break untuk halaman kedua -->
    <div class="page-break"></div>

    <!-- 10. Discharge Planning -->
    <div class="content-section">
        <div class="section-title">10. DISCHARGE PLANNING</div>
        <table class="detail-table">
            <tr>
                <td class="col-header">Diagnosis Medis:</td>
                <td colspan="3">{{ $asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->diagnosis_medis ?? '-' }}</td>
            </tr>
            <tr>
                <td class="col-header">Usia Lanjut:</td>
                <td>{{ $asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->usia_lanjut == '0' ? 'Ya' : ($asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->usia_lanjut == '1' ? 'Tidak' : '-') }}</td>
                <td class="col-header">Hambatan Mobilisasi:</td>
                <td>{{ $asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->hambatan_mobilisasi == '0' ? 'Ya' : ($asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->hambatan_mobilisasi == '1' ? 'Tidak' : '-') }}</td>
            </tr>
            <tr>
                <td class="col-header">Membutuhkan Penggunaan Media Berkelanjutan:</td>
                <td colspan="3">{{ $asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->penggunaan_media_berkelanjutan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="col-header">Ketergantungan dengan Orang Lain dalam Aktivitas Harian:</td>
                <td colspan="3">{{ $asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->ketergantungan_aktivitas ?? '-' }}</td>
            </tr>
            <tr>
                <td class="col-header">Pasien/Keluarga Memerlukan Keterampilan Khusus Setelah Pulang:</td>
                <td colspan="3">{{ $asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->keterampilan_khusus ?? '-' }}</td>
            </tr>
            <tr>
                <td class="col-header">Pasien Memerlukan Alat Bantu Setelah Keluar Rumah Sakit:</td>
                <td colspan="3">{{ $asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->alat_bantu ?? '-' }}</td>
            </tr>
            <tr>
                <td class="col-header">Pasien Memiliki Nyeri Kronis dan/atau Kebiasaan Setelah Pulang:</td>
                <td colspan="3">{{ $asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->nyeri_kronis ?? '-' }}</td>
            </tr>
            <tr>
                <td class="col-header">Perkiraan Lama Hari Dirawat:</td>
                <td>{{ $asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->perkiraan_hari ?? '-' }}</td>
                <td class="col-header">Rencana Tanggal Pulang:</td>
                <td>{{ $asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->tanggal_pulang ? date('d M Y', strtotime($asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->tanggal_pulang)) : '-' }}</td>
            </tr>
            <tr>
                <td class="col-header">Kesimpulan:</td>
                <td colspan="3">{{ $asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->kesimpulan_planing ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <!-- 11. Diagnosis -->
    <div class="content-section">
        <div class="section-title">11. DIAGNOSIS</div>
        <table class="detail-table">
            <tr>
                <td class="col-header">DIAGNOSIS BANDING :</td>
                <td>
                    @if(optional($asesmen->rmeAsesmenGinekologikDiagnosisImplementasi)->diagnosis_banding)
                        @php
                            $diagnosisBanding = json_decode($asesmen->rmeAsesmenGinekologikDiagnosisImplementasi->diagnosis_banding, true);
                        @endphp
                        @if(is_array($diagnosisBanding) && !empty($diagnosisBanding))
                            @foreach($diagnosisBanding as $index => $diagnosis)
                                {{ $index + 1 }}. {{ $diagnosis }}<br>
                            @endforeach
                        @else
                            {{ $asesmen->rmeAsesmenGinekologikDiagnosisImplementasi->diagnosis_banding }}
                        @endif
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <td class="col-header">DIAGNOSIS KERJA :</td>
                <td>
                    @if(optional($asesmen->rmeAsesmenGinekologikDiagnosisImplementasi)->diagnosis_kerja)
                        @php
                            $diagnosisKerja = json_decode($asesmen->rmeAsesmenGinekologikDiagnosisImplementasi->diagnosis_kerja, true);
                        @endphp
                        @if(is_array($diagnosisKerja) && !empty($diagnosisKerja))
                            @foreach($diagnosisKerja as $index => $diagnosis)
                                {{ $index + 1 }}. {{ $diagnosis }}<br>
                            @endforeach
                        @else
                            {{ $asesmen->rmeAsesmenGinekologikDiagnosisImplementasi->diagnosis_kerja }}
                        @endif
                    @else
                        -
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <!-- 12. Implementasi -->
    <div class="content-section">
        <div class="section-title">12. RENCANA PENATALAKSANAAN DAN PENGOBATAN</div>
        @php
            $implementasi = optional($asesmen->rmeAsesmenGinekologikDiagnosisImplementasi);
            $observasi = $implementasi->observasi ? json_decode($implementasi->observasi, true) : [];
            $terapeutik = $implementasi->terapeutik ? json_decode($implementasi->terapeutik, true) : [];
            $edukasi = $implementasi->edukasi ? json_decode($implementasi->edukasi, true) : [];
            $kolaborasi = $implementasi->kolaborasi ? json_decode($implementasi->kolaborasi, true) : [];
            $prognosis = $implementasi->prognosis ? json_decode($implementasi->prognosis, true) : [];
        @endphp

        <table class="detail-table">
            <tr>
                <td class="col-header" style="width: 25%;">Observasi:</td>
                <td style="width: 25%;">
                    @if(is_array($observasi) && !empty($observasi))
                        @foreach($observasi as $index => $item)
                            {{ $index + 1 }}. {{ $item }}<br>
                        @endforeach
                    @else
                        -
                    @endif
                </td>
                <td class="col-header" style="width: 25%;">Terapeutik:</td>
                <td style="width: 25%;">
                    @if(is_array($terapeutik) && !empty($terapeutik))
                        @foreach($terapeutik as $index => $item)
                            {{ $index + 1 }}. {{ $item }}<br>
                        @endforeach
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <td class="col-header">Edukasi:</td>
                <td>
                    @if(is_array($edukasi) && !empty($edukasi))
                        @foreach($edukasi as $index => $item)
                            {{ $index + 1 }}. {{ $item }}<br>
                        @endforeach
                    @else
                        -
                    @endif
                </td>
                <td class="col-header">Kolaborasi:</td>
                <td>
                    @if(is_array($kolaborasi) && !empty($kolaborasi))
                        @foreach($kolaborasi as $index => $item)
                            {{ $index + 1 }}. {{ $item }}<br>
                        @endforeach
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <td class="col-header">Prognosis:</td>
                <td colspan="3">
                    @if(is_array($prognosis) && !empty($prognosis))
                        @foreach($prognosis as $index => $item)
                            {{ $index + 1 }}. {{ $item }}<br>
                        @endforeach
                    @else
                        -
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <!-- Tanda Tangan -->
    <div class="sign-area">
        <div style="float: left; width: 48%;">
            <p>Tanggal:
                {{ optional($asesmen->rmeAsesmenGinekologik)->tanggal ? date('d/m/Y', strtotime($asesmen->rmeAsesmenGinekologik->tanggal)) : '.............................' }}
            </p>
            <p>Jam:
                {{ optional($asesmen->rmeAsesmenGinekologik)->jam_masuk ? date('H:i', strtotime($asesmen->rmeAsesmenGinekologik->jam_masuk)) : '.............................' }}
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
