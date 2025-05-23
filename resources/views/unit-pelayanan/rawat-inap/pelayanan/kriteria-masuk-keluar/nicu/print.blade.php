<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Kriteria Masuk & Keluar NICU</title>
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

        .table th.checkbox-col,
        .table td.checkbox-col {
            width: 40px;
            text-align: center;
            vertical-align: middle;
        }

        .table .checkbox-col input[type="checkbox"] {
            margin: 0;
            vertical-align: middle;
            width: 16px;
            height: 16px;
        }

        .table th.keterangan-col,
        .table td.keterangan-col {
            width: 30%;
        }

        .table .no {
            width: 25px;
            text-align: center;
        }

        .table .criteria {
            width: auto;
        }

        .main-criteria {
            font-weight: bold;
            margin-bottom: 3px;
        }

        .sub-criteria-text {
            padding-left: 15px;
            font-size: 0.95em;
        }

        .alert-info-box {
            background-color: #e0f7fa;
            border: 1px solid #b2ebf2;
            color: #006064;
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 3px;
            font-size: 0.9em;
        }

        .text-muted {
            color: #6c757d;
            font-size: 0.85em;
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
    </style>
</head>
<body>
    <div class="header">
        <div class="header-row">
            <div class="hospital-info">
                @if(isset($logoPath) && $logoPath)
                    <img src="{{ $logoPath }}" alt="Logo RSUD Langsa">
                @else
                    <img src="{{ public_path('assets/img/Logo-RSUD-Langsa-1.png') }}" alt="Logo RSUD Langsa">
                @endif
                <div class="info-text">
                    <p class="title">RSUD LANGSA</p>
                    <p>Jl. Jend. A. Yani Kota Langsa</p>
                    <p>Telp. 0641 - 32051</p>
                    <p>rsudlangsa.aceh@gmail.com</p>
                </div>
            </div>
            <div class="title-section">
                FORMULIR KRITERIA / INDIKASI <br> MASUK & KELUAR RUANG <br> <i style="font-size: 10pt"> NEONATAL INTENSIVE CARE UNIT </i><br>(NICU)
            </div>
            <div class="patient-info-cell">
                <div class="patient-info-box">
                    <p><b>NO RM: {{ $dataMedis->kd_pasien ?? 'N/A' }}</b></p>
                    <p>Nama: {{ $dataMedis->pasien->nama ?? 'N/A' }}</p>
                    <p>Jenis Kelamin: {{ ($dataMedis->pasien->jenis_kelamin ?? '') == '1' ? 'Laki-laki' : (($dataMedis->pasien->jenis_kelamin ?? '') == '0' ? 'Perempuan' : 'N/A') }}</p>
                    <p>Tanggal Lahir: {{ $dataMedis->pasien->tgl_lahir ? Carbon\Carbon::parse($dataMedis->pasien->tgl_lahir)->format('d-m-Y') : 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>
    <hr style="border: 0.5px solid #000; margin-top: 5px; margin-bottom: 10px;">

    <div class="section">
        <h6 style="font-size: 11pt; font-weight: bold; color: #2c3e50; margin-bottom: 8px;">Kriteria Masuk NICU</h6>
        @if ($dataNicu)
        <table class="table">
            <thead>
                <tr>
                    <th class="no">No</th>
                    <th>Kriteria Masuk</th>
                    <th class="checkbox-col">Status</th>
                    <th class="keterangan-col">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="no">1.</td>
                    <td><strong>BBLR (1000-1500 gram dengan komplikasi respirasi sindrome)</strong></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataNicu->kriteria_1 ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataNicu->keterangan_1 ?? '' }}</td>
                </tr>
                <tr>
                    <td class="no">2.</td>
                    <td><strong>Masa gestasi kurang dari 28 minggu dengan komplikasi respirasi distress sindrome (RDS)</strong></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataNicu->kriteria_2 ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataNicu->keterangan_2 ?? '' }}</td>
                </tr>
                <tr>
                    <td class="no">3.</td>
                    <td><strong>Post Date: dengan tanda-tanda Sepsis, masa kehamilan 42 minggu dengan RDS</strong></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataNicu->kriteria_3 ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataNicu->keterangan_3 ?? '' }}</td>
                </tr>
                <tr>
                    <td class="no">4.</td>
                    <td><div class="main-criteria">Bayi dengan kelainan kongenital:</div></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataNicu->kriteria_4_main ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataNicu->keterangan_4_main ?? '' }}</td>
                </tr>
                <tr>
                    <td class="no"></td>
                    <td><div class="sub-criteria-text">• Bibir sumbing</div></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataNicu->kriteria_4_bibir ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataNicu->keterangan_4_bibir ?? '' }}</td>
                </tr>
                <tr>
                    <td class="no"></td>
                    <td><div class="sub-criteria-text">• Atresia ani</div></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataNicu->kriteria_4_atresia ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataNicu->keterangan_4_atresia ?? '' }}</td>
                </tr>
                <tr>
                    <td class="no"></td>
                    <td><div class="sub-criteria-text">• An acephali</div></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataNicu->kriteria_4_acephali ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataNicu->keterangan_4_acephali ?? '' }}</td>
                </tr>
                <tr>
                    <td class="no"></td>
                    <td><div class="sub-criteria-text">• Polidactily</div></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataNicu->kriteria_4_polidactily ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataNicu->keterangan_4_polidactily ?? '' }}</td>
                </tr>
                <tr>
                    <td class="no">5.</td>
                    <td><div class="main-criteria">Asfiksia berat:</div></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataNicu->kriteria_5_main ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataNicu->keterangan_5_main ?? '' }}</td>
                </tr>
                <tr>
                    <td class="no"></td>
                    <td><div class="sub-criteria-text">• RR: > 70 x/m</div></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataNicu->kriteria_5_rr ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataNicu->keterangan_5_rr ?? '' }}</td>
                </tr>
                <tr>
                    <td class="no"></td>
                    <td><div class="sub-criteria-text">• Takipnoe</div></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataNicu->kriteria_5_takipnoe ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataNicu->keterangan_5_takipnoe ?? '' }}</td>
                </tr>
                <tr>
                    <td class="no"></td>
                    <td><div class="sub-criteria-text">• Apgar score: 0-3</div></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataNicu->kriteria_5_apgar ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataNicu->keterangan_5_apgar ?? '' }}</td>
                </tr>
                <tr>
                    <td class="no"></td>
                    <td><div class="sub-criteria-text">• Retraksi dinding dada</div></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataNicu->kriteria_5_retraksi ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataNicu->keterangan_5_retraksi ?? '' }}</td>
                </tr>
                <tr>
                    <td class="no"></td>
                    <td><div class="sub-criteria-text">• Sianosis</div></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataNicu->kriteria_5_sianosis ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataNicu->keterangan_5_sianosis ?? '' }}</td>
                </tr>
                <tr>
                    <td class="no"></td>
                    <td><div class="sub-criteria-text">• Merintih</div></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataNicu->kriteria_5_merintih ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataNicu->keterangan_5_merintih ?? '' }}</td>
                </tr>
                <tr>
                    <td class="no">6.</td>
                    <td><div class="main-criteria">Sepsis neonatorum:</div></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataNicu->kriteria_6_main ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataNicu->keterangan_6_main ?? '' }}</td>
                </tr>
                <tr>
                    <td class="no"></td>
                    <td><div class="sub-criteria-text">• Leukocyte: >20.000</div></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataNicu->kriteria_6_leukocyte ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataNicu->keterangan_6_leukocyte ?? '' }}</td>
                </tr>
                <tr>
                    <td class="no"></td>
                    <td><div class="sub-criteria-text">• RR 70</div></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataNicu->kriteria_6_rr ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataNicu->keterangan_6_rr ?? '' }}</td>
                </tr>
                <tr>
                    <td class="no"></td>
                    <td><div class="sub-criteria-text">• Temp: >38°C / <36 °C</div></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataNicu->kriteria_6_temp ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataNicu->keterangan_6_temp ?? '' }}</td>
                </tr>
                <tr>
                    <td class="no"></td>
                    <td><div class="sub-criteria-text">• HR: >160 x/m atau <100 x/i</div></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataNicu->kriteria_6_hr ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataNicu->keterangan_6_hr ?? '' }}</td>
                </tr>
                <tr>
                    <td class="no"></td>
                    <td><div class="sub-criteria-text">• Malas minum</div></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataNicu->kriteria_6_malas ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataNicu->keterangan_6_malas ?? '' }}</td>
                </tr>
                <tr>
                    <td class="no">7.</td>
                    <td><strong>Distres nafas berat</strong></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataNicu->kriteria_7 ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataNicu->keterangan_7 ?? '' }}</td>
                </tr>
                <tr>
                    <td class="no">8.</td>
                    <td><strong>Tetanus neonatorum</strong></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataNicu->kriteria_8 ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataNicu->keterangan_8 ?? '' }}</td>
                </tr>
                <tr>
                    <td class="no">9.</td>
                    <td><strong>Kejang pada bayi / neonatal seizure</strong></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataNicu->kriteria_9 ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataNicu->keterangan_9 ?? '' }}</td>
                </tr>
                <tr>
                    <td class="no">10.</td>
                    <td><strong>Bayi diare</strong></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataNicu->kriteria_10 ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataNicu->keterangan_10 ?? '' }}</td>
                </tr>
            </tbody>
        </table>
        @else
        <p>Data Kriteria Masuk NICU tidak tersedia.</p>
        @endif
    </div>

    <div class="section" style="margin-top: 55px;">
        <h6 style="font-size: 11pt; font-weight: bold; color: #2c3e50; margin-bottom: 8px;">Kriteria Keluar NICU</h6>
        @if ($dataKeluarNicu)
        <table class="table">
            <thead>
                <tr>
                    <th class="no">No</th>
                    <th>Kriteria Keluar</th>
                    <th class="checkbox-col">Status</th>
                    <th class="keterangan-col">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="no">1.</td>
                    <td><strong>BBLR bayi sudah normal berat badannya ≥ 1800 gr</strong></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataKeluarNicu->kriteria_keluar_1 ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataKeluarNicu->keterangan_keluar_1 ?? '' }}</td>
                </tr>
                <tr>
                    <td class="no">2.</td>
                    <td><strong>Kondisi Yang Sudah Membaik</strong></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataKeluarNicu->kriteria_keluar_2 ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataKeluarNicu->keterangan_keluar_2 ?? '' }}</td>
                </tr>
                <tr>
                    <td class="no">3.</td>
                    <td><strong>Apgar Score 7-10</strong></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataKeluarNicu->kriteria_keluar_3 ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataKeluarNicu->keterangan_keluar_3 ?? '' }}</td>
                </tr>
                <tr>
                    <td class="no">4.</td>
                    <td><strong>Kadar bilirubin normal</strong></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataKeluarNicu->kriteria_keluar_4 ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataKeluarNicu->keterangan_keluar_4 ?? '' }}</td>
                </tr>
                <tr>
                    <td class="no">5.</td>
                    <td><strong>Gerakan aktif, refleks isap kuat</strong></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataKeluarNicu->kriteria_keluar_5 ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataKeluarNicu->keterangan_keluar_5 ?? '' }}</td>
                </tr>
            </tbody>
        </table>
        @else
        <p>Data Kriteria Keluar NICU tidak tersedia.</p>
        @endif
    </div>

    <div class="signature">
        <div>
            <p>Dokter yang menilai</p>
            <div class="underline"></div>
            <p>{{ $dataNicu && $dataNicu->dokter ? $dataNicu->dokter->nama : '.............................' }}</p>
        </div>
    </div>
</body>
</html>