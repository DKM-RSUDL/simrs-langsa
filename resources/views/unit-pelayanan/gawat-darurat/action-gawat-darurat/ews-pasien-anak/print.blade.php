<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Early Warning System (EWS) Pasien Anak</title>
    <style>
        @page {
            margin: 0.5cm;
            size: A4 portrait;
            /* Sesuai controller: landscape */
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 8pt;
            line-height: 1.2;
        }

        .container {
            width: 100%;
            position: relative;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 5px;
        }

        .logo-rs {
            display: flex;
            align-items: center;
        }

        .logo {
            width: 50px;
            height: 50px;
            margin-right: 8px;
        }

        .hospital-info {
            font-size: 9pt;
        }

        .hospital-name {
            font-size: 12pt;
            font-weight: bold;
            margin: 0;
        }

        .hospital-address {
            margin: 2px 0;
        }

        .patient-info {
            border: 1px solid #000;
            padding: 5px;
            width: 250px;
            font-size: 9pt;
            position: absolute;
            top: 0;
            right: 0;
        }

        .patient-row {
            display: flex;
            margin-bottom: 4px;
        }

        .patient-label {
            width: 80px;
            font-weight: normal;
        }

        .patient-value {
            flex: 1;
        }

        .border-line {
            border-bottom: 2px solid black;
            margin: 5px 0;
        }

        .title {
            text-align: center;
            font-size: 12pt;
            font-weight: bold;
            margin: 10px 0;
        }

        table.ews-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 6pt;
            table-layout: fixed;
            /* Memastikan kolom proporsional */
        }

        table.ews-table th,
        table.ews-table td {
            border: 1px solid #000;
            padding: 2px;
            text-align: center;
            height: 14px;
            word-wrap: break-word;
            /* Memastikan teks panjang terputus */
        }

        table.ews-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .parameter-col {
            width: 90px;
            text-align: left !important;
            padding-left: 4px !important;
            font-weight: bold;
            white-space: nowrap;
        }

        .nilai-col {
            width: 150px;
            /* Diperlebar untuk penilaian panjang */
            text-align: left !important;
            padding-left: 4px !important;
        }

        .skor-col {
            width: 20px;
        }

        .record-col {
            width: 40px;
            /* Lebar kolom record */
            min-width: 40px;
            /* Pastikan kolom tidak menyusut terlalu kecil */
        }

        .cell-green {
            background-color: #90EE90;
        }

        .cell-yellow {
            background-color: #FFFF00;
        }

        .cell-red {
            background-color: #FF6347;
        }

        .hasil-ews {
            margin-top: 8px;
            font-size: 7pt;
            font-weight: bold;
        }

        .hasil-ews-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        .hasil-ews-table td {
            padding: 4px;
            border: 1px solid #000;
            font-size: 6pt;
            text-align: center;
        }

        .hasil-low {
            background-color: #90EE90;
        }

        .hasil-medium {
            background-color: #FFFF00;
        }

        .hasil-high {
            background-color: #FF6347;
        }

        .notes-section {
            margin-top: 8px;
            font-size: 6pt;
        }

        .notes-section p {
            margin: 2px 0;
        }

        .footer {
            margin-top: 10px;
            font-size: 6pt;
            text-align: right;
        }

        .small-text {
            font-size: 5pt;
        }

        .page-break {
            page-break-before: always;
        }

        /* Print-specific styles */
        @media print {
            .page-break {
                page-break-before: always;
            }
        }

        /* Styles untuk halaman kedua - Protocol */
        .protocol-title {
            text-align: center;
            font-size: 12pt;
            font-weight: bold;
            margin: 20px 0;
        }

        .protocol-section {
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .protocol-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 7pt;
        }

        .protocol-table td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
            vertical-align: top;
        }

        .skor-0-2 {
            background-color: #28a745;
            color: white;
            font-weight: bold;
            text-align: center;
            width: 100px;
        }

        .skor-3-4 {
            background-color: #ffc107;
            color: #000;
            font-weight: bold;
            text-align: center;
            width: 100px;
        }

        .skor-5-plus {
            background-color: #dc3545;
            color: white;
            font-weight: bold;
            text-align: center;
            width: 100px;
        }

        .skor-henti {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            text-align: center;
            width: 100px;
        }

        .protocol-text {
            font-size: 7pt;
            line-height: 1.3;
        }

        .vital-signs-section {
            margin-top: 15px;
        }

        .vital-signs-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 7pt;
        }

        .vital-signs-table th,
        .vital-signs-table td {
            border: 1px solid #000;
            padding: 4px;
            text-align: center;
        }

        .vital-signs-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .kategori-header,
        .usia-header,
        .nadi-header,
        .nafas-header {
            font-weight: bold;
            text-align: center;
        }

        .kategori-cell {
            font-weight: bold;
            text-align: center;
            width: 80px;
        }

        .data-cell {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="logo-rs">
                <img src="{{ public_path('assets/img/Logo-RSUD-Langsa-1.png') }}" alt="Logo RSUD Langsa" class="logo">
                <div class="hospital-info">
                    <p class="hospital-name">RSUD LANGSA</p>
                    <p class="hospital-address">Jl. Jend. A. Yani, Kota Langsa</p>
                    <p class="hospital-address">Telp: 0641-22051</p>
                    <p class="hospital-address">Email: rsudlangsa.aceh@gmail.com</p>
                </div>
            </div>
            <div class="patient-info">
                <div class="patient-row">
                    <span class="patient-label">No RM:</span>
                    <span class="patient-value">{{ $dataMedis->pasien->kd_pasien ?? '-' }}</span>
                </div>
                <div class="patient-row">
                    <span class="patient-label">Nama:</span>
                    <span class="patient-value">{{ $dataMedis->pasien->nama ?? '-' }}</span>
                </div>
                <div class="patient-row">
                    <span class="patient-label">Jenis Kelamin:</span>
                    <span
                        class="patient-value">{{ $dataMedis->pasien->jenis_kelamin == 1 ? 'Laki-laki' : ($dataMedis->pasien->jenis_kelamin == 0 ? 'Perempuan' : '-') }}</span>
                </div>
                <div class="patient-row">
                    <span class="patient-label">Tanggal Lahir:</span>
                    <span class="patient-value">
                        {{ $dataMedis->pasien->umur ?? '-' }} Thn
                        ({{ $dataMedis->pasien->tgl_lahir ? \Carbon\Carbon::parse($dataMedis->pasien->tgl_lahir)->format('d/m/Y') : '-' }})
                    </span>
                </div>
            </div>
        </div>

        <div class="border-line"></div>

        <div class="title">
            EARLY WARNING SYSTEM (EWS)<br>PASIEN ANAK
        </div>

        @if($ewsRecords->isEmpty())
            <p style="text-align: center; font-size: 8pt;">Tidak ada data EWS yang tersedia untuk tanggal
                {{ \Carbon\Carbon::parse($recordDate)->format('d/m/Y') }}.</p>
        @else
            <table class="ews-table">
                <thead>
                    <tr>
                        <th rowspan="3" class="parameter-col">PARAMETER</th>
                        <th colspan="2" rowspan="2">Tanggal & Jam</th>
                        @foreach($ewsRecords as $record)
                            <th class="record-col">{{ \Carbon\Carbon::parse($record->tanggal)->format('d/m/Y') }}</th>
                        @endforeach
                    </tr>
                    <tr>
                        @foreach($ewsRecords as $record)
                            <th class="record-col">{{ \Carbon\Carbon::parse($record->jam_masuk)->format('H:i') }}</th>
                        @endforeach
                    </tr>
                    <tr>
                        <th class="nilai-col">Penilaian</th>
                        <th class="skor-col">Skor</th>
                        @foreach($ewsRecords as $record)
                            <th class="record-col"></th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <!-- KEADAAN UMUM -->
                    <tr>
                        <td rowspan="4" class="parameter-col">KEADAAN UMUM</td>
                        <td class="nilai-col">Interaksi biasa</td>
                        <td class="skor-col cell-green">0</td>
                        @foreach($ewsRecords as $record)
                            <td class="record-col {{ $record->keadaan_umum == 0 ? 'cell-green' : '' }}">
                                {{ $record->keadaan_umum == 0 ? '0' : '' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="nilai-col">Somnolen</td>
                        <td class="skor-col cell-yellow">1</td>
                        @foreach($ewsRecords as $record)
                            <td class="record-col {{ $record->keadaan_umum == 1 ? 'cell-yellow' : '' }}">
                                {{ $record->keadaan_umum == 1 ? '1' : '' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="nilai-col">Iritabel, tidak dapat ditenangkan</td>
                        <td class="skor-col cell-yellow">2</td>
                        @foreach($ewsRecords as $record)
                            <td class="record-col {{ $record->keadaan_umum == 2 ? 'cell-yellow' : '' }}">
                                {{ $record->keadaan_umum == 2 ? '2' : '' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="nilai-col">Letargi, gelisah, penurunan respon terhadap nyeri</td>
                        <td class="skor-col cell-red">3</td>
                        @foreach($ewsRecords as $record)
                            <td class="record-col {{ $record->keadaan_umum == 3 ? 'cell-red' : '' }}">
                                {{ $record->keadaan_umum == 3 ? '3' : '' }}</td>
                        @endforeach
                    </tr>

                    <!-- KARDIOVASKULAR -->
                    <tr>
                        <td rowspan="4" class="parameter-col">KARDIOVASKULAR</td>
                        <td class="nilai-col">Tidak sianosis ATAU pengisian kapiler < 2 detik</td>
                        <td class="skor-col cell-green">0</td>
                        @foreach($ewsRecords as $record)
                            <td class="record-col {{ $record->kardiovaskular == 0 ? 'cell-green' : '' }}">
                                {{ $record->kardiovaskular == 0 ? '0' : '' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="nilai-col">Tampak pucat ATAU pengisian kapiler 2 detik</td>
                        <td class="skor-col cell-yellow">1</td>
                        @foreach($ewsRecords as $record)
                            <td class="record-col {{ $record->kardiovaskular == 1 ? 'cell-yellow' : '' }}">
                                {{ $record->kardiovaskular == 1 ? '1' : '' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="nilai-col">Tampak sianotik ATAU pengisian kapiler >2 detik ATAU Takikardi >20 × di atas
                            parameter HR sesuai usia/menit</td>
                        <td class="skor-col cell-yellow">2</td>
                        @foreach($ewsRecords as $record)
                            <td class="record-col {{ $record->kardiovaskular == 2 ? 'cell-yellow' : '' }}">
                                {{ $record->kardiovaskular == 2 ? '2' : '' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="nilai-col">Sianotik dan motlet, ATAU pengisian kapiler >5 detik, ATAU Takikardi >30x di
                            atas parameter HR sesuai usia/menit ATAU Bradikardia sesuai usia</td>
                        <td class="skor-col cell-red">3</td>
                        @foreach($ewsRecords as $record)
                            <td class="record-col {{ $record->kardiovaskular == 3 ? 'cell-red' : '' }}">
                                {{ $record->kardiovaskular == 3 ? '3' : '' }}</td>
                        @endforeach
                    </tr>

                    <!-- RESPIRASI -->
                    <tr>
                        <td rowspan="4" class="parameter-col">RESPIRASI</td>
                        <td class="nilai-col">Respirasi dalam parameter normal, tidak terdapat retraksi</td>
                        <td class="skor-col cell-green">0</td>
                        @foreach($ewsRecords as $record)
                            <td class="record-col {{ $record->respirasi == 0 ? 'cell-green' : '' }}">
                                {{ $record->respirasi == 0 ? '0' : '' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="nilai-col">Takipnea >10x di atas parameter RR sesuai usia/menit, ATAU Menggunakan otot
                            alat bantu napas, ATAU menggunakan FiO2 lebih dari 30%</td>
                        <td class="skor-col cell-yellow">1</td>
                        @foreach($ewsRecords as $record)
                            <td class="record-col {{ $record->respirasi == 1 ? 'cell-yellow' : '' }}">
                                {{ $record->respirasi == 1 ? '1' : '' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="nilai-col">Takipnea >20x di atas parameter RR sesuai usia/menit, ATAU Ada retraksi, ATAU
                            menggunakan FiO2 lebih dari 40%</td>
                        <td class="skor-col cell-yellow">2</td>
                        @foreach($ewsRecords as $record)
                            <td class="record-col {{ $record->respirasi == 2 ? 'cell-yellow' : '' }}">
                                {{ $record->respirasi == 2 ? '2' : '' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="nilai-col">Laju respirasi >30x di atas parameter normal ATAU Bradipneu di mana frekuensi
                            nafas lebih rendah 5 atau lebih, sesuai usia, disertai dengan retraksi berat ATAU menggunakan
                            FiO2 lebih dari 50% (NRM 8 liter/menit)</td>
                        <td class="skor-col cell-red">3</td>
                        @foreach($ewsRecords as $record)
                            <td class="record-col {{ $record->respirasi == 3 ? 'cell-red' : '' }}">
                                {{ $record->respirasi == 3 ? '3' : '' }}</td>
                        @endforeach
                    </tr>

                    <!-- TOTAL SKOR -->
                    <tr>
                        <td colspan="2" style="text-align: center; font-weight: bold;">TOTAL SKOR</td>
                        <td class="skor-col"></td>
                        @foreach($ewsRecords as $record)
                            <td class="record-col" style="font-weight: bold;">{{ $record->total_skor ?? '-' }}</td>
                        @endforeach
                    </tr>
                </tbody>
            </table>

            @php
                // Ambil record terbaru untuk menentukan hasil EWS
                $latestRecord = $ewsRecords->last();
                $totalSkor = $latestRecord ? $latestRecord->total_skor : 0;

                // Tentukan kategori berdasarkan total skor
                $kategoriHasil = '';
                $classHasil = '';
                $keteranganDetail = '';

                if ($totalSkor >= 5) {
                    $kategoriHasil = 'Skor ≥ 5: PERUBAHAN SIGNIFIKAN';
                    $classHasil = 'hasil-high';
                    $keteranganDetail = 'Ada perubahan yang signifikan, lakukan resusitasi, monitoring secara kontinyu, aktivasi code blue kegawatan medis, respon Tim Medis Emergency (TME) segera, maksimal 10 menit, informasikan dan konsultasikan ke DPJP.';
                } elseif ($totalSkor >= 3) {
                    $kategoriHasil = 'Skor 3-4 atau Skor 3 pada Satu Parameter: PENURUNAN KONDISI';
                    $classHasil = 'hasil-medium';
                    $keteranganDetail = 'Ada peningkatan kondisi pasien, assessment oleh dokter jaga bangsal. Lakukan evaluasi ulang setiap 2 jam atau lebih cepat, konsultasi ke DPJP, lakukan terapi sesuai instruksi, jika diperlukan dipindahkan ke area dengan monitoring yang sesuai.';
                } else {
                    $kategoriHasil = 'Skor 0-2: PASIEN STABIL';
                    $classHasil = 'hasil-low';
                    $keteranganDetail = 'Pasien dalam keadaan stabil, jika skor 0 lakukan evaluasi secara rutin tiap 8 jam, jika skor naik 1 atau 2, lakukan evaluasi setiap 4 jam, jika diperlukan assessment oleh dokter jaga bangsal.';
                }

                // Cek apakah ada parameter dengan skor 3 (kondisi khusus)
                $hasParameterSkor3 = false;
                if ($latestRecord) {
                    if ($latestRecord->keadaan_umum == 3 || $latestRecord->kardiovaskular == 3 || $latestRecord->respirasi == 3) {
                        $hasParameterSkor3 = true;
                        if ($totalSkor < 5) {
                            $kategoriHasil = 'Skor 3-4 atau Skor 3 pada Satu Parameter: PENURUNAN KONDISI';
                            $classHasil = 'hasil-medium';
                            $keteranganDetail = 'Ada peningkatan kondisi pasien, assessment oleh dokter jaga bangsal. Lakukan evaluasi ulang setiap 2 jam atau lebih cepat, konsultasi ke DPJP, lakukan terapi sesuai instruksi, jika diperlukan dipindahkan ke area dengan monitoring yang sesuai.';
                        }
                    }
                }
            @endphp

            <div class="hasil-ews">HASIL EARLY WARNING SCORING:</div>
            <table class="hasil-ews-table">
                <tr>
                    <td class="{{ $classHasil }}">
                        <strong>Total Skor: {{ $totalSkor }}</strong> <br>
                        {{-- {{ $kategoriHasil }}<br> --}}
                        {{ $keteranganDetail }}
                    </td>
                </tr>
            </table>
        @endif

        <div class="footer">
            <p style="font-size: 12px;">Nama dan Paraf:</p>
            <p style="margin-top: 30px; font-size: 12px;">{{ str()->title($eWSPasienAnak->userCreate->name ?? '-') }}</p>
            <p class="small-text" style="font-size: 12px;">Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}</p>
        </div>

        <!-- Halaman Kedua: Protokol dan Tabel Vital Signs -->
        <div class="page-break"></div>

        <div class="protocol-title">PROTOKOL ASSESSMENT DAN INTERVENSI EWS ANAK</div>

        <!-- Tabel Kategori Skor -->
        <div class="protocol-section">
            <table class="protocol-table">
                <tbody>
                    <tr>
                        <td class="skor-0-2">Skor 0-2</td>
                        <td class="protocol-text">Pasien dalam keadaan stabil, jika skor 0 lakukan evaluasi secara rutin
                            tiap 8 jam, jika skor naik 1 atau 2, lakukan evaluasi setiap 4 jam, jika di perlukan
                            assessment oleh dokter jaga bangsal.</td>
                    </tr>
                    <tr>
                        <td class="skor-3-4">Skor 3-4</td>
                        <td class="protocol-text">Ada peningkatan kondisi pasien, assessment oleh dokter jaga bangsal.
                            Lakukan evaluasi ulang setiap 2 jam atau lebih cepat, konsultasi ke DPJP, lakukan terapi
                            sesuai instruksi, jika diperlukan dipindahkan ke area dengan monitoring yang sesuai.
                        </td>
                    </tr>
                    <tr>
                        <td class="skor-5-plus">Skor > 5</td>
                        <td class="protocol-text">Ada perubahan yang signifikan, lakukan resusitasi, monitoring secara
                            kontinyu, aktivasi code blue kegawatan medis, respon Tim Medis Emergency (TME) segera,
                            maksimal 10 menit, informasikan dan konsultasikan ke DPJP.</td>
                    </tr>
                    <tr>
                        <td class="skor-henti">HENTI NAFAS/JANTUNG</td>
                        <td class="protocol-text">Lakukan RJP oleh petugas/ tim primer, aktivasi code blue henti jantung
                            respon Tim Medis Emergency (TME), maksimal 5 menit, informasikan dan konsultasikan ke
                            DPJP.</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Tabel Data Vital Signs berdasarkan Usia -->
        <div class="vital-signs-section">
            <table class="vital-signs-table">
                <thead>
                    <tr>
                        <th class="kategori-header">Kategori</th>
                        <th class="usia-header">Usia</th>
                        <th class="nadi-header">Nadi saat istirahat (x/menit)</th>
                        <th class="nafas-header">Nafas saat istirahat (x/menit)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="kategori-cell">Neonatus</td>
                        <td class="data-cell">0-1 bln</td>
                        <td class="data-cell">100-180</td>
                        <td class="data-cell">40-60</td>
                    </tr>
                    <tr>
                        <td class="kategori-cell">Bayi</td>
                        <td class="data-cell">1-12 bln</td>
                        <td class="data-cell">100-180</td>
                        <td class="data-cell">35-40</td>
                    </tr>
                    <tr>
                        <td class="kategori-cell">Balita</td>
                        <td class="data-cell">13-36 bln</td>
                        <td class="data-cell">70-110</td>
                        <td class="data-cell">25-30</td>
                    </tr>
                    <tr>
                        <td class="kategori-cell">Pra Sekolah</td>
                        <td class="data-cell">4-6 Thn</td>
                        <td class="data-cell">70-110</td>
                        <td class="data-cell">21-23</td>
                    </tr>
                    <tr>
                        <td class="kategori-cell">Sekolah</td>
                        <td class="data-cell">7-12 Thn</td>
                        <td class="data-cell">70-110</td>
                        <td class="data-cell">19-21</td>
                    </tr>
                    <tr>
                        <td class="kategori-cell">Remaja</td>
                        <td class="data-cell">13-19 Thn</td>
                        <td class="data-cell">55-90</td>
                        <td class="data-cell">16-18</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</body>

</html>
