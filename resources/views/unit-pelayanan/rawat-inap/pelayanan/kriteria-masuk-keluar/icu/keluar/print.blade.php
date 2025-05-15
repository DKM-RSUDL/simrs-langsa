<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Kriteria Keluar Ruang ICU</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 20px;
        }

        .header {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }

        .header-row {
            display: table-row;
        }

        .hospital-info, .title-section, .patient-info {
            display: table-cell;
            vertical-align: middle;
            width: 33.33%;
        }

        .hospital-info {
            text-align: left;
        }

        .hospital-info img {
            width: 60px;
            height: auto;
            vertical-align: middle;
            margin-right: 10px;
        }

        .hospital-info .info-text {
            display: inline-block;
            vertical-align: middle;
            font-size: 11px;
        }

        .hospital-info .info-text .title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 2px;
        }

        .hospital-info .info-text p {
            margin: 0;
        }

        .title-section {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
        }

        .patient-info {
            text-align: right;
            font-size: 11px;
        }

        .patient-info p {
            margin: 0;
        }

        .vital-signs {
            border: 1px solid #000;
            padding: 10px;
            margin-bottom: 20px;
            font-size: 11px;
        }

        .vital-signs p {
            margin: 0 0 5px 0;
        }

        .vital-signs .label {
            display: inline-block;
            font-weight: bold;
            width: 100px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #000;
            padding: 8px;
            vertical-align: top;
            font-size: 11px;
        }

        .table th {
            font-weight: bold;
            text-align: left;
        }

        .table .no {
            width: 30px;
            text-align: center;
        }

        .table .priority {
            width: 40%;
        }

        .table .criteria {
            width: 60%;
        }

        .table .criteria input[type="checkbox"] {
            margin-right: 5px;
        }

        .table .criteria label {
            font-size: 11px;
        }

        .signature {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
        }

        .signature div {
            text-align: center;
        }

        .signature p {
            margin: 0;
            font-size: 11px;
        }

        .signature .underline {
            border-bottom: 1px solid #000;
            width: 150px;
            margin: 60px auto 5px;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <div class="header">
        <div class="header-row">
            <div class="hospital-info">
                <img src="{{ public_path('assets/img/Logo-RSUD-Langsa-1.png') }}" alt="Logo RSUD Langsa">
                <div class="info-text">
                    <p class="title">RSUD LANGSA</p>
                    <p>Jl. Jend. A. Yani Kota Langsa</p>
                    <p>Telp. 0641 - 32051</p>
                    <p>email: rsudlangsa.aceh@gmail.com</p>
                </div>
            </div>
            <div class="title-section">
                KRITERIA KELUAR RUANG ICU
            </div>
            <div class="patient-info">
                <p>NO RM: {{ $dataMedis->kd_pasien }}</p>
                <p>Nama: {{ $dataMedis->pasien->nama ?? 'LAILYAHI' }}</p>
                <p>Jenis Kelamin: {{ $dataMedis->pasien->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                <p>Tanggal Lahir: {{ $dataMedis->pasien->tgl_lahir ? date('d-m-Y', strtotime($dataMedis->pasien->tgl_lahir)) : '01-07-1958' }}</p>
            </div>
        </div>
    </div>

    <!-- Vital Signs Section -->
    <div class="vital-signs">
        <p><span class="label">Hari/Tanggal:</span>{{ date('l, d-m-Y', strtotime($kriteriaKeluar->tanggal)) }} WIB</p>
        <p><span class="label">TD:</span>{{ $kriteriaKeluar->td_sistole }}/{{ $kriteriaKeluar->td_diastole }} mmHg</p>
        <p><span class="label">Nadi:</span>{{ $kriteriaKeluar->nadi }} x/Menit</p>
        <p><span class="label">RR:</span>{{ $kriteriaKeluar->rr }} x/mnt</p>
        <p><span class="label">Suhu:</span>{{ $kriteriaKeluar->suhu }} °C</p>
        <p><span class="label">GCS:</span>{{ $kriteriaKeluar->gcs_total }} (E: {{ $kriteriaKeluar->gcs_mata }}, V: {{ $kriteriaKeluar->gcs_verbal }}, M: {{ $kriteriaKeluar->gcs_motorik }})</p>
    </div>

    <!-- Priority Criteria Table -->
    <table class="table">
        <thead>
            <tr>
                <th class="no">No</th>
                <th class="priority">Prioritas</th>
                <th class="criteria">Kriteria</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="no">1</td>
                <td class="priority">
                    <strong>Pasien prioritas 1 (satu)</strong><br>
                    Pasien kritis, tidak stabil, yang memerlukan terapi intensif / tertitrasi
                </td>
                <td class="criteria">
                    <input type="checkbox" {{ in_array('kebutuhan_terapi_intensif_tidak_ada', $kriteriaKeluar->prioritas_1_array) ? 'checked' : '' }} disabled>
                    <label>Kebutuhan untuk terapi intensif tidak ada lagi / tidak bermanfaat</label><br>
                    <input type="checkbox" {{ in_array('terapi_gagal_prognosa_jelek', $kriteriaKeluar->prioritas_1_array) ? 'checked' : '' }} disabled>
                    <label>Terapi gagal, sehingga prognosis untuk jangka pendek jelek</label>
                </td>
            </tr>
            <tr>
                <td class="no">2</td>
                <td class="priority">
                    <strong>Pasien prioritas 2 (dua)</strong><br>
                    Memerlukan pelayanan pemantauan ICU, dengan kondisi medis yang senantiasa berubah
                </td>
                <td class="criteria">
                    <input type="checkbox" {{ in_array('pemantauan_tidak_memerlukan_terapi_intensif', $kriteriaKeluar->prioritas_2_array) ? 'checked' : '' }} disabled>
                    <label>Pada pemantauan, ternyata tidak memerlukan terapi intensif</label>
                </td>
            </tr>
            <tr>
                <td class="no">3</td>
                <td class="priority">
                    <strong>Pasien prioritas 3 (tiga)</strong><br>
                    Pasien kritis, tidak stabil, kemungkinan sembuh atau manfaat terapi di ICU sangat kecil
                </td>
                <td class="criteria">
                    <input type="checkbox" {{ in_array('kebutuhan_terapi_intensif_tidak_ada_sembuh', $kriteriaKeluar->prioritas_3_array) ? 'checked' : '' }} disabled>
                    <label>Kebutuhan terapi intensif tidak ada lagi, kemungkinan sembuh atau manfaat dari terapi intensif kontinyu kecil, maka dapat dikeluarkan dari ICU lebih dini. Tapi ini untuk penyakit ini dan terminal, karsinoma yang tersebar luas, tidak ada terapi potensial untuk memperbaiki penyakitnya.</label>
                </td>
            </tr>
            <tr>
                <td class="no">4</td>
                <td class="priority">
                    <strong>Berdasarkan kriteria diatas, maka pasien tersebut memenuhi kriteria untuk keluar ICU dengan diagnosa :</strong>
                </td>
                <td class="criteria">
                    {{ $kriteriaKeluar->diagnosa_kriteria ?? '' }}
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Signature Section -->
    <div class="signature">
        <div>
            <p>Dokter yang menilai</p>
            <div class="underline"></div>
            <p>Nama dan tanda tangan</p>
        </div>
    </div>
</body>
</html>