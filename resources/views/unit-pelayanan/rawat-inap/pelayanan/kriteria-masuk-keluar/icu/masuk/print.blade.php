<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Kriteria Masuk Ruang ICU</title>
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
                KRITERIA MASUK RUANG ICU
            </div>
            <div class="patient-info">
                <p>NO RM: ________________________</p>
                <p>Nama: {{ $dataMedis->pasien->nama ?? 'LAILYAHI' }}</p>
                <p>Jenis Kelamin: {{ $dataMedis->pasien->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                <p>Tanggal Lahir: {{ $dataMedis->pasien->tgl_lahir ? date('d-m-Y', strtotime($dataMedis->pasien->tgl_lahir)) : '01-07-1958' }}</p>
            </div>
        </div>
    </div>

    <!-- Vital Signs Section -->
    <div class="vital-signs">
        <p><span class="label">Hari/Tanggal:</span>{{ date('l, d-m-Y', strtotime($kriteriaMasuk->tanggal)) }} WIB</p>
        <p><span class="label">TD:</span>{{ $kriteriaMasuk->td_sistole }}/{{ $kriteriaMasuk->td_diastole }} mmHg</p>
        <p><span class="label">Nadi:</span>{{ $kriteriaMasuk->nadi }} x/Menit</p>
        <p><span class="label">RR:</span>{{ $kriteriaMasuk->rr }} x/mnt</p>
        <p><span class="label">Suhu:</span>{{ $kriteriaMasuk->suhu }} °C</p>
        <p><span class="label">GCS:</span>{{ $kriteriaMasuk->gcs_total }} (E: {{ $kriteriaMasuk->gcs_mata }}, V: {{ $kriteriaMasuk->gcs_verbal }}, M: {{ $kriteriaMasuk->gcs_motorik }})</p>
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
            <!-- Prioritas 1 -->
            <tr>
                <td class="no">1</td>
                <td class="priority">
                    <strong>Pasien prioritas 1 (satu)</strong><br>
                    Pasien kritis, tidak stabil, yang memerlukan terapi intensif / tertitrasi
                </td>
                <td class="criteria">
                    <input type="checkbox" {{ in_array('ventilasi_dukungan', $kriteriaMasuk->prioritas_1_array) ? 'checked' : '' }} disabled>
                    <label>Butuh dukungan / bantuan ventilasi dan alat bantu suportif organ / sistem lain (ventilator, masker NRM, masker RM, dll)</label><br>
                    <input type="checkbox" {{ in_array('infus_vasoaktif', $kriteriaMasuk->prioritas_1_array) ? 'checked' : '' }} disabled>
                    <label>Butuh infus/obat-obat vasoaktif kontinyu (Dopamin, Dobutamin, Vascon, Adrenalin)</label><br>
                    <input type="checkbox" {{ in_array('anti_aritmia', $kriteriaMasuk->prioritas_1_array) ? 'checked' : '' }} disabled>
                    <label>Obat anti aritmia kontinyu</label><br>
                    <input type="checkbox" {{ in_array('bedah_kardiothorasik', $kriteriaMasuk->prioritas_1_array) ? 'checked' : '' }} disabled>
                    <label>Pasien bedah kardiotorasik</label><br>
                    <input type="checkbox" {{ in_array('sepsis_berat', $kriteriaMasuk->prioritas_1_array) ? 'checked' : '' }} disabled>
                    <label>Pasien sepsis berat</label><br>
                    <input type="checkbox" {{ in_array('gangguan_asam_basa', $kriteriaMasuk->prioritas_1_array) ? 'checked' : '' }} disabled>
                    <label>Gangguan keseimbangan asam basa dan elektrolit yang mengancam nyawa</label>
                </td>
            </tr>
            <!-- Prioritas 2 -->
            <tr>
                <td class="no">2</td>
                <td class="priority">
                    <strong>Pasien prioritas 2 (dua)</strong><br>
                    Memerlukan pelayanan pemantauan ICU, dengan kondisi medis yang senantiasa berubah
                </td>
                <td class="criteria">
                    <input type="checkbox" {{ in_array('gagal_jantung_paru', $kriteriaMasuk->prioritas_2_array) ? 'checked' : '' }} disabled>
                    <label>Pasien gagal jantung paru</label><br>
                    <input type="checkbox" {{ in_array('gagal_ginjal_akut', $kriteriaMasuk->prioritas_2_array) ? 'checked' : '' }} disabled>
                    <label>Pasien gagal ginjal akut dan berat</label><br>
                    <input type="checkbox" {{ in_array('pembedahan_mayor', $kriteriaMasuk->prioritas_2_array) ? 'checked' : '' }} disabled>
                    <label>Telah mengalami pembedahan mayor</label>
                </td>
            </tr>
            <!-- Prioritas 3 -->
            <tr>
                <td class="no">3</td>
                <td class="priority">
                    <strong>Pasien prioritas 3 (tiga)</strong><br>
                    Pasien kritis, tidak stabil, kemungkinan sembuh dan atau manfaat terapi di ICU sangat kecil
                </td>
                <td class="criteria">
                    <input type="checkbox" {{ in_array('keganasan_metastatik', $kriteriaMasuk->prioritas_3_array) ? 'checked' : '' }} disabled>
                    <label>Keganasan metastatik disertai penyulit infeksi</label><br>
                    <input type="checkbox" {{ in_array('pericardial_tamponade', $kriteriaMasuk->prioritas_3_array) ? 'checked' : '' }} disabled>
                    <label>Pericardial tamponade</label><br>
                    <input type="checkbox" {{ in_array('sumbatan_jalan_napas', $kriteriaMasuk->prioritas_3_array) ? 'checked' : '' }} disabled>
                    <label>Sumbatan jalan napas</label><br>
                    <input type="checkbox" {{ in_array('penyakit_jantung', $kriteriaMasuk->prioritas_3_array) ? 'checked' : '' }} disabled>
                    <label>Pasien penyakit jantung</label><br>
                    <input type="checkbox" {{ in_array('penyakit_paru_terminal', $kriteriaMasuk->prioritas_3_array) ? 'checked' : '' }} disabled>
                    <label>Penyakit paru terminal disertai komplikasi penyakit akut berat</label>
                </td>
            </tr>
            <!-- Prioritas 4 -->
            <tr>
                <td class="no">4</td>
                <td class="priority">
                    <strong>Pengecualian (bisa masuk ICU, tetapi harus bisa dikeluarkan dari ICU agar pasien prioritas 1, 2 dan 3 bisa masuk)</strong>
                </td>
                <td class="criteria">
                    <input type="checkbox" {{ in_array('pasien_memenuhi_kriteria', $kriteriaMasuk->prioritas_4_array) ? 'checked' : '' }} disabled>
                    <label>Pasien yang memenuhi kriteria masuk tetapi menolak terapi tunjangan hidup agresif dan pasien dengan DNR (Do Not Resuscitate)</label><br>
                    <input type="checkbox" {{ in_array('vegetatif_permanen', $kriteriaMasuk->prioritas_4_array) ? 'checked' : '' }} disabled>
                    <label>Pasien dalam keadaan vegetatif permanen</label><br>
                    <input type="checkbox" {{ in_array('mati_batang_otak', $kriteriaMasuk->prioritas_4_array) ? 'checked' : '' }} disabled>
                    <label>Pasien mati batang otak, untuk menunjang fungsi organ, hanya untuk kepentingan donor organ</label>
                </td>
            </tr>
            <!-- Prioritas 5 -->
            <tr>
                <td class="no">5</td>
                <td class="priority">
                    <strong>Berdasarkan kriteria di atas, maka pasien tersebut memenuhi kriteria untuk masuk ICU dengan diagnosa:</strong>
                </td>
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
            <p>Nama dan tanda tangan</p>
        </div>
    </div>
</body>
</html>