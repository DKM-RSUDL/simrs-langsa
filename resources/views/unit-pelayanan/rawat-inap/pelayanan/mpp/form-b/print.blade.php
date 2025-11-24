<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Form B - Catatan Implementasi MPP</title>
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
        }

        .title-section {
            display: table-cell;
            vertical-align: top;
            width: 45%;
        }

        .patient-info-cell {
            display: table-cell;
            vertical-align: top;
            width: 30%;
        }

        .hospital-info {
            text-align: left;
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

        .title-section {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            padding: 8px 10px 0 10px;
        }

        .patient-info-cell {
            text-align: right;
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
        }

        .table th,
        .table td {
            border: 1px solid #000;
            padding: 4px;
            vertical-align: top;
            font-size: 9pt;
            text-align: left;
        }

        .table th.datetime-col,
        .table td.datetime-col {
            width: 120px;
            text-align: center;
            vertical-align: middle;
        }

        .table th.checkbox-col,
        .table td.checkbox-col {
            width: 30px;
            text-align: center;
            vertical-align: middle;
        }

        .table .checkbox-col input[type="checkbox"] {
            margin: 0;
            vertical-align: middle;
            width: 12px;
            height: 12px;
        }

        .section-header {
            background-color: #e9ecef;
            font-weight: bold;
            text-align: center;
            font-size: 10pt;
        }

        .rencana-row {
            background-color: #fff9f0;
        }

        .monitoring-row {
            background-color: #f0fff4;
        }

        .koordinasi-row {
            background-color: #f0f8ff;
        }

        .advokasi-row {
            background-color: #fff0f5;
        }

        .hasil-row {
            background-color: #f8f9fa;
        }

        .terminasi-row {
            background-color: #fdf2e9;
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

        .text-content {
            font-size: 8pt;
            line-height: 1.4;
            min-height: 40px;
            padding: 5px;
            background-color: #fafafa;
            border-radius: 3px;
            margin-top: 5px;
        }

        .signature {
            display: flex;
            justify-content: space-between;
            margin-top: 25px;
            width: 100%;
        }

        .signature div {
            text-align: center;
            width: 48%;
        }

        .signature p {
            margin: 0;
            font-size: 9pt;
        }

        .signature .underline {
            border-bottom: 1px solid #000;
            width: 150px;
            margin: 35px auto 3px;
        }

        .page-break {
            page-break-before: always;
        }

        .page-break-after {
            page-break-after: always;
        }

        /* Styles for staff table */
        .staff-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 9pt;
        }

        .staff-table th,
        .staff-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        .staff-table th {
            background-color: #e9ecef;
            font-weight: bold;
            text-align: center;
        }

        .staff-table .ppa-col {
            width: 25%;
        }

        .staff-table .nama-col {
            width: 50%;
        }

        .staff-table .ttd-col {
            width: 25%;
            text-align: center;
        }
    </style>
</head>

<body>
    <!-- PAGE 1: HEADER + SECTION 1-4 -->
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
                FORM B<br>
                CATATAN IMPLEMENTASI MPP<br>
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

    <!-- Doctor and Staff Information -->
    <div class="doctor-info">
        <table>
            <tr>
                <td style="width: 15%;"><strong>DPJP Utama:</strong></td>
                <td style="width: 35%;">{{ $dpjpUtama ? $dpjpUtama->nama : '-' }}</td>
                <td style="width: 15%;"><strong>Dokter Tambahan:</strong></td>
                <td style="width: 35%;">
                    @if ($dokterTambahan && count($dokterTambahan) > 0)
                        @foreach ($dokterTambahan as $index => $dokter)
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

    <!-- Main MPP Table - Section 1-4 -->
    <table class="table">
        <thead>
            <tr>
                <th class="datetime-col">TANGGAL DAN JAM</th>
                <th>CATATAN</th>
            </tr>
        </thead>
        <tbody>
            <!-- Section 1: Rencana Pelayanan Pasien -->
            <tr class="rencana-row">
                <td class="datetime-col">
                    <div class="datetime-display">
                        @if ($mppData->rencana_date)
                            {{ \Carbon\Carbon::parse($mppData->rencana_date)->format('d-m-Y') }}<br>
                        @endif
                        @if ($mppData->rencana_time)
                            {{ \Carbon\Carbon::parse($mppData->rencana_time)->format('H:i') }}
                        @endif
                    </div>
                </td>
                <td>
                    <strong>1. Rencana Pelayanan Pasien</strong>
                    <div class="text-content">
                        {{ $mppData->rencana_pelayanan ?? '-' }}
                    </div>
                </td>
            </tr>

            <!-- Section 2: Monitoring Pelayanan/Asuhan Pasien -->
            <tr class="monitoring-row">
                <td class="datetime-col">
                    <div class="datetime-display">
                        @if ($mppData->monitoring_date)
                            {{ \Carbon\Carbon::parse($mppData->monitoring_date)->format('d-m-Y') }}<br>
                        @endif
                        @if ($mppData->monitoring_time)
                            {{ \Carbon\Carbon::parse($mppData->monitoring_time)->format('H:i') }}
                        @endif
                    </div>
                </td>
                <td>
                    <strong>2. Monitoring Pelayanan/Asuhan Pasien Seluruh PPA</strong>
                    <br><small style="font-style: italic;">(Perkembangan, Kolaborasi, Verifikasi respon terhadap
                        intervensi yang diberikan, revisi rencana asuhan termasuk preferensi perubahan, transisi
                        pelayanan dan kendala pelayanan)</small>
                    <div class="text-content">
                        {{ $mppData->monitoring_pelayanan ?? '-' }}
                    </div>
                </td>
            </tr>

            <!-- Section 3: Koordinasi Komunikasi dan Kolaborasi -->
            <tr class="koordinasi-row">
                <td class="datetime-col">
                    <div class="datetime-display">
                        @if ($mppData->koordinasi_date)
                            {{ \Carbon\Carbon::parse($mppData->koordinasi_date)->format('d-m-Y') }}<br>
                        @endif
                        @if ($mppData->koordinasi_time)
                            {{ \Carbon\Carbon::parse($mppData->koordinasi_time)->format('H:i') }}
                        @endif
                    </div>
                </td>
                <td>
                    <strong>3. Koordinasi Komunikasi dan Kolaborasi</strong>
                    <br><br>
                    <div class="criteria-item">
                        <input type="checkbox" class="criteria-checkbox"
                            {{ $mppData->konsultasi_kolaborasi ? 'checked' : '' }} disabled>
                        <span class="criteria-label">Konsultasi/Kolaborasi</span>
                    </div>
                    <div class="criteria-item">
                        <input type="checkbox" class="criteria-checkbox"
                            {{ $mppData->second_opinion ? 'checked' : '' }} disabled>
                        <span class="criteria-label">Second Opinion</span>
                    </div>
                    <div class="criteria-item">
                        <input type="checkbox" class="criteria-checkbox" {{ $mppData->rawat_bersama ? 'checked' : '' }}
                            disabled>
                        <span class="criteria-label">Rawat Bersama/Alih Rawat</span>
                    </div>
                    <div class="criteria-item">
                        <input type="checkbox" class="criteria-checkbox"
                            {{ $mppData->komunikasi_edukasi ? 'checked' : '' }} disabled>
                        <span class="criteria-label">Komunikasi/Edukasi</span>
                    </div>
                    <div class="criteria-item">
                        <input type="checkbox" class="criteria-checkbox" {{ $mppData->rujukan ? 'checked' : '' }}
                            disabled>
                        <span class="criteria-label">Rujukan</span>
                    </div>
                </td>
            </tr>

            <!-- Section 4: Advokasi Pelayanan Pasien -->
            <tr class="advokasi-row">
                <td class="datetime-col">
                    <div class="datetime-display">
                        @if ($mppData->advokasi_date)
                            {{ \Carbon\Carbon::parse($mppData->advokasi_date)->format('d-m-Y') }}<br>
                        @endif
                        @if ($mppData->advokasi_time)
                            {{ \Carbon\Carbon::parse($mppData->advokasi_time)->format('H:i') }}
                        @endif
                    </div>
                </td>
                <td>
                    <strong>4. Advokasi Pelayanan Pasien</strong>
                    <br><br>
                    <div class="criteria-item">
                        <input type="checkbox" class="criteria-checkbox" {{ $mppData->diskusi_ppa ? 'checked' : '' }}
                            disabled>
                        <span class="criteria-label">Diskusi dengan PPA staf lain tentang kebutuhan pasien</span>
                    </div>
                    <div class="criteria-item">
                        <input type="checkbox" class="criteria-checkbox"
                            {{ $mppData->fasilitasi_akses ? 'checked' : '' }} disabled>
                        <span class="criteria-label">Memfasilitasi akses ke pelayanan sesuai kebutuhan pasien
                            berkoordinasi dengan PPA dan pemangku kepentingan</span>
                    </div>
                    <div class="criteria-item">
                        <input type="checkbox" class="criteria-checkbox"
                            {{ $mppData->kemandirian_keputusan ? 'checked' : '' }} disabled>
                        <span class="criteria-label">Meningkatkan kemandirian untuk menentukan pilihan/pengambilan
                            keputusan</span>
                    </div>
                    <div class="criteria-item">
                        <input type="checkbox" class="criteria-checkbox"
                            {{ $mppData->pencegahan_disparitas ? 'checked' : '' }} disabled>
                        <span class="criteria-label">Mengenali, mencegah, menghindari disparitas untuk mengakses mutu
                            dan hasil pelayanan terkait dengan ras, etnik, agama, gender, budaya, status pernikahan,
                            usia, politik, disabilitas fisik mental-kognitif</span>
                    </div>
                    <div class="criteria-item">
                        <input type="checkbox" class="criteria-checkbox"
                            {{ $mppData->pemenuhan_kebutuhan ? 'checked' : '' }} disabled>
                        <span class="criteria-label">Pemenuhan kebutuhan pelayanan yang berkembang/bertambah karena
                            perubahan kondisi</span>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- PAGE 2: SECTION 5-6 dengan Header ulang -->
    <div class="page-break">

        <!-- Table Section 5-6 -->
        <table class="table">
            <thead>
                <tr>
                    <th class="datetime-col">TANGGAL DAN JAM</th>
                    <th>CATATAN</th>
                </tr>
            </thead>
            <tbody>
                <!-- Section 5: Hasil Pelayanan -->
                <tr class="hasil-row">
                    <td class="datetime-col">
                        <div class="datetime-display">
                            @if ($mppData->hasil_date)
                                {{ \Carbon\Carbon::parse($mppData->hasil_date)->format('d-m-Y') }}<br>
                            @endif
                            @if ($mppData->hasil_time)
                                {{ \Carbon\Carbon::parse($mppData->hasil_time)->format('H:i') }}
                            @endif
                        </div>
                    </td>
                    <td>
                        <strong>5. Hasil Pelayanan</strong>
                        <div class="text-content">
                            {{ $mppData->hasil_pelayanan ?? '-' }}
                        </div>
                    </td>
                </tr>

                <!-- Section 6: Terminasi Manajemen Pelayanan -->
                <tr class="terminasi-row">
                    <td class="datetime-col">
                        <div class="datetime-display">
                            @if ($mppData->terminasi_date)
                                {{ \Carbon\Carbon::parse($mppData->terminasi_date)->format('d-m-Y') }}<br>
                            @endif
                            @if ($mppData->terminasi_time)
                                {{ \Carbon\Carbon::parse($mppData->terminasi_time)->format('H:i') }}
                            @endif
                        </div>
                    </td>
                    <td>
                        <strong>6. Terminasi Manajemen Pelayanan Pasien, Catatan kepuasan pasien/keluarga dengan
                            MPP</strong>
                        <br><br>
                        <div style="display: flex; flex-wrap: wrap; gap: 15px;">
                            <div style="flex: 1; min-width: 45%;">
                                <div class="criteria-item">
                                    <input type="checkbox" class="criteria-checkbox"
                                        {{ $mppData->puas ? 'checked' : '' }} disabled>
                                    <span class="criteria-label">Puas</span>
                                </div>
                                <div class="criteria-item">
                                    <input type="checkbox" class="criteria-checkbox"
                                        {{ $mppData->tidak_puas ? 'checked' : '' }} disabled>
                                    <span class="criteria-label">Tidak Puas</span>
                                </div>
                                <div class="criteria-item">
                                    <input type="checkbox" class="criteria-checkbox"
                                        {{ $mppData->abstain ? 'checked' : '' }} disabled>
                                    <span class="criteria-label">Abstain</span>
                                </div>
                                <div class="criteria-item">
                                    <input type="checkbox" class="criteria-checkbox"
                                        {{ $mppData->konflik_komplain ? 'checked' : '' }} disabled>
                                    <span class="criteria-label">Konflik/Komplain</span>
                                </div>
                            </div>
                            <div style="flex: 1; min-width: 45%;">
                                <div class="criteria-item">
                                    <input type="checkbox" class="criteria-checkbox"
                                        {{ $mppData->keuangan ? 'checked' : '' }} disabled>
                                    <span class="criteria-label">Masalah Keuangan</span>
                                </div>
                                <div class="criteria-item">
                                    <input type="checkbox" class="criteria-checkbox"
                                        {{ $mppData->pulang_sembuh ? 'checked' : '' }} disabled>
                                    <span class="criteria-label">Pasien Pulang Sembuh</span>
                                </div>
                                <div class="criteria-item">
                                    <input type="checkbox" class="criteria-checkbox"
                                        {{ $mppData->pulang_perbaikan ? 'checked' : '' }} disabled>
                                    <span class="criteria-label">Pasien Pulang Perbaikan</span>
                                </div>
                                <div class="criteria-item">
                                    <input type="checkbox" class="criteria-checkbox"
                                        {{ $mppData->rujuk ? 'checked' : '' }} disabled>
                                    <span class="criteria-label">Rujuk</span>
                                </div>
                                <div class="criteria-item">
                                    <input type="checkbox" class="criteria-checkbox"
                                        {{ $mppData->meninggal ? 'checked' : '' }} disabled>
                                    <span class="criteria-label">Meninggal</span>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Tabel Daftar Tenaga Medis -->
        <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
    <thead>
        <tr>
            <th style="border: 1px solid #000; padding: 4px; text-align: left;">PPA</th>
            <th style="border: 1px solid #000; padding: 4px; text-align: left;">NAMA</th>
            <th style="border: 1px solid #000; padding: 4px; text-align: left;">TANDA TANGAN</th>
        </tr>
    </thead>

    <tbody>

        <!-- DPJP Utama -->
        <tr style="height: 28px;">
            <td style="border: 1px solid #000; padding: 3px;"><strong>DPJP Utama</strong></td>
            <td style="border: 1px solid #000; padding: 3px;">{{ $dpjpUtama ? $dpjpUtama->nama : '-' }}</td>
            <td style="border: 1px solid #000; padding: 3px; height: 35px;"></td>
        </tr>

        <!-- Dokter Tambahan -->
        @if ($dokterTambahan && count($dokterTambahan) > 0)
            @foreach ($dokterTambahan as $index => $dokter)
                <tr style="height: 26px;">
                    <td style="border: 1px solid #000; padding: 3px;">
                        <strong>Dokter Tambahan {{ $index+1 }}</strong>
                    </td>
                    <td style="border: 1px solid #000; padding: 3px;">{{ $dokter->nama }}</td>
                    <td style="border: 1px solid #000; padding: 3px; height: 35px;"></td>
                </tr>
            @endforeach
        @else
            <tr style="height: 26px;">
                <td style="border: 1px solid #000; padding: 3px;"><strong>Dokter Tambahan</strong></td>
                <td style="border: 1px solid #000; padding: 3px;">-</td>
                <td style="border: 1px solid #000; padding: 3px; height: 35px;"></td>
            </tr>
        @endif

        <!-- Petugas Terkait -->
        @if ($petugasTerkait && count($petugasTerkait) > 0)
            @foreach ($petugasTerkait as $index => $petugas)
                <tr style="height: 26px;">
                    <td style="border: 1px solid #000; padding: 3px;">
                        <strong>Petugas Terkait {{ $index+1 }}</strong>
                    </td>
                    <td style="border: 1px solid #000; padding: 3px;">
                        {{ trim("$petugas->gelar_depan $petugas->nama $petugas->gelar_belakang") }}
                    </td>
                    <td style="border: 1px solid #000; padding: 3px; height: 35px;"></td>
                </tr>
            @endforeach
        @else
            <tr style="height: 26px;">
                <td style="border: 1px solid #000; padding: 3px;"><strong>Petugas Terkait</strong></td>
                <td style="border: 1px solid #000; padding: 3px;">-</td>
                <td style="border: 1px solid #000; padding: 3px; height: 35px;"></td>
            </tr>
        @endif

    </tbody>
</table>


        <!-- Signature pada halaman 2 -->
        <div style="text-align: right; margin-top: 30px; width: 100%;">
            <div style="display: inline-block; text-align: center; width: 250px;">
                <p style="margin: 0; font-size: 9pt;">Langsa, {{ date('d/m/Y') }}</p>
                <p style="margin: 5px 0 0 0; font-size: 9pt; font-weight: bold;">Manajer Pelayanan Pasien</p>
                <div style="border-bottom: 1px solid #000; width: 200px; margin: 50px auto 5px;"></div>
                <p style="margin: 0; font-size: 9pt; font-weight: bold;">
                    {{ $userCreate ? $userCreate->name : '...............................' }}
                </p>
                <p style="margin: 2px 0 0 0; font-size: 9pt;">NIP. ...............................</p>
            </div>
        </div>
    </div>

</body>

</html>
