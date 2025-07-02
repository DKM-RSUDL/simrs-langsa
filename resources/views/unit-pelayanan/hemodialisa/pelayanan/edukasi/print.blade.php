<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Edukasi Pasien dan Keluarga Pasien HD</title>
    <style>
        @page {
            margin: 0.8cm;
            size: A4 portrait;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 9pt;
            line-height: 1.2;
        }

        .container {
            width: 100%;
            position: relative;
        }

        header {
            width: 100%;
            display: table;
            padding-bottom: 30px;
            border-bottom: 2px solid black;
            font-size: 13px;
        }

        header .left-column {
            display: table-cell;
            width: 20%;
            vertical-align: top;
            text-align: center;
        }

        header .left-column p {
            margin: 5px;
        }

        header .center-column {
            display: table-cell;
            width: auto;
            vertical-align: middle;
            text-align: center;
            margin: 0 10px;
        }

        header .center-column p {
            font-size: 16px;
            font-weight: 700;
        }

        header .right-column {
            display: table-cell;
            width: 40%;
            vertical-align: top;
            text-align: right;
        }

        header .header-logo {
            width: 80px;
        }

        header .title {
            font-size: 24px;
            font-weight: bold;
        }

        header .info-table {
            width: 100%;
            border: 1px solid black;
            border-collapse: collapse;
        }

        header .info-table td {
            padding: 8px;
            border: 1px solid black;
        }

        .logo-section {
            display: table-cell;
            width: fit-content;
            vertical-align: top;
        }

        .logo {
            width: 50px;
            height: 50px;
            margin-right: 10px;
        }

        .hospital-info {
            display: table-cell;
            width: fit-content;
            font-size: 9pt;
        }

        .hospital-name {
            font-size: 12pt;
            font-weight: bold;
            margin: 0;
        }

        .hospital-address {
            margin: 1px 0;
        }

        .patient-section {
            display: table-cell;
            width: fit-content;
            vertical-align: top;
        }

        .patient-info {
            border: 2px solid #000;
            padding: 8px;
            font-size: 9pt;
            margin-left: 20px;
        }

        .patient-row {
            display: flex;
            margin-bottom: 3px;
        }

        .patient-label {
            width: 80px;
            font-weight: normal;
        }

        .patient-value {
            flex: 1;
            border-bottom: 1px solid #000;
            min-height: 15px;
            padding-left: 5px;
        }

        .title-section {
            text-align: center;
            margin: 15px 0;
        }

        .title-main {
            font-size: 14pt;
            font-weight: bold;
            margin: 5px 0;
        }

        .title-sub {
            font-size: 8pt;
            margin: 5px 0;
        }

        .instruction {
            font-size: 9pt;
            margin: 10px 0;
        }

        .section-header {
            font-size: 10pt;
            font-weight: bold;
            background-color: #f0f0f0;
            padding: 3px 5px;
            border: 1px solid #000;
            margin: 10px 0 5px 0;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8pt;
            margin-bottom: 10px;
        }

        .data-table td {
            border: 1px solid #000;
            padding: 3px 5px;
            vertical-align: top;
        }

        .label-col {
            width: 120px;
            font-weight: bold;
            background-color: #f8f8f8;
        }

        .colon-col {
            width: 10px;
            text-align: center;
        }

        .data-table .checkbox {
            margin-right: 10px;
        }

        .checkbox-row {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            margin-right: 10px;
        }

        .checkbox {
            width: 10px;
            height: 10px;
            border: 1px solid #000;
            margin-right: 4px;
            display: inline-block;
            text-align: center;
            line-height: 8px;
            font-size: 7pt;
            vertical-align: middle;
        }

        .checkbox.checked::before {
            content: "✓";
        }

        .input-field {
            border-bottom: 1px solid #000;
            display: inline-block;
            min-width: 80px;
            margin-left: 5px;
            padding: 0 3px;
        }

        .kebutuhan-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8pt;
        }

        .kebutuhan-table td {
            border: 1px solid #000;
            padding: 3px 5px;
            vertical-align: top;
        }

        .kebutuhan-left {
            width: 50%;
        }

        .kebutuhan-right {
            width: 50%;
        }

        .kebutuhan-item {
            display: flex;
            align-items: flex-start;
            margin: 2px 0;
        }

        .kebutuhan-item .checkbox {
            margin-top: 2px;
            margin-right: 5px;
        }

        .page-break {
            page-break-before: always;
        }

        .edukasi-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 7pt;
            margin-top: 10px;
            table-layout: fixed;
        }

        .edukasi-table th,
        .edukasi-table td {
            border: 1px solid #000;
            padding: 2px;
            text-align: center;
            vertical-align: middle;
            word-wrap: break-word;
        }

        .edukasi-table th {
            background-color: #f0f0f0;
            font-weight: bold;
            font-size: 7pt;
        }

        .tgl-jam-header {
            width: 80px;
            font-size: 7pt;
        }

        .topik-header {
            width: 160px;
            text-align: center;
            padding: 3px !important;
            font-size: 7pt;
        }

        .hasil-header {
            width: 85px;
            font-size: 7pt;
        }

        .reedukasi-header {
            width: 65px;
            font-size: 7pt;
        }

        .edukator-header {
            width: 70px;
            font-size: 7pt;
        }

        .ttd-header {
            width: 35px;
            font-size: 7pt;
        }

        .nama-header {
            width: 60px;
            font-size: 7pt;
        }

        .topik-cell {
            text-align: left;
            padding-left: 5px !important;
            font-size: 6pt;
            line-height: 1.1;
        }

        .tgl-cell {
            font-size: 6pt;
        }

        .hasil-cell {
            font-size: 6pt;
            line-height: 1.1;
            padding: 2px !important;
            text-align: left !important;
        }

        .hasil-cell .checkbox {
            width: 9px;
            height: 9px;
            font-size: 6pt;
            margin-right: 3px;
            vertical-align: top;
        }

        .hasil-option {
            display: block;
            margin-bottom: 1px;
            white-space: nowrap;
        }

        .reedukasi-cell {
            font-size: 6pt;
        }

        .edukator-cell {
            font-size: 6pt;
        }

        .nama-cell {
            font-size: 6pt;
        }

        .ttd-cell {
            width: 40px;
        }

        .no-formulir {
            text-align: right;
            font-size: 8pt;
            margin-top: 10px;
            font-weight: bold;
        }

        .hambatan-detail {
            margin-left: 20px;
            margin-top: 5px;
        }

        .hambatan-detail .checkbox-row {
            gap: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        {{-- HEADER --}}
        <header>
        <div class="left-column">
            <img src="{{ public_path('assets/img/Logo-RSUD-Langsa-1.png') }}" class="header-logo" alt="Logo">
            <p>RSUD Langsa</p>
            <p>Jl. Jend. A. Yani No.1 Kota Langsa</p>
        </div>
        <div class="center-column">
            <p>FORMULIR EDUKASI PASIEN DAN KELUARGA PASIEN HD</p>
        </div>
        <div class="right-column">
            <table class="info-table">
                <tr>
                    <td><strong>No RM</strong></td>
                    <td>{{ $dataMedis->kd_pasien }}</td>
                </tr>
                <tr>
                    <td><strong>Nama</strong></td>
                    <td>{{ str()->title($dataMedis->pasien->nama) }}</td>
                </tr>
                <tr>
                    <td><strong>Jenis Kelamin</strong></td>
                    <td>
                        @php
                            $gender = '-';

                            if ($dataMedis->pasien->jenis_kelamin == 1) {
                                $gender = 'Laki-Laki';
                            }
                            if ($dataMedis->pasien->jenis_kelamin == 0) {
                                $gender = 'Perempuan';
                            }

                            echo $gender;
                        @endphp
                    </td>
                </tr>
                <tr>
                    <td><strong>Tanggal Lahir</strong></td>
                    <td>{{ date('d/m/Y', strtotime($dataMedis->pasien->tgl_lahir)) }}</td>
                </tr>
            </table>
        </div>
    </header>

        <div class="instruction">Berilah tanda cheks list (✓) pada kotak yang sesuai</div>

        {{-- DATA PASIEN --}}
        <div class="section-header">DATA PASIEN</div>

        <table class="data-table">
            <tr>
                <td class="label-col">Tinggal bersama</td>
                <td class="colon-col">:</td>
                <td>
                    <span class="checkbox {{ in_array('Anak', $formData['tinggal_bersama']) ? 'checked' : '' }}"></span> Anak
                    <span class="checkbox {{ in_array('Orang Tua', $formData['tinggal_bersama']) ? 'checked' : '' }}"></span> Orang Tua
                    <span class="checkbox {{ in_array('Sendiri', $formData['tinggal_bersama']) ? 'checked' : '' }}"></span> Sendiri
                </td>
            </tr>
            <tr>
                <td class="label-col">Kemampuan bahasa</td>
                <td class="colon-col">:</td>
                <td>
                    <span class="checkbox {{ in_array('Indonesia', $formData['kemampuan_bahasa']) ? 'checked' : '' }}"></span> Indonesia
                    <span class="checkbox {{ in_array('Daerah', $formData['kemampuan_bahasa']) ? 'checked' : '' }}"></span> Daerah:<span class="input-field">{{ $bahasaDetails['bahasa_daerah_detail'] }}</span>
                    <span class="checkbox {{ in_array('Asing', $formData['kemampuan_bahasa']) ? 'checked' : '' }}"></span> Asing:<span class="input-field">{{ $bahasaDetails['bahasa_asing_detail'] }}</span>
                </td>
            </tr>
            <tr>
                <td class="label-col">Perlu penerjemah</td>
                <td class="colon-col">:</td>
                <td>
                    <span class="checkbox {{ $formData['perlu_penerjemah'] == 0 ? 'checked' : '' }}"></span> Tidak
                    <span class="checkbox {{ $formData['perlu_penerjemah'] == 1 ? 'checked' : '' }}"></span> Ya
                </td>
            </tr>
            <tr>
                <td class="label-col">Baca tulis</td>
                <td class="colon-col">:</td>
                <td>
                    <span class="checkbox {{ $formData['baca_tulis'] == 1 ? 'checked' : '' }}"></span> Bisa
                    <span class="checkbox {{ $formData['baca_tulis'] == 0 ? 'checked' : '' }}"></span> Tidak
                </td>
            </tr>
            <tr>
                <td class="label-col">Cara edukasi</td>
                <td class="colon-col">:</td>
                <td>
                    <span class="checkbox {{ in_array('Lisan', $formData['cara_edukasi']) ? 'checked' : '' }}"></span> Lisan
                    <span class="checkbox {{ in_array('Tulisan', $formData['cara_edukasi']) ? 'checked' : '' }}"></span> Tulisan
                    <span class="checkbox {{ in_array('Brosur/leaflet', $formData['cara_edukasi']) ? 'checked' : '' }}"></span> Brosur/leaflet
                    <span class="checkbox {{ in_array('Audiovisual', $formData['cara_edukasi']) ? 'checked' : '' }}"></span> Audiovisual
                </td>
            </tr>
            <tr>
                <td class="label-col">Hambatan</td>
                <td class="colon-col">:</td>
                <td>
                    <span class="checkbox {{ $formData['hambatan_status'] == 1 ? 'checked' : '' }}"></span> Ada
                    <span class="checkbox {{ $formData['hambatan_status'] == 0 ? 'checked' : '' }}"></span> Tidak
                    @if($formData['hambatan_status'] == 1)
                    <br>
                    <div style="margin-top: 5px;">
                        <span class="checkbox {{ in_array('Gangguan pendengaran', $formData['hambatan']) ? 'checked' : '' }}"></span> Gangguan pendengaran
                        <span class="checkbox {{ in_array('Gangguan emosi', $formData['hambatan']) ? 'checked' : '' }}"></span> Gangguan emosi
                    </div>
                    <div style="margin-top: 2px;">
                        <span class="checkbox {{ in_array('Motivasi kurang/buruk', $formData['hambatan']) ? 'checked' : '' }}"></span> Motivasi kurang/buruk
                        <span class="checkbox {{ in_array('Memori hilang', $formData['hambatan']) ? 'checked' : '' }}"></span> Memori hilang
                    </div>
                    <div style="margin-top: 2px;">
                        <span class="checkbox {{ in_array('Secara fisiologis tidak mampu belajar', $formData['hambatan']) ? 'checked' : '' }}"></span> Secara fisiobilogis tidak mampu belajar
                        <span class="checkbox {{ in_array('Perokok aktif/pasif', $formData['hambatan']) ? 'checked' : '' }}"></span> Perokok aktif/pasif *)
                    </div>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="label-col">Ketersediaan menerima edukasi:</td>
                <td class="colon-col"></td>
                <td>
                    <span class="checkbox {{ $formData['ketersediaan_edukasi'] == 1 ? 'checked' : '' }}"></span> Ya
                    <span class="checkbox {{ $formData['ketersediaan_edukasi'] == 0 ? 'checked' : '' }}"></span> Tidak
                </td>
            </tr>
        </table>

        {{-- KEBUTUHAN EDUKASI --}}
        <div class="section-header">KEBUTUHAN EDUKASI</div>

        <table class="kebutuhan-table">
            <tr>
                <td class="kebutuhan-left">
                    @php
                        $kebutuhanOptions = [
                            'kebutuhan_hak_berpartisipasi_pada_proses_pelayanan' => 'Hak berpartisipasi pada proses pelayanan',
                            'kebutuhan_prosedur_pemeriksaan_penunjang' => 'Prosedur pemeriksaan penunjang',
                            'kebutuhan_kondisi_kesehatan_daignosis_dan_penatalaksanaannya' => 'Kondisi kesehatan, daignosis, dan penatalaksanaannya',
                            'kebutuhan_proses_pemberian_informed_concent' => 'Proses pemberian informed concent',
                            'kebutuhan_diet_dan_nutrisi' => 'Diet dan nutrisi',
                            'kebutuhan_pengguanaan_obat_secara_efektif_dan_aman_serta_efek_samping_serta_interaksinya' => 'Pengguanaan obat secara efektif dan aman serta efek samping serta interaksinya.',
                            'kebutuhan_penggunaan_alat_medis_yang_aman' => 'Penggunaan alat medis yang aman',
                            'kebutuhan_manajemen_nyeri' => 'Manajemen nyeri'
                        ];
                        $leftItems = array_slice($kebutuhanOptions, 0, 8, true);
                    @endphp
                    @foreach($leftItems as $key => $label)
                    <div class="kebutuhan-item">
                        <span class="checkbox {{ in_array($key, $formData['kebutuhan_edukasi']) ? 'checked' : '' }}"></span>
                        <span>{{ $label }}</span>
                    </div>
                    @endforeach
                </td>
                <td class="kebutuhan-right">
                    @php
                        $rightOptions = [
                            'kebutuhan_teknik_rehabilitasi' => 'Teknik rehabilitasi',
                            'kebutuhan_cuci_tangan_yang_benar' => 'Cuci tangan yang benar',
                            'kebutuhan_bahaya_merokok' => 'Bahaya merokok',
                            'kebutuhan_rujukan_edukasi' => 'Rujukan edukasi',
                            'kebutuhan_perawatan_av_shunt' => 'Perawatan AV-Shunt',
                            'kebutuhan_perawatan_cdl' => 'Perawatan CDL',
                            'kebutuhan_kepatuhan_minum_obat' => 'Kepatuhan minum obat',
                            'kebutuhan_perawatan_luka_akses_femoralis' => 'Perawatan luka akses femoralis.'
                        ];
                    @endphp
                    @foreach($rightOptions as $key => $label)
                    <div class="kebutuhan-item">
                        <span class="checkbox {{ in_array($key, $formData['kebutuhan_edukasi']) ? 'checked' : '' }}"></span>
                        <span>{{ $label }}</span>
                    </div>
                    @endforeach
                </td>
            </tr>
        </table>

        {{-- TABEL EDUKASI --}}
        <table class="edukasi-table">
            <thead>
                <tr>
                    <th rowspan="2" class="tgl-jam-header">TGL/JAM<br>EDUKASI</th>
                    <th rowspan="2" class="topik-header">KEBUTUHAN<br>EDUKASI</th>
                    <th rowspan="2" class="hasil-header">HASIL<br>VERIFIKASI</th>
                    <th rowspan="2" class="reedukasi-header">TGL Rencana<br>Reedukasi/<br>Redemonstrasi</th>
                    <th colspan="2" class="edukator-header">EDUKATOR</th>
                    <th colspan="2" class="nama-header">PASIEN/<br>KELUARGA</th>
                </tr>
                <tr>
                    <th class="edukator-header">Nama dan<br>profesi</th>
                    <th class="ttd-header">TTD</th>
                    <th class="nama-header">Nama</th>
                    <th class="ttd-header">TTD</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $halaman1Topics = array_slice($topikEdukasiList, 0, 5, true);
                @endphp
                @foreach($halaman1Topics as $key => $topik)
                @php
                    $data = isset($edukasiData[$key]) ? $edukasiData[$key] : null;
                @endphp
                <tr>
                    <td class="tgl-cell">{{ $data ? $data['tgl_jam'] : '' }}</td>
                    <td class="topik-cell">{{ $topik }}</td>
                    <td class="hasil-cell">
                        <div class="hasil-option">
                            <span class="checkbox {{ ($data && $data['hasil_verifikasi'] == 'Sudah mengerti') ? 'checked' : '' }}"></span> Sudah mengerti
                        </div>
                        <div class="hasil-option">
                            <span class="checkbox {{ ($data && $data['hasil_verifikasi'] == 'Re-demonstrasi') ? 'checked' : '' }}"></span> Re-demonstrasi
                        </div>
                        <div class="hasil-option">
                            <span class="checkbox {{ ($data && $data['hasil_verifikasi'] == 'Re-edukasi') ? 'checked' : '' }}"></span> Re-edukasi
                        </div>
                    </td>
                    <td class="reedukasi-cell">{{ $data ? $data['tgl_reedukasi'] : '' }}</td>
                    <td class="edukator-cell">{{ $data ? $data['edukator_nama'] : '' }}</td>
                    <td class="ttd-cell"></td>
                    <td class="nama-cell">{{ $data ? $data['pasien_nama'] : '' }}</td>
                    <td class="ttd-cell"></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- HALAMAN 2 - LANJUTAN TABEL --}}
        <div class="page-break"></div>

        {{-- Lanjutan tabel untuk halaman 2 --}}
        <table class="edukasi-table">
            <thead>
                <tr>
                    <th rowspan="2" class="tgl-jam-header">TGL/JAM<br>EDUKASI</th>
                    <th rowspan="2" class="topik-header">KEBUTUHAN<br>EDUKASI</th>
                    <th rowspan="2" class="hasil-header">HASIL<br>VERIFIKASI</th>
                    <th rowspan="2" class="reedukasi-header">TGL Rencana<br>Reedukasi/<br>Redemonstrasi</th>
                    <th colspan="2" class="edukator-header">EDUKATOR</th>
                    <th colspan="2" class="nama-header">PASIEN/<br>KELUARGA</th>
                </tr>
                <tr>
                    <th class="edukator-header">Nama dan<br>profesi</th>
                    <th class="ttd-header">TTD</th>
                    <th class="nama-header">Nama</th>
                    <th class="ttd-header">TTD</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $halaman2Topics = array_slice($topikEdukasiList, 5, 14, true);
                @endphp
                @foreach($halaman2Topics as $key => $topik)
                @php
                    $data = isset($edukasiData[$key]) ? $edukasiData[$key] : null;
                @endphp
                <tr>
                    <td class="tgl-cell">{{ $data ? $data['tgl_jam'] : '' }}</td>
                    <td class="topik-cell">{{ $topik }}</td>
                    <td class="hasil-cell">
                        <div class="hasil-option">
                            <span class="checkbox {{ ($data && $data['hasil_verifikasi'] == 'Sudah mengerti') ? 'checked' : '' }}"></span> Sudah mengerti
                        </div>
                        <div class="hasil-option">
                            <span class="checkbox {{ ($data && $data['hasil_verifikasi'] == 'Re-demonstrasi') ? 'checked' : '' }}"></span> Re-demonstrasi
                        </div>
                        <div class="hasil-option">
                            <span class="checkbox {{ ($data && $data['hasil_verifikasi'] == 'Re-edukasi') ? 'checked' : '' }}"></span> Re-edukasi
                        </div>
                    </td>
                    <td class="reedukasi-cell">{{ $data ? $data['tgl_reedukasi'] : '' }}</td>
                    <td class="edukator-cell">{{ $data ? $data['edukator_nama'] : '' }}</td>
                    <td class="ttd-cell"></td>
                    <td class="nama-cell">{{ $data ? $data['pasien_nama'] : '' }}</td>
                    <td class="ttd-cell"></td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</body>
</html>
