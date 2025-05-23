<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Kriteria Masuk & Keluar PICU</title>
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

        .vital-signs {
            border: 1px solid #000;
            padding: 8px;
            margin-bottom: 15px;
            font-size: 9pt;
            background-color: #f9f9f9;
        }

        .vital-row {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 3px;
            align-items: baseline;
        }

        .vital-item {
            margin-right: 20px;
            white-space: nowrap;
        }

        .vital-item .label {
            font-weight: bold;
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
                FORMULIR KRITERIA / INDIKASI <br> MASUK & KELUAR RUANG <br> <i style="font-size: 10pt"> PEDIATRIC INTENSIVE CARE UNIT </i><br>(PICU)
            </div>
            <div class="patient-info-cell">
                <div class="patient-info-box">
                    <p>NO RM: {{ $dataMedis->kd_pasien ?? 'N/A' }}</p>
                    <p>Nama: {{ $dataMedis->pasien->nama_pasien ?? 'N/A' }}</p>
                    <p>Jenis Kelamin: {{ ($dataMedis->pasien->jk ?? '') == 'L' ? 'Laki-laki' : (($dataMedis->pasien->jk ?? '') == 'P' ? 'Perempuan' : 'N/A') }}</p>
                    <p>Tanggal Lahir: {{ $dataMedis->pasien->tgl_lahir ? Carbon\Carbon::parse($dataMedis->pasien->tgl_lahir)->format('d-m-Y') : 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>
    <hr style="border: 0.5px solid #000; margin-top: 5px; margin-bottom: 10px;">

    <div class="section">
        <h6 style="font-size: 11pt; font-weight: bold; color: #2c3e50; margin-bottom: 8px;">Kriteria Masuk PICU</h6>
        @if ($dataPICU)
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
                    <td><div class="main-criteria">Gawat Nafas/ gagal nafas.</div></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataPICU->kriteria_1_main ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataPICU->keterangan_1_main ?: '' }}</td>
                </tr>
                <tr>
                    <td class="no"></td>
                    <td><div class="sub-criteria-text">• RR: ≥ 60 x/i</div></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataPICU->kriteria_1_rr ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataPICU->keterangan_1_rr ?: '' }}</td>
                </tr>
                <tr>
                    <td class="no"></td>
                    <td><div class="sub-criteria-text">• Sianosis</div></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataPICU->kriteria_1_sianosis ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataPICU->keterangan_1_sianosis ?: '' }}</td>
                </tr>
                <tr>
                    <td class="no"></td>
                    <td><div class="sub-criteria-text">• Retraksi IGA</div></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataPICU->kriteria_1_retraksi ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataPICU->keterangan_1_retraksi ?: '' }}</td>
                </tr>
                <tr>
                    <td class="no"></td>
                    <td><div class="sub-criteria-text">• Merintih</div></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataPICU->kriteria_1_merintih ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataPICU->keterangan_1_merintih ?: '' }}</td>
                </tr>
                <tr>
                    <td class="no"></td>
                    <td><div class="sub-criteria-text">• Nafas cuping hidung.</div></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataPICU->kriteria_1_nafas_cuping ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataPICU->keterangan_1_nafas_cuping ?: '' }}</td>
                </tr>
                <tr>
                    <td class="no">2.</td>
                    <td><div class="main-criteria">Syok / kegagalan sirkulasi</div></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataPICU->kriteria_2_main ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataPICU->keterangan_2_main ?: '' }}</td>
                </tr>
                <tr>
                    <td class="no"></td>
                    <td><div class="sub-criteria-text">• Tekanan Darah tidak terukur</div></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataPICU->kriteria_2_tekanan_darah ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataPICU->keterangan_2_tekanan_darah ?: '' }}</td>
                </tr>
                <tr>
                    <td class="no"></td>
                    <td><div class="sub-criteria-text">• Nadi Cepat dan lemah</div></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataPICU->kriteria_2_nadi ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataPICU->keterangan_2_nadi ?: '' }}</td>
                </tr>
                <tr>
                    <td class="no"></td>
                    <td><div class="sub-criteria-text">• HR takikardia (>140)</div></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataPICU->kriteria_2_hr ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataPICU->keterangan_2_hr ?: '' }}</td>
                </tr>
                <tr>
                    <td class="no"></td>
                    <td><div class="sub-criteria-text">• Tekanan Nadi : ≥ 20mmHg</div></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataPICU->kriteria_2_tekanan_nadi ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataPICU->keterangan_2_tekanan_nadi ?: '' }}</td>
                </tr>
                <tr>
                    <td class="no"></td>
                    <td><div class="sub-criteria-text">• RR: Takipnue ≥ 60x/m</div></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataPICU->kriteria_2_rr ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataPICU->kriteria_2_rr ?: '' }}</td>
                </tr>
                <tr>
                    <td class="no"></td>
                    <td><div class="sub-criteria-text">• Akral dingin</div></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataPICU->kriteria_2_akral ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataPICU->kriteria_2_akral ?: '' }}</td>
                </tr>
                <tr>
                    <td class="no">3.</td>
                    <td><strong>Kejang berulang disertai penurunan kesadaran</strong></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataPICU->kriteria_3 ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataPICU->keterangan_3 ?: '' }}</td>
                </tr>
                <tr>
                    <td class="no">4.</td>
                    <td><strong>Sepsis (kesadaran menurun, nadi<60)</strong></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataPICU->kriteria_4 ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataPICU->keterangan_4 ?: '' }}</td>
                </tr>
                <tr>
                    <td class="no">5.</td>
                    <td><strong>Tetanus Anak</strong></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataPICU->kriteria_5 ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataPICU->keterangan_5 ?: '' }}</td>
                </tr>
                <tr>
                    <td class="no">6.</td>
                    <td><div class="main-criteria">Dehidrasi Berat</div></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataPICU->kriteria_6_main ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataPICU->keterangan_6_main ?: '' }}</td>
                </tr>
                <tr>
                    <td class="no"></td>
                    <td><div class="sub-criteria-text">• Penurunan kesadaran</div></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataPICU->kriteria_6_penurunan_kesadaran ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataPICU->keterangan_6_penurunan_kesadaran ?: '' }}</td>
                </tr>
                <tr>
                    <td class="no"></td>
                    <td><div class="sub-criteria-text">• Takikardia</div></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataPICU->kriteria_6_takikardia ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataPICU->kriteria_6_takikardia ?: '' }}</td>
                </tr>
                <tr>
                    <td class="no"></td>
                    <td><div class="sub-criteria-text">• Mata cekung</div></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataPICU->kriteria_6_mata ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataPICU->kriteria_6_mata ?: '' }}</td>
                </tr>
                <tr>
                    <td class="no"></td>
                    <td><div class="sub-criteria-text">• Letargi</div></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataPICU->kriteria_6_letargi ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataPICU->kriteria_6_letargi ?: '' }}</td>
                </tr>
                <tr>
                    <td class="no"></td>
                    <td><div class="sub-criteria-text">• Anuria</div></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataPICU->kriteria_6_anuria ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataPICU->kriteria_6_anuria ?: '' }}</td>
                </tr>
                <tr>
                    <td class="no"></td>
                    <td><div class="sub-criteria-text">• Malas minum</div></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataPICU->kriteria_6_malas_minum ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataPICU->kriteria_6_malas_minum ?: '' }}</td>
                </tr>
                <tr>
                    <td class="no">7.</td>
                    <td><strong>Hipertensi krisis pada anak (>180/120mmHg)</strong></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataPICU->kriteria_7 ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataPICU->keterangan_7 ?: '' }}</td>
                </tr>
                <tr>
                    <td class="no">8.</td>
                    <td><strong>Kegagalan organ</strong></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataPICU->kriteria_8 ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataPICU->keterangan_8 ?: '' }}</td>
                </tr>
                @if(property_exists($dataPICU, 'kriteria_9') && $dataPICU->kriteria_9 !== null && $dataPICU->kriteria_9_main === null)
                <tr>
                    <td class="no">9.</td>
                    <td><div class="main-criteria">Pasien anak pasca bedah (Umum)</div></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataPICU->kriteria_9 ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataPICU->keterangan_9 ?: '' }}</td>
                </tr>
                @endif
                <tr>
                    <td class="no">{{ (property_exists($dataPICU, 'kriteria_9') && $dataPICU->kriteria_9 !== null && $dataPICU->kriteria_9_main === null) ? '' : '9.' }}</td>
                    <td><div class="main-criteria">Pasien anak pasca bedah (Spesifik)</div></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataPICU->kriteria_9_main ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataPICU->keterangan_9_main ?: '' }}</td>
                </tr>
                <tr>
                    <td class="no"></td>
                    <td><div class="sub-criteria-text">• Traumatologi pada anak</div></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataPICU->kriteria_9_traumatologi ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataPICU->keterangan_9_traumatologi ?: '' }}</td>
                </tr>
            </tbody>
        </table>
        @else
        <p>Data Kriteria Masuk PICU tidak tersedia.</p>
        @endif
    </div>

    <div class="section" style="margin-top: 30px;">
        <h6 style="font-size: 11pt; font-weight: bold; color: #2c3e50; margin-bottom: 8px;">Kriteria Keluar PICU</h6>
        @if ($dataKeluarPICU)
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
                < graduate assistantship, tr>
                    <td class="no">1.</td>
                    <td><strong>Parameter hemodinamik stabil</strong></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataKeluarPICU->kriteria_keluar_1 ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataKeluarPICU->keterangan_keluar_1 ?: '' }}</td>
                </tr>
                <tr>
                    <td class="no">2.</td>
                    <td><strong>Status respirasi stabil (tanpa ETT, jalan nafas bebas, gas darah normal)</strong></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataKeluarPICU->kriteria_keluar_2 ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataKeluarPICU->keterangan_keluar_2 ?: '' }}</td>
                </tr>
                <tr>
                    <td class="no">3.</td>
                    <td><strong>Kebutuhan suplementasi oksigen minimal (tidak melebihi standar yang dapat dilakukan di luar ruang intensive pediatrik)</strong></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataKeluarPICU->kriteria_keluar_3 ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataKeluarPICU->keterangan_keluar_3 ?: '' }}</td>
                </tr>
                <tr>
                    <td class="no">4.</td>
                    <td><strong>Disritmia jantung terkontrol</strong></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataKeluarPICU->kriteria_keluar_4 ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataKeluarPICU->keterangan_keluar_4 ?: '' }}</td>
                </tr>
                <tr>
                    <td class="no">5.</td>
                    <td><strong>Alat pemantauan tekanan intrakranial intensive tidak terpasang lagi</strong></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataKeluarPICU->kriteria_keluar_5 ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataKeluarPICU->kriteria_keluar_5 ?: '' }}</td>
                </tr>
                <tr>
                    <td class="no">6.</td>
                    <td><strong>Neurologi stabil kejang terkontrol</strong></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataKeluarPICU->kriteria_keluar_6 ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataKeluarPICU->kriteria_keluar_6 ?: '' }}</td>
                </tr>
                <tr>
                    <td class="no">7.</td>
                    <td><strong>Kateter pemantau hemodinamik telah dilepas</strong></td>
                    <td class="checkbox-col"><input type="checkbox" {{ ($dataKeluarPICU->kriteria_keluar_7 ?? false) ? 'checked' : '' }} disabled></td>
                    <td class="keterangan-col">{{ $dataKeluarPICU->keterangan_keluar_7 ?: '' }}</td>
                </tr>
            </tbody>
        </table>
        @else
        <p>Data Kriteria Keluar PICU tidak tersedia.</p>
        @endif
    </div>

    <div class="signature">
        <div>
            <p>Dokter yang menilai</p>
            <div class="underline"></div>
            <p>{{ $dataPICU && $dataPICU->dokter ? $dataPICU->dokter->nama : '.............................' }}</p>
        </div>
    </div>
</body>
</html>