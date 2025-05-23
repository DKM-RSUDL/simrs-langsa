<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Kriteria Masuk Ruang ICU</title>
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
            /* Align all cells to top */
            width: 25%;
        }

        .title-section {
            display: table-cell;
            vertical-align: top;
            /* Align all cells to top */
            width: 45%;
        }

        .patient-info {
            display: table-cell;
            vertical-align: top;
            /* Align all cells to top */
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
            /* Aligns the cell content to the right */
        }

        .patient-info .info-box {
            display: inline-block;
            text-align: left;
            /* Text inside the box aligns left */
            border: 1px solid #000;
            /* Box border */
            padding: 10px;
            /* Inner padding */
            font-size: 12px;
            width: 200px;
            /* Fixed width for neatness */
            box-sizing: border-box;
            /* Prevent padding from affecting width */
        }

        .patient-info .info-box p {
            margin: 0;
            line-height: 1.5;
            /* Consistent line spacing */
        }

        /* Rest of the CSS remains unchanged */
        /* Vital Signs Section */
        /* Vital Signs Section */
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
            /* Changed from gap to specific margin for better control when combining label/value */
        }

        /* Style for each individual vital sign item (e.g., TD, Nadi, RR) */
        .vital-item {
            margin-right: 25px;
            /* Adds space after each vital sign reading */
            white-space: nowrap;
            /* Prevents values from breaking onto a new line if there's enough space */
        }

        .vital-item .label {
            font-weight: bold;
            /* Removed flex-shrink: 0 here as vital-item now controls layout */
        }

        .vital-item .value {
            /* Removed flex-grow: 1 here as vital-item now controls layout */
        }


        /* Specific adjustments for GCS row if needed */
        .vital-row.gcs-row .vital-item {
            margin-right: 0;
            /* No extra margin for the last item in GCS row if it's just one */
        }

        /* Media query for smaller screens - adjust as necessary */
        @media (max-width: 600px) {
            .vital-row {
                flex-direction: column;
                gap: 2px;
            }

            .vital-item {
                margin-right: 0;
                /* Remove horizontal margin when stacked */
                white-space: normal;
                /* Allow wrapping on small screens */
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
            /* Center-align all table content */
        }
        

        .table th.checkbox-col,
        .table td.checkbox-col {
            width: 50px;
            text-align: center;
            /* Fixed width for checkbox column */
        }

        .table .no {
            width: 30px;
        }

        .table .priority {
            width: 30%;
            /* Adjusted for checkbox column */
        }

        .table .criteria {
            width: 60%;
            /* Adjusted for checkbox column */
        }

        .table .criteria label {
            font-size: 11px;
            text-align: left;
            /* Left-align label text for readability */
            display: inline-block;
        }

        .table .checkbox-col input[type="checkbox"] {
            margin: 0;
            /* Remove extra margins for clean alignment */
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
                Formulir Kriteia / Indikasi Masuk Ruang <i>Intensive Care Unit</i> <br>(ICU)
            </div>
            <div class="patient-info">
                <div class="info-box">
                    <p>NO RM: {{ $dataMedis->kd_pasien }}</p>
                    <p>Nama: {{ $dataMedis->pasien->nama ?? 'LAILYAHI' }}</p>
                    <p>Jenis Kelamin: {{ $dataMedis->pasien->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                    <p>Tanggal Lahir:
                        {{ $dataMedis->pasien->tgl_lahir ? date('d-m-Y', strtotime($dataMedis->pasien->tgl_lahir)) : '01-07-1958' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Vital Signs Section -->
    <!-- Vital Signs Section -->
    <div class="vital-signs">
        <div class="vital-row">
            <span class="vital-item">
                <span class="label">Hari/Tanggal:</span> <span
                    class="value">{{ date('l, d-m-Y', strtotime($kriteriaMasuk->tanggal)) }}</span>
            </span>
            <span class="vital-item">
                <span class="label">Jam:</span> <span class="value">{{ date('H:i', strtotime($kriteriaMasuk->jam)) }}
                    WIB</span>
            </span>
        </div>
        <div class="vital-row">
            <span class="vital-item">
                <span class="label">TD:</span> <span
                    class="value">{{ $kriteriaMasuk->td_sistole }}/{{ $kriteriaMasuk->td_diastole }} mmHg</span>
            </span>
            <span class="vital-item">
                <span class="label">Nadi:</span> <span class="value">{{ $kriteriaMasuk->nadi }} x/Menit</span>
            </span>
            <span class="vital-item">
                <span class="label">RR:</span> <span class="value">{{ $kriteriaMasuk->rr }} x/mnt</span>
            </span>
            <span class="vital-item">
                <span class="label">Suhu:</span> <span class="value">{{ $kriteriaMasuk->suhu }} °C</span>
            </span>
        </div>
        <div class="vital-row gcs-row">
            <span class="vital-item">
                <span class="label">GCS:</span>
                <span class="value">{{ $kriteriaMasuk->gcs_total }} | E: {{ $kriteriaMasuk->gcs_mata }}, V:
                    {{ $kriteriaMasuk->gcs_verbal }}, M: {{ $kriteriaMasuk->gcs_motorik }}</span>
            </span>
        </div>
    </div>

    <!-- Priority Criteria Table -->
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
            <!-- Prioritas 1 -->
            <tr>
                <td class="no" rowspan="6">1</td>
                <td class="priority" rowspan="6">
                    <strong>Pasien prioritas 1 (satu)</strong><br>
                    Pasien kritis, tidak stabil, yang memerlukan terapi intensif / tertitrasi
                </td>
                <td class="checkbox-col">
                    <input type="checkbox"
                        {{ in_array('ventilasi_dukungan', $kriteriaMasuk->prioritas_1_array) ? 'checked' : '' }}
                        disabled>
                </td>
                <td class="criteria">
                    <label>Butuh dukungan / bantuan ventilasi dan alat bantu suportif organ / sistem lain (ventilator,
                        masker NRM, masker RM, dll)</label>
                </td>
            </tr>
            <tr>
                <td class="checkbox-col">
                    <input type="checkbox"
                        {{ in_array('infus_vasoaktif', $kriteriaMasuk->prioritas_1_array) ? 'checked' : '' }} disabled>
                </td>
                <td class="criteria">
                    <label>Butuh infus/obat-obat vasoaktif kontinyu (Dopamin, Dobutamin, Vascon, Adrenalin)</label>
                </td>
            </tr>
            <tr>
                <td class="checkbox-col">
                    <input type="checkbox"
                        {{ in_array('anti_aritmia', $kriteriaMasuk->prioritas_1_array) ? 'checked' : '' }} disabled>
                </td>
                <td class="criteria">
                    <label>Obat anti aritmia kontinyu</label>
                </td>
            </tr>
            <tr>
                <td class="checkbox-col">
                    <input type="checkbox"
                        {{ in_array('bedah_kardiothorasik', $kriteriaMasuk->prioritas_1_array) ? 'checked' : '' }}
                        disabled>
                </td>
                <td class="criteria">
                    <label>Pasien bedah kardiotorasik</label>
                </td>
            </tr>
            <tr>
                <td class="checkbox-col">
                    <input type="checkbox"
                        {{ in_array('sepsis_berat', $kriteriaMasuk->prioritas_1_array) ? 'checked' : '' }} disabled>
                </td>
                <td class="criteria">
                    <label>Pasien sepsis berat</label>
                </td>
            </tr>
            <tr>
                <td class="checkbox-col">
                    <input type="checkbox"
                        {{ in_array('gangguan_asam_basa', $kriteriaMasuk->prioritas_1_array) ? 'checked' : '' }}
                        disabled>
                </td>
                <td class="criteria">
                    <label>Gangguan keseimbangan asam basa dan elektrolit yang mengancam nyawa</label>
                </td>
            </tr>
            <!-- Prioritas 2 -->
            <tr>
                <td class="no" rowspan="3">2</td>
                <td class="priority" rowspan="3">
                    <strong>Pasien prioritas 2 (dua)</strong><br>
                    Memerlukan pelayanan pemantauan ICU, dengan kondisi medis yang senantiasa berubah
                </td>
                <td class="checkbox-col">
                    <input type="checkbox"
                        {{ in_array('gagal_jantung_paru', $kriteriaMasuk->prioritas_2_array) ? 'checked' : '' }}
                        disabled>
                </td>
                <td class="criteria">
                    <label>Pasien gagal jantung paru</label>
                </td>
            </tr>
            <tr>
                <td class="checkbox-col">
                    <input type="checkbox"
                        {{ in_array('gagal_ginjal_akut', $kriteriaMasuk->prioritas_2_array) ? 'checked' : '' }}
                        disabled>
                </td>
                <td class="criteria">
                    <label>Pasien gagal ginjal akut dan berat</label>
                </td>
            </tr>
            <tr>
                <td class="checkbox-col">
                    <input type="checkbox"
                        {{ in_array('pembedahan_mayor', $kriteriaMasuk->prioritas_2_array) ? 'checked' : '' }}
                        disabled>
                </td>
                <td class="criteria">
                    <label>Telah mengalami pembedahan mayor</label>
                </td>
            </tr>
            <!-- Prioritas 3 -->
            <tr>
                <td class="no" rowspan="5">3</td>
                <td class="priority" rowspan="5">
                    <strong>Pasien prioritas 3 (tiga)</strong><br>
                    Pasien kritis, tidak stabil, kemungkinan sembuh dan atau manfaat terapi di ICU sangat kecil
                </td>
                <td class="checkbox-col">
                    <input type="checkbox"
                        {{ in_array('keganasan_metastatik', $kriteriaMasuk->prioritas_3_array) ? 'checked' : '' }}
                        disabled>
                </td>
                <td class="criteria">
                    <label>Keganasan metastatik disertai penyulit infeksi</label>
                </td>
            </tr>
            <tr>
                <td class="checkbox-col">
                    <input type="checkbox"
                        {{ in_array('pericardial_tamponade', $kriteriaMasuk->prioritas_3_array) ? 'checked' : '' }}
                        disabled>
                </td>
                <td class="criteria">
                    <label>Pericardial tamponade</label>
                </td>
            </tr>
            <tr>
                <td class="checkbox-col">
                    <input type="checkbox"
                        {{ in_array('sumbatan_jalan_napas', $kriteriaMasuk->prioritas_3_array) ? 'checked' : '' }}
                        disabled>
                </td>
                <td class="criteria">
                    <label>Sumbatan jalan napas</label>
                </td>
            </tr>
            <tr>
                <td class="checkbox-col">
                    <input type="checkbox"
                        {{ in_array('penyakit_jantung', $kriteriaMasuk->prioritas_3_array) ? 'checked' : '' }}
                        disabled>
                </td>
                <td class="criteria">
                    <label>Pasien penyakit jantung</label>
                </td>
            </tr>
            <tr>
                <td class="checkbox-col">
                    <input type="checkbox"
                        {{ in_array('penyakit_paru_terminal', $kriteriaMasuk->prioritas_3_array) ? 'checked' : '' }}
                        disabled>
                </td>
                <td class="criteria">
                    <label>Penyakit paru terminal disertai komplikasi penyakit akut berat</label>
                </td>
            </tr>
            <!-- Prioritas 4 -->
            <tr>
                <td class="no" rowspan="3">4</td>
                <td class="priority" rowspan="3">
                    <strong>Pengecualian (bisa masuk ICU, tetapi harus bisa dikeluarkan dari ICU agar pasien prioritas
                        1, 2 dan 3 bisa masuk)</strong>
                </td>
                <td class="checkbox-col">
                    <input type="checkbox"
                        {{ in_array('pasien_memenuhi_kriteria', $kriteriaMasuk->prioritas_4_array) ? 'checked' : '' }}
                        disabled>
                </td>
                <td class="criteria">
                    <label>Pasien yang memenuhi kriteria masuk tetapi menolak terapi tunjangan hidup agresif dan pasien
                        dengan DNR (Do Not Resuscitate)</label>
                </td>
            </tr>
            <tr>
                <td class="checkbox-col">
                    <input type="checkbox"
                        {{ in_array('vegetatif_permanen', $kriteriaMasuk->prioritas_4_array) ? 'checked' : '' }}
                        disabled>
                </td>
                <td class="criteria">
                    <label>Pasien dalam keadaan vegetatif permanen</label>
                </td>
            </tr>
            <tr>
                <td class="checkbox-col">
                    <input type="checkbox"
                        {{ in_array('mati_batang_otak', $kriteriaMasuk->prioritas_4_array) ? 'checked' : '' }}
                        disabled>
                </td>
                <td class="criteria">
                    <label>Pasien mati batang otak, untuk menunjang fungsi organ, hanya untuk kepentingan donor
                        organ</label>
                </td>
            </tr>
            <!-- Prioritas 5 -->
            <tr>
                <td class="no">5</td>
                <td class="priority">
                    <strong>Berdasarkan kriteria di atas, maka pasien tersebut memenuhi kriteria untuk masuk ICU dengan
                        diagnosa:</strong>
                </td>
                <td class="checkbox-col"></td>
                <td class="criteria">
                    {{ $kriteriaMasuk->diagnosa_kriteria ?? '' }}
                </td>
            </tr>
        </tbody>
    </table>
    <!-- Signature Section -->
    <div class="signature">
        <div>
            <p>Dokter yang menilai</p>
            <div class="underline"></div>
            <p>{{ $kriteriaMasuk->dokter->nama ?? '.............................' }}</p>
        </div>
    </div>
</body>

</html>
