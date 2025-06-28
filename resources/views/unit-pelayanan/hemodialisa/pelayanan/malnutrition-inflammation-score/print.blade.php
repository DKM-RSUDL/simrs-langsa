<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Malnutrition Inflammation Score (MIS) Pasien Hemodialisa</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 10mm 10mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11pt;
            line-height: 1.2;
            margin: 0;
            padding: 0;
            color: #333;
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
            text-align: left;
        }

        .title-section {
            display: table-cell;
            vertical-align: middle;
            width: 45%;
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            color: #000000;
        }

        .patient-info-cell {
            display: table-cell;
            vertical-align: top;
            width: 30%;
            text-align: right;
        }

        .hospital-info .info-text {
            display: inline-block;
            vertical-align: middle;
            font-size: 9pt;
        }

        .hospital-info .info-text .title {
            font-size: 12pt;
            font-weight: bold;
            margin-bottom: 2px;
            color: #2c3e50;
        }

        .hospital-info .info-text p {
            margin: 1px 0;
            line-height: 1.1;
        }

        .patient-info-box {
            display: inline-block;
            text-align: left;
            border: 1px solid #000;
            padding: 6px;
            font-size: 8pt;
            width: 160px;
            box-sizing: border-box;
            background-color: #f8f9fa;
        }

        .patient-info-box p {
            margin: 2px 0;
            line-height: 1.3;
        }

        .form-info {
            margin: 10px 0;
            font-size: 8pt;
        }

        .form-info-table {
            width: 100%;
            border-collapse: collapse;
            border: 0.5px solid #000;
            background-color: #f8f9fa;
        }

        .form-info-table td {
            padding: 4px 6px;
            border: 0.5px solid #000;
            vertical-align: middle;
            line-height: 1;
        }

        .form-info-table .label {
            width: 120px;
            font-weight: bold;
            color: #000000;
            background-color: #ffffff;
            text-align: left;
        }

        .form-info-table .value {
            background-color: #ffffff;
            color: #000;
            font-weight: bold;
        }

        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
            font-size: 9pt;
            border: 2px solid #000;
        }

        .main-table th,
        .main-table td {
            border: 1px solid #000;
            padding: 4px;
            vertical-align: top;
        }

        .main-table th {
            background-color: #f5f5f5;
            color: #333;
            font-weight: bold;
            text-align: center;
            font-size: 10pt;
            padding: 6px 4px;
        }

        .section-header {
            background-color: #e9ecef;
            color: #333;
            font-weight: bold;
            text-align: left;
            font-size: 10pt;
            padding: 5px 6px;
        }

        .no-column {
            width: 5%;
            text-align: center;
            font-size: 9pt;
            font-weight: bold;
            background-color: #f8f9fa;
        }

        .component-column {
            width: 30%;
            font-size: 8pt;
            line-height: 1.2;
            padding: 6px;
            background-color: #f8f9fa;
        }

        .score-column {
            width: 65%;
            padding: 0;
        }

        .score-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
            padding: 0;
        }

        .score-table td {
            border: 1px solid #000;
            padding: 4px 2px;
            text-align: center;
            vertical-align: middle;
            font-size: 7pt;
            line-height: 1.1;
            width: 25%;
            height: 40px;
            position: relative;
        }

        .score-table td.selected {
            background-color: #cfcfcf;
            color: #333;
            font-weight: bold;
        }

        .score-table td .text {
            font-size: 7pt;
            line-height: 1.1;
            margin: 2px 0;
        }

        .score-table td .score-num {
            font-size: 7pt;
            margin-top: 1px;
            font-weight: bold;
        }

        .total-row {
            background-color: #f8f9fa;
            color: #333;
            font-weight: bold;
            border: 1px solid #000;
        }

        .total-row td {
            font-size: 10pt;
            padding: 6px;
        }

        .interpretation {
            margin-top: 12px;
            font-size: 10pt;
            border: 2px solid #000;
            padding: 10px;
            background-color: #f8f9fa;
        }

        .interpretation p:first-child {
            margin: 0;
            font-weight: bold;
            color: #2c3e50;
            font-size: 11pt;
        }

        .interpretation p:last-child {
            margin: 5px 0 0 0;
            font-size: 10pt;
            color: #2c3e50;
        }

        .signature-section {
            margin-top: 20px;
            text-align: right;
            font-size: 10pt;
        }

        .notes {
            margin-top: 12px;
            font-size: 8pt;
            line-height: 1.2;
            background-color: #f8f9fa;
            padding: 8px;
            border: 1px solid #000;
        }

        .notes p {
            margin: 3px 0;
        }

        .notes b {
            color: #2c3e50;
        }

        hr {
            border: 1px solid #000;
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <!-- HEADER SECTION -->
    <div class="header">
        <div class="header-row">
            <div class="hospital-info">
                <img src="{{ $logoPath }}" alt="Logo RSUD Langsa"
                    style="width: 50px; height: 50px; margin-right: 8px;">
                <div class="info-text">
                    <p class="title">RSUD LANGSA</p>
                    <p>Jl. Jend. A. Yani Kota Langsa</p>
                    <p>Telp. 0641 - 32051</p>
                    <p>rsudlangsa.aceh@gmail.com</p>
                </div>
            </div>
            <div class="title-section">
                Malnutrition Inflammation Score<br>
                Pasien Hemodialisa <br>
            </div>
            <div class="patient-info-cell">
                <div class="patient-info-box">
                    <p><b>NO RM: {{ $dataMedis->kd_pasien ?? 'N/A' }}</b></p>
                    <p><b>Nama:</b> {{ $dataMedis->pasien->nama ?? 'N/A' }}</p>
                    <p><b>Tanggal Lahir:</b>
                        {{ $dataMedis->pasien->tgl_lahir ? Carbon\Carbon::parse($dataMedis->pasien->tgl_lahir)->format('d-m-Y') : 'N/A' }}
                    </p>
                    <p><b>Umur:</b> {{ $dataMedis->pasien->umur ?? 'N/A' }} Tahun /
                        {{ ($dataMedis->pasien->jenis_kelamin ?? '') == '1' ? 'Laki-laki' : (($dataMedis->pasien->jenis_kelamin ?? '') == '0' ? 'Perempuan' : 'N/A') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    <hr>

    <!-- FORM INFO -->
    <div class="form-info">
        <table class="form-info-table">
            <tr>
                <td class="label">Tanggal:</td>
                <td class="value">{{ $skorMalnutrisi->tgl_rawat ? Carbon\Carbon::parse($skorMalnutrisi->tgl_rawat)->format('d/m/Y') : '___/___/20___' }}</td>
                <td class="label">Jam:</td>
                <td class="value">{{ Carbon\Carbon::parse($skorMalnutrisi->jam_rawat)->format('H:i') }} WIB</td>
            </tr>
            <tr>
                <td class="label">Diagnosis Medis:</td>
                <td colspan="3" class="value">{{ $skorMalnutrisi->diagnosis_medis ?? '________________________________' }}</td>
            </tr>
        </table>
    </div>

    <!-- MAIN TABLE -->
    <table class="main-table">
        <thead>
            <tr>
                <th class="no-column">NO</th>
                <th class="component-column">KOMPONEN MIS</th>
                <th class="score-column">SCORE</th>
            </tr>
        </thead>
        <tbody>
            <!-- SECTION A: RIWAYAT MEDIS -->
            <tr>
                <td colspan="3" class="section-header">A. RIWAYAT MEDIS</td>
            </tr>

            <!-- Item 1 -->
            <tr>
                <td class="no-column">1</td>
                <td class="component-column">
                    Perubahan berat badan kering di akhir dialysis (perubahan keseluruhan pada 3-6 bulan terakhir)
                </td>
                <td class="score-column">
                    <table class="score-table">
                        <tr>
                            <td class="{{ $skorMalnutrisi->perubahan_bb_kering == 0 ? 'selected' : '' }}">
                                <div class="text">
                                    < 0.5 kg</div>
                                        <div class="score-num">(0)</div>
                            </td>
                            <td class="{{ $skorMalnutrisi->perubahan_bb_kering == 1 ? 'selected' : '' }}">
                                <div class="text">0.5 - 1 kg</div>
                                <div class="score-num">(1)</div>
                            </td>
                            <td class="{{ $skorMalnutrisi->perubahan_bb_kering == 2 ? 'selected' : '' }}">
                                <div class="text">>1 kg tapi <5 %</div>
                                        <div class="score-num">(2)</div>
                            </td>
                            <td class="{{ $skorMalnutrisi->perubahan_bb_kering == 3 ? 'selected' : '' }}">
                                <div class="text">≥ 5 %</div>
                                <div class="score-num">(3)</div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- Item 2 -->
            <tr>
                <td class="no-column">2</td>
                <td class="component-column">Asupan Diet</td>
                <td class="score-column">
                    <table class="score-table">
                        <tr>
                            <td class="{{ $skorMalnutrisi->asupan_diet == 0 ? 'selected' : '' }}">
                                <div class="text">Nafsu makan baik dan tidak ada perubahan diet</div>
                                <div class="score-num">(0)</div>
                            </td>
                            <td class="{{ $skorMalnutrisi->asupan_diet == 1 ? 'selected' : '' }}">
                                <div class="text">Asupan diet padat suboptimal</div>
                                <div class="score-num">(1)</div>
                            </td>
                            <td class="{{ $skorMalnutrisi->asupan_diet == 2 ? 'selected' : '' }}">
                                <div class="text">Berkurangnya asupan makan padat dan cair</div>
                                <div class="score-num">(2)</div>
                            </td>
                            <td class="{{ $skorMalnutrisi->asupan_diet == 3 ? 'selected' : '' }}">
                                <div class="text">Starvasi krn diet cair min atau tidak ada</div>
                                <div class="score-num">(3)</div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- Item 3 -->
            <tr>
                <td class="no-column">3</td>
                <td class="component-column">Gejala gastrointestinal</td>
                <td class="score-column">
                    <table class="score-table">
                        <tr>
                            <td class="{{ $skorMalnutrisi->gejala_gastrointestinal == 0 ? 'selected' : '' }}">
                                <div class="text">Tidak ada gejala dengan nafsu makan baik</div>
                                <div class="score-num">(0)</div>
                            </td>
                            <td class="{{ $skorMalnutrisi->gejala_gastrointestinal == 1 ? 'selected' : '' }}">
                                <div class="text">Gejala ringan, mual, kehilangan nafsu makan atau diare ringan</div>
                                <div class="score-num">(1)</div>
                            </td>
                            <td class="{{ $skorMalnutrisi->gejala_gastrointestinal == 2 ? 'selected' : '' }}">
                                <div class="text">Kadang muntah atau gejala GI sedang</div>
                                <div class="score-num">(2)</div>
                            </td>
                            <td class="{{ $skorMalnutrisi->gejala_gastrointestinal == 3 ? 'selected' : '' }}">
                                <div class="text">Sering diare atau muntah atau anorexia berat</div>
                                <div class="score-num">(3)</div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- Item 4 -->
            <tr>
                <td class="no-column">4</td>
                <td class="component-column">Kapasitas fungsional (hubungan nutrisi dengan gangguan fungsional)</td>
                <td class="score-column">
                    <table class="score-table">
                        <tr>
                            <td class="{{ $skorMalnutrisi->kapasitas_fungsional == 0 ? 'selected' : '' }}">
                                <div class="text">Kapasitas fungsional normal, merasa sehat</div>
                                <div class="score-num">(0)</div>
                            </td>
                            <td class="{{ $skorMalnutrisi->kapasitas_fungsional == 1 ? 'selected' : '' }}">
                                <div class="text">Kadang sulit melakukan aktivitas dasar atau sering merasa lelah
                                </div>
                                <div class="score-num">(1)</div>
                            </td>
                            <td class="{{ $skorMalnutrisi->kapasitas_fungsional == 2 ? 'selected' : '' }}">
                                <div class="text">Sulit melakukan aktivitas mandiri</div>
                                <div class="score-num">(2)</div>
                            </td>
                            <td class="{{ $skorMalnutrisi->kapasitas_fungsional == 3 ? 'selected' : '' }}">
                                <div class="text">Terbaring di bed/kursi atau dengan aktivitas kecil sangat membatasi
                                </div>
                                <div class="score-num">(3)</div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- Item 5 -->
            <tr>
                <td class="no-column">5</td>
                <td class="component-column">Komorbiditas, termasuk lama menjalani (tahun) dialysis</td>
                <td class="score-column">
                    <table class="score-table">
                        <tr>
                            <td class="{{ $skorMalnutrisi->komorbiditas == 0 ? 'selected' : '' }}">
                                <div class="text">Komorbiditas minimal dialysis < 1 tahun terakhir</div>
                                        <div class="score-num">(0)</div>
                            </td>
                            <td class="{{ $skorMalnutrisi->komorbiditas == 1 ? 'selected' : '' }}">
                                <div class="text">Komorbiditas ringan, dalam dialysis 1-4 tahun termasuk MMC*</div>
                                <div class="score-num">(1)</div>
                            </td>
                            <td class="{{ $skorMalnutrisi->komorbiditas == 2 ? 'selected' : '' }}">
                                <div class="text">Komorbiditas sedang, dalam dialysis > 4 tahun (termasuk MMC*)</div>
                                <div class="score-num">(2)</div>
                            </td>
                            <td class="{{ $skorMalnutrisi->komorbiditas == 3 ? 'selected' : '' }}">
                                <div class="text">Setiap komorbiditas berat multiple (2 atau lebih MMC*)</div>
                                <div class="score-num">(3)</div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- SECTION B: PEMERIKSAAN FISIK -->
            <tr>
                <td colspan="3" class="section-header">B. PEMERIKSAAN FISIK</td>
            </tr>

            <!-- Item 6 -->
            <tr>
                <td class="no-column">6</td>
                <td class="component-column">Berkurangnya cadangan lemak atau kehilangan lemak subcutan (dibawah mata,
                    trisep, bisep, dada)</td>
                <td class="score-column">
                    <table class="score-table">
                        <tr>
                            <td class="{{ $skorMalnutrisi->berkurang_cadangan_lemak == 0 ? 'selected' : '' }}">
                                <div class="text">Tidak ada perubahan</div>
                                <div class="score-num">(0)</div>
                            </td>
                            <td class="{{ $skorMalnutrisi->berkurang_cadangan_lemak == 1 ? 'selected' : '' }}">
                                <div class="text">Ringan</div>
                                <div class="score-num">(1)</div>
                            </td>
                            <td class="{{ $skorMalnutrisi->berkurang_cadangan_lemak == 2 ? 'selected' : '' }}">
                                <div class="text">Sedang</div>
                                <div class="score-num">(2)</div>
                            </td>
                            <td class="{{ $skorMalnutrisi->berkurang_cadangan_lemak == 3 ? 'selected' : '' }}">
                                <div class="text">Berat</div>
                                <div class="score-num">(3)</div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- Item 7 -->
            <tr>
                <td class="no-column">7</td>
                <td class="component-column">Tanda kehilangan masa otot (kening, clavicula, skapula, costae, kuadricep,
                    lutut, interosseous)</td>
                <td class="score-column">
                    <table class="score-table">
                        <tr>
                            <td class="{{ $skorMalnutrisi->kehilangan_masa_oto == 0 ? 'selected' : '' }}">
                                <div class="text">Tidak ada perubahan</div>
                                <div class="score-num">(0)</div>
                            </td>
                            <td class="{{ $skorMalnutrisi->kehilangan_masa_oto == 1 ? 'selected' : '' }}">
                                <div class="text">Ringan</div>
                                <div class="score-num">(1)</div>
                            </td>
                            <td class="{{ $skorMalnutrisi->kehilangan_masa_oto == 2 ? 'selected' : '' }}">
                                <div class="text">Sedang</div>
                                <div class="score-num">(2)</div>
                            </td>
                            <td class="{{ $skorMalnutrisi->kehilangan_masa_oto == 3 ? 'selected' : '' }}">
                                <div class="text">Berat</div>
                                <div class="score-num">(3)</div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- SECTION C: UKURAN TUBUH -->
            <tr>
                <td colspan="3" class="section-header">C. UKURAN TUBUH</td>
            </tr>

            <!-- Item 8 -->
            <tr>
                <td class="no-column">8</td>
                <td class="component-column">
                    Indeks masa tubuh (kg/m²)<br>
                    <small><i>BB: {{ $skorMalnutrisi->berat_badan ?? 'N/A' }} kg, TB:
                            {{ $skorMalnutrisi->tinggi_badan ?? 'N/A' }} cm<br>
                            IMT: {{ $skorMalnutrisi->imt_result ?? 'N/A' }}</i></small>
                </td>
                <td class="score-column">
                    <table class="score-table">
                        <tr>
                            <td class="{{ $skorMalnutrisi->indeks_masa_tubuh == 0 ? 'selected' : '' }}">
                                <div class="text">≥ 20</div>
                                <div class="score-num">(0)</div>
                            </td>
                            <td class="{{ $skorMalnutrisi->indeks_masa_tubuh == 1 ? 'selected' : '' }}">
                                <div class="text">18 – 19.9</div>
                                <div class="score-num">(1)</div>
                            </td>
                            <td class="{{ $skorMalnutrisi->indeks_masa_tubuh == 2 ? 'selected' : '' }}">
                                <div class="text">16 – 17.99</div>
                                <div class="score-num">(2)</div>
                            </td>
                            <td class="{{ $skorMalnutrisi->indeks_masa_tubuh == 3 ? 'selected' : '' }}">
                                <div class="text">
                                    < 16</div>
                                        <div class="score-num">(3)</div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- SECTION D: PARAMETER LABORATORIUM -->
            <tr>
                <td colspan="3" class="section-header">D. PARAMETER LABORATORIUM</td>
            </tr>

            <!-- Item 9 -->
            <tr>
                <td class="no-column">9</td>
                <td class="component-column">Albumin serum (g/dl)</td>
                <td class="score-column">
                    <table class="score-table">
                        <tr>
                            <td class="{{ $skorMalnutrisi->albumin_serum == 0 ? 'selected' : '' }}">
                                <div class="text">≥ 4</div>
                                <div class="score-num">(0)</div>
                            </td>
                            <td class="{{ $skorMalnutrisi->albumin_serum == 1 ? 'selected' : '' }}">
                                <div class="text">3.5 – 3.9</div>
                                <div class="score-num">(1)</div>
                            </td>
                            <td class="{{ $skorMalnutrisi->albumin_serum == 2 ? 'selected' : '' }}">
                                <div class="text">3.0 – 3.4</div>
                                <div class="score-num">(2)</div>
                            </td>
                            <td class="{{ $skorMalnutrisi->albumin_serum == 3 ? 'selected' : '' }}">
                                <div class="text">
                                    < 3.0</div>
                                        <div class="score-num">(3)</div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- Item 10 -->
            <tr>
                <td class="no-column">10</td>
                <td class="component-column">TIBC (Total Iron Binding Capacity Serum) mg/dl **</td>
                <td class="score-column">
                    <table class="score-table">
                        <tr>
                            <td class="{{ $skorMalnutrisi->tibc == 0 ? 'selected' : '' }}">
                                <div class="text">≥ 250</div>
                                <div class="score-num">(0)</div>
                            </td>
                            <td class="{{ $skorMalnutrisi->tibc == 1 ? 'selected' : '' }}">
                                <div class="text">200 - 249</div>
                                <div class="score-num">(1)</div>
                            </td>
                            <td class="{{ $skorMalnutrisi->tibc == 2 ? 'selected' : '' }}">
                                <div class="text">150 - 199</div>
                                <div class="score-num">(2)</div>
                            </td>
                            <td class="{{ $skorMalnutrisi->tibc == 3 ? 'selected' : '' }}">
                                <div class="text">
                                    < 150</div>
                                        <div class="score-num">(3)</div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- TOTAL ROW -->
            <tr class="total-row">
                <td colspan="2" style="text-align: center;">TOTAL SKOR</td>
                <td style="text-align: center; font-size: 16pt; font-weight: bold;">
                    {{ $skorMalnutrisi->total_skor ?? 0 }}</td>
            </tr>
            <tr class="total-row">
                <td colspan="2" style="text-align: center;">INTERPRETASI HASIL</td>
                <td style="text-align: center; font-size: 12pt; font-weight: bold;">
                    {{ $skorMalnutrisi->interpretasi ?? 'Belum ada interpretasi' }}</td>
            </tr>
        </tbody>
    </table>

    <div class="notes">
        <p><b>Keterangan Pasien:</b></p>
        <p><b>Berat Badan : {{ $skorMalnutrisi->berat_badan ?? 'N/A' }} kg</b></p>
        <p><b>Tinggi Badan : {{ $skorMalnutrisi->tinggi_badan ?? 'N/A' }} cm</b></p>
        <p><b>IMT : {{ $skorMalnutrisi->imt_result ?? 'N/A' }}</b></p>
    </div>

    <!-- CATATAN -->
    <div class="notes">
        <p><b>Keterangan:</b></p>
        <p><b>*MMC (Mayor Comorbid Condition)</b> termasuk CHF kelas III atau IV, penyakit AIDS total (full blown), CAD
            berat, COPD berat yang memerlukan O2, metastasis solid organ, dan kemoterapia.</p>
        <p><b>**</b> Peningkatan serum transferrin yang diharapkan adalah: > 200(μ), 170-199 (1), 140-162 (2), dan < 140
                mg/dl (3).</p>
                <p><b>Interpretasi Skor:</b></p>
                <p>• Skor < 6: Normal - Tanpa malnutrisi</p>
                        <p>• Skor = 6: Borderline - Perlu evaluasi klinis lebih lanjut</p>
                        <p>• Skor > 6: Malnutrisi terdeteksi - Perlu intervensi</p>
    </div>

    <!-- SIGNATURE SECTION -->
    <div class="signature-section">
        <p style="margin: 20px 0 5px 0;"><b>Perawat yang mengkaji:</b></p>
        <br><br><br>
        <p style="margin: 0; border-bottom: 1px solid #000; width: 200px; display: inline-block;"></p>
        <p style="margin: 3px 0 0 0; font-size: 9pt; color: #666;">{{ $skorMalnutrisi->user_created ?? 'Perawat' }}
        </p>
    </div>

</body>

</html>
