<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Hasil Lab Hemodialisa - {{ $dataMedis->pasien->nama ?? '' }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 10mm;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9pt;
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

        /* Tabel untuk Hasil Lab */
        .lab-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
        }

        .lab-table th,
        .lab-table td {
            border: 1px solid #ccc;
            padding: 4px 6px;
        }

        .lab-table th {
            background-color: #f2f2f2;
        }

        .lab-table th:nth-child(1) {
            width: 45%;
        }

        .lab-table th:nth-child(2) {
            width: 30%;
        }

        .lab-table th:nth-child(3) {
            width: 25%;
        }

        .empty-value {
            color: #888;
            font-style: italic;
        }

        /* Tabel untuk data non-lab */
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
    </style>
</head>

<body>
    @php
        // Ambil data detail untuk kemudahan
        $detail = $dataHasilLab->detail;
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
                    <span class="title-main">HASIL LAB</span>
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



    @if ($detail)
        <!-- Bagian Hematologi -->
        <div class="section">
            <div class="section-title">Hematologi</div>
            <table class="lab-table">
                <thead>
                    <tr>
                        <th>Pemeriksaan</th>
                        <th>Hasil</th>
                        <th>Satuan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Hemoglobin (Hb)</td>
                        <td>{{ $detail->hb ?? '-' }}</td>
                        <td>g/dL</td>
                    </tr>
                    <tr>
                        <td>Leukosit</td>
                        <td>{{ $detail->leukosit ?? '-' }}</td>
                        <td>10³/µL</td>
                    </tr>
                    <tr>
                        <td>Thrombosit</td>
                        <td>{{ $detail->thrombosit ?? '-' }}</td>
                        <td>10³/µL</td>
                    </tr>
                    <tr>
                        <td>Hematokrit</td>
                        <td>{{ $detail->hematokrit ?? '-' }}</td>
                        <td>%</td>
                    </tr>
                    <tr>
                        <td>Eritrosit</td>
                        <td>{{ $detail->eritrosit ?? '-' }}</td>
                        <td>10⁶/µL</td>
                    </tr>
                    <tr>
                        <td>LED</td>
                        <td>{{ $detail->led ?? '-' }}</td>
                        <td>mm/jam</td>
                    </tr>
                    <tr>
                        <td>Golongan Darah</td>
                        <td colspan="2">{{ $detail->golongan_darah ?? '-' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Bagian Fungsi Ginjal -->
        <div class="section">
            <div class="section-title">Fungsi Ginjal</div>
            <table class="lab-table">
                <thead>
                    <tr>
                        <th>Pemeriksaan</th>
                        <th>Hasil</th>
                        <th>Satuan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Ureum Pre-Dialisis</td>
                        <td>{{ $detail->ureum_pre ?? '-' }}</td>
                        <td>mg/dL</td>
                    </tr>
                    <tr>
                        <td>Ureum Post-Dialisis</td>
                        <td>{{ $detail->ureum_post ?? '-' }}</td>
                        <td>mg/dL</td>
                    </tr>
                    <tr>
                        <td>Kreatinin Pre-Dialisis</td>
                        <td>{{ $detail->kreatinin_pre ?? '-' }}</td>
                        <td>mg/dL</td>
                    </tr>
                    <tr>
                        <td>Kreatinin Post-Dialisis</td>
                        <td>{{ $detail->kreatinin_post ?? '-' }}</td>
                        <td>mg/dL</td>
                    </tr>
                    <tr>
                        <td>URR (Urea Reduction Ratio)</td>
                        <td>{{ $detail->urr ?? '-' }}</td>
                        <td>%</td>
                    </tr>
                    <tr>
                        <td>Asam Urat</td>
                        <td>{{ $detail->asam_urat ?? '-' }}</td>
                        <td>mg/dL</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Bagian Anemia -->
        <div class="section">
            <div class="section-title">Anemia</div>
            <table class="lab-table">
                <thead>
                    <tr>
                        <th>Pemeriksaan</th>
                        <th>Hasil</th>
                        <th>Satuan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Besi (Fe)</td>
                        <td>{{ $detail->besi_fe ?? '-' }}</td>
                        <td>µg/dL</td>
                    </tr>
                    <tr>
                        <td>TIBC</td>
                        <td>{{ $detail->tibc ?? '-' }}</td>
                        <td>µg/dL</td>
                    </tr>
                    <tr>
                        <td>Saturasi Transferin</td>
                        <td>{{ $detail->saturasi_transferin ?? '-' }}</td>
                        <td>%</td>
                    </tr>
                    <tr>
                        <td>Feritin</td>
                        <td>{{ $detail->feritin ?? '-' }}</td>
                        <td>ng/mL</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Bagian Fungsi Hati -->
        <div class="section">
            <div class="section-title">Fungsi Hati</div>
            <table class="lab-table">
                <thead>
                    <tr>
                        <th>Pemeriksaan</th>
                        <th>Hasil</th>
                        <th>Satuan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>SGOT</td>
                        <td>{{ $detail->sgot ?? '-' }}</td>
                        <td>U/L</td>
                    </tr>
                    <tr>
                        <td>SGPT</td>
                        <td>{{ $detail->sgpt ?? '-' }}</td>
                        <td>U/L</td>
                    </tr>
                    <tr>
                        <td>Bilirubin Total</td>
                        <td>{{ $detail->bilirubin_total ?? '-' }}</td>
                        <td>mg/dL</td>
                    </tr>
                    <tr>
                        <td>Bilirubin Direct</td>
                        <td>{{ $detail->bilirubin_direct ?? '-' }}</td>
                        <td>mg/dL</td>
                    </tr>
                    <tr>
                        <td>Protein Total</td>
                        <td>{{ $detail->protein_total ?? '-' }}</td>
                        <td>g/dL</td>
                    </tr>
                    <tr>
                        <td>Albumin</td>
                        <td>{{ $detail->albumin ?? '-' }}</td>
                        <td>g/dL</td>
                    </tr>
                    <tr>
                        <td>Fosfatase Alkali</td>
                        <td>{{ $detail->fosfatase_alkali ?? '-' }}</td>
                        <td>U/L</td>
                    </tr>
                    <tr>
                        <td>Gamma GT</td>
                        <td>{{ $detail->gamma_gt ?? '-' }}</td>
                        <td>U/L</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Halaman Baru jika perlu -->
        <div style="page-break-before: auto;"></div>

        <!-- Bagian Diabetes Melitus -->
        <div class="section">
            <div class="section-title">Diabetes Melitus</div>
            <table class="lab-table">
                <thead>
                    <tr>
                        <th>Pemeriksaan</th>
                        <th>Hasil</th>
                        <th>Satuan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Glukosa Puasa</td>
                        <td>{{ $detail->glukosa_puasa ?? '-' }}</td>
                        <td>mg/dL</td>
                    </tr>
                    <tr>
                        <td>Glukosa 2 Jam PP</td>
                        <td>{{ $detail->glukosa_2jam_pp ?? '-' }}</td>
                        <td>mg/dL</td>
                    </tr>
                    <tr>
                        <td>Glukosa Sewaktu</td>
                        <td>{{ $detail->glukosa_sewaktu ?? '-' }}</td>
                        <td>mg/dL</td>
                    </tr>
                    <tr>
                        <td>HbA1c</td>
                        <td>{{ $detail->hb1a1c ?? '-' }}</td>
                        <td>%</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Bagian Lemak -->
        <div class="section">
            <div class="section-title">Lemak</div>
            <table class="lab-table">
                <thead>
                    <tr>
                        <th>Pemeriksaan</th>
                        <th>Hasil</th>
                        <th>Satuan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Kolesterol Total</td>
                        <td>{{ $detail->kolesterol_total ?? '-' }}</td>
                        <td>mg/dL</td>
                    </tr>
                    <tr>
                        <td>LDL-C</td>
                        <td>{{ $detail->ldl_c ?? '-' }}</td>
                        <td>mg/dL</td>
                    </tr>
                    <tr>
                        <td>HDL-C</td>
                        <td>{{ $detail->hdl_c ?? '-' }}</td>
                        <td>mg/dL</td>
                    </tr>
                    <tr>
                        <td>Trigliserida</td>
                        <td>{{ $detail->trigliserida ?? '-' }}</td>
                        <td>mg/dL</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Bagian Faal Jantung -->
        <div class="section">
            <div class="section-title">Faal Jantung</div>
            <table class="lab-table">
                <thead>
                    <tr>
                        <th>Pemeriksaan</th>
                        <th>Hasil</th>
                        <th>Satuan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>CK</td>
                        <td>{{ $detail->ck ?? '-' }}</td>
                        <td>U/L</td>
                    </tr>
                    <tr>
                        <td>CK-MB</td>
                        <td>{{ $detail->ck_mb ?? '-' }}</td>
                        <td>U/L</td>
                    </tr>
                    <tr>
                        <td>Troponin T</td>
                        <td>{{ $detail->troponin_t ?? '-' }}</td>
                        <td>ng/mL</td>
                    </tr>
                    <tr>
                        <td>Troponin I</td>
                        <td>{{ $detail->troponin_i ?? '-' }}</td>
                        <td>ng/mL</td>
                    </tr>
                    <tr>
                        <td>LDH</td>
                        <td>{{ $detail->ldh ?? '-' }}</td>
                        <td>U/L</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Bagian Elektrolit -->
        <div class="section">
            <div class="section-title">Elektrolit</div>
            <table class="lab-table">
                <thead>
                    <tr>
                        <th>Pemeriksaan</th>
                        <th>Hasil</th>
                        <th>Satuan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Natrium</td>
                        <td>{{ $detail->natrium ?? '-' }}</td>
                        <td>mEq/L</td>
                    </tr>
                    <tr>
                        <td>Kalium</td>
                        <td>{{ $detail->kalium ?? '-' }}</td>
                        <td>mEq/L</td>
                    </tr>
                    <tr>
                        <td>Calcium Ion</td>
                        <td>{{ $detail->calcium_ion ?? '-' }}</td>
                        <td>mmol/L</td>
                    </tr>
                    <tr>
                        <td>Clorida</td>
                        <td>{{ $detail->clorida ?? '-' }}</td>
                        <td>mEq/L</td>
                    </tr>
                    <tr>
                        <td>Magnesium</td>
                        <td>{{ $detail->magnesium ?? '-' }}</td>
                        <td>mg/dL</td>
                    </tr>
                    <tr>
                        <td>Calcium Total</td>
                        <td>{{ $detail->calcium_total ?? '-' }}</td>
                        <td>mg/dL</td>
                    </tr>
                    <tr>
                        <td>Phospor</td>
                        <td>{{ $detail->phospor ?? '-' }}</td>
                        <td>mg/dL</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Bagian Imunoserology -->
        <div class="section">
            <div class="section-title">Imunoserology</div>
            <table class="lab-table">
                <thead>
                    <tr>
                        <th>Pemeriksaan</th>
                        <th colspan="2">Hasil</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>HbsAg Rapid</td>
                        <td colspan="2">{{ $detail->hbsag_rapid ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>HbsAg Elisa</td>
                        <td colspan="2">{{ $detail->hbsag_elisa ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Anti HCV Rapid</td>
                        <td colspan="2">{{ $detail->anti_hcv_rapid ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Anti HIV Rapid</td>
                        <td colspan="2">{{ $detail->anti_hiv_rapid ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Anti HIV 3 Metode</td>
                        <td colspan="2">{{ $detail->anti_hiv_3_metode ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>FOB</td>
                        <td colspan="2">{{ $detail->fob ?? '-' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    @else
    @endif



</body>

</html>
