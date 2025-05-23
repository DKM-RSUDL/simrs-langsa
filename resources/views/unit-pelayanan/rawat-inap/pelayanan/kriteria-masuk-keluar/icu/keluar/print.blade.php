<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Kriteria Keluar Ruang ICU</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.2;
            margin: 2px;
        }

        .header {
            display: table;
            width: 100%;
            margin-bottom: 20px;
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

        .patient-info {
            display: table-cell;
            vertical-align: top;
            width: 30%;
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
            font-size: 16px;
            font-weight: bold;
            padding: 10px 15px 0 15px;
        }

        .patient-info {
            text-align: right;
        }

        .patient-info .info-box {
            display: inline-block;
            text-align: left;
            border: 1px solid #000;
            padding: 10px;
            font-size: 12px;
            width: 200px;
            box-sizing: border-box;
        }

        .patient-info .info-box p {
            margin: 0;
            line-height: 1.5;
        }

        .vital-signs {
            border: 1px solid #000;
            padding: 10px;
            margin-bottom: 20px;
            font-size: 11px;
            background-color: #f9f9f9;
        }

        .vital-row {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 5px;
            align-items: baseline;
        }

        .vital-item {
            margin-right: 25px;
            white-space: nowrap;
        }

        .vital-item .label {
            font-weight: bold;
        }

        .vital-row.gcs-row .vital-item {
            margin-right: 0;
        }

        @media (max-width: 600px) {
            .vital-row {
                flex-direction: column;
                gap: 2px;
            }

            .vital-item {
                margin-right: 0;
                white-space: normal;
            }
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #000;
            padding: 4px;
            vertical-align: top;
            font-size: 11px;
            text-align: left;
        }

        .table th.checkbox-col,
        .table td.checkbox-col {
            width: 50px;
            text-align: center;
        }

        .table .no {
            width: 30px;
        }

        .table .priority {
            width: 30%;
        }

        .table .criteria {
            width: 60%;
        }

        .table .criteria label {
            font-size: 11px;
            text-align: left;
            display: inline-block;
        }

        .table .checkbox-col input[type="checkbox"] {
            margin: 0;
            vertical-align: middle;
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
                    <p>rsudlangsa.aceh@gmail.com</p>
                </div>
            </div>
            <div class="title-section">
                Formulir Kriteria Keluar Ruang <i>Intensive Care Unit</i> (ICU)
            </div>
            <div class="patient-info">
                <div class="info-box">
                    <p>NO RM: {{ $dataMedis->kd_pasien }}</p>
                    <p>Nama: {{ $dataMedis->pasien->nama ?? 'LAILYAHI' }}</p>
                    <p>Jenis Kelamin: {{ $dataMedis->pasien->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                    <p>Tanggal Lahir: {{ $dataMedis->pasien->tgl_lahir ? date('d-m-Y', strtotime($dataMedis->pasien->tgl_lahir)) : '01-07-1958' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Vital Signs Section -->
    <div class="vital-signs">
        <div class="vital-row">
            <span class="vital-item">
                <span class="label">Hari/Tanggal:</span> 
                <span class="value">{{ date('l, d-m-Y', strtotime($kriteriaKeluar->tanggal)) }}</span>
            </span>
            <span class="vital-item">
                <span class="label">Jam:</span> 
                <span class="value">{{ date('H:i', strtotime($kriteriaKeluar->jam)) }} WIB</span>
            </span>
        </div>
        <div class="vital-row">
            <span class="vital-item">
                <span class="label">TD:</span> 
                <span class="value">{{ $kriteriaKeluar->td_sistole }}/{{ $kriteriaKeluar->td_diastole }} mmHg</span>
            </span>
            <span class="vital-item">
                <span class="label">Nadi:</span> 
                <span class="value">{{ $kriteriaKeluar->nadi }} x/Menit</span>
            </span>
            <span class="vital-item">
                <span class="label">RR:</span> 
                <span class="value">{{ $kriteriaKeluar->rr }} x/mnt</span>
            </span>
            <span class="vital-item">
                <span class="label">Suhu:</span> 
                <span class="value">{{ $kriteriaKeluar->suhu }} °C</span>
            </span>
        </div>
        <div class="vital-row gcs-row">
            <span class="vital-item">
                <span class="label">GCS:</span> 
                <span class="value">{{ $kriteriaKeluar->gcs_total }} | E: {{ $kriteriaKeluar->gcs_mata }}, V: {{ $kriteriaKeluar->gcs_verbal }}, M: {{ $kriteriaKeluar->gcs_motorik }}</span>
            </span>
        </div>
    </div>

    <!-- Priority Criteria Table -->
    <table class="table">
        <thead>
            <tr>
                <th class="no">No</th>
                <th class="priority">Prioritas</th>
                <th class="checkbox-col">Cek</th>
                <th class="criteria">Kriteria</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="no" rowspan="2">1</td>
                <td class="priority" rowspan="2">
                    <strong>Pasien prioritas 1 (satu)</strong><br>
                    Pasien kritis, tidak stabil, yang memerlukan terapi intensif / tertitrasi
                </td>
                <td class="checkbox-col">
                    <input type="checkbox" {{ in_array('kebutuhan_terapi_intensif_tidak_ada', $kriteriaKeluar->prioritas_1_array) ? 'checked' : '' }} disabled>
                </td>
                <td class="criteria">
                    <label>Kebutuhan untuk terapi intensif tidak ada lagi / tidak bermanfaat</label>
                </td>
            </tr>
            <tr>
                <td class="checkbox-col">
                    <input type="checkbox" {{ in_array('terapi_gagal_prognosa_jelek', $kriteriaKeluar->prioritas_1_array) ? 'checked' : '' }} disabled>
                </td>
                <td class="criteria">
                    <label>Terapi gagal, sehingga prognosis untuk jangka pendek jelek</label>
                </td>
            </tr>
            <tr>
                <td class="no">2</td>
                <td class="priority">
                    <strong>Pasien prioritas 2 (dua)</strong><br>
                    Memerlukan pelayanan pemantauan ICU, dengan kondisi medis yang senantiasa berubah
                </td>
                <td class="checkbox-col">
                    <input type="checkbox" {{ in_array('pemantauan_tidak_memerlukan_terapi_intensif', $kriteriaKeluar->prioritas_2_array) ? 'checked' : '' }} disabled>
                </td>
                <td class="criteria">
                    <label>Pada pemantauan, ternyata tidak memerlukan terapi intensif</label>
                </td>
            </tr>
            <tr>
                <td class="no">3</td>
                <td class="priority">
                    <strong>Pasien prioritas 3 (tiga)</strong><br>
                    Pasien kritis, tidak stabil, kemungkinan sembuh atau manfaat terapi di ICU sangat kecil
                </td>
                <td class="checkbox-col">
                    <input type="checkbox" {{ in_array('kebutuhan_terapi_intensif_tidak_ada_sembuh', $kriteriaKeluar->prioritas_3_array) ? 'checked' : '' }} disabled>
                </td>
                <td class="criteria">
                    <label>Kebutuhan terapi intensif tidak ada lagi, kemungkinan sembuh atau manfaat dari terapi intensif kontinyu kecil, maka dapat dikeluarkan dari ICU lebih dini. Tapi ini untuk penyakit ini dan terminal, karsinoma yang tersebar luas, tidak ada terapi potensial untuk memperbaiki penyakitnya.</label>
                </td>
            </tr>
            <tr>
                <td class="no">4</td>
                <td class="priority">
                    <strong>Berdasarkan kriteria di atas, maka pasien tersebut memenuhi kriteria untuk keluar ICU dengan diagnosa:</strong>
                </td>
                <td class="checkbox-col"></td>
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
            <p>{{ $kriteriaKeluar->dokter->nama ?? '.............................' }}</p>
        </div>
    </div>
</body>
</html>