<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Kriteria Masuk/Keluar ICCU</title>
    <style>
        @page {
            margin: 0.5cm; /* Mengurangi margin untuk memastikan muat dalam 1 halaman */
            size: A4 portrait;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 5;
            padding: 5;
            font-size: 9pt; /* Mengurangi ukuran font agar muat */
            line-height: 1.1;
        }

        .container {
            width: 100%;
            position: relative;
        }

        /* Header/Kop Surat */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 3px;
            width: 100%;
            position: relative;
        }

        .logo-rs {
            display: flex;
            align-items: center;
        }

        .logo {
            width: 50px; /* Mengurangi ukuran logo */
            height: 50px;
            margin-right: 5px;
        }

        .kop-text {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .rs-name-1 {
            font-size: 12pt;
            font-weight: bold;
            margin: 2;
        }

        .rs-address {
            font-size: 9pt;
            margin: 2;
            line-height: 1.2;
        }

        .border-line {
            border-bottom: 2px solid black;
            margin-top: 1px;
            margin-bottom: 1px;
        }

        .border-line-2 {
            border-bottom: 1px solid black;
            margin-bottom: 2px;
        }

        /* Judul */
        .title {
            text-align: center;
            font-size: 12pt;
            font-weight: bold;
            text-decoration: underline;
            margin: 3px 0;
        }

        /* Content */
        .content {
            margin-bottom: 2px;
        }

        /* Form Fields */
        p {
            margin: 2px 0;
            font-size: 9pt;
        }

        .form-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }

        .form-table td {
            padding: 1px 0;
            font-size: 9pt;
        }

        .form-table .label {
            width: 100px;
            text-align: left;
            padding-right: 5px;
        }

        .form-table .value {
            border-bottom: 1px dotted #000;
            min-height: 12px;
            padding-left: 3px;
        }

        /* Patient Info Box */
        .patient-info {
            border: 1px solid #000;
            padding: 3px;
            width: 250px;
            font-size: 9pt;
            position: absolute;
            top: 0;
            right: 0;
        }

        .patient-info-row {
            display: flex;
            margin-bottom: 3px;
        }

        .patient-info-label {
            width: 80px;
            font-weight: normal;
        }

        .patient-info-value {
            flex: 1;
        }

        /* Kriteria Table */
        .kriteria-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
            font-size: 9pt; /* Mengurangi ukuran font */
        }

        .kriteria-table th,
        .kriteria-table td {
            border: 1px solid #000;
            padding: 3px; /* Mengurangi padding */
            text-align: left;
            vertical-align: top;
        }

        .kriteria-table th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }

        .kriteria-table .check-column {
            width: 30px; /* Mengurangi lebar */
            text-align: center;
        }

        .kriteria-table .keterangan-column {
            width: 120px; /* Mengurangi lebar */
        }

        .kriteria-table .description-column {
            width: auto;
        }

        .sub-kriteria {
            margin-left: 10px; /* Mengurangi indentasi */
        }

        /* Fixed Signature Section */
        .signature-section {
            margin-top: 10px; /* Mengurangi margin */
            position: relative;
            text-align: right; /* Mengatur semua elemen ke kanan */
        }

        .signature-location {
            margin-bottom: 5px; /* Mengurangi margin */
            font-size: 9pt;
        }

        .signature-location .location {
            border-bottom: 1px dotted #000;
            min-width: 80px;
            text-align: center;
            display: inline-block;
            padding-bottom: 1px;
        }

        .signature-location .time {
            border-bottom: 1px dotted #000;
            min-width: 40px;
            text-align: center;
            display: inline-block;
            padding-bottom: 1px;
        }

        .signature-box {
            display: inline-block; /* Mengatur agar tanda tangan tetap di kanan */
            text-align: center;
            padding: 0 5px;
            vertical-align: top;
            width: 150px; /* Memberikan lebar tetap */
        }

        .signature-title {
            margin-bottom: 10px;
            font-size: 9pt;
        }

        .signature-space {
            min-height: 40px; /* Mengurangi tinggi */
            margin-bottom: 3px;
        }

        .signature-line {
            border-bottom: 1px solid #000;
            margin: 0 auto;
            width: 150px;
            text-align: center;
            padding-bottom: 2px;
            font-size: 9pt;
        }

        .signature-subtitle {
            margin-top: 3px;
            font-size: 9pt;
            text-align: center;
        }

        .clear {
            clear: both;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header/Kop Surat -->
        <div class="header">
            <div class="logo-rs">
                <img src="{{ public_path('assets/img/Logo-RSUD-Langsa-1.png') }}" alt="Logo RSUD Langsa" class="logo">
                <div class="kop-text">
                    <p class="rs-name-1">RSUD LANGSA</p>
                    <p class="rs-address">Jl. Jend. A. Yani, Kota Langsa</p>
                    <p class="rs-address">Telp: 0641-22051</p>
                    <p class="rs-address">email: rsudlangsa.aceh@gmail.com</p>
                </div>
            </div>
            <div class="patient-info">
                <div class="patient-info-row">
                    <span class="patient-info-label">No RM</span>
                    <span class="patient-info-value">: {{ $dataMedis->pasien->kd_pasien }}</span>
                </div>
                <div class="patient-info-row">
                    <span class="patient-info-label">Nama</span>
                    <span class="patient-info-value">: {{ $dataMedis->pasien->nama }}</span>
                </div>
                <div class="patient-info-row">
                    <span class="patient-info-label">Jenis Kelamin</span>
                    <span class="patient-info-value">:
                        {{ $dataMedis->pasien->jenis_kelamin == 1 ? 'Laki-laki' : ($dataMedis->pasien->jenis_kelamin == 0 ? 'Perempuan' : 'Tidak Diketahui') }}
                    </span>
                </div>
                <div class="patient-info-row">
                    <span class="patient-info-label">Umur</span>
                    <span class="patient-info-value">: {{ $dataMedis->pasien->umur ?? 'Tidak Diketahui' }} Tahun</span>
                </div>
            </div>
        </div>

        <div class="clear"></div>
        <div class="border-line"></div>
        <div class="border-line-2"></div>

        <!-- Judul -->
        <div class="title">FORMULIR KRITERIA MASUK/KELUAR ICCU</div>

        <!-- Isi Surat -->
        <div class="content">
            <!-- Informasi Dokter -->
            <table class="form-table">
                <tr>
                    <td class="label">Tanggal</td>
                    <td class="value">
                        : {{ $dataIccu->iccu_tanggal ? \Carbon\Carbon::parse($dataIccu->iccu_tanggal)->format('d M Y') : '-' }}
                    </td>
                </tr>
                <tr>
                    <td class="label">Jam</td>
                    <td class="value">
                        : {{ $dataIccu->iccu_jam ? \Carbon\Carbon::parse($dataIccu->iccu_jam)->format('H:i') : '-' }}
                    </td>
                </tr>
                <tr>
                    <td class="label">Dokter Jantung</td>
                    <td class="value">
                        : {{ $dokter->firstWhere('kd_dokter', $dataIccu->kd_dokter)->nama ?? '-' }}
                    </td>
                </tr>
            </table>

            <!-- Kriteria Masuk -->
            <p><strong>KRITERIA MASUK</strong></p>
            <table class="kriteria-table">
                <thead>
                    <tr>
                        <th class="description-column">Deskripsi</th>
                        <th class="check-column">Check</th>
                        <th class="keterangan-column">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>1. Nilai Tanda Vital</strong></td>
                        <td>{{ $dataIccu->vita_kriteria_masuk ? '✔' : '' }}</td>
                        <td>{{ $dataIccu->vita_keterangan_masuk ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td>1. Infark Miocard Akut</td>
                        <td>{{ $dataIccu->infark_kriteria_masuk ? '✔' : '' }}</td>
                        <td>{{ $dataIccu->infark_keterangan_masuk ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td>2. Angina Tidak Stabil</td>
                        <td>{{ $dataIccu->angina_kriteria_masuk ? '✔' : '' }}</td>
                        <td>{{ $dataIccu->angina_keterangan_masuk ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>3. Aritmia yang gawat, mengancam jiwa misalnya:</strong></td>
                        <td>{{ $dataIccu->aritmia_kriteria_masuk ? '✔' : '' }}</td>
                        <td>{{ $dataIccu->aritmia_keterangan_masuk ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td class="sub-kriteria">• Blok AV total dengan irama lolos Ventrikuler <40X/Menit</td>
                        <td>{{ $dataIccu->blokav_kriteria_masuk ? '✔' : '' }}</td>
                        <td>{{ $dataIccu->blokav_keterangan_masuk ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td class="sub-kriteria">• Sinus Bradikardi <40x/Menit</td>
                        <td>{{ $dataIccu->sinus_kriteria_masuk ? '✔' : '' }}</td>
                        <td>{{ $dataIccu->sinus_keterangan_masuk ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td class="sub-kriteria">• Sick Sinus Sindroma dengan serangan</td>
                        <td>{{ $dataIccu->sick_kriteria_masuk ? '✔' : '' }}</td>
                        <td>{{ $dataIccu->sick_keterangan_masuk ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td class="sub-kriteria">• Takikardia atrial proksimal</td>
                        <td>{{ $dataIccu->takikardia_kriteria_masuk ? '✔' : '' }}</td>
                        <td>{{ $dataIccu->takikardia_keterangan_masuk ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td class="sub-kriteria">• Fibrilasi ventrikuler</td>
                        <td>{{ $dataIccu->fibrilasi_kriteria_masuk ? '✔' : '' }}</td>
                        <td>{{ $dataIccu->fibrilasi_keterangan_masuk ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td>4. Edema Paru Akut</td>
                        <td>{{ $dataIccu->edema_kriteria_masuk ? '✔' : '' }}</td>
                        <td>{{ $dataIccu->edema_keterangan_masuk ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td>5. Miokarditis</td>
                        <td>{{ $dataIccu->miokarditis_kriteria_masuk ? '✔' : '' }}</td>
                        <td>{{ $dataIccu->miokarditis_keterangan_masuk ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td>6. Krisis Hipertensi</td>
                        <td>{{ $dataIccu->krisis_kriteria_masuk ? '✔' : '' }}</td>
                        <td>{{ $dataIccu->krisis_keterangan_masuk ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td>7. Penyakit Jantung lain yang memerlukan pemantauan Hemodinamik</td>
                        <td>{{ $dataIccu->penyakit_kriteria_masuk ? '✔' : '' }}</td>
                        <td>{{ $dataIccu->penyakit_keterangan_masuk ?: '-' }}</td>
                    </tr>
                </tbody>
            </table>

            <!-- Kriteria Keluar -->
            <p><strong>KRITERIA KELUAR</strong></p>
            <table class="kriteria-table">
                <thead>
                    <tr>
                        <th class="description-column">Deskripsi</th>
                        <th class="check-column">Check</th>
                        <th class="keterangan-column">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1. Dianggap keadaan penderita sudah tidak memerlukan perawatan intensif dan dapat dirawat di ruang rawat inap.</td>
                        <td>{{ $dataIccu->dirawat_kriteria_keluar ? '✔' : '' }}</td>
                        <td>{{ $dataIccu->dirawat_keterangan_keluar ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td>2. Kegawatan penderita bukan disebabkan oleh penyakit jantung dan dipindahkan ke unit perawatan intensif lain.</td>
                        <td>{{ $dataIccu->kegawatan_kriteria_keluar ? '✔' : '' }}</td>
                        <td>{{ $dataIccu->kegawatan_keterangan_keluar ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td>3. Penderita juga menderita penyakit menular.</td>
                        <td>{{ $dataIccu->penderita_kriteria_keluar ? '✔' : '' }}</td>
                        <td>{{ $dataIccu->penderita_keterangan_keluar ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td>4. Penderita yang meninggal dan dikeluarkan setelah 2 jam observasi di ICCU.</td>
                        <td>{{ $dataIccu->iccu_kriteria_keluar ? '✔' : '' }}</td>
                        <td>{{ $dataIccu->iccu_keterangan_keluar ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td>5. Penderita yang ingin dirawat di rumah sakit lain atas permintaan sendiri atau keluarga.</td>
                        <td>{{ $dataIccu->rslain_kriteria_keluar ? '✔' : '' }}</td>
                        <td>{{ $dataIccu->rslain_keterangan_keluar ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td>6. Yang pulang paksa setelah mendatangani surat pernyataan tidak ingin di rawat di RSUD Langsa.</td>
                        <td>{{ $dataIccu->rsud_kriteria_keluar ? '✔' : '' }}</td>
                        <td>{{ $dataIccu->rsud_keterangan_keluar ?: '-' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Tanda Tangan -->
        <div class="signature-section">
            <div class="signature-location">
                <p>Langsa, <span class="location">{{ $dataIccu->iccu_tanggal ? \Carbon\Carbon::parse($dataIccu->iccu_tanggal)->format('d M Y') : '-' }}</span></p>
                <p>Jam: <span class="time">{{ $dataIccu->iccu_jam ? \Carbon\Carbon::parse($dataIccu->iccu_jam)->format('H:i') : '-' }}</span></p>
            </div>
            <br>
            <div class="signature-box">
                <div class="signature-title">Dokter Jantung</div>
                <div class="signature-space"></div>
                <div class="signature-line">({{ $dokter->firstWhere('kd_dokter', $dataIccu->kd_dokter)->nama ?? '-' }})</div>                
            </div>
        </div>
    </div>
</body>

</html>