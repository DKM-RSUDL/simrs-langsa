<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Early Warning System (EWS) Pasien Anak</title>
    <style>
        @page {
            margin: 0.5cm;
            size: A4 portrait; /* Sesuai controller: landscape */
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
            table-layout: fixed; /* Memastikan kolom proporsional */
        }

        table.ews-table th, table.ews-table td {
            border: 1px solid #000;
            padding: 2px;
            text-align: center;
            height: 14px;
            word-wrap: break-word; /* Memastikan teks panjang terputus */
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
            width: 150px; /* Diperlebar untuk penilaian panjang */
            text-align: left !important;
            padding-left: 4px !important;
        }

        .skor-col {
            width: 20px;
        }

        .record-col {
            width: 40px; /* Lebar kolom record */
            min-width: 40px; /* Pastikan kolom tidak menyusut terlalu kecil */
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
                    <span class="patient-value">{{ $dataMedis->pasien->jenis_kelamin == 1 ? 'Laki-laki' : ($dataMedis->pasien->jenis_kelamin == 0 ? 'Perempuan' : '-') }}</span>
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
            <p style="text-align: center; font-size: 8pt;">Tidak ada data EWS yang tersedia untuk tanggal {{ \Carbon\Carbon::parse($recordDate)->format('d/m/Y') }}.</p>
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
                            <td class="record-col {{ $record->keadaan_umum == 0 ? 'cell-green' : '' }}">{{ $record->keadaan_umum == 0 ? '0' : '' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="nilai-col">Somnolen</td>
                        <td class="skor-col cell-yellow">1</td>
                        @foreach($ewsRecords as $record)
                            <td class="record-col {{ $record->keadaan_umum == 1 ? 'cell-yellow' : '' }}">{{ $record->keadaan_umum == 1 ? '1' : '' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="nilai-col">Iritabel, tidak dapat ditenangkan</td>
                        <td class="skor-col cell-yellow">2</td>
                        @foreach($ewsRecords as $record)
                            <td class="record-col {{ $record->keadaan_umum == 2 ? 'cell-yellow' : '' }}">{{ $record->keadaan_umum == 2 ? '2' : '' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="nilai-col">Letargi, gelisah, penurunan respon terhadap nyeri</td>
                        <td class="skor-col cell-red">3</td>
                        @foreach($ewsRecords as $record)
                            <td class="record-col {{ $record->keadaan_umum == 3 ? 'cell-red' : '' }}">{{ $record->keadaan_umum == 3 ? '3' : '' }}</td>
                        @endforeach
                    </tr>

                    <!-- KARDIOVASKULAR -->
                    <tr>
                        <td rowspan="4" class="parameter-col">KARDIOVASKULAR</td>
                        <td class="nilai-col">Tidak sianosis ATAU pengisian kapiler < 2 detik</td>
                        <td class="skor-col cell-green">0</td>
                        @foreach($ewsRecords as $record)
                            <td class="record-col {{ $record->kardiovaskular == 0 ? 'cell-green' : '' }}">{{ $record->kardiovaskular == 0 ? '0' : '' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="nilai-col">Tampak pucat ATAU pengisian kapiler 2 detik</td>
                        <td class="skor-col cell-yellow">1</td>
                        @foreach($ewsRecords as $record)
                            <td class="record-col {{ $record->kardiovaskular == 1 ? 'cell-yellow' : '' }}">{{ $record->kardiovaskular == 1 ? '1' : '' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="nilai-col">Tampak sianotik ATAU pengisian kapiler >2 detik ATAU Takikardi >20 × di atas parameter HR sesuai usia/menit</td>
                        <td class="skor-col cell-yellow">2</td>
                        @foreach($ewsRecords as $record)
                            <td class="record-col {{ $record->kardiovaskular == 2 ? 'cell-yellow' : '' }}">{{ $record->kardiovaskular == 2 ? '2' : '' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="nilai-col">Sianotik dan motlet, ATAU pengisian kapiler >5 detik, ATAU Takikardi >30x di atas parameter HR sesuai usia/menit ATAU Bradikardia sesuai usia</td>
                        <td class="skor-col cell-red">3</td>
                        @foreach($ewsRecords as $record)
                            <td class="record-col {{ $record->kardiovaskular == 3 ? 'cell-red' : '' }}">{{ $record->kardiovaskular == 3 ? '3' : '' }}</td>
                        @endforeach
                    </tr>

                    <!-- RESPIRASI -->
                    <tr>
                        <td rowspan="4" class="parameter-col">RESPIRASI</td>
                        <td class="nilai-col">Respirasi dalam parameter normal, tidak terdapat retraksi</td>
                        <td class="skor-col cell-green">0</td>
                        @foreach($ewsRecords as $record)
                            <td class="record-col {{ $record->respirasi == 0 ? 'cell-green' : '' }}">{{ $record->respirasi == 0 ? '0' : '' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="nilai-col">Takipnea >10x di atas parameter RR sesuai usia/menit, ATAU Menggunakan otot alat bantu napas, ATAU menggunakan FiO2 lebih dari 30%</td>
                        <td class="skor-col cell-yellow">1</td>
                        @foreach($ewsRecords as $record)
                            <td class="record-col {{ $record->respirasi == 1 ? 'cell-yellow' : '' }}">{{ $record->respirasi == 1 ? '1' : '' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="nilai-col">Takipnea >20x di atas parameter RR sesuai usia/menit, ATAU Ada retraksi, ATAU menggunakan FiO2 lebih dari 40%</td>
                        <td class="skor-col cell-yellow">2</td>
                        @foreach($ewsRecords as $record)
                            <td class="record-col {{ $record->respirasi == 2 ? 'cell-yellow' : '' }}">{{ $record->respirasi == 2 ? '2' : '' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="nilai-col">Laju respirasi >30x di atas parameter normal ATAU Bradipneu di mana frekuensi nafas lebih rendah 5 atau lebih, sesuai usia, disertai dengan retraksi berat ATAU menggunakan FiO2 lebih dari 50% (NRM 8 liter/menit)</td>
                        <td class="skor-col cell-red">3</td>
                        @foreach($ewsRecords as $record)
                            <td class="record-col {{ $record->respirasi == 3 ? 'cell-red' : '' }}">{{ $record->respirasi == 3 ? '3' : '' }}</td>
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

            <div class="hasil-ews">HASIL EARLY WARNING SCORING:</div>
            <table class="hasil-ews-table">
                <tr>
                    <td class="hasil-low">Skor 0-2: PASIEN STABIL</td>
                    <td class="hasil-medium">Skor 3-4 atau Skor 3 pada Satu Parameter: PENURUNAN KONDISI</td>
                    <td class="hasil-high">Skor ≥ 5: PERUBAHAN SIGNIFIKAN</td>
                </tr>
            </table>

            <div class="notes-section">
                <p><strong>Skor 0-4:</strong> Pasien dalam keadaan stabil, lakukan evaluasi sesuai rutin tiap 8 jam, jika skor meningkat lakukan evaluasi lebih sering.</p>
                <p><strong>Skor 5:</strong> Ada penurunan yang signifikan, lakukan evaluasi, monitoring secara kontinyu, lakukan evaluasi ulang 10 menit, informasikan ke dokter ICU/DPICU blue code jika penurunan respon Ti-Med Emergency (TME), maksimal 1 jam.</p>
                <p><strong>INFORMASI TAMBAHAN:</strong></p>
            </div>
        @endif

        <div class="footer">
            <p>Nama dan Paraf:</p>
            <p style="margin-top: 30px;">{{ str()->title($eWSPasienAnak->userCreate->name ?? '-') }}</p>
            <p class="small-text">Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}</p>
        </div>
    </div>
</body>
</html>