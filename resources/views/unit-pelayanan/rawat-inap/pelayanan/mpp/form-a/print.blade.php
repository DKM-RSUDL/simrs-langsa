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

        .screening-row {
            background-color: #fff9f0;
        }

        .assessment-row {
            background-color: #f0fff4;
        }

        .identification-row {
            background-color: #f0f8ff;
        }

        .planning-row {
            background-color: #fff0f5;
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
    </style>
</head>

<body>
    <!-- PAGE 1: HEADER + SECTION I & II -->
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
                    @if($dpjpTambahan && count($dpjpTambahan) > 0)
                        @foreach($dpjpTambahan as $index => $dokter)
                            {{ $index + 1 }}. {{ $dokter->nama }}@if(!$loop->last)<br>@endif
                        @endforeach
                    @else
                        -
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <!-- Main MPP Table - Section I & II -->
    <table class="table">
        <thead>
            <tr>
                <th class="datetime-col">TANGGAL DAN JAM</th>
                <th>CATATAN</th>
            </tr>
        </thead>
        <tbody>
            <!-- Section I: Identifikasi/Screening Pasien -->
            <tr class="section-header">
                <td colspan="2">I. IDENTIFIKASI/SCREENING PASIEN</td>
            </tr>

            <tr class="screening-row">
                <td class="datetime-col" rowspan="13">
                    <div class="datetime-display">
                        @if ($mppData->screening_date)
                            {{ \Carbon\Carbon::parse($mppData->screening_date)->format('d-m-Y') }}<br>
                        @endif
                        @if ($mppData->screening_time)
                            {{ \Carbon\Carbon::parse($mppData->screening_time)->format('H:i') }}
                        @endif
                    </div>
                </td>
                <td>
                    <div class="criteria-item">
                        <input type="checkbox" class="criteria-checkbox"
                            {{ $mppData->fungsi_kognitif ? 'checked' : '' }} disabled>
                        <span class="criteria-label">Fungsi kognitif rendah</span>
                    </div>
                </td>
            </tr>

            <tr class="screening-row">
                <td>
                    <div class="criteria-item">
                        <input type="checkbox" class="criteria-checkbox" {{ $mppData->risiko_tinggi ? 'checked' : '' }}
                            disabled>
                        <span class="criteria-label">Risiko tinggi</span>
                    </div>
                </td>
            </tr>

            <tr class="screening-row">
                <td>
                    <div class="criteria-item">
                        <input type="checkbox" class="criteria-checkbox"
                            {{ $mppData->potensi_komplain ? 'checked' : '' }} disabled>
                        <span class="criteria-label">Potensi komplain tinggi</span>
                    </div>
                </td>
            </tr>

            <tr class="screening-row">
                <td>
                    <div class="criteria-item">
                        <input type="checkbox" class="criteria-checkbox"
                            {{ $mppData->riwayat_kronis ? 'checked' : '' }} disabled>
                        <span class="criteria-label">Kasus dengan riwayat kronis, katastropik, terminal</span>
                    </div>
                </td>
            </tr>

            <tr class="screening-row">
                <td>
                    <div class="criteria-item">
                        <input type="checkbox" class="criteria-checkbox"
                            {{ $mppData->status_fungsional ? 'checked' : '' }} disabled>
                        <span class="criteria-label">Status fungsional rendah, kebutuhan ADL tinggi</span>
                    </div>
                </td>
            </tr>

            <tr class="screening-row">
                <td>
                    <div class="criteria-item">
                        <input type="checkbox" class="criteria-checkbox"
                            {{ $mppData->peralatan_medis ? 'checked' : '' }} disabled>
                        <span class="criteria-label">Riwayat penggunaan peralatan medis di masa lalu</span>
                    </div>
                </td>
            </tr>

            <tr class="screening-row">
                <td>
                    <div class="criteria-item">
                        <input type="checkbox" class="criteria-checkbox"
                            {{ $mppData->gangguan_mental ? 'checked' : '' }} disabled>
                        <span class="criteria-label">Riwayat gangguan mental, krisis keluarga, isu sosial (terlantar,
                            tinggal sendiri, narkoba)</span>
                    </div>
                </td>
            </tr>

            <tr class="screening-row">
                <td>
                    <div class="criteria-item">
                        <input type="checkbox" class="criteria-checkbox" {{ $mppData->sering_igd ? 'checked' : '' }}
                            disabled>
                        <span class="criteria-label">Sering masuk IGD, readmisi RS</span>
                    </div>
                </td>
            </tr>

            <tr class="screening-row">
                <td>
                    <div class="criteria-item">
                        <input type="checkbox" class="criteria-checkbox"
                            {{ $mppData->perkiraan_asuhan ? 'checked' : '' }} disabled>
                        <span class="criteria-label">Perkiraan asuhan dengan biaya tinggi</span>
                    </div>
                </td>
            </tr>

            <tr class="screening-row">
                <td>
                    <div class="criteria-item">
                        <input type="checkbox" class="criteria-checkbox"
                            {{ $mppData->sistem_pembiayaan ? 'checked' : '' }} disabled>
                        <span class="criteria-label">Kemungkinan sistem pembiayaan komplek, masalah finansial</span>
                    </div>
                </td>
            </tr>

            <tr class="screening-row">
                <td>
                    <div class="criteria-item">
                        <input type="checkbox" class="criteria-checkbox"
                            {{ $mppData->length_of_stay ? 'checked' : '' }} disabled>
                        <span class="criteria-label">Kasus yang melebihi rata-rata length of stay</span>
                    </div>
                </td>
            </tr>

            <tr class="screening-row">
                <td>
                    <div class="criteria-item">
                        <input type="checkbox" class="criteria-checkbox"
                            {{ $mppData->rencana_pemulangan ? 'checked' : '' }} disabled>
                        <span class="criteria-label">Kasus yang rencana pemulangannya berisiko/membutuhkan kontinuitas
                            pelayanan</span>
                    </div>
                </td>
            </tr>

            <tr class="screening-row">
                <td>
                    <div class="criteria-item">
                        <input type="checkbox" class="criteria-checkbox" {{ $mppData->lain_lain ? 'checked' : '' }}
                            disabled>
                        <span class="criteria-label">Lain-lain</span>
                    </div>
                </td>
            </tr>

            <!-- Section II: Assessment -->
            <tr class="section-header">
                <td colspan="2">II. ASSESSMENT</td>
            </tr>

            <tr class="assessment-row">
                <td class="datetime-col" rowspan="11">
                    <div class="datetime-display">
                        @if ($mppData->assessment_date)
                            {{ \Carbon\Carbon::parse($mppData->assessment_date)->format('d-m-Y') }}<br>
                        @endif
                        @if ($mppData->assessment_time)
                            {{ \Carbon\Carbon::parse($mppData->assessment_time)->format('H:i') }}
                        @endif
                    </div>
                </td>
                <td>
                    <div class="criteria-item">
                        <input type="checkbox" class="criteria-checkbox"
                            {{ $mppData->fisik_fungsional ? 'checked' : '' }} disabled>
                        <span class="criteria-label">Fisik, Fungsional, Kognitif, Kemandirian</span>
                    </div>
                </td>
            </tr>

            <tr class="assessment-row">
                <td>
                    <div class="criteria-item">
                        <input type="checkbox" class="criteria-checkbox"
                            {{ $mppData->riwayat_kesehatan ? 'checked' : '' }} disabled>
                        <span class="criteria-label">Riwayat Kesehatan</span>
                    </div>
                </td>
            </tr>

            <tr class="assessment-row">
                <td>
                    <div class="criteria-item">
                        <input type="checkbox" class="criteria-checkbox"
                            {{ $mppData->perilaku_psiko ? 'checked' : '' }} disabled>
                        <span class="criteria-label">Perilaku psiko-sosio-kultural</span>
                    </div>
                </td>
            </tr>

            <tr class="assessment-row">
                <td>
                    <div class="criteria-item">
                        <input type="checkbox" class="criteria-checkbox"
                            {{ $mppData->kesehatan_mental ? 'checked' : '' }} disabled>
                        <span class="criteria-label">Kesehatan mental</span>
                    </div>
                </td>
            </tr>

            <tr class="assessment-row">
                <td>
                    <div class="criteria-item">
                        <input type="checkbox" class="criteria-checkbox"
                            {{ $mppData->dukungan_keluarga ? 'checked' : '' }} disabled>
                        <span class="criteria-label">Tersedianya dukungan keluarga, kemampuan merawat dari pemberi
                            asuhan</span>
                    </div>
                </td>
            </tr>

            <tr class="assessment-row">
                <td>
                    <div class="criteria-item">
                        <input type="checkbox" class="criteria-checkbox"
                            {{ $mppData->finansial_asuransi ? 'checked' : '' }} disabled>
                        <span class="criteria-label">Finansial/status asuransi</span>
                    </div>
                </td>
            </tr>

            <tr class="assessment-row">
                <td>
                    <div class="criteria-item">
                        <input type="checkbox" class="criteria-checkbox"
                            {{ $mppData->riwayat_obat ? 'checked' : '' }} disabled>
                        <span class="criteria-label">Riwayat penggunaan obat, alternatif</span>
                    </div>
                </td>
            </tr>

            <tr class="assessment-row">
                <td>
                    <div class="criteria-item">
                        <input type="checkbox" class="criteria-checkbox"
                            {{ $mppData->trauma_kekerasan ? 'checked' : '' }} disabled>
                        <span class="criteria-label">Riwayat/trauma/kekerasan</span>
                    </div>
                </td>
            </tr>

            <tr class="assessment-row">
                <td>
                    <div class="criteria-item">
                        <input type="checkbox" class="criteria-checkbox"
                            {{ $mppData->health_literacy ? 'checked' : '' }} disabled>
                        <span class="criteria-label">Pemahaman tentang kesehatan (health literacy)</span>
                    </div>
                </td>
            </tr>

            <tr class="assessment-row">
                <td>
                    <div class="criteria-item">
                        <input type="checkbox" class="criteria-checkbox" {{ $mppData->aspek_legal ? 'checked' : '' }}
                            disabled>
                        <span class="criteria-label">Aspek legal</span>
                    </div>
                </td>
            </tr>

            <tr class="assessment-row">
                <td>
                    <div class="criteria-item">
                        <input type="checkbox" class="criteria-checkbox"
                            {{ $mppData->harapan_hasil ? 'checked' : '' }} disabled>
                        <span class="criteria-label">Harapan terhadap hasil asuhan, kemampuan untuk menerima
                            perubahan</span>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- PAGE 2: SECTION III & IV dengan Header ulang -->
    <div class="page-break">

        <!-- Table Section III & IV -->
        <table class="table">
            <thead>
                <tr>
                    <th class="datetime-col">TANGGAL DAN JAM</th>
                    <th>CATATAN</th>
                </tr>
            </thead>
            <tbody>
                <!-- Section III: Identifikasi Masalah -->
                <tr class="section-header">
                    <td colspan="2">III. IDENTIFIKASI MASALAH</td>
                </tr>

                <tr class="identification-row">
                    <td class="datetime-col" rowspan="8">
                        <div class="datetime-display">
                            @if ($mppData->identification_date)
                                {{ \Carbon\Carbon::parse($mppData->identification_date)->format('d-m-Y') }}<br>
                            @endif
                            @if ($mppData->identification_time)
                                {{ \Carbon\Carbon::parse($mppData->identification_time)->format('H:i') }}
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="criteria-item">
                            <input type="checkbox" class="criteria-checkbox"
                                {{ $mppData->tingkat_asuhan ? 'checked' : '' }} disabled>
                            <span class="criteria-label">Tingkat asuhan yang tidak sesuai dengan panduan, norma yang
                                digunakan</span>
                        </div>
                    </td>
                </tr>

                <tr class="identification-row">
                    <td>
                        <div class="criteria-item">
                            <input type="checkbox" class="criteria-checkbox"
                                {{ $mppData->over_under_utilization ? 'checked' : '' }} disabled>
                            <span class="criteria-label">Over/under utilization pelayanan dengan dasar panduan norma
                                yang
                                digunakan</span>
                        </div>
                    </td>
                </tr>

                <tr class="identification-row">
                    <td>
                        <div class="criteria-item">
                            <input type="checkbox" class="criteria-checkbox"
                                {{ $mppData->ketidak_patuhan ? 'checked' : '' }} disabled>
                            <span class="criteria-label">Ketidak patuhan pasien</span>
                        </div>
                    </td>
                </tr>

                <tr class="identification-row">
                    <td>
                        <div class="criteria-item">
                            <input type="checkbox" class="criteria-checkbox"
                                {{ $mppData->edukasi_kurang ? 'checked' : '' }} disabled>
                            <span class="criteria-label">Edukasi kurang memadai atau pemahamannya yang belum memadai
                                tentang proses penyakit, kondisi terkini dan daftar obat</span>
                        </div>
                    </td>
                </tr>

                <tr class="identification-row">
                    <td>
                        <div class="criteria-item">
                            <input type="checkbox" class="criteria-checkbox"
                                {{ $mppData->kurang_dukungan ? 'checked' : '' }} disabled>
                            <span class="criteria-label">Kurangnya dukungan keluarga, tidak ada keluarga</span>
                        </div>
                    </td>
                </tr>

                <tr class="identification-row">
                    <td>
                        <div class="criteria-item">
                            <input type="checkbox" class="criteria-checkbox"
                                {{ $mppData->penurunan_determinasi ? 'checked' : '' }} disabled>
                            <span class="criteria-label">Penurunan determinasi pasien (ketika tingkat
                                keparahan/komplikasi
                                meningkat)</span>
                        </div>
                    </td>
                </tr>

                <tr class="identification-row">
                    <td>
                        <div class="criteria-item">
                            <input type="checkbox" class="criteria-checkbox"
                                {{ $mppData->kendala_keuangan ? 'checked' : '' }} disabled>
                            <span class="criteria-label">Kendala keuangan ketika keparahan/komplikasi meningkat</span>
                        </div>
                    </td>
                </tr>

                <tr class="identification-row">
                    <td>
                        <div class="criteria-item">
                            <input type="checkbox" class="criteria-checkbox"
                                {{ $mppData->pemulangan_rujukan ? 'checked' : '' }} disabled>
                            <span class="criteria-label">Pemulangan/rujukan yang belum memenuhi kriteria atau
                                sebaliknya,
                                pemulangan/rujukan yang ditunda</span>
                        </div>
                    </td>
                </tr>

                <!-- Section IV: Perencanaan -->
                <tr class="section-header">
                    <td colspan="2">IV. PERENCANAAN MANAJEMEN PELAYANAN PASIEN</td>
                </tr>

                <tr class="planning-row">
                    <td class="datetime-col" rowspan="5">
                        <div class="datetime-display">
                            @if ($mppData->planning_date)
                                {{ \Carbon\Carbon::parse($mppData->planning_date)->format('d-m-Y') }}<br>
                            @endif
                            @if ($mppData->planning_time)
                                {{ \Carbon\Carbon::parse($mppData->planning_time)->format('H:i') }}
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="criteria-item">
                            <input type="checkbox" class="criteria-checkbox"
                                {{ $mppData->validasi_rencana ? 'checked' : '' }} disabled>
                            <span class="criteria-label">Validasi rencana asuhan, sesuaikan/konsisten dengan panduan
                                lakukan kolaborasi komunikasi dengan PPA dalam akses pelayanan</span>
                        </div>
                    </td>
                </tr>

                <tr class="planning-row">
                    <td>
                        <div class="criteria-item">
                            <input type="checkbox" class="criteria-checkbox"
                                {{ $mppData->rencana_informasi ? 'checked' : '' }} disabled>
                            <span class="criteria-label">Tentukan rencana pemberian informasi kepada pasien keluarga
                                untuk
                                pengambilan keputusan</span>
                        </div>
                    </td>
                </tr>

                <tr class="planning-row">
                    <td>
                        <div class="criteria-item">
                            <input type="checkbox" class="criteria-checkbox"
                                {{ $mppData->rencana_melibatkan ? 'checked' : '' }} disabled>
                            <span class="criteria-label">Tentukan rencana untuk melibatkan pasien dan keluarga dalam
                                menentukan asuhan termasuk kemungkinan perubahan rencana</span>
                        </div>
                    </td>
                </tr>

                <tr class="planning-row">
                    <td>
                        <div class="criteria-item">
                            <input type="checkbox" class="criteria-checkbox"
                                {{ $mppData->fasilitas_penyelesaian ? 'checked' : '' }} disabled>
                            <span class="criteria-label">Fasilitas penyelesaian masalah dan konflik</span>
                        </div>
                    </td>
                </tr>

                <tr class="planning-row">
                    <td>
                        <div class="criteria-item">
                            <input type="checkbox" class="criteria-checkbox"
                                {{ $mppData->bantuan_alternatif ? 'checked' : '' }} disabled>
                            <span class="criteria-label">Bantuan dalam alternatif solusi permasalahan keuangan</span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Signature pada halaman 2 -->
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
