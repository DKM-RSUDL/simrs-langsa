<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Pra Induksi - {{ $dataMedis->pasien->nama ?? 'Pasien' }}</title>
    <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
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
            margin-bottom: 12px;
        }

        .header-table td {
            vertical-align: middle;
            padding: 6px;
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
            padding: 12px 6px;
            text-align: center;
        }

        .hd-text {
            font-size: 16px;
            font-weight: bold;
            color: #ffffff;
        }

        /* PATIENT TABLE STYLE */
        .patient-table {
            width: 100%;
            margin-top: 6px;
            border-collapse: collapse;
            page-break-inside: avoid;
        }

        .patient-table th,
        .patient-table td {
            border: 1px solid #ccc;
            padding: 6px 8px;
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
            color: white;
            padding: 5px;
            margin: 12px 0 5px 0;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
            margin-top: 5px;
            page-break-inside: avoid;
        }

        .data-table th,
        .data-table td {
            border: 1px solid #ddd;
            padding: 6px 8px;
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
            margin-bottom: 6px;
            page-break-inside: avoid;
        }

        .form-label,
        .form-value {
            display: table-cell;
            padding: 6px 0;
            border-bottom: 1px solid #eee;
            vertical-align: top;
        }

        .form-label {
            width: 35%;
            font-weight: bold;
        }

        .form-value {
            width: 65%;
            padding-left: 10px;
        }

        .value-box {
            display: block;
            min-height: 20px;
            padding: 6px;
            background-color: #f9f9f9;
        }

        /* Make sure table rows don't break across pages */
        table,
        thead,
        tbody,
        tr,
        td,
        th {
            page-break-inside: avoid;
        }

        /* Small helper for columns that were missing */
        .nowrap {
            white-space: nowrap;
        }

        /* TTD STYLES */
        .ttd-container {
            margin-top: 30px;
            width: 100%;
            page-break-inside: avoid;
            display: table;
        }

        .ttd-cell {
            width: 33%;
            text-align: center;
            vertical-align: top;
            border: none;
            display: table-cell;
        }

        .ttd-line {
            margin-top: 60px;
            border-top: 1px solid #000;
            width: 80%;
            margin-left: auto;
            margin-right: auto;
        }

        /* small print note */
        .muted {
            font-size: 9pt;
            color: #666;
        }

        /* Kesimpulan box */
        .kesimpulan-box {
            padding: 8px;
            background-color: #28a745;
            color: white;
            border-radius: 4px;
            font-weight: bold;
            margin: 5px 0;
        }

        .subtitle {
            font-size: 10pt;
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    @php
        // Aliases untuk mempermudah akses
        $main = $okPraInduksi;
        $epas = $okPraInduksi->okPraInduksiEpas; // Evaluasi Pra Anestesi dan Sedasi
        $psas = $okPraInduksi->okPraInduksiPsas;
        // Pemantauan Selama Anestesi dan Sedasi
        $ctkp = $okPraInduksi->okPraInduksiCtkp;
        // Catatan Kamar Pemulihan
        $ipb = $okPraInduksi->okPraInduksiIpb;
        // Instruksi Pasca Bedah

        $pasien = $dataMedis->pasien;

        // --- HELPER FUNCTIONS DARI showprainduksiJS.txt ---

        if (!function_exists('getAvpuText')) {
            function getAvpuText($value)
            {
                switch ($value) {
                    case 0:
                        return 'Sadar Baik/Alert : 0';
                    case 1:
                        return 'Berespon dengan kata-kata/Voice: 1';
                    case 2:
                        return 'Hanya berespon jika dirangsang nyeri/pain: 2';
                    case 3:
                        return 'Pasien tidak sadar/unresponsive: 3';
                    case 4:
                        return 'Gelisah atau bingung: 4';
                    case 5:
                        return 'Acute Confusional States: 5';
                    default:
                        return '-';
                }
            }
        }

        if (!function_exists('getDukunganOksigenText')) {
            function getDukunganOksigenText($value)
            {
                switch ($value) {
                    case 1:
                        return 'Udara Bebas';
                    case 2:
                        return 'Kanul Nasal';
                    case 3:
                        return 'Simple Mark';
                    case 4:
                        return 'Rebreathing Mark';
                    case 5:
                        return 'No-Rebreathing Mark';
                    default:
                        return '-';
                }
            }
        }

        // Helper untuk Aldrete Score
        function getAldreteScore($score)
        {
            $map = [0 => '0', 1 => '1', 2 => '2'];
            return $map[$score] ?? '-';
        }

        // Parse monitoring/observasi/pain scale if exist
        $monitoringDataPSAS = json_decode($psas->all_monitoring_data ?? '[]', true) ?: [];
        $observasiData = json_decode($ctkp->all_observasi_data_ckp ?? '[]', true) ?: [];
        $painScaleData = json_decode($ctkp->pain_scale_data_json ?? '{}', true) ?: [];

        // Parse patient score data dan ambil data Bromage
        $patientScoreData = [];
        $skalaPasien = null;

        if (!empty($ctkp->patient_score_data_json)) {
            $decoded = json_decode($ctkp->patient_score_data_json, true);
            if (is_array($decoded) && !empty($decoded)) {
                $patientScoreData = $decoded;
            }
        }

        // --- DEFINISI UTAMA DATA BROMAGE (Mencari di dua kemungkinan key) ---
        $bromageData = $patientScoreData['bromage_data'] ?? ($patientScoreData['bromage'] ?? []);

        // Fallback: cek field skala_pasien
        if (empty($patientScoreData) && !empty($ctkp->skala_pasien)) {
            $skalaPasien = $ctkp->skala_pasien;
        }

        // Tentukan skala yang digunakan
        $selectedScale = null;
        if (!empty($patientScoreData)) {
            if (isset($patientScoreData['selected_score'])) {
                $selectedScale = $patientScoreData['selected_score'];
            } elseif (isset($patientScoreData['bromage_data'])) {
                $selectedScale = 'bromage';
            } elseif (isset($patientScoreData['steward_data'])) {
                $selectedScale = 'steward';
            } elseif (isset($patientScoreData['aldrete_data'])) {
                $selectedScale = 'aldrete';
            } elseif (isset($patientScoreData['padds_data'])) {
                $selectedScale = 'padds';
            }
        } elseif (!empty($skalaPasien)) {
            $selectedScale = $skalaPasien;
        }
    @endphp

    {{-- HEADER --}}
    <table class="header-table">
        <tr>
            <td class="td-left" style="width: 40%;">
                <table class="brand-table">
                    <tr>
                        <td class="va-middle" style="width: 60px;">
                            <img src="{{ asset('assets/img/Logo-RSUD-Langsa-1.png') }}" alt="Logo" class="brand-logo">
                        </td>
                        <td class="va-middle">
                            <p class="brand-name">RSUD Langsa</p>
                            <p class="brand-info">Jl. Jend. A. Yani No.1 Kota Langsa</p>
                        </td>
                    </tr>
                </table>
            </td>
            <td class="td-center" style="width: 40%; text-align: center;">
                <span class="title-main">PRA INDUKSI</span>
            </td>
            <td class="td-right" style="width: 20%;">
                <div class="hd-box"><span class="hd-text">OPERASI</span></div>
            </td>
        </tr>
    </table>

    {{-- PATIENT INFO --}}
    <table class="patient-table">
        <tr>
            <th>No. RM</th>
            <td>{{ $dataMedis->pasien->kd_pasien ?? '-' }}</td>
            <th>Jenis Kelamin</th>
            <td>{{ isset($dataMedis->pasien->jenis_kelamin) ? ($dataMedis->pasien->jenis_kelamin == 1 ? 'Laki-Laki' : 'Wanita') : '-' }}
            </td>
        </tr>
        <tr>
            <th>Nama Pasien</th>
            <td>{{ $pasien->nama ?? '-' }}</td>
            <th>Umur</th>
            <td>{{ $pasien->umur ?? '-' }} Tahun</td>
        </tr>
        <tr>
            <th>Tanggal Masuk</th>
            <td>
                {{ $main->tgl_masuk_pra_induksi ? date('Y-m-d', strtotime($main->tgl_masuk_pra_induksi)) : '-' }}
            </td>
            <th>Jam Masuk</th>
            <td>{{ $main->jam_masuk ? date('H:i', strtotime($main->jam_masuk)) : '-' }}</td>
        </tr>
    </table>

    {{-- 1. DATA MASUK --}}
    <div class="section-title">1. Data Masuk</div>
    <table class="data-table">
        <tr>
            <th style="width: 30%;">Tanggal Masuk</th>
            <td style="width: 70%;">
                {{ $main->tgl_masuk_pra_induksi ? date('Y-m-d', strtotime($main->tgl_masuk_pra_induksi)) : '-' }}
            </td>
        </tr>
        <tr>
            <th>Jam Masuk</th>
            <td>{{ $main->jam_masuk ? date('H:i', strtotime($main->jam_masuk)) : '-' }}</td>
        </tr>
    </table>

    {{-- 2. PRA INDUKSI --}}
    <div class="section-title">2. Pra Induksi</div>
    <table class="data-table">
        <tr>
            <th style="width: 25%;">Diagnosis</th>
            <td style="width: 75%;">{{ $main->diagnosis ?? '-' }}</td>
        </tr>
        <tr>
            <th>Tindakan</th>
            <td>{{ $main->tindakan ?? '-' }}</td>
        </tr>
        <tr>
            <th>Spesialis Anestesi</th>
            <td>{{ $main->spesialis_anestesi ?? '-' }}</td>
        </tr>
        <tr>
            <th>Penata Anestesi</th>
            <td>{{ $main->penata_anestesi ?? '-' }}</td>
        </tr>
        <tr>
            <th>Spesialis Bedah</th>
            <td>{{ $main->spesialis_bedah ?? '-' }}</td>
        </tr>
    </table>

    {{-- 3. Rencana Anestesi Spinal (RAS) --}}
    <div class="section-title">3. Rencana Anestesi Spinal (RAS)</div>
    <table class="data-table">
        <tr>
            <th style="width: 30%;">Tanggal</th>
            <td style="width: 70%;">{{ $main->ras_tanggal ? date('Y-m-d', strtotime($main->ras_tanggal)) : '-' }}</td>
        </tr>
        <tr>
            <th>Tingkat Anestesi Dan Sedasi</th>
            <td>{{ $main->ras_tingkat_anestesi ?? '-' }}</td>
        </tr>
        <tr>
            <th>Jenis Sedasi</th>
            <td>{{ $main->ras_jenis_sedasi ?? '-' }}</td>
        </tr>
        <tr>
            <th>Analgesia Pasca Sedasi</th>
            <td>{{ $main->ras_analgesia_pasca ?? '-' }}</td>
        </tr>
        <tr>
            <th>Jika Ada, Obat Yang Digunakan</th>
            <td>{{ $main->ras_obat_digunakan ?? '-' }}</td>
        </tr>
    </table>

    {{-- 4. Evaluasi Pra Anestesi dan Sedasi (EPAS) --}}
    <div class="section-title">4. Evaluasi Pra Anestesi dan Sedasi (EPAS)</div>
    <p class="subtitle">Keadaan Pra-Bedah</p>
    <table class="data-table">
        <tr>
            <th style="width: 30%;">Tek. Darah (mmHg)</th>
            <td style="width: 70%;">Sistole: {{ $epas->tekanan_darah_sistole ?? '-' }} / Diastole:
                {{ $epas->tekanan_darah_diastole ?? '-' }}</td>
        </tr>
        <tr>
            <th>Nadi (Per Menit)</th>
            <td>{{ $epas->nadi ?? '-' }}</td>
        </tr>
        <tr>
            <th>Nafas (Per Menit)</th>
            <td>{{ $epas->nafas ?? '-' }}</td>
        </tr>
        <tr>
            <th>Respirasi</th>
            <td>{{ $epas->respirasi ?? '-' }}</td>
        </tr>
        <tr>
            <th>Saturasi Oksigen (%)</th>
            <td>Tanpa bantuan O₂: {{ $epas->saturasi_tanpa_bantuan ?? '-' }}% / Dengan bantuan O₂:
                {{ $epas->saturasi_dengan_bantuan ?? '-' }}%</td>
        </tr>
        <tr>
            <th>Suhu (℃)</th>
            <td>{{ $epas->suhu ?? '-' }}</td>
        </tr>
        <tr>
            <th>AVPU</th>
            <td>{{ $epas->avpu !== null ? getAvpuText($epas->avpu) : '-' }}</td>
        </tr>
        <tr>
            <th>Glasgow Coma Scale (GCS)</th>
            <td>{{ $epas->gcs_total ?? '-' }}</td>
        </tr>
        <tr>
            <th>Golongan Darah</th>
            <td>{{ $epas->golongan_darah ?? '-' }}</td>
        </tr>
        <tr>
            <th>Akses Intravena (Tempat Dan Ukuran)</th>
            <td>{{ $epas->akses_intravena ?? '-' }}</td>
        </tr>
        <tr>
            <th>Status Fisik ASA</th>
            <td>{{ $epas->status_fisik_asa ?? '-' }}</td>
        </tr>
    </table>

    <p class="subtitle">Dukungan Oksigen</p>
    <table class="data-table">
        <tr>
            <th style="width: 30%;">Pemberian Oksigen Kepada Pasien</th>
            <td style="width: 70%;">
                {{ $epas->dukungan_pemberian_oksigen !== null ? getDukunganOksigenText($epas->dukungan_pemberian_oksigen) : '-' }}
            </td>
        </tr>
        <tr>
            <th>Jika Pasien Memerlukan Support Pernapasan</th>
            <td>{{ $epas->dukungan_support_pernapasan ?? '-' }}</td>
        </tr>
        <tr>
            <th>Jika Pasien Terintubasi</th>
            <td>Dengan bantuan O₂: {{ $epas->dukungan_terintubasi_o2 ?? '-' }} / persen(%):
                {{ $epas->dukungan_terintubasi_spo2 ?? '-' }}</td>
        </tr>
    </table>

    <p class="subtitle">Antropometri</p>
    <table class="data-table">
        <tr>
            <th style="width: 30%;">Tinggi Badan (Kg)</th>
            <td style="width: 70%;">{{ $epas->antropometri_tinggi_badan ?? '-' }}</td>
        </tr>
        <tr>
            <th>Berat Badan (Kg)</th>
            <td>{{ $epas->antropometri_berat_badan ?? '-' }}</td>
        </tr>
        <tr>
            <th>Indeks Massa Tubuh (IMT)</th>
            <td>{{ $epas->antropometri_imt ?? '-' }}</td>
        </tr>
        <tr>
            <th>Luas Permukaan Tubuh (LPT)</th>
            <td>{{ $epas->antropometri_lpt ?? '-' }}</td>
        </tr>
        <tr>
            <th>Obat Dan Pemantauan Selama Prosedur Dengan Anestesi Dan Sedasi</th>
            <td>{{ $epas->antropometri_obat_dan_pemantauan ?? '-' }}</td>
        </tr>
    </table>

    {{-- 5. Pemantauan Selama Anestesi dan Sedasi (PSAS) --}}
    <div class="section-title">5. Pemantauan Selama Anestesi dan Sedasi (PSAS)</div>

    <table class="data-table">
        <tr>
            <th style="width: 30%;">Hal Penting Yang Terjadi Selama Anestesi Dan Sedasi</th>
            <td style="width: 70%;">{{ $psas->hal_penting ?? '-' }}</td>
        </tr>
        <tr>
            <th>Kedalaman Anestesi Dan Sedasi</th>
            <td>{{ $psas->kedalaman_anestesi ?? '-' }}</td>
        </tr>
        <tr>
            <th>Respon Terhadap Anestesi Dan Sedasi</th>
            <td>{{ $psas->respon_anestesi ?? '-' }}</td>
        </tr>
    </table>

    <p class="subtitle">Grafik Pemantauan Selama Anestesi dan Sedasi (PSAS)</p>
    <div style="margin-top:8px; page-break-inside: avoid;">
        <canvas id="vitalSignsChartPSAS" height="150"></canvas>
    </div>

    {{-- PSAS monitoring table (every 5 mins) --}}
    <div style="margin-top:8px;"></div>
    <p class="subtitle">Data Pemantauan (Setiap 5 Menit)</p>
    <table class="data-table">
        <thead>
            <tr>
                <th>Waktu</th>
                <th>Sistole (mmHg)</th>
                <th>Diastole (mmHg)</th>
                <th>Nadi (Per Menit)</th>
                <th>Nafas (Per Menit)</th>
                <th>SpO₂ (%)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($monitoringDataPSAS as $data)
                <tr>
                    <td class="nowrap">{{ $data['time'] ?? '-' }}</td>
                    <td>{{ $data['sistole'] ?? '-' }}</td>
                    <td>{{ $data['diastole'] ?? '-' }}</td>
                    <td>{{ $data['nadi'] ?? '-' }}</td>
                    <td>{{ $data['nafas'] ?? '-' }}</td>
                    <td>{{ $data['spo2'] ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data pemantauan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- 6. Catatan Tindakan dan Kondisi Pasien (CTKP) --}}
    <div class="section-title" style="margin-top:10px">6. Catatan Tindakan dan Kondisi Pasien (CTKP)</div>

    <table class="data-table">
        <tr>
            <th style="width: 30%;">Data Masuk Jam</th>
            <td style="width: 70%;">
                {{ $ctkp->jam_masuk_pemulihan_ckp ? date('H:i', strtotime($ctkp->jam_masuk_pemulihan_ckp)) : '-' }}
            </td>
        </tr>
        <tr>
            <th>Jalan Nafas</th>
            <td>{{ $ctkp->jalan_nafas_ckp ?? '-' }}</td>
        </tr>
        <tr>
            <th>Jika Jalan Nafas Spontan</th>
            <td>{{ $ctkp->nafas_spontan_ckp ?? '-' }}</td>
        </tr>
        <tr>
            <th>Kesadaran</th>
            <td>{{ $ctkp->kesadaran_pemulihan_ckp ?? '-' }}</td>
        </tr>
    </table>

    {{-- Aldrete score --}}
    <p class="subtitle">Score Aldrete</p>
    <table class="data-table">
        <tr>
            <th style="width:30%;">Aktivitas</th>
            <td style="width:70%;">{{ getAldreteScore($ctkp->aktivitas) }}</td>
        </tr>
        <tr>
            <th>Sirkulasi</th>
            <td>{{ getAldreteScore($ctkp->sirkulasi) }}</td>
        </tr>
        <tr>
            <th>Pernafasan</th>
            <td>{{ getAldreteScore($ctkp->pernafasan) }}</td>
        </tr>
        <tr>
            <th>Kesadaran</th>
            <td>{{ getAldreteScore($ctkp->kesadaran) }}</td>
        </tr>
        <tr>
            <th>Warna Kulit</th>
            <td>{{ getAldreteScore($ctkp->warna_kulit) }}</td>
        </tr>
        <tr>
            <th>Total</th>
            <td>{{ $ctkp->total ?? '-' }}</td>
        </tr>
    </table>

    {{-- Observasi Pasca (tabel observasi per 5 menit) --}}
    <div style="margin-top:8px;"></div>
    <p class="subtitle">Observasi Pasca - Data Observasi (per 5 menit)</p>
    <table class="data-table">
        <thead>
            <tr>
                <th>Waktu</th>
                <th>Sistole (mmHg)</th>
                <th>Diastole (mmHg)</th>
                <th>Nadi (Per Menit)</th>
                <th>Nafas (Per Menit)</th>
                <th>SpO₂ (%)</th>
                <th>TVS</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($observasiData as $data)
                <tr>
                    <td class="nowrap">{{ $data['time'] ?? '-' }}</td>
                    <td>{{ $data['sistole'] ?? '-' }}</td>
                    <td>{{ $data['diastole'] ?? '-' }}</td>
                    <td>{{ $data['nadi'] ?? '-' }}</td>
                    <td>{{ $data['nafas'] ?? '-' }}</td>
                    <td>{{ $data['spo2'] ?? '-' }}</td>
                    <td>{{ $data['tvs'] ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data observasi</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top:10px; page-break-inside: avoid;">
        <p class="subtitle">Grafik Pasca Anestesi dan Sedasi</p>
        <canvas id="recoveryVitalChartCKP" height="150"></canvas>
    </div>

    {{-- Pain Scale (lengkap: NRS / FLACC / CRIES) --}}
    <div style="margin-top:8px;"></div>
    <p class="subtitle">Jenis Skala Nyeri</p>

    @if (isset($painScaleData) && is_array($painScaleData) && isset($painScaleData['selectedScale']))
        <table class="data-table">
            <tr>
                <th style="width: 30%;">Skala yang Digunakan</th>
                <td style="width: 70%;">
                    @if ($painScaleData['selectedScale'] == 'nrs')
                        Scale NRS / VAS / VRS
                    @elseif($painScaleData['selectedScale'] == 'flacc')
                        FLACC (Face, Legs, Activity, Cry, Consolability)
                    @elseif($painScaleData['selectedScale'] == 'cries')
                        CRIES (Neonatal)
                    @else
                        -
                    @endif
                </td>
            </tr>
        </table>

        @if ($painScaleData['selectedScale'] == 'nrs')
            <table class="data-table" style="margin-top:6px">
                <tr>
                    <th style="width: 30%;">Nilai NRS</th>
                    <td style="width: 70%;">{{ $painScaleData['nrs']['nilai'] ?? '0' }}</td>
                </tr>
                <tr>
                    <th>Jenis Skala</th>
                    <td>{{ isset($painScaleData['nrs']['scaleType']) && $painScaleData['nrs']['scaleType'] == 'wong-baker' ? 'Wong Baker Faces' : 'Numeric Rating Scale' }}
                    </td>
                </tr>
                <tr>
                    <th>Kategori</th>
                    <td>{{ $painScaleData['nrs']['kategori'] ?? 'Tidak Nyeri' }}</td>
                </tr>
            </table>
        @endif

        @if ($painScaleData['selectedScale'] == 'flacc')
            <table class="data-table" style="margin-top:6px">
                <thead>
                    <tr>
                        <th>Parameter</th>
                        <th>Nilai</th>
                        <th>Deskripsi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Wajah (Face)</td>
                        <td>{{ $painScaleData['flacc']['face'] ?? '0' }}</td>
                        <td>
                            @php $v = $painScaleData['flacc']['face'] ?? null; @endphp
                            @if ($v === 0)
                                Tersenyum / normal
                            @elseif ($v === 1)
                                Meringis / kurang respons
                            @elseif ($v === 2)
                                Ekspresi nyeri jelas
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Kaki (Legs)</td>
                        <td>{{ $painScaleData['flacc']['legs'] ?? '0' }}</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>Aktivitas (Activity)</td>
                        <td>{{ $painScaleData['flacc']['activity'] ?? '0' }}</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>Menangis (Cry)</td>
                        <td>{{ $painScaleData['flacc']['cry'] ?? '0' }}</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>Konsolabilitas</td>
                        <td>{{ $painScaleData['flacc']['consolability'] ?? '0' }}</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <strong>Total Skor:</strong> {{ $painScaleData['flacc']['total'] ?? '0' }} /
                            <strong>Kategori:</strong> {{ $painScaleData['flacc']['kategori'] ?? 'NYERI RINGAN' }}
                        </td>
                    </tr>
                </tbody>
            </table>
        @endif

        @if ($painScaleData['selectedScale'] == 'cries')
            <table class="data-table" style="margin-top:6px">
                <thead>
                    <tr>
                        <th>Parameter</th>
                        <th>Nilai</th>
                        <th>Deskripsi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Menangis (Cry)</td>
                        <td>{{ $painScaleData['cries']['cry'] ?? '0' }}</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>Requires (O₂)</td>
                        <td>{{ $painScaleData['cries']['requires'] ?? '0' }}</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>Increased (vital)</td>
                        <td>{{ $painScaleData['cries']['increased'] ?? '0' }}</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>Expression</td>
                        <td>{{ $painScaleData['cries']['expression'] ?? '0' }}</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>Sleepless</td>
                        <td>{{ $painScaleData['cries']['sleepless'] ?? '0' }}</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <strong>Total Skor:</strong> {{ $painScaleData['cries']['total'] ?? '0' }} /
                            <strong>Kategori:</strong> {{ $painScaleData['cries']['kategori'] ?? 'NYERI RINGAN' }}
                        </td>
                    </tr>
                </tbody>
            </table>
        @endif
    @else
        <div class="muted" style="padding:8px; background:#fff3cd; border:1px solid #ffeeba; margin-top:6px">
            Tidak ada data skala nyeri yang tersimpan.
        </div>
    @endif

    {{-- Nilai Skala Nyeri dan Kesimpulan --}}
    <table class="data-table" style="margin-top:6px">
        <tr>
            <th style="width: 30%;">Nilai Skala Nyeri</th>
            <td style="width: 70%;">
                {{ $selectedScale == 'nrs'
                    ? $painScaleData['nrs']['nilai'] ?? '0'
                    : ($selectedScale == 'flacc'
                        ? $painScaleData['flacc']['total'] ?? '0'
                        : ($selectedScale == 'cries'
                            ? $painScaleData['cries']['total'] ?? '0'
                            : $ctkp->nilai_skala_vas ?? '0')) }}
            </td>
        </tr>
        <tr>
            <th>Kesimpulan Nyeri</th>
            <td>
                <div class="kesimpulan-box">
                    {{ $selectedScale == 'nrs'
                        ? $painScaleData['nrs']['kategori'] ?? 'Nyeri Ringan'
                        : ($selectedScale == 'flacc'
                            ? $painScaleData['flacc']['kategori'] ?? 'NYERI RINGAN'
                            : ($selectedScale == 'cries'
                                ? $painScaleData['cries']['kategori'] ?? 'NYERI RINGAN'
                                : $ctkp->kesimpulan_nyeri ?? 'Nyeri Ringan')) }}
                </div>
            </td>
        </tr>
    </table>

    {{-- Skala Pada Pasien (Bromage/Steward/Aldrete/PADDS) --}}
    @if (!empty($selectedScale))
        <div style="margin-top:8px;"></div>
        <p class="subtitle">Skala Pada Pasien</p>

        @if ($selectedScale == 'bromage')
            <p style="margin: 5px 0;"><strong>Penilaian Bromage Score (SAB/Subarachnoid Block - Anak)</strong></p>
            <table class="data-table">
                <thead>
                    <tr>
                        <th width="35%">Score Pasca Anestesi dan Sedasi</th>
                        <th width="8%">Score</th>
                        <th width="15%">Jam Pasca Anestesi</th>
                        <th width="7%">15'</th>
                        <th width="7%">30'</th>
                        <th width="7%">45'</th>
                        <th width="7%">1 jam</th>
                        <th width="7%">2 jam</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Gerakan penuh dari tungkai</td>
                        <td style="text-align: center;">0</td>
                        <td>{{ $bromageData['time_inputs']['gerakan_penuh'] ?? '-' }}</td>
                        <td style="text-align: center;">
                            {{ isset($bromageData['time_observations']['time_15']['selected_option']) && stripos($bromageData['time_observations']['time_15']['selected_option'], 'gerakan_penuh') !== false ? '✓' : '' }}
                        </td>
                        <td style="text-align: center;">
                            {{ isset($bromageData['time_observations']['time_30']['selected_option']) && stripos($bromageData['time_observations']['time_30']['selected_option'], 'gerakan_penuh') !== false ? '✓' : '' }}
                        </td>
                        <td style="text-align: center;">
                            {{ isset($bromageData['time_observations']['time_45']['selected_option']) && stripos($bromageData['time_observations']['time_45']['selected_option'], 'gerakan_penuh') !== false ? '✓' : '' }}
                        </td>
                        <td style="text-align: center;">
                            {{ isset($bromageData['time_observations']['time_60']['selected_option']) && stripos($bromageData['time_observations']['time_60']['selected_option'], 'gerakan_penuh') !== false ? '✓' : '' }}
                        </td>
                        <td style="text-align: center;">
                            {{ isset($bromageData['time_observations']['time_120']['selected_option']) && stripos($bromageData['time_observations']['time_120']['selected_option'], 'gerakan_penuh') !== false ? '✓' : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td>Tak mampu ekstensi tungkai</td>
                        <td style="text-align: center;">1</td>
                        <td>{{ $bromageData['time_inputs']['tak_ekstensi'] ?? '-' }}</td>
                        <td style="text-align: center;">
                            {{ isset($bromageData['time_observations']['time_15']['selected_option']) && stripos($bromageData['time_observations']['time_15']['selected_option'], 'tak_ekstensi') !== false ? '✓' : '' }}
                        </td>
                        <td style="text-align: center;">
                            {{ isset($bromageData['time_observations']['time_30']['selected_option']) && stripos($bromageData['time_observations']['time_30']['selected_option'], 'tak_ekstensi') !== false ? '✓' : '' }}
                        </td>
                        <td style="text-align: center;">
                            {{ isset($bromageData['time_observations']['time_45']['selected_option']) && stripos($bromageData['time_observations']['time_45']['selected_option'], 'tak_ekstensi') !== false ? '✓' : '' }}
                        </td>
                        <td style="text-align: center;">
                            {{ isset($bromageData['time_observations']['time_60']['selected_option']) && stripos($bromageData['time_observations']['time_60']['selected_option'], 'tak_ekstensi') !== false ? '✓' : '' }}
                        </td>
                        <td style="text-align: center;">
                            {{ isset($bromageData['time_observations']['time_120']['selected_option']) && stripos($bromageData['time_observations']['time_120']['selected_option'], 'tak_ekstensi') !== false ? '✓' : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td>Tak mampu fleksi lutut</td>
                        <td style="text-align: center;">2</td>
                        <td>{{ $bromageData['time_inputs']['tak_fleksi_lutut'] ?? '-' }}</td>
                        <td style="text-align: center;">
                            {{ isset($bromageData['time_observations']['time_15']['selected_option']) && stripos($bromageData['time_observations']['time_15']['selected_option'], 'tak_fleksi_lutut') !== false ? '✓' : '' }}
                        </td>
                        <td style="text-align: center;">
                            {{ isset($bromageData['time_observations']['time_30']['selected_option']) && stripos($bromageData['time_observations']['time_30']['selected_option'], 'tak_fleksi_lutut') !== false ? '✓' : '' }}
                        </td>
                        <td style="text-align: center;">
                            {{ isset($bromageData['time_observations']['time_45']['selected_option']) && stripos($bromageData['time_observations']['time_45']['selected_option'], 'tak_fleksi_lutut') !== false ? '✓' : '' }}
                        </td>
                        <td style="text-align: center;">
                            {{ isset($bromageData['time_observations']['time_60']['selected_option']) && stripos($bromageData['time_observations']['time_60']['selected_option'], 'tak_fleksi_lutut') !== false ? '✓' : '' }}
                        </td>
                        <td style="text-align: center;">
                            {{ isset($bromageData['time_observations']['time_120']['selected_option']) && stripos($bromageData['time_observations']['time_120']['selected_option'], 'tak_fleksi_lutut') !== false ? '✓' : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td>Tak mampu fleksi pergelangan kaki</td>
                        <td style="text-align: center;">3</td>
                        <td>{{ $bromageData['time_inputs']['tak_fleksi_pergelangan'] ?? '-' }}</td>
                        <td style="text-align: center;">
                            {{ isset($bromageData['time_observations']['time_15']['selected_option']) && stripos($bromageData['time_observations']['time_15']['selected_option'], 'tak_fleksi_pergelangan') !== false ? '✓' : '' }}
                        </td>
                        <td style="text-align: center;">
                            {{ isset($bromageData['time_observations']['time_30']['selected_option']) && stripos($bromageData['time_observations']['time_30']['selected_option'], 'tak_fleksi_pergelangan') !== false ? '✓' : '' }}
                        </td>
                        <td style="text-align: center;">
                            {{ isset($bromageData['time_observations']['time_45']['selected_option']) && stripos($bromageData['time_observations']['time_45']['selected_option'], 'tak_fleksi_pergelangan') !== false ? '✓' : '' }}
                        </td>
                        <td style="text-align: center;">
                            {{ isset($bromageData['time_observations']['time_60']['selected_option']) && stripos($bromageData['time_observations']['time_60']['selected_option'], 'tak_fleksi_pergelangan') !== false ? '✓' : '' }}
                        </td>
                        <td style="text-align: center;">
                            {{ isset($bromageData['time_observations']['time_120']['selected_option']) && stripos($bromageData['time_observations']['time_120']['selected_option'], 'tak_fleksi_pergelangan') !== false ? '✓' : '' }}
                        </td>
                    </tr>
                    <tr style="background-color: #e3f2fd;">
                        <td colspan="3"><strong>TOTAL SCORE</strong></td>
                        <td colspan="5">
                            <strong>{{ $bromageData['total_score'] ?? '0' }}</strong> - ✅
                            Pasien BOLEH dipindah ke ruang perawatan
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3"><strong>Jam Pindah Ruang Perawatan</strong></td>
                        <td colspan="5">{{ $bromageData['jam_pindah'] ?? '-' }}</td>
                    </tr>
                </tbody>
            </table>
        @endif
    @endif

    {{-- Data lainnya di Section 6 --}}
    <table class="data-table" style="margin-top:8px">
        <tr>
            <th style="width: 30%;">Keluar Kamar Pulih Jam</th>
            <td style="width: 70%;">{{ $ctkp->jam_keluar ? date('H:i', strtotime($ctkp->jam_keluar)) : '-' }}</td>
        </tr>
        <tr>
            <th>Nilai Skala Nyeri VAS</th>
            <td>{{ $ctkp->nilai_skala_vas ?? '-' }}</td>
        </tr>
        <tr>
            <th>Lanjut Ke Ruang</th>
            <td>{{ $ctkp->lanjut_ruang ?? '-' }}</td>
        </tr>
        <tr>
            <th>Catatan Ruang Pemulihan</th>
            <td>{{ $ctkp->catatan_pemulihan ?? '-' }}</td>
        </tr>
    </table>

    {{-- 7. Instruksi Pasca Bedah (IPB) --}}
    <div class="section-title" style="margin-top:10px">7. Instruksi Pasca Bedah (IPB)</div>
    <table class="data-table">
        <tr>
            <th style="width: 30%;">Bila Kesakitan</th>
            <td style="width: 70%;">{{ $ipb->bila_kesakitan ?? '-' }}</td>
        </tr>
        <tr>
            <th>Bila Mual/Muntah</th>
            <td>{{ $ipb->bila_mual_muntah ?? '-' }}</td>
        </tr>
        <tr>
            <th>Antibiotika</th>
            <td>{{ $ipb->antibiotika ?? '-' }}</td>
        </tr>
        <tr>
            <th>Obat-Obatan Lain</th>
            <td>{{ $ipb->obat_lain ?? '-' }}</td>
        </tr>
        <tr>
            <th>Cairan Infus</th>
            <td>{{ $ipb->cairan_infus ?? '-' }}</td>
        </tr>
        <tr>
            <th>Minum</th>
            <td>{{ $ipb->minum ?? '-' }}</td>
        </tr>
        <tr>
            <th>Pemantauan Tanda Vital Setiap</th>
            <td>{{ $ipb->pemantauan_tanda_vital ?? '-' }}</td>
        </tr>
        <tr>
            <th>Selama Berapa Jam Pemantauan Dilakukan</th>
            <td>{{ $ipb->durasi_pemantauan ?? '-' }}</td>
        </tr>
        <tr>
            <th>E-Signature Dokter</th>
            <td>{{ $ipb->dokter_edukasi ?? '-' }}</td>
        </tr>
        <tr>
            <th>Lain-Lain</th>
            <td>{{ $ipb->lain_lain ?? '-' }}</td>
        </tr>
        <tr>
            <th>HardCopy Form Perlengkapan</th>
            <td>
                @if ($ipb->hardcopyform)
                    <a href="{{ asset('storage/' . $ipb->hardcopyform) }}" target="_blank">Lihat Dokumen</a>
                @else
                    Tidak ada file terlampir.
                @endif
            </td>
        </tr>
    </table>
    {{-- ======================================================= --}}
    {{-- TANDA TANGAN --}}
    {{-- ======================================================= --}}
    <div class="ttd-container">
        <table class="no-border" style="width: 100%;">
            <tr class="no-border">
                {{-- Kolom Kosong untuk Jarak --}}
                <td style="width: 50%; border: none;"></td>

                {{-- TTD --}}
                <td class="ttd-cell" style="width: 50%; text-align: center; border: none;">
                    Dokter<br>,
                </td>
            </tr>
            <tr class="no-border">
                {{-- Kolom Kosong untuk Jarak --}}
                <td style="width: 50%; border: none;"></td>

                <td class="ttd-cell" style="padding-top: 60px; border: none;">
                    ( {{ $namaCreator ?? '_____________________' }} )
                </td>
            </tr>
        </table>
    </div>

    <script>
        // --- 1. Data PSAS (Monitoring Selama Anestesi dan Sedasi) ---
        const monitoringDataPSAS = @json($okPraInduksi->okPraInduksiPsas->all_monitoring_data ?? '[]');
        let parsedMonitoringData = [];
        try {
            parsedMonitoringData = JSON.parse(monitoringDataPSAS);
            if (!Array.isArray(parsedMonitoringData)) {
                parsedMonitoringData = [];
            }
        } catch (error) {
            console.error('Error parsing PSAS JSON data:', error);
        }

        const psasLabels = parsedMonitoringData.map(item => item.time || '');
        const psasSistoleData = parsedMonitoringData.map(item => item.sistole || 0);
        const psasDiastoleData = parsedMonitoringData.map(item => item.diastole || 0);
        const psasNadiData = parsedMonitoringData.map(item => item.nadi || 0);
        const psasNafasData = parsedMonitoringData.map(item => item.nafas || 0);
        const psasSpo2Data = parsedMonitoringData.map(item => item.spo2 || 0);

        // --- 2. Data CTKP (Observasi Pasca Anestesi) ---
        const observasiDataCKP = @json($okPraInduksi->okPraInduksiCtkp->all_observasi_data_ckp ?? '[]');
        let parsedObservasiData = [];
        try {
            parsedObservasiData = JSON.parse(observasiDataCKP);
            if (!Array.isArray(parsedObservasiData)) {
                parsedObservasiData = [];
            }
        } catch (error) {
            console.error('Error parsing CTKP JSON data:', error);
        }

        const ctkpLabels = parsedObservasiData.map(item => item.time || '');
        const ctkpTekananDarahData = parsedObservasiData.map(item => item.tekananDarah || '0/0');
        const ctkpNadiData = parsedObservasiData.map(item => item.nadi || 0);
        const ctkpNafasData = parsedObservasiData.map(item => item.nafas || 0);
        const ctkpSpo2Data = parsedObservasiData.map(item => item.spo2 || 0);
        const ctkpTvsData = parsedObservasiData.map(item => item.tvs || 0);


        // --- 3. Fungsi Inisialisasi Grafik & Print ---

        function initializeChartsAndPrint() {
            // A. Inisialisasi PSAS Chart (Section 5)
            const psasChartElement = document.getElementById('vitalSignsChartPSAS');
            if (psasChartElement && psasLabels.length > 0) {
                const ctxPsas = psasChartElement.getContext('2d');
                new Chart(ctxPsas, {
                    type: 'line',
                    data: {
                        labels: psasLabels,
                        datasets: [{
                                label: 'Sistole',
                                data: psasSistoleData,
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 2,
                                fill: false,
                                tension: 0.4
                            },
                            {
                                label: 'Diastole',
                                data: psasDiastoleData,
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 2,
                                fill: false,
                                tension: 0.4
                            },
                            {
                                label: 'Nadi',
                                data: psasNadiData,
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 2,
                                fill: false,
                                tension: 0.4
                            },
                            {
                                label: 'Nafas',
                                data: psasNafasData,
                                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                                borderColor: 'rgba(153, 102, 255, 1)',
                                borderWidth: 2,
                                fill: false,
                                tension: 0.4
                            },
                            {
                                label: 'SpO₂',
                                data: psasSpo2Data,
                                backgroundColor: 'rgba(255, 159, 64, 0.2)',
                                borderColor: 'rgba(255, 159, 64, 1)',
                                borderWidth: 2,
                                fill: false,
                                tension: 0.4
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        scales: {
                            y: {
                                beginAtZero: false,
                                min: 0,
                                max: 250,
                                ticks: {
                                    stepSize: 50
                                }
                            }
                        }
                    }
                });
            }

            // B. Inisialisasi CTKP Chart (Section 6)
            const ctkpChartElement = document.getElementById('recoveryVitalChartCKP');
            if (ctkpChartElement && ctkpLabels.length > 0) {
                const ctxCtkp = ctkpChartElement.getContext('2d');
                new Chart(ctxCtkp, {
                    type: 'line',
                    data: {
                        labels: ctkpLabels,
                        datasets: [{
                                label: 'Sistole',
                                data: ctkpTekananDarahData.map(td => parseInt(td.split('/')[0]) || 0),
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 2,
                                fill: false,
                                tension: 0.4
                            },
                            {
                                label: 'Diastole',
                                data: ctkpTekananDarahData.map(td => parseInt(td.split('/')[1]) || 0),
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 2,
                                fill: false,
                                tension: 0.4
                            },
                            {
                                label: 'Nadi',
                                data: ctkpNadiData,
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 2,
                                fill: false,
                                tension: 0.4
                            },
                            {
                                label: 'Nafas',
                                data: ctkpNafasData,
                                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                                borderColor: 'rgba(153, 102, 255, 1)',
                                borderWidth: 2,
                                fill: false,
                                tension: 0.4
                            },
                            {
                                label: 'SpO₂',
                                data: ctkpSpo2Data,
                                backgroundColor: 'rgba(255, 159, 64, 0.2)',
                                borderColor: 'rgba(255, 159, 64, 1)',
                                borderWidth: 2,
                                fill: false,
                                tension: 0.4
                            },
                            {
                                label: 'TVS',
                                data: ctkpTvsData,
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 2,
                                fill: false,
                                tension: 0.4
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        scales: {
                            y: {
                                beginAtZero: false,
                                min: 0,
                                max: 250,
                                ticks: {
                                    stepSize: 50
                                }
                            }
                        }
                    }
                });
            }

            // C. Panggil Print setelah grafik memiliki waktu untuk dirender
            setTimeout(function() {
                window.print();
            }, 500);
        }

        // Panggil inisialisasi ketika DOM siap
        document.addEventListener('DOMContentLoaded', initializeChartsAndPrint);
    </script>

</body>

</html>
